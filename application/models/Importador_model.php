<?php 
class Importador_model extends CI_Model
{
	protected $resultado = array ();

	function verproductos($ars){
		$ejecutar=0;
		
		if ($ars['opcionbuscar']==1)
		{
			$this->db->where('a.importador', $ars['importador'], 'after');
			$ejecutar=1;
		}
		
		if ($ars['opcionbuscar']==2)
		{
			$this->db->like('b.nombre', $ars['importador'], 'after');
			$ejecutar=1;
		}

		if ($ars['opcionbuscar']==3)
		{
			$this->db->where('a.nombre_proveedor', $ars['importador'], 'after');
			$ejecutar=1;
		}
		if ($ars['opcionbuscar']==4)
		{
			$this->db->like('a.codproducto', $ars['importador'], 'after');
			$ejecutar=1;
		}

		if ($ars['opcionbuscar']==5)
		{
			$this->db->like('a.descripcion', $ars['importador'], 'after');
			$ejecutar=1;
		}

		if ($ars['opcionbuscar']==6)
		{
			$this->db->where('a.partida', $ars['importador'], 'after');
			$ejecutar=1;
		}

		if ($ars['opcionbuscar']==7)
		{
			$this->db->like('a.descripcion_generica', $ars['importador'], 'after');
			$ejecutar=1;
		}

		if ($ars['opcionbuscar']==8)
		{
			$this->db->like('a.funcion', $ars['importador'], 'after');
			$ejecutar=1;
		}
		if (empty($ars['opcionbuscar'])){
			if ($ars['inicio']==0){
				$this->db->where('b.nombre', $ars['importador'], 'after');
				$ejecutar=1;
			}
		}
		
		
		if ($ejecutar==1) {
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
								d.nombre nombre_pais,
								c.descripcion descripcion_bulto
								')
                        ->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
                        ->join('tipo_bulto c', 'a.tipo_bulto = c.codigo')
                        ->join('pricing.pais d', 'a.paisorigen = d.id_pais')
                        ->get('producto_importador a')
                         ->result();
		}
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