@extends('layouts.admin')
@section('title','Cliente')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <button id="btn_cliente" class="btn alert-success"><i class="fa fa-plus"></i> Nuevo Cliente</button>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                <form action="{{url('cliente/getclientesInfo')}}" method="get" id="frmsearch">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Cliente">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Lista de Clientes</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_clientes"></div>
            </div>
        </div>
    </div>
    @include('ventas.cliente.modal')
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        IniciarCliente();
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
            $("#detalle_clientes").html(data);
        });
    });

    function IniciarCliente(){
        var search = "";
        getClientes(1,search);
    }
    //script para pagination
    var click = $(document).on('click','.pagination li a',function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getClientes(page,$("#search").val());
    });

    function getClientes(page,search)
    {
        var url ="{{url('cliente/getclientesinfosearch')}}";
        $.ajax({
            type:'get',
            url: url+'?page='+page,
            data:{'search':search}
        }).done(function(data){
            $("#detalle_clientes").html(data);
        });
    }
    $('#btn_cliente').on('click',function(e){
        e.preventDefault();
        $('#FormCreateCliente')[0].reset();
        $('#reg_cliente').modal({
            show:true,
            backdrop:'static'
        });
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
                    $('#FormCreateCliente')[0].reset();
                    IniciarCliente();
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

    var EditarCliente = function(id) {
        var route = "{{url('ventas/cliente')}}/" + id + "/edit";
        $.get(route, function (data) {
            $('#id_cliente').val(data.ID_Cliente);
            $('#nombre_edit').val(data.Nombre);
            $('#direccion_edit').val(data.Direccion);
            $('#doc_edit').val(data.RUC_DNI);
            $('#telefono_edit').val(data.Telefono);
            $('#zona_edit').val(data.Zona);
            $('#edit_cliente_mod').modal({
                show: true,
                backdrop: 'static'
            });
            return false;
        });
    }

    $("#btnedit_cliente").on('click',function(e){
        e.preventDefault();
        $('#mensaje_cliente_edit').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
        var id = $("#id_cliente").val();
        var nom = $("#nombre_edit").val();
        var dir = $("#direccion_edit").val();
        var doc = $("#doc_edit").val();
        var tel = $("#telefono_edit").val();
        var zona = $("#zona_edit").val();
        var route = "{{url('ventas/cliente')}}/"+id+"";
        var token = $("#token").val();
        var dataString = {'Nombre':nom,'Direccion':dir,'RUC_DNI':doc,'Telefono':tel,'Zona':zona};
        $.ajax({
            url:route,
            headers: {'X-CSRF-TOKEN':token},
            type:'PUT',
            dataType: 'json',
            data: dataString,
            success: function(data){
                if(data.success == 'true') {
                    $('#mensaje_cliente_edit').addClass('exito').html("El cliente <b>"+data.Nombre+"</b> ha sido actualizado con éxito.").show(300).delay(3000).hide(300);
                    IniciarCliente();
                }
            }
        });
    });

    var EliminarCliente = function (id,name) {
        $.alertable.confirm("¿Está seguro de elminar el Cliente?: "+name).then(function(){
            var route = "{{url('ventas/cliente')}}/"+id+"";
            var token = $("#token").val();
            $.ajax({
                url:route,
                headers:{'X-CSRF-TOKEN' : token},
                type: 'DELETE',
                dataType: 'json',
                success: function(data){
                    if(data.success == 'true'){
                        $('#detalle_clientes').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                        IniciarCliente();
                    }
                }
            });
        });
    }

</script>
@endpush
