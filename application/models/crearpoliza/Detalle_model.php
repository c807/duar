<?php
class Detalle_model extends Crearpoliza_model {
	protected $idr;

	function set_duaduana($id) {
		$this->idr = $id;
	}

	function numitem(){
		$query = $this->db
						->select('(max(item)+1) as item')
						->where('duaduana',$this->idr)
						->where('eliminar',0)
						->get('detalle')
						->row()->item;
		if($query){
			return $query;
		} else {
			return 1;
		}
	}

	function verlineadetalle($id){
		return $this->db->where('detalle', $id)
						->get('detalle')
						->row();
	}

	function verdetalleduar(){
		return $this->db->where('duaduana',$this->idr)
						->where('eliminar', 0)
						->get('detalle')
						->result();
	}

	function guardardet($ars){
		if ($ars['detalle']	) {
			$this->db->where('detalle', $ars['detalle'])
					 ->update('detalle', $ars);

			return $ars['detalle'];
		} else {
			$this->guardarproducto_importador($ars);
			$this->db->insert("detalle", $ars);
			return $this->db->insert_id();
		}
	}

	function guardarproducto_importador($ars){
		$imp = $this->db->select('nit')
						->where('duaduana', $ars['duaduana'])
						->get('encabezado')->row();

		$prod = $this->db->where('importador',$imp->nit)
				         ->where('codproducto', $ars['codigo_producto'])
				 		 ->where('paisorigen', $ars['origen'])
				 		 ->get('producto_importador');

		$datos = array(
				'importador'  =>  $imp->nit,
				'codproducto' =>  $ars['codigo_producto'],
				'descripcion' =>  $ars['descripcion'],
				'tlc'         =>  $ars['tlc'],
				'marca'       =>  $ars['marcas'],
				'numeros'     =>  $ars['numeros'],
				'partida'     =>  $ars['partida'],
				'no_bultos'   =>  $ars['no_bultos'],
				'paisorigen'  =>  $ars['origen'],
				'tipo_bulto'  =>  $ars['tipo_bulto'],
				'peso_neto'   =>  $ars['peso_neto'],
				'descripcion' =>  $ars['desc_sac']
			);

		if ($prod->num_rows() > 0) {
			$this->db->where('codproducto',$ars['codigo_producto'])
					 ->update('producto_importador', $datos);
		} else {
			$datos['fecha'] = date('Y-m-d');
			$this->db->insert('producto_importador', $datos);
		}

	}

	function getproducto($ars) {
		if (verDato($ars, 'producto')) {
			$pro = $this->db->where('codproducto', $ars['producto'])
							->get('producto_importador')
							->row();
			return $pro;
		}

		return false;
	}
}
?>