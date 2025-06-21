<?php
/**
 * 
 */
class Pages extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ss_aw_page_content_model');
	}

	public function privacy_policy(){
		$page_id = '3';		
        $data['page_data_content'] = $this->ss_aw_page_content_model->get_page_data($page_id);
		$this->load->view('privacy-policy',$data);
	}
}