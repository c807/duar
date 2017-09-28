<?php
class Reporte extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$modelos = array('crearpoliza/Reporte_model','Accesorios_model');
		$this->load->model($modelos);
		$this->repor = new Reporte_model();
		$this->acces = new Accesorios_model();
	}

	function index(){
		echo "¡Hola!";
	}

	function descargar($idfile){
		require_once(APPPATH.'libraries/PHPEXCEL/PHPExcel.php');
    	require_once(APPPATH.'libraries/PHPEXCEL/PHPExcel/IOFactory.php');
		$objPHPExcel = PHPExcel_IOFactory::load(APPPATH."../public/fls/formato_poliza.xls");
		$informacion = $this->repor->encabezado($idfile);

		$this->repor->set_iddua($informacion->duaduana);

		if($informacion){
			$objPHPExcel->setActiveSheetIndex(0)

			## ENCABEZADO DEL DUA
						->setCellValue("A2", $informacion->anio)
						->setCellValue("B2", $informacion->aduana_entrada)
						->setCellValue("C2", $informacion->declarante)
						->setCellValue("D2", $informacion->referencia)
						->setCellValue("E2", $informacion->cero)
						->setCellValue("F2", $informacion->modelo)
						->setCellValue("G2", $informacion->cant_arti)
						->setCellValue("H2", $informacion->nit)
						->setCellValue("I2", $informacion->bultos)
						->setCellValue("J2", $informacion->pais_proc)
						->setCellValue("K2", $informacion->pais_export)
						->setCellValue("L2", $informacion->pais_destino)
						->setCellValue("M2", $informacion->registro_transportista)
						->setCellValue("N2", $informacion->pais)
						->setCellValue("O2", $informacion->cont)
						->setCellValue("P2", $informacion->incoterm)
						->setCellValue("Q2", $informacion->tipo_cambio)
						->setCellValue("R2", $informacion->total_facturar)
						->setCellValue("S2", $informacion->mod_transp)
						->setCellValue("T2", $informacion->lugar_carga)
						->setCellValue("U2", $informacion->t_liq)
						->setCellValue("V2", $informacion->aduana_salida)
						->setCellValue("W2", $informacion->localizacion_de_merc)
						->setCellValue("X2", $informacion->destinatario)
						->setCellValue("Y2", $informacion->fob)
						->setCellValue("Z2", $informacion->flete)
						->setCellValue("AA2", $informacion->seguro)
						->setCellValue("AB2", $informacion->otros)
						->setCellValue("AC2", $informacion->tasas)
						->setCellValue("AD2", $informacion->fecha)
						->setCellValue("AE2", $informacion->t_esp_pag)
						;
		}

		$detalle = $this->repor->detalle();
		if ($detalle){
			$cell = 2;
			foreach ($detalle as $row) {
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue("A{$cell}",$row->item)
						->setCellValue("B{$cell}",$row->marcas)
						->setCellValue("C{$cell}",$row->numeros)
						->setCellValue("D{$cell}",$row->partida)
						->setCellValue("E{$cell}",$row->comple)
						->setCellValue("F{$cell}",$row->desc_sac)
						->setCellValue("G{$cell}",$row->descripcion)
						->setCellValue("H{$cell}",$row->no_bultos)
						->setCellValue("I{$cell}",$row->tipo_bulto)
						->setCellValue("J{$cell}",$row->origen)
						->setCellValue("K{$cell}",$row->peso_bruto)
						->setCellValue("L{$cell}",$row->contenedor1)
						->setCellValue("M{$cell}",$row->reg_ext)
						->setCellValue("N{$cell}",$row->reg_adi)
						->setCellValue("O{$cell}",$row->peso_neto)
						->setCellValue("P{$cell}",$row->doc_transp)
						->setCellValue("Q{$cell}",$row->cuantia)
						->setCellValue("R{$cell}",$row->fob)
						->setCellValue("S{$cell}",$row->cif)
						->setCellValue("T{$cell}",$row->flete)
						->setCellValue("U{$cell}",$row->seguro)
						->setCellValue("V{$cell}",$row->otros_gastos)
						;
				$cell++;
			}
		}

		$documento = $this->repor->documentos();
		if ($documento) {
			$cell1 = 2;
			foreach ($documento as $row) {
				$objPHPExcel->setActiveSheetIndex(2)
					->setCellValue("A{$cell1}", $row->codigo_doc)
					->setCellValue("B{$cell1}", $row->num_doc)
					->setCellValue("C{$cell1}", $row->fecha);
				$cell1++;
			}
		}
			$objPHPExcel->setActiveSheetIndex(0);
			$nombre="Formato-Prepoliza#".$informacion->duaduana.".xls"; 
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$nombre.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');		 
			exit;
	}

	function verarchivo($idfile){
		require_once(APPPATH.'libraries/PHPEXCEL/PHPExcel.php');
    	require_once(APPPATH.'libraries/PHPEXCEL/PHPExcel/IOFactory.php');
		$objPHPExcel = PHPExcel_IOFactory::load(APPPATH."../public/fls/poliza.xls");

		$informacion = $this->repor->encabezado($idfile);
		$this->repor->set_iddua($informacion->duaduana);

		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("c2", $informacion->duaduana)
						->setCellValue("c3", $informacion->c807_file)
						->setCellValue("C4", $this->acces->empresas($informacion->declarante)->nombre)
						->setCellValue("c5", date('d-m-Y'))
			## ENCABEZADO DEL DUA
						->setCellValue("B9", $this->acces->aduanas($informacion->aduana_entrada)->nombre)
						->setCellValue("E9", $this->acces->aduanas($informacion->aduana_salida)->nombre)
						->setCellValue("H9", $this->acces->empresas($informacion->declarante)->nombre)
						->setCellValue("K9", $informacion->nit)
						->setCellValue("M9", $informacion->bultos)
						->setCellValue("B11", $informacion->modelo)
						->setCellValue("E11", $informacion->registro_transportista)
						->setCellValue("H11", $this->acces->modotransporte($informacion->mod_transp)->nombre)
						->setCellValue("K11", formatoFecha($informacion->fecha,2))
						->setCellValue("B13", $this->acces->paises($informacion->pais_proc))
						->setCellValue("E13", $this->acces->paises($informacion->pais_export))
						->setCellValue("H13", $this->acces->paises($informacion->pais_destino))
						->setCellValue("K13", $this->acces->paises($informacion->pais))
						->setCellValue("B15", $informacion->referencia)
						->setCellValue("E15", $informacion->fob)
						->setCellValue("G15", $informacion->flete)
						->setCellValue("I15", $informacion->seguro)
						->setCellValue("K15", $informacion->otros)
						->setCellValue("M15", $informacion->tasas)
						->setCellValue("E18", $informacion->tipo_cambio)
						->setCellValue("H18", $informacion->total_facturar)
						->setCellValue("J18", $informacion->destinatario)
						->setCellValue("L18", $this->acces->incoterm($informacion->incoterm)->DESCRIPCION)
						->setCellValue("E21", $informacion->localizacion_de_merc)
						;

		$detalle = $this->repor->detalle();
		if ($detalle) {
			$cell = 6;
			foreach ($detalle as $row) {
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue("B{$cell}",$row->item)
						->setCellValue("C{$cell}",$row->marcas)
						->setCellValue("D{$cell}",$row->numeros)
						->setCellValue("E{$cell}",$row->partida)
						->setCellValue("F{$cell}",$row->comple)
						->setCellValue("G{$cell}",$row->desc_sac)
						->setCellValue("H{$cell}",$row->no_bultos)
						->setCellValue("I{$cell}",$row->tipo_bulto)
						->setCellValue("J{$cell}",$this->acces->paises($row->origen))
						->setCellValue("K{$cell}",$row->peso_bruto)
						->setCellValue("L{$cell}",$row->contenedor1)
						->setCellValue("M{$cell}",$row->reg_ext)
						->setCellValue("N{$cell}",$row->reg_adi)
						->setCellValue("O{$cell}",$row->peso_neto)
						->setCellValue("P{$cell}",$row->doc_transp)
						->setCellValue("Q{$cell}",$row->cuantia)
						->setCellValue("R{$cell}",$row->fob)
						->setCellValue("S{$cell}",$row->flete)
						->setCellValue("T{$cell}",$row->seguro)
						->setCellValue("U{$cell}",$row->otros_gastos)
						->setCellValue("V{$cell}",$row->cif)
						->setCellValue("W{$cell}",$row->descripcion);
				$cell++;
			}
		}

		$documento = $this->repor->documentos();
		if ($documento) {
			$cell1 = 6;
			$num   = 1;
			foreach ($documento as $row) {
				$objPHPExcel->setActiveSheetIndex(2)
					->setCellValue("B{$cell1}", $num++)
					->setCellValue("C{$cell1}", $this->acces->documento($row->codigo_doc)->descripcion)
					->setCellValue("D{$cell1}", $row->num_doc)
					->setCellValue("E{$cell1}", $row->fecha);
			$cell1++;
			}
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$nombre="Prepoliza#".$informacion->duaduana.".xls"; 
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$nombre.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');
			 
			exit;
	}
}
?>