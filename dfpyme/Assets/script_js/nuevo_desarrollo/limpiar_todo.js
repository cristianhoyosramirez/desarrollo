function limpiar_todo() {
    $('#nit_cliente').val('22222222')
    $('#nombre_cliente').val('CLIENTE GENERAL')
    $('#id_mesa_pedido').val('')
    $('#nota_pedido').val('')


    $('#pedido_mesa').html('Pedido')
    $('#mesa_pedido').html('Mesa')
    $('#mesa_productos').html('')
    $('#sub_total').html(0)
    $('#valor_pedido').html('$0')
    $('#productos_categoria').html('')

}