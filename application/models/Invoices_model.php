<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoices_model extends CI_Model
{
    
    var $column_order = array(null, 'c.FirstName', 'c.LastName', 'u.username', 'i.invoice_no', 'i.invoice_date', 'i.Netammount', 'i.Balance_Amount', 'i.Status'); //set column field database for datatable orderable
    var $column_search = array('c.FirstName', 'c.LastName', 'u.username', 'i.invoice_no', 'i.invoice_date', 'i.Netammount', 'i.Balance_Amount', 'i.Status'); //set column field database for datatable searchable 
    var $order = array('i.id' => 'DESC');
    
    function __construct()
    {
        parent::__construct();
    }
    
    private function _get_datatables_query($table, $condition)
    {
        $feilds = array('i.id', 'c.FirstName', 'c.LastName', 'u.username', 'i.invoice_no', 'i.invoice_date', 'i.Netammount', 'i.Balance_Amount', 'i.Status','i.waybill_file');
        $this->db->select($feilds);
        $this->db->from('invoice i');
        $this->db->join('customers c', 'i.Customer_id = c.id');
        $this->db->join('users u', 'i.user_id= u.id');
        $this->db->group_by('i.id');
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
        if (isset($_POST['order'])) // here order processing
            {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables($table, $condition = '')
    {
        if (!empty($condition))
            $this->db->where($condition);
        $this->_get_datatables_query($table, $condition);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function count_all($table, $condition = '')
    {
        if (!empty($condition))
            $this->db->where($condition);
        $this->_get_datatables_query($table, $condition);
        return $this->db->count_all_results();
    }
    
    
    function count_filtered($table, $condition = '')
    {
        if (!empty($condition))
            $this->db->where($condition);
        $this->_get_datatables_query($table, $condition);
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

    public function GetInvcData($table, $condition = '', $order = '', $group = '', $limit = '')
    {
        $feilds = array('i.id', 'c.FirstName', 'c.LastName','c.Address','c.City','c.State','c.Country', 'c.Zip','c.GST_No','c.Email','c.Mobile', 'u.username', 'i.State_code','i.invoice_no', 'i.invoice_date','i.Lorry_no','i.waybill','i.Place','i.Gross_amount','i.Additional_amount','i.CGST_percentage','i.SGST_percentage','i.IGST_percentage','i.CESS_value','i.TCS_percentage','i.CGST','i.SGST','i.IGST','i.CESS','i.TCS', 'i.Roundoff','i.Netammount', 'i.Balance_Amount','i.Timestamp', 'i.Status','i.user_id','i.waybill_file','i.Qr_code', 'i.company_code');
        $this->db->select($feilds);
        $this->db->from($table);
        $this->db->join('customers c', 'i.Customer_id = c.id');
        $this->db->join('users u', 'i.user_id= u.id');
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        if ($group != '')
            $this->db->group_by($group);
        return $this->db->get()->row();
    }

    public function GetInvcDetail($table, $condition = '', $order = '', $group = '', $limit = '')
    {
        $feilds = array('i.id', 'p.Name','p.Unit', 'i.Hsn_code','i.Qty', 'i.Price','i.Amount');
        $this->db->select($feilds);
        $this->db->from($table);
        $this->db->join('products p', 'i.Product_id= p.id');
        if ($condition != '')
            $this->db->where($condition);
        if ($order != '')
            $this->db->order_by($order);
        if ($limit != '')
            $this->db->limit($limit);
        if ($group != '')
            $this->db->group_by($group);
        return $this->db->get()->result();
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