<?php
class Arancelaria extends CI_Controller {
	
	function __construct() {
		parent:: __construct();
		$modelos = array('Accesorios_model','crearpoliza/Crearpoliza_model','crearpoliza/Arancelaria_model');
		$this->load->model($modelos);
		$this->crear  = new Accesorios_model();
		$this->poliza = new Crearpoliza_model();
		$this->arance = new Arancelaria_model();
	}

	function index(){}

	function detalle($iddua){
		$this->arance->set_iddua($iddua);
		$pol = $this->poliza->obteneridpoliza($iddua);

		$datos['nopoliza']   = (isset($pol->duaduana)) ? $pol->duaduana : '';
		$datos['polTitulo']  = "<i class='glyphicon glyphicon-list-alt'></i> Detalle";
		$datos['vista']      = 'pdetalle/cuerpo';
		$datos['idDua']		 = $iddua;
		$datos['paises']     = $this->crear->paises();
		$datos['tipoBulto']  = $this->crear->tipoBulto();
		$datos['regresar']   = base_url("index.php/poliza/crear/headerduar/{$iddua}");

		if (isset($_GET['linea'])) {
			$this->arance->set_iddetalle($_GET['linea']);
			$datos['datosdetalle'] = $this->arance->verlineadetalle();
		}

		$datos['lista']        = 'pdetalle/lista';
		$datos['detallelista'] = $this->arance->vertododetalle();

 		$this->load->view('principal', $datos);
	}


	function guardardetalle(){
		if ($this->input->post('detalle')){

			$this->arance->set_iddetalle($this->input->post('detalle'));
			$obtiene = $this->arance->actualizar($_POST);

		} else {
			$obtiene = $this->arance->guardar($_POST);
		}

		$iddua = $this->input->post('duaduana');

		if (!empty($iddua)) {
			$this->guardarsugerencia($iddua);
		}

		redirect("poliza/arancelaria/detalle/{$iddua}?linea=".$obtiene);	
	}


	function guardarsugerencia($iddua){
		$this->arance->set_iddua($iddua);

		$ver   = $this->arance->verdeclarante();
		$suger = array(
			'importador'      => $ver,
			'codigo_producto' => $this->input->post('codigo_producto'),
			'marcas'          => $this->input->post('marcas'),
			'numeros'         => $this->input->post('numeros'),
			'partida'         => $this->input->post('partida'),
			'comple'          => $this->input->post('comple'),
			'no_bultos'       => $this->input->post('no_bultos'),
			'origen'          => $this->input->post('origen'),
			'tipo_bulto'      => $this->input->post('tipo_bulto'),
			'cuantia'         => $this->input->post('cuantia'),
			'peso_neto'       => $this->input->post('peso_neto'),
			'descripcion'     => $this->input->post('descripcion')
			);

		$this->arance->guardarsugerencia($suger);
	}

	function eliminardetalle($iddua) {

		if (!empty($iddua) && !empty($this->input->post('linea'))) {

			$this->arance->set_iddua($iddua);
			$this->arance->eliminardetaller($this->input->post('linea'));
			$lineas = $this->arance->traeridDetalle();
			$a      = 1;
			foreach ($lineas as $row){
				$this->arance-> actualizarnumerolinea($a++, $row->detalle);
			}
		}
	}

	function buscar_sugerencia($iddua){
		$this->arance->set_iddua($iddua);
		$ver   = $this->arance->verdeclarante();

		$datos = array(
				'importador' => $ver,
				'codigo'     => $_GET['codigo']
				);

		$result = $this->arance->traersugerencia($datos);

		echo json_encode($result);
	}

	function prorrateo(){

		$iddua = $this->input->get('iddua');
		$poliza = $this->poliza->obteneridpoliza($iddua);
		if ($poliza) {

			$cantidad = $this->input->get('cantidad');
			$fob      = $poliza->fob;
			$flete    = $poliza->flete;
			$seguro   = $poliza->seguro;
			$otros    = $poliza->otros;
			
			$totalflete  = ($flete / $fob) * $cantidad;
			$totalseguro = ($seguro / $fob) * $cantidad;
			$totalotros  = ($otros / $fob) * $cantidad;

			$suma = $this->arance->sumadefob();
			$error = ($suma >= $fob) ? 1 : 0;

		}

		$result = array(
					'error'  => $error,
					'flete'  => $totalflete,
					'seguro' => $totalseguro,
					'otros'  => $totalotros
					);

		echo json_encode($result);
	}

}
?>