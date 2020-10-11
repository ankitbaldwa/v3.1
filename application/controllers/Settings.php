<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Parent {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
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
        } else {
            redirect(LOGIN);
        }
    }
    public function index()
    {   
        $cond = "user_id = ".id;
        $settings_data = $this->Mymodel->GetDataArray('settings','', $cond); 
        $user_data = $this->Mymodel->GetData("users","id=".id);
        $data = array(
            'file' => 'Settings/list',
            'settings_data' => $settings_data,
            'body_class'=>BODY_CLASS,
            'heading'=>'Manage Settings',
            'userdata' => $user_data
        );
        $this->load->view('layout', $data);
    }
    //TO UPDATE SETTINGS 
    public function update($user_id)
    {
            $id=base64_decode($user_id);
            $table = "settings";
            $cond = "id=".$id;
            $update_data = $this->Mymodel->GetData($table,$cond);
            $user_data = $this->Mymodel->GetData("users","id=".id);
            $data = array(
                'file' => 'Settings/form',
                'heading' => 'Update Settings',
                'body_class'=>BODY_CLASS,
                'action'=>site_url(SETTINGS_UPDATE_ACTION),
                'data'=>$update_data,
                'userdata' => $user_data
            );
            $this->load->view('layout', $data); 
    } 
    public function update_action()
    {
        $table = "settings";
        $cond = "id=".$_POST['id'];
        $update = $this->Mymodel->SaveData($table,$_POST,$cond);
        if(isset($update)){
            redirect(SETTINGS);
        }
    }
 }
?>
