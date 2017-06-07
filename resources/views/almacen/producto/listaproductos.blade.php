
<table class="table table-striped">
    <thead>
    <tr>
        <th width="28%">Nombre</th>
        <th width="8%">PU_Publico</th>
        <th width="8%">Stock</th>
        <th width="10%">Marca</th>
        <th width="14%">Categoría</th>
        <th width="14%">Modelo</th>
        <th width="18%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($productos)>0)
        @foreach($productos as $producto)
            <tr class="id{{$producto->id}}">
                <td class="text-left">{{$producto->Nombre}}</td>
                <td class="text-left">{{$producto->PU_Publico}}</td>
                <td class="text-left">{{$producto->Stock}}</td>
                <td class="text-left">{{$producto->Marca}}</td>
                <td class="text-left">{{$producto->Categoria}}</td>
                <td class="text-left">{{$producto->Modelo}}</td>
                <td class="text-left">
                    <a title="Editar Producto" alt="Editar Producto" href="javascript:EditarProducto({{$producto->id}});" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                    <a titile="Actualizar Stock" alt="Actualizar Stock" href="javascript:ActualizarStock({{$producto->id}});" class="btn btn-success"><i class="fa fa-plus"></i></a>
                    <a title="Eliminar Producto" title="Eliminar Producto" href="javascript:EliminarProducto('{{$producto->id}}','{{$producto->Nombre}}');"><button class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">No se encontraron resultados</td>
        </tr>
    @endif
    </tbody>
</table>
{!! $productos->links() !!}