<?php
/**
 * 
 */
class Ss_aw_child_result_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_child_result";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function checkrecord($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_level', $level);
		return $this->db->get($this->table)->num_rows();
	}

	public function removerecord($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_level', $level);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function get_resulted_child_details(){
		$this->db->select('ss_aw_child_result.*, ss_aw_childs.ss_aw_child_nick_name, ss_aw_childs.ss_aw_child_gender, ss_aw_childs.ss_aw_device_token as child_token, ss_aw_childs.ss_aw_child_email, ss_aw_parents.ss_aw_parent_full_name, ss_aw_parents.ss_aw_device_token as parent_token, ss_aw_parents.ss_aw_parent_email');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_child_result.ss_aw_child_id');
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('ss_aw_child_result.ss_aw_is_send', 0);
		return $this->db->get()->result();
	}

	public function update_result_send_status($id){
		$this->db->where('ss_aw_id', $id);
		$this->db->set('ss_aw_is_send', 1);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}
}