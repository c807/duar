<?php 
class Reportes extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		
			$this->load->model('Reporte_model');
	
	}

	function index() {}

	function mobrk($id) {
		$rep = new Reporte_model(array('file' => $id));

		require_once(APPPATH.'libraries/PHPEXCEL/PHPExcel.php');
    	require_once(APPPATH.'libraries/PHPEXCEL/PHPExcel/IOFactory.php');
    	$objPHPExcel = PHPExcel_IOFactory::load(APPPATH."../public/fls/formato_poliza.xls");

    	if($rep->duar){
			$objPHPExcel->setActiveSheetIndex(0)
			## ENCABEZADO DEL DUA
						->setCellValue("A2", $rep->duar->anio)
						->setCellValue("B2", $rep->duar->aduana_entrada_salida)
						->setCellValue("C2", $rep->duar->declarante)
						->setCellValue("D2", $rep->duar->referencia)
						->setCellValue("E2", $rep->duar->cero)
						->setCellValue("F2", $rep->duar->modelo)
						->setCellValue("G2", $rep->duar->cant_arti)
						->setCellValue("H2", $rep->duar->nit)
						->setCellValue("I2", $rep->duar->bultos)
						->setCellValue("J2", $rep->duar->pais_proc)
						->setCellValue("K2", $rep->duar->pais_export)
						->setCellValue("L2", $rep->duar->pais_destino)
						->setCellValue("M2", $rep->duar->registro_transportista)
						->setCellValue("N2", $rep->duar->pais_origen)
						->setCellValue("O2", $rep->duar->incoterm)
						->setCellValue("P2", $rep->duar->total_facturar)
						->setCellValue("Q2", $rep->duar->mod_transp)
						->setCellValue("R2", $rep->duar->lugar_carga)
						->setCellValue("S2", $rep->duar->pais_trasporte)
						->setCellValue("T2", $rep->duar->localizacion_mercancia)
						->setCellValue("U2", $rep->duar->destinatario)
						->setCellValue("V2", $rep->duar->manifiesto)
						->setCellValue("W2", $rep->duar->fob)
						->setCellValue("X2", $rep->duar->flete)
						->setCellValue("Y2", $rep->duar->seguro)
						->setCellValue("Z2", $rep->duar->otros)
						->setCellValue("AA2", $rep->duar->tasas)
						->setCellValue("AB2", $rep->duar->fechapago)
						->setCellValue("AC2", $rep->duar->c807_file)
						->setCellValue("AD2", $rep->duar->reg_extendido)
						->setCellValue("AE2", $rep->duar->reg_adicional)
						->setCellValue("AF2", $rep->duar->presentacion)
						->setCellValue("AG2", $rep->duar->banco)
						->setCellValue("AH2", $rep->duar->agencia)
						->setCellValue("AI2", $rep->duar->contenedor)
						;
			
			$cell = 2;
			foreach ($rep->verdetallepoliza() as $row) {
				$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue("A{$cell}", $row->item)
							->setCellValue("B{$cell}", $row->marcas)
							->setCellValue("C{$cell}", $row->numeros)
							->setCellValue("D{$cell}", $row->partida)
							->setCellValue("E{$cell}", $row->comple)
							->setCellValue("F{$cell}", $row->desc_sac)
							->setCellValue("G{$cell}", $row->descripcion)
							->setCellValue("H{$cell}", $row->no_bultos)
							->setCellValue("I{$cell}", $row->tipo_bulto)
							->setCellValue("J{$cell}", $row->origen)
							->setCellValue("K{$cell}", $row->peso_bruto)
							->setCellValue("L{$cell}", $row->codigo_producto)
							->setCellValue("M{$cell}", $row->contenedor1)
							->setCellValue("N{$cell}", $row->contenedor2)
							->setCellValue("O{$cell}", $row->contenedor3)
							->setCellValue("P{$cell}", $row->contenedor4)
							->setCellValue("Q{$cell}", $row->peso_neto)
							->setCellValue("R{$cell}", $row->doc_transp)
							->setCellValue("S{$cell}", $row->cuantia)
							->setCellValue("T{$cell}", $row->fob)
							->setCellValue("U{$cell}", $row->flete)
							->setCellValue("V{$cell}", $row->seguro)
							->setCellValue("W{$cell}", $row->otros)
							->setCellValue("X{$cell}", $row->cif)
							->setCellValue("Y{$cell}", $row->tlc)
							->setCellValue("Z{$cell}", $row->acuerdo)
							->setCellValue("AA{$cell}", $row->quota)
							;
				$cell++;
			}

			$xcell = 2;
			foreach ($rep->verdocumentos() as $row) {
				$objPHPExcel->setActiveSheetIndex(2)
							->setCellValue("A{$xcell}", $row->tipodocumento)
							->setCellValue("B{$xcell}", $row->numero)
							->setCellValue("C{$xcell}", $row->fecha);
				$xcell++;
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$nombre="Formato-Prepoliza#".$rep->duar->duaduana.".xls"; 
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$nombre.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');		 
			exit;
		}

		return false;
	}
}
?>