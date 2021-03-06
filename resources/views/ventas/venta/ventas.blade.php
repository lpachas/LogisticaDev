@extends('layouts.admin')
@section('title','Ventas')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <a class="btn alert-success" href="venta/create" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nueva Venta</a>
        </div>
        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                <form action="{{url('venta/getventasInfo')}}" method="get" id="frmsearch">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="Buscar Venta">
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
            <div class="col-md-3">
                <div class="form-group">
                    <label>Filtrar por:</label>
                    <select class="form-control" id="select_tipo">
                        <option value="0">Seleccionar Tipo</option>
                        <option value="1">Factura</option>
                        <option value="2">Boleta</option>
                        <option value="3">Option three</option>
                        <option value="4">Option four</option>
                        <option value="5">Option five</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <label>Desde:</label>
                <input type="text" class="form-control" id="fecha_inicio">
            </div>
            <div class="col-md-3">
                <label>Hasta:</label>
                <input type="text" class="form-control" id="fecha_fin">
            </div>
            <div class="col-md-3">
                <br>
                <button id="btn_buscar" style="margin-top:4.3px;" class="btn alert-success"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
            </div>
        </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Lista de Ventas</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_ventas"></div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{asset('js/ventas/index.js') }}"></script>
<script>
    $(document).ready(function(){
        IniciarVenta();
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
            $("#detalle_ventas").html(data);
        });
    });

    function IniciarVenta(){
        var search = "";
        getVentas(1,search);
    }
    //script para pagination
    var click = $(document).on('click','.pagination li a',function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getVentas(page,$("#search").val());
    });

    function getVentas(page,search)
    {
        var url ="{{url('venta/getventasinfosearch')}}";
        $.ajax({
            type:'get',
            url: url+'?page='+page,
            data:{'search':search}
        }).done(function(data){
            $("#detalle_ventas").html(data);
        });
    }

    function listarventas(tipo,ini,fin){
        $.ajax({
            type:'get',
            url:"{!!url('venta/ListaVentas')!!}",
            data: {tipo:tipo,ini:ini,fin:fin},
            success: function(data)
            {
                console.log(data);
            }
        });
    }


    $('#btn_buscar').on('click',function(e){
        e.preventDefault();
        var tipo=$('#select_tipo').val();
        var f_ini=$('#fecha_inicio').val();
        var f_fin=$('#fecha_fin').val();
        listarventas(tipo,f_ini,f_fin);
    });

</script>
@endpush
