<?php
  class Ss_aw_assessment_subsection_matrix_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assessment_subsection_matrix";
	}

	public function add_child($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	public function deleterecord($id)
	{
		$this -> db -> where('ss_aw_parent_id', $id);
		$this -> db -> delete($this->table);
	}
	public function fetch_details($valueary)
	{
		foreach($valueary as $key=>$value){
			$this->db->where($this->table.'.`'.$key.'`',$value);
		}
		return $this->db->get($this->table)->result_array();
	}
	public function fetch_all_record()
	{
		return $this->db->get($this->table)->result();
	}

	public function update_records_byid($id,$update_array)
	{
		$this->db->where('ss_aw_assessment_matrix_id',$id)->update($this->table,$update_array);
		return true;
	}

}
