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

</head>

<body>
    <script src="<?= base_url() ?>/public/js/demo-theme.min.js?1684106062"></script>
    <?= $this->include('layout/header_mesas') ?>
    <div class="page">
        <!-- Navbar -->
        <div class="row">
            <p></p>
        </div>
        <br>
        <!--Sart row-->
        <div class="container">
            <div class="row text-center align-items-center flex-row-reverse">
                <div class="col-lg-auto ms-lg-auto">

                </div>

                <div class="col-lg-auto ms-lg-auto">
                    <p class="text-primary h3">INGRESO DE CANTIDADES AL INVENTARIO </p>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                    <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
                </div>
            </div>
        </div>
        <br>


        <div class="page-wrapper">
            <!-- Page body -->

            <div class="card container">
                <div class="card-body">
                    <form action="<?= base_url('inventario/ingreso_inventario') ?>" method="POST">
                        <input type="hidden" value="<?php echo $user_session->id_usuario; ?>" name="id_usuario">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Producto </label>
                                <input type="hidden" value="<?php echo base_url() ?>" id="url">
                                <input type="hidden" id="id_producto" name="id_producto">
                                <input type="text" class="form-control" id="producto" name="producto" autofocus>
                                <div class="text-danger"><?= session('errors.salon') ?></div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="form-label">Cantidad</label>
                                <input type="text" class="form-control" name="cantidad" id="cantidad" required>
                                <div class="text-danger"><?= session('errors.nombre') ?></div>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <br><br>
                            <button type="submit" class="btn btn-primary w-md"><i class="mdi mdi-plus"></i> Agregar al inventario </button>
                        </div>
                    </form>
                    <br>
                </div>
            </div>


        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url() ?>/public/js/tabler.min.js?1684106062" defer></script>
    <script src="<?= base_url() ?>/public/js/demo.min.js?1684106062" defer></script>


    <!--jQuery -->
    <script src="<?= base_url() ?>/Assets/js/jquery-3.5.1.js"></script>
    <!-- jQuery-ui -->
    <script src="<?php echo base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.js"></script>
    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>/Assets/plugin/sweet-alert2/sweetalert2@11.js"></script>



    <script>
        $("#producto").autocomplete({
            source: function(request, response) {
                var url = document.getElementById("url").value;
                $.ajax({
                    type: "POST",
                    url: url + "/" + "producto/pedido",
                    data: request,
                    success: response,
                    dataType: "json",
                });
            },
        }, {
            minLength: 1,
        }, {
            select: function(event, ui) {


                $('#id_producto').val(ui.item.id_producto)


            },
        });
    </script>











































</body>

</html>