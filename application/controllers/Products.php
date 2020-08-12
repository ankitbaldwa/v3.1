<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Products_model');
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
        } 
    }
    public function index()
    {        
        $data = array(
            'file' => 'Products/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Products'
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $table = "products";
        $cond = "User_id=".Id;
        $userData=$this->Products_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0;    
        foreach ($userData as $usersData) 
        {
            $btn =anchor(site_url(PRODUCTS_UPDATE.'/'.enc_dec(1,$usersData->id)),'<button title="Edit" class="btn btn-info btn-circle btn-xs"><i class="fa fa-edit"></i></button>');
            //$btn .='&nbsp;|&nbsp;'.anchor(site_url('Products/delete/'.base64_encode($usersData->id)),'<button title="Delete" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></button>');
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
            $nestedData[] = ucfirst($usersData->Name);
            $nestedData[] = $usersData->Description;
            $nestedData[] = $usersData->Hsn_code;
            $nestedData[] = $usersData->Unit;
            $nestedData[] = "<i class='fa fa-inr'></i> ".$usersData->Cost;
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Products_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Products_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE PRODUCT
    public function create(){
        $data = array(
            'file' => 'Products/form',
            'heading' => 'Add Product',
            'body_class'=>BODY_CLASS,
            'action'=>site_url(PRODUCTS_ADD_ACTION),
        );
        $this->load->view('layout', $data);
    }
    public function create_action()
    {
        $table = "products";
        $data = array(
            'Name'=>$_POST['Name'],
            'User_id'=>Id,
            'Description'=>$_POST['Description'],
            'Hsn_code'=>$_POST['Hsn_code'],
            'Unit'=>$_POST['Unit'],
            'Cost'=>$_POST['Cost']
        );
        $create = $this->Products_model->SaveData($table,$data);
        if(isset($create)){
            redirect(PRODUCTS);
        }
    }
    //TO UPDATE PRODUCT 
    public function update($user_id)
    {
            $id=enc_dec(2, $user_id);
            $table = "products";
            $cond = "id=".$id;
            $update_data = $this->Products_model->GetData($table,$cond);
            $data = array(
                'file' => 'Products/form',
                'heading' => 'Update Product',
                'body_class'=>BODY_CLASS,
                'action'=>site_url(PRODUCTS_UPDATE_ACTION),
                'data'=>$update_data
            );
            $this->load->view('layout', $data); 
    } 
    public function update_action()
    {
        $table = "products";
        $cond = "id=".$_POST['id'];
        $update = $this->Products_model->SaveData($table,$_POST,$cond);
        if(isset($update)){
            redirect(PRODUCTS);
        }
    }
    public function delete($user_id)
    {
        $id=base64_decode($user_id);
        $table = "products";
        $cond = "id=".$id;
        if($this->Products_model->DeleteData($table,$cond)){
            redirect(PRODUCTS);
        }
    }
 }
?>
