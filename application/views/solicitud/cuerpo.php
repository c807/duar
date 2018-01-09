<div class="form-group col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">Lista</div>
		<div class="panel-body" id="contenidosolicitud">
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading" id="titulo">Bitácora <span id="defile"></span>
			<button class="btn btn-danger btn-xs pull-right" id="btn-coment" onclick="comentario();">
				<i class="glyphicon glyphicon-comment"></i>
			</button>
		</div>
		<input type="hidden" id="valorfile">
		<div class="panel-body" id="contenidobitacora">
			<ul class="list-group">
				<li class="list-group-item bita-lista">
					<p class="text-center">Tienes <?php echo $contar; ?> solicitud(es) recibida(as)</p>
					<h4 class="text-center"><i class="glyphicon glyphicon-envelope"></i></h4>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- Para abrir el modal de comentario -->
<div class="modal fade" id="mdlcomentario">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Comentar proceso</h4>
			</div>
			<div class="modal-body" id="contenidoComentario"></div>
		</div>
	</div>
</div>

<script>
	cargalistaSol();
</script>