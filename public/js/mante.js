function base_url(url){
	return window.location.origin + '/grupo_c807/duar/' + url;
}

$(document).on('submit','#formter', function(event) {
	event.preventDefault();
	$("input#inicio").val(0);
	var url = this.action;
	var datos = $(this).serialize();

	$.post(url, datos, function(data){
		$('#contenidoLista').empty();
		$('#contenidoLista').append(data);
	})

})

function openform(id) {
	$('#editar').show('blind');
	
	var url = base_url('index.php/mantenimiento/empresas/ver/' + id);

	$.post(url, function(data){
		$('#contenidoeditar').html(data);
	})
}

$(document).on('submit', '#formEmpresa', function(event){
	event.preventDefault();
	var url   = this.action;
	var datos = $(this).serialize();
	$('#contenidoeditar').html('<p class="text-center"><img src="'+base_url('public/img/cargando.gif')+'"></p>');
	$.post(url, datos, function(data){
		$('#contenidoeditar').html(data);
		$('#formter').submit();
	})
})

function cerrar(ids){
	$('#'+ids).hide('blind');
}


function vermas(inicio) {
	$("#textocargar").html('Cargando...');
  
 	var ahora = $("input#inicio").val();
  	$("input#inicio").val(inicio+parseInt(ahora));

   	var url =  $("#formter").attr('action');
   	var datos = $("#formter").serialize();

  	$.post(url, datos, function( data ){
    	$("#cargarMas").remove();
    	$("#contenidoLista").append( data );
  	});
}

