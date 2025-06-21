<?php
/**
 * 
 */
class Ss_aw_assisment_diagnostic_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assisment_diagnostic";
	}
	/* This function for diagonostic questions */
	public function fetch_question_bycategory($category,$child_level)
	{
		return $this->db->where('ss_aw_level',$child_level)->where('ss_aw_category',$category)->where('ss_aw_quiz_type',1)->where('ss_aw_deleted', 1)
		->order_by('rand()')->limit(1)->get($this->table)->result_array();
	}

	public function checkbycategory($category, $child_level){
		return $this->db->where('ss_aw_level',$child_level)->where('ss_aw_category',$category)->where('ss_aw_quiz_type',1)->where('ss_aw_deleted', 1)->get($this->table)->num_rows();
	}
	
	public function fetch_question_byparam($searchary)
	{
		return $this->db->where('ss_aw_level',$child_level)->where('ss_aw_category',$category)->where('ss_aw_quiz_type',1)->where('ss_aw_deleted', 1)
		->order_by('rand()')->limit(1)->get($this->table)->result_array();
	}
	
	public function fetch_subcategory_byparam_groupby($searchary)
	{
		if(!empty($searchary))
		{
			foreach($searchary as $key=>$value)
			{
				$this->db->where('`'.$key.'`',$value);
			}
		}
		$this->db->group_by('ss_aw_sub_category');
		$this->db->where('ss_aw_deleted', 1);
		$this->db->order_by('ss_aw_id','ASC');
		return $this->db->get($this->table)->result_array();
	}
	
	public function fetch_subcategory_byparam($searchary)
	{
		if(!empty($searchary))
		{
		foreach($searchary as $key=>$value)
		{
			$this->db->where('`'.$key.'`',$value);
		}
		}
		$this->db->where('ss_aw_deleted', 1);
		$this->db->order_by('ss_aw_level','ASC');
		$this->db->order_by('ss_aw_seq_no','ASC');
		return $this->db->get($this->table)->result_array();
	}
	
	public function update_records($data)
	{
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->where('ss_aw_deleted', 1);
		$this->db->update($this->table,$data);
	}
	
	public function delete_record_subtopic($data)
	{
		$this->db->where('ss_aw_sub_category', $data['ss_aw_sub_category']);
		$this->db->where('ss_aw_uploaded_record_id', $data['ss_aw_uploaded_record_id']);
		$this->db->update($this->table,$data);
	}
	
	public function get_limited_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_limited_preface_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_preface_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_question_records($limit){
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_question_audio_exist','2');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_delete', 0);	
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_limited_answers_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_answers_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function fetch_databy_param($paramval = array())
	{
		if(!empty($paramval))
		{
			foreach($paramval as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}	
		$this->db->order_by('ss_aw_seq_no','ASC');
		$this->db->where($this->table.'.ss_aw_deleted','1');
		return $this->db->get($this->table)->result_array();
	}
	
	public function update_serialno($new_serial_no,$record_no)
	{
		$this->db->where('ss_aw_id', $record_no);
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$datary = array();
		$datary['ss_aw_seq_no'] = $new_serial_no;
		$this ->db->update($this->table,$datary);
		return 1;
	}
	
	public function get_deleted_records()
	{
		$this->db->select($this->table.'.*');	
		return $this->db->get($this->table)->result_array();
	}

	//sayan code
	public function fetch_subcategory_byparam_groupby_for_second_format($searchary)
	{
		if(!empty($searchary))
		{
			foreach($searchary as $key=>$value)
			{
				$this->db->where('`'.$key.'`',$value);
			}
		}
		$this->db->group_by('ss_aw_sub_category');
		$this->db->where('ss_aw_deleted', 1);
		$this->db->where('ss_aw_format', 'Multiple');
		return $this->db->get($this->table)->result_array();
	}

	public function fetch_subcategory_byparam_second_format($searchary)
	{
		if(!empty($searchary))
		{
		foreach($searchary as $key=>$value)
		{
			$this->db->where('`'.$key.'`',$value);
		}
		}
		$this->db->where('ss_aw_deleted', 1);
		$this->db->where('ss_aw_format', 'Multiple');
		$this->db->order_by('ss_aw_level','ASC');
		$this->db->order_by('ss_aw_seq_no','ASC');
		return $this->db->get($this->table)->result_array();
	}

	public function fetchrecordbyid($assesment_id){
		$this->db->where('ss_aw_uploaded_record_id', $assesment_id);
		return $this->db->get($this->table)->result_array();
	}

	public function totalnoofquestion($assesment_id){
		$this->db->where('ss_aw_uploaded_record_id', $assesment_id);
		$this->db->where('ss_aw_question_format !=', "");
		return $this->db->get($this->table)->num_rows();
	}
	
	public function fetch_subcategory_byparam_groupby_level($searchary)
	{
		if(!empty($searchary))
		{
			foreach($searchary as $key=>$value)
			{
				$this->db->where('`'.$key.'`',$value);
			}
		}
		$this->db->group_by('ss_aw_level');
		$this->db->where('ss_aw_deleted', 1);
		return $this->db->get($this->table)->result_array();
	}

	public function gettotalweight($question_id = array()){
		$this->db->select('SUM(ss_aw_weight) as total_weight');
		$this->db->from($this->table);
		$this->db->where_in('ss_aw_id', $question_id);
		return $this->db->get()->result();
	}

	public function gettotalnxtlvlweight($question_id = array(), $level){
		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		elseif ($level == 3) {
			$level_type = "A";
		}
		$this->db->select('SUM(ss_aw_weight) as total_weight');
		$this->db->from($this->table);
		$this->db->where_in('ss_aw_id', $question_id);
		$this->db->where('ss_aw_level !=', $level);
		return $this->db->get()->result();
	}

	public function update_multi_record($deleted_question_id, $data){
		$this->db->where_in('ss_aw_id', $deleted_question_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function checkassessmentreadyornot($assessment_id){
		$this->db->where('ss_aw_question_audio_exist', 2);
		$this->db->where('ss_aw_uploaded_record_id', $assessment_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function archived_records_by_id($assessment_id){
		$this->db->where('ss_aw_uploaded_record_id', $assessment_id);
		$this->db->set('ss_aw_deleted', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function get_question_by_id($id){
		$this->db->where('ss_aw_id', $id);
		return $this->db->get($this->table)->result_array();
	}

	public function getdiagnosticuniquequestion($category, $child_level, $oldquestionary = array()){
		if (!empty($oldquestionary)) {
			$this->db->where_not_in('ss_aw_id', $oldquestionary);
		}
		$this->db->where('ss_aw_level',$child_level);
		$this->db->where('ss_aw_category',$category);
		$this->db->where('ss_aw_quiz_type',1);
		$this->db->where('ss_aw_deleted', 1);
		$this->db->order_by('rand()');
		$this->db->limit(1);
		return $this->db->get($this->table)->result_array();
	}
}