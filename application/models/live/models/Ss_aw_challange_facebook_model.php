<?php

class Ss_aw_challange_facebook_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

// Your own constructor code
		$this->table = "ss_aw_challange_facebook";
	}

//Add: upload Quiz Challange
	public function quiz_facebook_image_insert($data)	
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
}
