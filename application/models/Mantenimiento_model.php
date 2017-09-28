<?php 
class Mantenimiento_model extends CI_Model
{
	
	function empresas ($termino='', $inicio)
	{
		if (!empty($termino)){
			$this->db->like('cod_empresa', $termino, 'after');
			$this->db->or_like('nombre', $termino, 'after');
		}

		return $this->db->limit(10, $inicio)
						->get('empresa')
						->result();
	}

	function verempresa($id)
	{
		return $this->db->where('empresa', $id)
						->get('empresa')
						->row();
	}

	function guardar($fing)
	{
		$this->db->insert('empresa', $fing);
		return $this->db->insert_id();
	}

	function actualizar($fing){
		$this->db->where('empresa', $fing['empresa'])
		         ->update('empresa', $fing);

		return $fing['empresa'];
	}	
}
?>