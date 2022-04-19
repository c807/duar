<?php
class Crear extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
            'registro_nac_medio'     =>  $_POST['registro_nac_medio']

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
        $id = $det->numitem($_SESSION['dua']);
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
        $id_detalle = $_POST['id_detalle'];
        $dua_id = $this->Crearpoliza_model->guardar_items($id_detalle, $data);
    }


    public function guardar_adjunto($id, $dua)
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
        //echo $ubicacion;
        // var_dump($_FILES);
        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);
        // $encode = chunk_split(file_get_contents($ubicacion));
        $encode = chunk_split(base64_encode(file_get_contents($ubicacion)));

        //$str = $this->base64url_encode($encode);



        // $encode = $str;
        // echo $encode;
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
            'nombre_documento'              =>  $nombre



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

        $archivo = getcwd() . "/" . $ref . ".pdf";

        $pdf_decoded = base64_decode($cadena);
        //Write data back to pdf file
        $pdf = fopen($archivo, 'w');
        fwrite($pdf, $pdf_decoded);
        //close output file
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
        echo "fffffffffffffffffffffffffffffffffffffffffffffffffff" . $container;
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





    public function generar_xml($id, $ref_duca)
    {
        header('Content-Type: application/json'); //cabecera json
        $data = array("ATTACHED_DOCUMENTS_LIST" => array());
        $general   = $this->Crearpoliza_model->generar_xml($id);
        $datos_items['items']    = $this->Crearpoliza_model->lista_items($id);
        $datos_docs['doc']    = $this->Crearpoliza_model->listado_adjuntos($id);
        $datos_eq['eq']    = $this->Crearpoliza_model->lista_equipamiento($id);
        $doc_scaneado = "";
        $hijos = "";
        $document_name = "APPLICATION/PDF";
        $padre = '{' . '"ATTACHED_DOCUMENTS_LIST"' . ":" . "[";
        foreach ($datos_docs['doc']  as  $adjunto) {
            $tipo_documento = $adjunto->tipodocumento;
            $referencia = $adjunto->referencia;
            $doc_scaneado = $adjunto->documento_escaneado;

            $str = str_replace(array("\r\n", "\r", "\n"), '', $doc_scaneado);
            $ref = str_replace(array("\r\n", "\r", "\n"), '', $referencia);
            // $str = str_replace(["\r\n", "\r", "\n"], '', $doc_scaneado); //falla en servidor produccion
            // $ref = str_replace(["\r\n", "\r", "\n"], '', $referencia);//falla en servidor produccion

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

        // $str = preg_replace('//s*/', '', $data); //falla en servidor produccion
        // $str = str_replace(["\r\n", "\r", "\n"], '', $str);//falla en servidor produccion

        $str = preg_replace(array('//s*/'), '', $data);
        $str = str_replace(array("\r\n", "\r", "\n"), '', $str);


        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        // echo $json;
        // exit;
        //  $api_key = "WSAA.08071107520015:4iqdMuStIt0Ww9h"; //pruebas
        //  $password = "4iqdMuStIt0Ww9h"; //pruebas

        $api_key = "WSAA.08071107520015:RFi1esgCqjHFkQG"; //produccion
        // $password = "4iqdMuStIt0Ww9h";
        $key = base64_encode($api_key);

        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://swtest.aduana.gob.sv/WSWebInterface/REST/encodeAttachedDocuments"); //servidor  pruebas
        curl_setopt($ch, CURLOPT_URL, "https://siduneaworld.aduana.gob.sv/WSWebInterface/REST/encodeAttachedDocuments"); // servidor producccion
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $api_key);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
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
          //  echo 'Curl error: ' . curl_error($ch);
        }
        $errors = curl_error($ch);  //retorna errores                                                                                                          
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE); //retorna el codigo de respuesta
        curl_close($ch);

        $rsl = json_decode($result, true);
        $doc_scaneado = $rsl['ENCODED_ATTACHED_DOCUMENTS'];
        //  echo $result;
        $respuesta="";
        if ($rsl['errorCode'] == 0) {
            $respuesta= "DOCUMENTOS ADJUNTOS PROCESADOS CORRECTAMENTE";
        } else {
            $respuesta= "ERROR, NO HA SIFO POSIBLE PROCESAR DOCUMENTOS ADJUNTOS";
        }
        // echo $json;
        // exit;
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
        // $xml->writeElement("Exporter_code", $datos->nit_exportador);
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


        //  $general->nit_exportador
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('	');
        // $xml->startDocument('version="1.0" encoding="UTF-8" standalone="no"');
        $xml->startDocument('1.0', 'UTF-8', 'no');

        $xml->startElement("ASYCUDA"); //elemento colegio

        $xml->startElement("Export_release"); //elemento curso        
        //$xml->writeElement("Date_of_exit", $date_of_exit);
        if ($date_of_exit == null) {
            $xml->startElement("Date_of_exit");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Date_of_exit", $date_of_exit);
        }
        //$xml->writeElement("Time_of_exit", $time_of_exit);
        if ($time_of_exit == null) {
            $xml->startElement("Time_of_exit");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Time_of_exit", $time_of_exit);
        }
        // $xml->writeElement("Actual_office_of_exit_code", $actual_office_of_exit_code);
        if ($actual_office_of_exit_code == null) {
            $xml->startElement("Actual_office_of_exit_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Actual_office_of_exit_code", $actual_office_of_exit_code);
        }
        //$xml->writeElement("Actual_office_of_exit_name", $actual_office_of_exit_name);
        if ($actual_office_of_exit_code == null) {
            $xml->startElement("Actual_office_of_exit_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Actual_office_of_exit_name", $actual_office_of_exit_code);
        }

        if ($exit_reference == null) {
            $xml->startElement("Exit_reference");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Exit_reference", $exit_reference);
        }

        if ($comments == null) {
            $xml->startElement("Comments");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Comments", $comments);
        }


        $xml->endElement(); //fin export_release

        $xml->startElement("Assessment_notice"); //  14  hijos de item 
        //$xml->writeElement("Item_tax_total",$item_tax_total);
        if ($item_tax_total == null) {
            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Item_tax_total");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            //$item_tax_total =  $datos->$item_tax_total;
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
            $xml->writeElement("Item_tax_total", $item_tax_total);
        }



        $xml->endElement(); //fin Assessment_notice

        $xml->startElement("Global_taxes");
        if ($global_tax_item == null) {
            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();

            $xml->startElement("Global_tax_item");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
            $xml->writeElement("Global_tax_item", $global_tax_item);
        } //estoy aqui

        $xml->endElement(); //fin Global_taxes

        $xml->startElement("Property");
        $xml->startElement("Forms");

        if ($number_of_the_form == null) {
            $xml->startElement("Number_of_the_form");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Number_of_the_form", $number_of_the_form);
        }


        if ($total_number_of_forms == null) {
            $xml->startElement("Total_number_of_forms");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Total_number_of_forms", $total_number_of_forms);
        }
        $xml->endElement(); //fin Forms

        $xml->startElement("Nbers");

        if ($number_of_loading_lists == null) {
            $xml->startElement("Number_of_loading_lists");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Number_of_loading_lists", $number_of_loading_lists);
        }


        if ($total_number_of_items == null) {
            $xml->startElement("Total_number_of_items");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Total_number_of_items", $total_number_of_items);
        }


        if ($total_number_of_packages == null) {
            $xml->startElement("Total_number_of_packages");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Total_number_of_packages", $total_number_of_packages);
        }


        $xml->endElement(); //fin Nbers


        if ($place_of_declaration == null) {
            $xml->startElement("Place_of_declaration");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Place_of_declaration", $place_of_declaration);
        }

        if ($date_of_declaration == null) {
            $xml->startElement("Date_of_declaration");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Date_of_declaration", $date_of_declaration);
        }

        if ($selected_page == null) {
            $xml->startElement("Selected_page");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Selected_page", $selected_page);
        }
        $xml->endElement(); // fin Property

        $xml->startElement("Identification");
        $xml->startElement("Office_segment"); //  consultar sobre su  cierre

        if ($customs_clearance_office_code == null) {
            $xml->startElement("Customs_clearance_office_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Customs_clearance_office_code", $customs_clearance_office_code);
        }
        $xml->endElement(); // fin Identification

        $xml->startElement("Type");


        if ($type_of_declaration == null) {
            $xml->startElement("Type_of_declaration");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Type_of_declaration", $type_of_declaration);
        }


        if ($declaration_gen_procedure_code == null) {
            $xml->startElement("Declaration_gen_procedure_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Declaration_gen_procedure_code", $declaration_gen_procedure_code);
        }

        if ($type_of_transit_document == null) {
            $xml->startElement("Type_of_transit_document");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Type_of_transit_document", $type_of_transit_document);
        }
        $xml->endElement();  // fin Type

        if ($manifest_reference_number == null) {
            $xml->startElement("Manifest_reference_number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Manifest_reference_number", $manifest_reference_number);
        }

        $xml->startElement("Registration");

        if ($serial_number == null) {
            $xml->startElement("Serial_number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Serial_number", $serial_number);
        }

        if ($number == null) {
            $xml->startElement("Number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Number", $number);
        }

        if ($date == null) {
            $xml->startElement("Date");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Date", $date);
        }
        $xml->endElement(); // fin Registration

        $xml->startElement("Assessment");

        if ($serial_number == null) {
            $xml->startElement("Serial_number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Serial_number", $serial_number);
        }

        if ($number == null) {
            $xml->startElement("Number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Number", $number);
        }

        if ($date == null) {
            $xml->startElement("Date");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Date", $date);
        }
        $xml->endElement(); // fin Assessment

        $xml->startElement("receipt");

        if ($serial_number == null) {
            $xml->startElement("Serial_number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Serial_number", $serial_number);
        }

        if ($number == null) {
            $xml->startElement("Number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Number", $number);
        }

        if ($date == null) {
            $xml->startElement("Date");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Date", $date);
        }
        $xml->endElement(); // fin receipt
        $xml->endElement(); // fin Identification

        $xml->startElement("Traders");
        $xml->startElement("Exporter");

        if ($exporter_code == null) {
            $xml->startElement("Exporter_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {

            $xml->writeElement("Exporter_code", $exporter_code);
        }


        if ($exporter_name == null) {
            $xml->startElement("Exporter_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {

            $xml->writeElement("Exporter_name", $exporter_name);
        }
        $xml->endElement(); // fin Exporter

        $xml->startElement("Consignee");

        if ($consignee_code == null) {
            $xml->startElement("Consignee_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Consignee_code", $consignee_code);
        }

        if ($consignee_name == null) {
            $xml->startElement("Consignee_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Consignee_name", $consignee_name);
        }


        if ($consignee_name_doc == null) {
            $xml->startElement("Consignee_name_doc");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Consignee_name_doc", $consignee_name_doc);
        }

        $xml->endElement(); //fin Consignee

        $xml->startElement("Financial");

        if ($financial_code == null) {
            $xml->startElement("Financial_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Financial_code", $financial_code);
        }

        if ($financial_name == null) {
            $xml->startElement("Financial_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Financial_name", $financial_name);
        }
        $xml->endElement(); //fin Financial

        $xml->endElement(); //fin Traders

        $xml->startElement("Declarant");

        if ($declarant_code == null) {
            $xml->startElement("Declarant_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Declarant_code", $declarant_code);
        }

        if ($declarant_name == null) {
            $xml->startElement("Declarant_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Declarant_name",  $declarant_name);
        }

        if ($declarant_representative == null) {
            $xml->startElement("Declarant_representative");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Declarant_representative",  $declarant_representative);
        }

        $xml->startElement("Reference");
        if ($number_reference == null) {
            $xml->startElement("Number");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Number",  $number_reference);  // completar esto en formulario de creacion de poliza
        }

        $xml->endElement();


        $xml->endElement(); // fin Declarant

        $xml->startElement("General_information");

        $xml->startElement("Country");

        if ($country_first_destination == null) {
            $xml->startElement("Country_first_destination");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Country_first_destination", $country_first_destination);
        }

        if ($trading_country == null) {
            $xml->startElement("Trading_country");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Trading_country",  $trading_country);
        }

        $xml->startElement("Export");

        if ($export_country_code == null) {
            $xml->startElement("Export_country_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Export_country_code", $export_country_code);
        }

        if ($export_country_region == null) {
            $xml->startElement("Export_country_region");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Export_country_region", $export_country_region);
        }
        $xml->endElement(); //Export

        $xml->startElement("Destination");

        if ($destination_country_code == null) {
            $xml->startElement("Destination_country_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Destination_country_code", $destination_country_code);
        }


        if ($destination_country_region == null) {
            $xml->startElement("Destination_country_region");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Destination_country_region",  $destination_country_region);
        }
        $xml->endElement(); //Destination

        if ($country_of_origin_name == null) {
            $xml->startElement("Country_of_origin_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Country_of_origin_name", $country_of_origin_name);
        }

        $xml->endElement(); //Country



        if ($value_details == null) {
            $xml->startElement("Value_details");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Value_details", $value_details);
        }


        if ($cap == null) {
            $xml->startElement("CAP");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("CAP", $cap);
        }

        if ($additional_information == null) {
            $xml->startElement("Additional_information");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Additional_information", $additional_information);
        }

        if ($comments_free_text == null) {
            $xml->startElement("Comments_free_text");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Comments_free_text", $comments_free_text);
        }

        $xml->endElement(); // fin General_information


        $xml->startElement("Transport");
        $xml->startElement("Means_of_transport");

        $xml->startElement("Departure_arrival_information");


        if ($identity_arrival_information == null) {
            $xml->startElement("Identity");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Identity", $identity_arrival_information);
        }


        if ($nationality_arrival_information == null) {
            $xml->startElement("Nationality");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Nationality", $nationality_arrival_information);
        }


        $xml->endElement(); // Departure_arrival_information

        $xml->startElement("Border_information");

        if ($identity == null) {
            $xml->startElement("Identity");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Identity", $identity);
        }


        if ($nationality == null) {
            $xml->startElement("Nationality");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Nationality", $nationality);
        }



        if ($mode == null) {
            $xml->startElement("Mode");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Mode", $mode);
        }
        $xml->endElement(); // Border_information
        //$xml->endElement(); // Border_information


        if ($inland_mode_of_transport == null) {
            $xml->startElement("Inland_mode_of_transport");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Inland_mode_of_transport", $inland_mode_of_transport);
        }

        $xml->endElement(); // Means_of_transport

        if ($container_flag == null) {
            $xml->startElement("Container_flag");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Container_flag", $container_flag);
        }


        $xml->startElement("Delivery_terms");

        if ($inco_term == null) {
            $xml->startElement("Code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Code", $inco_term);
        }

        if ($place == null) {
            $xml->startElement("Place");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Place", $place);
        }

        if ($situation == null) {
            $xml->startElement("Situation");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Situation", $situation);
        }
        $xml->endElement(); // Delivery_terms

        $xml->startElement("Border_office");


        if ($aduana_registro_code == null) {
            $xml->startElement("Code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Code", $aduana_registro_code);
        }



        if ($aduana_registro_name == null) {
            $xml->startElement("Name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Name", $aduana_registro_name);
        }



        $xml->endElement(); // Border_office


        $xml->startElement("Place_of_loading");


        if ($lugar_carga == null) {
            $xml->startElement("Code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Code", $lugar_carga);
        }
        //$xml->writeElement("Name", "name");
        if ($name_carga == null) {
            $xml->startElement("Name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Name", $name_carga);
        }

        //$xml->writeElement("Country", "name");
        if ($country == null) {
            $xml->startElement("Country");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Country", $country);
        }
        $xml->endElement(); // Place_of_loading

        // $xml->writeElement("Location_of_goods", $general->localizacion_mercancia);
        if ($location_of_goods == null) {
            $xml->startElement("Location_of_goods");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Location_of_goods", $location_of_goods);
        }


        $xml->endElement(); // Transport

        $xml->startElement("Financial");


        $xml->startElement("Financial_transaction");

        if ($financial_transaction_code1 == null) {
            $xml->startElement("code1");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("code1", $financial_transaction_code1);
        }

        if ($financial_transaction_code2 == null) {
            $xml->startElement("code2");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("code2", $financial_transaction_code2);
        }

        $xml->endElement(); // Financial

        $xml->startElement("Bank");
        if ($codigo_banco == null) {
            $xml->startElement("Code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Code", $codigo_banco);
        }


        if ($nombre_banco == null) {
            $xml->startElement("Name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Name",  $nombre_banco);
        }

        if ($branch == null) {
            $xml->startElement("Branch");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Branch",  $branch);
        }

        if ($regimen_adicional == null) {
            $xml->startElement("Reference");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Reference",  $regimen_adicional);
        }
        $xml->endElement(); // Bank


        $xml->startElement("Terms");

        if ($terms_code == null) {
            $xml->startElement("Code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Code", $terms_code);
        }

        if ($terms_description == null) {
            $xml->startElement("Description");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Description", $terms_description);
        }
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
        $xml->endElement(); //fin Total_manual_taxes

        $xml->startElement("Global_taxes");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Global_taxes

        $xml->startElement("Totals_taxes");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); //fin Totals_taxes

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

        if ($calculation_working_mode == null) {
            $xml->startElement("Calculation_working_mode");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Calculation_working_mode", $calculation_working_mode);
        }
        $xml->startElement("Weight");
        $gross_weight = null;
        if ($gross_weight == null) {
            $xml->startElement("Gross_weight");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Gross_weight", $gross_weight);
        }
        $xml->endElement(); // Weight*/

        /* $xml->startElement("Gross_weight");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // Gross_weight
        $xml->endElement(); // Weight*/

        $xml->startElement("Total_cost");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Total_cost

        $xml->startElement("Total_CIF");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Total_CIF

        $xml->startElement("Gs_Invoice");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency


        if ($amount_foreign_currency == null) {
            $xml->startElement("Amount_foreign_currency");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Amount_foreign_currency", $amount_foreign_currency);
        }



        if ($currency_code == null) {
            $xml->startElement("Currency_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_code", $currency_code);
        }

        $gs_invoice_Currency_name = null;
        if ($gs_invoice_Currency_name == null) {
            $xml->startElement("Currency_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_name", $gs_invoice_Currency_name);
        }

        $gs_invoice_Currency_rate = null;

        if ($gs_invoice_Currency_rate == null) {
            $xml->startElement("Currency_rate");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_rate", $gs_invoice_Currency_rate);
        }



        $xml->endElement(); // fin Gs_Invoice

        $xml->startElement("Gs_external_freight");


        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        if ($flete_interno == null) {
            $xml->startElement("Amount_foreign_currency");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Amount_foreign_currency", $flete_interno);
        }


        if ($currency_code == null) {
            $xml->startElement("Currency_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_code", $currency_code);
        }

        $gs_external_currency_name = null;
        if ($gs_external_currency_name == null) {
            $xml->startElement("Currency_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_name", $gs_external_currency_name);
        }


        $gs_external_currency_rate = null;
        if ($gs_external_currency_rate == null) {
            $xml->startElement("Currency_rate");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_rate", $gs_external_currency_rate);
        }
        $xml->endElement();
        /* gsinternal  */


        $xml->startElement("Gs_internal_freight");


        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency

        if ($flete_externo == null) {
            $xml->startElement("Amount_foreign_currency");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Amount_foreign_currency", $flete_externo);
        }


        if ($currency_code == null) {
            $xml->startElement("Currency_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_code", $currency_code);
        }

        $gs_external_currency_name = null;
        if ($gs_external_currency_name == null) {
            $xml->startElement("Currency_name");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_name", $gs_external_currency_name);
        }


        $gs_external_currency_rate = null;
        if ($gs_external_currency_rate == null) {
            $xml->startElement("Currency_rate");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_rate", $gs_external_currency_rate);
        }

        $xml->endElement(); // fin Gs_internal_freight
        /* fin */




        $xml->startElement("Gs_insurance");

        $xml->startElement("Amount_national_currency");
        $xml->startElement("null");
        $xml->endElement();
        $xml->endElement(); // fin Amount_national_currency


        if ($seguro == null) {
            $xml->startElement("Amount_foreign_currency");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Amount_foreign_currency", $seguro);
        }

        if ($currency_code == null) {
            $xml->startElement("Currency_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_code", $currency_code);
        }


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


        if ($otros_costos == null) {
            $xml->startElement("Amount_foreign_currency");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $n = $otros_costos;
            $aux = (string) $n;
            $decimal = substr($aux, strpos($aux, "."));
            if ($decimal == "0.00") {
                $otros_costos = "0.0";
            }
            $xml->writeElement("Amount_foreign_currency", $otros_costos);
        }

        if ($currency_code == null) {
            $xml->startElement("Currency_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_code", $currency_code);
        }

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


        if ($deducciones == null) {
            $xml->startElement("Amount_foreign_currency");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $n = $deducciones;
            $aux = (string) $n;
            $decimal = substr($aux, strpos($aux, "."));
            if ($decimal == "0.00") {
                $deducciones = "0.0";
            }
            $xml->writeElement("Amount_foreign_currency", $deducciones);
        }

        if ($currency_code == null) {
            $xml->startElement("Currency_code");
            $xml->writeElement("null");
            $xml->endElement();
        } else {
            $xml->writeElement("Currency_code", $currency_code);
        }

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
        //var_dump($datos_items['items']);

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
            $suppplementary_unit_quantity = $item->no_bultos;
            $item_price = $item->precio_item;
            $country_of_origin_code = $item->origen;
            $dato_partida = $this->Crearpoliza_model->consulta_producto($item->partida);

            $commercial_description = $dato_partida->descripcion;
            $commercial_description = substr($commercial_description, 0, 44);

            $summary_declaration = $item->doc_transp;
            $amount_deducted_from_licence = "0.0";
            $gross_weight_itm = $item->peso_bruto;
            $net_weight_itm = $item->peso_neto;
            $amount_foreign_currency = $item->precio_item;
            $consignee_cod_itm = "N/A";
            $consignee_nam_itm = "N/A";
            $consignee_typ_itm = "ARE";

            $xml->startElement("Item");
            if ($temp_item_number == null) {
                $xml->startElement("Temp_item_number");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Temp_item_number", $temp_item_number);
            }

            $xml->startElement("Packages");
            if ($number_of_packages == null) {
                $xml->startElement("Number_of_packages");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Number_of_packages", $number_of_packages);
            }
            //  agregado 
            if ($marks1_of_packages == null) {
                $xml->startElement("Marks1_of_packages");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Marks1_of_packages", $marks1_of_packages);
            }

            if ($marks2_of_packages == null) {
                $xml->startElement("Marks2_of_packages");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Marks2_of_packages", $marks2_of_packages);
            }



            //  $xml->writeElement("Kind_of_packages_code", $item->origen);
            if ($kind_of_packages_code == null) {
                $xml->startElement("Kind_of_packages_code");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Kind_of_packages_code", $kind_of_packages_code);
            }

            $xml->endElement(); // fin Packages

            $xml->startElement("Tarification");

            $xml->startElement("Tarification_data");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Tarification_data

            $xml->startElement("HScode");
            // $xml->writeElement("Commodity_code", $commodity_code);
            if ($commodity_code == null) {
                $xml->startElement("Commodity_code");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Commodity_code", $commodity_code);
            }

            //$xml->writeElement("Precision_1",$precision_1 );
            if ($precision_1 == null) {
                $xml->startElement("Precision_1");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Precision_1", $precision_1);
            }


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

            $preference_code = $item->codigo_preferencia;


            if ($preference_code == null) {
                $xml->startElement("Preference_code");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Preference_code", $preference_code);
                // $xml->writeElement("Preference_code", $item->codigo_preferencia);
            }

            $extended_customs_procedure = $general->reg_extendido;
            if ($extended_customs_procedure == null) {
                $xml->startElement("Extended_customs_procedure");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Extended_customs_procedure", $extended_customs_procedure);
            }

            $national_customs_procedure = $general->reg_adicional;
            if ($national_customs_procedure == null) {
                $xml->startElement("National_customs_procedure");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("National_customs_procedure", $national_customs_procedure);
            }


            $xml->startElement("Quota_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Quota_code

            $xml->startElement("Quota");

            $xml->startElement("QuotaCode");
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



            if ($suppplementary_unit_quantity == null) {
                $xml->startElement("Suppplementary_unit_quantity");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Suppplementary_unit_quantity", $suppplementary_unit_quantity);
            }



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

            $xml->writeElement("Suppplementary_unit_quantity", "0.0");

            $xml->endElement(); // fin Suppplementary_unit_quantity

            $xml->startElement("Supplementary_unit");

            $xml->startElement("Suppplementary_unit_code");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_code

            $xml->startElement("Suppplementary_unit_name");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Suppplementary_unit_name

            $xml->writeElement("Suppplementary_unit_quantity", "0.0");
            $xml->endElement(); // fin Suppplementary_unit_quantity

            if ($item_price == null) {
                $xml->startElement("Item_price");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Item_price", $item_price);
            }

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

            if ($country_of_origin_code == null) {
                $xml->startElement("Country_of_origin_code");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Country_of_origin_code", $country_of_origin_code);
            }

            $xml->startElement("Country_of_origin_region");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Country_of_origin_region

            $xml->startElement("Description_of_goods");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin Description_of_goods

            //$xml->writeElement("Commercial_Description", $item->desc_sac);
            if ($commercial_description == null) {
                $xml->startElement("Commercial_Description");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Commercial_Description", $commercial_description);
            }

            $xml->endElement(); // fin Goods_description

            $xml->startElement("Previous_doc");

            if ($summary_declaration == null) {
                $xml->startElement("Summary_declaration");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Summary_declaration", $summary_declaration);
            }

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

            if ($amount_deducted_from_licence == null) {
                $xml->startElement("Amount_deducted_from_licence");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Amount_deducted_from_licence", $amount_deducted_from_licence);
            }

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
            $xml->startElement("Weight_itm");


            if ($gross_weight_itm == null) {
                $xml->startElement("Gross_weight_itm");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Gross_weight_itm", $gross_weight_itm);
            }
            //$xml->writeElement("Gross_weight_itm", $item->peso_neto);
            if ($net_weight_itm == null) {
                $xml->startElement("Net_weight_itm");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Net_weight_itm", $net_weight_itm);
            }
            $xml->endElement(); // fin Taxation

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


            if ($amount_foreign_currency == null) {
                $xml->startElement("Amount_foreign_currency");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Amount_foreign_currency", $amount_foreign_currency);
            }

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


            //here
            $xml->startElement("item_internal_freight");

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

            $xml->endElement(); // fin item_internal_freight

            //here



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


            $xml->startElement("FAUCA_unit");
            $xml->startElement("null");
            $xml->endElement();
            $xml->endElement(); // fin FAUCA_reglas_accesorias


            $xml->endElement(); // fin FAUCA_item


            if ($consignee_cod_itm == null) {
                $xml->startElement("consignee_cod_itm");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("consignee_cod_itm", $consignee_cod_itm);
            }


            if ($consignee_nam_itm == null) {
                $xml->startElement("consignee_nam_itm");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("consignee_nam_itm", $consignee_nam_itm);
            }

            if ($consignee_typ_itm == null) {
                $xml->startElement("consignee_typ_itm");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("consignee_typ_itm", $consignee_typ_itm);
            }


            //FIN ITEMS
            $xml->startElement("Attached_documents");
            // var_dump($datos_docs['doc']);
            foreach ($datos_docs['doc'] as $doc) {

                $attached_document_code = $doc->tipodocumento;
                $attached_document_name = $doc->descripcion;

                $attached_document_date = date("m/d/Y", strtotime($doc->fecha_documento));
                if ($doc->fecha_expiracion) {
                    $attached_document_date_expiration = date("m/d/Y", strtotime($doc->fecha_expiracion));
                } else {
                    $attached_document_date_expiration = null;
                }


                $temp_attached_document_item = $doc->item;
                $attached_document_reference = $doc->referencia;
                // $attached_document_date_expiration =  $attached_document_date;
                $attached_document_amount = $doc->monto_autorizado;
                //$attached_document_date= date("d/m/Y", strtotime($doc->fecha_expiracion));




                $xml->startElement("Attached_document");
                //$xml->writeElement("Attached_document_code", $doc->tipodocumento);
                if ($attached_document_code == null) {
                    $xml->startElement("Attached_document_code");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_code", $attached_document_code);
                }
                //$xml->writeElement("Attached_document_name", "CERTIFICADO DE ORIGEN");///////////////////////////////////////////////////////////////////////////
                if ($attached_document_name == null) {
                    $xml->startElement("Attached_document_name");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_name", $attached_document_name);
                }

                $xml->startElement("Attached_document_from_rule");
                $xml->startElement("null");
                $xml->endElement();
                $xml->endElement(); // fin Attached_document_from_rule

                // $xml->writeElement("Attached_document_date", $doc->fecha_documento);
                if ($attached_document_date == null) {
                    $xml->startElement("Attached_document_date");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_date", $attached_document_date);
                }

                //$xml->writeElement("Temp_attached_document_item", $doc->item);
                if ($temp_attached_document_item == null) {
                    $xml->startElement("Temp_attached_document_item");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Temp_attached_document_item", $temp_attached_document_item);
                }

                if ($attached_document_reference == null) {
                    $xml->startElement("Attached_document_reference");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_reference", $attached_document_reference);
                }

                if ($attached_document_date_expiration == null) {
                    $xml->startElement("Attached_document_date_expiration");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_date_expiration", $attached_document_date_expiration);
                }



                $attached_document_country_code = null;
                if ($attached_document_country_code == null) {
                    $xml->startElement("Attached_document_country_code");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_country_code", $attached_document_country_code);
                }


                $attached_document_entity_code = null;
                if ($$attached_document_entity_code == null) {
                    $xml->startElement("Attached_document_entity_code");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_entity_code", $$attached_document_entity_code);
                }

                $attached_document_entity_name = null;
                if ($attached_document_entity_name == null) {
                    $xml->startElement("Attached_document_entity_name");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_entity_name", $attached_document_entity_name);
                }


                $attached_document_entity_other = null;
                if ($attached_document_entity_other == null) {
                    $xml->startElement("Attached_document_entity_other");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_entity_other", $attached_document_entity_other);
                }


                if ($attached_document_amount == null) {
                    $xml->startElement("Attached_document_amount");
                    $xml->writeElement("null");
                    $xml->endElement();
                } else {
                    $xml->writeElement("Attached_document_amount", $attached_document_amount);
                }



                $xml->endElement(); // fin Attached_documentss
            } //fin  foreach doc
            $xml->endElement(); // fin Attached_document

            $xml->endElement(); // fin Attached_documents
        } // fin foreach items


        $xml->startElement("Temp");
        $xml->startElement("Scanned_Documents_CDATA");

        $xml->writeCData($doc_scaneado);
        //  $xml->writeElement("Scanned_Documents_CDATA", "<![CDATA[". $doc_scaneado."]]>");
        $xml->endElement(); //fin Scanned_Documents_CDATA
        $xml->endElement(); // fin Temp


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
            $xml->startElement("Container");
            $xml->startElement("Item");
            //$xml->writeElement("Attached_document_reference", $eq->item);
            if ($attached_document_reference == null) {
                $xml->startElement("Item_Number");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Item_Number", $item_Number);
            }
            $xml->endElement(); //fin Item


            if ($equipment_type == null) {
                $xml->startElement("Equipment_type");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Equipment_type", $equipment_type);
            }

            if ($equipment_size == null) {
                $xml->startElement("Equipment_size");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Equipment_size", $equipment_size);
            }


            if ($id_equipment == null) {
                $xml->startElement("ID_equipment");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("ID_equipment", $id_equipment);
            }


            if ($container_identity == null) {
                $xml->startElement("Container_identity");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Container_identity", $container_identity);
            }

            if ($container_type == null) {
                $xml->startElement("Container_type");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Container_type", $container_type);
            }


            if ($empty_full_indicator == null) {
                $xml->startElement("Empty_full_indicator");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Empty_full_indicator", $empty_full_indicator);
            }

            $xml->writeElement("Gross_weight", "0.0");

            $xml->startElement("Package");

            if ($packages_number == null) {
                $xml->startElement("Packages_number");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Packages_number", $packages_number);
            }

            // $xml->writeElement("Packages_weight", $eq->peso_mercancias);
            if ($packages_weight == null) {
                $xml->startElement("Packages_weight");
                $xml->writeElement("null");
                $xml->endElement();
            } else {
                $xml->writeElement("Packages_weight", $packages_weight);
            }
            $xml->endElement(); // fin Package

            $xml->endElement(); // fin Package


        }


        $xml->endElement(); // fin Container

        $xml->endElement(); // fin Temp

        $xml->endElement(); //fin asycuda

        $content = $xml->outputMemory();

        // $filename = "R".$ref_duca.".xml";

        $ubicacion = sys_base("duar/public/xml");
        $filename = $ubicacion . "/" . "R" . $ref_duca . ".xml";
        //  $ubicacion .= "/" . $nombre;
        file_put_contents($filename, $content);
        echo $respuesta;
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
