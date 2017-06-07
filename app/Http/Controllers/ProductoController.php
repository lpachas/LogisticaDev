<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Producto;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\ProductoFormRequest;
use SISTEMA_LOGISTICA\Http\Requests\StockFormRequest;
use DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $marcas = DB::table('t_marca')->orderBy('ID_Marca','ASC')->get();
        $categorias = DB::table('t_categoria')->orderBy('ID_Categoria','ASC')->get();
        $modelos = DB::table('t_modelo')->orderBy('ID_Modelo','ASC')->get();
        return view('almacen.producto.index',["marcas"=>$marcas,"categorias" => $categorias,"modelos"=>$modelos]);
    }

    public function get_producto_info(Request $request)
    {
        if($request->ajax())
        {
            $productos=$this->listaproductos($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('almacen.producto.listaproductos',compact('productos','search'))->render();
                return response($view);
            }else{
                $view=view('almacen.producto.listaproductos',compact('productos'))->render();
                return response($view);
            }
        }
    }

    public function listaproductos($search)
    {
        return  $productos=DB::table('t_producto as t_p')
            ->join('t_marca as t_m','t_p.ID_Marca','=','t_m.ID_Marca')
            ->join('t_categoria as t_c','t_p.ID_Categoria','=','t_c.ID_Categoria')
            ->join('t_modelo as t_md','t_p.ID_Modelo','=','t_md.ID_Modelo')
            ->select('t_p.ID_Producto as id','t_p.Nombre','t_p.PU_Publico','t_p.PU_Ferreteria','t_p.Stock','t_m.Nombre as Marca','t_c.Nombre as Categoria','t_md.Nombre as Modelo')
            ->where('t_p.Nombre','LIKE','%'.$search.'%')
            ->orwhere('t_m.Nombre','LIKE','%'.$search.'%')
            ->orderBy('t_p.ID_Producto','DESC')
            ->paginate(10);
    }

    public function getproductosinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $productos=$this->listaproductos($request['search']);
            return view('almacen.producto.listaproductos',compact('productos'))->render();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(ProductoFormRequest $request)
    {
        if ($request->ajax())
        {
            $producto = new Producto($request->all());
            $producto->save();

            if ($producto) {
                return response()->json(['success'=>'true','Nombre'=>$producto->Nombre]);
            }else{
                return response()->json(['success'=>'false']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function stock($id)
    {
        $producto = Producto::FindOrFail($id);
        if ($producto)
        {
            return response()->json($producto);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModeloFormRequest $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto=Producto::FindOrFail($id);
        $producto->delete();

        if($producto)
        {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function UpdStock(StockFormRequest $request,$id)
    {
        if ($request->ajax())
        {
            $Actualizar = DB::select('call PA_ActStockxID(?,?)',array($id,$request->get('stock')));
            if($Actualizar){
                return response()->json(['success'=>'true']);
            }else{
                return response()->json(['success'=>'true']);
            }
        }
    }
}
