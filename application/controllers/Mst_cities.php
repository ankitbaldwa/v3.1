<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_cities extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mst_cities_model');
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
            'file'  => 'mst_cities/mst_cities_list',
            'title' => 'ACCORDANCE | City',
            'heading' => 'Manage City',
            'body_class'=>BODY_CLASS,
        );
          $this->load->view('Layout', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Mst_cities_model->json();
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
        $this->Mst_cities_model->update($id, $data);
        //print_r($this->db->last_query());exit;
        $this->session->set_flashdata('message', '<span class="alert alert-success alert-message">Status Updated Successfully</span>');
        redirect(site_url('city'));
    }


    

    public function create() 
    {
        $states = $this->Mymodel->GetData('mst_states','',"status='Active'");
        $Countries = $this->Mymodel->GetData('mst_countries','',"status='Active'");
        $data = array(
            'file'  => 'mst_cities/mst_cities_form',
             'title' => 'ACCORDANCE | City',
             'heading' => 'Create City',
            'button' => 'Create',
            'action' => site_url('city_create_action'),
	    'id' => set_value('id'),
	    'mst_country_id' => set_value('mst_country_id'),
	    'mst_state_id' => set_value('mst_state_id'),
	    'city_name' => set_value('city_name'),
         'Countries'=>$Countries,
         'states'=>$states,
	   
	);
        $this->load->view('Layout', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'mst_country_id' => $this->input->post('mst_country_id',TRUE),
		'mst_state_id' => $this->input->post('mst_state_id',TRUE),
		'city_name' => $this->input->post('city_name',TRUE),
		
	    );

            $this->Mst_cities_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('city'));
        }
    }

   public function get_state()
  {
    //print_r($_POST['id']); exit();
    $get_state = $this->Mymodel->GetData('mst_states','id,state_name',"mst_country_id='".$_POST['id']."'");
    
    $html = "<option value=''>Select State</option>";

    foreach ($get_state as $key) 
    {
      $html.="<option value='".$key->id."'>".$key->state_name."</option>";
    }

    echo $html;
  }
    
    public function update($id) 
    {
         $states = $this->Mymodel->GetData('mst_states','',"status='Active'");
        $Countries = $this->Mymodel->GetData('mst_countries','',"status='Active'");
        $row = $this->Mst_cities_model->get_by_id($id);

        if ($row) {
            $data = array(
                 'file'  => 'mst_cities/mst_cities_form',
                'title' => 'ACCORDANCE | City',
                 'heading' => 'Update City',
                'button' => 'Update',
                'action' => site_url('city_update_action'),
		'id' => set_value('id', $row->id),
		'mst_country_id' => set_value('mst_country_id', $row->mst_country_id),
		'mst_state_id' => set_value('mst_state_id', $row->mst_state_id),
		'city_name' => set_value('city_name', $row->city_name),
         'Countries'=>$Countries,
         'states'=>$states,
		
	    );
            $this->load->view('Layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('city'));
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
		'mst_state_id' => $this->input->post('mst_state_id',TRUE),
		'city_name' => $this->input->post('city_name',TRUE),
		
	    );

            $this->Mst_cities_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('city'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Mst_cities_model->get_by_id($id);

        if ($row) {
            $this->Mst_cities_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mst_cities'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mst_cities'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('mst_country_id', 'mst country id', 'trim|required');
	$this->form_validation->set_rules('mst_state_id', 'mst state id', 'trim|required');
	$this->form_validation->set_rules('city_name', 'city name', 'trim|required');
	

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "mst_cities.xls";
        $judul = "mst_cities";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Mst State Id");
	xlsWriteLabel($tablehead, $kolomhead++, "City Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Created");
	xlsWriteLabel($tablehead, $kolomhead++, "Modified");

	foreach ($this->Mst_cities_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->mst_country_id);
	    xlsWriteNumber($tablebody, $kolombody++, $data->mst_state_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->city_name);
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
        header("Content-Disposition: attachment;Filename=mst_cities.doc");

        $data = array(
            'mst_cities_data' => $this->Mst_cities_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('mst_cities/mst_cities_doc',$data);
    }

}

/* End of file Mst_cities.php */
/* Location: ./application/controllers/Mst_cities.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-15 13:12:07 */
/* http://harviacode.com */