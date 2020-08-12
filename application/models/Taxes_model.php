<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Taxes_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
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
            $data['modified'] = date("Y-m-d H:i:s");
        } else {
           $data['created'] = date("Y-m-d H:i:s"); 
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