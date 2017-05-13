<div class="modal fade" id="reg_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registrar Usuario</h4>
            </div>
            {!! Form::open(['id' => 'FormCreateUsuario'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="trabajador">Trabajador:</label>
                                <div id="select_trabajador">
                                    <select id="ID_Trabajador" name="ID_Trabajador" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Seleccione un Trabajador</option>
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{$trabajador->ID_Trabajador}}">{{$trabajador->Datos}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Usuario:</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nombre de Usuario" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Contraseña:</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="**********" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_paterno">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipos">Tipo de Usuario</label>
                                @foreach($tipos as $tipo)
                                    <div>
                                        <input type="checkbox" class=" check_class" id="tipo_{{$tipo->ID_Tipo_Usuario}}" value="{{$tipo->ID_Tipo_Usuario}}"> {{$tipo->Nombre}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control" placeholder="Descripción" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnregistrar_usuario">Registrar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_usuario"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<div class="modal fade" id="edit_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
            </div>
            {!! Form::open(['id' => 'FormEditUsuario'])!!}
            <input type="hidden" id="id_usuario_edit">
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="trabajador">Trabajador:</label>
                                <div id="select_trabajador">
                                    <input id="ID_Trabajador_edit" type="hidden">
                                    <input type="text" id="Nombre_Trabajador_edit" value="" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Usuario:</label>
                                <input type="text" name="name_edit" id="name_edit" class="form-control" placeholder="Nombre de Usuario" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_paterno">Email:</label>
                                <input type="email" name="email_edit" id="email_edit" class="form-control" placeholder="example@gmail.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipos">Tipo de Usuario</label>
                                @foreach($tipos as $tipo)
                                    <div>
                                        <input type="checkbox" id="check_edit_{{$tipo->ID_Tipo_Usuario}}" class="check_class_edit" value="{{$tipo->ID_Tipo_Usuario}}"> {{$tipo->Nombre}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion_edit" class="form-control" placeholder="Descripción" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btneditar_usuario">Actualizar</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_usuario_edit"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

