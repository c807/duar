<?php
class Crearpoliza_model extends CI_Model
{
    public $duar;

    public function __construct($ars='')
    {
        if (verDato($ars, 'file')) {
            $this->verpoliza($ars);
        }

        return false;
    }

    # verifica si la poliza ya esta iniciada
    public function verpoliza($ars='')
    {
        if (verDato($ars, 'file')) {
            $this->duar = $this->db->select('a.*')
                                    ->where('c807_file', $ars['file'])
                                    ->get('encabezado a')
                                    ->row();
        }
    }

    public function modelos($mod="")
    {
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

    public function ver_regimenes($ars)
    {
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

    public function nitempresa($ars)
    {
        return $this->db->where("empresa", $ars['nit'])
                        ->get("empresa")
                        ->row();
    }

    public function guardarhead($ars)
    {
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

    public function guardar_seg_general($id, $data)
    {
        if ($id) {
            $this->db->where('duaduana', $id);
            $this->db->update('encabezado', $data);
            return $id['encabezado'];
        } else {
            $this->db->insert('encabezado', $data);
            return $this->db->insert_id();
        }
    }

    public function guardar_items($id, $data)
    {
        if ($id) {
            $this->db->where('detalle', $id);
            $this->db->update('detalle', $data);
            return $id['detalle'];
        } else {
            $this->db->insert('detalle', $data);
            return $this->db->affected_rows() > 0;
        }
    }

    public function guardar_adjunto($id, $data)
    {
        if ($id) {
            $this->db->where('documento', $id);
            $this->db->update('documento', $data);
            return $id['documento'];
        } else {
            $this->db->insert('documento', $data);
            return $this->db->affected_rows() > 0;
        }
    }

    public function get_dua($id)
    {
        $pro = $this->db->where('c807_file', $id)
                            ->get('encabezado')
                            ->row();
        return $pro;
    }
    
    public function lista_items($id)
    {
        $query = $this->db->where('duaduana', $id)
           ->get('duarx.detalle')
           ->result();
        return $query;
    }

    public function lista_adjuntos($item, $id)
    {
        $query = $this->db->where('item', $item)
           ->where('duaduana', $id)
           ->get('duarx.documento')
           ->result();
        return $query;
    }

    public function consulta_adjunto($item)
    {
        $query = $this->db->where('documento', $item)
          ->get('documento')
          ->row();
        return $query;
    }
    public function consulta_item($item)
    {
        $query = $this->db->where('detalle', $item)
          ->get('detalle')
          ->row();
        return $query;
    }
    
    public function consulta_dm($id)
    {
        $query = $this->db->where('duaduana', $id)
          ->get('encabezado')
          ->row();
        return $query;
    }

    public function eliminar_adjunto($id)
    {
        $this->db->where('documento', $id);
    
        $this->db->delete('documento');
    }
    
    public function eliminar_item($id)
    {
        $this->db->where('detalle', $id);
    
        $this->db->delete('detalle');
    }

    public function dowload_adjunto($pdf)
    {
        $query = $this->db->where('documento', $pdf)
          ->get('documento')
          ->row();
        return $query;
    }


    public function guardar_equipamiento($id, $data)
    {
        if ($id) {
            $this->db->where('equipamiento', $id);
            $this->db->update('detalle_equipamiento', $data);
            return $id['equipamiento'];
        } else {
            $this->db->insert('detalle_equipamiento', $data);
            return $this->db->affected_rows() > 0;
        }
    }


    public function lista_equipamiento($id)
    {
        $query = $this->db->where('duaduana', $id)
           ->get('duarx.detalle_equipamiento')
           ->result();
        return $query;
    }

    
    public function consulta_equipamiento($item)
    {
        $query = $this->db->where('equipamiento', $item)
          ->get('detalle_equipamiento')
          ->row();
        return $query;
    }

    public function eliminar_equipamiento($id)
    {
        $this->db->where('equipamiento', $id);
    
        $this->db->delete('detalle_equipamiento');
    }

    public function consulta_consignatario($item)
    {
        $query = $this->db->where('no_identificacion', $item)
          ->get('gacela.cliente_hijo')
          ->row();
        return $query;
    }


    
    public function consulta_producto($item)
    {
        $query = $this->db->where('partida', $item)
          ->get('producto_importador')
          ->row();
        return $query;
    }

    public function generar_xml()
    {
        $duaduana=322;
        $query = $this->db->where('duaduana', $duaduana)
        ->get('duarx.encabezado')
        ->row();
        return $query;
    }
}
