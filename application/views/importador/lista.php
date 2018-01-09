<?php if (isset($productos)):  
	$a = (isset($aumenta)) ? $aumenta : 1;
?>
	<?php foreach ($productos as $row): ?>
		<tr>
			<td><?php echo $a++; ?></td>
			<td><?php echo $row->nombre; ?></td>
			<td><?php echo $row->descripcion; ?></td>
			<td><?php echo $row->codproducto; ?></td>
			<td><b><?php $res = ($row->tlc == 1) ? '&#10003;' : 'x'; echo $res; ?></b></td>
			<td><?php echo $row->partida; ?></td>
			<td><?php echo $row->paisorigen ?></td>
			<td><?php echo formatoFecha($row->fecha, 2); ?></td>
			<td><a href="#formedita" class="btn btn-default btn-xs" onclick="editarprod(<?php echo $row->producimport;?>);"><i class="glyphicon glyphicon-edit"></i></a></td>
		</tr>
	<?php endforeach ?>
<?php endif ?>

<?php if(isset($cantidad)): ?>
<tr id="cargarMas">
	<td colspan="100%">
		<p class="text-center" id="textocargar">
			<a href="javascript:;" onclick="vermas(<?php echo $cantidad; ?>)">Mostrar Más</a>
		</p>
	</td>
</tr>
<?php endif ?>
