<style>
.table {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 10px;
}

.table-hovers tbody tr:hover td {
    background-color: #D1D119 !important;
    background: #22313F !important;
    color: #fff !important;


}

#sailorTableArea {
    max-height: 550px;
    overflow-x: auto;
    overflow-y: auto;
}

#sailorTable {
    white-space: nowrap;
}

.table-responsive {
    height: 550px;
    overflow: scroll;
}

thead tr:nth-child(1) th {
    background: #c2deb3;
    position: sticky;
    top: 0;
    z-index: 10;

}


tbody td:hover {
    background: #455D72;

}

tbody tr:hover {
    background: #22313F !important;
    color: #fff !important;
}

thead th {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
}

/*.modal-header{
     background-color:#31592C;
     
     color:#fff;
}
*/
</style>
<div class="container">

    <div class="panel panel-success">

        <div class="panel-heading" id="titulo">Clasificar Productos new


        </div>

        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary btn-md pull-center" data-toggle="modal"
                            data-target="#cargarModal">
                            <i class="glyphicon glyphicon-open"></i>Subir Archivo</button>

                        <button type="button" class="btn btn-success btn-md pull-center btnsuccess" data-toggle="modal"
                            data-target="#crear_producto">
                            <i class="glyphicon glyphicon-plus"></i>Agregar</button>

                        <button type="button" class="btn btn-success btn-md pull-center btnsuccess" data-toggle="modal"
                            data-target="#crear_producto">
                            <i class="glyphicon glyphicon-search"></i>Buscar</button>

                    </div>
                    <div class="col-md-5">
                        <input id="myInput" type="text" placeholder="Buscar..." class='form-control '>

                    </div>

                </div>

            </div>
            <br>
            <?php
            if (isset($productos)) { ?>


            <div class="table-responsive table-hover table-condensed" id="sailorTableArea">

                <table class="table table-hover table-scroll tableFixHead" id="sailorTable">

                    <thead>

                        <tr>

                            <!--   <th class="col-xs-1">ID</th> -->

                            <th class=" col-xs-2">Importador</th>

                            <th class=" col-xs-2">Proveedor</th>

                            <th class=" col-xs-2">Código Producto</th>

                            <th class=" col-xs-4">Descripción Factura</th>

                            <th class=" col-xs-4">Descripción Generica</th>

                            <th class=" col-xs-4">Función</th>

                            <th class=" col-xs-4">Partida</th>

                            <th class=" col-xs-4">Observaciones</th>

                            <th class=" col-xs-4">Permiso</th>

                            <th class=" col-xs-4">TLC</th>

                            <th class=" col-xs-4"></th>
                            <th class=" col-xs-4"></th>


                        </tr>

                    </thead>

                    <tbody id="myTable">

                        <?php foreach ($productos as $row): ?>

                        <tr>

                            <td>
                                <!-- <?php echo  $row->importador; ?> -->
                                <?php echo $row->nombre; ?>
                            </td>
                            <td>
                                <?php echo $row->proveedor; ?>
                            </td>

                            <td>
                                <?php echo $row->codproducto; ?>
                            </td>

                            <td>
                                <?php echo $row->descripcion; ?>
                            </td>

                            <td>
                                <?php echo $row->descripcion_generica; ?>
                            </td>

                            <td>
                                <?php echo $row->funcion; ?>
                            </td>

                            <td>
                                <?php echo $row->partida; ?>
                            </td>
                            <td>
                                <?php echo $row->observaciones; ?>
                            </td>
                            <?php
                                if($row->permiso==1){
                                   echo '<td style="text-align:center;">';
                                   echo '<input type="checkbox" name="permiso" checked />';
                                   echo '</td>';
                                }else{
                                    echo '<td style="text-align:center;">';
                                    echo '<input type="checkbox" name="permiso"  />';
                                    echo '</td>';
                                }

                                if($row->tlc==1){
                                    echo '<td style="text-align:center;">';
                                    echo '<input type="checkbox" name="tlc" checked />';
                                    echo '</td>';
                                 }else{
                                     echo '<td style="text-align:center;">';
                                     echo '<input type="checkbox" name="tlc"  />';
                                     echo '</td>';
                                 }
                           
                              ?>

                            <td>
                                <a href='#editar_producto' class="btn btn-primary btn-xs" title="Editar Producto"
                                    data-toggle="modal" style="margin-left:2px;"
                                    data-book-id=" <?php echo trim($row->producimport);?> "
                                    data-book-id1=" <?php echo trim($row->importador);?> "
                                    data-book-id2=" <?php echo trim($row->codproducto);?> "
                                    data-book-id3=" <?php echo trim($row->descripcion);?> "
                                    data-book-id4=" <?php echo trim($row->descripcion_generica);?> "
                                    data-book-id5=" <?php echo trim($row->funcion);?> "
                                    data-book-id6=" <?php echo trim($row->partida);?> "
                                    data-book-id7=" <?php echo trim($row->observaciones);?> "
                                    data-book-id8=" <?php echo $row->permiso; ?> "
                                    data-book-id9=" <?php echo $row->tlc; ?> "
                                    data-book-id10=" <?php echo $row->proveedor; ?> ">
                                    <i class="glyphicon glyphicon-edit"></i> </a>
                            </td>


                            <td>
                                <button class="btn btn-default btn-xs"
                                    onclick="openform(<?php echo $row->empresa; ?>)"><i
                                        class="glyphicon glyphicon-trash"></i></button>
                            </td>


                        </tr>

                        <?php endforeach ?>

                    </tbody>

                </table>

            </div>

            <?php } ?>

        </div>
    </div>
</div>


<!-- Modal Crear Producto -->
<div class="container">
    <div class="modal fade" id="crear_producto" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert-success ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title border-bottom pb-3 mb-4"><strong>CREAR PRODUCTO </strong></h4>

                </div>
                <div class="row-fluid  message" id="message"></div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" class="add_producto" id="add_producto"
                        action="javascript:gestion_productos('c')">

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
                                        <label class="col-sm-4 control-label">Descripción G.</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="descripcion_generica"
                                                name="descripcion_generica"
                                                placeholder="Introduzca descripción genérica" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Función</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="funcion" name="funcion"
                                                placeholder="Introduzca función" required></textarea>
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
                                        <label class="col-sm-4 control-label">Observaciones</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="observaciones"
                                                name="observaciones" placeholder="Introduzca Observación"
                                                required></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-8 ">
                                            <label><input type="checkbox" value="" name="permiso"
                                                    id="permiso">PERMISO</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-8 ">
                                            <label><input type="checkbox" value="" name="tlc" id="tlc">TLC</label>
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

<!-- Modal Edita Producto -->
<div class="container">
    <div class="modal fade" id="editar_producto" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert-success ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title border-bottom pb-3 mb-4"><strong>EDITAR PRODUCTO </strong></h4>

                </div>
                <div class="row-fluid  messageup" id="messageup"></div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" class="edit_producto" id="edit_producto"
                        action="javascript:update_productos();">

                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control " name="producimport" id="producimport" />

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Importador</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="importador" id="importador"
                                                placeholder="Introduzca Importador" required />
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
                                        <label class="col-sm-4 control-label">Descripción G.</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="descripcion_generica"
                                                name="descripcion_generica"
                                                placeholder="Introduzca descripción genérica" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Función</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="funcion" name="funcion"
                                                placeholder="Introduzca función" required></textarea>
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
                                        <label class="col-sm-4 control-label">Observaciones</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="observaciones"
                                                name="observaciones" placeholder="Introduzca Observación"
                                                required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  ">Proveedor</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="proveedor" id="proveedor"
                                                placeholder="Introduzca proveedor" required />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-8 ">
                                            <label><input type="checkbox" value="" name="permiso"
                                                    id="permiso">PERMISO</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-8 ">
                                            <label><input type="checkbox" value="" name="tlc" id="tlc">TLC</label>
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
                                    <input type="submit" value="Guardar" id="upda"
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
<!-- fin Modal Editar Producto -->
<!-- Modal subir archivos -->

<div class="modal fade" id="cargarModal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header alert-success ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title border-bottom pb-3 mb-4"><strong>SUBIR PRODUCTO </strong></h4>

            </div>
            <div class="row-fluid" id="messagefile"></div>
            <div class="modal-body">

                <form enctype="multipart/form-data" class="up_productos" id="up_productos">

                    <div class="container-fluid">
                        <div class="row">
                            <input type="file" name="file" id="file" required />

                        </div>

                    </div>

                </form>
            </div> <br>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

                <input type="button" value="Aceptar" id="enviar" class="btn btn-success" onclick="subir_productos()" />

            </div>
        </div>
    </div>
</div>


<!---fin modal cargar productos -->

<script type="text/javascript">
$('#editar_producto').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('book-id');
    var bookId1 = $(e.relatedTarget).data('book-id1');
    var bookId2 = $(e.relatedTarget).data('book-id2');
    var bookId3 = $(e.relatedTarget).data('book-id3');
    var bookId4 = $(e.relatedTarget).data('book-id4');
    var bookId5 = $(e.relatedTarget).data('book-id5');
    var bookId6 = $(e.relatedTarget).data('book-id6');
    var bookId7 = $(e.relatedTarget).data('book-id7');
    var bookId8 = $(e.relatedTarget).data('book-id8');
    var bookId9 = $(e.relatedTarget).data('book-id9');
    var bookId10 = $(e.relatedTarget).data('book-id10');

    $(e.currentTarget).find('input[name="producimport"]').val(bookId);
    $(e.currentTarget).find('input[name="importador"]').val(bookId1);
    $(e.currentTarget).find('input[name="codproducto"]').val(bookId2);
    $(e.currentTarget).find('textarea[name="descripcion"]').val(bookId3);
    $(e.currentTarget).find('textarea[name="descripcion_generica"]').val(bookId4);
    $(e.currentTarget).find('textarea[name="funcion"]').val(bookId5);
    $(e.currentTarget).find('input[name="partida"]').val(bookId6);
    $(e.currentTarget).find('textarea[name="observaciones"]').val(bookId7);
    $(e.currentTarget).find('checked[name="permiso"]').val(bookId8);
    $(e.currentTarget).find('checked[name="proveedor"]').val(bookId9);
    if (bookId8 == 1) {
        $(e.currentTarget).find('input[name="permiso"]').prop("checked", true)
    } else {
        $(e.currentTarget).find('input[name="permiso"]').prop("checked", false)
    }

    if (bookId9 == 1) {
        $(e.currentTarget).find('input[name="tlc"]').prop("checked", true)
    } else {
        $(e.currentTarget).find('input[name="tlc"]').prop("checked", false)
    }
    $(e.currentTarget).find('input[name="proveedor"]').val(bookId10);


});
</script>


<script>
jQuery(document).ready(function() {
    jQuery(".main-table").clone(true).appendTo('#tabla').addClass('clone');
});
</script>


<script>
$(document).ready(function() {

    $("#myInput").on("keyup", function() {

        var value = $(this).val().toLowerCase();

        $("#myTable tr").filter(function() {

            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

        });

    });

});
</script>