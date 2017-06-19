@extends('layouts.admin')
@section('title','Nueva Venta')
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="margin-right: 10px;">Realizar Venta</h2>
                        <a href="create" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva Venta</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form>
                         <input type="hidden" id="id_usuario" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="hidden" id="id-0" value="20">
                                                        <input type="hidden" id="id-1" value="30">
                                                        <label>Tipo de Documento:</label>
                                                        <select id="id_documento" name="id_documento" class="form-control selectpicker" data-live-search="true">
                                                            <option value="">--Seleccione un documento--</option>
                                                            @foreach($documentos as $doc)
                                                                <option value="{{$doc->ID_Tipo_Documento}}_{{$doc->Serie}}_{{$doc->Numero}}">{{$doc->Descripcion_Doc}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Serie:</label>
                                                        <input type="text" id="serie" class="form-control" placeholder="Serie de Documento">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Número:</label>
                                                        <input type="text" id="numero" class="form-control" placeholder="Número de Documento">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Forma de Pago:</label>
                                                    <select id="id_forma_pago" name="id_forma_pago" class="form-control selectpicker" data-live-search="true">
                                                        <option value="">--Seleccione una forma--</option>
                                                        <option value="1">Forma 1</option>
                                                        <option value="2">Forma 2</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="panel panel-primary">
                                     <div class="panel-body">
                                         <div class="row">
                                             <div class="col-md-8">
                                                 <div class="form-group">
                                                     <label>Cliente:</label>
                                                     <div id="seccion-cliente">
                                                        <select id="id_cliente" class="form-control selectpicker" data-live-search="true">
                                                         <option value="">--Seleccione un cliente--</option>
                                                         @foreach($clientes as $cliente)
                                                             <option value="{{$cliente->ID_Cliente}}">{{$cliente->RUC_DNI}} - {{$cliente->Nombre}}</option>
                                                         @endforeach
                                                        </select>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-md-4" style="padding-top: 1.7em;">
                                                 <div class="form-group">
                                                     <button id="btn_cliente" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Cliente</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="panel panel-primary">
                                     <div class="panel-body">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label>Tipo de Venta:</label>
                                                     <select id="id_tipo_venta" class="form-control selectpicker" data-live-search="true">
                                                         <option value="">--Seleccione Tipo Venta--</option>
                                                         <option value="1">CONTADO</option>
                                                         <option value="2">CRÉDITO</option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label>Fecha:</label>
                                                     <input type="text" class="form-control" id="fecha_venta">
                                                     <!--<div class="input-group date" id="fecha">
                                                         <div class="input-group-addon">
                                                             <i class="fa fa-calendar"></i>
                                                         </div>
                                                         <input type="text" class="form-control pull-right" id="fecha_venta" name="fecha_venta">
                                                     </div>-->
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Producto:</label>
                                            <input type="text" id="id_producto" class="form-control" name="id_producto">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" id="cont-marca">
                                            <label>Marca:</label>
                                            <input type="hidden" id="id_producto_sel">
                                            <input type="hidden" id="id_marca">
                                            <input type="text" id="nom_marca" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Categoría:</label>
                                            <input type="hidden" id="id_categoria">
                                            <input type="text" id="nom_categoria" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Modelo</label>
                                            <input type="hidden" id="id_modelo">
                                            <input type="text" id="nom_modelo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Stock:</label>
                                        <input type="text" class="form-control" id="stock" disabled>
                                        <input type="hidden" id="nomprod">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cantidad:</label>
                                        <input type="number" class="form-control" id="cantidad">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Precio Venta:</label>
                                        <input type="text" class="form-control" id="pventa" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Descuento:</label>
                                        <input type="text" class="form-control" id="descuento" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Parcial:</label>
                                        <input type="text" class="form-control" id="parcial" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <br>
                                            <button type="button" id="btn_add" class="btn btn-primary" disabled>Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="group-factura" style="display: none;">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color: #A9D0F5">
                                        <tr>
                                            <th width="15%">Opciones</th>
                                            <th width="45%">Artículo</th>
                                            <th width="10%">Cantidad</th>
                                            <th width="10%">Precio Venta</th>
                                            <th width="10%">Descuento</th>
                                            <th width="10%">Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th width="15%" rowspan="3"></th>
                                            <th width="45%" class="text-right" rowspan="3"></th>
                                            <th width="10%" class="text-center" rowspan="3"></th>
                                            <th width="10%" class="text-center" rowspan="3">
                                                <input type="checkbox" id="check"><input type="text" id="igv" value="0.18" class="form-control" disabled>
                                            </th>
                                            <th width="10%">Subtotal:</th>
                                            <th width="10%" class="text-right"><h5 id="subt">S/. 0.00</h5></th>
                                        </tr>
                                        <tr>
                                            <th width="10%">Subtotal IGV 18%:</th>
                                            <th width="10%" class="text-right"><h5 id="subigv">S/. 0.00</h5></th>
                                        </tr>
                                        <tr>
                                            <th width="10%">Total:</th>
                                            <th width="10%" class="text-right"><h5 id="tot">S/. 0.00</h5><input type="hidden" id="total_sale"></th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div id="group-boleta" style="display: none;">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color: #A9D0F5">
                                    <tr>
                                        <th width="15%">Opciones</th>
                                        <th width="45%">Artículo</th>
                                        <th width="10%">Cantidad</th>
                                        <th width="10%">Precio Venta</th>
                                        <th width="10%">Descuento</th>
                                        <th width="10%">Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th width="15%">Total:</th>
                                        <th width="10%" class="text-right"><h5 id="tot">S/. 0.00</h5><input type="hidden" id="total_sale"></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-right" id="guardar">
                                <div class="form-group">
                                    <button class="btn btn-danger" type="reset">Cancelar</button>
                                    <button class="btn btn-primary" type="button" id="btn_guardarventa">Guardar</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @include('ventas.venta.modal')
@endsection
@push('scripts')
<script src="{{asset('js/ventas/ventas.js') }}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script type="text/javascript">
    $('#id_producto').autocomplete({
       source:'{!! URL::route('autocomplete') !!}',
        minlength:1,
        autoFocus:true,
        select:function(e,ui){
           $('#id_producto_sel').val(ui.item.id);
           $('#id_marca').val(ui.item.id_marca);
           $('#nom_marca').val(ui.item.marca);
           $('#id_categoria').val(ui.item.id_cat);
           $('#nom_categoria').val(ui.item.cat);
           $('#id_modelo').val(ui.item.id_modelo);
           $('#nom_modelo').val(ui.item.modelo);
           $('#stock').val(ui.item.stock);
           $('#pventa').val(ui.item.pu_pub);
        }
    });

    $('#btn_prueba').on('click',function(e){
        e.preventDefault();
        var cliente ='<input type="hidden" class="form-control" id="id_cliente" value="1"><input type="text" class="form-control" value="Prueba" disabled>';
        $('#seccion-cliente').html(cliente);
        var id= $('#id_cliente').val();
        console.log(id);
    });


    $('#btnregistrar_cliente').on('click',function(e){
        e.preventDefault();
        var nom = $('#nombre').val();
        var dir = $('#direccion').val();
        var r_d = $('#ruc_dni').val();
        var tel = $('#telefono').val();
        var zona = $('#zona').val();
        var token = $("input[name=_token]").val();

        var data = {Nombre:nom,Direccion:dir,RUC_DNI:r_d,Telefono:tel,Zona:zona};
        var route = "{{route('ventas.cliente.store')}}";

        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN':token},
            type:'post' ,
            datatype: 'json',
            data: data,
            success:function(data)
            {
                if(data.success == 'true')
                {
                    $('#mensaje_cliente').addClass('exito').html("El Cliente ha sido registrado").show(300).delay(3000).hide(300);
                    CerrarModal();
                    var cliente ='<input type="hidden" class="form-control" id="id_cliente" value="'+data.id_cliente+'"><input type="text" class="form-control" value="'+data.doc+' - '+data.nombre+'" disabled>';
                    $('#seccion-cliente').html(cliente);
                }else{
                    $('#mensaje_cliente').addClass('error').html('Error al registrar al cliente').show(300).delay(3000).hide(300);
                    $('#nombre').focus();
                }
            },
            error:function(){
                $('#mensaje_cliente').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
                $('#nombre').focus();
            }
        });
    });

    function CerrarModal(){
        setTimeout(function(){
            $('#reg_cliente').modal('toggle');
        }, 3500);
    }
    $('#btn_guardarventa').on('click',function(e){
        e.preventDefault();
        var idclient = $('#id_cliente').val();
        var idusuario = $('#id_usuario').val();
        var datosArticulo = document.getElementById('id_documento').value.split('_');
        var idtipodoc = datosArticulo[0];
        var serie = $('#serie').val();
        var numero = $('#numero').val();
        var idforma = $('#id_forma_pago').val();
        var idtipoventa = $('#id_tipo_venta').val();

        if(idtipodoc==4){
            var igv = $('#group-factura #igv').val();
            var subtotal = $('#group-factura #subt').val();
            var subigv = $('#group-factura #subigv').val();
            var total=$('#group-factura #tot').val();
        }

        if(idtipodoc==1){
            var igv = 0.00;
            var subtotal = 0.00;
            var subigv=0.00;
            var total=$('#group-boleta #tot').val();
        }
        ObtenerFechaActual();
        var fecha_actual = ObtenerFechaActual();
        if(idtipoventa==1){
            var fechacredito = "";
            var nrodias = 0;
        }else if(idtipoventa==2){
            var fechacredito = $('#fecha_venta').val();
            var nrodias = ObtenerNroDias(fecha_actual,fechacredito);
        }

        var arrayDetalles = new Array();
        for (var x = 0; x <clicks; x++){
            var detalles = new Object();
            detalles.ID_Producto = $("#idprod-"+idtipodoc+"-"+x).val();
            detalles.Cantidad = $("#cant-"+idtipodoc+"-"+x).val() ;
            detalles.Precio = $("#pventa-"+idtipodoc+"-"+x).val();
            detalles.Descuento = $("#desc-"+idtipodoc+"-"+x).val();
            detalles.Subtotal = $("#subtotal-"+idtipodoc+"-"+x).val() ;
            arrayDetalles.push(detalles);
        }

        var datos = {"ID_Cliente":idclient,"ID_Usuario":idusuario,"ID_Tipo_Documento":idtipodoc,
            "Serie":serie,"Numero":numero,"FechaVenta_Actual":fecha_actual,"ID_Forma_Pago":idforma,
            "FechaVenta_Credito":fechacredito,"Nro_Dias":nrodias,
            "IGV":igv,"Subtotal":subtotal,"SubIGV":subigv,"Total":total,"Detalles":arrayDetalles};

        var token = $("input[name=_token]").val();
        var route = "{{route('ventas.venta.store')}}";

        if(idclient == "" || idusuario== "" || idtipodoc == "" || serie=="" || numero == "" || idforma=="" || arrayDetalles == ""){
            swal({
                    title: "Datos Vacíos",
                    text: "Por favor, llene el formulario",
                    type: "warning"
            });
        }else{
            swal({
                    title: "¿Realizar Venta?",
                    text: "Por favor, revise los datos antes de completar la venta",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                },
                function(){
                    $.ajax({
                        url: route,
                        headers: {'X-CSRF-TOKEN':token},
                        type:'post' ,
                        datatype: 'json',
                        data: datos,
                        success:function(data)
                        {
                            swal({
                                title: '¡Éxito!',
                                text: "La venta se completó con éxito",
                                type: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Otra Venta',
                                cancelButtonText: 'Ver Detalle',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false
                            });
                            console.log(data);
                        },
                        error:function(data){
                            console.log(data);
                        }
                    });
                });
        }
    });
</script>
@endpush