<?php
/**
 * 
 */
class Ss_aw_puzzle_notify_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_puzzle_notify";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_records(){
		$this->db->select('DISTINCT(email)');
		$this->db->from($this->table);
		return $this->db->get()->result();
	}
}