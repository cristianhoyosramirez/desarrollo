<div>

    <div class="row">

        <div class="col-3">
            Producto: <?php echo $producto[0]['nombreproducto'] ?>
        </div>
        <div class="col-3   ">
            Valor unitario : <?php echo "$ " . number_format($producto[0]['valor_unitario'], 0, ',', '.') ?>
        </div>
        <div class="col-2">
            Cantidad: <?php echo $producto[0]['cantidad_producto'] ?>
        </div>
        <div class="col-3">
            Total: <?php echo "$ " . number_format($producto[0]['valor_total'], 0, ',', '.') ?>
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