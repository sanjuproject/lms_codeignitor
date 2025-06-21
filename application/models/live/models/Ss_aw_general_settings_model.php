<?php
  class Ss_aw_general_settings_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_general_settings";
	}

	public function update_data($id,$update_array)
	{
		$this->db->where('ss_aw_general_settings_id',$id)->update($this->table,$update_array);

	}

	public function fetch_record()
	{
		return $this->db->get($this->table)->result();
	}



}	