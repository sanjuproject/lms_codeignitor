<?php
  class Ss_aw_readalongs_topics_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalongs_topics";
	}
	public function number_of_records($search_data = array())
	{
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}
		$this->db->where('ss_aw_topic_deleted','1');
	    return $this->db->get($this->table)->num_rows();
		
	}

	public function get_all_records($limit,$start,$search_data = array())
	{
		$this->db->select($this->table.'.*');
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}	
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_topic_deleted','1');		
		return $this->db->get($this->table)->result();		
		
	}
	public function insert_record($insert_array)
	{
		$this->db->insert($this->table,$insert_array);
	}
	public function update_record($id,$update_array)
	{
		$this->db->where('ss_aw_section_id',$id)->update($this->table,$update_array);
		return $this->db->affected_rows();
		// echo $this->db->last_query();
		// exit();

	}
	
	public function fetch_record_by_level($level)
	{
		$where = "FIND_IN_SET('".$level."', ss_aw_expertise_level)"; 
		return $this->db->where($where)->order_by('ss_aw_section_id','ASC')->get($this->table)->result_array();
	}
	
	public function fetchall()
	{
		return $this->db->where('ss_aw_topic_deleted',1)->where('ss_aw_section_status',1)->order_by('ss_aw_section_id','ASC')->get($this->table)->result_array();
	}

	public function fetch_by_id($id){
		$this->db->where('ss_aw_section_id', $id);
		return $this->db->get($this->table)->result();
	}
}	
