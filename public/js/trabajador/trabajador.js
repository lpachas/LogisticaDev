$(document).ready(function(){
  loadtrabajadores(1);
}); 

function loadtrabajadores(page){
  var dato= $("#dato").val();
  $.ajax({
      url:'../php/trabajador/buscar_trabajador.php?action=ajax&page='+page+'&dato='+dato,
      success:function(res){
          $('#detalle_trabajador').html(res).fadeIn('slow');
      }
  });
}

$('#btn_new_trabajador').on('click',function(){
    $('#FormCreateTrabajador')[0].reset();
    $('#reg_trabajador_mod').modal({
        show:true,
        backdrop:'static' 
    });
});

$('#btnregistrar_trabajador').click(function (e)
{
	  e.preventDefault();
    $('#mensaje').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
    var nombres = $('#nombres').val();
    var ap_pat = $('#apellido_paterno').val();
    var ap_mat = $('#apellido_materno').val();
    var dni = $('#dni').val();
    var cargo = $('#cargo').val();
    var sueldo = $('#sueldo').val();
    var route ="../php/trabajador/agregar_trabajador.php";
    var dataString = {'nombres':nombres,'ap_pat':ap_pat,'ap_mat':ap_mat,'dni':dni,'cargo':cargo,'sueldo':sueldo};

    console.log(dataString);

    $.ajax({
      url: route,
      type:'post' ,
      data: dataString,
      success:function(data)
      {
        if (data == 1) {
            $('#mensaje').addClass('error').html('Ya existe un trabajador con el número de DNI ingresado.').show(300).delay(3000).hide(300);
            $('#dni').focus();
            return false;
        }else if (data == 2) {
            $('#mensaje').addClass('error').html('Error al registrar el trabajador.Por favor, revise los datos.').show(300).delay(3000).hide(300);
            $('#nombres').focus();
            return false;
        }else if(data == 3){
            $('#mensaje').addClass('exito').html("El trabajador ha sido registrado").show(300).delay(3000).hide(300);
            $('#FormCreateTrabajador')[0].reset();
            $('#detalle_trabajador').html(data);
            loadtrabajadores(1);
        }   
      },
      error:function(){
      		  $('#mensaje').addClass('error').html('Ha ocurrido un error.Por favor, comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
            $('#nombres').focus();
            loadtrabajadores(1);
      }
  	});
});


var EditarTrabajador = function(id){
  $('#formulario_edit_trabajador')[0].reset();
  var url = '../php/trabajador/editar_trabajador_datos.php';
    $.ajax({
    type:'POST',
    url:url,
    data:'id='+id,
    success: function(valores){
        var datos = eval(valores);
        $('#id_edit_trabajador').val(id);
        $('#nombres_edit').val(datos[0]);
        $('#ap_paterno_edit').val(datos[1]);
        $('#ap_materno_edit').val(datos[2]);
        $('#dni_edit').val(datos[3]);
        $('#cargo_edit').val(datos[4]);
        $('#sueldo_edit').val(datos[5]);
        $('#edit_trabajador_mod').modal({
          show:true,
          backdrop:'static'
        });
      return false;
    }
  });
  return false;
}



$("#btnedit_trabajador").on('click',function(e){
    e.preventDefault();
    $('#mensaje-edit').addClass('text-center').html('<img src="../img/ajax-loader.gif"> Cargando...');
    var id = $("#id_edit_trabajador").val();
    var nombres = $("#nombres_edit").val();
    var ap_pat = $('#ap_paterno_edit').val();
    var ap_mat = $('#ap_materno_edit').val();
    var dni = $('#dni_edit').val();
    var cargo = $('#cargo_edit').val();
    var sueldo = $('#sueldo_edit').val();
    var data={'id':id,'nombres':nombres,'ap_pat':ap_pat,'ap_mat':ap_mat,'dni':dni,'cargo':cargo,'sueldo':sueldo};
    var route = "../php/trabajador/editar_trabajador.php";    
      $.ajax({
          url:route,
          type:'post',
          data: data,
          success: function(data){
            if (data == 1) {
              $('#mensaje-edit').addClass('error').html('Error al registrar el trabajador.Por favor, revise los datos.').show(300).delay(3000).hide(300);
              $('#nombres_edit').focus();
              return false;
            }else if(data == 2){
              $('#mensaje-edit').addClass('exito').html("El trabajador ha sido actualizado").show(300).delay(3000).hide(300);
              $('#detalle_trabajador').html(data);
              loadtrabajadores(1);
            }else if(data == 3){
              $('#mensaje-edit').addClass('error').html('Ha ocurrido un error en la edición.Comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
              $('#nombres_edit').focus();
              loadtrabajadores(1);
            }
      },
      error:function(data)
        {
          $('#mensaje-edit').addClass('error').html('Ha ocurrido un error en la edición.Comuníquese con el Administrador del Sistema.').show(300).delay(3000).hide(300);
          $('#nombres_edit').focus();
          loadtrabajadores(1);
        }
    });
});

var ActivarTrabajador = function(id){
  var route = "../php/trabajador/activar.php";
  $.alertable.confirm("¿Activar la cuenta del trabajador seleccionado?").then(function(){
    $.ajax({
    type:'POST',
    url:route,
    data:'id='+id,
         success: function(data){
          if (data == 2) {
            $('#detalle_trabajador').html(data);
            loadtrabajadores(1);
          }
         }
    });
  });
}

function DesactivarTrabajador(id){
  var route = "../php/trabajador/desactivar.php";
  $.alertable.confirm("¿Está seguro de desactivar al trabajador seleccionado?").then(function(){

    $.ajax({
    type:'POST',
    url:route,
    data:'id='+id,
         success: function(data){
          if (data == 2) {
            $('#detalle_trabajador').html(data);
            loadtrabajadores(1);
          }
         }
    });
  });
}
