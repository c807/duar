<?php
class Detalle extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$modelos = array(
					'crearpoliza/Crearpoliza_model',
					'crearpoliza/Detalle_model'
			);

		$this->load->model($modelos);
		$this->datos = array();
	}

	function index(){}

	function duardetalle($detalle=''){
		$this->load->library("forms/Fdetalle");

		$crea = new Crearpoliza_model($_POST);
		$det  = new Detalle_model();
		$det->set_duaduana($crea->duar->duaduana);

		$fde  = new Fdetalle();
		# Setear el iddua de la duar en el input
		$fde->set_iddua($crea->duar->duaduana);

		$conf = new Conf_model();
		$fde->set_item($det->numitem());
		$fde->set_bulto($conf->tipoBulto());
		$fde->set_origen($conf->paises());
		$fde->set_action(base_url('index.php/poliza/detalle/guardar_detalle'));
		$fde->set_acuerdo($conf->acuerdo());
		$fde->set_quota($conf->quota());

		if (!empty($detalle)) {
			$fde->set_detalle($det->verlineadetalle($detalle));
			if ($det->verlineadetalle($detalle)->tlc) {
				$this->datos['aptlc'] = true;
			}
		}

		if ($crea->duar->contenedor) {
			$this->datos['contenedor'] = true;
		}

		$this->load->view('detallepoliza/cuerpo', array_merge($this->datos,$fde->mostrar()));
	}

	function guardar_detalle(){

		$det = new Detalle_model();

		$msj = "Error";
		$res = "error";
		$id  = "";

		if (verDato($_GET, 'tlc')){
			$_GET['tlc'] = 1;
		} else {
			$_GET['tlc'] = 0;
			$_GET['acuerdo'] = null;
			$_GET['quota'] = null;
		}

		$det->guardarproducto_importador($_GET);
		$rest = $det->guardardet($_GET);

		if ($rest){
			$msj = "Actualización correcta";
			$res = "success";
			$id  = $rest;
		}

		echo json_encode(
					array('msj' => $msj, 'res' => $res, 'id' => $id)
					);
	}

	function verlistadetalle() {
		$crea = new Crearpoliza_model($_POST);

		$det = new Detalle_model();
		$det->set_duaduana($crea->duar->duaduana);

		$this->datos['detallelista'] = $det->verdetalleduar();
		$this->load->view('detallepoliza/lista', $this->datos);
	}

	function prorratear($id){
		$crea = new Crearpoliza_model(array('file' => $id));

		$dt = new Detalle_model();
		$dt->set_duaduana($crea->duar->duaduana);
		$itemfob = $this->input->get('itemfob');
		
		$flete  = ($crea->duar->flete / $crea->duar->fob) * $itemfob;
		$seguro = ($crea->duar->seguro / $crea->duar->fob) * $itemfob;
		$otros  = ($crea->duar->otros / $crea->duar->fob) * $itemfob;
		$cif    = ($flete + $seguro + $otros + $itemfob);

		$datos = array(
					"flete"  => $flete,
					"seguro" => $seguro,
					"otros"  => $otros,
					"cif"    => $cif
					);
		echo json_encode($datos);
	}

	function eliminardetalle(){
		$dt = new Detalle_model();

		if (verDato($_POST, 'detalle') && verDato($_POST, 'duaduana')) {

			$dt->set_duaduana($_POST['duaduana']);
			$ar = array('detalle' => $_POST['detalle'], 'eliminar' => 1);

			if ($dt->guardardet($ar)) {
				$det = $dt->verdetalleduar();

				if ($det) {
					$a = 1;
					foreach($det as $row) {
						$dt->guardardet(array('detalle' => $row->detalle, 'item' => $a++));
					}
					$msj = 1;

				} else {
					$msj = 1;
				}

			} else {
				$msj = "No se puede eliminar, intente de nuevo";
			}

		} else {
			$msj = "Es necesario seleccionar una linea.";
		}

		echo $msj;

	}

	function buscar_producto() {
		$prod = $this->Detalle_model->getproducto($_GET);
		if ($prod) {
			echo json_encode($prod);
		}

		return false;
	}
}
?>