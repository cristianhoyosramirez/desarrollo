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
    <!-- Jquery-ui -->
    <link href="<?php echo base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.css" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/Assets/img/favicon.png">
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
                                    <a href="#tabs-home-7" class="nav-link " data-bs-toggle="tab" onclick="get_mesas()">TODAS</a>
                                </li>
                                <?php foreach ($salones as $detalle) : ?>

                                    <li class="nav-item">
                                        <a href="#tabs-profile-7" class="nav-link" data-bs-toggle="tab" onclick="mesas_salon(<?php echo $detalle['id'] ?>)"><?php echo $detalle['nombre'] ?> </a>
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
                                    <div class="tab-pane active show" id="tabs-home-7">


                                        <div style="display: block" id="todas_las_mesas">
                                            <?= $this->include('pedidos/todas_las_mesas_lista') ?>
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
                                            <input type="text" class="form-control " autocomplete="off" placeholder="Buscar por nombre o código" id="producto">
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
                                            <p id="pedido_mesa">Pedido </p>
                                        </div>
                                        <div class="col">
                                            <p id="mesa_pedido">Mesa </p>
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
                                        <a href="#" class="btn btn-outline-cyan w-100" onclick="prefactura()">
                                            Prefactura
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
                                            <input type="email" class="form-control" id="inputEmail3">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputPassword3" class="col-sm-4 col-form-label">Propina</label>
                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Seleccione</option>
                                                    <option value="1">%</option>
                                                    <option value="2">$</option>

                                                </select>
                                                <input type="text" aria-label="Last name" class="form-control" value=0>
                                                <input type="text" aria-label="Last name" class="form-control" value=50000 readonly>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputPassword3" class="col-sm-4 col-form-label">Total</label>
                                        <div class="col-sm-8">
                                            <a href="#" class="btn btn-outline-azure w-100" id="valor_pedido" onclick="finalizar_venta()" title="Pagar" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                                $0
                                            </a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                            <div class="container">
                                <div class="row mb-2 gy-2"> <!-- Fila para los botones -->
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-outline-red w-100" onclick="eliminar_pedido()">
                                            Eliminar pedido
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-outline-muted w-100" onclick="retiro_dinero()">
                                            Rerirar dinero</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-outline-yellow w-100" onclick="prefactura()">
                                            Devol producto
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

    <script>
        function retiro_dinero() {

            $("#modal_retiro_dinero").modal("show");
        }
    </script>
    <script>
        function pago_parcial() {
            let url = document.getElementById("url").value
            let id_mesa = document.getElementById("id_mesa_pedido").value;




            $.ajax({
                type: 'post',
                url: url + "/" + "pedidos/productos_pedido", // Cambia esto a tu script PHP para insertar en la base de datos
                data: {
                    id_mesa,

                }, // Pasar los datos al script PHP
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {

                        $('#productos_pago_parcial').html(resultado.productos)
                        $("#partir_factura").modal("show");



                    }
                },
            });
        }
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
        function finalizar_venta() {

            $("#finalizar_venta").modal("show");
        }
    </script>

    <script>
        function eliminar_cantidades(event, id_tabla_producto) {

            let url = document.getElementById("url").value
            let id_usuario = document.getElementById("id_usuario").value
            let id_tabla = id_tabla_producto
            event.stopPropagation();


            $.ajax({
                type: 'post',
                url: url + "/" + "pedidos/restar_producto", // Cambia esto a tu script PHP para insertar en la base de datos
                data: {
                    id_tabla,

                }, // Pasar los datos al script PHP
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {
                        sweet_alert('success', 'Se elimino un producto')

                        $("#mesa_productos").html(resultado.productos);
                        $("#valor_pedido").html(resultado.total);



                    }
                },
            });

        }
    </script>

<script>
        function actualizar_cantidad_partir_factura(cantidad,id,cantidad_producto) {
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




</body>

</html>