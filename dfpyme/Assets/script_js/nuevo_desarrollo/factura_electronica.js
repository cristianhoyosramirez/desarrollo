let invoice = { id: 0, dian_status: "", order_reference: "" }
let erroresp = { errors: [] };
let Error = { error: "" };



async function sendInvoice(iddoc) {
    invoice.id = iddoc;
    $("#id_de_factura").val(iddoc);
    $("#barra_progreso").modal("show");

    //let url = new URL("http://localhost:5000/api/Invoice/id");
    let url = new URL("http://localhost:3000/api2");
    url.search = new URLSearchParams({ id: iddoc });
    const response = await fetch(url, { method: "GET" });
    const data = await response.json();
    console.log(invoice.id)
    if (response.status === 200) {
        invoice = JSON.parse(JSON.stringify(data, null, 2));

        //alert('Fact No ' + invoice.id + ' ' + invoice.order_reference + ' ' + invoice.dian_status);
        //console.log('Fact No ' + invoice.order_reference + ' ' + invoice.dian_status);

        // $("#barra_progreso").modal("hide");
        //$("#id_factura").val(invoice.id);
        $("#id_factura").val(iddoc);
        $("#barra_de_progreso").hide();
        $("#respuesta_dian").show();
        $("#opciones_dian").show();
        $("#texto_dian").html(invoice.order_reference + ' ' + invoice.dian_status);


    }
    else if (response.status === 400) {   // Advertencia
        erroresp = JSON.parse(JSON.stringify(data, null, 2));
        //console.log(erroresp.errors[0].error);
        //alert(erroresp.errors[0].error);
        $("#barra_de_progreso").hide();
        $("#respuesta_dian").show();
        $("#error_dian").show();
        $("#texto_dian").html(erroresp.errors[0].error);
        //$("#id_factura").val(invoice.id);
        $("#id_factura").val(iddoc);
    }
    else {
        Error = JSON.parse(JSON.stringify(data, null, 2));  //Error Api 
        //alert(Error.error);
        $("#barra_de_progreso").hide();
        $("#respuesta_dian").show();
        $("#error_dian").show();
        $("#texto_dian").html('Respuesta DIAN: ' + erroresp.errors[0].error);
        //$("#id_factura").val(invoice.id);
        $("#id_factura").val(iddoc);
    }

}

function factura_electronica(id_mesa, estado, nit_cliente, id_usuario, url, pago_total, valor_venta, tipo_pago, efectivo, transaccion, id_usuario, propina_format) {
    let button = document.querySelector("#btn_pagar");
    button.disabled = true; // Habilitar el botón

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
                if (resultado.resultado == 1) {let button = document.querySelector("#btn_pagar");
                button.disabled = false; // Habilitar el botón



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
                        title: 'Información de pago',
                        showDenyButton: true,
                        confirmButtonText: 'Trasmitir', // Se intercambia con denyButtonText
                        denyButtonText: 'Nueva factura', // Se intercambia con confirmButtonText
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


                            /*  $.ajax({
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
                              });  */

                            sendInvoice(id_factura);

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

                                        btnPagar.setAttribute("disabled", "true");

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
