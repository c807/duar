<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fdetalle {
	protected $action;
	protected $bult;
	protected $ori;
	protected $deta;
	protected $item;

	public function __construct(){
		$this->procs    = & get_instance();
		$this->clase    = 'form-control';
		$this->datos    = array();
		$this->labclas  = array('class' => 'col-sm-2 control-label');
	}

	public function set_action($acc){
		$this->action = $acc;
	}

	public function set_iddua($iddua){
		$this->iddua = $iddua;
	}

	public function set_bulto($bult){
		$this->bult = $bult;
	}

	public function set_origen($ori){
		$this->ori = $ori;
	}

	public function set_detalle($det) {
		$this->deta = $det;
	}

	public function set_item($it){
		$this->item = $it;
	}

	public function set_acuerdo($acu) {
		$this->acuerdo = $acu;
	}

	public function set_quota($quo){
		$this->quota = $quo;
	}

	private function Openform(){
		$this->datos['iniciaform'] = form_open(
			$this->action,
			array(
				'id'       => 'formdetalle',
				'class'    => 'form-horizontal',
				'onsubmit' => 'enviardetalle(this); return false;'
				)
		);

		$this->datos['iddua'] = form_input(
			array(
				'value' =>  $this->iddua,
				'type'  => 'hidden',
				'name'  => 'duaduana'
			)
		);

		$this->datos['detallelinea'] = form_input(
			array(
				'value' => (($this->deta) ? $this->deta->detalle : ''),
				'type'  => 'hidden',
				'name'  => 'detalle'
			)
		);
	}

	private function item(){
		$this->datos['lab_item'] = form_label(
			'Item',
			'item',
			$this->labclas
		);

		$this->datos['item'] = form_input(
			array(
				'id'       => 'item',
				'name'     => 'item',
				'readonly' => 'readonly',
				'class'    => $this->clase,
				'value'    => (($this->deta) ? $this->deta->item : $this->item)
			)
		);
	}

	private function tlc(){
		$this->datos['tlc'] = form_checkbox(
			array(
				'name'    => 'tlc',
				'id'      => 'tlc',
				'value'   => 1,
				'onclick' => 'aplicatlc()',
				'checked' => (($this->deta && $this->deta->tlc == 1) ? TRUE : FALSE)
			)
		);
		# Acuerdo
		$this->datos['lab_acuerdo'] = form_label(
			'Acuerdo',
			'acuerdo',
			$this->labclas
		);

		$this->datos['acuerdo'] = form_dropdown(
			array(
				'id'    => 'acuerdo',
				'name'  => 'acuerdo',
				'class' => 'chosen'
			),
			opcionesSelect($this->acuerdo, 'codigo', 'codigo','descripcion'),
			(($this->deta) ? $this->deta->acuerdo : '')
		);

		# Quota
		$this->datos['lab_quota'] = form_label(
			'Quota',
			'quota',
			$this->labclas
		);

		$this->datos['quota'] = form_dropdown(
			array(
				'id'    => 'quota',
				'name'  => 'quota',
				'class' => 'chosen'
			),
			opcionesSelect($this->quota, 'codigo', 'codigo','descripcion'),
			(($this->deta) ? $this->deta->quota : '')
		);
	}

	private function producto(){
		# Codigo producto
		$this->datos['lab_codigoprod'] = form_label(
			'Código Producto',
			'codpro',
			$this->labclas
		);

		$this->datos['codigopro'] = form_input(
			array(
				'id'     => 'codpro',
				'name'   => 'codigo_producto',
				'class'  => $this->clase,
				'onblur' => 'verproducto(this)',
				'value'  => (($this->deta) ? $this->deta->codigo_producto : '')
			)
		);

		# Marcas
		$this->datos['lab_marca'] = form_label(
			'Marca',
			'marca',
			$this->labclas
		);

		$this->datos['marca'] = form_input(
			array(
				'id'    => 'marca',
				'name'  => 'marcas',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->marcas : '')
			)
		);

		# Números
		$this->datos['lab_numeros'] = form_label(
			'Numeros',
			'numero',
			$this->labclas
		);

		$this->datos['numero'] = form_input(
			array(
				'id'    => 'numero',
				'name'  => 'numeros',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->numeros : '')
			)
		);

		# Partida
		$this->datos['lab_partida'] = form_label(
			'Partida',
			'part',
			$this->labclas
		);

		$this->datos['partida'] = form_input(
			array(
				'id'    => 'part',
				'name'  => 'partida',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->partida : '')
			)
		);

		# Descripción SAC
		$this->datos['lab_sac'] = form_label(
			'Descripción SAC',
			'sac',
			$this->labclas
		);

		$this->datos['sac'] = form_input(
			array(
				'id'    => 'sac',
				'name'  => 'desc_sac',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->desc_sac : '')
			)
		);

		# Comple
		$this->datos['lab_comple'] = form_label(
			'Complemento',
			'comple',
			$this->labclas
		);

		$this->datos['comple'] = form_input(
			array(
				'id'    => 'comple',
				'name'  => 'comple',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->comple : '')
			)
		);

		# Numero de bultos
		$this->datos['lab_numbulto'] = form_label(
			'Número de Bultos',
			'bulto',
			$this->labclas
		);

		$this->datos['bulto'] = form_input(
			array(
				'id'    => 'bulto',
				'name'  => 'no_bultos',
				'class' => $this->clase,
				'type'  => 'number',
				'step'  => '0.01',
				'value' => (($this->deta) ? $this->deta->no_bultos : '')
			)
		);
	}

	private function tipobulto() {
		$this->datos['lab_tipobulto'] = form_label(
			'Tipo de Bulto',
			'tipbulto',
			$this->labclas
		);

		$this->datos['tipobulto'] = form_dropdown(
			array(
				'id'    => 'tipbulto',
				'class' => 'chosen',
				'name'  => 'tipo_bulto'
			),
			opcionesSelect($this->bult, 'codigo', 'codigo','descripcion'),
			(($this->deta) ? $this->deta->tipo_bulto : '')
		);

		# ORIGEN
		$this->datos['lab_origen'] = form_label(
			'País de Origen',
			'origen',
			$this->labclas
		);

		$this->datos['origen'] = form_dropdown(
			array(
				'id'    => 'origen',
				'class' => 'chosen',
				'name'  => 'origen'
			),
			opcionesSelect($this->ori, 'id_pais', 'id_pais','nombre'),
			(($this->deta) ? $this->deta->origen : '')
		);


	}

	private function pesos(){
		# PESO BRUTO
		$this->datos['lab_pesobruto'] = form_label(
			'Peso Bruto',
			'pesobruto',
			$this->labclas
		);

		$this->datos['pesobruto'] = form_input(
			array(
				'id'    => 'pesobruto',
				'name'  => 'peso_bruto',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->peso_bruto : '')
			)
		);

		# PESO NETO
		$this->datos['lab_pesoneto'] = form_label(
			'Peso Neto',
			'pesoneto',
			$this->labclas
		);

		$this->datos['pesoneto'] = form_input(
			array(
				'id'    => 'pesoneto',
				'name'  => 'peso_neto',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->peso_neto : '')
			)
		);
	}

	private function transporte(){
		# CUANTIA
		$this->datos['lab_cuantia'] = form_label(
			'Cuantia',
			'cuanti',
			$this->labclas
		);

		$this->datos['cuantia'] = form_input(
			array(
				'id'    => 'cuanti',
				'name'  => 'cuantia',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->cuantia : '')
			)
		);

		# documento Transporte
		$this->datos['lab_doctrans'] = form_label(
			'Documento Transporte',
			'doctran',
			$this->labclas
		);

		$this->datos['doctrans'] = form_input(
			array(
				'id'    => 'doctran',
				'name'  => 'doc_transp',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->doc_transp : '')
			)
		);
	}

	private function montos(){
		#FOB
		$this->datos['lab_fob'] = form_label(
			'Fob',
			'fob',
			$this->labclas
		);

		$this->datos['fob'] = form_input(
			array(
				'id'    => 'fob',
				'name'  => 'fob',
				'onblur' => 'prorrateo(this)',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->fob : '')
			)
		);

		#FLETE
		$this->datos['lab_flete'] = form_label(
			'Flete',
			'flete',
			$this->labclas
		);

		$this->datos['flete'] = form_input(
			array(
				'id'    => 'flete',
				'name'  => 'flete',
				'readonly' => 'readonly',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->flete : '')
			)
		);

		# Seguro
		$this->datos['lab_seguro'] = form_label(
			'Seguro',
			'seguro',
			$this->labclas
		);

		$this->datos['seguro'] = form_input(
			array(
				'id'    => 'seguro',
				'name'  => 'seguro',
				'readonly' => 'readonly',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->seguro : '')
			)
		);

		# OTROS
		$this->datos['lab_otros'] = form_label(
			'Otros',
			'otros',
			$this->labclas
		);

		$this->datos['otros'] = form_input(
			array(
				'id'    => 'otros',
				'name'  => 'otros',
				'readonly' => 'readonly',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->otros : '')
			)
		);

		#CIF
		$this->datos['lab_cif'] = form_label(
			'Cif',
			'cif',
			$this->labclas
		);

		$this->datos['cif'] = form_input(
			array(
				'id'    => 'cif',
				'readonly' => 'readonly',
				'name'  => 'cif',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->cif : '')
			)
		);
	}

	private function contenedores(){
		$this->datos['lab_contenedor1'] = form_label(
			'Contenedor 1',
			'contenedor1',
			$this->labclas
		);

		$this->datos['contenedor1'] = form_input(
			array(
				'id'    => 'contenedor1',
				'name'  => 'contenedor1',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->contenedor1 : '')
			)
		);

		$this->datos['lab_contenedor2'] = form_label(
			'Contenedor 2',
			'contenedor2',
			$this->labclas
		);

		$this->datos['contenedor2'] = form_input(
			array(
				'id'    => 'contenedor2',
				'name'  => 'contenedor2',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->contenedor2 : '')
			)
		);

		$this->datos['lab_contenedor3'] = form_label(
			'Contenedor 3',
			'contenedor3',
			$this->labclas
		);

		$this->datos['contenedor3'] = form_input(
			array(
				'id'    => 'contenedor3',
				'name'  => 'contenedor3',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->contenedor3 : '')
			)
		);

		$this->datos['lab_contenedor4'] = form_label(
			'Contenedor 4',
			'contenedor4',
			$this->labclas
		);

		$this->datos['contenedor4'] = form_input(
			array(
				'id'    => 'contenedor4',
				'name'  => 'contenedor4',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->contenedor4 : '')
			)
		);
	}

	private function descripcion(){
		$this->datos['lab_descripcion'] = form_label(
			'Descripción',
			'descri',
			$this->labclas
		);

		$this->datos['descripcion'] = form_textarea(
			array(
				'id'    => 'descri',
				'name'  => 'descripcion',
				'rows'  => '3',
				'class' => $this->clase,
				'value' => (($this->deta) ? $this->deta->descripcion : '')
			)
		);
	}

	private function Closeform(){
		$this->datos['cierraform'] = form_close();
	}

	public function mostrar(){
		$this->Openform();
		$this->item();
		$this->tlc();
		$this->producto();
		$this->tipobulto();
		$this->pesos();
		$this->transporte();
		$this->montos();
		$this->contenedores();
		$this->descripcion();
		$this->Closeform();
		return $this->datos;
	}

}
?>