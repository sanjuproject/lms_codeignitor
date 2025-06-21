<?php

class Ss_aw_master_lite_access_given_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = "ss_aw_master_lite_access_given";
    }

    public function insert_data($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function getaiglerowdata($child_id, $lesson_id,$lesson_type) {
        $this->db->select("*");
        $this->db->from("ss_aw_master_lite_access_given ag");
        $this->db->where("ag.ss_aw_child_id", $child_id);
        $this->db->where("ag.ss_aw_lesson_assesment_id", $lesson_id);
        $this->db->where("ag.ss_aw_lesson_type", $lesson_type);
        return $this->db->get()->row();
    }

    public function getassessmentdata($child_id,$lesson_id) {
        $this->db->select("*");
        $this->db->from("ss_aw_assesment_uploaded au");
        $this->db->join("ss_aw_assessment_score ase","ase.assessment_id=au.ss_aw_assessment_id and ase.child_id='$child_id'");
      
        $this->db->where("au.ss_aw_lesson_id", $lesson_id);        
        $this->db->order_by("ase.id","ASC");
        $this->db->limit(1);
        return $this->db->get()->row();
    }
	public function update_data($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);		
		$this->db->update("ss_aw_assessment_exam_completed", $data);
		return $this->db->affected_rows();
	}
}
