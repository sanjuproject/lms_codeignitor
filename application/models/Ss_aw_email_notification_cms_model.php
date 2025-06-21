<?php
  class Ss_aw_email_notification_cms_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_email_notification_cms";
	}
	public function fetch_all_record()
	{
		$this->db->order_by("ss_aw_template_name", "asc");
		return $this->db->get($this->table)->result();
	}
	public function update_records_byid($id,$update_array)
	{
		$this->db->where('ss_aw_email_temp_id',$id)->update($this->table,$update_array);
		return true;
	}
	public function fetch_record_byid($id)
	{
		return $this->db->where('ss_aw_email_temp_id',$id)->where('ss_aw_email_temp_status', 1)->get($this->table)->result();
	}

	public function fetch_data_by_id($id){
		return $this->db->where('ss_aw_email_temp_id',$id)->get($this->table)->result();
	}
}	
