<?php
/**
 * 
 */
class Ss_aw_institution_menus extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_institution_menus";
	}

	public function get_menus(){
		return $this->db->get($this->table)->row();
	}
}