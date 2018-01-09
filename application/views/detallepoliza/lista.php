<table class="table table-responsive table-sm"> 
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
		<th>DOC. TRANSPORTE</th>
		<th>GASTOS</th>
		<th></th>
	</tr>
<?php 
if(isset($detallelista)){
	foreach ($detallelista as $row) { ?>
		<tr>
			<td><?php echo $row->item; ?></td>
			<td><?php echo $row->descripcion; ?></td>
			<td><?php echo $row->marcas; ?></td>
			<td><?php echo $row->tipo_bulto; ?></td>
			<td><?php echo $row->origen; ?>
				
			</td>
			<td>
			 	<span class="pretitulo"><b class="m2">Bruto</b> [<?php echo $row->peso_bruto; ?>]</span>
			 	<span class="pretitulo"><b class="m2">Neto</b> [<?php echo $row->peso_neto; ?>]</span>
			</td>
			<td><?php echo $row->doc_transp; ?></td>
			<td>
				<span class ="pretitulo"><b class="m1">Fob:</b> <?php echo $row->fob; ?></span>
				<span class ="pretitulo"><b class="m1">Flete:</b> <?php echo $row->flete; ?></span>
				<span class ="pretitulo"><b class="m1">Seguro:</b> <?php echo $row->seguro; ?></span>
				<span class ="pretitulo"><b class="m1">Otros:</b> <?php echo $row->otros; ?></span>
				<span class ="pretitulo"><b class="m1">CIF:</b> <?php echo $row->cif; ?></span>
				
			</td>

			<td class="text-center">
				<div class="btn-group">
					<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
					</button>
				  	<ul class="dropdown-menu dropdown-menu-right">
				  		<li><a href="javascript:;" onclick="cargarvistas(2, <?php echo $row->detalle; ?>);"><i class="glyphicon glyphicon-pencil"></i> &nbsp;&nbsp;Editar</a></li>
				  		<?php 
				  		$var = json_encode(array('opc' => 1, 'detalle' => $row->detalle,'duaduana' => $row->duaduana));
				  		?>
						<li><a href="javascript:;" onclick='eliminarfila(<?php echo $var ?>)'><i class="glyphicon glyphicon-remove"></i> &nbsp;&nbsp;Eliminar</a></li>
					</ul>
				</div>
			</td>
		</tr>
	<?php
	}
}
?>
</table>