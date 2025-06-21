<?php
/**
 * 
 */
class Ss_aw_external_contact_upload_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_external_contacts_upload";
	}

	public function add_contact($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function remove_contact($upload_id){
		$this->db->where('ss_aw_id', $upload_id);
		$this->db->delete($this->table);
	}

	public function get_contact_details(){
		$this->db->select('ss_aw_external_contacts_upload.*, ss_aw_admin_users.ss_aw_admin_user_full_name');
		$this->db->from($this->table);
		$this->db->join('ss_aw_admin_users','ss_aw_external_contacts_upload.ss_aw_upload_by = ss_aw_admin_users.ss_aw_admin_user_id');
		$this->db->order_by('ss_aw_external_contacts_upload.ss_aw_id','desc');
		return $this->db->get()->result();
	}

	public function update_record($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
}