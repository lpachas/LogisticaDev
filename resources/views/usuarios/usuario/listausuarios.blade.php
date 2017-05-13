
<table class="table table-striped">
    <thead>
    <tr>
        <th width="20%">Usuario</th>
        <th width="30%">Datos</th>
        <th width="20%">Email</th>
        <th width="15%">Editar</th>
        <th width="15%">Eliminar</th>
    </tr>
    </thead>
    <tbody>
    @if(count($usuarios)>0)
        @foreach($usuarios as $usuario)
            <tr class="id{{$usuario->id}}">
                <td width="20%" class="text-left">{{$usuario->name}}</td>
                <td width="30%" class="text-left">{{$usuario->Datos}}</td>
                <td width="20%" class="text-left">{{$usuario->email}}</td>
                <td width="15%" class="text-left">
                    <a title="Editar usuarios" alt="Editar usuarios" href="javascript:EditarUsuario({{$usuario->id}})" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                </td>
                <td width="15%" class="text-left">
                    <a title="Eliminar usuarios" alt="Eliminar usuarios" href="javascript:EliminarUsuario('{{$usuario->id}}','{{$usuario->name}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
{!! $usuarios->links() !!}