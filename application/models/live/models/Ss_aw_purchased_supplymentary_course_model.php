<?php
  class Ss_aw_purchased_supplymentary_course_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_purchased_supplymentary_course";
	}

	public function search_byparam($data = array())
	{
		$this->db->select($this->table.'.*');
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

	public function get_purchased_supplymentary($child_id, $course_complete_date){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('DATE(ss_aw_create_date) >=', $course_complete_date);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->row();
	}
}
