<?php 
$id     = "";
$codigo = "";
$nombre = "";

if (isset($result)){
	$id     = $result->empresa;
	$codigo = $result->cod_empresa;
	$nombre = $result->nombre;
}
?>
<div class="row">
	<div class="col-sm-12">
		<div class="well well-sm"  id="result-bita">
			<div class="container-fluid">
				<form action="<?php echo base_url('index.php/mantenimiento/empresas/guardar')?>" method="post" id="formEmpresa">
					<input type="hidden" name="empresa" value="<?php echo $id; ?>">
					<div class="form-group col-sm-6">
						<label for="codigo">Código: </label>
						<input type="text" id="codigo" name="cod_empresa" class="form-control" value="<?php echo $codigo; ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="nombre">Nombre: </label>
						<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
					</div>
					<div class="form-group col-sm-12">
						<button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
