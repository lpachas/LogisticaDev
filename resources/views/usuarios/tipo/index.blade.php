@extends('layouts.admin')
@section('title','Tipos de Usuario')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <button class="btn alert-success" id="btn_newtipo" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nuevo Tipo</button>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                    <form action="{{url('tipo/gettiposInfo')}}" method="get" id="frmsearch">
                        <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Tipo">
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
                    <h2>Lista de Tipos</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_tipos"></div>
            </div>
        </div>
    </div>
    @include('usuarios.tipo.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            IniciarTipo();
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
                $("#detalle_tipos").html(data);
            });
        });

        function IniciarTipo(){
            $('#detalle_tipos').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
            var search = "";
            getTipos(1,search);
        }
        //script para pagination
        var click = $(document).on('click','.pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getTipos(page,$("#search").val());
        });

        function getTipos(page,search)
        {
            var url ="{{url('tipo/gettiposinfosearch')}}";
            $.ajax({
                type:'get',
                url: url+'?page='+page,
                data:{'search':search}
            }).done(function(data){
                $("#detalle_tipos").html(data);
            });
        }

        $('#btn_newtipo').on('click',function(e){
            $('#FormCreateTipo')[0].reset();
            $('#reg_tipo').modal({
                show:true,
                backdrop:'static'
            });
        });

        $('#btnregistrar_tipo').on('click',function (e)
        {
            e.preventDefault();
            $('#mensaje_tipo').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var nombre = $('#nombre').val();
            var token = $("input[name=_token]").val();
            var route = "{{route('usuarios.tipo.store')}}";
            var dataString = {'Nombre':nombre};
            if(nombre==""){
                $('#mensaje_tipo').addClass('error').html('Ingrese un nombre para el tipo').show(300).delay(3000).hide(300);
                $('#nombres').focus();
            }else{
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
                            $('#mensaje_tipo').addClass('exito').html("El tipo de usuario se ha sido registrado").show(300).delay(3000).hide(300);
                            $('#FormCreateTipo')[0].reset();
                            IniciarTipo();
                        }else{
                            $('#mensaje_tipo').addClass('error').html('Error al registrar el tipo').show(300).delay(3000).hide(300);
                            $('#nombres').focus();
                        }
                    },
                    error:function(){
                        $('#mensaje_tipo').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
                        $('#nombre').focus();
                        IniciarTipo();
                    }
                });
            }

        });

        var EditarTipo = function(id) {
            var route = "{{url('usuarios/tipo')}}/" + id + "/edit";
            $.get(route, function (data) {
                $('#id_tipo').val(data.ID_Tipo_Usuario);
                $('#nombre_edit').val(data.Nombre);
                $('#edit_tipo_mod').modal({
                    show: true,
                    backdrop: 'static'
                });
                return false;
            });
        }

        $("#btnedit_tipo").on('click',function(e){
            e.preventDefault();
            $('#mensaje_tipo_edit').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var id = $("#id_tipo").val();
            var nombre = $("#nombre_edit").val();
            var route = "{{url('usuarios/tipo')}}/"+id+"";
            var token = $("#token").val();
            var dataString = {'Nombre':nombre};
            $.ajax({
                url:route,
                headers: {'X-CSRF-TOKEN':token},
                type:'PUT',
                dataType: 'json',
                data: dataString,
                success: function(data){
                    if(data.success == 'true') {
                        $('#mensaje_tipo_edit').addClass('exito').html("El tipo ha sido actualizado con éxito.").show(300).delay(3000).hide(300);
                        IniciarTipo();
                    }
                }
            });
        });

        var EliminarTipo = function (id,name) {
            $.alertable.confirm("¿Está seguro de eliminar el tipo?: "+name).then(function(){
                var route = "{{url('usuarios/tipo')}}/"+id+"";
                var token = $("#token").val();

                $.ajax({
                    url:route,
                    headers:{'X-CSRF-TOKEN' : token},
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        if(data.success == 'true'){
                            $('#detalle_tipos').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                            IniciarTipo();
                        }
                    }
                });
            });
        }
    </script>
@endpush
