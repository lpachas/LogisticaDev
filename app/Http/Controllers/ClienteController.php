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
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }
}
