<?php
$vermox = ($vermod == 1) ? 'display:none' : 'display:block';
$verenc = ($vermod == 1) ? 'display:block' : 'display:none';
?>
<input type="hidden" id="file" value="<?php echo $file; ?>">
<div id="cargamodelo" style="<?php echo $vermox ?>">
	<?php
	$this->load->view("encabezadopoliza/modelo");
	?>
</div>

<div id="cargaheader" style="<?php echo $verenc ?>;">
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span id="titulod"></span>
				<div class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="seguir">
							<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" id="masopc">
							<?php if ($duaduana > 0): ?>
								<li><a href="javascript:;" onclick="cargarvistas(1);">Póliza</a></li>
								<li><a href="javascript:;" onclick="cargarvistas(2);">Detalle</a></li>
								<li><a href="javascript:;" onclick="cargarvistas(3);">Documento</a></li>
							<?php endif ?>
						</ul>
					</div>
				</div>
			</div>
			<input type="hidden" id="valorfile">
			<div class="panel-body" id="contcuerpo"> <!-- Habilitado para modificar -->
				<script>
				  cargarvistas(1);
				</script>
			</div>
		</div>
	</div>
</div>

<!-- Para modal para detalle -->
<div id="md-detalle" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalle</h4>
      </div>
      <div class="modal-body" id="contenidodetalle">
      </div>
    </div>
  </div>
</div>