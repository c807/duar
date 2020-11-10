<?php defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
class ProductosController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        # $this->load->database();
        $this->load->model('productos/ProductosModel');
        # $this->load->library('session');
    }

    public function index()
    {
        die("forbidden");
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
        
        $fito=0;
        if (isset($_POST["fito"])>0) {
            $fito=1;
        }

        $id=$_POST["producimport"];
        if ($id) {
        } else {
            $codigo=$this->ProductosModel->buscar_producto($_POST["codproducto"], $_POST["paises"], $_SESSION['pais_id']);
        }
        
       
        if ($codigo==1) {
            // echo 1;
            echo "existe";
        } else {
            $data = array(

            'importador'           => trim($_POST["importador"]),

            'codproducto'          => $_POST["codproducto"],

            'descripcion'          => $_POST["descripcion"],

            'descripcion_generica' => $_POST["descripcion_generica"],

            'funcion'              => $_POST["funcion"],

            'partida'              => $_POST["partida"],

            'observaciones'        => $_POST["observaciones"],

            'nombre_proveedor'     => $_POST["proveedor"],

            'permiso'              => $permiso,

            'tlc'                  => $tlc,

            'fito'                 => $fito,

            'paisorigen'           => $_POST["paises"],

            'marca'                => $_POST["marca"],

            'pais_id'              =>  $_SESSION['pais_id'],

            'idunidad'             => $_POST["u_comercial"],
            
            'idestado'             => $_POST["estados"],

            'pais_procedencia'      => $_POST["pais_procedencia"],
            
            'pais_adquisicion'      => $_POST["pais_adquisicion"]
     
        );



            $result= $this->ProductosModel->guardar_producto($id, $data);
            if ($result>0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }
  
   
    public function cargar_desde_archivo()
    {
        $nombre=basename($_FILES["file"]["name"]);
        $ubicacion = sys_base("duar/public/fls");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }
       
        $ubicacion .= "/".$nombre;
        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);
     
        try {
            $objPHPExcel = PHPExcel_IOFactory::load($ubicacion);
            $bandera="N";
                            
            $objPHPExcel = PHPExcel_IOFactory::load($ubicacion);
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
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
                    $marca = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $fito =$worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $idunidad =$worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $idestado= $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $procedencia= $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $adquisicion= $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                  

                    $codigo=$this->ProductosModel->buscar_producto($codproducto, $origen, $_SESSION['pais_id']);
                          
                    if ($codigo==1) {
                        $data[] = array(

                          'codproducto' 	=> $codproducto ,
                          
                          'descripcion'     => $descripcion ,
          
                          'paisorigen'      => $origen
                          
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
        } catch (Exception $e) {
            die('Error loading file "'.pathinfo($ubicacion, PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        
       
        if ($bandera=="N") {
            $this->guardar();
        }
    }

    public function guardar()
    {
        $nombre=basename($_FILES["file"]["name"]);
        $ubicacion = sys_base("duar/public/fls");

        if (!file_exists($ubicacion)) {
            if (!mkdir($ubicacion, 0777, true)) {
                die('Fallo al crear las carpeta de archivos...');
            }
        }
        
        $ubicacion .= "/".$nombre;
        move_uploaded_file($_FILES['file']['tmp_name'], $ubicacion);

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($ubicacion);
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
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
                    $marca = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $fito =$worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $idunidad =$worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $idestado= $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $procedencia= $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $adquisicion= $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                   // $codproducto=trim($codproducto);

                   
                        $data[] = array(

                        'importador'		   => $importador,

                        'codproducto'		   => $codproducto,
                        
                        'descripcion'          => $descripcion,
        
                        'descripcion_generica' => $descripcion_generica,
        
                        'funcion'              => $funcion,
        
                        'partida'              => $partida,
        
                        'observaciones'        => $observaciones,
        
                        'permiso'              => $permiso,
        
                        'tlc'                  => $tlc,
        
                        'nombre_proveedor'     => $proveedor,

                        'paisorigen'           => $origen,

                        'marca'                => $marca,

                        'fito'                 => $fito,

                        'idestado'             => $idestado,

                        'idunidad'             => $idunidad,

                        'pais_id'              => $_SESSION['pais_id'],

                        'pais_procedencia'     => $procedencia,

                        'pais_adquisicion'     => $adquisicion
                        
                    );
                    
                }
            }
            $this->ProductosModel->insertar($data);
            unlink($ubicacion);
        } catch (Exception $e) {
            die('Error loading file "'.pathinfo($ubicacion, PATHINFO_BASENAME).'": '.$e->getMessage());
        }
    }

        
    public function borrar_producto()
    {
        $codigo=$_POST['txtcodigo'];
        $nombre=$_POST['txtnombre'];
        $id=$_POST['txtidproducto'];
    
        $this->ProductosModel->borrar_producto($id);
    }

    public function consulta($id)
    {
        $this->datos['productos'] =  $this->ProductosModel->consulta($id, $_SESSION['pais_id']);
                
        $this->load->view('importador/lista', $this->datos);
    }

    public function consulta_duplicados()
    {
        $this->datos['productos'] = $_SESSION['duplicados'];
        unset($_SESSION["duplicados"]);
        $this->load->view('importador/duplicados', $this->datos);
    }
}
    
    /* End of file Controllername.php */