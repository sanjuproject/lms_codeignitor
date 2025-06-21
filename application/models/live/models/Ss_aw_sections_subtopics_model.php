<?php
/**
 * 
 */
class Ss_aw_sections_subtopics_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_sections_subtopics";
	}
	public function get_topiclist_bylevel($level)
	{
		$where = "FIND_IN_SET('".$level."', ss_aw_expertise_level)"; 
		return $this->db->where($where)->order_by('ss_aw_section_id','ASC')->get($this->table)->result_array();
	}
	
	public function fetchall()
	{
		return $this->db->where('ss_aw_subtopic_deleted',1)->get($this->table)->result_array();
	}
	
	public function number_of_records($search_data = array())
	{
		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}
		$this->db->where('ss_aw_subtopic_deleted','1');
	    
		return $this->db->get($this->table)->num_rows();
	}

	public function get_all_records($limit,$start,$search_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_section_title as topic_title');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_topic_id','left');
		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}	
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_subtopic_deleted','1');		
		return $this->db->get($this->table)->result();
	}

	public function get_records_by_topic_id($limit,$start,$search_data = array()){
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_section_title as topic_title');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_topic_id','left');
		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				if ($key == 'ss_aw_topic_id') {
					$this->db->where($this->table.'.ss_aw_topic_id', $value);
				}
				else
				{
					$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
				}
			}
		}	
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_subtopic_deleted','1');		
		return $this->db->get($this->table)->result();
	}
	
	public function insert_data($data)
	{
		$this->db->insert($this->table,$data);
		return true;
	}
	
	public function update_record($param)
	{
		foreach($param as $key=>$value)
		{
			if($key !='ss_aw_subtopic_deleted' && $key !='status' && $key !='ss_aw_section_status' && $key !='ss_aw_section_title' && $key !='status')
				$this->db->where("`".$key."`", $value);
		}
		
		if(!empty($param['ss_aw_subtopic_deleted']))
		{
			$this->db->set('ss_aw_subtopic_deleted',0);
		}
		else if(!empty($param['status']))
		{
			$this->db->set('ss_aw_section_status',$param['ss_aw_section_status']);
		}
		$this ->db->update($this->table,$param);
	}

	public function get_details_byparam($search_data = array())
	{
		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where("`".$key."`",$value);
			}
		}
		$this->db->where('ss_aw_subtopic_deleted','1');
		return $this->db->get($this->table)->result_array();
	}

	public function totalnoofsubtopic($topic_id){
		$this->db->where('ss_aw_topic_id', $topic_id);
		$this->db->where('ss_aw_subtopic_deleted','1');
		return $this->db->get($this->table)->num_rows();
	}
}