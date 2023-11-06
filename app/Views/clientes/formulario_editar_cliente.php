<form class="row g-1" action="<?= base_url('clientes/actualizar_datos_cliente'); ?>" method="post" id="cliente_editar" autocomplete="off">

    <input type="hidden" value="<?php echo $datos_cliente['id'] ?>" name="id_cliente">

    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Cedula</label>
        <input type="text" class="form-control" id="identificacion_cliente" name="identificacion_cliente" onkeyup="saltar_cliente(event,'nombres_cliente_pedido');" onkeypress="return soloNumeros(event)" value="<?php echo $datos_cliente['nitcliente'] ?>">
        <span class="text-danger error-text identificacion_cliente_error"></span>
    </div>
    <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Nombre y apellidos </label>
        <input type="text" class="form-control" id="nombres_cliente" name="nombres_cliente" onkeyup="saltar_cliente(event,'regimen_cliente_pedido');" value="<?php echo $datos_cliente['nombrescliente'] ?>">
        <span class="text-danger error-text nombres_cliente_error"></span>
    </div>
    <div class="col-4">
        <label for="inputAddress" class="form-label">Régimen</label>
        <select class="form-select select2" name="regimen_cliente" id="regimen_cliente" onkeyup="saltar_cliente(event,'tipo_cliente_pedido');">
            <?php foreach ($regimen as $detalle) { ?>
                <option value="<?php echo $detalle['idregimen'] ?>" <?php if ($detalle['idregimen'] == $datos_cliente['idregimen']) : ?>selected <?php endif; ?>><?php echo $detalle['nombreregimen'] ?> </option>
            <?php } ?>
        </select>
        <span class="text-danger error-text regimen_cliente_error"></span>
    </div>
    <div class="col-4">
        <label for="inputAddress2" class="form-label">Tipo</label>
        <select class="form-select select2" name="tipo_cliente" id="tipo_cliente" onkeyup="saltar_cliente(event,'clasificacion_cliente_pedido');">
            <?php foreach ($tipo_cliente as $detalle) { ?>
                <option value="<?php echo $detalle['id'] ?>" <?php if ($detalle['id'] == $datos_cliente['id']) : ?>selected <?php endif; ?>><?php echo $detalle['descripcion'] ?> </option>
            <?php } ?>
        </select>
        <span class="text-danger error-text tipo_cliente_error"></span>
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Clasificación</label>
        <select id="clasificacion_cliente" name="clasificacion_cliente" class="form-select" onkeyup="saltar_cliente(event,'telefono_cliente_pedido');">
            <?php foreach ($clasificacion_cliente as $detalle) { ?>
                <option value="<?php echo $detalle['id'] ?>" <?php if ($detalle['id'] == $datos_cliente['id']) : ?>selected <?php endif; ?>><?php echo $detalle['descripcion'] ?> </option>
            <?php } ?>
        </select>
        <span class="text-danger error-text clasificacion_cliente_error"></span>
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Teléfono</label>
        <input type="text" name="telefono_cliente" id="telefono_cliente" data-mask="(000) 000-0000" data-mask-visible="true" placeholder="(00) 0000-0000" autocomplete="off" class="form-control" onkeyup="saltar_cliente(event,'celular_cliente_pedido');" value="<?php echo $datos_cliente['telefonocliente'] ?>">
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Célular</label>
        <input type="text" id="celular_cliente" data-mask="(000) 000-0000" data-mask-visible="true" placeholder="(00) 0000-0000" name="celular_cliente" class="form-control" onkeyup="saltar_cliente(event,'e-mail_pedido');" value="<?php echo $datos_cliente['celularcliente'] ?>">
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">E-mail</label>
        <input type="text" onkeydown="validar_email()" id="e-mail" name="e-mail" class="form-control" onkeyup="saltar_cliente(event,'departamento_pedido');" value="<?php echo $datos_cliente['emailcliente'] ?>">
        <span id="error_email"></span>
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Departamento</label>
        <select id="departamento" name="departamento" class="form-select" onkeyup="saltar_cliente(event,'municipios_pedido');">
            <?php foreach ($departamentos as $detalle) { ?>

                <option value="<?php echo $detalle['iddepartamento'] ?>" <?php if ($detalle['iddepartamento'] == $id_departamento) : ?>selected <?php endif; ?>><?php echo $detalle['nombredepartamento'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Ciudad</label>
        <select id="municipios" name="municipios" class="form-select" onkeyup="saltar_cliente(event,'direccion_cliente_pedido');">
            <?php foreach ($departamentos as $detalle) { ?>
                <option value="<?php echo $id_ciudad ?>" selected><?php echo $ciudad ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Dirección</label>
        <input type="text" id="direccion_cliente" name="direccion_cliente" class="form-control" onkeyup="saltar_cliente(event,'agregar_cliente_pedido');" value="<?php echo $datos_cliente['direccioncliente'] ?>">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="btn_editar_cliente">Guardar cambios </button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>

<!--Actualizar los datos de las resolucion de facturacion -->
<script>
    $('#cliente_editar').submit(function(e) {
        e.preventDefault();
        var form = this;
        let button = document.querySelector("#btn_editar_cliente");
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
                        $("#editar_cliente").modal("hide");
                        // $('#tipo_de_identificacion').val(null).trigger('change');
                        $(form)[0].reset();
                        table = $('#clientes').DataTable();
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
                            title: 'Datos de cliente actualizado correctamente  '
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