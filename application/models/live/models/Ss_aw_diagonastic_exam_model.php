<?php
/**
 * 
 */
class Ss_aw_diagonastic_exam_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_diagonastic_exam";
	}

	public function insert_record($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function fetch_record_byparam($params)
	{
		foreach($params as $key=>$val)
		{
			$this->db->where($key,$val );	
		}	
		$this->db->order_by('ss_aw_diagonastic_exam_id','ASC');
		return $this->db->get($this->table)->result_array();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_diagonastic_child_id', $id);
		$this->db->delete($this->table);
	}

	public function getFUTstudents(){
		$this->db->select('ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_childs.ss_aw_child_id as child_id');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
		$this->db->where('ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date >=','2021-12-14');
		return $this->db->get()->result();
	}

	public function getFUTstudentsreport($child_id){
		$query = "SELECT ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_level as question_level, ss_aw_assisment_diagnostic.ss_aw_question_preface as question_preface,ss_aw_assisment_diagnostic.ss_aw_question as question, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answers as student_answer, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_right_answers as correct_answer FROM ss_aw_diagonastic_exam_log INNER JOIN ss_aw_diagonastic_exam ON ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_code=ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_exam_code INNER JOIN ss_aw_childs ON ss_aw_childs.ss_aw_child_id=ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id INNER JOIN ss_aw_assisment_diagnostic ON ss_aw_assisment_diagnostic.ss_aw_id=ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id WHERE ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = $child_id AND ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status=2";
		return $this->db->query($query)->result();

	}

	public function get_exam_details_by_child($child_id){
		$this->db->where('ss_aw_diagonastic_child_id', $child_id);
		$this->db->order_by('ss_aw_diagonastic_exam_id','DESC');
		$this->db->limit(1);
		return $this->db->get($this->table)->row();
	}

	public function get_diagnostic_exam_details($child_id){
		$query = "SELECT ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_level as question_level, ss_aw_assisment_diagnostic.ss_aw_question_preface as question_preface,ss_aw_assisment_diagnostic.ss_aw_question as question, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answers as student_answer, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_right_answers as correct_answer, ss_aw_assisment_diagnostic.ss_aw_category as topic_name, ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status as answer_status FROM ss_aw_diagonastic_exam_log INNER JOIN ss_aw_diagonastic_exam ON ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_code=ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_exam_code INNER JOIN ss_aw_childs ON ss_aw_childs.ss_aw_child_id=ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id INNER JOIN ss_aw_assisment_diagnostic ON ss_aw_assisment_diagnostic.ss_aw_id=ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id WHERE ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = $child_id";
		return $this->db->query($query)->result();
	}

	public function get_registration_by_date($search_date){
		$this->db->select('distinct(ss_aw_diagonastic_child_id)');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
		$this->db->where('ss_aw_childs.ss_aw_child_status', 1);
		$this->db->where('ss_aw_childs.ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date)', $search_date);
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id) = 0');
		return $this->db->get()->num_rows();
	}

	public function get_registration_by_date_range($search_date, $current_date){
		$this->db->select('distinct(ss_aw_diagonastic_child_id)');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
		$this->db->where('ss_aw_childs.ss_aw_child_status', 1);
		$this->db->where('ss_aw_childs.ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date) >', $search_date);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date) <=', $current_date);
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id) = 0');
		return $this->db->get()->num_rows();
	}

	public function get_registration_before_last_seven_days_of_current_date($search_date){
		$this->db->select('distinct(ss_aw_diagonastic_child_id)');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
		$this->db->where('ss_aw_childs.ss_aw_child_status', 1);
		$this->db->where('ss_aw_childs.ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date) <', $search_date);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date) >=', '2022-08-01');
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id) = 0');
		return $this->db->get()->num_rows();
	}

	public function get_daily_diagnostic_non_course_purchase_details($search_date){
		$this->db->select('distinct(ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id) as ss_aw_child_id, ss_aw_childs.ss_aw_child_nick_name');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
		$this->db->where('ss_aw_childs.ss_aw_child_status', 1);
		$this->db->where('ss_aw_childs.ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date) <=', $search_date);
		$this->db->where('DATE(ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date) >=', '2022-08-01');
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id) = 0');
		return $this->db->get()->result();
	}

	public function get_total_childs_up_to_date($current_date){
		$this->db->select('distinct(ss_aw_diagonastic_child_id)');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
		$this->db->where('ss_aw_childs.ss_aw_child_status', 1);
		$this->db->where('ss_aw_childs.ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date) <=', $current_date);
		$this->db->where('DATE(ss_aw_diagonastic_exam_date) >=', '2022-08-01');
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id) = 0');
		return $this->db->get()->num_rows();
	}
	
}