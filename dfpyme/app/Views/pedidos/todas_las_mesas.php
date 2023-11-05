<?php $user_session = session(); ?>
<div class="scrollable-div">
    <div class="row">
        <?php foreach ($mesas as $detalle) { ?>
            <div class="col-sm-4 col-md-3 col-xs-6 ">
                <!-- La mesa no tiene pedido -->
                <?php $tiene_pedido = model('pedidoModel')->pedido_mesa($detalle['id']); ?>

                <?php if (empty($tiene_pedido)) : ?>
                    <div class="text-white bg-green-lt border border-3 cursor-pointer " onClick="pedido(<?php echo $detalle['id'] ?>);">
                        <div class="row">
                            <p class=" text-center text-white-90"> Mesa: <span id="nombre_mesa"><?php echo $detalle['nombre'] ?></span></p>
                        </div>
                        <div class="row">
                            <div class="col">
                                <img src="<?php echo base_url(); ?>/Assets/img/libre.png" height="5" class="img-fluid mx-auto d-block cursor-pointer w-20">
                            </div>
                        </div><br>
                    </div>
                    <br>
                <?php endif ?>

                <?php if (!empty($tiene_pedido)) { ?>

                    <div class="text-white bg-red-lt border border-3  " onClick="pedido(<?php echo $detalle['id'] ?>);">
                        <div class="row">
                            <p class=" text-center text-white-90"> Mesa: <span id="nombre_mesa"><?php echo $detalle['nombre'] ?></span></p>
                        </div>
                        <div class="row">
                            <div class="col">
                                <img src="<?php echo base_url(); ?>/Assets/img/libre.png" height="5" class="img-fluid mx-auto d-block cursor-pointer w-20">
                            </div>
                        </div>
                        <br>
                        <div class="row gy-2 container">
                            <div class="col-12 col-md-6 col-xs-12">
                                <a title="Imprimir prefactura" class="btn bg-cyan text-white btn-pill w-100 btn-icon" onclick="impresion_prefactura(event,<?php echo $detalle['id'] ?>)">
                                    Prefacturas
                                </a>
                            </div>
                            <?php $administrador = model('usuariosModel')->select('idtipo')->where('idusuario_sistema', $user_session->id_usuario)->first(); ?>

                            <div class="col-12 col-md-6 col-xs-12">

                                <button title="Facturar " onclick="event.stopPropagation()" class="btn btn-success w-100 btn-pill btn-icon" type="button">
                                    <?php echo "$" . number_format($tiene_pedido[0]['valor_total'], 0, ",", "."); ?>
                                </button>

                            </div>
                        </div><br>

                        <br>
                    </div>
                    <br>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>