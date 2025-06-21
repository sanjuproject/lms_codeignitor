<?php
  class Course_audio_update_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
	}
   public function get_single_lesson_record($lesson_id){
       $this->db->select("al.*,(lu.ss_aw_lesson_topic)topic_name");
       $this->db->from("ss_aw_lessons al");
       $this->db->join("ss_aw_lessons_uploaded lu","lu.ss_aw_lession_id=al.ss_aw_lesson_record_id");
       $this->db->where("al.ss_aw_lession_id",$lesson_id);
       return $this->db->get()->row();
   }     
   public function get_single_assessment_record($assesment_id){
       $this->db->select("ad.*,(ad.ss_aw_category)topic_name");
       $this->db->from("ss_aw_assisment_diagnostic ad");      
       $this->db->where("ad.ss_aw_id",$assesment_id);
       $this->db->where("ad.ss_aw_deleted",1);
       return $this->db->get()->row();
   }     
        
}