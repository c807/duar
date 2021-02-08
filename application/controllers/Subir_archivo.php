<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subir_Archivo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('subir_archivos/Subir_archivos_model'));
        $this->load->model('subir_archivos/Subir_archivos_model');
        $this->load->model('Conf_model');
        
        
        $this->datos = array();
        $this->datos["navtext"] = "DPR";

      //  $this->load->library('PHPEXCEL/PHPExcel.php');
     
        $datos   = $this->Conf_model->info_accesos_dpr($_SESSION['UserID']);
       
        $_SESSION['roll']=$datos->ROLL;
        $_SESSION['add']=$datos->AGREGAR;
        $_SESSION['edit']=$datos->EDITAR;
        $_SESSION['delete']=$datos->ELIMINAR;
        $_SESSION['print']=$datos->IMPRIMIR;
        $_SESSION['consulta']=$datos->CONSULTAR;
        $_SESSION['cargar']=$datos->AGREGAR;
    }

    public function index()
    {
        /* despues de importar archivo, ejecuta este bloque para mostrar detalles de la carga */
        if (isset($_GET["file"])) {
            $id_file = $this->Subir_archivos_model->obtener_datos_file($_GET['c807_file']);

            $this->datos['contador']           = $_GET["contador"];
            $this->datos['file']               = $_GET["c807_file"];
            $this->datos['cantidad_productos'] = $this->Subir_archivos_model->consulta($_GET["file"], str_replace('', '', $id_file->no_identificacion), 3);
            $this->datos['registros']          = $this->Subir_archivos_model->consulta($_GET["file"], str_replace('', '', $id_file->no_identificacion), 2);
        } else {
            $this->datos['file']               = "";
        }

        $this->datos["mensaje"]	= "";

        $this->datos["vista"] = "subir_archivos/subir_archivo";
        $this->load->view('principal', $this->datos);
    }

    public function import()
    {
        if (isset($_FILES["file"]["name"]) && isset($_POST['c807_file'])) {
            $id_file = $this->Subir_archivos_model->obtener_datos_file($_POST['c807_file']);
            $nit_importador= $id_file->no_identificacion;
            $this->Subir_archivos_model->eliminar_dpr($id_file->id);
            $contador = 0;
            if (!$id_file) {
                $_SESSION["no_clasificado"] = 'Número de File: '. $_POST['c807_file'] .' no existe.';
                redirect("subir_archivo");
            } else {
                $destino = getcwd()."/public/uploads/file/";

                if (!is_dir($destino)) {
                    mkdir($destino, 0777, true);
                }

                if (file_exists((string)$_FILES['file']['tmp_name'])) {
                    $extension = explode(".", $_FILES["file"]["name"]);
                    $nombre = time()."-plantilla.".$extension[1];

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $destino."/".$nombre)) {
                        $link = $destino."/".$nombre;
                    } else {
                        $_SESSION["no_clasificado"] = "Error al subir el archivo";
                        redirect("subir_archivo");
                    }
                }

                $object = PHPExcel_IOFactory::load($link);
                $existe_Factura = '';
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow    = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();

                    $facturaIni = "";

                    for ($row=2; $row <= $highestRow; $row++) {
                        if ($row == 2) {
                            $facturaIni = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        }

                        $num_factura  = 	$worksheet->getCellByColumnAndRow(0, $row)->getValue();

                        if ($facturaIni !== $num_factura) {
                            $facturaIni = $num_factura;

                            $data = array(
                                'num_factura' => $num_factura,
                                'num_file'    => $_POST['c807_file']);

                            $cantidad = $this->Subir_archivos_model->existe_factura($data);

                            if ($cantidad->cantidad == 0) {
                                $existe_Factura = 'N';
                            } else {
                                $existe_Factura = 'S';
                            }
                        }
                    }
                }
                $numero_file= $_POST['c807_file'];
                if ($existe_Factura == 'S') {
                    $_SESSION["no_clasificado"] = 'Factuta ya fue Procesada al file '. $_POST['c807_file'];
                    redirect("subir_archivo");
                } else {
                    foreach ($object->getWorksheetIterator() as $worksheet) {
                        $highestRow    = $worksheet->getHighestRow();
                        $highestColumn = $worksheet->getHighestColumn();

                        for ($row=2; $row<=$highestRow; $row++) {
                            $codigo          = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                            $descripcion     = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            $unidades        = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                            $num_factura     = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                            $pais_origen     = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                            $peso_bruto      = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                            $peso_neto       = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                            $precio_unitario = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                            $total           = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                            $flete           = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                            $seguro          = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                            $otros_gastos    = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                            $bultos          = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                            $tlc             = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                            $proveedor       = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
                            
                            $codigo=trim($codigo);

                            if (is_null($codigo) || empty($codigo) || $codigo=="") {
                            } else {
                                $numero_partida="";
                                $datos = $this->Subir_archivos_model->verificar_partida($codigo, $nit_importador, $_SESSION['pais_id']);
                          
                                
                              
                                $numero_partida=$datos[0]->partida;
                               
                                $permiso=$datos[0]->permiso;
                                $estado=$datos[0]->idestado;
                                $unidad=$datos[0]->idunidad;
                                $fito=$datos[0]->fito;
                                $adquisicion=$datos[0]->pais_adquisicion;
                                $procedencia=$datos[0]->pais_procedencia;

                                $descripcion_generica=$datos[0]->descripcion_generica;
                                if ($tlc == null) {
                                    $tlc = '0';
                                }

                                if ($permiso == null) {
                                    $permiso = '0';
                                }
                                if ($descripcion_generica == null) {
                                } else {
                                    $descripcion=$descripcion_generica;
                                }

                                if ($flete == null) {
                                    $flete=0;
                                }
                                if ($seguro == null) {
                                    $seguro=0;
                                }
                                if ($otros_gastos == null) {
                                    $otros_gastos=0;
                                }
                    
                                
                                $data = array(
                                'codigo_producto'  => $codigo,
                                'descripcion'      => $descripcion,
                                'cuantia'          => $unidades,
                                'num_factura'      => $num_factura,
                                'pais_origen'      => $pais_origen,
                                'peso_bruto'       => $peso_bruto,
                                'peso_neto'        => $peso_neto,
                                'precio_unitario'  => $precio_unitario,
                                'total'            => $total,
                                'flete'            => $flete,
                                'seguro'           => $seguro,
                                'otros_gastos'     => $otros_gastos,
                                'bultos'           => $bultos,
                                'tlc'              => $tlc,
                                'nombre_proveedor' => $proveedor,
                                'id_file'          => $id_file->id,
                                'partida'          => $numero_partida,
                                'permiso'          => $permiso,
                                'pais_id'          => $_SESSION['pais_id'],
                                'idestado'         => $estado,
                                'idunidad'         => $unidad,
                                'fito'             => $fito,
                                'pais_adquisicion' => $adquisicion,
                                'pais_procedencia' => $procedencia


                                
                            );
                          
                                $this->Subir_archivos_model->insert($data);
                                $contador += 1;
                            }
                        }
                    }

                    $data = array('id_file' => $id_file->id);
                  //  $this->Subir_archivos_model->crear_listado_polizas($data);
                   
                    $_SESSION["no_clasificado"] = 'Datos Procesados al file '. $_POST['c807_file'];
                    unlink($link);
                    redirect("subir_archivo?file={$id_file->id}&contador={$contador}&c807_file={$_POST['c807_file']}");
                }
            }
        } else {
            $_SESSION["no_clasificado"] = "Error al subir el archivo";
            redirect("subir_archivo");
        }
    }


    public function clasificar_productos()
    {
        if (isset($_GET['c807_file'])) {
            $id_file = $this->Subir_archivos_model->obtener_datos_file($_GET['c807_file']);
            $data = array('id_file' => $id_file->id, 'id_usuario_clasificador' => $_SESSION["UserID"], 'fecha' =>  0);
            $this->Subir_archivos_model->crear_listado_polizas($data);
        }

        $this->datos["c807_file"] = (isset($_GET['c807_file'])) ? $_GET['c807_file'] : '';
        $this->datos["vista"] = 'subir_archivos/clasificar_productos';
        $this->load->view("principal", $this->datos);
    }
 
    
    public function no_clasificados($opcion)
    {
        $id_file = $this->Subir_archivos_model->obtener_datos_file($_POST['c807_file']);
      
        if (!isset($id_file)) {
            $_SESSION["no_clasificado"] = 'Número de file: ' . $_POST['c807_file'] . ' no existe';
            $this->load->view('subir_archivos/no_clasificados');
        } else {
            $this->datos['registros'] = $this->Subir_archivos_model->consulta($id_file->id, str_replace('', '', $id_file->no_identificacion), $opcion);
            $this->datos['num_file'] = $_POST['c807_file'];
            $this->datos['paises'] = $this->Conf_model->paises();
            $this->datos['estados'] = $this->Conf_model->estados();
            $this->datos['u_comercial'] = $this->Conf_model->u_comercial();
            
            //$this->datos['preferencia'] = $this->Conf_model->preferencia();
            $_SESSION["no_clasificado"] = '';
            if ($opcion == 2) {
                $this->datos['mensaje'] = "Listado de Productos: ";
                $this->load->view('subir_archivos/listado_productos', $this->datos);
            } else {
                $this->load->view('subir_archivos/no_clasificados', $this->datos);
            }
        }
    }

    public function traer_informacion_producto($id_reg, $num_file)
    {
        $datos = $this->Subir_archivos_model->traer_informacion_producto($id_reg);
        $cod_importador = $this->Subir_archivos_model->obtener_datos_file($num_file);

       
        enviarJson(array(
                
            'id'                   => $datos->id,
            'num_factura'          => $datos->num_factura,
            'codigo_producto'      => $datos->codigo_producto,
            'descripcion'          => $datos->descripcion,
            'nombre_proveedor'     => $datos->nombre_proveedor,
            'pais_origen'          => $datos->pais_origen,
            'importador'           => $cod_importador->no_identificacion));
    }


    public function grabar_partida($id_reg)
    {
        if (isset($_POST["partida_arancelaria".$id_reg]) && strlen(trim($_POST["partida_arancelaria".$id_reg])) > 0
         && isset($_POST["descripcion_generica".$id_reg]) && strlen(trim($_POST["descripcion_generica".$id_reg])) > 0
        ) {
            $tlc=0;
            if ($_POST['tlc'] == 'on') {
                $preferencia=$_POST["preferencia"];
                $tlc=1;
            } else {
                $preferencia=null;
                $tlc=0;
            }

            $permiso=0;
            if ($_POST['permiso'] == 'on') {
                $permiso=1;
            } else {
                $permiso=0;
            }
           

            $fito=0;
            if ($_POST['fito'] == 'on') {
                $fito=1;
            } else {
                $fito=0;
            }
           
            $datos = array(
                    'importador'           => str_replace('', '', $_POST["importador".$id_reg]),
                    'codigo_producto'      => $_POST["codigo_producto".$id_reg],
                    'descripcion'          => $_POST["descripcion".$id_reg],
                    'partida_arancelaria'  => $_POST["partida_arancelaria".$id_reg],
                    'codigo_extendido'     => $_POST["codigo_extendido".$id_reg],
                    'descripcion_generica' => $_POST["descripcion_generica".$id_reg],
                    'funcion'              => $_POST["funcion"],
                    'observaciones'        => $_POST["observaciones"],
                    'marca'                => $_POST["marca".$id_reg],
                    'nombre_proveedor'     => $_POST["proveedor".$id_reg],
                    'paisorigen'           => $_POST["paises"],
                    'tlc'                  => $tlc,
                    'permiso'              => $permiso,
                    'fito'                 => $fito,
                    'idestado'             => $_POST["estados"],
                    'idunidad'             => $_POST["u_comercial"],
                    'pais_procedencia'     => $_POST["pais_procedencia"],
                    'pais_adquisicion'     => $_POST["pais_adquisicion"],
                    'usuario'              => $_SESSION["UserID"],
                  
                    
            );
           // var_dum($datos);
            $dpr = array(
                'tlc'                     => $tlc,
                'partida_arancelaria'     => $_POST["partida_arancelaria".$id_reg],
                'permiso'                 => $permiso,
                'descripcion_generica'    => $_POST["descripcion_generica".$id_reg],
                'fito'                    => $fito,
                'idestado'                => $_POST["estados"],
                'idunidad'                => $_POST["u_comercial"],
                'pais_adquisicion'        => $_POST["pais_adquisicion"],
                'pais_procedencia'        => $_POST["pais_procedencia"],
                
        );
                
            $this->Subir_archivos_model->insertar_partida($datos);
            $this->Subir_archivos_model->actualizar_dpr($id_reg, $dpr);
        } else {
            enviarJson(array('mensaje' => 'Error, falta la partida arancelaria o descripción generica.'));
        }
    }

    public function mostrar_clasificados()
    {
        $this->datos['paises'] = $this->Conf_model->paises();
        $this->datos["vista"] = "subir_archivos/generar_archivo_clasificado";
        $this->load->view('principal', $this->datos);
    }

    
    public function excel_intec($file, $doc)
    {
      
        $datos['l_retaceo']    = $this->Subir_archivos_model->lista_retaceo($file);
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                  ->setCreator("Duar - C807")
                  ->setTitle("Office 2007 XLSX Test Document")
                  ->setSubject("Office 2007 XLSX Test Document")
                  ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                  ->setKeywords("office 2007 openxml php")
                  ->setCategory("Poliza");  
                                   
        $contador=1;
        $objPHPExcel->getActiveSheet()->setCellValue("A{$contador}", 'TIPO');	        
        $objPHPExcel->getActiveSheet()->setCellValue("B{$contador}", 'POS.ARANCEL');
        $objPHPExcel->getActiveSheet()->setCellValue("C{$contador}", 'DESCRIPCION');
        $objPHPExcel->getActiveSheet()->setCellValue("D{$contador}", 'ORIGEN');	        
        $objPHPExcel->getActiveSheet()->setCellValue("E{$contador}", 'PROC/DESTINO');
        $objPHPExcel->getActiveSheet()->setCellValue("F{$contador}", 'ADQUISICION');
        $objPHPExcel->getActiveSheet()->setCellValue("G{$contador}", 'ESTADO'); 
        $objPHPExcel->getActiveSheet()->setCellValue("H{$contador}", 'BULTOS'); 
        $objPHPExcel->getActiveSheet()->setCellValue("I{$contador}", 'UNIDAD COM.'); 
        $objPHPExcel->getActiveSheet()->setCellValue("J{$contador}", 'CANT. COM.');
        $objPHPExcel->getActiveSheet()->setCellValue("K{$contador}", 'UNIDAD EST.');
        $objPHPExcel->getActiveSheet()->setCellValue("L{$contador}", 'CANT. EST.');
        $objPHPExcel->getActiveSheet()->setCellValue("M{$contador}", 'PESO NETO');
        $objPHPExcel->getActiveSheet()->setCellValue("N{$contador}", 'PESO BRUTO');
        $objPHPExcel->getActiveSheet()->setCellValue("O{$contador}", 'FOB');
        $objPHPExcel->getActiveSheet()->setCellValue("P{$contador}", 'FLETE');
        $objPHPExcel->getActiveSheet()->setCellValue("Q{$contador}", 'SEGURO');
        $objPHPExcel->getActiveSheet()->setCellValue("R{$contador}", 'O.GASTOS');
        $objPHPExcel->getActiveSheet()->setCellValue("S{$contador}", 'ALMACENAJE');
        $objPHPExcel->getActiveSheet()->setCellValue("T{$contador}", 'AJUSTE INC.');
        $objPHPExcel->getActiveSheet()->setCellValue("U{$contador}", 'AJUSTE DED.');
        $objPHPExcel->getActiveSheet()->setCellValue("V{$contador}", 'CONVENIO');
        $objPHPExcel->getActiveSheet()->setCellValue("W{$contador}", 'CUOTA ARAN.');
        $objPHPExcel->getActiveSheet()->setCellValue("X{$contador}", 'ID. MATRIZ');
        $objPHPExcel->getActiveSheet()->setCellValue("Y{$contador}", 'DEC. CANCELAR');
        $objPHPExcel->getActiveSheet()->setCellValue("Z{$contador}", 'ITEM CANCELAR');
        $objPHPExcel->getActiveSheet()->setCellValue("AA{$contador}", 'TITULO MAN COUR.');
        $objPHPExcel->getActiveSheet()->setCellValue("AB{$contador}", 'CERTIF. IMP.');
        $objPHPExcel->getActiveSheet()->setCellValue("AC{$contador}", 'EXONERACION');
        $objPHPExcel->getActiveSheet()->setCellValue("AD{$contador}", 'GRUPO');
        $objPHPExcel->getActiveSheet()->setCellValue("AE{$contador}", '001');

        foreach ($datos['l_retaceo'] as $fila) {
            
	      	$contador++;
	      	$objPHPExcel->getActiveSheet()->setCellValue("A{$contador}","N");
		    $objPHPExcel->getActiveSheet()->setCellValue("B{$contador}", $fila->partida);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$contador}", $fila->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$contador}", $fila->pais_origen);
            $objPHPExcel->getActiveSheet()->setCellValue("E{$contador}", $fila->pais_procedencia);
            $objPHPExcel->getActiveSheet()->setCellValue("F{$contador}", $fila->pais_adquisicion);
            $objPHPExcel->getActiveSheet()->setCellValue("G{$contador}", $fila->idestado);
            $objPHPExcel->getActiveSheet()->setCellValue("H{$contador}", " ");
            $objPHPExcel->getActiveSheet()->setCellValue("I{$contador}", $fila->idunidad);
            $objPHPExcel->getActiveSheet()->setCellValue("J{$contador}", $fila->cuantia);
            $objPHPExcel->getActiveSheet()->setCellValue("K{$contador}", $fila->idunidad);
            $objPHPExcel->getActiveSheet()->setCellValue("L{$contador}", $fila->cuantia);
            $objPHPExcel->getActiveSheet()->setCellValue("M{$contador}", " ");
            $objPHPExcel->getActiveSheet()->setCellValue("N{$contador}"," ");
            $objPHPExcel->getActiveSheet()->setCellValue("O{$contador}", $fila->total);
        }
        $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$_GET ["c807_file"].'.xls');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
     
    }

    public function generar_excel()
    {
        if (isset($_GET["c807_file"]) &&  isset($_GET["doc_transporte"]) && isset($_GET["tot_bultos"]) && isset($_GET["tot_kilos"])
           && strlen(trim($_GET["c807_file"])) > 0  && strlen(trim($_GET["doc_transporte"])) > 0  && strlen(trim($_GET["tot_bultos"])) > 0
           && strlen(trim($_GET["tot_kilos"])) > 0) {
            $this->datos['cliente'] = $this->Subir_archivos_model->obtener_datos_file($_GET ["c807_file"]);
            $registros   = $this->Subir_archivos_model->generar_excel($_GET ["c807_file"], $_GET['doc_transporte']);

            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getProperties()
                        ->setCreator("IMPALA - C807")
                        ->setLastModifiedBy("Maarten Balliauw")
                        ->setTitle("Office 2007 XLSX Test Document")
                        ->setSubject("Office 2007 XLSX Test Document")
                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                        ->setKeywords("office 2007 openxml php")
                        ->setCategory("Poliza");

            $pos = 1;
            if ($registros) {
                $total_Cuantia = 0;
                $total_fob     = 0;

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'cuantia') {
                            $total_Cuantia += $field;
                        }
                        if ($item == 'fob') {
                            $total_fob += $field;
                        }
                    }
                }

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'partida') {
                            $this->datos['partida'] = $field;
                        }
                        if ($item == 'pais') {
                            $det_Paises = '';

                            if (isset($this->datos['partida'])) {
                                $paises = $this->Subir_archivos_model->traer_paises($this->datos);

                               

                                for ($i=0; $i < count($paises) ; $i++) {
                                    foreach ($paises[$i] as $key => $value) {
                                        $det_Paises = $det_Paises . $value . ",";
                                    }
                                }
                            }

                            $registros[$x]->pais = $det_Paises;
                        }
                    }
                }

               
                $bulto_por_partida = $_GET["tot_bultos"] / count($registros);
                $peso_por_partida  = $_GET["tot_kilos"] / count($registros);

                //Calculo de Flete, Seguro y Otros
                $cuantia_Paquete = 0;
                $fob_Paquete     = 0;
                $flete_Paquete   = 0;
                $seguro_Paquete  = 0;
                $otros_Paquete   = 0;

                $cuantia_paq_calculado  = 0;
                $flete_paq_calculado    = 0;
                $seguro_paq_calculado   = 0;
                $otros_paq_calculado    = 0;
                $peso_bruto_calculado   = 0;

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'cuantia') {
                            $cuantia_Paquete = round($field * $_GET["tot_bultos"] / $total_Cuantia, 2);

                            //segun el cuador de prorrateo de excel
                            $registros[$x]->numero_de_bultos  = $cuantia_Paquete;
                            $cuantia_paq_calculado           += $cuantia_Paquete;
                            $cuantia_Paquete = 0;
                        }

                        if ($item == 'numero_de_bultos') {
                          
                        }

                        if ($item == 'fob') {
                            $fob_Paquete    = round($field * $_GET["tot_kilos"] / $total_fob, 2);


                            //(isset($_GET['c807_file'])) ? $_GET['c807_file'] : '';

                            $flete_Paquete  = round((isset($_GET['flete'])) ? $_GET['flete'] : 0 / $total_fob * $field, 2);
                            $seguro_Paquete = round((isset($_GET['seguro'])) ? $_GET['seguro'] : 0 / $total_fob * $field, 2);
                            $otros_Paquete  = round((isset($_GET['otros'])) ? $_GET['otros'] : 0 / $total_fob * $field, 2);

                            $flete_paq_calculado    += $flete_Paquete;
                            $seguro_paq_calculado   += $seguro_Paquete;
                            $otros_paq_calculado    += $otros_Paquete;

                            //segun el cuadro de excel de prorrateo
                            $registros[$x]->peso_bruto  = $fob_Paquete;
                            $registros[$x]->peso_neto   = $fob_Paquete;
                            $peso_bruto_calculado       += $fob_Paquete;
                            $fob_Paquete = 0;
                        }

                        if ($item == 'peso_bruto') {
                          
                        }

                        if ($item == 'flete') {
                            $registros[$x]->flete  = $flete_Paquete;
                            $flete_Paquete = 0;
                        }
                        if ($item == 'seguro') {
                            $registros[$x]->seguro  = $seguro_Paquete;
                            $seguro_Paquete = 0;
                        }
                        if ($item == 'otros') {
                            $registros[$x]->otros  = $otros_Paquete;
                            $otros_Paquete = 0;
                        }
                    }
                }

                $tot_Gastos = 0;
                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'flete') {
                            $tot_Gastos = $field;
                        }
                        if ($item == 'seguro') {
                            $tot_Gastos += $field;
                        }
                        if ($item == 'otros') {
                            $tot_Gastos += $field;
                        }
                        if ($item == 'cif') {
                            $registros[$x]->cif  += $tot_Gastos;
                            $tot_Gastos  = 0;
                        }
                    }
                }


                //Ajustar datos de Prorrateo

                $registros[0]->numero_de_bultos = $registros[0]->numero_de_bultos + $_GET["tot_bultos"] - $cuantia_paq_calculado;
                $registros[0]->peso_bruto       = $registros[0]->peso_bruto + $_GET["tot_kilos"] - $peso_bruto_calculado;
                $registros[0]->peso_neto        = $registros[0]->peso_neto  + $_GET["tot_kilos"] - $peso_bruto_calculado;

                $registros[0]->flete            = $registros[0]->flete - $_GET["flete"] + $flete_paq_calculado;
                $registros[0]->seguro           = $registros[0]->seguro + $_GET["seguro"] - $seguro_paq_calculado;
                $registros[0]->otros            = $registros[0]->otros + $_GET["otros"] - $otros_paq_calculado;
               



                //Actualizar Numero de Fila en el excel
                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'linea') {
                            $registros[$x]->linea = $x+1;
                        }
                    }
                }

                //Actualizar Linea de Agrupacion de DPR
                $num_linea = 0;
                $tlc       = 0;
                $partida   = "";
                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'tlc') {
                            $tlc = $field;
                        }
                        if ($item == 'partida') {
                            $partida = $field;
                        }
                        if ($item == 'linea') {
                            $num_linea = $field;
                            //Actualziar pasar numero de file y partida y numero de linea
                            //$field es el codigo de partida arancelaria
                            $this->Subir_archivos_model->actualizar_linea_agrupacion($_GET["c807_file"], $partida, $num_linea, $tlc);
                        }
                    }
                }


                for ($x = 0; $x < count($registros); $x++) {
                    if ($x == 0) {
                        $datos = array();
                        foreach ($registros[$x]  as $item => $field) {
                            $datos[] = $item;
                        }
                        $objPHPExcel->getActiveSheet()->fromArray($datos, null, "A{$pos}");
                        $pos += 1;
                    }

                    $datos = array();
                    foreach ($registros[$x]  as $item => $field) {
                        $datos[] = $field;
                    }
                    $objPHPExcel->getActiveSheet()->fromArray($datos, null, "A{$pos}");
                    $pos += 1;
                }
            }


            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
            $objPHPExcel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$_GET ["c807_file"].'.xls');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            ob_end_clean();
            $objWriter->save('php://output');
            exit;
        } else {
            $this->datos["vista"] = "subir_archivos/generar_archivo_clasificado";
            $this->load->view('principal', $this->datos);
        }
    }


    public function generar_excel_sidunea()
    {
        if (isset($_GET["c807_file"]) &&  isset($_GET["doc_transporte"]) && isset($_GET["tot_bultos"]) && isset($_GET["tot_kilos"])
           && strlen(trim($_GET["c807_file"])) > 0  && strlen(trim($_GET["doc_transporte"])) > 0  && strlen(trim($_GET["tot_bultos"])) > 0
           && strlen(trim($_GET["tot_kilos"])) > 0) {
            $this->datos['cliente'] = $this->Subir_archivos_model->obtener_datos_file($_GET ["c807_file"]);
            $registros   = $this->Subir_archivos_model->generar_excel_sidunea($_GET ["c807_file"], $_GET['doc_transporte']);

            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getProperties()
                        ->setCreator("IMPALA - C807")
                        ->setLastModifiedBy("Maarten Balliauw")
                        ->setTitle("Office 2007 XLSX Test Document")
                        ->setSubject("Office 2007 XLSX Test Document")
                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                        ->setKeywords("office 2007 openxml php")
                        ->setCategory("Poliza");

            $pos = 1;
            if ($registros) {
                $total_Cuantia = 0;
                $total_fob     = 0;

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'supplementaryunits') {
                            $total_Cuantia += $field;
                        }
                        if ($item == 'fob') {
                            $total_fob += $field;
                        }
                    }
                }

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'partida') {
                            $this->datos['partida'] = $field;
                        }
                        if ($item == 'countryoforigin') {
                            $det_Paises = '';

                            if (isset($this->datos['partida'])) {
                                $paises = $this->Subir_archivos_model->traer_paises($this->datos);

                                

                                for ($i=0; $i < count($paises) ; $i++) {
                                    foreach ($paises[$i] as $key => $value) {
                                        $det_Paises = $det_Paises . $value . ",";
                                    }
                                }
                            }

                            $registros[$x]->countryoforigin = $det_Paises;
                        }
                    }
                }

                $bulto_por_partida = $_GET["tot_bultos"] / count($registros);
                $peso_por_partida  = $_GET["tot_kilos"] / count($registros);

                //Calculo de Flete, Seguro y Otros
                $cuantia_Paquete = 0;
                $fob_Paquete     = 0;
                $flete_Paquete   = 0;
                $seguro_Paquete  = 0;
                $otros_Paquete   = 0;

                $cuantia_paq_calculado  = 0;
                $flete_paq_calculado    = 0;
                $seguro_paq_calculado   = 0;
                $otros_paq_calculado    = 0;
                $peso_bruto_calculado   = 0;

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'supplementaryunits') {
                            $cuantia_Paquete = round($field * $_GET["tot_bultos"] / $total_Cuantia, 2);

                            //segun el cuador de prorrateo de excel
                            //$registros[$x]->numero_de_bultos  = $cuantia_Paquete;
                            $cuantia_paq_calculado           += $cuantia_Paquete;
                            $cuantia_Paquete = 0;
                        }

                        if ($item == 'numero_de_bultos') {
                            
                        }

                        if ($item == 'fob') {
                            $fob_Paquete    = round($field * $_GET["tot_kilos"] / $total_fob, 2);


                            //(isset($_GET['c807_file'])) ? $_GET['c807_file'] : '';

                            $flete_Paquete  = round((isset($_GET['flete'])) ? $_GET['flete'] : 0 / $total_fob * $field, 2);
                            $seguro_Paquete = round((isset($_GET['seguro'])) ? $_GET['seguro'] : 0 / $total_fob * $field, 2);
                            $otros_Paquete  = round((isset($_GET['otros'])) ? $_GET['otros'] : 0 / $total_fob * $field, 2);

                            $flete_paq_calculado    += $flete_Paquete;
                            $seguro_paq_calculado   += $seguro_Paquete;
                            $otros_paq_calculado    += $otros_Paquete;

                            //segun el cuadro de excel de prorrateo
                            $registros[$x]->grossmass   = $fob_Paquete;
                            $registros[$x]->netweight   = $fob_Paquete;
                            $peso_bruto_calculado       += $fob_Paquete;
                            $fob_Paquete = 0;
                        }

                        if ($item == 'peso_bruto') {
                           
                        }

                        if ($item == 'flete') {
                            $registros[$x]->flete  = $flete_Paquete;
                            $flete_Paquete = 0;
                        }
                        if ($item == 'seguro') {
                            $registros[$x]->seguro  = $seguro_Paquete;
                            $seguro_Paquete = 0;
                        }
                        if ($item == 'otros') {
                            $registros[$x]->otros  = $otros_Paquete;
                            $otros_Paquete = 0;
                        }
                    }
                }

                $tot_Gastos = 0;
                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'flete') {
                            $tot_Gastos = $field;
                        }
                        if ($item == 'seguro') {
                            $tot_Gastos += $field;
                        }
                        if ($item == 'otros') {
                            $tot_Gastos += $field;
                        }
                        if ($item == 'cif') {
                            $registros[$x]->cif  += $tot_Gastos;
                            $tot_Gastos  = 0;
                        }
                    }
                }


                $registros[0]->grossmass       = $registros[0]->grossmass + $_GET["tot_kilos"] - $peso_bruto_calculado;
                $registros[0]->netweight       = $registros[0]->netweight + $_GET["tot_kilos"] - $peso_bruto_calculado;
                $bulto_por_partida = $_GET["tot_bultos"] / count($registros);
                $peso_por_partida  = $_GET["tot_kilos"] / count($registros);

                //Calculo de Flete, Seguro y Otros
                $cuantia_Paquete = 0;
                $fob_Paquete     = 0;
                $flete_Paquete   = 0;
                $seguro_Paquete  = 0;
                $otros_Paquete   = 0;

                $cuantia_paq_calculado  = 0;
                $flete_paq_calculado    = 0;
                $seguro_paq_calculado   = 0;
                $otros_paq_calculado    = 0;
                $peso_bruto_calculado   = 0;

                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'supplementaryunits') {
                            $cuantia_Paquete = round($field * $_GET["tot_bultos"] / $total_Cuantia, 2);

                            //segun el cuador de prorrateo de excel
                            //$registros[$x]->numero_de_bultos  = $cuantia_Paquete;
                            $cuantia_paq_calculado           += $cuantia_Paquete;
                            $cuantia_Paquete = 0;
                        }

                        if ($item == 'numero_de_bultos') {
                           
                        }

                        if ($item == 'fob') {
                            $fob_Paquete    = round($field * $_GET["tot_kilos"] / $total_fob, 2);


                            //(isset($_GET['c807_file'])) ? $_GET['c807_file'] : '';

                            $flete_Paquete  = round((isset($_GET['flete'])) ? $_GET['flete'] : 0 / $total_fob * $field, 2);
                            $seguro_Paquete = round((isset($_GET['seguro'])) ? $_GET['seguro'] : 0 / $total_fob * $field, 2);
                            $otros_Paquete  = round((isset($_GET['otros'])) ? $_GET['otros'] : 0 / $total_fob * $field, 2);

                            $flete_paq_calculado    += $flete_Paquete;
                            $seguro_paq_calculado   += $seguro_Paquete;
                            $otros_paq_calculado    += $otros_Paquete;

                            //segun el cuadro de excel de prorrateo
                            $registros[$x]->grossmass   = $fob_Paquete;
                            $registros[$x]->netweight   = $fob_Paquete;
                            $peso_bruto_calculado       += $fob_Paquete;
                            $fob_Paquete = 0;
                        }

                        if ($item == 'peso_bruto') {
                          
                        }

                        if ($item == 'flete') {
                            $registros[$x]->flete  = $flete_Paquete;
                            $flete_Paquete = 0;
                        }
                        if ($item == 'seguro') {
                            $registros[$x]->seguro  = $seguro_Paquete;
                            $seguro_Paquete = 0;
                        }
                        if ($item == 'otros') {
                            $registros[$x]->otros  = $otros_Paquete;
                            $otros_Paquete = 0;
                        }
                    }
                }

                $tot_Gastos = 0;
                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'flete') {
                            $tot_Gastos = $field;
                        }
                        if ($item == 'seguro') {
                            $tot_Gastos += $field;
                        }
                        if ($item == 'otros') {
                            $tot_Gastos += $field;
                        }
                        if ($item == 'cif') {
                            $registros[$x]->cif  += $tot_Gastos;
                            $tot_Gastos  = 0;
                        }
                    }
                }


                $registros[0]->grossmass       = $registros[0]->grossmass + $_GET["tot_kilos"] - $peso_bruto_calculado;
                $registros[0]->netweight       = $registros[0]->netweight + $_GET["tot_kilos"] - $peso_bruto_calculado;
                for ($x = 0; $x < count($registros); $x++) {
                    foreach ($registros[$x]  as $item => $field) {
                        if ($item == 'itemnumber') {
                            $registros[$x]->itemnumber = $x+1;
                        }
                    }
                }

                for ($x = 0; $x < count($registros); $x++) {
                    if ($x == 0) {
                        $datos = array();
                        foreach ($registros[$x]  as $item => $field) {
                            $datos[] = $item;
                        }
                        $objPHPExcel->getActiveSheet()->fromArray($datos, null, "A{$pos}");
                        $pos += 1;
                    }

                    $datos = array();
                    foreach ($registros[$x]  as $item => $field) {
                        $datos[] = $field;
                    }
                    $objPHPExcel->getActiveSheet()->fromArray($datos, null, "A{$pos}");
                    $pos += 1;
                }
            }


            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
            $objPHPExcel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$_GET ["c807_file"].'.xls');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            ob_end_clean();
            $objWriter->save('php://output');



            exit;
        } else {
            $this->datos["vista"] = "subir_archivos/generar_archivo_clasificado";
            $this->load->view('principal', $this->datos);
        }
    }



    public function consulta_producto_file()
    {
        $this->datos["vista"] = 'subir_archivos/consulta_productos_file';
        $this->load->view("principal", $this->datos);
    }


    public function generar_rayado()
    {
        if (isset($_GET["c807_file"]) && !empty($_GET["c807_file"])) {
            $registros   = $this->Subir_archivos_model->generar_rayado($_GET["c807_file"]);

            include getcwd() . "/application/libraries/fpdf/fpdf.php";

            // Creacion del PDF

            /*
            * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
            * heredó todos las variables y métodos de fpdf
            */
            $this->pdf = new FPDF();
            // Agregamos una página
            $this->pdf->AddPage();
            // Define el alias para el número de página que se imprimirá en el pie
            $this->pdf->AliasNbPages();

            /* Se define el titulo, márgenes izquierdo, derecho y
            * el color de relleno predeterminado
            */

            $this->pdf->SetTitle("Rayado de Factura");
            $this->pdf->SetLeftMargin(10);
            $this->pdf->SetRightMargin(10);
            $this->pdf->SetFillColor(200, 200, 200);

            // Se define el formato de fuente: Arial, negritas, tamaño 9
            $this->pdf->SetFont('Arial', 'B', 7);

            ///$this->pdf->Ln(7);
            // La variable $x se utiliza para mostrar un número consecutivo
            $x = 0;

            $datos = array();
            foreach ($registros  as $item) {
                if ($x == 0) {
                    $this->pdf->Cell(160, 7, 'Rayado de Factura', 0, 0, 'C', '0');
                    $this->pdf->Cell(10, 7, 'Pagina '. $this->pdf->PageNo() . '/{nb}', 0, 0, 'C', '0');
                    $this->pdf->Ln(9);

                    $this->pdf->Cell(160, 7, 'File Numero: '. $_GET["c807_file"], 0, 0, 'C', '0');
                    $this->pdf->Ln(7);

                    $this->pdf->Cell(10, 7, 'Linea', 'TBL', 0, 'C', '1');
                    $this->pdf->Cell(20, 7, 'Producto', 'TB', 0, 'L', '1');
                    $this->pdf->Cell(80, 7, 'Descripcion', 'TB', 0, 'L', '1');
                    $this->pdf->Cell(30, 7, 'Factura', 'TB', 0, 'L', '1');
                    $this->pdf->Cell(20, 7, 'Partida', 'TBR', 0, 'L', '1');
                    $this->pdf->Cell(10, 7, 'TLC', 'TBR', 0, 'L', '1');
                    $this->pdf->Ln(9);
                }
                $x +=1;
                // Se imprimen los datos de cada producto
                $this->pdf->Cell(10, 5, $item->linea, 0, 0, 'L', 0);
                $this->pdf->Cell(20, 5, $item->Codigo_Producto, 0, 0, 'L', 0);
                $this->pdf->Cell(80, 5, $item->descripcion, 0, 0, 'L', 0);
                $this->pdf->Cell(30, 5, $item->num_factura, 0, 0, 'L', 0);
                $this->pdf->Cell(20, 5, $item->partida, 0, 0, 'L', 0);
                $this->pdf->Cell(10, 5, $item->tlc, 0, 0, 'L', 0);

                $this->pdf->Ln(5);

                if ($x == 48) {
                    $x = 0;
                }
            }


            $this->pdf->Output("Rayado.pdf", 'D');
        } else {
            $this->datos["vista"] = "subir_archivos/generar_archivo_clasificado";
            $this->load->view('principal', $this->datos);
        }
    }


    public function enviar_correo($opcion)
    {

        //$opcion 1 Aforador a Clasificador
        //Buscar los usuario de tipo Clasificador en la base de datos de usuarios
        //Obtener Listado de Usuarios a enviarle el correo
        $texto  = "";
        $asunto = "";
        if ($opcion == 1) {
            $usuario = $this->Subir_archivos_model->buscar_usuarios($_GET['c807_file']);
            $asunto = 'File Numero '. $_GET['c807_file']. ' para clasificacion';
            $texto  = "Se ha creado una nueva poliza en el sistema, para su clasificacion.";
        } else {
            $usuario = $this->Subir_archivos_model->buscar_usuario_aforador($_GET['c807_file']);
            $asunto = 'File Numero '. $_GET['c807_file']. ' lista para declaracion';
            $texto = "Se ha finalizado la clasificacion de la poliza.";
        }


        require(getcwd() . "../../enviar_correo.php");

        $para = array();

        foreach ($usuario as $item) {
            #$para = $para . $item->mail . ';';
            $para[] = $item->mail;
        }

        $user = $this->Conf_model->dtusuario($_SESSION["UserID"]);

      /*  enviarCorreo(array(
            'de'     => array($user->mail, $user->nombre),
            'para'   => $para,
            'asunto' => $asunto,
            'texto'  => $texto
          ), 2);*/

        #  mail($para, $asunto, $texto, "From: $user->mail" );
        //$this->enviar_email($correo);
        //  var_dump($_SESSION());
        if ($opcion == 2) {
            $id_file = $this->Subir_archivos_model->obtener_datos_file($_GET['c807_file']);
            $data = array('id_file' => $id_file->id, 'id_usuario_clasificador' => $_SESSION["UserID"], 'fecha' =>  1);
            $this->Subir_archivos_model->crear_listado_polizas($data);
        }
    }


    public function listado_polizas()
    {
        $this->datos['registros'] = $this->Subir_archivos_model->polizas_no_clasificadas();

        $this->datos["vista"] = 'subir_archivos/listado_polizas';
        $this->load->view("principal", $this->datos);
    }

    
    public function lista_retaceo($file, $doc)
    {
        $datos['l_retaceo']    = $this->Subir_archivos_model->lista_retaceo($file);
        $incremento=1;
        foreach ($datos['l_retaceo'] as $item) {
            $this->Subir_archivos_model->rayar($incremento, $item->partida, $doc);
            $incremento = $incremento + 1;
        }
        $this->load->view('subir_archivos/cuerpo', $datos);
    }

    public function dpr_clasificado($file, $doc)
    {
        $datos['dpr']    = $this->Subir_archivos_model->dpr_clasificado($file);
         
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                  ->setCreator("Duar - C807")
                  ->setTitle("Office 2007 XLSX Test Document")
                  ->setSubject("Office 2007 XLSX Test Document")
                  ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                  ->setKeywords("office 2007 openxml php")
                  ->setCategory("Poliza");  
                                   
        $contador=1;
        $objPHPExcel->getActiveSheet()->setCellValue("A{$contador}", 'Código de Producto');	        
        $objPHPExcel->getActiveSheet()->setCellValue("B{$contador}", 'Descripción');
        $objPHPExcel->getActiveSheet()->setCellValue("C{$contador}", 'Pais Origen');
        $objPHPExcel->getActiveSheet()->setCellValue("D{$contador}", 'Peso kl');	        
        $objPHPExcel->getActiveSheet()->setCellValue("E{$contador}", 'Cuantia');
        $objPHPExcel->getActiveSheet()->setCellValue("F{$contador}", 'Precio Unitario');
        $objPHPExcel->getActiveSheet()->setCellValue("G{$contador}", 'Total'); 
        $objPHPExcel->getActiveSheet()->setCellValue("H{$contador}", 'Factura'); 
        $objPHPExcel->getActiveSheet()->setCellValue("I{$contador}", 'TLC'); 
        $objPHPExcel->getActiveSheet()->setCellValue("J{$contador}", 'Partida');
        $objPHPExcel->getActiveSheet()->setCellValue("K{$contador}", 'DAI');
        $objPHPExcel->getActiveSheet()->setCellValue("L{$contador}", 'Peso Neto');
        $objPHPExcel->getActiveSheet()->setCellValue("M{$contador}", 'Proveedor');
        $objPHPExcel->getActiveSheet()->setCellValue("N{$contador}", 'Flete');
        $objPHPExcel->getActiveSheet()->setCellValue("O{$contador}", 'Seguro');
        $objPHPExcel->getActiveSheet()->setCellValue("P{$contador}", 'Otros Gastos');
        $objPHPExcel->getActiveSheet()->setCellValue("Q{$contador}", 'Permiso');
       
        
        foreach ($datos['dpr'] as $fila) {
            
	      	$contador++;
	      	$objPHPExcel->getActiveSheet()->setCellValue("A{$contador}", $fila->codigo_producto);
		    $objPHPExcel->getActiveSheet()->setCellValue("B{$contador}", $fila->descripcion);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$contador}", $fila->pais_origen);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$contador}", "0");
            $objPHPExcel->getActiveSheet()->setCellValue("E{$contador}", $fila->cuantia);
            $objPHPExcel->getActiveSheet()->setCellValue("F{$contador}", $fila->precio_unitario);
            $objPHPExcel->getActiveSheet()->setCellValue("G{$contador}", $fila->total);
            $objPHPExcel->getActiveSheet()->setCellValue("H{$contador}", $fila->num_factura);
            $objPHPExcel->getActiveSheet()->setCellValue("I{$contador}", $fila->tlc);
            $objPHPExcel->getActiveSheet()->setCellValue("J{$contador}", $fila->partida);
            $objPHPExcel->getActiveSheet()->setCellValue("K{$contador}", "0"); 
            $objPHPExcel->getActiveSheet()->setCellValue("L{$contador}", $fila->peso_neto);
            $objPHPExcel->getActiveSheet()->setCellValue("M{$contador}", $fila->proveedor);
            $objPHPExcel->getActiveSheet()->setCellValue("N{$contador}", $fila->flete);
            $objPHPExcel->getActiveSheet()->setCellValue("O{$contador}", $fila->seguro);
            $objPHPExcel->getActiveSheet()->setCellValue("P{$contador}", $fila->otros_gastos);
            $objPHPExcel->getActiveSheet()->setCellValue("Q{$contador}", $fila->permiso);
           

        }
        $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='."DPR ".$_GET ["c807_file"].'.xls');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
     
        
       
    }

    public function cuadro_duca($file)
    {
        // $file=10;
        $datos['retaceo']    = $this->Subir_archivos_model->lista_retaceo($file);
        $data['facturas']    = $this->Subir_archivos_model->consulta_facturas($file);
        $data_origen['origen']    = $this->Subir_archivos_model->consulta_origenes($file);
        // var_dump($datos['facturas']);

        include getcwd() . "/application/libraries/fpdf/fpdf.php";
        include getcwd()."/" ;
        $this->pdf = new FPDF();
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Cuadro de Retaceo");
        $this->pdf->SetLeftMargin(10);
        $this->pdf->SetRightMargin(10);
        $this->pdf->SetFillColor(200, 200, 200);
        $this->pdf->SetFont('Arial', 'B', 7);
        $x = 0;
        $correla=0;
        $archivo=$_POST['c807_file'];
        $total_bultos=0;
        $total_peso_bruto=0;
        $total_peso_neto=0;
        $total_cuantia=0;
        $monto_total=0;
        $tlc="NO";
        $posicionY=35.00125;
        foreach ($datos['retaceo'] as $item) {
            if ($item->tlc==1) {
                $tlc="SI";
            } else {
                $tlc="NO";
            }

            if ($x == 0) {
                $this->pdf->SetFont('Arial', 'B', 12);
                $this->pdf->Cell(160, 7, 'Cuadro Retaceo', 0, 0, 'C', '0');
                $this->pdf->SetFont('Arial', '', 7);
                $this->pdf->Cell(10, 7, 'Pagina '. $this->pdf->PageNo() . '/{nb}', 0, 0, 'C', '0');
                $this->pdf->Ln(9);

                $this->pdf->Cell(160, 7, 'File Numero: '. $archivo, 0, 0, 'L', '0');
                $this->pdf->Ln(7);
                $this->pdf->Cell(07, 7, 'ID', 'TBL', 0, 'C', '1');
                $this->pdf->Cell(20, 7, 'Partida', 'TBL', 0, 'C', '1');
                $this->pdf->Cell(70, 7, 'Descripcion', 'TB', 0, 'C', '1');
                $this->pdf->Cell(20, 7, 'Bultos', 'TBR', 0, 'R', '1');
                $this->pdf->Cell(16, 7, 'Peso Bruto', 'TBR', 0, 'L', '1');
                $this->pdf->Cell(18, 7, 'Peso Neto', 'TBR', 0, 'L', '1');
                $this->pdf->Cell(20, 7, 'Cuantia', 'TBR', 0, 'L', '1');
                $this->pdf->Cell(10, 7, 'Total', 'TBR', 0, 'L', '1');
                $this->pdf->Cell(10, 7, 'TLC', 'TB', 0, 'L', '1');
        
                $this->pdf->Ln(9);
            }
            $x +=1;
            $correla=$correla+1;
            // $posx=$this->pdf->GetX();
            // $posy=$this->pdf->GetY();
            //  $this->pdf->Cell(20, 5, $posx." -- ".$posy, 0, 0, 'R', 0);
            //  $this->pdf->Cell(20, 5, $posicion, 0, 0, 'R', 0);
            $this->pdf->Cell(07, 5, $correla, 0, 0, 'C', 0);
            $this->pdf->Cell(20, 5, $item->partida, 0, 0, 'L', 0);
           
            
            $this->pdf->MultiCell(70, 5, $item->nombre, 0, 'L');
            $y=$this->pdf->GetY();
         
            //  $this->pdf->SetY($posy);
            $this->pdf->SetY($y-5);
            $this->pdf->SetX(108);
           
            $this->pdf->Cell(20, 5, $item->bultos, 0, 0, 'R', 0);
            $this->pdf->Cell(15, 5, $item->peso_bruto, 0, 0, 'R', 0);
            $this->pdf->Cell(15, 5, $item->peso_neto, 0, 0, 'R', 0);
            $this->pdf->Cell(15, 5, $item->cuantia, 0, 0, 'R', 0);
            $this->pdf->Cell(17, 5, $item->total, 0, 0, 'R', 0);
            $this->pdf->Cell(13, 5, $tlc, 0, 0, 'C', 0);
            //  $this->pdf->Cell(20, 5, $posy."-".$y, 0, 0, 'R', 0);
            //$this->pdf->SetY($y);
            $total_bultos=$total_bultos+$item->bultos;
            $total_peso_bruto=$total_peso_bruto+$item->peso_bruto;
            $total_peso_neto=  $total_peso_neto+$item->peso_neto;
            $total_cuantia=$total_cuantia+ $item->cuantia;
            $monto_total=$monto_total+$item->total;
            
            //  $posicionY=$posicionY+10;
            // $this->pdf->SetY($posicionY+10);
            $this->pdf->Ln(5);
        }
        //
      
        $this->pdf->Ln(7);
              
        $this->pdf->Cell(117, 7, $total_bultos, 'TBR', 0, 'R', '1');
        $this->pdf->Cell(16, 7, $total_peso_bruto, 'TBR', 0, 'R', '1');
        $this->pdf->Cell(15, 7, $total_peso_neto, 'TBR', 0, 'R', '1');
        $this->pdf->Cell(15, 7, $total_cuantia, 'TBR', 0, 'R', '1');
        $this->pdf->Cell(16, 7, $monto_total, 'TBR', 0, 'R', '1');
        $this->pdf->Cell(14, 7, ' ', 'TBR', 0, 'R', '1');


        //Resumen retaceo (agrupado por numero de facturas)
        $this->pdf->Ln(15);
        $this->pdf->Cell(20);
        $this->pdf->Cell(25, 7, 'FACTURA', 'TBL', 0, 'C', '1');
        $this->pdf->Cell(25, 7, 'FOB', 'TBL', 0, 'R', '1');
        $this->pdf->Cell(25, 7, 'FLETE', 'TB', 0, 'R', '1');
        $this->pdf->Cell(25, 7, 'P/S', 'TBR', 0, 'R', '1');
        $this->pdf->Cell(25, 7, 'CIP', 'TBR', 0, 'R', '1');
        $this->pdf->Cell(25, 7, 'TLC', 'TBR', 0, 'R', '1');

      
        $this->pdf->Ln(7);
        $tlc="NO";
        $total_fob=0;
        $total_flete;
        $total_seguro=0;
        $total_cip=0;

        foreach ($data['facturas'] as $row) {
            if ($row->tlc==1) {
                $tlc="SI";
            } else {
                $tlc="NO";
            }

            $seguro= $row->seguro + $row->otros_gastos;
            $cip=$row->total + $row->flete + $row->seguro + $row->otros_gastos;
            $this->pdf->Cell(20);
            $this->pdf->Cell(25, 5, $row->num_factura, 0, 0, 'R', 0);
            $this->pdf->Cell(25, 5, number_format($row->total, 2), '0', 0, 'R', '');
            $this->pdf->Cell(25, 5, number_format($row->flete, 2), '0', 0, 'R', '');
            $this->pdf->Cell(25, 5, number_format($seguro, 2, '.', ''), '0', 0, 'R', '');
            $this->pdf->Cell(25, 5, number_format($cip, 2), '0', 0, 'R', '');
            $this->pdf->Cell(25, 5, $tlc, '0', 0, 'R', '');
            $this->pdf->Ln(5);
            $total_fob = $total_fob + $row->total;
            $total_flete = $total_flete + $row->flete;
            $total_seguro = $total_seguro + $seguro;
            $total_cip = $total_cip + $cip;
        }

        $this->pdf->Ln(5);
        $this->pdf->Cell(20);
        $this->pdf->Cell(25, 7, '', 'TBL', 0, 'C', '1');
        $this->pdf->Cell(25, 7, number_format($total_fob, 2), 'TBL', 0, 'R', '1');
        $this->pdf->Cell(25, 7, number_format($total_flete, 2), 'TB', 0, 'R', '1');
        $this->pdf->Cell(25, 7, number_format($total_seguro, 2), 'TBR', 0, 'R', '1');
        $this->pdf->Cell(25, 7, number_format($total_cip, 2), 'TBR', 0, 'R', '1');
        $this->pdf->Cell(25, 7, '', 'TBR', 0, 'R', '1');
       
        //fin resumen facturas

        //Resumen por pais de origen
        $this->pdf->Ln(15);
        $this->pdf->Cell(40, 7, "", '0', 0, 'C', '');
        $this->pdf->Cell(20, 7, 'PARTIDA', 'TBL', 0, 'L', '1');
        $this->pdf->Cell(60, 7, 'ORIGEN', 'TBL', 0, 'L', '1');
        
        $this->pdf->Cell(15, 7, 'TLC', 'TBR', 0, 'C', '1');
        $this->pdf->Cell(15, 7, 'PERMISO', 'TBR', 0, 'C', '1');

     
        $this->pdf->Ln(7);
        $tlc="NO";
        $total_fob=0;
        $total_flete;
        $total_seguro=0;
        $total_cip=0;
        $permiso="NO";
        $item=1;
        $partida_tempo="";
        $bandera=1;
        foreach ($data_origen['origen'] as $row) {
            if ($row->tlc==1) {
                $tlc="SI";
            } else {
                $tlc="NO";
            }

            if ($row->permiso==1) {
                $permiso="SI";
            } else {
                $permiso="NO";
            }
          

            $seguro= $row->seguro + $row->otros_gastos;
            $cip=$row->total + $row->flete + $row->seguro + $row->otros_gastos;
            if ($permiso=="SI") {
                $this->pdf->SetTextColor(194, 8, 8);
            } else {
                $this->pdf->SetTextColor(0, 0, 0);
            }

            if ($item===1) {
                $partida_tempo===$row->partida;
            }
           
            if ($partida_tempo===$row->partida) {
                $item=0;
            } else {
                $item =1;
                $partida_tempo = $row->partida;
            }
            if ($item==1) {
                if ($bandera==1) {
                } else {
                    $this->pdf->Ln(5);
                }
                $bandera=0;
                $this->pdf->SetFont('Arial', 'B', 7);
                $this->pdf->Cell(40, 5, "", 0, 0, 'L', 0);
                $this->pdf->Cell(20, 5, $row->partida, 0, 0, 'L', 0);
                $this->pdf->Cell(60, 5, $row->nombre, 0, 0, 'L', 0);
                $this->pdf->Ln(5);
            }
            $this->pdf->Cell(40, 5, "", 0, 0, 'L', 0);
            $this->pdf->SetFont('Arial', '', 7);
            $this->pdf->Cell(40, 5, "", 0, 0, 'L', 0);
          
            $this->pdf->Cell(40, 5, $row->pais_origen, 0, 0, 'L', 0);
           
            $this->pdf->Cell(15, 5, $tlc, '0', 0, 'C', '');
            $this->pdf->Cell(15, 5, $permiso, '0', 0, 'C', '');
            $this->pdf->Cell(15, 5, "", '0', 0, 'C', '');
           
            $this->pdf->Ln(5);
        }

        $this->pdf->Ln(5);
      
      
        //fin resumen origen

        $destino = getcwd()."/"."Retaceo.php";
       
        $this->pdf->Output($archivo.'.pdf', 'f');
    }
        
    public function lista_origen($id)
    {
        $datos['l_retaceo']    = $this->Subir_archivos_model->lista_origen($id);
        $this->load->view('subir_archivos/cuerpo_origen', $datos);
    }


    public function get_detalle_dpr($id)
    {
        $datos['detalle_dpr']    = $this->Subir_archivos_model->lista_retaceo($id);
        $correla=1;
       
        foreach ($datos['detalle_dpr'] as $row) {
            $data = array(
                'item'                    =>  $correla,
                'duaduana'                =>  $_SESSION['dua'],
                'no_bultos'               =>  $row->bultos,
                'partida'                 =>  $row->partida,
                'descripcion'             =>  $row->descripcion,
                'peso_bruto'              =>  $row->peso_bruto,
                'peso_neto'               =>  $row->peso_neto,
                'u_suplementarias'        =>  $row->cuantia,
                'precio_item'             =>  $row->total,
                'precio_item'             =>  $row->total,
                'seguro'                  =>  $row->seguro,
                'otros'                   =>  $row->otros_gastos,
                'codigo_producto'         =>  $row->codigo_producto,
                'doc_transp'              =>  $row->documento_transporte
               
            );
            $dua_id=$this->Subir_archivos_model->guardar_items_dpr($data);
            $correla=$correla+1;
        }
    }

    
    public function get_id_file($id)
    {
        $file = $this->Subir_archivos_model->get_id_file($id);
        if ($file) {
            echo json_encode($file);
        }
    }
    

    public function lista_cambiar_origen($id)
    {
        $datos['origen']    = $this->Subir_archivos_model->lista_cambiar_origen($id);
        $this->load->view('subir_archivos/cuerpo', $datos);
    }

    public function cambiar_origen($pais, $id)
    {
        $this->Subir_archivos_model->cambiar_origen($pais, $id);
    }
}



/* End of file Controllername.php */