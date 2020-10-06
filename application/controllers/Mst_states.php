<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_states extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mst_states_model');
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
            'file'  => 'mst_states/mst_states_list',
            'title' => 'ACCORDANCE | States',
            'heading' => 'Manage States',
            'body_class'=>BODY_CLASS,
        );
          $this->load->view('Layout', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Mst_states_model->json();
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
        $this->Mst_states_model->update($id, $data);
        //print_r($this->db->last_query());exit;
        $this->session->set_flashdata('message', '<span class="alert alert-success alert-message">Status Updated Successfully</span>');
        redirect(site_url('states'));
    }

    
    public function create() 
    {
         $Countries = $this->Mymodel->GetData('mst_countries','',"status='Active'");
        $data = array(
            'file'  => 'mst_states/mst_states_form',
                'title' => 'ACCORDANCE | States',
                'heading' => 'Create States',
            'button' => 'Create',
            'action' => site_url('states_create_action'),
	    'id' => set_value('id'),
	    'mst_country_id' => set_value('mst_country_id'),
	    'state_name' => set_value('state_name'),
	    
        'Countries'=>$Countries,
	);
        $this->load->view('Layout', $data);
    }
    
    public function create_action() 
    {
        //print_r($_POST);exit;
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'mst_country_id' => $this->input->post('mst_country_id',TRUE),
		'state_name' => $this->input->post('state_name',TRUE),
		
		//'created' => $this->input->post('created',TRUE),
		
	    );
           //print_r($data);exit;
            $this->Mst_states_model->insert($data);

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('states'));
        }
    }
    
    public function update($id) 
    {
         $Countries = $this->Mymodel->GetData('mst_countries','',"status='Active'");
        $row = $this->Mst_states_model->get_by_id($id);

        if ($row) {
            $data = array(
                'file'  => 'mst_states/mst_states_form',
                'title' => 'ACCORDANCE | States',
                'heading' => 'Update States',
                'button' => 'Update',
                'action' => site_url('states_update_action'),
		'id' => set_value('id', $row->id),
		'mst_country_id' => set_value('mst_country_id', $row->mst_country_id),
		'state_name' => set_value('state_name', $row->state_name),
		
		'modified' => set_value('modified', $row->modified),
         'Countries'=>$Countries,
	    );
            $this->load->view('Layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('states'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'mst_country_id' => $this->input->post('mst_country_id',TRUE),
		'state_name' => $this->input->post('state_name',TRUE),
		
		'modified' => $this->input->post('modified',TRUE),
	    );

            $this->Mst_states_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('states'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Mst_states_model->get_by_id($id);

        if ($row) {
            $this->Mst_states_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mst_states'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mst_states'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('mst_country_id', 'mst country id', 'trim|required');
	$this->form_validation->set_rules('state_name', 'state name', 'trim|required');
	

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "mst_states.xls";
        $judul = "mst_states";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Mst Country Id");
	xlsWriteLabel($tablehead, $kolomhead++, "State Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Created");
	xlsWriteLabel($tablehead, $kolomhead++, "Modified");

	foreach ($this->Mst_states_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->mst_country_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->state_name);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status);
	    xlsWriteLabel($tablebody, $kolombody++, $data->created);
	    xlsWriteLabel($tablebody, $kolombody++, $data->modified);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=mst_states.doc");

        $data = array(
            'mst_states_data' => $this->Mst_states_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('mst_states/mst_states_doc',$data);
    }

}

/* End of file Mst_states.php */
/* Location: ./application/controllers/Mst_states.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-06-24 12:18:49 */
/* http://harviacode.com */