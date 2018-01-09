<script src="<?php echo base_url('public/js/importador.js') ?>"></script>
<!-- Comienza -->


<div class="container">
	<div class="panel panel-default" id="formedita" style="display: none;">
		<div class="panel-heading" id="titulo"><i class="glyphicon glyphicon-edit"></i> Editar Producto Agregado
			<button class="btn btn-danger btn-xs pull-right" onclick="cerrar('formedita');"><i class="glyphicon glyphicon-remove"></i></button>
		</div>
			<div class="panel-body" id="contenidoedita">
				Aca va el producto
			</div>
	</div>
	
	
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">Buscar</div>
		<div class="panel-body">
			<table class="table table-responsive table-hovered">
				<thead>
					<tr>
						<th>#</th>
						<th>Importador</th>
						<th>Producto</th>
						<th>Código</th>
						<th>TLC</th>
						<th>Partida</th>
						<th>Origen</th>
						<th>Fecha</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="listaprod">
					<?php $this->load->view('importador/lista'); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>