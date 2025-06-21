<?php
/**
 * 
 */
class Ss_aw_external_contact_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_external_contacts";
	}

	public function check_data($email, $phone){
		$this->db->where('ss_aw_email', $email);
		$this->db->where('ss_aw_phone', $phone);
		return $this->db->get($this->table)->num_rows();
	}

	public function add_contact($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update_data($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getuserbyuploadid($upload_id){
		$this->db->where('ss_aw_upload_id', $upload_id);
		return $this->db->get($this->table)->result();
	}

	public function get_all_user(){
		return $this->db->get($this->table)->result();
	}

	public function getuserbyuploadidary($upload_id_ary = array()){
		$this->db->where_in('ss_aw_upload_id', $upload_id_ary);
		return $this->db->get($this->table)->result();
	}
}