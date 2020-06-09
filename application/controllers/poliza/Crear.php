<?php
class Crear extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        if (login()) {
            $modelos = array(
                        'crearpoliza/Crearpoliza_model',
                        'crearpoliza/Detalle_model'
                        );
            $this->load->model($modelos);
            $this->load->library('PHPEXCEL/PHPExcel.php');
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

    public function dowload_adjunto($pdf,$ref)
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
        $pdf = fopen( $archivo, 'w');
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
        // var_dump($dato);
        if ($dato) {
            echo json_encode($dato);
        }
    }
    /*======================================================================*/
}