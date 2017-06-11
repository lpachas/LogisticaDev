<html>
<head>
    <style>
        #detalles {border-spacing:0;}
        #detalles thead{background:#ddd;}
        #detalles tbody{background:#eee;}
        #detalles tfoot{background:#ddd;}
        #detalles th{padding:10px;}
        #detalles tr{padding:10px;}
        #detalles td{padding:10px;}
        table{width:80%;}
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="id_cliente">Cliente:</label>
            <input type="text" value="{{$venta->Cliente}}" class="form-control" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="id_usuario">Usuario:</label>
            <input type="text" value="{{$venta->Usuario}}" class="form-control" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="tipo_doc">Tipo de Documento:</label>
            <input type="text" value="{{$venta->Documento}}"  class="form-control" disabled>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="serie">Serie:</label>
            <input type="text" value="{{$venta->Serie}}"  class="form-control" disabled>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="numero">Número:</label>
            <input type="text" value="{{$venta->Numero}}" class="form-control" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="fecha">Fecha de Venta:</label>
            <input type="text" value="{{$venta->Fecha}}"  class="form-control" disabled>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="forma">Forma de Pago:</label>
            <input type="text" value="{{$venta->Forma}}"  class="form-control" disabled>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" value="{{$venta->Estado}}" class="form-control" disabled>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-md-12">
                <h4>Detalle: </h4>
            </div>
            <div>
                <table id="detalles">
                    <thead style="background-color: #A9D0F5">
                    <tr>
                        <th width="52%">Producto</th>
                        <th width="12%">Cantidad</th>
                        <th width="12%">Precio Venta</th>
                        <th width="12%">Descuento</th>
                        <th width="12%">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($detalles as $detalle)
                        <tr>
                            <th width="52%">{{$detalle->producto}}</th>
                            <th width="12%">{{$detalle->Cantidad}}</th>
                            <th width="12%">{{$detalle->Precio}}</th>
                            <th width="12%">{{$detalle->Descuento}}</th>
                            <th width="12%">{{$detalle->Subtotal}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                    <th width="52%"></th>
                    <th width="12%"><br>Total</th>
                    <th width="12%"><br>IGV</th>
                    <th width="12%"><input type="text" id="igv" value="{{$venta->IGV}}" class="form-control" disabled></th>
                    <th width="12%"><h4 id="total">{{$venta->Total}}</h4></th>
                    </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>