<?php

class Ss_aw_challange_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

// Your own constructor code
		$this->table = "ss_aw_challange";
	}

//Add: upload Quiz Challange
	public function answer_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}

	//get: all Quiz Challange list
	public function quiz_challange_list()	
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.challange_status', 1);
		$this->db->order_by('ss_aw_challange_id ','ASC');
		return $this->db->get()->result();
	}

	public function quiz_challange_view($id)	
	{
		$this->db->where('ss_aw_challange_id ',$id);
		$this->db->where('challange_status',1);
		$result=$this->db->get($this->table)->row();
		return $result;
	}

	public function remove_record($id){
		$this->db->where('ss_aw_challange_id', $id);
		$this->db->delete($this->table);
	}

	public function update_answer($data, $id){
		$this->db->where('ss_aw_challange_id', $id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function month_wise_list()	
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.challange_status', 1);
		$this->db->where($this->table.'.is_draft', 0);
		$this->db->order_by('challange_post_date','DESC');
		return $this->db->get()->result();
	}

	public function quiz_challange_list_last_id()	
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.challange_status', 1);
		$this->db->where($this->table.'.is_draft', 0);
		$this->db->order_by('ss_aw_challange_id ','DESC');
		$this->db->limit(1);
		return $this->db->get()->result();
	}

	public function get_report_details(){
		$this->db->select('ss_aw_challange.*, (select count(*) from ss_aw_challange_log where ss_aw_challange_log.ss_aw_challange_id = ss_aw_challange.ss_aw_challange_id) as total_attempt, (select count(*) from ss_aw_challange_log where ss_aw_challange_log.ss_aw_challange_id = ss_aw_challange.ss_aw_challange_id and ss_aw_challange_log.ss_aw_challange_status = 1) as correct, (select count(*) from ss_aw_challange_log where ss_aw_challange_log.ss_aw_challange_id = ss_aw_challange.ss_aw_challange_id and ss_aw_challange_log.ss_aw_challange_status = 2) as wrong');
		$this->db->from($this->table);
		$this->db->where('challange_status', 1);
		$this->db->where('is_draft', 0);
		return $this->db->get()->result();
	}
}
