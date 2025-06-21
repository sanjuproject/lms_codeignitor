<?php
  class Ss_aw_adminmenus_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_adminmenus";
	}

	public function search_byparam($data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_roles_category.ss_aw_admin_role_title');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$this->db->where($key,$val);
			}
		}
		$this->db->join(' ss_aw_roles_category',$this->table.'.ss_aw_role_category =  ss_aw_roles_category.ss_aw_admin_role_id','left');
		$this->db->order_by('order_value','ASC');
		return $this->db->get()->result_array();
	}
	
	
}
