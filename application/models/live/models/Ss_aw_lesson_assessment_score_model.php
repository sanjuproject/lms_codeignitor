<?php
/**
 * 
 */
class Ss_aw_lesson_assessment_score_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_lesson_assessment_score";
	}

	public function getallbyindividualtopic($level, $topic, $child_id = array()){
		$this->db->select('ss_aw_combine_correct,ss_aw_lesson_topic');
		$this->db->from($this->table);
		$this->db->where('ss_aw_lesson_topic', $topic);
		$this->db->where('ss_aw_course_level', $level);
		$this->db->where_in('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_combine_correct','ASC');
		return $this->db->get()->result();
	}

	public function gettotalcombinecorrect($level){
		$this->db->distinct('ss_aw_child_id');
		$this->db->select('ss_aw_combine_correct');
		$this->db->from('ss_aw_lesson_assessment_total_score');
		$this->db->where('ss_aw_course_level', $level);
		$this->db->order_by('ss_aw_combine_correct','ASC');
		return $this->db->get()->result();
	}

	public function gettotaldiagnosticcorrect($level){
		$this->db->distinct('ss_aw_child_id');
		$this->db->select('ss_aw_diagnostic_correct_percentage');
		$this->db->from('ss_aw_diagnostic_review_score');
		$this->db->where('ss_aw_level', $level);
		$this->db->order_by('ss_aw_diagnostic_correct_percentage','ASC');
		return $this->db->get()->result();
	}

	public function gettotalassessmentcorrect($level){
		$this->db->distinct('ss_aw_child_id');
		$this->db->select('ss_aw_review_percentage');
		$this->db->from('ss_aw_diagnostic_review_score');
		$this->db->where('ss_aw_level', $level);
		$this->db->order_by('ss_aw_diagnostic_correct_percentage','ASC');
		return $this->db->get()->result();
	}

	public function gettotalformattwolessonassessmentcorrect($level){
		$this->db->distinct('ss_aw_child_id');
		$this->db->select('ss_aw_correct_percentage');
		$this->db->from('ss_aw_format_two_lesson_assessment_total_score');
		$this->db->where('ss_aw_level', $level);
		$this->db->order_by('ss_aw_correct_percentage','ASC');
		return $this->db->get()->result();
	}

	public function save_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_data($child_id, $level_type){
		$this->db->select('SUM(ss_aw_lesson_quiz_correct) as lesson_correct, SUM(ss_aw_lesson_quiz_asked) as lesson_asked, SUM(ss_aw_assessment_in_level_asked) as assessment_in_level_asked,SUM(ss_aw_assessment_in_level_correct) as assessment_in_level_correct,SUM(ss_aw_assessment_in_level_actual_score) as assessment_in_level_actual_score,SUM(ss_aw_assessment_in_level_potential_score) as assessment_in_level_potential_score,SUM(	ss_aw_assessment_next_level_correct) as assessment_next_level_correct,SUM(ss_aw_assessment_next_level_asked) as assessment_next_level_asked,SUM(ss_aw_assessment_next_level_actual_score) as assessment_next_level_actual_score,SUM(ss_aw_assessment_next_level_potential_score) as assessment_next_level_potential_score,SUM(ss_aw_review_correct) as review_correct,SUM(ss_aw_review_asked) as review_asked');
		$this->db->from($this->table);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_course_level', $level_type);
		return $this->db->get()->result();
	}

	public function save_total($data){
		$this->db->insert('ss_aw_lesson_assessment_total_score', $data);
		return $this->db->insert_id();
	}

	public function save_final_total($data){
		$this->db->insert('ss_aw_diagnostic_review_score', $data);
		return $this->db->insert_id();
	}

	public function remove_child_data($child_id){
    	$this->db->where('ss_aw_child_id', $child_id);
    	$this->db->delete($this->table);
    }
}