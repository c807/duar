
<?php

include getcwd() . "/application/libraries/fpdf/fpdf.php";
//Generar PDF
    $destino = getcwd()."/public/uploads/file/";
    
    if (!is_dir($destino)) {
		mkdir($destino, 0777, true);
	}

	$pdf = new FPDF();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(40,10,'¡Hola, Mundo!');
	$pdf->Output($destino."hola.pdf");
    $pdf->close();
    
    redirect("subir_archivo");