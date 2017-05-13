<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\TipoUsuario;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\TipoUsuarioFormRequest;
use DB;

class TipoUsuarioController extends Controller
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
        return view('usuarios.tipo.index');
    }

    public function get_tipo_info(Request $request)
    {
        if($request->ajax())
        {
            $tipos=$this->listatipos($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('usuarios.tipo.listatipos',compact('tipos','search'))->render();
                return response($view);
            }else{
                $view=view('usuarios.tipo.listatipos',compact('tipos'))->render();
                return response($view);
            }
        }
    }

    public function listatipos($search)
    {
        return  $tipos=DB::table('t_tipo_usuario')->where('Nombre','LIKE','%'.$search.'%')
            ->orderBy('ID_Tipo_Usuario','DESC')
            ->paginate(10);
    }

    public function gettiposinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $tipos=$this->listatipos($request['search']);
            return view('usuarios.tipo.listatipos',compact('tipos'))->render();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoUsuarioFormRequest $request)
    {
        if ($request->ajax())
        {
            $tipo = new TipoUsuario($request->all());
            $tipo->save();

            if ($tipo) {
                return response()->json(['success'=>'true','ID_Tipo_Usuario'=>$tipo->ID_Tipo_Usuario,'Nombre'=>$tipo->Nombre]);
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
        $tipo = TipoUsuario::FindOrFail($id);
        return response()->json($tipo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipo = TipoUsuario::FindOrFail($id);
        if ($tipo)
        {
            return response()->json($tipo);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoUsuarioFormRequest $request, $id)
    {
        if ($request->ajax())
        {
            $tipo=TipoUsuario::FindOrFail($id);
            $tipo->fill($request->all());
            $tipo->save();
            if ($tipo){
                return response()->json(['success'=>'true','ID_Tipo_Usuario'=>$tipo->ID_Tipo_Usuario,'Nombre'=>$tipo->Nombre]);
            }else{
                return response()->json(['success'=>'false']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo=TipoUsuario::FindOrFail($id);
        $tipo->delete();

        if($tipo)
        {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
