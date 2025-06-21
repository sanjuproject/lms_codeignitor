<?php
  class Ss_aw_supplymentary_uploaded_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_supplymentary_uploaded";
	}
	public function insert_data($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->last_query();
	}
	public function number_of_records($search_parent_data = array())
	{
		if($search_parent_data!="")
		{
			foreach($search_parent_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}
		$this->db->where('ss_aw_delete','0');
		return $this->db->get($this->table)->num_rows();
	}
	public function get_all_records($limit,$start,$search_parent_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_section_title as title_name');
		if($search_parent_data!="")
		{
			foreach($search_parent_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}	
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_topic','left');
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_delete','0');		
		return $this->db->get($this->table)->result();
	}
	
	public function fetch_all()
	 {
		$this->db->where('ss_aw_delete',0);
		$this->db->order_by('ss_aw_id','ASC');
	 	return $this->db->get($this->table)->result_array();
	 }
	 
	 public function delete_single_record($id)
	{
		$this->db->where('ss_aw_id', $id);
		$this->db->delete($this->table);

	}
	
	public function update_record($datary)
	{
		
		$this->db->where('ss_aw_id', $datary['ss_aw_id']);
	
		$this ->db->update($this->table,$datary);
	}
	
	public function get_courselist_bylevel($level)
	{
		$where = "FIND_IN_SET('".$level."', ss_aw_level)"; 
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_section_title as title_name,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_title ='.$this->table.'.ss_aw_topic','left');
		$this->db->order_by('ss_aw_sections_topics.ss_aw_section_id','asc');
		return $this->db->where($where)->where('ss_aw_delete',0)->where('ss_aw_status',1)->get($this->table)->result_array();
	}

	public function get_supplymentary_details_by_id($id = array()){
		$this->db->where_in('ss_aw_id', $id);
		return $this->db->get($this->table)->result_array();
	}
	
}	