<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title><?= $this->renderSection('title') ?>&nbsp;-&nbsp;DF PYME</title>
  <!-- CSS files -->
  <link href="<?= base_url() ?>/Assets/css/tabler.min.css" rel="stylesheet" />
  <!-- Data tables -->
  <link href="<?= base_url() ?>/Assets/plugin/data_tables/bootstrap.min.css" />
  <link href="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.css" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>/Assets/img/favicon.png">
</head>
<?php $session = session(); ?>

<body>
  <div class="wrapper">
    <?= $this->include('layout/header') ?>
    <?= $this->include('layout/navbar') ?>

    <div class="page-wrapper">
      <div class="container-xl">
      </div>
      <div class="page-body">
        <?= $this->renderSection('content') ?>
        <?= $this->include('ventanas_modal_duplicado_factura/detalle_factura') ?>
      </div>
      <?= $this->include('layout/footer') ?>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url() ?>/Assets/js/tabler.min.js"></script>
    <!-- J QUERY -->
    <script src="<?= base_url() ?>/Assets/js/jquery-3.5.1.js"></script>
    <!-- Data tables -->
    <script src="<?= base_url() ?>/Assets/plugin/data_tables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.js"></script>
    <!-- Locales -->
    <script src="<?= base_url() ?>/Assets/script_js/duplicado_factura/detalle_factura.js"></script>
    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>/Assets/plugin/sweet-alert2/sweetalert2@11.js"></script>
    <script>
      $(document).ready(function() {
        $('#duplicadoFactura').DataTable({
            "language": {
              "decimal": "",
              "emptyTable": "No hay datos",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
              "infoEmpty": "Mostrando 0 a 0 de 0 registros",
              "infoFiltered": "(Filtro de _MAX_ total registros)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ registros",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscar:",
              "zeroRecords": "No se encontraron coincidencias",
              "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Próximo",
                "previous": "Anterior"
              },
              "aria": {
                "sortAscending": ": Activar orden de columna ascendente",
                "sortDescending": ": Activar orden de columna desendente"
              }

            },
            "order": [
              [0, "desc"]
            ]
          }

        );
      });
    </script>

    <script>
      function imprimir_duplicado_factura(id_factura) {
        var url = document.getElementById("url").value;
        id_de_factura = id_factura
        $.ajax({
          type: "POST",
          url: url + "/" + "consultas_y_reportes/imprimir_duplicado_factura",
          data: {
            id_de_factura
          },
          success: function(resultado) {
            var resultado = JSON.parse(resultado);

            if (resultado.resultado == 1) {
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
                title: 'Duplicado de factura'
              })
            }
          },
        });


      }
    </script>



</body>

</html>