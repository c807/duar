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
	<script type="text/javascript" src="<?php echo base_url('public/js/poliza.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/bootstrap/js/bootstrap.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/jquery-ui.js') ?>"></script>
	<title>Dua</title>
</head>
<body>
	<nav class="navbar navbar-default navbar-poli">
		<div class="container-fluid">
			<div class="collapse navbar-collapse">
				<h4 class="navbar-text">
				<?php 
				if (isset($regresar)){ 
					echo "<a class='btn btn-default btn-sm' href='{$regresar}'><i class='glyphicon glyphicon-arrow-left'></i></a>";
				
				}
				?>

				Póliza # 
					<b>
						<?php
						if (isset($nopoliza)) { 
							echo $nopoliza; 
						}
						?>
					</b>
				</h4>
				<ul class="nav navbar-nav pull-right">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									<i class="glyphicon glyphicon-cog"></i> Acción
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="<?php echo base_url('index.php/solicitud/solicitudes/vertodos') ?>"><i class="glyphicon glyphicon-th-list"></i> Solicitudes</a></li>
								</ul>
							</li>
						</ul>
					</ul>
			</div>
		</div>
	</nav>
	<div class="panel panel-default panel-poli">
		<div class="panel-heading" id="titulo">
			<?php 
			if (isset($polTitulo)){
				echo $polTitulo;
			} 
			?>
		</div>
	  	<div class="panel-body" id="contenido">
	   		<?php 
	   		if (isset($vista)) {
	   			$this->load->view($vista);
	   		} ?>
			<div id="idlista">
				<?php
		   		if (isset($lista)) {
					$this->load->view($lista);
				}
		   		?>
		   	</div>
		</div>
	</div>
</body>
</html>