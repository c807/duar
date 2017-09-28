<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Encabezadoform {
	protected $action;
	protected $select;

	public function __construct(){
		$this->procs = & get_instance();
		$this->clase = 'form-control';
		$this->datos = array();
	}

	public function set_accion($accion){
		$this->action = $accion;
	}

	public function set_select($select){
		$this->select = $select;
	}

	private function Openform(){
		$this->datos['iniciaform'] = form_open(
			$this->action,
			array(
				'id'    => 'formencabezado'
				)
		);
	}

	private function aduanaentrada(){
		$this->datos['lab_entrada'] = form_label(
            'Aduana Entrada', 
            'inp-entrada'
        );

		$this->datos['entrada_select'] = form_dropdown(
			array(
				'id'       => 'inp-entrada', 
				'class'    => 'chosen', 
				'name'	   => 'aduana_entrada',
				'required' => 'required'
            ),
            opcionesSelect($this->select, 'aduana', 'nombre')
        );
	}

	private function Closeform(){
		$this->datos['cierraform'] = form_close();
	}

	public function mostrar(){
    	$this->Openform();
    	$this->aduanaentrada();
    	$this->Closeform();
    	return $this->datos;
    }
}
?>