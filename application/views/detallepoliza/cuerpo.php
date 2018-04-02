<div class="container">
	<div class="well well-sm">
		<?php echo $iniciaform; ?>
		<?php echo $iddua; ?>
		<?php echo $detallelinea; ?>

	<div class="form-group form-group-sm">
		<?php echo $lab_item; ?>
		<div class="col-md-2">
			<?php echo $item; ?>
		</div>

		<div class="checkbox col-md-2">
		  <label><?php echo $tlc; ?> Aplica TLC</label>
		</div>

		<?php echo $lab_codigoprod; ?>
		<div class="col-md-4">
			<?php echo $codigopro ?>
		</div>
	</div>

	<?php $var = (isset($aptlc) ? 'display:block;' : 'display:none;'); ?>
	<div class="form-group form-group-sm" id="aplicatlc" style="<?php echo $var; ?>">
		<?php echo $lab_acuerdo ?>
		<div class="col-md-4">
			<?php echo $acuerdo; ?>
		</div>

		<?php echo $lab_quota; ?>
		<div class="col-md-4">
			<?php echo $quota; ?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_marca; ?>
		<div class="col-md-4">
			<?php echo $marca ?>
		</div>

		<?php echo $lab_numeros; ?>
		<div class="col-md-4">
			<?php echo $numero; ?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_partida; ?>
		<div class="col-md-4">
			<?php echo $partida; ?>
		</div>

		<?php echo $lab_sac; ?>
		<div class="col-md-4">
			<?php echo $sac; ?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_comple; ?>
		<div class="col-md-4">
			<?php echo $comple; ?>
		</div>

		<?php echo $lab_doctrans; ?>
		<div class="col-md-4">
			<?php echo $doctrans;?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_tipobulto; ?>
		<div class="col-md-4">
			<?php echo $tipobulto; ?>
		</div>

		<?php echo $lab_origen; ?>
		<div class="col-md-4">
			<?php echo $origen; ?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_pesobruto; ?>
		<div class="col-md-4">
			<?php echo $pesobruto;?>
		</div>

		<?php echo $lab_pesoneto; ?>
		<div class="col-md-4">
			<?php echo $pesoneto;?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_cuantia; ?>
		<div class="col-md-4">
			<?php echo $cuantia;?>
		</div>

		<?php echo $lab_fob; ?>
		<div class="col-md-4">
			<?php echo $fob;?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_flete; ?>
		<div class="col-md-4">
			<?php echo $flete;?>
		</div>

		<?php echo $lab_seguro; ?>
		<div class="col-md-4">
			<?php echo $seguro;?>
		</div>
	</div>

	<div class="form-group form-group-sm">

		<?php echo $lab_otros; ?>
		<div class="col-md-4">
			<?php echo $otros;?>
		</div>

		<?php echo $lab_cif; ?>
		<div class="col-md-4">
			<?php echo $cif;?>
		</div>
	</div>

	<div class="form-group form-group-sm">
		<?php echo $lab_numbulto; ?>
		<div class="col-md-4">
			<?php echo $bulto; ?>
		</div>

		<?php echo $lab_descripcion; ?>
		<div class="col-md-4">
			<?php echo $descripcion; ?>
		</div>
	</div>

	<?php if (isset($contenedor)): ?>
		<div class="form-group form-group-sm">
			<?php echo $lab_contenedor1; ?>
			<div class="col-md-4">
				<?php echo $contenedor1;?>
			</div>

			<?php echo $lab_contenedor2; ?>
			<div class="col-md-4">
				<?php echo $contenedor2;?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo $lab_contenedor3; ?>
			<div class="col-md-4">
				<?php echo $contenedor3;?>
			</div>

			<?php echo $lab_contenedor4; ?>
			<div class="col-md-4">
				<?php echo $contenedor4;?>
			</div>
		</div>
	<?php endif ?>

	<div class="form-group form-group-sm">


		<label class="col-md-2 control-label"></label>
		<div class="col-md-4">
			<button class="btn btn-xs btn-success"><i class="glyphicon glyphicon-ok"></i> Guardar</button>
			<button type="button" class="btn btn-xs btn-default" onclick="cargarvistas(2)"><i class="glyphicon glyphicon-plus"></i> Nuevo</button>
			<button type="button" class="btn btn-xs btn-default" onclick="verlista(1)"><i class="glyphicon glyphicon-list"></i> Lista</button>
			<button type="button" class="btn btn-xs btn-primary" onclick="SubirXLS()">
				<i class="glyphicon glyphicon-file"></i> Subir Xls
			</button>
		</div>
	</div>
	<?php echo $cierraform; ?>
</div>

</div>

<script>
	aplicatlc();
</script>
