
$("#producto").autocomplete({
    source: function (request, response) {
        var url = document.getElementById("url").value;
        $.ajax({
            type: "POST",
            url: url + "/" + "producto/pedido",
            data: request,
            success: response,
            dataType: "json",
        });
    },
}, {
    minLength: 1,
}, {
    select: function (event, ui) {


        let url = document.getElementById("url").value;
        let id_mesa = document.getElementById("id_mesa_pedido").value;
        let id_usuario = document.getElementById("id_usuario").value;
        let id_producto = ui.item.id_producto;

        if (id_mesa == "") {

            $('#error_producto').html('No se ha seleccionado una mesa ')

        } else if (id_mesa != "") {

            $.ajax({
                data: {
                    id_producto,
                    id_mesa,
                    id_usuario
                },
                url: url + "/" + "pedidos/agregar_producto",
                type: "POST",
                success: function (resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {

                        $('#producto').val('');
                        $('#mesa_productos').html(resultado.productos_pedido)
                        $('#valor_pedido').html(resultado.total_pedido)
                        $('#subtotal_pedido').val(resultado.total_pedido)
                    }
                },
            });
        }
    },
});
