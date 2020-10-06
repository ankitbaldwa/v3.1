<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_countries extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mst_countries_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
        $this->load->library('session');
        $this->load->model('Mymodel');
        /** Load comapny details and database */
	$this->company = get_company();
        $this->db = load_db($this->company);
	/** Load comapny details and database */
        if(isset($this->session->userdata('logged_in')['id'])){
            $login_name = $this->Mymodel->GetDataCount('users',array('username', 'last_login','profile'),"id='".$this->session->userdata('logged_in')['id']."'");
            define('name',$login_name->username);
            define('last_login',$login_name->last_login);
            define('Id', $this->session->userdata('logged_in')['id']);
            $setting_data = $this->Mymodel->GetDataArray('settings',"","user_id='".$this->session->userdata('logged_in')['id']."' and (name='Company Name' or name='Invoice_no' or name='GST Number')");
                        if($setting_data[0]['name'] == 'Company Name')
				define('LOGO',$setting_data[0]['value']);
			if($setting_data[2]['name'] == 'Invoice_no')
				define('LOGO_MINI', $setting_data[2]['value']);
                        if($setting_data[1]['name'] == 'GST Number')
				define('GST_NUMBER', $setting_data[1]['value']);
            define('profile',$login_name->profile);
        }
    }

    public function index()
    {
        $data = array(
            'file'  => 'mst_countries/mst_countries_list',
            'title' => 'ACCORDANCE | Country',
            'heading' => 'Manage Country',
            'body_class'=>BODY_CLASS,
        );
        //print_r($data);exit;
        $this->load->view('Layout', $data);
        
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Mst_countries_model->json();
    }

    public function status($status, $id){
        $data = array();
        //print_r($status);
        if($status == 'Active'){
            $data = array(
                'status' => 'Inactive'
            );
        } 
        if($status == 'Inactive'){
            $data = array(
                'status' => 'Active'
            );
        }
        $this->Mst_countries_model->update($id, $data);
        //print_r($this->db->last_query());exit;
        $this->session->set_flashdata('message', '<span class="alert alert-success alert-message">Status Updated Successfully</span>');
        redirect(site_url('countries'));
    }

public function create_countries()
  {

        $data=array(
        'country_name'=>$_POST['country_name'],
        'code'=>$_POST['code']
    );
        //$this->Crud_model->SaveData('mst_countries',$data);
         $this->Mst_countries_model->insert($data);
         //print_r($this->db->last_query());exit;
        $this->session->set_flashdata('message', 'Country created successfully');
       
  }
    public function create() 
    {
        $data = array(
            'file'  => 'mst_countries/mst_countries_form',
                'title' => 'ACCORDANCE | Country',
                'heading' => 'Create Country',
            'button' => 'Create',
            'action' => site_url('countries_create_action'),
	    'id' => set_value('id'),
	    'country_name' => set_value('country_name'),
	    'code' => set_value('code'),
	   
	);
        $this->load->view('Layout', $data);
    }
    
    public function create_action() 
    {    //print_r($_POST);exit;
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'country_name' => $this->input->post('country_name',TRUE),
		'code' => $this->input->post('code',TRUE),
		
	    );
              //print_r($data);exit;
            $this->Mst_countries_model->insert($data);
          
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('countries'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Mst_countries_model->get_by_id($id);

        if ($row) {
            $data = array(
                 'file'  => 'mst_countries/mst_countries_form',
                'title' => 'ACCORDANCE | Country',
                'heading' => 'Create Country',
                'button' => 'Update',
                'action' => site_url('countries_update_action'),
		'id' => set_value('id', $row->id),
		'country_name' => set_value('country_name', $row->country_name),
		'code' => set_value('code', $row->code),
		
	    );
            $this->load->view('Layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('countries'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'country_name' => $this->input->post('country_name',TRUE),
		'code' => $this->input->post('code',TRUE),
		
	    );

            $this->Mst_countries_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('countries'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Mst_countries_model->get_by_id($id);

        if ($row) {
            $this->Mst_countries_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('countries'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('countries'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('country_name', 'country name', 'trim|required');
	$this->form_validation->set_rules('code', 'code', 'trim|required');
	

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "mst_countries.xls";
        $judul = "mst_countries";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Country Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Code");
	

	foreach ($this->Mst_countries_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->country_name);
	    xlsWriteLabel($tablebody, $kolombody++, $data->code);
	

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mst_countries.doc");

        $data = array(
            'mst_countries_data' => $this->Mst_countries_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('mst_countries/mst_countries_doc',$data);
    }

}

/* End of file Mst_countries.php */
/* Location: ./application/controllers/Mst_countries.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-06-15 14:12:06 */
/* http://harviacode.com */