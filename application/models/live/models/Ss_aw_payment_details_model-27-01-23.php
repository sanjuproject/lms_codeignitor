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


}	