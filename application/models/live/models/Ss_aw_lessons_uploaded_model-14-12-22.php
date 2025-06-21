<?php
  class Ss_aw_lessons_uploaded_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_lessons_uploaded";
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
		$this->db->where('ss_aw_lesson_delete',0);
		$this->db->order_by('ss_aw_sl_no','ASC');
		return $this->db->get($this->table)->num_rows();
	}
	public function get_all_records($limit,$start,$search_parent_data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_courses.ss_aw_course_name');
		if($search_parent_data!="")
		{
			foreach($search_parent_data as $key=>$value)
			{
				$this->db->Like('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}	
		$this->db->join('ss_aw_courses','ss_aw_courses.ss_aw_course_id ='.$this->table.'.ss_aw_course_id','left');
		
		$this->db->limit($limit,$start);		
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);		
		$this->db->order_by('ss_aw_sl_no','ASC');
		return $this->db->get($this->table)->result();
	}
	
	public function fetch_all()
	 {
		$this->db->where('ss_aw_lesson_delete',0);
		$this->db->order_by('ss_aw_sl_no','ASC');
	 	return $this->db->get($this->table)->result_array();
	 }
	 
	 public function delete_single_record($id)
	{
		$this->db->where('ss_aw_lession_id', $id);
		$this->db->delete($this->table);

	}
	
	public function update_record($datary)
	{
		
		$this->db->where('ss_aw_lession_id', $datary['ss_aw_lession_id']);
	
		$this ->db->update($this->table,$datary);
	}
	
	public function get_lessonlist_bylevel($level)
	{
		$where = "FIND_IN_SET('".$level."', ss_aw_course_id)"; 
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic_id','left');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$this->db->where('ss_aw_lesson_status', 1);
		return $this->db->where($where)->order_by('ss_aw_sl_no','ASC')->get($this->table)->result_array();
	}
	
	public function fetch_databy_param($paramval = array())
	{
		if(!empty($paramval))
		{
			foreach($paramval as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value,'both');
			}
		}	
		$this->db->order_by('ss_aw_sl_no','ASC');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		return $this->db->get($this->table)->result_array();
	}
	
	public function update_serialno($new_serial_no,$record_no)
	{
		$this->db->where('ss_aw_lession_id', $record_no);
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$datary = array();
		$datary['ss_aw_sl_no'] = $new_serial_no;
		$this ->db->update($this->table,$datary);
		return 1;
	}
	
	public function fetch_all_slno_desc()
	 {
		$this->db->where('ss_aw_lesson_delete',0);
		$this->db->order_by('ss_aw_sl_no','desc');
	 	return $this->db->get($this->table)->result_array();
	 }
	 
	 public function updateserialno_byoldserial($serial_no)
		{
			$this->db->set('ss_aw_sl_no',$serial_no - 1);
			$this->db->where('ss_aw_sl_no',$serial_no);
			$response = $this->db->update($this->table);
			
			if ($response) {
				return $this->db->last_query();
			}
			else
			{
				return false;
			}
		}
		
		public function remove_record($id){
			$response = $this->db->delete($this->table, array('ss_aw_lession_id' => $id));
			if ($response) {
				return true;
			}
			else
			{
				return false;
			}
		}

		public function checkduplicatelessonname($lesson_name, $level){
			$this->db->where('ss_aw_lesson_topic', $lesson_name);
			$this->db->where('ss_aw_lesson_delete', 0);
			$this->db->where('ss_aw_course_id', $level);
			return $this->db->get($this->table)->num_rows();
		}

		public function getlessonsbylevel($level){
			$this->db->select('ss_aw_lesson_topic,ss_aw_lession_id');
			$this->db->from($this->table);
			$this->db->where('ss_aw_course_id', $level);
			$this->db->where('ss_aw_lesson_format', 'Multiple');
			$this->db->where('ss_aw_lesson_delete', 0);
			return $this->db->get()->result();
		}

		public function getsinglelessons(){
			$this->db->where('ss_aw_lesson_format','Single');
			$this->db->where('ss_aw_lesson_delete', 0);
			return $this->db->get($this->table)->result();
		}

		public function getlessonbyid($lesson_id){
			$this->db->where('ss_aw_lession_id', $lesson_id);
			return $this->db->get($this->table)->result();
		}

		public function get_lessoncount_bylevel($level){
			$where = "FIND_IN_SET('".$level."', ss_aw_course_id)"; 
			$this->db->where($this->table.'.ss_aw_lesson_delete',0);
			return $this->db->where($where)->get($this->table)->num_rows();
	}

	public function get_all_active_lessons(){
		$this->db->where('ss_aw_lesson_delete', 0);
		$this->db->where('ss_aw_lesson_status', 1);
		$this->db->order_by('ss_aw_sl_no','asc');
		return $this->db->get($this->table)->result();
	}

	public function get_lessonlist()
	{ 
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic_id','left');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$this->db->where('ss_aw_lesson_status', 1);
		return $this->db->order_by('ss_aw_sl_no','ASC')->get($this->table)->result_array();
	}

	public function get_lessonlist_by_topics($topicAry = array()){
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic_id','left');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$this->db->where('ss_aw_lesson_status', 1);
		$this->db->where_in($this->table.'.ss_aw_lesson_topic_id',$topicAry);
		return $this->db->order_by('ss_aw_sl_no','ASC')->get($this->table)->result_array();
	}

	public function get_winners_general_language_lessons(){
		$where = "FIND_IN_SET('2', ss_aw_course_id)";
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic_id','left');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$this->db->where($this->table.'.ss_aw_lesson_status', 1);
		$this->db->where($this->table.'.ss_aw_lesson_format', 'Multiple');
		$this->db->limit(10);
		return $this->db->where($where)->order_by('ss_aw_sl_no','ASC')->get($this->table)->result_array();
	}

	public function get_champions_general_language_lessons(){
		$where = "(FIND_IN_SET('2', ss_aw_course_id) OR FIND_IN_SET('3', ss_aw_course_id))";
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic_id','left');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$this->db->where($this->table.'.ss_aw_lesson_status', 1);
		$this->db->where($this->table.'.ss_aw_lesson_format', 'Multiple');
		$this->db->limit(15,10);
		return $this->db->where($where)->order_by('ss_aw_sl_no','ASC')->get($this->table)->result_array();
	}
}	