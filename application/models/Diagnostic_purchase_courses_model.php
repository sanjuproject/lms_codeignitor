<?php
/**
 * 
 */
class Diagnostic_purchase_courses_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "diagnostic_purchase_courses";
	}

    public function data_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
}