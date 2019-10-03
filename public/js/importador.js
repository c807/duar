function enviarformproducto(form){
	$("input#inicio").val(0);
	var url = form.action;
	var datos = $(form).serialize();

	$.post(url, datos, function(data) {
		document.getElementById('listaprod').innerHTML = data;
	})
}

function vermas(inicio) {
	$("#textocargar").html('Cargando...');
  
 	var ahora = $("input#inicio").val();
  	$("input#inicio").val(inicio+parseInt(ahora));

   	var url =  $("#formproducto").attr('action');
   	var datos = $("#formproducto").serialize();

  	$.post(url, datos, function( data ){
    	$("#cargarMas").remove();
    	$("#listaprod").append( data );
  	});
}

function editarprod(id){
	var url = base_url('index.php/mantenimiento/importador/formeditar/' + id);
	$('body,html').animate({scrollTop : 0}, 100);

	$.post(url, function (data) {
		document.getElementById('contenidoedita').innerHTML = data;
		$("#formedita").show('blind');
		$(".chosen").chosen({width:'100%'});
	})
}

function enviaredicion(form){
	var url = form.action;
	var datos = $(form).serialize();

	$.getJSON(url, datos, function (data) {
		editarprod(data.res);
		$("#formproducto").submit();
	})
}

function cerrar(id) {

	$("#"+id).hide('blind');
}