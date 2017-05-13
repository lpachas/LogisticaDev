<?php

namespace SISTEMA_LOGISTICA\Http\Controllers;

use Illuminate\Http\Request;
use SISTEMA_LOGISTICA\Http\Requests;
use SISTEMA_LOGISTICA\Categoria;
use Illuminate\Support\Facades\Redirect;
use SISTEMA_LOGISTICA\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
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
        return view('almacen.categoria.index');
    }

    public function get_categoria_info(Request $request)
    {
        if($request->ajax())
        {
            $categorias=$this->listacategorias($request['search']);
            if(!empty($request['search']))
            {
                $search=$request['search'];
                $view=view('almacen.categoria.listacategorias',compact('categorias','search'))->render();
                return response($view);
            }else{
                $view=view('almacen.categoria.listacategorias',compact('categorias'))->render();
                return response($view);
            }
        }
    }

    public function listacategorias($search)
    {
        return  $categorias=DB::table('t_categoria')->where('Nombre','LIKE','%'.$search.'%')
            ->orderBy('ID_Categoria','DESC')
            ->paginate(10);
    }

    public function getcategoriasinfosearch(Request $request)
    {
        if($request->ajax())
        {
            $categorias=$this->listacategorias($request['search']);
            return view('almacen.categoria.listacategorias',compact('categorias'))->render();
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
    public function store(CategoriaFormRequest $request)
    {
        if ($request->ajax())
        {
            $categoria = new Categoria($request->all());
            $categoria->save();

            if ($categoria) {
                return response()->json(['success'=>'true','ID_Categoria'=>$categoria->ID_Categoria,'Nombre'=>$categoria->Nombre,'Descripcion'=>$categoria->Descripcion]);
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
        $categoria = Categoria::FindOrFail($id);
        return response()->json($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::FindOrFail($id);
        if ($categoria)
        {
            return response()->json($categoria);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaFormRequest $request, $id)
    {
        if ($request->ajax())
        {
            $categoria=Categoria::FindOrFail($id);
            $categoria->fill($request->all());
            $categoria->save();
            if ($categoria){
                return response()->json(['success'=>'true','ID_Categoria'=>$categoria->ID_Categoria,'Nombre'=>$categoria->Nombre,'Descripcion'=>$categoria->Descripcion]);
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
        $categoria=Categoria::FindOrFail($id);
        $categoria->delete();

        if($categoria)
        {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
