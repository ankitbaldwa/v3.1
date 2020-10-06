<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// Load form helper library
		$this->load->helper('form');
		// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');
		//load file helper
        $this->load->helper('file');
		// Load database
		$this->load->helper('security');
		$this->load->model('Mymodel');
		/** Load comapny details and database */
		$this->company = get_company();
		$this->db = load_db($this->company);
		/** Load comapny details and database */
		if(isset($this->session->userdata('logged_in')['id'])){
			$login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
			$setting_data = $this->Mymodel->GetDataArray('settings',"","user_id='".$this->session->userdata('logged_in')['id']."' and (name='Company Name' or name='Invoice_no' or name='GST Number')");
                        if($setting_data[0]['name'] == 'Company Name')
				define('LOGO',$setting_data[0]['value']);
			if($setting_data[2]['name'] == 'Invoice_no')
				define('LOGO_MINI', $setting_data[2]['value']);
                        if($setting_data[1]['name'] == 'GST Number')
				define('GST_NUMBER', $setting_data[1]['value']);
			define('profile',$login_name->profile);
			define('name',$login_name->username);
			define('last_login',$login_name->last_login);
			define('Id', $this->session->userdata('logged_in')['id']);
		} 
	}
	public function index()
	{
		$data = array(
			'button' => 'Login',		
			'action' => site_url('login-action'),
			'body_class'=>'hold-transition login-page',
			'company_name' => $this->company->company_name,
			'company_code' => $this->company->company_code,
			'file'	=> 'login'
		);
		if(MAINTANCE){
			$this->load->view('maintance');
		} else {
			$this->load->view('layout', $data);
		}
	}
	public function Mydashboard()
	{
		$this->load->library('Numbertowordconvertsconver');
		$user_log = $this->Mymodel->GetDataArray('user_logs',array('ip_address', 'description', 'created'),"user_id='".$this->session->userdata('logged_in')['id']."'","","id DESC","10");
		$fy = $this->Mymodel->GetData("mst_financial_year","user_id=".Id." and status='Active'");
		$dashboard_data = $this->Mymodel->Dashboard(Id, "CALL GetDashboard(?, ?, ?)",$fy->from_date,$fy->to_date);
		$Donut_chart = $this->Mymodel->Dashboard(Id, "CALL Donut_chart(?, ?, ?)",$fy->from_date,$fy->to_date);
		$complete_gst = $this->Mymodel->GetGst(Id,"CALL GetGST(?, ?, ?, ?)",$fy->from_date,$fy->to_date,'Completed');
		//$complete_gst = $this->Mymodel->GetGst(Id,"CALL GetGST(?, ?, ?, ?)",'2019-04-01','2020-03-31','Completed');
		$script = $this->Mymodel->Script('invoice i',"i.status != 'Cancelled' AND i.invoice_date BETWEEN '".$fy->from_date."' AND '".$fy->to_date."' AND i.user_id='".Id."'", 'DATE_FORMAT(i.invoice_date, "%Y-%m") ASC','DATE_FORMAT(i.invoice_date, "%M %Y")');
		$purchase_script = $this->Mymodel->Purchase_Script('purchase_invoice pi',"pi.status != 'Cancelled' AND pi.invoice_date BETWEEN '".$fy->from_date."' AND '".$fy->to_date."' AND pi.user_id='".Id."'", 'DATE_FORMAT(pi.invoice_date, "%Y-%m") ASC','DATE_FORMAT(pi.invoice_date, "%M %Y")');
		//$script2 = $this->Mymodel->Script2('`invoice_payments` `p` ',"`p`.`Status` = 'Completed' AND YEAR(`p`.`payment_date`)=YEAR(CURDATE()) AND MONTH(`p`.`payment_date`) BETWEEN 1 AND 12 AND  `p`.`user_id`='".Id."'", '','DATE_FORMAT(`p`.`payment_date`, "%M %Y")');
		$script2 = $this->Mymodel->Script2('`invoice_payments` `p` ',"`p`.`Status` = 'Completed' AND 
		`p`.`payment_date` BETWEEN '".$fy->from_date."' AND '".$fy->to_date."' AND  `p`.`user_id`='".Id."'", 'DATE_FORMAT(`p`.`payment_date`, "%Y-%m") ASC','DATE_FORMAT(`p`.`payment_date`, "%M %Y")');
		//print_r($this->db->last_query());exit; 
		$purchase_script2 = $this->Mymodel->Purchase_Script2('`purchase_invoice_payments` `pp` ',"`pp`.`Status` = 'Completed' AND 
		`pp`.`payment_date` BETWEEN '".$fy->from_date."' AND '".$fy->to_date."' AND  `pp`.`user_id`='".Id."'", 'DATE_FORMAT(`pp`.`payment_date`, "%Y-%m") ASC','DATE_FORMAT(`pp`.`payment_date`, "%M %Y")');
		$email_setup = $this->Mymodel->GetData("settings","user_id = ".Id." AND name='from_email_setup'");
                if(empty($email_setup)){
                    $show_popup = true;
                } else {
                    $show_popup = false;
                }
                //print_r($email_setup);exit;
		$main_db = switch_db_main();
		//print_r($main_db['database']);exit;
		$mainDB = $this->load->database($main_db, TRUE);
		$release_note = $this->Mymodel->getReleaseNoteData($mainDB, "release_notes r", "r.status = 'Active'");
		//print_r($release_note);exit; 
		$data = array(
			'file' => 'Dashboard/dashboard',
			'body_class'=>BODY_CLASS,
			'data' => $dashboard_data[0],
			'user_log'=>$user_log,
			'script'=>json_encode($script),
			'purchase_script'=>json_encode($purchase_script),
			'script2'=>json_encode($script2),
			'purchase_script2'=>json_encode($purchase_script2),
			'Donut_chart'=>$Donut_chart[0],
			'complete_gst' => $complete_gst,
			'release_note' => $release_note,
                        'show_popup' => $show_popup
		);
     	$this->load->view('layout', $data);
	}
        public function update_email(){
            $save_data = $this->Mymodel->SaveData("settings", array('user_id'=>Id, "name"=>'from_email_setup', 'value'=>$_POST['email']));
            if($save_data){
                echo 1;exit;
            } else {
                echo 2; exit;
            }
        }
	public function Profile()
	{
		$user_data = $this->Mymodel->GetData("users","id=".Id);
		$data = array(
			'file' => 'Dashboard/profile',
			'body_class'=>BODY_CLASS,
			'heading' => 'Profile',
			'userdata' => $user_data,
			'action' => site_url(PROFILE_ACTION)
		);
     	$this->load->view('layout', $data);
	}
	public function Profile_action(){
		if($_FILES['profile']['name']!=''){
			$_POST['profile']= rand(0000,9999)."_".$_FILES['profile']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['profile']['tmp_name'];
			$config2['new_image'] =   getcwd().'/assets/dist/img/'.$_POST['profile'];
			$config2['allowed_types'] = 'JPG|PNG|jpg|png|JPEG|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->load->library('image_lib', $config2);
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize())
			{
				$this->session->set_flashdata('image_error', '<span class="text text-danger">This file type is not allowed</span>');
				$this->Profile();
				return;
			}
			else
			{
				$image  = $_POST['profile'];
			}
			$data = array(
				'username' => $_POST['username'],
				'email' => $_POST['email'],
				'mobile' => $_POST['mobile'],
				'profile' => $_POST['profile']
			);
			$condition = "id = ".Id;
			$result = $this->Mymodel->SaveData('users',$data,$condition );
			$this->session->set_flashdata('message','Record has been created successfully');
            redirect(site_url(PROFILE));
        } else {
			$this->session->set_flashdata('image_error', '<span class="text text-danger">Please upload image</span>');
			$this->Profile();
			return;
		}
	}
	//function for change password action
	public function Changepassword()
    {
		$user_data = $this->Mymodel->GetData("users","id=".Id);
		$data = array(
			'file' => 'Dashboard/changepassword',
			'body_class'=>BODY_CLASS,
			'heading' => 'Change Password',
			'userdata' => $user_data,
			'action' => site_url(CHANGEPASSWORD_ACTION)
		);
     	$this->load->view('layout', $data);
	}
	public function Changepassword_action()
    { 
    	$tableName = "users";
	    $condition = "id='".Id."'";
    	$data=array(
    				'password'=>md5($_POST['cn_password'])
    				);
    	$this->Mymodel->SaveData($tableName,$data,$condition);
    	$this->session->unset_userdata('logged_in', $sess_array);
		$this->session->set_flashdata('login_error','<div class="alert alert-success">Password Changed Successfully</div>');
		redirect('login');
		$this->index();
	}
	function checkCorrectPassword()
    { 
    	$getUserData = $this->Mymodel->GetData('users','',"id='".Id."'",'','','','Single');
    	
    	if(!empty($getUserData))
    	{
    		if($getUserData->password!=md5($_POST['cpassword']))
    		{
    			echo "1";exit;
    		}
			else 
			{ 
				echo "2";exit; 
			}
    		
    	}
    }
	
	// Check for user login process
	public function user_login_process() {
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email',
				array(
						'required'      => 'You have not provided %s',						
						'valid_email'=>'Please enter valid email'
					));
		$this->form_validation->set_rules('password', 'password', 'trim|required',
					array(
							'required'      => 'You have not provided %s',						
						));				
		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text text-danger">', '</span>');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$database = switch_db_dinamico($this->company->company_db_database, $this->company->company_db_host, $this->company->company_db_username, $this->company->comapny_db_password);
			$this->db = $this->load->database($database, TRUE);
			$data = array(
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password')
			);
			$condition = "email =" . "'" . $this->input->post('email') . "' AND " . "password ='" . md5($this->input->post('password')) . "'";
			$result = $this->Mymodel->login('users', $condition);
			//print_r($result);exit;
			if ($result != '') {
				$session_data = array(
					'id' => $result->id,
					'username' => $result->username,
					'email' => $result->email,
					'mobile' => $result->mobile,
					'role' => $result->role,
					'last_login'=>$result->last_login,
					'release_note_flag' => $result->release_note_flag,
					'company_name' => $this->company->company_name,
					'company_code' => $this->company->company_code,
					'company_db_host' => $this->company->company_db_host,
					'company_db_username' => $this->company->company_db_username,
					'comapny_db_password' => $this->company->comapny_db_password,
					'company_db_database' => $this->company->company_db_database
				);
				$userLogs_data = array(
					'user_id'=>$result->id,
					'device_info'=>$_SERVER['HTTP_USER_AGENT'],
					'description'=>'Login',
					'ip_address'=>$this->get_client_ip()
				);
				$result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
				$user_data_update = array(
					'last_login'=>date('Y-m-d H:i:s', time()),
					'ip_address'=>$this->get_client_ip()
				);
				$result = $this->Mymodel->SaveData('users',$user_data_update,$condition );
				// Add user data in session
				$this->session->set_userdata('logged_in', $session_data);
        		redirect(site_url('dashboard'));
				$this->Mydashboard();
			} else {
				$this->session->set_flashdata('login_error','<div class="alert alert-danger">Your email and password does not match</div>');
        		$this->index();
			}
		}
	}
	public function update_release_note(){
		$dt = $this->Mymodel->SaveData("users",array('release_note_flag' => 1),"id=".Id);
		echo 1; exit;
	}
	public function get_release_note(){
		$user_data = $this->Mymodel->GetData("users","id=".Id);
		echo $user_data->release_note_flag; exit;
	}
	// Logout from admin page
	public function logout() {
		// Removing session data
		$sess_array = array(
			'name' => ''
		);
		$userLogs_data = array(
			'user_id'=>Id,
			'device_info'=>$_SERVER['HTTP_USER_AGENT'],
			'description'=>'Logout',
			'ip_address'=>$this->get_client_ip()
		);
		$result = $this->Mymodel->SaveData('user_logs', $userLogs_data );
		$this->session->unset_userdata('logged_in', $sess_array);
		//$this->session->set_flashdata('login_error','<div class="alert alert-success">Successfully Logout</div>');
		redirect('login');
		$this->index();
	}
	//For graphs
	public function script_graph(){
		$data = $this->Mymodel->Script('invoice i','YEAR(i.invoice_date)=YEAR(CURDATE()) AND MONTH(i.invoice_date) BETWEEN 1 AND 12 AND i.user_id = '.Id, '','DATE_FORMAT(i.invoice_date, "%m-%Y")');
		print_r(json_encode($data));exit;
	}
	public function get_client_ip() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if(isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
	}
        public function release_notes(){
            $main_db = switch_db_main();
            //print_r($main_db['database']);exit;
            $mainDB = $this->load->database($main_db, TRUE);
            $release_note = $this->Mymodel->getReleaseNoteData($mainDB, "release_notes r", "r.status = 'Active'");
            $release_notes_all = $this->Mymodel->GetReleaseNoteDataAllRecords($mainDB, "release_notes r","","id DESC");
            $data = array(
                    'release_note' => $release_note,
                    'all_release_notes' => $release_notes_all
		);
            $this->load->view('release_notes', $data);
        }
}
