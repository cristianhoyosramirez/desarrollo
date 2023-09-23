<div class="container">
    <div class="row gy-2">
        <?php foreach ($mesas as $detalle) : ?>
            <?php $tiene_pedido = model('pedidoModel')->pedido_mesa($detalle['id']); ?>

            <div class="col-sm-4 col-md-2 col-xs-6">
                <?php if (empty($tiene_pedido)) : ?>
                    <div class=" card card_mesas text-white bg-green-lt cursor-pointer" onclick="pedido('<?php echo $detalle['id'] ?>','<?php echo $detalle['nombre'] ?>')">
                        <div class="row">
                            <div class="col-3">
                                <span class="avatar">
                                    <img src="<?php echo base_url(); ?>/Assets/img/libre.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                                </span>
                            </div>
                            <div class="col">
                                <div class="text-truncate">
                                    <strong><?php echo $detalle['nombre'] ?></strong>
                                </div>

                            </div>

                        </div>
                    </div>



                <?php elseif (!empty($tiene_pedido)) : ?>

                    <div class=" card card_mesas text-white bg-red-lt cursor-pointer" onclick="pedido('<?php echo $detalle['id'] ?>','<?php echo $detalle['nombre'] ?>')">
                        <div class="row">
                            <div class="col-3">
                                <span class="avatar">
                                    <img src="<?php echo base_url(); ?>/Assets/img/ocupada.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                                </span>
                            </div>
                            <div class="col">
                                <div class="text-truncate text-center">
                                    <strong class="text-truncate text-center small" ><?php echo $detalle['nombre'] ?></strong><br>
                                    <strong class="text-truncate text-center small"><?php echo "$ " . number_format($tiene_pedido[0]['valor_total'], 0, ",", ".") ?></strong><br>
                                    <strong class="text-truncate text-center small"><?php echo $tiene_pedido[0]['nombresusuario_sistema'] ?></strong>
                                </div>

                            </div>

                        </div>
                    </div>

                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
</div>