<?php
class Crear extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$modelos = array('Accesorios_model','crearpoliza/Crearpoliza_model');
		$this->load->model($modelos);
		$this->crear  = new Accesorios_model();
		$this->poliza = new Crearpoliza_model();
	}
	function index(){}


	function headerduar ($id){
		$pol = $this->poliza->obteneridpoliza($id);
		
		$datos = array(
				'file'      => $id,
				'polTitulo' => '<i class="glyphicon glyphicon-th"></i> Encabezado',
				'vista'     => 'pencabezado/cuerpo'
				);

		$datos['nopoliza']   = (isset($pol->duaduana)) ? $pol->duaduana : '';
		$datos['encabezado'] = $this->poliza->obteneridpoliza($id);
		$datos['aduana']     = $this->crear->aduanas();
		$datos['modotransp'] = $this->crear->modotransporte();
		$datos['declarante'] = $this->crear->empresas();
		$datos['paises']     = $this->crear->paises();
		$datos['incoterms']  = $this->crear->incoterm();

		$this->load->view('principal', $datos);
	}

	function verempresa($codigo='') {
		# TRAE EMPRESA SEGUN NIT 
		if (!empty($codigo)) {

			$empresa = $this->crear->empresas($codigo);
			$datos   = array(
				'nombre' => $empresa->nombre,
				'id'     => $empresa->empresa
				);
		}

		echo json_encode($datos);
	}

	function guardar_encabezado(){
		$validar = '';

		if ($this->input->post('duaduana')) {
			$this->poliza->set_iddua($this->input->post('duaduana'));
			$validar = $this->poliza->actualizaHead($_POST);

		} else {
			$validar = $this->poliza->guardarHead($_POST);
		}

		redirect('poliza/crear/headerduar/'.$validar);
	}


}
?>