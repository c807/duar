<?php
class Solicitud extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();

		if (login()) {
			$this->user = $_SESSION['UserID'];
			$this->load->model(array(
				'Solicitud_model',
				'Bitacora_model'
			));
		} else {
        	redirect(login_url());
        }
	}

	public function index()
	{
		$datos['navtext'] = "Solicitudes Recibidas";
		$datos['vista']   = 'solicitud/cuerpo';

		$solicitudes = $this->Solicitud_model->verSolicitudes();

		$pendientes = 0;
		if ($solicitudes) {
			$pendientes = count($solicitudes);
		}

		$datos['contar'] = $pendientes;

		$conf = new Conf_model();
		$datos['xnombre'] = $conf->dtusuario($_SESSION['UserID'])->nombre;

		$ejecutivos = array(); 
		if ($solicitudes) {
			foreach ($solicitudes as $key => $value) {
				$ejecutivos[$value->marginador] = array(
					'usuario' => $value->marginador,
					'nombre' => $value->nommarginador
				);
			}
		}

		$datos['ejecutivos'] = $ejecutivos;

		$this->load->view('principal',$datos);
	}

	public function act_lista()
	{
		$detalle = $this->Solicitud_model->verSolicitudes($_REQUEST);
		$this->datos['lista'] = $detalle;
		$this->datos['total'] = count($detalle);
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

				if ($_POST['status'] == 5) {
					$msj = "Se anulo la poliza del file {$idres->c807_file}";
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