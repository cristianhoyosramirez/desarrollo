<!-- Page header -->

<br>

<div id="listado_clientes">

    <?php if (!empty($clientes)) { ?>
        <?php foreach ($clientes as $detalle) { ?>

            <?php if (empty($detalle['imagen_cliente'])) : ?>
                <div class="card">
                    <div class="row g-0 cursor-pointer" onclick="detalle_cliente(<?php echo  $detalle['id'] ?>)">
                        <div class="col-auto">
                            <div class="card-body">
                                <div class="avatar avatar-md" style="background-image: url(<?php echo base_url() ?>/public/dist/img/hombre.png )"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card-body ps-0">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-0"><?php echo $detalle['nombres'] ?></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mt-3 list-inline list-inline-dots mb-0 text-muted d-sm-block ">
                                            <div class=""><!-- Download SVG icon from http://tabler-icons.io/i/building-community -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                                    <path d="M9 4v13"></path>
                                                    <path d="M15 7v5.5"></path>
                                                    <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                                                    <path d="M19 18v.01"></path>
                                                </svg>
                                                <?php echo $detalle['direccion'] ?>
                                            </div>
                                            <div class="list-inline-item"><!-- Download SVG icon from http://tabler-icons.io/i/license -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                                </svg>
                                                <?php echo $detalle['telefono'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php if (!empty($detalle['imagen_cliente'])) : ?>
                <div class="card">
                    <div class="row g-0 cursor-pointer" onclick="detalle_cliente(<?php echo  $detalle['id'] ?>)">
                        <div class="col-auto">
                            <div class="card-body">
                                <div class="avatar avatar-md" style="background-image: url(<?php echo base_url() ?>/images/clientes/<?php echo $detalle['imagen_cliente'] ?> )"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card-body ps-0">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-0"><?php echo $detalle['nombres'] ?></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mt-3 list-inline list-inline-dots mb-0 text-muted d-sm-block ">
                                            <div class=""><!-- Download SVG icon from http://tabler-icons.io/i/building-community -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                                    <path d="M9 4v13"></path>
                                                    <path d="M15 7v5.5"></path>
                                                    <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                                                    <path d="M19 18v.01"></path>
                                                </svg>
                                                <?php echo $detalle['direccion'] ?>
                                            </div>
                                            <div class="list-inline-item"><!-- Download SVG icon from http://tabler-icons.io/i/license -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                                </svg>
                                                <?php echo $detalle['telefono'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <br>
        <?php } ?>
    <?php } ?>

    <?php if (empty($clientes)) { ?>
        <div class="container">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No hay clientes creados. </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php } ?>
</div>

<?php $user_session = session(); ?>


<!-- Modal -->
<div class="modal fade" id="modal_fotos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_cliente" name="id_cliente">
                <div id="fotos">
                    <div class="row ">
                        <div class="col">
                            <video id="theVideo" autoplay muted></video>
                        </div>

                        <div id="contenedorFoto">
                            <img id="fotoCapturada" src="">
                        </div>
                        <div class="col">
                            <canvas id="theCanvas" style="display:none;"></canvas>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-3"></div>
                        <div class="col-2  text-center">
                            <button type="button" class="btn btn-primary btn-icon" onclick="capturarFoto()">

                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="13" r="3" />
                                    <path d="M5 7h2a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h2m9 7v7a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                    <line x1="15" y1="6" x2="21" y2="6" />
                                    <line x1="18" y1="3" x2="18" y2="9" />
                                </svg></button>
                        </div>
                        <div class="col-2  text-center">
                            <button id="btnOpenCamera" type="button" class="btn bg-muted-lt btn-icon ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                    <path d="M11.245 15.904a3 3 0 0 0 3.755 -2.904m-2.25 -2.905a3 3 0 0 0 -3.75 2.905" />
                                    <path d="M14 13h2v2" />
                                    <path d="M10 13h-2v-2" />
                                </svg></button>
                        </div>
                        <div class="col-2  text-center">
                            <button id="btnFotosCliente" type="button" class="btn btn-success btn-icon " disabled>
                                <!-- Download SVG icon from http://tabler-icons.io/i/device-floppy -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                    <circle cx="12" cy="14" r="2" />
                                    <polyline points="14 4 14 8 8 8 8 4" />
                                </svg></button>
                        </div>

                    </div>
                </div>
                <div class="mb-3"></div>
                <div id="fotos_cliente">

                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="card" id="frmCrearCliente" action="<?php base_url() ?>clientes/crear_cliente" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $user_session->id_usuario; ?>">

                    <div class="card-body">
                        <div class="mb-3">

                            <!--  <div class="col-auto">
                                        <span class="avatar avatar-md cursor-pointer" style="background-image: url(<?php echo base_url() ?>/public/dist/img/foto.png)"></span>
                                    </div> -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Numero identificación</label>
                                        <input type="text" class="form-control" id="identificacion" name="identificacion">
                                        <span class="text-danger error-text identificacion_error"></span>
                                        <span class="text-danger" id="cliente_creado"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputEmail4" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre">
                                        <span class="text-danger error-text nombre_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword4" class="form-label">Dirección casa </label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                        <button class="btn" type="button" onclick="getLocation()"><!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <circle cx="12" cy="11" r="3" />
                                                <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                            </svg></button>

                                    </div>
                                    <span class="text-danger error-text direccion_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword4" class="form-label">Dirección negocio </label>
                                    <input type="text" class="form-control" id="direccion_negocio" name="direccion_negocio">
                                    <span class="text-danger error-text direccion_negocio_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputAddress" class="form-label">Telefóno </label>
                                        <input type="text" class="form-control" id="telefono" name="telefono">
                                        <span class="text-danger error-text telefono_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputAddress" class="form-label">Telefóno negocio</label>
                                        <input type="text" class="form-control" id="telefono_negocio" name="telefono_negocio">
                                        <span class="text-danger error-text telefono_negocio_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputAddress2" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                        <span class="text-danger error-text email_error"></span>
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
                                        <input type="text" class="form-control" id="referencia_telefono" name="referencia_telefono">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputCity" class="form-label">Dirección referecia</label>
                                        <input type="text" class="form-control" id="referencia_direccion" name="referencia_direccion">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-green" id="btnCrearCliente">Guardar</button>
                            <button type="button" class="btn btn-red" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>public/js/clientes/crear_cliente.js"></script><!-- Abre un modal en el home para la creacion de un nuevo cliente  -->
    <script src="<?= base_url() ?>public/js/clientes/buscar_cliente.js"></script><!-- Abre un modal en el home para la creacion de un nuevo cliente  -->
    <!-- Libs JS -->

    <script>
        function getLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    convertir_coordenadas(latitude, longitude)
                });
            } else {
                document.getElementById("demo").innerHTML = "La geolocalización no está disponible en tu navegador.";
            }
        }
    </script>


    <script>
        const videoWidth = 230;
        const videoHeight = 230;
        const videoTag = document.getElementById("theVideo");
        let cameraActive = true; // Variable para rastrear el estado de la cámara

        // Obtener el elemento del botón
        const toggleCameraBtn = document.getElementById("btnOpenCamera");

        // Función para cambiar entre las cámaras
        function toggleCamera() {
            const constraints = {
                audio: false,
                video: {
                    width: videoWidth,
                    height: videoHeight,
                    facingMode: (cameraActive) ? "user" : {
                        exact: "environment"
                    }
                }
            };

            // Detener la transmisión de video actual (si existe)
            if (videoTag.srcObject) {
                const stream = videoTag.srcObject;
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            }

            // Acceder a la cámara seleccionada
            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                    videoTag.srcObject = stream;
                    cameraActive = !cameraActive;
                })
                .catch(function(error) {
                    console.error("Error al cambiar la cámara:", error);
                });
        }

        // Manejar el evento de clic en el botón
        toggleCameraBtn.addEventListener("click", toggleCamera);

        // Iniciar la cámara trasera por defecto al cargar la página
        toggleCamera();
    </script>


    <script>
        function capturarFoto() {
            // Obtener el elemento de video


            const btnFotosCliente = document.getElementById("btnFotosCliente");
            btnFotosCliente.disabled = false;


            const video = document.getElementById("theVideo");

            // Obtener el elemento de imagen donde se mostrará la foto capturada
            const fotoCapturada = document.getElementById("fotoCapturada");

            // Asegurarse de que el video esté reproduciéndose
            if (video.paused) {
                alert("La cámara no está activa. Haz clic en 'Iniciar Cámara' antes de capturar una foto.");
                return;
            }

            // Obtener el contexto del canvas
            const canvas = document.getElementById("theCanvas");
            const context = canvas.getContext("2d");

            // Definir el ancho y alto del canvas
            canvas.width = 800; // Ancho deseado
            canvas.height = 800; // Alto deseado

            // Capturar la foto en el canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Obtener la imagen en formato base64 desde el canvas
            const fotoBase64 = canvas.toDataURL("image/jpeg");

            // Asignar la imagen al elemento de imagen
            fotoCapturada.src = fotoBase64;

            // Opcional: Puedes enviar la foto capturada al servidor aquí si es necesario
        }
    </script>