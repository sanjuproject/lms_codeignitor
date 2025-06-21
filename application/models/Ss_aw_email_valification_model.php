<?php
/**
 * 
 */
class Ss_aw_email_valification_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_email_valification";
	}
	public function check_data_param($param)
	{
		foreach($param as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		return $this->db->get($this->table)->result();
	}
	 public function update_record($error_status,$error_message)
	 {
	 	$this->db->where('ss_aw_error_status',$error_status)->set('ss_aw_error_msg',$error_message)->update($this->table);
	 	return true;
	 }
	 
	 public function insert_data($data)
	{
		$this->db->insert($this->table,$data);
		return true;
	}
	
	public function delete_record($id)
	{
		$this -> db -> where('ss_aw_user_id', $id);
		$this -> db -> delete($this->table);
	}
	
	public function delete_record_by_email($email)
	{
		$this -> db -> where('ss_aw_email', $email);
		$this -> db -> delete($this->table);
	}
}