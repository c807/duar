<?php
class Importador_model extends CI_Model
{
    protected $resultado = array();

    public function verproductos($ars, $pais_id)
    {
        $ejecutar=0;
         echo "<br>";
     
        if ($ars['opcionbuscar']==1) {
            $this->db->where('a.importador', $ars['importador'], 'after');
            $ejecutar=1;
        }
        
        if ($ars['opcionbuscar']==2) {
            $this->db->like('b.nombre', $ars['importador'], 'after');
            $ejecutar=1;
        }

        if ($ars['opcionbuscar']==3) {
            $this->db->where('a.nombre_proveedor', $ars['importador'], 'after');
            $ejecutar=1;
        }
        if ($ars['opcionbuscar']==4) {
            $this->db->like('a.codproducto', $ars['importador'], 'after');
            $ejecutar=1;
        }

        if ($ars['opcionbuscar']==5) {
            $this->db->like('a.descripcion', $ars['importador'], 'after');
            $ejecutar=1;
        }

        if ($ars['opcionbuscar']==6) {
            $this->db->where('a.partida', $ars['importador'], 'after');
            $ejecutar=1;
        }

        if ($ars['opcionbuscar']==7) {
            $this->db->like('a.descripcion_generica', $ars['importador'], 'after');
            $ejecutar=1;
        }

        if ($ars['opcionbuscar']==8) {
            $this->db->like('a.funcion', $ars['importador'], 'after');
            $ejecutar=1;
        }
        if (empty($ars['opcionbuscar'])) {
            if ($ars['inicio']==0) {
                $this->db->where('b.nombre', $ars['importador'], 'after');
                $ejecutar=1;
            }
        }
        
        //  $this->db->where('a.pais_id', $pais_id)  ;
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
								a.funcion,
								a.descripcion_generica,
                                a.permiso,
                                a.fito,
                                a.idestado,
                                a.idunidad,
                                a.pais_procedencia,
                                a.pais_adquisicion,
								a.observaciones,
								a.nombre_proveedor,
                                a.importador,
                                a.pais_id,
								d.nombre nombre_pais
								')
                        ->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
                        ->join('pricing.pais d', 'a.paisorigen = d.id_pais')
                        ->where('a.pais_id', $pais_id)
                        ->get('producto_importador a')
                         ->result();
        }
    }

    public function verlineaproducto($ars)
    {
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
                                a.fito,
                                a.idestado,
                                a.idunidad,
                                a.pais_procedencia,
                                a.pais_adquisicion,
								a.descripcion_generica,
								a.observaciones,
								a.nombre_proveedor,
								a.importador,
								d.nombre as npaisorigen,
								c.descripcion as nombrebulto
								')
                        ->where('producimport', $ars['prodimpor'])
                        ->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
                        ->join('pricing.pais d', 'a.paisorigen = d.id_pais')
                        ->get('producto_importador a')
                        ->row();
    }

    public function set_mensaje($msj, $res)
    {
        $this->resultado = array('msj' => $msj, 'res' => $res);
    }

    public function get_mensaje()
    {
        return $this->resultado;
    }

    public function guardardatos($ars, $pais_id)
    {
        if (verDato($ars, 'producimport')) {
            $this->db->where('producimport', $ars['producimport']);
            $this->db->where('pais_id', $ars['$pais_id']);
            $this->db->update('producto_importador', $ars);
        } else {
            $this->db->insert('producto_importador', $ars);
        }

        return false;
    }
}