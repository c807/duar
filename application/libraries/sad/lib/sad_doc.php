<?php

#$tot_docs = "1" ;
#$documentos = "";
class Documento
{
	public $documentos = '';
	public $tot_docs   = '';

	public function Documento(){
		$this->correlativo = "";
		$this->codigo      = "";
		$this->descrip     = "";
		$this->numero_doc  = "";
		$this->zfec        = "";
	}

	public function agregar(){
		$correlativo = $this->correlativo;
		$codigo      = $this->codigo;
		$descrip     = $this->descrip;
		$numero_doc  = $this->numero_doc;
		$zfec        = $this->zfec;
		$ent         = 1;

		$vcont = $correlativo - $ent;


		if ($correlativo == 1) {
			$vpart = $this->tot_docs . chr(0) . trim($codigo) . chr(0) . trim($descrip) . chr(0) . trim($numero_doc) . chr(0) . $zfec . chr(0) . "0" . chr(0) . "1" . chr(0) . "1" . chr(0);
		}else{
			$vpart = trim($codigo) . chr(0) . trim($descrip) . chr(0) . trim($numero_doc) . chr(0) . $zfec . chr(0) . trim($vcont) . chr(0) . "1" . chr(0) . "0" . chr(0);
		}
		$this->adddoc($vpart);
	}

	public function adddoc($doc){
		#$GLOBALS["documentos"] = $GLOBALS["documentos"] . $doc;		
		$this->documentos .= $doc;
	}

	public function retdocs(){
		#return $GLOBALS['documentos'];
		return $this->documentos;
	}

}
?>