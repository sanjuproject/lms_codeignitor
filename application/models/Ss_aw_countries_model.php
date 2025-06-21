<?php
  class Ss_aw_countries_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_countries";
	}
	 public function get_all_records()
	 {
	 	$this->db->where('status', 1);
	 	return $this->db->get($this->table)->result_array();
	 }


}	