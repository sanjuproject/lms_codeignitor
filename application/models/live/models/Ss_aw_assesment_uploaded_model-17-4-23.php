<?php
  class Ss_aw_assesment_uploaded_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_assesment_uploaded";
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
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'after');
			}
		}	
		$this->db->where('ss_aw_assesment_delete','0');
		return $this->db->get($this->table)->num_rows();
	}

	public function get_all_records($limit,$start,$search_parent_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		 if($search_parent_data!="")
		{
			foreach($search_parent_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'after');
			}
		}	
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');	
		return $this->db->get($this->table)->result();
		
		
	}
	public function update_databyid($assesment_id,$update_arr)
	{
		$this->db->where('ss_aw_assessment_id',$assesment_id)->update($this->table,$update_arr);
	}
	
	public function fetch_all()
	 {
	 	$this->db->select('*');
	 	$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');		
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');
	 	return $this->db->get($this->table)->result_array();
	 }
	 
	 public function delete_single_record($id)
	{
		$this->db->where('ss_aw_assessment_id', $id);
		$this->db->delete($this->table);
	}
	
	public function update_record($datary)
	{
		
		$this->db->where('ss_aw_assessment_id', $datary['ss_aw_assessment_id']);
		
		$this ->db->update($this->table,$datary);
	}
	
	public function get_lessonlist_bylevel($level)
	{
		$where = "FIND_IN_SET('".$level."', ss_aw_course_id)"; 
		$this->db->where('ss_aw_assesment_delete','0');
		return $this->db->where($where)->order_by('ss_aw_lession_id','ASC')->get($this->table)->result_array();
	}
	
	public function fetch_by_params($search_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->where($this->table.'.ss_aw_assesment_status','1');
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');
	    return $this->db->get($this->table)->result_array();
		
	}

	public function getassesmentdetailbyid($id){
		$this->db->where('ss_aw_assessment_id', $id);
		return $this->db->get($this->table)->result();
	}

	public function get_assessmentcount_bylevel($level){
		$where = "FIND_IN_SET('".$level."', ss_aw_course_id)";
		$this->db->where('ss_aw_assesment_delete','0');
		return $this->db->where($where)->get($this->table)->num_rows();
	}

	public function gettotalquestion($assessment_id){
		$this->db->join('ss_aw_sections_subtopics','ss_aw_sections_subtopics.ss_aw_topic_id = ss_aw_assesment_uploaded.ss_aw_assesment_topic_id');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_assessment_id', $assessment_id);
		$this->db->get($this->table)->num_rows();
	}

	public function gettopic($assesment_id){
		$this->db->where('ss_aw_assessment_id', $assesment_id);
		return $this->db->get($this->table)->result();
	}

	public function get_deleted_limited_records($limit){
		$where = "(ss_aw_assisment_diagnostic.ss_aw_preface_audio_exist = 1 OR ss_aw_assisment_diagnostic.ss_aw_answers_audio_exist = 1 OR ss_aw_assisment_diagnostic.ss_aw_audio_exist = 1 OR ss_aw_assisment_diagnostic.ss_aw_question_audio_exist = 1)";
		$this->db->select('ss_aw_assisment_diagnostic.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assisment_diagnostic','ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id = ss_aw_assesment_uploaded.ss_aw_assessment_id');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_delete', 1);
		$this->db->where($where);
		$this->db->limit($limit);
		return $this->db->get()->result();
	}

	public function get_assessment_bylevel($level){
		$where = "FIND_IN_SET('".$level."', ss_aw_course_id)";
		$this->db->where('ss_aw_assesment_delete','0');
		$this->db->where('ss_aw_assesment_status','1');
		return $this->db->where($where)->get($this->table)->result();
	}

	public function get_all_deleted_record(){
		$this->db->select('ss_aw_assisment_diagnostic.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_assisment_diagnostic','ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id = ss_aw_assesment_uploaded.ss_aw_assessment_id');
		$this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_delete', 1);
		return $this->db->get()->result();
	}

	public function get_assessment_by_lesson_id($lesson_id){
		$this->db->where('ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_assesment_status', 1);
		$this->db->where('ss_aw_assesment_delete', 0);
		return $this->db->get($this->table)->result();
	}

	//version 2 code
	public function assessment_list($search_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		if(!empty($search_data))
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->where($this->table.'.ss_aw_assesment_status','1');
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');
	    return $this->db->get($this->table)->result_array();
		
	}

	public function get_winners_general_language_assessments()
	{
		$where = "FIND_IN_SET('C', ss_aw_assesment_uploaded.ss_aw_course_id)";
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->where($this->table.'.ss_aw_assesment_status','1');
		$this->db->where($this->table.'.ss_aw_assesment_format','Multiple');
		$this->db->where($where);
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');
		$this->db->limit(10);
	  return $this->db->get($this->table)->result_array();
	}

	public function get_champions_general_language_assessments()
	{
		$where = "(FIND_IN_SET('C', ss_aw_assesment_uploaded.ss_aw_course_id) OR FIND_IN_SET('A', ss_aw_assesment_uploaded.ss_aw_course_id))";
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->where($this->table.'.ss_aw_assesment_status','1');
		$this->db->where($this->table.'.ss_aw_assesment_format','Multiple');
		$this->db->where($where);
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');
		$this->db->limit(15,10);
	  return $this->db->get($this->table)->result_array();
	}

	public function get_assessmentlist_by_topics($topicAry = array()){
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->where($this->table.'.ss_aw_assesment_delete','0');
		$this->db->where($this->table.'.ss_aw_assesment_status','1');
		$this->db->where_in($this->table.'.ss_aw_assesment_topic_id', $topicAry);
		$this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no','ASC');
	  return $this->db->get($this->table)->result_array();
	}

	public function get_assessment_details_by_id($id){
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_sl_no');
		$this->db->join('ss_aw_lessons_uploaded',$this->table.'.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id','left');
		$this->db->where($this->table.'.ss_aw_assessment_id',$id);
	  return $this->db->get($this->table)->row();
	}
}	