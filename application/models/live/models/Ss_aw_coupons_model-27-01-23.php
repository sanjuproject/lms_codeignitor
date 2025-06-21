<?php
/**
 * 
 */
class Ss_aw_coupons_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_coupons";
	}

	public function total_record($data = array()){
		if (!empty($data)) {
			if (!empty($data['coupon_code'])) {
				$this->db->like('ss_coupon_code', $data['coupon_code'],'after');
			}

			if (!empty($data['start_date']) && !empty($data['end_date'])) {
				$start_date = date('Y-m-d', strtotime($data['start_date']));
				$end_date = date('Y-m-d', strtotime($data['end_date']));
				$query = "'".$start_date."' BETWEEN `ss_aw_start_date` AND `ss_aw_end_date` OR '".$end_date."' BETWEEN `ss_aw_start_date` AND `ss_aw_end_date`";
				$this->db->where($query);
			}
		}
		$this->db->where('ss_aw_status', 1);
		return $this->db->get($this->table)->num_rows();
	}
	public function add_record($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getlimitedrecord($data = array(), $limit, $start){
		if (!empty($data)) {
			if (!empty($data['coupon_code'])) {
				$this->db->like('ss_coupon_code', $data['coupon_code'],'after');
			}

			if (!empty($data['start_date']) && !empty($data['end_date'])) {
				$start_date = date('Y-m-d', strtotime($data['start_date']));
				$end_date = date('Y-m-d', strtotime($data['end_date']));
				$query = "'".$start_date."' BETWEEN `ss_aw_start_date` AND `ss_aw_end_date` OR '".$end_date."' BETWEEN `ss_aw_start_date` AND `ss_aw_end_date`";
				$this->db->where($query);
			}
		}
		$this->db->where('ss_aw_status', 1);
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	public function checkdefaultcoupon($target_type, $existing_id = ""){
		if($existing_id != ""){
			$this->db->where('ss_aw_id !=', $existing_id);
		}
		$this->db->where('ss_aw_target_audience', $target_type);
		$this->db->where('ss_aw_default', 1);
		$this->db->where('ss_aw_status', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function update_record($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getdetailbyid($id){
		$this->db->where('ss_aw_id', $id);
		return $this->db->get($this->table)->result();
	}

	public function update_multiple_status($record_ids, $data){
		$this->db->where_in('ss_aw_id', $record_ids);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function get_default_coupon_by_target_audience($target_audience){
		$this->db->where('ss_aw_default', 1);
		$this->db->where('ss_aw_target_audience', $target_audience);
		return $this->db->get($this->table)->result();
	}

	public function getnondefaultcoupons(){
		$this->db->where('ss_aw_default', 0);
		$this->db->where('ss_aw_status', 1);
		return $this->db->get($this->table)->result();
	}

	public function check_coupon_availability($coupon_code){
		$current_date = date('Y-m-d');
		$query = "'".$current_date."' BETWEEN ss_aw_start_date and ss_aw_end_date";
		$this->db->where('ss_coupon_code', trim($coupon_code));
		$this->db->where($query);
		return $this->db->get($this->table)->result();
	}

	public function getalltyperecord(){
		$this->db->where('ss_aw_status', 1);
		$this->db->where('ss_aw_target_audience', 3);
		return $this->db->get($this->table)->result();
	}
}