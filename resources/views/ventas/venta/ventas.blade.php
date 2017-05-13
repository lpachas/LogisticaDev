@extends('layouts.admin')
@section('title','Ventas')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <a class="btn alert-success" id="btn_newventa" style="margin-top: 10px;"><i class="fa fa-plus"></i> Nueva Venta</a>
        </div>

        <div class="title_right">
            <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">

                <form action="{{url('producto/getventasInfo')}}" method="get" id="frmsearch">
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