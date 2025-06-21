<?php
/**
 * 
 */
class Ss_aw_diagnostic_quintile_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_diagnostic_quintile";
	}

	public function save_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function remove_quintile(){
		$this->db->truncate($this->table);
	}

	public function getdatabyvalue($value, $level){
		$query ="'".$value."' BETWEEN `low_value` AND `high_value`";
		$this->db->where('level', $level);
		$this->db->where($query);
		return $this->db->get($this->table)->result();
	}
}