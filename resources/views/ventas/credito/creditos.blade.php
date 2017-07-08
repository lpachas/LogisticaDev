@extends('layouts.admin')
@section('title','Ventas')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <a class="btn alert-success" href="venta/create" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nueva Venta</a>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                <form action="{{url('credito/getcreditosInfo')}}" method="get" id="frmsearch">
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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Lista de Ventas a Crédito</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" id="detalle_creditos"></div>
            </div>
        </div>
    </div>
    @include('ventas.credito.modal')
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        IniciarCredito();
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
            $("#detalle_creditos").html(data);
        });
    });

    function IniciarCredito(){
        var search = "";
        getCreditos(1,search);
    }
    //script para pagination
    var click = $(document).on('click','.pagination li a',function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getCreditos(page,$("#search").val());
    });

    function getCreditos(page,search)
    {
        var url ="{{url('credito/getcreditosinfosearch')}}";
        $.ajax({
            type:'get',
            url: url+'?page='+page,
            data:{'search':search}
        }).done(function(data){
            $("#detalle_creditos").html(data);
        });
    }

    var PagarCredito = function(id) {
        var route = "{{url('ventas/credito')}}/" + id + "/Cargarcredito";
        $.get(route, function (data) {
            console.log(data);
            $('#FormPagarCredito')[0].reset();
            $('#id_venta').val(data[0].ID_Doc_Venta);
            $('#nombre_cliente').val(data[0].Cliente);
            var documento = data[0].Documento+": "+data[0].Serie+"-"+data[0].Numero;
            $('#documento').val(documento);
            $('#fecha_venta').val(data[0].Fecha);
            $('#fecha_credito').val(data[0].FechaCredito);
            $('#dias').val(data[0].Dias);
            $('#total').val(data[0].Total);
            $('#a_pagar').change(CalcularSaldo);
            function CalcularSaldo(){
                var total = parseInt($('#total').val());
                var pago = parseInt($('#a_pagar').val());
                var saldo = total-pago;
                $('#saldo').val(saldo);
            }
            $('#pagar_credito').modal({
                show:true,
                backdrop:'static'
            });
            return false;
        });
    }

</script>
@endpush
