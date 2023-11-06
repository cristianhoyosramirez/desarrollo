<div class="row">
    <?php
    foreach ($productos as $valor) : 
    ?>
    <div class="col-12 col-sm-6 col-lg-4 col-xl-4">
        <div class="cursor-pointer mb-1 elemento">
            <label class="form-selectgroup-item flex-fill" onclick="agregar_al_pedido(<?php echo $valor['codigointernoproducto'] ?>)">
                <div class="form-selectgroup-label d-flex align-items-center p-3 bg-azure-lt text-white">
                    <div class="me-3">
                    </div>
                    <div class="form-selectgroup-label-content d-flex align-items-center">
                        <span class="avatar me-3" style="background-image: url(<?php echo base_url(); ?>/images/productos/producto.png)"></span>
                        <div>
                            <div class="font-weight-medium text-primary text-start"><?php echo $valor['nombreproducto'] ?></div>
                            <div class="text-muted text-start"><?php echo "$ " . number_format($valor['valorventaproducto'], 0, ",", ".") ?></div>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <?php endforeach; ?>
</div>
