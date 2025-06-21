<?php
set_time_limit(320);
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
class Testingapi extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->model('ss_aw_parents_model');
		$this->load->model('ss_aw_error_code_model');
		$this->load->model('ss_aw_childs_model');
		$this->load->model('ss_aw_childs_temp_model');
		$this->load->model('ss_aw_parents_temp_model');
		$this->load->model('ss_aw_diagonastic_exam_model');
		$this->load->model('ss_aw_diagonastic_exam_log_model');
		$this->load->model('ss_aw_diagnonstic_questions_asked_model');
		$this->load->helper('custom_helper');
	}
	
	public function deletechilds()
	{
		$parent_id = $this->uri->segment(3);
		$this->ss_aw_childs_model->deleterecord($parent_id);
		$this->ss_aw_childs_temp_model->deleterecord($parent_id);
		$response['msg'] = "All Child record deleted";
		
		echo json_encode($response);
		die();
	}

	public function deleteparent()
	{
		$parent_id = $this->uri->segment(3);
		$this->ss_aw_childs_model->deleterecord($parent_id);
		$this->ss_aw_childs_temp_model->deleterecord($parent_id);
		
		$this->ss_aw_parents_model->deleterecord($parent_id);
		$this->ss_aw_parents_temp_model->deleterecord($parent_id);
		$response['msg'] = "Parent record deleted";
		
		echo json_encode($response);
		die();
	}
	
	public function resetexam_result()
	{
		$child_id = $this->uri->segment(3);
		$this->ss_aw_diagonastic_exam_model->deleterecord($child_id);
		$this->ss_aw_diagnonstic_questions_asked_model->deleterecord($child_id);
		
		$this->ss_aw_diagonastic_exam_log_model->deleterecord($child_id);
		
		$response['msg'] = "Exam record deleted";
		
		echo json_encode($response);
		die();
	}
	public function delete_singlechild()
	{
		$child_id = $this->uri->segment(3);
		$this->ss_aw_childs_model->delete_single_child($child_id);
		$this->ss_aw_childs_temp_model->delete_single_child($child_id);
		$response['msg'] = "Selected Child record deleted";
		
		echo json_encode($response);
		die();
	}
	
	public function setdiagnostic_result()
	{
		$child_id = $this->uri->segment(3);
		$result_status = $this->uri->segment(4);// 1 = 80%,2=40%		
		$childdetailsary = $this->ss_aw_childs_model->get_details($child_id);	
		$age = $childdetailsary[0]['ss_aw_child_age'];
		if($age <13)
		{
			$level = "E";
		}
		else
		{
			$level = "C";
		}
		$right_ans = 0;
		$resultary = array();
		$exam_code = time()."_".$child_id;
		
			for($i = 0;$i<20;$i++)
			{
				if($result_status == 1)
				{
					if($right_ans > 16)
					{
						$right = 0;
					}
					else
					{
						$right = 1;
					}
				}
				if($result_status == 2)
				{
					if($right_ans > 8)
					{
						$right = 0;
					}
					else
					{
						$right = 1;
					}
				}
				$right_ans++;
				$resultary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
				$resultary['ss_aw_diagonastic_log_child_id'] = $child_id;
				$resultary['ss_aw_diagonastic_log_level'] = $level;
				$resultary['ss_aw_diagonastic_log_question_id'] = rand(1,1900);
				$resultary['ss_aw_diagonastic_log_weight'] = 1;
				$resultary['ss_aw_diagonastic_log_answers'] = '[]';
				$resultary['ss_aw_diagonastic_log_right_answers'] = '[]';
				$resultary['ss_aw_diagonastic_log_answer_status'] = $right;
				$this->ss_aw_diagonastic_exam_log_model->insert_record($resultary);
			}
			$resultary = array();
			$resultary['ss_aw_diagonastic_child_id'] = $child_id;
			$resultary['ss_aw_diagonastic_exam_code'] = $exam_code;
			$this->ss_aw_diagonastic_exam_model->insert_record($resultary);
	}
}