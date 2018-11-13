
<!-- <?php echo $id['id_reg']?> -->
<div class="container well well-sm" id="actualizar_partida<?php echo $id['id_reg']?>" style="display: none; width:95%">
    <div class="card">
        <div class="card-header text-center btn-success">
            <div id="card-title">Crear Partida Arancelaria</div>
        </div>
        <br>
        <div class="card-body">
            <form id="partida<?php echo $id['id_reg']?>">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td><label for="proveedor<?php echo $id['id_reg']?>">Proveedor</label></td>
                            <td  colspan="2"><input type="text" name="proveedor<?php echo $id['id_reg']?>" id="proveedor<?php echo $id['id_reg']?>" readonly class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="num_factura<?php echo $id['id_reg']?>">Núumero Factura</label></td>
                            <td  colspan="2"><input type="text" name="num_factura<?php echo $id['id_reg']?>" id="num_factura<?php echo $id['id_reg']?>" readonly class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="codigo_producto<?php echo $id['id_reg']?>">Codigo Producto</label></td>
                            <td  colspan="2"><input type="text" name="codigo_producto<?php echo $id['id_reg']?>" id="codigo_producto<?php echo $id['id_reg']?>" readonly class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="nombre<?php echo $id['id_reg']?>">Descripcion</label></td>
                            <td colspan="2"><input type="text" name="descripcion<?php echo $id['id_reg']?>" id="descripcion<?php echo $id['id_reg']?>" readonly class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="partida_arancelaria<?php echo $id['id_reg']?>">Partida Arancelaria</label></td>
                            <td><input type="text" name="partida_arancelaria<?php echo $id['id_reg']?>" id="partida_arancelaria<?php echo $id['id_reg']?>" class="form-control" maxlength="8"></td>
                            <td><input type="text" name="codigo_extendido<?php echo $id['id_reg']?>" id="codigo_extendido<?php echo $id['id_reg']?>" class="form-control" maxlength="3"></td>
                        </tr>
                        <tr>
                            <td><label for="descripcion_generica<?php echo $id['id_reg']?>">Descripcion Generica</label></td>
                            <td  colspan="2"><input type="text" name="descripcion_generica<?php echo $id['id_reg']?>" id="descripcion_generica<?php echo $id['id_reg']?>" class="form-control" maxlength="45" ></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2"><button type="button" class="btn btn-success" onclick="crear_partida(<?php echo $id['id_reg']?>)"><span class="glyphicon glyphicon-floppy-save"></span> Agregar</button>
                                <button type="button" class="btn btn-success" onclick="cerrar(<?php echo $id['id_reg']?>)" id="cerrar2"><span class="glyphicon glyphicon-folder-close"></span>  Cerrar</button></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="importador<?php echo $id['id_reg']?>" id="importador<?php echo $id['id_reg']?>"></td>
                        </tr>
                    </table>
                </div>
            </form>
            <input type="hidden" name="id_reg" id="id_reg" >
        </div>
    </div>
</div>