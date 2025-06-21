<?php
/**
 * 
 */
class Diagnostic_child_login_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "diagnostic_child_login_log";
	}

	public function check_data($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function store_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_data_by_child($id){
		$this->db->where('ss_aw_child_id', $id);
		return $this->db->get($this->table)->result();
	}
}