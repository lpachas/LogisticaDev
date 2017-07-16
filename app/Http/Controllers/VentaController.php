<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Producto;
use SISTEMA_LOGISTICA\Venta;
use SISTEMA_LOGISTICA\CredVenta;
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
        $venta->Detalle_Total = $this->convertir($request->get('Total'));
        $venta->save();

        $credventa = new CredVenta;
        $credventa->ID_Cliente = $request->get('ID_Cliente');
        $credventa->ID_Usuario = $request->get('ID_Usuario');
        $credventa->ID_Tipo_Documento = $request->get('ID_Tipo_Documento');
        $credventa->Serie = $request->get('Serie');
        $credventa->Numero = $request->get('Numero');
        $credventa->FechaVenta_Actual= $request->get('FechaVenta_Actual');
        $credventa->ID_Forma_Pago=$request->get('ID_Forma_Pago');
        $credventa->Estado='Venta';
        $credventa->FechaVenta_Credito = $request->get('FechaVenta_Credito');
        $credventa->Nro_Dias=$request->get('Nro_Dias');
        $credventa->IGV = $request->get('IGV');
        $credventa->Subtotal = $request->get('Subtotal');
        $credventa->SubIGV = $request->get('SubIGV');
        $credventa->Total = $request->get('Total');
        $credventa->Detalle_Total = $this->convertir($request->get('Total'));
        $credventa->Saldo_Credito = $this->get('Total');
        $credventa->save();

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
        /*return $pdf->download('invoice.pdf');*/
        return $pdf->stream('prueba.pdf');
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

    public function ConvertirTotal($numero){

    }

    public function unidad($numuero){
        switch ($numuero)
        {
            case 9:
            {
                $numu = "NUEVE";
                break;
            }
            case 8:
            {
                $numu = "OCHO";
                break;
            }
            case 7:
            {
                $numu = "SIETE";
                break;
            }
            case 6:
            {
                $numu = "SEIS";
                break;
            }
            case 5:
            {
                $numu = "CINCO";
                break;
            }
            case 4:
            {
                $numu = "CUATRO";
                break;
            }
            case 3:
            {
                $numu = "TRES";
                break;
            }
            case 2:
            {
                $numu = "DOS";
                break;
            }
            case 1:
            {
                $numu = "UNO";
                break;
            }
            case 0:
            {
                $numu = "";
                break;
            }
        }
        return $numu;
    }

    public function decena($numdero){

        if ($numdero >= 90 && $numdero <= 99)
        {
            $numd = "NOVENTA ";
            if ($numdero > 90)
                $numd = $numd."Y ".($this->unidad($numdero - 90));
        }
        else if ($numdero >= 80 && $numdero <= 89)
        {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd."Y ".($this->unidad($numdero - 80));
        }
        else if ($numdero >= 70 && $numdero <= 79)
        {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd."Y ".($this->unidad($numdero - 70));
        }
        else if ($numdero >= 60 && $numdero <= 69)
        {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd."Y ".($this->unidad($numdero - 60));
        }
        else if ($numdero >= 50 && $numdero <= 59)
        {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd."Y ".($this->unidad($numdero - 50));
        }
        else if ($numdero >= 40 && $numdero <= 49)
        {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd."Y ".($this->unidad($numdero - 40));
        }
        else if ($numdero >= 30 && $numdero <= 39)
        {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd."Y ".($this->unidad($numdero - 30));
        }
        else if ($numdero >= 20 && $numdero <= 29)
        {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI".($this->unidad($numdero - 20));
        }
        else if ($numdero >= 10 && $numdero <= 19)
        {
            switch ($numdero){
                case 10:
                {
                    $numd = "DIEZ ";
                    break;
                }
                case 11:
                {
                    $numd = "ONCE ";
                    break;
                }
                case 12:
                {
                    $numd = "DOCE ";
                    break;
                }
                case 13:
                {
                    $numd = "TRECE ";
                    break;
                }
                case 14:
                {
                    $numd = "CATORCE ";
                    break;
                }
                case 15:
                {
                    $numd = "QUINCE ";
                    break;
                }
                case 16:
                {
                    $numd = "DIECISEIS ";
                    break;
                }
                case 17:
                {
                    $numd = "DIECISIETE ";
                    break;
                }
                case 18:
                {
                    $numd = "DIECIOCHO ";
                    break;
                }
                case 19:
                {
                    $numd = "DIECINUEVE ";
                    break;
                }
            }
        }
        else
            $numd = $this->unidad($numdero);
        return $numd;
    }

    public function centena($numc){
        if ($numc >= 100)
        {
            if ($numc >= 900 && $numc <= 999)
            {
                $numce = "NOVECIENTOS ";
                if ($numc > 900)
                    $numce = $numce.($this->decena($numc - 900));
            }
            else if ($numc >= 800 && $numc <= 899)
            {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800)
                    $numce = $numce.($this->decena($numc - 800));
            }
            else if ($numc >= 700 && $numc <= 799)
            {
                $numce = "SETECIENTOS ";
                if ($numc > 700)
                    $numce = $numce.($this->decena($numc - 700));
            }
            else if ($numc >= 600 && $numc <= 699)
            {
                $numce = "SEISCIENTOS ";
                if ($numc > 600)
                    $numce = $numce.($this->decena($numc - 600));
            }
            else if ($numc >= 500 && $numc <= 599)
            {
                $numce = "QUINIENTOS ";
                if ($numc > 500)
                    $numce = $numce.($this->decena($numc - 500));
            }
            else if ($numc >= 400 && $numc <= 499)
            {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400)
                    $numce = $numce.($this->decena($numc - 400));
            }
            else if ($numc >= 300 && $numc <= 399)
            {
                $numce = "TRESCIENTOS ";
                if ($numc > 300)
                    $numce = $numce.($this->decena($numc - 300));
            }
            else if ($numc >= 200 && $numc <= 299)
            {
                $numce = "DOSCIENTOS ";
                if ($numc > 200)
                    $numce = $numce.($this->decena($numc - 200));
            }
            else if ($numc >= 100 && $numc <= 199)
            {
                if ($numc == 100)
                    $numce = "CIEN ";
                else
                    $numce = "CIENTO ".($this->decena($numc - 100));
            }
        }
        else
            $numce = $this->decena($numc);

        return $numce;
    }

    public function miles($nummero){
        if ($nummero >= 1000 && $nummero < 2000){
            $numm = "MIL ".($this->centena($nummero%1000));
        }
        if ($nummero >= 2000 && $nummero <10000){
            $numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000));
        }
        if ($nummero < 1000)
            $numm = $this->centena($nummero);

        return $numm;
    }

    public function decmiles($numdmero){
        if ($numdmero == 10000)
            $numde = "DIEZ MIL";
        if ($numdmero > 10000 && $numdmero <20000){
            $numde = $this->decena(Floor($numdmero/1000))."MIL ".($this->centena($numdmero%1000));
        }
        if ($numdmero >= 20000 && $numdmero <100000){
            $numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));
        }
        if ($numdmero < 10000)
            $numde = $this->miles($numdmero);

        return $numde;
    }

    public function cienmiles($numcmero){
        if ($numcmero == 100000)
            $num_letracm = "CIEN MIL";
        if ($numcmero >= 100000 && $numcmero <1000000){
            $num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000));
        }
        if ($numcmero < 100000)
            $num_letracm = $this->decmiles($numcmero);
        return $num_letracm;
    }

    public function millon($nummiero){
        if ($nummiero >= 1000000 && $nummiero <2000000){
            $num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000));
        }
        if ($nummiero >= 2000000 && $nummiero <10000000){
            $num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000));
        }
        if ($nummiero < 1000000)
            $num_letramm = $this->cienmiles($nummiero);

        return $num_letramm;
    }

    public function decmillon($numerodm){
        if ($numerodm == 10000000)
            $num_letradmm = "DIEZ MILLONES";
        if ($numerodm > 10000000 && $numerodm <20000000){
            $num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ".($this->cienmiles($numerodm%1000000));
        }
        if ($numerodm >= 20000000 && $numerodm <100000000){
            $num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));
        }
        if ($numerodm < 10000000)
            $num_letradmm = $this->millon($numerodm);

        return $num_letradmm;
    }

    public function cienmillon($numcmeros){
        if ($numcmeros == 100000000)
            $num_letracms = "CIEN MILLONES";
        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
            $num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000));
        }
        if ($numcmeros < 100000000)
            $num_letracms = $this->decmillon($numcmeros);
        return $num_letracms;
    }

    public function milmillon($nummierod){
        if ($nummierod >= 1000000000 && $nummierod <2000000000){
            $num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod <10000000000){
            $num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000));
        }
        if ($nummierod < 1000000000)
            $num_letrammd = $this->cienmillon($nummierod);

        return $num_letrammd;
    }

    public function convertir($numero){
        $num = str_replace(",","",$numero);
        $num = number_format($num,2,'.','');
        $cents = substr($num,strlen($num)-2,strlen($num)-1);
        $num = (int)$num;

        $numf = $this->milmillon($num);

        return " ".$numf." CON ".$cents."/100";
    }
}
