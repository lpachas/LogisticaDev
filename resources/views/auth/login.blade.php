@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Usuario:</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 text-center">
                                <button type="button" class="btn btn-primary" id="btn_cperfil" disabled>Cargar Perfiles</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 text-center">
                                <select id="id_perfil" class="form-control">
                                    <option value="">--Seleccione un Perfil--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Ingresar
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">¿Olvidé mi contraseña?</a>
                            </div>
                        </div>
                        <div id="msg_perfiles"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scriptslayout')
<script>
    $(document).ready(function(){
        tecla();

    });

    function tecla(){
        var usu = $('#name').val();

        $("#password").on("keydown", function() {
            $('#btn_cperfil').prop("disabled", false);
        });

        var pass = $("#password").val();
        if( pass = ""){
            $('#btn_cperfil').prop("disabled", true);
        }
    }


    $('#btn_cperfil').on('click',function(e){
       e.preventDefault();
        $('#msg_perfiles').addClass('text-center').html('<img src="{{asset('img/ajax-loader.gif')}}"> Cargando Perfiles...');
        var usu=$('#name').val();
        var pass = $('#password').val();
        var token = $("input[name=_token]").val();
        var data = {name:usu};
        $.ajax({
            url: 'login/CargarPerfiles',
            headers: {'X-CSRF-TOKEN': token},
            type: 'post',
            datatype: 'json',
            data: data,
            success: function (res)
            {
                var option = "";
                for (var i=0; i<res.cant; i++) {
                    var perfil = res.perfiles[i];
                     option = '<option value="'+perfil.id+'">'+perfil.Nombre+'</option>';
                    $('#id_perfil').append(option);
                }
                $('#msg_perfiles').addClass('text-center').html('');
            }
        });
    });
</script>
@endpush
