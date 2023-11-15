function factura_electronica(id_mesa, estado, nit_cliente, id_usuario, url, pago_total, valor_venta, tipo_pago, efectivo, transaccion, id_usuario,propina_format) {

    if (pago_total >= parseInt(valor_venta)) {
        $.ajax({
            data: {
                id_usuario,
                nit_cliente,
                id_mesa,
                tipo_pago,
                valor_venta,
                efectivo,
                transaccion,
                estado,
                pago_total,
                propina_format
            },
            url: url + "/" + "factura_electronica/pre_factura",
            type: "POST",
            success: function (resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Error en la cantidad",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#2AA13D",
                    });
                }
                if (resultado.resultado == 1) {

                    limpiar_todo();
                    var mesas = document.getElementById("todas_las_mesas");
                    mesas.style.display = "block";


                    $('#finalizar_venta').modal('hide');

                    $('#todas_las_mesas').html(resultado.mesas)
                    $('#mesa_productos').html(resultado.productos)
                    $('#lista_categorias').html(resultado.categorias)
                    let lista_categorias = document.getElementById("lista_categorias");
                    lista_categorias.style.display = "none";

                    Swal.fire({
                        title: 'Resumen de prefactura electrónica',
                        showDenyButton: false,
                        confirmButtonText: 'Facturar',
                        denyButtonText: 'Facturar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        html: '<hr>' + resultado.mensaje +
                            '<div class="container">' +
                            '<div class="row">' +
                            '<div class="col-md-6 text-right-custom h1">Total :</div>' +
                            '<div class="col-md-6 text-right-custom h1">' + resultado.total + '</div>' +
                            '</div>' +
                            '<hr class="custom-hr">' + // Línea de separación personalizada
                            '<div class="row">' +
                            '<div class="col-md-6 text-right-custom h1">Valor pagado :</div>' +
                            '<div class="col-md-6 text-right-custom h1">' + resultado.valor_pago + '</div>' +
                            '</div>' +
                            '<hr class="custom-hr">' + // Línea de separación personalizada
                            '<div class="row">' +
                            '<div class="col-md-6 text-right-custom h1">Cambio : </div>' +
                            '<div class="col-md-6 text-right-custom h1">' + resultado.cambio + '</div>' +
                            '</div>' +
                            '<hr class="custom-hr">' + // Línea de separación personalizada
                            '</div>',

                        confirmButtonColor: '#6782EF',
                        denyButtonColor: '#6782EF',

                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            // Swal.fire('Saved!', '', 'success')


                            let numero_de_factura = resultado.id_factura

                            $.ajax({
                                data: {
                                    numero_de_factura,
                                },
                                url: url + "/" + "pedidos/imprimir_factura",
                                type: "POST",
                                success: function (resultado) {
                                    var resultado = JSON.parse(resultado);
                                    if (resultado.resultado == 1) {


                                        let mesas = document.getElementById("todas_las_mesas");
                                        mesas.style.display = "block"

                                        let lista_categorias = document.getElementById("lista_categorias");
                                        lista_categorias.style.display = "none";
                                        
                                        /**
                                         * Aca llamo a la funcion sweet alert y se le pasan los parametros.
                                         */
                                        sweet_alert('success', 'Impresión de factura correcto  ');
                                    }
                                },
                            });




                        } else if (result.isDenied) {
                            let id_factura = resultado.id_factura

                            $.ajax({
                                data: {
                                    id_factura,
                                },
                                url: url + "/" + "factura_pos/modulo_facturacion",
                                type: "get",
                                success: function (resultado) {
                                    var resultado = JSON.parse(resultado);
                                    if (resultado.resultado == 1) {

                                        let mesas = document.getElementById("todas_las_mesas");
                                        mesas.style.display = "block"

                                        let lista_categorias = document.getElementById("lista_categorias");
                                        lista_categorias.style.display = "none";

                                        /**
                                         * Aca llamo a la funcion sweet alert y se le pasan los parametros.
                                         */
                                        sweet_alert('success', 'Se ha finalizado la venta ');
                                    }
                                },
                            });
                        }
                    })
                }
            },
        });
    } else if (pago_total < parseInt(valor_venta)) {
        $('#valor_pago_error').html('¡ Pago insuficiente !')
    }
}
