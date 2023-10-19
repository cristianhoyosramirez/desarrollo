
function pedido_mesa(id_mesa, nombre_mesa) {
    $('#mesa_pedido').html(nombre_mesa)
    $('#id_mesa_pedido').val(id_mesa)

    let tipo_pedido = document.getElementById("tipo_pedido").value;

    if (tipo_pedido == "computador") {
        let categorias = document.getElementById("lista_categorias");
        categorias.style.display = "block";
    }

    if (tipo_pedido == "computador") {
        let mesas = document.getElementById("todas_las_mesas");
        mesas.style.display = "none";
    }

    $("#lista_todas_las_mesas").modal("hide");
    $('#mesasOffcanvas').offcanvas('hide');

    let url = document.getElementById("url").value;
    $.ajax({
        data: {

            id_mesa,

        },
        url: url + "/" + "pedidos/pedido",
        type: "POST",
        success: function (resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {


                $('#val_pedido').html(resultado.total_pedido)
                $('#mesa_productos').html(resultado.productos_pedido)
                $('#nombre_mesero').html('Mesero: ' + resultado.nombre_mesero)
                $('#id_mesa_pedido').val(resultado.id_mesa)
                $('#pedido_mesa').html('Pedido: ' + resultado.numero_pedido)
                $('#valor_pedido').html(resultado.total_propina)
                $('#nota_pedido').val(resultado.nota_pedido)
                $('#subtotal_pedido').val(resultado.total_pedido)
                $('#propina_del_pedido').val(resultado.propina)
                //$("#producto").readOnly = false;
                $("#producto").attr("readonly", false);
                $("#producto").focus();
                //$("#producto").attr("readonly", false);
            }
        },
    });

}