<?php
class Empresas extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$this->load->model('Mantenimiento_model');
		$this->mante = new Mantenimiento_model();
	}

	function index(){
		$datos['navbar'] = 'Empresas';
		$datos['action'] = base_url('index.php/mantenimiento/empresas/buscar');

		$this->load->view('mantenimiento', $datos);
	}

	function buscar() {
		$inicia            = (isset($_POST['inicio'])) ? $_POST['inicio'] : 0;
		$termino		   = (!empty($_POST['termino'])) ? $_POST['termino'] : null;
		$datos['lista']    = $this->mante->empresas($termino,$inicia);
		$contar = count($datos['lista']);

		if (10 == $contar) {
			$datos['cantidad'] = $contar;
		}

		$this->load->view('empresas/cuerpo',$datos);
	}

	function ver($id) {

		$datos['result'] = $this->mante->verempresa($id);
		$this->load->view('empresas/form', $datos);
	}

	function guardar(){

		if($this->input->post('empresa')) {
			$res = $this->mante->actualizar($_POST);
		} else {
			$res = $this->mante->guardar($_POST);
		}

		$datos['result'] = $this->mante->verempresa($res);

		$this->load->view('empresas/form', $datos);
	}

}
?>