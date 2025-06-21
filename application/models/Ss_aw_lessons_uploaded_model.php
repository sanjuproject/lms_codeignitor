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
			if ($level == 4) {
				$this->db->select('ss_aw_lesson_topic,ss_aw_lession_id');
				$this->db->from($this->table);
				$this->db->where('ss_aw_course_id', $level);
				$this->db->where('ss_aw_lesson_format', 'Single');
				$this->db->where('ss_aw_lesson_delete', 0);
				return $this->db->get()->result();
			}
			else{
				$this->db->select('ss_aw_lesson_topic,ss_aw_lession_id');
				$this->db->from($this->table);
				$this->db->where('ss_aw_course_id', $level);
				$this->db->where('ss_aw_lesson_format', 'Multiple');
				$this->db->where('ss_aw_lesson_delete', 0);
				return $this->db->get()->result();
			}
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
		$this->db->where($this->table.'.ss_aw_lesson_status', 1);
		$this->db->where('ss_aw_sections_topics.ss_aw_section_status', 1);
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
		$where = "(FIND_IN_SET('2', ss_aw_course_id))";
		$this->db->select($this->table.'.*,ss_aw_sections_topics.ss_aw_topic_description');
		$this->db->join('ss_aw_sections_topics','ss_aw_sections_topics.ss_aw_section_id ='.$this->table.'.ss_aw_lesson_topic_id','left');
		$this->db->where($this->table.'.ss_aw_lesson_delete',0);
		$this->db->where($this->table.'.ss_aw_lesson_status', 1);
		$this->db->where($this->table.'.ss_aw_lesson_format', 'Multiple');
		//$this->db->limit(15,10);
		return $this->db->where($where)->order_by('ss_aw_sl_no','ASC')->get($this->table)->result_array();
	}

	public function update_by_topic_id($topic_id, $data = array()){
		$this->db->where('ss_aw_lesson_topic_id', $topic_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function get_lessonlist_by_topics_check_last_lesson($topicAry = array(),$child_id) {
    return $this->db->query("select `ss_aw_sections_topics`.`ss_aw_section_reference_no`,
    `ss_aw_lessons_uploaded`.*,
    `ss_aw_sections_topics`.`ss_aw_topic_description`,
    `ll`.`ss_aw_las_lesson_id`,ll.ss_aw_last_lesson_modified_date,
    `ag`.`ss_aw_access_date`,
    (SELECT 
            ss_aw_last_lesson_modified_date
        FROM
            ss_aw_child_last_lesson
        WHERE
            ss_aw_las_lesson_id = `ll`.`ss_aw_las_lesson_id`) lesson_end_date,
    (SELECT 
            ss_aw_assessment_exam_completed.ss_aw_create_date
        FROM
            ss_aw_assesment_uploaded
                LEFT JOIN
            ss_aw_assessment_exam_completed ON ss_aw_assessment_exam_completed.ss_aw_assessment_id = ss_aw_assesment_uploaded.ss_aw_assessment_id
        WHERE
            ss_aw_assesment_uploaded.ss_aw_assesment_topic_id = `ss_aw_sections_topics`.`ss_aw_section_reference_no` and ss_aw_assessment_exam_completed.ss_aw_child_id='$child_id'
        ORDER BY ss_aw_assessment_exam_completed.ss_aw_id DESC
        LIMIT 1) assement_complete
FROM
    `ss_aw_lessons_uploaded`
        LEFT JOIN
    `ss_aw_sections_topics` ON `ss_aw_sections_topics`.`ss_aw_section_id` = `ss_aw_lessons_uploaded`.`ss_aw_lesson_topic_id`
        LEFT JOIN
    `ss_aw_child_last_lesson` `ll` ON `ll`.`ss_aw_lesson_id` = `ss_aw_lessons_uploaded`.`ss_aw_lession_id`
        AND `ll`.`ss_aw_child_id` = '$child_id'
       
        LEFT JOIN
    `ss_aw_master_lite_access_given` `ag` ON `ag`.`ss_aw_lesson_assesment_id` = `ss_aw_sections_topics`.`ss_aw_section_id`
        AND `ag`.`ss_aw_child_id` = '$child_id'
WHERE
    `ss_aw_lessons_uploaded`.`ss_aw_lesson_status` = 1
        AND ss_aw_lessons_uploaded.ss_aw_lesson_delete = 0
        AND `ss_aw_sections_topics`.`ss_aw_section_status` = 1
        AND `ss_aw_lessons_uploaded`.`ss_aw_lesson_topic_id` IN('".$topicAry."')
ORDER BY `ss_aw_sections_topics`.`ss_aw_section_reference_no` ASC")->result_array();
}

public function get_course_lesson_list($level){
    	if ($level == 5) {
    		$findTopicalByLevel = "(FIND_IN_SET('A', ss_aw_sections_topics.ss_aw_expertise_level) OR FIND_IN_SET('M', ss_aw_sections_topics.ss_aw_expertise_level))";
    		$findGeneralByLevel = "(FIND_IN_SET('3', ss_aw_lessons_uploaded.ss_aw_course_id) OR FIND_IN_SET('4', ss_aw_lessons_uploaded.ss_aw_course_id))";
    	}
    	elseif ($level == 3) {
    		$findTopicalByLevel = "FIND_IN_SET('C', ss_aw_sections_topics.ss_aw_expertise_level)";
    		$findGeneralByLevel = "FIND_IN_SET('2', ss_aw_lessons_uploaded.ss_aw_course_id)";
    	}
    	else{
    		$findTopicalByLevel = "FIND_IN_SET('E', ss_aw_sections_topics.ss_aw_expertise_level)";
    		$findGeneralByLevel = "FIND_IN_SET('1', ss_aw_lessons_uploaded.ss_aw_course_id)";
    	}
    	return $this->db->query("(
    SELECT
        ss_aw_lessons_uploaded.*
    FROM
        ss_aw_sections_topics
    JOIN ss_aw_lessons_uploaded ON ss_aw_lessons_uploaded.ss_aw_lesson_topic_id = ss_aw_sections_topics.ss_aw_section_id
    WHERE
        ss_aw_lessons_uploaded.ss_aw_lesson_status = 1 AND ss_aw_lessons_uploaded.ss_aw_lesson_delete = 0 AND ss_aw_sections_topics.ss_aw_section_status = 1 AND $findTopicalByLevel
)
UNION
    (
    SELECT
        ss_aw_lessons_uploaded.*
    FROM
        ss_aw_lessons_uploaded
    WHERE
        $findGeneralByLevel AND ss_aw_lessons_uploaded.ss_aw_lesson_format = 'Multiple' AND ss_aw_lessons_uploaded.ss_aw_lesson_status = 1 AND ss_aw_lessons_uploaded.ss_aw_lesson_delete = 0
) ORDER BY ss_aw_sl_no ASC;")->result_array();
    }

    public function update_status($topic_id, $status){
    	$this->db->where('ss_aw_lesson_topic_id', $topic_id);
    	$this->db->set('ss_aw_lesson_status', $status);
    	$this->db->update($this->table);
    }

}	