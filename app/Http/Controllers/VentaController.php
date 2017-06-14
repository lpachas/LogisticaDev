<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Producto;
use SISTEMA_LOGISTICA\Venta;
use SISTEMA_LOGISTICA\Detalle_Venta;
use SISTEMA_LOGISTICA\Tipo_Documento;
use SISTEMA_LOGISTICA\Http\Controllers\Controller;
use SISTEMA_LOGISTICA\Http\Requests\VentaFormRequest;
use DB;
use Carbon\Carbon;
use Input;
use PDF;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('ventas.venta.ventas');
    }

    public function get_venta_info(Request $request)
    {
        if($request->ajax())
        {
            $ventas=$this->listaventas($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('ventas.venta.listaventas',compact('ventas','search'))->render();
                return response($view);
            }else{
                $view=view('ventas.venta.listaventas',compact('ventas'))->render();
                return response($view);
            }
        }
    }

    public function listaventas($search)
    {
        return  $ventas=DB::table('t_doc_venta as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->select('v.ID_Doc_Venta','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','d.Serie','d.Numero','v.FechaVenta_Actual as Fecha')
            ->where('v.Numero','LIKE','%'.$search.'%')
            ->orwhere('v.Serie','LIKE','%'.$search.'%')
            ->orderBy('v.ID_Doc_Venta','DESC')
            ->paginate(15);
    }

    public function getventasinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $ventas=$this->listaventas($request['search']);
            return view('ventas.venta.listaventas',compact('ventas'))->render();
        }
    }

    public function create(){
        $cli = DB::table('t_cliente')->get();
        $doc = DB::table('t_tipo_documento')->get();
        $prod = DB::table('t_producto')->get();
        $marca = DB::table('t_marca')->get();
        $modelo = DB::table('t_modelo')->get();
        $categoria = DB::table('t_categoria')->get();
        return view('ventas.venta.create',["clientes"=>$cli,"documentos" => $doc,"productos"=>$prod,"marcas"=>$marca,"modelos"=>$modelo,"categorias"=>$categoria]);
    }

    public function ByProducto($id){
        /*$res = DB::select("call sp_GetProducto('.$id.')");*/
        $res = DB::table('t_producto as p')
                    ->join('t_marca as m','p.ID_Marca','=','m.ID_Marca')
                    ->join('t_modelo as mo','p.ID_Modelo','=','mo.ID_Modelo')
                    ->join('t_categoria as c','p.ID_Categoria','=','c.ID_Categoria')
                    ->select('p.ID_Producto','p.Nombre as Producto','p.Stock','p.PU_Ferreteria','m.ID_Marca','m.Nombre as Marca','mo.ID_Modelo','mo.Nombre as Modelo','c.ID_Categoria','c.Nombre as Categoria')
                    ->where('p.ID_Producto','=',$id)
                    ->get();
        if ($res){
            return response()->json(['success'=>'true','res'=>$res]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function getMarcas(){
        $marcas=DB::table('t_marca')->get();
        return response()->json([$marcas]);
    }

    public function store(VentaFormRequest $request){
        $venta = new Venta;
        $venta->ID_Cliente = $request->get('ID_Cliente');
        $venta->ID_Usuario = $request->get('ID_Usuario');
        $venta->ID_Tipo_Documento = $request->get('ID_Tipo_Documento');
        $venta->Serie = $request->get('Serie');
        $venta->Numero = $request->get('Numero');
        $venta->FechaVenta_Actual= $request->get('FechaVenta_Actual');
        $venta->ID_Forma_Pago=$request->get('ID_Forma_Pago');
        $venta->Estado='Venta';
        $venta->FechaVenta_Credito = $request->get('FechaVenta_Credito');
        $venta->Nro_Dias=$request->get('Nro_Dias');
        $venta->IGV = $request->get('IGV');
        $venta->Subtotal = $request->get('Subtotal');
        $venta->SubIGV = $request->get('SubIGV');
        $venta->Total = $request->get('Total');
        $venta->save();

        /*Cantidad de Productos Vendidos*/
        $cantidad = count($request->get('Detalles'));

        $contador = 0;
        while($contador < $cantidad) {
            $detalle = new Detalle_Venta();
            $detalle->ID_Doc_Venta = $venta->ID_Doc_Venta;
            $detalle->ID_Producto = $request->get('Detalles')[$contador]['ID_Producto'];
            $detalle->Cantidad = $request->get('Detalles')[$contador]['Cantidad'];
            $detalle->Precio = $request->get('Detalles')[$contador]['Precio'];
            $detalle->Descuento = $request->get('Detalles')[$contador]['Descuento'];
            $detalle->Subtotal = $request->get('Detalles')[$contador]['Subtotal'];
            $detalle->save();
            $contador = $contador + 1;
        }

        /*Agregar Kardex*/

        $cont = 0;
        while($cont < $cantidad){
            $fec =Carbon::now('America/Lima');
            $fecha=$fec->toDateTimeString();
            $idventa = $venta->ID_Doc_Venta;
            $idproducto= $request->get('Detalles')[$cont]['ID_Producto'];
            $cantprod = $request->get('Detalles')[$cont]['Cantidad'];
            $desc = "Ventas";
            $kardex = DB::select('call sp_kardex(?,?,?,?,?)',array($idventa,$fecha,$idproducto,$cantprod,$desc));
            $cont = $cont +1;
        }

        /*Actualizar el tipo de documento*/
        $idtipodoc = $request->get('ID_Tipo_Documento');
        $sertipodoc = $request->get('Serie');
        $numtipodoc = $request->get('Numero');
        /*optimizar codigo con una función*/
        $boleta=implode("",$this->UpdateBoleta($numtipodoc));
        $tdoc = Tipo_Documento::findOrFail($idtipodoc);
        $tdoc->Serie = $sertipodoc;
        $tdoc->Numero = $boleta;
        $tdoc->update();
        /************************/

        if ($venta){
            if ($detalle){
                if ($tdoc){
                    return response()->json(['success'=>'true']);
                }else{
                    return response()->json(['success'=>'false']);
                }
            }else{
                return response()->json(['success'=>'false']);
            }
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id){
        $venta = DB::table('t_doc_venta as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->join('t_forma_pago as p','v.ID_Forma_Pago','=','p.ID_Forma_Pago')
            ->select('v.ID_Doc_Venta','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','v.Serie','v.Numero','v.FechaVenta_Actual as Fecha','p.ID_Forma_Pago','p.Nombre as Forma','v.Estado','v.FechaVenta_Credito as Fecha_Credito','v.Nro_Dias','v.IGV','v.Total','v.Subtotal','v.SubIGV')
            ->where('v.ID_Doc_Venta','=',$id)
            ->first();

        $detalles = DB::table('t_detalle_doc_venta as d')
            ->join('t_producto as p','d.ID_Producto','=','p.ID_Producto')
            ->select('p.Nombre as producto','d.Cantidad','d.Precio','d.Descuento','d.Subtotal')
            ->where('d.ID_Doc_Venta','=',$id)
            ->get();

        return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }

    public function autocomplete(Request $request){
        $term=$request->term;
        $data = DB::table('t_producto as p')
              ->join('t_marca as ma','p.ID_Marca','=','ma.ID_Marca')
              ->join('t_modelo as mo','p.ID_Modelo','=','mo.ID_Modelo')
              ->join('t_categoria as c','p.ID_Categoria','=','c.ID_Categoria')
              ->select('p.ID_Producto','p.Nombre as Producto','p.PU_Publico','p.PU_Ferreteria','p.Stock','p.Stock_Min','p.ID_Marca',
              'ma.Nombre as Marca','p.ID_Categoria','c.Nombre as Categoria','p.ID_Modelo','mo.Nombre as Modelo')
              ->where('p.Nombre','LIKE','%'.$term.'%')
              ->orderBy('p.ID_Producto','ASC')
              ->take(50)
              ->get();
        $results=array();
        foreach ($data as $v)
        {
            $results[]=['id'=>$v->ID_Producto,'value'=>$v->Producto,'pu_pub'=>$v->PU_Publico,'pu_fer'=>$v->PU_Ferreteria,'stock'=>$v->Stock,
                'id_marca'=>$v->ID_Marca,'marca'=>$v->Marca,'id_cat'=>$v->ID_Categoria,'cat'=>$v->Categoria,'id_modelo'=>$v->ID_Modelo,
                'modelo'=>$v->Modelo];
        }
        return response()->json($results);
    }

    public function pdf($id){
        $venta = DB::table('t_doc_venta as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->join('t_forma_pago as p','v.ID_Forma_Pago','=','p.ID_Forma_Pago')
            ->select('v.ID_Doc_Venta','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','d.Serie','d.Numero','v.FechaVenta_Actual as Fecha','p.ID_Forma_Pago','p.Nombre as Forma','v.Estado','v.FechaVenta_Credito as Fecha_Credito','v.Nro_Dias','v.IGV','v.Total')
            ->where('v.ID_Doc_Venta','=',$id)
            ->first();

        $detalles = DB::table('t_detalle_doc_venta as d')
            ->join('t_producto as p','d.ID_Producto','=','p.ID_Producto')
            ->select('p.Nombre as producto','d.Cantidad','d.Precio','d.Descuento','d.Subtotal')
            ->where('d.ID_Doc_Venta','=',$id)
            ->get();


        $pdf = PDF::loadView('ventas.venta.pdf', ["venta"=>$venta,"detalles"=>$detalles]);
        return $pdf->download('invoice.pdf');
    }

    public function showpdf($id){
        $venta = DB::table('t_doc_venta as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->join('t_forma_pago as p','v.ID_Forma_Pago','=','p.ID_Forma_Pago')
            ->select('v.ID_Doc_Venta','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','d.Serie','d.Numero','v.FechaVenta_Actual as Fecha','p.ID_Forma_Pago','p.Nombre as Forma','v.Estado','v.FechaVenta_Credito as Fecha_Credito','v.Nro_Dias','v.IGV','v.Total')
            ->where('v.ID_Doc_Venta','=',$id)
            ->first();

        $detalles = DB::table('t_detalle_doc_venta as d')
            ->join('t_producto as p','d.ID_Producto','=','p.ID_Producto')
            ->select('p.Nombre as producto','d.Cantidad','d.Precio','d.Descuento','d.Subtotal')
            ->where('d.ID_Doc_Venta','=',$id)
            ->get();

        $view =  \View::make('ventas.venta.showpdf', ["venta"=>$venta,"detalles"=>$detalles]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');

    }


    public function UpdateBoleta($numtipodoc){
        $convert = array_map('intval',str_split($numtipodoc));

        if ($convert[6]==9){
            $convert[6]=0;
            if($convert[5] < 9)
            {
                $convert[5] = $convert[5] + 1;
            }elseif($convert[5]==9)
            {
                $convert[5]=0;
                if($convert[4] < 9)
                {
                    $convert[4]=$convert[4]+1;
                }elseif ($convert[4]==9)
                {
                    $convert[4]=0;
                    if($convert[3]<9)
                    {
                        $convert[3]=$convert[3]+1;
                    }elseif ($convert[3]==9)
                    {
                        $convert[3]=0;
                        if($convert[2]<9)
                        {
                            $convert[2]=$convert[2]+1;
                        }elseif ($convert[2]==9)
                        {
                            $convert[2]=0;
                            if($convert[1]<9)
                            {
                                $convert[1]=$convert[1]+1;
                            }elseif ($convert[1]==9)
                            {
                                $convert[1]=0;
                                if($convert[0]<9)
                                {
                                    $convert[0]=$convert[0]+1;
                                }elseif ($convert[0]==9){

                                }
                            }
                        }
                    }
                }
            }
        }else{
            $convert[6]= $convert[6] + 1;
        }

        return $convert;
    }

}
