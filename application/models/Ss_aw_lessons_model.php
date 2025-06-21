<?php
  class Ss_aw_lessons_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_lessons";
	}

	public function insert_data($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	public function deleterecord($id)
	{
		$is_delete['ss_aw_lesson_delete']=1;
		$this->db->where('ss_aw_parent_id', $id)->update($this->table,$is_delete);
		// $this->db->delete($this->table);
	}
	
	public function delete_single_record($id)
	{
		$is_delete['ss_aw_lesson_delete']=1;
		$this->db->where('ss_aw_lession_id', $id)->update($this->table,$is_delete);
		// $this->db->delete($this->table);
	}
	
	public function number_of_records($search_parent_data = array())
	{

		if($search_parent_data!="")
		{
			foreach($search_parent_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'after');
			}
		}
		$this->db->where('ss_aw_lesson_delete','0');
		return $this->db->get($this->table)->num_rows();
	}
	public function get_all_records($limit,$start,$search_parent_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_courses.ss_aw_course_name,ss_aw_sections_topics.ss_aw_section_title as topic_title');
		if($search_parent_data!="")
		{
			foreach($search_parent_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'after');
			}
		}	
		$this->db->join('ss_aw_courses','ss_aw_courses.ss_aw_course_id ='.$this->table.'.ss_aw_course_id','left');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic','left');
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');		
		return $this->db->get($this->table)->result();
	}
	
	public function update_record($datary)
	{
		
		$this->db->where('ss_aw_lession_id', $datary['ss_aw_lession_id']);
	
		$this ->db->update($this->table,$datary);
	}
	
	public function search_data_by_param($search_data = array())
	{
		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		$this->db->where('ss_aw_lesson_delete','0');
		$this->db->where('ss_aw_lesson_audio_exist','1');
		$this->db->where('ss_aw_lesson_status','1');
		return $this->db->get($this->table)->result_array();
	}

	public function alldatacountbyparam($search_data = array())
	{

		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		$this->db->where('ss_aw_lesson_delete','0');
		$this->db->where('ss_aw_lesson_status','1');
		return $this->db->get($this->table)->num_rows();
	}
	
	public function delete_records_by_lesson($id)
	{
		$is_delete['ss_aw_lesson_delete']=1;
		$this->db->where('ss_aw_lesson_record_id', $id)->update($this->table,$is_delete);
		// $this->db->delete($this->table);
	}
	
	public function get_limited_records($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_lesson_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_for_slow($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_lesson_audio_slow_exist','2');
		$this->db->order_by($this->table.'.ss_aw_lesson_record_id','asc');	
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_for_fast($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_lesson_audio_fast_exist','2');
		$this->db->order_by($this->table.'.ss_aw_lesson_record_id','asc');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_limited_records_details($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_details_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_details_slow($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_details_audio_slow_exist','2');	
		$this->db->order_by($this->table.'.ss_aw_lesson_record_id','asc');
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_details_fast($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_details_audio_fast_exist','2');	
		$this->db->order_by($this->table.'.ss_aw_lesson_record_id','asc');
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_answers($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_lesson_answers_audio_exist','2');	
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_answers_slow($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_lesson_answers_audio_slow_exist','2');
		$this->db->order_by($this->table.'.ss_aw_lesson_record_id','asc');	
		return $this->db->get($this->table)->result_array();
	}

	public function get_limited_records_answers_fast($limit)
	{
		$this->db->select($this->table.'.*,ss_aw_voice_type_matrix.ss_aw_voice_type,ss_aw_voice_type_matrix.ss_aw_language_code,ss_aw_voice_type_matrix.ss_aw_c_speed,
		ss_aw_voice_type_matrix.ss_aw_c_pitch,ss_aw_voice_type_matrix.ss_aw_e_speed,ss_aw_voice_type_matrix.ss_aw_e_pitch,ss_aw_voice_type_matrix.ss_aw_a_speed,
		ss_aw_voice_type_matrix.ss_aw_a_pitch,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lessons.ss_aw_lesson_record_id');
		$this->db->join('ss_aw_voice_type_matrix','ss_aw_voice_type_matrix.ss_aw_id = '.$this->table.'.ss_aw_audio_type','left');
		$this->db->limit($limit);		
		$this->db->where($this->table.'.ss_aw_lesson_delete','0');
		$this->db->where($this->table.'.ss_aw_lesson_answers_audio_fast_exist','2');
		$this->db->order_by($this->table.'.ss_aw_lesson_record_id','asc');	
		return $this->db->get($this->table)->result_array();
	}
	
	public function search_data_by_lesson_record_id($lesson_record_id)
	{
		$this->db->where('ss_aw_lesson_record_id',$lesson_record_id);	
		return $this->db->get($this->table)->result_array();
	}
	
	public function get_deleted_records()
	{
		$this->db->select($this->table.'.*');	
		$this->db->where($this->table.'.ss_aw_lesson_delete','1');
		return $this->db->get($this->table)->result_array();
	}

	public function getrecordbyid($lesson_record_id){
		$this->db->where('ss_aw_lesson_record_id', $lesson_record_id);
		return $this->db->get($this->table)->result_array();
	}

	public function countallquizbyid($lesson_id){
		$this->db->where('ss_aw_lesson_record_id', $lesson_id);
		$this->db->where('ss_aw_lesson_quiz_type_id !=', 0);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_limited_deleted_records($limit){
		$where = "(ss_aw_lessons.ss_aw_lesson_audio_exist = 1 OR ss_aw_lessons.ss_aw_details_audio_exist = 1 OR ss_aw_lessons.ss_aw_lesson_answers_audio_exist = 1)";
		$this->db->select('ss_aw_lessons.*');
		$this->db->from('ss_aw_lessons_uploaded');
		$this->db->join('ss_aw_lessons','ss_aw_lessons.ss_aw_lesson_record_id = ss_aw_lessons_uploaded.ss_aw_lession_id');
		$this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_delete', 1);
		$this->db->where($where);
		$this->db->limit($limit);
		return $this->db->get()->result();
	}

	public function check_lesson_audio_non_existance_number($lesson_id){
		$this->db->where('ss_aw_lesson_record_id', $lesson_id);
		$this->db->where('ss_aw_lesson_delete','0');
		$this->db->where('ss_aw_lesson_audio_exist','2');
		$this->db->where('ss_aw_lesson_status','1');
		return $this->db->get($this->table)->num_rows();
	}

	public function update_details($data = array(), $id){
		$this->db->where('ss_aw_lession_id', $id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getrecordbyidlevel($lesson_record_id, $level){
		$this->db->where('ss_aw_lesson_record_id', $lesson_record_id);
		$this->db->where('ss_aw_course_id', $level);
		$this->db->where('ss_aw_lesson_delete', 0);
		$this->db->where('ss_aw_lesson_status', 1);
		return $this->db->get($this->table)->result_array();
	}

	public function no_of_quizes($lesson_record_id){
		$this->db->where('ss_aw_lesson_record_id', $lesson_record_id);
		$this->db->where('ss_aw_lesson_format_type', 2);
		return $this->db->get($this->table)->num_rows();
	}
}
