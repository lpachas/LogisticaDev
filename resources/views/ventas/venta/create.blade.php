@extends('layouts.admin')
@section('title','Nueva Venta')
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nueva Venta</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="panel panel-primary">
                                     <div class="panel-body">
                                         <div class="row">
                                             <div class="col-md-8">
                                                 <div class="form-group">
                                                     <label>Cliente:</label>
                                                     <select id="id_cliente" class="form-control selectpicker" data-live-search="true">
                                                         <option value="">--Seleccione un cliente--</option>
                                                         @foreach($clientes as $cliente)
                                                             <option value="{{$cliente->ID_Cliente}}">{{$cliente->Nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4" style="padding-top: 1.7em;">
                                                 <div class="form-group">
                                                     <button id="btn_cliente" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Cliente</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="panel panel-primary">
                                     <div class="panel-body">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label>Tipo de Venta:</label>
                                                     <select id="id_tipo_venta" class="form-control selectpicker" data-live-search="true">
                                                         <option value="">--Seleccione Tipo Venta--</option>
                                                         <option value="1">Contado</option>
                                                         <option value="2">Crédito</option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label>Fecha:</label>
                                                     <div class="input-group date" id="fecha">
                                                         <div class="input-group-addon">
                                                             <i class="fa fa-calendar"></i>
                                                         </div>
                                                         <input type="text" class="form-control pull-right" id="fecha_venta" name="fecha_venta">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-4">
                               <div class="panel panel-primary">
                                   <div class="panel-body">
                                       <div class="col-md-12">
                                           <div class="form-group">
                                               <label>Forma de Pago:</label>
                                               <select id="id_forma_pago" name="id_forma_pago" class="form-control selectpicker" data-live-search="true">
                                                   <option value="">--Seleccione una forma--</option>
                                                   <option value="">Forma 1</option>
                                                   <option value="">Forma 2</option>
                                               </select>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                             </div>
                             <div class="col-md-8">
                                 <div class="panel panel-primary">
                                     <div class="panel-body">
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <label>Tipo de Documento:</label>
                                                     <select id="id_documento" name="id_documento" class="form-control selectpicker" data-live-search="true">
                                                         <option value="">--Seleccione un documento--</option>
                                                         @foreach($documentos as $doc)
                                                             <option value="{{$doc->ID_Tipo_Documento}}_{{$doc->Serie}}_{{$doc->Numero}}">{{$doc->Descripcion_Doc}}</option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <label>Serie:</label>
                                                     <input type="text" id="serie" class="form-control" placeholder="Serie de Documento">
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <label>Número:</label>
                                                     <input type="text" id="numero" class="form-control" placeholder="Número de Documento">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Producto:</label>
                                            <select id="id_producto" class="form-control selectpicker" data-live-search="true">
                                                <option value="">--Seleccione un Producto--</option>
                                                @foreach($productos as $prod)
                                                <option value="{{$prod->ID_Producto}}">{{$prod->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" id="cont-marca">
                                            <label>Marca:</label>
                                            <select id="id_marca" name="id_marca" class="form-control selectpicker" data-live-search="true">
                                                <option value="">--Seleccione una Marca--</option>
                                                @foreach($marcas as $m)
                                                    <option value="{{$m->ID_Marca}}">{{$m->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Categoría:</label>
                                            <select id="id_categoria" name="id_categoria" class="form-control selectpicker" data-live-search="true">
                                                <option value="">--Seleccione una Categoría--</option>
                                                @foreach($categorias as $c)
                                                    <option value="{{$c->ID_Categoria}}">{{$c->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Modelo</label>
                                            <select id="id_modelo" name="id_modelo" class="form-control selectpicker" data-live-search="true">
                                                <option value="">--Seleccione un Modelo--</option>
                                                @foreach($modelos as $m)
                                                    <option value="{{$m->ID_Modelo}}">{{$m->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Stock:</label>
                                        <input type="text" class="form-control" id="stock" disabled>
                                        <input type="hidden" id="nomprod">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cantidad:</label>
                                        <input type="number" class="form-control" id="cantidad">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Precio Venta:</label>
                                        <input type="text" class="form-control" id="pventa" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Descuento:</label>
                                        <input type="text" class="form-control" id="descuento" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Parcial:</label>
                                        <input type="text" class="form-control" id="parcial" disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <br>
                                            <button type="button" id="btn_add" class="btn btn-primary" disabled>Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color: #A9D0F5">
                                    <th width="15%">Opciones</th>
                                    <th width="30%">Artículo</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="15%">Precio Venta</th>
                                    <th width="15%">Descuento</th>
                                    <th width="15%">Subtotal</th>
                                    </thead>
                                    <tfoot>
                                    <th width="15%"><br>Total</th>
                                    <th width="30%"></th>
                                    <th width="15%"></th>
                                    <th width="15%"><br>IGV</th>
                                    <th width="15%"><input type="checkbox" id="check"><input type="text" id="igv" value="0.08" class="form-control" disabled></th>
                                    <th width="15%"><h4 id="total">S/. 0.00 </h4><input type="hidden" name="total_sale" id="total_sale"></th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
                                <div class="form-group">

                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                    <button class="btn btn-danger" type="reset">Cancelar</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @include('ventas.venta.modal')
@endsection
@push('scripts')
<script src="{{asset('js/ventas/ventas.js') }}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
@endpush