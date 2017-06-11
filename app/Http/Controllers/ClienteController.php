<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Cliente;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\ClienteFormRequest;
use DB;


class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('ventas.cliente.clientes');
    }

    public function get_cliente_info(Request $request)
    {
        if($request->ajax())
        {
            $clientes=$this->listaclientes($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('ventas.cliente.listaclientes',compact('clientes','search'))->render();
                return response($view);
            }else{
                $view=view('ventas.cliente.listaclientes',compact('clientes'))->render();
                return response($view);
            }
        }
    }

    public function listaclientes($search)
    {
        return  $clientes=DB::table('t_cliente')
            ->select('ID_Cliente','Nombre','Direccion','RUC_DNI','Telefono','Zona')
            ->where('Nombre','LIKE','%'.$search.'%')
            ->orwhere('RUC_DNI','LIKE','%'.$search.'%')
            ->orwhere('Zona','LIKE','%'.$search.'%')
            ->orderBy('ID_Cliente','DESC')
            ->paginate(15);
    }

    public function getclientesinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $clientes=$this->listaclientes($request['search']);
            return view('ventas.cliente.listaclientes',compact('clientes'))->render();
        }
    }

    public function store(ClienteFormRequest $request)
    {
        $cliente = new Cliente;
        $cliente->Nombre= $request->get('Nombre');
        $cliente->Direccion=$request->get('Direccion');
        $cliente->RUC_DNI=$request->get('RUC_DNI');
        $cliente->Telefono=$request->get('Telefono');
        $cliente->Zona=$request->get('Zona');
        $cliente->save();

        if ($cliente) {
            return response()->json(['success'=>'true','id_cliente'=>$cliente->ID_Cliente,'nombre'=>$cliente->Nombre,'doc'=>$cliente->RUC_DNI]);
        }else{
            return response()->json(['success'=>'false']);
        }

    }

    public function edit($id)
    {
        $cliente = Cliente::FindOrFail($id);
        if ($cliente)
        {
            return response()->json($cliente);
        }
    }

    public function update(ClienteFormRequest $request, $id)
    {
        if ($request->ajax())
        {
            $cliente=Cliente::FindOrFail($id);
            $cliente->fill($request->all());
            $cliente->save();
            if ($cliente){
                return response()->json(['success'=>'true','ID_Cliente'=>$cliente->ID_Cliente,'Nombre'=>$cliente->Nombre]);
            }else{
                return response()->json(['success'=>'false']);
            }
        }
    }

    public function destroy($id)
    {
        $cliente=Cliente::FindOrFail($id);
        $cliente->delete();

        if($cliente)
        {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

}
