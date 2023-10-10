<?php if (!empty($c_x_c)) { ?>
  <?php foreach ($c_x_c as $detalle) { ?>

    <div>
      <?php  if($detalle['dias_atraso']==0): ?>
      <div class="card bg-green text-green-fg">
        <div class="card-body">
          <div class="row cursor-pointer" onclick="pagar(<?php echo $detalle['id_c_x_c'] ?>)" title="Pagar crédito"  data-bs-toggle="tooltip">
            <div class="col-auto cursor-pointer" onclick="detalle_credito(event,'<?php echo $detalle['id_c_x_c'] ?>')">
              <span class="avatar"><img src="<?php echo base_url() ?>/public/dist/img/hombre.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></span>
            </div>
            <div class="col">
              <div class="row">
                <div class="col-4"><strong>Crédito No :</strong></div>
                <div class="col"><strong><?php echo $detalle['id_c_x_c'] ?></strong> </div>
              </div>
              <div class="row">
                <div class="col-4"> <strong>Cliente:</strong></div>
                <div class="col-8"><strong><?php echo $detalle['nombres'] ?></strong></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php  endif ?>
      <?php  if($detalle['dias_atraso']==1): ?>
      <div class="card bg-orange text-orange-fg">
        <div class="card-body">
          <div class="row cursor-pointer" onclick="pagar(<?php echo $detalle['id_c_x_c'] ?>)" title="Pagar crédito"  data-bs-toggle="tooltip">
            <div class="col-auto cursor-pointer" onclick="detalle_credito(event,'<?php echo $detalle['id_c_x_c'] ?>')">
              <span class="avatar"><img src="<?php echo base_url() ?>/public/dist/img/hombre.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></span>
            </div>
            <div class="col">
              <div class="row">
                <div class="col-4"><strong>Crédito No :</strong></div>
                <div class="col"><strong><?php echo $detalle['id_c_x_c'] ?></strong> </div>
              </div>
              <div class="row">
                <div class="col-4"> <strong>Cliente:</strong></div>
                <div class="col-8"><strong><?php echo $detalle['nombres'] ?></strong></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php  endif ?>
      <?php  if($detalle['dias_atraso']>1): ?>
      <div class="card bg-red text-red-fg">

      <?php if (empty($detalle['imagen_cliente'])): ?>
        <div class="card-body">
          <div class="row cursor-pointer" onclick="pagar(<?php echo $detalle['id_c_x_c'] ?>)" title="Pagar crédito"  data-bs-toggle="tooltip">
            <div class="col-auto cursor-pointer" onclick="detalle_credito(event,'<?php echo $detalle['id_c_x_c'] ?>')">
              <span class="avatar"><img src="<?php echo base_url() ?>/public/dist/img/hombre.png" width="110" height="32" alt="Tabler" class="navbar-brand-image"></span>
            </div>
            <div class="col">
              <div class="row">
                <div class="col-4"><strong>Crédito No :</strong></div>
                <div class="col"><strong><?php echo $detalle['id_c_x_c'] ?></strong> </div>
              </div>
              <div class="row">
                <div class="col-4"> <strong>Cliente:</strong></div>
                <div class="col-8"><strong><?php echo $detalle['nombres'] ?></strong></div>
              </div>
            </div>
          </div>
        </div>
        <?php  endif ?>

      <?php if (!empty($detalle['imagen_cliente'])): ?>
        <div class="card-body">
          <div class="row cursor-pointer" onclick="pagar(<?php echo $detalle['id_c_x_c'] ?>)" title="Pagar crédito"  data-bs-toggle="tooltip">
            <div class="col-auto cursor-pointer" onclick="detalle_credito(event,'<?php echo $detalle['id_c_x_c'] ?>')">
              <span class="avatar"><img src="<?php echo base_url() ?>/images/clientes/<?php echo $detalle['imagen_cliente'] ?> " width="110" height="32" alt="Tabler" class="navbar-brand-image"></span>
            </div>
            <div class="col">
              <div class="row">
                <div class="col-4"><strong>Crédito No :</strong></div>
                <div class="col"><strong><?php echo $detalle['id_c_x_c'] ?></strong> </div>
              </div>
              <div class="row">
                <div class="col-4"> <strong>Cliente:</strong></div>
                <div class="col-8"><strong><?php echo $detalle['nombres'] ?></strong></div>
              </div>
            </div>
          </div>
        </div>
        <?php  endif ?>


      </div>
      <?php  endif ?>
    </div>
    <br>
  <?php } ?>
<?php } ?>

<?php if (empty($c_x_c)) { ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>No hay cuentas para cobrar </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php } ?>