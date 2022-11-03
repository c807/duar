<?php
class Crear extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('global');
        if (login()) {
            $modelos = array(
                'crearpoliza/Crearpoliza_model',
                'crearpoliza/Detalle_model',
                'Conf_model'
            );
            $this->load->model($modelos);
            $datos   = $this->Conf_model->info_accesos_pa($_SESSION['UserID']);
            $_SESSION['roll'] = $datos->ROLL;
            $_SESSION['add'] = $datos->AGREGAR;
            $_SESSION['edit'] = $datos->EDITAR;
            $_SESSION['delete'] = $datos->ELIMINAR;
            $_SESSION['print'] = $datos->IMPRIMIR;
            $_SESSION['consulta'] = $datos->CONSULTAR;
            $_SESSION['cargar'] = $datos->AGREGAR;
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
        $numero_file = $file;
        if ($cre->duar) {
            $existef = 1;
            $xfile   = $cre->duar->c807_file;
            $iddua   = $cre->duar->duaduana;
        }
        echo "<br>";
        $_SESSION['numero_file'] = $file;
        $_SESSION['dua'] = $iddua;

        $this->datos['vermod']   = $existef;
        $this->datos['file']     = $xfile;
        $this->datos['duaduana'] = $iddua;
        $this->datos['duaduana'] = $iddua;
        $this->datos['vista']    = "encabezadopoliza/contenido";
        $this->datos['soli']     = true;
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
    public function get_regimen($modelo,$reg_e, $reg_a){
        $cadena = str_replace("%20", " ", $modelo);
        $modelo = $cadena;
        $rsl=$this->Crearpoliza_model->get_regimen($modelo,$reg_e,$reg_a);
        echo json_encode($rsl);
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

        $id_dua = $_POST['id_dua'];
        $data = array(
            'aduana_registro'        =>  $_POST['aduana_registro'],
            'manifiesto'             =>  $_POST['manifiesto'],
            'aduana_entrada_salida'  =>  $_POST['aduana_entrada_salida'],
            'modelo'                 =>  $_POST['modelo'],
            'reg_extendido'          =>  $_POST['reg_extendido'],
            'reg_adicional'          =>  $_POST['regimen_id'],
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
            'info_adicional'         =>  $_POST['info_adicional'],
            'pais_reg_tm'            =>  $_POST['pais_reg_tm'],
            'registro_nac_medio'     =>  $_POST['registro_nac_medio'],
            'banco'                  =>  "00",
            'agencia'                =>  "000"
        );

        $data['c807_file'] =  $_SESSION['numero_file'];
        $id_dua = $_POST['id_dua'];
        $dua_id = $this->Crearpoliza_model->guardar_seg_general($id_dua, $data);
        $data['duaduana'] = $dua_id;
        $_SESSION['dua'] = $dua_id;
    }

    public function guardar_items()
    {
        $det = new Detalle_model();
        $id_dua = $_POST['id_dua'];

        $id_detalle = $_POST['id_detalle'];
        if ($id_detalle) {
            $id = $_POST['item_id'];
        } else {
            $id = $det->numitem($_SESSION['dua']);
        }


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


        $dua_id = $this->Crearpoliza_model->guardar_items($id_detalle, $data);
    }


    public function guardar_adjunto($id, $dua,$num_item)
    {
        header('Content-Type: application/json; charset=utf-8');
        $nombre = $_FILES["file"]["name"];
        $ubicacion = sys_base("duar/public/dmup");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }

        $ubicacion .= "/" . $nombre;
        if ($id == 0) {

            $item = $_POST['item_adjunto'];
            $id_dua = $_POST['item_adjunto'];
        } else {
            $id_dua = $dua;
            // $ubicacion .= "/".$nombre."_".$id;
            $item = $id;
        }

        $cadena = $nombre;
        
        $t = strlen($cadena);
        $num = 0 - $t;
        $rest = substr($cadena, $num, -4); // devuelve "de"
        $nombre = $rest;
        if ($num_item >0 ){
            $nombre=$nombre."-0".$num_item;
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);

        $encode = chunk_split(base64_encode(file_get_contents($ubicacion)));
        $size =  filesize($ubicacion);

        $data = array(
            'item'                          =>  $item,
            'duaduana'                      =>  $id_dua,
            'tipodocumento'                 =>  $_POST['doc_adjunto'],
            'referencia'                    =>  $_POST['referencia_doc'],
            'fecha_documento'               =>  $_POST['fecha_doc'],
            'fecha_expiracion'              =>  $_POST['fecha_exp'],
            'id_pais'                       =>  $_POST['codigo_pais_adj'],
            'id_entidad'                    =>  $_POST['codigo_entidad'],
            'otra_entidad'                  =>  $_POST['otra_entidad'],
            'monto_autorizado'              =>  $_POST['monto_autorizado'],
            'documento_escaneado'           =>  $encode,
            'nombre_documento'              =>  $nombre,
            'atd_file_size'                 =>  $size

        );
        $id = $_POST['id_doc'];
        $dua_id = $this->Crearpoliza_model->guardar_adjunto($id, $data);
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
        $this->datos['tipodocumento'] = $this->Conf_model->tipodocumento();
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

        include getcwd() . "/";


        foreach ($data as $row) {
            $cadena = $row->documento_escaneado;
        }

        $ref = str_replace("%20"," ",$ref);
        
        $archivo = getcwd() . "/" . $ref . ".pdf";

        $pdf_decoded = base64_decode($cadena);
       
        $pdf = fopen($archivo, 'w');
       
        fwrite($pdf, $pdf_decoded);
        
        fclose($pdf);

        $mi_pdf =  $archivo;

        $file = $getcwd() . "/" . $mi_pdf;
        header('Content-type: application/pdf');
        header('Content-Disposition: download; filename="' . $mi_pdf . '"');
        readfile($mi_pdf);
    }


    /*======================================================================*/

    /* Guarda informacion de equipamiento */
    public function guardar_equipamiento()
    {
        $nombre = $_FILES["file"]["name"];
        $ubicacion = sys_base("duar/public/pdf");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }

        $ubicacion .= "/" . $nombre;

        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);
        $encode = chunk_split(base64_encode(file_get_contents($ubicacion)));
        $container = " ";
        if (isset($_POST['tipo_contenedor'])) {
            $container = $_POST['tipo_contenedor'];
        }
      //  echo "fffffffffffffffffffffffffffffffffffffffffffffffffff" . $container;
        // echo $encode;
        $data = array(
            'item'                    =>  $_POST['item_eq'],
            'duaduana'                =>  $_SESSION['dua'],
            'idequipamiento'          =>  $_POST['equipamiento'],
            'tamano_equipo'           =>  $_POST['tamano_equipo'],
            'id_equipamiento'         =>  $_POST['id_equipamiento'],
            'contenedor'              =>  $_POST['contenedor'],
            'numero_paquetes'         =>  $_POST['num_paq_eq'],
            'id_contenedor'           =>  $container,
            'id_carga'                =>  $_POST['tipo_carga'],
            'tara'                    =>  $_POST['tara'],
            'peso_mercancias'         =>  $_POST['peso_mercancias'],

        );
        $id = $_POST['id_doc_eq'];
        $dua_id = $this->Crearpoliza_model->guardar_equipamiento($id, $data);
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


    public function generar_xml($id, $ref_duca)
    {



        ini_set('memory_limit', '-1'); // enabled the full memory available.
        ini_set('max_execution_time', 480);
        date_default_timezone_set('America/Guatemala');
        ini_set('memory_limit', '1024M');
        header('Content-Type: application/json'); //cabecera json
        $data = array("ATTACHED_DOCUMENTS_LIST" => array());
        $general   = $this->Crearpoliza_model->generar_xml($id);
        //  echo var_dump($general);

        $datos_items['items']    = $this->Crearpoliza_model->lista_items($id);
        $datos_docs['doc']    = $this->Crearpoliza_model->listado_adjuntos($id);

        $datos_eq['eq']    = $this->Crearpoliza_model->lista_equipamiento($id);
        $doc_scaneado = "";


        foreach ($datos_docs['doc']  as  $adjunto) {

            $tipo_documento = $adjunto->tipodocumento;
            $referencia = $adjunto->referencia;
            $doc_scaneado = $adjunto->documento_escaneado;

            $str = str_replace(array("\r\n", "\r", "\n"), '', $doc_scaneado);
            $ref = str_replace(array("\r\n", "\r", "\n"), '', $referencia);

            array_push($data['ATTACHED_DOCUMENTS_LIST'], array(
                'ITM_NBR'     => $adjunto->item,
                'ATD_COD'     => $tipo_documento,
                'ATD_REF'     => trim($ref),
                'ATD_FIL_BYT' => trim($str),
                'ATD_FIL_NAM' => trim($adjunto->nombre_documento . '.PDF'),
                'ATD_FIL_CTY' => 'APPLICATION/PDF',
                'ATD_FIL_SIZ' => $adjunto->atd_file_size,
            ));
        }

        $str = str_replace(array("\r\n", "\r", "\n"), '', $data);

        $alias = $this->config->item('adjuntos_aduana');
      
         $url = "{$alias}/aduana_sv/adjunto.php";

        /** Llamada a servidor virtual */
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 960);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,   json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Accept: application/json',
                'Content-Type: application/json',

            )
            // 'Authorization: '.  $key
        );

        if (curl_exec($ch) === false) {
            echo 'Curl error: ' . curl_error($ch);
        }

        $errors = curl_error($ch);  //retorna errores                                                                                                          
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE); //retorna el codigo de respuesta
        curl_close($ch);

       
      //  $rsl = json_decode($result);

        //$doc_scaneado = $rsl->ENCODED_ATTACHED_DOCUMENTS;
         $doc_scaneado = $result;
        //echo $doc_scaneado;
        //$respuesta = "";
        //if ($rsl->errorCode == 0) {
          //  $respuesta = "DOCUMENTOS ADJUNTOS PROCESADOS CORRECTAMENTE";
        //} else {
          //  $respuesta = "ERROR, NO HA SIFO POSIBLE PROCESAR DOCUMENTOS ADJUNTOS";
       // }
      
    /** aqui bloque aduana originalmente */

        $date_of_exit                   = null;
        $time_of_exit                   = null;
        $actual_office_of_exit_code     = null;
        $actual_office_of_exit_name     = null;
        $exit_reference                 = null;
        $comments                       = null;
        $item_tax_total                 = null;
        $global_tax_item                = null;
        $total_number_of_items          = null;
        $total_number_of_packages       = null;
        $place_of_declaration           = null;
        $date_of_declaration            = null;
        $selected_page                  = null;
        $financial_code                 = null;
        $amount_foreign_currency        = null;
        $datos_modelo                   = null;
        $number_of_the_form             = null;
        $total_number_of_forms          = null;
        $customs_clearance_office_code  = null;
        $manifest_reference_number      = null;
        $exporter_code                  = null;
        $declaration_gen_procedure_code = null;
        $type_of_declaration            = null;
        $number                         = null;
        $date                           = null;
        $exporter_name                  = null;
        $consignee_code                 = null;
        $consignee_name                 = null;
        $financial_code                 = null;
        $financial_name                 = null;
        $declarant_code                 = null;
        $declarant_name                 = null;
        $declarant_representative       = null;
        $reference                      = null;
        $country_first_destination      = null;
        $trading_country                = null;
        $export_country_code            = null;
        $export_country_region          = null;
        $destination_country_code       = null;
        $destination_country_region     = null;
        $country_of_origin_name         = null;
        $cap                            = null;
        $additional_information         = null;
        $comments_free_text             = null;
        $transport                      = null;
        $means_of_transport             = null;
        $identity                       = null;
        $nationality                    = null;
        $mode                           = null;
        $inland_mode_of_transport       = null;
        $container_flag                 = null;
        $serial_number                  = null;
        $value_details                  = null;
        $number_of_loading_lists        = null;
        $type_of_transit_document       = null;
        $code                           = null;
        $place                          = null;
        $situation                      = null;
        $name_carga                     = null;
        $currency_code                  = null;
        $country                        = null;
        $location_of_goods              = null;
        $code1                          = null;
        $code2                          = null;


        $number_of_packages             = null;
        $kind_of_packages_code          = null;
        //number_of_packages
        $reference                      = null;
        $description                    = null;
        $calculation_working_mode       = null;
        $currency_code                  = null;
        $extended_customs_procedure     = null;
        $national_customs_procedure     = null;
        $amount_deducted_from_licence   = null;
        $location_of_goods              = null;
        $preciPreference_codesion_1     = null;
        $attached_document_date         = null;
        $temp_attached_document_item    = null;
        $attached_document_reference    = null;
        $equipment_type                 = null;
        $equipment_size                 = null;
        $id_equipment                   = null;
        $empty_full_indicator           = null;
        $packages_number                = null;
        $packages_weight                = null;
        $commodity_code                 = null;
        $precision_1                    = null;
        $item_price                     = null;
        $country_of_origin_code         = null;
        $commercial_Description         = null;
        $summary_declaration            = null;
        $gross_weight_itm               = null;
        $transport                      = null;
        $means_of_transport             = null;
        $temp_item_number               = null;
        $marks1_of_packages             = null;
        $marks2_of_packages             = null;
        $preference_code                = null;
        $attached_document_code         = null;
        $attached_document_name         = null;
        $departure_arrival_information  = null;
        $consignee_name_doc             = null;
        $number_reference               = null;
        $identity_arrival_information   = null;
        $inco_term                      = null;
        $aduana_registro_code           = null;
        $aduana_registro_name           = null;
        $lugar_carga                    = null;
        $codigo_banco                   = null;
        $nombre_banco                   = null;
        $financial_transaction_code1    = null;
        $financial_transaction_code2    = null;
        $branch                         = null;
        $regimen_adicional              = null;
        $terms_code                     = null;
        $terms_description              = null;
        $flete_interno                  = null;
        $flete_externo                  = null;
        $seguro                         = null;
        $otros_costos                   = null;
        $deducciones                    = null;
        $identity_arrival_information_identity = null;
        $border_information_identity = null;


        //$amount_foreign_currency        = null;
        //attached_document_reference

        $i = 1;
        foreach ($datos_items['items'] as $item_group) {
            $total_number_of_items = $i;
            $total_number_of_packages = $total_number_of_packages + $item_group->no_bultos;

            $i = $i + 1;
        }
        $customs_clearance_office_code = $general->aduana_entrada_salida;
        $type_of_declaration = substr($general->modelo, 0, 2);
        $declaration_gen_procedure_code = substr($general->modelo, 3, 1);

        $mode = $general->mod_transp;
        $code_delivery_terms = $general->fob;
        // $xml->appendChild("Exporter_code", $datos->nit_exportador);
        $exporter_name = $general->nombre_exportador;
        $nit_consignatario = trim(str_replace(array('-'), '', $general->nit_consignatario));
        $consignee_code = $nit_consignatario;
        $consignee_name = $general->consignatario;
        $declarant_code = $general->declarante;
        $number_reference = $general->referencia;
        $country_first_destination = $general->pais_proc;
        $export_country_code = $general->pais_export;
        $destination_country_code = $general->pais_destino;
        //$identity_arrival_information = "CHIQUITA LOGISTIC SERVICES"; //TODO:revisar esto debe ser dinamico
        $identity_arrival_information = $general->registro_nac_medio;
        $nationality_arrival_information = $general->pais_transporte;
        $container_flag = "false";
        $inco_term = $general->incoterm;
        $exporter_code = "N/A";
        $aduana_registro_code = $general->aduana_registro;
        $aduana_registro_name = $general->aduana_registro_name;
        $lugar_carga = $general->lugar_carga;
        $name_carga = $general->zona_descarga;
        $location_of_goods = $general->localizacion_mercancia;
        $codigo_banco = $general->banco;
        $nombre_banco = $general->nombre_banco;
        $branch = $general->agencia;
        $regimen_adicional = $general->reg_adicional;
        $terms_code = $general->presentacion;
        $terms_description = $general->nombre_presentacion;
        $calculation_working_mode = "0";
        $amount_foreign_currency = $general->total_facturar;
        $currency_code = "USD";
        $flete_interno = $general->flete_interno;
        $flete_externo = $general->flete_externo;
        $seguro = $general->seguro;
        $otros_costos  = $general->otros;
        $deducciones = $general->deducciones;
        $manifest_reference_number = $general->manifiesto;
        $identity_arrival_information_identity = $general->registro_transportista;
        $border_information_identity = $general->registro_transportista;

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->xmlStandalone = false;
        $doc->formatOutput = true;


        $root = $doc->createElement('ASYCUDA');
        $root = $doc->appendChild($root);


        //Inicio Export_release
        $root1 = $doc->createElement('Export_release');
        $root->appendChild($root1);


        //  $date_of_exit="30/05/2022";
        if ($date_of_exit == null) {
            $root2 = $doc->createElement('Date_of_exit');
            $root1->appendChild($root2);
            $root3 = $doc->createElement('null');
            $root2->appendChild($root3);
        } else {
            $root2 = $doc->createElement('Date_of_exit');
            $root2->nodeValue = $date_of_exit;
            $root1->appendChild($root2);
        }

        if ($time_of_exit == null) {
            $root2 = $doc->createElement('Time_of_exit');
            $root1->appendChild($root2);
            $root3 = $doc->createElement('null');
            $root2->appendChild($root3);
        } else {
            $root2 = $doc->createElement('Time_of_exit');
            $root2->nodeValue = $time_of_exit;
            $root1->appendChild($root2);
        }

        if ($actual_office_of_exit_code == null) {
            $root2 = $doc->createElement('Actual_office_of_exit_code');
            $root1->appendChild($root2);
            $root3 = $doc->createElement('null');
            $root2->appendChild($root3);
        } else {
            $root2 = $doc->createElement('Actual_office_of_exit_code');
            $root2->nodeValue = $actual_office_of_exit_code;
            $root1->appendChild($root2);
        }

        if ($actual_office_of_exit_code == null) {
            $root2 = $doc->createElement('Actual_office_of_exit_name');
            $root1->appendChild($root2);
            $root3 = $doc->createElement('null');
            $root2->appendChild($root3);
        } else {
            $root2 = $doc->createElement('Actual_office_of_exit_name');
            $root2->nodeValue = $actual_office_of_exit_code;
            $root1->appendChild($root2);
        }

        if ($exit_reference == null) {
            $root2 = $doc->createElement('Exit_reference');
            $root1->appendChild($root2);
            $root3 = $doc->createElement('null');
            $root2->appendChild($root3);
        } else {
            $root2 = $doc->createElement('Exit_reference');
            $root2->nodeValue = $exit_reference;
            $root1->appendChild($root2);
        }

        if ($comments == null) {
            $root2 = $doc->createElement('Comments');
            $root1->appendChild($root2);
            $root3 = $doc->createElement('null');
            $root2->appendChild($root3);
        } else {
            $root2 = $doc->createElement('Comments');
            $root2->nodeValue = $comments;
            $root1->appendChild($root2);
        }
        // fin Export_release

        // inicio Assessment_notice
        $root2 = $doc->createElement('Assessment_notice');
        $root->appendChild($root2);

        if ($item_tax_total == null) {
            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2->appendChild($root2_1);
            $root3 = $doc->createElement('null');
            $root2_1->appendChild($root3);
        } else {
            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);

            $root2_1 = $doc->createElement('Item_tax_total');
            $root2_1->nodeValue = $item_tax_total;
            $root2->appendChild($root2_1);
        }
        // fin Assessment_notice


        //Inicio Global_taxes
        $root3 = $doc->createElement('Global_taxes');
        $root->appendChild($root3);

        if ($global_tax_item == null) {
            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3->appendChild($root3_1);
            $root3_2 = $doc->createElement('null');
            $root3_1->appendChild($root3_2);
        } else {
            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);

            $root3_1 = $doc->createElement('Global_tax_item');
            $root3_1->nodeValue = $global_tax_item;
            $root3->appendChild($root3_1);
        }
        // fin Global_taxes

        //Inicio Property
        $root4 = $doc->createElement('Property');
        $root->appendChild($root4);

        $root5 = $doc->createElement('Forms');
        $root4->appendChild($root5);

        if ($number_of_the_form == null) {
            $root5_1 = $doc->createElement('Number_of_the_form');
            $root5->appendChild($root5_1);
            $root5_2 = $doc->createElement('null');
            $root5_1->appendChild($root5_2);
        } else {
            $root5_1 = $doc->createElement('Number_of_the_form');
            $root5_1->nodeValue = $number_of_the_form;
            $root5->appendChild($root5_1);
        }

        if ($total_number_of_forms == null) {
            $root5_1 = $doc->createElement('Total_number_of_forms');
            $root5->appendChild($root5_1);
            $root5_2 = $doc->createElement('null');
            $root5_1->appendChild($root5_2);
        } else {
            $root5_1 = $doc->createElement('Total_number_of_forms');
            $root5_1->nodeValue = $total_number_of_forms;
            $root5->appendChild($root5_1);
        }
        // fin forms

        $root6 = $doc->createElement('Nbers');
        $root4->appendChild($root6);

        if ($number_of_loading_lists == null) {
            $root6_1 = $doc->createElement('Number_of_loading_lists');
            $root6->appendChild($root6_1);
            $root6_2 = $doc->createElement('null');
            $root6_1->appendChild($root6_2);
        } else {
            $root6_1 = $doc->createElement('Number_of_loading_lists');
            $root6_1->nodeValue = $number_of_loading_lists;
            $root6->appendChild($root6_1);
        }

        if ($total_number_of_items == null) {
            $root6_1 = $doc->createElement('Total_number_of_items');
            $root6->appendChild($root6_1);
            $root6_2 = $doc->createElement('null');
            $root6_1->appendChild($root6_2);
        } else {
            $root6_1 = $doc->createElement('Total_number_of_items');
            $root6_1->nodeValue = $total_number_of_items;
            $root6->appendChild($root6_1);
        }

        if ($total_number_of_packages == null) {
            $root6_1 = $doc->createElement('Total_number_of_packages');
            $root6->appendChild($root6_1);
            $root6_2 = $doc->createElement('null');
            $root6_1->appendChild($root6_2);
        } else {
            $root6_1 = $doc->createElement('Total_number_of_packages');
            $root6_1->nodeValue = $total_number_of_packages;
            $root6->appendChild($root6_1);
        }
        //fin Nbers

        if ($place_of_declaration == null) {
            $root7_1 = $doc->createElement('Place_of_declaration');
            $root4->appendChild($root7_1);
            $root7_2 = $doc->createElement('null');
            $root7_1->appendChild($root7_2);
        } else {
            $root7_1 = $doc->createElement('Place_of_declaration');
            $root7_1->nodeValue = $place_of_declaration;
            $root4->appendChild($root7_1);
        }

        if ($date_of_declaration == null) {
            $root7_1 = $doc->createElement('Date_of_declaration');
            $root4->appendChild($root7_1);
            $root7_2 = $doc->createElement('null');
            $root7_1->appendChild($root7_2);
        } else {
            $root7_1 = $doc->createElement('Date_of_declaration');
            $root7_1->nodeValue = $date_of_declaration;
            $root4->appendChild($root7_1);
        }

        if ($selected_page == null) {
            $root7_1 = $doc->createElement('Selected_page');
            $root4->appendChild($root7_1);
            $root7_2 = $doc->createElement('null');
            $root7_1->appendChild($root7_2);
        } else {
            $root7_1 = $doc->createElement('Selected_page');
            $root7_1->nodeValue = $selected_page;
            $root4->appendChild($root7_1);
        }
        //fin Property

        //inicio 
        $root7 = $doc->createElement('Identification');
        $root->appendChild($root7);

        $root8 = $doc->createElement('Office_segment');
        $root7->appendChild($root8);


        if ($customs_clearance_office_code == null) {
            $root8_1 = $doc->createElement('Customs_clearance_office_code');
            $root8->appendChild($root8_1);
            $root8_2 = $doc->createElement('null');
            $root8_1->appendChild($root8_2);
        } else {
            $root8_1 = $doc->createElement('Customs_clearance_office_code');
            $root8_1->nodeValue = $customs_clearance_office_code;
            $root8->appendChild($root8_1);
        }

        $root9 = $doc->createElement('Type');
        $root7->appendChild($root9);

        if ($type_of_declaration == null) {
            $root9_1 = $doc->createElement('Type_of_declaration');
            $root9->appendChild($root9_1);
            $root9_2 = $doc->createElement('null');
            $root9_1->appendChild($root9_2);
        } else {
            $root9_1 = $doc->createElement('Type_of_declaration');
            $root9_1->nodeValue = $type_of_declaration;
            $root9->appendChild($root9_1);
        }

        if ($declaration_gen_procedure_code == null) {
            $root9_1 = $doc->createElement('Declaration_gen_procedure_code');
            $root9->appendChild($root9_1);
            $root9_2 = $doc->createElement('null');
            $root9_1->appendChild($root9_2);
        } else {
            $root9_1 = $doc->createElement('Declaration_gen_procedure_code');
            $root9_1->nodeValue = $declaration_gen_procedure_code;
            $root9->appendChild($root9_1);
        }

        if ($type_of_transit_document == null) {
            $root9_1 = $doc->createElement('Type_of_transit_document');
            $root9->appendChild($root9_1);
            $root9_2 = $doc->createElement('null');
            $root9_1->appendChild($root9_2);
        } else {
            $root9_1 = $doc->createElement('Type_of_transit_document');
            $root9_1->nodeValue = $type_of_transit_document;
            $root9->appendChild($root9_1);
        }

        if ($manifest_reference_number == null) {
            $root10_1 = $doc->createElement('Manifest_reference_number');
            $root7->appendChild($root10_1);
            $root10_2 = $doc->createElement('null');
            $root10_1->appendChild($root10_2);
        } else {
            $root10_1 = $doc->createElement('Manifest_reference_number');
            $root10_1->nodeValue = $manifest_reference_number;
            $root7->appendChild($root10_1);
        }

        $root11 = $doc->createElement('Registration');
        $root7->appendChild($root11);

        if ($serial_number == null) {
            $root11_1 = $doc->createElement('Serial_number');
            $root11->appendChild($root11_1);
            $root11_2 = $doc->createElement('null');
            $root11_1->appendChild($root11_2);
        } else {
            $root11_1 = $doc->createElement('Serial_number');
            $root11_1->nodeValue = $serial_number;
            $root11->appendChild($root11_1);
        }

        if ($number == null) {
            $root11_1 = $doc->createElement('Number');
            $root11->appendChild($root11_1);
            $root11_2 = $doc->createElement('null');
            $root11_1->appendChild($root11_2);
        } else {
            $root11_1 = $doc->createElement('Number');
            $root11_1->nodeValue = $number;
            $root11->appendChild($root11_1);
        }

        if ($date == null) {
            $root11_1 = $doc->createElement('Date');
            $root11->appendChild($root11_1);
            $root11_2 = $doc->createElement('null');
            $root11_1->appendChild($root11_2);
        } else {
            $root11_1 = $doc->createElement('Date');
            $root11_1->nodeValue = $date;
            $root11->appendChild($root11_1);
        }
        // fin Registration

        //Inicio Assessment
        $root12 = $doc->createElement('Assessment');
        $root7->appendChild($root12);

        if ($serial_number == null) {
            $root12_1 = $doc->createElement('Serial_number');
            $root12->appendChild($root12_1);
            $root12_2 = $doc->createElement('null');
            $root12_1->appendChild($root12_2);
        } else {
            $root12_1 = $doc->createElement('Serial_number');
            $root12_1->nodeValue = $serial_number;
            $root12->appendChild($root12_1);
        }

        if ($number == null) {
            $root12_1 = $doc->createElement('Number');
            $root12->appendChild($root12_1);
            $root12_2 = $doc->createElement('null');
            $root12_1->appendChild($root12_2);
        } else {
            $root12_1 = $doc->createElement('Number');
            $root12_1->nodeValue = $number;
            $root12->appendChild($root12_1);
        }

        if ($date == null) {
            $root12_1 = $doc->createElement('Date');
            $root12->appendChild($root12_1);
            $root12_2 = $doc->createElement('null');
            $root12_1->appendChild($root12_2);
        } else {
            $root12_1 = $doc->createElement('Date');
            $root12_1->nodeValue = $date;
            $root12->appendChild($root12_1);
        }

        // fin Assessment

        $root13 = $doc->createElement('receipt');
        $root7->appendChild($root13);

        if ($serial_number == null) {
            $root13_1 = $doc->createElement('Serial_number');
            $root13->appendChild($root13_1);
            $root13_2 = $doc->createElement('null');
            $root13_1->appendChild($root13_2);
        } else {
            $root13_1 = $doc->createElement('Serial_number');
            $root13_1->nodeValue = $serial_number;
            $root13->appendChild($root13_1);
        }

        if ($number == null) {
            $root13_1 = $doc->createElement('Number');
            $root13->appendChild($root13_1);
            $root13_2 = $doc->createElement('null');
            $root13_1->appendChild($root13_2);
        } else {
            $root13_1 = $doc->createElement('Number');
            $root13_1->nodeValue = $number;
            $root13->appendChild($root13_1);
        }

        if ($date == null) {
            $root13_1 = $doc->createElement('Date');
            $root13->appendChild($root13_1);
            $root13_2 = $doc->createElement('null');
            $root13_1->appendChild($root13_2);
        } else {
            $root13_1 = $doc->createElement('Date');
            $root13_1->nodeValue = $date;
            $root13->appendChild($root13_1);
        }

        // fin receipt
        // fin Identification

        $root14 = $doc->createElement('Traders');
        $root->appendChild($root14);

        $root15 = $doc->createElement('Exporter');
        $root14->appendChild($root15);

        if ($exporter_code == null) {
            $root15_1 = $doc->createElement('Exporter_code');
            $root15->appendChild($root15_1);
            $root15_2 = $doc->createElement('null');
            $root15_1->appendChild($root15_2);
        } else {
            $root15_1 = $doc->createElement('Exporter_code');
            $root15_1->nodeValue = $exporter_code;
            $root15->appendChild($root15_1);
        }


        if ($exporter_name == null) {
            $root15_1 = $doc->createElement('Exporter_name');
            $root15->appendChild($root15_1);
            $root15_2 = $doc->createElement('null');
            $root15_1->appendChild($root15_2);
        } else {
            $root15_1 = $doc->createElement('Exporter_name');
            $root15_1->nodeValue = $exporter_name;
            $root15->appendChild($root15_1);
        }
        // fin Exporter

        $root16 = $doc->createElement('Consignee');
        $root14->appendChild($root16);

        if ($consignee_code == null) {
            $root16_1 = $doc->createElement('Consignee_code');
            $root16->appendChild($root16_1);
            $root16_2 = $doc->createElement('null');
            $root16_1->appendChild($root16_2);
        } else {
            $root16_1 = $doc->createElement('Consignee_code');
            $root16_1->nodeValue = $consignee_code;
            $root16->appendChild($root16_1);
        }

        if ($consignee_name == null) {
            $root16_1 = $doc->createElement('Consignee_name');
            $root16->appendChild($root16_1);
            $root16_2 = $doc->createElement('null');
            $root16_1->appendChild($root16_2);
        } else {
            $root16_1 = $doc->createElement('Consignee_name');
            $root16_1->nodeValue = $consignee_name;
            $root16->appendChild($root16_1);
        }

        if ($consignee_name_doc == null) {
            $root16_1 = $doc->createElement('Consignee_name_doc');
            $root16->appendChild($root16_1);
            $root16_2 = $doc->createElement('null');
            $root16_1->appendChild($root16_2);
        } else {
            $root16_1 = $doc->createElement('Consignee_name_doc');
            $root16_1->nodeValue = $consignee_name_doc;
            $root16->appendChild($root16_1);
        }
        //fin consignee

        $root17 = $doc->createElement('Financial');
        $root14->appendChild($root17);

        if ($financial_code == null) {
            $root17_1 = $doc->createElement('Financial_code');
            $root17->appendChild($root17_1);
            $root17_2 = $doc->createElement('null');
            $root17_1->appendChild($root17_2);
        } else {
            $root17_1 = $doc->createElement('Financial_code');
            $root17_1->nodeValue = $financial_code;
            $root17->appendChild($root17_1);
        }

        if ($financial_name == null) {
            $root17_1 = $doc->createElement('Financial_name');
            $root17->appendChild($root17_1);
            $root17_2 = $doc->createElement('null');
            $root17_1->appendChild($root17_2);
        } else {
            $root17_1 = $doc->createElement('Financial_name');
            $root17_1->nodeValue = $financial_name;
            $root17->appendChild($root17_1);
        }

        $root18 = $doc->createElement('Declarant');
        $root->appendChild($root18);


        if ($declarant_code == null) {
            $root18_1 = $doc->createElement('Declarant_code');
            $root18->appendChild($root18_1);
            $root18_2 = $doc->createElement('null');
            $root18_1->appendChild($root18_2);
        } else {
            $root18_1 = $doc->createElement('Declarant_code');
            $root18_1->nodeValue = $declarant_code;
            $root18->appendChild($root18_1);
        }


        if ($declarant_name == null) {
            $root18_1 = $doc->createElement('Declarant_name');
            $root18->appendChild($root18_1);
            $root18_2 = $doc->createElement('null');
            $root18_1->appendChild($root18_2);
        } else {
            $root18_1 = $doc->createElement('Declarant_name');
            $root18_1->nodeValue = $declarant_name;
            $root18->appendChild($root18_1);
        }

        if ($declarant_representative == null) {
            $root18_1 = $doc->createElement('Declarant_representative');
            $root18->appendChild($root18_1);
            $root18_2 = $doc->createElement('null');
            $root18_1->appendChild($root18_2);
        } else {
            $root18_1 = $doc->createElement('Declarant_representative');
            $root18_1->nodeValue = $declarant_representative;
            $root18->appendChild($root18_1);
        }


        $root19 = $doc->createElement('Reference');
        $root18->appendChild($root19);

        if ($number_reference == null) {
            $root19_1 = $doc->createElement('Number');
            $root19->appendChild($root19_1);
            $root19_2 = $doc->createElement('null');
            $root19_1->appendChild($root19_2);
        } else {
            $root19_1 = $doc->createElement('Number');
            $root19_1->nodeValue = $number_reference;
            $root19->appendChild($root19_1);
        }
        // fin Declarant

        $root20 = $doc->createElement('General_information');
        $root->appendChild($root20);

        $root21 = $doc->createElement('Country');
        $root20->appendChild($root21);

        if ($country_first_destination == null) {
            $root21_1 = $doc->createElement('Country_first_destination');
            $root21->appendChild($root21_1);
            $root21_2 = $doc->createElement('null');
            $root21_1->appendChild($root21_2);
        } else {
            $root21_1 = $doc->createElement('Country_first_destination');
            $root21_1->nodeValue = $country_first_destination;
            $root21->appendChild($root21_1);
        }

        if ($trading_country == null) {
            $root21_1 = $doc->createElement('Trading_country');
            $root21->appendChild($root21_1);
            $root21_2 = $doc->createElement('null');
            $root21_1->appendChild($root21_2);
        } else {
            $root21_1 = $doc->createElement('Trading_country');
            $root21_1->nodeValue = $trading_country;
            $root21->appendChild($root21_1);
        }



        $root22 = $doc->createElement('Export');
        $root21->appendChild($root22);

        if ($export_country_code == null) {
            $root22_1 = $doc->createElement('Export_country_code');
            $root22->appendChild($root22_1);
            $root22_2 = $doc->createElement('null');
            $root22_1->appendChild($root22_2);
        } else {
            $root22_1 = $doc->createElement('Export_country_code');
            $root22_1->nodeValue = $export_country_code;
            $root22->appendChild($root22_1);
        }

        if ($export_country_region == null) {
            $root22_1 = $doc->createElement('Export_country_region');
            $root22->appendChild($root22_1);
            $root22_2 = $doc->createElement('null');
            $root22_1->appendChild($root22_2);
        } else {
            $root22_1 = $doc->createElement('Export_country_region');
            $root22_1->nodeValue = $export_country_region;
            $root22->appendChild($root22_1);
        }



        $root23 = $doc->createElement('Destination');
        $root21->appendChild($root23);

        if ($destination_country_code == null) {
            $root23_1 = $doc->createElement('Destination_country_code');
            $root23->appendChild($root23_1);
            $root23_2 = $doc->createElement('null');
            $root23_1->appendChild($root23_2);
        } else {
            $root23_1 = $doc->createElement('Destination_country_code');
            $root23_1->nodeValue = $destination_country_code;
            $root23->appendChild($root23_1);
        }

        if ($destination_country_region == null) {
            $root23_1 = $doc->createElement('Destination_country_region');
            $root23->appendChild($root23_1);
            $root23_2 = $doc->createElement('null');
            $root23_1->appendChild($root23_2);
        } else {
            $root23_1 = $doc->createElement('Destination_country_region');
            $root23_1->nodeValue = $destination_country_region;
            $root23->appendChild($root23_1);
        }


        if ($country_of_origin_name == null) {
            $root24_1 = $doc->createElement('Country_of_origin_name');
            $root21->appendChild($root24_1);
            $root24_2 = $doc->createElement('null');
            $root24_1->appendChild($root24_2);
        } else {
            $root24_1 = $doc->createElement('Country_of_origin_name');
            $root24_1->nodeValue = $country_of_origin_name;
            $root21->appendChild($root24_1);
        }


        if ($value_details == null) {
            $root25_1 = $doc->createElement('Value_details');
            $root20->appendChild($root25_1);
            $root25_2 = $doc->createElement('null');
            $root25_1->appendChild($root25_2);
        } else {
            $root25_1 = $doc->createElement('Value_details');
            $root25_1->nodeValue = $value_details;
            $root20->appendChild($root25_1);
        }

        if ($cap == null) {
            $root25_1 = $doc->createElement('CAP');
            $root20->appendChild($root25_1);
            $root25_2 = $doc->createElement('null');
            $root25_1->appendChild($root25_2);
        } else {
            $root25_1 = $doc->createElement('CAP');
            $root25_1->nodeValue = $cap;
            $root20->appendChild($root25_1);
        }

        if ($additional_information == null) {
            $root25_1 = $doc->createElement('Additional_information');
            $root20->appendChild($root25_1);
            $root25_2 = $doc->createElement('null');
            $root25_1->appendChild($root25_2);
        } else {
            $root25_1 = $doc->createElement('Additional_information');
            $root25_1->nodeValue = $additional_information;
            $root20->appendChild($root25_1);
        }

        if ($comments_free_text == null) {
            $root25_1 = $doc->createElement('Comments_free_text');
            $root20->appendChild($root25_1);
            $root25_2 = $doc->createElement('null');
            $root25_1->appendChild($root25_2);
        } else {
            $root25_1 = $doc->createElement('Comments_free_text');
            $root25_1->nodeValue = $comments_free_text;
            $root20->appendChild($root25_1);
        }
        // fin General_information

        $root26 = $doc->createElement('Transport');
        $root->appendChild($root26);

        $root27 = $doc->createElement('Means_of_transport');
        $root26->appendChild($root27);

        $root28 = $doc->createElement('Departure_arrival_information');
        $root27->appendChild($root28);

        if ($identity_arrival_information_identity == null) {
            $root28_1 = $doc->createElement('Identity');
            $root28->appendChild($root28_1);
            $root28_2 = $doc->createElement('null');
            $root28_1->appendChild($root28_2);
        } else {
            $root28_1 = $doc->createElement('Identity');
            $root28_1->nodeValue = $identity_arrival_information_identity;
            $root28->appendChild($root28_1);
        }

        if ($nationality_arrival_information == null) {
            $root281_1 = $doc->createElement('Nationality');
            $root28->appendChild($root281_1);
            $root281_2 = $doc->createElement('null');
            $root281_1->appendChild($root281_2);
        } else {
            $root281_1 = $doc->createElement('Nationality');
            $root281_1->nodeValue = $nationality_arrival_information;
            $root28->appendChild($root281_1);
        }

        $root29 = $doc->createElement('Border_information');
        $root27->appendChild($root29);

        if ($border_information_identity == null) {
            $root29_1 = $doc->createElement('Identity');
            $root29->appendChild($root29_1);
            $root29_2 = $doc->createElement('null');
            $root29_1->appendChild($root29_2);
        } else {
            $root29_1 = $doc->createElement('Identity');
            $root29_1->nodeValue = $border_information_identity;
            $root29->appendChild($root29_1);
        }

        if ($nationality == null) {
            $root29_1 = $doc->createElement('Nationality');
            $root29->appendChild($root29_1);
            $root29_2 = $doc->createElement('null');
            $root29_1->appendChild($root29_2);
        } else {
            $root29_1 = $doc->createElement('Nationality');
            $root29_1->nodeValue = $nationality;
            $root29->appendChild($root29_1);
        }

        if ($mode == null) {
            $root29_1 = $doc->createElement('Mode');
            $root29->appendChild($root29_1);
            $root29_2 = $doc->createElement('null');
            $root29_1->appendChild($root29_2);
        } else {
            $root29_1 = $doc->createElement('Mode');
            $root29_1->nodeValue = $mode;
            $root29->appendChild($root29_1);
        }

        if ($inland_mode_of_transport == null) {
            $root30_1 = $doc->createElement('Inland_mode_of_transport');
            $root27->appendChild($root30_1);
            $root30_2 = $doc->createElement('null');
            $root30_1->appendChild($root30_2);
        } else {
            $root30_1 = $doc->createElement('Inland_mode_of_transport');
            $root30_1->nodeValue = $inland_mode_of_transport;
            $root27->appendChild($root30_1);
        }


        if ($container_flag == null) {
            $root31_1 = $doc->createElement('Container_flag');
            $root26->appendChild($root31_1);
            $root31_2 = $doc->createElement('null');
            $root31_1->appendChild($root31_2);
        } else {
            $root31_1 = $doc->createElement('Container_flag');
            $root31_1->nodeValue = $container_flag;
            $root26->appendChild($root31_1);
        }

        $root32 = $doc->createElement('Delivery_terms');
        $root26->appendChild($root32);

        if ($inco_term == null) {
            $root32_1 = $doc->createElement('Code');
            $root32->appendChild($root32_1);
            $root32_2 = $doc->createElement('null');
            $root32_1->appendChild($root32_2);
        } else {
            $root32_1 = $doc->createElement('Code');
            $root32_1->nodeValue = $inco_term;
            $root32->appendChild($root32_1);
        }

        if ($place == null) {
            $root32_1 = $doc->createElement('Place');
            $root32->appendChild($root32_1);
            $root32_2 = $doc->createElement('null');
            $root32_1->appendChild($root32_2);
        } else {
            $root32_1 = $doc->createElement('Place');
            $root32_1->nodeValue = $place;
            $root32->appendChild($root32_1);
        }

        if ($situation == null) {
            $root32_1 = $doc->createElement('Situation');
            $root32->appendChild($root32_1);
            $root32_2 = $doc->createElement('null');
            $root32_1->appendChild($root32_2);
        } else {
            $root32_1 = $doc->createElement('Situation');
            $root32_1->nodeValue = $situation;
            $root32->appendChild($root32_1);
        }

        $root33 = $doc->createElement('Border_office');
        $root26->appendChild($root33);

        if ($aduana_registro_code == null) {
            $root33_1 = $doc->createElement('Code');
            $root33->appendChild($root33_1);
            $root33_2 = $doc->createElement('null');
            $root33_1->appendChild($root33_2);
        } else {
            $root33_1 = $doc->createElement('Code');
            $root33_1->nodeValue = $aduana_registro_code;
            $root33->appendChild($root33_1);
        }

        if ($aduana_registro_name == null) {
            $root33_1 = $doc->createElement('Name');
            $root33->appendChild($root33_1);
            $root33_2 = $doc->createElement('null');
            $root33_1->appendChild($root33_2);
        } else {
            $root33_1 = $doc->createElement('Name');
            $root33_1->nodeValue = $aduana_registro_name;
            $root33->appendChild($root33_1);
        }
        // Border_office

        $root34 = $doc->createElement('Place_of_loading');
        $root26->appendChild($root34);

        if ($lugar_carga == null) {
            $root34_1 = $doc->createElement('Code');
            $root34->appendChild($root34_1);
            $root34_2 = $doc->createElement('null');
            $root34_1->appendChild($root34_2);
        } else {
            $root34_1 = $doc->createElement('Code');
            $root34_1->nodeValue = $lugar_carga;
            $root34->appendChild($root34_1);
        }

        if ($name_carga == null) {
            $root34_1 = $doc->createElement('Name');
            $root34->appendChild($root34_1);
            $root34_2 = $doc->createElement('null');
            $root34_1->appendChild($root34_2);
        } else {
            $root34_1 = $doc->createElement('Name');
            $root34_1->nodeValue = $name_carga;
            $root34->appendChild($root34_1);
        }

        if ($country == null) {
            $root34_1 = $doc->createElement('Country');
            $root34->appendChild($root34_1);
            $root34_2 = $doc->createElement('null');
            $root34_1->appendChild($root34_2);
        } else {
            $root34_1 = $doc->createElement('Country');
            $root34_1->nodeValue = $country;
            $root34->appendChild($root34_1);
        }

        if ($location_of_goods == null) {
            $root35_1 = $doc->createElement('Location_of_goods');
            $root26->appendChild($root35_1);
            $root35_2 = $doc->createElement('null');
            $root35_1->appendChild($root35_2);
        } else {
            $root35_1 = $doc->createElement('Location_of_goods');
            $root35_1->nodeValue = $location_of_goods;
            $root26->appendChild($root35_1);
        }
        // Fin Transport

        $root36 = $doc->createElement('Financial');
        $root->appendChild($root36);

        $root37 = $doc->createElement('Financial_transaction');
        $root36->appendChild($root37);

        if ($financial_transaction_code1 == null) {
            $root37_1 = $doc->createElement('code1');
            $root37->appendChild($root37_1);
            $root37_2 = $doc->createElement('null');
            $root37_1->appendChild($root37_2);
        } else {
            $root37_1 = $doc->createElement('code1');
            $root37_1->nodeValue = $financial_transaction_code1;
            $root37->appendChild($root37_1);
        }

        if ($financial_transaction_code2 == null) {
            $root37_1 = $doc->createElement('code2');
            $root37->appendChild($root37_1);
            $root37_2 = $doc->createElement('null');
            $root37_1->appendChild($root37_2);
        } else {
            $root37_1 = $doc->createElement('code2');
            $root37_1->nodeValue = $financial_transaction_code2;
            $root37->appendChild($root37_1);
        }



        $root38 = $doc->createElement('Bank');
        $root36->appendChild($root38);

        if ($codigo_banco == null) {
            $root38_1 = $doc->createElement('Code');
            $root38->appendChild($root38_1);
            $root38_2 = $doc->createElement('null');
            $root38_1->appendChild($root38_2);
        } else {
            $root38_1 = $doc->createElement('Code');
            $root38_1->nodeValue = $codigo_banco;
            $root38->appendChild($root38_1);
        }

        if ($nombre_banco == null) {
            $root38_1 = $doc->createElement('Name');
            $root38->appendChild($root38_1);
            $root38_2 = $doc->createElement('null');
            $root38_1->appendChild($root38_2);
        } else {
            $root38_1 = $doc->createElement('Name');
            $root38_1->nodeValue = $nombre_banco;
            $root38->appendChild($root38_1);
        }

        if ($branch == null) {
            $root38_1 = $doc->createElement('Branch');
            $root38->appendChild($root38_1);
            $root38_2 = $doc->createElement('null');
            $root38_1->appendChild($root38_2);
        } else {
            $root38_1 = $doc->createElement('Branch');
            $root38_1->nodeValue = $branch;
            $root38->appendChild($root38_1);
        }

        if ($regimen_adicional == null) {
            $root38_1 = $doc->createElement('Reference');
            $root38->appendChild($root38_1);
            $root38_2 = $doc->createElement('null');
            $root38_1->appendChild($root38_2);
        } else {
            $root38_1 = $doc->createElement('Reference');
            $root38_1->nodeValue = $regimen_adicional;
            $root38->appendChild($root38_1);
        }



        $root39 = $doc->createElement('Terms');
        $root36->appendChild($root39);

        if ($terms_code == null) {
            $root39_1 = $doc->createElement('Code');
            $root39->appendChild($root39_1);
            $root39_2 = $doc->createElement('null');
            $root39_1->appendChild($root39_2);
        } else {
            $root39_1 = $doc->createElement('Code');
            $root39_1->nodeValue = $terms_code;
            $root39->appendChild($root39_1);
        }

        if ($terms_description == null) {
            $root39_1 = $doc->createElement('Description');
            $root39->appendChild($root39_1);
            $root39_2 = $doc->createElement('null');
            $root39_1->appendChild($root39_2);
        } else {
            $root39_1 = $doc->createElement('Description');
            $root39_1->nodeValue = $terms_description;
            $root39->appendChild($root39_1);
        }

        $total_invoice = null;
        if ($total_invoice == null) {
            $root40_1 = $doc->createElement('Total_invoice');
            $root36->appendChild($root40_1);
            $root40_2 = $doc->createElement('null');
            $root40_1->appendChild($root40_2);
        } else {
            $root40_1 = $doc->createElement('Total_invoice');
            $root40_1->nodeValue = $total_invoice;
            $root36->appendChild($root40_1);
        }

        $Deffered_payment_reference = null;
        if ($Deffered_payment_reference == null) {
            $root40_1 = $doc->createElement('Deffered_payment_reference');
            $root36->appendChild($root40_1);
            $root40_2 = $doc->createElement('null');
            $root40_1->appendChild($root40_2);
        } else {
            $root40_1 = $doc->createElement('Deffered_payment_reference');
            $root40_1->nodeValue = $Deffered_payment_reference;
            $root36->appendChild($root40_1);
        }
        $Mode_of_payment = null;
        if ($Mode_of_payment == null) {
            $root40_1 = $doc->createElement('Mode_of_payment');
            $root36->appendChild($root40_1);
            $root40_2 = $doc->createElement('null');
            $root40_1->appendChild($root40_2);
        } else {
            $root40_1 = $doc->createElement('Mode_of_payment');
            $root40_1->nodeValue = $Mode_of_payment;
            $root36->appendChild($root40_1);
        }


        $root41 = $doc->createElement('Amounts');
        $root36->appendChild($root41);

        $total_manual_taxes = null;
        if ($total_manual_taxes == null) {
            $root42_1 = $doc->createElement('Total_manual_taxes');
            $root41->appendChild($root42_1);
            $root42_2 = $doc->createElement('null');
            $root42_1->appendChild($root42_2);
        } else {
            $root42_1 = $doc->createElement('Total_manual_taxes');
            $root42_1->nodeValue = $total_manual_taxes;
            $root41->appendChild($root42_1);
        }
        $global_taxes = null;
        if ($global_taxes == null) {
            $root42_1 = $doc->createElement('Global_taxes');
            $root41->appendChild($root42_1);
            $root42_2 = $doc->createElement('null');
            $root42_1->appendChild($root42_2);
        } else {
            $root42_1 = $doc->createElement('Global_taxes');
            $root42_1->nodeValue = $global_taxes;
            $root41->appendChild($root42_1);
        }
        $totals_taxes = null;
        if ($totals_taxes == null) {
            $root42_1 = $doc->createElement('Totals_taxes');
            $root41->appendChild($root42_1);
            $root42_2 = $doc->createElement('null');
            $root42_1->appendChild($root42_2);
        } else {
            $root42_1 = $doc->createElement('Totals_taxes');
            $root42_1->nodeValue = $totals_taxes;
            $root41->appendChild($root42_1);
        }

        $root43 = $doc->createElement('Guarantee');
        $root36->appendChild($root43);

        $guaranteeName = null;
        if ($guaranteeName == null) {
            $root43_1 = $doc->createElement('Name');
            $root43->appendChild($root43_1);
            $root43_2 = $doc->createElement('null');
            $root43_1->appendChild($root43_2);
        } else {
            $root43_1 = $doc->createElement('Name');
            $root43_1->nodeValue = $guaranteeName;
            $root43->appendChild($root43_1);
        }

        $guaranteeAmount = null;
        if ($guaranteeAmount == null) {
            $root43_1 = $doc->createElement('Amount');
            $root43->appendChild($root43_1);
            $root43_2 = $doc->createElement('null');
            $root43_1->appendChild($root43_2);
        } else {
            $root43_1 = $doc->createElement('Amount');
            $root43_1->nodeValue = $guaranteeAmount;
            $root43->appendChild($root43_1);
        }
        $guaranteeDate = null;
        if ($guaranteeDate == null) {
            $root43_1 = $doc->createElement('Date');
            $root43->appendChild($root43_1);
            $root43_2 = $doc->createElement('null');
            $root43_1->appendChild($root43_2);
        } else {
            $root43_1 = $doc->createElement('Date');
            $root43_1->nodeValue = $guaranteeDate;
            $root43->appendChild($root43_1);
        }

        $root44 = $doc->createElement('Excluded_country');
        $root43->appendChild($root44);

        $excluded_country_code = null;
        if ($excluded_country_code == null) {
            $root44_1 = $doc->createElement('Code');
            $root44->appendChild($root44_1);
            $root44_2 = $doc->createElement('null');
            $root44_1->appendChild($root44_2);
        } else {
            $root44_1 = $doc->createElement('Code');
            $root44_1->nodeValue = $excluded_country_code;
            $root44->appendChild($root44_1);
        }

        $excluded_country_name = null;
        if ($excluded_country_name == null) {
            $root44_1 = $doc->createElement('Name');
            $root44->appendChild($root44_1);
            $root44_2 = $doc->createElement('null');
            $root44_1->appendChild($root44_2);
        } else {
            $root44_1 = $doc->createElement('Name');
            $root44_1->nodeValue = $excluded_country_name;
            $root44->appendChild($root44_1);
        }


        $root45 = $doc->createElement('Warehouse');
        $root->appendChild($root45);

        $Identification = null;
        if ($Identification == null) {
            $root46_1 = $doc->createElement('Identification');
            $root45->appendChild($root46_1);
            $root46_2 = $doc->createElement('null');
            $root46_1->appendChild($root46_2);
        } else {
            $root46_1 = $doc->createElement('Identification');
            $root46_1->nodeValue = $Identification;
            $root45->appendChild($root46_1);
        }

        $delay = null;
        if ($delay == null) {
            $root46_1 = $doc->createElement('Delay');
            $root45->appendChild($root46_1);
            $root46_2 = $doc->createElement('null');
            $root46_1->appendChild($root46_2);
        } else {
            $root46_1 = $doc->createElement('Delay');
            $root46_1->nodeValue = $delay;
            $root45->appendChild($root46_1);
        }


        $root47 = $doc->createElement('Transit');
        $root->appendChild($root47);

        $root48 = $doc->createElement('Principal');
        $root47->appendChild($root48);

        $principal_code = null;
        if ($principal_code == null) {
            $root48_1 = $doc->createElement('Code');
            $root48->appendChild($root48_1);
            $root48_2 = $doc->createElement('null');
            $root48_1->appendChild($root48_2);
        } else {
            $root48_1 = $doc->createElement('Code');
            $root48_1->nodeValue = $principal_code;
            $root48->appendChild($root48_1);
        }

        $principal_name = null;
        if ($principal_name == null) {
            $root48_1 = $doc->createElement('Name');
            $root48->appendChild($root48_1);
            $root48_2 = $doc->createElement('null');
            $root48_1->appendChild($root48_2);
        } else {
            $root48_1 = $doc->createElement('Name');
            $root48_1->nodeValue = $principal_name;
            $root48->appendChild($root48_1);
        }
        $representative = null;
        if ($representative == null) {
            $root48_1 = $doc->createElement('Representative');
            $root48->appendChild($root48_1);
            $root48_2 = $doc->createElement('null');
            $root48_1->appendChild($root48_2);
        } else {
            $root48_1 = $doc->createElement('Representative');
            $root48_1->nodeValue = $representative;
            $root48->appendChild($root48_1);
        }


        $root49 = $doc->createElement('Signature');
        $root47->appendChild($root49);

        $signature_place = null;
        if ($signature_place == null) {
            $root49_1 = $doc->createElement('Place');
            $root49->appendChild($root49_1);
            $root49_2 = $doc->createElement('null');
            $root49_1->appendChild($root49_2);
        } else {
            $root49_1 = $doc->createElement('Place');
            $root49_1->nodeValue = $signature_place;
            $root49->appendChild($root49_1);
        }

        $signature_date = null;
        if ($signature_place == null) {
            $root49_1 = $doc->createElement('Date');
            $root49->appendChild($root49_1);
            $root49_2 = $doc->createElement('null');
            $root49_1->appendChild($root49_2);
        } else {
            $root49_1 = $doc->createElement('Date');
            $root49_1->nodeValue = $signature_date;
            $root49->appendChild($root49_1);
        }


        $root50 = $doc->createElement('Destination');
        $root47->appendChild($root50);

        $destination = null;
        if ($destination == null) {
            $root50_1 = $doc->createElement('Office');
            $root50->appendChild($root50_1);
            $root50_2 = $doc->createElement('null');
            $root50_1->appendChild($root50_2);
        } else {
            $root50_1 = $doc->createElement('Office');
            $root50_1->nodeValue = $destination;
            $root50->appendChild($root50_1);
        }
        $destination_country = null;
        if ($destination_country == null) {
            $root50_1 = $doc->createElement('Country');
            $root50->appendChild($root50_1);
            $root50_2 = $doc->createElement('null');
            $root50_1->appendChild($root50_2);
        } else {
            $root50_1 = $doc->createElement('Country');
            $root50_1->nodeValue = $destination_country;
            $root50->appendChild($root50_1);
        }



        $root51 = $doc->createElement('Seals');
        $root47->appendChild($root51);

        $seals_number = null;
        if ($seals_number == null) {
            $root51_1 = $doc->createElement('Number');
            $root51->appendChild($root51_1);
            $root51_2 = $doc->createElement('null');
            $root51_1->appendChild($root51_2);
        } else {
            $root51_1 = $doc->createElement('Number');
            $root51_1->nodeValue = $seals_number;
            $root51->appendChild($root51_1);
        }

        $seals_identity = null;
        if ($seals_identity == null) {
            $root51_1 = $doc->createElement('Identity');
            $root51->appendChild($root51_1);
            $root51_2 = $doc->createElement('null');
            $root51_1->appendChild($root51_2);
        } else {
            $root51_1 = $doc->createElement('Identity');
            $root51_1->nodeValue = $seals_identity;
            $root51->appendChild($root51_1);
        }

        $result_of_control = null;
        if ($result_of_control == null) {
            $root52_1 = $doc->createElement('Result_of_control');
            $root47->appendChild($root52_1);
            $root52_2 = $doc->createElement('null');
            $root52_1->appendChild($root52_2);
        } else {
            $root51_1 = $doc->createElement('Result_of_control');
            $root51_1->nodeValue = $result_of_control;
            $root47->appendChild($root51_1);
        }

        $time_limit = null;
        if ($time_limit == null) {
            $root52_1 = $doc->createElement('Time_limit');
            $root47->appendChild($root52_1);
            $root52_2 = $doc->createElement('null');
            $root52_1->appendChild($root52_2);
        } else {
            $root51_1 = $doc->createElement('Time_limit');
            $root51_1->nodeValue = $time_limit;
            $root47->appendChild($root51_1);
        }

        $officer_name = null;
        if ($officer_name == null) {
            $root52_1 = $doc->createElement('Officer_name');
            $root47->appendChild($root52_1);
            $root52_2 = $doc->createElement('null');
            $root52_1->appendChild($root52_2);
        } else {
            $root51_1 = $doc->createElement('Officer_name');
            $root51_1->nodeValue = $officer_name;
            $root47->appendChild($root51_1);
        }


        $root53 = $doc->createElement('Valuation');
        $root->appendChild($root53);

        if ($calculation_working_mode == null) {
            $root53_1 = $doc->createElement('Calculation_working_mode');
            $root53->appendChild($root53_1);
            $root53_2 = $doc->createElement('null');
            $root53_1->appendChild($root53_2);
        } else {
            $root53_1 = $doc->createElement('Calculation_working_mode');
            $root53_1->nodeValue = $calculation_working_mode;
            $root53->appendChild($root53_1);
        }

        $root54 = $doc->createElement('Weight');
        $root53->appendChild($root54);

        $gross_weight = null;
        if ($gross_weight == null) {
            $root54_1 = $doc->createElement('Gross_weight');
            $root54->appendChild($root54_1);
            $root54_2 = $doc->createElement('null');
            $root54_1->appendChild($root54_2);
        } else {
            $root54_1 = $doc->createElement('Gross_weight');
            $root54_1->nodeValue = $gross_weight;
            $root54->appendChild($root54_1);
        }

        $total_cost = null;
        if ($total_cost == null) {
            $root55_1 = $doc->createElement('Total_cost');
            $root53->appendChild($root55_1);
            $root55_2 = $doc->createElement('null');
            $root55_1->appendChild($root55_2);
        } else {
            $root55_1 = $doc->createElement('Total_cost');
            $root55_1->nodeValue = $total_cost;
            $root53->appendChild($root55_1);
        }

        $total_CIF = null;
        if ($total_CIF == null) {
            $root55_1 = $doc->createElement('Total_CIF');
            $root53->appendChild($root55_1);
            $root55_2 = $doc->createElement('null');
            $root55_1->appendChild($root55_2);
        } else {
            $root55_1 = $doc->createElement('Total_CIF');
            $root55_1->nodeValue = $total_cost;
            $root53->appendChild($root55_1);
        }


        $root56 = $doc->createElement('Gs_Invoice');
        $root53->appendChild($root56);

        $amount_national_currency = null;
        if ($amount_national_currency == null) {
            $root56_1 = $doc->createElement('Amount_national_currency');
            $root56->appendChild($root56_1);
            $root56_2 = $doc->createElement('null');
            $root56_1->appendChild($root56_2);
        } else {
            $root56_1 = $doc->createElement('Amount_national_currency');
            $root56_1->nodeValue = $total_cost;
            $root56->appendChild($root56_1);
        }

        if ($amount_foreign_currency == null) {
            $root56_1 = $doc->createElement('Amount_foreign_currency');
            $root56->appendChild($root56_1);
            $root56_2 = $doc->createElement('null');
            $root56_1->appendChild($root56_2);
        } else {
            $root56_1 = $doc->createElement('Amount_foreign_currency');
            $root56_1->nodeValue = $amount_foreign_currency;
            $root56->appendChild($root56_1);
        }

        if ($currency_code == null) {
            $root56_1 = $doc->createElement('Currency_code');
            $root56->appendChild($root56_1);
            $root56_2 = $doc->createElement('null');
            $root56_1->appendChild($root56_2);
        } else {
            $root56_1 = $doc->createElement('Currency_code');
            $root56_1->nodeValue = $currency_code;
            $root56->appendChild($root56_1);
        }
        $gs_invoice_Currency_name = null;
        if ($gs_invoice_Currency_name == null) {
            $root56_1 = $doc->createElement('Currency_name');
            $root56->appendChild($root56_1);
            $root56_2 = $doc->createElement('null');
            $root56_1->appendChild($root56_2);
        } else {
            $root56_1 = $doc->createElement('Currency_name');
            $root56_1->nodeValue = $gs_invoice_Currency_name;
            $root56->appendChild($root56_1);
        }

        $gs_invoice_Currency_rate = null;
        if ($gs_invoice_Currency_rate == null) {
            $root56_1 = $doc->createElement('Currency_rate');
            $root56->appendChild($root56_1);
            $root56_2 = $doc->createElement('null');
            $root56_1->appendChild($root56_2);
        } else {
            $root56_1 = $doc->createElement('Currency_rate');
            $root56_1->nodeValue = $gs_invoice_Currency_rate;
            $root56->appendChild($root56_1);
        }


        $root57 = $doc->createElement('Gs_external_freight');
        $root53->appendChild($root57);

        $gs_amount_national_currency = null;
        if ($gs_amount_national_currency == null) {
            $root58_1 = $doc->createElement('Amount_national_currency');
            $root57->appendChild($root58_1);
            $root58_2 = $doc->createElement('null');
            $root58_1->appendChild($root58_2);
        } else {
            $root58_1 = $doc->createElement('Amount_national_currency');
            $root58_1->nodeValue = $gs_amount_national_currency;
            $root57->appendChild($root58_1);
        }

        if ($flete_externo == null) {
            $root58_1 = $doc->createElement('Amount_foreign_currency');
            $root57->appendChild($root58_1);
            $root58_2 = $doc->createElement('null');
            $root58_1->appendChild($root58_2);
        } else {
            $root58_1 = $doc->createElement('Amount_foreign_currency');
            $root58_1->nodeValue = $flete_externo;
            $root57->appendChild($root58_1);
        }

        if ($currency_code == null) {
            $root58_1 = $doc->createElement('Currency_code');
            $root57->appendChild($root58_1);
            $root58_2 = $doc->createElement('null');
            $root58_1->appendChild($root58_2);
        } else {
            $root58_1 = $doc->createElement('Currency_code');
            $root58_1->nodeValue = $currency_code;
            $root57->appendChild($root58_1);
        }
        $gs_external_currency_name = null;
        if ($gs_external_currency_name == null) {
            $root58_1 = $doc->createElement('Currency_name');
            $root57->appendChild($root58_1);
            $root58_2 = $doc->createElement('null');
            $root58_1->appendChild($root58_2);
        } else {
            $root58_1 = $doc->createElement('Currency_name');
            $root58_1->nodeValue = $gs_external_currency_name;
            $root57->appendChild($root58_1);
        }

        $gs_external_currency_rate = null;
        if ($gs_external_currency_rate == null) {
            $root58_1 = $doc->createElement('Currency_rate');
            $root57->appendChild($root58_1);
            $root58_2 = $doc->createElement('null');
            $root58_1->appendChild($root58_2);
        } else {
            $root58_1 = $doc->createElement('Currency_rate');
            $root58_1->nodeValue = $gs_external_currency_rate;
            $root57->appendChild($root58_1);
        }

        $root59 = $doc->createElement('Gs_internal_freight');
        $root53->appendChild($root59);

        $gs_internal_amount_national_currency = null;
        if ($gs_internal_amount_national_currency == null) {
            $root59_1 = $doc->createElement('Amount_national_currency');
            $root59->appendChild($root59_1);
            $root59_2 = $doc->createElement('null');
            $root59_1->appendChild($root59_2);
        } else {
            $root59_1 = $doc->createElement('Amount_national_currency');
            $root59_1->nodeValue = $gs_internal_amount_national_currency;
            $root59->appendChild($root59_1);
        }

        if ($flete_interno == null) {
            $root59_1 = $doc->createElement('Amount_foreign_currency');
            $root59->appendChild($root59_1);
            $root59_2 = $doc->createElement('null');
            $root59_1->appendChild($root59_2);
        } else {
            $root59_1 = $doc->createElement('Amount_foreign_currency');
            $root59_1->nodeValue = $flete_interno;
            $root59->appendChild($root59_1);
        }

        if ($currency_code == null) {
            $root59_1 = $doc->createElement('Currency_code');
            $root59->appendChild($root59_1);
            $root59_2 = $doc->createElement('null');
            $root59_1->appendChild($root59_2);
        } else {
            $root59_1 = $doc->createElement('Currency_code');
            $root59_1->nodeValue = $currency_code;
            $root59->appendChild($root59_1);
        }

        $currency_name = null;
        if ($currency_name == null) {
            $root59_1 = $doc->createElement('Currency_name');
            $root59->appendChild($root59_1);
            $root59_2 = $doc->createElement('null');
            $root59_1->appendChild($root59_2);
        } else {
            $root59_1 = $doc->createElement('Currency_name');
            $root59_1->nodeValue = $currency_name;
            $root59->appendChild($root59_1);
        }

        $currency_rate = null;
        if ($currency_rate == null) {
            $root59_1 = $doc->createElement('Currency_rate');
            $root59->appendChild($root59_1);
            $root59_2 = $doc->createElement('null');
            $root59_1->appendChild($root59_2);
        } else {
            $root59_1 = $doc->createElement('Currency_rate');
            $root59_1->nodeValue = $currency_rate;
            $root59->appendChild($root59_1);
        }

        $root60 = $doc->createElement('Gs_insurance');
        $root53->appendChild($root60);

        $insurance_amount_national_currency = null;
        if ($insurance_amount_national_currency == null) {
            $root60_1 = $doc->createElement('Amount_national_currency');
            $root60->appendChild($root60_1);
            $root60_2 = $doc->createElement('null');
            $root60_1->appendChild($root60_2);
        } else {
            $root60_1 = $doc->createElement('Amount_national_currency');
            $root60_1->nodeValue = $insurance_amount_national_currency;
            $root60->appendChild($root60_1);
        }

        if ($seguro == null) {
            $root60_1 = $doc->createElement('Amount_foreign_currency');
            $root60->appendChild($root60_1);
            $root60_2 = $doc->createElement('null');
            $root60_1->appendChild($root60_2);
        } else {
            $root60_1 = $doc->createElement('Amount_foreign_currency');
            $root60_1->nodeValue = $seguro;
            $root60->appendChild($root60_1);
        }


        if ($currency_code == null) {
            $root60_1 = $doc->createElement('Currency_code');
            $root60->appendChild($root60_1);
            $root60_2 = $doc->createElement('null');
            $root60_1->appendChild($root60_2);
        } else {
            $root60_1 = $doc->createElement('Currency_code');
            $root60_1->nodeValue = $currency_code;
            $root60->appendChild($root60_1);
        }


        $insurance_currency_name = null;
        if ($insurance_currency_name == null) {
            $root60_1 = $doc->createElement('Currency_name');
            $root60->appendChild($root60_1);
            $root60_2 = $doc->createElement('null');
            $root60_1->appendChild($root60_2);
        } else {
            $root60_1 = $doc->createElement('Currency_name');
            $root60_1->nodeValue = $insurance_currency_name;
            $root60->appendChild($root60_1);
        }

        $insurance_currency_rate = null;
        if ($insurance_currency_rate == null) {
            $root60_1 = $doc->createElement('Currency_rate');
            $root60->appendChild($root60_1);
            $root60_2 = $doc->createElement('null');
            $root60_1->appendChild($root60_2);
        } else {
            $root60_1 = $doc->createElement('Currency_rate');
            $root60_1->nodeValue = $insurance_currency_rate;
            $root60->appendChild($root60_1);
        }

        $root61 = $doc->createElement('Gs_other_cost');
        $root53->appendChild($root61);

        $gs_other_amount_national_currency = null;
        if ($gs_other_amount_national_currency == null) {
            $root61_1 = $doc->createElement('Amount_national_currency');
            $root61->appendChild($root61_1);
            $root61_2 = $doc->createElement('null');
            $root61_1->appendChild($root61_2);
        } else {
            $root61_1 = $doc->createElement('Amount_national_currency');
            $root61_1->nodeValue = $gs_other_amount_national_currency;
            $root61->appendChild($root61_1);
        }

        if ($otros_costos == null) {

            $root61_1 = $doc->createElement('Amount_foreign_currency');
            $root61->appendChild($root61_1);
            $root61_2 = $doc->createElement('null');
            $root61_1->appendChild($root61_2);
        } else {
            $n = $otros_costos;
            $aux = (string) $n;
            $decimal = substr($aux, strpos($aux, "."));
            if ($decimal == "0.00") {
                $otros_costos = "0.0";
            }
            $root61_1 = $doc->createElement('Amount_foreign_currency');
            $root61_1->nodeValue = $otros_costos;
            $root61->appendChild($root61_1);
        }

        if ($currency_code == null) {
            $root61_1 = $doc->createElement('Currency_code');
            $root61->appendChild($root61_1);
            $root61_2 = $doc->createElement('null');
            $root61_1->appendChild($root61_2);
        } else {
            $root61_1 = $doc->createElement('Currency_code');
            $root61_1->nodeValue = $currency_code;
            $root61->appendChild($root61_1);
        }

        $gs_other_currency_name = null;
        if ($gs_other_currency_name == null) {
            $root61_1 = $doc->createElement('Currency_name');
            $root61->appendChild($root61_1);
            $root61_2 = $doc->createElement('null');
            $root61_1->appendChild($root61_2);
        } else {
            $root61_1 = $doc->createElement('Currency_name');
            $root61_1->nodeValue = $gs_other_currency_name;
            $root61->appendChild($root61_1);
        }

        $gs_other_currency_rate = null;
        if ($gs_other_currency_rate == null) {
            $root61_1 = $doc->createElement('Currency_rate');
            $root61->appendChild($root61_1);
            $root61_2 = $doc->createElement('null');
            $root61_1->appendChild($root61_2);
        } else {
            $root61_1 = $doc->createElement('Currency_rate');
            $root61_1->nodeValue = $gs_other_currency_rate;
            $root61->appendChild($root61_1);
        }



        $root62 = $doc->createElement('Gs_deduction');
        $root53->appendChild($root62);

        $deduction_amount_national_currency = null;
        if ($deduction_amount_national_currency == null) {
            $root62_1 = $doc->createElement('Amount_national_currency');
            $root62->appendChild($root62_1);
            $root62_2 = $doc->createElement('null');
            $root62_1->appendChild($root62_2);
        } else {
            $root62_1 = $doc->createElement('Amount_national_currency');
            $root62_1->nodeValue = $deduction_amount_national_currency;
            $root62->appendChild($root62_1);
        }

        if ($deducciones == null) {
            $root62_1 = $doc->createElement('Amount_foreign_currency');
            $root62->appendChild($root62_1);
            $root62_2 = $doc->createElement('null');
            $root62_1->appendChild($root62_2);
        } else {
            $n = $deducciones;
            $aux = (string) $n;
            $decimal = substr($aux, strpos($aux, "."));
            if ($decimal == "0.00") {
                $deducciones = "0.0";
            }
            $root62_1 = $doc->createElement('Amount_foreign_currency');
            $root62_1->nodeValue = $deducciones;
            $root62->appendChild($root62_1);
        }

        $deduction_currency_code = null;
        if ($deduction_currency_code == null) {
            $root62_1 = $doc->createElement('Currency_code');
            $root62->appendChild($root62_1);
            $root62_2 = $doc->createElement('null');
            $root62_1->appendChild($root62_2);
        } else {
            $root62_1 = $doc->createElement('Currency_code');
            $root62_1->nodeValue = $deduction_currency_code;
            $root62->appendChild($root62_1);
        }

        $deduction_currency_name = null;
        if ($deduction_currency_name == null) {
            $root62_1 = $doc->createElement('Currency_name');
            $root62->appendChild($root62_1);
            $root62_2 = $doc->createElement('null');
            $root62_1->appendChild($root62_2);
        } else {
            $root62_1 = $doc->createElement('Currency_name');
            $root62_1->nodeValue = $deduction_currency_code;
            $root62->appendChild($root62_1);
        }

        $deduction_currency_rate = null;
        if ($deduction_currency_rate == null) {
            $root62_1 = $doc->createElement('Currency_rate');
            $root62->appendChild($root62_1);
            $root62_2 = $doc->createElement('null');
            $root62_1->appendChild($root62_2);
        } else {
            $root62_1 = $doc->createElement('Currency_rate');
            $root62_1->nodeValue = $deduction_currency_rate;
            $root62->appendChild($root62_1);
        }


        $root63 = $doc->createElement('Total');
        $root53->appendChild($root63);

        $root63_1 = $doc->createElement('Total_invoice');
        $root63->appendChild($root63_1);
        $root63_2 = $doc->createElement('null');
        $root63_1->appendChild($root63_2);

        $root63_1 = $doc->createElement('Total_weight');
        $root63->appendChild($root63_1);
        $root63_2 = $doc->createElement('null');
        $root63_1->appendChild($root63_2);

        $root64 = $doc->createElement('FAUCA');
        $root->appendChild($root64);

        $root64_1 = $doc->createElement('FAUCA_Fecha_vencimiento');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Forma_Pago');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Medio_Pago');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Aduana_Destino');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Aduana_Salida');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Fecha_Embarque');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Productor_Nombre');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_Productor_Cargo');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);


        $root64_1 = $doc->createElement('FAUCA_Productor_Empresa');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_ProductorEx_Nombre');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);

        $root64_1 = $doc->createElement('FAUCA_ProductorEx_Cargo');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);


        $root64_1 = $doc->createElement('FAUCA_ProductorEx_Empresa');
        $root64->appendChild($root64_1);
        $root64_2 = $doc->createElement('null');
        $root64_1->appendChild($root64_2);



        foreach ($datos_items['items']  as $item) {
            $datos_docs['doc']    = $this->Crearpoliza_model->listado_adjuntos_item($id, $item->item);
            $temp_item_number = $item->item;
            $number_of_packages = $item->no_bultos;

            $marks1_of_packages = $item->marcas_uno;
            $marks2_of_packages = $item->marcas_dos;

            $kind_of_packages_code = $item->tipo_bulto;
            $commodity_code = $item->partida;
            $commodity_code = substr($commodity_code, 0, 8);
            $precision_1 = substr($item->partida, 8, 3);
            $suppplementary_unit_quantity = $item->u_suplementarias;
            $item_price = $item->precio_item;
            $country_of_origin_code = $item->origen;
            $dato_partida = $this->Crearpoliza_model->consulta_producto($item->partida);

            $commercial_description = utf8_decode($dato_partida->descripcion_generica);
            $commercial_description = substr($commercial_description, 0, 44);


            $summary_declaration = $item->doc_transp;
            $amount_deducted_from_licence = "0.0";
            $gross_weight_itm = $item->peso_bruto;
            $net_weight_itm = $item->peso_neto;
            $amount_foreign_currency = $item->precio_item;
            $consignee_cod_itm = "N/A";
            $consignee_nam_itm = "N/A";
            $consignee_typ_itm = "ARE";

            $root66 = $doc->createElement('Item');
            $root->appendChild($root66);

            if ($temp_item_number == null) {
                $root66_1 = $doc->createElement('Temp_item_number');
                $root66->appendChild($root66_1);
                $root66_2 = $doc->createElement('null');
                $root66_1->appendChild($root66_2);
            } else {
                $root66_1 = $doc->createElement('Temp_item_number');
                $root66_1->nodeValue = $temp_item_number;
                $root66->appendChild($root66_1);
            }

            $root67 = $doc->createElement('Packages');
            $root66->appendChild($root67);

            if ($number_of_packages == null) {
                $root67_1 = $doc->createElement('Number_of_packages');
                $root67->appendChild($root67_1);
                $root67_2 = $doc->createElement('null');
                $root67_1->appendChild($root67_2);
            } else {
                $root67_1 = $doc->createElement('Number_of_packages');
                $root67_1->nodeValue = $number_of_packages;
                $root67->appendChild($root67_1);
            }


            if ($marks1_of_packages == null) {
                $root67_1 = $doc->createElement('Marks1_of_packages');
                $root67->appendChild($root67_1);
                $root67_2 = $doc->createElement('null');
                $root67_1->appendChild($root67_2);
            } else {
                $root67_1 = $doc->createElement('Marks1_of_packages');
                $root67_1->nodeValue = $marks1_of_packages;
                $root67->appendChild($root67_1);
            }

            if ($marks2_of_packages == null) {
                $root67_1 = $doc->createElement('Marks2_of_packages');
                $root67->appendChild($root67_1);
                $root67_2 = $doc->createElement('null');
                $root67_1->appendChild($root67_2);
            } else {
                $root67_1 = $doc->createElement('Marks2_of_packages');
                $root67_1->nodeValue = $marks2_of_packages;
                $root67->appendChild($root67_1);
            }

            if ($kind_of_packages_code == null) {
                $root67_1 = $doc->createElement('Kind_of_packages_code');
                $root67->appendChild($root67_1);
                $root67_2 = $doc->createElement('null');
                $root67_1->appendChild($root67_2);
            } else {
                $root67_1 = $doc->createElement('Kind_of_packages_code');
                $root67_1->nodeValue = $kind_of_packages_code;
                $root67->appendChild($root67_1);
            }

            $root68 = $doc->createElement('Tarification');
            $root66->appendChild($root68);

            $root68_1 = $doc->createElement('Tarification_data');
            $root68->appendChild($root68_1);
            $root68_2 = $doc->createElement('null');
            $root68_1->appendChild($root68_2);

            $root69 = $doc->createElement('HScode');
            $root68->appendChild($root69);

            if ($commodity_code == null) {
                $root69_1 = $doc->createElement('Commodity_code');
                $root69->appendChild($root69_1);
                $root69_2 = $doc->createElement('null');
                $root69_1->appendChild($root69_2);
            } else {
                $root69_1 = $doc->createElement('Commodity_code');
                $root69_1->nodeValue = $commodity_code;
                $root69->appendChild($root69_1);
            }

            if ($precision_1 == null) {
                $root69_1 = $doc->createElement('Precision_1');
                $root69->appendChild($root69_1);
                $root69_2 = $doc->createElement('null');
                $root69_1->appendChild($root69_2);
            } else {
                $root69_1 = $doc->createElement('Precision_1');
                $root69_1->nodeValue = $precision_1;
                $root69->appendChild($root69_1);
            }

            $root69_1 = $doc->createElement('Precision_2');
            $root69->appendChild($root69_1);
            $root69_2 = $doc->createElement('null');
            $root69_1->appendChild($root69_2);

            $root69_1 = $doc->createElement('Precision_3');
            $root69->appendChild($root69_1);
            $root69_2 = $doc->createElement('null');
            $root69_1->appendChild($root69_2);

            $root69_1 = $doc->createElement('Precision_4');
            $root69->appendChild($root69_1);
            $root69_2 = $doc->createElement('null');
            $root69_1->appendChild($root69_2);

            $preference_code = $item->codigo_preferencia;
            if ($preference_code == null) {
                $root70_1 = $doc->createElement('Preference_code');
                $root68->appendChild($root70_1);
                $root70_2 = $doc->createElement('null');
                $root70_1->appendChild($root70_2);
            } else {
                $root70_1 = $doc->createElement('Preference_code');
                $root70_1->nodeValue = $preference_code;
                $root68->appendChild($root70_1);
            }

            $extended_customs_procedure = $general->reg_extendido;
            if ($extended_customs_procedure == null) {
                $root71_1 = $doc->createElement('Extended_customs_procedure');
                $root68->appendChild($root71_1);
                $root71_2 = $doc->createElement('null');
                $root71_1->appendChild($root71_2);
            } else {
                $root71_1 = $doc->createElement('Extended_customs_procedure');
                $root71_1->nodeValue = $extended_customs_procedure;
                $root68->appendChild($root71_1);
            }

            $national_customs_procedure = $general->reg_adicional;
            if ($national_customs_procedure == null) {
                $root71_1 = $doc->createElement('National_customs_procedure');
                $root68->appendChild($root71_1);
                $root71_2 = $doc->createElement('null');
                $root71_1->appendChild($root71_2);
            } else {
                $root71_1 = $doc->createElement('National_customs_procedure');
                $root71_1->nodeValue = $national_customs_procedure;
                $root68->appendChild($root71_1);
            }

            $root72_1 = $doc->createElement('Quota_code');
            $root68->appendChild($root72_1);
            $root72_2 = $doc->createElement('null');
            $root72_1->appendChild($root72_2);

            $root73 = $doc->createElement('Quota');
            $root68->appendChild($root73);

            $root73_1 = $doc->createElement('QuotaCode');
            $root73->appendChild($root73_1);
            $root73_2 = $doc->createElement('null');
            $root73_1->appendChild($root73_2);

            $root73_1 = $doc->createElement('QuotaId');
            $root73->appendChild($root73_1);
            $root73_2 = $doc->createElement('null');
            $root73_1->appendChild($root73_2);



            $root74 = $doc->createElement('QuotaItem');
            $root73->appendChild($root74);

            $root74_1 = $doc->createElement('ItmNbr');
            $root74->appendChild($root74_1);
            $root74_2 = $doc->createElement('null');
            $root74_1->appendChild($root74_2);

            $root75 = $doc->createElement('Supplementary_unit');
            $root68->appendChild($root75);

            $root75_1 = $doc->createElement('Suppplementary_unit_code');
            $root75->appendChild($root75_1);
            $root75_2 = $doc->createElement('null');
            $root75_1->appendChild($root75_2);

            $root75_1 = $doc->createElement('Suppplementary_unit_name');
            $root75->appendChild($root75_1);
            $root75_2 = $doc->createElement('null');
            $root75_1->appendChild($root75_2);

            if ($suppplementary_unit_quantity == null) {
                $root75_1 = $doc->createElement('Suppplementary_unit_quantity');
                $root68->appendChild($root75_1);
                $root75_2 = $doc->createElement('null');
                $root75_1->appendChild($root75_2);
            } else {
                $root75_1 = $doc->createElement('Suppplementary_unit_quantity');
                $root75_1->nodeValue = $suppplementary_unit_quantity;
                $root75->appendChild($root75_1);
            }

            $root76 = $doc->createElement('Supplementary_unit');
            $root68->appendChild($root76);

            $root76_1 = $doc->createElement('Suppplementary_unit_code');
            $root76->appendChild($root76_1);
            $root76_2 = $doc->createElement('null');
            $root76_1->appendChild($root76_2);

            $root76_1 = $doc->createElement('Suppplementary_unit_name');
            $root76->appendChild($root76_1);
            $root76_2 = $doc->createElement('null');
            $root76_1->appendChild($root76_2);
            $suppplementary_unit_quantity = '0.00';
            if ($suppplementary_unit_quantity == null) {
                $root76_1 = $doc->createElement('Suppplementary_unit_quantity');
                $root76->appendChild($root76_1);
                $root76_2 = $doc->createElement('null');
                $root76_1->appendChild($root76_2);
            } else {
                $root76_1 = $doc->createElement('Suppplementary_unit_quantity');
                $root76_1->nodeValue = $suppplementary_unit_quantity;
                $root76->appendChild($root76_1);
            }

            $root77 = $doc->createElement('Supplementary_unit');
            $root68->appendChild($root77);

            $root77_1 = $doc->createElement('Suppplementary_unit_code');
            $root77->appendChild($root77_1);
            $root77_2 = $doc->createElement('null');
            $root77_1->appendChild($root77_2);

            $root77_1 = $doc->createElement('Suppplementary_unit_name');
            $root77->appendChild($root77_1);
            $root77_2 = $doc->createElement('null');
            $root77_1->appendChild($root77_2);
            $suppplementary_unit_quantity = '0.00';

            if ($suppplementary_unit_quantity == null) {
                $root77_1 = $doc->createElement('Suppplementary_unit_quantity');
                $root77->appendChild($root77_1);
                $root77_2 = $doc->createElement('null');
                $root77_1->appendChild($root77_2);
            } else {
                $root77_1 = $doc->createElement('Suppplementary_unit_quantity');
                $root77_1->nodeValue = $suppplementary_unit_quantity;
                $root77->appendChild($root77_1);
            }

            if ($item_price == null) {
                $root78_1 = $doc->createElement('Item_price');
                $root68->appendChild($root78_1);
                $root78_2 = $doc->createElement('null');
                $root78_1->appendChild($root78_2);
            } else {
                $root78_1 = $doc->createElement('Item_price');
                $root78_1->nodeValue = $item_price;
                $root68->appendChild($root78_1);
            }

            $valuation_method_code = null;
            if ($valuation_method_code == null) {
                $root78_1 = $doc->createElement('Valuation_method_code');
                $root68->appendChild($root78_1);
                $root78_2 = $doc->createElement('null');
                $root78_1->appendChild($root78_2);
            } else {
                $root78_1 = $doc->createElement('Valuation_method_code');
                $root78_1->nodeValue = $valuation_method_code;
                $root68->appendChild($root78_1);
            }

            $value_item = null;
            if ($value_item == null) {
                $root78_1 = $doc->createElement('Value_item');
                $root68->appendChild($root78_1);
                $root78_2 = $doc->createElement('null');
                $root78_1->appendChild($root78_2);
            } else {
                $root78_1 = $doc->createElement('Value_item');
                $root78_1->nodeValue = $value_item;
                $root68->appendChild($root78_1);
            }

            if ($value_item == null) {
                $root78_1 = $doc->createElement('Attached_doc_item');
                $root68->appendChild($root78_1);
                $root78_2 = $doc->createElement('null');
                $root78_1->appendChild($root78_2);
            } else {
                $root78_1 = $doc->createElement('Attached_doc_item');
                $root78_1->nodeValue = $value_item;
                $root68->appendChild($root78_1);
            }

            if ($value_item == null) {
                $root78_1 = $doc->createElement('A.I._code');
                $root68->appendChild($root78_1);
                $root78_2 = $doc->createElement('null');
                $root78_1->appendChild($root78_2);
            } else {
                $root78_1 = $doc->createElement('A.I._code');
                $root78_1->nodeValue = $value_item;
                $root68->appendChild($root78_1);
            }




            $root79 = $doc->createElement('Goods_description');
            $root66->appendChild($root79);

            if ($country_of_origin_code == null) {
                $root79_1 = $doc->createElement('Country_of_origin_code');
                $root69->appendChild($root79_1);
                $root79_2 = $doc->createElement('null');
                $root79_1->appendChild($root79_2);
            } else {
                $root79_1 = $doc->createElement('Country_of_origin_code');
                $root79_1->nodeValue = $country_of_origin_code;
                $root79->appendChild($root79_1);
            }

            $root79_1 = $doc->createElement('Country_of_origin_region');
            $root79->appendChild($root79_1);
            $root79_2 = $doc->createElement('null');
            $root79_1->appendChild($root79_2);


            $root79_1 = $doc->createElement('Description_of_goods');
            $root79->appendChild($root79_1);
            $root79_2 = $doc->createElement('null');
            $root79_1->appendChild($root79_2);


            if ($commercial_description == null) {
                $root79_1 = $doc->createElement('Commercial_Description');
                $root79->appendChild($root79_1);
                $root79_2 = $doc->createElement('null');
                $root79_1->appendChild($root79_2);
            } else {
                //  $dom->createElement(Commercial_Description, htmlentities($text_value))
                $root79_1 = $doc->createElement('Commercial_Description');
                $root79_1->nodeValue = htmlentities($commercial_description);
                $root79->appendChild($root79_1);
            }

            $root80 = $doc->createElement('Previous_doc');
            $root66->appendChild($root80);

            if ($summary_declaration == null) {
                $root80_1 = $doc->createElement('Summary_declaration');
                $root80->appendChild($root80_1);
                $root80_2 = $doc->createElement('null');
                $root80_1->appendChild($root80_2);
            } else {
                $root80_1 = $doc->createElement('Summary_declaration');
                $root80_1->nodeValue = $summary_declaration;
                $root80->appendChild($root80_1);
            }

            $root80_1 = $doc->createElement('Summary_declaration_sl');
            $root80->appendChild($root80_1);
            $root80_2 = $doc->createElement('null');
            $root80_1->appendChild($root80_2);


            $root80_1 = $doc->createElement('Previous_document_reference');
            $root80->appendChild($root80_1);
            $root80_2 = $doc->createElement('null');
            $root80_1->appendChild($root80_2);


            $root80_1 = $doc->createElement('Previous_warehouse_code');
            $root80->appendChild($root80_1);
            $root80_2 = $doc->createElement('null');
            $root80_1->appendChild($root80_2);

            $root81 = $doc->createElement('Licence');
            $root66->appendChild($root81);

            $root81_1 = $doc->createElement('Licence_number');
            $root81->appendChild($root81_1);
            $root81_2 = $doc->createElement('null');
            $root81_1->appendChild($root81_2);

            $root82 = $doc->createElement('Amount');
            $root81->appendChild($root82);

            if ($amount_deducted_from_licence == null) {
                $root82_1 = $doc->createElement('Amount_deducted_from_licence');
                $root82->appendChild($root82_1);
                $root82_2 = $doc->createElement('null');
                $root82_1->appendChild($root82_2);
            } else {
                $root82_1 = $doc->createElement('Amount_deducted_from_licence');
                $root82_1->nodeValue = $amount_deducted_from_licence;
                $root82->appendChild($root82_1);
            }

            $root82_1 = $doc->createElement('Quantity_deducted_from_licence');
            $root82->appendChild($root82_1);
            $root82_2 = $doc->createElement('null');
            $root82_1->appendChild($root82_2);



            $root83_1 = $doc->createElement('Free_text_1');
            $root66->appendChild($root83_1);
            $root83_2 = $doc->createElement('null');
            $root83_1->appendChild($root83_2);



            $root83_1 = $doc->createElement('Free_text_2');
            $root66->appendChild($root83_1);
            $root83_2 = $doc->createElement('null');
            $root83_1->appendChild($root83_2);



            $root84 = $doc->createElement('Taxation');
            $root66->appendChild($root84);

            $root84_1 = $doc->createElement('Item_taxes_amount');
            $root84->appendChild($root84_1);
            $root84_2 = $doc->createElement('null');
            $root84_1->appendChild($root84_2);

            $root84_1 = $doc->createElement('Item_taxes_guaranted_amount');
            $root84->appendChild($root84_1);
            $root84_2 = $doc->createElement('null');
            $root84_1->appendChild($root84_2);

            $root84_1 = $doc->createElement('Item_taxes_mode_of_payment');
            $root84->appendChild($root84_1);
            $root84_2 = $doc->createElement('null');
            $root84_1->appendChild($root84_2);

            $root84_1 = $doc->createElement('Counter_of_normal_mode_of_payment');
            $root84->appendChild($root84_1);
            $root84_2 = $doc->createElement('null');
            $root84_1->appendChild($root84_2);



            $root84_1 = $doc->createElement('Displayed_item_taxes_amount');
            $root84->appendChild($root84_1);
            $root84_2 = $doc->createElement('null');
            $root84_1->appendChild($root84_2);

            $root85 = $doc->createElement('Taxation_line');
            $root84->appendChild($root85);

            $root85_1 = $doc->createElement('Duty_tax_code');
            $root85->appendChild($root85_1);
            $root85_2 = $doc->createElement('null');
            $root85_1->appendChild($root85_2);

            $root85_1 = $doc->createElement('Duty_tax_Base');
            $root85->appendChild($root85_1);
            $root85_2 = $doc->createElement('null');
            $root85_1->appendChild($root85_2);

            $root85_1 = $doc->createElement('Duty_tax_rate');
            $root85->appendChild($root85_1);
            $root85_2 = $doc->createElement('null');
            $root85_1->appendChild($root85_2);

            $root85_1 = $doc->createElement('Duty_tax_amount');
            $root85->appendChild($root85_1);
            $root85_2 = $doc->createElement('null');
            $root85_1->appendChild($root85_2);

            $root85_1 = $doc->createElement('Duty_tax_MP');
            $root85->appendChild($root85_1);
            $root85_2 = $doc->createElement('null');
            $root85_1->appendChild($root85_2);

            $root85_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root85->appendChild($root85_1);
            $root85_2 = $doc->createElement('null');
            $root85_1->appendChild($root85_2);

            $root86 = $doc->createElement('Taxation_line');
            $root84->appendChild($root86);

            $root86_1 = $doc->createElement('Duty_tax_code');
            $root86->appendChild($root86_1);
            $root86_2 = $doc->createElement('null');
            $root86_1->appendChild($root86_2);

            $root86_1 = $doc->createElement('Duty_tax_Base');
            $root86->appendChild($root86_1);
            $root86_2 = $doc->createElement('null');
            $root86_1->appendChild($root86_2);

            $root86_1 = $doc->createElement('Duty_tax_rate');
            $root86->appendChild($root86_1);
            $root86_2 = $doc->createElement('null');
            $root86_1->appendChild($root86_2);

            $root86_1 = $doc->createElement('Duty_tax_amount');
            $root86->appendChild($root86_1);
            $root86_2 = $doc->createElement('null');
            $root86_1->appendChild($root86_2);


            $root86_1 = $doc->createElement('Duty_tax_MP');
            $root86->appendChild($root86_1);
            $root86_2 = $doc->createElement('null');
            $root86_1->appendChild($root86_2);

            $root86_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root86->appendChild($root86_1);
            $root86_2 = $doc->createElement('null');
            $root86_1->appendChild($root86_2);

            $root87 = $doc->createElement('Taxation_line');
            $root84->appendChild($root87);

            $root87_1 = $doc->createElement('Duty_tax_code');
            $root87->appendChild($root87_1);
            $root87_2 = $doc->createElement('null');
            $root87_1->appendChild($root87_2);

            $root87_1 = $doc->createElement('Duty_tax_Base');
            $root87->appendChild($root87_1);
            $root87_2 = $doc->createElement('null');
            $root87_1->appendChild($root87_2);

            $root87_1 = $doc->createElement('Duty_tax_rate');
            $root87->appendChild($root87_1);
            $root87_2 = $doc->createElement('null');
            $root87_1->appendChild($root87_2);

            $root87_1 = $doc->createElement('Duty_tax_amount');
            $root87->appendChild($root87_1);
            $root87_2 = $doc->createElement('null');
            $root87_1->appendChild($root87_2);

            $root87_1 = $doc->createElement('Duty_tax_MP');
            $root87->appendChild($root87_1);
            $root87_2 = $doc->createElement('null');
            $root87_1->appendChild($root87_2);

            $root87_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root87->appendChild($root87_1);
            $root87_2 = $doc->createElement('null');
            $root87_1->appendChild($root87_2);

            $root88 = $doc->createElement('Taxation_line');
            $root84->appendChild($root88);

            $root88_1 = $doc->createElement('Duty_tax_code');
            $root88->appendChild($root88_1);
            $root88_2 = $doc->createElement('null');
            $root88_1->appendChild($root88_2);

            $root88_1 = $doc->createElement('Duty_tax_Base');
            $root88->appendChild($root88_1);
            $root88_2 = $doc->createElement('null');
            $root88_1->appendChild($root88_2);

            $root88_1 = $doc->createElement('Duty_tax_rate');
            $root88->appendChild($root88_1);
            $root88_2 = $doc->createElement('null');
            $root88_1->appendChild($root88_2);

            $root88_1 = $doc->createElement('Duty_tax_amount');
            $root88->appendChild($root88_1);
            $root88_2 = $doc->createElement('null');
            $root88_1->appendChild($root88_2);

            $root88_1 = $doc->createElement('Duty_tax_MP');
            $root88->appendChild($root88_1);
            $root88_2 = $doc->createElement('null');
            $root88_1->appendChild($root88_2);

            $root88_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root88->appendChild($root88_1);
            $root88_2 = $doc->createElement('null');
            $root88_1->appendChild($root88_2);

            $root89 = $doc->createElement('Taxation_line');
            $root84->appendChild($root89);

            $root89_1 = $doc->createElement('Duty_tax_code');
            $root89->appendChild($root89_1);
            $root89_2 = $doc->createElement('null');
            $root89_1->appendChild($root89_2);

            $root89_1 = $doc->createElement('Duty_tax_Base');
            $root89->appendChild($root89_1);
            $root89_2 = $doc->createElement('null');
            $root89_1->appendChild($root89_2);

            $root89_1 = $doc->createElement('Duty_tax_rate');
            $root89->appendChild($root89_1);
            $root89_2 = $doc->createElement('null');
            $root89_1->appendChild($root89_2);


            $root89_1 = $doc->createElement('Duty_tax_amount');
            $root89->appendChild($root89_1);
            $root89_2 = $doc->createElement('null');
            $root89_1->appendChild($root89_2);


            $root89_1 = $doc->createElement('Duty_tax_MP');
            $root89->appendChild($root89_1);
            $root89_2 = $doc->createElement('null');
            $root89_1->appendChild($root89_2);

            $root89_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root89->appendChild($root89_1);
            $root89_2 = $doc->createElement('null');
            $root89_1->appendChild($root89_2);

            $root90 = $doc->createElement('Taxation_line');
            $root84->appendChild($root90);

            $root90_1 = $doc->createElement('Duty_tax_code');
            $root90->appendChild($root90_1);
            $root90_2 = $doc->createElement('null');
            $root90_1->appendChild($root90_2);

            $root90_1 = $doc->createElement('Duty_tax_Base');
            $root90->appendChild($root90_1);
            $root90_2 = $doc->createElement('null');
            $root90_1->appendChild($root90_2);

            $root90_1 = $doc->createElement('Duty_tax_rate');
            $root90->appendChild($root90_1);
            $root90_2 = $doc->createElement('null');
            $root90_1->appendChild($root90_2);

            $root90_1 = $doc->createElement('Duty_tax_amount');
            $root90->appendChild($root90_1);
            $root90_2 = $doc->createElement('null');
            $root90_1->appendChild($root90_2);

            $root90_1 = $doc->createElement('Duty_tax_MP');
            $root90->appendChild($root90_1);
            $root90_2 = $doc->createElement('null');
            $root90_1->appendChild($root90_2);


            $root90_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root90->appendChild($root90_1);
            $root90_2 = $doc->createElement('null');
            $root90_1->appendChild($root90_2);


            $root91 = $doc->createElement('Taxation_line');
            $root84->appendChild($root91);


            $root91_1 = $doc->createElement('Duty_tax_code');
            $root91->appendChild($root91_1);
            $root91_2 = $doc->createElement('null');
            $root91_1->appendChild($root91_2);

            $root91_1 = $doc->createElement('Duty_tax_Base');
            $root91->appendChild($root91_1);
            $root91_2 = $doc->createElement('null');
            $root91_1->appendChild($root91_2);

            $root91_1 = $doc->createElement('Duty_tax_rate');
            $root91->appendChild($root91_1);
            $root91_2 = $doc->createElement('null');
            $root91_1->appendChild($root91_2);

            $root91_1 = $doc->createElement('Duty_tax_amount');
            $root91->appendChild($root91_1);
            $root91_2 = $doc->createElement('null');
            $root91_1->appendChild($root91_2);

            $root91_1 = $doc->createElement('Duty_tax_MP');
            $root91->appendChild($root91_1);
            $root91_2 = $doc->createElement('null');
            $root91_1->appendChild($root91_2);


            $root91_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root91->appendChild($root91_1);
            $root91_2 = $doc->createElement('null');
            $root91_1->appendChild($root91_2);


            $root92 = $doc->createElement('Taxation_line');
            $root84->appendChild($root92);

            $root92_1 = $doc->createElement('Duty_tax_code');
            $root92->appendChild($root92_1);
            $root92_2 = $doc->createElement('null');
            $root92_1->appendChild($root92_2);

            $root92_1 = $doc->createElement('Duty_tax_Base');
            $root92->appendChild($root92_1);
            $root92_2 = $doc->createElement('null');
            $root92_1->appendChild($root92_2);

            $root92_1 = $doc->createElement('Duty_tax_rate');
            $root92->appendChild($root92_1);
            $root92_2 = $doc->createElement('null');
            $root92_1->appendChild($root92_2);

            $root92_1 = $doc->createElement('Duty_tax_amount');
            $root92->appendChild($root92_1);
            $root92_2 = $doc->createElement('null');
            $root92_1->appendChild($root92_2);

            $root92_1 = $doc->createElement('Duty_tax_MP');
            $root92->appendChild($root92_1);
            $root92_2 = $doc->createElement('null');
            $root92_1->appendChild($root92_2);

            $root92_1 = $doc->createElement('Duty_tax_Type_of_calculation');
            $root92->appendChild($root92_1);
            $root92_2 = $doc->createElement('null');
            $root92_1->appendChild($root92_2);

            $root93 = $doc->createElement('Valuation_item');
            $root66->appendChild($root93);

            $root94 = $doc->createElement('Weight_itm');
            $root93->appendChild($root94);

            if ($gross_weight_itm == null) {
                $root94_1 = $doc->createElement('Gross_weight_itm');
                $root94->appendChild($root94_1);
                $root94_2 = $doc->createElement('null');
                $root94_1->appendChild($root94_2);
            } else {
                $root94_1 = $doc->createElement('Gross_weight_itm');
                $root94_1->nodeValue = $gross_weight_itm;
                $root94->appendChild($root94_1);
            }

            if ($net_weight_itm == null) {
                $root94_1 = $doc->createElement('Net_weight_itm');
                $root94->appendChild($root94_1);
                $root94_2 = $doc->createElement('null');
                $root94_1->appendChild($root94_2);
            } else {
                $root94_1 = $doc->createElement('Net_weight_itm');
                $root94_1->nodeValue = $net_weight_itm;
                $root94->appendChild($root94_1);
            }

            $root93_1 = $doc->createElement('Total_cost_itm');
            $root93->appendChild($root93_1);
            $root93_2 = $doc->createElement('null');
            $root93_1->appendChild($root93_2);

            $root93_1 = $doc->createElement('Total_CIF_itm');
            $root93->appendChild($root93_1);
            $root93_2 = $doc->createElement('null');
            $root93_1->appendChild($root93_2);


            $root93_1 = $doc->createElement('Rate_of_adjustement');
            $root93->appendChild($root93_1);
            $root93_2 = $doc->createElement('null');
            $root93_1->appendChild($root93_2);


            $root93_1 = $doc->createElement('Statistical_value');
            $root93->appendChild($root93_1);
            $root93_2 = $doc->createElement('null');
            $root93_1->appendChild($root93_2);


            $root93_1 = $doc->createElement('Alpha_coeficient_of_apportionment');
            $root93->appendChild($root93_1);
            $root93_2 = $doc->createElement('null');
            $root93_1->appendChild($root93_2);



            $root95 = $doc->createElement('Item_Invoice');
            $root93->appendChild($root95);

            $root95_1 = $doc->createElement('Amount_national_currency');
            $root95->appendChild($root95_1);
            $root95_2 = $doc->createElement('null');
            $root95_1->appendChild($root95_2);

            if ($amount_foreign_currency == null) {
                $root95_1 = $doc->createElement('Amount_foreign_currency');
                $root95->appendChild($root95_1);
                $root95_2 = $doc->createElement('null');
                $root95_1->appendChild($root95_2);
            } else {
                $root95_1 = $doc->createElement('Amount_foreign_currency');
                $root95_1->nodeValue = $amount_foreign_currency;
                $root95->appendChild($root95_1);
            }


            $root95_1 = $doc->createElement('Currency_code');
            $root95->appendChild($root95_1);
            $root95_2 = $doc->createElement('null');
            $root95_1->appendChild($root95_2);

            $root95_1 = $doc->createElement('Currency_name');
            $root95->appendChild($root95_1);
            $root95_2 = $doc->createElement('null');
            $root95_1->appendChild($root95_2);

            $root95_1 = $doc->createElement('Currency_rate');
            $root95->appendChild($root95_1);
            $root95_2 = $doc->createElement('null');
            $root95_1->appendChild($root95_2);


            $root96 = $doc->createElement('item_external_freight');
            $root93->appendChild($root96);

            $root96_1 = $doc->createElement('Amount_national_currency');
            $root96->appendChild($root96_1);
            $root96_2 = $doc->createElement('null');
            $root96_1->appendChild($root96_2);

            $root96_1 = $doc->createElement('Amount_foreign_currency');
            $root96->appendChild($root96_1);
            $root96_2 = $doc->createElement('null');
            $root96_1->appendChild($root96_2);

            $root96_1 = $doc->createElement('Currency_code');
            $root96->appendChild($root96_1);
            $root96_2 = $doc->createElement('null');
            $root96_1->appendChild($root96_2);


            $root96_1 = $doc->createElement('Currency_name');
            $root96->appendChild($root96_1);
            $root96_2 = $doc->createElement('null');
            $root96_1->appendChild($root96_2);

            $root96_1 = $doc->createElement('Currency_rate');
            $root96->appendChild($root96_1);
            $root96_2 = $doc->createElement('null');
            $root96_1->appendChild($root96_2);



            $root97 = $doc->createElement('item_internal_freight');
            $root93->appendChild($root97);

            $root97_1 = $doc->createElement('Amount_national_currency');
            $root97->appendChild($root97_1);
            $root97_2 = $doc->createElement('null');
            $root97_1->appendChild($root97_2);


            $root97_1 = $doc->createElement('Amount_foreign_currency');
            $root97->appendChild($root97_1);
            $root97_2 = $doc->createElement('null');
            $root97_1->appendChild($root97_2);

            $root97_1 = $doc->createElement('Currency_code');
            $root97->appendChild($root97_1);
            $root97_2 = $doc->createElement('null');
            $root97_1->appendChild($root97_2);

            $root97_1 = $doc->createElement('Currency_name');
            $root97->appendChild($root97_1);
            $root97_2 = $doc->createElement('null');
            $root97_1->appendChild($root97_2);

            $root97_1 = $doc->createElement('Currency_rate');
            $root97->appendChild($root97_1);
            $root97_2 = $doc->createElement('null');
            $root97_1->appendChild($root97_2);



            $root98 = $doc->createElement('item_insurance');
            $root93->appendChild($root98);

            $root98_1 = $doc->createElement('Amount_national_currency');
            $root98->appendChild($root98_1);
            $root98_2 = $doc->createElement('null');
            $root98_1->appendChild($root98_2);


            $root98_1 = $doc->createElement('Amount_foreign_currency');
            $root98->appendChild($root98_1);
            $root98_2 = $doc->createElement('null');
            $root98_1->appendChild($root98_2);

            $root98_1 = $doc->createElement('Currency_code');
            $root98->appendChild($root98_1);
            $root98_2 = $doc->createElement('null');
            $root98_1->appendChild($root98_2);

            $root98_1 = $doc->createElement('Currency_name');
            $root98->appendChild($root98_1);
            $root98_2 = $doc->createElement('null');
            $root98_1->appendChild($root98_2);

            $root98_1 = $doc->createElement('Currency_rate');
            $root98->appendChild($root98_1);
            $root98_2 = $doc->createElement('null');
            $root98_1->appendChild($root98_2);

            $root99 = $doc->createElement('item_other_cost');
            $root93->appendChild($root99);

            $root99_1 = $doc->createElement('Amount_national_currency');
            $root99->appendChild($root99_1);
            $root99_2 = $doc->createElement('null');
            $root99_1->appendChild($root99_2);

            $root99_1 = $doc->createElement('Amount_foreign_currency');
            $root99->appendChild($root99_1);
            $root99_2 = $doc->createElement('null');
            $root99_1->appendChild($root99_2);

            $root99_1 = $doc->createElement('Currency_code');
            $root99->appendChild($root99_1);
            $root99_2 = $doc->createElement('null');
            $root99_1->appendChild($root99_2);

            $root99_1 = $doc->createElement('Currency_name');
            $root99->appendChild($root99_1);
            $root99_2 = $doc->createElement('null');
            $root99_1->appendChild($root99_2);

            $root99_1 = $doc->createElement('Currency_rate');
            $root99->appendChild($root99_1);
            $root99_2 = $doc->createElement('null');
            $root99_1->appendChild($root99_2);


            $root100 = $doc->createElement('item_deduction');
            $root93->appendChild($root100);

            $root100_1 = $doc->createElement('Amount_national_currency');
            $root100->appendChild($root100_1);
            $root100_2 = $doc->createElement('null');
            $root100_1->appendChild($root100_2);

            $root100_1 = $doc->createElement('Amount_foreign_currency');
            $root100->appendChild($root100_1);
            $root100_2 = $doc->createElement('null');
            $root100_1->appendChild($root100_2);


            $root100_1 = $doc->createElement('Currency_code');
            $root100->appendChild($root100_1);
            $root100_2 = $doc->createElement('null');
            $root100_1->appendChild($root100_2);

            $root100_1 = $doc->createElement('Currency_name');
            $root100->appendChild($root100_1);
            $root100_2 = $doc->createElement('null');
            $root100_1->appendChild($root100_2);


            $root100_1 = $doc->createElement('Currency_rate');
            $root100->appendChild($root100_1);
            $root100_2 = $doc->createElement('null');
            $root100_1->appendChild($root100_2);

            $root101 = $doc->createElement('Market_valuer');
            $root93->appendChild($root101);

            $root101_1 = $doc->createElement('Rate');
            $root101->appendChild($root101_1);
            $root101_2 = $doc->createElement('null');
            $root101_1->appendChild($root101_2);

            $root101_1 = $doc->createElement('Currency_code');
            $root101->appendChild($root101_1);
            $root101_2 = $doc->createElement('null');
            $root101_1->appendChild($root101_2);

            $root101_1 = $doc->createElement('Currency_amount');
            $root101->appendChild($root101_1);
            $root101_2 = $doc->createElement('null');
            $root101_1->appendChild($root101_2);

            $root101_1 = $doc->createElement('Basis_description');
            $root101->appendChild($root101_1);
            $root101_2 = $doc->createElement('null');
            $root101_1->appendChild($root101_2);

            $root101_1 = $doc->createElement('Basis_amount');
            $root101->appendChild($root101_1);
            $root101_2 = $doc->createElement('null');
            $root101_1->appendChild($root101_2);

            $root102 = $doc->createElement('FAUCA_item');
            $root66->appendChild($root102);

            $root102_1 = $doc->createElement('FAUCA_criterio_origen');
            $root102->appendChild($root102_1);
            $root102_2 = $doc->createElement('null');
            $root102_1->appendChild($root102_2);

            $root102_1 = $doc->createElement('FAUCA_reglas_accesorias');
            $root102->appendChild($root102_1);
            $root102_2 = $doc->createElement('null');
            $root102_1->appendChild($root102_2);

            $root102_1 = $doc->createElement('FAUCA_unit');
            $root102->appendChild($root102_1);
            $root102_2 = $doc->createElement('null');
            $root102_1->appendChild($root102_2);



            if ($consignee_cod_itm == null) {
                $root103_1 = $doc->createElement('consignee_cod_itm');
                $root66->appendChild($root103_1);
                $root103_2 = $doc->createElement('null');
                $root103_1->appendChild($root103_2);
            } else {
                $root103_1 = $doc->createElement('consignee_cod_itm');
                $root103_1->nodeValue = $consignee_cod_itm;
                $root66->appendChild($root103_1);
            }

            if ($consignee_nam_itm == null) {
                $root103_1 = $doc->createElement('consignee_nam_itm');
                $root66->appendChild($root103_1);
                $root103_2 = $doc->createElement('null');
                $root103_1->appendChild($root103_2);
            } else {
                $root103_1 = $doc->createElement('consignee_nam_itm');
                $root103_1->nodeValue = $consignee_nam_itm;
                $root66->appendChild($root103_1);
            }


            if ($consignee_nam_itm == null) {
                $root103_1 = $doc->createElement('consignee_typ_itm');
                $root66->appendChild($root103_1);
                $root103_2 = $doc->createElement('null');
                $root103_1->appendChild($root103_2);
            } else {
                $root103_1 = $doc->createElement('consignee_typ_itm');
                $root103_1->nodeValue = $consignee_nam_itm;
                $root66->appendChild($root103_1);
            }


            $root104 = $doc->createElement('Attached_documents');
            $root66->appendChild($root104);

            echo var_dump($datos_docs['doc']);
            foreach ($datos_docs['doc'] as $adjunto) {

                $attached_document_code = $adjunto->tipodocumento;
                $attached_document_name = $adjunto->descripcion;

                $attached_document_date = date("m/d/Y", strtotime($adjunto->fecha_documento));


                if ($adjunto->fecha_expiracion == "0000-00-00") {
                    $attached_document_date_expiration = null;
                } else {
                    $attached_document_date_expiration = date("m/d/Y", strtotime($adjunto->fecha_expiracion));
                }

                $temp_attached_document_item = $adjunto->item;
                $attached_document_reference = $adjunto->referencia;

                $attached_document_amount = $adjunto->monto_autorizado;

                $root105 = $doc->createElement('Attached_document');
                $root104->appendChild($root105);

                if ($attached_document_code == null) {
                    $root105_1 = $doc->createElement('Attached_document_code');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_code');
                    $root105_1->nodeValue = $attached_document_code;
                    $root105->appendChild($root105_1);
                }

                if ($attached_document_name == null) {
                    $root105_1 = $doc->createElement('Attached_document_name');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_name');
                    $root105_1->nodeValue = $attached_document_name;
                    $root105->appendChild($root105_1);
                }

                $root105_1 = $doc->createElement('Attached_document_from_rule');
                $root105->appendChild($root105_1);
                $root105_2 = $doc->createElement('null');
                $root105_1->appendChild($root105_2);

                if ($attached_document_date == null) {
                    $root105_1 = $doc->createElement('Attached_document_date');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {

                    $root105_1 = $doc->createElement('Attached_document_date');
                    $root105_1->nodeValue =  $attached_document_date;
                    $root105->appendChild($root105_1);
                }

                if ($temp_attached_document_item == null) {
                    $root105_1 = $doc->createElement('Temp_attached_document_item');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Temp_attached_document_item');
                    $root105_1->nodeValue = $temp_attached_document_item;
                    $root105->appendChild($root105_1);
                }

                if ($attached_document_reference == null) {
                    $root105_1 = $doc->createElement('Attached_document_reference');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_reference');
                    $root105_1->nodeValue = $attached_document_reference;
                    $root105->appendChild($root105_1);
                }

                if ($attached_document_date_expiration == null) {
                    $root105_1 = $doc->createElement('Attached_document_date_expiration');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_date_expiration');
                    $root105_1->nodeValue = $attached_document_date_expiration;
                    $root105->appendChild($root105_1);
                }
                $attached_document_country_code = null;
                if ($attached_document_country_code == null) {
                    $root105_1 = $doc->createElement('Attached_document_country_code');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_country_code');
                    $root105_1->nodeValue = $attached_document_country_code;
                    $root105->appendChild($root105_1);
                }

                $attached_document_entity_code = null;
                if ($attached_document_entity_code == null) {
                    $root105_1 = $doc->createElement('Attached_document_entity_code');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_entity_code');
                    $root105_1->nodeValue = $attached_document_entity_code;
                    $root105->appendChild($root105_1);
                }

                $attached_document_entity_name = null;
                if ($attached_document_entity_name == null) {
                    $root105_1 = $doc->createElement('Attached_document_entity_name');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_entity_name');
                    $root105_1->nodeValue = $attached_document_entity_name;
                    $root105->appendChild($root105_1);
                }

                $attached_document_entity_other = null;
                if ($attached_document_entity_other == null) {
                    $root105_1 = $doc->createElement('Attached_document_entity_other');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_entity_other');
                    $root105_1->nodeValue = $attached_document_entity_other;
                    $root105->appendChild($root105_1);
                }


                if ($attached_document_amount == null) {
                    $root105_1 = $doc->createElement('Attached_document_amount');
                    $root105->appendChild($root105_1);
                    $root105_2 = $doc->createElement('null');
                    $root105_1->appendChild($root105_2);
                } else {
                    $root105_1 = $doc->createElement('Attached_document_amount');
                    $root105_1->nodeValue = $attached_document_amount;
                    $root105->appendChild($root105_1);
                }
            } //fin adjuntos

        } // fin items

        $root106 = $doc->createElement('Temp');
        $root->appendChild($root106);


        $root106_1 = $doc->createElement('Scanned_Documents_CDATA');
        $root106_1->appendChild($doc->createCDATASection($doc_scaneado));
        $root106->appendChild($root106_1);





        foreach ($datos_eq['eq'] as $eq) {
            $item_Number = $eq->item;
            $equipment_type = $eq->id_equipamiento;
            $equipment_size = $eq->tamano_equipo;
            $id_equipment = $eq->idequipamiento;
            $container_identity = $eq->contenedor;
            $container_type = $eq->id_contenedor;
            $empty_full_indicator = $eq->id_carga;
            $packages_number = $eq->numero_paquetes;
            $packages_weight = $eq->peso_mercancias;

            $root107 = $doc->createElement('Container');
            $root->appendChild($root107);

            $root108 = $doc->createElement('Item');
            $root107->appendChild($root108);

            if ($attached_document_reference == null) {
                $root108_1 = $doc->createElement('Item_Number');
                $root108->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Item_Number');
                $root108_1->nodeValue = $item_Number;
                $root108->appendChild($root108_1);
            }

            if ($equipment_type == null) {
                $root108_1 = $doc->createElement('Equipment_type');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Equipment_type');
                $root108_1->nodeValue = $equipment_type;
                $root107->appendChild($root108_1);
            }


            if ($equipment_size == null) {
                $root108_1 = $doc->createElement('Equipment_size');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Equipment_size');
                $root108_1->nodeValue = $equipment_size;
                $root107->appendChild($root108_1);
            }

            if ($id_equipment == null) {
                $root108_1 = $doc->createElement('ID_equipment');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('ID_equipment');
                $root108_1->nodeValue = $id_equipment;
                $root107->appendChild($root108_1);
            }

            if ($container_identity == null) {
                $root108_1 = $doc->createElement('Container_identity');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Container_identity');
                $root108_1->nodeValue = $container_identity;
                $root107->appendChild($root108_1);
            }

            if ($container_type == null) {
                $root108_1 = $doc->createElement('Container_type');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Container_type');
                $root108_1->nodeValue = $container_type;
                $root107->appendChild($root108_1);
            }

            if ($empty_full_indicator == null) {
                $root108_1 = $doc->createElement('Empty_full_indicator');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Empty_full_indicator');
                $root108_1->nodeValue = $empty_full_indicator;
                $root107->appendChild($root108_1);
            }


            if ($gross_weight == null) {
                $root108_1 = $doc->createElement('Gross_weight');
                $root107->appendChild($root108_1);
                $root108_2 = $doc->createElement('null');
                $root108_1->appendChild($root108_2);
            } else {
                $root108_1 = $doc->createElement('Gross_weight');
                $root108_1->nodeValue = $gross_weight;
                $root107->appendChild($root108_1);
            }

            $root109 = $doc->createElement('Package');
            $root107->appendChild($root109);

            if ($packages_number == null) {
                $root109_1 = $doc->createElement('Packages_number');
                $root109->appendChild($root109_1);
                $root109_2 = $doc->createElement('null');
                $root109_1->appendChild($root109_2);
            } else {
                $root109_1 = $doc->createElement('Packages_number');
                $root109_1->nodeValue = $packages_number;
                $root109->appendChild($root109_1);
            }

            if ($packages_weight == null) {
                $root109_1 = $doc->createElement('Packages_weight');
                $root109->appendChild($root109_1);
                $root109_2 = $doc->createElement('null');
                $root109_1->appendChild($root109_2);
            } else {
                $root109_1 = $doc->createElement('Packages_weight');
                $root109_1->nodeValue = $packages_weight;
                $root109->appendChild($root109_1);
            }
        }

        //TODO:National_customs_procedure revisar esto

        $ubicacion = sys_base("duar/public/xml");
        $filename = $ubicacion . "/" . "R" . $ref_duca . ".xml";
        $doc->save($filename);
        //  $ubicacion .= "/" . $nombre;
        //  file_put_contents($filename, $content);
        // echo $respuesta;
    }

    /*======================================================================*/

    public function info_accesos()
    {
        $datos   = $this->Conf_modal->info_accesos();
    }

    public function verifica_permiso($opcion)
    {

        if ($opcion == 1  || $opcion == 7) {
            $permiso = $_SESSION['add'];
        }


        if ($opcion == 2) {
            $permiso = $_SESSION['edit'];
        }

        if ($opcion == 3) {
            $permiso = $_SESSION['delete'];
        }


        if ($opcion == 6) {
            $permiso = $_SESSION['consulta'];
        }

        if ($opcion == 7) {
            $permiso = $_SESSION['add'];
        }

        $data = array(
            'permiso'        => $permiso
        );

        echo json_encode($data);
    }
    public function download_xml($filename)
    {
        $this->load->helper('download');
        $data = file_get_contents(base_url('/public/xml/' . $filename));
        force_download($filename, $data);
    }

    public function cargar_adjunto_masivo()
    {
        $nombre = $_FILES["file_up"]["name"];
        $ubicacion = sys_base("duar/public/dmup");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }

        $ubicacion .= "/" . $nombre;
        move_uploaded_file($_FILES['file_up']['tmp_name'], $ubicacion);
        $encode = chunk_split(base64_encode(file_get_contents($ubicacion)));
    }
}
