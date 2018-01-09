<?php
class Principal_model extends CI_Model {
	public $dtfile;


	function __construct($proceso = ''){
		if (!empty($proceso)) {
			$this->verprocesoga($proceso);
		}
	}

	# Une el proceso de aduana (Gacela)
	function verprocesoga($proceso){
		$this->dtfile = $this->db
						->select('
								file_id,
								master_id,
								a.id as proceso,
								a.usuario_id as ejecutivo,
								b.c807_file,
								date(b.fecha) as creacion')
						->from('gacela.file_proceso a')
						->where('a.id',$proceso)
						->join('gacela.file b','b.id = a.file_id','inner')
						->get()
						->row();

		return $this->dtfile;
	}

	function ver_ejecutivo() {
		$this->ejec = $this->db
							->select('usuario,nombre,mail')
							->where('usuario', $this->dtfile->ejecutivo)
					     	->get('csd.usuario')
							->row();
		return  $this->ejec;
	}

	# Trae en arreglo los datos del file
	function filegacela() {
		$cl = $this->db->where('c807_file',$this->dtfile->c807_file)
					   ->join('gacela.cliente_hijo b','b.id = a.cliente_hijo_id','inner')
					   ->get('gacela.file a')
					   ->row_array();
		return $cl;
	}

	function setbitacorag(){
		if ($this->dtfile->master_id) {
			$msj = 'Se envió la solicitud para crear la pre póliza';

			$this->db
				->set('master_id', $this->dtfile->master_id)
				->set('file_id', $this->dtfile->file_id)
				->set('file_proceso_id', $this->dtfile->proceso)
				->set('estatus_disponible_id', 119)
				->set('proceso_id', 1)
				->set('ecorreo', 1)
				->set('epara', 'kelvynmagzul@stguatemala.com')
				->set('comentario', $msj)
				->set('fecha', 'now()', false)
				->set('usuario_id', $_SESSION['UserID'])
				->insert('gacela.bitacora');
		}
	}

	function setsolicitud_dua(){
		$gf = $this->filegacela();

		if (verDato($gf, 'usuario_id')) {
			$this->db
				->set('c807_file',$this->dtfile->c807_file)
				->set('marginador', $_SESSION['UserID'])
				->set('importador', $gf['nombre'])
				->set('ejecutivo', $gf['usuario_id'])
				->set('fecha' ,'now()', false)
				->set('status', 1)
				->insert('solicitud');
		}
	}

	function setbitacoradua($arg){
		$this->db
			->set('fecha', 'curdate()', false)
			->set('hora', 'CURRENT_TIME()', false)
			->set('descripcion', $arg['coment'])
			->set('c807_file', $this->dtfile->c807_file)
			->set('status', 1)
			->set('realizo', $_SESSION['UserID'])
			->insert('bitacora');
	}


}
?>