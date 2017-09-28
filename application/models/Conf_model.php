<?php
class Conf_model extends CI_Model {
	
	function datosDeproceso($proceso){
		if(!empty($proceso)) {
			$query = $this->db
						->select('a.estatus_disponible_id,file_id, master_id,a.id as proceso,b.c807_file')
						->from('gacela.file_proceso a')
						->where('a.id',$proceso)
						->join('gacela.file b','b.id = a.file_id','inner')
						->get()->row();
			return $query;
		} else {
			return false;
		}
	}

	function obetenerDatosUsuario($user){
		if(!empty($user)) {
			return $this->db
						->where('usuario',$_SESSION['UserID'])
						->get('csd.usuario')
						->row();
		} else {
			return false;
		}
	}

	function guardarBitacoragacela($datos){
		return $this->db->insert('gacela.bitacora',$datos);
	}

	function guardarSolicitud($file){
		$cliente = $this->db->where('c807_file',$file)
							->join('gacela.cliente_hijo b','b.id = a.cliente_hijo_id','inner')
							->get('gacela.file a')->row();

		$datos = array(
					'c807_file'  => $file,
					'marginador' => $_SESSION['UserID'],
					'importador' => $cliente->nombre,
					'ejecutivo'  => $cliente->usuario_id,
					'fecha'      => date('Y-m-d H:i:s'),
					'status'	 => 2
					);
		$this->db->insert('solicitud',$datos); #GUARDA LA SOLICITUD

		$datosbi = array(
					'fecha'       => date('Y-m-d'),
					'hora'        => date('H:i:s'),
					'descripcion' => 'Se inicio el proceso para crear la prepóliza',
					'c807_file'   => $file,
					'status'      => 1,
					'realizo'     => $_SESSION['UserID'] 
					);
		return $this->db->insert('bitacora',$datosbi);
	}
}
?>