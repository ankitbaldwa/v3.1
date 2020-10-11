<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Admin_Parent {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Purchase_model');
        $this->load->model('Purchase_Payments_model');
        $this->load->library('session');
        /*keep this code for mail */
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
        if(isset($this->session->userdata('logged_in')['id'])){
            $login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
            define('name',$login_name->username);
            define('id',$this->session->userdata('logged_in')['id']);
            define('last_login',$login_name->last_login);
			define('profile',$login_name->profile);
        } 
    }
    public function index()
    {        
        $data = array(
            'file' => 'Purchase/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Purchase Bills'
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $table = "purchase_invoice i";
        $cond = "i.user_id=".id;
        $userData=$this->Purchase_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0;    
        foreach ($userData as $usersData) 
        {
            $btn = anchor(site_url(PURCHASE_VIEW.'/'.$usersData->id),'<button title="View" class="btn btn-xs btn-default waves-effect"><i class="fa fa-eye"></i></button>');
            $btn .='&nbsp;|&nbsp;'.anchor(site_url(PURCHASE_PAYMENT.'/'.base64_encode($usersData->id)),'<button title="Payment" class="btn btn-info btn-circle btn-xs"><i class="fa fa-money"></i></button>');
            $btn .= '&nbsp;|&nbsp;'.anchor(site_url(INVOICES_PDF.'/'.$usersData->id),'<button title="Download PDF" class="btn btn-primary btn-circle btn-xs"><i class="fa fa-files-o"></i></button>');
           // $btn .= '&nbsp;|&nbsp;'.anchor(site_url(SEND_MAIL.'/'.$usersData->id),'<button title="Send Mail" class="btn btn-success btn-circle btn-sm"><i class="fa fa-paper-plane"></i></button>');
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
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Netammount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Balance_Amount);
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Purchase_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Purchase_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE INVOICE
    public function create(){
        $userdata = $this->Purchase_model->GetData('users',"id=".id);
        $customersdata = $this->Purchase_model->GetDataAll('suppliers','User_id='.id);
        $productsdata = $this->Purchase_model->GetFieldData('products','id,Name','User_id='.id);
        $CGST_per = $this->Purchase_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='CGST'",'','','1','1');
        $SGST_per = $this->Purchase_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='SGST'",'','','1','1');
        $IGST_per = $this->Purchase_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='IGST'",'','','1','1');
        $CESS_value = $this->Purchase_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='CESS'",'','','1','1');
        $TCS_per = $this->Purchase_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='TCS'",'','','1','1');
        $data = array(
            'file' => 'Purchase/form',
            'heading' => 'Create Purchase Bill',
            'body_class'=>BODY_CLASS,
            'action'=>site_url(PURCHASE_ADD_ACTION),
            'userdata'=>$userdata,
            'customersdata'=>$customersdata,
            'CGST_per'=>$CGST_per->value,
            'SGST_per'=>$SGST_per->value,
            'IGST_per'=>$IGST_per->value,
            'CESS'=>$CESS_value->value,
            'TCS_per'=>$TCS_per->value,
            'Product'=>$productsdata
        );
        $this->load->view('layout', $data);
    }
    public function get_Products(){
    	$productsdata = $this->Purchase_model->GetFieldData('products','id,Hsn_code,Unit,Cost',"id=".$_POST['id'],'','','','1');
    	$data = array(
    		'Hsn_code'=>$productsdata->Hsn_code,
    		'Unit'=>$productsdata->Unit,
    		'Cost'=>$productsdata->Cost
    	); 
		print_r(json_encode($data));exit();
    }
    public function create_action()
    {
        $table = "purchase_invoice";
		$_POST['waybill_file'] = 'Waybill_'.$_FILES['waybill_file']['name'];
		$targetfolder = FCPATH."/assets/upload/waybill_pdf/";

		$targetfolder = $targetfolder . basename('Waybill_'.$_FILES['waybill_file']['name']);
		move_uploaded_file($_FILES['waybill_file']['tmp_name'], $targetfolder);
        $data = array(
       		'user_id'=>$_POST['user_id'],
       		'Suppliers_id'=>$_POST['Suppliers_id'],
       		'invoice_no'=>$_POST['invoice_no'],
       		'invoice_date'=>date('Y-m-d', strtotime(str_replace('-', '/', $_POST['invoice_date']))),
       		'Lorry_no'=>$_POST['Lorry_no'],
       		'waybill'=>$_POST['waybill'],
			'waybill_file'=>$_POST['waybill_file'],
       		'Place'=>$_POST['Place'],
       		'Gross_amount'=>$_POST['Gross_amount'],
       		'Additional_amount'=>$_POST['Additional_amount'],
       		'CGST_percentage'=>$_POST['CGST_percentage'],
       		'SGST_percentage'=>$_POST['SGST_percentage'],
       		'IGST_percentage'=>$_POST['IGST_percentage'],
            'CESS_value'=>$_POST['CESS_value'],
            'TCS_percentage'=>$_POST['TCS_percentage'],
       		'CGST'=>$_POST['CGST'],
       		'SGST'=>$_POST['SGST'],
       		'IGST'=>$_POST['IGST'],
            'CESS'=>$_POST['CESS'],
            'TCS'=>$_POST['TCS'],
       		'Roundoff'=>$_POST['Roundoff'],
       		'Netammount'=>$_POST['Netammount'],
       		'Balance_Amount'=>$_POST['Netammount'],
       		'Timestamp'=>date('Y-m-d H:i:s'),
       		'Status'=>'Pending'
       );
       $last_id = $this->Purchase_model->SaveData($table,$data);
       //print_r($this->db->last_query());exit;
       for($i = 0; $i< count($_POST['Product_id']); $i++){
       		$inv_details = array(
       			'Purchase_Invoice_id'=>$last_id,
       			'Product_id'=>$_POST['Product_id'][$i],
       			'Hsn_code'=>$_POST['Hsn_code'][$i],
       			'Qty'=>$_POST['Qty'][$i],
       			'Price'=>$_POST['Price'][$i],
       			'Amount'=>$_POST['Amount'][$i]
       		);
       		$last_id1 = $this->Purchase_model->SaveData('purchase_invoice_items',$inv_details);
       }
        if(isset($last_id)){
            $userLogs_data = array(
                'user_id'=>id,
                'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                'description'=>'Purchase Bill Generated by '.name.' with Invoice no '.$_POST['invoice_no'],
                'ip_address'=>$_SERVER['SERVER_ADDR']
            );
            $result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
            redirect(site_url(PURCHASE_VIEW.'/'.$last_id));
        }
    }
    public function view($id){
        $this->load->library('Numbertowordconvertsconver');
        $table = "purchase_invoice i";
        $table2 = "purchase_invoice_items i";
        $table3 = "settings";
        $cond = "i.id=".$id;
        $cond2 = "i.Purchase_Invoice_id=".$id;
        $data = $this->Purchase_model->GetInvcData($table,$cond);
        $data2 = $this->Purchase_model->GetInvcDetail($table2,$cond2);
        $cond3 = "user_id=".id;
        $data3 = $this->Purchase_model->GetFieldData($table3,'name, value', $cond3);
        $user_data = $this->Purchase_model->GetFieldData('users','username,email,mobile',"id='".$data->user_id."'",'','','1','1');
        $data = array(
                'file' => 'Purchase/view',
                'heading' => 'View Purchase Bill',
                'body_class'=>'hold-transition skin-blue sidebar-mini',
                'data'=>$data,
                'Net_amt_words' => $this->numbertowordconvertsconver->convert_number($data->Netammount),
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3
            );
        $this->load->view('layout', $data); 
    }
    public function receipt($id){
        $this->load->library('Numbertowordconvertsconver');
        $table = "purchase_invoice i";
        $table2 = "purchase_invoice_items i";
        $table4 = "purchase_invoice_payments";
        $table3 = "settings";
        $cond = "i.id=".$id;
        $cond2 = "i.Purchase_Invoice_id=".$id;
        $data = $this->Purchase_model->GetInvcData($table,$cond);
        $data2 = $this->Purchase_model->GetInvcDetail($table2,$cond2);
        $cond3 = "user_id=".id;
        $cond4 = "user_id=".id." and purchase_invoice_id = ".$id;
        $data3 = $this->Purchase_model->GetFieldData($table3,'name, value', $cond3);
        $data4 = $this->Purchase_model->GetFieldData($table4,'*', $cond4);
        $data = array(
            'file' => 'Payments/receipt',
            'id' => $id,
            'body_class'=>BODY_CLASS,
            'heading'=>'Payments Receipt',
            'settings' => $data3,
            'receipt' => $data4[0],
            'invoice_details' => $data
        );
        $this->load->view('layout', $data);
    }
    public function payments($id){
        $id = base64_decode($id);
        $table = "purchase_invoice i";
        $cond = "i.id=".$id;
        $data = $this->Purchase_Payments_model->GetInvcData($table,$cond);
        $user_data = $this->Purchase_Payments_model->GetFieldData('settings','name,value',"user_id='".id."'",'','','','');
        $data = array(
            'file' => 'Purchase_Payments/list',
            'id' => $id,
            'data'=>$data,
            'user_data'=>$user_data,
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Purchase Bill Payments'
        );
        $this->load->view('layout', $data);
    }
    public function payment_ajax($id)
    {  
        $table = "purchase_invoice i";
        $cond = "p.user_id=".id ." and p.purchase_invoice_id = ".$id;
        $userData=$this->Purchase_Payments_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            $btn = anchor(site_url(PURCHASE_PAYMENT_RECEIPT.'/'.$usersData->payment_id),'<button title="Print" class="btn btn-xs btn-default waves-effect"><i class="fa fa-print"></i></button>',['target'=>'_blank']);
            if($usersData->payment_status =='Completed')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            }
            else
            {
                $status =  "<label class='label-warning label'> Canceled </label>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ($usersData->receipt_no !='')?$usersData->receipt_no:'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->payment_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->billed_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->payed_amount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->payment_bal_amt);
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Purchase_Payments_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Purchase_Payments_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function payments_add($id){
        $table = "purchase_invoice i";
        $cond = "i.id=".$id;
        $data = $this->Purchase_Payments_model->GetInvcData($table,$cond);
        $user_data = $this->Purchase_Payments_model->GetFieldData('settings','name,value',"user_id='".id."'",'','','','');
        $lastId = $this->Purchase_Payments_model->GetFieldData('purchase_invoice_payments','id',"user_id='".id."'",'','id DESC','1','1');
        if(empty($lastId)){
            $lst_id = 1;
        } else {
            $lst_id = (int) $lastId->id + 1;
        }
        if (date('m') <= 3) {
		   $financial_year = (date('y')-1) . '-' . date('y');
		} else {
		   $financial_year = date('y') . '-' . (date('y') + 1);
		}
        $data = array(
            'file' => 'Purchase_Payments/form',
            'id' => $id,
            'data'=>$data,
            'user_data'=>$user_data,
            'body_class'=>BODY_CLASS,
            'heading'=>'Purchase Bill Payment',
            'action' => site_url(PURCHASE_PAYMENT_ADD_ACTION).'/'.$id,
            'receipt_no'=>'PAY/'.$financial_year.'/'.str_pad($lst_id, 3, '0', STR_PAD_LEFT)
        );
        $this->load->view('layout', $data);
    }
    public function payment_action($id)
    {
        $table = "purchase_invoice";
        if($_POST['balance_amount'] == 0){
            $data = array(
                'Balance_Amount' => $_POST['balance_amount'],
                'Status' => 'Completed'
            );
        } else {
            $data = array(
                'Balance_Amount' => $_POST['balance_amount']
            );
        }
        $last_id = $this->Purchase_Payments_model->SaveData($table,$data,'id='.$_POST['invoice_id']);
        $table2 = "purchase_invoice_payments";
        $data2 = array(
            'user_id' => id,
            'purchase_invoice_id' => $_POST['invoice_id'],
            'suppliers_id' => $_POST['customer_id'],
            'receipt_no' => $_POST['receipt_no'],
            'payment_date' => date('Y-m-d', strtotime(str_replace('-', '/', $_POST['payment_date']))),
            'billed_amount' => $_POST['billed_amount'],
            'payed_amount' => $_POST['payed_amount'],
            'payment_type' => $_POST['payment_type'],
            'payment_description' => $_POST['payment_description'],
            'balance_amount' => $_POST['balance_amount'],
            'timestamp'=>date('Y-m-d H:i:s'),
            'created'=>date('Y-m-d H:i:s'),
            'status' => 'Completed'
        );
        $last_id2 = $this->Purchase_Payments_model->SaveData($table2,$data2);
        if(isset($last_id) && isset($last_id2)){
           $userLogs_data = array(
                'user_id'=>id,
                'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                'description'=>'Purchase Bill Payment paid by '.name.' with Receipt no '.$_POST['receipt_no'],
                'ip_address'=>$_SERVER['SERVER_ADDR']
            );
            $result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
            redirect(PURCHASE_PAYMENT.'/'.base64_encode($id));
        }
    }
    public function Inv_print($user_id){
        $user_id=base64_decode($user_id);
        $this->load->library('Numbertowordconvertsconver');
        $table = "purchase_invoice i";
        $table2 = "purchase_invoice_items i";
        $table3 = "settings";
        $table4 = "bank_details";
        $cond = "i.id=".$user_id;
        $cond2 = "i.Purchase_Invoice_id=".$user_id;
        $data = $this->Purchase_model->GetInvcData($table,$cond);
        $cond3 = "user_id=".id;
        $data2 = $this->Purchase_model->GetInvcDetail($table2,$cond2);
        $data3 = $this->Purchase_model->GetFieldData($table3,'name, value', $cond3);
        $user_data = $this->Purchase_model->GetFieldData('users','username,email,mobile',"id='".id."'",'','','1','1');
        $data = array(
                'data'=>$data,
                'Net_amt_words' => $this->numbertowordconvertsconver->convert_number($data->Netammount),
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3
            );
        $this->load->view('Purchase/print', $data); 
    }
    public function Inv_pdf($user_id){
        $this->load->helper('pdf_helper');
        $this->load->library('M_pdf');
        $table = "purchase_invoice i";
        $table2 = "purchase_invoice_items i";
        $table3 = "settings";
        $cond = "i.id=".$user_id;
        $cond2 = "i.Purchase_Invoice_id=".$user_id;
        $data = $this->Purchase_model->GetInvcData($table,$cond);
        $cond3 = "user_id=".id;
        $data2 = $this->Purchase_model->GetInvcDetail($table2,$cond2);
        $data3 = $this->Purchase_model->GetFieldData($table3,'name, value', $cond3);
        $user_data = $this->Purchase_model->GetFieldData('users','username,email,mobile',"id='".id."'",'','','1','1');
        $data = array(
                'data'=>$data,
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3
            );
       $mpdf_html = $this->load->view('Purchase/pdf', $data, true);
        $mpdf = new mPDF(); 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($mpdf_html);
        $mpdf->Output($data['data']->invoice_no.'_'.date('d_M_y').'.pdf', 'I'); 
       //print_r($mpdf_html);exit;
        //$this->load->view('pdf', array('pdfHTML' => $mpdf_html,'incoice_no'=>$data['data']->invoice_no)); 
    }
    public function receipt_pdf($id){
        $this->load->helper('pdf_helper');
        //$this->load->helper('mpdf_helper');
        $this->load->library('Numbertowordconvertsconver');
        $this->load->library('M_pdf');
        $table = "purchase_invoice i";
        $table2 = "purchase_invoice_items i";
        $table4 = "purchase_invoice_payments";
        $table3 = "settings";
        $cond = "i.id=".$id;
        $cond2 = "i.Purchase_Invoice_id=".$id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $cond3 = "user_id=".id;
        $cond4 = "user_id=".id." and purchase_invoice_id = ".$id;
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $data4 = $this->Invoices_model->GetFieldData($table4,'', $cond4);
        $data = array(
            'id' => $id,
            'heading'=>'Purchase Bill Payments Receipt',
            'settings' => $data3,
            'receipt' => $data4[0],
            'invoice_details' => $data
        );
        $this->load->view('Pruchase_Payments/receipt', $data);
        $mpdf_html = $this->load->view('Purchase/pdf', '', true);
        $mpdf = new mPDF(); 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($mpdf_html);
        $mpdf->Output($incoice_no.'_'.date('d_M_y').'.pdf', 'I');
        //$this->load->view('pdf', array('pdf' => $mpdf_html,'incoice_no'=>$data4[0]->receipt_no));
    }
    public function inv_mail($id){
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
        $mail = $this->Mymodel->GetData("mails_body","type='invoice_mail'");
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
        $this->custom->sendEmailSmtp($subject,$mail_body,$email,$fileatt, $data['settings'][0]->value);
        redirect(INVOICES_VIEW.'/'.$id);
    }
 }
?>
