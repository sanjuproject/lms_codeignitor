<?php
/**
 * 
 */
class Ss_aw_email_que_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_mail_que";
	}

	public function save_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_limited_records($limit){
		$this->db->limit($limit);
		return $this->db->get($this->table)->result();
	}

	public function remove_record($record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->delete($this->table);
	}
}