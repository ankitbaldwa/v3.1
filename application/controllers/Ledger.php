<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends Admin_Parent {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Ledgers_model');
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
			define('profile',$login_name->profile);
        } 
    }
    public function index(){
        $customers = $this->Ledgers_model->GetFieldData('customers', "id, FirstName, LastName","user_id=".id."","","FirstName ASC");
        $data = array(
            'file' => 'Ledger/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Ledger',
            'customers'=>$customers,
        );
        $this->load->view('layout', $data);
    }
    public function ajax(){
        $table = "ledger l";
        $cond = "l.customer_id = ".$_POST['SearchData']."";
        $userData=$this->Ledgers_model->get_datatables($table,$cond);
        //print_r($this->db->last_query());exit;
        $data = array();
        $ref = "";
        foreach ($userData as $usersData) 
        {
            if($usersData->invoice_no=='')
            {
                $description =  "Opening Balance";
            }
            else if($usersData->receipt_no=='')
            {
                $description =  "To, Sales";
                $ref = $usersData->invoice_no;
            } else {
                $description =  "By, ".$usersData->payment_type;
                $ref = $usersData->receipt_no;
            }
            $nestedData = array();
            $nestedData[] = date('d-m-Y',strtotime($usersData->transaction_date));
            $nestedData[] = $description;
            $nestedData[] = $ref;
            $nestedData[] = ($usersData->dr_amount !='')?"<i class='fa fa-inr'></i> ".moneyFormatIndia($usersData->dr_amount):'N/A';
            $nestedData[] = ($usersData->cr_amount !='')?"<i class='fa fa-inr'></i> ".moneyFormatIndia($usersData->cr_amount):'N/A';
            $nestedData[] = ($usersData->balance_amount < 0)?"<span class='text-danger'><i class='fa fa-inr'></i> ".moneyFormatIndia($usersData->balance_amount)." Cr.</span>":"<i class='fa fa-inr'></i> ".moneyFormatIndia($usersData->balance_amount);
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Ledgers_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Ledgers_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
}