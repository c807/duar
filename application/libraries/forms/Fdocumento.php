<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Fdocumento {

	protected $doc;
	protected $duar;
	protected $dtdoc;

	public function __construct(){
		$this->procs    = & get_instance();
		$this->clase    = 'form-control';
		$this->datos    = array();
		$this->labclas  = array('class' => 'col-sm-2 control-label');
	}

	public function set_tipodoc($doc){
		$this->doc = $doc;
	}

	public function set_duaduana($duar){
		$this->duar = $duar;
	}

	public function set_documento($dtdoc){
		$this->dtdoc = $dtdoc;
	}

	private function duaduana(){
		$this->datos['duaduana'] = form_input(
			array(
				'name' => 'duaduana',
				'type' => 'hidden',
				'value' => $this->duar
			)
		);
	}

	private function iddocumento(){
		$this->datos['iddoc'] = form_input(
			array(
				'name' => 'documento',
				'type' => 'hidden',
				'value' => (($this->dtdoc) ? $this->dtdoc->documento : '')
			)
		);
	}

	private function tipodoc(){
		$this->datos['lab_tipodoc'] = form_label(
			'Tipo de Documento',
			'tipdoc',
			$this->labclas
		);

		$this->datos['tipodoc'] = form_dropdown(
			array(
				'id'    => 'tipdoc',
				'name'  => 'tipodocumento',
				'class' => 'chosen'
			),
			opcionesSelect($this->doc, 'codigo', 'codigo', 'descripcion'),
			(($this->dtdoc) ? $this->dtdoc->tipodocumento : '')
		);
	}

	private function numerodoc(){
		$this->datos['lab_numerodoc'] = form_label(
			'Número de Documento',
			'numdoc',
			$this->labclas
		);

		$this->datos['numerodoc'] = form_input(
			array(
				'id'    => 'numdoc',
				'name'  => 'numero',
				'class' => $this->clase,
				'value' => (($this->dtdoc) ? $this->dtdoc->numero : '')
			)
		);
	}

	private function fechadoc(){
		$this->datos['lab_fechadoc'] = form_label(
			'Fecha de Documento',
			'fechdoc',
			$this->labclas
		);

		$this->datos['fechadoc'] = form_input(
			array(
				'id'    => 'fechdoc',
				'name'  => 'fecha',
				'class' => $this->clase,
				'type'  => 'date',
				'value' => (($this->dtdoc) ? $this->dtdoc->fecha : '')
			)
		);
	}

	public function crear(){
		$this->duaduana();
		$this->iddocumento();
		$this->tipodoc();
		$this->numerodoc();
		$this->fechadoc();
		return $this->datos;
	}

}
?>