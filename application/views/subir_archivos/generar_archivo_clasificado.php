<style>

</style>
<div class="container">

    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Generar Archivo Clasificado</h3>
        </div>
        <div class="panel-body">
            <form enctype="multipart/form-data" class="retaceo" id="retaceo">
                <input type="hidden" name="pais_id" id="pais_id" value="<?php echo $_SESSION['pais_id']?>" readonly>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td><label for="c807_file" class="col-sm-2"></label>Numero de File</td>
                                <td><input type="text" name="c807_file" id="c807_file" class="form-control"
                                        required="required"></td>
                                <td><label for="doc_transporte" class="col-sm-2"></label>Documento de Transporte</td>
                                <td><input type="text" name="doc_transporte" id="doc_transporte" class="form-control"
                                        required="required"></td>
                            </tr>

                        </tbody>
                    </table>


                    <button type="button" class="boton" onclick="lista_retaceo()">Retaceo</button>
                    <button type="button" class="boton" onclick="cuadro_duca()">Crear PDF</button>
                    <button type="button" class="boton" onclick="lista_cambiar_origen()">Cambiar Origen</button>
                    <button type="button" class="boton hn" onclick="excel_intec()" >Archivo INTEC</button>

                </div>
                <?php echo form_close();?>
                <div id="no_clasificados">
                    <?php // $this->load->view('subir_archivos/no_clasificados')?>
                </div>



                <div class="panel panel-default" id="panel_lista" style="display: none">
                    <div class="panel-heading" id="titulo">
                        Cuadro de Retaceo
                    </div>
                    <div class="panel-body" id="contenido">

                        <table class="table" id="tabla">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Partida</th>
                                    <th>Nombre</th>
                                    <th class="text-right">Bultos</th>
                                    <th class="text-right">Peso Bruto</th>
                                    <th class="text-right">Peso Neto</th>
                                    <th class="text-right">Cuantia</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-center" id="p_origen">origen</th>
                                    <th>TLC</th>
                                    <th class="text-center" id="item_pa">Item</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoLista">

                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

<!--- modal para mostrar dettalles de partidas -->
<div class="modal" id="detalle" role="dialog" data-backdrop="static">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header hdmodal buttonclose">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="opcion" class="modal-title border-bottom pb-3 mb-4"><strong>Detalle Origen </strong>
                </h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default" id="panel_lista_adjuntos">
                    <div class="" id="titulo">
                    </div>
                    <div class="panel-body" id="contenido">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Partida</th>
                                    <th>Cuantia</th>
                                    <th>Total</th>
                                    <th>Origen</th>
                                    <th>TLC</th>
                                </tr>
                            </thead>
                            <tbody id="contenido_lista_origen">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--- modal para mostrar dettalles de partidas -->


<!--- modal para cambiar pais de origen -->
<div class="modal" id="EditarOrigen" role="dialog" data-backdrop="static">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header hdmodal buttonclose">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="opcion" class="modal-title border-bottom pb-3 mb-4"><strong>Cambiar Origen </strong>
                </h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default" id="panel_lista_adjuntos">
                    <div class="" id="titulo">
                    </div>
                    <div class="panel-body">
                        <input type="hidden" class="form-control input-sm" id="id">
                        <div class="form-group form-group-sm">
                            <div class="col-md-2 text-left">
                                <label for="origen" class="control-label">Origen</label>
                            </div>
                            <div class="col-md-12">
                                <?php $this->load->view('paises'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardar_origen()">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!---fin  modal para cambiar pais de origen -->

<script>
$(document).ready(function() {
    $(".chosen").chosen({
        width: "100%"
    });
});
</script>

<script>
mostrar_origen()
ocultar_elementos_dpr();
</script>