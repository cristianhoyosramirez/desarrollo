<!-- Modal -->
<div class="modal fade" id="modal_terceros" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3" id="staticBackdropLabel">Terceros</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="crud_terceros"></div>
                <form class="row g-1" action="<?= base_url('terceros/crear_terceros'); ?>" method="post" id="creacion_tercero">
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">
                            Tipo de identificacion
                        </label>
                        <select class="form-select" id="tipos_de_identificacion" name="tipos_de_identificacion">
                            <option value="">Seleccione</option>
                        </select>
                        <span class="text-danger error-text tipos_de_identificacion_error"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="inputPassword4" class="form-label">Identificación</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" onkeyup="saltar(event,'nombre')">
                        <span class="text-danger error-text identificacion_error"></span>
                    </div>
                    <div class="col-4">
                        <label for="inputAddress" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" onkeyup="saltar(event,'direccion')">
                        <span class="text-danger error-text nombre_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="inputCity" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" onkeyup="saltar(event,'telefono')">
                        <span class="text-danger error-text direccion_error"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" onkeyup="saltar(event,'email')">
                        <span class="text-danger error-text telefono_error"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="inputZip" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" onkeyup="saltar(event,'btnAgregarTercero')">
                        <span class="text-danger error-text email_error"></span>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-green" id="btnCrearUsuario">Agregar </button>
                        <button type="button" class="btn btn-red">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

