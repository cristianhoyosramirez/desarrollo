function agregar_al_pedido(id_producto) {

    let url = document.getElementById("url").value;
    let id_mesa = document.getElementById("id_mesa_pedido").value;
    let id_usuario = document.getElementById("id_usuario").value;
    let mesero = document.getElementById("mesero").value;
 

    $.ajax({
        data: {
            id_producto,
            id_mesa,
            id_usuario,
            mesero
        },
        url: url + "/" + "pedidos/agregar_producto",
        type: "POST",
        success: function (resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                sweet_alert('success', 'Producto agregado')
                $('#mesa_productos').html(resultado.productos_pedido)
                $('#valor_pedido').html(resultado.total_pedido)
                $('#val_pedido').html(resultado.total_pedido)
                $('#pedido_mesa').html('Pedido: '+resultado.numero_pedido)
                $('#subtotal_pedido').val(resultado.total_pedido)
            }
        },
    });

}