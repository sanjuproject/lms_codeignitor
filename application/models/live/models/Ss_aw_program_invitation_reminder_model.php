<?php

/**
 * 
 */
class Ss_aw_program_invitation_reminder_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_program_invitation_reminder";
	}

	public function checkfirstinvitaion($child_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('type', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function checkregularreminder($child_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('type', 2);
		return $this->db->get($this->table)->num_rows();
	}

	public function add($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getallfirstreminder(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_program_invitation_reminder.child_id');
		$this->db->where('ss_aw_program_invitation_reminder.type', 1);
		return $this->db->get()->result();
	}

	public function getregularlastreminder($child_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('type', 2);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}
}