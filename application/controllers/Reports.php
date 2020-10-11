<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Parent {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Reports_model');
        $this->load->model('Invoices_model');
        $this->load->library('session');
        /*keep this code for mail */
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
        setlocale(LC_MONETARY, 'en_IN.UTF-8');
        /** Load comapny details and database */
		$this->company = get_company();
        $this->db = load_db($this->company);
		/** Load comapny details and database */
        if(isset($this->session->userdata('logged_in')['id'])){
            $login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
            define('name',$login_name->username);
            define('id',$this->session->userdata('logged_in')['id']);
            define('last_login',$login_name->last_login);
			define('profile',$login_name->profile);
        } 
    }
    public function customerReport()
    {        
        $customers = $this->Reports_model->GetFieldData('customers', "id, FirstName, LastName","user_id=".id."","","FirstName ASC");
        $taxdetails = $this->Reports_model->GetFieldData('mst_taxes', "name, value","user_id=".id."","","");
        $data = array(
            'file' => 'Reports/customerReport',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Customers Report',
            'customers'=>$customers,
            'taxdetails' => $taxdetails
        );
        $this->load->view('layout', $data);
    } 
    public function customerReport_ajax()
    {
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('Y-m-d',strtotime($_POST['start']));
            $end = date('Y-m-d',strtotime($_POST['end']));
            $cond = "i.user_id=".id ." and i.Customer_id = ".$_POST['SearchData']." and i.invoice_date >= '".$start."' AND i.invoice_date <= '".$end."' AND i.status != 'Cancelled'";
        } else {
            $cond = "i.user_id=".id ." and i.Customer_id = ".$_POST['SearchData']." and i.status != 'Cancelled'";
        }
        $table = "invoice i";
        $userData=$this->Reports_model->get_datatables($table,$cond);
        //print_r($this->db->last_query());exit;
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            //$btn = anchor(site_url(INVOICES_VIEW.'/'.$usersData->id),'<button title="View" class="btn btn-sm btn-default waves-effect"><i class="fa fa-eye"></i></button>',['target'=>'_blank']);
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url(INVOICES_PAYMENT.'/'.base64_encode($usersData->id)),'<button title="Payment" class="btn btn-info btn-circle btn-sm"><i class="fa fa-money"></i></button>',['target'=>'_blank']);
            if($usersData->Status!='Pending')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            }
            else
            {
                $status =  "<label class='label-warning label'> Pending </label>";
            }
            $no++;
            $nestedData = array();
            //$nestedData[] = $no;
            $nestedData[] = ($usersData->invoice_no !='')?$usersData->invoice_no:'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->invoice_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Gross_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->CGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->SGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->IGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->CESS);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->TCS);
            if($usersData->IGST != 0)
                $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia((float) $usersData->IGST + (float) $usersData->CESS + (float) $usersData->TCS );
            else
                $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia((float) $usersData->CGST + (float) $usersData->SGST + (float) $usersData->CESS + (float) $usersData->TCS);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Netammount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Balance_Amount);
            $nestedData[] = $status;
            //$nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Reports_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Reports_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function customerReport_excel()
    {
        $table = "invoice i";
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('Y-m-d',strtotime($_POST['start']));
            $end = date('Y-m-d',strtotime($_POST['end']));
            $cond = "i.user_id=".id ." and i.Customer_id = ".$_POST['months']." and i.invoice_date >= '".$start."' AND i.invoice_date <= '".$end."' and i.status != 'Cancelled'";
        } else {
            $cond = "i.user_id=".id ." and i.Customer_id = ".$_POST['months']." and i.status != 'Cancelled'";
        }
        //$cond = "i.user_id=".id ." and Customer_id = ".$_POST['months']."";
        $userData=$this->Reports_model->GetDataAll($table,$cond);
        $customer = $this->Reports_model->GetData('customers', "id=".$_POST['months']." and user_id = ".id);
        $taxdetails = $this->Reports_model->GetFieldData('mst_taxes', "name, value","user_id=".id."","","");
        //load our new PHPExcel library
        $this->load->library('excel');
        ob_start();
        // Set document properties
		$this->excel->getProperties()->setCreator(LOGO)
                                    ->setLastModifiedBy(name)
                                    ->setTitle("Customer Report")
                                    ->setSubject("")
                                    ->setDescription("")
                                    ->setKeywords("")
                                    ->setCategory("");
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Report of customer');
        //set cell A1 content with some text
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('d-M-Y',strtotime($_POST['start']));
            $end = date('d-M-Y',strtotime($_POST['end']));
            $this->excel->getActiveSheet()->setCellValue('A1', 'Customer Report Of '. $customer->FirstName.' '.$customer->LastName.' For '.$start.' To '. $end);
        } else {
            $this->excel->getActiveSheet()->setCellValue('A1', 'Customer Report Of '. $customer->FirstName.' '.$customer->LastName);
        }
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:N1');
        $this->excel->getActiveSheet()->getColumnDimensionByColumn('A2:N2')->setAutoSize(false);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Sr No.');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('4.42');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Invoice No');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('14');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Invoice Date');
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Gross Amount');
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('E2', 'CGST ('.$taxdetails[0]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('F2', 'SGST ('.$taxdetails[1]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('G2', 'IGST ('.$taxdetails[2]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('H2', 'CESS ('.$taxdetails[3]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('I2', 'TCS ('.$taxdetails[4]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('J2', 'Total Tax Amount');
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('K2', 'Net Amount');
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('L2', 'Balance Amount');
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('M2', 'Status');
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth('10');
        //set aligment to center for that merged cell (A1 to J1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(45);
        $a = 4;
        $sr = 1;
        $gross=0; $tax=0; $net=0; $balance = 0;
        foreach($userData as $data){
            $this->excel->getActiveSheet()->setCellValue('A'.$a, $sr);
            $this->excel->getActiveSheet()->setCellValue('B'.$a, ($data->invoice_no !='')?$data->invoice_no:'N/A');
            $this->excel->getActiveSheet()->setCellValue('C'.$a, date('d-M-Y',strtotime($data->invoice_date)));
            $this->excel->getActiveSheet()->setCellValue('D'.$a,(float) $data->Gross_amount );
            $gross += (float) $data->Gross_amount; 
            $this->excel->getActiveSheet()->getStyle('D'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('E'.$a,(float) $data->CGST );
            $this->excel->getActiveSheet()->getStyle('E'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('F'.$a,(float) $data->SGST );
            $this->excel->getActiveSheet()->getStyle('F'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('G'.$a,(float) $data->IGST );
            $this->excel->getActiveSheet()->getStyle('G'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('H'.$a,(float) $data->CESS );
            $this->excel->getActiveSheet()->getStyle('H'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('I'.$a,(float) $data->TCS );
            $this->excel->getActiveSheet()->getStyle('I'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            if($usersData->IGST != 0){
                $this->excel->getActiveSheet()->setCellValue('J'.$a,(float) $data->IGST + (float) $data->CESS + (float) $data->TCS );
            }
            else
                $this->excel->getActiveSheet()->setCellValue('J'.$a,(float) $data->CGST + (float) $data->SGST + (float) $data->CESS + (float) $data->TCS);
            $tax += (float) ((float) $data->CGST + (float) $data->SGST + (float) $data->IGST + (float) $data->CESS + (float) $data->TCS); 
            $this->excel->getActiveSheet()->getStyle('J'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('K'.$a,(float) $data->Netammount);
            $net += (float) $data->Netammount; 
            $this->excel->getActiveSheet()->getStyle('K'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('L'.$a,(float) $data->Balance_Amount);
            $balance += (float) $data->Balance_Amount; 
            $this->excel->getActiveSheet()->getStyle('L'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('M'.$a, $data->Status);
            $this->excel->getActiveSheet()->getStyle('M'.$a)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('M'.$a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $a++;
            $sr++;
        }
        $this->excel->getActiveSheet()->setCellValue('B'.($a+1), 'Total');
        $this->excel->getActiveSheet()->getStyle('B'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->setCellValue('D'.($a+1), $gross);
        $this->excel->getActiveSheet()->getStyle('D'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->getStyle('D'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00');
        $this->excel->getActiveSheet()->setCellValue('J'.($a+1), $tax);
        $this->excel->getActiveSheet()->getStyle('J'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->getStyle('J'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00');
        $this->excel->getActiveSheet()->setCellValue('K'.($a+1), $net);
        $this->excel->getActiveSheet()->getStyle('K'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->getStyle('K'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00');
        $this->excel->getActiveSheet()->setCellValue('L'.($a+1), $balance);
        $this->excel->getActiveSheet()->getStyle('L'.($a+1))->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('L'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00'); 
        $this->excel->getActiveSheet()->getStyle('B'.($a+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //Adding border to excel
        $this->excel->getActiveSheet()->getStyle("A1:M".($a+2))->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        //'color' => array('rgb' => 'DDDDDD')
                    )
                )
            )
        );
 
        $filename='Report_for_customer_'. strtoupper($customer->FirstName).'_'.strtoupper($customer->LastName).'.xlsx'; //save our workbook as this file name
 
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Cache-Control: max-age=0'); //no cache
        ob_get_clean();         
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as.XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    public function gstReport()
    {        
        $taxdetails = $this->Reports_model->GetFieldData('mst_taxes', "name, value","user_id=".id."","","");
        $data = array(
            'file' => 'Reports/gstReport',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage GST Report',
            'taxdetails' => $taxdetails
        );
        $this->load->view('layout', $data);
    } 
    public function gstReport_ajax()
    {
        $table = "invoice i";
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('Y-m-d',strtotime($_POST['start']));
            $end = date('Y-m-d',strtotime($_POST['end']));
            $cond = "i.user_id=".id ." and i.invoice_date >= '".$start."' AND i.invoice_date <= '".$end."'";
        } else {
            $cond = "i.user_id=".id ."";
        }
        $userData=$this->Reports_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            //$btn = anchor(site_url(INVOICES_VIEW.'/'.$usersData->id),'<button title="View" class="btn btn-sm btn-default waves-effect"><i class="fa fa-eye"></i></button>',['target'=>'_blank']);
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url(INVOICES_PAYMENT.'/'.base64_encode($usersData->id)),'<button title="Payment" class="btn btn-info btn-circle btn-sm"><i class="fa fa-money"></i></button>',['target'=>'_blank']);
            if($usersData->Status!='Pending')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            }
            else
            {
                $status =  "<label class='label-warning label'> Pending </label>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ($usersData->invoice_no !='')?$usersData->invoice_no:'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->invoice_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Gross_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->CGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->SGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->IGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->CESS);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->TCS);
            if($usersData->IGST != 0)
                $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia((float) $usersData->IGST + (float) $usersData->CESS + (float) $usersData->TCS );
            else
                $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia((float) $usersData->CGST + (float) $usersData->SGST + (float) $usersData->CESS + (float) $usersData->TCS);
            $nestedData[] = $status;
            //$nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Reports_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Reports_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function gstReportExcel()
    {
        $table = "invoice i";
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('Y-m-d',strtotime($_POST['start']));
            $end = date('Y-m-d',strtotime($_POST['end']));
            $cond = "i.user_id=".id ." and i.invoice_date >= '".$start."' AND i.invoice_date <= '".$end."'";
        } else {
            $cond = "i.user_id=".id ."";
        }
        $userData=$this->Reports_model->GetDataAll($table,$cond);
        $taxdetails = $this->Reports_model->GetFieldData('mst_taxes', "name, value","user_id=".id."","","");
        //print_r($userData);exit;
        //load our new PHPExcel library
        $this->load->library('excel');
        ob_start();
        // Set document properties
		$this->excel->getProperties()->setCreator(LOGO)
                                    ->setLastModifiedBy(name)
                                    ->setTitle("GST Report")
                                    ->setSubject("")
                                    ->setDescription("")
                                    ->setKeywords("")
                                    ->setCategory("");
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('GST Report');
        //set cell A1 content with some text
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('d-M-Y',strtotime($_POST['start']));
            $end = date('d-M-Y',strtotime($_POST['end']));
            $this->excel->getActiveSheet()->setCellValue('A1', 'GST Report For '.$start.' To '. $end);
        } else {
            $this->excel->getActiveSheet()->setCellValue('A1', 'GST Report');
        }
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        $this->excel->getActiveSheet()->getColumnDimensionByColumn('A2:J2')->setAutoSize(false);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Sr No.');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('4.42');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Invoice No');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('14');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Invoice Date');
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Gross Amount');
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('E2', 'CGST ('.$taxdetails[0]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('F2', 'SGST ('.$taxdetails[1]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('G2', 'IGST ('.$taxdetails[2]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('H2', 'CESS ('.$taxdetails[3]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('I2', 'TCS ('.$taxdetails[4]->value.'%)');
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('11');
        $this->excel->getActiveSheet()->setCellValue('J2', 'Total Tax Amount');
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('K2', 'Status');
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
        //set aligment to center for that merged cell (A1 to J1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(45);
        $a = 4;
        $sr = 1;
        $gross=0; $tax=0;
        foreach($userData as $data){
            $this->excel->getActiveSheet()->setCellValue('A'.$a, $sr);
            $this->excel->getActiveSheet()->setCellValue('B'.$a, ($data->invoice_no !='')?$data->invoice_no:'N/A');
            $this->excel->getActiveSheet()->setCellValue('C'.$a, date('d-M-Y',strtotime($data->invoice_date)));
            $this->excel->getActiveSheet()->setCellValue('D'.$a,(float) $data->Gross_amount );
            $gross += (float) $data->Gross_amount; 
            $this->excel->getActiveSheet()->getStyle('D'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('E'.$a,(float) $data->CGST );
            $this->excel->getActiveSheet()->getStyle('E'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('F'.$a,(float) $data->SGST );
            $this->excel->getActiveSheet()->getStyle('F'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('G'.$a,(float) $data->IGST );
            $this->excel->getActiveSheet()->getStyle('G'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('H'.$a,(float) $data->CESS );
            $this->excel->getActiveSheet()->getStyle('H'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('I'.$a,(float) $data->TCS );
            $this->excel->getActiveSheet()->getStyle('I'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            if($usersData->IGST != 0){
                $this->excel->getActiveSheet()->setCellValue('J'.$a,(float) $data->IGST + (float) $data->CESS + (float) $data->TCS );
            }
            else
                $this->excel->getActiveSheet()->setCellValue('J'.$a,(float) $data->CGST + (float) $data->SGST + (float) $data->CESS + (float) $data->TCS);
            $tax += (float) ((float) $data->CGST + (float) $data->SGST + (float) $data->IGST + (float) $data->CESS + (float) $data->TCS); 
            $this->excel->getActiveSheet()->getStyle('J'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('K'.$a, $data->Status);
            $this->excel->getActiveSheet()->getStyle('K'.$a)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('K'.$a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $a++;
            $sr++;
        }
        $this->excel->getActiveSheet()->setCellValue('B'.($a+1), 'Total');
        $this->excel->getActiveSheet()->getStyle('B'.($a+1))->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B'.($a+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
        $this->excel->getActiveSheet()->setCellValue('D'.($a+1), $gross);
        $this->excel->getActiveSheet()->getStyle('D'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->getStyle('D'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00');
        $this->excel->getActiveSheet()->setCellValue('J'.($a+1), $tax);
        $this->excel->getActiveSheet()->getStyle('J'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->getStyle('J'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00');
        //Adding border to excel
        $this->excel->getActiveSheet()->getStyle("A1:K".($a+2))->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        //'color' => array('rgb' => 'DDDDDD')
                    )
                )
            )
        );
 
        $filename='GST_Report.xlsx'; //save our workbook as this file name
 
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Cache-Control: max-age=0'); //no cache
        ob_get_clean();          
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as.XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    public function monthlyReport()
    {        
        $year = $this->Reports_model->GetFieldData('mst_financial_year', "id, DATE_FORMAT(from_date,'%M %Y') AS FROM_YEAR, DATE_FORMAT(to_date,'%M %Y') AS TO_YEAR","user_id=".id."","","id DESC");
        $data = array(
            'file' => 'Reports/report',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Monthly Report',
            'year'=>$year,
            'ajax' => MONTHLY_REPORT_AJAX,
            'excel_Report' => MONTHLY_REPORT_EXCEL,
            'table'=> "<th>Sr No</th>
                        <th>Customer Name</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Net Amount</th>
                        <th>Balance Amount</th>
                        <th>Status</th>
                        <th>Action</th>"
        );
        $this->load->view('layout', $data);
    } 
    public function monthlyReport_ajax()
    {
        $table = "invoice i";
        if(empty($_POST['SearchData']) && empty($_POST['fy'])){
            $cond = "i.user_id=".id ." and i.Status != 'Cancelled'";
        } else if(!empty($_POST['fy']) && empty($_POST['SearchData'])){
            $year = $this->Reports_model->GetData('mst_financial_year',"id=".$_POST['fy']);
            $cond = "i.user_id=".id ." and i.Status != 'Cancelled' and i.invoice_date BETWEEN '".date('Y-m-d',strtotime($year->from_date))."' and '".date('Y-m-d',strtotime($year->to_date))."'";
        } else {
            $cond = "i.user_id=".id ." and i.Status != 'Cancelled' and year(i.invoice_date) = '".date('Y', strtotime($_POST['SearchData']))."' AND monthname(i.invoice_date) = '".date('F', strtotime($_POST['SearchData']))."'";
        }
        $userData=$this->Reports_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            $id = enc_dec(1, $usersData->id);
            $btn1 = anchor(site_url(INVOICES_VIEW.'/'.$id),'<i class="fa fa-eye"></i>', array('title' => 'View Invoice', 'class'=>'btn btn-default btn-xs btn-flat'));
            if ($usersData->Status !='Cancelled'){
                if($usersData->Status!='Completed'){
                    $btn1 .=anchor(site_url(INVOICES_PAYMENT.'/'.$id),'<i class="fa fa-money"></i>', array('title' => 'Invoice Payment', 'class'=>'btn btn-info btn-xs btn-flat'));
                    $btn1 .= anchor(site_url(INVOICES_CANCEL.'/'.$id),'<i class="fa fa-trash"></i>', array('title' => 'Invoice Cancel', 'class'=>'btn btn-danger btn-xs btn-flat',"onclick"=>"return delete_opt('".$usersData->invoice_no."','".$usersData->id."');", "id"=>"delete".$usersData->id));
                }
            }
            $btn = '<div class="btn-group">'.$btn1.'</div>';
            if($usersData->Status=='Completed')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            } else if ($usersData->Status =='Cancelled'){
                $status =  "<label class='label-danger label'> Cancelled </label>";
            }
            else
            {
                $status =  "<label class='label-warning label'> Pending </label>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ucfirst($usersData->FirstName).' '.$usersData->LastName;
            $nestedData[] = ($usersData->invoice_no !='')?$usersData->invoice_no:'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->invoice_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Netammount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Balance_Amount);
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Reports_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Reports_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function monthlyReportExcel()
    {
        $table = "invoice i";
        if(empty($_POST['months']) && empty($_POST['years'])){
            $cond = "i.user_id=".id ." and i.Status != 'Cancelled'";
        } else if(!empty($_POST['years']) && empty($_POST['months'])){
            $year = $this->Reports_model->GetData('mst_financial_year',"id=".$_POST['years']);
            $cond = "i.user_id=".id ." and i.Status != 'Cancelled' and i.invoice_date BETWEEN '".date('Y-m-d',strtotime($year->from_date))."' and '".date('Y-m-d',strtotime($year->to_date))."'";
        } else {
            $cond = "i.user_id=".id ." and i.Status != 'Cancelled' and year(i.invoice_date) = '".date('Y', strtotime($_POST['months']))."' AND monthname(i.invoice_date) = '".date('F', strtotime($_POST['months']))."'";
        }
        $userData=$this->Reports_model->GetDataAll($table,$cond);
        //print_r($userData);exit;
        //load our new PHPExcel library
        $this->load->library('excel');
        // Set document properties
		$this->excel->getProperties()->setCreator(LOGO)
                                    ->setLastModifiedBy(name)
                                    ->setTitle("Monthly Report")
                                    ->setSubject("")
                                    ->setDescription("")
                                    ->setKeywords("")
                                    ->setCategory("");
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Monthly Report');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Report for the month of '.$_POST['months']);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->setCellValue('A2', 'Sr No.');			
        $this->excel->getActiveSheet()->setCellValue('B2', 'Customer Name');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Invoice No');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Invoice Date');
        $this->excel->getActiveSheet()->setCellValue('E2', 'Net Amount');
        $this->excel->getActiveSheet()->setCellValue('F2', 'Balance Amount');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Status');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        foreach(range('A','G') as $columnID)
        {
            $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $a = 4;
        $sr = 1;
        foreach($userData as $data){
            $this->excel->getActiveSheet()->setCellValue('A'.$a, $sr);
            $this->excel->getActiveSheet()->setCellValue('B'.$a, ucfirst($data->FirstName).' '.$data->LastName);
            $this->excel->getActiveSheet()->setCellValue('C'.$a, ($data->invoice_no !='')?$data->invoice_no:'N/A');
            $this->excel->getActiveSheet()->setCellValue('D'.$a, date('d-M-Y',strtotime($data->invoice_date)));
            $this->excel->getActiveSheet()->setCellValue('E'.$a,moneyFormatIndia($data->Netammount) );
            $this->excel->getActiveSheet()->setCellValue('F'.$a,moneyFormatIndia($data->Balance_Amount) );
            $this->excel->getActiveSheet()->setCellValue('G'.$a, $data->Status);
            $this->excel->getActiveSheet()->getStyle('G'.$a)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G'.$a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $a++;
            $sr++;
        }
 
        $filename='Report_For_Month_'.$_POST['months'].'.xlsx'; //save our workbook as this file name
 
        ob_end_clean();
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: '.date('D, d M Y H:i:s')); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    public function get_months() {
        $year = $this->Reports_model->GetData('mst_financial_year',"id=".$_POST['id']);
        $month = $this->Reports_model->GetFieldData('invoice', "DATE_FORMAT(invoice_date,'%M %Y') AS MONTH","user_id=".id." and invoice_date BETWEEN '".date('Y-m-d',strtotime($year->from_date))."' and '".date('Y-m-d',strtotime($year->to_date))."'","DATE_FORMAT(invoice_date,'%M')","DATE_FORMAT(invoice_date, '%m') DESC");
        echo json_encode($month);exit;
    }
    public function outstandingReport()
    {
        $year = $this->Reports_model->GetFieldData('mst_financial_year', "id, DATE_FORMAT(from_date,'%M %Y') AS FROM_YEAR, DATE_FORMAT(to_date,'%M %Y') AS TO_YEAR","user_id=".id."","","id DESC");
        $data = array(
            'file' => 'Reports/report',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Outstanding Report',
            'year'=>$year,
            'ajax' => OUTSTANDING_REPORT_AJAX,
            'excel_Report' => OUTSTANDING_REPORT_EXCEL,
            'table'=> "<th>Sr No</th>
                        <th>Customer Name</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Gross Amount</th>
                        <th>Total Tax Amount</th>
                        <th>Net Amount</th>
                        <th>Balance Amount</th>
                        <th>Status</th>"
        );
        $this->load->view('layout', $data);
    } 
    public function outstandingReport_ajax()
    {
        $table = "invoice i";
        if(empty($_POST['SearchData']) && empty($_POST['fy'])){
            $cond = "i.user_id=".id ." and i.status='Pending'";
        } else if(!empty($_POST['fy']) && empty($_POST['SearchData'])){
            $year = $this->Reports_model->GetData('mst_financial_year',"id=".$_POST['fy']);
            $cond = "i.user_id=".id ." and i.status='Pending' and i.invoice_date BETWEEN '".date('Y-m-d',strtotime($year->from_date))."' and '".date('Y-m-d',strtotime($year->to_date))."'";
        } else {
            $cond = "i.user_id=".id ." and i.status='Pending' and year(i.invoice_date) = '".date('Y', strtotime($_POST['SearchData']))."' AND monthname(i.invoice_date) = '".date('F', strtotime($_POST['SearchData']))."'";
        }
        $userData=$this->Reports_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            //$btn = anchor(site_url(INVOICES_VIEW.'/'.$usersData->id),'<button title="View" class="btn btn-sm btn-default waves-effect"><i class="fa fa-eye"></i></button>',['target'=>'_blank']);
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url(INVOICES_PAYMENT.'/'.base64_encode($usersData->id)),'<button title="Payment" class="btn btn-info btn-circle btn-sm"><i class="fa fa-money"></i></button>',['target'=>'_blank']);
            if($usersData->Status!='Pending')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            }
            else
            {
                $status =  "<label class='label-warning label'> Pending </label>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ucfirst($usersData->FirstName).' '.$usersData->LastName;
            $nestedData[] = ($usersData->invoice_no !='')?$usersData->invoice_no:'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->invoice_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Gross_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia((float) $usersData->CGST + (float) $usersData->SGST);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Netammount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Balance_Amount);
            $nestedData[] = $status;
            //$nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Reports_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Reports_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function outstandingReportExcel()
    {
        $table = "invoice i";
        if(empty($_POST['months']) && empty($_POST['years'])){
            $cond = "i.user_id=".id ." and i.status='Pending'";
        } else if(!empty($_POST['years']) && empty($_POST['months'])){
            $year = $this->Reports_model->GetData('mst_financial_year',"id=".$_POST['years']);
            $cond = "i.user_id=".id ." and i.status='Pending' and i.invoice_date BETWEEN '".date('Y-m-d',strtotime($year->from_date))."' and '".date('Y-m-d',strtotime($year->to_date))."'";
        } else {
            $cond = "i.user_id=".id ." and i.status='Pending' and year(i.invoice_date) = '".date('Y', strtotime($_POST['months']))."' AND monthname(i.invoice_date) = '".date('F', strtotime($_POST['months']))."'";
        }
        $userData=$this->Reports_model->GetDataAll($table,$cond);
        //print_r($userData);exit;
        //load our new PHPExcel library
        $this->load->library('excel');
        ob_start();
        // Set document properties
		$this->excel->getProperties()->setCreator(LOGO)
                                    ->setLastModifiedBy(name)
                                    ->setTitle("Outstanding Report")
                                    ->setSubject("")
                                    ->setDescription("")
                                    ->setKeywords("")
                                    ->setCategory("");
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Outstanding Report');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Outstanding Report for the month of '.$_POST['months']);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:I1');
        $this->excel->getActiveSheet()->setCellValue('A2', 'Sr No.');			
        $this->excel->getActiveSheet()->setCellValue('B2', 'Customer Name');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Invoice No');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Invoice Date');
        $this->excel->getActiveSheet()->setCellValue('E2', 'Gross Amount');
        $this->excel->getActiveSheet()->setCellValue('F2', 'Total Tax Amount');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Net Amount');
        $this->excel->getActiveSheet()->setCellValue('H2', 'Balance Amount');
        $this->excel->getActiveSheet()->setCellValue('I2', 'Status');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        foreach(range('A','I') as $columnID)
        {
            $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $a = 4;
        $sr = 1;
        foreach($userData as $data){
            $this->excel->getActiveSheet()->setCellValue('A'.$a, $sr);
            $this->excel->getActiveSheet()->setCellValue('B'.$a, ucfirst($data->FirstName).' '.$data->LastName);
            $this->excel->getActiveSheet()->setCellValue('C'.$a, ($data->invoice_no !='')?$data->invoice_no:'N/A');
            $this->excel->getActiveSheet()->setCellValue('D'.$a, date('d-M-Y',strtotime($data->invoice_date)));
            $this->excel->getActiveSheet()->setCellValue('E'.$a,moneyFormatIndia((float) $data->Gross_amount) );
            $this->excel->getActiveSheet()->setCellValue('F'.$a,moneyFormatIndia((float) $data->CGST + (float) $data->SGST) );
            $this->excel->getActiveSheet()->setCellValue('G'.$a,moneyFormatIndia($data->Netammount) );
            $this->excel->getActiveSheet()->setCellValue('H'.$a,moneyFormatIndia($data->Balance_Amount) );
            $this->excel->getActiveSheet()->setCellValue('I'.$a, $data->Status);
            $this->excel->getActiveSheet()->getStyle('I'.$a)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I'.$a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $a++;
            $sr++;
        }
 
        $filename='Outstanding_Report_For_Month_'.$_POST['months'].'.xlsx'; //save our workbook as this file name
 
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Cache-Control: max-age=0'); //no cache
        ob_get_clean();       
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as.XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    public function paymentReport()
    {        
        $customers = $this->Reports_model->GetFieldData('customers', "id, FirstName, LastName","user_id=".id."","","FirstName ASC");
        $data = array(
            'file' => 'Reports/paymentReport',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Payment Report',
            'customers'=>$customers
        );
        $this->load->view('layout', $data);
    } 
    public function paymentReport_ajax()
    {
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('Y-m-d',strtotime($_POST['start']));
            $end = date('Y-m-d',strtotime($_POST['end']));
            if($_POST['SearchData'] == '')
                $cond = "p.user_id=".id ." and p.payment_date >= '".$start."' AND p.payment_date <= '".$end."'";
            else
                $cond = "p.user_id=".id ." and p.Customer_id = ".$_POST['SearchData']." and p.payment_date >= '".$start."' AND p.payment_date <= '".$end."'";
        } else {
            if($_POST['SearchData'] == '')
                $cond = "p.user_id=".id ."";
            else
                $cond = "p.user_id=".id ." and p.Customer_id = ".$_POST['SearchData']."";
        }
        $table = "invoice_payments p";
        $userData=$this->Reports_model->get_datatables_payment($table,$cond);
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            //$btn = anchor(site_url(INVOICES_VIEW.'/'.$usersData->id),'<button title="View" class="btn btn-sm btn-default waves-effect"><i class="fa fa-eye"></i></button>',['target'=>'_blank']);
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url(INVOICES_PAYMENT.'/'.base64_encode($usersData->id)),'<button title="Payment" class="btn btn-info btn-circle btn-sm"><i class="fa fa-money"></i></button>',['target'=>'_blank']);
            if($usersData->status!='Pending')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            }
            else
            {
                $status =  "<label class='label-warning label'> Pending </label>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ucfirst($usersData->FirstName).' '.$usersData->LastName;
            $nestedData[] = ($usersData->invoice_no !='')?$usersData->invoice_no:'N/A';
            $nestedData[] = ($usersData->receipt_no !='')?$usersData->receipt_no:'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->payment_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->billed_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->payed_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->balance_amount);
            $nestedData[] = $usersData->payment_type;
            $nestedData[] = $status;
            //$nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Reports_model->count_all_payment($table,$cond),
                    "recordsFiltered" => $this->Reports_model->count_filtered_payment($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function paymentReport_excel(){
        if($_POST['start'] != '' && $_POST['end'] != ''){
            $start = date('Y-m-d',strtotime($_POST['start']));
            $end = date('Y-m-d',strtotime($_POST['end']));
            if($_POST['months'] == '')
                $cond = "p.user_id=".id ." and p.payment_date >= '".$start."' AND p.payment_date <= '".$end."'";
            else
                $cond = "p.user_id=".id ." and p.Customer_id = ".$_POST['months']." and p.payment_date >= '".$start."' AND p.payment_date <= '".$end."'";
        } else {
            if($_POST['months'] == '')
                $cond = "p.user_id=".id ."";
            else
                $cond = "p.user_id=".id ." and p.Customer_id = ".$_POST['months']."";
        }
        $table = "invoice_payments p";
        $userData=$this->Reports_model->GetDataAllPayment($table,$cond,"","p.id");
        //load our new PHPExcel library
        $this->load->library('excel');
        // Set document properties
		$this->excel->getProperties()->setCreator(LOGO)
                                    ->setLastModifiedBy(name)
                                    ->setTitle("Payment Report")
                                    ->setSubject("")
                                    ->setDescription("")
                                    ->setKeywords("")
                                    ->setCategory("");
		//activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Payment Report');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:I1');
        $this->excel->getActiveSheet()->getColumnDimensionByColumn('A2:H2')->setAutoSize(false);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Sr No.');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('4.42');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Customer Name');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Invoice No');
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('14');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Receipt No');
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('14');
        $this->excel->getActiveSheet()->setCellValue('E2', 'Payment Date');
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('F2', 'Billed Amount');
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('G2', 'Payment Amount');
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('H2', 'Balance Amount');
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('12');
        $this->excel->getActiveSheet()->setCellValue('I2', 'Status');
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
        //set aligment to center for that merged cell (A1 to J1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER );
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(45);
        $a = 4;
        $sr = 1;
        $payment = 0;

        foreach($userData as $data){
            //set cell A1 content with some text
            if($_POST['start'] != '' && $_POST['end'] != ''){
                $start = date('d-M-Y',strtotime($_POST['start']));
                $end = date('d-M-Y',strtotime($_POST['end']));
                if($_POST['months'] == '')
                    $this->excel->getActiveSheet()->setCellValue('A1', 'Payment Report From '.$start.' To '. $end);
                else
                    $this->excel->getActiveSheet()->setCellValue('A1', 'Customer Payment Report Of '. $data->FirstName.' '.$data->LastName.' For '.$start.' To '. $end);
                
            } else {
                if($_POST['months'] == '')
                    $this->excel->getActiveSheet()->setCellValue('A1', 'Payment Report');
                else
                    $this->excel->getActiveSheet()->setCellValue('A1', 'Customer Payment Report Of '. $data->FirstName.' '.$data->LastName);
            }
            $this->excel->getActiveSheet()->setCellValue('A'.$a, $sr);
            $this->excel->getActiveSheet()->setCellValue('B'.$a, ucfirst($data->FirstName).' '.$data->LastName);
            $this->excel->getActiveSheet()->setCellValue('C'.$a, ($data->invoice_no !='')?$data->invoice_no:'N/A');
            $this->excel->getActiveSheet()->setCellValue('D'.$a, ($data->receipt_no !='')?$data->receipt_no:'N/A');
            $this->excel->getActiveSheet()->setCellValue('E'.$a,date('d-M-Y',strtotime($data->payment_date)) );
            $this->excel->getActiveSheet()->setCellValue('F'.$a,(float) $data->billed_amount );
            $this->excel->getActiveSheet()->getStyle('F'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('G'.$a,(float) $data->payed_amount );
            $payment += (float) $data->payed_amount;
            $this->excel->getActiveSheet()->getStyle('G'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('H'.$a,(float) $data->balance_amount);
            $this->excel->getActiveSheet()->getStyle('H'.$a)->getNumberFormat()->setFormatCode('#,##0.00');
            $this->excel->getActiveSheet()->setCellValue('I'.$a, $data->status);
            $this->excel->getActiveSheet()->getStyle('I'.$a)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I'.$a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $a++;
            $sr++;
            if($_POST['months'] == '')
                $filename='Report_for_payment.xlsx'; //save our workbook as this file name
            else
                $filename='Report_for_customer_payment_'. strtoupper($data->FirstName).'_'.strtoupper($data->LastName).'.xlsx'; //save our workbook as this file name
        }
        if(empty($userData)){
            $filename='Report_for_payment.xlsx';
        }
        $this->excel->getActiveSheet()->setCellValue('B'.($a+1), 'Total');
        $this->excel->getActiveSheet()->getStyle('B'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->setCellValue('G'.($a+1), (float) $payment);
        $this->excel->getActiveSheet()->getStyle('G'.($a+1))->getFont()->setBold(true);  
        $this->excel->getActiveSheet()->getStyle('G'.($a+1))->getNumberFormat()->setFormatCode('#,##0.00');
        $this->excel->getActiveSheet()->getStyle('B'.($a+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //Adding border to excel
        $this->excel->getActiveSheet()->getStyle("A1:I".($a+2))->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        //'color' => array('rgb' => 'DDDDDD')
                    )
                )
            )
        );
        
		ob_end_clean();
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: '.date('D, d M Y H:i:s')); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter->save('php://output');
        exit;
    }
    public function send_mail($id){
        $id = enc_dec(2, $id);
        $this->load->helper('pdf_helper');
        $table = "invoice i";
        $table2 = "invoice_items i";
        $table3 = "settings";
        $table4 = "bank_details";
        $cond = "i.id=".$id;
        $cond2 = "i.Invoice_id=".$id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $cond3 = "user_id=".id;
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $data4 = $this->Invoices_model->GetFieldData($table4,'', $cond3);
        $user_data = $this->Invoices_model->GetFieldData('users','username,email,mobile',"id='".id."'",'','','1','1');
        $mail = $this->Mymodel->GetData("mails_body","type='invoice_mail_reminder'");
        $data = array(
                'data'=>$data,
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3,
                'bank_details' => $data4
            );
        $this->load->view('Invoices/pdf', $data); 
        $mpdf_html = $this->load->view('Invoices/pdf', '', true);
        tcpdf();
        $obj_pdf = new TCPDF('P','mm', 'A4', true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $title = $data['data']->invoice_no;
        $obj_pdf->SetTitle($title);
        $obj_pdf->SetHeaderMargin(0);
        $obj_pdf->SetFont('times', '', 10);
        $obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();
        // set cell padding
        $obj_pdf->setCellPaddings(0, 0, 0, 0);
        // set cell margins
        $obj_pdf->setCellMargins(0, 0, 0, 0);
        // we can have any view part here like HTML, PHP etc
        $obj_pdf->writeHTML($mpdf_html, true, false, true, false, '');
        // output the HTML content
        $obj_pdf->Output(FCPATH.'assets/upload/'.str_replace("/","_",$data['data']->invoice_no).'_'.date('d_M_y').'.pdf', 'F');
        $fileatt = FCPATH.'assets/upload/'.str_replace("/","_",$data['data']->invoice_no).'_'.date('d_M_y').'.pdf';
        $subject = $mail->subject;
        $mail_body = $mail->body;
        $subject = str_replace("{{invoice_no}}",$data['data']->invoice_no,$subject);
        $subject = str_replace("{{customer}}",$data['data']->FirstName.' '.$data['data']->LastName,$subject);

        $mail_body = str_replace("{{invoice_no}}",$data['data']->invoice_no,$mail_body);
        $mail_body = str_replace("{{customer}}",$data['data']->FirstName.' '.$data['data']->LastName,$mail_body);
        $mail_body = str_replace("{name}",$user_data->username,$mail_body);
        $mail_body = str_replace("{{billed_amount}}","Rs. ".moneyFormatIndia($data['data']->Netammount),$mail_body);
        $mail_body = str_replace("{{amount_words}}",convert_number($data['data']->Netammount),$mail_body);
        $mail_body = str_replace("{{bill_date}}",date('d-M-Y', strtotime($data['data']->invoice_date)),$mail_body);
        $mail_body = str_replace("{{conpany_name}}",$data['settings'][0]->value,$mail_body);
        if($data['data']->Email != ''){
            $email = array($user_data->email,$data['data']->Email);
        } else {
            $email = array($user_data->email);
        }
        if($data['data']->waybill_file != ''){
            $waybill = FCPATH.'assets/upload/sales_waybill_pdf/'.$data['data']->waybill_file;
        } else {
            $waybill = "";
        }
        $this->custom->sendEmailSmtp($subject,$mail_body,$email,$fileatt, array($data['settings'][12]->value,$data['settings'][0]->value), $waybill);
        //redirect(INVOICES);
        redirect(INVOICES_VIEW.'/'.enc_dec(1, $id));
    }
 }
?>