<?php
  class Ss_aw_readalong_quiz_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalong_quiz";
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
		$this->db->where($this->table.'.ss_aw_status','1');
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
		$this->db->where($this->table.'.ss_aw_status','1');		
		return $this->db->get($this->table)->result_array();		
		
	}
	public function insert_record($insert_array)
	{
		$this->db->insert($this->table,$insert_array);
	}
	public function update_record($id,$update_array)
	{
		$this->db->where('ss_aw_readalong_upload_id',$id)->update($this->table,$update_array);
		// echo $this->db->last_query();
		// exit();
	}
	
	public function update_record_byid($id,$update_array)
	{
		$this->db->where('ss_aw_readalong_id',$id)->update($this->table,$update_array);
		// echo $this->db->last_query();
		// exit();
	}
	
	 public function delete_single_record($id)
	{
		$status_change['ss_aw_status']=0;
		$this->db->where('ss_aw_readalong_upload_id', $id)->update($this->table,$status_change);
		// $this -> db -> delete($this->table);

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
		$this->db->where($this->table.'.ss_aw_status','1');
	    return $this->db->get($this->table)->result_array();
		
	}
	
	public function get_record_groupby_quiztype()
	{
		$this->db->select('ss_aw_quiz_type');
		$this->db->group_by('ss_aw_quiz_type'); 
		$this->db->where('ss_aw_quiz_type!=',0);
		$this->db->where($this->table.'.ss_aw_status','1');
	    return $this->db->get($this->table)->result_array();
		
	}
	
	public function get_limited_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_readalongs_upload.ss_aw_level,ss_aw_readalongs_upload.ss_aw_title as readalong_name');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->join('ss_aw_readalongs_upload','ss_aw_readalongs_upload.ss_aw_id = '.$this->table.'.ss_aw_readalong_upload_id','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_answers_audio_exist','2');	
		$this->db->where($this->table.'.ss_aw_status','1');
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_limited_records_details($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_readalongs_upload.ss_aw_level,ss_aw_readalongs_upload.ss_aw_title as readalong_name');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->join('ss_aw_readalongs_upload','ss_aw_readalongs_upload.ss_aw_id = '.$this->table.'.ss_aw_readalong_upload_id','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_details_audio_exist','2');	
		$this->db->where($this->table.'.ss_aw_status','1');
		return $this->db->get($this->table)->result_array();
	}

	public function get_record_by_upload_id($id){
		$this->db->where('ss_aw_readalong_upload_id', $id);
		return $this->db->get($this->table)->result_array();
	}
}	
