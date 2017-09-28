<?php 
class Solicitudes extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
		$modelos = array('Conf_model','Solicitud_model');
		$this->load->model($modelos);
		$this->conf = new Conf_model();
		$this->soli = new Solicitud_model();
	}

	function index(){}

	function vertodos() {
		$aforador             = $this->conf->obetenerDatosUsuario($_SESSION['UserID']);
		$datos['titulo']      = 'Aforador: '.$aforador->NOMBRE;
		$datos['solicitudes'] = $this->soli->verSolicitudes();
		$datos['listaSoli']   = 'solicitud/lista_solicitudes';
		$datos['contar']      = count($this->soli->verSolicitudes(1));
		$this->load->view('solicitud/principal',$datos);
	}

	function actualizalista(){
		$datos['solicitudes'] = $this->soli->verSolicitudes();
		$this->load->view('solicitud/lista_solicitudes', $datos);
	}

	function acciones_solicitudes($id){
		switch ($this->input->post('tipo')) {

			case 2: # Status aceptado
				$datos = array('status' => 2);
				$mensaje = "Se aceptó la solicitud de prepóliza";
				break;
			case 3: # Status terminado
				$datos = array('status' => 3);
				$mensaje = "El proceso de creación de la prepóliza ha terminado";
				break;
			default:
				return false;
				break;
		}

		if(!empty($id) && !empty($datos)) {
			$this->soli->acciones_solicitudes($id,$datos);
			$this->soli->insertabitacora($this->input->post('file'),$mensaje);
		} else {

			return false;
		}
	}	

}
?>