<div class="row gx-3 gy-2">
    <?php foreach ($meseros as $detalle) :   ?>



        <?php $tiene_pedido = model('pedidoModel')->where('fk_usuario', $detalle['idusuario_sistema'])->findAll();  ?>

        <div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-3">

            <?php foreach ($tiene_pedido as $pedidos) : ?>

                <div class="card card_mesas text-white bg-red-lt cursor-pointer" >
                    <div class="row ">
                        <div class="col-3">
                            <span class="avatar">
                                <img src="<?php echo base_url(); ?>/Assets/img/ocupada.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                            </span>
                        </div>
                        <div class="col-9">
                            <div class="text-truncate text-center">
                                <strong class="text-truncate text-center small"><?php echo $detalle['nombresusuario_sistema'] ?></strong><br>

                            </div>
                        </div>
                    </div>
                </div>
            

        </div>

        <?php endforeach ?>

    <?php endforeach ?>
</div>