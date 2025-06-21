<?php
/**
 * 
 */
class Ss_aw_assesment_multiple_question_asked_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assesment_multiple_question_asked";
	}

	public function check_existance($assessment_index_id, $assessment_id, $child_id, $exam_code){
		$this->db->where('ss_aw_exam_code', $exam_code);
		$this->db->where('ss_aw_page_index', $assessment_index_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function insert_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function fetchlastexamcode($child_id, $assesment_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_assessment_id', $assesment_id);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function getlastexamquestionindex($child_id, $exam_code){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_exam_code', $exam_code);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function checkrepeatexam($child_id, $exam_code, $assessment_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_exam_code !=', $exam_code);
		return $this->db->get($this->table)->num_rows();
	}

	public function checkstartedafterorbeforelesson($child_id, $compare_date){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_created_at >', $compare_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_exam_start_details($child_id, $assessment_id){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->result();
	}

	public function checkrepeatexambytopic($child_id, $exam_code, $assessment_topic){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_assessment_topic', $assessment_topic);
		$this->db->where('ss_aw_exam_code !=', $exam_code);
		return $this->db->get($this->table)->num_rows();
	}
}