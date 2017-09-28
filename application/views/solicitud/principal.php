<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css') ?>">	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/estilo.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/chosen/chosen.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/confirm/jquery-confirm.min.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('public/js/jquerypro.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/chosen/chosen.jquery.min.js'); ?>"></script>
	<script tyoe="text/javascript" src="<?php echo base_url('public/confirm/jquery-confirm.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/bitacora.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/solicitud.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/bootstrap/js/bootstrap.js'); ?>"></script>
	<title>Dua-R</title>
</head>
<body>
	<div class="form-group col-md-12">
		<nav class="navbar navbar-default navbar-prin" style="width: 100%;">
			<div class="container-fluid">
				<div class="collapse navbar-collapse">
					<p class="navbar-text">
						<b><?php echo $titulo; ?></b>
					</p>
					<!--<ul class="nav navbar-nav pull-right">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									Acción
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#">--</a></li>
								</ul>
							</li>
						</ul>
					</ul>-->
				</div>
			</div>
		</nav>
	</div>

	<div class="form-group col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading" id="titulo">Solicitudes</div>
		  	<div class="panel-body" id="contenidosolicitud" style="padding:0px;">
		   		<?php 
		   		if (isset($listaSoli)) {
		   			$this->load->view($listaSoli);
		   		}
		   		?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading" id="titulo">Bitácora <span id="defile"></span>
				<button class="btn btn-danger btn-xs pull-right" id="btn-coment" style="display: none;" onclick="comentario($('#valorfile').val());">
					<i class="glyphicon glyphicon-comment"></i>
				</button>
			</div>
			<input type="hidden" id="valorfile">
		  	<div class="panel-body" id="contenidobitacora">
		   		<ul class="list-group">
		   			<li class="list-group-item bita-lista">
		   				<p class="text-center">Tienes <?php echo $contar; ?> solicitud pendientes de iniciar</p>
		   			</li>
		   		</ul>
			</div>
		</div>
	</div>

	<div class="modal fade" id="mdlcomentario">
		<div class="modal-dialog modal-md">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">Agregar Comentario</h4>
	      		</div>
	      		<div class="modal-body" id="contenidoComentario"></div>
	    	</div>
	  	</div>
	</div>

</body>
</html>