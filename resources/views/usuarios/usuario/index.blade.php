@extends('layouts.admin')
@section('title','Usuarios')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <button class="btn alert-success" id="btn_newusuario" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nuevo Usuario</button>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                    <form action="{{url('usuario/getusuariosInfo')}}" method="get" id="frmsearch">
                        <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Usuario">
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
                    <h2>Lista de Usuario</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_usuarios"></div>
            </div>
        </div>
    </div>
    @include('usuarios.usuario.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            IniciarUsuario();
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
                $("#detalle_usuarios").html(data);
            });
        });

        function IniciarUsuario(){
            $('#detalle_usuarios').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
            var search = "";
            getUsuarios(1,search);
        }
        //script para pagination
        var click = $(document).on('click','.pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getUsuarios(page,$("#search").val());
        });

        function getUsuarios(page,search)
        {
            var url ="{{url('usuario/getusuariosinfosearch')}}";
            $.ajax({
                type:'get',
                url: url+'?page='+page,
                data:{'search':search}
            }).done(function(data){
                $("#detalle_usuarios").html(data);
            });
        }

        $('#btn_newusuario').on('click',function(e){
            $('#FormCreateUsuario')[0].reset();
            $('.icheckbox_flat-green').removeClass('checked');
            $('#reg_usuario').modal({
                show:true,
                backdrop:'static'
            });
        });

        $('#btnregistrar_usuario').on('click',function(e){
            e.preventDefault();
            var id_trabj = $('#ID_Trabajador').val();
            var usuario = $('#name').val();
            var password = $('#password').val();
            var email = $('#email').val();
            var desc = $('#descripcion').val();
            var token = $("input[name=_token]").val();
            var id_tipo = [];
            $('.check_class').each(function(){
                if($(this).is(":checked")){
                        id_tipo.push($(this).val());
                }
            });
            id_tipo = id_tipo.toString();
            var cadena = {'ID_Trabajador':id_trabj,'ID_Tipo_Usuario':id_tipo,'name':usuario,'email':email,'password':password,'Descripcion':desc};
            console.log(cadena);
            var route = "{{route('usuarios.usuario.store')}}";
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN':token},
                type:'post' ,
                datatype: 'json',
                data: cadena,
                success:function(data)
                {
                    if(data.success == 'true')
                    {
                        $('#mensaje_usuario').addClass('exito').html("El Usuario ha sido registrado").show(300).delay(3000).hide(300);
                        $('#FormCreateUsuario')[0].reset();
                        IniciarUsuario();
                    }else{
                        $('#mensaje_usuario').addClass('error').html('Error al registrar al usuario').showusuarioselay(3000).hide(300);
                        $('#name').focus();
                    }
                },
                error:function(){
                    $('#mensaje_usuario').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
                    $('#name').focus();
                    IniciarUsuario();
                }
            });

        });


        var EditarUsuario = function(id) {
            var route = "{{url('usuarios/usuario')}}/" + id + "/edit";
            $('.check_class_edit').prop('checked',false);
            $.get(route, function (data) {
                $('#id_usuario_edit').val(data.ID_USUARIO);
                $('#ID_Trabajador_edit').val(data.ID_TRABAJADOR);
                $('#Nombre_Trabajador_edit').val(data.DATOS);
                $('#name_edit').val(data.USUARIO);
                $('#email_edit').val(data.EMAIL);
                $('#descripcion_edit').val(data.DESCRIPCION);

                var tipos_string = data.TIPOS;
                var tipos = tipos_string.split(',');
                var cont = 0;
                while(cont < tipos.length){
                    $('#check_edit_'+tipos[cont]).val(tipos[cont]);
                    $('#check_edit_'+tipos[cont]).prop('checked',true);
                    cont++;
                }
                $('#edit_usuario').modal({
                    show: true,
                    backdrop: 'static'
                });
                return false;
            });
        }

        $("#btneditar_usuario").on('click',function(e){
            e.preventDefault();
            $('#mensaje_trabajador_edit').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var id = $("#id_usuario_edit").val();
            var id_trab = $('#ID_Trabajador_edit').val();
            var usuario = $("#name_edit").val();
            var email = $('#email_edit').val();
            var id_tipo = [];
            $('.check_class_edit').each(function(){
                if($(this).is(":checked")){
                    id_tipo.push($(this).val());
                }
            });
            id_tipo = id_tipo.toString();
            var desc = $('#descripcion_edit').val();
            var route = "{{url('usuarios/usuario')}}/"+id+"";
            var token = $("#token").val();

            var dataString = {'ID_Trabajador':id_trab,'name':usuario,'ID_Tipo_Usuario':id_tipo,'email':email,'Descripcion':desc};
            console.log(dataString);

            $.ajax({
                url:route,
                headers: {'X-CSRF-TOKEN':token},
                type:'PUT',
                dataType: 'json',
                data: dataString,
                success: function(data){
                    if(data.success == 'true') {
                        $('#mensaje_usuario_edit').addClass('exito').html("El usuario ha sido actualizado con éxito.").show(300).delay(3000).hide(300);
                        IniciarUsuario();
                    }

                }
            });
        });

        var EliminarUsuario = function (id,name) {
            $.alertable.confirm("¿Está seguro de Eliminar al Usuario?: "+name).then(function(){
                var route = "{{url('usuarios/usuario')}}/"+id+"";
                var token = $("#token").val();

                $.ajax({
                    url:route,
                    headers:{'X-CSRF-TOKEN' : token},
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        if(data.success == 'true'){
                            $('#detalle_usuarios').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                            IniciarUsuario();
                        }
                    }
                });
            });
        }
    </script>
@endpush
