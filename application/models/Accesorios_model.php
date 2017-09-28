<?php 
class Accesorios_model extends CI_Model {
	

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
			$query = $this->db->where("cod_empresa = {$nit} or empresa = {$nit}")
							  ->get('empresa')
							  ->row();
		} else {

			$query = $this->db->get('empresa')
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
			$query = $this->db->where('codigo',$tipo)
							  ->get('tipo_bulto')
							  ->row()
							  ->descripcion;
		} else {
		
			$query = $this->db->get('tipo_bulto')
					          ->result();
		} 

		return $query;
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

}
?>