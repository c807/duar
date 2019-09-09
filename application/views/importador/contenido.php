<style>


</style>
<script src="<?php echo base_url('public/js/importador.js') ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('public/js/productos.js') ?>"></script>
<!-- Comienza -->


<br>
<div class="container">
    <div class="panel panel-default" id="formedita" style="display: none;">
        <div class="panel-heading" id="titulo"><i class="glyphicon glyphicon-edit"></i> Editar Producto Agregado
            <button class="btn btn-danger btn-xs pull-right" onclick="cerrar('formedita');"><i
                    class="glyphicon glyphicon-remove"></i></button>
        </div>
        <div class="panel-body" id="contenidoedita">
            Aca va el producto
        </div>
    </div>


    <div class="panel panel-default">

        <div class="panel-heading" id="titulo">Productos


        </div>
        <div class="row-fluid  message" id="messagedel"></div>

        <table class="table table-responsive table-hovered" id="tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Importador</th>
                    <th>Producto</th>
                    <th>Código</th>
                    <th>TLC</th>
                    <th>Partida</th>
                    <th>Origen</th>
                    <th>Fecha</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="listaprod">
                <?php $this->load->view('importador/lista'); ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal subir archivo Excel -->

<div class="modal fade" id="upModal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header alert-success ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title border-bottom pb-3 mb-4"><strong>SUBIR ARCHIVO </strong></h4>

            </div>
            <div class="row-fluid" id="messagefile"></div>
            <div class="modal-body">

                <form enctype="multipart/form-data" class="up_productos" id="up_productos">

                    <div class="container-fluid">
                        <div class="row">

                            <input type="file" name="file" id="file" class="w-50" required accept=".xls" />

                        </div>

                    </div>

                </form>
            </div> <br>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                <input type="button" value="Aceptar" id="enviar" class="btn btn-success" onclick="subir_productos()" />

            </div>
        </div>
    </div>
</div>
<!-- fin modal subir archivo excel -->


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
                                        <label class="col-sm-4 control-label">Peso Neto</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" name="pesoneto" id="pesoneto"
                                                min="0" step="0.01" placeholder="Introduzca peso neto" required />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="tipobulto" class="col-sm-4 control-label">Tipo Bulto</label>
                                        <div class="col-sm-8">
                                      

                                            <?php
                                          
                                            $this->load->view('tipobulto'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Números</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="numeros" id="numeros"
                                                placeholder="Introduzca Números" required />
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
                                        <label class="col-sm-4 control-label  ">No. Bultos</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" name="nbultos" id="nbultos"
                                                min="0" step="0.01" placeholder="Introduzca Número de Bultos"
                                                required />
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


<!--- modal para eliminar registro -->
<div class="modal" id="delmodal" role="dialog" data-backdrop="static">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Eliminar Producto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form enctype="multipart/form-data" class="del_producto">
                    <div class="form-group">
                        <label for="txtcodigo" class="control-label">Código</label>
                        <input type="text" class="form-control w-50 text-left" id="txtcodigo" name="txtcodigo" readonly>
                    </div>

                    <div class="form-group">
                        <label for="txtnombre" class="control-label">Nombre</label>
                        <input type="text" class="form-control w-100 text-left" id="txtnombre" name="txtnombre"
                            readonly>
                    </div>

                    <div class="form-group text-center">
                        <strong>
                            <h4>
                                <p>Esta seguro(a) de eliminar este producto?</p>
                            </h4>
                        </strong>

                    </div>

                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                <input type="button" value="Borrar" id="borrar" class="btn btn-success" onclick="borrar_productos()"
                    data-dismiss="modal" />


            </div>
        </div>
    </div>

</div>

<!-- fin modal eliminar producto -->


<!-- Modal multipropositos,tanto para agregar usuarios a  -->
<div class="modal fade" id="multi_opt_user" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i class="fi-heart"></i>
                <button id="pethatlimypro" type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>



                <div class="modal-body">
                    <div id="pocos"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $('#delmodal').on('show.bs.modal', function(e) {
        var bookId = $(e.relatedTarget).data('book-id');
        var bookId1 = $(e.relatedTarget).data('book-id1');


        $(e.currentTarget).find('input[name="txtcodigo"]').val(bookId);
        $(e.currentTarget).find('input[name="txtnombre"]').val(bookId1);



    });
    </script>


    <script type="text/javascript">
   </script>

    <script>
    $(document).ready(function() {

        $("#myInput").on("keyup", function() {

            var value = $(this).val().toLowerCase();

            $("#tbl tr").filter(function() {

                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

            });

        });

    });
    </script>

 