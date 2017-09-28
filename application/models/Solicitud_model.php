<?php 
class Solicitud_model extends CI_Model {
	
# 1	Solicitud
# 2	Aceptado
# 3	Terminado
# 4	Comentario

	function verSolicitudes($ver=''){
		if (isset($_SESSION['UserID'])) {
			if (!empty($ver)) {
				$this->db->where('b.status', 2);
			}

			return $this->db->where('marginador',$_SESSION['UserID'])
							->join('status b','b.status = a.status','inner')
							//->order_by('a.status','asc')
							->get('solicitud a')
							->result();
		}
	}


	function acciones_solicitudes($id,$datos){
		if (!empty($id)) {
			return $this->db->where('solicitud', $id)
							->update('solicitud', $datos);
		} else {
			return false;
		}

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