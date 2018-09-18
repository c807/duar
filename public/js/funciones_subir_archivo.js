

//Esto es para subir archivos.

      function base_url_erp(url) {
        //return base_url(url)
        return window.location.origin + "/grupo_c807/duar/" + url;
      }


      $(document).ready(function () {

        $("#cerrar").click(function () {
            $("#actualizar_partida").hide();
        });
       });


      function no_clasificadas () {

      var url = base_url_erp("index.php/subir_Archivo/no_clasificados/")
      datos = $("#c807_file").serialize();

      $.post(url, datos, function (data) {
          $("#no_clasificados").html(data);
         }

       );
      }

      function mostrar_partida($id_Reg, $cod_importador) {

          $("#id_reg").val($id_Reg);
          $("#actualizar_partida").show("blind");

          var url = base_url_erp("index.php/subir_Archivo/traer_informacion_producto/" + $id_Reg + "/" + $cod_importador);

          $.get(url,   function (data) {
            $('#codigo_producto').val(data.codigo_producto);
            $('#descripcion').val(data.descripcion);
            $('#importador').val(data.importador);
            $('#partida_arancelaria').val('');
            }
          );

       }

      function crear_partida() {

          var url = base_url_erp("index.php/subir_archivo/grabar_partida/");
          datos = $("#partida").serialize();

          $.post(url, datos, function (data) {
            if (data.mensaje)
              {
                alert(data.mensaje);
              }else {
                $("#actualizar_partida").hide("slow");
                no_clasificadas();
              }

          });

      }

      function generar_archivo() {

        var url = base_url_erp("index.php/subir_Archivo/generar_excel/" )
        datos = $("#c807_file").serialize();



        $.post(url, datos, function (data) {
          alert(data);
          alert(data.trim().length);
          if (data.trim().length > 0)
           {alert('Archivo no se puede generar, falta clasificar partidas.');}

          $("#no_clasificados").html(data);

          }

        );



      }

