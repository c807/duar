//Esto es para subir archivos.

function base_url_erp(url) {
	//return base_url(url)
	return window.location.origin + "/grupo_c807/duar/" + url;
}

$(document).ready(function () {
	$("#cerrar1").click(function () {
		$("#actualizar_partida").hide();
	});
});

function cerrar($id_Reg) {
	$("#actualizar_partida" + $id_Reg).hide();
}

function no_clasificadas($opcion) {
	//Opcion 1 = productos no clasificados
	//Opcion 2 = todos los prodcutos

	var url = base_url_erp("index.php/Subir_archivo/no_clasificados/" + $opcion);

	datos = $("#c807_file").serialize();

	$.post(url, datos, function (data) {
		$("#no_clasificados").html(data);
	});
}

function mostrar_partida($id_Reg, $cod_importador) {
	$("#id_reg").val($id_Reg);
	$("#id").val($id_Reg);
	//alert($("#actualizar_partida") + $id_Reg);
	$("#actualizar_partida" + $id_Reg).show("blind");
	var url = base_url_erp(
		"index.php/Subir_archivo/traer_informacion_producto/" +
			$id_Reg +
			"/" +
			$cod_importador
	);
	$.get(url, function (data) {
		var str = data.pais_origen;
		var origen = str.toUpperCase();
		$("#proveedor" + $id_Reg).val(data.nombre_proveedor);
		$("#num_factura" + $id_Reg).val(data.num_factura);
		$("#codigo_producto" + $id_Reg).val(data.codigo_producto);
		$("#descripcion" + $id_Reg).val(data.descripcion);
		$("#importador" + $id_Reg).val(data.importador);
		$("#pais_origen" + $id_Reg).val(origen);
		$("#id_reg" + $id_Reg).val(data.id);
		$("#id").val($id_Reg);
		$("#partida_arancelaria" + $id_Reg).val("");
	});
}

function crear_partida($id_Reg) {
	var url = base_url_erp("index.php/Subir_archivo/grabar_partida/" + $id_Reg);
	datos = $("#partida" + $id_Reg).serialize();
	$.post(url, datos, function (data) {
		if (data.mensaje) {
			alert(data.mensaje);
		} else {
			// $.notify("Partida Arancelaria creada." , "success" );
			$("#actualizar_partida".$id_Reg).hide("slow");
			no_clasificadas(1);
		}
	});
}

//Revisar esta funcion
function generar_archivo() {
	generar_rayado();
	generar_excel();
}

function generar_excel() {
	var url = base_url_erp("index.php/Subir_archivo/generar_excel/");

	$num_file = $("#c807_file").val();
	$doc_tra = $("#doc_transporte").val();
	$t_bultos = $("#tot_bultos").val();
	$t_kilos = $("#tot_kilos").val();

	$mensaje = "";

	if ($num_file.length == 0) {
		$mensaje = "numero de File";
	}
	if ($doc_tra.length == 0) {
		$mensaje += ", documento de transporte";
	}
	if ($t_bultos.length == 0) {
		$mensaje += ", total bultos";
	}
	if ($t_kilos.length == 0) {
		$mensaje += ", total kilos.";
	}

	if ($mensaje.length > 0) {
		$mesnsaje = "numero de File.";
		$.notify("Falta digitar " + $mensaje, "error");
	} else {
		window.location.href =
			url +
			"?" +
			$("#c807_file").serialize() +
			"&" +
			$("#doc_transporte").serialize() +
			"&" +
			$("#tot_bultos").serialize() +
			"&" +
			$("#tot_kilos").serialize();
		$.notify("Archivo de Excel Generado.", "success");
	}
}

function generar_excel_sidunea() {
	var url = base_url_erp("index.php/Subir_archivo/generar_excel_sidunea/");

	$num_file = $("#c807_file").val();
	$doc_tra = $("#doc_transporte").val();
	$t_bultos = $("#tot_bultos").val();
	$t_kilos = $("#tot_kilos").val();

	$mensaje = "";

	if ($num_file.length == 0) {
		$mensaje = "numero de File";
	}
	if ($doc_tra.length == 0) {
		$mensaje += ", documento de transporte";
	}
	if ($t_bultos.length == 0) {
		$mensaje += ", total bultos";
	}
	if ($t_kilos.length == 0) {
		$mensaje += ", total kilos.";
	}

	if ($mensaje.length > 0) {
		$mesnsaje = "numero de File.";
		$.notify("Falta digitar " + $mensaje, "error");
	} else {
		window.location.href =
			url +
			"?" +
			$("#c807_file").serialize() +
			"&" +
			$("#doc_transporte").serialize() +
			"&" +
			$("#tot_bultos").serialize() +
			"&" +
			$("#tot_kilos").serialize();
		$.notify("Archivo de Excel Generado.", "success");
	}
}

function generar_excel_dva() {
	var url = base_url_erp("index.php/Subir_archivo/generar_excel_dva/");

	$num_file = $("#c807_file").val();
	$doc_tra = $("#doc_transporte").val();
	$t_bultos = $("#tot_bultos").val();
	$t_kilos = $("#tot_kilos").val();

	$mensaje = "";

	if ($num_file.length == 0) {
		$mensaje = "numero de File";
	}
	if ($doc_tra.length == 0) {
		$mensaje += ", documento de transporte";
	}
	if ($t_bultos.length == 0) {
		$mensaje += ", total bultos";
	}
	if ($t_kilos.length == 0) {
		$mensaje += ", total kilos.";
	}

	if ($mensaje.length > 0) {
		$mesnsaje = "numero de File.";
		$.notify("Falta digitar " + $mensaje, "error");
	} else {
		window.location.href =
			url +
			"?" +
			$("#c807_file").serialize() +
			"&" +
			$("#doc_transporte").serialize() +
			"&" +
			$("#tot_bultos").serialize() +
			"&" +
			$("#tot_kilos").serialize();
		$.notify("Archivo de Excel Generado.", "success");
	}
}

function generar_rayado() {
	var url = base_url_erp("index.php/Subir_archivo/generar_rayado/");
	$datos = $("#c807_file").val();

	if ($datos == null || $datos == undefined || $datos.length == 0) {
		$.notify("Falta digitar número de file.", "error");
	} else {
		window.location.href = url + "?" + $("#c807_file").serialize();
		$.notify("Archivo PDF generado.", "success");
	}
}

function enviar_correo($opcion) {
	//$opcion 1 de Aforador a Clasificador
	//$opcion 2 de Clasificacdor a Aforador

	var url = base_url_erp("index.php/Subir_archivo/enviar_correo/" + $opcion);
	$datos = $("#c807_file").serialize();

	$.get(url, $datos, function (data) {
		$.notify(data, "success");
	});
}

function no_clasificadas_new($opcion) {
	//Opcion 1 = productos no clasificados
	//Opcion 2 = todos los prodcutos

	var url = base_url_erp("index.php/Subir_archivo/no_clasificados/" + $opcion);

	datos = $("#c807_file").serialize();

	$.post(url, datos, function (data) {
		$("#no_clasificados").html(data);
	});
}

function lista_retaceo() {
	var verifica = verificar_input_retaceo();
	if (verifica === 0) {
		return false;
	}
	var file = $("#c807_file").val();
	var documento = $("#doc_transporte").val();
	var id_file;
	var url = base_url("index.php/Subir_archivo/get_id_file/" + file);
	$.getJSON(url, { producto: file.value }, function (data) {
		id_file = data.id;

		var url = base_url(
			"index.php/Subir_archivo/lista_retaceo/" + id_file + "/" + documento
		);
		$.get(url, function (data) {
			$("#p_origen").hide();
			$("#item_pa").hide();
			$("#panel_lista").show();

			document.getElementById("contenidoLista").innerHTML = data;
		});
	});
}

function cuadro_duca() {
	var verifica = verificar_input_retaceo();
	if (verifica === 0) {
		return false;
	}
	var file = $("#c807_file").val();
	var id_file;
	var url = base_url("index.php/Subir_archivo/get_id_file/" + file);
	$.getJSON(url, { producto: file.value }, function (data) {
		id_file = data.id;

		var formData;
		url_destino = "index.php/Subir_archivo/cuadro_duca/" + id_file;
		formData = new FormData($(".retaceo")[0]);
		$.ajax({
			url: base_url(url_destino),
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				pdf_retaceo(file);
			},
			error: function () {},
		});
	});
}

function pdf_retaceo(ruta) {
	var loc = window.location;

	var url = ruta;
	window.open(
		base_url(url + ".pdf"),
		"ventana1",
		"width=600,height=600,scrollbars=no,toolbar=no, titlebar=no, menubar=no"
	);
}
function mostrar_origen() {
	$(function () {
		$("#tabla").on("dblclick", "tbody tr", function (event) {
			var arancelId = this.cells[1].innerHTML;

			var url = base_url("index.php/Subir_archivo/lista_origen/" + arancelId);

			$.get(url, function (data) {
				$("#panel_lista_adjuntos").show();
				$("#detalle").modal("show");
				document.getElementById("contenido_lista_origen").innerHTML = data;
			});
		});
	});
}

function get_detalle_dpr() {
	var file = $("#file_number").val();
	var id_file;
	var url = base_url("index.php/Subir_archivo/get_id_file/" + file);
	$.getJSON(url, { producto: file.value }, function (data) {
		id_file = data.id;
		var dua = document.getElementById("id_dua").value;
		var url = base_url("index.php/Subir_archivo/get_detalle_dpr/" + id_file);
		$.get(url, function (data) {
			$.notify("Proceso finalizado con exito", "success");
			lista_items(dua);
		});
	});
}

function lista_cambiar_origen() {
	var verifica = verificar_input_retaceo();
	if (verifica === 0) {
		return false;
	}
	var file = $("#c807_file").val();
	var id_file;
	var url = base_url("index.php/Subir_archivo/get_id_file/" + file);
	$.getJSON(url, { producto: file.value }, function (data) {
		id_file = data.id;

		var url = base_url(
			"index.php/Subir_archivo/lista_cambiar_origen/" + id_file
		);
		$.get(url, function (data) {
			$("#p_origen").show();
			$("#item_pa").show();
			$("#panel_lista").show();
			document.getElementById("contenidoLista").innerHTML = data;
		});
	});
}
function cambiar_origen(pais) {
	$("#EditarOrigen").modal("show");
	$("#id").val(pais);
}

function guardar_origen() {
	var url = base_url(
		"index.php/Subir_archivo/cambiar_origen/" +
			$("#paises").val() +
			"/" +
			$("#id").val()
	);
	$.post(url, function (data) {
		lista_cambiar_origen();
		$("#EditarOrigen").modal("hide");
	});
}

function verificar_input_retaceo() {
	if ($("#c807_file").val().length == 0) {
		$.notify("Ingrese numero de file", "warning");
		return 0;
	}
	if ($("#doc_transporte").val().length == 0) {
		$.notify("Ingrese documento de transporte", "warning");
		return 0;
	}
}
