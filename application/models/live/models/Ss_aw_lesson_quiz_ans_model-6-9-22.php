<?php
  class Ss_aw_lesson_quiz_ans_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_lesson_quiz_ans";
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
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}
	
	public function search_data_by_param_count_lessons_ans($search_data = array())
	{
		$this->db->select('ss_aw_lesson_id,count(*) as lesson_count');
		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		 $this->db->group_by('ss_aw_lesson_id'); 
		return $this->db->get($this->table)->result_array();
	}

	public function gettotalquestionbylessonchild($lesson_id, $child_id){
		$this->db->where('ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function gettotalwrightanswerbylessonchild($lesson_id, $child_id){
		$this->db->where('ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_answer_status', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function getrecordbytopic($topic_id, $lesson_id, $child_id){
		$this->db->select('ss_aw_lesson_quiz_ans.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_lessons','ss_aw_lessons.ss_aw_lesson_details = ss_aw_lesson_quiz_ans.ss_aw_question');
		$this->db->where('ss_aw_lessons.ss_aw_lesson_format','Multiple');
		$this->db->where('ss_aw_lessons.ss_aw_lesson_topic', $topic_id);
		$this->db->where('ss_aw_lesson_quiz_ans.ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_lesson_quiz_ans.ss_aw_child_id', $child_id);
		return $this->db->get()->result();
	}

	public function get_answered_record_by_lessions($lesson_ids = array()){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where_in('ss_aw_lesson_id', $lesson_ids);
		return $this->db->get($this->table)->result();
	}

	public function checkquestionansweredornot($question, $child_id){
		$this->db->where('ss_aw_question', $question);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->result();
	}

	public function getlessonquizdetails($child_id, $lesson_id){
		$this->db->select('ss_aw_lesson_quiz_ans.*, ss_aw_lessons_uploaded.ss_aw_lesson_topic, ss_aw_lessons.ss_aw_lesson_answers, ss_aw_lessons.ss_aw_lesson_title, ss_aw_lessons.ss_aw_lesson_question_options, ss_aw_lessons.ss_aw_lesson_format_type');
		$this->db->from($this->table);
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lesson_quiz_ans.ss_aw_lesson_id');
		$this->db->join('ss_aw_lessons','ss_aw_lessons.ss_aw_lession_id = ss_aw_lesson_quiz_ans.ss_aw_question_id');
		$this->db->where('ss_aw_lesson_quiz_ans.ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_lesson_quiz_ans.ss_aw_lesson_id', $lesson_id);
		$this->db->group_by('ss_aw_lesson_quiz_ans.ss_aw_id');
		return $this->db->get()->result();
	}

}
