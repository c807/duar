<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css') ?>">	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/chosen/chosen.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/confirm/jquery-confirm.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/cssmante.css') ?>">
	<script type="text/javascript" src="<?php echo base_url('public/js/jquerypro.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/chosen/chosen.jquery.min.js'); ?>"></script>
	<script tyoe="text/javascript" src="<?php echo base_url('public/confirm/jquery-confirm.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/mante.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/bootstrap/js/bootstrap.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/jquery-ui.js') ?>"></script>
	<title>Mantenimiento</title>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<span class="navbar-brand">
					Control de 
					<?php 
					if (isset($navbar)) {
						echo $navbar;
					}
					?>	
				</span>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<form class="navbar-form navbar-left" action="<?php echo $action ?>" method="post" id="formter">
			        <input type="hidden" id="inicio" value="0" name="inicio">
			        <div class="form-group">
			        	<input type="text" class="form-control" id="termino" name="termino" placeholder="Código o nombre">
	
		       		<button class="btn btn-primary btn-sm">
						<i class="glyphicon glyphicon-search"></i>
					</button>
					</div>
		      	</form>
				<button type="button" class="btn btn-default navbar-btn btn-xs" onclick="openform()">
					<i class="glyphicon glyphicon-plus"></i> Nuevo
				</button>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!-- Contenido empresa -->
	<div class="panel panel-default" id="editar">
		<div class="panel-heading" id="titulo">
			<i class="glyphicon glyphicon-edit"></i> Editar
			<button class="btn btn-danger btn-xs pull-right" onclick="cerrar('editar')"><i class="glyphicon glyphicon-remove"></i></button>
		</div>
  		<div class="panel-body" id="contenidoeditar">
  		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">
			<?php if (isset($navbar)) {
				echo $navbar;
			} ?>
		</div>
  		<div class="panel-body" id="contenido">
  			<table class="table">
  				<thead>
					<tr>
						<th>Código</th>
						<th>Nombre</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody id="contenidoLista">
				</tbody>
			</table>
  		</div>
	</div>
</body>
</html>