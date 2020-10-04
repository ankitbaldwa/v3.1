<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mst_states_model extends CI_Model
{

    public $table = 'mst_states';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() 
    {
        $this->datatables->select('s.id,c.country_name,s.state_name,s.state_code,s.status');
        $this->datatables->from('mst_states s');
        //add this line for join
        $this->datatables->join('mst_countries c', 's.mst_country_id = c.id');
        $this->datatables->edit_column('status',anchor(site_url('Mst_states/status/$1/$2'),'<label class="label-success label">$1</label>','class="status"','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'),'status,id');

       $this->datatables->add_column('action', anchor(site_url('states-update/$1'),'<button title="Edit" class="btn btn-info btn-circle btn-xs"><i class="fa fa-edit fa-fw"></i></button>',"title='Update State'"), 'id');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('mst_country_id', $q);
	$this->db->or_like('state_name', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('created', $q);
	$this->db->or_like('modified', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('mst_country_id', $q);
	$this->db->or_like('state_name', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('created', $q);
	$this->db->or_like('modified', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Mst_states_model.php */
/* Location: ./application/models/Mst_states_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-06-24 12:18:49 */
/* http://harviacode.com */