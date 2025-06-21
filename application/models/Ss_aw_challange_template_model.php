<?php

class Ss_aw_challange_template_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

// Your own constructor code
		$this->table = "ss_aw_challange_template";
	}

	//get: all Quiz Challange list
	public function quiz_challange_template_list()	
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.challange_template_status', 1);
		$this->db->order_by('ss_aw_challange_template_id','ASC');
		return $this->db->get()->result();
	}

	
}
