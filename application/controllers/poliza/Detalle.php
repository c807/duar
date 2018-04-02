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
		$fde->set_doctransporte($crea->duar->doc_transporte);
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

		$registros = $det->verdetalleduar();
		if ($registros) {
			$fde->set_documentos($registros);
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

		$bulto  = ($crea->duar->bultos / $crea->duar->fob) * $itemfob;
		$datos = array(
					"flete"  => round($flete,2),
					"seguro" => round($seguro,2),
					"otros"  => round($otros,2),
					"cif"    => round($cif,2),
					"bulto"  => round($bulto,2)
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

	function setdescripcion_sac(){
		$dato = array();

		if (verDato($_GET, 'codigo')) {
			$cod["codigo"] = $_GET["codigo"]."00";
			$desc = $this->Detalle_model->sac_descripcion($cod);
			if ($desc) {
				$dato['descripcion'] = $desc->DESCRIPCION;
			}

			echo json_encode($dato);
		}

		return false;
	}

	function form_xls_detalle($duaduana) {
		$this->datos['accion'] = base_url("index.php/poliza/detalle/guardar_xls_detalle/{$duaduana}");
		$this->load->view("detallepoliza/form_xls", $this->datos);
	}

	function guardar_xls_detalle($duaduana) {
		$det = new Detalle_model();
		$det->set_duaduana($duaduana);

		$this->load->library('PHPExcel/PHPExcel.php');
		$exito = 0;

		$cargar    = PHPExcel_IOFactory::identify($_FILES['archivo']['tmp_name']);
		$objReader = PHPExcel_IOFactory::createReader($cargar);
		$objReader->setLoadSheetsOnly('Hoja1');

		$objPHPExcel   = $objReader->load($_FILES['archivo']['tmp_name']);
		$hoja          = $objPHPExcel->getSheet(0);
		$highestRow    = $hoja->getHighestRow();
		$highestColumn = $hoja->getHighestColumn();

		for ($row = 2; $row <= $highestRow; $row++) {
			$linea['detalle']		  = '';
			$linea['codigo_producto'] = $hoja->getCell("A".$row)->getValue();
			$linea['item']			  = $det->numitem();
			$linea["tlc"]             = ($hoja->getCell("B".$row)->getValue()) ? $hoja->getCell("B".$row)->getValue() : 0;
			$linea["acuerdo"]         = $hoja->getCell("C".$row)->getValue();
			$linea["quota"]           = $hoja->getCell("D".$row)->getValue();
			$linea["marcas"]          = $hoja->getCell("E".$row)->getValue();
			$linea["numeros"]         = $hoja->getCell("F".$row)->getValue();
			$linea["partida"]         = $hoja->getCell("G".$row)->getValue();
			$linea["doc_transp"]      = $hoja->getCell("H".$row)->getValue();
			$linea["tipo_bulto"]      = $hoja->getCell("I".$row)->getValue();
			$linea["origen"]          = $hoja->getCell("J".$row)->getValue();
			$linea["peso_bruto"]      = $hoja->getCell("K".$row)->getValue();
			$linea["peso_neto"]       = $hoja->getCell("L".$row)->getValue();
			$linea["cuantia"]         = $hoja->getCell("M".$row)->getValue();
			$linea["fob"]             = $hoja->getCell("N".$row)->getValue();
			$linea["flete"]           = $hoja->getCell("O".$row)->getValue();
			$linea["seguro"]          = $hoja->getCell("P".$row)->getValue();
			$linea["otros"]           = $hoja->getCell("Q".$row)->getValue();
			$linea["cif"]             = $hoja->getCell("R".$row)->getValue();
			$linea["no_bultos"]       = $hoja->getCell("S".$row)->getValue();
			$linea["descripcion"]     = $hoja->getCell("T".$row)->getValue();
			$linea["contenedor1"]     = $hoja->getCell("U".$row)->getValue();
			$linea["contenedor2"]     = $hoja->getCell("V".$row)->getValue();
			$linea["contenedor3"]     = $hoja->getCell("W".$row)->getValue();
			$linea["contenedor4"]     = $hoja->getCell("X".$row)->getValue();
			$linea["comple"]          = '000';
			$partida = $hoja->getCell("G".$row)->getValue()."00";
			$desc = $this->Detalle_model->sac_descripcion(array("codigo" => $partida));
			$linea["desc_sac"]        = ($desc) ? $desc->DESCRIPCION : '';
			$linea["duaduana"]        = $duaduana;

			if ($this->Detalle_model->guardardet($linea)) {
				$exito = 1;
			}
		}

		if ($exito) {
			$mensaje = "El detalle se agregó con éxito";
		} else {
			$mensaje = "No se puede agregar el detalle, intentelo nuevamente";
		}

		$dato['exito']   = $exito;
		$dato['mensaje'] = $mensaje;

		echo json_encode($dato);
	}
}
?>