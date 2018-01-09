<?php 
class Bitacora_model extends CI_Model {
	
	# 1	Solicitud
	# 2	Aceptado
	# 3	Terminado
	# 4	Comentario


	function verdatosBitacora($ars){
		return $this->db->select('
							a.*,
							b.nombre ')
						->join('csd.usuario b','a.realizo = b.usuario', 'left')
						->where('c807_file', $ars['file'])
						->where('eliminar', 0)
						->order_by('bitacora','desc')
						->get('bitacora a')
						->result();
	}


	function set_bitacora_duar($ars){
		return $this->db
				->set("c807_file", $ars['file'])
				->set("descripcion", $ars['msj'])
				->set('fecha', 'curdate()', false)
				->set('hora', 'CURRENT_TIME()', false)
				->set("status", 4)
				->set("realizo",$_SESSION['UserID'])
				->insert('bitacora');
	}

	function set_bitacora_eliminar($bit){
		return $this->db->set('eliminar', 1)
						->where('bitacora', $bit)
						->delete('bitacora');
	}
}
?>