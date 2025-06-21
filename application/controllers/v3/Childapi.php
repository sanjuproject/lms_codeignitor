<?php

set_time_limit(320);
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

class Childapi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('ss_aw_error_code_model');
		$this->load->model('ss_aw_childs_model');
		$this->load->helper('custom_helper');
		$this->load->model('ss_aw_sections_topics_model');
		$this->load->model('ss_aw_assisment_diagnostic_model');
		$this->load->model('ss_aw_diagnonstic_questions_asked_model');
		$this->load->model('ss_aw_diagonastic_exam_log_model');
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_diagonastic_exam_model');
		$this->load->model('ss_aw_test_timing_model');
		$this->load->model('ss_aw_assessment_subsection_matrix_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_assessment_exam_log_model');
		$this->load->model('ss_aw_lessons_model');
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_child_course_model');
		$this->load->model('ss_aw_purchase_courses_model');
		$this->load->model('ss_aw_general_settings_model');
		$this->load->model('ss_aw_current_lesson_model');
		$this->load->model('ss_aw_schedule_readalong_model');
		$this->load->model('ss_aw_lesson_quiz_ans_model');
		$this->load->model('ss_aw_readalongs_upload_model');
		$this->load->model('ss_aw_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_supplymentary_uploaded_model');
		$this->load->model('ss_aw_supplymentary_model');
		$this->load->model('ss_aw_readalong_quiz_ans_model');
		$this->load->model('ss_aw_last_readalong_model');
		$this->load->model('ss_aw_purchased_supplymentary_course_model');
		$this->load->model('ss_aw_supplymentary_exam_model');
		$this->load->model('ss_aw_supplymentary_exam_finish_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_assesment_multiple_question_answer_model');
		$this->load->model('ss_aw_vocabulary_model');
		$this->load->model('ss_aw_readalong_restriction_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_sections_subtopics_model');
		$this->load->model('ss_aw_notification_model');
		$this->load->model('ss_aw_promotion_model');
		$this->load->model('store_procedure_model');
		$this->load->model('ss_aw_store_readalong_page_model');
		$this->load->model('ss_aw_email_que_model');
		$this->load->model('ss_aw_parents_model');
		$this->load->model('ss_aw_course_completion_model');
		$this->load->model('ss_aw_course_count_model');

		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		if (!$foo = $this->cache->get('idletime')) {
			$searchary = array();
			$test_timeary = $this->ss_aw_test_timing_model->search_byparam($searchary);
			if ($test_timeary[0]['ss_aw_test_timing_fieldname'] == 'Question Idle Time') {
				$idletime = $test_timeary[0]['ss_aw_test_timing_value'];
				$this->cache->file->save('idletime', $idletime, 10);
			}
		}
	}

	public function update_details()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		$profile_pic = "";
		if ($inputpost) {
			$child_id = $inputpost['user_id'];
			$child_token = $inputpost['user_token'];
			if ($this->check_child_existance($child_id, $child_token)) {
				$updateary = array();

				if (isset($_FILES["profile_pic"]['name'])) {
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['encrypt_name'] = TRUE;
					// $config['max_size']             = 100;
					// $config['max_width']            = 1024;
					// $config['max_height']           = 768;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('profile_pic')) {
						//echo "not success";
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
					}
					$data = $this->upload->data();
					$profile_pic = $data['file_name'];
					$updateary['ss_aw_child_profile_pic'] = $profile_pic;
				}
				if (isset($inputpost['child_nick_name'])) {
					$updateary['ss_aw_child_nick_name'] = $inputpost['child_nick_name'];
				}
				$updateary['ss_aw_child_modified_date'] = date('Y-m-d H:i:s');

				$result = $this->ss_aw_childs_model->update_child_details($updateary, $child_id);
				if ($result) {
					$responseary['status'] = 200;
					$responseary['user_id'] = $child_id;
					$responseary['msg'] = 'Update successfully done';
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1017');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function logout()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id'];

			$result = $this->ss_aw_childs_model->logout($child_id);
			if ($result) {
				$responseary['status'] = 200;
				$responseary['msg'] = "Logout Successful";
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1014');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	public function get_profile_details()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id'];
			$child_token = $inputpost['user_token'];
			$result = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
			if (!empty($result)) {
				$responseary['status'] = 200;
				$responseary['msg'] = "Data Found";
				foreach ($result as $value) {
					$responseary['user_id'] = $value->ss_aw_child_id;
					$responseary['child_code'] = $value->ss_aw_child_code;
					$responseary['parent_id'] = $value->ss_aw_parent_id;
					$responseary['nick_name'] = $value->ss_aw_child_nick_name;
					$responseary['first_name'] = $value->ss_aw_child_first_name;
					$responseary['last_name'] = $value->ss_aw_child_last_name;

					if (!empty($value->ss_aw_child_profile_pic))
						$responseary['photo'] = base_url() . "uploads/" . $value->ss_aw_child_profile_pic;
					else
						$responseary['photo'] = base_url() . "uploads/profile.jpg";

					$responseary['child_schoolname'] = $value->ss_aw_child_schoolname;
					$responseary['child_gender'] = $value->ss_aw_child_gender;
					$responseary['dob'] = $value->ss_aw_child_dob;
					$responseary['email'] = $value->ss_aw_child_email;
					$responseary['primary_mobile'] = $value->ss_aw_child_mobile;
					$responseary['country_sort_name'] = $value->ss_aw_child_country_sort_name;
					$responseary['country_code'] = $value->ss_aw_child_country_code;
					$responseary['user_token'] = $child_token;
					$responseary['child_created_date'] = $value->ss_aw_child_created_date;
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
		}
		echo json_encode($responseary);
		die();
	}

	function random_strings($length_of_string)
	{

		// random_bytes returns number of bytes 
		// bin2hex converts them into hexadecimal format 
		return substr(md5(time()), 0, $length_of_string);
	}

	public function check_child_existance($child_id, $child_token)
	{
		if ($child_id == 32 || $child_id == 28) {
			return 1;
		} else {
			$response = $this->ss_aw_childs_model->check_child_existance_with_token($child_id, $child_token);
			if ($response) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	/*
      Generate first set Diagnostic question bese on child Age
      The students, whose age in between 10 and 12 years, will be considered
      as Emerging (E) on start of the diagnostic tests.
      Students whose age is 13+ will be considered as Consolidating (C) at start of the test.
      No students will be ever marked as Advanced (A) on start of the diagnostic test.
     */

	public function diagnostic_test_question_first_set()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		$categorysetcountno = 15;
		$categoryallowcount = 10;

		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				//check diagnostic exam given or not
				$diagnostic_complete_check = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
				if (!empty($diagnostic_complete_check)) {
					$responseary['status'] = 1025;
					$responseary['msg'] = "You have already completed diagnostic";
					$this->ss_aw_childs_model->logout($child_id);
					die(json_encode($responseary));
				}

				//check diagnostic attempt number
				$diagnostic_exam_attempt_details = $this->ss_aw_diagnonstic_questions_asked_model->get_diagnostic_exam_attempt_details($child_id);
				if ($diagnostic_exam_attempt_details->total_attempt > 2) {
					$last_diagnostic_exam_code = $diagnostic_exam_attempt_details->ss_aw_diagonastic_exam_code;
					$exam_complete_data = array();
					$exam_complete_data['ss_aw_diagonastic_child_id'] = $child_id;
					$exam_complete_data['ss_aw_diagonastic_exam_code'] = $last_diagnostic_exam_code;
					$this->ss_aw_diagonastic_exam_model->insert_record($exam_complete_data);

					$total_marks = 20;
					$obtain_marks = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($last_diagnostic_exam_code);
					//send notification code
					$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

					$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
					$child_name = $child_profile[0]->ss_aw_child_nick_name;
					$child_gender = $child_profile[0]->ss_aw_child_gender;
					$child_age = calculate_age($child_profile[0]->ss_aw_child_dob);

					if (!empty($child_profile[0]->ss_aw_child_username)) {
						$email_template = getemailandpushnotification(30, 1, 1);
						$app_template = getemailandpushnotification(30, 2, 1);
						$action_id = 5;

						$month_date = date('d/m/Y');
						$gender = "";
						if ($child_gender == 1) {
							$gender = "him";
						} else {
							$gender = "her";
						}
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
							if ($child_age >= 13) {
								$body = str_ireplace("[@@child_emerging_promotion@@]", "If your child performs well in the first 6 weeks of the program, we will seek your permission to promote them to the Consolidating Program.", $body);
							} else {
								$body = str_ireplace("[@@child_emerging_promotion@@]", "", $body);
							}

							$send_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
						}

						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
							$title = $app_template['title'];
							$token = $parent_detail[0]->ss_aw_device_token;

							$state_details = getchild_diagnosticexam_status($child_id);

							$params = array(
								'childId' => $child_id,
								'childStateId' => $state_details['id'],
								'childStateSubId' => $state_details['sub_id'],
								'childNickName' => $child_name,
							);

							$extra_data = json_encode($params);

							pushnotification($title, $body, $token, $action_id, $extra_data);

							$save_data = array(
								'user_id' => $parent_detail[0]->ss_aw_parent_id,
								'user_type' => 1,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => $action_id,
								'params' => $extra_data
							);

							save_notification($save_data);
						}
					} else {
						$email_template = getemailandpushnotification(58, 1, 2);
						$action_id = 5;
						$month_date = date('d/m/Y');

						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);

							$send_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
						}
					}

					$responseary['status'] = 1025;
					$responseary['msg'] = "Maximum attempts exceeded";
					$this->ss_aw_childs_model->logout($child_id);
					die(json_encode($responseary));
					//end of diagnostic completetion code	
				}
				$diagnostic_exam_code = time() . "_" . $child_id; // Format : time()_<child_id> This code USe to identify ever diagnostic exam uniquely
				$childdetailsary = array();
				$childdetailsary = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
				$child_age = calculate_age($childdetailsary[0]->ss_aw_child_dob);
				$child_level = "";
				if (!empty($childdetailsary[0]->ss_aw_child_username)) {
					if ($child_age < 13) { // Check Child age betweeen 10 and 13 years
						$child_level = "E";
					} else if ($child_age >= 13) { // Check child age 13+
						$child_level = "C";
					}
				} else {
					$child_level = "C";
				}

				$topic_listary = array();
				$sequencenoary = array();
				if (!empty($childdetailsary[0]->ss_aw_child_username)) {
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(10, 0);
				} else {
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(20, 0);
				}

				$categorysetcountno = count($topic_listary);
				$sequencenoaryids = array();
				foreach ($topic_listary as $key => $val) {
					$check_validate = $this->ss_aw_assisment_diagnostic_model->checkbycategory($val->ss_aw_section_title, $child_level);
					if ($check_validate > 0) {
						if ($key < $categorysetcountno) {
							$sequencenoaryids[] = $val->ss_aw_section_id;
							$sequencenoary[$val->ss_aw_section_id] = $val->ss_aw_section_title;
						}
					}
				}

				shuffle($sequencenoaryids);

				$randomtopic = array();
				$randomtopic = array_slice($sequencenoaryids, 0, $categoryallowcount);

				/*
                  Create a array of Topic names from where the questions are asked.1 from each topic/category
                 */
				$finalquestionary = array();
				/* Get Idle time for a question */
				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

				$i = 0;
				$asked_question_ids = "";
				$asked_category_ids = "";
				foreach ($randomtopic as $key => $val) {
					//$randomtopic[$key] = $sequencenoary[$val];
					$response = $this->ss_aw_assisment_diagnostic_model->fetch_question_bycategory($sequencenoary[$val], $child_level);

					$finalquestionary[$i]['question_id'] = $response[0]['ss_aw_id'];
					$finalquestionary[$i]['level'] = $response[0]['ss_aw_level'];
					$finalquestionary[$i]['format'] = $response[0]['ss_aw_format'];

					if ($response[0]['ss_aw_format'] == 'Single')
						$finalquestionary[$i]['format_id'] = 1;
					else
						$finalquestionary[$i]['format_id'] = 2;

					$finalquestionary[$i]['seq_no'] = $response[0]['ss_aw_seq_no'];
					$finalquestionary[$i]['weight'] = $response[0]['ss_aw_weight'];
					$finalquestionary[$i]['category'] = $response[0]['ss_aw_category'];
					$finalquestionary[$i]['sub_category'] = $response[0]['ss_aw_sub_category'];
					$finalquestionary[$i]['question_format'] = $response[0]['ss_aw_question_format'];

					if ($response[0]['ss_aw_question_format'] == 'Choose the right answer')
						$finalquestionary[$i]['question_format_id'] = 2;
					else if ($response[0]['ss_aw_question_format'] == 'Fill in the blanks')
						$finalquestionary[$i]['question_format_id'] = 1;
					else if ($response[0]['ss_aw_question_format'] == 'Rewrite the sentence')
						$finalquestionary[$i]['question_format_id'] = 3;


					$finalquestionary[$i]['prefaceaudio'] = base_url() . $response[0]['ss_aw_question_preface_audio'];
					$finalquestionary[$i]['preface'] = $response[0]['ss_aw_question_preface'];
					$finalquestionary[$i]['question'] = trim($response[0]['ss_aw_question']);

					$multiple_choice_ary = array();
					$multiple_choice_ary = explode("/", $response[0]['ss_aw_multiple_choice']);

					if (count($multiple_choice_ary) > 1)
						$finalquestionary[$i]['options'] = $multiple_choice_ary;
					else
						$finalquestionary[$i]['options'][0] = $response[0]['ss_aw_multiple_choice'];


					$finalquestionary[$i]['verb_form'] = $response[0]['ss_aw_verb_form'];

					$answersary = array();
					$answersary = explode("/", trim($response[0]['ss_aw_answers']));
					if (count($answersary) > 1) {
						$answersary = array_map('trim', $answersary);
						$finalquestionary[$i]['answers'] = $answersary;
					} else {
						$finalquestionary[$i]['answers'][0] = trim($response[0]['ss_aw_answers']);
					}
					$finalquestionary[$i]['answeraudio'] = base_url() . $response[0]['ss_aw_answers_audio'];

					$finalquestionary[$i]['rules'] = trim($response[0]['ss_aw_rules']);

					$finalquestionary[$i]['hint'] = "";
					$finalquestionary[$i]['ruleaudio'] = base_url() . $response[0]['ss_aw_rules_audio'];

					$i++;
					$asked_question_ids .= $response[0]['ss_aw_id'] . ",";
					$asked_category_ids .= $val . ",";
				}

				$insertary = array();
				$insertary['ss_aw_child_id'] = $child_id;
				$insertary['ss_aw_question_set'] = 1;
				$insertary['ss_aw_diagnostic_id'] = $asked_question_ids;
				$insertary['ss_aw_asked_category_id'] = $asked_category_ids;
				$insertary['ss_aw_diagonastic_exam_code'] = $diagnostic_exam_code;
				$this->ss_aw_diagnonstic_questions_asked_model->insert_record($insertary);

				$responseary['status'] = 200;

				$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
				$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
				$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
				$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
				$responseary['skip_duration'] = $idletime;
				$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
				$responseary['skip_type_1_2_duration'] = $idletime;
				$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
				$responseary['data'] = $finalquestionary;
				$responseary['diagonastic_exam_code'] = $diagnostic_exam_code;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	public function UniqueRandomNumbersWithinRange($min, $max, $quantity)
	{
		$numbers = range($min, $max);
		shuffle($numbers);
		return array_slice($numbers, 0, $quantity);
	}

	/*
      Based on the number of correct answers from this list of 10 questions, the next set of questions will be prepared.
     */

	public function diagnostic_test_question_second_set()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();

		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$diagonastic_exam_code = $inputpost['diagonastic_exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childdetailsary = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
				$child_age = calculate_age($childdetailsary[0]->ss_aw_child_dob);

				$topic_listary = array();
				$sequencenoary = array();

				$paramary = array();

				$paramary['ss_aw_child_id'] = $child_id;
				$paramary['ss_aw_diagonastic_exam_code'] = $diagonastic_exam_code;
				$oldquestionsdataary = array();
				$oldquestionsdataary = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam($paramary);

				$oldquestionlist = "";
				foreach ($oldquestionsdataary as $val) {
					$oldquestionlist .= $val['ss_aw_diagnostic_id'];
				}

				$oldquestionslistary = array();
				$oldquestionslistary = explode(",", ($oldquestionlist));
				$oldquestionslistary = array_filter($oldquestionslistary);

				if (!empty($childdetailsary[0]->ss_aw_child_username)) {
					if (count($oldquestionslistary) < 15) {
						$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(5, 10);
						$child_level = 'C';
					} else {
						if ($child_age < 13) {
							$child_level = 'E';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(10, 0);
						} else {
							$child_level = 'C';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(5, 10);
						}
					}
				} else {
					if (count($oldquestionslistary) < 15) {
						$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(5, 15);
						$child_level = 'A';
					} else {
						$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(5, 20);
						$child_level = 'A';
					}
				}


				$sequencenoaryids = array();
				foreach ($topic_listary as $key => $val) {
					$sequencenoaryids[] = $val->ss_aw_section_id;
					$sequencenoary[$val->ss_aw_section_id] = $val->ss_aw_section_title;
				}

				shuffle($sequencenoaryids);
				$categoryallowcount = 5;
				$randomtopic = array();
				$randomtopic = array_slice($sequencenoaryids, 0, $categoryallowcount);

				/*
                  Create a array of Topic names from where the questions are asked.1 from each topic/category
                 */
				$finalquestionary = array();
				/* Get Idle time for a question */
				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

				$i = 0;
				$asked_question_ids = "";
				$asked_category_ids = "";

				foreach ($randomtopic as $key => $val) {
					//$randomtopic[$key] = $sequencenoary[$val];
					$response = $this->ss_aw_assisment_diagnostic_model->getdiagnosticuniquequestion($sequencenoary[$val], $child_level, $oldquestionslistary);

					$finalquestionary[$i]['question_id'] = $response[0]['ss_aw_id'];
					$finalquestionary[$i]['level'] = $response[0]['ss_aw_level'];
					$finalquestionary[$i]['format'] = $response[0]['ss_aw_format'];

					if ($response[0]['ss_aw_format'] == 'Single')
						$finalquestionary[$i]['format_id'] = 1;
					else
						$finalquestionary[$i]['format_id'] = 2;

					$finalquestionary[$i]['seq_no'] = $response[0]['ss_aw_seq_no'];
					$finalquestionary[$i]['weight'] = $response[0]['ss_aw_weight'];
					$finalquestionary[$i]['category'] = $response[0]['ss_aw_category'];
					$finalquestionary[$i]['sub_category'] = $response[0]['ss_aw_sub_category'];
					$finalquestionary[$i]['question_format'] = $response[0]['ss_aw_question_format'];

					if ($response[0]['ss_aw_question_format'] == 'Choose the right answer')
						$finalquestionary[$i]['question_format_id'] = 2;
					else if ($response[0]['ss_aw_question_format'] == 'Fill in the blanks')
						$finalquestionary[$i]['question_format_id'] = 1;
					else if ($response[0]['ss_aw_question_format'] == 'Rewrite the sentence')
						$finalquestionary[$i]['question_format_id'] = 3;


					$finalquestionary[$i]['prefaceaudio'] = base_url() . $response[0]['ss_aw_question_preface_audio'];
					$finalquestionary[$i]['preface'] = $response[0]['ss_aw_question_preface'];
					$finalquestionary[$i]['question'] = trim($response[0]['ss_aw_question']);

					$multiple_choice_ary = array();
					$multiple_choice_ary = explode("/", $response[0]['ss_aw_multiple_choice']);

					if (count($multiple_choice_ary) > 1)
						$finalquestionary[$i]['options'] = $multiple_choice_ary;
					else
						$finalquestionary[$i]['options'][0] = $response[0]['ss_aw_multiple_choice'];


					$finalquestionary[$i]['verb_form'] = $response[0]['ss_aw_verb_form'];

					$answersary = array();
					$answersary = explode("/", trim($response[0]['ss_aw_answers']));
					if (count($answersary) > 1) {
						$answersary = array_map('trim', $answersary);
						$finalquestionary[$i]['answers'] = $answersary;
					} else {
						$finalquestionary[$i]['answers'][0] = trim($response[0]['ss_aw_answers']);
					}
					$finalquestionary[$i]['answeraudio'] = base_url() . $response[0]['ss_aw_answers_audio'];

					$finalquestionary[$i]['rules'] = trim($response[0]['ss_aw_rules']);

					$finalquestionary[$i]['hint'] = "";
					$finalquestionary[$i]['ruleaudio'] = base_url() . $response[0]['ss_aw_rules_audio'];

					$i++;
					$asked_question_ids .= $response[0]['ss_aw_id'] . ",";
					$asked_category_ids .= $val . ",";
				}

				$insertary = array();
				$insertary['ss_aw_child_id'] = $child_id;
				$insertary['ss_aw_question_set'] = 2;
				$insertary['ss_aw_diagnostic_id'] = $asked_question_ids;
				$insertary['ss_aw_asked_category_id'] = $asked_category_ids;
				$insertary['ss_aw_diagonastic_exam_code'] = $diagonastic_exam_code;
				$this->ss_aw_diagnonstic_questions_asked_model->insert_record($insertary);

				$responseary['status'] = 200;

				$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
				$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
				$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
				$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
				$responseary['skip_duration'] = $idletime;
				$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
				$responseary['skip_type_1_2_duration'] = $idletime;
				$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
				$responseary['data'] = $finalquestionary;
				$responseary['diagonastic_exam_code'] = $diagonastic_exam_code;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	public function updatelevel($child_id, $level, $category_count, $question_no, $student_level, $diagonastic_exam_code, $correct_ans = "", $total_ans = "")
	{
		$responseary = array();
		$categorysetcountno = $category_count; // Search From no of Category
		$categoryallowcount = $question_no; // Total Asked Question
		$child_level = $level;
		$topic_listary = array();
		$sequencenoary = array();
		/*
          Create a array of Topic names from where the questions are asked.1 from each topic/category
         */
		$paramary = array();

		$paramary['ss_aw_child_id'] = $child_id;
		$paramary['ss_aw_diagonastic_exam_code'] = $diagonastic_exam_code;
		$oldquestionsdataary = array();
		//if($student_level != 4)
		{
			$oldquestionsdataary = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam($paramary);

			$oldcatgorylist = "";
			$oldquestionlist = "";
			foreach ($oldquestionsdataary as $val) {
				$oldcatgorylist .= $val['ss_aw_asked_category_id'];
				$oldquestionlist .= $val['ss_aw_diagnostic_id'];
			}
			$oldcategorydataary = explode(",", ($oldcatgorylist));
			$oldcategorydataary = array_values(array_filter(array_unique($oldcategorydataary)));

			//$oldquestionsdataary = explode(",",($oldquestionsdataary[0]['ss_aw_diagnostic_id']));
			$oldquestionslistary = array();
			$oldquestionslistary = explode(",", ($oldquestionlist));
			$oldquestionslistary = array_filter($oldquestionslistary);
		}

		//print_r($oldquestionslistary);
		$topic_listary = $this->ss_aw_sections_topics_model->get_topiclist_bylevel($child_level); // Get All Topic List against LEVEL

		foreach ($topic_listary as $key => $val) {
			$check_validate = $this->ss_aw_assisment_diagnostic_model->checkbycategory($val['ss_aw_section_title'], $child_level);
			if ($check_validate > 0) {
				if ($key < $categorysetcountno) {
					if (!empty($total_ans)) {
						if ($child_level == 'C' && ($correct_ans < 8 && $total_ans < 15)) {
							if (!in_array($val['ss_aw_section_id'], $oldcategorydataary)) {
								$sequencenoaryids[] = $val['ss_aw_section_id'];
								$sequencenoary[$val['ss_aw_section_id']] = $val['ss_aw_section_title'];
							}
						} else {
							$sequencenoaryids[] = $val['ss_aw_section_id'];
							$sequencenoary[$val['ss_aw_section_id']] = $val['ss_aw_section_title'];
						}
					} else {
						$sequencenoaryids[] = $val['ss_aw_section_id'];
						$sequencenoary[$val['ss_aw_section_id']] = $val['ss_aw_section_title'];
					}
				}
			}
		}


		shuffle($sequencenoaryids);

		$randomtopic = array();
		$randomtopic = array_slice($sequencenoaryids, 0, $categoryallowcount);

		$finalquestionary = array();
		$i = 0;
		$asked_question_ids = "";
		$asked_category_ids = "";

		$topicary = $this->ss_aw_sections_topics_model->fetchall();

		$question_ids = "";

		foreach ($randomtopic as $key => $val) {
			//$response = $this->ss_aw_assisment_diagnostic_model->fetch_question_bycategory($val,$child_level);		
			$response = $this->ss_aw_assisment_diagnostic_model->getdiagnosticuniquequestion($sequencenoary[$val], $child_level, $oldquestionslistary);

			if (!empty($response)) {
				//$question_id = $this->check_question_exist($response[0]['ss_aw_id'],$oldquestionslistary,$sequencenoary[$val],$child_level);
				$question_id = $response[0]['ss_aw_id'];
				$question_ids .= "," . $question_id;
				foreach ($topicary as $value) {
					//if($value['ss_aw_section_title'] == $val)
					if ($value['ss_aw_section_title'] == $sequencenoary[$val]) {
						$category_id = $value['ss_aw_section_id'];
					}
				}
				$finalquestionary[$i]['question_id'] = $question_id;
				$finalquestionary[$i]['level'] = $response[0]['ss_aw_level'];
				$finalquestionary[$i]['format'] = $response[0]['ss_aw_format'];

				if ($response[0]['ss_aw_format'] == 'Single')
					$finalquestionary[$i]['format_id'] = 1;
				else
					$finalquestionary[$i]['format_id'] = 2;

				$finalquestionary[$i]['seq_no'] = $response[0]['ss_aw_seq_no'];
				$finalquestionary[$i]['weight'] = $response[0]['ss_aw_weight'];
				$finalquestionary[$i]['category'] = $response[0]['ss_aw_category'];
				$finalquestionary[$i]['sub_category'] = $response[0]['ss_aw_sub_category'];
				$finalquestionary[$i]['question_format'] = $response[0]['ss_aw_question_format'];

				/* if($response[0]['ss_aw_question_format'] == 'Choose the right answers')
                  $finalquestionary[$i]['question_format_id'] = 2; */
				if ($response[0]['ss_aw_question_format'] == 'Choose the right answer')
					$finalquestionary[$i]['question_format_id'] = 2;
				else if ($response[0]['ss_aw_question_format'] == 'Fill in the blanks')
					$finalquestionary[$i]['question_format_id'] = 1;
				else if ($response[0]['ss_aw_question_format'] == 'Rewrite the sentence')
					$finalquestionary[$i]['question_format_id'] = 3;


				$finalquestionary[$i]['prefaceaudio'] = base_url() . $response[0]['ss_aw_question_preface_audio'];
				$finalquestionary[$i]['preface'] = $response[0]['ss_aw_question_preface'];
				$finalquestionary[$i]['question'] = trim($response[0]['ss_aw_question']);

				$multiple_choice_ary = array();
				$multiple_choice_ary = explode("/", trim($response[0]['ss_aw_multiple_choice']));
				if (count($multiple_choice_ary) > 1)
					$finalquestionary[$i]['options'] = $multiple_choice_ary;
				else
					$finalquestionary[$i]['options'][] = $response[0]['ss_aw_multiple_choice'];

				$finalquestionary[$i]['verb_form'] = $response[0]['ss_aw_verb_form'];

				$answersary = array();
				$answersary = explode("/", trim($response[0]['ss_aw_answers']));
				if (count($answersary) > 1) {
					$answersary = array_map('trim', $answersary);
					$finalquestionary[$i]['answers'] = $answersary;
				} else {
					$finalquestionary[$i]['answers'][] = trim($response[0]['ss_aw_answers']);
				}
				$finalquestionary[$i]['answeraudio'] = base_url() . $response[0]['ss_aw_answers_audio'];

				$finalquestionary[$i]['rules'] = trim($response[0]['ss_aw_rules']);
				$finalquestionary[$i]['hint'] = "";
				$finalquestionary[$i]['ruleaudio'] = base_url() . $response[0]['ss_aw_rules_audio'];

				$i++;
				$asked_question_ids .= $question_id . ",";
				$asked_category_ids .= $category_id . ",";
			} else {
				//$finalquestionary[] = "No Data Found";
			}
		}
		//echo $question_ids;

		/* Get Idle time for a question */
		$setting_result = array();
		$setting_result = $this->ss_aw_general_settings_model->fetch_record();
		$idletime = $setting_result[0]->ss_aw_time_skip;
		$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
		$insertary = array();
		$insertary['ss_aw_child_id'] = $child_id;
		$insertary['ss_aw_question_set'] = 2;
		$insertary['ss_aw_diagnostic_id'] = $asked_question_ids;
		$insertary['ss_aw_asked_category_id'] = $asked_category_ids;
		$insertary['ss_aw_diagonastic_exam_code'] = $diagonastic_exam_code;
		$this->ss_aw_diagnonstic_questions_asked_model->insert_record($insertary);

		$responseary['status'] = 200;
		$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
		$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
		$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
		$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
		$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
		$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
		$responseary['skip_duration'] = $idletime;
		$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
		$responseary['skip_type_1_2_duration'] = $idletime;
		$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
		$responseary['data'] = $finalquestionary;
		$responseary['diagonastic_exam_code'] = $diagonastic_exam_code;

		return $responseary;
	}

	/*
      Store diagnostic Exam data against partisular Student
     */

	public function store_diagnostic_exam_data()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$exam_code = $inputpost['diagonastic_exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$question_id = $inputpost['question_id'];
				$answers_post = $inputpost['answers_post'];
				$right_answers = $inputpost['right_answers'];
				$answers_status = $inputpost['answers_status']; // 1 = Right, 2 = Wrong
				$level = $inputpost['level']; // E,C,A
				$weight = $inputpost['weight'];

				$storedata = array();
				$storedata['ss_aw_diagonastic_log_child_id'] = $child_id;
				$storedata['ss_aw_diagonastic_log_question_id'] = $question_id;
				$storedata['ss_aw_diagonastic_log_level'] = $level;
				$storedata['ss_aw_diagonastic_log_answers'] = $answers_post;
				$storedata['ss_aw_diagonastic_log_weight'] = $weight;
				$storedata['ss_aw_diagonastic_log_right_answers'] = $right_answers;
				$storedata['ss_aw_diagonastic_log_answer_status'] = $answers_status;
				$storedata['ss_aw_diagonastic_log_exam_code'] = $exam_code;

				$this->ss_aw_diagonastic_exam_log_model->insert_record($storedata);

				$responseary['status'] = 200;
				$responseary['msg'] = "Diagnostic test answers post successfully.";
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function complete_diagonatic_exam()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$exam_code = $inputpost['diagonastic_exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$postdata = array();
				$postdata['ss_aw_diagonastic_child_id'] = $child_id;
				$postdata['ss_aw_diagonastic_exam_code'] = $exam_code;
				$this->ss_aw_diagonastic_exam_model->insert_record($postdata);

				$responseary['status'] = 200;
				$responseary['msg'] = "Diagnostic test completed successfully.";

				$total_marks = 20;
				$obtain_marks = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
				//send notification code
				$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

				$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
				$child_name = $child_profile[0]->ss_aw_child_nick_name;
				$child_gender = $child_profile[0]->ss_aw_child_gender;
				$child_age = calculate_age($child_profile[0]->ss_aw_child_dob);
				$month_date = date('d/m/Y');
				$gender = "";
				if ($child_gender == 1) {
					$gender = "him";
				} else {
					$gender = "her";
				}
				$action_id = 5;
				$user_course = $this->ss_aw_child_course_model->get_latest_course($child_id);
				if ($user_course->ss_aw_course_id == 1) {
					if (empty($child_profile[0]->ss_aw_is_self) && empty($child_profile[0]->ss_aw_institution_user_upload_id)) {
						$email_template = getemailandpushnotification(30, 1, 1);
						$app_template = getemailandpushnotification(30, 2, 1);

						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);

							$send_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
						}

						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
							$title = $app_template['title'];
							$token = $parent_detail[0]->ss_aw_device_token;

							$state_details = getchild_diagnosticexam_status($child_id);

							$params = array(
								'childId' => $child_id,
								'childStateId' => $state_details['id'],
								'childStateSubId' => $state_details['sub_id'],
								'childNickName' => $child_name,
							);

							$extra_data = json_encode($params);

							pushnotification($title, $body, $token, $action_id, $extra_data);

							$save_data = array(
								'user_id' => $parent_detail[0]->ss_aw_parent_id,
								'user_type' => 1,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => $action_id,
								'params' => $extra_data
							);

							save_notification($save_data);
						}
					}


					$email_template = getemailandpushnotification(30, 1, 2);
					$app_template = getemailandpushnotification(30, 2, 2);

					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@child_name@@]", $child_name, $body);
						$body = str_ireplace("[@@month_date@@]", $month_date, $body);
						$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
						$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
						$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);

						$send_data = array(
							'ss_aw_email' => $child_profile[0]->ss_aw_child_email,
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
					}

					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@month_date@@]", $month_date, $body);
						$body = str_ireplace("[@@child_name@@]", $child_name, $body);
						$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
						$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
						$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
						$title = $app_template['title'];
						$token = $child_profile[0]->ss_aw_device_token;

						$state_details = getchild_diagnosticexam_status($child_id);

						$params = array(
							'childId' => $child_id,
							'childStateId' => $state_details['id'],
							'childStateSubId' => $state_details['sub_id'],
							'childNickName' => $child_name,
						);

						$extra_data = json_encode($params);

						pushnotification($title, $body, $token, $action_id, $extra_data);

						$save_data = array(
							'user_id' => $child_profile[0]->ss_aw_child_id,
							'user_type' => 2,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => $action_id,
							'params' => $extra_data
						);

						save_notification($save_data);
					}
				} elseif ($user_course->ss_aw_course_id == 3) {
					if (empty($child_profile[0]->ss_aw_is_self) && empty($child_profile[0]->ss_aw_institution_user_upload_id)) {
						$email_template = getemailandpushnotification(69, 1, 1);
						$app_template = getemailandpushnotification(69, 2, 1);

						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);

							$send_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
						}

						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
							$title = $app_template['title'];
							$token = $parent_detail[0]->ss_aw_device_token;

							$state_details = getchild_diagnosticexam_status($child_id);

							$params = array(
								'childId' => $child_id,
								'childStateId' => $state_details['id'],
								'childStateSubId' => $state_details['sub_id'],
								'childNickName' => $child_name,
							);

							$extra_data = json_encode($params);

							pushnotification($title, $body, $token, $action_id, $extra_data);

							$save_data = array(
								'user_id' => $parent_detail[0]->ss_aw_parent_id,
								'user_type' => 1,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => $action_id,
								'params' => $extra_data
							);

							save_notification($save_data);
						}
					}

					$email_template = getemailandpushnotification(69, 1, 2);
					$app_template = getemailandpushnotification(69, 2, 2);

					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@child_name@@]", $child_name, $body);
						$body = str_ireplace("[@@month_date@@]", $month_date, $body);
						$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
						$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
						$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);

						$send_data = array(
							'ss_aw_email' => $child_profile[0]->ss_aw_child_email,
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
					}

					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@month_date@@]", $month_date, $body);
						$body = str_ireplace("[@@child_name@@]", $child_name, $body);
						$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
						$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
						$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
						$title = $app_template['title'];
						$token = $child_profile[0]->ss_aw_device_token;

						$state_details = getchild_diagnosticexam_status($child_id);

						$params = array(
							'childId' => $child_id,
							'childStateId' => $state_details['id'],
							'childStateSubId' => $state_details['sub_id'],
							'childNickName' => $child_name,
						);

						$extra_data = json_encode($params);

						pushnotification($title, $body, $token, $action_id, $extra_data);

						$save_data = array(
							'user_id' => $child_profile[0]->ss_aw_child_id,
							'user_type' => 2,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => $action_id,
							'params' => $extra_data
						);

						save_notification($save_data);
					}
				} else {
					if (empty($child_profile[0]->ss_aw_is_self) && empty($child_profile[0]->ss_aw_institution_user_upload_id)) {
						$email_template = getemailandpushnotification(58, 1, 1);

						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
							$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);

							$send_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
						}
					}

					$email_template = getemailandpushnotification(58, 1, 2);

					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@child_name@@]", $child_name, $body);
						$body = str_ireplace("[@@month_date@@]", $month_date, $body);
						$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
						$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
						$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);

						$send_data = array(
							'ss_aw_email' => $child_profile[0]->ss_aw_child_email,
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	/*
      Get Child Status.Diagonatic exam status,Lesson status,Readalong status
     */

	public function get_course_status()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$child_state = array();
				$child_state = getchild_diagnosticexam_status($child_id); // This function situated in Custom_helper

				$responseary['status'] = 200;
				$responseary['child_state'] = $child_state;
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = "";
				$accessable = 1;
				if (!empty($childary)) {
					$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];
					if ($course_id == 1) {
						$level = "E";
					} elseif ($course_id == 2) {
						$level = "C";
					} elseif ($course_id == 3) {
						$level = "A";
					} else {
						$level = "M";
					}

					//get accessibility of course
					if ($childary[count($childary) - 1]['ss_aw_course_payemnt_type'] == 1) {
						//get first emi payment date
						$first_emi_date = date('Y-m-d', strtotime($childary[0]['ss_aw_child_course_create_date']));
						$first_emi_date_time = strtotime($first_emi_date);
						$current_date = date('Y-m-d');
						$current_date_time = strtotime($current_date);

						//calculate difference between first payment date and current date.
						$datediff = $current_date_time - $first_emi_date_time;
						$mid_days = round($datediff / (60 * 60 * 24));
						//get present emi day num after first payment date
						$present_emi_day_num = ($mid_days / 31); //31 is the day interval between two emis
						$present_emi_day_num = round($present_emi_day_num) * 31;

						//calculate next emi date
						$next_emi_date = date('Y-m-d', strtotime($first_emi_date . " +" . $present_emi_day_num . " days"));
						$next_emi_date_time = strtotime($next_emi_date);
						$datediff = $next_emi_date_time - $current_date_time;
						$mid_days = round($datediff / (60 * 60 * 24));
						if ($mid_days >= -1) {
							$accessable = 1;
						} else {
							$accessable = 0;
						}
					} else {
						$accessable = 1;
					}
				}
				$responseary['child_level'] = $level;
				$responseary['child_accessibility'] = $accessable;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	function check_question_exist($questionid, $oldquestionsdataary, $category_id, $child_level)
	{
		/* echo $questionid;
          print_r($oldquestionsdataary);
          echo "==========="; */
		if (!in_array($questionid, $oldquestionsdataary)) {
			return $questionid;
		} else {
			$response = $this->ss_aw_assisment_diagnostic_model->fetch_question_bycategory($category_id, $child_level);

			return $this->check_question_exist($response[0]['ss_aw_id'], $oldquestionsdataary, $category_id, $child_level);
		}
	}

	public function assessment_exam_question_first_question()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
				$child_age = calculate_age($child_profile[0]->ss_aw_child_dob);

				$assessment_details = $this->ss_aw_assesment_uploaded_model->get_assessment_details_by_id($assessment_id);
				$assessment_serial_no = $assessment_details->ss_aw_sl_no;
				if (!empty($inputpost['assessment_exam_code'])) {

					$getlast_lessonary = array();
					$getlast_lessonary = $this->ss_aw_child_last_lesson_model->fetch_details($child_id);
					/*
                      Find out Current LEVEL of the child
                     */
					$subcategoryary = array();
					if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
						$level = "E";
					else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
						$level = "C";
					else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
						$level = "A";
					else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 5)
						$level = "M";

					if ($level == 'E' || $level == 'C') {
						if ($child_age < 13) {
							if ($assessment_serial_no > 10) {
								$fetch_level = 'C';
							} else {
								$fetch_level = 'E';
							}
						} else {
							$fetch_level = 'C';
						}
					} elseif ($level == 'M') {
						if ($assessment_serial_no <= 10) {
							$fetch_level = 'C';
						} elseif ($assessment_serial_no > 10 && $assessment_serial_no < 56) {
							$fetch_level = 'A';
						} else {
							$fetch_level = 'M';
						}
					} else {
						$fetch_level = 'A';
					}

					$subcategoryary['ss_aw_level'] = $fetch_level;
					$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
					//$subcategoryary['ss_aw_quiz_type'] = 2;

					$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);

					$firstsubcategory_name = $searchresultary[0]['ss_aw_sub_category'];
					$count_subcategory = count($searchresultary); // Total No of Sub-category



					$subcategoryary = array();
					$subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
					$searchresultary = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);

					$min_question_no = $searchresultary[0]['ss_aw_min_question']; // Min question asked form current LEVEL
					$sub_section_no = $searchresultary[0]['ss_aw_sub_section_no'];
					$total_question_no = $searchresultary[0]['ss_aw_total_question'] * $sub_section_no;
					$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']); // Min question asked from sub-category
					$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']); // Min question asked from sub-category

					$exam_code = $inputpost['assessment_exam_code'];
					$searchary = array();
					$searchary['ss_aw_assessment_exam_code'] = $exam_code;
					$searchary['ss_aw_child_id'] = $child_id;
					$searchary['ss_aw_assessment_id'] = $assessment_id;
					$response = array();
					$response = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_question_details($searchary);

					$finalquestionary = array();
					$i = 0;
					foreach ($response as $value) {

						$finalquestionary[$i]['question_id'] = $value['ss_aw_assessment_question_id'];
						$finalquestionary[$i]['level'] = $value['ss_aw_asked_level'];
						$finalquestionary[$i]['format'] = $value['ss_aw_format'];

						if ($value['ss_aw_format'] == 'Single')
							$finalquestionary[$i]['format_id'] = 1;
						else
							$finalquestionary[$i]['format_id'] = 2;

						$finalquestionary[$i]['seq_no'] = $value['ss_aw_seq_no'];
						$finalquestionary[$i]['weight'] = $value['ss_aw_weight'];
						$finalquestionary[$i]['category'] = $value['ss_aw_asked_category'];
						$finalquestionary[$i]['sub_category'] = $value['ss_aw_asked_sub_category'];
						$finalquestionary[$i]['question_format'] = $value['ss_aw_question_format'];

						if ($value['ss_aw_question_format'] == 'Choose the right answers')
							$finalquestionary[$i]['question_format_id'] = 2;
						if ($value['ss_aw_question_format'] == 'Choose the right answer')
							$finalquestionary[$i]['question_format_id'] = 2;
						else if ($value['ss_aw_question_format'] == 'Fill in the blanks')
							$finalquestionary[$i]['question_format_id'] = 1;
						else if ($value['ss_aw_question_format'] == 'Rewrite the sentence')
							$finalquestionary[$i]['question_format_id'] = 3;



						$finalquestionary[$i]['prefaceaudio'] = base_url() . $value['ss_aw_question_preface_audio'];
						$finalquestionary[$i]['preface'] = $value['ss_aw_question_preface'];
						$finalquestionary[$i]['question'] = trim($value['ss_aw_question']);

						$multiple_choice_ary = array();
						$multiple_choice_ary = explode("/", $value['ss_aw_multiple_choice']);

						if (count($multiple_choice_ary) > 1) {
							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
							$finalquestionary[$i]['options'] = $multiple_choice_ary;
						} else {
							$finalquestionary[$i]['options'][0] = $value['ss_aw_multiple_choice'];
						}

						$finalquestionary[$i]['verb_form'] = $value['ss_aw_verb_form'];

						$answersary = array();
						$answersary = explode("/", trim($value['ss_aw_answers']));
						if (count($answersary) > 1) {
							$answersary = array_map('trim', $answersary);
							$finalquestionary[$i]['answers'] = $answersary;
						} else {
							$finalquestionary[$i]['answers'][0] = trim($value['ss_aw_answers']);
						}
						$finalquestionary[$i]['answeraudio'] = base_url() . $value['ss_aw_answers_audio'];
						$finalquestionary[$i]['rules'] = trim($value['ss_aw_rules']);

						$finalquestionary[$i]['hint'] = "";
						$finalquestionary[$i]['ruleaudio'] = base_url() . $value['ss_aw_rules_audio'];

						$finalquestionary[$i]['releted_question_id'] = $value['ss_aw_skip_related_queston'];

						$finalquestionary[$i]['releted_question_status'] = $value['ss_aw_related_queston_status'];

						if ($value['ss_aw_assessment_quiz_skip'] == 2)
							$finalquestionary[$i]['skip_status'] = 1; // 1 = SKIP, 0 = NOT SKIP
						else
							$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP

						if ($value['ss_aw_answers_status'] == 1)
							$finalquestionary[$i]['ans_status'] = 1; // 1 = Answered, 0 = Pending, 2= Wrong
						else if ($value['ss_aw_answers_status'] == 2)
							$finalquestionary[$i]['ans_status'] = 2; // 1 = Answered, 0 = Pending, 2= Wrong
						else
							$finalquestionary[$i]['ans_status'] = 0; // 1 = Answered, 0 = Pending, 2= Wrong

						$i++;
					}
				} else {
					$getlast_lessonary = array();
					$getlast_lessonary = $this->ss_aw_child_last_lesson_model->fetch_details($child_id);

					/*
                      Find out Current LEVEL of the child
                     */
					$subcategoryary = array();
					if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
						$level = "E";
					else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
						$level = "C";
					else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
						$level = "A";
					else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 5)
						$level = "M";

					if ($level == 'E' || $level == 'C') {
						if ($child_age < 13) {
							if ($assessment_serial_no > 10) {
								$fetch_level = 'C';
							} else {
								$fetch_level = 'E';
							}
						} else {
							$fetch_level = 'C';
						}
					} elseif ($level == 'M') {
						if ($assessment_serial_no <= 10) {
							$fetch_level = 'C';
						} elseif ($assessment_serial_no > 10 && $assessment_serial_no < 56) {
							$fetch_level = 'A';
						} else {
							$fetch_level = 'M';
						}
					} else {
						$fetch_level = 'A';
					}

					$subcategoryary['ss_aw_level'] = $fetch_level;
					$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
					//$subcategoryary['ss_aw_quiz_type'] = 2;

					$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);

					$firstsubcategory_name = $searchresultary[0]['ss_aw_sub_category'];
					$count_subcategory = count($searchresultary); // Total No of Sub-category



					$subcategoryary = array();
					$subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
					$searchresultary = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);

					$min_question_no = $searchresultary[0]['ss_aw_min_question']; // Min question asked form current LEVEL
					$sub_section_no = $searchresultary[0]['ss_aw_sub_section_no'];
					$total_question_no = $searchresultary[0]['ss_aw_total_question'] * $sub_section_no;
					$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']); // Min question asked from sub-category
					$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']); // Min question asked from sub-category

					/*
                      Search record group by Level from assessment questions
                     */
					$subcategoryary = array();
					$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
					$searchresultlevelgroupary = array();
					$searchresultlevelgroupary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby_level($subcategoryary);

					if ($fetch_level == 'A') {
						$min_question_no = $searchresultary[0]['ss_aw_total_question'];
					} else if ($fetch_level == 'C') {
						$exist_levelary = array();
						foreach ($searchresultlevelgroupary as $value) {
							$exist_levelary[] = $value['ss_aw_level'];
						}
						if (!in_array('A', $exist_levelary)) {
							$min_question_no = $searchresultary[0]['ss_aw_total_question'];
						}
					}
					$min_subsection_questions_count = $min_question_no;
					$subcategoryary = array();
					$subcategoryary['ss_aw_level'] = $fetch_level;

					//$subcategoryary['ss_aw_quiz_type'] = 2;
					$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
					$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;

					$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
					$total_question_first_subcat = count($searchresultary);

					$sequence_start_value = $total_question_first_subcat / $min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL
					$response = array();
					$exam_code = time() . "_" . $child_id;

					for ($i = 1; $i <= $min_question_no; $i++) {
						$subcategoryary = array();
						$subcategoryary['ss_aw_seq_no'] = ceil($sequence_start_value * $i);
						$subcategoryary['ss_aw_level'] = $fetch_level;
						//$subcategoryary['ss_aw_quiz_type'] = 2;
						$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
						$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;

						$currentresult = array();
						$checkresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);

						if (!empty($checkresult)) {
							$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
							//$currentresult = $this->check_question_exist_assisment($subcategoryary);
							$response[] = $currentresult;
						} else {
							do {
								$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;

								$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
								//$currentresult = $this->check_question_exist_assisment($subcategoryary);
								$response[] = $currentresult;
							} while (empty($currentresult));
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

					$finalquestionary = array();
					$i = 0;
					foreach ($response as $value) {
						//if($i == 0)
						{
							$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
							$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
							$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];

							if ($value[0]['ss_aw_format'] == 'Single')
								$finalquestionary[$i]['format_id'] = 1;
							else
								$finalquestionary[$i]['format_id'] = 2;

							$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
							$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
							$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
							$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
							$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];

							if ($value[0]['ss_aw_question_format'] == 'Choose the right answer')
								$finalquestionary[$i]['question_format_id'] = 2;
							else if ($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
								$finalquestionary[$i]['question_format_id'] = 1;
							else if ($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
								$finalquestionary[$i]['question_format_id'] = 3;


							$finalquestionary[$i]['prefaceaudio'] = base_url() . $value[0]['ss_aw_question_preface_audio'];
							$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
							$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);

							$multiple_choice_ary = array();
							$multiple_choice_ary = explode("/", $value[0]['ss_aw_multiple_choice']);

							if (count($multiple_choice_ary) > 1) {
								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								$finalquestionary[$i]['options'] = $multiple_choice_ary;
							} else {
								$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];
							}

							$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];

							$answersary = array();
							$answersary = explode("/", trim($value[0]['ss_aw_answers']));
							if (count($answersary) > 1) {
								$answersary = array_map('trim', $answersary);
								$finalquestionary[$i]['answers'] = $answersary;
							} else {
								$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
							}
							$finalquestionary[$i]['answeraudio'] = base_url() . $value[0]['ss_aw_answers_audio'];
							$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);

							$finalquestionary[$i]['hint'] = "";
							$finalquestionary[$i]['ruleaudio'] = base_url() . $value[0]['ss_aw_rules_audio'];
							$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
							$i++;
						}
					}
				}
				/* Get Idle time for a question */

				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(3);

				$responseary['status'] = 200;
				if (!empty($inputpost['assessment_exam_code'])) {
					$total_taken_time = $this->ss_aw_assessment_exam_log_model->get_total_time_elapsed($inputpost['assessment_exam_code'], $child_id);
					$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value - $total_taken_time;
				} else {
					$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
				}

				$responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
				$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
				$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
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
				$assesment_detail = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
				if (!empty($assesment_detail)) {
					$responseary['topic_id'] = $assesment_detail[0]->ss_aw_assesment_topic_id;
				} else {
					$responseary['topic_id'] = 0;
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function current_assessment_exam_details()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_assessment_quiz_skip'] = 3;
				$searchresultary = array();
				$searchresultary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($searchary);
				if (!empty($searchresultary)) {
					$responseary['status'] = 200;
					$responseary['exam_code'] = $searchresultary[0]['ss_aw_assessment_exam_code'];
					$responseary['current_question_id'] = $searchresultary[0]['ss_aw_assessment_question_id'];
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
					}
				}
				echo json_encode($responseary);
				die();
			}
		}
	}

	public function assessment_exam_question_next_level_subcategory()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$assessment_exam_code = $inputpost['assessment_exam_code'];

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
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

				/*
                  Total Correct ans count
                 */
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
				/*
                  Find out no of sub category against partcular topic/category for Assesment test
                 */
				$subcategoryary = array();
				if ($getlast_askedquestion[0]['ss_aw_asked_level'] == 'E')
					$level = "C";
				else if ($getlast_askedquestion[0]['ss_aw_asked_level'] == 'C')
					$level = "A";

				$subcategoryary['ss_aw_level'] = $level;
				$subcategoryary['ss_aw_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;

				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);

				$count_subcategory = count($searchresultary); // Total No of Sub-category



				$subcategoryary = array();
				$subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
				$searchresultary = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);

				$min_question_no = $searchresultary[0]['ss_aw_min_question']; // Min question asked form current LEVEL
				$sub_section_no = $searchresultary[0]['ss_aw_sub_section_no'];
				$total_question_no = $searchresultary[0]['ss_aw_total_question'] * $sub_section_no;
				$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']); // Min question asked from sub-category
				$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']); // Total question asked from sub-category

				$subcategoryary = array();
				$subcategoryary['ss_aw_level'] = $level;
				$subcategoryary['ss_aw_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
				$total_question_first_subcat = count($searchresultary);

				//Total Right ans count not required.Always use remaing question count
				//$total_question_asked = $total_subsection_questions_count - $total_right_ans_count;

				$min_question_no = $total_subsection_questions_count - $min_subsection_questions_count;

				/* if($total_right_ans_count == $total_question_asked)
                  {
                  $min_question_no = $total_subsection_questions_count - $min_question_no;
                  } */

				$sequence_start_value = $total_question_first_subcat / $min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL
				//$min_subsection_questions_count = $min_question_no;
				$response = array();

				$question_no_asked = $total_subsection_questions_count - $total_question_asked;

				for ($i = 1; $i <= $question_no_asked; $i++) {
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

					if (!empty($checkresult)) {
						$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
						//$currentresult = $this->check_question_exist_assisment($subcategoryary);
						$response[] = $currentresult;
					} else {
						do {

							$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;

							$checkresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
							$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
							//$currentresult = $this->check_question_exist_assisment($subcategoryary);
							if (!empty($currentresult))
								$response[] = $currentresult;
						} while (empty($checkresult));
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
				foreach ($response as $value) {
					//if($i == 0)
					{
						$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
						$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
						$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];

						if ($value[0]['ss_aw_format'] == 'Single')
							$finalquestionary[$i]['format_id'] = 1;
						else
							$finalquestionary[$i]['format_id'] = 2;

						$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
						$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
						$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
						$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
						$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];

						if ($value[0]['ss_aw_question_format'] == 'Choose the right answer')
							$finalquestionary[$i]['question_format_id'] = 2;
						else if ($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
							$finalquestionary[$i]['question_format_id'] = 1;
						else if ($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
							$finalquestionary[$i]['question_format_id'] = 3;


						$finalquestionary[$i]['prefaceaudio'] = base_url() . $value[0]['ss_aw_question_preface_audio'];
						$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
						$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);

						$multiple_choice_ary = array();
						$multiple_choice_ary = explode("/", $value[0]['ss_aw_multiple_choice']);

						if (count($multiple_choice_ary) > 1) {
							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
							$finalquestionary[$i]['options'] = $multiple_choice_ary;
						} else {
							$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];
						}

						$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];

						$answersary = array();
						$answersary = explode("/", trim($value[0]['ss_aw_answers']));
						if (count($answersary) > 1) {
							$answersary = array_map('trim', $answersary);
							$finalquestionary[$i]['answers'] = $answersary;
						} else {
							$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
						}
						$finalquestionary[$i]['answeraudio'] = base_url() . trim($value[0]['ss_aw_answers_audio']);
						$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);

						$finalquestionary[$i]['hint'] = "";
						$finalquestionary[$i]['ruleaudio'] = base_url() . $value[0]['ss_aw_rules_audio'];
						$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
						$i++;
					}
				}
				/* Get Idle time for a question */

				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

				$responseary['status'] = 200;
				$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
				$responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
				$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
				$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
				$responseary['skip_duration'] = $idletime;
				$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
				$responseary['skip_type_1_2_duration'] = $idletime;
				$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
				$responseary['data'] = $finalquestionary;
				$responseary['assessment_exam_code'] = $assessment_exam_code;
				$responseary['question_asked_count'] = 0;
				$responseary['total_questions_count'] = $total_question_no;
				$responseary['min_subsection_questions_count'] = $min_subsection_questions_count;
				$responseary['total_subsection_questions_count'] = $total_subsection_questions_count;
				$responseary['assessment_id'] = intval($assessment_id);
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function assessment_exam_question_next_sub_category()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$assessment_exam_code = $inputpost['assessment_exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
				$child_age = calculate_age($child_profile[0]->ss_aw_child_dob);

				$assessment_details = $this->ss_aw_assesment_uploaded_model->get_assessment_details_by_id($assessment_id);
				$assessment_serial_no = $assessment_details->ss_aw_sl_no;
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
				foreach ($asked_questions_array as $value) {
					$asked_sub_catname[] = $value['ss_aw_asked_sub_category'];
					$asked_questionary[] = $value['ss_aw_assessment_question_id'];
				}
				$asked_sub_catname = array_unique($asked_sub_catname);

				/*
                  Find out no of sub category against partcular topic/category for Assesment test
                 */
				$subcategoryary = array();
				if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
					$level = "E";
				else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
					$level = "C";
				else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
					$level = "A";
				else if ($getlast_lessonary[0]['ss_aw_lesson_level'] == 5)
					$level = "M";

				if ($level == 'E' || $level == 'C') {
					if ($child_age < 13) {
						if ($assessment_serial_no > 10) {
							$fetch_level = 'C';
						} else {
							$fetch_level = 'E';
						}
					} else {
						$fetch_level = 'C';
					}
				} elseif ($level == 'M') {
					if ($assessment_serial_no <= 10) {
						$fetch_level = 'C';
					} elseif ($assessment_serial_no > 10 && $assessment_serial_no < 56) {
						$fetch_level = 'A';
					} else {
						$fetch_level = 'M';
					}
				} else {
					$fetch_level = 'A';
				}

				$subcategoryary['ss_aw_level'] = $fetch_level;
				//$subcategoryary['ss_aw_category'] = $getlast_lessonary[0]['ss_aw_lesson_topic'];
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$firstsubcategory_name = "";
				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);

				$count_subcategory = count($searchresultary); // Total No of Sub-category
				foreach ($searchresultary as $value) {
					if ($count_subcategory > 1) {
						if (!in_array($value['ss_aw_sub_category'], $asked_sub_catname)) {
							$firstsubcategory_name = $value['ss_aw_sub_category'];
							break;
						}
					} else {
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
				$min_subsection_questions_count = intval($searchresultary[0]['ss_aw_min_question']); // Min question asked from sub-category
				$total_subsection_questions_count = intval($searchresultary[0]['ss_aw_total_question']); // Min question asked from sub-category


				$response = array();
				$exam_code = $assessment_exam_code;

				/*                 * ************************************************************************************************************************** */
				/*
                  Search record group by Level from assessment questions
                 */
				$subcategoryary = array();
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$searchresultlevelgroupary = array();
				$searchresultlevelgroupary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby_level($subcategoryary);

				if ($fetch_level == 'A') {
					$min_question_no = $searchresultary[0]['ss_aw_total_question'];
				} else if ($fetch_level == 'C') {
					$exist_levelary = array();
					foreach ($searchresultlevelgroupary as $value) {
						$exist_levelary[] = $value['ss_aw_level'];
					}
					if (!in_array('A', $exist_levelary)) {
						$min_question_no = $searchresultary[0]['ss_aw_total_question'];
					}
				}

				/*                 * *************************************************************************************************************************** */
				$min_subsection_questions_count = $min_question_no;
				$subcategoryary = array();
				$subcategoryary['ss_aw_level'] = $fetch_level;

				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
				$total_question_first_subcat = count($searchresultary);

				$sequence_start_value = $total_question_first_subcat / $min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL

				for ($i = 1; $i <= $min_question_no; $i++) {
					$subcategoryary = array();

					$subcategoryary['ss_aw_seq_no'] = ceil($sequence_start_value * $i);

					$subcategoryary['ss_aw_level'] = $fetch_level;
					//$subcategoryary['ss_aw_assessment_exam_code'] = $exam_code;
					//$subcategoryary['ss_aw_quiz_type'] = 2;
					$subcategoryary['ss_aw_sub_category'] = $firstsubcategory_name;
					$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
					$currentresult = array();
					$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
					if (!empty($currentresult)) {
						if (in_array($currentresult[0]['ss_aw_id'], $asked_questionary)) {
							do {
								$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;
								$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
								$response[] = $currentresult;
							} while (empty($currentresult));
						} else {
							$response[] = $currentresult;
						}
					} else {
						do {
							$subcategoryary['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'] + 1;
							$currentresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);

							if (!in_array($currentresult[0]['ss_aw_id'], $asked_questionary)) {
								$response[] = $currentresult;
							}
						} while (in_array($currentresult[0]['ss_aw_id'], $asked_questionary) || empty($currentresult));
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
				foreach ($response as $value) {
					//if($i == 0)
					{
						$finalquestionary[$i]['question_id'] = $value[0]['ss_aw_id'];
						$finalquestionary[$i]['level'] = $value[0]['ss_aw_level'];
						$finalquestionary[$i]['format'] = $value[0]['ss_aw_format'];

						if ($value[0]['ss_aw_format'] == 'Single')
							$finalquestionary[$i]['format_id'] = 1;
						else
							$finalquestionary[$i]['format_id'] = 2;

						$finalquestionary[$i]['seq_no'] = $value[0]['ss_aw_seq_no'];
						$finalquestionary[$i]['weight'] = $value[0]['ss_aw_weight'];
						$finalquestionary[$i]['category'] = $value[0]['ss_aw_category'];
						$finalquestionary[$i]['sub_category'] = $value[0]['ss_aw_sub_category'];
						$finalquestionary[$i]['question_format'] = $value[0]['ss_aw_question_format'];

						if ($value[0]['ss_aw_question_format'] == 'Choose the right answer')
							$finalquestionary[$i]['question_format_id'] = 2;
						else if ($value[0]['ss_aw_question_format'] == 'Fill in the blanks')
							$finalquestionary[$i]['question_format_id'] = 1;
						else if ($value[0]['ss_aw_question_format'] == 'Rewrite the sentence')
							$finalquestionary[$i]['question_format_id'] = 3;

						$finalquestionary[$i]['prefaceaudio'] = base_url() . $value[0]['ss_aw_question_preface_audio'];
						$finalquestionary[$i]['preface'] = $value[0]['ss_aw_question_preface'];
						$finalquestionary[$i]['question'] = trim($value[0]['ss_aw_question']);

						$multiple_choice_ary = array();
						$multiple_choice_ary = explode("/", $value[0]['ss_aw_multiple_choice']);

						if (count($multiple_choice_ary) > 1) {
							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
							$finalquestionary[$i]['options'] = $multiple_choice_ary;
						} else {
							$finalquestionary[$i]['options'][0] = $value[0]['ss_aw_multiple_choice'];
						}

						$finalquestionary[$i]['verb_form'] = $value[0]['ss_aw_verb_form'];

						$answersary = array();
						$answersary = explode("/", trim($value[0]['ss_aw_answers']));
						if (count($answersary) > 1) {
							$answersary = array_map('trim', $answersary);
							$finalquestionary[$i]['answers'] = $answersary;
						} else {
							$finalquestionary[$i]['answers'][0] = trim($value[0]['ss_aw_answers']);
						}
						$finalquestionary[$i]['answeraudio'] = base_url() . trim($value[0]['ss_aw_answers_audio']);
						$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);

						$finalquestionary[$i]['hint'] = "";
						$finalquestionary[$i]['ruleaudio'] = base_url() . $value[0]['ss_aw_rules_audio'];
						$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
						$i++;
					}
				}
				/* Get Idle time for a question */

				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

				$responseary['status'] = 200;
				$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
				$responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
				$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
				$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
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
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	// public function store_assessment_exam_data()
	// {
	// 	$inputpost = $this->input->post(); // Accept All post data post from APP		
	// 	$responseary = array();
	// 	if($inputpost)
	// 	{
	// 		$child_id = $inputpost['user_id']; // Child Record ID from Database
	// 		$child_token = $inputpost['user_token']; // Token get after login
	// 		$exam_code = $inputpost['assessment_exam_code'];
	// 		$parent_id = "";
	// 		if (!empty($inputpost['parent_id'])) {
	// 			$parent_id = $inputpost['parent_id'];
	// 		}
	// 		if($parent_id == "" ? $this->check_child_existance($child_id,$child_token) : $this->check_parent_existance($parent_id, $child_token)) // Check provider Token valid or not against child_id and token
	// 		{
	// 			$question_id = $inputpost['question_id'];
	// 			$answers_post = $inputpost['answers_post'];
	// 			$right_answers = $inputpost['right_answers'];
	// 			$answers_status = $inputpost['answers_status']; // 1 = Right, 2 = Wrong, 3= Skip
	// 			$question_format = $inputpost['question_format'];
	// 			$question_topic_id = $inputpost['topic_id'];
	// 			$time_elapsed = $inputpost['time_elapsed'];
	// 			$seconds_to_start_answer_question = $inputpost['seconds_to_start_answer_question'];
	// 			$seconds_to_answer_question = $inputpost['seconds_to_answer_question'];
	// 			$question_detailsary = array();
	// 			$searchary = array();
	// 			$searchary['ss_aw_id'] = $question_id;
	// 			$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
	// 			/* Get asnwered question details */
	// 			$checksearchary = array();
	// 			$checksearchary['ss_aw_assessment_exam_code'] = $exam_code;
	// 			$checksearchary['ss_aw_assessment_question_id'] = $question_id;
	// 			$checksearchary['ss_aw_child_id'] = $child_id;
	// 			$question_skipedstatus = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($checksearchary);
	// 			$finalquestionary = array();
	// 			//Return new Record against both the wrong and Skip Question
	// 			if($answers_status != 1 && $question_skipedstatus[0]['ss_aw_skip_once'] != 2) // 1 = Right, 2 = Wrong, 3= Skip
	// 			{
	// 				$searchary = array();
	// 				$newquestion = array();
	// 				$searchary['ss_aw_uploaded_record_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
	// 				$searchary['ss_aw_level'] = $question_detailsary[0]['ss_aw_level']; // E,C,A
	// 				$searchary['ss_aw_category'] = $question_detailsary[0]['ss_aw_category']; 
	// 				$searchary['ss_aw_sub_category'] = $question_detailsary[0]['ss_aw_sub_category'];
	// 				$ss_aw_seq_no = $question_detailsary[0]['ss_aw_seq_no']; 
	// 				$searchdata['ss_aw_quiz_type'] = $question_detailsary[0]['ss_aw_quiz_type'];
	// 				do{
	// 					$searchary['ss_aw_seq_no'] = $ss_aw_seq_no - 1;
	// 					if($searchary['ss_aw_seq_no'] <= 0)
	// 					{
	// 						break;
	// 					}
	// 					$checksearchary = array();
	// 					//$checksearchary['ss_aw_calculated_seq_no'] = $searchary['ss_aw_seq_no'];
	// 					$checksearchary['ss_aw_assessment_exam_code'] = $exam_code;
	// 					$checksearchary['ss_aw_assessment_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
	// 					$checksearchary['ss_aw_asked_sub_category'] = $searchary['ss_aw_sub_category'];
	// 					$checksearchary['ss_aw_asked_category'] = $searchary['ss_aw_category'];
	// 					$checksearchary['ss_aw_asked_level'] = $searchary['ss_aw_level'];
	// 					$checksearchary['ss_aw_child_id'] = $child_id;
	// 					/*
	// 					Check Question already asked or not using seq no
	// 					*/						
	// 					$alreadyasked_questionary = array();
	// 					$alreadyasked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($checksearchary);
	// 					$alreadyaskedquestionidary = array();
	// 					/* Already asked question ID array */
	// 					if(!empty($alreadyasked_questionary))
	// 					{
	// 						foreach($alreadyasked_questionary  as $value)
	// 						{
	// 							$alreadyaskedquestionidary[] = $value['ss_aw_assessment_question_id'];
	// 						}
	// 					}
	// 						$newquestion = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
	// 						if(!empty($newquestion))
	// 						{
	// 							foreach($newquestion as $value)
	// 							{
	// 								if(in_array($value['ss_aw_id'],$alreadyaskedquestionidary))
	// 								{
	// 									$newquestion = array();
	// 								}
	// 							}
	// 						}
	// 					$ss_aw_seq_no = $searchary['ss_aw_seq_no'];
	// 				}while(empty($newquestion));
	// 				$i = 0;
	// 				foreach($newquestion as $value)
	// 				{
	// 					//if($i == 0)
	// 					{					
	// 						$finalquestionary[$i]['question_id'] = $value['ss_aw_id'];
	// 						$finalquestionary[$i]['level'] = $value['ss_aw_level'];
	// 						$finalquestionary[$i]['format'] = $value['ss_aw_format'];
	// 						if($value['ss_aw_format'] == 'Single')
	// 							$finalquestionary[$i]['format_id'] = 1;
	// 						else
	// 							$finalquestionary[$i]['format_id'] = 2;
	// 						$finalquestionary[$i]['seq_no'] = $value['ss_aw_seq_no'];
	// 						$finalquestionary[$i]['weight'] = $value['ss_aw_weight'];
	// 						$finalquestionary[$i]['category'] = $value['ss_aw_category'];
	// 						$finalquestionary[$i]['sub_category'] = $value['ss_aw_sub_category'];
	// 						$finalquestionary[$i]['question_format'] = $value['ss_aw_question_format'];
	// 						/*if($value['ss_aw_question_format'] == 'Choose the right answers')
	// 							$finalquestionary[$i]['question_format_id'] = 2;*/
	// 						if($value['ss_aw_question_format'] == 'Choose the right answer')
	// 							$finalquestionary[$i]['question_format_id'] = 2;
	// 						else if($value['ss_aw_question_format'] == 'Fill in the blanks')
	// 							$finalquestionary[$i]['question_format_id'] = 1;
	// 						else if($value['ss_aw_question_format'] == 'Rewrite the sentence')
	// 							$finalquestionary[$i]['question_format_id'] = 3;
	// 						/*else if($value['ss_aw_question_format'] == 'Change the word to its comparative degree')
	// 							$finalquestionary[$i]['question_format_id'] = 4;
	// 						else if($value['ss_aw_question_format'] == 'Choose the right option')
	// 							$finalquestionary[$i]['question_format_id'] = 5;
	// 						else if($value['ss_aw_question_format'] == 'Convert to the comparative degree')
	// 							$finalquestionary[$i]['question_format_id'] = 6;
	// 						else if($value['ss_aw_question_format'] == 'Insert the adverb')
	// 							$finalquestionary[$i]['question_format_id'] = 7;
	// 						else if($value['ss_aw_question_format'] == 'Join the sentences')
	// 							$finalquestionary[$i]['question_format_id'] = 8;
	// 						else if($value['ss_aw_question_format'] == 'Place the article in the aprropraite place')
	// 							$finalquestionary[$i]['question_format_id'] = 9;
	// 						else if($value['ss_aw_question_format'] == 'Rewrite the sentence')
	// 							$finalquestionary[$i]['question_format_id'] = 10;*/
	// 						$finalquestionary[$i]['prefaceaudio'] = base_url().$value['ss_aw_question_preface_audio'];
	// 						$finalquestionary[$i]['preface'] = $value['ss_aw_question_preface'];
	// 						$finalquestionary[$i]['question'] = trim($value['ss_aw_question']);
	// 						$multiple_choice_ary = array();
	// 						$multiple_choice_ary = explode("/",$value['ss_aw_multiple_choice']);
	// 						if(count($multiple_choice_ary) > 1)
	// 						{
	// 							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
	// 							$finalquestionary[$i]['options'] = $multiple_choice_ary;
	// 						}
	// 						else
	// 						{
	// 							$finalquestionary[$i]['options'][0] = $value['ss_aw_multiple_choice'];									
	// 						}			
	// 						$finalquestionary[$i]['verb_form'] = $value['ss_aw_verb_form'];
	// 						$answersary = array();
	// 						$answersary = explode("/",trim($value['ss_aw_answers']));
	// 						if(count($answersary)> 1)
	// 						{
	// 							$answersary = array_map('trim', $answersary);
	// 							$finalquestionary[$i]['answers'] = $answersary;
	// 						}
	// 						else
	// 						{
	// 							$finalquestionary[$i]['answers'][0] = trim($value['ss_aw_answers']);
	// 						}
	// 						$finalquestionary[$i]['answeraudio'] = base_url().trim($value['ss_aw_answers_audio']);
	// 						$finalquestionary[$i]['rules'] = trim($value['ss_aw_rules']);
	// 						$finalquestionary[$i]['hint'] = "";
	// 						$finalquestionary[$i]['ruleaudio'] = base_url().$value['ss_aw_rules_audio'];
	// 						$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
	// 						$i++;
	// 					}
	// 					$insert_record = array();
	// 					$insert_record['ss_aw_assessment_exam_code'] = $exam_code;
	// 					$insert_record['ss_aw_assessment_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
	// 					$insert_record['ss_aw_calculated_seq_no'] = $value['ss_aw_seq_no'];
	// 					$insert_record['ss_aw_child_id'] = $child_id;
	// 					$insert_record['ss_aw_asked_level'] = $value['ss_aw_level'];
	// 					$insert_record['ss_aw_asked_category'] = $value['ss_aw_category'];
	// 					$insert_record['ss_aw_asked_sub_category'] = $value['ss_aw_sub_category'];
	// 					$insert_record['ss_aw_assessment_question_id'] = $value['ss_aw_id'];
	// 					$insert_record['ss_aw_skip_related_queston'] = $question_id;
	// 					$insert_record['ss_aw_related_queston_status'] = $answers_status;
	// 					$insert_record['ss_aw_time_elapsed'] = $time_elapsed;
	// 					$this->ss_aw_assesment_questions_asked_model->insert_record($insert_record);
	// 				}
	// 			}
	// 			$level = $question_detailsary[0]['ss_aw_level']; // E,C,A
	// 			$category = $question_detailsary[0]['ss_aw_category']; 
	// 			$sub_category = $question_detailsary[0]['ss_aw_sub_category']; 
	// 			$weight = $question_detailsary[0]['ss_aw_weight'];
	// 			$storedata = array();
	// 			$storedata['ss_aw_log_child_id'] = $child_id;
	// 			$storedata['ss_aw_log_question_id'] = $question_id;
	// 			$storedata['ss_aw_log_level'] = $level;
	// 			$storedata['ss_aw_log_category'] = $category;
	// 			$storedata['ss_aw_log_subcategory'] = $sub_category;
	// 			$storedata['ss_aw_log_answers'] = $answers_post;
	// 			$storedata['ss_aw_log_weight'] = $weight;
	// 			$storedata['ss_aw_log_right_answers'] = $right_answers;
	// 			$storedata['ss_aw_log_answer_status'] = $answers_status;  // 1 = Right, 2 = Wrong, 3= Skip
	// 			$storedata['ss_aw_log_start_answer_time'] = $seconds_to_start_answer_question;
	// 			$storedata['ss_aw_seconds_to_answer_question'] = $seconds_to_answer_question;
	// 			$storedata['ss_aw_log_exam_code'] = $exam_code;
	// 			$storedata['ss_aw_log_question_type'] = $question_format;
	// 			$storedata['ss_aw_log_topic_id'] = $question_topic_id;
	// 			$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
	// 			$updateary = array();
	// 			$updateary['ss_aw_assessment_question_id'] = $question_id;
	// 			$updateary['ss_aw_assessment_exam_code'] = $exam_code;
	// 			if($answers_status == 3) // 1 = Right, 2 = Wrong, 3= Skip
	// 			{	
	// 				$updateary['ss_aw_assessment_quiz_skip'] = 2;
	// 				$updateary['ss_aw_skip_once'] = 2;
	// 				//$updateary['ss_aw_skip_related_queston'] = 2;
	// 			}
	// 			else
	// 			{
	// 				$updateary['ss_aw_assessment_quiz_skip'] = 1;
	// 				$updateary['ss_aw_answers_status'] = $answers_status; // 1 = Right, 2 = Wrong, 3= Skip
	// 			}
	// 			$this->ss_aw_assesment_questions_asked_model->update_record($updateary);
	// 			$responseary['status'] = 200;
	// 			$responseary['msg'] = "Assessment test answers post successfully.";
	// 			$responseary['data'] = $finalquestionary;	
	// 		}
	// 		else
	// 		{
	// 			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
	// 				foreach ($error_array as $value){
	// 				$responseary['status'] = $value->ss_aw_error_status;
	// 				$responseary['msg'] = $value->ss_aw_error_msg;
	// 				$responseary['title'] = "Error";	
	// 				}			
	// 		}	
	// 		echo json_encode($responseary);
	// 		die(); 	
	// 	}
	// }

	public function store_assessment_exam_data()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP	

		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$exam_code = $inputpost['assessment_exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) :
				$this->check_parent_existance($parent_id, $child_token)
			) { // Check provider Token valid or not against child_id and token
				$question_id = $inputpost['question_id'];
				$answers_post = $inputpost['answers_post'];
				$right_answers = $inputpost['right_answers'];
				$answers_status = $inputpost['answers_status']; // 1 = Right, 2 = Wrong, 3= Skip
				$question_format = $inputpost['question_format'];
				$question_topic_id = $inputpost['topic_id'];
				$time_elapsed = $inputpost['time_elapsed'];
				$seconds_to_start_answer_question = $inputpost['seconds_to_start_answer_question'];
				$seconds_to_answer_question = $inputpost['seconds_to_answer_question'];
				$question_detailsary = array();
				$searchary = array();
				$searchary['ss_aw_id'] = $question_id;
				$question_detailsary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
				/* Get asnwered question details */
				$checksearchary = array();
				$checksearchary['ss_aw_assessment_exam_code'] = $exam_code;
				$checksearchary['ss_aw_assessment_question_id'] = $question_id;
				$checksearchary['ss_aw_child_id'] = $child_id;
				$question_skipedstatus = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($checksearchary);

				$finalquestionary = array();
				//Return new Record against both the wrong and Skip Question
				if ($answers_status != 1 && $question_skipedstatus[0]['ss_aw_skip_once'] != 2) { // 1 = Right, 2 = Wrong, 3= Skip
					$searchary = array();
					$newquestion = array();
					$searchary['ss_aw_uploaded_record_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
					$searchary['ss_aw_level'] = $question_detailsary[0]['ss_aw_level']; // E,C,A
					$searchary['ss_aw_category'] = $question_detailsary[0]['ss_aw_category'];
					$searchary['ss_aw_sub_category'] = $question_detailsary[0]['ss_aw_sub_category'];
					$ss_aw_seq_no = $question_detailsary[0]['ss_aw_seq_no'];
					$searchdata['ss_aw_quiz_type'] = $question_detailsary[0]['ss_aw_quiz_type'];
					do {
						$searchary['ss_aw_seq_no'] = $ss_aw_seq_no - 1;
						if ($searchary['ss_aw_seq_no'] <= 0) {
							break;
						}
						$checksearchary = array();
						//$checksearchary['ss_aw_calculated_seq_no'] = $searchary['ss_aw_seq_no'];
						$checksearchary['ss_aw_assessment_exam_code'] = $exam_code;
						$checksearchary['ss_aw_assessment_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
						$checksearchary['ss_aw_asked_sub_category'] = $searchary['ss_aw_sub_category'];
						$checksearchary['ss_aw_asked_category'] = $searchary['ss_aw_category'];
						$checksearchary['ss_aw_asked_level'] = $searchary['ss_aw_level'];
						$checksearchary['ss_aw_child_id'] = $child_id;
						/*
                          Check Question already asked or not using seq no
                         */
						$alreadyasked_questionary = array();
						$alreadyasked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($checksearchary);
						$alreadyaskedquestionidary = array();

						/* Already asked question ID array */
						if (!empty($alreadyasked_questionary)) {
							foreach ($alreadyasked_questionary as $value) {
								$alreadyaskedquestionidary[] = $value['ss_aw_assessment_question_id'];
							}
						}

						$newquestion = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
						if (!empty($newquestion)) {
							foreach ($newquestion as $value) {
								if (in_array($value['ss_aw_id'], $alreadyaskedquestionidary)) {
									$newquestion = array();
								}
							}
						}

						$ss_aw_seq_no = $searchary['ss_aw_seq_no'];
					} while (empty($newquestion));

					$i = 0;
					foreach ($newquestion as $value) {
						//if($i == 0)
						{
							$finalquestionary[$i]['question_id'] = $value['ss_aw_id'];
							$finalquestionary[$i]['level'] = $value['ss_aw_level'];
							$finalquestionary[$i]['format'] = $value['ss_aw_format'];

							if ($value['ss_aw_format'] == 'Single')
								$finalquestionary[$i]['format_id'] = 1;
							else
								$finalquestionary[$i]['format_id'] = 2;

							$finalquestionary[$i]['seq_no'] = $value['ss_aw_seq_no'];
							$finalquestionary[$i]['weight'] = $value['ss_aw_weight'];
							$finalquestionary[$i]['category'] = $value['ss_aw_category'];
							$finalquestionary[$i]['sub_category'] = $value['ss_aw_sub_category'];
							$finalquestionary[$i]['question_format'] = $value['ss_aw_question_format'];

							/* if($value['ss_aw_question_format'] == 'Choose the right answers')
                              $finalquestionary[$i]['question_format_id'] = 2; */
							if ($value['ss_aw_question_format'] == 'Choose the right answer')
								$finalquestionary[$i]['question_format_id'] = 2;
							else if ($value['ss_aw_question_format'] == 'Fill in the blanks')
								$finalquestionary[$i]['question_format_id'] = 1;
							else if ($value['ss_aw_question_format'] == 'Rewrite the sentence')
								$finalquestionary[$i]['question_format_id'] = 3;
							/* else if($value['ss_aw_question_format'] == 'Change the word to its comparative degree')
                              $finalquestionary[$i]['question_format_id'] = 4;
                              else if($value['ss_aw_question_format'] == 'Choose the right option')
                              $finalquestionary[$i]['question_format_id'] = 5;
                              else if($value['ss_aw_question_format'] == 'Convert to the comparative degree')
                              $finalquestionary[$i]['question_format_id'] = 6;
                              else if($value['ss_aw_question_format'] == 'Insert the adverb')
                              $finalquestionary[$i]['question_format_id'] = 7;
                              else if($value['ss_aw_question_format'] == 'Join the sentences')
                              $finalquestionary[$i]['question_format_id'] = 8;
                              else if($value['ss_aw_question_format'] == 'Place the article in the aprropraite place')
                              $finalquestionary[$i]['question_format_id'] = 9;
                              else if($value['ss_aw_question_format'] == 'Rewrite the sentence')
                              $finalquestionary[$i]['question_format_id'] = 10; */


							$finalquestionary[$i]['prefaceaudio'] = base_url() . $value['ss_aw_question_preface_audio'];
							$finalquestionary[$i]['preface'] = $value['ss_aw_question_preface'];
							$finalquestionary[$i]['question'] = trim($value['ss_aw_question']);

							$multiple_choice_ary = array();
							$multiple_choice_ary = explode("/", $value['ss_aw_multiple_choice']);

							if (count($multiple_choice_ary) > 1) {
								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								$finalquestionary[$i]['options'] = $multiple_choice_ary;
							} else {
								$finalquestionary[$i]['options'][0] = $value['ss_aw_multiple_choice'];
							}

							$finalquestionary[$i]['verb_form'] = $value['ss_aw_verb_form'];

							$answersary = array();
							$answersary = explode("/", trim($value['ss_aw_answers']));
							if (count($answersary) > 1) {
								$answersary = array_map('trim', $answersary);
								$finalquestionary[$i]['answers'] = $answersary;
							} else {
								$finalquestionary[$i]['answers'][0] = trim($value['ss_aw_answers']);
							}
							$finalquestionary[$i]['answeraudio'] = base_url() . trim($value['ss_aw_answers_audio']);
							$finalquestionary[$i]['rules'] = trim($value['ss_aw_rules']);

							$finalquestionary[$i]['hint'] = "";
							$finalquestionary[$i]['ruleaudio'] = base_url() . $value['ss_aw_rules_audio'];
							$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
							$i++;
						}

						$insert_record = array();

						$insert_record['ss_aw_assessment_exam_code'] = $exam_code;
						$insert_record['ss_aw_assessment_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
						$insert_record['ss_aw_calculated_seq_no'] = $value['ss_aw_seq_no'];
						$insert_record['ss_aw_child_id'] = $child_id;
						$insert_record['ss_aw_asked_level'] = $value['ss_aw_level'];
						$insert_record['ss_aw_asked_category'] = $value['ss_aw_category'];
						$insert_record['ss_aw_asked_sub_category'] = $value['ss_aw_sub_category'];
						$insert_record['ss_aw_assessment_question_id'] = $value['ss_aw_id'];
						$insert_record['ss_aw_skip_related_queston'] = $question_id;
						$insert_record['ss_aw_related_queston_status'] = $answers_status;
						$insert_record['ss_aw_time_elapsed'] = $time_elapsed;
						$this->ss_aw_assesment_questions_asked_model->insert_record($insert_record);
					}
				}

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
				$storedata['ss_aw_log_start_answer_time'] = $seconds_to_start_answer_question;
				$storedata['ss_aw_seconds_to_answer_question'] = $seconds_to_answer_question;
				$storedata['ss_aw_log_exam_code'] = $exam_code;
				$storedata['ss_aw_log_question_type'] = $question_format;
				$storedata['ss_aw_log_topic_id'] = $question_topic_id;

				$question_store_rules = $this->ss_aw_sections_topics_model->get_question_store_rules($question_topic_id); //get the rules
				//get singale sub category question count.
				$check_question_count = $this->ss_aw_assessment_exam_log_model->get_exam_question_count_according_subtopic($exam_code, $question_topic_id, $sub_category, true, ''); //skip question check false,true

				if ($check_question_count < $question_store_rules->ss_aw_total_question) { //check if the question count less inserted into the table.
					//check if question allready present
					$check_question = $this->ss_aw_assessment_exam_log_model->get_exam_question_count_according_subtopic($exam_code, $question_topic_id, $sub_category, false, $question_id);
					if ($check_question > 0 && $answers_status != 3) {
						$this->ss_aw_assessment_exam_log_model->update_record($storedata, array("ss_aw_log_exam_code" => $exam_code, "ss_aw_log_question_id" => $question_id));
					} else {
						$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
					}
				}

				$updateary = array();
				$updateary['ss_aw_assessment_question_id'] = $question_id;
				$updateary['ss_aw_assessment_exam_code'] = $exam_code;

				if ($answers_status == 3) { // 1 = Right, 2 = Wrong, 3= Skip
					$updateary['ss_aw_assessment_quiz_skip'] = 2;
					$updateary['ss_aw_skip_once'] = 2;
					//$updateary['ss_aw_skip_related_queston'] = 2;
				} else {
					$updateary['ss_aw_assessment_quiz_skip'] = 1;
					$updateary['ss_aw_answers_status'] = $answers_status; // 1 = Right, 2 = Wrong, 3= Skip
				}
				$this->ss_aw_assesment_questions_asked_model->update_record($updateary);

				$responseary['status'] = 200;
				$responseary['msg'] = "Assessment test answers post successfully.";
				$responseary['data'] = $finalquestionary;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function check_question_exist_assisment($subcategoryary, $exam_resultstatus = "", $counter = "")
	{
		$searchdata = array();
		$searchdata['ss_aw_level'] = $subcategoryary['ss_aw_level'];
		$searchdata['ss_aw_category'] = $subcategoryary['ss_aw_category'];
		$searchdata['ss_aw_quiz_type'] = $subcategoryary['ss_aw_quiz_type'];
		$searchdata['ss_aw_sub_category'] = $subcategoryary['ss_aw_sub_category'];
		//$searchdata['ss_aw_assessment_exam_code'] = $subcategoryary['ss_aw_assessment_exam_code'];
		//$searchdata['ss_aw_seq_no'] = $subcategoryary['ss_aw_seq_no'];
		$searchresultary = array();
		$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchdata);

		$final_ary = array();
		foreach ($searchresultary as $value) {
			if (intval($value['ss_aw_seq_no']) == intval($subcategoryary['ss_aw_seq_no'])) {
				$question_id = $value['ss_aw_id'];
				$paramary = array();
				$paramary['ss_aw_assessment_question_id'] = $question_id;
				$asked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($paramary);
				if (!$asked_questionary) {
					$final_ary[] = $value;
					return $final_ary;
				}
			}
		}

		foreach ($searchresultary as $value) {
			if (intval($value['ss_aw_seq_no']) > intval($subcategoryary['ss_aw_seq_no'])) {

				//echo $value['ss_aw_id'];
				$question_id = $value['ss_aw_id'];

				$paramary = array();
				$paramary['ss_aw_assessment_question_id'] = $question_id;
				$asked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($paramary);
				if (!$asked_questionary) {
					$final_ary[] = $value;
					return $final_ary;
				}
			}
		}

		foreach ($searchresultary as $value) {
			if (intval($value['ss_aw_seq_no']) < intval($subcategoryary['ss_aw_seq_no'])) {

				//echo $value['ss_aw_id'];
				$question_id = $value['ss_aw_id'];

				$paramary = array();
				$paramary['ss_aw_assessment_question_id'] = $question_id;
				$asked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($paramary);
				if (!$asked_questionary) {
					$final_ary[] = $value;
					return $final_ary;
				}
			}
		}
		$new_seq_no = $subcategoryary['ss_aw_seq_no'];
		foreach ($searchresultary as $value) {
			if (intval($value['ss_aw_seq_no']) == intval($new_seq_no)) {

				//echo $value['ss_aw_id'];
				$question_id = $value['ss_aw_id'];

				$paramary = array();
				$paramary['ss_aw_assessment_question_id'] = $question_id;
				$asked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($paramary);
				if (!$asked_questionary) {
					$final_ary[] = $value;
					return $final_ary;
				}
			}
			$new_seq_no = $new_seq_no - 1;
		}

		foreach ($searchresultary as $value) {
			if (intval($value['ss_aw_seq_no']) == intval($new_seq_no)) {

				//echo $value['ss_aw_id'];
				$question_id = $value['ss_aw_id'];

				$paramary = array();
				$paramary['ss_aw_assessment_question_id'] = $question_id;
				$asked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($paramary);
				if (!$asked_questionary) {
					$final_ary[] = $value;
					return $final_ary;
				}
			}
			$new_seq_no = $new_seq_no + 1;
		}


		die();
	}

	/*
      Get Lesson All list against
     */

	public function get_lessons_list()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);

				$level = $childary[count($childary) - 1]['ss_aw_course_id'];

				$previous_lesson_complete_count = 0;
				$previous_level = "";
				if ($level == 2) {
					$previous_level = "E";
				} elseif ($level == 3) {
					$previous_level = "C";
				}

				if (!empty($previous_level)) {
					$check_promotion = $this->ss_aw_promotion_model->get_promotion_detail($child_id, $previous_level);

					if (!empty($check_promotion)) {
						$previous_lesson_complete_count = $this->ss_aw_lesson_score_model->checklessoncompletebylevel($previous_level, $child_id);
					}
				}

				$childs_lessonsary = $this->ss_aw_child_last_lesson_model->fetch_details_lesson_list($child_id, $level);


				$topic_listary = array();
				$general_language_lessons = array();
				if ($level == 1 || $level == 2) {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'E';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
				} elseif ($level == 3) {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'C';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
					$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
				} else {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'A,M';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
				}
				$topicAry = array();
				if (!empty($topic_listary)) {
					foreach ($topic_listary as $key => $value) {
						$topicAry[] = $value->ss_aw_section_id;
					}
				}
				$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

				$lesson_listary = array_merge($topical_lessons, $general_language_lessons);

				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$course_purchase_date = $childary[count($childary) - 1]['ss_aw_child_course_create_date'];
				$completed_assessmentsary = array();
				$completed_assessmentsary = $this->ss_aw_assessment_exam_completed_model->fetch_details_byparam_withlessonupload($searchary, $course_purchase_date);

				$assessment_completedary = array();
				if (!empty($completed_assessmentsary)) {
					foreach ($completed_assessmentsary as $value) {
						$assessment_completedary[$value['ss_aw_lesson_id']] = $value['ss_aw_create_date'];
					}
				}

				/*
                  Create a array of running or completed Lessons LIST
                 */
				$runninglessonsary = array();
				$lessonsstartdateary = array();
				$completedlessonsary = array();
				$completedlessonsdateary = array();
				if (!empty($childs_lessonsary)) {
					foreach ($childs_lessonsary as $value2) {
						$lessonsstartdateary[$value2['ss_aw_lesson_id']] = $value2['ss_aw_last_lesson_create_date'];
						if ($value2['ss_aw_lesson_status'] == 1) {
							$runninglessonsary[] = $value2['ss_aw_lesson_id'];
						}
						if ($value2['ss_aw_lesson_status'] == 2) {
							$completedlessonsary[] = $value2['ss_aw_lesson_id'];
							$completedlessonsdateary[$value2['ss_aw_lesson_id']] = $value2['ss_aw_last_lesson_modified_date'];
						}
					}
				}

				$resultary = array();
				$prev_lesson_start_date_time = "";
				$prev_lesson_end_date_time = "";
				$prev_assessment_end_date_time = "";
				//Check if user give diagnostic//
				$diagnostic_complete_check = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);


				if (!empty($lesson_listary)) {
					$count = 0;
					$course_available = true;
					foreach ($lesson_listary as $key => $val) {
						$count++;
						if ($count <= $previous_lesson_complete_count) {
							$resultary[$key]['is_blocked'] = 1;
						} else {
							$resultary[$key]['is_blocked'] = 0;
						}
						if (!empty($diagnostic_complete_check) && $count == '1') {
							$course_available = true;
						} else {
							$course_available = $prev_assessment_end_date_time >= 0 && $prev_lesson_start_date_time > 6 ? true : false;
						}

						$resultary[$key]['lesson_end_date'] = "";
						$resultary[$key]['lesson_start_date'] = "";
						if (!empty($childs_lessonsary)) {
							if (in_array($val['ss_aw_lession_id'], $completedlessonsary)) {
								$resultary[$key]['lesson_status'] = 2;
								if (array_key_exists($val['ss_aw_lession_id'], $completedlessonsdateary)) {
									$resultary[$key]['lesson_end_date'] = $completedlessonsdateary[$val['ss_aw_lession_id']];
								}
							} else if (in_array($val['ss_aw_lession_id'], $runninglessonsary)) {
								$resultary[$key]['lesson_status'] = 1;
							} else {
								$resultary[$key]['lesson_status'] = 0;
							}



							foreach ($childs_lessonsary as $value2) {
								$resultary[$key]['lesson_id'] = $val['ss_aw_lession_id'];
								$resultary[$key]['topic_title'] = $val['ss_aw_lesson_topic'];
							}

							if ($val['ss_aw_lesson_format'] == 'Single')
								$resultary[$key]['lesson_format_id'] = 1;
							else
								$resultary[$key]['lesson_format_id'] = 2;

							if (array_key_exists($val['ss_aw_lession_id'], $lessonsstartdateary)) {
								$resultary[$key]['lesson_start_date'] = $lessonsstartdateary[$val['ss_aw_lession_id']];
							}

							$prev_lesson_start_date_time = $resultary[$key]['lesson_start_date'] != '' ? daysDifferent(strtotime(date_format(date_create($resultary[$key]['lesson_start_date']), 'Y-m-d')), strtotime(date('Y-m-d'))) : "";
							$prev_lesson_end_date_time = $resultary[$key]['lesson_end_date'] != '' ? daysDifferent(strtotime(date_format(date_create($resultary[$key]['lesson_end_date']), 'Y-m-d')), strtotime(date('Y-m-d'))) : "";
						} else {
							$resultary[$key]['lesson_format'] = $val['ss_aw_lesson_format'];
							if ($val['ss_aw_lesson_format'] == 'Single')
								$resultary[$key]['lesson_format_id'] = 1;
							else
								$resultary[$key]['lesson_format_id'] = 2;

							$resultary[$key]['lesson_id'] = $val['ss_aw_lession_id'];
							$resultary[$key]['topic_title'] = $val['ss_aw_lesson_topic'];
							$resultary[$key]['lesson_status'] = 0; // 0 = Not started, 1 = Running, = 2 = Completed
						}
						if (!empty($assessment_completedary[$val['ss_aw_lession_id']])) {
							$resultary[$key]['assessment_status'] = 2;
							$resultary[$key]['assessment_end_date'] = $assessment_completedary[$val['ss_aw_lession_id']];
						} else {
							$resultary[$key]['assessment_status'] = 0;
							$resultary[$key]['assessment_end_date'] = "";
						}
						$prev_assessment_end_date_time = $resultary[$key]['assessment_end_date'] != '' ? daysDifferent(strtotime(date_format(date_create($resultary[$key]['assessment_end_date']), 'Y-m-d')), strtotime(date('Y-m-d'))) : "";


						$resultary[$key]['is_demo'] = $val['ss_aw_is_demo'];

						$resultary[$key]['is_available'] = $course_available == true || $resultary[$key]['lesson_start_date'] != "" ? 1 : 0;
					}
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data Found';
					$responseary['result'] = $resultary;
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function finish_lesson()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = $childary[count($childary) - 1]['ss_aw_course_id'];
				if ($level == 1) {
					$course_code = "E";
				} elseif ($level == 2) {
					$course_code = "C";
				} else {
					$course_code = "A";
				}

				$chk_completion = $this->ss_aw_course_completion_model->getcoursecompletionRow($child_id, $level, 1);

				if (!empty($chk_completion)) {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Lesson exam record already exist.';
					die(json_encode($responseary));
				}

				$lesson_id = $inputpost['lesson_id'];

				$data = array();
				$data['child_id'] = $child_id;
				$data['lesson_id'] = $lesson_id;
				$data['level_id'] = $level;
				$data['ss_aw_lesson_status'] = 2; // 1 = Completed ,2 = Running
				$data['ss_aw_last_lesson_modified_date'] = date('Y-m-d H:i:s');
				$data['ss_aw_back_click_count'] = $inputpost['back_click_count'];
				$response = $this->ss_aw_child_last_lesson_model->update_details($data);
				//autofill question according to lesson if not asked
				$this->lesson_data_checking($child_id, $lesson_id, $level);

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
				$this->ss_aw_lesson_score_model->store_data($store_score);
				//end

				if ($response) {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Lesson completed successfully';

					//send notification code
					$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

					$child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id);
					$gender = $child_profile[0]->ss_aw_child_gender;
					$gender_noun = "";
					$gender_pronoun = "";
					if ($gender == 1) {
						$gender_noun = "he";
						$gender_pronoun = "his";
					} else {
						$gender_noun = "she";
						$gender_pronoun = "her";
					}
					$child_name = $child_profile[0]->ss_aw_child_nick_name;

					$lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);

					$lesson_name = $lesson_detail[0]->ss_aw_lesson_topic;

					$lesson_listary = $this->ss_aw_lessons_uploaded_model->get_course_lesson_list($level);
					$serial_ary = array();
					if (!empty($lesson_listary)) {
						$lesson_count = 1;
						foreach ($lesson_listary as $key => $value) {
							$serial_ary[$value['ss_aw_lession_id']] = $lesson_count;
							$lesson_count++;
						}
					}
					$serial_no = 0;
					if (!empty($serial_ary)) {
						$serial_no = $serial_ary[$lesson_id];
					}
					//get assessment of lesson
					$assessment_detail = $this->ss_aw_assesment_uploaded_model->get_assessment_by_lesson_id($lesson_id);
					$assessment_name = "";
					if (!empty($assessment_detail)) {
						$assessment_name = $assessment_detail[0]->ss_aw_assesment_topic;
					}

					if (empty($child_profile[0]->ss_aw_is_self) && empty($child_profile[0]->ss_aw_institution_user_upload_id)) {
						if (!empty($parent_detail)) {
							$email_template = getemailandpushnotification(10, 1, 1);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_name, $body);
								$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
								$body = str_ireplace("[@@gender@@]", $gender_noun, $body);
								$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);

								$send_data = array(
									'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
									'ss_aw_subject' => $email_template['title'],
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);

								//emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
							}

							$app_template = getemailandpushnotification(10, 2, 1);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
								$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_name, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
								$body = str_ireplace("[@@gender@@]", $gender_noun, $body);
								$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
								$title = $app_template['title'];
								$token = $parent_detail[0]->ss_aw_device_token;

								pushnotification($title, $body, $token, 15);

								$save_data = array(
									'user_id' => $parent_detail[0]->ss_aw_parent_id,
									'user_type' => 1,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => 15
								);

								save_notification($save_data);
							}
						}
					}


					if (!empty($child_profile)) {
						$email_template = getemailandpushnotification(10, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
							$body = str_ireplace("[@@username@@]", $child_name, $body);
							$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
							$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
							$send_data = array(
								'ss_aw_email' => $child_profile[0]->ss_aw_child_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
							//emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
						}

						$app_template = getemailandpushnotification(10, 2, 2);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
							$body = str_ireplace("[@@username@@]", $child_name, $body);
							$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
							$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
							$title = $app_template['title'];
							$token = $child_profile[0]->ss_aw_device_token;

							//pushnotification($title,$body,$token,2);
							pushnotification($title, $body, $token, 14);

							$save_data = array(
								'user_id' => $child_profile[0]->ss_aw_child_id,
								'user_type' => 2,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => 14
							);

							save_notification($save_data);
						}
					}
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1030');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function get_lesson_details_list()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childdetailsary = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
				$child_age = calculate_age($childdetailsary[0]->ss_aw_child_dob);

				$lesson_id = ($inputpost['lesson_id']);
				$lesson_upload_details = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
				$lesson_serial_no = $lesson_upload_details[0]->ss_aw_sl_no;
				//Get Current Lesson status
				$lessonary = array();
				$lessonary['ss_aw_lesson_id'] = $lesson_id;
				$lessonary['ss_aw_child_id'] = $child_id;
				$current_lesson_response = $this->ss_aw_current_lesson_model->fetch_record_byparam($lessonary); //Currently Reading Page

				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];

				if ($level_id == 1 || $level_id == 2) {
					if ($child_age < 13) {
						if ($lesson_serial_no > 10) {
							$fetch_level_id = 2;
						} else {
							$fetch_level_id = 1;
						}
					} else {
						$fetch_level_id = 2;
					}
				} elseif ($level_id == 5) {
					if ($lesson_serial_no <= 10) {
						$fetch_level_id = 2;
					} elseif ($lesson_serial_no > 10 && $lesson_serial_no < 56) {
						$fetch_level_id = 3;
					} else {
						$fetch_level_id = 4;
					}
				} else {
					$fetch_level_id = 3;
				}

				$searchary = array();
				$searchary['ss_aw_lesson_record_id'] = $lesson_id;
				$searchary['ss_aw_course_id'] = $fetch_level_id;
				$lessonary = $this->ss_aw_lessons_model->search_data_by_param($searchary);

				$all_page_count = $this->ss_aw_lessons_model->alldatacountbyparam($searchary);
				/*
                  Start Lesson
                 */
				$startcourse = array();
				$startcourse['ss_aw_child_id'] = $child_id;
				$startcourse['ss_aw_lesson_level'] = $level_id;
				$startcourse['ss_aw_lesson_id'] = $lesson_id;
				$lastlesson_response = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($startcourse);
				if (empty($lastlesson_response)) {
					$startcourse['ss_aw_lesson_format'] = $lessonary[0]['ss_aw_lesson_format'];
					$startcourse['ss_aw_last_lesson_create_date'] = date('Y-m-d H:i:s');
					$this->ss_aw_child_last_lesson_model->data_insert($startcourse);
				}

				if ($level_id == 2) {
					$level = 'C';
				} else if ($level_id == 1) {
					$level = 'E';
				} else if ($level_id == 3) {
					$level = 'A';
				}

				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

				$resultary = array();
				$resultary['course'] = $level;
				$resultary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$resultary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$resultary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$resultary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
				if ($lessonary[0]['ss_aw_lesson_format'] == 'Multiple') {
					$resultary['lesson_quiz_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_general_language_correct;
					$resultary['lesson_quiz_bad_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_general_language_incorrect;
					$resultary['lesson_quiz_bad_audio2'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_general_language_incorrect2;
				} else {
					$resultary['lesson_quiz_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_topical_lesson_correct;
					$resultary['lesson_quiz_bad_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_topical_lesson_incorrect;
					$resultary['lesson_quiz_bad_audio2'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_topical_lesson_incorrect2;
				}

				if (!empty($current_lesson_response[0]['ss_aw_lesson_index']))
					$resultary['current_page_index'] = $current_lesson_response[0]['ss_aw_lesson_index'];
				else
					$resultary['current_page_index'] = "";

				if (!empty($current_lesson_response[0]['ss_aw_back_click_count'])) {
					$resultary['back_click_count'] = $current_lesson_response[0]['ss_aw_back_click_count'];
				} else {
					$resultary['back_click_count'] = "";
				}

				if (!empty($lessonary)) {
					if ($lessonary[0]['ss_aw_lesson_format'] == 'Multiple') {
						/////////////// First Data section ///////////////////////////////
						$i = 0;
						$resultary_inner1 = array();
						foreach ($lessonary as $key => $val) {
							if ($i == 0) {
								$useindexary[] = $val['ss_aw_lession_id'];
								$resultary_inner1['index'] = $val['ss_aw_lession_id'];
								$resultary_inner1['title'] = strip_tags($val['ss_aw_lesson_title']);

								$resultary_inner1['lesson_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner1['type'] = 1;  // 1 = Text, 2= Quiz
								$resultary_inner1['comprehension_question'] = 0;

								//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];

								if (!empty($val['ss_aw_lesson_audio'])) {
									$resultary_inner1['audio'] = base_url() . $val['ss_aw_lesson_audio'];
								} else {
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
						///////////////////////////////////////////////////////////////////////////////////
						$lessonaryinterm = array();
						foreach ($lessonary as $key => $val) {
							if ($key > 0)
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
						foreach ($lessonary as $key => $val) {
							if ($i == 0) {
								$useindexary[] = $val['ss_aw_lession_id'];
								$resultary_inner2['index'] = $val['ss_aw_lession_id'];
								$resultary_inner2['title'] = strip_tags($val['ss_aw_lesson_title']);

								$resultary_inner2['lesson_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner2['type'] = 1;  // 1 = Text, 2= Quiz
								$resultary_inner2['comprehension_question'] = 1;

								//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];

								if (!empty($val['ss_aw_lesson_audio'])) {
									$resultary_inner2['audio'] = base_url() . $val['ss_aw_lesson_audio'];
								} else {
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
						foreach ($lessonary as $key => $val) {
							if ($i == 0) {
								$useindexary[] = $val['ss_aw_lession_id'];
								$resultary_inner['index'] = $val['ss_aw_lession_id'];
								$resultary_inner['title'] = strip_tags($val['ss_aw_lesson_details']);

								$resultary_inner['lesson_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner['type'] = 2;  // 1 = Text, 2= Quiz
								$resultary_inner['comprehension_question'] = 1;

								//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];

								if (!empty($val['ss_aw_lesson_details_audio'])) {
									$resultary_inner['audio'] = base_url() . $val['ss_aw_lesson_details_audio'];
									$resultary_inner['audio_slow'] = base_url() . $val['ss_aw_lesson_details_audio_slow'];
									$resultary_inner['audio_fast'] = base_url() . $val['ss_aw_lesson_details_audio_fast'];
								} else {
									$resultary_inner['audio'] = "";
									$resultary_inner['audio_slow'] = "";
									$resultary_inner['audio_fast'] = "";
								}
								//$resultary['data'][0]['recap'] = 0;
								$resultary_inner['details']['course'] = $val['ss_aw_course_id'];

								$resultary_inner['details']['quizes'][0]['topic_id'] = $val['ss_aw_lesson_topic'];
								$resultary_inner['details']['quizes'][0]['question'] = "";
								$resultary_inner['details']['quizes'][0]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
								$resultary_inner['details']['quizes'][0]['question_id'] = $val['ss_aw_lession_id'];

								//check question answered before or not.
								$question_details = str_replace("\n", "", $val['ss_aw_lesson_details']);
								$question_details = trim($question_details);
								$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($question_details, $child_id);

								if (!empty($check_question)) {
									$resultary_inner['details']['quizes'][0]['answered'] = 1;
									if ($check_question[0]->ss_aw_answer_status == 1) {
										$resultary_inner['details']['quizes'][0]['correct'] = 1;
									} else {
										$resultary_inner['details']['quizes'][0]['correct'] = 0;
									}
								} else {
									$resultary_inner['details']['quizes'][0]['answered'] = 0;
								}
								//end of checking

								$multiple_choice_ary = array();
								//$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
								$multiple_choice_ary = explode("/", trim($val['ss_aw_lesson_question_options']));

								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								if (!empty($multiple_choice_ary))
									$resultary_inner['details']['quizes'][0]['options'] = $multiple_choice_ary;
								else
									$resultary_inner['details']['quizes'][0]['options'] = array();

								$answersary = array();
								$answersary = explode("/", trim(strip_tags($val['ss_aw_lesson_answers'])));

								$answersary = array_map('trim', $answersary);
								if (!empty($answersary)) {
									$resultary_inner['details']['quizes'][0]['answers'] = $answersary;
									$resultary_inner['details']['quizes'][0]['answeraudio'] = base_url() . $val['ss_aw_lesson_answers_audio'];
									$resultary_inner['details']['quizes'][0]['answeraudio_slow'] = base_url() . $val['ss_aw_lesson_answers_audio_slow'];
									$resultary_inner['details']['quizes'][0]['answeraudio_fast'] = base_url() . $val['ss_aw_lesson_answers_audio_fast'];
								} else {
									$resultary_inner['details']['quizes'][0]['answers'] = array();
									$resultary_inner['details']['quizes'][0]['answeraudio'] = "";
									$resultary_inner['details']['quizes'][0]['answeraudio_slow'] = "";
									$resultary_inner['details']['quizes'][0]['answeraudio_fast'] = "";
								}
							}
							$i++;
						}

						array_push($resultary['data'], $resultary_inner);

						$resultary_inner3 = array();

						$i = 0;
						$j = 0;
						foreach ($lessonary as $key => $val) {

							if (($i > 0) && trim($firstvalue) == trim($val['ss_aw_lesson_title'])) {
								$useindexary[] = $val['ss_aw_lession_id'];
								$resultary_inner3[$j]['index'] = $val['ss_aw_lession_id'];
								$resultary_inner3[$j]['title'] = strip_tags($val['ss_aw_lesson_details']);

								$resultary_inner3[$j]['lesson_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner3[$j]['type'] = 2;  // 1 = Text, 2= Quiz
								$resultary_inner3[$j]['comprehension_question'] = 1;

								//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];

								if (!empty($val['ss_aw_lesson_details_audio'])) {
									$resultary_inner3[$j]['audio'] = base_url() . $val['ss_aw_lesson_details_audio'];
									$resultary_inner3[$j]['audio_slow'] = base_url() . $val['ss_aw_lesson_details_audio_slow'];
									$resultary_inner3[$j]['audio_fast'] = base_url() . $val['ss_aw_lesson_details_audio_fast'];
								} else {
									$resultary_inner3[$j]['audio'] = "";
									$resultary_inner3[$j]['audio_slow'] = "";
									$resultary_inner3[$j]['audio_fast'] = "";
								}
								//$resultary['data'][0]['recap'] = 0;
								$resultary_inner3[$j]['details']['course'] = $val['ss_aw_course_id'];

								$resultary_inner3[$j]['details']['quizes'][0]['topic_id'] = $val['ss_aw_lesson_topic'];
								$resultary_inner3[$j]['details']['quizes'][0]['question'] = "";
								$resultary_inner3[$j]['details']['quizes'][0]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
								$resultary_inner3[$j]['details']['quizes'][0]['question_id'] = $val['ss_aw_lession_id'];

								//check question answered before or not.
								$question_details = str_replace("\n", "", $val['ss_aw_lesson_details']);
								$question_details = trim($question_details);
								$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($question_details, $child_id);
								if (!empty($check_question)) {
									$resultary_inner3[$j]['details']['quizes'][0]['answered'] = 1;
									if ($check_question[0]->ss_aw_answer_status == 1) {
										$resultary_inner3[$j]['details']['quizes'][0]['correct'] = 1;
									} else {
										$resultary_inner3[$j]['details']['quizes'][0]['correct'] = 0;
									}
								} else {
									$resultary_inner3[$j]['details']['quizes'][0]['answered'] = 0;
								}
								//end of checking

								$multiple_choice_ary = array();
								//$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
								$multiple_choice_ary = explode("/", trim($val['ss_aw_lesson_question_options']));

								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								if (!empty($multiple_choice_ary))
									$resultary_inner3[$j]['details']['quizes'][0]['options'] = $multiple_choice_ary;
								else
									$resultary_inner3[$j]['details']['quizes'][0]['options'] = array();

								$answersary = array();
								$answersary = explode("/", trim(strip_tags($val['ss_aw_lesson_answers'])));

								$answersary = array_map('trim', $answersary);
								if (!empty($answersary)) {
									$resultary_inner3[$j]['details']['quizes'][0]['answers'] = $answersary;
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = base_url() . $val['ss_aw_lesson_answers_audio'];
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_slow'] = base_url() . $val['ss_aw_lesson_answers_audio_slow'];
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_fast'] = base_url() . $val['ss_aw_lesson_answers_audio_fast'];
								} else {
									$resultary_inner3[$j]['details']['quizes'][0]['answers'] = array();
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = "";
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_slow'] = "";
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_fast'] = "";
								}

								$j++;
							}
							$i++;
						}
						foreach ($resultary_inner3 as $value)
							array_push($resultary['data'], $value);



						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						$i = $j + 2;

						$previous_title = "";
						$firstvalue = trim($lessonary[0]['ss_aw_lesson_title']);
						foreach ($lessonary as $key => $val) {
							if (!in_array($val['ss_aw_lession_id'], $useindexary)) {
								if ($firstvalue != trim($val['ss_aw_lesson_title'])) {
									if ($previous_title != trim($val['ss_aw_lesson_title'])) {
										$i++;
										$j = 0;
										$r = 0;
									} else if ($previous_title == trim($val['ss_aw_lesson_title'])) {
										if (!empty($val['ss_aw_lesson_details']))
											$j++;
									}
									$previous_title = trim($val['ss_aw_lesson_title']);

									$resultary['data'][$i]['index'] = $val['ss_aw_lession_id'];
									if ($val['ss_aw_lesson_format'] == 'Single')
										$resultary['data'][$i]['lesson_format'] = 1;
									else
										$resultary['data'][$i]['lesson_format'] = 2;

									$resultary['data'][$i]['type'] = 2;
									$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
									$resultary['data'][$i]['title'] = strip_tags($val['ss_aw_lesson_title']);
									if (!empty($val['ss_aw_lesson_audio'])) {
										$resultary['data'][$i]['audio'] = base_url() . $val['ss_aw_lesson_audio'];
										$resultary['data'][$i]['audio_slow'] = base_url() . $val['ss_aw_lesson_audio_slow'];
										$resultary['data'][$i]['audio_fast'] = base_url() . $val['ss_aw_lesson_audio_fast'];
									} else {
										$resultary['data'][$i]['audio'] = "";
										$resultary['data'][$i]['audio_slow'] = "";
										$resultary['data'][$i]['audio_fast'] = "";
									}

									$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);

									$resultary['data'][$i]['details']['examples'] = array();

									if ($val['ss_aw_lesson_quiz_type_id'] > 0) {
										$resultary['data'][$i]['details']['quizes'][$j]['topic_id'] = $val['ss_aw_lesson_topic'];
										$resultary['data'][$i]['details']['quizes'][$j]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
										$resultary['data'][$i]['details']['quizes'][$j]['question'] = strip_tags($val['ss_aw_lesson_details']);
										$resultary['data'][$i]['details']['quizes'][$j]['question_id'] = $val['ss_aw_lession_id'];

										//check question answered before or not.
										$question_details = str_replace("\n", "", $val['ss_aw_lesson_details']);
										$question_details = trim($question_details);
										$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($question_details, $child_id);
										if (!empty($check_question)) {
											$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 1;
											if ($check_question[0]->ss_aw_answer_status == 1) {
												$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 1;
											} else {
												$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 0;
											}
										} else {
											$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 0;
										}
										//end of checking

										$multiple_choice_ary = array();
										//$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
										$multiple_choice_ary = explode("/", trim($val['ss_aw_lesson_question_options']));

										$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
										//if(count($multiple_choice_ary) > 1)
										$resultary['data'][$i]['details']['quizes'][$j]['options'] = $multiple_choice_ary;
										//else
										//$resultary['data'][$i]['details']['quizes'][$j]['options'] = $val['ss_aw_lesson_question_options'];

										$answersary = array();
										$answersary = explode("/", trim(strip_tags($val['ss_aw_lesson_answers'])));

										$answersary = array_map('trim', $answersary);

										$resultary['data'][$i]['details']['quizes'][$j]['answers'] = $answersary;
										//$resultary['data'][$i]['details']['quizes'][$j]['answer'] = $val['ss_aw_lesson_answers'];
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = base_url() . $val['ss_aw_lesson_answers_audio'];
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_slow'] = base_url() . $val['ss_aw_lesson_answers_audio_slow'];
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_fast'] = base_url() . $val['ss_aw_lesson_answers_audio_fast'];
									} else {
										$resultary['data'][$i]['details']['quizes'] = array();
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = "";
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_slow'] = "";
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_fast'] = "";
									}
								}
							}
						}


						//array_splice($resultary['data'],1,1);

						$responseary['status'] = '200';
						$responseary['msg'] = 'Data Found';
						$responseary['result'] = $resultary;
					} else { // Single Section Start FRom HERE
						$resultary['topic_id'] = $lessonary[0]['ss_aw_lesson_topic'];
						$i = 0;
						$j = 0;
						$r = 0;
						$previous_title = $lessonary[0]['ss_aw_lesson_title'];
						$resultary['data'][$i]['index'] = $lessonary[0]['ss_aw_lession_id'];
						if ($lessonary[0]['ss_aw_lesson_format'] == 'Single')
							$resultary['data'][$i]['lesson_format'] = 1;
						else
							$resultary['data'][$i]['lesson_format'] = 2;

						$resultary['data'][$i]['type'] = $lessonary[0]['ss_aw_lesson_format_type'];
						$resultary['data'][$i]['topic_format_id'] = $lessonary[0]['ss_aw_topic_format_id'];
						$resultary['data'][$i]['title'] = strip_tags($lessonary[0]['ss_aw_lesson_title']);
						if (!empty($lessonary[0]['ss_aw_lesson_audio'])) {
							$resultary['data'][$i]['audio'] = base_url() . $lessonary[0]['ss_aw_lesson_audio'];
							$resultary['data'][$i]['audio_slow'] = base_url() . $lessonary[0]['ss_aw_lesson_audio_slow'];
							$resultary['data'][$i]['audio_fast'] = base_url() . $lessonary[0]['ss_aw_lesson_audio_fast'];
						} else {
							$resultary['data'][$i]['audio'] = "";
							$resultary['data'][$i]['audio_slow'] = "";
							$resultary['data'][$i]['audio_fast'] = "";
						}
						if (strtolower($lessonary[0]['ss_aw_lessons_recap']) == 'yes')
							$resultary['data'][$i]['recap'] = 1;
						else
							$resultary['data'][$i]['recap'] = 0;
						$resultary['data'][$i]['details']['course'] = intval($lessonary[0]['ss_aw_course_id']);
						$resultary['data'][$i]['details']['duration'] = $idletime;
						if (!empty($lessonary[0]['ss_aw_lesson_details'])) {
							$resultary['data'][$i]['details']['examples'][$j]['subindex'] = $j;
							$resultary['data'][$i]['details']['examples'][$j]['data'] = strip_tags($lessonary[0]['ss_aw_lesson_details']);
							if (!empty($lessonary[0]['ss_aw_lesson_details_audio'])) {
								$resultary['data'][$i]['details']['examples'][$j]['audio'] = base_url() . $lessonary[0]['ss_aw_lesson_details_audio_slow'];
								$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = base_url() . $lessonary[0]['ss_aw_lesson_details_audio'];
								$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = base_url() . $lessonary[0]['ss_aw_lesson_details_audio_fast'];
							} else {
								$resultary['data'][$i]['details']['examples'][$j]['audio'] = "";
								$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = "";
								$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = "";
							}
							if (strtolower($lessonary[0]['ss_aw_lessons_recap']) == 'yes')
								$resultary['data'][$i]['details']['examples'][$j]['recap'] = 1;
							else
								$resultary['data'][$i]['details']['examples'][$j]['recap'] = 0;
						} else {
							$resultary['data'][$i]['details']['examples'] = array();
						}
						$resultary['data'][$i]['details']['course'] = intval($lessonary[0]['ss_aw_course_id']);
						if ($lessonary[0]['ss_aw_lesson_quiz_type_id'] > 0) {
							$resultary['data'][$i]['details']['quizes'][0]['qtype'] = $lessonary[0]['ss_aw_lesson_quiz_type_id'];
							$resultary['data'][$i]['details']['quizes'][0]['question'] = ($lessonary[0]['ss_aw_lesson_details']);
							$resultary['data'][$i]['details']['quizes'][0]['question_id'] = $lessonary[0]['ss_aw_lession_id'];

							//check question answered before or not.
							$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($lessonary[0]['ss_aw_lesson_details'], $child_id);
							if (!empty($check_question)) {
								$resultary['data'][$i]['details']['quizes'][0]['answered'] = 1;
								if ($check_question[0]->ss_aw_answer_status == 1) {
									$resultary['data'][$i]['details']['quizes'][0]['correct'] = 1;
								} else {
									$resultary['data'][$i]['details']['quizes'][0]['correct'] = 0;
								}
							} else {
								$resultary['data'][$i]['details']['quizes'][0]['answered'] = 0;
							}
							//end of checking

							$multiple_choice_ary = array();
							$multiple_choice_ary = explode(",", trim($lessonary[0]['ss_aw_lesson_question_options']));

							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
							//if(count($multiple_choice_ary) > 1)
							$resultary['data'][$i]['details']['quizes'][0]['options'] = $multiple_choice_ary;
							//else
							//$resultary['data'][$i]['details']['quizes'][0]['options'] = $lessonary[0]['ss_aw_lesson_question_options'];

							$answersary = array();
							$answersary = explode("/", trim(strip_tags($lessonary[0]['ss_aw_lesson_answers'])));
							$answersary = array_map('trim', $answersary);
							$resultary['data'][$i]['details']['quizes'][0]['answers'] = $answersary;

							$resultary['data'][$i]['details']['quizes'][0]['answeraudio'] = base_url() . $lessonary[0]['ss_aw_lesson_answers_audio'];
							$resultary['data'][$i]['details']['quizes'][0]['answeraudio_slow'] = base_url() . $lessonary[0]['ss_aw_lesson_answers_audio_slow'];
							$resultary['data'][$i]['details']['quizes'][0]['answeraudio_fast'] = base_url() . $lessonary[0]['ss_aw_lesson_answers_audio_fast'];
						} else {
							$resultary['data'][$i]['details']['quizes'] = array();
							$resultary['data'][$i]['details']['quizes'][0]['answeraudio'] = "";
							$resultary['data'][$i]['details']['quizes'][0]['answeraudio_slow'] = "";
							$resultary['data'][$i]['details']['quizes'][0]['answeraudio_fast'] = "";
						}
						foreach ($lessonary as $key => $val) {
							if ($previous_title != $val['ss_aw_lesson_title']) {
								$i++;
								$j = 0;
								$r = 0;
							} else if ($previous_title == $val['ss_aw_lesson_title']) {
								if (!empty($val['ss_aw_lesson_details']) && $key != 0)
									$j++;
							}
							$previous_title = $val['ss_aw_lesson_title'];

							$resultary['data'][$i]['index'] = $val['ss_aw_lession_id'];
							if ($val['ss_aw_lesson_format'] == 'Single')
								$resultary['data'][$i]['lesson_format'] = 1;
							else
								$resultary['data'][$i]['lesson_format'] = 2;

							$resultary['data'][$i]['type'] = $val['ss_aw_lesson_format_type'];
							$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
							$resultary['data'][$i]['title'] = strip_tags($val['ss_aw_lesson_title']);
							if (!empty($val['ss_aw_lesson_audio'])) {
								$resultary['data'][$i]['audio'] = base_url() . $val['ss_aw_lesson_audio'];
								$resultary['data'][$i]['audio_slow'] = base_url() . $val['ss_aw_lesson_audio_slow'];
								$resultary['data'][$i]['audio_fast'] = base_url() . $val['ss_aw_lesson_audio_fast'];
							} else {
								$resultary['data'][$i]['audio'] = "";
								$resultary['data'][$i]['audio_slow'] = "";
								$resultary['data'][$i]['audio_fast'] = "";
							}
							if (strtolower($val['ss_aw_lessons_recap']) == 'yes' && $r == 0) {
								$r++;
								$resultary['data'][$i]['recap'] = 1;
							} else if ($r == 0) {
								$resultary['data'][$i]['recap'] = 0;
							}

							$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);
							$resultary['data'][$i]['details']['duration'] = $idletime;
							if ($val['ss_aw_lesson_format_type'] != 2) {
								if (!empty($val['ss_aw_lesson_details'])) {
									$resultary['data'][$i]['details']['examples'][$j]['subindex'] = $j;
									$resultary['data'][$i]['details']['examples'][$j]['data'] = strip_tags($val['ss_aw_lesson_details']);
									if (!empty($val['ss_aw_lesson_details_audio'])) {
										$resultary['data'][$i]['details']['examples'][$j]['audio'] = base_url() . $val['ss_aw_lesson_details_audio'];
										$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = base_url() . $val['ss_aw_lesson_details_audio_slow'];
										$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = base_url() . $val['ss_aw_lesson_details_audio_fast'];
									} else {
										$resultary['data'][$i]['details']['examples'][$j]['audio'] = "";
										$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = "";
										$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = "";
									}

									if (strtolower($val['ss_aw_lessons_recap']) == 'yes')
										$resultary['data'][$i]['details']['examples'][$j]['recap'] = 1;
									else
										$resultary['data'][$i]['details']['examples'][$j]['recap'] = 0;
									//$resultary['data'][$i]['details']['example']['audio'] = $val['ss_aw_lesson_audio'];
									$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);
								} else {
									$resultary['data'][$i]['details']['examples'] = array();
								}
							} else {
								$resultary['data'][$i]['details']['examples'] = array();
							}

							if ($val['ss_aw_lesson_quiz_type_id'] > 0) {
								$resultary['data'][$i]['details']['quizes'][$j]['qtype'] = $val['ss_aw_lesson_quiz_type_id'];
								$resultary['data'][$i]['details']['quizes'][$j]['question'] = strip_tags($val['ss_aw_lesson_details']);

								//check question answered before or not.
								$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($val['ss_aw_lesson_details'], $child_id);
								if (!empty($check_question)) {
									$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 1;
									if ($check_question[0]->ss_aw_answer_status == 1) {
										$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 1;
									} else {
										$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 0;
									}
								} else {
									$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 0;
								}
								//end of checking

								$multiple_choice_ary = array();
								$multiple_choice_ary = explode(",", trim($val['ss_aw_lesson_question_options']));

								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								//if(count($multiple_choice_ary) > 1)
								$resultary['data'][$i]['details']['quizes'][$j]['options'] = $multiple_choice_ary;
								//else
								//$resultary['data'][$i]['details']['quizes'][$j]['options'] = $val['ss_aw_lesson_question_options'];

								$answersary = array();
								$answersary = explode("/", trim(strip_tags($val['ss_aw_lesson_answers'])));

								$answersary = array_map('trim', $answersary);

								$resultary['data'][$i]['details']['quizes'][$j]['answers'] = $answersary;
								//$resultary['data'][$i]['details']['quizes'][$j]['answer'] = $val['ss_aw_lesson_answers'];
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = base_url() . $val['ss_aw_lesson_answers_audio'];
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_slow'] = base_url() . $val['ss_aw_lesson_answers_audio_slow'];
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_fast'] = base_url() . $val['ss_aw_lesson_answers_audio_fast'];
								$resultary['data'][$i]['details']['quizes'][$j]['question_id'] = $val['ss_aw_lession_id'];
							} else {
								$resultary['data'][$i]['details']['quizes'] = array();
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = "";
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_slow'] = "";
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_fast'] = "";
							}
						}
						//array_splice($resultary['data'],1,1);
						$responseary['status'] = '200';
						$responseary['msg'] = 'Data Found';
						$responseary['result'] = $resultary;
					}
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function change_password()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			if ($this->check_child_existance($child_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$old_password = $inputpost['old_password'];
				$password = $inputpost['password'];
				$result = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
				$child_password = $result[0]->ss_aw_child_password;
				if ($this->bcrypt->check_password($old_password, $child_password)) {
					$hash_pass = $this->bcrypt->hash_password($password);
					$result = $this->ss_aw_childs_model->password_update($child_id, $hash_pass);

					if ($result) {
						$responseary['status'] = 200;
						$responseary['msg'] = "Password successfully change";
						$responseary['user_id'] = $child_id;
					} else {
						$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1019');
						foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";
						}
					}
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1020');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	/* Store Latest Lesson Page */

	public function store_current_lesson_page()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$back_click_count = $inputpost['back_click_count'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$lesson_id = ($inputpost['lesson_id']);
				$lesson_index_id = ($inputpost['lesson_index_id']);
				$lessonary = array();
				$lessonary['ss_aw_lesson_id'] = $lesson_id;
				$lessonary['ss_aw_child_id'] = $child_id;
				$lessonary['ss_aw_lesson_index'] = $lesson_index_id;
				$lessonary['ss_aw_updated_date'] = date('Y-m-d H:i:s');
				$lessonary['ss_aw_back_click_count'] = $back_click_count;
				$response = $this->ss_aw_current_lesson_model->update_record($lessonary);
				if ($response == 0) {
					$this->ss_aw_current_lesson_model->insert_data($lessonary);
				}
				$responseary['status'] = '200';
				$responseary['msg'] = 'Lesson current status updated';
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	public function get_current_lesson_page()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$lesson_id = ($inputpost['lesson_id']);

				$lessonary = array();
				$lessonary['ss_aw_lesson_id'] = $lesson_id;
				$lessonary['ss_aw_child_id'] = $child_id;
				$response = $this->ss_aw_current_lesson_model->fetch_record_byparam($lessonary);

				$responseary['status'] = '200';
				$responseary['msg'] = 'Lesson current status';
				$responseary['lesson_index'] = $response[0]['ss_aw_lesson_index'];
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	public function store_lesson_quiz_answers()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$postdata = array();
				$postdata['ss_aw_child_id'] = $child_id;
				$postdata['ss_aw_lesson_id'] = $inputpost['lesson_id'];
				$postdata['ss_aw_question'] = $inputpost['question'];
				$postdata['ss_aw_options'] = $inputpost['options'];
				$postdata['ss_aw_post_answer'] = $inputpost['answer'];
				$postdata['ss_aw_question_format'] = $inputpost['question_format'];
				$postdata['ss_aw_answer_status'] = $inputpost['answer_status']; // 1 = Right,2 = Wrong
				$postdata['ss_aw_topic_id'] = $inputpost['topic_id'];
				$postdata['ss_aw_seconds_to_start_answer_question'] = $inputpost['seconds_to_start_answer_question'];
				$postdata['ss_aw_seconds_to_answer_question'] = $inputpost['seconds_to_answer_question'];
				$postdata['ss_aw_question_id'] = $inputpost['question_id'];

				/*
                  Check particular Lesson Quiz already post by child or not
                 */
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_lesson_id'] = $inputpost['lesson_id'];
				$searchary['ss_aw_question'] = $inputpost['question'];
				$searchdetailsary = array();
				$searchdetailsary = $this->ss_aw_lesson_quiz_ans_model->search_data_by_param($searchary);
				if (empty($searchdetailsary)) {
					$this->ss_aw_lesson_quiz_ans_model->data_insert($postdata);
					$responseary['msg'] = 'Lesson question answer post successfully.';
				} else {
					/* $record_id = $searchdetailsary[0]['ss_aw_id'];
                      $postdata['ss_aw_id'] = $record_id;
                      $this->ss_aw_lesson_quiz_ans_model->update_record($postdata); */
					$responseary['msg'] = 'Already answered this question.';
				}

				$responseary['status'] = '200';
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	/*     * ***************************************************** Readalong SECTION **************************************** */

	public function schedule_readalongs()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];

				$readAlongCount = $this->ss_aw_schedule_readalong_model->get_active_readalong_all_count($child_id, $course_id);
				//check if user already add 5 readalong//
				if ($readAlongCount >= 5) {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1040');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
					echo json_encode($responseary);
					die();
				}

				$postdata = array();
				$postdata['ss_aw_child_id'] = $child_id;
				$postdata['ss_aw_readalong_id'] = $inputpost['readalong_id'];
				if (!empty($inputpost['readalong_schedule'])) {
					$schedule_date = $inputpost['readalong_schedule'];
				} else {
					$schedule_date = date('Y-m-d H:i:s');
				}
				$postdata['ss_aw_schedule_readalong'] = $schedule_date; // 2021-06-31 16:45:50
				$postdata['ss_aw_course_id'] = $course_id;
				$searchdata = array();
				$searchdata['ss_aw_child_id'] = $child_id;
				$searchdata['ss_aw_course_id'] = $course_id;

				$searchresultary = $this->ss_aw_schedule_readalong_model->scheduledreadalongdetail($searchdata);
				if (empty($searchresultary) || @$searchresultary[0]->ss_aw_readalong_status == 1) {
					$this->ss_aw_schedule_readalong_model->data_insert($postdata);
					$responseary['status'] = '200';
					$responseary['msg'] = 'Readalong scheduled successfully';
				} else {
					//this block mean raedalong is not readable yet.
					$postdata = array();
					$postdata['ss_aw_child_id'] = $child_id;
					$postdata['ss_aw_course_id'] = $course_id;
					$postdata['ss_aw_readalong_id'] = $inputpost['readalong_id'];
					$postdata['ss_aw_schedule_readalong'] = $schedule_date; // 2021-06-31 16:45:50
					$postdata['ss_aw_id'] = $searchresultary[0]->ss_aw_id;
					$this->ss_aw_schedule_readalong_model->update_scheduler($postdata);
					$msg = "Readalong schedule updated successfully.";

					$responseary['status'] = '200';
					$responseary['msg'] = $msg;
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	/*
      Delete Scheduled Readalong against particular Readalong
     */

	public function delete_schedule_readalongs()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$postdata = array();
				$postdata['ss_aw_child_id'] = $child_id;
				$postdata['ss_aw_readalong_id'] = $inputpost['readalong_id'];

				$searchdata = array();
				$searchdata['ss_aw_child_id'] = $child_id;
				$searchdata['ss_aw_readalong_id'] = $inputpost['readalong_id'];
				$searchresultary = $this->ss_aw_schedule_readalong_model->search_byparam($searchdata);
				if (!empty($searchresultary)) {
					$this->ss_aw_schedule_readalong_model->remove_scheduled_readalong($postdata);
					$responseary['status'] = '200';
					$responseary['msg'] = 'Readalong schedule canceled successfully';
				} else {
					$responseary['status'] = '500';
					$responseary['msg'] = 'Readalong not scheduled.';
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	/*
      This function provide all readalong list against child Level
     */

	public function readalongs_list()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$this->db->trans_start();
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_course_currrent_status'] = 1;
				$courseary = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
				$course_code = $courseary[count($courseary) - 1]['ss_aw_course_code'];
				$course_id = $courseary[count($courseary) - 1]['ss_aw_selected_course_id'];
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_course_id'] = $course_id;
				$schedule_result = $this->ss_aw_schedule_readalong_model->search_byparam($searchary);

				$scheduled_readalong_array = array();
				foreach ($schedule_result as $value) {
					$scheduled_readalong_array[] = $value['ss_aw_readalong_id']; // This array contain all scheduled readalongs record id
				}

				if ($course_code == 'M') {
					$course_code = 'A';
				}
				$result = $this->ss_aw_readalongs_upload_model->get_not_scheduled_readalongs($course_code, $scheduled_readalong_array);


				$this->db->trans_complete();
				if (!empty($result)) {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data found';
					foreach ($result as $key => $value) {
						$responseary['result'][$key]['readalong_id'] = $value['ss_aw_id'];
						$responseary['result'][$key]['type'] = $value['ss_aw_type'];
						$responseary['result'][$key]['title'] = $value['ss_aw_title'];
						$responseary['result'][$key]['level'] = $value['ss_aw_level'];
						$responseary['result'][$key]['topic'] = $value['ss_aw_topic'];
						$responseary['result'][$key]['release_date'] = $value['ss_aw_created_date'];
					}
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function schedule_readalongs_list()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$this->db->trans_start();
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$result = $this->ss_aw_schedule_readalong_model->search_byparam($searchary); //Search Scheduled Readalongs LIST by child

				if (!empty($result)) {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data found';
					$i = 0;
					foreach ($result as $key => $value) {
						if ($value['ss_aw_status'] == 1) {
							$responseary['result'][$i]['readalong_id'] = $value['readalongid'];
							$responseary['result'][$i]['type'] = $value['ss_aw_type'];
							$responseary['result'][$i]['title'] = $value['ss_aw_title'];
							$responseary['result'][$i]['level'] = $value['ss_aw_level'];
							$responseary['result'][$i]['topic'] = $value['ss_aw_topic'];
							$responseary['result'][$i]['readalong_status'] = $value['ss_aw_readalong_status'];
							$responseary['result'][$i]['start_date'] = $value['ss_aw_start_date'];
							$responseary['result'][$i]['end_date'] = $value['ss_aw_end_date'];
							$responseary['result'][$i]['scheduled_date'] = $value['ss_aw_schedule_readalong'];
							//start badge code
							if ($value['ss_aw_readalong_status'] == 1) {
								$responseary['result'][$i]['sitting_count'] = $value['ss_aw_sitting_count'];
								//check wrong answer
								$wrong_count = $this->ss_aw_readalong_quiz_ans_model->get_wrong_answer_count($child_id, $value['readalongid']);
								$responseary['result'][$i]['wrong_answer_count'] = $wrong_count;
								$total_questions = $this->ss_aw_readalong_quiz_ans_model->get_all_question_count($child_id, $value['readalongid']);
								$responseary['result'][$i]['total_questions'] = $total_questions;
								$responseary['result'][$i]['wright_answers'] = $total_questions - $wrong_count;
							} else {
								$responseary['result'][$i]['sitting_count'] = "";
								$responseary['result'][$i]['wrong_answer_count'] = "";
								$responseary['result'][$i]['total_questions'] = "";
								$responseary['result'][$i]['wright_answers'] = "";
							}
							$responseary['result'][$key]['is_demo'] = $value['ss_aw_is_demo'];
							$i++;
						}
					}
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			$this->db->trans_complete();
			echo json_encode($responseary);
			die();
		}
	}

	public function readalongs_details()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				//mark this readalong as read
				$update_readalong_accessibility['ss_aw_child_id'] = $child_id;
				$update_readalong_accessibility['ss_aw_readalong_id'] = $inputpost['readalong_id'];
				$this->ss_aw_schedule_readalong_model->update_read_status($update_readalong_accessibility);
				$this->ss_aw_schedule_readalong_model->increment_readalong_sitting_count($child_id, $inputpost['readalong_id']);
				//end

				$searchary = array();
				$searchary['ss_aw_id'] = $inputpost['readalong_id'];
				//$result = $this->ss_aw_readalongs_upload_model->fetch_by_params($searchary);
				$result = $this->ss_aw_readalongs_upload_model->get_record_by_upload_id($inputpost['readalong_id']);
				$searchary = array();
				$searchary['ss_aw_readalong_upload_id'] = $inputpost['readalong_id'];
				//$readalongary = $this->ss_aw_readalong_model->search_byparam($searchary);
				$readalongary = $this->ss_aw_readalong_model->get_alldata_byrecordid($inputpost['readalong_id']);

				$searchary = array();
				$searchary['ss_aw_readalong_upload_id'] = $inputpost['readalong_id'];
				//$readalongquizary = $this->ss_aw_readalong_quiz_model->search_byparam($searchary);
				$readalongquizary = $this->ss_aw_readalong_quiz_model->get_record_by_upload_id($inputpost['readalong_id']);

				$getreadalongdetails = array();
				$getreadalongquiz = array();

				if (!empty($result[0]['ss_aw_upload_file'])) {
					$zipfile_path = explode("/", $result[0]['ss_aw_upload_file']);
					$image_ath = $zipfile_path[1] . "/" . $zipfile_path[2] . "/";
				} else {
					$image_ath = "";
				}

				if (!empty($readalongary)) {

					$setting_result = array();
					$setting_result = $this->ss_aw_general_settings_model->fetch_record();
					$idletime = $setting_result[0]->ss_aw_time_skip;
					$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

					$responseary['status'] = '200';
					$responseary['msg'] = 'Data found';
					$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
					$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
					$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
					$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
					$responseary['lesson_quiz_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_lesson_quiz_audio;
					$responseary['lesson_quiz_bad_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_bad_audio;

					$responseary['readalong_id'] = $inputpost['readalong_id'];
					$responseary['course'] = $readalongary[0]['ss_aw_level'];
					$responseary['topic'] = $readalongary[0]['ss_aw_topic'];
					$responseary['image_viewing_time'] = 5000;

					//check readalong comprehension part read or not.
					$check_readalong = $this->ss_aw_schedule_readalong_model->checkreadalongcomprehensionstatus($inputpost['readalong_id'], $child_id);
					if (!empty($check_readalong)) {
						if ($check_readalong[0]->ss_aw_comprehension_read == 1) {
							$responseary['read_status'] = 1;
						} else {
							$responseary['read_status'] = 0;
						}
					} else {
						$responseary['read_status'] = 0;
					}
					//end of checking.
					//get readalong last page index
					$get_page_index_details = $this->ss_aw_store_readalong_page_model->get_page_index($child_id, $inputpost['readalong_id']);
					if (!empty($get_page_index_details)) {
						$responseary['last_page_index'] = $get_page_index_details[0]->ss_aw_page_index;
					} else {
						$responseary['last_page_index'] = 0;
					}
					//end
					foreach ($readalongary as $key => $value) {
						$getreadalongdetails[$key]['index'] = $value['ss_aw_readalong_id'];
						if ($value['ss_aw_title_exist'] == 'Y') { // Check TITLE EXIST OR NOT Y = Yes, N = NO
							$getreadalongdetails[$key]['title'] = strip_tags($value['ss_aw_content']);
							$getreadalongdetails[$key]['description'] = "";
							if (!empty($value['ss_aw_readalong_audio']))
								$getreadalongdetails[$key]['title_audio'] = base_url() . $value['ss_aw_readalong_audio'];
							else
								$getreadalongdetails[$key]['title_audio'] = "";
							$getreadalongdetails[$key]['description_audio'] = "";
						} else {
							$getreadalongdetails[$key]['title'] = "";
							$getreadalongdetails[$key]['description'] = strip_tags($value['ss_aw_content']);
							$getreadalongdetails[$key]['title_audio'] = "";
							if (!empty($value['ss_aw_readalong_audio']))
								$getreadalongdetails[$key]['description_audio'] = base_url() . $value['ss_aw_readalong_audio'];
							else
								$getreadalongdetails[$key]['description_audio'] = "";
						}

						$getreadalongdetails[$key]['is_title'] = 0; // 1 = Title Exist, 0 = Absent



						if (!empty($value['ss_aw_image'])) {
							if (strtolower($value['ss_aw_image']) == 't') {
								$getreadalongdetails[$key]['is_title'] = 1; // 1 = Title Exist, 0 = Absent
							} else {
								$getreadalongdetails[$key]['image'] = base_url() . $image_ath . $value['ss_aw_image'];
							}
						} else {
							$getreadalongdetails[$key]['image'] = "";
						}

						if ($value['ss_aw_voiceover'] == 'Y') {
							$getreadalongdetails[$key]['voiceover'] = 1; // 1 = Voiceover exist, 0 = Voiceover absent
						} else {
							$getreadalongdetails[$key]['voiceover'] = 0;
						}
						if ($value['ss_aw_text_visible'] == 'Y') {
							$getreadalongdetails[$key]['text_visible'] = 1;
						} else {
							$getreadalongdetails[$key]['text_visible'] = 0;
						}
					}
					$responseary['data'] = $getreadalongdetails;

					//QUIZ SECTION START HERE
					$quizary = array();
					$quizgroupary = $this->ss_aw_readalong_quiz_model->get_record_groupby_quiztype();
					foreach ($quizgroupary as $value) {
						$quizary[] = $value['ss_aw_quiz_type'];
					}

					$k = 1;
					$quiz_description = "";
					foreach ($quizary as $val) {
						if ($val == 1) {
							$quiz_description = "Fill in the blanks";
							$quiz_descriptionaudio = base_url() . 'assets/audio/fill_the_blanks.mp3';
						}
						if ($val == 2) {
							$quiz_description = "Choose the Correct Answer";
							$quiz_descriptionaudio = base_url() . 'assets/audio/choose_right_answers.mp3';
						}
						if ($val == 3) {
							$quiz_description = " Rewrite the sentence";
							$quiz_descriptionaudio = base_url() . 'assets/audio/rewrite_the_sentence.mp3';
						}
						$getreadalongquiz = array();
						$getquiz_endary = array();
						$i = 1;
						$j = 0;
						foreach ($readalongquizary as $key1 => $value) {
							if ($value['ss_aw_quiz_type'] == $val) {
								$getreadalongquiz[$j]['subindex'] = $value['ss_aw_readalong_id']; //Quiz Index
								$getreadalongquiz[$j]['question_id'] = $value['ss_aw_readalong_id']; //Quiz Index
								$getreadalongquiz[$j]['question'] = $value['ss_aw_question'];
								$getreadalongquiz[$j]['qtype'] = $value['ss_aw_quiz_type'];

								//check readalong quiz answered or not.
								$check_answered_status = $this->ss_aw_readalong_quiz_ans_model->checkdatabyid($value['ss_aw_readalong_id'], $inputpost['readalong_id'], $child_id);
								if (!empty($check_answered_status)) {
									$getreadalongquiz[$j]['answered'] = 1;
									if ($check_answered_status[0]->ss_aw_quiz_right_wrong == 1) {
										$getreadalongquiz[$j]['correct'] = 1;
									} else {
										$getreadalongquiz[$j]['correct'] = 0;
									}
								} else {
									$getreadalongquiz[$j]['answered'] = 0;
								}
								//end of checking

								$multiple_choice_ary = array();
								$multiple_choice_ary = explode(",", $value['ss_aw_multiple_choice']);

								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);

								$getreadalongquiz[$j]['options'] = $multiple_choice_ary;

								$ans_ary = array();
								$ans_ary = explode("/", trim(strip_tags($value['ss_aw_answers'])));

								$ans_ary = array_map('trim', $ans_ary);

								$getreadalongquiz[$j]['answers'] = $ans_ary;
								$getreadalongquiz[$j]['answeraudio'] = base_url() . $value['ss_aw_answers_audio'];
								$i++;
								$j++;
							} else {
								$getquiz_endary['index'] = $key + $k + 2;
								$getquiz_endary['title'] = "";
								$getquiz_endary['description'] = strip_tags($value['ss_aw_details']);
								$getquiz_endary['title_audio'] = "";
								$getquiz_endary['description_audio'] = base_url() . $value['ss_aw_quiz_type_audio'];
								$getquiz_endary['image'] = "";
								$getquiz_endary['voiceover'] = 1;
								$getquiz_endary['text_visible'] = 1;
							}
						}


						$responseary['data'][$key + $k]['index'] = $key + $k + 1;
						$responseary['data'][$key + $k]['image'] = "";
						$responseary['data'][$key + $k]['description_audio'] = $quiz_descriptionaudio;
						$responseary['data'][$key + $k]['is_title'] = 0;
						$responseary['data'][$key + $k]['title_audio'] = "";
						$responseary['data'][$key + $k]['description'] = strip_tags($quiz_description);
						$responseary['data'][$key + $k]['title'] = "";
						$responseary['data'][$key + $k]['details']['examples'] = array();
						$responseary['data'][$key + $k]['details']['course'] = 1;
						$responseary['data'][$key + $k]['details']['duration'] = 0;
						$responseary['data'][$key + $k]['details']['quizzes'] = $getreadalongquiz;
						$k++;
					}
					$responseary['data'][$key + $k] = $getquiz_endary;
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function store_readalong_quiz_answers()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				//check same question existance for individual scheduling
				$arr['ss_aw_child_id'] = $child_id;
				$last_schedule_readalong = $this->ss_aw_schedule_readalong_model->scheduledreadalongdetail($arr);

				if (!empty($last_schedule_readalong)) {
					$chek_duplicate_question = $this->ss_aw_readalong_quiz_ans_model->ceck_duplicate_question($child_id, $inputpost['readalong_id'], $inputpost['question_id']);

					if ($chek_duplicate_question > 0) {
						$responseary['status'] = '200';
						$responseary['msg'] = 'Readalong question answer post successfully';
						echo json_encode($responseary);
						die();
					}
				}

				$postdata = array();
				$postdata['ss_aw_child_id'] = $child_id;
				$postdata['ss_aw_readalong_id'] = $inputpost['readalong_id'];
				$postdata['ss_aw_quiz_id'] = $inputpost['question_id'];
				$postdata['ss_aw_quiz_ans_post'] = $inputpost['answer'];
				$postdata['ss_aw_quiz_right_wrong'] = $inputpost['answer_status']; // 1 = Right,2 = Wrong
				$this->ss_aw_readalong_quiz_ans_model->data_insert($postdata);

				$responseary['status'] = '200';
				$responseary['msg'] = 'Readalong question answer post successfully';
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function finish_readalong()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];

				$readalong_id = $inputpost['readalong_id'];

				//check already completed or not.
				$check_active_atatus = $this->ss_aw_schedule_readalong_model->check_active_readalong($child_id, $readalong_id);

				if ($check_active_atatus == 0) {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Readalong completed successfully';
					echo json_encode($responseary);
					die();
				}
				//end
				$data = array();
				$data['ss_aw_child_id'] = $child_id;
				$data['ss_aw_readalong_id'] = $readalong_id;
				$data['ss_aw_course_id'] = $course_id;
				$data['ss_aw_status'] = 1;
				$response = $this->ss_aw_last_readalong_model->data_insert($data);

				$data = array();
				$data['ss_aw_child_id'] = $child_id;
				$data['ss_aw_readalong_id'] = $readalong_id;
				$data['ss_aw_readalong_status'] = 1;
				$response = $this->ss_aw_schedule_readalong_model->update_details($data);

				$responseary['status'] = '200';
				$responseary['msg'] = 'Readalong completed successfully';

				//send notification code
				$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

				$child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id);
				$child_name = $child_profile[0]->ss_aw_child_nick_name;
				$gender = $child_profile[0]->ss_aw_child_gender;
				if ($gender == 1) {
					$gender_name = "him";
				} else {
					$gender_name = "her";
				}
				$readalong_detail = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
				$readalong_name = $readalong_detail[0]->ss_aw_title;
				if (empty($child_profile[0]->ss_aw_is_self) && empty($child_profile[0]->ss_aw_institution_user_upload_id)) {
					if (!empty($parent_detail)) {
						$email_template = getemailandpushnotification(16, 1, 1);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@readalong_name@@]", $readalong_name, $body);
							$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $gender_name, $body);
							$send_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
							//emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
						}

						$app_template = getemailandpushnotification(16, 2, 1);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@readalong_name@@]", $readalong_name, $body);
							$body = str_ireplace("[@@child_name@@]", $child_name, $body);
							$title = $app_template['title'];
							$token = $parent_detail[0]->ss_aw_device_token;

							pushnotification($title, $body, $token, 25);

							$save_data = array(
								'user_id' => $parent_detail[0]->ss_aw_parent_id,
								'user_type' => 1,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => 25
							);

							save_notification($save_data);
						}
					}
				}


				//child section
				if (!empty($child_profile)) {
					$email_template = getemailandpushnotification(16, 1, 2);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@readalong_name@@]", $readalong_name, $body);
						$body = str_ireplace("[@@username@@]", $child_name, $body);
						$send_data = array(
							'ss_aw_email' => $child_profile[0]->ss_aw_child_email,
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
						//emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
					}

					$app_template = getemailandpushnotification(16, 2, 2);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@readalong_name@@]", $readalong_name, $body);
						$body = str_ireplace("[@@username@@]", $child_name, $body);

						$title = $app_template['title'];
						$token = $child_profile[0]->ss_aw_device_token;

						pushnotification($title, $body, $token, 24);

						$save_data = array(
							'user_id' => $child_profile[0]->ss_aw_child_id,
							'user_type' => 2,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 24
						);

						save_notification($save_data);
					}
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	/*     * ************************************************************************************************************************* */

	public function get_assessments_list()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$this->db->trans_start();
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_course_currrent_status'] = 1;
				$courseary = $this->ss_aw_purchase_courses_model->get_purchase_course_details($searchary);
				$course_code = $courseary[0]['ss_aw_course_code'];
				$course_purchase_date = $courseary[0]['ss_aw_course_created_date'];
				$previous_level = "";
				if ($course_code == 'C') {
					$previous_level = "E";
				} elseif ($course_code == "A") {
					$previous_level = "C";
				}
				$previous_assessment_complete_count = 0;
				//fetch promotion details
				if (!empty($previous_level)) {
					$check_promotion = $this->ss_aw_promotion_model->get_promotion_detail($child_id, $previous_level);

					if (!empty($check_promotion)) {
						$previous_assessment_complete_count = $this->ss_aw_assessment_score_model->checkassessmentcompletebylevel($previous_level, $child_id);
					}
				}

				$topic_listary = array();
				$general_language_assessments = array();

				if ($course_code == 'E' || $course_code == 'C') {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'E';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
				} elseif ($course_code == 'A') {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'C';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
					$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_champions_general_language_assessments();
				} else {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'A,M';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
				}
				$topicAry = array();
				if (!empty($topic_listary)) {
					foreach ($topic_listary as $key => $value) {
						$topicAry[] = $value->ss_aw_section_id;
					}
				}
				$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);

				$result = array_merge($topical_assessments, $general_language_assessments);

				$getreadalonglist = array();

				/*
                  Get Started Assessments exam LIST against particular Child
                 */
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$statred_result = array();
				$statred_result = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($searchary, $course_purchase_date); //Get started assessement exam list
				$started_assessment_list = array();
				if (!empty($statred_result)) {
					foreach ($statred_result as $value) {
						$started_assessment_list[] = $value['ss_aw_asked_category'];
					}
				}
				$started_assessment_list = array_values(array_unique($started_assessment_list));

				/*
                  Get completed assessment exam LIST against partcular child
                 */
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$completed_result = array();
				$completed_result = $this->ss_aw_assessment_exam_completed_model->fetch_details_byparam($searchary, $course_purchase_date); //Get completed assessement exam list
				$completed_assessment_list = array();
				if (!empty($completed_result)) {
					foreach ($completed_result as $value) {
						$completed_assessment_list[] = $value['ss_aw_assesment_topic'];
					}
				}

				/*
                  Get completed Lessons LIST against partcular child
                 */
				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_lesson_status'] = 2;
				if ($course_code == 'E')
					$searchary['ss_aw_lesson_level'] = 1;
				if ($course_code == 'C')
					$searchary['ss_aw_lesson_level'] = 2;
				if ($course_code == 'A')
					$searchary['ss_aw_lesson_level'] = 3;

				$lesson_completed_result = array();
				$lesson_completed_result = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($searchary, $course_purchase_date); //Get completed assessement exam list

				$completed_lesson_list = array();
				$completed_lesson_date = array();
				if (!empty($lesson_completed_result)) {
					foreach ($lesson_completed_result as $value) {
						$completed_lesson_list[] = $value['ss_aw_lesson_id'];
						$completed_lesson_date[$value['ss_aw_lesson_id']] = $value['ss_aw_last_lesson_modified_date'];
					}
				}

				if (!empty($result)) {
					$count = 0;
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data found';
					foreach ($result as $key => $value) {
						$count++;
						if ($count <= $previous_assessment_complete_count) {
							$responseary['result'][$key]['is_blocked'] = 1;
						} else {
							$responseary['result'][$key]['is_blocked'] = 0;
						}

						$complete_count = $this->ss_aw_assessment_exam_completed_model->totalcompletebytopic($value['ss_aw_assesment_topic'], $child_id, $course_purchase_date);

						if ($complete_count > 0) {
							$confidence = $this->show_confidence_based_on_index($child_id, $course_code, $value['ss_aw_assesment_topic']);
							$confidence_ary = json_decode($confidence);
							$responseary['result'][$key]['confidence'] = $confidence_ary->point;
							$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_topic_child($child_id, $value['ss_aw_assesment_topic']);
							$total_questions = 0;
							$wright_answers = 0;
							if (!empty($assessment_score_details)) {
								$total_questions = $assessment_score_details[0]->total_question;
								$wright_answers = $assessment_score_details[0]->wright_answers;
								$percentage = get_percentage($total_questions, $wright_answers);
							} else {
								$percentage = 0;
							}
							$responseary['result'][$key]['accuracy'] = $percentage;
							$responseary['result'][$key]['total_questions'] = $total_questions;
							$responseary['result'][$key]['wright_answers'] = $wright_answers;
						} else {
							$responseary['result'][$key]['confidence'] = "";
							$responseary['result'][$key]['accuracy'] = "";
							$responseary['result'][$key]['total_question'] = "";
							$responseary['result'][$key]['wright_answers'] = "";
						}

						if ($course_code == 'E' || $course_code == 'C') {
							$course_id = 1;
						} elseif ($course_code == 'A') {
							$course_id = 3;
						} else {
							$course_id = 5;
						}
						$chkCompletion = $this->ss_aw_course_completion_model->checkcoursecompletionRow($child_id, $course_id);
						//new changes on 24-08-2023//
						if (!empty($chkCompletion)) {
							$responseary['result'][$key]['assessment_restarted'] = 0;
						} elseif ($complete_count >= 2 || $complete_count == 0) {
							$responseary['result'][$key]['assessment_restarted'] = 0;
						} else {
							$completed_exam_detail = $this->ss_aw_assessment_exam_completed_model->getexamdetailbytopic($value['ss_aw_assesment_topic'], $child_id);

							if ($value['ss_aw_assesment_format'] == 'Single') {
								$check_restarted = $this->ss_aw_assesment_questions_asked_model->checkrepeatexambytopic($child_id, $completed_exam_detail[0]->ss_aw_exam_code, $value['ss_aw_assesment_topic']);
							} else {
								$check_restarted = $this->ss_aw_assesment_multiple_question_asked_model->checkrepeatexambytopic($child_id, $completed_exam_detail[0]->ss_aw_exam_code, $value['ss_aw_assesment_topic']);
							}

							if ($check_restarted > 0) {
								$responseary['result'][$key]['assessment_restarted'] = 1;
							} else {
								$responseary['result'][$key]['assessment_restarted'] = 0;
							}
						}
						if (($key > 0) && ($complete_count > 0)) {
							$previous_key = $key - 1;
							if ($responseary['result'][$previous_key]['assessment_status'] == 0) {
								$responseary['result'][$previous_key]['assessment_status'] = 2;
								$responseary['result'][$previous_key]['exam_completed'] = 1;
								$responseary['result'][$previous_key]['assessment_status'] = 2;
								$assessment_topic_id = $value['ss_aw_assesment_topic_id'];
								if ($assessment_topic_id > 0) {
									$previous_assessment_complete = $this->ss_aw_assessment_exam_completed_model->getcompletecountbytopic($assessment_topic_id, $child_id);
									$responseary['result'][$previous_key]['assessment_complete_count'] = $previous_assessment_complete;
								}
							}
						}

						$responseary['result'][$key]['complete'] = $complete_count;
						$responseary['result'][$key]['assessment_complete_count'] = $complete_count;
						$responseary['result'][$key]['assessment_id'] = $value['ss_aw_assessment_id'];
						$responseary['result'][$key]['lesson_id'] = $value['ss_aw_lesson_id'];
						$responseary['result'][$key]['language'] = $value['ss_aw_language'];
						$responseary['result'][$key]['assesment_format'] = $value['ss_aw_assesment_format'];
						if ($value['ss_aw_assesment_format'] == 'Single')
							$responseary['result'][$key]['assesment_format_id'] = 1;
						else
							$responseary['result'][$key]['assesment_format_id'] = 2;
						$responseary['result'][$key]['level'] = $course_code;
						$responseary['result'][$key]['topic'] = $value['ss_aw_assesment_topic'];

						/* Check Assessment Started or Not */
						if (in_array($value['ss_aw_assesment_topic'], $started_assessment_list)) {
							$responseary['result'][$key]['assessment_status'] = 1;
						} else {
							$responseary['result'][$key]['assessment_status'] = 0;
						}
						//exam_completed = 0 = assessment exam Not completed/Running
						//exam_completed = 1 = assessment exam  completed/Finish

						if (in_array($value['ss_aw_assesment_topic'], $completed_assessment_list)) {
							$responseary['result'][$key]['exam_completed'] = 1;
							$responseary['result'][$key]['assessment_status'] = 2;
						} else {
							$responseary['result'][$key]['exam_completed'] = 0;
						}

						// Check Corrosponding Lesson Completed OR NOT
						if (in_array($value['ss_aw_lesson_id'], $completed_lesson_list)) {
							$responseary['result'][$key]['lesson_completed_date'] = $completed_lesson_date[$value['ss_aw_lesson_id']];
							$responseary['result'][$key]['lesson_completed'] = 1;
						} else {
							$responseary['result'][$key]['lesson_completed_date'] = "";
							$responseary['result'][$key]['lesson_completed'] = 0;
						}

						$responseary['result'][$key]['is_demo'] = $value['ss_aw_is_demo'];


						$lesson_end_date_time = $responseary['result'][$key]['lesson_completed_date'] != '' ? daysDifferent(strtotime(date_format(date_create($responseary['result'][$key]['lesson_completed_date']), 'Y-m-d')), strtotime(date('Y-m-d'))) : "";
						$responseary['result'][$key]['days'] = $lesson_end_date_time;
						$responseary['result'][$key]['is_available'] = ($lesson_end_date_time != "" && $lesson_end_date_time > 0) || ($responseary['result'][$key]['assessment_status'] == 2) ? 1 : 0;
					}
				} else {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
				$this->db->trans_complete();
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	/* public function complete_assessment_exam()
      {
      $inputpost = $this->input->post();
      $responseary = array();
      if($inputpost)
      {
      $child_id = $inputpost['user_id']; // Child Record ID from Database
      $child_token = $inputpost['user_token']; // Token get after login
      $assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
      $assessment_exam_code = $inputpost['assessment_exam_code'];
      if(!empty($inputpost['back_click_count'])){
      $back_click_count = $inputpost['back_click_count'];
      }
      else
      {
      $back_click_count = 0;
      }

      if($this->check_child_existance($child_id,$child_token)) // Check provider Token valid or not against child_id and token
      {
      $this->db->trans_start();
      $insert_data = array();
      $insert_data['ss_aw_assessment_id'] = $assessment_id;
      $insert_data['ss_aw_exam_code'] = $assessment_exam_code;
      $insert_data['ss_aw_child_id'] = $child_id;
      $response = $this->ss_aw_assessment_exam_completed_model->searchdata($insert_data);
      if(empty($response))
      {
      $insert_data['ss_aw_back_click_count'] = $back_click_count;
      $this->ss_aw_assessment_exam_completed_model->insert_data($insert_data);

      $assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);

      if (!empty($assessment_details)) {
      $assessemnt_format = $assessment_details[0]->ss_aw_assesment_format;
      if ($assessemnt_format == 'Single') {
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

      $wright_answers = $this->ss_aw_assesment_questions_asked_model->totalnoofcorrectanswers($assessment_id, $child_id);
      }
      else
      {
      $total_questions = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofquestionasked($assessment_id, $child_id);
      $wright_answers = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofcorrectanswers($assessment_id, $child_id);
      }
      }

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

      //store assessment exam score
      $store_score = array(
      'exam_code' => $assessment_exam_code,
      'child_id' => $child_id,
      'assessment_id' => $assessment_id,
      'total_question' => $total_questions,
      'wright_answers' => $wright_answers,
      'level' => $level
      );

      $this->ss_aw_assessment_score_model->store_data($store_score);
      //end
      $responseary['status'] = '200';
      $responseary['msg'] = 'Assessment exam completed.';

      $total_level_assessment = $this->ss_aw_assesment_uploaded_model->get_assessment_bylevel($level);
      $level_assessment_id = array();
      if (!empty($total_level_assessment)) {
      foreach ($total_level_assessment as $level_assessment) {
      $level_assessment_id[] = $level_assessment->ss_aw_assessment_id;
      }
      }

      $assessment_complete_count = $this->ss_aw_assessment_exam_completed_model->totallevelcompletecount($level_assessment_id, $child_id);

      if ($assessment_complete_count == count($level_assessment_id)) {
      $course_status = 2; // FINISH
      $data = array();
      $data['ss_aw_course_status'] = $course_status;
      $data['ss_aw_child_course_modified_date'] = date('Y-m-d H:i:s');
      $result = $this->ss_aw_child_course_model->updaterecord_child($child_id,$data);
      }

      //send notification code
      $parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

      $child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
      $child_name = $child_profile[0]->ss_aw_child_nick_name;

      $assessment_name = $assessment_details[0]->ss_aw_assesment_topic;
      if (!empty($parent_detail)) {

      $email_template = getemailandpushnotification(13, 1, 1);
      if (!empty($email_template)) {
      $body = $email_template['body'];
      $body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
      $body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
      $body = str_ireplace("[@@child_name@@]", $child_name, $body);
      emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body, 'deepanjan.das@gmail.com');
      }

      $app_template = getemailandpushnotification(13, 2, 1);
      if (!empty($app_template)) {
      $body = $app_template['body'];
      $body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
      $body = str_ireplace("[@@child_name@@]", $child_name, $body);
      $title = $app_template['title'];
      $token = $parent_detail[0]->ss_aw_device_token;

      pushnotification($title,$body,$token,20);

      $save_data = array(
      'user_id' => $parent_detail[0]->ss_aw_parent_id,
      'user_type' => 1,
      'title' => $title,
      'msg' => $body,
      'status' => 1,
      'read_unread' => 0,
      'action' => 20
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

      pushnotification($title,$body,$token,19);

      $save_data = array(
      'user_id' => $child_profile[0]->ss_aw_child_id,
      'user_type' => 2,
      'title' => $title,
      'msg' => $body,
      'status' => 1,
      'read_unread' => 0,
      'action' => 19
      );

      save_notification($save_data);

      }
      }

      }
      else
      {
      $responseary['status'] = '200';
      $responseary['msg'] = 'Assessment exam record already exist.';
      }
      $this->db->trans_complete();
      }
      else
      {
      $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
      foreach ($error_array as $value) {
      $responseary['status'] = $value->ss_aw_error_status;
      $responseary['msg'] = $value->ss_aw_error_msg;
      $responseary['title'] = "Error";
      }
      }
      echo json_encode($responseary);
      die();
      }
      } */

	public function complete_assessment_exam()
	{
		
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$assessment_exam_code = $inputpost['assessment_exam_code'];
			if (!empty($inputpost['back_click_count'])) {
				$back_click_count = $inputpost['back_click_count'];
			} else {
				$back_click_count = 0;
			}
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];
				if ($level_id == 1) {
					$level = "E";
				} elseif ($level_id == 2) {
					$level = "C";
				} elseif ($level_id == 3) {
					$level = "A";
				} else {
					$level = "M";
				}
				$course_completed = $this->ss_aw_course_completion_model->getcoursecompletionRow($child_id, $level_id, 1);
				if (!empty($course_completed)) {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Assessment exam record already exist.';
					die(json_encode($responseary));
				}

				$this->db->trans_start();
				$insert_data = array();
				$insert_data['ss_aw_assessment_id'] = $assessment_id;
				$insert_data['ss_aw_exam_code'] = $assessment_exam_code;
				$insert_data['ss_aw_child_id'] = $child_id;
				$response = $this->ss_aw_assessment_exam_completed_model->searchdata($insert_data);
				if (empty($response)) {
					$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
					$insert_data['ss_aw_back_click_count'] = $back_click_count;
					$insert_data['ss_aw_assessment_topic'] = $assessment_details[0]->ss_aw_assesment_topic;
					$this->ss_aw_assessment_exam_completed_model->insert_data($insert_data);

					if (!empty($assessment_details)) {
						$assessemnt_format = $assessment_details[0]->ss_aw_assesment_format;
						if ($assessemnt_format == 'Single') {
							$topic_detail = $this->ss_aw_assesment_uploaded_model->gettopic($assessment_id);
							$total_subtopic = $this->ss_aw_sections_subtopics_model->totalnoofsubtopic($topic_detail[0]->ss_aw_assesment_topic_id);

							$searchary = array();
							$searchary['ss_aw_sub_section_no'] = $total_subtopic;
							$get_assessment_quiz_matrix = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($searchary);
							if (!empty($get_assessment_quiz_matrix)) {
								$total_questions = $total_subtopic * $get_assessment_quiz_matrix[0]['ss_aw_total_question'];
							} else {
								$total_questions = 0;
							}

							$wright_answers = $this->ss_aw_assesment_questions_asked_model->totalnoofcorrectanswers($assessment_id, $child_id, $assessment_exam_code);
						} else {
							$total_questions = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofquestionasked($assessment_id, $child_id);
							$wright_answers = $this->ss_aw_assesment_multiple_question_answer_model->totalnoofcorrectanswers($assessment_id, $child_id);
						}
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
					} else {
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

					//store assessment exam score
					$store_score = array(
						'exam_code' => $assessment_exam_code,
						'child_id' => $child_id,
						'assessment_id' => $assessment_id,
						'assessment_topic' => $assessment_details[0]->ss_aw_assesment_topic,
						'total_question' => $total_questions,
						'wright_answers' => $wright_answers,
						'level' => $level
					);

					$this->ss_aw_assessment_score_model->store_data($store_score);
					//end
					$responseary['status'] = '200';
					$responseary['msg'] = 'Assessment exam completed.';

					$total_level_assessment = $this->ss_aw_assesment_uploaded_model->get_course_assessment_list($level_id);
					$level_assessment_id = array();
					$serial_ary = array();
					if (!empty($total_level_assessment)) {
						$assessment_count = 1;
						foreach ($total_level_assessment as $level_assessment) {
							$level_assessment_id[] = $level_assessment['ss_aw_assessment_id'];
							//set serial number
							$serial_ary[$level_assessment['ss_aw_assessment_id']] = $assessment_count;
							$assessment_count++;
						}
					}

					$total_assessment_count = count($total_level_assessment);
				
					$assessment_complete_count = $this->ss_aw_assessment_exam_completed_model->totalExamlevelcompletecount($level_assessment_id, $child_id);

					if ($assessment_complete_count == $total_assessment_count) {
						$compl['ss_aw_course_id'] = $level_id;
						$compl['ss_aw_is_completed'] = 1;
						$compl['ss_aw_child_id'] = $child_id;
						$this->ss_aw_course_completion_model->insert_data($compl);
					}


					$serial_no = 0;
					if (!empty($serial_ary)) {
						$serial_no = $serial_ary[$assessment_id];
					}
					$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

					$child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id);
					$child_name = $child_profile[0]->ss_aw_child_nick_name;
					$gender_pronoun = "";
					if ($child_profile[0]->ss_aw_child_gender == 1) {
						$gender_pronoun = "his";
					} else {
						$gender_pronoun = "her";
					}
					$assessment_name = $assessment_details[0]->ss_aw_assesment_topic;

					if (empty($child_profile[0]->ss_aw_is_self) && empty($child_profile[0]->ss_aw_institution_user_upload_id)) {
						if (!empty($parent_detail)) {
							$email_template = getemailandpushnotification(13, 1, 1);

							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_name, $body);
								$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
								$send_data = array(
									'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
									'ss_aw_subject' => $email_template['title'],
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);
								//emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body, 'sayan.sen@schemaphic.com');
							}

							$app_template = getemailandpushnotification(13, 2, 1);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_name, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
								$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
								$title = $app_template['title'];
								$token = $parent_detail[0]->ss_aw_device_token;

								pushnotification($title, $body, $token, 57);

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
					}


					//child section
					if (!empty($child_profile)) {
						$email_template = getemailandpushnotification(13, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
							$body = str_ireplace("[@@username@@]", $child_name, $body);
							$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
							$send_data = array(
								'ss_aw_email' => $child_profile[0]->ss_aw_child_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
							//emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body, 'sayan.sen@schemaphic.com');
						}

						$app_template = getemailandpushnotification(13, 2, 2);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
							$body = str_ireplace("[@@username@@]", $child_name, $body);
							$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);

							$title = $app_template['title'];
							$token = $child_profile[0]->ss_aw_device_token;

							pushnotification($title, $body, $token);

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
				} else {
					$responseary['status'] = '200';
					$responseary['msg'] = 'Assessment exam record already exist.';
				}
				$this->db->trans_complete();
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function get_current_assessment_exam_code()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$this->db->trans_start();
				$search_data = array();
				$search_data['ss_aw_assessment_id'] = $assessment_id;
				$search_data['ss_aw_child_id'] = $child_id;

				// if(empty($response))
				{
					$assesment_detail = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
					if (!empty($assesment_detail)) {
						$assesment_format = $assesment_detail[0]->ss_aw_assesment_format;
						if ($assesment_format == 'Multiple') {
							$search_result = $this->ss_aw_assesment_multiple_question_asked_model->fetchlastexamcode($child_id, $assessment_id);
							if (!empty($search_result)) {
								$search_data['ss_aw_exam_code'] = $search_result[0]->ss_aw_exam_code;
								$response = $this->ss_aw_assessment_exam_completed_model->searchdata($search_data);
								if (empty($response)) {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam code found';
									$responseary['exam_code'] = $search_result[0]->ss_aw_exam_code;
								} else {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam already completed.';
								}
							} else {
								$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
								foreach ($error_array as $value) {
									$responseary['status'] = $value->ss_aw_error_status;
									$responseary['msg'] = $value->ss_aw_error_msg;
									$responseary['title'] = "Error";
								}
							}
						} else {
							$search_result = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_bydesc($search_data);

							if (!empty($search_result)) {
								$search_data['ss_aw_exam_code'] = $search_result[0]['ss_aw_assessment_exam_code'];
								$response = $this->ss_aw_assessment_exam_completed_model->searchdata($search_data);
								if (empty($response)) {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam code found';
									$responseary['exam_code'] = $search_result[0]['ss_aw_assessment_exam_code'];
								} else {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam already completed.';
								}
							} else {
								$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
								foreach ($error_array as $value) {
									$responseary['status'] = $value->ss_aw_error_status;
									$responseary['msg'] = $value->ss_aw_error_msg;
									$responseary['title'] = "Error";
								}
							}
						}
					}
				}
				$this->db->trans_complete();
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function readalongs_word_meaning()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$word = strtolower($inputpost['word']); // Assessment ID against the exam conducted
			$endpoint = "entries";
			$language_code = "en";
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				//modified on 9th december,2021
				$responseary['status'] = '200';
				$responseary['word'] = $word;
				$word = strtolower($word);
				$check_vocabulary = $this->ss_aw_vocabulary_model->getdefinationbyword($word);
				if (!empty($check_vocabulary)) {
					$responseary['definition'] = $check_vocabulary[0]->meaning;
				} else {
					$responseary['definition'] = "";
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	//////////////////////////////// Supplymentary ///////////////////////////////////////////////////////////////////
	public function supplementary_exam_question()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$supplementary_id = $inputpost['supplementary_id']; // supplementary ID against the exam conducted
			$supplementary_exam_code = rand() . time() . "_" . $child_id;
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$response = array();
				$response = $this->ss_aw_supplymentary_model->get_byparam($supplementary_id);

				$finalquestionary = array();
				$i = 0;
				foreach ($response as $value) {
					//this checking is only for eraly release this problem should be change while uploading
					if ($value['ss_aw_question_format'] != "") {
						$finalquestionary[$i]['question_id'] = $value['ss_aw_id'];
						$finalquestionary[$i]['level'] = $value['ss_aw_level'];
						$finalquestionary[$i]['format'] = 'Single';

						$finalquestionary[$i]['format_id'] = 1;

						$finalquestionary[$i]['category'] = $value['ss_aw_category'];
						$finalquestionary[$i]['sub_category'] = $value['ss_aw_sub_category'];
						$finalquestionary[$i]['question_format'] = $value['ss_aw_question_format'];

						/* if($value['ss_aw_question_format'] == 'Choose the right answers')
                          $finalquestionary[$i]['question_format_id'] = 2; */
						if ($value['ss_aw_question_format'] == 'Choose the right answer')
							$finalquestionary[$i]['question_format_id'] = 2;
						else if ($value['ss_aw_question_format'] == 'Fill in the blanks')
							$finalquestionary[$i]['question_format_id'] = 1;
						else if ($value['ss_aw_question_format'] == 'Rewrite the sentence')
							$finalquestionary[$i]['question_format_id'] = 3;
						/* else if($value['ss_aw_question_format'] == 'Change the word to its comparative degree')
                          $finalquestionary[$i]['question_format_id'] = 4;
                          else if($value['ss_aw_question_format'] == 'Choose the right option')
                          $finalquestionary[$i]['question_format_id'] = 5;
                          else if($value['ss_aw_question_format'] == 'Convert to the comparative degree')
                          $finalquestionary[$i]['question_format_id'] = 6;
                          else if($value['ss_aw_question_format'] == 'Insert the adverb')
                          $finalquestionary[$i]['question_format_id'] = 7;
                          else if($value['ss_aw_question_format'] == 'Join the sentences')
                          $finalquestionary[$i]['question_format_id'] = 8;
                          else if($value['ss_aw_question_format'] == 'Place the article in the aprropraite place')
                          $finalquestionary[$i]['question_format_id'] = 9;
                          else if($value['ss_aw_question_format'] == 'Rewrite the sentence')
                          $finalquestionary[$i]['question_format_id'] = 10; */


						$finalquestionary[$i]['prefaceaudio'] = base_url() . $value['ss_aw_question_preface_audio'];
						$finalquestionary[$i]['preface'] = $value['ss_aw_question_preface'];
						$finalquestionary[$i]['question'] = trim($value['ss_aw_question']);

						$multiple_choice_ary = array();
						$multiple_choice_ary = explode("/", $value['ss_aw_multiple_choice']);

						if (count($multiple_choice_ary) > 1) {
							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
							$finalquestionary[$i]['options'] = $multiple_choice_ary;
						} else {
							$finalquestionary[$i]['options'][0] = $value['ss_aw_multiple_choice'];
						}

						$finalquestionary[$i]['verb_form'] = $value['ss_aw_verb_form'];

						$answersary = array();
						$answersary = explode("/", trim($value['ss_aw_answers']));
						if (count($answersary) > 1) {
							$answersary = array_map('trim', $answersary);
							$finalquestionary[$i]['answers'] = $answersary;
						} else {
							$finalquestionary[$i]['answers'][0] = trim($value['ss_aw_answers']);
						}
						$finalquestionary[$i]['answeraudio'] = base_url() . $value['ss_aw_answers_audio'];
						$finalquestionary[$i]['rules'] = trim($value['ss_aw_rules']);

						$finalquestionary[$i]['hint'] = "";
						$finalquestionary[$i]['ruleaudio'] = base_url() . $value['ss_aw_rules_audio'];

						$i++;
					}
				}
			}

			/* Get Idle time for a question */

			$setting_result = array();
			$setting_result = $this->ss_aw_general_settings_model->fetch_record();
			$idletime = $setting_result[0]->ss_aw_time_skip;
			$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

			$responseary['status'] = 200;
			$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
			$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
			$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
			$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
			$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
			$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
			$responseary['skip_duration'] = $idletime;
			$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
			$responseary['skip_type_1_2_duration'] = $idletime;
			$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
			$responseary['exam_code'] = $supplementary_exam_code;
			$responseary['complete_supplementary_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
			$responseary['data'] = $finalquestionary;
		} else {
			$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
			}
		}
		echo json_encode($responseary);
		die();
	}

	public function supplementary_courses_list()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id'];
			$child_token = $inputpost['user_token'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$this->db->trans_start();
				$profile_detailsary = $this->ss_aw_childs_model->get_child_profile_details($child_id);
				$parent_id = $profile_detailsary[0]->ss_aw_parent_id;

				$searchary = array();
				$purchased_courseary = array();
				$searchary['ss_aw_parent_id'] = $parent_id;
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_course_currrent_status'] = 2;
				$purchased_courseary = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
				$purchased_course_date = $purchased_courseary[0]['ss_aw_course_created_date'];

				if ($purchased_courseary[0]['ss_aw_selected_course_id'] == 1 || $purchased_courseary[0]['ss_aw_selected_course_id'] == 2)
					$current_course = "E";
				else if ($purchased_courseary[0]['ss_aw_selected_course_id'] == 3)
					$current_course = "C";
				else if ($purchased_courseary[0]['ss_aw_selected_course_id'] == 5)
					$current_course = "A";

				$searchary = array();
				$searchary['ss_aw_parent_id'] = $parent_id;
				$searchary['ss_aw_child_id'] = $child_id;
				$courseary = $this->ss_aw_purchased_supplymentary_course_model->search_byparam($searchary);
				$course_ary = array();
				$purchase_date = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$supplymentray_access_duration = $setting_result[0]->ss_aw_supplementary_content_access_duration; //in hour
				if (!empty($courseary)) { //For testing purpose this line of code commented.Date 2021-08-11
					//As per depanjan sir instruction over skype
					foreach ($courseary as $key => $val) {
						$buy_date = $val['ss_aw_create_date'];
						$buy_time = strtotime($buy_date);
						if ($buy_time > time($purchased_course_date)) {
							$current_time = time();
							$diff_time = $current_time - $buy_time;
							$diff_day = $diff_time / 3600;
							if ($diff_day < $supplymentray_access_duration) {
								$purchase_ids = explode(",", $val['ss_aw_supplymentary_courses']);
								if (!empty($purchase_ids)) {
									foreach ($purchase_ids as $s_id) {
										$course_ary[] = $s_id;
										$purchase_date[$s_id] = $val['ss_aw_create_date'];
									}
								}
							}
						}
					}



					$supplymentary_course_ary = array();
					$supplymentary_course_ary = $this->ss_aw_supplymentary_uploaded_model->get_courselist_bylevel($current_course);

					if (!empty($supplymentary_course_ary)) {
						$responseary['status'] = 200;
						$i = 0;
						foreach ($supplymentary_course_ary as $key => $val) {
							if (in_array($val['ss_aw_id'], $course_ary)) { //For testing purpose this line of code commented.Date 2021-08-11
								//As per depanjan sir instruction over skype
								$responseary['result'][$i]['course_id'] = $val['ss_aw_id'];
								$responseary['result'][$i]['course_name'] = $val['ss_aw_course_name'];
								$responseary['result'][$i]['main_course'] = $val['ss_aw_level'];
								$responseary['result'][$i]['topic_name'] = $val['title_name'];
								$responseary['result'][$i]['course_description'] = $val['ss_aw_description'];
								$responseary['result'][$i]['purchase_date'] = $purchase_date[$val['ss_aw_id']];
								$i++;
							}
						}
					}
				} else { //For testing purpose this line of code commented.Date 2021-08-11
					//As per depanjan sir instruction over skype
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";
					}
				}
				$this->db->trans_complete();
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function store_supplementary_exam_data()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$exam_code = $inputpost['exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$course_id = $inputpost['course_id'];
				$question_id = $inputpost['question_id'];
				$answers_post = $inputpost['answers_post'];
				$answers_status = $inputpost['answers_status']; // 1 = Right, 2 = Wrong

				$storedata = array();
				$storedata['ss_aw_child_id'] = $child_id;
				$storedata['ss_aw_course_id'] = $course_id;
				$storedata['ss_aw_question_id'] = $question_id;
				$storedata['ss_aw_answer_post'] = $answers_post;
				$storedata['ss_aw_answers_status'] = $answers_status;  // 1 = Right, 2 = Wrong,
				$storedata['ss_aw_supplymentary_exam_code'] = $exam_code;

				$this->ss_aw_supplymentary_exam_model->insert_record($storedata);

				$responseary['status'] = 200;
				$responseary['msg'] = "Supplymentary test answers post successfully.";
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function supplementary_exam_finish()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$exam_code = $inputpost['exam_code'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$course_id = $inputpost['course_id'];
				$question_id = $inputpost['question_id'];

				$storedata = array();
				$storedata['ss_aw_child_id'] = $child_id;
				$storedata['ss_aw_course_id'] = $course_id;

				$storedata['ss_aw_supplymentary_exam_code'] = $exam_code;

				$this->ss_aw_supplymentary_exam_finish_model->insert_record($storedata);

				$responseary['status'] = 200;
				$responseary['msg'] = "Supplymentary exam finish successfully.";
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function set_course_complete()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login


			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$course_status = 2; // FINISH
				$data = array();
				$data['ss_aw_course_status'] = $course_status;
				$data['ss_aw_child_course_modified_date'] = date('Y-m-d H:i:s');
				$result = $this->ss_aw_child_course_model->updaterecord_child($child_id, $data);

				$responseary['status'] = 200;
				if ($result == 1)
					$responseary['msg'] = "Course Completed successfully";
				else
					$responseary['msg'] = "Course update fail";
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	public function get_assessments_introduction_audio()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login


			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$responseary['status'] = 200;
				$result = $this->ss_aw_general_settings_model->fetch_record();
				if (!empty($result)) {
					if (!empty($result[0]->ss_aw_welcome_assesment_audio)) {
						$welcome_assesment_audio = base_url() . 'assets/audio/' . $result[0]->ss_aw_welcome_assesment_audio;
					} else {
						$welcome_assesment_audio = "";
					}
				} else {
					$welcome_assesment_audio = "";
				}

				$responseary['assessment_intro_audio_url'] = $welcome_assesment_audio;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			echo json_encode($responseary);
			die();
		}
	}

	//sayan code

	public function assessment_exam_format_two_questions()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$exam_code = time() . "_" . $child_id;

				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];

				$chkCompletion = $this->ss_aw_course_completion_model->checkcoursecompletionRow($child_id, $level_id);

				if (empty($chkCompletion)) {
					if (!empty($inputpost['assessment_exam_code'])) {
						$exam_code = $inputpost['assessment_exam_code'];
						$last_exam_detail = $this->ss_aw_assesment_multiple_question_asked_model->getlastexamquestionindex($child_id, $exam_code);
						if (!empty($last_exam_detail)) {
							$responseary['current_page_index'] = $last_exam_detail[0]->ss_aw_page_index;
							$responseary['back_click_count'] = $last_exam_detail[0]->ss_aw_back_click_count;
						}
					}
				}

				$lessonary = array();
				$lessonary['ss_aw_child_id'] = $child_id;



				$searchary = array();
				$searchary['ss_aw_uploaded_record_id'] = $assessment_id;
				$lessonary = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($searchary);

				if ($level_id == 2) {
					$level = 'C';
				} else if ($level_id == 1) {
					$level = 'E';
				} else if ($level == 3) {
					$level = 'A';
				}


				$setting_result = array();
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

				$resultary = array();
				$resultary['course'] = $level;
				$responseary['status'] = 200;
				$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
				$responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
				$responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
				$responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
				$responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
				$responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
				$responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
				$responseary['lesson_quiz_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_general_language_correct;
				$responseary['lesson_quiz_bad_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_general_language_incorrect;
				$responseary['lesson_quiz_bad_audio2'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_general_language_incorrect2;
				$responseary['skip_duration'] = $idletime;
				$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
				$responseary['skip_type_1_2_duration'] = $idletime;
				$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
				$responseary['assessment_exam_code'] = $exam_code;
				$responseary['assessment_id'] = $assessment_id;

				if (!empty($lessonary)) {
					if ($lessonary[0]['ss_aw_format'] == 'Multiple') {
						/////////////// First Data section ///////////////////////////////
						$i = 0;
						$resultary_inner1 = array();
						foreach ($lessonary as $key => $val) {
							if ($i == 0) {
								$useindexary[] = $val['ss_aw_id'];
								$resultary_inner1['index'] = $val['ss_aw_id'];
								$resultary_inner1['title'] = strip_tags($val['ss_aw_question_preface']);

								$resultary_inner1['assesment_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner1['type'] = 1;  // 1 = Text, 2= Quiz
								$resultary_inner1['comprehension_question'] = 0;

								//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];

								if (!empty($val['ss_aw_question_preface_audio'])) {
									$resultary_inner1['audio'] = base_url() . $val['ss_aw_question_preface_audio'];
								} else {
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
						foreach ($lessonary as $key => $val) {
							if ($key > 0)
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
						foreach ($lessonary as $key => $val) {
							if ($i == 0) {
								$useindexary[] = $val['ss_aw_id'];
								$resultary_inner2['index'] = $val['ss_aw_id'];
								$resultary_inner2['title'] = strip_tags($val['ss_aw_question_preface']);

								$resultary_inner2['assesment_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner2['type'] = 1;  // 1 = Text, 2= Quiz
								$resultary_inner2['comprehension_question'] = 1;

								//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];

								if (!empty($val['ss_aw_question_preface_audio'])) {
									$resultary_inner2['audio'] = base_url() . $val['ss_aw_question_preface_audio'];
								} else {
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
						foreach ($lessonary as $key => $val) {
							if ($i == 0) {
								$useindexary[] = $val['ss_aw_id'];
								$resultary_inner['index'] = $val['ss_aw_id'];
								$resultary_inner['title'] = strip_tags($val['ss_aw_question']);

								$resultary_inner['assesment_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner['type'] = 2;  // 1 = Text, 2= Quiz
								$resultary_inner['comprehension_question'] = 1;
								$resultary_inner['audio'] = "";
								if (!empty($val['ss_aw_question_audio'])) {
									$resultary_inner['audio'] = base_url() . $val['ss_aw_question_audio'];
								}
								//$resultary['data'][0]['recap'] = 0;
								$resultary_inner['details']['course'] = $val['ss_aw_level'];

								$resultary_inner['details']['quizes'][0]['topic_id'] = $val['ss_aw_question_topic_id'];
								$resultary_inner['details']['quizes'][0]['question'] = "";
								$resultary_inner['details']['quizes'][0]['question_id'] = $val['ss_aw_id'];
								if ($val['ss_aw_question_format'] == 'Choose the right answer') {
									$qtype = 2;
								} elseif ($val['ss_aw_question_format'] == 'Fill in the blanks') {
									$qtype = 1;
								} elseif ($val['ss_aw_question_format'] == 'Rewrite the sentence') {
									$qtype = 3;
								} else {
									$qtype = 0;
								}
								$resultary_inner['details']['quizes'][0]['qtype'] = $qtype;

								$multiple_choice_ary = array();
								//$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
								$multiple_choice_ary = explode("/", trim($val['ss_aw_multiple_choice']));

								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								if (!empty($multiple_choice_ary))
									$resultary_inner['details']['quizes'][0]['options'] = $multiple_choice_ary;
								else
									$resultary_inner['details']['quizes'][0]['options'] = array();

								$answersary = array();
								$answersary = explode("/", trim(strip_tags($val['ss_aw_answers'])));

								$answersary = array_map('trim', $answersary);
								if (!empty($answersary)) {
									$resultary_inner['details']['quizes'][0]['answers'] = $answersary;
									$resultary_inner['details']['quizes'][0]['answeraudio'] = base_url() . $val['ss_aw_answers_audio'];
								} else {
									$resultary_inner['details']['quizes'][0]['answers'] = array();
									$resultary_inner['details']['quizes'][0]['answeraudio'] = "";
								}
							}
							$i++;
						}

						array_push($resultary['data'], $resultary_inner);

						$resultary_inner3 = array();

						$i = 0;
						$j = 0;
						foreach ($lessonary as $key => $val) {

							if (($i > 0) && trim($firstvalue) == trim($val['ss_aw_question_preface'])) {
								$useindexary[] = $val['ss_aw_id'];
								$resultary_inner3[$j]['index'] = $val['ss_aw_id'];
								$resultary_inner3[$j]['title'] = strip_tags($val['ss_aw_question']);

								$resultary_inner3[$j]['assesment_format'] = 2; // 1 = Single, 2 = Multiple
								$resultary_inner3[$j]['type'] = 2;  // 1 = Text, 2= Quiz
								$resultary_inner3[$j]['comprehension_question'] = 1;
								$resultary_inner3[$j]['audio'] = "";
								if (!empty($val['ss_aw_question_audio'])) {
									$resultary_inner3[$j]['audio'] = base_url() . $val['ss_aw_question_audio'];
								}

								//$resultary['data'][0]['recap'] = 0;
								$resultary_inner3[$j]['details']['course'] = $val['ss_aw_level'];

								$resultary_inner3[$j]['details']['quizes'][0]['topic_id'] = $val['ss_aw_question_topic_id'];
								$resultary_inner3[$j]['details']['quizes'][0]['question'] = "";
								$resultary_inner3[$j]['details']['quizes'][0]['question_id'] = $val['ss_aw_id'];

								if ($val['ss_aw_question_format'] == 'Choose the right answer') {
									$qtype = 2;
								} elseif ($val['ss_aw_question_format'] == 'Fill in the blanks') {
									$qtype = 1;
								} elseif ($val['ss_aw_question_format'] == 'Rewrite the sentence') {
									$qtype = 3;
								} else {
									$qtype = 0;
								}

								$resultary_inner3[$j]['details']['quizes'][0]['qtype'] = $qtype;

								$multiple_choice_ary = array();
								//$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
								$multiple_choice_ary = explode("/", trim($val['ss_aw_multiple_choice']));

								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								if (!empty($multiple_choice_ary))
									$resultary_inner3[$j]['details']['quizes'][0]['options'] = $multiple_choice_ary;
								else
									$resultary_inner3[$j]['details']['quizes'][0]['options'] = array();

								$answersary = array();
								$answersary = explode("/", trim(strip_tags($val['ss_aw_answers'])));

								$answersary = array_map('trim', $answersary);
								if (!empty($answersary)) {
									$resultary_inner3[$j]['details']['quizes'][0]['answers'] = $answersary;
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = base_url() . $val['ss_aw_answers_audio'];
								} else {
									$resultary_inner3[$j]['details']['quizes'][0]['answers'] = array();
									$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = "";
								}

								$j++;
							}
							$i++;
						}


						foreach ($resultary_inner3 as $value)
							array_push($resultary['data'], $value);

						////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						$i = $j + 2;

						$previous_title = "";
						$firstvalue = trim($lessonary[0]['ss_aw_question_preface']);
						foreach ($lessonary as $key => $val) {
							if (!in_array($val['ss_aw_id'], $useindexary)) {
								if ($firstvalue != trim($val['ss_aw_question_preface'])) {
									if ($previous_title != trim($val['ss_aw_question_preface'])) {
										$i++;
										$j = 0;
										$r = 0;
									} else if ($previous_title == trim($val['ss_aw_question_preface'])) {
										if (!empty($val['ss_aw_question_preface']))
											$j++;
									}
									$previous_title = trim($val['ss_aw_question_preface']);

									$resultary['data'][$i]['index'] = $val['ss_aw_id'];
									if ($val['ss_aw_format'] == 'Single')
										$resultary['data'][$i]['assesment_format'] = 1;
									else
										$resultary['data'][$i]['assesment_format'] = 2;

									$resultary['data'][$i]['type'] = 2;
									/* $resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id']; */
									$resultary['data'][$i]['title'] = strip_tags($val['ss_aw_question_preface']);
									if (!empty($val['ss_aw_question_preface_audio']))
										$resultary['data'][$i]['audio'] = base_url() . $val['ss_aw_question_preface_audio'];
									else
										$resultary['data'][$i]['audio'] = "";


									$resultary['data'][$i]['details']['course'] = $val['ss_aw_level'];

									$resultary['data'][$i]['details']['examples'] = array();

									if ($val['ss_aw_question_format'] == 'Choose the right answer') {
										$qtype = 2;
									} elseif ($val['ss_aw_question_format'] == 'Fill in the blanks') {
										$qtype = 1;
									} elseif ($val['ss_aw_question_format'] == 'Rewrite the sentence') {
										$qtype = 3;
									} else {
										$qtype = 0;
									}

									if ($qtype > 0) {
										$resultary['data'][$i]['details']['quizes'][$j]['topic_id'] = $val['ss_aw_question_topic_id'];
										$resultary['data'][$i]['details']['quizes'][$j]['qtype'] = $qtype;
										$resultary['data'][$i]['details']['quizes'][$j]['question'] = strip_tags($val['ss_aw_question']);
										$resultary['data'][$i]['details']['quizes'][$j]['question_id'] = $val['ss_aw_id'];
										$multiple_choice_ary = array();
										//$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
										$multiple_choice_ary = explode("/", trim($val['ss_aw_multiple_choice']));

										$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
										//if(count($multiple_choice_ary) > 1)
										$resultary['data'][$i]['details']['quizes'][$j]['options'] = $multiple_choice_ary;
										//else
										//$resultary['data'][$i]['details']['quizes'][$j]['options'] = $val['ss_aw_lesson_question_options'];

										$answersary = array();
										$answersary = explode("/", trim(strip_tags($val['ss_aw_answers'])));

										$answersary = array_map('trim', $answersary);

										$resultary['data'][$i]['details']['quizes'][$j]['answers'] = $answersary;
										//$resultary['data'][$i]['details']['quizes'][$j]['answer'] = $val['ss_aw_lesson_answers'];
										$resultary['data'][$i]['details']['quizes'][$j]['answeraudio'] = base_url() . $val['ss_aw_answers_audio'];
									} else {
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
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	public function store_current_assesment_page()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$exam_code = $inputpost['assessment_exam_code'];
			$back_click_count = $inputpost['back_click_count'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$assessment_id = ($inputpost['assessment_id']);
				$assessment_index_id = ($inputpost['assessment_index_id']);
				$assessment_details = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
				$assessmentary = array();
				$assessmentary['ss_aw_assessment_id'] = $assessment_id;
				$assessmentary['ss_aw_assessment_topic'] = $assessment_details[0]->ss_aw_assesment_topic;
				$assessmentary['ss_aw_child_id'] = $child_id;
				$assessmentary['ss_aw_page_index'] = $assessment_index_id;
				$assessmentary['ss_aw_exam_code'] = $exam_code;
				$assessmentary['ss_aw_created_at'] = date('Y-m-d H:i:s');
				$assessmentary['ss_aw_back_click_count'] = $back_click_count;
				$check_current_status = $this->ss_aw_assesment_multiple_question_asked_model->check_existance($assessment_index_id, $assessment_id, $child_id, $exam_code);
				if ($check_current_status == 0) {
					$this->ss_aw_assesment_multiple_question_asked_model->insert_record($assessmentary);
				}
				$responseary['status'] = '200';
				$responseary['msg'] = 'Assessment current status updated';
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			echo json_encode($responseary);
			die();
		}
	}

	//store assesment format 2 answers
	public function store_assesment_quiz()
	{
		$postdata = $this->input->post();
		if ($postdata) {
			$child_id = $postdata['user_id'];
			$childary = $this->ss_aw_child_course_model->get_details($child_id);
			$level = $childary[count($childary) - 1]['ss_aw_course_id'];
			$assessment_id = $postdata['assessment_id'];
			$assessment_exam_code = $postdata['assessment_exam_code'];
			$question = $postdata['question'];
			$topic_id = $postdata['topic_id'];
			$answer = $postdata['answer'];
			$right_answers = $postdata['right_answers'];
			/* if ($right_answers) {
              $right_answers = implode(",", $right_answers);
              }
              else{
              $right_answers = "";
              } */
			$answers_status = $postdata['answers_status'];
			$seconds_to_start_answer_question = $postdata['seconds_to_start_answer_question'];
			$seconds_to_answer_question = $postdata['seconds_to_answer_question'];
			$question_id = $postdata['question_id'];

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
				'ss_aw_question_id' => $question_id,
				'ss_aw_created_at' => date('Y-m-d h:i:s')
			);

			$check_existance = $this->ss_aw_assesment_multiple_question_answer_model->check_data($data);

			if ($check_existance) {
				$record_id = $check_existance[0]->ss_aw_id;
				$this->ss_aw_assesment_multiple_question_answer_model->update_record($data, $record_id);
				$msg = "Assesment answer record updated successfully.";
			} else {
				$this->ss_aw_assesment_multiple_question_answer_model->store_data($data);
				$msg = "Assesment answer record stored successfully.";
			}

			$responseary['status'] = '200';
			$responseary['msg'] = $msg;

			die(json_encode($responseary));
		}
	}

	//function to check readalong scheduled or not after lesson completion.
	public function readalong_scheduled_or_not()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = $childary[count($childary) - 1]['ss_aw_course_id'];
				//get restricted time
				$restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($level);
				$restriction_time = $restriction_detail[0]->restricted_time;

				//get lesson count
				$total_lesson = $this->ss_aw_child_last_lesson_model->getcompletelessoncount($child_id, $level);

				if ($total_lesson > 0) {
					$responseary['status'] = 200;
					if ($level == 1) {
						if (($total_lesson % 2) == 1) {
							$fetch_lesson_num = $total_lesson;
						} else {
							$fetch_lesson_num = $total_lesson - 1;
						}
					} else {
						$fetch_lesson_num = $total_lesson;
					}

					$get_lesson_completion_detail = $this->ss_aw_child_last_lesson_model->getcompletelessondetailbyindex($fetch_lesson_num, $child_id, $level);
					if (!empty($get_lesson_completion_detail)) {
						$lesson_format = $get_lesson_completion_detail[0]->ss_aw_lesson_format;
						$start_date = $get_lesson_completion_detail[0]->ss_aw_last_lesson_create_date;
						$end_date = date('Y-m-d H:i:s', strtotime($start_date . "+ " . $restriction_time . " minutes"));

						$check_last_assign_readalong = $this->ss_aw_schedule_readalong_model->getlastassignedrecord($child_id);
						if (!empty($check_last_assign_readalong)) {
							if (($check_last_assign_readalong[0]->ss_aw_schedule_readalong >= $start_date) && ($check_last_assign_readalong[0]->ss_aw_schedule_readalong <= $end_date)) {
								$responseary['scheduled'] = 1; //Readalong scheduled.
							} else {
								$responseary['scheduled'] = 0; //Readalong not scheduled.
							}
						} else {
							$responseary['scheduled'] = 0;
						}
					}
				} else {
					$responseary['status'] = 200;
					$responseary['scheduled'] = 0;
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	//function to get readalong selection time
	public function get_readalong_selection_time_restriction()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];
				$result_arrr = $this->ss_aw_course_count_model->get_course_count($course_id);
				$total_course_readalong = $result_arrr[0]['ss_aw_readalong'];

				$readalong_scheduler = 0;
				$check_active_readalong = $this->ss_aw_schedule_readalong_model->get_active_readalong_count($child_id, $course_id);
				$total_readalong_complete_num = $this->ss_aw_last_readalong_model->get_total_complete_count($child_id, $course_id);
				if (($check_active_readalong == 0) && ($total_readalong_complete_num < $total_course_readalong)) {
					$readalong_scheduler = 1;
				}
				$responseary['status'] = 200;
				$responseary['readalong_scheduler'] = $readalong_scheduler;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	public function notification()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$responseary['status'] = 200;
				$notification_list = $this->ss_aw_notification_model->getallnotification($child_id, 2);
				if (!empty($notification_list)) {
					foreach ($notification_list as $key => $value) {
						$responseary['result'][$key]['notification_id'] = $value->id;
						$responseary['result'][$key]['title'] = $value->title;
						$responseary['result'][$key]['notification'] = $value->msg;
						$responseary['result'][$key]['action'] = $value->action;
						$responseary['result'][$key]['is_read'] = $value->read_unread;
						$responseary['result'][$key]['notify_date'] = $value->created_at;
					}
				} else {
					$responseary['msg'] = "No data found.";
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
		}

		die(json_encode($responseary));
	}

	public function check_assessment_ready_or_not()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$check_assessment_ready = $this->ss_aw_assisment_diagnostic_model->checkassessmentreadyornot($assessment_id);
				$responseary['status'] = 200;
				if ($check_assessment_ready == 0) {
					$responseary['access_assessment'] = 1;
				} else {
					$responseary['access_assessment'] = 0;
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	public function load_configs()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login

			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$setting_result = $this->ss_aw_general_settings_model->fetch_record();
				if (!empty($setting_result)) {
					$responseary['status'] = 200;
					$responseary['msg'] = 'Data found.';
					$lesson_assessment_time_gap = 0;
					if (!empty($setting_result[0]->ss_aw_lesson_assessment_time_difference)) {
						$lesson_assessment_time_gap = $setting_result[0]->ss_aw_lesson_assessment_time_difference * 60;
					}

					$lesson_time_gap = 0;
					if (!empty($setting_result[0]->ss_aw_lesson_time_gap)) {
						$lesson_time_gap = $setting_result[0]->ss_aw_lesson_time_gap * 60;
					}

					$next_course_time_gap = 0;
					if ($setting_result[0]->ss_aw_next_course_start_time) {
						$next_course_time_gap = $setting_result[0]->ss_aw_next_course_start_time * 60;
					}

					$supplymentary_time_gap = 0;
					if (!empty($setting_result[0]->ss_aw_supplementary_content_access_duration)) {
						$supplymentary_time_gap = $setting_result[0]->ss_aw_supplementary_content_access_duration * 60;
					}

					$responseary['data']['lesson_assessment_time_difference'] = $lesson_assessment_time_gap;
					//$responseary['data']['lesson_assessment_time_difference'] = 5;
					$responseary['data']['lesson_time_gap'] = $lesson_time_gap;
					//$responseary['data']['lesson_time_gap'] = 10;
					$responseary['data']['next_course_start_time'] = $next_course_time_gap;
					$responseary['data']['supplementary_content_access_duration'] = $supplymentary_time_gap;
				} else {
					$responseary['status'] = 500;
					$responseary['msg'] = 'Data not found';
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	public function check_lesson_ready_or_not()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$lesson_id = $inputpost['lesson_id'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$check_assessment_ready = $this->ss_aw_lessons_model->check_lesson_audio_non_existance_number($lesson_id);
				$responseary['status'] = 200;
				if ($check_assessment_ready == 0) {
					$responseary['access_lesson'] = 1;
				} else {
					$responseary['access_lesson'] = 0;
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	public function markreadalongcomprehensionasread()
	{
		$postdata = $this->input->post();
		$child_id = $postdata['user_id'];
		$child_token = $postdata['user_token'];
		$readalong_id = $postdata['readalong_id'];
		$responseary = array();
		$parent_id = "";
		if (!empty($postdata['parent_id'])) {
			$parent_id = $postdata['parent_id'];
		}

		if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
			$data = array();
			$data['ss_aw_child_id'] = $child_id;
			$data['ss_aw_readalong_id'] = $readalong_id;
			$data['ss_aw_comprehension_read'] = 1;
			$response = $this->ss_aw_schedule_readalong_model->changereadalongcomprehensionstatus($child_id, $readalong_id);

			$responseary['status'] = 200;
			$responseary['msg'] = "Marked as read.";
		} else {
			$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";
			}
		}

		die(json_encode($responseary));
	}

	public function get_emi_status()
	{
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$child_id = $postdata['user_id'];
			$child_token = $postdata['user_token'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = "";
				$accessable = 1;
				if (!empty($childary)) {
					$course_id = $childary[count($childary) - 1]['ss_aw_course_id'];
					if ($course_id == 1) {
						$level = "E";
					} elseif ($course_id == 2) {
						$level = "C";
					} elseif ($course_id == 3) {
						$level = "A";
					}

					//get accessibility of course
					if ($childary[count($childary) - 1]['ss_aw_course_payemnt_type'] == 1) {
						//get first emi payment date
						$first_emi_date = date('Y-m-d', strtotime($childary[0]['ss_aw_child_course_create_date']));

						//get present emi day num after first payment date
						$searchary = array(
							'ss_aw_child_id' => $child_id,
							'ss_aw_selected_course_id' => $course_id
						);

						$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
						$present_emi_day_num = count($count_previous_emi) * 31; //31 is the day interval between two emis
						//calculate next emi date
						$next_emi_date = date('Y-m-d', strtotime($first_emi_date . " +" . $present_emi_day_num . " days"));
						$next_emi_date_time = strtotime($next_emi_date);
						$current_date = date('Y-m-d');
						$current_date_time = strtotime($current_date);
						$datediff = $next_emi_date_time - $current_date_time;
						$mid_days = round($datediff / (60 * 60 * 24));
						if ($mid_days >= -1) {
							$accessable = 1;
						} else {
							$accessable = 0;
						}
					} else {
						$accessable = 1;
					}
				}

				$responseary['status'] = 200;
				$responseary['data']['child_accessibility'] = $accessable;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
		} else {
			$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";
			}
		}

		die(json_encode($responseary));
	}

	public function get_block_status()
	{
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$child_id = $postdata['user_id'];
			$child_token = $postdata['user_token'];
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$child_details = $this->ss_aw_childs_model->get_details($child_id);
				$block = $child_details[0]['ss_aw_blocked'];
				if ($block == 1) {
					$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1034');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
					}
				} else {
					$responseary['status'] = 200;
					$responseary['msg'] = "Success";
				}
				$responseary['data']['block'] = $block;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
				}
			}
		} else {
			$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";
			}
		}

		die(json_encode($responseary));
	}

	public function store_readalong_comprehension_page()
	{
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$child_id = $postdata['user_id'];
			$child_token = $postdata['user_token'];
			$parent_id = "";
			if (!empty($postdata['parent_id'])) {
				$parent_id = $postdata['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$page_index = $postdata['page_index'];
				$readalong_id = $postdata['readalong_id'];
				$data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_page_index' => $page_index,
					'ss_aw_readalong_id' => $readalong_id
				);

				$response = $this->ss_aw_store_readalong_page_model->store_page_index($data);
				if ($response) {
					$responseary['status'] = 200;
					$responseary['msg'] = "Page index stored successfully.";
				} else {
					$responseary['status'] = 200;
					$responseary['msg'] = "Something went wrong, please try again later.";
				}
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}

	public function show_confidence_based_on_index($child_id, $level, $topic)
	{
		$get_timing = $this->store_procedure_model->getquestioncompletetimebytopic($child_id, $level, $topic);
		$all_question_complete_timing = $get_timing[0]->ss_aw_all_question;
		$combine_score_detail = $this->store_procedure_model->get_total_combine_score_by_topic($child_id, $level, $topic);
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
				} else {
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
			} else {
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

	public function check_parent_existance($parent_id, $parent_token)
	{
		$response = $this->ss_aw_parents_model->check_parent_existance($parent_id, $parent_token);
		if ($response) {
			// $check_self_registration = $this->ss_aw_childs_model->check_self_registration($parent_id);
			// if ($check_self_registration->ss_aw_child_status == 1 && $check_self_registration->ss_aw_blocked == 0) {
			// 	return 1;
			// } else {
			// 	$responseary['status'] = 1025;
			// 	$responseary['msg'] = "Due to inactivity your account has been blocked. Kindly contact the system admin";
			// 	$this->ss_aw_childs_model->logout($child_id);
			// 	die(json_encode($responseary));
			// }
			return 1;
		} else {
			$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
			}
		}
		echo json_encode($responseary);
		die();
	}

	public function lesson_question_inserted()
	{
		$this->load->model('ss_aw_child_lesson_model');
		$child_data = $this->ss_aw_child_lesson_model->get_all_lesson_type();

		if (!empty($child_data)) {
			foreach ($child_data->result() as $chld) {

				$child_id = $chld->ss_aw_child_id;
				$child_age = $chld->age;
				$level = $chld->ss_aw_course_id;
				$lesson_id = $chld->ss_aw_lesson_id;

				switch ($level) {
					case ($level == 1 || $level == 2) && $child_age < 13 && $lesson_id > 10:
						$course_id = 2;
						break;
					case ($level == 1 || $level == 2) && $child_age < 13 && $lesson_id <= 10:
						$course_id = 1;
						break;
					case ($level == 1 || $level == 2) && $child_age >= 13:
						$course_id = 2;
						break;
					case ($level == 5) && $lesson_id <= 10:
						$course_id = 2;
						break;
					case ($level == 5) && $lesson_id > 10 && $lesson_id < 56:
						$course_id = 3;
						break;
					case ($level == 5) && $lesson_id >= 56:
						$course_id = 4;
						break;
					default:
						$course_id = 3;
						break;
				}
				// echo $child_id.','.$course_id.','.$lesson_id;exit;
				$check_question_count = $this->ss_aw_child_lesson_model->get_question_count($child_id, $course_id, $lesson_id);

				if ($check_question_count->cnt_lesson > $check_question_count->cnt_lesson_done) {
					//                    echo $check_question_count->cnt_lesson.','.$check_question_count->cnt_lesson_done;exit;
					//                   echo $child_id.','.$course_id.','.$lesson_id;exit;
					$limit = $check_question_count->cnt_lesson - $check_question_count->cnt_lesson_done;
					$this->ss_aw_child_lesson_model->data_lesson_quize_insert($child_id, $course_id, $lesson_id, $limit);

					$this->ss_aw_child_lesson_model->update_lesson_score($child_id, $lesson_id, $limit);
				}
			}
		}
		return true;
	}

	public function lesson_data_checking($child_id, $lesson_id, $level)
	{
		$this->load->model('ss_aw_child_lesson_model');
		$child_age = $this->ss_aw_child_lesson_model->get_child_age($child_id, $level);
		switch ($level) {
			case ($level == 1 || $level == 2) && $child_age->age < 13 && $lesson_id > 10:
				$course_id = 2;
				break;
			case ($level == 1 || $level == 2) && $child_age->age < 13 && $lesson_id <= 10:
				$course_id = 1;
				break;
			case ($level == 1 || $level == 2) && $child_age->age >= 13:
				$course_id = 2;
				break;
			case ($level == 5) && $lesson_id <= 10:
				$course_id = 2;
				break;
			case ($level == 5) && $lesson_id > 10 && $lesson_id < 56:
				$course_id = 3;
				break;
			case ($level == 5) && $lesson_id >= 56:
				$course_id = 4;
				break;
			default:
				$course_id = 3;
				break;
		}

		$check_question_count = $this->ss_aw_child_lesson_model->get_question_count($child_id, $course_id, $lesson_id);

		if ($check_question_count->cnt_lesson > $check_question_count->cnt_lesson_done) {
			$limit = $check_question_count->cnt_lesson - $check_question_count->cnt_lesson_done;
			$this->ss_aw_child_lesson_model->data_lesson_quize_insert($child_id, $course_id, $lesson_id, $limit);
			$this->ss_aw_child_lesson_model->update_lesson_score($child_id, $lesson_id, $limit);
		}

		return true;
	}
public function is_adult_buy_master()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if ($inputpost) {
			$child_id = $inputpost['user_id']; // Child Record ID from Database
			$child_token = $inputpost['user_token']; // Token get after login
			$parent_id = "";
			if (!empty($inputpost['parent_id'])) {
				$parent_id = $inputpost['parent_id'];
			}

			if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
				$data = $this->ss_aw_purchase_courses_model->get_single_course_details($child_id);
				$responseary['status'] = 200;
				$responseary['msg'] = "Data fatched successfully";
				$responseary['is_master_buy'] = $data;
			} else {
				$error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}

			die(json_encode($responseary));
		}
	}
}
