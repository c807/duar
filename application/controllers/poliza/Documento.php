<?php 
class Documento extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
		$modelos = array(
						'crearpoliza/Crearpoliza_model',
						'crearpoliza/Documento_model'
						);
		$this->load->model($modelos);

	}

	function index(){}

	function documento($iddua = ''){

		$this->load->library('forms/Fdocumento');
		$crea = new Crearpoliza_model($_POST);

		$fdc = new Fdocumento();
		$fdc->set_tipodoc($this->Conf_model->tipodocumento());
		$fdc->set_duaduana($crea->duar->duaduana);

		$doc = new Documento_model();
		$fdc->set_documento($doc->verdocumento(array('documento' => $iddua)));

		$this->load->view('documentopoliza/cuerpo', $fdc->crear());
	}

	function guardar(){
		$msj = "Error, intentelo nuevamente";
		$res = "error";
		$id  = "";

		$sen = $this->Documento_model->guardar($_GET);
		if ($sen) {
			$msj = "Éxito, documento guardado";
			$res = "success";
			$id  = $sen;
		}

		enviarJson(
				array(
					'msj' => $msj, 
					'res' => $res,
					'id'  => $id
				)	
			);
	}

	function verlistadocumento(){
		$crea = new Crearpoliza_model($_POST);

		$det = new Documento_model();
		
		$this->datos['listadocs'] = 
			$det->verlistadocumento(
				array('duaduana' => $crea->duar->duaduana)
			);
			
		$this->load->view('documentopoliza/lista', $this->datos);
	}
}
?>