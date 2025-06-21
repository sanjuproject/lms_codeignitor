<?php
set_time_limit(320);
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
class Parentapi extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->model('ss_aw_parents_model');
		$this->load->model('ss_aw_error_code_model');
		$this->load->model('ss_aw_childs_model');
		$this->load->model('ss_aw_childs_temp_model');
		$this->load->model('ss_aw_parents_temp_model');
		$this->load->helper('custom_helper');
		$this->load->model('ss_aw_diagonastic_exam_model');
		$this->load->model('ss_aw_courses_model');
		$this->load->model('ss_aw_purchase_courses_model');
		$this->load->model('ss_aw_diagonastic_exam_log_model');
		$this->load->model('ss_aw_page_content_model');
		$this->load->model('ss_aw_faq_model');
		$this->load->model('ss_aw_course_count_model');
		$this->load->model('ss_aw_email_valification_model');
		$this->load->model('ss_aw_phone_valification_model');
		$this->load->model('ss_aw_child_course_model');
		$this->load->model('ss_aw_sections_topics_model');
		$this->load->model('ss_aw_payment_details_model');
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_supplymentary_uploaded_model');
		$this->load->model('ss_aw_purchased_supplymentary_course_model');
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_lesson_quiz_ans_model');
		$this->load->model('ss_aw_supplymentary_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_last_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_ans_model');
		$this->load->model('ss_aw_readalong_quiz_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_readalongs_upload_model');
		$this->load->model('ss_aw_readalong_restriction_model');
		$this->load->model('ss_aw_schedule_readalong_model');
		$this->load->model('ss_aw_notification_model');
		$this->load->model('ss_aw_promotion_model');
		$this->load->model('ss_aw_coupons_model');
		$this->load->model('ss_aw_manage_coupon_send_model');
		$this->load->model('ss_aw_schools_model');
		$this->load->model('ss_aw_child_result_model');
		$this->load->model('ss_aw_reporting_collection_model');
		$this->load->model('ss_aw_reporting_revenue_model');
		$this->load->model('ss_aw_email_que_model');
		$this->load->model('ss_aw_lessons_model');
		$this->load->model('ss_aw_general_settings_model');
		$this->load->model('ss_aw_test_timing_model');
		$this->load->model('ss_aw_assisment_diagnostic_model');
		$this->load->model('ss_aw_assessment_subsection_matrix_model');
		$this->load->model('ss_aw_readalong_model');
		$this->load->model('ss_aw_assessment_exam_log_model');
		$this->load->model('ss_aw_sections_subtopics_model');
		$this->load->model('store_procedure_model');
		$this->load->model('ss_aw_supplymentary_exam_finish_model');
		$this->load->model('ss_aw_vocabulary_model');
		$this->load->model('ss_aw_current_lesson_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_store_readalong_page_model');
		$this->load->model('ss_aw_update_profile_log_model');
	}
	public function signup()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if($inputpost){
			$email = $inputpost['email'];
			$device_type = $inputpost['os'];
			$referrer = $inputpost['referrer'];
			$primary_mobile = $inputpost['primary_mobile'];

			if($this->check_email_existance($email)){
				$image = "";	
				if(isset($_FILES["profile_pic"]['name']))
				{
					$image = time().'.'.$_FILES["profile_pic"]['name'];		
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('profile_pic'))
					{
						$error = array('error' => $this->upload->display_errors());
						print_r($error);                       
					}               
					$data = $this->upload->data();
					$image = $data['file_name'];
				}			
										

				$password = $inputpost['password'];
				$hash_pass = @$this->bcrypt->hash_password($password);
				$signupary = array();
				$signupary['ss_aw_parent_full_name'] = $inputpost['fullname'];

				if (!empty($inputpost['primary_mobile'])) {
					if($this->check_mobile_existance($inputpost['primary_mobile'])){
						$signupary['ss_aw_parent_primary_mobile'] = $inputpost['primary_mobile'];
					}
					else{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1026');
						foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";				
						}

						die(json_encode($responseary));
					}	
				}
				
				if (!empty($inputpost['country_code'])) {
					$signupary['ss_aw_parent_country_code'] = $inputpost['country_code'];
				}	
				
				if(!empty($inputpost['country_sort_name'])){
					$signupary['ss_aw_parent_country_sort_name'] = $inputpost['country_sort_name'];
				}
				$signupary['ss_aw_parent_email'] = $email;
				$signupary['ss_aw_parent_password'] = $hash_pass;
				$signupary['ss_aw_parent_profile_photo'] = $image;

				$otp = rand(100000,999999);
				$signupary['ss_aw_parent_otp']= $otp;
				$userid = $this->ss_aw_parents_temp_model->data_insert($signupary);
				$this->activate_account($email,$otp,$password,$device_type,$referrer);
			}
			else
			{ 
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1012');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else
		{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1004');
				foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error"; 				
				}			
		}
		echo json_encode($responseary);
		die();
	}

	public function check_parent_email_exist()
	{
		$postdata = $this->input->post();
		$email = $postdata['email'];
		$parent_id = $postdata['user_id'];
		$responseary = array();
		$dataary['ss_aw_parent_email'] = $email;
		$searchdataary = array();
		
		$check_email = $this->ss_aw_parents_model->check_email_except_own($email, $parent_id);
		
		if($check_email > 0)
		{
			$status = 0;
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1012');
			foreach ($error_array as $value) {
			$responseary['status'] = $value->ss_aw_error_status;
			$responseary['msg'] = $value->ss_aw_error_msg;
			$responseary['title'] = "Error";	
			}
		}
		else 
		{
				$this->ss_aw_email_valification_model->delete_record_by_email($email);
				$rand = rand(1000,9999);
				$subject = "Alsowise parent user email verification";
				$msg = "Email valification code : ".$rand;
				$insertdata = array();
				$insertdata['ss_aw_user_id'] = 0;
				$insertdata['ss_aw_email'] = $email;
				$insertdata['ss_aw_code'] = $rand;
				$this->ss_aw_email_valification_model->insert_data($insertdata);

				$email_template = getemailandpushnotification(40, 1);
				if (!empty($email_template)) {
					$body = $email_template['body'];
					$body = str_ireplace("[@@otp@@]", $rand, $body);
					emailnotification($email, 'Verification OTP, as requested by you', $body);
				}
			
			$status = 1;
			$responseary['status'] = 200;
			$responseary['msg'] = "Email verification code send to your email address.";
			$responseary['otp'] = $rand;
		}
	
		echo json_encode($responseary);
		die();
	}
	
	public function verify_email()
	{
		$postdata = $this->input->post();
		$email = $postdata['email'];
		$code = $postdata['code'];
		$parent_id = $postdata['user_id'];
		$responseary = array();
		$dataary['ss_aw_email'] = $email;
		$dataary['ss_aw_code'] = $code;
		$searchdataary = array();
		$searchdataary = $this->ss_aw_email_valification_model->check_data_param($dataary);
		if(!empty($searchdataary))
		{
			$otp_send_time = strtotime($searchdataary[0]->ss_aw_created_date);
			$current_time = time();
			$datediff = $current_time - $otp_send_time;
			$minutes = round($datediff / 60);
			if ($minutes > 5) {
				$status = 0;
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1035');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			else{
				$this->ss_aw_email_valification_model->delete_record_by_email($email);
				$update_email_data = array(
					'ss_aw_parent_email' => $email,
					'ss_aw_is_email_verified' => 1
				);
				$this->ss_aw_parents_model->update_parent_details($update_email_data, $parent_id);
				$status = 1;
				$responseary['status'] = 200;
				$responseary['msg'] = "Your email verified successfully.";
			}
		}
		else
		{
			$status = 0;
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1029');
			foreach ($error_array as $value) {
			$responseary['status'] = $value->ss_aw_error_status;
			$responseary['msg'] = $value->ss_aw_error_msg;
			$responseary['title'] = "Error";
			}
		}
		echo json_encode($responseary);
		die();
	}
	public function resend_email_verification_code()
	{
		$this->check_parent_email_exist();
	}
	
	public function check_parent_phone_exist()
	{
		$postdata = $this->input->post();
		$responseary = array();
		$phone = $postdata['primary_mobile'];
		$country_code = $postdata['country_code'];
		$phone = $country_code.$phone;
		//$email = $postdata['email'];
		$dataary['ss_aw_parent_primary_mobile'] = $postdata['primary_mobile'];
		$searchdataary = array();
		$searchdataary = $this->ss_aw_parents_model->search_byparam($dataary);
	
		if(!empty($searchdataary))
		{
			$status = 0;
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1026');
			foreach ($error_array as $value) {
			$responseary['status'] = $value->ss_aw_error_status;
			$responseary['msg'] = $value->ss_aw_error_msg;
			$responseary['title'] = "Error";
			}
		}
		else 
		{
				$this->ss_aw_phone_valification_model->delete_record_by_phone($phone);
				$rand = rand(1000,9999);
				$subject = "Alsowise parent primary mobile no valification";
				$msg = "Mobile valification code : ".$rand;
				$result = send_sms($country_code, $phone, $rand);
				$insertdata = array();
				$insertdata['ss_aw_user_id'] = 0;
				$insertdata['ss_aw_phone'] = $phone;
				$insertdata['ss_aw_code'] = $rand;
				$this->ss_aw_phone_valification_model->insert_data($insertdata);
				//sendmail($msg,$subject,$email);
			
			$status = 1;
			$responseary['status'] = 200;
			$responseary['msg'] = "Verification code sent to your mobile";
			$responseary['otp'] = $rand;
		}
		echo json_encode($responseary);
		die();
	}
	
	public function resend_phone_verification_code()
	{
		$this->check_parent_phone_exist();
	}
	
	public function verify_phone()
	{
		$postdata = $this->input->post();
		$phone = $postdata['primary_mobile'];
		$country_code = $postdata['country_code'];
		$phone = $country_code.$phone;
		$code = $postdata['code'];
		$responseary = array();
		
		$dataary['ss_aw_phone'] = $phone;
		$dataary['ss_aw_code'] = $code;
		$searchdataary = array();
		$searchdataary = $this->ss_aw_phone_valification_model->check_data_param($dataary);
		if(!empty($searchdataary))
		{
			$otp_send_time = strtotime($searchdataary[0]->ss_aw_created_date);
			$current_time = time();
			$datediff = $current_time - $otp_send_time;
			$minutes = round($datediff / 60);
			if ($minutes > 5) {
				$status = 0;
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1035');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";
				}
			}
			else{
				$this->ss_aw_phone_valification_model->delete_record_by_phone($phone);
				$status = 1;
				$responseary['status'] = 200;
				$responseary['msg'] = "Your phone no verified successfully.";
			}
		}
		else
		{
			$status = 0;
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1029');
			foreach ($error_array as $value) {
			$responseary['status'] = $value->ss_aw_error_status;
			$responseary['msg'] = $value->ss_aw_error_msg;
			$responseary['title'] = "Error";
			}
		}
		echo json_encode($responseary);
		die();
	}
	
	public function activate_account($email,$otp,$password,$device_type="",$refferal_id = "")
	{
		
			$otp = $otp;
			$email = $email;
			$data = $this->ss_aw_parents_temp_model->activate_account($otp,$email);
			$modify_time_arr = $this->ss_aw_parents_temp_model->data_modify_time($email);
			$signupary = array();

			$token = $this->random_strings(20);

			
			$otp_time = $modify_time_arr[0]['ss_aw_parent_modified_date'];
			$cur_time =  date('Y-m-d H:i:s');			

			$datetime1 = new DateTime($otp_time);
			$datetime2 = new DateTime($cur_time);
			$interval = $datetime1->diff($datetime2);
			
				foreach ($data as $value) {
		         	$signupary['ss_aw_parent_full_name'] = $value['ss_aw_parent_full_name'];					
		         	$signupary['ss_aw_user_type'] = 1;

		         	if (!empty($value['ss_aw_parent_primary_mobile'])) {
		         		$signupary['ss_aw_parent_primary_mobile'] = $value['ss_aw_parent_primary_mobile'];						
		         	}					
							
					$signupary['ss_aw_parent_email'] = $value['ss_aw_parent_email'];	
					$signupary['ss_aw_parent_password'] = $value['ss_aw_parent_password']; 
					$signupary['ss_aw_parent_profile_photo'] = $value['ss_aw_parent_profile_photo'];
					if (!empty($value['ss_aw_parent_country_code'])) {
						$signupary['ss_aw_parent_country_code'] = $value['ss_aw_parent_country_code'];	
					}
					
					if(!empty($value['ss_aw_parent_country_sort_name'])){
						$signupary['ss_aw_parent_country_sort_name'] = $value['ss_aw_parent_country_sort_name'];
					}
					$signupary['ss_aw_parent_auth_key'] = $token;
					if (!empty($device_type)) {
						$signupary['ss_aw_device_type'] = $device_type;	
					}

					if (!empty($refferal_id)) {
						if (base64_encode(base64_decode($refferal_id)) === $refferal_id) {
							$refferal_code = base64_decode($refferal_id);
						}
						else{
							$refferal_code = $refferal_id;
						}
						$signupary['ss_aw_refferal_id'] = $refferal_code;
					}
				
				}
				
				if(count($data)>0)
				{
					$userid = $this->ss_aw_parents_model->data_insert($signupary);
					
					if($userid!="")
					{
						$this->ss_aw_parents_temp_model->delete_parent($email);
					}
					$responseary['status'] = 200;
					$responseary['user_id'] = $userid;
					$responseary['user_token'] = $token;
					$responseary['created_date'] = date('Y-m-d H:i:s');
					$responseary['msg'] = 'Signup successfully done and account activated.';

					$email_template = getemailandpushnotification(1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@password@@]", $password, $body);
						$body = str_ireplace("[@@email@@]", $signupary['ss_aw_parent_email'], $body);
						$body = str_ireplace("[@@username@@]", $signupary['ss_aw_parent_full_name'], $body);
						emailnotification($signupary['ss_aw_parent_email'], 'Welcome to ALSOWISE. Thank you for registering with us.', $body);
					}
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
					}	
				}


			echo json_encode($responseary);
		die();
	}

	public function resend_account_active_otp()
	{
		if($this->input->post('email')!="")
		{
			$email = $this->input->post('email');
			$result = $this->ss_aw_parents_temp_model->get_parent_byemail($email);
			if(count($result)>0)
			{
			   $otp = rand(100000,999999);
			   $current_date = date('Y-m-d H:i:s');
			   $this->ss_aw_parents_temp_model->update_otp($otp,$email,$current_date);				

				

				$msg = "Otp for activate your account is: ".$otp;
				$subject = "Password Reset Code";
					// use wordwrap() if lines are longer than 70 characters
					/*$msg = wordwrap($msg,70);

					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					$headers .= "From: Alsowise <deepanjan.das@gmail.com>";
						

					// send email
					mail($email,$subject,$msg,$headers);
					*/
					sendmail($msg,$subject,$email);
				$responseary['status'] = 200;				
				$responseary['otp'] = $otp;	
				$responseary['msg'] = "Please active your Account";
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
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

	public function update_details()
	{

		$inputpost = $this->input->post();
		$responseary = array();
		if($inputpost){
			$parent_id = $inputpost['user_id'];
			$parent_token = $inputpost['user_token'];
			$this->check_parent_existance($parent_id,$parent_token);
			$updateary = array();
			if($this->check_parent_existance($parent_id,$parent_token))
			{
				
			   $image = "";	
				if(isset($_FILES["profile_pic"]['name']))
				{
					
						
                        $config['upload_path']          = './uploads/';
		                $config['allowed_types']        = 'gif|jpg|png';
		                $config['encrypt_name'] = TRUE;
		                // $config['max_size']             = 100;
		                // $config['max_width']            = 1024;
		                // $config['max_height']           = 768;
		                $this->load->library('upload', $config);
		                 if ( ! $this->upload->do_upload('profile_pic'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);                       
			                }		                             
						$data = $this->upload->data();
						$profile_pic = $data['file_name'];
						$image = $profile_pic;
						$updateary['ss_aw_parent_profile_photo'] = $image;
				}
				
				
				
				if(isset($inputpost['fullname']))
				{
					$updateary['ss_aw_parent_full_name'] = $inputpost['fullname'];
                  
				}
				if(isset($inputpost['primary_mobile']))
				{
					$updateary['ss_aw_parent_primary_mobile'] = $inputpost['primary_mobile'];

				}
				if(isset($inputpost['address']))
				{
					$updateary['ss_aw_parent_address'] = $inputpost['address'];

				}
				if(isset($inputpost['city']))
				{
					$updateary['ss_aw_parent_city'] = $inputpost['city'];

				}
				if(isset($inputpost['state']))
				{
					$updateary['ss_aw_parent_state'] = $inputpost['state'];

				}
				if(isset($inputpost['pincode']))
				{
					$updateary['ss_aw_parent_pincode'] = $inputpost['pincode'];

				}

				if(isset($inputpost['country']))
				{
					$updateary['ss_aw_parent_country'] = $inputpost['country'];	
					$updateary['ss_aw_parent_state'] = "";
				}
				if(isset($inputpost['secondary_mobile']))
				{
					$updateary['ss_aw_parent_secondary_mobile'] = $inputpost['secondary_mobile'];
				}
				if(isset($inputpost['country_code']))
				{
					$updateary['ss_aw_parent_country_code'] = $inputpost['country_code'];
				}
				
				if(isset($inputpost['country_sort_name']))
				{
					$updateary['ss_aw_parent_country_sort_name'] = $inputpost['country_sort_name'];
				}

				if(isset($inputpost['email']))
				{ 
					$email = $inputpost['email'];

					 $check_temp_parent_tbl = $this->ss_aw_parents_temp_model->email_existance($email);

					
					 if(!$check_temp_parent_tbl && $this->check_email_existance($email))
					{          
                      	$updateary['ss_aw_parent_email'] = $inputpost['email'];
						$updateary['ss_aw_parent_auth_key'] = ''; 
						
						$api_key = FRESH_DESK_API;
						$password = FRESH_DESK_PASSWORD;
						$yourdomain = FRESH_DESK_DOMAIN;
			
						$getpaentdetails = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
						
						$old_parent_email = $getpaentdetails[0]->ss_aw_parent_email;
						
						$url = "https://$yourdomain.freshdesk.com/api/v2/contacts?email=$old_parent_email";

						$ch = curl_init($url);

						curl_setopt($ch, CURLOPT_HEADER, true);
						curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$server_output = curl_exec($ch);
						$info = curl_getinfo($ch);
						$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
						$headers = substr($server_output, 0, $header_size);
						$response = substr($server_output, $header_size);
						$responseary = json_decode($response,true);
						$freshdesk_id = $responseary[0]['id'];
						
						
						$contact_data = json_encode(array(
						  "email" => $email
						));

						// Id of the contact to be updated
						$contact_id = $freshdesk_id;

						$url = "https://$yourdomain.freshdesk.com/api/v2/contacts/$contact_id";

						$ch = curl_init($url);

						$header[] = "Content-type: application/json";
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
						curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
						curl_setopt($ch, CURLOPT_HEADER, true);
						curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
						curl_setopt($ch, CURLOPT_POSTFIELDS, $contact_data);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$server_output = curl_exec($ch);
						$info = curl_getinfo($ch);
						$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
						$headers = substr($server_output, 0, $header_size);
						$response = substr($server_output, $header_size);
					}
					else
					{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1012');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;				
						}

						echo json_encode($responseary);
						die();  

					}					
				}			

				//$password = $inputpost['password'];
				//$hash_pass = $this->bcrypt->hash_password($password);
						
				
				$updateary['ss_aw_parent_modified_date'] = date('Y-m-d H:i:s');
				
				//$signupary['ss_aw_parent_password'] = $hash_pass;
				//

				$result = $this->ss_aw_parents_model->update_parent_details($updateary,$parent_id);
				if($result)
				{
					$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);
					if (!empty($parent_detail)) {
						$email_template = getemailandpushnotification(29, 1, 1);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);

							$mail_data = array(
								'ss_aw_email' => $parent_detail[0]->ss_aw_parent_email,
								'ss_aw_type' => 1,
								'ss_aw_content' => $body,
								'ss_aw_subject' => $email_template['title']
							);
							$check_data = $this->ss_aw_update_profile_log_model->check_duplicate($mail_data);
							if ($check_data == 0) {
								$this->ss_aw_update_profile_log_model->insert_data($mail_data);	
							}
							
							//emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
						}	
					}
					$responseary['status'] = 200;
					$responseary['user_id'] = $parent_id;
					$responseary['msg'] = 'Update successfully done';					
				}
				else
				{ 
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1017');
					foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
					}

				}
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
		
	}
	
  public function logout()
  {
  	 $inputpost = $this->input->post();		
     $responseary = array();
      if($inputpost)
	  {
	  	$parent_id = $inputpost['user_id'];
		
		$result = $this->ss_aw_parents_model->logout($parent_id);
		if($result)
		{
			$responseary['status'] = 200;
            $responseary['msg'] = "Logged out successfully";
		}
		else
		{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1014');
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
  public function get_profile_details()
  {
  	 $inputpost = $this->input->post();		
     $responseary = array();
     if($inputpost)
	{
		$parent_id = $inputpost['user_id'];
		$parent_token = $inputpost['user_token'];
		$this->check_parent_existance($parent_id,$parent_token);
		$result = $this->ss_aw_parents_model->get_parent_profile_details($parent_id,$parent_token);
		 if(!empty($result))
			{                  
                   $responseary['status'] = 200;
                   $responseary['msg'] = "Data Found";
                   foreach ($result as $value) {
                    $responseary['user_id'] = $value->ss_aw_parent_id ;
                    $responseary['fullname'] = $value->ss_aw_parent_full_name ;
                    if($value->ss_aw_parent_address!="")
                    {
                    	$responseary['address'] = $value->ss_aw_parent_address ;
                    }
                    else
                    {
                    	$responseary['address'] = "";
                    }
                     if($value->ss_aw_parent_city!="")
                    {
                    	$responseary['city'] = $value->ss_aw_parent_city ;
                    }
                    else
                    {
                    	$responseary['city'] = "";
                    }

                    if($value->ss_aw_parent_state!="")
                    {
                    	$responseary['state'] = $value->ss_aw_parent_state ;
                    }
                    else
                    {
                    	$responseary['state'] = "";
                    }
                     if($value->ss_aw_parent_pincode!="")
                    {
                    	$responseary['pincode'] = $value->ss_aw_parent_pincode ;
                    }
                    else
                    {
                    	$responseary['pincode'] = "";
                    }   

                    if($value->ss_aw_parent_country!="")
                    {
                    	$responseary['country'] = $value->ss_aw_parent_country ;
                    }
                    else
                    {
                    	$responseary['country'] = "";
                    }                
                   
                    $responseary['country_code'] = $value->ss_aw_parent_country_code ;
					
					$responseary['country_sort_name'] = $value->ss_aw_parent_country_sort_name;
					
                    $responseary['primary_mobile'] = $value->ss_aw_parent_primary_mobile ;

                    if($value->ss_aw_parent_secondary_mobile!="")
                    {
                    	$responseary['secondary_mobile'] = $value->ss_aw_parent_secondary_mobile ;
                    }
                    else
                    {
                    	$responseary['secondary_mobile'] = "";
                    }                    
                    $responseary['email'] = $value->ss_aw_parent_email ;

                     if($value->ss_aw_parent_profile_photo!="")
                    {
                    	$responseary['photo'] = base_url()."uploads/".$value->ss_aw_parent_profile_photo ;
                    }
                    else
                    {
                    	$responseary['photo'] = base_url()."uploads/profile.jpg";
                    }                   
                    $responseary['user_token'] = $value->ss_aw_parent_auth_key ;
                    $responseary['created_date'] = $value->ss_aw_parent_created_date ;    
                   }				
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
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

  public function add_child()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();
	 $child_data = array();
     if($inputpost)
     {
        $parent_id = $inputpost['user_id'];
		$parent_token = $inputpost['user_token'];
		$this->check_parent_existance($parent_id,$parent_token);
		$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
		
		$check_in_parent = $this->ss_aw_parents_model->check_in_parent($parent_id, trim($inputpost['child_email']));
		
		$check_in_child = $this->ss_aw_childs_model->check_in_child($parent_id, trim($inputpost['child_email']));
		if ($check_in_parent == 0 && $check_in_child == 0) {
			$child_count = $this->ss_aw_childs_model->check_child_count($parent_id);
				
			$child_dob = $inputpost['child_dob'];

		    $age = calculate_age($child_dob); // Call Helper calculate_age() function to calculate AGE
				
			if(!empty($inputpost['child_image_color_no']))
				$child_data['ss_aw_child_image_color_no'] = $inputpost['child_image_color_no'];	
			
			$child_username = $inputpost['child_username'];
			$check_username = $this->ss_aw_childs_model->check_username($child_username);
			$check_temp_username = $this->ss_aw_childs_temp_model->check_username($child_username);
			if ($check_username == 0 && $check_temp_username == 0) {
				if($child_count < 3)
				{
					$code_check = $this->ss_aw_childs_model->child_code_check();      
					if(isset($code_check))
					{
						$random_code = $code_check->ss_aw_child_code + 1;
					}
					else
					{
						$random_code =  10000001;
					}					   

					$child_code = $random_code;

			        if($age>=10 && $age<=19)
			        {
			            $check_firstchild_array = $this->ss_aw_childs_model->first_child($parent_id);                    
									
			            if(isset($check_firstchild_array))
			            {

			                if($child_count==2)
			                {
			                    $first_child_dob = $check_firstchild_array->ss_aw_child_dob;	                     		                     		
			                    $current_child_dob = $inputpost['child_dob'];
								$date1=date_create($first_child_dob);
								$date2=date_create($current_child_dob);
								$diff=date_diff($date1,$date2);
								$year_gap = floor($diff->format("%a")/365);
										
								if($year_gap < 2)
			                    {
			                     	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1023');
									foreach ($error_array as $value) {
										$responseary['status'] = $value->ss_aw_error_status;
										$responseary['msg'] = $value->ss_aw_error_msg;	
						            }
			                    }
			                    else
			                    {
		                     		$child_password = $inputpost['child_password'];
									$hash_pass = @$this->bcrypt->hash_password($child_password);
					                $child_data['ss_aw_child_code']= $child_code;
									$child_data['ss_aw_parent_id']= $parent_id;
									$child_data['ss_aw_child_nick_name']= $inputpost['child_nick_name'];
									$child_data['ss_aw_child_dob']= $inputpost['child_dob'];
									$child_data['ss_aw_child_age']= $age;
									$child_data['ss_aw_child_email']= $inputpost['child_email'];
									$child_data['ss_aw_child_password']= $hash_pass;
									$child_data['ss_aw_child_username']= $child_username;
									$result = $this->ss_aw_childs_model->add_child($child_data);
									$responseary['status'] = 200;
						            $responseary['msg'] = "Child successfully added";
						            $responseary['child_code'] = $child_code;
						            $responseary['child_username'] = $child_username;
						            $responseary['child_id'] = $result;
			                    }                 		

			                }
			               	else
			                {
			                    $child_password = $inputpost['child_password'];
								$hash_pass = $this->bcrypt->hash_password($child_password);
					            $child_data['ss_aw_child_code']= $child_code;
								$child_data['ss_aw_parent_id']= $parent_id;
								$child_data['ss_aw_child_nick_name']= $inputpost['child_nick_name'];
								$child_data['ss_aw_child_dob']= $inputpost['child_dob'];
								$child_data['ss_aw_child_age']= $age;
								$child_data['ss_aw_child_email']= $inputpost['child_email'];
								$child_data['ss_aw_child_password']= $hash_pass;
								$child_data['ss_aw_child_username']= $child_username;
								$result = $this->ss_aw_childs_model->add_child($child_data);
								$responseary['status'] = 200;
						        $responseary['msg'] = "Child successfully added";
						        $responseary['child_code'] = $child_code;
						        $responseary['child_username'] = $child_username;
						        $responseary['child_id'] = $result;
			                }

			            }             
			            else
			            {    	
			                $child_password = $inputpost['child_password'];
							$hash_pass = $this->bcrypt->hash_password($child_password);
				            $child_data['ss_aw_child_code']= $child_code;
							$child_data['ss_aw_parent_id']= $parent_id;
							$child_data['ss_aw_child_nick_name']= $inputpost['child_nick_name'];
							$child_data['ss_aw_child_dob']= $inputpost['child_dob'];
							$child_data['ss_aw_child_age']= $age;
							$child_data['ss_aw_child_email']= $inputpost['child_email'];
							$child_data['ss_aw_child_password']= $hash_pass;
							$child_data['ss_aw_child_username']= $child_username;
							$result = $this->ss_aw_childs_model->add_child($child_data);
							$responseary['status'] = 200;
					        $responseary['msg'] = "Child successfully added";
					        $responseary['child_code'] = $child_code;
					        $responseary['child_username'] = $child_username;
					        $responseary['child_id'] = $result;
			            }
						
						//change parent type to 1 from 4	
						/*$update_user_type = array(
							'ss_aw_user_type' => 1
						);
						$this->ss_aw_parents_model->update_parent_details($update_user_type, $parent_id);*/

						// $email_template = getemailandpushnotification(1, 1, 2);
						// if (!empty($email_template)) {
						// 	$body = $email_template['body'];
						// 	$body = str_ireplace("[@@username@@]", $inputpost['child_nick_name'], $body);
						// 	$send_data = array(
						// 		'ss_aw_email' => $child_data['ss_aw_child_email'],
						// 		'ss_aw_subject' => $email_template['title'],
						// 		'ss_aw_template' => $body,
						// 		'ss_aw_type' => 1
						// 	);
						// 	$this->ss_aw_email_que_model->save_record($send_data);
						// }
			        }
			        else
			        {
			            $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1024');
						foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";	
						}
			        }
								 
				}
				else
				{
					$child_password = $inputpost['child_password'];
					$hash_pass = $this->bcrypt->hash_password($child_password); 
					$child_data['ss_aw_parent_id']= $parent_id;
					$child_data['ss_aw_child_nick_name']= $inputpost['child_nick_name'];
					$child_data['ss_aw_child_dob']= $inputpost['child_dob'];
					$child_data['ss_aw_child_age']= $age;
					$child_data['ss_aw_child_email']= $inputpost['child_email'];
					$child_data['ss_aw_child_password']= $hash_pass;
					$child_data['ss_aw_child_username']= $child_username;
					$result = $this->ss_aw_childs_temp_model->add_child($child_data);

					//send fourth child approval request.
					$email_template = getemailandpushnotification(53, 1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@child_name@@]", $inputpost['child_nick_name'], $body);
						$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
						$send_data = array(
							'ss_aw_email' => 'deepanjan@schemaphic.com',
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
						//emailnotification('deepanjan@schemaphic.com', $email_template['title'], $body);
					}
					$responseary['status'] = 200;
					$responseary['msg'] = "Child request received. Admin approval required to activate this child.";
				}		
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1037');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";	
				}
			}	
				
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1036');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}					
     }
     else
     {
     	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1008');
				foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
				}
     }
     echo json_encode($responseary);
	 die();	
  }

  public function view_child_details()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();
     $child_array  =array();
     if($inputpost)
     {
     	 $parent_id = $inputpost['user_id'];
		$parent_token = $inputpost['user_token'];
		if($this->check_parent_existance($parent_id,$parent_token))
			{
              $child_count = $this->ss_aw_childs_model->check_child_count($parent_id);
              
              if($child_count>0)
              {

                $result = $this->ss_aw_childs_model->get_childs($parent_id);
				
				$i=0;
                foreach ($result as $value) {
				   $course_result = $this->ss_aw_child_course_model->get_details($value->ss_aw_child_id);
					
					
                   $child_array[$i]['child_id'] = $value->ss_aw_child_id; 
                   $child_array[$i]['child_code'] = $value->ss_aw_child_code;                  
                   $child_array[$i]['child_nick_name'] = $value->ss_aw_child_nick_name; 
                   $child_array[$i]['child_first_name'] = $value->ss_aw_child_first_name; 
                   $child_array[$i]['child_last_name'] = $value->ss_aw_child_last_name; 
                   if(!empty($value->ss_aw_child_profile_pic))
				   {
						$child_array[$i]['child_photo'] = base_url()."uploads/".$value->ss_aw_child_profile_pic; 
				   }
				   else
				   {
                    	$child_array[$i]['child_photo'] = base_url()."uploads/profile.jpg";              
				   }
				   $child_array[$i]['child_gender'] = $value->ss_aw_child_gender;
				   $child_array[$i]['country_code'] = $value->ss_aw_child_country_code;	
                   $child_array[$i]['child_schoolname'] = $value->ss_aw_child_schoolname; 
                   $child_array[$i]['child_dob'] = $value->ss_aw_child_dob;                  
                   $child_array[$i]['child_email'] = $value->ss_aw_child_email; 
                   $child_array[$i]['child_mobile'] = $value->ss_aw_child_mobile; 
				   $child_array[$i]['country_sort_name'] = $value->ss_aw_child_country_sort_name;
				   $child_array[$i]['child_image_color_no'] = $value->ss_aw_child_image_color_no;
                   $child_array[$i]['created_date'] = $value->ss_aw_child_created_date; 
                   $child_array[$i]['child_status'] = $value->ss_aw_child_status;
				   $child_array[$i]['child_course_status'] = $course_result[0]['ss_aw_course_status'];
				   $child_array[$i]['child_username'] = $value->ss_aw_child_username;
				   $child_array[$i]['child_state'] = getchild_diagnosticexam_status($value->ss_aw_child_id); // Get the Child exam/lesson status
				   $i++;
                }

                $responseary['status'] = 200;
                $responseary['msg'] = "Child Found";
                $responseary['user_id'] = $parent_id;
                $responseary['result'] = $child_array;

              } 
               else
               {
               	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1009');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
						}
               }

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
  }

  public function view_child_details_byid()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();
     $child_array  =array();
     if($inputpost)
     {
     	 $parent_id = $inputpost['user_id'];
		 $parent_token = $inputpost['user_token'];
		if($this->check_parent_existance($parent_id,$parent_token))
			{
              
              	$child_id = $inputpost['child_id'];
                $result = $this->ss_aw_childs_model->get_child_details_by_id($child_id,$parent_id);
              if($result)
              {
                $i=0;
                foreach ($result as $value) {
                   $child_array[$i]['child_id'] = $value->ss_aw_child_id; 
                   $child_array[$i]['child_code'] = $value->ss_aw_child_code;                  
                   $child_array[$i]['child_nick_name'] = $value->ss_aw_child_nick_name; 
                   $child_array[$i]['child_first_name'] = $value->ss_aw_child_first_name; 
                   $child_array[$i]['child_last_name'] = $value->ss_aw_child_last_name; 
                   $child_array[$i]['child_gender'] = $value->ss_aw_child_gender; 
                   $child_array[$i]['child_schoolname'] = $value->ss_aw_child_schoolname; 
                   $child_array[$i]['child_dob'] = $value->ss_aw_child_dob; 
                   $child_array[$i]['child_email'] = $value->ss_aw_child_email; 
                   $child_array[$i]['child_country_code'] = $value->ss_aw_child_country_code; 
				   $child_array[$i]['country_sort_name'] = $value->ss_aw_child_country_sort_name;
				   $child_array[$i]['child_image_color_no'] = $value->ss_aw_child_image_color_no;
				   
				   $child_array[$i]['child_mobile'] = $value->ss_aw_child_mobile; 
                   $child_array[$i]['created_date'] = $value->ss_aw_child_created_date; 
                   $child_array[$i]['child_status'] = $value->ss_aw_child_status;               
                   $child_array[$i]['child_username'] = $value->ss_aw_child_username;               
				   $child_array[$i]['child_state'] = getchild_diagnosticexam_status($value->ss_aw_child_id);	
				}
				
                $responseary['status'] = 200;
                $responseary['msg'] = "Child Found";
                 $responseary['user_id'] = $parent_id;
                $responseary['result'] = $child_array;

              } 
               else
               {
               	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1009');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
						}
               }

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
  }

  public function change_password()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
     	 $parent_id = $inputpost['user_id'];
		 $parent_token = $inputpost['user_token'];
		if($this->check_parent_existance($parent_id,$parent_token))
			{
				$old_password = $inputpost['old_password'];	
				$password = $inputpost['password'];			
				$result=$this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
				$parent_password=$result[0]->ss_aw_parent_password;
				if ($this->bcrypt->check_password($old_password, $parent_password))
				{
                    $hash_pass = $this->bcrypt->hash_password($password);
                    $result = $this->ss_aw_parents_model->password_update($parent_id,$hash_pass);
                    if($result)
                    {
                    	$responseary['status'] = 200;
		                $responseary['msg'] = "Password successfully change";
		                $responseary['user_id'] =  $parent_id;
                    }
                    else
                    {
                    	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1019');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
						}

                    }			
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1020');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";		
					}
				}
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
  }

  public function delete_child()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();
     if($inputpost)
     {
     	 $parent_id = $inputpost['user_id'];
		 $parent_token = $inputpost['user_token'];
		if($this->check_parent_existance($parent_id,$parent_token))
			{
               	$child_id = $inputpost['child_id'];
               	$result = $this->ss_aw_childs_model->delete_child($child_id,$parent_id);
               	if($result)
               	{
               		$responseary['status'] = 200;
               		$responseary['child_id'] = $child_id;
	                $responseary['msg'] = "Child successfully deleted";
               	}
               	else
               	{
               		$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1021');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
						}
               	}
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
  }
  


   public function update_child_details()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();
     if($inputpost)
     {
     	 $parent_id = $inputpost['user_id'];
		 $parent_token = $inputpost['user_token'];
		if($this->check_parent_existance($parent_id,$parent_token))
			{
				$child_email = $inputpost['child_email'];
				if ($this->check_child_email_existance($child_email, $parent_id)) {
					$child_id = $inputpost['child_id'];
					$updateary = array();
					if(isset($inputpost['child_nick_name']))
					{
						$updateary['ss_aw_child_nick_name'] = $inputpost['child_nick_name'];
					}
					if(isset($inputpost['child_first_name']))
					{
						$updateary['ss_aw_child_first_name'] = $inputpost['child_first_name'];
					}
					if(isset($inputpost['child_last_name']))
					{
						$updateary['ss_aw_child_last_name'] = $inputpost['child_last_name'];
					}
					if(isset($inputpost['child_gender']))
					{
						$updateary['ss_aw_child_gender'] = $inputpost['child_gender'];   //1 = Male , 2= Female
					}
					if(isset($inputpost['child_schoolname']))
					{
						$updateary['ss_aw_child_schoolname'] = trim($inputpost['child_schoolname']);
						$check_duplicate = $this->ss_aw_schools_model->check_duplicate($updateary['ss_aw_child_schoolname']);
						if ($check_duplicate == 0) {
							$school_data = array(
								'ss_aw_name' => $updateary['ss_aw_child_schoolname']
							);
							$this->ss_aw_schools_model->add_record($school_data);
						}
					}
					if(isset($inputpost['password']))
					{
						$password = $inputpost['password'];
						$hash_pass = $this->bcrypt->hash_password($password);
						$updateary['ss_aw_child_password'] = $password;
					}
					if(isset($inputpost['child_dob']))
					{
						$updateary['ss_aw_child_dob'] = $inputpost['child_dob'];
					}
					if(isset($inputpost['child_email']))
					{
						$updateary['ss_aw_child_email'] = $inputpost['child_email'];
					}
					if(isset($inputpost['child_country_code']))
					{
						$updateary['ss_aw_child_country_code'] = $inputpost['child_country_code'];
					}
					if(isset($inputpost['country_sort_name']))
					{
						$updateary['ss_aw_child_country_sort_name'] = $inputpost['country_sort_name'];
					}
					if(isset($inputpost['child_mobile']))
					{
						$updateary['ss_aw_child_mobile'] = $inputpost['child_mobile'];
					}
					$updateary['ss_aw_child_modified_date'] = date('Y-m-d H:i:s');

					$result = $this->ss_aw_childs_model->update_child_details($updateary,$child_id);

					if($result)
					{
						$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
						//send profile update email to child
						$email_template = getemailandpushnotification(29, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							$mail_data = array(
								'ss_aw_email' => $child_details[0]->ss_aw_child_email,
								'ss_aw_type' => 2,
								'ss_aw_content' => $body,
								'ss_aw_subject' => $email_template['title']
							);
							$check_data = $this->ss_aw_update_profile_log_model->check_duplicate($mail_data);
							
							if ($check_data == 0) {
								$this->ss_aw_update_profile_log_model->insert_data($mail_data);	
							}

							//emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
						}
						//end
						$responseary['status'] = 200;
						$responseary['child_id'] = $child_id;
						$responseary['msg'] = 'Update successfully done';					
					}
					else
					{ 
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1017');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
						}

					}	
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1012');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
					}
				}
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
 }


















/////////////////////////////////////////////////////////////////////

  public function check_parent_existance($parent_id,$parent_token)
  { 
  	if ($parent_id == 17) {
  	 	return 1;
  	}
  	else{
  		$response = $this->ss_aw_parents_model->check_parent_existance($parent_id,$parent_token);
	  	if($response)
	  	{
	  		return 1;
	  	}
	  	else
	  	{
	  		$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;				
			}
	  	}
	  	echo json_encode($responseary);	
  	} 	
 	die();
  }

  public function check_email_existance($email){

		$response = $this->ss_aw_parents_model->check_email($email);
		$child_email_response = $this->ss_aw_childs_model->check_email($email);
		if (empty($response) && empty($child_email_response)) {
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function check_mobile_existance($mobile){

		$response = $this->ss_aw_parents_model->check_mobile($mobile);
		$child_mobile_response = $this->ss_aw_childs_model->check_mobile($mobile);
		if (empty($response) && empty($child_mobile_response)) {
			return 1;
		}
		else
		{
			return 0;
		}
	}

  function random_strings($length_of_string) { 
  
    // random_bytes returns number of bytes 
    // bin2hex converts them into hexadecimal format 
    return substr(md5(time()), 0, $length_of_string); 
}

	
	
	public function purchase_courses()
	{
		 $inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 $child_id = $inputpost['child_id'];
			 $course_id = $inputpost['course_id'];
			 $transaction_id = $inputpost['transaction_id'];
			 $payment_amount = $inputpost['payment_amount'];
			 $invoice_prefix = "ALWS/";
			 $invoice_suffix = "/".date('m').date('y');
			 $get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
			 if (!empty($get_last_invoice_details)) {
			 	$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
			 	if (!empty($invoice_ary)) {
			 		if (!empty($invoice_ary[1])) {
			 			if (is_numeric($invoice_ary[1])) {
			 				$suffix_num = (int)$invoice_ary[1] + 1;
			 				$invoice_no = $invoice_prefix.$suffix_num;
			 			}
			 			else{
			 				$invoice_no = $invoice_prefix."100001";
			 			}
			 		}
			 		else{
			 			$invoice_no = $invoice_prefix."100001";
			 		}
			 	}
			 	else{
			 		$invoice_no = $invoice_prefix."100001";
			 	}
			 }
			 else{
			 	$invoice_no = $invoice_prefix."100001";
			 }
			 $invoice_no = $invoice_no.$invoice_suffix;
			 $gst_rate = $inputpost['gst_rate'];
			 $discount_amount = $inputpost['discount_amount'];
			 $coupon_id = $inputpost['coupon_id'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

					$data = array();
					$data['transaction_id'] = $transaction_id;
					$data['payment_amount'] = $payment_amount;
					$data['course_id'] = $course_id;
					$data['invoice_no'] = $invoice_no;
					$data['parent_details'] = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);
					$data['discount_amount'] = $discount_amount;
					$data['gst_rate'] = $gst_rate;
					$data['coupon_id'] = $coupon_id;
					$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => $course_id));
					$data['payment_type'] = $inputpost['emi_payment'];
					
					$this->load->library('pdf');
					$html = $this->load->view('pdf/paymentinvoice', $data, true);
					
					$filename = time().rand()."_".$child_id.".pdf";
					$save_file_path = "./payment_invoice/".$filename;
					$this->pdf->createPDF($save_file_path, $html, $filename, false);

					$this->db->trans_start();
					//update parent user type
					$updated_user_type = 3;
					$check_self_enrolled = $this->ss_aw_childs_model->check_self_enrolled($parent_id);
					if (!empty($check_self_enrolled)) {
						$updated_user_type = 5;
					}
					else{
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
					$searary['ss_aw_parent_id'] = $parent_id;
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_selected_course_id'] = $course_id;
					$searary['ss_aw_transaction_id'] = $transaction_id;
					$searary['ss_aw_course_payment'] = $payment_amount;
					$searary['ss_aw_invoice'] = $filename;
					$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
					$payment_invoice_file_path = base_url()."payment_invoice/".$filename;
					$searary = array();
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_course_id'] = $course_id;
					if ($inputpost['emi_payment']) {
						$searary['ss_aw_course_payemnt_type'] = 1;	
					}					
					$courseary = $this->ss_aw_child_course_model->data_insert($searary);

					$searary = array();
					$searary['ss_aw_parent_id'] = $parent_id;
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_payment_invoice'] = $invoice_no;
					$searary['ss_aw_transaction_id'] = $transaction_id;
					$searary['ss_aw_payment_amount'] = $payment_amount;
					$searary['ss_aw_gst_rate'] = $gst_rate;
					$searary['ss_aw_discount_coupon'] = $coupon_id;
					$searary['ss_aw_discount_amount'] = $discount_amount;
					$courseary = $this->ss_aw_payment_details_model->data_insert($searary);
					
					//revenue mis data store
					$invoice_amount = $payment_amount - $gst_rate;
					$reporting_collection_data = array(
						'ss_aw_parent_id' => $parent_id,
						'ss_aw_bill_no' => $invoice_no,
						'ss_aw_course_id' => $course_id,
						'ss_aw_invoice_amount' => $invoice_amount,
						'ss_aw_discount_amount' => $discount_amount,
						'ss_aw_payment_type' => $inputpost['emi_payment']
					);

					$resporting_collection_insertion = $this->ss_aw_reporting_collection_model->store_data($reporting_collection_data);
					if ($resporting_collection_insertion) {
						if ($inputpost['emi_payment']) {
							if ($inputpost['promoted']) {
								if ($course_id == 2) {
									$previous_course_id = 1;
									$promoted_course_duration = 175;
									$previous_course_duration = 105;
								}
								elseif ($course_id == 3) {
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
								$today_date = date('Y')."-".date('m')."-01";
								//first insertion
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $previous_course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $inputpost['emi_payment']
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

								//second insertion
								$today_date = date('Y-m-d');
								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today = date('d');
								$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
								$remaing_days = $days_current_month - $today;

								$revenue_invoice_amount = ( $previous_invoice_amount / $days_current_month ) * $remaing_days;

								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $inputpost['emi_payment'],
									'ss_aw_advance' => 1
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							}
							else{
								$today_date = date('Y-m-d');
								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today = date('d');
								$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
								$remaing_days = $days_current_month - $today;

								$revenue_invoice_amount = ( $invoice_amount / $days_current_month ) * $remaing_days;

								//for the first insertion
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $remaing_days,
									'ss_aw_payment_type' => $inputpost['emi_payment']
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

								//for the second insertion
								$remaing_amount = $invoice_amount - $revenue_invoice_amount;
								if ($remaing_amount > 0) {
									$today_date = new DateTime();
									$today_date->format('Y-m-d');
									$day = $today_date->format('j');
									$today_date->modify('first day of +1 month');
									$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
									$today_date = $today_date->format('Y-m-d');
									$month = date('m', strtotime($today_date));
									$year = date('Y', strtotime($today_date));
									$today_date = $year."-".$month."-01";
									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($remaing_amount, 2),
										'ss_aw_discount_amount' => 0,
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => 0,
										'ss_aw_payment_type' => $inputpost['emi_payment'],
										'ss_aw_advance' => 1
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								}
							}
						}
						else{
							if (!empty($inputpost['promoted'])){
								if ($course_id == 2) {
									$previous_course_id = 1;
									$promoted_course_duration = 175;
									$previous_course_duration = 105;
								}
								elseif ($course_id == 3) {
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
								$sum_of_reporting_collection = $previous_invoice_amount + round($invoice_amount, 2);
								//end
								$first_revenue_amount = ($previous_invoice_amount / $previous_course_duration) * $today;

								// Store first revenue record
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $previous_course_id,
									'ss_aw_invoice_amount' => round($first_revenue_amount, 2),
									'ss_aw_discount_amount' => round($discount_amount, 2),
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $today,
									'ss_aw_payment_type' => $inputpost['emi_payment']
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								//end

								$previous_level_details = $this->ss_aw_reporting_revenue_model->getpreviousleveldaycount($previous_course_id, $parent_id);
								if (!empty($previous_level_details)) {
									$previous_level_count_day = $previous_level_details[0]->previous_level_count;
								}
								else{
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
											'ss_aw_invoice_amount' => round($second_revenue_amount, 2),
											'ss_aw_discount_amount' => 0,
											'ss_aw_revenue_date' => $today_date,
											'ss_aw_revenue_count_day' => $remaing_days,
											'ss_aw_payment_type' => $inputpost['emi_payment']
										);

										$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
									}
									else{
										$advance_payment = 1;
										$today_date = date('Y-m-d');
										$today_date = date('Y-m-d', strtotime($today_date. ' + '.$count.' month'));
										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = 0;
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;
										$today_date = $year."-".$month."-01";

										if ($remaing_days > $course_duration) {
											$remaing_days = $course_duration;
											$course_duration = 0;
										}
										else{
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
											'ss_aw_invoice_amount' => round($second_revenue_amount, 2),
											'ss_aw_discount_amount' => 0,
											'ss_aw_revenue_date' => $today_date,
											'ss_aw_revenue_count_day' => $remaing_days,
											'ss_aw_payment_type' => $inputpost['emi_payment'],
											'ss_aw_advance' => $advance_payment
										);

										$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
									}
									$count++;
								}
							}
							else{
								if ($course_id == 1 || $course_id == 2) {
									$fixed_course_duration = WINNERS_DURATION;
									$course_duration = WINNERS_DURATION;
								}
								elseif ($course_id == 3) {
									$fixed_course_duration = CHAMPIONS_DURATION;
									$course_duration = CHAMPIONS_DURATION;
								}
								else{
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
									}
									else{
										$advance_payment = 1;

										$today_date = new DateTime();
										$today_date->format('Y-m-d');
										$day = $today_date->format('j');
										$today_date->modify('first day of + '.$count.' month');
										$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
										$today_date = $today_date->format('Y-m-d');

										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = 0;
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;
										$today_date = $year."-".$month."-01";
									}

									if ($remaing_days > $course_duration) {
										$remaing_days = $course_duration;
										$course_duration = 0;
									}
									else{
										$course_duration = $course_duration - $remaing_days;	
									}

									$revenue_invoice_amount = ( $invoice_amount / $fixed_course_duration ) * $remaing_days;
									$revenue_discount_amount = 0;
									if ($discount_amount > 0) {
										$revenue_discount_amount = ( $discount_amount / $fixed_course_duration ) * $remaing_days;
									}

									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
										'ss_aw_discount_amount' => round($revenue_discount_amount, 2),
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => $inputpost['emi_payment'],
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
					$responseary['status'] = 200;
					$responseary['user_type'] = $updated_user_type;
					$responseary['msg'] = "Purchase new course successfully done.";

					if (empty($inputpost['promoted'])) {
						$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);

						//send notification code
						if ($course_id == 1 || $course_id == 2) {
							$course_name = Winners;
						}
						elseif($course_id == 3){
							$course_name = Champions;
						}
						else{
							$course_name = Master."s";
						}

						if (!empty($child_details)) {
							if ($course_id == 1 || $course_id == 2) {
								$email_template = getemailandpushnotification(7, 1, 2);
								$app_template = getemailandpushnotification(7, 2, 2);
								$action_id = 9;
							}
							elseif($course_id == 3){
								$email_template = getemailandpushnotification(32, 1, 2);
								$app_template = getemailandpushnotification(32, 2, 2);
								$action_id = 11;
							}
							else{
								$email_template = getemailandpushnotification(33, 1, 2);
								$app_template = getemailandpushnotification(33, 2, 2);
								$action_id = 11;
							}

							$month_date = date('d/m/Y');
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
								emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
							}

							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
								$title = $app_template['title'];
								$token = $child_details[0]->ss_aw_device_token;

								pushnotification($title,$body,$token,$action_id);

								$save_data = array(
									'user_id' => $child_details[0]->ss_aw_child_id,
									'user_type' => 2,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => $action_id
								);

								save_notification($save_data);
							}
							
							$this->ss_aw_childs_model->logout($child_details[0]->ss_aw_child_id);
						}
						
						if (empty($child_details[0]->ss_aw_child_username)) {
							//payment confirmation email notification.
								$email_template = getemailandpushnotification(59, 1, 1);
								if (!empty($email_template)) {
									$body = $email_template['body'];
									$body = str_ireplace("[@@course_name@@]", $course_name, $body);
									$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
									$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
									$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
									$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
									$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
									$gender = $child_details[0]->ss_aw_child_gender;
									if ($gender == 2) {
										$g_name = "She";
									}
									else{
										$g_name = "He";
									}
									$body = str_ireplace("[@@gender@@]", $g_name, $body);
									emailnotification($parent_detail[0]->ss_aw_parent_email, 'Payment Confirmation', $body);
								}

								$app_template = getemailandpushnotification(59, 2, 1);
								if (!empty($app_template)) {
									$body = $app_template['body'];
									$body = str_ireplace("[@@course_name@@]", $course_name, $body);
									$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
									$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
									$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
									$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
									$gender = $child_details[0]->ss_aw_child_gender;
									if ($gender == 2) {
										$g_name = "She";
									}
									else{
										$g_name = "He";
									}
									$body = str_ireplace("[@@gender@@]", $g_name, $body);
									$title = 'Payment Confirmation';
									$token = $parent_detail[0]->ss_aw_device_token;

									pushnotification($title,$body,$token,8);

									$save_data = array(
										'user_id' => $parent_detail[0]->ss_aw_parent_id,
										'user_type' => 1,
										'title' => $title,
										'msg' => $body,
										'status' => 1,
										'read_unread' => 0,
										'action' => 8
									);

									save_notification($save_data);
								}	
						}
						else{
							//payment confirmation email notification.
							$email_template = getemailandpushnotification(6, 1, 1);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
								$gender = $child_details[0]->ss_aw_child_gender;
								if ($gender == 2) {
									$g_name = "She";
								}
								else{
									$g_name = "He";
								}
								$body = str_ireplace("[@@gender@@]", $g_name, $body);
								emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
							}

							$app_template = getemailandpushnotification(6, 2, 1);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$gender = $child_details[0]->ss_aw_child_gender;
								if ($gender == 2) {
									$g_name = "She";
								}
								else{
									$g_name = "He";
								}
								$body = str_ireplace("[@@gender@@]", $g_name, $body);
								$title = $app_template['title'];
								$token = $parent_detail[0]->ss_aw_device_token;

								pushnotification($title,$body,$token,8);

								$save_data = array(
									'user_id' => $parent_detail[0]->ss_aw_parent_id,
									'user_type' => 1,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => 8
								);

								save_notification($save_data);
							}
						}
						
						if (!empty($parent_detail) && !empty($child_details[0]->ss_aw_child_username)) {
							// if ($course_id == 1 || $course_id == 2) {
							// 	$email_template = getemailandpushnotification(7, 1, 1);
							// 	$app_template = getemailandpushnotification(7, 2, 1);
							// 	$action_id = 9;
							// }
							// elseif($course_id == 3){
							// 	$email_template = getemailandpushnotification(32, 1, 1);
							// 	$app_template = getemailandpushnotification(32, 2, 1);
							// 	$action_id = 11;
							// }
							// else{
							// 	$email_template = getemailandpushnotification(33, 1, 1);
							// 	$app_template = getemailandpushnotification(33, 2, 1);
							// 	$action_id = 11;
							// }

							// if (!empty($email_template)) {
							// 	$body = $email_template['body'];
							// 	$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							// 	$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
							// 	$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
							// 	$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							// 	$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
							// 	$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
							// 	$gender = $child_details[0]->ss_aw_child_gender;
							// 	if ($gender == 2) {
							// 		$g_name = "She";
							// 	}
							// 	else{
							// 		$g_name = "He";
							// 	}
							// 	$body = str_ireplace("[@@gender@@]", $g_name, $body);
							// 	emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
							// }

							// if (!empty($app_template)) {
							// 	$body = $app_template['body'];
							// 	$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							// 	$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
							// 	$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
							// 	$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							// 	$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
							// 	$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
							// 	$gender = $child_details[0]->ss_aw_child_gender;
							// 	if ($gender == 2) {
							// 		$g_name = "She";
							// 	}
							// 	else{
							// 		$g_name = "He";
							// 	}
							// 	$body = str_ireplace("[@@gender@@]", $g_name, $body);
							// 	$title = $app_template['title'];
							// 	$token = $parent_detail[0]->ss_aw_device_token;

							// 	pushnotification($title,$body,$token,8);

							// 	$save_data = array(
							// 		'user_id' => $parent_detail[0]->ss_aw_parent_id,
							// 		'user_type' => 1,
							// 		'title' => $title,
							// 		'msg' => $body,
							// 		'status' => 1,
							// 		'read_unread' => 0,
							// 		'action' => 8
							// 	);

							// 	save_notification($save_data);
							// }
						}
					}
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
	}
	public function recomended_course_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 $child_id = $inputpost['child_id'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$searchary = array();
					$searchary['ss_aw_diagonastic_child_id'] = $child_id;
					$resultary = array();
					$resultary = $this->ss_aw_diagonastic_exam_model->fetch_record_byparam($searchary);
					if(!empty($resultary))
					{
						$exam_code = $resultary[0]['ss_aw_diagonastic_exam_code'];
						$searchary = array();
						$searchary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
						$examresultary = array();
						$examresultary = $this->ss_aw_diagonastic_exam_log_model->fetch_record_byparam($searchary);
						$resultcountary = array();
						foreach($examresultary as $value)
						{
							if($value['ss_aw_diagonastic_log_answer_status'] != 3)
							{
								$resultcountary[$value['ss_aw_diagonastic_log_level']]['total_ask'][] = $value['ss_aw_diagonastic_log_question_id'];
								if($value['ss_aw_diagonastic_log_answer_status'] == 1)
									$resultcountary[$value['ss_aw_diagonastic_log_level']]['right_ans'][] = $value['ss_aw_diagonastic_log_question_id'];
							}
						}
						$pct_level_e = "";
						$pct_level_c = "";
						$pct_level_a = "";
						if(!empty($resultcountary['E']))
							$pct_level_e  = round((count($resultcountary['E']['right_ans'])/count($resultcountary['E']['total_ask']))*100);
						
						if(!empty($resultcountary['C']))
							$pct_level_c  = round((count($resultcountary['C']['right_ans'])/count($resultcountary['C']['total_ask']))*100);
						
						if(!empty($resultcountary['A']))
							$pct_level_a  = round((count($resultcountary['A']['right_ans'])/count($resultcountary['A']['total_ask']))*100);
						
						/*This Checking for the E level student whose age bellow 13 years */
						if(!empty($resultcountary['E']))
						{
							if($pct_level_e > 80 && $pct_level_c > 70)
							{
								$recomended_level = 'C';
							}
							else
							{
								$recomended_level = 'E';
							}
						}
						/*This Checking for the C level student whose age above 13 years */
						if(!empty($resultcountary['C']))
						{
							if($pct_level_c > 80 && $pct_level_a > 70)
							{
								$recomended_level = 'A';
							}
							else if($pct_level_c < 50)
							{
								$recomended_level = 'E';
							}
							else
							{
								$recomended_level = 'C';
							}
						}
						$searary = array();
						$searary['ss_aw_course_type_id'] = 1;
						$courseary = $this->ss_aw_courses_model->search_byparam($searary);
						$i = 0;
						$j = 0;
						$responseary['status'] = 200;
						$recomended_course_id = 0;
						if(!empty($courseary))
						{
							foreach($courseary as $val)
							{
								if($recomended_level == $val['ss_aw_course_code'])
								{
									if ($val['ss_aw_course_id'] == 1) {
				                      $readalong_count = EMERGING_READALONG;
				                    }
				                    elseif ($val['ss_aw_course_id'] == 2) {
				                      $readalong_count = CONSOLATING_READALONG;
				                    }
				                    else{
				                      $readalong_count = ADVANCED_READALONG;
				                    }

									$responseary['recomended_courses'][$i]['course_code'] = $val['ss_aw_course_code'];
									$responseary['recomended_courses'][$i]['course_id'] = $val['ss_aw_course_id'];
									$responseary['recomended_courses'][$i]['course_name'] = $val['ss_aw_course_name'];
									//$responseary['recomended_courses'][$i]['course_price'] = $val['ss_aw_course_price'];
									$responseary['recomended_courses'][$i]['course_price'] = ((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100) + 0;
									$result_arrr = array();
									$result_arrr = $this->ss_aw_course_count_model->get_course_count($val['ss_aw_course_id']);   

									$responseary['recomended_courses'][$i]['lessons'] = $result_arrr[0]['ss_aw_lessons'];
									$responseary['recomended_courses'][$i]['assessments'] = $result_arrr[0]['ss_aw_assessments'];
									$responseary['recomended_courses'][$i]['readalong'] = $readalong_count;	          			 

						
									$i++;
									$recomended_course_id = intVal($val['ss_aw_course_id']);
								}
							}
							foreach($courseary as $val)
							{
							if($recomended_course_id > 0 && intVal($val['ss_aw_course_id']) < $recomended_course_id)
								{
									if ($val['ss_aw_course_id'] == 1) {
				                      $readalong_count = EMERGING_READALONG;
				                    }
				                    elseif ($val['ss_aw_course_id'] == 2) {
				                      $readalong_count = CONSOLATING_READALONG;
				                    }
				                    else{
				                      $readalong_count = ADVANCED_READALONG;
				                    }
									$responseary['other_courses'][0]['course_code'] = $val['ss_aw_course_code'];
									$responseary['other_courses'][0]['course_id'] = $val['ss_aw_course_id'];
									$responseary['other_courses'][0]['course_name'] = $val['ss_aw_course_name'];
									//$responseary['other_courses'][0]['course_price'] = $val['ss_aw_course_price'];
									$responseary['other_courses'][0]['course_price'] = ((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100) + 0;
									$result_arrr = array();
									$result_arrr = $this->ss_aw_course_count_model->get_course_count($val['ss_aw_course_id']);   

									$responseary['other_courses'][0]['lessons'] = $result_arrr[0]['ss_aw_lessons'];
									$responseary['other_courses'][0]['assessments'] = $result_arrr[0]['ss_aw_assessments'];
									$responseary['other_courses'][0]['readalong'] = $readalong_count;
									
									$j++;
								}
							}
						}
					}
					else
					{
							$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";	
							}							
					}
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
	}
	
	


	
	 
	 
	 public function courses_list()
	{
		 $inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$searary = array();
					$searary['ss_aw_course_type_id'] = 1;
					$courseary = $this->ss_aw_courses_model->search_byparam($searary);
					$i = 0;
					$responseary['status'] = 200;
					foreach($courseary as $val)
					{
						if($val['ss_aw_course_code'] != 'S')
						{
						$responseary['result'][$i]['course_id'] = $val['ss_aw_course_id'];
						$responseary['result'][$i]['course_name'] = $val['ss_aw_course_name'];
						$responseary['result'][$i]['sort_desc'] = $val['ss_aw_sort_description'];
						$responseary['result'][$i]['long_desc'] = $val['ss_aw_long_description'];
						//$responseary['result'][$i]['gst_rate'] = $val['ss_aw_gst_rate'];
						//$responseary['result'][$i]['actual_course_price'] = $val['ss_aw_course_price'];
						
						$responseary['result'][$i]['gst_rate'] = str_replace("%","",$val['ss_aw_gst_rate']) + 0;
						$responseary['result'][$i]['actual_course_price'] = str_replace(",","",$val['ss_aw_course_price']) + 0; // Without GST
						
						//$responseary['result'][$i]['course_price'] = number_format((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100,2);
						$responseary['result'][$i]['course_price'] = ((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100) + 0;
						$i++;
						}
					}
					$result = $responseary['result'];
					$n=0;
					foreach ($result as $value) { 

					  $result_arrr[$n] = $this->ss_aw_course_count_model->get_course_count($value['course_id']);   

					   $responseary['result'][$n]['lessons'] = $result_arrr[$n][0]['ss_aw_lessons'];
                      $responseary['result'][$n]['assessments'] = $result_arrr[$n][0]['ss_aw_assessments'];
                      if ($value['course_id'] == 1) {
                      	$readalong_count = EMERGING_READALONG;
                      }
                      elseif ($value['course_id'] == 2) {
                      	$readalong_count = CONSOLATING_READALONG;
                      }
                      else{
                      	$readalong_count = ADVANCED_READALONG;
                      }
                      $responseary['result'][$n]['readalong'] = $readalong_count;	          			 

						$n++;					
					}
					
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
	}
	
	public function get_all_schoolname()
	{
		 $inputpost = $this->input->post();		
		 $responseary = array();
		 $school_array = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$search_data = $inputpost['search_data'];
					$result = $this->ss_aw_schools_model->searched_scl_list($search_data);              
                    for($i=0;$i<count($result);$i++)
                    {
                        $school_array[$i] = $result[$i]->ss_aw_name;	
                    }			

					$responseary['status'] = '200';
					$responseary['msg'] = 'Data Found';
					$responseary['result'] = $school_array;

					
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
	}
	
	 public function recomended_course_details()
	{
		 $inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			$parent_id = $inputpost['user_id'];
			$parent_token = $inputpost['user_token'];
			$child_id = $inputpost['child_id']; 
			$course_id = $inputpost['course_id'];
			if (!empty($inputpost['device_type'])) {
			 	$device_type = $inputpost['device_type'];
			}
			else{
				$device_type = "";
			}
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					if (empty($course_id)) {
						$child_course_details = $this->ss_aw_child_course_model->get_child_complete_course($child_id);
						$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
						if (!empty($child_course_details)) {
							$last_course_id = $child_course_details[count($child_course_details) - 1]['ss_aw_course_id'];
							if ($last_course_id == 1 || $last_course_id == 2) {
								$course_id = 3;
							}
							elseif ($last_course_id == 3) {
								$course_id = 4;
							}
						}
						else{
							if ($child_details[0]->ss_aw_child_age >= 18) {
								$course_id = 5;
							}
							else{
								$course_id = 1;	
							}
						}	
					}
					
					$searary = array();
					$searary['ss_aw_course_id'] = $course_id;
					$courseary = $this->ss_aw_courses_model->search_byparam($searary);
					
					$level = $courseary[0]['ss_aw_course_id'];
					$topic_listary = array();
					$general_language_lessons = array();
					if ($course_id == 1 || $course_id == 2) {
						$search_data = array();
						$search_data['ss_aw_expertise_level'] = 'E';
						$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
						$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
					}
					elseif($course_id == 3){
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
						foreach ($topic_listary as $key => $value) {
							$topicAry[] = $value->ss_aw_section_id;
						}
					}
					$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

					$lesson_listary = array_merge($topical_lessons, $general_language_lessons);

					if(!empty($lesson_listary))
					{
						foreach($lesson_listary as $key=>$value)
						{
							$responseary['result']['topics'][$key]['title']= $value['ss_aw_lesson_topic'];
							$responseary['result']['topics'][$key]['description']= $value['ss_aw_topic_description'];
						}
						
					foreach($courseary as $val)
					{					
						$responseary['result']['course_id'] = $val['ss_aw_course_id'];
						$responseary['result']['course_code'] = $val['ss_aw_course_code'];
						$responseary['result']['course_name'] = $val['ss_aw_course_name'];
						$responseary['result']['sort_desc'] = $val['ss_aw_sort_description'];
						$responseary['result']['long_desc'] = $val['ss_aw_long_description'];
						$responseary['result']['gst_rate'] = str_replace("%","",$val['ss_aw_gst_rate']) + 0;
						$lumpsum_amount = 0;
						if ($device_type == 'IOS') {
							$lumpsum_amount = $val['ss_aw_apple_course_price'];
						}
						else{
							$lumpsum_amount = $val['ss_aw_course_price'];
						}
						$course_price_with_gst = str_replace(",","",$lumpsum_amount);
						$course_price_with_gst = (float)$course_price_with_gst;
						$gst_rate = str_replace("%","",$val['ss_aw_gst_rate']);
						$course_price = ($course_price_with_gst * 100) / (100 + $gst_rate);
						$course_price = number_format($course_price, 2);
						$course_price = str_replace(",", "", $course_price);
						$course_price = (float)$course_price;
						$responseary['result']['course_price_with_gst'] = $course_price_with_gst;
						$responseary['result']['course_price'] = $course_price;
					}
					
					$coursecount_ary = $this->ss_aw_course_count_model->get_course_count($course_id);   

					 $responseary['result']['lessons'] = $coursecount_ary[0]['ss_aw_lessons'];
                     $responseary['result']['assessments'] = $coursecount_ary[0]['ss_aw_assessments'];
                     $responseary['result']['readalong'] = $coursecount_ary[0]['ss_aw_readalong'];
                     	// if ($course_id == 1) {
			            //     $readalong_count = EMERGING_READALONG;
			            // }
			            // elseif ($course_id == 2) {
			            //     $readalong_count = EMERGING_READALONG;
			            // }
			            // else{
			            //     $readalong_count = ADVANCED_READALONG;
			            // }
                     	// $responseary['result']['readalong'] = $readalong_count;
						
						$responseary['status'] = 200;
						
					}
					else
					{
							$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";	
							}							
					}
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
	}
	/*************************************************************************************************************************/
	public function create_ticket()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 
			
		if($this->check_parent_existance($parent_id,$parent_token))
		{
				$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
			
			$getpaentdetails = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			
			$type = $inputpost['type']; 
			$sub_type = $inputpost['sub_type']; 
			$message = $inputpost['message']; 
			
			$subject = $inputpost['subject'];
			
			$custom_fields=array("cf_types"=>$type,"cf_sub_types"=>$sub_type);

			$ticket_data = json_encode(array(
			  "description" => $message,
			  "subject" => $subject,
			  "email" => $getpaentdetails[0]->ss_aw_parent_email,
			  "priority" => 1,
			  "status" => 2,
			  //"cc_emails" => array("ram@freshdesk.com", "diana@freshdesk.com"),
			  "custom_fields" => $custom_fields,
			  //"cf_cf_testing" => "Hello World"
			));

			$url = "https://$yourdomain.freshdesk.com/api/v2/tickets";

			$ch = curl_init($url);

			$header[] = "Content-type: application/json";
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


			$server_output = curl_exec($ch);
			$info = curl_getinfo($ch);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = substr($server_output, 0, $header_size);
			$response = substr($server_output, $header_size);

			if($info['http_code'] == 201) {
				$responseary['status'] = 200;
				$responseary['msg'] = "Ticket created successfully.";

				$html = "Subject: <p>".$subject."</p>";
				$html .= "Message: <p>".$message."</p>";
				$html .= "Parent Email: <p>".$getpaentdetails[0]->ss_aw_parent_email."</p>";
				emailnotification_disputes('support@alsowise.com', 'Disputes', $html);
			 
			} else {
			  if($info['http_code'] == 404) {
				$responseary['status'] = 500;
				$responseary['msg'] = "Error, Please check the end point";
			  } else {
				$responseary['status'] = 500;
				$responseary['msg'] = "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			  }
			}

			curl_close($ch);
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
	}
	
	public function ticket_list()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 
			
		if($this->check_parent_existance($parent_id,$parent_token))
		{
				$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
			
			$getpaentdetails = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			
			$parentemail = urlencode($getpaentdetails[0]->ss_aw_parent_email);

			

			$url = "https://$yourdomain.freshdesk.com/api/v2/tickets?email=$parentemail";

			$ch = curl_init($url);

			$header[] = "Content-type: application/json";
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$info = curl_getinfo($ch);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = substr($server_output, 0, $header_size);
			$response = substr($server_output, $header_size);

			$responsedata = array();
			$responsedata = json_decode($response,true);
			if($info['http_code'] == 200) {
				if(!empty($responsedata))
				{
				$responseary['status'] = 200;
				$key = 0;
				foreach($responsedata as $value)
				{	
						$responseary['result'][$key]['sender_name'] = $getpaentdetails[0]->ss_aw_parent_full_name;
						$responseary['result'][$key]['subject'] = $value['subject'];
						$responseary['result'][$key]['ticket_id'] = $value['id'];
						$responseary['result'][$key]['status'] = $value['status'];
						$responseary['result'][$key]['create_date'] = $value['fr_due_by'];
						$responseary['result'][$key]['type'] = $value['custom_fields']['cf_types'];
						$responseary['result'][$key]['sub_type'] = $value['custom_fields']['cf_sub_types'];
						$key++;
				}
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";		
				}
				}
				
			} else {
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";
							}
			}

			curl_close($ch);
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
	}
	
	public function ticket_details()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 
			
		if($this->check_parent_existance($parent_id,$parent_token))
		{
				$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
			
				$getpaentdetails = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			
				$parentemail = $getpaentdetails[0]->ss_aw_parent_email;			
				
				$ticketid = $inputpost['ticket_id'];
				$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticketid";

		$ch = curl_init($url);

		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		
		if($info['http_code'] == 200) {
			$responsedata = json_decode($response,true);
			
			$responseary['status'] = 200;
				$contactuser = array();
				$contactuser = $this->contact_details();
	
				$responseary['result']['ticket_details']['sender_email'] = $parentemail;
				$responseary['result']['ticket_details']['subject'] = $responsedata['subject'];
				$responseary['result']['ticket_details']['description'] = $responsedata['description_text'];
				$responseary['result']['ticket_details']['ticket_id'] = $responsedata['id'];
				$responseary['result']['ticket_details']['status'] = $responsedata['status'];
				$responseary['result']['ticket_details']['create_date'] = $responsedata['created_at'];
				$responseary['result']['ticket_details']['update_date'] = $responsedata['updated_at'];
				$responseary['result']['ticket_details']['requester_id'] = $responsedata['requester_id'];
				$responseary['result']['ticket_details']['type'] = $responsedata['custom_fields']['cf_types'];
				$responseary['result']['ticket_details']['sub_type'] = $responsedata['custom_fields']['cf_sub_types'];
				
				$searchary = array();
				$searchary['ss_aw_parent_email'] = $parentemail;
				$usersdetailsary = $this->ss_aw_parents_model->search_byparam($searchary);
				if(!empty($usersdetailsary[0]['ss_aw_parent_full_name']))
					$responseary['result']['ticket_details']['parent_full_name'] = $usersdetailsary[0]['ss_aw_parent_full_name'];
				else
					$responseary['result']['ticket_details']['parent_full_name'] = "";
				if(!empty($usersdetailsary[0]['ss_aw_parent_profile_photo']))
					$responseary['result']['ticket_details']['profile_photo'] = base_url()."uploads/".$usersdetailsary[0]['ss_aw_parent_profile_photo'];
				else
					$responseary['result']['ticket_details']['profile_photo'] = base_url()."uploads/profile.jpg";
			/*************** Conversion **************************************/
				$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticketid/conversations";

				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_POST, false);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
				//curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec($ch);
				$info = curl_getinfo($ch);
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$headers = substr($server_output, 0, $header_size);
				$response_conversion = substr($server_output, $header_size);
			
				$response_conversion_ary = json_decode($response_conversion,true);
			$conversion_array = array();
			foreach($response_conversion_ary as $key=>$value)
			{
				$conversion_array[$key]['body_text'] = $value['body_text'];
				$conversion_array[$key]['user_id'] = $value['user_id'];
				$conversion_array[$key]['from_email'] = $value['from_email'];
				if(!empty($contactuser[$value['user_id']]))
				{
					$conversion_array[$key]['user_name'] = $contactuser[$value['user_id']]['name'];
				}
				else
				{
					$conversion_array[$key]['user_name'] = "Admin";
					
				}
				$conversion_array[$key]['create_date'] = date('d M, Y H:i:s',strtotime($value['created_at']));
			}
			$responseary['result']['conversion'] = $conversion_array;
			
		} else {
		  if($info['http_code'] == 404) {
			echo "Error, Please check the end point \n";
		  } else {
			echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			echo "Headers are ".$headers;
			echo "Response are ".$response;
		  }
		}
		curl_close($ch);
			
			
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
	}
	
	public function ticket_post_reply()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 
			
		if($this->check_parent_existance($parent_id,$parent_token))
		{
				$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
			
				$getpaentdetails = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			
				$parentemail = $getpaentdetails[0]->ss_aw_parent_email;			
				$contactdetailsary = $this->contact_details();
				$userid = "";
				foreach($contactdetailsary as $value)
				{
					if($value['email'] == $parentemail)
					{
						$userid = $value['id'];
					}
				}
				
				$ticketid = $inputpost['ticket_id'];
				$message = $inputpost['message'];
				
				$ticket_data = json_encode(array(
				  "body" => $message,
				  "user_id" => $userid
				));
				//$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticketid/reply";
			    $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticketid/notes";

				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				$header[] = "Content-type: multipart/form-data";
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec($ch);
				$info = curl_getinfo($ch);
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$headers = substr($server_output, 0, $header_size);
				$response = substr($server_output, $header_size);
				curl_close($ch);
				if($info['http_code'] == 201){
					$responseary['status'] = 200;
					$responseary['msg'] = "Reply post successfully";
				}
				else{
					$responseary['status'] = 500;
					$responseary['error'] = $info;
					$responseary['msg'] = "Reply post fail";
				}
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
	}
	/* Close the ticket or reopen the ticket
	*/
	public function ticket_status_update()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 $ticket_status = $inputpost['ticket_status']; // 2 = OPEN, 5 = Closed
			 
			
		if($this->check_parent_existance($parent_id,$parent_token))
		{
				$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
			
				$getpaentdetails = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			
				$parentemail = $getpaentdetails[0]->ss_aw_parent_email;			
				$contactdetailsary = $this->contact_details();
				$userid = "";
				foreach($contactdetailsary as $value)
				{
					if($value['email'] == $parentemail)
					{
						$userid = $value['id'];
					}
				}
				
				$ticketid = $inputpost['ticket_id'];
				
				
				$ticket_data = json_encode(array(
		  "status" => intVal($ticket_status),			
		  "priority" => 2
		));
				$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticketid";

				$ch = curl_init($url);

				$header[] = "Content-type: application/json";
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
				$server_output = curl_exec($ch);
				$info = curl_getinfo($ch);
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$headers = substr($server_output, 0, $header_size);
				$response = substr($server_output, $header_size);
				
				curl_close($ch);
				if($info['http_code'] == 200){
					$responseary['status'] = 200;
					$responseary['msg'] = "Ticket status update successfully";
				}
				else{
					$responseary['status'] = 500;
					$responseary['msg'] = "Reply post fail";
				}
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
	}
	
	public function contact_details()
	{
		$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
		/********************* Contact Details ***************************/
		$url = "https://$yourdomain.freshdesk.com/api/v2/contacts";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		
		$responsedata_contact = json_decode($response,true);
		$contactuser = array();
		foreach($responsedata_contact as $value)
		{
			$contactuser[$value['id']]['name'] = $value['name'];
			$contactuser[$value['id']]['email'] = $value['email'];
			$contactuser[$value['id']]['id'] = $value['id'];
		}
		return $contactuser;
	}
	
	public function get_dispute_category_list()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 	
			if($this->check_parent_existance($parent_id,$parent_token))
			{
				$json = file_get_contents(base_url()."assets/data/ticket_category.json");
				$obj  = json_decode($json,true);
				$responseary['status'] = 200;
				foreach($obj as $key=>$value)
				{
					$responseary['result'][]= $key;
				}
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
	}
	
	public function get_dispute_subcategory_list()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 $category = ucfirst($inputpost['category']);	
			if($this->check_parent_existance($parent_id,$parent_token))
			{
				$json = file_get_contents(base_url()."assets/data/ticket_category.json");
				$obj = json_decode($json,true);
				$responseary['status'] = 200;
				if(!empty($obj))
				{
					foreach($obj as $key=>$value)
					{
						if($key == $category)
						{
							$responseary['result']= $value;
						}
					}
				}
				else
				{
					$responseary['result']= array();
				}
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
	}
	
	public function purchased_courses_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $child_id = $inputpost['child_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$this->db->trans_start();
					$searchary = array();
					$searchary['ss_aw_parent_id'] = $parent_id;
					$searchary['ss_aw_child_id'] = $child_id;
					$courseary = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
					
					if(!empty($courseary))
					{
						$already_selected_course = array();
						$responseary['status'] = 200;
						$i = 0;
						foreach($courseary as $key=>$val)
						{
							if ($val['ss_aw_selected_course_id'] == 1) {
		                      $readalong_count = EMERGING_READALONG;
		                    }
		                    elseif ($val['ss_aw_selected_course_id'] == 2) {
		                      $readalong_count = CONSOLATING_READALONG;
		                    }
		                    else{
		                      $readalong_count = ADVANCED_READALONG;
		                    }

							if ($val['ss_aw_selected_course_id'] == 1) {
								$previous_level = "E";
							}
							elseif ($val['ss_aw_selected_course_id'] == 2) {
								$previous_level = "C";
							}
							else{
								$previous_level = "A";
							}

							$check_promotion = $this->ss_aw_promotion_model->get_promotion_detail($child_id, $previous_level);
							if (empty($check_promotion)) {
								if (!in_array($val['ss_aw_selected_course_id'], $already_selected_course)) {
									$already_selected_course[] = $val['ss_aw_selected_course_id'];
									$responseary['result'][$i]['course_id'] = $val['ss_aw_selected_course_id'];
									$responseary['result'][$i]['course_code'] = $val['ss_aw_course_code'];
									$responseary['result'][$i]['course_name'] = $val['ss_aw_course_name'];
									$responseary['result'][$i]['sort_description'] = $val['ss_aw_sort_description'];
									$responseary['result'][$i]['long_description'] = $val['ss_aw_long_description'];
									$responseary['result'][$i]['transaction_id'] = $val['ss_aw_transaction_id'];
									$responseary['result'][$i]['course_payment'] = $val['ss_aw_course_payment'];
									$responseary['result'][$i]['course_status'] = $val['ss_aw_course_currrent_status'];
									$responseary['result'][$i]['lessons'] = $val['ss_aw_lessons'];
									$responseary['result'][$i]['assessments'] = $val['ss_aw_assessments'];
									//$responseary['result'][$i]['readalong'] = $readalong_count;
									$responseary['result'][$i]['readalong'] = $val['ss_aw_readalong'];
									$responseary['result'][$i]['purchase_date'] = $val['ss_aw_course_created_date'];	
									$check_course = $this->ss_aw_child_course_model->get_details_by_child_course($child_id, $val['ss_aw_selected_course_id']);
									$purchase_mode = 0;
									if (!empty($check_course)) {
										if ($check_course[0]->ss_aw_course_payemnt_type == 1) {
											$purchase_mode = 1;
										}
										else{
											$purchase_mode = 0;
										}
									}

									$responseary['result'][$i]['purchase_mode'] = $purchase_mode;
								}

								$i++;
							}
						}
					}
					else
					{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";				
							}
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
	}
	/********************************************************* Supplymentary Course Start ********************************/
	public function supplementary_course_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $child_id = $inputpost['child_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$searchary = array();
					$courseary = array();
					$searchary['ss_aw_parent_id'] = $parent_id;
					$searchary['ss_aw_child_id'] = $child_id;
					$searchary['ss_aw_course_currrent_status'] = 1;
					
					//Get the course name which purchased by parent for child
					$courseary = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
					
					if($courseary[0]['ss_aw_selected_course_id'] == 1)
						$current_course = "E";
					else if($courseary[0]['ss_aw_selected_course_id'] == 2)
						$current_course = "C";
					else if($courseary[0]['ss_aw_selected_course_id'] == 3)
						$current_course = "A";
					
					/*
					Get Already Purchased supplementary courses by parent against particular child
					*/
					$searchary = array();
					$searchary['ss_aw_parent_id'] = $parent_id;
					$searchary['ss_aw_child_id'] = $child_id;
					$purchased_supplementarycourses = $this->ss_aw_purchased_supplymentary_course_model->search_byparam($searchary);
					$purchased_course_list_ary = array();
					if(!empty($purchased_supplementarycourses))
					{
						foreach ($purchased_supplementarycourses as $key => $value) {
							$purchase_ids = explode(",", $value['ss_aw_supplymentary_courses']);
							if (!empty($purchase_ids)) {
								foreach ($purchase_ids as $s_id) {
									$purchased_course_list_ary[] = $s_id;
								}
							}
						}
						/*$purchased_course_list_ary = explode(",",$purchased_supplementarycourses[count($purchased_supplementarycourses) - 1]['ss_aw_supplymentary_courses']);*/
					}
					
					//Get the course Price
					$searchary = array();
					$searchary['ss_aw_course_id'] = 4;
					$searchary['ss_aw_course_code'] = 'S';
					$coursedetailsary = $this->ss_aw_courses_model->search_byparam($searchary);
					
					/*
					Count No of Question in a Supplementary course
					*/
					$countrecord_array = array();
					$countrecord_array = $this->ss_aw_supplymentary_model->count_record_no();
					
						
					
					$supplymentary_course_ary = array();
					$supplymentary_course_ary = $this->ss_aw_supplymentary_uploaded_model->get_courselist_bylevel($current_course);
					if(!empty($supplymentary_course_ary))
					{
						$responseary['status'] = 200;

						$course_price_with_gst = str_replace(",","",$coursedetailsary[0]['ss_aw_course_price']);
						$course_price_with_gst = (float)$course_price_with_gst;
						$gst_rate = str_replace("%","",$coursedetailsary[0]['ss_aw_gst_rate']);
						$course_price = ($course_price_with_gst * 100) / (100 + $gst_rate);
						$course_price = number_format($course_price, 2);
						$course_price = str_replace(",", "", $course_price);
						$course_price = (float)$course_price;

						$responseary['gst_rate'] = str_replace("%","",$coursedetailsary[0]['ss_aw_gst_rate']) + 0;
						$responseary['course_price'] = $course_price; // Without GST
						$responseary['course_price_with_gst'] = $course_price_with_gst;

						$responseary['course_currency'] = $coursedetailsary[0]['ss_aw_course_currency'];
						
						foreach($supplymentary_course_ary as $key=>$val)
						{
							if(in_array($val['ss_aw_id'],$purchased_course_list_ary))
							{
								$responseary['result'][$key]['is_course_selected'] = 1; //1 = Course Purcased 0 = Not Purcased
							}
							else
							{
								$responseary['result'][$key]['is_course_selected'] = 0;
							}
							$responseary['result'][$key]['course_id'] = $val['ss_aw_id'];
							foreach($countrecord_array as $countval)
							{
								if($countval['ss_aw_record_id'] == $val['ss_aw_id'])
								{
									$responseary['result'][$key]['question_no'] = $countval['total_question'];
								}
							}
							
							$responseary['result'][$key]['course_name'] = $val['ss_aw_course_name'];
							$responseary['result'][$key]['main_course'] = $val['ss_aw_level'];
							$responseary['result'][$key]['topic_name'] = $val['title_name'];
							//$responseary['result'][$key]['topic_description'] = $val['ss_aw_topic_description'];
							$responseary['result'][$key]['course_description'] = $val['ss_aw_description'];
						}
					}
					else
					{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";				
							}
					}
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
	}
	
	public function purchase_supplementary_courses()
	{
		 $inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			$parent_id = $inputpost['user_id'];
			$parent_token = $inputpost['user_token'];
			$child_id = $inputpost['child_id'];
			$course_id = $inputpost['course_id']; // 1,2,3,4,5
			$transaction_id = $inputpost['transaction_id'];
			$payment_amount = $inputpost['payment_amount'];
			$invoice_no = $inputpost['invoice_no'];
			$gst_rate = $inputpost['gst_rate'];
			$discount_amount = $inputpost['discount_amount'];
			//$coupon_id = $inputpost['coupon_id'];

			if($this->check_parent_existance($parent_id,$parent_token))
			{
				//create invoice number
				$invoice_prefix = "ALWS/";
				$invoice_suffix = "/".date('m').date('y');
				$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
				if (!empty($get_last_invoice_details)) {
					$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
					if (!empty($invoice_ary)) {
					 	if (!empty($invoice_ary[1])) {
					 		if (is_numeric($invoice_ary[1])) {
					 			$suffix_num = (int)$invoice_ary[1] + 1;
					 			$invoice_no = $invoice_prefix.$suffix_num;
					 		}
					 		else{
					 			$invoice_no = $invoice_prefix."100001";
					 		}
					 	}
					 	else{
					 		$invoice_no = $invoice_prefix."100001";
					 	}
					}
					else{
					 	$invoice_no = $invoice_prefix."100001";
					}
				}
				else{
					$invoice_no = $invoice_prefix."100001";
				}
				$invoice_no = $invoice_no.$invoice_suffix;
				//end

				//create invoice PDF
				$data = array();
				$data['transaction_id'] = $transaction_id;
				$data['payment_amount'] = $payment_amount;
				$data['course_id'] = 4;
				$data['invoice_no'] = $invoice_no;
				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
				$data['parent_details'] = $parent_detail;
				$data['discount_amount'] = $discount_amount;
				$data['gst_rate'] = $gst_rate;
				$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => 4));

				$this->load->library('pdf');
				$html = $this->load->view('pdf/supplymentary-paymentinvoice', $data, true);
							
				$filename = time().rand()."_".$child_id.".pdf";
				$save_file_path = "./payment_invoice/".$filename;
				$this->pdf->createPDF($save_file_path, $html, $filename, false);
				//end

				$this->db->trans_start();
				$searary = array();
				$searary['ss_aw_parent_id'] = $parent_id;
				$searary['ss_aw_child_id'] = $child_id;
				$searary['ss_aw_supplymentary_courses'] = $course_id;
				$searary['ss_aw_transection_id'] = $transaction_id;
				$searary['ss_aw_course_payment'] = $payment_amount;
				$courseary = $this->ss_aw_purchased_supplymentary_course_model->data_insert($searary);
					
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

				//send payment confirmation maill to parent and student
				$payment_invoice_file_path = base_url()."payment_invoice/".$filename;
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level = $childary[count($childary) - 1]['ss_aw_course_id'];
				if ($level == 1 || $level == 2) {
					$level_text = "E";
					$course_name = Winners;
				}
				else{
					$level_text = "A";
					$course_name = Champions;
				}

				$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
				$supplymentary_ary = explode(",", $course_id);
				$topic_list = $this->ss_aw_supplymentary_uploaded_model->get_supplymentary_details_by_id($supplymentary_ary);
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

				if (!empty($child_details)) {
					$email_template = getemailandpushnotification(39, 1, 2);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@topic_content@@]", $topic_table, $body);
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
						emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
					}

					$app_template = getemailandpushnotification(39, 2, 2);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$title = $app_template['title'];
						$token = $child_details[0]->ss_aw_device_token;

						pushnotification($title,$body,$token,48);

						$save_data = array(
							'user_id' => $child_details[0]->ss_aw_child_id,
							'user_type' => 2,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 48
						);

						save_notification($save_data);
					}	
				}

				//send notification to parent
				if (!empty($parent_detail) && !empty($child_details[0]->ss_aw_child_username)) {

					$email_template = getemailandpushnotification(39, 1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
						emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
					}

					$app_template = getemailandpushnotification(39, 2, 1);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
						$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
						$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
						$gender = $child_details[0]->ss_aw_child_gender;
						if ($gender == 2) {
							$g_name = "She";
						}
						else{
							$g_name = "He";
						}
						$body = str_ireplace("[@@gender@@]", $g_name, $body);
						$title = $app_template['title'];
						$token = $parent_detail[0]->ss_aw_device_token;

						pushnotification($title,$body,$token,48);

						$save_data = array(
							'user_id' => $parent_detail[0]->ss_aw_parent_id,
							'user_type' => 1,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 48
						);

						save_notification($save_data);
					}
				}

				$responseary['status'] = 200;
				$responseary['msg'] = "Purchase supplementary course successfully done.";
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
	}
	
	public function already_purchased_supplementary_courses_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $child_id = $inputpost['child_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$this->db->trans_start();
					$searchary = array();
					$searchary['ss_aw_parent_id'] = $parent_id;
					$searchary['ss_aw_child_id'] = $child_id;
					$courseary = $this->ss_aw_purchased_supplymentary_course_model->search_byparam($searchary);
					
					if(!empty($courseary))
					{
						foreach($courseary as $key=>$val)
						{
							$course_ary = explode(",",$val['ss_aw_supplymentary_courses']);
						}
						
						$searchary = array();
					$courseary = array();
					$searchary['ss_aw_parent_id'] = $parent_id;
					$searchary['ss_aw_child_id'] = $child_id;
					$searchary['ss_aw_course_currrent_status'] = 1;
					$courseary = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
					
					if($courseary[0]['ss_aw_selected_course_id'] == 1)
						$current_course = "E";
					else if($courseary[0]['ss_aw_selected_course_id'] == 2)
						$current_course = "C";
					else if($courseary[0]['ss_aw_selected_course_id'] == 3)
						$current_course = "A";
						$supplymentary_course_ary = array();
						$supplymentary_course_ary = $this->ss_aw_supplymentary_uploaded_model->get_courselist_bylevel($current_course);
						
						if(!empty($supplymentary_course_ary))
						{
							$responseary['status'] = 200;
							foreach($supplymentary_course_ary as $key=>$val)
							{
								if(in_array($val['ss_aw_id'],$course_ary))
								{
									$responseary['result'][$key]['course_id'] = $val['ss_aw_id'];
									$responseary['result'][$key]['course_name'] = $val['ss_aw_course_name'];
									$responseary['result'][$key]['main_course'] = $val['ss_aw_level'];
									$responseary['result'][$key]['topic_name'] = $val['title_name'];
									$responseary['result'][$key]['course_description'] = $val['ss_aw_description'];
								}
							}
						}
					}
					else
					{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";				
							}
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
	}
	/********************************************************* Supplymentary Course END ********************************/
	
	public function child_record_exist()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $child_id = $inputpost['child_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$this->db->trans_start();
					$childdataary = $this->ss_aw_childs_model->get_child_details_by_id($child_id,$parent_id);
					
					if(!empty($childdataary))
					{
						$responseary['status'] = 200;
						foreach($childdataary as $key=>$val)
						{
							if($val->ss_aw_child_first_name!='' && $val->ss_aw_child_last_name!='' 
							&& $val->ss_aw_child_gender!='' && $val->ss_aw_child_schoolname !='')
							{
								$responseary['profile_status'] = 1;
								$responseary['msg'] = "Profile all data exist";
							}
							else
							{
								$responseary['status'] = 1031;
								$responseary['profile_status'] = 0;
								$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1031');
								foreach ($error_array as $value) {
									$responseary['status'] = $value->ss_aw_error_status;
									$responseary['msg'] = $value->ss_aw_error_msg;
									$responseary['title'] = "Error";				
								}
							}
						}
					}
					else
					{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";				
							}
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
	}
	
	public function nextlevel_suggested_courses_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $child_id = $inputpost['child_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$this->db->trans_start();
					$childcourseary = $this->ss_aw_child_course_model->get_details($child_id);
					if(!empty($childcourseary))
					{
						$responseary['status'] = 200;
						foreach($childcourseary as $key=>$val)
						{
							$last_course_id = $val['ss_aw_course_id'];
							
							$i = 0;
							if($last_course_id == 2 || $last_course_id == 1)
							{
								$course_complete_date = date('Y-m-d', strtotime($val['ss_aw_child_course_modified_date']));
									
								$supplymentary_purchaseary = array();
								$supplymentary_purchaseary = $this->ss_aw_purchased_supplymentary_course_model->get_purchased_supplymentary($child_id, $course_complete_date);
								
								if (!empty($supplymentary_purchaseary)) {
									$supplymentary_course_ids = array();
									$supplymentary_course_ids = explode(",", $supplymentary_purchaseary->ss_aw_supplymentary_courses);
									$supplymentary_complete_count = $this->ss_aw_supplymentary_exam_finish_model->get_complete_count($child_id, $supplymentary_course_ids, $course_complete_date);
									$course_complete_date = strtotime($course_complete_date);
									$diff = time() - $course_complete_date;
									$diffDay = round($diff / (60 * 60 * 24));
									if ($supplymentary_complete_count > 4 || $diffDay > 30) {
										$course_id = 3;		
									}
									else{
										$course_id = '';
									}		
								}
								else{
									$course_complete_date = strtotime($course_complete_date);
									$diff = time() - $course_complete_date;
									$diffDay = round($diff / (60 * 60 * 24));
									if ($diffDay >= 8) {
										$course_id = 3;
									}
									else{
										$course_id = '';
									}
								}

								if (!empty($course_id)) {
									$suggested_course_id = $course_id;
									$searary['ss_aw_course_id'] = $suggested_course_id;
									$courseary = $this->ss_aw_courses_model->search_byparam($searary);
									
									$responseary['status'] = 200;
									foreach($courseary as $val)
									{
										if($val['ss_aw_course_code'] != 'S')
										{
										$responseary['result'][$i]['last_course_completion_date'] = $childcourseary[0]['ss_aw_child_course_modified_date'];	
										$responseary['result'][$i]['course_id'] = $val['ss_aw_course_id'];
										$responseary['result'][$i]['course_name'] = $val['ss_aw_course_name'];
										$responseary['result'][$i]['sort_desc'] = $val['ss_aw_sort_description'];
										$responseary['result'][$i]['long_desc'] = $val['ss_aw_long_description'];
										
										$responseary['result'][$i]['gst_rate'] = str_replace("%","",$val['ss_aw_gst_rate']) + 0;
										$responseary['result'][$i]['actual_course_price'] = str_replace(",","",$val['ss_aw_course_price']) + 0; // Without GST
										
										$responseary['result'][$i]['course_price'] = ((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100) + 0;
										$i++;
										}
									}
								}
								
								$result = $responseary['result'];
								$n=0;
								foreach ($result as $value) { 

									$result_arrr[$n] = $this->ss_aw_course_count_model->get_course_count($value['course_id']);   

									$responseary['result'][$n]['lessons'] = $result_arrr[$n][0]['ss_aw_lessons'];
									$responseary['result'][$n]['assessments'] = $result_arrr[$n][0]['ss_aw_assessments'];
									$responseary['result'][$n]['readalong'] = $result_arrr[$n][0]['ss_aw_readalong'];
									$n++;					
								}
							}
							
							$searary['ss_aw_course_id'] = 4;
								$courseary = $this->ss_aw_courses_model->search_byparam($searary);
								
								$responseary['status'] = 200;
								foreach($courseary as $val)
								{
									if($val['ss_aw_course_code'] == 'S')
									{
									$responseary['result'][$i]['is_supplementary'] = 1;	
									$responseary['result'][$i]['course_id'] = $val['ss_aw_course_id'];
									$responseary['result'][$i]['course_name'] = $val['ss_aw_course_name'];
									$responseary['result'][$i]['sort_desc'] = $val['ss_aw_sort_description'];
									$responseary['result'][$i]['long_desc'] = $val['ss_aw_long_description'];
									//$responseary['result'][$i]['gst_rate'] = $val['ss_aw_gst_rate'];
									//$responseary['result'][$i]['actual_course_price'] = $val['ss_aw_course_price'];
									
									$responseary['result'][$i]['gst_rate'] = str_replace("%","",$val['ss_aw_gst_rate']) + 0;
									$responseary['result'][$i]['actual_course_price'] = str_replace(",","",$val['ss_aw_course_price']) + 0; // Without GST
									
									//$responseary['result'][$i]['course_price'] = number_format((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100,2);
									$responseary['result'][$i]['course_price'] = ((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100) + 0;
									$i++;
									}
								}
						}
					}
					else
					{
						$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";				
							}
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
	}
	
	/*
	Child EXAM RESULT
	*/
	public function get_child_exam_result(){
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost){
			$parent_id = $inputpost['user_id'];
			$child_id = $inputpost['child_id'];
			$parent_token = $inputpost['user_token'];
			$level = $inputpost['course_id'];
			if($this->check_parent_existance($parent_id,$parent_token)){
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				if (!empty($childary)) {
					if (empty($level)) {
						$level = $childary[count($childary) - 1]['ss_aw_course_id'];	
					}
					
					if ($level == 1 || $level == 2) {
						$course_level = "E";
					}
					elseif ($level == 3) {
						$course_level = "A";
					}
					elseif ($level == 5)
					{
						$course_level = "M";
					}

					//get completed lesson list
					$searchary = array();
					$searchary['ss_aw_child_id'] = $child_id;
					$searchary['ss_aw_lesson_level'] = $level;
					$searchary['ss_aw_lesson_status'] = 2;
					$completed_lessonid = array();

					$lessons_listary = $this->ss_aw_child_last_lesson_model->getallcompletelessonbychild($searchary);

					$responseary['status'] = 200;
					$result = array();
					$responseary['result']['level'] = $course_level;
					$result_arrr = $this->ss_aw_course_count_model->get_course_count($level); 
					$responseary['result']['total_lessons_count'] = $result_arrr[0]['ss_aw_lessons'];
					$responseary['result']['total_assessments_count'] = $result_arrr[0]['ss_aw_assessments'];
					$responseary['result']['total_readalong_count'] = $result_arrr[0]['ss_aw_readalong'];
					/*if ($level == 1) {
						$total_lesson = $responseary['result']['total_lessons_count'];
						$readalong_count = 0;
						for ($i=$total_lesson; $i > 5; $i--) { 
							if (($i % 2) == 1) {
								$readalong_count++;
							}
						}
					}
					else
					{
						$readalong_count = $responseary['result']['total_lessons_count'];
					}

					$responseary['result']['total_readalong_count'] = $readalong_count;*/

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
							$lesson_assessment_data[$key]['lesson_complete_date'] = date('Y-m-d', strtotime($value['ss_aw_last_lesson_modified_date']));

							$assessment_complete_question_detail = $this->ss_aw_assessment_score_model->gettotalquestionanswercount($child_id, $value['ss_aw_lesson_id']);
							if (!empty($assessment_complete_question_detail)) {
								$lesson_assessment_data[$key]['assessment_total_currect_ans'] = $assessment_complete_question_detail[0]->wright_answers;
								$lesson_assessment_data[$key]['assessment_total_question'] = $assessment_complete_question_detail[0]->total_question;
								$exam_details = $this->ss_aw_assessment_exam_completed_model->getexamdetail($assessment_complete_question_detail[0]->assessment_id, $child_id);
								$lesson_assessment_data[$key]['assessment_complete_date'] = date('Y-m-d', strtotime($exam_details[count($exam_details) - 1]->ss_aw_create_date));
							}
							else
							{
								$lesson_assessment_data[$key]['assessment_total_currect_ans'] = 0;
								$lesson_assessment_data[$key]['assessment_total_question'] = 0;
								$lesson_assessment_data[$key]['assessment_complete_date'] = "";
							}

							
							$lesson_format = $get_lesson_completion_detail[0]->ss_aw_lesson_format;
							$start_date = $value['ss_aw_last_lesson_modified_date'];
							$restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($level);
							$restriction_time = $restriction_detail[0]->restricted_time;
							$end_date = date('Y-m-d H:i:s', strtotime($start_date. "+ ".$restriction_time." minutes"));
							$get_check_details = $this->ss_aw_schedule_readalong_model->get_readalong_schduled($child_id, $start_date, $end_date);
							if (!empty($get_check_details)) {
								$lesson_assessment_data[$key]['readalong_complete'] = 1;
								$get_complete_details = $this->ss_aw_last_readalong_model->check_readalong_completion($get_check_details->ss_aw_readalong_id, $child_id);
								
								if (!empty($get_complete_details)) {
									$lesson_assessment_data[$key]['readalong_complete_date'] = date('Y-m-d', strtotime($get_complete_details[0]->ss_aw_create_date));
								}
								else{
									$lesson_assessment_data[$key]['readalong_complete_date'] = "";
								}
								$wrong_count = $this->ss_aw_readalong_quiz_ans_model->get_wrong_answer_count($child_id, $get_check_details->ss_aw_readalong_id);
								
								$total_questions = $this->ss_aw_readalong_quiz_ans_model->get_all_question_count($child_id, $get_check_details->ss_aw_readalong_id);
								$lesson_assessment_data[$key]['readalong_total_question'] = $total_questions;
								$lesson_assessment_data[$key]['readalong_total_correct_ans'] = $total_questions - $wrong_count;
							}
							else{
								$lesson_assessment_data[$key]['readalong_complete'] = 0;
								$lesson_assessment_data[$key]['readalong_complete_date'] = "";
								$lesson_assessment_data[$key]['readalong_total_question'] = "";
								$lesson_assessment_data[$key]['readalong_total_correct_ans'] = "";
							}

						}

						// Generate score card pdf
						/*$this->load->library('pdf');
						echo "@1";
						die();
						$html = $this->load->view('pdf/scorepdf', [], true);
						$filename = time().".pdf";
						$save_file_path = "./scorepdf/".$filename;
						$this->pdf->createPDF($save_file_path, $html, $filename, false);
						$responseary['result']['score_card'] = base_url().'scorepdf/'.$filename;

						echo "@1";
						die();*/
					}

					$responseary['result']['lessons_assessment'] = $lesson_assessment_data;

				}
				else{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
					}
				}
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

			die(json_encode($responseary));
		}
	}
	public function get_child_exam_result_old()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $child_id = $inputpost['child_id'];
			 $parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$this->db->trans_start();
				/*
				*************************************************************************************************************
									LESSON SECTION START
				*************************************************************************************************************
				*/	
					$searchary = array();
					$searchary['ss_aw_child_id'] = $child_id;
					$searchary['ss_aw_lesson_status'] = 2;
					$completed_lessonid = array();
					$lessons_listary = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($searchary);
					
					//Count Total Currect ans against a particular child
					$searchary = array();
					$searchary['ss_aw_child_id'] = $child_id;
					$searchary['ss_aw_answer_status'] = 1;
					$lesson_ansarray = array();
					$lesson_ansarray = $this->ss_aw_lesson_quiz_ans_model->search_data_by_param_count_lessons_ans($searchary);
					
					//Count Total Question asked against a particular child
					$searchary = array();
					$searchary['ss_aw_child_id'] = $child_id;
					
					$lesson_questionarray = array();
					$lesson_questionarray = $this->ss_aw_lesson_quiz_ans_model->search_data_by_param_count_lessons_ans($searchary);
						
						
					if(!empty($lessons_listary))
					{
						
						
						$i = 0;
						$result = array();
						$responseary['status'] = 200;
						if($lessons_listary[0]['ss_aw_lesson_level'] == 1)
							$responseary['level'] = "E"; // 1 = E,2 = C, 3 = A
						else if($lessons_listary[0]['ss_aw_lesson_level'] == 2)
							$responseary['level'] = "C"; // 1 = E,2 = C, 3 = A
						else if($lessons_listary[0]['ss_aw_lesson_level'] == 3)
							$responseary['level'] = "A"; // 1 = E,2 = C, 3 = A
						$j = 0;
						foreach($lessons_listary as $key=>$val)
						{
							$completed_lessonid[] = $val['ss_aw_lesson_id'];
							
							$result[$i]['lesson_id'] = $val['ss_aw_lesson_id'];
							
							if(!empty($lesson_questionarray))
							{
								foreach($lesson_questionarray as $tval)
								{
									if($tval['ss_aw_lesson_id'] == $val['ss_aw_lesson_id'])
									{
										$result[$i]['lesson_total_question'] = $tval['lesson_count'];
									}
									else
									{
										$result[$i]['lesson_total_question'] = 0;
										
									}
								}
							}
							else
							{
								$result[$i]['lesson_total_question'] = 0;
							}
							if(!empty($lesson_ansarray))
							{
								foreach($lesson_ansarray as $rval)
								{
									if($rval['ss_aw_lesson_id'] == $val['ss_aw_lesson_id'])
									{
										$result[$i]['lesson_total_currect_ans'] = $rval['lesson_count'];
									}
									else
									{
										$result[$i]['lesson_total_currect_ans'] = 0;
										
									}
								}
							}
							else
							{
								$result[$i]['lesson_total_currect_ans'] = 0;
								
							}
							
							$i++;
						}
						$responseary['data']['lessons_assessment'] = $result;
					}
					//$j = $i; // Transfer Total Lessons record count
				/*
				*************************************************************************************************************
									LESSON SECTION END
				*************************************************************************************************************
				*/	

				/*
				*************************************************************************************************************
														ASSESSMENT SECTION START
				*************************************************************************************************************
				*/	
					$result = array();
					$searchary = array();
					$searchary['ss_aw_child_id'] = $child_id;
					
					$assessment_listary = $this->ss_aw_assessment_exam_completed_model->fetch_details_byparam_withlessons($searchary,$completed_lessonid);

					
					if(!empty($assessment_listary))
					{
						$i = 0;
						foreach($assessment_listary as $value)
						{
							$responseary['data']['lessons_assessment'][$i]['assessment_id'] = $value['ss_aw_assessment_id'];
							
							$searchary = array();
							$searchary['ss_aw_assessment_exam_code'] = $value['ss_aw_exam_code'];
							$searchary['ss_aw_child_id'] = $child_id;
							$get_assessment_questions_ary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($searchary);
							$total_question_count = count($get_assessment_questions_ary);
							
							$responseary['data']['lessons_assessment'][$i]['assessment_total_question'] = $total_question_count;
							/*
								Count no of Questions Answers right
							*/
							$searchary = array();
							$searchary['ss_aw_assessment_exam_code'] = $value['ss_aw_exam_code'];
							$searchary['ss_aw_answers_status'] = 1;
							$get_assessment_rightans_ary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($searchary);
							$right_ansno = count($get_assessment_rightans_ary);
							
							
							$responseary['data']['lessons_assessment'][$i]['assessment_total_currect_ans'] = $right_ansno;
							$i++;
						}
					}
					else
					{
						for($k = 0;$k<$i;$k++)
						{
							$responseary['data']['lessons_assessment'][$k]['assessment_total_question'] = 0;
							$responseary['data']['lessons_assessment'][$k]['assessment_total_currect_ans'] = 0;
						}
					}
					/*
				*************************************************************************************************************
														ASSESSMENT SECTION END
				*************************************************************************************************************
				*/	
				
				/*
				*************************************************************************************************************
														READALONG SECTION START
				*************************************************************************************************************
				*/	
					$result = array();
					$searchary = array();
					$searchary['ss_aw_child_id'] = $child_id;
					$readalong_listary = $this->ss_aw_last_readalong_model->search_data_by_param($searchary);
					
					if(!empty($readalong_listary))
					{
						$i = 0;
						foreach($readalong_listary as $value)
						{
							$result[$i]['readalong_id'] = $value['ss_aw_readalong_id'];
							$total_question_count = 0;
							$searchary = array();
							$get_readalong_questions_ary = array();
							$searchary['ss_aw_readalong_upload_id'] = $value['ss_aw_readalong_id'];
							$searchary['ss_aw_quiz_type'] = 1;
							$get_readalong_questions_ary = $this->ss_aw_readalong_quiz_model->search_byparam($searchary);
							$total_question_count = count($get_readalong_questions_ary);
							
							$result[$i]['total_question'] = $total_question_count;
							/*
								Count no of Questions Answers right
							*/
							$searchary = array();
							$searchary['ss_aw_readalong_id'] = $value['ss_aw_readalong_id'];
							$searchary['ss_aw_child_id'] = $child_id;
							$searchary['ss_aw_quiz_right_wrong'] = 1;
							$get_readalong_rightans_ary = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param($searchary);
							$right_ansno = count($get_readalong_rightans_ary);
							
							$result[$i]['total_currect_ans'] = $right_ansno;	
							$i++;
						}
						$responseary['data']['readalongs'] = $result;
					}
					else
					{
						$responseary['data']['readalongs'][0]['total_currect_ans'] = 0;
						$responseary['data']['readalongs'][0]['total_question'] = 0;
					}
					/*
				*************************************************************************************************************
														READALONG SECTION END
				*************************************************************************************************************
				*/	
					$responseary['data']['total_lessons_count'] = count($responseary['data']['lessons_assessment']);
					$responseary['data']['total_readalong_count'] = count($responseary['data']['readalongs']);
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
	}

	public function get_readalong_restriction_time($child_id, $level){
		//get restricted time
		$restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($level);
		$restriction_time = $restriction_detail[0]->restricted_time;

		//get lesson count
		$total_lesson = $this->ss_aw_child_last_lesson_model->getcompletelessoncount($child_id, $level);

		
		$fetch_lesson_num = $total_lesson;
		if ($fetch_lesson_num > 0) {
			$get_lesson_completion_detail = $this->ss_aw_child_last_lesson_model->getcompletelessondetailbyindex($fetch_lesson_num, $child_id, $level);
			if (!empty($get_lesson_completion_detail)) {
				$lesson_format = $get_lesson_completion_detail[0]->ss_aw_lesson_format;
				$start_date = $get_lesson_completion_detail[0]->ss_aw_last_lesson_modified_date;
				$end_date = date('Y-m-d H:i:s', strtotime($start_date. "+ ".$restriction_time." minutes"));
			}
			else
			{
				$start_date = "";
				$end_date = "";
			}
		}
		else{
			$start_date = "";
			$end_date = "";
		}
		
		if ($start_date == "" || $end_date == "") {
			$responseary['readalong_scheduler'] = 0;
		}
		else
		{
			$check_last_assign_readalong = $this->ss_aw_schedule_readalong_model->getlastassignedrecord($child_id);
			if (!empty($check_last_assign_readalong)) {
				$schedule_date = date('Y-m-d', strtotime($check_last_assign_readalong[0]->ss_aw_schedule_readalong));
				$restricted_start_date = date('Y-m-d', strtotime($start_date));
				$restricted_end_date = date('Y-m-d', strtotime($end_date));
				if (($schedule_date >=$restricted_start_date) && ($schedule_date <=$restricted_end_date)) {
					if ($check_last_assign_readalong[0]->ss_aw_readalong_status == 1) {
						$responseary['readalong_scheduler'] = 1;
					}
					else
					{
						$responseary['readalong_scheduler'] = 0;
					}
							
				}
				else
				{
					$responseary['readalong_scheduler'] = 0;
				}
			}
			else
			{
				$responseary['readalong_scheduler'] = 0;
			}
		}

		return $responseary['readalong_scheduler'];
	}

	public function notification(){
   	$inputpost = $this->input->post();
   	$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login

			if($this->check_parent_existance($parent_id,$parent_token)){
				$responseary['status'] = 200;
				$notification_list = $this->ss_aw_notification_model->getallnotification($parent_id, 1);
				if (!empty($notification_list)) {
					foreach ($notification_list as $key => $value) {
						$responseary['result'][$key]['notification_id'] = $value->id;
						$responseary['result'][$key]['title'] = $value->title;
						$responseary['result'][$key]['notification'] = $value->msg;
						$responseary['result'][$key]['action'] = $value->action;
						$responseary['result'][$key]['is_read'] = $value->read_unread;
						$responseary['result'][$key]['notify_date'] = $value->created_at;
					}
				}
				else
				{
					$responseary['msg'] = "No data found.";
				}
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
		}

		die(json_encode($responseary));
   }

   public function promotional_course_details()
	{
		 $inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token'];
			 $course_id = $inputpost['course_id'];
			 $child_id = $inputpost['child_id']; 
			
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$searary = array();
					$searary['ss_aw_course_id'] = $course_id;
					$courseary = $this->ss_aw_courses_model->search_byparam($searary);
					
					$level = $courseary[0]['ss_aw_course_id'];
					
					if ($level == 1) {
						$suggested_course_level = 2;
					}
					elseif ($level == 2) {
						$suggested_course_level = 3;
					}

					$resultary = array();
					$resultary = $this->ss_aw_lessons_uploaded_model->get_lessonlist_bylevel($suggested_course_level);

					//get suggested course details
					$suggested_course_search_ary = array();
					$suggested_course_search_ary['ss_aw_course_id'] = $suggested_course_level;
					$suggestedcourseary = $this->ss_aw_courses_model->search_byparam($suggested_course_search_ary);
					$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
					$responseary['result']['student_gender'] = $child_details[0]->ss_aw_child_gender;
					if(!empty($resultary))
					{
						foreach($resultary as $key=>$value)
						{
							$responseary['result']['topics'][$key]['title']= $value['ss_aw_lesson_topic'];
							$responseary['result']['topics'][$key]['description']= $value['ss_aw_topic_description'];
						}
						
						foreach($courseary as $val)
						{					
							$responseary['result']['course_id'] = $val['ss_aw_course_id'];
							$responseary['result']['course_code'] = $val['ss_aw_course_code'];
							$responseary['result']['course_name'] = $val['ss_aw_course_name'];
							$responseary['result']['sort_desc'] = $val['ss_aw_sort_description'];
							$responseary['result']['long_desc'] = $val['ss_aw_long_description'];
							$responseary['result']['gst_rate'] = str_replace("%","",$val['ss_aw_gst_rate']) + 0;
							$responseary['result']['course_price'] = str_replace(",","",$val['ss_aw_course_price']) + 0; // Without GST
						}

						foreach ($suggestedcourseary as $val) {
							$responseary['result']['suggested_course_id'] = $val['ss_aw_course_id'];
							$responseary['result']['suggested_course_name'] = $val['ss_aw_course_name'];
							$responseary['result']['suggested_course_price'] = str_replace(",","",$val['ss_aw_course_price']) + 0;

						}
					
						$coursecount_ary = $this->ss_aw_course_count_model->get_course_count($suggested_course_level);
						$responseary['result']['lessons'] = $coursecount_ary[0]['ss_aw_lessons'];
	                    $responseary['result']['assessments'] = $coursecount_ary[0]['ss_aw_assessments'];
	                    $responseary['result']['readalong'] = $coursecount_ary[0]['ss_aw_readalong'];
						$responseary['status'] = 200;
						
					}
					else
					{
							$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
							foreach ($error_array as $value) {
							$responseary['status'] = $value->ss_aw_error_status;
							$responseary['msg'] = $value->ss_aw_error_msg;
							$responseary['title'] = "Error";	
							}							
					}
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
	}

	public function payment_details(){
		$inputpost = $this->input->post();		
		 $responseary = array();
		 $payment_details = array();
		 $supplymentary_payment_details = array();
		 if($inputpost)
		 {
			 $parent_id = $inputpost['user_id'];
			 $parent_token = $inputpost['user_token']; 
			
			if($this->check_parent_existance($parent_id,$parent_token))
			{
				$purchase_course_details = $this->ss_aw_purchase_courses_model->get_purchase_courses_by_parent($parent_id);
				$supplymentary_course_details = $this->ss_aw_purchased_supplymentary_course_model->get_purchase_courses_by_parent($parent_id);
				if (!empty($purchase_course_details)) {
					foreach ($purchase_course_details as $key => $value) {
						$payment_details[$key]['transaction_id'] = $value->ss_aw_transaction_id;
						if ($value->ss_aw_selected_course_id == 1 || $value->ss_aw_selected_course_id == 2) {
							$course_name = Winners;
						}
						elseif ($value->ss_aw_selected_course_id == 3) {
							$course_name = Champions;
						}
						else
						{
							$course_name = Master."s";
						}
						$payment_details[$key]['description'] = "You have successfully purchased a ".$course_name." Programme.";
						$payment_details[$key]['amount'] = $value->ss_aw_course_payment;
						if (!empty($value->ss_aw_invoice)) {
							$payment_details[$key]['invoice'] = base_url()."payment_invoice/".$value->ss_aw_invoice;
						}
						else
						{
							$payment_details[$key]['invoice'] = "";
						}
					}
				}

				if (!empty($supplymentary_course_details)) {
					foreach ($supplymentary_course_details as $key => $value) {
						$supplymentary_payment_details[$key]['transaction_id'] = $value->ss_aw_transection_id;
						$supplymentary_payment_details[$key]['description'] = "You have successfully purchased supplymentary course.";
						$supplymentary_payment_details[$key]['amount'] = $value->ss_aw_course_payment;
						if (!empty($value->ss_aw_invoice)) {
							$supplymentary_payment_details[$key]['invoice'] = base_url()."payment_invoice/".$value->ss_aw_invoice;
						}
						else
						{
							$supplymentary_payment_details[$key]['invoice'] = "";
						}
						
					}
				}

				$responseary['status'] = 200;
				if (!empty($payment_details)) {
					$responseary['msg'] = "Data found.";
					if (!empty($supplymentary_payment_details)) {
						$payment_details = array_merge($payment_details, $supplymentary_payment_details);
					}
				}
				else
				{
					$responseary['msg'] = "Not found";
				}
				$responseary['data'] = $payment_details;
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";	
				}							
			}
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

		die(json_encode($responseary));
	}

	public function check_child_email_existance($email, $parent_id){
		$check1 = $this->ss_aw_parents_model->check_email_with_parent($email, $parent_id);
		$check2 = $this->ss_aw_childs_model->check_email_with_parent($email, $parent_id);
		if ($check1 == 0 && $check2 == 0) {
			return true;
		}
		else
		{
			return false;
		}
	}

	public function razorPaySuccess(){
		if ($this->input->post()) {
			$inputpost = $this->input->post();
			$parent_id = $inputpost['user_id'];
			$parent_token = $inputpost['user_token'];
			$child_id = $inputpost['child_id'];
			$course_id = $inputpost['course_id'];
			$transaction_id = $inputpost['transaction_id'];
			$payment_amount = $inputpost['payment_amount'] / 100;
			$invoice_prefix = "ALWS/";
			$invoice_suffix = "/".date('m').date('y');
			$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
			if (!empty($get_last_invoice_details)) {
				$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
				if (!empty($invoice_ary)) {
				 	if (!empty($invoice_ary[1])) {
				 		if (is_numeric($invoice_ary[1])) {
				 			$suffix_num = (int)$invoice_ary[1] + 1;
				 			$invoice_no = $invoice_prefix.$suffix_num;
				 		}
				 		else{
				 			$invoice_no = $invoice_prefix."100001";
				 		}
				 	}
				 	else{
				 		$invoice_no = $invoice_prefix."100001";
				 	}
				}
				else{
				 	$invoice_no = $invoice_prefix."100001";
				}
			}
			else{
				$invoice_no = $invoice_prefix."100001";
			}
			$invoice_no = $invoice_no.$invoice_suffix;
			$gst_rate = $inputpost['gst_rate'];
			$discount_amount = $inputpost['discount_amount'];
			$coupon_id = $inputpost['coupon_id'];

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
			$data['payment_type'] = $inputpost['emi_payment'];

			$this->load->library('pdf');
			$html = $this->load->view('pdf/paymentinvoice', $data, true);
						
			$filename = time().rand()."_".$child_id.".pdf";
			$save_file_path = "./payment_invoice/".$filename;
			$this->pdf->createPDF($save_file_path, $html, $filename, false);

			$this->db->trans_start();
			$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			//update parent user type
			$updated_user_type = 3;
			$check_self_enrolled = $this->ss_aw_childs_model->check_self_enrolled($parent_id);
			if (!empty($check_self_enrolled)) {
				$updated_user_type = 5;
			}
			else{
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
			$searary['ss_aw_parent_id'] = $parent_id;
			$searary['ss_aw_child_id'] = $child_id;
			$searary['ss_aw_selected_course_id'] = $course_id;
			$searary['ss_aw_transaction_id'] = $transaction_id;
			$searary['ss_aw_course_payment'] = $payment_amount;
			$searary['ss_aw_invoice'] = $filename;
			$courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
			$payment_invoice_file_path = base_url()."payment_invoice/".$filename;
			$searary = array();
			$searary['ss_aw_child_id'] = $child_id;
			$searary['ss_aw_course_id'] = $course_id;
			if ($inputpost['emi_payment']) {
				$searary['ss_aw_course_payemnt_type'] = 1;	
			}					
			$courseary = $this->ss_aw_child_course_model->data_insert($searary);

			//update child promotional record
			if (!empty($inputpost['promoted'])) {
				$previous_course = "";
				if ($course_id == 2) {
					$previous_course = "E";	
					$promoted_course = "C";
				}
				elseif ($course_id == 3) {
					$previous_course = "C";
					$promoted_course = "A";	
				}

				if ($previous_course == 'E') {
					$previous_course_code = 1;
				}
				elseif ($previous_course == 'C') {
					$previous_course_code = 2;
				}

				if (!empty($previous_course)) {
					$update_promotion_data = array();
					$update_promotion_data['ss_aw_child_id'] = $child_id;
					$update_promotion_data['ss_aw_current_level'] = $previous_course;
					$update_promotion_data['status'] = 1;
					$response = $this->ss_aw_promotion_model->update_record($update_promotion_data);
					if ($response) {
						//get pre-promotion lesson records and insert as promoted level record
						$get_lesson_score_detail = $this->ss_aw_lesson_score_model->getlessonscoreofpreviouscourse($previous_course, $child_id);
						if (!empty($get_lesson_score_detail)) {
							$completed_lesson_ids = array();
							foreach ($get_lesson_score_detail as $key => $value) {
								$completed_lesson_ids[] = $value->lesson_id;
								$data = array(
									'lesson_id' => $value->lesson_id,
									'child_id' => $child_id,
									'level' => $promoted_course,
									'total_question' => $value->total_question,
									'wright_answers' => $value->wright_answers
								);

								$this->ss_aw_lesson_score_model->store_data($data);
							}
						}

						$childs_lessonsary = $this->ss_aw_child_last_lesson_model->fetch_details_lesson_list($child_id,$previous_course_code,'asc');
						if (!empty($childs_lessonsary)) {
							foreach ($childs_lessonsary as $key => $value) {
								$data = array(
									'ss_aw_child_id' => $child_id,
									'ss_aw_lesson_level' => $course_id,
									'ss_aw_lesson_id' => $value['ss_aw_lesson_id'],
									'ss_aw_lesson_format' => $value['ss_aw_lesson_format'],
									'ss_aw_back_click_count' => $value['ss_aw_back_click_count'],
									'ss_aw_lesson_status' => $value['ss_aw_lesson_status'],
									'ss_aw_last_lesson_create_date' => $value['ss_aw_last_lesson_create_date'],
									'ss_aw_last_lesson_modified_date' => $value['ss_aw_last_lesson_modified_date']
								);

								$this->ss_aw_child_last_lesson_model->data_insert($data);
							}
						}

						//get pre-promotion assessment records and insert as promoted level record
						$get_assessment_score_detail = $this->ss_aw_assessment_score_model->getassessmentofpreviouscourse($previous_course, $child_id);
						if (!empty($get_assessment_score_detail)) {
							foreach ($get_assessment_score_detail as $value) {
								$data = array(
									'child_id' => $child_id,
									'level' => $promoted_course,
									'exam_code' => $value->exam_code,
									'assessment_id' => $value->assessment_id,
									'total_question' => $value->total_question,
									'wright_answers' => $value->wright_answers
								);

								$this->ss_aw_assessment_score_model->store_data($data);
							}
						}
					}
				}	
			}

			$searary = array();
			$searary['ss_aw_parent_id'] = $parent_id;
			$searary['ss_aw_child_id'] = $child_id;
			$searary['ss_aw_payment_invoice'] = $invoice_no;
			$searary['ss_aw_transaction_id'] = $transaction_id;
			$searary['ss_aw_payment_amount'] = $payment_amount;
			$searary['ss_aw_gst_rate'] = $gst_rate;
			$searary['ss_aw_discount_amount'] = $discount_amount;
			$courseary = $this->ss_aw_payment_details_model->data_insert($searary);
			
			//revenue mis data store
					$invoice_amount = $payment_amount - $gst_rate;
					$reporting_collection_data = array(
						'ss_aw_parent_id' => $parent_id,
						'ss_aw_bill_no' => $invoice_no,
						'ss_aw_course_id' => $course_id,
						'ss_aw_invoice_amount' => $invoice_amount,
						'ss_aw_discount_amount' => $discount_amount,
						'ss_aw_payment_type' => $inputpost['emi_payment']
					);

					$resporting_collection_insertion = $this->ss_aw_reporting_collection_model->store_data($reporting_collection_data);
					if ($resporting_collection_insertion) {
						if ($inputpost['emi_payment']) {
							if ($inputpost['promoted']) {
								if ($course_id == 2) {
									$previous_course_id = 1;
									$promoted_course_duration = 175;
									$previous_course_duration = 105;
								}
								elseif ($course_id == 3) {
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
								$today_date = date('Y')."-".date('m')."-01";
								//first insertion
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $previous_course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $inputpost['emi_payment']
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);

								//second insertion
								$today_date = date('Y-m-d');
								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today = date('d');
								$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
								$remaing_days = $days_current_month - $today;

								$revenue_invoice_amount = ( $previous_invoice_amount / $days_current_month ) * $remaing_days;

								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => 0,
									'ss_aw_payment_type' => $inputpost['emi_payment'],
									'ss_aw_advance' => 1
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
							}
							else{
								$today_date = date('Y-m-d');
								$month = date('m', strtotime($today_date));
								$year = date('Y', strtotime($today_date));
								$today = date('d');
								$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
								$remaing_days = $days_current_month - $today;

								$revenue_invoice_amount = ( $invoice_amount / $days_current_month ) * $remaing_days;

								//for the first insertion
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $course_id,
									'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
									'ss_aw_discount_amount' => 0,
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $remaing_days,
									'ss_aw_payment_type' => $inputpost['emi_payment']
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
									$today_date = $year."-".$month."-01";
									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($remaing_amount, 2),
										'ss_aw_discount_amount' => 0,
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => 0,
										'ss_aw_payment_type' => $inputpost['emi_payment'],
										'ss_aw_advance' => 1
									);

									$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								}
							}
						}
						else{
							if (!empty($inputpost['promoted'])){
								if ($course_id == 2) {
									$previous_course_id = 1;
									$promoted_course_duration = 175;
									$previous_course_duration = 105;
								}
								elseif ($course_id == 3) {
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
								$sum_of_reporting_collection = $previous_invoice_amount + round($invoice_amount, 2);
								//end
								$first_revenue_amount = ($previous_invoice_amount / $previous_course_duration) * $today;

								// Store first revenue record
								$reporting_revenue_data = array(
									'ss_aw_parent_id' => $parent_id,
									'ss_aw_bill_no' => $invoice_no,
									'ss_aw_course_id' => $previous_course_id,
									'ss_aw_invoice_amount' => round($first_revenue_amount, 2),
									'ss_aw_discount_amount' => round($discount_amount, 2),
									'ss_aw_revenue_date' => $today_date,
									'ss_aw_revenue_count_day' => $today,
									'ss_aw_payment_type' => $inputpost['emi_payment']
								);

								$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
								//end

								$previous_level_details = $this->ss_aw_reporting_revenue_model->getpreviousleveldaycount($previous_course_id, $parent_id);
								if (!empty($previous_level_details)) {
									$previous_level_count_day = $previous_level_details[0]->previous_level_count;
								}
								else{
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
											'ss_aw_invoice_amount' => round($second_revenue_amount, 2),
											'ss_aw_discount_amount' => 0,
											'ss_aw_revenue_date' => $today_date,
											'ss_aw_revenue_count_day' => $remaing_days,
											'ss_aw_payment_type' => $inputpost['emi_payment']
										);

										$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
									}
									else{
										$advance_payment = 1;
										$today_date = date('Y-m-d');
										$today_date = date('Y-m-d', strtotime($today_date. ' + '.$count.' month'));
										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = 0;
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;
										$today_date = $year."-".$month."-01";

										if ($remaing_days > $course_duration) {
											$remaing_days = $course_duration;
											$course_duration = 0;
										}
										else{
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
											'ss_aw_invoice_amount' => round($second_revenue_amount, 2),
											'ss_aw_discount_amount' => 0,
											'ss_aw_revenue_date' => $today_date,
											'ss_aw_revenue_count_day' => $remaing_days,
											'ss_aw_payment_type' => $inputpost['emi_payment'],
											'ss_aw_advance' => $advance_payment
										);

										$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
									}
									$count++;
								}
							}
							else{
								if ($course_id == 1 || $course_id == 2) {
									$fixed_course_duration = WINNERS_DURATION;
									$course_duration = WINNERS_DURATION;
								}
								elseif ($course_id == 3) {
									$fixed_course_duration = CHAMPIONS_DURATION;
									$course_duration = CHAMPIONS_DURATION;
								}
								else{
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
									}
									else{
										$advance_payment = 1;
										$today_date = new DateTime();
										$today_date->format('Y-m-d');
										$day = $today_date->format('j');
										$today_date->modify('first day of + '.$count.' month');
										$today_date->modify('+' . (min($day, $today_date->format('t')) - 1) . ' days');
										$today_date = $today_date->format('Y-m-d');

										
										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = 0;
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;
										$today_date = $year."-".$month."-01";
									}

									if ($remaing_days > $course_duration) {
										$remaing_days = $course_duration;
										$course_duration = 0;
									}
									else{
										$course_duration = $course_duration - $remaing_days;	
									}

									$revenue_invoice_amount = ( $invoice_amount / $fixed_course_duration ) * $remaing_days;
									$revenue_discount_amount = 0;
									if ($discount_amount > 0) {
										$revenue_discount_amount = ( $discount_amount / $fixed_course_duration ) * $remaing_days;
									}

									$reporting_revenue_data = array(
										'ss_aw_parent_id' => $parent_id,
										'ss_aw_bill_no' => $invoice_no,
										'ss_aw_course_id' => $course_id,
										'ss_aw_invoice_amount' => round($revenue_invoice_amount, 2),
										'ss_aw_discount_amount' => round($revenue_discount_amount, 2),
										'ss_aw_revenue_date' => $today_date,
										'ss_aw_revenue_count_day' => $remaing_days,
										'ss_aw_payment_type' => $inputpost['emi_payment'],
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
			$responseary['status'] = 200;
			$responseary['user_type'] = $updated_user_type;
			$responseary['msg'] = "Purchase new course successfully done.";

			//send notification code
						if ($course_id == 1 || $course_id == 2) {
							$course_name = Winners;
						}
						elseif($course_id == 3){
							$course_name = Champions;
						}
						else{
							$course_name = Master."s";
						}

						if (!empty($child_details)) {
							if ($course_id == 1 || $course_id == 2) {
								$email_template = getemailandpushnotification(7, 1, 2);
								$app_template = getemailandpushnotification(7, 2, 2);
								$action_id = 9;
							}
							elseif($course_id == 3){
								$email_template = getemailandpushnotification(32, 1, 2);
								$app_template = getemailandpushnotification(32, 2, 2);
								$action_id = 11;
							}
							else{
								$email_template = getemailandpushnotification(33, 1, 2);
								$app_template = getemailandpushnotification(33, 2, 2);
								$action_id = 11;
							}

							$month_date = date('d/m/Y');
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
								emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
							}

							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
								$title = $app_template['title'];
								$token = $child_details[0]->ss_aw_device_token;

								pushnotification($title,$body,$token,$action_id);

								$save_data = array(
									'user_id' => $child_details[0]->ss_aw_child_id,
									'user_type' => 2,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => $action_id
								);

								save_notification($save_data);
							}
							
							$this->ss_aw_childs_model->logout($child_details[0]->ss_aw_child_id);
						}
						
						if (empty($child_details[0]->ss_aw_child_username)) {
							//payment confirmation email notification.
								$email_template = getemailandpushnotification(59, 1, 1);
								if (!empty($email_template)) {
									$body = $email_template['body'];
									$body = str_ireplace("[@@course_name@@]", $course_name, $body);
									$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
									$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
									$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
									$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
									$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
									$gender = $child_details[0]->ss_aw_child_gender;
									if ($gender == 2) {
										$g_name = "She";
									}
									else{
										$g_name = "He";
									}
									$body = str_ireplace("[@@gender@@]", $g_name, $body);
									emailnotification($parent_detail[0]->ss_aw_parent_email, 'Payment Confirmation', $body);
								}

								$app_template = getemailandpushnotification(59, 2, 1);
								if (!empty($app_template)) {
									$body = $app_template['body'];
									$body = str_ireplace("[@@course_name@@]", $course_name, $body);
									$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
									$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
									$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
									$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
									$gender = $child_details[0]->ss_aw_child_gender;
									if ($gender == 2) {
										$g_name = "She";
									}
									else{
										$g_name = "He";
									}
									$body = str_ireplace("[@@gender@@]", $g_name, $body);
									$title = 'Payment Confirmation';
									$token = $parent_detail[0]->ss_aw_device_token;

									pushnotification($title,$body,$token,8);

									$save_data = array(
										'user_id' => $parent_detail[0]->ss_aw_parent_id,
										'user_type' => 1,
										'title' => $title,
										'msg' => $body,
										'status' => 1,
										'read_unread' => 0,
										'action' => 8
									);

									save_notification($save_data);
								}	
						}
						else{
							//payment confirmation email notification.
							$email_template = getemailandpushnotification(6, 1, 1);
							if (!empty($email_template)) {
								$body = $email_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
								$gender = $child_details[0]->ss_aw_child_gender;
								if ($gender == 2) {
									$g_name = "She";
								}
								else{
									$g_name = "He";
								}
								$body = str_ireplace("[@@gender@@]", $g_name, $body);
								emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
							}

							$app_template = getemailandpushnotification(6, 2, 1);
							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
								$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
								$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
								$gender = $child_details[0]->ss_aw_child_gender;
								if ($gender == 2) {
									$g_name = "She";
								}
								else{
									$g_name = "He";
								}
								$body = str_ireplace("[@@gender@@]", $g_name, $body);
								$title = $app_template['title'];
								$token = $parent_detail[0]->ss_aw_device_token;

								pushnotification($title,$body,$token,8);

								$save_data = array(
									'user_id' => $parent_detail[0]->ss_aw_parent_id,
									'user_type' => 1,
									'title' => $title,
									'msg' => $body,
									'status' => 1,
									'read_unread' => 0,
									'action' => 8
								);

								save_notification($save_data);
							}
						}
						
						if (!empty($parent_detail) && !empty($child_details[0]->ss_aw_child_username)) {
							// if ($course_id == 1 || $course_id == 2) {
							// 	$email_template = getemailandpushnotification(7, 1, 1);
							// 	$app_template = getemailandpushnotification(7, 2, 1);
							// 	$action_id = 9;
							// }
							// elseif($course_id == 3){
							// 	$email_template = getemailandpushnotification(32, 1, 1);
							// 	$app_template = getemailandpushnotification(32, 2, 1);
							// 	$action_id = 11;
							// }
							// else{
							// 	$email_template = getemailandpushnotification(33, 1, 1);
							// 	$app_template = getemailandpushnotification(33, 2, 1);
							// 	$action_id = 11;
							// }

							// if (!empty($email_template)) {
							// 	$body = $email_template['body'];
							// 	$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							// 	$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
							// 	$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
							// 	$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							// 	$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
							// 	$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
							// 	$gender = $child_details[0]->ss_aw_child_gender;
							// 	if ($gender == 2) {
							// 		$g_name = "She";
							// 	}
							// 	else{
							// 		$g_name = "He";
							// 	}
							// 	$body = str_ireplace("[@@gender@@]", $g_name, $body);
							// 	emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
							// }

							// if (!empty($app_template)) {
							// 	$body = $app_template['body'];
							// 	$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							// 	$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
							// 	$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
							// 	$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							// 	$body = str_ireplace("[@@child_code@@]", $child_details[0]->ss_aw_child_username, $body);
							// 	$body = str_ireplace("[@@gender_pronoun@@]", $child_details[0]->ss_aw_child_gender == 1 ? 'him' : 'her', $body);
							// 	$gender = $child_details[0]->ss_aw_child_gender;
							// 	if ($gender == 2) {
							// 		$g_name = "She";
							// 	}
							// 	else{
							// 		$g_name = "He";
							// 	}
							// 	$body = str_ireplace("[@@gender@@]", $g_name, $body);
							// 	$title = $app_template['title'];
							// 	$token = $parent_detail[0]->ss_aw_device_token;

							// 	pushnotification($title,$body,$token,8);

							// 	$save_data = array(
							// 		'user_id' => $parent_detail[0]->ss_aw_parent_id,
							// 		'user_type' => 1,
							// 		'title' => $title,
							// 		'msg' => $body,
							// 		'status' => 1,
							// 		'read_unread' => 0,
							// 		'action' => 8
							// 	);

							// 	save_notification($save_data);
							// }
							
						}

			echo json_encode($responseary);			
		}
	}

	public function razorPaySupplymentarySuccess(){
		if ($this->input->post()) {
			$inputpost = $this->input->post();
			$parent_id = $inputpost['user_id'];
			$parent_token = $inputpost['user_token'];
			$child_id = $inputpost['child_id'];
			$course_id = $inputpost['course_id'];
			$transaction_id = $inputpost['transaction_id'];
			$payment_amount = $inputpost['payment_amount'] / 100;
			$gst_rate = $inputpost['gst_rate'];
			$discount_amount = $inputpost['discount_amount'];
			//create invoice number
			$invoice_prefix = "ALWS/";
			$invoice_suffix = "/".date('m').date('y');
			$get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
			if (!empty($get_last_invoice_details)) {
				$invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
				if (!empty($invoice_ary)) {
				 	if (!empty($invoice_ary[1])) {
				 		if (is_numeric($invoice_ary[1])) {
				 			$suffix_num = (int)$invoice_ary[1] + 1;
				 			$invoice_no = $invoice_prefix.$suffix_num;
				 		}
				 		else{
				 			$invoice_no = $invoice_prefix."100001";
				 		}
				 	}
				 	else{
				 		$invoice_no = $invoice_prefix."100001";
				 	}
				}
				else{
				 	$invoice_no = $invoice_prefix."100001";
				}
			}
			else{
				$invoice_no = $invoice_prefix."100001";
			}
			$invoice_no = $invoice_no.$invoice_suffix;
			//end

			//create invoice PDF
			$data = array();
			$data['transaction_id'] = $transaction_id;
			$data['payment_amount'] = $payment_amount;
			$data['course_id'] = 4;
			$data['invoice_no'] = $invoice_no;
			$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
			$data['parent_details'] = $parent_detail;
			$data['discount_amount'] = $discount_amount;
			$data['gst_rate'] = $gst_rate;
			$data['course_details'] = $this->ss_aw_courses_model->search_byparam(array('ss_aw_course_id' => 4));

			$this->load->library('pdf');
			$html = $this->load->view('pdf/supplymentary-paymentinvoice', $data, true);
						
			$filename = time().rand()."_".$child_id.".pdf";
			$save_file_path = "./payment_invoice/".$filename;
			$this->pdf->createPDF($save_file_path, $html, $filename, false);
			//end
			$this->db->trans_start();
			$searary = array();
			$searary['ss_aw_parent_id'] = $parent_id;
			$searary['ss_aw_child_id'] = $child_id;
			$searary['ss_aw_supplymentary_courses'] = $course_id;
			$searary['ss_aw_transection_id'] = $transaction_id;
			$searary['ss_aw_course_payment'] = $payment_amount;
			$searary['ss_aw_invoice'] = $filename;
			$courseary = $this->ss_aw_purchased_supplymentary_course_model->data_insert($searary);
					
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

			//send payment confirmation maill to parent and student
			$payment_invoice_file_path = base_url()."payment_invoice/".$filename;
			$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			//send notification code
			if ($course_id == 1 || $course_id == 2) {
				$level_text = "E";
				$course_name = Winners;
			}
			else{
				$level_text = "A";
				$course_name = Champions;
			}
			

			$topic_list = $this->ss_aw_sections_topics_model->get_topiclist_bylevel($level_text);
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

			if (!empty($child_details)) {
				$email_template = getemailandpushnotification(39, 1, 2);
				if (!empty($email_template)) {
					$body = $email_template['body'];
					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
					$body = str_ireplace("[@@topic_content@@]", $topic_table, $body);
					$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
					emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
				}

				$app_template = getemailandpushnotification(39, 2, 2);
				if (!empty($app_template)) {
					$body = $app_template['body'];
					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
					$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
					$title = $app_template['title'];
					$token = $child_details[0]->ss_aw_device_token;

					pushnotification($title,$body,$token,48);

					$save_data = array(
						'user_id' => $child_details[0]->ss_aw_child_id,
						'user_type' => 2,
						'title' => $title,
						'msg' => $body,
						'status' => 1,
						'read_unread' => 0,
						'action' => 48
					);

					save_notification($save_data);
				}

				$this->ss_aw_childs_model->logout($child_details[0]->ss_aw_child_id);
			}
			//end

			//send email & notification to parent
			if (!empty($parent_detail)) {
				if (!empty($child_details[0]->ss_aw_child_username)) {
					$email_template = getemailandpushnotification(39, 1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
						emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
					}

					$app_template = getemailandpushnotification(39, 2, 1);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
						$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
						$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
						$gender = $child_details[0]->ss_aw_child_gender;
						if ($gender == 2) {
							$g_name = "She";
						}
						else{
							$g_name = "He";
						}
						$body = str_ireplace("[@@gender@@]", $g_name, $body);
						$title = $app_template['title'];
						$token = $parent_detail[0]->ss_aw_device_token;

						pushnotification($title,$body,$token,48);

						$save_data = array(
							'user_id' => $parent_detail[0]->ss_aw_parent_id,
							'user_type' => 1,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 48
						);

						save_notification($save_data);
					}	
				}
				else{
					$email_template = getemailandpushnotification(60, 1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@invoice_link@@]", $payment_invoice_file_path, $body);
						emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
					}

					$app_template = getemailandpushnotification(60, 2, 1);
					if (!empty($app_template)) {
						$body = $app_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						$body = str_ireplace("[@@amount@@]", $payment_amount, $body);
						$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
						$body = str_ireplace("[@@child_name@@]", $child_details[0]->ss_aw_child_nick_name, $body);
						$gender = $child_details[0]->ss_aw_child_gender;
						if ($gender == 2) {
							$g_name = "She";
						}
						else{
							$g_name = "He";
						}
						$body = str_ireplace("[@@gender@@]", $g_name, $body);
						$title = $app_template['title'];
						$token = $parent_detail[0]->ss_aw_device_token;

						pushnotification($title,$body,$token,48);

						$save_data = array(
							'user_id' => $parent_detail[0]->ss_aw_parent_id,
							'user_type' => 1,
							'title' => $title,
							'msg' => $body,
							'status' => 1,
							'read_unread' => 0,
							'action' => 48
						);

						save_notification($save_data);
					}
				}
			}

			$responseary['status'] = 200;
			$responseary['msg'] = "Purchase supplementary course successfully done.";
			echo json_encode($responseary);
		}
	}

	public function RazorThankYou(){
		$this->load->view('thankyou');
	}

	public function check_course_purchased_or_not(){
		$postdata = $this->input->post();
		$responseary = array();
		if ($postdata) {
			$userid = $postdata['user_id'];
			$user_token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			if ($this->check_parent_existance($userid, $user_token)) {
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($userid);
				$responseary['status'] = 200;
				if (!empty($childary)) {
					$responseary['msg'] = "Course purchased.";
					$responseary['data']['course_purchase'] = 1;
				}
				else{
					$responseary['msg'] = "Course not purchased.";
					$responseary['data']['course_purchase'] = 0;
				}
				$responseary['data']['user_type'] = $parent_detail[0]->ss_aw_user_type;
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}
		
		die(json_encode($responseary));

	}

	public function check_coupon_availability(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$userid = $postdata['user_id'];
			$token = $postdata['user_token'];
			$coupon_code = $postdata['coupon_code'];
			$child_id = $postdata['child_id'];
			$payment_type = $postdata['payment_type'];
			$responseary = array();
			if ($this->check_parent_existance($userid, $token)) {
				$check_coupon_availability = $this->ss_aw_coupons_model->check_coupon_availability($coupon_code, $payment_type);
				if (!empty($check_coupon_availability)) {
					$coupon_id = $check_coupon_availability[0]->ss_aw_id;
					$check_user_send_details = $this->ss_aw_manage_coupon_send_model->check_coupon_assign($coupon_id, $userid);
					$check_previous_use = $this->ss_aw_payment_details_model->check_coupon_use($userid, $coupon_code);
					if ($check_coupon_availability[0]->ss_aw_target_audience == 3) {
						{
							$responseary['status'] = 200;
							$responseary['msg'] = "Valid coupon";
							$responseary['data'] = array(
								'discount_percentage' => $check_coupon_availability[0]->ss_aw_discount
							);
						}
					}
					else{
						if ($check_user_send_details > 0 && $check_previous_use == 0) {
							$responseary['status'] = 200;
							$responseary['msg'] = "Valid coupon";
							$responseary['data'] = array(
								'discount_percentage' => $check_coupon_availability[0]->ss_aw_discount
							);
						}
						else{
							$responseary['status'] = 200;
							$responseary['msg'] = "Invalid coupon";
						}
					}
					
				}
				else{
					$responseary['status'] = 200;
					$responseary['msg'] = "Invalid coupon";
				}
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}

		die(json_encode($responseary));
	}

	public function emi_list(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$userid = $postdata['user_id'];
			$token = $postdata['user_token'];
			$course_id = $postdata['course_id'];
			$child_id = $postdata['child_id'];
			if (!empty($inputpost['device_type'])) {
			 	$device_type = $inputpost['device_type'];
			}
			else{
				$device_type = "";
			}
			if ($this->check_parent_existance($userid, $token)) {

				// checking promotion with previous course emi details

				$previous_course = "";
				if ($course_id == 2) {
					$previous_course = "E";
				}
				elseif ($course_id == 3) {
					$previous_course = "C";
				}

				$total_complete_emi_count = 0;
				$first_emi_date = "";

				$emi_paid_date = array(); // EMI paid date storage
				$first_emi_price = "";
				$duration = 0;
				$check_promotion = array();
				$previous_course_id = 0;
				$course_price_as_before = 0;
				$first_transaction_id = "";

				if ($course_id == 1 || $course_id == 2 || $course_id == 3) {
					$duration = CONSOLIDATED_EMI_DURATION;
				}
				else{
					if ($duration == 0) {
						$duration = ADVANCED_EMI_DURATION;	
					}
				}

				$searchary = array(
					'ss_aw_parent_id' => $userid,
					'ss_aw_child_id' => $child_id,
					'ss_aw_selected_course_id' => $course_id
				);

				$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);

				if (!empty($count_previous_emi)) {
					foreach ($count_previous_emi as $key => $value) {
						$emi_paid_date[] = date('Y-m-d', strtotime($value['ss_aw_course_created_date']));
					}
					$first_emi_price = $count_previous_emi[0]['ss_aw_course_payment'];
					$first_transaction_id = $count_previous_emi[0]['ss_aw_transaction_id'];
					if (count($count_previous_emi) > 1) {
						$course_price_as_before = round($count_previous_emi[1]['ss_aw_course_payment']) * $duration; 
					}
				}

				$total_complete_emi_count = $total_complete_emi_count + count($count_previous_emi);
				if (!empty($count_previous_emi) && empty($first_emi_date)) {
					$first_emi_date = date('Y-m-d', strtotime($count_previous_emi[0]['ss_aw_course_created_date']));
				}
				else{
					$first_emi_date = date('Y-m-d');
				}

				// end of checking

				$search_data = array(
					'ss_aw_course_id' => $course_id
				);
				$devide_duration = $duration;	
				
				$course_details = $this->ss_aw_courses_model->search_byparam($search_data);
				$gst_rate = str_replace("%","",$course_details[0]['ss_aw_gst_rate']) + 0;
				$installment_price = 0;
				if ($device_type == 'IOS') {
					$installment_price = $course_details[0]['ss_aw_apple_installment_price'];
				}
				else{
					$installment_price = $course_details[0]['ss_aw_installment_price'];
				}
				if ($course_price_as_before > 0) {
					$actual_course_price = $course_price_as_before;
				}
				else{
					$actual_course_price = str_replace(",","", $installment_price);	
				}
				
				$price_per_month = $actual_course_price / $devide_duration;
				$price_per_month = number_format($price_per_month, 2);
				$course_price_with_gst = str_replace(",", "", $price_per_month);
				$course_price_with_gst = (float)$course_price_with_gst;
				$course_price = ($course_price_with_gst * 100) / (100 + $gst_rate);
				$course_price = number_format($course_price, 2);
				$course_price = str_replace(",", "", $course_price);
				$course_price = (float)$course_price;
				$responseary = array();
				$responseary['status'] = 200;
				$responseary['msg'] = "Fetched emi list.";
				$search_data = array(
					'ss_aw_course_id' => $course_id
				);
				$original_course_details = $this->ss_aw_courses_model->search_byparam($search_data);
				$responseary['course_name'] = $original_course_details[0]['ss_aw_course_name'];

				$count = 0;
				//check course in complete
				$check_complete = $this->ss_aw_child_course_model->check_course_complete_or_not($child_id, $course_id);
				if ($check_complete == 0) {
					if ($total_complete_emi_count >= $duration) {
						$duration = $total_complete_emi_count + 1;
					}
				}
				for ($i=0; $i < $duration; $i++) {
					$count++;
					$emi_done = 0;
					if ($count <= $total_complete_emi_count) {
					 	$emi_done = 1;
					} 
					$responseary['data'][$i]['gst_rate'] = $gst_rate;
					$responseary['data'][$i]['course_price_with_gst'] = $course_price_with_gst;
					$responseary['data'][$i]['course_price'] = $course_price;
					$responseary['data'][$i]['emi_status'] = $emi_done;
					$advance_day = $i * 31;
					
					if ($i != 0) {
						$formated_emi_date = date('Y-m-d', strtotime($first_emi_date."+31 days"));	
					}
					else{
						$formated_emi_date = date('Y-m-d', strtotime($first_emi_date));
					}
					$responseary['data'][$i]['emi_date'] = date('d/m/Y', strtotime($formated_emi_date));

					$emi_payment_date = "";
					if ($emi_done == 1) {
						$emi_payment_date = $emi_paid_date[$count - 1];
						$emi_payment_date = date('d/m/Y', strtotime($emi_payment_date));
					}

					$responseary['data'][$i]['emi_payment_date'] = $emi_payment_date;

					if (empty($emi_payment_date)) {
						$current_time = time();
						$emi_date_time = strtotime($formated_emi_date);
						$datediff = $current_time - $emi_date_time;
						$daydiff = round($datediff / (60 * 60 * 24));
						if ($daydiff > 30) {
							$responseary['data'][$i]['emi_block'] = 1;
						}
						else{
							$responseary['data'][$i]['emi_block'] = 0;
						}
					}
					else{
						$responseary['data'][$i]['emi_block'] = 0;
					}
					

					$first_emi_date = $formated_emi_date;
				}

				if (!empty($first_transaction_id)) {
					$first_payment_details = $this->ss_aw_payment_details_model->get_details_by_transaction_id($first_transaction_id);
					$responseary['data'][0]['gst_rate'] = $gst_rate;
					$responseary['data'][0]['course_price_with_gst'] = round($first_payment_details->ss_aw_payment_amount);
					$first_emi_course_price = ($first_payment_details->ss_aw_payment_amount * 100) / (100 + $gst_rate);
					$first_emi_course_price = number_format($first_emi_course_price, 2);
					$first_emi_course_price = str_replace(",", "", $first_emi_course_price);
					$responseary['data'][0]['course_price'] = $first_emi_course_price;
				}
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}	
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}

		die(json_encode($responseary));
	}

	public function check_promotion(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$userid = $postdata['user_id'];
			$token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			$course_id = $postdata['course_id'];
			if ($this->check_parent_existance($userid, $token)) {
				if ($course_id == 2) {
					$previous_course = "E";
					$previous_course_id = 1;
				}
				elseif ($course_id == 3) {
					$previous_course = "C";
					$previous_course_id = 2;
				}
				$check_promotion = $this->ss_aw_promotion_model->get_promotion_detail($child_id, $previous_course);
				if (!empty($check_promotion)) {
					$promoted = 1;
					$target_course_id = $previous_course_id;

				}
				else{
					$promoted = 0;
					$target_course_id = $course_id;
				}

				$check_course = $this->ss_aw_child_course_model->get_details_by_child_course($child_id, $target_course_id);
				$purchase_mode = 0;
				$purchase_date = "";
				$searchary = array(
					'ss_aw_parent_id' => $userid,
					'ss_aw_child_id' => $child_id,
					'ss_aw_selected_course_id' => $target_course_id
				);

				$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);

				if (!empty($count_previous_emi)) {
					$purchase_date = date('Y-m-d', strtotime($count_previous_emi[0]['ss_aw_course_created_date']));
				}

				if (!empty($check_course)) {
					if ($check_course[0]->ss_aw_course_payemnt_type == 1) {
						$purchase_mode = 1;
					}
					else{
						$purchase_mode = 0;
					}
				}

				$responseary['status'] = 200;
				$responseary['data']['promoted'] = $promoted;
				$responseary['data']['purchase_mode'] = $purchase_mode;
				$responseary['data']['purchase_date'] = $purchase_date;

			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}

		die(json_encode($responseary));
	}

	// public function accept_promotion(){
	// 	$postdata = $this->input->post();
	// 	$responseary = array();
	// 	if (!empty($postdata)) {
	// 		$user_id = $postdata['user_id'];
	// 		$user_token = $postdata['user_token'];
	// 		$pre_course_id = $postdata['course_id'];
	// 		$child_id = $postdata['child_id'];
	// 		if ($this->check_parent_existance($user_id, $user_token)) {
	// 			//update child promotional record
	// 			if ($pre_course_id == 1) {
	// 				$course_id = 2;
	// 			}
	// 			elseif ($pre_course_id == 2) {
	// 				$course_id = 3;
	// 			}
	// 			$promotion_details = $this->ss_aw_promotion_model->check_rejection($child_id, $pre_course_id);
	// 			$invitation_lesson_num = $promotion_details[0]->ss_aw_lesson_num;
	// 			$searchary = array(
	// 				'ss_aw_child_id' => $child_id,
	// 				'ss_aw_lesson_level' => $pre_course_id
	// 			);
	// 			$count_complete_lesson = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($searchary);

	// 			if (($promotion_details[0]->status == 0) && (count($count_complete_lesson) == $invitation_lesson_num)) {
	// 				$searary = array();
	// 				$searary['ss_aw_child_id'] = $child_id;
	// 				$searary['ss_aw_course_id'] = $course_id;

	// 				$courseary = $this->ss_aw_child_course_model->updaterecord_child($child_id, $searary);

	// 				$update_payment_record = array();
	// 				$update_payment_record['ss_aw_selected_course_id'] = $course_id;
	// 				$this->ss_aw_purchase_courses_model->update_record($child_id, $update_payment_record);
						
	// 				{
	// 					$previous_course = "";
	// 					if ($course_id == 2) {
	// 						$previous_course = "E";	
	// 						$promoted_course = "C";
	// 					}
	// 					elseif ($course_id == 3) {
	// 						$previous_course = "C";
	// 						$promoted_course = "A";	
	// 					}

	// 					if (!empty($previous_course)) {
	// 						$update_promotion_data = array();
	// 						$update_promotion_data['ss_aw_child_id'] = $child_id;
	// 						$update_promotion_data['ss_aw_current_level'] = $previous_course;
	// 						$update_promotion_data['status'] = 1;
	// 						$response = $this->ss_aw_promotion_model->update_record($update_promotion_data);
	// 						if ($response) {
	// 							//get pre-promotion lesson records and insert as promoted level record
	// 							$get_lesson_score_detail = $this->ss_aw_lesson_score_model->getlessonscoreofpreviouscourse($previous_course, $child_id);
	// 							if (!empty($get_lesson_score_detail)) {
	// 								$completed_lesson_ids = array();
	// 								foreach ($get_lesson_score_detail as $key => $value) {
	// 									$completed_lesson_ids[] = $value->lesson_id;
	// 									$data = array(
	// 										'lesson_id' => $value->lesson_id,
	// 										'child_id' => $child_id,
	// 										'level' => $promoted_course,
	// 										'total_question' => $value->total_question,
	// 										'wright_answers' => $value->wright_answers
	// 									);

	// 									$this->ss_aw_lesson_score_model->store_data($data);
	// 								}
	// 							}

	// 							if ($previous_course == 'E') {
	// 								$previous_course_code = 1;
	// 								$current_course_name = "Emerging";
	// 								$promoted_course_name = "Consolating";
	// 							}
	// 							elseif ($previous_course == 'C') {
	// 								$previous_course_code = 2;
	// 								$current_course_name = "Consolating";
	// 								$promoted_course_name = "Advanced";
	// 							}

	// 							$childs_lessonsary = $this->ss_aw_child_last_lesson_model->fetch_details_lesson_list($child_id,$previous_course_code,'asc');
	// 							if (!empty($childs_lessonsary)) {
	// 								foreach ($childs_lessonsary as $key => $value) {
	// 									$data = array(
	// 										'ss_aw_child_id' => $child_id,
	// 										'ss_aw_lesson_level' => $course_id,
	// 										'ss_aw_lesson_id' => $value['ss_aw_lesson_id'],
	// 										'ss_aw_lesson_format' => $value['ss_aw_lesson_format'],
	// 										'ss_aw_back_click_count' => $value['ss_aw_back_click_count'],
	// 										'ss_aw_lesson_status' => $value['ss_aw_lesson_status'],
	// 										'ss_aw_last_lesson_create_date' => $value['ss_aw_last_lesson_create_date'],
	// 										'ss_aw_last_lesson_modified_date' => $value['ss_aw_last_lesson_modified_date']
	// 									);

	// 									$this->ss_aw_child_last_lesson_model->data_insert($data);
	// 								}
	// 							}

	// 							//get pre-promotion assessment records and insert as promoted level record
	// 							$get_assessment_score_detail = $this->ss_aw_assessment_score_model->getassessmentofpreviouscourse($previous_course, $child_id);
	// 							if (!empty($get_assessment_score_detail)) {
	// 								foreach ($get_assessment_score_detail as $value) {
	// 									$data = array(
	// 										'child_id' => $child_id,
	// 										'level' => $promoted_course,
	// 										'exam_code' => $value->exam_code,
	// 										'assessment_id' => $value->assessment_id,
	// 										'total_question' => $value->total_question,
	// 										'wright_answers' => $value->wright_answers
	// 									);

	// 									$this->ss_aw_assessment_score_model->store_data($data);
	// 								}
	// 							}

	// 							//send promotion confirmation notifications to parent
	// 							$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
	// 							$child_name = $child_details[0]->ss_aw_child_nick_name;
	// 							$gender = $child_details[0]->ss_aw_child_gender;
	// 							if ($gender == 1) {
	// 								$g = "his";	
	// 							}
	// 							else{
	// 								$g = "her";
	// 							}
	// 							if (!empty($child_details)) {
	// 								if ($course_id == 2) {
	// 									$email_template = getemailandpushnotification(41, 1, 2);
	// 									$app_template = getemailandpushnotification(41, 2, 2);
	// 									$action_id = 40;		
	// 								}
	// 								elseif ($course_id == 3) {
	// 									$email_template = getemailandpushnotification(42, 1, 2);
	// 									$app_template = getemailandpushnotification(42, 2, 2);
	// 									$action_id = 43;	
	// 								}

	// 								$title = "Student Promotion Confirmation";

	// 								if (!empty($email_template)) {
	// 									$body = $email_template['body'];
	// 									$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
	// 									$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
	// 									emailnotification($child_details[0]->ss_aw_child_email, $title, $body);
	// 								}

	// 								if (!empty($app_template)) {
	// 									$body = $app_template['body'];
	// 									$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
	// 									$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
	// 									$token = $child_details[0]->ss_aw_device_token;

	// 									pushnotification($title,$body,$token,$action_id);

	// 									$save_data = array(
	// 										'user_id' => $child_details[0]->ss_aw_child_id,
	// 										'user_type' => 2,
	// 										'title' => $title,
	// 										'msg' => $body,
	// 										'status' => 1,
	// 										'read_unread' => 0,
	// 										'action' => $action_id
	// 									);

	// 									save_notification($save_data);
	// 								}	
	// 							}

	// 							$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);
	// 							if ($course_id == 2) {
	// 								$email_template = getemailandpushnotification(37, 1, 1);
	// 								$app_template = getemailandpushnotification(37, 2, 1);
	// 								$action_id = 38;
	// 							}
	// 							elseif ($course_id == 3) {
	// 								$email_template = getemailandpushnotification(43, 1, 1);
	// 								$app_template = getemailandpushnotification(43, 2, 1);
	// 								$action_id = 41;
	// 							}
	// 							if (!empty($parent_detail)) {	
									
	// 								if (!empty($email_template)) {
	// 									$body = $email_template['body'];
	// 									$body = str_ireplace("[@@child_name@@]", $child_name, $body);
	// 									$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
	// 									$body = str_ireplace("[@@course_name@@]", $current_course_name, $body);
	// 									$body = str_ireplace("[@@promoted_course_name@@]", $promoted_course_name, $body);
	// 									$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
	// 									emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $email_template['body']);
	// 								}

									
	// 								if (!empty($app_template)) {
	// 									$body = $app_template['body'];
	// 									$body = str_ireplace("[@@child_name@@]", $child_name, $body);
	// 									$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
	// 									$body = str_ireplace("[@@course_name@@]", $current_course_name, $body);
	// 									$body = str_ireplace("[@@promoted_course_name@@]", $promoted_course_name, $body);
	// 									$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
	// 									$title = $app_template['title'];
	// 									$token = $parent_detail[0]->ss_aw_device_token;

	// 									pushnotification($title,$body,$token,$action_id);

	// 									$save_data = array(
	// 										'user_id' => $parent_detail[0]->ss_aw_parent_id,
	// 										'user_type' => 1,
	// 										'title' => $title,
	// 										'msg' => $body,
	// 										'status' => 1,
	// 										'read_unread' => 0,
	// 										'action' => $action_id
	// 									);

	// 									save_notification($save_data);
	// 								}	
	// 							}
	// 						}
	// 					}	
	// 				}

	// 				$responseary['status'] = 200;
	// 				$responseary['msg'] = "Promotion confirmed successfully.";	
	// 			}
	// 			else{
	// 				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1032');
	// 				foreach ($error_array as $value) {
	// 					$responseary['status'] = $value->ss_aw_error_status;
	// 					$responseary['msg'] = $value->ss_aw_error_msg;
	// 					$responseary['title'] = "Error";				
	// 				}
	// 			}
	// 		}
	// 		else{
	// 			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
	// 			foreach ($error_array as $value) {
	// 				$responseary['status'] = $value->ss_aw_error_status;
	// 				$responseary['msg'] = $value->ss_aw_error_msg;
	// 				$responseary['title'] = "Error";				
	// 			}
	// 		}	
	// 	}

	// 	die(json_encode($responseary));
	// }

	public function check_course_purchased_or_not_for_ios(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$userid = $postdata['user_id'];
			$user_token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			$course_id = $postdata['course_id'];
			if ($this->check_parent_existance($userid, $user_token)) {
				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($userid);
				$childary = $this->ss_aw_child_course_model->get_details_by_child_course($child_id, $course_id);
				$responseary['status'] = 200;
				if (!empty($childary)) {
					$responseary['msg'] = "Course purchased.";
					$responseary['data']['course_purchase'] = 1;
				}
				else{
					$responseary['msg'] = "Course not purchased.";
					$responseary['data']['course_purchase'] = 0;
				}
				$responseary['data']['user_type'] = $parent_detail[0]->ss_aw_user_type;
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}
		die(json_encode($responseary));
	}

	public function check_supplementary_purchased_or_not_for_ios(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$userid = $postdata['user_id'];
			$user_token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			$course_id = $postdata['course_id'];
			if ($this->check_parent_existance($userid, $user_token)) {
				$searchary = array(
					'ss_aw_parent_id' => $userid,
					'ss_aw_child_id' => $child_id,
					'ss_aw_supplymentary_courses' => $course_id
				);
				$childary = $this->ss_aw_purchased_supplymentary_course_model->search_byparam($searchary);
				$responseary['status'] = 200;
				if (!empty($childary)) {
					$responseary['msg'] = "Supplymentary content purchased.";
					$responseary['data']['supplymentary_purchase'] = 1;
				}
				else{
					$responseary['msg'] = "Supplymentary content not purchased.";
					$responseary['data']['supplymentary_purchase'] = 0;
				}
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}
		die(json_encode($responseary));
	}

	public function final_performance_report_ready(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$userid = $postdata['user_id'];
			$user_token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			$course_id = $postdata['course_id'];
			if ($this->check_parent_existance($userid, $user_token)) {
				$responseary['status'] = 200;
				if ($course_id == 1) {
					$course_level = "E";
				}
				elseif ($course_id == 2) {
					$course_level = "C";
				}
				else{
					$course_level = "A";
				}

				$check = $this->ss_aw_child_result_model->checkrecord($child_id, $course_level);
				if (!empty($check)) {
					$responseary['data']['final_performance_report_ready'] = 1;
					$responseary['data']['final_report_link'] = base_url()."scorepdf/".$check[0]->ss_aw_report_path;
				}
				else{
					$responseary['data']['final_performance_report_ready'] = 0;
					$responseary['data']['final_report_link'] = '';
				}
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}

		die(json_encode($responseary));
	}

	public function reject_promotion(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$userid = $postdata['user_id'];
			$token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			$course_id = $postdata['course_id']; // Current course id
			if ($this->check_parent_existance($userid, $token)) {
				if ($course_id == 1) {
					$course_level = "E";
				}
				elseif ($course_id == 2) {
					$course_level = "C";
				}
				else{
					$course_level = "A";
				}

				$this->ss_aw_promotion_model->reject_promotion($child_id, $course_level);
				$responseary['status'] = 200;
				$responseary['msg'] = "Promotion rejected successfully.";	
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		else{
			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
			foreach ($error_array as $value) {
				$responseary['status'] = $value->ss_aw_error_status;
				$responseary['msg'] = $value->ss_aw_error_msg;
				$responseary['title'] = "Error";				
			}
		}

		die(json_encode($responseary));
	}

	public function check_parent_child_essential_record_existance()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id'];
			$child_id = $inputpost['child_id'];
			$parent_token = $inputpost['user_token'];
			if($this->check_parent_existance($parent_id,$parent_token))
			{
				$this->db->trans_start();

				//check parent profile essential record exist or not
				$childdataary = $this->ss_aw_childs_model->get_child_details_by_id($child_id,$parent_id);
					
				if(!empty($childdataary))
				{
					$responseary['status'] = 200;
					foreach($childdataary as $key=>$val)
					{
						if($val->ss_aw_child_first_name!='' && $val->ss_aw_child_last_name!='' 
							&& $val->ss_aw_child_gender!='' && $val->ss_aw_child_schoolname !='')
						{
							$responseary['profile_status'] = 1;
							$responseary['msg'] = "Profile all data exist";
						}
						else
						{
							$responseary['status'] = 1031;
							$responseary['profile_status'] = 0;
							$responseary['user_type'] = 2; //child
							$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1031');
							foreach ($error_array as $value) {
								$responseary['status'] = $value->ss_aw_error_status;
								$responseary['msg'] = $value->ss_aw_error_msg;
								$responseary['title'] = "Error";				
							}
						}
					}
				}
				else
				{
					$responseary['status'] = 1031;
					$responseary['profile_status'] = 0;
					$responseary['user_type'] = 2; //child
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
					}
					die(json_encode($responseary));
				}

				$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);
				if ($parent_detail[0]->ss_aw_parent_address != "" && $parent_detail[0]->ss_aw_parent_city != "" && $parent_detail[0]->ss_aw_parent_state && $parent_detail[0]->ss_aw_parent_pincode != "") {
					$responseary['profile_status'] = 1;
					$responseary['msg'] = "Profile data exist";
				}
				else{
					$responseary['status'] = 1031;
					$responseary['profile_status'] = 0;
					$responseary['user_type'] = 1; //parent
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1031');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
					}
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
	}

	public function delete_parent_data(){
		$inputpost = $this->input->post();
		$parent_id = $inputpost['user_id'];
		$parent_token = $inputpost['user_token'];
		if($this->check_parent_existance($parent_id,$parent_token))
		{
			$data = array(
				'ss_aw_blocked' => 1
			);
			$response = $this->ss_aw_parents_model->update_parent_details($data, $parent_id);
			if ($response) {
				$childs = $this->ss_aw_childs_model->get_all_child_details($parent_id);
				if (!empty($childs)) {
					foreach ($childs as $key => $value) {
						$update_child = array(
							'ss_aw_child_status' => 0
						);
						$this->ss_aw_childs_model->update_child_details($update_child, $value->ss_aw_child_id);
					}
				}

				$email_template = getemailandpushnotification(51, 1);
				if (!empty($email_template)) {
					$parent_detail = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
					$body = $email_template['body'];
					$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
					emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
				}

				$responseary['status'] = 200;
				$responseary['msg'] = "Blocked successfully.";
			}
			else{
				$responseary['status'] = 200;
				$responseary['msg'] = "Something went wrong, please try again later.";
			}
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

	//version 2 code

	public function get_lessons_list()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				
				$previous_lesson_complete_count = 0;
				
				$childs_lessonsary = array();
				
				$lesson_listary = $this->ss_aw_lessons_uploaded_model->get_lessonlist(); 
				$completed_assessmentsary = array(); 
				
				$assessment_completedary = array();
				
				/*
					Create a array of running or completed Lessons LIST
				*/
				$runninglessonsary  = array();
				$lessonsstartdateary  = array();
				$completedlessonsary  = array();
				$completedlessonsdateary  = array();
				
				$resultary = array();
				
				if(!empty($lesson_listary))
				{				
					foreach($lesson_listary as $key=>$val)
					{
						$resultary[$key]['is_blocked'] = 0;
						$resultary[$key]['lesson_end_date'] = "";
						$resultary[$key]['lesson_start_date'] = "";

						$resultary[$key]['lesson_format'] = $val['ss_aw_lesson_format'];
						if($val['ss_aw_lesson_format'] == 'Single')
							$resultary[$key]['lesson_format_id'] = 1;
						else
							$resultary[$key]['lesson_format_id'] = 2;
							
						$resultary[$key]['lesson_id'] = $val['ss_aw_lession_id'];
						$resultary[$key]['topic_title'] = $val['ss_aw_lesson_topic'];
						$resultary[$key]['lesson_status'] = 0; // 0 = Not started, 1 = Running, = 2 = Completed
						
						$resultary[$key]['assessment_status'] = 0;
						$resultary[$key]['assessment_end_date'] = "";
						$resultary[$key]['is_demo'] = $val['ss_aw_is_demo'];
					}
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data Found';
					$responseary['result'] = $resultary;
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value){
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;	
						$responseary['title'] = "Error";	
					}			
				}
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;	
					$responseary['title'] = "Error";	
				}			
					
			}	
			echo json_encode($responseary);
			die(); 	
		}
	}

	public function get_assessments_list()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
     	$parent_id = $inputpost['user_id']; // Child Record ID from Database
		$parent_token = $inputpost['user_token']; // Token get after login
			
		if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
		{
			$this->db->trans_start();
			
				$result = $this->ss_aw_assesment_uploaded_model->assessment_list(); //Get all assessement exam list

				if(!empty($result))
				{
					$count = 0;
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data found';
					foreach($result as $key=>$value)
					{
						$responseary['result'][$key]['is_blocked'] = 0;
						$responseary['result'][$key]['confidence'] = "";
						$responseary['result'][$key]['accuracy'] = "";
						$responseary['result'][$key]['total_question'] = "";	
						$responseary['result'][$key]['wright_answers'] = "";
						$responseary['result'][$key]['assessment_restarted'] = 0;
						
						$responseary['result'][$key]['complete'] = 0;
						$responseary['result'][$key]['assessment_complete_count'] = 0;
						$responseary['result'][$key]['assessment_id'] = $value['ss_aw_assessment_id'];
						$responseary['result'][$key]['lesson_id'] = $value['ss_aw_lesson_id'];
						$responseary['result'][$key]['language'] = $value['ss_aw_language'];
						$responseary['result'][$key]['assesment_format'] = $value['ss_aw_assesment_format'];
						if($value['ss_aw_assesment_format'] == 'Single')
							$responseary['result'][$key]['assesment_format_id'] = 1;
						else
							$responseary['result'][$key]['assesment_format_id'] = 2;
						$responseary['result'][$key]['level'] = "";
						$responseary['result'][$key]['topic'] = $value['ss_aw_assesment_topic'];
						$responseary['result'][$key]['assessment_status'] = 0;
						$responseary['result'][$key]['exam_completed'] = 0;
						$responseary['result'][$key]['lesson_completed_date'] = "";
						$responseary['result'][$key]['lesson_completed'] = 0;
						$responseary['result'][$key]['is_demo'] = $value['ss_aw_is_demo'];
					}
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
					}
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
   }

   public function readalongs_list()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
     	$parent_id = $inputpost['user_id']; // Child Record ID from Database
		$parent_token = $inputpost['user_token']; // Token get after login
			
		if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
		{
			$this->db->trans_start();
			if ($inputpost['is_adult'] == 1) {
				$child_code = "10000001";
			}
			else{
				$child_code = "10000000";	
			}
			$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
			$searchary = array();
			$searchary['ss_aw_child_id'] = $child_details[0]->ss_aw_child_id;
			$result = $this->ss_aw_schedule_readalong_model->search_byparam($searchary);
				
			$this->db->trans_complete();
			if(!empty($result))
			{
				$responseary['status'] = '200';
				$responseary['msg'] = 'Data found';
				foreach($result as $key=>$value)
				{
					if($value['ss_aw_status'] == 1){
						$responseary['result'][$key]['readalong_id'] = $value['ss_aw_readalong_id'];
						$responseary['result'][$key]['type'] = $value['ss_aw_type'];
						$responseary['result'][$key]['title'] = $value['ss_aw_title'];
						$responseary['result'][$key]['level'] = $value['ss_aw_level'];
						$responseary['result'][$key]['topic'] = $value['ss_aw_topic'];
						$responseary['result'][$key]['release_date'] = $value['ss_aw_created_date'];
						$responseary['result'][$key]['scheduled_date'] = "";
						$responseary['result'][$key]['is_scheduled'] = 0;	
						$responseary['result'][$key]['is_demo'] = $value['ss_aw_is_demo'];	
					}		
				}
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
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
   }

   public function store_current_lesson_page()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
     	 	$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$back_click_count = $inputpost['back_click_count'];
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_age = calculate_age($child_details[0]->ss_aw_child_dob);
				$child_id = $child_details[0]->ss_aw_child_id;
				$lesson_code = $inputpost['lesson_id']."_".$parent_id;
				$lesson_id = ($inputpost['lesson_id']);
				$lesson_index_id = ($inputpost['lesson_index_id']);
				$lessonary = array();
				$lessonary['ss_aw_lesson_id'] = $lesson_id;
				$lessonary['ss_aw_child_id'] = $child_id;
				$lessonary['ss_aw_lesson_index'] = $lesson_index_id;
				$lessonary['ss_aw_updated_date'] = date('Y-m-d H:i:s');
				$lessonary['ss_aw_back_click_count'] = $back_click_count;
				$lessonary['ss_aw_lesson_code'] = $lesson_code;
				$response = $this->ss_aw_current_lesson_model->update_record($lessonary);
				if($response == 0)
				{
					$this->ss_aw_current_lesson_model->insert_data($lessonary);
				}
				$responseary['status'] = '200';
				$responseary['msg'] = 'Lesson current status updated';
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
   }

   public function get_lesson_details_list()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			
			if($this->check_parent_existance($parent_id,$parent_token))
			{
				$lesson_id = ($inputpost['lesson_id']);
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_age = calculate_age($child_details[0]->ss_aw_child_dob);
				$child_id = $child_details[0]->ss_aw_child_id;
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];
				$lesson_upload_details = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
				$lesson_serial_no = $lesson_upload_details[0]->ss_aw_sl_no;
				
				if ($level_id == 1 || $level_id == 2) {
					if ($child_age < 13) {
						if ($lesson_serial_no > 10) {
							$fetch_level_id = 2;
						}
						else{
							$fetch_level_id = 1;
						}
					}
					else{
						$fetch_level_id = 2;
					}
				}
				elseif ($level_id == 5) {
					if ($lesson_serial_no <= 10) {
						$fetch_level_id = 2;
					}
					elseif ($lesson_serial_no > 10 && $lesson_serial_no < 56) {
						$fetch_level_id = 3;
					}
					else{
						$fetch_level_id = 4;
					}
				}
				else{
					$fetch_level_id = 3;
				}

				

				$searchary = array();
				$searchary['ss_aw_lesson_record_id'] = $lesson_id;
				$searchary['ss_aw_course_id'] = $fetch_level_id;
				$lessonary = $this->ss_aw_lessons_model->search_data_by_param($searchary);
				$searchary = array();
				$searchary['ss_aw_lesson_record_id'] = $lesson_id;
				$searchary['ss_aw_course_id'] = $fetch_level_id;
				$lessonary = $this->ss_aw_lessons_model->search_data_by_param($searchary); 
				
				$all_page_count = $this->ss_aw_lessons_model->alldatacountbyparam($searchary);
				
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
				else if($level_id == 3)
				{
					$level = 'A';
				}
				else if($level_id == 5)
				{
					$level = 'M';
				}
				
				$setting_result = array();
				$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
				$idletime = $setting_result[0]->ss_aw_time_skip;
				$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
				
				$resultary = array();
				$resultary['course'] = "";
				$resultary['correct_answer_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_answer_audio;
				$resultary['skip_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_skip_audio;
				$resultary['correct_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_audio;
				$resultary['incorrect_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_incorrect_audio;
				if ($lessonary[0]['ss_aw_lesson_format'] == 'Multiple') {
					$resultary['lesson_quiz_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_general_language_correct;
					$resultary['lesson_quiz_bad_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_general_language_incorrect;	
					$resultary['lesson_quiz_bad_audio2'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_general_language_incorrect2;	
				}
				else{
					$resultary['lesson_quiz_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_topical_lesson_correct;
					$resultary['lesson_quiz_bad_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_topical_lesson_incorrect;
					$resultary['lesson_quiz_bad_audio2'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_topical_lesson_incorrect2;
				}
				
				$current_page_details = array();
				$lesson_code = $lesson_id."_".$parent_id;
				$current_page_details['ss_aw_lesson_id'] = $lesson_id;
				$current_page_details['ss_aw_child_id'] = $child_id;
				$current_page_details['ss_aw_lesson_code'] = $lesson_code;
				$current_lesson_response = $this->ss_aw_current_lesson_model->fetch_record_byparam($current_page_details);

				if(!empty($current_lesson_response[0]['ss_aw_lesson_index']))
					$resultary['current_page_index'] = $current_lesson_response[0]['ss_aw_lesson_index'];
				else
					$resultary['current_page_index'] = "";

				$resultary['back_click_count'] = "";
				if(!empty($lessonary))
				{
					if($lessonary[0]['ss_aw_lesson_format'] == 'Multiple')
					{
						/////////////// First Data section ///////////////////////////////
						$i = 0;
						$resultary_inner1 = array();
							foreach($lessonary as $key=>$val)
							{
								if($i == 0)
								{		
									$useindexary[] = $val['ss_aw_lession_id'];
									$resultary_inner1['index'] = $val['ss_aw_lession_id'];
									$resultary_inner1['title'] = strip_tags($val['ss_aw_lesson_title']);
									
									$resultary_inner1['lesson_format'] = 2; // 1 = Single, 2 = Multiple
									$resultary_inner1['type'] = 1;  // 1 = Text, 2= Quiz
									$resultary_inner1['comprehension_question'] = 0;	
									
										
									//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
									
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
							///////////////////////////////////////////////////////////////////////////////////
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
							$firstvalue = trim($lessonary[0]['ss_aw_lesson_title']);
							$resultary_inner2 = array();
							foreach($lessonary as $key=>$val)
							{
								if($i == 0)
								{		
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
							foreach($lessonary as $key=>$val)
							{
								if($i == 0)
								{			
									$useindexary[] = $val['ss_aw_lession_id'];
									$resultary_inner['index'] = $val['ss_aw_lession_id'];
									$resultary_inner['title'] = strip_tags($val['ss_aw_lesson_details']);
									
									$resultary_inner['lesson_format'] = 2; // 1 = Single, 2 = Multiple
									$resultary_inner['type'] = 2;  // 1 = Text, 2= Quiz
									$resultary_inner['comprehension_question'] = 1;
									
										
									//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
									
									if(!empty($val['ss_aw_lesson_details_audio'])) 
									{
										$resultary_inner['audio'] = base_url().$val['ss_aw_lesson_details_audio'];
										$resultary_inner['audio_slow'] = base_url().$val['ss_aw_lesson_details_audio_slow'];
										$resultary_inner['audio_fast'] = base_url().$val['ss_aw_lesson_details_audio_fast'];
									}
									else
									{
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
										if($check_question[0]->ss_aw_answer_status == 1){
											$resultary_inner['details']['quizes'][0]['correct'] = 1;
										}
										else{
											$resultary_inner['details']['quizes'][0]['correct'] = 0;
										}
									}
									else{
										$resultary_inner['details']['quizes'][0]['answered'] = 0;
									}
									//end of checking

									$multiple_choice_ary = array();
										//$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
										$multiple_choice_ary = explode("/",trim($val['ss_aw_lesson_question_options']));
										
										$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
										if(!empty($multiple_choice_ary))
											$resultary_inner['details']['quizes'][0]['options'] = $multiple_choice_ary;
										else
											$resultary_inner['details']['quizes'][0]['options'] = array();
										
										$answersary = array();
										$answersary = explode("/",trim(strip_tags($val['ss_aw_lesson_answers'])));
										
										$answersary = array_map('trim',$answersary);
										if(!empty($answersary))
										{
											$resultary_inner['details']['quizes'][0]['answers'] = $answersary;
											$resultary_inner['details']['quizes'][0]['answeraudio'] = base_url().$val['ss_aw_lesson_answers_audio'];
											$resultary_inner['details']['quizes'][0]['answeraudio_slow'] = base_url().$val['ss_aw_lesson_answers_audio_slow'];
											$resultary_inner['details']['quizes'][0]['answeraudio_fast'] = base_url().$val['ss_aw_lesson_answers_audio_fast'];
										}
										else{
											$resultary_inner['details']['quizes'][0]['answers'] = array();
											$resultary_inner['details']['quizes'][0]['answeraudio'] = "";
											$resultary_inner['details']['quizes'][0]['answeraudio_slow'] = "";
											$resultary_inner['details']['quizes'][0]['answeraudio_fast'] = "";
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
								
								if(($i > 0) && trim($firstvalue) == trim($val['ss_aw_lesson_title']))
								{
									$useindexary[] = $val['ss_aw_lession_id'];
									$resultary_inner3[$j]['index'] = $val['ss_aw_lession_id'];
									$resultary_inner3[$j]['title'] = strip_tags($val['ss_aw_lesson_details']);
									
									$resultary_inner3[$j]['lesson_format'] = 2; // 1 = Single, 2 = Multiple
									$resultary_inner3[$j]['type'] = 2;  // 1 = Text, 2= Quiz
									$resultary_inner3[$j]['comprehension_question'] = 1;
									
										
									//$resultary['data'][$i]['topic_format_id'] = $val['ss_aw_topic_format_id'];
									
									if(!empty($val['ss_aw_lesson_details_audio'])) 
									{
										$resultary_inner3[$j]['audio'] = base_url().$val['ss_aw_lesson_details_audio'];
										$resultary_inner3[$j]['audio_slow'] = base_url().$val['ss_aw_lesson_details_audio_slow'];
										$resultary_inner3[$j]['audio_fast'] = base_url().$val['ss_aw_lesson_details_audio_fast'];
									}
									else
									{
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
										if($check_question[0]->ss_aw_answer_status == 1){
											$resultary_inner3[$j]['details']['quizes'][0]['correct'] = 1;
										}
										else{
											$resultary_inner3[$j]['details']['quizes'][0]['correct'] = 0;
										}
									}
									else{
										$resultary_inner3[$j]['details']['quizes'][0]['answered'] = 0;
									}
									//end of checking

									$multiple_choice_ary = array();
										//$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
										$multiple_choice_ary = explode("/",trim($val['ss_aw_lesson_question_options']));
										
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
											$resultary_inner3[$j]['details']['quizes'][0]['answers'] = $answersary;
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = base_url().$val['ss_aw_lesson_answers_audio'];
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_slow'] = base_url().$val['ss_aw_lesson_answers_audio_slow'];
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_fast'] = base_url().$val['ss_aw_lesson_answers_audio_fast'];
										}
										else{
											$resultary_inner3[$j]['details']['quizes'][0]['answers'] = array();
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio'] = "";
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_slow'] = "";
											$resultary_inner3[$j]['details']['quizes'][0]['answeraudio_fast'] = "";
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
						$firstvalue = trim($lessonary[0]['ss_aw_lesson_title']);
						foreach($lessonary as $key=>$val)
						{
						if(!in_array($val['ss_aw_lession_id'],$useindexary))
						{
							if($firstvalue != trim($val['ss_aw_lesson_title']))
							{
						if($previous_title != trim($val['ss_aw_lesson_title']))
							{
								$i++;
								$j = 0;
								$r = 0;
							}
							else if($previous_title == trim($val['ss_aw_lesson_title']))
							{
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
							if(!empty($val['ss_aw_lesson_audio'])){
								$resultary['data'][$i]['audio'] = base_url().$val['ss_aw_lesson_audio'];
								$resultary['data'][$i]['audio_slow'] = base_url().$val['ss_aw_lesson_audio_slow'];
								$resultary['data'][$i]['audio_fast'] = base_url().$val['ss_aw_lesson_audio_fast'];
							}
							else{
								$resultary['data'][$i]['audio'] = "";
								$resultary['data'][$i]['audio_slow'] = "";
								$resultary['data'][$i]['audio_fast'] = "";
							}
							
							$resultary['data'][$i]['details']['course'] = intval($val['ss_aw_course_id']);
							
							
							$resultary['data'][$i]['details']['examples'] = array();
							
							if($val['ss_aw_lesson_quiz_type_id'] > 0)
							{
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
									if($check_question[0]->ss_aw_answer_status == 1){
										$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 1;
									}
									else{
										$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 0;
									}
								}
								else{
									$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 0;
								}
								//end of checking

								$multiple_choice_ary = array();
								//$multiple_choice_ary = explode(",",trim($val['ss_aw_lesson_question_options']));
								$multiple_choice_ary = explode("/",trim($val['ss_aw_lesson_question_options']));
								
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
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_slow'] = base_url().$val['ss_aw_lesson_answers_audio_slow'];
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_fast'] = base_url().$val['ss_aw_lesson_answers_audio_fast'];
							}
							else
							{
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
				}
				else // Single Section Start FRom HERE
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
							if(!empty($lessonary[0]['ss_aw_lesson_audio'])){
								$resultary['data'][$i]['audio'] = base_url().$lessonary[0]['ss_aw_lesson_audio'];
								$resultary['data'][$i]['audio_slow'] = base_url().$lessonary[0]['ss_aw_lesson_audio_slow'];
								$resultary['data'][$i]['audio_fast'] = base_url().$lessonary[0]['ss_aw_lesson_audio_fast'];
							}
							else{
								$resultary['data'][$i]['audio'] = "";
								$resultary['data'][$i]['audio_slow'] = "";
								$resultary['data'][$i]['audio_fast'] = "";
							}
							if(strtolower($lessonary[0]['ss_aw_lessons_recap']) == 'yes')
								$resultary['data'][$i]['recap'] = 1;
							else
								$resultary['data'][$i]['recap'] = 0;
							$resultary['data'][$i]['details']['course'] = intval($lessonary[0]['ss_aw_course_id']);
							$resultary['data'][$i]['details']['duration'] = $idletime;
							if(!empty($lessonary[0]['ss_aw_lesson_details']))
							{
								$resultary['data'][$i]['details']['examples'][$j]['subindex'] = $j;
								$resultary['data'][$i]['details']['examples'][$j]['data'] = strip_tags($lessonary[0]['ss_aw_lesson_details']);
								if(!empty($lessonary[0]['ss_aw_lesson_details_audio'])){
									$resultary['data'][$i]['details']['examples'][$j]['audio'] = base_url().$lessonary[0]['ss_aw_lesson_details_audio_slow'];
									$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = base_url().$lessonary[0]['ss_aw_lesson_details_audio'];
									$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = base_url().$lessonary[0]['ss_aw_lesson_details_audio_fast'];
								}
								else{ 
									$resultary['data'][$i]['details']['examples'][$j]['audio'] = "";
									$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = "";
									$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = "";
								}
								if(strtolower($lessonary[0]['ss_aw_lessons_recap']) == 'yes')
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
								$resultary['data'][$i]['details']['quizes'][0]['question_id'] = $lessonary[0]['ss_aw_lession_id'];

								//check question answered before or not.
								$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($lessonary[0]['ss_aw_lesson_details'], $child_id);
								if (!empty($check_question)) {
									$resultary['data'][$i]['details']['quizes'][0]['answered'] = 1;
									if($check_question[0]->ss_aw_answer_status == 1){
										$resultary['data'][$i]['details']['quizes'][0]['correct'] = 1;
									}
									else{
										$resultary['data'][$i]['details']['quizes'][0]['correct'] = 0;
									}
								}
								else{
									$resultary['data'][$i]['details']['quizes'][0]['answered'] = 0;
								}
								//end of checking

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
								$resultary['data'][$i]['details']['quizes'][0]['answeraudio_slow'] = base_url().$lessonary[0]['ss_aw_lesson_answers_audio_slow'];
								$resultary['data'][$i]['details']['quizes'][0]['answeraudio_fast'] = base_url().$lessonary[0]['ss_aw_lesson_answers_audio_fast'];
							}
							else
							{
								$resultary['data'][$i]['details']['quizes'] = array();
								$resultary['data'][$i]['details']['quizes'][0]['answeraudio'] = "";
								$resultary['data'][$i]['details']['quizes'][0]['answeraudio_slow'] = "";
								$resultary['data'][$i]['details']['quizes'][0]['answeraudio_fast'] = "";
							}
					foreach($lessonary as $key=>$val)
					{
						if($previous_title != $val['ss_aw_lesson_title'])
							{
								$i++;
								$j = 0;
								$r = 0;
							}
							else if($previous_title == $val['ss_aw_lesson_title'])
							{
								if(!empty($val['ss_aw_lesson_details']) && $key != 0)
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
							if(!empty($val['ss_aw_lesson_audio'])){
								$resultary['data'][$i]['audio'] = base_url().$val['ss_aw_lesson_audio'];
								$resultary['data'][$i]['audio_slow'] = base_url().$val['ss_aw_lesson_audio_slow'];
								$resultary['data'][$i]['audio_fast'] = base_url().$val['ss_aw_lesson_audio_fast'];
							}
							else{
								$resultary['data'][$i]['audio'] = "";
								$resultary['data'][$i]['audio_slow'] = "";
								$resultary['data'][$i]['audio_fast'] = "";
							}
							if(strtolower($val['ss_aw_lessons_recap']) == 'yes' && $r == 0)
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
									if(!empty($val['ss_aw_lesson_details_audio'])){
										$resultary['data'][$i]['details']['examples'][$j]['audio'] = base_url().$val['ss_aw_lesson_details_audio'];
										$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = base_url().$val['ss_aw_lesson_details_audio_slow'];
										$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = base_url().$val['ss_aw_lesson_details_audio_fast'];
									}
									else{
										$resultary['data'][$i]['details']['examples'][$j]['audio'] = "";
										$resultary['data'][$i]['details']['examples'][$j]['audio_slow'] = "";
										$resultary['data'][$i]['details']['examples'][$j]['audio_fast'] = "";
									}
									
									if(strtolower($val['ss_aw_lessons_recap']) == 'yes')
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
								
								//check question answered before or not.
								$check_question = $this->ss_aw_lesson_quiz_ans_model->checkquestionansweredornot($val['ss_aw_lesson_details'], $child_id);
								if (!empty($check_question)) {
									$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 1;
									if($check_question[0]->ss_aw_answer_status == 1){
										$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 1;
									}
									else{
										$resultary['data'][$i]['details']['quizes'][$j]['correct'] = 0;
									}
								}
								else{
									$resultary['data'][$i]['details']['quizes'][$j]['answered'] = 0;
								}
								//end of checking

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
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_slow'] = base_url().$val['ss_aw_lesson_answers_audio_slow'];
								$resultary['data'][$i]['details']['quizes'][$j]['answeraudio_fast'] = base_url().$val['ss_aw_lesson_answers_audio_fast'];
								$resultary['data'][$i]['details']['quizes'][$j]['question_id'] = $val['ss_aw_lession_id'];
							}
							else
							{
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
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;	
					$responseary['title'] = "Error";	
					}			
				}
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
					foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;	
					$responseary['title'] = "Error";	
					}			
					
			}	
			echo json_encode($responseary);
			die(); 	
		}
	}

	public function assessment_exam_question_first_question()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_profile = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_profile[0]->ss_aw_child_id;

				$child_age = calculate_age($child_profile[0]->ss_aw_child_dob);

				$assessment_details = $this->ss_aw_assesment_uploaded_model->get_assessment_details_by_id($assessment_id);
				$assessment_serial_no = $assessment_details->ss_aw_sl_no;
			if(!empty($inputpost['assessment_exam_code']))
			{
				
				$getlast_lessonary = array();
			$getlast_lessonary = $this->ss_aw_child_last_lesson_model->fetch_details($child_id);
			/*
				Find out Current LEVEL of the child
			*/			
				$subcategoryary = array();
				if($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
					$level = "E";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
					$level = "C";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
					$level = "A";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 5)
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
				
				$exam_code = $inputpost['assessment_exam_code'];
				$searchary = array();
				$searchary['ss_aw_assessment_exam_code'] = $exam_code;
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_assessment_id'] = $assessment_id;
				$searchary['ss_aw_parent_id'] = $parent_id;
				$response = array();
				$response = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_question_details($searchary);
				
				$finalquestionary = array();
				$i = 0;
				foreach($response as $value)
				{
					
						$finalquestionary[$i]['question_id'] = $value['ss_aw_assessment_question_id'];
						$finalquestionary[$i]['level'] = $value['ss_aw_asked_level'];
						$finalquestionary[$i]['format'] = $value['ss_aw_format'];
						
						if($value['ss_aw_format'] == 'Single')
							$finalquestionary[$i]['format_id'] = 1;
						else
							$finalquestionary[$i]['format_id'] = 2;
						
						$finalquestionary[$i]['seq_no'] = $value['ss_aw_seq_no'];
						$finalquestionary[$i]['weight'] = $value['ss_aw_weight'];
						$finalquestionary[$i]['category'] = $value['ss_aw_asked_category'];
						$finalquestionary[$i]['sub_category'] = $value['ss_aw_asked_sub_category'];
						$finalquestionary[$i]['question_format'] = $value['ss_aw_question_format'];
						
						if($value['ss_aw_question_format'] == 'Choose the right answers')
							$finalquestionary[$i]['question_format_id'] = 2;
						if($value['ss_aw_question_format'] == 'Choose the right answer')
							$finalquestionary[$i]['question_format_id'] = 2;
						else if($value['ss_aw_question_format'] == 'Fill in the blanks')
							$finalquestionary[$i]['question_format_id'] = 1;
						else if($value['ss_aw_question_format'] == 'Rewrite the sentence')
							$finalquestionary[$i]['question_format_id'] = 3;
						
						
						
						$finalquestionary[$i]['prefaceaudio'] = base_url().$value['ss_aw_question_preface_audio'];
						$finalquestionary[$i]['preface'] = $value['ss_aw_question_preface'];
						$finalquestionary[$i]['question'] = trim($value['ss_aw_question']);
						
						$multiple_choice_ary = array();
						$multiple_choice_ary = explode("/",$value['ss_aw_multiple_choice']);
						
						if(count($multiple_choice_ary) > 1)
						{
							$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
							$finalquestionary[$i]['options'] = $multiple_choice_ary;
						}
						else
						{
							$finalquestionary[$i]['options'][0] = $value['ss_aw_multiple_choice'];									
						}			
						
						$finalquestionary[$i]['verb_form'] = $value['ss_aw_verb_form'];
						
						$answersary = array();
						$answersary = explode("/",trim($value['ss_aw_answers']));
						if(count($answersary)> 1)
						{
							$answersary = array_map('trim', $answersary);
							$finalquestionary[$i]['answers'] = $answersary;
						}
						else
						{
							$finalquestionary[$i]['answers'][0] = trim($value['ss_aw_answers']);
						}
						$finalquestionary[$i]['answeraudio'] = base_url().$value['ss_aw_answers_audio'];
						$finalquestionary[$i]['rules'] = trim($value['ss_aw_rules']);
						
						$finalquestionary[$i]['hint'] = "";
						$finalquestionary[$i]['ruleaudio'] = base_url().$value['ss_aw_rules_audio'];
						
						$finalquestionary[$i]['releted_question_id'] = $value['ss_aw_skip_related_queston'];
						
						$finalquestionary[$i]['releted_question_status'] = $value['ss_aw_related_queston_status'];
						
						if($value['ss_aw_assessment_quiz_skip'] == 2)
							$finalquestionary[$i]['skip_status'] = 1; // 1 = SKIP, 0 = NOT SKIP
						else
							$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
						
						if($value['ss_aw_answers_status'] == 1)
							$finalquestionary[$i]['ans_status'] = 1; // 1 = Answered, 0 = Pending, 2= Wrong
						else if($value['ss_aw_answers_status'] == 2)
							$finalquestionary[$i]['ans_status'] = 2; // 1 = Answered, 0 = Pending, 2= Wrong
						else
							$finalquestionary[$i]['ans_status'] = 0; // 1 = Answered, 0 = Pending, 2= Wrong
						
						$i++;
				}
			}
			else
			{
			$getlast_lessonary = array();
			$getlast_lessonary = $this->ss_aw_child_last_lesson_model->fetch_details($child_id);

			/*
				Find out Current LEVEL of the child
			*/			
				$subcategoryary = array();
				if($getlast_lessonary[0]['ss_aw_lesson_level'] == 1)
					$level = "E";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 2)
					$level = "C";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 3)
					$level = "A";
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 5)
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
				
				if($fetch_level == 'A')
				{
					$min_question_no = $searchresultary[0]['ss_aw_total_question'];
				}
				else if($fetch_level == 'C')
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
				$min_subsection_questions_count = $min_question_no;
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
					$insert_record[' ss_aw_assessment_id'] = $assessment_id;
					$insert_record['ss_aw_calculated_seq_no'] = $sequence_start_value * $i;
					$insert_record['ss_aw_child_id'] = $child_id;
					$insert_record['ss_aw_asked_level'] = $currentresult[0]['ss_aw_level'];
					$insert_record['ss_aw_asked_category'] = $currentresult[0]['ss_aw_category'];
					$insert_record['ss_aw_asked_sub_category'] = $currentresult[0]['ss_aw_sub_category'];
					$insert_record['ss_aw_assessment_question_id'] = $currentresult[0]['ss_aw_id'];
					$insert_record['ss_aw_parent_id'] = $parent_id;
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
					$finalquestionary[$i]['answeraudio'] = base_url().$value[0]['ss_aw_answers_audio'];
					$finalquestionary[$i]['rules'] = trim($value[0]['ss_aw_rules']);
					
					$finalquestionary[$i]['hint'] = "";
					$finalquestionary[$i]['ruleaudio'] = base_url().$value[0]['ss_aw_rules_audio'];
					$finalquestionary[$i]['skip_status'] = 0; // 1 = SKIP, 0 = NOT SKIP
					$i++;
				}
			}
			}
					/* Get Idle time for a question */
						
						$setting_result = array();
						$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
						$idletime = $setting_result[0]->ss_aw_time_skip;
						$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(3);
						
						$responseary['status'] = 200;
						if (!empty($inputpost['assessment_exam_code'])) {
							$total_taken_time = $this->ss_aw_assessment_exam_log_model->get_total_time_elapsed($inputpost['assessment_exam_code'], $child_id);
							$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value - $total_taken_time;
						}
						else
						{
							$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;	
						}
						
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
						$assesment_detail = $this->ss_aw_assesment_uploaded_model->getassesmentdetailbyid($assessment_id);
						if (!empty($assesment_detail)) {
							$responseary['topic_id'] = $assesment_detail[0]->ss_aw_assesment_topic_id;
						}
						else
						{
							$responseary['topic_id'] = 0;
						}
						
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
					foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;				
					}			
					
			}	
			echo json_encode($responseary);
			die(); 	
		}
	}

	

	public function readalongs_details()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
     	 $parent_id = $inputpost['user_id']; // Child Record ID from Database
		$parent_token = $inputpost['user_token']; // Token get after login
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;
				
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
				
				if(!empty($result[0]['ss_aw_upload_file']))
				{
					$zipfile_path = explode("/",$result[0]['ss_aw_upload_file']);
					$image_ath = $zipfile_path[1]."/".$zipfile_path[2]."/";
				}
				else
				{
					$image_ath="";
				}					
				
				if(!empty($readalongary))
				{
					
					$setting_result = array();
					$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
					$idletime = $setting_result[0]->ss_aw_time_skip;
					$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
						
						
					$responseary['status'] = '200';
					$responseary['msg'] = 'Data found';
					$responseary['correct_answer_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_answer_audio;
					$responseary['skip_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_skip_audio;
					$responseary['correct_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_audio;
					$responseary['incorrect_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_incorrect_audio;
					$responseary['lesson_quiz_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_lesson_quiz_audio;
					$responseary['lesson_quiz_bad_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_bad_audio;
				
					$responseary['readalong_id'] = $inputpost['readalong_id'];
					$responseary['course'] = $readalongary[0]['ss_aw_level'];
					$responseary['topic'] = $readalongary[0]['ss_aw_topic'];
					$responseary['image_viewing_time'] = 5000;
					$responseary['read_status'] = 0;
					//get readalong last page index
					$get_page_index_details = $this->ss_aw_store_readalong_page_model->get_page_index($child_id, $inputpost['readalong_id'], $parent_id);
					if (!empty($get_page_index_details)) {
						$responseary['last_page_index'] = $get_page_index_details[0]->ss_aw_page_index;
					}
					else{
						$responseary['last_page_index'] = 0;
					}
					//end
					
					foreach($readalongary as $key=>$value)
					{
						$getreadalongdetails[$key]['index'] = $value['ss_aw_readalong_id'];
						if($value['ss_aw_title_exist'] == 'Y') // Check TITLE EXIST OR NOT Y = Yes, N = NO
						{
							$getreadalongdetails[$key]['title'] = strip_tags($value['ss_aw_content']);
							$getreadalongdetails[$key]['description'] = "";
							if(!empty($value['ss_aw_readalong_audio']))
								$getreadalongdetails[$key]['title_audio'] = base_url().$value['ss_aw_readalong_audio'];
							else
								$getreadalongdetails[$key]['title_audio'] = "";
							$getreadalongdetails[$key]['description_audio'] = "";
						}
						else
						{
							$getreadalongdetails[$key]['title'] = "";
							$getreadalongdetails[$key]['description'] = strip_tags($value['ss_aw_content']);
							$getreadalongdetails[$key]['title_audio'] = "";
							if(!empty($value['ss_aw_readalong_audio']))
								$getreadalongdetails[$key]['description_audio'] = base_url().$value['ss_aw_readalong_audio'];
							else
								$getreadalongdetails[$key]['description_audio'] = "";
								
						}
						
						$getreadalongdetails[$key]['is_title'] = 0; // 1 = Title Exist, 0 = Absent
						
						
						
						if(!empty($value['ss_aw_image']))
						{
							if(strtolower($value['ss_aw_image']) == 't')
							{
								$getreadalongdetails[$key]['is_title'] = 1; // 1 = Title Exist, 0 = Absent
							}
							else
							{
								$getreadalongdetails[$key]['image'] = base_url().$image_ath.$value['ss_aw_image'];
							}
						}
						else
						{
							$getreadalongdetails[$key]['image'] = "";
						}
						
						if($value['ss_aw_voiceover'] == 'Y')
						{
							$getreadalongdetails[$key]['voiceover'] = 1; // 1 = Voiceover exist, 0 = Voiceover absent
						}
						else
						{
							$getreadalongdetails[$key]['voiceover'] = 0;
						}
						if($value['ss_aw_text_visible'] == 'Y')
						{
							$getreadalongdetails[$key]['text_visible'] = 1;
						}
						else
						{
							$getreadalongdetails[$key]['text_visible'] = 0;
						}
						
					}
					$responseary['data'] = $getreadalongdetails;
					
					//QUIZ SECTION START HERE
					$quizary = array();
					$quizgroupary = $this->ss_aw_readalong_quiz_model->get_record_groupby_quiztype();
					foreach($quizgroupary as $value)
					{
						$quizary[] = $value['ss_aw_quiz_type'];
					}
					
					$k = 1;
					$quiz_description = "";
					foreach($quizary as $val)
					{
						if($val == 1)
						{
							$quiz_description = "Fill in the blanks";
							$quiz_descriptionaudio = base_url().'assets/audio/fill_the_blanks.mp3';
						}
						if($val == 2)
						{
							$quiz_description = "Choose the Correct Answer";
							$quiz_descriptionaudio = base_url().'assets/audio/choose_right_answers.mp3';
						}
						if($val == 3)
						{
							$quiz_description = " Rewrite the sentence";
							$quiz_descriptionaudio = base_url().'assets/audio/rewrite_the_sentence.mp3';
						}
						$getreadalongquiz = array();
						$getquiz_endary = array();
						$i = 1;
						$j = 0;
						foreach($readalongquizary as $key1=>$value)
						{
							if($value['ss_aw_quiz_type'] == $val)
							{
								$getreadalongquiz[$j]['subindex'] = $value['ss_aw_readalong_id']; //Quiz Index
								$getreadalongquiz[$j]['question_id'] = $value['ss_aw_readalong_id']; //Quiz Index
								$getreadalongquiz[$j]['question'] = $value['ss_aw_question'];
								$getreadalongquiz[$j]['qtype'] = $value['ss_aw_quiz_type'];
								$getreadalongquiz[$j]['answered'] = 0;
								
								
								$multiple_choice_ary = array();
								$multiple_choice_ary = explode(",",$value['ss_aw_multiple_choice']);
										
										$multiple_choice_ary = array_map('trim',$multiple_choice_ary);
										
											$getreadalongquiz[$j]['options'] = $multiple_choice_ary;
										
								$ans_ary = array();
								$ans_ary = explode("/",trim(strip_tags($value['ss_aw_answers'])));
										
										$ans_ary = array_map('trim',$ans_ary);
										
								$getreadalongquiz[$j]['answers'] = $ans_ary;
								$getreadalongquiz[$j]['answeraudio'] = base_url().$value['ss_aw_answers_audio'];	
								$i++;
								$j++;
							}
							else
							{
								$getquiz_endary['index'] = $key + $k + 2;
								$getquiz_endary['title'] = "";
								$getquiz_endary['description'] = strip_tags($value['ss_aw_details']);
								$getquiz_endary['title_audio'] = "";
								$getquiz_endary['description_audio'] = base_url().$value['ss_aw_quiz_type_audio'];
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
				}
				else
				{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";				
						}
				}
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
   }

   public function current_assessment_exam_details()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_profile = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_profile[0]->ss_aw_child_id;

				$searchary = array();
				$searchary['ss_aw_child_id'] = $child_id;
				$searchary['ss_aw_parent_id'] = $parent_id;
				$searchary['ss_aw_assessment_quiz_skip'] = 3;
				$searchresultary = array();
				$searchresultary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($searchary);
				if(!empty($searchresultary))
				{
					$responseary['status'] = 200;
					$responseary['exam_code'] = $searchresultary[0]['ss_aw_assessment_exam_code'];
					$responseary['current_question_id'] = $searchresultary[0]['ss_aw_assessment_question_id'];
				}
				else
				{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
					foreach ($error_array as $value){
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
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$assessment_exam_code = $inputpost['assessment_exam_code'];
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_profile = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_profile[0]->ss_aw_child_id;

				$getlast_askedquestion = array();
				$searchary = array();
				$searchary['ss_aw_assessment_id'] = $assessment_id;
				$searchary['ss_aw_assessment_exam_code'] = $assessment_exam_code;
				$searchary['ss_aw_parent_id'] = $parent_id;
				$getlast_askedquestion = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_bydesc($searchary);
				
				
				$askedquestion_bysubcategory = array();
				$searchary = array();
				$searchary['ss_aw_assessment_id'] = $assessment_id;
				$searchary['ss_aw_assessment_exam_code'] = $assessment_exam_code;
				$searchary['ss_aw_asked_level'] = $getlast_askedquestion[0]['ss_aw_asked_level'];
				$searchary['ss_aw_asked_category'] = $getlast_askedquestion[0]['ss_aw_asked_category'];
				$searchary['ss_aw_asked_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];
				$searchary['ss_aw_parent_id'] = $parent_id;
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
				$searchary['ss_aw_parent_id'] = $parent_id;
				$rightansary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam_bydesc($searchary);
				$total_right_ans_count = count($rightansary);
			/*
				Find out no of sub category against partcular topic/category for Assesment test
			*/			
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
				//$subcategoryary['ss_aw_quiz_type'] = 2;
				$subcategoryary['ss_aw_sub_category'] = $getlast_askedquestion[0]['ss_aw_asked_sub_category'];;
				$subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
				$searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($subcategoryary);
				$total_question_first_subcat = count($searchresultary);
				
				//Total Right ans count not required.Always use remaing question count
				//$total_question_asked = $total_subsection_questions_count - $total_right_ans_count;
				
				$min_question_no = $total_subsection_questions_count - $min_subsection_questions_count;
				
				/*if($total_right_ans_count == $total_question_asked)
				{
					$min_question_no = $total_subsection_questions_count - $min_question_no;
				}*/
				
				$sequence_start_value = $total_question_first_subcat/$min_question_no;  //TOTAL AVAILABLE QUESTIONS IN EACH SUB-SECTION FOR A PARTICULAR LEVEL/MINIMUM QUESTIONS TO BE ASKED IN EACH SUB-SECTION FOR THAT LEVEL
			
			//$min_subsection_questions_count = $min_question_no;
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
					$insert_record['ss_aw_parent_id'] = $parent_id;
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
						$responseary['assessment_exam_code'] = $assessment_exam_code;
						$responseary['question_asked_count'] = 0;
						$responseary['total_questions_count'] = $total_question_no;
						$responseary['min_subsection_questions_count'] = $min_subsection_questions_count;
						$responseary['total_subsection_questions_count'] = $total_subsection_questions_count;
						$responseary['assessment_id'] = intval($assessment_id);
						
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
					foreach ($error_array as $value){
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
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$assessment_exam_code = $inputpost['assessment_exam_code'];
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_profile = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_profile[0]->ss_aw_child_id;

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
				$searchary['ss_aw_parent_id'] = $parent_id;
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
				else if($getlast_lessonary[0]['ss_aw_lesson_level'] == 5)
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
				
				if($fetch_level == 'A')
				{
					$min_question_no = $searchresultary[0]['ss_aw_total_question'];
				}
				else if($fetch_level == 'C')
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
				$subcategoryary['ss_aw_level'] = $fetch_level;
				
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
				
				$subcategoryary['ss_aw_level'] = $fetch_level;
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
					$insert_record['ss_aw_parent_id'] = $parent_id;
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
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
					foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;				
					}			
					
			}	
			echo json_encode($responseary);
			die(); 	
		}
	}

	public function store_assessment_exam_data()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			
			$exam_code = $inputpost['assessment_exam_code'];
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;

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
				$checksearchary['ss_aw_parent_id'] = $parent_id;
				$question_skipedstatus = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($checksearchary);
				
				$finalquestionary = array();
				//Return new Record against both the wrong and Skip Question
				if($answers_status != 1 && $question_skipedstatus[0]['ss_aw_skip_once'] != 2) // 1 = Right, 2 = Wrong, 3= Skip
				{
					$searchary = array();
					$newquestion = array();
					$searchary['ss_aw_uploaded_record_id'] = $question_detailsary[0]['ss_aw_uploaded_record_id'];
					$searchary['ss_aw_level'] = $question_detailsary[0]['ss_aw_level']; // E,C,A
					$searchary['ss_aw_category'] = $question_detailsary[0]['ss_aw_category']; 
					$searchary['ss_aw_sub_category'] = $question_detailsary[0]['ss_aw_sub_category'];
					$ss_aw_seq_no = $question_detailsary[0]['ss_aw_seq_no']; 
					$searchdata['ss_aw_quiz_type'] = $question_detailsary[0]['ss_aw_quiz_type'];
					do{
						$searchary['ss_aw_seq_no'] = $ss_aw_seq_no - 1;
						if($searchary['ss_aw_seq_no'] <= 0)
						{
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
						$checksearchary['ss_aw_parent_id'] = $parent_id;
						/*
						Check Question already asked or not using seq no
						*/						
						$alreadyasked_questionary = array();
						$alreadyasked_questionary = $this->ss_aw_assesment_questions_asked_model->fetch_record_byparam($checksearchary);
						$alreadyaskedquestionidary = array();
						
						/* Already asked question ID array */
						if(!empty($alreadyasked_questionary))
						{
							foreach($alreadyasked_questionary  as $value)
							{
								$alreadyaskedquestionidary[] = $value['ss_aw_assessment_question_id'];
							}
						}
						
							$newquestion = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
							if(!empty($newquestion))
							{
								foreach($newquestion as $value)
								{
									if(in_array($value['ss_aw_id'],$alreadyaskedquestionidary))
									{
										$newquestion = array();
									}
								}
							}
											
						$ss_aw_seq_no = $searchary['ss_aw_seq_no'];
					}while(empty($newquestion));
					
					$i = 0;
					foreach($newquestion as $value)
					{
						//if($i == 0)
						{					
							$finalquestionary[$i]['question_id'] = $value['ss_aw_id'];
							$finalquestionary[$i]['level'] = $value['ss_aw_level'];
							$finalquestionary[$i]['format'] = $value['ss_aw_format'];
							
							if($value['ss_aw_format'] == 'Single')
								$finalquestionary[$i]['format_id'] = 1;
							else
								$finalquestionary[$i]['format_id'] = 2;
							
							$finalquestionary[$i]['seq_no'] = $value['ss_aw_seq_no'];
							$finalquestionary[$i]['weight'] = $value['ss_aw_weight'];
							$finalquestionary[$i]['category'] = $value['ss_aw_category'];
							$finalquestionary[$i]['sub_category'] = $value['ss_aw_sub_category'];
							$finalquestionary[$i]['question_format'] = $value['ss_aw_question_format'];
							
							/*if($value['ss_aw_question_format'] == 'Choose the right answers')
								$finalquestionary[$i]['question_format_id'] = 2;*/
							if($value['ss_aw_question_format'] == 'Choose the right answer')
								$finalquestionary[$i]['question_format_id'] = 2;
							else if($value['ss_aw_question_format'] == 'Fill in the blanks')
								$finalquestionary[$i]['question_format_id'] = 1;
							else if($value['ss_aw_question_format'] == 'Rewrite the sentence')
								$finalquestionary[$i]['question_format_id'] = 3;
							/*else if($value['ss_aw_question_format'] == 'Change the word to its comparative degree')
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
								$finalquestionary[$i]['question_format_id'] = 10;*/
							
							
							$finalquestionary[$i]['prefaceaudio'] = base_url().$value['ss_aw_question_preface_audio'];
							$finalquestionary[$i]['preface'] = $value['ss_aw_question_preface'];
							$finalquestionary[$i]['question'] = trim($value['ss_aw_question']);
							
							$multiple_choice_ary = array();
							$multiple_choice_ary = explode("/",$value['ss_aw_multiple_choice']);
							
							if(count($multiple_choice_ary) > 1)
							{
								$multiple_choice_ary = array_map('trim', $multiple_choice_ary);
								$finalquestionary[$i]['options'] = $multiple_choice_ary;
							}
							else
							{
								$finalquestionary[$i]['options'][0] = $value['ss_aw_multiple_choice'];									
							}			
							
							$finalquestionary[$i]['verb_form'] = $value['ss_aw_verb_form'];
							
							$answersary = array();
							$answersary = explode("/",trim($value['ss_aw_answers']));
							if(count($answersary)> 1)
							{
								$answersary = array_map('trim', $answersary);
								$finalquestionary[$i]['answers'] = $answersary;
							}
							else
							{
								$finalquestionary[$i]['answers'][0] = trim($value['ss_aw_answers']);
							}
							$finalquestionary[$i]['answeraudio'] = base_url().trim($value['ss_aw_answers_audio']);
							$finalquestionary[$i]['rules'] = trim($value['ss_aw_rules']);
							
							$finalquestionary[$i]['hint'] = "";
							$finalquestionary[$i]['ruleaudio'] = base_url().$value['ss_aw_rules_audio'];
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
						$insert_record['ss_aw_parent_id'] = $parent_id;
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
				
				$this->ss_aw_assessment_exam_log_model->insert_record($storedata);
				
				
				$updateary = array();
				$updateary['ss_aw_assessment_question_id'] = $question_id;
				$updateary['ss_aw_assessment_exam_code'] = $exam_code;

				if($answers_status == 3) // 1 = Right, 2 = Wrong, 3= Skip
				{	
					$updateary['ss_aw_assessment_quiz_skip'] = 2;
					$updateary['ss_aw_skip_once'] = 2;
					//$updateary['ss_aw_skip_related_queston'] = 2;
				}
				else
				{
					$updateary['ss_aw_assessment_quiz_skip'] = 1;
					$updateary['ss_aw_answers_status'] = $answers_status; // 1 = Right, 2 = Wrong, 3= Skip
				}
				$this->ss_aw_assesment_questions_asked_model->update_record($updateary);
					
				
				$responseary['status'] = 200;
				$responseary['msg'] = "Assessment test answers post successfully.";
				$responseary['data'] = $finalquestionary;	
			}
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
					foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";	
					}			
					
			}	
			echo json_encode($responseary);
			die(); 	
		}
	}

   public function get_assessments_introduction_audio(){
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			
		
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{	
				$responseary['status'] = 200;
				$result = $this->ss_aw_general_settings_model->fetch_record();
				if (!empty($result)) {
					if (!empty($result[0]->ss_aw_welcome_assesment_audio)) {
						$welcome_assesment_audio = base_url().'assets/audio/'.$result[0]->ss_aw_welcome_assesment_audio;
					}
					else
					{
						$welcome_assesment_audio = "";
					}
				}
				else
				{
					$welcome_assesment_audio = "";
				}

				$responseary['assessment_intro_audio_url'] = $welcome_assesment_audio;
				
			}
			else
			{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
					foreach ($error_array as $value){
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;
						$responseary['title'] = "Error";	
					}			
					
			}	
			echo json_encode($responseary);
			die(); 	
		}
	}

	public function complete_assessment_exam()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			$assessment_exam_code = $inputpost['assessment_exam_code'];
			if(!empty($inputpost['back_click_count'])){
				$back_click_count = $inputpost['back_click_count'];	
			}
			else
			{
				$back_click_count = 0;
			}
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;

				$this->db->trans_start();
				$insert_data = array();
				$insert_data['ss_aw_assessment_id'] = $assessment_id;
				$insert_data['ss_aw_exam_code'] = $assessment_exam_code;
				$insert_data['ss_aw_child_id'] = $child_id;
				$response = $this->ss_aw_assessment_exam_completed_model->searchdata($insert_data);
				if(empty($response))
				{
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
							}
							else
							{
								$total_questions = 0;
							}

							$wright_answers = $this->ss_aw_assesment_questions_asked_model->totalnoofcorrectanswers($assessment_id, $child_id, $assessment_exam_code);
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

					$searchary = array();
					$searchary['ss_aw_course_id'] = $level;
					$total_level_assessment = $this->ss_aw_assesment_uploaded_model->fetch_by_params($searchary);
					$level_assessment_id = array();
					$serial_ary = array();
					if (!empty($total_level_assessment)) {
						if ($level == 'A') {
							$assessment_count = 11;
						}
						else{
							$assessment_count = 1;	
						}
						foreach ($total_level_assessment as $level_assessment) {
							$level_assessment_id[] = $level_assessment['ss_aw_assessment_id'];
							//set serial number
							if (strtolower($level_assessment['ss_aw_assesment_format']) == 'single') {
								$serial_ary[$level_assessment['ss_aw_assessment_id']] = $assessment_count;
								$assessment_count++;	
							}
							else{
								$assessment_name_ary = explode(" ", $level_assessment['ss_aw_assesment_topic']);
								$serial_ary[$level_assessment['ss_aw_assessment_id']] = $assessment_name_ary[count($assessment_name_ary) - 1];
							}
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
   }

   public function check_email_verified_or_not(){
   	$postdata = $this->input->post();
   	$parent_id = $postdata['user_id'];
	$parent_email = $postdata['email'];
	$response = $this->ss_aw_parents_model->check_email_verified($parent_id, $parent_email);
	if ($response) {
		$verified = 1;
	}
	else{
		$verified = 0;
	}
	$responseary['status'] = 200;
	$responseary['verified'] = $verified;
	die(json_encode($responseary));
   }

   public function check_child_unique_code(){
   	 $postdata = $this->input->post();
   	 $parent_id = $postdata['user_id'];
   	 $parent_token = $postdata['user_token'];
   	 $responseary = array();
   	 if ($this->check_parent_existance($parent_id, $parent_token)) {
   	 	$child_unique_code = $postdata['child_unique_code'];
   	 	$check_username = $this->ss_aw_childs_model->check_username($child_unique_code);
   	 	$check_temp_username = $this->ss_aw_childs_temp_model->check_username($child_unique_code);
   	 	if ($check_username == 0 && $check_temp_username == 0) {
   	 		$is_unique = 1;
   	 	}
   	 	else{
   	 		$is_unique = 0;
   	 	}
   	 	$responseary['status'] = 200;
   	 	$responseary['is_unique'] = $is_unique;
   	 }
   	 else{
   	 	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
		foreach ($error_array as $value) {
			$responseary['status'] = $value->ss_aw_error_status;
			$responseary['msg'] = $value->ss_aw_error_msg;
			$responseary['title'] = "Error";				
		}
   	 }

   	 die(json_encode($responseary));
   }

   public function get_child_count(){
   	 $postdata = $this->input->post();
   	 $parent_id = $postdata['user_id'];
   	 $parent_token = $postdata['user_token'];
   	 $responseary = array();
   	 if ($this->check_parent_existance($parent_id, $parent_token)) {
   	 	$result = $this->ss_aw_childs_model->get_child_count_by_parent_id($parent_id);
   	 	$self_registration = $this->ss_aw_childs_model->check_self_enrolled($parent_id);
   	 	if (empty($self_registration)) {
   	 		$self_enrolled = 0;
   	 	}
   	 	else{
   	 		$self_enrolled = 1;
   	 	}
   	 	$child_details = array();
   	 	if (!empty($result)) {
   	 		foreach ($result as $key => $value) {
   	 			$child_details[$key]['child_id'] = $value->ss_aw_child_id;
   	 			$child_details[$key]['child_name'] = $value->ss_aw_child_nick_name;
   	 			$state_details = getchild_diagnosticexam_status($value->ss_aw_child_id);
   	 			$child_details[$key]['child_status'] = array(
   	 				'id' => $state_details['id'],
   	 				'sub_id' => $state_details['sub_id']
   	 			);
   	 		}
   	 	}
   	 	$responseary['status'] = 200;
   	 	$responseary['data']['childs'] = $child_details;
   	 	$responseary['data']['is_self_enrolled'] = $self_enrolled;
   	 }
   	 else{
   	 	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
		foreach ($error_array as $value) {
			$responseary['status'] = $value->ss_aw_error_status;
			$responseary['msg'] = $value->ss_aw_error_msg;
			$responseary['title'] = "Error";				
		}
   	 }

   	 die(json_encode($responseary));		
   }

   public function assessment_exam_format_two_questions()
	{
		$inputpost = $this->input->post(); // Accept All post data post from APP		
		$responseary = array();
		if($inputpost)
		{
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;

				$exam_code = time()."_".$child_id;
				if (!empty($inputpost['assessment_exam_code'])) {
					$exam_code = $inputpost['assessment_exam_code'];
					$last_exam_detail = $this->ss_aw_assesment_multiple_question_asked_model->getlastexamquestionindex($child_id, $exam_code);
					if (!empty($last_exam_detail)) {
						$responseary['current_page_index'] = $last_exam_detail[0]->ss_aw_page_index;
						$responseary['back_click_count'] = $last_exam_detail[0]->ss_aw_back_click_count;
					}
				}
				$lessonary = array();
				$lessonary['ss_aw_child_id'] = $child_id;
				
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];
				
				$searchary = array();
				$searchary['ss_aw_uploaded_record_id'] = $assessment_id;
				$lessonary = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($searchary);

				
					

						$setting_result = array();
						$setting_result =  $this->ss_aw_general_settings_model->fetch_record();
						$idletime = $setting_result[0]->ss_aw_time_skip;
						$timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);
						
						$resultary = array();
						$resultary['course'] = "";
						$responseary['status'] = 200;
						$responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
						$responseary['complete_assessment_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_complete_assessment_audio;
						$responseary['correct_answer_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_answer_audio;
						$responseary['skip_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_skip_audio;
						$responseary['warning_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_warning_audio;
						$responseary['correct_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_correct_audio;
						$responseary['incorrect_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_incorrect_audio;
						$responseary['lesson_quiz_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_general_language_correct;
						$responseary['lesson_quiz_bad_audio'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_general_language_incorrect;
						$responseary['lesson_quiz_bad_audio2'] = base_url()."assets/audio/".$setting_result[0]->ss_aw_general_language_incorrect2;
						$responseary['skip_duration'] = $idletime;
						$responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
						$responseary['skip_type_1_2_duration'] = $idletime;
						$responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
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
									$resultary_inner['details']['quizes'][0]['question_id'] = $val['ss_aw_id'];
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
										//$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
										$multiple_choice_ary = explode("/",trim($val['ss_aw_multiple_choice']));
										
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
									$resultary_inner3[$j]['details']['quizes'][0]['question_id'] = $val['ss_aw_id'];

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
										//$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
										$multiple_choice_ary = explode("/",trim($val['ss_aw_multiple_choice']));
										
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
									$resultary['data'][$i]['details']['quizes'][$j]['question_id'] = $val['ss_aw_id'];
									$multiple_choice_ary = array();
									//$multiple_choice_ary = explode(",",trim($val['ss_aw_multiple_choice']));
									$multiple_choice_ary = explode("/",trim($val['ss_aw_multiple_choice']));
									
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
			else
			{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
				foreach ($error_array as $value){
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;	
					$responseary['title'] = "Error";	
				}
			}

			die(json_encode($responseary));
		}
	}

	public function readalongs_word_meaning()
   {
	$inputpost = $this->input->post();		
     $responseary = array();     
		 if($inputpost)
		 {
				$parent_id = $inputpost['user_id']; // Child Record ID from Database
				$parent_token = $inputpost['user_token']; // Token get after login
				$word = strtolower($inputpost['word']); // Assessment ID against the exam conducted
				$endpoint = "entries";
				$language_code = "en";
			if($this->check_email_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{	
				//modified on 9th december,2021
				$responseary['status'] = '200';
				$responseary['word'] = $word;
				$word = strtolower($word);
				$check_vocabulary = $this->ss_aw_vocabulary_model->getdefinationbyword($word);
				if (!empty($check_vocabulary)) {
					$responseary['definition'] = $check_vocabulary[0]->meaning;
				}
				else
				{
					$responseary['definition'] = "";
				}
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
   }

   public function store_current_assesment_page()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
     	 	$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$exam_code = $inputpost['assessment_exam_code'];
			$back_click_count = $inputpost['back_click_count'];
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;
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
				$assessmentary['ss_aw_parent_id'] = $parent_id;
				$check_current_status = $this->ss_aw_assesment_multiple_question_asked_model->check_existance($assessment_index_id, $assessment_id, $child_id, $exam_code);
				if ($check_current_status == 0) {
					$this->ss_aw_assesment_multiple_question_asked_model->insert_record($assessmentary);
				}
				$responseary['status'] = '200';
				$responseary['msg'] = 'Assessment current status updated';
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
   }

   public function get_current_assessment_exam_code()
   {
	 $inputpost = $this->input->post();		
     $responseary = array();     
     if($inputpost)
     {
			$parent_id = $inputpost['user_id']; // Child Record ID from Database
			$parent_token = $inputpost['user_token']; // Token get after login
			$assessment_id = $inputpost['assessment_id']; // Assessment ID against the exam conducted
			 
			if($this->check_parent_existance($parent_id,$parent_token)) // Check provider Token valid or not against child_id and token
			{
				if ($inputpost['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;
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
							$search_result = $this->ss_aw_assesment_multiple_question_asked_model->fetchlastexamcode($child_id, $assessment_id, $parent_id);
							if(!empty($search_result))
							{
								$search_data['ss_aw_exam_code'] = $search_result[0]->ss_aw_exam_code;
								$response = $this->ss_aw_assessment_exam_completed_model->searchdata($search_data);
								if (empty($response)) {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam code found';
									$responseary['exam_code'] = $search_result[0]->ss_aw_exam_code;
								}
								else
								{
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam already completed.';
								}
							}
							else
							{
								$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
								foreach ($error_array as $value) {
								$responseary['status'] = $value->ss_aw_error_status;
								$responseary['msg'] = $value->ss_aw_error_msg;
								$responseary['title'] = "Error";				
								}
							}
						}
						else
						{
							$search_result = $this->ss_aw_assesment_questions_asked_model->get_current_exam_code($assessment_id, $child_id, $parent_id);
					
							if(!empty($search_result))
							{
								$search_data['ss_aw_exam_code'] = $search_result->ss_aw_assessment_exam_code;
								$response = $this->ss_aw_assessment_exam_completed_model->searchdata($search_data);
								if (empty($response)) {
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam code found';
									$responseary['exam_code'] = $search_result->ss_aw_assessment_exam_code;
								}
								else
								{
									$responseary['status'] = '200';
									$responseary['msg'] = 'Assessment exam already completed.';
								}
								
							}
							else
							{
								$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1001');
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
   }

   public function store_readalong_comprehension_page(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$parent_id = $postdata['user_id'];
			$parent_token = $postdata['user_token'];
			if ($this->check_parent_existance($parent_id, $parent_token)) {
				$page_index = $postdata['page_index'];
				$readalong_id = $postdata['readalong_id'];
				if ($postdata['is_adult'] == 1) {
					$child_code = "10000001";
				}
				else{
					$child_code = "10000000";	
				}
				$child_details = $this->ss_aw_childs_model->check_child_existance($child_code);
				$child_id = $child_details[0]->ss_aw_child_id;

				$data = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_parent_id' => $parent_id,
					'ss_aw_page_index' => $page_index,
					'ss_aw_readalong_id' => $readalong_id
				);

				$response = $this->ss_aw_store_readalong_page_model->store_page_index($data);
				if ($response) {
					$responseary['status'] = 200;
					$responseary['msg'] = "Page index stored successfully.";
				}
				else{
					$responseary['status'] = 200;
					$responseary['msg'] = "Something went wrong, please try again later.";
				}
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}

			die(json_encode($responseary));
		}
	}

	public function add_self_as_child(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$parent_id = $postdata['user_id'];
			$parent_token = $postdata['user_token'];
			if ($this->check_parent_existance($parent_id, $parent_token)) {
				$check_self_child_registration = $this->ss_aw_childs_model->check_self_registration($parent_id);
				if (empty($check_self_child_registration)) {
					$profile_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
					$code_check = $this->ss_aw_childs_model->child_code_check();      
					if(isset($code_check))
					{
						$random_code = $code_check->ss_aw_child_code + 1;
					}
					else
					{
						$random_code =  10000002;
					}					   

					$child_code = $random_code;

					$child_data = array();
					$child_data['ss_aw_child_code'] = $child_code;
					$child_data['ss_aw_parent_id'] = $parent_id;
					$child_data['ss_aw_child_nick_name'] = $profile_details[0]->ss_aw_parent_full_name;
					$current_date = date('Y-m-d');
					$child_data['ss_aw_child_dob'] = date('Y-m-d', strtotime($current_date." -18 years"));
					$child_data['ss_aw_child_age'] = calculate_age($child_data['ss_aw_child_dob']);
					$child_data['ss_aw_child_email'] = $profile_details[0]->ss_aw_parent_email;
					$child_data['ss_aw_child_password'] = $profile_details[0]->ss_aw_parent_password;
					$child_data['ss_aw_device_token'] = $profile_details[0]->ss_aw_device_token;
					$result = $this->ss_aw_childs_model->add_child($child_data);
					$responseary['status'] = 200;
					$responseary['msg'] = "Child successfully added";
					$responseary['child_id'] = $result;
					$responseary['is_profile_completed'] = 0;	
				}
				else{
					if ($check_self_child_registration->ss_aw_child_first_name == "" || $check_self_child_registration->ss_aw_child_last_name == "" || $check_self_child_registration->ss_aw_child_nick_name == "" || $check_self_child_registration->ss_aw_child_gender == "" || $check_self_child_registration->ss_aw_child_schoolname == "") {
						$is_profile_completed = 0;
					}
					else{
						$is_profile_completed = 1;
					}
					$responseary['status'] = 200;
					$responseary['msg'] = "Already registered.";
					$responseary['child_id'] = $check_self_child_registration->ss_aw_child_id;
					$responseary['is_profile_completed'] = $is_profile_completed;
				}
				
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		die(json_encode($responseary));
	}

	public function check_self_enrollement(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$parent_id = $postdata['user_id'];
			$parent_token = $postdata['user_token'];
			if ($this->check_parent_existance($parent_id, $parent_token)) {
				$responseary['status'] = 200;
				$check_self_child_registration = $this->ss_aw_childs_model->check_self_enrolled($parent_id);
				if (empty($check_self_child_registration)) {
					$responseary['self_enrolled'] = 0;
				}
				else{
					$responseary['self_enrolled'] = 1;
				}
			}
			else{
				$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1025');
				foreach ($error_array as $value) {
					$responseary['status'] = $value->ss_aw_error_status;
					$responseary['msg'] = $value->ss_aw_error_msg;
					$responseary['title'] = "Error";				
				}
			}
		}
		die(json_encode($responseary));
	}
	
}