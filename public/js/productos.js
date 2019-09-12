function base_url(url) {
	return window.location.origin + "/grupo_c807/duar/" + url;
}

function gestion_productos(opcion)
{
    var formData;
    var valido = "S";
   

    if (opcion == 'c'){
        url_destino = "index.php/productos/ProductosController/crear_productos/";
        formData = new FormData($(".add_producto")[0]);
    }
    
    
    if (valido == "S")
    {
        var message = ""; 
        $.ajax({
            url: base_url(url_destino),  
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                var accion="";
            if (response == 1) {
                //alert('Ya existe no puede continuar');
                //  document.getElementById("message").innerHTML = 'Ya existe no puede continuar';
               
                $("#message").html('<div class="alert alert-success alertred "><button type="button" class="close">x</button><strong>Código de producto ya esta registrado en BDD</strong></div>');
        
                window.setTimeout(function () {
                $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
                });
                }, 5000);

                $('.alert .close').on("click", function (e) {
                $(this).parent().fadeTo(500, 0).slideUp(500);
                });
              

            } else {
                if ($('#producimport').val().length == 0) {
                    $("#importador").val("");
                    $("#codproducto").val("");
                    $("#descripcion").val("");
                    $("#descripcion_generica").val("");
                    $("#funcion").val("");
                    $("#partida").val("");
                    $("#observaciones").val("");
                    $("#tlc").prop("checked", false);
                    $("#permiso").prop("checked", false);
                    $("#pesoneto").val("");
                    $("#numeros").val("");
                    $("#nbultos").val("");
                    $("#marca").val("");
                    $("#proveedor").val("");
                  }
                

                  $("#message").html('<div class="alert alert-success alertgreen"><button type="button" class="close">x</button><strong>Producto ha sido guardado correctamente</strong></div>');
                  window.setTimeout(function () {
                    $(".alert").fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                    });
                    }, 5000);
    
                    $('.alert .close').on("click", function (e) {
                    $(this).parent().fadeTo(500, 0).slideUp(500);
                    });
                   
                } 
            },
            
                     
        });
    }  
}


function subir_productos()
{
    var formData;
    url_destino = "index.php/productos/ProductosController/cargar_desde_archivo/";
    formData = new FormData($(".up_productos")[0]);
 
    $.ajax({
        url: base_url(url_destino),  
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
        $("#messagefile").html('<div class="alert alert-success alertgreen "><button type="button" class="close">x</button><strong>Proceso ha finalizado correctamente.</strong></div>');
        window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
        }, 5000);
        $('.alert .close').on("click", function (e) {
        $(this).parent().fadeTo(500, 0).slideUp(500);
        });
        },
    });
}


function update_productos()
{
    var formData;
    url_destino = "index.php/productos/ProductosController/actualizar_producto/";
    formData = new FormData($(".edit_producto")[0]);
 
    $.ajax({
        url: base_url(url_destino),  
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
           
        $("#messageup").html('<div class="alert alert-success alertgreen "><button type="button" class="close">x</button><strong>la Actualización ha  finalizado correctamente.</strong></div>');
        window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
        }, 5000);
        $('.alert .close').on("click", function (e) {
        $(this).parent().fadeTo(500, 0).slideUp(500);
        });
        
        },
      



        
    });
}


function borrar_productos()
{
    var formData;
    url_destino = "index.php/productos/ProductosController/borrar_producto/";
    formData = new FormData($(".del_producto")[0]);
 
    $.ajax({
        url: base_url(url_destino),  
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
          
        $("#message").html('<div class="alert alert-success alertgreen "><button type="button" class="close">x</button><strong>Producto ha  sido borrado.</strong></div>');
        window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
        }, 5000);

        $('.alert .close').on("click", function (e) {
        $(this).parent().fadeTo(500, 0).slideUp(500);
        });
       
 
         
        },
    });
} 
function mostrarModal(titulo) {
    $("#modalTitle").html(titulo);
   
    $("#crear_producto").modal("show");
  }
  function mostrar(){
   
    $('#crear_producto').on('show.bs.modal', function(e) {
        var bookId = $(e.relatedTarget).data('book-id');
        var bookId1 = $(e.relatedTarget).data('book-id1');
        var bookId2 = $(e.relatedTarget).data('book-id2');
        var bookId3 = $(e.relatedTarget).data('book-id3');
        var bookId4 = $(e.relatedTarget).data('book-id4');
        var bookId5 = $(e.relatedTarget).data('book-id5');
        var bookId6 = $(e.relatedTarget).data('book-id6');
        var bookId7 = $(e.relatedTarget).data('book-id7');
        var bookId8 = $(e.relatedTarget).data('book-id8');
        var bookId9 = $(e.relatedTarget).data('book-id9');
        var bookId10 = $(e.relatedTarget).data('book-id10');
        var bookId11 = $(e.relatedTarget).data('book-id11');
        var bookId12 = $(e.relatedTarget).data('book-id12');
        var bookId13 = $(e.relatedTarget).data('book-id13');
        var bookId14 = $(e.relatedTarget).data('book-id14');
        var bookId15 = $(e.relatedTarget).data('book-id15');
        var bookId16 = $(e.relatedTarget).data('book-id16');  
              
  
        $(e.currentTarget).find('input[name="producimport"]').val(bookId);
        $(e.currentTarget).find('input[name="importador"]').val(bookId1);
        $(e.currentTarget).find('input[name="codproducto"]').val(bookId2);
        $(e.currentTarget).find('textarea[name="descripcion"]').val(bookId3);
        $(e.currentTarget).find('textarea[name="descripcion_generica"]').val(bookId4);
        $(e.currentTarget).find('textarea[name="funcion"]').val(bookId5);
        $(e.currentTarget).find('input[name="partida"]').val(bookId6);
        $(e.currentTarget).find('textarea[name="observaciones"]').val(bookId7);
        $(e.currentTarget).find('checked[name="permiso"]').val(bookId8);
        $(e.currentTarget).find('checked[name="tlc"]').val(bookId9);


        if (bookId8 == 1) {
            $(e.currentTarget).find('input[name="permiso"]').prop("checked", true)
        } else {
            $(e.currentTarget).find('input[name="permiso"]').prop("checked", false)
        }

        if (bookId9 == 1) {
            $(e.currentTarget).find('input[name="tlc"]').prop("checked", true)
        } else {
            $(e.currentTarget).find('input[name="tlc"]').prop("checked", false)
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
        $("#tipobulto").val(bookId15)
        $('#tipobulto').change();
        $("#paises").val(bookId16)
        $('#paises').change();
        $("#importador").val(bookId1)
        $('#importador').change();

        //document.ready = document.getElementById("tipobulto").value=bookId15; esto tambien funciona
    
    });
    
  }
  function mostrarficha(){
   
    $('#verficha').on('show.bs.modal', function(e) {
        var bookId = $(e.relatedTarget).data('book-id');
        var bookId1 = $(e.relatedTarget).data('book-id1');
        var bookId2 = $(e.relatedTarget).data('book-id2');
        var bookId3 = $(e.relatedTarget).data('book-id3');
        var bookId4 = $(e.relatedTarget).data('book-id4');
        var bookId5 = $(e.relatedTarget).data('book-id5');
        var bookId6 = $(e.relatedTarget).data('book-id6');
        var bookId7 = $(e.relatedTarget).data('book-id7');
        var bookId8 = $(e.relatedTarget).data('book-id8');
        var bookId9 = $(e.relatedTarget).data('book-id9');
        var bookId10 = $(e.relatedTarget).data('book-id10');
        var bookId11 = $(e.relatedTarget).data('book-id11');
        var bookId12 = $(e.relatedTarget).data('book-id12');
        var bookId13 = $(e.relatedTarget).data('book-id13');
        var bookId14 = $(e.relatedTarget).data('book-id14');
        var bookId15 = $(e.relatedTarget).data('book-id15');
        var bookId16 = $(e.relatedTarget).data('book-id16'); 
        var bookId17 = $(e.relatedTarget).data('book-id17'); 
        var bookId18 = $(e.relatedTarget).data('book-id18');    
        var bookId19 = $(e.relatedTarget).data('book-id19');           
  
        $(e.currentTarget).find('label[name="producimport"]').val(bookId);
        $(e.currentTarget).find('input[name="importador"]').val(bookId1);
        $(e.currentTarget).find('input[name="codproducto"]').val(bookId2);
        $(e.currentTarget).find('textarea[name="descripcion"]').val(bookId3);
        $(e.currentTarget).find('textarea[name="descripcion_generica"]').val(bookId4);
        $(e.currentTarget).find('textarea[name="funcion"]').val(bookId5);
        $(e.currentTarget).find('input[name="partida"]').val(bookId6);
        $(e.currentTarget).find('textarea[name="observaciones"]').val(bookId7);
        $(e.currentTarget).find('checked[name="permiso"]').val(bookId8);
        $(e.currentTarget).find('checked[name="tlc"]').val(bookId9);


        if (bookId8 == 1) {
            $(e.currentTarget).find('input[name="permiso"]').prop("checked", true)
        } else {
            $(e.currentTarget).find('input[name="permiso"]').prop("checked", false)
        }

        if (bookId9 == 1) {
            $(e.currentTarget).find('input[name="tlc"]').prop("checked", true)
        } else {
            $(e.currentTarget).find('input[name="tlc"]').prop("checked", false)
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
        $("#tipobulto").val(bookId15)
        $('#tipobulto').change();
        $("#paises").val(bookId16)
        $('#paises').change();
        

        $(e.currentTarget).find('input[name="paisorigen"]').val(bookId17);
        $(e.currentTarget).find('input[name="descripcion_bulto"]').val(bookId18);
        $(e.currentTarget).find('input[name="nombre_importador"]').val(bookId19);

        //document.ready = document.getElementById("tipobulto").value=bookId15; esto tambien funciona
    
    });
    
  }

 
 