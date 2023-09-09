<?php $user_session = session(); ?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- CSS files -->
    <link href="<?= base_url() ?>/public/css/tabler.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/public/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="<?= base_url() ?>/Assets/css/mesas.css" rel="stylesheet" />
    <!-- Jquery date picker  -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/Assets/plugin/calendario/jquery-ui-1.12.1.custom/jquery-ui.css">
    <!-- Jquery-ui -->
    <link href="<?php echo base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.css" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/Assets/img/favicon.png">
    <style>
        /* CSS para desactivar el resaltado de selección de texto */
        body {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    <style>
        /* Estilo personalizado para reducir el espaciado entre las líneas */
        .custom-hr {
            margin: 5px 0;
            /* Ajusta el espaciado vertical según tus preferencias */
        }

        /* Estilo personalizado para alinear a la derecha */
        .text-right-custom {
            text-align: right;
        }
    </style>

    <style>
        .card_mesas {
            width: 170px;
            /* Puedes ajustar este valor según tus necesidades */
            padding: 10px;
            /* Ajusta el relleno según lo necesario */
            margin-bottom: 0.5 px;
            /* Ajusta el margen según lo necesario */
            border: 1px solid #ccc;
            /* Agrega bordes para una apariencia de tarjeta */

        }
    </style>
    <style>
        .form-control-rounded {
            width: 100%;
        }

        .card-title {
            width: 100%;
            /* Asegura que el contenedor tiene ancho completo */
        }
    </style>


    <style>
        /* Aplicar a un input de tipo number específico */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Para navegadores que no son WebKit (como Firefox) */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>


    <style>
        .div {

            width: 100px;
            height: 10px;
            padding-right: 5px;
            /* Pequeño relleno entre los divs */
            box-sizing: border-box;
            /* Asegura que el relleno no afecte las dimensiones totales */
        }
    </style>



</head>

<body>
    <script src="<?= base_url() ?>/public/js/demo-theme.min.js?1684106062"></script>
    <?= $this->renderSection('content') ?>

    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url() ?>/public/js/tabler.min.js?1684106062" defer></script>
    <script src="<?= base_url() ?>/public/js/demo.min.js?1684106062" defer></script>

    <?= $this->include('pedidos/modal_pago_parcial') ?>
    <?= $this->include('pedidos/modal_agregar_nota') ?>
    <?= $this->include('pedidos/modal_finaliza_venta') ?>
    <?= $this->include('pedidos/modal_retiro_dinero') ?>
    <?= $this->include('ventanas_modal_pedido/cambiar_de_mesa') ?>
    <?= $this->include('ventanas_modal_retiro_de_dinero/imprimir_retiro') ?>
    <?= $this->include('ventanas_modal_retiro_de_dinero/devolucion') ?>
    <!--jQuery -->
    <script src="<?= base_url() ?>/Assets/js/jquery-3.5.1.js"></script>
    <!-- jQuery-ui -->
    <script src="<?php echo base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.js"></script>
    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>/Assets/plugin/sweet-alert2/sweetalert2@11.js"></script>
    <!-- Locales -->
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/actualizar_nota.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/agregar_nota.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/sweet_alert.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/prefactura.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/pedido.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/productos_categoria.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/limpiar_todo.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/agregar_al_pedido.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/producto_autocomplete.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/pedido_mesa.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/imprimir_comanda.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/insertar_nota.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/limpiar_campos.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/cambiar_mesas.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/intercambio_mesas.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/todas_las_mesas.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/ocultar_menu.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/mostrar_menu.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/mesas_salon.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/get_mesas.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/eliminar_producto.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/actualizar_cantidades.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/eliminar_pedido.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/pago_parcial.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/eliminar_cantidades.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/retiro_efectivo.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/imprimir_retiro_de_dinero.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/cambio.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/retiro_dinero.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/total.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/finalizar_venta.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/saltar_factura_pos.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/detener_propagacion.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/actualizar_partir_factura.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/factura_electronica.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/pagar.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/habilitarBotonPago.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/cancelar_pagar.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/factura_pos/devolucion.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/calcular_propina.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/total_pedido.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/criterio_propina.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/buscar_por_codigo_de_barras_devolucion.js"></script>
    <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/actualizar_producto_cantidad.js"></script>


    <script>
        const total_propina = document.querySelector("#total_propina");

        function formatNumber(n) {
            // Elimina cualquier carácter que no sea un número
            n = n.replace(/\D/g, "");
            // Formatea el número
            return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
        }

        total_propina.addEventListener("input", (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    </script>


    <script>
        function total_pedido_final(valor) {
            var sub_total = document.getElementById("valor_total_a_pagar").value;

            temp_valor = "";

            if (valor === "") {
                temp_valor = 0
            } else {
                temp_valor = valor;
            }

            if (temp_valor != 0) {
                temp_valor = valor.replace(/\./g, ''); // Elimina el punto
            }

            valor_pedido = parseInt(sub_total) + parseInt(temp_valor)

            $('#total_pedido').html('Total: $ ' + valor_pedido.toLocaleString('es-CO'))

        }
    </script>

    <script>
        function calcular_propina_final(propina) {

            var criterio_propina = document.getElementById("criterio_propina_final").value;
            var subtotal = document.getElementById("valor_total_a_pagar").value;


            temp_propina = 0;

            if (propina === "") {
                temp_propina = 0;
            } else {
                temp_propina = propina
            }



            if (criterio_propina == 1) {

                if (temp_propina >= 0 && temp_propina < 100) {
                    let porcentaje = parseInt(temp_propina) / 100
                    valor_propina = parseInt(subtotal) * parseFloat(porcentaje)
                    var propinaFormateada = valor_propina.toLocaleString('es-ES');

                    //console.log(valor_propina)
                    total = parseInt(valor_propina) + parseInt(subtotal)




                    //$('#valor_total_a_pagar').val(total)
                    $('#total_propina').val(propinaFormateada)

                    if (total >= 0) {
                        $('#total_pedido').html("Total " + total.toLocaleString('es-ES'))
                    }

                }

            }


            if (criterio_propina == 2) {

                const propina_en_pesos = document.querySelector("#propina_pesos");

                function formatNumber(n) {
                    // Elimina cualquier carácter que no sea un número
                    n = n.replace(/\D/g, "");
                    // Formatea el número
                    return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
                }

                propina_en_pesos.addEventListener("input", (e) => {
                    const element = e.target;
                    const value = element.value;
                    element.value = formatNumber(value);
                });

                var propina_pesos = document.getElementById("propina_pesos").value;
                var propina_pesos_limpio = subtotal.replace(/\$|\.+/g, "");

                total = parseInt(propina_pesos_limpio) + parseInt(subtotalLimpio)

                //$('#propina_del_pedido').val(propinaFormateada)
                $('#valor_pedido').html(total.toLocaleString('es-ES'))

            }


        }
    </script>




    <script>
        const propina_pedido = document.querySelector("#propina_del_pedido");

        function formatNumber(n) {
            // Elimina cualquier carácter que no sea un número
            n = n.replace(/\D/g, "");
            // Formatea el número
            return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
        }

        propina_pedido.addEventListener("input", (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    </script>

    <script>
        let mensaje = "<?php echo $user_session->getFlashdata('mensaje'); ?>";
        let iconoMensaje = "<?php echo $user_session->getFlashdata('iconoMensaje'); ?>";
        if (mensaje != "") {
            sweet_alert(iconoMensaje, mensaje)
        }
    </script>


    <script>
        $("#devolucion_producto").autocomplete({
            source: function(request, response) {
                var url = document.getElementById("url").value;
                $.ajax({
                    type: "POST",
                    url: url + "/" + "producto/pedido_pos",
                    //data: request,
                    data: {
                        term: request.term,
                        extraParams: $('#lista_precios').val()
                    },
                    success: response,
                    dataType: "json",
                });
            },
            appendTo: "#devolucion",
        }, {
            minLength: 1,
        }, {
            select: function(event, ui) {
                $("#devolucion_producto").val(ui.item.value);
                $("#codigo_producto_devolucion").val(ui.item.id_producto);
                $("#precio_devolucion").val(ui.item.valor_venta_producto);
                //$("#cantidad_factura_pos").focus();
                //document.getElementById("cantidad_factura_pos").focus()

            },
        });
    </script>



    <script>
        function actualizar_cantidad_partir_factura(cantidad, id, cantidad_producto) {
            var url = document.getElementById("url").value;
            let id_mesa = document.getElementById("id_mesa_pedido").value;
            let id_tabla = id

            $.ajax({
                data: {
                    cantidad,
                    id,
                    cantidad_producto,
                    id_mesa
                },
                url: url +
                    "/" +
                    "pedidos/partir_factura",
                type: "POST",
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 0) {
                        Swal.fire({
                            icon: "success",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#2AA13D",
                            title: "Operacion cancelada",
                        });
                    } else if (resultado.resultado == 1) {
                        /*$("#valor_producto_partir_factura").html(
                          resultado.valor_total_producto
                        );*/
                        $("#total_factura_mostrar").html(
                            resultado.valor_total_pedido
                        );
                        $("#items_facturar_partir").html(resultado.productos);
                        Swal.fire({
                            icon: "success",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#2AA13D",
                            title: "Operación exitosa",
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                myModal = new bootstrap.Modal(
                                    document.getElementById("items_partir_factura"), {}
                                );
                                myModal.show();
                            }
                        });
                    }
                },
            });

        }
    </script>


    <script type="text/javascript">
        function valideKey(evt) {

            // code is the decimal ASCII representation of the pressed key.
            var code = (evt.which) ? evt.which : evt.keyCode;

            if (code == 8) { // backspace.
                return true;
            } else if (code >= 48 && code <= 57) { // is a number.
                return true;
            } else { // other keys.
                return false;
            }
        }
    </script>

    <script>
        $("#buscar_cliente").autocomplete({
            source: function(request, response) {
                var url = document.getElementById("url").value;
                $.ajax({
                    type: "POST",
                    url: url + "/" + "clientes/clientes_autocompletado",
                    data: request,
                    success: response,
                    dataType: "json",
                });
            },
            appendTo: "#finalizar_venta",
        }, {
            minLength: 1,
        }, {
            select: function(event, ui) {
                // $("#id_cliente_factura_pos").val(ui.item.value);
                //$("#clientes_factura_pos").val(ui.item.nit_cliente);
                $("#nit_cliente").val(ui.item.nit_cliente);
                $("#nombre_cliente").val(ui.item.value);
                $(this).val("");
                return false;
                //$('#buscar_cliente').val(''); 
            },
        });
    </script>


    <script>
        const efectivo = document.querySelector("#efectivo");

        function formatNumber(n) {
            // Elimina cualquier carácter que no sea un número
            n = n.replace(/\D/g, "");
            // Formatea el número
            return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
        }

        efectivo.addEventListener("input", (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    </script>

    <script>
        const transaccion = document.querySelector("#transaccion");

        function formatNumber(n) {
            // Elimina cualquier carácter que no sea un número
            n = n.replace(/\D/g, "");
            // Formatea el número
            return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
        }

        transaccion.addEventListener("input", (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    </script>

    <script>
        const retiro = document.querySelector("#valor_retiro");

        function formatNumber(n) {
            // Elimina cualquier carácter que no sea un número
            n = n.replace(/\D/g, "");
            // Formatea el número
            return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
        }

        retiro.addEventListener("input", (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    </script>


    <script>
        function cambio_transaccion(valor) { //Se recibe un un valor desde el formulario de pagos 
            var res = 0;
            let pago = 0;

            transaccionFormat = valor.replace(/[.]/g, ""); //Se quita el punto del valor recibido 

            let valorAsignado = transaccionFormat === "" ? 0 : parseInt(transaccionFormat); // Validamos que si valor esta vacio le asigne un cero 

            var valor_venta = document.getElementById("valor_total_a_pagar").value; // El valor de la venta 
            var transaccion = valorAsignado; // Valor sin punto o en caso de haber llegado vacio cero 



            let valor_efectivo = document.getElementById("efectivo").value;
            let efectivoFormat = valor_efectivo.replace(/[.]/g, "");
            let valor_e = efectivoFormat;

            // Asigna un valor predeterminado de cero si "valor" está vacío
            let efectivo = valor_e === "" ? 0 : parseInt(valor_e);


            sub_total = parseInt(efectivo) + parseInt(transaccion);
            res = parseInt(sub_total) - parseInt(valor_venta);



            resultado = res.toLocaleString('es-CO');
            if (res > 0) {
                $('#cambio').html('Cambio: $' + resultado)
            }
            if (res < 0) {
                $('#cambio').html('Cambio: $ 0')
                $('#pago').html('Valor pago: $ 0')
            }

            //if (sub_total > valor_venta) {
                $('#pago').html('Valor pago: $' + sub_total.toLocaleString('es-CO'))
            //}

        }
    </script>


    <script>
        function restar_partir_factura(event, cantidad, id_tabla_producto) {
            event.stopPropagation()

            let url = document.getElementById("url").value;


            $.ajax({
                data: {
                    id_tabla_producto,
                    cantidad
                },
                url: url + "/" + "pedidos/restar_partir_factura",
                type: "POST",
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {

                        $('#total_pago_parcial').html(resultado.total)
                        $("#productos_pago_parcial").html(resultado.productos);



                    }
                },
            });

        }
    </script>

    <script>
        function cancelar_pago_parcial() {

            let id_mesa = document.getElementById("id_mesa_pedido").value;
            let url = document.getElementById("url").value;

            $.ajax({
                type: 'post',
                url: url + "/" + "pedidos/cancelar_pago_parcial ", // Cambia esto a tu script PHP para insertar en la base de datos
                data: {
                    id_mesa,

                }, // Pasar los datos al script PHP
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {

                        sweet_alert('warning', 'Cancelación de pagos parciales')
                        $("#partir_factura").modal("hide");



                    }
                },
            });

        }
    </script>



    <script>
        function pagar_parcial() {



            let url = document.getElementById("url").value;
            let id_mesa = document.getElementById("id_mesa_pedido").value;

            $.ajax({
                data: {
                    id_mesa,
                },
                url: url + "/" + "pedidos/valor_pago_parcial",
                type: "POST",
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {


                        if (resultado.valor_total !== null && resultado.valor_total > 0) {
                            $('#partir_factura').modal('hide');
                            $('#finalizar_venta').modal('show');
                            $('#sub_total_pedido').html("Sub total: " + resultado.total)
                            $('#mensaje_factura').html(resultado.total)
                            $('#mensaje_factura').html(resultado.factura_electronica)
                            $('#total_pedido').html(resultado.total)
                            $('#tipo_pago').val(0)
                            $('#valor_total_a_pagar').val(resultado.valor_total)
                            $('#requiere_factura_electronica').val(resultado.requiere_factura_electronica)
                            $('#total_propina').val(0)

                        } else if (resultado.valor_total === null) {
                            sweet_alert('warning', ' ! No hay productos para efectuar pagos parciales ¡')
                        }

                    }
                },
            });
        }
    </script>


    <script>
        function calculo_propina() {
            let url = document.getElementById("url").value;
            let id_mesa = document.getElementById("id_mesa_pedido").value;

            if (id_mesa == "") {
                sweet_alert('warning', 'No hay pedido')
            } else if (id_mesa != "") {

                $.ajax({
                    data: {
                        id_mesa,
                    },
                    url: url + "/" + "pedidos/propinas",
                    type: "POST",
                    success: function(resultado) {
                        var resultado = JSON.parse(resultado);
                        if (resultado.resultado == 1) {

                            $('#propina_del_pedido').val(resultado.propina)
                            $('#valor_pedido').html(resultado.total_pedido)

                        }
                    },
                });
            }
        }
    </script>

</body>

</html>