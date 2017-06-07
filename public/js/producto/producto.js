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

$('#stock_aument').change(StockTotal);
function StockTotal(){
    var stock = parseInt($('#stock_actual').val());
    var stock_aum = parseInt($('#stock_aument').val());
    var stock_total = stock+stock_aum;
    $('#stock_total').val(stock_total);
}