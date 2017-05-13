<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\User;
use SISTEMA_LOGISTICA\Membresia;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\UserFormRequest;
use DB;

class UsuarioController extends Controller
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
        $trabajadores = DB::table('t_trabajador')
                    ->select(DB::raw('CONCAT(Nombre," ",Ap_Paterno," ",Ap_Materno) as Datos'),'ID_Trabajador')
                    ->orderBy('ID_Trabajador','ASC')->get();
        $tipos = DB::table('t_tipo_usuario')->orderBy('ID_Tipo_Usuario','ASC')->get();
        return view('usuarios.usuario.index',["trabajadores"=>$trabajadores,"tipos" => $tipos]);
    }

    public function get_usuario_info(Request $request)
    {
        if($request->ajax())
        {
            $usuarios=$this->listausuarios($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('usuarios.usuario.listausuarios',compact('usuarios','search'))->render();
                return response($view);
            }else{
                $view=view('usuarios.usuario.listausuarios',compact('usuarios'))->render();
                return response($view);
            }
        }
    }

    public function listausuarios($search)
    {
        return  $usuarios=DB::table('users as u')
            ->join('t_trabajador as t','u.ID_Trabajador','=','t.ID_Trabajador')
            ->select('u.id','u.name',DB::raw('CONCAT(t.Nombre," ",t.Ap_Paterno) as Datos'),'u.email','u.Estado')
            ->where('u.Estado','=',1)
            ->where('u.name','LIKE','%'.$search.'%')
            ->orderBy('u.id','DESC')
            ->paginate(10);
    }

    public function getusuariosinfosearch(Request $request)
    {
        if ($request->ajax()) {
            $usuarios = $this->listausuarios($request['search']);
            return view('usuarios.usuario.listausuarios', compact('usuarios'))->render();
        }
    }

    public function store(UserFormRequest $request)
    {
        if ($request->ajax())
        {
            $usuario = new User;
            $usuario->ID_Trabajador=$request->get('ID_Trabajador');
            $usuario->name=$request->get('name');
            $usuario->password=bcrypt($request->password);
            $usuario->email=$request->get('email');
            $usuario->Descripcion=$request->get('Descripcion');
            $usuario->tipos = $request->get('ID_Tipo_Usuario');
            $usuario->Estado = 1;
            $usuario->save();

            $tipos  = explode(",",$request->get('ID_Tipo_Usuario'));
            $cont = 0;
            while($cont < count($tipos)) {
                $membresia=new Membresia();
                $membresia->ID_Usuario = $usuario->id;
                $membresia->ID_Tipo_Usuario = $tipos[$cont];
                $membresia->Estado = 1;
                $membresia->save();
                $cont = $cont + 1;
            }

            if ($usuario) {
                if ($membresia){
                    return response()->json(['success'=>'true']);
                }else{
                    return response()->json(['success'=>'true']);
                }
            }else{
                return response()->json(['success'=>'false']);
            }
        }
    }

    public function edit($id){
        $usuario = DB::table('users as u')
            ->join('t_trabajador as t','u.ID_Trabajador','=','t.ID_Trabajador')
            ->select('u.id as ID_USUARIO','u.ID_TRABAJADOR','u.tipos AS TIPOS',DB::raw('CONCAT(t.Nombre," ",t.Ap_Paterno," ",t.Ap_Materno) as DATOS'),'u.name as USUARIO','u.email as EMAIL','u.Descripcion as DESCRIPCION')
            ->where('u.id','=',$id)
            ->first();

        if ($usuario)
        {
            return response()->json($usuario);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $usuario = User::FindOrFail($id);
            $usuario->name = $request->get('name');
            $usuario->email = $request->get('email');
            $usuario->Descripcion = $request->get('Descripcion');
            $usuario->tipos = $request->get('ID_Tipo_Usuario');
            $usuario->update();


            //actualización de tipos
            /*
            $tiposBD = DB::table('users')->select('tipos')->where('id','=',$id)->first(); //tipos almacenados en la BD
            $tiposBDa= explode(",",$tiposBD);  // array de tipos almacenados en la BD
            $tipos = explode(",", $request->get('ID_Tipo_Usuario')); // tipos provenientes del Form Edit
            $cant1 = count($tiposBDa);
            $cant2 = count($tipos);
            $cont = 0;

            if ($cant1>$cant2){
                $mayor = $cant1;
            }else{
                $mayor = $cant2;
            }
            */

            $tipos = explode(",", $request->get('ID_Tipo_Usuario')); // tipos provenientes del Form Edit
            $cont = 0;

            while ($cont < count($tipos)) {
                $membresia = Membresia::where('ID_Usuario', '=', $id)->where('ID_Tipo_Usuario', '=', $tipos[$cont])->First();
                if(empty($membresia))
                {
                    $membresia=new Membresia();
                    $membresia->ID_Usuario = $id;
                    $membresia->ID_Tipo_Usuario = $tipos[$cont];
                    $membresia->Estado = 1;
                    $membresia->save();
                }else{
                    $membresia->ID_Tipo_Usuario = $tipos[$cont];
                    $membresia->Estado = 1;
                    $membresia->update();
                }

                $cont = $cont + 1;
            }

            if ($usuario) {
                if ($membresia)
                {
                    return response()->json(['success' => 'true']);
                }else{
                    return response()->json(['success'=>'false']);
                }
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function destroy($id)
    {
        $tipos = DB::table('t_membresia')->where('ID_Usuario','=',$id)->lists('id');
        $cont=0;
        while($cont < count($tipos))
        {
            $membresia = Membresia::where('id','=',$tipos[$cont])->First();
            $membresia->Estado = 0;
            $membresia->update();
            $cont++;
        }

        $usuario = User::FindOrFail($id);
        $usuario->Estado = 0;
        $usuario->update();

        if ($usuario){
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success' => 'false']);
        }
    }
}
