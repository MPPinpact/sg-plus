<?php
	require('/public/tcpdf/examples/tcpdf_include.php');
	require('/public/tcpdf/tcpdf.php');
	// Comentar las siguientes 5 lines para verlo como php normal //
	// header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	// header("Content-Disposition: attachment; filename=prestaciones.xls");  //File name extension was wrong
	// header("Expires: 0");
	// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	// header("Cache-Control: private",false);

	$html = $_POST['BoletaString'];
	
	$nombreEmpresa = 'DEL PEDREGAL Santiago SPA';
	$direccionEmpresa = 'CASA MATRIZ: GENERAL L ASTRA 688SANTIAGO';
	$conceptos = $conceptos = array( 0=> 'Queso Parmesano', 1 => 'Queso Palmito',  2 => 'Queso Cheddar',);
	$conceptos = $conceptos = array( 0=> 'Queso Parmesano', 1 => 'Queso Palmito',  2 => 'Queso Cheddar',);
	$precio = $precio = array( 0=> 5000, 1 => 6000,  2 => 7000,);
	$total = array_sum($precio);	
	$largo_conceptos = count($conceptos);


	// print_r($conceptos['Queso Parmesano']);
	// var_dump($conceptos[]);
	// print_r($conceptos); 
	$html = '<html>
<head>
	<title>Analisis de calculo de jubilacion</title>
</head>
<table width="100%" border="0px" align="center" cellpadding="0" cellspacing="0" align="center">
	<!-- <tr>
		<td width="20"  >&nbsp;</td>
		<td width="20" >&nbsp;</td>
		<td width="20" >&nbsp;</td>
		<td width="20" >&nbsp;</td>
		<td width="20" >&nbsp;</td>
		<td width="20" >&nbsp;</td>
		<td width="21" >&nbsp;</td>
		<td width="21" >&nbsp;</td>
		<td width="21" >&nbsp;</td>
		<td width="21" >&nbsp;</td>
		<td width="21" >&nbsp;</td>
		<td width="21" >&nbsp;</td>
	</tr>
	-->
	<tr>
	<td colspan="10" rowspan="1" style= "border-style: solid; border-width: 1px 1px 1px 1px; border-color:black;font-size: 08px;">R.U.T.: 76.445.586-K <br>BOLETA ELECTRONICA<br>Nº0121152</td><td colspan="0"></td>
	</tr>


<!--
	<tr>
	<td colspan="10" rowspan="1" style= "font-size: 6px;">S.I.J. SANTIAGO NORTE</td><td colspan="0"></td>
	</tr>

	 -->
	<tr>
	<td colspan="10" style="font-size: 7px;">S.I.J. SANTIAGO NORTE</td>
	</tr>
	
	<tr>
	<td colspan="10"><img src="public/imagenes/logo.jpg" width="300%"></td>
	</tr>

	<tr>
	<td></td><td colspan="10" rowspan="1" style="font-size: 5px;" align="left" align="left">'.$nombreEmpresa.' <br>COMERCIALIZACION Y DISTRIBUCION DE ALIMENTOS FRESCOS Y CONGELADOS, EXPOTACION E IMPORTACION Y ROSTISERIA.</td><td colspan="0">
	</td>
	</tr>

		<tr>
	<td colspan="10" style="font-size: 7px;"></td>
	</tr>
	<tr>
	<td></td><td colspan="10" style="font-size: 5px;" align="left" align="left">'.$direccionEmpresa.' <br> General L Astra 688, Santiago</td><td colspan="0">
	</td>
	</tr>

<tr>

<td colspan="8" style="font-size: 5px;  border-bottom-width: 0.5px solid #000;" align="left"> DETALLE </td>
<td colspan="8" style="font-size: 5px; border-bottom-width: 0.5px solid #000;" align="left"> TOTAL</td>

</tr>


	';

	for ($i=0; $i <= $largo_conceptos ; $i++){						
		

$html .= '
<tr>

<td colspan="8" style="font-size: 5px;" align="left"> '.$conceptos[$i].'</td>
<td colspan="8" style="font-size: 5px;" align="left"> '.$precio[$i].'</td>

</tr>
';}
	$html .= '
<tr>
<td colspan="10" style="font-size: 5px;" align="left"> '.$total.'</td>
</tr>
	
	</table></html>
	';
	//echo $html;



class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'tope.jpg';
		//$this->Image($image_file, 5, 10, 200, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		// $this->SetFont('helvetica', 'I', 8);
		$this->SetFont('times', 'B', 20);
		// Page number
		$this->Cell(0, 10, '', 0, false, 'C', 0, '', 0, false, 'T', 'M');

	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Calculo de Jubilaciones');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

//

$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(0,0,0);
//
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// Original
// $pdf->SetMargins(20, 20, 0, true);
// Personalizado
$pdf->SetMargins(8, 4, 8);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

//CODIGO QR

$params = $pdf->serializeTCPDFtagParameters(array('010201010', 'C39', '', '', 40, 20, 0.4, array('position'=>'S', 'border'=>true, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
$html .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';





// Original
// $pdf->AddPage('P', 'LEGAL');
// Personalizado
$pdf->AddPage('P', 'A7');

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document

echo($pdf->Output('expediente.pdf', 'I'));

