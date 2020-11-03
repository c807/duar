<?php
class Crear extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        if (login()) {
            $modelos = array(
                        'crearpoliza/Crearpoliza_model',
                        'crearpoliza/Detalle_model',
                        'Conf_model'
                        );
            $this->load->model($modelos);
            $this->load->library('PHPExcel.php');
            $datos   = $this->Conf_model->info_accesos_pa($_SESSION['UserID']);
           
            $_SESSION['roll']=$datos->ROLL;
            $_SESSION['add']=$datos->AGREGAR;
            $_SESSION['edit']=$datos->EDITAR;
            $_SESSION['delete']=$datos->ELIMINAR;
            $_SESSION['print']=$datos->IMPRIMIR;
            $_SESSION['consulta']=$datos->CONSULTAR;
            $_SESSION['cargar']=$datos->AGREGAR;
        } else {
            redirect(login_url());
        }
    }

    public function index()
    {
    }

    public function declaracion($file)
    {
        $cre = new Crearpoliza_model(array('file' => $file));
        

        $this->datos['navtext'] = "Póliza File # {$file}";
        $this->datos['modelos'] = $cre->modelos();
        $this->datos['aduanas'] = $cre->Conf_model->aduanas();
        $this->datos['empresas'] = $cre->Conf_model->empresas();
        $this->datos['paises'] = $cre->Conf_model->paises();
        $this->datos['incoterm'] = $cre->Conf_model->incoterm();
        $this->datos['localmercancia'] = $cre->Conf_model->localmercancia();
        $this->datos['modotransporte'] = $cre->Conf_model->modotransporte();
        $this->datos['lugardecarga'] = $cre->Conf_model->lugardecarga();
        $this->datos['presentacion'] = $cre->Conf_model->presentacion();
        $this->datos['tipoBulto'] = $cre->Conf_model->tipoBulto();
        $this->datos['preferencia'] = $cre->Conf_model->preferencia();
        $this->datos['tipodocumento'] = $cre->Conf_model->tipodocumento();
        $this->datos['entidad'] = $cre->Conf_model->entidad();
        $this->datos['equipamiento'] = $cre->Conf_model->equipamiento();
        $this->datos['tipocontenedor'] = $cre->Conf_model->tipocontenedor();
        $this->datos['tipocarga'] = $cre->Conf_model->tipocarga();
        
        //var_dump($cre);
        
        $existef  = 0;
        $duaduana = 0;
        $iddua    = 0;
        $xfile    = $file;
        $numero_file=$file;
        if ($cre->duar) {
            $existef = 1;
            $xfile   = $cre->duar->c807_file;
            $iddua   = $cre->duar->duaduana;
        }
        echo "<br>";
        $_SESSION['numero_file']=$file;
        $_SESSION['dua']=$iddua;
        
        $this->datos['vermod']   = $existef;
        $this->datos['file']     = $xfile;
        $this->datos['duaduana'] = $iddua;
        $this->datos['vista']    = "encabezadopoliza/contenido";
        $this->datos['soli']	 = true;
        $conf = new Conf_model();

        $this->datos['xnombre'] = $conf->dtusuario($_SESSION['UserID'])->nombre;
        //$this->datoenca['datos_dm'] = $this->Crearpoliza_model->detalle_dm($iddua);
        //  echo json_encode($datoenca);
        //var_dump( $this->datos['datos_dm']);
        $this->load->view("principal", $this->datos);
    }

    #Para ver listas dependientes
    public function dependencias()
    {
        switch ($_GET['lista']) {
            case 1:
                echo json_encode($this->Crearpoliza_model->ver_regimenes($_GET));
                break;
            case 2:
                echo json_encode($this->Conf_model->agencia($_GET['codigo']));
                break;
            case 3:
            echo json_encode($this->Conf_model->tipocarga($_GET['codigo']));
                    break;
            default:
                return false;
                break;
        }
    }

    public function encabezado()
    {
        $reg = new Crearpoliza_model($_POST);
        $conf = new Conf_model();

        $this->load->library('forms/Fencabezado');
        $form = new Fencabezado();
        $form->set_accion(base_url('index.php/poliza/crear/guardar'));
        if ($reg->duar) {
            $form->set_datosheader($reg->duar);
            $agencia = $conf->agencia($reg->duar->banco);
        }

        if (verDato($_POST, 'reg_ext') && verDato($_POST, 'modelo')) {
            $mod  = $this->Conf_model->get_modelo($_POST['modelo']);
            $xdec = array('imp_exp' => $mod->imp_exp);

            $form->set_declaracion(array_merge($xdec, $_POST));
        }
        # Para iniciar los catalogos
        $form->set_select(
            array(
                'empresas' => $conf->empresas(),
                'aduanas'  => $conf->aduanas(),
                'modtrans' => $conf->modotransporte(),
                'incoterm' => $conf->incoterm(),
                'lugcarga' => $conf->lugardecarga(),
                'locmerca' => $conf->localmercancia(),
                'presenta' => $conf->presentacion(),
                'bancos'   => $conf->bancos(),
                'paises'   => $conf->paises(),
                'agentes'  => $conf->agentes(),
                'agencia'  => $agencia
                )
        );

        $this->load->view('encabezadopoliza/cuerpo', $form->mostrar());
    }

    public function guardar()
    {
        $crear = new Crearpoliza_model();
        $msj   = "No se puede realizar la acción";
        $res   = "error";

        if (verDato($_GET, 'contenedor')) {
            $_GET['contenedor'] = 1;
        } else {
            $_GET['contenedor'] = 0;
        }

        if ($crear->guardarhead($_GET)) {
            $msj = "Proceso realizado exitosamente";
            $res = "success";
        }

        echo json_encode(
            array(
                    'msj' => $msj,
                    'res' => $res
                    )
        );
    }

    public function empresanit()
    {
        if (verDato($_GET, 'nit')) {
            $cre = new Crearpoliza_model();

            echo json_encode($cre->nitempresa($_GET));
        }
    }

    public function guardar_seg_general()
    {
        $id_dua=$_POST['id_dua'];
        $data = array(
            'aduana_registro'        =>  $_POST['aduana_registro'],
            'manifiesto'             =>  $_POST['manifiesto'],
            'aduana_entrada_salida'  =>  $_POST['aduana_entrada_salida'],
            'modelo'                 =>  $_POST['modelo'],
            'reg_extendido'          =>  $_POST['reg_extendido'],
            'nit_exportador'         =>  $_POST['nit_exportador'],
            'nombre_exportador'      =>  $_POST['nombre_exportador'],
            'nit_consignatario'      =>  $_POST['nit_consignatario'],
            'consignatario'          =>  $_POST['consignatario'],
            'declarante'             =>  $_POST['declarante'],
            'pais_export'            =>  $_POST['pais_export'],
            'registro_transportista' =>  $_POST['registro_transportista'],
            'incoterm'               =>  $_POST['incoterm'],
            'total_facturar'         =>  $_POST['total_facturar'],
            'flete_interno'          =>  $_POST['flete_interno'],
            'flete_externo'          =>  $_POST['flete_externo'],
            'seguro'                 =>  $_POST['seguro'],
            'otros'                  =>  $_POST['otros'],
            'deducciones'            =>  $_POST['deducciones'],
            'localizacion_mercancia' =>  $_POST['localizacion_mercancia'],
            'bultos'                 =>  $_POST['bultos'],
            'referencia'             =>  $_POST['referencia'],
            'pais_proc'              =>  $_POST['pais_proc'],
            'pais_destino'           =>  $_POST['pais_destino'],
            'mod_transp'             =>  $_POST['mod_transp'],
            'pais_transporte'        =>  $_POST['pais_transporte'],
            'lugar_carga'            =>  $_POST['lugar_carga'],
            'presentacion'           =>  $_POST['presentacion'],
            'info_adicional'         =>  $_POST['info_adicional']

        );
      
        $data['c807_file'] =  $_SESSION['numero_file'];
        $id_dua=$_POST['id_dua'];
        $dua_id=$this->Crearpoliza_model->guardar_seg_general($id_dua, $data);
        $data['duaduana'] = $dua_id;
        $_SESSION['dua']=$dua_id;
    }
    
    public function guardar_items()
    {
        $det = new Detalle_model();
        $id_dua=$_POST['id_dua'];
        $id=$det->numitem($_SESSION['dua']);
        $data = array(
            'item'                    =>  $id,
            'duaduana'                =>  $_SESSION['dua'],
            'marcas_uno'              =>  $_POST['marcas_num_uno'],
            'marcas_dos'              =>  $_POST['marcas_num_dos'],
            'no_bultos'               =>  $_POST['numero_paquetes'],
            'tipo_bulto'              =>  $_POST['embalaje'],
            'partida'                 =>  $_POST['codigo_mercancia'],
            'origen'                  =>  $_POST['pais_origen_item'],
            'peso_bruto'              =>  $_POST['peso_bruto'],
            'peso_neto'               =>  $_POST['peso_neto'],
            'codigo_preferencia'      =>  $_POST['preferencia'],
            'cuota'                   =>  $_POST['cuota'],
            'doc_transp'              =>  $_POST['doc_transporte'],
            'u_suplementarias'        =>  $_POST['unidades_sup'],
            'u_suplementarias_uno'    =>  $_POST['unidades_sup_uno'],
            'u_suplementarias_dos'    =>  $_POST['unidades_sup_dos'],
            'referencia_licencia'     =>  $_POST['referencia_licencia'],
            'valor_deducido'          =>  $_POST['valor_deducido'],
            'precio_item'             =>  $_POST['precio_item'],
            'flete_interno'           =>  $_POST['flete_interno_i'],
            'flete_externo'           =>  $_POST['flete_externo_i'],
            'seguro'                  =>  $_POST['id="seguro_item"'],
            'otros'                   =>  $_POST['otros_costos_item'],
            'deducciones'             =>  $_POST['deducciones_item']

        );
     
        //  $id_dua=$_POST['id_dua'];
        $id_detalle=$_POST['id_detalle'];
        $dua_id=$this->Crearpoliza_model->guardar_items($id_detalle, $data);
    }


    public function guardar_adjunto()
    {
        $nombre=$_FILES["file"]["name"];
        $ubicacion = sys_base("duar/public/dmup");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }
       
        $ubicacion .= "/".$nombre;
        //echo $ubicacion;
        // var_dump($_FILES);
        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);
        $encode = chunk_split(base64_encode(file_get_contents($ubicacion)));

        // echo $encode;
        $data = array(
            'item'                          =>  $_POST['item_adjunto'],
            'duaduana'                      =>  $_POST['dua_adjunto'],
            'tipodocumento'                 =>  $_POST['doc_adjunto'],
            'referencia'                    =>  $_POST['referencia_doc'],
            'fecha_documento'               =>  $_POST['fecha_doc'],
            'fecha_expiracion'              =>  $_POST['fecha_exp'],
            'id_pais'                       =>  $_POST['codigo_pais_adj'],
            'id_entidad'                    =>  $_POST['codigo_entidad'],
            'otra_entidad'                  =>  $_POST['otra_entidad'],
            'monto_autorizado'              =>  $_POST['monto_autorizado'],
            'documento_escaneado'           =>  $encode
           
           

        );
        $id= $_POST['id_doc'];
        $dua_id=$this->Crearpoliza_model->guardar_adjunto($id, $data);
    }
    
    public function get_dua($id)
    {
        $file = $this->Crearpoliza_model->get_dua($id);
        if ($file) {
            echo json_encode($file);
        }
    }

    public function lista_items($id)
    {
        $datos['l_items']    = $this->Crearpoliza_model->lista_items($id);
      
        $this->load->view('encabezadopoliza/cuerpo', $datos);
    }

    public function lista_adjuntos($item, $id)
    {
        $datos['l_adjuntos']    = $this->Crearpoliza_model->lista_adjuntos($item, $id);
        
        $this->load->view('encabezadopoliza/cuerpo_adjuntos', $datos);
    }

    public function consulta_adjunto($id)
    {
        $dato = $this->Crearpoliza_model->consulta_adjunto($id);
        if ($dato) {
            echo json_encode($dato);
        }
    }

    public function eliminar_adjunto($id)
    {
        $this->Crearpoliza_model->eliminar_adjunto($id);
    }

    public function eliminar_item($id)
    {
        $this->Crearpoliza_model->eliminar_item($id);
    }

    public function dowload_adjunto($pdf, $ref)
    {
        // $consulta = $this->Crearpoliza_model->dowload_adjunto($pdf);
        $data['saldos'] = $this->Crearpoliza_model->dowload_adjunto($pdf);
         
        include getcwd()."/" ;
        
       
        foreach ($data as $row) {
            $cadena=$row->documento_escaneado;
        }
     
        $archivo= getcwd()."/" .$ref.".pdf";
    
        $pdf_decoded = base64_decode($cadena);
        //Write data back to pdf file
        $pdf = fopen($archivo, 'w');
        fwrite($pdf, $pdf_decoded);
        //close output file
        fclose($pdf);
        $mi_pdf =  $archivo;

        $file=$getcwd()."/".$mi_pdf;
        header('Content-type: application/pdf');
        header('Content-Disposition: download; filename="'.$mi_pdf.'"');
        readfile($mi_pdf);
    }


    /*======================================================================*/

    /* Guarda informacion de equipamiento */
    public function guardar_equipamiento()
    {
        $nombre=$_FILES["file"]["name"];
        $ubicacion = sys_base("duar/public/pdf");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }
   
        $ubicacion .= "/".$nombre;
        
        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);
        $encode = chunk_split(base64_encode(file_get_contents($ubicacion)));

        // echo $encode;
        $data = array(
        'item'                    =>  $_POST['item_eq'],
        'duaduana'                =>  $_SESSION['dua'],
        'idequipamiento'          =>  $_POST['equipamiento'],
        'tamano_equipo'           =>  $_POST['tamano_equipo'],
        'id_equipamiento'         =>  $_POST['id_equipamiento'],
        'contenedor'              =>  $_POST['contenedor'],
        'numero_paquetes'         =>  $_POST['num_paq_eq'],
        'id_contenedor'           =>  $_POST['tipo_contenedor'],
        'id_carga'                =>  $_POST['tipo_carga'],
        'tara'                    =>  $_POST['tara'],
        'peso_mercancias'         =>  $_POST['peso_mercancias'],
       
    );
        $id= $_POST['id_doc_eq'];
        $dua_id=$this->Crearpoliza_model->guardar_equipamiento($id, $data);
    }

    public function lista_equipamiento($id)
    {
        $datos['l_equipamiento']    = $this->Crearpoliza_model->lista_equipamiento($id);
        $this->load->view('encabezadopoliza/cuerpo_equipamiento', $datos);
    }

    public function consulta_equipamiento($id)
    {
        $dato = $this->Crearpoliza_model->consulta_equipamiento($id);
        if ($dato) {
            echo json_encode($dato);
        }
    }
    public function consulta_item($id)
    {
        $dato = $this->Crearpoliza_model->consulta_item($id);
        //  var_dump($dato);
        if ($dato) {
            echo json_encode($dato);
        }
    }

    
    public function eliminar_equipamiento($id)
    {
        $this->Crearpoliza_model->eliminar_equipamiento($id);
    }


    public function consulta_consignatario($id)
    {
        $dato = $this->Crearpoliza_model->consulta_consignatario($id);
        // var_dump($dato);
        if ($dato) {
            echo json_encode($dato);
        }
    }

    public function consulta_dm($id)
    {
        $dato = $this->Crearpoliza_model->consulta_dm($id);
       
        if ($dato) {
            echo json_encode($dato);
        }
    }

    
    public function consulta_producto($id)
    {
        $dato = $this->Crearpoliza_model->consulta_producto($id);
        if ($dato) {
            echo json_encode($dato);
        }
    }



    public function generar_xml($id)
    {
        $datos   = $this->Crearpoliza_model->generar_xml($id);
        $datos_items['items']    = $this->Crearpoliza_model->lista_items($id);
        $datos_docs['doc']    = $this->Crearpoliza_model->listado_adjuntos($id);
        $datos_eq['eq']    = $this->Crearpoliza_model->lista_equipamiento($id);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('	');
        $xml->startDocument('version="1.0" encoding="UTF-8" standalone="no"');

        $xml->startElement("ASYCUDA"); //elemento colegio
           $xml->startElement("Export_release"); //elemento curso
            
                $xml->writeElement("Date_of_exit", "4");
        $xml->writeElement("Time_of_exit", "70");
        $xml->writeElement("Actual_office_of_exit_code", 1);
        $xml->writeElement("Actual_office_of_exit_name", "nombre");
        $xml->writeElement("Exit_reference", "referencia");
        $xml->writeElement("Comments", "Comments");
    
        $xml->endElement(); //fin export_release

        $xml->startElement("Assessment_notice");
        $xml->writeElement("Item_tax_total", 1);
        $xml->endElement(); //fin Assessment_notice

        $xml->startElement("Global_taxes");
        $xml->writeElement("Global_tax_item", 1);
        $xml->endElement(); //fin Global_taxes

        $xml->startElement("Property");
        $xml->startElement("Forms");
        $xml->writeElement("Number_of_the_form", "valor");
        $xml->writeElement("Total_number_of_forms", "valor");
        $xml->endElement(); //fin Forms
        
        $xml->startElement("Nbers");
        $xml->writeElement("Number_of_loading_lists", "valor");
        $xml->writeElement("Total_number_of_items", 1);
        $xml->writeElement("Total_number_of_packages", 1);
        $xml->endElement(); //fin Nbers

        $xml->writeElement("Place_of_declaration", 1);
        $xml->writeElement("Date_of_declaration", 1);
        $xml->writeElement("Selected_page", 1);
        $xml->endElement(); // fin Property

        $xml->startElement("Identification");
        $xml->startElement("Office_segment");
        $xml->writeElement("Place_of_declaration", "valor");
        $xml->writeElement("Customs_clearance_office_code", "valor");
        $xml->endElement(); // fin Identification

        $xml->startElement("Type");
        $xml->writeElement("Type_of_declaration", substr($datos->modelo, 0, 2));
        $xml->writeElement("Declaration_gen_procedure_code", substr($datos->modelo, 3, 1));
        $xml->writeElement("Type_of_transit_document", "valor");
        $xml->endElement();  // fin Type
        $xml->writeElement("Manifest_reference_number", "valor");

        $xml->startElement("Registration");
        $xml->writeElement("Serial_number", "valor");
        $xml->writeElement("Number", "valor");
        $xml->writeElement("Date", "valor");
        $xml->endElement(); // fin Registration

        $xml->startElement("Assessment");
        $xml->writeElement("Serial_number", "valor");
        $xml->writeElement("Number", "valor");
        $xml->writeElement("Date", "valor");
        $xml->endElement(); // fin Assessment

        $xml->startElement("receipt");
        $xml->writeElement("Serial_number", "valor");
        $xml->writeElement("Number", "valor");
        $xml->writeElement("Date", "valor");
        $xml->endElement(); // fin receipt
       
      

        $xml->startElement("Traders");
        $xml->startElement("Exporter");
        $xml->writeElement("Exporter_code", $datos->nit_exportador);
        $xml->writeElement("Exporter_name", $datos->nombre_exportador);
        $xml->endElement(); // fin Exporter

        $xml->startElement("Consignee");
        $xml->writeElement("Consignee_code", $datos->nit_consignatario);
        $xml->writeElement("Consignee_name", $datos->consignatario);
        $xml->endElement(); //fin Consignee

        $xml->startElement("Financial");
        $xml->writeElement("Financial_code", 1);
        $xml->writeElement("Financial_name", "valor");
        $xml->endElement(); //fin Financial

        $xml->endElement(); //fin Traders

        $xml->startElement("Declarant");
        $xml->writeElement("Declarant_code", $datos->declarante);
        $xml->writeElement("Declarant_name", "valor");
        $xml->writeElement("Declarant_representative", "valor");
        $xml->writeElement("Reference", $datos->referencia);
        $xml->endElement(); // fin Declarant

        $xml->startElement("General_information");
        $xml->startElement("Country");
        $xml->writeElement("Country_first_destination", $datos->pais_export);
        $xml->writeElement("Trading_country", "valor");

        $xml->startElement("Export");
        $xml->writeElement("Export_country_code", $datos->pais_export);
        $xml->writeElement("Export_country_region", "valor");
        $xml->endElement(); //Export

        $xml->startElement("Destination");
        $xml->writeElement("Destination_country_code", $datos->pais_destino);
        $xml->writeElement("Destination_country_region", "valor");
        $xml->endElement(); //Destination
        $xml->writeElement("Country_of_origin_name", "valor");

        $xml->endElement(); //Country
        $xml->writeElement("Value_details", "valor");
        $xml->writeElement("CAP", "valor");
        $xml->writeElement("Additional_information", "valor");
        $xml->writeElement("Comments_free_text", "valor");

        $xml->endElement(); // fin General_information

        $xml->startElement("Transport");
        $xml->startElement("Means_of_transport");
                    
        $xml->startElement("Departure_arrival_information");
        $xml->writeElement("Identity", "valor");
        $xml->writeElement("Nationality", "valor");
        $xml->endElement(); // Departure_arrival_information

        $xml->startElement("Border_information");
        $xml->writeElement("Identity", "valor");
        $xml->writeElement("Nationality", "valor");
        $xml->writeElement("Mode", $datos->mod_transp);
        $xml->endElement(); // Border_information
                    
        $xml->writeElement("Inland_mode_of_transport", "valor");

        $xml->endElement(); // Means_of_transport
        $xml->writeElement("Container_flag", "false");

        $xml->startElement("Delivery_terms");
        $xml->writeElement("Code", $datos->fob);
        $xml->writeElement("Place", "valor");
        $xml->writeElement("Situation", "VALOR");
        $xml->endElement(); // Delivery_terms

        $xml->startElement("Border_office");
        $xml->writeElement("Code", $datos->pais_origen);
        $xml->writeElement("Name", "name");
        $xml->endElement(); // Border_office

        $xml->startElement("Place_of_loading");
        $xml->writeElement("Code", $datos->lugar_carga);
        $xml->writeElement("Name", "name");
        $xml->writeElement("Country", "name");
        $xml->endElement(); // Place_of_loading
        $xml->writeElement("Location_of_goods", $datos->localizacion_mercancia);

        $xml->endElement(); // Transport

        $xml->startElement("Financial");

        $xml->startElement("Financial_transaction");
        $xml->writeElement("code1", "valor");
        $xml->writeElement("code2", "valor");
        $xml->endElement(); // Financial

        $xml->startElement("Bank");
        $xml->writeElement("Code", $datos->banco);
        $xml->writeElement("Name", "valor");
        $xml->writeElement("Reference", "valor");
        $xml->endElement(); // Bank

        $xml->startElement("Terms");
        $xml->writeElement("Reference", $datos->presenacion);
        $xml->writeElement("Description", "valor");
        $xml->endElement(); // Terms

        $xml->startElement("Total_invoice");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Total_invoice

        $xml->startElement("Deffered_payment_reference");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Deffered_payment_reference

        $xml->startElement("Mode_of_payment");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Mode_of_payment

        $xml->startElement("Amounts");
        $xml->startElement("Total_manual_taxes");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement();//fin Total_manual_taxes
                    
        $xml->startElement("Global_taxes");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement();//fin Global_taxes

        $xml->startElement("Totals_taxes");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement();//fin Totals_taxes

        $xml->endElement(); // Amounts

        $xml->startElement("Guarantee");
        $xml->startElement("Name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Name

        $xml->startElement("Amount");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Amount

        $xml->startElement("Date");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Date

        $xml->startElement("Excluded_country");
                        
        $xml->startElement("Code");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Code

        $xml->startElement("Name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Name

        $xml->endElement(); // Excluded_country

        $xml->endElement(); // Guarantee

        $xml->endElement(); // Financial
          
        $xml->startElement("Warehouse");
        $xml->startElement("Identification");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin  Identification

        $xml->startElement("Delay");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Delay
            $xml->endElement(); // fin  Warehouse
            

            $xml->startElement("Transit");
        $xml->startElement("Principal");
                
        $xml->startElement("Code");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Code

        $xml->startElement("Name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Code

        $xml->startElement("Representative");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Representative
               
        $xml->endElement(); //fin Principal

        $xml->startElement("Signature");
                    
        $xml->startElement("Place");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement();

        $xml->startElement("Date");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement();

        $xml->endElement(); //fin Signature


        $xml->startElement("Destination");
                    
        $xml->startElement("Office");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Office

        $xml->startElement("Country");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Country

        $xml->endElement(); //fin Destination

        $xml->startElement("Seals");
                    
        $xml->startElement("Number");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Number

        $xml->startElement("Identity");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Identity

        $xml->endElement(); //fin Seals
               
        $xml->startElement("Result_of_control");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Result_of_control

        $xml->startElement("Time_limit");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Time_limit

        $xml->startElement("Officer_name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Officer_name

        $xml->endElement(); // fin  Transit
          
        $xml->startElement("Valuation");
        $xml->writeElement("Calculation_working_mode", "valor");
               
        $xml->startElement("Weight");

        $xml->startElement("Gross_weight");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Gross_weight

        $xml->startElement("Total_cost");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Total_cost

        $xml->startElement("Total_CIF");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Total_CIF

        $xml->endElement(); // fin Weight

        $xml->startElement("Gs_Invoice");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        $xml->writeElement("Amount_foreign_currency", "valor");
        $xml->writeElement("Currency_code", "valor");

        $xml->startElement("Currency_name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_name

        $xml->startElement("Currency_rate");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_rate

        $xml->endElement(); // fin Gs_Invoice
                
        $xml->startElement("Gs_external_freight");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        $xml->writeElement("Amount_foreign_currency", "valor");
        $xml->writeElement("Currency_code", "valor");

        $xml->startElement("Currency_name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_name

        $xml->startElement("Currency_rate");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_rate

        $xml->endElement(); // fin Gs_external_freight

        $xml->startElement("Gs_insurance");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        $xml->writeElement("Amount_foreign_currency", "valor");
        $xml->writeElement("Currency_code", "valor");

        $xml->startElement("Currency_name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_name

        $xml->startElement("Currency_rate");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_rate

        $xml->endElement(); // fin Gs_insurance

        $xml->startElement("Gs_other_cost");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        $xml->writeElement("Amount_foreign_currency", "valor");
        $xml->writeElement("Currency_code", "valor");

        $xml->startElement("Currency_name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_name

        $xml->startElement("Currency_rate");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_rate

        $xml->endElement(); // fin Gs_other_cost

        $xml->startElement("Gs_deduction");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        $xml->writeElement("Amount_foreign_currency", "valor");
        $xml->writeElement("Currency_code", "valor");

        $xml->startElement("Currency_name");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_name

        $xml->startElement("Currency_rate");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_rate

        $xml->endElement(); // fin Gs_deduction

        $xml->startElement("Total");

        $xml->startElement("Total_invoice");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Total_invoice

        $xml->startElement("Total_weight");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Currency_name

        $xml->endElement(); // fin Total

        $xml->endElement(); // fin Valuation

        $xml->startElement("FAUCA");

        $xml->startElement("FAUCA_Fecha_vencimiento");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Fecha_vencimiento

        $xml->startElement("FAUCA_Forma_Pago");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Forma_Pago

        $xml->startElement("FAUCA_Medio_Pago");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Medio_Pago

        $xml->startElement("FAUCA_Aduana_Destino");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Aduana_Destino

        $xml->startElement("FAUCA_Aduana_Salida");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Aduana_Salida

        $xml->startElement("FAUCA_Fecha_Embarque");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Fecha_Embarque

        $xml->startElement("FAUCA_Productor_Nombre");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Productor_Nombre

        $xml->startElement("FAUCA_Productor_Cargo");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Productor_Cargo

        $xml->startElement("FAUCA_Productor_Empresa");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_Productor_Empresa

                
        $xml->startElement("FAUCA_ProductorEx_Nombre");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_ProductorEx_Nombre

        $xml->startElement("FAUCA_ProductorEx_Cargo");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_ProductorEx_Cargo

        $xml->startElement("FAUCA_ProductorEx_Empresa");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin FAUCA_ProductorEx_Empresa

        $xml->endElement(); // fin FAUCA

        $xml->startElement("Item");
        foreach ($datos_items['items']  as $item) {
            $xml->writeElement("Amount_foreign_currency", 1);
               
            $xml->startElement("Packages");
            $xml->writeElement("Number_of_packages", $item->no_bultos);
            $xml->writeElement("Amount_foreign_currency", $item->marcas_uno);
            $xml->writeElement("Amount_foreign_currency", $item->marcas_dos);
            $xml->writeElement("Kind_of_packages_code", $item->origen);
            $xml->endElement(); // fin Packages

            $xml->startElement("Tarification");

            $xml->startElement("Tarification_data");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Tarification_data

            $xml->startElement("HScode");
            $xml->writeElement("Commodity_code", "valor");
            $xml->writeElement("Precision_1", "valor");
                        
            $xml->startElement("Precision_2");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Precision_2
                        
            $xml->startElement("Precision_3");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Precision_3

            $xml->startElement("Precision_4");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Precision_4


            $xml->endElement(); // fin HScode

            $xml->writeElement("PreciPreference_codesion_1", $item->codigo_preferencia);
            $xml->writeElement("Extended_customs_procedure", "valor");
            $xml->writeElement("National_customs_procedure", "valor");

            $xml->startElement("Quota_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Quota_code

            $xml->startElement("Quota");

            $xml->startElement("Quota_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Quota_code

            $xml->startElement("QuotaId");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin QuotaId

            $xml->startElement("QuotaItem");
            $xml->startElement("ItmNbr");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin QuotaItem
                        $xml->endElement(); // fin ItmNbr

                    $xml->endElement(); // fin Quota

            $xml->startElement("Supplementary_unit");

            $xml->startElement("Suppplementary_unit_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_code

            $xml->startElement("Suppplementary_unit_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_name

            $xml->startElement("Suppplementary_unit_quantity");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_quantity

            $xml->endElement(); // fin Supplementary_unit

            $xml->startElement("Supplementary_unit");

            $xml->startElement("Suppplementary_unit_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_code

            $xml->startElement("Suppplementary_unit_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_name

            $xml->startElement("Suppplementary_unit_quantity");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_quantity

            $xml->endElement(); // fin Supplementary_unit

            $xml->startElement("Supplementary_unit");

            $xml->startElement("Suppplementary_unit_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_code

            $xml->startElement("Suppplementary_unit_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_name

            $xml->startElement("Suppplementary_unit_quantity");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_quantity

            $xml->endElement(); // fin Supplementary_unit

            $xml->writeElement("Item_price", $item->precio_item); //me que en line 600
                                      
            $xml->startElement("Valuation_method_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Valuation_method_code

            $xml->startElement("Value_item");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Value_item

            $xml->startElement("Attached_doc_item");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Attached_doc_item

            $xml->startElement("A.I._code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin A.I._code

            $xml->endElement(); // fin Tarification

            $xml->startElement("Goods_description");
            $xml->writeElement("Country_of_origin_code", $item->origen);
                    
            $xml->startElement("Country_of_origin_region");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Country_of_origin_region

            $xml->startElement("Description_of_goods");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Description_of_goods

            $xml->writeElement("Commercial_Description", $item->desc_sac);
                  

            $xml->endElement(); // fin Goods_description

            $xml->startElement("Previous_doc");
            $xml->writeElement("Summary_declaration", $item->desc_sac);
                    
            $xml->startElement("Summary_declaration_sl");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Summary_declaration_sl

            $xml->startElement("Previous_document_reference");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Previous_document_reference

            $xml->startElement("Previous_warehouse_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Previous_warehouse_code

            $xml->endElement(); // fin Previous_doc

            $xml->startElement("Licence");

            $xml->startElement("Licence_number");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Licence_number

            $xml->startElement("Amount");
            $xml->writeElement("Amount_deducted_from_licence", "valor");
            $xml->startElement("Quantity_deducted_from_licence");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Quantity_deducted_from_licence

            $xml->endElement(); // fin Amount

            $xml->endElement(); // fin Licence

            $xml->startElement("Free_text_1");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Free_text_1

            $xml->startElement("Free_text_2");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Free_text_2

            $xml->startElement("Taxation");

            $xml->startElement("Item_taxes_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Item_taxes_amount

            $xml->startElement("Item_taxes_guaranted_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Item_taxes_guaranted_amount

            $xml->startElement("Item_taxes_mode_of_payment");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Item_taxes_mode_of_payment

            $xml->startElement("Counter_of_normal_mode_of_payment");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Counter_of_normal_mode_of_payment

            $xml->startElement("Displayed_item_taxes_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Displayed_item_taxes_amount

            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

                   
            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

                   
            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line

                   
            $xml->startElement("Taxation_line");

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_code

            $xml->startElement("Duty_tax_Base");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Base

            $xml->startElement("Duty_tax_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_rate
                        
            $xml->startElement("Duty_tax_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_amount

            $xml->startElement("Duty_tax_MP");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_MP

            $xml->startElement("Duty_tax_Type_of_calculation");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Duty_tax_Type_of_calculation

            $xml->endElement(); // fin Taxation_line
               
            $xml->endElement(); // fin Taxation

            $xml->startElement("Valuation_item");
            $xml->writeElement("Gross_weight_itm", $item->peso_bruto);
            $xml->writeElement("Gross_weight_itm", $item->peso_neto);

            $xml->startElement("Total_cost_itm");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Total_cost_itm

            $xml->startElement("Total_CIF_itm");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Total_CIF_itm

            $xml->startElement("Rate_of_adjustement");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Rate_of_adjustement

            $xml->startElement("Statistical_value");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Statistical_value

            $xml->startElement("Alpha_coeficient_of_apportionment");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Alpha_coeficient_of_apportionment

            $xml->startElement("Item_Invoice");
                        
            $xml->startElement("Amount_national_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_national_currency

            $xml->writeElement("Amount_foreign_currency", $item->peso_neto);

            $xml->startElement("Currency_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_name

            $xml->startElement("Currency_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_rate

            $xml->endElement(); // fin Item_Invoice

            $xml->startElement("item_external_freight");
                        
            $xml->startElement("Amount_national_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_national_currency

            $xml->startElement("Amount_foreign_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_foreign_currency

            $xml->startElement("Currency_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_name

            $xml->startElement("Currency_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_name

            $xml->endElement(); // fin item_external_freight

            $xml->startElement("item_insurance");
                     
            $xml->startElement("Amount_national_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_national_currency

            $xml->startElement("Amount_foreign_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_foreign_currency

            $xml->startElement("Currency_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code


            $xml->endElement(); // fin item_insurance

            $xml->startElement("item_other_cost");
                    
            $xml->startElement("Amount_national_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_national_currency

            $xml->startElement("Amount_foreign_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_foreign_currency

            $xml->startElement("Currency_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_name

            $xml->startElement("Currency_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_rate

            $xml->endElement(); // fin item_other_cost

            $xml->startElement("item_deduction");

            $xml->startElement("Amount_national_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_national_currency

            $xml->startElement("Amount_foreign_currency");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Amount_national_currency

            $xml->startElement("Currency_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_name

            $xml->startElement("Currency_rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_rate

            $xml->endElement(); // fin item_deduction

            $xml->startElement("Market_valuer");
                        
            $xml->startElement("Rate");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Rate

            $xml->startElement("Currency_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_code

            $xml->startElement("Currency_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Currency_amount

            $xml->startElement("Basis_description");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Basis_description

            $xml->startElement("Basis_amount");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Basis_amount

            $xml->endElement(); // fin Market_valuer

            $xml->endElement(); // fin Valuation_item

            $xml->startElement("FAUCA_item");

            $xml->startElement("FAUCA_criterio_origen");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin FAUCA_criterio_origen

            $xml->startElement("FAUCA_reglas_accesorias");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin FAUCA_reglas_accesorias

            $xml->endElement(); // fin FAUCA_item

            foreach ($datos_docs['doc'] as $doc) {
                $xml->startElement("Attached_documents");

                $xml->startElement("Attached_documents");
                $xml->writeElement("Amount_foreign_currency", $doc->tipodocumento);
                $xml->writeElement("Amount_foreign_currency", "FACTURA O DUCUMENTO EQUIVALENTE");

                $xml->startElement("Attached_document_from_rule");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_from_rule

                $xml->writeElement("Attached_document_date", $doc->fecha_documento);
                $xml->writeElement("Temp_attached_document_item", $doc->item);
                $xml->writeElement("Attached_document_reference", $doc->referencia);

                $xml->startElement("Attached_document_date_expiration");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_date_expiration

                $xml->startElement("Attached_document_country_code");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_country_code

                $xml->startElement("Attached_document_entity_code");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_entity_code

                $xml->startElement("Attached_document_entity_name");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_entity_name

                $xml->startElement("Attached_document_entity_other");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_entity_name

                $xml->writeElement("Attached_document_amount", "0.0");

                $xml->endElement(); // fin Attached_documents

                $xml->endElement(); // fin Attached_documents
            } //fin  foreach doc
        } // fin foreach items
            $xml->endElement(); //fin Item

            $xml->startElement("Temp");
        $xml->startElement("Scanned_Documents_CDATA");
        //incrustar adjuntos aqui
                $xml->endElement(); //fin Scanned_Documents_CDATA
            $xml->endElement(); // fin Temp

            $xml->startElement("Container");
        foreach ($datos_eq['eq'] as $eq) {
            $xml->startElement("Item");
            $xml->writeElement("Attached_document_reference", $eq->item);
            $xml->endElement(); //fin Item

            $xml->writeElement("Equipment_type", $eq->id_equipamiento);
            $xml->writeElement("Equipment_size", $eq->tamano_equipo);
            $xml->writeElement("ID_equipment", $eq->idequipamiento);

            $xml->startElement("Container_identity");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Container_identity

            $xml->startElement("Container_type");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Container_type

            $xml->writeElement("Empty_full_indicator", $eq->idcarga);
            $xml->writeElement("Gross_weight", "0.0");
                    
            $xml->startElement("Package");
            $xml->writeElement("Packages_number", $eq->numero_paquetes);
            $xml->writeElement("Packages_weight", $eq->peso_mercancias);
            $xml->endElement(); // fin Package
        }
                
        $xml->endElement(); // fin Container

    
        $xml->endElement(); //fin asycuda
 
        $content = $xml->outputMemory();
        ob_end_clean();
        ob_start();
        header('Content-Type: application/xml; charset=UTF-8');
        header('Content-Encoding: UTF-8');
        header("Content-Disposition: attachment;filename=ejemplo.xml");
        header('Expires: 0');
        header('Pragma: cache');
        header('Cache-Control: private');
        echo $content;
     
        /*  $xml = '<root>';
          foreach ($datos as $row) {
              $xml .= '<item>
               <name>'.$row->anio.'</name>
               <price>'.$row->aduana_registro.'</price>
               <image>'.$row->declarante.'</image>
             </item>';
          }
          $xml .= '</root>';
          $this->output->set_content_type('text/xml');
         $this->output->set_output($xml);*/
    }
    
    /*======================================================================*/

    public function info_accesos()
    {
        $datos   = $this->Conf_modal->info_accesos();
        
    }

    public function verifica_permiso($opcion)
    {
       // $datos = $this->Conf_modal->info_accesos();
      

      //  var_dump($datos);
       
       /* $_SESSION['roll']=$datos->ROLL;
        $_SESSION['add']=$datos->AGREGAR;
        $_SESSION['edit']=$datos->EDITAR;
        $_SESSION['delete']=$datos->ELIMINAR;
        $_SESSION['print']=$datos->IMPRIMIR;
        $_SESSION['consulta']=$datos->CONSULTAR; */

       // echo  "here i am". $_SESSION['roll'];
        if ($opcion==1  || $opcion==7)  {
            $permiso=$_SESSION['add'];
        }
      
        
        if ($opcion==2)  {
            $permiso=$_SESSION['edit'];
        }
        
        if ($opcion==3)  {
           $permiso= $_SESSION['delete'];
        }

        
        if ($opcion==6) {
            $permiso=$_SESSION['consulta'];
        }

        if ($opcion==7) {
            $permiso=$_SESSION['add'];
        }
 
        $data = array(
            'permiso'        => $permiso
        );

        echo json_encode($data);
    }
}
