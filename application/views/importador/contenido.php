<script src="<?php echo base_url('public/js/importador.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/productos.js') ?>"></script>
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
                    <th>Proveedor</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Descripción Generica</th>
                    <th>Función</th>
                    <th>TLC</th>
                    <th>Permiso</th>
                    <th>Partida</th>
                    <th>Origen</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="listaprod">
                <?php $this->load->view('importador/lista'); ?>
            </tbody>

        </table>

        <table class="table table-responsive table-hovered" id="tbld">


            <tbody id="lista_duplicados">
                <?php $this->load->view('importador/duplicados'); ?>
            </tbody>
        </table>

    </div>

</div>
</div>

<!-- Modal subir archivo Excel -->

<div class="modal fade" id="upModal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header hdmodal buttonclose">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title border-bottom pb-3 mb-4"><strong>SUBIR ARCHIVO </strong></h4>

            </div>
            <div class="row-fluid" id="messagefile"></div>
            <form enctype="multipart/form-data" class="up_productos" id="up_productos"
                action="javascript:subir_productos()">
                <div class="modal-body">

                    <div class="container-fluid">
                        <div class="row">

                            <input type="file" name="file" id="file" class="w-50" required accept=".xls" />

                        </div>

                    </div>

                </div> <br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                    <input type="submit" value="Aceptar" id="enviar" class="btn btn-success" />

                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal subir archivo excel -->


<!-- Modal Crear Producto -->
<div class="container">
    <div class="modal fade" id="crear_producto" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header hdmodal buttonclose">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="opcion" class="modal-title border-bottom pb-3 mb-4"><strong>AGREGAR PRODUCTO </strong></h4>

                </div>
                <div class="row-fluid  message" id="message"></div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" class="add_producto" id="add_producto"
                        action="javascript:gestion_productos('c')">

                        <div class="container-fluid">
                            <input type="hidden" class="form-control " name="producimport" id="producimport" />
                            <div class="row">
                                <div class="col-sm-6">

                                </div>

                            </div>


                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Importador</label>
                                        <div class="col-sm-8">
                                            <!--   <input type="text" class="form-control required" name="importador"
                                                 id="importador" placeholder="Introduzca Importador" required /> -->
                                            <?php $this->load->view('importador'); ?>
                                        </div>
                                    </div>

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
                                        <label class="col-sm-4 control-label">Observaciones</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="observaciones"
                                                name="observaciones" placeholder="Introduzca Observación"
                                                required></textarea>
                                        </div>
                                    </div>

                                </div>
                                <!--fin primera Columna -->
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Proveedor</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="proveedor" id="proveedor"
                                                placeholder="Nombre Proveedor" required />
                                        </div>
                                    </div>

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
                                        class="btn btn-success pull-left btnsuccess"  />
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
<div class="modal" id="borrar_producto" role="dialog" data-backdrop="static">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header hdmodal buttonclose">
                <h4 class="modal-title">Eliminar Producto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="row-fluid  message" id="message_delete"></div>
            <!-- Modal body -->
            <div class="modal-body">
                <form enctype="multipart/form-data" class="del_producto">

                    <div class="form-group  has-success">
                        <label for="txtcodigo" class="control-label">Código</label>
                        <input type="text" class="form-control w-50 text-left" id="txtcodigo" name="txtcodigo" readonly>
                    </div>

                    <div class="form-group  has-success">
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

                <input type="button" value="Borrar" id="borrar" class="btn btn-success" data-dismiss="modal"  onclick="borrar_productos()"  />


            </div>
        </div>
    </div>

</div>

<!-- fin modal eliminar producto -->

<!--- modal para ver ficha -->
<div class="modal" id="verficha" role="dialog" data-backdrop="static">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header hdmodal buttonclose">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="opcion" class="modal-title border-bottom pb-3 mb-4"><strong>FICHA </strong></h4>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form enctype="multipart/form-data" class="del_producto">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-5 text-left">
                                <h4><strong><input type="text" class="sinborde" name="nombre_importador" /></strong>
                                </h4>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-tag"></i> Producto:</b>
                            </div>

                            <div class="col-sm-8">
                                <textarea class="sinborde" rows="1" id="descripcion" name="descripcion"
                                    style="width:100%"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-barcode"></i> Código:</b>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="codproducto" />
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-star"></i> Marca:</b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="marca" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-registration-mark"></i> Partida:</b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="partida" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-indent-right"></i> Peso Neto: </b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="pesoneto" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-th"></i> Numeros: </b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="numeros" readonly />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-certificate"></i> Tipo Bulto:</b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="descripcion_bulto" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-th"></i> Número de Bultos:</b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="nbultos" />
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-road"></i> País de Origen</b> <br>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="sinborde" name="paisorigen" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-calendar"></i> Fecha: </b> <br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-wrench"></i> Aplica TLC: </b> <br>
                            </div>

                            <div class="col-sm-8">
                                <label><input type="checkbox" value="" name="tlc" id="tlc" class="pull-right"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <b><i class="glyphicon glyphicon-ok"></i> Permiso: </b> <br>
                            </div>

                            <div class="col-sm-8">
                                <label><input type="checkbox" value="" name="permiso" id="permiso"
                                        class="pull-right"></label>
                            </div>
                        </div>

                    </div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>




            </div>
        </div>
    </div>

</div>

<!-- fin modal ver ficha -->


<!--- modal busqueda personalizada -->
<div class="modal" id="buscar" role="dialog" data-backdrop="static">
    <form role="search" method="get" action="<?php echo $action; ?>" id="formproducto"
        onsubmit="enviarformproducto(this); return false;">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Buscar...</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="form-group has-success ">
                        <select name="opcionbuscar" class="form-control" required>

                            <option value="">Elige una opción</option>

                            <option value="1"> NIt Importador</option>

                            <option value="2">Nombre Importador</option>

                            <option value="3">Nombre Provedor</option>

                            <option value="4">Código Producto</option>

                            <option value="5">Descripción Factura</option>

                            <option value="6">Partida</option>

                            <option value="7">Descripción Genérica</option>

                            <option value="8">Función</option>

                        </select>

                        <br><input type="search" class="form-control" placeholder="Importador" id="Buscador"
                            name="importador" />

                    </div><br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                        <button type="submit" class="btn btn-success btnsuccess ">
                            <i class="glyphicon glyphicon-search"> Buscar</i>
                        </button>
                    </div>


                </div>
            </div>
    </form>
</div>

<!---fin  modal busqueda personalizada -->

<script type="text/javascript">
$('#borrar_producto').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('book-id');
    var bookId1 = $(e.relatedTarget).data('book-id1');


    $(e.currentTarget).find('input[name="txtcodigo"]').val(bookId);
    $(e.currentTarget).find('input[name="txtnombre"]').val(bookId1);



});
</script>