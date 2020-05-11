<div class="container">
	<div class="well well-sm">
			<?php echo $iniciaform ?>
				<?php 
				echo $duaduana;
				echo $regext;
				echo $regadi;
				echo $file;
				echo $declarante;
				?>
				<div class="form-group form-group-sm">
					<?php echo $lab_nit; ?>
					<div class="col-md-4">
						<?php echo $nit; ?>
					</div>

					<?php echo $exp_det; ?>
					<div class="col-md-4">
						<?php echo $nitnombre; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_modelo; ?>
					<div class="col-md-4">
						<?php echo $modelo; ?>
					</div>

					<?php echo $direccion; ?>
					<div class="col-md-4">
						<?php echo $nitdirec; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_pais; ?>
					<div class="col-md-4">
						<?php echo $pais; ?>
					</div>

					<?php echo $lab_paisdestino; ?>
					<div class="col-md-4">
						<?php echo $paisdestino; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_paisprocedencia; ?>
					<div class="col-md-4">
						<?php echo $paisprocedencia; ?>
					</div>

					<?php echo $lab_paisexpor; ?>
					<div class="col-md-4">
						<?php echo $paisexportacion; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_aduana; ?>
					<div class="col-md-4">
						<?php echo $aduana; ?>
					</div>
					
					<?php echo $lab_regtrans; ?>
					<div class="col-md-4">
						<?php echo $regtransportista ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_modotrans; ?>
					<div class="col-md-4">
						<?php echo $modotransporte; ?>
					</div>

					<?php echo $lab_paistransporte; ?>
					<div class="col-md-4">
						<?php echo $paistransporte; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_localmerca; ?>
					<div class="col-md-4">
						<?php echo $localmercancia; ?>
					</div>
					
					<?php echo $lab_lugcarga; ?>
					<div class="col-md-4">
						<?php echo $lugarcarga; ?>
					</div>

				</div>
				<div class="form-group form-group-sm">
					<?php echo $lab_incoterm; ?>
					<div class="col-md-4">
						<?php echo $incoterms; ?>
					</div>

					<?php echo $lab_doctrans; ?>
					<div class="col-md-4">
						<?php echo $doctrans; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_fob; ?>
					<div class="col-md-4">
						<?php echo $fob; ?>
					</div>

					<?php echo $lab_flete; ?>
					<div class="col-md-4">
						<?php echo $flete; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_seguro; ?>
					<div class="col-md-4">
						<?php echo $seguro; ?>
					</div>

					<?php echo $lab_otros; ?>
					<div class="col-md-4">
						<?php echo $otros; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_tasa; ?>
					<div class="col-md-4">
						<?php echo $tasas; ?>
					</div>
					
					<?php echo $lab_totalfactura; ?>
					<div class="col-md-4">
						<?php echo $totalfactura; ?>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_manifiesto; ?>
					<div class="col-md-4">
						<?php echo $manifiesto; ?>
					</div>

					<?php echo $lab_presentacion; ?>
					<div class="col-md-4">
						<?php echo $presentacion; ?>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<?php echo $lab_banco; ?>
					<div class="col-md-4">
						<?php echo $banco; ?>
					</div>
					
					<?php echo $lab_agencia; ?>
					<div class="col-md-4">
						<?php echo $agencia; ?>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<?php echo $lab_fechapago; ?>
					<div class="col-md-4">
						<?php echo $fechapago; ?>	
					</div>
					
					<?php echo $lab_bulto; ?>
					<div class="col-md-4">
						<?php echo $bulto; ?>
					</div>
								
				</div>

				<div class="form-group form-group-sm">
					<?php echo $lab_referencia; ?>
					<div class="col-md-4">
						<?php echo $referencia; ?>
					</div>

					<?php echo $lab_agente; ?>
					<div class="col-md-4">
						<?php echo $agente; ?>
					</div>
				</div>
				
				<div class="form-group form-group-sm">
					<label class="col-md-2 control-label"></label>
					<div class="checkbox col-md-2">
					 	<label><?php echo $contenedor; ?> Contenedores</label>
					</div>		
					<div class="col-md-2">
						<button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i> Guardar</button>
					</div>
				</div>

				
			<?php echo $cierraform; ?>
		</div>
	
</div>