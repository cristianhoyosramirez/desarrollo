<?php $session = session(); ?>
<?php $user_session = session(); ?>
<?= $this->extend('template/home') ?>
<?= $this->section('title') ?>
DFpyme
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mesas" class="table  table-hover">
                        <thead class="table-dark">
                            <tr>
                                <td>Id</td>
                                <td>Documento</td>
                                <td>Estado</td>
                                <td>Orden</td>
                                <td class="text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tipo_factura as $detalle) { ?>
                                <tr>
                                    <td><?php echo $detalle['idestado'] ?></td>
                                    <td><input type="text" value="<?php echo $detalle['descripcionestado'] ?>" class="form-control"></td>
                                    <td><select class="form-select" name="estado">
                                           
                                            <option value="1">Habilitado</option>
                                            <option value="2">No habilitado</option>
                                        </select></td>
                                    <td><input type="text" value="<?php echo $detalle['orden'] ?>" class="form-control"></td>
                                    <td class="text-end">


                                        <input type="hidden" value="<?php #echo $detalle['id'] 
                                                                    ?>" name="id">
                                        <button type="submit" class="btn btn-outline-success">Actualizar</button>
                                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>


                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>