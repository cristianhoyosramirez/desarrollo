<div class="table-responsive">
  <table class="table table-vcenter card-table">
    <thead class="table-dark">
      <tr>
        <td >Cuota</th>
        <td>Vencimiento</th>
        <td>Fecha pago </th>
        <td>Saldo </th>
        <td>atraso </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($datos_cuotas as $detalle) : ?>

        <?php
        $fecha_pago = "";
        if ($detalle['fecha_pago'] == '0000-00-00') {
          $fecha_pago = "PENDIENTE DE PAGO ";
        } else if ($detalle['fecha_pago'] != '0000-00-00'){
          $fecha_pago=$detalle['fecha_pago'];
        }?>

        <?php if ($detalle['dias_atraso'] == 0) { ?>
          <tr class="table-success">
            <td ><?php echo  $detalle['numero_cuota'] ?></td>
            <td><?php echo  $detalle['fecha_vencimiento'] ?></td>
            <td><?php echo  $fecha_pago ?></td>
            <td><?php echo  "$" . number_format($detalle['saldo_cuota'], 0, ",", ".") ?></td>
            <td><?php echo  $detalle['dias_atraso'] ?></td>
          </tr>
        <?php } ?>
        <?php if ($detalle['dias_atraso'] == 1) { ?>
          <tr class="table-warning">
            <td><?php echo  $detalle['id'] ?></td>
            <td><?php echo  $detalle['fecha_vencimiento'] ?></td>
            <td><?php echo  $fecha_pago ?></td>
            <td><?php echo  "$" . number_format($detalle['saldo_cuota'], 0, ",", ".") ?></td>
            <td><?php echo  $detalle['dias_atraso'] ?></td>
          </tr>
        <?php } ?>
        <?php if ($detalle['dias_atraso'] > 1) { ?>
          <tr class="table-danger">
            <td ><?php echo  $detalle['id'] ?></td>
            <td><?php echo  $detalle['fecha_vencimiento'] ?></td>
            <td><?php echo  $fecha_pago ?></td>
            <td><?php echo  "$" . number_format($detalle['saldo_cuota'], 0, ",", ".") ?></td>
            <td><?php echo  $detalle['dias_atraso'] ?></td>
          </tr>
        <?php } ?>
      <?php endforeach  ?>
    </tbody>
  </table>
</div>