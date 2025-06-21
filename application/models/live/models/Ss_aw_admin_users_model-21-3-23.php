<?php
  class Ss_aw_admin_users_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_admin_users";
	}

	public function search_byparam($data = array())
	{
		$this->db->select('*');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				if($key == 'search_value')
				{
					$this->db->group_start(); // Open bracket
					$this->db->or_like('ss_aw_admin_user_full_name',$val,'both');
					$this->db->or_like('ss_aw_admin_user_mobile_no',$val,'both');
					$this->db->or_like('ss_aw_admin_user_email',$val,'both');
					$this->db->group_end(); // close bracket
				}
				else if($key == 'selected_roles')
				{
					foreach($val as $id)
					{					
					//$this->db->where('find_in_set(ss_aw_admin_user_role_ids,"'.$val.'") <> 0');					
					$this->db->where('find_in_set("'.$id.'", ss_aw_admin_user_role_ids) <> 0');
					}
				}
				else
				{
					$this->db->where($key,$val);
				}
			}
		}
		$this->db->where('ss_aw_admin_user_deleted',0);
		return $this->db->get()->result_array();
	}
	
	public function update_details($data)	
	{
		$this->db->where('ss_aw_admin_user_id',$data['ss_aw_admin_user_id']);
		$this->db->update($this->table, $data );
		$count = $this->db->affected_rows();
		if($count==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	public function data_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
}
