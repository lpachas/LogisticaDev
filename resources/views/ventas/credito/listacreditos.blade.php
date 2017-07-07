<table class="table table-striped">
    <thead>
    <tr>
        <th width="25%">Cliente</th>
        <th width="10%">Usuario</th>
        <th width="18%">Documento</th>
        <th width="10%">Fecha Venta</th>
        <th width="10%">Fecha Crédito</th>
        <th width="12%">Días Restantes</th>
        <th width="15%">Opciones</th>
    </tr>
    </thead>
    <tbody>
    @if(count($creditos)>0)
        @foreach($creditos as $credito)
            <tr class="id{{$credito->ID_Doc_Venta}}">
                <td width="25%" class="text-left">{{$credito->Cliente}}</td>
                <td width="10%" class="text-left">{{$credito->Usuario}}</td>
                <td width="18%" class="text-left">{{$credito->Documento}}: "{{$credito->Serie}}-{{$credito->Numero}}"</td>
                <td width="10%" class="text-left">{{$credito->Fecha}}</td>
                <td width="12%" class="text-left">{{$credito->FechaCredito}}</td>
                <td width="10%" class="text-center">
                    <?php $d = $credito->Dias?>
                    @if($d< 5)
                            <b style="color:red"> {{$d = $credito->Dias}} Días</b>
                    @elseif ($d>5 and $d<30 )
                            <b style="color:green"> {{$d = $credito->Dias}} Días</b>
                    @endif
                </td>
                <td width="15%" class="text-left">

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
{!! $creditos->links() !!}