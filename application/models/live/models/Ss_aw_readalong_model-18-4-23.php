<?php
  class Ss_aw_readalong_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalong";
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
	public function insert_record($insert_array)
	{
		$this->db->insert($this->table,$insert_array);
	}
	public function update_record($id,$update_array)
	{
		$this->db->where('ss_aw_readalong_id',$id)->update($this->table,$update_array);
		// echo $this->db->last_query();
		// exit();
	}
	
	 public function delete_single_record($id)
	{
		$this -> db -> where('ss_aw_readalong_upload_id', $id);
		$this -> db -> delete($this->table);
	}
	public function get_limited_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_readalongs_upload.ss_aw_title as readalong_name');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->join('ss_aw_readalongs_upload','ss_aw_readalongs_upload.ss_aw_id = ss_aw_readalong.ss_aw_readalong_upload_id');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_voiceover','Y');
		$this->db->where($this->table.'.ss_aw_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function search_byparam($search_data = array())
	{
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
	    return $this->db->get($this->table)->result_array();
		
	}
	
	public function get_alldata_byrecordid($id)
	{
		$this->db->select($this->table.'.*');		
		$this->db->where($this->table.'.ss_aw_readalong_upload_id',$id);		
		return $this->db->get($this->table)->result_array();		
		
	}
	
	public function get_deleted_records()
	{
		return $this->db->get($this->table)->result_array();
	}

	//sayan code
	public function fetch_detail_byid($id){
		$this->db->select($this->table.'.*, ss_aw_readalongs_upload.ss_aw_title as readalong_name');
		$this->db->from($this->table);
		$this->db->join('ss_aw_readalongs_upload','ss_aw_readalongs_upload.ss_aw_id = ss_aw_readalong.ss_aw_readalong_upload_id');
		$this->db->where('ss_aw_readalong_id', $id);
		return $this->db->get()->result();
	}

	public function update_readalong_details($data){
		$this->db->where('ss_aw_readalong_id', $data['ss_aw_readalong_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
	
}	
