<?php $user_session = session(); ?>

<div class="container-xl" style="display: block;" id="home">
  <div class="row row-cards">
    <div class="col-md-6 col-lg-3 cursor-pointer" onclick="cobro_dia()">
      <div class="card">
        <br>
        <h3 class="card-title text-center">Cobros del dia <br> <?php echo date('Y-m-d') ?></h3>
        <a class="card-body text-center" href="#"><img src="<?php echo base_url() ?>/public/dist/img/calendario.png" width="110" height="60" alt="Tabler" class="navbar-brand-image"></a>

        <h3 class="card-title text-center"> <p id="debido_cobrar"> Debido cobrar <?php echo "$" . number_format($user_session->debido_cobrar, 0, ",", "."); ?> </p></h3>

      </div>
    </div>

    <div class="col-md-6 col-lg-3 cursor-pointer" onclick="nuevo_prestamo()">
      <div class="card">
        <br>
        <h3 class="card-title text-center">Gestión créditos</h3>

        <div class="card-body text-center"><img src="<?php echo base_url() ?>/public/dist/img/prestamo.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 cursor-pointer" onclick="clientes()">
      <div class="card">
        <br>
        <h3 class="card-title text-center">Clientes

          <div class="card-body text-center"><img src="<?php echo base_url() ?>/public/dist/img/clientes.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 cursor-pointer" onclick="ingresos_adicionales()">
      <div class="card">
        <br>
        <h3 class="card-title text-center">Ingresos adicionales

          <div class="card-body text-center"><img src="<?php echo base_url() ?>/public/dist/img/ingresos.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 cursor-pointer" onclick="gastos()">
      <div class="card">
        <br>
        <h3 class="card-title text-center">Gastos

          <div class="card-body text-center"><img src="<?php echo base_url() ?>/public/dist/img/gastos.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></div>
      </div>
    </div>
  </div>
</div>