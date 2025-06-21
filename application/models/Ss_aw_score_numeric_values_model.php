<?php
/**
 * 
 */
class Ss_aw_score_numeric_values_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_score_numeric_values";
	}

	public function update_record($data){
		$this->db->where('id', $data['id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function fetch_data(){
		return $this->db->get($this->table)->result();
	}
}