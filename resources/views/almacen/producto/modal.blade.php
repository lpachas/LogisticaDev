<div class="modal fade" id="reg_producto_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Producto</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateProducto'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row" style="margin-bottom: 1.5em;">
                            <div class="col-md-2">
                                <label>Nombre del Producto:</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="nombre_producto" class="form-control">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 1.5em;">
                            <div class="col-md-6">
                                <div class="row" style="margin-bottom: 1.5em;">
                                    <div class="col-md-3">
                                        <label>Precio Público:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="precio_pu" class="form-control">
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 1.5em;">
                                    <div class="col-md-3">
                                        <label>Precio Ferretería:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="precio_fe" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row" style="margin-bottom: 1.5em;">
                                    <div class="col-md-3">
                                        <label>Stock:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="stock" class="form-control">
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 1.5em;">
                                    <div class="col-md-3">
                                        <label>Stock Mín.:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="stock_min" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 1.5px;">
                            <div class="col-md-4">
                                <div class="row" style="margin-bottom: 1.5px;">
                                    <div class="col-md-3">
                                        <label>Marca:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="contenedor">
                                            <div id="select_marca">
                                                <select id="id_marca" name="id_marca" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    @foreach($marcas as $marca)
                                                        <option value="{{$marca->ID_Marca}}">{{$marca->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button id="btn_nueva_marca" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i> Marca</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row" style="margin-bottom: 1.5px;">
                                    <div class="col-md-3">
                                        <label>Categoría:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="contenedor">
                                            <div id="select_categoria">
                                                <select id="id_categoria" name="id_categoria" class="form-control">
                                                    <option value="">Seleccione una Categoría</option>
                                                    @foreach($categorias as $categoria)
                                                        <option value="{{$categoria->ID_Categoria}}">{{$categoria->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button id="btn_nueva_categoria" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i> Categoría</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row" style="margin-bottom: 1.5px;">
                                    <div class="col-md-3">
                                        <label>Modelo:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="contenedor">
                                            <div id="select_modelo">
                                                <select id="id_modelo" name="id_modelo" class="form-control">
                                                    <option value="">Seleccione un Modelo</option>
                                                    @foreach($modelos as $modelo)
                                                        <option value="{{$modelo->ID_Modelo}}">{{$modelo->Nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="select_modelo_reg" style="display: none;"></div>
                                            <button id="btn_nuevo_modelo" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i> Modelo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="box-footer text-center">
                            <button class="btn btn-primary" type="button" id="btnregistrar_producto">Registrar</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                        </div>
                    </div>
                    <div id="mensaje_producto"></div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="reg_marca_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Marca</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateMarca'])!!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" id="nombre_marca" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detalle">Descripción:</label>
                                <textarea class="form-control" rows="4" id="descripcion_marca" name="descripcion_marca"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_marca">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_marca"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="reg_categoria_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Categoría</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateCategoria'])!!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" id="nombre_categoria" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detalle">Descripción:</label>
                                <textarea class="form-control" rows="4" id="descripcion_categoria" name="descripcion_categoria"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_categoria">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_categoria"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<div class="modal fade" id="reg_modelo_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Modelo</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateModelo'])!!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" id="nombre_modelo" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detalle">Descripción:</label>
                                <textarea class="form-control" rows="4" id="descripcion_modelo" name="descripcion_modelo"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_modelo">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_modelo"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<div class="modal fade" id="upd_stock_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar Stock</h4>
            </div>
            {!! Form::open(['id' => 'FormUpdateStock'])!!}
            <div class="modal-body">
                <div class="box-body" style="margin-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Stock Actual:</label>
                            <input type="text" id="stock_actual" value="200" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label>Stock a Aumentar:</label>
                            <input type="text" id="stock_aument" value="100" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Stock Total:</label>
                            <input type="text" id="stock_total" value="300" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnAct_Stock">Actualizar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_stock"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>