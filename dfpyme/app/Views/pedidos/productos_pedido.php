<style>
    .input-group-append {
        display: inline-flex;
        vertical-align: middle;
        /* Añadir esta propiedad para alinear verticalmente */
    }

    .btn {
        flex: 1;
        /* Distribuir espacio equitativamente entre los botones */
    }
</style>

<style>
    .custom-width {
        width: 100px;
        /* Ajusta el ancho según tus necesidades */
    }
</style>


<div class="table-responsive">
    <table class="table table-vcenter card-table table  table-hover table-border">

        <tbody>

            <?php foreach ($productos as $detalle) { ?>

                <tr onclick="agregar_nota(<?php echo $detalle['id'] ?>)">
                    <td>
                        <?php echo $detalle['nombreproducto']; ?>
                        <?php if (!empty($detalle['nota_producto'])) { ?>
                            <p class="text-primary fw-bold"><?php echo $detalle['nota_producto'] ?></p>

                        <?php } ?>
                    </td>
                    <td>
                        <?php echo "$" . number_format($detalle['valor_unitario'], 0, ",", ".")  ?>
                    </td>

                    <td>





                        <div class="input-group-append">
                            <a href="#" class="btn bg-muted-lt btn-icon " onclick="eliminar_cantidades(event,'<?php echo $detalle['id_tabla_producto'] ?>')">
                                <!-- Download SVG icon from http://tabler-icons.io/i/minus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                            </a>


                            <input type="hidden" class="form-control " value="<?php echo $detalle['cantidad_producto'] ?>">
                            <input type="number" class="w-5 form-control form-control-sm text-center custom-width" value="<?php echo $detalle['cantidad_producto'] ?>" onclick="detener_propagacion(event)" onkeypress="return valideKey(event)" min="1" max="100" onkeyup="actualizar_producto_cantidad(event,this.value,<?php echo $detalle['id_tabla_producto'] ?>)" readonly>

                            <a href="#" class="btn bg-muted-lt  btn-icon " onclick="actualizar_cantidades(event,'<?php echo $detalle['id_tabla_producto'] ?>')" title="Agregar producto">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                            </a>
                        </div>
                    </td>

                    <td>
                        <?php echo "$" . number_format($valor = $detalle['valor_total'], 0, ",", "."); ?>
                    </td>

                    <td> <a href="#" class="btn text-white bg-red-lt w-1 btn-icon" aria-label="Bitbucket" onclick="eliminar_producto(event,'<?php echo $detalle['id_tabla_producto'] ?>')">
                            <!-- Download SVG icon from http://tabler-icons.io/i/trash -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="4" y1="7" x2="20" y2="7" />
                                <line x1="10" y1="11" x2="10" y2="17" />
                                <line x1="14" y1="11" x2="14" y2="17" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </a></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>