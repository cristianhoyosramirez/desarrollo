<style type="text/css">
    thead tr td {
        position: sticky;
        top: 0;
        background-color: #ffffff;
    }

    .table-responsive {
        height: 350px;
        overflow: scroll;
    }
</style>


<div class="row">
    <div class="col-10">

    </div>
    <div class="col-2 text-end">
        <form action="<?php echo base_url() ?>/reportes/exportar_excel" method="post">
            <input type="hidden" value="<?php echo $id_apertura ?>" name="id_apertura" id="id_apertura">
            <button type="submit" class="btn btn-outline-success  btn-icon">
                Excel
            </button>
        </form>
    </div>
</div>

<br>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <td scope="col">FECHA</th>
                <td scope="col">HORA</th>
                <td scope="col">DOCUMENTO</th>
                <td scope="col">VALOR</th>
                <td scope="col">PROPINA</th>
                <td scope="col">TOTAL</th>
                <td scope="col">EFECTIVO</th>
                <td scope="col">TRANSFERENCIA</th>
                <td scope="col">TOTAL PAGO</th>
                <td scope="col">CAMBIO </th>
                <td scope="col">USUARIO </th>
            </tr>
        </thead>
        <tbody class="table-scroll">
            <?php foreach ($movimientos as $valor) :

                $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $valor['id_mesero'])->first();

            ?>


                <tr>
                    <td><?php echo $valor['fecha'] ?></td>

                    <td><?php echo date("h:i A", strtotime($valor['hora'])) ?></td>
                    <td><?php echo $valor['documento'] ?></td>
                    <td><?php echo "$ " . number_format($valor['valor'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['propina'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['total_documento'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['recibido_efectivo'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['recibido_transferencia'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['total_pago'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['cambio'], 0, ",", ".") ?></td>
                    <td><?php echo $nombre_usuario['nombresusuario_sistema'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>