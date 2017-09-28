<?php 
if (isset($lista)) {
foreach ($lista as $row) { ?>
	<tr>
		<td><?php echo $row->cod_empresa; ?></td>
		<td><?php echo $row->nombre; ?></td>
		<td>
			<button class="btn btn-default btn-xs" onclick="openform(<?php echo $row->empresa; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
		</td>
	</tr>
	<?php
}
}
?>
<?php if(isset($cantidad)): ?>
<tr id="cargarMas">
	<td colspan="100%">
		<p class="text-center" id="textocargar">
			<a href="javascript:;" onclick="vermas(<?php echo $cantidad; ?>)">Mostrar Más</a>
		</p>
	</td>
</tr>
<?php endif ?>
