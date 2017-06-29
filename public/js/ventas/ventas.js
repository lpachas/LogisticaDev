$(document).ready(function(){
    CheckIGV();
    $('#id_documento').change(ReiniciarClicks);
    $("#btn_add").click(function(){
        agregar();
        AumentarClicks();
    });
    FechaxTipo("");
    $('#id_tipo_venta').change(function() {
        var id = $('#id_tipo_venta').val();
        FechaxTipo(id);
    }).change();



    DetallesDocumentoDisabled();
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
});
function FechaxTipo(id){
    if(id==1 || id==""){
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#fecha_venta').attr('disabled', 'disabled');
        $('#fecha_venta').datepicker({
            startDate: today,
            Format: "dd-mm-yyyy",
            language: "es",
            orientation: "bottom auto",
            autoclose:"true",
            todayHighlight: true
        });
    }else{
        $('#fecha_venta').removeAttr('disabled');
    }
}

function DetallesDocumentoDisabled(){
    if($('#id_documento').val() == "" ){
        $('#serie').attr('disabled', 'disabled');
        $('#numero').attr('disabled', 'disabled');
    }else{
        $('#serie').removeAttr('disabled');
        $('#numero').removeAttr('disabled');
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



$("#id_documento").change(cargarDatosDoc);

function cargarDatosDoc()
{
    var id = $('#id_documento').val();

    if(id != ""){
        $('#serie').removeAttr('disabled');
        $('#numero').removeAttr('disabled');
        datosTipoDoc = document.getElementById('id_documento').value.split('_');
        $("#numero").val(datosTipoDoc[2]);
        $("#serie").val(datosTipoDoc[1]);
        var id2=datosTipoDoc[0];
        if (id2==4){
            $('#group-factura').show();
            $('#group-boleta').hide();
            LimpiarBoleta();
        }else if(id2==1) {
            $('#group-factura').hide();
            $('#group-boleta').show();
            LimpiarFactura();
        }


    }else{
        $('#serie').attr('disabled', 'disabled');
        $('#numero').attr('disabled', 'disabled');
        $("#numero").val("");
        $("#serie").val("");
    }

}



$('#btn_cliente').on('click',function(e){
    e.preventDefault();
    $('#FormCreateCliente')[0].reset();
    $('#reg_cliente').modal({
        show:true,
        backdrop:'static'
    });
});

$('#id_producto').change(function(e) {
    e.preventDefault();
    var id = $('#id_producto_sel').val();
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
/* variables de factura*/
total=0.00;
detotal = 0.00;
totalIGV = 0.00;
totsubtotal= 0.00;
totalIGV2= 0.00;
subtotal=[];
/* variables de boleta*/
total2 = 0.00;
detotal2 = 0.00
totalsubtotal2= 0.00;
subtotalbol=[];

function agregar(){
    var idprod = $('#id_producto_sel').val();
    var nomprod = $("#nomprod").val();
    var cant=$("#cantidad").val();
    var desc=$("#descuento").val();
    var stock=$("#stock").val();
    var pventa = $("#pventa").val();
    var datosTipoDoc = document.getElementById('id_documento').value.split('_');
    var iddoc = datosTipoDoc[0];
    var fecha_actual='19/06/2017';
    var fechacredito=$('#fecha_venta').val();
    var nrodias = ObtenerNroDias(fecha_actual,fechacredito);
    console.log(nrodias);

    if(idprod !="" && nomprod != "" && cant != "" && desc != "" && pventa != "" && stock != "")
    {
        if(iddoc == 4){
            subtotal[cont] = parseFloat(parseInt(cant) * pventa - desc).toFixed(2);

            if($('#group-factura #total_sale').val() == ""){
                total= parseFloat(total) + parseFloat(subtotal[cont]);
            }else{
                total = parseFloat($('#group-factura #total_sale').val()) + parseFloat(subtotal[cont]);
            }
            detotal = parseFloat(total).toFixed(2);

            totsubtotal = detotal / (1 + parseFloat($('#igv').val()));
            totalIGV2=  parseFloat($('#group-factura #igv').val()) * totsubtotal;
            var fila = '<tr class="selected" id="fila-'+iddoc+'-'+cont+'"><td><input type="hidden" id="stock-'+iddoc+'-'+cont+'" value="'+stock+'"><button type="button" class="btn btn-danger" onclick="eliminar('+iddoc+','+cont+');">X</button><button type="button" id="aceptar_prod-'+iddoc+'-'+cont+'" class="btn btn-primary" onclick="aceptar('+iddoc+','+cont+');" style="display: none;"><i class="fa fa-check"></i></button><button type="button" id="editar_prod-'+iddoc+'-'+cont+'" class="btn btn-warning" onclick="editar('+iddoc+','+cont+');"><i class="fa fa-edit"></i></button></td><td><input type="hidden" id="idprod-'+iddoc+'-'+cont+'" name="idprod[]" value="'+idprod+'">'+nomprod+'</td><td><input type="number" name="cant[]" id="cant-'+iddoc+'-'+cont+'"  value="'+cant+'" disabled></td><td><input type="number" name="pventa[]" id="pventa-'+iddoc+'-'+cont+'" value="'+pventa+'" disabled></td><td><input type="number" name="desc[]" id="desc-'+iddoc+'-'+cont+'" value="'+desc+'" disabled></td><td><input type="text" id="subtotal-'+iddoc+'-'+cont+'" value="'+subtotal[cont]+'" disabled></td></tr>';
            cont++;
            limpiar();

            $("#group-factura #total_sale").val(parseFloat(detotal).toFixed(2));
            $("#group-factura #detalles").append(fila);
            $("#group-factura #tot").html("S/. "+parseFloat(detotal).toFixed(2));
            $("#group-factura #tot").val(parseFloat(detotal).toFixed(2));
            $("#group-factura #subt").html("S/."+parseFloat(totsubtotal).toFixed(2));
            $("#group-factura #subt").val(parseFloat(totsubtotal).toFixed(2));
            $('#group-factura #subigv').html("S/. "+parseFloat(totalIGV2).toFixed(2));
            $("#group-factura #subigv").val(parseFloat(totalIGV2).toFixed(2));
            return detotal;
        }
        if(iddoc==1){
            subtotalbol[cont] = parseFloat(parseInt(cant) * pventa - desc).toFixed(2);
            if($('#group-boleta #total_sale').val() == ""){
                total2= parseFloat(total2) + parseFloat(subtotalbol[cont]);
            }else{
                total2 = parseFloat($('#group-boleta #total_sale').val()) + parseFloat(subtotalbol[cont]);
            }
            detotal2 = parseFloat(total2).toFixed(2);
            var fila = '<tr class="selected" id="fila-'+iddoc+'-'+cont+'"><td><input type="hidden" id="stock-'+iddoc+'-'+cont+'" value="'+stock+'"><button type="button" class="btn btn-danger" onclick="eliminar('+iddoc+','+cont+');">X</button><button type="button" id="aceptar_prod-'+iddoc+'-'+cont+'" class="btn btn-primary" onclick="aceptar('+iddoc+','+cont+');" style="display: none;"><i class="fa fa-check"></i></button><button type="button" id="editar_prod-'+iddoc+'-'+cont+'" class="btn btn-warning" onclick="editar('+iddoc+','+cont+');"><i class="fa fa-edit"></i></button></td><td><input type="hidden" id="idprod-'+iddoc+'-'+cont+'" name="idprod[]" value="'+idprod+'">'+nomprod+'</td><td><input type="number" name="cant[]" id="cant-'+iddoc+'-'+cont+'"  value="'+cant+'" disabled></td><td><input type="number" name="pventa[]" id="pventa-'+iddoc+'-'+cont+'" value="'+pventa+'" disabled></td><td><input type="number" name="desc[]" id="desc-'+iddoc+'-'+cont+'" value="'+desc+'" disabled></td><td><input type="text" id="subtotal-'+iddoc+'-'+cont+'" value="'+subtotalbol[cont]+'" disabled></td></tr>';
            cont++;
            limpiar();
            $("#group-boleta #total_sale").val(parseFloat(detotal2).toFixed(2));
            $("#group-boleta #detalles").append(fila);
            $("#group-boleta #tot").html("S/. "+parseFloat(detotal2).toFixed(2));
            $("#group-boleta #tot").val(parseFloat(detotal2).toFixed(2));
            return detotal2;
        }

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
    $("#id_producto").val("");
    $("#id_marca").val("");
    $("#nom_marca").val("");
    $("#nom_modelo").val("");
    $("#nom_categoria").val("");
    $("#id_modelo").val("");
    $("#id_categoria").val("");
    $("#id_producto_sel").val("");

}

function eliminar(iddoc,id){
    $.alertable.confirm("¿Está seguro de elminar este producto de la lista?").then(function() {
        $('#id_documento').change(ReiniciarClicks);
        ReducirClicks();
        if(iddoc==4){
            total = parseFloat(detotal) - parseFloat(subtotal[id]);
            detotal = parseFloat(total).toFixed(2);
            totsubtotal = detotal / (1 + parseFloat($('#igv').val()));
            totalIGV2=  parseFloat($('#igv').val()) * totsubtotal;
            $("#group-factura #total_sale").val(parseFloat(detotal).toFixed(2));
            $("#group-factura #tot").html("S/. "+parseFloat(detotal).toFixed(2));
            $("#group-factura #tot").val(parseFloat(detotal).toFixed(2));
            $("#group-factura #subt").html("S/."+parseFloat(totsubtotal).toFixed(2));
            $("#group-factura #subt").val(parseFloat(totsubtotal).toFixed(2));
            $('#group-factura #subigv').html("S/. "+parseFloat(totalIGV2).toFixed(2));
            $("#group-factura #subigv").val(parseFloat(totalIGV2).toFixed(2));
            $("#group-factura #fila-"+iddoc+"-"+ id).remove();
            evaluar();
            return detotal;
        }
        if(iddoc==1){
            total2 = parseFloat(detotal2) - parseFloat(subtotalbol[id]);
            detotal2 = parseFloat(total2).toFixed(2);
            $("#group-boleta #tot").html("S/. "+parseFloat(detotal2).toFixed(2));
            $("#group-boleta #tot").val(parseFloat(detotal2).toFixed(2));
            $("#group-boleta #total_sale").val(parseFloat(detotal2).toFixed(2));
            $("#group-boleta #fila-"+iddoc+"-"+ id).remove();
            evaluar();
            return detotal2;
        }

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
        $('#group-factura check').click(function() {
            if ($(this).is(':checked')) {
                $('#group-factura #igv').removeAttr('disabled');
            }else {
                $('#group-factura #igv').attr('disabled', 'disabled');
            }
        });
    });
}

$('#igv').change(CalcularTotalIGV);
function CalcularTotalIGV(){
    /*1900.00*/
    totsubtotal = detotal / (1 + parseFloat($('#group-factura #igv').val()));
    /* 1900.00/0.12 = totsubtotal = 1696.43 */
    totalIGV2=  parseFloat($('#group-factura #igv').val()) * totsubtotal; /* 0.12 * 1696.43 = 203.57  */
    $("#group-factura #subigv").html("S/. "+parseFloat(totalIGV2).toFixed(2));
    $("#group-factura #subigv").val(parseFloat(totalIGV2).toFixed(2));
    $("#group-factura #subt").html("S/. "+ parseFloat(totsubtotal).toFixed(2));
    $("#group-factura #subt").val(parseFloat(totsubtotal).toFixed(2));
    $("#group-factura #tot").html("S/. " + parseFloat(detotal).toFixed(2));
    $("#group-factura #tot").val(parseFloat(detotal).toFixed(2));
    $("#group-factura #total_sale").val(parseFloat(detotal).toFixed(2));
}


function editar(iddoc,id){
    if(iddoc!=""){
        $('#editar_prod-'+iddoc+'-'+id).hide();
        $('#aceptar_prod-'+iddoc+'-'+id).show();
        $('#cant-'+iddoc+'-'+id).removeAttr('disabled');
        $('#pventa-'+iddoc+'-'+id).removeAttr('disabled');
        $('#desc-'+iddoc+'-'+id).removeAttr('disabled');
        $('#cant-'+iddoc+'-'+id).change(ValidarCantidad_NewStock);
        function ValidarCantidad_NewStock(){
            var cant = $('#cant-'+iddoc+'-'+id).val();
            var stock = parseInt($('#stock-'+iddoc+'-'+id).val());
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


}

function aceptar(iddoc,id){
    $('#editar_prod-'+iddoc+'-'+id).show();
    $('#aceptar_prod-'+iddoc+'-'+id).hide();
    $('#cant-'+iddoc+'-'+id).attr('disabled', 'disabled');
    $('#pventa-'+iddoc+'-'+id).attr('disabled','disabled');
    $('#desc-'+iddoc+'-'+id).attr('disabled','disabled');
    var cant=$('#cant-'+iddoc+'-'+id).val();
    var desc=$('#desc-'+iddoc+'-'+id).val();
    var stock=$('#stock-'+iddoc+'-'+id).val();
    var pventa = $('#pventa-'+iddoc+'-'+id).val();
    var totalant = $('#subtotal-'+iddoc+'-'+id).val();
    if(iddoc==4){
        var totaltotal = $('#group-factura #total_sale').val();
        var nuevocalculo = parseFloat(parseInt(cant) * pventa - desc).toFixed(2);
        $('#subtotal-'+iddoc+'-'+id).val(parseFloat(nuevocalculo).toFixed(2));
        var total_final = parseFloat(totaltotal) - parseFloat(totalant) + parseFloat(nuevocalculo);
        totsubtotal = total_final / (1 + parseFloat($('#group-factura #igv').val()));
        totalIGV2=  parseFloat($('#group-factura #igv').val()) * totsubtotal;
        $("#group-factura #subigv").html("S/. "+parseFloat(totalIGV2).toFixed(2));
        $("#group-factura #subigv").val(parseFloat(totalIGV2).toFixed(2));
        $("#group-factura #subt").html("S/. "+ parseFloat(totsubtotal).toFixed(2));
        $("#group-factura #subt").val(parseFloat(totsubtotal).toFixed(2));
        $("#group-factura #tot").html("S/. " + parseFloat(total_final).toFixed(2));
        $("#group-factura #tot").val(parseFloat(total_final).toFixed(2));
        $("#group-factura #total_sale").val(total_final);
    }
    if(iddoc==1){
        var totaltotal = $('#group-boleta #total_sale').val();
        var nuevocalculo = parseFloat(parseInt(cant) * pventa - desc).toFixed(2);
        $('#subtotal-'+iddoc+'-'+id).val(parseFloat(nuevocalculo).toFixed(2));
        var total_final = parseFloat(totaltotal) - parseFloat(totalant) + parseFloat(nuevocalculo);


        $("#group-boleta #tot").html("S/. "+parseFloat(total_final).toFixed(2));
        $("#group-boleta #tot").val(parseFloat(total_final).toFixed(2));
        $("#group-boleta #total_sale").val(total_final);
    }
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

function ReiniciarClicks(){
    clicks=0;
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
    console.log(fecha_inicio+'-'+fecha_fin);
    var diff = fechaFin - fechaInicio;
    var dif = diff/(1000*60*60*24);
    return dif;
}

function LimpiarFactura(){
    $('#group-factura tbody').html("");
    $("#group-factura #total_sale").val("");
    $("#group-factura #tot").html("");
    $("#group-factura #tot").val("");
    $("#group-factura #subt").html("");
    $("#group-factura #subt").val("");
    $('#group-factura #subigv').html("");
    $("#group-factura #subigv").val("");

}

function LimpiarBoleta(){
    $('#group-boleta tbody').html("");
    $("#group-boleta #total_sale").val("");
    $("#group-boleta #tot").html("");
    $("#group-boleta #tot").val("");

}