<?php 
class Solicitud_model extends CI_Model {
	
	# 1	Solicitud
	# 2	Aceptado
	# 3	Terminado
	# 4	Comentario

	function verSolicitudes($ars){
		if (verDato($ars, 'id')) {
			$this->db->where('a.solicitud', $ars['id']); 
		} 

		if (verDato($ars, 'margi')) {
			$this->db->where("a.marginador", $ars['margi']);
		}

		if (VerDato($ars, 'file')) {
			$this->db->where("a.c807_file", $ars['file']);
		}

		$soli = $this->db->select("
							a.*,
							b.nombre as nomejecutivo,
							c.nombre as nomstatus
							")
						->from("solicitud a")
						->join("csd.usuario b","a.ejecutivo = b.usuario","left")
						->join("status c","a.status = c.status")
						//->where("a.status",1)
						->get();

		if (verDato($ars, 'id') || verDato($ars, 'file')) {
			return $soli->row();
		} else {
			return $soli->result();
		}
	}

	function set_status($ars){
		if (verDato($ars, 'id')) {
			return $this->db->set('status', $ars['status'])
							->where('solicitud', $ars['id'])
							->update('solicitud');
		}
		
		return FALSE;
	}

	function insertabitacora($file, $coment){
		if (!empty($file)) {
			$datos = array(
					'fecha'       => date('Y-m-d'),
					'hora'        => date('H:m:s'),
					'realizo'     => $_SESSION['UserID'],
					'status'      => 4,
					'c807_file'   => $file,
					'descripcion' => $coment
				);
				return $this->db->insert('bitacora', $datos);
		} else {
			return false;
		}
	}

	function verificarpoliza($file){
		if (!empty($file)) {
			$query = $this->db->where('c807_file', $file)
					 	      ->get('encabezado');
					 	      
			if ($query->num_rows() > 0 ){
				return true;
			} 

		} else {
			return false;
		}
	}
}
?>