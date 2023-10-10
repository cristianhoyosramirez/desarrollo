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
        <div class="col-1">
          <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <a class="nav-link" onClick="history.go(-1);"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 12l14 0"></path>
                <path d="M5 12l4 4"></path>
                <path d="M5 12l4 -4"></path>
              </svg></a>
          </div>
        </div>
        <div class="col-5">
          <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <p class="text-primary h3 ">Cuentas para cobrar del dia:  <?php  
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            date("n");
            
            echo date("d") . " del " . $meses[date('n')-1]. " de " . date("Y"); ?></p>
          </div>
        </div>
        <div class="col-6">
          <?= $this->include('layout/breadcumb_gestion') ?>
        </div>
      </div>
    </div>

    <div class="page-wrapper">
      <!-- Page body -->
      <div class="page-body">
        <div class="container">


          <div class="card">
            <div class="container">
              <input type="hidden" value="<?php echo base_url(); ?>" id="url">
              <div class="table-responsive">
                <table class="table table-vcenter card-table " id="example">
                  <thead class="table-dark">
                    <tr>
                      <td>Fecha vencimiento </td>
                      <td>Nombre</td>
                      <td>Valor cuota</td>
                      <td>Acciones</td>
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
    
    <!-- Propios -->
   
    <script src="<?= base_url() ?>public/js/cobros_del_dia/DataTable.js"></script>
   

   


</body>

</html>