<?php foreach ($datos as $detalle) : ?>
    <tr>
        <td>
            <p onclick="movimiento(<?php echo $detalle[0] ?>)" class="cursor-pointer"> <?php echo  $detalle[1] ?> </p>
            </td>
        <td>
            <p onclick="movimiento(<?php echo $detalle[0] ?>)" class="cursor-pointer"> <?php echo $detalle[2] ?> </p>
        </td>

    </tr>
<?php endforeach ?>