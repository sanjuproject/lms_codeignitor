<?php
class Diagnostic_upload_child_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = "diagnostic_upload_child";
	}



	public function store_data($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	public function update_child_details($data, $child_id)
	{
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->update($this->table, $data);
		$count = $this->db->affected_rows();
		if ($count == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function get_diagnostic_users_by_parents_ary($instution_id = array(), $limit = "", $start = "", $search_data = "", $institution_list = 0)
	{
		$this->db->select('*, (case when ll.ss_aw_last_lesson_modified_date !=""
		then DATEDIFF(date_format(now(),"%Y-%m-%d"),date_format(ll.ss_aw_last_lesson_modified_date,"%Y-%m-%d"))
		else 0 end)datedifference,
		(select ss_aw_diagnostic_purchase_restriction from ss_aw_general_settings where 1)duration');
		if (!empty($instution_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->join("diagnostic_childs", "diagnostic_childs.ss_aw_child_id=diagnostic_upload_child.ss_aw_child_id");
			$this->db->join("diagnostic_child_course", "diagnostic_child_course.ss_aw_child_id=" . $this->table . ".ss_aw_child_id", "left");
			$this->db->join("diagnostic_exam_last_lesson ll", "ll.ss_aw_child_id=diagnostic_upload_child.ss_aw_child_id AND ll.upload_child_id=diagnostic_upload_child.id", "left");

			$this->db->where('diagnostic_childs.ss_aw_child_delete', 0);
			$this->db->where_in('diagnostic_childs.ss_aw_institution_id', $instution_id);
			$this->db->where('diagnostic_childs.ss_aw_child_username', null);
			$this->db->where('diagnostic_childs.ss_aw_institution_user_upload_id !=', 0);
			if ($search_data != "") {
				$this->db->group_start();
				$this->db->like('diagnostic_childs.ss_aw_child_username', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_nick_name', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_first_name', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_last_name', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_email', $search_data);
				$this->db->group_end();
			}
			// $this->db->group_by("diagnostic_upload_child.id");

			if (!empty($limit)) {
				$this->db->limit($limit, $start);
			}
			return $this->db->get($this->table)->result();
		}
	}
	public function total_diagnostic_users($instution_id = array(), $search_data = "", $institution_list = 0)
	{
		if (!empty($instution_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->join("diagnostic_childs", "diagnostic_childs.ss_aw_child_id=diagnostic_upload_child.ss_aw_child_id");
			$this->db->join("diagnostic_child_course", "diagnostic_child_course.ss_aw_child_id=" . $this->table . ".ss_aw_child_id", "left");
			$this->db->join("diagnostic_exam_last_lesson ll", "ll.ss_aw_child_id=diagnostic_upload_child.ss_aw_child_id AND ll.upload_child_id=diagnostic_upload_child.id", "left");
			$this->db->where('diagnostic_childs.ss_aw_child_delete', 0);
			$this->db->where_in('diagnostic_childs.ss_aw_institution_id', $instution_id);
			$this->db->where('diagnostic_childs.ss_aw_child_username', null);
			$this->db->where('diagnostic_childs.ss_aw_institution_user_upload_id !=', 0);
			if ($search_data != "") {
				$this->db->group_start();
				$this->db->like('diagnostic_childs.ss_aw_child_username', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_nick_name', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_first_name', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_last_name', $search_data);
				$this->db->or_like('diagnostic_childs.ss_aw_child_email', $search_data);
				$this->db->group_end();
			}
			// $this->db->group_by("diagnostic_upload_child.id");
			return $this->db->get($this->table)->num_rows();
		}
	}
	public function get_record_by_upload_id($upload_id)
	{
		$this->db->join("diagnostic_childs", "diagnostic_childs.ss_aw_child_id=diagnostic_upload_child.ss_aw_child_id");
		$this->db->where('diagnostic_upload_child.student_upload_id', $upload_id);
		$this->db->where('diagnostic_childs.ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}
}
