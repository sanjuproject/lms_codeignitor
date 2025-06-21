<?php
/**
 * 
 */
class Ss_aw_vocabulary_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_vocabulary";
	}

	public function store_data($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function total_record($searched_word = ""){
		if ($searched_word != "") {
			$this->db->like('word', $searched_word);
		}
		$this->db->where('is_delete', 0);
		return $this->db->get($this->table)->num_rows();
	}

	public function getlimitedrecord($searched_word = "", $limit, $start){
		if ($searched_word != "") {
			$this->db->like('word', $searched_word);
		}
		$this->db->where('is_delete', 0);
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	public function update_data($data){
		$this->db->where('id', $data['id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getdefinationbyword($word){
		$this->db->where('word', $word);
		$this->db->where('is_delete', 0);
		return $this->db->get($this->table)->result();
	}

	public function check_data($word){
		$this->db->where('word', $word);
		$this->db->where('is_delete', 0);
		return $this->db->get($this->table)->result();
	}

	public function check_except_id($word, $id){
		$this->db->where('word', $word);
		$this->db->where('is_delete', 0);
		$this->db->where('id !=', $id);
		return $this->db->get($this->table)->result();
	}
}