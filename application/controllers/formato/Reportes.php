<?php 
class Reportes extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		
			$this->load->model('Reporte_model');
	
	}

	function index() {}

	function archivosad($file) {
		include "application/libraries/sad/lib/Sad_gen.php";
		include "application/libraries/sad/lib/sad_item.php";
		include "application/libraries/sad/lib/sad_doc.php";
		/*$this->load->library("sad/lib/sad_item");
		$this->load->library("sad/lib/sad_doc");*/

		$rep = new Reporte_model(array('file' => $file));

		
		$generales = new General;
		
		$generales->año          = $rep->duar->anio;
		$generales->aduana       = $rep->duar->aduana_entrada_salida; 
		$generales->agente       = '040';
		$generales->narch        = $rep->duar->referencia;
		$generales->NRO_REG      = $rep->duar->referencia;
		$generales->imodelod     = $rep->duar->modelo;
		$generales->manifiesto   = $rep->duar->manifiesto;
		$generales->cant_art     = $rep->duar->cant_arti;
		$generales->t_bultos     = $rep->duar->bultos;
		$generales->nit_emp      = $rep->duar->nit;
		$generales->pais_proc    = $rep->duar->pais_proc;
		$generales->paisdestproc = $rep->duar->pais_destino;
		$generales->ipaise       = $rep->duar->pais_export;
		$generales->idenp        = $rep->duar->registro_transportista;
		$generales->ipaism       = $rep->duar->pais_trasporte;
		$generales->idfurg       = $rep->duar->contenedor;
		$generales->icond_e      = $rep->duar->incoterm; 
		$generales->t_fob        = $rep->duar->fob;
		$generales->mod_tra      = $rep->duar->mod_transp;
		$generales->ildescarg    = $rep->duar->lugar_carga;
		$generales->tipo_liq     = $rep->duar->presentacion;
		$generales->adu_fro      = $rep->duar->aduana_entrada_salida;
		$generales->ilocalm      = $rep->duar->localizacion_mercancia;
		$generales->t_flete      = $rep->duar->flete;
		$generales->t_seguro     = $rep->duar->seguro;
		$generales->t_otros      = ($rep->duar->otros == 0) ? '' : $rep->duar->otros;
		$generales->iconsign     = $rep->duar->nombre;
		$generales->dir1         = substr($rep->duar->direccion, 0,35); 
		$generales->dir2         = substr($rep->duar->direccion, 36,35);
		$generales->dir3         = substr($rep->duar->direccion, 71,35);
		$generales->fecha_reg    = date("d/m/Y");
		$encabezado = $generales->crear();

		$detalles = $rep->verdetallepoliza();
		$item     = new Item;
		foreach ($detalles as $row) {
			
			$item->imodelod    = $rep->duar->modelo;
			$item->cont01      = $row->contenedor1;
			$item->cont02      = $row->contenedor2;
			$item->cont03      = $row->contenedor3;
			$item->cont04      = $row->contenedor4;
			$item->quo_lic     = ($row->tlc == 1) ? 1 : "      ";
			$item->art         = $row->item;
			$item->partida     = $row->partida;
			$item->ptdadi      = $row->comple;
			$item->pais_orig   = $row->origen;
			$item->peso_bruto  = $row->peso_bruto;
			$item->bultos      = $row->no_bultos; 
			$item->cod_bultos  = $row->tipo_bulto;
			$item->marca       = $row->marcas;
			$item->numero      = $row->numeros; 
			$item->desc_ptda   = $row->descripcion;
			$item->regimen     = $rep->duar->reg_extendido;
			$item->sub_reg     = $rep->duar->reg_adicional;
			$item->peso_neto   = $row->peso_neto;
			$item->doct        = $row->doc_transp;
			$item->unidad_supl = $row->cuantia;
			$item->fob_item    = $row->fob;
			$item->agregar();

		}
		$xitems = $item->retitems();
		
		$documentos = $rep->verdocumentos();

		$doc = new Documento;

		$total = count($documentos);
		$doc->tot_docs = $total;
		foreach ($documentos as $row) {
			$doc->correlativo = $row->documento;
			$doc->codigo      = $row->tipo_documento;
			$doc->descrip     = $row->descripcion;
			$doc->numero_doc  = $row->numero;
			$doc->zfec        = formatofecha($row->fecha,2);
			$doc->agregar();
		}
		$xdoc = $doc->retdocs();

		echo $encabezado.$xitems.$xdoc;

		$filename = $generales->narch . "-formato.SAD";

		header("Content-type: application/txt");
		header("Content-Disposition: attachment; filename='$filename'");
	}
}
?>