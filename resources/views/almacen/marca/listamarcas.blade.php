
<table class="table table-striped">
    <thead>
    <tr>
        <th width="40%">Nombre</th>
        <th width="40%">Descripción</th>
        <th width="20%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($marcas)>0)
        @foreach($marcas as $marca)
            <tr class="id{{$marca->ID_Marca}}">
                <td width="40%" class="text-left">{{$marca->Nombre}}</td>
                <td width="40%" class="text-left">{{$marca->Descripcion}}</td>
                <td width="20%" class="text-left">
                    <a title="Editar Marca" alt="Editar Marca" href="javascript:EditarMarca({{$marca->ID_Marca}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                    <a title="Eliminar Marca" alt="Eliminar Marca" href="javascript:EliminarMarca('{{$marca->ID_Marca}}','{{$marca->Nombre}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
{!! $marcas->links() !!}