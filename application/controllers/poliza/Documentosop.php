<?php 
class Documentosop extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
		$modelos = array('Accesorios_model','crearpoliza/Crearpoliza_model','crearpoliza/Documentosop_model','crearpoliza/Arancelaria_model');
		$this->load->model($modelos);
		$this->crear  = new Accesorios_model();
		$this->poliza = new Crearpoliza_model();
		$this->arance = new Arancelaria_model();
		$this->doc    = new Documentosop_model();
	}

	function index(){}

	function docsoporte($iddua){
		$this->arance->set_iddua($iddua);
		$pol = $this->poliza->obteneridpoliza($iddua);

		$datos['nopoliza']   = (isset($pol->duaduana)) ? $pol->duaduana : '';
		$datos['polTitulo']  = "<i class='glyphicon glyphicon-file'></i> Documentos de Soporte";
		$datos['vista']      = 'pdocumento/cuerpo';
		$datos['idDua']		 = $iddua;
		$datos['documentos'] = $this->crear->documento();
		$datos['regresar']   = base_url("index.php/poliza/crear/headerduar/{$iddua}");

		if(!empty($_GET['doc'])) {
			$datos['datosDocSP'] = $this->doc->verlinea($_GET['doc']);
		}

		$datos['listadocs'] = $this->doc->verlista($iddua);
		$datos['lista']        = 'pdocumento/lista';

		$this->load->view('principal', $datos);
	}

	function guardardoc(){
		if ($this->input->post('documento')) {

			$ver = $this->doc->actualizardoc($_POST);
		} else {
			$ver = $this->doc->guardardoc($_POST);
		}
		
		$iddua = $this->input->post('duaduana');
		redirect("poliza/documentosop/docsoporte/{$iddua}?doc={$ver}");
	}

	function eliminar($id) {
		$ver = $this->doc->eliminardoc($id);
		if ($ver) {
			return true;
		} else {
			return false;
		}

	}
}
?>