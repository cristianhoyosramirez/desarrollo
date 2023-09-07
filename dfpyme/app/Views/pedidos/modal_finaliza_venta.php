<style>
  .table-numeric {
    width: 100%;
    border-collapse: collapse;
  }

  .table-numeric td {
    vertical-align: top;
    text-align: center;
    width: 33.33333333333%;
    border: 0;
  }

  .table-numeric button {
    position: relative;
    cursor: pointer;
    display: block;
    width: 100%;
    box-sizing: border-box;
    padding: 0.6em 0.3em;
    font-size: 1em;
    border-radius: 0.1em;
    outline: none;
    user-select: none;

  }
</style>






<div class="modal fade" id="finalizar_venta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="row">
            <div class="col-12">
              <h5 class="modal-title">Finalizar venta</h5>
            </div>
            <div class="col-12">
              <div id="mensaje_factura"></div>
            </div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cancelar_pagar()"></button>
      </div>
      <div class="modal-body">

        <div class="row row-cards">
          <div class="col-md-5 col-lg-5">
            <div class="card">
              <div class="card-body">
                <form>
                  <input type="hidden" id="valor_total_a_pagar">
                  <div class="mb-2">

                    <div class="input-group input-group-flat">

                      <input type="text" class="form-control" id="buscar_cliente" name="buscar_cliente" placeholder="Buscar cliente por identificación o nombre">
                      <span class="input-group-text">
                        <a href="#" class="link-secondary" title="Limpiar busqueda" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                          </svg>
                        </a>
                        <a href="#" class="link-secondary ms-2" title="Nuevo cliente " data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/adjustments -->
                          <!-- Download SVG icon from http://tabler-icons.io/i/user-plus -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            <path d="M16 11h6m-3 -3v6" />
                          </svg>
                        </a>
                      </span>
                    </div>
                  </div>
                  <div class="row mb-2">

                    <div class="col-sm-12">
                      <input type="hidden" value="<?php echo $nit_cliente ?>" id="nit_cliente">
                      <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<?php echo $nombre_cliente ?>" readonly>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Documento</label>
                    <div class="col-sm-8">
                      <select class="form-select" id="documento" name="documento" onchange="habilitarBotonPago()">
                        <option value="1">POS Contado</option>
                        <option value="8">Factura electrónica</option>
                      </select>
                      <p class="text-danger h3" id="error_documento"></p>
                    </div>
                  </div>

                  <div class="row mb-2">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha limite</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" id="inputEmail3" value="<?php echo date('Y-m-d') ?>">
                    </div>
                  </div>

                  <div class="row mb-2">

                    <div class="col-sm-12">
                      <p class="text-center h2" id="sub_total_pedido"></p>
                    </div>
                  </div>

                  <div class="row mb-2">

                    <div class="col-sm-12">
                      <div class="input-group">

                        <select class="form-select w-1" aria-label="Default select example" disabled>
                          <option value="">Descuento</option>

                          <option value="">Descuento % </option>
                          <option value="">Descuento $ </option>

                        </select>
                        <input type="text" value=0 class="form-control" disabled>
                        <input type="text" value=0 class="form-control" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">

                    <div class="col-sm-12">
                      <div class="input-group">
<!-- 
                        <select class="form-select w-1" aria-label="Default select example" id="criterio_propina_final"  >
                          
                          <option value="1">Propina % </option>
                          
                        </select> -->

                        <input type="hidden" value="1"  id="criterio_propina_final">
                        <label for="" class="col-sm-4 col-form-label" style="width: 100px;">Propina</label>
                        <input type="text" value=0 class="form-control" onkeyup="calcular_propina_final(this.value)" id="propina_pesos_final" placeholder="%" >
                        <input type="text"  class="form-control" id="total_propina" onkeyup="total_pedido_final(this.value)"  placeholder="$" value=0 >
                        
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">

                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="card">

              <div class="card-body">

                <form>
                  <div class="row mb-2">
                    <p class="text-center h2" id="total_pedido"> </p>
                    <p id="valor_pago_error" class="text-danger h3"></p>
                  </div>
                  <div class="row mb-2">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Efectivo </label>
                    <div class="col-sm-9">
                      <input type="text" inputmode="numeric" class="form-control" id="efectivo" name="efectivo" onkeyup="cambio(this.value),saltar_factura_pos(event,'transaccion')">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <label for="inputEmail3" class="col-sm-6 col-form-label w-6">Banco</label>

                    </div>
                    <div class="col-sm-9">

                      <div class="input-group">

                        <select class="form-select w-20" aria-label="Default select example" id="banco" name="banco">

                          <?php foreach ($bancos as $detalle) : ?>
                            <option value="<?php echo $detalle['id'] ?>"><?php echo  $detalle['nombre'] ?> </option>
                          <?php endforeach ?>
                        </select>
                        <input type="text" aria-label="Last name" class="form-control" id="transaccion" name="transaccion" value=0 onkeyup="cambio_transaccion(this.value),saltar_factura_pos(event,'btn_pagar')">
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">

                    <div class="col-sm-12">
                      <p class="text-center h2" id="pago"> Valor pago: 0</p>
                    </div>
                  </div>
                  <div class="row mb-3">

                    <div class="col-sm-12">
                      <p class="text-center h2" id="cambio"> &nbsp; &nbsp; &nbsp;&nbsp;Cambio: 0</p>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-12 text-center">
                      <input type="hidden" id="tipo_pago" value="1"> <!-- Tipo de pago 1 = pago completo; 0 pago parcial -->
                      <input type="hidden" id="requiere_factura_electronica">
                      <button type="button" class="btn btn-outline-success col-sm-4 " id="btn_pagar" onclick="pagar()">Pagar</button>
                      <button type="button" class="btn btn-outline-red col-sm-4" onclick="cancelar_pagar()">Cancelar</button>
                    </div>
                  </div>
                </form>
                <div class="row mb-3">

                </div>
              </div>
            </div>

          </div>

          <div class="col-md-3 col-lg-3">
            <div class="card">
              <div class="card-header card-header-light">
                <h3 class="card-title"></h3>
              </div>
              <div class="card-body">

                <div class="row mb-3">

                  <div class="col">
                    <table class="table-numeric" id="formulario">
                      <tbody>
                        <tr>
                          <td style="width: 10px;"><button type="button" class="btn btn-outline-success py-3 " onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '1';">1</button></td>
                          <td><button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '2';">2</button></td>
                          <td><button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '3';">3</button></td>
                        </tr>
                        <tr>
                          <td> <button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '4';">4</button></td>
                          <td><button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '5';">5</button></td>
                          <td> <button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '6';">6</button></td>
                        </tr>
                        <tr>
                          <td> <button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '7';">7</button></td>
                          <td><button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '8';">8</button></td>
                          <td><button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '9';">9</button></td>
                        </tr>

                        <tr>
                          <td> <button type="button" class="btn bg-orange-lt py-3 w-7" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value.slice(0, -1);borrar_error()"><!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="10" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <line x1="5" y1="12" x2="11" y2="18" />
                                <line x1="5" y1="12" x2="11" y2="6" />
                              </svg></button></td>
                          <td> <button type="button" class="btn btn-outline-success py-3" onclick="document.getElementById('efectivo').value=document.getElementById('efectivo').value + '0';">0</button></td>
                          <td> <button type="button" class="btn bg-green-lt py-3" onclick="login()"><!-- Download SVG icon from http://tabler-icons.io/i/letter-x -->
                              <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l5 5l10 -10" />
                              </svg></button></td>
                      </tbody>
                    </table>
                  </div>
                </div>





              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<script>

</script>