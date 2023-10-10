<?php $user_session = session(); ?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <?= $this->include('favicon') ?>
  <title>Bienvenidos al sistema de recaudo </title>
  <!-- CSS files -->
  <link href="<?php echo base_url() ?>/public/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
  <link href="<?php echo base_url() ?>/public/dist/css/css.css" rel="stylesheet" />
  <!-- Data tables -->
  <link href="<?= base_url() ?>/public/dist/libs/DataTable/cdnjs.cloudflare.com_ajax_libs_twitter-bootstrap_5.2.0_css_bootstrap.min.css" />
  <!-- Jquery-ui -->
  <link href="<?php echo base_url() ?>/public/dist/libs/jquery-ui/jquery-ui.css" rel="stylesheet">
</head>

<body>

  <?php if ($user_session->accesos > 1) { ?>

    <script src="<?php echo base_url() ?>/public/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
      <?= $this->include('layout/header') ?>
      <?= $this->include('layout/navbar') ?>
      <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
          <!-- Menu principal -->
          <?= $this->include('home/menu_principal') ?>
          <!-- ../Menu principal -->

          <input type="hidden" value="<?php echo base_url(); ?>" id="url">
          <input type="hidden" value="<?php echo $user_session->id_usuario; ?>" id="id_de_usuario">
          <!-- Cobros del dia   -->
          <div id="cobros_dia" class="container" style="display:none;">
            <!-- Llamado a la vista de flecha atras  -->
            <div class="row">

              <div class="col-2">
                <?= $this->include('layout/flecha_atras') ?>
              </div>
              <div class="col-8">
                <p class="text-center text-primary h3">Gestión de cuentas por cobrar </p>
              </div>
              <div class="col">

              </div>
            </div>

            <div class="container" id="prestamos_del_dia">

            </div>
          </div>

          <!-- ../Cobros del dia   -->
          <!-- Crear nuevo prestamo  -->
          <div id="nuevo_prestamo" class="container" style="display:none;">
            <div class="container">
              <!-- Page header -->

              <div class="row">
                <div class="col-2">
                  <?= $this->include('layout/flecha_atras') ?>
                </div>
                <div class="col-6">
                  <p class="text-center text-primary h3">Prestamos activos </p>
                </div>
                <div class="col-2">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_crear_prestamo">
                    N prestamo
                  </button>
                </div>
              </div>

              <div id="prestamos_usuario">

              </div>
            </div>
          </div>

          <!-- Lisatado clientes   -->
          <div id="listado_clientes" class="container" style="display:none;">
            <div class="container">
              <div class="row gy-2 align-items-center">
                <!-- Llamado a la vista de flecha atras  -->


                <div class="container-xl">
                  <div class="row g-2 align-items-center">
                    <div class="col">
                      <?= $this->include('layout/flecha_atras') ?>
                    </div>
                    <div class="col d-none  d-lg-block">
                      <p class="text-center text-primary h3">Gestión de clientes </p>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                      <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Buscar cliente " onkeyup="buscar_cliente(this.value)" />
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_cliente">
                          <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                          </svg>
                          Nuevo cliente
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div id="list_clientes">

              </div>
            </div>
          </div>
          <!-- ../Crear nuevo prestamo  -->



          <div id="gastos" class="container" style="display:none;">
            <div class="container">
              <div class="row gy-2 align-items-center">
                <!-- Llamado a la vista de flecha atras  -->
                <p class="text-center text-primary h3">Gestión de gastos </p>
                <?= $this->include('layout/flecha_atras') ?>
              </div>
              <?= $this->include('gastos/gastos') ?>
            </div>
          </div>
          <!-- ../Ingresos adicionales  -->
          <?= $this->include('layout/footer') ?>
          <?= $this->include('home/modal_resumen_prestamo') ?>
          <?= $this->include('prestamos/modal_finalizar_pago') ?>
          <?= $this->include('terceros/modal_tercero') ?>
          <?= $this->include('ingresos/modal_ingresos') ?>

        </div>
        <!-- ../Page body -->
      </div>
      <div class="container" id="nuevo_prestamo" style="display:block;">

      </div>


      <!-- Tabler Core -->
      <script src="<?php echo base_url() ?>/public/dist/js/tabler.min.js?1684106062" defer></script>
      <!-- jQuery-->
      <script src="<?php echo base_url() ?>/public/dist/libs/jQuery/code.jquery.com_jquery-3.5.1.js"></script>
      <!-- jQuery-ui -->
      <script src="<?php echo base_url() ?>/public/dist/libs/jquery-ui/jquery-ui.js"></script>
      <!-- Sweet alert -->
      <script src="<?php echo base_url(); ?>/public/dist/libs/sweet-alert2/cdn.jsdelivr.net_npm_sweetalert2@11.7.12_dist_sweetalert2.all.min.js"></script>

      <!-- Propios -->
      <script src="<?= base_url() ?>public/js/clientes/clientes.js"></script><!-- Carga una tabla todos los clientes actuales y que estan activos -->
      <script src="<?= base_url() ?>public/js/home/cobro_dia.js"></script>
      <script src="<?= base_url() ?>public/js/home/formulario_prestamo.js"></script>
      <script src="<?= base_url() ?>public/js/ingresos_adicionales/ingresos_adicionales.js"></script>
      <script src="<?= base_url() ?>public/js/prestamos/abrir_modal_prestamos.js"></script>
      <script src="<?= base_url() ?>public/js/gastos/gastos.js"></script>
      <script src="<?= base_url() ?>public/js/clientes/detalle_cliente.js"></script>
      <script src="<?= base_url() ?>public/js/terceros/crear_tercero.js"></script>
      <script src="<?= base_url() ?>public/js/terceros/modal_crear_tercero.js"></script>
      <script src="<?= base_url() ?>public/js/prestamos/pagar.js"></script>
      <!-- Globales -->
      <script src="<?= base_url() ?>public/js/globales/saltar.js"></script>
      <script src="<?= base_url() ?>public/js/globales/resetInput.js"></script>
      <script src="<?= base_url() ?>public/js/flecha_atras.js"></script>
      <script src="<?= base_url() ?>public/js/prestamos/detalle_credito.js"></script>



      <script>
        // Coordenadas de ejemplo (París, Francia)
        function convertir_coordenadas(latitud, longitud) {
          var lat = latitud;
          var lon = longitud;

          // URL de la API de Nominatim para la geocodificación inversa
          var apiUrl = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;

          // Realiza una solicitud GET a la API
          fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
              // Obtiene la dirección desde la respuesta JSON
              var address = data.display_name;

              $('#direccion').val(address)
              

              // También puedes insertarla en un elemento HTML en tu página
              // document.getElementById("direccion").textContent = "Dirección: " + address;
            })
            .catch(error => {
              console.error("Error al obtener la dirección: " + error);
            });
        }
      </script>

      <script>
        function abonar() {


          let id_c_x_c = document.getElementById("c_x_c").value;
          let usuario = document.getElementById("id_usuario").value;
          let pago = document.getElementById("efectivo").value;
          let url = document.getElementById("url").value;

          if (pago == "" || pago == 0) {
            $('#error_pago').html('Ingrese un valor válidio  ')
          } else if (pago != "") {

            $.ajax({
              data: {
                id_c_x_c,
                usuario,
                pago
              },
              url: url + "/" + "prestamos/abonar",
              type: "POST",
              success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {
                  $('#modal_tabla_amortizacion').modal('hide');
                  $('#prestamos_usuario').html(resultado.prestamos);
                  $('#debido_cobrar').html(resultado.debido_cobrar);
                  $('#efectivo').val(0);


                  Swal.fire({
                    title: '!Bien hecho¡ ',
                    icon: 'success',
                    html: 'Se realizo un abono por ' + resultado.abono + ' al señor(a) ' + resultado.nombre_cliente + '<p>nuevo saldo:</p> ',

                    showCancelButton: false,
                    focusConfirm: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: "#2FB344",

                  })

                  let cliente = document.getElementById("gastos");
                  cliente.style.display = "none";




                }
              },
            });
          }
        }
      </script>

      <script>
        $(function() {
          $('#modal_tabla_amortizacion').on('shown.bs.modal', function(e) {
            $('#pago').focus();
          })
        });
      </script>

      <script>
        function borrar_error() {
          $('#error_pago').html('')
        }
      </script>

      <script>
        function calcular_cambio(valor) {

          let pago_minimo = document.getElementById("pago_minimo").value;

          var pago_minimo_format = pago_minimo.replace(/[$.]/g, '');

          cambio = parseInt(valor) - parseInt(pago_minimo_format)

          console.log(cambio)



        }
      </script>




      <script>
        let mensaje = "<?php echo $user_session->getFlashdata('mensaje'); ?>";
        let iconoMensaje = "<?php echo $user_session->getFlashdata('iconoMensaje'); ?>";
        if (mensaje != "") {
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
            icon: iconoMensaje,
            title: mensaje
          })

        }
      </script>



</body>
<?php } ?>

<?php if ($user_session->accesos == 1) { ?>
  <br>
  <div class="container">
    <br>
    <div class="alert alert-green alert-dismissible fade show" role="alert">
      <?php  //echo $user_session->nombre_usuario 
      ?>
      <strong><?php echo $user_session->nombre ?> Es primer vez que te vemos por aca por tal motivo debes cambiar la clave</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?= $this->include('home/cambiar_clave') ?>
  </div>


<?php } ?>

</html>