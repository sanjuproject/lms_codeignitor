<?php
  class Ss_aw_courses_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_courses";
	}

	public function search_byparam($data = array())
	{
		$this->db->select('*');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$this->db->where($key,$val);
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

public function get_all_data()
	{
		return $this->db->get($this->table)->result();
	}
	public function data_update($course_id,$update_data)
	{
		$this->db->where('ss_aw_course_id ',$course_id)->update($this->table,$update_data);
		return true;
	}
}
