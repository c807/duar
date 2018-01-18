<?php
include 'lib/sad_gen.php';
include 'lib/sad_item.php';
include 'lib/sad_doc.php';

//****************GENERAR EL ENCABEZADO O DATOS GENERALES DE LA DM****************************************
$generales = new General;
//asignar los valores a los parametros.
$generales->año          = '2017'; //año .
$generales->aduana       = '06'; //codigo de la aduana de registro de la DM. 
$generales->agente       = '040'; //codigo del agente aduanal.
$generales->narch        = '040347315'; //Numero de referencia o correlativo de la declaracion.
$generales->NRO_REG      = '040347315'; //Numero de referencia o correlativo de la declaracion.
$generales->imodelod     = "IM 5"; //modelo de la declaracion(IM 5, EX 3, IM 4, Etc.).
$generales->manifiesto   = ""; //numero de manifiesto electronico
$generales->cant_art     = "2"; //Total de Articulos o Items de la declaracion.
$generales->t_bultos     = "17"; //Total de Bultos de la declaracion. (sumatoria de bultos de Items)
$generales->nit_emp      = "05150207081019"; //NIT ya sea del exportador o destinatario.
$generales->pais_proc    = "CN"; //Pais de Ultima Procedencia;
$generales->paisdestproc = "SV"; //Pais Destino o procedencia segun el modelo de la declaracion.
$generales->ipaise       = "CN"; //Pais de Exportacion.
$generales->idenp        = "UPS"; //Registro del transportista.
$generales->ipaism       = "SV"; //Pais de Transporte.
$generales->idfurg       = "1"; //Identificador de contenedores 0 (si) ó 1 (no)
$generales->icond_e      = "FOB"; //Incoterms o Condicion de Entrega.
$generales->t_fob        = "4103.00"; //Total FOB
$generales->mod_tra      = "2"; //Codigo del modo de transporte 1-Terrestre, etc.
$generales->ildescarg    = "SVCOM"; //Codigo de la zona de caegue o descargue.
$generales->tipo_liq     = "3"; //Presentacion o modalidad.
$generales->adu_fro      = "03"; //Aduana de entrada o Salida segun el modelo de la declaracion.
$generales->ilocalm      = "0301"; //Codigo de Localizacion de las mercancias.
$generales->t_flete      = "1680.35"; //Total de Flete, SI EL FLETE ES CERO DEJAR EL CAMPO VACIO.
$generales->t_seguro     = "61.54"; // Total Seguro SI ES CERO DEJAR EL CAMPO VACIO.
$generales->t_otros      = ""; //Total Otros Gastos SI ES CERO DEJAR EL CAMPO VACIO.
$generales->iconsign     = "RAMKP LTD."; //Nombre del Exportador o Destinatario segun el modelo seleccionado.
$generales->dir1         = "D3-601 LINGHUI CHUNGZHAN BUSSINESS"; //Direccion 1
$generales->dir2         = "CENTER No 38 HU CAI ROAD, DONGPU"; //Direccion 2
$generales->dir3         = ""; //Direccion 3
$generales->fecha_reg    = "22/12/2017"; //Fecha de registro de la DM DD/MM/YYYY

//Crear el encabezado
$encabezado = $generales->crear();

//****************GENERAR LOS ITEMS DE LA DM*****************************************
//Esto lo pueden hacer con FOREACH que recorra los items
$item = new Item;
$item->imodelod = "IM 5"; //Importante proporcionar nuevamente el modelo de la declaracion.
$item->cont01 = "CONTENEDOR1"; //Dato del contenedor 1
$item->cont02 = ""; //Dato del contenedor 2
$item->cont03 = ""; //Dato del contenedor 3
$item->cont04 = ""; //Dato del contenedor 4
$item->quo_lic = "      "; //Proporcionar solo si aplica TLC de lo contrario 6 espacios en blanco.
$item->art = "1"; //Numero de correlativo del Item.
$item->partida = "48211000"; //Partida o Inciso Arancelario
$item->ptdadi = "000"; //Extencion de la partida Arancelaria
$item->pais_orig = "CN"; //Pais de Origen
$item->peso_bruto = "114.50"; //Peso Bruto
$item->bultos = "14"; //Bultos
$item->cod_bultos = "PK"; //Embalaje
$item->marca = "S/M"; //Marcas
$item->numero = "S/N"; //Numeros
$item->desc_ptda = "ETIQUETAS DE CARTON IMPRESAS (HANG TANG) PCS"; //Descripcion de las mercancias
$item->regimen = "5200"; //Codigo del Regimen Extendido (Este se captura en los datos generales)
$item->sub_reg = "000"; //Codigo del Subregimen o Regimen Adicional (Este se captura en los datos generales)
$item->peso_neto = "114.50"; //Peso Neto
$item->doct = "5037634327"; //Documentos de Transporte
$item->unidad_supl = "54700.00"; //Cuantia
$item->fob_item = "2460.00"; //Valor FOB
$item->agregar();

//Mismo proceso repetir para agregar los items deseados
$item = new Item;
$item->imodelod = "IM 5"; //Importante proporcionar nuevamente el modelo de la declaracion.
$item->cont01 = ""; //Dato del contenedor 1
$item->cont02 = ""; //Dato del contenedor 2
$item->cont03 = ""; //Dato del contenedor 3
$item->cont04 = ""; //Dato del contenedor 4
$item->quo_lic = "      "; //Proporcionar solo si aplica TLC de lo contrario 6 espacios en blanco.
$item->art = "2"; //Numero de correlativo del Item.
$item->partida = "39269099"; //Partida o Inciso Arancelario
$item->ptdadi = "000"; //Extencion de la partida Arancelaria
$item->pais_orig = "CN"; //Pais de Origen
$item->peso_bruto = "114.50"; //Peso Bruto
$item->bultos = "3"; //Bultos
$item->cod_bultos = "PK"; //Embalaje
$item->marca = "S/M"; //Marcas
$item->numero = "S/N"; //Numeros
$item->desc_ptda = "MANUFACTURAS PLASTICAS (PCS)"; //Descripcion de las mercancias
$item->regimen = "5200"; //Codigo del Regimen Extendido (Este se captura en los datos generales)
$item->sub_reg = "000"; //Codigo del Subregimen o Regimen Adicional (Este se captura en los datos generales)
$item->peso_neto = "114.50"; //Peso Neto
$item->doct = "5037634327"; //Documentos de Transporte
$item->unidad_supl = "29100.00"; //Cuantia
$item->fob_item = "1643.00"; //Valor FOB
$item->agregar();

//crear todos los items
$items = Item::retitems();

//****************GENERAR LOS DOCUMENTOS ADJUNTOS*****************************************
$GLOBALS['tot_docs'] = "4"; //Importante asignar el numero de total de Documentos Adjuntos.

//Repetir el proceso para agregar todos los items se puede hacer con un FOREACH con los datos de la BD.
//MODBRK siempre solicita como primer documento siempre que se agreue el 049 (Factura).
$doc = new Documento;
$doc->correlativo = "1"; //Numero correlativo incrementable con cada Documento agregado
$doc->codigo = "049";  // Codigo del documento
$doc->descrip = "FACTURA"; // Descripcion del documento.
$doc->numero_doc = "AAPI1504197"; // Numero del documento.
$doc->zfec = "29/09/2017"; // Fecha del documento (DD/MM/YYY/)
$doc->agregar();

$doc = new Documento;
$doc->correlativo = "2"; //Numero correlativo incrementable con cada Documento agregado
$doc->codigo = "056";  // Codigo del documento
$doc->descrip = "GUIA AEREA"; // Descripcion del documento.
$doc->numero_doc = "5037634327"; // Numero del documento.
$doc->zfec = "30/09/2017"; // Fecha del documento (DD/MM/YYY/)
$doc->agregar();

$doc = new Documento;
$doc->correlativo = "3"; //Numero correlativo incrementable con cada Documento agregado
$doc->codigo = "028";  // Codigo del documento
$doc->descrip = "CONTROL DE CARGA"; // Descripcion del documento.
$doc->numero_doc = "3.1103273"; // Numero del documento.
$doc->zfec = "06/10/2017"; // Fecha del documento (DD/MM/YYY/)
$doc->agregar();

$doc = new Documento;
$doc->correlativo = "4"; //Numero correlativo incrementable con cada Documento agregado
$doc->codigo = "008";  // Codigo del documento
$doc->descrip = "AUTORIZACION DEL MINISTERIO DE ECONOMIA ( DPA )"; // Descripcion del documento.
$doc->numero_doc = "AE938.DO196.TO381 DEL 20/10/2008"; // Numero del documento.
$doc->zfec = ""; // Fecha del documento (DD/MM/YYY/)
$doc->agregar();

$docs = Documento::retdocs();

//*********SALIDA DE DATOS************************
echo $encabezado . $items . $docs;

$filename = $generales->narch . ".SAD";

header("Content-type: application/txt");
header("Content-Disposition: attachment; filename='$filename'");

?>