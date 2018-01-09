<?php 
class Conf_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		if (isset($_SESSION['pais_id'])) {
			$this->pais = $_SESSION['pais_id'];
		} else {
			$this->pais = 0;
		}
	}

	function get_modelo($mcod){
		return $this->db->where('codigo', $mcod)
						->get('modelo')
						->row();
	}

	function dtusuario($id){
		$user = $this->db->select("
							usuario,
							nombre,
							mail
							")
						->where('usuario', $id)
						->get('csd.usuario')
						->row();
						
		return $user;
	}

	# #  Datos para mostrar en el encabezado
	function aduanas($aduana = ''){
		if (!empty($aduana)) {
			return $this->db->where('aduana', $aduana)
							->get('aduana')
							->row();	
		} else {
			return $this->db->get('aduana')
							->result();
		}
	}

	function modotransporte($modo=''){
		if (!empty($modo)) {
			return $this->db->where('codigo', $modo)
							->get('modo_transporte')
							->row();
		} else {
			return $this->db->get('modo_transporte')
							->result();
		}
	}

	function empresas($nit=''){

		if (!empty($nit)) {
			$query = $this->db->where("no_identificacion",$nit)
							  ->get('gacela.cliente_hijo')
							  ->row();
		} else {

			$query = $this->db->get('gacela.cliente_hijo')
							  ->result();
		}

		return $query;
		
	}

	function paises($pais=''){
		if (!empty($pais)) {
			$query = $this->db->where('id_pais', $pais)
							->get('pricing.pais')->row()
							->nombre;

		} else {
			$query = $this->db->get('pricing.pais')
					          ->result();
		}

		return $query;
	}

	function incoterm($inco=''){
		if (!empty($inco)) {
			return $this->db->where('codigo', $inco)
							->get('dua.incoterms')
							->row();
		} else {
			return $this->db->get('dua.incoterms')
							->result();
		}
	}

	function tipoBulto($ipo=''){
		if (!empty($tipo)) {
			return $this->db->where('codigo',$tipo)
							  ->get('tipo_bulto')
							  ->row()
							  ->descripcion;
		} else {
		
			return  $this->db->get('tipo_bulto')
					          ->result();
		} 
	}

	function documento($doc=''){
		if (!empty($doc)) {
			return $this->db->where('cod',$doc)
							->get('tipo_documento')
							->row();
		} else {
			return $this->db->get('tipo_documento')
						    ->result();
		}
	}

	function verfinalizar($file=''){
		if (! empty($file)){
			$sql = $this->db->where('c807_file', $file)
							->get('solicitud')->row();

			$return = (isset($sql->status) && $sql->status == 3) ? 1 : 0;
			
			return $return; 
		}
	}

	function regextendido(){
		return $this->db->get('reg_extendido')
				    	->result();
	}

	function regadicional(){
		return $this->db->where('')
						->get('reg_adicional')
						->result();
	}

	function acuerdo(){
		return $this->db->get('acuerdo')
						->result();
	}

	function quota(){
		return $this->db->get('quota')
						->result();
	}

	function localmercancia(){
		return $this->db->where('pais_empresa', $this->pais)
						->get('localizacion_mercancia')
						->result();
	}

	function lugardecarga(){
		return $this->db->where('pais_empresa', $this->pais)
						->get('zona_descargue')
						->result();
	}

	function presentacion(){
		return $this->db->where('pais_empresa', $this->pais)
						->get('presentacion')
						->result();
	}

	function bancos(){
		return $this->db->where('pais_empresa', $this->pais)
						->get('banco')
						->result();
	}

	function agencia($codigo){
		return $this->db->where('pais_empresa', $this->pais)
						->where('banco',$codigo)
						->get('agencia')
						->result();
	}

	function tipodocumento(){
		return $this->db->where('pais_empresa', $this->pais)
						->get('tipo_documento')
						->result();
	}
}
?>