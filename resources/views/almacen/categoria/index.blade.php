@extends('layouts.admin')
@section('title','Categorías')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <button class="btn alert-success" id="btn_newcategoria" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nueva Categoria</button>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                    <form action="{{url('categoria/getcategoriasInfo')}}" method="get" id="frmsearch">
                        <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Categoría">
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
                    <h2>Lista de Categorías</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_categorias"></div>
            </div>
        </div>
    </div>
    @include('almacen.categoria.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            IniciarCategoria();
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
                $("#detalle_categorias").html(data);
            });
        });

        function IniciarCategoria(){
            var search = "";
            getCategorias(1,search);
        }
        //script para pagination
        var click = $(document).on('click','.pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getCategorias(page,$("#search").val());
        });

        function getCategorias(page,search)
        {
            var url ="{{url('categoria/getcategoriasinfosearch')}}";
            $.ajax({
                type:'get',
                url: url+'?page='+page,
                data:{'search':search}
            }).done(function(data){
                $("#detalle_categorias").html(data);
            });
        }

        $('#btn_newcategoria').on('click',function(e){
            $('#FormCreateCategoria')[0].reset();
            $('#reg_categoria').modal({
                show:true,
                backdrop:'static'
            });
        });
        $('#btnregistrar_categoria').on('click',function(e)
        {
            $('#mensaje_categoria').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var nombre = $('#nombre_categoria').val();
            var descripcion = $('#descripcion_categoria').val();
            var token = $("input[name=_token]").val();
            var route = "{{route('almacen.categoria.store')}}";
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
                        $('#mensaje_categoria').addClass('exito').html("La Categoría <b>"+data.Nombre+"</b> ha sido creada").show(300).delay(3000).hide(300);
                        $('#FormCreateCategoria')[0].reset();
                        IniciarCategoria();
                    }else{
                        $('#mensaje_categoria').addClass('error').html('Error al registrar la Categoría').show(300).delay(3000).hide(300);
                        $('#nombre_categoria').focus();
                    }
                },
                error:function(data)
                {
                    $('#mensaje_categoria').addClass('error').html('Error al registrar la Categoria').show(300).delay(3000).hide(300);
                    $('#nombre_categoria').focus();
                    return false;
                }
            });
        });

        var EditarCategoria = function(id) {
            var route = "{{url('almacen/categoria')}}/" + id + "/edit";
            $.get(route, function (data) {
                $('#id_categoria').val(data.ID_Categoria);
                $('#nombre_edit').val(data.Nombre);
                $('#descripcion_edit').val(data.Descripcion);
                $('#edit_categoria_mod').modal({
                    show: true,
                    backdrop: 'static'
                });
                return false;
            });
        }

        $("#btnedit_categoria").on('click',function(e){
            e.preventDefault();
            $('#mensaje_categoria_edit').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var id = $("#id_categoria").val();
            var nombre = $("#nombre_edit").val();
            var descripcion = $("#descripcion_edit").val();
            var route = "{{url('almacen/categoria')}}/"+id+"";
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
                        $('#mensaje_categoria_edit').addClass('exito').html("La Categoría <b>"+data.Nombre+"</b> ha sido actualizada con éxito.").show(300).delay(3000).hide(300);
                        IniciarCategoria();
                    }
                }
            });
        });

        var EliminarCategoria = function (id,name) {
            $.alertable.confirm("¿Está seguro de elminar la Categoría?: "+name).then(function(){
                var route = "{{url('almacen/categoria')}}/"+id+"";
                var token = $("#token").val();

                $.ajax({
                    url:route,
                    headers:{'X-CSRF-TOKEN' : token},
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        if(data.success == 'true'){
                            $('#detalle_categorias').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                            IniciarCategoria();
                        }
                    }
                });
            });
        }
    </script>
@endpush
