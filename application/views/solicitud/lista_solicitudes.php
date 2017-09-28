<table class="table">
	<tr class="tbl-th">
		<th>File</th>
    	<th>Importador</th>
    	<th>Ejecutivo</th>
    	<th>Fecha Solicitud</th>
    	<th>Status</th>
    	<th class="text-center">Acción</th>
	</tr>
<?php 
if(isset($solicitudes)) {
	foreach ($solicitudes as $row) { ?>
		<tr>
		    <td><?php echo $row->c807_file; ?></td>
		    <td><?php echo $row->importador; ?></td>
		    <td><?php 
		    	$eje = $this->conf->obetenerDatosUsuario($row->ejecutivo);	
		    	echo $eje->NOMBRE;
		    	?>
		    </td>
		    <td><?php echo formatofecha($row->fecha,2); ?></td>
		    <td><?php echo $row->nombre;?></td>
		    <td class="text-center">
		    	<?php if($row->status == 2) { ?>
		    		<span style="color:red;">Es necesario terminar la prepóliza<br></span>
		    	<?php } ?>
		    	<div class="btn-group">
					<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			   			<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
					</button>
				  	<ul class="dropdown-menu dropdown-menu-right">
				  		<?php if($row->status <> 2 && $row->status <> 3 ) { ?>
					    	<li>
					    		<a href="javascript:;" id="btn-bitacora" onclick="accionesduar(<?php echo $row->solicitud; ?>, 2,'<?php echo $row->c807_file; ?>');">Aceptar</a>
					    	</li>
					    <?php } ?>
					    <li>
					    	<a href="javascript:;" onclick="cargarbitacora('<?php echo $row->c807_file; ?>')" id="btn-bitacora">Bitácora</a>
					    </li>

					    <?php if($row->status == 2) { ?>
					    	<li>
					    		<a target="_blank" href='<?php echo base_url('index.php/poliza/crear/headerduar/'.$row->c807_file) ?>'>Crear Prepóliza</a>
					    		<!-- <a target="_blank" href='<?php //echo base_url('index.php/poliza/crear/headerduar/'.$row->c807_file) ?>'>Crear Prepóliza</a> -->
					    	</li>
					    	<?php if ($this->soli->verificarpoliza($row->c807_file)){ ?>
					    	<li>
					    		<a href="javascript:;" id="btn-bitacora" onclick="accionesduar(<?php echo $row->solicitud; ?>, 3,'<?php echo $row->c807_file; ?>');">Terminar Prepóliza</a>
					    	</li>
					    <?php 
							}
					    } ?>

					    <?php if($row->status == 3) { ?>
					   		<li>
					   			<a href="<?php echo base_url('index.php/reportes/reporte/descargar/'.$row->c807_file) ?>">Descargar XLS </a>
					   		</li>
					    	<li>
					    		<a href="<?php echo base_url('index.php/reportes/reporte/verarchivo/'.$row->c807_file) ?>"> Ver Archivo XLS</a>
					    	</li>								    						
						<?php } ?>
						
						<?php if($row->status == 2 || $row->status == 3){ ?>
						    <li>
						    	<a href="<?php echo base_url('index.php/poliza/crear/headerduar/'.$row->c807_file) ?>">Ver Prepóliza</a>
						    </li>	
						<?php } ?>
					</ul>
				</div>
		    </td>
		</tr>
	<?php
	}
}
?>
</table>