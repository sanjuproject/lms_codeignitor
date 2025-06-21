<?php
  class Ss_aw_readalong_quiz_ans_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalong_quiz_ans";
	}

	public function data_insert($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
		
	public function update_record($datary)
	{
		
		$this->db->where('ss_aw_id', $datary['ss_aw_id']);
	
		$this ->db->update($this->table,$datary);
	}
	
	public function search_data_by_param($search_data = array())
	{

		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		return $this->db->get($this->table)->result_array();
	}
	
	public function checkdatabyid($quiz_id, $readalong_id, $child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_quiz_id', $quiz_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		return $this->db->get($this->table)->result();
	}

	public function get_quiz_details($child_id, $readalong_id){
		$this->db->select('ss_aw_readalong_quiz_ans.*,ss_aw_readalong_quiz.ss_aw_question, ss_aw_readalong_quiz.ss_aw_answers,ss_aw_readalong_quiz.ss_aw_details');
		$this->db->from($this->table);
		$this->db->join('ss_aw_readalong_quiz','ss_aw_readalong_quiz.ss_aw_readalong_id = ss_aw_readalong_quiz_ans.ss_aw_quiz_id');
		$this->db->where('ss_aw_readalong_quiz_ans.ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_quiz_ans.ss_aw_readalong_id', $readalong_id);
		return $this->db->get()->result();
	}

	public function get_wrong_answer_count($child_id, $readalong_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		$this->db->where('ss_aw_quiz_right_wrong', 2);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_all_question_count($child_id, $readalong_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		return $this->db->get($this->table)->num_rows();
	}

}
