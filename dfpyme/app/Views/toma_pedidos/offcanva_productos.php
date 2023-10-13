<style>
  /* Establecer el ancho del toast */
  .swal2-toast {
    width: 200px; /* Ajusta el ancho según tus preferencias */
  }
</style>

    
    
    
    
    
    <?php $alturaCalc = "37rem + 10px"; // Calcula la altura 
    ?>

    <!-- <div class="offcanvas offcanvas-start" style="width: 100%; height: 100vh;" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel"> -->
    <div class="offcanvas offcanvas-start " style="width: 100%; height: 100vh;" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" data-bs-scroll="true">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Productos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" onclick="mesas_actualizadas()"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="horizontal-list">
                <?php foreach ($categorias as $detalle) : ?>

                    <li><button type="button" class="btn btn-outline-indigo btn-pill btn-sm" id="categoria_<?php echo $detalle['codigocategoria'] ?>" onclick="productos_categoria(<?php echo $detalle['codigocategoria'] ?>)"><?php echo $detalle['nombrecategoria'] ?></button></li>

                <?php endforeach ?>
            </ul>
            <div>
                <div class="card" style="height: calc(<?php echo $alturaCalc; ?>)">
                    <div class="card-header border-0" style="margin-bottom: -10px; padding-bottom: 0;" id="pedido">
                        <div class="card-title">
                            <div class="mb-3">
                                <div class="input-group input-group-flat">
                                    <input type="text" class="form-control " autocomplete="off" placeholder="Buscar por nombre o código " onkeyup="buscar_productos(this.value)">
                                    <span class="input-group-text">
                                        <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="limpiarCampo()"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M18 6l-12 12" />
                                                <path d="M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <span id="error_producto" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                        <div id="productos_categoria"></div>


                        <div class="row " id="canva_producto">
                            <?php $productos = model('productoModel')->orderBy('nombreproducto', 'asc')->findAll();
                            foreach ($productos as $valor) : ?>
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-4 ">
                                    <div class="cursor-pointer mb-1 elemento " onclick="agregar_al_pedido(<?php echo $valor['codigointernoproducto'] ?>)">
                                        <div class="row ">
                                            <label class="form-selectgroup-item flex-fill ">
                                                <input type="checkbox" name="form-project-manager[]" value="1" class="form-selectgroup-input ">
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
                                </div>

                            <?php endforeach ?>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample'));
    </script>