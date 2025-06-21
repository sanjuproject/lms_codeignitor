<?php
/**
 * 
 */
class Ss_aw_store_readalong_page_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_store_readalong_page";
	}

	public function store_page_index($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_page_index($child_id, $readalong_id, $parent_id = ""){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		//parent id needed only for demo users
		if (!empty($parent_id)) {
			$this->db->where('ss_aw_parent_id', $parent_id);
		}
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function get_first_start_details($child_id, $readalong_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		$this->db->order_by('ss_aw_id','asc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}
}