$(document).ready(function(){
	$('select').chosen({width:'100%'});
})

function base_url(url){
	return window.location.origin + '/grupo_c807/duar/' + url;
}


function vernombrepresa(id){
	var url = base_url('index.php/poliza/crear/verempresa/'+id);

	$.getJSON(url,function(data){
		$('#declarante').val(data.id);
		$('#nomdeclarante').val(data.nombre);

	})
}

function eliminardetalle(iddua, ldetalle){
	var url   =  base_url('index.php/poliza/arancelaria/eliminardetalle/'+ iddua);
	var datos = {
		 			'linea': ldetalle
		 		};
	$.post(url,datos,function(data){
		window.location.href = base_url('index.php/poliza/arancelaria/detalle/'+ iddua);
	})
}

///   FUNCION PARA MOSTRAR SUGERENCIA

function sugerencia (iddua, codigo) {
	var url   =  base_url('index.php/poliza/arancelaria/buscar_sugerencia/'+ iddua);
	var datos =  { 
				'codigo':codigo
				} 

	$.getJSON(url, datos, function(data){
		$('#marcas').val(data.marcas);
		$('#numero').val(data.numeros);
		$('#partida').val(data.partida);
		$('#comple').val(data.comple);
		$('#num_bultos').val(data.no_bultos);
		$('#origen option[value="'+data.origen+'"]').attr('selected', true);
		$('#tipo_bulto').val(data.tipo_bulto);
		$('#cuantia').val(data.cuantia);
		$('#peso_neto').val(data.peso_neto);
		$('#descripcion').val(data.descripcion);
	})
}

function eliminardoc(id, iddua){
	var url = base_url('index.php/poliza/documentosop/eliminar/' + id);

	$.post(url, function(data){
		window.location.href = base_url('index.php/poliza/documentosop/docsoporte/'+ iddua);		
	})
}

function prorrateo(val){
	var url = base_url('index.php/poliza/arancelaria/prorrateo');
	var datos = {
			'iddua':$('#duaduana').val(),
			'cantidad': val 
			};

	$.getJSON(url, datos, function(data){

		if (data.error == 1 && $('#detalle').val() == '') {
			alert('El valor del FOB total ya esta distribuido');
		} else {
			$('#flete').val(data.flete);
			$('#seguro').val(data.seguro);
			$('#otros').val(data.otros);
		}
	})
}

function listas(id){
	$(id).toggle('blind');
}