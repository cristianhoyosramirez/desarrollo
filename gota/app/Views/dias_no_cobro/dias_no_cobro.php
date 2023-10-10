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
  <title>Bienvenidos al sistema de recaudo </title>
  <!-- CSS files -->
  <link href="<?php echo base_url() ?>/public/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
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

    <div class="page-wrapper">
      <!-- Page body -->
      <div class="page-body">
        <div class="col-6 container">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Dias de la semana </h3>
            </div>
            <div class="list-group list-group-flush">
              <div class="list-group-item">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input"></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Lunes</a>

                  </div>
                </div>
              </div>
              <div class="list-group-item active">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input" checked></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Martes</a>

                  </div>
                </div>
              </div>
              <div class="list-group-item active">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input" checked></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Miercoles</a>

                  </div>
                </div>
              </div>
              <div class="list-group-item active">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input" checked></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Jueves</a>

                  </div>
                </div>
              </div>
              <div class="list-group-item active">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input" checked></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Viernes</a>

                  </div>
                </div>
              </div>
              <div class="list-group-item active">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input" checked></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Sabado</a>

                  </div>
                </div>
              </div>
              <div class="list-group-item active">
                <div class="row align-items-center">
                  <div class="col-auto"><input type="checkbox" class="form-check-input" checked></div>

                  <div class="col text-truncate">
                    <a class="text-reset d-block">Domingo</a>

                  </div>
                </div>
              </div>
             
             
             
     
           
        
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
  <script src="<?php echo base_url() ?>/public/dist/js/demo.min.js?1684106062" defer></script>
</body>

</html>