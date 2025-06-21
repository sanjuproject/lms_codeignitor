<?php
/**
 * 
 */
class Ss_aw_update_profile_log_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_update_profile_log";
	}

	public function check_duplicate($data = array()){
		$this->db->where('ss_aw_email', $data['ss_aw_email']);
		$this->db->where('ss_aw_type', $data['ss_aw_type']);
		return $this->db->get($this->table)->num_rows();
	}

	public function insert_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_data($limit){
		$this->db->limit($limit);
		return $this->db->get($this->table)->result();
	}

	public function remove_record($record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->delete($this->table);
	}
}