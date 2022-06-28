function base_url(url) {
	return window.location.origin + "/grupo_c807/duar/" + url;
}

function chosenselect(){
	$('.chosen').chosen({width:'100%'});
}

$(document).ready(function(){
	chosenselect();
})

function cargando(id){
	document.getElementById(id).innerHTML = '';
	var dir = base_url("public/img/cargando.gif");
	var img = document.createElement('p');
	img.className  = "text-center";
	img.innerHTML = "<img src='"+ dir + "' alt=''>";

	return document.getElementById(id).appendChild(img);
}

function cargalistaSol(){
	var afo = document.getElementById('selectAforador')

	let datos = {}
	if (afo && afo.value) {
		datos['margi'] = afo.value
	}

	var url = base_url('index.php/solicitud/solicitud/act_lista');
	cargando('contenidosolicitud');

	$.post(url,datos, function(data){
		document.getElementById("contenidosolicitud").innerHTML = data;
	})
}

function cargar_bitacora(file){
	var url   = base_url('index.php/bitacora/bitacora/verbitacora');
	var datos = {'file':file};
	cargando("contenidobitacora");
	document.getElementById("valorfile").value = file;

	$.post(url, datos, function(data) {
		document.getElementById("contenidobitacora"). innerHTML = data;
	})

}

function poliza(sts,id) {
	var url   = base_url('index.php/solicitud/solicitud/cambiar_status');
	var datos = { status:sts, id:id } ;
	var valido = true;
	if (sts == 5 ){
		valido = confirm("¿Está seguro de anular esta declaración?");
	}

	if (valido) {
		$.post(url, datos, function(data){
			cargalistaSol();
			cargar_bitacora(data);
			if (sts == 2) {
				window.location.href = base_url('index.php/poliza/crear/headerduar/' + data)
			}
		})
	}
}

function cerrar(id) {

	$("#"+id).hide('blind');
}