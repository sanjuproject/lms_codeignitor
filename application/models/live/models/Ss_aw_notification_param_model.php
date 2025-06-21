<?php
/**
 * 
 */
class Ss_aw_notification_param_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_notification_params";
	}

	public function getallparam(){
		return $this->db->get($this->table)->result();
	}
}