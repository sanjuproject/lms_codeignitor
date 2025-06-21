<?php
/**
 * 
 */
class Ss_aw_notification_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_notofication";
	}

	public function save_notification($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getallnotification($userid, $usertype){
		$this->db->where('user_id', $userid);
		$this->db->where('user_type', $usertype);
		$this->db->where('status', 1);
		$this->db->order_by('id','desc');
		return $this->db->get($this->table)->result();
	}

	public function update_record($data){
		$this->db->where('id', $data['id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function archivenotification($user_id, $user_type){
		$this->db->where('user_id', $user_id);
		$this->db->where('user_type', $user_type);
		$this->db->set('status', 0);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function countnotification($user_id, $user_type){
		$this->db->where('user_id', $user_id);
		$this->db->where('user_type', $user_type);
		$this->db->where('status', 1);
		$this->db->where('read_unread', 0);
		return $this->db->get($this->table)->num_rows();
	}
}