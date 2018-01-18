<p>Se muestran las solicitudes de <b><?php echo $nomuser; ?></b> pendientes de iniciar</p>

<table class="table table-hover table-responsive" style="border:1px solid #ddd;">
	<thead>
		<tr class="bg-success">
			<th>#</th>
			<th>Importador</th>
			<th>File</th>
			<th>Fecha Ingresada</th>
			<th>Ejecutivo</th>
			<th>Status</th>
			<th><i class="glyphicon glyphicon-cog"></i></th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($lista)): $a = 1; ?>
			<?php foreach ($lista as $row): ?>
				<tr>
					<td><?php echo $a++ ?></td>
					<td><?php echo $row->importador ?></td>
					<td><?php echo $row->c807_file ?></td>
					<td><?php echo formatoFecha($row->fecha) ?></td>
					<td><?php echo $row->nomejecutivo ?></td>
					<td><?php echo $row->nomstatus ?></td>
					<td>
					<div class="btn-group">
						<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				   			<span class="caret"></span>
						</button>
					  	<ul class="dropdown-menu dropdown-menu-right">
					  		<li><a href="javascript:;" onclick="cargar_bitacora('<?php echo "{$row->c807_file}"; ?>')">Bitácora</a></li>

							<!-- Cuando no se ha iniciado -->
					  		<?php if ($row->status == 1): ?>
					  			<!-- <li><a href="javascript:;" onclick="poliza(2, <?php echo $row->solicitud; ?>)">Crear</a></li> -->
					  			<li><a href='<?php echo base_url("index.php/poliza/crear/declaracion/{$row->c807_file}") ?>'>Crear</a></li>
					  		<?php endif ?>

							<!-- Cuando la poliza esta en proceso -->
					  		<?php if ($row->status == 2): ?>
					  			<li><a href="javascript:;" onclick="poliza(3, <?php echo $row->solicitud; ?>)">Terminar</a></li>
					  		<?php endif ?>

							<!-- Cuando se termina la poliza -->
					  		<?php if ($row->status == 3): ?>
					  			<!-- <li><a href="javascript:;">Descargar</a></li> -->
					  			<!--<li><a href='<?php //echo base_url("index.php/formato/reportes/mobrk/{$row->c807_file}") ?>'>Formato</a></li>-->
					  			<li><a target="_blank" href='<?php echo base_url("index.php/formato/reportes/archivosad/{$row->c807_file}") ?>'>Formato</a></li>
					  		<?php endif ?>

							<?php if ($row->status <> 1): ?>
								<li><a href='<?php echo base_url("index.php/poliza/crear/declaracion/{$row->c807_file}") ?>'>Ver póliza</a></li>
							<?php endif ?>
						</ul>
					</div>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>