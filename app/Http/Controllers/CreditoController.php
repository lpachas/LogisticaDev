<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;

use SISTEMA_LOGISTICA\Http\Requests;
use DB;
use Carbon\Carbon;
use Input;
use PDF;
class CreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('ventas.credito.creditos');
    }

    public function get_credito_info(Request $request)
    {
        if($request->ajax())
        {
            $creditos=$this->listacreditos($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('ventas.credito.listacreditos',compact('creditos','search'))->render();
                return response($view);
            }else{
                $view=view('ventas.credito.listacreditos',compact('creditos'))->render();
                return response($view);
            }
        }
    }

    public function listacreditos($search)
    {
        return  $creditos=DB::table('t_doc_venta as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->select('v.ID_Doc_Venta','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','d.Serie','d.Numero','v.FechaVenta_Actual as Fecha','v.FechaVenta_Credito as FechaCredito','v.Nro_Dias as Dias')
            ->where('v.Numero','LIKE','%'.$search.'%')
            ->where('v.FechaVenta_Credito','<>','0000-00-00')
            ->orderBy('v.ID_Doc_Venta','DESC')
            ->paginate(15);
    }

    public function getcreditosinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $creditos=$this->listacreditos($request['search']);
            return view('ventas.credito.listacreditos',compact('creditos'))->render();
        }
    }
}
