<?php 
class Documentosop_model extends CI_Model {

	function guardardoc($datos){
		if (verDato($datos, 'codigo_doc')) {
			$this->db->insert('documento', $datos);
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	function actualizardoc($datos){
		if (verDato($datos, 'codigo_doc') && verDato($datos, 'duaduana')) {
			$this->db->where('documento', $datos['documento'])
			         ->update('documento', $datos);

			return $datos['documento'];

		} else {
			return FALSE;
		}
	}

	function verlista($iddua = ''){
		if (!empty($iddua)) {
			return $this->db->where('eliminar',0)
							->where('duaduana', $iddua)
							->get('documento')
							->result();
		}

		return false;
	}	

	function verlinea($id=''){
		if (!empty($id)) {
			return $this->db->where('documento', $id)
							->get('documento')
							->row();
		} else {
			return false;
		}
	}

	function eliminardoc($id=''){
		if (!empty($id)) {
			$datos['eliminar'] = 1;
			return $this->db->where('documento', $id)
							->update('documento', $datos);
		} 
		return false;
	}
}
?>