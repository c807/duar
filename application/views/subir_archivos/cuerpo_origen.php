
<?php 
if (isset($l_retaceo)) {
foreach ($l_retaceo as $row) { ?>
	<tr>
		<td><?php echo $row->partida; ?></td>
		<td><?php echo $row->cuantia; ?></td>
		<td><?php echo $row->total; ?></td>
		<td><?php echo $row->pais_origen; ?></td>
		<td><b><?php $res = ($row->tlc == 1) ? 'SI' : 'NO'; echo $res; ?></b></td>
		
		<td>
		<!--	<button class="btn btn-default btn-xs" onclick="openform(<?php echo $row->id; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
		-->
		</td>
	</tr>
	<?php
}
}
?>