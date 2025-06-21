<?php
/**
 * 
 */
class Ss_aw_reporting_collection_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_reporting_collection";
	}

	public function store_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getalldata($month, $year){
		$this->db->select('ss_aw_reporting_collection.*,ss_aw_parents.ss_aw_parent_full_name,ss_aw_parents.ss_aw_parent_address,ss_aw_parents.ss_aw_parent_city,ss_aw_parents.ss_aw_parent_state,ss_aw_parents.ss_aw_parent_pincode,ss_aw_parents.ss_aw_parent_country');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_reporting_collection.ss_aw_parent_id');
		$this->db->where('MONTH(ss_aw_reporting_collection.ss_aw_created_at)', $month);
		$this->db->where('YEAR(ss_aw_reporting_collection.ss_aw_created_at)', $year);
		return $this->db->get()->result();
	}

	public function getalladvancereceiptsdata($date){
		$month = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		$this->db->select('ss_aw_reporting_collection.*,ss_aw_parents.ss_aw_parent_full_name,ss_aw_parents.ss_aw_parent_address,ss_aw_parents.ss_aw_parent_city,ss_aw_parents.ss_aw_parent_state,ss_aw_parents.ss_aw_parent_pincode,ss_aw_parents.ss_aw_parent_country,(ss_aw_reporting_collection.ss_aw_invoice_amount - ss_aw_reporting_revenue.ss_aw_invoice_amount) as invoice_amount');
		$this->db->from($this->table);
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_reporting_collection.ss_aw_parent_id');
		$this->db->join('ss_aw_reporting_revenue','ss_aw_reporting_revenue.ss_aw_parent_id = ss_aw_reporting_collection.ss_aw_parent_id');
		$this->db->where('MONTH(ss_aw_reporting_collection.ss_aw_created_at)', $month);
		$this->db->where('YEAR(ss_aw_reporting_collection.ss_aw_created_at)', $year);
		return $this->db->get()->result();
	}

	public function getdatabylevel($course_id, $parent_id){
		$this->db->where('ss_aw_course_id', $course_id);
		$this->db->where('ss_aw_parent_id', $parent_id);
		return $this->db->get($this->table)->result();
	}

	public function getlastemicollection($course_id, $parent_id){
		$this->db->where('ss_aw_course_id', $course_id);
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('ss_aw_payment_type', 1);
		$this->db->order_by('ss_aw_id', 'desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function getparentdatabymonthyear($month, $year, $parent_id){
		$this->db->select('ss_aw_invoice_amount');
		$this->db->from($this->table);
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->where('MONTH(ss_aw_reporting_collection.ss_aw_created_at)', $month);
		$this->db->where('YEAR(ss_aw_reporting_collection.ss_aw_created_at)', $year);
		return $this->db->get()->result();
	}
}