<?php
    
    defined('BASEPATH') or exit('No direct script access allowed');
    
    class ProductosModel extends CI_Model
    {
        public function buscar_producto($codigo, $origen)
        {
            $query = $this->db->get_where('producto_importador', array(
                    'codproducto' => $codigo,
                    'paisorigen' => $origen
                ));
                
            return $query->num_rows() > 0 ? 1 : 0;
        }
 
        public function guardar_producto($id, $data)
        {
            if ($id) {
                $this->db->where('producimport', $id);
                $this->db->update('producto_importador', $data);
            } else {
                $this->db->insert('producto_importador', $data);
            }
        }
      
        public function insertar($data)
        {
            $this->db->insert_batch('producto_importador', $data);
        }

        public function borrar_producto($codigo)
        {
            $this->db->where('codproducto', $codigo);
        
            $this->db->delete('producto_importador');
        }
  
        public function consulta($id)
        {
            $this->db->where('a.producimport', $id, 'after');
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
                                    a.observaciones,
                                    a.nombre_proveedor,
                                    a.importador,
                                    d.nombre nombre_pais,
                                    c.descripcion descripcion_bulto
                                    ')
                            ->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
                            ->join('pricing.pais d', 'a.paisorigen = d.id_pais')
                            ->get('producto_importador a')
                            ->result();
        }
    }
    /* End of file ModelName.php */
