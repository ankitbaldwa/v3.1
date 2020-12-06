	<?php
ob_start();
mpdf();
//$obj_pdf = new TCPDF('P','mm', 'A4', true, 'UTF-8', false);
$obj_pdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4-P',
	'orientation' => 'P',
	'setAutoTopMargin' => 'stretch',
	'autoMarginPadding' => 0,
	'bleedMargin' => 0,
	'crossMarkMargin' => 0,
	'cropMarkMargin' => 0,
	'nonPrintMargin' => 0,
	'margBuffer' => 0,
	'collapseBlockMargins' => false,
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 10,
	'margin_bottom' => 10,
	'margin_header' => 0,
	'margin_footer' => 0,
]);
//$obj_pdf->SetCreator(PDF_CREATOR);
$title = $incoice_no;
$obj_pdf->SetTitle($title);
//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetFont('DejaVuSans');
//$obj_pdf->SetHeaderMargin(0);
//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('times', '', 10);
//$obj_pdf->setFontSubsetting(true);
$obj_pdf->AddPage();
// set cell padding
//$obj_pdf->setCellPaddings(100, 0, 0, 0);

// set cell margins
//$obj_pdf->setCellMargins(0, 0, 0, 0);
//print_r($pdf);exit;
//$obj_pdf->writeHTMLCell(0, 0, '', '', $pdf, 1, 1, false, true, 'J', false);
// reset font stretching
//$obj_pdf->setFontStretching(100);
// reset font spacing
//$obj_pdf->setFontSpacing(0);
// we can have any view part here like HTML, PHP etc
//$obj_pdf->writeHTML($pdf, true, false, true, false, '');
// output the HTML content
$obj_pdf->WriteHTML($pdf);
$obj_pdf->Output($incoice_no.'_'.date('d_M_y').'.pdf', 'I');
	?>