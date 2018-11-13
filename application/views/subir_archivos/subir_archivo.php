
    <div class="container">

	<div class="panel panel-success">
		 <div class="panel-heading">Subir Archivo al File :</div>
		<div class="panel-body">
			<?php
			     if (isset($_SESSION["no_clasificado"]) )
			     {
			     ?>
			     	<div class="alert alert-success">
                        <?php echo $_SESSION["no_clasificado"] ?>
			     	</div>
			     <?php
			     }
			?>


			<div>

			<?php  echo form_open_multipart("subir_archivo/import",array("name"=>"form"));?>
            <!-- <form name="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">  -->
			<?php
				$errors=validation_errors('<li>','</li>');
				if($errors !=""){
			?>
			   	<div class="alert alert-danger">
			  		<ul>
			   			<?php echo $errors; ?>
                           <?php echo $_SESSION["no_clasificado"] ?>
			   		</ul>
			   	</div>
			   <?php
			  }
			?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td><label for="c807_file" >Número de File</label></td>
                                <td><input type="text" name="c807_file" id="c807_file" class="form-control" required="true" value="<?php echo ($file) ?>"</td>
                            </tr>
                            <tr>
                                <td><label for="file" >Archivo xls</label></td>
                                <td><input type="file" name="file" id="file" required accept=".xls"/> </td>
                            </tr>
                            <tr><td></td>
                                <td><input type="submit" value="Enviar" class="btn btn-success" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <br/>
                <div class="card">
                    <?php
                        if (isset($registros))
                            { ?>
                                <div class="card-header text-center btn-success">
                                    <div id="card-title">Producto Importados: <?php echo ($contador)?> </div>
                                </div>
                        <br>
                            <?php } ?>
				    <div card="card-body">
                                            
                        <div id="no_clasificados">
                            <?php $this->load->view('subir_archivos/listado_productos')?>
                        </div>
                        <div>
                        <?php
                        if (isset($registros))
                            { ?>
                                <div class="card-body text-center">
                                    <div>
                                        <?php if (isset($cantidad_productos)) {
                                            $_SESSION["no_clasificado"] = '';
                                            if ($cantidad_productos[0]->cantidad == 0)  { ?>
                                            <a class="btn btn-primary"  href="<?php echo base_url('index.php/subir_archivo/mostrar_clasificados')?>" role="button">Ir a Generación de Archivo Excel</a>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-success" onclick="enviar_correo(1)" >Enviar a Clasificar</button>
                                            
                                    <?php } }?>
                                    </div>
                                </div>
                        <br>
                            <?php } ?>
                        </div>
				    </div>
                </div>
			<?php echo form_close();?>
				<hr />
			</div>
		</div>
	</div>
</div>




