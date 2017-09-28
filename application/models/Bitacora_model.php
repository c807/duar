<?php 
class Bitacora_model extends CI_Model {
	
	# 1	Solicitud
	# 2	Aceptado
	# 3	Terminado
	# 4	Comentario


	function verdatosBitacora($file){
		if (!empty($file)) {
			return $this->db->where('c807_file', $file)
							->where('eliminar', 0)
							->order_by('bitacora','desc')
							->get('bitacora')
							->result();
		} else {
			return false;
		}
	}


	function bitacora_guardar(){
		$datos = array(
				'c807_file'   => $this->input->post('inp-file'),
				'descripcion' => $this->input->post('descripcion'),
				'hora'        => date('H:i:s'),
				'fecha'       => date('Y-m-d'),
				'status'      => 4,
				'realizo'     => $_SESSION['UserID']
		);
		return $this->db->insert('bitacora',$datos);
	}

	function bitacoraeliminar($id){
		if (!empty($id)) {
			$edita = array('eliminar' => 1 );
			return $this->db->where('bitacora',$id)
							->update('bitacora',$edita);
		} else {
			return false;
		}
	}
}
?>