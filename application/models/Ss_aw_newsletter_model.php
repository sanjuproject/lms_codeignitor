<?php
/**
 * 
 */
class Ss_aw_newsletter_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_newsletter";
	}

	public function add_newsletter($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getlimitedrecord($data = array(), $limit, $start){
		if (!empty($data)) {
			$this->db->where('ss_aw_status', $data['status']);
		}
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	public function total_record($data = array()){
		if (!empty($data)) {
			$this->db->where('ss_aw_status', $data['status']);
		}
		return $this->db->get($this->table)->num_rows();
	}

	public function update_record($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function remove_record($record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function getrecordbyid($record_id){
		$this->db->where('ss_aw_id', $record_id);
		return $this->db->get($this->table)->result();
	}

	public function getallnewsletter(){
		$this->db->where('ss_aw_status', 1);
		return $this->db->get($this->table)->result();
	}
}