<?php
class Importador extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model("Importador_model");
      //  ini_set('display_errors', 1);
      //  ini_set('display_startup_errors', 1);
       // error_reporting(E_ALL);
    }

    public function index()
    {
    }

    public function productos()
    {
        $this->datos['navtext']   = "Producto Importador";
        $this->datos['vista']     = "importador/contenido";
        $this->datos['form']      = "importador/form";
        $this->datos['action']    = base_url('index.php/mantenimiento/importador/buscar');
        $this->datos['paises'] = $this->Conf_model->paises();
        $this->datos['estados'] = $this->Conf_model->estados();
        $this->datos['u_comercial'] = $this->Conf_model->u_comercial();
        $this->datos['importador'] = $this->Conf_model->empresas();
        $this->datos['tipobulto'] = $this->Conf_model->tipoBulto();
        $this->datos['catalogopermisos'] = $this->Conf_model->catalogo_permisos();
       // var_dump(  $this->datos['catalogopermisos']);
       $this->load->view("principal", $this->datos);
    }

    public function buscar()
    {
        
        $this->datos['productos'] =  $this->Importador_model->verproductos($_POST, $_SESSION['pais_id']);
      
        $this->load->view('importador/lista', $this->datos);
    }

    public function formeditar($id)
    {
        $this->load->library('mante/Improducto');

        $imp = new Improducto();
        $imp->set_select(
            array(
                    'paises' => $this->Conf_model->paises(),
                    'tipbul' => $this->Conf_model->tipoBulto()
                 )
        );

        $imp->set_dtproducto($this->Importador_model->verlineaproducto(array('prodimpor' => $id)));
        $this->datos['informacion'] = $this->Importador_model->verlineaproducto(array('prodimpor' => $id));
        $this->datos['action'] = base_url('index.php/mantenimiento/importador/guardar');

        $this->load->view('importador/editar', array_merge($this->datos, $imp->crear()));
    }

    public function guardar()
    {
        if (verDato($_GET, 'producimport')) {
            if (verDato($_GET, 'tlc')) {
                $_GET['tlc'] = 1;
            } else {
                $_GET['tlc'] = 0;
            }

            if (verDato($_GET, 'permiso')) {
                $_GET['permiso'] = 1;
            } else {
                $_GET['permiso'] = 0;
            }
            if (verDato($_GET, 'fito')) {
                $_GET['fito'] = 1;
            } else {
                $_GET['fito'] = 0;
            }
            $_GET['pais_id'] =  $_SESSION['pais_id'];
            if ($this->Importador_model->guardardatos($_GET, $_SESSION['pais_id'])) {
                $res = array('msj' => "Actualización de datos correcto", 'res' => $_GET['producimport']);
            } else {
                $res = $this->Importador_model->get_mensaje();
            }
        }

        enviarJson($res);
    }

  
}
