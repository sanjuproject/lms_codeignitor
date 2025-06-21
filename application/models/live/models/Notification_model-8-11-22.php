<?php
/**
 * 
 */
class Notification_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getdiagnosticinviteparents($searchdate){
		$this->db->select('*');
		$this->db->from('ss_aw_parents');
		$this->db->where('ss_aw_parent_created_date >=',$searchdate);
		$this->db->where('ss_aw_parent_delete',0);
		return $this->db->get()->result_array();
	}

	public function check_diagnostic_exam_data($child_id){
		$this->db->where('ss_aw_diagonastic_child_id', $child_id);
		return $this->db->get('ss_aw_diagonastic_exam')->num_rows();
	}

	public function getdiagnosticinvitechilds($searchdate){
		$this->db->select('ss_aw_childs.*, ss_aw_parents.ss_aw_parent_full_name, ss_aw_parents.ss_aw_parent_email, ss_aw_parents.ss_aw_device_token as parent_device_token, ss_aw_parents.ss_aw_parent_id as parent_id');
		$this->db->from('ss_aw_childs');
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('ss_aw_childs.ss_aw_child_created_date >=',$searchdate);
		$this->db->where('ss_aw_childs.ss_aw_child_delete',0);
		$this->db->where('ss_aw_childs.ss_aw_child_status',1);
		return $this->db->get()->result();
	}

	public function check_assessment_completion($date, $child_id){
		$this->db->select('ss_aw_assesment_uploaded.ss_aw_assesment_topic as assessment_name');
		$this->db->from('ss_aw_assessment_exam_completed');
		$this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
		$this->db->where('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
		$this->db->where('DATE(ss_aw_assessment_exam_completed.ss_aw_create_date)', date('Y-m-d', strtotime($date)));
		return $this->db->get()->result();
	}

	public function add_monthly_score_card($data){
		$this->db->insert('ss_aw_monthly_scorecard_notification', $data);
		return $this->db->insert_id();
	}

	public function getparentsofzerochild($searchdate){
		$this->db->select('*');
		$this->db->from('ss_aw_parents');
		$this->db->where('ss_aw_parent_created_date >=',$searchdate);
		$this->db->where('ss_aw_parent_delete',0);
		$this->db->where('ss_aw_parent_status',1);
		$this->db->where('(select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_parent_id = ss_aw_parents.ss_aw_parent_id and ss_aw_childs.ss_aw_child_delete = 0 and ss_aw_childs.ss_aw_child_status = 1) = 0');
		return $this->db->get()->result();
	}
}