<?php
    
    defined('BASEPATH') or exit('No direct script access allowed');
    
    class ProductosController extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->model('productos/ProductosModel');
            $this->load->library('PHPEXCEL/PHPExcel.php');
            $this->load->library('session');
        }
    
        public function index()
        {
        }

        public function crear_productos()
        {
            $tlc=0;
            if (isset($_POST["tlc"])>0) {
                $tlc=1;
            }

            $permiso=0;
            $codigo=0;
            if (isset($_POST["permiso"])>0) {
                $permiso=1;
            }
            $id=$_POST["producimport"];
            if ($id) {
            } else {
                $codigo=$this->ProductosModel->buscar_producto($_POST["codproducto"], $_POST["paises"]);
            }
            
           
            if ($codigo==1) {
                echo 1;
            } else {
                echo 0;

                $data = array(

                'importador'  => trim($_POST["importador"]),

                'codproducto'  => $_POST["codproducto"],

                'descripcion'        => $_POST["descripcion"],

                'descripcion_generica' => $_POST["descripcion_generica"],

                'funcion' => $_POST["funcion"],

                'partida' => $_POST["partida"],

                'observaciones' => $_POST["observaciones"],

                'nombre_proveedor' => $_POST["proveedor"],

                'permiso' => $permiso,

                'tlc' => $tlc,

                'paisorigen' => $_POST["paises"],

                'tipo_bulto' => $_POST["tipobulto"],

                'peso_neto' => $_POST["pesoneto"],

                'no_bultos' => $_POST["nbultos"],

                'marca' => $_POST["marca"],

                'numeros' => $_POST["numeros"]

            );

                $this->ProductosModel->guardar_producto($id, $data);
            }
        }
      
       
        public function cargar_desde_archivo()
        {
            $bandera="N";
            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row=2; $row<=$highestRow; $row++) {
                        $importador = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $codproducto = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $descripcion = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $descripcion_generica = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $funcion = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $partida = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $observaciones = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $permiso = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $tlc = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $proveedor = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $origen = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $tipo_bulto = $worksheet->getCellByColumnAndRow(11, $row)->getValue();


                        $codigo=$this->ProductosModel->buscar_producto($codproducto, $origen);
                              
                        if ($codigo==1) {
                            $data[] = array(

                              'codproducto' 	=>	$codproducto ,
                              
                              'descripcion'   =>$descripcion ,
              
                              'paisorigen' =>  $origen
                              
                          );
                            $bandera="S";
                        } else {
                        }
                    }
                }
              
                if ($bandera=='S') {
                    echo 0;
                    $_SESSION['duplicados']=$data;
                }
            }
             
           
            if ($bandera=="N") {
                $this->guardar();
            }
        }
        public function guardar()
        {
            echo 1;

            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row=2; $row<=$highestRow; $row++) {
                        $importador = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $codproducto = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $descripcion = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $descripcion_generica = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $funcion = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $partida = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $observaciones = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $permiso = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $tlc = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $proveedor = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $origen = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $tipo_bulto = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                     
                       
                        $data[] = array(

                            'importador'		=>	$importador,

                            'codproducto'			=>	$codproducto,
                            
                            'descripcion'        =>$descripcion,
            
                            'descripcion_generica' => $descripcion_generica,
            
                            'funcion' => $funcion,
            
                            'partida' => $partida,
            
                            'observaciones' => $observaciones,
            
                            'permiso' => $permiso,
            
                            'tlc' => $tlc,
            
                            'nombre_proveedor' =>  $proveedor,

                            'paisorigen' =>  $origen,

                            'tipo_bulto' =>  $tipo_bulto
                            
                        );
                    }
                }
                $this->ProductosModel->insertar($data);
            }
        }

            
        public function borrar_producto()
        {
            $codigo=$_POST['txtcodigo'];
            $nombre=$_POST['txtnombre'];
        
            $this->ProductosModel->borrar_producto($codigo);
        }

        public function consulta($id)
        {
            $this->datos['productos'] =  $this->ProductosModel->consulta($id);
                    
            $this->load->view('importador/lista', $this->datos);
        }

        public function consulta_duplicados()
        {
            $this->datos['productos'] = $_SESSION['duplicados'];
         
            $this->load->view('importador/duplicados', $this->datos);
        }
    }
    
    /* End of file Controllername.php */
