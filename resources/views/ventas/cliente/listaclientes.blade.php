<table class="table table-striped">
    <thead>
    <tr>
        <th width="25%">Cliente</th>
        <th width="20%">RUC o DNI</th>
        <th width="20%">Zona</th>
        <th width="20%">Teléfono</th>
        <th width="15%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($clientes)>0)
        @foreach($clientes as $cliente)
            <tr class="id{{$cliente->ID_Cliente}}">
                <td width="25%" class="text-left">{{$cliente->Nombre}}</td>
                <td width="20%" class="text-left">{{$cliente->RUC_DNI}}</td>
                <td width="20%" class="text-left">{{$cliente->Zona}}</td>
                <td width="20%" class="text-left">{{$cliente->Telefono}}</td>
                <td width="15%" class="text-left">
                    <a title="Editar Cliente" alt="Editar Cliente" href="javascript:EditarCliente({{$cliente->ID_Cliente}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                    <a title="Eliminar Cliente" alt="Eliminar Cliente" href="javascript:EliminarCliente('{{$cliente->ID_Cliente}}','{{$cliente->Nombre}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">No se encontraron resultados</td>
        </tr>
    @endif
    </tbody>
</table>
{!! $clientes->links() !!}