<table class="table table-striped">
    <thead>
    <tr>
        <th width="25%">Cliente</th>
        <th width="15%">Usuario</th>
        <th width="13%">Documento</th>
        <th width="13%">Serie</th>
        <th width="13%">Número</th>
        <th width="10">Fecha</th>
        <th width="11%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($ventas)>0)
        @foreach($ventas as $venta)
            <tr class="id{{$venta->ID_Doc_Venta}}">
                <td width="25%" class="text-left">{{$venta->Cliente}}</td>
                <td width="15%" class="text-left">{{$venta->Usuario}}</td>
                <td width="13%" class="text-left">{{$venta->Documento}}</td>
                <td width="13%" class="text-left">{{$venta->Serie}}</td>
                <td width="13%" class="text-left">{{$venta->Numero}}</td>
                <td width="10%" class="text-left">{{$venta->Fecha}}</td>
                <td width="11%" class="text-left">
                    <a href="{{URL::action('VentaController@show', $venta->ID_Doc_Venta)}}" title="Ver Detalle" alt="Ver Detalle" ><button class="btn btn-primary"><i class="fa fa-sign-in"></i></button></a>
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
{!! $ventas->links() !!}