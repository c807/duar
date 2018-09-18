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
	<script type="text/javascript" src="<?php echo base_url('public/bootstrap/js/bootstrap.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/jquery-ui.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/notify.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/solicitud.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/modelo.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('public/js/poliza.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/js/funciones_subir_archivo.js') ?>"></script>
	<title>DuaR</title>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" style="box-shadow: 0 0 8px rgba(0,0,0,0.3);">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="color:#565656;"><?php if(isset($navtext)) { echo $navtext;} ?></a>
    </div>
    <?php if (isset($form)): ?>
      <?php $this->load->view($form); ?>
    <?php endif ?>
    <?php if (isset($soli)): ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-flag"></i> Acción<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('index.php/solicitud/solicitud') ?>"><i class="glyphicon glyphicon-envelope"></i> Solicitud</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <?php endif ?>
  </div>
</nav>
<?php
if (isset($vista)) {
	$this->load->view($vista);
}
?>
	<script type="text/javascript" src="<?php echo base_url('public/js/bitacora.js') ?>"></script>

</body>
</html>