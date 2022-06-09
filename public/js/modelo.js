$(document).on("change", "#selectmod", function(e) {
    $('#selectregadi').html('');
    $("select").trigger("chosen:updated");

})

function dependencia(opc, val, id, selec) {
    var url = base_url('index.php/poliza/crear/dependencias');
    var datos = { opc: opc, codigo: val, lista: selec };
    document.getElementById(id).innerHTML = '';

    $.getJSON(url, datos, function(data) {
        var opcion = document.createElement('option');
        opcion.value = '';
        opcion.innerHTML = 'Seleccione...';
        document.getElementById(id).appendChild(opcion);

        data.forEach(function(arg) {
            var opcion = document.createElement('option');
            opcion.value = arg.codigo;
            opcion.innerHTML = arg.codigo + ' - ' + arg.codigo_adicional + ' ' + arg.descripcion_adicional;
            document.getElementById(id).appendChild(opcion);


        })

        $("select").trigger("chosen:updated");
    })
}

function setvalida() {
    var mod = $("#selectmod").val();
    var ext = $("#selectregext").val();
    var adi = $("#selectregadi").val();


    if (mod == null || ext == null || adi == null) {
        $("#btvalida").notify(
            "Faltan datos por completar",
            "error");

    } else {
        $("#mod").submit();

    }
}

$(document).on("submit", "form#mod", function(event) {
    event.preventDefault();
    var url = this.action;
    var datos = $(this).serialize();

    $.post(url, datos, function(data) {
        $("#btvalida").notify(
            "Presione el botón siguiente para iniciar",
            "warn");

        $("#btvalida").hide();
        $("#btnext").show();

        document.getElementById('btnext').setAttribute('href', base_url('index.php/poliza/crear/headerduar/') + data);
    })
})