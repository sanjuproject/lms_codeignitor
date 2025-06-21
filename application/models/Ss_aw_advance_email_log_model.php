<?php
/**
 * 
 */
class Ss_aw_advance_email_log_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_advance_email_log";
	}

	public function get_data($search_date = ""){
		if (!empty($search_date)) {
			$this->db->where('DATE(ss_aw_date)', $search_date);
		}
		return $this->db->get($this->table)->result();
	}
}