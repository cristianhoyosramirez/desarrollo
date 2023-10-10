<?php $user_session = session(); ?>
<!-- Modal -->
<div class="modal fade" id="modal_tabla_amortizacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;">
                <div class="row">
                    <div class="col-6">
                        <p id="clientes"> Cliente </p>
                    </div>
                    <div class="col-6">
                        <p id="nombres"></p>
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="container">

            </div>
            <div class="modal-body" id="plan_pagos">

            </div>
            <div class="row">
                <div class="col">
                    <br>
                </div>
            </div>
            <div id="pago" class="container">
                <div class="row">
                    <div class="col-6 col-sm-4">
                        <p id="cuotas_atrasadas" class="h3">Cuotas atrasadas</p>
                    </div>
                    <div class="col-6 col-sm-4">
                        <p id="cuotas_atrasadas" class="h3">Saldo a la fecha </p>
                    </div>
                    <div class="col-6 col-sm-4">
                        <p id="cuotas_atrasadas" class="h3">Falta por cancelar  </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-4 col-form-label">Pago mínimo</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="pago_minimo" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputEmail3" class="col-4 col-form-label">Efectivo</label>
                    <div class="col-8">
                        <input type="number" class="form-control" id="efectivo" value="0" onkeyup="borrar_error()">
                    </div>
                    <span id="error_pago" style="color:red;"></span>
                </div>

                <div class="row mb-3">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" id="c_x_c">
                                <input type="hidden" id="id_usuario" value="<?php echo $user_session->id_usuario ?>">
                                <a class="btn btn-success me-md-2" type="button" onclick="abonar()">Pagar </a>
                            </div>
                            <div class="col">
                                <button class="btn btn-danger me-md-2" type="button">Cancelar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal-footer" id="modal_footer">
            <a type="button" class="btn btn-success">
                Guardar
            </a>
            <button type="button" class="btn btn-red" data-bs-dismiss="modal">Cancelar </button>
        </div>

    </div>
</div>