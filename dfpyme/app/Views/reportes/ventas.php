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
        <a href="#" class="btn btn-outline-red  btn-icon" aria-label="Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pdf" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M10 8v8h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-2z"></path>
                <path d="M3 12h2a2 2 0 1 0 0 -4h-2v8"></path>
                <path d="M17 12h3"></path>
                <path d="M21 8h-4v8"></path>
            </svg>
        </a>

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
                <td scope="col">TOTAL DOCUMENTO</th>
                <td scope="col">EFECTIVO</th>
                <td scope="col">TRANSFERENCIA</th>
                <td scope="col">TOTAL PAGO</th>
                <td scope="col">ATENDIDO POR</th>
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
                    <td><?php echo "$ " . number_format($valor['efectivo'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['transferencia'], 0, ",", ".") ?></td>
                    <td><?php echo "$ " . number_format($valor['efectivo']+$valor['transferencia'], 0, ",", ".") ?></td>
                    <td><?php echo $nombre_usuario['nombresusuario_sistema'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>