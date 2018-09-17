
        <div class="container">
            <div class="panel panel-success">
                <div class="panel-heading">
                        <h3 class="panel-title">Clasificar Productos</h3>
                </div>
                <div class="panel-body">


                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td><label for="c807_file" class="col-sm-2"></label>Numero de File</td>
                                     <td>
                                         <input type="text" name="c807_file" id="c807_file" class="form-control" value="" required="true">
                                     </td>
                                     <td>
                                     <button type="submit" class="btn btn-primary" onclick="no_clasificadas()">Buscar</button>
                                     </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="container well well-sm" id="actualizar_partida" style="display: none; width:95%">
                        <div class="card">
                            <div class="card-header text-center btn-success">
                                <div id="card-title">Crear Partida Arancelaria</div>
                            </div>
                            <br>
                            <div class="card-body">
                                <form id="partida">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <td><label for="codigo_producto">Codigo Producto</label></td>
                                                <td><input type="text" name="codigo_producto" id="codigo_producto" readonly class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="nombre">Descripcion</label></td>
                                                <td ><input type="text" name="nombre" id="descripcion" readonly class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td><label for="partida_arancelaria">Partida Arancelaria</label></td>
                                                <td><input type="text" name="partida_arancelaria" id="partida_arancelaria"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><button type="button" class="btn btn-success" onclick="crear_partida()"><span class="glyphicon glyphicon-floppy-save"></span> Agregar</button>
                                                    <button type="button" class="btn btn-success" id="cerrar"><span class="glyphicon glyphicon-folder-close"></span>  Cerrar</button></td>
                                            </tr>
                                            <tr>
                                                <td><input type="hidden" name="importador" id="importador"></td>

                                            </tr>
                                        </table>
                                    </div>
                                </form>
                                <input type="hidden" name="id_reg" id="id_reg" >
                            </div>
                        </div>
                    </div>


                    <div id="no_clasificados">
                        <?php $this->load->view('subir_archivos/no_clasificados')?>
                    </div>

                </div>
            </div>
        </div>
