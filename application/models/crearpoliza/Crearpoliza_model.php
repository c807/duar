<?php
class Crearpoliza_model extends CI_Model {
	public $duar;

	function __construct($ars=''){
		if (verDato($ars, 'file')) {
			$this->verpoliza($ars);
		}

		return false;
	}

	# verifica si la poliza ya esta iniciada
	function verpoliza($ars=''){
		if (verDato($ars, 'file')) {
			$this->duar = $this->db->select('a.*, b.nombre, b.direccion')
									->where('c807_file', $ars['file'])
									->join('gacela.cliente_hijo b','a.nit = b.no_identificacion','left')
									->get('encabezado a')
									->row();
		}
	}

	function modelos($mod="") {
		if (!empty($mod)) {
			return $this->db
						->where('codigo', $mod)
						->get('modelo')
						->row();
		} else {
			return $this->db
						->get('modelo')
						->result();
		}
	}

	function ver_regimenes($ars){
		if (verDato($ars, 'opc')) {
			switch ($ars['opc']) {
				case 1:
					return $this->db->select("*")
									->from("reg_extendido")
									->where("modelo", $ars['codigo'])
									->get()
									->result();

					break;
				case 2:
					return $this->db->select("*")
									->from("reg_adicional")
									->where("reg_ext", $ars['codigo'])
									->get()
									->result();
				break;
				default:
					return false;
					break;
			}
		}
	}

	function nitempresa($ars){
		return $this->db->where("no_identificacion", $ars['nit'])
						->get("gacela.cliente_hijo")
						->row();
	}

	function guardarhead ($ars) {
		if ($ars['duaduana']) {

			return $this->db->where('duaduana', $ars['duaduana'])
					 		->update('encabezado', $ars);
		} else {
			$xdato = array('status' => 2);
			$this->db->where('c807_file', $ars['c807_file'])
					 ->update('solicitud', $xdato);

			$ars['anio']  = date('Y');
			return $this->db->insert('encabezado', $ars);
		}
	}

}
?>