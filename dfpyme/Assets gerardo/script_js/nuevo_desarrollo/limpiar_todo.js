function limpiar_todo() {
    $('#nit_cliente').val('22222222')
    $('#nombre_cliente').val('22222222 CUANTIAS MENORES')
    $('#id_mesa_pedido').val('')
    $('#nota_pedido').val('')


    $('#pedido_mesa').html('Pedido')
    $('#mesa_pedido').html('Mesa')
    $('#mesa_productos').html('')
    $('#sub_total').html(0)
    $('#valor_pedido').html('$0')
    $('#productos_categoria').html('')
    $('#subtotal_pedido').val('$0')


    $('#propina_del_pedido').val(0);
    $('#total_propina').val(0);
    $('#efectivo').val(0);
    $('#propina_pesos').val(0);
    $('#transaccion').val('');
    $("#documento")[0].selectedIndex = 0;
    $('#pago').html('Valor pago: 0');
    $('#cambio').html('Cambio: 0');
    $('#mesa_pedido').html('');
    $('#sub_total_pedido').html('Sub total: 0');

}