<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;

use SISTEMA_LOGISTICA\Http\Requests;
use DB;
use Carbon\Carbon;
use SISTEMA_LOGISTICA\Credito;
use SISTEMA_LOGISTICA\Http\Requests\CreditoFormRequest;
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
        return  $creditos=DB::table('t_credito as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->select('v.ID_Credito','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','d.Serie','d.Numero','v.FechaVenta_Actual as Fecha','v.FechaVenta_Credito as FechaCredito','v.Nro_Dias as Dias','v.Saldo_Credito')
            ->where('v.Numero','LIKE','%'.$search.'%')
            ->where('v.FechaVenta_Credito','<>','0000-00-00')
            ->where('v.Saldo_Credito','<>',0.00)
            ->orderBy('v.ID_Credito','DESC')
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

    public function Cargarcredito($id)
    {
        $credito=DB::table('t_credito as v')
            ->join('t_cliente as c','v.ID_Cliente','=','c.ID_Cliente')
            ->join('users as u','v.ID_Usuario','=','u.id')
            ->join('t_tipo_documento as d','v.ID_Tipo_Documento','=','d.ID_Tipo_Documento')
            ->select('v.ID_Credito','c.ID_Cliente','c.Nombre as Cliente','u.id as ID_Usuario','u.name as Usuario','d.ID_Tipo_Documento','d.Descripcion_Doc as Documento','d.Serie','d.Numero','v.FechaVenta_Actual as Fecha','v.FechaVenta_Credito as FechaCredito','v.Nro_Dias as Dias','v.Saldo_Credito')
            ->where('v.ID_Credito','=',$id)
            ->get();

        if ($credito)
        {
            return response()->json($credito);
        }
    }

    public function store(CreditoFormRequest $request)
    {
        $idcred=$request->get('ID_Credito');
        $iduser=$request->get('ID_Usuario');
        $dTotal=$request->get('dTotal');
        $dPago=$request->get('dPago');
        $dSaldo=$request->get('dSaldo');
        $credito = DB::select('call PA_PagarCredito(?,?,?,?,?)',array($idcred,$iduser,$dTotal,$dPago,$dSaldo));

        if ($credito){
            return response()->json(['success'=>'error']); /*modifico esto porque en los PA así ejecute bien me devuelve como error*/
        }else{
            return response()->json(['success'=>'hecho']);
        }
    }
}
