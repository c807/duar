function base_url(url) {
	return window.location.origin + "/grupo_c807/duar/" + url;
}

function gestion_productos(opcion) {
	var formData;
	var valido = "S";

	if (opcion == "c") {
		url_destino = "index.php/productos/ProductosController/crear_productos/";
		formData = new FormData($(".add_producto")[0]);
	}

	if (valido == "S") {
		var message = "";
		$.ajax({
			url: base_url(url_destino),
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				var accion = "";
				if (response == "existe") {
					$("#message").html(
						'<div class="alert alert-success alertred "><button type="button" class="close">x</button><strong>Código de producto ya esta registrado en BDD</strong></div>'
					);

					document.getElementById("lista_duplicados").innerHTML = "";
					alert_hide();
					return false;
				}
				if (response == "true") {
					if ($("#producimport").val().length == 0) {
						//$("#importador").val("");
						$("#codproducto").val("");
						$("#descripcion").val("");
						$("#descripcion_generica").val("");
						$("#funcion").val("");
						$("#partida").val("");
						$("#observaciones").val("");
						$("#tlc").prop("checked", false);
						$("#permiso").prop("checked", false);
						$("#marca").val("");
						$("#proveedor").val("");
						$.notify("Producto guardado.", "success");
					} else {
						$.notify("Los cambios han sido guardados", "success");
						CerrarModal();
					}

					document.getElementById("msg").innerHTML = "";
					document.getElementById("lista_duplicados").innerHTML = "";
				} else {
					$("#message").html(
						'<div class="alert alert-success alertred "><button type="button" class="close">x</button><strong>Error: No ha sido posible guardar producto</strong></div>'
					);
				}
				if ($("#producimport").val() > 0) {
					var id = $("#producimport").val();
					var url = base_url(
						"index.php/productos/ProductosController/consulta/" +
							id +
							"/" +
							$("#importador").val()
					);
					$.post(url, function (data) {
						document.getElementById("listaprod").innerHTML = data;
					});
				}

				
			},
		});
	}
}

function subir_productos() {
	var formData;
	url_destino = "index.php/productos/ProductosController/cargar_desde_archivo/";
	formData = new FormData($(".up_productos")[0]);

	$.ajax({
		url: base_url(url_destino),
		type: "POST",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		success: function (response) {
			if (response == 1) {
				$("#messagefile").html(
					'<div class="alert alert-success alertgreen "><button type="button" class="close">x</button><strong>Proceso ha finalizado correctamente.</strong></div>'
				);
				$("#file").val("");
				alert_hide();
			}
			if (response == 0) {
				var url = base_url(
					"index.php/productos/ProductosController/consulta_duplicados/"
				);

				$.post(url, function (data) {
					document.getElementById("listaprod").innerHTML = "";
					$("#msg").html(
						'<div class="alert alert-danger alertred "><button type="button" class="close">x</button><strong>Los sguientes productos, ya existen en la Base de Datos (Proceso Cancelado)</strong></div>'
					);
					document.getElementById("lista_duplicados").innerHTML = data;
				});
			}
		},
	});
}

function borrar_productos() {
	var formData;
	url_destino = "index.php/productos/ProductosController/borrar_producto/";
	formData = new FormData($(".del_producto")[0]);

	$.ajax({
		url: base_url(url_destino),
		type: "POST",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		success: function (data) {
			$.notify("Producto ha sido eliminado.", "success");
			document.getElementById("msg").innerHTML = "";
			document.getElementById("lista_duplicados").innerHTML = "";
			document.getElementById("listaprod").innerHTML = "";
		},
	});
}
function mostrarModal(titulo) {
	$("#modalTitle").html(titulo);

	$("#crear_producto").modal("show");
}
function mostrar(valor) {
	modal_producto_importador(valor);
	$("#crear_producto").on("show.bs.modal", function (e) {
		var bookId = $(e.relatedTarget).data("book-id");
		var bookId1 = $(e.relatedTarget).data("book-id1");
		var bookId2 = $(e.relatedTarget).data("book-id2");
		var bookId3 = $(e.relatedTarget).data("book-id3");
		var bookId4 = $(e.relatedTarget).data("book-id4");
		var bookId5 = $(e.relatedTarget).data("book-id5");
		var bookId6 = $(e.relatedTarget).data("book-id6");
		var bookId7 = $(e.relatedTarget).data("book-id7");
		var bookId8 = $(e.relatedTarget).data("book-id8");
		var bookId9 = $(e.relatedTarget).data("book-id9");
		var bookId10 = $(e.relatedTarget).data("book-id10");
		var bookId14 = $(e.relatedTarget).data("book-id14");
		var bookId16 = $(e.relatedTarget).data("book-id16");
		var bookId17 = $(e.relatedTarget).data("book-id17");
		var bookId18 = $(e.relatedTarget).data("book-id18");
		var bookId19 = $(e.relatedTarget).data("book-id19");
		var bookId20 = $(e.relatedTarget).data("book-id20");
		var bookId21 = $(e.relatedTarget).data("book-id21");

		$(e.currentTarget).find('input[name="producimport"]').val(bookId);
		$(e.currentTarget).find('input[name="importador"]').val(bookId1);
		$(e.currentTarget).find('input[name="codproducto"]').val(bookId2);
		$(e.currentTarget).find('textarea[name="descripcion"]').val(bookId3);
		$(e.currentTarget)
			.find('textarea[name="descripcion_generica"]')
			.val(bookId4);
		$(e.currentTarget).find('textarea[name="funcion"]').val(bookId5);
		$(e.currentTarget).find('input[name="partida"]').val(bookId6);
		$(e.currentTarget).find('textarea[name="observaciones"]').val(bookId7);
		$(e.currentTarget).find('checked[name="permiso"]').val(bookId8);
		$(e.currentTarget).find('checked[name="tlc"]').val(bookId9);

		if (bookId8 == 1) {
			$(e.currentTarget).find('input[name="permiso"]').prop("checked", true);
		} else {
			$(e.currentTarget).find('input[name="permiso"]').prop("checked", false);
		}

		if (bookId9 == 1) {
			$(e.currentTarget).find('input[name="tlc"]').prop("checked", true);
		} else {
			$(e.currentTarget).find('input[name="tlc"]').prop("checked", false);
		}

		if (bookId17 == 1) {
			$(e.currentTarget).find('input[name="fito"]').prop("checked", true);
		} else {
			$(e.currentTarget).find('input[name="fito"]').prop("checked", false);
		}

		$(e.currentTarget).find('input[name="proveedor"]').val(bookId10);
		$(e.currentTarget).find('input[name="marca"]').val(bookId14);

		$("#paises").val(bookId16);
		$("#paises").change();
		$("#importador").val(bookId1);
		$("#importador").change();

		$("#estados").val(bookId18);
		$("#estados").change();

		$("#u_comercial").val(bookId19);
		$("#u_comercial").change();

		$("#pais_procedencia").val(bookId20);
		$("#pais_procedencia").change();

		$("#pais_adquisicion").val(bookId21);
		$("#pais_adquisicion").change();

		$("#pais_procedencia").val(bookId20).trigger("chosen:updated.chosen");
		$("#pais_adquisicion").val(bookId21).trigger("chosen:updated.chosen");

		$("#estados").val(bookId18).trigger("chosen:updated.chosen");
		$("#u_comercial").val(bookId19).trigger("chosen:updated.chosen");

		$("#paises").val(bookId16).trigger("chosen:updated.chosen");
		$("#importador").val(bookId1).trigger("chosen:updated.chosen");
		$(".chosen").chosen({ width: "100%" });
		//document.ready = document.getElementById("paises").value=bookId15; esto tambien funciona
	});
	ocultar_elementos_dpr();
}
function mostrarficha() {
	$("#verficha").on("show.bs.modal", function (e) {
		var bookId = $(e.relatedTarget).data("book-id");
		var bookId1 = $(e.relatedTarget).data("book-id1");
		var bookId2 = $(e.relatedTarget).data("book-id2");
		var bookId3 = $(e.relatedTarget).data("book-id3");
		var bookId4 = $(e.relatedTarget).data("book-id4");
		var bookId5 = $(e.relatedTarget).data("book-id5");
		var bookId6 = $(e.relatedTarget).data("book-id6");
		var bookId7 = $(e.relatedTarget).data("book-id7");
		var bookId8 = $(e.relatedTarget).data("book-id8");
		var bookId9 = $(e.relatedTarget).data("book-id9");
		var bookId10 = $(e.relatedTarget).data("book-id10");
		var bookId11 = $(e.relatedTarget).data("book-id11");
		var bookId12 = $(e.relatedTarget).data("book-id12");
		var bookId13 = $(e.relatedTarget).data("book-id13");
		var bookId14 = $(e.relatedTarget).data("book-id14");
		var bookId15 = $(e.relatedTarget).data("book-id15");
		var bookId16 = $(e.relatedTarget).data("book-id16");
		var bookId17 = $(e.relatedTarget).data("book-id17");
		var bookId18 = $(e.relatedTarget).data("book-id18");
		var bookId19 = $(e.relatedTarget).data("book-id19");

		$(e.currentTarget).find('label[name="producimport"]').val(bookId);
		$(e.currentTarget).find('input[name="importador"]').val(bookId1);
		$(e.currentTarget).find('input[name="codproducto"]').val(bookId2);
		$(e.currentTarget).find('textarea[name="descripcion"]').val(bookId3);
		$(e.currentTarget)
			.find('textarea[name="descripcion_generica"]')
			.val(bookId4);
		$(e.currentTarget).find('textarea[name="funcion"]').val(bookId5);
		$(e.currentTarget).find('input[name="partida"]').val(bookId6);
		$(e.currentTarget).find('textarea[name="observaciones"]').val(bookId7);
		$(e.currentTarget).find('checked[name="permiso"]').val(bookId8);
		$(e.currentTarget).find('checked[name="tlc"]').val(bookId9);

		if (bookId8 == 1) {
			$(e.currentTarget).find('input[name="permiso"]').prop("checked", true);
		} else {
			$(e.currentTarget).find('input[name="permiso"]').prop("checked", false);
		}

		if (bookId9 == 1) {
			$(e.currentTarget).find('input[name="tlc"]').prop("checked", true);
		} else {
			$(e.currentTarget).find('input[name="tlc"]').prop("checked", false);
		}
		$(e.currentTarget).find('input[name="proveedor"]').val(bookId10);
		$(e.currentTarget).find('input[name="pesoneto"]').val(bookId11);
		$(e.currentTarget).find('input[name="numeros"]').val(bookId12);
		$(e.currentTarget).find('input[name="nbultos"]').val(bookId13);
		$(e.currentTarget).find('input[name="marca"]').val(bookId14);

		/* esta es otra forma de hacerlo
        var modal = $(this)
        modal.find('.modal-body #tipobulto').val(bookId15)
        */
		$("#tipobulto").val(bookId15);
		$("#tipobulto").change();
		$("#paises").val(bookId16);
		$("#paises").change();

		$(e.currentTarget).find('input[name="paisorigen"]').val(bookId17);
		$(e.currentTarget).find('input[name="descripcion_bulto"]').val(bookId18);
		$(e.currentTarget).find('input[name="nombre_importador"]').val(bookId19);

		//document.ready = document.getElementById("tipobulto").value=bookId15; esto tambien funciona
	});
}

function datos_borrar(valor) {
	modal_producto_importador(valor);
	$("#borrar_producto").on("show.bs.modal", function (e) {
		var bookId = $(e.relatedTarget).data("book-id");
		var bookId1 = $(e.relatedTarget).data("book-id1");
		var bookId2 = $(e.relatedTarget).data("book-id2");

		$(e.currentTarget).find('input[name="txtcodigo"]').val(bookId);
		$(e.currentTarget).find('input[name="txtnombre"]').val(bookId1);
		$(e.currentTarget).find('input[name="txtidproducto"]').val(bookId2);
	});
}

function alert_hide() {
	window.setTimeout(function () {
		$(".alert")
			.fadeTo(500, 0)
			.slideUp(500, function () {
				$(this).remove();
			});
	}, 5000);
	$(".alert .close").on("click", function (e) {
		$(this).parent().fadeTo(500, 0).slideUp(500);
	});
}
function CerrarModal() {
	$("#crear_producto").modal("hide");
	$("body").removeClass("modal-open");
	$(".modal-backdrop").remove();
}
function cerrar_modal_delete() {
	$("#borrar_producto").modal("hide");
	$("body").removeClass("modal-open");
	$(".modal-backdrop").remove();
}
function modal_producto_importador(valor) {
	var url = base_url("index.php/poliza/crear/verifica_permiso/" + valor);
	$.getJSON(url, { usuario: valor.value }, function (data) {
		//data.permiso = 0;
		if (data.permiso == 0) {
			if (valor == 2) {
				CerrarModal();
			}
			if (valor == 3) {
				cerrar_modal_delete();
			}

			$.notify("No esta autorizado para realizar esta operación", "error");
		} else {
			if (valor == 1) {
				// agregar producto
				$("#crear_producto").modal();
			}

			if (valor == 2) {
			}

			if (valor == 3) {
			}

			if (valor == 6) {
				// opciones de busqueda
				$("#buscar").modal();
			}

			if (valor == 7) {
				// subir desde archivo excel
				$("#upModal").modal();
			}
		}
	});
}

function ocultar_elementos_dpr() {
	pais = $("#pais_id").val();
	if (pais == 2) {
		$(".hn").hide();
	}
}
