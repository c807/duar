<div class="container">
    
    <div class="panel panel-success">
          <div class="panel-heading">
                <h3 class="panel-title">Listado de Polizas No Clasificados: <?php  echo count($registros)?> </h3>
          </div>
          <div class="panel-body">

                <div card="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">

                         <?php if (isset($registros)) { ?>
                         <?php for ($x = 0; $x < count($registros); $x++) { ?>
                            <tr>
                                <?php if ( $x == 0) { #solo imprime los encabezados
                                    foreach ($registros[$x]  as $item => $field) { ?>
                                        <td><?php echo $item?></td>
                                    <?php } ?>

                                    </tr><tr>
                                    <?php }
                                    foreach ($registros[$x]  as $item => $field) {
                                        if ($item == "Id") { ?>
                                            <td>
                                                <a href="<?php echo base_url('index.php/subir_archivo/clasificar_productos?c807_file='), $field; ?>" >
                                                     <i class="glyphicon glyphicon-edit">Trabajar</i>
                                                </a>
                                        </td>
                                <?php } else { ?>
                                    <td><?php echo $field?></td>
                                <?php } } ?>


                            </tr>
                        <?php }
                        } // fin if
                        ?>
                    </table>
                </div>
            </div>
        </div>

            </div>

          </div>
    </div>
</div>