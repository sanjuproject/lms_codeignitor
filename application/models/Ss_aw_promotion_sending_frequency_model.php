<?php
/**
 * 
 */
class Ss_aw_promotion_sending_frequency_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_promotion_sending_frequency";
	}

	public function update_record($data){
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function get_record(){
		return $this->db->get($this->table)->result();
	}
}