
<table class="table table-striped">
    <thead>
    <tr>
        <th width="31%">Datos Personales</th>
        <th width="13%">DNI</th>
        <th width="13%">Cargo</th>
        <th width="7%">Editar</th>
        <th width="7%">Eliminar</th>
    </tr>
    </thead>
    <tbody>
    @if(count($trabajadores)>0)
        @foreach($trabajadores as $trabajador)
            <tr class="id{{$trabajador->ID_Trabajador}}">
                <td width="31%" class="text-left">{{$trabajador->Datos}}</td>
                <td width="13%" class="text-left">{{$trabajador->DNI}}</td>
                <td width="13%" class="text-left">{{$trabajador->Cargo}}</td>
                <td width="15%" class="text-left">
                    <a title="Editar Trabajador" alt="Editar Trabajador" href="javascript:EditarTrabajador({{$trabajador->ID_Trabajador}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                </td>
                <td width="15%" class="text-left">
                        <a title="Eliminar Trabajador" alt="Eliminar Trabajador" href="javascript:EliminarTrabajador('{{$trabajador->ID_Trabajador}}','{{$trabajador->Datos}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-left">No se encontraron resultados</td>
        </tr>
    @endif
    </tbody>
</table>
{!! $trabajadores->links() !!}