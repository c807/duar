<div class="row">
	<div class="col-sm-12">
		<div class="well well-sm"  id="result-bita">
			<div class="alert alert-warning">
				Este comentario se agregará al file <strong><?php echo $file; ?></strong>.
			</div>
			<div class="container-fluid">
				<?php echo $iniciaform; ?>
					<div class="form-group col-md-6">
					    <?php echo $lab_file; ?>
						<?php echo $inp_file; ?>
					</div>
					<div class="col-md-4" id="enviacorreo">
			            <div class="checkbox">
			              <label>
			                <input type="checkbox" name="enviar" id="enviacorreo" value="1"> Enviar Correo
			              </label>
			            </div>
			            <span>Se enviará al ejecutivo</span>
			        </div>
					<div class="form-group col-md-12">
						<?php echo $lab_mensaje; ?>
						<?php echo $inp_mensaje; ?>
					</div>
					<div class="form-group col-md-12">
						<?php echo $button; ?>
					</div>
				<?php echo $cierraform; ?>
			</div>
		</div>
	</div>
</div>
