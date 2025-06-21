<?php
/**
 * 
 */
class Ss_aw_manage_coupon_send_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_manage_coupon_send";
	}

	public function checkcouponuses($coupon_id){
		$this->db->where('ss_aw_coupon_id', $coupon_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_send_detailsofuser($user_id, $audience_type){
		$this->db->where('ss_aw_target_audience', $audience_type);
		$this->db->where('ss_aw_user_id', $user_id);
		return $this->db->get($this->table)->result();
	}

	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function check_coupon_assign($coupon_id, $parent_id, $target_audience = ""){
		$this->db->where('ss_aw_coupon_id', $coupon_id);
		$this->db->where('ss_aw_user_id', $parent_id);
		if (!empty($target_audience)) {
			$this->db->where('ss_aw_target_audience', $target_audience);	
		}
		return $this->db->get($this->table)->num_rows();
	}
}