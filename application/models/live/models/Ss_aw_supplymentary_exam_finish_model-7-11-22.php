<?php
/**
 * 
 */
class Ss_aw_supplymentary_exam_finish_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_supplymentary_exam_finish";
	}
	public function insert_record($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function fetch_record_byparam($params)
	{
		foreach($params as $key=>$val)
		{
			$this->db->where($key,$val );	
		}
		return $this->db->get($this->table)->result_array();
		
		//$where = "FIND_IN_SET('".$level."', ss_aw_expertise_level)"; 
		//return $this->db->where($where)->order_by('ss_aw_question_asked_id','DESC')->limit(1)->get($this->table)->result_array();
	}
	
	public function deleterecord($id)
	{
		$this -> db -> where('ss_aw_child_id', $id);
		$this -> db -> delete($this->table);
	}
	
}