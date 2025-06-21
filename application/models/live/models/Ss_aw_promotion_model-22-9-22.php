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

	public function get_ptd_promotion_num($current_date, $lesson_num){
		$this->db->where('DATE(created_at)', $current_date);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_ytd_promotion_num($current_year, $lesson_num){
		$this->db->where('YEAR(created_at)', $current_year);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_promotion_num_by_month($month, $lesson_num){
		$this->db->where('MONTH(created_at)', $month);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_ptd_promotion_num_by_status($current_date, $lesson_num, $status){
		$this->db->where('DATE(created_at)', $current_date);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		$this->db->where('status', $status);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_ytd_promotion_num_by_status($current_year, $lesson_num, $status){
		$this->db->where('YEAR(created_at)', $current_year);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		$this->db->where('status', $status);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_promotion_num_by_status_by_month($month, $lesson_num, $status){
		$this->db->where('MONTH(created_at)', $month);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		$this->db->where('status', $status);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_ptd_expired_promotion_num_by_status($current_date, $lesson_num){
		$this->db->where('DATE(created_at)', $current_date);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		$this->db->where('(select count(*) from ss_aw_child_last_lesson where ss_aw_child_last_lesson.ss_aw_child_id = ss_aw_promotion.ss_aw_child_id) > '.$lesson_num);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_ytd_expired_promotion_num_by_status($current_year, $lesson_num){
		$this->db->where('YEAR(created_at)', $current_year);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		$this->db->where('(select count(*) from ss_aw_child_last_lesson where ss_aw_child_last_lesson.ss_aw_child_id = ss_aw_promotion.ss_aw_child_id) > '.$lesson_num);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_expired_promotion_num_by_status_by_month($month, $lesson_num){
		$this->db->where('MONTH(created_at)', $month);
		$this->db->where('ss_aw_lesson_num', $lesson_num);
		$this->db->where('(select count(*) from ss_aw_child_last_lesson where ss_aw_child_last_lesson.ss_aw_child_id = ss_aw_promotion.ss_aw_child_id) > '.$lesson_num);
		return $this->db->get($this->table)->num_rows();
	}


}