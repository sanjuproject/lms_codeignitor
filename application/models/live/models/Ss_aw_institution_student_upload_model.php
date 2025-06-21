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
		$this->db->select($this->table.'.*, (select count(*) from ss_aw_institution_payment_details where ss_aw_institution_payment_details.ss_aw_upload_id = ss_aw_institution_student_upload.ss_aw_id) as transaction_count');
		$this->db->from($this->table);
		$this->db->where($this->table.'.ss_aw_id', $record_id);
		return $this->db->get()->row();
	}

	public function get_institution_upload_records($institution_id){
		$this->db->select($this->table.'.*, (select count(*) from ss_aw_institution_payment_details where ss_aw_institution_payment_details.ss_aw_upload_id = ss_aw_institution_student_upload.ss_aw_id) as transaction_count, (select sum(ss_aw_payment_amount) from ss_aw_institution_payment_details where ss_aw_institution_payment_details.ss_aw_upload_id = ss_aw_institution_student_upload.ss_aw_id) as total_paid_amount, (select ss_aw_payment_amount from ss_aw_institution_payment_details where ss_aw_institution_payment_details.ss_aw_upload_id = ss_aw_institution_student_upload.ss_aw_id order by ss_aw_institution_payment_details.ss_aw_id limit 1) as first_paid_amount, ss_aw_institutions.ss_aw_partial_payment');
		$this->db->from($this->table);
		$this->db->join('ss_aw_institutions','ss_aw_institutions.ss_aw_id = '.$this->table.'.ss_aw_institution_id');
		$this->db->where($this->table.'.ss_aw_deleted', 0);
		$this->db->where($this->table.'.ss_aw_institution_id', $institution_id);
		return $this->db->get()->result();
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