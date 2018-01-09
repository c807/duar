<div class="row">
	<div class="col-sm-12">
		<div class="well well-sm"  id="result-bita">
			<div class="container-fluid">
				<form onsubmit="sendbitacora(this); return false;" method="post" id="formbita" action="<?php echo $accion; ?>">
					<input type="hidden" value="<?php echo $file; ?>" name="file">
					<div class="checkbox">
						<label><input type="checkbox" name="enviar" value="1"> Notificar por correo</label>
					</div>
					<div class="form-group">
						<textarea type="text" name="msj" placeholder="Ingrese la Descripción..." class="form-control" rows="5"></textarea>
					</div>
					<div class="form-group text-center">
						<button class="btn btn-primary btn-sm">Guardar</button>
						<button class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">Cancelar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
