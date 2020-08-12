<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {
    function __construct()
    {
        parent::__construct();      
        $this->load->database();
        $this->load->model('Mymodel');
        $this->load->library('session');
    }
    public function index(){
        /** Dynamic Database Connection starts here */
        $get_all_db = $this->Mymodel->GetDataAllRecords('subscription');
        foreach($get_all_db as $db){
            $database = switch_db_dinamico($db->company_db_database, $db->company_db_host, $db->company_db_username, $db->comapny_db_password);
            $this->db = $this->load->database($database, TRUE);
            $this->create_table($db->company_db_database);
            $this->alter_table($db->company_db_database);
        }
		/** Dynamic Database Connection starts here */
    }
    public function create_table($database){
       $sql = "CREATE TABLE $database.`ledger` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `customer_id` INT NULL , `invoice_id` INT NULL , `payment_id` INT NULL , `transaction_date` DATE NOT NULL , `narration` TEXT NOT NULL , `dr_amount` FLOAT NULL , `cr_amount` FLOAT NULL , `balance_amount` FLOAT NOT NULL , `created` DATETIME NOT NULL , `modified` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

       $this->db->query($sql);

    }
    public function alter_table($database){
        $sql = "ALTER TABLE $database.`customers` ADD `Balance_as_on` DATE NOT NULL AFTER `Country`, ADD `Type` ENUM('Dr','Cr') NOT NULL AFTER `Balance_as_on`, ADD `Opening_balance` FLOAT NOT NULL AFTER `Type`;";
        $this->db->query($sql);
        $sql2 = "ALTER TABLE $database.`users` ADD `release_note_flag` INT NOT NULL DEFAULT '0' AFTER `profile`;";
        $this->db->query($sql2);
    }
    public function update_op_balance_customer(){
        $get_all_db = $this->Mymodel->GetDataAllRecords('subscription');
        foreach($get_all_db as $db){
            $database = switch_db_dinamico($db->company_db_database, $db->company_db_host, $db->company_db_username, $db->comapny_db_password);
            $this->db = $this->load->database($database, TRUE);

            $cus_data = $this->Mymodel->Customer_balance('customers U');
            foreach($cus_data as $cust){
                if($cust->balance_amount != ''){
                    $balance = $cust->balance_amount;
                } else {
                    $balance = 0;
                }
                $cust_arr = array(
                    'Type' => 'Dr',
                    'Opening_balance' => $balance,
                    'Balance_as_on' => date('Y-m-d'),
                    'Modified' => date('Y-m-d H:i:s')
                );
                $create = $this->Mymodel->SaveData('customers',$cust_arr,"id=".$cust->id);
                $user_id = $this->Mymodel->GetData('users',"role='User'");
                $ledger_data = array(
                    'user_id' => $user_id->id,
                    'customer_id' => $cust->id,
                    'transaction_date' => date('Y-m-d'),
                    'narration' => "Opening Balance",
                    'balance_amount' => $balance,
                    'dr_amount' => $balance,
                    'created' => date('Y-m-d H:i:s')
                );
                $create = $this->Mymodel->SaveData('ledger',$ledger_data);
            }
        }
        echo "Data successfully saved";exit;
    }
}
?>