<?php 
class Reporte_model extends CI_Model {
	
	protected $iddua;

	function set_iddua($iddua){
		$this->iddua = $iddua;
	}

	function encabezado($file = ""){
		if (!empty($file)) {
			return $this->db->where('c807_file', $file)
							->get('encabezado')
							->row();
		} else {
			return false;
		}
	}

	function detalle() {
		if (!empty($this->iddua)) {
			return $this->db->where('duaduana', $this->iddua)
							->where('eliminar', 0)
							->get('detalle')
							->result();
		} else {
			return false;
		}
	}

	function documentos() {
		if (!empty($this->iddua)) {
			return $this->db->where('duaduana',$this->iddua)
							->where('eliminar', 0)
							->get('documento')
							->result();
		} else {
			return false;
		}
	}


}
?>