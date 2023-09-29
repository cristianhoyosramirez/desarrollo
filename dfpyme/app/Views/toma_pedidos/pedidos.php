<?php $user_session = session(); ?>
<?= $this->extend('pedidos/template_mesa') ?>
<?= $this->section('title') ?>
Bienvenido DFpyme
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>

<div class="page">
    <!-- Navbar -->
    <div id="header">
        <?= $this->include('layout/header_mesas') ?>
    </div>
    <div id="header_oculto" class="container" style="display:none">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">

                    <li class="list-inline-item">
                        <a class=" cursor-pointer" onclick="mostrar_menu()" title="Mostar menu" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="3" y1="3" x2="21" y2="21" />
                                <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                                <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                            </svg></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <!-- Page body -->
        <div class="div"></div>
        <input type="hidden" value="<?php echo base_url() ?>" id="url">
        <input type="hidden" value="<?php echo $user_session->id_usuario ?>" id="id_usuario">
        <input type="hidden" value="<?php echo $requiere_mesero ?>" id="requiere_mesero" name="requiere_mesero">
        <input type="hidden" value="<?php echo $user_session->tipo ?>" id="tipo_usuario" name="tipo_usuario">
        <div class="container-fluid">
            <div class="row row-deck row-cards">
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <ul class="nav nav-tabs" data-bs-toggle="tabs">

                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="todas_las_mesas()"><!-- Download SVG icon from http://tabler-icons.io/i/arrows-maximize -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <polyline points="16 4 20 4 20 8" />
                                        <line x1="14" y1="10" x2="20" y2="4" />
                                        <polyline points="8 20 4 20 4 16" />
                                        <line x1="4" y1="20" x2="10" y2="14" />
                                        <polyline points="16 20 20 20 20 16" />
                                        <line x1="14" y1="14" x2="20" y2="20" />
                                        <polyline points="8 4 4 4 4 8" />
                                        <line x1="4" y1="4" x2="10" y2="10" />
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link " data-bs-toggle="tab" onclick="get_mesas()">TODAS</a>
                            </li>
                            <?php foreach ($salones as $detalle) : ?>

                                <li class="nav-item">
                                    <a href="#tabs-home-7" class="nav-link" data-bs-toggle="tab" onclick="mesas_salon(<?php echo $detalle['id'] ?>)"><?php echo $detalle['nombre'] ?> </a>
                                </li>

                            <?php endforeach ?>
                            <li class="nav-item ms-auto">
                                <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab"><!-- Download SVG icon from http://tabler-icons.io/i/settings -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show">


                                    <div style="display: block" id="todas_las_mesas">
                                        <div id="lista_completa_mesas">
                                            <?= $this->include('pedidos/todas_las_mesas_lista') ?>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <div id="lista_categorias" style="display: none">
                                            <ul class="horizontal-list">
                                                <?php foreach ($categorias as $detalle) : ?>

                                                    <li><button type="button" class="btn btn-outline-indigo btn-pill btn-sm" id="categoria_<?php echo $detalle['codigocategoria'] ?>" onclick="productos_categoria(<?php echo $detalle['codigocategoria'] ?>)"><?php echo $detalle['nombrecategoria'] ?></button></li>

                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $alturaCalc = "37rem + 10px"; // Calcula la altura 
                ?>

                <!--Productos-->
                <div class="col-md-3" id="pedido" style="display: block">
                    <div class="card" style="height: calc(<?php echo $alturaCalc; ?>)">
                        <div class="card-header border-0" style="margin-bottom: -10px; padding-bottom: 0;">
                            <div class="card-title">
                                <div class="mb-3">
                                    <div class="input-group input-group-flat">
                                        <input type="text" readonly class="form-control " autocomplete="off" placeholder="Buscar por nombre o código" id="producto">
                                        <span class="input-group-text">
                                            <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="limpiarCampo()"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <span id="error_producto" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                            <div id="productos_categoria"></div>
                            <p id="bogota"></p>

                        </div>
                    </div>
                </div>

                <!--Pedido-->
                <div class="col-md-6" id="productos" style="display: block">
                    <input type="hidden" id="id_mesa_pedido">
                    <div class="card" style="height: calc(<?php echo $alturaCalc; ?>)">
                        <div class="card-header border-1" style="margin-bottom: -10px; padding-bottom: 0;">
                            <div class="card-title">
                                <div class="row align-items-start">
                                    <table>
                                        <tr>
                                            <td tyle="width: 25%;">
                                                <p id="mesa_pedido" class="text-warning "> Mesa:</p>
                                            </td>
                                            <td yle="width: 25%;">
                                                <p id="pedido_mesa">Pedio: </p>
                                            </td>
                                            <td tyle="width: 50%;">
                                                <p id="nombre_mesero" class="cursor-pointer text-primary"   data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom">Mesero </p>

                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow">

                            <div id="mesa_productos"></div>

                        </div>

                        <div class="container">
                            <div class="row mb-2"> <!-- Fila para los botones -->
                                <div class="col-md-4">
                                    <a href="#" class="btn btn-outline-indigo w-100" onclick="cambiar_mesas()">
                                        Cambio de mesa
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="#" class="btn btn-outline-purple w-100" onclick="imprimir_comanda()">
                                        Comanda
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="#" class="btn btn-outline-red w-100" onclick="alerta()">
                                        Eliminar pedido
                                    </a>
                                </div>
                            </div>
                            <div class="row"> <!-- Fila para el textarea -->
                                <div class="col-md-12 mb-2">
                                    <textarea class="form-control" rows="1" id="nota_pedido" onkeyup="insertarDatos(this.value)" placeholder="Nota general del pedido "></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--valor Pedido-->
                <div class="col-md-3">

                    <div class="card" style="height: calc(20rem + 10px)">
                        <div class="card-header border-1" style="margin-bottom: -10px; padding-bottom: 0;">
                            <div class="card-title">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <p id="pedido_mesa">Valor pedido </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">

                            <form>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Subtotal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="subtotal_pedido" disabled="">
                                    </div>
                                </div>

                                <div class="row mb-2 gy-2">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <!-- 
                                            <select class="form-select" aria-label="Default select example" id="criterio_propina" style="width: 90px;">
                                                <option value="1">Propina %</option>
                                                <option value="2">Propina $</option>

                                            </select> -->



                                            <a href="#" class="btn btn-outline-green  col-sm-4" onclick="calculo_propina()" title="Propina" style="width: 100px;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom"> <!-- Download SVG icon from http://tabler-icons.io/i/mood-happy -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <circle cx="12" cy="12" r="9" />
                                                    <line x1="9" y1="9" x2="9.01" y2="9" />
                                                    <line x1="15" y1="9" x2="15.01" y2="9" />
                                                    <path d="M8 13a4 4 0 1 0 8 0m0 0h-8" />
                                                </svg></a>


                                            <input type="text" aria-label="Last name" class="form-control w-1" style="width: 50px;" value=0 onkeyup="calcular_propina(this.value)" id="propina_pesos" placeholder="%">
                                            <input type="text" aria-label="Last name" class="form-control" style="width: 50px;" id="propina_del_pedido" name="propina_del_pedido" onkeyup="total_pedido(this.value)" value=0 placeholder="$">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label  h2">Total</label>
                                    <div class="col-sm-8">
                                        <a href="#" class="btn btn-outline-azure w-100 h2" id="valor_pedido" onclick="alerta()" title="Pagar" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                            $ 0
                                        </a>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="container">
                            <div class="row mb-2 gy-2"> <!-- Fila para los botones -->
                                <div class="col-md-6">


                                    <a href="#" class="btn btn-outline-cyan w-100" onclick="prefactura()">
                                        Prefactura
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-outline-muted w-100" onclick="alerta()">
                                        Rerirar dinero</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-yellow w-100"  onclick="alerta()">
                                        Devolución
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-outline-azure w-100" onclick="alerta()">
                                        Pago parcial
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--partida-->
            </div>
        </div>
    </div>
</div>




<script>
    function alerta() {

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'warning',
            title: '!Acción requiere permisos!'
        })

    }
</script>

<?= $this->endSection('content') ?>