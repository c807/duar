

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

        $("#actualizar_partida"+$id_Reg).hide();

       }

      function no_clasificadas ($opcion) {

        //Opcion 1 = productos no clasificados
        //Opcion 2 = todos los prodcutos

        var url = base_url_erp("index.php/subir_archivo/no_clasificados/" + $opcion);;

        datos = $("#c807_file").serialize();

        $.post(url, datos, function (data) {
            $("#no_clasificados").html(data);
         }

       );
      }

      function mostrar_partida($id_Reg, $cod_importador) {

          $("#id_reg").val($id_Reg);
          //alert($("#actualizar_partida") + $id_Reg);
          $("#actualizar_partida"+$id_Reg).show("blind");

          var url = base_url_erp("index.php/subir_archivo/traer_informacion_producto/" + $id_Reg + "/" + $cod_importador);

          $.get(url,   function (data) {
            $('#num_factura'+$id_Reg).val(data.num_factura);
            $('#codigo_producto'+$id_Reg).val(data.codigo_producto);
            $('#descripcion'+$id_Reg).val(data.descripcion);
            $('#importador'+$id_Reg).val(data.importador);
            $('#partida_arancelaria'+$id_Reg).val('');
            }
          );

       }

      function crear_partida($id_Reg) {

          var url = base_url_erp("index.php/subir_archivo/grabar_partida/" + $id_Reg);
          datos = $("#partida"+$id_Reg).serialize();

          $.post(url, datos, function (data) {
            if (data.mensaje)
              {
                alert(data.mensaje);
              }else {
                $.notify("Partida Arancelaria creada." , "success" );
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

        var url = base_url_erp("index.php/subir_archivo/generar_excel/" );

        window.location.href = url +"?"+ $("#c807_file").serialize() + "&" + $("#doc_transporte").serialize() + "&" + $("#tot_bultos").serialize() + "&" + $("#tot_kilos").serialize() ;
        $.notify("Archivo de Excel Generado.", "success");
      }

      function generar_rayado() {

        var url = base_url_erp("index.php/subir_archivo/generar_rayado/");

        window.location.href = url +"?"+ $("#c807_file").serialize();
        $.notify("Archivo de Rayado de Factura Generado.", "success");

      }

      function enviar_correo ($opcion) {

        //$opcion 1 de Aforador a Clasificador
        //$opcion 2 de Clasificacdor a Aforador

        var url = base_url_erp("index.php/subir_archivo/enviar_correo/" + $opcion);
        $datos = $("#c807_file").serialize();

        $.get(url, $datos, function(data){
          $.notify(data, "success");
        });

      }


