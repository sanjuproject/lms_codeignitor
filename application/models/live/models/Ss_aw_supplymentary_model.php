<?php
  class Ss_aw_supplymentary_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_supplymentary";
	}
	public function insert_data($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->last_query();
	}
	
	public function get_byparam($id)
	{
		$this->db->select($this->table.'.*');
		return $this->db->where('ss_aw_record_id',$id)->where('ss_aw_deleted',1)->where('ss_aw_status',1)->get($this->table)->result_array();
	}
	
	public function get_limited_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_limited_preface_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_preface_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_limited_answers_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_deleted','1');
		$this->db->where($this->table.'.ss_aw_answers_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function update_records($data)
	{
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->where('ss_aw_deleted', 1);
		$this->db->update($this->table,$data);
	}
	
	public function get_alldata_byrecordid($id)
	{
		$this->db->select($this->table.'.*');
		return $this->db->where('ss_aw_record_id',$id)->get($this->table)->result_array();
	}
	
	public function get_deleted_records()
	{
		return $this->db->get($this->table)->result_array();
	}
	
	public function count_record_no()
	{
		$this->db->select('ss_aw_record_id,count(*) as total_question');
		return $this->db->group_by('ss_aw_record_id')->get($this->table)->result_array();
	}
}	