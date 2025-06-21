<?php
class Diagnostic_childs_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = "diagnostic_childs";
	}
	public function add_child($data)
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
	public function check_email($email)
	{
		$this->db->where('ss_aw_child_email', $email);
		$this->db->where('ss_aw_child_delete', 0);
		//$this->db->where('ss_aw_child_status', 1);
		return $this->db->get($this->table)->result();
	}
	public function child_code_check()
	{
		return $this->db->order_by('ss_aw_child_code', "desc")->get($this->table)->row();
	}

	public function total_diagnostic_users($instution_id = array(), $search_data = "", $institution_list = 0)
	{
		if (!empty($instution_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->join("diagnostic_child_course", "diagnostic_child_course.ss_aw_child_id=" . $this->table . ".ss_aw_child_id", "left");
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_institution_id', $instution_id);
			$this->db->where('ss_aw_child_username', null);
			$this->db->where('ss_aw_institution_user_upload_id !=', 0);
			if ($search_data != "") {
				$this->db->group_start();
				$this->db->like('ss_aw_child_username', $search_data);
				$this->db->or_like('ss_aw_child_nick_name', $search_data);
				$this->db->or_like('ss_aw_child_first_name', $search_data);
				$this->db->or_like('ss_aw_child_last_name', $search_data);
				$this->db->or_like('ss_aw_child_email', $search_data);
				$this->db->group_end();
			}
			return $this->db->get($this->table)->num_rows();
		}
	}
	public function get_diagnostic_users_by_parents_ary($instution_id = array(), $limit = "", $start = "", $search_data = "", $institution_list = 0)
	{
		if (!empty($instution_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->join("diagnostic_child_course", "diagnostic_child_course.ss_aw_child_id=" . $this->table . ".ss_aw_child_id", "left");

			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_institution_id', $instution_id);
			$this->db->where('ss_aw_child_username', null);
			$this->db->where('ss_aw_institution_user_upload_id !=', 0);
			if ($search_data != "") {
				$this->db->group_start();
				$this->db->like('ss_aw_child_username', $search_data);
				$this->db->or_like('ss_aw_child_nick_name', $search_data);
				$this->db->or_like('ss_aw_child_first_name', $search_data);
				$this->db->or_like('ss_aw_child_last_name', $search_data);
				$this->db->or_like('ss_aw_child_email', $search_data);
				$this->db->group_end();
			}
			if (!empty($limit)) {
				$this->db->limit($limit, $start);
			}
			return $this->db->get($this->table)->result();
		}
	}
	public function get_record_by_upload_id($upload_id)
	{
		$this->db->where('ss_aw_institution_user_upload_id', $upload_id);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}
	public function get_child_detail_by_id($child_id)
	{
		return $this->db->where('ss_aw_child_id ', $child_id)->get($this->table)->result();
	}
	public function get_details_with_course($child_id)
	{
		$this->db->select('diagnostic_childs.*, 
		(SELECT diagnostic_child_course.ss_aw_course_id FROM diagnostic_child_course WHERE diagnostic_child_course.ss_aw_child_id = diagnostic_childs.ss_aw_child_id ORDER BY diagnostic_child_course.ss_aw_child_course_id DESC LIMIT 1) as course, 
		(SELECT diagnostic_child_course.ss_aw_child_course_create_date FROM diagnostic_child_course WHERE diagnostic_child_course.ss_aw_child_id = diagnostic_childs.ss_aw_child_id ORDER BY diagnostic_child_course.ss_aw_child_course_id DESC LIMIT 1) as course_start_date, 
		(SELECT ss_aw_parents.ss_aw_device_type FROM ss_aw_parents WHERE ss_aw_parents.ss_aw_parent_id = diagnostic_childs.ss_aw_parent_id) as parent_device_type');
		$this->db->from($this->table);
		$this->db->where('diagnostic_childs.ss_aw_child_id', $child_id);
		return $this->db->get()->row();
	}
	public function get_child_profile_details($child_id, $child_token = "")
	{
		$this->db->where('ss_aw_child_id', $child_id);
		if (!empty($child_token)) {
			$this->db->where('ss_aw_child_auth_key', $child_token);
		}
		return $this->db->get($this->table)->result();
	}
	public function check_child_existance_with_token($child_id, $child_token)
	{
		$count = $this->db->where('ss_aw_child_id', $child_id)->where('ss_aw_child_auth_key', $child_token)->get($this->table)->num_rows();
		if ($count == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function get_all_institutional_users($parent_id = array())
	{
		if (!empty($parent_id)) {
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			return $this->db->get($this->table)->result();
		}
	}
	public function login_process($email)
	{
		$this->db->select('*');
		$this->db->from("ss_aw_parents");
		$this->db->where('ss_aw_parent_email', $email);
		$this->db->where('ss_aw_parent_status', 1);
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_blocked', 0);
		$this->db->group_start();
		$this->db->where('ss_aw_institution', 0);
		$this->db->or_where('(select count(*) from diagnostic_childs where diagnostic_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id and diagnostic_childs.ss_aw_child_username is null) > 0');
		$this->db->group_end();
		return $this->db->get()->result();
	}
	public function token_update_by_email($email, $token, $device_type = "")
	{
		$this->db->where('ss_aw_child_email', $email);
		$this->db->set('ss_aw_child_auth_key', $token);
		if (!empty($device_type)) {
			$this->db->set('ss_aw_device_type', $device_type);
		}
		$this->db->update($this->table);
		$count = $this->db->affected_rows();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function check_self_registration($parent_id)
	{
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('ss_aw_is_self', 1);
		return $this->db->get($this->table)->row();
	}
	public function token_update_by_code($child_code, $token, $device_type = "")
	{
		$query = "(ss_aw_child_code = '" . $child_code . "' or ss_aw_child_username = '" . $child_code . "')";
		$this->db->where($query);
		$this->db->set('ss_aw_child_auth_key', $token);
		if (!empty($device_type)) {
			$this->db->set('ss_aw_device_type', $device_type);
		}
		$this->db->update($this->table);
		$count = $this->db->affected_rows();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function child_login_process($child_code)
	{
		$query = "(ss_aw_child_code = '" . $child_code . "' or ss_aw_child_username = '" . $child_code . "')";
		$this->db->where($query);
		$this->db->where('ss_aw_child_status', 1);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}
	public function password_update($child_id, $password)
	{
		$this->db->set('ss_aw_child_password', $password)->where('ss_aw_child_id', $child_id)->update($this->table);
		$count = $this->db->affected_rows();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function logout($child_id)
	{

		$this->db->where('ss_aw_child_id', $child_id)->set('ss_aw_child_auth_key', '')->set('ss_aw_device_token', '')->update($this->table);
		$count = $this->db->affected_rows();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function email_existance($email){
		$this->db->where('ss_aw_child_email',$email);		
		$query=$this->db->get($this->table);
		if ($query->num_rows() > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
}
