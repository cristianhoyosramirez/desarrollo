<?php foreach ($meseros as $valor) :  $nombre_mesero = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $valor['id_mesero'])->first();    ?>

  <table class="table table-striped table-hover">
    <thead clas="thead-dark">
      <tr class="table-primary">
        <td>
          <p class="text-dark"><?php echo $nombre_mesero['nombresusuario_sistema'];   ?></p>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>



    </thead>
    <tbody>
      <?php $facturas = model('facturaPropinaModel')->get_propinas($id_apertura, $valor['id_mesero']) ?>
      <?php foreach ($facturas as $detalle) :   $id_mesa = model('facturaVentaModel')->select('fk_mesa')->where('id', $detalle['id_factura'])->first();

        $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa['fk_mesa'])->first(); ?>


        <?php $documento = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $detalle['id_factura'])->first(); ?>
        <?php $valor_documento = model('facturaVentaModel')->select('valor_factura')->where('id', $detalle['id_factura'])->first(); ?>
        <tr class="table-dark">
          <td scope="row">Mesa </th>
          <td scope="row">Documento </th>
          <td scope="row">Valor documento </th>
          <td colspan="2">Valor propina</td>

        </tr>
        <tr>
          <td scope="row"><?php echo $nombre_mesa['nombre'] ?> </th>
          <td scope="row"><?php echo $documento['numerofactura_venta'] ?> </th>
          <td scope="row"><?php echo "$" . number_format($valor_documento['valor_factura'], 0, ",", ".") ?> </th>
          <td colspan="2"><?php echo "$" . number_format($detalle['valor_propina'], 0, ",", ".") ?></td>

        </tr>
      <?php endforeach ?>
    </tbody>
    <?php $total = model('facturaPropinaModel')->get_total_propinas($id_apertura, $valor['id_mesero']); ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>


      <td></td>
      <td class="table-warning">Total: <?php echo "$" . number_format($total[0]['total_propina'], 0, ",", ".") ?> </td>
    </tr>
  </table>

<?php endforeach ?>