function agregar_al_pedido(id_producto) {

    let url = document.getElementById("url").value;
    let id_mesa = document.getElementById("id_mesa_pedido").value;
    let id_usuario = document.getElementById("id_usuario").value;

    $.ajax({
        data: {
            id_producto,
            id_mesa,
            id_usuario
        },
        url: url + "/" + "pedidos/agregar_producto",
        type: "POST",
        success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                sweet_alert('success','Producto agregado')
                $('#mesa_productos').html(resultado.productos_pedido)
            }
        },
    });

}