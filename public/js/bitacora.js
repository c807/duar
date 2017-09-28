function base_url(direc){
	return window.location.origin + "/grupo_c807/duar/" + direc;
}

function cargargif(){
	var img = base_url('public/img/cargando.gif');
	var load = '<p class="text-center"><img src="'+ img +'" alt=""></p>';
	return  load;	
}

function cargarbitacora(file){
	var url  = base_url('index.php/solicitud/bitacora/verbitacora/'+ file);
	$('#btn-coment').show();

	$.get(url, function(data){
		$('#defile').html('del file '+ file);
		$('#valorfile').val(file);
		$('#contenidobitacora').html(data);
	})
}

function comentario(file){
	$('#mdlcomentario').modal();

	var url = base_url('index.php/solicitud/bitacora/form_bitacora/' + file);

	$.get(url, function(data){
		$('#contenidoComentario').html(data);
	})
}

// GUARDA LA BITACORA	
$(document).on('submit','#formcomenta',function(event){
	event.preventDefault();
	var datos = $(this).serialize();
		$('#result-bita').html(cargargif());
	$.post(this.action,datos, function(data){
		$('#result-bita').html('<p class="text-center">'+data+'</p>');
		cargarbitacora($('#valorfile').val());
	})
});

function eliminabitacora(id,file){
	var confirma = confirm("¿Está seguro de eliminar el registro?");

	if (confirma) {
		var url = base_url('index.php/solicitud/bitacora/eliminarbitacora/' + id );
		$.get(url, function(data){
			cargarbitacora(file);
		})
	} else {
		return false;
	}
}