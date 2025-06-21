<?php
/**
 * 
 */
class Ss_aw_parents_temp_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_parents_temp";
	}
	public function data_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}

	public function email_existance($email){
		$this->db->where('ss_aw_parent_email',$email);		
		$query=$this->db->get($this->table);
		if ($query->num_rows() > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
	public function mobile_existance($mobile){
		$this->db->where('ss_aw_parent_primary_mobile',$mobile);		
		$query=$this->db->get($this->table);
		if ($query->num_rows() > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
	public function activate_account($otp,$email)
	{
		return $this->db->select('*')->where('ss_aw_parent_otp',$otp)->where('ss_aw_parent_email',$email)->get($this->table)->result_array();
	}
	public function delete_parent($email)
	{
		$this->db->where('ss_aw_parent_email',$email)->delete($this->table);
		return true;
	}
   
   public function get_parent_byemail($email)
   {
      return $this->db->where('ss_aw_parent_email',$email)->get($this->table)->result();
   }

   public function update_otp($otp,$email,$current_date)
   {
   	$this->db->set('ss_aw_parent_otp',$otp)->set('ss_aw_parent_modified_date',$current_date)->where('ss_aw_parent_email',$email)->update($this->table);
   }

   public function data_modify_time($email)
	{
		return $this->db->select('ss_aw_parent_modified_date')->where('ss_aw_parent_email',$email)->get($this->table)->result_array();
	}
	public function data_update($updateary,$email)
	{
		$this->db->where('ss_aw_parent_email',$email)->update($this->table,$updateary);
	}
	
	public function deleterecord($id)
	{
		$this -> db -> where('ss_aw_parent_id', $id);
		$this -> db -> delete($this->table);
	}

}	