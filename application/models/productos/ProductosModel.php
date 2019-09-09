<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class ProductosModel extends CI_Model {
    
                
        public function lista_productos_importador(){
            return $this->db->select('
            b.nombre,
            a.producimport,
            a.descripcion,
            a.codproducto,
            a.tlc,
            a.partida,
            a.paisorigen,
            a.fecha,
            a.importador,
            a.funcion,
            a.descripcion_generica,
            a.observaciones,
            a.permiso,
            a.nombre_proveedor
           
            ')
            ->join('gacela.cliente_hijo b', 'a.importador = b.no_identificacion')
            ->get('producto_importador a')
            ->result();
     
        }

       
    
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

       // function cargar_desde_archivo($importador, $codproducto, $descripcion, $descripcion_generica, $funcion, $partida, $observaciones, $obervaciones, $tlc, $proveedor)
       function cargar_desde_archivo($data)
        {
       
        	$this->db->insert('producto_importador', $data);
	    }

        function actualizar_producto($id, $datos)
        {
           
            $this->db->where('producimport', $id);
   
            $this->db->update('producto_importador', $datos);
            

        }  
        

        function insertar($data)
        {
            $this->db->insert_batch('producto_importador', $data);
        }
    
         function borrar_producto($codigo){
	
            $this->db->where('codproducto', $codigo);
        
            $this->db->delete('producto_importador');
        
            
            }


            function get_salaries_dropdown()
            {
                $this->db->from($this->empresa);
                $this->db->order_by('id');
                $result = $this->db->get();
                $return = array();
                if($result->num_rows() > 0){
                        $return[''] = 'please select';
                    foreach($result->result_array() as $row){
                        $return[$row['id']] = $row['nombre'];
                    }
                }
                return $return;
            }
        
    
    }
    
    /* End of file ModelName.php */
    
?>