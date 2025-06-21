<?php
/**
 * 
 */
class Ss_aw_institutions_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_institutions";
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function check_duplicate($institution_name, $record_id = ""){
		$this->db->where('ss_aw_name', $institution_name);
		$this->db->where('ss_aw_deleted', 0);
		if (!empty($record_id)) {
			$this->db->where('ss_aw_id !=', $record_id);
		}
		return $this->db->get($this->table)->num_rows();
	}

	public function number_of_records($filter_data = array()){
		$this->db->select($this->table.'.*, ss_aw_countries.name as country, ss_aw_states.name as state');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_institution = '.$this->table.'.ss_aw_id');
		$this->db->join('ss_aw_countries','ss_aw_countries.id = '.$this->table.'.ss_aw_country');
		$this->db->join('ss_aw_states','ss_aw_states.id = '.$this->table.'.ss_aw_state');
		$query = "((select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id and ss_aw_childs.ss_aw_child_username IS null) = 0)";
		$this->db->where($query);
		$this->db->where($this->table.'.ss_aw_deleted', 0);
		if (!empty($filter_data)) {
			$this->db->group_start();
			$this->db->like($this->table.'.ss_aw_name', $filter_data['search_data']);
			$this->db->or_like('ss_aw_parents.ss_aw_parent_full_name', $filter_data['search_data']);
			$this->db->or_like('ss_aw_parents.ss_aw_parent_email', $filter_data['search_data']);
			$this->db->group_end();
		}
		return $this->db->get()->num_rows();
	}

	public function get_all_records($limit, $start, $filter_data = array()){
		$this->db->select($this->table.'.*, ss_aw_countries.name as country, ss_aw_states.name as state, ss_aw_parents.ss_aw_parent_full_name, ss_aw_parents.ss_aw_parent_email, ss_aw_parents.ss_aw_parent_id');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_institution = '.$this->table.'.ss_aw_id');
		$this->db->join('ss_aw_countries','ss_aw_countries.id = '.$this->table.'.ss_aw_country');
		$this->db->join('ss_aw_states','ss_aw_states.id = '.$this->table.'.ss_aw_state');
		$query = "((select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id and ss_aw_childs.ss_aw_child_username IS null) = 0)";
		$this->db->where($query);
		$this->db->where($this->table.'.ss_aw_deleted', 0);
		if (!empty($filter_data)) {
			$this->db->group_start();
			$this->db->like($this->table.'.ss_aw_name', $filter_data['search_data']);
			$this->db->or_like('ss_aw_parents.ss_aw_parent_full_name', $filter_data['search_data']);
			$this->db->or_like('ss_aw_parents.ss_aw_parent_email', $filter_data['search_data']);
			$this->db->group_end();
		}
		$this->db->limit($limit, $start);
		return $this->db->get()->result();
	}

	public function update_record($data = array(), $record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function get_record_by_id($record_id){
		$this->db->select('ss_aw_institutions.*, ss_aw_countries.name as country_name, ss_aw_states.name as state_name');
		$this->db->from($this->table);
		$this->db->join('ss_aw_countries','ss_aw_countries.id = ss_aw_institutions.ss_aw_country','left');
		$this->db->join('ss_aw_states','ss_aw_states.id = ss_aw_institutions.ss_aw_state','left');
		$this->db->where('ss_aw_institutions.ss_aw_id', $record_id);
		return $this->db->get()->row();
	}

	public function get_institution_coupon($payment_type, $institution_id, $program_type){
		$this->db->select('ss_aw_coupons.ss_coupon_code as coupon_code');
		$this->db->from($this->table);
		$this->db->where('ss_aw_institutions.ss_aw_id', $institution_id);
		if ($payment_type == 1) {
			if ($program_type == 1) {
				$this->db->join('ss_aw_coupons','ss_aw_institutions.ss_aw_coupon_code_lumpsum = ss_aw_coupons.ss_aw_id');
			}
			elseif ($program_type == 2) {
				$this->db->join('ss_aw_coupons','ss_aw_institutions.ss_aw_coupon_code_lumpsum_masters = ss_aw_coupons.ss_aw_id');
			}
			else{
				$this->db->join('ss_aw_coupons','ss_aw_institutions.ss_aw_coupon_code_lumpsum_champions = ss_aw_coupons.ss_aw_id');
			}
		}
		else{
			if ($program_type == 1) {
				$this->db->join('ss_aw_coupons','ss_aw_institutions.ss_aw_coupon_code_emi = ss_aw_coupons.ss_aw_id');
			}
			elseif ($program_type == 2) {
				$this->db->join('ss_aw_coupons','ss_aw_institutions.ss_aw_coupon_code_emi_masters = ss_aw_coupons.ss_aw_id');
			}
			else{
				$this->db->join('ss_aw_coupons','ss_aw_institutions.ss_aw_coupon_code_emi_champions = ss_aw_coupons.ss_aw_id');
			}
		}
		return $this->db->get()->row();
	}

	public function check_duplicate_mobile($mobile, $record_id = ""){
		$this->db->where('ss_aw_deleted', 0);
		if (!empty($record_id)) {
			$this->db->where('ss_aw_id !=', $record_id);
		}
		$this->db->where('ss_aw_mobile_no', $mobile);
		return $this->db->get($this->table)->num_rows();
	}

	public function check_duplicate_pan($pan_no, $record_id = ""){
		$this->db->where('ss_aw_deleted', 0);
		if (!empty($record_id)) {
			$this->db->where('ss_aw_id !=', $record_id);
		}
		$this->db->where('ss_aw_pan_no', $pan_no);
		return $this->db->get($this->table)->num_rows();
	}

	public function check_duplicate_gst($gst_no, $record_id = ""){
		$this->db->where('ss_aw_deleted', 0);
		if (!empty($record_id)) {
			$this->db->where('ss_aw_id !=', $record_id);
		}
		$this->db->where('ss_aw_gst_no', $gst_no);
		return $this->db->get($this->table)->num_rows();
	}

	public function fetch_all(){
		$this->db->where('ss_aw_deleted', 0);
		return $this->db->get($this->table)->result();
	}
}