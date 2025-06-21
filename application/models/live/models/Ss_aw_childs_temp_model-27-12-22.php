<?php
  class Ss_aw_childs_temp_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_childs_temp";
	}

	public function add_child($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->delete($this->table);
	}
	
	public function delete_single_child($id)
	{
		$this->db->where('ss_aw_child_temp_id', $id);
		$this->db->delete($this->table);
	}

	public function get_child_by_parent_id($parent_id){
		$this->db->where('ss_aw_parent_id', $parent_id);
		return $this->db->get($this->table)->result();
	}

	public function get_child_details($child_id){
		$this->db->where('ss_aw_child_temp_id', $child_id);
		return $this->db->get($this->table)->result();
	}

	public function get_child_count_by_parent_id($parent_id){
		$this->db->where('ss_aw_parent_id', $parent_id);
		return $this->db->get($this->table)->num_rows();
	}

}
