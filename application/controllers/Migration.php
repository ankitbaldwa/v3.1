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
        $this->db->query('ALTER TABLE `release_notes` ADD `key_points` TEXT NOT NULL AFTER `release_notes_pdf`;');
        /** Dynamic Database Connection starts here */
        $get_all_db = $this->Mymodel->GetDataAllRecords('subscription');
        foreach($get_all_db as $db){
            $database = switch_db_dinamico($db->company_db_database, $db->company_db_host, $db->company_db_username, $db->comapny_db_password);
            $this->db = $this->load->database($database, TRUE);
            //$this->create_table($db->company_db_database);
            //$this->alter_table($db->company_db_database);
            $this->customer_alter_table($db->company_db_database);
        }
        /** Dynamic Database Connection starts here */
    }
    public function customer_alter_table($database){
        $sql = "ALTER TABLE $database.`customers` ADD `place` VARCHAR(255) NULL AFTER `Country`;";
        $this->db->query($sql);
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
            //print_r($cus_data);exit;
            foreach($cus_data as $cust){
                if($cust->balance_amount != ''){
                    $balance = $cust->balance_amount;
                } else {
                    $balance = 0;
                }
                $cust_arr = array(
                    'Type' => 'Dr',
                    'Opening_balance' => $balance,
                    'Balance_as_on' => date('Y-m-d', strtotime('2020-04-01')),
                    'Modified' => date('Y-m-d H:i:s')
                );
                $create = $this->Mymodel->SaveData('customers',$cust_arr,"id=".$cust->id);
                $user_id = $this->Mymodel->GetData('users',"role='User'");
                $ledger_data = array(
                    'user_id' => $user_id->id,
                    'customer_id' => $cust->id,
                    'transaction_date' => date('Y-m-d', strtotime('2020-04-01')),
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
    public function insert_entries_existing_invoices_payments(){
        $get_all_db = $this->Mymodel->GetDataAllRecords('subscription');
        foreach($get_all_db as $db){
            $database = switch_db_dinamico($db->company_db_database, $db->company_db_host, $db->company_db_username, $db->comapny_db_password);
            $this->db = $this->load->database($database, TRUE);
            
            /* Initial date and duration of processing */
            $start = '2020-04-01';
            $to=date_create(date('Y-m-d'));
            $from=date_create($start);
            $diff=date_diff($to,$from);
            $months = $diff->days;

            /* reduce start date to it's constituent parts */
            $year = date('Y',strtotime($start));
            $month = date('m',strtotime($start));
            $day = date('d',strtotime($start));

            for( $i=0; $i <= $months; $i++ ){
                /* Get dates */
                $output=date('Y-m-d', mktime( 0, 0, 0, $month, $day + $i, $year ) );
                
                $inv_data = $this->Mymodel->GetDataAllRecords('invoice',"invoice_date = '".$output."'");
                foreach($inv_data as $inv){
                    $bal = $this->Mymodel->GetDataCount('ledger', array('sum(dr_amount) as dr_amount', 'sum(cr_amount) as cr_amount'), "customer_id=".$inv->Customer_id." AND transaction_date <= '".$inv->invoice_date."'");
                    $op_bal = $this->Mymodel->GetDataCount('customers', array('Balance_as_on', 'Type', 'Opening_balance'), "id=".$inv->Customer_id);
                    if($op_bal->Type == 'Dr'){
                         $balance_amt = ($op_bal->Opening_balance + $bal->dr_amount + $inv->Netammount) - $bal->cr_amount;
                    } else {
                         $balance_amt = ($op_bal->Opening_balance + $bal->cr_amount) - ($bal->dr_amount + $inv->Netammount);
                    }
                    $ledger_data = array(
                        'user_id' => $inv->user_id,
                        'customer_id' => $inv->Customer_id,
                        'invoice_id' => $inv->id,
                        'transaction_date' => date('Y-m-d', strtotime(str_replace('-', '/', $inv->invoice_date))),
                        'narration' => 'Sold Goods on credit',
                        'dr_amount'=> $inv->Netammount,
                        'balance_amount'=>$balance_amt,
                        'created' => date('Y-m-d H:i:s')
                    );
                    //print_r($ledger_data);print_r("<br/>");
                    $ledger_result = $this->Mymodel->SaveData('ledger', $ledger_data );
                }
                $payment_data = $this->Mymodel->GetDataAllRecords('invoice_payments',"payment_date = '".$output."'");
                foreach($payment_data as $payment){
                    $bal = $this->Mymodel->GetDataCount('ledger', array('sum(dr_amount) as dr_amount', 'sum(cr_amount) as cr_amount'), "customer_id=".$payment->customer_id." AND transaction_date <= '".$payment->payment_date."'");
                    //print_r($bal);
                    $op_bal = $this->Mymodel->GetDataCount('customers', array('Balance_as_on', 'Type', 'Opening_balance'), "id=".$payment->customer_id);
                    if($op_bal->Type == 'Dr'){
                         $balance_amt = ($op_bal->Opening_balance + $bal->dr_amount) - $bal->cr_amount - $payment->payed_amount;
                    } else {
                         $balance_amt = ($op_bal->Opening_balance + $bal->cr_amount + $payment->payed_amount) - $bal->dr_amount;
                    }
                    //print_r($bal);print_r($op_bal);print_r($balance_amt);exit;
                     $ledger_data = array(
                         'user_id' => $payment->user_id,
                         'customer_id' => $payment->customer_id,
                         'invoice_id' => $payment->invoice_id,
                         'payment_id' => $payment->id,
                         'transaction_date' => date('Y-m-d', strtotime(str_replace('-', '/', $payment->payment_date))),
                         'narration' => 'Amount received from customer in bank or cash',
                         'cr_amount'=> $payment->payed_amount,
                         'balance_amount'=>$balance_amt,
                         'created' => date('Y-m-d H:i:s')
                     );
                    // print_r($ledger_data);print_r("<br/>");
                     $ledger_result = $this->Mymodel->SaveData('ledger', $ledger_data );
                }//print_r("<br/>");print_r("<br/>");print_r("<br/>");
            }            
            echo "Data successfully saved";
            exit;
        }
    }
}
?>