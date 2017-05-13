$(document).ready(function(){
  loadusuarios(1);
});

function loadusuarios(page){
  var dato= $("#dato").val();
  $.ajax({
      url:'../php/usuario/buscar_usuario.php?action=ajax&page='+page+'&dato='+dato,
      success:function(res){
          $('#detalle_usuario').html(res).fadeIn('slow');
      }
  });
}

$('#btn_new_usuario').on('click',function(){
    $('#FormCreateUsuario')[0].reset();
    $('#reg_usuario_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btnregistrar_usuario').click(function (e)
{
	  e.preventDefault();
    $('#mensaje').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
    var id_trab = $('#id_trabajador').val();
    var usuario = $('#usuario').val();
    var clave = $('#clave').val();
    var email = $('#email').val();
    var id_tipo = $('#id_tipo').val();
    var descripcion = $('#descripcion').val();
    var route ="../php/usuario/agregar_usuario.php";
    var dataString = {'id_trab':id_trab,'usuario':usuario,'clave':clave,'email':email,'id_tipo':id_tipo,'descripcion':descripcion};

    $.ajax({
      url: route,
      type:'post' ,
      data: dataString,
      success:function(data)
      {
        if (data == 1) {
            $('#mensaje').addClass('error').html('Ya existe un usario con ese nombre o email.').show(300).delay(3000).hide(300);
            $('#usuario').focus();
            return false;
        }else if (data == 2) {
            $('#mensaje').addClass('error').html('No se puede crear un usuario.Por favor revise los datos.').show(300).delay(3000).hide(300);
            return false;
        }else if (data == 3) {
            $('#mensaje').addClass('exito').html("El Usuario ha sido creado con éxito.").show(300).delay(3000).hide(300);
            $('#FormCreateUsuario')[0].reset();
            $('#detalle_usuario').html(data);
            loadusuarios(1);
        }else if(data == 4){
            $('#mensaje').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            loadusuarios(1);
        }   
      },
      error:function(){
      		 $('#mensaje').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
          loadusuarios(1);

      }
  	});
});


var EditarUsuario = function(id){
  $('#formulario_edit_usuario')[0].reset();
  var url = '../php/usuario/editar_usuarios_datos.php';
    $.ajax({
    type:'POST',
    url:url,
    data:'id='+id,
    success: function(valores){
        var datos = eval(valores);
        $('#id_edit_usuario').val(id);
        $('#nombre_edit').val(datos[0]);
        $('#usuario_edit').val(datos[2]);
        $('#clave_edit').val(datos[3]);
        $('#email_edit').val(datos[4]);
        $('#id_tipo_edit').val(datos[1]);
        $('#descripcion_edit').val(datos[5]);
        $('#id_trabajador_edit').val(datos[6]);
        $('#edit_usuario_mod').modal({
          show:true,
          backdrop:'static'
        });
      return false;
    }
  });
  return false;
}


$('#btnedit_usuario').on('click',function(e){
	e.preventDefault();
  $('#mensaje-edit').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
	var id_user = $('#id_edit_usuario').val();
	var id_trab = $('#id_trabajador_edit').val();
    var usuario = $('#usuario_edit').val();
    var clave = $('#clave_edit').val();
    var email = $('#email_edit').val();
    var id_tipo = $('#id_tipo_edit').val();
    var descripcion = $('#descripcion_edit').val();
    var route = "../php/usuario/editar_usuario.php";
    var dataString = {'id_user':id_user,'id_trab':id_trab,'usuario':usuario,'clave':clave,'email':email,'id_tipo':id_tipo,'descripcion':descripcion};

    $.ajax({
      url: route,
      type:'post' ,
      data: dataString,
      success:function(data)
      {
         if (data == 1) {
         	  $('#mensaje-edit').addClass('error').html('Error al Editar al Usuario.Por favor, revise los datos.').show(300).delay(3000).hide(300);
            $('#usuario_edit').focus();
            return false;
		     }else if (data == 2) {
            $('#mensaje-edit').addClass('exito').html("El Usuario ha sido actualizado").show(300).delay(3000).hide(300);
            $('#detalle_usuario').html(data);
            loadusuarios(1);
         }else if(data == 3){
		 	      $('#mensaje-edit').addClass('error').html('Error al Editar ya que tiene datos relacionados.').show(300).delay(3000).hide(300);
            $('#usuario_edit').focus();
            return false;
        }
      },
      error:function(){
          $('#mensaje-edit').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
          $('#usuario_edit').focus();
          loadusuarios(1);
      }
  	});

});

var DesactivarUsuario = function(id){
  var route = "../php/usuario/desactivar.php";
  $.alertable.confirm("¿Está seguro de desactivar al usuario seleccionado?").then(function(){
    $.ajax({
    type:'POST',
    url:route,
    data:'id='+id,
         success: function(data){
          if (data == 2) {
            $('#detalle_usuario').html(data);
            loadusuarios(1);
          }
         }
    });
  });
}

var ActivarUsuario = function(id){
  var route = "../php/usuario/activar.php";
  $.alertable.confirm("¿Activar la cuenta del usuario seleccionado?").then(function(){
    $.ajax({
    type:'POST',
    url:route,
    data:'id='+id,
         success: function(data){
          if (data == 2) {
            $('#detalle_usuario').html(data);
            loadusuarios(1);
          }
         }
    });
  });
}