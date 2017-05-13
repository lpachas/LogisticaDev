$(document).ready(function(){
  loadproductos(1);
});

function loadproductos(page){
  var dato= $("#dato").val();
  $.ajax({
      url:'../php/producto/buscar_producto.php?action=ajax&page='+page+'&dato='+dato,
      success:function(res){
          $('#detalle_producto').html(res).fadeIn('slow');
      }
  });
}

$('#btn_new_producto').on('click',function(e){
    e.preventDefault();
    $('#FormCreateProducto')[0].reset();
    $('#select_marca_reg').hide();
    $('#select_marca').show();
    $('#select_categoria_reg').hide();
    $('#select_categoria').show();
    $('#select_modelo_reg').hide();
    $('#select_modelo').show();
    $('#reg_producto_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btn_nueva_marca').on('click',function(e){
    e.preventDefault();
    $('#FormCreateMarca')[0].reset();
    $('#reg_marca_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btn_nueva_categoria').on('click',function(e){
    e.preventDefault();
    $('#FormCreateCategoria')[0].reset();
    $('#reg_categoria_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btn_nuevo_modelo').on('click',function(e){
    e.preventDefault();
    $('#FormCreateModelo')[0].reset();
    $('#reg_modelo_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btnregistrar_producto').click(function (e)
{
	  e.preventDefault();
    $('#msg-producto').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
    var nombre = $('#nombre_producto').val();
    var precio_pu = $('#precio_pu').val();
    var precio_fe = $('#precio_fe').val();
    var stock = $('#stock').val();
    var stock_min = $('#stock_min').val();
    var id_marca = $('#id_marca').val();
    var id_categoria = $('#id_categoria').val();
    var id_modelo = $('#id_modelo').val();
    var route ="../php/producto/agregar_producto.php";
    var dataString = {'nombre':nombre,'precio_pu':precio_pu,'precio_fe':precio_fe,'stock':stock,'stock_min':stock_min,
    'id_marca':id_marca,'id_categoria':id_categoria,'id_modelo':id_modelo};
    console.log(dataString);
    /*$.ajax({
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
  	});*/
});

$('#btnregistrar_marca').on('click',function(e){
  e.preventDefault();
  $('#mensaje_marca').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
  var nombre = $('#nombre_marca').val();
  var desc = $('#descripcion_marca').val();
  var datos = {'nombre':nombre,'descripcion':desc};
  var route = "../php/producto/agregar_marca.php";
  $.ajax({
      url: route,
      type:'post',
      dataType:'json',
      data: datos,
      success:function(data)
      {
        if (data == 2) {
            $('#mensaje_marca').addClass('error').html('Error al registrar la marca.Por favor, revise los datos.').show(300).delay(3000).hide(300);
            $('#nombre_marca').focus();
            return false;
        }else if (data == 3) {
          $('#mensaje_marca').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_marca').focus();
            return false;
        }else{
            $('#mensaje_marca').addClass('exito').html("La Marca "+nombre+" ha sido creada").show(300).delay(3000).hide(300);
            $('#select_marca').hide();
            $('#select_marca_reg').show();
            $.each(data.marcas, function(i,marca){
            var newRow = '<input type="hidden" id="id_marca_reg" value="'+marca.id+'"><input type="text" value="'+marca.nombre+'" class="form-control">';
            $('#select_marca_reg').html(newRow);
            });
        }   
      },
      error:function(){
            $('#mensaje').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_marca').focus();
            return false;
      }
    });
});

$('#btnregistrar_categoria').on('click',function(e){
  e.preventDefault();
  $('#mensaje_cat').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
  var nombre = $('#nombre_cat').val();
  var desc = $('#descripcion_cat').val();
  var datos = {'nombre':nombre,'descripcion':desc};
  var route = "../php/producto/agregar_categoria.php";
  $.ajax({
      url: route,
      type:'post',
      dataType:'json',
      data: datos,
      success:function(data)
      {
        if (data == 2) {
            $('#mensaje_cat').addClass('error').html('Error al registrar la Categoría.Por favor, revise los datos.').show(300).delay(3000).hide(300);
            $('#nombre_cat').focus();
            return false;
        }else if (data == 3) {
            $('#mensaje_cat').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_cat').focus();
            return false;
        }else{
            $('#mensaje_cat').addClass('exito').html("La Categoría "+nombre+" ha sido creada").show(300).delay(3000).hide(300);
            $('#select_categoria').hide();
            $('#select_categoria_reg').show();
            $.each(data.categorias, function(i,categoria){
            var newRow = '<input type="hidden" id="id_categoria_reg" value="'+categoria.id+'"><input type="text" value="'+categoria.nombre+'" class="form-control">';
            $('#select_categoria_reg').html(newRow);
            });
        }   
      },
      error:function(){
            $('#mensaje_cat').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_cat').focus();
            return false;
      }
    });
});


$('#btnregistrar_modelo').on('click',function(e){
  e.preventDefault();
  $('#mensaje_mod').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
  var nombre = $('#nombre_modelo').val();
  var desc = $('#descripcion_modelo').val();
  var datos = {'nombre':nombre,'descripcion':desc};
  var route = "../php/producto/agregar_modelo.php";
  $.ajax({
      url: route,
      type:'post',
      dataType:'json',
      data: datos,
      success:function(data)
      {
        if (data == 2) {
            $('#mensaje_mod').addClass('error').html('Error al registrar el Modelo.Por favor, revise los datos.').show(300).delay(3000).hide(300);
            $('#nombre_modelo').focus();
            return false;
        }else if (data == 3) {
            $('#mensaje_mod').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_modelo').focus();
            return false;
        }else{
            $('#mensaje_mod').addClass('exito').html("El Modelo "+nombre+" ha sido creado").show(300).delay(3000).hide(300);
            $('#select_modelo').hide();
            $('#select_modelo_reg').show();
            $.each(data.modelos, function(i,modelo){
            var newRow = '<input type="hidden" id="id_modelo_reg" value="'+modelo.id+'"><input type="text" value="'+modelo.nombre+'" class="form-control">';
            $('#select_modelo_reg').html(newRow);
            });
        }   
      },
      error:function(){
            $('#mensaje_mod').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_modelo').focus();
            return false;
      }
    });
});


var DetalleProducto = function(id){
  $('#formulario_detalle_producto')[0].reset();
  var url = '../php/producto/productos_datos.php';
    $.ajax({
    type:'POST',
    url:url,
    data:'id='+id,
    success: function(valores){
        var datos = eval(valores);
        $('#id_producto').val(id);
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

var EditarProducto = function(id){
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