function prefactura(id) {

    let url = document.getElementById("url").value;
    let id_mesa = document.getElementById("id_mesa_pedido").value;
    if (id_mesa == "") {
        sweet_alert('warning', 'No hay pedido ')
    } else if (id_mesa != "") {
        if (id_mesa == "") {
            sweet_alert('warning', 'No hay pedido ')
        } else if (id_mesa != "") {
            $.ajax({
                data: {

                    id_mesa,

                },
                url: url + "/" + "pedidos/prefactura",
                type: "POST",
                success: function (resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {

                        sweet_alert('success', 'Impresión de prefactura')

                    }
                },
            });
        }
    }
}