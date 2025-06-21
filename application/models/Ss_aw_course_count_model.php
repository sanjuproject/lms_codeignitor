<?php

class Ss_aw_course_count_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_course_count";
	}
	public function get_course_count($id)
	{
		return $this->db->select('ss_aw_lessons,ss_aw_assessments,ss_aw_readalong')->where('ss_aw_course_id', $id)->get($this->table)->result_array();
	}

	public function update_record($datary)
	{
		$this->db->where('ss_aw_course_id', $datary['ss_aw_course_id']);

		$this->db->update($this->table, $datary);
	}
	public function update_record_by_query($dat, $id)
	{
		$this->db->set("ss_aw_lessons", "ss_aw_lessons $dat", FALSE);
		$this->db->set("ss_aw_assessments", "ss_aw_assessments $dat", FALSE);
		$this->db->set("ss_aw_readalong", "ss_aw_readalong $dat", FALSE);
		$this->db->where('ss_aw_course_id', $id);
		$this->db->update($this->table);		
		return $this->db->affected_rows();
	}
}
