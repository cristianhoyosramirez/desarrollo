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
                    $('#valor_pedido').html(resultado.valor_pedio)
                    $('#subtotal_pedido').val(resultado.valor_pedio)

                    $('#id_mesa_pedido').val(resultado.id_mesa)
                    $('#pedido_mesa').html("Pedido: ")
                    $('#mesa_pedido').html("Mesa: ")
                    $('#nombre_mesero').html("Mesero: ")
                    $('#tipo_pago').val(1)
                    



                    let lista_categorias = document.getElementById("lista_categorias");
                    lista_categorias.style.display = "none";
                    
                    Swal.fire({
                        title: 'Resumen de prefactura electrónica',
                        showDenyButton: true,
                        confirmButtonText: 'Imprimir factura', // Se intercambia con denyButtonText
                        denyButtonText: 'Facturar', // Se intercambia con confirmButtonText
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
                        confirmButtonColor: '#58C269', // Se intercambia con denyButtonColor
                        denyButtonColor: '#6782EF', // Se intercambia con confirmButtonColor
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            // Swal.fire('Saved!', '', 'success')
                            
                            let id_factura = resultado.id_factura

                            
                           $.ajax({
                                data: {
                                    id_factura, // Incluye el número de factura en los datos
                                },
                                url: url + "/" + "pedidos/imprimir_factura_electronica",
                                type: "POST",
                                success: function (resultado) {
                                    var resultado = JSON.parse(resultado);
                                    if (resultado.resultado == 1) {


                                        let mesas = document.getElementById("todas_las_mesas");
                                        mesas.style.display = "block"

                                        let lista_categorias = document.getElementById("lista_categorias");
                                        lista_categorias.style.display = "none";
                                        
                                       
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
