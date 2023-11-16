<div class="hr-text hr-text-center">
    <p class="h4 text-primary">Editar <?php echo $nombre_producto ?></p>
</div>

<div class="hr-text hr-text-left">
    <p class="h4 text-green">Información general </p>
</div>

<form class="row g-1" action="<?= base_url('producto/actualizar_precio_producto'); ?>" method="post" id="cambiar_datos_de_producto" autocomplete="off">
    <input type="hidden" id="codigo_interno_producto_editar" value="<?php echo $codigo_interno_producto ?>" name="codigo_interno_producto_editar">
    <div class="col-md-2">
        <label for="inputEmail4" class="form-label">Código interno</label>
        <input type="text" class="form-control" id="crear_producto_codigo_interno" name="crear_producto_codigo_interno" value="<?php echo $codigo_interno_producto ?>" readonly>
        <span class="text-danger error-text crear_producto_codigo_interno_error"></span>
    </div>

    <div class="col-md-4">
        <label for="inputEmail4" class="form-label">Código de barras</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <!-- Download SVG icon from http://tabler-icons.io/i/barcode -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                    <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                    <rect x="5" y="11" width="1" height="2" />
                    <line x1="10" y1="11" x2="10" y2="13" />
                    <rect x="14" y="11" width="1" height="2" />
                    <line x1="19" y1="11" x2="19" y2="13" />
                </svg>
            </span>
            <input type="text" class="form-control" name="crear_producto_codigo_de_barras" id="crear_producto_codigo_de_barras" onkeyup="saltar_creacion_producto(event,'crear_producto_nombre')">
        </div>
    </div>

    <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Nombre producto</label>
        <input type="text" class="form-control" id="crear_producto_nombre" name="crear_producto_nombre" onkeyup="saltar_creacion_producto(event,'categoria_producto'),minusculasAmayusculas()" value="<?php echo $nombre_producto ?>">
        <span class="text-danger error-text crear_producto_nombre_error"></span>
    </div>


    <div class="row g-1">
        <div class="col-md-3">
            <label for="">Categoria</label>
            <select class="form-select" id="editar_categoria_producto" name="edicion_de_categoria_producto" onkeyup="saltar_creacion_producto(event,'marca_producto')">

                <?php foreach ($categorias as $detalle) { ?>
                    <option value="<?php echo $detalle['codigocategoria'] ?>" <?php if ($detalle['codigocategoria'] == $id_categoria) : ?>selected <?php endif; ?>><?php echo $detalle['nombrecategoria'] ?> </option>
                <?php } ?>
            </select>

            <span class="text-danger error-text categoria_producto_error"></span>
        </div>
        <div class="col-sm">
            <br>
            <button type="button" class="btn btn-success btn-icon" title="Agregar categoria" data-bs-toggle="modal" data-bs-target="#agregar_categoria">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg></button>
        </div>


        <div class="col-md-3">
            <label for="">Marca</label>
            <select class="form-select" id="editar_marca_producto" name="editar_marca_producto">

                <?php foreach ($marcas as $detalle) { ?>
                    <option value="<?php echo $detalle['idmarca'] ?>"><?php echo $detalle['nombremarca'] ?></option>
                <?php } ?>
            </select>
            <span class="text-danger error-text editar_marca_producto_error"></span>
        </div>
        <div class="col-sm">
            <br>
            <button type="button" class="btn btn-success btn-icon" title="Agregar marca"><!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg></button>
        </div>

        <div class="col-md-2"><br>
            <?php if ($impresion_en_comanda == 'f') { ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" value="false" id="editar_impresion_en_comanda" name="editar_impresion_en_comanda" onkeyup="saltar_creacion_producto(event,'permitir_descuento')">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Imprimir comanda</label>
                </div>
            <?php } ?>
            <?php if ($impresion_en_comanda == 't') { ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="editar_impresion_en_comanda" name="editar_impresion_en_comanda" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Imprimir en comanda</label>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-2"><br>
            <?php if ($permite_descuento == 'f') { ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="editar_descuento" name="editar_descuento" onkeyup="saltar_creacion_producto(event,'permitir_descuento')">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Descuento</label>
                </div>
            <?php } ?>
            <?php if ($permite_descuento == 't') { ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="editar_descuento" name="editar_descuento" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Descuento</label>
                </div>
            <?php } ?>
        </div>


    </div>

    <div class="col-3">
        <label for="inputAddress2" class="form-label">Valor costo</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <!-- Download SVG icon from http://tabler-icons.io/i/coin -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                    <path d="M12 6v2m0 8v2" />
                </svg>
            </span>
            <input type="text" class="form-control" id="edicion_de_valor_costo_producto" value="<?php echo number_format($valor_costo, 0, ",", ".") ?>" name="edicion_de_valor_costo_producto" onkeyup="saltar_creacion_producto(event,'valor_venta_producto')">
        </div>
        <span class="text-danger error-text edicion_de_valor_costo_producto_error"></span>
    </div>

    <div class="col-md-2">
        <label for="inputPassword4" class="form-label">Información tributaria</label>
        <select class="form-select" id="editar_informacion_tributaria" name="informacion_tributaria" onchange="cambiar_informacion_tributaria()">
            <?php if ($aplica_ico == 't') { ?>
                <option value="1" selected>Impuesto Nacional al Consumo (ICO)</option>
                <option value="2">Impuesto al Valor Agregado (IVA)</option>
            <?php } ?>
            <?php if ($aplica_ico == 'f') { ?>
                <option value="2" selected>Impuesto al Valor Agregado (IVA)</option>
                <option value="1">Impuesto Nacional al Consumo (ICO)</option>
            <?php } ?>
        </select>
    </div>

    <?php if ($aplica_ico == 'f') { ?>
        <div class="col-md-1" id="editar_impuesto_al_valor_agregado">
            <label for="inputPassword4" class="form-label">Valor IVA </label>
            <select class="form-select" id="valor_iva" name="valor_iva">
                <?php foreach ($iva as $detalle) { ?>
                    <option value="<?php echo $detalle['idiva'] ?>" <?php if ($detalle['idiva'] == $id_iva) : ?>selected <?php endif; ?>><?php echo $detalle['valoriva']. "-" . $detalle['conceptoiva']  ?> </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-1" style="display: none" id="editar_impuesto_al_conusmo_nacional">
            <label for="inputPassword4" class="form-label">Valor ICO</label>
            <select class="form-select" id="valor_ico" name="valor_ico">
                <?php foreach ($ico as $detalle) { ?>
                    <option value="<?php echo $detalle['id_ico'] ?>"><?php echo $detalle['valor_ico'] ?></option>
                <?php } ?>
            </select>
        </div>


    <?php } ?>

    <?php if ($aplica_ico == 't') { ?>

        <div class="col-md-1" id="editar_impuesto_al_valor_agregado" style="display: none">
            <label for="inputPassword4" class="form-label">Valor IVA </label>
            <select class="form-select" id="valor_iva" name="valor_iva">
                <?php foreach ($iva as $detalle) { ?>
                    <option value="<?php echo $detalle['idiva'] ?>" selected><?php echo $detalle['valoriva']. "-" . $detalle['conceptoiva']  ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-1" style="display: block" id="editar_impuesto_al_conusmo_nacional">
            <label for="inputPassword4" class="form-label">Valor ICO</label>
            <select class="form-select" id="valor_ico" name="valor_ico">
                <?php foreach ($ico as $detalle) { ?>
                    <option value="<?php echo $detalle['id_ico'] ?>" <?php if ($detalle['id_ico'] == $id_ico) : ?>selected <?php endif; ?>><?php echo $detalle['valor_ico'] ?> </option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

<!--     <div class="col-md-3">
        <label for="inputPassword4" class="form-label">Tipo impuesto saludable </label>
        <select class="form-select" id="impuesto_saludable" name="impuesto_saludable">

            <?php foreach ($impuesto_saludable as $impuesto_saludable) { ?>

                <option value="<?php echo $impuesto_saludable['id']  ?>"><?php echo $impuesto_saludable['nombre'] ?></option>

            <?php } ?>

        </select>
    </div>

    <div class="col-md-2">
        <label for="inputPassword4" class="form-label">Valor impuesto saludable</label>
        <input type="text" class="form-control" id="valor_impuesto_saludable" name="valor_impuesto_saludable" value="<?php echo $valor_impuesto_saludable ?>">
    </div> -->




    <div class="col-3">
        <label for="inputAddress2" class="form-label">Precio 1 </label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <!-- Download SVG icon from http://tabler-icons.io/i/coin -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                    <path d="M12 6v2m0 8v2" />
                </svg>
            </span>
            <input type="text" class="form-control" id="editar_valor_venta_producto" name="editar_valor_venta_producto" value="<?php echo number_format($valor_venta, 0, ",", ".") ?>" onkeyup="saltar_creacion_producto(event,'precio_2')">
        </div>
        <span class="text-danger error-text editar_valor_venta_producto_error"></span>
    </div>

    <div class="col-3">
        <label for="inputAddress2" class="form-label">Precio 2 </label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <!-- Download SVG icon from http://tabler-icons.io/i/coin -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                    <path d="M12 6v2m0 8v2" />
                </svg>
            </span>
            <input type="text" class="form-control" id="editar_precio_2" name="precio_2" onkeyup="saltar_creacion_producto(event,'btn_crear_producto'),hablilitar_boton(event)" value="<?php echo $precio_2 ?>">
        </div>
        <span class="text-danger error-text precio_2_error"></span>
    </div>

    <div class="col-6">

    </div>
    <div class="col-6">
        <button type="submit" class="btn btn-success" id="btnguardar_cambios_edicion_producto">Guardar cambios</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    /**
     * Formato edicion costo producto 
     */
    const editar_costo = document.querySelector("#edicion_de_valor_costo_producto");

    function formatNumber(n) {
        n = String(n).replace(/\D/g, "");
        return n === "" ? n : Number(n).toLocaleString();
    }
    editar_costo.addEventListener("keyup", (e) => {
        const element = e.target;
        const value = element.value;
        element.value = formatNumber(value);
    });
</script>

<script>
    /**
     * Formato edicion costo producto 
     */
    const editar_precio_1 = document.querySelector("#editar_valor_venta_producto");

    function formatNumber(n) {
        n = String(n).replace(/\D/g, "");
        return n === "" ? n : Number(n).toLocaleString();
    }
    editar_precio_1.addEventListener("keyup", (e) => {
        const element = e.target;
        const value = element.value;
        element.value = formatNumber(value);
    });
</script>


<!--Actualizar precio  producto -->
<script>
    $('#cambiar_datos_de_producto').submit(function(e) {
        e.preventDefault();
        var form = this;
        let button = document.querySelector("#btnguardar_cambios_edicion_producto");
        button.disabled = true;
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
                button.disabled = false;
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    if (data.code == 1) {
                        $("#edicion_de_producto").modal("hide");
                        // $('#tipo_de_identificacion').val(null).trigger('change');
                        $(form)[0].reset();
                        table = $('#example').DataTable();
                        table.draw();
                        //$('#countries-table').DataTable().ajax.reload(null, false);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Edición de producto correcta  '
                        })
                    } else {
                        alert(data.msg);
                    }
                } else {
                    $.each(data.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });
</script>