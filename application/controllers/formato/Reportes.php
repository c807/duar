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
		$detalles   = $rep->verdetallepoliza();
		$documentos = $rep->verdocumentos();

		$generales = new General;

		$generales->año          = $rep->duar->anio;
		$generales->aduana       = $rep->duar->codigoaduana;
		$generales->agente       = $rep->duar->agenteaduanal;
		$generales->narch        = $rep->duar->referencia;
		$generales->NRO_REG      = $rep->duar->referencia;
		$generales->imodelod     = $rep->duar->modelo;
		$generales->manifiesto   = $rep->duar->manifiesto;
		$generales->cant_art     = count($detalles);
		$generales->t_bultos     = $rep->duar->bultos;
		$generales->nit_emp      = str_replace("-","",$rep->duar->nit);
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
		$generales->adu_fro      = $rep->duar->codigoaduana;
		$generales->ilocalm      = $rep->duar->localizacion_mercancia;
		$generales->t_flete      = $rep->duar->flete;
		$generales->t_seguro     = $rep->duar->seguro;
		$generales->t_otros      = ($rep->duar->otros == 0) ? '' : $rep->duar->otros;
		$generales->iconsign     = $rep->duar->importador_exportador;
		$generales->dir1         = substr($rep->duar->direccion, 0,35);
		$generales->dir2         = substr($rep->duar->direccion, 36,35);
		$generales->dir3         = substr($rep->duar->direccion, 71,35);
		$generales->fecha_reg    = date("d/m/Y");
		$encabezado = $generales->crear();


		$item     = new Item;
		foreach ($detalles as $row) {

			$item->imodelod    = $rep->duar->modelo;
			$item->cont01      = $row->contenedor1;
			$item->cont02      = $row->contenedor2;
			$item->cont03      = $row->contenedor3;
			$item->cont04      = $row->contenedor4;
			$item->quo_lic     = ($row->tlc == 1) ? $row->quota : "      ";
			$item->acuerdo     = ($row->tlc == 1) ? $row->acuerdo :"        ";
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

		$doc = new Documento;

		$total = count($documentos);
		$doc->tot_docs = $total;
		foreach ($documentos as $key => $row) {
			$doc->correlativo = $key + 1;
			$doc->codigo      = $row->codigo;
			$doc->descrip     = $row->descripcion;
			$doc->numero_doc  = $row->numero;
			$doc->zfec        = formatofecha($row->fecha,2);
			$doc->agregar();
		}
		$xdoc = $doc->retdocs();

		$texto = $encabezado.$xitems.$xdoc;

		$filename = $generales->narch . ".SAD";

		$archivo = fopen("public/fls/sad/{$filename}", 'a');
		fputs($archivo, $texto);
		fclose($archivo);

		redirect("formato/reportes/descargar/{$generales->narch}");
	}

	function descargar($nombre) {
		$nombre_fichero = getcwd()."/public/fls/sad/{$nombre}.SAD";

		if (file_exists($nombre_fichero)) {

		    $url = base_url("public/fls/sad/{$nombre}.SAD");

			header("Content-disposition: attachment; filename={$nombre}.SAD");
			header("Content-type: application/octet-stream");
			readfile($url);

			unlink($nombre_fichero);
		} else {
			echo "No se ha generado el archivo";
		}
	}
}
?>