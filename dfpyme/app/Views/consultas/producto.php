<div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-6">
            Producto: <?php echo $producto[0]['nombreproducto'] ?>
        </div>
        <div class="col-md-6 col-sm-6 col-6">
            Valor unitario: <?php echo "$" . number_format($producto[0]['valor_unitario'], 0, ',', '.') ?>
        </div>
        <div class="col-md-6 col-sm-6 col-6 ">
            Cantidad: <?php echo $producto[0]['cantidad_producto'] ?>
        </div>
        <div class="col-md-6 col-sm-6 col-6 ">
            Total: <?php echo "$" . number_format($producto[0]['valor_total'], 0, ',', '.') ?>
        </div>
    </div>

</div>
<?php if (!empty($producto[0]['nota_producto'])) { ?>
    <div class="row">
        <div class="col">
            Nota: <?php echo $producto[0]['nota_producto'] ?>
        </div>
    </div>
<?php } ?>

</div>