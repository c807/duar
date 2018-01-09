<?php
class Principal extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$this->load->model('Principal_model');

	}

	function index(){
		echo '¡Hola!';
	}

	function crearpoliza($proceso){
		$gac = new Principal_model($proceso);


		$gac->setbitacorag();
		$gac->setsolicitud_dua();

		$msj = "Se apertura el proceso para crear la prepóliza";
		$arg = array('coment' => $msj);
		$gac->setbitacoradua($arg);


		## El correo debe enviarse al analista
		$gac->filegacela(); #Viene en formato arreglo
		$ejecutivo   = $gac->ver_ejecutivo();
		//$datorealiza = $this->Conf_model->dtusuario($_SESSION['UserID']);
		correo(); # Carga la libreria de correo

		$cuerpo = "Buen día, <br><br>";
		$cuerpo.= "Se le ha asignado el proceso de creación para la prepóliza con file # {$gac->dtfile->c807_file}";
		$cuerpo.= ", por favor de iniciarlo. <br><br>";
		$cuerpo.= "Datos del file:<br><br>";
		$cuerpo.= "<b>FILE</b>: {$gac->dtfile->c807_file}<br>";
		$cuerpo.= "<b>Vendedor</b>: {$ejecutivo->nombre} <br>";
		$cuerpo.= "<b>Fecha Creación</b>: ".formatoFecha($gac->dtfile->creacion,2)."<br><br>";
		$cuerpo.= "Saludos<br>";
		$cuerpo.= "Att: {$ejecutivo->nombre}";

		$correo = array(
				'de'     => array($ejecutivo->mail, $ejecutivo->nombre),
				'para'   => array('desarrollo2@c807.com'),
				'asunto' => "Solicitud de prepóliza para file # {$gac->dtfile->c807_file}",
				'texto'  => $cuerpo
			);
		enviarCorreo($correo,2);

		redirect('solicitud/solicitud');
	}

}
?>
