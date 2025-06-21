<?php
/**
 * 
 */
class Testingapi_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getchilddetailsbyid($child_id){
		$this->db->select('ss_aw_childs.*, ss_aw_parents.ss_aw_parent_full_name, ss_aw_parents.ss_aw_parent_email, ss_aw_parents.ss_aw_device_token as parent_device_token, ss_aw_parents.ss_aw_parent_id as parent_id');
		$this->db->from('ss_aw_childs');
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('ss_aw_childs.ss_aw_child_id',$child_id);
		return $this->db->get()->result();
	}

	public function getexamcodedetailsbychild($child_id){
		$this->db->where('ss_aw_diagonastic_child_id', $child_id);
		return $this->db->get('ss_aw_diagonastic_exam')->result();
	}

	public function getnullableusernamechilds(){
		$this->db->where('ss_aw_child_username', null);
		return $this->db->get('ss_aw_childs')->result();
	}

	public function getnotverifiedparents(){
		$this->db->where('ss_aw_is_email_verified', 0);
		return $this->db->get('ss_aw_parents')->result();
	}

	public function getzerochildparents(){
		$this->db->select('ss_aw_parents.*');
		$this->db->from('ss_aw_parents');
		$this->db->where('(select count(*) from ss_aw_payment_details where ss_aw_payment_details.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id) = 0');
		return $this->db->get()->result();
	}
}