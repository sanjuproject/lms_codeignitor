<?php
/**
 * 
 */
class Ss_aw_unsubscribe_emails extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_unsubscribe_emails";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function check_duplicate($email){
		$this->db->where('ss_aw_email', $email);
		return $this->db->get($this->table)->num_rows();
	}

	public function remove_record($email){
		$this->db->where('ss_aw_email', $email);
		$this->db->delete($this->table);
	}
}