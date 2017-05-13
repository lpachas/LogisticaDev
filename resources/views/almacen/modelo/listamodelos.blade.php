
<table class="table table-striped">
    <thead>
    <tr>
        <th width="40%">Nombre</th>
        <th width="40%">Descripción</th>
        <th width="20%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($modelos)>0)
        @foreach($modelos as $modelo)
            <tr class="id{{$modelo->ID_Modelo}}">
                <td width="40%" class="text-left">{{$modelo->Nombre}}</td>
                <td width="40%" class="text-left">{{$modelo->Descripcion}}</td>
                <td width="20%" class="text-left">
                    <a title="Editar Modelo" alt="Editar Modelo" href="javascript:EditarModelo({{$modelo->ID_Modelo}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                    <a title="Eliminar Modelo" alt="Eliminar Modelo" href="javascript:EliminarModelo('{{$modelo->ID_Modelo}}','{{$modelo->Nombre}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
{!! $modelos->links() !!}