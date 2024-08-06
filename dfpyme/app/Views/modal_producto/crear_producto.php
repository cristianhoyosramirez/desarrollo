<!-- Modal Crear producto-->
<div class="modal fade " id="crear_producto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">

      <div class="modal-body">
        <div class="hr-text text-primary ">
          <p class="h4 text-primary">Crear producto</p>
        </div>



        <div class="text-end">

          <a href="#" id="favorito-btn" class="btn btn-outline-warning btn-icon " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Agregar a favoritos" onclick="favorito()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
            </svg>
          </a>

        </div>

        <form class="row g-1" action="<?= base_url('producto/creacion_producto'); ?>" method="post" id="producto_agregar" autocomplete="off">

          <input type="hidden" value="false" id="favorito" name="favorito">
          <div class="hr-text hr-text-left">
            <p class="h4 text-green">Información general</p>
          </div>



          <div class="col-md-2">
            <label for="inputEmail4" class="form-label">Códido</label>
            <input type="text" class="form-control" id="crear_producto_codigo_interno" name="crear_producto_codigo_interno" readonly>
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

          <div class="col-md-5">
            <label for="inputPassword4" class="form-label">Nombre producto</label>
            <input type="text" class="form-control" id="crear_producto_nombre" name="crear_producto_nombre" onkeyup="saltar_creacion_producto(event,'categoria_producto'),minusculasAmayusculas()">
            <span class="text-danger error-text crear_producto_nombre_error"></span>
          </div>




          <div class="col-md-3">
            <label for="">Categoria</label>
            <select class="form-select" id="categoria_product" name="categoria_producto" onchange="sub_categorias_productos(this.value)" onkeyup="saltar_creacion_producto(event,'marca_producto')">
              <option value="">Seleccione una categoria</option>
              <?php foreach ($categorias as $valor) { ?>

                <option value="<?php echo $valor['codigocategoria'] ?>"><?php echo $valor['nombrecategoria'] ?> </option>

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

          <div class="col-md-3" id="div_sub_categoria" style="display:none">
            <input type="hidden" id="requiere_categoria" value=0>
            <label for="">Sub categoria</label>
            <select class="form-select" id="sub_categoria" name="sub_categoria">
              <option value="">Seleccione una sub categoria </option>
              <?php foreach ($sub_categorias as $valor) { ?>

                <option value="<?php echo $valor['id'] ?>"><?php echo $valor['nombre'] ?> </option>

              <?php } ?>
            </select>

            <span class="text-danger " id="error_sub_categoria"></span>
          </div>




          <div class="col-md-3">
            <label for="">Marca</label>
            <select class="form-select" id="marca_product" name="marca_producto">

              <?php foreach ($marcas as $valor) : ?>

                <option value="<?php echo $valor['idmarca'] ?>"> <?php echo $valor['nombremarca'] ?> </option>

              <?php endforeach ?>


            </select>
            <span class="text-danger error-text marca_producto_error"></span>
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
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="impresion_en_comanda" name="impresion_en_comanda" onkeyup="saltar_creacion_producto(event,'permitir_descuento')">
              <label class="form-check-label" for="flexSwitchCheckDefault">Imprimir comanda</label>
            </div>
          </div>
          <div class="col-md-2"><br>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="permitir_descuento" name="permitir_descuento" onkeyup="saltar_creacion_producto(event,'informacion_tributaria')">
              <label class="form-check-label" for="flexSwitchCheckDefault">Descuento</label>
            </div>
          </div>

          <div class="hr-text hr-text-left">
            <p class="h4 text-green">Información de precio</p>
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
              <input type="text" class="form-control" id="valor_costo_producto" name="valor_costo_producto" onkeyup="saltar_creacion_producto(event,'valor_venta_producto')">
            </div>
            <span class="text-danger error-text valor_costo_producto_error"></span>
          </div>
          <div class="col-md-2">
            <label for="inputPassword4" class="form-label">Información tributaria</label>
            <select class="form-select" id="informacion_tributaria" name="informacion_tributaria" onchange="mostrar_informacion_tributaria()">
              <option value="1">Impuesto Nacional al Consumo (ICO)</option>
              <option value="2">Impuesto al Valor Agregado (IVA)</option>
            </select>
            <span class="text-danger error-text informacion_tributaria_error"></span>
          </div>

          <div class="col-md-1" style="display: none" id="informacion_triburaria_iva">
            <label for="inputPassword4" class="form-label">Valor IVA </label>
            <select class="form-select" id="valor_iv" name="valor_iva">
              <?php foreach ($iva as $detalle) { ?>
                <option value="<?php echo $detalle['idiva'] ?>"><?php echo $detalle['valoriva'] . "-" . $detalle['conceptoiva'] ?></option>
              <?php } ?>
            </select>
          </div>




          <div class="col-md-1" style="display: block" id="informacion_tributaria_ico">
            <label for="inputPassword4" class="form-label">Valor ICO</label>
            <select class="form-select" id="valor_ico" name="valor_ico">
              <?php foreach ($ico as $detalle) { ?>
                <option value="<?php echo $detalle['id_ico'] ?>"><?php echo $detalle['valor_ico'] ?></option>
              <?php } ?>
            </select>
          </div>



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
            <input type="text" class="form-control" id="valor_impuesto_saludable" name="valor_impuesto_saludable">
          </div> -->



          <div class="col-2">
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
              <input type="text" class="form-control" id="valor_venta_producto" name="valor_venta_producto" onkeyup="saltar_creacion_producto(event,'precio_2')">
            </div>
            <span class="text-danger error-text valor_venta_producto_error"></span>
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
              <input type="text" class="form-control" id="precio_2" name="precio_2" onkeyup="saltar_creacion_producto(event,'btn_crear_producto'),hablilitar_boton(event)" value=0>
            </div>
            <span class="text-danger error-text precio_2_error"></span>
          </div>

          <div class="col-8">
          </div>
          <div class="col-4">
            <button type="button" class="btn btn-success" id="btn_crear_producto" onclick="mandar()">Guardar </button>
            <button type="button" class="btn btn-danger" onclick="cancelar_creacion_producto()">Cancelar</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  function favorito() {
    var favorito = document.getElementById("favorito");
    var favoritoBtn = document.getElementById("favorito-btn");

    if (favorito.value == "false") {
      favorito.value = "true";
      favoritoBtn.classList.remove("btn-outline-warning");
      favoritoBtn.classList.add("btn-warning");
    } else {
      favorito.value = "false";
      favoritoBtn.classList.remove("btn-warning");
      favoritoBtn.classList.add("btn-outline-warning");
    }

    // Actualizar el texto de estado
    document.getElementById("status-value").textContent = favorito.value;
  }
</script>


<script>
  function sub_categorias_productos(id_categoria) {
    var url = document.getElementById("url").value;
    $.ajax({
      data: {
        id_categoria
      },
      url: url +
        "/" +
        "categoria/consulta_sub_categoria",
      type: "post",
      success: function(resultado) {
        var resultado = JSON.parse(resultado);
        if (resultado.resultado == 1) {

          if (resultado.sub_categoria == 't') {
            $("#div_sub_categoria").show();
            $("#requiere_categoria").val(1);
            $("#sub_categoria").html(resultado.datos);
          }

          if (resultado.sub_categoria == 'f') {
            $("#div_sub_categoria").hide();
            $("#requiere_categoria").val(0);
          }



        }
      },
    });
  }
</script>

<script>
  function cancelar_creacion_producto() {
    $("#crear_producto").modal("hide");
    $(".crear_producto_nombre_error").html("");
    $(".categoria_producto_error").html("");
    $(".marca_producto_error").html("");
    $(".informacion_tributaria_error").html("");
    $(".valor_costo_producto_error").html("");
    $(".valor_venta_producto_error").html("");
    $('#categoria_producto').val(null).trigger('change');
    $('#marca_producto').val(null).trigger('change');

    $('#crear_producto_codigo_interno').val('');

    $('#crear_producto_codigo_de_barras').val('');
    $('#crear_producto_nombre').val('');
    $('#categoria_product').val('');
    $('#sub_categoria').val('');
    $('#marca_product').val('');
    $('#impresion_en_comanda').prop('checked', false);
    $('#permitir_descuento').prop('checked', false);
    $('#valor_costo_producto').val('');
    $('#valor_venta_producto').val('');
    $('#precio_2').val('0');
    $('#informacion_tributaria').val('1');
    $('#valor_iv').val('');
    $('#valor_ico').val('');
  }
</script>


<script>
  function mandar() {
    // Obtén el elemento <button> que deseas cambiar


    var requiere_sub_categoria = document.getElementById("requiere_categoria").value;


    if (requiere_sub_categoria == 1) {
      var sub_categoria = document.getElementById("sub_categoria").value;
      if (sub_categoria === "") {
        $('#error_sub_categoria').html('Debe seleccionar una subcategoria');
      }
      if (sub_categoria !== "") {
        var buttonElement = document.getElementById("btn_crear_producto");
        // Cambia el tipo del botón a "submit"
        buttonElement.type = "submit";
      }


    }

    if (requiere_sub_categoria == 0) {
      var buttonElement = document.getElementById("btn_crear_producto");
      // Cambia el tipo del botón a "submit"
      buttonElement.type = "submit";
    }


  }
</script>
<script>
  function mostrar_informacion_tributaria() {
    var informacion_tribuitaria = document.getElementById("informacion_tributaria").value;
    ico = document.getElementById('informacion_tributaria_ico');
    iva = document.getElementById('informacion_triburaria_iva');

    if (informacion_tribuitaria == 1) {

      ico.style.display = 'block';
      iva.style.display = 'none';
    }

    if (informacion_tribuitaria == 2) {
      ico.style.display = 'none';
      iva.style.display = 'block';
    }

  }
</script>

<script>
  const precio_2 = document.querySelector("#precio_2");

  function formatNumber(n) {
    // Elimina cualquier carácter que no sea un número
    n = n.replace(/\D/g, "");
    // Formatea el número
    return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
  }

  precio_2.addEventListener("input", (e) => {
    const element = e.target;
    const value = element.value;
    element.value = formatNumber(value);
  });
</script>
<script>
  const impuesto_saludable = document.querySelector("#valor_impuesto_saludable");

  function formatNumber(n) {
    // Elimina cualquier carácter que no sea un número
    n = n.replace(/\D/g, "");
    // Formatea el número
    return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
  }

  impuesto_saludable.addEventListener("input", (e) => {
    const element = e.target;
    const value = element.value;
    element.value = formatNumber(value);
  });
</script>