<?php
/**
 * 
 */
class Ss_aw_create_promotion_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_create_promotion";
	}

	public function add_promotion($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update_promotion($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getlimitedrecord($data = array(), $limit, $start){
		if (!empty($data)) {
			// code...
		}
		$this->db->where('ss_aw_deleted', 1);
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	public function total_record($data = array()){
		if (!empty($data)) {
			// code...
		}
		$this->db->where('ss_aw_deleted', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function remove_record($record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->set('ss_aw_deleted', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function remove_multiple_record($record_id = array()){
		$this->db->where_in('ss_aw_id', $record_id);
		$this->db->set('ss_aw_deleted', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function getdetailsbyid($record_id){
		$this->db->where('ss_aw_id', $record_id);
		return $this->db->get($this->table)->result();
	}

	public function getallnewslettersendnewusers(){
		$this->db->where('ss_aw_contact_type', 1);
		return $this->db->get($this->table)->result();
	}
}