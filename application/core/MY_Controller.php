<?php
class Admin_Parent extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel');
        // Load session library
        $this->load->library('session');
        /** Load comapny details and database */
        $this->company = get_company();
        $this->database = load_db($this->company);
        define('COMPANY_DATABASE', $this->company->company_db_database);
        /** Load comapny details and database */
        if(isset($this->session->userdata('logged_in')['id'])){
            $setting_data = $this->Mymodel->GetDataArray(COMPANY_DATABASE.'.settings',"","user_id='".$this->session->userdata('logged_in')['id']."' and (name='Company Name' or name='Invoice_no' or name='GST Number')");
            if($setting_data[0]['name'] == 'Company Name')
                    define('LOGO',$setting_data[0]['value']);
            if($setting_data[2]['name'] == 'Invoice_no')
                    define('LOGO_MINI', $setting_data[2]['value']);
            if($setting_data[1]['name'] == 'GST Number')
                    define('GST_NUMBER', $setting_data[1]['value']);
            $fy = $this->Mymodel->GetData(COMPANY_DATABASE.".mst_financial_year","user_id=".$this->session->userdata('logged_in')['id']." and status='Active'");
            define('CURENT_FY_YEAR', date('d-M-Y',strtotime($fy->from_date)).' to '.date('d-M-Y',strtotime($fy->to_date)));
        }
    }
}