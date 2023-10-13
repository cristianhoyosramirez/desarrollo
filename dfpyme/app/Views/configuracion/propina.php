<?= $this->extend('template/template_boletas') ?>
<?= $this->section('title') ?>
Configuración
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>

<div class="card container">
    <div class="card-body">
        <form action="<?= base_url('configuracion/configuracion_propina') ?>" method="POST">
            <input type="hidden" value="<?php echo base_url() ?>" id="url">
            <div class="row">
                <div class="col-md-4">
                    <label for="inputState" class="form-label">Tipo propina </label>
                    <select id="inputState" class="form-select" name="propina" id="propina">
                        <option value="0">Sin redondeo </option>
                        <option value="1">Con redondeo </option>
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="row text-end">
                        <div class="col-6">
                        </div>
                        <div class="col-3">
                            <a href="#" class="btn btn-outline-red active w-100">
                                Cancelar
                            </a>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-outline-green active w-100">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function actualizar_mesero(valor) {
        var url = document.getElementById("url").value;
        $.ajax({
            data: {
                valor,
            },
            url: url + "/" + "configuracion/actualizar_mesero",
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