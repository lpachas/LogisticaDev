<html>
<head></head>
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
            <div class="col-md-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color: #A9D0F5">
                    <th width="52%">Producto</th>
                    <th width="12%">Cantidad</th>
                    <th width="12%">Precio Venta</th>
                    <th width="12%">Descuento</th>
                    <th width="12%">Subtotal</th>
                    </thead>
                    <tfoot>
                    <th width="52%"></th>
                    <th width="12%"><br>Total</th>
                    <th width="12%"><br>IGV</th>
                    <th width="12%"><input type="text" id="igv" value="{{$venta->IGV}}" class="form-control" disabled></th>
                    <th width="12%"><h4 id="total">{{$venta->Total}}</h4></th>
                    </tfoot>
                    <tbody>
                    @foreach($detalles as $detalle)
                        <tr>
                            <td>{{$detalle->producto}}</td>
                            <td>{{$detalle->Cantidad}}</td>
                            <td>{{$detalle->Precio}}</td>
                            <td>{{$detalle->Descuento}}</td>
                            <td>{{$detalle->Subtotal}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-2 col-md-push-8">
                <div class="text-right" id="export">
                    <b>Ver Doc.:</b>
                    <a href="#" title="Ver Doc." alt="Ver Doc."><i class="fa fa-search-plus" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-2 col-md-push-8">
                <div class="text-right" id="export">
                    <b>Exportar a :</b>
                    <a href="#" title="Exportar a PDF" alt="Exportar a PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    <a href="#" title="Exportar a Excel" alt="Exportar a Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>