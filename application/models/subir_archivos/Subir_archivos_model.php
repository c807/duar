<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Subir_archivos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function consulta($id_file, $no_identificacion = null, $opcion = null)
    {
      
        if (isset($no_identificacion)) {
            if ($opcion == 1) {
                $query = $this->db
                                      ->select("d.id , d.codigo_producto, d.descripcion,   d.num_factura , d.tlc , d.cuantia")
                                      ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                                      ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$no_identificacion'", 'left')
                                      ->where('du.partida IS  NULL')
                                      ->where('f.id', $id_file)
                                      ->where('d.pais_id',  $_SESSION['pais_id'])
                                      ->order_by('d.num_factura, d.id')
                                      ->get('gacela.file as f')
                                     ->result();
            } elseif ($opcion == 2) {
                /* d.num_factura as 'Numero Factura' , d.tlc as TLC, f.c807_file as 'File' , d.cuantia, d.proveedor ")*/
                $query = $this->db
                                      ->select("d.id as Id , d.codigo_producto as 'Codigo Producto' , d.descripcion as Descripcion, du.partida as 'Partida Arancelaria', 
                                       d.num_factura as 'Numero Factura' , d.tlc as TLC, f.c807_file as 'File' , d.cuantia ")
                                      ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                                      ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$no_identificacion'", 'left')
                                      ->where('f.id', $id_file)
                                      ->where('d.pais_id',  $_SESSION['pais_id'])    
                                      ->order_by('d.id')
                                      ->get('gacela.file as f')
                                      ->result();
            } else {
                //Verificar si archivo que se subio tiene productos SIN CLASIFICAR
                $query = $this->db
                               ->select("count(*) as cantidad")
                               ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                               ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$no_identificacion'", 'left')
                               ->where('du.partida IS  NULL')
                               ->where('f.id', $id_file)
                               ->where('d.pais_id',  $_SESSION['pais_id']) 
                               ->order_by('d.descripcion')
                               ->get('gacela.file as f')
                               ->result();
            }
        } else {
        }

        return $query;
    }

    public function existe_factura($data)
    {
        $importador = $this->obtener_datos_file($data['num_file']);
        $query = $this->db
                ->select('count(*) as cantidad')
                ->where('id_file', $importador->id)
                ->where('num_factura', $data['num_factura'])
                ->get('duarx.dpr')
                ->row();

        return $query;
    }

    public function insert($data)
    {
        $this->db->insert('duarx.dpr', $data);
    }


    public function crear_listado_polizas($data)
    {
        if (isset($data['id_usuario_clasificador'])) {
            date_default_timezone_set("America/Guatemala");
            //0 es fecha de asignacion y 1 es finalizacion
            $fecha = "";
            if ($data['fecha'] == 0) {
                $fecha = 'lp.fecha_asignacion';
            } else {
                $fecha = 'lp.fecha_finalizacion';
            }

            $this->db
                     ->set('lp.id_usuario_clasificador', $data['id_usuario_clasificador'])
                     ->set($fecha, date("Y/m/d h:i:s"))
                     ->where('lp.id_file', $data['id_file'])
                     ->update('duarx.listado_polizas as lp');
        } else {
            $query = $this->db
                          ->select('count(*) as cantidad')
                          ->where('lp.id_file', $data['id_file'])
                          ->get('duarx.listado_polizas as lp')
                          ->result();
     
            if ($query[0]->cantidad == 0) {
                $this->db->insert('duarx.listado_polizas', $data);
            }
        }
    }

    public function polizas_no_clasificadas()
    {
        $query = $this->db
                      ->select("f.c807_file as Id , f.c807_file as 'Numero file' , lp.fecha_importacion as 'Fecha Importacion' ")
                      ->join('gacela.file  as f', 'f.id = lp.id_file', 'inner')
                      ->where('lp.id_usuario_clasificador', 0)
                      ->get('duarx.listado_polizas as lp')
                      ->result();

        return $query;
    }

    
    public function traer_informacion_producto($id_reg)
    {

        //->select('id , id_file  , codigo_producto, descripcion, num_factura, proveedor') quite esta linea
        return $this->db->where('id', $id_reg)
                        ->get('dpr')
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
        if (verDato($args, "codigo_extendido")) {
            $datos['codigo_extendido'] = $args["codigo_extendido"];
        }
        if (verDato($args, "descripcion_generica")) {
            $datos['descripcion_generica'] = $args["descripcion_generica"];
        }

        if (verDato($args, "nombre_proveedor")) {
            $datos['nombre_proveedor'] = $args["nombre_proveedor"];
        }

        if (verDato($args, "usuario")) {
            $datos['usuario'] = $args["usuario"];
        }
        $datos['funcion'] = $args["funcion"];
        $datos['observaciones'] = $args["observaciones"];
        $datos['marca'] = $args["marca"];

        $datos['paisorigen'] = $args["paisorigen"];
        $datos['tlc'] = $args["tlc"];
        $datos['permiso'] = $args["permiso"];
        $datos['fito'] = $args["fito"];
        $datos['idestado'] = $args["idestado"];
        $datos['idunidad'] = $args["idunidad"];
        $datos['pais_id'] = $_SESSION['pais_id'];
        $datos['pais_adquisicion'] = $args["pais_adquisicion"];
        $datos['pais_procedencia'] = $args['pais_procedencia'];

     
        $this->db->insert('duarx.producto_importador', $datos);
    }
    public function actualizar_dpr($id, $data)
    {
        $this->db
        ->set('tlc', $data['tlc'])
        ->set('permiso', $data['permiso'])
        ->set('partida', $data['partida_arancelaria'])
        ->set('descripcion', $data['descripcion_generica'])
        ->set('fito', $data['fito'])
        ->set('idestado', $data['idestado'])
        ->set('idunidad', $data['idunidad'])
        ->set('pais_adquisicion', $data['pais_adquisicion'])
        ->set('pais_procedencia', $data['pais_procedencia'])
        ->where('id', $id)
        ->update('duarx.dpr');
    }
    
    public function generar_excel($numero_file, $doc_transporte)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-', '', $importador->no_identificacion);
        
        return  $this->db
                    ->select("  '' as 'Codigo Producto', d.tlc as tlc, '' as acuerdo, '' as cuota,
                    'S/M' as marca , 'S/N' as numero, du.partida as partida,  '$doc_transporte' as 'Documento de Transporte' , 'PK' AS 'Tipo Bulto', 
                    d.pais_origen as pais , 0 as  'peso_bruto' , 0 as 'peso_neto', sum(d.cuantia) as cuantia,  sum(d.total) as fob, 
                    0 as flete, 0 as seguro , 0 as otros, sum(d.total) as cif , 0 as 'numero_de_bultos', du.descripcion_generica  as descripcion, '' as contenedor1
                    , '' as contenedor2, '' as contenedor3, '' as contenedor4, du.codigo_extendido  , 0 as linea")
                    ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$importador->no_identificacion'", 'left')
                    ->where('f.c807_file', $numero_file)
                    ->group_by('du.partida, du.codigo_extendido , d.tlc')
                    ->order_by('du.partida ')
                    ->get('gacela.file as f')
                    ->result();
    }

    public function generar_excel_sidunea($numero_file, $doc_transporte)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-', '', $importador->no_identificacion);
        
        return  $this->db
                    ->select(" 0 as itemnumber , concat(du.partida,du.codigo_extendido) as commoditycode, sum(d.cuantia) as supplementaryunits,
                    d.pais_origen as countryoforigin , 0 as  grossmass , d.tlc as tlc , sum(d.total) as fob ,   '' as preference, 
                    '' as internal , '' as moneda, '' as external , '' as moneda ,  '' as insurance , '' as moneda, '' as othercosts , '' as moneda,
                    '' as deduction , '' as moneda, '' as r , '' as s , 'S/M' as marca , du.descripcion_generica as commercialdescripcionofgoods,
                    '' as 'summarydeclaration' , 0 as netweight , du.partida")
                    ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$importador->no_identificacion'", 'left')
                    ->where('f.c807_file', $numero_file)
                    ->group_by('du.partida, du.codigo_extendido , d.tlc')
                    ->order_by('du.partida ')
                    ->get('gacela.file as f')
                    ->result();
    }

    public function generar_excel_dva($numero_file, $doc_transporte)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-', '', $importador->no_identificacion);
        
        return  $this->db
                    ->select(" 0 as itemnumber , concat(du.partida,du.codigo_extendido) as commoditycode, sum(d.cuantia) as supplementaryunits,
                    d.pais_origen as countryoforigin ,  sum(d.total) as fob ,
                    'S/M' as marca , du.descripcion_generica as commercialdescripcionofgoods, du.partida, d.num_factura")
                    ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$importador->no_identificacion'", 'left')
                    ->where('f.c807_file', $numero_file)
                    ->group_by('du.partida, du.codigo_extendido , d.num_factura')
                    ->order_by('d.num_factura ')
                    ->get('gacela.file as f')
                    ->result();
    }



    public function generar_rayado($numero_file)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-', '', $importador->no_identificacion);
        
        $query =  $this->db
                    ->select(" d.linea_agrupacion as linea ,  d.codigo_producto as 'Codigo_Producto', d.num_factura , d.tlc as tlc,  du.partida, 
                     d.pais_origen as pais ,  d.cuantia as cuantia,  d.total as fob, mid(du.descripcion,1,50) as descripcion")
                    ->join('duarx.dpr as d', 'd.id_file =  f.id', 'inner')
                    ->join('duarx.producto_importador as du', "du.codproducto = d.codigo_producto and du.importador = '$importador->no_identificacion'", 'left')
                    ->where('f.c807_file', $numero_file)
                    ->order_by('d.id ')
                    ->get('gacela.file as f')
                    ->result();

        //echo $this->db->last_query();exit();
    
        return $query;
    }
    
    public function contar_registros($id_file)
    {
        return  $this->db
                    ->select('count(*) as total')
                    ->join('dpr as d', 'd.id_file =  f.id', 'inner')
                    ->join('dua as du', 'du.codigo_producto = d.codigo_producto', 'left')
                    ->where('du.partida_arancelaria IS NULL')
                    ->where('f.c807_file', $id_file)
                    ->get('file as f')
                    ->result();
    }

    public function generar_excel_no_agrupada($id_file)
    {
        return $this->db
                    ->select('d.id ,  d.codigo_producto, d.descripcion , du.partida_arancelaria, d.cuantia, d.precio_unitario, d.total')
                    ->join('dpr as d', 'd.id_file =  f.id', 'inner')
                    ->join('dua as du', 'du.codigo_producto = d.codigo_producto', 'inner')
                    ->where('du.partida_arancelaria IS NOT NULL')
                    ->where('f.c807_file', $id_file)
                    ->get('file as f')
                    ->result();
    }


    public function actualizar_linea_agrupacion($numero_file, $partida_arancelaria, $linea, $tlc)
    {
        $listado = $this->obtener_listado_productos($numero_file, $partida_arancelaria);

        for ($i=0; $i <count($listado) ; $i++) {
            foreach ($listado[$i] as $key => $value) {
                $this->db
                     ->set('dp.linea_agrupacion', $linea)
                     ->where('dp.id', $value)
                     ->where('dp.tlc', $tlc)
                     ->update('duarx.dpr as dp');
            }
        }
    }

    public function obtener_listado_productos($numero_file, $partida_arancelaria)
    {
        $importador = $this->obtener_datos_file($numero_file);
        $importador->no_identificacion = str_replace('-', '', $importador->no_identificacion);

        //Traer listado de Productos de DUARX.PRODUCTO_IMPORTADOR
        $listado = $this->db
                        ->select('dp.id')
                        ->join('duarx.producto_importador as pi', "dp.codigo_producto = pi.codproducto and pi.importador = '$importador->no_identificacion'  and pi.partida ='$partida_arancelaria'", 'inner')
                        ->where('dp.id_file', $importador->id)
                        ->get('duarx.dpr as dp')
                        ->result();


        //echo $this->db->last_query();exit();
        return $listado;
    }

    public function obtener_datos_file($numero_file)
    {
        if ( $_SESSION['pais_id']==2)//El Salvador
        {
            return $this->db
            ->select('f.id as id, c.nit as no_identificacion')
            ->where('f.c807_file', $numero_file)
            ->join('csd.cliente as c', 'c.cliente = f.cliente', 'inner')
            ->get('gacela.file  as f')
            ->row();
        }
        
        
        if ( $_SESSION['pais_id']==3)//Honduras
        {
            return $this->db
            ->select('f.id as id, c.no_identificacion as no_identificacion')
            ->where('f.c807_file', $numero_file)
            ->join('gacela.cliente_hijo  c', 'c.id = f.cliente_hijo_id', 'inner')
            ->get('gacela.file  f')
            ->row();
        }

      
    }

    public function traer_paises($arreglo)
    {

        // id_file , partida, importador, codproducto, id_file, codigo_producto, pais_origen
        if (isset($arreglo['partida'])) {
            $arreglo['cliente']->no_identificacion = str_replace('-', '', $arreglo['cliente']->no_identificacion);
            $query = $this->db
                       ->distinct()
                       ->select('iso2')
                       ->join('duarx.dpr', 'codigo_producto = codproducto and id_file = ' . $arreglo['cliente']->id, 'inner')
                       ->join('gacela.pais', 'nombre = pais_origen', 'inner')
                       ->where('partida', $arreglo['partida'])
                       ->where('importador', $arreglo['cliente']->no_identificacion)
                       ->get('duarx.producto_importador')
                       ->result();

            //echo $this->db->last_query();exit();
        }
        // echo $this->db->last_query();exit();

        return $query;
    }

    public function traer_descripcion_productos($arreglo)
    {

        // id_file , partida, importador, codproducto, id_file, codigo_producto, pais_origen
        if (isset($arreglo['partida'])) {
            $arreglo['cliente']->no_identificacion = str_replace('-', '', $arreglo['cliente']->no_identificacion);
            $query = $this->db
                       ->select('dp.descripcion')
                       ->join('duarx.dpr as dp', 'codigo_producto = codproducto and id_file = ' . $arreglo['cliente']->id, 'inner')
                       ->where('partida', $arreglo['partida'])
                       ->where('importador', $arreglo['cliente']->no_identificacion)
                       ->where('dp.tlc', $arreglo['tlc'])
                       ->get('duarx.producto_importador')
                       ->result();
            
            return $query;
        }
        //echo $this->db->last_query();exit();
    }

    public function buscar_usuarios($numero_file)
    {
        $query = $this->db
                      ->select('us.mail, us.nombre')
                      ->join('gacela.master as ma', 'ma.id = f.master_id', 'inner')
                      ->join('csd.usuario as us', 'us.empresa = ma.empresa', 'inner')
                      ->where('f.c807_file', $numero_file)
                      ->where('us.tipo_usuario', 1)
                      ->get('gacela.file as f')
                      ->result();

        return $query;
    }


    public function buscar_usuario_aforador($numero_file)
    {
        $query = $this->db
                      ->select('us.mail, us.nombre')
                      ->join('csd.usuario us', 'us.usuario = f.usuario_id', 'inner')
                      ->where('f.c807_file', $numero_file)
                      //->where('us.tipo_usuario' , 1)
                      ->get('gacela.file f')
                      ->result();

        return $query;
    }

    public function verificar_partida($codigo, $importador, $pais_id)
    {
        $query = $this->db
        ->select('partida, tlc, permiso, descripcion_generica, idestado, idunidad, fito, pais_adquisicion, pais_procedencia')
        ->where('codproducto', $codigo)
        ->where('importador', $importador)
        ->where('pais_id', $pais_id)
        ->get('duarx.producto_importador')
        ->result();
        return $query;
    }

    public function lista_retaceo($file)
    {
        $query = $this->db
        ->select('partida, sum(cuantia) AS cuantia, sum(total+flete+seguro+otros_gastos) as total, sum(peso_bruto) peso_bruto, sum(peso_neto) peso_neto, sum(bultos) bultos, pais_origen,tlc,partida,group_concat(DISTINCT descripcion) as nombre, codigo_producto, documento_transporte,idestado,idunidad,fito,sum(total),pais_adquisicion, pais_procedencia, ref_tlc, marcas_uno, marcas_dos, cuota, u_suplementarias_uno, u_suplementarias_dos, referencia_licencia, embalaje')
        ->where('id_file', $file)
        ->group_by('partida,tlc')
        ->get('duarx.dpr')
        ->result();

        return $query;
    }

    public function dpr_clasificado($file)
    {
        $query = $this->db
        ->select('*')
        ->where('id_file', $file)
        ->get('duarx.dpr')
        ->result();

        return $query;
    }

    public function consulta_facturas($file)
    {
        $query = $this->db
     ->select('partida,sum(cuantia) AS cuantia, sum(total) as total, sum(peso_bruto) peso_bruto, sum(peso_neto) peso_neto, sum(bultos) bultos, sum(flete) flete, sum(seguro) seguro, sum(otros_gastos) otros_gastos, pais_origen,tlc,partida,descripcion as nombre,num_factura')
     ->where('id_file', $file)
     ->group_by('num_factura,tlc')
     ->get('duarx.dpr')
     ->result();

        return $query;
    }
    public function consulta_origenes($file)
    {
        $query = $this->db
     ->select('partida,sum(cuantia) AS cuantia, sum(total) as total, sum(peso_bruto) peso_bruto, sum(peso_neto) peso_neto, sum(bultos) bultos, sum(flete) flete, sum(seguro) seguro, sum(otros_gastos) otros_gastos, pais_origen,tlc,partida,descripcion as nombre,num_factura, permiso')
     ->where('id_file', $file)
     ->group_by('partida,pais_origen,tlc,permiso')
     ->get('duarx.dpr')
     ->result();

        return $query;
    }
    public function lista_origen($id)
    {
        $query = $this->db
        ->select('partida,sum(cuantia) AS cuantia, sum(total) as total, pais_origen,tlc')
        ->where('partida', $id)
        ->group_by('pais_origen,tlc')
        ->get('duarx.dpr')
        ->result();

        return $query;
    }

    
    public function consulta_file($file)
    {
        $query = $this->db->select('*')
           ->where('id_file', $file)
           ->get('duarx.dpr')
           ->result();
        return $query;
    }

    public function guardar_pesos($monto_total, $pb, $id, $total_item, $pn, $bultos)
    {
        $peso_bruto=($pb/$monto_total)*$total_item;
        $peso_neto=($pn/$monto_total)*$total_item;
        $total_bultos=($bultos/$monto_total)*$total_item;
        $this->db
        ->set('peso_bruto', $peso_bruto)
        ->set('peso_neto', $peso_neto)
        ->set('bultos', $total_bultos)
        ->where('id', $id)
        ->update('duarx.dpr');
    }

    
    public function get_id_file($id)
    {
        $pro = $this->db->where('c807_file', $id)
                            ->get('gacela.file')
                            ->row();
        return $pro;
    }

    
    public function guardar_items_dpr($data)
    {
        $this->db->insert('detalle', $data);
        return $this->db->affected_rows() > 0;
    }

    public function lista_cambiar_origen($file)
    {
        $query = $this->db
        ->select('partida, cuantia, total, peso_bruto, peso_neto, bultos, pais_origen, tlc, partida, descripcion as nombre,id,item')
        ->where('id_file', $file)
        ->get('duarx.dpr')
        ->result();

        return $query;
    }

    public function cambiar_origen($pais, $id)
    {
        $this->db
        ->set('pais_origen', $pais)
        ->where('id', $id)
        ->update('duarx.dpr');
    }

    
    public function rayar($id, $pa, $doc)
    {
        $this->db
        ->set('item', $id)
        ->set('documento_transporte', $doc)
        ->where('partida', $pa)
        ->update('duarx.dpr');
    }


    public function eliminar_dpr($id)
    {
        $this->db->where('id_file', $id);
        $this->db->where('pais_id', $_SESSION['pais_id']);
        $this->db->delete('duarx.dpr');
    }
}

/* End of file ModelName.php */