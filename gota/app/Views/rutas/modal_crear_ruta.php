<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear ruta </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="reset_formulario_crear_ruta()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('rutas/crearRuta'); ?>" method="post" id="crear_ruta">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="saltar(event,'btnCrearRuta')">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="reset_inputs('nombre')"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                        <span class="text-danger error-text nombre_error"></span>

                        <div class="modal-footer">
                            <div class="row g-2 align-items-end">
                                <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                    <button class="btn btn-green w-100" type="submit" id="btnCrearRuta">
                                        Crear
                                    </button>
                                </div>
                                <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                    <a class="btn btn-red w-100" onclick="reset_formulario_crear_ruta()" data-bs-dismiss="modal">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>