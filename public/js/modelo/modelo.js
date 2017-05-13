$(document).ready(function(){
  loadmodelos(1);
});

function loadmodelos(page){
   var dato= $("#dato").val();
   $.ajax({
      url:'../php/modelo/buscar_modelo.php?action=ajax&page='+page+'&dato='+dato,
      success:function(res){
          $('#detalle_modelo').html(res).fadeIn('slow');
      }
  });
}

$('#btn_new_modelo').on('click',function(){
    $('#FormCreateModelo')[0].reset();
    $('#reg_modelo_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btnregistrar_modelo').on('click',function(e){
	e.preventDefault();
	$('#mensaje_mod').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
	var nombre = $('#nombre_modelo').val();
	var desc = $('#descripcion_modelo').val();
	var datos = {'nombre':nombre,'descripcion':desc};
	var route = "../php/modelo/agregar_modelo.php";
	
	$.ajax({
      url: route,
      type:'post',
      data: datos,
      success:function(data)
      {
		    if (data == 2) {
            $('#mensaje_mod').addClass('error').html('Error al registrar la modelo.Por favor, revise los datos.').show(300).delay(3000).hide(300);
            $('#nombre_modelo').focus();
            return false;
        }else if (data == 3) {
        	  $('#mensaje_mod').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_modelo').focus();
            return false;
        }else if(data == 4){
			      $('#mensaje_mod').addClass('exito').html("La Modelo "+nombre+" ha sido creada").show(300).delay(3000).hide(300);
            $('#FormCreateModelo')[0].reset();
            $('#detalle_modelo').html(data);
            loadmodelos(1);
        }   
      },
      error:function(){
            $('#mensaje_mod').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombre_modelo').focus();
            return false;
      }
  	});
});

var EditarModelo = function(id){
  $('#FormEditModelo')[0].reset();
  var url = '../php/modelo/editar_modelo_datos.php';
    $.ajax({
    type:'POST',
    url:url,
    data:'id='+id,
    success: function(valores){
        var datos = eval(valores);
        $('#id_modelo').val(id);
        $('#nombre_edit').val(datos[0]);
        $('#descripcion_edit').val(datos[1]);
        $('#edit_modelo_mod').modal({
          show:true,
          backdrop:'static'
        });
      return false;
    }
  });
  return false;
}

$("#btnedit_modelo").on('click',function(e){
    e.preventDefault();
    $('#mensaje_mod_edit').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
    var id = $("#id_modelo").val();
    var nombre = $("#nombre_edit").val();
    var descripcion = $('#descripcion_edit').val();
    var data={'id':id,'nombre':nombre,'descripcion':descripcion};
    console.log(data);
    var route = "../php/modelo/editar_modelo.php";    
      $.ajax({
          url:route,
          type:'post',
          data: data,
          success: function(data){
            if (data == 1) {
               $('#mensaje_mod_edit').addClass('error').html('Error! El Nombre no puede estar vacío.').show(300).delay(3000).hide(300);
               $('#nombre_edit').focus();
               return false;
            }else if(data == 2){
              $('#mensaje_mod_edit').addClass('exito').html("El Modelo <b>"+nombre+"</b> ha sido actualizada con éxito.").show(300).delay(3000).hide(300);;
              $('#detalle_modelo').html(data);
              loadmodelos(1);
            }else if (data == 3) {
              $('#mensaje_mod_edit').addClass('error').html('Error. Por favor comuníquese con el Administrador del Sistema').show(300).delay(3000).hide(300);
              $('#nombre_edit').focus();
              return false;
            }
      },
      error:function(data)
        {
          $('#mensaje_mod_edit').addClass('error').html('Error. Por favor comuníquese con el Administrador del Sistema').show(300).delay(3000).hide(300);
          $('#nombre_edit').focus();
        }
    });
});


function EliminarModelo(id){
  var route = "../php/modelo/eliminar.php";
  $.alertable.confirm("¿Está seguro de eliminar el modelo seleccionado?").then(function(){
    $.ajax({
    type:'POST',
    url:route,
    data:'id='+id,
         success: function(data){
          if (data == 1) {
            loadmodelos(1);
          }else{
            
          }
         }
    });
  });
}