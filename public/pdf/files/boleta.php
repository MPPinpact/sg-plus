<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');



// create new PDF document

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
              $this->SetFont('helvetica', 'I', 8);
              $this->SetFont('times', 'I', 20);
              // Page number
              $this->Cell(0, 10, '', 0, false, 'C', 0, '', 0, false, 'T', 'M');

       }
}
$width = 945;  
$height = 266; 
$pageLayout = array($width, $height);
// $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'px', $pageLayout, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDFT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// $pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);

// $orientation = ($height>$width) ? 'P' : 'L';  
// $pdf->addFormat("custom", $width, $height);  
// $pdf->reFormat("custom", $orientation);  


// set document information
// $pdf->SetCreator('');
// $pdf->SetAuthor('');
// $pdf->SetTitle('Boleta de Venta');
// $pdf->SetSubject('');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData('', '', '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
// 	require_once(dirname(__FILE__).'/lang/eng.php');
// 	$pdf->setLanguageArray($l);
// }

//Parametros Recibidos por POST
// ---------------------------------------------------------
$codigo	= $_POST['codigo'];
$empresa = $_POST['empresa'];
$local = $_POST['local'];
$detalles = $_POST['detalles'];
$pagos = $_POST['pagos'];
// ---------------------------------------------------------

// set default font subsetting mode
// $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 8, '', true);


// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));




$params = $pdf->serializeTCPDFtagParameters(array($codigo, 'C39', '', '', 60, 20, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));

	$html = "ñlkjldfkjgj  lfjglfkjgj flkgjflkgj jfgkl dfjlgkfj <p></p>";


	$html .= $empresa ;
	$html .= "<p></p>";
	$html .= $local ;
	$html .= "<p></p>";
	$html .= $detalles ;
	$html .= "<p></p>";
	$html .= $pagos ;
	$html .= "<p></p>";

	
	







	// foreach ($empresa as $key => $value) {
	// 	$html .= "  ::::  ";
	// 	$html .= $key."  ::::  ".$vale;
	// }

	$html .= "<p></p>";

       // $html .= '<div style="font-size:7px;">
       //      <input type="hidden" id="NumeroBoletaModal" value="'.$id.'">
       //      <table border="1" cellspacing="0" width="95%">
       //          <tr>
       //              <td>
       //                  <table border="0" cellspacing="0" width="100%">
       //                      <tr>
       //                          <td style="text-align:center;">
       //                              '.$local->RUTEmpresa.'
       //                          </td>
       //                      </tr>
       //                      <tr>
       //                          <td style="text-align:center;">
       //                              '.$tittle.'
       //                          </td>
       //                      </tr>
       //                      <tr>
       //                          <td style="text-align:center;">
       //                              '.$numero.'
       //                          </td>
       //                      </tr>
       //                  </table>
       //              </td>
       //          </tr>
       //      </table>
       //      <br>
       //      <br>
       //      <table border="0" cellspacing="0" width="100%">
       //          <tr>
       //              <td>
       //                  <b>'.$empresa->NombreFantasia.'</b>
       //              </td>
       //          </tr>
       //          <tr>
       //              <td>
       //                  <b>'.$empresa->Giro.'</b>
       //              </td>
       //          </tr>
       //          <tr>
       //              <td>
       //                  <b>'.$local->DireccionLocal.'</b>
       //              </td>
       //          </tr>
       //      </table>
       //       <br />
       //      <table border="0" cellspacing="0" width="100%">
       //          <tr>
       //              <td>
       //                  <b>Fecha Emisión: '.$FechaNow->format('d-m-Y').' </b>
       //              </td>
       //          </tr>
       //          <tr>
       //              <td>
       //                  <b>Hora Emisión: '.$FechaNow->format('H:i:s').' </b>
       //              </td>
       //          </tr>                                                                            
       //      </table>
       //      <br />
       //      <table border="0" cellspacing="0" width="100%" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
       //          <tr class="tableHead" style="font-weight: bold;" >
       //              <td width="80%" colspan="2">DETALLE COMPRA</td>
       //              <td width="20%"align="right">TOTAL</td>
       //          </tr>
       //      '.$DetalleFactura.'
       //          <tr><td colspan="2"></td><td border="1">=============</td></tr>
       //          <tr>
       //              <td colspan="2"><b>TOTAL</b></td>
       //              <td align="right"><b>'.number_format($total, 2,",", ".").'</b></td>
       //          </tr>
       //          <tr>
       //              <td colspan="3"><br /></td>
       //          </tr>
       //      </table>
       //      <table border="0" cellspacing="0" width="100%" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
       //          <tr>
       //              <td colspan="3" style="font-weight: bold;">DETALLE PAGO</td>
       //          </tr>
       //      '.$DetallePago.'
       //      </table>
       //  </div>';



// $html .= '<br>';
// $html .='<tcpdf method="write1DBarcode" params="'.$params.'" />';


// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// Original
// $pdf->SetMargins(20, 20, 0, true);
// Personalizado
// $pdf->SetMargins(8, 4, 8);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor

// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
// 	require_once(dirname(__FILE__).'/lang/eng.php');
// 	$pdf->setLanguageArray($l);
// }

// Original
// $pdf->AddPage('P', 'LEGAL');
// Personalizado

//Add a custom size  
$pdf->AddPage();
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();
$pdf->Close();
// ---------------------------------------------------------

//Close and output PDF document
echo($pdf->Output('Boleta.pdf', 'I'));
// ---------------------------------------------------------
