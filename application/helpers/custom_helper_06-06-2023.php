<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function calculate_age($dob)
{
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dob ), date_create($today));
	$age = $diff->format('%y');
	return $age;
}


function sendmail($msg,$subject,$email,$bcc = "",$attachment = "",$cc = "")
{
	// use wordwrap() if lines are longer than 70 characters
	/*$msg = wordwrap($msg,70);

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	$headers .= "From: team <deepanjan.das@gmail.com>". "\r\n" ."CC: deepanjan.das@gmail.com";
							
	$status = mail($email,$subject,$msg,$headers);
	return $status;*/

	$config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'smtp.netcorecloud.net',
		'smtp_port' => 587,
		'smtp_user' => 'team',
		'smtp_pass' => 'team_f5768c7c3da3c1aaa0932a7844075e39',
		'mailtype'  => 'html', 
		'charset'   => 'utf-8',
		'smtp_crypto' => 'tls'
	);	

	$CI = get_instance();
	$CI->load->library('email', $config);
	$CI->email->set_newline("\r\n");
	$CI->email->from('communications@team.com', 'team™');
	$CI->email->to($email);
	if (!empty($cc)) {
		$cc_multi_mail = explode(",", $cc);
		$CI->email->cc($cc_multi_mail); 	
	}
	if (!empty($bcc)) {
		$bcc_multi_mail = explode(",", $bcc);
		$CI->email->bcc($bcc_multi_mail); 	
	} 		
	$CI->email->subject($subject);
	$CI->email->message($msg);
	if (!empty($attachment)) {
	 	$CI->email->attach($attachment);
	}  
	$response = $CI->email->send();
	return $response;
}

function sendbulkmail($msg,$subject,$email = array(),$bcc = "",$attachment = ""){
	if (!empty($email)) {
		$msg = wordwrap($msg, 70);			
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.netcorecloud.net',
			'smtp_port' => 587,
			'smtp_user' => 'team',
			'smtp_pass' => 'team_f5768c7c3da3c1aaa0932a7844075e39',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8',
			'smtp_crypto' => 'tls'
		);	

		$CI = get_instance();
		$CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");
		$CI->email->from('communications@team.com', 'team™');
		$CI->email->to($email);
		//$CI->email->cc("sayan.sen@schemaphic.com");
		if (!empty($bcc)) {
			$bcc_multi_mail = explode(",", $bcc);
			$CI->email->bcc($bcc_multi_mail); 	
		}		
		$CI->email->subject($subject);
		$CI->email->message($msg); 
		if (!empty($attachment)) {
		 	$CI->email->attach($attachment);
		 } 
		$response = $CI->email->send();
		return $response;	
	}
}

function get_datediff($insertdate)
{
	$today = date("Y-m-d");
	$diff = date_diff(date_create($insertdate ), date_create($today));
	$date_diff = $diff->format('%d');
	return $date_diff;
}

function getchild_diagnosticexam_status($child_id)
{
	$CI = get_instance();
	$CI->load->model('ss_aw_child_course_model');
	$CI->load->model('ss_aw_diagonastic_exam_model');
	$CI->load->model('ss_aw_diagnonstic_questions_asked_model');
	$CI->load->model('ss_aw_child_last_lesson_model');
	$CI->load->model('ss_aw_assessment_exam_completed_model');
	$CI->load->model('ss_aw_assesment_questions_asked_model');
	$CI->load->model('ss_aw_purchased_supplymentary_course_model');
	$CI->load->model('ss_aw_supplymentary_exam_finish_model');
	$CI->load->model('ss_aw_supplymentary_exam_model');
	$CI->load->model('ss_aw_assessment_exam_log_model');
	$CI->load->model('ss_aw_assesment_multiple_question_asked_model');
	
	$searchary['ss_aw_diagonastic_child_id'] = $child_id;
	$lesson_id = 0;
	$format_type = "";
	$courseresult = array();
	$courseresult = $CI->ss_aw_child_course_model->get_details($child_id); // Search Course completed or not
				
	$lastassessment_exam = array();
	if (!empty($courseresult)) {
		$course_id = $courseresult[count($courseresult) - 1]['ss_aw_course_id'];
		if ($course_id == 1 || $course_id == 2) {
			$type = 1;
		}
		elseif($course_id == 3){
			$type = 2;
		}
		else{
			$type = 3;
		}

		$lastassessment_exam = $CI->ss_aw_assesment_questions_asked_model->get_last_exam_details($child_id, $type); // Search LAST Assessment Exam code
	}
	$last_exam_code = "";
	if(!empty($lastassessment_exam))
		$last_exam_code = $lastassessment_exam[0]['ss_aw_assessment_exam_code'];
				
				
		$searcharey = array();
		$searcharey['ss_aw_child_id'] = $child_id;
		$searcharey['ss_aw_exam_code'] = $last_exam_code;
		$lastassessment_exam_complete = $CI->ss_aw_assessment_exam_completed_model->searchdata($searcharey); // Search LAST Assessment Exam code
		$startcourse = array();
		$startcourse['ss_aw_child_id'] = $child_id;
		$startcourse['ss_aw_lesson_level'] = $courseresult[count($courseresult) - 1]['ss_aw_course_id'];		
		$lastlesson_response = $CI->ss_aw_child_last_lesson_model->fetch_details_byparam($startcourse);

		if(!empty($lastassessment_exam_complete))
		{
			$complete_assessment_status = 1;
			if ($lastlesson_response[0]['ss_aw_lesson_status'] == 2) {
				$last_lesson_complete_date = $lastlesson_response[0]['ss_aw_last_lesson_modified_date'];
				$last_assessment_complete_date = $lastassessment_exam_complete[0]['ss_aw_create_date'];

				if ($last_assessment_complete_date >= $last_lesson_complete_date) {
					$complete_assessment_status = 1;		
				}
				else
				{
					$complete_assessment_status = 0;
				}
			}
		}
		else
		{
			$complete_assessment_status = 0;
		}
		

		$searchresult = array();
		$searchresult = $CI->ss_aw_diagonastic_exam_model->fetch_record_byparam($searchary); // Search exam completed or not
				
		$check_diagnostic_start = array();
		$check_start_searchary['ss_aw_child_id'] = $child_id;
		$check_diagnostic_start = $CI->ss_aw_diagnonstic_questions_asked_model->fetch_record_byparam($check_start_searchary); // Search exam start or not
				
		$check_purchase_course_exist = array();	
		if (!empty($courseresult)) {
			$searchary = array();
			$searchary['ss_aw_child_id'] = $child_id;
			$searchary['ss_aw_course_currrent_status'] = $courseresult[count($courseresult) - 1]['ss_aw_course_status'];
			$check_purchase_course_exist = $CI->ss_aw_purchase_courses_model->search_byparam($searchary); // Search course purchase against child or not // Status  = 1 = Running,2 = Completed	
		}
				
				/*
				Supplymentary Course Purchase OR NOT
				*/
		$searcharey = array();
		$searcharey['ss_aw_child_id'] = $child_id;
		$supplymentary_purchaseary = array();
		$supplymentary_purchaseary = $CI->ss_aw_purchased_supplymentary_course_model->search_byparam($searcharey); // Search Supplementary course purchase
				
		$supplymentary_examary = array();
		$supplymentary_examary = $CI->ss_aw_supplymentary_exam_model->fetch_record_byparam($searcharey); // Search Supplementary course Start
				
		if(!empty($supplymentary_examary))
		{
			$searcharey['ss_aw_supplymentary_exam_code'] = $supplymentary_examary[0]['ss_aw_supplymentary_exam_code'];
			$supplymentary_examendary = array();
			$supplymentary_examendary = $CI->ss_aw_supplymentary_exam_finish_model->fetch_record_byparam($searcharey); // Search Supplementary course End
		}
				
				/*
				Get LAST LESSON Status
				*/
		
		if (empty($check_purchase_course_exist)) {
			$id = 0;
			$sub_id = 0;
			$msg = "Not yet enrolled";		
		}
		else{
			if(!empty($searchresult))
			{
				$datediffcount = get_datediff($searchresult[0]['ss_aw_diagonastic_exam_date']);
						
				// $id = 0;
				// if($datediffcount > 90)
				// {
				// 	$sub_id = 3;
				// 	$msg = "Cancelled last try for diagnostic test";
				// }
				if(!empty($lastlesson_response))
				{
					if($lastlesson_response[0]['ss_aw_lesson_status'] == 1)
					{
						$id = 1;
						$sub_id = 1;
						$lesson_id = $lastlesson_response[0]['ss_aw_lesson_id'];
								
						if($lastlesson_response[0]['ss_aw_lesson_format'] == 'Single')
							$format_type = 1;
						else
							$format_type = 2;
						$msg = "Lesson started";
					}
					else if($lastlesson_response[0]['ss_aw_lesson_status'] == 2)
					{
						$id = 1;
						$sub_id = 2;
						$msg = "Lesson completed";
					}
				}
				else if(!empty($check_purchase_course_exist))
				{
					$id = 1;
					$sub_id = 0;
					$msg = "Enrolled, Diagnostic test completed, awaiting for lesson start";
				}
				else
				{
					$id = 0;
					$sub_id = 2;
					$msg = "Diagnostic test completed, awaiting for course selection";
				}
						
				if($complete_assessment_status == 1)
				{
					$id = 2;
					$sub_id = 2;
					$msg = "assessment completed";
				}
				else if(!empty($lastassessment_exam))
				{
					if ($lastlesson_response[0]['ss_aw_lesson_status'] == 2) {
						$check_for_single = $CI->ss_aw_assessment_exam_log_model->checkstartedafterorbeforelesson($child_id, $lastlesson_response[0]['ss_aw_last_lesson_modified_date']);
						$check_for_multiple = $CI->ss_aw_assesment_multiple_question_asked_model->checkstartedafterorbeforelesson($child_id, $lastlesson_response[0]['ss_aw_last_lesson_modified_date']);
						if ($check_for_multiple > 0 || $check_for_single > 0) {
							$id = 2;
							$sub_id = 1;
							if($lastassessment_exam[0]['ss_aw_assesment_format'] == 'Single')
								$format_type = 1;
							else
								$format_type = 2;
							$msg = "assessment started";	
						}	
					}
				}

				if ($courseresult[count($courseresult) - 1]['ss_aw_course_status'] == 2) {
					if(empty($supplymentary_purchaseary))
					{
						$id = 3;
						$sub_id = 0;
						$msg = "Supplementary course to be purchased";
					}
					else if(!empty($supplymentary_purchaseary) && empty($supplymentary_examary))
					{
						$id = 3;
						$sub_id = 1;
						$msg = "Supplementary course purchased";
					}
					else if(!empty($supplymentary_examary) && empty($supplymentary_examendary))
					{
						$id = 3;
						$sub_id = 2;
						$msg = "Supplementary course started";
					}
					else if(!empty($supplymentary_examendary))
					{
						$id = 3;
						$sub_id = 3;
						$msg = "Supplementary course completed";
					}	
				}
						
			}
			else if(!empty($check_diagnostic_start))
			{
				$id = 0;
				$sub_id = 2;
				$msg = "Diagnostic test started";
			}
			else
			{
				$id = 0;
				$sub_id = 1;
				$msg = "Diagnostic exam not yet started";
			}

			if (!empty($courseresult)) {
				if ($courseresult[count($courseresult) - 1]['ss_aw_course_status'] == 2) {
					$purchase_date = date('Y-m-d', strtotime($courseresult[count($courseresult) - 1]['ss_aw_child_course_create_date']));
					$purchase_time = strtotime($purchase_date);
					$current_date = time();
					$datediff = $current_date - $purchase_time;
					$days = round($datediff / (60 * 60 * 24));
					if ($days >= 30) {
						$id = 4;
						$sub_id = 0;
						$msg = "Ready for new course";
					}

				}
			}
		}		
		
		$responseary = array();		
		$responseary['id'] = $id;
		$responseary['lesson_id'] = $lesson_id;
		$responseary['format_type'] = $format_type;
		$responseary['sub_id'] = $sub_id;
		$responseary['msg'] = $msg;
		
		return $responseary;				
				
}


function adminmenusection()
{
	$data = array();
	$CI = get_instance();
	$CI->load->model('ss_aw_roles_category_model');
	$CI->load->model('ss_aw_adminmenus_model');
	$user_role_ids_ary = array();
	$user_role_ids_ary = explode(",",$CI->session->userdata('role_ids'));
	$role_categoryary = $CI->ss_aw_roles_category_model->fetch_record_byparam();
		
		$searchary = array();
		$adminmenuary = $CI->ss_aw_adminmenus_model->search_byparam($searchary);
		
		$roleary = array();
		foreach($role_categoryary as $val)
		{
			$roleary[] = $val['ss_aw_admin_role_title'];
		}
		$categoryary = array();
		foreach($adminmenuary as $key=>$value)
		{
			if(!empty($value['ss_aw_admin_role_title']))
			{
				if(in_array($value['ss_aw_id'],$user_role_ids_ary))
				{
					$categoryary[$value['ss_aw_admin_role_title']][$value['ss_aw_id']] = $value['ss_aw_menu_name'];
				}
			}
		}
		$data['role'] = $roleary;
		$data['category'] = $categoryary;
		return $data;
}

function checklogin()
	{
		$CI = get_instance();
		if(empty($CI->session->userdata('id')))
		{
			$CI->session->set_flashdata('error','First login to access any page.');
			redirect('admin/index');
		}else
		{
			$CI->load->model('ss_aw_adminmenus_model');
			$headerdata = array();
			$headerdata['profile_name'] = $CI->session->userdata('fullname');
			$headerdata['profile_pic'] = $CI->session->userdata('profile_pic');
			
			$searchary = array();
			$adminmenuary = $CI->ss_aw_adminmenus_model->search_byparam($searchary);
			
			
			$user_role_ids_ary = array();
			$user_role_ids_ary = explode(",",$CI->session->userdata('role_ids'));
			
			foreach($user_role_ids_ary as $val)
			{
				foreach($adminmenuary as $val2)
				{
					if($val == $val2['ss_aw_id'])
					{
						if($val2['ss_aw_menu_category_id'] > 0)
						{
							$user_role_ids_ary[] = $val2['ss_aw_menu_category_id'];
						}
					}
				}
			}
			
			$user_role_ids_ary = array_values(array_unique($user_role_ids_ary));
			
			$admin_menu_ary = array();
			$j = 1;$i = 1;
				foreach($adminmenuary as $val)
				{
					if(in_array($val['ss_aw_id'],$user_role_ids_ary))
					{
						
						if(trim($val['ss_aw_menu_category_id']) == 0)
						{
							$admin_menu_ary[$val['ss_aw_id']][0]['menu_icon'] = $val['ss_aw_menu_icon'];
							$admin_menu_ary[$val['ss_aw_id']][0]['page'] = $val['ss_aw_menu_name'];
							$admin_menu_ary[$val['ss_aw_id']][0]['link'] = $val['ss_aw_adminusers_pagelink'];
						}
					}
				}
				foreach($adminmenuary as $val)
				{
					if(in_array($val['ss_aw_id'],$user_role_ids_ary))
					{
						foreach($admin_menu_ary as $key=>$val2){
							if($key == $val['ss_aw_menu_category_id'])
							{	
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

function notificationsendmail($email_template,$subject,$email,$phone,$fullname)
{
	$CI = get_instance();
	$CI->load->model('ss_aw_email_notification_cms_model');
			
			$adminmenuary = $CI->ss_aw_email_notification_cms_model->fetch_record_byid($email_template);
			
			if($adminmenuary[0]->ss_aw_email_temp_status == 1)
			{
				$email_template_contain = $adminmenuary[0]->ss_aw_email_temp_contain;	
				$temp_contain = str_ireplace("[@@email@@]",$email,$email_template_contain);
				$temp_contain = str_ireplace("[@@mobile@@]",$phone,$temp_contain);
				$temp_contain = str_ireplace("[@@username@@]",$fullname,$temp_contain);
				$msg = wordwrap($temp_contain,70);

				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'smtp.netcorecloud.net',
					'smtp_port' => 587,
					'smtp_user' => 'team',
					'smtp_pass' => 'team_f5768c7c3da3c1aaa0932a7844075e39',
					'mailtype'  => 'html', 
					'charset'   => 'utf-8',
					'smtp_crypto' => 'tls'
				);	

				$CI = get_instance();
				$CI->load->library('email', $config);
				$CI->email->set_newline("\r\n");
				$CI->email->from('communications@team.com', 'team™');
				$CI->email->to($email); 		
				$CI->email->subject($subject);
				$CI->email->message($msg);  
				$response = $CI->email->send();
				return $response;
			}
}

	function sendpushnotification($email_template,$subject,$email,$phone,$fullname,$token)
	{
		//print_r($postdata);
		//die();
		$url = "https://fcm.googleapis.com/fcm/send";
		
		$serverKey = FIREBASE_SERVER_KEY;
		$CI = get_instance();
		$CI->load->model('ss_aw_app_notification_cms_model');
		$adminmenuary = $CI->ss_aw_app_notification_cms_model->fetch_record_byid($email_template);
			
			if(!empty($adminmenuary) && $adminmenuary[0]->ss_aw_app_temp_status == 1)
			{
				$app_template_contain = $adminmenuary[0]->ss_aw_app_temp_contain;	
				$temp_contain = str_ireplace("[@@email@@]",$email,$app_template_contain);
				$temp_contain = str_ireplace("[@@mobile@@]",$phone,$temp_contain);
				$temp_contain = str_ireplace("[@@username@@]",$fullname,$temp_contain);
				$body = $temp_contain;
				$title = $adminmenuary[0]->ss_aw_app_template_name;
			}
			else
			{
				$body = "Test Notification Body";
				$title = "Test Notification Title";
			}
		
		//print_r($postdata);
		
		$imageshow = base_url()."assets/images/logo-sm.png";
		/*$data = array();
		//$data['url'] = $imageshow;
		$data['user_type'] = $postdata['user_type'];
		//$data['medicine_type'] = $postdata['medicine_type'];
		
		if(!empty($postdata['medicine_name'])){
			//$data['medicine_name'] = $postdata['medicine_name'];
		//$data['notification_for'] = $postdata['notification_for']."(".$postdata['medicine_name'].")";
		$title = $postdata['title'];
		}
		else{
			//$data['notification_for'] = $postdata['notification_for'];
			$title = $postdata['title'];
		}
		
		//$data['notification_for'] = "Test Notification By Saunak";
		//$data['postdata'] = $postdata['postdata'];
		$data['title'] = $title." (".$postdata['medicine_name'].")";
		$data['text'] = $body;
		$data['sender_id'] = $postdata['sender_id'];
		$data['receiver_id'] = $postdata['receiver_id'];
		$data['requirment_id'] = $postdata['requirment_id'];
		if(!empty($postdata['postdata']['ss_type']))
			$data['ss_type'] = $postdata['postdata']['ss_type'];
		else
			$data['ss_type'] = $postdata['ss_type'];
		
		if(!empty($postdata['rec_id']))
		{
			$data['rec_id'] = $postdata['rec_id'];
		}
		if(!empty($postdata['status']))
		{
			$data['status'] = $postdata['status'];
		}else{
			$data['status'] = 0;
		}*/
		$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
		
		$json = json_encode($arrayToSend);
		//die();
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		//Send the request
		$response = curl_exec($ch);
		//print_r($response);
		//die();
		
		/*$postdatary = array();
		$postdatary['requirment_id'] = $postdata['requirment_id'];
		$postdatary['medicine_id'] = $postdata['medicine_id'];
		$postdatary['medicine_price'] = $postdata['medicine_price'];
		$postdatary['sender_id'] = $postdata['sender_id'];
		$postdatary['receiver_id'] = $postdata['receiver_id'];
		$postdatary['user_type'] = $postdata['user_type'];
		$postdatary['title'] = $title;
		$postdatary['content'] = $postdata['msg'];
		if(!empty($postdata['msg_type']))
		{
			$postdatary['msg_type'] = $postdata['msg_type'];
		}
		else
		{
			$postdatary['msg_type'] = 1;
		}
		$this->insert_users_notification($postdatary);
		*/
		//Close request
		if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $response;
	}


	function pushnotification($title,$body,$token,$action = "", $extra_data = "")
	{
		//print_r($postdata);
		//die();
		$url = "https://fcm.googleapis.com/fcm/send";
		
		$serverKey = FIREBASE_SERVER_KEY;
		
		$data = array();
		if (!empty($action)) {
			$data['action'] = $action;
		}

		if (!empty($extra_data)) {
			$data['params'] = $extra_data;
		}
		$imageshow = base_url()."assets/images/logo-sm.png";
		$notification = array('title' => $title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		if (!empty($data)) {
			$arrayToSend = array('to' => $token, 'notification' => $notification,'data' => $data,'priority' => 'high');	
		}
		else{
			$arrayToSend = array('to' => $token, 'notification' => $notification,'priority' => 'high');
		}
		
		$json = json_encode($arrayToSend);
		//die();
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		//Send the request
		$response = curl_exec($ch);
		//Close request
		/*if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}*/
		curl_close($ch);
		return $response;
	}

	function testpushnotification($title,$body,$token,$action = "")
	{
		//print_r($postdata);
		//die();
		$url = "https://fcm.googleapis.com/fcm/send";
		
		$serverKey = FIREBASE_SERVER_KEY;
		
		$data = array();
		if (!empty($action)) {
			$data['action'] = $action;
		}
		$imageshow = base_url()."assets/images/logo-sm.png";
		$notification = array('title' => $title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $token, 'notification' => $notification,'data' => $data, 'priority' => 'high');
		
		$json = json_encode($arrayToSend);
		//die();
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		//Send the request
		$response = curl_exec($ch);

		echo $response;
		die();
		//Close request
		if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $response;
	}

	function emailnotification_old($email, $subject, $msg, $cc = "", $attachment = ""){
		$msg = wordwrap($msg,70);

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.netcorecloud.net',
			'smtp_port' => 587,
			'smtp_user' => 'team',
			'smtp_pass' => 'team_f5768c7c3da3c1aaa0932a7844075e39',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8',
			'smtp_crypto' => 'tls'
		);	

		$CI = get_instance();
		$CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");
		$CI->email->from('communications@team.com', 'team™');
		$CI->email->to($email);
		if (!empty($cc)) {
		 	$CI->email->cc($cc);
		} 		
		$CI->email->subject($subject);
		$CI->email->message($msg);
		if (!empty($attachment)) {
		 	$CI->email->attach($attachment);
		}  
		$response = $CI->email->send();
		//add email log
		if (!empty($email)) {
			$data = array(
				'ss_aw_recipient_email' => $email,
				'ss_aw_subject' => $subject,
				'ss_aw_date' => date('Y-m-d H:i:s')
			);
			$CI->load->model('ss_aw_email_log_model');
			$CI->ss_aw_email_log_model->save_record($data);	
		}
		//end of insertion
		//$CI->email->clear(TRUE);
		return $response;
	}
	
	function emailnotification($email, $subject, $msg, $cc = "", $attachment = ""){
		$unsubscribe_link = base_url().'unsubscribe/'.base64_encode($email);
		$msg = str_ireplace("[@@UNSUBSCRIBE_USER_EMAIL_LINK@@]", $unsubscribe_link, $msg);
		$msg = str_ireplace("[@@CURRENT_YEAR@@]", date('Y'), $msg);
		if (!empty($attachment)) {
			$CI = get_instance();
			$curl = curl_init();
			curl_setopt_array($curl, array(
			   CURLOPT_URL => 'http://smsc.biz/httpemailapi/v1/send',
			   CURLOPT_RETURNTRANSFER => true,
			   CURLOPT_ENCODING => '',
			   CURLOPT_MAXREDIRS => 10,
			   CURLOPT_TIMEOUT => 0,
			   CURLOPT_FOLLOWLOCATION => true,
			   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			   CURLOPT_CUSTOMREQUEST => 'POST',
			   CURLOPT_POSTFIELDS =>
			'api_key=3b246c24a1af2a042ab05f4c80ead807&from=swagat%40team.com
			&to='.$email.'
			&subject='.$subject.'&html='.urlencode($msg).'&attachment='.$attachment.'',
			   CURLOPT_HTTPHEADER => array(
				 'Content-Type: application/x-www-form-urlencoded',
				 'Cookie: ci_session=5qc7st5skaejn8j8l2loi6na8mm1ho12'
			   ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			if (!empty($response)) {
				$data = array(
					'ss_aw_message_id' => $response,
					'ss_aw_email_id' => $email,
					'ss_aw_subject' => $subject
				);
				$CI->db->insert('ss_aw_advance_email_log', $data);
			}
			//add email log
			if (!empty($email)) {
				$data = array(
					'ss_aw_recipient_email' => $email,
					'ss_aw_subject' => $subject,
					'ss_aw_date' => date('Y-m-d H:i:s')
				);
				$CI->load->model('ss_aw_email_log_model');
				$CI->ss_aw_email_log_model->save_record($data);	
			}
			//end of insertion
			
			return $response;
		}
		else{
			$CI = get_instance();
			$curl = curl_init();
			curl_setopt_array($curl, array(
			   CURLOPT_URL => 'http://smsc.biz/httpemailapi/v1/send',
			   CURLOPT_RETURNTRANSFER => true,
			   CURLOPT_ENCODING => '',
			   CURLOPT_MAXREDIRS => 10,
			   CURLOPT_TIMEOUT => 0,
			   CURLOPT_FOLLOWLOCATION => true,
			   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			   CURLOPT_CUSTOMREQUEST => 'POST',
			   CURLOPT_POSTFIELDS =>
			'api_key=3b246c24a1af2a042ab05f4c80ead807&from=swagat%40team.com
			&to='.$email.'
			&subject='.$subject.'&html='.urlencode($msg).'',
			   CURLOPT_HTTPHEADER => array(
				 'Content-Type: application/x-www-form-urlencoded',
				 'Cookie: ci_session=5qc7st5skaejn8j8l2loi6na8mm1ho12'
			   ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			if (!empty($response)) {
				$data = array(
					'ss_aw_message_id' => $response,
					'ss_aw_email_id' => $email,
					'ss_aw_subject' => $subject
				);
				$CI->db->insert('ss_aw_advance_email_log', $data);
			}
			//add email log
			if (!empty($email)) {
				$data = array(
					'ss_aw_recipient_email' => $email,
					'ss_aw_subject' => $subject,
					'ss_aw_date' => date('Y-m-d H:i:s')
				);
				$CI->load->model('ss_aw_email_log_model');
				$CI->ss_aw_email_log_model->save_record($data);	
			}
			//end of insertion
			
			return $response;
		}

	}

	function emailnotification_disputes($email, $subject, $msg){
		$unsubscribe_link = base_url().'unsubscribe/'.base64_encode($email);
		$msg = str_replace("[@@UNSUBSCRIBE_USER_EMAIL_LINK@@]", $unsubscribe_link, $msg);
		$msg = str_ireplace("[@@CURRENT_YEAR@@]", date('Y'), $msg);
		$CI = get_instance();
		subject:"Trans Mail";
		text:"Mail body text";
		$curl = curl_init();
		curl_setopt_array($curl, array(
		   CURLOPT_URL => 'http://smsc.biz/httpemailapi/v1/send',
		   CURLOPT_RETURNTRANSFER => true,
		   CURLOPT_ENCODING => '',
		   CURLOPT_MAXREDIRS => 10,
		   CURLOPT_TIMEOUT => 0,
		   CURLOPT_FOLLOWLOCATION => true,
		   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		   CURLOPT_CUSTOMREQUEST => 'POST',
		   CURLOPT_POSTFIELDS =>
		'api_key=3b246c24a1af2a042ab05f4c80ead807&from=swagat%40team.com
		&to='.$email.'&bcc=ateesh@team.com,sheel@team.com,craig@team.com
		&subject='.$subject.'&html='.urlencode($msg).'',
		   CURLOPT_HTTPHEADER => array(
			 'Content-Type: application/x-www-form-urlencoded',
			 'Cookie: ci_session=5qc7st5skaejn8j8l2loi6na8mm1ho12'
		   ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		
		if (!empty($response)) {
			$data = array(
				'ss_aw_message_id' => $response,
				'ss_aw_email_id' => $email,
				'ss_aw_subject' => $subject
			);
			$CI->db->insert('ss_aw_advance_email_log', $data);
		}
		
		//add email log
		if (!empty($email)) {
			$data = array(
				'ss_aw_recipient_email' => $email,
				'ss_aw_subject' => $subject,
				'ss_aw_date' => date('Y-m-d H:i:s')
			);
			$CI->load->model('ss_aw_email_log_model');
			$CI->ss_aw_email_log_model->save_record($data);	
		}
		//end of insertion
		
		return $response;


	}

	function pagination_config($redirect_to, $total_record, $uri_segment, $per_page){
		$config = array();
	    $config['base_url'] = $redirect_to;
        $config["total_rows"] = $total_record;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $uri_segment;
        $config['full_tag_open'] = '<ul class="pagination pagination-rounded justify-content-end">';
    	$config['full_tag_close'] = '</ul>';
    	$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
   		$config['cur_tag_close'] = '</a></li>'; 		 
   		$config['num_tag_open'] = '<li class="page-item page-link">';
        $config['num_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">«</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li class="page-item page-link">';
		$config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '<span aria-hidden="true">»</span><span class="sr-only">Next</span>';
	    $config['next_tag_open'] = '<li class="page-item page-link">';
	    $config['next_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li class="page-item page-link">';
	    $config['first_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li class="page-item page-link">';
	    $config['last_tag_close'] = '</li>'; 
	    return $config;   
	}

	function save_notification($data){
		$ci = get_instance();
		$ci->load->model('ss_aw_notification_model');
		$ci->ss_aw_notification_model->save_notification($data);
	}

	//fetch email and push notification template.
	//type 1 = email, 2 = notification
	function getemailandpushnotification($record_id, $type, $user_type = ""){
		$ci = get_instance();
		$ci->load->model('ss_aw_app_notification_cms_model');
		$ci->load->model('ss_aw_email_notification_cms_model');
		$responseary = array();
		if ($type == 1) {
			$template = $ci->ss_aw_email_notification_cms_model->fetch_record_byid($record_id);
			if (!empty($template)) {
				$responseary['title'] = $template[0]->ss_aw_template_name;
				if ($user_type != "") {
					if ($user_type == 1) {
						$responseary['body'] = $template[0]->ss_aw_email_temp_contain;
					}
					else{
						$responseary['body'] = $template[0]->ss_aw_child_email_temp_contain;
					}
				}
				else
				{
					$responseary['body'] = $template[0]->ss_aw_email_temp_contain;
				}	
			}
		}
		elseif ($type == 2) {
			$template = $ci->ss_aw_app_notification_cms_model->fetch_record_byid($record_id);
			if (!empty($template)) {
				$responseary['title'] = $template[0]->ss_aw_app_template_name;
				if ($user_type != "") {
					if ($user_type == 1) {
						$responseary['body'] = trim($template[0]->ss_aw_app_temp_contain);
					}
					else
					{
						$responseary['body'] = trim($template[0]->ss_aw_app_temp_contain_child);
					}
				}
				else{
					$responseary['body'] = trim($template[0]->ss_aw_app_temp_contain);
				}	
			}
		}

		return $responseary;
	}

	function get_percentage($total, $obtain){
		if ($total == 0) {
			return 0;
		}
		else
		{
			if ($total >= $obtain) {
				$percentage = ($obtain * 100) / $total;
				return round($percentage);
			}
			else
			{
				return 0;
			}
		}
	}

	function isJSON($string){
	   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	function getQuestion($title_str){
		$remove_ary = array("[u]","[/u]","[b]","[/b]","[c]","[/c]","[h]","[/h]");
		$title_str = str_ireplace($remove_ary,"",trim($title_str));
		$title_str = (str_ireplace($remove_ary,"",trim(preg_replace('/\s\s+/', ' ',str_replace("\n", " ",$title_str)))));
		return $title_str;
	}

	function quintileRange($value){
		if (($value >= 1) && ($value <= 18)) {
			$quintile = 1;
		}
		elseif (($value >= 19) && ($value <= 36)) {
			$quintile = 2;
		}
		elseif (($value >= 37) && ($value <= 56)) {
			$quintile = 3;
		}
		elseif (($value >= 57) && ($value <= 75)) {
			$quintile = 4;
		}
		elseif (($value >= 76) && ($value <= 100)) {
			$quintile = 5;
		}

		return $quintile;
	}

	function quintileTopicQuintile($value, $topic, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_combine_score_quintile_topic_wise_model');
		$get_quintile_detail = $ci->ss_aw_combine_score_quintile_topic_wise_model->getdatabyvalueandtopic($value, $topic, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function diagnosticQuantile($value, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_diagnostic_quintile_model');
		$get_quintile_detail = $ci->ss_aw_diagnostic_quintile_model->getdatabyvalue($value, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function assessmentQuantile($value, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_assessment_quintile_model');
		$get_quintile_detail = $ci->ss_aw_assessment_quintile_model->getdatabyvalue($value, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function combineTotalQuintile($value, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_combine_score_quintile_model');
		$get_quintile_detail = $ci->ss_aw_combine_score_quintile_model->getdatabyvalue($value, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function formatTwoLessonAssessmentQuintile($value, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_lesson_assessment_format_two_quintile_model');
		$get_quintile_detail = $ci->ss_aw_lesson_assessment_format_two_quintile_model->getdatabyvalue($value, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function readalongScoreQuantile($value, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_readalong_score_quintile_model');
		$get_quintile_detail = $ci->ss_aw_readalong_score_quintile_model->getdatabyvalue($value, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function lessonConfidenceScoreQuantile($value, $level){
		$ci = get_instance();
		$ci->load->model('ss_aw_english_language_confidence_quintile_model');
		$get_quintile_detail = $ci->ss_aw_english_language_confidence_quintile_model->getdatabyvalue($value, $level);
		if (!empty($get_quintile_detail)) {
			$quintile = $get_quintile_detail[0]->quintile;
		}
		else
		{
			$quintile = "NA";
		}

		return $quintile;
	}

	function send_sms($country_code, $mob_number, $otp){
		if ($country_code == 91) {
			$route = "T";
		}
		else{
			$route = "I";
			//$mob_number = $country_code.$mob_number;
		}
		$username = "ateesh@team.com";
		$password = "Bastille1789";
		// Sender ID
		if ($country_code == 1) {
			$approved_senderid="18336033505";	
		}
		else{
			$approved_senderid="ALSOWS";
		}
		//Approved Template
		$message = "The OTP to validate your team account is ".$otp.". Please do not share this OTP with anyone. - The team team";
		$enc_msg= rawurlencode($message); // Encoded message

		//Create API URL
		$fullapiurl="http://smsc.biz/httpapi/send?username=$username&password=$password&sender_id=$approved_senderid&route=$route&phonenumber=$mob_number&message=$enc_msg";

		//Call API
		$ch = curl_init($fullapiurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

function get_active_inactive_delinquent_students($data = array()) {
    $ci = get_instance();
    $ci->load->model('ss_aw_childs_model');
    $ci->load->model('ss_aw_child_last_lesson_model');
    $all_childs = $ci->ss_aw_childs_model->get_all_child($data); //all child data 
    $all_childs_ary = array();
    $all_completed_child = array();
    $delinquent_student_ary = array();
    $inactive_student_ary = array();
    $active_student_ary = array();

    if (!empty($all_childs)) {
        foreach ($all_childs as $key => $value) {
            $all_childs_ary[] = $value->ss_aw_child_id;
        }
    }
    $get_lesson_complete_students = $ci->ss_aw_child_last_lesson_model->get_each_user_last_lesson($data); //lesson start date end date child wise for completed course
    if (!empty($get_lesson_complete_students)) {
        foreach ($get_lesson_complete_students as $key => $value) {
        	$date_diff = 0;
        	if (!empty($value->assessment_complete_date)) {
        		$date_diff = daysDifferent(strtotime($value->assessment_complete_date), time());
        	}
        	elseif (!empty($value->ss_aw_last_lesson_modified_date)) {
        		$date_diff = daysDifferent(strtotime($value->ss_aw_last_lesson_modified_date), time());
        	}
        	elseif (!empty($value->ss_aw_last_lesson_create_date)) {
        		$date_diff = daysDifferent(strtotime($value->ss_aw_last_lesson_create_date), time());
        	}
        	
            if ($date_diff != 0) {
                if ($date_diff > 21) {
                    $inactive_student_ary[] = $value->ss_aw_child_id;
                } elseif ($date_diff > 7 && $date_diff<=21) {
                    $delinquent_student_ary[] = $value->ss_aw_child_id;
                } else{       
                    $active_student_ary[] = $value->ss_aw_child_id;
                }
            }
        }
    }

    $data['all_childs_ary'] = $all_childs_ary; //child id's all
    $data['delinquent_student_ary'] = $delinquent_student_ary;
    $data['inactive_student_ary'] = $inactive_student_ary;
    $data['active_student_ary'] = $active_student_ary;
    return $data;
}

function daysDifferent($start_time, $end_time){
	$diff = $end_time - $start_time;
	$diffDay = round($diff / (60 * 60 * 24));
	return $diffDay;
}

	function get_delinquent_students($data = array()){
		$ci = get_instance();
		$ci->load->model('ss_aw_childs_model');
		$ci->load->model('ss_aw_child_last_lesson_model');

		$get_lesson_complete_students = $ci->ss_aw_child_last_lesson_model->check_student_status($data);
		if (!empty($get_lesson_complete_students)) {
			foreach ($get_lesson_complete_students as $key => $value) {
				$child_id = $value->child_id;
				$end_date = $value->end_date;
				$end_timestamp = strtotime($end_date);
				$current_time = time();
				$diff = $current_time - $end_timestamp;
				$diffDay = round($diff / (60 * 60 * 24));
				if ($diffDay >= 1 && $diffDay < 8) {
					$delinquent_student_ary['first'][] = $value->child_id;	
				}
				elseif ($diffDay >= 8 && $diffDay < 15) {
					$delinquent_student_ary['second'][] = $value->child_id;
				}
				elseif ($diffDay >= 16 && $diffDay < 22) {
					$delinquent_student_ary['third'][] = $value->child_id;
				}
				elseif ($diffDay > 22){
					$delinquent_student_ary['last'][] = $value->child_id;
				}	
			}
		}

		$data['delinquent_student_ary'] = $delinquent_student_ary;
		return $data;
	}

	function AmountInWords(float $amount){
       $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
       // Check if there is any number after decimal
       $amt_hundred = null;
       $count_length = strlen($num);
       $x = 0;
       $string = array();
       $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $x < $count_length ) {
          $get_divider = ($x == 2) ? 10 : 100;
          $amount = floor($num % $get_divider);
          $num = floor($num / $get_divider);
          $x += $get_divider == 10 ? 1 : 2;
          if ($amount) {
           $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
           $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
           $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
           '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
           '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
            }
       else $string[] = null;
       }
       $implode_to_Rupees = implode('', array_reverse($string));
       // $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
       // " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
       $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[floor($amount_after_decimal / 10) * 10].' '.$change_words[$amount_after_decimal % 10]) . ' Paise' : '';
       return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }

    function coupon_code($coupon_id){
    	$ci = get_instance();
    	$ci->load->model('ss_aw_coupons_model');
    	if (!empty($coupon_id)) {
    		$result = $ci->ss_aw_coupons_model->getdetailbyid($coupon_id);
	    	if (!empty($result)) {
	    		return $result[0]->ss_coupon_code;
	    	}
	    	else{
	    		return "";
	    	}	
    	}
    	else{
    		return "NA";
    	}
    }

