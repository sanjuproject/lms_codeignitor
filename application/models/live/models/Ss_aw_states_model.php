<?php
  class Ss_aw_states_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_states";
	}
	 public function get_record_by_country($country_id)
	 {
	 	return $this->db->where('country_id',$country_id)->get($this->table)->result_array();
	 }

	 public function getstatelistbycountry($country_id){
		$this->db->select('ss_aw_states.*, ss_aw_countries.phonecode');
		$this->db->from($this->table);
		$this->db->join('ss_aw_countries','ss_aw_countries.id = ss_aw_states.country_id');
		$this->db->where('ss_aw_states.country_id', $country_id);
		return $this->db->get()->result();
	}

	public function getstatelistbycountrysortname($country_name){
		$this->db->where('name', $country_name);
		$response = $this->db->get('ss_aw_countries')->row();
		if (!empty($response)) {
			$country_id = $response->id;
			$this->db->select('ss_aw_states.*, ss_aw_countries.phonecode');
			$this->db->from($this->table);
			$this->db->join('ss_aw_countries','ss_aw_countries.id = ss_aw_states.country_id');
			$this->db->where('ss_aw_states.country_id', $country_id);
			return $this->db->get()->result();	
		}
		else{
			return false;
		}
	}

}	