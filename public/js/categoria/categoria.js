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
        $("#detalle_categoria").html(data);
    });
});

$(document).ready(function(){
    IniciarMarca();
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
        $("#detalle_categoria").html(data);
    });
}

