function logeo(){
    $('#loading').show();
	var usuario = $('#usuario').val();
	var clave = $('#clave').val();
    var tipo = $('#tipo_user') .val();
    var data = {'usuario':usuario,'clave':clave,'tipo':tipo};
	$.ajax({
    type:'POST',
    url:'php/login_usuario.php',
    data:data,
    success:function(respuesta){ 
    	if (respuesta== 1) {
            $('#loading').hide();
    		$('#notificacion').addClass('alert').html('El usuario ingresado no existe').show(300).delay(3000).hide(300);
			$('#usuario').focus();
			return false;
    	}else if(respuesta==3){
            $('#loading').hide();
    		$('#notificacion').addClass('alert').html('Contraseña Incorrecta').show(300).delay(3000).hide(300);
			$('#clave').focus();
    	}else if(respuesta==4){
            $('#loading').hide();
    		$('#form-login')[0].reset();
    		$('#notificacion').addClass('error').html('Error Desconocido. Consulte con su Administrador').show(300).delay(3000).hide(300);
    	}else if(respuesta==5){
            $('#loading').hide();
    		$('#notificacion').addClass('error').html('Cuenta Desactivada. Consulte con su Administrador').show(300).delay(3000).hide(300);
			$('#usuario').focus();
			return false;
    	}else if(respuesta == 2) {
            $('#loading').hide();
            $('#notificacion').addClass('alert').html('Por favor. Ingrese sus credenciales.').show(300).delay(3000).hide(300);
            $('#clave').focus();
        }else if(respuesta == 6){
            $('#loading').hide();
            $('#notificacion').addClass('error').html('Seleccione un tipo de cuenta').show(300).delay(3000).hide(300);
            $('#usuario').focus();
            return false;
        }else{
            $('#loading').hide();
			document.location.href = 'sistema/index.php';
        }
  }});
}