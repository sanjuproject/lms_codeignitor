<?php
/**
 * 
 */
class Ss_aw_institution_payment_details_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_institution_payment_details";
	}

	public function get_last_record(){
		$this->db->order_by('ss_aw_id','desc');
		return $this->db->get($this->table)->row();
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function check_paid_status($record_id){
		$this->db->where('ss_aw_upload_id', $record_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function gethistory($upload_id){
		$this->db->where('ss_aw_upload_id', $upload_id);
		return $this->db->get($this->table)->result();
	}

	public function get_institution_last_payment($institution_id){
		$this->db->where('ss_aw_institution_id', $institution_id);
		$this->db->order_by('ss_aw_id','desc');
		return $this->db->get($this->table)->row();
	}

	public function get_payment_details($institution_id, $limit, $start){
		$this->db->select($this->table.'.*, ss_aw_institution_student_upload.ss_aw_upload_file_name, ss_aw_institution_student_upload.ss_aw_student_number, ss_aw_institution_student_upload.ss_aw_payment_type');
		$this->db->from($this->table);
		$this->db->join('ss_aw_institution_student_upload','ss_aw_institution_student_upload.ss_aw_id = '.$this->table.'.ss_aw_upload_id');
		$this->db->where($this->table.'.ss_aw_institution_id', $institution_id);
		$this->db->limit($limit, $start);
		return $this->db->get()->result();
	}

	public function total_record($institution_id){
		$this->db->where('ss_aw_institution_id', $institution_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function check_lumpsum_payment($record_id){
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_institution_student_upload','ss_aw_institution_student_upload.ss_aw_id = '.$this->table.'.ss_aw_upload_id');
		$this->db->where($this->table.'.ss_aw_upload_id', $record_id);
		$this->db->where('ss_aw_institution_student_upload.ss_aw_payment_type', 1);
		return $this->db->get()->num_rows();
	}
}