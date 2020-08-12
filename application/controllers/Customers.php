<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Customers_model');
        $this->load->model('Invoices_model');
        $this->load->library('session');
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
            'file' => 'Customers/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Customers'
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $this->load->library('Numbertowordconvertsconver');
        $table = "customers U";
        $cond = "U.User_id = ".id."";
        $userData=$this->Customers_model->get_datatables($table,$cond);
        //print_r($this->db->last_query());exit;
        $data = array();    
        $no= 0;    
        foreach ($userData as $usersData) 
        {
            $id = enc_dec(1,$usersData->id);
            $btn = anchor(site_url(CUSTOMERS_VIEW.'/'.$id),'<button title="View" class="btn btn-xs btn-default waves-effect" data-toggle="tooltip"><i class="fa fa-eye"></i></button>');
            $btn .='&nbsp;|&nbsp;'.anchor(site_url(CUSTOMERS_UPDATE.'/'.$id),'<button title="Edit" class="btn btn-info btn-circle btn-xs" data-toggle="tooltip"><i class="fa fa-edit"></i></button>');
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url('Customers/delete/'.base64_encode($usersData->id)),'<button title="Delete" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></button>');
            if($usersData->Status=='Active')
            {
                $status =  "<label class='label-success label'> Active </label>";
            }
            else
            {
                $status =  "<label class='label-success label'> Inactive </label>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ucfirst($usersData->FirstName).' '.$usersData->LastName;
            $nestedData[] = ($usersData->GST_No !='')?$usersData->GST_No:'N/A';
            $nestedData[] = ($usersData->Email !='')?$usersData->Email:'N/A';
            $nestedData[] = ($usersData->Mobile !='')?$usersData->Mobile:'N/A';
            $nestedData[] = "<i class='fa fa-inr'></i> ".moneyFormatIndia($usersData->balance_amount);
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Customers_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Customers_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE CUSTOMER
    public function create(){
        $data = array(
            'file' => 'Customers/form',
            'heading' => 'Add Customer',
            'body_class'=>BODY_CLASS,
            'action'=>site_url(CUSTOMERS_ADD_ACTION),
        );
        $this->load->view('layout', $data);
    }
    public function create_action()
    {
        $tbl ="ledger";
        $table = "customers";
        $_POST['User_id'] = id;
        $create = $this->Customers_model->SaveData($table,$_POST);
        $ledger_data = array(
            'user_id' => id,
            'customer_id' => $create,
            'transaction_date' => date('Y-m-d', strtotime($_POST['Balance_as_on'])),
            'narration' => "Opening Balance",
            'balance_amount' => $_POST['Opening_balance'],
            'created' => date('Y-m-d H:i:s')
        );
        if($_POST['Type'] == 'Dr')
            $ledger_data['dr_amount'] = $_POST['Opening_balance'];
        else 
            $ledger_data['cr_amount'] = $_POST['Opening_balance'];
        $ledger_save = $this->Customers_model->SaveData($tbl,$ledger_data);
        if(isset($create)){
            redirect(CUSTOMERS);
        }
    }
    public function countries(){
        $table = "mst_countries";
        if(isset($_GET['q'])){
            $cond = "country_name LIKE '%".$_GET['q']."%' AND status = 'Active'"; 
        } else {
            $cond = "status = 'Active'"; 
        }
        $country_data = $this->Customers_model->GetDataAll($table,$cond,'','',10);
        $json = [];
        foreach($country_data as $country){
             $json[] = ['id'=>$country->country_name, 'text'=>$country->country_name];
        }
        echo json_encode($json);
    }
    public function states(){
        $table = "mst_states";
        $country_id = $this->Customers_model->GetData('mst_countries',"country_name='".$_GET['country']."'");
        if(isset($_GET['searchTerm'])){
            $cond = "state_name LIKE '%".$_GET['searchTerm']."%' AND mst_country_id = ".$country_id->id." AND status = 'Active'"; 
        } else {
            $cond = "mst_country_id = ".$country_id->id." AND status = 'Active'"; 
        }
        $state_data = $this->Customers_model->GetDataAll($table,$cond,'','',10);
        $json = [];
        foreach($state_data as $state){
             $json[] = ['id'=>$state->state_name, 'text'=>$state->state_name];
        }
        echo json_encode($json);
    }
    public function cities(){
        $table = "mst_cities";
        $state_id = $this->Customers_model->GetData('mst_states',"state_name='".$_GET['state']."'");
        if(isset($_GET['searchTerm'])){
            $cond = "city_name LIKE '%".$_GET['searchTerm']."%' AND mst_state_id = ".$state_id->id." AND mst_country_id = ".$state_id->mst_country_id." AND status = 'Active'"; 
        } else {
            $cond = "mst_state_id = ".$state_id->id ." AND mst_country_id = ".$state_id->mst_country_id." AND status = 'Active'"; 
        }
        $city_data = $this->Customers_model->GetDataAll($table,$cond,'','',10);
        $json = [];
        foreach($city_data as $city){
             $json[] = ['id'=>$city->city_name, 'text'=>$city->city_name];
        }
        echo json_encode($json);
    }
    //TO UPDATE CUSTOMER 
    public function update($user_id)
    {
            $id=enc_dec(2, $user_id);
            $table = "customers";
            $cond = "id=".$id;
            $update_data = $this->Customers_model->GetData($table,$cond);
            $data = array(
                'file' => 'Customers/form',
                'heading' => 'Update Customer',
                'body_class'=>BODY_CLASS,
                'action'=>site_url(CUSTOMER_UPDATE_ACTION),
                'data'=>$update_data
            ); 
            $this->load->view('layout', $data); 
    }
    public function Payments_action(){
        $data = $this->Customers_model->GetFieldData("invoice",array('id','invoice_no','invoice_date','Balance_Amount'),"Customer_id = ".$_POST['customer_id']." and user_id = ".id."","","","","");
        $outstanding_amt = $_POST['payed_amount'];
        $total = 0;
        $myArray = explode('/', $_POST['receipt_no']);
        foreach($data as $value){
            $outstanding_amt = $outstanding_amt - $value->Balance_Amount;
            $receipt = $myArray[0].'/'.$myArray[1].'/'.++$myArray[2];
            if($outstanding_amt > 0){
                $invoice = $this->Invoices_model->SaveData("invoice",array('Balance_Amount' => 0,'Status' => 'Completed'),'id='.$value->id);
                $payment = array(
                    'user_id' => id,
                    'invoice_id' => $value->id,
                    'customer_id' => $_POST['customer_id'],
                    'receipt_no' => $receipt,
                    'payment_date' => date('Y-m-d', strtotime(str_replace('-', '/', $_POST['payment_date']))),
                    'billed_amount' => $value->Balance_Amount,
                    'payed_amount' => $value->Balance_Amount,
                    'payment_type' => $_POST['payment_type'],
                    'payment_description' => $_POST['payment_description'],
                    'balance_amount' => 0,
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'created'=>date('Y-m-d H:i:s'),
                    'status' => 'Completed'
                );
                $last_id2 = $this->Invoices_model->SaveData("invoice_payments",$payment);
                $userLogs_data = array(
                    'user_id'=>id,
                    'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                    'description'=>'Invoices Payment Received by '.name.' with Receipt no '.$receipt,
                    'ip_address'=>$_SERVER['SERVER_ADDR']
                );
                $result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
                $total = $total + $value->Balance_Amount;
            } else {
                $outstanding_amt = $value->Balance_Amount - ($_POST['payed_amount'] - $total);
                $invoice = $this->Invoices_model->SaveData("invoice",array('Balance_Amount' => $outstanding_amt),'id='.$value->id);
                $payment = array(
                    'user_id' => id,
                    'invoice_id' => $value->id,
                    'customer_id' => $_POST['customer_id'],
                    'receipt_no' => $receipt,
                    'payment_date' => date('Y-m-d', strtotime(str_replace('-', '/', $_POST['payment_date']))),
                    'billed_amount' => $value->Balance_Amount,
                    'payed_amount' => ($_POST['payed_amount'] - $total),
                    'payment_type' => $_POST['payment_type'],
                    'payment_description' => $_POST['payment_description'],
                    'balance_amount' => $outstanding_amt,
                    'timestamp'=>date('Y-m-d H:i:s'),
                    'created'=>date('Y-m-d H:i:s'),
                    'status' => 'Completed'
                );
                $last_id2 = $this->Invoices_model->SaveData("invoice_payments",$payment);
                break;
            }
        }
        redirect(CUSTOMERS_VIEW.'/'.enc_dec(1,$_POST['customer_id']));
    }
    public function update_action()
    {
        $table = "customers";
        $cond = "id=".$_POST['id'];
        $update = $this->Customers_model->SaveData($table,$_POST,$cond);
        if(isset($update)){
            redirect(CUSTOMERS);
        }
    }
    public function delete($user_id)
    {
        $id=enc_dec(2, $user_id);
        $table = "customers";
        $cond = "id=".$id;
        if($this->Customers_model->DeleteData($table,$cond)){
            redirect(CUSTOMERS);
        }
    }
    public function Payments($user_id){
        $id=enc_dec(2, $user_id);
        $table = "customers";
        $cond = "id=".$id;
        $data = $this->Customers_model->GetData($table,$cond);
        $balance_amount = $this->Customers_model->GetFieldData("invoice",array('sum(Balance_Amount) as balance_amount'),"Customer_id = ".$id." and user_id = ".id." and status = 'Pending'","","","",1);
        $user_data = $this->Customers_model->GetFieldData('settings','name,value',"user_id='".id."'",'','','','');
        $lastId = $this->Customers_model->GetFieldData('invoice_payments','id',"user_id='".id."'",'','id DESC','1','1');
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
            'file' => 'Customers/payment',
            'id' => $id,
            'data'=>$data,
            'user_data'=>$user_data,
            'body_class'=>BODY_CLASS,
            'heading'=>'Create Bill Payment',
            'action' => site_url(CUSTOMER_PAYMENTS_ACTION),
            'receipt_no'=>'REC/'.$financial_year.'/'.str_pad($lst_id, 3, '0', STR_PAD_LEFT),
            'balance_amount' => $balance_amount
        );
        $this->load->view('layout', $data);
    }
    public function view($user_id){
        $id=enc_dec(2, $user_id);
        $table = "customers";
        $cond = "id=".$id;
        $data = $this->Customers_model->GetData($table,$cond);
        $balance_amount = $this->Customers_model->GetFieldData("invoice",array('sum(Balance_Amount) as balance_amount'),"Customer_id = ".$id." and user_id = ".id." and status = 'Pending'","","","",1);
        $data = array(
                'file' => 'Customers/view',
                'heading' => 'View Customer',
                'body_class'=>BODY_CLASS,
                'data'=>$data,
                'balance_amount' => $balance_amount
            );
        $this->load->view('layout', $data); 
    }
    public function cust_ajax($customer_id)
    {
        $customer_id = enc_dec(2, $customer_id);
        $table = "invoice i";
        $cond = "i.user_id=".id." and i.Customer_id=".$customer_id;
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
            $btn = '<div class="btn-group">'.$btn1.'</div>';
            if($usersData->Status=='Completed')
            {
                $status =  "<label class='label-success label'> Completed </label>";
            }else if ($usersData->Status =='Cancelled'){
                $status =  "<label class='label-danger label'> Cancelled </label>";
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
    public function GSTIN_ajax(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ewaybillgst.gov.in/BillGeneration/BillGeneration.aspx/GetGSTNDetails",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{'gstin':'".$_POST['GSTIN']."'}\r\n",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 24c33584-ddb1-5bcd-f734-bd8bebe922ab"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        print_r(json_encode(json_decode($response)->d)); exit;
        }
    }
 }
?>
