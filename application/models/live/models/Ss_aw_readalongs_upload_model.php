<?php
  class Ss_aw_readalongs_upload_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalongs_upload";
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
		$this->db->where('ss_aw_deleted','1');
	    return $this->db->get($this->table)->num_rows();
		
	}
	public function number_of_records_daterange($search_data = array())
	{
	  if(isset($search_data['ss_aw_created_date']))
	  {
	  	$temp_date_array = explode("to", $search_data['ss_aw_created_date']);
		$start_date = trim($temp_date_array[0]);
		$end_date = trim($temp_date_array[1]);
		$this->db->where('ss_aw_created_date >=', $start_date);
		$this->db->where('ss_aw_created_date <=', $end_date);
		unset($search_data['ss_aw_created_date']);
	  }
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}
		$this->db->where('ss_aw_deleted','1');
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
		$this->db->where($this->table.'.ss_aw_deleted','1');		
		return $this->db->get($this->table)->result_array();		
		
	}
	public function get_all_records_daterange($limit,$start,$search_data = array())
	{
		$this->db->select($this->table.'.*');
		if(isset($search_data['ss_aw_created_date']))
		  {
		  	$temp_date_array = explode("to", $search_data['ss_aw_created_date']);
			$start_date = trim($temp_date_array[0]);
			$end_date = trim($temp_date_array[1]);
			$this->db->where('ss_aw_created_date >=', $start_date);
			$this->db->where('ss_aw_created_date <=', $end_date);
			unset($search_data['ss_aw_created_date']);
		  }
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}	
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_deleted','1');		
		return $this->db->get($this->table)->result_array();		
		
	}
	public function insert_record($insert_array)
	{
		$this->db->insert($this->table,$insert_array);
	}
	public function update_record($id,$update_array)
	{
		$this->db->where('ss_aw_id',$id)->update($this->table,$update_array);
		// echo $this->db->last_query();
		// exit();
	}
	
	 public function delete_single_record($id)
	{
		$this->db->where('ss_aw_id', $id);
		$this->db->delete($this->table);
	}
	
	public function fetch_all()
	 {
		$this->db->where('ss_aw_deleted',1);
	 	return $this->db->get($this->table)->result_array();
	 }
	 
	 public function fetch_by_params($search_data = array())
	{
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		$this->db->where('ss_aw_deleted','1');
	  return $this->db->get($this->table)->result_array();
		
	}

	public function totalreadalongcount($level){
		$this->db->where('ss_aw_level', $level);
		$this->db->where('ss_aw_status', 1);
		$this->db->where('ss_aw_deleted', 1);
		return $this->db->get($this->table)->num_rows();
	}

	public function getrecordbyid($readalong_id){
		$this->db->where('ss_aw_id', $readalong_id);
		return $this->db->get($this->table)->result();
	}

	public function get_record_by_upload_id($id){
		$this->db->where('ss_aw_id', $id);
		return $this->db->get($this->table)->result_array();
	}

	public function update_topic_names($topic_name, $new_topic_name){
		$this->db->where('ss_aw_topic', $topic_name);
		$this->db->set('ss_aw_topic', $new_topic_name);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function get_all_readalong(){
		$this->db->where('ss_aw_status', '1');
		$this->db->where('ss_aw_deleted','1');
	  return $this->db->get($this->table)->result_array();
	}

	public function fetch_record_alphabatically($search_data = array())
	{
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		$this->db->order_by('ss_aw_title','asc');
		$this->db->where('ss_aw_deleted','1');
	  return $this->db->get($this->table)->result_array();
		
	}
}	
