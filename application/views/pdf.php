	<?php
ob_start();
tcpdf();
$obj_pdf = new TCPDF('P','mm', 'A4', true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = $incoice_no;
$obj_pdf->SetTitle($title);
//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(0);
//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('times', '', 10);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();
// set cell padding
$obj_pdf->setCellPaddings(0, 0, 0, 0);

// set cell margins
$obj_pdf->setCellMargins(0, 0, 0, 0);
//print_r($pdf);exit;
// we can have any view part here like HTML, PHP etc
$obj_pdf->writeHTML($pdf, true, false, true, false, '');
// output the HTML content
//$obj_pdf->writeHTML($html, true, false, true, false, '');
$obj_pdf->Output($incoice_no.'_'.date('d_M_y').'.pdf', 'I');
	?>