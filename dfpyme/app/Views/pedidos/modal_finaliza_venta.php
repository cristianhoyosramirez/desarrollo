<div class="modal fade" id="finalizar_venta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <p class="h3 text-center">FINALIZAR VENTA</p>



        <div class="row row-cards">
          <div class="col-md-6 col-lg-6">
            <div class="card">
              <div class="card-header card-header-light">
                <h3 class="card-title">Datos factura </h3>
              </div>
              <div class="card-body">

                <form>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Cliente</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Tipo documento </label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha limite</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-6">
            <div class="card">
              <div class="card-header card-header-light">
                <h3 class="card-title">Datos pago </h3>
              </div>
              <div class="card-body">

                <form>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Sub total </label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Descuento </label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Propina</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Efectivo</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="inputEmail3">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">P electrónico</label>
                    <div class="col-sm-8">
                      <div class="mb-3">
                        <label class="form-label"></label>
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="form-payment" value="visa" class="form-selectgroup-input">
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="payment payment-provider-visa payment-xs me-2"></span>
                                Nequi <strong><input type="text" class="form-control"></strong>
                              </div>
                            </div>
                          </label>
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="form-payment" value="mastercard" class="form-selectgroup-input" checked>
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="payment payment-provider-mastercard payment-xs me-2"></span>
                                ending in <strong>2807</strong>
                              </div>
                            </div>
                          </label>
                          <label class="form-selectgroup-item flex-fill">
                            <input type="radio" name="form-payment" value="paypal" class="form-selectgroup-input">
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                              <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                              </div>
                              <div>
                                <span class="payment payment-provider-paypal payment-xs me-2"></span>
                              </div>
                            </div>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>





        </div>















        <div class="modal-footer">
          <button type="button" data-bs-dismiss="modal" onclick="reset_inputs()" class="btn btn-danger">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>