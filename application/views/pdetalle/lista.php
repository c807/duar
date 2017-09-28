<table class="table"> 
	<tr>
		<th colspan="100%" class="thtitulo" style="background: #4E714A; color :#FFF;"><i class="glyphicon glyphicon-briefcase"></i> Lista de Detalles
		</th>
	</tr>
	<tr class="titbar">
		<th>ITEM</th>
		<th>DESCRIPCION</th>
		<th>MARCA</th>
		<th>TIPO BULTO</th>
		<th>ORIGEN</th>
		<th>PESO</th>
		<th>DOCUMENTO TRANSPORTE</th>
		<th>GASTOS</th>
		<th>ACCIONES</th>
	</tr>
<?php 
if(isset($detallelista)){
	foreach ($detallelista as $row) { ?>
		<tr>
			<td><?php echo $row->item; ?></td>
			<td><?php echo $row->descripcion; ?></td>
			<td><?php echo $row->marcas; ?></td>
			<td><?php echo $row->tipo_bulto; ?></td>
			<td><?php 
			if ($row->origen) { 
				echo $this->crear->paises($row->origen);
			} else {
				echo '';
			} ?>
				
			</td>
			<td>
			 	<span class="pretitulo"><b>Bruto</b> <span class="restitulo">[<?php echo $row->peso_bruto; ?>]</span></span>
			 	<span class="pretitulo"><b>Neto</b> <span class="restitulo">[<?php echo $row->peso_neto; ?>]</span></span>
			</td>
			<td><?php echo $row->doc_transp; ?></td>
			<td>
				<span class="pretitulo"><b>Fob:</b> <span class="restitulo"><?php echo $row->fob; ?></span></span>
				<span class="pretitulo"><b>Flete:</b> <span class="restitulo"><?php echo $row->flete; ?></span></span>
				<span class="pretitulo"><b>Seguro:</b> <span class="restitulo"><?php echo $row->seguro; ?></span></span>
				<span class="pretitulo"><b>Otros:</b> <span class="restitulo"><?php echo $row->otros_gastos; ?></span></span>
				
			</td>

			<td class="text-center">
				<a href='<?php echo base_url("index.php/poliza/arancelaria/detalle/{$idDua}?linea={$row->detalle}"); ?>' class="btn btn-default btn-sm btn-xs" title="Editar">
					<i class="glyphicon glyphicon-edit"></i>
				</a>
				<a href="javascript:;" class="btn btn-danger btn-sm btn-xs" title="Eliminar" onclick="eliminardetalle(<?php echo $idDua;?>,<?php echo $row->detalle;?>)">
					<i class="glyphicon glyphicon-remove"></i>
				</a>
			</td>
		</tr>
	<?php
	}
}
?>
</table>