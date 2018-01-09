<div class="container">
	<div class="well">
		<form action="<?php echo base_url('index.php/poliza/documento/guardar'); ?>" onsubmit="enviardocumento(this); return false;" class="form-horizontal" id="formdoc">
			<?php echo $duaduana; ?>
			<?php echo $iddoc; ?>
			<div class="form-group form-group-sm">
				<?php echo $lab_tipodoc; ?>
				<div class="col-md-4">
					<?php echo $tipodoc; ?>
				</div>

				<?php echo $lab_numerodoc; ?>
				<div class="col-md-4">
					<?php echo $numerodoc; ?>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo $lab_fechadoc; ?>
				<div class="col-md-4">
					<?php echo $fechadoc; ?>
				</div>

				<label class="control-label col-md-2"></label>
				<div class="col-md-4">
					<button type="submit" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i> Guardar</button>
					<button type="button" class="btn btn-danger btn-xs" onclick="cargarvistas(3);"><i class="glyphicon glyphicon-plus"></i> Nuevo</button>
					<button type="button" class="btn btn-primary btn-xs" onclick="verlista(2);"><i class="glyphicon glyphicon-list"></i> Lista</button>
				</div>
			</div>
		</form>
	</div>
</div>