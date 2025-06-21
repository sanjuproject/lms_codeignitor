<?php

class Diagnostic_child_course_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = "diagnostic_child_course";
	}
	public function data_insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	public function get_details($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table . '.ss_aw_child_id', $id);
		$this->db->order_by('ss_aw_child_course_id', 'ASC');
		return $this->db->get()->result_array();
	}
	public function get_institutional_enroll_count($child_ary = array()){
		if (!empty($child_ary)) {			
			$this->db->where_in('ss_aw_child_id', $child_ary);
			$this->db->group_by("ss_aw_child_id");
			return $this->db->get($this->table)->num_rows();	
		}
		else{
			return 0;
		}
		
	}
}
