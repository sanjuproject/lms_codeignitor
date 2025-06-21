<?php
  class Ss_aw_payment_details_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_payment_details";
	}

	public function data_insert($data)
	{
		$this->db->insert($this->table,$data);
		return true;
	}
	 public function get_all_records()
	 {
	 	return $this->db->get($this->table)->result();
	 }
	 
	 public function deleterecord_child($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}

	public function get_last_invoice(){
		$this->db->select('ss_aw_payment_invoice');
		$this->db->from($this->table);
		$this->db->order_by('ss_aw_payment_id','desc');
		$this->db->limit(1);
		return $this->db->get()->result();
	}

	public function check_coupon_use($user_id, $coupon_id){
		$this->db->where('ss_aw_discount_coupon', $coupon_id);
		$this->db->where('ss_aw_parent_id', $user_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_details_by_transaction_id($transaction_id){
		$this->db->where('ss_aw_transaction_id', $transaction_id);
		return $this->db->get($this->table)->row();
	}

	public function get_details_by_child_course_id($child_id, $course_id){
		$this->db->select('ss_aw_payment_details.ss_aw_payment_invoice as invoice_number');
		$this->db->from($this->table);
		$this->db->join('ss_aw_purchase_courses','ss_aw_purchase_courses.ss_aw_transaction_id = ss_aw_payment_details.ss_aw_transaction_id');
		$this->db->where('ss_aw_purchase_courses.ss_aw_selected_course_id', $course_id);
		$this->db->where('ss_aw_payment_details.ss_aw_child_id', $child_id);
		return $this->db->get()->result();
	}
}	