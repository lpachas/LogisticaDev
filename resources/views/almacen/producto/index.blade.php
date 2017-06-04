@extends('layouts.admin')
@section('title','Productos')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <a class="btn alert-success" id="btn_newproducto" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nuevo Producto</a>
            <a class="btn alert-success" id="btn_upd_stock" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nuevo Producto</a>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                    <form action="{{url('producto/getproductosInfo')}}" method="get" id="frmsearch">
                        <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Producto">
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
                    <h2>Lista de Productos</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_productos"></div>
            </div>
        </div>
    </div>
    @include('almacen.producto.modal')
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset('js/producto/producto.js')}}"></script>
    <script>
        $(document).ready(function(){
            IniciarProducto();
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
                $("#detalle_productos").html(data);
            });
        });

        function IniciarProducto(){
            var search = "";
            getProductos(1,search);
        }
        //script para pagination
        var click = $(document).on('click','.pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getProductos(page,$("#search").val());
        });

        function getProductos(page,search)
        {
            var url ="{{url('producto/getproductosinfosearch')}}";
            $.ajax({
                type:'get',
                url: url+'?page='+page,
                data:{'search':search}
            }).done(function(data){
                $("#detalle_productos").html(data);
            });
        }

        $('#btn_newproducto').on('click',function(e){
            $('#FormCreateProducto')[0].reset();
            $('#reg_producto_mod').modal({
                show:true,
                backdrop:'static'
            });
        });

        $('#btnregistrar_producto').on('click',function(e){
            $('#mensaje_producto').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
            var nombre = $('#nombre_producto').val();
            var publico = $('#precio_pu').val();
            var ferr = $('#precio_fe').val();
            var stock = $('#stock').val();
            var stock_min = $('#stock_min').val();
            var marca = $('#id_marca').val();
            var categoria = $('#id_categoria').val();
            var modelo = $('#id_modelo').val();

            var datos = "Nombre="+nombre+"&PU_Publico="+publico+"&PU_Ferreteria="+ferr+"&Stock="+stock+"&Stock_Min="+stock_min+"&ID_Marca="+marca+
                "&ID_Categoria="+categoria+"&ID_Modelo="+modelo;
            console.log(datos);
            var token = $("input[name=_token]").val();
            var route = "{{route('almacen.producto.store')}}";
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN':token},
                type:'post' ,
                datatype: 'json',
                data: datos,
                success:function(data)
                {
                    if(data.success == 'true')
                    {
                        $('#mensaje_producto').addClass('exito').html("El producto <b>"+data.Nombre+"</b> ha sido registrado").show(300).delay(3000).hide(300);
                        $('#FormCreateProducto')[0].reset();
                        IniciarProducto();
                    }else{
                        $('#mensaje_producto').addClass('error').html('Error al registrar el Producto').show(300).delay(3000).hide(300);
                        $('#nombre_producto').focus();
                    }
                },
                error:function(data)
                {
                    $('#mensaje_producto').addClass('error').html('Error al registrar el Producto').show(300).delay(3000).hide(300);
                    $('#nombre_producto').focus();
                    return false;
                }
            });

        });

        var EliminarProducto = function (id,name) {
            $.alertable.confirm("¿Está seguro de elminar el Producto?: "+name).then(function(){
                var route = "{{url('almacen/producto')}}/"+id+"";
                var token = $("#token").val();

                $.ajax({
                    url:route,
                    headers:{'X-CSRF-TOKEN' : token},
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        if(data.success == 'true'){
                            $('#detalle_productos').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}">');
                            IniciarProducto();
                        }
                    }
                });
            });
        }

        $('#btnregistrar_marca').on('click',function(e)
        {
            $('#mensaje_marca').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando...');
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
                        $('#mensaje_marca').addClass('exito').html("La Marca <b>"+data.Nombre+"</b> ha sido creada").show(300).delay(3000).hide(300);
                        $('#FormCreateMarca')[0].reset();
                        var fila ='<option value="'+data.ID_Marca+'">'+data.Nombre+'</option>';
                        $('#id_marca').append(fila);
                    }else{
                        $('#mensaje_marca').addClass('error').html('Error al registrar la Marca').show(300).delay(3000).hide(300);
                        $('#nombre_marca').focus();
                    }
                },
                error:function(data)
                {
                    $('#mensaje_marca').addClass('error').html('Error al registrar la Marca').show(300).delay(3000).hide(300);
                    $('#nombre_marca').focus();
                    return false;
                }
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
                        var fila ='<option value="'+data.ID_Categoria+'">'+data.Nombre+'</option>';
                        $('#id_categoria').append(fila);
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
                        $('#mensaje_modelo').addClass('exito').html("El modelo <b>"+data.Nombre+"</b> ha sido creado").show(300).delay(3000).hide(300);
                        $('#FormCreateModelo')[0].reset();
                        var fila ='<option value="'+data.ID_Modelo+'">'+data.Nombre+'</option>';
                        $('#id_modelo').append(fila);
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

        var ActualizarStock = function(id) {
            var route = "{{url('almacen/producto')}}/" + id + "/stock";
            $.get(route, function (data) {
                $('#id_producto_act').val(data.ID_Producto);
                $('#stock_actual').val(data.Stock);
                $('#upd_stock_mod').modal({
                    show: true,
                    backdrop: 'static'
                });
                return false;
            });
        }

        $("#btnAct_Stock").on('click',function(e){
            e.preventDefault();
            /* aqui me quedo */
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

    </script>
@endpush
