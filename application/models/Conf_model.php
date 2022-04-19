<?php
class Conf_model extends CI_Model
{
    public function __construct()
    {
        parent :: __construct();
      //   $_SESSION['pais_id']=2; //El Salvador
       //  $_SESSION['pais_id']=3;  //Honduras
        if (isset($_SESSION['pais_id'])) {
            $this->pais = $_SESSION['pais_id'];
        } else {
            $this->pais = 0;
		}
		
    }

    public function get_modelo($mcod)
    {
        return $this->db->where('codigo', $mcod)
                        ->get('modelo')
                        ->row();
    }

    public function dtusuario($id)
    {
        $user = $this->db->select("
							usuario,
							nombre,
							mail
							")
                        ->where('usuario', $id)
                        ->get('csd.usuario')
                        ->row();

        return $user;
    }

    # #  Datos para mostrar en el encabezado
    public function aduanas($aduana = '')
    {
        if (!empty($aduana)) {
            return $this->db->where('aduana', $aduana)
                            ->get('aduana')
                            ->row();
        } else {
            return $this->db->get('aduana')
                            ->result();
        }
    }

    public function modotransporte($modo='')
    {
        if (!empty($modo)) {
            return $this->db->where('codigo', $modo)
                            ->get('modo_transporte')
                            ->row();
        } else {
            return $this->db->get('modo_transporte')
                            ->result();
        }
    }

    public function empresas($nit='')
    {
        if (!empty($nit)) {
            $query = $this->db->where("no_identificacion", $nit)
                              ->get('gacela.cliente_hijo')
                              ->row();
        } else {
            $query = $this->db->get('gacela.cliente_hijo')
                              ->result();
        }

        return $query;
    
       
    }

    public function paises($pais='')
    {
        if (!empty($pais)) {
            $query = $this->db->where('id_pais', $pais)
                            ->get('pricing.pais')->row()
                            ->nombre;
        } else {
            $query = $this->db->get('pricing.pais')
                              ->result();
        }

        return $query;
    }

    public function incoterm($inco='')
    {
        if (!empty($inco)) {
            return $this->db->where('codigo', $inco)
                            ->get('dua.incoterms')
                            ->row();
        } else {
            return $this->db->get('dua.incoterms')
                            ->result();
        }
    }
    

    public function tipoBulto($ipo='')
    {
        if (!empty($tipo)) {
            return $this->db->where('codigo', $tipo)
                              ->get('tipo_bulto')
                              ->row()
                              ->descripcion;
        } else {
            return  $this->db->get('tipo_bulto')
                              ->result();
        }
    }

    public function documento($doc='')
    {
        if (!empty($doc)) {
            return $this->db->where('cod', $doc)
                            ->get('tipo_documento')
                            ->row();
        } else {
            return $this->db->get('tipo_documento')
                            ->result();
        }
    }

    public function preferencia($doc='')
    {
        if (!empty($doc)) {
            return $this->db->where('cod_preferencia', $doc)
                            ->get('preferencia')
                            ->row();
        } else {
            return $this->db->get('preferencia')
                            ->result();
        }
    }
    public function verfinalizar($file='')
    {
        if (! empty($file)) {
            $sql = $this->db->where('c807_file', $file)
                            ->get('solicitud')->row();

            $return = (isset($sql->status) && $sql->status == 3) ? 1 : 0;

            return $return;
        }
    }

    public function regextendido()
    {
        return $this->db->get('reg_extendido')
                        ->result();
    }

    public function equipamiento()
    {
        return $this->db->get('equipamiento')
                        ->result();
    }

    public function tipocontenedor()
    {
        return $this->db->get('tipo_contenedor')
                        ->result();
    }
    public function tipocarga()
    {
        return $this->db->get('tipo_carga')
                        ->result();
    }

    

    public function regadicional()
    {
        return $this->db->where('')
                        ->get('reg_adicional')
                        ->result();
    }

    public function acuerdo()
    {
        return $this->db->get('acuerdo')
                        ->result();
    }

    public function quota()
    {
        return $this->db->get('quota')
                        ->result();
    }

    public function entidad()
    {
        return $this->db->get('entidad')
                        ->result();
    }

    public function localmercancia()
    {
        return $this->db->where('pais_empresa', $this->pais)
                        ->get('localizacion_mercancia')
                        ->result();
    }

    public function lugardecarga()
    {
        return $this->db->where('pais_empresa', $this->pais)
                        ->get('zona_descargue')
                        ->result();
    }

    

    public function presentacion()
    {
        return $this->db->where('pais_empresa', $this->pais)
                        ->get('presentacion')
                        ->result();
    }

    public function bancos()
    {
        return $this->db->where('pais_empresa', $this->pais)
                        ->get('banco')
                        ->result();
    }

    public function agencia($codigo)
    {
        return $this->db->where('pais_empresa', $this->pais)
                        ->where('banco', $codigo)
                        ->get('agencia')
                        ->result();
    }

    public function tipodocumento()
    {
        return $this->db->where('pais_empresa', $this->pais)
                        ->get('tipo_documento')
                        ->result();
    }



    public function agentes()
    {
        return $this->db->where("pais_empresa", $this->pais)
                        ->get("agente_aduanal")
                        ->result();
    }


    public function estados($estados='')
    {
        if (!empty($estados)) {
            $query = $this->db->where('idestado', $estados)
                            ->get('estado')->row()
                            ->descripcion;
        } else {
            $query = $this->db->get('estado')
                              ->result();
        }

        return $query;
    }

    
    public function u_comercial($u_comercial='')
    {
        if (!empty($u_comercial)) {
            $query = $this->db->where('idunidad', $u_comercial)
                            ->get('unidad_comercial')->row()
                            ->descripcion;
        } else {
            $query = $this->db->get('unidad_comercial')
                              ->result();
        }

        return $query;
    }
    

   

	public function info_accesos_dpr($user)
	
    {
		$query = $this->db
		->select('e.*, c.descripcion as menu, c.descripcion  as menu, b.descripcion as modulo, f.nombre as usuario ')
		->join('csd.menu b', 'b.menu = a.menu', 'inner')
		->join('csd.modulo c', 'c.modulo = a.modulo', 'inner')
		->join('csd.roll d', 'd.roll = a.roll', 'inner')
		->join('csd.acceso e', 'e.modulo = a.modulo', 'inner')
		->join('csd.usuario f', 'f.usuario = e.usuario', 'inner')
        ->where('a.modulo', 29)
		->where('a.menu', 1065)
		->where('f.usuario', $user)
		->get('csd.sys03 a')
		->row();

		return $query;

    }
    
    
	public function info_accesos_pa($user)
	
    {
		$query = $this->db
		->select('e.*, c.descripcion as menu, c.descripcion  as menu, b.descripcion as modulo, f.nombre as usuario ')
		->join('csd.menu b', 'b.menu = a.menu', 'inner')
		->join('csd.modulo c', 'c.modulo = a.modulo', 'inner')
		->join('csd.roll d', 'd.roll = a.roll', 'inner')
		->join('csd.acceso e', 'e.modulo = a.modulo', 'inner')
		->join('csd.usuario f', 'f.usuario = e.usuario', 'inner')
        ->where('a.modulo', 29)
		->where('a.menu', 1071)
		->where('f.usuario', $user)
		->get('csd.sys03 a')
		->row();

		return $query;

	}

    public function catalogo_permisos()
    {
        return $this->db->where("id_pais", $this->pais)
                        ->get("permiso")
                        ->result();
    }

	
}
