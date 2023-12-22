<?php $session = session(); ?>
<?php $user_session = session(); ?>
<?= $this->extend('template/template_boletas') ?>
<?= $this->section('title') ?>
HOME
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Agregar sub categoria
            </button>
        </div>

        <div class="col-lg-auto ms-lg-auto">
            <p class="text-primary h3">LISTA CATEGORIAS Y SUB CATEGORIAS </p>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
        </div>
    </div>
</div>


<div class="container">
    <br>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <td scope="col">Nombre</th>
                <td scope="col">Acción</th>

            </tr>
        </thead>
        <tbody>

            <?php foreach ($sub_categorias as $detalle) { ?>
                <tr>

                    <td><?php echo $detalle['nombre'] ?></td>
                    <td><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Editar
                        </button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Eliminar
                        </button>
                    </td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    Agregar sub categoria
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" action="<?= base_url('categoria/sub_categoria') ?>" method="POST" id="crear_categoria">
                    <div class="row">

                        <div class="col">
                            <label for="" class="form-label">Nombre sub categoria </label>
                            <input type="text" class="form-control" name="nombre_categoria" id="nombre_categoria" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Guardar</button>
                        <button type="button" class="btn btn-red" data-bs-dismiss="modal">Cancelar </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<script>
    function actualizar_sub_categoria(valor) {
        var url = document.getElementById("url").value;
        $.ajax({
            data: {
                valor,
            },
            url: url + "/" + "configuracion/actualizar_sub_categoria",
            type: "POST",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {

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
                        icon: 'success',
                        title: 'Cambio exitoso'
                    })

                }
            },
        });

    }
</script>

<?= $this->endSection('content') ?>