<?php
/**
 * 
 */
class Ss_aw_schools_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_schools";
	}

	public function check_duplicate($scl_name){
		$this->db->where('LOWER(ss_aw_name)', strtolower($scl_name));
		return $this->db->get($this->table)->num_rows();
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_schools(){
		$this->db->where('status', 1);
		return $this->db->get($this->table)->result();
	}

	public function searched_scl_list($search_data){
		$this->db->like('ss_aw_name', $search_data, 'after');
		return $this->db->get($this->table)->result();
	}
}