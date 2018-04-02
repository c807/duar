<div id="respuesta"></div>
<div class="list-group-item" id="contenidoxls">
	<h4><i class="glyphicon glyphicon-upload"></i> Seleccione el archivo XLS</h4>
	<form action="<?php echo $accion ?>" id="formXLS" enctype="multipart/form-data" method="post" onsubmit="enviarXls(this); return false;">
		<div class="form-group form-group-sm">
			<input type="file" name="archivo" class="form-control">
		</div>
		<!-- <div class="form-group form-group-sm">
			<p>Agrupar por:</p>
			<div class="radio">
				<label class="radio-inline"><input type="radio" name="agrupar" value="1"> Partida Arancelaria</label>
			</div>
			<div class="radio">
				<label class="radio-inline"><input type="radio" name="agrupar" value="2"> Descripción</label>
			</div>
		</div> -->
		<div class="form-group form-group-sm text-center">
			<button class="btn btn-sm btn-primary" id="btnxls">
				<i class="glyphicon glyphicon-ok"></i> Aceptar
			</button>
			<div id="carga"></div>
		</div>
	</form>
</div>
