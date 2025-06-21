<?php
  class Ss_aw_purchase_courses_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_purchase_courses";
	}

	public function search_byparam($data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_courses.ss_aw_course_name,ss_aw_courses.ss_aw_course_code,ss_aw_courses.ss_aw_sort_description,ss_aw_courses.ss_aw_long_description,
		ss_aw_course_count.ss_aw_lessons,ss_aw_course_count.ss_aw_assessments,ss_aw_course_count.ss_aw_readalong');
		$this->db->join('ss_aw_courses','ss_aw_courses.ss_aw_course_id ='.$this->table.'.ss_aw_selected_course_id','left');
		$this->db->join('ss_aw_course_count','ss_aw_course_count.ss_aw_course_id =ss_aw_courses.ss_aw_course_id','left');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$this->db->where($this->table.".".$key,$val);
			}
		}
		return $this->db->get()->result_array();
	}

	public function get_purchase_course_details($data = array()){
		$this->db->select($this->table.'.*,ss_aw_courses.ss_aw_course_name,ss_aw_courses.ss_aw_course_code,ss_aw_courses.ss_aw_sort_description,ss_aw_courses.ss_aw_long_description,
		ss_aw_course_count.ss_aw_lessons,ss_aw_course_count.ss_aw_assessments,ss_aw_course_count.ss_aw_readalong');
		$this->db->join('ss_aw_courses','ss_aw_courses.ss_aw_course_id ='.$this->table.'.ss_aw_selected_course_id','left');
		$this->db->join('ss_aw_course_count','ss_aw_course_count.ss_aw_course_id =ss_aw_courses.ss_aw_course_id','left');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$this->db->where($this->table.".".$key,$val);
			}
		}
		$this->db->order_by($this->table.'.ss_aw_purchase_course_id','desc');
		return $this->db->get()->result_array();
	}
	
	public function update_details($data)	
	{
		$this->db->where('ss_aw_test_timing_id',$data['ss_aw_test_timing_id']);
		$this->db->update($this->table, $data );
		$count = $this->db->affected_rows();
		if($count==1)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	public function data_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}

	public function get_purchase_courses_by_parent($parent_id){
		$this->db->where('ss_aw_parent_id', $parent_id);
		return $this->db->get($this->table)->result();
	}

	public function updatecourseidafterpromote($child_id, $course_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->set('ss_aw_selected_course_id', $course_id);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function checkpaidornot($child_id, $course_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_selected_course_id', $course_id);
		return $this->db->get($this->table)->result();
	}

	public function update_record($child_id, $data = array()){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
}
