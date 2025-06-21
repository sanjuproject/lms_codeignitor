<?php
/**
 * 
 */
class Ss_aw_refferal_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_refferal";
	}

	public function save_data($data = array()){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all(){
		$this->db->where('ss_aw_deleted', 0);
		$this->db->order_by('ss_aw_id','desc');
		return $this->db->get($this->table)->result();
	}

	public function total_record(){
		$this->db->where('ss_aw_deleted', 0);
		return $this->db->get($this->table)->num_rows();
	}

	public function getlimitedrecord($limit, $start){
		$this->db->where('ss_aw_deleted', 0);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	public function remove_record($record_id){
		$this->db->where('ss_aw_id', $record_id);
		$this->db->set('ss_aw_deleted', 1);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}
}