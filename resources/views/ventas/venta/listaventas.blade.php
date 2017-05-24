
<table class="table table-striped">
    <thead>
    <tr>
        <th width="40%">Nombre</th>
        <th width="40%">Descripción</th>
        <th width="20%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($categorias)>0)
        @foreach($categorias as $categoria)
            <tr class="id{{$categoria->ID_Categoria}}">
                <td width="40%" class="text-left">{{$categoria->Nombre}}</td>
                <td width="40%" class="text-left">{{$categoria->Descripcion}}</td>
                <td width="20%" class="text-left">
                    <a title="Editar Categoría" alt="Editar Categoría" href="javascript:EditarCategoria({{$categoria->ID_Categoria}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                    <a title="Eliminar Categoría" alt="Eliminar Categoría" href="javascript:EliminarCategoria('{{$categoria->ID_Categoria}}','{{$categoria->Nombre}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3">No se encontraron resultados</td>
        </tr>
    @endif
    </tbody>
</table>
{!! $categorias->links() !!}