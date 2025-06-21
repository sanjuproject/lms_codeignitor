<?php
set_time_limit(320);
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
class Webhook extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$getdata = $this->input->get();
		$messageid = $getdata['messageid'];
		$status = $getdata['status'];
		$date = $getdata['date'];

		$this->db->where('ss_aw_message_id', $messageid);
		$this->db->set('ss_aw_status', $status);
		$this->db->set('ss_aw_date', $date);
		$response = $this->db->update('ss_aw_advance_email_log');
		if ($response) {
			$msg = "Email log updated successfully.";
		}
		else{
			$msg = "Nothing to update";
		}
		$responseary['status'] = 200;
		$responseary['msg'] = $msg;
		die(json_encode($responseary));
	}
}