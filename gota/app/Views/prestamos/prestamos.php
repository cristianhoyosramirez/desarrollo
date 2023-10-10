<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <?= $this->include('favicon') ?>
  <title>Bienvenidos al sistema de recaudo </title>
  <!-- CSS files -->
  <link href="<?php echo base_url() ?>/public/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
  <!-- Sweet alert  -->
  <link href="<?php echo base_url() ?>/public/dist/libs/sweet-alert2/cdn.jsdelivr.net_npm_sweetalert2@11.7.12_dist_sweetalert2.min.css" rel="stylesheet" />

  <!-- Data tables -->
  <link href="<?= base_url() ?>/public/dist/libs/DataTable/cdnjs.cloudflare.com_ajax_libs_twitter-bootstrap_5.2.0_css_bootstrap.min.css" />
  <!-- Select 2 -->
  <link href="<?php echo base_url(); ?>/public/dist/libs/select2/select2.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/public/dist/libs/select2/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  <!-- Jquery-ui -->
  <link href="<?php echo base_url() ?>/public/dist/libs/jquery-ui/jquery-ui.css" rel="stylesheet">
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
  <script src="<?php echo base_url() ?>/public/dist/js/demo-theme.min.js?1684106062"></script>
  <div class="page">
    <?= $this->include('layout/header') ?>
    <?= $this->include('layout/navbar') ?>

    <!-- Page header -->
    <p></p>
    <div class="container">
      <div class="row gy-2 align-items-center">
        <div class="col">
          <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <a class="nav-link" onClick="history.go(-1);"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 12l14 0"></path>
                <path d="M5 12l4 4"></path>
                <path d="M5 12l4 -4"></path>
              </svg></a>
          </div>
        </div>
        <div class="col">
          <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <p class="text-primary h3 ">Lista de prestamos activos </p>
          </div>
        </div>

        <div class="col-auto ms-auto d-print-none">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item " aria-current="page">Gestión</li>
              <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
          </nav>

        </div>
      </div>
    </div>

    <div class="page-wrapper">
      <!-- Page body -->
      <div class="page-body">
        <div class="container">


          <div class="row g-2 align-items-end">

            <div class="col-6 col-sm-4 col-md-2 col-xl-10 py-3">

            </div>
            <div class="col-6 col-sm-4 col-md-2 col-xl-2 py-3">

              <a href="#" class="btn btn-icon btn-indigo w-100" onclick="modal_crear_prestamo()"> Agregar prestamo </a>

            </div>
          </div>


          <div class="card">
            <div class="container">
              <input type="hidden" value="<?php echo base_url(); ?>" id="url">
              <div class="table-responsive">
                <table class="table table-vcenter card-table " id="example">
                  <thead class="table-dark">
                    <tr>
                      <td>Nombre</td>
                      <td>Valor cuota</td>
                      <td>Fecha vencimiento</td>
                      <td>Estado</td>
                      <td>Acción</td>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?= $this->include('layout/footer') ?>
    </div>

    <?= $this->include('prestamos/modal_crear_prestamo') ?>


    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?php echo base_url() ?>/public/dist/js/tabler.min.js?1684106062" defer></script>
    <!-- jQuery-->
    <script src="<?php echo base_url() ?>/public/dist/libs/jQuery/code.jquery.com_jquery-3.5.1.js"></script>
    <!-- jQuery-ui -->
    <script src="<?php echo base_url() ?>/public/dist/libs/jquery-ui/jquery-ui.js"></script>
    <!-- Data tables -->
    <script src="<?= base_url() ?>/public/dist/libs/DataTable/cdn.datatables.net_1.13.4_js_jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/public/dist/libs/DataTable/cdn.datatables.net_1.13.4_js_dataTables.bootstrap5.min.js"></script>

    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>/public/dist/libs/sweet-alert2/cdn.jsdelivr.net_npm_sweetalert2@11.7.12_dist_sweetalert2.all.min.js"></script>
    <!--select2 -->
    <script src="<?php echo base_url(); ?>/public/dist/libs/select2/select2.min.js"></script>
    <!-- Propios -->
    
    <script src="<?= base_url() ?>public/js/prestamos/DataTable.js"></script>
    <script src="<?= base_url() ?>public/js/prestamos/autocompletar_tercero.js"></script>
   

    <script>
      function modal_crear_prestamo() {
        let url = document.getElementById("url").value;
        let operacion = 1;
        $.ajax({
          data:{operacion},
          url: url + "/" + "prestamos/abrirModal",
          type: "POST",
          success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {
              $("#modal_crear_prestamo").modal("show");
            }
          }
        })
      }
    </script>







</body>

</html>