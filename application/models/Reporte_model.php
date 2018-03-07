<?php

class Reporte_model extends CI_Model {
	public $duar;

	function __construct($ars=''){
		if (verDato($ars, 'file')) {
			$this->verpoliza($ars);
		}
	}

	function verpoliza($ars='') {
		if (verDato($ars, 'file')) {
			$this->duar = $this->db->select('a.*, b.nombre, c.codigo as codigoaduana')
									->where('c807_file', $ars['file'])
									->join('empresa b','a.nit = b.cod_empresa','left')
									->join('aduana c','a.aduana_entrada_salida = c.aduana','left')
									->get('encabezado a')
									->row();
		}
	}

	function verdetallepoliza() {
		if ($this->duar->duaduana) {
			return $this->db->where('duaduana', $this->duar->duaduana)
							->where('eliminar',0)
							->get('detalle')
							->result();
		}

		return FALSE;
	}

	function verdocumentos() {
		if ($this->duar->duaduana) {
			return $this->db->select("
								*,
								IF(tipodocumento = 049, 1, 2) AS orden
								")
							->where('duaduana', $this->duar->duaduana)
							->where('eliminar', 0)
							->join('tipo_documento b','a.tipodocumento = b.codigo')
							->order_by("orden, tipodocumento","ASC")
							->get('documento a')
							->result();
		}
	}
}
?>