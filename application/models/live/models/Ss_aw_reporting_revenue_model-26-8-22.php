<?php

/**
 * 
 */
class Ss_aw_reporting_revenue_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_reporting_revenue";
	}

	public function store_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getalldata($month, $year){
		$this->db->select('ss_aw_reporting_revenue.*,ss_aw_parents.ss_aw_parent_full_name,ss_aw_parents.ss_aw_parent_address,ss_aw_parents.ss_aw_parent_city,ss_aw_parents.ss_aw_parent_state,ss_aw_parents.ss_aw_parent_pincode,ss_aw_parents.ss_aw_parent_country');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_reporting_revenue.ss_aw_parent_id');
		$this->db->where('MONTH(ss_aw_reporting_revenue.ss_aw_revenue_date)', $month);
		$this->db->where('YEAR(ss_aw_reporting_revenue.ss_aw_revenue_date)', $year);
		return $this->db->get()->result();
	}

	public function getdatabyparentmonth($parent_id, $month){
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('MONTH(ss_aw_revenue_date)', $month);
		return $this->db->get($this->table)->result();
	}

	public function getdatauptomonth($course_id, $month, $parent_id){
		$this->db->select('SUM(ss_aw_invoice_amount) as invoice_amount, SUM(ss_aw_revenue_count_day) as revenue_count_days');
		$this->db->from($this->table);
		//$this->db->where('ss_aw_course_id', $course_id);
		//$this->db->where('MONTH(ss_aw_revenue_date) <', $month);
		$this->db->where('ss_aw_parent_id', $parent_id);
		return $this->db->get()->result();
	}

	public function removerecordfrommonth($month, $course_id, $parent_id){
		$this->db->where('MONTH(ss_aw_revenue_date) >=', $month);
		$this->db->where('ss_aw_course_id', $course_id);
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function getpreviousleveldaycount($course_id, $parent_id){
		$this->db->select('SUM(ss_aw_revenue_count_day) as previous_level_count');
		$this->db->from($this->table);
		$this->db->where('ss_aw_parent_id', $parent_id);
		return $this->db->get()->result();
	}

	public function getlastemirevenue(){
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('ss_aw_payment_type', 1);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function getalladvancedata($month, $year){
		$this->db->select('ss_aw_reporting_revenue.*,ss_aw_parents.ss_aw_parent_full_name,ss_aw_parents.ss_aw_parent_address,ss_aw_parents.ss_aw_parent_city,ss_aw_parents.ss_aw_parent_state,ss_aw_parents.ss_aw_parent_pincode,ss_aw_parents.ss_aw_parent_country');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_reporting_revenue.ss_aw_parent_id');
		$this->db->where('ss_aw_advance', 1);
		$this->db->where('MONTH(ss_aw_reporting_revenue.ss_aw_revenue_date)', $month);
		$this->db->where('YEAR(ss_aw_reporting_revenue.ss_aw_revenue_date)', $year);
		return $this->db->get()->result();
	}
}