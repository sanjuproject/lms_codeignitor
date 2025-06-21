<?php
/**
 * 
 */
class Ss_aw_assesment_questions_asked_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assesment_questions_asked";
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
	
	public function fetch_record_byparam_bydesc($params)
	{
		$this->db->select($this->table.'.*,ss_aw_assesment_uploaded.ss_aw_assesment_format');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id ='.$this->table.'.ss_aw_assessment_id','left');
		foreach($params as $key=>$val)
		{
			$this->db->where($this->table.'.'.$key,$val);	
		}
		$this->db->order_by('ss_aw_question_asked_id','DESC');
		return $this->db->get($this->table)->result_array();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}
	
	public function update_record($update_array)
	 {
	 	$this->db->where('ss_aw_assessment_exam_code',$update_array['ss_aw_assessment_exam_code'])->where('ss_aw_assessment_question_id',$update_array['ss_aw_assessment_question_id'])
		->update($this->table,$update_array);
	 	return true;
	 }
	 
	 public function update_record_by_exam_code($update_array)
	 {
	 	$this->db->where('ss_aw_assessment_exam_code',$update_array['ss_aw_assessment_exam_code'])->update($this->table,$update_array);
	 	return true;
	 }
	 
	 public function fetch_record_byparam_question_details($params)
	{
		$this->db->select($this->table.'.*,ss_aw_assisment_diagnostic.ss_aw_format,ss_aw_assisment_diagnostic.ss_aw_seq_no,
		ss_aw_assisment_diagnostic.ss_aw_weight,ss_aw_assisment_diagnostic.ss_aw_question_format,ss_aw_assisment_diagnostic.ss_aw_question_preface_audio,
		ss_aw_assisment_diagnostic.ss_aw_question_preface,ss_aw_assisment_diagnostic.ss_aw_question,ss_aw_assisment_diagnostic.ss_aw_multiple_choice,
		ss_aw_assisment_diagnostic.ss_aw_verb_form,ss_aw_assisment_diagnostic.ss_aw_answers,ss_aw_assisment_diagnostic.ss_aw_answers_audio,
		ss_aw_assisment_diagnostic.ss_aw_rules_audio,ss_aw_assisment_diagnostic.ss_aw_rules');
		$this->db->join(' ss_aw_assisment_diagnostic',' ss_aw_assisment_diagnostic.ss_aw_id ='.$this->table.'.ss_aw_assessment_question_id','left');
		foreach($params as $key=>$val)
		{
			$this->db->where($this->table.'.'.$key,$val );	
		}
		return $this->db->get($this->table)->result_array();
	}

	public function checkrepeatexam($child_id, $exam_code, $assessment_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_assessment_exam_code !=', $exam_code);
		return $this->db->get($this->table)->num_rows();
	}

	public function totalnoofquestionasked($assessment_id, $child_id, $exam_code = ""){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		if (!empty($exam_code)) {
			$this->db->where('ss_aw_assessment_exam_code', $exam_code);
		}
		return $this->db->get($this->table)->num_rows();
	}

	public function totalnoofcorrectanswers($assessment_id, $child_id, $exam_code = ""){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		if (!empty($exam_code)) {
			$this->db->where('ss_aw_assessment_exam_code', $exam_code);
		}
		$this->db->where('ss_aw_answers_status', 1);
		return $this->db->get($this->table)->num_rows();	
	}

	public function fetch_all_in_level_question($exam_code, $level){
		$this->db->select('ss_aw_assesment_questions_asked.*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_assessment_exam_code', $exam_code);
		$this->db->where('ss_aw_asked_level', $level);
		return $this->db->get()->result();
	}

	public function fetch_all_nxt_level_question($exam_code, $level){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_assessment_exam_code', $exam_code);
		$this->db->where('ss_aw_asked_level !=', $level);
		return $this->db->get()->result();
	}

	public function get_exam_start_details($child_id, $assessment_id){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_question_asked_id','ASC');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function checkrepeatexambytopic($child_id, $exam_code, $assessment_topic){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_asked_category', $assessment_topic);
		$this->db->where('ss_aw_assessment_exam_code !=', $exam_code);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_last_exam_details($child_id, $type) //type 1 = winners program,2=champions program
	{
		$this->db->select($this->table.'.*,ss_aw_assesment_uploaded.ss_aw_assesment_format');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id ='.$this->table.'.ss_aw_assessment_id','left');
		if ($type == 1) {
			$query = "(ss_aw_assesment_questions_asked.ss_aw_asked_level = 'E' OR ss_aw_assesment_questions_asked.ss_aw_asked_level = 'C')";
		}
		elseif ($type == 2) {
			$query = "(ss_aw_assesment_questions_asked.ss_aw_asked_level = 'A')";
		}
		else{
			$query = "(ss_aw_assesment_questions_asked.ss_aw_asked_level = 'C' OR ss_aw_assesment_questions_asked.ss_aw_asked_level = 'A')";
		}
		$this->db->where($query);
		if (!empty($child_id)) {
			$this->db->where('ss_aw_assesment_questions_asked.ss_aw_child_id', $child_id);
		}
		$this->db->order_by('ss_aw_question_asked_id','DESC');
		return $this->db->get($this->table)->result_array();
	}

	public function get_current_exam_code($assessment_id, $child_id, $parent_id)
	{
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->order_by('ss_aw_question_asked_id','desc');
		return $this->db->get($this->table)->row();
	}

	public function check_exam_start($child_id, $lesson_id){
		$this->db->select('ss_aw_assesment_questions_asked.*,ss_aw_assesment_uploaded.ss_aw_assessment_id');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assesment_questions_asked.ss_aw_assessment_id');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_assesment_questions_asked.ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_assesment_questions_asked.ss_aw_question_asked_id','ASC');
		$this->db->limit(1);
		return $this->db->get()->result();
	}
	
}