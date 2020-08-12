<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Invoices_model');
        $this->load->model('Payments_model');
        $this->load->library('session');
        /*keep this code for mail */
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        /** Load comapny details and database */
		$this->company = get_company();
        $this->db = load_db($this->company);
		/** Load comapny details and database */
        if(isset($this->session->userdata('logged_in')['id'])){
            $login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
            define('name',$login_name->username);
            define('id',$this->session->userdata('logged_in')['id']);
            define('last_login',$login_name->last_login);
            $setting_data = $this->Mymodel->GetDataArray('settings',"","user_id='".$this->session->userdata('logged_in')['id']."' and (name='Company Name' or name='Invoice_no')");
			if($setting_data[0]['name'] == 'Company Name')
				define('LOGO',$setting_data[0]['value']);
			if($setting_data[1]['name'] == 'Invoice_no')
				define('LOGO_MINI', $setting_data[1]['value']);
			define('profile',$login_name->profile);
        } 
    }
    public function index()
    {        
        $data = array(
            'file' => 'Invoices/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Sales Bills'
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $table = "invoice i";
        $cond = "i.user_id=".id;
        $userData=$this->Invoices_model->get_datatables($table,$cond);
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
            //$btn1 .= '<li>'.anchor(site_url(SEND_MAIL.'/'.$usersData->id),'<i class="fa fa-paper-plane"></i> Send Mail').'</li>';
            //$btn1 .= '<li>'.anchor(site_url(INVOICES_PDF.'/'.$usersData->id),'<i class="fa fa-files-o"></i> View PDF').'</li>';
            //$btn1 .= '<li>'.anchor(base_url().'assets/upload/sales_waybill_pdf/'.$usersData->waybill_file,'<i class="fa fa-file-pdf-o"></i> View WayBill',['target' => '_blank']).'</li>';
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
            $nestedData[] = ($usersData->invoice_no !='')?anchor(site_url(INVOICES_VIEW.'/'.enc_dec(1, $usersData->id)),$usersData->invoice_no, array('title' => 'View Invoice')):'N/A';
            $nestedData[] = date('d-M-Y',strtotime($usersData->invoice_date));
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Netammount);
            $nestedData[] = '<i class="fa fa-inr"></i> '.moneyFormatIndia($usersData->Balance_Amount);
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Invoices_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Invoices_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE INVOICE
    public function create(){
        $userdata = $this->Invoices_model->GetData('users',"id=".id);
        $customersdata = $this->Invoices_model->GetDataAll('customers','User_id='.id);
        $productsdata = $this->Invoices_model->GetFieldData('products','id,Name','User_id='.id);
        $CGST_per = $this->Invoices_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='CGST'",'','','1','1');
        $SGST_per = $this->Invoices_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='SGST'",'','','1','1');
        $IGST_per = $this->Invoices_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='IGST'",'','','1','1');
        $CESS_value = $this->Invoices_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='CESS'",'','','1','1');
        $TCS_per = $this->Invoices_model->GetFieldData('mst_taxes','value',"user_id='".id."' and name='TCS'",'','','1','1');
        $lastId = $this->Invoices_model->GetDataAll('invoice',"user_id='".id."' and Status!='Cancelled'");
        $incoice_startfrom = $this->Invoices_model->GetFieldData('settings','value',"user_id='".id."' and name='Invoice_no'",'','id DESC','1','1');
        $invoice_no = $this->Invoices_model->GetFieldData('settings','value',"user_id='".id."' and name='Invoice_no_start'",'','id DESC','1','1');
        $invoice_separator = $this->Invoices_model->GetFieldData('settings','value',"user_id='".id."' and name='invoice_separator'",'','id DESC','1','1');
        $fy = $this->Invoices_model->GetFieldData('mst_financial_year','',"user_id='".id."' and status='Active'",'','id DESC','1','1');
        $lastCancel = $this->Invoices_model->GetFieldData('invoice',array('invoice_no'),"Status='Cancelled'","","");
        if(empty($lastId)){
            $id = $invoice_no->value;
        } else {
            $id = $invoice_no->value;
            $id = (int) $id + count($lastId);
        }
        $financial_year = (date('y', strtotime($fy->from_date))) . '-' . date('y', strtotime($fy->to_date));
        $flag = 0;
        foreach($lastCancel as $value){
            $Inv_exist = $this->Invoices_model->GetFieldData('invoice',array('count(invoice_no) as count'),"Status!='Cancelled' and invoice_no='".$value->invoice_no."'","","","1","1");
            //If already exist
            if($Inv_exist->count > 0){ // True
                $flag = 0;
            } else { //false
                $inv_no = $value->invoice_no;
                $flag = 1;
                break;
            }
        } 
        if($flag == 0){
            //Gengerate New Invoice No
            $inv_no = $incoice_startfrom->value.$invoice_separator->value.$id.'/'.$financial_year;
        } else {
            $inv_no = $inv_no;
        }
        $data = array(
            'file' => 'Invoices/form',
            'heading' => 'Create Sale Bill',
            'body_class'=>BODY_CLASS,
            'action'=>site_url(INVOICES_ADD_ACTION),
            'userdata'=>$userdata,
            'customersdata'=>$customersdata,
            'CGST_per'=>$CGST_per->value,
            'SGST_per'=>$SGST_per->value,
            'IGST_per'=>$IGST_per->value,
            'CESS'=>$CESS_value->value,
            'TCS_per'=>$TCS_per->value,
            'Product'=>$productsdata,
            'Product'=>$productsdata,
            'invoice_no'=> $inv_no
        );
        $this->load->view('layout', $data);
    }
	public function Get_GSTIN(){
		$table = "customers";
		$cond = "id=".$_POST['id'];
		$data = $this->Invoices_model->GetData($table,$cond);
		print_r(json_encode($data));exit;
	}
    public function get_Products(){
    	$productsdata = $this->Invoices_model->GetFieldData('products','id,Hsn_code,Unit,Cost',"id=".$_POST['id'],'','','','1');
    	$data = array(
    		'Hsn_code'=>$productsdata->Hsn_code,
    		'Unit'=>$productsdata->Unit,
    		'Cost'=>$productsdata->Cost
    	); 
		print_r(json_encode($data));exit();
    }
    public function create_action()
    {
        $table = "invoice";
        if($_FILES['waybill_file']['error'] == 0){
    		$_POST['waybill_file'] = 'Waybill_'.$_FILES['waybill_file']['name'];
    		$targetfolder = FCPATH."/assets/upload/sales_waybill_pdf/";
    
    		$targetfolder = $targetfolder . basename('Waybill_'.$_FILES['waybill_file']['name']);
    		move_uploaded_file($_FILES['waybill_file']['tmp_name'], $targetfolder);
        } else {
            $_POST['waybill_file'] = "";
        }
        $data = array(
       		'user_id'=>$_POST['user_id'],
       		'Customer_id'=>$_POST['Customer_id'],
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
       		'CGST'=>$_POST['CGST'],
       		'SGST'=>$_POST['SGST'],
       		'IGST'=>$_POST['IGST'],
       		'CESS_value'=>$_POST['CESS_value'],
            'TCS_percentage'=>$_POST['TCS_percentage'],
            'CESS'=>$_POST['CESS'],
            'TCS'=>$_POST['TCS'],
       		'Roundoff'=>$_POST['Roundoff'],
       		'Netammount'=>$_POST['Netammount'],
       		'Balance_Amount'=>$_POST['Netammount'],
       		'Timestamp'=>date('Y-m-d H:i:s'),
       		'Status'=>'Pending'
       );
       $last_id = $this->Invoices_model->SaveData($table,$data);
       $this->load->library('ciqrcode');
       $company_code = $this->session->userdata('logged_in')['company_code'];
        if (!is_dir(FCPATH.'assets/Qr_code/'.$company_code)) {
            mkdir(FCPATH.'assets/Qr_code/' . $company_code, 0777, TRUE);
        }
        $url = site_url(INVOICES_PDF.'/'.enc_dec(1,$last_id));
        $params['data'] = $url;
        $params['level'] = 'H';
        $params['size'] = 5;
        $params['savename'] = FCPATH.'assets/Qr_code/'.$company_code.'/'.str_replace("/","-",$_POST['invoice_no']).'_QRCODE.png';
        $QR_CODE_File = str_replace("/","-",$_POST['invoice_no']).'_QRCODE.png';
        $this->ciqrcode->generate($params);
        $QR = imagecreatefrompng(FCPATH.'assets/Qr_code/'.$company_code.'/'.$QR_CODE_File);

        // START TO DRAW THE IMAGE ON THE QR CODE
        $logo = imagecreatefromstring(file_get_contents(base_url().'assets/img/QR_logo.png'));
        /**
         *  Fix for the transparent background
         */
        imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
        imagealphablending($logo , false);
        imagesavealpha($logo , true);

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width/3;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;

        imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        // Save QR code again, but with logo on it
        imagepng($QR,FCPATH.'assets/Qr_code/'.$company_code.'/'.$QR_CODE_File);

        // End DRAWING LOGO IN QR CODE
        $Save_QR = $this->Invoices_model->SaveData($table,array('Qr_code'=>$QR_CODE_File),"id=".$last_id);
       for($i = 0; $i< count($_POST['Product_id']); $i++){
       		$inv_details = array(
       			'Invoice_id'=>$last_id,
       			'Product_id'=>$_POST['Product_id'][$i],
       			'Hsn_code'=>$_POST['Hsn_code'][$i],
       			'Qty'=>$_POST['Qty'][$i],
       			'Price'=>$_POST['Price'][$i],
       			'Amount'=>$_POST['Amount'][$i]
       		);
       		$last_id1 = $this->Invoices_model->SaveData('invoice_items',$inv_details);
       }
       /** Saving data in ledger */
       $bal = $this->Mymodel->GetDataCount('ledger', array('sum(dr_amount) as dr_amount', 'sum(cr_amount) as cr_amount'), "customer_id=".$_POST['Customer_id']);
       $op_bal = $this->Mymodel->GetDataCount('customers', array('Balance_as_on', 'Type', 'Opening_balance'), "id=".$_POST['Customer_id']);
       if($op_bal->Type == 'Dr'){
            $balance_amt = $op_bal->Opening_balance + $bal->dr_amount - $bal->cr_amount + $_POST['Netammount'];
       } else {
            $balance_amt = $op_bal->Opening_balance + $bal->cr_amount - $bal->dr_amount + $_POST['Netammount'];
       }
       //print_r($bal);print_r($op_bal);exit;
       $ledger_data = array(
           'user_id' => $_POST['user_id'],
           'customer_id' => $_POST['Customer_id'],
           'invoice_id' => $last_id,
           'transaction_date' => date('Y-m-d', strtotime(str_replace('-', '/', $_POST['invoice_date']))),
           'narration' => 'Sold Goods on credit',
           'dr_amount'=> $_POST['Netammount'],
           'balance_amount'=>$balance_amt,
           'created' => date('Y-m-d H:i:s')
       );
       $ledger_result = $this->Mymodel->SaveData('ledger', $ledger_data );
        if(isset($last_id)){
            $userLogs_data = array(
                'user_id'=>id,
                'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                'description'=>'Invoices Generated by '.name.' with Invoice no '.$_POST['invoice_no'],
                'ip_address'=>$_SERVER['SERVER_ADDR']
            );
            //$result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
            redirect(site_url(INVOICES_VIEW.'/'.enc_dec(1, $last_id)));
        }
    }
    public function gengrate_qr_code(){
        $inv_data = $this->Mymodel->GetDataAllRecords('invoice');
        foreach($inv_data as $data){
            $this->load->library('ciqrcode');
            $company_code = $this->session->userdata('logged_in')['company_code'];
            if (!is_dir(FCPATH.'assets/Qr_code/'.$company_code)) {
                mkdir(FCPATH.'assets/Qr_code/' . $company_code, 0777, TRUE);
            }
            $url = site_url(INVOICES_PDF.'/'.enc_dec(1,$data->id));
            $params['data'] = $url;
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] = FCPATH.'assets/Qr_code/'.$company_code.'/'.str_replace("/","-",$data->invoice_no).'_QRCODE.png';
            $QR_CODE_File = str_replace("/","-",$data->invoice_no).'_QRCODE.png';
            $this->ciqrcode->generate($params);
            $QR = imagecreatefrompng(FCPATH.'assets/Qr_code/'.$company_code.'/'.$QR_CODE_File);

            // START TO DRAW THE IMAGE ON THE QR CODE
            $logo = imagecreatefromstring(file_get_contents(base_url().'assets/img/QR_logo.png'));
            /**
             *  Fix for the transparent background
             */
            imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
            imagealphablending($logo , false);
            imagesavealpha($logo , true);

            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);

            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);

            // Scale logo to fit in the QR Code
            $logo_qr_width = $QR_width/3;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;

            imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

            // Save QR code again, but with logo on it
            imagepng($QR,FCPATH.'assets/Qr_code/'.$company_code.'/'.$QR_CODE_File);

            // End DRAWING LOGO IN QR CODE
            $Save_QR = $this->Invoices_model->SaveData('invoice',array('Qr_code'=>$QR_CODE_File),"id=".$data->id);
        }
    }
    public function upload_waybill(){
        $table = "invoice";
        if($_FILES['file']['error'] == 0){
    		$_POST['waybill_file'] = 'Waybill_'.$_FILES['file']['name'];
    		$targetfolder = FCPATH."/assets/upload/sales_waybill_pdf/";
    
    		$targetfolder = $targetfolder . basename('Waybill_'.$_FILES['file']['name']);
    		move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder);
        } else {
            $_POST['waybill_file'] = "";
        }
        $res = $this->Invoices_model->SaveData($table,array('waybill_file'=>$_POST['waybill_file']),"id=".$_POST['id']);
        print_r(json_encode(array('status'=>1)));exit;
    }
    public function view($id){
        $id = enc_dec(2, $id);
        $this->load->library('Numbertowordconvertsconver');
        $table = "invoice i";
        $table2 = "invoice_items i";
        $table3 = "settings";
        $cond = "i.id=".$id;
        $cond2 = "i.Invoice_id=".$id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $cond3 = "user_id=".id;
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $user_data = $this->Invoices_model->GetFieldData('users','username,email,mobile',"id='".$data->user_id."'",'','','1','1');
        $data = array(
                'file' => 'Invoices/view',
                'heading' => 'View Sale Bill',
                'body_class'=>'hold-transition skin-blue sidebar-mini',
                'data'=>$data,
                'Net_amt_words' => $this->numbertowordconvertsconver->convert_number($data->Netammount),
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3
            );
        $this->load->view('layout', $data); 
    }
    public function Inv_cancel($id){
        $id = enc_dec(2, $id);
        $table = "invoice";
        $cond = "id=".$id;
        $cancel_data = $this->Invoices_model->SaveData($table,array('Status'=>'Cancelled'),$cond);
        if($cancel_data){
            //Mail function for cancel

            //Save in log for cancelling invoice
            $data = $this->Invoices_model->GetData($table, $cond);
            /** Saving data in ledger */
            $ledger_data = array(
                'user_id' => $data->user_id,
                'customer_id' => $data->Customer_id,
                'invoice_id' => $id,
                'transaction_date' => date('Y-m-d'),
                'narration' => 'Transaction Cancelled and ledger entry reversed',
                'cr_amount'=> $data->Netammount,
                'balance_amount'=>'',
                'created' => date('Y-m-d H:i:s')
            );
            $ledger_result = $this->Mymodel->SaveData('ledger', $ledger_data );
            $userLogs_data = array(
                'user_id'=>id,
                'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                'description'=>'Invoices Canceled by '.name.' of Invoice no '.$_POST['invoice_no'],
                'ip_address'=>$_SERVER['SERVER_ADDR']
            );
            $result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
            redirect(site_url(INVOICES));
        }
    }
    public function receipt($id){
        $id = enc_dec(2, $id);
        $this->load->library('Numbertowordconvertsconver');
        $this->load->helper('pdf_helper');
        $data2 = $this->Mymodel->GetData("invoice_payments","id=".$id."");
       // print_r($data2);
        $table2 = "invoice_items i";
        $table4 = "invoice_payments";
        $table3 = "settings";
        $table = "invoice i";
        $cond = "i.id=".$data2->invoice_id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $cond2 = "i.Invoice_id=".$data2->invoice_id;
        //print_r($data);exit;
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $cond3 = "user_id=".id;
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $cond4 = "user_id=".id." and id = ".$id;
        $data4 = $this->Invoices_model->GetFieldData($table4,'', $cond4);
        $user_data = $this->Invoices_model->GetFieldData('users','username,email,mobile',"id='".id."'",'','','1','1');
        $data = array(
            'file' => 'Payments/receipt',
            'id' => $id,
            'body_class'=>BODY_CLASS,
            'heading'=>'Sales Receipt',
            'settings' => $data3,
            'receipt' => $data4[0],
            'invoice_details' => $data
        );
        $this->load->view('layout', $data);
    }
    public function payments($id){
        $id = enc_dec(2, $id);
        $table = "invoice i";
        $cond = "i.id=".$id;
        $data = $this->Payments_model->GetInvcData($table,$cond);
        $user_data = $this->Payments_model->GetFieldData('settings','name,value',"user_id='".id."'",'','','','');
        $data = array(
            'file' => 'Payments/list',
            'id' => $id,
            'data'=>$data,
            'user_data'=>$user_data,
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Sale Bill Payments'
        );
        $this->load->view('layout', $data);
    }
    public function payment_ajax($id)
    {  
        $id = enc_dec(2, $id);
        $table = "invoice i";
        $cond = "p.user_id=".id ." and p.invoice_id = ".$id;
        $userData=$this->Payments_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0; 
        foreach ($userData as $usersData) 
        {
            $btn = anchor(site_url(INVOICES_PAYMENT_RECEIPT.'/'.enc_dec(1, $usersData->payment_id)),'<button title="Print" class="btn btn-xs btn-default waves-effect"><i class="fa fa-print"></i></button>',['target'=>'_blank']);
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
                    "recordsTotal" => $this->Payments_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Payments_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    public function payments_add($id){
        $id = enc_dec(2, $id);
        $table = "invoice i";
        $cond = "i.id=".$id;
        $data = $this->Payments_model->GetInvcData($table,$cond);
        $user_data = $this->Payments_model->GetFieldData('settings','name,value',"user_id='".id."'",'','','','');
        $lastId = $this->Payments_model->GetFieldData('invoice_payments','id',"user_id='".id."'",'','id DESC','1','1');
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
            'file' => 'Payments/form',
            'id' => $id,
            'data'=>$data,
            'user_data'=>$user_data,
            'body_class'=>BODY_CLASS,
            'heading'=>'Create Sale Bill Payment',
            'action' => site_url(INVOICES_PAYMENT_ADD_ACTION).'/'.enc_dec(1, $id),
            'receipt_no'=>'REC/'.$financial_year.'/'.str_pad($lst_id, 3, '0', STR_PAD_LEFT)
        );
        $this->load->view('layout', $data);
    }
    public function payment_action($id)
    {
        $id = enc_dec(2, $id);
        $table = "invoice";
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
        $last_id = $this->Invoices_model->SaveData($table,$data,'id='.$_POST['invoice_id']);
        $table2 = "invoice_payments";
        $data2 = array(
            'user_id' => id,
            'invoice_id' => $_POST['invoice_id'],
            'customer_id' => $_POST['customer_id'],
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
        $last_id2 = $this->Invoices_model->SaveData($table2,$data2);
        /** Saving data in ledger */
        $bal = $this->Mymodel->GetDataCount('ledger', array('sum(dr_amount) as dr_amount', 'sum(cr_amount) as cr_amount'), "customer_id=".$_POST['customer_id']);
       $op_bal = $this->Mymodel->GetDataCount('customers', array('Balance_as_on', 'Type', 'Opening_balance'), "id=".$_POST['customer_id']);
       if($op_bal->Type == 'Dr'){
            $balance_amt = $op_bal->Opening_balance + $bal->dr_amount - $bal->cr_amount - $_POST['payed_amount'];
       } else {
            $balance_amt = $op_bal->Opening_balance + $bal->cr_amount - $bal->dr_amount - $_POST['payed_amount'];
       }
       //print_r($bal);print_r($op_bal);print_r($balance_amt);exit;
        $ledger_data = array(
            'user_id' => id,
            'customer_id' => $_POST['customer_id'],
            'invoice_id' => $_POST['invoice_id'],
            'payment_id' => $last_id2,
            'transaction_date' => date('Y-m-d', strtotime(str_replace('-', '/', $_POST['payment_date']))),
            'narration' => 'Amount received from customer in bank or cash',
            'cr_amount'=> $_POST['payed_amount'],
            'balance_amount'=>'',
            'created' => date('Y-m-d H:i:s')
        );
        $ledger_result = $this->Mymodel->SaveData('ledger', $ledger_data );
        /** Mail function starts here */
        $table3 = "settings";
        $table = "invoice i";
        $cond = "i.id=".$_POST['invoice_id'];
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $cond3 = "user_id=".id;
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $user_data = $this->Invoices_model->GetFieldData('users','username,email,mobile',"id='".id."'",'','','1','1');
        $mail = $this->Mymodel->GetData("mails_body","type='receipt_mail'");
        $subject = $mail->subject;
        $mail_body = $mail->body;
        $subject = str_replace("{{invoice_no}}",$_POST['receipt_no'],$subject);
        $subject = str_replace("{{customer}}",$data->FirstName.' '.$data->LastName,$subject);
        $mail_body = str_replace("{{invoice_no}}",$data->invoice_no,$mail_body);
        $mail_body = str_replace("{{receipt_no}}",$_POST['receipt_no'],$mail_body);
        $mail_body = str_replace("{{customer}}",$data->FirstName.' '.$data->LastName,$mail_body);
        $mail_body = str_replace("{name}",$user_data->username,$mail_body);
        $mail_body = str_replace("{{amount_paid}}","Rs. ".moneyFormatIndia($_POST['payed_amount']),$mail_body);
        $mail_body = str_replace("{{billed_amount}}","Rs. ".moneyFormatIndia($_POST['billed_amount']),$mail_body);
        $mail_body = str_replace("{{balance_amount}}","Rs. ".moneyFormatIndia($_POST['balance_amount']),$mail_body);
        $mail_body = str_replace("{{amount_words}}",convert_number($_POST['payed_amount']),$mail_body);
        $mail_body = str_replace("{{bill_date}}",date('d-m-Y', strtotime(str_replace('-', '/', $_POST['payment_date']))),$mail_body);
        $mail_body = str_replace("{{type}}",$_POST['payment_type'],$mail_body);
        $mail_body = str_replace("{{description}}",$_POST['payment_description'],$mail_body);
        $mail_body = str_replace("{{conpany_name}}",$data3[0]->value,$mail_body);
        //print_r($mail_body);exit;
        if(!empty($data->Email)){
            $email = array($user_data->email,$data->Email);
        } else {
            $email = array($user_data->email,'b.ankit@accordance.co.in');
        }
        $this->custom->sendEmailSmtp($subject,$mail_body,$email,"", $data3[0]->value);
        /** Mail function ends here */
        if(isset($last_id) && isset($last_id2)){
           $userLogs_data = array(
                'user_id'=>id,
                'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                'description'=>'Invoices Payment Received by '.name.' with Receipt no '.$_POST['receipt_no'],
                'ip_address'=>$_SERVER['SERVER_ADDR']
            );
            $result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
            redirect(INVOICES_PAYMENT.'/'.enc_dec(1, $id));
        }
    }
    public function Inv_print($user_id){
        $user_id = enc_dec(2, $user_id);
        $this->load->library('Numbertowordconvertsconver');
        $table = "invoice i";
        $table2 = "invoice_items i";
        $table3 = "settings";
        $table4 = "bank_details";
        $cond = "i.id=".$user_id;
        $cond2 = "i.Invoice_id=".$user_id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $cond3 = "user_id=".$data->user_id;
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $data4 = $this->Invoices_model->GetFieldData($table4,'', $cond3);
        $user_data = $this->Invoices_model->GetFieldData('users','username,email,mobile',"id='".$data->user_id."'",'','','1','1');
        $data = array(
                'data'=>$data,
                'Net_amt_words' => $this->numbertowordconvertsconver->convert_number($data->Netammount),
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3,
                'bank_details' => $data4
            );
        $this->load->view('Invoices/print', $data); 
    }
    public function Inv_pdf($user_id){
        $user_id = enc_dec(2, $user_id);
        $this->load->helper('pdf_helper');
        $table = "invoice i";
        $table2 = "invoice_items i";
        $table3 = "settings";
        $table4 = "bank_details";
        $cond = "i.id=".$user_id;
        $cond2 = "i.Invoice_id=".$user_id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $cond3 = "user_id=".$data->user_id;
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $data4 = $this->Invoices_model->GetFieldData($table4,'', $cond3);
        $user_data = $this->Invoices_model->GetFieldData('users','username,email,mobile',"id='".$data->user_id."'",'','','1','1');
        $data = array(
                'data'=>$data,
                'user_data'=>$user_data,
                'invoice_details'=>$data2,
                'settings' => $data3,
                'bank_details' => $data4
            );
        $this->load->view('Invoices/pdf', $data); 
        $mpdf_html = $this->load->view('Invoices/pdf', '', true);
        //print_r($mpdf_html);exit;
        $this->load->view('pdf', array('pdf' => $mpdf_html,'incoice_no'=>$data['data']->invoice_no)); 
    }
    public function receipt_pdf($id){
        $id = enc_dec(2, $id);
        $this->load->helper('pdf_helper');
        $this->load->library('Numbertowordconvertsconver');
        $table = "invoice i";
        $table2 = "invoice_items i";
        $table4 = "invoice_payments";
        $table3 = "settings";
        $cond = "i.id=".$id;
        $cond2 = "i.Invoice_id=".$id;
        $data = $this->Invoices_model->GetInvcData($table,$cond);
        $data2 = $this->Invoices_model->GetInvcDetail($table2,$cond2);
        $cond3 = "user_id=".id;
        $cond4 = "user_id=".id." and invoice_id = ".$id;
        $data3 = $this->Invoices_model->GetFieldData($table3,'name, value', $cond3);
        $data4 = $this->Invoices_model->GetFieldData($table4,'', $cond4);
        $data = array(
            'id' => $id,
            'heading'=>'Payments Receipt',
            'settings' => $data3,
            'receipt' => $data4[0],
            'invoice_details' => $data
        );
        $this->load->view('Payments/receipt', $data);
        $mpdf_html = $this->load->view('Invoices/pdf', '', true);
        $this->load->view('pdf', array('pdf' => $mpdf_html,'incoice_no'=>$data4[0]->receipt_no));
    }
    public function inv_mail($id){
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
        if($data['data']->waybill_file != ''){
            $waybill = FCPATH.'assets/upload/sales_waybill_pdf/'.$data['data']->waybill_file;
        } else {
            $waybill = "";
        }
        $this->custom->sendEmailSmtp($subject,$mail_body,$email,$fileatt, $data['settings'][0]->value, $waybill);
        redirect(INVOICES_VIEW.'/'.enc_dec(1, $id));
    }
 }
?>
