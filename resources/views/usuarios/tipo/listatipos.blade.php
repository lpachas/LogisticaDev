
<table class="table table-striped">
    <thead>
    <tr>
        <th width="70%">Nombre</th>
        <th width="30%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($tipos)>0)
        @foreach($tipos as $tipo)
            <tr class="id{{$tipo->ID_Tipo_Usuario}}">
                <td width="70%" class="text-left">{{$tipo->Nombre}}</td>
                <td width="30%" class="text-left">
                    <a title="Editar Tipo" alt="Editar Tipo" href="javascript:EditarTipo({{$tipo->ID_Tipo_Usuario}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                    <a title="Eliminar Tipo" alt="Eliminar Tipo" href="javascript:EliminarTipo('{{$tipo->ID_Tipo_Usuario}}','{{$tipo->Nombre}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2" class="text-left">No se encontraron resultados</td>
        </tr>
    @endif
    </tbody>
</table>
{!! $tipos->links() !!}