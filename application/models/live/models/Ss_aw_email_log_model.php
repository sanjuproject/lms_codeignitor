<?php
/**
 * 
 */
class Ss_aw_email_log_model extends CI_Model
{
	
	function __construct()
	{
		$this->table = "ss_aw_email_log";
	}

	public function save_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
}