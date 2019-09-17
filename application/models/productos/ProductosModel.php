<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class ProductosModel extends CI_Model {
    
            
        
        public   function buscar_producto($codigo,$origen)
        {
                $query = $this->db->get_where('producto_importador',array(
                    'codproducto' => $codigo,
                    'paisorigen' => $origen
                ));

                $count = $query->num_rows(); 
                $r="0";
                if ($count === 0) {
                    $r=0;
                
                }else{
                    $r=1;
                
                }
                return $r;

        }

 
        public function guardar_producto($id, $data)
        {
           
           if ($id)
           {
            $this->db->where('producimport', $id);
            $this->db->update('producto_importador', $data);
           } else{
            $this->db->insert('producto_importador', $data);
           
           }

          
        }
      
     
        
        function insertar($data)
        {
            $this->db->insert_batch('producto_importador', $data);
        }

        function insertar_duplicados($data)
        {
            $this->db->insert_batch('producto_duplicado', $data);
        }
    
         function borrar_producto($codigo){
	
            $this->db->where('codproducto', $codigo);
        
            $this->db->delete('producto_importador');
        
            
            }
  
        function consulta($id)
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

        function consulta_duplicados(){
           
            return $this->db->select('*')
                            ->get('producto_duplicado')
                            ->result();
        }

        function borrar_duplicados(){
	
            $this->db->empty_table('producto_duplicado');
            
            }

    }
    /* End of file ModelName.php */
    
?>