<?php
/**
 * 
 */
class Ss_aw_assessment_exam_log_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assessment_exam_log";
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
		return $this->db->get($this->table)->result_array();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_log_child_id', $id);
		$this->db->delete($this->table);
	}

	public function totalnoofcorrectanswers($exam_code, $child_id){
		$this->db->where('ss_aw_log_exam_code', $exam_code);
		$this->db->where('ss_aw_log_child_id', $child_id);
		$this->db->where('ss_aw_log_answer_status', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function checkstartedafterorbeforelesson($child_id, $compare_date){
		$this->db->where('ss_aw_log_child_id', $child_id);
		$this->db->where('ss_aw_log_created_date >', $compare_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function getdiagnosticexamdetails($child_id, $exam_code){
		$this->db->select('ss_aw_assessment_exam_log.ss_aw_log_answers as given_answer,ss_aw_assessment_exam_log.ss_aw_log_answer_status as answer_status,ss_aw_assisment_diagnostic.ss_aw_question_preface as question_preface,ss_aw_assisment_diagnostic.ss_aw_question as question,ss_aw_assisment_diagnostic.ss_aw_answers as answers,ss_aw_assessment_exam_log.ss_aw_log_level as question_level,ss_aw_assisment_diagnostic.ss_aw_weight as weight');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assisment_diagnostic','ss_aw_assisment_diagnostic.ss_aw_id = ss_aw_assessment_exam_log.ss_aw_log_question_id');
		$this->db->where('ss_aw_assessment_exam_log.ss_aw_log_exam_code', $exam_code);
		$this->db->where('ss_aw_assessment_exam_log.ss_aw_log_child_id', $child_id);
		$this->db->where('ss_aw_assessment_exam_log.ss_aw_log_answer_status !=', 3);
		return $this->db->get()->result();
	}

	public function get_total_time_elapsed($exam_code, $child_id){
		$this->db->where('ss_aw_log_child_id', $child_id);
		$this->db->where('ss_aw_log_exam_code', $exam_code);
		$count = $this->db->get($this->table)->num_rows();
		if ($count > 0) {
			$this->db->select('SUM(ss_aw_seconds_to_answer_question) as total_time_taken');
			$this->db->from($this->table);
			$this->db->where('ss_aw_log_child_id', $child_id);
			$this->db->where('ss_aw_log_exam_code', $exam_code);
			$result = $this->db->get()->result();
			return round($result[0]->total_time_taken);
		}
		else{
			return 0;
		}
	}

	public function getassessmentskipno($child_id, $level, $topic_id){
        $this->db->where('ss_aw_log_answer_status', 3);
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_level', $level);
        $this->db->where('ss_aw_log_topic_id', $topic_id);
        return $this->db->get($this->table)->num_rows();
    }

    public function getreviewassessmentskipno($child_id, $level_type, $topic_id){
        $this->db->where('ss_aw_log_answer_status', 3);
        $this->db->where('ss_aw_log_level !=', $level_type);
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_topic_id', $topic_id);
        return $this->db->get($this->table)->num_rows(); 
    }

    public function remove_child_data($child_id){
    	$this->db->where('ss_aw_log_child_id', $child_id);
    	$this->db->delete($this->table);
    }

    public function update_record($data, $where) {
        $query = $this->db->update($this->table, $data, $where);
        return $query ? true : false;
    }

    public function get_exam_question_count_according_subtopic($exam_code, $question_topic_id, $sub_category, $skip = false, $question_id = '') {
        if ($skip == true) {
            $this->db->where('ss_aw_log_answer_status<>', 3);
        }
        $this->db->where("ss_aw_log_exam_code", $exam_code);
        if ($question_id != '') {
            $this->db->where("ss_aw_log_question_id", $question_id);
        }
        $this->db->where("ss_aw_log_topic_id", $question_topic_id);
        $this->db->where("ss_aw_log_subcategory", $sub_category);
        return $this->db->get($this->table)->num_rows();
    }
	
}