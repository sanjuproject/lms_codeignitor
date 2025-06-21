<?php
/**
 * 
 */
class State_master_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "state_master";
	}

	public function getstatelistbycountry($country_id){
		$this->db->select('state_master.*, country_master.phonecode');
		$this->db->from($this->table);
		$this->db->join('country_master','country_master.id = state_master.country_id');
		$this->db->where('state_master.country_id', $country_id);
		return $this->db->get()->result();
	}
}