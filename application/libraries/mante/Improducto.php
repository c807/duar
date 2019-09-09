<?php 
class Improducto
{
	protected $select;
	protected $producto;

	public function __construct(){
		$this->procs    = & get_instance();
		$this->clase    = 'form-control input-sm';
		$this->datos    = array();
		$this->labclas  = array('class' => 'col-sm-2 control-label');
		$this->labcla1  = array('class' => 'col-sm-1 control-label');
	}

	public function set_select($ars){
		$this->select = $ars;
	}

	public function set_dtproducto($prod) {
		$this->producto = $prod;
	}

	private function idproducto(){
		$this->datos['idprod'] = form_input(
			array(
				'name'  => 'producimport',
				'type'  => 'hidden',
				'value' => (($this->producto) ? $this->producto->producimport : '')
			)
		);
	}

	private function codigo(){
		$this->datos['lab_codigo'] = form_label(
			'Código',
			'cod',
			$this->labclas
		);

		$this->datos['codigo'] = form_input(
			array(
				'id'    => 'cod',
				'name'  => 'codproducto',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->codproducto : '')
			)
		);
	}

	private function partida(){
		$this->datos['lab_partida'] = form_label(
			'Partida',
			'partida',
			$this->labclas
		);

		$this->datos['partida'] = form_input(
			array(
				'id'    => 'partida',
				'name'  => 'partida',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->partida : '')
			)
		);
	}

	private function origen(){
		$this->datos['lab_origen'] = form_label(
			'Origen',
			'origen',
			$this->labclas
		);

		$this->datos['origen'] = form_dropdown(
			array(
				'id'    => 'origen',
				'name'  => 'paisorigen',
				'class' => 'chosen'
			),
			opcionesSelect($this->select['paises'], 'id_pais', 'id_pais', 'nombre'),
			(($this->producto) ? $this->producto->paisorigen : '')
		);
	}

	private function tipobulto(){
		$this->datos['lab_tipbulto'] = form_label(
			'Tipo Bulto',
			'tipbulto',
			$this->labclas
		);

		$this->datos['tipbulto'] = form_dropdown(
			array(
				'id'    => 'tipbulto',
				'name'  => 'tipo_bulto',
				'class' => 'chosen'
			),
			opcionesSelect($this->select['tipbul'], 'codigo', 'codigo','descripcion'),
			(($this->producto) ? $this->producto->tipo_bulto : '')
		);
	}

	private function nobulto(){
		$this->datos['lab_nobulto'] = form_label(
			'No. Bultos',
			'nobulto',
			$this->labclas
		);

		$this->datos['nobulto'] = form_input(
			array(
				'id'    => 'nobulto',
				'name'  => 'no_bultos',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->no_bultos : '')
			)
		);
	}

	private function pesoneto(){
		$this->datos['lab_pneto'] = form_label(
			'Peso Neto',
			'pneto',
			$this->labclas
		);

		$this->datos['pneto'] = form_input(
			array(
				'id'    => 'pneto',
				'name'  => 'peso_neto',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->peso_neto : '')
			)
		);
	}

	private function numeros(){
		$this->datos['lab_numeros'] = form_label(
			'Numeros',
			'num',
			$this->labclas
		);

		$this->datos['numeros'] = form_input(
			array(
				'id'    => 'num',
				'name'  => 'numeros',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->numeros : '')
			)
		);
	}

	private function marca(){
		$this->datos['lab_marca'] = form_label(
			'Marca',
			'marca',
			$this->labclas
		);

		$this->datos['marca'] = form_input(
			array(
				'id'    => 'marca',
				'name'  => 'marca',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->marca : '')
			)
		);
	}

	private function descripcion(){
		$this->datos['lab_descripcion'] = form_label(
			'Descripción',
			'descrip',
			$this->labclas
		);

		$this->datos['descripcion'] = form_textarea(
			array(
				'id'    => 'descrip',
				'name'  => 'descripcion',
				'class' => $this->clase,
				'rows'  => '3',
				'value' => (($this->producto) ? $this->producto->descripcion : '')
			)
		);
	}

	private function tlc(){
		$this->datos['tlc'] = form_checkbox(
			array(
				'id'      => 'tlc',
				'name'    => 'tlc',
				'value'   => 1,
				'checked' => (($this->producto->tlc == 1) ? TRUE : FALSE)
			)
		);
	}

	private function permiso(){
		$this->datos['permiso'] = form_checkbox(
			array(
				'id'      => 'permiso',
				'name'    => 'permiso',
				'value'   => 1,
				'checked' => (($this->producto->permiso == 1) ? TRUE : FALSE)
			)
		);
	}
	private function descripcion_generica(){
		$this->datos['lab_descripcion_generica'] = form_label(
			'Descripción Generica',
			'descripcion generica',
			$this->labclas
		);

		$this->datos['descripcion_generica'] = form_textarea(
			array(
				'id'    => 'descripcion_generica',
				'name'  => 'descripcion_generica',
				'class' => $this->clase,
				'rows'  => '3',
				'value' => (($this->producto) ? $this->producto->descripcion_generica : '')
			)
		);
	}
	private function funcion(){
		$this->datos['lab_funcion'] = form_label(
			'Función',
			'funcion',
			$this->labclas
		);

		$this->datos['funcion'] = form_textarea(
			array(
				'id'    => 'funcion',
				'name'  => 'funcion',
				'class' => $this->clase,
				'rows'  => '3',
				'value' => (($this->producto) ? $this->producto->funcion : '')
			)
		);
	}
	private function observaciones(){
		$this->datos['lab_observaciones'] = form_label(
			'Observaciones',
			'observaciones',
			$this->labclas
		);

		$this->datos['observaciones'] = form_textarea(
			array(
				'id'    => 'observaciones',
				'name'  => 'observaciones',
				'class' => $this->clase,
				'rows'  => '3',
				'value' => (($this->producto) ? $this->producto->observaciones : '')
			)
		);
	}

	private function nombre_proveedor(){
		$this->datos['lab_nombre_proveedor'] = form_label(
			'Proveedor',
			'proveedor',
			$this->labclas
		);

		$this->datos['nombre_proveedor'] = form_input(
			array(
				'id'    => 'nombre_proveedor',
				'name'  => 'nombre_proveedor',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->nombre_proveedor : '')
			)
		);
	}

	
	private function importador(){
		$this->datos['lab_importador'] = form_label(
			'Importador',
			'importador',
			$this->labclas
		);

		$this->datos['importador'] = form_input(
			array(
				'id'    => 'importador',
				'name'  => 'importador',
				'class' => $this->clase,
				'value' => (($this->producto) ? $this->producto->importador : '')
			)
		);
	}
	public function crear(){
		$this->idproducto();
		$this->codigo();
		$this->partida();
		$this->origen();
		$this->tipobulto();
		$this->nobulto();
		$this->pesoneto();
		$this->numeros();
		$this->marca();
		$this->descripcion();
		$this->tlc();
		$this->permiso();
		$this->funcion();
		$this->descripcion_generica();
		$this->observaciones();
		$this->nombre_proveedor();
		$this->importador();
		return $this->datos;
	}
}
?>