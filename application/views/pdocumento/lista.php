<table class="table"> 
	<tr>
		<th colspan="10" class="thtitulo" style="background: #4E714A; color :#FFF;"> Lista de Detalles de Documentos
		</th>
	</tr>
	<tr class="titbar">
		<th>No.</th>
		<th>Tipo de Documentos</th>
		<th>Número Documento</th>
		<th>Fecha Documento</th>
		<!-- <th>Descripción</th> -->
		<th class="text-center">Accion</th>
	</tr>
	<?php 
	if (isset($listadocs)){
		$cant = 1;
		foreach ($listadocs as $row){ ?>
			<tr>
				<td><?php echo $cant++; ?></td>
				<td>
					<?php 
					$doc = $this->crear->documento($row->codigo_doc);
					echo $doc->descripcion;
					echo "<br><span style='color:#4288C3;'><strong> Código: [{$row->codigo_doc}]</strong></span>";
					?>
					
				</td>
				<td><?php echo $row->num_doc; ?></td>
				<td><?php echo formatoFecha($row->fecha,2); ?></td>
				<!--<td><?php //echo $row->desc_cod; ?></td>-->
				<td class="text-center">
					<a class="btn btn-default btn-xs" href='<?php echo base_url("index.php/poliza/documentosop/docsoporte/{$row->duaduana}?doc={$row->documento}") ?>'><i class="glyphicon glyphicon-edit"></i></a>
					<button class="btn btn-danger btn-xs" onclick="eliminardoc(<?php echo $row->documento;?>, <?php echo $row->duaduana; ?>)"><i class="glyphicon glyphicon-remove"></i></button>
				</td>
			</tr>
		<?php
		}
	}
	?>
</table>