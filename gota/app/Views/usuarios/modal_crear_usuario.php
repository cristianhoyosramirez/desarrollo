<div class="modal modal-blur fade" id="modal_crear_usuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Crear usuario </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-end">

                    <span class="form-help h2" title="Creación de usuarios" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="
            <?php echo "Tener en cuenta los siguientes aspectos:";
            echo "</br>";
            echo "1. Si la persona ya ha sido registrada con anterioridad no es necesario crear los datos personales solo debe hacer una busqueda por número de documento o nombres. ";
            echo "</br>";
            echo "2. Todos los roles se debe asignar ruta(s) excepto al rol adminsitrador  ";
            ?> 
            
            ">?</span>
                </div>


                <div id="operaciones">
                    <form action="<?= base_url('usuarios/crearUsuario'); ?>" method="post" id="crear_usuarios" class="g-1">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Nombres </label>
                                    <div class="input-group input-group-flat">
                                        <input type="hidden" id="id_tercero" name="id_tercero">
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Buscar por nombre o identificación" onkeyup="saltar(event,'crear_usuario')">

                                        <span class="input-group-text">
                                            <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="reset_inputs('nombre')"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </span>
                                        <a class="btn btn-indigo btn-icon" title="Crear tercero" data-bs-toggle="tooltip" type="button" onclick="modal_crear_tercero()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                <path d="M16 19h6"></path>
                                                <path d="M19 16v6"></path>
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                            </svg></a>
                                    </div>
                                    <span class="text-danger error-text nombre_error"></span>
                                    <span class="text-danger error-text id_tercero_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">Usuario </label>
                                <input type="text" class="form-control" id="crear_usuario" name="crear_usuario" onkeyup="saltar(event,'pass_usuario')">
                                <span class="text-danger error-text crear_usuario_error"></span>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Contraseña </label>
                                    <input type="password" class="form-control" id="pass_usuario" name="pass_usuario" onkeyup="saltar(event,'rol')">
                                    <span class="text-danger error-text pass_usuario_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-4">
                                    <label class="form-label">Rol </label>
                                    <select class="form-select" id="rol" name="rol" onkeyup="saltar(event,'btnCrearUsuario')">
                                        <option value="" selected>Seleccione</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Supervisor</option>
                                        <option value="3">Supervisor</option>
                                        <option value="4">cobrador</option>
                                    </select>
                                </div>
                                <span class="text-danger error-text rol_error"></span>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-4">
                                    <label class="form-label">Rutas </label>
                                    <select class="form-select" id="rutas" name="rutas" onkeyup="saltar(event,'btnCrearUsuario')" name="ruta">
                                        <option value="" selected>Seleccione</option>
                                        <option value="1">Lima</option>
                                        <option value="2">
                                            Arequipa
                                        </option>
                                        <option value="3">Cusco </option>
                                    </select>
                                </div>
                                <span class="text-danger error-text rutas_error"></span>
                            </div>
                        </div>



                        <div class="modal-footer">
                            <div class="row g-2 align-items-end">
                                <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                    <button class="btn btn-green w-100" type="submit" id="btnCrearUsuario">
                                        Crear
                                    </button>
                                </div>
                                <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                    <button class="btn btn-red w-100">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>