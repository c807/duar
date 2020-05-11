<?php
if (isset($_SESSION["no_clasificado"])) {?>
   	<div class="alert alert-success">
        <?php echo $_SESSION["no_clasificado"] ?>
    </div>
<?php } ?>

<div class="card">
    <?php if (isset($registros)) { ?>
        <div class="card-header text-center btn-success">
            <div id="card-title">Producto a Clasificar: <?php echo count($registros)?> </div>
        </div>
        <br>
    <?php } ?>
    <div card="card-body ">
        <div class="table-responsive">
            <table class="table table-hover table-condensed">
                <?php if (isset($registros)) { 
                    if (count($registros) == 0) { ?>     
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-primary" onclick="enviar_correo(2)">Enviar Correo Aforador</button>
                        </div>
                    <?php }?>    
                    <?php for ($x = 0; $x < count($registros); $x++) { ?>
                        <tr>
                            <?php if ( $x == 0) { #solo imprime los encabezados
                                foreach ($registros[$x]  as $item => $field) {
                                    ?>
                                    <td><?php echo $item?></td>
                                <?php } ?>

                                </tr><tr>
                                 <?php }
                                foreach ($registros[$x]  as $item => $field) {
                                    if ($item == "id") { ?>
                                        <td>
                                            <a href="javascript:;"  onclick="mostrar_partida(<?php echo $field?> , '<?php echo $num_file ?>')">
                                                 <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            <div id="crear_partida">

                                                <?php
                                                    $this->data = array(
                                                        'id_reg' => $field);
                                                    $this->datos['id'] = $this->data;
                                                   
                                                    $this->load->view("subir_archivos/crear_partida",$this->datos )
                                                 ?>
                                            </div>
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

<script>
if ($('tlc').is(':checked')) {
    alert('fine');
}
</script>