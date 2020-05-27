

<div class="card">
    <?php if (isset($registros)) { ?>
        <div class="card-header text-center btn-success">
            <?php if (isset($mensaje) && strlen($mensaje) >0 ) { ?>
                <div id="card-title"> <?php echo $mensaje;  echo count($registros)?> </div> 
             <?php } ?>    
        </div>
        <br>
    <?php } ?>
    <div card="card-body">
        <div class="table-responsive">
            <table class="table table-hover">

                <?php if (isset($registros)) { ?>
                    <?php for ($x = 0; $x < count($registros); $x++) { ?>
                        <tr>
                            <?php if ( $x == 0) { #solo imprime los encabezados
                                foreach ($registros[$x]  as $item => $field) { ?>
                                    <td><?php echo strtoupper($item)?></td>
                                <?php } ?>

                                </tr><tr>
                                 <?php }
                                foreach ($registros[$x]  as $item => $field) {
                                    { ?>
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

