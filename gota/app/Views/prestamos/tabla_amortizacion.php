  <style>
    .table-striped>tbody>tr:nth-child(odd)>td,
    .table-striped>tbody>tr:nth-child(odd)>th {
      background-color: #cfe2ff;
      /* Choose your own color here */

    }

    #global {
      height: 200px;
      overflow-y: scroll;
    }

    #global_tabla {
      height: 400px;
      overflow-y: scroll;
    }
  </style>


  <?php

  $temp_contador = 0;

  $dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

  $dia_inicio = $dias[(date('N', strtotime($fecha_inicio))) - 1];
  $mes_inicio = $meses[(date('m', strtotime($fecha_inicio))) - 1];

  $dia_final = $dias[(date('N', strtotime($fecha_finalizacion))) - 1];
  $mes_final = $meses[(date('m', strtotime($fecha_finalizacion))) - 1];


  ?>

  <div class="container">

    <div class="row ">
      <div class="col-6">
        <p>Cliente: <?php echo $nombres_cliente ?> </p>
      </div>
      <div class="col-6">
        <p>Monto solicitado: <?php echo $monto_solicitado ?> </p>
      </div>
    </div>

    <div class="row ">
      <div class="col-6">
        <p>Número de cuotas : <?php echo $numero_de_cuotas ?> </p>
      </div>
      <div class="col">
        <p>Valor cuota: <?php echo $valor_cuota ?> </p>
      </div>
    </div>

    <div class="row">
      <div class="col-6">
        <p>Fecha inicio: <?php echo $dia_inicio . ", " . date("d", strtotime($fecha_inicio)) . " " . $mes_inicio . " " . date("Y", strtotime($fecha_inicio)); ?></p>
      </div>

      <div class="col-6">
        <p>Fecha final:<?php echo $dia_final . ", " . date("d", strtotime($fecha_finalizacion)) . " " . $mes_final . " " . date("Y", strtotime($fecha_finalizacion)); ?> </p>
      </div>
    </div>
  </div>

  <table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <td scope="col">No de cuota </td>
        <td scope="col">Vence</td>
        <td>Total</td>
      </tr>
    </thead>
    <tbody>


      <?php
      foreach ($detalle_prestamo as $detalle) {
        $dia = $dias[(date('N', strtotime($detalle['fecha']))) - 1];
        $mes = $meses[(date('m', strtotime($detalle['fecha']))) - 1];
      ?>
        <tr>
          <td><?php echo $contador = $temp_contador + 1;
              $temp_contador = $contador; ?></td>
          <td>
            <?php echo $dia . ", " . date("d", strtotime($detalle['fecha'])) . " " . $mes . " " . date("Y", strtotime($detalle['fecha'])); ?>
          </td>
          <td><?php echo $valor_cuota ?> </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>