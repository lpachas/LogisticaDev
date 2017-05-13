<div class="modal fade" id="reg_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Cliente</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateCliente'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ruc_dni">RUC o DNI:</label>
                                <input type="text" name="ruc_dni" id="ruc_dni" class="form-control" placeholder="RUC o DNI" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_paterno">Teléfono:</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" placeholder="999999999">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipos">Zona</label>
                                <input type="text" name="zona" id="zona" class="form-control" placeholder="Zona" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_cliente">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_cliente"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

