<?php $user_session = session(); ?>
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Bienvenido DFpyme</title>
    <!-- CSS files -->
    <link href="<?= base_url() ?>/public/css/tabler.min.css" rel="stylesheet" />
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
    <div class="page">
        <!-- Navbar -->

        <div id="header">
            <?= $this->include('layout/header_mesas') ?>
        </div>

        <div id="header_oculto" class="container" style="display:none">
            <div class="row text-center align-items-center flex-row-reverse">
                <div class="col-lg-auto ms-lg-auto">
                    <ul class="list-inline list-inline-dots mb-0">

                        <li class="list-inline-item">


                            <a class=" cursor-pointer" onclick="mostrar_menu()" title="Mostar menu" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="3" y1="3" x2="21" y2="21" />
                                    <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                                    <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                                </svg></a>

                            <!--  <button type="button" class="btn btn-cyan btn-icon cursor-pointer" onclick="mostrar_menu()" title="Mostar menu" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom" > 
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="3" y1="3" x2="21" y2="21" />
                                    <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                                    <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                                </svg></button> -->
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0">

                </div>
            </div>
        </div>


        <div class="page-wrapper">
            <!-- Page body -->
            <div class="div"></div>

            <input type="hidden" value="<?php echo base_url() ?>" id="url">
            <input type="hidden" value="<?php echo $user_session->id_usuario ?>" id="id_usuario">
            <div class="container-fluid">
                <div class="row row-deck row-cards">
                    <div class="col-md-12 col-xl-12">
                        <div class="card">
                            <ul class="nav nav-tabs" data-bs-toggle="tabs">

                                <li class="nav-item">
                                    <a href="#" class="nav-link " data-bs-toggle="tab" onclick="get_mesas()">TODAS</a>
                                </li>
                                <?php foreach ($salones as $detalle) : ?>

                                    <li class="nav-item">
                                        <a href="#tabs-home-7" class="nav-link" data-bs-toggle="tab" onclick="mesas_salon(<?php echo $detalle['id'] ?>)"><?php echo $detalle['nombre'] ?> </a>
                                    </li>

                                <?php endforeach ?>
                                <li class="nav-item ms-auto">
                                    <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab"><!-- Download SVG icon from http://tabler-icons.io/i/settings -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active show">


                                        <div style="display: block" id="todas_las_mesas">
                                            <div id="lista_completa_mesas">
                                                <?= $this->include('pedidos/todas_las_mesas_lista') ?>
                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <div id="lista_categorias" style="display: none">
                                                <ul class="horizontal-list">
                                                    <?php foreach ($categorias as $detalle) : ?>

                                                        <li><button type="button" class="btn btn-outline-indigo btn-pill btn-sm" id="categoria_<?php echo $detalle['codigocategoria'] ?>" onclick="productos_categoria(<?php echo $detalle['codigocategoria'] ?>)"><?php echo $detalle['nombrecategoria'] ?></button></li>

                                                    <?php endforeach ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!--Productos-->
                    <div class="col-md-3" id="pedido" style="display: block">
                        <div class="card" style="height: calc(20rem + 10px)">
                            <div class="card-header border-0" style="margin-bottom: -10px; padding-bottom: 0;">
                                <div class="card-title">

                                    <div class="mb-3">
                                        <div class="input-group input-group-flat">
                                            <input type="text" readonly class="form-control " autocomplete="off" placeholder="Buscar por nombre o código" id="producto">
                                            <span class="input-group-text">
                                                <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="limpiarCampo()"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <span id="error_producto" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                <div id="productos_categoria"></div>
                                <p id="bogota"></p>

                            </div>
                        </div>
                    </div>



                    <!--Pedido-->
                    <div class="col-md-6" id="productos" style="display: block">

                        <input type="hidden" id="id_mesa_pedido">

                        <div class="card" style="height: calc(20rem + 10px)">
                            <div class="card-header border-1" style="margin-bottom: -10px; padding-bottom: 0;">
                                <div class="card-title">
                                    <div class="row align-items-start">
                                        <div class="col">
                                            <div class="row gy-1">
                                                <div class="col-3">
                                                    <p class="text-dark">Mesa: </p>
                                                </div>
                                                <div class="col">
                                                    <p id="mesa_pedido" class="text-warning fw-bold"> </p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <p id="pedido_mesa">Pedido </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body card-body-scrollable card-body-scrollable-shadow">

                                <div id="mesa_productos"></div>

                            </div>

                            <div class="container">
                                <div class="row mb-2"> <!-- Fila para los botones -->
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-outline-indigo w-100" onclick="cambiar_mesas()">
                                            Cambio de mesa
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-outline-purple w-100" onclick="imprimir_comanda()">
                                            Comanda
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-outline-red w-100" onclick="eliminar_pedido()">
                                            Eliminar pedido
                                        </a>
                                    </div>
                                </div>
                                <div class="row"> <!-- Fila para el textarea -->
                                    <div class="col-md-12 mb-2">
                                        <textarea class="form-control" rows="1" id="nota_pedido" onkeyup="insertarDatos(this.value)" placeholder="Nota general del pedido "></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--valor Pedido-->
                    <div class="col-md-3">



                        <div class="card" style="height: calc(20rem + 10px)">
                            <div class="card-header border-1" style="margin-bottom: -10px; padding-bottom: 0;">
                                <div class="card-title">
                                    <div class="row align-items-start">
                                        <div class="col">
                                            <p id="pedido_mesa">Valor pedido </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body card-body-scrollable card-body-scrollable-shadow">

                                <form>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Subtotal</label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" id="subtotal_pedido" disabled="">
                                        </div>
                                    </div>


                                    <div class="row mb-2">

                                        <div class="col-sm-12">

                                            <div class="input-group">

                                                <select class="form-select" aria-label="Default select example" id="descuento_propina" onchange="criterio_propina()" style="width: 90px;" disabled>
                                                    <option value="1">Propina %</option>
                                                    <option value="2">Propina $</option>

                                                </select>
                                                <input type="text" aria-label="Last name" class="form-control w-1" style="width: 50px;" value=0 disabled>
                                                <input type="text" aria-label="Last name" class="form-control" style="width: 50px;" value=0 disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputPassword3" class="col-sm-4 col-form-label  h2">Total</label>
                                        <div class="col-sm-8">
                                            <a href="#" class="btn btn-outline-azure w-100 h2" id="valor_pedido" onclick="finalizar_venta()" title="Pagar" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                                $ 0
                                            </a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                            <div class="container">
                                <div class="row mb-2 gy-2"> <!-- Fila para los botones -->
                                    <div class="col-md-6">


                                        <a href="#" class="btn btn-outline-cyan w-100" onclick="prefactura()">
                                            Prefactura
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-outline-muted w-100" onclick="retiro_dinero()">
                                            Rerirar dinero</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-outline-yellow w-100" data-bs-toggle="modal" data-bs-target="#devolucion">
                                            Devolución
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-outline-azure w-100" onclick="pago_parcial()">
                                            Pago parcial
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!--partida-->
                </div>
            </div>

<div id="gg"  ></div>


        </div>
    </div>
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

    <script>
        let mensaje = "<?php echo $user_session->getFlashdata('mensaje'); ?>";
        let iconoMensaje = "<?php echo $user_session->getFlashdata('iconoMensaje'); ?>";
        if (mensaje != "") {
            sweet_alert(iconoMensaje, mensaje)
        }
    </script>

    <script>
        function criterio_propina() {

            var x = document.getElementById("descuento_propina").value;
            var tot = document.getElementById("subtotal_pedido").value;
            if (tot > 0) {
                if (x == 1 || x == 2) {
                    // var y = document.getElementById("valor_descuento%");
                    document.getElementById("valor_descuento_propina").disabled = false;
                    //var y = document.getElementById("valor_descuento%").value;
                    //console.log(y)
                }
            }
            if (tot == 0) {
                const Toast_1 = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast_1.addEventListener('mouseenter', Swal.stopTimer)
                        toast_1.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast_1.fire({
                    icon: 'info',
                    title: 'No hay venta para aplicar descuento '
                })
            }


        }
    </script>





    <script>
        function buscar_por_codigo_de_barras_devolucion(e, codigo) {
            var enterKey = 13;
            if (codigo != '') {
                if (e.which == enterKey) {

                    var codigo_de_barras = codigo

                    codigo_interno = document.getElementById("codigo_producto_devolucion").value

                    if (codigo_interno == '') {

                        $.ajax({
                            data: {
                                codigo_de_barras
                            },
                            url: '<?php echo base_url(); ?>/producto/buscar_por_codigo_de_barras',
                            type: "POST",
                            success: function(resultado) {
                                var resultado = JSON.parse(resultado);

                                if (resultado.resultado == 1) {
                                    $("#codigo_producto_devolucion").val(resultado.codigointernoproducto);
                                    $("#precio_devolucion").val(resultado.valor_venta_producto);
                                    //$("#nombre_producto").val(resultado.valor_venta_producto);
                                    $("#buscar_producto").val(resultado.nombre_producto);
                                    //$("#cantidad_factura_pos").focus();
                                    $('#buscar_producto').autocomplete('close');
                                    $("#mensaje_de_error").empty();
                                }
                                if (resultado.resultado == 0) {
                                    $('#buscar_producto').autocomplete('close');
                                    document.getElementById("codigo_producto_devolucion").value = ''
                                    document.getElementById("devolucion_producto").value = ''
                                    document.getElementById("devolucion_producto").focus();

                                    $("#error_producto_devolucion").html('NO HAY CONCIDENCIAS');
                                }
                            },
                        });

                    }
                }
            }
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



    <!--         <script type="text/javascript">
            function tiempoReal() {
                $.ajax({

                    url: '<?php echo base_url(); ?>/pedidos/tiempo_real',
                    success: function(resultado) {
                        var resultado = JSON.parse(resultado);
                        if (resultado.resultado == 1) {
                            $("#todas_las_mesas").html(resultado.mesas);


                        } else {
                            $("#prueba").html(resultado.pedidos);

                        }
                    },
                });
            }
            setInterval(tiempoReal, 5000);
        </script> -->

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



    <script>
        function actualizar_producto_cantidad(e, cantidad, id_tabla_producto) {


            if (cantidad != "") {
                var url = document.getElementById("url").value;
                var id_usuario = document.getElementById("id_usuario").value;

                $.ajax({
                    data: {
                        cantidad,
                        id_tabla_producto,
                        id_usuario
                    },
                    url: url + "/" + "producto/actualizacion_cantidades",
                    type: "post",
                    success: function(resultado) {
                        var resultado = JSON.parse(resultado);

                        if (resultado.resultado == 1) {
                            $('#productos_pedido').html(resultado.productos);
                            $("#valor_total").html(resultado.total_pedido);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: 'Cantidades agregadas'
                            })
                        } else if (resultado.resultado == 0) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: 'Usuario no tiene permiso de eliminacion de pedido '
                            })
                        }
                    },
                });





            }

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
            }

            if (sub_total > 0) {
                $('#pago').html('Valor pago: $' + sub_total.toLocaleString('es-CO'))
            }

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

            $('#partir_factura').modal('hide');
            $('#finalizar_venta').modal('show');

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


                        $('#sub_total_pedido').html("Sub total: " + resultado.total)
                        $('#mensaje_factura').html(resultado.total)
                        $('#mensaje_factura').html(resultado.factura_electronica)
                        $('#total_pedido').html(resultado.total)
                        $('#tipo_pago').val(0)
                        $('#valor_total_a_pagar').val(resultado.valor_total)
                        $('#requiere_factura_electronica').val(resultado.requiere_factura_electronica)



                    }
                },
            });



        }
    </script>


</body>

</html>