<?php
    
    defined('BASEPATH') or exit('No direct script access allowed');
    
    class ProductosModel extends CI_Model
    {
        public function buscar_producto($codigo, $origen, $pais_id, $importador)
        {
            $query = $this->db->get_where('producto_importador', array(
                    'codproducto' => $codigo,
                    'paisorigen'  => $origen,
                    'pais_id'     => $pais_id,
                    'importador'  => $importador

                ));
                
            return $query->num_rows() > 0 ? 1 : 0;
        }
 
        public function guardar_producto($id, $data)
        {
            if ($id) {
                $this->db->where('producimport', $id);
                $this->db->update('producto_importador', $data);
                return ($this->db->affected_rows() > 0);
           
            } else {
                $this->db->insert('producto_importador', $data);
                return ($this->db->affected_rows() > 0);
           
            }
        }
      
        public function insertar($data)
        {
            if ($this->db->insert_batch('producto_importador', $data)) {
                echo 1;
            }
        }

        public function borrar_producto($id)
        {
            $this->db->where('producimport', $id);
            $this->db->delete('producto_importador');
        }
  
        public function consulta($id, $pais_id,$importador)
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
                                a.fito,
                                a.idestado,
                                a.idunidad,
                                a.pais_procedencia,
                                a.pais_adquisicion,
								a.observaciones,
								a.nombre_proveedor,
								a.importador,
								d.nombre nombre_pais
                                  ')
                            ->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
                            ->join('pricing.pais d', 'a.paisorigen = d.id_pais')
                            ->where('a.pais_id', $pais_id)
                            ->where('a.importador', $importador)
                            ->get('producto_importador a')
                            ->result();
        }
        public function listado_permisos($id){
         
            return $this->db->select('p.descripcion, d.id, d.idpermiso,d.partida')
                            ->join('detalle_permiso d', 'd.idpermiso = p.idpermiso')
                            ->where('d.partida', $id)
                            ->get('permiso p')
                            ->result();
        }

        public function agregar_permiso($data){
            $this->db->insert('detalle_permiso', $data);
            return ($this->db->affected_rows() > 0);
        }

        public function eliminar_permiso($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('detalle_permiso');
        }

        function verificar_permiso($permiso,$id){
            return $this->db
            ->where('idpermiso', $permiso)
            ->where('partida', $id)
            ->get('detalle_permiso')
            ->row();
        }
    }
    /* End of file ModelName.php */
