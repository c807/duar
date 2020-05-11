<?php
if (isset($l_retaceo)) {
    $i=1;
    foreach ($l_retaceo as $row) { ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->partida; ?></td>
			<td><?php echo $row->nombre; ?></td>
			<td class="text-right"><?php echo $row->bultos; ?></td>
			<td class="text-right"><?php echo $row->peso_bruto; ?></td>
			<td class="text-right"><?php echo $row->peso_neto; ?></td>
			<td class="text-right"><?php echo $row->cuantia; ?></td>
			<td class="text-right"><?php echo $row->total; ?></td>
			<td class="text-center"><b><?php $res = ($row->tlc == 1) ? 'SI' : 'NO'; echo $res; ?></b></td>
		</tr>

		<?php
		
	
    $i=$i+1;
	}
}

if (isset($origen)) {
    $i=1;
    foreach ($origen as $row) { ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->partida; ?></td>
			<td><?php echo $row->nombre; ?></td>
			<td class="text-right"><?php echo $row->bultos; ?></td>
			<td class="text-right"><?php echo $row->peso_bruto; ?></td>
			<td class="text-right"><?php echo $row->peso_neto; ?></td>
			<td class="text-right"><?php echo $row->cuantia; ?></td>
			<td class="text-right"><?php echo $row->total; ?></td>
			<td class="text-center"><?php echo $row->pais_origen; ?></td> 
			<td class="text-center"><b><?php $res = ($row->tlc == 1) ? 'SI' : 'NO'; echo $res; ?></b></td>
			<td class="text-center"><?php echo $row->item; ?></td> 

			<td>
				<button class="btn btn-default btn-xs" onclick="cambiar_origen(<?php echo $row->id; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
			</td>
		</tr>

	<?php
     $i=$i+1;
    }
}
?>