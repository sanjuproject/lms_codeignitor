<?php
/**
 * 
 */
class Ss_aw_institution_student_upload_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_institution_student_upload";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_records(){
		$this->db->where('ss_aw_deleted', 0);
		return $this->db->get($this->table)->result();
	}

	public function update_record($data, $id){
		$this->db->where('ss_aw_id', $id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function remove_record($record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->delete($this->table);
	}

	public function get_record_by_id($record_id){
		$this->db->where('ss_aw_id', $record_id);
		return $this->db->get($this->table)->row();
	}

	public function get_institution_upload_records($institution_id){
		$this->db->where('ss_aw_deleted', 0);
		$this->db->where('ss_aw_institution_id', $institution_id);
		return $this->db->get($this->table)->result();
	}

	public function update_emi_count($upload_id, $data){
		$this->db->where('ss_aw_id', $upload_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function file_soft_delete($file_id){
		$this->db->where('ss_aw_id', $file_id);
		$this->db->set('ss_aw_deleted', 1);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}
}