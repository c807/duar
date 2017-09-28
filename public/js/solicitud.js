function actualizalista(){
	var url = base_url('index.php/solicitud/solicitudes/actualizalista');
	
	$.post(url,function(data){
		$('#contenidosolicitud').html(data);	
	})
}

function accionesduar(id, tipo, file){
	var url = base_url('index.php/solicitud/solicitudes/acciones_solicitudes/' + id);
	var datos = {'tipo':tipo, 'file':file };

	$.post(url, datos, function(data){
		actualizalista();
		cargarbitacora(file);
	})
}