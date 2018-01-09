<ul class="list-group">
	<?php 
	if (isset($bitacora) && ($bitacora)){
		foreach ($bitacora as $row){ ?>
			<li class="list-group-item bita-lista">
				<button type="button" class="close" onclick="eliminabitacora(<?php echo $row->bitacora ?>); ">
					<span>&times;</span>
				</button>
				<span class="bita-deta"><b><i class="glyphicon glyphicon-user"></i></b>
					<?php echo $row->nombre ?>
				</span><br>
				<span class="bita-deta"><b><i class="glyphicon glyphicon-calendar"></i></b>
					<?php echo formatoFecha($row->fecha,2).' - '.$row->hora; ?>
				</span><br>
				<span class="bita-deta"><b><i class="glyphicon glyphicon-comment"></i></b>
				Comentario:
				</span>
				<p><?php echo $row->descripcion; ?></p>
			</li>
		<?php
		}
	} else {
		echo '<li class="list-group-item bita-lista">';
		echo "<p class='text-center'>No tiene registros para mostrar</p>";
		echo '</li>';
	}
	?>
</ul>