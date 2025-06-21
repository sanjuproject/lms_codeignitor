		<?php
		defined('BASEPATH') OR exit('No direct script access allowed');

		class Notifications extends CI_Controller {

			/**
			 * Index Page for this controller.
			 *
			 * Maps to the following URL
			 * 		http://example.com/index.php/welcome
			 *	- or -
			 * 		http://example.com/index.php/welcome/index
			 *	- or -
			 * Since this controller is set as the default controller in
			 * config/routes.php, it's displayed at http://example.com/
			 *
			 * So any other public methods not prefixed with an underscore will
			 * map to /index.php/welcome/<method_name>
			 * @see https://codeigniter.com/user_guide/general/urls.html
			 */
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
				$this->load->model('ss_aw_diagonastic_exam_model');
				$this->load->model('ss_aw_diagonastic_exam_model');
				$this->load->model('ss_aw_parents_model');
				$this->load->model('ss_aw_admin_users_model');
				$this->load->model('ss_aw_adminmenus_model');
				$this->load->model('ss_aw_roles_category_model');
				$this->load->model('ss_aw_page_content_model');
				$this->load->model('ss_aw_faq_model');
				$this->load->model('ss_aw_courses_model');
				$this->load->model('ss_aw_currencies_model');
				$this->load->model('ss_aw_lessons_model');
				$this->load->model('ss_aw_email_valification_model');
				$this->load->model('ss_aw_phone_valification_model');
				$this->load->model('ss_aw_sections_subtopics_model');
				$this->load->model('ss_aw_test_timing_model');
				$this->load->model('ss_aw_general_settings_model');
				$this->load->model('ss_aw_assessment_subsection_matrix_model');
				$this->load->model('ss_aw_email_notification_cms_model');
				$this->load->model('ss_aw_app_notification_cms_model');
				$this->load->model('ss_aw_imagegallery_model');
				$this->load->model('ss_aw_readalong_model');
				$this->load->model('ss_aw_supplymentary_model');
				$this->load->model('ss_aw_lessons_uploaded_model');
				$this->load->model('ss_aw_assesment_uploaded_model');
				$this->load->model('ss_aw_readalongs_upload_model');
				$this->load->model('ss_aw_supplymentary_uploaded_model');
				$this->load->model('ss_aw_child_last_lesson_model');
				$this->load->model('ss_aw_assesment_reminder_model');
				$this->load->model('ss_aw_readalong_reminder_model');
				$this->load->model('ss_aw_program_invitation_reminder_model');
				$this->load->model('ss_aw_child_course_model');
				$this->load->helper('directory');
				$this->load->model('ss_aw_readalong_restriction_model');
				$this->load->model('ss_aw_schedule_readalong_model');
				$this->load->model('ss_aw_last_readalong_model');
				$this->load->model('notification_model');
				$this->load->model('ss_aw_lesson_score_model');
				$this->load->model('ss_aw_assessment_score_model');
				$this->load->model('ss_aw_child_result_model');
				$this->load->model('ss_aw_email_que_model');
			} 

			/*public function diagnostic_invitation()
			{
				$parentsary = array();
				$searchval = date('Y-m-d 00:00:00',strtotime("-3 days"));
				$this->db->select('*');
				$this->db->from('ss_aw_parents');
				$this->db->where('ss_aw_parent_created_date >=',$searchval);
				$this->db->where('ss_aw_parent_delete',0);
				$parentsary = $this->db->get()->result_array();
				foreach($parentsary as $value)
				{
					$email_template = getemailandpushnotification(2, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@username@@]", $value['ss_aw_parent_full_name'], $body);
						emailnotification($value['ss_aw_parent_email'], $email_template['title'], $body);
					}

					$app_template = getemailandpushnotification(2, 2);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$title = $app_template['title'];
						$token = $value['ss_aw_device_token'];

						pushnotification($title,$body,$token,1);

						$save_data = array(
							'user_id' => $value['ss_aw_parent_id'],
							'user_type' => 1,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 1
						);

						save_notification($save_data);

					}
						
				}
				die();
			}*/

			/*public function diagnostic_quiz_link(){
				$parentsary = array();
				$searchval = date('Y-m-d 00:00:00',strtotime("-3 days"));
				$parentsary = $this->notification_model->getdiagnosticinviteparents($searchval);

				if (!empty($parentsary)) {
					foreach($parentsary as $value) {
						$child_details = $this->ss_aw_childs_model->get_child_details($value['ss_aw_parent_id']);
						$email_template = getemailandpushnotification(3, 1, 1);
						$app_template = getemailandpushnotification(3, 2, 1);
						if (!empty($child_details)) {
							foreach ($child_details as $key => $childs) {
								$check_child_exam = $this->notification_model->check_diagnostic_exam_data($childs->ss_aw_child_id);
								if ($check_child_exam == 0) {
									if (!empty($email_template)) {
										$body = $email_template['body'];
										$body = str_ireplace("[@@username@@]", $value['ss_aw_parent_full_name'], $body);
										$body = str_ireplace("[@@child_name@@]", $childs->ss_aw_child_nick_name, $body);
										emailnotification($value['ss_aw_parent_email'], $email_template['title'], $body);	
									}

									//app notification
									if (!empty($app_template)) {
										$body = $app_template['body'];
										$body = str_ireplace("[@@child_name@@]", $childs->ss_aw_child_nick_name, $body);
										$title = $app_template['title'];
										$token = $value['ss_aw_device_token'];

										if (!empty($token)) {
											pushnotification($title,$body,$token,1);	
										}

										$save_data = array(
											'user_id' => $childs->ss_aw_child_id,
											'user_type' => 1,
											'title' => $title,
											'msg' => $body,
											'status' => 1,
											'read_unread' => 0,
											'action' => 1
										);

										save_notification($save_data);

									}	
								}
							}
						}
					}
				}
			}*/

			// public function diagnostic_invitation(){
			// 	$parentsary = array();
			// 	$searchval = date('Y-m-d 00:00:00',strtotime("-7 days"));
			// 	$childs = $this->notification_model->getdiagnosticinvitechilds($searchval);
			// 	$email_template = getemailandpushnotification(2, 1, 1);
			// 	$app_template = getemailandpushnotification(2, 2, 1);

			// 	$child_email_template = getemailandpushnotification(2, 1, 2);
			// 	if (!empty($childs)) {
			// 		foreach ($childs as $key => $value) {
			// 			$check_child_exam = $this->notification_model->check_diagnostic_exam_data($value->ss_aw_child_id);
			// 			if ($check_child_exam == 0) {
			// 				if (!empty($email_template)) {
			// 					$body = $email_template['body'];
			// 					$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
			// 					emailnotification($value->ss_aw_parent_email, $email_template['title'], $body);	
			// 				}

			// 				//app notification
			// 				if (!empty($app_template)) {
			// 					$body = $app_template['body'];
			// 					$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
			// 					$title = $app_template['title'];
			// 					$token = $value->parent_device_token;

			// 					if (!empty($token)) {
			// 						pushnotification($title,$body,$token,4);	
			// 					}

			// 					$save_data = array(
			// 						'user_id' => $value->parent_id,
			// 						'user_type' => 1,
			// 						'title' => $title,
			// 						'msg' => $body,
			// 						'status' => 1,
			// 						'read_unread' => 0,
			// 						'action' => 4
			// 					);

			// 					save_notification($save_data);
			// 				}

			// 				//send email notification to students

			// 				if (!empty($child_email_template)) {
			// 					$body = $child_email_template['body'];
			// 					$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
			// 					$body = str_ireplace("[@@login_id@@]", $value->ss_aw_child_code, $body);
			// 					$body = str_ireplace("[@@password@@]", "", $body);
			// 					emailnotification($value->ss_aw_child_email, $child_email_template['title'], $body);	
			// 				}
			// 			}
			// 		}
			// 	}
			// }

			// public function invitation_to_enrol()
			// {
			// 	$parentsary = array();
			// 	$searchval = date('Y-m-d 00:00:00',strtotime("-3 days"));

			// 	$this->db->select('ss_aw_parents.ss_aw_parent_email,ss_aw_parents.ss_aw_parent_primary_mobile,ss_aw_parents.ss_aw_parent_full_name,ss_aw_parents.ss_aw_device_token');
			// 	$this->db->from('ss_aw_diagonastic_exam');
			// 	$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
			// 	$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
			// 	$this->db->where('ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date >=', $searchval);
			// 	$parentsary = $this->db->get()->result_array();

			// 	if (!empty($parentsary)) {
			// 		foreach($parentsary as $value)
			// 		{
			// 			$email_template = getemailandpushnotification(5, 1);
			// 			if (!empty($email_template)) {
			// 				$body = $email_template['body'];
			// 				$body = str_ireplace("[@@username@@]", $value['ss_aw_parent_full_name'], $body);
			// 				emailnotification($value['ss_aw_parent_email'], $email_template['title'], $email_template['body']);
			// 			}

			// 			$app_template = getemailandpushnotification(5, 2);
			// 			if (!empty($app_template)) {
			// 				$body = $app_template['body'];
			// 				$title = $app_template['title'];
			// 				$token = $value['ss_aw_device_token'];

			// 				pushnotification($title,$body,$token,63);

			// 				$save_data = array(
			// 					'user_id' => $value['ss_aw_parent_id'],
			// 					'user_type' => 1,
			// 					'title' => $title,
			// 					'msg' => $body,
			// 					'status' => 1,
			// 					'read_unread' => 0,
			// 					'action' => 63
			// 				);

			// 				save_notification($save_data);

			// 			}
			// 		}	
			// 	}
			// 	die();
			// }

			public function first_assesment_quiz_reminder(){
				$result = $this->ss_aw_child_last_lesson_model->getallcompletelessonresult();
				if (!empty($result)) {
					foreach($result as $key => $value){
						$childary = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
						$level = $childary[count($childary) - 1]['ss_aw_course_id'];
						//creating lesson serial no
						$topic_listary = array();
						$general_language_lessons = array();
						if ($level == 1 || $level == 2) {
							$search_data = array();
							$search_data['ss_aw_expertise_level'] = 'E';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
							$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
						}
						elseif($level == 3){
							$search_data = array();
							$search_data['ss_aw_expertise_level'] = 'C';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
							$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
						}
						else{
							$search_data = array();
							$search_data['ss_aw_expertise_level'] = 'A,M';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
						}
						$topicAry = array();
						if (!empty($topic_listary)) {
							foreach ($topic_listary as $key => $val) {
								$topicAry[] = $val->ss_aw_section_id;
							}
						}
						$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

						$lesson_listary = array_merge($topical_lessons, $general_language_lessons);

						$serial_ary = array();
						if (!empty($lesson_listary)) {
							if ($level == 3) {
								$lesson_count = 16;
							}
							else{
								$lesson_count = 1;	
							}

							foreach ($lesson_listary as $key => $lesson) {
								if (strtolower($lesson['ss_aw_lesson_format']) == 'single') {
									$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_count;
									$lesson_count++;	
								}
								else{
									$lesson_name_ary = explode(" ", $lesson['ss_aw_lesson_topic']);
									$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_name_ary[count($lesson_name_ary) - 1];
								}
							}
						}
						//end

						$current_date = date('Y-m-d');
						$current_date = strtotime($current_date);
						$lesson_complete_date = date('Y-m-d', strtotime($value->ss_aw_last_lesson_modified_date));
						$lesson_complete_date = strtotime($lesson_complete_date);
						$diff = $current_date - $lesson_complete_date;
						$diffDay = round($diff / (60 * 60 * 24));
						
						if($diffDay >= 2){
							$complete_days_num = convert_number($diffDay);
							$check_assessment_completion = $this->notification_model->check_assessment_completion($value->ss_aw_last_lesson_modified_date, $value->ss_aw_child_id);
							if (count($check_assessment_completion) == 0) {
								$response = $this->ss_aw_assesment_reminder_model->check_first_reminder($value->ss_aw_child_id, $value->ss_aw_lesson_id);
								if (empty($response)) {
									{
										$data = array(
											'child_id' => $value->ss_aw_child_id,
											'lesson_id' => $value->ss_aw_lesson_id,
											'type' => 1,
											'notify_time' => date('Y-m-d H:i:s')
										);

										$check_insertion = $this->ss_aw_assesment_reminder_model->save_notification($data);
										
										if ($check_insertion) {
											$serial_no = 0;
											if (!empty($serial_ary)) {
												$serial_no = $serial_ary[$value->ss_aw_lesson_id];
											}
											$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);
											$lesson_details = $this->ss_aw_lessons_uploaded_model->getlessonbyid($value->ss_aw_lesson_id);
											$lesson_name = $lesson_details[0]->ss_aw_lesson_topic;
											$email_template = getemailandpushnotification(11, 1, 2);
											if (!empty($email_template)) {
												$body = $email_template['body'];
												$body = str_ireplace("[@@child_name@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
												$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
												$body = str_ireplace("[@@reminder_number@@]", "first", $body);
												$body = str_ireplace("[@@lesson_completed_days@@]", $complete_days_num, $body);
												$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
												emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
											}

											$app_template = getemailandpushnotification(11, 2, 2);
											if (!empty($app_template)) {
												$body = $app_template['body'];
												$title = $app_template['title'];
												$token = $child_profile[0]->ss_aw_device_token;

												pushnotification($title,$body,$token,16);

												$save_data = array(
													'user_id' => $value->ss_aw_child_id,
													'user_type' => 2,
													'title' => $title,
													'msg' => $body,
													'status' => 1,
													'read_unread' => 0,
													'action' => 16
												);

												save_notification($save_data);

											}

										}
									}
									
								}	
							}
						}
					}
				}

				die();
			}

			public function final_assesment_quiz_reminder(){
				$searchval = date('Y-m-d 00:00:00',strtotime("-3 days"));
				$result = $this->ss_aw_assesment_reminder_model->getallfirstreminder($searchval);
				
				if(!empty($result)){
					foreach($result as $value){
						$childary = $this->ss_aw_child_course_model->get_details($value->child_id);
						$level = $childary[count($childary) - 1]['ss_aw_course_id'];
						//creating lesson serial no
						$topic_listary = array();
						$general_language_lessons = array();
						if ($level == 1 || $level == 2) {
							$search_data = array();
							$search_data['ss_aw_expertise_level'] = 'E';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
							$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
						}
						elseif($level == 3){
							$search_data = array();
							$search_data['ss_aw_expertise_level'] = 'C';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(10, 15);
							$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
						}
						else{
							$search_data = array();
							$search_data['ss_aw_expertise_level'] = 'A,M';
							$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
						}
						$topicAry = array();
						if (!empty($topic_listary)) {
							foreach ($topic_listary as $key => $val) {
								$topicAry[] = $val->ss_aw_section_id;
							}
						}
						$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

						$lesson_listary = array_merge($topical_lessons, $general_language_lessons);

						$serial_ary = array();
						if (!empty($lesson_listary)) {
							if ($level == 3) {
								$lesson_count = 16;
							}
							else{
								$lesson_count = 1;	
							}

							foreach ($lesson_listary as $key => $lesson) {
								if (strtolower($lesson['ss_aw_lesson_format']) == 'single') {
									$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_count;
									$lesson_count++;	
								}
								else{
									$lesson_name_ary = explode(" ", $lesson['ss_aw_lesson_topic']);
									$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_name_ary[count($lesson_name_ary) - 1];
								}
							}
						}
						//end
						$check_assessment_completion = $this->notification_model->check_assessment_completion($value->notify_time, $value->child_id);
						if (count($check_assessment_completion) == 0) {
							$response = $this->ss_aw_assesment_reminder_model->check_last_reminder($value->child_id, $value->lesson_id);
							if ($response < 2) {
								if ($response == 0) {
									$notification_number_in_words = "second";
								}
								elseif ($response == 1) {
									$notification_number_in_words = "third";
								}
								
								$data = array(
									'child_id' => $value->child_id,
									'lesson_id' => $value->lesson_id,
									'type' => 2,
									'notify_time' => date('Y-m-d H:i:s')
								);

								$check_insertion = $this->ss_aw_assesment_reminder_model->save_notification($data);
								if ($check_insertion) {
									$serial_no = 0;
									if (!empty($serial_ary)) {
										$serial_no = $serial_ary[$value->lesson_id];
									}
									$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->child_id);
									$lesson_details = $this->ss_aw_lessons_uploaded_model->getlessonbyid($value->lesson_id);
										$lesson_name = $lesson_details[0]->ss_aw_lesson_topic;

										//get lesson complete details
										$lesson_complete = $this->ss_aw_child_last_lesson_model->fetch_details_byparam(array('ss_aw_lesson_id' => $value->lesson_id,'ss_aw_child_id' => $value->child_id));
										$current_date = date('Y-m-d');
										$current_date = strtotime($current_date);
										$lesson_complete_date = date('Y-m-d', strtotime($lesson_complete[0]['ss_aw_last_lesson_modified_date']));
										$lesson_complete_date = strtotime($lesson_complete_date);
										$diff = $current_date - $lesson_complete_date;
										$diffDay = round($diff / (60 * 60 * 24));
										$complete_days_num = convert_number($diffDay);
									$email_template = getemailandpushnotification(11, 1, 2);
									if (!empty($email_template)) {
										$body = $email_template['body'];
										$body = str_ireplace("[@@child_name@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
										$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
											$body = str_ireplace("[@@reminder_number@@]", $notification_number_in_words, $body);
											$body = str_ireplace("[@@lesson_completed_days@@]", $complete_days_num, $body);
											$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
											
										emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
									}

									$app_template = getemailandpushnotification(11, 2, 2);
									if (!empty($app_template)) {
										$body = $app_template['body'];
										$title = $app_template['title'];
										$token = $child_profile[0]->ss_aw_device_token;

										pushnotification($title,$body,$token,16);

										$save_data = array(
											'user_id' => $value->child_id,
											'user_type' => 2,
											'title' => $title,
											'msg' => $body,
											'status' => 1,
											'read_unread' => 0,
											'action' => 16
										);

										save_notification($save_data);

									}

								}
							}	
						}
					}
				}

				die();
			}

			public function last_assesment_quiz_reminder(){
				$result = $this->ss_aw_child_last_lesson_model->getallcompletelessonresult();
				if (!empty($result)) {
					foreach($result as $key => $value){
						$current_date = date('Y-m-d');
						$current_date = strtotime($current_date);
						$lesson_complete_date = date('Y-m-d', strtotime($value->ss_aw_last_lesson_modified_date));
						$lesson_complete_date = strtotime($lesson_complete_date);
						$diff = $current_date - $lesson_complete_date;
						$diffDay = round($diff / (60 * 60 * 24));

						if($diffDay > 6){
							$check_assessment_completion = $this->notification_model->check_assessment_completion($value->ss_aw_last_lesson_modified_date, $value->ss_aw_child_id);
							if (count($check_assessment_completion) == 0) {
								$response = $this->ss_aw_assesment_reminder_model->check_final_reminder($value->ss_aw_child_id, $value->ss_aw_lesson_id);

								if ($response == 0) {
									$data = array(
										'child_id' => $value->ss_aw_child_id,
										'lesson_id' => $value->ss_aw_lesson_id,
										'type' => 3,
										'notify_time' => date('Y-m-d H:i:s')
									);

									$check_insertion = $this->ss_aw_assesment_reminder_model->save_notification($data);
									if ($check_insertion) {
										//get lesson related assessment record
										$assessment_details = $this->ss_aw_assesment_uploaded_model->get_assessment_by_lesson_id($value->ss_aw_lesson_id);
										$assessment_id = $assessment_details[0]->ss_aw_assessment_id;
										//set topic serial number
										$searchary = array();
										$searchary['ss_aw_child_id'] = $value->ss_aw_child_id;
										$searchary['ss_aw_course_currrent_status'] = 1;
										$courseary = $this->ss_aw_purchase_courses_model->get_purchase_course_details($searchary);
										$course_code = $courseary[0]['ss_aw_course_code'];


										$topic_listary = array();
										$general_language_assessments = array();
										if ($course_code == 'E' || $course_code == 'C') {
											$search_data = array();
											$search_data['ss_aw_expertise_level'] = 'E';
											$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
											$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();	
										}
										elseif($course_code == 'A'){
											$search_data = array();
											$search_data['ss_aw_expertise_level'] = 'C';
											$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
											$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_champions_general_language_assessments();
										}
										else{
											$search_data = array();
											$search_data['ss_aw_expertise_level'] = 'A,M';
											$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
										}
										$topicAry = array();
										if (!empty($topic_listary)) {
											foreach ($topic_listary as $key => $val){
												$topicAry[] = $val->ss_aw_section_id;
											}
										}
										$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);

										$result = array_merge($topical_assessments, $general_language_assessments);


										$serial_ary = array();
										if (!empty($assessment_list)) {
											if ($level == 'A') {
												$assessment_count = 11;
											}
											else{
												$assessment_count = 1;	
											}
											
											foreach ($assessment_list as $key => $value) {
												if (strtolower($value['ss_aw_assesment_format']) == 'single') {
													$serial_ary[$value['ss_aw_assessment_id']] = $assessment_count;
													$assessment_count++;	
												}
												else{
													$assessment_name_ary = explode(" ", $value['ss_aw_assesment_topic']);
													$serial_ary[$value['ss_aw_assessment_id']] = $assessment_name_ary[count($assessment_name_ary) - 1];
												}
											}
										}

										$serial_no = 0;
										if (!empty($serial_ary)) {
											$serial_no = $serial_ary[$assessment_id];
										}
										//end
										$assessment_name = $assessment_details[0]->ss_aw_assesment_topic;
										//end
										$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);

										//for child
										if ($child_profile[0]->ss_aw_child_gender == 1) {
											$gender = "he";
											$gender_pronoun = "his";
										}
										else{
											$gender = "she";
											$gender_pronoun = "her";
										}
										$email_template = getemailandpushnotification(12, 1, 2);
										if (!empty($email_template)) {
											$body = $email_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
											$body = str_ireplace("[@@gender@@]", $gender, $body);
												$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
											$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
											emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
										}

										$app_template = getemailandpushnotification(12, 2, 2);
										if (!empty($app_template)) {
											$body = $app_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
											$body = str_ireplace("[@@gender@@]", $gender, $body);
												$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
											$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);	
											$title = $app_template['title'];
											$token = $child_profile[0]->ss_aw_device_token;

											pushnotification($title,$body,$token,17);

											$save_data = array(
												'user_id' => $value->ss_aw_child_id,
												'user_type' => 2,
												'title' => $title,
												'msg' => $body,
												'status' => 1,
												'read_unread' => 0,
												'action' => 17
											);

											save_notification($save_data);

										}

										//end
										$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($value->ss_aw_child_id);
										if (!empty($parent_detail) && !empty($child_profile[0]->ss_aw_child_username)) {

											//for parent
											$email_template = getemailandpushnotification(12, 1, 1);
											if (!empty($email_template)) {
												$body = $email_template['body'];
												$body = str_ireplace("[@@user_type@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "Admin" : "Parent");
												$body = str_ireplace("[@@child_nominee@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "nominee" : "child");
												$body = str_ireplace("[@@child_name@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
												$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
												$body = str_ireplace("[@@gender@@]", $gender, $body);
												$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
												$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
												emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
											}

											$app_template = getemailandpushnotification(12, 2, 1);
											if (!empty($app_template)) {
												$body = $app_template['body'];
												$body = str_ireplace("[@@user_type@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "Admin" : "Parent");
												$body = str_ireplace("[@@child_nominee@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "nominee" : "child");
												$body = str_ireplace("[@@child_name@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
												$body = str_ireplace("[@@assessment_name@@]", $assessment_name, $body);
												$body = str_ireplace("[@@gender@@]", $gender, $body);
												$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
												$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
												$title = $app_template['title'];
												$token = $parent_detail[0]->ss_aw_device_token;

												pushnotification($title,$body,$token,18);

												$save_data = array(
													'user_id' => $parent_detail[0]->ss_aw_parent_id,
													'user_type' => 1,
													'title' => $title,
													'msg' => $body,
													'status' => 1,
													'read_unread' => 0,
													'action' => 18
												);

												save_notification($save_data);

											}

											//end
										}
									}
								}
							}
						}
					}
				}

				die();
			}

			public function first_readalong_reminder(){
				$search_date = date('Y-m-d', strtotime("-2 days"));
				$result = $this->ss_aw_child_last_lesson_model->getallcompletelessonresult($search_date);
				if (!empty($result)) {
					foreach($result as $key => $value){
						$check_schedule = $this->get_readalong_restriction_time($value->ss_aw_child_id);
						if ($check_schedule) 
						{
							/*$current_date = time();
							$lesson_complete_date = strtotime($value->ss_aw_last_lesson_modified_date);
							$diff = $current_date - $lesson_complete_date;
							$diffDay = round($diff / (60 * 60 * 24));*/
							//if($diffDay >= 2)
							{
								$response = $this->ss_aw_readalong_reminder_model->check_first_reminder($value->ss_aw_child_id, $value->ss_aw_lesson_id);
								if (empty($response)) {
									$data = array(
										'child_id' => $value->ss_aw_child_id,
										'lesson_id' => $value->ss_aw_lesson_id,
										'type' => 1,
										'lesson_type' => $value->ss_aw_lesson_level,
										'notify_time' => date('Y-m-d H:i:s')
									);

									$check_insertion = $this->ss_aw_readalong_reminder_model->save_notification($data);
									
									if ($check_insertion) {
										$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);

										//for child
										$lesson_details = $this->ss_aw_lessons_uploaded_model->getlessonbyid($value->ss_aw_lesson_id);
										$lesson_name = $lesson_details[0]->ss_aw_lesson_topic;
										$email_template = getemailandpushnotification(14, 1, 2);
										if (!empty($email_template)) {
											$body = $email_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
											$body = str_ireplace("[@@reminder_number@@]", 'a reminder', $body);
											$body = str_ireplace("[@@lesson_completion_days_num@@]", 'two', $body);
											emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
										}

										$app_template = getemailandpushnotification(14, 2, 2);
										if (!empty($app_template)) {
											$body = $app_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
											$title = $app_template['title'];
											$token = $child_profile[0]->ss_aw_device_token;

											pushnotification($title,$body,$token,21);

											$save_data = array(
												'user_id' => $value->ss_aw_child_id,
												'user_type' => 2,
												'title' => $title,
												'msg' => $body,
												'status' => 1,
												'read_unread' => 0,
												'action' => 21
											);

											save_notification($save_data);

										}
										//end

									}
								}
							}	
						}
					}
				}

				die();
			}

			public function regularreadalongreminder(){
				$searchval = date('Y-m-d 00:00:00',strtotime("-3 days"));
				$result = $this->ss_aw_readalong_reminder_model->getallfirstreminder($searchval);
				if(!empty($result)){
					foreach($result as $value){
						$check_schedule = $this->get_readalong_restriction_time($value->child_id);
						if ($check_schedule) {
							$response = $this->ss_aw_readalong_reminder_model->check_last_reminder($value->child_id, $value->lesson_id);
							if ($response) {
								$data = array(
									'child_id' => $value->child_id,
									'lesson_id' => $value->lesson_id,
									'type' => 2,
									'notify_time' => date('Y-m-d H:i:s')
								);

								$check_insertion = $this->ss_aw_readalong_reminder_model->save_notification($data);
								if ($check_insertion) {
									$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->child_id);

									//for child

									$email_template = getemailandpushnotification(14, 1, 2);
									if (!empty($email_template)) {
										$body = $email_template['body'];
										$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
										emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
									}

									$app_template = getemailandpushnotification(14, 2, 2);
									if (!empty($app_template)) {
										$body = $app_template['body'];
										$title = $app_template['title'];
										$token = $child_profile[0]->ss_aw_device_token;

										pushnotification($title,$body,$token,5);

										$save_data = array(
											'user_id' => $value->child_id,
											'user_type' => 2,
											'title' => $title,
											'msg' => $body,
											'status' => 1,
											'read_unread' => 0,
											'action' => 5
										);

										save_notification($save_data);

									}

									//end

								}
							}	
						}
					}
				}

				die();
			}

			public function regularreadalongreminderforemerging(){
				$searchval = date('Y-m-d 00:00:00',strtotime("-4 days"));
				$result = $this->ss_aw_readalong_reminder_model->getallfirstemergingreminder($searchval);
				if(!empty($result)){
					foreach($result as $value){
						$check_schedule = $this->get_readalong_restriction_time($value->child_id);
						if ($check_schedule) {
							$response = $this->ss_aw_readalong_reminder_model->check_emerging_reminder($value->child_id, $value->lesson_id);
							if ($response) {
								
								$current_date = time();
								$last_notify_time = strtotime($value->notify_time);
								$diff = $current_date - $last_notify_time;
								$diffDay = round($diff / (60 * 60 * 24));

								if ($diffDay > 2) {
									$data = array(
										'child_id' => $value->child_id,
										'lesson_id' => $value->lesson_id,
										'type' => 4,
										'notify_time' => date('Y-m-d H:i:s')
									);

									$check_insertion = $this->ss_aw_readalong_reminder_model->save_notification($data);
									if ($check_insertion) {
										$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->child_id);

										//for child

										$email_template = getemailandpushnotification(14, 1, 2);
										if (!empty($email_template)) {
											$body = $email_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
										}

										$app_template = getemailandpushnotification(14, 2, 2);
										if (!empty($app_template)) {
											$body = $app_template['body'];
											$title = $app_template['title'];
											$token = $child_profile[0]->ss_aw_device_token;

											pushnotification($title,$body,$token,5);

											$save_data = array(
												'user_id' => $value->child_id,
												'user_type' => 2,
												'title' => $title,
												'msg' => $body,
												'status' => 1,
												'read_unread' => 0,
												'action' => 5
											);

											save_notification($save_data);

										}

										//end

									}	
								}
							}	
						}
					}
				}

				die();
			}

			public function finalreadalongreminder(){
				$search_date = date('Y-m-d', strtotime("-6 days"));
				$result = $this->ss_aw_child_last_lesson_model->getallcompletelessonresult($search_date);
				if (!empty($result)) {
					foreach($result as $value){
						{
								$check_readalong_status = $this->ss_aw_last_readalong_model->checkreadalong($value->ss_aw_last_lesson_modified_date, $value->ss_aw_child_id);
								
								if ($check_readalong_status) {
									$check = $this->ss_aw_readalong_reminder_model->check_final_reminder($value->ss_aw_child_id, $value->ss_aw_lesson_id);
									if($check == 0){
										$data = array(
											'child_id' => $value->ss_aw_child_id,
											'lesson_id' => $value->ss_aw_lesson_id,
											'type' => 3,
											'notify_time' => date('Y-m-d H:i:s')
										);

										$check_insertion = $this->ss_aw_assesment_reminder_model->save_notification($data);
										if ($check_insertion) {
											$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);

											//for child

												$email_template = getemailandpushnotification(15, 1, 2);
												if (!empty($email_template)) {
													$body = $email_template['body'];
													$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
													$body = str_ireplace("[@@gender_pronoun@@]", $child_profile[0]->ss_aw_child_gender == 1 ? 'his' : 'her', $body);
													emailnotification($child_profile[0]->ss_aw_child_email, $email_template['title'], $body);
												}

												$app_template = getemailandpushnotification(15, 2, 2);
												if (!empty($app_template)) {
													$body = $app_template['body'];
													$title = $app_template['title'];
													$token = $child_profile[0]->ss_aw_device_token;

													pushnotification($title,$body,$token,5);

													$save_data = array(
														'user_id' => $value->ss_aw_child_id,
														'user_type' => 2,
														'title' => $title,
														'msg' => $body,
														'status' => 1,
														'read_unread' => 0,
														'action' => 5
													);

													save_notification($save_data);

												}

											//end

											$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($value->ss_aw_child_id);
											if (!empty($parent_detail) && !empty($child_profile[0]->ss_aw_child_username)) {
												//for child

												$email_template = getemailandpushnotification(15, 1, 1);
												if (!empty($email_template)) {
													$body = $email_template['body'];
													$body = str_ireplace("[@@user_type@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "Admin" : "Parent");
													$body = str_ireplace("[@@child_nominee@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "nominee" : "child");
													$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
													$body = str_ireplace("[@@gender_pronoun@@]", $child_profile[0]->ss_aw_child_gender == 1 ? 'his' : 'her', $body);
													emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
												}

												$app_template = getemailandpushnotification(15, 2, 1);
												if (!empty($app_template)) {
													$body = $app_template['body'];
													$body = str_ireplace("[@@user_type@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "Admin" : "Parent");
													$body = str_ireplace("[@@child_nominee@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "nominee" : "child");
													$title = $app_template['title'];
													$token = $parent_detail[0]->ss_aw_device_token;

													pushnotification($title,$body,$token,58);

													$save_data = array(
														'user_id' => $parent_detail[0]->ss_aw_parent_id,
														'user_type' => 1,
														'title' => $title,
														'msg' => $body,
														'status' => 1,
														'read_unread' => 0,
														'action' => 58
													);

													save_notification($save_data);

												}

												//end
											}
										} 
									}
								}
							}
					}
				}

				die();
			}

			// public function final_promotion_reminder(){
			// 	$result = $this->ss_aw_child_last_lesson_model->get_all_child();
			// 	if (!empty($result)) {
			// 		foreach($result as $value){
			// 			$complete_lesson_detail = $this->ss_aw_child_last_lesson_model->getsixthcompletelesson($value->ss_aw_child_id);
			// 			if (!empty($complete_lesson_detail)) {
			// 				$current_date = time();
			// 				$lesson_complete_date = strtotime($value->ss_aw_last_lesson_modified_date);
			// 				$diff = $current_date - $lesson_complete_date;
			// 				$diffDay = round($diff / (60 * 60 * 24));
			// 				if ($diffDay == 6) {
			// 					$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($value->ss_aw_child_id);
			// 					if (!empty($parent_detail)) {

			// 						//for parent

			// 						$email_template = getemailandpushnotification(19, 1, 1);
			// 						if (!empty($email_template)) {
			// 							$body = $email_template['body'];
			// 							$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
			// 							emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
			// 						}

			// 						$app_template = getemailandpushnotification(19, 2, 1);
			// 						if (!empty($app_template)) {
			// 							$body = $app_template['body'];
			// 							$title = $app_template['title'];
			// 							$token = $parent_detail[0]->ss_aw_device_token;

			// 							pushnotification($title,$body,$token,9);

			// 							$save_data = array(
			// 								'user_id' => $parent_detail[0]->ss_aw_parent_id,
			// 								'user_type' => 1,
			// 								'title' => $title,
			// 								'msg' => $body,
			// 								'status' => 1,
			// 								'read_unread' => 0,
			// 								'action' => 9
			// 							);

			// 							save_notification($save_data);

			// 						}

			// 						//end
			// 					}
			// 				}
			// 			}
			// 		}
			// 	}
			// }

			public function invitation_to_begun_program_after_one_hour_welcome(){
				$result = $this->ss_aw_child_course_model->getchildstobeginprogram();
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						$purchase_date = date('Y-m-d H:i', strtotime($value->course_purchase_date));
						$purchase_date_time = strtotime($purchase_date);
						$current_time = date('Y-m-d H:i');
						$current_date_time = strtotime($current_time);
						$hourdiff = ($current_date_time - $purchase_date_time)/3600;
						if ($hourdiff == 1) {
							if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
								$course_name = Winners;
							}
							elseif($value->ss_aw_course_id == 3){
								$course_name = Champions;
							}
							else{
								$course_name = Master."s";
							}

							$email_template = getemailandpushnotification(8, 1, 2);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
								emailnotification($value->ss_aw_child_email, $email_template['title'], $body);
							}

							$app_template = getemailandpushnotification(8, 2, 2);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
								$title = $app_template['title'];
								$token = $value->ss_aw_device_token;

								pushnotification($title,$body,$token,12);

								$save_data = array(
									'user_id' => $value->ss_aw_child_id,
									'user_type' => 2,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => 12
								);

								save_notification($save_data);
							}	
						}
					}
				}
			}

			public function invitation_to_begun_program(){
				$searchval = date('Y-m-d',strtotime("-3 days"));	
				$result = $this->ss_aw_child_course_model->getchildstobeginprogram($searchval);
				
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
							$course_name = Winners;
						}
						elseif($value->ss_aw_course_id == 3){
							$course_name = Champions;
						}
						else{
							$course_name = Master."s";
						}

						$email_template = getemailandpushnotification(8, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
							emailnotification($value->ss_aw_child_email, $email_template['title'], $body);
						}

						$app_template = getemailandpushnotification(8, 2, 2);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
							$title = $app_template['title'];
							$token = $value->ss_aw_device_token;

							pushnotification($title,$body,$token,12);

							$save_data = array(
								'user_id' => $value->ss_aw_child_id,
								'user_type' => 2,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => 12
							);

							save_notification($save_data);
						}
					}
				}
			}

			public function non_perticipation_reminder(){
				$result = $this->ss_aw_child_course_model->getchildstobeginprogram();
				if (!empty($result)) {
					foreach($result as $value){
						//get first lesson details
						$course_id = $value->ss_aw_course_id;
						$lesson_list = $this->ss_aw_lessons_uploaded_model->get_lessonlist_bylevel($course_id);
						$lesson_name = $lesson_list[0]['ss_aw_lesson_topic'];
						//end
						$current_time = time();	
						$create_date = strtotime($value->course_purchase_date);
						$diff = $current_time - $create_date;
						$diffDay = round($diff / (60 * 60 * 24));
						if ($diffDay > 3 && $diffDay < 5) {
							$gender_pronoun = "";
							if ($value->ss_aw_child_gender == 1) {
								$gender_pronoun = "his";
							}
							else{
								$gender_pronoun = "her";
							}
							$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($value->ss_aw_child_id);
							if (!empty($parent_detail)) {
								//for child
								$email_template = getemailandpushnotification(9, 1, 1);

								if (!empty($email_template)) {
									$body = $email_template['body'];
									$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
									$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
									$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
									emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
								}

								$app_template = getemailandpushnotification(9, 2, 1);

								if (!empty($app_template)) {
									$body = $app_template['body'];
									$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
									$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
									$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
									$title = $app_template['title'];
									$token = $parent_detail[0]->ss_aw_device_token;

									pushnotification($title,$body,$token,13);

									$save_data = array(
										'user_id' => $parent_detail[0]->ss_aw_parent_id,
										'user_type' => 1,
										'title' => $title,
										'msg' => $body,
										'status' => 1,
										'read_unread' => 0,
										'action' => 13
									);

									save_notification($save_data);

								}

								//end
							}	
						}
					}
				}

				die();
			}

			public function test_notification()
			{
				$child_code = $this->uri->segment(3);
				$childdetails = array();
				$childdetails = $this->ss_aw_childs_model->check_child_existance($child_code);
				$response = sendpushnotification(1,'Test push notification',$childdetails[0]->ss_aw_child_email,$childdetails[0]->ss_aw_child_mobile,
				$childdetails[0]->ss_aw_child_nick_name,$childdetails[0]->ss_aw_device_token);	
				$msgary = array();
				
				echo $response;
				die();	
			}

			public function test_push_notification(){
				$child_id = $this->uri->segment(3);
				$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
				$lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid(2);
				$lesson_name = $lesson_detail[0]->ss_aw_lesson_topic;
				$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);
				if (!empty($parent_detail)) {
					$app_template = getemailandpushnotification(10, 2, 1);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
						$body = str_ireplace("[@@child_name@@]", $child_name, $body);
						$title = $app_template['title'];
						$token = $parent_detail[0]->ss_aw_device_token;

						$response = pushnotification($title,$body,$token,54);

						$data[] = array(
							'firebase_response' => $response,
							'device_token' => $token
						);
					}
				}

				if (!empty($child_profile)) {
					$app_template = getemailandpushnotification(10, 2, 2);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
						$body = str_ireplace("[@@username@@]", $child_name, $body);

						$title = $app_template['title'];
						$token = $child_profile[0]->ss_aw_device_token;

						$response = pushnotification($title,$body,$token,2);

						$data[] = array(
							'firebase_response' => $response,
							'device_token' => $token
						);
					}
				}

				if (!empty($data)) {
					die(json_encode($data));
				}
			}

			public function test_parent_notification2(){

			}

			public function test_parent_notification()
			{	
				$parent_id = $this->input->post('parent_id');
				$parent_token = $this->input->post('parent_token');
				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);

				if (!empty($parent_detail)) {
					testpushnotification('demo title','demo body', $parent_detail[0]->ss_aw_device_token, 2);
					//sendpushnotification(4,'Diagnostic Quiz Result',$parent_detail[0]->ss_aw_parent_email,$parent_detail[0]->ss_aw_parent_primary_mobile,$parent_detail[0]->ss_aw_parent_full_name,$parent_detail[0]->ss_aw_device_token);	
				}
				
				echo $response;
				die();	
			}

			public function test_complete_notification(){
				$child_id = $this->uri->segment(3);
				$child_token = $this->uri->segment(4);
				$lesson_id = $this->uri->segment(5);
				$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);

				$child_profile = $this->ss_aw_childs_model->get_child_profile_details($child_id, $child_token);
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

						echo pushnotification($title,$body,$token,2);
						die();
						$save_data = array(
							'user_id' => $child_profile[0]->ss_aw_child_id,
							'user_type' => 2,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 2
						);

						//save_notification($save_data);

					}
				}
			}
			
			public function cron_delete_old_audiofiles()
			{
				/**************** LESSON SECTION **************************/
				$existing_lesson_audio_ary = array();
				$existing_lesson_audio_ary = directory_map('./assets/audio/lessons/');// Lesson Audio Array
				
				$result_array = array();
				$result_array = $this->ss_aw_lessons_model->get_deleted_records();
				
				$existinggroup_array = array();
				$existinggroup_array = $this->ss_aw_lessons_uploaded_model->fetch_all();
				
				$existinggroupary = array();
				foreach($existinggroup_array as $val)
				{
					$existinggroupary[] = $val['ss_aw_lession_id'];
				}
				$lessonaudio_list = array();
				if(!empty($result_array))
				{
					foreach($result_array as $value)
					{
						if(!in_array($value['ss_aw_lesson_record_id'],$existinggroupary))
						{
							@unlink($value['ss_aw_lesson_audio']);
							@unlink($value['ss_aw_lesson_details_audio']);
							@unlink($value['ss_aw_lesson_answers_audio']);
						}
						$lessonaudio_list[] = $value['ss_aw_lesson_audio'];
						$lessonaudio_list[] = $value['ss_aw_lesson_details_audio'];	
						$lessonaudio_list[] = $value['ss_aw_lesson_answers_audio'];	
					}
				}
				
				foreach($existing_lesson_audio_ary as $value)
				{
					if(!in_array('assets/audio/lessons/'.$value,$lessonaudio_list))
					{
						//unlink('assets/audio/lessons/'.$value);
					}
				}
				
				/**************** Assessment SECTION **************************/
				$existing_assessment_answers_audio_ary = array();
				$existing_assessment_answers_audio_ary = directory_map('./assets/audio/assessment_answers/');// Assessment answers Audio Array
				
				$existing_assessment_question_preface_audio_ary = array();
				$existing_assessment_question_preface_audio_ary = directory_map('./assets/audio/question_preface/');// Assessment question preface Audio Array
				
				$existing_assessment_rules_audio_ary = array();
				$existing_assessment_rules_audio_ary = directory_map('./assets/audio/rules/');// Assessment question preface Audio Array
				
				$result_array = array();
				$result_array = $this->ss_aw_assisment_diagnostic_model->get_deleted_records();
				
				$existinggroup_array = array();
				$existinggroup_array = $this->ss_aw_assesment_uploaded_model->fetch_all();
				
				$existinggroupary = array();
				foreach($existinggroup_array as $val)
				{
					$existinggroupary[] = $val['ss_aw_assessment_id'];
				}
				
				$assessment_answers_audio_list = array();
				$assessment_question_preface_list = array();
				$assessment_rules_list = array();
				
				if(!empty($result_array))
				{
					foreach($result_array as $value)
					{
						if(!in_array($value['ss_aw_uploaded_record_id'],$existinggroupary))
						{
							@unlink($value['ss_aw_question_preface_audio']);
							@unlink($value['ss_aw_answers_audio']);
							@unlink($value['ss_aw_rules_audio']);
						}
						$assessment_answers_audio_list[] = $value['ss_aw_answers_audio'];
						$assessment_question_preface_list[] = $value['ss_aw_question_preface_audio'];
						$assessment_rules_list[] = $value['ss_aw_rules_audio'];
					}
				}
				
				foreach($existing_assessment_answers_audio_ary as $value)
				{
					if(!in_array('assets/audio/assessment_answers/'.$value,$assessment_answers_audio_list))
					{
						//@unlink('assets/audio/assessment_answers/'.$value);
					}
				}
				
				foreach($existing_assessment_question_preface_audio_ary as $value)
				{
					if(!in_array('assets/audio/question_preface/'.$value,$assessment_question_preface_list))
					{
						//@unlink('assets/audio/question_preface/'.$value);
					}
				}
				
				foreach($existing_assessment_rules_audio_ary as $value)
				{
					if(!in_array('assets/audio/rules/'.$value,$assessment_rules_list))
					{
						//@unlink('assets/audio/rules/'.$value);
					}
				}
				
				
				/**************** READALONGS SECTION **************************/
				$result_array = array();
				$result_array = $this->ss_aw_readalong_model->get_deleted_records();
				
				$existinggroup_array = array();
				$existinggroup_array = $this->ss_aw_readalongs_upload_model->fetch_all();
				
				$existinggroupary = array();
				foreach($existinggroup_array as $val)
				{
					$existinggroupary[] = $val['ss_aw_id'];
				}
				
				if(!empty($result_array))
				{
					foreach($result_array as $value)
					{
						if(!in_array($value['ss_aw_readalong_upload_id'],$existinggroupary))
						{
							if(!empty($value['ss_aw_readalong_audio']))
								@unlink($value['ss_aw_readalong_audio']);
						}
					}
				}
			
				/**************** Supplymentary SECTION **************************/
				$result_array = array();
				$result_array = $this->ss_aw_supplymentary_model->get_deleted_records();
				
				$existinggroup_array = array();
				$existinggroup_array = $this->ss_aw_supplymentary_uploaded_model->fetch_all();
				
				$existinggroupary = array();
				foreach($existinggroup_array as $val)
				{
					$existinggroupary[] = $val['ss_aw_id'];
				}
				if(!empty($result_array))
				{
					foreach($result_array as $value)
					{
						if(!in_array($value['ss_aw_record_id'],$existinggroupary))
						{
							@unlink($value['ss_aw_question_preface_audio']);
							@unlink($value['ss_aw_answers_audio']);
							@unlink($value['ss_aw_rules_audio']);
						}
					}
				}
			}

			public function get_readalong_restriction_time($child_id){
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = $childary[count($childary) - 1]['ss_aw_course_id'];

				//get restricted time
				$restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($level);
				$restriction_time = $restriction_detail[0]->restricted_time;

				//get lesson count
				$total_lesson = $this->ss_aw_child_last_lesson_model->getcompletelessoncount($child_id, $level);

				/*if ($level == 1) 
				{
					if (($total_lesson % 2) == 1) {
						$fetch_lesson_num = $total_lesson;
					}
					else
					{
						$fetch_lesson_num = $total_lesson - 1;
					}
				}
				else{
					$fetch_lesson_num = $total_lesson;
				}*/
				$fetch_lesson_num = $total_lesson;

				$get_lesson_completion_detail = $this->ss_aw_child_last_lesson_model->getcompletelessondetailbyindex($fetch_lesson_num, $child_id, $level);
				if ($start_date == "" || $end_date == "") {
					$responseary['readalong_scheduler'] = 0;
				}
				else
				{
					$check_last_assign_readalong = $this->ss_aw_schedule_readalong_model->getlastassignedrecord($child_id);
					if (!empty($check_last_assign_readalong)) {
						if (($check_last_assign_readalong[0]->ss_aw_schedule_readalong >=$start_date) && ($check_last_assign_readalong[0]->ss_aw_schedule_readalong <=$end_date)) {
							if ($check_last_assign_readalong[0]->ss_aw_read == 1) {
								$responseary['readalong_scheduler'] = 0;
							}
							else
							{
								$responseary['readalong_scheduler'] = 1;
							}
									
						}
						else
						{
							$responseary['readalong_scheduler'] = 1;
						}
					}
					else
					{
						$responseary['readalong_scheduler'] = 1;
					}
				}

				return $responseary['readalong_scheduler'];
			}

			public function monthly_performance_scorecard(){
				$childs = $this->ss_aw_child_course_model->getchildstogeneratescorecard();
				if (!empty($childs)) {
					foreach ($childs as $key => $child) {
						$level = $child->ss_aw_course_id;
						$child_id = $child->ss_aw_child_id;
						if ($level == 1) {
							$course_level = "E";
						}
						elseif ($level == 2) {
							$course_level = "C";
						}
						else
						{
							$course_level = "A";
						}
						//get completed lesson list
						$searchary = array();
						$searchary['ss_aw_child_id'] = $child_id;
						$searchary['ss_aw_lesson_level'] = $level;
						$searchary['ss_aw_lesson_status'] = 2;
						$completed_lessonid = array();

						$lessons_listary = $this->ss_aw_child_last_lesson_model->getallcompletelessonbychild($searchary);
						$lesson_assessment_data = array();
						if (!empty($lessons_listary)) {
							$responseary['result']['start_date'] = date('Y-m-d', strtotime($lessons_listary[0]['ss_aw_last_lesson_create_date']));
							foreach ($lessons_listary as $key => $value) {
								$lesson_assessment_data[$key]['id'] = $key + 1;
								$lesson_complete_question_detail = $this->ss_aw_lesson_score_model->check_data($child_id, $value['ss_aw_lesson_id']);
								if (!empty($lesson_complete_question_detail)) {
									$lesson_assessment_data[$key]['lesson_total_correct_ans'] = $lesson_complete_question_detail[0]->wright_answers;
									$lesson_assessment_data[$key]['lesson_total_question'] = $lesson_complete_question_detail[0]->total_question;
								}
								else
								{
									$lesson_assessment_data[$key]['lesson_total_correct_ans'] = 0;
									$lesson_assessment_data[$key]['lesson_total_question'] = 0;
								}

								$assessment_complete_question_detail = $this->ss_aw_assessment_score_model->gettotalquestionanswercount($child_id, $value['ss_aw_lesson_id']);
								if (!empty($assessment_complete_question_detail)) {
									$lesson_assessment_data[$key]['assessment_total_currect_ans'] = $assessment_complete_question_detail[0]->wright_answers;
									$lesson_assessment_data[$key]['assessment_total_question'] = $assessment_complete_question_detail[0]->total_question;
								}
								else
								{
									$lesson_assessment_data[$key]['assessment_total_currect_ans'] = 0;
									$lesson_assessment_data[$key]['assessment_total_question'] = 0;
								}

								$lesson_assessment_data[$key]['readalong_complete'] = $this->get_readalong_restriction_time($child_id, $level);
							}

							$data['result'] = $lesson_assessment_data;

							$score_card = "<table>";
							$score_card .= "<tr>";
							$score_card .= "<th>Sl No.</th>";
							$score_card .= "<th>Lessons</th>";
							$score_card .= "<th>Assessments</th>";
							$score_card .= "<th>ReadAlongs</th>";
							$score_card .= "</tr>";
							if (!empty($lesson_assessment_data)) {
								$count = 0;
								foreach ($lesson_assessment_data as $score) {
									$count++;
			                        $background_color = "#ffffff";
			                        if ($count % 2 == 0) {
			                            $background_color = "#f0f0f0";
			                        }
			                        $score_card .= "<tr style='background-color: $background_color'>";
			                        $score_card .= "<td>".$count."</td>";
			                        $score_card .= "<td>".$score['lesson_total_correct_ans']." of ".$score['lesson_total_question']."</td>";
			                        $score_card .= "<td>".$score['assessment_total_currect_ans']." of ".$score['assessment_total_question']."</td>";
			                        if ($score['readalong_complete'] == 1) {
			                        	$score_card .= "<td>Completed</td>";
			                        }
			                        else{
			                        	$score_card .= "<td>Not completed</td>";
			                        }
			                        $score_card .= "<tr/>";
								}
							}
							else{
								$score_card .= "<tr><td colspan='4'></td></tr>";
							}
							$score_card .= "</table>";

							//send notification code
							$gender = "";
							if ($child->ss_aw_child_gender == 1) {
								$gender = "he";
							}
							else{
								$gender = "she";
							}
							$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);
							if (!empty($parent_detail)) {
								$email_template = getemailandpushnotification(21, 1, $child->ss_aw_child_username ? 1 : 2);
								if (!empty($email_template)) {
									$body = $email_template['body'];
									$body = str_ireplace("[@@gender@@]", $gender, $body);
									$body = str_ireplace("[@@monthly_score_card@@]", $score_card, $body);
									$body = str_ireplace("[@@child_name@@]", $child_name, $body);
									$response = emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
									if ($response) {
										$insert_data = array(
											'ss_aw_child_id' => $child_id
										);
										$this->notification_model->add_monthly_score_card($insert_data);
									}
								}

								$app_template = getemailandpushnotification(21, 2,  $child->ss_aw_child_username ? 1 : 2);
								if (!empty($app_template)) {
									$body = $app_template['body'];
									$body = str_ireplace("[@@child_name@@]", $child_name, $body);
									$title = $app_template['title'];
									$token = $parent_detail[0]->ss_aw_device_token;
									
									pushnotification($title,$body,$token,44);

									$save_data = array(
										'user_id' => $parent_detail[0]->ss_aw_parent_id,
										'user_type' => 1,
										'title' => $title,
										'msg' => $body,
										'status' => 1,
										'read_unread' => 0,
										'action' => 44
									);
								}
							}
						}
					}
				}
			}

			public function send_awsum_performance_result(){
				$result = $this->ss_aw_child_result_model->get_resulted_child_details();
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						$value->ss_aw_child_email = "sayan.sen@schemaphic.com";
						$childary = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
						$level = $childary[count($childary) - 1]['ss_aw_course_id'];
						//for child
						if ($level == 1 || $level == 2) {
							$course_name = Winners;
						}
						elseif ($level == 3) {
							$course_name = Champions;
						}
						else{
							$course_name = Master."s";
						}
						$gender = "";
						if ($value->ss_aw_child_gender == 1) {
							$gender = "he";
							$gender_pronoun = "his";
						}
						else{
							$gender = "she";
							$gender_pronoun = "her";
						}

						$month_date = date('d/m/Y', strtotime($value->ss_aw_created_at));
						$email_template = getemailandpushnotification(22, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$attachment = base_url().$value->ss_aw_report_path;
							$body = str_ireplace("[@@report_path@@]", $attachment);
							emailnotification($value->ss_aw_child_email, $email_template['title'], $body);
						}

						$app_template = getemailandpushnotification(22, 2, 2);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$title = $app_template['title'];
							$token = $value->child_token;

							pushnotification($title,$body,$token,45);

							$save_data = array(
								'user_id' => $value->ss_aw_child_id,
								'user_type' => 2,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => 45
							);

							save_notification($save_data);

						}

						//end
						if ($level != 5) {
							$email_template = getemailandpushnotification(22, 1, 1);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@username@@]", $value->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender@@]", $gender, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
								emailnotification($value->ss_aw_parent_email, $email_template['title'], $body);
							}

							$app_template = getemailandpushnotification(22, 2, 1);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@username@@]", $value->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender@@]", $gender, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $gender_pronoun, $body);
								$title = $app_template['title'];
								$token = $value->parent_token;

								pushnotification($title,$body,$token,46);

									$save_data = array(
										'user_id' => $value->ss_aw_parent_id,
										'user_type' => 1,
										'title' => $title,
										'msg' => $body,
										'status' => 1,
										'read_unread' => 0,
										'action' => 46
									);

								save_notification($save_data);

							}
							//end
						}
						//update result send status to avoid multiple send
						$this->ss_aw_child_result_model->update_result_send_status($value->ss_aw_id);
					}
				}
			}

			public function supplymentary_quiz_offer(){
				$result = $this->ss_aw_child_course_model->get_complete_student_parent_details();
				$current_date = date('Y-m-d');
				$current_time = strtotime($current_date);	
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						$complete_date = date('Y-m-d', strtotime($value->ss_aw_child_course_modified_date));
						$complete_time = strtotime($complete_date);
						$time_diff = $current_time - $complete_time;
						$diff_day = $time_diff / (60 * 60 * 24);
						if ($diff_day == 2) {
							$gender = "";
							if ($value->ss_aw_child_gender == 1) {
								$gender = "he";
							}
							else{
								$gender = "she";
							}

							if ($value->ss_aw_course_id == 1) {
								$level = "E";
							}
							elseif ($value->ss_aw_course_id == 2) {
								$level = "C";
							}
							else{
								$level = "A";
							}

							$topic_list = $this->ss_aw_sections_topics_model->get_topiclist_bylevel($level);
							$topic_table = "<table style='border: 1px solid #dddddd;width: 80%;margin-left:auto;margin-right:auto;'>";
							$topic_table .= "<tr>";
							$topic_table .= "<th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Topic / Section Name (ID)</th>";
							$topic_table .= "</tr>";
							if (!empty($topic_list)) {
								$count = 0;
								foreach ($topic_list as $topic_content) {
									$count++;
			                        $background_color = "#ffffff";
			                        if ($count % 2 == 0) {
			                            $background_color = "#f0f0f0";
			                        }
			                        $topic_table .= "<tr style='background-color: $background_color'>";
			                        $topic_table .= "<td style='padding: 8px;'>".$topic_content['ss_aw_section_title']."</td>";
			                        $topic_table .= "<tr/>";
								}
							}
							else{
								$topic_table .= "<tr><td colspan='1'></td></tr>";
							}
							$topic_table .= "</table>";
							//end
							$email_template = getemailandpushnotification(38, 1, $value->ss_aw_child_username ? 1 : 2);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@gender@@]", $gender, $body);
								$body = str_ireplace("[@@topic_content@@]", $topic_table, $body);
								emailnotification($value->ss_aw_parent_email, $email_template['title'], $body);
							}

							$app_template = getemailandpushnotification(38, 2, $value->ss_aw_child_username ? 1 : 2);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@child_name@@]", $value->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@gender@@]", $gender, $body);
								$title = $app_template['title'];
								$token = $value->parent_token;

								pushnotification($title,$body,$token,47);

								$save_data = array(
									'user_id' => $value->ss_aw_parent_id,
									'user_type' => 1,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => 47
								);

								save_notification($save_data);
							}	
						}
					}
				}
			}

			public function child_registration_reminder(){
				$parentsary = array();
				$searchval = date('Y-m-d 00:00:00',strtotime("-20 days"));
				$parents = $this->notification_model->getparentsofzerochild($searchval);
				$email_template = getemailandpushnotification(52, 1, 1);
				if (!empty($parents)) {
					foreach ($parents as $key => $value) {
						$complete_date = date('Y-m-d', strtotime($value->ss_aw_parent_created_date));
						$complete_time = strtotime($complete_date);
						$time_diff = time() - $complete_time;
						$diff_day = $time_diff / (60 * 60 * 24);
						if ($diff_day % 2 == 0) {
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@username@@]", $value->ss_aw_parent_full_name, $body);
								emailnotification($value->ss_aw_parent_email, 'Reminder to complete enrolment', $body);
							}	
						}
					}
				}
			}

			// public function diagnostic_complete_reminder(){
			// 	$searchval = date('Y-m-d 00:00:00',strtotime("-7 days"));
			// 	$result = $this->ss_aw_childs_model->get_diagnostic_non_course_purchase_details($searchval);
				
			// 	if (!empty($result)) {
			// 		foreach ($result as $key => $value) {
			// 			//get diagnostic exam details
			// 			$searchary = array();
			// 			$searchary['ss_aw_diagonastic_child_id'] = $value->ss_aw_child_id;
			// 			$resultary = array();
			// 			$resultary = $this->ss_aw_diagonastic_exam_model->fetch_record_byparam($searchary);
			// 			if (!empty($resultary)) {
			// 				$exam_code = $resultary[0]['ss_aw_diagonastic_exam_code'];
			// 			$searchary = array();
			// 			$searchary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
			// 			$examresultary = array();
			// 			$examresultary = $this->ss_aw_diagonastic_exam_log_model->fetch_record_byparam($searchary);

			// 			$total_marks = $this->ss_aw_diagonastic_exam_log_model->asked_question_num_by_exam_code($exam_code);
			// 			$obtain_marks = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);

			// 			$resultcountary = array();
			// 			foreach($examresultary as $examresult)
			// 			{
			// 				if($examresult['ss_aw_diagonastic_log_answer_status'] != 3)
			// 				{
			// 					$resultcountary[$examresult['ss_aw_diagonastic_log_level']]['total_ask'][] = $examresult['ss_aw_diagonastic_log_question_id'];
			// 					if($examresult['ss_aw_diagonastic_log_answer_status'] == 1)
			// 						$resultcountary[$examresult['ss_aw_diagonastic_log_level']]['right_ans'][] = $examresult['ss_aw_diagonastic_log_question_id'];
			// 				}
			// 			}

			// 			$pct_level_e = "";
			// 			$pct_level_c = "";
			// 			$pct_level_a = "";
			// 			if(!empty($resultcountary['E']))
			// 				$pct_level_e  = round((count($resultcountary['E']['right_ans'])/count($resultcountary['E']['total_ask']))*100);
							
			// 			if(!empty($resultcountary['C']))
			// 				$pct_level_c  = round((count($resultcountary['C']['right_ans'])/count($resultcountary['C']['total_ask']))*100);
							
			// 			if(!empty($resultcountary['A']))
			// 				$pct_level_a  = round((count($resultcountary['A']['right_ans'])/count($resultcountary['A']['total_ask']))*100);
							
			// 			/*This Checking for the E level student whose age bellow 13 years */
			// 			if(!empty($resultcountary['E']))
			// 			{
			// 				if($pct_level_e > 80 && $pct_level_c > 70)
			// 				{
			// 					$recomended_level = 'C';
			// 				}
			// 				else
			// 				{
			// 					$recomended_level = 'E';
			// 				}
			// 			}
			// 			/*This Checking for the C level student whose age above 13 years */
			// 			if(!empty($resultcountary['C']))
			// 			{
			// 				if($pct_level_c > 80 && $pct_level_a > 70)
			// 				{
			// 					$recomended_level = 'A';
			// 				}
			// 				else if($pct_level_c < 50)
			// 				{
			// 					$recomended_level = 'E';
			// 				}
			// 				else
			// 				{
			// 					$recomended_level = 'C';
			// 				}
			// 			}

			// 			if ($recomended_level == 'E') {
			// 				$email_template = getemailandpushnotification(30, 1, 1);
			// 				$app_template = getemailandpushnotification(30, 2, 1);
			// 				$action_id = 5;
			// 			}
			// 			elseif ($recomended_level == 'C') {
			// 				$email_template = getemailandpushnotification(4, 1, 1);
			// 				$app_template = getemailandpushnotification(4, 2, 1);
			// 				$action_id = 6;
			// 			}
			// 			else{
			// 				$email_template = getemailandpushnotification(31, 1, 1);
			// 				$app_template = getemailandpushnotification(31, 2, 1);
			// 				$action_id = 7;
			// 			}

			// 			$month_date = date('d/m/Y', strtotime($value->exam_date));
			// 			$gender = "";
			// 			if ($value->ss_aw_child_gender == 1) {
			// 				$gender = "him";
			// 			}
			// 			else{
			// 				$gender = "her";
			// 			}
			// 			$child_name = $value->ss_aw_child_nick_name;
			// 			if (!empty($email_template)) {
			// 				$body = $email_template['body'];
			// 				$body = str_ireplace("[@@child_name@@]", $child_name, $body);
			// 				$body = str_ireplace("[@@month_date@@]", $month_date, $body);
			// 				$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
			// 				$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
			// 				$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
			// 				if ($recomended_level == 'E' && $child_age >= 13) {
			// 					$body = str_ireplace("[@@child_emerging_promotion@@]", "If your child performs well in the first 6 weeks of the program, we will seek your permission to promote them to the Consolidating Program.", $body);
			// 				}
			// 				else{
			// 					$body = str_ireplace("[@@child_emerging_promotion@@]", "", $body);
			// 				}

							

			// 				emailnotification($value->ss_aw_parent_email, $email_template['title'], $body);
			// 			}

			// 				if (!empty($app_template)) {
			// 					$body = $app_template['body'];
			// 					$body = str_ireplace("[@@month_date@@]", $month_date, $body);
			// 					$body = str_ireplace("[@@child_name@@]", $child_name, $body);
			// 					$body = str_ireplace("[@@gender_pronoun@@]", $gender, $body);
			// 					$body = str_ireplace("[@@total_marks@@]", $total_marks, $body);
			// 					$body = str_ireplace("[@@obtain_marks@@]", $obtain_marks, $body);
			// 					$title = $app_template['title'];
			// 					$token = $value->ss_aw_device_token;

			// 					$state_details = getchild_diagnosticexam_status($child_id);
												
			// 					$params = array(
			// 						'childId' => $child_id,
			// 						'childStateId' => $state_details['id'],
			// 						'childStateSubId' => $state_details['sub_id'],
			// 						'childNickName' => $child_name,
			// 					);

			// 					$extra_data = json_encode($params);

			// 					pushnotification($title,$body,$token,$action_id,$extra_data);

			// 					$save_data = array(
			// 						'user_id' => $parent_detail[0]->ss_aw_parent_id,
			// 						'user_type' => 1,
			// 						'title' => $title,
			// 						'msg' => $body,
			// 						'status' => 1,
			// 						'read_unread' => 0,
			// 						'action' => $action_id,
			// 						'params' => $extra_data
			// 					);

			// 					save_notification($save_data);
			// 				}
			// 			}
			// 		}
			// 	}
			// }

			public function first_lesson_reminder(){
				$result = $this->ss_aw_child_last_lesson_model->get_each_user_last_lesson();
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						if (!empty($value->ss_aw_last_lesson_modified_date)) {
							$topic_listary = array();
							$general_language_lessons = array();
							$level = $value->ss_aw_lesson_level;
							
							if ($level == 1 || $level == 2) {
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'E';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
								$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
							}
							elseif($level == 3){
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'A,M';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
								$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
							}
							else{
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'A,M';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
							}
							$topicAry = array();
							if (!empty($topic_listary)) {
								foreach ($topic_listary as $topic) {
									$topicAry[] = $topic->ss_aw_section_id;
								}
							}

							$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

							$lesson_listary = array_merge($topical_lessons, $general_language_lessons);
							//get serial no
							$serial_ary = array();
							if (!empty($lesson_listary)) {
								if ($level == 3) {
									$lesson_count = 16;
								}
								else{
									$lesson_count = 1;	
								}

								foreach ($lesson_listary as $key => $lesson) {
									if (strtolower($lesson['ss_aw_lesson_format']) == 'single') {
										$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_count;
										$lesson_count++;	
									}
									else{
										$lesson_name_ary = explode(" ", $lesson['ss_aw_lesson_topic']);
										$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_name_ary[count($lesson_name_ary) - 1];
									}
								}
							}
							//end
							$current_date = date('Y-m-d');
							$current_date = strtotime($current_date);
							$lesson_complete_date = date('Y-m-d', strtotime($value->ss_aw_last_lesson_modified_date));
							$lesson_complete_date = strtotime($lesson_complete_date);
							$diff = $current_date - $lesson_complete_date;
							$diffDay = round($diff / (60 * 60 * 24));
							if ($diffDay == 8) {
								if (!empty($serial_ary)) {
									$childary = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
									$level = $childary[count($childary) - 1]['ss_aw_course_id'];
									//for child
									if ($level == 1 || $level == 2) {
										$course_name = Winners;
									}
									else {
										$course_name = Champions;
									}

									$array_key = array_search($serial_ary[$value->ss_aw_lesson_id], $serial_ary);
									if (!empty($serial_ary[$array_key + 1])) {
										$upcoming_lesson_id = $lesson_listary[$array_key + 1]['ss_aw_lession_id'];
										$lesson_name = $lesson_listary[$array_key + 1]['ss_aw_lesson_topic'];
										$serial_no = $serial_ary[$upcoming_lesson_id];

										$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);
										$email_template = getemailandpushnotification(54, 1, 2);
										if (!empty($email_template)) {
											$body = $email_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
											$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
											$body = str_ireplace("[@@course_name@@]", $course_name, $body);
											emailnotification($child_profile[0]->ss_aw_child_email, 'Lesson Start Reminder', $body);
										}
									}
									
								}
							}
						}
					}
				}
			}

			public function second_lesson_reminder(){
				$result = $this->ss_aw_child_last_lesson_model->get_each_user_last_lesson();
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						if (!empty($value->ss_aw_last_lesson_modified_date)) {
							$topic_listary = array();
							$general_language_lessons = array();
							$level = $value->ss_aw_lesson_level;
							
							if ($level == 1 || $level == 2) {
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'E';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
								$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
							}
							elseif($level == 3){
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'A,M';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
								$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
							}
							else{
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'A,M';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
							}
							$topicAry = array();
							if (!empty($topic_listary)) {
								foreach ($topic_listary as $topic) {
									$topicAry[] = $topic->ss_aw_section_id;
								}
							}

							$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

							$lesson_listary = array_merge($topical_lessons, $general_language_lessons);
							//get serial no
							$serial_ary = array();
							if (!empty($lesson_listary)) {
								if ($level == 3) {
									$lesson_count = 16;
								}
								else{
									$lesson_count = 1;	
								}

								foreach ($lesson_listary as $key => $lesson) {
									if (strtolower($lesson['ss_aw_lesson_format']) == 'single') {
										$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_count;
										$lesson_count++;	
									}
									else{
										$lesson_name_ary = explode(" ", $lesson['ss_aw_lesson_topic']);
										$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_name_ary[count($lesson_name_ary) - 1];
									}
								}
							}
							//end
							$current_date = date('Y-m-d');
							$current_date = strtotime($current_date);
							$lesson_complete_date = date('Y-m-d', strtotime($value->ss_aw_last_lesson_modified_date));
							$lesson_complete_date = strtotime($lesson_complete_date);
							$diff = $current_date - $lesson_complete_date;
							$diffDay = round($diff / (60 * 60 * 24));
							if ($diffDay == 9 || $diffDay == 10) {
								if (!empty($serial_ary)) {
									if ($diffDay == 9) {
										$reminder = "a reminder";
									}
									else{
										$reminder = "your second reminder";
									}
									$childary = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
									$level = $childary[count($childary) - 1]['ss_aw_course_id'];
									//for child
									if ($level == 1 || $level == 2) {
										$course_name = Winners;
									}
									else{
										$course_name = Champions;
									}

									$array_key = array_search($serial_ary[$value->ss_aw_lesson_id], $serial_ary);
									if (!empty($serial_ary[$array_key + 1])) {
										$upcoming_lesson_id = $lesson_listary[$array_key + 1]['ss_aw_lession_id'];
										$lesson_name = $lesson_listary[$array_key + 1]['ss_aw_lesson_topic'];
										$serial_no = $serial_ary[$upcoming_lesson_id];

										$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);
										$email_template = getemailandpushnotification(55, 1, 2);
										if (!empty($email_template)) {
											$body = $email_template['body'];
											$body = str_ireplace("[@@username@@]", $child_profile[0]->ss_aw_child_nick_name, $body);
											$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
											$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
											$body = str_ireplace("[@@course_name@@]", $course_name, $body);
											$body = str_ireplace("[@@reminder@@]", $reminder, $body);
											emailnotification($child_profile[0]->ss_aw_child_email, 'Lesson Start Reminder', $body);
										}
									}
									
								}
							}
						}
					}
				}
			}

			public function last_lesson_reminder(){
				$result = $this->ss_aw_child_last_lesson_model->get_each_user_last_lesson();
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						if (!empty($value->ss_aw_last_lesson_modified_date)) {
							$topic_listary = array();
							$general_language_lessons = array();
							$level = $value->ss_aw_lesson_level;
							
							if ($level == 1 || $level == 2) {
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'E';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
								$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
							}
							elseif($level == 3){
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'A,M';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
								$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
							}
							else{
								$search_data = array();
								$search_data['ss_aw_expertise_level'] = 'A,M';
								$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
							}
							$topicAry = array();
							if (!empty($topic_listary)) {
								foreach ($topic_listary as $topic) {
									$topicAry[] = $topic->ss_aw_section_id;
								}
							}

							$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

							$lesson_listary = array_merge($topical_lessons, $general_language_lessons);

							//get serial no
							$serial_ary = array();
							if (!empty($lesson_listary)) {
								if ($level == 3) {
									$lesson_count = 16;
								}
								else{
									$lesson_count = 1;	
								}

								foreach ($lesson_listary as $key => $lesson) {
									if (strtolower($lesson['ss_aw_lesson_format']) == 'single') {
										$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_count;
										$lesson_count++;	
									}
									else{
										$lesson_name_ary = explode(" ", $lesson['ss_aw_lesson_topic']);
										$serial_ary[$lesson['ss_aw_lession_id']] = $lesson_name_ary[count($lesson_name_ary) - 1];
									}
								}
							}
							//end
							$current_date = date('Y-m-d');
							$current_date = strtotime($current_date);
							$lesson_complete_date = date('Y-m-d', strtotime($value->ss_aw_last_lesson_modified_date));
							$lesson_complete_date = strtotime($lesson_complete_date);
							$diff = $current_date - $lesson_complete_date;
							$diffDay = round($diff / (60 * 60 * 24));
							if ($diffDay == 11) {
								if (!empty($serial_ary)) {
									$childary = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
									$level = $childary[count($childary) - 1]['ss_aw_course_id'];
									//for child
									if ($level == 1 || $level == 2) {
										$course_name = Winners;
									}
									elseif ($level == 3){
										$course_name = Champions;
									}
									else{
										$course_name = Master."s";
									}									
									$array_key = array_search($serial_ary[$value->ss_aw_lesson_id], $serial_ary);
									if (!empty($serial_ary[$array_key + 1])) {
										$upcoming_lesson_id = $lesson_listary[$array_key + 1]['ss_aw_lession_id'];
										$lesson_name = $lesson_listary[$array_key + 1]['ss_aw_lesson_topic'];
										$serial_no = $serial_ary[$upcoming_lesson_id];

										$child_profile = $this->ss_aw_childs_model->get_child_detail_by_id($value->ss_aw_child_id);
										$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($child_profile[0]->ss_aw_parent_id);
										if ($parent_details[0]->ss_aw_institution > 0) {
											$parent_details = $this->ss_aw_parents_model->get_institutions_admin($parent_details[0]->ss_aw_institution);
										}
										$email_template = getemailandpushnotification(56, 1, 1);
										
										if (!empty($email_template)) {
											$body = $email_template['body'];
											$body = str_ireplace("[@@user_type@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "Admin" : "Parent");
											$body = str_ireplace("[@@child_nominee@@]", $child_profile[0]->ss_aw_is_institute > 0 ? "nominee" : "child");
											$body = str_ireplace("[@@username@@]", $parent_details[0]->ss_aw_parent_full_name, $body);
											$body = str_ireplace("[@@lesson_name@@]", $lesson_name, $body);
											$body = str_ireplace("[@@topic_serial_number@@]", $serial_no, $body);
											$body = str_ireplace("[@@course_name@@]", $course_name, $body);
											$email = $parent_details[0]->ss_aw_parent_email;
											emailnotification($email, 'Lesson Start Reminder', $body);
										}
									}
									
								}
							}
						}
					}
				}
			}

			public function users_emi_reminder(){
				$get_emi_paid_users = $this->ss_aw_childs_model->get_emi_paid_users();
				$dateDiff = array();
				if (!empty($get_emi_paid_users)) {
					foreach ($get_emi_paid_users as $key => $value) {
						$present_emi_day_num = $value->emi_paid_num * 31; //31 is the day interval between two emis

						//calculate next emi date
						$next_emi_date = date('Y-m-d', strtotime($value->ss_aw_child_course_create_date." +".$present_emi_day_num." days"));
						$next_emi_date_time = strtotime($next_emi_date);
						$current_date = date('Y-m-d');
						$current_date_time = strtotime($current_date);
						$datediff = $next_emi_date_time - $current_date_time;
						$mid_days = round($datediff / (60 * 60 * 24));
						if ($mid_days == 1 || $mid_days == 3) {
							if ($value->ss_aw_course_id == 5) {
								$email_template = getemailandpushnotification(67, 1, 1);	
							}
							else{
								$email_template = getemailandpushnotification(66, 1, 1);
							}

							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@user_name@@]", !empty($value->first_name) ? $value->first_name." ".$value->last_name : $value->nick_name, $body);
								$body = str_ireplace("[@@remaining_day_count@@]", $mid_days == 1 ? "tomorrow" : "3 days", $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $value->gender == 1 ? "his" : "her", $body);
								$body = str_ireplace("[@@gender@@]", $value->gender == 1 ? "he" : "she", $body);
								$send_data = array(
									'ss_aw_email' => $value->parent_email,
									'ss_aw_subject' => "EMI Reminder",
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);
							}
						}
					}
				}
			}

			public function institution_emi_reminder(){
				$get_emi_paid_users = $this->ss_aw_childs_model->get_emi_paid_institution_users();
				$dateDiff = array();
				if (!empty($get_emi_paid_users)) {
					foreach ($get_emi_paid_users as $key => $value) {
						$present_emi_day_num = $value->emi_paid_num * 31; //31 is the day interval between two emis
						//calculate next emi date
						$next_emi_date = date('Y-m-d', strtotime($value->ss_aw_child_course_create_date." +".$present_emi_day_num." days"));
						$next_emi_date_time = strtotime($next_emi_date);
						$current_date = date('Y-m-d');
						$current_date_time = strtotime($current_date);
						$datediff = $next_emi_date_time - $current_date_time;
						$mid_days = round($datediff / (60 * 60 * 24));
						
						if ($mid_days == 1 || $mid_days == 3) {
							if ($value->ss_aw_course_id == 5) {
								$email_template = getemailandpushnotification(67, 1, 1);	
							}
							else{
								$email_template = getemailandpushnotification(66, 1, 1);
							}

							if (!empty($email_template)) {
								$institution_admin_details = $this->ss_aw_parents_model->get_institutions_admin($value->institution_id);
								$body = $email_template['body'];
								$body = str_ireplace("[@@user_name@@]", !empty($value->first_name) ? $value->first_name." ".$value->last_name : $value->nick_name, $body);
								$body = str_ireplace("[@@remaining_day_count@@]", $mid_days == 1 ? "tomorrow" : "3 days", $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $value->gender == 1 ? "his" : "her", $body);
								$body = str_ireplace("[@@gender@@]", $value->gender == 1 ? "he" : "she", $body);
								$send_data = array(
									'ss_aw_email' => $institution_admin_details[0]->ss_aw_parent_email,
									'ss_aw_subject' => "EMI Reminder",
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);
							}
						}
					}
				}
			}
		}

		function convert_number($number) 
		{
		    if (($number < 0) || ($number > 999999999)) 
		        {
		            throw new Exception("Number is out of range");
		        }
		        $giga = floor($number / 1000000);
		        // Millions (giga)
		        $number -= $giga * 1000000;
		        $kilo = floor($number / 1000);
		        // Thousands (kilo)
		        $number -= $kilo * 1000;
		        $hecto = floor($number / 100);
		        // Hundreds (hecto)
		        $number -= $hecto * 100;
		        $deca = floor($number / 10);
		        // Tens (deca)
		        $n = $number % 10;
		        // Ones
		        $result = "";
		        if ($giga) 
		        {
		            $result .= convert_number($giga) .  "Million";
		        }
		        if ($kilo) 
		        {
		            $result .= (empty($result) ? "" : " ") .convert_number($kilo) . " Thousand";
		        }
		        if ($hecto) 
		        {
		            $result .= (empty($result) ? "" : " ") .convert_number($hecto) . " Hundred";
		        }
		        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
		        if ($deca || $n) {
		            if (!empty($result)) 
		            {
		                $result .= " and ";
		            }
		            if ($deca < 2) 
		            {
		                $result .= $ones[$deca * 10 + $n];
		            } else {
		                $result .= $tens[$deca];
		                if ($n) 
		                {
		                    $result .= "-" . $ones[$n];
		                }
		            }
		        }
		        if (empty($result)) 
		        {
		            $result = "zero";
		        }
		        return $result;
		    }
