<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Producto;
use SISTEMA_LOGISTICA\Venta;
use SISTEMA_LOGISTICA\Marca;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\VentaFormRequest;
use DB;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('ventas.venta.ventas');
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
}
