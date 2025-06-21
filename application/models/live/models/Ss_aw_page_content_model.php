<?php
/**
 * 
 */
class Ss_aw_page_content_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_page_content";
	}
	public function get_page_data($page_id)
	{
		return $this->db->where('page_id',$page_id)->get($this->table)->result_array();
	}
	public function update_page_content($page_id,$update_data)
	{
		$this->db->where('page_id',$page_id)->update($this->table,$update_data);
	}
}