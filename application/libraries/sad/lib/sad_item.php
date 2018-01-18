<?php
/**
* 
*/

class Item
{
	public $todos = '';
	
	public function Item(){
		$this->coment1     = "                                   ";		
		$this->acuerdo     = "        ";
		$this->imodelod    = "";
		$this->cont01      = "";
		$this->cont02      = "";
		$this->cont03      = "";
		$this->cont04      = "";
		$this->quo_lic     = "      ";
		$this->docs_adjc   = "                 ";
		$this->art         = 1;
		$this->partida     = "";
		$this->ptdadi      = "000";		
		$this->pais_orig   = "";
		$this->peso_bruto  = "0";
		$this->bultos      = "0";
		$this->cod_bultos  = "";		
		$this->marca       = "";
		$this->numero      = "";		
		$this->desc_ptda   = "";
		$this->regimen     = "";
		$this->sub_reg     = "";
		$this->peso_neto   = "0";
		$this->doct        = "";
		$this->unidad_supl = "0";
		$this->fob_item    = "0";
	}

	public function agregar(){		
		$xart         = trim($this->art);
		$xpartida     = trim($this->partida);
		$xptdadi      = trim($this->ptdadi);
		$natural      = 12;
		$xnro_nat     = trim(number_format(12, 2, ".", ""));
		$xpais_orig   = trim($this->pais_orig);
		$xpeso_bruto  = trim(number_format($this->peso_bruto, 2, ".", ""));
		$bultos       = $this->bultos;
		$xcant_bultos = trim(number_format($bultos, 2, ".", ""));
		$xcod_bultos  = trim($this->cod_bultos);
		$xdai_pag     = "0.00";
		$xiva_pag     = "0.00";
		$xcoment1     = trim($this->coment1);
		$xmarca       = trim($this->marca);
		$xnumero      = trim($this->numero);
		$xdesc_aran   = "";
		$xdesc_ptda   = trim($this->desc_ptda);
		$xbultos_it   = trim(number_format($bultos, 2, ".", ""));
		$xacuerdo     = trim($this->acuerdo);
		$xconten1     = trim($this->cont01);
		$xconten2     = trim($this->cont02);
		$xconten3     = trim($this->cont03);
		$xconten4     = trim($this->cont04);
		$xreginen     = trim($this->regimen);
		$xsub_reg     = trim($this->sub_reg);
		$xpeso_neto   = trim(number_format($this->peso_neto, 2, ".", ""));
		$xquo_lic     = trim($this->quo_lic);
		$doct         = trim($this->doct);
		$xunidad_supl = trim(number_format($this->unidad_supl, 2, ".", ""));
		$xfob_item    = trim(number_format($this->fob_item, 2, ".", ""));
		$doctad       = trim($this->docs_adjc);
		$fletex       = "0.00";
		$seguroi      = "0.00";
		$otgtosi      = "0.00";
		$fletei       = "0.00";
		$deduci       ="0.00";
		$reg_ant      = "";
		$mas          = "+";
		$menos        = "-";
		$calm         = "2" . chr(0) . "ALM";
		$cesp         = "1" . str_repeat(chr(0), 4);
		$xrefant      = "";
		$xtcambio     = "1.000";
		$xtotros_i    = "0.00000";
		$xartic       = trim($xart);
		$modelo       = trim($this->imodelod);
		$cero         = "0.00";
		$xdivisa      = "USD";

		$los_items = "";

		if ($xart == 1) {
			if (left($modelo, 2) == "IM") {
				$los_items = strval($xartic) . chr(0) . $xmarca . chr(0) . $xnumero . chr(0) . $xpartida . chr(0) . $xptdadi . str_repeat(chr(0),4) . $xdesc_aran . str_repeat(chr(0),2) . $xdesc_ptda . str_repeat(chr(0),1) . $xbultos_it . chr(0) . $xcod_bultos . chr(0) . $xpais_orig . str_repeat(chr(0),2) . $xpeso_bruto . str_repeat(chr(0),1) . $xacuerdo . str_repeat(chr(0),1) . $xconten1 . chr(0) . $xconten2 . chr(0) . $xconten3 . chr(0) . $xconten4 . chr(0) . $xreginen . chr(0) . $xsub_reg . chr(0) . $xpeso_neto . str_repeat(chr(0),1) . str_repeat(chr(0),1) . $doct . chr(0) . $xunidad_supl . str_repeat(chr(0),2) . $xfob_item . str_repeat(chr(0),2) . $reg_ant . str_repeat(chr(0),2) . $fletex . " " . $mas . " " . $seguroi . " " . $mas . " " . $otgtosi . " " . $mas . " " . $deduci . " " . $menos . " " . "0.00" . str_repeat(chr(0),2) . $xtcambio . str_repeat(chr(0),5) . "0.00" . str_repeat(chr(0),2) . $cero . str_repeat(chr(0),4) . $cero . chr(0) . $cero . chr(0) . $xartic . chr(0) . $xfob_item . chr(0) . $xdivisa . chr(0) . $xtcambio . chr(0) . "1" . chr(0) . $xfob_item . chr(0) . "0.00" . chr(0) . $xdivisa . chr(0) . $xtcambio . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . $xdivisa . chr(0) . $xtcambio . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),1);
			}else{
				$los_items = strval($xartic) . chr(0) . $xmarca . chr(0) . $xnumero . chr(0) . $xpartida . chr(0) . $xptdadi . str_repeat(chr(0),4) . $xdesc_aran . str_repeat(chr(0),2) . $xdesc_ptda . str_repeat(chr(0),1) . $xbultos_it . chr(0) . $xcod_bultos . chr(0) . $xpais_orig . str_repeat(chr(0),2) . $xpeso_bruto . str_repeat(chr(0),2) . $xconten1 . chr(0) . $xconten2 . chr(0) . $xconten3 . chr(0) . $xconten4 . chr(0) . $xreginen . chr(0) . $xsub_reg . chr(0) . $xpeso_neto . str_repeat(chr(0),2) . $doct . chr(0) . $xunidad_supl . str_repeat(chr(0),3) . Trim($doctad) . str_repeat(chr(0),3) . "0.00" . " - " . "0.00" . str_repeat(chr(0),3) . $xrefant . str_repeat(chr(0),4) . $xfob_item . chr(0) . "0.00" . chr(0) . "0" . str_repeat(chr(0),4) . "2" . chr(0) . "ALM" . str_repeat(chr(0),2) . "0.00000" . chr(0) . "0.00000" . chr(0) . "0.00000" . chr(0) . "1" . chr(0) . "OTR" . str_repeat(chr(0),2) . "0.00000" . chr(0) . "0.00000" . chr(0) . $xtotros_i . chr(0) . "1" . chr(0) . "0" . chr(0) . "1" . chr(0) . $xfob_item . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . $xfob_item . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),10);
			}
		}else{
			if (left($modelo, 2) == "IM") {
				$los_items = strval($xartic) . chr(0) . $xmarca . chr(0) . $xnumero . chr(0) . $xpartida . chr(0) . $xptdadi . str_repeat(chr(0),4) . $xdesc_aran . str_repeat(chr(0),2) . $xdesc_ptda . str_repeat(chr(0),1) . $xbultos_it . chr(0) . $xcod_bultos . chr(0) . $xpais_orig . str_repeat(chr(0),2) . $xpeso_bruto . str_repeat(chr(0),2) . $xconten1 . chr(0) . $xconten2 . chr(0) . $xconten3 . chr(0) . $xconten4 . chr(0) . $xreginen . chr(0) . $xsub_reg . chr(0) . $xpeso_neto . str_repeat(chr(0),2) . $doct . chr(0) . $xunidad_supl . chr(0) . $xfob_item . str_repeat(chr(0),2) . $doctad . chr(0) . $reg_ant . str_repeat(chr(0),2) . $fletex . " " . $mas . " " . $seguroi . " " . $mas . " " . $otgtosi . " " . $mas . " " . $deduci . " " . $menos . " " . "0.00" . str_repeat(chr(0),2) . $xtcambio . str_repeat(chr(0),3) . $xcoment1 . chr(0) . $xrefant . str_repeat(chr(0),1) . $cero . chr(0) . $cero . chr(0) . "1" . str_repeat(chr(0),4) . "2" . chr(0) . "DAI" . str_repeat(chr(0),2) . $cero . chr(0) . $xdai_pag . chr(0) . $cero . chr(0) . "1" . chr(0) . "IVA" . str_repeat(chr(0),2) . $cero . chr(0) . $xiva_pag . chr(0) . $cero . chr(0) . "1" . chr(0) . $xartic . chr(0) . $xfob_item . chr(0) . $xdivisa . chr(0) . $xtcambio . chr(0) . "1" . chr(0) . $xfob_item . chr(0) . "0.00" . chr(0) . $xdivisa . chr(0) . $xtcambio . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . $xdivisa . chr(0) . $xtcambio . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),10);
			}else{
				$los_items = strval($xartic) . chr(0) . $xmarca . chr(0) . $xnumero . chr(0) . $xpartida . chr(0) . $xptdadi . str_repeat(chr(0),4) . $xdesc_aran . str_repeat(chr(0),2) . $xdesc_ptda . str_repeat(chr(0),1) . $xbultos_it . chr(0) . $xcod_bultos . chr(0) . $xpais_orig . str_repeat(chr(0),2) . $xpeso_bruto . str_repeat(chr(0),2) . $xconten1 . chr(0) . $xconten2 . chr(0) . $xconten3 . chr(0) . $xconten4 . chr(0) . $xreginen . chr(0) . $xsub_reg . chr(0) . $xpeso_neto . str_repeat(chr(0),2) . $doct . chr(0) . $xunidad_supl . str_repeat(chr(0),3) . trim($doctad) . str_repeat(chr(0),3) . "0.00" . " - " . "0.00" . str_repeat(chr(0),3) . $xrefant . str_repeat(chr(0),4) . $xfob_item . chr(0) . "0.00" . chr(0) . "0" . str_repeat(chr(0),4) . "0" . chr(0) . "2" . chr(0) . $xfob_item . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . $xfob_item . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1" . chr(0) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),10);
			}
		}

		$this->additem($los_items);

		//return $GLOBALS["todos"];
	}

	public function additem($item){
		#$GLOBALS["todos"] = $GLOBALS["todos"] . $item;		
		$this->todos .= $item;
	}

	public function retitems(){
		#return $GLOBALS["todos"];
		return $this->todos;
	}

}

?>