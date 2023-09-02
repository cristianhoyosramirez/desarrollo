
function pagar() {

    let requiere_factura_electronica = document.getElementById("requiere_factura_electronica").value; // Determinar si se requiere factura electronica o no  
    let estado = document.getElementById("documento").value; // Tipo de documento 
    let valor_venta = document.getElementById("valor_total_a_pagar").value; // El valor de la venta 
    let valor_efectivo = document.getElementById("efectivo").value;
    efectivoFormat = valor_efectivo.replace(/[.]/g, "");
    let valor_e = efectivoFormat;
    // Asigna un valor predeterminado de cero si "valor" está vacío
    let efectivo = valor_e === "" ? 0 : parseInt(valor_e);
    let valor_t = document.getElementById("transaccion").value;
    valor_t_Format = valor_t.replace(/[.]/g, "");
    // Asigna un valor predeterminado de cero si "valor" está vacío
    let transaccion = valor_t_Format === "" ? 0 : parseInt(valor_t_Format); //Pago electronico 
    let banco = document.getElementById("banco").value; // Banco con el se registra un pago por pagos electronicos 
    let nit_cliente = document.getElementById("nit_cliente").value; // nit cliente  
    let id_mesa = document.getElementById("id_mesa_pedido").value; // id de la mesa 
    let url = document.getElementById("url").value; // url base
    let id_usuario = document.getElementById("id_usuario").value; // id del usuario 
    let pago_total = parseInt(efectivo) + parseInt(transaccion);
    let tipo_pago = document.getElementById("tipo_pago").value; // Tipo de pago 1 = pago completo; 2 pago parcial

    
    if (requiere_factura_electronica == "si") {  // Validacion de si requiere o no factura electronica 

        if (estado == 8) {    // Validacion de que este seleccionada la factura electronica 

            factura_electronica(id_mesa, estado, nit_cliente, id_usuario, url,pago_total,valor_venta,tipo_pago,efectivo,transaccion,id_usuario)
        } else if (estado != 8) {
            $('#error_documento').html('! Para continuar por favor seleccione Factura electrónica !')
        }

    } else if (requiere_factura_electronica == "no") {
          
        if (pago_total >= parseInt(valor_venta)) {

            if (estado == 8) {

                factura_electronica(id_mesa, estado, nit_cliente, id_usuario, url,pago_total,valor_venta,tipo_pago,efectivo,transaccion,id_usuario)

            } else if (estado != 8) {

                $.ajax({
                    data: {
                        id_mesa,
                        efectivo,
                        transaccion,
                        estado,
                        nit_cliente,
                        valor_venta,
                        id_usuario

                    },
                    url: url + "/" + "pedidos/cerrar_venta",
                    type: "POST",
                    success: function (resultado) {
                        var resultado = JSON.parse(resultado);
                        if (resultado.resultado == 1) {
                            limpiar_todo();
                            //$('#efectivo').val(0)
                            $('#finalizar_venta').modal('hide');
                            $('#todas_las_mesas').html(resultado.mesas)
                            $('#lista_completa_mesas').html(resultado.mesas)
                            
                            let mesas = document.getElementById("todas_las_mesas");
                            mesas.style.display = "block"

                            

                            Swal.fire({
                                title: 'Resumen',
                                showDenyButton: true,
                                confirmButtonText: 'Imprimir factura',
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

                                confirmButtonColor: '#58C269',
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
            }
        } else if (pago_total < parseInt(valor_venta)) {
            $('#valor_pago_error').html('¡ Pago insuficiente !')
        }

    }
}
