<?php
/**
 * 
 */
class Ss_aw_diagonastic_exam_log_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_diagonastic_exam_log";
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
		$this->db->where('ss_aw_diagonastic_log_child_id', $id);
		$this->db->delete($this->table);
	}

	public function asked_question_num_by_exam_code($exam_code){
		$this->db->where('ss_aw_diagonastic_log_exam_code', $exam_code);
		$this->db->where('ss_aw_diagonastic_log_answer_status !=', 3);
		return $this->db->get($this->table)->num_rows();
	}

	public function correct_answered_question_num_by_exam_code($exam_code){
		$this->db->where('ss_aw_diagonastic_log_exam_code', $exam_code);
		$this->db->where('ss_aw_diagonastic_log_answer_status', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_details_by_exam_code_question_id($question_id, $exam_code){
    	$this->db->where('ss_aw_diagonastic_log_question_id', $question_id);
		$this->db->where('ss_aw_diagonastic_log_exam_code', $exam_code);
		return $this->db->get($this->table)->row();
    }
	
}