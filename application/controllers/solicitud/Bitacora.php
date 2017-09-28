<?php 
class Bitacora extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$modelos = array('Bitacora_model','Conf_model');
		$this->load->model($modelos);
		$this->conf = new Conf_model();
		$this->bita = new Bitacora_model();
	}

	function index(){
	 echo '¡Hola!';		
	}

	function verbitacora($file) {
		$datos['bitacora'] = $this->bita->verdatosBitacora($file);
		$this->load->view('bitacora/lista',$datos);
	}

	function form_bitacora($file='') {

		$this->load->library('forms/Bitacoraform');
		$fobita = new Bitacoraform();

		$fobita->set_file($file);
		$fobita->set_action(base_url('index.php/solicitud/bitacora/guardar_bitacora'));
		$this->datos['file'] = $file;

		$this->load->view('bitacora/form', array_merge($this->datos, $fobita->mostrar()));
	}

	function guardar_bitacora(){

		if(!empty($this->input->post('enviar'))) {
			getcwd();
			chdir('../');
			require(getcwd() . "/enviar_correo.php");

			$correo = array(
				'de'     => array('desarrollo2@c807.com','Desarrollo'), ## aqui va el correo del analista
				'para'   => array('kelvynmagzul@stguatemala.com'), ## va correo del ejecutivo
				'asunto' => 'Comentario de prepóliza según file '.$this->input->post('inp-file'),
				'texto'  => $this->input->post('descripcion')
			);

			enviarCorreo($correo,2);
		} 
		
		if($this->bita->bitacora_guardar()){
			echo 'Se actualizó la bitácora de prepóliza del file '.$this->input->post('inp-file');
		} else {
			echo 'En este momento no se puede realizar el comentario';
		}
	}

	function eliminarbitacora($id){
		if (!is_null($id)) {

			$this->bita->bitacoraeliminar($id);
			return true;

		}  else {
			
			return false;
		}
	}
	/*
	$this->load->library('forms/Asignar');
		$asigna = new Asignar();
		$asigna->set_combo($this->Conf_model->analista());
		$asigna->set_action(base_url('index.php/principal/guardarAsigna'));
		$this->load->view('solicitud/analista',array_merge($this->datos, $asigna->mostrar()));
	*/
}
?>