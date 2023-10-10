<!-- CSS files -->
<link href="<?php echo base_url() ?>/public/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />

<div class="card-body">
    <div class="mb-3">

        <!--  <div class="col-auto">
                                        <span class="avatar avatar-md cursor-pointer" style="background-image: url(<?php echo base_url() ?>/public/dist/img/foto.png)"></span>
                                    </div> -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Numero identificación</label>
                    <input type="text" class="form-control" value="<?php echo $cliente[0]['numero_identificacion'] ?> ">

                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputEmail4" class="form-label">Nombre</label>
                    <input type="text" class="form-control" value="<?php echo $cliente[0]['nombres'] ?> ">

                </div>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Dirección casa </label>
                <input type="text" class="form-control" value="<?php echo $cliente[0]['direccion'] ?> ">

            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Dirección negocio </label>
                <input type="text" class="form-control" value="<?php echo $cliente[0]['direccion_negocio'] ?> ">
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputAddress" class="form-label">Telefóno </label>
                    <input type="text" class="form-control" value="<?php echo $cliente[0]['telefono'] ?> ">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputAddress" class="form-label">Telefóno negocio</label>
                    <input type="text" class="form-control" value="<?php echo $cliente[0]['telefono_negocio'] ?> ">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputAddress2" class="form-label">Email</label>
                    <input type="text" class="form-control" value="<?php echo $cliente[0]['email'] ?> ">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputCity" class="form-label">Referencia personal</label>
                    <input type="text" class="form-control" id="referencia" name="referencia">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputCity" class="form-label">Telefono referencia</label>
                    <input type="text" class="form-control" id="referencia_telefono" name="referencia_telefono" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="inputCity" class="form-label">Dirección referecia</label>
                    <input type="text" class="form-control" id="referencia_direccion" name="referencia_direccion" readonly>
                </div>
            </div>


            <div class="container-xl">

                <div class="row row-cols-6 g-3">

                    <div class="col-6 col-sm-3">
                        <label for=""> FOTO DNI</label>
                        <a data-fslightbox="gallery" href="<?php base_url() ?>images/dni/<?php echo $cliente[0]['imagen_dni'] ?> ">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?php base_url() ?>images/dni/<?php echo $cliente[0]['imagen_dni']?>)"></div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label for=""> FOTO CLIENTE</label>
                        <a data-fslightbox="gallery" href="<?php base_url() ?>images/clientes/<?php echo $cliente[0]['imagen_cliente'] ?> ">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?php base_url() ?>images/clientes/<?php echo $cliente[0]['imagen_cliente'] ?>)"></div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label for=""> FOTO CASA</label>
                        <a data-fslightbox="gallery" href="<?php base_url() ?>images/casa/<?php echo $cliente[0]['imagen_casa'] ?> ">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?php base_url() ?>images/casa/<?php echo $cliente[0]['imagen_casa'] ?>)"></div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label for=""> FOTO NEGOCIO</label>
                        <a data-fslightbox="gallery" href="<?php base_url() ?>images/negocio/<?php echo $cliente[0]['imagen_negocio'] ?> ">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?php base_url() ?>images/negocio/<?php echo $cliente[0]['imagen_negocio'] ?>)"></div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label for=""> FOTO SERVICIO</label>
                        <a data-fslightbox="gallery" href="<?php base_url() ?>images/servicio/<?php echo $cliente[0]['imagen_servicio'] ?> ">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?php base_url() ?>images/servicio/<?php echo $cliente[0]['imagen_servicio'] ?>)"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Libs JS -->
<script src="<?php echo base_url() ?>/public/dist/libs/fslightbox/index.js?1684106062" defer></script>