<div class="modal fade" id="pagar_credito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pagar Crédito</h4>
            </div>
            {!! Form::open(['id' => 'FormPagarCredito'])!!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                                <input type="hidden" id="id_venta">
                                <input type="hidden" id="id_usuario">
                                <label for="cliente">Cliente:</label>
                                <input type="text" id="nombre_cliente" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="documento">Documento:</label>
                                <input type="text" id="documento" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_venta">Fecha Venta:</label>
                                <input type="text" id="fecha_venta" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_credito">Fecha Crédito:</label>
                                <input type="text" id="fecha_credito" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dias">Días Restantes:</label>
                                <input type="text" id="dias" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total">Total:</label>
                                <input type="text" id="total" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="a_pagar">A Pagar:</label>
                                <input type="text" id="a_pagar" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="saldo">Saldo:</label>
                                <input type="text" id="saldo" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="box-footer text-center">
                        <button class="btn btn-primary" type="button" id="btnpagar_credito">Realizar Pago</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true"> Cancelar</button>
                    </div>
                </div>
                <div id="mensaje_pago"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>