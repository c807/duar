<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Subir_archivos_model extends CI_Model {


    public function __construct() {
        parent::__construct();
    }

    function consulta($id_file, $cliente_hijo_id = null)
    {

        if (isset($cliente_hijo_id))
            {
                $query = $this->db 
                              ->select("d.id , d.codigo_producto, d.descripcion, du.partida")
                              ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                              ->join('duarx.producto_importador as du', 'du.codproducto = d.codigo_producto and du.importador = '.  $cliente_hijo_id, 'left')
                              ->where('du.partida IS  NULL')
                              ->where('f.id', $id_file)                 
                              ->order_by('d.descripcion')
					          ->get('gacela.file as f')
                              ->result();
            }else {

                $query = $this->db 
                              ->select("d.id , d.codigo_producto, d.descripcion")
                              ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                          //    ->join('duarx.producto_importador as du', 'du.codproducto = d.codigo_producto and du.importador = '.  $cliente_hijo_id, 'left')
                           //   ->where('du.partida IS  NULL')
                              ->where('f.id', $id_file)                 
                              ->order_by('d.descripcion')
					          ->get('gacela.file as f')
                              ->result();
            }    

        return $query;
        //echo $this->db->last_query();exit();
    }

    public function existe_factura($data)
    {
        //con id_file obtener el codgo de cliente
        //Verificar que producto en ese cliente no exista

        //$importador = $this->obtener_datos_file($data['numero_file']);
        $importador = $this->obtener_datos_file($data['num_file']);
        
        $query = $this->db
                ->select('count(*) as cantidad')
                ->where('id_file',$importador->id )
              //  ->where('codigo_producto',$data['codigo_producto'])
                ->where('num_factura',$data['num_factura'])
                ->get('duarx.dpr')
                ->row();

        return $query;        
        //var_dump(intval($query->cantidad));
        //die();
    }

    function insert($data)

      {
        $this->db->insert('duarx.dpr', $data);
      }

    
    function traer_informacion_producto($id_reg)
    {
        return  $this->db
                     ->select('id , id_file  , codigo_producto, descripcion')
                     ->where('id' , $id_reg)
                     ->get('duarx.dpr')
                     ->row();
    }


    public function insertar_partida($args)
    {
        //grabar IMPORTADOR, CODIGO DE PRODUCTO, DESCRIPCION Y PARTIDA ARANCEARIA
        if (verDato($args, 'importador')) {
			$datos['importador'] = $args['importador'];
        } 
        if (verDato($args, 'codigo_producto')) {
			$datos['codproducto'] = $args['codigo_producto'];
		}
        if (verDato($args, 'nombre')) {
			$datos['descripcion'] = $args['nombre'];
        }
        if (verDato($args, 'partida_arancelaria')) {
			$datos['partida'] = $args['partida_arancelaria'];
		}

        $this->db->insert('duarx.producto_importador', $datos);

    }
    
    function generar_excel($numero_file, $doc_transporte)
    {        
        
        $importador = $this->obtener_datos_file($numero_file);
        
        return  $this->db
                    ->select(" '' as 'Codigo Producto', '' as tlc, '' as acuerdo, '' as cuota,
                    'S/M' as marca , 'S/N' as numero, du.partida, $doc_transporte as 'Documento de Transporte' , 'PK' AS 'Tipo Bulto', 
                    d.pais_origen as pais ,  sum(d.cuantia) as cuantia,  sum(d.total) as fob, 0 as  'peso_bruto' , 0 as 'peso_neto',
                    0 as flete, 0 as seguro , 0 as otros, sum(d.total) as cif , 0 as 'numero_de_bultos', du.descripcion , '' as contenedor1
                    , '' as contenedor2, '' as contenedor3, '' as contenedor4")
                    ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', 'du.codproducto = d.codigo_producto and du.importador = '.  $importador->cliente_hijo_id, 'left')
                    ->where('f.c807_file' , $numero_file)
                    ->group_by('du.partida')             
                    ->order_by('du.partida')
                    ->get('gacela.file as f')
                    ->result();
            //echo $this->db->last_query();exit();

    }
    
    public function contar_registros($id_file)

    {
        return  $this->db
                    ->select('count(*) as total')
                    ->join('dpr as d' , 'd.id_file =  f.id', 'inner')
                    ->join('dua as du', 'du.codigo_producto = d.codigo_producto', 'left')
                    ->where('du.partida_arancelaria IS NULL')
                    ->where('f.c807_file', $id_file)    
                    ->get('file as f')
                    ->result();
    }

    function generar_excel_no_agrupada($id_file)
    {        
        return $this->db
                    ->select('d.id ,  d.codigo_producto, d.descripcion , du.partida_arancelaria, d.cuantia, d.precio_unitario, d.total')
                    ->join('dpr as d' , 'd.id_file =  f.id', 'inner')
                    ->join('dua as du', 'du.codigo_producto = d.codigo_producto', 'inner')
                    ->where('du.partida_arancelaria IS NOT NULL')
                    ->where('f.c807_file', $id_file)    
                    ->get('file as f')
                    ->result();
    }

    public function obtener_datos_file($numero_file)
    {

        return $this->db
                     ->select('id, cliente_hijo_id')
                     ->where('c807_file', $numero_file)
                     ->get('gacela.file')
                     ->row();
        
    }

    public function traer_paises($arreglo)
    {

        // id_file , partida, importador, codproducto, id_file, codigo_producto, pais_origen
        if (isset($arreglo['partida']))
        {
            $query = $this->db
                       ->distinct()            
                       ->select('iso2')  
                       ->join('duarx.dpr' , 'codigo_producto = codproducto and id_file = ' . $arreglo['cliente']->id, 'inner')
                       ->join('gacela.pais' ,'nombre = pais_origen', 'inner')
                       ->where('partida' , $arreglo['partida'])
                       ->where('importador' ,  $arreglo['cliente']->cliente_hijo_id)
                       ->get('duarx.producto_importador')
                       ->result();
        }
        //echo $this->db->last_query();exit();

        return $query;

    }

}

/* End of file ModelName.php */
