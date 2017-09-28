<?php 
class Arancelaria_model extends CI_Model {
	protected $iddua;
	protected $deta;

	function set_iddua($iddua){
		$this->iddua = $iddua;
	}

	function set_iddetalle($det){
		$this->deta = $det;
	}

	function agregarItem(){
		$query = $this->db
						->select('(max(item)+1) as idDetalle')
						->where('duaduana',$this->iddua)
						->where('eliminar',0)
						->get('detalle')
						->row()->idDetalle;
		if($query){
			return $query;
		} else {
			return 1;
		}
	}

	function verlineadetalle() {
		if (!empty($this->deta)) {
			return $this->db->where('detalle', $this->deta)
							->where('duaduana', $this->iddua)
							->get('detalle')
							->row();
		} else {
			return false;
		}
	}

	function vertododetalle() {
		if (!empty($this->iddua)) {
			return $this->db->where('duaduana', $this->iddua)
							->where('eliminar',0)
							->get('detalle')
							->result();
		} else {
			return false;
		}
	}

	function actualizar($args) {
		if (verDato($args, 'detalle') && $this->deta) {

			$this->db->where('detalle', $this->deta)
			         ->update('detalle', $args);
			return $this->deta;

		} else {
			return false;
		}
	}

	function guardar($args) {

		if (verDato($args, 'duaduana')) {
			$this->db->insert('detalle', $args);
			return $this->db->insert_id();

		} else {
			return false;
		}
	}

	## PARA ELIMINAR Y RECALCULAR LINEA
	function eliminardetaller($id){
		if (!empty($id)) {
			$datos = array(
				'eliminar' => 1
				);

			return $this->db->where('detalle', $id)
							->update('detalle', $datos);
		}
	}

	function traeridDetalle($id){
		return $this->db->select('detalle')
						->from('detalle')
						->where('eliminar',0)
						->where('duaduana',$this->iddua)
						->get()->result();
	}

	function actualizarnumerolinea($num,$detalle){
		$datos = array('item' => $num);
		return $this->db->where('detalle',$detalle)
						->update('detalle',$datos);
	}

	## PARA MOSTRAR SUGERENCIAS

	function verdeclarante() {
		if (!empty($this->iddua)) {
			return $this->db->where('duaduana', $this->iddua)
							->get('encabezado')
							->row()->declarante;
		} else {
			return false;
		}
	}

	function traersugerencia($args) {
		if (verDato($args, 'importador') && verDato($args, 'codigo')) {
			return $this->db->where('importador', $args['importador'])
							->where('codigo_producto', $args['codigo'])
							->get('producto_empresa')
							->row();
		} else {
			return false;
		}
	}

	function guardarsugerencia($suger) {
		if (verDato($suger, 'importador') && verDato($suger, 'codigo_producto')) {

			if (!empty($suger['importador']) && !empty($suger['codigo_producto'])) {

				$args = array(
						'importador' => $suger['importador'],
						'codigo'     => $suger['codigo_producto']
						);

				$ver = $this->traersugerencia($args);
				
				if ($ver) {
					$add = $this->db->where('producto_empresa', $ver->producto_empresa)
								    ->update('producto_empresa', $suger);
				}
				else {
					$add = $this->db->insert('producto_empresa', $suger);
				}

				return $add;
			}

		} else {
			return FALSE;
		}

	}

	function sumadefob(){
		return $this->db->select('sum(fob) as total')
						->get('detalle')
						->row()->total;
	}
}
?>