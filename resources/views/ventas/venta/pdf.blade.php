<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>

        #detalles {border-spacing:0;}
        #detalles thead{background:#ddd;}
        #detalles tbody{background:#eee;}
        #detalles tfoot{background:#ddd;}
        #detalles th{padding:10px;}
        #detalles tr{padding:10px;}
        #detalles td{padding:10px;}
        .tabla table {
            border-collapse: collapse;
            width: 100%;
        }
        .nom_saldo table{
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid #000;
        }
        .tabla table .cabecera{
            background-color: #b3b3b3;
        }
        .tabla table tr td,.tabla table tr th{
            text-align: center;
            padding:10px;
        }
        .nom_saldo table tr td{
            padding: 10px;
        }
        .nom_saldo table tr td .derecha{
            text-align: left;
        }
        .nom_saldo table tr td .izquierda{
            text-align: right;
        }
    </style>
</head>
<body>
<div class="datos_venta">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="id_cliente">Cliente:</label>
                <input type="text" value="{{$venta->Cliente}}" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="id_usuario">Usuario:</label>
                <input type="text" value="{{$venta->Usuario}}" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="tipo_doc">Tipo de Documento:</label>
                <input type="text" value="{{$venta->Documento}}"  class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="serie">Serie:</label>
                <input type="text" value="{{$venta->Serie}}"  class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" value="{{$venta->Numero}}" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="fecha">Fecha de Venta:</label>
                <input type="text" value="{{$venta->Fecha}}"  class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="forma">Forma de Pago:</label>
                <input type="text" value="{{$venta->Forma}}"  class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" value="{{$venta->Estado}}" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="tabla">
    <table style="width: 100%">
        <thead>
        <tr class="cabecera">
            <td width="10%">CANT.</td>
            <td width="50%">DESCRIPCION</td>
            <td width="15%">P. UNIT</td>
            <td width="25%">VALOR VENTA</td>
        </tr>
        </thead>
        <tbody>
        @foreach($detalles as $detalle)
            <tr>
                <th>{{$detalle->Cantidad}}</th>
                <th>{{$detalle->producto}}</th>
                <th>{{$detalle->Precio}}</th>
                <th>{{$detalle->Subtotal}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<br>
<div class="nom_saldo">
    <table style="width: 60%;float: right;">
        <tr>
            <td>
                <b class="derecha">SON:</b>
                {{$venta->Detalle_Total}}
                <b style="float:right;">SOLES</b>
            </td>
        </tr>
    </table>
    <table style="width:35%; float:left;">
        <tr>
            <td>
                <b class="derecha">SON:</b>

                <b style="float:right;">SOLES</b>
            </td>
        </tr>
    </table>
</div>


</body>
</html>