

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

        var url = base_url_erp("index.php/subir_Archivo/no_clasificados/" + $opcion);;

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

          var url = base_url_erp("index.php/subir_Archivo/traer_informacion_producto/" + $id_Reg + "/" + $cod_importador);

          $.get(url,   function (data) {
            $('#proveedor'+$id_Reg).val(data.proveedor);
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

        var url = base_url_erp("index.php/subir_Archivo/generar_excel/" );

        $num_file = $("#c807_file").val();
        $doc_tra  = $("#doc_transporte").val();
        $t_bultos = $("#tot_bultos").val();
        $t_kilos   = $("#tot_kilos").val();

        $mensaje = "";

        if ($num_file.length  == 0) {$mensaje = "numero de File";}
        if ($doc_tra.length   == 0) {$mensaje += ", documento de transporte";}
        if ($t_bultos.length  == 0) {$mensaje += ", total bultos";}
        if ($t_kilos.length   == 0) {$mensaje += ", total kilos.";}

        if ($mensaje.length > 0 )
        {
          $mesnsaje = "numero de File.";
          $.notify("Falta digitar " + $mensaje , "error");
        }else {
          window.location.href = url +"?"+ $("#c807_file").serialize() + "&" + $("#doc_transporte").serialize() + "&" + $("#tot_bultos").serialize() + "&" + $("#tot_kilos").serialize() ;
          $.notify("Archivo de Excel Generado.", "success");
        }
      }

      function generar_excel_sidunea() {

        var url = base_url_erp("index.php/subir_Archivo/generar_excel_sidunea/" );

        $num_file = $("#c807_file").val();
        $doc_tra  = $("#doc_transporte").val();
        $t_bultos = $("#tot_bultos").val();
        $t_kilos   = $("#tot_kilos").val();

        $mensaje = "";

        if ($num_file.length  == 0) {$mensaje = "numero de File";}
        if ($doc_tra.length   == 0) {$mensaje += ", documento de transporte";}
        if ($t_bultos.length  == 0) {$mensaje += ", total bultos";}
        if ($t_kilos.length   == 0) {$mensaje += ", total kilos.";}

        if ($mensaje.length > 0 )
        {
          $mesnsaje = "numero de File.";
          $.notify("Falta digitar " + $mensaje , "error");
        }else {
          window.location.href = url +"?"+ $("#c807_file").serialize() + "&" + $("#doc_transporte").serialize() + "&" + $("#tot_bultos").serialize() + "&" + $("#tot_kilos").serialize() ;
          $.notify("Archivo de Excel Generado.", "success");
        }
      }

      function generar_excel_dva() {

        var url = base_url_erp("index.php/subir_Archivo/generar_excel_dva/" );

        $num_file = $("#c807_file").val();
        $doc_tra  = $("#doc_transporte").val();
        $t_bultos = $("#tot_bultos").val();
        $t_kilos   = $("#tot_kilos").val();

        $mensaje = "";

        if ($num_file.length  == 0) {$mensaje = "numero de File";}
        if ($doc_tra.length   == 0) {$mensaje += ", documento de transporte";}
        if ($t_bultos.length  == 0) {$mensaje += ", total bultos";}
        if ($t_kilos.length   == 0) {$mensaje += ", total kilos.";}

        if ($mensaje.length > 0 )
        {
          $mesnsaje = "numero de File.";
          $.notify("Falta digitar " + $mensaje , "error");
        }else {
          window.location.href = url +"?"+ $("#c807_file").serialize() + "&" + $("#doc_transporte").serialize() + "&" + $("#tot_bultos").serialize() + "&" + $("#tot_kilos").serialize() ;
          $.notify("Archivo de Excel Generado.", "success");
        }
      }



      function generar_rayado() {
        
        var url = base_url_erp("index.php/subir_Archivo/generar_rayado/");
        $datos = $("#c807_file").val();

        
        if ($datos == null || $datos== undefined || $datos.length == 0) {
          $.notify("Falta digitar número de file." , "error");
        }else{

          window.location.href = url +"?"+ $("#c807_file").serialize();
          $.notify("Archivo PDF generado.", "success");
      }

      }

      function enviar_correo ($opcion) {
        
        //$opcion 1 de Aforador a Clasificador
        //$opcion 2 de Clasificacdor a Aforador
        
        var url = base_url_erp("index.php/subir_Archivo/enviar_correo/" + $opcion);
        $datos = $("#c807_file").serialize();

        $.get(url, $datos, function(data){
          $.notify(data, "success");
        });

      }


