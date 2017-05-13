@extends('layouts.admin')
@section('title','Modelos')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <button class="btn alert-success" id="btn_newmodelo" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nuevo Modelo</button>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                    <form action="{{url('modelo/getmodelosInfo')}}" method="get" id="frmsearch">
                        <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Modelo">
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
                    <h2>Lista de Modelos</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_modelos"></div>
            </div>
        </div>
    </div>
    @include('almacen.modelo.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            IniciarModelo();
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
                $("#detalle_modelos").html(data);
            });
        });

        function IniciarModelo(){
            var search = "";
            getModelos(1,search);
        }
        //script para pagination
        var click = $(document).on('click','.pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getModelos(page,$("#search").val());
        });

        function getModelos(page,search)
        {
            var url ="{{url('modelo/getmodelosinfosearch')}}";
            $.ajax({
                type:'get',
                url: url+'?page='+page,
                data:{'search':search}
            }).done(function(data){
                $("#detalle_modelos").html(data);
            });
        }

        $('#btn_newmodelo').on('click',function(e){
            $('#FormCreateModelo')[0].reset();
            $('#reg_modelo').modal({
                show:true,
                backdrop:'static'
            });
        });
        $('#btnregistrar_modelo').on('click',function(e)
        {
            $('#mensaje_modelo').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var nombre = $('#nombre_modelo').val();
            var descripcion = $('#descripcion_modelo').val();
            var token = $("input[name=_token]").val();
            var route = "{{route('almacen.modelo.store')}}";
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
                        /*var fila = '<tr class="id'+data.ID_Marca+'"><td>'+data.Nombre+'</td><td>'+data.Descripcion+'</td><td><a title="Editar Marca" alt="Editar Marca" href="javascript:EditarMarca('+data.ID_Marca+')" class="btn btn-warning"><i class="fa fa-edit"></i></a><a title="Eliminar Marca" alt="Eliminar Marca" href="" class="btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>';
                        $("#detalle_marcas").append(fila);*/
                        $('#mensaje_modelo').addClass('exito').html("El modelo <b>"+data.Nombre+"</b> ha sido creado").show(300).delay(3000).hide(300);
                        $('#FormCreateModelo')[0].reset();
                        IniciarModelo();
                    }else{
                        $('#mensaje_modelo').addClass('error').html('Error al registrar el Modelo').show(300).delay(3000).hide(300);
                        $('#nombre_modelo').focus();
                    }
                },
                error:function(data)
                {
                    $('#mensaje_modelo').addClass('error').html('Error al registrar el Modelo').show(300).delay(3000).hide(300);
                    $('#nombre_modelo').focus();
                    return false;
                }
            });
        });

        var EditarModelo = function(id) {
            var route = "{{url('almacen/modelo')}}/" + id + "/edit";
            $.get(route, function (data) {
                $('#id_modelo').val(data.ID_Modelo);
                $('#nombre_edit').val(data.Nombre);
                $('#descripcion_edit').val(data.Descripcion);
                $('#edit_modelo_mod').modal({
                    show: true,
                    backdrop: 'static'
                });
                return false;
            });
        }

        $("#btnedit_modelo").on('click',function(e){
            e.preventDefault();
            $('#mensaje_modelo_edit').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var id = $("#id_modelo").val();
            var nombre = $("#nombre_edit").val();
            var descripcion = $("#descripcion_edit").val();
            var route = "{{url('almacen/modelo')}}/"+id+"";
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
                        $('#mensaje_modelo_edit').addClass('exito').html("El modelo <b>"+data.Nombre+"</b> ha sido actualizado con éxito.").show(300).delay(3000).hide(300);
                        IniciarModelo();
                    }
                }
            });
        });

        var EliminarModelo = function (id,name) {
            $.alertable.confirm("¿Está seguro de elminar el Modelo?: "+name).then(function(){
                var route = "{{url('almacen/modelo')}}/"+id+"";
                var token = $("#token").val();

                $.ajax({
                    url:route,
                    headers:{'X-CSRF-TOKEN' : token},
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        if(data.success == 'true'){
                            $('#detalle_modelos').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                            IniciarModelo();
                        }
                    }
                });
            });
        }
    </script>
@endpush
