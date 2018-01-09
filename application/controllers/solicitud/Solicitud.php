<?php 
class Solicitud extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
		if (login()) {    
			$modelos = array(
							'Solicitud_model',
							'Bitacora_model'
							);
			$this->user = $_SESSION['UserID'];
			$this->load->model($modelos);
		} else {
        	redirect(login_url());
        }
	}

	function index()
	{
		$slc = new Solicitud_model();

		$datos['navtext'] = "Solicitudes Recibidas";
		$datos['vista']   = 'solicitud/cuerpo';

		$pendientes = 0;
		if ($slc->verSolicitudes(array('margi' => $this->user))) {
			$pendientes = count($slc->verSolicitudes(array('margi' => $this->user)));
		}
		$datos['contar'] = $pendientes;

		$conf = new Conf_model();
		$datos['xnombre'] = $conf->dtusuario($_SESSION['UserID'])->nombre;

		$this->load->view('principal',$datos);
	}

	function act_lista(){
		$cf = new Conf_model();
		
		$res = $cf->dtusuario($this->user);
		$aforador = '';
		if ($res) {
			$aforador = $res->nombre;
		}
		$this->datos['nomuser'] = $aforador;

		$sol = new Solicitud_model();
		$this->datos['lista'] = $sol->verSolicitudes(array('margi' => $this->user));
		$this->load->view('solicitud/lista', $this->datos);
	}

	function cambiar_status() {
		if (verDato($_POST, 'status')) {
		
			$sol = new Solicitud_model();
			if ($sol->set_status($_POST)) {

				$idres = $sol->verSolicitudes($_POST);
				$bit = new Bitacora_model();
				
				if ($_POST['status'] == 2) {
					$msj = "Inicio de la creciación de la prepoliza";
				}

				if ($_POST['status'] == 3) {
					$msj = "Se ha terminado la creciación de la prepoliza";
				}

				$bit->set_bitacora_duar(
						array(
							'file' => $idres->c807_file, 
							'msj'  => $msj )
						);
				echo $idres->c807_file;
			}		
		}
	}
}
?>