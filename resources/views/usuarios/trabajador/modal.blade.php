<div class="modal fade" id="reg_trabajador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Trabajador</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateTrabajador'])!!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombres:</label>
                                <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_paterno">Apellido Paterno:</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Apellido Paterno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_materno">Apellido Materno:</label>
                                <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Apellido Materno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" name="dni" id="dni" class="form-control" placeholder="99999999" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Cargo" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sueldo">Sueldo</label>
                                <input type="number" name="sueldo" id="sueldo" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_trabajador">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_trabajador"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="edit_trabajador_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel2">Editar Trabajador</h4>
            </div>
            {!! Form::open(['id' => 'formulario_edit_trabajador']) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="modal-body">
                <input type="hidden" id="id_trabajador">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombres">Nombres:</label>
                                <input type="text" name="nombres_edit" id="nombres_edit" class="form-control" placeholder="Nombre" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ap_paterno">Apellido Paterno:</label>
                                <input type="text" name="ap_paterno_edit" id="ap_paterno_edit" class="form-control" placeholder="Apellido Paterno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ap_materno">Apellido Materno:</label>
                                <input type="text" name="ap_materno_edit" id="ap_materno_edit" class="form-control" placeholder="Apellido Materno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" name="dni_edit" id="dni_edit" class="form-control" placeholder="99999999" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <input type="text" name="cargo_edit" id="cargo_edit" class="form-control" placeholder="Cargo" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sueldo">Sueldo</label>
                                <input type="number" name="sueldo_edit" id="sueldo_edit" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnedit_trabajador">Actualizar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_trabajador_edit"></div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>