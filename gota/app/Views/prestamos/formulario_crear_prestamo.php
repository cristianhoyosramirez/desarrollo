<?php $user_session = session(); ?>

<form class="row g-3" action="<?php base_url() ?>prestamos/generarPrestamo" method="POST" id="frm_prestamos">
    <div class="col-md-4">
        <label class="form-label">Cliente </label>
        <div class="input-group input-group-flat">
            <input type="hidden" value="<?php echo $user_session->id_usuario; ?>" name="id_usuario">
            <input type="hidden" id="id_cliente" name="id_cliente">
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
    </div>
    <div class="col-md-4">
        <label for="inputPassword4" class="form-label">Monto solicitado </label>
        <input type="number" class="form-control" id="monto" name="monto">
    </div>
    <div class="col-md-4">
        <label for="inputAddress" class="form-label">Detalle</label>
        <input type="text" class="form-control" id="detalle" name="detalle">
    </div>

    <div class="col-md-4">
        <label for="inputAddress2" class="form-label">Intereses</label>
        <input type="number" class="form-control" id="intereses" name="intereses">
        <span class="text-danger error-text intereses_error"></span>
    </div>
    <div class="col-md-4">
        <label for="inputState" class="form-label">Tipo prestamo</label>
        <select id="inputState" class="form-select">
            <option selected>Nuevo</option>
            <option>Renovación</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="inputAddress" class="form-label">Plazo</label>
        <div class="input-group">
            <input type="number" class="form-control" id="plazo" name="plazo">
            <select class="form-select" id="frecuencia" name="frecuencia" >
                <option selected>Dias</option>
                <option value="1">Semana</option>
                <option value="2">Quincena</option>
                <option value="3">Mes</option>
            </select>
        </div>
        <span class="text-danger error-text frecuencia_error"></span>
    </div>


    <div class="row g-2 align-items-center">
        <div class="col-3 col-sm-8 col-md-2 col-xl py-3">

        </div>
        <div class=" col-3 py-3">
            <button class="btn btn-green  w-100" id="btnPrestamo">
                Crear
            </button>
        </div>
        <div class="col-3 py-3">
            <button class="btn btn-red  w-100">
                Cancelar
            </button>
        </div>
    </div>
    <br>
</form>