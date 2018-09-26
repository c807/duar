<div class="container">
    <div class="panel panel-success">
          <div class="panel-heading">
                <h3 class="panel-title">Generar Archivo Clasificado</h3>
          </div>
          <div class="panel-body">
                <?php  echo form_open_multipart("subir_archivo/generar_excel",array("name"=>"form" , "method"=>"GET"));?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td><label for="c807_file" class="col-sm-2"></label>Numero de File</td>
                                    <td><input type="text" name="c807_file" id="c807_file" class="form-control" required="required"></td>
                                    <td><label for="doc_transporte" class="col-sm-2"></label>Documento de Transporte</td>
                                    <td><input type="text" name="doc_transporte" id="doc_transporte" class="form-control" required="required"></td>
                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <td><label for="tot_bultos" class="col-sm-2"></label>Total Bultos</td>
                                    <td><input type="number" name="tot_bultos" id="tot_bultos" class="form-control" required="required"></td>
                                    <td><label for="tot_kilos" class="col-sm-2"></label>Total Peso Kilos</td>
                                    <td><input type="number" name="tot_kilos" id="tot_kilos" class="form-control" required="required" step="0.01"></td>
                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <td><label for="flete" class="col-sm-2"></label>Flete</td>
                                    <td><input type="number" name="flete" id="flete" class="form-control" step="0.01"></td>
                                    <td><label for="seguro" class="col-sm-2"></label>Seguro</td>
                                    <td><input type="number" name="seguro" id="seguro" class="form-control"  step="0.01"></td>
                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <td><label for="otros" class="col-sm-2"></label>Otros</td>
                                    <td><input type="number" name="otros" id="otros" class="form-control" step="0.01"></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                 
                                    <td colspan="2"> <button type="button" class="btn btn-primary pull-right" onclick="generar_excel()">Generar Excel</button></td>
                                    
                                    <td colspan="2">
                                        <button type="button" class="btn btn-primary pull-left" onclick="generar_rayado()" >Generar PDF</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php echo form_close();?>
                <div id="no_clasificados">
                    <?php $this->load->view('subir_archivos/no_clasificados')?>
                </div>

          </div>
    </div>

</div>
