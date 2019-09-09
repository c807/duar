<?php 
class Importador_model extends CI_Model
{
	protected $resultado = array ();

	function verproductos($ars){
		if (verDato($ars, 'importador')) {
			$this->db->like('b.nombre', $ars['importador'], 'after');
		}

		return $this->db->select('
								b.nombre,
								a.producimport,
								a.descripcion,
								a.codproducto,
								if(a.tlc = 1, 1,0) as tlc,
								a.partida,
								a.paisorigen,
								a.fecha,
								a.no_bultos,
								a.peso_neto,
								a.numeros,
								a.marca,
								a.tipo_bulto,
								a.funcion,
								a.descripcion_generica,
								a.permiso,
								a.observaciones,
								a.nombre_proveedor,
								a.importador,
								c.descripcion as descrip
								
								')
						->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
						->join('tipo_bulto c', 'a.tipo_bulto = c.codigo')
						->join('pricing.pais d', 'a.paisorigen = d.id_pais')
						->limit(10, $ars['inicio'])
						->get('producto_importador a')
				 		->result();
	}

	function verlineaproducto($ars) {
		return $this->db->select('
								b.nombre,
								a.producimport,
								a.descripcion,
								a.codproducto,
								if(a.tlc = 1, 1,0) as tlc,
								a.partida,
								a.paisorigen,
								a.fecha,
								a.no_bultos,
								a.peso_neto,
								a.numeros,
								a.marca,
								a.tipo_bulto,
								a.funcion,
								a.permiso,
								a.descripcion_generica,
								a.observaciones,
								a.nombre_proveedor,
								a.importador,
								d.nombre as npaisorigen,
								c.descripcion as nombrebulto
								')
						->where('producimport', $ars['prodimpor'])
						->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
						->join('tipo_bulto c', 'a.tipo_bulto = c.codigo')
						->join('pricing.pais d', 'a.paisorigen = d.id_pais')
						->get('producto_importador a')
						->row();
	}

	function set_mensaje($msj, $res) {
		$this->resultado = array('msj' => $msj, 'res' => $res);
	}

	function get_mensaje(){
		return $this->resultado;
	}

	function guardardatos($ars){
		if (verDato($ars, 'producimport')) {
			$this->db->where('producimport', $ars['producimport']);
/*
			if ($this->db->update('producto_importador', $ars)) {
				return $ars['producimport'];
			} else {
				$this->set_mensaje("No se puede realizar la actualización ",$ars['producimport']);
			}*/
			$this->db->update('producto_importador', $ars);
			

		} else {
			$this->db->insert('producto_importador', $ars);
			//$this->set_mensaje("Faltan datos principales para editar",$ars['producimport']);
		}

		return FALSE;
	}
}
?>