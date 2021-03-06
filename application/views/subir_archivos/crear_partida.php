<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

    </style>
</head>

<body>

    <!-- <?php echo $id['id_reg']?> -->
    <div class="container" id="actualizar_partida<?php echo $id['id_reg']?>" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center btn-success">
                        <div id="card-title">Crear Partida Arancelaria</div>
                    </div>
                    <br>
                    <div class="card-body w-100">
                        <form id="partida<?php echo $id['id_reg']?>">
                        <input type="hidden" name="pais_id"  id="pais_id" value="<?php echo $_SESSION['pais_id']?>" readonly >

                            <div class="table">
                                <table class="table table-hover">
                                    <tr>
                                        <td><label for="proveedor<?php echo $id['id_reg']?>">Proveedor</label></td>
                                        <td colspan="2"><input type="text" name="proveedor<?php echo $id['id_reg']?>"
                                                id="proveedor<?php echo $id['id_reg']?>" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="importador<?php echo $id['id_reg']?>">Nit Importador</label>
                                        </td>
                                        <td colspan="2"><input type="text" name="importador<?php echo $id['id_reg']?>"
                                                id="importador<?php echo $id['id_reg']?>" readonly class="form-control">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label for="codigo_producto<?php echo $id['id_reg']?>">Codigo
                                                Producto</label>
                                        </td>
                                        <td colspan="2"><input type="text"
                                                name="codigo_producto<?php echo $id['id_reg']?>"
                                                id="codigo_producto<?php echo $id['id_reg']?>" readonly
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="nombre<?php echo $id['id_reg']?>">Descripcion</label></td>
                                        <td colspan="2"><input type="text" name="descripcion<?php echo $id['id_reg']?>"
                                                id="descripcion<?php echo $id['id_reg']?>" readonly
                                                class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="partida_arancelaria<?php echo $id['id_reg']?>">Partida
                                                Arancelaria</label>
                                        </td>
                                        
                                        <td><input type="text" name="partida_arancelaria<?php echo $id['id_reg']?>"
                                                id="partida_arancelaria<?php echo $id['id_reg']?>" class="form-control"
                                                maxlength="16"></td>


                                        <!-- <td><label for="codigo_extendido<?php echo $id['id_reg']?>">Código
                                                Extendido</label>
                                        </td>
                                        <td><input type="text" name="codigo_extendido<?php echo $id['id_reg']?>"
                                                id="codigo_extendido<?php //echo $id['id_reg']?>" class="form-control"
                                                maxlength="3">
                                        </td>
                                       -->
                                    </tr>
                                    <tr>
                                        <td><label for="descripcion_generica<?php echo $id['id_reg']?>">Descripcion
                                                Generica</label>
                                        </td>
                                        <td colspan="4"><input type="text"
                                                name="descripcion_generica<?php echo $id['id_reg']?>"
                                                id="descripcion_generica<?php echo $id['id_reg']?>" class="form-control"
                                                maxlength="100">
                                        </td>
                                    </tr>

                                    <tr>

                                        <td> <label for="funcion">Función</label> </td>
                                        <td colspan="4"> <textarea class="form-control" rows="3" id="funcion"
                                                name="funcion" placeholder="Introduzca función" required></textarea>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td> <label for="observaciones">Observaciones</label> </td>

                                        <td colspan="6">
                                            <textarea class="form-control" rows="3" id="observaciones"
                                                name="observaciones" placeholder="Introduzca Observación"
                                                required></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td> <label for="marca">Marca</label> </td>
                                        <td colspan="4"><input type="text" name="marca<?php echo $id['id_reg']?>"
                                                id="marca<?php echo $id['id_reg']?>" class="form-control"
                                                maxlength="100">
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><label for="paises">Origen</label></td>
                                        <td style="width:100%">
                                            <?php $this->load->view('paises'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="pais_origen<?php echo $id['id_reg']?>">Pais Origen</label></td>
                                        <td colspan="4"><input type="text" name="pais_origen<?php echo $id['id_reg']?>"
                                                id="pais_origen<?php echo $id['id_reg']?>" class="form-control"
                                                readonly>
                                        </td>
                                    </tr>

                                    <tr class="hn">
                                        
                                        <td><label for="estados">Estado</label></td>
                                        <td style="width:100%">
                                            <?php $this->load->view('catalogos/estados'); ?>
                                        </td>
                                    </tr>

                                    <tr class="hn">
                                        <td><label for="u_comercial">Unidad Comercial</label></td>
                                        <td style="width:100%">
                                            <?php $this->load->view('catalogos/unidad_comercial'); ?>
                                        </td>
                                    </tr>

                                    <tr class="hn">
                                        <td><label for="pais_procedencia">Pais Procedencia</label></td>
                                        <td style="width:100%">
                                            <?php $this->load->view('catalogos/procedencia'); ?>
                                        </td>
                                    </tr>

                                    <tr class="hn">
                                        <td><label for="pais_adquisicion">Pais Adquisición</label></td>
                                        <td style="width:100%">
                                            <?php $this->load->view('catalogos/adquisicion'); ?>
                                        </td>
                                    </tr>

                                </table>

                                <div class="container"  style="margin-top:0px; padding-top:0px">

                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permiso"
                                                        id="permiso">PERMISO</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="tlc" id="tlc">TLC</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 hn">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="fito" id="fito">Fito</label>
                                            </div>

                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>

                                </div>

                                <button type="button" class="btn btn-success"
                                    onclick="crear_partida(<?php echo $id['id_reg']?>)"><span
                                        class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
                                <button type="button" class="btn btn-success"
                                    onclick="cerrar(<?php echo $id['id_reg']?>)" id="cerrar2"><span
                                        class="glyphicon glyphicon-folder-close"></span> Cerrar</button>


                                <input type="hidden" name="id_reg<?php echo $id['id_reg']?>"
                                    id="id_reg<?php echo $id['id_reg']?>" readonly class="form-control">

                                <input type="hidden" name="imp<?php echo $id['id_reg']?>"
                                    id="imp<?php echo $id['id_reg']?>">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>

</body>

</html>

<script>
/*
    var verifica_tlc = function () {
    if ($("#tlc").is(":checked")) {
        $('#preferencia').prop('disabled', false);
        $('#preferencia').prop('disabled', false).trigger("chosen:updated");
    }
    else {
        $('#preferencia').prop('disabled', 'disabled');
        $('#preferencia').prop('disabled', true).trigger("chosen:updated");
    }
};

$(verifica_tlc);
$("#tlc").change(verifica_tlc);
*/
</script>

<script>
$(document).ready(function() {
    $(".chosen").chosen({
        width: "100%"
    });
});

</script>