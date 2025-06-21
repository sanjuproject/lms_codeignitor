<?php
/**
 * 
 */
class Ss_aw_parents_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_parents";
	}

	public function check_email($email){
		$this->db->where('ss_aw_parent_email',$email);
		//$this->db->where('ss_aw_parent_status',1);
		$this->db->where('ss_aw_parent_delete',0);
		$query=$this->db->get($this->table);
		if ($query->num_rows() > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
	public function check_mobile($mobile){
		$this->db->where('ss_aw_parent_primary_mobile',$mobile);
		$this->db->where('ss_aw_parent_status',1);
		$this->db->where('ss_aw_parent_delete',0);
		$query=$this->db->get($this->table);
		if ($query->num_rows() > 0) {
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
	public function update_parent_details($data,$parent_id)	
	{
		$this->db->where('ss_aw_parent_id',$parent_id);
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

	public function login_process($email){
		$this->db->where( 'ss_aw_parent_email',$email );
		$this->db->where( 'ss_aw_parent_status',1 );
		$this->db->where('ss_aw_parent_delete',0);	
		$this->db->where('ss_aw_blocked', 0);	
		return $this->db->get($this->table)->result();		
	}
	public function token_update_by_email($email,$token,$device_type = "")
	{
		$this->db->where( 'ss_aw_parent_email',$email );
		$this->db->set('ss_aw_parent_auth_key',$token);
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
	public function get_parent_profile_details($parent_id,$parent_token)
	{

		return $this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_parent_auth_key',$parent_token)->get($this->table)->result();
	}
	public function logout($parent_id)
	{
		
           $this->db->where('ss_aw_parent_id',$parent_id)->set('ss_aw_parent_auth_key','')->set('ss_aw_device_token','')->update($this->table);
           	$count = $this->db->affected_rows();
				if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}
	}

	public function check_parent_existance($parent_id,$parent_token)
	{
		$count=$this->db->where('ss_aw_parent_id',$parent_id)->where('ss_aw_parent_auth_key',$parent_token)->get($this->table)->num_rows();
		if($count==1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	public function password_update($parent_id,$password)
	{
		$this->db->set('ss_aw_parent_password',$password)->where('ss_aw_parent_id',$parent_id)->update($this->table);
			$count = $this->db->affected_rows();
			if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}
	}
	public function forget_password_to_set_code($email,$data)
	{
		$this->db->where('ss_aw_parent_email',$email)->update($this->table,$data);
		$count = $this->db->affected_rows();
			if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}
	}
	public function forget_password_reset($reset_code,$data,$email)
	{
		$this->db->where('ss_aw_parent_reset_code',$reset_code)->where('ss_aw_parent_email',$email)->update($this->table,$data);
		$count = $this->db->affected_rows();
			if ($count > 0) {
					return true;
				}
				else
				{
					return false;
				}
	}

	public function get_parent_profile_detailsbyid($parent_id)
	{
		return $this->db->where('ss_aw_parent_id',$parent_id)->get($this->table)->result();
	}
   
    public function data_modify_time($email)
	{
		return $this->db->select('ss_aw_parent_modified_date')->where('ss_aw_parent_email',$email)->get($this->table)->result_array();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->delete($this->table);
	}

public function deleterecord_byid($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->set('ss_aw_parent_delete',1);
		$this ->db->update($this->table);
	}

	public function number_of_records($search_parent_data)
	{
       
		if($search_parent_data!="")
		{
			$this->db->group_start();
			$this->db->like('ss_aw_parent_full_name', $search_parent_data);
			$this->db->or_like('ss_aw_parent_city', $search_parent_data);
			$this->db->or_like('ss_aw_parent_primary_mobile', $search_parent_data);
			$this->db->or_like('ss_aw_parent_email', $search_parent_data);
			$this->db->group_end();
			
		}
		$this->db->where('ss_aw_institution', 0);
		$this->db->where('ss_aw_parent_delete',0);
		return $this->db->get($this->table)->num_rows();
	}
	public function get_all_records($limit,$start,$search_parent_data)
	{
		
		if($search_parent_data!="")
		{
			
			$this->db->group_start();
			$this->db->like('ss_aw_parent_full_name', $search_parent_data);
			$this->db->or_like('ss_aw_parent_city', $search_parent_data);
			$this->db->or_like('ss_aw_parent_primary_mobile', $search_parent_data);
			$this->db->or_like('ss_aw_parent_email', $search_parent_data);
			$this->db->group_end();

		}		
		$this->db->limit($limit,$start);
		$this->db->where('ss_aw_institution', 0);		
		$this->db->where('ss_aw_parent_delete',0);
		$this->db->order_by('ss_aw_parent_id','desc');		
		return $this->db->get($this->table)->result();
		
		
	}
	public function update_active_status($parent_id,$parent_status)
	{
		$this->db->where('ss_aw_parent_id',$parent_id)->set('ss_aw_parent_status',$parent_status)->update($this->table);
		return true;
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
		$this->db->where('ss_aw_parent_delete',0);
		return $this->db->get()->result_array();
	}

	public function check_email_with_parent($email, $parent_id){
		$this->db->where('ss_aw_parent_email', $email);
		$this->db->where('ss_aw_parent_id !=', $parent_id);
		$this->db->where('ss_aw_parent_delete', 0);
		return $this->db->get($this->table)->num_rows();
	}

	public function check_user($user_id, $token){
		return $this->db->where('ss_aw_parent_id',$user_id)->where('ss_aw_parent_auth_key',$token)->get($this->table)->result();
	}

	public function getallparents(){
		$this->db->where('ss_aw_parent_delete',0);
		return $this->db->get($this->table)->result();
	}

	public function getallnotcoursepurchasedparents(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_parents.ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parents.ss_aw_parent_status', 1);
		$this->db->where('(select count(*) from ss_aw_purchase_courses where ss_aw_purchase_courses.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id) = 0');
		return $this->db->get()->result();
	}

	public function getallcoursepurchasedparents(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_parents.ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parents.ss_aw_parent_status', 1);
		$this->db->where('(select count(*) from ss_aw_purchase_courses where ss_aw_purchase_courses.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id) > 0');
		return $this->db->get()->result();
	}

	public function check_in_parent($parent_id, $child_email){
		$this->db->where('ss_aw_parent_id !=', $parent_id);
		$this->db->where('ss_aw_parent_email', $child_email);
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->limit(1);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_by_date($search_date){
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parent_status', 1);
		$this->db->where('DATE(ss_aw_parent_created_date)', $search_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_by_date_range($search_date, $current_date){
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parent_status', 1);
		$this->db->where('DATE(ss_aw_parent_created_date) >', $search_date);
		$this->db->where('DATE(ss_aw_parent_created_date) <=', $current_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_before_last_seven_days_of_current_date($search_date){
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parent_status', 1);
		$this->db->where('DATE(ss_aw_parent_created_date) <', $search_date);
		$this->db->where('DATE(ss_aw_parent_created_date) >=', '2022-08-01');
		return $this->db->get($this->table)->num_rows();
	}

	public function get_total_parents_up_to_date($current_date){
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parent_status', 1);
		$this->db->where('DATE(ss_aw_parent_created_date) <=', $current_date);
		$this->db->where('DATE(ss_aw_parent_created_date) >=', '2022-08-01');
		return $this->db->get($this->table)->num_rows();
	}

	public function check_email_verified($parent_id, $parent_email){
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('ss_aw_parent_email', $parent_email);
		$this->db->where('ss_aw_is_email_verified', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function check_email_except_own($email, $parent_id){
		$this->db->where('ss_aw_parent_delete', 0);
		$this->db->where('ss_aw_parent_status', 1);
		$this->db->where('ss_aw_parent_email', $email);
		$this->db->where('ss_aw_parent_id !=', $parent_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_institutions_users($institution_id){
		$this->db->where('ss_aw_institution', $institution_id);
		return $this->db->get($this->table)->result();
	}

	public function update_record_by_institution($data = array(), $institution_id){
		$this->db->where('ss_aw_institution', $institution_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function check_email_institution($email){
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_institutions','ss_aw_institutions.ss_aw_id = ss_aw_parents.ss_aw_institution');
		$this->db->where('ss_aw_institutions.ss_aw_status', 1);
		$this->db->where($this->table.'.ss_aw_parent_email', $email);
		$this->db->where($this->table.'.ss_aw_parent_status', 1);
		$this->db->where($this->table.'.ss_aw_parent_delete', 0);
		$this->db->where($this->table.'.ss_aw_institution !=', 0);
		$query = "((select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id and ss_aw_childs.ss_aw_child_username IS null) = 0)";
		$this->db->where($query);
		return $this->db->get()->row();
	}

	public function get_institutions_admin($institution_id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('ss_aw_parents.ss_aw_institution', $institution_id);
		$query = "((select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id and ss_aw_childs.ss_aw_child_username IS null) = 0)";
		$this->db->where($query);
		return $this->db->get()->result();
	}
	public function remove_multiple_parent($parent_id = array()){
		$this->db->where_in('ss_aw_parent_id', $parent_id);
		$this->db->set('ss_aw_parent_delete', 1);
		$this->db->set('ss_aw_parent_status', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}
}