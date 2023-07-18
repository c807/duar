function cargarvistas(ptn, opc = "") {
    /*
    ptn = carga de las vistas
    opc = si se desea agrue otra funcionalidad
    id  = id de la dua
    */
    var label = document.getElementById("titulod");
    //var datos = '';

    switch (ptn) {
        case 1:
            var datos = {
                file: $("#file").val()
            };
            if (opc) {
                $("#cargamodelo").hide();
                $("#cargaheader").show();
                var datos = $("#formodelo").serialize();
            }

            label.innerHTML = "<i class='glyphicon glyphicon-edit'>";
            label.innerHTML += " Encabezado Poliza";
            var url = base_url("index.php/poliza/crear/encabezado/");

            break;
        case 2:
            label.innerHTML = "<i class='glyphicon glyphicon-list'>";
            label.innerHTML += " Detalle de lineas";
            var url = base_url("index.php/poliza/detalle/duardetalle/" + opc);
            var datos = {
                file: $("#file").val()
            };

            break;
        case 3:
            label.innerHTML = "<i class='glyphicon glyphicon-file'>";
            label.innerHTML += " Documentos para póliza";
            var url = base_url("index.php/poliza/documento/documento/" + opc);
            var datos = {
                file: $("#file").val()
            };
            break;

        default:
            return false;
            break;
    }

    cargando("contcuerpo");
    $.post(url, datos, function(data) {
        document.getElementById("contcuerpo").innerHTML = data;
        chosenselect();
    });
}

function empresanit(ars) {

    alert(ars);
    /*var url = base_url('index.php/poliza/crear/empresanit/');
    var datos = {nit:ars.value};

    $.getJSON(url, datos, function(data) {
    	//document.getElementById("direc").value   = data.direccion;
    	//document.getElementById("nombre").value  = data.nombre;
    	document.getElementById("declara").value = data.empresa;
    })*/
}

/* Para guardar el encabezado de la poliza */
function enviarhead(form) {
    var url = form.action;
    var datos = $(form).serialize();

    $.getJSON(url, datos, function(data) {
        cargarvistas(1);
        $.notify(data.msj, data.res);

        $("#masopc").html(
            "<li><a href='javascript:;' onclick='cargarvistas(1);'>Póliza</a></li><li><a href='javascript:;' onclick='cargarvistas(2);'>Detalle</a></li><li><a href='javascript:;' onclick='cargarvistas(3);'>Documento</a></li>"
        );
        $("#seguir").notify("Se habilitó más opciones", {
            position: "bottom right"
        });
    });
}

function aplicatlc() {
    check = document.getElementById("tlc");

    if (check.checked) {
        $("#aplicatlc").show("blind");
    } else {
        $("#aplicatlc").hide("blind");
    }
}

/* Para guardar el detalle de la poliza */
function enviardetalle(form) {
    var url = form.action;
    var datos = $(form).serialize();

    $.getJSON(url, datos, function(data) {
        $.notify(data.msj, data.res);
        cargarvistas(2, data.id);
    });
}

function verlista(opc) {
    var datos = {
        file: $("#file").val()
    };
    switch (opc) {
        case 1:
            var url = base_url("index.php/poliza/detalle/verlistadetalle");
            break;
        case 2:
            var url = base_url("index.php/poliza/documento/verlistadocumento");
            break;
        default:
            alert("Danger");
            break;
    }

    $.post(url, datos, function(data) {
        document.getElementById("contenidodetalle").innerHTML = data;
        $("#md-detalle").modal();
    });
}

/* Para guardar los documentos de soporte */
function enviardocumento(form) {
    var url = form.action;
    var datos = $(form).serialize();

    $.getJSON(url, datos, function(data) {
        $.notify(data.msj, data.res);
        cargarvistas(3, data.id);
    });
}

function prorrateo(inp) {
    var file = document.getElementById("file").value;
    var url = base_url("index.php/poliza/detalle/prorratear/" + file);

    $.getJSON(url, {
        itemfob: inp.value
    }, function(data) {
        $("#flete").val(data.flete);
        $("#seguro").val(data.seguro);
        $("#otros").val(data.otros);
        $("#cif").val(data.cif);
        $("#bulto").val(data.bulto);
    });
}

function eliminarfila(ars) {
    switch (ars.opc) {
        case 1:
            var url = base_url("index.php/poliza/detalle/eliminardetalle");
            break;
        case 2:
            var url = "";
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
            $.notify(data, "error");
        }
    });
}

function verproducto(inp) {
    var url = base_url("index.php/poliza/detalle/buscar_producto");
    $.getJSON(url, {
        producto: inp.value
    }, function(data) {
        $("#marca").val(data.marca);
        $("#numero").val(data.numeros);
        $("#part").val(data.partida);
        $("#sac").val(data.descripcion);
        $("#bulto").val(data.no_bultos);
        $("#pesoneto").val(data.peso_neto);
        $("#tipbulto option[value=" + data.tipo_bulto + "]").attr("selected", true);
        $("#origen option[value=" + data.paisorigen + "]").attr("selected", true);
        $("select").trigger("chosen:updated");
    });
}

function verdescription(inp) {
    var url = base_url("index.php/poliza/detalle/setdescripcion_sac");
    var comple = $("#comple").val();

    var datos = {
        codigo: inp.value
    };

    $.getJSON(url, datos, function(data) {
        $("#sac").val(data.descripcion);
    });
}

function SubirXLS() {
    var declaracion = $("input[name=duaduana]").val();
    var url =
        base_url("index.php/poliza/detalle/form_xls_detalle/") + declaracion;
    cargando("contenidodetalle");

    $.post(url, function(data) {
        document.getElementById("contenidodetalle").innerHTML = data;
    });

    $("#md-detalle").modal();
}

function enviarXls(form) {
    var conf = confirm("¿Está seguro de realizar esta acción?");
    if (conf) {
        cargando("carga");

        var data = new FormData($(form)[0]);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", form.action, true);

        xhr.onload = function() {
            var res = JSON.parse(this.response);
            if (res.exito) {
                document.getElementById("respuesta").innerHTML = res.mensaje;
                $("#contenidoxls").hide("blind");
                cargarvistas(2);
            } else {
                document.getElementById("carga").innerHTML = "";
            }
        };

        xhr.send(data);
    }
}

function guardar_seg_general(file) {
 //   alert($("#selectregext").val());

    var formData;
    url_destino = "index.php/poliza/crear/guardar_seg_general/";
    
    formData = new FormData($(".form_sg")[0]);
    $.ajax({
        url: base_url(url_destino),
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
        
            get_dua(file);
            $.notify("Encabezado de poliza  ha sido guardada con exito", "success");
        },
        error: function() {
            $.notify("Ha ocurrido un error, operacion ha sido cancelada", "error");
        }
    });
}

function guardar_items() {
    var formData;
    url_destino = "index.php/poliza/crear/guardar_items";
    formData = new FormData($(".form_item")[0]);
    $.ajax({
        url: base_url(url_destino),
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            var dua = document.getElementById("id_dua").value;
            lista_items(dua);
            limpiar_input_item();
            $.notify("Item  ha sido guardada con exito", "success");
        },
        error: function() {
            $.notify("Ha ocurrido un error, operacion ha sido cancelada", "error");
        }
    });
}

function add_adjunto(id, dua, num_item) {
    var formData;
    url_destino = "index.php/poliza/crear/guardar_adjunto/" + id + "/" + dua + "/" + num_item;
    formData = new FormData($(".form_adjunto")[0]);
    $.ajax({
        url: base_url(url_destino),
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            var item = document.getElementById("item_adjunto").value;
            var dua = document.getElementById("dua_adjunto").value;
            if (id == 0) {
                reload(item, dua);
            }

        },
        error: function() {

        }
    });
    //  $.notify("Ha ocurrido un error, operacion ha sido cancelada", "error");
}

function reload(item, dua) {
    lista_adjuntos(item, dua);
    limpiar_input_adjuntos();
    $.notify("documento  ha sido guardada con exito", "success");
}
/*guarda informacion de los archivos adjuntos */
function guardar_adjunto() {
    op = $("#id_opc").val();
    if (op == 1) {
        add_adjunto(0, 0, 0);

    } else {


        id_dua = $('#id_dua').val()
            //   ruta = ($('#file_up').val());


        var filas = $("#tbl_items").find("tr");
        opc = 1;
        for (i = 1; i < filas.length; i++) {
            var celdas = $(filas[i]).find("td");
            id_item = $(celdas[0]).text();


            if ($("#chk" + opc).is(":checked")) {

                add_adjunto(id_item, id_dua, opc);
            } else {}
            opc = opc + 1;
        }

        $.notify("Documento adjunto ha sido guardado con éxito ", "success ");


    }

}

/* asigna  el numero de poliza */
function get_dua(file) {
    var url = base_url("index.php/poliza/crear/get_dua/" + file);
    $.getJSON(url, {
        producto: file.value
    }, function(data) {
        $("#id_dua").val(data.duaduana);
        $("#id_dua_i").val(data.duaduana);
    });
}
/* muestra los items de la poliza*/
function lista_items(dua) {
    var url = base_url("index.php/poliza/crear/lista_items/" + dua);
    $.post(url, function(data) {
        $("#panel_lista").show();
        document.getElementById("contenidoLista").innerHTML = data;
    });
}

/* muesta en ventana modal el numero de item y el numero de poliza para cuado se edite una fila */

function get_item_adjunto() {
    $("#add_adjuntos").on("show.bs.modal", function(e) {
        var bookId = $(e.relatedTarget).data("book-id");
        var bookId1 = $(e.relatedTarget).data("book-id1");

        $(e.currentTarget)
            .find('input[name="item_adjunto"]')
            .val(bookId);
        $(e.currentTarget)
            .find('input[name="dua_adjunto"]')
            .val(bookId1);
        lista_adjuntos(bookId, bookId1);
    });
}

/* muestra la lista de adjuntos de un item deteminado y muestra informacióon en tabla */
function lista_adjuntos(item, dua) {
    $("#id_opc").val(1);
    var url = base_url(
        "index.php/poliza/crear/lista_adjuntos/" + item + "/" + dua
    );
    $.get(url, function(data) {
        $("#panel_lista_adjuntos").show();
        document.getElementById("contenidoLista_adjuntos").innerHTML = data;
    });
}
/* consulta un documento adjunto y los muestr en formulario */
function consulta_adjunto(doc) {
    var url = base_url("index.php/poliza/crear/consulta_adjunto/" + doc);
    $.getJSON(url, {
        producto: doc.value
    }, function(data) {
        $("#doc_adjunto").val(data.tipodocumento);
        $("#referencia_doc").val(data.referencia);
        $("#fecha_doc").val(data.fecha_documento);
        $("#fecha_exp").val(data.fecha_expiracion);
        $("#codigo_pais_adj").val(data.id_pais);
        $("#codigo_entidad").val(data.id_entidad);
        $("#otra_entidad").val(data.otra_entidad);
        $("#monto_autorizado").val(data.monto_autorizado);
        $("#id_doc").val(doc);
        $("select").trigger("chosen:updated");
    });
}
/* consulta un items y los muestra info en formulario */
function consulta_item(doc) {

    var url = base_url("index.php/poliza/crear/consulta_item/" + doc);
    $.getJSON(url, {
        producto: doc.value
    }, function(data) {
        $("#marcas_num_uno").val(data.marcas_uno);
        $("#marcas_num_dos").val(data.marcas_dos);
        $("#numero_paquetes").val(data.no_bultos);
        $("#embalaje").val(data.tipo_bulto);
        $("#codigo_mercancia").val(data.partida);
        $("#descripcion_comercial").val(data.descripcion);
       // $("#codigo_mercancia").blur();
        $("#pais_origen_item").val(data.origen);
        $("#peso_bruto").val(data.peso_bruto);
        $("#peso_neto").val(data.peso_neto);
        $("#preferencia").val(data.codigo_preferencia);
        $("#cuota").val(data.cuota);
        $("#doc_transporte").val(data.doc_transp);
        $("#unidades_sup").val(data.u_suplementarias);
        $("#unidades_sup_uno").val(data.u_suplementarias_uno);
        $("#unidades_sup_dos").val(data.u_suplementarias_dos);
        $("#referencia_licencia").val(data.referencia_licencia);
        $("#valor_deducido").val(data.valor_deducido);
        $("#precio_item").val(data.precio_item);
        $("#flete_externo_i").val(data.flete_externo);
        $("#flete_interno_i").val(data.flete_interno);
        $("#seguro_item").val(data.seguro);
        $("#otros_costos_item").val(data.otros);
        $("#deducciones_item").val(data.deducciones);
        $("#id_detalle").val(doc);
        $("#item_id").val(data.item);
        $("select").trigger("chosen:updated");
    });
}

/* eliminar un documento adjunto seleccionado */
function eliminar_adjunto(doc) {
    var url = base_url("index.php/poliza/crear/eliminar_adjunto/" + doc);
    var item = document.getElementById("item_adjunto").value;
    var dua = document.getElementById("dua_adjunto").value;
    $.post(url, function(data) {
        lista_adjuntos(item, dua);
        $.notify("documento adjunto   ha sido eliminado con exito", "success");
    });
}
/* eliminar item del formuñlario para los Items */
function eliminar_item(id) {
    var url = base_url("index.php/poliza/crear/eliminar_item/" + id);
    var dua = document.getElementById("id_dua").value;

    $.post(url, function(data) {
        lista_items(dua);

        $.notify("documento adjunto   ha sido eliminado con exito", "success");
    });
}

/*Limpia input de ventana modal */
function limpiar_input_adjuntos() {
    $("#doc_adjunto").val("Seleccione...");
    $("#referencia_doc").val("");
    $("#fecha_doc").val("");
    $("#fecha_exp").val("");
    $("#codigo_pais_adj").val("");
    $("#codigo_entidad").val("");
    $("#otra_entidad").val("");
    $("#monto_autorizado").val("");
    $("#file").val("");
    $("#id_doc").val("");
    $("select").trigger("chosen:updated");
}

/*guarda informacion de  equipamiento */
function guardar_equipamiento() {
    var formData;
    url_destino = "index.php/poliza/crear/guardar_equipamiento";
    formData = new FormData($(".form_equipamiento")[0]);
    $.ajax({
        url: base_url(url_destino),
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            //var item = document.getElementById("item_adjunto").value;
            var dua = document.getElementById("id_dua").value;
            //	alert(dua);
            lista_equipamiento(dua);
            limpiar_input_equipamiento();
            $.notify("documento  ha sido guardada con exito", "success");
        },
        error: function() {
            $.notify("Ha ocurrido un error, operacion ha sido cancelada", "error");
        }
    });
}
/* muestra la lista de equipamiento muestra informacióon en tabla */
function lista_equipamiento(dua) {
    var url = base_url("index.php/poliza/crear/lista_equipamiento/" + dua);
    $.get(url, function(data) {
        $("#panel_lista_equipamiento").show();
        document.getElementById("contenidoLista_equipamiento").innerHTML = data;
    });
}

/*Limpia input de formulario equipamiento */
function limpiar_input_equipamiento() {
    $("#id_equipamiento").val("Seleccione...");
    $("#tamano_equipo").val("");
    $("#equipamiento").val("");
    $("#contenedor").val("");
    $("#num_paq_eq").val("");
    $("#tipo_contenedor").val("Seleccione...");
    $("#tipo_carga").val("Seleccione...");
    $("#tara").val("");
    $("#peso_mercancias").val("");
    $("#id_doc_eq").val("");
    $("select").trigger("chosen:updated");
}

/* consulta equipamiento y  muestra datos  en formulario */
function consulta_equipamiento(doc) {
    var url = base_url("index.php/poliza/crear/consulta_equipamiento/" + doc);
    $.getJSON(url, {
        producto: doc.value
    }, function(data) {
        $("#item_eq").val(data.item);
        $("#id_equipamiento").val(data.id_equipamiento);
        $("#tamano_equipo").val(data.tamano_equipo);
        $("#equipamiento").val(data.idequipamiento);
        $("#contenedor").val(data.contenedor);
        $("#num_paq_eq").val(data.numero_paquetes);
        $("#tipo_contenedor").val(data.id_contenedor);
        $("#tipo_carga").val(data.id_carga);
        $("#tara").val(data.tara);
        $("#peso_mercancias").val(data.peso_mercancias);
        $("#id_doc_eq").val(doc);
        $("select").trigger("chosen:updated");
    });
}

/* eliminar un documento adjunto seleccionado */
function eliminar_equipamiento(doc) {
    var url = base_url("index.php/poliza/crear/eliminar_equipamiento/" + doc);
    var dua = document.getElementById("id_dua").value;
    $.post(url, function(data) {
        lista_equipamiento(dua);
        $.notify("documento adjunto   ha sido eliminado con exito", "success");
    });
}

function detalle_poliza(file) {
    var dua = document.getElementById("id_dua").value;
    var url = base_url("index.php/poliza/crear/consulta_dm/" + file + "/" + dua);
    $.getJSON(url, {
        producto: dua.value
    }, function(data) {

        $("#aduana_registro").val(data.aduana_registro);
        $("#manifiesto").val(data.manifiesto);
        $("#aduana_entrada_salida").val(data.aduana_entrada_salida);
        $("#selectmod").val(data.modelo);
        $("#selectmod").trigger('change');
        $("#nombre_exportador").val(data.nombre_exportador);
        $("#nit_consignatario").val(data.nit_consignatario);
        $("#nit_consignatario").blur();

        $("#nit_exportador").val(data.nit_exportador);
        $("#nit_exportador").blur();
        $("#consignatario").val(data.consignatario);

        $("#declarante").val(data.declarante);
        $("#pais_export").val(data.pais_export);
        $("#registro_transportista").val(data.registro_transportista);
        $("#incoterm").val(data.incoterm);
        $("#total_facturar").val(data.total_facturar);
        $("#flete_interno").val(data.flete_interno);
        $("#flete_externo").val(data.flete_externo);
        $("#seguro").val(data.seguro);
        $("#otros").val(data.otros);
        $("#deducciones").val(data.deducciones);
        $("#localizacion_mercancia").val(data.localizacion_mercancia);
        $("#bultos").val(data.bultos);
        $("#referencia").val(data.referencia);
        $("#pais_proc").val(data.pais_proc);
        $("#pais_destino").val(data.pais_destino);
        $("#mod_transp").val(data.mod_transp);
        $("#pais_transporte").val(data.pais_transporte);
        $("#lugar_carga").val(data.lugar_carga);
        $("#presentacion").val(data.presentacion);
        $("#info_adicional").val(data.info_adicional);
        $("#pais_reg_tm").val(data.pais_reg_tm);
        $("#registro_nac_medio").val(data.registro_nac_medio);

        $("select").trigger("chosen:updated");

        if (data.modelo && data.reg_extendido && data.reg_adicional) {
            regimen(data.modelo, data.reg_extendido, data.reg_adicional);
        }
        lista_items(dua);
        lista_equipamiento(dua);
    });
}

function regimen(modelo, reg_e, reg_a) {

  //  alert(reg_e);
    var url = base_url("index.php/poliza/crear/get_regimen/" + modelo + "/" + reg_e + "/" + reg_a);

    $.get(url, function(data) {
        $("#selectregext").val(reg_e);

        $("#selectregext").trigger('change');
        $("select").trigger("chosen:updated");
    });


}

function limpiar_input_item() {
    $("#marcas_num_uno").val("");
    $("#marcas_num_dos").val("");
    $("#numero_paquetes").val("");
    $("#embalaje").val("");
    $("#descripcion_comercial").val("");
    $("#codigo_mercancia").val("");
    $("#pais_origen_item").val("");
    $("#peso_bruto").val("");
    $("#peso_neto").val("");
    $("#preferencia").val("");
    $("#cuota").val("");
    $("#doc_transporte").val("");
    $("#unidades_sup").val("");
    $("#unidades_sup_uno").val("");
    $("#unidades_sup_dos").val("");
    $("#referencia_licencia").val("");
    $("#valor_deducido").val("");
    $("#precio_item").val("");
    $("#flete_externo_i").val("");
    $("#flete_interno_i").val("");
    $("#seguro_item").val("");
    $("#otros_costos_item").val("");
    $("#deducciones_item").val("");
    $("#id_detalle").val("");
    $("select").trigger("chosen:updated");
}

function dowload_adjunto(pdf, ref) {

    var doc = ref + ".pdf";

    var url = base_url(
        "index.php/poliza/crear/dowload_adjunto/" + pdf + "/" + encodeURI(ref)
    );

    ver_url_tramite_aduana(doc);
    $.getJSON(url, {
        producto: pdf.value
    }, function(data) {});
}

function ver_url_tramite_aduana(doc) {
    var url = doc;
    window.open(
        base_url(url.replace(/%20/g, " ")),
        "ventana1",
        "width=600,height=600,scrollbars=no,toolbar=no, titlebar=no, menubar=no"
    );
}

function crear_pdf_sw() {

}


function generar_xml_original() {
    dua = $("#id_dua").val();
    var url = base_url("index.php/poliza/crear/generar_xml/" + dua);
    $.get(url, function(data) {
        //$("#panel_lista_equipamiento").show();
        //document.getElementById("contenidoLista_equipamiento").innerHTML = data;
    });
}


function download_xml() {

    var dataObj = {
        somekey: "someValue"
    }
    $("#loader-1").show();
    referencia = $("#referencia").val();
    var url = base_url("index.php/poliza/crear/download_xml/" + "R" + referencia + ".xml");
    $.ajax({
        method: "POST",
        url: url,
        data: dataObj,
        success: function(response) {
            const blob = new Blob([response], {
                type: 'text/xml'
            });
            const downloadUrl = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = downloadUrl;
            a.download = "R" + referencia + ".xml";
            document.body.appendChild(a);
            a.click();

            $("#loader-1").css("display", "none");
        }

    });

    // window.location.origin + "/grupo_c807/duar/" + "dm.xml";
}

function cargar_adjunto_masivo() {
    $("#add_adjuntos").modal("show");
    $("#id_opc").val(2);
    $("#item_adjunto").val("");
}


function generar_xml() {
    var dataObj = {
        somekey: "someValue"
    }
    $("#loader-1").css("display", "block");
    dua = $("#id_dua").val();
    referencia = $("#referencia").val();
    var url = base_url("index.php/poliza/crear/generar_xml/" + dua + "/" + referencia);
    $.ajax({
        method: "POST",
        url: url,
        data: dataObj,
        success: function(response) {
            $("#loader-1").css("display", "none");

        },
        error: function(request, status, errorThrown) {
            $("#loader-1").css("display", "none");

        }

    });


}