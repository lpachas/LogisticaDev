$(document).ready(function(){
    CheckIGV();
    $("#btn_add").click(function(){
        agregar();
        AumentarClicks();
    });
    $('#id_tipo_venta').change(function(e) {
        var id = $('#id_tipo_venta').val();
        FechaxTipo(id);
    });
});
function FechaxTipo(id){
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    if(id==1){
        $('#fecha_venta').attr('disabled', 'disabled');
        $('#fecha').datepicker({
            startDate: today,
            format: "yyyy-mm-dd",
            language: "es",
            orientation: "bottom auto",
            autoclose:"true",
            todayHighlight: true
        });
        $('#fecha').datepicker('setDate', today);
    }else{
        $('#fecha_venta').removeAttr('disabled');
        $('#fecha').datepicker({
            startDate: new Date(),
            format: "yyyy-mm-dd",
            language: "es",
            orientation: "bottom auto",
            autoclose:"true",
            todayHighlight: true
        });
    }
}
$('#cantidad').change(ValidarCantidad_Stock);
function ValidarCantidad_Stock(){
    var cant = $('#cantidad').val();
    var stock = parseInt($('#stock').val());
    if(stock < cant){
        swal({
            title: "Error!",
            text: "La cantidad debe ser menor que el stock",
            type: "error",
            confirmButtonText: "OK"
        });
        $('#pventa').attr('disabled', 'disabled');
        $('#descuento').attr('disabled', 'disabled');
    }else if(stock > cant){
        $('#pventa').removeAttr('disabled');
        $('#descuento').removeAttr('disabled');
    }else if(stock == cant){
        $('#pventa').removeAttr('disabled');
        $('#descuento').removeAttr('disabled');
    }
}

$('#descuento').change(CalcularParcial);
function CalcularParcial(){
    var cum = parseInt($('#cantidad').val()) * $('#pventa').val();
    var parcial = parseFloat(cum - $('#descuento').val()).toFixed(2);
    $('#parcial').val(parcial);
}

function CargarSelectMarcas(){
    var url ="create/getMarcas";
    var search = "";
    $.ajax({
        type:'get',
        url: url,
    }).done(function(data){
        var lista = '<div class="form-group"><label>Marca:</label> <select id="id_marca" class="form-control js-example-basic-single select2-hidden-accessible" tabindex="-1" aria-hidden="true"> <option value="">--Seleccione una Marca--</option> <option value="">Marca 1</option> <option value="">Marca 2</option> </select> <span class="select2 select2-container select2-container--default select2-container--focus" dir="ltr" style="width: 235px;"> <span class="selection"> <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-id_marca-container"> <span class="select2-selection__rendered" id="select2-id_marca-container" title="--Seleccione una Marca--">--Seleccione una Marca--</span> <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span> </span> </span> <span class="dropdown-wrapper" aria-hidden="true"></span> </span> </div>';
        $('#cont-marca').append(lista);
    });
}


$("#id_documento").change(cargarDatosDoc);

function cargarDatosDoc()
{
    datosTipoDoc = document.getElementById('id_documento').value.split('_');
    $("#numero").val(datosTipoDoc[2]);
    $("#serie").val(datosTipoDoc[1]);
}

$('#btn_cliente').on('click',function(e){
    e.preventDefault();
    $('#FormCreateCliente')[0].reset();
    $('#reg_cliente').modal({
        show:true,
        backdrop:'static'
    });
});

function CerrarModal(){
    setTimeout(function(){
        $('#reg_cliente').modal('toggle');
    }, 3500);
}


$('#id_producto').change(function(e) {
    e.preventDefault();
    var id = $('#id_producto').val();
    var route="create/ByProducto/"+id;
    var token = $("input[name=_token]").val();
    $.ajax({
        url: route,
        type:'post' ,
        headers: {'X-CSRF-TOKEN': token},
        datatype: 'json',
        data: id,
        success:function(data)
        {
            if (data.success=='true'){
                /*console.log(data.res[0].ID_Producto);*/
                $('#stock').val(data.res[0].Stock);
                $('#pventa').val(data.res[0].PU_Ferreteria);
                $('#nomprod').val(data.res[0].Producto);
            }else{
                console.log('error');
            }

        }
    });
});

$('#descuento').change(ActivarAdd);
function ActivarAdd(){
    $('#btn_add').removeAttr('disabled');
}


var cont = 0;
total=0.00;
detotal = 0.00;
totalIGV = 0.00;
subtotal=[];
function agregar(){
    var idprod = $('#id_producto').val();
    var nomprod = $("#nomprod").val();
    var cant=$("#cantidad").val();
    var desc=$("#descuento").val();
    var stock=$("#stock").val();
    var pventa = $("#pventa").val();

    if(idprod !="" && nomprod != "" && cant != "" && desc != "" && pventa != "" && stock != "")
    {
        subtotal[cont] = parseFloat(parseInt(cant) * pventa - desc).toFixed(2);
        if($('#total_sale').val() == ""){
            total= parseFloat(total) + parseFloat(subtotal[cont]); /* Me quedo aquí :) 7:07 am */
        }else{
            total = parseFloat($('#total_sale').val()) + parseFloat(subtotal[cont]);
        }
        /*console.log(total);*/
        detotal = parseFloat(total).toFixed(2);
        totalIGV = detotal - detotal * parseFloat($('#igv').val());
        var fila = '<tr class="selected" id="fila'+cont+'"><td><input type="hidden" id="stock-'+cont+'" value="'+stock+'"><button type="button" class="btn btn-danger" onclick="eliminar('+cont+');">X</button><button type="button" id="aceptar_prod-'+cont+'" class="btn btn-primary" onclick="aceptar('+cont+');" style="display: none;"><i class="fa fa-check"></i></button><button type="button" id="editar_prod-'+cont+'" class="btn btn-warning" onclick="editar('+cont+');"><i class="fa fa-edit"></i></button></td><td><input type="hidden" id="idprod-'+cont+'" name="idprod[]" value="'+idprod+'">'+nomprod+'</td><td><input type="number" name="cant[]" id="cant-'+cont+'"  value="'+cant+'" disabled></td><td><input type="number" name="pventa[]" id="pventa-'+cont+'" value="'+pventa+'" disabled></td><td><input type="number" name="desc[]" id="desc-'+cont+'" value="'+desc+'" disabled></td><td><input type="text" id="subtotal-'+cont+'" value="'+subtotal[cont]+'" disabled></td></tr>';
        cont++;
        limpiar();
        $("#total").html("S/. "+totalIGV);
        $("#total").val(totalIGV);
        $("#total_sale").val(detotal);
        $("#detalles").append(fila);
        return detotal;
    }else{
        alert('Error al ingresar el detalle de la venta, por favor, revise los datos del artículo');
    }
}

function limpiar(){
    $("#cantidad").val("0");
    $("#pventa").val("");
    $("#pventa").attr('disabled','disabled');
    $("#descuento").val("");
    $("#descuento").attr('disabled','disabled');
    $("#parcial").val("");
    $('#btn_add').attr('disabled','disabled');
    $('#stock').val("");

}

function eliminar(id){
    $.alertable.confirm("¿Está seguro de elminar este producto de la lista?").then(function() {
        ReducirClicks();
        total = parseFloat(total) - parseFloat(subtotal[id]);
        detotal = parseFloat(total).toFixed(2);
        totalIGV = detotal - detotal * parseFloat($('#igv').val());
        $("#total").html("S/. " + totalIGV);
        $("#total").val(totalIGV);
        $("#total_sale").val(detotal);
        $("#fila" + id).remove();
        evaluar();
        return detotal;
    });
}

function evaluar(){
    if(total>1){
        $("#guardar").show();
    }else{
        $("#guardar").hide();
    }
}

function CheckIGV(){
    $(function() {
        $('#check').click(function() {
            if ($(this).is(':checked')) {
                $('#igv').removeAttr('disabled');
            }else {
                $('#igv').attr('disabled', 'disabled');
            }
        });
    });
}

$('#igv').change(CalcularTotalIGV);
function CalcularTotalIGV(){
    totalIGV = detotal - detotal * parseFloat($('#igv').val());
    $("#total").html("S/. " + totalIGV);
    $("#total").val(totalIGV);
    $("#total_sale").val(detotal);
}


function editar(id){
    $('#editar_prod-'+id).hide();
    $('#aceptar_prod-'+id).show();
    $('#cant-'+id).removeAttr('disabled');
    $('#pventa-'+id).removeAttr('disabled');
    $('#desc-'+id).removeAttr('disabled');

    $('#cant-'+id).change(ValidarCantidad_NewStock);
    function ValidarCantidad_NewStock(){
        var cant = $('#cant-'+id).val();
        var stock = parseInt($('#stock-'+id).val());
        if(stock < cant){
            swal({
                title: "Error!",
                text: "La cantidad debe ser menor que el stock",
                type: "error",
                confirmButtonText: "OK"
            });
        }
    }

}

function aceptar(id){
    /*Github */
    $('#editar_prod-'+id).show();
    $('#aceptar_prod-'+id).hide();
    $('#cant-'+id).attr('disabled', 'disabled');
    $('#pventa-'+id).attr('disabled','disabled');
    $('#desc-'+id).attr('disabled','disabled');
    var cant=$("#cant-"+id).val();
    var desc=$("#desc-"+id).val();
    var stock=$("#stock-"+id).val();
    var pventa = $("#pventa-"+id).val();
    var totalant = $("#subtotal-"+id).val();
    var totaltotal = $('#total_sale').val();
    /*console.log('total_sale='+totaltotal+'-cant='+cant+'-desc='+desc+'-stock='+stock+'-pventa='+pventa+'-totalant='+totalant);*/

    var total_final = parseFloat(totaltotal) - parseFloat(totalant) + parseFloat(parseFloat(parseInt(cant) * pventa - desc).toFixed(2));
    var totalIGV2 = total_final - total_final * parseFloat($('#igv').val());
    /*console.log(total_final+'-'+totalIGV2);*/
    $("#total").html("S/. " + totalIGV2);
    $("#total").val(totalIGV2);
    $("#subtotal-"+id).val(parseFloat(parseFloat(parseInt(cant) * pventa - desc).toFixed(2)).toFixed(2));
    $("#total_sale").val(total_final);
}




var clicks = 0;
function AumentarClicks(){
    clicks=clicks+1
    return clicks;
}

function ReducirClicks(){
    clicks=clicks-1
    return clicks;
}

function ObtenerFechaActual(){
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth()+1; //hoy es 0!
    var yyyy = hoy.getFullYear();

    if(dd<10) {
        dd='0'+dd
    }

    if(mm<10) {
        mm='0'+mm
    }

    hoy = yyyy+'-'+mm+'-'+dd;
    return hoy;
}

function ObtenerNroDias(fecha_inicio,fecha_fin){
    var fechaInicio = new Date(fecha_inicio).getTime();
    var fechaFin    = new Date(fecha_fin).getTime();

    var diff = fechaFin - fechaInicio;
    var dif = diff/(1000*60*60*24);
    return dif;
}
