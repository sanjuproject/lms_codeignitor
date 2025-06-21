<?php
/**
 * 
 */
class Ss_aw_current_lesson_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_current_lesson";
	}
	
	public function fetchall()
	{
		return $this->db->get($this->table)->result_array();
	}
	
	public function insert_data($data)
	{
       $this->db->insert($this->table,$data);
	   return 1;
	}
	public function update_record($dataary)
	{
		$this->db->where('ss_aw_lesson_id',$dataary['ss_aw_lesson_id'])->where('ss_aw_child_id',$dataary['ss_aw_child_id'])->update($this->table,$dataary);
		return $this->db->affected_rows();
	}
	
	public function fetch_record_byparam($search_data = array())
	{
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
	    return $this->db->get($this->table)->result_array();
		
	}
	
	public function deleterecord_child($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}
}