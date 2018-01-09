<?php 
class Documento_model extends CI_Model {

	function guardar($ars){
		if (verDatovalor($ars, 'documento')) {
			$this->db->where('documento', $ars['documento'])
					 ->update('documento', $ars);

			return $ars['documento'];

		} else {
			$this->db->insert('documento', $ars);
			return $this->db->insert_id();
		}
	}

	function verdocumento($ars){
		return $this->db->where('documento', $ars['documento'])
						->get('documento')
						->row();
	}

	function verlistadocumento($ars){
		return $this->db->select('a.*, b.descripcion')
						->where('duaduana', $ars['duaduana'])
						->join('tipo_documento b', 'a.tipodocumento = b.tipo_documento', 'inner')
						->get('documento a')
						->result();
	}
}
?>