<?php
/**
 * 
 */
class Ss_aw_readalong_restriction_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalong_restriction";
	}

	public function get_restricted_time($level){
		$this->db->where('course_level', $level);
		return $this->db->get($this->table)->result();
	}

	public function update_restrict_time($time = 0){
		$time_in_hours = $time * 60;
		$this->db->set('restricted_time', $time_in_hours);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}
}