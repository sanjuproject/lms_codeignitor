<?php
/**
 * 
 */
class Ss_aw_error_code_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_error_code";
	}
	public function get_msg_by_status($status)
	{
		return $this->db->where('ss_aw_error_status',$status)->get($this->table)->result();
	}
	public function number_of_records($error_search_data)
	{
		if($error_search_data!="")
		{
			$this->db->group_start();
			$this->db->like('ss_aw_error_msg', $error_search_data);
			$this->db->or_like('ss_aw_error_status', $error_search_data);
			$this->db->group_end();
		}
		return $this->db->get($this->table)->num_rows();
	}
	public function get_all_faq($limit,$start,$error_search_data)
	 {
	 	if($error_search_data!="")
		{
			$this->db->group_start();
			$this->db->like('ss_aw_error_msg', $error_search_data);
			$this->db->or_like('ss_aw_error_status', $error_search_data);
			$this->db->group_end();
		}
	 	$this->db->limit($limit,$start);
	 	return $this->db->get($this->table)->result();
	 }
	 public function update_record($error_status,$error_message)
	 {
	 	$this->db->where('ss_aw_error_status',$error_status)->set('ss_aw_error_msg',$error_message)->update($this->table);
	 	return true;
	 }
}