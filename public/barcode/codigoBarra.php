<?php

require('../pdf/tcpdf.php');
require('../pdf/tcpdf_barcodes_2d.php');
require('../pdf/tcpdf_barcodes_1d.php');

$codigo = isset( $_GET["codigo"] ) ?   $_GET["codigo"] : "1234567890"  ;
$producto = isset( $_GET["producto"] ) ? $_GET["producto"] : "PRODUCTO - PRODUCTO" ;
$precio = isset( $_GET["precio"] ) ? "$ " . number_format($_GET["precio"], 0, ",", ".") .".-"  : "$ 000.000.-"; 
$cantidad = isset( $_GET["cantidad"] ) ? $_GET["cantidad"] : 1;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
// 	require_once(dirname(__FILE__).'/lang/eng.php');
// 	$pdf->setLanguageArray($l);
// }

// ---------------------------------------------------------

// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.

$pdf->SetFont('helvetica', '', 6);

// define barcode style
$style = array(
	'position' => '',
	'align' => 'C',
	'stretch' => false,
	'fitwidth' => true,
	'cellfitalign' => '',
	'border' => false,
	'hpadding' => 'auto',
	'vpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255),
	'text' => true,
	'font' => 'helvetica',
	'fontsize' => 8,
	'stretchtext' => 4
);


// add a page ----------
// $pdf->AddPage('P', 'A4');
// $pdf->AddPage('P', array(60,40));

for($i=0; $i<$cantidad;$i++){
	// CODE 128 AUTO
	$pdf->AddPage('L', array(20,33));

	$pdf->StartTransform();
	$pdf->Rotate(-90);

	$pdf->Cell(0, 0, $producto, 0, 1, 'C');
	$pdf->write1DBarcode($codigo, 'C128A', '', '', '', 13, 0.4, $style, 'N');
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(0, 0, $precio, 0, 1, 'C');
	$pdf->SetFont('helvetica', '', 6);
	$pdf->Cell(0, 0, '----------------', 0, 1);	

	$pdf->StopTransform();
}


//Close and output PDF document
$pdf->Output('etiquetasSGPLUS.pdf', 'I');
