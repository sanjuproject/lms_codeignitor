<?php
/**
 * 
 */
class Ss_aw_assessment_score_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assessment_score";
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

	public function gettotalquestionanswercount($child_id, $lesson_id){
		$this->db->select('ss_aw_assessment_score.total_question, ss_aw_assessment_score.wright_answers, ss_aw_assessment_score.exam_code,ss_aw_assesment_uploaded.ss_aw_assesment_format,ss_aw_assessment_score.assessment_id');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_score.assessment_id');
		/*$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_assesment_uploaded.ss_aw_lesson_id');*/
		$this->db->where('ss_aw_assessment_score.child_id', $child_id);
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
		$this->db->order_by('ss_aw_assessment_score.id','asc');
		$this->db->limit(1);
		return $this->db->get()->result();
	}

	public function getcountbychildcourse($child_id, $level){
		$this->db->where('level', $level);
		$this->db->where('child_id', $child_id);
		$this->db->group_by('assessment_id');
		return $this->db->get('ss_aw_assessment_score')->result();
	}

	public function checkassessmentcompletebylevel($level, $child_id){
		$this->db->distinct('assessment_id');
		$this->db->where('level', $level);
		$this->db->where('child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function getassessmentofpreviouscourse($level, $child_id){
		$this->db->where('level', $level);
		$this->db->where('child_id', $child_id);
		return $this->db->get($this->table)->result();
	}

	public function get_score_details_by_assessment_child($child_id, $assessment_id){
		$this->db->where('assessment_id', $assessment_id);
		$this->db->where('child_id', $child_id);
		$this->db->order_by('id','asc');
		return $this->db->get($this->table)->result();
	}

	public function get_score_details_by_assessment_topic_child($child_id, $assessment_topic){
		$this->db->where('assessment_topic', $assessment_topic);
		$this->db->where('child_id', $child_id);
		$this->db->order_by('id','desc');
		return $this->db->get($this->table)->result();
	}
}