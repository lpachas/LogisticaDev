@extends('layouts.admin')
@section('title','Trabajadores')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <button class="btn alert-success" id="btn_newtrabajador" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nuevo Trabajador</button>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                    <form action="{{url('trabajador/gettrabajadoresInfo')}}" method="get" id="frmsearch">
                        <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Trabajador">
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
                    <h2>Lista de Trabajadores</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_trabajadores"></div>
            </div>
        </div>
    </div>
    @include('usuarios.trabajador.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            IniciarTrabajador();
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
                $("#detalle_trabajadores").html(data);
            });
        });

        function IniciarTrabajador(){
            $('#detalle_trabajadores').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
            var search = "";
            getTrabajadores(1,search);
        }
        //script para pagination
        var click = $(document).on('click','.pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getTrabajadores(page,$("#search").val());
        });

        function getTrabajadores(page,search)
        {
            var url ="{{url('trabajador/gettrabajadoresinfosearch')}}";
            $.ajax({
                type:'get',
                url: url+'?page='+page,
                data:{'search':search}
            }).done(function(data){
                $("#detalle_trabajadores").html(data);
            });
        }

        $('#btn_newtrabajador').on('click',function(e){
            $('#FormCreateTrabajador')[0].reset();
            $('#reg_trabajador').modal({
                show:true,
                backdrop:'static'
            });
        });

        $('#btnregistrar_trabajador').on('click',function (e)
        {
            e.preventDefault();
            $('#mensaje_trabajador').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var nombres = $('#nombres').val();
            var ap_pat = $('#apellido_paterno').val();
            var ap_mat = $('#apellido_materno').val();
            var dni = $('#dni').val();
            var cargo = $('#cargo').val();
            var sueldo = $('#sueldo').val();
            var token = $("input[name=_token]").val();
            var route = "{{route('usuarios.trabajador.store')}}";
            var dataString = {'Nombre':nombres,'Ap_Paterno':ap_pat,'Ap_Materno':ap_mat,'DNI':dni,'Cargo':cargo,'Sueldo_Base':sueldo};

            console.log(dataString);

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
                        $('#mensaje_trabajador').addClass('exito').html("El Trabajador ha sido registrado").show(300).delay(3000).hide(300);
                        $('#FormCreateTrabajador')[0].reset();
                        IniciarTrabajador();
                    }else{
                        $('#mensaje_trabajador').addClass('error').html('Error al registrar al trabajador').show(300).delay(3000).hide(300);
                        $('#nombres').focus();
                    }
                },
                error:function(){
                    $('#mensaje_trabajador').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
                    $('#nombres').focus();
                    IniciarTrabajador();
                }
            });
        });

        var EditarTrabajador = function(id) {
            var route = "{{url('usuarios/trabajador')}}/" + id + "/edit";
            $.get(route, function (data) {
                $('#id_trabajador').val(data.ID_Trabajador);
                $('#nombres_edit').val(data.Nombre);
                $('#ap_paterno_edit').val(data.Ap_Paterno);
                $('#ap_materno_edit').val(data.Ap_Materno);
                $('#dni_edit').val(data.DNI);
                $('#cargo_edit').val(data.Cargo);
                $('#sueldo_edit').val(data.Sueldo_Base);
                $('#edit_trabajador_mod').modal({
                    show: true,
                    backdrop: 'static'
                });
                return false;
            });
        }

        $("#btnedit_trabajador").on('click',function(e){
            e.preventDefault();
            $('#mensaje_trabajador_edit').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var id = $("#id_trabajador").val();
            var nombre = $("#nombres_edit").val();
            var ap_pat = $('#ap_paterno_edit').val();
            var ap_mat = $('#ap_materno_edit').val();
            var dni = $('#dni_edit').val();
            var cargo = $('#cargo_edit').val();
            var sueldo = $('#sueldo_edit').val();
            var route = "{{url('usuarios/trabajador')}}/"+id+"";
            var token = $("#token").val();
            var dataString = {'Nombre':nombre,'Ap_Paterno':ap_pat,'Ap_Materno':ap_mat,'DNI':dni,'Cargo':cargo,'Sueldo_Base':sueldo};
            $.ajax({
                url:route,
                headers: {'X-CSRF-TOKEN':token},
                type:'PUT',
                dataType: 'json',
                data: dataString,
                success: function(data){
                    if(data.success == 'true') {
                        $('#mensaje_trabajador_edit').addClass('exito').html("El trabajador ha sido actualizado con éxito.").show(300).delay(3000).hide(300);
                        IniciarTrabajador();
                    }
                }
            });
        });

        var EliminarTrabajador = function (id,name) {
            $.alertable.confirm("¿Está seguro de Eliminar al Trabajador?: "+name).then(function(){
                var route = "{{url('usuarios/trabajador')}}/"+id+"";
                var token = $("#token").val();

                $.ajax({
                    url:route,
                    headers:{'X-CSRF-TOKEN' : token},
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        if(data.success == 'true'){
                            $('#detalle_trabajadores').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                            IniciarTrabajador();
                        }
                    }
                });
            });
        }
    </script>
@endpush
