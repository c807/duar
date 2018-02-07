<?php
class Crear extends CI_Controller {

	function __construct() {
		parent:: __construct();
		if (login()) {
			$modelos = array(
						'crearpoliza/Crearpoliza_model'
						);
			$this->load->model($modelos);
		} else {
        	redirect(login_url());
        }
	}

	function index(){}

	function declaracion($file) {
		$cre = new Crearpoliza_model(array('file' => $file));

		$this->datos['navtext'] = "Póliza File # {$file}";
		$this->datos['modelos'] = $cre->modelos();

		$existef  = 0;
		$duaduana = 0;
		$iddua    = 0;
		$xfile    = $file;
		if ($cre->duar) {
			$existef = 1;
			$xfile   = $cre->duar->c807_file;
			$iddua   = $cre->duar->duaduana;
		}

		$this->datos['vermod']   = $existef;
		$this->datos['file']     = $xfile;
		$this->datos['duaduana'] = $iddua;
		$this->datos['vista']    = "encabezadopoliza/contenido";
		$this->datos['soli']	 = true;
		$conf = new Conf_model();

		$this->datos['xnombre'] = $conf->dtusuario($_SESSION['UserID'])->nombre;

		$this->load->view("principal", $this->datos);
	}

	#Para ver listas dependientes
	function dependencias(){

		switch ($_GET['lista']) {
			case 1:
				echo json_encode($this->Crearpoliza_model->ver_regimenes($_GET));
				break;
			case 2:
				echo json_encode($this->Conf_model->agencia($_GET['codigo']));
				break;
			default:
				return false;
				break;
		}
	}

	function encabezado(){
		$reg = new Crearpoliza_model($_POST);
		$conf = new Conf_model();

		$this->load->library('forms/Fencabezado');
		$form = new Fencabezado();
		$form->set_accion(base_url('index.php/poliza/crear/guardar'));
		if ($reg->duar) {
			$form->set_datosheader($reg->duar);
			$agencia = $conf->agencia($reg->duar->banco);
		}

		if (verDato($_POST, 'reg_ext') && verDato($_POST, 'modelo')) {
			$mod  = $this->Conf_model->get_modelo($_POST['modelo']);
			$xdec = array('imp_exp' => $mod->imp_exp);

			$form->set_declaracion(array_merge($xdec,$_POST));
		}
		# Para iniciar los catalogos
		$form->set_select(
			array(
				'empresas' => $conf->empresas(),
				'aduanas'  => $conf->aduanas(),
				'modtrans' => $conf->modotransporte(),
				'incoterm' => $conf->incoterm(),
				'lugcarga' => $conf->lugardecarga(),
				'locmerca' => $conf->localmercancia(),
				'presenta' => $conf->presentacion(),
				'bancos'   => $conf->bancos(),
				'paises'   => $conf->paises(),
				'agentes'  => $conf->agentes(),
				'agencia'  => $agencia
				)
			);

		$this->load->view('encabezadopoliza/cuerpo', $form->mostrar());
	}

	function guardar(){
		$crear = new Crearpoliza_model();
		$msj   = "No se puede realizar la acción";
		$res   = "error";

		if (verDato($_GET, 'contenedor')){
				$_GET['contenedor'] = 1;
			} else {
				$_GET['contenedor'] = 0;
			}

		if ($crear->guardarhead($_GET)) {
			$msj = "Proceso realizado exitosamente";
			$res = "success";
		}

		echo json_encode(
				array(
					'msj' => $msj,
					'res' => $res
					)
			);
	}

	function empresanit(){
		if (verDato($_GET, 'nit')) {
			$cre = new Crearpoliza_model();

			echo json_encode($cre->nitempresa($_GET));
		}
	}

}
?>