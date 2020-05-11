<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">Declarión<span id="defile"></span>
		</div>
		<div class="panel-body" id="contmodelo">
			<form action="" method="post" id="formodelo" onsubmit="cargarvistas(1,1); return false;">
				<input type="hidden" name="file" value="<?php echo $file ?>" id="valorfile">
				<div class="well well-sm" id="result">
					<div class="row ">
						<div class="col-md-3"></div>
						<div class="col-md-6 offset-md-3">
						<div class="alert alert-success">Es necesario seleccionar un modelo para el file <b><?php echo $file ?></b></div>
					</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3"></div>
						<div class="col-md-6 offset-md-3">
							<label for="selectmod"><b>Modelo de Declaración</b></label>
							<select name="modelo" id="selectmod" class="chosen" data-placeholder="Seleccione..." onchange="dependencia(1, this.value, 'selectregext',1)">
								<option value=""></option>
								<?php 
								if (isset($modelos)) {
									foreach ($modelos as $row) {
										echo "<option value='{$row->codigo}'>{$row->codigo} - {$row->descripcion}</option>";
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3"></div>
						<div class="col-md-6 offset-md-3">
							<label for="selectmod"><b>Regimen Extendido</b></label>
							<select name="reg_ext" id="selectregext" class="chosen" data-placeholder="Seleccione..." onchange="dependencia(2, this.value, 'selectregadi',1)">
								<option value=""></option>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3"></div>
						<div class="col-md-6 offset-md-3">
							<label for="selectmod"><b>Regimen Adicional</b></label>
							<select name="reg_adi" id="selectregadi" class="chosen" data-placeholder="Seleccione...">
								<option value=""></option>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3"></div>
						<div class="col-md-6 offset-md-3">
							<a href="<?php echo base_url('index.php/solicitud/solicitud') ?>" class="btn btn-default btn-sm"> <i class="glyphicon glyphicon-arrow-left"></i> Atras</a>
							<button class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-right"></i> Siguiente</button>
						</div>
					</div>
				</div>	
			</form>
		</div>
	</div>
</div>

