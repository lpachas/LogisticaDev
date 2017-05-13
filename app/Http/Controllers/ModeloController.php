<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Modelo;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\ModeloFormRequest;
use DB;

class ModeloController extends Controller
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
        return view('almacen.modelo.index');
    }

    public function get_modelo_info(Request $request)
    {
        if($request->ajax())
        {
            $modelos=$this->listamodelos($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('almacen.modelo.listamodelos',compact('modelos','search'))->render();
                return response($view);
            }else{
                $view=view('almacen.modelo.listamodelos',compact('modelos'))->render();
                return response($view);
            }
        }
    }

    public function listamodelos($search)
    {
        return  $modelos=DB::table('t_modelo')->where('Nombre','LIKE','%'.$search.'%')
            ->orderBy('ID_Modelo','DESC')
            ->paginate(10);
    }

    public function getmodelosinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $modelos=$this->listamodelos($request['search']);
            return view('almacen.modelo.listamodelos',compact('modelos'))->render();
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
    public function store(ModeloFormRequest $request)
    {
        if ($request->ajax())
        {
            $modelo = new Modelo($request->all());
            $modelo->save();

            if ($modelo) {
                return response()->json(['success'=>'true','ID_Modelo'=>$modelo->ID_Modelo,'Nombre'=>$modelo->Nombre,'Descripcion'=>$modelo->Descripcion]);
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
        $modelo = Modelo::FindOrFail($id);
        return response()->json($modelo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelo = Modelo::FindOrFail($id);
        if ($modelo)
        {
            return response()->json($modelo);
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
        if ($request->ajax())
        {
            $modelo= Modelo::FindOrFail($id);
            $modelo->fill($request->all());
            $modelo->save();
            if ($modelo){
                return response()->json(['success'=>'true','ID_Modelo'=>$modelo->ID_Modelo,'Nombre'=>$modelo->Nombre,'Descripcion'=>$modelo->Descripcion]);
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
        $modelo=Modelo::FindOrFail($id);
        $modelo->delete();

        if($modelo)
        {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
