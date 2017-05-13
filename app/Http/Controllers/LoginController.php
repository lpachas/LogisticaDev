<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\User;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\CargarPerfilesRequest;
use DB;

class LoginController extends Controller
{
    public function Index(){
        return view('login');
    }

    public function CargarPerfiles(CargarPerfilesRequest $request){
        $perfiles = DB::table('users as u')
              ->join('t_membresia as m','u.id','=','m.ID_Usuario')
              ->join('t_tipo_usuario as t','m.ID_Tipo_Usuario','=','t.ID_Tipo_Usuario')
              ->select('u.id','m.ID_Tipo_Usuario','t.Nombre')
              ->where('u.name','=',$request->name)
              ->where('m.Estado','=',1)
              ->get();

        if ($perfiles)
        {
            return response()->json(['success'=>'true','cant'=>count($perfiles),'perfiles'=>$perfiles]);
        }else{
            return response()->json(['success'=>'false']);
        }


    }
}
