<table class="table"> 
	<tr>
		<th colspan="10" class="thtitulo" style="background: #4E714A; color :#FFF;"> Lista de Documentos
		</th>
	</tr>
	<tr class="titbar">
		<th>No.</th>
		<th>Tipo de Documentos</th>
		<th>Número Documento</th>
		<th>Fecha Documento</th>
		<th></th>
	</tr>
	<?php 
	if (isset($listadocs)){
		$cant = 1;
		foreach ($listadocs as $row){ ?>
		<tr>
			<td><?php echo $cant++; ?></td>
			<td><?php echo $row->descripcion; ?></td>
			<td><?php echo $row->numero; ?></td>
			<td><?php echo formatoFecha($row->fecha,2); ?></td>
			<td class="text-center">
				<div class="btn-group">
					<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="javascript:;" onclick="cargarvistas(3, <?php echo $row->documento; ?>);"><i class="glyphicon glyphicon-pencil"></i> &nbsp;&nbsp;Editar</a></li>
						<li><a href="javascript:;"><i class="glyphicon glyphicon-remove"></i> &nbsp;&nbsp;Eliminar</a></li>
					</ul>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>
</table>