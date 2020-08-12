<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Suppliers_model');
        $this->load->model('Purchase_model');
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
        } else {
            redirect(LOGIN);
        }
    }
    public function index()
    {        
        $data = array(
            'file' => 'Suppliers/list',
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Suppliers'
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $this->load->library('Numbertowordconvertsconver');
        $table = "suppliers U";
        $cond = "U.User_id = ".id;
        $userData=$this->Suppliers_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0;    
        foreach ($userData as $usersData) 
        {
            $btn = anchor(site_url(SUPPLIERS_VIEW.'/'.base64_encode($usersData->id)),'<button title="View" class="btn btn-xs btn-default waves-effect"><i class="fa fa-eye"></i></button>');
            $btn .='&nbsp;|&nbsp;'.anchor(site_url(SUPPLIERS_UPDATE.'/'.base64_encode($usersData->id)),'<button title="Edit" class="btn btn-info btn-circle btn-xs"><i class="fa fa-edit"></i></button>');
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
                    "recordsTotal" => $this->Suppliers_model->count_all($table,$cond),
                    "recordsFiltered" => $this->Suppliers_model->count_filtered($table,$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE CUSTOMER
    public function create(){
        $data = array(
            'file' => 'Suppliers/form',
            'heading' => 'Add Supplier',
            'body_class'=>BODY_CLASS,
            'action'=>site_url(SUPPLIERS_ADD_ACTION),
        );
        $this->load->view('layout', $data);
    }
    public function create_action()
    {
        $table = "suppliers";
        $_POST['User_id'] = id;
        $create = $this->Suppliers_model->SaveData($table,$_POST);
        if(isset($create)){
            redirect(SUPPLIERS);
        }
    }
    public function countries(){
        $table = "mst_countries";
        if(isset($_GET['q'])){
            $cond = "country_name LIKE '%".$_GET['q']."%' AND status = 'Active'"; 
        } else {
            $cond = "status = 'Active'"; 
        }
        $country_data = $this->Suppliers_model->GetDataAll($table,$cond,'','',10);
        $json = [];
        foreach($country_data as $country){
             $json[] = ['id'=>$country->country_name, 'text'=>$country->country_name];
        }
        echo json_encode($json);
    }
    public function states(){
        $table = "mst_states";
        $country_id = $this->Suppliers_model->GetData('mst_countries',"country_name='".$_GET['country']."'");
        if(isset($_GET['searchTerm'])){
            $cond = "state_name LIKE '%".$_GET['searchTerm']."%' AND mst_country_id = ".$country_id->id." AND status = 'Active'"; 
        } else {
            $cond = "mst_country_id = ".$country_id->id." AND status = 'Active'"; 
        }
        $state_data = $this->Suppliers_model->GetDataAll($table,$cond,'','',10);
        $json = [];
        foreach($state_data as $state){
             $json[] = ['id'=>$state->state_name, 'text'=>$state->state_name];
        }
        echo json_encode($json);
    }
    public function cities(){
        $table = "mst_cities";
        $state_id = $this->Suppliers_model->GetData('mst_states',"state_name='".$_GET['state']."'");
        if(isset($_GET['searchTerm'])){
            $cond = "city_name LIKE '%".$_GET['searchTerm']."%' AND mst_state_id = ".$state_id->id." AND mst_country_id = ".$state_id->mst_country_id." AND status = 'Active'"; 
        } else {
            $cond = "mst_state_id = ".$state_id->id ." AND mst_country_id = ".$state_id->mst_country_id." AND status = 'Active'"; 
        }
        $city_data = $this->Suppliers_model->GetDataAll($table,$cond,'','',10);
        $json = [];
        foreach($city_data as $city){
             $json[] = ['id'=>$city->city_name, 'text'=>$city->city_name];
        }
        echo json_encode($json);
    }
    //TO UPDATE CUSTOMER 
    public function update($user_id)
    {
            $id=base64_decode($user_id);
            $table = "suppliers";
            $cond = "id=".$id;
            $update_data = $this->Suppliers_model->GetData($table,$cond);
            $data = array(
                'file' => 'Suppliers/form',
                'heading' => 'Update Supplier',
                'body_class'=>BODY_CLASS,
                'action'=>site_url(SUPPLIERS_UPDATE_ACTION),
                'data'=>$update_data
            ); 
            $this->load->view('layout', $data); 
    } 
    public function update_action()
    {
        $table = "suppliers";
        $cond = "id=".$_POST['id'];
        $update = $this->Suppliers_model->SaveData($table,$_POST,$cond);
        if(isset($update)){
            redirect(SUPPLIERS);
        }
    }
    public function delete($user_id)
    {
        $id=base64_decode($user_id);
        $table = "suppliers";
        $cond = "id=".$id;
        if($this->Suppliers_model->DeleteData($table,$cond)){
            redirect(SUPPLIERS);
        }
    }
    public function view($user_id){
        $id=base64_decode($user_id);
        $table = "suppliers";
        $cond = "id=".$id;
        $data = $this->Suppliers_model->GetData($table,$cond);
        $data = array(
                'file' => 'Suppliers/view',
                'heading' => 'View Supplier',
                'body_class'=>BODY_CLASS,
                'data'=>$data
            );
        $this->load->view('layout', $data); 
    }
    public function cust_ajax($customer_id)
    {
        $table = "purchase_invoice i";
        $cond = "i.user_id=".id." and i.Suppliers_id=".$customer_id;
        $userData=$this->Purchase_model->get_datatables($table,$cond);
        $data = array();    
        $no= 0;    
        foreach ($userData as $usersData) 
        {
            $btn = anchor(site_url(PURCHASE_VIEW.'/'.$usersData->id),'<button title="View" class="btn btn-xs btn-default waves-effect"><i class="fa fa-eye"></i></button>');
            $btn .='&nbsp;|&nbsp;'.anchor(site_url(PURCHASE_PAYMENT.'/'.base64_encode($usersData->id)),'<button title="Payment" class="btn btn-info btn-circle btn-xs"><i class="fa fa-money"></i></button>');
            $btn .= '&nbsp;|&nbsp;'.anchor(site_url(INVOICES_PDF.'/'.$usersData->id),'<button title="Download PDF" class="btn btn-primary btn-circle btn-xs"><i class="fa fa-files-o"></i></button>'); 
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
	public function Get_GSTIN(){
		$table = "suppliers";
		$cond = "id=".$_POST['id'];
		$data = $this->Suppliers_model->GetData($table,$cond);
		print_r(json_encode($data));exit;
	}
 }
?>
