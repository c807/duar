<?php 
class Importador extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model("Importador_model");
	}

	function index(){}

	function productos() {
		$this->datos['navtext']   = "Producto Importador";
		$this->datos['vista']     = "importador/contenido";
		$this->datos['form']      = "importador/form";
		$this->datos['action']    = base_url('index.php/mante/importador/buscar');

		$this->datos['productos'] = $this->Importador_model->verproductos(array('inicio' => 0));

		$contar = count($this->datos['productos']);
		if (10 == $contar) {
			$this->datos['cantidad'] = $contar;
		}

		$this->load->view("principal", $this->datos);
	}

	function buscar(){
		$this->datos['productos'] =  $this->Importador_model->verproductos($_POST);
		$contar = count($this->datos['productos']);
		if (10 == $contar) {
			$this->datos['cantidad'] = $contar;
		}
		$this->datos['aumenta'] = $_POST['inicio'] + 1;
		$this->load->view('importador/lista', $this->datos);
	}

	function formeditar($id){
		$this->load->library('mante/Improducto');

		$imp = new Improducto();
		$imp->set_select(
					array(
						'paises' => $this->Conf_model->paises(),
						'tipbul' => $this->Conf_model->tipoBulto()
					)
				);

		$imp->set_dtproducto($this->Importador_model->verlineaproducto(array('prodimpor' => $id)));
		$this->datos['informacion'] = $this->Importador_model->verlineaproducto(array('prodimpor' => $id));
		$this->datos['action'] = base_url('index.php/mante/importador/guardar');

		$this->load->view('importador/editar', array_merge($this->datos, $imp->crear()));
	}

	function guardar() {

		if (verDato($_GET, 'producimport')) {
			if (verDato($_GET, 'tlc')){
				$_GET['tlc'] = 1;
			} else {
				$_GET['tlc'] = 0;
			}
			if ($this->Importador_model->guardardatos($_GET)) {
				$res = array('msj' => "Actualización de datos correcto", 'res' => $_GET['producimport']);
			} else {
				$res = $this->Importador_model->get_mensaje();
			}
		}

		enviarJson($res);
	}
}
?>