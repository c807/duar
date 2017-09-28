<?php 
class Crearpoliza_model extends CI_Model {
	
	protected $duaid;

	function set_iddua($iddua){
		$this->duaid = $iddua;
	}

	function obteneridpoliza($id='') {
		if (!empty($id)) {
			return $this->db->where('duaduana', $id)
							->or_where('c807_file', $id)
							->get('encabezado')
							->row();
		} else {
			return false;
		}
	}

	function actualizaHead($args){
		if (verDato($args, 'duaduana')) {
			
			$this->db->where('duaduana', $this->duaid)
			 		->update('encabezado',  $args);

			return $this->duaid;
		} else {

			return false;

		}
	}

	function guardarHead($args){
		if (verDato($args, 'c807_file')) {

			$this->db->insert('encabezado', $args);
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

}
?>