<?php
/**
 * 
 */
class Ss_aw_roles_category_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_roles_category";
	}
	public function insert_record($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function fetch_record_byparam($params = array())
	{
		if(!empty($params))
		{
		foreach($params as $key=>$val)
		{
			$this->db->where($key,$val );	
		}	
		}
		$this->db->order_by('ss_aw_admin_role_id','ASC');
		return $this->db->get($this->table)->result_array();
	}
	
}