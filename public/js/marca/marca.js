$(document).ready(function(){
    IniciarMarca();
});
$("#frmsearch").on("submit",function(e){
    e.preventDefault();
    var url = $(this).attr('action');
    var data = $(this).serializeArray();
    var get = $(this).attr('method');

    $.ajax({
        type: get,
        url: url,
        data: data,

    }).done(function(data){
        $("#detalle_marcas").html(data);
    });
});

function IniciarMarca(){
    var search = "";
    getMarcas(1,search);
}
//script para pagination
var click = $(document).on('click','.pagination li a',function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getMarcas(page,$("#search").val());
});

//script para obtener las categorias con la pagination en ajax
function getMarcas(page,search)
{
    var url ="{{url('marca/getmarcasinfosearch')}}";
    $.ajax({
        type:'get',
        url: url+'?page='+page,
        data:{'search':search}
    }).done(function(data){
        $("#detalle_marcas").html(data);
    });
}

$('#btn_newmarca').on('click',function(e){
    $('#FormCreateMarca')[0].reset();
    $('#reg_marca').modal({
        show:true,
        backdrop:'static'
    });
});
$('#btnregistrar_marca').on('click',function(e)
{
    var nombre = $('#nombre_marca').val();
    var descripcion = $('#descripcion_marca').val();
    var token = $("input[name=_token]").val();
    var route = "{{route('almacen.marca.store')}}";
    var dataString = "Nombre="+nombre+"&Descripcion="+descripcion;
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN':token},
        type:'post' ,
        datatype: 'json',
        data: dataString,
        success:function(data)
        {
            if(data.success == 'true')
            {
                alert('ok');
            }
        },
        error:function(data)
        {
            $('#error').html('Ha ocurrido un error al registrar.');
            $('#message-error').fadeIn().show(200).delay(2500).hide(200);
        }
    });
});

var EditarMarca = function(id) {
    var route = "{{url('almacen/marca')}}/" + id + "/edit";
    $.get(route, function (data) {
        $('#id_marca').val(data.ID_Marca);
        $('#nombre_edit').val(data.Nombre);
        $('#descripcion_edit').val(data.Descripcion);
        $('#edit_marca_mod').modal({
            show: true,
            backdrop: 'static'
        });
        return false;
    });
}

$("#btnedit_marca").on('click',function(){
    var id = $("#id_marca").val();
    var nombre = $("#nombre_edit").val();
    var descripcion = $("#descripcion_edit").val();
    var route = "{{url('almacen/marca')}}/"+id+"";
    var token = $("#token").val();
    var dataString = {'Nombre':nombre,'Descripcion':descripcion};
    $.ajax({
        url:route,
        headers: {'X-CSRF-TOKEN':token},
        type:'PUT',
        dataType: 'json',
        data: dataString,
        success: function(data){
            if(data.success == 'true') {
                alert('ok');
            }
        }
    });
});