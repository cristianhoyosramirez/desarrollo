<div class="row gx-3 gy-2">
    <?php foreach ($mesas as $detalle) : ?>

        <?php $tiene_pedido = model('pedidoModel')->pedido_mesa($detalle['id']);  ?>
        <div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-3">
            <?php if (empty($tiene_pedido)) : ?>



                <div class="card card_mesas text-white bg-green-lt cursor-pointer" onclick="pedido('<?php echo $detalle['id'] ?>','<?php echo $detalle['nombre'] ?>')">
                    <div class="row ">
                        <div class="col-3">
                            <span class="avatar">
                                <img src="<?php echo base_url(); ?>/Assets/img/ocupada.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                            </span>
                        </div>
                        <div class="col-9">
                            <div class="text-truncate text-center">
                                <strong class="text-truncate text-center small"><?php echo $detalle['nombre'] ?></strong><br>

                            </div>
                        </div>
                    </div>
                </div>





            <?php endif ?>


            <?php if (!empty($tiene_pedido)) : ?>


                <div class="card card_mesas text-white bg-red-lt cursor-pointer" onclick="pedido_mesa('<?php echo $detalle['id'] ?>','<?php echo $detalle['nombre'] ?>')">

                    <div class="row">

                        <div class="col-3">
                            <span class="avatar">
                                <img src="<?php echo base_url(); ?>/Assets/img/ocupada.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                            </span>
                        </div>
                        <div class="col-9">
                            <div class="text-truncate text-center">

                                <strong class="text-truncate text-center small"><?php echo $detalle['nombre']
                                                                                ?></strong><br>
                                <strong class="text-truncate text-center small"><?php echo "$ " . number_format($tiene_pedido[0]['valor_total'], 0, ",", ".")
                                                                                ?></strong><br>
                                <strong class="text-truncate text-center small"><?php echo $tiene_pedido[0]['nombresusuario_sistema']?></strong><br>
                                <strong class="text-truncate text-center small"><?php echo $tiene_pedido[0]['nota_pedido']?></strong>
                            </div>
                        </div>
                    </div>

                </div>

            <?php endif ?>


        </div>



    <?php endforeach ?>
</div>