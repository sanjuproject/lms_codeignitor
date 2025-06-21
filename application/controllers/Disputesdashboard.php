<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disputesdashboard extends CI_Controller {

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
	}
	public function index()
	{
		$headerdata = array();
		$headerdata = checklogin();	
		
		$headerdata['title'] = "List of Disputes";
		
		$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;
		$status = "";
		$type = "";
	if($this->input->post())
	{
		$status = $this->input->post('status');
		$type = $this->input->post('type');
		if($type == 1)
		{
			$typename = "Sales";
		}
		else if($type == 2)
		{
			$typename = "Courses";
		}
		else if($type == 3)
		{
			$typename = "Payments";
		}
		else if($type == 4)
		{
			$typename = "Others";
		}
	}

// Return the tickets that are new or opend & assigned to you
// If you want to fetch all tickets remove the filter query param
//$url = "https://$yourdomain.freshdesk.com/api/v2/tickets?query=status:3%20OR%20status:4";

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


$responseary = array();
if($info['http_code'] == 200) {
	$responsedata = json_decode($response,true);
	
	
	$contactuser = array();
	$contactuser = $this->contact_details();
	foreach($responsedata as $key=>$value)
	{
		if(!empty($status))
		{
			if($status == $value['status'])
			{
			
			$responseary[$key]['sender_name'] = $contactuser[$value['requester_id']]['name'];
			$responseary[$key]['subject'] = $value['subject'];
			$responseary[$key]['ticket_id'] = $value['id'];
			$responseary[$key]['status'] = $value['status'];
			$responseary[$key]['create_date'] = $value['fr_due_by'];
			$responseary[$key]['type'] = $value['custom_fields']['cf_types'];
			$responseary[$key]['sub_type'] = $value['custom_fields']['cf_sub_types'];
			}
		}
		else
		{
			$responseary[$key]['sender_name'] = $contactuser[$value['requester_id']]['name'];
			$responseary[$key]['subject'] = $value['subject'];
			$responseary[$key]['ticket_id'] = $value['id'];
			$responseary[$key]['status'] = $value['status'];
			$responseary[$key]['create_date'] = $value['fr_due_by'];
			$responseary[$key]['type'] = $value['custom_fields']['cf_types'];
			$responseary[$key]['sub_type'] = $value['custom_fields']['cf_sub_types'];
		}
	}
$temp_responseary = array();	
	foreach($responseary as $key=>$value)
	{
		if(!empty($type))
		{
			
			if($typename == $value['type'])
			{
				$temp_responseary[$key]['sender_name'] = $value['sender_name'];
				$temp_responseary[$key]['subject'] = $value['subject'];
				$temp_responseary[$key]['ticket_id'] = $value['ticket_id'];
				$temp_responseary[$key]['status'] = $value['status'];
				$temp_responseary[$key]['create_date'] = $value['create_date'];
				$temp_responseary[$key]['type'] = $value['type'];
				$temp_responseary[$key]['sub_type'] = $value['sub_type'];
			}
		}
	}

if(!empty($temp_responseary))
{
	unset($responseary);
	$responseary = $temp_responseary;
}
	
} else {
  if($info['http_code'] == 404) {
    echo "Error, Please check the end point \n";
  } else {
    echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
    //echo "Headers are ".$headers;
    //echo "Response are ".$response;
  }
}
curl_close($ch);
	$resultdata = array();
	$resultdata['result'] = $responseary;
	$resultdata['searchstatus'] = $status;
	$resultdata['searchtype'] = $type;
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/disputesdashboard',$resultdata);
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
	
	public function disputedetails()
	{
		$headerdata = array();
		$headerdata = checklogin();	
		$headerdata['title'] = "List of Disputes";
		
$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;

		$ticketid = base64_decode($this->uri->segment(3));
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
		
		
	
		$responseary = array();
		if($info['http_code'] == 200) {
			$responsedata = json_decode($response,true);
			
				$contactuser = array();
				$contactuser = $this->contact_details();
	
				$responseary['sender_email'] = $contactuser[$responsedata['requester_id']]['email'];
				$responseary['subject'] = $responsedata['subject'];
				$responseary['description'] = $responsedata['description_text'];
				$responseary['ticket_id'] = $responsedata['id'];
				$responseary['status'] = $responsedata['status'];
				$responseary['create_date'] = $responsedata['created_at'];
				$responseary['update_date'] = $responsedata['updated_at'];
				$responseary['requester_id'] = $responsedata['requester_id'];
				$responseary['type'] = $responsedata['custom_fields']['cf_types'];
				$responseary['sub_type'] = $responsedata['custom_fields']['cf_sub_types'];
				
				$searchary = array();
				$searchary['ss_aw_parent_email'] = $responseary['sender_email'];
				$usersdetailsary = $this->ss_aw_parents_model->search_byparam($searchary);
				$responseary['parent_device_token'] = $usersdetailsary[0]['ss_aw_device_token'];
				$responseary['parent_id'] = $usersdetailsary[0]['ss_aw_parent_id'];
				if(!empty($usersdetailsary[0]['ss_aw_parent_full_name']))
					$responseary['parent_full_name'] = $usersdetailsary[0]['ss_aw_parent_full_name'];
				else
					$responseary['parent_full_name'] = "";
				if(!empty($usersdetailsary[0]['ss_aw_parent_profile_photo']))
					$responseary['profile_photo'] = base_url()."uploads/".$usersdetailsary[0]['ss_aw_parent_profile_photo'];
				else
					$responseary['profile_photo'] = base_url()."uploads/profile.jpg";
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
					
					$conversion_array[$key]['view']	 = "even";
					
				}
				else
				{
					$conversion_array[$key]['user_name'] = "Admin";
					$conversion_array[$key]['view']	 = "odd";
				}
				$conversion_array[$key]['create_date'] = date('d M, Y H:i:s',strtotime($value['created_at']));
			}
			
			
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
			$resultdata = array();
			$resultdata['result'] = $responseary;
			$resultdata['conversession'] = $conversion_array;
				$this->load->view('admin/header',$headerdata);
				$this->load->view('admin/disputedetails',$resultdata);
	}
	
	public function postreply()
	{
		$headerdata = array();
		checklogin();	
		
		$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;

		$ticketid = $this->input->post('ticket_id');
		$message = $this->input->post('message');
		$subject = $this->input->post('subject');
		$device_token = $this->input->post('device_token');
		$parent_id = $this->input->post('parent_id');
		
		$ticket_data = json_encode(array(
		  "body" => $message,
		));
		$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticketid/reply";

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
		curl_close($ch);
		if($info['http_code'] == 201){
			$this->session->set_flashdata('success','Reply post successfully');
			$title = "ALSOWISE Ticket ID: ".$ticketid;
			$body = $subject." - Admin responded";
			if (!empty($device_token)) {
				pushnotification($title,$body,$device_token,49);	
			}
			
			$save_data = array(
				'user_id' => $parent_id,
				'user_type' => 1,
				'title' => $title,
				'msg' => $body,
				'status' => 1,
				'read_unread' => 0,
				'action' => 49
			);

			save_notification($save_data);
			redirect(base_url().'disputesdashboard/disputedetails/'.base64_encode($ticketid));
		}
		else{
			$this->session->set_flashdata('error','Reply post fail.');
			redirect(base_url().'disputesdashboard/disputedetails/'.base64_encode($ticketid));
		}

	}
	
	public function deleteticket()
	{
		$headerdata = array();
		checklogin();	
		
$api_key = FRESH_DESK_API;
				$password = FRESH_DESK_PASSWORD;
				$yourdomain = FRESH_DESK_DOMAIN;

		$ticketid = $this->input->post('ticket_id');
		
		
		$ticket_data = '{"bulk_action": {"ids": ['. $ticketid .']}}';
		
		$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/bulk_delete";

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
		curl_close($ch);
	
		
		if($info['http_code'] == 202){
			$this->session->set_flashdata('success','Ticket deleted successfully');
			redirect(base_url().'disputesdashboard/index');
		}
		else{
			$this->session->set_flashdata('error','Ticket delete fail.');
			redirect(base_url().'disputesdashboard/index');
		}	
	}
	/*
	Resolved a ticket by admin and wait for patrent close
	*/
	public function updateticketstatus()
	{
		$headerdata = array();
		checklogin();	
		
		$api_key = FRESH_DESK_API;
		$password = FRESH_DESK_PASSWORD;
		$yourdomain = FRESH_DESK_DOMAIN;

		$ticketid = $this->input->post('ticket_id');
		
		$ticket_data = json_encode(array(
		  "status" => 4,
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
	
		if($info['http_code'] == 200){
			$this->session->set_flashdata('success','Ticket resolved and closed successfully');
			redirect(base_url().'disputesdashboard/disputedetails/'.base64_encode($ticketid));
		}
		else{
			$this->session->set_flashdata('error','Ticket update status fail.');
			redirect(base_url().'disputesdashboard/disputedetails/'.base64_encode($ticketid));
		}
		
	}
	
	public function cron_closed_resolved_tickets()
	{
		$api_key = FRESH_DESK_API;
		$password = FRESH_DESK_PASSWORD;
		$yourdomain = FRESH_DESK_DOMAIN;
		$status = 4;
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

		$responseary = array();
		if($info['http_code'] == 200) {
		$responsedata = json_decode($response,true);
		$contactuser = array();
		$contactuser = $this->contact_details();
		$curdate = time();
		$fixedtimediff = (60 * 60) * 48; // 48 Hours
		foreach($responsedata as $key=>$value)
		{
			
			if(!empty($status))
			{
				if($status == $value['status'])
				{
					$updated_date = strtotime($value['updated_at']);
					$datediff = $curdate - $updated_date;
					if($datediff > $fixedtimediff)
					{
						$ticket_data = json_encode(array(
						  "status" => 5,
						  "priority" => 2
						));
						$ticketid = $value['id'];
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
					}
				}
			}
		}		
	} else {
	  if($info['http_code'] == 404) {
		echo "Error, Please check the end point \n";
	  } else {
		echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
		//echo "Headers are ".$headers;
		//echo "Response are ".$response;
	  }
	}
	curl_close($ch);
	}
}