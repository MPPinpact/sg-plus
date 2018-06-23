<?php

require('../tcpdf/tcpdf.php');
require('../tcpdf/tcpdf_barcodes_2d.php');
require('../tcpdf/tcpdf_barcodes_1d.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(6, 5, 175);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

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
$pdf->AddPage('P', 'A4');

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);;
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);

// CODE 128 AUTO
$pdf->Cell(0, 0, 'CALZA DEPORTIVA', 0, 1, 'C');
$pdf->write1DBarcode('2045', 'C128A', '', '', '', 13, 0.4, $style, 'N');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, '$ 4.990.-', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 6);
$pdf->Cell(0, 0, '', 0, 1);


//Close and output PDF document
$pdf->Output('example_027.pdf', 'I');
