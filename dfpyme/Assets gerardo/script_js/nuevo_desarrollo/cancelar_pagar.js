function cancelar_pagar() {
    $('#finalizar_venta').modal('hide')
    $('#efectivo').val('')
    $('#transaccion').val('')
    $('#pago').html('Valor pago: 0')
    $('#cambio').html('Cambio: 0')
    $('#error_documento').html('')

    let id_mesa = document.getElementById("id_mesa_pedido").value;
    let url = document.getElementById("url").value;
    let tipo_pago = document.getElementById("tipo_pago").value;

  
    if (tipo_pago == 0) {
        $.ajax({
            type: 'post',
            url: url + "/" + "pedidos/cancelar_pago_parcial ", // Cambia esto a tu script PHP para insertar en la base de datos
            data: {
                id_mesa,

            }, // Pasar los datos al script PHP
            success: function (resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {

                    $("#partir_factura").modal("hide");



                }
            },
        });
    }
}