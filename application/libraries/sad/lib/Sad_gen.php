	<?php
/**
* 
*/
class General
{
	public function General(){
		$this->año = "";
		$this->aduana = "";
		$this->agente = "";
		$this->narch = "";
		$this->NRO_REG = "";
		$this->imodelod = "";
		$this->manifiesto = "";
		$this->cant_art = "";		
		$this->t_bultos = "";
		$this->nit_emp = "";
		$this->pais_proc = "";
		$this->paisdestproc = "";
		$this->ipaise = "";
		$this->idenp = "";
		$this->ipaism = "";
		$this->idfurg = "";
		$this->icond_e = "";
		$this->t_fob = "";
		$this->mod_tra = "";
		$this->ildescarg = "";
		$this->tipo_liq = "";
		$this->adu_fro = "";
		$this->ilocalm = "";
		$this->ibanco = "     ";
		$this->ibco_ag = "  00";
		$this->iboleta = "                 ";
		$this->whs_cod = "                 ";
		$this->t_flete = "";
		$this->t_seguro = "";
		$this->t_otros = "";
		$this->iconsign = "";
		$this->dir1 = "";
		$this->dir2 = "";
		$this->dir3 = "";
		$this->t_tasas = "0";	
		$this->fecha_reg = "";	

	}

	public function Crear(){
		$numero_de_correlativo = $this->NRO_REG;
		$nliq = trim($this->NRO_REG);
		$xanio = trim($this->año);
		$xaduana = trim($this->aduana);
		$xagente = trim($this->agente);
		$xnro_reg = trim($nliq);
		$xtimport = "1";
		$xmodel = left((trim($this->imodelod)), 2) . chr(0) . right((trim($this->imodelod)),1);
		$xmodel2 = left((trim($this->imodelod)), 3) . chr(0) . right((trim($this->imodelod)),1);
		$xmanif = trim($this->manifiesto);
		$xbultos = trim(intval($this->t_bultos));
		$xnit = trim($this->nit_emp);
		$xpaisp = trim($this->pais_proc);
		$cero = "0.00";
		$xndgra = "";
		$xpaisex = trim($this->ipaise);
		$xpaisdest = trim($this->paisdestproc);
		$xidenp = trim($this->idenp);
		$xpais_tran = trim($this->ipaism);
		$xcod_furg = trim($this->idfurg);
		$xcon_entreg = trim($this->icond_e);
		$xdivisa = "USD";
		$xfobtot = trim($this->t_fob);
		$xcodtran = trim($this->mod_tra);
		$xldescarg = $this->ildescarg;
		$xtpago = trim($this->tipo_liq);
		$xadu_ent = trim($this->adu_fro);
		$xubicme = trim($this->ilocalm);
		$xcodbco = "00";
		$xcodage = "00";
		$xnropag = "00";
		$xubicmed = str_repeat(chr(0), 2) . trim($this->whs_cod) . str_repeat(chr(0), 9);
		$xfletet = trim($this->t_flete);
		$xsegurot = trim($this->t_seguro);
		$xotgtos = trim($this->t_otros);
		if ($xfletet == 0) {
			$xfletet = "";
		}
		if ($xsegurot == 0) {
			$xsegurot = "";
		}
		if ($xotgtos == 0) {
			$xotgtos = "";
		}
		$xfletein = "0.00";
		$xdeducc = "0.00";
		$xtalm = trim($this->t_tasas);
		$xplazo = "";
		$xconsig = trim($this->iconsign);
		$xdir1 = trim($this->dir1);
		$xdir2 = trim($this->dir2);
		$xdir3 = trim($this->dir3);
		$tlong = strlen(trim($this->agente) . trim(intval($this->NRO_REG)));
		$articulos = $this->cant_art;
		$xcant_art = trim($articulos);
		$leftimodelod = left(trim($this->imodelod),2);

		$el_principio = "";
		$datos_generales = "";
		$encabezado = "";

		if (trim(left($this->imodelod, 2)) == "IM") {
			$el_principio = "1" . chr(0) . trim($tlong) . chr(0) . chr(1) . str_repeat(chr(0),3) . chr(1) . str_repeat(chr(0),7) . chr(1) . str_repeat(chr(0),19) . chr($xcant_art) . str_repeat(chr(0),3) . chr($xcant_art) . str_repeat(chr(0),3) . chr($xcant_art) . str_repeat(Chr(0),7);

			$datos_generales = $xanio . chr(0) . $xaduana . chr(0) . $xagente . chr(0) . $xnro_reg . chr(0) . $xtimport . chr(0) . $xmodel . str_repeat(chr(0),3) . $xmanif . str_repeat(chr(0),5) . $xcant_art . chr(0) . $xbultos . chr(0) . $xnit . str_repeat(chr(0),2) . $xpaisp . str_repeat(chr(0),2) . "000.00" . chr(0) . $xndgra . chr(0) . $xpaisex . str_repeat(chr(0),2) . $xpaisdest . str_repeat(chr(0),2) . $xidenp . chr(0) . $xpais_tran . str_repeat(chr(0),1) . $xcod_furg . chr(0) . $xcon_entreg . str_repeat(chr(0),3) . $xidenp . str_repeat(chr(0),2) . $xdivisa . chr(0) . $xfobtot . str_repeat(chr(0),3) . $xcodtran . str_repeat(chr(0),2) . $xldescarg . chr(0) . $xtpago . str_repeat(chr(0),1) . $xadu_ent . chr(0) . $xubicme . chr(0) . $xcodbco . chr(0) . $xcodage . chr(0) . $xnropag . $xubicmed . "0.00" . str_repeat(chr(0),2) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),6) . "0" . chr(0) . $xfobtot . chr(0) . $xdivisa . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xfobtot . chr(0) . $xfletet . chr(0) . $xdivisa . chr(0) . "1.000" . str_repeat(chr(0),1) . "1.00000" . chr(0) . $xfletet . chr(0) . $xsegurot . chr(0) . $xdivisa . chr(0) . "1.000" . str_repeat(chr(0),1) . "1.00000" . chr(0) . $xsegurot . chr(0) . $xotgtos . chr(0) . $xdivisa . chr(0) . "1.000" . str_repeat(chr(0),1) . "1.00000" . chr(0) . $xotgtos . chr(0) . $xfletein . chr(0) . $xdivisa . chr(0) . "1.000" . str_repeat(chr(0),1) . "1.00000" . chr(0) . $xfletein . chr(0) . $xdeducc . chr(0) . $xdivisa . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . "0.00" . chr(0) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),3) . $xconsig . chr(0) . $xdir1 . chr(0) . $xdir2 . chr(0) . $xdir3 . str_repeat(chr(0),2);
		}
		if (trim(left($this->imodelod, 2)) == "EX") {
			$el_principio = "1" . chr(0) . trim($tlong) . chr(0) . chr(1) . str_repeat(Chr(0),7) . chr(1) . str_repeat(chr(0),7) . chr(1) . str_repeat(chr(0),3) . chr(1) . str_repeat(chr(0),11) . chr($xcant_art) . str_repeat(chr(0),3) . chr($xcant_art) . str_repeat(chr(0),7) . chr($xcant_art) . str_repeat(Chr(0),3);

			$datos_generales = $xanio . chr(0) . $xaduana . chr(0) . $xagente . chr(0) . $xnro_reg . chr(0) . "0" . chr(0) . $xmodel . str_repeat(chr(0),2) . $xnit . str_repeat(chr(0),6) . $xcant_art . chr(0) . $xbultos . str_repeat(chr(0),3) . $xpaisdest . str_repeat(chr(0),3) . $xndgra . chr(0) . $xpaisex . str_repeat(chr(0),2) . $xpaisdest . str_repeat(chr(0),2) . $xidenp . chr(0) . $xpais_tran . chr(0) . $xcod_furg . chr(0) . $xcon_entreg . str_repeat(chr(0),5) . $xdivisa . chr(0) . $xfobtot . str_repeat(chr(0),3) . $xcodtran . str_repeat(chr(0),2) . $xldescarg . chr(0) . $xtpago . chr(0) . $xadu_ent . chr(0) . $xubicme . str_repeat(chr(0),6) . $xplazo . str_repeat(chr(0),8) . "0.00" . str_repeat(chr(0),2) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),6) . "0" . chr(0) . $xfobtot . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xfobtot . chr(0) . $xfletein . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xfletein . chr(0) . $xdeducc . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xdeducc . chr(0) . "0.00" . str_repeat(chr(0),2) . "0.00" . Chr(0) . $xconsig . chr(0) . $xdir1 . chr(0) . $xdir2 . chr(0) . $xdir3 . str_repeat(chr(0),4);
		}
		if (trim(left($this->imodelod, 2)) == "EI") {
			$el_principio = "1" . chr(0) . trim($tlong) . chr(0) . chr(1) . str_repeat(chr(0),7) . chr(1) . str_repeat(chr(0),7) . chr(1) . str_repeat(chr(0),3) . chr(1) . str_repeat(chr(0),11) . chr($xcant_art) . str_repeat(chr(0),3) . chr($xcant_art) . str_repeat(chr(0),7) . chr($xcant_art) . str_repeat(chr(0),3);

			$datos_generales = $xanio . chr(0) . $xaduana . chr(0) . $xagente . chr(0) . $xnro_reg . chr(0) . "0" . chr(0) . $xmodel2 . str_repeat(chr(0),2) . $xnit . str_repeat(chr(0),6) . $xcant_art . chr(0) . $xbultos . str_repeat(chr(0),3) . $xpaisdest . str_repeat(chr(0),3) . $xndgra . chr(0) . $xpaisex . str_repeat(chr(0),2) . $xpaisdest . str_repeat(chr(0),2) . $xidenp . chr(0) . $xpais_tran . chr(0) . $xcod_furg . chr(0) . $xcon_entreg . str_repeat(chr(0),5) . $xdivisa . chr(0) . $xfobtot . str_repeat(chr(0),3) . $xcodtran . str_repeat(chr(0),2) . $xldescarg . chr(0) . $xtpago . chr(0) . $xadu_ent . chr(0) . $xubicme . str_repeat(chr(0),6) . $xplazo . str_repeat(chr(0),8) . "0.00" . str_repeat(chr(0),2) . "0.00" . chr(0) . "0.00" . str_repeat(chr(0),6) . "0" . chr(0) . $xfobtot . chr(0) . "USD" . Chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xfobtot . chr(0) . $xfletein . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xfletein . chr(0) . $xdeducc . chr(0) . "USD" . chr(0) . "1.000" . chr(0) . "1.00000" . chr(0) . $xdeducc . chr(0) . "0.00" . str_repeat(chr(0),2) . "0.00" . chr(0) . $xconsig . chr(0) . $xdir1 . chr(0) . $xdir2 . chr(0) . $xdir3 . str_repeat(chr(0),5);
		}

	$encabezado = $el_principio . $datos_generales;	
	return	$encabezado;


	}	
	
}

function left($str, $length) {
     return substr($str, 0, $length);
	}
 
function right($str, $length) {
     return substr($str, -$length);
	}

?>