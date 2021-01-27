<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ledgers_model extends CI_Model
{
    
    var $column_order = array('l.id', 'l.transaction_date', 'l.dr_amount', 'l.cr_amount', 'l.balance_amount', 'i.invoice_no', "CONCAT(c.FirstName,' ',c.LastName) as name", "p.receipt_no", "p.payment_type"); //set column field database for datatable orderable
    var $column_search = array('l.id', 'l.transaction_date', 'l.dr_amount', 'l.cr_amount', 'l.balance_amount', 'i.invoice_no', "CONCAT(c.FirstName,' ',c.LastName) as name", "p.receipt_no", "p.payment_type"); //set column field database for datatable searchable 
    var $order = array(array('l.transaction_date' => 'DESC'), array('p.id' => 'ASC'));
    
    function __construct()
    {
        parent::__construct();
    }
    
    /** SELECT id, customer_id, transaction_date, dr_amount, cr_amount, COALESCE(((SELECT SUM(b.dr_amount) FROM ledger b WHERE b.transaction_date <= l.transaction_date AND l.customer_id = '4') - (SELECT SUM(b.cr_amount) FROM ledger b WHERE b.transaction_date <= l.transaction_date AND l.customer_id = '4')), 0) as balance, narration FROM ledger l WHERE l.customer_id = '4' ORDER BY l.transaction_date DESC */
    private function _get_datatables_query($table, $condition, $customer_id)
    {
        $feilds = array('l.id', 'l.transaction_date', 'l.dr_amount', 'l.cr_amount', 'COALESCE(((SELECT SUM(b.dr_amount) FROM ledger b WHERE b.transaction_date <= l.transaction_date AND b.customer_id = '.$customer_id.') - (SELECT SUM(b.cr_amount) FROM ledger b WHERE b.transaction_date <= l.transaction_date AND b.customer_id = '.$customer_id.')), 0) as balance', 'l.balance_amount', 'i.invoice_no', "CONCAT(c.FirstName,' ',c.LastName) as name", "p.receipt_no", "p.payment_type");
        $this->db->select($feilds);
        $this->db->from($table);
        $this->db->join('invoice i', "i.id = l.invoice_id",'LEFT');
        $this->db->join('customers c', "c.id = l.customer_id",'INNER');
        $this->db->join('invoice_payments p', "p.id = l.payment_id",'LEFT');
        //$this->db->group_by('U.id');
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order[0]), $order[0][key($order[0])]);
            $this->db->order_by(key($order[1]), $order[1][key($order[1])]);
        }
    }
    
    function get_datatables($table, $condition = '', $customer_id)
    {
        if (!empty($condition))
            $this->db->where($condition);
        $this->_get_datatables_query($table, $condition, $customer_id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function count_all($table, $condition = '', $customer_id)
    {
        if (!empty($condition))
            $this->db->where($condition);
        $this->_get_datatables_query($table, $condition, $customer_id);
        return $this->db->count_all_results();
    }
    
    
    function count_filtered($table, $condition = '', $customer_id)
    {
        if (!empty($condition))
            $this->db->where($condition);
        $this->_get_datatables_query($table, $condition, $customer_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function GetFieldData($table, $field = '', $condition = '', $group = '', $order = '', $limit = '', $result = '')
    {
        if ($field != '')
            $this->db->select($field);
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        if ($group != '')
            $this->db->group_by($group);
        if ($result != '') {
            $return = $this->db->get($table)->row();
        } else {
            $return = $this->db->get($table)->result();
        }
        return $return;
    }
    public function GetDataAll($table, $condition = '', $order = '', $group = '', $limit = '')
    {
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        if ($group != '')
            $this->db->group_by($group);
        return $this->db->get($table)->result();
    }
    
    public function GetData($table, $condition = '', $order = '', $group = '', $limit = '')
    {
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        if ($group != '')
            $this->db->group_by($group);
        return $this->db->get($table)->row();
    }
    
    
    public function SaveData($table, $data, $condition = '')
    {
        $DataArray = array();
        if (!empty($condition)) {
            $data['Modified'] = date("Y-m-d H:i:s");
        } else {
           $data['Created'] = date("Y-m-d H:i:s"); 
        }
        $table_fields = $this->db->list_fields($table);
        foreach ($data as $field => $value) {
            if (in_array($field, $table_fields)) {
                $DataArray[$field] = $value;
            }
        }
        
        if ($condition != '') {
            $this->db->where($condition);
            return $this->db->update($table, $DataArray);
            
        } else {
            $this->db->insert($table, $DataArray);
            
        }
        return $this->db->insert_id();
    }
    
    public function DeleteData($table, $condition = '', $limit = '')
    {
        if ($condition != '')
            $this->db->where($condition);
        if ($limit != '')
            $this->db->limit($limit);
        $this->db->delete($table);
        return true;
    }
}
?>