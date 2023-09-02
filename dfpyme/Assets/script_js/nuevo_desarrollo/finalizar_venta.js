function finalizar_venta() {

    let id_mesa = document.getElementById("id_mesa_pedido").value;
    var url = document.getElementById("url").value;
    if (id_mesa != "") {
        $.ajax({
            data: {
                id_mesa
            },
            url: url + "/" + "pedidos/valor",
            type: "POST",
            success: function (resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {
                    $('#finalizar_venta').on('shown.bs.modal', function () {
                        $('#efectivo').focus();
                    })
                    $('#total_pedido').html(resultado.total)
                    $('#valor_total_a_pagar').val(resultado.valor_total)
                    $('#sub_total_pedido').html(resultado.sub_total)
                    $('#requiere_factura_electronica').val(resultado.requiere_factura_electronica)

                    /* $("#finalizar_venta").on("shown.bs.modal", function() {
                        // Selecciona automáticamente el texto en el input
                        $("#transaccion").select();
                    }); */
                    if (resultado.factura_electronica == 1) {
                        // Obtén una referencia al botón
                        var boton = document.getElementById("btn_pagar");
                        // Deshabilitar el botón
                        boton.disabled = true;
                    }

                    $('#mensaje_factura').html(resultado.factura_electronica);

                    $("#finalizar_venta").modal("show");



                }
                if (resultado.resultado == 0) {

                    Swal.fire({
                        title: '¡ Debe abrir la caja ! ',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        icon: 'warning'
                    })
                }
            },
        });
    }
    if (id_mesa == "") {
        sweet_alert('warning', 'No hay pedido')
    }
}