<?php
  class Ss_aw_faq_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_faq";
	}

	public function insert_data($data)
	{
		$this->db->insert($this->table,$data);
		return true;
	}
	public function number_of_records($faq_search_data)
	{
		if($faq_search_data!="")
		{ 
			$this->db->group_start();
			$this->db->like('faq_question', $faq_search_data);
			$this->db->or_like('faq_answer', $faq_search_data);
			$this->db->group_end();
		}
		return $this->db->get($this->table)->num_rows();
	}
	 public function get_all_faq($limit,$start,$faq_search_data)
	 {
	 	if($faq_search_data!="")
		{
			$this->db->group_start();
			$this->db->like('faq_question', $faq_search_data);
			$this->db->or_like('faq_answer', $faq_search_data);
			$this->db->group_end();
		}
	 	$this->db->limit($limit,$start);
	 	return $this->db->get($this->table)->result();
	 }
	 public function update_faq($faq_id,$update_array)
	 {
	 	$this->db->where('faq_id',$faq_id)->update($this->table,$update_array);
	 	return true;
	 }
	 public function delete_faqbyid($faq_id)
	 {
	 	$this->db->where('faq_id',$faq_id)->delete($this->table);
	 	return true;
	 }
	 public function get_all_records()
	 {
	 	return $this->db->where('faq_status','1')->get($this->table)->result();
	 }
	 public function get_recordby_usertype($user_type){
	 	$this->db->where('faq_user_type', $user_type);
	 	$this->db->where('faq_status', 1);
	 	return $this->db->get($this->table)->result();
	 }

	 public function getdatabyid($id){
	 	$this->db->where('faq_id', $id);
	 	return $this->db->get($this->table)->result();
	 }


}	