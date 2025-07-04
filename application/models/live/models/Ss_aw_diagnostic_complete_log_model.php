<?php
/**
 * 
 */
class Ss_aw_diagnostic_complete_log_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_diagnostic_complete_log";
	}

	public function add_logs($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function institution_log($program_type, $institution_id){
		$this->db->where('ss_aw_program_type', $program_type);
		$this->db->where('ss_aw_institution_id', $institution_id);
		return $this->db->get($this->table)->row();
	}

	public function removeprogramlog($program_type, $institution_id){
		$this->db->where('ss_aw_program_type', $program_type);
		$this->db->where('ss_aw_institution_id', $institution_id);
		$this->db->delete($this->table);
	}
}