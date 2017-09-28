<?php 
if (isset($datosDocSP)) {
	$idDoc       = $datosDocSP->documento;
	$tipodoc     = $datosDocSP->codigo_doc;
	$numdoc      = $datosDocSP->num_doc;
	$fechadoc    = $datosDocSP->fecha;
	$descripcion = $datosDocSP->desc_cod;
} else {
	$idDoc       = '';
	$tipodoc     = '';
	$numdoc      = '';
	$fechadoc    = '';
	$descripcion = '';
}
?>
<div id="DocumentSP">
	<div class="well well-sm">
		<div class="row">
			<div class="col-sm-12">
				<form action="<?php echo base_url('index.php/poliza/documentosop/guardardoc') ?>" method="POST" id="formDocs"> 
					<input type="hidden" value="<?php echo $idDua; ?>" name="duaduana" id="duaduana">
					<input type="hidden" value="<?php echo $idDoc; ?>" name="documento">
					<div class="form-group col-sm-4">
						<label for="tipo_doc">Tipo Documento</label>
						<select name="codigo_doc" id="tipo_doc" class="form-control">
							<option value="">-</option>
							<?php
							if(isset($documentos)){
								foreach ($documentos as $row){
									if($tipodoc == $row->cod){
										echo "<option value='{$tipodoc}' selected>{$row->cod} - {$row->descripcion}</option>";
									}
									echo "<option value='{$row->cod}'>{$row->cod} - {$row->descripcion}</option>";
								}
							}
							?>
						</select>
					</div>
					<div class="form-group col-sm-4">
						<label for="num_doc">Número Documento</label>
						<input type="text" class="form-control" name="num_doc" id="num_doc" value="<?php echo $numdoc; ?>">
					</div>
					<div class="form-group col-sm-4">
						<label for="date_doc">Fecha Documento</label>
						<input type="date" class="form-control" name="fecha" id="date_doc" value="<?php echo $fechadoc; ?>">
					</div>
					<!--<div class="form-group col-sm-4">
						<label for="descripcion">Descripción</label>
						<textarea name="descripcion" id="descripcion" rows="2" class="form-control"><?php echo $descripcion; ?></textarea>
					</div>-->
					<div class="form-group col-sm-12 text-right">
						<a href="<?php echo base_url("index.php/poliza/documentosop/docsoporte/{$idDua}") ?>" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-plus"></i></a>
						<button class="btn btn-primary btn-sm">Guardar</button>
						<a href="javascript:" type="button" class="btn btn-info btn-sm  open_list" onclick="listas('#idlista')"><i class="glyphicon glyphicon-sort"></i></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>