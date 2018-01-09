<?php 
class Bitacora extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if (login()) {
			$modelos = array(
							'Bitacora_model',
							'Conf_model',
							'Solicitud_model');
			$this->load->model($modelos);
			$this->conf = new Conf_model();
		} else {
        	redirect(login_url());
        }
	}

	function index(){
	 echo '¡Hola!';		
	}

	function verbitacora() {
		if (verDato($_POST, 'file')) {
			$bita = new Bitacora_model();
			$result = $bita->verdatosBitacora($_POST);
		}
		$datos['bitacora'] = $result;
		$this->load->view('bitacora/lista',$datos);
	}

	function form_bitacora() {
		$file = $_POST['file'];

		$this->datos['accion'] = base_url('index.php/bitacora/bitacora/guardar_bitacora');
		$this->datos['file']   = $file;

		$this->load->view('bitacora/form', $this->datos);
	}

	function guardar_bitacora(){

		if(verDato($_POST, 'enviar')) {
			correo();
			$us = new Conf_model();
			$analista = $us->dtusuario($_SESSION['UserID']);
			
			$sol = new Solicitud_model();
			$dtsol = $sol->verSolicitudes($_POST);
			
			$eje = $us->dtusuario($dtsol->ejecutivo);

			$mensaje = "Buen día, <br><br> Por este medio se le notifica que se ha realizado ";
			$mensaje.= "el siguiente comentario:<br><br>";
			$mensaje.= $this->input->post('msj');
			$mensaje.= "<br><br> Att: {$analista->nombre}";
			$mensaje.= "<br>Saludos";

			$correo = array(
				'de'     => array($analista->mail,$analista->nombre), 
				'para'   => array('kelvynmagzul@stguatemala.com'), ## va correo del ejecutivo -> array($eje->mail)
				'asunto' => 'Prepóliza file # '.$_POST['file'],
				'texto'  => $mensaje
			);

			enviarCorreo($correo,2);
		} 
		
		$bita = new Bitacora_model();

		$msj = "Error, vuelva a intentarlo";
		if($bita->set_bitacora_duar($_POST)){
			$msj = 'Actualización exitosa';
		}

		echo $msj;
	}

	function eliminarbitacora($bit){
		$bita = new Bitacora_model();
		
		if ($bita->set_bitacora_eliminar($bit)) {
			echo "Se eliminó un registro de bitacora file";
		} 

		return false;
	}
}
?>