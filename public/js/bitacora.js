var setfile = document.getElementById("valorfile");

function comentario() {
	if (setfile.value == '') {
		$("#btn-coment").notify(
					"Debe cargar la bitácora de una solicitud",
					{position:"top right"}
					);

	} else {
		var url = base_url('index.php/bitacora/bitacora/form_bitacora')
		var datos = {file:setfile.value};
		$.post(url,datos, function(data) {
			document.getElementById("contenidoComentario").innerHTML = data;
		})
		$("#mdlcomentario").modal();
	}
}

function sendbitacora(fbit) {
	var url = fbit.action;
	var datos = $(fbit).serialize();
	cargando("result-bita");

	$.post(url, datos, function (data) {
		document.getElementById("result-bita").innerHTML = data;
		cargar_bitacora(setfile.value);
	})
}

function eliminabitacora(bit){
	var url = base_url('index.php/bitacora/bitacora/eliminarbitacora/'+bit);

	$.post(url, function (data) {
		$.notify(data+ ' '+ setfile.value,'error');
		cargar_bitacora(setfile.value);
	})
}