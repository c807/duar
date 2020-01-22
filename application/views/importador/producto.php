<!-- Modal Crear Producto -->
<div class="container">
    <div class="modal fade" id="crear_producto"  role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header hdmodal buttonclose">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="opcion" class="modal-title border-bottom pb-3 mb-4"><strong>AGREGAR PRODUCTO </strong></h4>
                    
                </div>
                <div class="row-fluid  message" id="message"></div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" method='$_GET' class="add_producto" id="add_producto"
                        action="javascript:gestion_productos('c')">
                        <input type="hidden" class="form-control " name="producimport" id="producimport" />
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Importador</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control required" name="importador"
                                                id="importador" placeholder="Introduzca Importador" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                            </div>


                            <div class="row">

                                <div class="col-sm-6">


                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Código</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="codproducto" id="codproducto"
                                                placeholder="Introduzca código de producto" required />
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Descripción F.</label>
                                        <div class="col-sm-8">

                                            <textarea class="form-control" rows="3" id="descripcion" name="descripcion"
                                                placeholder="Introduzca descripción según factura" required></textarea>

                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Función</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="funcion" name="funcion"
                                                placeholder="Introduzca función" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Proveedor</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="proveedor" id="proveedor"
                                                placeholder="Nombre Proveedor" required />
                                        </div>
                                    </div>


                                </div>
                                <!--fin primera Columna -->
                                <div class="col-sm-6">

                                    <!--Inicio segunda Columna -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  ">Partida</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="partida" id="partida"
                                                placeholder="Introduzca partida Arancelelaria" required />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="paises" class="col-sm-4 control-label">Origen</label>
                                        <div class="col-sm-8">
                                            <?php $this->load->view('paises'); ?>
                                        </div>
                                    </div>

                                  

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  ">Marca</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="marca" id="marca"
                                                placeholder="Introduzca Marca" required />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Descripción G.</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="descripcion_generica"
                                                name="descripcion_generica"
                                                placeholder="Introduzca descripción genérica" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Observaciones</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="observaciones"
                                                name="observaciones" placeholder="Introduzca Observación"
                                                required></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-4">
                                            <label><input type="checkbox" value="" name="permiso"
                                                    id="permiso">PERMISO</label>

                                        </div>
                                        <label class="col-sm-0 control-label  "></label>
                                        <div class=" checkbox col-sm-4">

                                            <label><input type="checkbox" value="" name="tlc" id="tlc"
                                                    class="pull-right">TLC</label>
                                        </div>



                                    </div>



                                </div>
                                <!--fin segunda Columna -->
                            </div>

                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-default pull-right "
                                        data-dismiss="modal">Cancelar</button>
                                </div>

                                <div class="col">
                                    <input type="submit" value="Guardar" id="enviar"
                                        class="btn btn-success pull-left btnsuccess" />
                                </div>
                            </div>
                    </form>
                </div> <br>

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Crear Producto -->


<script>
    $('#crear_producto').modal('show')
    </script>