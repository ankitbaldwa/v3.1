<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends CI_Controller {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Vouchers_model');
        $this->load->library('session');
        /** Load comapny details and database */
		$this->company = get_company();
        $this->db = load_db($this->company);
		/** Load comapny details and database */
        if(isset($this->session->userdata('logged_in')['id'])){
            $login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
            define('name',$login_name->username);
            define('last_login',$login_name->last_login);
            define('Id', $this->session->userdata('logged_in')['id']);
            $setting_data = $this->Mymodel->GetDataArray('settings',"","user_id='".$this->session->userdata('logged_in')['id']."' and (name='Company Name' or name='Invoice_no')");
			if($setting_data[0]['name'] == 'Company Name')
				define('LOGO',$setting_data[0]['value']);
			if($setting_data[1]['name'] == 'Invoice_no')
				define('LOGO_MINI', $setting_data[1]['value']);
			define('profile',$login_name->profile);
        } else {
            redirect(LOGIN);
        }
    }
    public function index()
    {        
        $data = array(
            'file' => 'Vouchers/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Vouchers'
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $table = "voucher";
        $cond = "user_id=".Id;
        $userData=$this->Vouchers_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0;   
        foreach ($userData as $usersData) 
        {
            //print_r($userData[0]->paid_to);
            $btn =anchor(site_url(VOUCHER_PRINT.'/'.enc_dec(1, $usersData->id)),'<button title="Edit" class="btn btn-info btn-circle btn-xs"><i class="fa fa-print"></i></button>',['target'=>'_blank']);
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url('Products/delete/'.base64_encode($usersData->id)),'<button title="Delete" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></button>');
            if($usersData->status=='Complete')
            {
                $status =  "<a href='javascript:void(0)' title='Edit' onclick='status('".enc_dec(1,$usersData->id)."')'><label class='label-success label'> Complete </label></a>";
            }
            else
            {
                $status =  "<a href='javascript:void(0)' title='Edit' onclick='status('".enc_dec(1, $usersData->id)."')'><label class='label-success label'> Cancel </label></a>";
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $usersData->voucher_no;
            $nestedData[] = date('d-M-Y',strtotime($usersData->voucher_date));
            $nestedData[] = $usersData->account_name;
            $nestedData[] = $usersData->payment_type;
            $nestedData[] = $userData[$no-1]->paidTo;
            $nestedData[] = (empty($usersData->debit_amount))?'-':"<i class='fa fa-inr'></i> ".$usersData->debit_amount;
            $nestedData[] = (empty($usersData->credit_amount))?'-':"<i class='fa fa-inr'></i> ".$usersData->credit_amount;
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Vouchers_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Vouchers_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE Voucher
    public function create(){
        $data = array(
            'file' => 'Vouchers/form',
            'heading' => 'Add Voucher',
            'body_class'=>BODY_CLASS,
            'action'=>site_url(VOUCHER_ADD_ACTION)
        );
        $this->load->view('layout', $data);
    }
    public function ajax_voucher_no($type){
        if($type == 'Debit')
            $voucher_no = $this->Vouchers_model->GetFieldData('settings','value',"user_id='".Id."' and name='voucher_no_debit'",'','id DESC','1','1');
        else 
            $voucher_no = $this->Vouchers_model->GetFieldData('settings','value',"user_id='".Id."' and name='voucher_no_credit'",'','id DESC','1','1');
        $lastId = $this->Vouchers_model->GetDataAll('voucher',"user_id='".Id."' and voucher_type='".$type."' and voucher_type='".$type."'");
        $fy = $this->Vouchers_model->GetFieldData('mst_financial_year','',"user_id='".Id."' and status='Active'",'','id DESC','1','1');
        if(empty($lastId)){
            $id = $voucher_no->value;
        } else {
            $id = $voucher_no->value;
            $id = (int) $id + count($lastId);
        }
        $financial_year = (date('y', strtotime($fy->from_date))) . '-' . date('y', strtotime($fy->to_date));
        echo $id.'/'.$financial_year;exit;
    }
    public function create_action()
    {
        $table = "voucher";
        $_POST['user_id'] = Id;
        $_POST['voucher_date'] = date('Y-m-d',strtotime($_POST['voucher_date']));
        if($_POST['payment_type'] == 'Bank')
            $_POST['cheque_date'] = date('Y-m-d',strtotime($_POST['cheque_date']));
        //print_r($_POST);exit;
        $create = $this->Vouchers_model->SaveData($table,$_POST);
        if(isset($create)){
            $userLogs_data = array(
                'user_id'=>id,
                'device_info'=>$_SERVER['HTTP_USER_AGENT'],
                'description'=>'Voucher Generated by '.name.' with Voucher no '.$_POST['voucher_no'],
                'ip_address'=>gethostbyname(trim(`hostname`))
            );
            $result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
            redirect(VOUCHER);
        }
    }
    public function voucher_print($id){
        $id = enc_dec(2, $id);
        $this->load->library('Numbertowordconvertsconver');
        $id = base64_decode($id);
        $data = $this->Vouchers_model->GetData('voucher',"user_id='".Id."' and id=".$id."");
        $cond3 = "user_id=".Id;
        $data3 = $this->Vouchers_model->GetFieldData('settings','name, value', $cond3);
        $data = array(
            'data' => $data,
            'settings' => $data3
        );
        //print_r($data);exit;
        $this->load->view('Vouchers/print', $data);
    }
 }
?>
