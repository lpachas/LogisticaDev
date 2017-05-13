<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Trabajador;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\TrabajadorFormRequest;
use DB;

class TrabajadorController extends Controller
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
        return view('usuarios.trabajador.index');
    }

    public function get_trabajador_info(Request $request)
    {
        if($request->ajax())
        {
            $trabajadores=$this->listatrabajadores($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('usuarios.trabajador.listatrabajadores',compact('trabajadores','search'))->render();
                return response($view);
            }else{
                $view=view('usuarios.trabajador.listatrabajadores',compact('trabajadores'))->render();
                return response($view);
            }
        }
    }

    public function listatrabajadores($search)
    {
        return  $trabajadores=DB::table('t_trabajador')
            ->select(DB::raw('CONCAT(Nombre," ",Ap_Paterno," ",Ap_Materno) as Datos'),'ID_Trabajador','DNI','Cargo')
            ->where('Nombre','LIKE','%'.$search.'%')
            ->orwhere('DNI','LIKE','%'.$search.'%')
            ->orderBy('ID_Trabajador','DESC')
            ->paginate(10);
    }

    public function gettrabajadoresinfosearch(Request $request)
    {
        if ($request->ajax()) {
            $trabajadores = $this->listatrabajadores($request['search']);
            return view('usuarios.trabajador.listatrabajadores', compact('trabajadores'))->render();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrabajadorFormRequest $request)
    {
        if ($request->ajax())
        {

            $trabajador = new Trabajador;
            $trabajador->DNI=$request->get('DNI');
            $trabajador->Nombre=$request->get('Nombre');
            $trabajador->Ap_Paterno=$request->get('Ap_Paterno');
            $trabajador->Ap_Materno=$request->get('Ap_Materno');
            $trabajador->Cargo = $request->get('Cargo');
            $trabajador->Sueldo_Base =$request->get('Sueldo_Base');
            $trabajador->save();

            if ($trabajador) {
                return response()->json(['success'=>'true']);
            }else{
                return response()->json(['success'=>'false']);
            }
        }
    }

    public function edit($id)
    {
        $trabajador = Trabajador::FindOrFail($id);
        if ($trabajador)
        {
            return response()->json($trabajador);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrabajadorFormRequest $request, $id)
    {
        if ($request->ajax())
        {
            $trabajador=Trabajador::FindOrFail($id);
            $trabajador->DNI=$request->get('DNI');
            $trabajador->Nombre=$request->get('Nombre');
            $trabajador->Ap_Paterno=$request->get('Ap_Paterno');
            $trabajador->Ap_Materno = $request->get('Ap_Materno');
            $trabajador->Cargo=$request->get('Cargo');
            $trabajador->Sueldo_Base=$request->get('Sueldo_Base');
            $trabajador->update();
            if ($trabajador){
                return response()->json(['success'=>'true']);
            }else{
                return response()->json(['success'=>'false']);
            }
        }
    }

    public function destroy($id)
    {
        $trabajador=Trabajador::FindOrFail($id);
        $trabajador->delete();

        if($trabajador)
        {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
