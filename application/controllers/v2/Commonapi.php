<?php
set_time_limit(320);
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
class Commonapi extends CI_Controller {

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
		$this->load->model('ss_aw_countries_model');
		$this->load->model('ss_aw_states_model');
		$this->load->model('ss_aw_notification_model');
		$this->load->model('state_master_model');
	}

public function view_aboutus()
  {
  	$inputpost = $this->input->post();		
     $responseary = array();
     if($inputpost)
     {
     	 $user_id = $inputpost['user_id'];
		 $user_token = $inputpost['user_token'];
		 $user_type =  $inputpost['user_type'];
		 if($user_type==1)
		 {
		 	$this->check_parent_existance($user_id,$user_token);
		 }
		 elseif ($user_type==2) {
		 	$this->check_child_existance($user_id,$user_token);
		 }
         

		$page_id = '1';
		$result = $this->ss_aw_page_content_model->get_page_data($page_id);

		if(!empty($result))
			{
				$responseary['status'] = 200;
				$responseary['msg']  = 'Data Found';
		        $responseary['result'] = $result;

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

public function terms_conditions()
{		
   $responseary = array();
   $page_id = '2';
	$result = $this->ss_aw_page_content_model->get_page_data($page_id);

	if(!empty($result))
	{
		$responseary['status'] = 200;
		$responseary['msg']  = 'Data Found';
		$responseary['result'] = $result;
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

public function privacy_policy()
{		
   $responseary = array();
	$page_id = '3';
	$result = $this->ss_aw_page_content_model->get_page_data($page_id);

	if(!empty($result))
	{
		$responseary['status'] = 200;
		$responseary['msg']  = 'Data Found';
		$responseary['result'] = $result;
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

public function cancellation_policy()
{		
   $responseary = array();
	$page_id = '4';
	$result = $this->ss_aw_page_content_model->get_page_data($page_id);

	if(!empty($result))
	{
		$responseary['status'] = 200;
		$responseary['msg']  = 'Data Found';
		$responseary['result'] = $result;
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

public function faq()
  {
  		$inputpost = $this->input->post();		
     $responseary = array();
     if($inputpost)
     {
     	 $user_id = $inputpost['user_id'];
		 $user_token = $inputpost['user_token'];
		 $user_type =  $inputpost['user_type'];
		 
		 if ($user_type==2) {
		 	$this->check_child_existance($user_id,$user_token);
		 }
		 else{
		 	$this->check_parent_existance($user_id,$user_token);
		 }
         

		if ($user_type != 2) {
			$user_type = 1;
		}
		$result = $this->ss_aw_faq_model->get_recordby_usertype($user_type);

		if(!empty($result))
			{
				$responseary['status'] = 200;
				$responseary['msg']  = 'Data Found';
		        $responseary['result'] = $result;

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


 public function check_child_existance($child_id,$child_token)
	  {  	
		$response = $this->ss_aw_childs_model->check_child_existance_with_token($child_id,$child_token);
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
					echo json_encode($responseary);
 			die();	
		}
	  }
 public function check_parent_existance($parent_id,$parent_token)
  {  	
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
  	echo json_encode($responseary);
 			die();
  	}
  }
  
  public function contactus()
  {
	 	$inputpost = $this->input->post();		
     	$responseary = array();
      if($inputpost)
      {
     	 	$user_id = $inputpost['user_id'];
		 	$user_token = $inputpost['user_token'];
		 	$user_type =  $inputpost['user_type'];
		 	$message = $inputpost['message'];
		 	$parent_details = $this->ss_aw_parents_model->check_user($user_id, $user_token);
		 	$child_details = $this->ss_aw_childs_model->check_user($user_id, $user_token);
		 	$subject = $inputpost['subject'];
		 	if (!empty($child_details)) {
		 		$name = $child_details[0]->ss_aw_child_nick_name;
			 	$email = $child_details[0]->ss_aw_child_email;
			 	$mobile = $child_details[0]->ss_aw_child_mobile;
			 	$loginID = $child_details[0]->ss_aw_child_code;
			 	
			 	$subject = "team Feedback from ".$name;
			 	/*$msg .= "<br><br>";
			 	$msg .= "Email Body:";
			 	$msg .= "<br>";*/
			 	$msg .= "Name: ".$name." (Child)<br>";
			 	$msg .= "Email: ".$email."<br>";
			 	$msg .= "Subject: ".$inputpost['subject']."<br>";
			 	$msg .= "Message: ".$inputpost['message']."<br>";
		 	}
		 	elseif (!empty($parent_details)) {
		 		$name = $parent_details[0]->ss_aw_parent_full_name;
			 	$email = $parent_details[0]->ss_aw_parent_email;
			 	$mobile = $parent_details[0]->ss_aw_parent_primary_mobile;
			 	
			 	$subject = "team Feedback from ".$name;
			 	/*$msg .= "<br><br>";
			 	$msg .= "Email Body:";
			 	$msg .= "<br>";*/
			 	$msg .= "Name: ".$name." (Parent)<br>";
			 	$msg .= "Email: ".$email."<br>";
			 	$msg .= "Subject: ".$inputpost['subject']."<br>";
			 	$msg .= "Message: ".$inputpost['message']."<br>";
		 	}

			if($user_type==1)
			{
			 	$this->check_parent_existance($user_id,$user_token);
			 	$parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($user_id);
			 	if (!empty($parent_details)) {
			 		$name = $parent_details[0]->ss_aw_parent_full_name;
			 		$email = $parent_details[0]->ss_aw_parent_email;
			 		$mobile = $parent_details[0]->ss_aw_parent_primary_mobile;
			 		$msg .= "<br>";
			 		$msg .= "Name - ".$name."<br>";
			 		$msg .= "Email - ".$email."<br>";
			 		$msg .= "Mobile - ".$mobile;
			 	}
			}
			elseif ($user_type==2) {
			 	$this->check_child_existance($user_id,$user_token);
			 	$child_details = $this->ss_aw_childs_model->get_child_detail_by_id($user_id);
			 	if (!empty($child_details)) {
			 		$name = $child_details[0]->ss_aw_child_nick_name;
			 		$email = $child_details[0]->ss_aw_child_email;
			 		$mobile = $child_details[0]->ss_aw_child_mobile;
			 		$loginID = $child_details[0]->ss_aw_child_code;
			 		$msg .= "<br>";
			 		$msg .= "Name - ".$name."<br>";
			 		$msg .= "Email - ".$email."<br>";
			 		$msg .= "Mobile - ".$mobile."<br>";
			 		$msg .= "LoginID - ".$loginID;
			 	}
			}

			$msg .= "<br>";
			$msg .= "Warm Regards";
			$msg .= "<br>";
			$msg .= "team™ Team";
	      //$subject = $inputpost['subject'];
			$email = "ateesh@team.com";
			$bcc = "deepanjan@schemaphic.com"; // Send the mail to this account
			$cc = "ateesh@team.com";
			sendmail($msg,$subject,$email,$bcc,"",$cc);
			//sendmail($msg,$subject,$email);
			 
			$responseary['status'] = 200;
			$responseary['msg']  = 'Contact us message send successfully';
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
			 $user_id = $inputpost['user_id'];
			 //$user_token = $inputpost['user_token'];
			 $user_type =  $inputpost['user_type'];  // 1 = Parent , 2 = Child

			 if($user_type==1||$user_type==2)
			 {
				 if($user_type==1)
				 {
					//$this->check_parent_existance($user_id,$user_token);
					$result = $this->ss_aw_parents_model->logout($user_id);
				 }
				 else{
					//$this->check_child_existance($user_id,$user_token);
					$result = $this->ss_aw_childs_model->logout($user_id);		 	
				 }

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
					echo json_encode($responseary);
					 die();	
			 }
		 }
	} 
	
	public function country_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $user_id = $inputpost['user_id'];
			 $user_token = $inputpost['user_token'];
			 $user_type =  $inputpost['user_type'];
			 
			 if ($user_type==2){
				$this->check_child_existance($user_id,$user_token);
				$result = $this->ss_aw_countries_model->get_all_records();
			 }
			 else{
			 	$this->check_parent_existance($user_id,$user_token);
				$result = $this->ss_aw_countries_model->get_all_records();
			 } 
				
				 	 
				 if($result)
					{
						$responseary['status'] = 200;
						$responseary['result'] = $result;
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
	public function state_list()
	{
		$inputpost = $this->input->post();		
		 $responseary = array();
		 if($inputpost)
		 {
			 $user_id = $inputpost['user_id'];
			 $user_token = $inputpost['user_token'];
			 $user_type =  $inputpost['user_type'];
			 $country_id =  $inputpost['country_id'];
			 
			 if ($user_type==2){
				$this->check_child_existance($user_id,$user_token);
				$result = $this->ss_aw_states_model->get_record_by_country($country_id);
			 }
			 else{
			 	$this->check_parent_existance($user_id,$user_token);
				$result = $this->ss_aw_states_model->get_record_by_country($country_id);
			 } 
				
				 	 
				 if($result)
					{
						$responseary['status'] = 200;
						$responseary['result'] = $result;
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
	
	public function update_user_device_token()
	{
		$inputpost = $this->input->post();		
		$responseary = array();
		if($inputpost)
		{
			$user_id = $inputpost['user_id'];
			$user_token = $inputpost['user_token'];
			$user_type =  $inputpost['user_type']; // 1 = Parent, 2 = Child
			$device_token =  $inputpost['device_token'];
			
			if ($user_type==2){
				$this->check_child_existance($user_id,$user_token);
				$data = array();
				$data['ss_aw_device_token'] = $device_token;
				$result = $this->ss_aw_childs_model->update_child_details($data,$user_id);
			}
			else{
				$this->check_parent_existance($user_id,$user_token);
				$data = array();
				$data['ss_aw_device_token'] = $device_token;
				$result = $this->ss_aw_parents_model->update_parent_details($data,$user_id);
				$check_self_registration = $this->ss_aw_childs_model->check_self_registration($user_id);
				if (!empty($check_self_registration)) {
					$result = $this->ss_aw_childs_model->update_child_details($data,$check_self_registration->ss_aw_child_id);
            }
			} 
				 
			$responseary['status'] = 200;
			$responseary['msg'] = 'Device token updated successfully';		
			echo json_encode($responseary);
			die();	
		}
	}

	public function notification(){
   	$inputpost = $this->input->post();
   	$responseary = array();
		if($inputpost)
		{
			$user_id = $inputpost['user_id']; // Child Record ID from Database
			$user_token = $inputpost['user_token']; // Token get after login
			$user_type = $inputpost['user_type'];

			if($user_type == '2' ? $this->check_child_existance($user_id,$user_token) : $this->check_parent_existance($user_id,$user_token)){
				$responseary['status'] = 200;
				$notification_list = $this->ss_aw_notification_model->getallnotification($user_id, $user_type);
				if (!empty($notification_list)) {
					foreach ($notification_list as $key => $value) {
						$responseary['result'][$key]['notification_id'] = $value->id;
						$responseary['result'][$key]['title'] = $value->title;
						$responseary['result'][$key]['notification'] = $value->msg;
						$responseary['result'][$key]['action'] = $value->action;
						$responseary['result'][$key]['params'] = $value->params;
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

   public function marknotificationasread(){
   	$inputpost = $this->input->post();
   	$responseary = array();
		if($inputpost)
		{
			$user_id = $inputpost['user_id']; // Child Record ID from Database
			$user_token = $inputpost['user_token']; // Token get after login
			$user_type = $inputpost['user_type'];
			$notification_id = $inputpost['notification_id'];

			if($user_type == '1' ? $this->check_parent_existance($user_id,$user_token) : $this->check_child_existance($user_id,$user_token)){
				$data = array(
					'read_unread' => 1,
					'id' => $notification_id
				);

				$response = $this->ss_aw_notification_model->update_record($data);
				
				$responseary['status'] = 200;
				if ($response) {
					$responseary['msg'] = "Status updated successfully.";
				}
				else
				{
					$responseary['msg'] = "This is already marked as read.";
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

   public function removenotification(){
   	$inputpost = $this->input->post();
   	$responseary = array();
		if($inputpost)
		{
			$user_id = $inputpost['user_id']; // Child Record ID from Database
			$user_token = $inputpost['user_token']; // Token get after login
			$user_type = $inputpost['user_type'];
			//$notification_id = $inputpost['notification_id'];

			if($user_type == '1' ? $this->check_parent_existance($user_id,$user_token) : $this->check_child_existance($user_id,$user_token)){

				$response = $this->ss_aw_notification_model->archivenotification($user_id, $user_type);
				
				$responseary['status'] = 200;
				if ($response) {
					$responseary['msg'] = "Notification archived successfully.";
				}
				else
				{
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
		}

		die(json_encode($responseary));
   }

   public function notification_count(){
   	$inputpost = $this->input->post();
   	$responseary = array();
		if($inputpost)
		{
			$user_id = $inputpost['user_id']; // Child Record ID from Database
			$user_token = $inputpost['user_token']; // Token get after login
			$user_type = $inputpost['user_type'];
			//$notification_id = $inputpost['notification_id'];

			if($user_type == '1' ? $this->check_parent_existance($user_id,$user_token) : $this->check_child_existance($user_id,$user_token)){

				$response = $this->ss_aw_notification_model->countnotification($user_id, $user_type);
				
				$responseary['status'] = 200;
				$responseary['data']['notification_count'] = $response;
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

   public function states(){
   	$inputpost = $this->input->post();
   	$responseary = array();
		if($inputpost)
		{
			$user_id = $inputpost['user_id'];
			$user_token = $inputpost['user_token'];
			$user_type = $inputpost['user_type'];

			if($user_type == '1' ? $this->check_parent_existance($user_id,$user_token) : $this->check_child_existance($user_id,$user_token)){
				$country_name = "";
				if ($user_type == 1) {
					$parent_details = $this->ss_aw_parents_model->get_parent_profile_details($user_id, $user_token);
					$country_name = $parent_details[0]->ss_aw_parent_country;
				}

				//$result = $this->ss_aw_states_model->getstatelistbycountry(101);
				$result = $this->ss_aw_states_model->getstatelistbycountrysortname($country_name);
								$states = array();
				if (!empty($result)) {
					foreach ($result as $key => $value) {
						$states[$key]['state_id'] = $value->id;
						$states[$key]['state_name'] = $value->name;
						$states[$key]['state_short_name'] = $value->code;
						$states[$key]['country_code'] = $value->phonecode;
					}
				}
				$responseary['status'] = 200;
				$responseary['data'] = $states;
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

   public function test_mail(){
   	$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'smtpout.secureserver.net',
					'smtp_port' => 465,
					'smtp_user' => 'noreply@team.com',
					'smtp_pass' => 'team2021',
					'mailtype'  => 'html', 
					'charset'   => 'utf-8',
					'smtp_crypto' => 'ssl'
				);
				
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('noreply@team.com', 'team');
				$this->email->to("deepanjan.das@gmail.com");
			
				$this->email->subject('Test');
				$this->email->message("Demo test");  

				$result = $this->email->send();

				echo $result;
   }

   public function web_faq()
	{		
	   $responseary = array();

		$result = $this->ss_aw_faq_model->get_recordby_usertype(1);

		if(!empty($result))
		{
			$responseary['status'] = 200;
			$responseary['msg']  = 'Data Found';
			$responseary['result'] = $result;

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