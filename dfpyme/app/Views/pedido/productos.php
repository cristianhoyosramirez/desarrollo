<div class="row ">
    <?php
    foreach ($productos as $valor) : ?>
        <div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-3">
            <div class="cursor-pointer mb-1 elemento " onclick="agregar_al_pedido(<?php echo $valor['codigointernoproducto'] ?>)">
                <div class="row ">

                    <div class="card card_mesas  bg-primary-lt  cursor-pointer" >
                        <div class="row ">
                            <div class="col-3">
                                <span class="avatar">
                                    <img src="<?php echo base_url(); ?>/images/productos/producto.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                                </span>
                            </div>
                            <div class="col-9">
                                <div class="text-truncate text-center">
                                    <strong class="text-truncate text-center small"><?php echo $valor['nombreproducto'] ?></strong><br>
                                    <strong class="text-truncate text-center small"><?php echo "$ " . number_format($valor['valorventaproducto'], 0, ",", ".") ?></strong><br>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    <?php endforeach ?>

</div>