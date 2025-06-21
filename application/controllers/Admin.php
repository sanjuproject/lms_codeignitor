<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('vendor/autoload.php');
class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$function_name = $this->uri->segment(2);
		if ($function_name != "managecoupons") {
			$this->session->unset_userdata('coupon_search_data');
		}
		if ($function_name != "managenewsletters") {
			$this->session->unset_userdata('newsletter_search_data');
		}
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
		$this->load->model('ss_aw_voice_type_matrix_model');
		$this->load->model('ss_aw_vocabulary_model');
		$this->load->model('ss_aw_notification_param_model');
		$this->load->model('ss_aw_score_numeric_values_model');
		$this->load->model('ss_aw_confidence_numeric_values_model');
		$this->load->model('ss_aw_external_contact_upload_model');
		$this->load->model('ss_aw_external_contact_model');
		$this->load->model('ss_aw_coupons_model');
		$this->load->model('ss_aw_manage_coupon_send_model');
		$this->load->model('ss_aw_newsletter_model');
		$this->load->model('ss_aw_create_promotion_model');
		$this->load->model('ss_aw_promotion_sending_frequency_model');
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_last_readalong_model');
		$this->load->model('ss_aw_purchase_courses_model');
		$this->load->model('ss_aw_child_course_model');
		$this->load->model('ss_aw_payment_details_model');
		$this->load->model('ss_aw_promotion_model');
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_childs_temp_model');
		$this->load->model('ss_aw_child_login_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_schedule_readalong_model');
		$this->load->model('ss_aw_lesson_quiz_ans_model');
		$this->load->model('ss_aw_assesment_multiple_question_answer_model');
		$this->load->model('ss_aw_assessment_exam_log_model');
		$this->load->model('ss_aw_readalongs_upload_model');
		$this->load->model('ss_aw_store_readalong_page_model');
		$this->load->model('ss_aw_readalong_quiz_ans_model');
		$this->load->model('ss_aw_reporting_collection_model');
		$this->load->model('ss_aw_reporting_revenue_model');
		$this->load->model('ss_aw_refferal_model');
		$this->load->model('ss_aw_challange_model');
		$this->load->model('ss_aw_challange_facebook_model');
		$this->load->model('ss_aw_challange_template_model');
		$this->load->model('ss_aw_challange_log_model');
		$this->load->model('ss_aw_puzzle_notify_model');
		$this->load->model('ss_aw_email_que_model');
		$this->load->model('ss_aw_countries_model');
		$this->load->model('ss_aw_states_model');
		$this->load->model('ss_aw_institution_users_model');
		$this->load->model('ss_aw_institutions_model');
		$this->load->model('ss_aw_unsubscribe_emails');
		$this->load->model('ss_aw_schools_model');
		$this->load->model('ss_aw_institution_menus');
		$this->load->model('ss_aw_institution_payment_details_model');
		$this->load->model('ss_aw_institution_student_upload_model');
		$this->load->model('ss_aw_readalong_restriction_model');
		$this->load->model('ss_aw_diagnostic_complete_log_model');
		$this->load->model('ss_aw_topics_complete_log_model');
		$this->load->model('ss_aw_lesson_assessment_total_score_model');
		$this->load->model('ss_aw_lesson_assessment_score_model');
		$this->load->model('ss_aw_current_lesson_model');
		$this->load->model('ss_aw_assesment_reminder_model');
		$this->load->model('module_wise_performance_model');
		$this->load->model('ss_aw_course_count_model');
	}

	public function index($cheat_code = "")
	{
		$data = array();
		$data['cheat_code'] = $cheat_code;
		if (!empty($this->session->userdata('id'))) {
			$parent_id = $this->session->userdata('id');
			$institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			if (!empty($institution_admin_details)) {
				$institution_id = $institution_admin_details[0]->ss_aw_institution;
				$institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
				if ($institution_details->ss_aw_status == 0) {
					$thzis->session->set_flashdata('error', 'First login to access any page.');
					$this->load->view('admin/index');
				} else {
					redirect('admin/dashboard');
				}
			} else {
				redirect('admin/dashboard');
			}
		} else {
			$this->load->view('admin/index', $data);
		}
	}

	public function forgotpassword()
	{
		if (!empty($this->session->userdata('id'))) {
			redirect('admin/dashboard');
		} else {
			$this->load->view('admin/forgotpassword');
		}
	}

	public function checklogin()
	{
		if (empty($this->session->userdata('id'))) {
			$this->session->set_flashdata('error', 'First login to access any page.');
			redirect('admin/index');
		} else {
			$parent_id = $this->session->userdata('id');
			$institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			if ($this->session->userdata('is_institute')) {
				if (!empty($institution_admin_details)) {
					$institution_id = $institution_admin_details[0]->ss_aw_institution;
					$institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
					if ($institution_details->ss_aw_status == 0) {
						$this->session->set_flashdata('error', 'First login to access any page.');
						redirect('admin/index');
					}
				}
			}

			$headerdata = array();
			$headerdata['profile_name'] = $this->session->userdata('fullname');
			$headerdata['profile_pic'] = $this->session->userdata('profile_pic');
			$headerdata['user_email'] = $this->session->userdata('user_email');

			$searchary = array();
			$searchary['ss_aw_status'] = 1;
			$adminmenuary = $this->ss_aw_adminmenus_model->search_byparam($searchary);


			$user_role_ids_ary = array();
			$user_role_ids_ary = explode(",", $this->session->userdata('role_ids'));

			foreach ($user_role_ids_ary as $val) {
				foreach ($adminmenuary as $val2) {
					if ($val == $val2['ss_aw_id']) {
						if ($val2['ss_aw_menu_category_id'] > 0) {
							$user_role_ids_ary[] = $val2['ss_aw_menu_category_id'];
						}
					}
				}
			}

			$user_role_ids_ary = array_values(array_unique($user_role_ids_ary));

			$admin_menu_ary = array();
			$j = 1;
			$i = 1;
			foreach ($adminmenuary as $val) {
				if (in_array($val['ss_aw_id'], $user_role_ids_ary)) {

					if (trim($val['ss_aw_menu_category_id']) == 0) {
						$admin_menu_ary[$val['ss_aw_id']][0]['menu_icon'] = $val['ss_aw_menu_icon'];
						$admin_menu_ary[$val['ss_aw_id']][0]['page'] = $val['ss_aw_menu_name'];
						$admin_menu_ary[$val['ss_aw_id']][0]['link'] = $val['ss_aw_adminusers_pagelink'];
					}
				}
			}
			foreach ($adminmenuary as $val) {
				if (in_array($val['ss_aw_id'], $user_role_ids_ary)) {
					foreach ($admin_menu_ary as $key => $val2) {
						if ($key == $val['ss_aw_menu_category_id']) {
							$admin_menu_ary[$key][$j]['page'] = $val['ss_aw_menu_name'];
							$admin_menu_ary[$key][$j]['link'] = $val['ss_aw_adminusers_pagelink'];
							$j++;
						}
					}
				}
			}
			$headerdata['menuary'] = $admin_menu_ary;
			return $headerdata;
		}
	}
	public function login()
	{
		$postdata = $this->input->post();
		$dataary = array();
		$dataary['ss_aw_admin_user_email'] = $postdata['email'];
		$searchdataary = array();
		$searchdataary = $this->ss_aw_admin_users_model->search_byparam($dataary);


		//temp ITC login
		$check_user_password = true;
		if (($postdata['email'] == 'priya.anu0402@gmail.com' && $postdata['password'] == 'priya@123') || ($postdata['email'] == 'konica.khuran@itchotels.in' && $postdata['password'] == 'konica@123') || ($postdata['email'] == 'anjana.rai@itchotels.in' && $postdata['password'] == 'anjana@123')) {
			$postdata['email'] = 'ashima.gulati@itchotels.in';
			$check_user_password = false;
		}
		//end

		//temp GD Goenka Group Login
		if (($postdata['email'] == 'neeta.prasad@gdgoenka.ac.in' && $postdata['password'] == 'neeta@123') || ($postdata['email'] == 'shruti.bhattacharya@gdgoenka.ac.in' && $postdata['password'] == 'shruti@123') || ($postdata['email'] == 'priya.hatwal@gdgoenka.ac.in' && $postdata['password'] == 'priya@123')) {
			$postdata['email'] = 'meenakshi.khetrapal@gdgoenka.ac.in';
			$check_user_password = false;
		}
		//end


		//search for institute admin
		$institution_credential = $this->ss_aw_parents_model->check_email_institution($postdata['email']);
		//end
		if (!empty($searchdataary)) {
			$password = $searchdataary[0]['ss_aw_admin_user_password'];

			//temp ITC users password checking

			if ($this->bcrypt->check_password($postdata['password'], $password)) {
				$this->session->set_userdata('access_id', $searchdataary[0]['access_id']);
				$this->session->set_userdata('id', $searchdataary[0]['ss_aw_admin_user_id']);
				$this->session->set_userdata('fullname', $searchdataary[0]['ss_aw_admin_user_full_name']);
				$this->session->set_userdata('profile_pic', $searchdataary[0]['ss_aw_admin_user_profile_pic']);
				$this->session->set_userdata('user_mobile_no', $searchdataary[0]['ss_aw_admin_user_mobile_no']);
				$this->session->set_userdata('user_email', $searchdataary[0]['ss_aw_admin_user_email']);
				$this->session->set_userdata('role_ids', $searchdataary[0]['ss_aw_admin_user_role_ids']);
				$this->session->set_userdata('is_institute', 0);
				if ($postdata['cheat_code'] != '') {
					redirect('master_lite/active_cheat_code/' . $postdata['cheat_code']);
				} else {
					redirect('admin/dashboard');
				}
			} else {
				$this->session->set_flashdata('error', 'Login fail.Invalid password.');
				redirect('admin/index');
			}
		} elseif (!empty($institution_credential)) {
			$password = $institution_credential->ss_aw_parent_password;
			//if ($this->bcrypt->check_password($postdata['password'], $password)) {

			//ternary operator use only for ITC multiuser login
			if ($check_user_password == true ? $this->bcrypt->check_password($postdata['password'], $password) : 1) {
				$institution_menus = $this->ss_aw_institution_menus->get_menus();
				$this->session->set_userdata('id', $institution_credential->ss_aw_parent_id);
				$this->session->set_userdata('fullname', $institution_credential->ss_aw_parent_full_name);
				$this->session->set_userdata('profile_pic', $institution_credential->ss_aw_parent_profile_photo);
				$this->session->set_userdata('user_mobile_no', $institution_credential->ss_aw_parent_primary_mobile);
				$this->session->set_userdata('user_email', $institution_credential->ss_aw_parent_email);
				$this->session->set_userdata('is_institute', 1);
				$this->session->set_userdata('role_ids', $institution_menus->ss_aw_institution_menus);
				if ($postdata['cheat_code'] != '') {
					redirect('master_lite/active_cheat_code/' . $postdata['cheat_code']);
				} else {
					redirect('admin/dashboard');
				}
			} else {
				$this->session->set_flashdata('error', 'Login fail.Invalid password.');
				redirect('admin/index');
			}
		} else {
			$this->session->set_flashdata('error', 'Login fail.Invalid email address.');
			redirect('admin/index');
		}
	}

	public function dashboard()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Dashboard";
		if ($this->session->userdata('is_institute')) {
			$data = array();
			$userid = $this->session->userdata('id');
			$institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($userid);
			$institution_id = $institute_admin_details[0]->ss_aw_institution;
			$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
			$institution_users_id = array();
			if (!empty($institution_parents)) {
				foreach ($institution_parents as $key => $value) {
					$institution_users_id[] = $value->ss_aw_parent_id;
				}
			}
			$result = $this->ss_aw_childs_model->get_all_institutional_users($institution_users_id);
			$child_ary = array();
			if (!empty($result)) {
				foreach ($result as $key => $value) {
					$child_ary[] = $value->ss_aw_child_id;
				}
			}
			$data['students_num'] = $this->ss_aw_child_course_model->get_institutional_enroll_count($child_ary);
			$data['last_payment'] = $this->ss_aw_institution_payment_details_model->get_institution_last_payment($institution_id);
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/institutiondashboard', $data);
			$this->load->view('admin/footer');
		} else {
			//get disputes details
			$api_key = FRESH_DESK_API;
			$password = FRESH_DESK_PASSWORD;
			$yourdomain = FRESH_DESK_DOMAIN;

			$url = "https://$yourdomain.freshdesk.com/api/v2/tickets";

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$info = curl_getinfo($ch);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = substr($server_output, 0, $header_size);
			$response = substr($server_output, $header_size);

			if ($info['http_code'] == 200) {
				$responsedata = json_decode($response, true);
				$data['disputes_count'] = count($responsedata);
			} else {
				$data['disputes_count'] = 0;
			}

			$searchary = array();
			$searchary['ss_aw_assesment_status'] = 1;
			$assessment_count = $this->ss_aw_assesment_uploaded_model->number_of_records($searchary);
			$searchary = array();
			$searchary['ss_aw_lesson_status'] = 1;
			$lesson_count = $this->ss_aw_lessons_uploaded_model->number_of_records($searchary);
			$reports_count = 12;
			$data['assessment_count'] = $assessment_count;
			$data['lesson_count'] = $lesson_count;
			$data['report_count'] = $reports_count;

			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/dashboard', $data);
			$this->load->view('admin/footer');
		}
	}

	public function logout()
	{
		session_destroy();
		$this->session->set_flashdata('success', 'Succesfully logout from your account.');
		redirect('admin/index');
	}

	public function profile()
	{
		$headerdata = $this->checklogin();

		$headerdata['title'] = "Profile";
		$headerdata['profile_name'] = $this->session->userdata('fullname');
		$userid = $this->session->userdata('id');
		$searchary = array();
		$searchary['ss_aw_admin_user_id'] = $userid;
		$userdetailsary = $this->ss_aw_admin_users_model->search_byparam($searchary);
		$userdetailsary = $userdetailsary[0];


		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/profile', $userdetailsary);
	}

	public function updateprofile()
	{
		$this->checklogin();
		$postdata = $this->input->post();
		$userid = $this->session->userdata('id');
		$profile_pic = "";
		$old_mobile = $this->session->userdata('user_mobile_no');
		$old_email = $this->session->userdata('user_email');


		if (isset($_FILES["profile_pic"]['name'])) {
			$config['upload_path']          = './assets/images/users/';
			$config['allowed_types']        = 'gif|jpg|png';
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
		}


		if (!empty($postdata['croppedimagesrc'])) {
			define('UPLOAD_DIR', './assets/images/users/');
			$img = $postdata['croppedimagesrc'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = UPLOAD_DIR . uniqid() . '.png';

			$success = file_put_contents($file, $data);
			$new_cropped_img = explode("/", $file);
			$new_cropped_img_name = $new_cropped_img[4];
		} else if ($postdata['old_cropped_image'] != '') {
			$new_cropped_img_name = $postdata['old_cropped_image'];
		} else {
			$new_cropped_img_name = "";
		}


		$queryary = array();
		$queryary['ss_aw_admin_user_id'] = $userid;
		$queryary['ss_aw_admin_user_full_name'] = $postdata['fullname'];
		$queryary['ss_aw_admin_user_countrycode'] = $postdata['countrycode'];

		if (!empty($postdata['password']))
			$queryary['ss_aw_admin_user_password'] = $this->bcrypt->hash_password($postdata['password']);

		$newphone = str_replace(array('+', '(', ')', '-', ' '), '', $postdata['phone']);
		if ($old_mobile != $newphone) {
			$queryary['ss_aw_admin_user_mobile_no'] = $postdata['phone'];
			$queryary['ss_aw_admin_user_mobile_approved'] = 0;
		}
		if ($old_email != $postdata['email']) {
			$queryary['ss_aw_admin_user_email'] = $postdata['email'];
			$queryary['ss_aw_admin_user_email_approved'] = 0;
		}
		if (!empty($profile_pic))
			$queryary['ss_aw_admin_user_profile_pic'] = $profile_pic;

		$queryary['ss_aw_admin_user_crop_pic'] = $new_cropped_img_name;


		$userdetailsary = $this->ss_aw_admin_users_model->update_details($queryary);
		if ($userdetailsary) {
			$this->session->set_userdata('fullname', $queryary['ss_aw_admin_user_full_name']);

			$this->session->set_userdata('user_mobile_no', $newphone);
			$this->session->set_userdata('user_email', $postdata['email']);
			if (isset($_FILES["profile_pic"]['name']))
				$this->session->set_userdata('profile_pic', $new_cropped_img_name);
			else
				$this->session->set_userdata('profile_pic', $new_cropped_img_name);
		}
		$this->session->set_flashdata('success', 'Succesfully profile updated.');
		redirect('admin/profile');
	}

	public function adminusers()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Admin users list";
		$data = array();
		$data = adminmenusection(); //For Access control seting in Add user modal
		$postdata = $this->input->post();
		$searchdata = array();
		if ($postdata) {
			$searchdata['search_value'] = $postdata['search_value'];
			if (!empty($postdata['selected_roles'])) {
				$data['selected_roles'] = $postdata['selected_roles'];
				$searchdata['selected_roles'] = $data['selected_roles'];
			}
		}
		/*
		VIEW USERS LIST 
		*/

		$searchdata['ss_aw_admin_user_id >'] = 1;
		$usersary = $this->ss_aw_admin_users_model->search_byparam($searchdata);

		$searchary = array();
		$adminmenuary = $this->ss_aw_adminmenus_model->search_byparam($searchary);

		$data['adminuserslist'] = $usersary;
		$data['adminmenuary'] = $adminmenuary;

		if (!empty($searchdata['search_value']))
			$data['search_value'] = $searchdata['search_value'];
		if (!empty($searchdata['selected_roles'])) {
			$data['selected_roles'] = $postdata['selected_roles'];
		}

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/adminusers', $data);
	}

	public function manageparents()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Admin users list";
		$data = adminmenusection();
		$search_parent_data = "";
		$postdata = $this->input->post();

		if (isset($postdata['parent_status_change'])) {
			$pageno = $postdata['status_pageno'];
			$parent_id = $postdata['status_parent_id'];
			$parent_status = $postdata['status_parent_status'];
			$this->ss_aw_parents_model->update_active_status($parent_id, $parent_status);
			if ($parent_status == 0) {
				$this->ss_aw_parents_model->logout($parent_id);
				$childs = $this->ss_aw_childs_model->get_child_details($parent_id);
				if (!empty($childs)) {
					foreach ($childs as $key => $value) {
						$this->ss_aw_childs_model->logout($value->ss_aw_child_id);
						$this->ss_aw_childs_model->chnage_child_status($value->ss_aw_child_id, 0);
					}
				}
			}
			$this->session->set_flashdata('success', 'Parent Staus updated.');
			redirect('admin/manageparents/' . $pageno);
		}
		if (isset($postdata['parent_delete_process'])) {
			$parent_id = $postdata['parent_delete_id'];
			$this->ss_aw_parents_model->deleterecord_byid($parent_id);
			$this->ss_aw_childs_model->deleterecord_byid($parent_id);
			$this->session->set_flashdata('success', 'Parent Deleted Successful');
		}
		if (isset($postdata['parent_logout'])) {
			$parent_id = $postdata['logout_parent_id'];
			$this->ss_aw_parents_model->logout($parent_id);
		}

		if (isset($postdata['search_parent'])) {
			if (isset($postdata['search_parent_data'])) {
				$search_parent_data = $postdata['search_parent_data'];
			}
			$this->session->set_userdata('search_parent_data', $search_parent_data);

			$data['search_parent_data'] = $search_parent_data;
		}
		if ($this->session->userdata('search_parent_data') != "") {
			if ($this->session->userdata('search_parent_data') != "") {
				$search_parent_data = $this->session->userdata('search_parent_data');
			}
			$this->session->set_userdata('search_parent_data', $search_parent_data);
			$data['search_parent_data'] = $search_parent_data;
		}

		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/manageparents';
		$config["total_rows"] = $this->ss_aw_parents_model->number_of_records($search_parent_data);
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item page-link">';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '<span aria-hidden="true">&lt;</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '<span aria-hidden="true">&gt;</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li class="page-item page-link">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item page-link">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item page-link">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		$parent_arr = $this->ss_aw_parents_model->get_all_records($config['per_page'], $page, $search_parent_data);
		$data['page'] = $page;

		$i = 0;
		foreach ($parent_arr as $value) {
			$child_count = $this->ss_aw_childs_model->get_all_child_count($value->ss_aw_parent_id);
			$temp_child_count = $this->ss_aw_childs_temp_model->get_child_count_by_parent_id($value->ss_aw_parent_id);
			$parent_arr[$i]->num_temp_childs = $temp_child_count;
			if ($child_count == 0) {
				$parent_arr[$i]->num_childs = 0;
			} else {
				$parent_arr[$i]->num_childs = $child_count;
			}
			$i++;
		}
		$data['result'] = $parent_arr;
		$data['countries'] = $this->ss_aw_countries_model->get_all_records();
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/manageparents', $data);
	}

	public function addadminuser()
	{
		$postdata = $this->input->post();
		$fullname = $postdata['fullname'];
		$email = $postdata['email'];
		$mobile = str_replace('-', '', $postdata['mobile']);
		$setroleary = $postdata['my_multi_select2'];
		$user_role_ids = implode(",", $setroleary);
		$password = 12345678;
		$hash_pass = $this->bcrypt->hash_password($password);
		$adduserdata = array();
		$adduserdata['ss_aw_admin_user_full_name'] = $fullname;
		$adduserdata['ss_aw_admin_user_mobile_no'] = $mobile;
		$adduserdata['ss_aw_admin_user_email'] = $email;
		$adduserdata['ss_aw_admin_user_password'] = $hash_pass;
		$adduserdata['ss_aw_admin_user_role_ids'] = $user_role_ids;
		$userid = $this->ss_aw_admin_users_model->data_insert($adduserdata);

		$subject = "team Admin user login credential";
		$msg = "New admin user created.Login username : " . $email . " and password: " . $password;
		emailnotification($email, $subject, $msg);

		$this->session->set_flashdata('success', 'Succesfully new admin user added.');
		redirect('admin/adminusers');
	}

	public function editadminuser()
	{
		$postdata = $this->input->post();
		$fullname = $postdata['fullname'];
		$email = $postdata['email'];
		$mobile = str_replace('-', '', $postdata['mobile']);
		$setroleary = $postdata['edit_my_multi_select2'];
		$user_role_ids = implode(",", $setroleary);
		$userid = $postdata['userid'];

		$adduserdata = array();
		$adduserdata['ss_aw_admin_user_id'] = $userid;
		$adduserdata['ss_aw_admin_user_full_name'] = $fullname;
		$adduserdata['ss_aw_admin_user_mobile_no'] = $mobile;
		$adduserdata['ss_aw_admin_user_mobile_approved'] = 1;
		$adduserdata['ss_aw_admin_user_email'] = $email;
		$adduserdata['ss_aw_admin_user_email_approved'] = 1;
		$adduserdata['ss_aw_admin_user_role_ids'] = str_replace("'", "", $user_role_ids);
		$userid = $this->ss_aw_admin_users_model->update_details($adduserdata);

		$this->session->set_flashdata('success', 'Succesfully new admin user added.');
		redirect('admin/adminusers');
	}

	public function about_us()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "About Us";
		$data = adminmenusection();
		$page_id = '1';

		if ($this->input->post('page_data') != "") {
			$update_data['page_data'] = $this->input->post('page_data');


			$update_data['added_by'] = $this->session->userdata('id');
			$update_data['created_date'] = date('Y-m-d H:i:s');
			$this->ss_aw_page_content_model->update_page_content($page_id, $update_data);
			$this->session->set_flashdata('success', 'Data Update Succesfully');

			$email = "saumojit.nandy@schemaphic.com";
			$msg = "About us details updated by " . $this->session->userdata('fullname');
			$subject = "About Us Details Changed";
			$email = $headerdata['user_email'];
			emailnotification($email, $subject, $msg);
		}


		$data['page_data_content'] = $this->ss_aw_page_content_model->get_page_data($page_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/aboutus', $data);
	}
	public function terms_conditions()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Terms & Conditions";
		$data = adminmenusection();
		$page_id = '2';



		if ($this->input->post('page_data') != "") {
			$update_data['page_data'] = $this->input->post('page_data');


			$update_data['added_by'] = $this->session->userdata('id');
			$update_data['created_date'] = date('Y-m-d H:i:s');
			$this->ss_aw_page_content_model->update_page_content($page_id, $update_data);
			$this->session->set_flashdata('success', 'Data Update Succesfully');
		}


		$data['page_data_content'] = $this->ss_aw_page_content_model->get_page_data($page_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/terms_conditions', $data);
	}
	public function privacy_policy()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Privacy Policy";
		$data = adminmenusection();
		$page_id = '3';



		if ($this->input->post('page_data') != "") {
			$update_data['page_data'] = $this->input->post('page_data');


			$update_data['added_by'] = $this->session->userdata('id');
			$update_data['created_date'] = date('Y-m-d H:i:s');
			$this->ss_aw_page_content_model->update_page_content($page_id, $update_data);
			$this->session->set_flashdata('success', 'Data Update Succesfully');
		}


		$data['page_data_content'] = $this->ss_aw_page_content_model->get_page_data($page_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/privacy_policy', $data);
	}

	public function cancellation_policy()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Cancellation Policy";
		$data = adminmenusection();
		$page_id = '4';



		if ($this->input->post('page_data') != "") {
			$update_data['page_data'] = $this->input->post('page_data');


			$update_data['added_by'] = $this->session->userdata('id');
			$update_data['created_date'] = date('Y-m-d H:i:s');
			$this->ss_aw_page_content_model->update_page_content($page_id, $update_data);
			$this->session->set_flashdata('success', 'Data Update Succesfully');
		}


		$data['page_data_content'] = $this->ss_aw_page_content_model->get_page_data($page_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/cancellation_policy', $data);
	}

	public function faq()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "FAQ";
		$data = adminmenusection();
		$postdata = $this->input->post();
		$faq_search_data = "";


		if (isset($postdata['add_faq'])) {
			$insert_data['faq_user_type'] = $postdata['user_type'];
			$insert_data['faq_question'] = $postdata['faq_question'];
			$insert_data['faq_answer'] = $postdata['faq_answer'];

			if (isset($postdata['faq_status'])) {
				$insert_data['faq_status'] = 1;
			} else {
				$insert_data['faq_status'] = 0;
			}
			$insert_data['added_by'] = $this->session->userdata('id');
			$insert_data['create_date'] = date('Y-m-d H:i:s');
			$insert_data['modify_date'] = date('Y-m-d H:i:s');
			$this->ss_aw_faq_model->insert_data($insert_data);
			$this->session->set_flashdata('success', 'Data Inser Succesfully');
		}
		if (isset($postdata['faq_search'])) {
			$faq_search_data = $postdata['faq_search_data'];
			$data['faq_search_data'] = $faq_search_data;
			$this->session->set_userdata('faq_search_data', $faq_search_data);
		}

		if ($this->session->userdata('faq_search_data') != "") {
			if ($this->session->userdata('faq_search_data') != "") {
				$faq_search_data = $this->session->userdata('faq_search_data');
			}
			$this->session->set_userdata('faq_search_data', $faq_search_data);
			$data['faq_search_data'] = $faq_search_data;
		}



		if (isset($postdata['faq_status_change'])) {
			echo $faq_id = $postdata['faq_id'];
			echo "<br>" . $faq_status = $postdata['faq_status'];
			exit();
		}
		if (isset($postdata['edit_faq'])) {
			$faq_id = $postdata['edit_faq_id'];
			$update_array['faq_user_type'] = $postdata['user_type'];
			$update_array['faq_question'] = $postdata['edit_question'];
			$update_array['faq_answer'] = $postdata['edit_answer'];
			$update_array['added_by'] = $this->session->userdata('id');
			$update_array['modify_date'] = date('Y-m-d H:i:s');

			if (isset($postdata['edit_faq_status'])) {
				$update_array['faq_status'] = 1;
			} else {
				$update_array['faq_status'] = 0;
			}
			$this->ss_aw_faq_model->update_faq($faq_id, $update_array);

			$this->session->set_flashdata('success', 'Data Update Succesfully');

			$email = $headerdata['user_email'];
			$msg = "FAQ updated by " . $this->session->userdata('fullname');
			$subject = "FAQ Changed Notification";

			emailnotification($email, $subject, $msg);
		}
		if (isset($postdata['delete_faq'])) {
			$faq_id = $postdata['delete_faq_id'];
			$this->ss_aw_faq_model->delete_faqbyid($faq_id);
			$this->session->set_flashdata('success', 'Data Deleted Succesfully');
			$email = "saumojit.nandy@schemaphic.com";
			$msg = "FAQ deleted by " . $this->session->userdata('fullname');
			$subject = "FAQ Deleted Notification";
			// use wordwrap() if lines are longer than 70 characters
			$msg = wordwrap($msg, 70);
			$email = $headerdata['user_email'];

			emailnotification($email, $subject, $msg);
		}


		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/faq';
		$config["total_rows"] = $this->ss_aw_faq_model->number_of_records($faq_search_data);
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item page-link">';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '<span aria-hidden="true">�</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '<span aria-hidden="true">�</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li class="page-item page-link">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item page-link">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item page-link">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		$data['result'] = $this->ss_aw_faq_model->get_all_faq($config['per_page'], $page, $faq_search_data);
		$data['page'] = $page;

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/faq', $data);
	}

	public function getfaqdetail()
	{
		$faq_id = $this->input->get('faq_id');
		$result = $this->ss_aw_faq_model->getdatabyid($faq_id);
		$responseary = array();
		if (!empty($result)) {
			$responseary['faq_id'] = $result[0]->faq_id;
			$responseary['faq_question'] = $result[0]->faq_question;
			$responseary['faq_answer'] = $result[0]->faq_answer;
			$responseary['faq_user'] = $result[0]->faq_user_type;
			$responseary['faq_status'] = $result[0]->faq_status;
		}

		echo json_encode($responseary);
	}

	public function screen_messages()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Screen Messages";
		$data = adminmenusection();
		$postdata = $this->input->post();
		$error_search_data = '';

		if (isset($postdata['error_search'])) {
			if (isset($postdata['error_search_data'])) {
				$error_search_data = $postdata['error_search_data'];
			}
			$this->session->set_userdata('error_search_data', $error_search_data);

			$data['error_search_data'] = $error_search_data;
		}
		if ($this->session->userdata('error_search_data') != "") {
			if ($this->session->userdata('error_search_data') != "") {
				$error_search_data = $this->session->userdata('error_search_data');
			}
			$this->session->set_userdata('error_search_data', $error_search_data);
			$data['error_search_data'] = $error_search_data;
		}
		if (isset($postdata['edit_error_record'])) {
			$error_status = $postdata['edit_error_status'];
			$error_message = $postdata['edit_error_message'];
			$this->ss_aw_error_code_model->update_record($error_status, $error_message);
			$this->session->set_flashdata('success', 'Data Updated Succesfully');
		}


		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/screen_messages';
		$config["total_rows"] = $this->ss_aw_error_code_model->number_of_records($error_search_data);
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item page-link">';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '<span aria-hidden="true">�</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '<span aria-hidden="true">�</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li class="page-item page-link">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item page-link">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item page-link">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		$data['result'] = $this->ss_aw_error_code_model->get_all_faq($config['per_page'], $page, $error_search_data);
		$data['page'] = $page;

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/screen_messages', $data);
	}
	public function childrendetails()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Children Details";
		$data = adminmenusection();
		$postdata = $this->input->post();
		$parent_id =  $this->uri->segment(3);
		$data['manage_parent_page'] = $this->uri->segment(4) ? $this->uri->segment(4) : '';
		if (isset($postdata['chnage_child_status'])) {
			$child_id = $postdata['status_child_id'];
			$child_status = $postdata['status_child_status'];
			$this->ss_aw_childs_model->chnage_child_status($child_id, $child_status);
			if ($child_status == 0) {
				$this->ss_aw_childs_model->logout($child_id);
			}
			$this->session->set_flashdata('success', 'Child status succesfully change ');
		}
		if (isset($postdata['delete_child'])) {
			$child_id = $postdata['delete_child_id'];
			$this->ss_aw_childs_model->deleterecord_by_childid($child_id);
			$this->session->set_flashdata('success', 'Child Deleted succesfully done');
		}
		if (isset($postdata['delete_temp_child'])) {
			$child_id = $postdata['delete_child_temp_id'];
			$this->ss_aw_childs_temp_model->delete_single_child($child_id);
			$this->session->set_flashdata('success', 'Child Deleted succesfully done');
		}
		if (isset($postdata['child_logout'])) {
			$child_id = $postdata['logout_child_id'];
			$this->ss_aw_childs_model->logout($child_id);
			$this->session->set_flashdata('success', 'Child logout succesfully done');
		}
		if (isset($postdata['chnage_child_block_status'])) {
			$child_id = $postdata['block_child_id'];
			$block_status = $postdata['block_child_status'];
			$update_data = array(
				'ss_aw_blocked' => $block_status
			);
			$this->ss_aw_childs_model->update_child_details($update_data, $child_id);
			$this->session->set_flashdata('success', 'Child blocked status changed succesfully.');
		}

		if (isset($postdata['child_approval'])) {
			$child_id = $postdata['approval_child_id'];
			$child_details = $this->ss_aw_childs_temp_model->get_child_details($child_id);
			if (!empty($child_details)) {
				$tmp_parent_id = $child_details[0]->ss_aw_parent_id;
				$tmp_child_nick_name = $child_details[0]->ss_aw_child_nick_name;
				$tmp_child_dob = $child_details[0]->ss_aw_child_dob;
				$tmp_child_age = $child_details[0]->ss_aw_child_age;
				$tmp_child_email = $child_details[0]->ss_aw_child_email;
				$tmp_child_mobile = $child_details[0]->ss_aw_child_mobile;
				$tmp_child_coutry_code = $child_details[0]->ss_aw_child_country_code;
				$tmp_child_coutry_sort_name = $child_details[0]->ss_aw_child_country_sort_name;
				$tmp_child_password = $child_details[0]->ss_aw_child_password;
				$tmp_child_image_color_no = $child_details[0]->ss_aw_child_image_color_no;
				$tmp_child_username = $child_details[0]->ss_aw_child_username;

				$code_check = $this->ss_aw_childs_model->child_code_check();
				if (isset($code_check)) {
					$random_code = $code_check->ss_aw_child_code + 1;
				} else {
					$random_code =  10000001;
				}

				$child_code = $random_code;
				$child_data['ss_aw_child_code'] = $child_code;
				$child_data['ss_aw_parent_id'] = $tmp_parent_id;
				$child_data['ss_aw_child_nick_name'] = $tmp_child_nick_name;
				$child_data['ss_aw_child_dob'] = $tmp_child_dob;
				$child_data['ss_aw_child_age'] = $tmp_child_age;
				$child_data['ss_aw_child_email'] = $tmp_child_email;
				$child_data['ss_aw_child_mobile'] = $tmp_child_mobile;
				$child_data['ss_aw_child_country_code'] = $tmp_child_coutry_code;
				$child_data['ss_aw_child_country_sort_name'] = $tmp_child_coutry_sort_name;
				$child_data['ss_aw_child_password'] = $tmp_child_password;
				$child_data['ss_aw_child_username'] = $tmp_child_username;
				$result = $this->ss_aw_childs_model->add_child($child_data);
				if ($result) {
					$this->ss_aw_childs_temp_model->delete_single_child($child_id);
					$this->session->set_flashdata('success', 'Child approved succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}
		}

		$result = $this->ss_aw_childs_model->get_all_child_details_except_self($parent_id);
		$lessoncount = array();
		$assessmentcount = array();
		$readalongcount = array();
		$paymentstatus = array();
		$course_complete_status = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$course_start_date = $value->course_start_date;
				$child_id = $value->ss_aw_child_id;
				$duration = "";
				$lessoncount[$value->ss_aw_child_id] = $this->ss_aw_child_last_lesson_model->gettotalcompletenum($value->ss_aw_child_id, $course_start_date);
				$assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenum($value->ss_aw_child_id, $course_start_date);

				$readalongcount[$value->ss_aw_child_id] = $this->ss_aw_last_readalong_model->gettotalcompletenum($value->ss_aw_child_id, $course_start_date);
				//check course completion status
				$course_complete_status[$value->ss_aw_child_id] = $this->ss_aw_child_course_model->check_course_complete_or_not($value->ss_aw_child_id, $value->course);
				//end
				$child_course_details = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);

				if (!empty($child_course_details)) {

					if ($child_course_details[count($child_course_details) - 1]['ss_aw_course_payemnt_type'] == 1) {
						$previous_course = "";
						if ($value->course == 2) {
							$previous_course = "E";
						} elseif ($value->course == 3) {
							$previous_course = "C";
						}

						$total_complete_emi_count = 0;
						if (!empty($previous_course)) {
							$check_promotion = $this->ss_aw_promotion_model->get_promotion_detail($child_id, $previous_course);
							if ($previous_course == "E") {
								$previous_course_id = 1;
							} elseif ($previous_course == "C") {
								$previous_course_id = 2;
							}
							if (!empty($check_promotion)) {
								if ($previous_course_id == 2) {
									$duration = 9;
								}
								$searchary = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_child_id' => $child_id,
									'ss_aw_selected_course_id' => $previous_course_id
								);

								$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
								$total_complete_emi_count = $total_complete_emi_count + count($count_previous_emi);
							}
						}

						$searchary = array(
							'ss_aw_parent_id' => $parent_id,
							'ss_aw_child_id' => $value->ss_aw_child_id,
							'ss_aw_selected_course_id' => $value->course
						);

						$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
						$total_complete_emi_count = $total_complete_emi_count + count($count_previous_emi);
						$paymentstatus[$value->ss_aw_child_id]['payment_status'] = 2;
						$paymentstatus[$value->ss_aw_child_id]['emi_count'] = $total_complete_emi_count;
						$paymentstatus[$value->ss_aw_child_id]['duration'] = $duration;
					} else {
						$payment_details = $this->ss_aw_purchase_courses_model->checkpaidornot($value->ss_aw_child_id, $value->course);
						if (!empty($payment_details)) {
							$paymentstatus[$value->ss_aw_child_id]['payment_status'] = 1;
							$paymentstatus[$value->ss_aw_child_id]['transaction_id'] = $payment_details[0]->ss_aw_transaction_id;
						} else {
							$paymentstatus[$value->ss_aw_child_id]['payment_status'] = 0;
						}
					}
				} else {
					$payment_details = $this->ss_aw_purchase_courses_model->checkpaidornot($value->ss_aw_child_id, $value->course);
					if (!empty($payment_details)) {
						$paymentstatus[$value->ss_aw_child_id]['payment_status'] = 1;
						$paymentstatus[$value->ss_aw_child_id]['transaction_id'] = $payment_details[0]->ss_aw_transaction_id;
					} else {
						$paymentstatus[$value->ss_aw_child_id]['payment_status'] = 0;
					}
				}
			}
		}


		//get temp students
		$temp_cilds = $this->ss_aw_childs_temp_model->get_child_by_parent_id($parent_id);
		$data['temp_cilds'] = $temp_cilds;
		//end
		$searary = array();
		$searary['ss_aw_course_type_id'] = 1;
		$searary['ss_aw_course_status'] = 0;
		$data['courses'] = $this->ss_aw_courses_model->search_byparam($searary);
		$data['result'] = $result;
		$data['lessoncount'] = $lessoncount;
		$data['assessmentcount'] = $assessmentcount;
		$data['readalongcount'] = $readalongcount;
		$data['paymentstatus'] = $paymentstatus;
		$data['parent_id'] = $parent_id;
		$data['course_complete_status'] = $course_complete_status;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/childrendetails', $data);
	}
	public function managecoursepricing()
	{

		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage Course Pricing";
		$data = adminmenusection();
		$postdata = $this->input->post();

		if (isset($postdata['update_course_price'])) {
			$update_data['ss_aw_course_price'] = $postdata['course_price'];
			$update_data['ss_aw_apple_course_price'] = $postdata['apple_course_price'];
			$update_data['ss_aw_installment_price'] = $postdata['installment_price'];
			$update_data['ss_aw_apple_installment_price'] = $postdata['apple_installment_price'];
			$update_data['ss_aw_course_currency'] = $postdata['course_currency'];
			$update_data['ss_aw_sort_description'] = $postdata['sort_desc'];
			$update_data['ss_aw_long_description'] = $postdata['long_desc'];
			$course_id = $postdata['course_id'];
			$this->ss_aw_courses_model->data_update($course_id, $update_data);
			$this->session->set_flashdata('success', 'Price update Succesfully done');

			$course_name = $postdata['course_name'];
			$email = $headerdata['user_email'];

			$msg = $course_name . " details updated by " . $this->session->userdata('fullname');
			$subject = "Course Details Changed";
			// use wordwrap() if lines are longer than 70 characters
			$msg = wordwrap($msg, 70);


			emailnotification($email, $subject, $msg);
		} else if (isset($postdata['gst_value'])) {
			$sql = "UPDATE `ss_aw_courses` SET `ss_aw_gst_rate` = '" . $postdata['gst_value'] . "'";
			$this->db->query($sql);
			$this->session->set_flashdata('success', 'GST rate update succesfully done.');
		}

		$data['result'] = $this->ss_aw_courses_model->get_all_data();
		$data['curerncy'] = $this->ss_aw_currencies_model->get_all_currency();
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/managecoursepricing', $data);
	}

	public function deleteadminusers()
	{
		$postdata = $this->input->post();
		$dataary = array();
		$dataary['ss_aw_admin_user_id'] = $postdata['admin_delete_id'];
		$dataary['ss_aw_admin_user_deleted'] = 1;
		$this->ss_aw_admin_users_model->update_details($dataary);
		$this->session->set_flashdata('success', 'Admin user deleted from system.');
		redirect('/admin/adminusers');
	}
	public function statusadminusers()
	{
		$postdata = $this->input->post();
		$dataary = array();
		$dataary['ss_aw_admin_user_id'] = $postdata['admin_status_id'];
		$dataary['ss_aw_admin_user_status'] = $postdata['admin_status'];
		$this->ss_aw_admin_users_model->update_details($dataary);
		$this->session->set_flashdata('success', 'Admin user status updated.');
		redirect('/admin/adminusers');
	}

	public function getadminuserdata()
	{
		$postdata = $this->input->post();
		$userid = $postdata['id'];
		$searchary = array();
		$searchary['ss_aw_admin_user_id'] = $userid;
		$userdetailsary = $this->ss_aw_admin_users_model->search_byparam($searchary);
		echo json_encode($userdetailsary[0]);
		die();
	}

	public function notificationtemplatescms()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "notificationtemplatescms";
		$data = adminmenusection();
		$postdata = $this->input->post();
		if (isset($postdata['select_notification_preview'])) {
			$id = $postdata['select_notification'];
			if ($id != '0') {
				$data['email_template_resultbyid'] =  $this->ss_aw_email_notification_cms_model->fetch_data_by_id($id);
				$data['app_template_resultbyid'] = $this->ss_aw_app_notification_cms_model->fetch_data_by_id($id);
				$data['select_notification'] = $id;
			}
		}

		$email_template_result = $this->ss_aw_email_notification_cms_model->fetch_all_record();
		$app_template_result = $this->ss_aw_app_notification_cms_model->fetch_all_record();
		$data['notification_param'] = $this->ss_aw_notification_param_model->getallparam();
		$data['email_template_result'] = $email_template_result;
		$data['app_template_result'] = $app_template_result;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/notificationtemplatescms', $data);
	}
	public function update_notificationtemplatescms()
	{
		$this->checklogin();
		$postdata = $this->input->post();
		if (isset($postdata['update_template_email'])) {
			$id = $postdata['id'];
			if ($postdata['user_type'] == 'parent') {
				$update_array['ss_aw_email_temp_contain'] = $postdata['email_template_contain'];
			} else {
				$update_array['ss_aw_child_email_temp_contain'] = $postdata['email_template_contain_child'];
			}
			// $update_array['ss_aw_email_temp_status'] = $postdata['email_template_status'];
			$this->ss_aw_email_notification_cms_model->update_records_byid($id, $update_array);
			echo  true;
		}
		if (isset($postdata['update_template_email_status'])) {
			$id = $postdata['id'];
			$update_array['ss_aw_email_temp_status'] = $postdata['email_template_status'];
			$this->ss_aw_email_notification_cms_model->update_records_byid($id, $update_array);
			echo  true;
		}


		if (isset($postdata['update_template_app'])) {
			$id = $postdata['id'];
			if ($postdata['user_type'] == 'parent') {
				$update_array['ss_aw_app_temp_contain'] = $postdata['app_template_contain'];
			} else {
				$update_array['ss_aw_app_temp_contain_child'] = $postdata['app_template_contain_child'];
			}
			// $update_array['ss_aw_app_temp_status'] = $postdata['app_template_status'];
			$this->ss_aw_app_notification_cms_model->update_records_byid($id, $update_array);
			echo  true;
		}

		if (isset($postdata['update_template_app_status'])) {
			$id = $postdata['id'];
			$update_array['ss_aw_app_temp_status'] = $postdata['app_template_status'];
			$this->ss_aw_app_notification_cms_model->update_records_byid($id, $update_array);
			echo  true;
		}
	}

	public function ajax_send_testmail()
	{
		$this->checklogin();
		$postdata = $this->input->post();

		$test_emailsary = explode(",", $postdata['test_emails']);
		$count = 0;
		$attachment  = $postdata['attachment'];
		foreach ($test_emailsary as $email) {
			$temp_contain = str_ireplace("[@@email@@]", $email, $postdata['email_template_contain']);
			$temp_contain = str_ireplace("[@@mobile@@]", "9900000000", $temp_contain);
			$temp_contain = str_ireplace("[@@username@@]", $this->session->userdata('fullname'), $temp_contain);

			$msg = wordwrap($temp_contain, 70);
			if (!empty($postdata['email_subject'])) {
				$subject = $postdata['email_subject'];
			} else {
				$subject = "Test mail for email template";
			}
			// send email
			//$response = sendmail($msg, $subject, $email, 'deepanjan.das@gmail.com,ateesh@team.com', $attachment);
			//$response = sendmail($msg,$subject,$email,'deepanjan.das@gmail.com',$attachment);
			$response = emailnotification($email, $subject, $msg);
			echo $response;
			die();
			if ($response) {
				$count++;
			}
		}
		if ($count > 0) {
			echo  true;
		} else {
			echo false;
		}
		die();
	}


	public function reportsdashboard()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "reportsdashboard";
		$data = adminmenusection();

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/reportsdashboard', $data);
	}

	public function assessmentquizmatrixsetup()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "assessmentquizmatrixsetup";
		$data = adminmenusection();
		$postdata = $this->input->post();

		if (isset($postdata['update_matrix_record'])) {
			$final_array = $postdata;
			array_pop($final_array);
			$count = sizeof($final_array);
			$update_array = array();

			for ($i = 1; $i < $count + 1; $i++) {
				$key = 'section' . $i;
				$array_count = sizeof($final_array[$key]);

				$timing_id	 = $final_array[$key][0];
				$update_array['ss_aw_total_question'] = $final_array[$key][1];
				$update_array['ss_aw_min_question']	 = $final_array[$key][2];
				$this->ss_aw_assessment_subsection_matrix_model->update_records_byid($timing_id, $update_array);
			}
		}

		$result = $this->ss_aw_assessment_subsection_matrix_model->fetch_all_record();
		$data['result'] = $result;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/assessmentquizmatrixsetup', $data);
	}

	public function setreporttimings()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "setreporttimings";
		$data = adminmenusection();
		$timing_id = 4;

		$postdata = $this->input->post();
		if (isset($postdata['update_report_time'])) {

			$report_time = $postdata['report_time'];
			$this->ss_aw_test_timing_model->update_records($timing_id, $report_time);
		}



		$record_data = $this->ss_aw_test_timing_model->fetch_record_byid($timing_id);

		$data['result'] = $record_data;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/setreporttimings', $data);
	}

	public function check_admin_email_exist()
	{
		$postdata = $this->input->post();
		$email = $postdata['email'];
		$userid = $postdata['userid'];

		$dataary['ss_aw_admin_user_email'] = $email;
		$searchdataary = array();
		$searchdataary = $this->ss_aw_admin_users_model->search_byparam($dataary);

		if (!empty($searchdataary) && ($userid != $searchdataary[0]['ss_aw_admin_user_id'])) {
			echo 0;
		} else {
			if ($userid != 0) {
				$rand = rand(1000, 9999);
				$subject = "team admin user email valification";
				$msg = "Email valification code : " . $rand;
				$insertdata = array();
				$insertdata['ss_aw_user_id'] = $userid;
				$insertdata['ss_aw_email'] = $email;
				$insertdata['ss_aw_code'] = $rand;
				$this->ss_aw_email_valification_model->insert_data($insertdata);
				sendmail($msg, $subject, $email);
			}
			echo 1;
		}
		die();
	}

	public function verify_email()
	{
		$postdata = $this->input->post();
		$email = $postdata['email'];
		$code = $postdata['code'];

		$dataary['ss_aw_email'] = $email;
		$dataary['ss_aw_code'] = $code;
		$searchdataary = array();
		$searchdataary = $this->ss_aw_email_valification_model->check_data_param($dataary);
		if (!empty($searchdataary)) {
			$this->ss_aw_email_valification_model->delete_record($searchdataary[0]->ss_aw_user_id);
			echo 1;
		} else {
			echo 0;
		}
		die();
	}

	public function check_admin_phone_exist()
	{
		$postdata = $this->input->post();
		$phone = $postdata['phone'];
		$userid = $postdata['userid'];
		$email = $postdata['email'];
		$dataary['ss_aw_admin_user_mobile_no'] = $phone;
		$searchdataary = array();
		$searchdataary = $this->ss_aw_admin_users_model->search_byparam($dataary);

		if (!empty($searchdataary) && ($userid != $searchdataary[0]['ss_aw_admin_user_id'])) {
			echo 0;
		} else {
			if ($userid != 0) {
				$rand = rand(1000, 9999);
				$subject = "team admin user mobile no valification";
				$msg = "Mobile valification code : " . $rand;
				$insertdata = array();
				$insertdata['ss_aw_user_id'] = $userid;
				$insertdata['ss_aw_phone'] = $phone;
				$insertdata['ss_aw_code'] = $rand;
				$this->ss_aw_phone_valification_model->insert_data($insertdata);
				sendmail($msg, $subject, $email);
			}
			echo 1;
		}
		die();
	}

	public function verify_phone()
	{
		$postdata = $this->input->post();
		$phone = $postdata['phone'];
		$code = $postdata['code'];

		$dataary['ss_aw_phone'] = $phone;
		$dataary['ss_aw_code'] = $code;
		$searchdataary = array();
		$searchdataary = $this->ss_aw_phone_valification_model->check_data_param($dataary);
		if (!empty($searchdataary)) {
			$this->ss_aw_phone_valification_model->delete_record($searchdataary[0]->ss_aw_user_id);
			echo 1;
		} else {
			echo 0;
		}
		die();
	}

	function multipledeleteadminusers()
	{
		$postdata = $this->input->post();
		if ($postdata['selected_action'] == 3) {
			$usersary = $postdata['selectedusers'];
			foreach ($usersary as $value) {
				$deleteary = array();
				$deleteary['ss_aw_admin_user_id'] = $value;
				$deleteary['ss_aw_admin_user_deleted'] = 1;
				$this->ss_aw_admin_users_model->update_details($deleteary);
			}
			$this->session->set_flashdata('success', 'All selected admin users deleted from system.');
			redirect('/admin/adminusers');
		}
	}

	public function topics()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();

		$search_data = array();
		if (!empty($postdata['status_topic_id'])) {
			$status_lesson_id = $postdata['status_topic_id'];
			$status_lesson_status = $postdata['status_topic_status'];
			$dataary = array();
			$dataary['ss_aw_section_id'] = $status_lesson_id;
			$dataary['ss_aw_section_status'] = $status_lesson_status;
			$this->ss_aw_sections_topics_model->update_record($dataary);
			$this->ss_aw_assesment_uploaded_model->update_status($status_lesson_id, $status_lesson_status == 0 ? 2 : 1);
			$this->ss_aw_lessons_uploaded_model->update_status($status_lesson_id, $status_lesson_status);
			$this->session->set_flashdata('success', 'Topic status succesfully change.');
		} else if (!empty($postdata['topic_delete_id'])) {
			$topic_delete_id = $postdata['topic_delete_id'];
			$topic_delete_process = $postdata['topic_delete_process'];
			$dataary = array();
			$dataary['ss_aw_section_id'] = $topic_delete_id;
			$dataary['ss_aw_topic_deleted'] = $topic_delete_process;

			//GET previous topic data//
			$prev_data = $this->ss_aw_sections_topics_model->getrecordbyid($topic_delete_id);
			$prev_data_arr = explode(",", $prev_data[0]->ss_aw_expertise_level);
			foreach ($prev_data_arr as $prv_arr) {
				$sql = " - 1";
				if ($prv_arr == 'E') {
					$cour_id = 1;
				} elseif ($prv_arr == 'C') {
					$cour_id = 3;
				} elseif ($prv_arr == 'A') {
					$cour_id = 5;
				} elseif ($prv_arr == 'M') {
					$cour_id = 5;
				}
				$this->ss_aw_course_count_model->update_record_by_query($sql, $cour_id);
			}



			$this->ss_aw_sections_topics_model->update_record($dataary);
			$this->session->set_flashdata('success', 'Topic deleted succesfully.');
		} else if (isset($postdata['add_new_topic'])) {
			$last_topic_details = $this->ss_aw_sections_topics_model->get_last_record();
			$insert_data['ss_aw_section_reference_no'] = $last_topic_details->ss_aw_section_reference_no + 1;
			$insert_data['ss_aw_section_title'] = $postdata['new_topic'];
			$insert_data['ss_aw_topic_description'] = $postdata['add_topic_desc'];
			$add_level = implode(',', $postdata['add_topic_level']);

			//$insert_data['ss_aw_expertise_level'] = $add_level;
			$insert_data['ss_aw_expertise_level'] = strtoupper($add_level);
			$expertise_level = explode(",", strtoupper($edit_level));
			foreach ($expertise_level as $exp_arr) {
				$sql = "+ 1";
				if ($exp_arr == 'E') {
					$cour_id = 1;
				} elseif ($exp_arr == 'C') {
					$cour_id = 3;
				} elseif ($exp_arr == 'A') {
					$cour_id = 5;
				} elseif ($exp_arr == 'M') {
					$cour_id = 5;
				}
				$this->ss_aw_course_count_model->update_record_by_query($sql, $cour_id);
			}


			$this->ss_aw_sections_topics_model->add_data($insert_data);

			$this->session->set_flashdata('success', 'New Topic added succesfully.');
		}

		if (isset($postdata['section_name'])) {
			$search_data['ss_aw_section_title'] = strtolower($postdata['section_name']);
		}
		if (!empty($postdata['ss_aw_section_status']) && $postdata['ss_aw_section_status'] != '') {
			if ($postdata['ss_aw_section_status'] == 2) {
				$search_data['ss_aw_section_status'] = 0;
			} else {
				$search_data['ss_aw_section_status'] = $postdata['ss_aw_section_status'];
			}
		}
		if (isset($postdata['search_level'])) {
			if ($postdata['search_level'] != "Select Levels") {
				$search_data['ss_aw_expertise_level'] = $postdata['search_level'];
				$this->session->set_flashdata('ss_aw_expertise_level', $search_data['ss_aw_expertise_level']);
			} else {
				$search_data['ss_aw_expertise_level'] = '';
				$this->session->set_flashdata('ss_aw_expertise_level', $search_data['ss_aw_expertise_level']);
			}
		}

		if ($this->session->flashdata('ss_aw_expertise_level') != "") {
			if ($this->session->flashdata('ss_aw_expertise_level') != "Select Levels") {
				$search_data['ss_aw_expertise_level'] = $this->session->flashdata('ss_aw_expertise_level');
				$this->session->set_flashdata('ss_aw_expertise_level', $search_data['ss_aw_expertise_level']);
			} else {
				$this->session->set_flashdata('ss_aw_expertise_level', '');
				$search_data['ss_aw_expertise_level'] = '';
			}
		}


		if (isset($postdata['topic_status_change'])) {
			$topic_id = $postdata['status_topic_id'];
			$update_data['ss_aw_section_status'] = $postdata['status_topic_status'];
			$this->ss_aw_sections_topics_model->update_topic_data($topic_id, $update_data);
			//GET previous topic data//
			$prev_data = $this->ss_aw_sections_topics_model->getrecordbyid($topic_id);
			$prev_data_arr = explode(",", $prev_data[0]->ss_aw_expertise_level);
			if ($postdata['status_topic_status'] == 0) {
				foreach ($prev_data_arr as $prv_arr) {
					$sql = " - 1";
					if ($prv_arr == 'E') {
						$cour_id = 1;
					} elseif ($prv_arr == 'C') {
						$cour_id = 3;
					} elseif ($prv_arr == 'A') {
						$cour_id = 5;
					} elseif ($prv_arr == 'M') {
						$cour_id = 5;
					}
					$this->ss_aw_course_count_model->update_record_by_query($sql, $cour_id);
				}
			} else {
				foreach ($prev_data_arr as $prv_arr) {
					$sql = " + 1";
					if ($prv_arr == 'E') {
						$cour_id = 1;
					} elseif ($prv_arr == 'C') {
						$cour_id = 3;
					} elseif ($prv_arr == 'A') {
						$cour_id = 5;
					} elseif ($prv_arr == 'M') {
						$cour_id = 5;
					}
					$this->ss_aw_course_count_model->update_record_by_query($sql, $cour_id);
				}
			}
		}
		if (isset($postdata['edit_new_topic'])) {

			$topic_id = $postdata['edit_topic_id'];
			$update_data['ss_aw_section_title'] = $postdata['edit_topic_name'];
			$update_data['ss_aw_topic_description'] = $postdata['edit_topic_desc'];
			$edit_level = $postdata['edit_topic_level'];
			$edit_level = rtrim($edit_level, ',');
			$update_data['ss_aw_expertise_level'] = strtoupper($edit_level);
			//GET previous topic data//
			$prev_data = $this->ss_aw_sections_topics_model->getrecordbyid($topic_id);
			//update course count data//			
			$prev_data_arr = explode(",", $prev_data[0]->ss_aw_expertise_level);
			$expertise_level = explode(",", strtoupper($edit_level));
			foreach ($prev_data_arr as $prv_arr) {
				if (!in_array($prv_arr, $expertise_level)) {
					$sql = " - 1";
					if ($prv_arr == 'E') {
						$cour_id = 1;
					} elseif ($prv_arr == 'C') {
						$cour_id = 3;
					} elseif ($prv_arr == 'A') {
						$cour_id = 5;
					} elseif ($prv_arr == 'M') {
						$cour_id = 5;
					}
					$this->ss_aw_course_count_model->update_record_by_query($sql, $cour_id);
				}
			}
			foreach ($expertise_level as $exp_arr) {
				if (!in_array($exp_arr, $prev_data_arr)) {
					$sql = "+ 1";
					if ($exp_arr == 'E') {
						$cour_id = 1;
					} elseif ($exp_arr == 'C') {
						$cour_id = 3;
					} elseif ($exp_arr == 'A') {
						$cour_id = 5;
					} elseif ($exp_arr == 'M') {
						$cour_id = 5;
					}
					$this->ss_aw_course_count_model->update_record_by_query($sql, $cour_id);
				}
			}


			$this->ss_aw_sections_topics_model->update_topic_data($topic_id, $update_data);
			$lesson_update = array();
			$lesson_update['ss_aw_lesson_topic'] = $postdata['edit_topic_name'];
			if (!empty(strtoupper($edit_level))) {
				$topicLevels = explode(",", strtoupper($edit_level));
				if (!empty($topicLevels)) {
					$lesson_course_id = "";
					foreach ($topicLevels as $i => $topic_level) {
						if ($i > 0) {
							$lesson_course_id .= ",";
						}
						if ($topic_level == 'E') {
							$lesson_course_id .= 1;
						} elseif ($topic_level == 'C') {
							$lesson_course_id .= 2;
						} elseif ($topic_level == 'A') {
							$lesson_course_id .= 3;
						} else {
							$lesson_course_id .= 4;
						}
					}
					$lesson_update['ss_aw_course_id'] = $lesson_course_id;
				}
			}



			$this->ss_aw_lessons_uploaded_model->update_by_topic_id($topic_id, $lesson_update);

			$assessment_update = array();
			$assessment_update['ss_aw_assesment_topic'] = $postdata['edit_topic_name'];
			$assessment_update['ss_aw_course_id'] = strtoupper($edit_level);
			$this->ss_aw_assesment_uploaded_model->update_by_topic_id($topic_id, $assessment_update);
			$this->session->set_flashdata('success', 'Topic updated succesfully.');
		}
		$subtopicary = array();

		$queryary = $this->ss_aw_sections_subtopics_model->fetchall();

		foreach ($queryary as $value) {
			$subtopicary[$value['ss_aw_topic_id']][] = $value['ss_aw_section_title'];
		}

		$headerdata['title'] = "Topics";



		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/topics';

		$config["total_rows"] = $this->ss_aw_sections_topics_model->number_of_records($search_data);

		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item page-link">';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '<span aria-hidden="true">&lt;</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '<span aria-hidden="true">&gt;</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li class="page-item page-link">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item page-link">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item page-link">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		$topic_arr = $this->ss_aw_sections_topics_model->get_all_records($config['per_page'], $page, $search_data);

		if (!empty($postdata['ss_aw_section_status'])) {
			if ($postdata['ss_aw_section_status'] == 2) {
				$search_data['ss_aw_section_status'] = 2;
			}
		}

		$data['page'] = $page;
		$data['result'] = $topic_arr;
		$data['subtopic_result'] = $subtopicary;
		$data['search_data'] = $search_data;

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/topics', $data);
	}

	public function subtopics()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();

		if (!empty($postdata['subtopic_status_id'])) {
			$topic_id = $postdata['topic_id'];
			$subtopic_status_id = $postdata['subtopic_status_id'];
			$subtopic_status = $postdata['subtopic_status'];
			$dataary = array();
			$dataary['ss_aw_subtopic_id'] = $subtopic_status_id;
			$dataary['ss_aw_section_status'] = $subtopic_status;

			$this->ss_aw_sections_subtopics_model->update_record($dataary);
			$this->session->set_flashdata('success', 'Topic status succesfully change.');
			redirect('admin/subtopics/' . $topic_id, 'refresh');
		} else if (!empty($postdata['subtopic_delete_id'])) {
			$topic_delete_id = $postdata['subtopic_delete_id'];

			$topic_id = $postdata['topic_id'];
			$dataary = array();
			$dataary['ss_aw_subtopic_id'] = $topic_delete_id;
			$dataary['ss_aw_subtopic_deleted'] = 0;
			$this->ss_aw_sections_subtopics_model->update_record($dataary);

			$this->session->set_flashdata('success', 'Subtopic deleted succesfully.');
			redirect('admin/subtopics/' . $topic_id, 'refresh');
		} else if (!empty($postdata['add_subtopic'])) {
			$topic_id = $postdata['topic_id'];
			$subtopic_name = $postdata['subtopic_name'];
			$dataary = array();
			$dataary['ss_aw_topic_id'] = $topic_id;
			$dataary['ss_aw_section_title'] = $subtopic_name;
			$this->ss_aw_sections_subtopics_model->insert_data($dataary);
			$this->session->set_flashdata('success', 'Subtopic added succesfully.');
			redirect('admin/subtopics/' . $topic_id, 'refresh');
		} else if (!empty($postdata['get_subtopic'])) {
			$id = $postdata['id'];
			$dataary = array();
			$dataary['ss_aw_subtopic_id'] = $id;
			$resultary = $this->ss_aw_sections_subtopics_model->get_details_byparam($dataary);
			echo json_encode($resultary[0]);
			die();
		} else if (!empty($postdata['edit_subtopic'])) {
			$topic_id = $postdata['topic_id'];
			$subtopic_id = $postdata['edit_subtopic'];
			$subtopic_name = $postdata['subtopic_name'];
			$dataary = array();
			$dataary['ss_aw_subtopic_id'] = $subtopic_id;
			$dataary['ss_aw_section_title'] = $subtopic_name;
			$this->ss_aw_sections_subtopics_model->update_record($dataary);

			$this->session->set_flashdata('success', 'Subtopic updated succesfully.');
			redirect('admin/subtopics/' . $topic_id, 'refresh');
		}

		$headerdata['title'] = "Sub-Topics";
		$search_data = array();
		$search_data['ss_aw_topic_id'] = $this->uri->segment(3);
		if (!empty($postdata['searchdata'])) {
			$search_data['ss_aw_section_title'] = strtolower($postdata['searchdata']);
			$search_data['ss_aw_topic_id'] = $postdata['ss_aw_topic_id'];
		}
		if (!empty($postdata['ss_aw_section_status'])) {
			if ($postdata['ss_aw_section_status'] == 2) {
				$search_data['ss_aw_section_status'] = 0;
			} else {
				$search_data['ss_aw_section_status'] = $postdata['ss_aw_section_status'];
			}
			$search_data['ss_aw_topic_id'] = $postdata['ss_aw_topic_id'];
		}
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/subtopics/' . $search_data['ss_aw_topic_id'];
		$config["total_rows"] = $this->ss_aw_sections_subtopics_model->number_of_records($search_data);
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item page-link">';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '<span aria-hidden="true">&lt;</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '<span aria-hidden="true">&gt;</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li class="page-item page-link">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item page-link">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item page-link">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		$topic_arr = $this->ss_aw_sections_subtopics_model->get_records_by_topic_id($config['per_page'], $page, $search_data);
		if (!empty($postdata['ss_aw_section_status'])) {
			if ($postdata['ss_aw_section_status'] == 2) {
				$search_data['ss_aw_section_status'] = 2;
			}
		}
		$data['page'] = $page;
		$data['result'] = $topic_arr;
		$data['topic_id'] = $search_data['ss_aw_topic_id'];
		$data['search_data'] = $search_data;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/subtopics', $data);
	}

	function multipledeletesubtopic()
	{
		$postdata = $this->input->post();
		$topic_id = $postdata['ss_aw_topic_id'];
		if (!empty($postdata['selecteddata'])) {
			$dataary = $postdata['selecteddata'];

			foreach ($dataary as $value) {
				$deleteary = array();
				$deleteary['ss_aw_subtopic_id'] = $value;
				$deleteary['ss_aw_subtopic_deleted'] = 0;
				$this->ss_aw_sections_subtopics_model->update_record($deleteary);
			}
			$this->session->set_flashdata('success', 'All selected sub topic deleted from system.');
			redirect('admin/subtopics/' . $topic_id, 'refresh');
		}
	}

	function multipledeletetopic()
	{
		$postdata = $this->input->post();
		if (!empty($postdata['selecteddata'])) {
			$dataary = $postdata['selecteddata'];

			foreach ($dataary as $value) {
				$deleteary = array();
				$deleteary['ss_aw_section_id'] = $value;
				$deleteary['ss_aw_topic_deleted'] = 0;
				$this->ss_aw_sections_topics_model->update_record($deleteary);
			}
			$this->session->set_flashdata('success', 'All selected sub topic deleted from system.');
			redirect('admin/topics', 'refresh');
		}
	}

	/******************************************** SETTINGS PAGE ******************************************************/
	public function settesttimings()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "settesttimings";
		$data = adminmenusection();
		$record_id_arr = array("2", "3");

		$result = array();

		$postdata = $this->input->post();
		if (isset($postdata['update_records'])) {
			$txtDiagonsticTestTiming_id = '2';
			$txtDiagonsticTestTiming = ($postdata['txtDiagonsticTestTiming'] * 60);

			$txtAssessmentTestTiming_id = '3';
			$txtAssessmentTestTiming = ($postdata['txtAssessmentTestTiming'] * 60);

			$this->ss_aw_test_timing_model->update_records($txtDiagonsticTestTiming_id, $txtDiagonsticTestTiming);
			$this->ss_aw_test_timing_model->update_records($txtAssessmentTestTiming_id, $txtAssessmentTestTiming);
			//generale settings timing update code
			$update_array['ss_aw_time_skip'] = $postdata['txtQuizIdleTime'];
			$update_array['ss_aw_pause_time'] = $postdata['txtPauseWrongTime'];
			$this->ss_aw_general_settings_model->update_data($postdata['record_id'], $update_array);
			//end
			$this->session->set_flashdata('success', 'Setting timing data updated succesfully.');
		}



		foreach ($record_id_arr as $value) {
			$record_data = $this->ss_aw_test_timing_model->fetch_record_byid($value);
			$result = array_merge($result, $record_data);
		}

		$data['result'] = $result;
		$generale_time_setting =  $this->ss_aw_general_settings_model->fetch_record();
		$data['generale_time_setting'] = $generale_time_setting;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/settesttimings', $data);
	}
	function createaudio_fromtext($title_str, $audio_file)
	{

		// Your API Key here
		$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=" . GOOGLE_KEY;
		$textary = array();
		$textary['input']['text'] = $title_str;
		$textary['voice']['languageCode'] = 'en-gb';
		$textary['voice']['name'] = 'En-GBR-Wavelength - D- Smartphone';
		$textary['audioConfig']['audioEncoding'] = 'MP3';
		$textary['audioConfig']['pitch'] = '-4.00';
		$textary['audioConfig']['speakingRate'] = '0.85';

		$audio_data = json_encode($textary);
		$ch = curl_init($url);

		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);
		$info = curl_getinfo($ch);

		$final_output = json_decode($output, true);
		$final_output = base64_decode($final_output['audioContent']);

		file_put_contents($audio_file, $final_output);


		return	$final_output;
	}
	function newcreateaudio_fromtext($title_str, $audio_file, $config_voice_array = array())
	{

		// Your API Key here
		$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=" . GOOGLE_KEY;
		$textary = array();
		$textary['input']['text'] = $title_str;
		$textary['voice']['languageCode'] = $config_voice_array['ss_aw_language_code'];
		$textary['voice']['name'] = $config_voice_array['ss_aw_voice_type'];
		$textary['audioConfig']['audioEncoding'] = 'MP3';
		$textary['audioConfig']['pitch'] = $config_voice_array['ss_aw_c_pitch'];
		$textary['audioConfig']['speakingRate'] = $config_voice_array['ss_aw_c_speed'];

		$audio_data = json_encode($textary);
		$ch = curl_init($url);

		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);
		$info = curl_getinfo($ch);

		$final_output = json_decode($output, true);
		$final_output = base64_decode($final_output['audioContent']);

		file_put_contents($audio_file, $final_output);


		return	$final_output;
	}

	function democreateaudio_fromtext($title_str, $audio_file, $config_voice_array = array())
	{

		// Your API Key here
		$url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=" . GOOGLE_KEY;
		$textary = array();
		$textary['input']['text'] = $title_str;
		$textary['voice']['languageCode'] = $config_voice_array['ss_aw_language_code'];
		$textary['voice']['name'] = $config_voice_array['ss_aw_voice_type'];
		$textary['audioConfig']['audioEncoding'] = 'MP3';
		$textary['audioConfig']['pitch'] = doubleval($config_voice_array['ss_aw_c_pitch']);
		$textary['audioConfig']['speakingRate'] = doubleval($config_voice_array['ss_aw_c_speed']);

		$audio_data = json_encode($textary);
		$ch = curl_init($url);

		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);

		$info = curl_getinfo($ch);

		$final_output = json_decode($output, true);

		$final_output = base64_decode($final_output['audioContent']);

		file_put_contents($audio_file, $final_output);

		return	$final_output;
	}
	public function generalsettings()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "generalsettings";
		$data = adminmenusection();
		$postdata = $this->input->post();
		$update_array = array();

		if (isset($postdata['update_general_settings'])) {
			$id = $postdata['record_id'];


			$update_array['ss_aw_lesson_assessment_time_difference'] = $postdata['ss_aw_lesson_assessment_time_difference'];
			$update_array['ss_aw_lesson_time_gap'] = $postdata['ss_aw_lesson_time_gap'];
			$update_array['ss_aw_next_course_start_time'] = $postdata['ss_aw_next_course_start_time'];
			$update_array['ss_aw_supplementary_content_access_duration'] = $postdata['ss_aw_supplementary_content_access_duration'];

			$this->ss_aw_general_settings_model->update_data($id, $update_array);
			$this->ss_aw_readalong_restriction_model->update_restrict_time($postdata['ss_aw_lesson_time_gap']);
			$this->session->set_flashdata('success', 'General settings data updated succesfully.');
		}

		$result =  $this->ss_aw_general_settings_model->fetch_record();

		$data['result'] = $result;

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/generalsettings', $data);
	}
	public function audiosettings()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "audiosettings";
		$data = adminmenusection();
		$postdata = $this->input->post();
		$update_array = array();

		if (isset($postdata['update_general_settings'])) {
			//update upload data of correct anser and wright answer audio
			if ($_FILES["fileCorrectAnswerAudio"]['name'] != "") {
				$config['upload_path']          = './assets/audio/';
				$config['allowed_types']        = 'mp3';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('fileCorrectAnswerAudio')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
				$data = $this->upload->data();
				$correct_audio = $data['file_name'];
				$update_array['ss_aw_correct_audio'] = $correct_audio;
			}
			if ($_FILES["fileIncorrectAnswerAudio"]['name'] != "") {
				$config['upload_path']          = './assets/audio/';
				$config['allowed_types']        = 'mp3';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('fileIncorrectAnswerAudio')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
				$data = $this->upload->data();
				$incorrect_audio = $data['file_name'];
				$update_array['ss_aw_incorrect_audio'] = $incorrect_audio;
			}
			if ($_FILES["fileCompleteAnswerAudio"]['name'] != "") {
				$config['upload_path']          = './assets/audio/';
				$config['allowed_types']        = 'mp3';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('fileCompleteAnswerAudio')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
				$data = $this->upload->data();
				$complete_audio = $data['file_name'];
				$update_array['ss_aw_complete_assessment_audio'] = $complete_audio;
			}
			//end
			$id = $postdata['record_id'];
			$update_array['ss_aw_audio_text'] = $postdata['txtSkipAudioText'];
			$update_array['ss_aw_warning_text'] = $postdata['txtWarningAudioText'];

			$update_array['ss_aw_lesson_quiz_text '] = $postdata['txtLessonquizAudioText'];
			$update_array['ss_aw_correct_answer_text '] = $postdata['correctanswerAudioText'];
			$update_array['ss_aw_bad_audio_text'] = $postdata['txtBadAudioText'];
			$update_array['ss_aw_welcome_assesment_text'] = $postdata['txtWelcomeAssesmentAudioText'];
			$update_array['ss_aw_topical_lesson_correct_txt'] = $postdata['txtCorrectTopicalLessonAudioTxt'];
			$update_array['ss_aw_topical_lesson_incorrect_txt'] = $postdata['txtIncorrectTopicalLessonAudioTxt'];
			$update_array['ss_aw_topical_lesson_incorrect2_txt'] = $postdata['txtIncorrect2TopicalLessonAudioTxt'];

			$update_array['ss_aw_topical_assessment_correct_txt'] = $postdata['txtCorrectTopicalAssessmentAudioTxt'];
			$update_array['ss_aw_topical_assessment_incorrect_txt'] = $postdata['txtIncorrectTopicalAssessmentAudioTxt'];
			$update_array['ss_aw_topical_assessment_incorrect2_txt'] = $postdata['txtIncorrect2TopicalAssessmentAudioTxt'];

			$update_array['ss_aw_general_language_correct_txt'] = $postdata['txtCorrectGeneralLanguageAudioTxt'];
			$update_array['ss_aw_general_language_incorrect_txt'] = $postdata['txtIncorrectGeneralLanguageAudioTxt'];
			$update_array['ss_aw_general_language_incorrect2_txt'] = $postdata['txtIncorrect2GeneralLanguageAudioTxt'];
			//$update_array['ss_aw_mobile_count'] = $postdata['txtMobileValidationCount'];
			$global_audio_voice_id = $postdata['global_audio_voice'];
			$update_array['ss_aw_golabal_voice'] = $global_audio_voice_id;

			//$voice_matrix_array =  $this->ss_aw_voice_type_matrix_model->get_recordby_id($global_audio_voice_id);

			$config_voice_array = array();
			$audio_matrix_ary = array();
			$voice_type = array();
			$audio_matrix_ary = $this->ss_aw_voice_type_matrix_model->search_byparam();
			$i = 1;
			$k = 0;
			foreach ($audio_matrix_ary as $key => $value) {

				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_e_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_e_speed'];

				$k = $k + 1;
				$i = $i + 1;
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_c_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_c_speed'];

				$k = $k + 1;
				$i = $i + 1;
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_a_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_a_speed'];

				$i++;
				$k++;
			}

			foreach ($voice_type as $vvalue) {

				if ($vvalue['ss_aw_id'] == $global_audio_voice_id) {
					$config_voice_array['ss_aw_voice_type'] = $vvalue['ss_aw_voice_type'];
					$config_voice_array['ss_aw_language_code'] = $vvalue['ss_aw_language_code'];
					$config_voice_array['ss_aw_c_speed'] = $vvalue['ss_aw_speed'];
					$config_voice_array['ss_aw_c_pitch'] = $vvalue['ss_aw_pitch'];
				}
			}

			if (!empty($postdata['skip_audio']))
				unlink('assets/audio/' . $postdata['skip_audio']);
			if (!empty($postdata['warning_audio']))
				unlink('assets/audio/' . $postdata['warning_audio']);

			$skip_audiofile = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $skip_audiofile;
			$this->newcreateaudio_fromtext($postdata['txtSkipAudioText'], $audio_file, $config_voice_array);

			$update_array['ss_aw_skip_audio'] = $skip_audiofile;

			$warning_audiofile = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $warning_audiofile;
			$this->newcreateaudio_fromtext($postdata['txtWarningAudioText'], $audio_file, $config_voice_array);

			$update_array['ss_aw_warning_audio'] = $warning_audiofile;


			$lesson_quiz_audiofile = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $lesson_quiz_audiofile;
			$this->newcreateaudio_fromtext($postdata['txtLessonquizAudioText'], $audio_file, $config_voice_array);

			$update_array['ss_aw_lesson_quiz_audio'] = $lesson_quiz_audiofile;

			$correctanswer_audiofile = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $correctanswer_audiofile;
			$this->newcreateaudio_fromtext($postdata['correctanswerAudioText'], $audio_file, $config_voice_array);

			$update_array['ss_aw_correct_answer_audio'] = $correctanswer_audiofile;

			$bad_audiofile = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $bad_audiofile;
			$this->newcreateaudio_fromtext($postdata['txtBadAudioText'], $audio_file, $config_voice_array);

			$update_array['ss_aw_bad_audio'] = $bad_audiofile;

			$welcome_assesment_audiofile = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $welcome_assesment_audiofile;
			$this->newcreateaudio_fromtext($postdata['txtWelcomeAssesmentAudioText'], $audio_file, $config_voice_array);

			$update_array['ss_aw_welcome_assesment_audio'] = $welcome_assesment_audiofile;

			$topical_lesson_correct_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $topical_lesson_correct_audion;
			$this->newcreateaudio_fromtext($postdata['txtCorrectTopicalLessonAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_topical_lesson_correct'] = $topical_lesson_correct_audion;

			$topical_lesson_incorrect_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $topical_lesson_incorrect_audion;
			$this->newcreateaudio_fromtext($postdata['txtIncorrectTopicalLessonAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_topical_lesson_incorrect'] = $topical_lesson_incorrect_audion;

			$topical_lesson_incorrect2_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $topical_lesson_incorrect2_audion;
			$this->newcreateaudio_fromtext($postdata['txtIncorrect2TopicalLessonAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_topical_lesson_incorrect2'] = $topical_lesson_incorrect2_audion;

			$topical_assessment_correct_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $topical_assessment_correct_audion;
			$this->newcreateaudio_fromtext($postdata['txtCorrectTopicalAssessmentAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_topical_assessment_correct'] = $topical_assessment_correct_audion;

			$topical_assessment_incorrect_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $topical_assessment_incorrect_audion;
			$this->newcreateaudio_fromtext($postdata['txtIncorrectTopicalAssessmentAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_topical_assessment_incorrect'] = $topical_assessment_incorrect_audion;

			$topical_assessment_incorrect2_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $topical_assessment_incorrect2_audion;
			$this->newcreateaudio_fromtext($postdata['txtIncorrect2TopicalAssessmentAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_topical_assessment_incorrect2'] = $topical_assessment_incorrect2_audion;

			$general_language_correct_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $general_language_correct_audion;
			$this->newcreateaudio_fromtext($postdata['txtCorrectGeneralLanguageAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_general_language_correct'] = $general_language_correct_audion;

			$general_language_incorrect_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $general_language_incorrect_audion;
			$this->newcreateaudio_fromtext($postdata['txtIncorrectGeneralLanguageAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_general_language_incorrect'] = $general_language_incorrect_audion;

			$general_language_incorrect2_audion = time() . "_" . rand() . ".mp3";
			$audio_file = "assets/audio/" . $general_language_incorrect2_audion;
			$this->newcreateaudio_fromtext($postdata['txtIncorrect2GeneralLanguageAudioTxt'], $audio_file, $config_voice_array);

			$update_array['ss_aw_general_language_incorrect2'] = $general_language_incorrect2_audion;


			$this->ss_aw_general_settings_model->update_data($id, $update_array);

			//update audio pitch speed
			$audio_id = $postdata['text_generate_audio_voice'];
			if (!empty($audio_id)) {
				$audio_data = array(
					'ss_aw_e_pitch' => $postdata['e_pitch'],
					'ss_aw_e_speed' => $postdata['e_speed'],
					'ss_aw_c_pitch' => $postdata['c_pitch'],
					'ss_aw_c_speed' => $postdata['c_speed'],
					'ss_aw_a_pitch' => $postdata['a_pitch'],
					'ss_aw_a_speed' => $postdata['a_speed']
				);
				$this->ss_aw_voice_type_matrix_model->update_data($audio_id, $audio_data);
			}
			//end
			$this->session->set_flashdata('success', 'Audio settings data updated succesfully.');
		}

		$audio_pitch_speed = array();
		$result =  $this->ss_aw_general_settings_model->fetch_record();
		if (!empty($result[0]->ss_aw_golabal_voice)) {
			$global_audio_id = $result[0]->ss_aw_golabal_voice;
			$audio_pitch_speed = $this->ss_aw_voice_type_matrix_model->get_recordby_id($global_audio_id);
		}
		$data['audio_pitch_speed'] = $audio_pitch_speed;
		$data['result'] = $result;
		$audio_matrix_ary = array();
		$voice_type = array();
		$audio_matrix_ary = $this->ss_aw_voice_type_matrix_model->search_byparam();
		$i = 1;
		$k = 0;
		foreach ($audio_matrix_ary as $key => $value) {
			//foreach($value as $value2)
			{
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_e_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_e_speed'];

				$k = $k + 1;
				$i = $i + 1;
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_c_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_c_speed'];

				$k = $k + 1;
				$i = $i + 1;
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_a_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_a_speed'];
				$i++;
				$k++;
			}
		}

		$data['audio_voice_type'] = $voice_type;
		$data['audio_voices'] = $audio_matrix_ary;
		//echo "<pre>";
		//print_r($data['audio_voice_type']);
		//exit();	
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/audiosettings', $data);
	}
	public function demo_audio_play()
	{
		$postdata = $this->input->post();
		if (!empty($postdata)) {
			$delete_file = 'demo_audio/demo.mp3';
			if (file_exists($delete_file)) {
				unlink($delete_file);
			}

			$bad_audiofile = "demo" . ".mp3";
			$audio_file = "demo_audio/" . $bad_audiofile;

			$demo_audio_voice_id = $postdata['demo_audio_voice'];

			$config_voice_array = array();
			$audio_matrix_ary = array();
			$voice_type = array();
			$audio_matrix_ary = $this->ss_aw_voice_type_matrix_model->search_byparam();
			$i = 1;
			$k = 0;
			foreach ($audio_matrix_ary as $key => $value) {

				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_e_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_e_speed'];

				$k = $k + 1;
				$i = $i + 1;
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_c_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_c_speed'];

				$k = $k + 1;
				$i = $i + 1;
				$voice_type[$k]['ss_aw_id'] = $i;
				$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
				$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
				$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
				$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_a_pitch'];
				$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_a_speed'];

				$i++;
				$k++;
			}

			foreach ($voice_type as $vvalue) {
				if ($vvalue['ss_aw_id'] == $demo_audio_voice_id) {
					$config_voice_array['ss_aw_voice_type'] = $vvalue['ss_aw_voice_type'];
					$config_voice_array['ss_aw_language_code'] = $vvalue['ss_aw_language_code'];
					$config_voice_array['ss_aw_c_speed'] = $vvalue['ss_aw_speed'];
					$config_voice_array['ss_aw_c_pitch'] = $vvalue['ss_aw_pitch'];
				}
			}


			$this->democreateaudio_fromtext($postdata['demoAudioText'], $audio_file, $config_voice_array);
			$num = rand();

			echo base_url() . '/demo_audio/demo.mp3?a=' . $num;
		}
	}

	public function audiotest()
	{

		$bad_audiofile = "demo" . ".mp3";
		$audio_file = "demo_audio/" . $bad_audiofile;

		$demo_audio_voice_id = 1;

		$config_voice_array = array();
		$audio_matrix_ary = array();
		$voice_type = array();
		$audio_matrix_ary = $this->ss_aw_voice_type_matrix_model->search_byparam();
		$i = 1;
		$k = 0;
		foreach ($audio_matrix_ary as $key => $value) {

			$voice_type[$k]['ss_aw_id'] = $i;
			$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
			$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
			$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
			$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_e_pitch'];
			$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_e_speed'];

			$k = $k + 1;
			$i = $i + 1;
			$voice_type[$k]['ss_aw_id'] = $i;
			$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
			$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
			$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
			$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_c_pitch'];
			$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_c_speed'];

			$k = $k + 1;
			$i = $i + 1;
			$voice_type[$k]['ss_aw_id'] = $i;
			$voice_type[$k]['ss_aw_category'] = $value['ss_aw_category'];
			$voice_type[$k]['ss_aw_voice_type'] = $value['ss_aw_voice_type'];
			$voice_type[$k]['ss_aw_language_code'] = $value['ss_aw_language_code'];
			$voice_type[$k]['ss_aw_pitch'] = $value['ss_aw_a_pitch'];
			$voice_type[$k]['ss_aw_speed'] = $value['ss_aw_a_speed'];

			$i++;
			$k++;
		}

		foreach ($voice_type as $vvalue) {
			if ($vvalue['ss_aw_id'] == $demo_audio_voice_id) {
				$config_voice_array['ss_aw_voice_type'] = $vvalue['ss_aw_voice_type'];
				$config_voice_array['ss_aw_language_code'] = $vvalue['ss_aw_language_code'];
				$config_voice_array['ss_aw_c_speed'] = $vvalue['ss_aw_speed'];
				$config_voice_array['ss_aw_c_pitch'] = $vvalue['ss_aw_pitch'];
			}
		}
		$response = $this->democreateaudio_fromtext("Demo Test Audio.", $audio_file, $config_voice_array);
		print_r($response);
		echo "@1";
		die();
	}


	public function imagegallery()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "imagegallery";
		$data = adminmenusection();
		$postdata = $this->input->post();

		if (!empty($postdata['delete_pic_id'])) {
			$id = $postdata['delete_pic_id'];
			$this->ss_aw_imagegallery_model->delete_record($id);
			$this->session->set_flashdata('success', 'Picture deleted succesfully');
			$unlink_img = 'uploads/image_galary/' . $postdata['delete_image'];

			unlink($unlink_img);
		}


		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'admin/imagegallery';

		$config["total_rows"] = $this->ss_aw_imagegallery_model->number_of_records();;

		$config["per_page"] = 3;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page-item page-link">';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '<span aria-hidden="true">&lt;</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '<span aria-hidden="true">&gt;</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li class="page-item page-link">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item page-link">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item page-link">';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);

		$data['page'] = $page;
		$data['result'] = $this->ss_aw_imagegallery_model->fetch_all_record($config['per_page'], $page);



		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/imagegallery', $data);
	}
	public function imagegallery_upload()
	{
		$insert_array = array();

		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$ran = time();
			$targetPath = "./uploads/image_galary/";
			// $fileName =  $ran.$_FILES['file']['name'];
			$length = 10;
			$characters = time() . '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}


			$fileName = $randomString . rand(1, 99999) . '.' . end(explode(".", $_FILES["file"]["name"]));
			$targetFile = $targetPath . $fileName;


			$insert_array['ss_aw_image'] = $fileName;
			$image_size =  getimagesize($tempFile);

			$insert_array['ss_aw_image_resolution'] = $image_size[0] . "w X " . $image_size[1] . "h";
			$img_name = $_FILES['file']['name'];
			$ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
			$allowfiletype = array('jpeg', 'png', 'jpg');
			if (in_array($ext, $allowfiletype)) {
				$img_name = substr($img_name, 0, strpos($img_name, "."));
				$insert_array['ss_aw_image_name'] = $img_name;

				$this->ss_aw_imagegallery_model->insert_record($insert_array);
				move_uploaded_file($tempFile, $targetFile);

				echo $response = 1;
			} else {
				echo $response = 2;
			}
			die();
		}
	}

	public function vocabulary()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Vocabulary";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$check_old = $this->ss_aw_vocabulary_model->check_data(strtolower($postdata['word']));
			if (!empty($check_old)) {
				$data = array(
					'id' => $check_old[0]->id,
					'word' => strtolower($postdata['word']),
					'meaning' => $postdata['meaning'],
					'updated_at' => date('Y-m-d H:i:s')
				);
				$response = $this->ss_aw_vocabulary_model->update_data($data);
			} else {
				$data = array(
					'word' => strtolower($postdata['word']),
					'meaning' => $postdata['meaning'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$response = $this->ss_aw_vocabulary_model->store_data($data);
			}

			if ($response) {
				$this->session->set_flashdata('success', 'Record added succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/vocabulary');
		} else {
			$search_data = array();
			$searched_word = "";
			if ($this->session->flashdata('searched_word')) {
				$searched_word = $this->session->flashdata('searched_word');
			}
			$search_data['searched_word'] = $searched_word;
			$data['search_data'] = $search_data;
			$total_record = $this->ss_aw_vocabulary_model->total_record($searched_word);
			$redirect_to = base_url() . 'admin/vocabulary';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;', $str_links);
			if ($page >= $config["total_rows"]) {
				$page = 0;
			}
			$result = $this->ss_aw_vocabulary_model->getlimitedrecord($searched_word, $config['per_page'], $page);
			$data['result'] = $result;
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/vocabulary', $data);
		}
	}

	public function multiplevocabularyimport()
	{ {

			//$postdata = $this->input->post();
			if (isset($_FILES["file"]['name'])) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types']        = 'xls|xlsx';
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('file')) {
					//echo "not success";
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
					$this->session->set_flashdata('error', 'Uploaded file format mismatch.');
					redirect('admin/vocabulary');
				}

				$data = $this->upload->data();
				$lesson_file = $data['file_name'];
			}

			$file = './uploads/' . $lesson_file;

			//load the excel library
			$this->load->library('excel');

			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);

			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();


			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				$column = @$objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = @$objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if (empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue())) {

					if ($cell[0] == 'A') {
						$data_value = trim($avalue);
					}
					if ($cell[0] == 'B') {
						$data_value = trim($bvalue);
					}
				} else {
					if ($cell[0] == 'A') {
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					} else if ($cell[0] == 'B') {
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = trim($data_value);
				} else {
					$arr_data[$row][$column] = trim($data_value);
				}
			}

			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;

			if (!empty($data['values'])) {
				foreach ($data['values'] as $key => $value) {
					$check_old = $this->ss_aw_vocabulary_model->check_data(strtolower($value['A']));
					if (!empty($check_old)) {
						$data = array(
							'id' => $check_old[0]->id,
							'word' => strtolower($value['A']),
							'meaning' => $value['B'],
							'updated_at' => date('Y-m-d H:i:s')
						);
						$this->ss_aw_vocabulary_model->update_data($data);
					} else {
						$data = array(
							'word' => strtolower($value['A']),
							'meaning' => $value['B'],
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->ss_aw_vocabulary_model->store_data($data);
					}
				}
			}

			$this->session->set_flashdata('success', 'Vocabulary imported Successfully.');

			redirect('admin/vocabulary');
		}
	}
	public function search_vocabulary()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if (!empty($postdata['search_word'])) {
				$this->session->set_flashdata('searched_word', $postdata['search_word']);
			}
		}

		redirect('admin/vocabulary');
	}
	public function update_vocabulary()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$check_update_data = $this->ss_aw_vocabulary_model->check_except_id(strtolower($postdata['edit_word']), $postdata['edit_word_id']);
			if (empty($check_update_data)) {
				$data = array(
					'id' => $postdata['edit_word_id'],
					'word' => strtolower($postdata['edit_word']),
					'meaning' => $postdata['edit_meaning'],
					'updated_at' => date('Y-m-d H:i:s')
				);

				$response = $this->ss_aw_vocabulary_model->update_data($data);
				if ($response) {
					$this->session->set_flashdata('success', 'Record updated succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please tryr again later.');
				}
			} else {
				$this->session->set_flashdata('error', 'The given word is already exist.');
			}
		}

		redirect('admin/vocabulary');
	}

	public function delete_vocabulary()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$data = array(
				'id' => $postdata['vocabulary_delete_id'],
				'is_delete' => 1,
			);

			$response = $this->ss_aw_vocabulary_model->update_data($data);
			if ($response) {
				$this->session->set_flashdata('success', 'Record removed succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please tryr again later.');
			}
		}

		redirect('admin/vocabulary');
	}

	public function multipledeletevocabulary()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if (isset($postdata['selecteddata'])) {
				$delete_record_id = $postdata['selecteddata'];
				foreach ($delete_record_id as $value) {
					$data = array(
						'id' => $value,
						'is_delete' => 1,
					);

					$response = $this->ss_aw_vocabulary_model->update_data($data);
				}

				$this->session->set_flashdata('success', 'Record removed succesfully.');
			}
		}

		redirect('admin/vocabulary');
	}

	public function removeUnwantedCollateralImages()
	{
		$dir = './assets/collateral';
		deleteAll($dir);
	}

	public function externalcontacts()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if (isset($_FILES["file"]['name'])) {
				$config['upload_path'] = './assets/contacts/';
				$config['allowed_types'] = 'xls|xlsx';
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('file')) {
					//echo "not success";
					$error = array('error' => $this->upload->display_errors());

					$this->session->set_flashdata('error', 'Uploaded file format mismatch.');
					redirect('admin/externalcontacts');
				}

				$data = $this->upload->data();
				$lesson_file = $data['file_name'];
			}

			$file = './assets/contacts/' . $lesson_file;

			//load the excel library
			$this->load->library('excel');

			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);

			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();


			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				$column = @$objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = @$objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if (empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue())) {

					if ($cell[0] == 'A') {
						$data_value = trim($avalue);
					}
					if ($cell[0] == 'B') {
						$data_value = trim($bvalue);
					}
					if ($cell[0] == 'C') {
						$data_value = trim($cvalue);
					}
				} else {
					if ($cell[0] == 'A') {
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					} else if ($cell[0] == 'B') {
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					} else if ($cell[0] == 'C') {
						$cvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = trim($data_value);
				} else {
					$arr_data[$row][$column] = trim($data_value);
				}
			}

			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;

			$upload_data = array(
				'ss_aw_title' => $postdata['title'],
				'ss_aw_upload_by' => $this->session->userdata('id'),
				'ss_aw_file' => $lesson_file
			);
			$upload_id = $this->ss_aw_external_contact_upload_model->add_contact($upload_data);
			if ($upload_id) {
				if (!empty($data['values'])) {
					$insert_count = 0;
					foreach ($data['values'] as $key => $value) {
						$check_old = $this->ss_aw_external_contact_model->check_data(strtolower($value['B']), $value['C']);
						if ($check_old == 0) {
							$data = array(
								'ss_aw_upload_id' => $upload_id,
								'ss_aw_name' => $value['A'],
								'ss_aw_email' => $value['B'],
								'ss_aw_phone' => $value['C']
							);
							$response = $this->ss_aw_external_contact_model->add_contact($data);
							if ($response) {
								$insert_count++;
							}
						}
					}

					if ($insert_count > 0) {
						$this->session->set_flashdata('success', 'Contacts imported Successfully.');
					} else {
						$this->session->set_flashdata('error', 'Uploaded file content already exist.');
						$this->ss_aw_external_contact_upload_model->remove_contact($upload_id);
					}
				}
			}

			redirect('admin/externalcontacts');
		} else {
			$data['contacts'] = $this->ss_aw_external_contact_upload_model->get_contact_details();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/externalcontactsupload', $data);
		}
	}

	public function update_external_contact_status()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if ($postdata['status'] == 1) {
				$status = 0;
			} else {
				$status = 1;
			}
			$data = array(
				'ss_aw_id' => $postdata['id'],
				'ss_aw_status' => $status
			);

			$this->ss_aw_external_contact_upload_model->update_record($data);

			echo "1";
		}
	}

	public function remove_external_contact()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['external_contact_id'];
			$this->ss_aw_external_contact_upload_model->remove_contact($record_id);
			$this->session->set_flashdata('success', 'Contact details removed succesfully.');
			redirect('admin/externalcontacts');
		}
	}

	public function get_user_list()
	{
		$postdata = $this->input->post();
		$user_list = $this->ss_aw_external_contact_model->getuserbyuploadid($postdata['id']);
		$user = array();
		if (!empty($user_list)) {
			$count = 0;
			foreach ($user_list as $key => $value) {
				$count++;
				$user[$key]['sl_no'] = $count;
				$user[$key]['name'] = $value->ss_aw_name;
				$user[$key]['email'] = $value->ss_aw_email;
				$user[$key]['phone'] = $value->ss_aw_phone;
			}

			$result = json_encode($user);
		} else {
			$result = "";
		}

		echo $result;
	}

	public function targetaudiencegroups()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/targetaudiencegroups');
	}

	public function createaudiencegroup()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/createaudiencegroup');
	}

	public function add_coupon()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";
		if ($this->input->post()) {
			$postdata = $this->input->post();

			if (isset($postdata['mark_as_default'])) {
				$default = 1;
				$check_default = $this->ss_aw_coupons_model->checkdefaultcoupon($postdata['member']);
				if ($check_default > 0) {
					$this->session->set_flashdata('error', 'There is already one default coupon set for the target audience type.');
					redirect('admin/add_coupon');
				}
			} else {
				$default = 0;
			}

			$is_institution_coupon = 0;
			if (isset($postdata['use_institution'])) {
				$is_institution_coupon = 1;
			} else {
				$is_institution_coupon = 0;
			}

			$start_date = date('Y-m-d', strtotime($postdata['start_date']));
			$end_date = date('Y-m-d', strtotime($postdata['end_date']));
			if ($default == 1) {
				$end_date = date('Y-m-d', strtotime($start_date . " +99 years"));
			}

			if (!empty($postdata['executing_day'])) {
				$executing_day = $postdata['executing_day'];
			} else {
				$executing_day = 0;
			}

			$data = array(
				'ss_aw_coupon_type' => $postdata['coupon_type'],
				'ss_coupon_code' => strtoupper($postdata['coupon_code']),
				'ss_aw_target_audience' => $postdata['member'],
				'ss_aw_start_date' => $start_date,
				'ss_aw_end_date' => $end_date,
				'ss_aw_discount' => $postdata['discount'],
				'ss_aw_executing_date_in_month' => $executing_day,
				'ss_aw_template' => $postdata['template'],
				'ss_aw_default' => $default,
				'ss_aw_is_institution_coupon' => $is_institution_coupon
			);

			$response = $this->ss_aw_coupons_model->add_record($data);

			if ($response) {
				$this->session->set_flashdata('success', 'Coupon added succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/add_coupon');
		}
		$data['notification_param'] = $this->ss_aw_notification_param_model->getallparam();
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/addcoupon', $data);
	}

	public function copy_coupon()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";

		if ($this->input->post()) {

			$postdata = $this->input->post();
			$default = 0;
			$start_date = date('Y-m-d', strtotime($postdata['start_date']));
			$end_date = date('Y-m-d', strtotime($postdata['end_date']));
			$executing_day = 0;

			$is_institution_coupon = 0;
			if (isset($postdata['use_institution'])) {
				$is_institution_coupon = 1;
			} else {
				$is_institution_coupon = 0;
			}

			$data = array(
				'ss_coupon_code' => $postdata['coupon_code'],
				'ss_aw_coupon_type' => $postdata['coupon_type'],
				'ss_aw_target_audience' => $postdata['audience_type'],
				'ss_aw_start_date' => $start_date,
				'ss_aw_end_date' => $end_date,
				'ss_aw_discount' => $postdata['discount'],
				'ss_aw_executing_date_in_month' => $executing_day,
				'ss_aw_template' => $postdata['template'],
				'ss_aw_default' => $default,
				'ss_aw_is_institution_coupon' => $is_institution_coupon
			);

			$response = $this->ss_aw_coupons_model->add_record($data);

			if ($response) {
				$this->session->set_flashdata('success', 'Coupon added succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}

		redirect('admin/managecoupons');
	}

	public function edit_coupon()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['record_id'];
			if (isset($postdata['mark_as_default'])) {
				$default = 1;
				$check_default = $this->ss_aw_coupons_model->checkdefaultcoupon($postdata['member'], $record_id);
				if ($check_default > 0) {
					$this->session->set_flashdata('error', 'There is already one default coupon set for the target audience type.');
					redirect('admin/edit_coupon/' . $record_id);
				}
			} else {
				$default = 0;
			}

			$is_institution_coupon = 0;
			if (isset($postdata['use_institution'])) {
				$is_institution_coupon = 1;
			} else {
				$is_institution_coupon = 0;
			}

			$start_date = date('Y-m-d', strtotime($postdata['start_date']));
			$end_date = date('Y-m-d', strtotime($postdata['end_date']));
			if ($default == 1) {
				$end_date = date('Y-m-d', strtotime($start_date . " +99 years"));
			}

			$data = array(
				'ss_aw_id' => $record_id,
				'ss_aw_coupon_type' => $postdata['coupon_type'],
				'ss_coupon_code' => $postdata['coupon_code'],
				'ss_aw_target_audience' => $postdata['member'],
				'ss_aw_start_date' => $start_date,
				'ss_aw_end_date' => $end_date,
				'ss_aw_discount' => $postdata['discount'],
				'ss_aw_executing_date_in_month' => $postdata['executing_day'],
				'ss_aw_template' => $postdata['template'],
				'ss_aw_default' => $default,
				'ss_aw_is_institution_coupon' => $is_institution_coupon
			);

			$response = $this->ss_aw_coupons_model->update_record($data);

			if ($response) {
				$this->session->set_flashdata('success', 'Coupon updated succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/edit_coupon/' . $record_id);
		} else {
			$record_id = $this->uri->segment(3);
			$check_coupon_uses = $this->ss_aw_manage_coupon_send_model->checkcouponuses($record_id);
			if ($check_coupon_uses > 0) {
				$this->session->set_flashdata('error', 'This coupon is already in use.');
				redirect('admin/managecoupons');
			}
			$data['result'] = $this->ss_aw_coupons_model->getdetailbyid($record_id);
			$data['notification_param'] = $this->ss_aw_notification_param_model->getallparam();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/editcoupon', $data);
		}
	}

	public function get_coupon_detail()
	{
		$coupon_id = $this->input->post('coupon_id');
		$result = $this->ss_aw_coupons_model->getdetailbyid($coupon_id);
		$responseary = array();
		if (!empty($result)) {
			$responseary['coupon_code'] = $result[0]->ss_coupon_code;
			$responseary['target_audience'] = $result[0]->ss_aw_target_audience;
			$responseary['start_date'] = date('F d, Y', strtotime($result[0]->ss_aw_start_date));
			$responseary['end_date'] = date('F d, Y', strtotime($result[0]->ss_aw_end_date));
			$responseary['discount'] = $result[0]->ss_aw_discount;
			$responseary['executing_day'] = $result[0]->ss_aw_executing_date_in_month;
			$responseary['template'] = $result[0]->ss_aw_template;
			$responseary['default'] = $result[0]->ss_aw_default;
			$responseary['coupon_type'] = $result[0]->ss_aw_coupon_type;
			$responseary['use_institution'] = $result[0]->ss_aw_is_institution_coupon;
		}

		if (!empty($responseary)) {
			echo json_encode($responseary);
		} else {
			echo "";
		}
	}

	public function remove_coupon()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();

			$record_id = $postdata['delete_record_id'];
			$check_coupon_uses = $this->ss_aw_manage_coupon_send_model->checkcouponuses($record_id);
			if ($check_coupon_uses > 0) {
				$this->session->set_flashdata('error', 'This coupon is already in use.');
				redirect('admin/managecoupons');
			}

			if ($postdata['remove_type'] == 'single') {
				$record_id = $postdata['delete_record_id'];

				$check_coupon_uses = $this->ss_aw_manage_coupon_send_model->checkcouponuses($record_id);
				if ($check_coupon_uses > 0) {
					$this->session->set_flashdata('error', 'This coupon is already in use.');
					redirect('admin/managecoupons');
				}

				$update_data = array(
					'ss_aw_id' => $record_id,
					'ss_aw_status' => 0
				);
				$response = $this->ss_aw_coupons_model->update_record($update_data);
				if ($response) {
					$this->session->set_flashdata('success', 'Coupon removed succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			} else {
				$record_id = $postdata['delete_record_id'];
				$record_id_ary = explode(",", $record_id);
				if (!empty($record_id_ary)) {
					foreach ($record_id_ary as $value) {
						$check_coupon_uses = $this->ss_aw_manage_coupon_send_model->checkcouponuses($record_id);
						if ($check_coupon_uses == 0) {
							$update_data = array(
								'ss_aw_id' => $value,
								'ss_aw_status' => 0
							);
							$response = $this->ss_aw_coupons_model->update_record($update_data);
							if ($response) {
								$this->session->set_flashdata('success', 'Coupon removed succesfully.');
							} else {
								$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
							}
						}
					}
				}
			}
		}

		redirect('admin/managecoupons');
	}

	public function add_newsletter()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "News Letter";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$title = $postdata['title'];
			$template = $postdata['template'];
			if (isset($postdata['status'])) {
				$status = 1;
			} else {
				$status = 2;
			}

			$data = array(
				'ss_aw_title' => $title,
				'ss_aw_template' => $template,
				'ss_aw_status' => $status
			);

			$response = $this->ss_aw_newsletter_model->add_newsletter($data);
			if ($response) {
				$this->session->set_flashdata('success', 'Newsletter added succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/add_newsletter');
		} else {
			$data['notification_param'] = $this->ss_aw_notification_param_model->getallparam();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/addnewsletters', $data);
		}
	}

	public function edit_newsletter()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "News Letter";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['record_id'];
			$title = $postdata['title'];
			$template = $postdata['template'];
			if (isset($postdata['status'])) {
				$status = 1;
			} else {
				$status = 2;
			}

			$data = array(
				'ss_aw_id' => $record_id,
				'ss_aw_title' => $title,
				'ss_aw_template' => $template,
				'ss_aw_status' => $status
			);

			$response = $this->ss_aw_newsletter_model->update_record($data);
			if ($response) {
				$this->session->set_flashdata('success', 'Newsletter updated succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Nothing is be updated.');
			}

			redirect('admin/edit_newsletter/' . $record_id);
		} else {
			$record_id = $this->uri->segment(3);
			$data['result'] = $this->ss_aw_newsletter_model->getrecordbyid($record_id);
			$data['notification_param'] = $this->ss_aw_notification_param_model->getallparam();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/editnewsletters', $data);
		}
	}

	public function createpromotions()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Promotion";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$name = $postdata['title'];
			$date = $postdata['date'];
			$select_type = $postdata['promotiontype'];
			if ($select_type == 2) {
				$select_type_id = $postdata['couponname'];
			} else {
				$select_type_id = $postdata['newslettername'];
			}
			$contact_type = $postdata['contact_type'];
			if ($contact_type == 1) {
				$contact_list_ids = implode(",", $postdata['contact']);
			} else {
				$contact_list_ids = "";
			}

			$data = array(
				'ss_aw_name' => $name,
				'ss_aw_date' => $date,
				'ss_aw_select_type' => $select_type,
				'ss_aw_select_type_id' => $select_type_id,
				'ss_aw_contact_type' => $contact_type,
				'ss_aw_contact_list_ids' => $contact_list_ids,
				'ss_aw_created_at' => date('Y-m-d h:i:s')
			);

			$response = $this->ss_aw_create_promotion_model->add_promotion($data);
			if ($response) {
				$this->session->set_flashdata('success', 'Promotion created successfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/createpromotions');
		} else {
			$data['newsletter'] = $this->ss_aw_newsletter_model->getallnewsletter();
			$data['externalcontacts'] = $this->ss_aw_external_contact_upload_model->get_contact_details();
			$data['coupons'] = $this->ss_aw_coupons_model->getnondefaultcoupons();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/createpromotions', $data);
		}
	}

	public function send_promotion()
	{
		$this->checklogin();
		$promotion_id = $this->input->post('send_promotion_id');
		$promotion_details = $this->ss_aw_create_promotion_model->getdetailsbyid($promotion_id);

		$contact_type = $promotion_details[0]->ss_aw_contact_type;
		$title = $promotion_details[0]->ss_aw_name;
		$select_type = $promotion_details[0]->ss_aw_select_type;
		$select_type_id = $promotion_details[0]->ss_aw_select_type_id;

		if ($contact_type == 1) {
			$sending_emails = array();
			$contact_list_ids = $promotion_details[0]->ss_aw_contact_list_ids;
			$contact_list_ids_ary = explode(",", $contact_list_ids);
			if (!empty($contact_list_ids_ary)) {
				$contacts = $this->ss_aw_external_contact_model->getuserbyuploadidary($contact_list_ids_ary);
				if (!empty($contacts)) {
					foreach ($contacts as $key => $value) {
						if ($select_type == 1) {
							$details = $this->ss_aw_newsletter_model->getrecordbyid($select_type_id);
							$template = $details[0]->ss_aw_template;
							$template = str_ireplace("[@@username@@]", $value->ss_aw_name, $template);
							if (!empty($template)) {
								$sending_emails[] = $value->ss_aw_email;
								emailnotification($value->ss_aw_email, $title, $template);
							}
						} else {
							$details = $this->ss_aw_coupons_model->getdetailbyid($select_type_id);
							$template = $details[0]->ss_aw_template;
							$coupon_code = $details[0]->ss_coupon_code;
							$start_date = date('d/m/Y', strtotime($details[0]->ss_aw_start_date));
							$end_date = date('d/m/Y', strtotime($details[0]->ss_aw_end_date));
							$discount = $details[0]->ss_aw_discount . "%";

							$template = str_ireplace("[@@coupon_code@@]", $coupon_code, $template);
							$template = str_ireplace("[@@coupon_start_date@@]", $start_date, $template);
							$template = str_ireplace("[@@coupon_end_date@@]", $end_date, $template);
							$template = str_ireplace("[@@coupon_discount@@]", $discount, $template);
							$template = str_ireplace("[@@username@@]", $value->ss_aw_name, $template);
							if (!empty($template)) {
								$data = array(
									'ss_aw_coupon_id' => $select_type_id,
									'ss_aw_user_id' => $value->ss_aw_id,
									'ss_aw_target_audience' => 2,
									'ss_aw_send_date' => date('Y-m-d')
								);

								$check_coupon_assign = $this->ss_aw_manage_coupon_send_model->check_coupon_assign($select_type_id, $value->ss_aw_id, 2);
								if ($check_coupon_assign == 0) {
									$response = $this->ss_aw_manage_coupon_send_model->add_record($data);
									if ($response) {
										$sending_emails[] = $value->ss_aw_email;
										emailnotification($value->ss_aw_email, $title, $template);
									}
								}
							}
						}
					}
					//sendbulkmail($template, 'Exiting Offer', $value->ss_aw_email);
				}
			}
		} else {
			$contacts = $this->ss_aw_parents_model->getallnotcoursepurchasedparents();

			if (!empty($contacts)) {
				$sending_emails = array();
				foreach ($contacts as $key => $value) {
					if ($select_type == 2) {
						$details = $this->ss_aw_coupons_model->getdetailbyid($select_type_id);
						$template = $details[0]->ss_aw_template;
						$coupon_code = $details[0]->ss_coupon_code;
						$start_date = date('d/m/Y', strtotime($details[0]->ss_aw_start_date));
						$end_date = date('d/m/Y', strtotime($details[0]->ss_aw_end_date));
						$discount = $details[0]->ss_aw_discount . "%";

						$template = str_ireplace("[@@coupon_code@@]", $coupon_code, $template);
						$template = str_ireplace("[@@coupon_start_date@@]", $start_date, $template);
						$template = str_ireplace("[@@coupon_end_date@@]", $end_date, $template);
						$template = str_ireplace("[@@coupon_discount@@]", $discount, $template);
						$template = str_ireplace("[@@username@@]", $value->ss_aw_parent_full_name, $template);
						if (!empty($template)) {
							$data = array(
								'ss_aw_coupon_id' => $select_type_id,
								'ss_aw_user_id' => $value->ss_aw_parent_id,
								'ss_aw_target_audience' => 1,
								'ss_aw_send_date' => date('Y-m-d')
							);

							$check_coupon_assign = $this->ss_aw_manage_coupon_send_model->check_coupon_assign($select_type_id, $value->ss_aw_parent_id, 1);
							if ($check_coupon_assign == 0) {
								$response = $this->ss_aw_manage_coupon_send_model->add_record($data);
								if ($response) {
									$sending_emails[] = $value->ss_aw_parent_email;
									emailnotification($value->ss_aw_parent_email, $title, $template);
								}
							}
						}
					} else {
						$details = $this->ss_aw_newsletter_model->getrecordbyid($select_type_id);
						$template = $details[0]->ss_aw_template;
						$template = str_ireplace("[@@username@@]", $value->ss_aw_parent_full_name, $template);
						$sending_emails[] = $value->ss_aw_parent_email;
						emailnotification($value->ss_aw_parent_email, $title, $template);
					}
				}

				//sendbulkmail($template, 'Exiting Offer', $sending_emails);
			}
		}

		if (!empty($sending_emails)) {
			$this->session->set_flashdata('success', 'Promtion send successfully to the target users.');
		} else {
			$this->session->set_flashdata('error', 'Sorry! no new target user found.');
		}
		redirect('admin/managepromotions');
	}

	public function managecoupons()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Coupon";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('coupon_search_data', $postdata);
			redirect('admin/managecoupons');
		} else {
			$search_data = array();
			if ($this->session->userdata('coupon_search_data')) {
				$search_data = $this->session->userdata('coupon_search_data');
			}
			$data['search_data'] = $search_data;
			$total_record = $this->ss_aw_coupons_model->total_record($search_data);
			$redirect_to = base_url() . 'admin/managecoupons';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;', $str_links);
			if ($page >= $config["total_rows"]) {
				$page = 0;
			}
			$result = $this->ss_aw_coupons_model->getlimitedrecord($search_data, $config['per_page'], $page);
			$data['result'] = $result;
			$data['notification_param'] = $this->ss_aw_notification_param_model->getallparam();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/managecouponlist', $data);
		}
	}

	public function changenewsletterstatus()
	{
		$this->checklogin();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$newsletter_id = $postdata['status_newsletter_id'];
			$newsletter_status = $postdata['status_newsletter_status'];
			if ($newsletter_status == 1) {
				$updated_status = 2;
			} else {
				$updated_status = 1;
			}
			$data = array(
				'ss_aw_id' => $newsletter_id,
				'ss_aw_status' => $updated_status
			);

			$response = $this->ss_aw_newsletter_model->update_record($data);

			if ($response) {
				$this->session->set_flashdata('success', 'Status updated succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}

		redirect('admin/managenewsletters');
	}

	public function remove_newsletter()
	{
		$this->checklogin();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['delete_record_id'];

			if ($postdata['remove_type'] == 'single') {
				$record_id = $postdata['delete_record_id'];

				$response = $this->ss_aw_newsletter_model->remove_record($record_id);
				if ($response) {
					$this->session->set_flashdata('success', 'Newsletter removed succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			} else {
				$record_id = $postdata['delete_record_id'];
				$record_id_ary = explode(",", $record_id);
				if (!empty($record_id_ary)) {
					foreach ($record_id_ary as $value) {
						$response = $this->ss_aw_newsletter_model->remove_record($record_id);
						if ($response) {
							$this->session->set_flashdata('success', 'Newsletter removed succesfully.');
						} else {
							$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
						}
					}
				}
			}
		}
		redirect('admin/managenewsletters');
	}

	public function managenewsletters()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Newsletter";

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('newsletter_search_data', $postdata);
			redirect('admin/managenewsletters');
		} else {
			$search_data = array();
			if ($this->session->userdata('newsletter_search_data')) {
				$search_data = $this->session->userdata('newsletter_search_data');
			}
			$data['search_data'] = $search_data;
			$total_record = $this->ss_aw_newsletter_model->total_record($search_data);
			$redirect_to = base_url() . 'admin/managenewsletters';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;', $str_links);
			if ($page >= $config["total_rows"]) {
				$page = 0;
			}
			$result = $this->ss_aw_newsletter_model->getlimitedrecord($search_data, $config['per_page'], $page);
			$data['result'] = $result;
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/managenewsletters', $data);
		}
	}

	public function managepromotions()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Promotions";

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('promotion_search_data', $postdata);
			redirect('admin/managenewsletters');
		} else {
			$search_data = array();
			if ($this->session->userdata('promotion_search_data')) {
				$search_data = $this->session->userdata('promotion_search_data');
			}
			$data['search_data'] = $search_data;
			$total_record = $this->ss_aw_create_promotion_model->total_record($search_data);
			$redirect_to = base_url() . 'admin/managepromotions';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;', $str_links);
			if ($page >= $config["total_rows"]) {
				$page = 0;
			}
			$result = $this->ss_aw_create_promotion_model->getlimitedrecord($search_data, $config['per_page'], $page);
			$data['result'] = $result;
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/managepromotions', $data);
		}
	}

	public function remove_promotion()
	{
		$this->checklogin();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['delete_record_id'];

			if ($postdata['remove_type'] == 'single') {
				$record_id = $postdata['delete_record_id'];

				$response = $this->ss_aw_create_promotion_model->remove_record($record_id);
				if ($response) {
					$this->session->set_flashdata('success', 'Promotion removed succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			} else {
				$record_id = $postdata['delete_record_id'];
				$record_id_ary = explode(",", $record_id);
				if (!empty($record_id_ary)) {
					$response = $this->ss_aw_create_promotion_model->remove_multiple_record($record_id_ary);
					if ($response) {
						$this->session->set_flashdata('success', 'Promotion removed succesfully.');
					} else {
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				} else {
					$this->session->set_flashdata('error', 'Please choose atleast one record.');
				}
			}
		}
		redirect('admin/managepromotions');
	}

	public function edit_promotion()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Promotion";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['record_id'];
			$name = $postdata['title'];
			$date = $postdata['date'];
			$select_type = $postdata['promotiontype'];
			if ($select_type == 2) {
				$select_type_id = $postdata['couponname'];
			} else {
				$select_type_id = $postdata['newslettername'];
			}
			$contact_type = $postdata['contact_type'];
			if ($contact_type == 1) {
				$contact_list_ids = implode(",", $postdata['contact']);
			} else {
				$contact_list_ids = "";
			}

			$data = array(
				'ss_aw_id' => $record_id,
				'ss_aw_name' => $name,
				'ss_aw_date' => $date,
				'ss_aw_select_type' => $select_type,
				'ss_aw_select_type_id' => $select_type_id,
				'ss_aw_contact_type' => $contact_type,
				'ss_aw_contact_list_ids' => $contact_list_ids,
				'ss_aw_select_type_id' => $select_type_id,
				'ss_aw_created_at' => date('Y-m-d h:i:s')
			);

			$response = $this->ss_aw_create_promotion_model->update_promotion($data);

			if ($response) {
				$this->session->set_flashdata('success', 'Promotion updated successfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/edit_promotion/' . $record_id);
		} else {
			$record_id = $this->uri->segment(3);
			$data['result'] = $this->ss_aw_create_promotion_model->getdetailsbyid($record_id);
			$data['newsletter'] = $this->ss_aw_newsletter_model->getallnewsletter();
			$data['externalcontacts'] = $this->ss_aw_external_contact_upload_model->get_contact_details();
			$data['coupons'] = $this->ss_aw_coupons_model->getnondefaultcoupons();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/editpromotion', $data);
		}
	}

	public function settings()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Promotion Settings";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$data = array(
				'ss_aw_frequency_for_new_users' => $postdata['frequency_new_user'],
				'ss_aw_frequency_duration' => $postdata['frequency_duration'],
				'ss_aw_rest_period' => $postdata['rest_period']
			);

			$response = $this->ss_aw_promotion_sending_frequency_model->update_record($data);

			if ($response) {
				$this->session->set_flashdata('success', 'Settings updated succesfully.');
			} else {
				$this->session->set_flashdata('error', 'There is nothing to update.');
			}

			redirect('admin/settings');
		} else {
			$data['result'] = $this->ss_aw_promotion_sending_frequency_model->get_record();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/promotionsettings', $data);
		}
	}

	public function score_settings()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Score Settings";
		$data['score_value'] = $this->ss_aw_score_numeric_values_model->fetch_data();
		$data['confidence_value'] = $this->ss_aw_confidence_numeric_values_model->fetch_data();
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/score_settings', $data);
	}

	public function add_scoring_values()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if (!empty($postdata['update_score_settings'])) {
				$data = array();
				$data['part1_1'] = $postdata['part1_1'];
				$data['part1_2'] = $postdata['part1_2'];
				$data['part1_3'] = $postdata['part1_3'];
				$data['part1_4'] = $postdata['part1_4'];
				$data['part1_5'] = $postdata['part1_5'];
				$data['part1_6'] = $postdata['part1_6'];
				$data['part1_7'] = $postdata['part1_7'];
				$data['part1_8'] = $postdata['part1_8'];
				$data['part1_9'] = $postdata['part1_9'];
				$data['part1_10'] = $postdata['part1_10'];
				$data['part1_11'] = $postdata['part1_11'];
				$data['part1_12'] = $postdata['part1_12'];
				$data['part1_13'] = $postdata['part1_13'];
				$data['part1_14'] = $postdata['part1_14'];
				$data['part1_15'] = $postdata['part1_15'];
				$data['part1_16'] = $postdata['part1_16'];
				$data['part1_17'] = $postdata['part1_17'];
				$data['part1_18'] = $postdata['part1_18'];
				$data['part1_19'] = $postdata['part1_19'];
				$data['part1_20'] = $postdata['part1_20'];

				//part 2
				$data['part2_1'] = $postdata['part2_1'];
				$data['part2_2'] = $postdata['part2_2'];
				$data['part2_3'] = $postdata['part2_3'];
				$data['part2_4'] = $postdata['part2_4'];
				$data['part2_5'] = $postdata['part2_5'];
				$data['part2_6'] = $postdata['part2_6'];
				$data['part2_7'] = $postdata['part2_7'];
				$data['part2_8'] = $postdata['part2_8'];
				$data['part2_9'] = $postdata['part2_9'];
				$data['part2_10'] = $postdata['part2_10'];
				$data['part2_11'] = $postdata['part2_11'];
				$data['part2_12'] = $postdata['part2_12'];
				$data['part2_13'] = $postdata['part2_13'];
				$data['part2_14'] = $postdata['part2_14'];
				$data['part2_15'] = $postdata['part2_15'];
				$data['part2_16'] = $postdata['part2_16'];
				$data['part2_17'] = $postdata['part2_17'];
				$data['id'] = $postdata['record_id'];

				$response = $this->ss_aw_score_numeric_values_model->update_record($data);

				if ($response) {
					$this->session->set_flashdata('success', 'Score numeric values updated successfully.');
				}
			} elseif (!empty($postdata['update_confidence_settings'])) {
				$data = array();
				$data['part1_1'] = $postdata['part1_1'];
				$data['part1_2'] = $postdata['part1_2'];
				$data['part1_3'] = $postdata['part1_3'];
				$data['part1_4'] = $postdata['part1_4'];
				$data['part1_5'] = $postdata['part1_5'];
				$data['part1_6'] = $postdata['part1_6'];
				$data['part1_7'] = $postdata['part1_7'];
				$data['part1_8'] = $postdata['part1_8'];
				$data['part1_9'] = $postdata['part1_9'];
				$data['part1_10'] = $postdata['part1_10'];
				$data['part1_11'] = $postdata['part1_11'];
				$data['part1_12'] = $postdata['part1_12'];
				$data['part1_13'] = $postdata['part1_13'];
				$data['part1_14'] = $postdata['part1_14'];
				$data['part1_15'] = $postdata['part1_15'];
				$data['part1_16'] = $postdata['part1_16'];
				$data['part1_17'] = $postdata['part1_17'];
				$data['part1_18'] = $postdata['part1_18'];
				$data['part1_19'] = $postdata['part1_19'];
				$data['part1_20'] = $postdata['part1_20'];
				$data['part1_21'] = $postdata['part1_21'];
				$data['part1_22'] = $postdata['part1_22'];
				$data['part1_23'] = $postdata['part1_23'];
				$data['part1_24'] = $postdata['part1_24'];
				$data['part1_25'] = $postdata['part1_25'];
				$data['part1_26'] = $postdata['part1_26'];
				$data['part1_27'] = $postdata['part1_27'];
				$data['part1_28'] = $postdata['part1_28'];
				$data['part1_29'] = $postdata['part1_29'];
				$data['part1_30'] = $postdata['part1_30'];
				$data['id'] = $postdata['record_id'];

				$response = $this->ss_aw_confidence_numeric_values_model->update_record($data);

				if ($response) {
					$this->session->set_flashdata('success', 'Confidence numeric values updated successfully.');
				}
			}
		}

		redirect('admin/score_settings');
	}

	public function makepayment()
	{
		if ($this->uri->segment(3)) {
			$url = base64_decode($this->uri->segment(3));
			$urldata = explode("@", $url);
			$data['user_id'] = $urldata[0];
			$data['child_id'] = $urldata[1];
			$data['course_id'] = $urldata[2];
			$data['invoice_no'] = $urldata[3];
			$data['payment_amount'] = $urldata[4];
			$data['gst_rate'] = $urldata[5];
			$data['discount_amount'] = $urldata[6];
			$data['coupon_id'] = $urldata[7];
			$data['promoted'] = $urldata[8];
			$data['emi_payment'] = $urldata[9];

			$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($data['user_id']);
			if (!empty($parent_details)) {
				$data['user_email'] = $parent_details[0]->ss_aw_parent_email;
			}

			$search_data = array();
			$search_data['ss_aw_course_id'] = $data['course_id'];
			$course_details = $this->ss_aw_courses_model->search_byparam($search_data);
			if (!empty($course_details)) {
				$data['course_name'] = $course_details[0]['ss_aw_course_name'];
			}

			$this->load->view('admin/payment', $data);
		}
	}

	public function make_supplymentary_payment()
	{
		if ($this->uri->segment(3)) {
			$url = base64_decode($this->uri->segment(3));
			$urldata = explode("@", $url);
			$data['user_id'] = $urldata[0];
			$data['child_id'] = $urldata[1];
			$data['course_id'] = $urldata[2];
			$data['payment_amount'] = $urldata[3];
			$data['gst_rate'] = $urldata[4];
			$data['discount_amount'] = $urldata[5];

			$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($data['user_id']);
			if (!empty($parent_details)) {
				$data['user_email'] = $parent_details[0]->ss_aw_parent_email;
			}

			$search_data = array();
			$search_data['ss_aw_course_id'] = $data['course_id'];
			$course_details = $this->ss_aw_courses_model->search_byparam($search_data);
			if (!empty($course_details)) {
				$data['course_name'] = $course_details[0]['ss_aw_course_name'];
			}

			$this->load->view('admin/supplymentary_payment', $data);
		}
	}

	public function mark_payment()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$child_id = $postdata['payment_child_id'];
			$course_id = $postdata['course_id'];
			$transaction_id = $postdata['transaction_id'];
			$payment_amount = $postdata['payment_amount'];
			$parent_id = $postdata['payment_parent_id'];
			if ($transaction_id == "" && $payment_amount == "") {
				$this->session->set_flashdata('error', 'Please enter Transaction ID & Payment Amount.');
				redirect('admin/childrendetails/' . $parent_id);
			}


			
			if (empty($postdata['emi_payment'])) {
				$postdata['emi_payment'] = 0;
			}
			$invoice_prefix = "ALWS/";
			$invoice_suffix = "/" . date('m') . date('y');
			$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
			if (!empty($get_last_invoice_details)) {
				$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
				if (!empty($invoice_ary)) {
					if (!empty($invoice_ary[1])) {
						if (is_numeric($invoice_ary[1])) {
							$suffix_num = (int)$invoice_ary[1] + 1;
							$invoice_no = $invoice_prefix . $suffix_num;
						} else {
							$invoice_no = $invoice_prefix . "100001";
						}
					} else {
						$invoice_no = $invoice_prefix . "100001";
					}
				} else {
					$invoice_no = $invoice_prefix . "100001";
				}
			} else {
				$invoice_no = $invoice_prefix . "100001";
			}
			$invoice_no = $invoice_no . $invoice_suffix;
			$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			$searary = array();
			$searary['ss_aw_course_id'] = $course_id;
			$courseary_details = $this->ss_aw_courses_model->search_byparam($searary);

			$discount_amount = 0;
			$gst_rate = ($payment_amount * 18) / 100;
			$coupon_id = 0;
			if (!empty($courseary_details)) {
				$data = array();
				$data['transaction_id'] = $transaction_id;
				$data['payment_amount'] = $payment_amount;
				$data['course_id'] = $course_id;
				$data['invoice_no'] = $invoice_no;
				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
				$data['parent_details'] = $parent_detail;
				$data['discount_amount'] = $discount_amount;
				$data['gst_rate'] = $gst_rate;
				$data['coupon_id'] = $coupon_id;
				$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => $course_id));
				$data['payment_type'] = $postdata['emi_payment'];
				$this->load->library('pdf');
				$html = $this->load->view('pdf/paymentinvoice', $data, true);

				$filename = time() . rand() . "_" . $child_id . ".pdf";
				$save_file_path = "./payment_invoice/" . $filename;
				$this->pdf->createPDF($save_file_path, $html, $filename, false);

				$this->db->trans_start();
				$searary = array();
				$searary['ss_aw_parent_id'] = $parent_id;
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_selected_course_id'] = $course_id;
				$searary['ss_aw_transaction_id'] = $transaction_id;
				$searary['ss_aw_course_payment'] = $payment_amount;
				$searary['ss_aw_invoice'] = $filename;
				$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
				$searary = array();
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_course_id'] = $course_id;
				if ($postdata['emi_payment']) {
					$searary['ss_aw_course_payemnt_type'] = 1;
				}

				$courseary = $this->ss_aw_child_course_model->data_insert($searary);

				//update parent user type
				$updated_user_type = 3;
				$check_self_enrolled = $this->ss_aw_childs_model->check_self_enrolled($parent_id);
				if (!empty($check_self_enrolled)) {
					$updated_user_type = 5;
				} else {
					if ($child_details[0]->ss_aw_child_age >= 18) {
						$updated_user_type = 4;
					}
				}

				$parent_data = array(
					'ss_aw_user_type' => $updated_user_type
				);
				$this->ss_aw_parents_model->update_parent_details($parent_data, $parent_id);
				//end

				$searary = array();
				$discount_amount = 0;
				$searary['ss_aw_parent_id'] = $parent_id;
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_payment_invoice'] = $invoice_no;
				$searary['ss_aw_transaction_id'] = $transaction_id;
				$searary['ss_aw_payment_amount'] = $payment_amount;
				$searary['ss_aw_gst_rate'] = $courseary_details[0]['ss_aw_gst_rate'];
				$searary['ss_aw_discount_amount'] = $discount_amount;
				$courseary = $this->ss_aw_payment_details_model->data_insert($searary);

				//revenue mis data store
				$invoice_amount = $payment_amount - $gst_rate;
				$reporting_collection_data = array(
					'ss_aw_parent_id' => $parent_id,
					'ss_aw_bill_no' => $invoice_no,
					'ss_aw_course_id' => $course_id,
					'ss_aw_invoice_amount' => round($invoice_amount,2),
					'ss_aw_discount_amount' => round($discount_amount,2),
					'ss_aw_payment_type' => $postdata['emi_payment']
				);

				$resporting_collection_insertion = $this->ss_aw_reporting_collection_model->store_data($reporting_collection_data);
				if ($resporting_collection_insertion) {
					if ($inputpost['emi_payment']) {
						if ($inputpost['promoted']) {
							if ($course_id == 2) {
								$previous_course_id = 1;
								$promoted_course_duration = 175;
								$previous_course_duration = 105;
							} elseif ($course_id == 3) {
								$previous_course_id = 2;
								$promoted_course_duration = 210;
								$previous_course_duration = 175;
							}

							//remove previous revenue records
							$current_month = date('m');
							$this->ss_aw_reporting_revenue_model->removerecordfrommonth($current_month, $previous_course_id, $parent_id);
							//end

							//get previous collection data
							$reporting_collection_details = $this->ss_aw_reporting_collection_model->getlastemicollection($previous_course_id, $parent_id);
							$previous_invoice_amount = $reporting_collection_details[0]->ss_aw_invoice_amount;
							//get previous emi revenue
							$reporting_revenue_details = $this->ss_aw_reporting_revenue_model->getlastemirevenue($parent_id);
							$last_emi_revenue = $reporting_revenue_details[0]->ss_aw_invoice_amount;
							$revenue_invoice_amount = $previous_invoice_amount - $last_emi_revenue;
							$today_date = date('Y') . "-" . date('m') . "-01";
							//first insertion
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $previous_course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => 0,
								'ss_aw_payment_type' => $postdata['emi_payment']
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

							//second insertion
							$today_date = date('Y-m-d');
							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							$revenue_invoice_amount = ($previous_invoice_amount / $days_current_month) * $remaing_days;

							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => 0,
								'ss_aw_payment_type' => $postdata['emi_payment'],
								'ss_aw_advance' => 1
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
						} else {
							$today_date = date('Y-m-d');
							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							$revenue_invoice_amount = ($invoice_amount / $days_current_month) * $remaing_days;

							//for the first insertion
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => $remaing_days,
								'ss_aw_payment_type' => $postdata['emi_payment']
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

							//for the second insertion
							$remaing_amount = $invoice_amount - $revenue_invoice_amount;
							if ($remaing_amount > 0) {
								$today_date = new DateTime();
								$today_date->format('Y-m-d');
								$day = $today_date->format('j');
								$today_date->modify('first day of + 1 month');
								$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
								$today_date = $today_date->format('Y-m-d');
								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today_date = $year . "-" . $month . "-01";
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($remaing_amount,2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $postdata['emi_payment'],
									'ss_aw_advance' => 1
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							}
						}
					} else {
						if (!empty($inputpost['promoted'])) {
							if ($course_id == 2) {
								$previous_course_id = 1;
								$promoted_course_duration = 175;
								$previous_course_duration = 105;
							} elseif ($course_id == 3) {
								$previous_course_id = 2;
								$promoted_course_duration = 210;
								$previous_course_duration = 175;
							}

							//remove previous revenue records
							$current_month = date('m');
							$this->ss_aw_reporting_revenue_model->removerecordfrommonth($current_month, $previous_course_id, $parent_id);
							//end
							$today_date = date('Y-m-d');
							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							//get previous collection details
							$reporting_collection_details = $this->ss_aw_reporting_collection_model->getdatabylevel($previous_course_id, $parent_id);
							$previous_invoice_amount = $reporting_collection_details[0]->ss_aw_invoice_amount;
							$sum_of_reporting_collection = $previous_invoice_amount + round($invoice_amount);
							//end
							$first_revenue_amount = ($previous_invoice_amount / $previous_course_duration) * $today;

							// Store first revenue record
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $previous_course_id,
								'ss_aw_invoice_amount' => round($first_revenue_amount,2),
								'ss_aw_discount_amount' => round($discount_amount,2),
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => $today,
								'ss_aw_payment_type' => $postdata['emi_payment']
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							//e

							$previous_level_details = $this->ss_aw_reporting_revenue_model->getpreviousleveldaycount($previous_course_id, $parent_id);
							if (!empty($previous_level_details)) {
								$previous_level_count_day = $previous_level_details[0]->previous_level_count;
							} else {
								$previous_level_count_day = 0;
							}

							$course_duration = $promoted_course_duration - $previous_level_count_day;
							$count = 0;
							while ($course_duration != 0) {
								if ($count == 0) {
									$advance_payment = 0;
									$reporting_revenue_details = $this->ss_aw_reporting_revenue_model->getdatauptomonth($course_id, $current_month, $parent_id);
									$sum_of_reporting_revenue = $reporting_revenue_details[0]->invoice_amount;
									$sum_of_revenue_count_days = $reporting_revenue_details[0]->revenue_count_days;
									$substraction_revenue = $sum_of_reporting_collection - $sum_of_reporting_revenue;
									$second_revenue_amount = (($substraction_revenue) / ($promoted_course_duration - $sum_of_revenue_count_days)) * $remaing_days;

									//for the first insertion
									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($second_revenue_amount,2),
										'ss_aw_discount_amount' => 0,
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => $postdata['emi_payment']
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								} else {
									$advance_payment = 1;
									$today_date = date('Y-m-d');
									$today_date = date('Y-m-d', strtotime($today_date . ' + ' . $count . ' month'));
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = 0;
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
									$today_date = $year . "-" . $month . "-01";

									if ($remaing_days > $course_duration) {
										$remaing_days = $course_duration;
										$course_duration = 0;
									} else {
										$course_duration = $course_duration - $remaing_days;
									}

									$reporting_revenue_details = $this->ss_aw_reporting_revenue_model->getdatauptomonth($course_id, $current_month, $parent_id);
									$sum_of_reporting_revenue = $reporting_revenue_details[0]->invoice_amount;
									$sum_of_revenue_count_days = $reporting_revenue_details[0]->revenue_count_days;
									$substraction_revenue = $sum_of_reporting_collection - $sum_of_reporting_revenue;
									$second_revenue_amount = (($substraction_revenue) / ($promoted_course_duration - $sum_of_revenue_count_days)) * $remaing_days;

									//for the first insertion
									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($second_revenue_amount,2),
										'ss_aw_discount_amount' => 0,
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => $postdata['emi_payment'],
										'ss_aw_advance' => $advance_payment
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								}
								$count++;
							}
						} else {
							if ($course_id == 1 || $course_id == 2) {
								$fixed_course_duration = WINNERS_DURATION;
								$course_duration = WINNERS_DURATION;
							} elseif ($course_id == 3) {
								$fixed_course_duration = CHAMPIONS_DURATION;
								$course_duration = CHAMPIONS_DURATION;
							} else {
								$fixed_course_duration = MASTERS_DURATION;
								$course_duration = MASTERS_DURATION;
							}


							$today = date('d');

							$count = 0;
							while ($course_duration != 0) {
								if ($count == 0) {
									$advance_payment = 0;
									$today_date = date('Y-m-d');
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = date('d');
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
								} else {
									$advance_payment = 1;
									$today_date = new DateTime();
									$today_date->format('Y-m-d');
									$day = $today_date->format('j');
									$today_date->modify('first day of + ' . $count . ' month');
									$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
									$today_date = $today_date->format('Y-m-d');
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = 0;
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
									$today_date = $year . "-" . $month . "-01";
								}

								if ($remaing_days > $course_duration) {
									$remaing_days = $course_duration;
									$course_duration = 0;
								} else {
									$course_duration = $course_duration - $remaing_days;
								}

								$revenue_invoice_amount = ($invoice_amount / $fixed_course_duration) * $remaing_days;
								$revenue_discount_amount = 0;
								if ($discount_amount > 0) {
									$revenue_discount_amount = ($discount_amount / $fixed_course_duration) * $remaing_days;
								}

								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
									'ss_aw_discount_amount' => round($revenue_discount_amount,2),
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $remaing_days,
									'ss_aw_payment_type' => $postdata['emi_payment'],
									'ss_aw_advance' => $advance_payment
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

								$count++;
							}
						}
					}
				}
				//end

				$this->db->trans_complete();

				$this->session->set_flashdata('success', 'Marked as paid succesfully.');

				// if (empty($inputpost['promoted'])) {
				// 	$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);
				// 	$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

				// 	//send notification code
				// 	if ($course_id == 1 || $course_id == 2) {
				// 		$course_name = "Winners";
				// 	}
				// 	elseif($course_id == 3){
				// 		$course_name = "Champions";
				// 	}
				// 	else{
				// 		$course_name = "Masters";
				// 	}

				// 	if (!empty($child_details)) {
				// 		if ($course_id == 1 || $course_id == 2) {
				// 			$email_template = getemailandpushnotification(7, 1, 2);
				// 			$app_template = getemailandpushnotification(7, 2, 2);
				// 			$action_id = 9;
				// 		} elseif ($course_id == 3) {
				// 			$email_template = getemailandpushnotification(32, 1, 2);
				// 			$app_template = getemailandpushnotification(32, 2, 2);
				// 			$action_id = 10;
				// 		} else {
				// 			$email_template = getemailandpushnotification(33, 1, 2);
				// 			$app_template = getemailandpushnotification(33, 2, 2);
				// 			$action_id = 11;
				// 		}

				// 		$month_date = date('d/m/Y');
				// 		if (!empty($email_template)) {
				// 			$body = $email_template['body'];
				// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 			$body = str_ireplace("[@@month_date@@]", $month_date, $body);
				// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 			emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
				// 		}

				// 		if (!empty($app_template)) {
				// 			$body = $app_template['body'];
				// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 			$body = str_ireplace("[@@month_date@@]", $month_date, $body);
				// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 			$title = $app_template['title'];
				// 			$token = $child_details[0]->ss_aw_device_token;

				// 			pushnotification($title, $body, $token, $action_id);

				// 			$save_data = array(
				// 				'user_id' => $child_details[0]->ss_aw_child_id,
				// 				'user_type' => 2,
				// 				'title' => $title,
				// 				'msg' => $body,
				// 				'status' => 1,
				// 				'read_unread' => 0,
				// 				'action' => $action_id
				// 			);

				// 			save_notification($save_data);
				// 		}

				// 		$this->ss_aw_childs_model->logout($child_details[0]->ss_aw_child_id);
				// 	}

				// 	if (empty($child_details[0]->ss_aw_child_username)) {
				// 			//payment confirmation email notification.
				// 				$email_template = getemailandpushnotification(59, 1, 1);
				// 				if (!empty($email_template)) {
				// 					$body = $email_template['body'];
				// 					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 					$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 					$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 					$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 					$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 					$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
				// 					$gender = $child_details[0]->ss_aw_child_gender;
				// 					if ($gender == 2) {
				// 						$g_name = "She";
				// 					}
				// 					else{
				// 						$g_name = "He";
				// 					}
				// 					$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 					emailnotification($parent_detail[0]->ss_aw_parent_email, 'Payment Confirmation', $body);
				// 				}

				// 				$app_template = getemailandpushnotification(59, 2, 1);
				// 				if (!empty($app_template)) {
				// 					$body = $app_template['body'];
				// 					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 					$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 					$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 					$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 					$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 					$gender = $child_details[0]->ss_aw_child_gender;
				// 					if ($gender == 2) {
				// 						$g_name = "She";
				// 					}
				// 					else{
				// 						$g_name = "He";
				// 					}
				// 					$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 					$title = 'Payment Confirmation';
				// 					$token = $parent_detail[0]->ss_aw_device_token;

				// 					pushnotification($title,$body,$token,8);

				// 					$save_data = array(
				// 						'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 						'user_type' => 1,
				// 						'title' => $title,
				// 						'msg' => $body,
				// 						'status' => 1,
				// 						'read_unread' => 0,
				// 						'action' => 8
				// 					);

				// 					save_notification($save_data);
				// 				}	
				// 		}
				// 		else{
				// 			//payment confirmation email notification.
				// 			$email_template = getemailandpushnotification(6, 1, 1);
				// 			if (!empty($email_template)) {
				// 				$body = $email_template['body'];
				// 				$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 				$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 				$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 				$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 				$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
				// 				$gender = $child_details[0]->ss_aw_child_gender;
				// 				if ($gender == 2) {
				// 					$g_name = "She";
				// 				}
				// 				else{
				// 					$g_name = "He";
				// 				}
				// 				$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 				emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
				// 			}

				// 			$app_template = getemailandpushnotification(6, 2, 1);
				// 			if (!empty($app_template)) {
				// 				$body = $app_template['body'];
				// 				$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 				$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 				$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 				$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 				$gender = $child_details[0]->ss_aw_child_gender;
				// 				if ($gender == 2) {
				// 					$g_name = "She";
				// 				}
				// 				else{
				// 					$g_name = "He";
				// 				}
				// 				$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 				$title = $app_template['title'];
				// 				$token = $parent_detail[0]->ss_aw_device_token;

				// 				pushnotification($title,$body,$token,8);

				// 				$save_data = array(
				// 					'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 					'user_type' => 1,
				// 					'title' => $title,
				// 					'msg' => $body,
				// 					'status' => 1,
				// 					'read_unread' => 0,
				// 					'action' => 8
				// 				);

				// 				save_notification($save_data);
				// 			}
				// 		}
				// 	// if (!empty($parent_detail)) {
				// 	// 	if ($course_id == 1 || $course_id == 2) {
				// 	// 			$email_template = getemailandpushnotification(7, 1, 1);
				// 	// 			$app_template = getemailandpushnotification(7, 2, 1);
				// 	// 			$action_id = 9;
				// 	// 		}
				// 	// 		else{
				// 	// 			$email_template = getemailandpushnotification(32, 1, 1);
				// 	// 			$app_template = getemailandpushnotification(32, 2, 1);
				// 	// 			$action_id = 11;
				// 	// 		}

				// 	// 		if (!empty($email_template)) {
				// 	// 			$body = $email_template['body'];
				// 	// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 			$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 			$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 			$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 	// 			$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 			if ($gender == 2) {
				// 	// 				$g_name = "She";
				// 	// 			}
				// 	// 			else{
				// 	// 				$g_name = "He";
				// 	// 			}
				// 	// 			$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 	// 			emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
				// 	// 		}

				// 	// 		$app_template = getemailandpushnotification(6, 2, 1);
				// 	// 		if (!empty($app_template)) {
				// 	// 			$body = $app_template['body'];
				// 	// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 			$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 			$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 			$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 	// 			$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 			if ($gender == 2) {
				// 	// 				$g_name = "She";
				// 	// 			}
				// 	// 			else{
				// 	// 				$g_name = "He";
				// 	// 			}
				// 	// 			$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 	// 			$title = $app_template['title'];
				// 	// 			$token = $parent_detail[0]->ss_aw_device_token;

				// 	// 			pushnotification($title,$body,$token,8);

				// 	// 			$save_data = array(
				// 	// 				'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 	// 				'user_type' => 1,
				// 	// 				'title' => $title,
				// 	// 				'msg' => $body,
				// 	// 				'status' => 1,
				// 	// 				'read_unread' => 0,
				// 	// 				'action' => 8
				// 	// 			);

				// 	// 			save_notification($save_data);
				// 	// 		}
				// 	// 	$email_template = getemailandpushnotification(6, 1, 1);
				// 	// 	if (!empty($email_template)) {
				// 	// 		$body = $email_template['body'];
				// 	// 		$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 		$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 		$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 		$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 		$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 		$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 		if ($gender == 2) {
				// 	// 			$g_name = "She";
				// 	// 		} else {
				// 	// 			$g_name = "He";
				// 	// 		}
				// 	// 		$body = str_ireplace("[@@gender@@]", $g_name, $body);;
				// 	// 	}

				// 	// 	$app_template = getemailandpushnotification(6, 2, 1);
				// 	// 	if (!empty($app_template)) {
				// 	// 		$body = $app_template['body'];
				// 	// 		$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 		$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 		$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 		$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 		$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 		$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 		if ($gender == 2) {
				// 	// 			$g_name = "She";
				// 	// 		} else {
				// 	// 			$g_name = "He";
				// 	// 		}
				// 	// 		$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 	// 		$title = $app_template['title'];
				// 	// 		$token = $parent_detail[0]->ss_aw_device_token;

				// 	// 		pushnotification($title, $body, $token, 8);

				// 	// 		$save_data = array(
				// 	// 			'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 	// 			'user_type' => 1,
				// 	// 			'title' => $title,
				// 	// 			'msg' => $body,
				// 	// 			'status' => 1,
				// 	// 			'read_unread' => 0,
				// 	// 			'action' => 8
				// 	// 		);

				// 	// 		save_notification($save_data);
				// 	// 	}
				// 	// }
				// }
			}

			redirect('admin/childrendetails/' . $parent_id);
		}
	}

	public function parentdetail()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Parent Details";
		$parent_id = $this->uri->segment(3);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$child_details = $this->ss_aw_childs_model->get_all_child_by_parent($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;

		$check_self_child_registration = $this->ss_aw_childs_model->check_self_registration($parent_id);
		$paymentstatus = array();
		if (!empty($check_self_child_registration)) {
			$self_enrolled = 1;
			$child_id = $check_self_child_registration->ss_aw_child_id;
			$child_course_details = $this->ss_aw_child_course_model->get_details($child_id);
			if (!empty($child_course_details)) {
				if ($child_course_details[count($child_course_details) - 1]['ss_aw_course_payemnt_type'] == 1) {

					$searchary = array(
						'ss_aw_parent_id' => $parent_id,
						'ss_aw_child_id' => $child_id,
						'ss_aw_selected_course_id' => 5
					);

					$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
					$total_complete_emi_count = count($count_previous_emi);
					$paymentstatus['payment_status'] = 2;
					$paymentstatus['emi_count'] = $total_complete_emi_count;
				} else {
					$course_id = $child_course_details[count($child_course_details) - 1]['ss_aw_course_id'];
					$payment_details = $this->ss_aw_purchase_courses_model->checkpaidornot($child_id, $course_id);
					if (!empty($payment_details)) {
						$paymentstatus['payment_status'] = 1;
						$paymentstatus['transaction_id'] = $payment_details[0]->ss_aw_transaction_id;
					} else {
						$paymentstatus['payment_status'] = 0;
					}
				}
			} else {
				$payment_details = $this->ss_aw_purchase_courses_model->checkpaidornot($child_id, 5);
				if (!empty($payment_details)) {
					$paymentstatus['payment_status'] = 1;
					$paymentstatus['transaction_id'] = $payment_details[0]->ss_aw_transaction_id;
				} else {
					$paymentstatus['payment_status'] = 0;
				}
			}
		} else {
			$self_enrolled = 0;
		}

		$data['paymentstatus'] = $paymentstatus;
		$data['self_enrolled'] = $self_enrolled;
		$data['self_child_registration'] = $check_self_child_registration;
		$data['course_id'] = 5;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/parentdetail', $data);
	}

	public function child_course_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Child Course Details";
		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
		if (!empty($diagnostic_exam_code_details)) {
			$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
			$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
			$diagnostic_question_asked = DIAGNOSTIC_QUESTION_NUM;
			$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
		} else {
			$diagnostic_question_asked = 0;
			$diagnostic_question_correct = 0;
		}

		//recommended course suggested course
		$recomended_level = "";
		$searchary = array();
		$searchary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
		$examresultary = array();
		$examresultary = $this->ss_aw_diagonastic_exam_log_model->fetch_record_byparam($searchary);
		$resultcountary = array();
		foreach ($examresultary as $value) {
			if ($value['ss_aw_diagonastic_log_answer_status'] != 3) {
				$resultcountary[$value['ss_aw_diagonastic_log_level']]['total_ask'][] = $value['ss_aw_diagonastic_log_question_id'];
				if ($value['ss_aw_diagonastic_log_answer_status'] == 1)
					$resultcountary[$value['ss_aw_diagonastic_log_level']]['right_ans'][] = $value['ss_aw_diagonastic_log_question_id'];
			}
		}
		$pct_level_e = "";
		$pct_level_c = "";
		$pct_level_a = "";
		if (!empty($resultcountary['E']))
			$pct_level_e  = round((count($resultcountary['E']['right_ans']) / count($resultcountary['E']['total_ask'])) * 100);

		if (!empty($resultcountary['C']))
			$pct_level_c  = round((count($resultcountary['C']['right_ans']) / count($resultcountary['C']['total_ask'])) * 100);

		if (!empty($resultcountary['A']))
			$pct_level_a  = round((count($resultcountary['A']['right_ans']) / count($resultcountary['A']['total_ask'])) * 100);

		/*This Checking for the E level student whose age bellow 13 years */
		if (!empty($resultcountary['E'])) {
			if ($pct_level_e > 80 && $pct_level_c > 70) {
				$recomended_level = 'C';
			} else {
				$recomended_level = 'E';
			}
		}
		/*This Checking for the C level student whose age above 13 years */
		if (!empty($resultcountary['C'])) {
			if ($pct_level_c > 80 && $pct_level_a > 70) {
				$recomended_level = 'A';
			} else if ($pct_level_c < 50) {
				$recomended_level = 'E';
			} else {
				$recomended_level = 'C';
			}
		}
		//end
		$child_enroll_details = $this->ss_aw_child_last_lesson_model->child_enroll_details($child_id);
		$login_details = $this->ss_aw_child_login_model->get_data_by_child($child_id);
		//lesson and assessment topical details
		$completed_topic_details = $this->ss_aw_child_last_lesson_model->getallcompletelessonby_child($child_id);
		$lesson_score = array();
		$assessment_score = array();
		$assessment_id_ary = array();
		if (!empty($completed_topic_details)) {
			foreach ($completed_topic_details as $key => $value) {
				$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $value->ss_aw_lesson_id);
				$lesson_asked = 0;
				$lesson_correct = 0;
				if (!empty($lesson_score_details)) {
					$lesson_asked = $lesson_score_details[0]->total_question;
					$lesson_correct = $lesson_score_details[0]->wright_answers;
				}
				$lesson_score['asked'][$value->ss_aw_lesson_id] = $lesson_asked;
				$lesson_score['correct'][$value->ss_aw_lesson_id] = $lesson_correct;

				//assessment section
				$assessment_id = "";
				$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
				if (!empty($topical_assessment_start_details)) {
					if (!empty($topical_assessment_start_details)) {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($topical_assessment_start_details[0]->ss_aw_created_date));
					} else {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = "NA";
					}

					$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
				} else {
					$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
					if (!empty($comprehension_assessment_start_details)) {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($comprehension_assessment_start_details[0]->ss_aw_created_at));
					} else {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = "NA";
					}

					$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
				}
				$assessment_id_ary[$value->ss_aw_lesson_id] = $assessment_id;
				$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
				$assessment_asked = 0;
				$assessment_correct = 0;
				$assessment_score['exam_completed'][$value->ss_aw_lesson_id] = "NA";
				$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
				if (!empty($assessment_completetion_details)) {
					$assessment_score['exam_completed'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($assessment_completetion_details[0]->ss_aw_create_date));
				}
				if (!empty($assessment_score_details)) {
					$assessment_asked = $assessment_score_details[0]->total_question;
					$assessment_correct = $assessment_score_details[0]->wright_answers;
				}
				$assessment_score['asked'][$value->ss_aw_lesson_id] = $assessment_asked;
				$assessment_score['correct'][$value->ss_aw_lesson_id] = $assessment_correct;
			}
		}
		//end

		//readalong data fetch
		$search_ary = array(
			'ss_aw_child_id' => $child_id,
			'ss_aw_comprehension_read' => 1
		);
		$readalong_lists = $this->ss_aw_schedule_readalong_model->search_byparam($search_ary);
		$readalong_finish = array();
		$readalong_score = array();
		if (!empty($readalong_lists)) {
			foreach ($readalong_lists as $key => $value) {

				$readalong_finish['start_date'][$value['ss_aw_readalong_id']] = "NA";
				$check_store_index = $this->ss_aw_store_readalong_page_model->get_first_start_details($child_id, $value['ss_aw_readalong_id']);
				if (!empty($check_store_index)) {
					$readalong_finish['start_date'][$value['ss_aw_readalong_id']] = date('d/m/Y', strtotime($value['ss_aw_create_date']));
				}
				$check_finish = $this->ss_aw_last_readalong_model->check_readalong_completion($value['ss_aw_readalong_id'], $child_id);
				$readalong_correct = 0;
				$readalong_asked = 0;
				if (!empty($check_finish)) {
					$readalong_finish['complete_date'][$value['ss_aw_readalong_id']] = date('d/m/Y', strtotime($check_finish[0]->ss_aw_create_date));
					$readalong_asked_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id']));
					$readalong_asked = count($readalong_asked_questions);
					$readalong_correct_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id'], 'ss_aw_quiz_right_wrong' => 1));
					$readalong_correct = count($readalong_correct_questions);
				} else {
					$readalong_finish['complete_date'][$value['ss_aw_readalong_id']] = "NA";
				}
				$readalong_score['asked'][$value['ss_aw_readalong_id']] = $readalong_asked;
				$readalong_score['correct'][$value['ss_aw_readalong_id']] = $readalong_correct;
			}
		}
		//end
		//payment details
		$payment_details = $this->ss_aw_child_course_model->get_details($child_id);
		//end
		$data['child_details'] = $child_details;
		$data['login_details'] = $login_details;
		$data['child_enroll_details'] = $child_enroll_details;
		$data['diagnostic_question_asked'] = $diagnostic_question_asked;
		$data['diagnostic_question_correct'] = $diagnostic_question_correct;
		$data['diagnostic_exam_code_details'] = $diagnostic_exam_code_details;
		$data['recomended_level'] = $recomended_level;
		$data['completed_topic_details'] = $completed_topic_details;
		$data['lesson_score'] = $lesson_score;
		$data['assessment_score'] = $assessment_score;
		$data['readalong_lists'] = $readalong_lists;
		$data['readalong_finish'] = $readalong_finish;
		$data['readalong_score'] = $readalong_score;
		$data['payment_details'] = $payment_details;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$data['assessment_id_ary'] = $assessment_id_ary;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/child_course_details', $data);
	}

	/*public function diagnostic_question_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Details";
		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$data = array();

		$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
		$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
		$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
		$asked_question = array();
		if (!empty($diagnostic_question_asked_details)) {
			foreach ($diagnostic_question_asked_details as $key => $value) {
				$asked_question_id = explode(",", $value['ss_aw_diagnostic_id']);
				if (!empty($asked_question_id)) {
					foreach ($asked_question_id as $question_id) {
						if (!empty($question_id)) {
							$asked_question[] = $question_id;
						}
					}
				}
			}
		}
		
		$asked_question_details = $this->ss_aw_assisment_diagnostic_model->get_bulk_questions($asked_question);

		if (!empty($asked_question_details)) {
			foreach ($asked_question_details as $key => $value) {
				$log_details = $this->ss_aw_diagonastic_exam_log_model->get_details_by_exam_code_question_id($value->ss_aw_id, $exam_code);
				if (!empty($log_details)) {
					$value->correct_answer = $log_details->ss_aw_diagonastic_log_right_answers;
					$value->student_answer = $log_details->ss_aw_diagonastic_log_answers;
					$value->answer_status = $log_details->ss_aw_diagonastic_log_answer_status;
				}
				else{
					$value->correct_answer = "";
					$value->student_answer = "";
					$value->answer_status = 2;
				}
			}
		}
		$data['dianostic_details'] = $asked_question_details;
		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/diagnosticdetails', $data);
	}*/

	public function diagnostic_question_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Details";
		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$data = array();

		$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child_log($child_id);

		$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_log_exam_code;
		$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));

		$asked_question = array();
		if (!empty($diagnostic_question_asked_details)) {
			foreach ($diagnostic_question_asked_details as $key => $value) {
				$asked_question_id = explode(",", $value['ss_aw_diagnostic_id']);
				if (!empty($asked_question_id)) {
					foreach ($asked_question_id as $question_id) {
						if (!empty($question_id)) {
							$asked_question[] = $question_id;
						}
					}
				}
			}
		}

		$asked_question_details = $this->ss_aw_assisment_diagnostic_model->get_bulk_questions($asked_question);

		if (!empty($asked_question_details)) {
			foreach ($asked_question_details as $key => $value) {
				$log_details = $this->ss_aw_diagonastic_exam_log_model->get_details_by_exam_code_question_id($value->ss_aw_id, $exam_code);
				if (!empty($log_details)) {
					$value->correct_answer = $log_details->ss_aw_diagonastic_log_right_answers;
					$value->student_answer = $log_details->ss_aw_diagonastic_log_answers;
					$value->answer_status = $log_details->ss_aw_diagonastic_log_answer_status;
				} else {
					$value->correct_answer = "";
					$value->student_answer = "";
					$value->answer_status = 2;
				}
			}
		}
		$data['dianostic_details'] = $asked_question_details;
		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/diagnosticdetails', $data);
	}

	public function lesson_quiz_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Quiz Details";
		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$lesson_id = $this->uri->segment(5);
		$data = array();
		$data['lesson_details'] = $this->ss_aw_lesson_quiz_ans_model->getlessonquizdetails($child_id, $lesson_id);

		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$data['lesson_id'] = $lesson_id;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/lessondetails', $data);
	}

	public function assessment_quiz_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Quiz Details";

		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$assessment_id = $this->uri->segment(5);
		$data = array();
		$data['assessment_details'] = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);

		$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $data['assessment_details'][0]->ss_aw_assessment_id);
		$exam_code = $assessment_score_details[0]->exam_code;
		if ($data['assessment_details'][0]->ss_aw_assesment_format == 'Single') {
			$question_details = $this->ss_aw_assessment_exam_log_model->getdiagnosticexamdetails($child_id, $exam_code);
		} else {
			$question_details = $this->ss_aw_assesment_multiple_question_answer_model->getdiagnosticexamdetails($child_id, $exam_code);
		}

		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$data['assessment_id'] = $assessment_id;
		$data['question_details'] = $question_details;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/assessmentdetails', $data);
	}

	public function readalong_quiz_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Quiz Details";

		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$readalong_id = $this->uri->segment(5);
		$data = array();
		$question_details = $this->ss_aw_readalong_quiz_ans_model->get_quiz_details($child_id, $readalong_id);
		$readalong_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
		$data['question_details'] = $question_details;
		$data['readalong_details'] = $readalong_details;
		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$data['readalong_id'] = $readalong_id;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/readalongdetails', $data);
	}

	public function addrefferal()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage Refferal";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$insert_data = array(
				'ss_aw_title' => $postdata['title'],
				'ss_aw_newsletter_id' => $postdata['newsletter'],
				'ss_aw_coupon_id' => $postdata['coupon']
			);
			$response = $this->ss_aw_refferal_model->save_data($insert_data);
			if ($response) {
				$this->session->set_flashdata('success', 'Record saved succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}

			redirect('admin/addrefferal');
		} else {
			$data = array();
			$data['coupons'] = $this->ss_aw_coupons_model->getalltyperecord();
			$data['newsletter'] = $this->ss_aw_newsletter_model->getallnewsletter();
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/addrefferal', $data);
		}
	}

	public function manage_refferal()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage Refferal";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if (!empty($postdata['delete_record_id'])) {
				$record_id = $postdata['delete_record_id'];
				$response = $this->ss_aw_refferal_model->remove_record($record_id);
				if ($response) {
					$this->session->set_flashdata('success', 'Record saved succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}
			redirect('admin/manage_refferal');
		} else {
			$data = array();
			$total_record = $this->ss_aw_refferal_model->total_record();
			$redirect_to = base_url() . 'admin/managenewsletters';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;', $str_links);
			if ($page >= $config["total_rows"]) {
				$page = 0;
			}
			$result = $this->ss_aw_refferal_model->getlimitedrecord($config['per_page'], $page);
			$data['result'] = $result;
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/manage-refferal', $data);
		}
	}

	public function quiz_upload()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Quiz";
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/quiz');
	}

	public function quiz_answer_upload()
	{
		if ($this->input->post()) {
			$formdata = $this->input->post();

			$img  = $formdata['image'];
			list($width, $height) = getimagesize($img);

			define('UPLOAD_DIR_DOWNLOAD', 'assets/quiz_challange/');

			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = UPLOAD_DIR_DOWNLOAD . uniqid() . time() . '.jpeg';


			/****************************************************************/

			$img_i = $data;
			$im = imagecreatefromstring($img_i);

			$thumb1 = imagecreatetruecolor($width, $height);
			//imageresolution($thumb1, 300,300); // Work on PHP 7.2 or higher
			imagecopyresampled($thumb1, $im, 0, 0, 0, 0, $width, $height, $width, $height);


			//echo $savefile = file_put_contents(uniqid().time() . '.jpeg', $imageConverted);
			imagejpeg($thumb1, $file, 95);
			chmod($file, 0777);

			// echo $file;
			// die();
			$insert_data = array(
				'challange_type' 		=>	$formdata['quiz_type_detail'],
				'challange_name' 		=>	$formdata['upload_quiz_name'],
				'challange_answer' 		=>	$formdata['challange_answer'],
				'challange_hints' 		=>	$formdata['challange_answer_hints'],
				'challange_status' 		=>	1,
				'challange_image' 		=>	$file,
				'challange_post_date'	=>	date('Y-m-d h:i:s')
			);
			echo $response = $this->ss_aw_challange_model->answer_insert($insert_data);
		}
	}

	public function quiz_list()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Quiz List";
		$this->load->view('admin/header', $headerdata);
		$data = array();
		$data['quiz_list_data'] = $this->ss_aw_challange_model->quiz_challange_list();
		$this->load->view('admin/quiz_list', $data);
	}

	public function quiz_list_id_wise_view()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Quiz View";
		$this->load->view('admin/header', $headerdata);
		$quiz_view_id = $this->uri->segment(3);
		$data = array();
		$data['quiz_list_data'] = $this->ss_aw_challange_model->quiz_challange_view($quiz_view_id);
		if ($data['quiz_list_data']->challange_type == 'crossword') {
			$view_name = 'admin/quiz_view';
		} else {
			$view_name = 'admin/hangman_view';
		}
		$data['quiz_templete_data'] = $this->ss_aw_challange_template_model->quiz_challange_template_list();
		$this->load->view($view_name, $data);
	}

	public function delete_quiz()
	{
		$quiz_view_id = $this->input->post('quiz_id');
		$this->ss_aw_challange_model->remove_record($quiz_view_id);
		$this->session->set_userdata('success', 'Record removed succesfully');
		redirect('admin/quiz_list');
	}

	public function quiz_facebook_image_Upload()
	{
		if ($this->input->post()) {
			$formdata = $this->input->post();
			// print_r($formdata['image']);
			// die();
			try {
				$img  = $formdata['image'];
				list($width, $height) = getimagesize($img);

				define('UPLOAD_DIR_DOWNLOAD', 'assets/quiz_facebook_image/');

				$image_parts = explode(";base64,", $img);
				$data = base64_decode($image_parts[1]);
				$file = UPLOAD_DIR_DOWNLOAD . uniqid() . time() . '.jpeg';


				/****************************************************************/

				$img_i = $data;
				$im = imagecreatefromstring($img_i);

				$thumb1 = imagecreatetruecolor($width, $height);
				//imageresolution($thumb1, 300,300); // Work on PHP 7.2 or higher
				imagecopyresampled($thumb1, $im, 0, 0, 0, 0, $width, $height, $width, $height);


				//echo $savefile = file_put_contents(uniqid().time() . '.jpeg', $imageConverted);
				imagejpeg($thumb1, $file, 95);
				chmod($file, 0777);
			} catch (Exception $e) {
				echo 'Message: ' . $e->getMessage();
			}


			// echo $file;
			// die();
			$insert_data = array(
				'challange_facebook_image'	=>	$file,
				'challange_id'				=>	$formdata['quiz_challange_id'],
				'create_date'				=>	date('Y-m-d h:i:s'),
				// 'challange_pub_date'		=>	date('Y-m-d h:i:s')
			);
			$response = $this->ss_aw_challange_facebook_model->quiz_facebook_image_insert($insert_data);

			$fb = new \Facebook\Facebook([
				'app_id' => FACEBOOK_APP_ID,
				'app_secret' => FACEBOOK_APP_SECRET,
				'default_graph_version' => 'v2.10',
				//'default_access_token' => '{access-token}', // optional
			]);

			// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
			//   $helper = $fb->getRedirectLoginHelper();
			//   $helper = $fb->getJavaScriptHelper();
			//   $helper = $fb->getCanvasHelper();
			//   $helper = $fb->getPageTabHelper();

			$pageAccessToken = FACEBOOK_ACCESS_TOKEN;
			// $pageAccessToken = 'EAAKZBTKDDBGwBACc0YZCVpBDcSjZA1rZBXFzhCmyDMt1loG6w6HJGDfJxfNSmwFPzEJ39B8hhDRlOh0KmnLLifeZBkzqA2O8KGZCHg2r55YWgaFIZAYfzWlXnb1ibIAiaKoBmJvZCuvenOxTIYczzKpIkIRYtZBCIpm3KpLNrV62P73zXXEIBXy0kJX3f2NwsbZCPN8ezvgLyEI1IupP719RR0';
			$data = array(
				'source' => $fb->fileToUpload(base_url() . $file)
			);

			try {
				// Get the \Facebook\GraphNodes\GraphUser object for the current user.
				// If you provided a 'default_access_token', the '{access-token}' is optional.
				$response = $fb->post('/me/photos', $data, $pageAccessToken);

				$facebook_publish_date = array(
					// 'challange_id'				=>	$formdata['quiz_challange_id'],
					// 'create_date'				=>	date('Y-m-d h:i:s'),
					'challange_pub_date'		=>	date('Y-m-d h:i:s')
				);
				$pub_response = $this->ss_aw_challange_model->update_answer($facebook_publish_date, $formdata['quiz_challange_id']);
			} catch (\Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch (\Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
		}
	}

	public function update_quiz()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Edit Quiz";
		$quiz_id = $this->uri->segment(3);
		$data = array();
		$quiz_details = $this->ss_aw_challange_model->quiz_challange_view($quiz_id);
		if ($quiz_details->challange_type == 'crossword') {
			$view_name = 'admin/edit_quiz';
		} else {
			$view_name = 'admin/edit_hangman';
		}
		$data['quiz_details'] = $quiz_details;
		$this->load->view('admin/header', $headerdata);
		$this->load->view($view_name, $data);
	}

	public function update_quiz_answer()
	{
		if ($this->input->post()) {
			$formdata = $this->input->post();

			$img  = $formdata['image'];
			list($width, $height) = getimagesize($img);

			define('UPLOAD_DIR_DOWNLOAD', 'assets/quiz_challange/');

			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = UPLOAD_DIR_DOWNLOAD . uniqid() . time() . '.jpeg';


			/****************************************************************/

			$img_i = $data;
			$im = imagecreatefromstring($img_i);

			$thumb1 = imagecreatetruecolor($width, $height);
			//imageresolution($thumb1, 300,300); // Work on PHP 7.2 or higher
			imagecopyresampled($thumb1, $im, 0, 0, 0, 0, $width, $height, $width, $height);


			//echo $savefile = file_put_contents(uniqid().time() . '.jpeg', $imageConverted);
			imagejpeg($thumb1, $file, 95);
			chmod($file, 0777);

			// echo $file;
			// die();
			$update_data = array(
				'challange_type' 		=>	$formdata['quiz_type_detail'],
				'challange_name' 		=>	$formdata['upload_quiz_name'],
				'challange_answer' 		=>	$formdata['challange_answer'],
				'challange_hints' 		=>	$formdata['challange_answer_hints'],
				'challange_status' 		=>	1,
				'challange_image' 		=>	$file,
				'challange_post_date'	=>	date('Y-m-d h:i:s')
			);
			echo $response = $this->ss_aw_challange_model->update_answer($update_data, $formdata['challange_id']);
		}
	}
	public function quiz_answer_id_wise()
	{
		$quiz_last_record_details = $this->ss_aw_challange_model->quiz_challange_list_last_id();
		$last_quiz_id = $quiz_last_record_details[0]->ss_aw_challange_id;

		$quiz_view_id = $this->uri->segment(3);
		$data = array();
		$fetched_challange_id = "";
		if ($quiz_view_id == '') {
			$fetched_challange_id = $last_quiz_id;
			$data['quiz_answer_data'] = $this->ss_aw_challange_model->quiz_challange_view($last_quiz_id);
			$quiz_all_data = $this->ss_aw_challange_model->month_wise_list('crossword');
			$random_token = substr(md5(time()), 0, 20);
			$challange_token = $random_token . "_" . $last_quiz_id;
			$this->session->set_userdata('challange_session', $challange_token);
		} else {
			$fetched_challange_id = $quiz_view_id;
			$data['quiz_answer_data'] = $this->ss_aw_challange_model->quiz_challange_view($quiz_view_id);
			$quiz_all_data = $this->ss_aw_challange_model->month_wise_list('crossword');
			$random_token = substr(md5(time()), 0, 20);
			$challange_token = $random_token . "_" . $quiz_view_id;
			$this->session->set_userdata('challange_session', $challange_token);
		}

		$month_data = array();
		if (!empty($quiz_all_data)) {
			foreach ($quiz_all_data as $value) {
				if (!empty($month_data[date('F Y', strtotime($value->challange_post_date))])) {
					$month_data[date('F Y', strtotime($value->challange_post_date))][] = $value;
				} else {
					$month_data[date('F Y', strtotime($value->challange_post_date))][] = $value;
				}
			}
		}
		$data['month_data'] = $month_data;
		$data['latherboard_list'] = $this->ss_aw_challange_log_model->get_last_week_winners($fetched_challange_id);
		$data['all_latherboard_list'] = $this->ss_aw_challange_log_model->get_latherboard_list($fetched_challange_id);
		$this->load->view('admin/quiz_answer', $data);
	}

	public function quiz_log_upload()
	{
		if ($this->input->post()) {
			$formdata = $this->input->post();

			$insert_data = array(
				'ss_aw_challange_id' 		=>	$formdata['ss_aw_challange_id'],
				'ss_aw_challange_input' 	=>	json_encode($formdata['ss_aw_challange_input']),
				'ss_aw_challange_status' 	=>	$formdata['ss_aw_challange_status'],
				'submit_date'				=>	date('Y-m-d h:i:s')
			);
			echo $response = $this->ss_aw_challange_log_model->answer_log_insert($insert_data);
		}
	}

	public function change_draft_status()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$quiz_id = $postdata['quiz_id'];
			$draft_status = $postdata['draft_status'];
			$update_data = array(
				'is_draft' => $draft_status == 1 ? 0 : 1
			);
			$response = $this->ss_aw_challange_model->update_answer($update_data, $quiz_id);
			if ($response) {
				if ($draft_status == 1) {
					$get_quiz_details = $this->ss_aw_challange_model->quiz_challange_view($quiz_id);
					$notify_users = $this->ss_aw_puzzle_notify_model->get_all_records();
					$email_template = getemailandpushnotification(57, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@puzzle_name@@]", $get_quiz_details->challange_type == 'crossword' ? 'CROSSWISE' : 'WORDWISE', $body);
						$body = str_ireplace("[@@puzzle_url@@]", $get_quiz_details->challange_type == 'crossword' ? 'https://team.com/awadmin/puzzles/crosswise/' : 'https://team.com/awadmin/puzzles/wordwise/', $body);
						if (!empty($notify_users)) {
							foreach ($notify_users as $key => $value) {
								$send_data = array(
									'ss_aw_email' => $value->email,
									'ss_aw_subject' => $email_template['title'],
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);
							}
						}
					}
				}
				$this->session->set_flashdata('success', 'Status changed succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}

		redirect('admin/quiz_list');
	}

	public function like_quiz()
	{
		if ($this->input->post()) {
			$challange_id = $this->input->post('challange_id');
			$response = $this->ss_aw_challange_model->likechallange($challange_id);
			echo $response;
		} else {
			echo 0;
		}
	}

	public function quiz_hangman_answer_id_wise()
	{
		$quiz_last_record_details = $this->ss_aw_challange_model->quiz_challange_hangman_list_last_id();
		$hangman_last_quiz_id = $quiz_last_record_details[0]->ss_aw_challange_id;

		$quiz_view_id = $this->uri->segment(3);

		if ($quiz_view_id == '') {
			$data['quiz_data_details'] = $this->ss_aw_challange_model->quiz_challange_view($hangman_last_quiz_id);
			$quiz_all_data = $this->ss_aw_challange_model->month_wise_list('hangman');
			$random_token = substr(md5(time()), 0, 20);
			$challange_token = $random_token . "_" . $hangman_last_quiz_id;
			$this->session->set_userdata('challange_session', $challange_token);
		} else {
			$data['quiz_data_details'] = $this->ss_aw_challange_model->quiz_challange_view($quiz_view_id);
			$quiz_all_data = $this->ss_aw_challange_model->month_wise_list('hangman');
			$random_token = substr(md5(time()), 0, 20);
			$challange_token = $random_token . "_" . $quiz_view_id;
			$this->session->set_userdata('challange_session', $challange_token);
		}

		// $data['quiz_data_details'] = $this->ss_aw_challange_model->quiz_challange_view($quiz_view_id);
		$data['quiz_url'] = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$quiz_all_data = $this->ss_aw_challange_model->quiz_challange_hangman_view();

		$month_data = array();
		if (!empty($quiz_all_data)) {
			foreach ($quiz_all_data as $value) {
				if (!empty($month_data[date('F Y', strtotime($value->challange_post_date))])) {
					$month_data[date('F Y', strtotime($value->challange_post_date))][] = $value;
				} else {
					$month_data[date('F Y', strtotime($value->challange_post_date))][] = $value;
				}
			}
		}
		$data['month_data'] = $month_data;

		$this->load->view('admin/quiz_answer_hangman', $data);
	}

	public function add_hangman()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Wordwise Upload";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$insert_data = array(
				'challange_type' 		=>	'hangman',
				'challange_name' 		=>	$postdata['quiz_name'],
				'challange_answer' 		=>	$postdata['quiz_answer'],
				'challange_hints' 		=>	$postdata['quiz_hint'],
				'challange_status' 		=>	1,
				'challange_image' 		=>	$postdata['quiz_question'],
				'challange_meaning' 		=>	$postdata['quiz_meaning'],
				'challange_post_date'	=>	date('Y-m-d h:i:s')
			);

			$response = $this->ss_aw_challange_model->answer_insert($insert_data);
			if ($response) {
				$this->session->set_flashdata('success', 'Quiz uploaded succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
			redirect('admin/add_hangman');
		} else {
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/add_hangman');
		}
	}

	public function update_hangman()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$update_data = array(
				'challange_name' 		=>	$postdata['quiz_name'],
				'challange_answer' 		=>	$postdata['quiz_answer'],
				'challange_hints' 		=>	$postdata['quiz_hint'],
				'challange_status' 		=>	1,
				'challange_image' 		=>	$postdata['quiz_question'],
				'challange_meaning' 		=>	$postdata['quiz_meaning'],
				'challange_post_date'	=>	date('Y-m-d h:i:s')
			);

			$response = $this->ss_aw_challange_model->update_answer($update_data, $postdata['record_id']);

			if ($response) {
				$this->session->set_flashdata('success', 'Quiz updated succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
			redirect('admin/update_quiz/' . $postdata['record_id']);
		}
	}

	public function update_challange_log()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if (!empty($postdata['name'])) {
				$challenge_id = $postdata['challange_id'];
				$data = array(
					'ss_aw_participant_name' => $postdata['name']
				);

				$this->ss_aw_challange_log_model->update_log($data, $challenge_id);
			}

			if (!empty($postdata['email'])) {
				$data = array(
					'email' => $postdata['email']
				);

				$this->ss_aw_puzzle_notify_model->add_record($data);
			}

			echo 1;
		} else {
			echo 0;
		}
	}

	public function listenaudio()
	{
		$postdata = $this->input->post();
		if (!empty($postdata)) {
			$delete_file = 'test_voice.mp3';
			if (file_exists($delete_file)) {
				unlink($delete_file);
			}

			$audio_file = "test_voice" . ".mp3";

			$global_audio = $postdata['global_sudio'];
			$pitch = $postdata['pitch'];
			$speed = $postdata['speed'];

			$config_voice_array = array();
			$audio_matrix_ary = array();
			$voice_type = array();
			$audio_matrix_ary = $this->ss_aw_voice_type_matrix_model->get_recordby_id($global_audio);


			$config_voice_array['ss_aw_voice_type'] = $audio_matrix_ary[0]->ss_aw_voice_type;
			$config_voice_array['ss_aw_language_code'] = $audio_matrix_ary[0]->ss_aw_language_code;
			$config_voice_array['ss_aw_c_speed'] = $speed;
			$config_voice_array['ss_aw_c_pitch'] = $pitch;

			$generate_audio_text = "This is a demo text.";
			$this->democreateaudio_fromtext($generate_audio_text, $audio_file, $config_voice_array);
			$num = rand();

			echo base_url() . $audio_file . '?a=' . $num;
		}
	}

	public function getaudiopitchspeed()
	{
		$postdata = $this->input->post();
		$audio_id = $postdata['audio_id'];
		$audio_matrix_ary = $this->ss_aw_voice_type_matrix_model->get_recordby_id($audio_id);
		if (!empty($audio_matrix_ary)) {
			echo json_encode($audio_matrix_ary[0]);
		} else {
			echo "";
		}
	}

	public function add_parent()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$response = $this->ss_aw_parents_model->check_email($email);
			$child_email_response = $this->ss_aw_childs_model->check_email($email);
			if (empty($response) && empty($child_email_response)) {
				$country_id_ary = explode("@", $postdata['country']);
				$country_name = $country_id_ary[1];
				$signupary = array();
				$signupary['ss_aw_parent_full_name'] = $postdata['fullname'];
				$signupary['ss_aw_user_type'] = 1;
				$signupary['ss_aw_parent_email'] = $postdata['email'];
				$password = $postdata['password'];
				$hash_pass = @$this->bcrypt->hash_password($password);
				$signupary['ss_aw_parent_password'] = $hash_pass;
				$signupary['ss_aw_parent_address'] = $postdata['address'];
				$signupary['ss_aw_parent_city'] = $postdata['city'];
				$signupary['ss_aw_parent_state'] = $postdata['state'];
				$signupary['ss_aw_parent_country'] = $country_name;
				$signupary['ss_aw_parent_pincode'] = $postdata['pin'];
				$signupary['ss_aw_is_email_verified'] = 1;
				$userid = $this->ss_aw_parents_model->data_insert($signupary);
				if ($userid) {
					$email_template = getemailandpushnotification(1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@password@@]", $password, $body);
						$body = str_ireplace("[@@email@@]", $signupary['ss_aw_parent_email'], $body);
						$body = str_ireplace("[@@username@@]", $signupary['ss_aw_parent_full_name'], $body);
						emailnotification($signupary['ss_aw_parent_email'], $email_template['title'], $body);
					}

					$this->session->set_flashdata('success', 'Parent added succesfully.');
				} else {
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			} else {
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1012');
				$msg = $error_array[0]->ss_aw_error_msg;
				$this->session->set_flashdata('error', $msg);
			}
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
		}

		redirect('admin/manageparents');
	}

	public function add_child()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$parent_id = $postdata['parent_id'];
			$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			$check_in_parent = $this->ss_aw_parents_model->check_in_parent($parent_id, trim($postdata['email']));

			$check_in_child = $this->ss_aw_childs_model->check_in_child($parent_id, trim($postdata['email']));
			if ($check_in_parent == 0 && $check_in_child == 0) {
				$child_count = $this->ss_aw_childs_model->check_child_count($parent_id);
				$child_dob = $postdata['date_of_birth'];
				$age = calculate_age($child_dob); // Call Helper calculate_age() function to calculate AGE
				$child_username = $postdata['userid'];
				$check_username = $this->ss_aw_childs_model->check_username($child_username);
				$check_temp_username = $this->ss_aw_childs_temp_model->check_username($child_username);
				if ($check_username == 0 && $check_temp_username == 0) {
					$code_check = $this->ss_aw_childs_model->child_code_check();
					if (isset($code_check)) {
						$random_code = $code_check->ss_aw_child_code + 1;
					} else {
						$random_code =  10000001;
					}
					$child_code = $random_code;
					if ($age >= 10 && $age <= 19) {
						$check_firstchild_array = $this->ss_aw_childs_model->first_child($parent_id);

						if (isset($check_firstchild_array)) {

							if ($child_count == 2) {
								$first_child_dob = $check_firstchild_array->ss_aw_child_dob;
								$current_child_dob = $postdata['date_of_birth'];
								$date1 = date_create($first_child_dob);
								$date2 = date_create($current_child_dob);
								$diff = date_diff($date1, $date2);
								$year_gap = floor($diff->format("%a") / 365);

								if ($year_gap < 2) {
									$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1023');
									$msg = $error_array[0]->ss_aw_error_msg;
									$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
								} else {
									$child_password = $postdata['password'];
									$hash_pass = @$this->bcrypt->hash_password($child_password);
									$child_data['ss_aw_child_code'] = $child_code;
									$child_data['ss_aw_parent_id'] = $parent_id;
									$child_data['ss_aw_child_nick_name'] = $postdata['firstname'] . " " . $postdata['lastname'];
									$child_data['ss_aw_child_dob'] = $postdata['date_of_birth'];
									$child_data['ss_aw_child_age'] = $age;
									$child_data['ss_aw_child_email'] = $postdata['email'];
									$child_data['ss_aw_child_password'] = $hash_pass;
									$child_data['ss_aw_child_username'] = $child_username;
									$child_data['ss_aw_child_gender'] = $postdata['rad_gender'];
									$result = $this->ss_aw_childs_model->add_child($child_data);
									$this->session->set_flashdata('success', 'Child added succesfully.');
								}
							} else {
								$child_password = $postdata['password'];
								$hash_pass = $this->bcrypt->hash_password($child_password);
								$child_data['ss_aw_child_code'] = $child_code;
								$child_data['ss_aw_parent_id'] = $parent_id;
								$child_data['ss_aw_child_nick_name'] = $postdata['firstname'] . " " . $postdata['lastname'];
								$child_data['ss_aw_child_dob'] = $postdata['date_of_birth'];
								$child_data['ss_aw_child_age'] = $age;
								$child_data['ss_aw_child_email'] = $postdata['email'];
								$child_data['ss_aw_child_password'] = $hash_pass;
								$child_data['ss_aw_child_username'] = $child_username;
								$child_data['ss_aw_child_gender'] = $postdata['rad_gender'];
								$result = $this->ss_aw_childs_model->add_child($child_data);
								$this->session->set_flashdata('success', 'Child added succesfully.');
							}
						} else {
							$child_password = $postdata['password'];
							$hash_pass = $this->bcrypt->hash_password($child_password);
							$child_data['ss_aw_child_code'] = $child_code;
							$child_data['ss_aw_parent_id'] = $parent_id;
							$child_data['ss_aw_child_nick_name'] = $postdata['firstname'] . " " . $postdata['lastname'];
							$child_data['ss_aw_child_dob'] = $postdata['date_of_birth'];
							$child_data['ss_aw_child_age'] = $age;
							$child_data['ss_aw_child_email'] = $postdata['email'];
							$child_data['ss_aw_child_password'] = $hash_pass;
							$child_data['ss_aw_child_username'] = $child_username;
							$child_data['ss_aw_child_gender'] = $postdata['rad_gender'];
							$result = $this->ss_aw_childs_model->add_child($child_data);
							$this->session->set_flashdata('success', 'Child added succesfully.');
						}
					} else {
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1024');
						$msg = $error_array[0]->ss_aw_error_msg;
						$this->session->set_flashdata('error', $msg);
					}
				} else {
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1037');
					$msg = $error_array[0]->ss_aw_error_msg;
					$this->session->set_flashdata('error', $msg);
				}
			} else {
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1036');
				$msg = $error_array[0]->ss_aw_error_msg;
				$this->session->set_flashdata('error', $msg);
			}
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
		}

		redirect('admin/parentdetail/' . $parent_id);
	}

	public function getstates()
	{
		$country_id_ary = explode("@", $this->input->post('countryId'));
		$country_id = $country_id_ary[0];
		$result = $this->ss_aw_states_model->get_record_by_country($country_id);
		echo json_encode($result);
	}

	public function mark_payment_for_masters()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$course_id = 5;
			$transaction_id = $postdata['transaction_id'];
			$payment_amount = $postdata['payment_amount'];
			$parent_id = $postdata['payment_parent_id'];
			if ($transaction_id == "" && $payment_amount == "") {
				$this->session->set_flashdata('error', 'Please enter Transaction ID & Payment Amount.');
				redirect('admin/parentdetail/' . $parent_id);
			}
			$check_self_registration = $this->ss_aw_childs_model->check_self_registration($parent_id);
			if (!empty($check_self_registration)) {
				$child_id = $check_self_registration->ss_aw_child_id;
			} else {
				$profile_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
				$code_check = $this->ss_aw_childs_model->child_code_check();
				if (isset($code_check)) {
					$random_code = $code_check->ss_aw_child_code + 1;
				} else {
					$random_code =  10000002;
				}

				$child_code = $random_code;

				$child_data = array();
				$child_data['ss_aw_child_code'] = $child_code;
				$child_data['ss_aw_parent_id'] = $parent_id;
				$child_data['ss_aw_child_nick_name'] = $profile_details[0]->ss_aw_parent_full_name;
				$current_date = date('Y-m-d');
				$child_data['ss_aw_child_dob'] = date('Y-m-d', strtotime($current_date . " -18 years"));
				$child_data['ss_aw_child_age'] = calculate_age($child_data['ss_aw_child_dob']);
				$child_data['ss_aw_child_email'] = $profile_details[0]->ss_aw_parent_email;
				$child_data['ss_aw_child_password'] = $profile_details[0]->ss_aw_parent_password;
				$child_data['ss_aw_device_token'] = $profile_details[0]->ss_aw_device_token;
				$child_data['ss_aw_is_self'] = 1;
				$child_id = $this->ss_aw_childs_model->add_child($child_data);
			}
			if (empty($postdata['emi_payment'])) {
				$postdata['emi_payment'] = 0;
			}
			$invoice_prefix = "ALWS/";
			$invoice_suffix = "/" . date('m') . date('y');
			$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
			if (!empty($get_last_invoice_details)) {
				$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
				if (!empty($invoice_ary)) {
					if (!empty($invoice_ary[1])) {
						if (is_numeric($invoice_ary[1])) {
							$suffix_num = (int)$invoice_ary[1] + 1;
							$invoice_no = $invoice_prefix . $suffix_num;
						} else {
							$invoice_no = $invoice_prefix . "100001";
						}
					} else {
						$invoice_no = $invoice_prefix . "100001";
					}
				} else {
					$invoice_no = $invoice_prefix . "100001";
				}
			} else {
				$invoice_no = $invoice_prefix . "100001";
			}
			$invoice_no = $invoice_no . $invoice_suffix;
			$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			$searary = array();
			$searary['ss_aw_course_id'] = $course_id;
			$courseary_details = $this->ss_aw_courses_model->search_byparam($searary);

			$discount_amount = 0;
			$gst_rate = ($payment_amount * 18) / 100;
			$coupon_id = 0;
			if (!empty($courseary_details)) {
				$data = array();
				$data['transaction_id'] = $transaction_id;
				$data['payment_amount'] = $payment_amount;
				$data['course_id'] = $course_id;
				$data['invoice_no'] = $invoice_no;
				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
				$data['parent_details'] = $parent_detail;
				$data['discount_amount'] = $discount_amount;
				$data['gst_rate'] = $gst_rate;
				$data['coupon_id'] = $coupon_id;
				$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => $course_id));
				$data['payment_type'] = $postdata['emi_payment'];
				$this->load->library('pdf');
				$html = $this->load->view('pdf/paymentinvoice', $data, true);

				$filename = time() . rand() . "_" . $child_id . ".pdf";
				$save_file_path = "./payment_invoice/" . $filename;
				$this->pdf->createPDF($save_file_path, $html, $filename, false);

				$this->db->trans_start();
				$searary = array();
				$searary['ss_aw_parent_id'] = $parent_id;
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_selected_course_id'] = $course_id;
				$searary['ss_aw_transaction_id'] = $transaction_id;
				$searary['ss_aw_course_payment'] = $payment_amount;
				$searary['ss_aw_invoice'] = $filename;
				$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
				$searary = array();
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_course_id'] = $course_id;
				if ($postdata['emi_payment']) {
					$searary['ss_aw_course_payemnt_type'] = 1;
				}

				$courseary = $this->ss_aw_child_course_model->data_insert($searary);

				//update parent user type
				$updated_user_type = 4;
				$check_self_enrolled = $this->ss_aw_childs_model->get_all_child_by_parent($parent_id);
				if (!empty($check_self_enrolled)) {
					$updated_user_type = 5;
				}

				$parent_data = array(
					'ss_aw_user_type' => $updated_user_type
				);
				$this->ss_aw_parents_model->update_parent_details($parent_data, $parent_id);
				//end

				$searary = array();
				$discount_amount = 0;
				$searary['ss_aw_parent_id'] = $parent_id;
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_payment_invoice'] = $invoice_no;
				$searary['ss_aw_transaction_id'] = $transaction_id;
				$searary['ss_aw_payment_amount'] = $payment_amount;
				$searary['ss_aw_gst_rate'] = $courseary_details[0]['ss_aw_gst_rate'];
				$searary['ss_aw_discount_amount'] = $discount_amount;
				$courseary = $this->ss_aw_payment_details_model->data_insert($searary);

				//revenue mis data store
				$invoice_amount = $payment_amount - $gst_rate;
				$reporting_collection_data = array(
					'ss_aw_parent_id' => $parent_id,
					'ss_aw_bill_no' => $invoice_no,
					'ss_aw_course_id' => $course_id,
					'ss_aw_invoice_amount' => round($invoice_amount,2),
					'ss_aw_discount_amount' => round($discount_amount,2),
					'ss_aw_payment_type' => $postdata['emi_payment']
				);

				$resporting_collection_insertion = $this->ss_aw_reporting_collection_model->store_data($reporting_collection_data);
				if ($resporting_collection_insertion) {
					if ($inputpost['emi_payment']) {
						if ($inputpost['promoted']) {
							if ($course_id == 2) {
								$previous_course_id = 1;
								$promoted_course_duration = 175;
								$previous_course_duration = 105;
							} elseif ($course_id == 3) {
								$previous_course_id = 2;
								$promoted_course_duration = 210;
								$previous_course_duration = 175;
							}

							//remove previous revenue records
							$current_month = date('m');
							$this->ss_aw_reporting_revenue_model->removerecordfrommonth($current_month, $previous_course_id, $parent_id);
							//end

							//get previous collection data
							$reporting_collection_details = $this->ss_aw_reporting_collection_model->getlastemicollection($previous_course_id, $parent_id);
							$previous_invoice_amount = $reporting_collection_details[0]->ss_aw_invoice_amount;
							//get previous emi revenue
							$reporting_revenue_details = $this->ss_aw_reporting_revenue_model->getlastemirevenue($parent_id);
							$last_emi_revenue = $reporting_revenue_details[0]->ss_aw_invoice_amount;
							$revenue_invoice_amount = $previous_invoice_amount - $last_emi_revenue;
							$today_date = date('Y') . "-" . date('m') . "-01";
							//first insertion
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $previous_course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => 0,
								'ss_aw_payment_type' => $postdata['emi_payment']
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

							//second insertion
							$today_date = new DateTime();
							$today_date->format('Y-m-d');
							$day = $today_date->format('j');
							$today_date->modify('first day of + ' . $count . ' month');
							$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
							$today_date = $today_date->format('Y-m-d');

							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							$revenue_invoice_amount = ($previous_invoice_amount / $days_current_month) * $remaing_days;

							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => 0,
								'ss_aw_payment_type' => $postdata['emi_payment'],
								'ss_aw_advance' => 1
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
						} else {
							$today_date = date('Y-m-d');
							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							$revenue_invoice_amount = ($invoice_amount / $days_current_month) * $remaing_days;

							//for the first insertion
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => $remaing_days,
								'ss_aw_payment_type' => $postdata['emi_payment']
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

							//for the second insertion
							$remaing_amount = $invoice_amount - $revenue_invoice_amount;
							if ($remaing_amount > 0) {
								$today_date = new DateTime();
								$today_date->format('Y-m-d');
								$day = $today_date->format('j');
								$today_date->modify('first day of + 1 month');
								$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
								$today_date = $today_date->format('Y-m-d');

								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today_date = $year . "-" . $month . "-01";
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($remaing_amount,2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $postdata['emi_payment'],
									'ss_aw_advance' => 1
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							}
						}
					} else {
						if (!empty($inputpost['promoted'])) {
							if ($course_id == 2) {
								$previous_course_id = 1;
								$promoted_course_duration = 175;
								$previous_course_duration = 105;
							} elseif ($course_id == 3) {
								$previous_course_id = 2;
								$promoted_course_duration = 210;
								$previous_course_duration = 175;
							}

							//remove previous revenue records
							$current_month = date('m');
							$this->ss_aw_reporting_revenue_model->removerecordfrommonth($current_month, $previous_course_id, $parent_id);
							//end
							$today_date = date('Y-m-d');
							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							//get previous collection details
							$reporting_collection_details = $this->ss_aw_reporting_collection_model->getdatabylevel($previous_course_id, $parent_id);
							$previous_invoice_amount = $reporting_collection_details[0]->ss_aw_invoice_amount;
							$sum_of_reporting_collection = $previous_invoice_amount + round($invoice_amount);
							//end
							$first_revenue_amount = ($previous_invoice_amount / $previous_course_duration) * $today;

							// Store first revenue record
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $previous_course_id,
								'ss_aw_invoice_amount' => round($first_revenue_amount,2),
								'ss_aw_discount_amount' => round($discount_amount,2),
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => $today,
								'ss_aw_payment_type' => $postdata['emi_payment']
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							//e

							$previous_level_details = $this->ss_aw_reporting_revenue_model->getpreviousleveldaycount($previous_course_id, $parent_id);
							if (!empty($previous_level_details)) {
								$previous_level_count_day = $previous_level_details[0]->previous_level_count;
							} else {
								$previous_level_count_day = 0;
							}

							$course_duration = $promoted_course_duration - $previous_level_count_day;
							$count = 0;
							while ($course_duration != 0) {
								if ($count == 0) {
									$advance_payment = 0;
									$reporting_revenue_details = $this->ss_aw_reporting_revenue_model->getdatauptomonth($course_id, $current_month, $parent_id);
									$sum_of_reporting_revenue = $reporting_revenue_details[0]->invoice_amount;
									$sum_of_revenue_count_days = $reporting_revenue_details[0]->revenue_count_days;
									$substraction_revenue = $sum_of_reporting_collection - $sum_of_reporting_revenue;
									$second_revenue_amount = (($substraction_revenue) / ($promoted_course_duration - $sum_of_revenue_count_days)) * $remaing_days;

									//for the first insertion
									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($second_revenue_amount,2),
										'ss_aw_discount_amount' => 0,
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => $postdata['emi_payment']
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								} else {
									$advance_payment = 1;
									$today_date = date('Y-m-d');
									$today_date = date('Y-m-d', strtotime($today_date . ' + ' . $count . ' month'));
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = 0;
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
									$today_date = $year . "-" . $month . "-01";

									if ($remaing_days > $course_duration) {
										$remaing_days = $course_duration;
										$course_duration = 0;
									} else {
										$course_duration = $course_duration - $remaing_days;
									}

									$reporting_revenue_details = $this->ss_aw_reporting_revenue_model->getdatauptomonth($course_id, $current_month, $parent_id);
									$sum_of_reporting_revenue = $reporting_revenue_details[0]->invoice_amount;
									$sum_of_revenue_count_days = $reporting_revenue_details[0]->revenue_count_days;
									$substraction_revenue = $sum_of_reporting_collection - $sum_of_reporting_revenue;
									$second_revenue_amount = (($substraction_revenue) / ($promoted_course_duration - $sum_of_revenue_count_days)) * $remaing_days;

									//for the first insertion
									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($second_revenue_amount,2),
										'ss_aw_discount_amount' => 0,
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => $postdata['emi_payment'],
										'ss_aw_advance' => $advance_payment
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								}
								$count++;
							}
						} else {
							if ($course_id == 1 || $course_id == 2) {
								$fixed_course_duration = WINNERS_DURATION;
								$course_duration = WINNERS_DURATION;
							} elseif ($course_id == 3) {
								$fixed_course_duration = CHAMPIONS_DURATION;
								$course_duration = CHAMPIONS_DURATION;
							} else {
								$fixed_course_duration = MASTERS_DURATION;
								$course_duration = MASTERS_DURATION;
							}

							$today = date('d');

							$count = 0;
							while ($course_duration != 0) {
								if ($count == 0) {
									$advance_payment = 0;
									$today_date = date('Y-m-d');
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = date('d');
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
								} else {
									$advance_payment = 1;
									$today_date = new DateTime();
									$today_date->format('Y-m-d');
									$day = $today_date->format('j');
									$today_date->modify('first day of + ' . $count . ' month');
									$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
									$today_date = $today_date->format('Y-m-d');

									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = 0;
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
									$today_date = $year . "-" . $month . "-01";
								}

								if ($remaing_days > $course_duration) {
									$remaing_days = $course_duration;
									$course_duration = 0;
								} else {
									$course_duration = $course_duration - $remaing_days;
								}

								$revenue_invoice_amount = ($invoice_amount / $fixed_course_duration) * $remaing_days;
								$revenue_discount_amount = 0;
								if ($discount_amount > 0) {
									$revenue_discount_amount = ($discount_amount / $fixed_course_duration) * $remaing_days;
								}

								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
									'ss_aw_discount_amount' => round($revenue_discount_amount,2),
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $remaing_days,
									'ss_aw_payment_type' => $postdata['emi_payment'],
									'ss_aw_advance' => $advance_payment
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

								$count++;
							}
						}
					}
				}
				//end

				$this->db->trans_complete();

				$this->session->set_flashdata('success', 'Marked as paid succesfully.');

				// if (empty($inputpost['promoted'])) {
				// 	$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);
				// 	$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

				// 	//send notification code
				// 	if ($course_id == 1 || $course_id == 2) {
				// 		$course_name = "Winners";
				// 	}
				// 	elseif($course_id == 3){
				// 		$course_name = "Champions";
				// 	}
				// 	else{
				// 		$course_name = "Masters";
				// 	}

				// 	if (!empty($child_details)) {
				// 		if ($course_id == 1 || $course_id == 2) {
				// 			$email_template = getemailandpushnotification(7, 1, 2);
				// 			$app_template = getemailandpushnotification(7, 2, 2);
				// 			$action_id = 9;
				// 		}
				// 		elseif($course_id == 3){
				// 			$email_template = getemailandpushnotification(32, 1, 2);
				// 			$app_template = getemailandpushnotification(32, 2, 2);
				// 			$action_id = 11;
				// 		}
				// 		else{
				// 			$email_template = getemailandpushnotification(33, 1, 2);
				// 			$app_template = getemailandpushnotification(33, 2, 2);
				// 			$action_id = 11;
				// 		}

				// 		$month_date = date('d/m/Y');
				// 		if (!empty($email_template)) {
				// 			$body = $email_template['body'];
				// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 			$body = str_ireplace("[@@month_date@@]", $month_date, $body);
				// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 			emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
				// 		}

				// 		if (!empty($app_template)) {
				// 			$body = $app_template['body'];
				// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 			$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 			$body = str_ireplace("[@@month_date@@]", $month_date, $body);
				// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 			$title = $app_template['title'];
				// 			$token = $child_details[0]->ss_aw_device_token;

				// 			pushnotification($title, $body, $token, $action_id);

				// 			$save_data = array(
				// 				'user_id' => $child_details[0]->ss_aw_child_id,
				// 				'user_type' => 2,
				// 				'title' => $title,
				// 				'msg' => $body,
				// 				'status' => 1,
				// 				'read_unread' => 0,
				// 				'action' => $action_id
				// 			);

				// 			save_notification($save_data);
				// 		}

				// 		$this->ss_aw_childs_model->logout($child_details[0]->ss_aw_child_id);
				// 	}

				// 	if (empty($child_details[0]->ss_aw_child_username)) {
				// 			//payment confirmation email notification.
				// 				$email_template = getemailandpushnotification(59, 1, 1);
				// 				if (!empty($email_template)) {
				// 					$body = $email_template['body'];
				// 					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 					$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 					$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 					$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 					$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 					$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
				// 					$gender = $child_details[0]->ss_aw_child_gender;
				// 					if ($gender == 2) {
				// 						$g_name = "She";
				// 					}
				// 					else{
				// 						$g_name = "He";
				// 					}
				// 					$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 					emailnotification($parent_detail[0]->ss_aw_parent_email, 'Payment Confirmation', $body);
				// 				}

				// 				$app_template = getemailandpushnotification(59, 2, 1);
				// 				if (!empty($app_template)) {
				// 					$body = $app_template['body'];
				// 					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 					$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 					$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 					$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 					$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 					$gender = $child_details[0]->ss_aw_child_gender;
				// 					if ($gender == 2) {
				// 						$g_name = "She";
				// 					}
				// 					else{
				// 						$g_name = "He";
				// 					}
				// 					$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 					$title = 'Payment Confirmation';
				// 					$token = $parent_detail[0]->ss_aw_device_token;

				// 					pushnotification($title,$body,$token,8);

				// 					$save_data = array(
				// 						'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 						'user_type' => 1,
				// 						'title' => $title,
				// 						'msg' => $body,
				// 						'status' => 1,
				// 						'read_unread' => 0,
				// 						'action' => 8
				// 					);

				// 					save_notification($save_data);
				// 				}	
				// 		}
				// 		else{
				// 			//payment confirmation email notification.
				// 			$email_template = getemailandpushnotification(6, 1, 1);
				// 			if (!empty($email_template)) {
				// 				$body = $email_template['body'];
				// 				$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 				$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 				$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 				$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 				$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
				// 				$gender = $child_details[0]->ss_aw_child_gender;
				// 				if ($gender == 2) {
				// 					$g_name = "She";
				// 				}
				// 				else{
				// 					$g_name = "He";
				// 				}
				// 				$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 				emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
				// 			}

				// 			$app_template = getemailandpushnotification(6, 2, 1);
				// 			if (!empty($app_template)) {
				// 				$body = $app_template['body'];
				// 				$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 				$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 				$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 				$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 				$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 				$gender = $child_details[0]->ss_aw_child_gender;
				// 				if ($gender == 2) {
				// 					$g_name = "She";
				// 				}
				// 				else{
				// 					$g_name = "He";
				// 				}
				// 				$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 				$title = $app_template['title'];
				// 				$token = $parent_detail[0]->ss_aw_device_token;

				// 				pushnotification($title,$body,$token,8);

				// 				$save_data = array(
				// 					'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 					'user_type' => 1,
				// 					'title' => $title,
				// 					'msg' => $body,
				// 					'status' => 1,
				// 					'read_unread' => 0,
				// 					'action' => 8
				// 				);

				// 				save_notification($save_data);
				// 			}
				// 		}

				// 	// if (!empty($parent_detail)) {
				// 	// 	if ($course_id == 1 || $course_id == 2) {
				// 	// 			$email_template = getemailandpushnotification(7, 1, 1);
				// 	// 			$app_template = getemailandpushnotification(7, 2, 1);
				// 	// 			$action_id = 9;
				// 	// 		}
				// 	// 		else{
				// 	// 			$email_template = getemailandpushnotification(32, 1, 1);
				// 	// 			$app_template = getemailandpushnotification(32, 2, 1);
				// 	// 			$action_id = 11;
				// 	// 		}

				// 	// 		if (!empty($email_template)) {
				// 	// 			$body = $email_template['body'];
				// 	// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 			$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 			$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 			$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 	// 			$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 			if ($gender == 2) {
				// 	// 				$g_name = "She";
				// 	// 			}
				// 	// 			else{
				// 	// 				$g_name = "He";
				// 	// 			}
				// 	// 			$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 	// 			emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
				// 	// 		}

				// 	// 		$app_template = getemailandpushnotification(6, 2, 1);
				// 	// 		if (!empty($app_template)) {
				// 	// 			$body = $app_template['body'];
				// 	// 			$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 			$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 			$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 			$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 			$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 			$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
				// 	// 			$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 			if ($gender == 2) {
				// 	// 				$g_name = "She";
				// 	// 			}
				// 	// 			else{
				// 	// 				$g_name = "He";
				// 	// 			}
				// 	// 			$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 	// 			$title = $app_template['title'];
				// 	// 			$token = $parent_detail[0]->ss_aw_device_token;

				// 	// 			pushnotification($title,$body,$token,8);

				// 	// 			$save_data = array(
				// 	// 				'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 	// 				'user_type' => 1,
				// 	// 				'title' => $title,
				// 	// 				'msg' => $body,
				// 	// 				'status' => 1,
				// 	// 				'read_unread' => 0,
				// 	// 				'action' => 8
				// 	// 			);

				// 	// 			save_notification($save_data);
				// 	// 		}
				// 	// 	$email_template = getemailandpushnotification(6, 1, 1);
				// 	// 	if (!empty($email_template)) {
				// 	// 		$body = $email_template['body'];
				// 	// 		$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 		$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 		$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 		$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 		$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 		$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 		if ($gender == 2) {
				// 	// 			$g_name = "She";
				// 	// 		} else {
				// 	// 			$g_name = "He";
				// 	// 		}
				// 	// 		$body = str_ireplace("[@@gender@@]", $g_name, $body);;
				// 	// 	}

				// 	// 	$app_template = getemailandpushnotification(6, 2, 1);
				// 	// 	if (!empty($app_template)) {
				// 	// 		$body = $app_template['body'];
				// 	// 		$body = str_ireplace("[@@course_name@@]", $course_name, $body);
				// 	// 		$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
				// 	// 		$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
				// 	// 		$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
				// 	// 		$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
				// 	// 		$gender = $child_details[0]->ss_aw_child_gender;
				// 	// 		if ($gender == 2) {
				// 	// 			$g_name = "She";
				// 	// 		} else {
				// 	// 			$g_name = "He";
				// 	// 		}
				// 	// 		$body = str_ireplace("[@@gender@@]", $g_name, $body);
				// 	// 		$title = $app_template['title'];
				// 	// 		$token = $parent_detail[0]->ss_aw_device_token;

				// 	// 		pushnotification($title, $body, $token, 8);

				// 	// 		$save_data = array(
				// 	// 			'user_id' => $parent_detail[0]->ss_aw_parent_id,
				// 	// 			'user_type' => 1,
				// 	// 			'title' => $title,
				// 	// 			'msg' => $body,
				// 	// 			'status' => 1,
				// 	// 			'read_unread' => 0,
				// 	// 			'action' => 8
				// 	// 		);

				// 	// 		save_notification($save_data);
				// 	// 	}
				// 	// }
				// }
			}

			redirect('admin/parentdetail/' . $parent_id);
		}
	}

	public function self_course_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Child Course Details";
		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
		if (!empty($diagnostic_exam_code_details)) {
			$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
			$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
			$diagnostic_question_asked = DIAGNOSTIC_QUESTION_NUM;
			$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
		} else {
			$diagnostic_question_asked = 0;
			$diagnostic_question_correct = 0;
		}

		$child_enroll_details = $this->ss_aw_child_last_lesson_model->child_enroll_details($child_id);
		$login_details = $this->ss_aw_child_login_model->get_data_by_child($child_id);
		//lesson and assessment topical details
		$completed_topic_details = $this->ss_aw_child_last_lesson_model->getallcompletelessonby_child($child_id);
		$lesson_score = array();
		$assessment_score = array();
		$assessment_id_ary = array();
		if (!empty($completed_topic_details)) {
			foreach ($completed_topic_details as $key => $value) {
				$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $value->ss_aw_lesson_id);
				$lesson_asked = 0;
				$lesson_correct = 0;
				if (!empty($lesson_score_details)) {
					$lesson_asked = $lesson_score_details[0]->total_question;
					$lesson_correct = $lesson_score_details[0]->wright_answers;
				}
				$lesson_score['asked'][$value->ss_aw_lesson_id] = $lesson_asked;
				$lesson_score['correct'][$value->ss_aw_lesson_id] = $lesson_correct;

				//assessment section
				//assessment section
				$assessment_id = "";
				$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
				if (!empty($topical_assessment_start_details)) {
					if (!empty($topical_assessment_start_details)) {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($topical_assessment_start_details[0]->ss_aw_created_date));
					} else {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = "NA";
					}

					$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
				} else {
					$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
					if (!empty($comprehension_assessment_start_details)) {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($comprehension_assessment_start_details[0]->ss_aw_created_at));
					} else {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = "NA";
					}

					$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
				}
				$assessment_id_ary[$value->ss_aw_lesson_id] = $assessment_id;
				$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
				$assessment_asked = 0;
				$assessment_correct = 0;
				$assessment_score['exam_completed'][$value->ss_aw_lesson_id] = "NA";
				$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
				if (!empty($assessment_completetion_details)) {
					$assessment_score['exam_completed'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($assessment_completetion_details[0]->ss_aw_create_date));
				}
				if (!empty($assessment_score_details)) {
					$assessment_asked = $assessment_score_details[0]->total_question;
					$assessment_correct = $assessment_score_details[0]->wright_answers;
				}
				$assessment_score['asked'][$value->ss_aw_lesson_id] = $assessment_asked;
				$assessment_score['correct'][$value->ss_aw_lesson_id] = $assessment_correct;
			}
		}
		//end

		//readalong data fetch
		$search_ary = array(
			'ss_aw_child_id' => $child_id,
			'ss_aw_comprehension_read' => 1
		);
		$readalong_lists = $this->ss_aw_schedule_readalong_model->search_byparam($search_ary);
		$readalong_finish = array();
		$readalong_score = array();
		if (!empty($readalong_lists)) {
			foreach ($readalong_lists as $key => $value) {

				$readalong_finish['start_date'][$value['ss_aw_readalong_id']] = "NA";
				$check_store_index = $this->ss_aw_store_readalong_page_model->get_first_start_details($child_id, $value['ss_aw_readalong_id']);
				if (!empty($check_store_index)) {
					$readalong_finish['start_date'][$value['ss_aw_readalong_id']] = date('d/m/Y', strtotime($value['ss_aw_create_date']));
				}
				$check_finish = $this->ss_aw_last_readalong_model->check_readalong_completion($value['ss_aw_readalong_id'], $child_id);
				$readalong_correct = 0;
				$readalong_asked = 0;
				if (!empty($check_finish)) {
					$readalong_finish['complete_date'][$value['ss_aw_readalong_id']] = date('d/m/Y', strtotime($check_finish[0]->ss_aw_create_date));
					$readalong_asked_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id']));
					$readalong_asked = count($readalong_asked_questions);
					$readalong_correct_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id'], 'ss_aw_quiz_right_wrong' => 1));
					$readalong_correct = count($readalong_correct_questions);
				} else {
					$readalong_finish['complete_date'][$value['ss_aw_readalong_id']] = "NA";
				}
				$readalong_score['asked'][$value['ss_aw_readalong_id']] = $readalong_asked;
				$readalong_score['correct'][$value['ss_aw_readalong_id']] = $readalong_correct;
			}
		}
		//end
		//payment details
		$payment_details = $this->ss_aw_child_course_model->get_details($child_id);
		//end
		$data['child_details'] = $child_details;
		$data['login_details'] = $login_details;
		$data['child_enroll_details'] = $child_enroll_details;
		$data['diagnostic_question_asked'] = $diagnostic_question_asked;
		$data['diagnostic_question_correct'] = $diagnostic_question_correct;
		$data['diagnostic_exam_code_details'] = $diagnostic_exam_code_details;
		$data['completed_topic_details'] = $completed_topic_details;
		$data['lesson_score'] = $lesson_score;
		$data['assessment_score'] = $assessment_score;
		$data['readalong_lists'] = $readalong_lists;
		$data['readalong_finish'] = $readalong_finish;
		$data['readalong_score'] = $readalong_score;
		$data['payment_details'] = $payment_details;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$data['assessment_id_ary'] = $assessment_id_ary;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/self_course_details', $data);
	}

	public function search_institution()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$search_data = $postdata['search_data'];
			$this->session->set_userdata('institution_search_data', $search_data);
			redirect('admin/manage_institutions');
		}
	}

	public function manage_institutions()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage Institutions";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$check_instituion = $this->ss_aw_institutions_model->check_duplicate($postdata['institutionname']);
			$check_parent_email = $this->ss_aw_parents_model->check_email($postdata['email']);
			$check_child_email = $this->ss_aw_childs_model->check_email($postdata['email']);
			$check_duplicate_mobile = $this->ss_aw_institutions_model->check_duplicate_mobile($postdata['mobile']);
			if ($check_instituion > 0) {
				$this->session->set_flashdata('error', 'Sorry! Duplicate institution.');
			} elseif (!empty($check_parent_email) || !empty($check_child_email)) {

				$this->session->set_flashdata('error', 'Sorry! User email id is already exist.');
			} elseif ($check_duplicate_mobile > 0) {
				$this->session->set_flashdata('error', 'Mobile no. already exist.');
			} else {
				$partial_payment = 0;
				if ($postdata['partial_payment']) {
					$partial_payment = 1;
				}
				$institution_data = array(
					'ss_aw_name' => $postdata['institutionname'],
					'ss_aw_address' => $postdata['address'],
					'ss_aw_city' => $postdata['city'],
					'ss_aw_country' => $postdata['country'],
					'ss_aw_state' => $postdata['state'],
					'ss_aw_pincode' => $postdata['pin'],
					'ss_aw_mobile_no' => $postdata['mobile'],
					'ss_aw_lumpsum_price' => $postdata['lumpsum_price'],
					'ss_aw_emi_price' => $postdata['emi_price'],
					'ss_aw_coupon_code_lumpsum' => $postdata['coupon_code_lumpsum'],
					'ss_aw_coupon_code_emi' => $postdata['coupon_code_emi'],
					'ss_aw_lumpsum_price_champions' => $postdata['champions_lumpsum_price'],
					'ss_aw_emi_price_champions' => $postdata['champions_emi_price'],
					'ss_aw_coupon_code_lumpsum_champions' => $postdata['champions_coupon_code_lumpsum'],
					'ss_aw_coupon_code_emi_champions' => $postdata['champions_coupon_code_emi'],
					'ss_aw_lumpsum_price_masters' => $postdata['masters_lumpsum_price'],
					// 'ss_aw_emi_price_masters' => $postdata['masters_emi_price'],
					'ss_aw_coupon_code_lumpsum_masters' => $postdata['masters_coupon_code_lumpsum'],
					'ss_aw_coupon_code_emi_masters' => $postdata['masters_coupon_code_emi'],
					'ss_aw_partial_payment' => $partial_payment
				);
				$institution_id = $this->ss_aw_institutions_model->add_record($institution_data);
				if ($institution_id) {
					$user_data = array(
						'ss_aw_institution' => $institution_id,
						'ss_aw_parent_full_name' => $postdata['adminname'],
						'ss_aw_parent_email' => $postdata['email'],
						'ss_aw_parent_password' => $this->bcrypt->hash_password($postdata['password']),
						'ss_aw_user_type' => 1
					);
					$response = $this->ss_aw_parents_model->data_insert($user_data);
					if ($response) {
						$email_template = getemailandpushnotification(64, 1, 1);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@username@@]", $postdata['adminname'], $body);
							$body = str_ireplace("[@@organization_name@@]", $postdata['institutionname'], $body);
							$body = str_ireplace("[@@email@@]", $postdata['email'], $body);
							$body = str_ireplace("[@@password@@]", $postdata['password'], $body);
							$send_data = array(
								'ss_aw_email' => $postdata['email'],
								'ss_aw_subject' => 'Welcome to team. Thank you for registering with us.',
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
						}

						$this->session->set_flashdata('success', 'Institution added succesfully.');
					} else {
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}
			}

			redirect('admin/manage_institutions');
		} else {
			$data = array();
			$filter_data = array();
			if (!empty($this->session->userdata('institution_search_data'))) {
				$filter_data['search_data'] = $this->session->userdata('institution_search_data');
				$data['search_data'] = $this->session->userdata('institution_search_data');
			}
			$this->load->library('pagination');
			$config['base_url'] = base_url() . 'admin/manage_institutions';
			$config["total_rows"] = $this->ss_aw_institutions_model->number_of_records($filter_data);
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
			$config['full_tag_close'] = '</ul>';
			$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page-item page-link">';
			$config['num_tag_close'] = '</li>';

			$config['prev_link'] = '<span aria-hidden="true">&lt;</span><span class="sr-only">Previous</span>';
			$config['prev_tag_open'] = '<li class="page-item page-link">';
			$config['prev_tag_close'] = '</li>';


			$config['next_link'] = '<span aria-hidden="true">&gt;</span><span class="sr-only">Next</span>';
			$config['next_tag_open'] = '<li class="page-item page-link">';
			$config['next_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li class="page-item page-link">';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item page-link">';
			$config['last_tag_close'] = '</li>';

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;', $str_links);
			$data['institutions'] = $this->ss_aw_institutions_model->get_all_records($config['per_page'], $page, $filter_data);
			$data['page'] = $page;
			$data['countries'] = $this->ss_aw_countries_model->get_all_records();
			$data['lumpsum_coupons'] = $this->ss_aw_coupons_model->get_coupons_by_type(1);
			$data['emi_coupons'] = $this->ss_aw_coupons_model->get_coupons_by_type(2);
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/manageinstitutions', $data);
		}
	}

	public function remove_institutions()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['record_id'];
			$institution_parents = $this->ss_aw_parents_model->get_institutions_users($record_id);
			$institution_users_id = array();
			if (!empty($institution_parents)) {
				foreach ($institution_parents as $key => $value) {
					$institution_users_id[] = $value->ss_aw_parent_id;
				}
			}
			$check_active_user_num = $this->ss_aw_childs_model->check_institution_users_deleted_or_not($institution_users_id);
			if ($check_active_user_num > 0) {
				$this->session->set_flashdata('error', "You can't delete the institution which has users, you have to delete all users first from this Institution");
			} else {
				$data = array(
					'ss_aw_updated_at' => date('Y-m-d H:i:s'),
					'ss_aw_deleted' => 1
				);
				$this->ss_aw_institutions_model->update_record($data, $record_id);
				//soft delete all childs
				$this->ss_aw_childs_model->remove_multiple_child_by_parent_id($institution_users_id);
				//soft delete master users parent details
				$this->ss_aw_parents_model->remove_multiple_parent($institution_users_id);
				$this->session->set_flashdata('success', 'Record removed succesfully.');
			}

			redirect('admin/manage_institutions/' . $postdata['page']);
		}
	}

	public function change_institution_status()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['record_id'];
			$status = $postdata['status'] == 1 ? 0 : 1;
			$data = array(
				'ss_aw_updated_at' => date('Y-m-d H:i:s'),
				'ss_aw_status' => $status
			);
			$this->ss_aw_institutions_model->update_record($data, $record_id);
			$this->session->set_flashdata('success', 'Status changed succesfully.');
			redirect('admin/manage_institutions/' . $postdata['page']);
		}
	}

	public function edit_institutions()
	{
		$record_id = $this->input->post('record_id');
		$data = array();
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($record_id);
		if (!empty($data['institution_details'])) {
			$data['states'] = $this->ss_aw_states_model->get_record_by_country($data['institution_details']->ss_aw_country);
			$data['admin_user'] = $this->ss_aw_parents_model->get_institutions_users($record_id);
		}
		echo json_encode($data);
	}

	public function update_institutions()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$update_record_id = $postdata['update_record_id'];
			$institution_admin_id = $postdata['admin_id'];
			$check_instituion = $this->ss_aw_institutions_model->check_duplicate($postdata['institutionname'], $update_record_id);
			$check_instituion_users = $this->ss_aw_institution_users_model->check_duplicate($postdata['email'], $update_record_id);
			$check_duplicate_mobile = $this->ss_aw_institutions_model->check_duplicate_mobile($postdata['mobile'], $update_record_id);
			if ($check_instituion > 0) {
				$this->session->set_flashdata('error', 'Sorry! Duplicate institution.');
			} elseif ($check_instituion_users > 0) {
				$this->session->set_flashdata('error', 'Sorry! User email id is already exist.');
			} elseif ($check_duplicate_mobile > 0) {
				$this->session->set_flashdata('error', 'Mobile no. already exist.');
			} else {
				$partial_payment = 0;
				if ($postdata['partial_payment']) {
					$partial_payment = 1;
				}
				$institution_data = array(
					'ss_aw_name' => $postdata['institutionname'],
					'ss_aw_address' => $postdata['address'],
					'ss_aw_city' => $postdata['city'],
					'ss_aw_country' => $postdata['country'],
					'ss_aw_state' => $postdata['state'],
					'ss_aw_pincode' => $postdata['pin'],
					'ss_aw_mobile_no' => $postdata['mobile'],
					'ss_aw_lumpsum_price' => $postdata['lumpsum_price'],
					'ss_aw_emi_price' => $postdata['emi_price'],
					'ss_aw_coupon_code_lumpsum' => $postdata['coupon_code_lumpsum'],
					'ss_aw_coupon_code_emi' => $postdata['coupon_code_emi'],
					'ss_aw_lumpsum_price_champions' => $postdata['champions_lumpsum_price'],
					'ss_aw_emi_price_champions' => $postdata['champions_emi_price'],
					'ss_aw_coupon_code_lumpsum_champions' => $postdata['champions_coupon_code_lumpsum'],
					'ss_aw_coupon_code_emi_champions' => $postdata['champions_coupon_code_emi'],
					'ss_aw_lumpsum_price_masters' => $postdata['masters_lumpsum_price'],
					'ss_aw_emi_price_masters' => $postdata['masters_emi_price'],
					'ss_aw_coupon_code_lumpsum_masters' => $postdata['masters_coupon_code_lumpsum'],
					'ss_aw_coupon_code_emi_masters' => $postdata['masters_coupon_code_emi'],
					'ss_aw_partial_payment' => $partial_payment
				);
				$institution_update_response = $this->ss_aw_institutions_model->update_record($institution_data, $update_record_id); {
					if (!empty($postdata['password'])) {
						$user_data = array(
							'ss_aw_parent_full_name' => $postdata['adminname'],
							'ss_aw_parent_email' => $postdata['email'],
							'ss_aw_parent_password' => $this->bcrypt->hash_password($postdata['password'])
						);
					} else {
						$user_data = array(
							'ss_aw_parent_full_name' => $postdata['adminname'],
							'ss_aw_parent_email' => $postdata['email']
						);
					}
					$response = $this->ss_aw_parents_model->update_parent_details($user_data, $institution_admin_id);
					if ($institution_update_response > 0 || $response > 0) {
						$this->session->set_flashdata('success', 'Record updated succesfully.');
					} else {
						$this->session->set_flashdata('error', 'Nothing to update.');
					}
				}
			}

			redirect('admin/manage_institutions/' . $postdata['page_no']);
		} else {
			$headerdata = $this->checklogin();
			$headerdata['title'] = "Update Institution";
			$institution_id = $this->uri->segment(3);
			$data = array();
			$data['countries'] = $this->ss_aw_countries_model->get_all_records();
			$data['lumpsum_coupons'] = $this->ss_aw_coupons_model->get_coupons_by_type(1);
			$data['emi_coupons'] = $this->ss_aw_coupons_model->get_coupons_by_type(2);
			$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
			$data['admin_details'] = $this->ss_aw_parents_model->get_institutions_admin($institution_id);
			$data['states'] = $this->ss_aw_states_model->get_record_by_country($data['institution_details']->ss_aw_country);
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/edit_institution', $data);
		}
	}

	public function view_institution()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "View Institution";
		$institution_id = $this->uri->segment(3);
		$page_index = $this->uri->segment(4);
		$data = array();
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['users'] = $this->ss_aw_parents_model->get_institutions_admin($institution_id);
		$data['page_index'] = $page_index;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/viewinstitution', $data);
	}

	public function institute_user_list()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Edit Institution";
		$institution_id = $this->uri->segment(3);
		$data['users'] = $this->ss_aw_parents_model->get_institutions_admin($institution_id);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institute_user_list', $data);
	}

	public function reset_institution_user_password()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$record_id = $postdata['record_id'];
			$institution_id = $postdata['institution_id'];
			$password = $postdata['password'];
			$confirm_password = $postdata['confirmpassword'];
			if ($password != $confirm_password) {
				$this->session->set_flashdata('error', 'Password and confirmed password not matched.');
				redirect('admin/manage_institutions');
			}
			$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($record_id);
			$parent_password = $parent_details[0]->ss_aw_parent_password;
			if ($this->bcrypt->check_password($password, $parent_password)) {
				$this->session->set_flashdata('error', 'Please enter a new password.');
				redirect('admin/manage_institutions');
			}
			$data = array(
				'ss_aw_parent_password' => $this->bcrypt->hash_password($password),
				'ss_aw_parent_modified_date' => date('Y-m-d H:i:s')
			);
			$this->ss_aw_parents_model->update_parent_details($data, $record_id);
			$this->session->set_flashdata('success', 'Password reset successfully.');
			redirect('admin/manage_institutions');
		}
	}

	public function unsubscibe_newsletters()
	{
		if (!empty($this->input->post('email'))) {
			$email = $this->input->post('email');
			$data = array(
				'ss_aw_email' => $email
			);
			$check_duplicate = $this->ss_aw_unsubscribe_emails->check_duplicate($email);
			if ($check_duplicate > 0) {
				$this->ss_aw_unsubscribe_emails->remove_record($email);
				$response = $this->ss_aw_unsubscribe_emails->add_record($data);
			} else {
				$response = $this->ss_aw_unsubscribe_emails->add_record($data);
			}
			if ($response) {
				$this->session->set_flashdata('success', 'You are unsubscribed succesfully.');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
			redirect('unsubscribe');
		} else {
			$email = base64_decode($this->uri->segment(2));
			$data['email'] = $email;
			$this->load->view('admin/unsubscribe_email', $data);
		}
	}

	public function add_multiple_adults()
	{
		//$postdata = $this->input->post();
		// Get default limit
		$normalTimeLimit = ini_get('max_execution_time');

		// Set new limit
		ini_set('max_execution_time', 600);

		if (isset($_FILES["file"]['name'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file')) {
				//echo "not success";
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
				$this->session->set_flashdata('error', 'Uploaded file format mismatch.');
				redirect('admin/vocabulary');
			}

			$data = $this->upload->data();
			$lesson_file = $data['file_name'];
		}

		$file = './uploads/' . $lesson_file;

		//load the excel library
		$this->load->library('excel');

		//read file from path
		$objPHPExcel = @PHPExcel_IOFactory::load($file);

		//get only the Cell Collection
		$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();


		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = @$objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = @$objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

			if (empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue())) {

				if ($cell[0] == 'A') {
					$data_value = trim($avalue);
				}
				if ($cell[0] == 'B') {
					$data_value = trim($bvalue);
				}
			} else {
				if ($cell[0] == 'A') {
					$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				} else if ($cell[0] == 'B') {
					$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				}
			}
			//The header will/should be in row 1 only. of course, this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = trim($data_value);
			} else {
				$arr_data[$row][$column] = trim($data_value);
			}
		}

		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data;

		$success = 0;
		if (!empty($data['values'])) {
			foreach ($data['values'] as $value) {

				$gender = $value['B'];
				$email = $value['C'];
				//check parent email is valid or not
				if ($this->check_email_existance($email)) {
					$parent_name = $value['A'];
					$institution_name = $value['D'];
					$address = $value['E'];
					$city = $value['F'];
					$state = $value['G'];
					$country = $value['H'];
					$pincode = $value['I'];
					$amount = $value['J'];
					$coupon_code = $value['K'];
					$nameAry = explode(" ", $parent_name);
					$first_name = $nameAry[0];
					$last_name = $nameAry[1];
					$password = strtolower($first_name) . "@123";
					$hash_pass = $this->bcrypt->hash_password($password);
					$token = $this->random_strings(20);

					$data = array(
						'ss_aw_parent_full_name' => $parent_name,
						'ss_aw_user_type' => 4,
						'ss_aw_parent_email' => $email,
						'ss_aw_parent_password' => $hash_pass,
						'ss_aw_parent_auth_key' => $token,
						'ss_aw_parent_address' => $address,
						'ss_aw_parent_city' => $city,
						'ss_aw_parent_state' => $state,
						'ss_aw_parent_pincode' => $pincode,
						'ss_aw_parent_country' => $country
					);
					//add data to parent table
					$parent_id = $this->ss_aw_parents_model->data_insert($data);
					if (!empty($parent_id)) {
						$email_template = getemailandpushnotification(61, 1);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@password@@]", $password, $body);
							$body = str_ireplace("[@@email@@]", $email, $body);
							$body = str_ireplace("[@@username@@]", $parent_name, $body);
							emailnotification($email, 'Welcome to team. Thank you for registering with us.', $body);
						}


						//get last inserted child code
						$code_check = $this->ss_aw_childs_model->child_code_check();
						if (isset($code_check)) {
							$random_code = $code_check->ss_aw_child_code + 1;
						} else {
							$random_code =  10000002;
						}
						$child_code = $random_code;

						$child_data = array();
						$child_data['ss_aw_child_code'] = $child_code;
						$child_data['ss_aw_parent_id'] = $parent_id;
						$child_data['ss_aw_child_nick_name'] = $parent_name;
						$current_date = date('Y-m-d');
						$child_data['ss_aw_child_dob'] = date('Y-m-d', strtotime($current_date . " -18 years"));
						$child_data['ss_aw_child_age'] = calculate_age($child_data['ss_aw_child_dob']);
						$child_data['ss_aw_child_email'] = $email;
						$child_data['ss_aw_child_password'] = $hash_pass;
						$child_data['ss_aw_child_first_name'] = $first_name;
						$child_data['ss_aw_child_last_name'] = $last_name;
						$child_data['ss_aw_child_schoolname'] = $institution_name;
						$child_data['ss_aw_child_gender'] = strtolower($gender) == 'male' ? 1 : 2;
						$child_data['ss_aw_is_self'] = 1;
						$check_duplicate = $this->ss_aw_schools_model->check_duplicate($institution_name);
						if ($check_duplicate == 0) {
							$this->ss_aw_schools_model->add_record(array('ss_aw_name' => $institution_name));
						}
						$child_id = $this->ss_aw_childs_model->add_child($child_data);
						//mark as paid
						if (!empty($child_id)) {
							//send welcome masters mail
							$email_template = getemailandpushnotification(33, 1, 2);
							$month_date = date('d/m/Y');
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@username@@]", $parent_name, $body);
								emailnotification($email, $email_template['title'], $body);
							}
							//end
							$course_id = 5;
							$transaction_id = $this->random_strings(10);
							$invoice_prefix = "ALWS/";
							$invoice_suffix = "/" . date('m') . date('y');
							$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
							if (!empty($get_last_invoice_details)) {
								$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
								if (!empty($invoice_ary)) {
									if (!empty($invoice_ary[1])) {
										if (is_numeric($invoice_ary[1])) {
											$suffix_num = (int)$invoice_ary[1] + 1;
											$invoice_no = $invoice_prefix . $suffix_num;
										} else {
											$invoice_no = $invoice_prefix . "100001";
										}
									} else {
										$invoice_no = $invoice_prefix . "100001";
									}
								} else {
									$invoice_no = $invoice_prefix . "100001";
								}
							} else {
								$invoice_no = $invoice_prefix . "100001";
							}
							$invoice_no = $invoice_no . $invoice_suffix;
							//generate PDF code
							$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

							$payment_amount = $amount; //5999
							$course_price = round(($payment_amount * 100) / (100 + 18), 2);
							$gst_rate = $payment_amount - $course_price;
							$discount_amount = 0;
							if (!empty($coupon_code)) {
								$check_coupon_availability = $this->ss_aw_coupons_model->check_coupon_availability($coupon_code, 1);
								$discount_percentage = $check_coupon_availability[0]->ss_aw_discount;
								$discount_amount = round(($course_price * $discount_percentage) / 100, 2);
								$payment_amount = $course_price - $discount_amount;
								$gst_rate = round(($payment_amount * 18) / 100, 2);
								$payment_amount = $payment_amount + $gst_rate;
							}
							$data = array();
							$data['transaction_id'] = $transaction_id;
							$data['payment_amount'] = $payment_amount;
							$data['course_id'] = $course_id;
							$data['invoice_no'] = $invoice_no;
							$data['parent_details'] = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
							$data['discount_amount'] = $discount_amount;

							$data['gst_rate'] = $gst_rate;
							$data['coupon_id'] = $coupon_code;
							$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => $course_id));
							$data['payment_type'] = $inputpost['emi_payment'];

							$this->load->library('pdf');
							$html = $this->load->view('pdf/paymentinvoice', $data, true);

							$filename = time() . rand() . "_" . $child_id . ".pdf";
							$save_file_path = "./payment_invoice/" . $filename;
							$this->pdf->createPDF($save_file_path, $html, $filename, false);
							//END

							//add data to child course table
							$searary = array();
							$searary['ss_aw_parent_id'] = $parent_id;
							$searary['ss_aw_child_id'] = $child_id;
							$searary['ss_aw_selected_course_id'] = $course_id;
							$searary['ss_aw_transaction_id'] = $transaction_id;
							$searary['ss_aw_course_payment'] = $payment_amount;
							$searary['ss_aw_invoice'] = $filename;
							$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
							$payment_invoice_file_path = base_url() . "payment_invoice/" . $filename;
							$searary = array();
							$searary['ss_aw_child_id'] = $child_id;
							$searary['ss_aw_course_id'] = $course_id;
							if ($inputpost['emi_payment']) {
								$searary['ss_aw_course_payemnt_type'] = 1;
							}
							$courseary = $this->ss_aw_child_course_model->data_insert($searary);
							//end

							//add data to payment details table
							$searary = array();
							$searary['ss_aw_parent_id'] = $parent_id;
							$searary['ss_aw_child_id'] = $child_id;
							$searary['ss_aw_payment_invoice'] = $invoice_no;
							$searary['ss_aw_transaction_id'] = $transaction_id;
							$searary['ss_aw_payment_amount'] = $payment_amount;
							$searary['ss_aw_gst_rate'] = $gst_rate;
							$searary['ss_aw_discount_coupon'] = $coupon_code;
							$searary['ss_aw_discount_amount'] = $discount_amount;
							$courseary = $this->ss_aw_payment_details_model->data_insert($searary);
							//end
							//revenue mis data store
							$invoice_amount = $payment_amount - $gst_rate;
							$reporting_collection_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $course_id,
								'ss_aw_invoice_amount' => $invoice_amount,
								'ss_aw_discount_amount' => $discount_amount,
								'ss_aw_payment_type' => 0
							);

							$resporting_collection_insertion = $this->ss_aw_reporting_collection_model->store_data($reporting_collection_data); {
								$fixed_course_duration = 196;
								$course_duration = 196;


								$today = date('d');

								$count = 0;
								while ($course_duration != 0) {
									if ($count == 0) {
										$advance_payment = 0;
										$today_date = date('Y-m-d');
										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = date('d');
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;
									} else {
										$advance_payment = 1;
										$today_date = new DateTime();
										$today_date->format('Y-m-d');
										$day = $today_date->format('j');
										$today_date->modify('first day of + ' . $count . ' month');
										$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
										$today_date = $today_date->format('Y-m-d');

										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = 0;
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;
										$today_date = $year . "-" . $month . "-01";
									}

									if ($remaing_days > $course_duration) {
										$remaing_days = $course_duration;
										$course_duration = 0;
									} else {
										$course_duration = $course_duration - $remaing_days;
									}

									$revenue_invoice_amount = ($invoice_amount / $fixed_course_duration) * $remaing_days;
									$revenue_discount_amount = 0;
									if ($discount_amount > 0) {
										$revenue_discount_amount = ($discount_amount / $fixed_course_duration) * $remaing_days;
									}

									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
										'ss_aw_discount_amount' => round($revenue_discount_amount, 2),
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => 0,
										'ss_aw_advance' => $advance_payment
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

									$count++;
								}
							}
						}
						$success++;
					}
				}
			}
		}

		if ($success > 0) {
			$this->session->set_flashdata('success', 'Adults enrolled succesfully');
		} else {
			$this->session->set_flashdata('error', 'Invalid data.');
		}
		// Restore default limit
		ini_set('max_execution_time', $normalTimeLimit);

		redirect('admin/manageparents');
	}

	public function random_strings($length_of_string)
	{
		// random_bytes returns number of bytes 
		// bin2hex converts them into hexadecimal format 
		return substr(md5(time()), 0, $length_of_string);
	}

	public function check_email_existance($email)
	{
		$response = $this->ss_aw_parents_model->check_email($email);
		$child_email_response = $this->ss_aw_childs_model->check_email($email);
		if (empty($response) && empty($child_email_response)) {
			return 1;
		} else {
			return 0;
		}
	}

	public function manageinstitutionusers()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage " . Winners . " Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$data['institution_id'] = $institution_id;
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}
		//if search by any data
		$search_data = "";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$search_data = $postdata['search_data'];
		}
		$data['search_data'] = $search_data;
		$total_record = $this->ss_aw_childs_model->total_winner_users($institution_users_id, $search_data);
		$redirect_to = base_url() . 'admin/manageinstitutionusers/' . $institution_id;
		$uri_segment = 4;
		$record_per_page = 10;
		$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		if ($page >= $config["total_rows"]) {
			$page = 0;
		}
		$result = $this->ss_aw_childs_model->get_users_by_parents_ary($institution_users_id, $config['per_page'], $page, $search_data);
		$data['page'] = $page;
		$lessoncount = array();
		$assessmentcount = array();
		$readalongcount = array();
		$diagnostictotalquestion = array();
		$diagnosticcorrectquestion = array();
		$diagnosticexamdate = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				$duration = "";
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				if (!empty($childary)) {
					$value->course = $childary[count($childary) - 1]['ss_aw_course_id'];
					$lessoncount[$value->ss_aw_child_id] = $this->ss_aw_child_last_lesson_model->getcompletelessoncount($value->ss_aw_child_id, $value->course);
					$assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenumbychild($value->ss_aw_child_id, $value->course);

					$readalongcount[$value->ss_aw_child_id] = $this->ss_aw_last_readalong_model->gettotalcompletenum($value->ss_aw_child_id, $value->course);

					//get diagnostic exam details
					$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($value->ss_aw_child_id);
					if (!empty($diagnostic_exam_code_details)) {
						$diagnostic_exam_date = date('d/m/Y', strtotime($diagnostic_exam_code_details->ss_aw_diagonastic_exam_date));
						$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
						$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
						$diagnostic_question_asked = DIAGNOSTIC_QUESTION_NUM;
						$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					} else {
						$diagnostic_exam_date = "";
						$diagnostic_question_asked = 0;
						$diagnostic_question_correct = 0;
					}
					$diagnostictotalquestion[$value->ss_aw_child_id] = $diagnostic_question_asked;
					$diagnosticcorrectquestion[$value->ss_aw_child_id] = $diagnostic_question_correct;
					$diagnosticexamdate[$value->ss_aw_child_id] = $diagnostic_exam_date;
					//end

					//get child course details
					$course_details[$value->ss_aw_child_id] = $this->ss_aw_childs_model->get_details_with_course($value->ss_aw_child_id);
					//end		
				}
			}
		}

		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $result;
		$data['lessoncount'] = $lessoncount;
		$data['assessmentcount'] = $assessmentcount;
		$data['readalongcount'] = $readalongcount;
		$data['diagnostictotalquestion'] = $diagnostictotalquestion;
		$data['diagnosticcorrectquestion'] = $diagnosticcorrectquestion;
		$data['course_details'] = $course_details;
		$data['course_type'] = 1;
		$data['diagnosticexamdate'] = $diagnosticexamdate;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/manageinstitutionswinnersusers', $data);
	}

	public function manageinstitutionmastersusers()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage " . Master . " Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$data['institution_id'] = $institution_id;
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}
		//if search by any data
		$search_data = "";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$search_data = $postdata['search_data'];
		}
		$data['search_data'] = $search_data;
		$total_record = $this->ss_aw_childs_model->total_masters_users($institution_users_id, $search_data);
		$redirect_to = base_url() . 'admin/manageinstitutionmastersusers/' . $institution_id;
		$uri_segment = 4;
		$record_per_page = 10;
		$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		if ($page >= $config["total_rows"]) {
			$page = 0;
		}
		$result = $this->ss_aw_childs_model->get_master_users_by_parents_ary($institution_users_id, $config['per_page'], $page, $search_data);
		$data['page'] = $page;
		$lessoncount = array();
		$assessmentcount = array();
		$readalongcount = array();
		$diagnostictotalquestion = array();
		$diagnosticcorrectquestion = array();
		$diagnosticexamdate = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				$duration = "";
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				if (!empty($childary)) {
					$value->course = $childary[count($childary) - 1]['ss_aw_course_id'];
					$lessoncount[$value->ss_aw_child_id] = $this->ss_aw_child_last_lesson_model->getcompletelessoncount($value->ss_aw_child_id, $value->course);
					$assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenumbychild($value->ss_aw_child_id, $value->course);

					$readalongcount[$value->ss_aw_child_id] = $this->ss_aw_last_readalong_model->gettotalcompletenum($value->ss_aw_child_id, $value->course);

					//get diagnostic exam details
					$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($value->ss_aw_child_id);
					if (!empty($diagnostic_exam_code_details)) {
						$diagnostic_exam_date = date('d/m/Y', strtotime($diagnostic_exam_code_details->ss_aw_diagonastic_exam_date));
						$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
						$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
						$diagnostic_question_asked = DIAGNOSTIC_QUESTION_NUM;
						$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					} else {
						$diagnostic_exam_date = "";
						$diagnostic_question_asked = 0;
						$diagnostic_question_correct = 0;
					}
					$diagnostictotalquestion[$value->ss_aw_child_id] = $diagnostic_question_asked;
					$diagnosticcorrectquestion[$value->ss_aw_child_id] = $diagnostic_question_correct;
					$diagnosticexamdate[$value->ss_aw_child_id] = $diagnostic_exam_date;
					//end

					//get child course details
					$course_details[$value->ss_aw_child_id] = $this->ss_aw_childs_model->get_details_with_course($value->ss_aw_child_id);
					//end	
				}
			}
		}
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $result;
		$data['lessoncount'] = $lessoncount;
		$data['assessmentcount'] = $assessmentcount;
		$data['readalongcount'] = $readalongcount;
		$data['diagnostictotalquestion'] = $diagnostictotalquestion;
		$data['diagnosticcorrectquestion'] = $diagnosticcorrectquestion;
		$data['course_details'] = $course_details;
		$data['course_type'] = 2;
		$data['diagnosticexamdate'] = $diagnosticexamdate;
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/manageinstitutionsmasterssusers', $data);
	}

	public function edit_institution_user()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Edit Institution User";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			if ($postdata['program_type'] == 1) {
				$child_data = array();
				$child_data['ss_aw_child_username'] = $postdata['userid'];
				$child_data['ss_aw_child_nick_name'] = $postdata['nickname'];
				$child_data['ss_aw_child_first_name'] = $postdata['firstname'];
				$child_data['ss_aw_child_last_name'] = $postdata['lastname'];
				$child_data['ss_aw_child_dob'] = $postdata['date_of_birth'];
				$child_data['ss_aw_child_age'] = calculate_age($child_data['ss_aw_child_dob']);
				$child_data['ss_aw_child_gender'] = $postdata['rad_gender'];
				$child_data['ss_aw_child_email'] = $postdata['email'];
				if (!empty($postdata['password'])) {
					$child_data['ss_aw_child_password'] = @$this->bcrypt->hash_password($postdata['password']);
				}
				$this->ss_aw_childs_model->update_child_details($child_data, $postdata['user_id']);
				$this->session->set_flashdata('success', 'Record updated successfully.');
				redirect('admin/manageinstitutionusers/' . $postdata['institution_id'] . '/' . $postdata['page']);
			} else {
				$parent_id = $postdata['parent_id'];
				$parent_data = array();
				$parent_data['ss_aw_parent_full_name'] = $postdata['firstname'] . " " . $postdata['lastname'];
				$parent_data['ss_aw_parent_email'] = $postdata['email'];
				if (!empty($postdata['password'])) {
					$parent_data['ss_aw_parent_password'] = @$this->bcrypt->hash_password($postdata['password']);
				}
				$this->ss_aw_parents_model->update_parent_details($parent_data, $parent_id);
				$child_data = array();
				$child_data['ss_aw_child_nick_name'] = $postdata['nickname'];
				$child_data['ss_aw_child_first_name'] = $postdata['firstname'];
				$child_data['ss_aw_child_last_name'] = $postdata['lastname'];
				$child_data['ss_aw_child_gender'] = $postdata['master_gender'];
				$child_data['ss_aw_child_email'] = $postdata['email'];
				if (!empty($postdata['password'])) {
					$child_data['ss_aw_child_password'] = @$this->bcrypt->hash_password($postdata['password']);
				}
				$this->ss_aw_childs_model->update_child_details($child_data, $postdata['user_id']);
				$this->session->set_flashdata('success', 'Record updated successfully.');
				redirect('admin/manageinstitutionmastersusers/' . $postdata['institution_id'] . '/' . $postdata['page']);
			}
		} else {
			$data = array();
			$child_id = $this->uri->segment(3);
			$institution_id = $this->uri->segment(4);
			$page = $this->uri->segment(5);
			$self_details = array();
			$child_details = array();
			$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			if (!empty($child_details)) {
				if (empty($child_details[0]->ss_aw_child_username)) {
					$self_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($child_details[0]->ss_aw_parent_id);
				}
			}
			$data['child_details'] = $child_details;
			$data['self_details'] = $self_details;
			$data['page'] = $page;
			$data['institution_id'] = $institution_id;
			$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
			$this->load->view('admin/header', $headerdata);
			$this->load->view('admin/edit-institution-user', $data);
		}
	}

	public function import_institution_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Import Bulk Users";
		//bulk upload feature
		$normalTimeLimit = ini_get('max_execution_time');
		ini_set('max_execution_time', 600);
		if (isset($_FILES["file"]['name'])) {
			$original_file_name_ary = explode(".xlsx", $_FILES["file"]['name']);
			$original_file_name = $original_file_name_ary[0];
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file')) {
				//echo "not success";
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', 'Uploaded file format mismatch.');
				redirect($_SERVER['HTTP_REFERER']);
			}

			$data = $this->upload->data();
			$lesson_file = $data['file_name'];

			$file = './uploads/' . $lesson_file;

			//load the excel library
			$this->load->library('excel');

			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);

			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();


			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				$column = @$objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = @$objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if (empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue())) {

					if ($cell[0] == 'A') {
						$data_value = trim($avalue);
					}
					if ($cell[0] == 'B') {
						$data_value = trim($bvalue);
					}
				} else {
					if ($cell[0] == 'A') {
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					} else if ($cell[0] == 'B') {
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = trim($data_value);
				} else {
					$arr_data[$row][$column] = trim($data_value);
				}
			}

			$header_field_count = 0;
			foreach ($header[1] as $headerdata) {
				if (!empty($headerdata)) {
					$header_field_count++;
				}
			}
			if ($this->input->post('programme_type') == 1) {
				if ($header_field_count != 6) {
					$this->session->set_flashdata('error', 'Please choose the correct format for ' . strtolower(Winners) . ' programme.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				if ($header_field_count != 4) {
					$this->session->set_flashdata('error', 'Please choose the correct format for ' . strtolower(Master) . ' programme.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			//save upload mster record
			$original_file_name = $this->input->post('file_name');
			$master_data = array(
				'ss_aw_upload_file_path' => 'uploads/' . $lesson_file,
				'ss_aw_upload_file_name' => $original_file_name,
				'ss_aw_program_type' => $this->input->post('programme_type')
			);
			$upload_record_id = $this->ss_aw_institution_student_upload_model->add_record($master_data);
			//end

			//get institution details
			$institution_id = $this->input->post('institution_id');
			$institution_admin_details = $this->ss_aw_parents_model->get_institutions_admin($institution_id);
			$parent_id = $institution_admin_details[0]->ss_aw_parent_id;
			$institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
			//end

			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			$existing_emails = array();
			$existing_usernames = array();

			$dobAry = array();
			if ($this->input->post('programme_type') == 1) {
				if (!empty($data['values'])) {
					foreach ($data['values'] as $value) {
						if (!empty($value['F'])) {
							$dob = ($value['F'] - 25569) * 86400;
							$dob = 25569 + ($dob / 86400);
							$dob = ($dob - 25569) * 86400;
							$dob = date('Y-m-d', $dob);
							if (!validateDate($dob)) {
								$this->session->set_flashdata('error', 'Invalid date format.');
								redirect($_SERVER['HTTP_REFERER']);
							}
						}
					}
				}

				$success = 0;
				if (!empty($data['values'])) {
					foreach ($data['values'] as $value) {
						if (!empty($value['A']) && !empty($value['C']) && !empty($value['D']) && !empty($value['E']) && !empty($value['F'])) {
							$first_name = $value['A'];
							$first_name = trim($first_name);
							$last_name = $value['B'];
							$last_name = !empty($last_name) ? trim($last_name) : '';
							$gender = $value['C'];
							$email = $value['D'];
							$username = $value['E'];
							$username = strtolower(str_replace(" ", "", $username));
							$dob = ($value['F'] - 25569) * 86400;
							$dob = 25569 + ($dob / 86400);
							$dob = ($dob - 25569) * 86400;
							$dob = date('Y-m-d', $dob); {
								if (empty($email)) {
									$email = $this->session->userdata('user_email');
								} else {
									//check unique email
									$check_in_parent = $this->ss_aw_parents_model->check_in_parent($parent_id, trim($email));
									$check_in_child = $this->ss_aw_childs_model->check_in_child($parent_id, trim($email));
									//end
									//check unique username
									$check_username = $this->ss_aw_childs_model->check_username($username);
									$check_temp_username = $this->ss_aw_childs_temp_model->check_username($username);

									//end
									if ($check_in_parent > 0 || $check_in_child > 0) {
										$existing_emails[] = $email;
									} elseif ($check_username > 0 || $check_temp_username > 0) {
										$existing_usernames[] = $username;
									} else {
										//get the last child code and create after last.
										$code_check = $this->ss_aw_childs_model->child_code_check();
										if (isset($code_check)) {
											$random_code = $code_check->ss_aw_child_code + 1;
										} else {
											$random_code =  10000001;
										}

										$password = explode(" ", strtolower($first_name))[0];
										if (strlen($password) > 11) {
											$password = substr($password, 0, 11);
										}
										$password = $password . "@123";
										$data = array(
											'ss_aw_child_username' => $username,
											'ss_aw_child_code' => $random_code,
											'ss_aw_parent_id' => $parent_id,
											'ss_aw_child_nick_name' => $first_name . " " . $last_name,
											'ss_aw_child_first_name' => $first_name,
											'ss_aw_child_last_name' => $last_name,
											'ss_aw_child_gender' => $gender == "Male" ? 1 : 2,
											'ss_aw_child_schoolname' => $institution_details->ss_aw_name,
											'ss_aw_child_dob' => $dob,
											'ss_aw_child_age' => calculate_age($dob),
											'ss_aw_child_email' => $email,
											'ss_aw_child_password' => @$this->bcrypt->hash_password($password),
											'ss_aw_is_institute' => 1,
											'ss_aw_institution_user_upload_id' => $upload_record_id,
											'ss_aw_child_status' => 0
										);
										$response = $this->ss_aw_childs_model->add_child($data);
										if ($response) {
											$success++;
										}
									}
								}
							}
						}
					}
				}
			} else {
				$success = 0;
				$existing_emails = array();
				if (!empty($data['values'])) {
					foreach ($data['values'] as $value) {
						if (!empty($value['A']) && !empty($value['C']) && !empty($value['D'])) {
							$first_name = $value['A'];
							$first_name = trim($first_name);
							$last_name = $value['B'];
							$last_name = !empty($last_name) ? trim($last_name) : '';
							$gender = $value['C'];
							$email = $value['D'];
							if (empty($this->ss_aw_childs_model->check_email($email))) {
								//get the last child code and create after last.
								$code_check = $this->ss_aw_childs_model->child_code_check();
								if (isset($code_check)) {
									$random_code = $code_check->ss_aw_child_code + 1;
								} else {
									$random_code =  10000001;
								}

								$password = explode(" ", strtolower($first_name))[0];
								if (strlen($password) > 11) {
									$password = substr($password, 0, 11);
								}
								$password = $password . "@123";
								$data = array(
									'ss_aw_parent_full_name' => $first_name . " " . $last_name,
									'ss_aw_user_type' => 4,
									'ss_aw_parent_email' => $email,
									'ss_aw_parent_password' => @$this->bcrypt->hash_password($password),
									'ss_aw_parent_address' => $institution_details->ss_aw_address,
									'ss_aw_parent_city' => $institution_details->ss_aw_city,
									'ss_aw_parent_state' => $institution_details->state_name,
									'ss_aw_parent_pincode' => $institution_details->ss_aw_pincode,
									'ss_aw_parent_country' => $institution_details->country_name,
									'ss_aw_institution' => $institution_details->ss_aw_id,
									'ss_aw_parent_status' => 0
								);
								//add data to parent table
								$parent_id = $this->ss_aw_parents_model->data_insert($data);
								if ($parent_id) { {
										//add as alert
										$child_data = array();
										$child_data['ss_aw_child_code'] = $random_code;
										$child_data['ss_aw_parent_id'] = $parent_id;
										$child_data['ss_aw_child_nick_name'] = $first_name . " " . $last_name;
										$current_date = date('Y-m-d');
										$child_data['ss_aw_child_dob'] = date('Y-m-d', strtotime($current_date . " -18 years"));
										$child_data['ss_aw_child_age'] = calculate_age($child_data['ss_aw_child_dob']);
										$child_data['ss_aw_child_email'] = $email;
										$child_data['ss_aw_child_password'] = @$this->bcrypt->hash_password($password);
										$child_data['ss_aw_child_first_name'] = $first_name;
										$child_data['ss_aw_child_last_name'] = $last_name;
										$child_data['ss_aw_child_schoolname'] = $institution_details->ss_aw_name;
										$child_data['ss_aw_child_gender'] = $gender == "Male" ? 1 : 2;
										$child_data['ss_aw_is_institute'] = 1;
										$child_data['ss_aw_institution_user_upload_id'] = $upload_record_id;
										$child_data['ss_aw_child_status'] = 0;
										$child_data['ss_aw_is_self'] = 1;
										$check_duplicate = $this->ss_aw_schools_model->check_duplicate($institution_details->ss_aw_name);
										if ($check_duplicate == 0) {
											$this->ss_aw_schools_model->add_record(array('ss_aw_name' => $institution_details->ss_aw_name));
										}
										$response = $this->ss_aw_childs_model->add_child($child_data);
										if (!empty($response)) {
											$success++;
										}
									}
								}
							} else {
								$existing_emails[] = $email;
							}
						}
					}
				}
			}
		}
		// Restore default limit
		ini_set('max_execution_time', $normalTimeLimit);
		//end
		if ($success > 0) {
			$msg = "User added successfully";
			if (!empty($existing_emails)) {
				$existing_emails_string = implode(",", $existing_emails);
				$msg .= " and the following emails already exists in the system (" . $existing_emails_string . ").";
			}
			if (!empty($existing_usernames)) {
				$existing_usernames_string = implode(",", $existing_usernames);
				$msg .= " and the following user ids already exists in the system (" . $existing_usernames_string . ").";
			}
			$update_data = array(
				'ss_aw_institution_id' => $institution_id,
				'ss_aw_student_number' => $success
			);
			$this->ss_aw_institution_student_upload_model->update_record($update_data, $upload_record_id);
			$this->session->set_flashdata('success', $msg);
		} else {
			if (!empty($existing_emails)) {
				$existing_emails_string = implode(",", $existing_emails);
				$msg .= "The following emails already exists in the system (" . $existing_emails_string . ").";
			}
			if (!empty($existing_usernames)) {
				$existing_usernames_string = implode(",", $existing_usernames);
				$msg .= "The following user ids already exists in the system (" . $existing_usernames_string . ").";
			}
			$this->ss_aw_institution_student_upload_model->remove_record($upload_record_id);
			$this->session->set_flashdata('error', $msg);
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function change_institution_user_status()
	{
		$postdata = $this->input->post();
		$child_id = $postdata['status_child_id'];
		$child_status = $postdata['status_child_status'];
		$this->ss_aw_childs_model->chnage_child_status($child_id, $child_status);
		if ($child_status == 0) {
			$this->ss_aw_childs_model->logout($child_id);
		}
		//get child details and check its adult or not
		$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		if (empty($child_details[0]->ss_aw_child_username)) {
			$parent_id = $child_details[0]->ss_aw_parent_id;
			$this->ss_aw_parents_model->update_active_status($parent_id, $child_status);
			if ($child_status == 0) {
				$this->ss_aw_parents_model->logout($parent_id); //logout from system if already logged in
			}
		}
		$this->session->set_flashdata('success', 'User status changed succesfully');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function change_institution_user_block_status()
	{
		$postdata = $this->input->post();
		$child_id = $postdata['block_child_id'];
		$block_status = $postdata['block_child_status'];
		$data = array(
			'ss_aw_blocked' => $block_status
		);
		$this->ss_aw_childs_model->update_child_details($data, $child_id);
		$this->session->set_flashdata('success', 'User block status changed succesfully');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function institution_user_course_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "User Course Details";
		$data = array();
		$parent_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$pageno = $this->uri->segment(5);
		$data['page'] = $pageno;
		$program_type = $this->uri->segment(6);
		$institution_id = $this->uri->segment(7);
		$data['program_type'] = $program_type;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$data['parent_id'] = $parent_id;
		$data['child_id'] = $child_id;
		$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
		if (!empty($diagnostic_exam_code_details)) {
			$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
			$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
			$diagnostic_question_asked = DIAGNOSTIC_QUESTION_NUM;
			$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
		} else {
			$diagnostic_question_asked = 0;
			$diagnostic_question_correct = 0;
		}

		//recommended course suggested course
		$recomended_level = "";
		$searchary = array();
		$searchary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
		$examresultary = array();
		$examresultary = $this->ss_aw_diagonastic_exam_log_model->fetch_record_byparam($searchary);
		$resultcountary = array();
		foreach ($examresultary as $value) {
			if ($value['ss_aw_diagonastic_log_answer_status'] != 3) {
				$resultcountary[$value['ss_aw_diagonastic_log_level']]['total_ask'][] = $value['ss_aw_diagonastic_log_question_id'];
				if ($value['ss_aw_diagonastic_log_answer_status'] == 1)
					$resultcountary[$value['ss_aw_diagonastic_log_level']]['right_ans'][] = $value['ss_aw_diagonastic_log_question_id'];
			}
		}
		$pct_level_e = "";
		$pct_level_c = "";
		$pct_level_a = "";
		if (!empty($resultcountary['E']))
			$pct_level_e  = round((count($resultcountary['E']['right_ans']) / count($resultcountary['E']['total_ask'])) * 100);

		if (!empty($resultcountary['C']))
			$pct_level_c  = round((count($resultcountary['C']['right_ans']) / count($resultcountary['C']['total_ask'])) * 100);

		if (!empty($resultcountary['A']))
			$pct_level_a  = round((count($resultcountary['A']['right_ans']) / count($resultcountary['A']['total_ask'])) * 100);

		/*This Checking for the E level student whose age bellow 13 years */
		if (!empty($resultcountary['E'])) {
			if ($pct_level_e > 80 && $pct_level_c > 70) {
				$recomended_level = 'C';
			} else {
				$recomended_level = 'E';
			}
		}
		/*This Checking for the C level student whose age above 13 years */
		if (!empty($resultcountary['C'])) {
			if ($pct_level_c > 80 && $pct_level_a > 70) {
				$recomended_level = 'A';
			} else if ($pct_level_c < 50) {
				$recomended_level = 'E';
			} else {
				$recomended_level = 'C';
			}
		}
		//end
		$child_enroll_details = $this->ss_aw_child_last_lesson_model->child_enroll_details($child_id);
		$login_details = $this->ss_aw_child_login_model->get_data_by_child($child_id);
		//lesson and assessment topical details
		$completed_topic_details = $this->ss_aw_child_last_lesson_model->getallcompletelessonby_child($child_id);
		$lesson_score = array();
		$assessment_score = array();
		$assessment_id_ary = array();
		if (!empty($completed_topic_details)) {
			foreach ($completed_topic_details as $key => $value) {
				$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $value->ss_aw_lesson_id);
				$lesson_asked = 0;
				$lesson_correct = 0;
				if (!empty($lesson_score_details)) {
					$lesson_asked = $lesson_score_details[0]->total_question;
					$lesson_correct = $lesson_score_details[0]->wright_answers;
				}
				$lesson_score['asked'][$value->ss_aw_lesson_id] = $lesson_asked;
				$lesson_score['correct'][$value->ss_aw_lesson_id] = $lesson_correct;

				//assessment section
				$assessment_id = "";
				$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
				if (!empty($topical_assessment_start_details)) {
					if (!empty($topical_assessment_start_details)) {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($topical_assessment_start_details[0]->ss_aw_created_date));
					} else {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = "NA";
					}

					$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
				} else {
					$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
					if (!empty($comprehension_assessment_start_details)) {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($comprehension_assessment_start_details[0]->ss_aw_created_at));
					} else {
						$assessment_score['exam_start'][$value->ss_aw_lesson_id] = "NA";
					}

					$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
				}
				$assessment_id_ary[$value->ss_aw_lesson_id] = $assessment_id;
				$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
				$assessment_asked = 0;
				$assessment_correct = 0;
				$assessment_score['exam_completed'][$value->ss_aw_lesson_id] = "NA";
				$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
				if (!empty($assessment_completetion_details)) {
					$assessment_score['exam_completed'][$value->ss_aw_lesson_id] = date('d/m/Y', strtotime($assessment_completetion_details[0]->ss_aw_create_date));
				}
				if (!empty($assessment_score_details)) {
					$assessment_asked = $assessment_score_details[0]->total_question;
					$assessment_correct = $assessment_score_details[0]->wright_answers;
				}
				$assessment_score['asked'][$value->ss_aw_lesson_id] = $assessment_asked;
				$assessment_score['correct'][$value->ss_aw_lesson_id] = $assessment_correct;
			}
		}
		//end

		//readalong data fetch
		$search_ary = array(
			'ss_aw_child_id' => $child_id,
			'ss_aw_comprehension_read' => 1
		);
		$readalong_lists = $this->ss_aw_schedule_readalong_model->search_byparam($search_ary);
		if (!empty($readalong_lists)) {
			foreach ($readalong_lists as $key => $value) {
				$readalong_lists[$key]['readalong_start_date'] = "NA";
				$check_store_index = $this->ss_aw_store_readalong_page_model->get_first_start_details($child_id, $value['ss_aw_readalong_id']);
				if (!empty($check_store_index)) {
					$readalong_lists[$key]['readalong_start_date'] = date('d/m/Y', strtotime($value['ss_aw_create_date']));
				}
				$check_finish = $this->ss_aw_last_readalong_model->check_readalong_completion($value['ss_aw_readalong_id'], $child_id, $value['ss_aw_start_date'], $value['ss_aw_end_date']);

				$readalong_correct = 0;
				$readalong_asked = 0;
				if (!empty($check_finish)) {
					$readalong_lists[$key]['readalong_complete_date'] = date('d/m/Y', strtotime($check_finish[0]->ss_aw_create_date));
					$readalong_asked_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id']));
					$readalong_asked = count($readalong_asked_questions);
					$readalong_correct_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id'], 'ss_aw_quiz_right_wrong' => 1));
					$readalong_correct = count($readalong_correct_questions);
				} else {
					$readalong_lists[$key]['readalong_complete_date'] = "NA";
				}
				$readalong_lists[$key]['question_asked'] = $readalong_asked;
				$readalong_lists[$key]['question_correct'] = $readalong_correct;
			}
		}
		//end
		//payment details
		$payment_details = $this->ss_aw_child_course_model->get_details($child_id);
		//end
		$data['child_details'] = $child_details;
		$data['login_details'] = $login_details;
		$data['child_enroll_details'] = $child_enroll_details;
		$data['diagnostic_question_asked'] = $diagnostic_question_asked;
		$data['diagnostic_question_correct'] = $diagnostic_question_correct;
		$data['diagnostic_exam_code_details'] = $diagnostic_exam_code_details;
		$data['recomended_level'] = $recomended_level;
		$data['completed_topic_details'] = $completed_topic_details;
		$data['lesson_score'] = $lesson_score;
		$data['assessment_score'] = $assessment_score;
		$data['readalong_lists'] = $readalong_lists;
		$data['payment_details'] = $payment_details;
		$child_details = $this->ss_aw_childs_model->get_details_with_course($child_id);
		$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		$data['parent_details'] = $parent_details;
		$data['child_details'] = $child_details;
		$data['assessment_id_ary'] = $assessment_id_ary;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/user_course_details', $data);
	}

	public function institution_diagnostic_question_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Details";
		$institution_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$page_type = base64_decode($this->uri->segment(5));
		$data = array();

		$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
		$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
		$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
		$asked_question = array();
		if (!empty($diagnostic_question_asked_details)) {
			foreach ($diagnostic_question_asked_details as $key => $value) {
				$asked_question_id = explode(",", $value['ss_aw_diagnostic_id']);
				if (!empty($asked_question_id)) {
					foreach ($asked_question_id as $question_id) {
						if (!empty($question_id)) {
							$asked_question[] = $question_id;
						}
					}
				}
			}
		}

		$asked_question_details = $this->ss_aw_assisment_diagnostic_model->get_bulk_questions($asked_question);
		if (!empty($asked_question_details)) {
			foreach ($asked_question_details as $key => $value) {
				$log_details = $this->ss_aw_diagonastic_exam_log_model->get_details_by_exam_code_question_id($value->ss_aw_id, $exam_code);
				if (!empty($log_details)) {
					$value->correct_answer = $value->correct_answer;
					$value->student_answer = $log_details->ss_aw_diagonastic_log_answers;
					$value->answer_status = $log_details->ss_aw_diagonastic_log_answer_status;
				} else {
					$value->correct_answer = $value->correct_answer;;
					$value->student_answer = "";
					$value->answer_status = 2;
				}
			}
		}
		$data['dianostic_details'] = $asked_question_details;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$data['page_type'] = $page_type;
		$data['program_type'] = "";
		if ($this->uri->segment(6)) {
			$data['program_type'] = base64_decode($this->uri->segment(6));
		}
		$data['userlist_page_no'] = "";
		if ($this->uri->segment(7)) {
			$data['userlist_page_no'] = base64_decode($this->uri->segment(7));
		}
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/diagnosticdetails', $data);
	}

	public function institution_lesson_quiz_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Quiz Details";
		$institution_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$lesson_id = $this->uri->segment(5);
		$page_type = base64_decode($this->uri->segment(6));
		$data = array();
		$data['lesson_details'] = $this->ss_aw_lesson_quiz_ans_model->getlessonquizdetails($child_id, $lesson_id);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$data['page_type'] = $page_type;
		$data['program_type'] = "";
		if ($this->uri->segment(7)) {
			$data['program_type'] = base64_decode($this->uri->segment(6));
		}
		$data['userlist_page_no'] = "";
		if ($this->uri->segment(8)) {
			$data['userlist_page_no'] = base64_decode($this->uri->segment(7));
		}
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/lessondetails', $data);
	}

	public function institution_assessment_quiz_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Quiz Details";
		$institution_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$assessment_id = $this->uri->segment(5);
		$page_type = base64_decode($this->uri->segment(6));
		$data = array();
		$data['assessment_details'] = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);

		$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $data['assessment_details'][0]->ss_aw_assessment_id);
		$exam_code = $assessment_score_details[0]->exam_code;
		if ($data['assessment_details'][0]->ss_aw_assesment_format == 'Single') {
			$question_details = $this->ss_aw_assessment_exam_log_model->getdiagnosticexamdetails($child_id, $exam_code);
		} else {
			$question_details = $this->ss_aw_assesment_multiple_question_answer_model->getdiagnosticexamdetails($child_id, $exam_code);
		}
		$data['question_details'] = $question_details;

		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$data['page_type'] = $page_type;
		$data['program_type'] = "";
		if ($this->uri->segment(7)) {
			$data['program_type'] = base64_decode($this->uri->segment(6));
		}
		$data['userlist_page_no'] = "";
		if ($this->uri->segment(8)) {
			$data['userlist_page_no'] = base64_decode($this->uri->segment(7));
		}
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/assessmentdetails', $data);
	}

	public function institution_readalong_quiz_details()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Quiz Details";
		$institution_id = $this->uri->segment(3);
		$child_id = $this->uri->segment(4);
		$readalong_id = $this->uri->segment(5);
		$page_type = base64_decode($this->uri->segment(6));
		$data = array();
		$question_details = $this->ss_aw_readalong_quiz_ans_model->get_quiz_details($child_id, $readalong_id);
		$readalong_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
		$data['question_details'] = $question_details;
		$data['readalong_details'] = $readalong_details;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$data['page_type'] = $page_type;
		$data['program_type'] = "";
		if ($this->uri->segment(7)) {
			$data['program_type'] = base64_decode($this->uri->segment(6));
		}
		$data['userlist_page_no'] = "";
		if ($this->uri->segment(8)) {
			$data['userlist_page_no'] = base64_decode($this->uri->segment(7));
		}
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/readalongdetails', $data);
	}

	public function institutionpaymentdetails()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Payment History";
		$data = array();
		$institution_id = $this->uri->segment(3);

		$total_record = $this->ss_aw_institution_payment_details_model->total_record($institution_id);
		$redirect_to = base_url() . 'admin/institutionpaymentdetails/' . $institution_id;
		$uri_segment = 4;
		$record_per_page = 10;
		$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		if ($page >= $config["total_rows"]) {
			$page = 0;
		}
		$payment_history = $this->ss_aw_institution_payment_details_model->get_payment_details($institution_id, $config['per_page'], $page);
		$data['payment_history'] = $payment_history;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/payment_history', $data);
	}

	public function removeuser()
	{
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$child_id = $postdata['parent_delete_id'];
			$child_details = $this->ss_aw_childs_model->get_details($child_id);
			if (empty($child_details[0]['ss_aw_child_username'])) {
				$parent_id = $child_details[0]['ss_aw_parent_id'];
				$update_data = array(
					'ss_aw_parent_status' => 0,
					'ss_aw_parent_delete' => 1
				);
				$this->ss_aw_parents_model->update_parent_details($update_data, $parent_id);
			}
			$this->ss_aw_childs_model->remove_institution_user($child_id);
			if (!empty($child_details[0]['ss_aw_institution_user_upload_id'])) {
				$excel_upload_id = $child_details[0]['ss_aw_institution_user_upload_id'];
				$student_upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($excel_upload_id);
				$updated_student_num = $student_upload_details->ss_aw_student_number - 1;
				if ($updated_student_num == 0) {
					$this->ss_aw_institution_student_upload_model->remove_record($excel_upload_id);
				} else {
					$data = array(
						'ss_aw_student_number' => $updated_student_num
					);
					$this->ss_aw_institution_student_upload_model->update_record($data, $excel_upload_id);
				}
			}
			$this->session->set_flashdata('success', 'Record removed successfully.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_admin_password()
	{
		$admin_id = $this->uri->segment(3);
		$admin_details = $this->ss_aw_admin_users_model->getrecordbyid($admin_id);
		$email = $admin_details->ss_aw_admin_user_email;
		$random_password = generate_random_letters(8);
		$data = array(
			'ss_aw_admin_user_id' => $admin_id,
			'ss_aw_admin_user_password' => $this->bcrypt->hash_password($random_password)
		);
		$this->ss_aw_admin_users_model->update_details($data);
		$subject = "team Admin Reset Password";
		$msg = "Password reset successfully.Your new password : " . $random_password;
		emailnotification($email, $subject, $msg);
		$this->session->set_flashdata('success', 'Password reset successfully.');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function institutionreportdashboard()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Report Dashboard";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$data = array();
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/report_dashboard', $data);
	}

	public function institution_individual_performance()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Individual Performance";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}
		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('individual_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('individual_programme_type') ? $this->session->userdata('individual_programme_type') : 1;
		$searchdata = array();
		$searchdata['programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$topic_listary = array();
		$general_language_lessons = array();
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get comprehensions
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
			//champions child is not set for the institution
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

		$total_record = $this->ss_aw_childs_model->get_programee_users_count($institution_users_id, $programme_type);
		$redirect_to = base_url() . 'admin/institution_individual_performance/' . $institution_id;
		$uri_segment = 4;
		$record_per_page = 10;
		$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		if ($page >= $config["total_rows"]) {
			$page = 0;
		}
		$datper = array();
		$performance = $this->module_wise_performance_model->get_module_individual_performence_data($institution_id, $search_data['ss_aw_expertise_level'], $programme_type);
		if (!empty($performance)) {
			foreach ($performance as $per) {
				$datper[$per['ss_aw_child_id']][$per['ss_aw_lession_id']] = $per;
			}
		}
		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, $config['per_page'], $page);
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				//diagnostic section
				$diagnostic_exam_complete_date = "";
				$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
				if (!empty($diagnostic_exam_code_details)) {
					$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
					$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					$diagnosticcorrectnum[$child_id] = get_percentage(DIAGNOSTIC_QUESTION_NUM, $diagnostic_question_correct) . "%";
					$diagnostic_exam_complete_date = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_date;
				} else {
					$diagnostic_question_correct = 0;
					$diagnosticcorrectnum[$child_id] = "NA";
				}
			}
		}



		$data['topics'] = $lesson_listary;
		$data['childs'] = $childs;
		$data['performence'] = $datper;
		$data['diagnosticcorrectnum'] = $diagnosticcorrectnum;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/individual_performance', $data);
	}
	
	public function institution_individual_performance_old()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Individual Performance";
		$data = array();

		$institution_id = $this->uri->segment(3);
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('individual_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('individual_programme_type') ? $this->session->userdata('individual_programme_type') : 1;
		$searchdata = array();
		$searchdata['programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$topic_listary = array();
		$general_language_lessons=array();
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get comprehensions
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
			//champions child is not set for the institution
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
		//get score data
		$diagnosticcorrectnum = array();
		$lessonscoredata = array();
		$assessment_id_ary = array();
		$assessmentscoredata = array();
		$readalongscore = array();
		$readalong_id_ary = array();

		$total_record = $this->ss_aw_childs_model->get_programee_users_count($institution_users_id, $programme_type);
		$redirect_to = base_url() . 'admin/institution_individual_performance/' . $institution_id;
		$uri_segment = 4;
		$record_per_page = 10;
		$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		if ($page >= $config["total_rows"]) {
			$page = 0;
		}

		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, $config['per_page'], $page);
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;

				//diagnostic section
				$diagnostic_exam_complete_date = "";
				$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
				if (!empty($diagnostic_exam_code_details)) {
					$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
					$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					$diagnosticcorrectnum[$child_id] = get_percentage(DIAGNOSTIC_QUESTION_NUM, $diagnostic_question_correct) . "%";
					$diagnostic_exam_complete_date = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_date;
				} else {
					$diagnostic_question_correct = 0;
					$diagnosticcorrectnum[$child_id] = "NA";
				}

				//lesson assessment and readalong section
				$finish_record_id = array();
				if (!empty($lesson_listary)) {
					$prev_assessment_complete_date = "";
					foreach ($lesson_listary as $i => $lesson_topic) {
						if ($i == 0) {
							$prev_assessment_complete_date = date('Y-m-d', strtotime($diagnostic_exam_complete_date));
						}
						//lesson section
						$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_topic['ss_aw_lession_id']);
						$lesson_asked = 0;
						$lesson_correct = 0;
						$lesson_complete_date = "";
						$lesson_start_date = "";
						if (!empty($lesson_score_details)) {
							$lesson_asked = $lesson_score_details[0]->total_question;
							$lesson_correct = $lesson_score_details[0]->wright_answers;
							$lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_topic['ss_aw_lession_id'], $child_id);
							$lesson_complete_date = $lesson_complete_details->ss_aw_last_lesson_modified_date;
							$lesson_start_date = $lesson_complete_details->ss_aw_last_lesson_create_date;
						}
						$lesson_score = $lesson_asked > 0 ? get_percentage($lesson_asked, $lesson_correct) . "%" : "NA";
						$lessonscoredata[$child_id][$lesson_topic['ss_aw_lession_id']] = $lesson_score;
						//end

						//assessment section
						$assessment_id = "";
						$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $lesson_topic['ss_aw_lession_id']);
						if (!empty($topical_assessment_start_details)) {
							$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
						} else {
							$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $lesson_topic['ss_aw_lession_id']);
							$assessment_id = !empty($comprehension_assessment_start_details) ? $comprehension_assessment_start_details[0]->ss_aw_assessment_id : '';
						}
						$assessment_id_ary[$child_id][$lesson_topic['ss_aw_lession_id']] = $assessment_id;
						$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
						$assessment_asked = 0;
						$assessment_correct = 0;
						if (!empty($assessment_score_details)) {
							$assessment_asked = $assessment_score_details[0]->total_question;
							$assessment_correct = $assessment_score_details[0]->wright_answers;
						}
						$assessment_score = $assessment_asked > 0 ? get_percentage($assessment_asked, $assessment_correct) . "%" : "NA";
						$assessmentscoredata[$child_id][$lesson_topic['ss_aw_lession_id']] = $assessment_score;
						$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
						if (!empty($assessment_completetion_details)) {
							$assessment_complete_date = $assessment_completetion_details[0]->ss_aw_create_date;
							$module_complete_day_gap = daysDifferent(strtotime($lesson_start_date), strtotime($assessment_complete_date));
							if ($module_complete_day_gap < 7) {
								$prev_assessment_complete_date = date('Y-m-d', strtotime($lesson_start_date . " +7 day"));
							} else {
								$prev_assessment_complete_date = date('Y-m-d', strtotime($assessment_complete_date));
							}
						}
						//end		
					}
				}
			}
		}
		//end
		$data['topics'] = $lesson_listary;
		$data['childs'] = $childs;
		$data['assessment_id_ary'] = $assessment_id_ary;
		$data['assessmentscoredata'] = $assessmentscoredata;
		$data['lessonscoredata'] = $lessonscoredata;
		$data['diagnosticcorrectnum'] = $diagnosticcorrectnum;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/individual_performance', $data);
	}

	public function institution_module_wise_incomplete_performance()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Users yet to Complete Modules";
		$data = array();

		$institution_id = $this->uri->segment(3);
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('incomplete_users_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('incomplete_users_programme_type') ? $this->session->userdata('incomplete_users_programme_type') : 1;

		$searchdata = array();
		$searchdata['incomplete_user_programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$topic_listary = array();
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get comprehensions
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//champions child is not set for the institution
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
		$lesson_listary = array_merge($topical_lessons);
		//get score data
		$diagnosticincompletenum = 0;
		$diagnosticincompletechilds = array();

		$lessonincompletenum = array();
		$lessonincompletechilds = array();
		$lessonnonaccessable = array();

		$assessmentincompletenum = array();
		$assessmentincompletechilds = array();
		$assessmentnonaccessable = array();

		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);

		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				if (empty($value->ss_aw_diagonastic_exam_date)) {
					$diagnosticincompletenum++;
					$diagnosticincompletechilds[] = $child_id;
				}
			}
		}

		//lesson assessment and readalong section
		$getdata = $this->module_wise_performance_model->getmodulewisenoncompletedata($institution_id, $search_data['ss_aw_expertise_level'], $programme_type);
		
		$data['topics'] = $lesson_listary;
		$data['childs'] = $childs;
		$data['diagnosticincompletenum'] = $diagnosticincompletenum;
		$data['diagnosticincompletechilds'] = $diagnosticincompletechilds;
		$data['getdata'] = $getdata;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/module_wise_incomplete_performance', $data);
	}



	public function institution_module_wise_incomplete_performance_old()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Users yet to Complete Modules";
		$data = array();

		$institution_id = $this->uri->segment(3);
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('incomplete_users_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('incomplete_users_programme_type') ? $this->session->userdata('incomplete_users_programme_type') : 1;

		$searchdata = array();
		$searchdata['incomplete_user_programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$topic_listary = array();
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get comprehensions
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//champions child is not set for the institution
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
		$lesson_listary = array_merge($topical_lessons);
		//get score data
		$diagnosticincompletenum = 0;
		$diagnosticincompletechilds = array();

		$lessonincompletenum = array();
		$lessonincompletechilds = array();
		$lessonnonaccessable = array();

		$assessmentincompletenum = array();
		$assessmentincompletechilds = array();
		$assessmentnonaccessable = array();

		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);

		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				if (empty($value->ss_aw_diagonastic_exam_date)) {
					$diagnosticincompletenum++;
					$diagnosticincompletechilds[] = $child_id;
				}
			}
		}

		//lesson assessment and readalong section
		if (!empty($lesson_listary)) {
			foreach ($lesson_listary as $i => $lesson_topic) {
				$lesson_id = $lesson_topic['ss_aw_lession_id'];

				$lessonincompletenum[$lesson_id] = 0;
				$lessonincompletechilds[$lesson_id] = array();
				$lessonnonaccessable[$lesson_id] = 0;

				$assessmentincompletenum[$lesson_id] = 0;
				$assessmentincompletechilds[$lesson_id] = array();
				$assessmentnonaccessable[$lesson_id] = 0;

				if (!empty($childs)) {
					foreach ($childs as $key => $value) {
						$child_id = $value->ss_aw_child_id; {
							if (!empty($value->ss_aw_diagonastic_exam_date)) {
								$accessable = 0;
								if ($i == 0) {
									$accessable = 1;
									$readalong_start_date = date('Y-m-d', strtotime($value->ss_aw_diagonastic_exam_date));
								} else {
									$prev_lesson_id = $lesson_listary[$i - 1]['ss_aw_lession_id'];
									$prev_lesson_complete_date = "";
									$prev_lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_listary[$i - 1]['ss_aw_lession_id'], $child_id);

									//check prev assessment complete or not
									//if assessment not complete then upcoming lesson will not open.
									$prev_assessment_id = "";
									$prev_topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $prev_lesson_id);
									if (!empty($prev_topical_assessment_start_details)) {
										$prev_assessment_id = $prev_topical_assessment_start_details[0]->ss_aw_assessment_id;
									} else {
										$prev_comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $prev_lesson_id);
										$prev_assessment_id = $prev_comprehension_assessment_start_details[0]->ss_aw_assessment_id;
									}

									$prev_assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $prev_assessment_id);

									if (!empty($prev_lesson_complete_details) && !empty($prev_assessment_score_details)) {
										//assessment exam complete details
										$prev_assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($prev_assessment_id, $child_id);
										$prev_assessment_complete_date = $prev_assessment_completetion_details[0]->ss_aw_create_date;
										$module_complete_day_gap = daysDifferent(strtotime($prev_lesson_complete_details->ss_aw_last_lesson_create_date), strtotime($prev_assessment_complete_date));
										if ($module_complete_day_gap < 7) {
											$readalong_start_date = date('Y-m-d', strtotime($prev_lesson_complete_details->ss_aw_last_lesson_create_date . " +7 day"));
										} else {
											$readalong_start_date = date('Y-m-d', strtotime($prev_assessment_complete_date));
										}
										//end
										$prev_lesson_start_date = $prev_lesson_complete_details->ss_aw_last_lesson_create_date;
										$prev_lesson_complete_date = $prev_lesson_complete_details->ss_aw_last_lesson_modified_date;
										$accessDate = date('Y-m-d', strtotime($prev_lesson_start_date . " + 7 day"));
										$accessTime = strtotime($accessDate);
										$current_date = date('Y-m-d');
										$currentTime = strtotime($current_date);
										if (($currentTime >= $accessTime)) {
											$accessable = 1;
										}
									}
								}

								$lesson_complete_date = "";
								if ($accessable) {
									$lessonnonaccessable[$lesson_id]++;
									//lesson section
									$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_id);
									if (empty($lesson_score_details)) {
										$lessonincompletenum[$lesson_id] = $lessonincompletenum[$lesson_id] + 1;
										$lessonincompletechilds[$lesson_id][] = $child_id;
									} else {
										$lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_id, $child_id);
										$lesson_complete_date = $lesson_complete_details->ss_aw_last_lesson_modified_date;
									}
									//end

									{
										$assessmentnonaccessable[$lesson_id]++;

										//assessment section
										$assessment_id = "";
										$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $lesson_id);
										if (!empty($topical_assessment_start_details)) {
											$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
										} else {
											$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $lesson_id);
											$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
										}

										$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
										if (empty($assessment_score_details)) {
											$assessmentincompletenum[$lesson_id]++;
											$assessmentincompletechilds[$lesson_id][] = $child_id;
										}
										//end
									}
								}
							}
						}
					}
				}
			}
		}
		//end
		$data['topics'] = $lesson_listary;
		$data['childs'] = $childs;
		$data['diagnosticincompletenum'] = $diagnosticincompletenum;
		$data['diagnosticincompletechilds'] = $diagnosticincompletechilds;
		$data['getdata'] = $getdata;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/module_wise_incomplete_performance', $data);
	}

	public function diagnostic_incomplete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Incomplete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/diagnostic_incomplete_users', $data);
	}

	public function lesson_incomplete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Incomplete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/lesson_incomplete_users', $data);
	}

	public function assessment_incomplete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Incomplete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/assessment_incomplete_users', $data);
	}

	public function readalong_incomplete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Incomplete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/readalong_incomplete_users', $data);
	}

	public function institution_module_wise_complete_performance()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Module-wise Completion Status";
		$data = array();

		$institution_id = $this->uri->segment(3);

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('complete_users_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('complete_users_programme_type') ? $this->session->userdata('complete_users_programme_type') : 1;

		$searchdata = array();
		$searchdata['complete_user_programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$topic_listary = array();
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			//get comprehensions
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			//champions child is not set for the institution
		} else {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'A,M';
		}
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}
		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);
		$getdata = $this->module_wise_performance_model->getmodulewisereportdata($institution_id, $search_data['ss_aw_expertise_level'], $programme_type);
		// echo $this->db->last_query();
		// echo "<pre>";
		// print_r($getdata);
		// die();

		$diagnostic_complete_log = $this->ss_aw_diagnostic_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
		$data['diagnostic_complete_log'] = $diagnostic_complete_log;
		$topics_complete_log = $this->ss_aw_topics_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
		$topical_log_details = array();
		if (!empty($topics_complete_log)) {
			foreach ($topics_complete_log as $key => $value) {
				$topical_log_details[$value->ss_aw_lesson_id] = $value;
			}
		}
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				if (!empty($value->ss_aw_diagonastic_exam_date)) {
					$diagnosticcompletenum++;
					$diagnosticcompletechilds[] = $child_id;
				}
			}
		}

		$data['topical_log_details'] = $topical_log_details;
		$data['childs'] = $childs;
		$data['diagnosticcompletenum'] = $diagnosticcompletenum;
		$data['diagnosticcompletechilds'] = $diagnosticcompletechilds;
		$data['topics'] = $getdata;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/module_wise_complete_performance', $data);
	}

	public function institution_module_wise_complete_performance_old()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Module-wise Completion Status";
		$data = array();

		$institution_id = $this->uri->segment(3);

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('complete_users_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('complete_users_programme_type') ? $this->session->userdata('complete_users_programme_type') : 1;

		$searchdata = array();
		$searchdata['complete_user_programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$topic_listary = array();
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			//get comprehensions
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			//champions child is not set for the institution
		} else {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'A,M';
		}
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}
		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);
		$start = time();
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				if (!empty($value->ss_aw_diagonastic_exam_date)) {
					$diagnosticcompletenum++;
					$diagnosticcompletechilds[] = $child_id;
				}
			}
		}

		//lesson assessment and readalong section
		$loop_count = 0;
		if (!empty($lesson_listary)) {
			foreach ($lesson_listary as $i => $lesson_topic) {
				$loop_count++;
				$lesson_id = $lesson_topic['ss_aw_lession_id'];

				$lessoncompletenum[$lesson_id] = 0;
				$lessoncompletechilds[$lesson_id] = array();
				$lessonnonaccessable[$lesson_id] = 0;

				$assessmentcompletenum[$lesson_id] = 0;
				$assessmentcompletechilds[$lesson_id] = array();
				$assessmentnonaccessable[$lesson_id] = 0;

				if (!empty($childs)) {
					foreach ($childs as $key => $value) {
						$loop_count++;
						$lesson_complete_date = "";
						$child_id = $value->ss_aw_child_id;
						if (!empty($value->ss_aw_diagonastic_exam_date)) {
							$child_activation_date = date('Y-m-d', strtotime($value->ss_aw_diagonastic_exam_date)); {
								$accessable = 0;
								if ($i == 0) {
									$accessable = 1;
									$readalong_start_date = $child_activation_date;
								} else {
									$prev_lesson_id = $lesson_listary[$i - 1]['ss_aw_lession_id'];
									$prev_lesson_complete_date = "";
									$prev_lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_listary[$i - 1]['ss_aw_lession_id'], $child_id);

									//check prev assessment complete or not
									//if assessment not complete then upcoming lesson will not open.
									$prev_assessment_id = "";
									$prev_topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $prev_lesson_id);
									if (!empty($prev_topical_assessment_start_details)) {
										$prev_assessment_id = $prev_topical_assessment_start_details[0]->ss_aw_assessment_id;
									} else {
										$prev_comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $prev_lesson_id);
										$prev_assessment_id = $prev_comprehension_assessment_start_details[0]->ss_aw_assessment_id;
									}

									$prev_assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $prev_assessment_id);

									if (!empty($prev_lesson_complete_details) && !empty($prev_assessment_score_details)) {
										//assessment exam complete details
										$prev_assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($prev_assessment_id, $child_id);
										$prev_assessment_complete_date = $prev_assessment_completetion_details[0]->ss_aw_create_date;
										$module_complete_day_gap = daysDifferent(strtotime($prev_lesson_complete_details->ss_aw_last_lesson_create_date), strtotime($prev_assessment_complete_date));
										if ($module_complete_day_gap < 7) {
											$readalong_start_date = date('Y-m-d', strtotime($prev_lesson_complete_details->ss_aw_last_lesson_create_date . " +7 day"));
										} else {
											$readalong_start_date = date('Y-m-d', strtotime($prev_assessment_complete_date));
										}
										//end
										$prev_lesson_start_date = $prev_lesson_complete_details->ss_aw_last_lesson_create_date;
										$prev_lesson_complete_date = $prev_lesson_complete_details->ss_aw_last_lesson_modified_date;
										$accessDate = date('Y-m-d', strtotime($prev_lesson_start_date . " + 7 day"));
										$accessTime = strtotime($accessDate);
										$current_date = date('Y-m-d');
										$currentTime = strtotime($current_date);
										if (($currentTime >= $accessTime)) {
											$accessable = 1;
										}
									}
								}

								$lesson_complete_date = "";
								if ($accessable) {
									$lessonnonaccessable[$lesson_id]++;

									//lesson section
									$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_id);
									if (!empty($lesson_score_details)) {
										$lessoncompletenum[$lesson_id] = $lessoncompletenum[$lesson_id] + 1;
										$lessoncompletechilds[$lesson_id][] = $child_id;

										$lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_id, $child_id);
										$lesson_complete_date = $lesson_complete_details->ss_aw_last_lesson_modified_date;
									}
									//end

									if (!empty($lesson_complete_date)) {
										$assessmentnonaccessable[$lesson_id]++;
										//assessment section
										$assessment_id = "";
										$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $lesson_id);
										if (!empty($topical_assessment_start_details)) {
											$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
										} else {
											$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
											$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
										}

										$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
										if (!empty($assessment_score_details)) {
											$assessmentcompletenum[$lesson_id]++;
											$assessmentcompletechilds[$lesson_id][] = $child_id;
										}
										//end
									}
								}
							}
						}
					}
				}
			}
		}
		//end

		$end = time();

		$executionTime = $end - $start;

		// Output the result
		echo "Script execution time: " . $executionTime . " seconds" . $loop_count;
		die();
		$diagnostic_complete_log = $this->ss_aw_diagnostic_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
		$data['diagnostic_complete_log'] = $diagnostic_complete_log;
		$topics_complete_log = $this->ss_aw_topics_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
		$topical_log_details = array();
		if (!empty($topics_complete_log)) {
			foreach ($topics_complete_log as $key => $value) {
				$topical_log_details[$value->ss_aw_lesson_id] = $value;
			}
		}
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				if (!empty($value->ss_aw_diagonastic_exam_date)) {
					$diagnosticcompletenum++;
					$diagnosticcompletechilds[] = $child_id;
				}
			}
		}

		$data['topical_log_details'] = $topical_log_details;
		$data['childs'] = $childs;
		$data['diagnosticcompletenum'] = $diagnosticcompletenum;
		$data['diagnosticcompletechilds'] = $diagnosticcompletechilds;
		$data['topics'] = $getdata;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/module_wise_complete_performance', $data);
	}

	public function diagnostic_complete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Complete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		if ($this->uri->segment(5)) {
			$data['page_type'] = base64_decode($this->uri->segment(5));
		} else {
			$data['page_type'] = "";
		}
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/diagnostic_complete_users', $data);
	}

	public function lesson_complete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Complete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/lesson_complete_users', $data);
	}

	public function assessment_complete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Complete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		if ($this->uri->segment(5)) {
			$data['page_type'] = base64_decode($this->uri->segment(5));
		} else {
			$data['page_type'] = "";
		}
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/assessment_complete_users', $data);
	}

	public function readalong_complete_users()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Complete Users";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/readalong_complete_users', $data);
	}

	public function institution_combined_performance()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Combined Performance";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}

		$programme_type = 1;
		if ($this->input->post()) {
			$programme_type = $this->input->post('programme_type');
		}

		$searchdata = array();
		$searchdata['combined_programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;
		$topic_listary = array();
		$general_language_lessons = array();

		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		} elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
			//champions child is not set for the institution
		} else {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'A,M';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get all childs			
		}
		$topicAry = array();
		if (!empty($topic_listary)) {
			foreach ($topic_listary as $key => $value) {
				$topicAry[] = $value->ss_aw_section_id;
			}
		}
		$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);
		$lesson_listary = array_merge($topical_lessons, $general_language_lessons);

		$topic_names = array();
		$lesson0to25 = array();
		$lesson25to50 = array();
		$lesson50to75 = array();
		$lesson75to100 = array();

		$assessment0to25 = array();
		$assessment25to50 = array();
		$assessment50to75 = array();
		$assessment75to100 = array();

		$lesson_avg_score = array();
		$assessment_avg_score = array();
		$total_lesson_assessment_user_num = array();

		$cmb_lesson = $this->module_wise_performance_model->getcombinelessondata($institution_id, $search_data['ss_aw_expertise_level'], $programme_type);
		
		$cmb_assess = $this->module_wise_performance_model->getcombineassesdata($institution_id, $search_data['ss_aw_expertise_level'], $programme_type);

		if (!empty($lesson_listary)) {
			foreach ($lesson_listary as $key => $lesson_topic) {
				$topic_names[] = $lesson_topic['ss_aw_lesson_topic'];
				$lesson_id = $lesson_topic['ss_aw_lession_id'];
				$arr_key = array_search($lesson_id, array_column($cmb_lesson, 'ss_aw_lession_id'));
				$lesson0to25[] = $cmb_lesson["$arr_key"]['lesson_upto25'];
				$lesson25to50[] = $cmb_lesson["$arr_key"]['lesson_upto50'];
				$lesson50to75[] = $cmb_lesson["$arr_key"]['lesson_upto75'];
				$lesson75to100[] = $cmb_lesson["$arr_key"]['lesson_upto100'];

				$lesson_avg_score[] = $cmb_lesson["$arr_key"]['average_lesson_score'] != 0 ? $cmb_lesson["$arr_key"]['average_lesson_score'] : '';
				$lesson_attend_child_num = $cmb_lesson["$arr_key"]['child'] != 0 ? $cmb_lesson["$arr_key"]['child'] : '';

				$arr_key_as = array_search($lesson_id, array_column($cmb_assess, 'ss_aw_lession_id'));
				$assessment0to25[] = $cmb_assess["$arr_key_as"]['assess_upto25'];
				$assessment25to50[] = $cmb_assess["$arr_key_as"]['assess_upto50'];
				$assessment50to75[] = $cmb_assess["$arr_key_as"]['assess_upto75'];
				$assessment75to100[] = $cmb_assess["$arr_key_as"]['assess_upto100'];

				$assessment_avg_score[] = $cmb_assess["$arr_key_as"]['average_assessment_score'] != "" ? $cmb_assess["$arr_key_as"]['average_assessment_score'] : '';
				$assessment_attend_child_num = $cmb_assess["$arr_key_as"]['child'] != 0 ? $cmb_assess["$arr_key_as"]['child'] : '';

				$total_lesson_assessment_user_num[] = array($lesson_attend_child_num, $assessment_attend_child_num);
			}
		}

		$data['topics'] = json_encode($topic_names);

		$data['lesson0to25'] = json_encode($lesson0to25);
		$data['lesson25to50'] = json_encode($lesson25to50);
		$data['lesson50to75'] = json_encode($lesson50to75);
		$data['lesson75to100'] = json_encode($lesson75to100);

		$data['assessment0to25'] = json_encode($assessment0to25);
		$data['assessment25to50'] = json_encode($assessment25to50);
		$data['assessment50to75'] = json_encode($assessment50to75);
		$data['assessment75to100'] = json_encode($assessment75to100);

		$data['lesson_avg_score'] = json_encode($lesson_avg_score);
		$data['assessment_avg_score'] = json_encode($assessment_avg_score);

		$data['total_lesson_assessment_user_num'] = json_encode($total_lesson_assessment_user_num);

		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/combined_performance', $data);
	}

	public function institutionmanagepayment()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Manage Payments";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$result = $this->ss_aw_institution_student_upload_model->get_institution_upload_records($institution_id);
		$payment_status = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$payment_status[$value->ss_aw_id] = $this->ss_aw_institution_payment_details_model->check_paid_status($value->ss_aw_id);
			}
		}
		$data['result'] = $result;
		$data['payment_status'] = $payment_status;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/managepayments', $data);
	}

	public function institution_upload_user_list()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Uploaded Users List";
		$data = array();
		$institution_id = $this->uri->segment(3);
		$upload_record_id = $this->uri->segment(4);
		$user_upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($upload_record_id);
		$result = $this->ss_aw_childs_model->get_record_by_upload_id($upload_record_id);
		$lessoncount = array();
		$assessmentcount = array();
		$readalongcount = array();
		$diagnostictotalquestion = array();
		$diagnosticcorrectquestion = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$child_id = $value->ss_aw_child_id;
				$duration = "";
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				if (!empty($childary)) {
					$value->course = $childary[count($childary) - 1]['ss_aw_course_id'];
					$lessoncount[$value->ss_aw_child_id] = $this->ss_aw_child_last_lesson_model->gettotalcompletenum($value->ss_aw_child_id, $value->course);
					$assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenumbychild($value->ss_aw_child_id);

					$readalongcount[$value->ss_aw_child_id] = $this->ss_aw_last_readalong_model->gettotalcompletenum($value->ss_aw_child_id, $value->course);

					//get diagnostic exam details
					$diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($value->ss_aw_child_id);
					if (!empty($diagnostic_exam_code_details)) {
						$exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
						$diagnostic_question_asked_details = $this->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam(array('ss_aw_diagonastic_exam_code' => $exam_code));
						$diagnostic_question_asked = DIAGNOSTIC_QUESTION_NUM;
						$diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					} else {
						$diagnostic_question_asked = 0;
						$diagnostic_question_correct = 0;
					}
					$diagnostictotalquestion[$value->ss_aw_child_id] = $diagnostic_question_asked;
					$diagnosticcorrectquestion[$value->ss_aw_child_id] = $diagnostic_question_correct;
					//end

					//get child course details
					$course_details[$value->ss_aw_child_id] = $this->ss_aw_childs_model->get_details_with_course($value->ss_aw_child_id);
					//end
				}
			}
		}

		$data['child_details'] = $result;
		$data['lessoncount'] = $lessoncount;
		$data['assessmentcount'] = $assessmentcount;
		$data['readalongcount'] = $readalongcount;
		$data['diagnostictotalquestion'] = $diagnostictotalquestion;
		$data['diagnosticcorrectquestion'] = $diagnosticcorrectquestion;
		$data['course_details'] = $course_details;
		$data['user_upload_details'] = $user_upload_details;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/uploadeduserslist', $data);
	}

	public function institution_make_payment()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Make Payment";
		$institution_id = $this->uri->segment(3);
		$upload_id = $this->uri->segment(4);
		$data = array();
		$check_payment = $this->ss_aw_institution_payment_details_model->check_lumpsum_payment($upload_id);
		if ($check_payment > 0) {
			$this->session->set_flashdata('success', 'Payment already done.');
			redirect('institution/manage_payment');
		}
		$upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($upload_id);
		$payment_history = array();
		$payment_history = $this->ss_aw_institution_payment_details_model->gethistory($upload_details->ss_aw_id);
		$institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['upload_details'] = $upload_details;
		$data['institution_details'] = $institution_details;
		$institution_admin_details = $this->ss_aw_parents_model->get_institutions_admin($institution_id);
		$data['institution_admin_details'] = $institution_admin_details;
		if (!empty($payment_history)) {
			$data['payment_history'] = json_encode($payment_history);
		} else {
			$data['payment_history'] = "";
		}

		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/makepayments', $data);
	}

	public function check_pan_gst()
	{
		$excel_upload_id = $this->input->post('excel_upload_id');
		$upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($excel_upload_id);
		$pan_no = "";
		$gst_no = "";
		if (!empty($upload_details)) {
			$institution_id = $upload_details->ss_aw_institution_id;
			$institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
			$pan_no = $institution_details->ss_aw_pan_no;
			$gst_no = $institution_details->ss_aw_gst_no;
			if (empty($institution_details->ss_aw_pan_no) && empty($institution_details->ss_aw_gst_no)) {
				$status = 400;
			} elseif (!empty($institution_details->ss_aw_pan_no) && empty($institution_details->ss_aw_gst_no)) {
				$status = 420;
			} else {
				$status = 200;
			}
		} else {
			$status = 400;
		}
		$responseary = array();
		$responseary['status'] = $status;
		$responseary['institution_id'] = $institution_id;
		$responseary['pan_no'] = $pan_no;
		$responseary['gst_no'] = $gst_no;
		echo json_encode($responseary);
	}

	public function add_pan_gst()
	{
		$postdata = $this->input->post();
		$pan_no = $postdata['pan_no'];
		$gst_no = $postdata['gst_no'];
		$institution_id = $postdata['institution_id'];
		$excel_upload_id = $postdata['excel_upload_id'];
		$data = array(
			'ss_aw_pan_no' => $pan_no,
			'ss_aw_gst_no' => $gst_no
		);
		$this->ss_aw_institutions_model->update_record($data, $institution_id);
		$this->session->set_flashdata('institution_id', $institution_id);
		$this->session->set_flashdata('excel_upload_id', $excel_upload_id);
		redirect('admin/institutionmanagepayment/' . $institution_id);
	}

	public function institution_bulk_payment()
	{
		$postdata = $this->input->post();
		if (!empty($postdata)) {
			$parent_id = $postdata['parent_id'];
			$institution_id = $postdata['institution_id'];
			$course_id = $postdata['course_id'];
			$chk_discount_coupon = $postdata['chk_discount_coupon'];
			$transaction_id = $postdata['transaction_id'];
			$payment_amount = $postdata['payment_amount']; //9.99
			$payment_amount_without_gst = ($payment_amount * 100) / 118;
			$payment_amount_without_gst = round($payment_amount_without_gst * 100) / 100;
			$discount_amount = $postdata['discount_amount']; //161.02
			//$discount_amount_with_gst = ($discount_amount * 118) / 100;//37.996
			//$discount_amount_with_gst = round($discount_amount_with_gst, 2);//38.00
			//$payment_amount_without_gst = $payment_amount_without_gst + $discount_amount;//40.00
			//$payment_amount = ($payment_amount_without_gst * 118) / 100;
			//$payment_amount = round($payment_amount * 100) / 100;
			$coupon_code = $postdata['coupon_code'];
			$payment_type = $postdata['payment_type']; //1=lumpsum,2=emi
			$gst_rate = ($payment_amount_without_gst * 18) / 100;
			$gst_rate = round($gst_rate * 100) / 100;
			//$course_price = ($payment_amount * 100) / (100 + 18);//33.898
			//$course_price = round($course_price, 2);//33.90
			//$gst_rate = $payment_amount - $course_price;//6.1
			// if ($discount_amount > 0) {
			// 	$payment_amount = $course_price - $discount_amount;//1.7
			// 	$gst_rate = ($payment_amount * 18) / 100;//0.30
			// 	$gst_rate = floor($gst_rate * 100) / 100;
			// 	$payment_amount = $payment_amount + $gst_rate;//2.00
			// }

			$excel_upload_id = $postdata['excel_upload_id'];
			$invoice_prefix = "ALWS/IST/";
			$invoice_suffix = "/" . date('m') . date('y');
			$get_last_invoice_details = $this->ss_aw_institution_payment_details_model->get_last_record();
			if (!empty($get_last_invoice_details)) {
				$invoice_ary = explode("/", $get_last_invoice_details->ss_aw_payment_invoice);
				if (!empty($invoice_ary)) {
					if (!empty($invoice_ary[2])) {
						if (is_numeric($invoice_ary[2])) {
							$suffix_num = (int)$invoice_ary[2] + 1;
							$invoice_no = $invoice_prefix . $suffix_num;
						} else {
							$invoice_no = $invoice_prefix . "100001";
						}
					} else {
						$invoice_no = $invoice_prefix . "100001";
					}
				} else {
					$invoice_no = $invoice_prefix . "100001";
				}
			} else {
				$invoice_no = $invoice_prefix . "100001";
			}
			$invoice_no = $invoice_no . $invoice_suffix;

			//generate PDF code
			$data = array();
			$data['transaction_id'] = $transaction_id;
			$data['payment_amount'] = $payment_amount;
			$data['course_id'] = $course_id;
			$data['invoice_no'] = $invoice_no;
			$institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
			$data['institution_details'] = $institution_details;
			$data['discount_amount'] = $discount_amount;
			$data['gst_rate'] = $gst_rate;
			$data['coupon_id'] = $discount_amount > 0 ? $coupon_code : "";
			$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => $course_id));
			$data['payment_type'] = $payment_type == 1 ? 0 : 1;

			$this->load->library('pdf');
			$html = $this->load->view('pdf/institutepaymentinvoice', $data, true);

			$filename = time() . rand() . ".pdf";
			$save_file_path = "./payment_invoice/" . $filename;
			$this->pdf->createPDF($save_file_path, $html, $filename, false);
			$payment_invoice_file_path = base_url() . "payment_invoice/" . $filename;
			//END

			//get all student under the specified excel sheet id
			$paid_childs = array();
			$childs = $this->ss_aw_childs_model->get_record_by_upload_id($excel_upload_id);
			if (!empty($childs)) {
				foreach ($childs as $key => $value) {
					$paid_childs[] = $value->ss_aw_child_id;
					$student_upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($excel_upload_id);
					if ($payment_type == 1) {
						$course_name = "";
						if ($course_id == 1) {
							$email_template = getemailandpushnotification(7, 1, 2);
							$app_template = getemailandpushnotification(7, 2, 2);
							$action_id = 9;
							$course_name = Winners;
						} elseif ($course_id == 3) {
							$email_template = getemailandpushnotification(32, 1, 2);
							$app_template = getemailandpushnotification(32, 2, 2);
							$action_id = 11;
							$course_name = Champions;
						} else {
							$email_template = getemailandpushnotification(33, 1, 2);
							$app_template = getemailandpushnotification(33, 2, 2);
							$action_id = 11;
							$course_name = Master . "s";
						}
						$month_date = date('d/m/Y');
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
							$body = str_ireplace("[@@child_code@@]", $value->ss_aw_child_username, $body);
							$body = str_ireplace("[@@month_date@@]", $month_date, $body);
							$body = str_ireplace("[@@gender_pronoun@@]", $value->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
							$send_data = array(
								'ss_aw_email' => $value->ss_aw_child_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
							//emailnotification($value->ss_aw_child_email, $email_template['title'], $body);
						}

						if ($course_id == 1) {
							$register_email_template = getemailandpushnotification(62, 1);
						} else {
							$register_email_template = getemailandpushnotification(61, 1);
						}
						if (!empty($register_email_template)) {
							$password = strtolower($value->ss_aw_child_first_name) . "@123";
							$body = $register_email_template['body'];
							$body = str_ireplace("[@@password@@]", $password, $body);
							$body = str_ireplace("[@@login_id@@]", $course_id == 5 ? $value->ss_aw_child_email : $value->ss_aw_child_username, $body);
							$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
							$send_data = array(
								'ss_aw_email' => $value->ss_aw_child_email,
								'ss_aw_subject' => 'Welcome to team. Thank you for registering with us.',
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);
							//emailnotification($email, 'Welcome to team. Thank you for registering with us.', $body);	
						}
					} else {
						if ($student_upload_details->ss_aw_emi_count == 0) {
							$course_name = "";
							if ($course_id == 1) {
								$email_template = getemailandpushnotification(7, 1, 2);
								$course_name = Winners;
							} elseif ($course_id == 3) {
								$email_template = getemailandpushnotification(32, 1, 2);
								$course_name = Champions;
							} else {
								$email_template = getemailandpushnotification(33, 1, 2);
								$course_name = Master . "s";
							}
							$month_date = date('d/m/Y');
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $value->ss_aw_child_username, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $value->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
								$send_data = array(
									'ss_aw_email' => $value->ss_aw_child_email,
									'ss_aw_subject' => $email_template['title'],
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);
							}

							if ($course_id == 1) {
								$register_email_template = getemailandpushnotification(62, 1);
							} else {
								$register_email_template = getemailandpushnotification(61, 1);
							}
							if (!empty($register_email_template)) {
								$password = strtolower($value->ss_aw_child_first_name) . "@123";
								$body = $register_email_template['body'];
								$body = str_ireplace("[@@password@@]", $password, $body);
								$body = str_ireplace("[@@login_id@@]", $course_id == 5 ? $value->ss_aw_child_email : $value->ss_aw_child_username, $body);
								$body = str_ireplace("[@@username@@]", $value->ss_aw_child_nick_name, $body);
								$send_data = array(
									'ss_aw_email' => $value->ss_aw_child_email,
									'ss_aw_subject' => 'Welcome to team. Thank you for registering with us.',
									'ss_aw_template' => $body,
									'ss_aw_type' => 1
								);
								$this->ss_aw_email_que_model->save_record($send_data);
							}
						}
					}
				}
			}
			//end

			// add record to institution payment table
			$data = array();
			$data['ss_aw_transaction_id'] = $transaction_id;
			$data['ss_aw_institution_id'] = $institution_id;
			if (!empty($paid_childs)) {
				$data['ss_aw_child_id'] = implode(",", $paid_childs);
			}
			$data['ss_aw_payment_invoice'] = $invoice_no;
			$data['ss_aw_payment_amount'] = $payment_amount;
			$data['ss_aw_gst_rate'] = $gst_rate;
			$data['ss_aw_discount_coupon'] = $coupon_code;
			$data['ss_aw_discount_amount'] = $discount_amount;
			$data['ss_aw_payment_invoice_filepath'] = $payment_invoice_file_path;
			$data['ss_aw_upload_id'] = $excel_upload_id;
			$save_payment = $this->ss_aw_institution_payment_details_model->add_record($data);

			$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			if ($save_payment) {
				//payment confirmation email notification.
				if ($course_id == 1) {
					$course_name = Winners;
				} elseif ($course_id == 3) {
					$course_name = Champions;
				} else {
					$course_name = Master . "s";
				}
				$email_template = getemailandpushnotification(63, 1, 1);
				if (!empty($email_template)) {
					$body = $email_template['body'];
					$body = str_ireplace("[@@child_name@@]", "Admin", $body);
					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
					$body = str_ireplace("[@@enrollment_time@@]", date('d/m/Y'), $body);
					$body = str_ireplace("[@@name_of_file@@]", $student_upload_details->ss_aw_upload_file_name, $body);
					$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
					$send_data = array(
						'ss_aw_email' => $parent_details[0]->ss_aw_parent_email,
						'ss_aw_subject' => 'Payment Confirmation',
						'ss_aw_template' => $body,
						'ss_aw_type' => 1
					);
					$this->ss_aw_email_que_model->save_record($send_data);
					//emailnotification($parent_details[0]->ss_aw_parent_email, 'Payment Confirmation', $body);
				}
			}
			//end
			//update emi count in upload master table
			if ($payment_type == 2) {
				$student_upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($excel_upload_id);
				$data = array(
					'ss_aw_emi_count' => $student_upload_details->ss_aw_emi_count + 1
				);
				$this->ss_aw_institution_student_upload_model->update_emi_count($excel_upload_id, $data);
			}
			//end
			if ($save_payment) {
				if (!empty($paid_childs)) {
					$child_count = count($paid_childs);
					$total_payment_amount = $postdata['payment_amount'];
					$total_discount_amount = $postdata['discount_amount'];
					$total_payment_amount = $total_payment_amount + $total_discount_amount;
					$total_payment_amount = round($total_payment_amount / $child_count, 2);

					foreach ($paid_childs as $child_id) {
						$payment_amount = $total_payment_amount;
						$invoice_prefix = "ALWS/";
						$invoice_suffix = "/" . date('m') . date('y');
						$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
						if (!empty($get_last_invoice_details)) {
							$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
							if (!empty($invoice_ary)) {
								if (!empty($invoice_ary[1])) {
									if (is_numeric($invoice_ary[1])) {
										$suffix_num = (int)$invoice_ary[1] + 1;
										$invoice_no = $invoice_prefix . $suffix_num;
									} else {
										$invoice_no = $invoice_prefix . "100001";
									}
								} else {
									$invoice_no = $invoice_prefix . "100001";
								}
							} else {
								$invoice_no = $invoice_prefix . "100001";
							}
						} else {
							$invoice_no = $invoice_prefix . "100001";
						}
						$invoice_no = $invoice_no . $invoice_suffix;

						//generate PDF code
						$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

						$course_price = round(($payment_amount * 100) / (100 + 18), 2);
						$gst_rate = $payment_amount - $course_price;
						$discount_amount = 0;
						if (!empty($coupon_code) && $chk_discount_coupon == 1) {
							$check_coupon_availability = $this->ss_aw_coupons_model->check_coupon_availability($coupon_code, $payment_type, 1);
							$discount_percentage = $check_coupon_availability[0]->ss_aw_discount;
							$lumpsum_price = $course_id == 1 || $course_id == 2 ? $institution_details->ss_aw_lumpsum_price : ($course_id == 3 ? $institution_details->ss_aw_lumpsum_price_champions : $institution_details->ss_aw_lumpsum_price_masters);
							$course_price = round(($lumpsum_price * 100) / (100 + 18), 2); //course price without GST 4236.44
							$discount_amount = round(($course_price * $discount_percentage) / 100, 2);//Discount amount 1237.46						
							$payment_amount = $course_price - $discount_amount;						
							$gst_rate = round(($payment_amount * 18) / 100, 2);						
							$payment_amount = $payment_amount + $gst_rate;
						}
						$data = array();
						$data['transaction_id'] = $transaction_id;
						$data['payment_amount'] = $payment_amount;
						$data['course_id'] = $course_id;
						$data['invoice_no'] = $invoice_no;
						$data['parent_details'] = $parent_details;
						$data['discount_amount'] = $discount_amount;

						$data['gst_rate'] = $gst_rate;
						$data['coupon_id'] = $discount_amount > 0 ? $coupon_code : "";
						$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => $course_id));
						$data['payment_type'] = $payment_type == 1 ? 0 : 1;

						$this->load->library('pdf');
						$html = $this->load->view('pdf/paymentinvoice', $data, true);

						$filename = time() . rand() . "_" . $child_id . ".pdf";
						$save_file_path = "./payment_invoice/" . $filename;
						$this->pdf->createPDF($save_file_path, $html, $filename, false);
						//END

						//add data to child course table
						$searary = array();
						$searary['ss_aw_parent_id'] = $parent_id;
						$searary['ss_aw_child_id'] = $child_id;
						$searary['ss_aw_selected_course_id'] = $course_id;
						$searary['ss_aw_transaction_id'] = $transaction_id;
						$searary['ss_aw_course_payment'] = $payment_amount;
						$searary['ss_aw_invoice'] = $filename;
						$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
						$payment_invoice_file_path = base_url() . "payment_invoice/" . $filename;
						$searary = array();
						$searary['ss_aw_child_id'] = $child_id;
						$searary['ss_aw_course_id'] = $course_id;
						if ($payment_type != 1) {
							$searary['ss_aw_course_payemnt_type'] = 1;
						}
						$courseary = $this->ss_aw_child_course_model->data_insert($searary);
						//end

						//add data to payment details table
						$searary = array();
						$searary['ss_aw_parent_id'] = $parent_id;
						$searary['ss_aw_child_id'] = $child_id;
						$searary['ss_aw_payment_invoice'] = $invoice_no;
						$searary['ss_aw_transaction_id'] = $transaction_id;
						$searary['ss_aw_payment_amount'] = $payment_amount;
						$searary['ss_aw_gst_rate'] = $gst_rate;
						$searary['ss_aw_discount_coupon'] = $discount_amount > 0 ? $coupon_code : "";
						$searary['ss_aw_discount_amount'] = $discount_amount;
						$courseary = $this->ss_aw_payment_details_model->data_insert($searary);
						//end

						//revenue mis data store
						$invoice_amount = $payment_amount - $gst_rate;
						$reporting_collection_data = array(
							'ss_aw_parent_id' => $parent_id,
							'ss_aw_bill_no' => $invoice_no,
							'ss_aw_course_id' => $course_id,
							'ss_aw_invoice_amount' => round($invoice_amount,2),
							'ss_aw_discount_amount' => round($discount_amount,2),
							'ss_aw_payment_type' => $payment_type == 1 ? 0 : 1
						);

						$resporting_collection_insertion = $this->ss_aw_reporting_collection_model->store_data($reporting_collection_data);
						if ($payment_type == 1) {
							if ($course_id == 1 || $course_id == 2) {
								$fixed_course_duration = WINNERS_DURATION;
								$course_duration = WINNERS_DURATION;
							} elseif ($course_id == 3) {
								$fixed_course_duration = CHAMPIONS_DURATION;
								$course_duration = CHAMPIONS_DURATION;
							} else {
								$fixed_course_duration = MASTERS_DURATION;
								$course_duration = MASTERS_DURATION;
							}


							$today = date('d');

							$count = 0;
							while ($course_duration != 0) {
								if ($count == 0) {
									$advance_payment = 0;
									$today_date = date('Y-m-d');
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = date('d');
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
								} else {
									$advance_payment = 1;
									$today_date = new DateTime();
									$today_date->format('Y-m-d');
									$day = $today_date->format('j');
									$today_date->modify('first day of + ' . $count . ' month');
									$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
									$today_date = $today_date->format('Y-m-d');
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today = 0;
									$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
									$remaing_days = $days_current_month - $today;
									$today_date = $year . "-" . $month . "-01";
								}

								if ($remaing_days > $course_duration) {
									$remaing_days = $course_duration;
									$course_duration = 0;
								} else {
									$course_duration = $course_duration - $remaing_days;
								}

								$revenue_invoice_amount = ($invoice_amount / $fixed_course_duration) * $remaing_days;
								$revenue_discount_amount = 0;
								if ($discount_amount > 0) {
									$revenue_discount_amount = ($discount_amount / $fixed_course_duration) * $remaing_days;
								}

								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
									'ss_aw_discount_amount' => round($revenue_discount_amount,2),
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $remaing_days,
									'ss_aw_payment_type' => $payment_type == 1 ? 0 : 1,
									'ss_aw_advance' => $advance_payment
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

								$count++;
							}
						} else {
							$today_date = date('Y-m-d');
							$month = date('m', strtotime($today_date));
							$year = date('Y', strtotime($today_date));
							$today = date('d');
							$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
							$remaing_days = $days_current_month - $today;

							$revenue_invoice_amount = ($invoice_amount / $days_current_month) * $remaing_days;

							//for the first insertion
							$reporting_revenue_data = array(
								'ss_aw_parent_id' => $parent_id,
								'ss_aw_bill_no' => $invoice_no,
								'ss_aw_course_id' => $course_id,
								'ss_aw_invoice_amount' => round($revenue_invoice_amount,2),
								'ss_aw_discount_amount' => 0,
								'ss_aw_revenue_date' => $today_date,
								'ss_aw_revenue_count_day' => $remaing_days,
								'ss_aw_payment_type' => $payment_type == 1 ? 0 : 1
							);

							$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

							//for the second insertion
							$remaing_amount = $invoice_amount - $revenue_invoice_amount;
							if ($remaing_amount > 0) {
								$today_date = new DateTime();
								$today_date->format('Y-m-d');
								$day = $today_date->format('j');
								$today_date->modify('first day of + 1 month');
								$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
								$today_date = $today_date->format('Y-m-d');
								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today_date = $year . "-" . $month . "-01";
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($remaing_amount,2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $payment_type == 1 ? 0 : 1,
									'ss_aw_advance' => 1
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							}
						}

						//update child and parent status to active
						$this->ss_aw_childs_model->update_child_details(array('ss_aw_child_status' => 1), $child_id);
						$child_prent_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
						if (!empty($child_prent_details)) {
							$childs_parent_id = $child_prent_details[0]->ss_aw_parent_id;
							$this->ss_aw_parents_model->update_parent_details(array('ss_aw_parent_status' => 1), $childs_parent_id);
						}
						//end
					}

					$update_upload_data = array(
						'ss_aw_payment_type' => $payment_type
					);
					$this->ss_aw_institution_student_upload_model->update_record($update_upload_data, $excel_upload_id);
					$responseStatus = 200;
					$msg = "Payment done successfully.";
				} else {
					$responseStatus = 400;
					$msg = "Something went wrong, please try again later.";
				}
			} else {
				$responseStatus = 400;
				$msg = "Something went wrong, please try again later.";
			}

			$responseAry = array();
			$responseAry['status'] = $responseStatus;
			$responseAry['msg'] = $msg;
			echo json_encode($responseAry);
		}
	}

	public function institution_paymentsuccess()
	{
		$institution_id = $this->uri->segment(3);
		$status = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : 400;
		if ($status == 200) {
			$msg = "Payment done successfully.";
			$this->session->set_flashdata('success', $msg);
		} else {
			$msg = "Something went wrong, please try again later.";
			$this->session->set_flashdata('success', $msg);
		}
		redirect('admin/institutionmanagepayment/' . $institution_id);
	}

	public function unpaid_user()
	{
		$child_id = $this->input->post('child_id');

		$child_course_details = $this->ss_aw_child_course_model->get_details($child_id);
		if (!empty($child_course_details)) {
			foreach ($child_course_details as $course_details) {
				$course_id = $course_details['ss_aw_course_id'];
				//payment details list
				$payment_details = $this->ss_aw_payment_details_model->get_details_by_child_course_id($child_id, $course_id);
				$invoiceIdAry = array();
				if (!empty($payment_details)) {
					foreach ($payment_details as $value) {
						$invoiceIdAry[] = $value->invoice_number;
					}

					//remove course, payment and purchase table details
					if (!empty($invoiceIdAry)) {
						//remove reporting collection data
						$this->ss_aw_reporting_collection_model->remove_record_by_invoice_number($invoiceIdAry);
						//remove reporting revenue data
						$this->ss_aw_reporting_revenue_model->remove_record_by_invoice_number($invoiceIdAry);
					}
					$this->ss_aw_child_course_model->removecoursewithpaymentdetail($child_id, $course_id);
				}
			}
			$this->ss_aw_purchase_courses_model->deleterecord($child_id);
			//remove assessment multiple format record
			$this->ss_aw_assesment_multiple_question_answer_model->remove_child_data($child_id);
			$this->ss_aw_assesment_multiple_question_asked_model->remove_child_data($child_id);

			//remove assessment single format record
			$this->ss_aw_assesment_questions_asked_model->remove_child_data($child_id);
			$this->ss_aw_assessment_exam_log_model->remove_child_data($child_id);

			//remove assessment exam complete and score data
			$this->ss_aw_assessment_exam_completed_model->remove_child_data($child_id);
			$this->ss_aw_assessment_score_model->remove_child_data($child_id);

			//remove assessment reminder record
			$this->ss_aw_assesment_reminder_model->remove_child_data($child_id);

			//remove lesson record
			$this->ss_aw_child_last_lesson_model->remove_child_data($child_id);
			$this->ss_aw_current_lesson_model->deleterecord_child($child_id);
			$this->ss_aw_lesson_score_model->remove_child_data($child_id);
			$this->ss_aw_lesson_quiz_ans_model->remove_child_data($child_id);

			//remove lesson & assessment report card related data
			$this->ss_aw_lesson_assessment_score_model->remove_child_data($child_id);
			$this->ss_aw_lesson_assessment_total_score_model->remove_child_data($child_id);

			//remove readalong data
			$this->ss_aw_readalong_quiz_ans_model->remove_child_data($child_id);
			$this->ss_aw_schedule_readalong_model->remove_child_data($child_id);
			$this->ss_aw_last_readalong_model->remove_child_data($child_id);

			//remove diagnostic exam details
			$this->ss_aw_diagnonstic_questions_asked_model->deleterecord($child_id);
			$this->ss_aw_diagonastic_exam_log_model->deleterecord($child_id);
			$this->ss_aw_diagonastic_exam_model->deleterecord($child_id);

			$this->session->set_flashdata('success', 'User marked as unpaid succesfully.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function readalog_count()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong count";
		$data = array();

		$institution_id = $this->uri->segment(3);
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('individual_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('individual_programme_type') ? $this->session->userdata('individual_programme_type') : 1;
		$searchdata = array();
		$searchdata['programme_type'] = $programme_type;
		$data['searchdata'] = $searchdata;

		$data['childs'] = $childs = $this->ss_aw_childs_model->get_programee_users_readalong($institution_users_id, $programme_type);
		$no_users = 0;
		$readalongs = 0;
		if (!empty($childs)) {
			foreach ($childs as $chil) {
				if ($chil->count_readalong != '') {
					$no_users++;
					$readalongs += $chil->count_readalong;
				}
			}
		}
		$data['no_users'] = $no_users;
		$data['readalongs'] = $readalongs;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['courses_drop'] = $this->common_model->getAllcourses(false);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/readalong_count_data', $data);
	}

	public function getallreadalongdata()
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Details";
		$data = array();

		$child_id = $this->uri->segment(3);
		$institution_id = $this->uri->segment(4);
		$data['readalong_details'] = $this->ss_aw_childs_model->getallreadalongdetails($child_id);
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/readalong_details_data', $data);
	}

	public function readalnongscoredetails($institution_id, $child_id, $readalong_id)
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Quiz Details";
		$data = array();
		$question_details = $this->ss_aw_readalong_quiz_ans_model->get_quiz_details($child_id, $readalong_id);
		$readalong_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
		$data['question_details'] = $question_details;
		$data['readalong_details'] = $readalong_details;
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/readalongscoredetails', $data);
	}

	public function assessment_subtopic_score($institution_id, $child_id, $assessment_id, $page_type, $program_type, $userlist_page_no)
	{
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Quiz Details";
		$page_type = base64_decode($page_type);
		$data = array();
		$data['assessment_details'] = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
		$exam_complete_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
		$data['result'] = array();
		$data['score'] = array();
		if (!empty($exam_complete_details)) {
			$exam_code = $exam_complete_details[0]->ss_aw_exam_code;
			$data['result'] = $this->ss_aw_assessment_exam_log_model->score_subtopic_wise($exam_code, $child_id);
			$data['score'] = $this->ss_aw_assessment_score_model->getscorebyexamcode($exam_code, $child_id);
		}
		$data['institution_details'] = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
		$data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
		$data['page_type'] = $page_type;
		$data['program_type'] = "";
		if ($this->uri->segment(7)) {
			$data['program_type'] = base64_decode($program_type);
		}
		$data['userlist_page_no'] = "";
		if ($this->uri->segment(8)) {
			$data['userlist_page_no'] = base64_decode($userlist_page_no);
		}
		$this->load->view('admin/header', $headerdata);
		$this->load->view('admin/institution/assessment_subtopic_score', $data);
	}
}

function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) === $date;
}

function deleteAll($dir, $remove = false)
{
	$structure = glob(rtrim($dir, "/") . '/*');
	if (is_array($structure)) {
		foreach ($structure as $file) {
			if (is_dir($file))
				deleteAll($file, true);
			else if (is_file($file))
				unlink($file);
		}
	}
}

function generate_random_letters($length)
{
	$random = '';
	for ($i = 0; $i < $length; $i++) {
		$random .= chr(rand(ord('a'), ord('z')));
	}
	return $random;
}
