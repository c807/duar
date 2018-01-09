<div class="col-md-7">
	<ul class="list-group">
	<li class="list-group-item ">
		<form action="<?php echo $action; ?>" class="form-horizontal" method="post" onsubmit="enviaredicion(this); return false;">
			<?php echo $idprod; ?>
		<div class="form-group form-group-sm">
			<?php echo $lab_codigo; ?>
			<div class="col-md-4">
				<?php echo $codigo; ?>
			</div>

			<?php echo $lab_partida; ?>
			<div class="col-md-4">
				<?php echo $partida; ?>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<?php echo $lab_pneto; ?>
			<div class="col-md-4">
				<?php echo $pneto; ?>
			</div>

			<?php echo $lab_origen; ?>
			<div class="col-md-4">
				<?php echo $origen; ?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo $lab_tipbulto; ?>
			<div class="col-md-4">
				<?php echo $tipbulto; ?>
			</div>

			<?php echo $lab_nobulto; ?>
			<div class="col-md-4">
				<?php echo $nobulto; ?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo $lab_numeros; ?>
			<div class="col-md-4">
				<?php echo $numeros; ?>
			</div>

			<?php echo $lab_marca; ?>
			<div class="col-md-4">
				<?php echo $marca; ?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo $lab_descripcion; ?>
			<div class="col-md-4">
				<?php echo $descripcion; ?>
			</div>

			<label class="col-sm-2 "></label>
			<div class="col-md-4">
				<label><?php echo $tlc; ?> Aplica TLC</label>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<div class="col-md-12">
				<button class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-edit"></i> Actualizar Información</button>
				<button type="button" class="btn btn-default btn-sm" onclick="cerrar('formedita')"> <i class="glyphicon glyphicon-remove"></i> Cancelar</button>
			</div>
		</div>
	</form>
	</li>
</ul>
</div>

<div class="col-md-5">
	<ul class="list-group">
		<li class="list-group-item">
			<?php if ($informacion): ?>
			<h5 class="text-center"><b><?php echo $informacion->nombre; ?></b></h5>
			<div class="row">
				<span class="col-md-5">
					<b><i class="glyphicon glyphicon-tag"></i> Producto:</b> <br>
					<b><i class="glyphicon glyphicon-barcode"></i> Código:</b> <br>
					<b><i class="glyphicon glyphicon-star"></i> Marca:</b> <br>
					<b><i class="glyphicon glyphicon-registration-mark"></i> Partida:</b> <br>
					<b><i class="glyphicon glyphicon-indent-right"></i> Peso Neto: </b> <br>
					<b><i class="glyphicon glyphicon-th"></i> Numeros: </b> <br>
					<b><i class="glyphicon glyphicon-certificate"></i> Tipo Bulto:</b> <br>
					<b><i class="glyphicon glyphicon-th"></i> Número de Bultos:</b> <br>
					<b><i class="glyphicon glyphicon-road"></i> País de Origen</b> <br>
					<b><i class="glyphicon glyphicon-calendar"></i> Fecha: </b> <br>
					<b><i class="glyphicon glyphicon-wrench"></i> Aplica TLC: </b> <br>
				</span>
				<span class="col-md-6">  
					<?php echo $informacion->descripcion; ?> <br>
					<?php echo $informacion->codproducto; ?> <br>
					<?php echo $informacion->marca; ?><br>
					<?php echo $informacion->partida; ?><br>
					<?php echo $informacion->peso_neto; ?><br>
					<?php echo $informacion->numeros; ?><br>
					<?php echo $informacion->nombrebulto ?><br>
					<?php echo $informacion->no_bultos ?><br>
					<?php echo $informacion->npaisorigen ?><br>
					<?php echo formatoFecha($informacion->fecha, 2); ?><br>
					<?php echo ($informacion->tlc == 1) ? 'SI' : 'NO'; ?>
				</span>
			</div>
			<?php endif ?>
			
		</li>
	</ul>
</div>