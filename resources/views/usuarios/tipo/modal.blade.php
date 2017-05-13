<div class="modal fade" id="reg_tipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Tipo</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateTipo'])!!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" id="nombre" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_tipo">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_tipo"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_tipo_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel2">Editar Tipo</h4>
            </div>
            {!! Form::open(['id' => 'formulario_edit_tipo']) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="modal-body">
                <input type="hidden" id="id_tipo">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombres">Nombre:</label>
                                <input type="text" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Nombre" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnedit_tipo">Actualizar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_tipo_edit"></div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>