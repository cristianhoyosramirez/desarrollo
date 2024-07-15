<?= $this->extend('template/template_boletas') ?>
<?= $this->section('title') ?>
Configuración
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>
<p class="text-center h3 text-primary">Partir comanda</p><br>
<div class="card container">
    <input type="hidden" value="<?php echo base_url() ?>" id="url">


    <div class="card-body">

        <?php if ($comanda == 'false') : ?>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onclick="actualizar_comanda()" value="<?php echo $comanda ?>">
                <label class="form-check-label" for="flexSwitchCheckDefault">No</label>
            </div>
        <?php endif ?>
        <?php if ($comanda == 'true') : ?>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onclick="actualizar_comanda()" value="<?php echo $comanda ?>" checked>
                <label class="form-check-label" for="flexSwitchCheckDefault">Si</label>
            </div>
        <?php endif ?>
    </div>
</div>

<script>
    const switchInput = document.getElementById('flexSwitchCheckDefault');
    const label = document.querySelector('.form-check-label');

    switchInput.addEventListener('change', function() {
        if (this.checked) {
            label.textContent = 'Sí';
            this.value = true;
        } else {
            label.textContent = 'No';
            this.value = false;
        }
    });
</script>


<script>
    function actualizar_comanda() {

        const temp_valor = document.getElementById('flexSwitchCheckDefault').value;

        if (temp_valor == "false") {
            valor = "true"
        }

        if (temp_valor == "true") {
            valor = "false"
        }


        let url = document.getElementById("url").value;

        $.ajax({
            data: {
                valor
            },
            url: url + "/" + "configuracion/actualizar_comanda",
            type: "POST",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {
                    // Aquí puedes agregar lo que necesitas hacer si resultado.resultado es 1

                    sweet_alert_start('success', 'Configuración de propina actualizada   ');


                }
            },
        });

    }
</script>


<?= $this->endSection('content') ?>