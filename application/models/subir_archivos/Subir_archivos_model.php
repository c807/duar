<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Subir_archivos_model extends CI_Model {


    public function __construct() {
        parent::__construct();
    }

    function consulta($id_file, $no_identificacion = null, $opcion = null)
    {


        if (isset($no_identificacion))
            {
                if ($opcion == 1)
                    {

                        $query = $this->db
                                      ->select("d.id , d.codigo_producto, d.descripcion, du.partida,  d.num_factura , d.tlc")
                                      ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                                      ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$no_identificacion'", 'left')
                                      ->where('du.partida IS  NULL')
                                      ->where('f.id', $id_file)
                                      ->order_by('d.descripcion')
					                  ->get('gacela.file as f')
                                     ->result();
                    } elseif ($opcion == 2) {
                        $query = $this->db
                                      ->select("d.id as Id , d.codigo_producto as 'Codigo Producto' , d.descripcion as Descripcion, du.partida as 'Partida Arancelaria',
                                       d.num_factura as 'Numero Factura' , d.tlc as TLC, f.c807_file as 'File'  ")
                                      ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                                      ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$no_identificacion'", 'left')
                                      ->where('f.id', $id_file)
                                      ->order_by('d.descripcion')
					                  ->get('gacela.file as f')
                                     ->result();
                    }  else {
                        //Verificar si archivo que se subio tiene productos SIN CLASIFICAR
                        $query = $this->db
                               ->select("count(*) as cantidad")
                               ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                               ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$no_identificacion'", 'left')
                               ->where('du.partida IS  NULL')
                               ->where('f.id', $id_file)
                               ->order_by('d.descripcion')
				               ->get('gacela.file as f')
                               ->result();

                      /*   echo "Cantidad de Registro: ";
                        var_dump($query);
                        die(); */
                    }

            }else {


               /*  $query = $this->db
                              ->select("d.id , d.codigo_producto, d.descripcion")
                              ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                              //->join('duarx.producto_importador as du', 'du.codproducto = d.codigo_producto and du.importador = '.  $no_identificacion, 'left')
                              ->where('f.id', $id_file)
                              ->order_by('d.descripcion')
					          ->get('gacela.file as f')
                              ->result(); */
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

    function crear_listado_polizas($data)
    {

        if (isset($data['id_usuario_clasificador'])) {
            $this->db
                     ->set('lp.id_usuario_clasificador' , $data['id_usuario_clasificador'])
                     ->where('lp.id_file' , $data['id_file'])
                     ->update('duarx.listado_polizas as lp');
        }else{
            $this->db->insert('duarx.listado_polizas' , $data);
        }


    }

    function polizas_no_clasificadas()
    {
        $query = $this->db
                      ->select("f.c807_file as Id , f.c807_file as 'Numero file' , lp.fecha_importacion as 'Fecha Importacion' ")
                      ->join('gacela.file  as f','f.id = lp.id_file','inner')
                      ->where('lp.id_usuario_clasificador' , 0 )
                      ->get('duarx.listado_polizas as lp')
                      ->result();

        return $query;
    }


    function traer_informacion_producto($id_reg)
    {
        return  $this->db
                     ->select('id , id_file  , codigo_producto, descripcion, num_factura')
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
        if (verDato($args, 'descripcion')) {
			$datos['descripcion'] = $args['descripcion'];
        }
        if (verDato($args, "partida_arancelaria")) {
			$datos['partida'] = $args["partida_arancelaria"];
		}

        $this->db->insert('duarx.producto_importador', $datos);

    }

    function generar_excel($numero_file, $doc_transporte)
    {

        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-','',$importador->no_identificacion);

        return  $this->db
                    ->select(" 0 as linea,  '' as 'Codigo Producto', d.tlc as tlc, '' as acuerdo, '' as cuota,
                    'S/M' as marca , 'S/N' as numero, du.partida, $doc_transporte as 'Documento de Transporte' , 'PK' AS 'Tipo Bulto',
                    d.pais_origen as pais ,  sum(d.cuantia) as cuantia,  sum(d.total) as fob, 0 as  'peso_bruto' , 0 as 'peso_neto',
                    0 as flete, 0 as seguro , 0 as otros, sum(d.total) as cif , 0 as 'numero_de_bultos', du.descripcion , '' as contenedor1
                    , '' as contenedor2, '' as contenedor3, '' as contenedor4")
                    ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$importador->no_identificacion'"  , 'left')
                    ->where('f.c807_file' , $numero_file)
                    ->group_by('du.partida , d.tlc')
                    ->order_by('du.partida ')
                    ->get('gacela.file as f')
                    ->result();
            //echo $this->db->last_query();exit();

    }

    public function generar_rayado($numero_file)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-','',$importador->no_identificacion);

        return  $this->db
                    ->select(" d.linea_agrupacion as linea ,  d.codigo_producto as 'Codigo_Producto', d.num_factura , d.tlc as tlc,  du.partida,
                     d.pais_origen as pais ,  d.cuantia as cuantia,  d.total as fob, du.descripcion")
                    ->join('duarx.dpr as d' , 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$importador->no_identificacion'"  , 'left')
                    ->where('f.c807_file' , $numero_file)
                    ->order_by('d.id ')
                    ->get('gacela.file as f')
                    ->result();
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


    public function actualizar_linea_agrupacion($numero_file, $partida_arancelaria, $linea, $tlc)
    {

        $listado = $this->obtener_listado_productos($numero_file,$partida_arancelaria);

        for ($i=0; $i <count($listado) ; $i++) {
            foreach ($listado[$i] as $key => $value) {
                 $this->db
                     ->set('dp.linea_agrupacion' , $linea)
                     ->where('dp.id' , $value)
                     ->where('dp.tlc' , $tlc)
                     ->update('duarx.dpr as dp');
            }
        }

    }

    public function obtener_listado_productos($numero_file,$partida_arancelaria)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-','',$importador->no_identificacion);

        //Traer listado de Productos de DUARX.PRODUCTO_IMPORTADOR
        $listado = $this->db
                        ->select('dp.id')
                        ->join('duarx.producto_importador as pi', "dp.codigo_producto = pi.codproducto and pi.importador = '$importador->no_identificacion'  and pi.partida ='$partida_arancelaria'",'inner')
                        ->where('dp.id_file' , $importador->id)
                        ->get('duarx.dpr as dp')
                        ->result();


        //echo $this->db->last_query();exit();
        return $listado;
    }

    public function obtener_datos_file($numero_file)
    {

        return $this->db
                     ->select('f.id as id, f.cliente_hijo_id as cliente_hijo_id , ch.no_identificacion as no_identificacion')
                     ->where('f.c807_file', $numero_file)
                     ->join('gacela.cliente_hijo as ch' , 'ch.id = f.cliente_hijo_id' ,'inner')
                     ->get('gacela.file  as f')
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


    public function buscar_usuarios($numero_file)
    {
        $query = $this->db
                      ->select('us.mail, us.nombre')
                      ->join('gacela.master as ma' , 'ma.id = f.master_id' ,'inner')
                      ->join('csd.usuario as us' , 'us.empresa = ma.empresa' , 'inner')
                      ->where('f.c807_file', $numero_file)
                      ->where('us.tipo_usuario' , 1)
                      ->get('gacela.file as f')
                      ->result();

        return $query;
    }

    public function buscar_usuario_aforador($numero_file)
    {
        $query = $this->db
                      ->select('us.mail, us.nombre')
                      ->join('csd.usuario as us' , 'us.usuario = f.usuario_id' , 'inner')
                      ->where('f.c807_file', $numero_file)
                      //->where('us.tipo_usuario' , 1)
                      ->get('gacela.file as f')
                      ->result();

        return $query;
    }

}

/* End of file ModelName.php */
