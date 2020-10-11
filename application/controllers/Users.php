<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Parent {

    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->model('Users_model');
        $this->load->library('session');
        /** Load comapny details and database */
		$this->company = get_company();
        $this->db = load_db($this->company);
		/** Load comapny details and database */
        if(isset($this->session->userdata('logged_in')['id'])){
            $login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
            define('name',$login_name->username);
            define('last_login',$login_name->last_login);
            define('profile',$login_name->profile);
        } 
    }
    public function index()
    {        
        $data = array(
            'file' => 'Users/list',
            'body_class'=>BODY_CLASS
        );
        $this->load->view('layout', $data);
    } 
    public function ajax()
    {  
        $table = "users";
        $cond = "role !='Admin'";

        $userData=$this->Users_model->get_datatables($table,$cond);
        $data = array();    
            $no= 0;    
        foreach ($userData as $usersData) 
        {
               // $btn = anchor(site_url('Users/view/'.base64_encode($usersData->id)),'<button title="View" class="btn btn-sm btn-default waves-effect"><i class="fa fa-eye"></i></button>');
                $btn =anchor(site_url('user-update/'.base64_encode($usersData->id)),'<button title="Edit" class="btn btn-info btn-circle btn-xs"><i class="fa fa-edit"></i></button>');
                //$btn .='&nbsp;|&nbsp;'.'<span class="btn btn-danger btn-circle btn-sm" style="cursor:pointer" onclick="delCountries('.$usersData->id.');"><i class="fa fa-trash"></i></span>';
                $btn .='&nbsp;|&nbsp;'.anchor(site_url('Users/delete/'.base64_encode($usersData->id)),'<button title="Delete" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-trash"></i></button>');
            if($usersData->status=='Active')
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
            $nestedData[] = ucfirst($usersData->username);
            $nestedData[] = $usersData->email;
            $nestedData[] = $usersData->mobile;
            $nestedData[] = $usersData->role;
            $nestedData[] = $status;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->Users_model->count_all('users',$cond),
                    "recordsFiltered" => $this->Users_model->count_filtered('users',$cond),
                    "data" => $data,
                );
        echo json_encode($output);
    }
    // TO CREATE USER
    public function create(){
        $data = array(
            'file' => 'Users/form',
            'heading' => 'Add Company',
            'body_class'=>BODY_CLASS,
            'action'=>site_url('Users/create_action'),
        );
        $this->load->view('layout', $data);
    }
    public function create_action()
    {
        $table = "users";
        $data = array(
            'username'=>$_POST['username'],
            'email'=>$_POST['email'],
            'mobile'=>$_POST['mobile'],
            'password'=>md5($_POST['password'])
        );
        $create = $this->Users_model->SaveData($table,$data,$cond);
        if(isset($create)){
            redirect('users');
        }
    }
    //TO UPATE USER 
    public function update($user_id)
    {
            $id=base64_decode($user_id);
            $table = "users";
            $cond = "id=".$id;
            $update_data = $this->Users_model->GetData($table,$cond);
            $data = array(
                'file' => 'Users/form',
                'heading' => 'Update Company',
                'body_class'=>BODY_CLASS,
                'action'=>site_url('Users/update_action'),
                'data'=>$update_data
            );
            $this->load->view('layout', $data); 
    } 
    public function update_action()
    {
        $table = "users";
        $cond = "id=".$_POST['id'];
        $update = $this->Users_model->SaveData($table,$_POST,$cond);
        if(isset($update)){
            redirect('users');
        }
    }
    public function delete($user_id)
    {
        $id=base64_decode($user_id);
        $table = "users";
        $cond = "id=".$id;
        if($this->Users_model->DeleteData($table,$cond)){
            redirect('users');
        }
    }
 }
?>
