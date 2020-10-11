<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxes extends Admin_Parent {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Taxes_model');
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
            define('profile',$login_name->profile);
        } else {
            redirect(LOGIN);
        }
    }
    public function index(){
        $cond = "user_id=".Id;
        $tax_data = $this->Taxes_model->GetDataAll('mst_taxes',$cond);
        $user_data = $this->Mymodel->GetData("users","id=".Id);
        $data = array(
            'file' => 'Taxes/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Taxes',
            'taxes'=>$tax_data,
            'userdata' => $user_data
        );
        $this->load->view('layout', $data);
    }
    //TO UPDATE TAX 
    public function update()
    {
        $table = "mst_taxes";
        $cond = "id=".$_POST['id'];
        $SaveData = array(
            'value'=>$_POST['value']
        );
        $update_data = $this->Taxes_model->SaveData($table,$SaveData,$cond);
        echo $_POST['id'];exit;
    } 
    public function bankDetails(){
        $cond = "user_id=".Id;
        $bank_data = $this->Taxes_model->GetDataAll('bank_details',$cond);
        $user_data = $this->Mymodel->GetData("users","id=".Id);
        $data = array(
            'file' => 'Taxes/bankDetails',
            'body_class'=>BODY_CLASS,
            'heading'=>'Bank Details',
            'bank_data'=>$bank_data,
            'userdata' => $user_data
        );
        $this->load->view('layout', $data);
    }
    //TO UPDATE BANK DETAILS 
    public function update_bank()
    {
        $table = "bank_details";
        $cond = "id=".$_POST['id'];
        //print_r($_POST);exit;
        $SaveData = array(
            'bank_name'=>$_POST['bank_name'],
            'account_no'=>$_POST['account_no'],
            'branch'=>$_POST['branch'],
            'IFC_code'=>$_POST['IFC_code']
        );
        $update_data = $this->Taxes_model->SaveData($table,$_POST,$cond);
        echo $_POST['id'];exit;
    } 
 }
?>
