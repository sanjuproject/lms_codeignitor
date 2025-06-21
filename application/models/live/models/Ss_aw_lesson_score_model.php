<?php
/**
 * 
 */
class Ss_aw_lesson_score_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_lesson_score";
	}

	public function store_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function check_data($child_id, $lesson_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('lesson_id', $lesson_id);
		return $this->db->get($this->table)->result();
	}

	public function update_data($data){
		$this->db->where('child_id', $data['child_id']);
		$this->db->where('lesson_id', $data['lesson_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function checklessoncompletebylevel($level, $child_id){
		$this->db->distinct('child_id');
		$this->db->where('level', $level);
		$this->db->where('child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function getlessonscoreofpreviouscourse($level, $child_id){
		$this->db->where('level', $level);
		$this->db->where('child_id', $child_id);
		return $this->db->get($this->table)->result();
	}
}