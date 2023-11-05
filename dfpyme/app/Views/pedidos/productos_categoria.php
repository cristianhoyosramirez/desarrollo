 <?php foreach ($productos as $valor) : ?>

     <div class="cursor-pointer mb-2" onclick="agregar_al_pedido(<?php echo $valor['id']?>)">
         <div class="row">
             <div class="col-auto">
                 <span class="avatar">
                     <img src="<?php echo base_url(); ?>/images/productos/producto.png" width="110" height="32" alt="Macondo" class="navbar-brand-image">
                 </span>
             </div>
             <div class="col">
                 <div class="text-truncate">
                     <strong><?php echo $valor['nombreproducto'] ?></strong>
                 </div>
                 <div class="text-muted"><?php echo "$" . number_format($valor['valorventaproducto'], 0, ",", ".") ?></div>
             </div>
             
         </div>
         <hr class="my-1"> <!-- Línea de separación -->
     </div>
     </div>
 <?php endforeach ?>