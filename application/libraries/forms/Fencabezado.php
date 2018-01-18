<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fencabezado {

	protected $action;
	protected $datodua;
	protected $combo;
	protected $modelo;

	public function __construct(){
		$this->procs   = & get_instance();
		$this->clase   = 'form-control';
		$this->datos   = array();
		$this->labclas = array('class' => 'col-sm-2 control-label');
	}

	public function set_accion($accion){
		$this->action = $accion;
	}

	public function set_datosheader($duar) {
		$this->datodua = $duar;
	}

	public function set_select($ars=array()){
		$this->combo = $ars;
	}

	public function set_declaracion($decla = array()) {
		$this->modelo = $decla;
	}



	private function Openform(){
		$this->datos['iniciaform'] = form_open(
			$this->action,
			array(
				'id'       => 'formdatoduabezado',
				'class'    => 'form-horizontal',
				'onsubmit' => 'enviarhead(this); return false;'
				)
		);
	}

	private function duaduana(){
		$this->datos['duaduana'] = form_input(
			array(
				'name'  => 'duaduana',
				'value' => (($this->datodua) ? $this->datodua->duaduana: ''),
				'type'  => 'hidden'
			)
		);

		$this->datos['regext'] = form_input(
			array(
				'name' => 'reg_extendido',
				'value' => (($this->datodua) ? $this->datodua->reg_extendido: $this->modelo['reg_ext']),
				'type' => 'hidden'
			)
		);

		$this->datos['regadi'] = form_input(
			array(
				'name' => 'reg_adicional',
				'value' => (($this->datodua) ? $this->datodua->reg_adicional: $this->modelo['reg_adi']),
				'type' => 'hidden'
			)
		);

		$this->datos['file'] = form_input(
			array(
				'name' => 'c807_file',
				'value' => (($this->datodua) ? $this->datodua->c807_file : $this->modelo['file']),
				'type' => 'hidden'
			)
		);
	}

	private function nit(){

		$this->datos['lab_nit'] = form_label(
			(($this->modelo['imp_exp'] == 1) ? 'Nit del Exportador':'Nit del Destinatario'),
			'nit',
			$this->labclas
		);

		$this->datos['nit'] = form_dropdown(
			array(
				'id'    => 'enit',
				'class' => 'chosen',
				'name'  => 'nit',
				'onchange' => 'empresanit(this)'
			),
			opcionesSelect($this->combo['empresas'], 'no_identificacion', 'no_identificacion','nombre'),
			(($this->datodua) ? $this->datodua->nit:'')
		);

		# Nombre del exportador o destinatario
		$this->datos['exp_det'] = form_label(
			(($this->modelo['imp_exp'] == 1) ? 'Destinatario':'Exportador'),
			'nombre',
			$this->labclas
		);

		$this->datos['nitnombre'] = form_input(
			array(
        		'id'    => 'nombre',
        		'class' => $this->clase,
        		'value' => (($this->datodua) ? $this->datodua->nombre:'')
        		)
		);

		# Dirección de empresa
		$this->datos['direccion'] = form_label(
				'Dirección',
				'direc',
				$this->labclas
		);

		$this->datos['nitdirec'] = form_input(
			array(
        		'id'    => 'direc',
        		'class' => $this->clase,
        		'value' => (($this->datodua) ? $this->datodua->direccion:'')
        		)
		);

		# ID del nit va como oculto
		$this->datos['declarante'] = form_input(
			array(
        		'id'    => 'declara',
        		'name'  => 'declarante',
        		'type'  => 'hidden',
        		'value' => (($this->datodua) ? $this->datodua->declarante:'')
        		)
		);
	}

	private function modelo() {
		$this->datos['lab_modelo'] = form_label(
			'Modelo',
			'mod',
			$this->labclas
		);

		$this->datos['modelo'] = form_input(
			array(
				'name'     => 'modelo',
				'id'       => 'modelo',
				'class'    => $this->clase,
				'readonly' => 'readonly',
				'value'    => (($this->datodua) ? $this->datodua->modelo : $this->modelo['modelo'])
			)
		);
	}

	private function aduanas(){
		# Entrada
		$this->datos['lab_aduana'] = form_label(
			(($this->modelo['imp_exp'] == 1) ? 'Aduana de Salida':'Aduana de Entrada'),
			'aduana',
			$this->labclas
		);

		$this->datos['aduana'] = form_dropdown(
			array(
				'id'    => 'aduana',
				'class' => 'chosen',
				'name'  => 'aduana_entrada_salida'
			),
			opcionesSelect($this->combo['aduanas'], 'aduana', 'codigo','nombre'),
			(($this->datodua) ? $this->datodua->aduana_entrada_salida:'')
		);
	}

	private function paises(){
		# Pais
		$this->datos['lab_pais'] = form_label(
			'Pais de Origen',
			'pais',
			$this->labclas
		);

		$this->datos['pais'] = form_dropdown(
			array(
				'id'    => 'pais',
				'class' => 'chosen',
				'name'  => 'pais_origen'
			),
			opcionesSelect($this->combo['paises'], 'id_pais', 'id_pais','nombre'),
			(($this->datodua) ? $this->datodua->pais_origen:'')
		);

		#Pais Exportación
		$this->datos['lab_paisexpor'] = form_label(
			'Pais de Exportación',
			'paisexp',
			$this->labclas
		);

		$this->datos['paisexportacion'] = form_dropdown(
			array(
				'id'    => 'paisexp',
				'class' => 'chosen',
				'name'  => 'pais_export'
			),
			opcionesSelect($this->combo['paises'], 'id_pais', 'id_pais','nombre'),
			(($this->datodua) ? $this->datodua->pais_export:'')
		);

		# Pais de procedencias
		$this->datos['lab_paisprocedencia'] = form_label(
			(($this->modelo['imp_exp'] == 1) ? 'País Primer Destino' : 'País Ultima Procedencia'),
			'paisproce',
			$this->labclas
		);

		$this->datos['paisprocedencia'] = form_dropdown(
			array(
				'id'    => 'paisproce',
				'class' => 'chosen',
				'name'  => 'pais_proc'
			),
			opcionesSelect($this->combo['paises'], 'id_pais', 'id_pais','nombre'),
			(($this->datodua) ? $this->datodua->pais_proc:'')
		);

		# Pais de destino
		$this->datos['lab_paisdestino'] = form_label(
			'Pais de Destino',
			'paisdestino',
			$this->labclas
		);

		$this->datos['paisdestino'] = form_dropdown(
			array(
				'id'    => 'paisdestino',
				'class' => 'chosen',
				'name'  => 'pais_destino'
			),
			opcionesSelect($this->combo['paises'], 'id_pais', 'id_pais','nombre'),
			(($this->datodua) ? $this->datodua->pais_destino:'')
		);

		#Pais de transporte
		$this->datos['lab_paistransporte'] = form_label(
			'Pais de Transporte',
			'paistrans',
			$this->labclas
		);

		$this->datos['paistransporte'] = form_dropdown(
			array(
				'id'    => 'paistrans',
				'name'  => 'pais_trasporte',
				'class' => 'chosen'
			),
			opcionesSelect($this->combo['paises'], 'id_pais', 'id_pais','nombre'),
			(($this->datodua) ? $this->datodua->pais_trasporte : '')
		);
	}

	private function transportista(){
		$this->datos['lab_regtrans'] = form_label(
			'Registro Transportista',
			'regtrans',
			$this->labclas
		);

		$this->datos['regtransportista'] = form_input(
			array(
				'name'     => 'registro_transportista',
				'id'       => 'regtrans',
				'class'    => $this->clase,
				'value'	   => (($this->datodua) ? $this->datodua->registro_transportista : '')
			)
		);
	}

	private function modotransporte(){
		$this->datos['lab_modotrans'] = form_label(
			'Modo de transporte',
			'modtrans',
			$this->labclas
		);

		$this->datos['modotransporte'] = form_dropdown(
			array(
				'id'    => 'modotrans',
				'class' => 'chosen',
				'name'  => 'mod_transp'
			),
			opcionesSelect($this->combo['modtrans'], 'codigo', 'codigo', 'nombre'),
			(($this->datodua) ? $this->datodua->mod_transp:'')
		);
	}

	private function lugarcarga(){
		$this->datos['lab_lugcarga'] = form_label(
			'Lugar de Carga',
			'lugcarga',
			$this->labclas
		);

		$this->datos['lugarcarga'] = form_dropdown(
			array(
				'name'  => 'lugar_carga',
				'id'    => 'lugcarga',
				'class' => 'chosen'
			),
			opcionesSelect($this->combo['lugcarga'],'codigo','codigo','descripcion'),
			(($this->datodua) ? $this->datodua->lugar_carga:'')

		);
	}

	private function localmerca(){
		$this->datos['lab_localmerca'] = form_label(
			'Localización de Mercancias',
			'localmerca',
			$this->labclas
		);

		$this->datos['localmercancia'] = form_dropdown(
			array(
				'name'  => 'localizacion_mercancia',
				'id'    => 'localmerca',
				'class' => 'chosen',
			),
			opcionesSelect($this->combo['locmerca'], 'codigo','codigo','descripcion'),
			(($this->datodua) ? $this->datodua->localizacion_mercancia:'')
		);
	}

	private function incoterm(){
		$this->datos['lab_incoterm'] = form_label(
			'Incoterms',
			'incoterm',
			$this->labclas
		);

		$this->datos['incoterms'] = form_dropdown(
			array(
				'id'    => 'incoterm',
				'class' => 'chosen',
				'name'  => 'incoterm'
			),
			opcionesSelect($this->combo['incoterm'], 'CODIGO', 'CODIGO', 'DESCRIPCION'),
			(($this->datodua) ? $this->datodua->incoterm:'')
		);
	}

	private function cantidadarticulo(){
		$this->datos['lab_cantart'] = form_label(
			'Cantidad Artículos',
			'cantarti',
			$this->labclas
		);

		$this->datos['cantidadarticulo'] = form_input(
			array(
				'name'  => 'cant_arti',
				'id'    => 'cantarti',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->cant_arti:'')
			)
		);
	}

	private function montos(){
		# FOB
		$this->datos['lab_fob'] = form_label(
			'Fob',
			'fob',
			$this->labclas
		);

		$this->datos['fob'] = form_input(
			array(
				'name'  => 'fob',
				'id'    => 'fob',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->fob:'')
			)
		);

		# FLETE
		$this->datos['lab_flete'] = form_label(
			'Flete',
			'flete',
			$this->labclas
		);

		$this->datos['flete'] = form_input(
			array(
				'name'  => 'flete',
				'id'    => 'flete',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->flete:'')
			)
		);

		# SEGURO
		$this->datos['lab_seguro'] = form_label(
			'Seguro',
			'seguro',
			$this->labclas
		);

		$this->datos['seguro'] = form_input(
			array(
				'name'  => 'seguro',
				'id'    => 'seguro',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->seguro:'')
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
				'name'  => 'otros',
				'id'    => 'otros',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->otros:'')
			)
		);
	}

	private function montodos(){
		# TASA
		$this->datos['lab_tasa'] = form_label(
			'Tasas',
			'tasa',
			$this->labclas
		);

		$this->datos['tasas'] = form_input(
			array(
				'name'  => 'tasas',
				'id'    => 'tasa',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->tasas:'')
			)
		);

		# Total Factura
		$this->datos['lab_totalfactura'] = form_label(
			'Total Factura',
			'totfac',
			$this->labclas
		);

		$this->datos['totalfactura'] = form_input(
			array(
				'name'  => 'total_facturar',
				'id'    => 'totfac',
				'type'  => 'number',
				'step'  => '0.01',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->total_facturar:'')
			)
		);
	}

	private function referencia(){
		$this->datos['lab_referencia'] = form_label(
			'Referencias',
			'referencia',
			$this->labclas
		);
		$this->datos['referencia'] = form_textarea(
			array(
				'id'   => 'referencia',
				'name' => 'referencia',
				'rows' => '3',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->referencia:'')
				)
		);
	}

	private function manifiesto(){
		$this->datos['lab_manifiesto'] = form_label(
			'Manifiesto',
			'manif',
			$this->labclas
		);

		$this->datos['manifiesto'] = form_input(
			array(
				'id' => 'manif',
				'name' => 'manifiesto',
				'class' => $this->clase,
				'value' => (($this->datodua) ? $this->datodua->manifiesto : '')
			)
		);
	}

	private function presentacion(){
		$this->datos['lab_presentacion'] = form_label(
			'Modalidad',
			'present',
			$this->labclas
		);

		$this->datos['presentacion'] = form_dropdown(
			array(
				'id' => 'present',
				'name' => 'presentacion',
				'class' => 'chosen'
			),
			opcionesSelect($this->combo['presenta'], 'codigo', 'codigo','descripcion'),
			(($this->datodua) ? $this->datodua->presentacion : '')
		);
	}

	private function banco(){
		$this->datos['lab_banco'] = form_label(
			'Banco',
			'banco',
			$this->labclas
		);

		$this->datos['banco'] = form_dropdown(
			array(
				'id'       => 'banco',
				'name'     => 'banco',
				'class'    => 'chosen',
				'onchange' => "dependencia('', this.value, 'agencia',2)"
			),
			opcionesSelect($this->combo['bancos'], 'codigo', 'codigo', 'descripcion'),
			(($this->datodua) ? $this->datodua->banco : '')
		);
	}

	private function fechapago(){
		$this->datos['lab_fechapago'] = form_label(
			'Fecha de Pago',
			'fechpago',
			$this->labclas
		);

		$this->datos['fechapago'] = form_input(
			array(
				'id'    => 'fechpago',
				'name'  => 'fechapago',
				'class' => $this->clase,
				'type'  => 'date',
				'value' => (($this->datodua) ? $this->datodua->fechapago : '')
			)
		);
	}

	private function contenedor(){
		$this->datos['contenedor'] = form_checkbox(
			array(
				'name'    => 'contenedor',
				'id'      => 'contenedor',
				'value'   => 1,
				'checked' => (($this->datodua->contenedor) ? TRUE : FALSE)
			)
		);
	}

	private function agencia(){
		$this->datos['lab_agencia'] = form_label(
			'Agencia',
			'agencia',
			$this->labclas
		);

		$this->datos['agencia'] = form_dropdown(
			array(
				'id' => 'agencia',
				'name' => 'agencia',
				'class' => 'chosen'
			),
			opcionesSelect($this->combo['agencia'], 'codigo', 'codigo', 'descripcion'),
			(($this->datodua) ? $this->datodua->agencia : '')
		);
	}

	private function bultos() {
		$this->datos['lab_bulto'] = form_label(
			'Total Bultos',
			'totbulto',
			$this->labclas
		);

		$this->datos['bulto'] = form_input(
			array(
				'id' => 'totbulto',
				'name' => 'bultos',
				'class' => $this->clase,
				'type' => 'number',
				'steep' => '0.01',
				'value' => (($this->datodua) ? $this->datodua->bultos : '')
			)
		);
	}
	private function Closeform(){
		$this->datos['cierraform'] = form_close();
	}

	public function mostrar(){
    	$this->Openform();
    	$this->duaduana();
    	$this->nit();
    	$this->modelo();
    	$this->aduanas();
    	$this->paises();
    	$this->transportista();
    	$this->modotransporte();
    	$this->lugarcarga();
    	$this->localmerca();
    	$this->incoterm();
    	$this->cantidadarticulo();
    	$this->montos();
    	$this->montodos();
    	$this->referencia();
    	$this->manifiesto();
    	$this->presentacion();
    	$this->banco();
    	$this->fechapago();
    	$this->contenedor();
    	$this->bultos();
    	$this->Closeform();
    	$this->agencia();
    	return $this->datos;
    }
}
?>