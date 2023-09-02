<?php foreach ($datos as $detalle) : ?>
    <?php

    $fecha_cierre_formateada = $detalle[3];
    $hora_cierre_formateada = "";


    setlocale(LC_TIME, 'es_ES');
    $hora_apertura = $detalle[2];
    $hora_apertura_formateada = date("g:i a", strtotime($hora_apertura));

    if ($detalle[3] != "Sin cierre") {
        $hora_cierre = $detalle[4];
        $hora_cierre_formateada = date("g:i a", strtotime($hora_cierre));
    }


    $locale = 'es_ES'; // Establece el idioma y la región a español
    $fecha_apertura = $detalle[1]; // Supongamos que $detalle[1] contiene la fecha en un formato válido.

    $formato = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    $fecha_apertura_formateada = $formato->format(strtotime($fecha_apertura));


    if ($detalle[3] != "Sin cierre") {
        $fecha_cierre = $detalle[3]; // Supongamos que $detalle[1] contiene la fecha en un formato válido.

        $formato = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $fecha_cierre_formateada = $formato->format(strtotime($fecha_cierre));
    }


    ?>
    <tr>
        <td>
            <p onclick="movimiento(<?php echo $detalle[0] ?>)" class="cursor-pointer"> <?php echo  $fecha_apertura_formateada . " " .  $hora_apertura_formateada;  ?> </p> <!-- feccha y hora apertura -->
        </td>
        <td>
            <p onclick="movimiento(<?php echo $detalle[0] ?>)" class="cursor-pointer"> <?php echo  $fecha_cierre_formateada . " " .  $hora_cierre_formateada;  ?> </p> <!-- feccha y hora apertura -->
        </td>


    </tr>
<?php endforeach ?>