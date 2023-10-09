<!-- Modal -->
<div class="modal fade" id="crear_cliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
          Crear cliente
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
          <div class="col-md-3">
            <label for="inputEmail4" class="form-label">Tipo de persona</label>
            <select class="form-select" id="tipo_persona" name="tipo_personal">
              <option value="1">Natural </option>
              <option value="1">Juridica</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputPassword4" class="form-label">
              tipo de documento
            </label>
            <?php $identificacion = model('TiposDocumento')->findALL(); ?>
            <select class="form-select" aria-label="Default select example" id="tipo_documento" name="tipo_documento">
              <?php foreach ($identificacion as $detalle) : ?>

                <option value="<?php $detalle['codigo'] ?>"><?php echo $detalle['descripcion'] ?></option>

              <?php endforeach  ?>
            </select>
          </div>
          <div class="col-3">
            <label for="inputAddress" class="form-label">Numero de identificación </label>
            <input type="text" class="form-control" id="inputAddress">
          </div>
          <div class="col-3">
            <label for="inputAddress2" class="form-label">Dv</label>
            <input type="text" class="form-control" id="inputAddress2">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Régimen</label>
            <?php $regimen = model('regimenModel')->findALL(); ?>
            <select class="form-select" aria-label="Default select example" id="regimen" name="regimen">
              <?php foreach ($regimen as $detalle) : ?>

                <option value="<?php $detalle['idregimen'] ?>"><?php echo $detalle['nombreregimen'] ?></option>

              <?php endforeach  ?>
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Tipo de ventas </label>

            <?php $tipo_cliente = model('tipoClienteModel')->findALL(); ?>
            <select class="form-select" aria-label="Default select example" name="tipo_ventas" id="tipo_ventas">
              <?php foreach ($tipo_cliente as $detalle) : ?>

                <option value="<?php $detalle['id'] ?>"><?php echo $detalle['descripcion'] ?></option>

              <?php endforeach  ?>
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Clasificación comercial
            </label>

            <?php $clasificacion_cliente = model('clasificacionClienteModel')->findALL(); ?>
            <select class="form-select" aria-label="Default select example">
              <?php foreach ($clasificacion_cliente as $detalle) : ?>

                <option value="<?php $detalle['id'] ?>"><?php echo $detalle['descripcion'] ?></option>

              <?php endforeach  ?>
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Nombres
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Apellidos
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Razon social
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Nombre comercial
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Dirección
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Departamento
            </label>
            <?php $departamento = model('departamentoModel')->where('idpais', 49)->findAll(); ?>
            <select class="form-select"  name="departamento" id="departamento">
              <?php foreach ($departamento as $detalle) : ?>

                <option value="<?php $detalle['iddepartamento'] ?>"><?php echo $detalle['nombredepartamento'] . "-" . $detalle['code'] ?></option>

              <?php endforeach  ?>
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Ciudad
            </label>
           

            <select class="form-select" name="ciudad" id="ciudad">
              
           
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Codigo postal
            </label>
            <?php $postal = model('CodigoPostalModel')->findAll();  ?>

            <select class="form-select" aria-label="Default select example" id="codigo_postal" name="codigo_postal">
              <?php foreach ($postal as $detalle) : ?>

                <option value="<?php $detalle['id'] ?>"> <?php echo $detalle['departamento'] . "-" . $detalle['ciudad'] . "-" . $detalle['c_postal'] ?> </option>

              <?php endforeach  ?>
            </select>
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Correo electrónico
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Telefono /celular
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">Detalles tributarios del cliente
              <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-3">
            <label for="inputCity" class="form-label">valores de la casilla 53 o 54 de RUT
            </label>
            <input type="text" class="form-control" id="inputCity">
          </div>



        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Crear </button>
        <button type="button" class="btn btn-danger">Cancelar</button>
      </div>
    </div>
  </div>
</div>