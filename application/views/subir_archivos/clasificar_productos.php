<div class="container">
    <div class="panel panel-success" >
      
        <div class="panel-heading" id="titulo">Clasificar Productos

               
              

        
        <a href="<?php echo base_url('index.php/productos/ProductosController/lista_productos_importador?mid=29/') ?>" 
        class="btn btn-default btn-xs pull-right"><i class="glyphicon glyphicon-th-list"></i> Gestionar Productos</a>
        </div>
        <div class="panel-body">


            <div class="table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><label for="c807_file" class="col-sm-2"></label>Numero de File</td>
                             <td>
                                 <input type="text" name="c807_file" id="c807_file" class="form-control" value="<?php echo $c807_file ?>" required="true">
                             </td>
                             <td>
                             <button type="submit" class="btn btn-primary" onclick="no_clasificadas(1)">Buscar</button>
                             </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="no_clasificados">
                <?php $this->load->view('subir_archivos/no_clasificados')?>
            </div>

        </div>
    </div>
</div>

