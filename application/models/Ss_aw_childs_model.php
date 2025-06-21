<?php
  class Ss_aw_childs_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_childs";
	}

	public function add_child($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}

	public function check_child_existance($child_code)
	{
		$query = "ss_aw_child_status = 1 and ss_aw_child_delete = 0 and (ss_aw_child_code = '".$child_code."' or ss_aw_child_username = '".$child_code."')";
		return $this->db->where($query)->get($this->table)->result();
	}
	public function check_child_count($parent_id)
	{
		return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status','1')->where($this->table.'.ss_aw_child_delete','0')->get($this->table)->num_rows();
	}
	public function get_child_details($parent_id)
	{
		$this->db->select($this->table.'.*,ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_status');
		$this->db->from($this->table);
		$this->db->join('ss_aw_diagonastic_exam',$this->table.'.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id','left');
		$this->db->where($this->table.'.ss_aw_parent_id',$parent_id)->where($this->table.'.ss_aw_child_status','1');
		return $this->db->get()->result();
		//return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status','1')->get($this->table)->result();
	}
	public function get_child_details_by_id($child_id,$parent_id)
	{
	    $this->db->where('ss_aw_child_id ',$child_id);
	    if($parent_id!="")
	    {
	    	$this->db->where('ss_aw_parent_id  ',$parent_id);
	    }
	    
	   return $this->db->get($this->table)->result();
	}
	public function child_login_process($child_code)
	{
		$query = "(ss_aw_child_code = '".$child_code."' or ss_aw_child_username = '".$child_code."')";
		$this->db->where($query);
		$this->db->where('ss_aw_child_status',1 );		
		$this->db->where('ss_aw_child_delete',0 );		
		return $this->db->get($this->table)->result();	
	}

	public function token_update_by_code($child_code,$token,$device_type = "")
	{
		$query = "(ss_aw_child_code = '".$child_code."' or ss_aw_child_username = '".$child_code."')";
		$this->db->where($query);
		$this->db->set('ss_aw_child_auth_key',$token);
		if (!empty($device_type)) {
			$this->db->set('ss_aw_device_type', $device_type);
		}
		$this->db->update($this->table);
		$count = $this->db->affected_rows();
		if ($count > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
	public function check_child_existance_with_token($child_id,$child_token)
	{
		$count=$this->db->where('ss_aw_child_id',$child_id)->where('ss_aw_child_auth_key',$child_token)->get($this->table)->num_rows();
		if($count==1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function update_child_details($data,$child_id)	
	{
		$this->db->where('ss_aw_child_id',$child_id);
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

	public function logout($child_id)
	{
		
           $this->db->where('ss_aw_child_id',$child_id)->set('ss_aw_child_auth_key','')->set('ss_aw_device_token','')->update($this->table);
           	$count = $this->db->affected_rows();
				if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}		
		
	}

	public function get_child_profile_details($child_id,$child_token = "")
	{
			$this->db->where('ss_aw_child_id',$child_id);
			if (!empty($child_token)) {
				$this->db->where('ss_aw_child_auth_key',$child_token);	
			}
	    return $this->db->get($this->table)->result();
	}

	public function delete_child($child_id,$parent_id)
	{
		 $this->db->set('ss_aw_child_status','0')->set('ss_aw_child_delete','1')->where('ss_aw_child_id',$child_id)->where('ss_aw_parent_id',$parent_id)->update($this->table);
		 $count = $this->db->affected_rows();
				if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}	

	}
	public function child_parent_email_id($child_code)
	{
		
		$query=$this->db->select('ss_aw_parents.ss_aw_parent_email,ss_aw_childs.ss_aw_child_email,ss_aw_child_nick_name')->from($this->table)->join('ss_aw_parents','ss_aw_childs.ss_aw_parent_id=ss_aw_parents.ss_aw_parent_id')->where('ss_aw_childs.ss_aw_child_code',$child_code)->get()->result();

		return $query;
	}

	public function forget_password_to_set_code($child_code,$data)
	{
		$this->db->where('ss_aw_child_code',$child_code)->update($this->table,$data);
		$count = $this->db->affected_rows();
			if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}
	}

	public function forget_password_reset($reset_code,$data,$child_code)
	{
		$this->db->where('ss_aw_child_reset_code',$reset_code)->where('ss_aw_child_code',$child_code)->update($this->table,$data);
		$count = $this->db->affected_rows();
			if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}
	}
	public function child_code_check()
	{
		return $this->db->order_by('ss_aw_child_code',"desc")->get($this->table)->row();
	}

	public function last_child($parent_id)
	{
		return $this->db->where('ss_aw_parent_id ',$parent_id)->order_by('ss_aw_child_id ',"desc")->get($this->table)->row();
	}

	public function first_child($parent_id)
	{
		return $this->db->where('ss_aw_parent_id ',$parent_id)->order_by('ss_aw_child_id ',"asc")->get($this->table)->row();
	}

	 public function data_modify_time($child_code)
	{
		return $this->db->select('ss_aw_child_modified_date')->where('ss_aw_child_code',$child_code)->get($this->table)->result_array();
	}
	


	public function deleterecord($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->delete($this->table);
	}

public function deleterecord_byid($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->set('ss_aw_child_delete','1');
		$this->db->update($this->table);
	}
	
	public function delete_single_child($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}
	public function get_details($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.ss_aw_child_id',$id);
		return $this->db->get()->result_array();
	}

	public function get_all_child_details($parent_id)
	{

		$this->db->select($this->table.'.*,ss_aw_parents.ss_aw_parent_email,ss_aw_parents.ss_aw_blocked as parent_block_status,(SELECT ss_aw_child_course.ss_aw_course_id FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course, (SELECT ss_aw_child_course.ss_aw_child_course_create_date FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course_start_date');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents',$this->table.'.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id ','left');
		$this->db->where($this->table.'.ss_aw_parent_id',$parent_id)->where($this->table.'.ss_aw_child_delete','0');
		
		return $this->db->get()->result();
		//return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status','1')->get($this->table)->result();
	}

	public function get_all_child_details_except_self($parent_id)
	{

		$this->db->select($this->table.'.*,ss_aw_parents.ss_aw_parent_email,ss_aw_parents.ss_aw_blocked as parent_block_status,(SELECT ss_aw_child_course.ss_aw_course_id FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course, (SELECT ss_aw_child_course.ss_aw_child_course_create_date FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course_start_date');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents',$this->table.'.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id ','left');
		$this->db->where($this->table.'.ss_aw_parent_id',$parent_id)->where($this->table.'.ss_aw_child_delete','0')->where('ss_aw_is_self', null);
		
		return $this->db->get()->result();
		//return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status','1')->get($this->table)->result();
	}

	public function get_childs($parent_id)
	{
		$this->db->select($this->table.'.*,ss_aw_parents.ss_aw_parent_email,(SELECT ss_aw_child_course.ss_aw_course_id FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course, (SELECT ss_aw_child_course.ss_aw_child_course_create_date FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course_start_date');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents',$this->table.'.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id ','left');
		$this->db->where($this->table.'.ss_aw_parent_id',$parent_id)->where($this->table.'.ss_aw_child_status','1')->where($this->table.'.ss_aw_child_delete','0');
		
		return $this->db->get()->result();
		//return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status','1')->get($this->table)->result();
	}

	public function chnage_child_status($child_id,$child_status)
	{
		$this->db->where('ss_aw_child_id ',$child_id)->set('ss_aw_child_status',$child_status)->update($this->table);
		return true;
	}
	public function get_all_child_count($parent_id)
	{
		return $this->db->where('ss_aw_parent_id',$parent_id)->where($this->table.'.ss_aw_child_delete','0')->where($this->table.'.ss_aw_child_username !=', null)->get($this->table)->num_rows();
	}
	
	public function get_all_schoolname($search_data)
	{
		$this->db->like('ss_aw_child_schoolname',$search_data, 'after');
		return $this->db->distinct('ss_aw_child_schoolname')->select('ss_aw_child_schoolname')->get($this->table)->result();
	}
	
	public function password_update($parent_id,$password)
	{
		$this->db->set('ss_aw_child_password',$password)->where('ss_aw_child_id',$parent_id)->update($this->table);
			$count = $this->db->affected_rows();
			if ($count > 0) {
				return true;
			}
			else
			{
				return false;
			}
	}

	public function get_child_detail_by_id($child_id){
	    return $this->db->where('ss_aw_child_id ',$child_id)->get($this->table)->result();
	}

	public function get_all_child($data = array()){
		if (!empty($data)) {
			if (!empty($data['age'])) {
				$ageAry = explode("-", $data['age']);
				$start_age = $ageAry[0];
				$end_age = $ageAry[1];
				$this->db->where('ss_aw_child_age >=', $start_age);
				$this->db->where('ss_aw_child_age <=', $end_age);
			}

			if (!empty($data['enroll_type'])) {
				$this->db->where('ss_aw_child_enroll_type', $data['enroll_type']);
			}

			if (!empty($data['level'])) {
				$level = $data['level'];
				if ($level == 1) {
					$this->db->where('(SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 1 or (SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 2');
				}
				else{
					$this->db->where('(SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = "'.$level.'"');
				}
			}
		}
		$this->db->where('ss_aw_child_status', 1);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}

	//============== Sayan Code ===============

	public function get_parent_email_device_token_by_child_id($child_id){
		$this->db->select('ss_aw_parents.ss_aw_parent_email,ss_aw_parents.ss_aw_device_token,ss_aw_parents.ss_aw_parent_primary_mobile,ss_aw_parents.ss_aw_parent_full_name,ss_aw_parents.ss_aw_parent_id');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id');
		$this->db->where('ss_aw_childs.ss_aw_child_id', $child_id);
		return $this->db->get()->result();
	}

	public function getchild_byage($start_age, $end_age){
		$this->db->where('ss_aw_child_age >=', $start_age);
		$this->db->where('ss_aw_child_age <=', $end_age);
		$this->db->where('ss_aw_child_status', 1);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}

	public function check_email($email){
		$this->db->where('ss_aw_child_email', $email);
		$this->db->where('ss_aw_child_delete', 0);
		//$this->db->where('ss_aw_child_status', 1);
		return $this->db->get($this->table)->result();
	}

	public function check_mobile($mobile){
		$this->db->where('ss_aw_child_mobile', $mobile);
		$this->db->where('ss_aw_child_delete', 0);
		$this->db->where('ss_aw_child_status', 1);
		return $this->db->get($this->table)->result();
	}

	public function check_email_with_parent($email, $parent_id){
		$this->db->where('ss_aw_child_email', $email);
		$this->db->where('ss_aw_parent_id !=', $parent_id);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->num_rows();
	}

	public function getdiffuserlogintypenum($program_date){
		$this->db->select('(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 1 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as online,(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 2 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as email_solitation,(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 3 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as offer');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function getdiffuserlogintypenum_ytd($year){
		$this->db->select('(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 1 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and YEAR(ss_aw_child_created_date) = "'.$year.'" and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as online,(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 2 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and YEAR(ss_aw_child_created_date) = "'.$year.'" and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as email_solitation,(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 3 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and YEAR(ss_aw_child_created_date) = "'.$year.'" and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as offer');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function getdiffuserlogintypenum_monthly($year, $month){
		$this->db->select('(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 1 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and YEAR(ss_aw_child_created_date) = "'.$year.'" and MONTH(ss_aw_child_created_date) = "'.$month.'" and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as online,(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 2 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and YEAR(ss_aw_child_created_date) = "'.$year.'" and MONTH(ss_aw_child_created_date) = "'.$month.'" and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as email_solitation,(SELECT count(*) FROM ss_aw_childs WHERE ss_aw_child_enroll_type = 3 and ss_aw_child_status = 1 and ss_aw_child_delete = 0 and YEAR(ss_aw_child_created_date) = "'.$year.'" and MONTH(ss_aw_child_created_date) = "'.$month.'" and DATE(ss_aw_child_created_date) >= "'.report_date_from.'") as offer');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function check_user($child_id,$child_token){
		return $this->db->where('ss_aw_child_id',$child_id)->where('ss_aw_child_auth_key',$child_token)->get($this->table)->result();
	}

	public function get_all_child_by_parent($parent_id){
		return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_username !=', null)->where('ss_aw_child_delete', 0)->get($this->table)->result();
	}

	public function get_all_active_childs_by_parent($parent_id){
		return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status', 1)->where('ss_aw_child_delete', 0)->get($this->table)->result();
	}

	public function change_all_child_status_by_parent($parent_id){
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->set('ss_aw_child_status', 0);
		$this->db->update($this->table);
	}

	public function get_details_with_course($child_id){
		$this->db->select('ss_aw_childs.*, (SELECT ss_aw_child_course.ss_aw_course_id FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course, (SELECT ss_aw_child_course.ss_aw_child_course_create_date FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id ORDER BY ss_aw_child_course.ss_aw_child_course_id DESC LIMIT 1) as course_start_date, (SELECT ss_aw_parents.ss_aw_device_type FROM ss_aw_parents WHERE ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id) as parent_device_type');
		$this->db->from($this->table);
		$this->db->where('ss_aw_childs.ss_aw_child_id', $child_id);
		return $this->db->get()->row();
	}

	public function deleterecord_by_childid($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->set('ss_aw_child_status', 0);
		$this->db->set('ss_aw_child_delete', 1);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function check_in_child($parent_id, $child_email){
		$this->db->where('ss_aw_parent_id !=', $parent_id);
		$this->db->where('ss_aw_child_email', $child_email);
		$this->db->where('ss_aw_child_delete', 0);
		$this->db->limit(1);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_diagnostic_non_course_purchase_details($search_date){
		$this->db->select('ss_aw_childs.ss_aw_child_id, ss_aw_childs.ss_aw_child_nick_name, ss_aw_parents.ss_aw_parent_email, ss_aw_childs.ss_aw_child_dob, (select ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date from ss_aw_diagonastic_exam where ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = ss_aw_childs.ss_aw_child_id limit 1) as exam_date, ss_aw_parents.ss_aw_device_token');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('(select count(*) from ss_aw_diagonastic_exam where ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = ss_aw_childs.ss_aw_child_id and ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date >= "'.$search_date.'") > 0');
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id) = 0');
		return $this->db->get()->result();
	}

	public function get_registration_by_date($search_date){
		$this->db->where('ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_child_created_date)', $search_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_by_date_range($search_date, $current_date){
		$this->db->where('ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_child_created_date) >', $search_date);
		$this->db->where('DATE(ss_aw_child_created_date) <=', $current_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_before_last_seven_days_of_current_date($search_date){
		$this->db->where('ss_aw_child_delete', 0);
		$this->db->where('DATE(ss_aw_child_created_date) <', $search_date);
		$this->db->where('DATE(ss_aw_child_created_date) >=', report_date_from);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_daily_diagnostic_non_course_purchase_details($search_date){
		$this->db->select('ss_aw_childs.ss_aw_child_id');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('(select count(*) from ss_aw_diagonastic_exam where ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = ss_aw_childs.ss_aw_child_id and DATE(ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date) <= "'.$search_date.'") and DATE(ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date) >= "'.report_date_from.'") > 0');
		$this->db->where('ss_aw_childs.ss_aw_child_delete', 0);
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id) = 0');
		return $this->db->get()->result();
	}

	public function get_total_childs_up_to_date($current_date){
		$this->db->where('ss_aw_child_delete', 0);
		$this->db->where('ss_aw_child_status', 1);
		$this->db->where('DATE(ss_aw_child_created_date) <=', $current_date);
		$this->db->where('DATE(ss_aw_child_created_date) >=', report_date_from);
		return $this->db->get($this->table)->num_rows();
	}

	//============== End Code ==================
	

	//============version 2 code============
	public function check_username($username){
		$this->db->where('ss_aw_child_username', $username);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_child_count_by_parent_id($parent_id){
		return $this->db->where('ss_aw_child_username !=', null)->where('ss_aw_parent_id',$parent_id)->where('ss_aw_child_status', 1)->where('ss_aw_child_delete', 0)->get($this->table)->result();
	}

	public function check_self_registration($parent_id){
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('ss_aw_is_self', 1);
		return $this->db->get($this->table)->row();
	}

	public function check_self_enrolled($parent_id){
		$this->db->select('ss_aw_childs.*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_childs.ss_aw_parent_id', $parent_id);
		// $this->db->where('ss_aw_childs.ss_aw_child_username', null);
		$this->db->where('ss_aw_childs.ss_aw_is_self', 1);
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id) > 0');
		return $this->db->get()->row();
	}

	public function check_child_enrolled($parent_id){
		$this->db->select('ss_aw_childs.*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_childs.ss_aw_parent_id', $parent_id);
		// $this->db->where('ss_aw_childs.ss_aw_child_username', null);
		$this->db->where('ss_aw_childs.ss_aw_is_self', null);
		$this->db->where('(select count(*) from ss_aw_child_course where ss_aw_child_course.ss_aw_child_id = ss_aw_childs.ss_aw_child_id) > 0');
		return $this->db->get()->row();
	}

	public function total_winner_users($parent_id = array(), $search_data = "", $institution_list = 0){
		if (!empty($parent_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			$this->db->where('ss_aw_child_username !=', null);
			$this->db->where('ss_aw_institution_user_upload_id !=', 0);
			if($search_data!="") {
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

	public function get_users_by_parents_ary($parent_id = array(), $limit = "", $start = "", $search_data = "", $institution_list = 0){
		if (!empty($parent_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			$this->db->where('ss_aw_child_username !=', null);
			$this->db->where('ss_aw_institution_user_upload_id !=', 0);
			if($search_data!="") {
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

	public function total_masters_users($parent_id = array(), $search_data = "", $institution_list = 0){
		if (!empty($parent_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			$this->db->where('ss_aw_child_username', null);
			$this->db->where('ss_aw_institution_user_upload_id !=', 0);
			if($search_data!="") {
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

	public function get_master_users_by_parents_ary($parent_id = array(), $limit = "", $start = "", $search_data = "", $institution_list = 0){
		if (!empty($parent_id)) {
			if ($institution_list) {
				$this->db->where('ss_aw_child_status', 1);
			}
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			$this->db->where('ss_aw_child_username', null);
			$this->db->where('ss_aw_institution_user_upload_id !=', 0);
			if($search_data!="") {
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

	public function remove_institution_user($child_id){
		 	$this->db->set('ss_aw_child_status','0')->set('ss_aw_child_delete','1')->where('ss_aw_child_id',$child_id)->update($this->table);
		 	$count = $this->db->affected_rows();
			if ($count > 0) {
				return true;
			}
			else
			{
				return false;
			}
	}

	public function get_record_by_upload_id($upload_id){
		$this->db->where('ss_aw_institution_user_upload_id', $upload_id);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}

	public function get_all_institutional_users($parent_id = array()){
		if (!empty($parent_id)) {
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			return $this->db->get($this->table)->result();	
		}
	}

	public function check_institution_users_deleted_or_not($parent_id = array()){
		if (!empty($parent_id)) {
			$this->db->where('ss_aw_child_delete', 0);
			$this->db->where_in('ss_aw_parent_id', $parent_id);
			return $this->db->get($this->table)->num_rows();	
		}
		else{
			return 0;
		}
	}

	public function remove_multiple_child($child_id = array()){
		$this->db->where_in('ss_aw_child_id', $child_id);
		$this->db->set('ss_aw_child_delete', 1);
		$this->db->set('ss_aw_child_status', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function get_winners_by_upload_id($upload_id){
		$this->db->where('ss_aw_institution_user_upload_id', $upload_id);
		$this->db->where('ss_aw_child_username !=', null);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}

	public function get_masters_by_upload_id($upload_id){
		$this->db->where('ss_aw_institution_user_upload_id', $upload_id);
		$this->db->where('ss_aw_child_username', null);
		$this->db->where('ss_aw_child_delete', 0);
		return $this->db->get($this->table)->result();
	}

	public function remove_multiple_child_by_parent_id($parent_id = array()){
		$this->db->where_in('ss_aw_parent_id', $parent_id);
		$this->db->set('ss_aw_child_delete', 1);
		$this->db->set('ss_aw_child_status', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function get_childs_by_ary($childary = array()){
		$this->db->where_in('ss_aw_child_id', $childary);
		return $this->db->get($this->table)->result();
	}

	public function get_programee_users($parent_id = array(), $programme_type, $limit = 0, $start = 0, $institution_list = 0){
		if (!empty($parent_id)) {
			$this->db->select($this->table.'.*, ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date');
			$this->db->from($this->table);
			$this->db->join('ss_aw_diagonastic_exam','ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = '.$this->table.'.ss_aw_child_id','left');
			$this->db->join('ss_aw_child_course','ss_aw_child_course.ss_aw_child_id = '.$this->table.'.ss_aw_child_id');
			$this->db->where('ss_aw_child_course.ss_aw_course_id', $programme_type);
			if ($institution_list) {
				$this->db->where($this->table.'.ss_aw_child_status', 1);
			}
			$this->db->where($this->table.'.ss_aw_child_delete', 0);
			$this->db->where_in($this->table.'.ss_aw_parent_id', $parent_id);
			if ($programme_type == 5) {
				$this->db->where($this->table.'.ss_aw_child_username', null);
			}
			else{
				$this->db->where($this->table.'.ss_aw_child_username !=', null);
			}
			$this->db->group_by($this->table.'.ss_aw_child_id');
			$this->db->order_by($this->table.'.ss_aw_child_id');
			if (!empty($limit)) {
				$this->db->limit($limit, $start);
			}
			return $this->db->get()->result();	
		}
	}

	public function get_programee_users_count($parent_id = array(), $programme_type, $institution_list = 0){
		if (!empty($parent_id)) {
			$this->db->select($this->table.'.*, ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date');
			$this->db->from($this->table);
			$this->db->join('ss_aw_diagonastic_exam','ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = '.$this->table.'.ss_aw_child_id','left');
			$this->db->join('ss_aw_child_course','ss_aw_child_course.ss_aw_child_id = '.$this->table.'.ss_aw_child_id');
			$this->db->where('ss_aw_child_course.ss_aw_course_id', $programme_type);
			if ($institution_list) {
				$this->db->where($this->table.'.ss_aw_child_status', 1);
			}
			$this->db->where($this->table.'.ss_aw_child_delete', 0);
			$this->db->where_in($this->table.'.ss_aw_parent_id', $parent_id);
			if ($programme_type == 5) {
				$this->db->where($this->table.'.ss_aw_child_username', null);
			}
			else{
				$this->db->where($this->table.'.ss_aw_child_username !=', null);
			}
			$this->db->group_by($this->table.'.ss_aw_child_id');
			return $this->db->get()->num_rows();	
		}
	}

	public function get_childs_by_ary_with_parent_lesson($childary = array()) {
        
       $this->db->select('cl.*,ai.ss_aw_name institution_name,ap.ss_aw_parent_full_name parent_name');
        $this->db->from($this->table.' cl');
        $this->db->join('ss_aw_institution_student_upload su','su.ss_aw_id=cl.ss_aw_institution_user_upload_id','left');
        $this->db->join('ss_aw_institutions ai','ai.ss_aw_id=su.ss_aw_institution_id','left');
        $this->db->join('ss_aw_parents ap','ap.ss_aw_parent_id=cl.ss_aw_parent_id','left');
         $this->db->where_in('cl.ss_aw_child_id', $childary);
        return $this->db->get()->result();
    }

    public function get_emi_paid_users(){
    	$query = "SELECT ss_aw_child_course.*, ss_aw_parents.ss_aw_parent_email as parent_email, ss_aw_childs.ss_aw_child_first_name as first_name, ss_aw_childs.ss_aw_child_last_name as last_name, ss_aw_childs.ss_aw_child_nick_name as nick_name, ss_aw_childs.ss_aw_child_username as username, ss_aw_childs.ss_aw_child_gender as gender, (SELECT count(*) FROM ss_aw_child_course cc WHERE cc.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id AND cc.ss_aw_course_id = ss_aw_child_course.ss_aw_course_id) as emi_paid_num FROM ss_aw_child_course INNER JOIN (SELECT MIN(ss_aw_child_course_id) as id FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_course_payemnt_type = 1 GROUP BY ss_aw_child_id) first_payment ON first_payment.id = ss_aw_child_course.ss_aw_child_course_id JOIN ss_aw_childs ON ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id JOIN ss_aw_parents ON ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id WHERE ss_aw_childs.ss_aw_institution_user_upload_id = 0";
    	return $this->db->query($query)->result();
    }

    public function get_emi_paid_institution_users(){
    	$query = "SELECT ss_aw_child_course.*, ss_aw_parents.ss_aw_institution as institution_id, ss_aw_childs.ss_aw_child_first_name as first_name, ss_aw_childs.ss_aw_child_last_name as last_name, ss_aw_childs.ss_aw_child_nick_name as nick_name, ss_aw_childs.ss_aw_child_username as username, ss_aw_childs.ss_aw_child_gender as gender, (SELECT count(*) FROM ss_aw_child_course cc WHERE cc.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id AND cc.ss_aw_course_id = ss_aw_child_course.ss_aw_course_id) as emi_paid_num FROM ss_aw_child_course INNER JOIN (SELECT MIN(ss_aw_child_course_id) as id FROM ss_aw_child_course WHERE ss_aw_child_course.ss_aw_course_payemnt_type = 1 GROUP BY ss_aw_child_id) first_payment ON first_payment.id = ss_aw_child_course.ss_aw_child_course_id JOIN ss_aw_childs ON ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id JOIN ss_aw_parents ON ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id WHERE ss_aw_childs.ss_aw_institution_user_upload_id != 0";
    	return $this->db->query($query)->result();
    }

    public function get_child_details_with_age($child_id){
        $query="Select TIMESTAMPDIFF(YEAR,
        DATE(ac.ss_aw_child_dob),
        DATE(cc.ss_aw_child_course_create_date))child_age from ss_aw_child_course cc "
                . "join ss_aw_childs ac on ac.ss_aw_child_id=cc.ss_aw_child_id "
                . "where cc.ss_aw_child_id='$child_id' "
                . "group by cc.ss_aw_child_id order by cc.ss_aw_child_course_id ";
        return $this->db->query($query)->row();
    }

    public function get_all_childs($parent_id){
    	$this->db->where('ss_aw_parent_id', $parent_id);
    	return $this->db->get($this->table)->result();
    }

    public function get_programee_users_readalong($parent_id = array(), $programme_type, $only_active_users_log = 0) {
        if (!empty($parent_id)) {
            $this->db->select($this->table . ".*, ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date,"
                    . "(select count(lr.ss_aw_id) from ss_aw_last_readalong lr where lr.ss_aw_child_id=". $this->table . ".ss_aw_child_id group by lr.ss_aw_child_id)count_readalong");
            $this->db->from($this->table);
            $this->db->join('ss_aw_diagonastic_exam', 'ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = ' . $this->table . '.ss_aw_child_id', 'left');
            $this->db->join('ss_aw_child_course', 'ss_aw_child_course.ss_aw_child_id = ' . $this->table . '.ss_aw_child_id');
            $this->db->where('ss_aw_child_course.ss_aw_course_id', $programme_type);
            if ($only_active_users_log) {
            	$this->db->where($this->table.'.ss_aw_child_status', 1);
            }
            $this->db->where($this->table . '.ss_aw_child_delete', 0);
            $this->db->where_in($this->table . '.ss_aw_parent_id', $parent_id);
            if ($programme_type == 5) {
                $this->db->where($this->table . '.ss_aw_child_username', null);
            } else {
                $this->db->where($this->table . '.ss_aw_child_username !=', null);
            }
            $this->db->group_by($this->table . '.ss_aw_child_id');
            $this->db->order_by($this->table . '.ss_aw_child_id');           
            return $this->db->get()->result();
        }
    } 
    
    public function getallreadalongdetails($child_id){
        $this->db->select("ru.ss_aw_id,ru.ss_aw_title,ru.ss_aw_topic,lr.ss_aw_create_date, (select count(*) from ss_aw_readalong_quiz_ans where ss_aw_readalong_quiz_ans.ss_aw_child_id = $child_id and ss_aw_readalong_quiz_ans.ss_aw_readalong_id = lr.ss_aw_readalong_id) as total_question, (select count(*) from ss_aw_readalong_quiz_ans where ss_aw_readalong_quiz_ans.ss_aw_child_id = $child_id and ss_aw_readalong_quiz_ans.ss_aw_readalong_id = lr.ss_aw_readalong_id and ss_aw_readalong_quiz_ans.ss_aw_quiz_right_wrong = 1) as right_answer");
        $this->db->from("ss_aw_last_readalong lr");
        $this->db->join("ss_aw_readalongs_upload ru","ru.ss_aw_id=lr.ss_aw_readalong_id","left");
        $this->db->where("lr.ss_aw_child_id",$child_id);
        return $this->db->get()->result_array();
        
    }
}
