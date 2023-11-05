
function pedido_mesa(id_mesa, nombre_mesa) {
    $('#mesa_pedido').html('Mesa: ' + nombre_mesa)
    $('#id_mesa_pedido').val(id_mesa)

    let categorias = document.getElementById("lista_categorias");
    categorias.style.display = "block";



    let mesas = document.getElementById("todas_las_mesas");
    mesas.style.display = "none";

    let url = document.getElementById("url").value;
    $.ajax({
        data: {

            id_mesa,

        },
        url: url + "/" + "pedidos/pedido",
        type: "POST",
        success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                $('#mesa_productos').html(resultado.productos_pedido)
                $('#id_mesa_pedido').val(resultado.id_mesa)
                $('#pedido_mesa').html('Pedido: ' + resultado.numero_pedido)
                $('#valor_pedido').html(resultado.total_pedido)
            }
        },
    });

}