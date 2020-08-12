<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suppliers_model extends CI_Model
{
    
    var $column_order = array(null, 'U.FirstName', 'U.LastName', 'U.GST_No', 'U.Email', 'U.Mobile','U.Status'); //set column field database for datatable orderable
    var $column_search = array('U.FirstName', 'U.LastName', 'U.GST_No', 'U.Email', 'U.Mobile','U.Status'); //set column field database for datatable searchable 
    var $order = array('U.id' => 'DESC');
    
    function __construct()
    {
        parent::__construct();
    }
    
    private function _get_datatables_query($table, $condition)
    {
        $feilds = array('U.id','U.FirstName', 'U.LastName', 'U.GST_No', 'U.Email', 'U.Mobile','U.Status','sum(i.Balance_Amount) as balance_amount');
        $this->db->select($feilds);
        $this->db->from($table);
        $this->db->join('purchase_invoice i', 'U.id = i.Suppliers_id','LEFT');
        $this->db->group_by('U.id');
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