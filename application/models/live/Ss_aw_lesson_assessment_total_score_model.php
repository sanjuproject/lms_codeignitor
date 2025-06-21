<?php
/**
 * 
 */
class Ss_aw_lesson_assessment_total_score_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_lesson_assessment_total_score";
	}

	public function remove_child_data($child_id){
    	$this->db->where('ss_aw_child_id', $child_id);
    	$this->db->delete($this->table);
    }
}