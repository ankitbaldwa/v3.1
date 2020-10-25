<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Mymodel extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
    //Get data 
    public function GetData($table,$condition='',$order='',$group='',$limit='')
    {
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get($table)->row();
    }
    public function getReleaseNoteData($db, $table,$condition='',$order='',$group='',$limit=''){
        $db->select('r.id, r.version, r.release_notes, r.status, p.name, r.release_notes_pdf, r.key_points, r.created');
        $db->from($table);
        $db->join('package_pricing p', 'r.package_id = p.id', 'left');
        if($condition != '')
        $db->where($condition);
        if($order != '')
        $db->order_by($order);
        if($limit != '')
        $db->limit($limit);
        if($group != '')
        $db->group_by($group);
        return $db->get()->row();
    }
    public function GetReleaseNoteDataAllRecords($db, $table,$condition='',$order='',$group='',$limit='')
    {
        $db->select('r.id, r.version, r.release_notes, r.status, p.name, r.release_notes_pdf, r.key_points');
        $db->from($table);
        $db->join('package_pricing p', 'r.package_id = p.id', 'left');
        if($condition != '')
        $db->where($condition);
        if($order != '')
        $db->order_by($order);
        if($limit != '')
        $db->limit($limit);
        if($group != '')
        $db->group_by($group);
        return $db->get()->result();
    }
    public function GetDataCount($table,$field='',$condition='',$order='',$group='',$limit='')
    {
        if($field != '')
        $this->db->select($field);
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get($table)->row();
    }
    // Read data using username and password
	public function login($table,$condition) {
		$this->db->where($condition);
        $result = $this->db->get($table);
		if ($result->num_rows() == 1) {
			return $result->row();;
		} else {
			return false;
		}
	}
    //Get data in array
    public function GetDataArray($table,$field='',$condition='',$group='',$order='',$limit='',$result='')
    {
        if($field != '')
        $this->db->select($field);
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        if($result != '')
        {
            $return =  $this->db->get($table)->row_array();
        }else{
            $return =  $this->db->get($table)->result_array();
        }
        return $return;
    }
	//Get data in result
	public function GetDataAllRecords($table,$condition='',$order='',$group='',$limit='')
	{
		if($condition != '')
		$this->db->where($condition);
		if($order != '')
		$this->db->order_by($order);
		if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get($table)->result();
	}
    public function GetList($table,$condition='',$order='',$group='',$limit='')
    {
        $this->db->select('a.id, a.name, a.email, a.mobile, a.designation, a.createdby, b.designation as createdBY_designation, b.name as createdBY_name');
        $this->db->from('users a');
        $this->db->join('users b', 'a.createdby = b.id', 'left outer');
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get()->result();
    }
	//Save and update data
	public function SaveData($table,$data,$condition='')
    {
    	$DataArray = array();
        if(empty($condition))
        {
            $data['created']=date("Y-m-d H:i:s");
        }
        else 
        {
        	$data['modified']=date("Y-m-d H:i:s");
        }
        $table_fields = $this->db->list_fields($table);
        foreach($data as $field=>$value)
        {
            if(in_array($field,$table_fields))
            {
                $DataArray[$field]= $value;
            }
        }
       
        if($condition != '')
    	{
    		$this->db->where($condition);
    		$this->db->update($table,$DataArray);
    	}else{
    		$this->db->insert($table,$DataArray);
    	}
		return $this->db->insert_id();
    }
    //Delete Data from table
    public function DeleteData($table,$condition='',$limit='')
    {
        if($condition != '')
            $this->db->where($condition);
        if($limit != '')
            $this->db->limit($limit);
        $this->db->delete($table);
    }
    //Call procedure for dashboard
    public function Dashboard($user_id, $dashboard_stored_proc, $from_date = "", $to_date = ""){
        //$dashboard_stored_proc = "CALL GetDashboard(?)";
        $data = array('Id' => $user_id, 'FY_from' => $from_date, 'FY_to' => $to_date);
        $result = $this->db->query($dashboard_stored_proc, $data);
        $result->next_result();
        //end of new code
        return $result->result_array();
    }
    //Call procedure for gst
    public function GetGst($user_id, $dashboard_stored_proc, $from_date = "", $to_date = "", $status){
        //$dashboard_stored_proc = "CALL GetDashboard(?)";
        $data = array('Id' => $user_id, 'FY_from' => $from_date, 'FY_to' => $to_date, 'Status'=> $status);
        $result = $this->db->query($dashboard_stored_proc, $data);
        $result->next_result();
        //end of new code
        return $result->result();
    }
    public function Script($table,$condition='',$order='',$group='',$limit=''){
        $this->db->reconnect();
        $this->db->select('DATE_FORMAT(i.invoice_date, "%Y %b") AS y, SUM(i.Netammount) as Sale');
        $this->db->from($table);
        //$this->db->join('invoice_payments p', 'i.id = p.invoice_id', 'LEFT');
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get()->result();
    }
    public function Purchase_Script($table,$condition='',$order='',$group='',$limit=''){
        $this->db->reconnect();
        $this->db->select('DATE_FORMAT(pi.invoice_date, "%Y %b") AS y, SUM(pi.Netammount) as Purchase');
        $this->db->from($table);
        //$this->db->join('invoice_payments p', 'i.id = p.invoice_id', 'LEFT');
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get()->result();
    }
    public function Script2($table,$condition='',$order='',$group='',$limit=''){
        $this->db->reconnect();
        $this->db->select('DATE_FORMAT(`p`.`payment_date`, "%Y-%m") AS y , sum(`p`.`payed_amount`) as Received');
        $this->db->from($table);
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get()->result();
    }
    public function Purchase_Script2($table,$condition='',$order='',$group='',$limit=''){
        $this->db->reconnect();
        $this->db->select('DATE_FORMAT(`pp`.`payment_date`, "%Y-%m") AS y , sum(`pp`.`payed_amount`) as Payment');
        $this->db->from($table);
        if($condition != '')
        $this->db->where($condition);
        if($order != '')
        $this->db->order_by($order);
        if($limit != '')
        $this->db->limit($limit);
        if($group != '')
        $this->db->group_by($group);
        return $this->db->get()->result();
    }
    public function Customer_inv_balance($table){
        $feilds = array('U.id','CONCAT(`U`.`FirstName`," ", `U`.`LastName`) AS name', 'U.GST_No', 'sum(i.Netammount) as net_amount', "(SELECT sum(p.payed_amount) FROM `invoice_payments` `p` WHERE `p`.`payment_date` <= '2020-03-31' AND p.customer_id = U.id) as total_payment_received");
        $this->db->select($feilds);
        $this->db->from($table);
        $this->db->join('`customers` `U`', "`i`.`Customer_id` = `U`.`id`",'LEFT');
        $this->db->where("`i`.`Status` != 'Cancelled' AND `i`.`invoice_date` <= '2020-03-31'");
        $this->db->group_by('U.id');
        return $this->db->get()->result();
    }
    public function Customer_pay_balance($table){
        $feilds = array('U.id','CONCAT(`U`.`FirstName`," ", `U`.`LastName`) AS name', 'U.GST_No', ' sum(p.payed_amount) as total_payment_received');
        $this->db->select($feilds);
        $this->db->from($table);
        $this->db->join('`customers` `U`', " `U`.`id` = `p`.`customer_id`",'LEFT');
        $this->db->where("`p`.`payment_date` <= '2020-03-31'");
        $this->db->group_by('U.id');
        return $this->db->get()->result();
    }
}