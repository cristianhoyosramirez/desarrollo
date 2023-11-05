<?= $this->extend('template/clientes') ?>
<?= $this->section('title') ?>
LISTADO DE CLIENTES
<?= $this->endSection('title') ?>
<?= $this->section('content') ?>

<div class="container">
  <div class="row text-center align-items-center flex-row-reverse">
    <div class="col-lg-auto ms-lg-auto">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Salones</a></li>
          <li class="breadcrumb-item"><a href="#">Mesas</a></li>
          <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
          <li class="breadcrumb-item"><a href="#">Empresa</a></li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>
<!--Sart row-->
<div class="container">
  <div class="row text-center align-items-center flex-row-reverse">
    <div class="col-lg-auto ms-lg-auto">

      <button type="button" class="btn btn-warning btn-pill w-100" onclick="nuevo_cliente()">
        Agregar cliente
      </button>
    </div>

    <div class="col-lg-auto ms-lg-auto">
      <p class="text-primary h3">LISTA GENERAL DE CLIENTES </p>
    </div>
    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
      <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
    </div>
  </div>
</div>
<br>
<div class="container">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <input type="hidden" id="url" value="<?php echo base_url() ?>">
          <table id="clientes" class="table">
            <thead class="table-dark">
              <td>Nit</td>
              <td>Cliente</td>
              <td>Celular</td>
              <td>Dirección</td>
              <td>Régimen</td>
              <td>Acción</td>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?= $this->include('pedidos/crear_cliente') ?>
<?= $this->include('clientes/modal_editar_cliente') ?>



<?= $this->endSection('content') ?>
<!-- end row -->