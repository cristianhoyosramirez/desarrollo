<?php $counter = 0; ?>

<div class="row row-cols-3 g-3">
    <?php foreach ($fotos as $foto) : ?>
        <div class="col-md-4 mb-3"> <!-- Utiliza col-md-4 para columnas medianas y mb-3 para margen inferior -->
            <a data-fslightbox="gallery" href="<?php echo base_url() ?>uploads/<?php echo $foto['ruta'] ?>">
                <!-- Photo -->
                <div class="img-responsive img-responsive-4x3 rounded border" style="background-image: url(<?php echo base_url() ?>uploads/<?php echo $foto['ruta'] ?>)"></div>
            </a>
        </div>

        <?php
        $counter++;
        if ($counter % 3 === 0) {
            // Cerrar la fila actual y abrir una nueva fila después de cada grupo de 3 fotos
            echo '</div><div class="row row-cols-3 g-3">';
        }
        ?>
    <?php endforeach ?>
</div>
<script src="<?php echo base_url() ?>/public/dist/libs/fslightbox/index.js?1684106062" defer></script>