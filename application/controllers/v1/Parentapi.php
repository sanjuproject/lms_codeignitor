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
	}
	public function signup()
	{
		$inputpost = $this->input->post();
		$responseary = array();
		if($inputpost){
			$email = $inputpost['email'];
			$primary_mobile = $inputpost['primary_mobile'];
			$device_type = $inputpost['os'];
			$referrer = $inputpost['referrer'];
			if($this->check_email_existance($email))
			{ 
                
                if($this->check_mobile_existance($primary_mobile))
                {
					
                	//$check_temp_parent_tbl = $this->ss_aw_parents_temp_model->email_existance($email);
                	//$check_temp_parent_tbl_mob = $this->ss_aw_parents_temp_model->mobile_existance($primary_mobile);
				  //if(!$check_temp_parent_tbl)
				 // {
              		
					//if(!$check_temp_parent_tbl_mob)
              		//{
              			$image = "";	
						if(isset($_FILES["profile_pic"]['name']))
						{
							$image = time().'.'.$_FILES["profile_pic"]['name'];
							
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
							$image = $data['file_name'];
						}			
									

							$password = $inputpost['password'];
							$hash_pass = @$this->bcrypt->hash_password($password);
							$signupary = array();
							$signupary['ss_aw_parent_full_name'] = $inputpost['fullname'];					
							$signupary['ss_aw_parent_primary_mobile'] = $inputpost['primary_mobile'];	
							$signupary['ss_aw_parent_country_code'] = $inputpost['country_code'];	
							if(!empty($inputpost['country_sort_name']))
								$signupary['ss_aw_parent_country_sort_name'] = $inputpost['country_sort_name']; // IN = India, BD = Bangladesh
							$signupary['ss_aw_parent_email'] = $email;
							$signupary['ss_aw_parent_password'] = $hash_pass;
							$signupary['ss_aw_parent_profile_photo'] = $image;

							$otp = rand(100000,999999);
							$signupary['ss_aw_parent_otp']= $otp;
				
						
						$userid = $this->ss_aw_parents_temp_model->data_insert($signupary);
						
						/*$msg = "Otp for activate your account is: ".$otp;
						$subject = "Active account code";
							// use wordwrap() if lines are longer than 70 characters
							/*$msg = wordwrap($msg,70);

							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

							$headers .= "From: team <deepanjan.das@gmail.com>";
									

							// send email
						mail($email,$subject,$msg,$headers);
						
						sendmail($msg,$subject,$email);*/
						
						$this->activate_account($email,$otp,$password,$device_type,$referrer);

              		//}
              		/*else
              		{
              			$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1022');
						foreach ($error_array as $value) {
						$responseary['status'] = $value->ss_aw_error_status;
						$responseary['msg'] = $value->ss_aw_error_msg;				
						$responseary['title'] = "Error";				
						}

              		}*/
              	
				  //}
				  /*else
				  {

					$password = $inputpost['password'];
					$hash_pass = $this->bcrypt->hash_password($password);
					$updateary = array();
					$updateary['ss_aw_parent_full_name'] = $inputpost['fullname'];					
					$updateary['ss_aw_parent_primary_mobile'] = $inputpost['primary_mobile'];
					$updateary['ss_aw_parent_country_code'] = $inputpost['country_code'];
					
					$updateary['ss_aw_parent_password'] = $hash_pass;
					$updateary['ss_aw_parent_modified_date'] = date('Y-m-d H:i:s');

					

					$otp = rand(100000,999999);
					$updateary['ss_aw_parent_otp']= $otp;

				
					$this->ss_aw_parents_temp_model->data_update($updateary,$email);
					/*$msg = "Otp for activate your account is: ".$otp;
					$subject = "Active account code";*/
						// use wordwrap() if lines are longer than 70 characters
						/*$msg = wordwrap($msg,70);	

						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

						$headers .= "From: team <deepanjan.das@gmail.com>";
								

						// send email
					mail($email,$subject,$msg,$headers);
					*/
					//sendmail($msg,$subject,$email);
					//$responseary['status'] = 200;
					
					//$responseary['msg'] = "Signup Successful.Please active your Account";
					//$responseary['otp'] = $otp;              	
					//	$this->activate_account($email,$otp);
				  //}

                }
                else
                {
                	$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1026');
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
		$responseary = array();
		$dataary['ss_aw_parent_email'] = $email;
		$searchdataary = array();
		
		$searchdataary = $this->ss_aw_parents_model->search_byparam($dataary);
		
		if(!empty($searchdataary))
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
				$subject = "team parent user email valification";
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
					emailnotification($email, $email_template['title'], $body);
				}
			
			$status = 1;
			$responseary['status'] = 200;
			$responseary['msg'] = "Email valification code send to your email address.";
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
				$subject = "team parent primary mobile no valification";
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
					$signupary['ss_aw_parent_primary_mobile'] = $value['ss_aw_parent_primary_mobile'];		
					$signupary['ss_aw_parent_email'] = $value['ss_aw_parent_email'];	
					$signupary['ss_aw_parent_password'] = $value['ss_aw_parent_password']; 
					$signupary['ss_aw_parent_profile_photo'] = $value['ss_aw_parent_profile_photo'];
					$signupary['ss_aw_parent_country_code'] = $value['ss_aw_parent_country_code'];
					if(!empty($value['ss_aw_parent_country_sort_name']))
						$signupary['ss_aw_parent_country_sort_name'] = $value['ss_aw_parent_country_sort_name'];
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
						emailnotification($signupary['ss_aw_parent_email'], $email_template['title'], $body);
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

					$headers .= "From: team <deepanjan.das@gmail.com>";
						

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
							emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body);
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
								$child_data['ss_aw_child_mobile']= $inputpost['child_moblie'];
								$child_data['ss_aw_child_country_code']= $inputpost['country_code'];
								if(!empty($inputpost['country_sort_name']))
									$child_data['ss_aw_child_country_sort_name']= $inputpost['country_sort_name'];
									
								$child_data['ss_aw_child_password']= $hash_pass;
								$result = $this->ss_aw_childs_model->add_child($child_data);
								$responseary['status'] = 200;
					            $responseary['msg'] = "Child successfully added";
					            $responseary['child_code'] = $child_code;
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
							$child_data['ss_aw_child_mobile']= $inputpost['child_moblie'];
							$child_data['ss_aw_child_country_code']= $inputpost['country_code'];
							if(!empty($inputpost['country_sort_name']))
								$child_data['ss_aw_child_country_sort_name']= $inputpost['country_sort_name'];
							$child_data['ss_aw_child_password']= $hash_pass;
							$result = $this->ss_aw_childs_model->add_child($child_data);
							$responseary['status'] = 200;
					        $responseary['msg'] = "Child successfully added";
					        $responseary['child_code'] = $child_code;
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
						$child_data['ss_aw_child_mobile']= $inputpost['child_moblie'];
						$child_data['ss_aw_child_country_code']= $inputpost['country_code'];
						if(!empty($inputpost['country_sort_name']))
							$child_data['ss_aw_child_country_sort_name']= $inputpost['country_sort_name'];
						$child_data['ss_aw_child_password']= $hash_pass;
						$result = $this->ss_aw_childs_model->add_child($child_data);
						$responseary['status'] = 200;
				        $responseary['msg'] = "Child successfully added";
				        $responseary['child_code'] = $child_code;

		            }
								
					$email_template = getemailandpushnotification(1, 1, 2);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@username@@]", $inputpost['child_nick_name'], $body);
						$send_data = array(
							'ss_aw_email' => $child_data['ss_aw_child_email'],
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
						//emailnotification($child_data['ss_aw_child_email'], $email_template['title'], $body);
					}

					//send diagnostic invitation.
					$email_template = getemailandpushnotification(2, 1, 2);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@username@@]", $inputpost['child_nick_name'], $body);
						$body = str_ireplace("[@@login_id@@]", $child_code, $body);
						$password_line = 'And your password is <strong><span style="color:#ff0000">'.$child_password.'</span></strong>';
						$body = str_ireplace("[@@password@@]", $password_line, $body);
						$send_data = array(
							'ss_aw_email' => $child_data['ss_aw_child_email'],
							'ss_aw_subject' => $email_template['title'],
							'ss_aw_template' => $body,
							'ss_aw_type' => 1
						);
						$this->ss_aw_email_que_model->save_record($send_data);
					}
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
				$child_data['ss_aw_child_mobile']= $inputpost['child_moblie'];
				$child_data['ss_aw_child_country_code']= $inputpost['country_code'];
				if(!empty($inputpost['country_sort_name']))
					$child_data['ss_aw_child_country_sort_name']= $inputpost['country_sort_name'];
				$child_data['ss_aw_child_password']= $hash_pass;
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
							$send_data = array(
								'ss_aw_email' => $child_details[0]->ss_aw_child_email,
								'ss_aw_subject' => $email_template['title'],
								'ss_aw_template' => $body,
								'ss_aw_type' => 1
							);
							$this->ss_aw_email_que_model->save_record($send_data);

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
									'ss_aw_payment_type' => $inputpost['emi_payment']
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
									$today_date = date('Y-m-d', strtotime($today_date. ' + 1 month'));
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
										'ss_aw_payment_type' => $inputpost['emi_payment']
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
											'ss_aw_payment_type' => $inputpost['emi_payment']
										);

										$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
									}
									$count++;
								}
							}
							else{
								if ($course_id == 1) {
									$fixed_course_duration = 105;
									$course_duration = 105; //in days
								}
								elseif ($course_id == 2) {
									$fixed_course_duration = 175;
									$course_duration = 175;
								}
								else{
									$fixed_course_duration = 210;
									$course_duration = 210;
								}

								
								$today = date('d');
								
								$count = 0;
								while ($course_duration != 0) {
									if ($count == 0) {
										$today_date = date('Y-m-d');
										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = date('d');
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;		
									}
									else{
										$today_date = date('Y-m-d');
										$today_date = date('Y-m-d', strtotime($today_date. ' + '.$count.' month'));
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
										'ss_aw_payment_type' => $inputpost['emi_payment']
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
					$responseary['msg'] = "Purchase new course successfully done.";

					if (empty($inputpost['promoted'])) {
						$parent_detail = $this->ss_aw_parents_model->get_parent_profile_details($parent_id, $parent_token);
						$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);

						//send notification code
						if ($course_id == 1) {
							$course_name = "Emerging";
						}
						elseif ($course_id == 2) {
							$course_name = "Consolating";
						}
						else{
							$course_name = "Advance";
						}

						if (!empty($child_details)) {
							if ($course_id == 1) {
								$email_template = getemailandpushnotification(7, 1, 2);
								$app_template = getemailandpushnotification(7, 2, 2);
								$action_id = 9;
							}
							elseif ($course_id == 2) {
								$email_template = getemailandpushnotification(32, 1, 2);
								$app_template = getemailandpushnotification(32, 2, 2);
								$action_id = 10;
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
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
								emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
							}

							if (!empty($app_template)) {
								$body = $app_template['body'];
								$body = str_ireplace("[@@course_name@@]", $course_name, $body);
								$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
								$body = str_ireplace("[@@month_date@@]", $month_date, $body);
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
						
						if (!empty($parent_detail)) {

							$email_template = getemailandpushnotification(6, 1, 1);
							if (!empty($email_template)) {
								$body = $email_template['body'];
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
								emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
							}

							$app_template = getemailandpushnotification(6, 2, 1);
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
			 $course_id = $inputpost['course_id']; 
			
			if($this->check_parent_existance($parent_id,$parent_token))
				{
					$searary = array();
					$searary['ss_aw_course_id'] = $course_id;
					$courseary = $this->ss_aw_courses_model->search_byparam($searary);
					
					$level = $courseary[0]['ss_aw_course_id'];
					$resultary = array();
					$resultary = $this->ss_aw_lessons_uploaded_model->get_lessonlist_bylevel($level);
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
						/*$responseary['result']['actual_course_price'] = str_replace(",","",$val['ss_aw_course_price']);
						$responseary['result']['course_price'] = ((str_replace(",","",$val['ss_aw_course_price']) * (100 + str_replace("%","",$val['ss_aw_gst_rate'])))/100) + 0;*/
						$course_price_with_gst = str_replace(",","",$val['ss_aw_course_price']);
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
                     	if ($course_id == 1) {
			                $readalong_count = EMERGING_READALONG;
			            }
			            elseif ($course_id == 2) {
			                $readalong_count = CONSOLATING_READALONG;
			            }
			            else{
			                $readalong_count = ADVANCED_READALONG;
			            }
                     	$responseary['result']['readalong'] = $readalong_count;	      
					
						
						
						
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
				emailnotification_disputes('support@team.com', 'Disputes', $html);
			 
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
									$responseary['result'][$i]['readalong'] = $readalong_count;
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
				if ($level == 1) {
					$level_text = "E";
					$course_name = "Emerging";
				}
				elseif ($level == 2) {
					$level_text = "C";
					$course_name = "Consolating";
				}
				else{
					$level_text = "A";
					$course_name = "Advance";
				}

				$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
				$supplymentary_ary = explode(",", $course_id);
				$topic_list = $this->ss_aw_supplymentary_uploaded_model->get_topiclist_bylevel($supplymentary_ary);
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
				if (!empty($parent_detail)) {

					$email_template = getemailandpushnotification(39, 1, 1);
					if (!empty($email_template)) {
						$body = $email_template['body'];
						$body = str_ireplace("[@@course_name@@]", $course_name, $body);
						emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
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
							if($last_course_id == 1)
							{
								$suggested_course_id = 2;
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
								  $responseary['result'][$n]['readalong'] = $result_arrr[$n][0]['ss_aw_readalong'];	          			 

									$n++;					
								}
							}
							else if($last_course_id == 2)
							{
								$suggested_course_id = 3;
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
			if($this->check_parent_existance($parent_id,$parent_token)){
				$childary = $this->ss_aw_child_course_model->get_details($child_id);
				if (!empty($childary)) {
					$level = $childary[count($childary) - 1]['ss_aw_course_id'];
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
						if ($value->ss_aw_selected_course_id == 1) {
							$course_name = "Emerging";
						}
						elseif ($value->ss_aw_selected_course_id == 2) {
							$course_name = "Consolidated";
						}
						else
						{
							$course_name = "Advanced";
						}
						$payment_details[$key]['description'] = "You have successfully purchased ".$course_name." course.";
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
									'ss_aw_payment_type' => $inputpost['emi_payment']
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
									$today_date = date('Y-m-d', strtotime($today_date. ' + 1 month'));
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
										'ss_aw_payment_type' => $inputpost['emi_payment']
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
											'ss_aw_payment_type' => $inputpost['emi_payment']
										);

										$this->ss_aw_reporting_revenue_model->store_data($reporting_revenue_data);
									}
									$count++;
								}
							}
							else{
								if ($course_id == 1) {
									$fixed_course_duration = 105;
									$course_duration = 105; //in days
								}
								elseif ($course_id == 2) {
									$fixed_course_duration = 175;
									$course_duration = 175;
								}
								else{
									$fixed_course_duration = 210;
									$course_duration = 210;
								}

								
								$today = date('d');
								
								$count = 0;
								while ($course_duration != 0) {
									if ($count == 0) {
										$today_date = date('Y-m-d');
										$month = date('m', strtotime($today_date));
										$year = date('Y', strtotime($today_date));
										$today = date('d');
										$days_current_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
										$remaing_days = $days_current_month - $today;		
									}
									else{
										$today_date = date('Y-m-d');
										$today_date = date('Y-m-d', strtotime($today_date. ' + '.$count.' month'));
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
										'ss_aw_payment_type' => $inputpost['emi_payment']
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
			$responseary['msg'] = "Purchase new course successfully done.";

			$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
			//send notification code
			if ($course_id == 1) {
				$course_name = "Emerging";
			}
			elseif ($course_id == 2) {
				$course_name = "Consolating";
			}
			else{
				$course_name = "Advance";
			}
			if (!empty($parent_detail)) {

				$email_template = getemailandpushnotification(6, 1, 1);
				if (!empty($email_template)) {
					$body = $email_template['body'];
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
					emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
				}

				$app_template = getemailandpushnotification(6, 2, 1);
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

					pushnotification($title,$body,$token);

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

					
			if (!empty($child_details)) {
				$email_template = getemailandpushnotification(8, 1, 2);
				if (!empty($email_template)) {
					$body = $email_template['body'];
					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
					$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
					emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
				}

				$app_template = getemailandpushnotification(8, 2, 2);
				if (!empty($app_template)) {
					$body = $app_template['body'];
					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
					$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
					$title = $app_template['title'];
					$token = $child_details[0]->ss_aw_device_token;

					pushnotification($title,$body,$token,9);

					$save_data = array(
						'user_id' => $child_details[0]->ss_aw_child_id,
						'user_type' => 2,
						'title' => $title,
						'msg' => $body,
						'status' => 1,
						'read_unread' => 0,
						'action' => 9
					);

					save_notification($save_data);
				}

				$this->ss_aw_childs_model->logout($child_details[0]->ss_aw_child_id);
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
			if ($course_id == 1) {
				$level_text = "E";
				$course_name = "Emerging";
			}
			elseif ($course_id == 2) {
				$level_text = "C";
				$course_name = "Consolating";
			}
			else{
				$level_text = "A";
				$course_name = "Advance";
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

				$email_template = getemailandpushnotification(39, 1, 1);
				if (!empty($email_template)) {
					$body = $email_template['body'];
					$body = str_ireplace("[@@course_name@@]", $course_name, $body);
					emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $body,'',$payment_invoice_file_path);
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
				$responseary['status'] = 200;
				if (!empty($childary)) {
					$responseary['msg'] = "Course purchased.";
					$responseary['data']['course_purchase'] = 1;
				}
				else{
					$responseary['msg'] = "Course not purchased.";
					$responseary['data']['course_purchase'] = 0;
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

	public function check_coupon_availability(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$userid = $postdata['user_id'];
			$token = $postdata['user_token'];
			$coupon_code = $postdata['coupon_code'];
			$child_id = $postdata['child_id'];
			$responseary = array();
			if ($this->check_parent_existance($userid, $token)) {
				$check_coupon_availability = $this->ss_aw_coupons_model->check_coupon_availability($coupon_code);
				if (!empty($check_coupon_availability)) {
					$coupon_id = $check_coupon_availability[0]->ss_aw_id;
					$check_user_send_details = $this->ss_aw_manage_coupon_send_model->check_coupon_assign($coupon_id, $userid);
					$check_previous_use = $this->ss_aw_payment_details_model->check_coupon_use($userid, $coupon_code);
					
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
				if (!empty($previous_course)) {
					$check_promotion = $this->ss_aw_promotion_model->get_promotion_detail($child_id, $previous_course);
					if ($previous_course == "E") {
						$previous_course_id = 1;
					}
					elseif ($previous_course == "C") {
						$previous_course_id = 2;
					}
					if (!empty($check_promotion)) {
						if ($previous_course_id == 2) {
							$duration = 9;
						}

						$searchary = array(
							'ss_aw_parent_id' => $userid,
							'ss_aw_child_id' => $child_id,
							'ss_aw_selected_course_id' => $previous_course_id
						);

						$count_previous_emi = $this->ss_aw_purchase_courses_model->search_byparam($searchary);
						if (!empty($count_previous_emi)) {
							foreach ($count_previous_emi as $key => $value) {
								$emi_paid_date[] = date('Y-m-d', strtotime($value['ss_aw_course_created_date']));
							}
						}
						$total_complete_emi_count = $total_complete_emi_count + count($count_previous_emi);
						if (!empty($count_previous_emi)) {
							$first_emi_date = date('Y-m-d', strtotime($count_previous_emi[0]['ss_aw_course_created_date']));
							$first_emi_price = $count_previous_emi[0]['ss_aw_course_payment'];
						}
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
				}

				$total_complete_emi_count = $total_complete_emi_count + count($count_previous_emi);
				if (!empty($count_previous_emi) && empty($first_emi_date)) {
					$first_emi_date = date('Y-m-d', strtotime($count_previous_emi[0]['ss_aw_course_created_date']));
				}
				else{
					$first_emi_date = date('Y-m-d');
				}

				// end of checking
				if ($course_id == 1) {
					$duration = EMERGING_EMI_DURATION;
				}
				elseif ($course_id == 2) {
					$duration = CONSOLIDATED_EMI_DURATION;
				}
				else{
					if ($duration == 0) {
						$duration = ADVANCED_EMI_DURATION;	
					}
				}

				if (!empty($check_promotion)) {
					$search_data = array(
						'ss_aw_course_id' => $previous_course_id
					);

					if ($previous_course_id == 1) {
						$devide_duration = EMERGING_EMI_DURATION;
					}
					elseif ($previous_course_id == 2) {
						$devide_duration = CONSOLIDATED_EMI_DURATION;
					}
					else{
						if ($duration == 0) {
							$devide_duration = ADVANCED_EMI_DURATION;	
						}
						else{
							$devide_duration = $duration;
						}
					}

				}
				else{
					$search_data = array(
						'ss_aw_course_id' => $course_id
					);
					$devide_duration = $duration;	
				}
				
				$course_details = $this->ss_aw_courses_model->search_byparam($search_data);
				$gst_rate = str_replace("%","",$course_details[0]['ss_aw_gst_rate']) + 0;
				if (!empty($first_emi_price)) {
					$actual_course_price = $first_emi_price;
				}
				else{
					$actual_course_price = str_replace(",","",$course_details[0]['ss_aw_installment_price']);	
				}
				
				$price_per_month = $actual_course_price / $devide_duration;
				$price_per_month = number_format($price_per_month, 2);
				$course_price_with_gst = str_replace(",", "", $price_per_month);
				$course_price_with_gst = (float)$course_price_with_gst;
				$course_price = ($course_price_with_gst * 100) / (100 + $gst_rate);
				$course_price = number_format($course_price, 2);
				$course_price = str_replace(",", "", $course_price);
				$course_price = (float)$course_price;
				/*$course_price = ((str_replace(",","",$price_per_month) * (100 + str_replace("%","",$course_details[0]['ss_aw_gst_rate'])))/100) + 0;
				$course_price = number_format($course_price, 2);*/
				$responseary = array();
				$responseary['status'] = 200;
				$responseary['msg'] = "Fetched emi list.";
				$search_data = array(
					'ss_aw_course_id' => $course_id
				);
				$original_course_details = $this->ss_aw_courses_model->search_byparam($search_data);
				$responseary['course_name'] = $original_course_details[0]['ss_aw_course_name'];

				$count = 0;
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

	public function accept_promotion(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$user_id = $postdata['user_id'];
			$user_token = $postdata['user_token'];
			$pre_course_id = $postdata['course_id'];
			$child_id = $postdata['child_id'];
			if ($this->check_parent_existance($user_id, $user_token)) {
				//update child promotional record
				if ($pre_course_id == 1) {
					$course_id = 2;
				}
				elseif ($pre_course_id == 2) {
					$course_id = 3;
				}
				$promotion_details = $this->ss_aw_promotion_model->check_rejection($child_id, $pre_course_id);
				$invitation_lesson_num = $promotion_details[0]->ss_aw_lesson_num;
				$searchary = array(
					'ss_aw_child_id' => $child_id,
					'ss_aw_lesson_level' => $pre_course_id
				);
				$count_complete_lesson = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($searchary);

				if (($promotion_details[0]->status == 0) && (count($count_complete_lesson) == $invitation_lesson_num)) {
					$searary = array();
					$searary['ss_aw_child_id'] = $child_id;
					$searary['ss_aw_course_id'] = $course_id;

					$courseary = $this->ss_aw_child_course_model->updaterecord_child($child_id, $searary);

					$update_payment_record = array();
					$update_payment_record['ss_aw_selected_course_id'] = $course_id;
					$this->ss_aw_purchase_courses_model->update_record($child_id, $update_payment_record);
						
					{
						$previous_course = "";
						if ($course_id == 2) {
							$previous_course = "E";	
							$promoted_course = "C";
						}
						elseif ($course_id == 3) {
							$previous_course = "C";
							$promoted_course = "A";	
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

								if ($previous_course == 'E') {
									$previous_course_code = 1;
									$current_course_name = "Emerging";
									$promoted_course_name = "Consolating";
								}
								elseif ($previous_course == 'C') {
									$previous_course_code = 2;
									$current_course_name = "Consolating";
									$promoted_course_name = "Advanced";
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

								//send promotion confirmation notifications to parent
								$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
								$child_name = $child_details[0]->ss_aw_child_nick_name;
								$gender = $child_details[0]->ss_aw_child_gender;
								if ($gender == 1) {
									$g = "his";	
								}
								else{
									$g = "her";
								}
								if (!empty($child_details)) {
									if ($course_id == 2) {
										$email_template = getemailandpushnotification(41, 1, 2);
										$app_template = getemailandpushnotification(41, 2, 2);
										$action_id = 40;		
									}
									elseif ($course_id == 3) {
										$email_template = getemailandpushnotification(42, 1, 2);
										$app_template = getemailandpushnotification(42, 2, 2);
										$action_id = 43;	
									}

									$title = "Student Promotion Confirmation";

									if (!empty($email_template)) {
										$body = $email_template['body'];
										$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
										$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
										emailnotification($child_details[0]->ss_aw_child_email, $title, $body);
									}

									if (!empty($app_template)) {
										$body = $app_template['body'];
										$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
										$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
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
								}

								$parent_detail = $this->ss_aw_childs_model->get_parent_email_device_token_by_child_id($child_id);
								if ($course_id == 2) {
									$email_template = getemailandpushnotification(37, 1, 1);
									$app_template = getemailandpushnotification(37, 2, 1);
									$action_id = 38;
								}
								elseif ($course_id == 3) {
									$email_template = getemailandpushnotification(43, 1, 1);
									$app_template = getemailandpushnotification(43, 2, 1);
									$action_id = 41;
								}
								if (!empty($parent_detail)) {	
									
									if (!empty($email_template)) {
										$body = $email_template['body'];
										$body = str_ireplace("[@@child_name@@]", $child_name, $body);
										$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
										$body = str_ireplace("[@@course_name@@]", $current_course_name, $body);
										$body = str_ireplace("[@@promoted_course_name@@]", $promoted_course_name, $body);
										$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
										emailnotification($parent_detail[0]->ss_aw_parent_email, $email_template['title'], $email_template['body']);
									}

									
									if (!empty($app_template)) {
										$body = $app_template['body'];
										$body = str_ireplace("[@@child_name@@]", $child_name, $body);
										$body = str_ireplace("[@@username@@]", $parent_detail[0]->ss_aw_parent_full_name, $body);
										$body = str_ireplace("[@@course_name@@]", $current_course_name, $body);
										$body = str_ireplace("[@@promoted_course_name@@]", $promoted_course_name, $body);
										$body = str_ireplace("[@@gender_pronoun@@]", $g, $body);
										$title = $app_template['title'];
										$token = $parent_detail[0]->ss_aw_device_token;

										pushnotification($title,$body,$token,$action_id);

										$save_data = array(
											'user_id' => $parent_detail[0]->ss_aw_parent_id,
											'user_type' => 1,
											'title' => $title,
											'msg' => $body,
											'status' => 1,
											'read_unread' => 0,
											'action' => $action_id
										);

										save_notification($save_data);
									}	
								}
							}
						}	
					}

					$responseary['status'] = 200;
					$responseary['msg'] = "Promotion confirmed successfully.";	
				}
				else{
					$error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1032');
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
		}

		die(json_encode($responseary));
	}

	public function check_course_purchased_or_not_for_ios(){
		$postdata = $this->input->post();
		$responseary = array();
		if (!empty($postdata)) {
			$userid = $postdata['user_id'];
			$user_token = $postdata['user_token'];
			$child_id = $postdata['child_id'];
			$course_id = $postdata['course_id'];
			if ($this->check_parent_existance($userid, $user_token)) {
				$childary = $this->ss_aw_child_course_model->get_details_by_child_course($child_id, $course_id);
				$responseary['status'] = 200;
				if (!empty($childary)) {
					$responseary['msg'] = "Course purchased.";
					$responseary['data']['course_purchase'] = 1;

					//send notification code
					/*if ($course_id == 1) {
						$course_name = "Emerging";
					}
					elseif ($course_id == 2) {
						$course_name = "Consolidated";
					}
					else{
						$course_name = "Advanced";
					}
					
					$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
					if (!empty($child_details)) {
						$email_template = getemailandpushnotification(8, 1, 2);
						if (!empty($email_template)) {
							$body = $email_template['body'];
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							emailnotification($child_details[0]->ss_aw_child_email, $email_template['title'], $body);
						}

						$app_template = getemailandpushnotification(8, 2, 2);
						if (!empty($app_template)) {
							$body = $app_template['body'];
							$body = str_ireplace("[@@course_name@@]", $course_name, $body);
							$body = str_ireplace("[@@username@@]", $child_details[0]->ss_aw_child_nick_name, $body);
							$title = $app_template['title'];
							$token = $child_details[0]->ss_aw_device_token;

							pushnotification($title,$body,$token,9);

							$save_data = array(
								'user_id' => $child_details[0]->ss_aw_child_id,
								'user_type' => 2,
								'title' => $title,
								'msg' => $body,
								'status' => 1,
								'read_unread' => 0,
								'action' => 9
							);

							save_notification($save_data);
						}
					}*/
					//end
				}
				else{
					$responseary['msg'] = "Course not purchased.";
					$responseary['data']['course_purchase'] = 0;
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

					die(json_encode($responseary));
				}

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
	
}