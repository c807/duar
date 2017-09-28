<ul class="list-group">
	<?php 
	if ($bitacora){
		foreach ($bitacora as $row){
			$real = $this->conf->obetenerDatosUsuario($row->realizo); ?>
			<li class="list-group-item bita-lista">
				<button type="button" class="close" style="outline: none;" onclick="eliminabitacora(<?php echo $row->bitacora ?>,'<?php echo $row->c807_file ?>'); ">
					<span>&times;</span>
				</button>
				<span class="bita-deta"><b>
					<i class="glyphicon glyphicon-user"></i> 
					<?php echo $real->NOMBRE; ?></b>
				</span><br>
				<span class="bita-deta"><b>
					<i class="glyphicon glyphicon-calendar"></i> <?php echo formatoFecha($row->fecha,2).' - '.$row->hora; ?></b>
				</span><br><br>
				<p><?php echo $row->descripcion; ?></p>
			</li>
		<?php
		}
	} else {
		echo "<p class='text-center'>No tiene registros para mostrar</p>";
	}
	?>
</ul>