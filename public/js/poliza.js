function cargarvistas(ptn,opc=''){
	/*
	ptn = carga de las vistas
	opc = si se desea agrue otra funcionalidad
	id  = id de la dua
	*/
	var label = document.getElementById("titulod");
	//var datos = '';

	switch(ptn){
		case 1:
			var datos = {file: $("#file").val()};
			if (opc) {
				$("#cargamodelo").hide();
				$("#cargaheader").show();
				var datos = $("#formodelo").serialize();
			}

			label.innerHTML = "<i class='glyphicon glyphicon-edit'>";
			label.innerHTML+= " Encabezado Poliza";
			var url = base_url('index.php/poliza/crear/encabezado/');

		break;
		case 2:
			label.innerHTML = "<i class='glyphicon glyphicon-list'>";
			label.innerHTML+= " Detalle de lineas";
			var url = base_url("index.php/poliza/detalle/duardetalle/" + opc);
			var datos = {file: $("#file").val()};

		break;
		case 3:
			label.innerHTML = "<i class='glyphicon glyphicon-file'>";
			label.innerHTML+= " Documentos para póliza";
			var url = base_url("index.php/poliza/documento/documento/" + opc);
			var datos = {file: $("#file").val()};
		break;

		default:
		return false;
		break;
	}

	cargando("contcuerpo");
	$.post(url, datos, function(data) {
		document.getElementById("contcuerpo").innerHTML = data;
		chosenselect();
	})
}

function empresanit(ars){
	var url = base_url('index.php/poliza/crear/empresanit/');
	var datos = {nit:ars.value};

	$.getJSON(url, datos, function(data) {
		document.getElementById("direc").value   = data.direccion;
		document.getElementById("nombre").value  = data.nombre;
		document.getElementById("declara").value = data.id;
	})
}

/* Para guardar el encabezado de la poliza */
function enviarhead(form) {
	var url = form.action;
	var datos = $(form).serialize();

	$.getJSON(url, datos, function(data){
		cargarvistas(1);
		$.notify(data.msj,data.res);

		$("#masopc").html("<li><a href='javascript:;' onclick='cargarvistas(1);'>Póliza</a></li><li><a href='javascript:;' onclick='cargarvistas(2);'>Detalle</a></li><li><a href='javascript:;' onclick='cargarvistas(3);'>Documento</a></li>")
		$("#seguir").notify(
					"Se habilitó más opciones",
					{position:"bottom right"}
					);
	});
}

function aplicatlc() {
    check = document.getElementById("tlc");

    if (check.checked) {
        $("#aplicatlc").show('blind');
    }
    else {
        $("#aplicatlc").hide('blind');
    }
}

/* Para guardar el detalle de la poliza */
function enviardetalle(form){
	var url = form.action;
	var datos = $(form).serialize();

	$.getJSON(url, datos, function(data) {
		$.notify(data.msj, data.res);
		cargarvistas(2,data.id);
	})
}

function verlista(opc){
	var datos = {file: $("#file").val()};
	switch(opc){
		case 1:
			var url = base_url('index.php/poliza/detalle/verlistadetalle');
		break;
		case 2:
			var url = base_url('index.php/poliza/documento/verlistadocumento');
		break;
		default:
		alert('Danger');
		break;
	}

	$.post(url, datos, function(data) {
		document.getElementById("contenidodetalle").innerHTML = data;
		$("#md-detalle").modal();
	})
}

/* Para guardar los documentos de soporte */
function enviardocumento(form){
	var url = form.action;
	var datos = $(form).serialize();

	$.getJSON(url, datos, function(data) {
		$.notify(data.msj, data.res);
		cargarvistas(3, data.id);
	})
}


function prorrateo(inp){
	var file = document.getElementById('file').value;
	var url = base_url('index.php/poliza/detalle/prorratear/' + file);

	$.getJSON(url, {itemfob : inp.value}, function (data) {
		$("#flete").val(data.flete);
		$("#seguro").val(data.seguro);
		$("#otros").val(data.otros);
		$("#cif").val(data.cif);
		$("#bulto").val(data.bulto);
	})
	
}

function eliminarfila(ars){
	switch(ars.opc) {
		case 1:
			var url = base_url('index.php/poliza/detalle/eliminardetalle')
		break;
		case 2:
			var url = ''
		break;
		default:
			return false;
		break;
	}

	var datos = ars;

	$.post(url, datos, function(data) {
		if (data == 1) {
			verlista(1);
			cargarvistas(2);
		} else {
			$.notify(data,"error");
		}
	})
}

function verproducto(inp){
	var url = base_url('index.php/poliza/detalle/buscar_producto');
	$.getJSON(url, {producto:inp.value},function(data) {
		$("#marca").val(data.marca);
		$("#numero").val(data.numeros);
		$("#part").val(data.partida);
		$("#sac").val(data.descripcion);
		$("#bulto").val(data.no_bultos);
		$("#pesoneto").val(data.peso_neto);
		$("#tipbulto option[value="+ data.tipo_bulto +"]").attr("selected",true);
		$("#origen option[value="+ data.paisorigen +"]").attr("selected",true);
		$("select").trigger("chosen:updated");
	})
}

function verdescription(inp) {
	var url    = base_url("index.php/poliza/detalle/setdescripcion_sac");
	var comple = $("#comple").val();

	var datos = {'codigo': inp.value};

	$.getJSON(url, datos, function(data) {
		$("#sac").val(data.descripcion);
	})
}