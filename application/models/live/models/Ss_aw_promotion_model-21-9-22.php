<?php
/**
 * 
 */
class Ss_aw_promotion_model extends CI_Model
{
	
	function __construct()
	{
		$this->table = "ss_aw_promotion";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update_record($data){
		$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
		$this->db->where('ss_aw_current_level', $data['ss_aw_current_level']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function get_promotion_detail($child_id, $previous_level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_current_level', $previous_level);
		$this->db->where('status', 1);
		return $this->db->get($this->table)->result();
	}

	public function removedatabychillevel($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_current_level', $level);
		$this->db->delete($this->table);
	}

	public function checkpromotionlapsation($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_current_level', $level);
		return $this->db->get($this->table)->num_rows();
	}

	public function reject_promotion($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_current_level', $level);
		$this->db->set('status', 2);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function check_rejection($child_id, $course_id){
		if ($course_id == 1) {
			$level = 'E';
		}
		elseif ($course_id == 2) {
			$level = "C";
		}
		else{
			$level = "A";
		}
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_current_level', $level);
		return $this->db->get($this->table)->result();
	}
}