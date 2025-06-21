<?php
  class Ss_aw_currencies_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_currencies";
	}
	public function get_all_currency()
	{
		return $this->db->get($this->table)->result();
	}

}