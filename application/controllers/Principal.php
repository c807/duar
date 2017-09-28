<?php 
class Principal extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$this->load->model('Conf_model');
		$this->gacela = new Conf_model();
	}

	function index(){ 
		echo '¡Hola!';
	}

	function crearpoliza($proceso){
		$dgacela = $this->gacela->datosDeproceso($proceso);
		$datos = array(
				'master_id'             => $dgacela->master_id,
				'file_id'               => $dgacela->file_id,
				'file_proceso_id'       => $dgacela->proceso,
				'estatus_disponible_id' => 119,
				'proceso_id'            => 1,
				'ecorreo'               => 1,
				'epara'                 => 'kelvynmagzul@stguatemala.com',
				'comentario'            => 'Se ha iniciado el proceso para crear la prepóliza',
				'fecha'                 => date('Y-m-d H:i:s'),
				'usuario_id'            => $_SESSION['UserID']
			);
		$this->gacela->guardarBitacoragacela($datos);

		## REGISTRO DE SOLICITUDES
		$this->gacela->guardarSolicitud($dgacela->c807_file);

		## El correo debe enviarse al analista 
		getcwd();
		chdir('../');
		require(getcwd() . "/enviar_correo.php");
		$cuerpo = "Buen día, <br><br>";
		$cuerpo.= "Se le a asignado el proceso de creación de prepóliza para el file ".$dgacela->c807_file;
		$cuerpo.= ", por favor de iniciarlo. <br><br>";
		$cuerpo.= "Saludos";
		
		$correo = array(
				'de'     => array('desarrollo2@c807.com','Desarrollo'),
				'para'   => array('kelvynmagzul@stguatemala.com'),
				'asunto' => 'Solicitud para iniciar proceso de prepóliza del file '.$dgacela->c807_file,
				'texto'  => $cuerpo
			);
		enviarCorreo($correo,2);

		redirect('solicitud/solicitudes/vertodos/');
	}

	/*function asignar(){
		$this->load->library('forms/Asignar');
		$asigna = new Asignar();
		$asigna->set_combo($this->Conf_model->analista());
		$asigna->set_action(base_url('index.php/principal/guardarAsigna'));
		$this->load->view('solicitud/analista',array_merge($this->datos, $asigna->mostrar()));
	}*/
}
?>
