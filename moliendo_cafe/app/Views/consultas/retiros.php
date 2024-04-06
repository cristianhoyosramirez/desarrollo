<table class="table">
    <thead class="table-dark">
        <tr>
            <td scope="col">Fecha</th>
            <td scope="col">Valor</th>
            <td scope="col">Concepto</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($retiros as $valor) : ?>
            <tr>
                <td><?php echo $valor['fecha'] ?></th>
                <td><?php echo "$ ".number_format($valor['valor'], 0, ",", ".") ?></th>
                <td><?php echo $valor['concepto'] ?></td>
            </tr>
        <?php endforeach ?>

    </tbody>
</table>

<p class="text-end h3 " >Total retiros : <?php   echo "$ ".number_format($total_retiros, 0, ",", ".") ?></p>