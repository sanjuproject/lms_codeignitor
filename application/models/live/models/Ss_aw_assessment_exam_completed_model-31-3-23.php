<?php
  class Ss_aw_assessment_exam_completed_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assessment_exam_completed";
	}
	public function insert_data($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	public function searchdata($data = array())
	{
		if($data!="")
		{
			foreach($data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		return $this->db->get($this->table)->result_array();
	}
	public function fetch_details_byparam($param)
	{
		$this->db->select($this->table.'.*, ss_aw_assesment_uploaded.ss_aw_assesment_topic');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id ='.$this->table.'.ss_aw_assessment_id','left');
		if(!empty($param))
		{
			foreach($param as $key=>$val)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$val);
			}
		}
		return $this->db->get($this->table)->result_array();
	}
	
	public function fetch_details_byparam_withlessons($param,$lessonsary)
	{
		$this->db->select($this->table.'.*,ss_aw_assesment_uploaded.ss_aw_assessment_id,ss_aw_assesment_uploaded .ss_aw_lesson_id');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id ='.$this->table.'.ss_aw_assessment_id','left');
		if(!empty($param))
		{
			foreach($param as $key=>$val)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$val);
			}
		}
		$this->db->where_in('ss_aw_assesment_uploaded .ss_aw_lesson_id',$lessonsary);
		return $this->db->get($this->table)->result_array();
	}
	
	public function fetch_details_byparam_withlessonupload($param)
	{
		$this->db->select($this->table.'.*,ss_aw_assesment_uploaded.ss_aw_assessment_id,ss_aw_assesment_uploaded .ss_aw_lesson_id');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id ='.$this->table.'.ss_aw_assessment_id','left');
		if(!empty($param))
		{
			foreach($param as $key=>$val)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$val);
			}
		}
		return $this->db->get($this->table)->result_array();
	}

	public function totalcompletecount($assesment_id, $child_id){
		$this->db->where('ss_aw_assessment_id', $assesment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function getexamdetail($assesment_id, $child_id){
		$this->db->where('ss_aw_assessment_id', $assesment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->result();
	}

	public function update_data($data){
		$this->db->where('ss_aw_child_id', $data['child_id']);
		$this->db->where('ss_aw_assessment_id', $data['ss_aw_assessment_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function totallevelcompletecount($assessment_id, $child_id){
		$this->db->distinct('ss_aw_assessment_id');
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where_in('ss_aw_assessment_id', $assessment_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function getcompletecountbytopic($topic_id, $child_id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_topic_id', $topic_id);
		$this->db->where('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
		return $this->db->get()->num_rows();
	}

	public function gettotalcompletenum($child_id = "", $course = ""){
		if (!empty($child_id) && !empty($course)) {
			if ($course == 1) {
				$level = "E";
			}
			elseif ($course == 2) {
				$level = "C";
			}
			else
			{
				$level = "A";
			}
			$where = "FIND_IN_SET('".$level."', ss_aw_assesment_uploaded.ss_aw_course_id)";
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
			$this->db->where('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
			$this->db->where($where);
			return $this->db->get()->num_rows();
		}
	}

	public function get_assessment_completion_details($assessment_id, $child_id){
		$this->db->where('ss_aw_assessment_id', $assessment_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_id','ASC');
		return $this->db->get($this->table)->result();
	}

	public function totalcompletebytopic($assessment_topic, $child_id){
		$this->db->where('ss_aw_assessment_topic', $assessment_topic);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function getexamdetailbytopic($assesment_topic, $child_id){
		$this->db->where('ss_aw_assessment_topic', $assesment_topic);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->result();
	}

}	