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

