<?php

/**
 * 
 */
class Ss_aw_assesment_multiple_question_answer_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assesment_multiple_question_answer";
	}

	public function store_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update_record($data, $record_id){
		$this->db->where('ss_aw_id', $record_id);
		$response = $this->db->update($this->table, $data);
		if ($response) {
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_data($data){
		$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
		$this->db->where('ss_aw_assessment_id', $data['ss_aw_assessment_id']);
		$this->db->where('ss_aw_assessment_exam_code', $data['ss_aw_assessment_exam_code']);
		$this->db->where('ss_aw_question', $data['ss_aw_question']);
		$this->db->where('ss_aw_question', $data['ss_aw_question']);
		$check = $this->db->get($this->table)->num_rows();
		if ($check > 0) {
			$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
			$this->db->where('ss_aw_assessment_id', $data['ss_aw_assessment_id']);
			$this->db->where('ss_aw_assessment_exam_code', $data['ss_aw_assessment_exam_code']);
			$this->db->where('ss_aw_question', $data['ss_aw_question']);
			$this->db->where('ss_aw_question', $data['ss_aw_question']);
			return $this->db->get($this->table)->result();
		}
		else
		{
			return $check;
		}
	}

	public function totalnoofquestionasked($assessment_id, $child_id){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function totalnoofcorrectanswers($assessment_id, $child_id){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_answers_status', 1);
		return $this->db->get($this->table)->num_rows();	
	}

	public function getrecordbytopic($topic_id, $lesson_id, $child_id){
		$this->db->select('ss_aw_assesment_multiple_question_answer.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assisment_diagnostic','ss_aw_assisment_diagnostic.ss_aw_question = ss_aw_assesment_multiple_question_answer.ss_aw_question');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_assisment_diagnostic.ss_aw_question_topic_id', $topic_id);
		$this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
		return $this->db->get()->result();
	}

	public function getdiagnosticexamdetails($child_id, $exam_code){
		$this->db->select('ss_aw_assesment_multiple_question_answer.ss_aw_answer as given_answer,ss_aw_assesment_multiple_question_answer.ss_aw_right_answers as answers,ss_aw_assisment_diagnostic.ss_aw_question_preface as question_preface,ss_aw_assesment_multiple_question_answer.ss_aw_question as question,ss_aw_assesment_multiple_question_answer.ss_aw_level as question_level,ss_aw_assesment_multiple_question_answer.ss_aw_answers_status as answer_status,ss_aw_assisment_diagnostic.ss_aw_weight as weight');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assisment_diagnostic','ss_aw_assisment_diagnostic.ss_aw_id = ss_aw_assesment_multiple_question_answer.ss_aw_question_id');
		$this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_assessment_exam_code', $exam_code);
		$this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
		return $this->db->get()->result();
	}

	public function getassessmentskipno($child_id, $level, $assessment_id){
        $this->db->where('ss_aw_answers_status', 3);
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->where('ss_aw_assessment_id', $assessment_id);
        return $this->db->get($this->table)->num_rows();
    }

    public function getreviewassessmentskipno($child_id, $level_type, $assessment_id){
        $this->db->where('ss_aw_answers_status', 3);
        $this->db->where('ss_aw_level !=', $level_type);
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_assessment_id', $assessment_id);
        return $this->db->get($this->table)->num_rows(); 
    }
}