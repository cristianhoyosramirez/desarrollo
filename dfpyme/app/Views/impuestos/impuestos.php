<?php if (!empty($iva)) : ?>
    <?php foreach ($iva as $valor) : ?>
        <div class="row">
            <div class="col-9"></div>
            <div class="col-3">
                <div class="card ">

                    <div class="card-body">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <td></td>
                                    <td colspan="2">IVA 19</td>
                                    <!-- colspan aplicado correctamente a la celda -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">Base</td>
                                    <!-- colspan aplicado correctamente a la celda -->
                                    <td>IVA</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?php if (!empty($inc)) : ?>
    <?php foreach ($inc as $valor) : ?>
        <div class="row">
            <div class="col-6"></div>
            <div class="col-3">
                <div class="card ">

                    <div class="card-body">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <td></td>
                                    <td colspan="3">INC <?php echo $valor['inc'] ?> % </td>
                                    <!-- colspan aplicado correctamente a la celda -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php
                                 $total_venta_inc = model('kardexModel')->total_venta_inc($apertura,$valor['inc']);
                                 $venta_inc = model('kardexModel')->venta_inc($apertura);
                                  ?>
                                    <td colspan="2">Base   <?php   echo number_format($total_venta_inc[0]['total'] - $venta_inc[0]['inc'], 0, ",", ".")  ?></td>
                                    <!-- colspan aplicado correctamente a la celda -->
                                    <td>INC <?php   echo number_format($venta_inc[0]['inc'], 0, ",", ".")  ?> </td>
                                    <td>TOTAL <?php   echo number_format($total_venta_inc[0]['total'], 0, ",", ".")  ?> </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-3">

            <div class="card ">

                    <div class="card-body">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <td></td>
                                    <td colspan="3">VENTA TOTAL  </td>
                                    <!-- colspan aplicado correctamente a la celda -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php
                                 $total_venta = model('pagosModel')->selectSum('valor')->where('id_apertura',$apertura)->findAll();
                                 
                                  ?>
                                    <td >  </td>
                                    <td colspan="2 " class="text-center">  <?php   echo "</br>". number_format($total_venta[0]['valor'] , 0, ",", ".")  ?></td>
                                   
                                    
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>