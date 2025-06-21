<?php
/**
 * 
 */
class Ss_aw_institution_users_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_institution_users";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function check_duplicate($email, $institution_id = ""){
		$this->db->where('ss_aw_email', $email);
		if (!empty($institution_id)) {
			$this->db->where('ss_aw_institution_id !=', $institution_id);
		}
		return $this->db->get($this->table)->num_rows();
	}

	public function get_institutions_users($institution_id){
		$this->db->where('ss_aw_institution_id', $institution_id);
		return $this->db->get($this->table)->result();
	}

	public function update_record($data = array(), $record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
}