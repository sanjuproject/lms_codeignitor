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
		$this->load->model('ss_aw_purchase_courses_model');
		$this->load->model('ss_aw_child_course_model');
		$this->load->model('ss_aw_payment_details_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_assessment_exam_log_model');
		$this->load->model('ss_aw_lesson_quiz_ans_model');
		$this->load->model('ss_aw_current_lesson_model');
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_lessons_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_assisment_diagnostic_model');
		$this->load->model('ss_aw_sections_subtopics_model');
		$this->load->model('ss_aw_assessment_subsection_matrix_model');
		$this->load->model('ss_aw_assesment_multiple_question_answer_model');
		$this->load->model('store_procedure_model');
		$this->load->model('ss_aw_lesson_assessment_score_model');
		$this->load->model('ss_aw_general_settings_model');
		$this->load->model('ss_aw_test_timing_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_combine_score_quintile_model');
		$this->load->model('ss_aw_combine_score_quintile_topic_wise_model');
		$this->load->model('ss_aw_diagnostic_quintile_model');
		$this->load->model('ss_aw_assessment_quintile_model');
		$this->load->model('ss_aw_lesson_assessment_format_two_quintile_model');
		$this->load->model('ss_aw_promotion_model');
		$this->load->model('ss_aw_english_language_confidence_quintile_model');
		$this->load->model('ss_aw_child_result_model');
		$this->load->model('testingapi_model');
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
	
	/*public function setdiagnostic_result()
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
	}*/
	
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
		$resultary = array();
		$exam_code = time()."_".$child_id;
		if ($level == "C" && $result_status == 1) {
			$right_ans = 0;
			$up_right_ans = 0;
			for($i = 0;$i < 20;$i++)
			{
				if ($i < 10) {
					if ($right_ans > 8) {
						$right = 0;
					}
					else{
						$right = 1;
					}

					$resultary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
					$resultary['ss_aw_diagonastic_log_child_id'] = $child_id;
					$resultary['ss_aw_diagonastic_log_level'] = "C";
					$resultary['ss_aw_diagonastic_log_question_id'] = rand(1,1900);
					$resultary['ss_aw_diagonastic_log_weight'] = 1;
					$resultary['ss_aw_diagonastic_log_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_right_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_answer_status'] = $right;
					$this->ss_aw_diagonastic_exam_log_model->insert_record($resultary);
					$right_ans++;
				}
				else{
					if ($up_right_ans > 8) {
						$right = 0;
					}
					else{
						$right = 1;
					}

					$resultary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
					$resultary['ss_aw_diagonastic_log_child_id'] = $child_id;
					$resultary['ss_aw_diagonastic_log_level'] = "A";
					$resultary['ss_aw_diagonastic_log_question_id'] = rand(1,1900);
					$resultary['ss_aw_diagonastic_log_weight'] = 1;
					$resultary['ss_aw_diagonastic_log_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_right_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_answer_status'] = $right;
					$this->ss_aw_diagonastic_exam_log_model->insert_record($resultary);
					$up_right_ans++;
				}
				
			}
		}
		if ($level == "E" && $result_status == 1) {
			$right_ans = 0;
			$up_right_ans = 0;
			for($i = 0;$i < 20;$i++)
			{
				if ($i < 10) {
					if ($right_ans > 8) {
						$right = 0;
					}
					else{
						$right = 1;
					}

					$resultary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
					$resultary['ss_aw_diagonastic_log_child_id'] = $child_id;
					$resultary['ss_aw_diagonastic_log_level'] = "E";
					$resultary['ss_aw_diagonastic_log_question_id'] = rand(1,1900);
					$resultary['ss_aw_diagonastic_log_weight'] = 1;
					$resultary['ss_aw_diagonastic_log_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_right_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_answer_status'] = $right;
					$this->ss_aw_diagonastic_exam_log_model->insert_record($resultary);
					$right_ans++;
				}
				else{
					if ($up_right_ans > 8) {
						$right = 0;
					}
					else{
						$right = 1;
					}

					$resultary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
					$resultary['ss_aw_diagonastic_log_child_id'] = $child_id;
					$resultary['ss_aw_diagonastic_log_level'] = "C";
					$resultary['ss_aw_diagonastic_log_question_id'] = rand(1,1900);
					$resultary['ss_aw_diagonastic_log_weight'] = 1;
					$resultary['ss_aw_diagonastic_log_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_right_answers'] = '[]';
					$resultary['ss_aw_diagonastic_log_answer_status'] = $right;
					$this->ss_aw_diagonastic_exam_log_model->insert_record($resultary);
					$up_right_ans++;
				}
				
			}
		}
		else{
			$right_ans = 0;
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
		}

		$resultary = array();
		$resultary['ss_aw_diagonastic_child_id'] = $child_id;
		$resultary['ss_aw_diagonastic_exam_code'] = $exam_code;
		$this->ss_aw_diagonastic_exam_model->insert_record($resultary);
	}
	
	public function revertback_purchase_courses()
	{
			$child_id = $this->uri->segment(3);
			$childdetailsary = $this->ss_aw_childs_model->get_details($child_id);
			$parent_id = $childdetailsary[0]['ss_aw_parent_id'];
		
			 $child_id = $child_id;
			 				
			$this->ss_aw_diagonastic_exam_log_model->deleterecord($child_id);
	
			$this->ss_aw_diagonastic_exam_model->deleterecord($child_id);
			
					$this->db->trans_start();
					
					$courseary = $this->ss_aw_purchase_courses_model->deleterecord($child_id);
									
					$courseary = $this->ss_aw_child_course_model->deleterecord_child($child_id);
					
					$courseary = $this->ss_aw_payment_details_model->deleterecord_child($child_id);
					
					$this->db->trans_complete();
					$responseary['status'] = 200;
					$responseary['msg'] = "Course revert back successfully done.";
				
			echo json_encode($responseary);
			die();	
	}
	
	public function purchase_courses()
	{
			$child_id = $this->uri->segment(3);
			$childdetailsary = $this->ss_aw_childs_model->get_details($child_id);
			$parent_id = $childdetailsary[0]['ss_aw_parent_id'];
		
			 $child_id = $child_id;
			 $transaction_id = "test_565665";
			 $payment_amount = 555;
			 $invoice_no = "test_99999";
			 $gst_rate = 12;
			 $discount_amount = 200;
			 $coupon_id = 1;
			 $result_status = 1;
		$age = $childdetailsary[0]['ss_aw_child_age'];
		if($age <13)
		{
			$level = "E";
			$course_id = 1;
		}
		else
		{
			$level = "C";
			$course_id = 2;
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
			
					$this->db->trans_start();
					$searary = array();
					$searary['ss_aw_parent_id'] = $parent_id;
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_selected_course_id'] = $course_id;
					$searary['ss_aw_transaction_id'] = $transaction_id;
					$searary['ss_aw_course_payment'] = $payment_amount;
					$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
					$searary = array();
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_course_id'] = $course_id;					
					$courseary = $this->ss_aw_child_course_model->data_insert($searary);
					
					$searary = array();
					$searary['ss_aw_parent_id'] = $parent_id;
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_payment_invoice'] = $invoice_no;
					$searary['ss_aw_transaction_id'] = $transaction_id;
					$searary['ss_aw_payment_amount'] = $payment_amount;
					$searary['ss_aw_gst_rate'] = $gst_rate;
					$searary['ss_aw_discount_amount'] = $discount_amount;
					$courseary = $this->ss_aw_payment_details_model->data_insert($searary);
					
					$this->db->trans_complete();
					$responseary['status'] = 200;
					$responseary['msg'] = "Purchase new course successfully done.";
				
			echo json_encode($responseary);
			die();	
	}
	
	function createaudio_fromtext()
	{
		$title_str = urldecode($this->uri->segment(3));
		$audio_file = "testaudio.mp3"; 
		unlink($audio_file);
		$url = "https://translate.google.com.vn/translate_tts?ie=UTF-8&q=".urlencode($title_str)."&tl=en&client=tw-ob";	

								if (!function_exists('curl_init')) { // use file get contents 
										$output = file_get_contents($url); 
									} else { // use curl 
										$ch = curl_init(); 
										curl_setopt($ch, CURLOPT_URL, $url); 
										curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); 
										curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1"); 
										curl_setopt($ch, CURLOPT_HEADER, 0); 
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
										curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
										$output = curl_exec($ch); 
										curl_close($ch); 
									}
									$final_output = $output;
									file_put_contents($audio_file, $final_output);
					$audiofile = base_url().$audio_file;	
					echo '<a href="'.$audiofile.'" download> Download Audio </a>';	
	}
	
	public function child_complete_course()
	{
		$child_id = $this->uri->segment(3);
		$course_status = 2; // FINISH
		$data = array();
		$data['ss_aw_course_status'] = $course_status;
		$result = $this->ss_aw_child_course_model->updaterecord_child($child_id,$data);
		$response = array();
		if($result == 1)
			$response['msg'] = "Course Completed";
		else
			$response['msg'] = "Course update fail";
		echo json_encode($response);
		die();
	}
	
	public function child_restart_course()
	{
		$child_id = $this->uri->segment(3);
		$course_status = 1; // Running
		$data = array();
		$data['ss_aw_course_status'] = $course_status;
		$result = $this->ss_aw_child_course_model->updaterecord_child($child_id,$data);
		$this->ss_aw_assesment_questions_asked_model->deleterecord($child_id);
		$this->ss_aw_assessment_exam_log_model->deleterecord($child_id);
		
		$this->ss_aw_child_last_lesson_model->deleterecord_child($child_id);
		$this->ss_aw_lesson_quiz_ans_model->deleterecord($child_id);
		$this->ss_aw_current_lesson_model->deleterecord_child($child_id);
		
		$response = array();
		if($result == 1)
			$response['msg'] = "Course re-start again";
		else
			$response['msg'] = "Course update fail";
		echo json_encode($response);
		die();
	}

	//sayan code

	public function updatestudentfromEtoC(){
		$child_id = $this->uri->segment(3);
		if (!empty($child_id)) {
			$response = $this->ss_aw_child_course_model->getlastemergingcorsebychildid($child_id);
			if ($response) {
				$data = array(
					'ss_aw_course_id' => 2,
					'ss_aw_course_status' => 1
				);
				$check_update = $this->ss_aw_child_course_model->updatecourseEtoC($response[0]['ss_aw_child_course_id'], $data);
				$this->ss_aw_purchase_courses_model->updatecourseidafterpromote($child_id, 2);
				$responseary['msg'] = 'Student level updated successfully.';
			}
			else{
				$responseary['msg'] = 'Student has no emerging course.';
			}
		}
		else
		{
			$responseary['msg'] = 'Please send child id';
		}

		echo json_encode($responseary);
		die();
	}

	public function updatestudentfromCtoE(){
		$child_id = $this->uri->segment(3);
		if (!empty($child_id)) {
			$response = $this->ss_aw_child_course_model->getlastconsolatingcorsebychildid($child_id);
			if ($response) {
				$data = array(
					'ss_aw_course_id' => 1,
					'ss_aw_course_status' => 1
				);
				$check_update = $this->ss_aw_child_course_model->updatecourseEtoC($response[0]['ss_aw_child_course_id'], $data);
				$this->ss_aw_purchase_courses_model->updatecourseidafterpromote($child_id, 1);
				$responseary['msg'] = 'Student level updated successfully.';
			}
			else{
				$responseary['msg'] = 'Student has no consolating course.';
			}
		}
		else
		{
			$responseary['msg'] = 'Please send child id';
		}

		echo json_encode($responseary);
		die();
	}

	public function updatestudentfromEtoA(){

		$child_id = $this->uri->segment(3);
		if (!empty($child_id)) {
			$response = $this->ss_aw_child_course_model->getlastemergingcorsebychildid($child_id);
			if ($response) {
				$data = array(
					'ss_aw_course_id' => 3,
					'ss_aw_course_status' => 1
				);
				$check_update = $this->ss_aw_child_course_model->updatecourseEtoC($response[0]['ss_aw_child_course_id'], $data);
				$this->ss_aw_purchase_courses_model->updatecourseidafterpromote($child_id, 3);
				$responseary['msg'] = 'Student level updated successfully.';
			}
			else{
				$responseary['msg'] = 'Student has no emerging course.';
			}
		}
		else
		{
			$responseary['msg'] = 'Please send child id';
		}

		echo json_encode($responseary);
		die();
	}

	public function updatestudentfromCtoA(){

		$child_id = $this->uri->segment(3);
		if (!empty($child_id)) {
			$response = $this->ss_aw_child_course_model->getlastconsolidatedcorsebychildid($child_id);
			if ($response) {
				$data = array(
					'ss_aw_course_id' => 3,
					'ss_aw_course_status' => 1
				);
				$check_update = $this->ss_aw_child_course_model->updatecourseEtoC($response[0]['ss_aw_child_course_id'], $data);
				$this->ss_aw_purchase_courses_model->updatecourseidafterpromote($child_id, 3);
				$responseary['msg'] = 'Student level updated successfully.';
			}
			else{
				$responseary['msg'] = 'Student has no consolidated course.';
			}
		}
		else
		{
			$responseary['msg'] = 'Please send child id';
		}

		echo json_encode($responseary);
		die();
	}

	public function completelesson(){
		$child_id = $this->uri->segment(3);
		$lesson_id = $this->uri->segment(4);

		$lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
		$format = $lesson_detail[0]->ss_aw_lesson_format;
		$lesson_quiz_detail = $this->get_lesson_details_list($lesson_id, $child_id);

		if (!empty($lesson_quiz_detail)) {
			$lesson_quiz = json_decode($lesson_quiz_detail);
			if (!empty($lesson_quiz)) {
				if (!empty($lesson_quiz->result)) {
					if (!empty($lesson_quiz->result->data)) {
						foreach ($lesson_quiz->result->data as $key => $value) {
							if (!empty($value->details)) {
								$record_detail = $value->details;
								if (!empty($record_detail->quizes)) {
									
									//store curent lesson page index
									$lessonary = array();
									$lessonary['ss_aw_lesson_id'] = $lesson_id;
									$lessonary['ss_aw_child_id'] = $child_id;
									$lessonary['ss_aw_lesson_index'] = $value->index;
									$lessonary['ss_aw_updated_date'] = date('Y-m-d H:i:s');
									$lessonary['ss_aw_back_click_count'] = rand(0, 10);
									$response = $this->ss_aw_current_lesson_model->update_record($lessonary);
									if($response == 0)
									{
										$this->ss_aw_current_lesson_model->insert_data($lessonary);
									}
									//end

									$quizes = $record_detail->quizes;
									foreach ($quizes as $quiz) {
										if (!empty($quiz->question)) {
											$question = $quiz->question;
											$answers = "";
											if (!empty($quiz->answers)) {
												$answers = implode(",", $quiz->answers);
											}
											$options = "";
											if (!empty($quiz->options) && !empty($quiz->options[0])) {
												$options = implode(",", $quiz->options);
											}

											$postdata = array();
											$postdata['ss_aw_child_id'] = $child_id;
											$postdata['ss_aw_lesson_id'] = $lesson_id;
											$postdata['ss_aw_question'] = $question;
											$postdata['ss_aw_options'] = $options;
											$postdata['ss_aw_post_answer'] = $answers;
											$postdata['ss_aw_question_format'] = $quiz->qtype;
											$postdata['ss_aw_answer_status'] = rand(1, 2); // 1 = Right,2 = Wrong
											if ($format == 'Multiple') {
												$postdata['ss_aw_topic_id'] = $quiz->topic_id;
											}
											else
											{
												$postdata['ss_aw_topic_id'] = $lesson_quiz->result->topic_id;
											}
											
											$postdata['ss_aw_seconds_to_start_answer_question'] = 0;
											$postdata['ss_aw_seconds_to_answer_question'] = 0;
											
											/*
											Check particular Lesson Quiz already post by child or not
											*/
											$searchary = array();
											$searchary['ss_aw_child_id'] = $child_id;
											$searchary['ss_aw_lesson_id'] = $lesson_id;
											$searchary['ss_aw_question'] = $question;
											$searchdetailsary = array();
											$searchdetailsary = $this->ss_aw_lesson_quiz_ans_model->search_data_by_param($searchary);
											if(empty($searchdetailsary))
											{
												$this->ss_aw_lesson_quiz_ans_model->data_insert($postdata);
											}
											else
											{
												$record_id = $searchdetailsary[0]['ss_aw_id'];
												$postdata['ss_aw_id'] = $record_id;
												$this->ss_aw_lesson_quiz_ans_model->update_record($postdata);
											}
										}
									}
								}
							}
						}

						$childary = $this->ss_aw_child_course_model->get_details($child_id);
						$level = $childary[count($childary) - 1]['ss_aw_course_id'];

						$data = array();
						$data['ss_aw_child_id'] = $child_id;
						$data['ss_aw_lesson_id'] = $lesson_id;
						$data['ss_aw_lesson_level'] = $level;
						$data['ss_aw_lesson_status'] = 2;// 1 = Completed ,2 = Running
						$data['ss_aw_last_lesson_modified_date'] = date('Y-m-d H:i:s');
						$data['ss_aw_back_click_count'] = rand(0, 10);

						$response = $this->ss_aw_child_last_lesson_model->update_details($data);

						//get all score content to store
						$totalquestion = $this->ss_aw_lesson_quiz_ans_model->gettotalquestionbylessonchild($lesson_id, $child_id);

						$totalwrightanswer = $this->ss_aw_lesson_quiz_ans_model->gettotalwrightanswerbylessonchild($lesson_id, $child_id);

						$store_score = array(
							'child_id' => $child_id,
							'lesson_id' => $lesson_id,
							'total_question' => $totalquestion,
							'wright_answers' => $totalwrightanswer
						);

						$check_storage = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_id);
						if (!empty($check_storage)) {
							$this->ss_aw_lesson_score_model->update_data($store_score);
						}
						else
						{
							$this->ss_aw_lesson_score_model->store_data($store_score);
						}
						

						$responseary['status'] = 200;
						$responseary['msg'] = "Lesson completed successfully.";

						echo json_encode($responseary);
					}
				}
			}
		}

		die();
	}

	public function get_lesson_details_list($lesson_id, $child_id){
		//Get Current Lesson status
		$lessonary = array();
		$lessonary['ss_aw_lesson_id'] = $lesson_id;
		$lessonary['ss_aw_child_id'] = $child_id;
		$current_lesson_response = $this->ss_aw_current_lesson_model->fetch_record_byparam($lessonary); //Currently Reading Page
				
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];

		$searchary = array();
		$searchary['ss_aw_lesson_record_id'] = $lesson_id;
		//$searchary['ss_aw_course_id'] = $level_id;
		$lessonary = $this->ss_aw_lessons_model->search_data_by_param($searchary); 
		
		$startcourse = array();
		$startcourse['ss_aw_child_id'] = $child_id;
		$startcourse['ss_aw_lesson_level'] = $level_id;
		$startcourse['ss_aw_lesson_id'] = $lesson_id;
		$lastlesson_response = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($startcourse);
		if(empty($lastlesson_response))
		{
			$startcourse['ss_aw_lesson_format'] = $lessonary[0]['ss_aw_lesson_format'];
			$startcourse['ss_aw_last_lesson_create_date'] = date('Y-m-d H:i:s');
			$this->ss_aw_child_last_lesson_model->data_insert($startcourse);
		}
				
		if($level_id == 2)
		{
			$level = 'C';
		}
		else if($level_id == 1)
		{
			$level = 'E';
		}
		else if($level == 3)
		{
			$level = 'A';
		}
		else{
			$level = 'M';
		}
				
		$setting_result = array();
		$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
		$idletime = $setting_result[0]->ss_aw_time_skip;
		$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

		$resultary = array();
		$resultary['course'] = $level;
		$resultary['correct_answer_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_answer_audio;
		$resultary['skip_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_skip_audio;
		$resultary['correct_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_audio;
		$resultary['incorrect_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_incorrect_audio;
		$resultary['lesson_quiz_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_lesson_quiz_audio;
		$resultary['lesson_quiz_bad_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_bad_audio;
		if(!empty($current_lesson_response[0]['ss_aw_lesson_index']))
			$resultary['current_page_index'] = $current_lesson_response[0]['ss_aw_lesson_index'];
		else
			$resultary['current_page_index'] = "";
				
		if (!empty($current_lesson_response[0]['ss_aw_back_click_count'])) {
			$resultary['back_click_count'] = $current_lesson_response[0]['ss_aw_back_click_count'];
		}
		else
		{
			$resultary['back_click_count'] = "";
		}

		if(!empty($lessonary)){
			if($lessonary[0]['ss_aw_lesson_format'] == 'Multiple'){
				$i = 0;
				$resultary_inner1 = array();
				foreach($lessonary as $key=>$val){
					if($i == 0){		
						$useindexary[] = $val['ss_aw_lession_id'];
						$resultary_inner1['index'] = $val['ss_aw_lession_id'];
						$resultary_inner1['title'] = strip_tags($val['ss_aw_lesson_title']);
									
						$resultary_inner1['lesson_format'] = 2; // 1 = Single, 2 = Multiple
						$resultary_inner1['type'] = 1;  // 1 = Text, 2= Quiz
						$resultary_inner1['comprehension_question'] = 0;
									
						if(!empty($val['ss_aw_lesson_audio'])) 
						{
							$resultary_inner1['audio'] = base_url().$val['ss_aw_lesson_audio'];
						}
						else
						{
							$resultary_inner1['audio'] = "";
						}
									//$resultary['data'][0]['recap'] = 0;
						$resultary_inner1['details']['course'] = $val['ss_aw_course_id'];
						$resultary_inner1['details']['quizes'] = array();
						$resultary_inner1['details']['examples'] = array();	
					}
					$i++;
				}

				$resultary['data'][0] = $resultary_inner1;

				$lessonaryinterm = array();
				foreach($lessonary as $key=>$val){
					if($key > 0)
						$lessonaryinterm[] = $val;
				}
				$lessonary = array();
				$lessonary = $lessonaryinterm;
							
				$i = 0;
				$useindexary = array();		
				$r = 0;
				$previous_title = "";
				$firstvalue = trim($lessonary[0]['ss_aw_lesson_title']);

				$resultary_inner2 = array();
				foreach($lessonary as $key=>$val){
					if($i == 0){		
						$useindexary[] = $val['ss_aw_lession_id'];
						$resultary_inner2['index'] = $val['ss_aw_lession_id'];
						$resultary_inner2['title'] = strip_tags($val['ss_aw_lesson_title']);
									
						$resultary_inner2['lesson_format'] = 2; // 1 = Single, 2 = Multiple
						$resultary_inner2['type'] = 1;  // 1 = Text, 2= Quiz
						$resultary_inner2['comprehension_question'] = 1;	
									
										
									//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
									
						if(!empty($val['ss_aw_lesson_audio'])) 
						{
							$resultary_inner2['audio'] = base_url().$val['ss_aw_lesson_audio'];
						}
						else
						{
							$resultary_inner2['audio'] = "";
						}
									//$resultary['data'][0]['recap'] = 0;
						$resultary_inner2['details']['course'] = $val['ss_aw_course_id'];
						$resultary_inner2['details']['quizes'] = array();
						$resultary_inner2['details']['examples'] = array();	
					}
					$i++;
				}
				$resultary['data'][1] = $resultary_inner2;

				$i = 0;
				$resultary_inner = array();
				foreach($lessonary as $key=>$val){
					if($i == 0){			
						$useindexary[] = $val['ss_aw_lession_id'];
						$resultary_inner['index'] = $val['ss_aw_lession_id'];
						$resultary_inner['title'] = strip_tags($val['ss_aw_lesson_details']);
									
						$resultary_inner['lesson_format'] = 2; // 1 = Single, 2 = Multiple
						$resultary_inner['type'] = 2;  // 1 = Text, 2= Quiz
						$resultary_inner['comprehension_question'] = 1;
									
						if(!empty($val['ss_aw_lesson_details_audio'])) 
						{
							$resultary_inner['audio'] = base_url().$val['ss_aw_lesson_details_audio'];
						}
						else
						{
							$resultary_inner['audio'] = "";
						}
						
						$resultary_inner['details']['course'] = $val['ss_aw_course_id'];
									
						$resultary_inner['details']['quizes'][0]['topic_id'] = $val['ss_aw_lesson_topic'];
						$resultary_inner['details']['quizes'][0]['question'] = "";
						$resultary_inner['details']['quizes'][0]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
									
						$multiple_choice_ary = array();
						$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
										
						$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
						if(!empty($multiple_choice_ary))
							$resultary_inner['details']['quizes'][0]['options'] = $multiple_choice_ary;
						else
							$resultary_inner['details']['quizes'][0]['options'] = array();
										
						$answersary = array();
						$answersary = explode("/",trim(strip_tags($val['ss_aw_lesson_answers'])));
										
						$answersary = array_map('trim',$answersary);
						if(!empty($answersary)){
							$resultary_inner['details']['quizes'][0]['answers'] = $answersary;
							$resultary_inner['details']['quizes'][0]['answeraudio'] = base_url().$val['ss_aw_lesson_answers_audio'];
						}
						else{
							$resultary_inner['details']['quizes'][0]['answers'] = array();
							$resultary_inner['details']['quizes'][0]['answeraudio'] = "";
						}
											
					}
					$i++;				
				}			
				array_push($resultary['data'],$resultary_inner);

				$resultary_inner3 = array();
						
				$i = 0;
				$j = 0;
				foreach($lessonary as $key=>$val){
								
					if(($i > 0) && trim($firstvalue) == trim($val['ss_aw_lesson_title'])){
						$useindexary[] = $val['ss_aw_lession_id'];
						$resultary_inner3[$j]['index'] = $val['ss_aw_lession_id'];
						$resultary_inner3[$j]['title'] = strip_tags($val['ss_aw_lesson_details']);
									
						$resultary_inner3[$j]['lesson_format'] = 2; // 1 = Single, 2 = Multiple
						$resultary_inner3[$j]['type'] = 2;  // 1 = Text, 2= Quiz
						$resultary_inner3[$j]['comprehension_question'] = 1;
									
						if(!empty($val['ss_aw_lesson_details_audio'])) 
						{
							$resultary_inner3[$j]['audio'] = base_url().$val['ss_aw_lesson_details_audio'];
						}
						else
						{
							$resultary_inner3[$j]['audio'] = "";
						}
									//$resultary['data'][0]['recap'] = 0;
						$resultary_inner3[$j]['details']['course'] = $val['ss_aw_course_id'];
									
						$resultary_inner3[$j]['details']['quizes'][0]['topic_id'] = $val['ss_aw_lesson_topic'];
						$resultary_inner3[$j]['details']['quizes'][0]['question'] = "";
						$resultary_inner3[$j]['details']['quizes'][0]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
									
						$multiple_choice_ary = array();
						$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
										
						$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
						if(!empty($multiple_choice_ary))
							$resultary_inner3[$j]['details']['quizes'][0]['options'] = $multiple_choice_ary;
						else
							$resultary_inner3[$j]['details']['quizes'][0]['options'] = array();
										
						$answersary = array();
						$answersary = explode("/",trim(strip_tags($val['ss_aw_lesson_answers'])));
										
						$answersary = array_map('trim',$answersary);
						if(!empty($answersary))
						{
							$resultay_inner3[$j]['details']['quizes'][0]['answers'] = $answersary;
							$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = base_url().$val['ss_aw_lesson_answers_audio'];
						}
						else{
							$resultary_inner3[$j]['details']['quizes'][0]['answers'] = array();
							$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = "";
						}
										
						$j++;
					}
					$i++;
				}

				foreach($resultary_inner3 as $value)
					array_push($resultary['data'],$value);		
			
						
				$i = $j + 2;
						
				$previous_title = "";	
				$firstvalue = trim($lessonary[0]['ss_aw_lesson_title']);
				foreach($lessonary as $key=>$val){
					if(!in_array($val['ss_aw_lession_id'],$useindexary)){
						if($firstvalue != trim($val['ss_aw_lesson_title'])){
							if($previous_title != trim($val['ss_aw_lesson_title'])){
								$i++;
								$j = 0;
								$r = 0;
							}
							else if($previous_title == trim($val['ss_aw_lesson_title'])){
								if(!empty($val['ss_aw_lesson_details']))
									$j++;
							}

							$previous_title = trim($val['ss_aw_lesson_title']);
							$resultary['data'][$i]['index'] = $val['ss_aw_lession_id'];
							if($val['ss_aw_lesson_format'] == 'Single')
								$resultary['data'][$i]['lesson_format'] = 1;
							else
								$resultary['data'][$i]['lesson_format'] = 2;
							
							$resultary['data'][$i]['type'] = 2;
							$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
							$resultary['data'][$i]['title'] = strip_tags($val['ss_aw_lesson_title']);
							if(!empty($val['ss_aw_lesson_audio']))
								$resultary['data'][$i]['audio'] = base_url().$val['ss_aw_lesson_audio'];
							else
								$resultary['data'][$i]['audio'] = "";
							
							
							$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);
							
							
							$resultary['data'][$i]['details']['examples'] = array();
							
							if($val['ss_aw_lesson_quiz_type_id'] > 0)
							{
								$resultary['data'][$i]['details']['quizes'][$j]['topic_id'] = $val['ss_aw_lesson_topic'];
								$resultary['data'][$i]['details']['quizes'][$j]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
								$resultary['data'][$i]['details']['quizes'][$j]['question'] = strip_tags($val['ss_aw_lesson_details']);
								$multiple_choice_ary = array();
								$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
								
								$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
								//if(count($multiple_choice_ary) > 1)
									$resultary['data'][$i]['details']['quizes'][$j]['options'] = $multiple_choice_ary;
								//else
									//$resultary['data'][$i]['details']['quizes'][$j]['options'] = $val['ss_aw_lesson_question_options'];
								
								$answersary = array();
								$answersary = explode("/",trim(strip_tags($val['ss_aw_lesson_answers'])));
								
								$answersary = array_map('trim',$answersary);
								
								$resultary['data'][$i]['details']['quizes'][$j]['answers'] = $answersary;
								//$resultary['data'][$i]['details']['quizes'][$j]['answer'] = $val['ss_aw_lesson_answers'];
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = base_url().$val['ss_aw_lesson_answers_audio'];
							}
							else
							{
								$resultary['data'][$i]['details']['quizes'] = array();
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = "";
							}
								
						}
							
					}
				}

				$responseary['status'] = '200';
				$responseary['msg'] = 'Data Found';
				$responseary['result'] = $resultary;
			}
			else
			{
				$resultary['topic_id'] = $lessonary[0]['ss_aw_lesson_topic'];
				$i = 0;	
				$j = 0;
				$r = 0;
				$previous_title = $lessonary[0]['ss_aw_lesson_title'];
				$resultary['data'][$i]['index'] = $lessonary[0]['ss_aw_lession_id'];
				if($lessonary[0]['ss_aw_lesson_format'] == 'Single')
					$resultary['data'][$i]['lesson_format'] = 1;
				else
					$resultary['data'][$i]['lesson_format'] = 2;
							
				$resultary['data'][$i]['type'] = $lessonary[0]['ss_aw_lesson_format_type'];
				$resultary['data'][$i]['topic_format_id'] = $lessonary[0]['ss_aw_topic_format_id'];
				$resultary['data'][$i]['title'] = strip_tags($lessonary[0]['ss_aw_lesson_title']);
				if(!empty($lessonary[0]['ss_aw_lesson_audio']))
					$resultary['data'][$i]['audio'] = base_url().$lessonary[0]['ss_aw_lesson_audio'];
				else
					$resultary['data'][$i]['audio'] = "";
				if($lessonary[0]['ss_aw_lessons_recap'] == 'YES')
					$resultary['data'][$i]['recap'] = 1;
				else
					$resultary['data'][$i]['recap'] = 0;
				$resultary['data'][$i]['details']['course'] = intval($lessonary[0]['ss_aw_course_id']);
				$resultary['data'][$i]['details']['duration'] = $idletime;
				if(!empty($lessonary[0]['ss_aw_lesson_details'])){
					$resultary['data'][$i]['details']['examples'][$j]['subindex'] = $j;
					$resultary['data'][$i]['details']['examples'][$j]['data'] = strip_tags($lessonary[0]['ss_aw_lesson_details']);
					if(!empty($lessonary[0]['ss_aw_lesson_details_audio']))
						$resultary['data'][$i]['details']['examples'][$j]['audio'] = base_url().$lessonary[0]['ss_aw_lesson_details_audio'];
					else 
						$resultary['data'][$i]['details']['examples'][$j]['audio'] = "";
					if($lessonary[0]['ss_aw_lessons_recap'] == 'YES')
						$resultary['data'][$i]['details']['examples'][$j]['recap'] = 1;
					else
						$resultary['data'][$i]['details']['examples'][$j]['recap'] = 0;
				}
				else
				{
					$resultary['data'][$i]['details']['examples'] = array();
				}
				$resultary['data'][$i]['details']['course'] = intval($lessonary[0]['ss_aw_course_id']);
				if($lessonary[0]['ss_aw_lesson_quiz_type_id'] > 0)
				{
					$resultary['data'][$i]['details']['quizes'][0]['qtype'] = $lessonary[0]['ss_aw_lesson_quiz_type_id'];
					$resultary['data'][$i]['details']['quizes'][0]['question'] = ($lessonary[0]['ss_aw_lesson_details']);
					$multiple_choice_ary = array();
					$multiple_choice_ary = explode(",",trim($lessonary[0]['ss_aw_lesson_question_options']));
								
					$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
					//if(count($multiple_choice_ary) > 1)
						$resultary['data'][$i]['details']['quizes'][0]['options'] = $multiple_choice_ary;
					//else
						//$resultary['data'][$i]['details']['quizes'][0]['options'] = $lessonary[0]['ss_aw_lesson_question_options'];
								
					$answersary = array();
					$answersary = explode("/",trim(strip_tags($lessonary[0]['ss_aw_lesson_answers'])));
					$answersary = array_map('trim',$answersary);
					$resultary['data'][$i]['details']['quizes'][0]['answers'] = $answersary;
								
					$resultary['data'][$i]['details']['quizes'][0]['answeraudio'] = base_url().$lessonary[0]['ss_aw_lesson_answers_audio'];
				}
				else
				{
					$resultary['data'][$i]['details']['quizes'] = array();
					$resultary['data'][$i]['details']['quizes'][0]['answeraudio'] = "";
				}

				foreach($lessonary as $key=>$val){
					if($previous_title != $val['ss_aw_lesson_title']){
						$i++;
						$j = 0;
						$r = 0;
					}
					else if($previous_title == $val['ss_aw_lesson_title']){
						if(!empty($val['ss_aw_lesson_details']))
						$j++;
					}
					$previous_title = $val['ss_aw_lesson_title'];
							
					$resultary['data'][$i]['index'] = $val['ss_aw_lession_id'];
					if($val['ss_aw_lesson_format'] == 'Single')
						$resultary['data'][$i]['lesson_format'] = 1;
					else
						$resultary['data'][$i]['lesson_format'] = 2;
							
					$resultary['data'][$i]['type'] = $val['ss_aw_lesson_format_type'];
					$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
					$resultary['data'][$i]['title'] = strip_tags($val['ss_aw_lesson_title']);
					if(!empty($val['ss_aw_lesson_audio']))
						$resultary['data'][$i]['audio'] = base_url().$val['ss_aw_lesson_audio'];
					else
						$resultary['data'][$i]['audio'] = "";
					if($val['ss_aw_lessons_recap'] == 'YES' && $r == 0)
					{
						$r++;
						$resultary['data'][$i]['recap'] = 1;
					}
					else if($r == 0)
					{
						$resultary['data'][$i]['recap'] = 0;
					}
							
					$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);
					$resultary['data'][$i]['details']['duration'] = $idletime;
					if($val['ss_aw_lesson_format_type'] != 2)
					{
						if(!empty($val['ss_aw_lesson_details']))
						{
						$resultary['data'][$i]['details']['examples'][$j]['subindex'] = $j;
							$resultary['data'][$i]['details']['examples'][$j]['data'] = strip_tags($val['ss_aw_lesson_details']);
							if(!empty($val['ss_aw_lesson_details_audio']))
								$resultary['data'][$i]['details']['examples'][$j]['audio'] = base_url().$val['ss_aw_lesson_details_audio'];
							else 
								$resultary['data'][$i]['details']['examples'][$j]['audio'] = "";
									
							if($val['ss_aw_lessons_recap'] == 'YES')
								$resultary['data'][$i]['details']['examples'][$j]['recap'] = 1;
							else
								$resultary['data'][$i]['details']['examples'][$j]['recap'] = 0;
									//$resultary['data'][$i]['details']['example']['audio'] = $val['ss_aw_lesson_audio'];
							$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);
						}
						else
						{
							$resultary['data'][$i]['details']['examples'] = array();
						}
					}
					else
					{
						$resultary['data'][$i]['details']['examples'] = array();
					}
							
					if($val['ss_aw_lesson_quiz_type_id'] > 0)
					{
						$resultary['data'][$i]['details']['quizes'][$j]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
						$resultary['data'][$i]['details']['quizes'][$j]['question'] = strip_tags($val['ss_aw_lesson_details']);
						$multiple_choice_ary = array();
						$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
								
						$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
								//if(count($multiple_choice_ary) > 1)
							$resultary['data'][$i]['details']['quizes'][$j]['options'] = $multiple_choice_ary;
								//else
									//$resultary['data'][$i]['details']['quizes'][$j]['options'] = $val['ss_aw_lesson_question_options'];
								
						$answersary = array();
						$answersary = explode("/",trim(strip_tags($val['ss_aw_lesson_answers'])));
								
						$answersary = array_map('trim',$answersary);
								
						$resultary['data'][$i]['details']['quizes'][$j]['answers'] = $answersary;
								
						$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = base_url().$val['ss_aw_lesson_answers_audio'];
					}
					else
					{
						$resultary['data'][$i]['details']['quizes'] = array();
						$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = "";
					}	
				}

				$responseary['status'] = '200';
				$responseary['msg'] = 'Data Found';
				$responseary['result'] = $resultary;
			}
		}

		return json_encode($responseary);
	}

	public function completeassessment(){
			$child_id = $this->uri->segment(3);
			$assessment_id = $this->uri->segment(4);
			$assessment_exam_code = "";
			$this->db->trans_start();
		

			$back_click_count = 0;
			$check_existance = $this->ss_aw_assessment_exam_completed_model->getexamdetail($assessment_id, $child_id);
			//if (empty($check_existance)) {
			{
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];

				$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
				if (!empty($assessment_details)) {
					$assessemnt_format = $assessment_details[0]->ss_aw_assesment_format;
					if ($assessemnt_format == 'Single') {
						$assessment_question_detail = $this->assessment_exam_question_first_question($child_id, $assessment_id);
						$assessment_first_questions = json_decode($assessment_question_detail);
						
						if (!empty($assessment_first_questions)) {
							if (!empty($assessment_first_questions->data)) {
								$assessment_first_set = $assessment_first_questions->data;
								$exam_code = $assessment_first_questions->assessment_exam_code;
								$assessment_exam_code = $exam_code;
								foreach ($assessment_first_set as $key => $value) {
									$question_id = $value->question_id;
									$answers_post = "";
									$right_answers = "";
									$answers_status = rand(1, 2);

									$searchary = array();
									$searchary['ss_aw_id'] = $question_id;
									$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);

									$level = $question_detailsary[0]['ss_aw_level']; // E,C,A
									$category = $question_detailsary[0]['ss_aw_category']; 
									$sub_category = $question_detailsary[0]['ss_aw_sub_category']; 
									$weight = $question_detailsary[0]['ss_aw_weight'];
									
									$storedata = array();
									$storedata['ss_aw_log_child_id'] = $child_id;
									$storedata['ss_aw_log_question_id'] = $question_id;
									$storedata['ss_aw_log_level'] = $level;
									$storedata['ss_aw_log_category'] = $category;
									$storedata['ss_aw_log_subcategory'] = $sub_category;
									$storedata['ss_aw_log_answers'] = $answers_post;
									$storedata['ss_aw_log_weight'] = $weight;
									$storedata['ss_aw_log_right_answers'] = $right_answers;
									$storedata['ss_aw_log_answer_status'] = $answers_status;  // 1 = Right, 2 = Wrong, 3= Skip
									$storedata['ss_aw_log_exam_code'] = $exam_code;
									
									$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
								}
							}
						}
						$assessment_next_level_question = $this->assessment_exam_question_next_level_subcategory($child_id, $assessment_id, $assessment_first_questions->assessment_exam_code);
						$assessment_next_questions = json_decode($assessment_next_level_question);
						if (!empty($assessment_next_questions)) {
							if (!empty($assessment_next_questions->data)) {
								$assessment_second_set = $assessment_next_questions->data;
								$exam_code = $assessment_next_questions->assessment_exam_code;
								foreach ($assessment_second_set as $key => $value) {
									$question_id = $value->question_id;
									$answers_post = "";
									$right_answers = "";
									$answers_status = rand(1, 2);

									$searchary = array();
									$searchary['ss_aw_id'] = $question_id;
									$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);

									$level = $question_detailsary[0]['ss_aw_level']; // E,C,A
									$category = $question_detailsary[0]['ss_aw_category']; 
									$sub_category = $question_detailsary[0]['ss_aw_sub_category']; 
									$weight = $question_detailsary[0]['ss_aw_weight'];
									
									$storedata = array();
									$storedata['ss_aw_log_child_id'] = $child_id;
									$storedata['ss_aw_log_question_id'] = $question_id;
									$storedata['ss_aw_log_level'] = $level;
									$storedata['ss_aw_log_category'] = $category;
									$storedata['ss_aw_log_subcategory'] = $sub_category;
									$storedata['ss_aw_log_answers'] = $answers_post;
									$storedata['ss_aw_log_weight'] = $weight;
									$storedata['ss_aw_log_right_answers'] = $right_answers;
									$storedata['ss_aw_log_answer_status'] = $answers_status;  // 1 = Right, 2 = Wrong, 3= Skip
									$storedata['ss_aw_log_exam_code'] = $exam_code;
									
									$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
								}
							}
						}

						
						$topic_detail = $this->ss_aw_assesment_uploaded_model->gettopic($assessment_id);
						$total_subtopic = $this->ss_aw_sections_subtopics_model->totalnoofsubtopic($topic_detail[0]->ss_aw_assesment_topic_id);

						$searchary = array();
						$searchary['ss_aw_sub_section_no'] = $total_subtopic;
						$get_assessment_quiz_matrix = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($searchary);

						if (!empty($get_assessment_quiz_matrix)) {
							$total_questions = $total_subtopic * $get_assessment_quiz_matrix[0]['ss_aw_total_question'];	
						}
						else
						{
							$total_questions = 0;
						}

						$wright_answers = $this->ss_aw_assessment_exam_log_model->totalnoofcorrectanswers($assessment_exam_code, $child_id);
					}
					else
					{
						$assessment_multiple_questions = $this->assessment_exam_format_two_questions($child_id, $assessment_id);
						$assessment_multiple_question_detail = json_decode($assessment_multiple_questions);

						if (!empty($assessment_multiple_question_detail)) {
							if (!empty($assessment_multiple_question_detail->result)) {
								if (!empty($assessment_multiple_question_detail->result->data)) {
									foreach ($assessment_multiple_question_detail->result->data as $key => $value) {
										if (!empty($value->details)) {
											$record_detail = $value->details;
											if (!empty($record_detail->quizes)) {
												$quiz_question = $record_detail->quizes;
												foreach ($quiz_question as $quiz) {
											   		$assessment_exam_code = $assessment_multiple_question_detail->assessment_exam_code;
											   		
											   		if (!empty($quiz->question)) {
											   			$question = $quiz->question;
											   		}
											   		else
											   		{
											   			$question = $value->title;
											   		}
						
											   		$topic_id = $quiz->topic_id;
											   		if (empty($topic_id)) {
											   			$topic_id = 0;
											   		}
											   		$answer = "";
											   		/*if (!empty($quiz->answers)) {
											   			$answer = implode(",", $quiz->answers);
											   		}*/
											   		
											   		$right_answers = "";
											   		if (!empty($quiz->answers)) {
											   			$right_answers = implode(",", $quiz->answers);
											   		}
											   		
											   		$answers_status = rand(1, 2);
											   		$seconds_to_start_answer_question = 0;
											   		$seconds_to_answer_question = 0;

											   		$data = array(
											   			'ss_aw_child_id' => $child_id,
											   			'ss_aw_assessment_id' => $assessment_id,
											   			'ss_aw_assessment_exam_code' => $assessment_exam_code,
											   			'ss_aw_question' => $question,
											   			'ss_aw_topic_id' => $topic_id,
											   			'ss_aw_answer' => $answer,
											   			'ss_aw_right_answers' => $right_answers,
											   			'ss_aw_answers_status' => $answers_status,
											   			'ss_aw_seconds_to_start_answer_question' => $seconds_to_start_answer_question,
											   			'ss_aw_seconds_to_answer_question' => $seconds_to_answer_question,
											   			'ss_aw_created_at' => date('Y-m-d h:i:s')
											   		);

											   		
											   		$check_existance = $this->ss_aw_assesment_multiple_question_answer_model->check_data($data);

											   		if ($check_existance) {
											   			$record_id = $check_existance[0]->ss_aw_id;
											   			$this->ss_aw_assesment_multiple_question_answer_model->update_record($data, $record_id);
											   			$msg = "Assesment answer record updated successfully.";
											   		}
											   		else
											   		{
											   			$this->ss_aw_assesment_multiple_question_answer_model->store_data($data);
											   			$msg = "Assesment answer record stored successfully.";
											   		}


											   		$assessmentary = array();
													$assessmentary['ss_aw_assessment_id'] = $assessment_id;
													$assessmentary['ss_aw_child_id'] = $child_id;
													$assessmentary['ss_aw_page_index'] = $value->index;
													$assessmentary['ss_aw_exam_code'] = $assessment_exam_code;
													$assessmentary['ss_aw_created_at'] = date('Y-m-d H:i:s');
													$assessmentary['ss_aw_back_click_count'] = 0;

													$check_current_status = $this->ss_aw_assesment_multiple_question_asked_model->check_existance($value->index, $assessment_id, $child_id, $assessment_exam_code);

													if ($check_current_status == 0) {
														$this->ss_aw_assesment_multiple_question_asked_model->insert_record($assessmentary);
													}

												}
											}
										}
									}
								}
							}
						}
						$total_questions = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofquestionasked($assessment_id, $child_id);
						$wright_answers = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofcorrectanswers($assessment_id, $child_id);
					}
					
					$insert_data = array();
					$insert_data['ss_aw_assessment_id'] = $assessment_id;
					$insert_data['ss_aw_assessment_topic'] = $assessment_details[0]->ss_aw_assesment_topic;
					$insert_data['ss_aw_exam_code'] = $assessment_exam_code;
					$insert_data['ss_aw_child_id'] = $child_id;
					$insert_data['ss_aw_back_click_count'] = 0;
					$response = $this->ss_aw_assessment_exam_completed_model->insert_data($insert_data);
					if ($level_id == 1 || $level_id == 2) {
						$level = "E";
					}
					elseif ($level_id == 3) {
						$level = "A";
					}
					else{
						$level = "M";
					}
					if ($response) {
						$store_score = array(
							'child_id' => $child_id,
							'level' => $level,
							'exam_code' => $assessment_exam_code,
							'assessment_id' => $assessment_id,
							'assessment_topic' => $assessment_details[0]->ss_aw_assesment_topic,
							'total_question' => $total_questions,
							'wright_answers' => $wright_answers
						);

						$check_insertion = $this->ss_aw_assessment_score_model->store_data($store_score);	
						if ($check_insertion) {
							$responseary['status'] = '200';
							$responseary['msg'] = 'Assessment exam completed.';	
						}
							
					}
				}
			}

		$this->db->trans_complete();

		echo json_encode($responseary);

		$this->session->set_flashdata('success','Assessment completed successfully.');
		redirect('testingapi/lesson_assessment_completion_view');
	}

	public function assessment_exam_format_two_questions($child_id, $assessment_id)
	{	
		$responseary = array();
		//if($inputpost)
		{
			
			//if($this->check_child_existance($child_id,$child_token)) // Check provider Token valid or not against child_id and token
			{
				$exam_code = time()."_".$child_id;
				$lessonary = array();
				$lessonary['ss_aw_child_id'] = $child_id;
				
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];
				
				$searchary = array();
				$searchary['ss_aw_uploaded_record_id'] = $assessment_id;
				$lessonary = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($searchary);

				if($level_id == 2)
					{
						$level = 'C';
					}
					else if($level_id == 1)
					{
						$level = 'E';
					}
					else if($level == 3)
					{
						$level = 'A';
					}
					

						$setting_result = array();
						$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
						$idletime = $setting_result[0]->ss_aw_time_skip;
						$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
						
						$resultary = array();
						$resultary['course'] = $level;
						$responseary['status'] = 200;
						$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
						$responseary['correct_answer_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_answer_audio;
						$responseary['skip_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_skip_audio;
						$responseary['warning_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_warning_audio;
						$responseary['correct_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_audio;
						$responseary['incorrect_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_incorrect_audio;
						$responseary['lesson_quiz_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_lesson_quiz_audio;
						$responseary['lesson_quiz_bad_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_bad_audio;
						$responseary['skip_duration'] = $idletime;
						$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
						$responseary['assessment_exam_code'] = $exam_code;
						$responseary['assessment_id'] = $assessment_id;


					
					if(!empty($lessonary))
					{
						if($lessonary[0]['ss_aw_format'] == 'Multiple')
						{
								/////////////// First Data section ///////////////////////////////
								$i = 0;
								$resultary_inner1 = array();
								foreach($lessonary as $key=>$val)
								{
									if($i == 0)
									{		
										$useindexary[] = $val['ss_aw_id'];
										$resultary_inner1['index'] = $val['ss_aw_id'];
										$resultary_inner1['title'] = strip_tags($val['ss_aw_question_preface']);
										
										$resultary_inner1['assesment_format'] = 2; // 1 = Single, 2 = Multiple
										$resultary_inner1['type'] = 1;  // 1 = Text, 2= Quiz
										$resultary_inner1['comprehension_question'] = 0;	
										
											
										//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
										
										if(!empty($val['ss_aw_question_preface_audio'])) 
										{
											$resultary_inner1['audio'] = base_url().$val['ss_aw_question_preface_audio'];
										}
										else
										{
											$resultary_inner1['audio'] = "";
										}
										//$resultary['data'][0]['recap'] = 0;
										$resultary_inner1['details']['course'] = $val['ss_aw_level'];
										$resultary_inner1['details']['quizes'] = array();
										$resultary_inner1['details']['examples'] = array();	
									}
									$i++;
								}
								$resultary['data'][0] = $resultary_inner1;


					$lessonaryinterm = array();
							foreach($lessonary as $key=>$val)
							{
								if($key > 0)
									$lessonaryinterm[] = $val;
							}
							$lessonary = array();
							$lessonary = $lessonaryinterm;
							
							$i = 0;
							$useindexary = array();		
										$r = 0;
							$previous_title = "";
							$firstvalue = trim($lessonary[0]['ss_aw_question_preface']);
							$resultary_inner2 = array();
							foreach($lessonary as $key=>$val)
							{
								if($i == 0)
								{		
									$useindexary[] = $val['ss_aw_id'];
									$resultary_inner2['index'] = $val['ss_aw_id'];
									$resultary_inner2['title'] = strip_tags($val['ss_aw_question_preface']);
									
									$resultary_inner2['assesment_format'] = 2; // 1 = Single, 2 = Multiple
									$resultary_inner2['type'] = 1;  // 1 = Text, 2= Quiz
									$resultary_inner2['comprehension_question'] = 1;	
									
										
									//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
									
									if(!empty($val['ss_aw_question_preface_audio'])) 
									{
										$resultary_inner2['audio'] = base_url().$val['ss_aw_question_preface_audio'];
									}
									else
									{
										$resultary_inner2['audio'] = "";
									}
									//$resultary['data'][0]['recap'] = 0;
									$resultary_inner2['details']['course'] = $val['ss_aw_level'];
									$resultary_inner2['details']['quizes'] = array();
									$resultary_inner2['details']['examples'] = array();	
								}
								$i++;
							}
							$resultary['data'][1] = $resultary_inner2;
							$i = 0;
							$resultary_inner = array();
							foreach($lessonary as $key=>$val)
							{
								if($i == 0)
								{			
									$useindexary[] = $val['ss_aw_id'];
									$resultary_inner['index'] = $val['ss_aw_id'];
									$resultary_inner['title'] = strip_tags($val['ss_aw_question']);
									
									$resultary_inner['assesment_format'] = 2; // 1 = Single, 2 = Multiple
									$resultary_inner['type'] = 2;  // 1 = Text, 2= Quiz
									$resultary_inner['comprehension_question'] = 1;
									$resultary_inner['audio'] = "";
									if (!empty($val['ss_aw_question_audio'])) {
										$resultary_inner['audio'] = base_url().$val['ss_aw_question_audio'];
									}
									//$resultary['data'][0]['recap'] = 0;
									$resultary_inner['details']['course'] = $val['ss_aw_level'];
									
									$resultary_inner['details']['quizes'][0]['topic_id'] = $val['ss_aw_question_topic_id'];
									$resultary_inner['details']['quizes'][0]['question'] = "";
									if ($val['ss_aw_question_format'] == 'Choose the right answer') {
										$qtype = 2;
									}
									elseif($val['ss_aw_question_format'] == 'Fill in the blanks'){
										$qtype = 1;
									}
									elseif($val['ss_aw_question_format'] == 'Rewrite the sentence'){
										$qtype = 3;
									}
									else
									{
										$qtype = 0;
									}
									$resultary_inner['details']['quizes'][0]['qtype'] = $qtype;
									
									$multiple_choice_ary = array();
										$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
										
										$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
										if(!empty($multiple_choice_ary))
											$resultary_inner['details']['quizes'][0]['options'] = $multiple_choice_ary;
										else
											$resultary_inner['details']['quizes'][0]['options'] = array();
										
										$answersary = array();
										$answersary = explode("/",trim(strip_tags($val['ss_aw_answers'])));
										
										$answersary = array_map('trim',$answersary);
										if(!empty($answersary))
										{
											$resultary_inner['details']['quizes'][0]['answers'] = $answersary;
											$resultary_inner['details']['quizes'][0]['answeraudio'] = base_url().$val['ss_aw_answers_audio'];
										}
										else{
											$resultary_inner['details']['quizes'][0]['answers'] = array();
											$resultary_inner['details']['quizes'][0]['answeraudio'] = "";
										}
											
								}
								$i++;
								
							}
							
							array_push($resultary['data'],$resultary_inner);
							
							$resultary_inner3 = array();
						
							$i = 0;
							$j = 0;
							foreach($lessonary as $key=>$val)
							{
								
								if(($i > 0) && trim($firstvalue) == trim($val['ss_aw_question_preface']))
								{
									$useindexary[] = $val['ss_aw_id'];
									$resultary_inner3[$j]['index'] = $val['ss_aw_id'];
									$resultary_inner3[$j]['title'] = strip_tags($val['ss_aw_question']);
									
									$resultary_inner3[$j]['assesment_format'] = 2; // 1 = Single, 2 = Multiple
									$resultary_inner3[$j]['type'] = 2;  // 1 = Text, 2= Quiz
									$resultary_inner3[$j]['comprehension_question'] = 1;
									$resultary_inner3[$j]['audio'] = "";
									if (!empty($val['ss_aw_question_audio'])) {
										$resultary_inner3[$j]['audio'] = base_url().$val['ss_aw_question_audio'];
									}

									//$resultary['data'][0]['recap'] = 0;
									$resultary_inner3[$j]['details']['course'] = $val['ss_aw_level'];
									
									$resultary_inner3[$j]['details']['quizes'][0]['topic_id'] = $val['ss_aw_question_topic_id'];
									$resultary_inner3[$j]['details']['quizes'][0]['question'] = "";

									if ($val['ss_aw_question_format'] == 'Choose the right answer') {
										$qtype = 2;
									}
									elseif($val['ss_aw_question_format'] == 'Fill in the blanks'){
										$qtype = 1;
									}
									elseif($val['ss_aw_question_format'] == 'Rewrite the sentence'){
										$qtype = 3;
									}
									else
									{
										$qtype = 0;
									}

									$resultary_inner3[$j]['details']['quizes'][0]['qtype'] = $qtype;
									
									$multiple_choice_ary = array();
										$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
										
										$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
										if(!empty($multiple_choice_ary))
											$resultary_inner3[$j]['details']['quizes'][0]['options'] = $multiple_choice_ary;
										else
											$resultary_inner3[$j]['details']['quizes'][0]['options'] = array();
										
										$answersary = array();
										$answersary = explode("/",trim(strip_tags($val['ss_aw_answers'])));
										
										$answersary = array_map('trim',$answersary);
										if(!empty($answersary))
										{
											$resultary_inner3[$j]['details']['quizes'][0]['answers'] = $answersary;
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = base_url().$val['ss_aw_answers_audio'];
										}
										else{
											$resultary_inner3[$j]['details']['quizes'][0]['answers'] = array();
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = "";
										}
										
										$j++;
								}
								$i++;
							}


					foreach($resultary_inner3 as $value)
						array_push($resultary['data'],$value);		
		
						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						$i = $j + 2;
						
						$previous_title = "";	
						$firstvalue = trim($lessonary[0]['ss_aw_question_preface']);
						foreach($lessonary as $key=>$val)
						{
							if(!in_array($val['ss_aw_id'],$useindexary))
							{
								if($firstvalue != trim($val['ss_aw_question_preface']))
								{
							if($previous_title != trim($val['ss_aw_question_preface']))
								{
									$i++;
									$j = 0;
									$r = 0;
								}
								else if($previous_title == trim($val['ss_aw_question_preface']))
								{
									if(!empty($val['ss_aw_question_preface']))
										$j++;
								}
								$previous_title = trim($val['ss_aw_question_preface']);
								
								$resultary['data'][$i]['index'] = $val['ss_aw_id'];
								if($val['ss_aw_format'] == 'Single')
									$resultary['data'][$i]['assesment_format'] = 1;
								else
									$resultary['data'][$i]['assesment_format'] = 2;
								
								$resultary['data'][$i]['type'] = 2;
								/*$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];*/
								$resultary['data'][$i]['title'] = strip_tags($val['ss_aw_question_preface']);
								if(!empty($val['ss_aw_question_preface_audio']))
									$resultary['data'][$i]['audio'] = base_url().$val['ss_aw_question_preface_audio'];
								else
									$resultary['data'][$i]['audio'] = "";
								
								
								$resultary['data'][$i]['details']['course'] = $val['ss_aw_level'];
								
								
								$resultary['data'][$i]['details']['examples'] = array();
								
								if ($val['ss_aw_question_format'] == 'Choose the right answer') {
									$qtype = 2;
								}
								elseif($val['ss_aw_question_format'] == 'Fill in the blanks'){
									$qtype = 1;
								}
								elseif($val['ss_aw_question_format'] == 'Rewrite the sentence'){
									$qtype = 3;
								}
								else
								{
									$qtype = 0;
								}

								if($qtype > 0)
								{
									$resultary['data'][$i]['details']['quizes'][$j]['topic_id'] = $val['ss_aw_question_topic_id'];
									$resultary['data'][$i]['details']['quizes'][$j]['qtype'] = $qtype;
									$resultary['data'][$i]['details']['quizes'][$j]['question'] = strip_tags($val['ss_aw_question']);
									$multiple_choice_ary = array();
									$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
									
									$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
									//if(count($multiple_choice_ary) > 1)
										$resultary['data'][$i]['details']['quizes'][$j]['options'] = $multiple_choice_ary;
									//else
										//$resultary['data'][$i]['details']['quizes'][$j]['options'] = $val['ss_aw_lesson_question_options'];
									
									$answersary = array();
									$answersary = explode("/",trim(strip_tags($val['ss_aw_answers'])));
									
									$answersary = array_map('trim',$answersary);
									
									$resultary['data'][$i]['details']['quizes'][$j]['answers'] = $answersary;
									//$resultary['data'][$i]['details']['quizes'][$j]['answer'] = $val['ss_aw_lesson_answers'];
									$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = base_url().$val['ss_aw_answers_audio'];
								}
								else
								{
									$resultary['data'][$i]['details']['quizes'] = array();
									$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = "";
								}
									
							}
								
						}
					}
				}
			}	
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data Found';
					$responseary['result'] = $resultary;		
			}

			return json_encode($responseary);
		}
	}

	public function assessment_exam_question_first_question($child_id, $assessment_id)
	{
		$getlast_lessonary = array();
		$getlast_lessonary = $this->ss_aw_child_last_lesson_model->fetch_details($child_id);


		$subcategoryary = array();
		if($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
			$level = "E";
		else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
			$level = "C";
		else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
			$level = "A";
		else
			$level = "M";

		if ($level == 'E' || $level == 'C') {
			if ($child_age < 13) {
				if ($assessment_serial_no > 10) {
					$fetch_level = 'C';
				}
				else{
					$fetch_level = 'E';
				}
			}
			else{
				$fetch_level = 'C';
			}
		}
		elseif ($level == 'M') {
			if ($assessment_serial_no <= 10) {
				$fetch_level = 'C';
			}
			elseif ($assessment_serial_no > 10 && $assessment_serial_no < 56) {
				$fetch_level = 'A';
			}
			else{
				$fetch_level = 'M';
			}
		}
		else{
			$fetch_level = 'A';
		}

		$subcategoryary['ss_aw_level'] = $fetch_level;
		$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				
		$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);
				
		$firstsubcategory_name = $searchresultary[0]['ss_aw_sub_category'];
		$count_subcategory = count($searchresultary);	// Total No of Sub-category
				
				
				
		$subcategoryary = array();
		$subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
		$searchresultary = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);
				
		$min_question_no = $searchresultary[0]['ss_aw_min_question']; // Min question asked form current LEVEL
		$sub_section_no = $searchresultary[0]['ss_aw_sub_section_no'];
		$total_question_no = $searchresultary[0]['ss_aw_total_question'] * $sub_section_no;
		$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']);	// Min question asked from sub-category
		$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']);	// Min question asked from sub-category
				
				/*
					Search record group by Level from assessment questions
				*/
		$subcategoryary = array();
		$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
		$searchresultlevelgroupary = array();
		$searchresultlevelgroupary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby_level($subcategoryary);
				
		if($fetch_level == 'A'){
			$min_question_no = $searchresultary[0]['ss_aw_total_question'];
		}
		else if($fetch_level == 'C'){
			$exist_levelary = array();
			foreach($searchresultlevelgroupary as $value)
			{
				$exist_levelary[] = $value['ss_aw_level'];
			}
			if(!in_array('A',$exist_levelary))
			{
				$min_question_no = $searchresultary[0]['ss_aw_total_question'];
			}
		}

		$subcategoryary = array();
		$subcategoryary['ss_aw_level'] = $fetch_level;
				
		//$subcategoryary['ss_aw_quiz_type'] = 2;
		$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
		$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				
		$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
		$total_question_first_subcat = count($searchresultary);
				
		$sequence_start_value = $total_question_first_subcat/$min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL
		$response = array();
		$exam_code = time()."_".$child_id;
		
		for($i=1;$i<=$min_question_no;$i++)
		{
			$subcategoryary = array();
			$subcategoryary['ss_aw_seq_no'] = ceil($sequence_start_value * $i);
			$subcategoryary['ss_aw_level'] = $fetch_level;
			//$subcategoryary['ss_aw_quiz_type'] = 2;
			$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
			$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				
			$currentresult = array();
			$checkresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
			if(!empty($checkresult))
			{
				$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
					//$currentresult = $this->check_question_exist_assisment($subcategoryary);
				$response[] = $currentresult;
			}
			else
			{
				do{
				$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;
					
				$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
					//$currentresult = $this->check_question_exist_assisment($subcategoryary);
				$response[] = $currentresult;
				}while(empty($currentresult));
			}

			$insert_record = array();
			$insert_record['ss_aw_assessment_exam_code'] = $exam_code;
			$insert_record['ss_aw_assessment_id'] = $assessment_id;
			$insert_record['ss_aw_calculated_seq_no'] = $sequence_start_value * $i;
			$insert_record['ss_aw_child_id'] = $child_id;
			$insert_record['ss_aw_asked_level'] = $currentresult[0]['ss_aw_level'];
			$insert_record['ss_aw_asked_category'] = $currentresult[0]['ss_aw_category'];
			$insert_record['ss_aw_asked_sub_category'] = $currentresult[0]['ss_aw_sub_category'];
			$insert_record['ss_aw_assessment_question_id'] = $currentresult[0]['ss_aw_id'];
			$this->ss_aw_assesment_questions_asked_model->insert_record($insert_record);

			$finalquestionary = array();
			$i = 0;
			foreach($response as $value)
			{
				//if($i == 0)
				{					
					$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
					$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
					$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];
					$finalquestionary[$i]['question_topic_id'] = $value[0]['ss_aw_question_topic_id'];
					
					if($value[0]['ss_aw_format'] == 'Single')
						$finalquestionary[$i]['format_id'] = 1;
					else
						$finalquestionary[$i]['format_id'] = 2;
					
					$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
					$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
					$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
					$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
					$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];
					
					if($value[0]['ss_aw_question_format'] == 'Choose the right answers')
						$finalquestionary[$i]['question_format_id'] = 2;
					if($value[0]['ss_aw_question_format'] == 'Choose the right answer')
						$finalquestionary[$i]['question_format_id'] = 2;
					else if($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
						$finalquestionary[$i]['question_format_id'] = 1;
					else if($value[0]['ss_aw_question_format'] == 'Change the sentence')
						$finalquestionary[$i]['question_format_id'] = 3;
					else if($value[0]['ss_aw_question_format'] == 'Change the word to its comparative degree')
						$finalquestionary[$i]['question_format_id'] = 4;
					else if($value[0]['ss_aw_question_format'] == 'Choose the right option')
						$finalquestionary[$i]['question_format_id'] = 5;
					else if($value[0]['ss_aw_question_format'] == 'Convert to the comparative degree')
						$finalquestionary[$i]['question_format_id'] = 6;
					else if($value[0]['ss_aw_question_format'] == 'Insert the adverb')
						$finalquestionary[$i]['question_format_id'] = 7;
					else if($value[0]['ss_aw_question_format'] == 'Join the sentences')
						$finalquestionary[$i]['question_format_id'] = 8;
					else if($value[0]['ss_aw_question_format'] == 'Place the article in the aprropraite place')
						$finalquestionary[$i]['question_format_id'] = 9;
					else if($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
						$finalquestionary[$i]['question_format_id'] = 10;
					
					
					$finalquestionary[$i]['prefaceaudio'] = base_url().$value[0]['ss_aw_question_preface_audio'];
					$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
					$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);
					
					$multiple_choice_ary = array();
					$multiple_choice_ary = explode("/",$value[0]['ss_aw_multiple_choice']);
					
					if(count($multiple_choice_ary) > 1)
					{
						$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
						$finalquestionary[$i]['options'] = $multiple_choice_ary;
					}
					else
					{
						$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];									
					}			
					
					$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];
					
					$answersary = array();
					$answersary = explode("/",trim($value[0]['ss_aw_answers']));
					if(count($answersary)> 1)
					{
						$answersary = array_map('trim', $answersary);
						$finalquestionary[$i]['answers'] = $answersary;
					}
					else
					{
						$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
					}
					$finalquestionary[$i]['answeraudio'] = base_url().$value[0]['ss_aw_answers_audio'];
					$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);
					
					$finalquestionary[$i]['hint'] = "";
					$finalquestionary[$i]['ruleaudio'] = base_url().$value[0]['ss_aw_rules_audio'];
					$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
					$i++;
				}
			}
		}

		$setting_result = array();
		$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
		$idletime = $setting_result[0]->ss_aw_time_skip;
		$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
						
		$responseary['status'] = 200;
		$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
		$responseary['correct_answer_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_answer_audio;
		$responseary['skip_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_skip_audio;
		$responseary['warning_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_warning_audio;
		$responseary['correct_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_audio;
		$responseary['incorrect_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_incorrect_audio;
		$responseary['skip_duration'] = $idletime;
		$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
		$responseary['data'] = $finalquestionary;
		$responseary['assessment_exam_code'] = $exam_code;
		$responseary['question_asked_count'] = 0;
		$responseary['total_questions_count'] = $total_question_no;
		$responseary['min_subsection_questions_count'] = $min_subsection_questions_count;
		$responseary['total_subsection_questions_count'] = $total_subsection_questions_count;
		$responseary['assessment_id'] = intval($assessment_id);
		$assesment_detail = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
		if (!empty($assesment_detail)) {
			$responseary['topic_id'] = $assesment_detail[0]->ss_aw_assesment_topic_id;
		}
		else
		{
			$responseary['topic_id'] = 0;
		}

		return json_encode($responseary);
	}

	public function assessment_exam_question_next_level_subcategory($child_id, $assessment_id, $assessment_exam_code){
		$getlast_askedquestion = array();
		$searchary = array();
		$searchary['ss_aw_assessment_id'] = $assessment_id;
		$searchary['ss_aw_assessment_exam_code'] = $assessment_exam_code;
		$getlast_askedquestion = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_bydesc($searchary);
				
		$askedquestion_bysubcategory = array();
		$searchary = array();
		$searchary['ss_aw_assessment_id'] = $assessment_id;
		$searchary['ss_aw_assessment_exam_code'] = $assessment_exam_code;
		$searchary['ss_aw_asked_level'] = $getlast_askedquestion[0]['ss_aw_asked_level'];
		$searchary['ss_aw_asked_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
		$searchary['ss_aw_asked_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];
		$askedquestion_bysubcategory = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_bydesc($searchary);
				
		$total_question_asked = count($askedquestion_bysubcategory);
				
		$rightansary = array();
		$searchary = array();
		$searchary['ss_aw_assessment_id'] = $assessment_id;
		$searchary['ss_aw_assessment_exam_code'] = $assessment_exam_code;
		$searchary['ss_aw_asked_level'] = $getlast_askedquestion[0]['ss_aw_asked_level'];
		$searchary['ss_aw_asked_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
		$searchary['ss_aw_asked_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];
		$searchary['ss_aw_answers_status'] = 1;
		$rightansary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_bydesc($searchary);
		$total_right_ans_count = count($rightansary);

		$subcategoryary = array();
		if($getlast_askedquestion[0]['ss_aw_asked_level'] == 'E')
			$level = "C";
		else if($getlast_askedquestion[0]['ss_aw_asked_level'] == 'C')
			$level = "A";
				
		$subcategoryary['ss_aw_level'] = $level;
		$subcategoryary['ss_aw_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
		//$subcategoryary['ss_aw_quiz_type'] = 2;
		$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				
		$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);
				
		$count_subcategory = count($searchresultary);	// Total No of Sub-category
				
				
				
		$subcategoryary = array();
		$subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
		$searchresultary = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);
				
		$min_question_no = $searchresultary[0]['ss_aw_min_question']; // Min question asked form current LEVEL
		$sub_section_no = $searchresultary[0]['ss_aw_sub_section_no'];
		$total_question_no = $searchresultary[0]['ss_aw_total_question'] * $sub_section_no;
		$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']);	// Min question asked from sub-category
		$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']);	// Total question asked from sub-category
					
		$subcategoryary = array();
		$subcategoryary['ss_aw_level'] = $level;
		$subcategoryary['ss_aw_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
		$subcategoryary['ss_aw_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];;
		$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
		$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
		$total_question_first_subcat = count($searchresultary);
				
		$min_question_no = $total_subsection_questions_count - $min_subsection_questions_count;		
		$sequence_start_value = $total_question_first_subcat/$min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL
			
		$response = array();
			
		$question_no_asked = $total_subsection_questions_count - $total_question_asked;

		for($i=1;$i<=$question_no_asked;$i++)
		{
			$subcategoryary = array();
			$subcategoryary['ss_aw_seq_no'] = ceil($sequence_start_value * $i);
			$subcategoryary['ss_aw_level'] = $level;
			//$subcategoryary['ss_aw_assessment_exam_code'] = $exam_code;
			$subcategoryary['ss_aw_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
			//$subcategoryary['ss_aw_quiz_type'] = 2;
			$subcategoryary['ss_aw_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];;
			$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
			$currentresult = array();
			$checkresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
				
			if(!empty($checkresult))
			{
				$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
					//$currentresult = $this->check_question_exist_assisment($subcategoryary);
				$response[] = $currentresult;
			}
			else
			{
				do{
					$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;
					$checkresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);	
					$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
					//$currentresult = $this->check_question_exist_assisment($subcategoryary);
					if(!empty($currentresult))
						$response[] = $currentresult;
				}while(empty($checkresult));
			}
				
			$insert_record = array();
			$insert_record['ss_aw_assessment_exam_code'] = $assessment_exam_code;
			$insert_record[' ss_aw_assessment_id'] = $assessment_id;
			$insert_record['ss_aw_calculated_seq_no'] = $sequence_start_value * $i;
			$insert_record['ss_aw_child_id'] = $child_id;
			$insert_record['ss_aw_asked_level'] = $currentresult[0]['ss_aw_level'];
			$insert_record['ss_aw_asked_category'] = $currentresult[0]['ss_aw_category'];
			$insert_record['ss_aw_asked_sub_category'] = $currentresult[0]['ss_aw_sub_category'];
			$insert_record['ss_aw_assessment_question_id'] = $currentresult[0]['ss_aw_id'];
			$this->ss_aw_assesment_questions_asked_model->insert_record($insert_record);
		}

		$finalquestionary = array();
		$i = 0;
		foreach($response as $value)
		{
			//if($i == 0)
			{					
				$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
				$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
				$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];
				$finalquestionary[$i]['question_topic_id'] = $value[0]['ss_aw_question_topic_id'];	
				if($value[0]['ss_aw_format'] == 'Single')
					$finalquestionary[$i]['format_id'] = 1;
				else
					$finalquestionary[$i]['format_id'] = 2;
					
				$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
				$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
				$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
				$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
				$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];
					
				if($value[0]['ss_aw_question_format'] == 'Choose the right answers')
					$finalquestionary[$i]['question_format_id'] = 2;
				if($value[0]['ss_aw_question_format'] == 'Choose the right answer')
					$finalquestionary[$i]['question_format_id'] = 2;
				else if($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
					$finalquestionary[$i]['question_format_id'] = 1;
				else if($value[0]['ss_aw_question_format'] == 'Change the sentence')
					$finalquestionary[$i]['question_format_id'] = 3;
				else if($value[0]['ss_aw_question_format'] == 'Change the word to its comparative degree')
					$finalquestionary[$i]['question_format_id'] = 4;
				else if($value[0]['ss_aw_question_format'] == 'Choose the right option')
					$finalquestionary[$i]['question_format_id'] = 5;
				else if($value[0]['ss_aw_question_format'] == 'Convert to the comparative degree')
					$finalquestionary[$i]['question_format_id'] = 6;
				else if($value[0]['ss_aw_question_format'] == 'Insert the adverb')
					$finalquestionary[$i]['question_format_id'] = 7;
				else if($value[0]['ss_aw_question_format'] == 'Join the sentences')
					$finalquestionary[$i]['question_format_id'] = 8;
				else if($value[0]['ss_aw_question_format'] == 'Place the article in the aprropraite place')
					$finalquestionary[$i]['question_format_id'] = 9;
				else if($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
					$finalquestionary[$i]['question_format_id'] = 10;
					
					
				$finalquestionary[$i]['prefaceaudio'] = base_url().$value[0]['ss_aw_question_preface_audio'];
				$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
				$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);
					
				$multiple_choice_ary = array();
				$multiple_choice_ary = explode("/",$value[0]['ss_aw_multiple_choice']);
					
				if(count($multiple_choice_ary) > 1)
				{
					$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
					$finalquestionary[$i]['options'] = $multiple_choice_ary;
				}
				else
				{
					$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];
				}			
					
				$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];
					
				$answersary = array();
				$answersary = explode("/",trim($value[0]['ss_aw_answers']));
				if(count($answersary)> 1)
				{
					$answersary = array_map('trim', $answersary);
					$finalquestionary[$i]['answers'] = $answersary;
				}
				else
				{
					$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
				}
				$finalquestionary[$i]['answeraudio'] = base_url().trim($value[0]['ss_aw_answers_audio']);
				$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);
					
				$finalquestionary[$i]['hint'] = "";
				$finalquestionary[$i]['ruleaudio'] = base_url().$value[0]['ss_aw_rules_audio'];
				$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
				$i++;
			}
		}

		$setting_result = array();
		$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
		$idletime = $setting_result[0]->ss_aw_time_skip;
		$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
						
		$responseary['status'] = 200;
		$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
		$responseary['correct_answer_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_answer_audio;
		$responseary['skip_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_skip_audio;
		$responseary['warning_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_warning_audio;
		$responseary['correct_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_correct_audio;
		$responseary['incorrect_audio'] = base_url()."uploads/".$setting_result[0]->ss_aw_incorrect_audio;
		$responseary['skip_duration'] = $idletime;
		$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
		$responseary['data'] = $finalquestionary;
		$responseary['assessment_exam_code'] = $assessment_exam_code;
		$responseary['question_asked_count'] = 0;
		$responseary['total_questions_count'] = $total_question_no;
		$responseary['min_subsection_questions_count'] = $min_subsection_questions_count;
		$responseary['total_subsection_questions_count'] = $total_subsection_questions_count;
		$responseary['assessment_id'] = intval($assessment_id);

		return json_encode($responseary);
	}

	public function assessment_exam_question_next_sub_category($child_id, $assessment_id, $assessment_exam_code)
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		{
			
			{
				$getlast_lessonary = array();
				$getlast_lessonary = $this->ss_aw_child_last_lesson_model->fetch_details($child_id);
			
			/*
				Already asked sub-category name
			*/
				$searchary = array();
				$searchary['ss_aw_assessment_id'] = $assessment_id;
				$searchary['ss_aw_assessment_exam_code'] = $assessment_exam_code;
				$searchary['ss_aw_child_id'] = $child_id;
				$asked_questions_array = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($searchary);	
				$asked_sub_catname = array();
				$asked_questionary = array();
				foreach($asked_questions_array as $value)
				{
					$asked_sub_catname[] = $value['ss_aw_asked_sub_category'];
					$asked_questionary[] = $value['ss_aw_assessment_question_id'];
				}
				$asked_sub_catname = array_unique($asked_sub_catname);
				
			/*
				Find out no of sub category against partcular topic/category for Assesment test
			*/			
				$subcategoryary = array();
				if($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
					$level = "E";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
					$level = "C";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
					$level = "A";
				
				$subcategoryary['ss_aw_level'] = $level;
				//$subcategoryary['ss_aw_category'] = $getlast_lessonary[0]['ss_aw_lesson_topic'];
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$firstsubcategory_name = "";
				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);
				
				$count_subcategory = count($searchresultary);	// Total No of Sub-category
				foreach($searchresultary as $value)
				{
					if($count_subcategory > 1)
					{
						if(!in_array($value['ss_aw_sub_category'],$asked_sub_catname))
						{
							$firstsubcategory_name = $value['ss_aw_sub_category'];
							break;
						}
					}
					else
					{
						$firstsubcategory_name = $value['ss_aw_sub_category'];
						break;
					}
				}
			
				$subcategoryary = array();
				$subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
				$searchresultary = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);
				
				$min_question_no = $searchresultary[0]['ss_aw_min_question']; // Min question asked form current LEVEL
				$sub_section_no = $searchresultary[0]['ss_aw_sub_section_no'];
				$total_question_no = $searchresultary[0]['ss_aw_total_question'] * $sub_section_no;
				$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']);	// Min question asked from sub-category
				$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']);	// Min question asked from sub-category
				
				
			$response = array();
			$exam_code = $assessment_exam_code;
			
			/*****************************************************************************************************************************/
			/*
					Search record group by Level from assessment questions
				*/
				$subcategoryary = array();
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$searchresultlevelgroupary = array();
				$searchresultlevelgroupary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby_level($subcategoryary);
				
				if($level == 'A')
				{
					$min_question_no = $searchresultary[0]['ss_aw_total_question'];
				}
				else if($level == 'C')
				{
					$exist_levelary = array();
					foreach($searchresultlevelgroupary as $value)
					{
						$exist_levelary[] = $value['ss_aw_level'];
					}
					if(!in_array('A',$exist_levelary))
					{
						$min_question_no = $searchresultary[0]['ss_aw_total_question'];
					}
				}
				
			/******************************************************************************************************************************/
			$min_subsection_questions_count = $min_question_no;
			$subcategoryary = array();
				$subcategoryary['ss_aw_level'] = $level;
				
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
				$total_question_first_subcat = count($searchresultary);
				
				$sequence_start_value = $total_question_first_subcat/$min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL
				
			for($i=1;$i<=$min_question_no;$i++)
			{
				$subcategoryary = array();
				
				$subcategoryary['ss_aw_seq_no'] = ceil($sequence_start_value * $i);
				
				$subcategoryary['ss_aw_level'] = $level;
				//$subcategoryary['ss_aw_assessment_exam_code'] = $exam_code;
				
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$currentresult = array();
				$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
				if(!empty($currentresult))
				{
					if(in_array($currentresult[0]['ss_aw_id'],$asked_questionary))
					{
						do{
							$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;
							$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
							$response[] = $currentresult;
						}while(empty($currentresult));
					}
					else
					{
						$response[] = $currentresult;
					}
					
				}
				else
				{
					do{	
							$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;
							$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
							
								if(!in_array($currentresult[0]['ss_aw_id'],$asked_questionary))
								{
									$response[] = $currentresult;
								}
							}while(in_array($currentresult[0]['ss_aw_id'],$asked_questionary) || empty($currentresult));
				}
				
					$insert_record = array();
					$insert_record['ss_aw_assessment_exam_code'] = $exam_code;
					$insert_record[' ss_aw_assessment_id'] = $assessment_id;
					
					$insert_record['ss_aw_calculated_seq_no'] = $sequence_start_value * $i;
					$insert_record['ss_aw_child_id'] = $child_id;
					$insert_record['ss_aw_asked_level'] = $currentresult[0]['ss_aw_level'];
					$insert_record['ss_aw_asked_category'] = $currentresult[0]['ss_aw_category'];
					$insert_record['ss_aw_asked_sub_category'] = $currentresult[0]['ss_aw_sub_category'];
					$insert_record['ss_aw_assessment_question_id'] = $currentresult[0]['ss_aw_id'];
					$this->ss_aw_assesment_questions_asked_model->insert_record($insert_record);
			}
			
			$response = array_values(array_filter($response));
			
			$finalquestionary = array();
			$i = 0;
			foreach($response as $value)
			{
				//if($i == 0)
				{					
					$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
					$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
					$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];
					$finalquestionary[$i]['question_topic_id'] = $value[0]['ss_aw_question_topic_id'];
					if($value[0]['ss_aw_format'] == 'Single')
						$finalquestionary[$i]['format_id'] = 1;
					else
						$finalquestionary[$i]['format_id'] = 2;
					
					$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
					$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
					$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
					$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
					$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];
					
					/*if($value[0]['ss_aw_question_format'] == 'Choose the right answers')
						$finalquestionary[$i]['question_format_id'] = 2;*/
					if($value[0]['ss_aw_question_format'] == 'Choose the right answer')
						$finalquestionary[$i]['question_format_id'] = 2;
					else if($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
						$finalquestionary[$i]['question_format_id'] = 1;
					else if($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
						$finalquestionary[$i]['question_format_id'] = 3;
					/*else if($value[0]['ss_aw_question_format'] == 'Change the word to its comparative degree')
						$finalquestionary[$i]['question_format_id'] = 4;
					else if($value[0]['ss_aw_question_format'] == 'Choose the right option')
						$finalquestionary[$i]['question_format_id'] = 5;
					else if($value[0]['ss_aw_question_format'] == 'Convert to the comparative degree')
						$finalquestionary[$i]['question_format_id'] = 6;
					else if($value[0]['ss_aw_question_format'] == 'Insert the adverb')
						$finalquestionary[$i]['question_format_id'] = 7;
					else if($value[0]['ss_aw_question_format'] == 'Join the sentences')
						$finalquestionary[$i]['question_format_id'] = 8;
					else if($value[0]['ss_aw_question_format'] == 'Place the article in the aprropraite place')
						$finalquestionary[$i]['question_format_id'] = 9;
					else if($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
						$finalquestionary[$i]['question_format_id'] = 10;*/
					
					
					$finalquestionary[$i]['prefaceaudio'] = base_url().$value[0]['ss_aw_question_preface_audio'];
					$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
					$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);
					
					$multiple_choice_ary = array();
					$multiple_choice_ary = explode("/",$value[0]['ss_aw_multiple_choice']);
					
					if(count($multiple_choice_ary) > 1)
					{
						$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
						$finalquestionary[$i]['options'] = $multiple_choice_ary;
					}
					else
					{
						$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];									
					}			
					
					$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];
					
					$answersary = array();
					$answersary = explode("/",trim($value[0]['ss_aw_answers']));
					if(count($answersary)> 1)
					{
						$answersary = array_map('trim', $answersary);
						$finalquestionary[$i]['answers'] = $answersary;
					}
					else
					{
						$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
					}
					$finalquestionary[$i]['answeraudio'] = base_url().trim($value[0]['ss_aw_answers_audio']);
					$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);
					
					$finalquestionary[$i]['hint'] = "";
					$finalquestionary[$i]['ruleaudio'] = base_url().$value[0]['ss_aw_rules_audio'];
					$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
					$i++;
				}
			}
					/* Get Idle time for a question */
						
						$setting_result = array();
						$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
						$idletime = $setting_result[0]->ss_aw_time_skip;
						$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
						
						$responseary['status'] = 200;
						$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
						$responseary['complete_assessment_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_complete_assessment_audio;
						$responseary['correct_answer_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_answer_audio;
						$responseary['skip_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_skip_audio;
						$responseary['warning_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_warning_audio;
						$responseary['correct_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_audio;
						$responseary['incorrect_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_incorrect_audio;
						$responseary['skip_duration'] = $idletime;
						$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
						$responseary['skip_type_1_2_duration'] = $idletime;
						$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
						$responseary['data'] = $finalquestionary;
						$responseary['assessment_exam_code'] = $exam_code;
						$responseary['question_asked_count'] = 0;
						$responseary['total_questions_count'] = $total_question_no;
						$responseary['min_subsection_questions_count'] = $min_subsection_questions_count;
						$responseary['total_subsection_questions_count'] = $total_subsection_questions_count;
						$responseary['assessment_id'] = intval($assessment_id);
						
			}
				
			return json_encode($responseary); 	
		}
	}

	public function generatescore(){
		$getallcoursecompletedstudent = $this->store_procedure_model->getallcoursecompletestudent();
		if (!empty($getallcoursecompletedstudent)) {
			foreach ($getallcoursecompletedstudent as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				$level = $value->ss_aw_course_id;

				if ($level == 1) {
					$level_type = "E";
				}
				elseif ($level == 2) {
					$level_type = "C";
				}
				else
				{
					$level_type = "A";
				}

				$check_report = $this->ss_aw_child_result_model->checkrecord($child_id, $level_type);
				if ($check_report > 0) {
					$this->ss_aw_child_result_model->removerecord($child_id, $level_type);
					$this->store_procedure_model->removeformattwolessonassessmentscore($child_id, $level_type);
					$this->store_procedure_model->removeformattwolessonassessmenttotalscore($child_id, $level_type);
					$this->store_procedure_model->removelessonassessmentconfidence($child_id, $level_type);
					$this->store_procedure_model->removebackclickdetails($child_id, $level_type);
					$this->store_procedure_model->removelessonassessmentscore($child_id, $level_type);
					$this->store_procedure_model->removelessonassessmenttotalscore($child_id, $level_type);
					$this->store_procedure_model->removemultipleformatskipdetail($child_id, $level_type);
					$this->store_procedure_model->removereadalongscore($child_id, $level_type);
					$this->store_procedure_model->removeassessmentanswertimingdetails($child_id, $level_type);
					$this->store_procedure_model->removeassessmentanswertimingdetails($child_id, $level_type);
					$this->store_procedure_model->removetotalreadalongscore($child_id, $level_type);
				}
				
				//run score generation functions
				$this->storescore($child_id, $level);
				$this->storeformattwoscore($child_id, $level);
				$this->store_readalong_score($child_id, $level);
				$this->store_confidence($child_id, $level);	
				$this->createpdfreport($child_id, $level);
			}
		}
	}

	public function generateindividualscore(){
		$child_id = $this->uri->segment(3);
		$level = $this->uri->segment(4);
		$parent_id = $this->uri->segment(5);

		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		else
		{
			$level_type = "A";
		}

		$check_report = $this->ss_aw_child_result_model->checkrecord($child_id, $level_type);
		if ($check_report > 0) {
			$this->ss_aw_child_result_model->removerecord($child_id, $level_type);
			$this->store_procedure_model->removeformattwolessonassessmentscore($child_id, $level_type);
			$this->store_procedure_model->removeformattwolessonassessmenttotalscore($child_id, $level_type);
			$this->store_procedure_model->removelessonassessmentconfidence($child_id, $level_type);
			$this->store_procedure_model->removebackclickdetails($child_id, $level_type);
			$this->store_procedure_model->removelessonassessmentscore($child_id, $level_type);
			$this->store_procedure_model->removelessonassessmenttotalscore($child_id, $level_type);
			$this->store_procedure_model->removemultipleformatskipdetail($child_id, $level_type);
			$this->store_procedure_model->removereadalongscore($child_id, $level_type);
			$this->store_procedure_model->removeassessmentanswertimingdetails($child_id, $level_type);
			$this->store_procedure_model->removetotalreadalongscore($child_id, $level_type);
			$this->store_procedure_model->removedaignosticreviewscore($child_id, $level_type);
		}
				
		//run score generation functions
		$this->storescore($child_id, $level);
		$this->storeformattwoscore($child_id, $level);
		$this->store_readalong_score($child_id, $level);
		$this->store_confidence($child_id, $level);	
		$this->createpdfreport($child_id, $level);

		$this->session->set_flashdata('success','Score card generated succesfully.');
		redirect('admin/childrendetails/'.$parent_id);
	}

	public function storeformattwoscore($child_id, $level){
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level_type = "";
		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		elseif ($level == 3) {
			$level_type = "A";
		}

		$scored_lesson_list = array();
		$scored_lesson_list = $this->store_procedure_model->get_scored_lesson($child_id, $level, 'Multiple');
		
		if (!empty($scored_lesson_list)) {
			foreach ($scored_lesson_list as $key => $value) {
				$lesson_id = $value->ss_aw_lession_id;
				$lesson_asked = $this->store_procedure_model->getalllessonaskedquestion($lesson_id, $child_id);
				$lesson_correct = $this->store_procedure_model->getalllessoncorrectquestionanswer($lesson_id, $child_id);

				$assessment_asked = $this->store_procedure_model->getallassessmentasked($lesson_id, $child_id);
				$assessment_correct = $this->store_procedure_model->getallassessmentcorrect($lesson_id, $child_id);

				$topic_name = $value->ss_aw_lesson_topic;
				$total_asked = $lesson_asked + $assessment_asked;
				$total_correct = $lesson_correct + $assessment_correct;
				$correct_percentage = get_percentage($total_asked, $total_correct);

				$data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_topic' => $topic_name,
					'ss_aw_asked' => $total_asked,
					'ss_aw_correct' => $total_correct,
					'ss_aw_correct_percentage' => $correct_percentage
				);

				$this->store_procedure_model->storelessonassessmentscore($data);
			}

			$get_format_two_record = $this->store_procedure_model->getformattwototallessonassessmentrecord($child_id, $level_type);
			if ($get_format_two_record) {
				$total_data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_asked' => $get_format_two_record[0]->total_asked,
					'ss_aw_correct' => $get_format_two_record[0]->total_correct,
					'ss_aw_correct_percentage' => get_percentage($get_format_two_record[0]->total_asked, $get_format_two_record[0]->total_correct)
				);

				$this->store_procedure_model->store_lesson_assessment_format_two_total_score($total_data);
			}
		}
	}

	public function storescore($child_id, $level){
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level_type = "";
		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		elseif ($level == 3) {
			$level_type = "A";
		}

		$scored_lesson_list = array();
		$scored_lesson_list = $this->store_procedure_model->get_scored_lesson($child_id, $level, 'Single');
		if (!empty($scored_lesson_list)) {
			$count = 0;
			foreach ($scored_lesson_list as $key => $value) {
				$count++;
				$asked = $value->total_question;
				$correct = $value->wright_answers;
				$percentage = $value->percentage;
				$lesson_topic_id = $value->ss_aw_lesson_topic_id;

				$data = array();
				$data['ss_aw_child_id'] = (int)$child_id;
				$data['ss_aw_course_level'] = $level_type;
				$data['ss_aw_lesson_quiz_asked'] = (int)$asked;
				$data['ss_aw_lesson_quiz_correct'] = (int)$correct;
				$data['ss_aw_lesson_quiz_correct_percentage'] = (double)$percentage;
				$data['ss_aw_lesson_topic'] = $value->ss_aw_lesson_topic;

				$in_level_question_ids = $this->store_procedure_model->get_inlevel_questions($child_id, $level_type, $value->ss_aw_lession_id);

				$total_question_ary = array();
				if (!empty($in_level_question_ids)) {
					$total_question_ary = explode(",", $in_level_question_ids[0]->question_id);
					$actual_score_detail = $this->ss_aw_assisment_diagnostic_model->gettotalweight($total_question_ary);
					if (!empty($actual_score_detail)) {
						$actual_score = $actual_score_detail[0]->total_weight;
						$actual_score = round($actual_score, 2);
					}
					else
					{
						$actual_score = 0;
					}
				}
				else
				{
					$actual_score = 0;
				}

				$in_level_currect_answer_question = $this->store_procedure_model->get_inlevel_correct_questions($child_id, $level_type, $value->ss_aw_lession_id);

				$correct_question_ary = array();
				if (!empty($in_level_currect_answer_question)) {
					$correct_question_ary = explode(",", $in_level_currect_answer_question[0]->question_id);
					$potential_score_details = $this->ss_aw_assisment_diagnostic_model->gettotalweight($correct_question_ary);
					if (!empty($potential_score_details)) {
						$potential_score = $potential_score_details[0]->total_weight;
						$potential_score = round($potential_score, 2);
					}
					else
					{
						$potential_score = 0;
					}
				}
				else
				{
					$potential_score = 0;
				}

				$in_leve_precentage = get_percentage($actual_score, $potential_score);

				$data['ss_aw_assessment_in_level_asked'] = (int)count($total_question_ary);
				$data['ss_aw_assessment_in_level_correct'] = (int)count($correct_question_ary);
				$data['ss_aw_assessment_in_level_actual_score'] = (double)$actual_score;
				$data['ss_aw_assessment_in_level_potential_score'] = (double)$potential_score;
				$data['ss_aw_assessment_in_level_score'] = (double)$in_leve_precentage;

				//next level score structure
				$nxt_level_question_ids = $this->store_procedure_model->get_nxtlevel_questions($child_id, $level_type, $value->ss_aw_lession_id);
				$total_question_ary = array();
				if (!empty($nxt_level_question_ids)) {
					$total_question_ary = explode(",", $nxt_level_question_ids[0]->question_id);
					$actual_score_detail = $this->ss_aw_assisment_diagnostic_model->gettotalweight($total_question_ary);
					if (!empty($actual_score_detail)) {
						$nxt_actual_score = $actual_score_detail[0]->total_weight;
						$nxt_actual_score = round($nxt_actual_score, 2);
					}
					else
					{
						$nxt_actual_score = 0;
					}
				}
				else
				{
					$nxt_actual_score = 0;
				}

				$nxt_level_correct_answer_question = $this->store_procedure_model->get_nxtlevel_correct_questions($child_id, $level_type, $value->ss_aw_lession_id);
				$correct_question_ary = array();
				if (!empty($nxt_level_correct_answer_question)) {
					$correct_question_ary = explode(",", $nxt_level_correct_answer_question[0]->question_id);
					$potential_score_details = $this->ss_aw_assisment_diagnostic_model->gettotalweight($correct_question_ary);
					if (!empty($potential_score_details)) {
						$nxt_potential_score = $potential_score_details[0]->total_weight;
						$nxt_potential_score = round($nxt_potential_score, 2);
					}
					else
					{

						$nxt_potential_score = 0;
					}
				}
				else
				{
					$nxt_potential_score = 0;
				}

				$nxt_level_precentage = get_percentage($potential_score, $actual_score);

				$data['ss_aw_assessment_next_level_asked'] = (int)count($total_question_ary);
				$data['ss_aw_assessment_next_level_correct'] = (int)count($correct_question_ary);
				$data['ss_aw_assessment_next_level_actual_score'] = (double)$nxt_actual_score;
				$data['ss_aw_assessment_next_level_potential_score'] = (double)$nxt_potential_score;
				$data['ss_aw_assessment_next_level_score'] = (double)$nxt_level_precentage;

				//review level code start
				$lesson_review_asked = $this->store_procedure_model->get_review_all_question($lesson_topic_id, $value->ss_aw_lession_id, $child_id);
				if (empty($lesson_review_asked)) {
					$lesson_review_asked = 0;
				}

				$lesson_review_correct = $this->store_procedure_model->get_review_correct_question($lesson_topic_id, $value->ss_aw_lession_id, $child_id);
				if (empty($lesson_review_correct)) {
					$lesson_review_correct = 0;
				}
				
				$assessment_review_asked = $this->store_procedure_model->get_assessment_review_all_question($lesson_topic_id, $value->ss_aw_lession_id, $child_id);
				$assessment_review_correct = $this->store_procedure_model->get_assessment_review_correct_question($lesson_topic_id, $value->ss_aw_lession_id, $child_id);

				$review_correct = $lesson_review_correct + $assessment_review_correct;
				$review_asked = $lesson_review_asked + $assessment_review_asked;

				$data['ss_aw_review_correct'] = (int)$review_correct;
				$data['ss_aw_review_asked'] = (int)$review_asked;
				$data['ss_aw_review_correct_percentage'] = (double)get_percentage($review_asked, $review_correct);
				$assessment_actual_score = $actual_score + $nxt_actual_score + $review_correct;
				$assessment_potential_score = $potential_score + $nxt_potential_score + $review_asked;

				$combine_percentage = (double)get_percentage($assessment_actual_score, $assessment_potential_score);

				$data['ss_aw_combine_correct'] = $combine_percentage;

				//$this->store_procedure_model->store_lesson_assessment_score($data);
				$this->ss_aw_lesson_assessment_score_model->save_data($data);

				if (count($scored_lesson_list) == $count) {
					$result = array();
					$result = $this->ss_aw_lesson_assessment_score_model->get_all_data($child_id, $level_type);
					$data = array();
					$data['ss_aw_child_id'] = $child_id;
					$data['ss_aw_course_level'] = $level_type;
					$data['ss_aw_lesson_quiz_correct'] = $result[0]->lesson_correct;
					$data['ss_aw_lesson_quiz_asked'] = $result[0]->lesson_asked;
					$data['ss_aw_lesson_quiz_correct_percentage'] = get_percentage($result[0]->lesson_asked, $result[0]->lesson_correct);
					$data['ss_aw_assessment_in_level_asked'] = $result[0]->assessment_in_level_asked;
					$data['ss_aw_assessment_in_level_correct'] = $result[0]->assessment_in_level_correct;
					$data['ss_aw_assessment_in_level_actual_score'] = $result[0]->assessment_in_level_actual_score;
					$data['ss_aw_assessment_in_level_potential_score'] = $result[0]->assessment_in_level_potential_score;
					$data['	ss_aw_assessment_in_level_score'] = get_percentage($result[0]->assessment_in_level_potential_score, $result[0]->assessment_in_level_actual_score);
					$data['ss_aw_assessment_next_level_correct'] = $result[0]->assessment_next_level_correct;
					$data['ss_aw_assessment_next_level_asked'] = $result[0]->assessment_next_level_asked;
					$data['ss_aw_assessment_next_level_asked'] = $result[0]->assessment_next_level_asked;
					$data['ss_aw_assessment_next_level_actual_score'] = $result[0]->assessment_next_level_actual_score;
					$data['ss_aw_assessment_next_level_potential_score'] = $result[0]->assessment_next_level_potential_score;
					$data['ss_aw_assessment_next_level_score'] = get_percentage($result[0]->assessment_next_level_potential_score, $result[0]->assessment_next_level_actual_score);
					$data['ss_aw_review_correct'] = $result[0]->review_correct;
					$data['ss_aw_review_asked'] = $result[0]->review_asked;
					$data['ss_aw_review_correct_percentage'] = get_percentage($result[0]->review_asked, $result[0]->review_correct);

					$assessment_actual_score = $result[0]->assessment_in_level_actual_score + $result[0]->assessment_next_level_actual_score + $result[0]->review_correct;
					$assessment_potential_score = $result[0]->assessment_in_level_potential_score + $result[0]->assessment_next_level_potential_score + $result[0]->review_asked;

					$combine_percentage = get_percentage($assessment_actual_score, $assessment_potential_score);

					$data['ss_aw_combine_correct'] = $combine_percentage;

					$data['ss_aw_created_at'] = date('Y-m-d H:i:s');

					$response = $this->ss_aw_lesson_assessment_score_model->save_total($data);
					if ($response) {
						$diagnostic_asked_question = $this->store_procedure_model->get_diagnostic_asked_question($child_id);
						$diagnostic_correct_question = $this->store_procedure_model->get_diagnostic_correct_question($child_id);
						$diagnostic_correct_percentage = get_percentage($diagnostic_asked_question, $diagnostic_correct_question);

						/*$review_correct = $data['ss_aw_assessment_in_level_potential_score'] + $data['ss_aw_review_correct'];
						$review_asked = $data['ss_aw_assessment_in_level_actual_score'] + $data['ss_aw_review_asked'];
						$final_review_percentage = get_percentage($review_asked, $review_correct);*/

						//the below code is implemented for non promoted students.
						$review_correct = $data['ss_aw_assessment_in_level_potential_score'] + $data['ss_aw_assessment_next_level_potential_score'] + $data['ss_aw_review_correct'];
						$review_asked = $data['ss_aw_assessment_in_level_actual_score'] + $data['ss_aw_assessment_next_level_actual_score'] + $data['ss_aw_review_asked'];
						$final_review_percentage = get_percentage($review_asked, $review_correct);
						//End of code

						$final_data = array(
							'ss_aw_child_id' => $child_id,
							'ss_aw_level' => $level_type,
							'ss_aw_diagnostic_asked' => $diagnostic_asked_question,
							'ss_aw_diagnostic_correct' => $diagnostic_correct_question,
							'ss_aw_diagnostic_correct_percentage' => $diagnostic_correct_percentage,
							'ss_aw_review_correct' => $review_correct,
							'ss_aw_review_asked' => $review_asked,
							'ss_aw_review_percentage' => $final_review_percentage
						);

						$this->ss_aw_lesson_assessment_score_model->save_final_total($final_data);
					}
				}
			}
		}

	}

	public function store_grand_total($child_id, $level_type){
		$result = array();
		$result = $this->ss_aw_lesson_assessment_score_model->get_all_data($child_id, $level_type);
		if (!empty($result)) {
			$data = array();
			$data['ss_aw_child_id'] = $child_id;
			$data['ss_aw_course_level'] = $level_type;
			$data['ss_aw_lesson_quiz_correct'] = $result[0]->lesson_correct;
			$data['ss_aw_lesson_quiz_asked'] = $result[0]->lesson_asked;
			$data['ss_aw_lesson_quiz_correct_percentage'] = get_percentage($result[0]->lesson_asked, $result[0]->lesson_correct);
			$data['ss_aw_assessment_in_level_asked'] = $result[0]->assessment_in_level_asked;
			$data['ss_aw_assessment_in_level_correct'] = $result[0]->assessment_in_level_correct;
			$data['ss_aw_assessment_in_level_actual_score'] = $result[0]->assessment_in_level_actual_score;
			$data['ss_aw_assessment_in_level_potential_score'] = $result[0]->assessment_in_level_potential_score;
			$data['	ss_aw_assessment_in_level_score'] = get_percentage($result[0]->assessment_in_level_potential_score, $result[0]->assessment_in_level_actual_score);
			$data['ss_aw_assessment_next_level_correct'] = $result[0]->assessment_next_level_correct;
			$data['ss_aw_assessment_next_level_asked'] = $result[0]->assessment_next_level_asked;
			$data['ss_aw_assessment_next_level_asked'] = $result[0]->assessment_next_level_asked;
			$data['ss_aw_assessment_next_level_actual_score'] = $result[0]->assessment_next_level_actual_score;
			$data['ss_aw_assessment_next_level_potential_score'] = $result[0]->assessment_next_level_potential_score;
			$data['ss_aw_assessment_next_level_score'] = get_percentage($result[0]->assessment_next_level_potential_score, $result[0]->assessment_next_level_actual_score);
			$data['ss_aw_review_correct'] = $result[0]->review_correct;
			$data['ss_aw_review_asked'] = $result[0]->review_asked;
			$data['ss_aw_review_correct_percentage'] = get_percentage($result[0]->review_asked, $result[0]->review_correct);

			$assessment_actual_score = $result[0]->assessment_in_level_actual_score + $result[0]->assessment_next_level_actual_score + $result[0]->review_correct;
			$assessment_potential_score = $result[0]->assessment_in_level_potential_score + $result[0]->assessment_next_level_potential_score + $result[0]->review_asked;

			$combine_percentage = get_percentage($assessment_potential_score, $assessment_actual_score);

			$data['ss_aw_combine_correct'] = $combine_percentage;

			$data['ss_aw_created_at'] = date('Y-m-d H:i:s');

			$this->ss_aw_lesson_assessment_score_model->save_total($data);
		}
	}

	public function store_readalong_score($child_id, $level_num){
		if ($level_num == 1) {
			$level = "E";
		}
		elseif ($level_num == 2) {
			$level = "C";
		}
		else
		{
			$level = "A";
		}
		$readalongsbylevel = $this->store_procedure_model->getcompletedreadalongs($level, $child_id);
		if (!empty($readalongsbylevel)) {
			foreach ($readalongsbylevel as $key => $value) {
				$asked = $this->store_procedure_model->getallaskedquestion($value->ss_aw_id, $child_id);
				$correct = $this->store_procedure_model->getallcorrectquestion($value->ss_aw_id, $child_id);
				if (!empty($asked)) {
					$total_asked = count($asked);
					$total_correct = count($correct);

					$data = array(
						'ss_aw_child_id' => $child_id,
						'ss_aw_level' => $level,
						'ss_aw_title' => $value->ss_aw_title,
						'ss_aw_asked' => $total_asked,
						'ss_aw_correct' => $total_correct,
						'ss_aw_correct_percentage' => get_percentage($total_asked, $total_correct)
					);

					$this->store_procedure_model->store_readalong_scoring_data($data);
				}
			}

			$total_readalong_data = $this->store_procedure_model->get_readalong_scoring($child_id, $level);
			if (!empty($total_readalong_data)) {
				$readalong_data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level,
					'ss_aw_asked' => $total_readalong_data[0]->total_asked != "" ? $total_readalong_data[0]->total_asked : 0,
					'ss_aw_correct' => $total_readalong_data[0]->total_correct != "" ? $total_readalong_data[0]->total_correct : 0,
					'ss_aw_correct_percentage' => get_percentage($total_readalong_data[0]->total_asked, $total_readalong_data[0]->total_correct)
				);

				$this->store_procedure_model->store_readalong_total_scoring_data($readalong_data);
			}
		}
	}

	public function getscoreboard(){
		$child_id = $this->uri->segment(3);
		$this->storescore($child_id);
		die();
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level = $childary[count($childary) - 1]['ss_aw_course_id'];
		$level_type = "";
		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		elseif ($level == 3) {
			$level_type = "A";
		}
		$lessonlist = $this->ss_aw_lessons_uploaded_model->get_lessonlist_bylevel($level);
		$scoreboard = array();
		$scored_lesson_list = array();
		$scored_lesson_list = $this->store_procedure_model->get_scored_lesson($child_id, $level);
		if (!empty($lessonlist)) {
			foreach ($lessonlist as $key => $value) {
				if ($value['ss_aw_lesson_format'] == 'Single') {

					$data = array();
					$data['ss_aw_child_id'] = $child_id;
					$data['ss_aw_course_level'] = $level_type;
					$data['ss_aw_lesson_topic'] = $value['ss_aw_lesson_topic'];

					$lesson_topic_id = $value['ss_aw_lesson_topic_id'];
					$scoreboard[$key]['topic'] = $value['ss_aw_lesson_topic'];
					$lesson_score_Detail = $this->ss_aw_lesson_score_model->check_data($child_id, $value['ss_aw_lession_id']);
					if (!empty($lesson_score_Detail)) {
						$asked = $lesson_score_Detail[0]->total_question;
						$correct = $lesson_score_Detail[0]->wright_answers;
						$percentage = get_percentage($asked, $correct);

						$data['ss_aw_lesson_quiz_asked'] = $asked;
						$data['ss_aw_lesson_quiz_correct'] = $correct;
						$data['ss_aw_lesson_quiz_correct_percentage'] = $percentage;

						/*$scoreboard[$key]['lesson_quiz'] = array(
							'asked' => $asked,
							'correct' => $correct,
							'percentage' => $percentage
						);*/
					}
					else
					{
						$data['ss_aw_lesson_quiz_asked'] = 0;
						$data['ss_aw_lesson_quiz_correct'] = 0;
						$data['ss_aw_lesson_quiz_correct_percentage'] = 0;
						/*$scoreboard[$key]['lesson_quiz'] = array(
							'asked' => 'NA',
							'correct' => 'NA',
							'percentage' => 'NA'
						);*/
					}

					/*$assesment_detail = $this->ss_aw_assesment_uploaded_model->fetch_by_params(array('ss_aw_lesson_id' => $value->ss_aw_lession_id));
					if (!empty($assesment_detail)) {
						$assessment_id = $assesment_detail[0]['ss_aw_assessment_id'];

					}*/

					$score_detail = $this->ss_aw_assessment_score_model->gettotalquestionanswercount($child_id, $value['ss_aw_lession_id']);
					if (!empty($score_detail)) {
						$exam_code = $score_detail[0]->exam_code;

						$all_asked_question_detail = $this->ss_aw_assesment_questions_asked_model->fetch_all_in_level_question($exam_code, $level_type);
						
						$correct_answer_id = array();
						$all_question_id = array();
						$wright_answers = 0;
						$total_questions = 0;
						if (!empty($all_asked_question_detail)) {
							foreach ($all_asked_question_detail as $asked_question) {
								if ($asked_question->ss_aw_answers_status == 1 || $asked_question->ss_aw_answers_status == 2) {
									$all_question_id[] = $asked_question->ss_aw_assessment_question_id;
									$total_questions++;
								}
								if ($asked_question->ss_aw_answers_status == 1) {
									$correct_answer_id[] = $asked_question->ss_aw_assessment_question_id;
									$wright_answers++;
								}
							}
						}

						if (!empty($correct_answer_id)) {
							$actual_score_detail = $this->ss_aw_assisment_diagnostic_model->gettotalweight($correct_answer_id);
							if (!empty($actual_score_detail)) {
								$actual_score = $actual_score_detail[0]->total_weight;
								$actual_score = round($actual_score, 2);
							}
							else
							{
								$actual_score = 0;
							}
						}
						else
						{
							$actual_score = 0;
						}

						if (!empty($all_question_id)) {
							$potential_Score = $this->ss_aw_assisment_diagnostic_model->gettotalweight($all_question_id);
							if (!empty($potential_Score)) {
								$potential_Score = $potential_Score[0]->total_weight;
								$potential_Score = round($potential_Score, 2);
							}
							else
							{
								$potential_Score = 0;
							}
						}
						else
						{
							$potential_Score = 0;
						}

						$in_leve_precentage = get_percentage($potential_Score, $actual_score);

						$data['ss_aw_assessment_in_level_asked'] = $total_questions;
						$data['ss_aw_assessment_in_level_correct'] = $wright_answers;
						$data['ss_aw_assessment_in_level_actual_score'] = $actual_score;
						$data['ss_aw_assessment_in_level_potential_score'] = $potential_Score;
						$data['ss_aw_assessment_in_level_score'] = $in_leve_precentage;

						/*$scoreboard[$key]['in_level'] = array(
							'asked' => $total_questions,
							'correct' => $wright_answers,
							'actual_score' => $actual_score,
							'potential_score' => $potential_Score,
							'score' => $in_leve_precentage
						);*/

						//next level data structure

						$all_next_asked_question_detail = $this->ss_aw_assesment_questions_asked_model->fetch_all_nxt_level_question($exam_code, $level_type);
						
						$nxt_correct_answer_id = array();
						$nxt_all_question_id = array();
						$nxt_wright_answers = 0;
						$nxt_total_questions = 0;
						if (!empty($all_next_asked_question_detail)) {
							foreach ($all_next_asked_question_detail as $nxt_asked_question) {
								if ($nxt_asked_question->ss_aw_answers_status == 1 || $nxt_asked_question->ss_aw_answers_status == 2) {
									$nxt_all_question_id[] = $nxt_asked_question->ss_aw_assessment_question_id;
									$nxt_total_questions++;
								}
								if ($nxt_asked_question->ss_aw_answers_status == 1) {
									$nxt_correct_answer_id[] = $nxt_asked_question->ss_aw_assessment_question_id;
									$nxt_wright_answers++;
								}
								
								
							}
						}

						if (!empty($nxt_correct_answer_id)) {
							$nxt_actual_score_detail = $this->ss_aw_assisment_diagnostic_model->gettotalweight($nxt_correct_answer_id);
							if (!empty($nxt_actual_score_detail)) {
								$nxt_actual_score = $nxt_actual_score_detail[0]->total_weight;
								$nxt_actual_score = round($nxt_actual_score, 2);
							}
							else
							{
								$nxt_actual_score = 0;
							}	
						}
						else
						{
							$nxt_actual_score = 0;
						}
						
						if (!empty($nxt_all_question_id)) {
							$nxt_potential_score_detail = $this->ss_aw_assisment_diagnostic_model->gettotalweight($nxt_all_question_id);
							if (!empty($nxt_potential_score_detail)) {
								$nxt_potential_Score = $nxt_potential_score_detail[0]->total_weight;
								$nxt_potential_Score = round($nxt_potential_Score, 2);
							}
							else
							{
								$nxt_potential_Score = 0;
							}
						}
						else
						{
							$nxt_potential_Score = 0;
						}

						$nxt_leve_precentage = get_percentage($nxt_potential_Score, $nxt_actual_score);

						$data['ss_aw_assessment_next_level_correct'] = $nxt_wright_answers;
						$data['ss_aw_assessment_next_level_asked'] = $nxt_total_questions;
						$data['ss_aw_assessment_next_level_actual_score'] = $nxt_actual_score;
						$data['ss_aw_assessment_next_level_potential_score'] = $nxt_potential_Score;
						$data['ss_aw_assessment_next_level_score'] = $nxt_leve_precentage;

						/*$scoreboard[$key]['next_level'] = array(
							'asked' => $nxt_total_questions,
							'correct' => $nxt_wright_answers,
							'actual_score' => $nxt_actual_score,
							'potential_score' => $nxt_potential_Score,
							'score' => $nxt_leve_precentage
						);*/

						//review level code start
						$get_all_lesson_review_question = $this->ss_aw_lesson_quiz_ans_model->getrecordbytopic($lesson_topic_id, $value['ss_aw_lession_id'], $child_id);
						$lesson_review_correct = 0;
						$lesson_review_asked = count($get_all_lesson_review_question);
						if (!empty($get_all_lesson_review_question)) {
							foreach ($get_all_lesson_review_question as $review_question) {
								if ($review_question->ss_aw_answer_status == 1) {
									$lesson_review_correct++;
								}
							}
						}

						$get_all_assessment_review_question = $this->ss_aw_assesment_multiple_question_answer_model->getrecordbytopic($lesson_topic_id, $value['ss_aw_lession_id'], $child_id);

						$assessment_review_correct = 0;
						$assessment_review_asked = count($get_all_assessment_review_question);
						if (!empty($get_all_assessment_review_question)) {
							foreach ($get_all_assessment_review_question as $assessment_review_question) {
								if ($assessment_review_question->ss_aw_answers_status == 1) {
									$assessment_review_correct++;
								}
							}
						}

						$review_correct = $lesson_review_correct + $assessment_review_correct;
						$review_asked = $lesson_review_asked + $assessment_review_asked;

						$data['ss_aw_review_correct'] = $review_correct;
						$data['ss_aw_review_asked'] = $review_asked;
						$data['ss_aw_review_correct_percentage'] = get_percentage($review_asked, $review_correct);
						$assessment_actual_score = $actual_score + $nxt_actual_score + $review_correct;
						$assessment_potential_score = $potential_Score + $nxt_potential_Score + $review_asked;

						$combine_percentage = get_percentage($assessment_potential_score, $assessment_actual_score);

						$data['ss_aw_combine_correct'] = $combine_percentage;

						$this->ss_aw_lesson_assessment_score_model->save_data($data);

						return 1;
						/*$scoreboard[$key]['review'] = array(
							'correct' => $review_correct,
							'asked' => $review_asked,
							'percentage' => get_percentage($review_asked, $review_correct)
						);*/

					}
					else
					{
						/*$scoreboard[$key]['in_level'] = array(
							'asked' => 'NA',
							'correct' => 'NA',
							'actual_score' => 'NA',
							'potential_score' => 'NA',
							'score' => 'NA'
						);

						$scoreboard[$key]['next_level'] = array(
							'asked' => 'NA',
							'correct' => 'NA',
							'actual_score' => 'NA',
							'potential_score' => 'NA',
							'score' => 'NA'
						);

						$scoreboard[$key]['review'] = array(
							'correct' => 'NA',
							'asked' => 'NA',
							'percentage' => 'NA'
						);*/
						return 0;
					}
				}
			}
		}

		echo "<pre>";
		print_r($scoreboard);
		die();
	}


	public function resetchildrecord(){
		$child_id = $this->uri->segment(3);
		if (!empty($child_id)) {
			
			//remove assessment multiple format record
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_assesment_multiple_question_answer');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_assesment_multiple_question_asked');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_assesment_questions_asked');

			$this->db->where('child_id', $child_id);
			$this->db->delete('ss_aw_assesment_reminder_notification');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_assessment_exam_completed');

			$this->db->where('ss_aw_log_child_id', $child_id);
			$this->db->delete('ss_aw_assessment_exam_log');

			$this->db->where('child_id', $child_id);
			$this->db->delete('ss_aw_assessment_score');

			//remove lesson record
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_child_last_lesson');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_current_lesson');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_lesson_assessment_score');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_lesson_assessment_total_score');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_lesson_quiz_ans');

			$this->db->where('child_id', $child_id);
			$this->db->delete('ss_aw_lesson_score');

			//remove readalong record
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_readalong_quiz_ans');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_schedule_readalong');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->delete('ss_aw_last_readalong');

			echo "Record removed successfully.";
		}
	}

	public function demousergenerate(){
		$generate_no = $this->uri->segment(3);
		for ($i=0; $i < $generate_no; $i++) { 
			$responseary = array();
			$parent_data = array();
			$first_name = generateRandomString(6);
			$last_name = generateRandomString(3);
			$parent_data['ss_aw_parent_full_name'] = $first_name." ".$last_name;
			$parent_data['ss_aw_parent_country'] = 'India';
			$parent_data['ss_aw_parent_country_code'] = 91;
			$parent_data['ss_aw_parent_primary_mobile'] = generateRandomMobileNumber(10);
			$parent_data['ss_aw_parent_email'] = $first_name.$last_name."@yopmail.com";
			$parent_data['ss_aw_parent_password'] = @$this->bcrypt->hash_password('12345678');
			$parent_data['ss_aw_parent_auth_key'] = generateRandomString(20);
			$userid = $this->ss_aw_parents_model->data_insert($parent_data);
			if ($userid) {
				$responseary['parent_status'] = "Added successfully.";
				$child_data = array();
				$code_check = $this->ss_aw_childs_model->child_code_check();      
				if(isset($code_check))
				{
					$random_code = $code_check->ss_aw_child_code + 1;
				}
				else
				{
					$random_code =  10000001;
				}
				$age = rand(10, 16);
				$current_date = date('Y-m-d');
				$child_dob = date('Y-m-d', strtotime($current_date." -".$age." years"));
				$hash_pass = $this->bcrypt->hash_password('12345678');
				$child_data['ss_aw_child_code']= $random_code;
				$child_data['ss_aw_parent_id']= $userid;
				$child_data['ss_aw_child_nick_name']= generateRandomString(5);
				$child_data['ss_aw_child_dob']= $child_dob;
				$child_data['ss_aw_child_age']= $age;
				$child_data['ss_aw_child_email']= $child_data['ss_aw_child_nick_name']."@yopmail.com";
				$child_data['ss_aw_child_mobile']= generateRandomMobileNumber(10);
				$child_data['ss_aw_child_country_code']= 91;
				$child_data['ss_aw_child_password']= $hash_pass;
				$result = $this->ss_aw_childs_model->add_child($child_data);
				if ($result) {
					$responseary['child_status'] = "Added successfully.";
				}
			}

			die(json_encode($responseary));	
		}
	}

	public function removelessonrecordbychildid(){
		$child_id = $this->uri->segment(3);
		$lesson_id = $this->uri->segment(4);
		if (!empty($child_id) && !empty($lesson_id)) {
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_lesson_id', $lesson_id);
			$this->db->delete('ss_aw_child_last_lesson');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_lesson_id', $lesson_id);
			$this->db->delete('ss_aw_current_lesson');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_lesson_id', $lesson_id);
			$this->db->delete('ss_aw_lesson_quiz_ans');

			$this->db->where('child_id', $child_id);
			$this->db->where('lesson_id', $lesson_id);
			$this->db->delete('ss_aw_lesson_score');

			echo "Lesson record removed succesfully.";
		}
	}

	public function removeassessmentrecordbychildid(){
		$child_id = $this->uri->segment(3);
		$assessment_id = $this->uri->segment(4);
		if (!empty($child_id) && !empty($assessment_id)) {
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_assessment_id', $assessment_id);
			$this->db->delete('ss_aw_assesment_multiple_question_answer');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_assessment_id', $assessment_id);
			$this->db->delete('ss_aw_assesment_multiple_question_asked');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_assessment_id', $assessment_id);
			$this->db->limit(1);
			$response = $this->db->get('ss_aw_assesment_questions_asked')->result();
			if (!empty($response)) {
				$exam_code = $response[0]->ss_aw_assessment_exam_code;
				$this->db->where('ss_aw_log_exam_code', $exam_code);
				$this->db->delete('ss_aw_assessment_exam_log');	
			}
			
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_assessment_id', $assessment_id);
			$this->db->delete('ss_aw_assesment_questions_asked');

			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_assessment_id', $assessment_id);
			$this->db->delete('ss_aw_assessment_exam_completed');

			$this->db->where('child_id', $child_id);
			$this->db->where('assessment_id', $assessment_id);
			$this->db->delete('ss_aw_assessment_score');

			echo "Assessment record removed succesfully.";
		}
	}

	public function lesson_assessment_completion_view(){
		$this->load->model('ss_aw_sections_topics_model');
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'E';
		$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
		$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();
		$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		$topicAry = array();
		if (!empty($topic_listary)) {
			foreach ($topic_listary as $key => $value) {
				$topicAry[] = $value->ss_aw_section_id;
			}
		}
		$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);
		$lesson_listary = array_merge($topical_lessons, $general_language_lessons);
		$data['lesson_list'] = $lesson_listary;
		$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);
		$assessment_listary = array_merge($topical_assessments, $general_language_assessments);
		$data['assessment_list'] = $assessment_listary;
		$this->load->view('admin/lesson-assessment-completion-page', $data);
	}

	public function getlessonassessmentlistbylevel(){
		$level = $this->input->get('level');
		$this->load->model('ss_aw_sections_topics_model');
		if ($level == 5) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'A,M';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$topicAry = array();
			if (!empty($topic_listary)) {
				foreach ($topic_listary as $key => $value) {
					$topicAry[] = $value->ss_aw_section_id;
				}
			}
			$data['lesson_list'] = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);
			$data['assessment_list'] = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);
		}
		else{
			$search_data = array();
			if ($level == 1) {
				$search_data['ss_aw_expertise_level'] = 'E';
				$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
				$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();
			}
			elseif ($level == 3) {
				$search_data['ss_aw_expertise_level'] = 'C';
				$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
				$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_champions_general_language_assessments();
			}
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$topicAry = array();
			if (!empty($topic_listary)) {
				foreach ($topic_listary as $key => $value) {
					$topicAry[] = $value->ss_aw_section_id;
				}
			}
			$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);
			$lesson_listary = array_merge($topical_lessons, $general_language_lessons);
			$data['lesson_list'] = $lesson_listary;
			$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);
			$assessment_listary = array_merge($topical_assessments, $general_language_assessments);
			$data['assessment_list'] = $assessment_listary;
		}
		
		echo json_encode($data);
		die();
	}

	public function lesson_completion(){

		if ($this->input->post()) {
			$postdata = $this->input->post();
			if(filter_var($postdata['child_id'],FILTER_VALIDATE_EMAIL)) {
				$parent_detail = $this->ss_aw_parents_model->login_process($postdata['child_id']);
				$check_self_registration = $this->ss_aw_childs_model->check_self_registration($parent_detail[0]->ss_aw_parent_id);
                if (!empty($check_self_registration)) {
                    $child_id = $check_self_registration->ss_aw_child_id;
                }
                else{
                	$this->session->set_flashdata('success','Invalid child ID');
					redirect('testingapi/lesson_assessment_completion_view');
                }
          	}
          	else{
          		$child_detail = $this->ss_aw_childs_model->check_child_existance($postdata['child_id']);
          		if (!empty($child_detail)) {
          			$child_id = $child_detail[0]->ss_aw_child_id;	
          		}
          		else{
          			$this->session->set_flashdata('success','Invalid child ID');
					redirect('testingapi/lesson_assessment_completion_view');
          		}	
          	}
			
			$lesson_id = $postdata['lesson'];
			if ($postdata['action'] == 1) {
				$lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
				$format = $lesson_detail[0]->ss_aw_lesson_format;
				$lesson_quiz_detail = $this->get_lesson_details_list($lesson_id, $child_id);

				if (!empty($lesson_quiz_detail)) {
					$lesson_quiz = json_decode($lesson_quiz_detail);
					if (!empty($lesson_quiz)) {
						if (!empty($lesson_quiz->result)) {
							if (!empty($lesson_quiz->result->data)) {
								foreach ($lesson_quiz->result->data as $key => $value) {
									if (!empty($value->details)) {
										$record_detail = $value->details;
										if (!empty($record_detail->quizes)) {
											
											//store curent lesson page index
											$lessonary = array();
											$lessonary['ss_aw_lesson_id'] = $lesson_id;
											$lessonary['ss_aw_child_id'] = $child_id;
											$lessonary['ss_aw_lesson_index'] = $value->index;
											$lessonary['ss_aw_updated_date'] = date('Y-m-d H:i:s');
											$lessonary['ss_aw_back_click_count'] = rand(0, 10);
											$response = $this->ss_aw_current_lesson_model->update_record($lessonary);
											if($response == 0)
											{
												$this->ss_aw_current_lesson_model->insert_data($lessonary);
											}
											//end

											$quizes = $record_detail->quizes;
											foreach ($quizes as $quiz) {
												if (!empty($quiz->question)) {
													$question = $quiz->question;
													$answers = "";
													if (!empty($quiz->answers)) {
														$answers = implode(",", $quiz->answers);
													}
													$options = "";
													if (!empty($quiz->options) && !empty($quiz->options[0])) {
														$options = implode(",", $quiz->options);
													}

													$postdata = array();
													$postdata['ss_aw_child_id'] = $child_id;
													$postdata['ss_aw_lesson_id'] = $lesson_id;
													$postdata['ss_aw_question_id'] = $value->index;
													$postdata['ss_aw_question'] = $question;
													$postdata['ss_aw_options'] = $options;
													$postdata['ss_aw_post_answer'] = $answers;
													$postdata['ss_aw_question_format'] = $quiz->qtype;
													$postdata['ss_aw_answer_status'] = rand(1, 2); // 1 = Right,2 = Wrong
													if ($format == 'Multiple') {
														$postdata['ss_aw_topic_id'] = $quiz->topic_id;
													}
													else
													{
														$postdata['ss_aw_topic_id'] = $lesson_quiz->result->topic_id;
													}
													
													$postdata['ss_aw_seconds_to_start_answer_question'] = 0;
													$postdata['ss_aw_seconds_to_answer_question'] = 0;
													
													/*
													Check particular Lesson Quiz already post by child or not
													*/
													$searchary = array();
													$searchary['ss_aw_child_id'] = $child_id;
													$searchary['ss_aw_lesson_id'] = $lesson_id;
													$searchary['ss_aw_question'] = $question;
													$searchdetailsary = array();
													$searchdetailsary = $this->ss_aw_lesson_quiz_ans_model->search_data_by_param($searchary);
													if(empty($searchdetailsary))
													{
														$this->ss_aw_lesson_quiz_ans_model->data_insert($postdata);
													}
													else
													{
														$record_id = $searchdetailsary[0]['ss_aw_id'];
														$postdata['ss_aw_id'] = $record_id;
														$this->ss_aw_lesson_quiz_ans_model->update_record($postdata);
													}
												}
											}
										}
									}
								}

								$childary = $this->ss_aw_child_course_model->get_details($child_id);
								$level = $childary[count($childary) - 1]['ss_aw_course_id'];

								$data = array();
								$data['child_id'] = $child_id;
								$data['lesson_id'] = $lesson_id;
								$data['level_id'] = $level;
								$data['ss_aw_lesson_status'] = 2;// 1 = Completed ,2 = Running
								$data['ss_aw_last_lesson_modified_date'] = date('Y-m-d H:i:s');
								$data['ss_aw_back_click_count'] = rand(0, 10);

								$response = $this->ss_aw_child_last_lesson_model->update_details($data);

								//get all score content to store
								$totalquestion = $this->ss_aw_lesson_quiz_ans_model->gettotalquestionbylessonchild($lesson_id, $child_id);

								$totalwrightanswer = $this->ss_aw_lesson_quiz_ans_model->gettotalwrightanswerbylessonchild($lesson_id, $child_id);

								$store_score = array(
									'child_id' => $child_id,
									'lesson_id' => $lesson_id,
									'level' => $level,
									'total_question' => $totalquestion,
									'wright_answers' => $totalwrightanswer
								);

								$check_storage = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_id);
								if (!empty($check_storage)) {
									$this->ss_aw_lesson_score_model->update_data($store_score);
								}
								else
								{
									$this->ss_aw_lesson_score_model->store_data($store_score);
								}
								

								$this->session->set_flashdata('success','Lesson completed successfully.');
							}
						}
					}
				}
			}
			elseif ($postdata['action'] == 3) {
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->order_by('ss_aw_las_lesson_id','desc');
				$this->db->limit(1);
				$result = $this->db->get('ss_aw_child_last_lesson')->result();
				if (!empty($result)) {
					$record_id = $result[0]->ss_aw_las_lesson_id;
					$start_time = $result[0]->ss_aw_last_lesson_create_date;
					$end_time = $result[0]->ss_aw_last_lesson_modified_date;
					$updated_start_time = "";
					if (!empty($start_time)) {
						$updated_start_time = date('Y-m-d H:i:s', strtotime($start_time." -7 day"));
					}
					$updated_end_time = "";
					if (!empty($end_time)) {
						$updated_end_time = date('Y-m-d H:i:s', strtotime($end_time." -7 day"));
					}

					$this->db->where('ss_aw_las_lesson_id', $record_id);
					if (!empty($updated_start_time)) {
						$this->db->set('ss_aw_last_lesson_create_date', $updated_start_time);
					}
					if (!empty($updated_end_time)) {
						$this->db->set('ss_aw_last_lesson_modified_date', $updated_end_time);
					}
					$this->db->update('ss_aw_child_last_lesson');

					$this->session->set_flashdata('success','Given access successfully.');
				}
			}
			else{
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_lesson_id', $lesson_id);
				$this->db->delete('ss_aw_child_last_lesson');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_lesson_id', $lesson_id);
				$this->db->delete('ss_aw_current_lesson');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_lesson_id', $lesson_id);
				$this->db->delete('ss_aw_lesson_quiz_ans');

				$this->db->where('child_id', $child_id);
				$this->db->where('lesson_id', $lesson_id);
				$this->db->delete('ss_aw_lesson_score');

				$this->session->set_flashdata('success','Lesson record removed.');
			}
		}

		redirect('testingapi/lesson_assessment_completion_view');
	}

	public function assessment_completion(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if(filter_var($postdata['child_id'],FILTER_VALIDATE_EMAIL)) {
				$parent_detail = $this->ss_aw_parents_model->login_process($postdata['child_id']);
				$check_self_registration = $this->ss_aw_childs_model->check_self_registration($parent_detail[0]->ss_aw_parent_id);
                if (!empty($check_self_registration)) {
                    $child_id = $check_self_registration->ss_aw_child_id;
                }
                else{
                	$this->session->set_flashdata('success','Invalid child ID');
					redirect('testingapi/lesson_assessment_completion_view');
                }
          	}
          	else{
          		$child_detail = $this->ss_aw_childs_model->check_child_existance($postdata['child_id']);
          		if (!empty($child_detail)) {
          			$child_id = $child_detail[0]->ss_aw_child_id;	
          		}
          		else{
          			$this->session->set_flashdata('success','Invalid child ID');
					redirect('testingapi/lesson_assessment_completion_view');
          		}	
          	}
          	
			$assessment_id = $postdata['assessment'];
			if ($postdata['action'] == 1) {
				redirect('testingapi/completeassessment/'.$child_id.'/'.$assessment_id);
			}
			elseif ($postdata['action'] == 3) {
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->order_by('ss_aw_las_lesson_id','desc');
				$this->db->limit(1);
				$result = $this->db->get('ss_aw_child_last_lesson')->result();
				if (!empty($result)) {
					$record_id = $result[0]->ss_aw_las_lesson_id;
					$start_time = $result[0]->ss_aw_last_lesson_create_date;
					$end_time = $result[0]->ss_aw_last_lesson_modified_date;
					$updated_start_time = "";
					if (!empty($start_time)) {
						$updated_start_time = date('Y-m-d H:i:s', strtotime($start_time." -1 day"));
					}
					$updated_end_time = "";
					if (!empty($end_time)) {
						$updated_end_time = date('Y-m-d H:i:s', strtotime($end_time." -1 day"));
					}

					$this->db->where('ss_aw_las_lesson_id', $record_id);
					if (!empty($updated_start_time)) {
						$this->db->set('ss_aw_last_lesson_create_date', $updated_start_time);
					}
					if (!empty($updated_end_time)) {
						$this->db->set('ss_aw_last_lesson_modified_date', $updated_end_time);
					}
					$this->db->update('ss_aw_child_last_lesson');

					$this->session->set_flashdata('success','Given access successfully.');
				}
			}
			else{
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_assessment_id', $assessment_id);
				$this->db->delete('ss_aw_assesment_multiple_question_answer');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_assessment_id', $assessment_id);
				$this->db->delete('ss_aw_assesment_multiple_question_asked');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_assessment_id', $assessment_id);
				$this->db->limit(1);
				$response = $this->db->get('ss_aw_assesment_questions_asked')->result();
				if (!empty($response)) {
					$exam_code = $response[0]->ss_aw_assessment_exam_code;
					$this->db->where('ss_aw_log_exam_code', $exam_code);
					$this->db->delete('ss_aw_assessment_exam_log');	
				}
				
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_assessment_id', $assessment_id);
				$this->db->delete('ss_aw_assesment_questions_asked');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->where('ss_aw_assessment_id', $assessment_id);
				$this->db->delete('ss_aw_assessment_exam_completed');

				$this->db->where('child_id', $child_id);
				$this->db->where('assessment_id', $assessment_id);
				$this->db->delete('ss_aw_assessment_score');
				$this->session->set_flashdata('success','Assessment record removed succesfully.');
			}
		}

		redirect('testingapi/lesson_assessment_completion_view');
	}

	public function store_confidence($child_id, $level){
		/*$child_id = $this->uri->segment(3);
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level = $childary[count($childary) - 1]['ss_aw_course_id'];*/
		$level_type = "";
		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		elseif ($level == 3) {
			$level_type = "A";
		}

		$scored_lesson_list = array();
		$scored_lesson_list = $this->store_procedure_model->getallcompletelessonresult($child_id, $level, 'Single');

		$lesson_confidence_dataAry = array();
		if (!empty($scored_lesson_list)) {
			$total_lesson_skip = 0;
			$total_lesson_back_click = 0;
			$total_lesson_skip_back_click = 0;
			$total_assessment_skip = 0;
			$total_review_skip = 0;
			$total_combine_score = 0;
			$total_assessment_multiple_choice_answer_time = 0;
			$total_assessment_short_answer_time = 0;
			$total_assessment_rewrite_answer_time = 0;
			$total_assessment_answer_time = 0;
			foreach ($scored_lesson_list as $key => $value) {
				$lesson_quiz_skip = $this->store_procedure_model->getlessonskipno($child_id, $level_type, $value->ss_aw_lession_id);
				$lesson_back_click_count = $value->ss_aw_back_click_count;
				$lesson_total_confidence = ($lesson_quiz_skip + $lesson_back_click_count) / 3;

				//get in level assessments data
				$assessment_skip_no = $this->store_procedure_model->getassessmentskipno($child_id, $level_type, $value->ss_aw_lesson_topic_id);

				$review_assessment_skip_no = $this->store_procedure_model->getreviewassessmentskipno($child_id, $level_type, $value->ss_aw_lesson_topic_id);
				$combine_total = $lesson_total_confidence + $assessment_skip_no + $review_assessment_skip_no;
				$data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_lesson_topic' => $value->ss_aw_lesson_topic,
					'ss_aw_lesson_skip' => $lesson_quiz_skip,
					'ss_aw_lesson_back_click' => $lesson_back_click_count,
					'ss_aw_lesson_total' => $lesson_total_confidence,
					'ss_aw_assessment_skip' => $assessment_skip_no,
					'ss_aw_review_skip' => $review_assessment_skip_no,
					'ss_aw_combine_score' => $combine_total
				);

				$lesson_confidence_dataAry[] = $data;

				$this->store_procedure_model->store_lesson_assessment_confidence($data);

				//store data for total result

				$total_lesson_skip = $total_lesson_skip + $lesson_quiz_skip;
				$total_lesson_back_click = $total_lesson_back_click + $lesson_back_click_count;
				$total_lesson_skip_back_click = $total_lesson_skip_back_click + $lesson_total_confidence;
				$total_assessment_skip = $total_assessment_skip + $assessment_skip_no;
				$total_review_skip = $total_review_skip + $review_assessment_skip_no;
				$total_combine_score = $total_combine_score + $combine_total;

				//end

				//get review assessment answer timing details
				$multiple_choice_time = $this->store_procedure_model->getassessmentanswertiming($value->ss_aw_lesson_topic_id, 2);
				$multiple_choice_answer_begin_time = 0;
				if (!empty($multiple_choice_time)) {
					$multiple_choice_answer_begin_time = $multiple_choice_time[0]->begin_to_answer;
				}
				$short_answer_time = $this->store_procedure_model->getassessmentanswertiming($value->ss_aw_lesson_topic_id, 1);
				$short_answer_begin_time = 0;
				if (!empty($short_answer_time)) {
					$short_answer_begin_time = $short_answer_time[0]->begin_to_answer;
				}
				$rewrite_sentence_time = $this->store_procedure_model->getassessmentanswertiming($value->ss_aw_lesson_topic_id, 3);
				$rewrite_sentence_answer_begin_time = 0;
				if (!empty($rewrite_sentence_time)) {
					$rewrite_sentence_answer_begin_time = $rewrite_sentence_time[0]->begin_to_answer;
				}

				
				//get assessment answer timing details
				$multiple_choice_assessment_time = $this->store_procedure_model->getassessmentformatoneanswertiming($value->ss_aw_lesson_topic_id, 2);
				$multiple_choice_assessment_answer_begin_time = 0;
				if (!empty($multiple_choice_assessment_time)) {
					$multiple_choice_assessment_answer_begin_time = $multiple_choice_assessment_time[0]->begin_to_answer;
				}
				$short_answer_assessment_time = $this->store_procedure_model->getassessmentformatoneanswertiming($value->ss_aw_lesson_topic_id, 1);
				$short_answer_assessment_answer_begin_time = 0;
				if (!empty($short_answer_assessment_time)) {
					$short_answer_assessment_answer_begin_time = $short_answer_assessment_time[0]->begin_to_answer;
				}
				$rewrite_sentence_assessment_time = $this->store_procedure_model->getassessmentformatoneanswertiming($value->ss_aw_lesson_topic_id, 3);
				$rewrite_sentence_assessment_answer_begin_time = 0;
				if (!empty($rewrite_sentence_assessment_time)) {
					$rewrite_sentence_assessment_answer_begin_time = $rewrite_sentence_assessment_time[0]->begin_to_answer;
				}

				$total_multiple_choice_time = $multiple_choice_answer_begin_time + $multiple_choice_assessment_answer_begin_time;
				$total_short_answer_time = $short_answer_begin_time + $short_answer_assessment_answer_begin_time;
				$total_rewrite_sentence_time = $rewrite_sentence_answer_begin_time + $rewrite_sentence_assessment_answer_begin_time;

				$total_taking_time = $total_multiple_choice_time + $total_short_answer_time + $total_rewrite_sentence_time;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(3);
				$total_test_time = $timesetting[0]->ss_aw_test_timing_value;

				$all_question_average = round(($total_taking_time / $total_test_time), 2);

				$second_data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_topic_name' => $value->ss_aw_lesson_topic,
					'ss_aw_multiple_choice' => $total_multiple_choice_time,
					'ss_aw_short_answer' => $total_short_answer_time,
					'ss_aw_complete_sentence' => $total_rewrite_sentence_time,
					'ss_aw_all_question' => $all_question_average
				);

				$required_time_ary[] = $second_data;
				$this->store_procedure_model->store_assessment_review_answer_timing($second_data);

				$total_assessment_multiple_choice_answer_time = $total_assessment_multiple_choice_answer_time + $total_multiple_choice_time;
				$total_assessment_short_answer_time = $total_assessment_short_answer_time + $total_short_answer_time;
				$total_assessment_rewrite_answer_time = $total_assessment_rewrite_answer_time + $total_rewrite_sentence_time;
				$total_assessment_answer_time = $total_assessment_answer_time + $all_question_average;
			}

			//store total skip,back click with combine score
			$total_skip_backclick = array(
				'ss_aw_child_id' => $child_id,
				'ss_aw_level' => $level_type,
				'ss_aw_lesson_skip' => $total_lesson_skip,
				'ss_aw_lesson_back_click' => $total_lesson_back_click,
				'ss_aw_lesson_total' => $total_lesson_skip_back_click,
				'ss_aw_assessment_skip' => $total_assessment_skip,
				'ss_aw_review_skip' => $total_review_skip,
				'ss_aw_combine_score' => $total_combine_score
			);

			$this->store_procedure_model->store_total_skip_back_click_details($total_skip_backclick);

			//store total assessment answers timing
			$total_topics = count($scored_lesson_list);
			$total_answer_timing = array(
				'ss_aw_child_id' => $child_id,
				'ss_aw_level' => $level_type,
				'ss_aw_multiple_choice' => round(($total_assessment_multiple_choice_answer_time / $total_topics), 2),
				'ss_aw_short_answer' => round(($total_assessment_short_answer_time / $total_topics), 2),
				'ss_aw_complete_sentence' => round(($total_assessment_rewrite_answer_time / $total_topics), 2),
				'ss_aw_all_question' => round(($total_assessment_answer_time / $total_topics), 2)
			);

			$this->store_procedure_model->store_total_assessment_review_answer_timing($total_answer_timing);

			//store grouping value
			$total_topics = count($scored_lesson_list);
			$total_topics = 5;
			$x = ((int)($total_topics / ASSESSMENT_GROUPING_DIVIDER) * ASSESSMENT_GROUPING_MULTIPLIER);
			$calculate_key = $total_topics - $x;
			if ($calculate_key == 0) {
				$topic_per_group = (int)($total_topics / 3);
				$first_group = range(0, ($topic_per_group - 1));
				$first_group_last_index_value = $first_group[count($first_group) - 1];
				$second_group = range(($first_group_last_index_value + 1), ($first_group_last_index_value + $topic_per_group));
				$second_group_last_index_value = $second_group[count($second_group) - 1];
				$third_group = range(($second_group_last_index_value + 1), ($second_group_last_index_value + $topic_per_group));
			}
			elseif ($calculate_key == 1) {
				$topic_per_group = (int)($total_topics / 3);
				$first_group = range(0, ($topic_per_group - 1));
				$first_group_last_index_value = $first_group[count($first_group) - 1];
				$second_group = range(($first_group_last_index_value + 1), ($first_group_last_index_value + $topic_per_group + 1));
				$second_group_last_index_value = $second_group[count($second_group) - 1];
				$third_group = range(($second_group_last_index_value + 1), ($second_group_last_index_value + $topic_per_group));
			}
			elseif ($calculate_key == 2) {
				$topic_per_group = (int)($total_topics / 3);
				$first_group = range(0, ($topic_per_group - 1));
				$first_group_last_index_value = $first_group[count($first_group) - 1];
				$second_group = range(($first_group_last_index_value + 1), ($first_group_last_index_value + $topic_per_group + 1));
				$second_group_last_index_value = $second_group[count($second_group) - 1];
				$third_group = range(($second_group_last_index_value + 1), ($second_group_last_index_value + $topic_per_group + 1));
			}

			if (!empty($first_group)) {

				$first_group_score = 0;
				$time_total = 0;
				for ($i=0; $i < count($first_group); $i++) { 

					if (!empty($lesson_confidence_dataAry[$first_group[$i]])) {
						$first_group_score = $first_group_score + $lesson_confidence_dataAry[$first_group[$i]]['ss_aw_combine_score'];	
					}
					
					if (!empty($required_time_ary[$first_group[$i]])) {
						$time_total = $time_total + $required_time_ary[$first_group[$i]]['ss_aw_all_question'];	
					}	
				}

				$average_time_total = round($time_total / count($first_group), 2);
				$group_data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_group_name' => 'first',
					'ss_aw_combine_score' => round($first_group_score, 2),
					'ss_aw_lesson' => count($first_group),
					'ss_aw_avg_lesson' => round(($first_group_score / count($first_group)), 2),
					'ss_aw_average_time_to_answer' => $average_time_total
				);

				$this->store_procedure_model->addgrouptotal($group_data);
			}

			if (!empty($second_group)) {

				$first_group_score = 0;
				$time_total = 0;
				for ($i=0; $i < count($second_group); $i++) { 

					if (!empty($lesson_confidence_dataAry[$second_group[$i]])) {
						$first_group_score = $first_group_score + $lesson_confidence_dataAry[$second_group[$i]]['ss_aw_combine_score'];	
					}
					
					if (!empty($required_time_ary[$second_group[$i]])) {
						$time_total = $time_total + $required_time_ary[$second_group[$i]]['ss_aw_all_question'];	
					}	
				}

				$average_time_total = round($time_total / count($second_group), 2);
				$group_data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_group_name' => 'second',
					'ss_aw_combine_score' => round($first_group_score, 2),
					'ss_aw_lesson' => count($second_group),
					'ss_aw_avg_lesson' => round(($first_group_score / count($second_group)), 2),
					'ss_aw_average_time_to_answer' => $average_time_total
				);

				$this->store_procedure_model->addgrouptotal($group_data);
			}

			if (!empty($third_group)) {

				$first_group_score = 0;
				$time_total = 0;
				for ($i=0; $i < count($third_group); $i++) { 

					if (!empty($lesson_confidence_dataAry[$third_group[$i]])) {
						$first_group_score = $first_group_score + $lesson_confidence_dataAry[$third_group[$i]]['ss_aw_combine_score'];	
					}
					
					if (!empty($required_time_ary[$third_group[$i]])) {
						$time_total = $time_total + $required_time_ary[$third_group[$i]]['ss_aw_all_question'];	
					}	
				}

				$average_time_total = round($time_total / count($third_group), 2);
				$group_data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_group_name' => 'third',
					'ss_aw_combine_score' => round($first_group_score, 2),
					'ss_aw_lesson' => count($third_group),
					'ss_aw_avg_lesson' => round(($first_group_score / count($third_group)), 2),
					'ss_aw_average_time_to_answer' => $average_time_total
				);

				$this->store_procedure_model->addgrouptotal($group_data);
			}
			//end

			$this->store_multiple_type_assessment_data($child_id, $level, $level_type);
		}
	}

	public function show_confidence(){
		$child_id = $this->uri->segment(3);
		$level = $this->uri->segment(4);
		if (!empty(CONFIDENCE_MEASUREMENT[$level])) {
			$confidence_measurements_params = CONFIDENCE_MEASUREMENT[$level];
			$combine_score_detail = $this->store_procedure_model->get_total_combine_score($child_id, $level);
			if (!empty($combine_score_detail)) {
				$responseary['status'] = 200;
				$responseary['success'] = true;
				$confidence = "";
				$total_combine_score = $combine_score_detail[0]->ss_aw_combine_score;
				foreach ($confidence_measurements_params as $key => $value) {
					if ($value['type'] == 'le') {
						if ($total_combine_score <= $value['compare_with']) {
							$confidence = $value['msg'];
						}		
					}
					elseif ($value['type'] == 'both') {
						$compareAry = explode("@", $value['compare_with']);
						if (($total_combine_score >= $compareAry[0]) && ($total_combine_score <= $compareAry[1])) {
							$confidence = $value['msg'];
						}
					}
					elseif ($value['type'] == 'gt') {
						if ($total_combine_score > $value['compare_with']) {
							$confidence = $value['msg'];
						}
					}	
				}

				$responseary['confidence'] = $confidence;
			}
			else
			{
				$responseary['status'] = 500;
				$responseary['success'] = false;
			}
		}
		else
		{
			$responseary['status'] = 200;
			$responseary['success'] = false;
		}
		echo json_encode($responseary);
		return json_encode($responseary);
	}

	public function show_confidence_based_on_group(){
		$child_id = $this->uri->segment(3);
		$level = $this->uri->segment(4);
		if (!empty(CONFIDENCE_MEASUREMENT_BASED_ON_GROUP[$level])) {
			$confidence_measurements_params = CONFIDENCE_MEASUREMENT_BASED_ON_GROUP[$level];
			$group_score_detail = $this->store_procedure_model->getscoreofgroup($child_id, $level);
			$first_avg = 0;
			$third_avg = 0;
			if (!empty($group_score_detail)) {
				foreach ($group_score_detail as $key => $value) {
					if ($value->ss_aw_group_name == 'first') {
						$first_avg = $value->ss_aw_avg_lesson;
					}

					if ($value->ss_aw_group_name == 'third') {
						$third_avg = $value->ss_aw_avg_lesson;
					}
				}

				$responseary['status'] = 200;
				$responseary['success'] = true;
				$confidence = "";
				$total_combine_score = $third_avg - $first_avg;
				foreach ($confidence_measurements_params as $key => $value) {
					if ($value['type'] == 'lt') {
						if ($total_combine_score < $value['compare_with']) {
							$confidence = $value['msg'];
						}		
					}
					elseif ($value['type'] == '2le') {
						$compareAry = explode("@", $value['compare_with']);
						if (($total_combine_score >= $compareAry[0]) && ($total_combine_score <= $compareAry[1])) {
							$confidence = $value['msg'];
						}
					}
					elseif ($value['type'] == '1lt1le') {
						$compareAry = explode("@", $value['compare_with']);
						if (($total_combine_score > $compareAry[0]) && ($total_combine_score <= $compareAry[1])) {
							$confidence = $value['msg'];
						}
					}
					elseif ($value['type'] == 'ge') {
						if ($total_combine_score >= $value['compare_with']) {
							$confidence = $value['msg'];
						}
					}	
				}

				$responseary['confidence'] = $confidence;
			}
			else
			{
				$responseary['status'] = 500;
				$responseary['success'] = false;
			}
		}
		else
		{
			$responseary['status'] = 200;
			$responseary['success'] = false;
		}
		echo json_encode($responseary);
		return json_encode($responseary);
	}

	public function show_confidence_based_on_index($child_id, $level){
		/*$child_id = $this->uri->segment(3);
		$level = $this->uri->segment(4);*/
		$get_timing = $this->store_procedure_model->getquestioncompletetime($child_id, $level);
		$all_question_complete_timing = $get_timing[0]->ss_aw_all_question;
		$combine_score_detail = $this->store_procedure_model->get_total_combine_score($child_id, $level);
		$total_combine_score = $combine_score_detail[0]->ss_aw_combine_score;
		$count = 0;
		$responseary['point'] = "";
		foreach (CONFIDENCE_INDEX_MEASUREMENT[$level] as $key => $value) {
			$avg_time_ary = explode('-', $key);
			$start_avg = "";
			$end_avg = "";
			if ($avg_time_ary[0] != "") {
				$start_avg = $avg_time_ary[0];
			}

			if ($avg_time_ary[1] != "") {
				$end_avg = $avg_time_ary[1];
			}

			if ($start_avg != "" && $end_avg != "") {
				if ($count == 0) {
					if ($all_question_complete_timing >= $start_avg && $all_question_complete_timing <= $end_avg) {
						foreach ($value as $total_score => $point) {
							$total_score_index_ary = explode('-', $total_score);
							$start_score = "";
							$end_score = "";
							if ($total_score_index_ary[0] != "") {
								$start_score = $total_score_index_ary[0];	
							}
							if ($total_score_index_ary[1] != "") {
								$end_score = $total_score_index_ary[1];
							}
							if ($start_score != "" && $end_score != "") {
								if ($total_combine_score >= $start_score && $total_combine_score <= $end_score) {
									$responseary['point'] = $point;
								}
							}
						}
					}	
				}
				else
				{
					if ($all_question_complete_timing > $start_avg && $all_question_complete_timing <= $end_avg) {
						foreach ($value as $total_score => $point) {
							$total_score_index_ary = explode('-', $total_score);
							$start_score = "";
							$end_score = "";
							if ($total_score_index_ary[0] != "") {
								$start_score = $total_score_index_ary[0];	
							}
							if ($total_score_index_ary[1] != "") {
								$end_score = $total_score_index_ary[1];
							}
							if ($start_score != "" && $end_score != "") {
								if ($total_combine_score >= $start_score && $total_combine_score <= $end_score) {
									$responseary['point'] = $point;
								}
							}
						}	
					}
				}
			}
			else
			{
				if ($all_question_complete_timing > $start_avg) {
					foreach ($value as $total_score => $point) {
						$total_score_index_ary = explode('-', $total_score);
						foreach ($value as $total_score => $point) {
							$total_score_index_ary = explode('-', $total_score);
							$start_score = "";
							$end_score = "";
							if ($total_score_index_ary[0] != "") {
								$start_score = $total_score_index_ary[0];	
							}
							if ($total_score_index_ary[1] != "") {
								$end_score = $total_score_index_ary[1];
							}
							if ($start_score != "" && $end_score != "") {
								if ($total_combine_score >= $start_score && $total_combine_score <= $end_score) {
									$responseary['point'] = $point;
								}
							}
						}
					}
				}
			}
			$count++;
		}

		$responseary['status'] = 200;
		return json_encode($responseary);
	}

	public function store_multiple_type_assessment_data($child_id, $level, $level_type){
		$scored_lesson_list = $this->store_procedure_model->getallcompletelessonresult($child_id, $level, 'Multiple');
		if (!empty($scored_lesson_list)) {
			foreach ($scored_lesson_list as $key => $value) {
				$assessment_skip_no = $this->store_procedure_model->multipleassessmentwronganswerno($child_id, $level_type, $value->ss_aw_lession_id);
				$lesson_quiz_skip = $this->store_procedure_model->getlessonskipno($child_id, $level_type, $value->ss_aw_lession_id);
				$total_quiz_count = $assessment_skip_no + $lesson_quiz_skip;
				$data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_level' => $level_type,
					'ss_aw_topic' => $value->ss_aw_lesson_topic,
					'ss_aw_skip' => $total_quiz_count,
				);		

				$this->store_procedure_model->addmultipleformatscore($data);
			}
		}
	}

	public function createpdfreport($child_id, $level_num){
	//public function createpdfreport(){
		/*$child_id = $this->uri->segment(3);
		$level_num = $this->uri->segment(4);*/
		if ($level_num == 1) {
			$level = "E";
		}
		elseif ($level_num == 2) {
			$level = "C";
		}
		else{
			$level = "A";
		}

		$data = array();
		if (!empty($child_id) && !empty($level)) {
			$result = $this->store_procedure_model->getlessonassessmentscoreformatone($child_id, $level);
			$data['result'] = $result;
			$data['total_score'] = $this->store_procedure_model->getlessonassessmenttotalscore($child_id, $level);
			$data['diagnostic_assessment'] = $this->store_procedure_model->getdiagnosticassessmentscore($child_id, $level);
			$data['formattwo_lesson_assessment'] = $this->store_procedure_model->getlessonassessmentformattwo($child_id, $level);
			$data['formattwo_lesson_assessment_total'] = $this->store_procedure_model->getlessonassessmentformattwototal($child_id, $level);
			$data['readalong_score'] = $this->store_procedure_model->getreadalongscoring($child_id, $level);
			$data['readalong_total_score'] = $this->store_procedure_model->getreadalongtotalscoring($child_id, $level);
			$data['student_detail'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			$data['course_level'] = $level;
			$data['scoring_statements'] = $this->store_procedure_model->getscoringstatements();
			$data['confidence_index_detail'] = $this->show_confidence_based_on_index($child_id, $level);
			$data['language_confidence'] = $this->store_procedure_model->getlanguageconfidencebychildlevel($child_id, $level);
			$average_group_lesson = $this->store_procedure_model->get_group_average_lesson($level_num);
			$total_complete_lesson = 0;
			$group_lesson_average = 0;
			if (!empty($average_group_lesson)) {
				foreach ($average_group_lesson as $key => $value) {
					$total_complete_lesson = $total_complete_lesson + $value->lesson_complete_count;
				}

				$group_lesson_average = $total_complete_lesson / count($average_group_lesson);
			}
			$data['group_average_lesson'] = round($group_lesson_average);

			$all_childs = $this->ss_aw_childs_model->get_all_child();
			$child_id_ary = array();
			if (!empty($all_childs)) {
				foreach ($all_childs as $key => $value) {
					$childary = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
					if (!empty($childary)) {
						$level_numeric = $childary[count($childary) - 1]['ss_aw_course_id'];
						if ($level_numeric == $level_num) {
							$child_id_ary[] = $value->ss_aw_child_id;
						}
					}
				}
			}
			
			$average_group_assessment = $this->store_procedure_model->get_group_average_assessment($child_id_ary);
			$total_complete_assessment = 0;
			$group_assessment_average = 0;
			if (!empty($average_group_assessment)) {
				foreach ($average_group_assessment as $key => $value) {
					$total_complete_assessment = $total_complete_assessment + $value->assessment_complete_count;
				}

				$group_assessment_average = $total_complete_assessment / count($child_id_ary);
			}

			$data['group_average_assessment'] = round($group_assessment_average);

			$average_group_readalong = $this->store_procedure_model->get_group_average_readalong($child_id_ary);
			$average_group_reading_comprehension = $this->store_procedure_model->get_group_average_multiple_assessment($child_id_ary);
			$total_complete_readalong = 0;
			$group_assessment_readalong = 0;
			if (!empty($average_group_readalong)) {
				foreach ($average_group_readalong as $key => $value) {
					$total_complete_readalong = $total_complete_readalong + $value->readalong_complete_count;
				}
			}

			if (!empty($average_group_reading_comprehension)) {
				foreach ($average_group_reading_comprehension as $key => $value) {
					$total_complete_readalong = $total_complete_readalong + $value->assessment_complete_count;
				}
			}

			$group_assessment_readalong = ($total_complete_readalong + 1) / count($child_id_ary);

			$data['group_average_readalong'] = round($group_assessment_readalong);

		}
		$this->load->library('pdf');
		$html = $this->load->view('pdf/finalscore', $data, true);
		$filename = time().rand()."_".$child_id.".pdf";
		$save_file_path = "./scorepdf/".$filename;
		$this->pdf->createPDF($save_file_path, $html, $filename, false);
		$insert_data = array(
			'ss_aw_child_id' => $child_id,
			'ss_aw_level' => $level,
			'ss_aw_report_path' => $filename
		);
		$this->ss_aw_child_result_model->add_record($insert_data);
	}

	public function store_quintile(){
		$remove_previous_quintile = $this->ss_aw_combine_score_quintile_model->remove_quintile();
		
		for ($k=1; $k < 4; $k++) { 
			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_combine_correct_by_topic = $this->ss_aw_lesson_assessment_score_model->gettotalcombinecorrect($level_type);

			$total_result_num = count($get_combine_correct_by_topic);
			if ($total_result_num >= 200) {
				for ($j=$total_result_num; $j >= 200 ; $j--) { 
					if ($j % 5 == 0) {
						$mediator = $total_result_num / 5;
						for ($i=1; $i <= 5; $i++) { 
							$low_index_value = $i - 1;
							$low_index = $mediator * $low_index_value;
							$high_index = $mediator * $i;
							$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
							if ($j == 5) {
								$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
							}
							else
							{
								$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
							}

							$data = array(
								'level' => $level_type,
								'quintile' => $i,
								'low_value' => $low_value,
								'high_value' => $hign_value
							);

							$this->ss_aw_combine_score_quintile_model->save_data($data);
						}	
						break;
					}
				}
			}
		}
	}

	public function store_topic_wise_quintile(){
		$this->ss_aw_combine_score_quintile_topic_wise_model->remove_quintile();
		//for level E
		for ($k=1; $k < 4; $k++) { 
			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_course_complete = $this->store_procedure_model->getallcompletecoursestudentbylevel($k);
			if (!empty($get_course_complete)) {
				$child_id = array();
				foreach ($get_course_complete as $key => $value) {
					$child_id[] = $value->ss_aw_child_id;	
				}

				$get_completed_topics = $this->store_procedure_model->get_scored_lesson_by_multiple_child($child_id, $k, 'Single');
				if (!empty($get_completed_topics)) {
					foreach ($get_completed_topics as $topics) {
						$topic = $topics->ss_aw_lesson_topic;
						$get_combine_correct_by_topic = $this->ss_aw_lesson_assessment_score_model->getallbyindividualtopic($level_type, $topic, $child_id);
						$total_result_num = count($get_combine_correct_by_topic);
						if ($total_result_num >= 200) {
							for ($j=$total_result_num; $j >= 200 ; $j--) { 
								if ($j % 5 == 0) {
									$mediator = $total_result_num / 5;
									for ($i=1; $i <= 5; $i++) { 
										$low_index_value = $i - 1;
										$low_index = $mediator * $low_index_value;
										$high_index = $mediator * $i;
										$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
										if ($j == 5) {
											$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
										}
										else
										{
											$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
										}

										$data = array(
											'topic' => $topic,
											'level' => $level_type,
											'quintile' => $i,
											'low_value' => $low_value,
											'high_value' => $hign_value
										);

										$this->ss_aw_combine_score_quintile_topic_wise_model->save_data($data);
									}	
									break;
								}
							}
						}	
					}	
				}	
			}	
		}	
	}

	public function store_diagnostic_quintile(){
		$remove_previous_quintile = $this->ss_aw_diagnostic_quintile_model->remove_quintile();
		
		for ($k=1; $k < 4; $k++) { 

			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_combine_correct_by_topic = $this->ss_aw_lesson_assessment_score_model->gettotaldiagnosticcorrect($level_type);

			$total_result_num = count($get_combine_correct_by_topic);
			if ($total_result_num >= 200) {
				for ($j=$total_result_num; $j >= 200 ; $j--) { 
					if ($j % 5 == 0) {
						$mediator = $total_result_num / 5;
						for ($i=1; $i <= 5; $i++) { 
							$low_index_value = $i - 1;
							$low_index = $mediator * $low_index_value;
							$high_index = $mediator * $i;
							$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
							if ($j == 5) {
								$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
							}
							else
							{
								$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
							}

							$data = array(
								'level' => $level_type,
								'quintile' => $i,
								'low_value' => $low_value,
								'high_value' => $hign_value
							);

							$this->ss_aw_diagnostic_quintile_model->save_data($data);
						}	
						break;
					}
				}
			}	
		}
	}

	public function store_assessment_quintile(){
		$remove_previous_quintile = $this->ss_aw_assessment_quintile_model->remove_quintile();
		
		for ($k=1; $k < 4; $k++) { 

			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_combine_correct_by_topic = $this->ss_aw_lesson_assessment_score_model->gettotalassessmentcorrect($level_type);

			$total_result_num = count($get_combine_correct_by_topic);
			if ($total_result_num >= 200) {
				for ($j=$total_result_num; $j >= 200 ; $j--) { 
					if ($j % 5 == 0) {
						$mediator = $total_result_num / 5;
						for ($i=1; $i <= 5; $i++) { 
							$low_index_value = $i - 1;
							$low_index = $mediator * $low_index_value;
							$high_index = $mediator * $i;
							$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
							if ($j == 5) {
								$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
							}
							else
							{
								$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
							}

							$data = array(
								'level' => $level_type,
								'quintile' => $i,
								'low_value' => $low_value,
								'high_value' => $hign_value
							);

							$this->ss_aw_assessment_quintile_model->save_data($data);
						}	
						break;
					}
				}
			}	
		}
	}

	public function store_format_two_lesson_assessment_quintile(){
		$remove_previous_quintile = $this->ss_aw_lesson_assessment_format_two_quintile_model->remove_quintile();
		
		for ($k=1; $k < 4; $k++) { 

			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_combine_correct_by_topic = $this->ss_aw_lesson_assessment_score_model->gettotalformattwolessonassessmentcorrect($level_type);

			$total_result_num = count($get_combine_correct_by_topic);
			if ($total_result_num >= 200) {
				for ($j=$total_result_num; $j >= 200 ; $j--) { 
					if ($j % 5 == 0) {
						$mediator = $total_result_num / 5;
						for ($i=1; $i <= 5; $i++) { 
							$low_index_value = $i - 1;
							$low_index = $mediator * $low_index_value;
							$high_index = $mediator * $i;
							$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
							if ($j == 5) {
								$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
							}
							else
							{
								$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
							}

							$data = array(
								'level' => $level_type,
								'quintile' => $i,
								'low_value' => $low_value,
								'high_value' => $hign_value
							);

							$this->ss_aw_lesson_assessment_format_two_quintile_model->save_data($data);
						}	
						break;
					}
				}
			}	
		}
	}

	public function readalong_score_quintile(){
		$remove_previous_quintile = $this->ss_aw_readalong_score_quintile_model->remove_quintile();
		
		for ($k=1; $k < 4; $k++) { 

			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_combine_correct_by_topic = $this->store_procedure_model->getreadalongtotalscore($level_type);

			$total_result_num = count($get_combine_correct_by_topic);
			if ($total_result_num >= 200) {
				for ($j=$total_result_num; $j >= 200 ; $j--) { 
					if ($j % 5 == 0) {
						$mediator = $total_result_num / 5;
						for ($i=1; $i <= 5; $i++) { 
							$low_index_value = $i - 1;
							$low_index = $mediator * $low_index_value;
							$high_index = $mediator * $i;
							$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
							if ($j == 5) {
								$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
							}
							else
							{
								$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
							}

							$data = array(
								'level' => $level_type,
								'quintile' => $i,
								'low_value' => $low_value,
								'high_value' => $hign_value
							);

							$this->ss_aw_readalong_score_quintile_model->save_data($data);
						}	
						break;
					}
				}
			}	
		}
	}

	public function english_language_confidence_quintile(){
		$remove_previous_quintile = $this->ss_aw_english_language_confidence_quintile_model->remove_quintile();
		
		for ($k=1; $k < 4; $k++) { 

			if ($k == 1) {
				$level_type = "E";
			}
			elseif ($k == 2) {
				$level_type = "C";
			}
			else
			{
				$level_type = "A";
			}

			$get_combine_correct_by_topic = $this->store_procedure_model->getlessonconfiencescoredetail($level_type);

			$total_result_num = count($get_combine_correct_by_topic);
			if ($total_result_num >= 200) {
				for ($j=$total_result_num; $j >= 200 ; $j--) { 
					if ($j % 5 == 0) {
						$mediator = $total_result_num / 5;
						for ($i=1; $i <= 5; $i++) { 
							$low_index_value = $i - 1;
							$low_index = $mediator * $low_index_value;
							$high_index = $mediator * $i;
							$low_value = $get_combine_correct_by_topic[$low_index]->ss_aw_combine_correct;
							if ($j == 5) {
								$hign_value = $get_combine_correct_by_topic[$total_result_num]->ss_aw_combine_correct;	
							}
							else
							{
								$hign_value = $get_combine_correct_by_topic[$hign_index]->ss_aw_combine_correct;
							}

							$data = array(
								'level' => $level_type,
								'quintile' => $i,
								'low_value' => $low_value,
								'high_value' => $hign_value
							);

							$this->ss_aw_english_language_confidence_quintile_model->save_data($data);
						}	
						break;
					}
				}
			}	
		}
	}

	public function create_promotional_score(){
		$child_id = $this->uri->segment(3);
		$lesson_id = $this->uri->segment(4);
		$assessment_id = $this->uri->segment(5);
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level = $childary[count($childary) - 1]['ss_aw_course_id'];
		if ($level == 1) {
			$course_code = "E";
		}
		elseif ($level == 2) {
			$course_code = "C";
		}
		else
		{
			$course_code = "A";
		}

		{
			$lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
			$format = $lesson_detail[0]->ss_aw_lesson_format;
			$lesson_quiz_detail = $this->get_lesson_details_list($lesson_id, $child_id);

			if (!empty($lesson_quiz_detail)) {
				$lesson_quiz = json_decode($lesson_quiz_detail);
				if (!empty($lesson_quiz)) {
					if (!empty($lesson_quiz->result)) {
						if (!empty($lesson_quiz->result->data)) {
							
							foreach ($lesson_quiz->result->data as $key => $value) {
								if (!empty($value->details)) {
									$record_detail = $value->details;
									if (!empty($record_detail->quizes)) {
												
									//store curent lesson page index
										$lessonary = array();
										$lessonary['ss_aw_lesson_id'] = $lesson_id;
										$lessonary['ss_aw_child_id'] = $child_id;
										$lessonary['ss_aw_lesson_index'] = $value->index;
										$lessonary['ss_aw_updated_date'] = date('Y-m-d H:i:s');
										$lessonary['ss_aw_back_click_count'] = rand(0, 10);
										$response = $this->ss_aw_current_lesson_model->update_record($lessonary);
										if($response == 0)
										{
											$this->ss_aw_current_lesson_model->insert_data($lessonary);
										}
												//end

										$quizes = $record_detail->quizes;
										foreach ($quizes as $quiz) {
											if (!empty($quiz->question)) {
												$question = $quiz->question;
												$answers = "";
												if (!empty($quiz->answers)) {
													$answers = implode(",", $quiz->answers);
												}
												$options = "";
												if (!empty($quiz->options) && !empty($quiz->options[0])) {
													$options = implode(",", $quiz->options);
												}

												$postdata = array();
												$postdata['ss_aw_child_id'] = $child_id;
												$postdata['ss_aw_lesson_id'] = $lesson_id;
												$postdata['ss_aw_question'] = $question;
												$postdata['ss_aw_options'] = $options;
												$postdata['ss_aw_post_answer'] = $answers;
												$postdata['ss_aw_question_format'] = $quiz->qtype;
												$postdata['ss_aw_answer_status'] = 1; // 1 = Right,2 = Wrong
												if ($format == 'Multiple') {
													$postdata['ss_aw_topic_id'] = $quiz->topic_id;
												}
												else
												{
													$postdata['ss_aw_topic_id'] = $lesson_quiz->result->topic_id;
												}
														
												$postdata['ss_aw_seconds_to_start_answer_question'] = 0;
												$postdata['ss_aw_seconds_to_answer_question'] = 0;
														
														
												$searchary = array();
												$searchary['ss_aw_child_id'] = $child_id;
												$searchary['ss_aw_lesson_id'] = $lesson_id;
												$searchary['ss_aw_question'] = $question;
												$searchdetailsary = array();
												$searchdetailsary = $this->ss_aw_lesson_quiz_ans_model->search_data_by_param($searchary);
												if(empty($searchdetailsary))
												{
													$this->ss_aw_lesson_quiz_ans_model->data_insert($postdata);
												}
												else
												{
													$record_id = $searchdetailsary[0]['ss_aw_id'];
													$postdata['ss_aw_id'] = $record_id;
															$this->ss_aw_lesson_quiz_ans_model->update_record($postdata);
												}
											}
										}
									}
								}
							}

							$childary = $this->ss_aw_child_course_model->get_details($child_id);
							$level = $childary[count($childary) - 1]['ss_aw_course_id'];

							$data = array();
							$data['child_id'] = $child_id;
							$data['lesson_id'] = $lesson_id;
							$data['level_id'] = $level;
							$data['ss_aw_lesson_status'] = 2;// 1 = Completed ,2 = Running
							$data['ss_aw_last_lesson_modified_date'] = date('Y-m-d H:i:s');
							$data['ss_aw_back_click_count'] = rand(0, 10);

							$response = $this->ss_aw_child_last_lesson_model->update_details($data);
											
							//get all score content to store
							$totalquestion = $this->ss_aw_lesson_quiz_ans_model->gettotalquestionbylessonchild($lesson_id, $child_id);

							$totalwrightanswer = $this->ss_aw_lesson_quiz_ans_model->gettotalwrightanswerbylessonchild($lesson_id, $child_id);

							$store_score = array(
								'child_id' => $child_id,
								'lesson_id' => $lesson_id,
								'total_question' => $totalquestion,
								'wright_answers' => $totalwrightanswer,
								'level' => $course_code
							);

							$check_storage = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_id);
							if (!empty($check_storage)) {
								$this->ss_aw_lesson_score_model->update_data($store_score);
							}
							else
							{
								$this->ss_aw_lesson_score_model->store_data($store_score);
							}
						}
					}
				}
			}
		}

		
		
		$assessment_id = $this->uri->segment(5);
		{
			$assessment_count = 0;
			{
				{
					$assessment_exam_code = "";
					$this->db->trans_start();
				

					$back_click_count = 0;
					$check_existance = $this->ss_aw_assessment_exam_completed_model->getexamdetail($assessment_id, $child_id);
					if (empty($check_existance)) {
						$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
						if (!empty($assessment_details)) {
							$assessemnt_format = $assessment_details[0]->ss_aw_assesment_format;
							if ($assessemnt_format == 'Single') {

								$assessment_question_detail = $this->assessment_exam_question_first_question($child_id, $assessment_id);

								$assessment_first_questions = json_decode($assessment_question_detail);

								if (!empty($assessment_first_questions)) {
									if (!empty($assessment_first_questions->data)) {
										$assessment_first_set = $assessment_first_questions->data;
										$exam_code = $assessment_first_questions->assessment_exam_code;
										$assessment_exam_code = $exam_code;
										foreach ($assessment_first_set as $key => $value) {
											$question_id = $value->question_id;
											$answers_post = "";
											$right_answers = "";
											$answers_status = 1;
											$question_format = 0;
											if($value->question_format == 'Choose the right answer'){
												$question_format = 2;
											}
											else if($value->question_format == 'Fill in the blanks'){
												$question_format = 1;
											}
											else if($value->question_format == 'Rewrite the sentence'){
												$question_format = 3;
											}
											$question_topic_id = $value->question_topic_id;

											$searchary = array();
											$searchary['ss_aw_id'] = $question_id;
											$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);

											$level = $question_detailsary[0]['ss_aw_level']; // E,C,A
											$category = $question_detailsary[0]['ss_aw_category']; 
											$sub_category = $question_detailsary[0]['ss_aw_sub_category']; 
											$weight = $question_detailsary[0]['ss_aw_weight'];
											
											$storedata = array();
											$storedata['ss_aw_log_child_id'] = $child_id;
											$storedata['ss_aw_log_question_id'] = $question_id;
											$storedata['ss_aw_log_level'] = $level;
											$storedata['ss_aw_log_category'] = $category;
											$storedata['ss_aw_log_subcategory'] = $sub_category;
											$storedata['ss_aw_log_answers'] = $answers_post;
											$storedata['ss_aw_log_weight'] = $weight;
											$storedata['ss_aw_log_right_answers'] = $right_answers;
											$storedata['ss_aw_log_answer_status'] = $answers_status;  // 1 = Right, 2 = Wrong, 3= Skip
											$storedata['ss_aw_log_exam_code'] = $exam_code;
											$storedata['ss_aw_log_question_type'] = $question_format;
											$storedata['ss_aw_log_topic_id'] = $question_topic_id;
											
											$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
										}
									}
								}

								$assessment_next_level_question = $this->assessment_exam_question_next_level_subcategory($child_id, $assessment_id, $assessment_first_questions->assessment_exam_code);
								$assessment_next_questions = json_decode($assessment_next_level_question);

								
								if (!empty($assessment_next_questions)) {
									if (!empty($assessment_next_questions->data)) {
										$assessment_second_set = $assessment_next_questions->data;
										$exam_code = $assessment_next_questions->assessment_exam_code;
										foreach ($assessment_second_set as $key => $value) {
											$question_id = $value->question_id;
											$answers_post = "";
											$right_answers = "";
											$answers_status = 1;

											$question_format = 0;
											if($value->question_format == 'Choose the right answer'){
												$question_format = 2;
											}
											else if($value->question_format == 'Fill in the blanks'){
												$question_format = 1;
											}
											else if($value->question_format == 'Rewrite the sentence'){
												$question_format = 3;
											}
											$question_topic_id = $value->question_topic_id;

											$searchary = array();
											$searchary['ss_aw_id'] = $question_id;
											$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);

											$level = $question_detailsary[0]['ss_aw_level']; // E,C,A
											$category = $question_detailsary[0]['ss_aw_category']; 
											$sub_category = $question_detailsary[0]['ss_aw_sub_category']; 
											$weight = $question_detailsary[0]['ss_aw_weight'];
											
											$storedata = array();
											$storedata['ss_aw_log_child_id'] = $child_id;
											$storedata['ss_aw_log_question_id'] = $question_id;
											$storedata['ss_aw_log_level'] = $level;
											$storedata['ss_aw_log_category'] = $category;
											$storedata['ss_aw_log_subcategory'] = $sub_category;
											$storedata['ss_aw_log_answers'] = $answers_post;
											$storedata['ss_aw_log_weight'] = $weight;
											$storedata['ss_aw_log_right_answers'] = $right_answers;
											$storedata['ss_aw_log_answer_status'] = $answers_status;  // 1 = Right, 2 = Wrong, 3= Skip
											$storedata['ss_aw_log_exam_code'] = $exam_code;
											$storedata['ss_aw_log_question_type'] = $question_format;
											$storedata['ss_aw_log_topic_id'] = $question_topic_id;
											$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
										}
									}
								}
								
								$topic_detail = $this->ss_aw_assesment_uploaded_model->gettopic($assessment_id);
								$total_subtopic = $this->ss_aw_sections_subtopics_model->totalnoofsubtopic($topic_detail[0]->ss_aw_assesment_topic_id);

								if ($total_subtopic > 1) {
									for ($i=0; $i < $total_subtopic - 1; $i++) { 
										$assessment_next_sub_category_level_question = $this->assessment_exam_question_next_sub_category($child_id, $assessment_id, $assessment_first_questions->assessment_exam_code);
										$assessment_next_sub_category_question = json_decode($assessment_next_sub_category_level_question);

										if (!empty($assessment_next_sub_category_question)) {
											if (!empty($assessment_next_sub_category_question->data)) {
												$assessment_third_set = $assessment_next_sub_category_question->data;
												$exam_code = $assessment_next_sub_category_question->assessment_exam_code;
												foreach ($assessment_third_set as $key => $value) {
													$question_id = $value->question_id;
													$answers_post = "";
													$right_answers = "";
													$answers_status = 1;

													$question_format = 0;
													if($value->question_format == 'Choose the right answer'){
														$question_format = 2;
													}
													else if($value->question_format == 'Fill in the blanks'){
														$question_format = 1;
													}
													else if($value->question_format == 'Rewrite the sentence'){
														$question_format = 3;
													}
													$question_topic_id = $value->question_topic_id;

													$searchary = array();
													$searchary['ss_aw_id'] = $question_id;
													$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);

													$level = $question_detailsary[0]['ss_aw_level']; // E,C,A
													$category = $question_detailsary[0]['ss_aw_category']; 
													$sub_category = $question_detailsary[0]['ss_aw_sub_category']; 
													$weight = $question_detailsary[0]['ss_aw_weight'];
													
													$storedata = array();
													$storedata['ss_aw_log_child_id'] = $child_id;
													$storedata['ss_aw_log_question_id'] = $question_id;
													$storedata['ss_aw_log_level'] = $level;
													$storedata['ss_aw_log_category'] = $category;
													$storedata['ss_aw_log_subcategory'] = $sub_category;
													$storedata['ss_aw_log_answers'] = $answers_post;
													$storedata['ss_aw_log_weight'] = $weight;
													$storedata['ss_aw_log_right_answers'] = $right_answers;
													$storedata['ss_aw_log_answer_status'] = $answers_status;  // 1 = Right, 2 = Wrong, 3= Skip
													$storedata['ss_aw_log_exam_code'] = $exam_code;
													$storedata['ss_aw_log_question_type'] = $question_format;
													$storedata['ss_aw_log_topic_id'] = $question_topic_id;
													$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
												}
											}
										}
									}
								}

								$searchary = array();
								$searchary['ss_aw_sub_section_no'] = $total_subtopic;
								$get_assessment_quiz_matrix = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($searchary);

								if (!empty($get_assessment_quiz_matrix)) {
									$total_questions = $total_subtopic * $get_assessment_quiz_matrix[0]['ss_aw_total_question'];	
								}
								else
								{
									$total_questions = 0;
								}

								$wright_answers = $this->ss_aw_assessment_exam_log_model->totalnoofcorrectanswers($assessment_exam_code, $child_id);
							}
							else
							{
								$assessment_multiple_questions = $this->assessment_exam_format_two_questions($child_id, $assessment_id);
								$assessment_multiple_question_detail = json_decode($assessment_multiple_questions);
								
								if (!empty($assessment_multiple_question_detail)) {
									if (!empty($assessment_multiple_question_detail->result)) {
										if (!empty($assessment_multiple_question_detail->result->data)) {
											foreach ($assessment_multiple_question_detail->result->data as $key => $value) {
												if (!empty($value->details)) {
													$record_detail = $value->details;
													if (!empty($record_detail->quizes)) {
														$quiz_question = $record_detail->quizes;
														foreach ($quiz_question as $quiz) {
													   		$assessment_exam_code = $assessment_multiple_question_detail->assessment_exam_code;
													   		
													   		if (!empty($quiz->question)) {
													   			$question = $quiz->question;
													   		}
													   		else
													   		{
													   			$question = $value->title;
													   		}
								
													   		$topic_id = $quiz->topic_id;
													   		$answer = "";
													   		
													   		
													   		$right_answers = "";
													   		if (!empty($quiz->answers)) {
													   			$right_answers = implode(",", $quiz->answers);
													   		}
													   		
													   		$answers_status = rand(1, 2);
													   		$seconds_to_start_answer_question = 0;
													   		$seconds_to_answer_question = 0;

													   		$data = array(
													   			'ss_aw_child_id' => $child_id,
													   			'ss_aw_assessment_id' => $assessment_id,
													   			'ss_aw_assessment_exam_code' => $assessment_exam_code,
													   			'ss_aw_question' => $question,
													   			'ss_aw_topic_id' => $topic_id,
													   			'ss_aw_answer' => $answer,
													   			'ss_aw_right_answers' => $right_answers,
													   			'ss_aw_answers_status' => $answers_status,
													   			'ss_aw_seconds_to_start_answer_question' => $seconds_to_start_answer_question,
													   			'ss_aw_seconds_to_answer_question' => $seconds_to_answer_question,
													   			'ss_aw_level' => $level,
													   			'ss_aw_created_at' => date('Y-m-d h:i:s')
													   		);

													   		
													   		$check_existance = $this->ss_aw_assesment_multiple_question_answer_model->check_data($data);

													   		if ($check_existance) {
													   			$record_id = $check_existance[0]->ss_aw_id;
													   			$this->ss_aw_assesment_multiple_question_answer_model->update_record($data, $record_id);
													   			$msg = "Assesment answer record updated successfully.";
													   		}
													   		else
													   		{
													   			$this->ss_aw_assesment_multiple_question_answer_model->store_data($data);
													   			$msg = "Assesment answer record stored successfully.";
													   		}


													   		$assessmentary = array();
															$assessmentary['ss_aw_assessment_id'] = $assessment_id;
															$assessmentary['ss_aw_child_id'] = $child_id;
															$assessmentary['ss_aw_page_index'] = $value->index;
															$assessmentary['ss_aw_exam_code'] = $assessment_exam_code;
															$assessmentary['ss_aw_created_at'] = date('Y-m-d H:i:s');
															$assessmentary['ss_aw_back_click_count'] = 0;

															$check_current_status = $this->ss_aw_assesment_multiple_question_asked_model->check_existance($value->index, $assessment_id, $child_id, $assessment_exam_code);

															if ($check_current_status == 0) {
																$this->ss_aw_assesment_multiple_question_asked_model->insert_record($assessmentary);
															}

														}
													}
												}
											}
										}
									}
								}
								$total_questions = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofquestionasked($assessment_id, $child_id);
								$wright_answers = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofcorrectanswers($assessment_id, $child_id);
							}
							
							$insert_data = array();
							$insert_data['ss_aw_assessment_id'] = $assessment_id;
							$insert_data['ss_aw_exam_code'] = $assessment_exam_code;
							$insert_data['ss_aw_child_id'] = $child_id;
							$insert_data['ss_aw_back_click_count'] = 0;
							$response = $this->ss_aw_assessment_exam_completed_model->insert_data($insert_data);
							if ($response) {
								$store_score = array(
									'child_id' => $child_id,
									'exam_code' => $assessment_exam_code,
									'assessment_id' => $assessment_id,
									'total_question' => $total_questions,
									'wright_answers' => $wright_answers,
									'level' => $course_code
								);

								$check_insertion = $this->ss_aw_assessment_score_model->store_data($store_score);	
								if ($check_insertion) {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam completed.';	
								}
									
							}
						}
					}

					$this->db->trans_complete();
					$assessment_count++;
				}
			}
		}

		$count_complete_assessment = $this->ss_aw_assessment_score_model->getcountbychildcourse($child_id, $course_code);
		
		if (count($count_complete_assessment) == 4) {
			$TOT_QUIZ_CNT_C = 0;
			$PER_SUM_SCO_E = 0;
			$PER_SUM_SCO_C = 0;
			$in_level_all_correct = 0;
			$next_level_all_correct = 0;
			$in_level_all_attempt = 0;
			$next_level_all_attempt = 0;

			foreach ($count_complete_assessment as $key => $value) {
				$assessment_id = $value->assessment_id;
				$exam_code = $value->exam_code;
				$in_level_attempt = $this->store_procedure_model->get_inlevel_assessment_questions($child_id, $course_code, $exam_code);
				
				$in_level_correct = $this->store_procedure_model->get_inlevel_assessment_correct_questions($child_id, $course_code, $exam_code);
				
				$next_level_attept = $this->store_procedure_model->get_nxtlevel_assessment_questions($child_id, $course_code, $exam_code);
				
				$next_level_correct = $this->store_procedure_model->get_nxtlevel_assessment_correct_questions($child_id, $course_code, $exam_code);

				$TOT_QUIZ_CNT_C = $TOT_QUIZ_CNT_C + $next_level_attept;
				$in_level_all_correct = $in_level_all_correct + $in_level_correct;
				$next_level_all_correct = $next_level_all_correct + $next_level_correct;
				$in_level_all_attempt = $in_level_all_attempt + $in_level_attempt;
				$next_level_all_attempt = $next_level_all_attempt + $next_level_attept;
				
			}

			$PER_SUM_SCO_E = ($in_level_all_correct / $in_level_all_attempt) * 100;
			$PER_SUM_SCO_C = ($next_level_all_correct / $next_level_all_attempt) * 100;

			if ($TOT_QUIZ_CNT_C > 10 && $PER_SUM_SCO_E >= 80 && $PER_SUM_SCO_C >= 70) {
					$data = array(
						'ss_aw_child_id' => $child_id,
						'ss_aw_current_level' => $course_code,
						'ss_aw_lesson_num' => count($count_complete_assessment),
						'created_at' => date('Y-m-d h:i:s')
					);

					$response = $this->ss_aw_promotion_model->add_record($data);

					if ($response) {

						$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

						
						$child_name = $child_profile[0]->ss_aw_child_nick_name;
						//for child

						if ($course_code == 'E') {
							$promoted_course = 'C';
							$promoted_course_name = 'Consolating';
							$course_code_name = "Emerging";
						}
						elseif ($course_code == 'C') {
							$promoted_course = 'A';
							$promoted_course_name = 'Advance';
							$course_code_name = "Consolating";
						}
						else{
							$promoted_course = '';
						}

						$email_template = getemailandpushnotification(17, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
							$body = str_ireplace("[@@current_course@@]", $course_code, $body);
							$body = str_ireplace("[@@promoted_course@@]", $promoted_course, $body);
							emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body, 'sayan.sen@schemaphic.com');
						}

						$app_template = getemailandpushnotification(17, 2, 2);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
							$body = str_ireplace("[@@current_course@@]", $course_code, $body);
							$body = str_ireplace("[@@promoted_course@@]", $promoted_course, $body);
							$title = $app_template['title'];
							$token = $child_profile[0]->ss_aw_device_token;

							pushnotification($title,$body,$token,10);

							$save_data = array(
								'user_id' => $child_id,
								'user_type' => 2,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => 10
							);

							save_notification($save_data);

						}

						//end

						$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);
						if (!empty($parent_detail)) {
							
							//for child
							$email_template = getemailandpushnotification(17, 1, 1);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@child_name@@]", $child_name, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@current_course@@]", $course_code, $body);
								$body = str_ireplace("[@@promoted_course@@]", $promoted_course, $body);
								emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body, 'sayan.sen@schemaphic.com');
							}
							
							$app_template = getemailandpushnotification(17, 2, 1);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@child_name@@]", $child_name, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@current_course@@]", $course_code, $body);
								$body = str_ireplace("[@@promoted_course@@]", $promoted_course, $body);
								$title = $app_template['title'];
								$token = $parent_detail[0]->ss_aw_device_token;

								$state_details = getchild_diagnosticexam_status($child_id);
								if ($course_code == 'E') {
									$level = 1;
								}
								elseif ($course_code == 'C') {
									$level = 2;
								}
								else{
									$level == 3;
								}

								//extra params
								$params = array(
									'childId' => $child_id,
									'childStateId' => $state_details['id'],
									'childStateSubId' => $state_details['sub_id'],
									'childNickName' => $child_profile[0]->ss_aw_child_nick_name,
									'courseId' => $level
								);

								$extra_data = json_encode($params);

								pushnotification($title,$body,$token,64,$extra_data);

								$save_data = array(
									'user_id' => $parent_detail[0]->ss_aw_parent_id,
									'user_type' => 1,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => 64,
									'params' => $extra_data
								);

								save_notification($save_data);
							}

							//end
						}
					}
				}
		}
	}

	public function downgradegradeCtoE(){
		$child_id = $this->uri->segment(3);
		$remove_promotion_invitation = $this->ss_aw_promotion_model->removedatabychillevel($child_id, 'E');
		$remove_course_payment = $this->ss_aw_child_course_model->removecoursewithpaymentdetail($child_id, 2);
	}

	public function create_promotional_assessment_score(){
		$child_id = $this->uri->segment(3);
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level = $childary[count($childary) - 1]['ss_aw_course_id'];

	} 

	public function currect_time(){
		echo date('Y-m-d H:i:s');
	}

	public function get_assessment_question_format(){
		$question_id = $this->uri->segment(3);
		$responseary = array();
		$value = $this->ss_aw_assisment_diagnostic_model->get_question_by_id($question_id);
		$i = 0;
		$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
		$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
		$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];
					
		if($value[0]['ss_aw_format'] == 'Single')
			$finalquestionary[$i]['format_id'] = 1;
		else
			$finalquestionary[$i]['format_id'] = 2;
					
		$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
		$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
		$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
		$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
		$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];
		if($value[0]['ss_aw_question_format'] == 'Choose the right answer')
			$finalquestionary[$i]['question_format_id'] = 2;
		else if($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
			$finalquestionary[$i]['question_format_id'] = 1;
		else if($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
			$finalquestionary[$i]['question_format_id'] = 3;
					
					
		$finalquestionary[$i]['prefaceaudio'] = base_url().$value[0]['ss_aw_question_preface_audio'];
		$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
		$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);
					
		$multiple_choice_ary = array();
		$multiple_choice_ary = explode("/",$value[0]['ss_aw_multiple_choice']);
					
		if(count($multiple_choice_ary) > 1)
		{
			$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
			$finalquestionary[$i]['options'] = $multiple_choice_ary;
		}
		else
		{
			$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];									
		}			
					
		$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];
					
		$answersary = array();
		$answersary = explode("/",trim($value[0]['ss_aw_answers']));
		if(count($answersary)> 1)
		{
			$answersary = array_map('trim', $answersary);
			$finalquestionary[$i]['answers'] = $answersary;
		}
		else
		{
			$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
		}
		$finalquestionary[$i]['answeraudio'] = base_url().$value[0]['ss_aw_answers_audio'];
		$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);
					
		$finalquestionary[$i]['hint'] = "";
		$finalquestionary[$i]['ruleaudio'] = base_url().$value[0]['ss_aw_rules_audio'];
		$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP			
		$responseary['data'] = $finalquestionary;
		die(json_encode($responseary));
	}

	public function cancel_scheduled_readalong(){
		$userid = $this->uri->segment(3);
		$this->load->model('ss_aw_schedule_readalong_model');
		$response = $this->ss_aw_schedule_readalong_model->cancelscheduledreadalong($userid);
		$this->db->where('ss_aw_child_id', $userid);
        $this->db->delete('ss_aw_readalong_quiz_ans');

        $this->db->where('ss_aw_child_id', $userid);
        $this->db->delete('ss_aw_last_readalong');

        $this->db->where('ss_aw_child_id', $userid);
        $this->db->delete('ss_aw_store_readalong_page');
        //end
		if ($response) {
			$responseary['msg'] = "Scheduled readalong canceled successfully.";
		}
		else
		{
			$responseary['msg'] = "Something went wrong, please try again later.";
		}

		die(json_encode($responseary));
	}

	public function reset_password(){
		$postdata = $this->input->post();
		$userid = $postdata['userid'];
		$user_type = $postdata['user_type'];
		$password = $postdata['password'];
		$hash_pass = @$this->bcrypt->hash_password($password);
		$responseary = array();
		if ($user_type == 1) {
			$data = array(
				'ss_aw_parent_password' => $hash_pass,
				'ss_aw_parent_auth_key' => ''
			);

			$response = $this->ss_aw_parents_model->update_parent_details($data, $userid);
			if ($response) {
				$msg = "Password changed successfully.";
			}
			else{
				$msg = "Something went wrong.";
			}
		}
		else{
			$data = array(
				'ss_aw_child_password' => $hash_pass,
				'ss_aw_child_auth_key' => ''
			);

			$response = $this->ss_aw_childs_model->update_child_details($data, $userid);
			if ($response) {
				$msg = "Password changed successfully.";
			}
			else{
				$msg = "Something went wrong.";
			}
		}

		$responseary['msg'] = $msg;
		die(json_encode($responseary));
	}

	//testing notification cheatcodes.
	// public function diagnostic_quiz_link(){
	// 	$child_id = $this->uri->segment(3);
	// 	$email_template = getemailandpushnotification(3, 1, 1);
	// 	$app_template = getemailandpushnotification(3, 2, 1);
	// 	$child_detail = $this->testingapi_model->getchilddetailsbyid($child_id);
	// 	if (!empty($email_template)) {
	// 		$body = $email_template['body'];
	// 		$body = str_ireplace("[@@username@@]", $child_detail[0]->ss_aw_parent_full_name, $body);
	// 		$body = str_ireplace("[@@child_name@@]", $child_detail[0]->ss_aw_child_nick_name, $body);
	// 		emailnotification($child_detail[0]->ss_aw_parent_email, $email_template['title'], $body);	
	// 	}

	// 	//app notification
	// 	if (!empty($app_template)) {
	// 		$body = $app_template['body'];
	// 		$body = str_ireplace("[@@child_name@@]", $child_detail[0]->ss_aw_child_nick_name, $body);
	// 		$title = $app_template['title'];
	// 		$token = $child_detail[0]->parent_device_token;

	// 		if (!empty($token)) {
	// 			pushnotification($title,$body,$token,1);	
	// 		}

	// 		$save_data = array(
	// 			'user_id' => $child_detail[0]->parent_id,
	// 			'user_type' => 1,
	// 			'title' => $title,
	// 			'msg' => $body,
	// 			'status' => 1,
	// 			'read_unread' => 0,
	// 			'action' => 1
	// 		);

	// 		save_notification($save_data);

	// 	}

	// 	$responseary['msg'] = "Send successfully.";
	// 	die(json_encode($responseary));
	// }

	// public function diagnostic_quiz_result(){
	// 	$child_id = $this->uri->segment(3);
	// 	$diagnostic_exam_details = $this->testingapi_model->getexamcodedetailsbychild($child_id);
	// 	$responseary = array();
	// 	if (!empty($diagnostic_exam_details)) {
	// 		$exam_code = $diagnostic_exam_details[0]->ss_aw_diagonastic_exam_code;
	// 		$total_marks = $this->ss_aw_diagonastic_exam_log_model->asked_question_num_by_exam_code($exam_code);
	// 		$obtain_marks = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
	// 		//send notification code
	// 		$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

	// 		$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
	// 		$child_name = $child_profile[0]->ss_aw_child_nick_name;

	// 		$assessment_name = $assessment_details[0]->ss_aw_assesment_topic;
	// 		if (!empty($parent_detail)) {
	// 			$email_template = getemailandpushnotification(4, 1, 1);
	// 			if (!empty($email_template)) {
	// 				$body = $email_template['body'];
	// 				$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
	// 				$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
	// 				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
	// 				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
	// 				emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
	// 			}

	// 			$app_template = getemailandpushnotification(4, 2, 1);
	// 			if (!empty($app_template)) {
	// 				$body = $app_template['body'];
	// 				$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
	// 				$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
	// 				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
	// 				$title = $app_template['title'];
	// 				$token = $parent_detail[0]->ss_aw_device_token;

	// 				$state_details = getchild_diagnosticexam_status($child_id);
											
	// 				$params = array(
	// 					'childId' => $child_id,
	// 					'childStateId' => $state_details['id'],
	// 					'childStateSubId' => $state_details['sub_id'],
	// 					'childNickName' => $child_name,
	// 				);

	// 				$extra_data = json_encode($params);

	// 				pushnotification($title,$body,$token,52,$extra_data);

	// 				$save_data = array(
	// 					'user_id' => $parent_detail[0]->ss_aw_parent_id,
	// 					'user_type' => 1,
	// 					'title' => $title,
	// 					'msg' => $body,
	// 					'status' => 1,
	// 					'read_unread' => 0,
	// 					'action' => 52,
	// 					'params' => $extra_data
	// 				);

	// 				save_notification($save_data);
	// 			}
	// 		}

	// 		$responseary['msg'] = "Send successfully.";
	// 	}
	// 	else{
	// 		$responseary['msg'] = "No exam details found.";
	// 	}

	// 	die(json_encode($responseary));
	// }

	public function invitation_to_enrol(){
		$child_id = $this->uri->segment(3);
		$diagnostic_exam_details = $this->testingapi_model->getexamcodedetailsbychild($child_id);
		$responseary = array();
		if (!empty($diagnostic_exam_details)) {
			$email_template = getemailandpushnotification(5, 1, 1);
			$app_template = getemailandpushnotification(5, 2, 1);
			$child_detail = $this->testingapi_model->getchilddetailsbyid($child_id);
			if (!empty($email_template)) {
				$body = $email_template['body'];
				$body = str_ireplace("[@@username@@]", $child_detail[0]->ss_aw_parent_full_name, $body);
				$body = str_ireplace("[@@child_name@@]", $child_detail[0]->ss_aw_child_nick_name, $body);
				emailnotification($child_detail[0]->ss_aw_parent_email, $email_template['title'], $body);	
			}

			//app notification
			if (!empty($app_template)) {
				$body = $app_template['body'];
				$body = str_ireplace("[@@child_name@@]", $child_detail[0]->ss_aw_child_nick_name, $body);
				$title = $app_template['title'];
				$token = $child_detail[0]->parent_device_token;

				if (!empty($token)) {
					pushnotification($title,$body,$token,63);	
				}

				$save_data = array(
					'user_id' => $child_detail[0]->ss_aw_child_id,
					'user_type' => 1,
					'title' => $title,
					'msg' => $body,
					'status' => 1,
					'read_unread' => 0,
					'action' => 63
				);

				save_notification($save_data);

			}

			$responseary['msg'] = "Send successfully.";
		}
		else{
			$responseary['msg'] = "Did not completed diagnostic exam";
		}

		die(json_encode($responseary));
	}

	public function invitation_to_begin_program(){
		$child_id = $this->uri->segment(3);
		$email_template = getemailandpushnotification(8, 1, 2);
		$app_template = getemailandpushnotification(8, 2, 2);

		$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

		if (!empty($email_template)) {
			$body = $email_template['body'];
			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
			emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
		}

		if (!empty($app_template)) {
			$body = $app_template['body'];
			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
			$title = $app_template['title'];
			$token = $child_details[0]->ss_aw_device_token;

			pushnotification($title,$body,$token,2);

			$save_data = array(
				'user_id' => $child_details[0]->ss_aw_child_id,
				'user_type' => 2,
				'title' => $title,
				'msg' => $body,
				'status' => 1,
				'read_unread' => 0,
				'action' => 2
			);

			save_notification($save_data);
		}

		$responseary['msg'] = "Send successfully.";
		die(json_encode($responseary));
	}

	public function lesson_completion_confirmation() {
		$child_id = $this->uri->segment(3);
		$lesson_id = $this->uri->segment(4);

		$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

		$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$child_name = $child_profile[0]->ss_aw_child_nick_name;

		$lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);

		$lesson_name = $lesson_detail[0]->ss_aw_lesson_topic;
		if (!empty($parent_detail)) {

			$email_template = getemailandpushnotification(10, 1, 1);
			if (!empty($email_template)) {
				
				$body = $email_template['body'];
				$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
				emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
			}

			$app_template = getemailandpushnotification(10, 2, 1);
			if (!empty($app_template)) {
				$body = $app_template['body'];
				$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
				$title = $app_template['title'];
				$token = $parent_detail[0]->ss_aw_device_token;

				pushnotification($title,$body,$token,54);

				$save_data = array(
					'user_id' => $parent_detail[0]->ss_aw_parent_id,
					'user_type' => 1,
					'title' => $title,
					'msg' => $body,
					'status' => 1,
					'read_unread' => 0,
					'action' => 54
				);

				save_notification($save_data);
			}
		}

					
		if (!empty($child_profile)) {
			$email_template = getemailandpushnotification(10, 1, 2);
			if (!empty($email_template)) {
				$body = $email_template['body'];
				$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
				$body = str_ireplace("[@@username@@]", $child_name, $body);
				emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
			}

			$app_template = getemailandpushnotification(10, 2, 2);
			if (!empty($app_template)) {
				$body = $app_template['body'];
				$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
				$body = str_ireplace("[@@username@@]", $child_name, $body);

				$title = $app_template['title'];
				$token = $child_profile[0]->ss_aw_device_token;

				//pushnotification($title,$body,$token,2);
				pushnotification($title,$body,$token);

				$save_data = array(
					'user_id' => $child_profile[0]->ss_aw_child_id,
					'user_type' => 2,
					'title' => $title,
					'msg' => $body,
					'status' => 1,
					'read_unread' => 0,
					'action' => 0
				);

				save_notification($save_data);

			}
		}

		$responseary['msg'] = "Send successfully.";
		die(json_encode($responseary));
	}

	public function assessment_quiz_reminder(){
		$child_id = $this->uri->segment(3);
		$email_template = getemailandpushnotification(11, 1, 2);
		$app_template = getemailandpushnotification(11, 2, 2);
		$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

		if (!empty($email_template)) {
			$body = $email_template['body'];
			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
			emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
		}

		if (!empty($app_template)) {
			$body = $app_template['body'];
			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
			$title = $app_template['title'];
			$token = $child_details[0]->ss_aw_device_token;

			pushnotification($title,$body,$token,3);

			$save_data = array(
				'user_id' => $child_details[0]->ss_aw_child_id,
				'user_type' => 2,
				'title' => $title,
				'msg' => $body,
				'status' => 1,
				'read_unread' => 0,
				'action' => 3
			);

			save_notification($save_data);
		}

		$responseary['msg'] = "Send successfully.";
		die(json_encode($responseary));
	}

	public function assessment_completion_confirmation() {
		$child_id = $this->uri->segment(3);
		$assessment_id = $this->uri->segment(4);
		$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
		//send notification code
		$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

		$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$child_name = $child_profile[0]->ss_aw_child_nick_name;

		$assessment_name = $assessment_details[0]->ss_aw_assesment_topic;
		if (!empty($parent_detail)) {

			$email_template = getemailandpushnotification(13, 1, 1);
			if (!empty($email_template)) {
				$body = $email_template['body'];
				$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
				emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body, 'sayan.sen@schemaphic.com');
			}

			$app_template = getemailandpushnotification(13, 2, 1);
			if (!empty($app_template)) {
				$body = $app_template['body'];
				$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
				$title = $app_template['title'];
				$token = $parent_detail[0]->ss_aw_device_token;

				pushnotification($title,$body,$token,57);

				$save_data = array(
					'user_id' => $parent_detail[0]->ss_aw_parent_id,
					'user_type' => 1,
					'title' => $title,
					'msg' => $body,
					'status' => 1,
					'read_unread' => 0,
					'action' => 57
				);

				save_notification($save_data);
			}
		}

		//child section
		if (!empty($child_profile)) {
			$email_template = getemailandpushnotification(13, 1, 2);
			if (!empty($email_template)) {
				$body = $email_template['body'];
				$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
				$body = str_ireplace("[@@username@@]", $child_name, $body);
				emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body, 'sayan.sen@schemaphic.com');
			}

			$app_template = getemailandpushnotification(13, 2, 2);
			if (!empty($app_template)) {
				$body = $app_template['body'];
				$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
				$body = str_ireplace("[@@username@@]", $child_name, $body);

				$title = $app_template['title'];
				$token = $child_profile[0]->ss_aw_device_token;

				pushnotification($title,$body,$token);

				$save_data = array(
					'user_id' => $child_profile[0]->ss_aw_child_id,
					'user_type' => 2,
					'title' => $title,
					'msg' => $body,
					'status' => 1,
					'read_unread' => 0,
					'action' => 0
				);

				save_notification($save_data);

			}
		}
	}

	public function send_test_msg(){
		$mobile_no = $this->uri->segment(3);
		$otp = rand(1000,9999);
		$result = send_sms($mobile_no, $otp);
		print_r($result);
		die();
	}

	public function clear_payment_history(){
		$child_id = $this->uri->segment(3);
		$this->ss_aw_child_course_model->deleterecord_child($child_id);
		$this->ss_aw_payment_details_model->deleterecord_child($child_id);
		$this->ss_aw_purchase_courses_model->deleterecord($child_id);

		//remove assessment multiple format record
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_assesment_multiple_question_answer');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_assesment_multiple_question_asked');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_assesment_questions_asked');

		$this->db->where('child_id', $child_id);
		$this->db->delete('ss_aw_assesment_reminder_notification');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_assessment_exam_completed');

		$this->db->where('ss_aw_log_child_id', $child_id);
		$this->db->delete('ss_aw_assessment_exam_log');

		$this->db->where('child_id', $child_id);
		$this->db->delete('ss_aw_assessment_score');

		//remove lesson record
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_child_last_lesson');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_current_lesson');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_lesson_assessment_score');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_lesson_assessment_total_score');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_lesson_quiz_ans');

		$this->db->where('child_id', $child_id);
		$this->db->delete('ss_aw_lesson_score');

		//remove readalong record
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_readalong_quiz_ans');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_schedule_readalong');

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_last_readalong');
		
		//remove promotion details
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete('ss_aw_promotion');
		
		$responseary = array(
			'msg' => 'Payment details removed succesfully'
		);

		die(json_encode($responseary));
	}

	public function display_lesson_assements(){
		$data = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$level = $postdata['level'];
			if ($level == 1) {
				$level_type = "E";
			}
			elseif ($level == 2) {
				$level_type = "C";
			}
			else{
				$level_type = "A";
			}
			$data['level'] = $level;
			$data['lesson_list'] = $this->ss_aw_lessons_uploaded_model->get_lessonlist_bylevel($level);
			$data['assessment_list'] = $this->ss_aw_assesment_uploaded_model->get_assessment_bylevel($level_type);
		}
		$this->load->view('admin/display-lesson-assessment', $data);
	}

	public function display_child_id(){
		$data = array();
		if ($this->input->post()) {
			$child_code = $this->input->post('child_code');
			$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
			$data['child_detail'] = $child_details;
			$data['child_code'] = $child_code;
		}
		$this->load->view('admin/display-child-id', $data);
	}

	public function complete_course(){
		$child_id = $this->uri->segment(3);
		$data = array(
			'ss_aw_course_status' => 2
		);
		$response = $this->ss_aw_child_course_model->updaterecord_child($child_id, $data);
		$responseary = array(
			'msg' => 'Course marked as finished successfully.'
		);
		die(json_encode($responseary));
	}

	public function get_parent_by_email(){
		$data = array();
		if ($this->input->post()) {
			$email = trim($this->input->post('email'));
			$this->db->where('ss_aw_parent_email', $email);
			$result = $this->db->get('ss_aw_parents')->result();
			$data['parent_detail'] = $result;
			$data['email'] = $email;
		}
		$this->load->view('admin/display-parent-id-by-email', $data);
	}

	public function clear_user(){
		$parent_id = $this->uri->segment(3);
		$childs = $this->ss_aw_childs_model->get_all_child_by_parent($parent_id);
		//remove reporting collection
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->delete('ss_aw_reporting_collection');
		//remove reporting revenue
		$this->db->where('ss_aw_parent_id', $parent_id);
		$this->db->delete('ss_aw_reporting_revenue');

		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				$this->ss_aw_child_course_model->deleterecord_child($child_id);
				$this->ss_aw_payment_details_model->deleterecord_child($child_id);
				$this->ss_aw_purchase_courses_model->deleterecord($child_id);

				//remove assessment multiple format record
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_assesment_multiple_question_answer');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_assesment_multiple_question_asked');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_assesment_questions_asked');

				$this->db->where('child_id', $child_id);
				$this->db->delete('ss_aw_assesment_reminder_notification');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_assessment_exam_completed');

				$this->db->where('ss_aw_log_child_id', $child_id);
				$this->db->delete('ss_aw_assessment_exam_log');

				$this->db->where('child_id', $child_id);
				$this->db->delete('ss_aw_assessment_score');

				//remove lesson record
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_child_last_lesson');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_current_lesson');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_lesson_assessment_score');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_lesson_assessment_total_score');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_lesson_quiz_ans');

				$this->db->where('child_id', $child_id);
				$this->db->delete('ss_aw_lesson_score');

				//remove readalong record
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_readalong_quiz_ans');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_schedule_readalong');

				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_last_readalong');

				//remove promotion details
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_promotion');

				//remove diagnostic exam details
				$this->db->where('ss_aw_diagonastic_log_child_id', $child_id);
				$this->db->delete('ss_aw_diagonastic_exam_log');

				$this->db->where('ss_aw_diagonastic_child_id', $child_id);
				$this->db->delete('ss_aw_diagonastic_exam');

				//remove child
				$this->db->where('ss_aw_child_id', $child_id);
				$this->db->delete('ss_aw_childs');
			}
		}

		//remove parent records
		//$this->db->where('ss_aw_parent_id', $parent_id);
		//$this->db->delete('ss_aw_parents');

		$responseary = array(
			'msg' => 'Parent record with their childs removed succesfully.'
		);

		die(json_encode($responseary));
	}

	public function update_assessment_weight(){
        $assessment_id = $this->uri->segment(3);
        if (!empty($assessment_id)) {
            $this->db->where('ss_aw_uploaded_record_id', $assessment_id);
            $this->db->order_by('ss_aw_id','asc');
            /*$this->db->where('ss_aw_status', 1);
            $this->db->where('ss_aw_deleted', 1);*/
            $result = $this->db->get('ss_aw_assisment_diagnostic')->result();
            if (!empty($result)) {
                $e_sq_no = 0;
                $c_sq_no = 0;
                $a_sq_no = 0;

                $e_count = 0;
                $c_count = 0;
                $a_count = 0;
                foreach ($result as $value) {
                    $level = $value->ss_aw_level;
                    if($level == 'E')
                    {
                        $e_count++;
                    }
                    if($level == 'C')
                    {
                        $c_count++;
                    }
                    if($level == 'A')
                    {
                        $a_count++;
                    }
                }

                foreach ($result as $key => $value) {
                    $level = $value->ss_aw_level;
                    if ($level == 'E') {
                        $e_sq_no = $e_sq_no + 1;
                    }

                    if ($level == 'C') {
                        $c_sq_no = $c_sq_no + 1;
                    }

                    if ($level == 'A') {
                        $a_sq_no = $a_sq_no + 1;
                    }

                    //calculate weight
                    if($level == 'E' && $e_count > 25)
                    {
                        $weight = ($e_sq_no * 0.01) + 1;
                    }else if($level == 'E' && $e_count > 17 && $e_count < 25)
                    {
                        $weight = ($e_sq_no * 0.02) + 1;
                    }
                    else if($level == 'E' && $e_count > 10 && $e_count < 17)
                    {
                        $weight = ($e_sq_no * 0.03) + 1;
                    }
                    else if($level == 'E' && $e_count <= 10)
                    {
                        $weight = ($e_sq_no * 0.04) + 1;
                    }
                    else if($level == 'E' && $e_count == 1)
                    {
                        $weight = 1;
                    }
                    
                    if($level == 'C' && $c_count > 25)
                    {
                        $weight = (1+($c_sq_no * (0.01)));
                        
                    }else if($level == 'C' && $c_count > 17 && $c_count < 25)
                    {
                        $weight = ($c_sq_no * 0.02) + 1;
                    }
                    else if($level == 'C' && $c_count > 10 && $c_count < 17)
                    {
                        $weight = ($c_sq_no * 0.03) + 1;
                    }
                    else if($level == 'C' && $c_count <= 10)
                    {
                        $weight = ($c_sq_no * 0.04) + 1;
                    }
                    else if($level == 'C' && $c_count == 1)
                    {
                        $weight = 1;
                    }
                    
                    if($level == 'A' && $a_count > 25)
                    {
                        $weight = (1+($a_sq_no * (0.01)));
                    }else if($level == 'A' && $a_count > 17 && $a_count < 25)
                    {
                        $weight = ($a_sq_no * 0.02) + 1;
                    }
                    else if($level == 'A' && $a_count > 10 && $a_count < 17)
                    {
                        $weight = ($a_sq_no * 0.03) + 1;
                    }
                    else if($level == 'A' && $a_count <= 10)
                    {
                        $weight = ($a_sq_no * 0.04) + 1;
                    }
                    else if($level == 'A' && $a_count == 1)
                    {
                        $weight = 1;
                    }

                    $this->db->where('ss_aw_id', $value->ss_aw_id);
                    $this->db->set('ss_aw_weight', $weight);
                    $this->db->update('ss_aw_assisment_diagnostic');

                }
            }
        }
    }

    public function movereadalongfiles(){
        $this->load->model('ss_aw_readalong_model');
        $this->load->model('ss_aw_readalong_quiz_model');
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $postdataAry = explode("@", $postdata['readalong_id']);
            $readalong_id = $postdataAry[0];
            $readalong_title = trim($postdataAry[1]);
            $readalong_title = str_replace(" ", "_", strtolower($readalong_title));
            //create directory
            $upload_path = "assets/audio/readalong/".$readalong_title;
            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            //end
            $readalong_data = $this->ss_aw_readalong_model->get_alldata_byrecordid($readalong_id);
            if (!empty($readalong_data)) {
                foreach ($readalong_data as $key => $value) {
                    if (!empty($value['ss_aw_readalong_audio'])) {
                        $pathAry = explode("/", $value['ss_aw_readalong_audio']);
                        $file_name = $pathAry[count($pathAry) - 1];
                        $destination_path = $upload_path."/".$file_name;
                        $moved = rename($value['ss_aw_readalong_audio'], $destination_path);
                        if ($moved) {
                            $update_file_path = array(
                                'ss_aw_readalong_audio' => $destination_path
                            );

                            $this->ss_aw_readalong_model->update_record($value['ss_aw_readalong_id'], $update_file_path);
                        }
                    }
                }
            }

            //move readalong quiz files
            $readalong_quizes = $this->ss_aw_readalong_quiz_model->get_record_by_upload_id($readalong_id);
            if (!empty($readalong_quizes)) {
                foreach ($readalong_quizes as $key => $value) {
                    if (!empty($value['ss_aw_quiz_type_audio'])) {
                        $pathAry = explode("/", $value['ss_aw_quiz_type_audio']);
                        $file_name = $pathAry[count($pathAry) - 1];
                        $destination_path = $upload_path."/".$file_name;
                        $moved = rename($value['ss_aw_quiz_type_audio'], $destination_path);
                        if ($moved) {
                            $update_file_path = array(
                                'ss_aw_quiz_type_audio' => $destination_path
                            );

                            $this->ss_aw_readalong_quiz_model->update_record_byid($value['ss_aw_readalong_id'], $update_file_path);
                        }
                    }

                    if (!empty($value['ss_aw_answers_audio'])) {
                        $pathAry = explode("/", $value['ss_aw_answers_audio']);
                        $file_name = $pathAry[count($pathAry) - 1];
                        $destination_path = $upload_path."/".$file_name;
                        $moved = rename($value['ss_aw_answers_audio'], $destination_path);
                        if ($moved) {
                            $update_file_path = array(
                                'ss_aw_answers_audio' => $destination_path
                            );

                            $this->ss_aw_readalong_quiz_model->update_record_byid($value['ss_aw_readalong_id'], $update_file_path);
                        }
                    }
                }
            }

            $this->session->set_flashdata('success','Files moved');
            redirect('testingapi/movereadalongfiles');
        }
        else{
            $this->load->view('movereadalongfiles');
        }
    }

    public function fetchreadalonglist(){
        $this->load->model('ss_aw_readalongs_upload_model');
        $course_code = $this->input->get('course_code');
        $searchary = array();
        $searchary['ss_aw_level'] = $course_code;
        $result = $this->ss_aw_readalongs_upload_model->fetch_by_params($searchary);
        echo json_encode($result);
    }

    public function service_call(){
    	try {
			$command = escapeshellcmd("python3 /var/www/vhosts/team.com/httpdocs/python_services/generatescorecard.py");
			shell_exec($command);	
		} catch (Exception $e) {
			echo 'Message: ' .$e->getMessage();
			die();
		}
    }

    public function make_assessment_confidence(){
    	$child_id = $this->uri->segment(3);
    	$assessment_id = $this->uri->segment(4);
    	$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
    	$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];
		if ($level_id == 1) {
			$level = "E";
		}
		elseif ($level_id == 2) {
			$level = "C";
		}
		elseif ($level_id == 3) {
			$level = "A";
		}

		$lesson_id = $assessment_details[0]->ss_aw_lesson_id;
		$assessment_topic_id = $assessment_details[0]->ss_aw_assesment_topic_id;
		//store confidence related records
		$lesson_quiz_skip = $this->ss_aw_lesson_quiz_ans_model->getlessonskipno($child_id, $lesson_id);
		$lesson_last_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_id, $child_id);
		$lesson_back_click_count = $lesson_last_details->ss_aw_back_click_count;
		$lesson_total_confidence = ($lesson_quiz_skip + $lesson_back_click_count) / 3;

		//get in level assessments data
		if (trim($assessment_details[0]->ss_aw_assesment_format) == 'Single') {
			$assessment_skip_no = $this->ss_aw_assessment_exam_log_model->getassessmentskipno($child_id, $level, $assessment_topic_id);
			$review_assessment_skip_no = $this->ss_aw_assessment_exam_log_model->getreviewassessmentskipno($child_id, $level, $assessment_topic_id);	
		}
		else{
			$assessment_skip_no = $this->ss_aw_assesment_multiple_question_answer_model->getassessmentskipno($child_id, $level_id, $assessment_id);
			$review_assessment_skip_no = $this->ss_aw_assesment_multiple_question_answer_model->getreviewassessmentskipno($child_id, $level_id, $assessment_id);
		}
					

		$combine_total = $lesson_total_confidence + $assessment_skip_no + $review_assessment_skip_no;
					$data = array(
						'ss_aw_child_id' => $child_id,
						'ss_aw_level' => $level,
						'ss_aw_lesson_topic' => $assessment_details[0]->ss_aw_assesment_topic,
						'ss_aw_lesson_skip' => $lesson_quiz_skip,
						'ss_aw_lesson_back_click' => $lesson_back_click_count,
						'ss_aw_lesson_total' => $lesson_total_confidence,
						'ss_aw_assessment_skip' => $assessment_skip_no,
						'ss_aw_review_skip' => $review_assessment_skip_no,
						'ss_aw_combine_score' => $combine_total
					);

					$this->store_procedure_model->store_lesson_assessment_confidence($data);
					//need to insert review answer timing

					//get review assessment answer timing details
					$multiple_choice_time = $this->store_procedure_model->getassessmentanswertiming($assessment_topic_id, 2);
					$multiple_choice_answer_begin_time = 0;
					if (!empty($multiple_choice_time)) {
						$multiple_choice_answer_begin_time = $multiple_choice_time[0]->begin_to_answer;
					}
					$short_answer_time = $this->store_procedure_model->getassessmentanswertiming($assessment_topic_id, 1);
					$short_answer_begin_time = 0;
					if (!empty($short_answer_time)) {
						$short_answer_begin_time = $short_answer_time[0]->begin_to_answer;
					}
					$rewrite_sentence_time = $this->store_procedure_model->getassessmentanswertiming($assessment_topic_id, 3);
					$rewrite_sentence_answer_begin_time = 0;
					if (!empty($rewrite_sentence_time)) {
						$rewrite_sentence_answer_begin_time = $rewrite_sentence_time[0]->begin_to_answer;
					}

					//get assessment answer timing details
					$multiple_choice_assessment_time = $this->store_procedure_model->getassessmentformatoneanswertiming($assessment_topic_id, 2);
					$multiple_choice_assessment_answer_begin_time = 0;
					if (!empty($multiple_choice_assessment_time)) {
						$multiple_choice_assessment_answer_begin_time = $multiple_choice_assessment_time[0]->begin_to_answer;
					}
					$short_answer_assessment_time = $this->store_procedure_model->getassessmentformatoneanswertiming($assessment_topic_id, 1);
					$short_answer_assessment_answer_begin_time = 0;
					if (!empty($short_answer_assessment_time)) {
						$short_answer_assessment_answer_begin_time = $short_answer_assessment_time[0]->begin_to_answer;
					}
					$rewrite_sentence_assessment_time = $this->store_procedure_model->getassessmentformatoneanswertiming($assessment_topic_id, 3);
					$rewrite_sentence_assessment_answer_begin_time = 0;
					if (!empty($rewrite_sentence_assessment_time)) {
						$rewrite_sentence_assessment_answer_begin_time = $rewrite_sentence_assessment_time[0]->begin_to_answer;
					}

					$total_multiple_choice_time = $multiple_choice_answer_begin_time + $multiple_choice_assessment_answer_begin_time;
					$total_short_answer_time = $short_answer_begin_time + $short_answer_assessment_answer_begin_time;
					$total_rewrite_sentence_time = $rewrite_sentence_answer_begin_time + $rewrite_sentence_assessment_answer_begin_time;

					$total_taking_time = $total_multiple_choice_time + $total_short_answer_time + $total_rewrite_sentence_time;
					$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(3);
					$total_test_time = $timesetting[0]->ss_aw_test_timing_value;

					$all_question_average = round(($total_taking_time / $total_test_time), 2);

					$second_data = array(
						'ss_aw_child_id' => $child_id,
						'ss_aw_level' => $level,
						'ss_aw_topic_name' => $assessment_details[0]->ss_aw_assesment_topic,
						'ss_aw_multiple_choice' => $total_multiple_choice_time,
						'ss_aw_short_answer' => $total_short_answer_time,
						'ss_aw_complete_sentence' => $total_rewrite_sentence_time,
						'ss_aw_all_question' => $all_question_average
					);

					$this->store_procedure_model->store_assessment_review_answer_timing($second_data);
    }

	//end code

	public function fill_multiple_assessment_asked_table(){
    	$result = $this->db->get('ss_aw_assesment_multiple_question_asked')->result();
    	if (!empty($result)) {
    		foreach ($result as $key => $value) {
    			$assessment_id = $value->ss_aw_assessment_id;
    			$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
    			$topic_name = $assessment_details[0]->ss_aw_assesment_topic;

    			//update table by topic name
    			$this->db->where('ss_aw_id', $value->ss_aw_id);
    			$this->db->set('ss_aw_assessment_topic', $topic_name);
    			$this->db->update('ss_aw_assesment_multiple_question_asked');	
    		}
    	}
    }

    public function fill_assessment_exam_complete_table(){
    	$result = $this->db->get('ss_aw_assessment_exam_completed')->result();
    	if (!empty($result)) {
    		foreach ($result as $key => $value) {
    			$assessment_id = $value->ss_aw_assessment_id;
    			$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
    			$topic_name = $assessment_details[0]->ss_aw_assesment_topic;

    			//update table by topic name
    			$this->db->where('ss_aw_id', $value->ss_aw_id);
    			$this->db->set('ss_aw_assessment_topic', $topic_name);
    			$this->db->update('ss_aw_assessment_exam_completed');	
    		}
    	}
    }

    public function fill_assessment_score_table(){
    	$result = $this->db->get('ss_aw_assessment_score')->result();
    	if (!empty($result)) {
    		foreach ($result as $key => $value) {
    			$assessment_id = $value->assessment_id;
    			$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
    			$topic_name = $assessment_details[0]->ss_aw_assesment_topic;

    			//update table by topic name
    			$this->db->where('id', $value->id);
    			$this->db->set('assessment_topic', $topic_name);
    			$this->db->update('ss_aw_assessment_score');	
    		}
    	}
    }

    public function send_test_mail(){
    	try {
    		$res = emailnotification('sayan.sen@schemaphic.com', 'Disputes', 'Test Message');
    		print_r($res);
    	} catch (Exception $e) {
    		echo 'Message: ' .$e->getMessage();
    		die();
    	}	
    }

    public function fill_child_username(){
    	$childs = $this->testingapi_model->getnullableusernamechilds();
    	if (!empty($childs)) {
    		foreach ($childs as $key => $value) {
    			{
    				$childnickname = strtolower(trim($value->ss_aw_child_nick_name));
	    			$childusername = str_replace(" ", "", $childnickname);
	    			$childusername = $childusername.date('Y', strtotime($value->ss_aw_child_dob));
	    			$update_data_ary = array(
	    				'ss_aw_child_username' => $childusername
	    			);
	    			$this->ss_aw_childs_model->update_child_details($update_data_ary, $value->ss_aw_child_id);	
    			}
    		}
    	}
    }

    public function active_parent_email_verification(){
    	$parents = $this->testingapi_model->getnotverifiedparents();
    	if (!empty($parents)) {
    		foreach ($parents as $key => $value) {
    			$update_data_ary = array(
    				'ss_aw_is_email_verified' => 1
    			);
    			$this->ss_aw_parents_model->update_parent_details($update_data_ary, $value->ss_aw_parent_id);
    		}
    	}
    }

    public function change_parent_user_type(){
    	$parents = $this->testingapi_model->getzerochildparents();
    	if (!empty($parents)) {
    		foreach ($parents as $key => $value) {
    			{
    				$update_data_ary = array(
	    				'ss_aw_user_type' => 1
	    			);
	    			$this->ss_aw_parents_model->update_parent_details($update_data_ary, $value->ss_aw_parent_id);
    			}
    		}
    	}
    }

    public function update_questionid_of_lesson_quiz(){
    	//$child_id = $this->uri->segment(3);
    	$this->db->where('ss_aw_child_id', 20);
    	$result = $this->db->get('ss_aw_lesson_quiz_ans')->result();
    	if (!empty($result)) {
    		foreach ($result as $key => $value) {
    			$question = $value->ss_aw_question;
    			$this->db->where('ss_aw_lesson_details', $question);
    			$this->db->where('ss_aw_lesson_record_id', $value->ss_aw_lesson_id);
    			$this->db->where('ss_aw_course_id', 2);
    			$question_details = $this->db->get('ss_aw_lessons')->row();
    			if (!empty($question_details)) {
    				$question_id = $question_details->ss_aw_lession_id;
	    			//update question id
	    			$this->db->where('ss_aw_id', $value->ss_aw_id);
	    			$this->db->set('ss_aw_question_id', $question_id);
	    			$this->db->update('ss_aw_lesson_quiz_ans');
	    			//end	
    			}
    		}
    	}
    }

    public function number_to_word(){
    	echo AmountInWords(526.55);
    }
}

function generateRandomString($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomMobileNumber($length) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}