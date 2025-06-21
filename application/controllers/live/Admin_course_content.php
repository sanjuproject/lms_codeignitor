<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_course_content extends CI_Controller {

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
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_readalongs_upload_model');
		$this->load->model('ss_aw_readalongs_topics_model');
		$this->load->model('ss_aw_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_model');
		$this->load->helper('directory');
		$this->load->model('ss_aw_supplymentary_uploaded_model');
		$this->load->model('ss_aw_course_count_model');
		$this->load->model('ss_aw_voice_type_matrix_model');
		$this->load->model('ss_aw_supplymentary_model');
		$this->load->model('ss_aw_schedule_readalong_model');
	}
	public function checklogin()
	{
		if(empty($this->session->userdata('id')))
		{
			$this->session->set_flashdata('error','First login to access any page.');
			redirect('admin/index');
		}else
		{
			$headerdata = array();
			$headerdata['profile_name'] = $this->session->userdata('fullname');
			$headerdata['profile_pic'] = $this->session->userdata('profile_pic');
			
			$searchary = array();
			$adminmenuary = $this->ss_aw_adminmenus_model->search_byparam($searchary);
			
			
			$user_role_ids_ary = array();
			$user_role_ids_ary = explode(",",$this->session->userdata('role_ids'));
			
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
	public function lessons()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$search_parent_data = array();
		
		if(!empty($postdata['status_lesson_id']))
		{
			$pageno = $postdata['status_pageno'];
			$status_lesson_id = $postdata['status_lesson_id'];
			$status_lesson_status = $postdata['status_lesson_status'];
			$dataary = array();
			$dataary['ss_aw_lession_id'] = $status_lesson_id;
			$dataary['ss_aw_lesson_status'] = $status_lesson_status;
			$this->ss_aw_lessons_uploaded_model->update_record($dataary);
			
			$this->session->set_flashdata('success','Lesson status succesfully change.');

			redirect('admin_course_content/lessons/'.$pageno);
			
		}
		else if(!empty($postdata['lesson_delete_id']))
		{
			$lesson_delete_id = $postdata['lesson_delete_id'];
			$lesson_delete_process = $postdata['lesson_delete_process'];
			
			/*
				Get Assessments related with this particular Lesson
			*/
				$searchary = array();
				$searchary['ss_aw_lesson_id'] = $lesson_delete_id;
				$searchary['ss_aw_assesment_delete'] = 0;
				$assessment_resultary = array();
				$assessment_resultary = $this->ss_aw_assesment_uploaded_model->fetch_by_params($searchary);
				
			if(empty($assessment_resultary))
			{				
				
				$searchary = array();
				$searchary['ss_aw_lession_id'] = $lesson_delete_id;
				$target_resourceary = array();
				$target_resourceary = $this->ss_aw_lessons_uploaded_model->fetch_databy_param($searchary);
		
				$curserialno = $target_resourceary[0]['ss_aw_sl_no'];
				$lastrecordary = array();
				$lastrecordary = $this->ss_aw_lessons_uploaded_model->fetch_all_slno_desc();
				$lastserialno = $lastrecordary[0]['ss_aw_sl_no'];
				
				for($i=$curserialno + 1;$i<=$lastserialno;$i++)
				{
					$this->ss_aw_lessons_uploaded_model->updateserialno_byoldserial($i);	
				}
				/*
					Delete All Audio Files against this lesson
				*/
				$lessondataary = $this->ss_aw_lessons_model->search_data_by_lesson_record_id($lesson_delete_id);
				foreach($lessondataary as $lvalue)
				{
					if(!empty($lvalue['ss_aw_lesson_audio']))
						unlink($lvalue['ss_aw_lesson_audio']);
					
					if(!empty($lvalue['ss_aw_lesson_details_audio']))
						unlink($lvalue['ss_aw_lesson_details_audio']);
					
					if(!empty($lvalue['ss_aw_lesson_answers_audio']))
						unlink($lvalue['ss_aw_lesson_answers_audio']);
				}
			
				$this->ss_aw_lessons_uploaded_model->remove_record($lesson_delete_id);
			
				$this->session->set_flashdata('success','Lesson deleted succesfully.');
			}
			else
			{
				$this->session->set_flashdata('error','Lesson delete fail.First delete assessment '.$assessment_resultary[0]['ss_aw_assesment_topic'].' which related with this lesson.');
			}
		}
		elseif (!empty($postdata['demo_lesson_availability'])) {
			$pageno = $postdata['demo_pageno'];
			$demo_lesson_id = $postdata['demo_lesson_id'];
			$is_demo = 0;
			if (isset($postdata['is_demo'])) {
				if (count($postdata['is_demo']) > 1) {
					$is_demo = 3;
				}
				else{
					$is_demo = $postdata['is_demo'][0];
				}
			}
			$dataary = array();
			$dataary['ss_aw_lession_id'] = $demo_lesson_id;
			$dataary['ss_aw_is_demo'] = $is_demo;
			$this->ss_aw_lessons_uploaded_model->update_record($dataary);
			$this->session->set_flashdata('success','Lesson demo status succesfully change.');

			redirect('admin_course_content/lessons/'.$pageno);
		}
		
		if(!empty($postdata['search_filter']))
		{
			$search_parent_data['ss_aw_lesson_topic'] = $postdata['topic_name'];
			$search_parent_data['ss_aw_course_id'] = $postdata['choose_level'];
			$search_parent_data['ss_aw_lesson_status'] = $postdata['status'];
			$this->session->set_flashdata('ss_aw_lesson_topic',$search_parent_data['ss_aw_lesson_topic']);
			$this->session->set_flashdata('ss_aw_course_id',$search_parent_data['ss_aw_course_id']);
			$this->session->set_flashdata('ss_aw_lesson_status',$search_parent_data['ss_aw_lesson_status']);
		}else if($this->session->flashdata('ss_aw_lesson_topic')!='' || $this->session->flashdata('ss_aw_course_id')!='' || $this->session->flashdata('ss_aw_lesson_status')!='')
		{
			$search_parent_data['ss_aw_lesson_topic'] = $this->session->flashdata('ss_aw_lesson_topic');
			$search_parent_data['ss_aw_course_id'] = $this->session->flashdata('ss_aw_course_id');
			$search_parent_data['ss_aw_lesson_status'] = $this->session->flashdata('ss_aw_lesson_status');
			
			$this->session->set_flashdata('ss_aw_lesson_topic',$search_parent_data['ss_aw_lesson_topic']);
			$this->session->set_flashdata('ss_aw_course_id',$search_parent_data['ss_aw_course_id']);
			$this->session->set_flashdata('ss_aw_lesson_status',$search_parent_data['ss_aw_lesson_status']);
		}
		
		$headerdata['title'] = "Lessons";
		
		$this->load->library('pagination');
        $config['base_url'] = base_url().'admin_course_content/lessons';
        $config["total_rows"] = $this->ss_aw_lessons_uploaded_model->number_of_records($search_parent_data);
		
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
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
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		/*
			Topic List 
		*/
		$topicary = array();
		$resultary = $this->ss_aw_sections_topics_model->fetchall();
		foreach($resultary as $val)
		{
			if($val['ss_aw_section_status'] == 1 && $val['ss_aw_topic_deleted'] == 1)
			{
				$topicary[$val['ss_aw_section_id']] = $val['ss_aw_section_title'];
			}
		}
		
		/*
			Voice type List 
		*/
		$voicetypeary = array();
		$voicesearchary = array();
		$voicesearchary['ss_aw_category'] = 1;
		$resultary = $this->ss_aw_voice_type_matrix_model->search_byparam($voicesearchary);
		foreach($resultary as $val)
		{
				$voicetypeary[$val['ss_aw_id']] = $val['ss_aw_voice_type'];	
		}
	
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        $lesson_arr = $this->ss_aw_lessons_uploaded_model->get_all_records($config['per_page'],$page,$search_parent_data);
		//echo "<pre>";
        //print_r($lesson_arr);
		//die();
		/* Count lessons against diffarent LEVELs */
		
		$level_e = 0;
		$level_c = 0;
		$level_a = 0;
		$uploaded_lessonsary = $this->ss_aw_lessons_uploaded_model->fetch_all();
		foreach($uploaded_lessonsary as $val)
		{
			if($val['ss_aw_lesson_status'] == 1)
			{
			$level_ary = explode(",",$val['ss_aw_course_id']);
			if(in_array(1,$level_ary))
			{
				$level_e += 1;
			}
			if(in_array(2,$level_ary))
			{
				$level_c += 1;
			}
			if(in_array(3,$level_ary))
			{
				$level_a += 1;
			}
			}
		}
		for($i = 1;$i<4;$i++)
		{
			$updateary = array();
			$updateary['ss_aw_course_id'] = $i;
			if($i == 1)
				$updateary['ss_aw_lessons'] = $level_e;			
			else if($i == 2)
				$updateary['ss_aw_lessons'] = $level_c;
			else if($i == 3)
				$updateary['ss_aw_lessons'] = $level_a;
			//commented out beacause of the course count updated automatically.
			//$this->ss_aw_course_count_model->update_record($updateary);
		}
		
		sort($topicary);
		$data['page'] = $page;
		$data['result'] = $lesson_arr;
		$data['topicslist'] = $this->ss_aw_sections_topics_model->getalltopic();
		$data['voicetypelist'] = $voicetypeary;
		$data['search_parent_data'] = $search_parent_data;
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/lessons',$data);
	}
	
	public function upload_lesson()
	{		
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$lessons_uploaded_ary = array();
		$lessons_uploaded_ary = $this->ss_aw_lessons_uploaded_model->fetch_all();
		$sl_no = 1;
		if(!empty($lessons_uploaded_ary))
		{
			$last_sl_no = $lessons_uploaded_ary[count($lessons_uploaded_ary) - 1]['ss_aw_sl_no']; 
			$sl_no = $last_sl_no + 1;
		}
		
		$lesson_record_ary = array();

		$lesson_record_ary['ss_aw_course_id'] = $postdata['level'];

		if ($postdata['format'] == 'Multiple') {
			$lesson_record_ary['ss_aw_lesson_topic'] = ucwords($postdata['lesson_name']);
			$lesson_record_ary['ss_aw_lesson_topic_id'] = 0;
			$check_duplicate = $this->ss_aw_lessons_uploaded_model->checkduplicatelessonname(ucwords($postdata['lesson_name']), $postdata['level']);
			if ($check_duplicate > 0) {
				$this->session->set_flashdata('error','The given lesson name is already exist.');
				redirect('admin_course_content/lessons');
			}

		}
		else
		{
			$lesson_record_ary['ss_aw_lesson_topic'] = $postdata['topic_name'];
			$lesson_record_ary['ss_aw_lesson_topic_id'] = $postdata['topic'];
		}

		$lesson_record_ary['ss_aw_lesson_format'] = $postdata['format'];
		$lesson_record_ary['ss_aw_language'] = $postdata['language'];
		
		$lesson_record_ary['ss_aw_sl_no'] = $sl_no;
		$audio_type = $postdata['voice_type'];
		$lesson_record_ary['ss_aw_audio_type'] = $audio_type;
		
		$this->ss_aw_lessons_uploaded_model->insert_data($lesson_record_ary);
		$insert_record_id = $this->db->insert_id();
		
		if(isset($_FILES["file"]['name']))
					{
                        $config['upload_path']          = './uploads/';
		                $config['allowed_types']        = 'xls|xlsx';
		                $config['encrypt_name'] = TRUE;
		                
		                $this->load->library('upload', $config);
		                 if (!$this->upload->do_upload('file'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);      
									$this->session->set_flashdata('error','Uploaded file format mismatch.');
									redirect('admin_course_content/lessons');
			                }               
						
						$data = $this->upload->data();
						$lesson_file = $data['file_name'];
					}
					
			$file = './uploads/'.$lesson_file;
 
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
				
				if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
				{
					
					if($cell[0] == 'A')
					{
						$data_value = trim($avalue);
					}
					if($cell[0] == 'B')
					{
						$data_value = trim($bvalue);
					}
					
				}
				else
				{
					if($cell[0] == 'A')
					{
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'B')
					{
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
			
			
			$finalary = array();
			$i = 0;
			$topic = $postdata['topic'];
			$language = $postdata['language'];
			$format = $postdata['format'];
			if($format == "Single")
			{
				foreach($data['values'] as $key=>$value)
				{
					if($key > 2)
					{
						if(strlen($value['D']) > 1)
						{
							$course_ary = array();
							$course_ary = explode(",",$value['D']);
							
							foreach($course_ary as $val2)
							{
								//if($course_ary[0])
								{
									$finalary[$i] = $value;
									$finalary[$i]['D'] = $val2;
								}
								$i++;
							}
						}
						else
						{
							$finalary[$i] = $value;
							$i++;
						}
					}					
				}
			}
			else
			{
				$level = $postdata['level'];
				$finalary = $data['values'];
				
			}
			$i = 1;
			foreach($finalary as $key=>$val)
			{
				if($format == "Single")
				{
					$topic_format_id = $topic."_". 1 ."_".($key+1);
				
				
					$sql = "INSERT INTO `ss_aw_lessons`(`ss_aw_lesson_record_id`,`ss_aw_audio_type`,`ss_aw_language`,`ss_aw_topic_format_id`,`ss_aw_lesson_topic`,`ss_aw_lesson_format`,`ss_aw_course_id`,
					`ss_aw_lesson_format_type`,`ss_aw_lesson_title`, `ss_aw_lesson_details`,`ss_aw_lesson_quiz_type_id`, `ss_aw_lesson_question_options`,
					`ss_aw_lesson_answers`, `ss_aw_lessons_recap`) 
					VALUES ('".$insert_record_id."','".$audio_type."','".$language."','".$topic_format_id."','".$topic."','".$format."','".addslashes($val['D'])."','".addslashes($val['A'])."',
					'".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($val['E'])."','".addslashes($val['F'])."','".addslashes($val['G'])."',
					'".addslashes($val['H'])."')";
					$this->db->query($sql);
					
				}
				else
				{
					if($key > 2)
					{
					if($val['B'] == 'Examples / Details')
					{
						$val['B'] = "";
					}

					$topic = $val['F'];	
					if (empty($topic)) {
						$topic = 0;
					}
					else
					{
						$topic_details = $this->ss_aw_sections_topics_model->gettopicdetailbyreferenceno($topic);
						if (!empty($topic_details)) {
							$topic = $topic_details[0]->ss_aw_section_id;
						}
						else
						{
							$topic = 0;
						}
					}
					$topic_format_id = $topic."_". 2 ."_". $i;
					$lesson_format_type = 7;
					$sql = "INSERT INTO `ss_aw_lessons`(`ss_aw_lesson_record_id`,`ss_aw_audio_type`,`ss_aw_language`,`ss_aw_topic_format_id`,`ss_aw_lesson_topic`,`ss_aw_lesson_format`,`ss_aw_course_id`,
					`ss_aw_lesson_format_type`,`ss_aw_lesson_title`, `ss_aw_lesson_details`,`ss_aw_lesson_quiz_type_id`, `ss_aw_lesson_question_options`,
					`ss_aw_lesson_answers`, `ss_aw_lessons_recap`) 
					VALUES ('".$insert_record_id."','".$audio_type."','".$language."','".$topic_format_id."','".$topic."','".$format."','".$level."','".$lesson_format_type."',
					'".addslashes($val['A'])."','".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($val['D'])."','".addslashes($val['E'])."','')";
					$this->db->query($sql);
					$i++;
					}					
				}
			}
			if($format == "Single")
			{
				$sql = "SELECT `ss_aw_course_id` FROM `ss_aw_lessons` where `ss_aw_lesson_record_id` = $insert_record_id GROUP BY `ss_aw_course_id`";
				$query = $this->db->query($sql);
				
				$courses = "";
				foreach ($query->result() as $row)
				{
					if($row->ss_aw_course_id > 0)
						$courses = $row->ss_aw_course_id.",".$courses;
				}
				$sql = "update `ss_aw_lessons_uploaded` set `ss_aw_course_id` = '$courses' where `ss_aw_lession_id` = $insert_record_id";
				$this->db->query($sql);
			}
		
				
		
		$this->session->set_flashdata('success','Succesfully lesson uploaded.');
		redirect('admin_course_content/lessons');
	}
	
	public function edit_upload_lesson()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$pageno = $postdata['pageno'];
		$lesson_id = $postdata['lesson_id'];
		$audio_type = $postdata['voice_type'];
		
		$lessondataary = $this->ss_aw_lessons_model->search_data_by_lesson_record_id($lesson_id);
		if (!empty($lessondataary)) {
			foreach($lessondataary as $lvalue){
				if(!empty($lvalue['ss_aw_lesson_audio'])){
					@unlink($lvalue['ss_aw_lesson_audio']);
				}
						
				if(!empty($lvalue['ss_aw_lesson_details_audio'])){
					@unlink($lvalue['ss_aw_lesson_details_audio']);
				}
						
				if(!empty($lvalue['ss_aw_lesson_answers_audio'])){
					@unlink($lvalue['ss_aw_lesson_answers_audio']);
				}
			}	
		}
		$this->ss_aw_lessons_model->delete_records_by_lesson($lesson_id);
		
		$insert_record_id = $postdata['lesson_id'];
		
		if(isset($_FILES["file"]['name']))
					{
                        $config['upload_path'] = './uploads/';
		                $config['allowed_types']  = 'xls|xlsx';
		                $config['encrypt_name'] = TRUE;
		                
		                $this->load->library('upload', $config);
		                 if (!$this->upload->do_upload('file'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);      
									$this->session->set_flashdata('error','Uploaded file format mismatch.');
									redirect('admin_course_content/lessons/'.$pageno);
			                }               
						
						$data = $this->upload->data();
						$lesson_file = $data['file_name'];
					}
					
			$file = './uploads/'.$lesson_file;
	
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
				
				if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
				{
					
					if($cell[0] == 'A')
					{
						$data_value = $avalue;
					}
					if($cell[0] == 'B')
					{
						$data_value = $bvalue;
					}
					
				}
				else
				{
					if($cell[0] == 'A')
					{
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'B')
					{
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
				
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			$finalary = array();
			$i = 0;
			$topic = $postdata['topic_id'];
			$language = $postdata['language'];
			$format = $postdata['format'];
			if($format == "Single")
			{
				foreach($data['values'] as $key=>$value)
				{
					if($key > 2)
					{
						if(strlen($value['D']) > 1)
						{
							$course_ary = array();
							$course_ary = explode(",",$value['D']);
							
							foreach($course_ary as $val2)
							{
								//if($course_ary[0])
								{
									$finalary[$i] = $value;
									$finalary[$i]['D'] = $val2;
								}
								$i++;
							}
						}
						else
						{
							$finalary[$i] = $value;
							$i++;
						}
					}					
				}
			}
			else
			{
				$level = $postdata['level'];
				$finalary = $data['values'];
			}
			$i = 1;
			foreach($finalary as $key=>$val)
			{
				if($format == "Single")
				{
					$topic_format_id = $topic."_". 1 ."_".($key+1);
				
				
					$sql = "INSERT INTO `ss_aw_lessons`(`ss_aw_lesson_record_id`,`ss_aw_audio_type`,`ss_aw_language`,`ss_aw_topic_format_id`,`ss_aw_lesson_topic`,`ss_aw_lesson_format`,`ss_aw_course_id`,
					`ss_aw_lesson_format_type`,`ss_aw_lesson_title`, `ss_aw_lesson_details`,`ss_aw_lesson_quiz_type_id`, `ss_aw_lesson_question_options`,
					`ss_aw_lesson_answers`, `ss_aw_lessons_recap`) 
					VALUES ('".$insert_record_id."','".$audio_type."','".$language."','".$topic_format_id."','".$topic."','".$format."','".addslashes($val['D'])."','".addslashes($val['A'])."',
					'".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($val['E'])."','".addslashes($val['F'])."','".addslashes($val['G'])."',
					'".addslashes($val['H'])."')";
					$this->db->query($sql);
					
				}
				else
				{
					if($key > 2)
					{
					if($val['B'] == 'Examples / Details')
					{
						$val['B'] = "";
					}		

					if (!empty($val['F'])) {
							$topic = $val['F'];				
					}				
					$topic_format_id = $topic."_". 2 ."_". $i;
					$lesson_format_type = 7;
					$sql = "INSERT INTO `ss_aw_lessons`(`ss_aw_lesson_record_id`,`ss_aw_audio_type`,`ss_aw_language`,`ss_aw_topic_format_id`,`ss_aw_lesson_topic`,`ss_aw_lesson_format`,`ss_aw_course_id`,
					`ss_aw_lesson_format_type`,`ss_aw_lesson_title`, `ss_aw_lesson_details`,`ss_aw_lesson_quiz_type_id`, `ss_aw_lesson_question_options`,
					`ss_aw_lesson_answers`, `ss_aw_lessons_recap`) 
					VALUES ('".$insert_record_id."','".$audio_type."','".$language."','".$topic_format_id."','".$topic."','".$format."','".$level."','".$lesson_format_type."',
					'".addslashes($val['A'])."','".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($val['D'])."','".addslashes($val['E'])."','')";
					$this->db->query($sql);
					$i++;
					}
				}
			}
			
			//if($format == "Single")
			{
				$sql = "SELECT `ss_aw_course_id` FROM `ss_aw_lessons` where `ss_aw_lesson_record_id` = $insert_record_id GROUP BY `ss_aw_course_id`";
				$query = $this->db->query($sql);
				
				$courses = "";
				foreach ($query->result() as $row)
				{
					if($row->ss_aw_course_id > 0)
						$courses = $row->ss_aw_course_id.",".$courses;
				}
				$update_date = date('Y-m-d H:i:s');
				$sql = "update `ss_aw_lessons_uploaded` set `ss_aw_course_id` = '$courses',`ss_aw_modified_date` = '$update_date' where `ss_aw_lession_id` = $insert_record_id";
				$this->db->query($sql);
			}
			unlink($file);
		$this->session->set_flashdata('success','Succesfully lesson updated.');
		redirect('admin_course_content/lessons/'.$pageno);
	}
	
	function multipledeletelesson()
	{
		$postdata = $this->input->post();
		if(!empty($postdata['selecteddata']))
		{
			$dataary = $postdata['selecteddata'];	
			
			foreach($dataary as $value)
			{
				$deleteary = array();
				$deleteary['ss_aw_lession_id'] = $value;
				$deleteary['ss_aw_lesson_delete'] = 1;
				$this->ss_aw_lessons_uploaded_model->update_record($deleteary);
				$deleted_lessons = $this->ss_aw_lessons_model->getrecordbyid($value);
				if (!empty($deleted_lessons)) {
					foreach($deleted_lessons as $val){
						if (!empty($val['ss_aw_lesson_audio'])) {
			 	 			@unlink($val['ss_aw_lesson_audio']);
			 	 		}
			 	 		
			 	 		if (!empty($val['ss_aw_lesson_details_audio'])) {
			 	 			@unlink($val['ss_aw_lesson_details_audio']);
			 	 		}
			 	 		
			 	 		if (!empty($val['ss_aw_lesson_answers_audio'])) {
			 	 			@unlink($val['ss_aw_lesson_answers_audio']);
			 	 		}
					}
				}
			}
		$this->session->set_flashdata('success','All selected lessons deleted from system.');
		redirect('admin_course_content/lessons', 'refresh');
		}
		
	}
	
	
	
	public function assessments()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$search_parent_data = array();
		$data = array();
		$headerdata['title'] = "Assessments";
		
        $search_parent_data = array();
        $update_arr =  array();
        
        if(!empty($postdata['search_filter']))
		{
			$search_parent_data['ss_aw_assesment_topic'] = $postdata['topic_name'];			
			 $search_parent_data['ss_aw_assesment_status'] = $postdata['status'];
			

			 $this->session->set_flashdata('ss_aw_assesment_topic',$search_parent_data['ss_aw_assesment_topic']);


			 $this->session->set_flashdata('ss_aw_assesment_status',$search_parent_data['ss_aw_assesment_status']);

			
		}
		if($this->session->flashdata('ss_aw_assesment_topic')!=''||$this->session->flashdata('ss_aw_assesment_status')!='')
		{
			
			$search_parent_data['ss_aw_assesment_topic'] = $this->session->flashdata('ss_aw_assesment_topic');
			$search_parent_data['ss_aw_assesment_status'] = $this->session->flashdata('ss_aw_assesment_status');		
			
			$this->session->set_flashdata('ss_aw_assesment_topic',$search_parent_data['ss_aw_assesment_topic']);
			 $this->session->set_flashdata('ss_aw_assesment_status',$search_parent_data['ss_aw_assesment_status']);
		}
		
		if(!empty($postdata['format']))
			{
				$search_parent_data['ss_aw_assesment_format'] = $postdata['format'];			
				
			}
		 if(!empty($postdata['assesment_status_change']))
		 {

		 		$pageno = $postdata['status_pageno'];
		 	 $assesment_id = $postdata['status_assesment_id'];
		 	 $update_arr['ss_aw_assesment_status'] = $postdata['status_assesment_status']; 

		 	 $this->ss_aw_assesment_uploaded_model->update_databyid($assesment_id,$update_arr);
		 		redirect('admin_course_content/assessments/'.$pageno);

		 }

		 if(!empty($postdata['assessment_delete_process']))
		 {
		 	 $assesment_id = $postdata['assessment_delete_id'];
		 	 $update_arr['ss_aw_assesment_delete'] = 1;
		 	 $pageno = $postdata['pageno'];
		 	 //update record as deleted
		 	 $this->ss_aw_assesment_uploaded_model->update_databyid($assesment_id,$update_arr);
		 	 $this->ss_aw_assisment_diagnostic_model->archived_records_by_id($assesment_id);
		 	 //get all records of this assesment
		 	 $deleted_assessment_data = $this->ss_aw_assisment_diagnostic_model->fetchrecordbyid($assesment_id);
		 	 if (!empty($deleted_assessment_data)) {
		 	 	foreach($deleted_assessment_data as $value){
		 	 		if (!empty($value['ss_aw_question_preface_audio'])) {
		 	 			@unlink($value['ss_aw_question_preface_audio']);
		 	 		}
		 	 		
		 	 		if (!empty($value['ss_aw_question_audio'])) {
		 	 			@unlink($value['ss_aw_question_audio']);
		 	 		}
		 	 		
		 	 		if (!empty($value['ss_aw_answers_audio'])) {
		 	 			@unlink($value['ss_aw_answers_audio']);
		 	 		}
		 	 		
		 	 		if (!empty($value['ss_aw_rules_audio'])) {
		 	 			@unlink($value['ss_aw_rules_audio']);
		 	 		}
		 	 		
		 	 		if (!empty($value['ss_aw_rules_audio'])) {
		 	 			@unlink($value['ss_aw_rules_audio']);
		 	 		}
		 	 		
		 	 	}
		 	 }
		 	 $this->session->set_flashdata('success','Assessment record deleted successfully');
		 	 redirect('admin_course_content/assessments/'.$pageno);
		 }

		 	if (!empty($postdata['demo_assessment_availability'])) {
				$pageno = $postdata['demo_pageno'];
				$demo_assessment_id = $postdata['demo_assessment_id'];
				$is_demo = 0;
				if (isset($postdata['is_demo'])) {
					if (count($postdata['is_demo']) > 1) {
						$is_demo = 3;
					}
					else{
						$is_demo = $postdata['is_demo'][0];
					}
				}
				$update_arr = array();
				$update_arr['ss_aw_is_demo'] = $is_demo;
				$this->ss_aw_assesment_uploaded_model->update_databyid($demo_assessment_id,$update_arr);
				$this->session->set_flashdata('success','Assessment demo status succesfully change.');

				redirect('admin_course_content/assessments/'.$pageno);
			}


        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin_course_content/assessments';
        $config["total_rows"] = $this->ss_aw_assesment_uploaded_model->number_of_records($search_parent_data);
		
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
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
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		
		
		
	
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        $assesments_arr = $this->ss_aw_assesment_uploaded_model->get_all_records($config['per_page'],$page,$search_parent_data);
        $data['page'] = $page;
		$data['result'] = $assesments_arr;
		$data['search_parent_data'] = $search_parent_data;
	
		/*
			Topic List 
		*/
		$topicary = array();
		$resultary = $this->ss_aw_sections_topics_model->fetchall();
		foreach($resultary as $val)
		{
			if($val['ss_aw_section_status'] == 1 && $val['ss_aw_topic_deleted'] == 1)
			{
				$topicary[$val['ss_aw_section_id']] = $val['ss_aw_section_title'];
			}
		}
		
		/*
			Lesson List 
		*/
		$lessonary = array();
		$resultary = $this->ss_aw_lessons_uploaded_model->fetch_all();
		foreach($resultary as $val)
		{
			if($val['ss_aw_lesson_status'] == 1)
				$lessonary[$val['ss_aw_lession_id']] = $val['ss_aw_lesson_topic'];	
		}
		
		/*
			Voice type List 
		*/
		$voicetypeary = array();
		$searchary['ss_aw_category'] = 1;
		$resultary = $this->ss_aw_voice_type_matrix_model->search_byparam($searchary);
		foreach($resultary as $val)
		{
				$voicetypeary[$val['ss_aw_id']] = $val['ss_aw_voice_type'];	
		}
		/*
		Count Total Assessments against particular LEVEL
		*/
		$level_e = 0;
		$level_c = 0;
		$level_a = 0;
		$uploaded_lessonsary = $this->ss_aw_assesment_uploaded_model->fetch_all();
		foreach($uploaded_lessonsary as $val)
		{
			if($val['ss_aw_assesment_status'] == 1)
			{
			$level_ary = explode(",",$val['ss_aw_course_id']);
			if(in_array('E',$level_ary))
			{
				$level_e += 1;
			}
			if(in_array('C',$level_ary))
			{
				$level_c += 1;
			}
			if(in_array('A',$level_ary))
			{
				$level_a += 1;
			}
			}
		}
		for($i = 1;$i<4;$i++)
		{
			$updateary = array();
			$updateary['ss_aw_course_id'] = $i;
			if($i == 1)
				$updateary['ss_aw_assessments'] = $level_e;			
			else if($i == 2)
				$updateary['ss_aw_assessments'] = $level_c;
			else if($i == 3)
				$updateary['ss_aw_assessments'] = $level_a;
			//commented out beacause of the course count updated automatically.
			//$this->ss_aw_course_count_model->update_record($updateary);
		}
		sort($topicary);		
		$data['topicslist'] = $topicary;
		$data['lessonslist'] = $lessonary;
		$data['voicetypelist'] = $voicetypeary;
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/assessments',$data);
	}
	
	function multipledeleteassessment()
	{
		$postdata = $this->input->post();
		if(!empty($postdata['selecteddata']))
		{
			$dataary = $postdata['selecteddata'];	
			
			
			if(!empty($postdata['ss_aw_uploaded_record_id']))
			{
				$record_id = $postdata['ss_aw_uploaded_record_id'];
				foreach($dataary as $value)
				{
					$deleteary = array();
					$deleteary['ss_aw_uploaded_record_id'] = $record_id;
					$deleteary['ss_aw_sub_category'] = $value;
					$deleteary['ss_aw_deleted'] = 0;
					$this->ss_aw_assisment_diagnostic_model->delete_record_subtopic($deleteary);
				}
				
				$this->session->set_flashdata('success','All selected assessments deleted from system.');
				redirect('admin_course_content/assessmentsparticulartopic/'.base64_encode($record_id), 'refresh');
			}
			else if(isset($postdata['delete_assisment_diagnostic']))
			{
                if($postdata['delete_assisment_diagnostic'] == 1)
                {

					foreach($dataary as $value)
					{
						$deleteary = array();
						$deleteary['ss_aw_id'] = $value;
						$deleteary['ss_aw_deleted'] = 0;
						$this->ss_aw_assisment_diagnostic_model->update_records($deleteary);
					}
					$this->session->set_flashdata('success','All selected assessments deleted from system.');
					if(!empty($postdata['ss_aw_sub_category']))
					{
						redirect('admin_course_content/assessmentsparticulartopicquestions/'.base64_encode($postdata['ss_aw_sub_category'])."/".base64_encode($postdata['ss_aw_record_id']), 'refresh');
					}
					else
					{
						redirect('admin_course_content/assessmentsparticulartopicquestions/'.base64_encode($postdata['ss_aw_category'])."/".base64_encode($postdata['ss_aw_record_id']), 'refresh');
					}

                }

			}
			else
			{
				foreach($dataary as $value)
				{
					$deleteary = array();
					$deleteary['ss_aw_assessment_id'] = $value;
					$deleteary['ss_aw_assesment_delete'] = 1;
					$this->ss_aw_assesment_uploaded_model->update_record($deleteary);
					$this->ss_aw_assisment_diagnostic_model->archived_records_by_id($assesment_id);
					$deleted_assessment_data = $this->ss_aw_assisment_diagnostic_model->fetchrecordbyid($value);
					if (!empty($deleted_assessment_data)) {
				 	 	foreach($deleted_assessment_data as $val){
				 	 		if (!empty($val['ss_aw_question_preface_audio'])) {
				 	 			@unlink($val['ss_aw_question_preface_audio']);
				 	 		}
				 	 		
				 	 		if (!empty($val['ss_aw_question_audio'])) {
				 	 			@unlink($val['ss_aw_question_audio']);
				 	 		}
				 	 		
				 	 		if (!empty($val['ss_aw_answers_audio'])) {
				 	 			@unlink($val['ss_aw_answers_audio']);
				 	 		}
				 	 		
				 	 		if (!empty($val['ss_aw_rules_audio'])) {
				 	 			@unlink($val['ss_aw_rules_audio']);
				 	 		}
				 	 		
				 	 		if (!empty($val['ss_aw_rules_audio'])) {
				 	 			@unlink($val['ss_aw_rules_audio']);
				 	 		}
				 	 	}
				 	}
				}
				
				$this->session->set_flashdata('success','All selected assessments deleted from system.');
				redirect('admin_course_content/assessments', 'refresh');
			}
		
		}
		
	}
	
	public function assessmentsparticulartopic()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$search_parent_data = array();
		$data = array();
		$headerdata['title'] = "Assessments";
		
		$record_id = base64_decode($this->uri->segment(3));
        $search_parent_data['ss_aw_uploaded_record_id'] = $record_id;
        $update_arr =  array();
      
		if(!empty($postdata))
		{
			if(!empty($postdata['category']))
			{
				$search_parent_data['ss_aw_category'] = $postdata['category'];			
				
			}
			
			if(!empty($postdata['sub_category']))
			{
				$search_parent_data['ss_aw_sub_category'] = $postdata['sub_category'];
				
			}
			
			
		}
		
		 if(!empty($postdata['assessment_delete_process']))
		 {
			 $deleteary = array();
			 $deleteary['ss_aw_sub_category'] = $postdata['sub_topic'];
			 $deleteary['ss_aw_uploaded_record_id'] = $record_id;
		 	 $deleteary['ss_aw_deleted'] = 0;
			 
		 	 $this->ss_aw_assisment_diagnostic_model->delete_record_subtopic($deleteary);


			 $this->session->set_flashdata('success','Sub topic assessments/diagnostic data deleted succesfully.');
		 	
		 }

        $assesments_arr = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($search_parent_data);
        
		$data['result'] = $assesments_arr;
		$data['search_parent_data'] = $search_parent_data;
		$data['record_id'] = base64_encode($record_id);
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/assessmentsparticulartopic',$data);
	}
	
	public function assessmentsparticulartopicquestions()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$search_parent_data = array();
		
		$record_id = base64_decode($this->uri->segment(4));
		$search_subcategory = base64_decode($this->uri->segment(3));
		$data = array();
		$headerdata['title'] = "Assessments";
		
        $search_parent_data['ss_aw_sub_category'] = $search_subcategory;
		$search_parent_data['ss_aw_uploaded_record_id'] = $record_id;
        $update_arr =  array();
        
        if(!empty($postdata))
		{
			if(!empty($postdata['question_form']))
				$search_parent_data['ss_aw_question_format'] = $postdata['question_form'];
			if(!empty($postdata['search_level']))
				$search_parent_data['ss_aw_level'] = $postdata['search_level'];	
			
			if(!empty($postdata['status']))
			{
				if($postdata['status']==2)
					$search_parent_data['ss_aw_status'] = 0;
				else	
					$search_parent_data['ss_aw_status'] = $postdata['status'];
			}		
		}
		
		 if(!empty($postdata['assesment_status_change']))
		 {
		 	 $updateary = array();
		 	 $updateary['ss_aw_id'] = $postdata['ss_aw_id'];
			 if($postdata['status_assesment_status'] == 1)
				$updateary['ss_aw_status'] = 1;
			else
				$updateary['ss_aw_status'] = 0;
			 $this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
			
		 }

		 if(!empty($postdata['assessment_delete_process']))
		 {
			 $updateary = array();
		 	 $updateary['ss_aw_id'] = $postdata['ss_aw_id'];
			 $updateary['ss_aw_deleted'] = 0;
		 	 $this->ss_aw_assisment_diagnostic_model->update_records($updateary);
		 	
		 }

        $assesments_arr = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($search_parent_data);
		
        if(empty($assesments_arr))
		{
			unset($search_parent_data['ss_aw_sub_category']);
			$search_parent_data['ss_aw_category'] = $search_subcategory;
			$assesments_arr = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($search_parent_data);
		}
		$data['result'] = $assesments_arr;
		
		if(!empty($postdata['status']))
		{
			if($postdata['status'] == 2)
			{
				$search_parent_data['ss_aw_status'] = 2;
			}
		}
		$data['search_parent_data'] = $search_parent_data;
		
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/assessmentsparticulartopicquestions',$data);
	}
	
	public function upload_assessment()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		
		
		$assessments_record_ary = array();

		$get_associated_lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($postdata['selected_lesson']);
		if (!empty($get_associated_lesson_detail)) {
			if (!empty($get_associated_lesson_detail[0]->ss_aw_lesson_topic_id)) {
				$assessments_record_ary['ss_aw_assesment_topic_id'] = $get_associated_lesson_detail[0]->ss_aw_lesson_topic_id;
				$topic_detail = $this->ss_aw_sections_topics_model->getrecordbyid($get_associated_lesson_detail[0]->ss_aw_lesson_topic_id);
				$postdata['topic_name'] = $topic_detail[0]->ss_aw_section_title;
			}
			else
			{
				$assessments_record_ary['ss_aw_assesment_topic_id'] = 0;
			}	
		}
		else
		{
			$assessments_record_ary['ss_aw_assesment_topic_id'] = 0;
		}
		
		if (!empty($postdata['lesson_name'])) {
			$assessments_record_ary['ss_aw_assesment_topic'] = $postdata['lesson_name'];
		}
		else
		{
			$assessments_record_ary['ss_aw_assesment_topic'] = $postdata['topic_name'];
		}
		
		$assessments_record_ary['ss_aw_assesment_format'] = $postdata['format'];
		$assessments_record_ary['ss_aw_language'] = $postdata['language'];
		$assessments_record_ary['ss_aw_lesson_id'] = $postdata['selected_lesson'];
		$audio_type = $postdata['voice_type'];
		if($postdata['format'] == "Multiple")
		{
			$assessments_record_ary['ss_aw_course_id'] = $postdata['level'];
		}
		//$this->db->trans_start();
		$this->ss_aw_assesment_uploaded_model->insert_data($assessments_record_ary);
		$insert_record_id = $this->db->insert_id();
		
		if(isset($_FILES["file"]['name']))
					{
                        $config['upload_path']          = './uploads/';
		                $config['allowed_types']        = 'xls|xlsx';
		                $config['encrypt_name'] = TRUE;
		                
		                $this->load->library('upload', $config);
		                 if (!$this->upload->do_upload('file'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);      
									$this->session->set_flashdata('error','Uploaded file format mismatch.');
									redirect('admin_course_content/assessments');
			                }               
						
						$data = $this->upload->data();
						$assessments_file = $data['file_name'];
					}
					
		$file = './uploads/'.$assessments_file;
		
		if($postdata['format'] == "Multiple")
		{
			$assessments_record_ary['insert_record_id'] = $insert_record_id;
			$assessments_record_ary['audio_type'] = $audio_type;
			$this->assesment_multilevel($file,$assessments_record_ary);
		}
		else if($postdata['format'] == "Single")
		{
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
			 
			
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			
			$data['values'] = $arr_data;
			
			
		
			/************* Count E Courses *********************/
			$e_count = 0;
			$c_count = 0;
			$a_count = 0;
			$topic = "";
			$format = "";
			
				
				foreach($data['values'] as $key=>$val)
				{
					if($key > 2)
					{
						$level = trim($val['A']);
						if($level == 'E')
						{
							$e_count++;
						}
						if($level == 'C')
						{
							$c_count++;
						}
						if($level == 'A')
						{
							$a_count++;
						}
					}
					else
					{
						$topic = $val['B'];
						$format = $val['C'];
					}
				}
			$initial_sub_cat = strtolower(trim($data['values'][3]['D']));
			$initial_level = strtolower(trim($data['values'][3]['A']));
			$seq_no = 1;
			/*foreach($data['values'] as $key=>$val)
			{
				if($key > 2)
				{
					if(($initial_sub_cat == strtolower(trim($val['D']))) && ($initial_level == strtolower(trim($val['A']))))
					{
						$data['values'][$key]['B'] = $seq_no;
						$seq_no++;
					}
					else
					{
						$initial_sub_cat = strtolower(trim($val['D']));
						$initial_level = strtolower(trim($val['A']));
						$data['values'][$key]['B'] = 1;
						$seq_no = 2;
					}
				}
			}*/
			
			$e_sq_no = 0;
			$c_sq_no = 0;
			$a_sq_no = 0;
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);
				//$data['values'][$key]['B'] = $topic;
				//$data['values'][$key]['C'] = $format;
				if ($level == 'E') {
					$e_sq_no = $e_sq_no + 1;
				}

				if ($level == 'C') {
					$c_sq_no = $c_sq_no + 1;
				}

				if ($level == 'A') {
					$a_sq_no = $a_sq_no + 1;
				}
					if($val['A'] == 'E' && $e_count > 25)
					{
						$weight = ($e_sq_no * 0.01) + 1;
						$data['values'][$key]['C'] = $weight;
					}else if($level == 'E' && $e_count > 17 && $e_count < 25)
					{
						$weight = ($e_sq_no * 0.02) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'E' && $e_count > 10 && $e_count < 17)
					{
						$weight = ($e_sq_no * 0.03) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'E' && $e_count <= 10)
					{
						$weight = ($e_sq_no * 0.04) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'E' && $e_count == 1)
					{
						$weight = 1;
						$data['values'][$key]['C'] = $weight;
					}
					
					if($level == 'C' && $c_count > 25)
					{
						$weight = (1+($c_sq_no * (0.01)));
						$data['values'][$key]['C'] = $weight;
					}else if($level == 'C' && $c_count > 17 && $c_count < 25)
					{
						$weight = ($c_sq_no * 0.02) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'C' && $c_count > 10 && $c_count < 17)
					{
						$weight = ($c_sq_no * 0.03) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'C' && $c_count <= 10)
					{
						$weight = ($c_sq_no * 0.04) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'C' && $c_count == 1)
					{
						$weight = 1;
						$data['values'][$key]['C'] = $weight;
					}
					
					if($level == 'A' && $a_count > 25)
					{
						$weight = (1+($a_sq_no * (0.01)));
						$data['values'][$key]['C'] = $weight;
					}else if($level == 'A' && $a_count > 17 && $a_count < 25)
					{
						$weight = ($a_sq_no * 0.02) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'A' && $a_count > 10 && $a_count < 17)
					{
						$weight = ($a_sq_no * 0.03) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'A' && $a_count <= 10)
					{
						$weight = ($a_sq_no * 0.04) + 1;
						$data['values'][$key]['C'] = $weight;
					}
					else if($level == 'A' && $a_count == 1)
					{
						$weight = 1;
						$data['values'][$key]['C'] = $weight;
					}
					
					/* Set Assessment or Diagonistic */
					if($val['L'] == 'Assessment (A)')
					{
						$data['values'][$key]['L'] = 2;
					}
					else
					{
						$data['values'][$key]['L'] = 1;
					}						
			}
			$final_output = "";
			$rule_file = "";
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);
				if($key > 2)
				{
					
						$format = trim(str_replace("/ ","",$val['E']));
						if($val['E'] == 2)
						{
							$audio_file = "choose_right_answers.mp3";
							$format = "Choose the right answer";
						}
						else if($val['E'] == 1)
						{
							$audio_file = "fill_the_blanks.mp3";
							$format = "Fill in the blanks";
						}
						else if($val['E'] == 3)
						{
							$audio_file = "rewrite_the_sentence.mp3";
							$format = "Rewrite the sentence";
						}
						
						
					
					$rule_str = trim($val['K']);
					$rule_file = "";
					if($rule_str == 'NA' || $rule_str == '')
					{
						$audio_exist = 1;
					}
					else
					{
						$audio_exist = 2;
					}
					if(!empty($val['F']))
					{
						$question_preference = str_replace("(Sub Category)",$val['D'],$val['F']);
						$question_preference = str_replace("(sub category)",$val['D'],$question_preference);
						
						$rule_str = str_replace("(Column H)",$val['J'],$rule_str);
						$rule_str = str_replace("(Column F)",$val['J'],$rule_str);
						$rule_str = str_replace("(Column J)",$val['J'],$rule_str);
						$this->db->trans_start();
						$sub_category = $val['D'];
						if ($sub_category == 'NA') {
							$topic_detail = $this->ss_aw_sections_topics_model->getrecordbyid($assessments_record_ary['ss_aw_assesment_topic_id']);
							if (!empty($topic_detail)) {
								$sub_category = $topic_detail[0]->ss_aw_section_title;
							}
						}
						$searchary = array();
						$searchary['ss_aw_topic_id'] = $assessments_record_ary['ss_aw_assesment_topic_id'];
						$searchary['ss_aw_section_title'] = trim($sub_category);
						$subtopicary = $this->ss_aw_sections_subtopics_model->get_details_byparam($searchary);
						if(empty($subtopicary))
						{
							$insertary = array();
							$insertary['ss_aw_topic_id'] = $assessments_record_ary['ss_aw_assesment_topic_id'];
							$insertary['ss_aw_section_title'] = trim($sub_category);
							$this->ss_aw_sections_subtopics_model->insert_data($insertary);
						}
						
						$sql = "INSERT INTO `ss_aw_assisment_diagnostic`(`ss_aw_added_by`,`ss_aw_uploaded_record_id`,`ss_aw_audio_type`, `ss_aw_level`,`ss_aw_format`,`ss_aw_seq_no`,`ss_aw_weight`, `ss_aw_category`,
						`ss_aw_sub_category`, `ss_aw_question_format`,`ss_aw_question_preface_audio`,`ss_aw_question_preface`, `ss_aw_question`, `ss_aw_multiple_choice`, `ss_aw_verb_form`,
						`ss_aw_answers`, `ss_aw_rules`, `ss_aw_rules_audio`,`ss_aw_audio_exist`,`ss_aw_quiz_type`) VALUES ('1','".$insert_record_id."','".$audio_type."','".addslashes($level)."','".addslashes($postdata['format'])."',
						'".addslashes($val['B'])."','".addslashes($val['C'])."','".addslashes($postdata['topic_name'])."','".addslashes($val['D'])."','".addslashes($format)."',
						'','".addslashes($question_preference)."','".addslashes($val['G'])."','".addslashes($val['H'])."','".addslashes($val['I'])."',
						'".addslashes($val['J'])."','".addslashes($rule_str)."','".$rule_file."','".$audio_exist."','".addslashes($val['L'])."')";
						$this->db->query($sql);
						$this->db->trans_complete();
					}
				}		
			}	
						$sql = "SELECT `ss_aw_level` FROM `ss_aw_assisment_diagnostic` where `ss_aw_uploaded_record_id` = $insert_record_id GROUP BY `ss_aw_level`";
						$query = $this->db->query($sql);
						
						$courses = "";
						foreach ($query->result() as $row)
						{
							if($row->ss_aw_level!='')
								$courses = $row->ss_aw_level.",".$courses;
						}
						$sql = "update `ss_aw_assesment_uploaded` set `ss_aw_course_id` = '$courses' where `ss_aw_assessment_id` = $insert_record_id";
						$this->db->query($sql);
						
			//$this->db->trans_complete();		
		}
		
		$this->session->set_flashdata('success','Succesfully assessments/diagnostic updated.');
		redirect('admin_course_content/assessments','refresh');			
	}
	
	public function assesment_multilevel($file,$formdata)
	{
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
				
				if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
				{
					if($cell[0] == 'A')
					{
						$data_value = $avalue;
					}
					if($cell[0] == 'B')
					{
						//$data_value = $bvalue;
					}
				}
				else
				{
					if($cell[0] == 'A')
					{
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					else if($cell[0] == 'B')
					{
						//$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					
				}
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			$seq_no = 1;
			foreach($data['values'] as $key=>$val)
			{
				$audio_file = "";
				if($key > 2)
				{
	
						$format = $val['C'];
						
						if($format == 1)
						{
							$audio_file = "fill_the_blanks.mp3";
							$format = "Fill in the blanks";
						}
						else if($format == 2)
						{
							$audio_file = "choose_right_answers.mp3";
							$format = "Choose the right answer";
						}
						else if($format == 3)
						{
							$audio_file = "rewrite_the_sentence.mp3";
							$format = "Rewrite the sentence";
						}
				
				if($formdata['ss_aw_course_id'] == 1)
				{
					$formdata['ss_aw_course_id'] = "E";
				}					
				else if($formdata['ss_aw_course_id'] == 2)
				{
					$formdata['ss_aw_course_id'] = "C";
				}
				else if($formdata['ss_aw_course_id'] == 3)
				{
					$formdata['ss_aw_course_id'] = "A";
				}

				if (!empty($val['F'])) {
					$topic = $val['F'];
					$topic_details = $this->ss_aw_sections_topics_model->gettopicdetailbyreferenceno($topic);
					if (!empty($topic_details)) {
						$topic = $topic_details[0]->ss_aw_section_id;
					}
					else
					{
						$topic = 0;
					}
				}
				else
				{
					$topic = 0;
				}
				$quiz_type = "2";
				$weight = 1;
				$sql = "INSERT INTO `ss_aw_assisment_diagnostic`(`ss_aw_added_by`,`ss_aw_uploaded_record_id`,`ss_aw_audio_type`,`ss_aw_level`,`ss_aw_format`,
				`ss_aw_seq_no`,`ss_aw_weight`, `ss_aw_category`,`ss_aw_question_format`,`ss_aw_question_preface_audio`,`ss_aw_question_preface`,`ss_aw_preface_audio_exist`,
				`ss_aw_question`, `ss_aw_multiple_choice`,`ss_aw_answers`,`ss_aw_quiz_type`,`ss_aw_audio_exist`,`ss_aw_question_topic_id`) VALUES ('1','".$formdata['insert_record_id']."',
				'".$formdata['audio_type']."','".$formdata['ss_aw_course_id']."','".$formdata['ss_aw_assesment_format']."','".$seq_no."','".$weight."',
				'".$formdata['ss_aw_assesment_topic']."','".$format."','','".addslashes($val['A'])."','2','".addslashes($val['B'])."','".addslashes($val['D'])."',
				'".addslashes($val['E'])."','".$quiz_type."','1','".$topic."')";
				$this->db->query($sql);
				$seq_no++;
				
				}
				
			}
		return 1;
	}
	
	
	
	
	public function updateassessment_seqno()
	{
		$headerdata = $this->checklogin();
		$formdata = $this->input->post();
		$target_resourceary = array();
		$paramary = array();
		$paramary['ss_aw_id'] = $formdata['id'];
		$paramary['ss_aw_category'] = $formdata['category'];
		$paramary['ss_aw_sub_category'] = $formdata['sub_category'];
		$paramary['ss_aw_level'] = $formdata['level'];
		$resorucedetailsary = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($paramary);
		
		$paramary = array();
		$paramary['ss_aw_seq_no'] = $formdata['serial_no'];
		$paramary['ss_aw_category'] = $formdata['category'];
		$paramary['ss_aw_sub_category'] = $formdata['sub_category'];
		$paramary['ss_aw_level'] = $formdata['level'];
		$target_resourceary = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($paramary);
		$currentserial_no = $resorucedetailsary[0]['ss_aw_seq_no'];
		
		if(!empty($target_resourceary[0]['ss_aw_id']))
		{
			$target_resourceary = array();
			$paramary = array();
			$paramary['ss_aw_category'] = $formdata['category'];
			$paramary['ss_aw_sub_category'] = $formdata['sub_category'];
			$paramary['ss_aw_level'] = $formdata['level'];
			$target_resourcearytemp = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($paramary);
			foreach($target_resourcearytemp as $value)
			{
				$target_resourceary[$value['ss_aw_seq_no']] = $value;
			}
			
			if($currentserial_no > $formdata['serial_no'])
			{
				
				$serial_no1 = $formdata['serial_no'];//Small Value
				$serial_no2 = $currentserial_no; // Large Serial No

				$recordsary = array();
				for($i = $serial_no1;$i<$serial_no2;$i++)
				{
					if(!empty($target_resourceary[$i]['ss_aw_id']))
					{
						$recordsary[$target_resourceary[$i]['ss_aw_id']] = $target_resourceary[$i]['ss_aw_seq_no'];
					}
					//echo $this->resource_detail_model->updateserialno_byoldserial($i)."<br/>";
				}
				
				foreach($recordsary as $key=>$val)
				{
					$this->ss_aw_assisment_diagnostic_model->update_serialno($val+1,$key);
					
				}
				
			}
			else
			{
				
				$recordsary = array();
				$serial_no2 = $formdata['serial_no']; // Large Serial No
				$serial_no1 = $currentserial_no;  //Small Value
				//print_r($target_resourceary);
				
				for($i = $serial_no2;$i>$serial_no1;$i--)
				{
					
					//$target_resourceary = $this->resource_detail_model->getrecord_byserailno($i);
					if(!empty($target_resourceary[$i]['ss_aw_id']))
						$recordsary[$target_resourceary[$i]['ss_aw_id']] = $target_resourceary[$i]['ss_aw_seq_no'];
					//echo $this->resource_detail_model->updateserialno_byoldserial($i)."<br/>";
				}
				
				foreach($recordsary as $key=>$val)
				{
					$this->ss_aw_assisment_diagnostic_model->update_serialno($val - 1,$key);
				}
			}
			$dataary = array();
			$dataary['ss_aw_id'] = $formdata['id'];
			$dataary['ss_aw_seq_no'] = $formdata['serial_no'];
			$this->ss_aw_assisment_diagnostic_model->update_records($dataary);
			$this->update_weight($formdata['category'],$formdata['sub_category'],$formdata['level']);
			echo 1;
			die();
		}
		else
		{
			
			$this->ss_aw_assisment_diagnostic_model->update_serialno($paramary['ss_aw_seq_no'],$formdata['id']);
			$this->update_weight($formdata['category'],$formdata['sub_category'],$formdata['level']);
			echo 1;
			die();
		}			
	}
	public function update_weight($category,$sub_category,$level)
	{
		$paramary = array();
			$paramary['ss_aw_category'] = $category;
			$paramary['ss_aw_sub_category'] = $sub_category;
			$paramary['ss_aw_level'] = $level;
			$target_resource = $this->ss_aw_assisment_diagnostic_model->fetch_databy_param($paramary);
			
			$count = count($target_resource);
			foreach($target_resource as $value)
			{
				$weight = $this->calculate_weight($level,$value['ss_aw_seq_no'],$count);
				$updateary = array();
				$updateary['ss_aw_id'] = $value['ss_aw_id'];
				$updateary['ss_aw_weight'] = $weight;
				$this->ss_aw_assisment_diagnostic_model->update_records($updateary);
			}
	}
	public function calculate_weight($level,$seq_no,$count)
	{
		if($level == 'E' && $count > 25)
					{
						$weight = ($seq_no * 0.01) + 1;
						
					}else if($level == 'E' && $count > 17 && $count < 25)
					{
						$weight = ($seq_no * 0.02) + 1;
						
					}
					else if($level == 'E' && $count > 10 && $count < 17)
					{
						$weight = ($seq_no * 0.03) + 1;
						
					}
					else if($level == 'E' && $count <= 10)
					{
						$weight = ($seq_no * 0.04) + 1;
						
					}
					else if($level == 'E' && $count == 1)
					{
						$weight = 1;
						
					}
					
					if($level == 'C' && $count > 25)
					{
						$weight = (1+($seq_no * (0.01)));
						
					}else if($level == 'C' && $count > 17 && $count < 25)
					{
						$weight = ($seq_no * 0.02) + 1;
						
					}
					else if($level == 'C' && $count > 10 && $count < 17)
					{
						$weight = ($seq_no * 0.03) + 1;
						
					}
					else if($level == 'C' && $count <= 10)
					{
						$weight = ($seq_no * 0.04) + 1;
						
					}
					else if($level == 'C' && $count == 1)
					{
						$weight = 1;
						
					}
					
					if($level == 'A' && $count > 25)
					{
						$weight = (1+($seq_no * (0.01)));
						
					}else if($level == 'A' && $count > 17 && $count < 25)
					{
						$weight = ($seq_no * 0.02) + 1;
						
					}
					else if($level == 'A' && $count > 10 && $count < 17)
					{
						$weight = ($seq_no * 0.03) + 1;
						
					}
					else if($level == 'A' && $count <= 10)
					{
						$weight = ($seq_no * 0.04) + 1;
						
					}
					else if($level == 'A' && $count == 1)
					{
						$weight = 1;
						
					}
		return $weight;			
	}
	///////////////////////////////////////////////////////////////LESSON ///////////////////////////////////////////////////////////////
	public function updatelesson_seqno()
	{
		$headerdata = $this->checklogin();
		$formdata = $this->input->post();
		$target_resourceary = array();
		$paramary = array();
		$paramary['ss_aw_lession_id'] = $formdata['id'];
		$resorucedetailsary = $this->ss_aw_lessons_uploaded_model->fetch_databy_param($paramary);
		
		$paramary = array();
		$paramary['ss_aw_sl_no'] = $formdata['serial_no'];
		$target_resourceary = $this->ss_aw_lessons_uploaded_model->fetch_databy_param($paramary);
		$currentserial_no = $resorucedetailsary[0]['ss_aw_sl_no'];
		
		if(!empty($target_resourceary[0]['ss_aw_lession_id']))
		{
			$target_resourceary = array();
			$target_resourcearytemp = $this->ss_aw_lessons_uploaded_model->fetch_all();
			foreach($target_resourcearytemp as $value)
			{
				$target_resourceary[$value['ss_aw_sl_no']] = $value;
			}
			
			if($currentserial_no > $formdata['serial_no'])
			{
				
				$serial_no1 = $formdata['serial_no'];//Small Value
				$serial_no2 = $currentserial_no; // Large Serial No

				$recordsary = array();
				for($i = $serial_no1;$i<$serial_no2;$i++)
				{
					if(!empty($target_resourceary[$i]['ss_aw_lession_id']))
					{
						$recordsary[$target_resourceary[$i]['ss_aw_lession_id']] = $target_resourceary[$i]['ss_aw_sl_no'];
					}
					//echo $this->resource_detail_model->updateserialno_byoldserial($i)."<br/>";
				}
				
				foreach($recordsary as $key=>$val)
				{
					$this->ss_aw_lessons_uploaded_model->update_serialno($val+1,$key);
				}
				
			}
			else
			{
				$recordsary = array();
				$serial_no2 = $formdata['serial_no']; // Large Serial No
				$serial_no1 = $currentserial_no;  //Small Value
				//print_r($target_resourceary);
				
				for($i = $serial_no2;$i>$serial_no1;$i--)
				{
					
					//$target_resourceary = $this->resource_detail_model->getrecord_byserailno($i);
					if(!empty($target_resourceary[$i]['ss_aw_lession_id']))
						$recordsary[$target_resourceary[$i]['ss_aw_lession_id']] = $target_resourceary[$i]['ss_aw_sl_no'];
					//echo $this->resource_detail_model->updateserialno_byoldserial($i)."<br/>";
				}
				
				foreach($recordsary as $key=>$val)
				{
					$this->ss_aw_lessons_uploaded_model->update_serialno($val - 1,$key);
				}
			}
			$dataary = array();
			$dataary['ss_aw_lession_id'] = $formdata['id'];
			$dataary['ss_aw_sl_no'] = $formdata['serial_no'];
			$this->ss_aw_lessons_uploaded_model->update_record($dataary);
			echo 1;
			die();
		}
		else
		{
			$this->ss_aw_lessons_uploaded_model->update_serialno($paramary['ss_aw_sl_no'],$formdata['id']);
			
			echo 1;
			die();
		}			
	}
	
	/****************************************** READALONGS SECTION *************************************************/
	public function readalongs()
	{
		$headerdata = array();
		$headerdata = checklogin();	

		$postdata = $this->input->post();
		$search_parent_data = array();
		$data = array();
		$headerdata['title'] = "Readalongs";
		
        $update_arr =  array();
        
		if($this->input->post())
		{
			if(isset($postdata['readalong_status_change']))
			{
			  $update_array['ss_aw_status'] = $postdata['status_readalong_status'];
			  $id = $postdata['status_readalong_id'];
			  $this->ss_aw_readalongs_upload_model->update_record($id,$update_array);
				$this->session->set_flashdata('success','Record updated succesfully');
				
			}
			if(isset($postdata['readalong_delete_process']))
			{
			  
			  $id = $postdata['readalong_delete_id'];
			  $this->ss_aw_readalongs_upload_model->delete_single_record($id);
			  /*
				Delete All Audio Files against this Readalongs
			*/
			$readalongdataary = $this->ss_aw_readalong_model->get_alldata_byrecordid($id);
			foreach($readalongdataary as $lvalue)
			{
				if(!empty($lvalue['ss_aw_readalong_audio']))
					unlink($lvalue['ss_aw_readalong_audio']);				
			}
			$quizary = array();
			$quizary['ss_aw_readalong_upload_id'] = $id;
			$readalongdataary = array();
			$readalongdataary = $this->ss_aw_readalong_quiz_model->search_byparam($quizary);
			foreach($readalongdataary as $lvalue)
			{
				if(!empty($lvalue['ss_aw_answers_audio']))
					unlink($lvalue['ss_aw_answers_audio']);				
			}
			
				$this->session->set_flashdata('success','Record deleted succesfully');
				
			}
		
			if(!empty($postdata['search_filter']))
			{

				$search_parent_data['ss_aw_status'] = $postdata['status'];
				if($search_parent_data['ss_aw_status']=="")
				{
					unset($search_parent_data['ss_aw_status']);
				}
				else
				{
					$this->session->set_flashdata('ss_aw_status',$search_parent_data['ss_aw_status']);
				}
				$search_parent_data['ss_aw_title'] = $postdata['title'];
				if($search_parent_data['ss_aw_title']=="")
				{
					unset($search_parent_data['ss_aw_title']);
				}
				else
				{
					$this->session->set_flashdata('ss_aw_title',$search_parent_data['ss_aw_title']);
				}
				$search_parent_data['ss_aw_topic'] = $postdata['topic'];
				if($search_parent_data['ss_aw_topic']=="")
				{
					unset($search_parent_data['ss_aw_topic']);
				}
				else
				{
					$this->session->set_flashdata('ss_aw_topic',$search_parent_data['ss_aw_topic']);
				}
				$search_parent_data['ss_aw_created_date'] = $postdata['publish_date'];
				if($search_parent_data['ss_aw_created_date']=="")
				{
					unset($search_parent_data['ss_aw_created_date']);
				}
				else
				{
					$this->session->set_flashdata('ss_aw_created_date',$search_parent_data['ss_aw_created_date']);
				}
				
			}
			redirect('admin_course_content/readalongs');
		}
		else
		{
			if($this->session->flashdata('ss_aw_title')!='')
			{	
				$search_parent_data['ss_aw_title'] = $this->session->flashdata('ss_aw_title');			
				$this->session->set_flashdata('ss_aw_title',$search_parent_data['ss_aw_title']);
			}
			if($this->session->flashdata('ss_aw_status')!='')
			{	
				$search_parent_data['ss_aw_status'] = $this->session->flashdata('ss_aw_status');			
				$this->session->set_flashdata('ss_aw_status',$search_parent_data['ss_aw_status']);
			}
			if($this->session->flashdata('ss_aw_topic')!='')
			{	
				$search_parent_data['ss_aw_topic'] = $this->session->flashdata('ss_aw_topic');			
				$this->session->set_flashdata('ss_aw_topic',$search_parent_data['ss_aw_topic']);
			}
			if($this->session->flashdata('ss_aw_created_date')!='')
			{	
				$search_parent_data['ss_aw_created_date'] = $this->session->flashdata('ss_aw_created_date');			
				$this->session->set_flashdata('ss_aw_created_date',$search_parent_data['ss_aw_created_date']);
			}
			
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin_course_content/readalongs';
        $config["total_rows"] = $this->ss_aw_readalongs_upload_model->number_of_records_daterange($search_parent_data);
		
		
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
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
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
		
        $readalong_arr = $this->ss_aw_readalongs_upload_model->get_all_records_daterange($config['per_page'],$page,$search_parent_data);
        $data['page'] = $page;
		$data['result'] = $readalong_arr;
		$data['search_parent_data'] = $search_parent_data;

		
		/*
			Topic List 
		*/
		$topicary = array();
		$resultary = $this->ss_aw_readalongs_topics_model->fetchall();
		foreach($resultary as $val)
		{
			if($val['ss_aw_section_status'] == 1 && $val['ss_aw_topic_deleted'] == 1)
			{
				$topicary[] = $val['ss_aw_section_title'];
			}
		}
		
		$data['topicslist'] = $topicary;
		
		/*
			Voice type List 
		*/
		$voicetypeary = array();
	
		$resultary = $this->ss_aw_voice_type_matrix_model->search_byparam();
		foreach($resultary as $val)
		{
				$voicetypeary[$val['ss_aw_id']] = $val['ss_aw_voice_type'];	
		}
		$data['voicetypelist'] = $voicetypeary;
		/*
			Update Readalongs count against particular LEVELs
		*/		
		
		$level_e = 0;
		$level_c = 0;
		$level_a = 0;
		$uploaded_lessonsary = $this-> ss_aw_readalongs_upload_model->fetch_all();
		foreach($uploaded_lessonsary as $val)
		{
			if($val['ss_aw_status'] == 1)
			{
				$level_ary = explode(",",$val['ss_aw_level']);
				if(in_array('E',$level_ary))
				{
					$level_e += 1;
				}
				if(in_array('C',$level_ary))
				{
					$level_c += 1;
				}
				if(in_array('A',$level_ary))
				{
					$level_a += 1;
				}
			}
		}
		for($i = 1;$i<4;$i++)
		{
			$updateary = array();
			$updateary['ss_aw_course_id'] = $i;
			if($i == 1)
				$updateary['ss_aw_readalong'] = $level_e;			
			else if($i == 2)
				$updateary['ss_aw_readalong'] = $level_c;
			else if($i == 3)
				$updateary['ss_aw_readalong'] = $level_a;

			//commented out beacause of the course count updated automatically.
			//$this->ss_aw_course_count_model->update_record($updateary);
		}
	
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/readalongs',$data);
		}
	}
	
	public function upload_readalongs()
	{
		if($this->input->post())
		{
			$postdata = $this->input->post();

			$readalongs_record_ary = array();
			$readalongs_record_ary['ss_aw_type'] = $postdata['type'];
			$readalongs_record_ary['ss_aw_topic'] = $postdata['topic_name'];
			$readalongs_record_ary['ss_aw_title'] = $postdata['title'];
			$readalongs_record_ary['ss_aw_level'] = $postdata['level'];
			$audio_type = $postdata['voice_type'];
			$readalongs_record_ary['ss_aw_audio_type'] = $audio_type;
		
			if(isset($_FILES["file"]['name']))
						{
							$config['upload_path'] = './uploads/';
							$config['allowed_types'] = 'zip';
							$config['encrypt_name'] = TRUE;
							
							$folder_path = $config['upload_path']. str_replace(" ","_",$postdata['title'].'_'.time()."/");
							mkdir($folder_path,0777);
							
							$config['upload_path'] = $folder_path;
							
							$this->load->library('upload', $config);
							 if (!$this->upload->do_upload('file'))
								{
									   //echo "not success";
									   $error = array('error' => $this->upload->display_errors());
									   print_r($error);      
										$this->session->set_flashdata('error','Uploaded file format mismatch.');
										redirect('admin_course_content/readalongs');
								}
							else
							{	
								$data = array('upload_data' => $this->upload->data());
								$full_path = $data['upload_data']['full_path'];
								$actual_filename = str_replace(".zip","",$data['upload_data']['orig_name']);
								
								$zip = new ZipArchive;
						 
								if ($zip->open($full_path) === TRUE)
								{
									$zip->extractTo(FCPATH.$folder_path);
									$zip->close();
								}
						 
								$params = array('success' => 'Extracted successfully!');
   
								//$data = $this->upload->data();
								$readalong_file = $data['upload_data']['file_name'];
								
							}
						}
		$this->db->trans_start();	
		$readalongs_record_ary['ss_aw_upload_file'] = $config['upload_path'].$readalong_file;
		$this->ss_aw_readalongs_upload_model->insert_record($readalongs_record_ary);
		$insert_record_id = $this->db->insert_id();
		
			//load the excel library
			$this->load->library('excel');			
			$map = directory_map($config['upload_path']);
			

			
			
			//foreach($map["$actual_filename\\"] as $value) // LOCAL
			foreach($map["$actual_filename/"] as $value)
			{
				if(!is_array($value))
				{
					$ext = pathinfo($value, PATHINFO_EXTENSION);
					if($ext == 'xlsx' || $ext == 'xls')
					{
						
						$file = $folder_path.$actual_filename.'/'.$value;
						
						//read file from path
						$objPHPExcel = @PHPExcel_IOFactory::load($file);
						 
						//get only the Cell Collection
						$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
						 
						$data = array();
						$arr_data = array();
						$header = array();
						//extract to a PHP readable array format
						foreach ($cell_collection as $cell) {
							
							$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
							$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
							
							$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
						
						
													
							if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
									{
										
										if($cell[0] == 'A')
										{
											$data_value = $avalue;
										}
										
										if($cell[0] == 'B')
										{
											$data_value = $bvalue;
										}
										
									}
									else
									{
										if($cell[0] == 'A')
										{
											$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
										}
										if($cell[0] == 'B')
										{
											$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
										}
										
										
									}
						
							//The header will/should be in row 1 only. of course, this can be modified to suit your need.
							if ($row == 1) {
								$header[$row][$column] = $data_value;
							} else {
								$arr_data[$row][$column] = $data_value;
							}
								
						}
						
						//send the data in an array format
						$data['header'] = $header;
						$data['values'] = $arr_data;
						
						
						if(strtolower(trim($data['header'][1]['E'])) == 'multiple choice options')
						{
							foreach($data['values'] as $key=>$val)
							{
								if($key > 2)
								{
								if(!empty($val['A']))
								{
									$audio_file = "";	
									if($val['D'] == 2)
									{
										$audio_file = "choose_right_answers.mp3";
									}
									else if($val['D'] == 1)
									{
										$audio_file = "fill_the_blanks.mp3";
									}
									else if($val['D'] == 3)
									{
										$audio_file = "rewrite_the_sentence.mp3";
									}	
									
									$sql = "INSERT INTO `ss_aw_readalong_quiz`(`ss_aw_readalong_upload_id`,`ss_aw_audio_type`,`ss_aw_content_type`,
									`ss_aw_details`,`ss_aw_question`,`ss_aw_quiz_type`,`ss_aw_quiz_type_audio`,`ss_aw_multiple_choice`,`ss_aw_answers`)
									VALUES ('".$insert_record_id."','".$audio_type."','".addslashes($val['A'])."','".addslashes($val['B'])."',
									'".addslashes($val['C'])."','".addslashes($val['D'])."','".$audio_file."','".addslashes($val['E'])."','".addslashes($val['F'])."')";
									$this->db->query($sql);
								}
								}
							}
							
						}
						else
						{
						
							foreach($data['values'] as $key=>$val)
							{
								if(!empty($val['C']) || !empty($val['D']))
								{
									if(empty($val['C']))
									{
										$content = $val['D'];
										$image = "";
									}
									else if(strtolower($val['C']) == 't')
									{
										$content = $val['D'];
										$image = "T";
									}
									else
									{
										$content =  $val['D'];
										$image = $actual_filename."/assets/".addslashes($val['C']);
									}
								$sql = "INSERT INTO `ss_aw_readalong`(`ss_aw_readalong_upload_id`,`ss_aw_audio_type`,`ss_aw_level`,`ss_aw_topic`,
								`ss_aw_content`,`ss_aw_image`, `ss_aw_voiceover`, `ss_aw_text_visible`) VALUES ('".$insert_record_id."',
								'".$audio_type."','".addslashes($postdata['level'])."','".addslashes($postdata['topic_name'])."',
								'".addslashes($content)."','".$image."','".addslashes($val['B'])."','".addslashes($val['A'])."')";
								$this->db->query($sql);
								}
							}
						}
					}
				}
			}				
		}
		$this->db->trans_complete();
		
		$this->session->set_flashdata('success','Succesfully readalongs updated.');
		redirect('admin_course_content/readalongs');			
	}
	
	public function edit_upload_readalongs()
	{
		if($this->input->post())
		{
			$postdata = $this->input->post();

			$record_id = $postdata['rec_id'];
			//$this->ss_aw_readalongs_upload_model->delete_single_record($record_id);
			
			
			$readalongs_record_ary = array();
			$readalongs_record_ary['ss_aw_type'] = $postdata['type'];
			$readalongs_record_ary['ss_aw_topic'] = $postdata['topic_name'];
			$readalongs_record_ary['ss_aw_title'] = $postdata['title'];
			$readalongs_record_ary['ss_aw_level'] = $postdata['level'];
			$audio_type = $postdata['audio_type'];
			
			if(!empty($_FILES["file"]['name']))
						{
							$config['upload_path'] = './uploads/';
							$config['allowed_types'] = 'zip';
							$config['encrypt_name'] = TRUE;
							
							$folder_path = $config['upload_path']. str_replace(" ","_",$postdata['title'].'_'.time()."/");
							mkdir($folder_path,0777);
							
							$config['upload_path'] = $folder_path;
							
							$this->load->library('upload', $config);
							 if (!$this->upload->do_upload('file'))
								{
									   //echo "not success";
									   $error = array('error' => $this->upload->display_errors());
									   print_r($error);      
										$this->session->set_flashdata('error','Uploaded file format mismatch.');
										redirect('admin_course_content/readalongs');
								}
							else
							{	
								$this->ss_aw_readalong_quiz_model->delete_single_record($record_id);
								$this->ss_aw_readalong_model->delete_single_record($record_id);
								$data = array('upload_data' => $this->upload->data());
								$full_path = $data['upload_data']['full_path'];
								$actual_filename = (str_replace(".zip","",$data['upload_data']['orig_name']));
								
								$zip = new ZipArchive;
						 
								if ($zip->open($full_path) === TRUE)
								{
									$zip->extractTo(FCPATH.$folder_path);
									$zip->close();
								}
						 
								$params = array('success' => 'Extracted successfully!');
   
								//$data = $this->upload->data();
								$readalong_file = $data['upload_data']['file_name'];
								
							}
						}
						else
						{
							$this->ss_aw_readalongs_upload_model->update_record($record_id,$readalongs_record_ary);
							$this->session->set_flashdata('success','Succesfully readalongs updated.');
							redirect('admin_course_content/readalongs');	
						}
						
		$this->db->trans_start();	
		$readalongs_record_ary['ss_aw_upload_file'] = $config['upload_path'].$readalong_file;
		$this->ss_aw_readalongs_upload_model->update_record($record_id,$readalongs_record_ary);
		$insert_record_id = $record_id;
		
			//load the excel library
			$this->load->library('excel');			
			$map = directory_map($config['upload_path']);
		
			//foreach($map["$actual_filename\\"] as $value) // For Local
			foreach($map["$actual_filename/"] as $value)
			{
				if(!is_array($value))
				{
					$ext = pathinfo($value, PATHINFO_EXTENSION);
					if($ext == 'xlsx' || $ext == 'xls')
					{
						
						$file = $folder_path.$actual_filename.'/'.$value;
						
						//read file from path
						$objPHPExcel = @PHPExcel_IOFactory::load($file);
						 
						//get only the Cell Collection
						$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
						 
						$data = array();
						$arr_data = array();
						$header = array();
						//extract to a PHP readable array format
						foreach ($cell_collection as $cell) {
							
							$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
							$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
							
							$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
						
						
													
							if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
									{
										
										if($cell[0] == 'A')
										{
											$data_value = $avalue;
										}
										
										if($cell[0] == 'B')
										{
											$data_value = $bvalue;
										}
										
									}
									else
									{
										if($cell[0] == 'A')
										{
											$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
										}
										if($cell[0] == 'B')
										{
											$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
										}
										
										
									}
						
							//The header will/should be in row 1 only. of course, this can be modified to suit your need.
							if ($row == 1) {
								$header[$row][$column] = $data_value;
							} else {
								$arr_data[$row][$column] = $data_value;
							}
								
						}
						
						//send the data in an array format
						$data['header'] = $header;
						$data['values'] = $arr_data;
						
						if(strtolower(trim($data['header'][1]['E'])) == 'multiple choice options')
						{
							foreach($data['values'] as $key=>$val)
							{
								if($key > 2)
								{
								if(!empty($val['A']))
								{
									$audio_file = "";	
									if($val['D'] == 2)
									{
										$audio_file = "choose_right_answers.mp3";
									}
									else if($val['D'] == 1)
									{
										$audio_file = "fill_the_blanks.mp3";
									}
									else if($val['D'] == 3)
									{
										$audio_file = "rewrite_the_sentence.mp3";
									}	
									
									$sql = "INSERT INTO `ss_aw_readalong_quiz`(`ss_aw_readalong_upload_id`,`ss_aw_audio_type`,`ss_aw_content_type`,
									`ss_aw_details`,`ss_aw_question`,`ss_aw_quiz_type`,`ss_aw_quiz_type_audio`,`ss_aw_multiple_choice`,`ss_aw_answers`)
									VALUES ('".$insert_record_id."','".$audio_type."','".addslashes($val['A'])."','".addslashes($val['B'])."',
									'".addslashes($val['C'])."','".addslashes($val['D'])."','".$audio_file."','".addslashes($val['E'])."','".addslashes($val['F'])."')";
									$this->db->query($sql);
								}
								}
							}
							
						}
						else
						{
							foreach($data['values'] as $key=>$val)
							{
								if(!empty($val['C']) || !empty($val['D']))
								{
									if(empty($val['C']))
									{
										$content = $val['D'];
										$image = "";
									}
									else if(strtolower($val['C']) == 't')
									{
										$content = $val['D'];
										$image = "T";
									}
									else
									{
										$content =  $val['D'];
										$image = $actual_filename."/assets/".addslashes($val['C']);
									}
								$sql = "INSERT INTO `ss_aw_readalong`(`ss_aw_readalong_upload_id`,`ss_aw_audio_type`,`ss_aw_level`,`ss_aw_topic`,
								`ss_aw_content`,`ss_aw_image`, `ss_aw_voiceover`, `ss_aw_text_visible`) VALUES ('".$insert_record_id."',
								'".$audio_type."','".addslashes($postdata['level'])."','".addslashes($postdata['topic_name'])."',
								'".addslashes($content)."','".$image."','".addslashes($val['B'])."','".addslashes($val['A'])."')";
								$this->db->query($sql);
								
								}
							}
						}
					}
				}
			}				
		}
		$this->db->trans_complete();
		$this->session->set_flashdata('success','Succesfully readalongs updated.');
		redirect('admin_course_content/readalongs/'.$postdata['page_no']);			
	}
	
	function multipledeletereadalong()
	{
		$postdata = $this->input->post();
		if(!empty($postdata['selecteddata']))
		{
			$dataary = $postdata['selecteddata'];	
			
			foreach($dataary as $value)
			{
				$deleteary = array();
				$deleteary['ss_aw_deleted'] = 0;
				$this->ss_aw_readalongs_upload_model->update_record($value,$deleteary);
			}
		$this->session->set_flashdata('success','All selected readalongs deleted from system.');
		redirect('admin_course_content/readalongs', 'refresh');
		}
		
	}
	
	public function readalongstopics()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$search_parent_data = array();
		$headerdata['title'] = "Readalongstopics";
		
		if($postdata)
		{
			if(isset($postdata['add_readlong']))
			{
				$insert_array['ss_aw_section_title'] = $postdata['read_name'];
				$insert_array['ss_aw_expertise_level'] = implode(",",$postdata['read_level']);
				
				$this->ss_aw_readalongs_topics_model->insert_record($insert_array);
				
				$this->session->set_flashdata('success','Readalongs topic added succesfully.');
				
			}

			if(isset($postdata['update_readlong']))
			{
				$update_array['ss_aw_section_title'] = $postdata['edit_topic'];
				$update_array['ss_aw_expertise_level'] = implode(",",$postdata['edit_topiclevel']);
				$id = $postdata['edit_id'];
				$old_details = $this->ss_aw_readalongs_topics_model->fetch_by_id($id);
				$response = $this->ss_aw_readalongs_topics_model->update_record($id,$update_array);
				if ($response) {
					$old_topic_name = $old_details[0]->ss_aw_section_title;
					$this->ss_aw_readalongs_upload_model->update_topic_names($old_topic_name, $postdata['edit_topic']);
					$this->session->set_flashdata('success','Record updated succesfully');
				}
				else{
					$this->session->set_flashdata('error','Nothing to update.');
				}
				
			}
			if(isset($postdata['topic_status_change']))
			{
			  $update_array['ss_aw_section_status'] = $postdata['status_topic_status'];
			  $id = $postdata['status_topic_id'];
			  $this->ss_aw_readalongs_topics_model->update_record($id,$update_array);
				$this->session->set_flashdata('success','Record updated succesfully');
				
			}
			if(isset($postdata['topic_delete_process']))
			{
			  $update_array['ss_aw_topic_deleted'] = '0';
			  $id = $postdata['topic_delete_id'];
			  $this->ss_aw_readalongs_topics_model->update_record($id,$update_array);
				$this->session->set_flashdata('success','Record deleted succesfully');
				
			}
		
			if(!empty($postdata['search_filter']))
			{

				$search_parent_data['ss_aw_section_status'] = $postdata['status'];
				if($search_parent_data['ss_aw_section_status']=="")
				{
					unset($search_parent_data['ss_aw_section_status']);
				}
				else
				{
					$this->session->set_flashdata('ss_aw_section_status',$search_parent_data['ss_aw_section_status']);
				}			
			}
			redirect('admin_course_content/readalongstopics');
		}
		else
		{
			if($this->session->flashdata('ss_aw_section_status')!='')
			{
			   
				
				$search_parent_data['ss_aw_section_status'] = $this->session->flashdata('ss_aw_section_status');			
				$this->session->set_flashdata('ss_aw_section_status',$search_parent_data['ss_aw_section_status']);
			}
		
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin_course_content/readalongstopics';
			$config["total_rows"] = $this->ss_aw_readalongs_topics_model->number_of_records($search_parent_data);
			
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
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
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			/*
				Topic List 
			*/
			$topicary = array();
			
			
		
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			$topicary = $this->ss_aw_readalongs_topics_model->get_all_records($config['per_page'],$page,$search_parent_data);
			
			$data['page'] = $page;
			$data['result'] = $topicary;
			if(isset($search_parent_data['ss_aw_section_status']))
			{
				if($search_parent_data['ss_aw_section_status']==0)
				{
					$search_parent_data['ss_aw_section_status']=2;
				}
			}    

			$data['search_parent_data'] = $search_parent_data;
			$this->load->view('admin/header',$headerdata);
			$this->load->view('admin/readalongstopics',$data);
		}
	}
	
	function multipledeletereadalongtopic()
	{
		$postdata = $this->input->post();
		if(!empty($postdata['selecteddata']))
		{
			$dataary = $postdata['selecteddata'];	
			
			foreach($dataary as $value)
			{
				$deleteary = array();
				$deleteary['ss_aw_topic_deleted'] = 0;
				$this->ss_aw_readalongs_topics_model->update_record($value,$deleteary);
			}
		$this->session->set_flashdata('success','All selected readalong topic deleted from system.');
		redirect('admin_course_content/readalongstopics', 'refresh');
		}
		
	}
	
	public function ajax_readalongtopics()
	{
			$topicary = array();
			$postdata = $this->input->post();
			$topicary = $this->ss_aw_readalongs_topics_model->fetch_record_by_level($postdata['level']);
			$topicslist = array();
			foreach($topicary as $val)
			{
				if($val['ss_aw_section_status'] == 1 && $val['ss_aw_topic_deleted'] == 1)
					$topicslist[] = $val['ss_aw_section_title'];
			}
			echo json_encode($topicslist);
			die();
	}
	
	/***************************************************  SUPPLYMENTARY ***************************************************************/
	public function supplementary()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$search_parent_data = array();
		
		if(!empty($postdata['status_supplementary_id']))
		{
			$status_id = $postdata['status_supplementary_id'];
			$status = $postdata['status_supplementary_status'];
			$dataary = array();
			$dataary['ss_aw_id'] = $status_id;
			$dataary['ss_aw_status'] = $status;
			$this->ss_aw_supplymentary_uploaded_model->update_record($dataary);
			
			$this->session->set_flashdata('success','Supplementary status succesfully change.');
			
		}
		else if(!empty($postdata['supplementary_delete_id']))
		{
			$delete_id = $postdata['supplementary_delete_id'];
			$delete_process = $postdata['supplementary_delete_process'];
			$dataary = array();
			$dataary['ss_aw_id'] = $delete_id;
			$dataary['ss_aw_delete'] = $delete_process;
			$this->ss_aw_supplymentary_uploaded_model->delete_single_record($delete_id);
			
			
			/*
				Delete All Audio Files against this Supplementary Lesson
			*/
			$supplymentarydataary = $this->ss_aw_supplymentary_model->get_alldata_byrecordid($delete_id);
			foreach($supplymentarydataary as $lvalue)
			{
				if(!empty($lvalue['ss_aw_question_preface_audio']))
					unlink($lvalue['ss_aw_question_preface_audio']);
				
				if(!empty($lvalue['ss_aw_answers_audio']))
					unlink($lvalue['ss_aw_answers_audio']);
				
				if(!empty($lvalue['ss_aw_rules_audio']))
					unlink($lvalue['ss_aw_rules_audio']);
			}
			
			$this->session->set_flashdata('success','Supplementary deleted succesfully.');
		}
		
		if(!empty($postdata['search_filter']))
		{
			$search_parent_data['ss_aw_course_name'] = $postdata['course_name'];
			
			$search_parent_data['ss_aw_level'] = $postdata['choose_level'];
			
			$search_parent_data['ss_aw_status'] = $postdata['status'];
			$this->session->set_flashdata('ss_aw_course_name',$search_parent_data['ss_aw_course_name']);
			$this->session->set_flashdata('ss_aw_level',$search_parent_data['ss_aw_level']);
			$this->session->set_flashdata('ss_aw_status',$search_parent_data['ss_aw_status']);
		}else
		{
			$search_parent_data['ss_aw_course_name'] = $this->session->flashdata('ss_aw_course_name');
			$search_parent_data['ss_aw_level'] = $this->session->flashdata('ss_aw_level');
			$search_parent_data['ss_aw_status'] = $this->session->flashdata('ss_aw_status');
			
			$this->session->set_flashdata('ss_aw_course_name',$search_parent_data['ss_aw_course_name']);
			$this->session->set_flashdata('ss_aw_level',$search_parent_data['ss_aw_level']);
			$this->session->set_flashdata('ss_aw_status',$search_parent_data['ss_aw_status']);
		}
		
		$headerdata['title'] = "Supplementary Content";
		
		$this->load->library('pagination');
        $config['base_url'] = base_url().'admin_course_content/supplementary';
        $config["total_rows"] = $this->ss_aw_supplymentary_uploaded_model->number_of_records($search_parent_data);
		
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
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
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		/*
			Topic List 
		*/
		$topicary = array();
		$resultary = $this->ss_aw_sections_topics_model->fetchall();
		foreach($resultary as $val)
		{
			if($val['ss_aw_section_status'] == 1 && $val['ss_aw_topic_deleted'] == 1)
			{
				$topicary[$val['ss_aw_section_id']] = $val['ss_aw_section_title'];
			}
		}
		
		/*
			Voice type List 
		*/
		$voicetypeary = array();
		$searchary['ss_aw_category'] = 1;
		$resultary = $this->ss_aw_voice_type_matrix_model->search_byparam($searchary);
		foreach($resultary as $val)
		{
				$voicetypeary[$val['ss_aw_id']] = $val['ss_aw_voice_type'];	
		}
	
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        $lesson_arr = $this->ss_aw_supplymentary_uploaded_model->get_all_records($config['per_page'],$page,$search_parent_data);
		//echo "<pre>";
        //print_r($lesson_arr);
		//die();
		asort($topicary);
		$data['page'] = $page;
		$data['result'] = $lesson_arr;
		$data['topicslist'] = $topicary;
		$data['voicetypelist'] = $voicetypeary;
		$data['search_parent_data'] = $search_parent_data;
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/supplementary',$data);
	}
	
	public function upload_supplymentary()
	{		
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		
		$lesson_record_ary = array();
		$lesson_record_ary['ss_aw_course_name'] = $postdata['course_name'];
		$lesson_record_ary['ss_aw_description'] = $postdata['course_details'];
		$lesson_record_ary['ss_aw_level'] = $postdata['level'];
		$topic_name = $postdata['topic_name'];
		$lesson_record_ary['ss_aw_topic'] = $topic_name;
		
		$audio_type = $postdata['voice_type'];
		$lesson_record_ary['ss_aw_voice_type'] = $audio_type;
		$this->db->trans_start();
		$this->ss_aw_supplymentary_uploaded_model->insert_data($lesson_record_ary);
		$insert_record_id = $this->db->insert_id();
		
		if(isset($_FILES["file"]['name']))
					{
                        $config['upload_path']          = './uploads/';
		                $config['allowed_types']        = 'xls|xlsx';
		                $config['encrypt_name'] = TRUE;
		                
		                $this->load->library('upload', $config);
		                 if (!$this->upload->do_upload('file'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);      
									$this->session->set_flashdata('error','Uploaded file format mismatch.Allow only XLS or XLSX file.');
									redirect('admin_course_content/supplementary');
			                }               
						
						$data = $this->upload->data();
						$lesson_file = $data['file_name'];
					}
					
			$file = './uploads/'.$lesson_file;
 
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
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			//echo "<pre>";
			//print_r($data);
			//die();
			
			$finalary = array();
			
			
						
			$finalary = $data['values'];
			
			$audio_file = "";
			$added_by = $this->session->userdata('id');
			foreach($finalary as $key=>$val)
			{
				if($key > 2)
				{
				$format = $val['B'];
						
						if($format == 1)
						{
							$audio_file = "fill_the_blanks.mp3";
							$format = "Fill in the blanks";
						}
						else if($format == 2)
						{
							$audio_file = "choose_right_answers.mp3";
							$format = "Choose the right answer";
						}
						else if($format == 3)
						{
							$audio_file = "rewrite_the_sentence.mp3";
							$format = "Rewrite the sentence";
						}
				$question_preference = str_replace("(Sub Category)",$val['A'],$val['C']);
				$question_preference = str_replace("(sub category)",$val['A'],$question_preference);
				$rule_str = addslashes(str_replace(array('(Colum H)','(Column H)','(Column G)','(Column D)'),$val['D'],$val['H']));

						
					$sql = "INSERT INTO `ss_aw_supplymentary`(`ss_aw_record_id`,`ss_aw_added_by`,`ss_aw_audio_type`,`ss_aw_level`,`ss_aw_category`,`ss_aw_sub_category`, `ss_aw_question_format`,
					`ss_aw_question_format_audio`, `ss_aw_question_preface`, `ss_aw_question`, `ss_aw_multiple_choice`, `ss_aw_answers`,`ss_aw_verb_form`, `ss_aw_rules`)
					VALUES ('".$insert_record_id."','".$added_by."','".$audio_type."','".$postdata['level']."','".$topic_name."','".addslashes($val['A'])."','".$format."','".$audio_file."',
					'".$question_preference."','".addslashes($val['D'])."','".addslashes($val['E'])."','".addslashes($val['G'])."','".addslashes($val['F'])."','".$rule_str."')";
					
					$this->db->query($sql);
				}
			}
			$this->db->trans_complete();
		$this->session->set_flashdata('success','Succesfully supplementary contents uploaded.');
		redirect('admin_course_content/supplementary');
	}
	
	public function edit_upload_supplementary()
	{		
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		$topic_name = $postdata['topic_name'];
		$lesson_record_ary = array();
		$audio_type = $postdata['voice_type'];
		$sql = "delete from `ss_aw_supplymentary` where `ss_aw_record_id` = '".$postdata['supplementary_id']."'";
		$this->db->query($sql);
		$insert_record_id = $postdata['supplementary_id'];
		
		if(isset($_FILES["file"]['name']))
					{
                        $config['upload_path']          = './uploads/';
		                $config['allowed_types']        = 'xls|xlsx';
		                $config['encrypt_name'] = TRUE;
		                
		                $this->load->library('upload', $config);
		                 if (!$this->upload->do_upload('file'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);      
									$this->session->set_flashdata('error','Uploaded file format mismatch.');
									redirect('admin_course_content/lessons');
			                }               
						
						$data = $this->upload->data();
						$lesson_file = $data['file_name'];
					}
					
			$file = './uploads/'.$lesson_file;
 
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
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;
			
			//echo "<pre>";
			//print_r($data);
			//die();
			
			$finalary = array();
			
			
						
			$finalary = $data['values'];
			
			$audio_file = "";
			$added_by = $this->session->userdata('id');
			foreach($finalary as $key=>$val)
			{
				if($key > 2)
				{
				$format = $val['B'];
						
						if($format == 1)
						{
							$audio_file = "fill_the_blanks.mp3";
							$format = "Fill in the blanks";
						}
						else if($format == 2)
						{
							$audio_file = "choose_right_answers.mp3";
							$format = "Choose the right answer";
						}
						else if($format == 3)
						{
							$audio_file = "rewrite_the_sentence.mp3";
							$format = "Rewrite the sentence";
						}
				$question_preference = str_replace("(Sub Category)",$val['A'],$val['C']);
				$question_preference = str_replace("(sub category)",$val['A'],$question_preference);
				$rule_str = addslashes(str_replace(array('(Colum H)','(Column H)','(Column G)','(Column D)'),$val['D'],$val['H']));
						
					$sql = "INSERT INTO `ss_aw_supplymentary`(`ss_aw_record_id`,`ss_aw_added_by`,`ss_aw_audio_type`,`ss_aw_level`,`ss_aw_category`,`ss_aw_sub_category`, `ss_aw_question_format`,
					`ss_aw_question_format_audio`, `ss_aw_question_preface`, `ss_aw_question`, `ss_aw_multiple_choice`, `ss_aw_answers`,`ss_aw_verb_form`, `ss_aw_rules`)
					VALUES ('".$insert_record_id."','".$added_by."','".$audio_type."','".$postdata['level']."','".$topic_name."','".addslashes($val['A'])."','".$format."','".$audio_file."',
					'".$question_preference."','".addslashes($val['D'])."','".addslashes($val['E'])."','".addslashes($val['G'])."','".addslashes($val['F'])."','".$rule_str."')";
					
					$this->db->query($sql);
				}
			}
		$this->session->set_flashdata('success','Succesfully supplementary contents uploaded.');
		redirect('admin_course_content/supplementary');
	}
	
	function multipledeletesupplementary()
	{
		$postdata = $this->input->post();
		if(!empty($postdata['selecteddata']))
		{
			$dataary = $postdata['selecteddata'];	
			
			foreach($dataary as $value)
			{
				$deleteary = array();
				$deleteary['ss_aw_id'] = $value;
				$deleteary['ss_aw_delete'] = 1;
				$this->ss_aw_supplymentary_uploaded_model->update_record($deleteary);
			}
		$this->session->set_flashdata('success','All selected supplementary deleted from system.');
		redirect('admin_course_content/supplementary', 'refresh');
		}
		
	}
	
	public function ajax_sectiontopics()
	{
			$topicary = array();
			$postdata = $this->input->post();
			$topicary = $this->ss_aw_sections_topics_model->get_topiclist_bylevel($postdata['level']);
			
			$topicslist = array();
			foreach($topicary as $key=>$val)
			{
				if($val['ss_aw_section_status'] == 1 && $val['ss_aw_topic_deleted'] == 1)
					$topicslist[$key]['id'] = $val['ss_aw_section_id'];
					$topicslist[$key]['title'] = $val['ss_aw_section_title'];
			}
			echo json_encode($topicslist);
			die();
	}
	
	
	
	
	
	public function upload_assessment_additional()
	{
		$headerdata = $this->checklogin();
		$postdata = $this->input->post();
		
		$assessments_record_ary = array();
		$insert_record_id = $postdata['ss_aw_record_id'];
		$searchary = array();
		$searchary['ss_aw_uploaded_record_id'] = $insert_record_id;
		$searchresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
		
		$searchary['ss_aw_category'] = $searchresult[0]['ss_aw_category'];
		$searchary['ss_aw_sub_category'] = $postdata['ss_aw_sub_category'];
		
		
		$audio_type = $searchresult[0]['ss_aw_audio_type'];
		$postdata['topic_name']= $searchresult[0]['ss_aw_category'];
		if($postdata['format'] == "Multiple")
		{
			$assessments_record_ary['ss_aw_course_id'] = $postdata['level'];
		}
		
		
		if(isset($_FILES["file"]['name']))
					{
                        $config['upload_path']          = './uploads/';
		                $config['allowed_types']        = 'xls|xlsx';
		                $config['encrypt_name'] = TRUE;
		                
		                $this->load->library('upload', $config);
		                 if (!$this->upload->do_upload('file'))
			                {
			                       //echo "not success";
			                       $error = array('error' => $this->upload->display_errors());
			                       print_r($error);      
									$this->session->set_flashdata('error','Uploaded file format mismatch.');
									redirect('admin_course_content/assessments');
			                }               
						
						$data = $this->upload->data();
						$assessments_file = $data['file_name'];
					}
					
		$file = './uploads/'.$assessments_file;
		
		if($postdata['format'] == "Multiple")
		{
			$searchary = array();
			$searchary['ss_aw_assessment_id'] = $insert_record_id;
			$searchresult = $this->ss_aw_assesment_uploaded_model->fetch_by_params($searchary);
		
			$assessments_record_ary['ss_aw_assesment_topic_id'] = $searchresult[0]['ss_aw_assesment_topic_id'];
			$assessments_record_ary['ss_aw_assesment_topic'] = $searchresult[0]['ss_aw_assesment_topic'];
			$assessments_record_ary['ss_aw_assesment_format'] = $searchresult[0]['ss_aw_assesment_format'];
			$assessments_record_ary['ss_aw_language'] = $searchresult[0]['ss_aw_language'];
			$assessments_record_ary['ss_aw_lesson_id'] = $searchresult[0]['ss_aw_lesson_id'];
			$assessments_record_ary['insert_record_id'] = $insert_record_id;
			$assessments_record_ary['audio_type'] = $audio_type;
			$this->assesment_multilevel($file,$assessments_record_ary);
		}
		else if($postdata['format'] == "Single")
		{
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();
			 
			
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			 
			//send the data in an array format
			$data['header'] = $header;
			
			$data['values'] = $arr_data;
			
			
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);	
					/* Set Assessment or Diagonistic */
					if($val['L'] == 'Assessment (A)')
					{
						$data['values'][$key]['L'] = 2;
					}
					else
					{
						$data['values'][$key]['L'] = 1;
					}						
			}
			$final_output = "";
			$rule_file = "";
			
			
			foreach($data['values'] as $key=>$val)
			{
				$level = trim($val['A']);
				
				if($key > 2)
				{
					$val['D'] = $postdata['ss_aw_sub_category'];
					$searchary['ss_aw_level'] = $level;
		
				/*
					Create array of existing seq.no 
				*/
				$existingrecordary = array();
				$existingrecordary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
				$seqnoary = array();
				foreach($existingrecordary as $value)
				{
					$seqnoary[] = $value['ss_aw_seq_no'];
				}
					
					$seq_noary = (explode(".",$val['B']));
					$val['B'] = $seq_noary[0] + $seq_noary[1];
					
						$format = trim(str_replace("/ ","",$val['E']));
						if($val['E'] == 2)
						{
							$audio_file = "choose_right_answers.mp3";
							$format = "Choose the right answer";
						}
						else if($val['E'] == 1)
						{
							$audio_file = "fill_the_blanks.mp3";
							$format = "Fill in the blanks";
						}
						else if($val['E'] == 3)
						{
							$audio_file = "rewrite_the_sentence.mp3";
							$format = "Rewrite the sentence";
						}
						
						
					
					$rule_str = trim($val['K']);
					$rule_file = "";
					if($rule_str == 'NA' || $rule_str == '')
					{
						$audio_exist = 1;
					}
					else
					{
						$audio_exist = 2;
					}
					if(!empty($val['F']))
					{
						if(in_array($val['B'],$seqnoary))
						{
							$this->db->trans_start();
							$searchresult = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam($searchary);
							
							foreach($searchresult as $seqval)
							{
								if($seqval['ss_aw_seq_no'] >= $val['B'])
								{									
									$newsq_no = $seqval['ss_aw_seq_no'] + 1;
									$updateary = array();
									$updateary['ss_aw_seq_no'] = $newsq_no;
									$updateary['ss_aw_id'] = $seqval['ss_aw_id'];
									$this->ss_aw_assisment_diagnostic_model->update_records($updateary);	
								}
							}
						}
						
						$question_preference = str_replace("(Sub Category)",$val['D'],$val['F']);
						$question_preference = str_replace("(sub category)",$val['D'],$question_preference);
						
						$rule_str = str_replace("(Column H)",$val['J'],$rule_str);
						$rule_str = str_replace("(Column F)",$val['J'],$rule_str);
						
						$sql = "INSERT INTO `ss_aw_assisment_diagnostic`(`ss_aw_added_by`,`ss_aw_uploaded_record_id`,`ss_aw_audio_type`, `ss_aw_level`,`ss_aw_format`,`ss_aw_seq_no`,`ss_aw_weight`, `ss_aw_category`,
						`ss_aw_sub_category`, `ss_aw_question_format`,`ss_aw_question_preface_audio`,`ss_aw_question_preface`, `ss_aw_question`, `ss_aw_multiple_choice`, `ss_aw_verb_form`,
						`ss_aw_answers`, `ss_aw_rules`, `ss_aw_rules_audio`,`ss_aw_audio_exist`,`ss_aw_quiz_type`) VALUES ('1','".$insert_record_id."','".$audio_type."','".addslashes($level)."','".addslashes($postdata['format'])."',
						'".addslashes($val['B'])."','0','".addslashes($postdata['topic_name'])."','".addslashes($val['D'])."','".addslashes($format)."',
						'','".addslashes($question_preference)."','".addslashes($val['G'])."','".addslashes($val['H'])."','".addslashes($val['I'])."',
						'".addslashes($val['J'])."','".addslashes($rule_str)."','".$rule_file."','".$audio_exist."','".addslashes($val['L'])."')";
						$this->db->query($sql);
						
						$this->db->trans_complete();	
					}
					
					$this->update_weight($searchary['ss_aw_category'],$searchary['ss_aw_sub_category'],$level);
				}		
			}	
			
			
						$sql = "SELECT `ss_aw_level` FROM `ss_aw_assisment_diagnostic` where `ss_aw_uploaded_record_id` = $insert_record_id GROUP BY `ss_aw_level`";
						$query = $this->db->query($sql);
						
						$courses = "";
						foreach ($query->result() as $row)
						{
							if($row->ss_aw_level!='')
								$courses = $row->ss_aw_level.",".$courses;
						}
			//$this->db->trans_complete();		
		}
		
		$this->session->set_flashdata('success','Succesfully assessments/diagnostic updated.');
		redirect('admin_course_content/assessmentsparticulartopicquestions/'.base64_encode($searchary['ss_aw_sub_category'])."/".base64_encode($postdata['ss_aw_record_id']), 'refresh');			
	}

	public function getlessonbylevel(){
		$course_id = $this->input->get('level');
		$format = $this->input->get('format');
		if (!empty($format)) {
			if ($format == 'Single') {
				$data['result'] = $this->ss_aw_lessons_uploaded_model->getsinglelessons();
			}
			else
			{
				if (!empty($course_id)) {
					if ($course_id == 'E') {
						$level = 1;
					}
					elseif($course_id == 'C'){
						$level = 2;
					}
					elseif($course_id == 'A'){
						$level = 3;
					}
					else{
						$level = 4;
					}

					$data['result'] = $this->ss_aw_lessons_uploaded_model->getlessonsbylevel($level);	
				}
				else
				{
					$data['result'] = array();
				}
			}
		}
		else
		{
			$data['result'] = array();
		}
		
		$this->load->view('admin/ajax/lessonlist', $data);
	}

	public function readalong_details(){
		$headerdata = $this->checklogin();
		$readalong_id = $this->uri->segment(3);
		$readalong_details = $this->ss_aw_readalong_model->get_alldata_byrecordid($readalong_id);
		$readalong_upload_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
		$data['result'] = $readalong_details;
		$data['upload_details'] = $readalong_upload_details;
		$headerdata['title'] = $readalong_upload_details[0]->ss_aw_title;
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/readalong_details',$data);
	}

	public function upload_readalong_audio(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$readalong_id = $postdata['readalong_id'];
			$readalong_upload_id = $postdata['readalong_upload_id'];
			$audio_details = $this->ss_aw_readalong_model->fetch_detail_byid($readalong_id);
			$readalong_title = trim($audio_details[0]->readalong_name);
      $readalong_title = str_replace(" ", "_", strtolower($readalong_title));
      //create directory
      $upload_path = "assets/audio/readalong/".$readalong_title;
      if (!file_exists($upload_path)) {
        mkdir($upload_path, 0777, true);
      }
      //end
			if (!empty($audio_details)) {
				if (!empty($audio_details[0]->ss_aw_readalong_audio)) {
					unlink($audio_details[0]->ss_aw_readalong_audio);
				}
			}
			if(isset($_FILES["file"]['name'])) {
        $config['upload_path']  = './'.$upload_path;
		    $config['allowed_types'] = 'mp3';
		    $config['encrypt_name'] = TRUE;
		                
		    $this->load->library('upload', $config);
		    if (!$this->upload->do_upload('file')){
			    $error = array('error' => $this->upload->display_errors());
			    print_r($error);      
					$this->session->set_flashdata('error','Uploaded file format mismatch.');
					redirect('admin_course_content/readalong_details/'.$readalong_upload_id);
			  }               
						
				$data = $this->upload->data();
				$lesson_file = $data['file_name'];
				$upload_file_path = $upload_path."/".$lesson_file;

				$update_data = array(
					'ss_aw_readalong_id' => $readalong_id,
					'ss_aw_readalong_audio' => $upload_file_path,
					'ss_aw_audio_exist' => 1
				);
				
				$response = $this->ss_aw_readalong_model->update_readalong_details($update_data);
				
				if ($response) {
					$this->session->set_flashdata('success','Audio uploaded succesfully.');
				}
				else{
					$this->session->set_flashdata('error','Something went wrong, please try again later.');
				}
			}
			else{
				$this->session->set_flashdata('error','No file uploaded.');
			}

			redirect('admin_course_content/readalong_details/'.$readalong_upload_id);

		}
	}

	public function upload_readalong_content(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$readalong_upload_id = $postdata['readalong_upload_id'];
			$content = $postdata['content'];
			$readalong_id = $postdata['content_id'];

			$update_data = array(
				'ss_aw_readalong_id' => $readalong_id,
				'ss_aw_content' => $content
			);
				
			$response = $this->ss_aw_readalong_model->update_readalong_details($update_data);
				
			if ($response) {
				$this->session->set_flashdata('success','Content updated succesfully.');
			}
			else{
				$this->session->set_flashdata('error','Something went wrong, please try again later.');
			}
			redirect('admin_course_content/readalong_details/'.$readalong_upload_id);
		}
	}

	public function upload_readalong_image(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$readalong_upload_id = $postdata['readalong_upload_id'];
			$readalong_id = $postdata['upload_image_id'];
			$readalong_upload_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_upload_id);
			$zipfile_path = explode("/",$readalong_upload_details[0]->ss_aw_upload_file);

      //create directory
      $upload_path = $zipfile_path[1]."/".$zipfile_path[2]."/images";
      if (!file_exists($upload_path)) {
        mkdir($upload_path, 0777, true);
      }
      //end

			if(isset($_FILES["content_image"]['name'])) {
        $config['upload_path']  = './'.$upload_path;
		    $config['allowed_types'] = 'jpg|JPG|jpeg|JPEG|png|PNG';
		    $config['encrypt_name'] = TRUE;
		                
		    $this->load->library('upload', $config);
		    if (!$this->upload->do_upload('content_image')){
			    $error = array('error' => $this->upload->display_errors());
			    print_r($error);      
					$this->session->set_flashdata('error','Uploaded file format mismatch.');
					redirect('admin_course_content/readalong_details/'.$readalong_upload_id);
			  }               
						
				$data = $this->upload->data();
				$lesson_file = $data['file_name'];
				$upload_file_path = "images/".$lesson_file;

				$update_data = array(
					'ss_aw_readalong_id' => $readalong_id,
					'ss_aw_image' => $upload_file_path
				);
				
				$response = $this->ss_aw_readalong_model->update_readalong_details($update_data);

				if ($response) {
					$this->session->set_flashdata('success','Image uploaded succesfully.');
				}
				else{
					$this->session->set_flashdata('error','Something went wrong, please try again later.');
				}
			}
			else{
				$this->session->set_flashdata('error','No file uploaded.');
			}

			redirect('admin_course_content/readalong_details/'.$readalong_upload_id);
		}
	}

	public function lesson_details(){
		$headerdata = $this->checklogin();
		$lesson_id = $this->uri->segment(3);
		$upload_lesson_details = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
		$headerdata['title'] = $upload_lesson_details[0]->ss_aw_lesson_topic;
		$data['upload_lesson_details'] = $upload_lesson_details;
		$lesson_details = array();

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$course_level = $this->input->post('course_level');

			if (isset($postdata['upload_lesson_details'])) {

				$details_id = $postdata['details_id'];
				$lesson_details = $postdata['lesson_details'];

				$lesson_details_audio = $this->ss_aw_lessons_model->search_data_by_param(array('ss_aw_lession_id' => $details_id));
				if (!empty($lesson_details_audio)) {
					$audio_file = $lesson_details_audio[0]['ss_aw_lesson_details_audio'];
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}

				$update_data = array(
					'ss_aw_lesson_details' => $lesson_details,
					'ss_aw_details_audio_exist' => 2,
					'ss_aw_lesson_details_audio' => ''
				);
				$response = $this->ss_aw_lessons_model->update_details($update_data, $details_id);
				if ($response) {
					$this->session->set_flashdata('success','Details updated succesfully.');
				}
				else{
					$this->session->set_flashdata('error','No change in data.');
				}
			}

			if (isset($postdata['upload_lesson_title'])) {
				$title_id = $postdata['title_id'];
				$lesson_title = $postdata['lesson_title'];

				$lesson_details_audio = $this->ss_aw_lessons_model->search_data_by_param(array('ss_aw_lession_id' => $title_id));
				if (!empty($lesson_details_audio)) {
					$audio_file = $lesson_details_audio[0]['ss_aw_lesson_audio'];
					if (file_exists($audio_file)) {
						unlink($audio_file);
					}
				}

				$update_data = array(
					'ss_aw_lesson_title' => $lesson_title,
					'ss_aw_lesson_audio_exist' => 2,
					'ss_aw_lesson_audio' => ''
				);
				$response = $this->ss_aw_lessons_model->update_details($update_data, $title_id);
				if ($response) {
					$this->session->set_flashdata('success','Title updated succesfully.');
				}
				else{
					$this->session->set_flashdata('error','No change in data.');
				}
			}

			$data['course_id'] = $course_level;
			$lesson_details = $this->ss_aw_lessons_model->getrecordbyidlevel($lesson_id, $course_level);
		}
		
		$data['lesson_details'] = $lesson_details;
		$this->load->view('admin/header',$headerdata);
		$this->load->view('admin/lesson_details',$data);
	}

	public function upload_readalong_quiz(){
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$readalong_upload_id = $postdata['readalong_upload_id'];
			$audio_type = $postdata['readalong_audio_type'];
			if(isset($_FILES["file"]['name']))
			{
        $config['upload_path'] = './uploads/';
		    $config['allowed_types'] = 'xls|xlsx';
		    $config['encrypt_name'] = TRUE;
		                
		    $this->load->library('upload', $config);
		    if (!$this->upload->do_upload('file'))
			  {
			    $error = array('error' => $this->upload->display_errors());     
					$this->session->set_flashdata('error','Uploaded file format mismatch.');
					redirect('admin_course_content/readalongs');
			  }               
						
				$data = $this->upload->data();
				$lesson_file = $data['file_name'];
			}
					
			$file = './uploads/'.$lesson_file;
 
			//load the excel library
			$this->load->library('excel');
			 
			//read file from path
			$objPHPExcel = @PHPExcel_IOFactory::load($file);
			 
			//get only the Cell Collection
			$cell_collection = @$objPHPExcel->getActiveSheet()->getCellCollection();

			$data = array();
			$arr_data = array();
			$header = array();
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {			
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();			
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					
				if(empty($objPHPExcel->getActiveSheet()->getCell($cell)->getValue()))
				{
					if($cell[0] == 'A')
					{
						$data_value = $avalue;
					}
										
					if($cell[0] == 'B')
					{
						$data_value = $bvalue;
					}
										
				}
				else
				{
					if($cell[0] == 'A')
					{
						$avalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}
					if($cell[0] == 'B')
					{
						$bvalue = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					}					
				}
						
				//The header will/should be in row 1 only. of course, this can be modified to suit your need.
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
								
			}
						
			//send the data in an array format
			$data['header'] = $header;
			$data['values'] = $arr_data;

						if(strtolower(trim($data['header'][1]['E'])) == 'multiple choice options')
						{
							$this->ss_aw_readalong_quiz_model->delete_single_record($readalong_upload_id);
							foreach($data['values'] as $key=>$val)
							{
								if($key > 2)
								{
								if(!empty($val['A']))
								{
									$audio_file = "";	
									if($val['D'] == 2)
									{
										$audio_file = "choose_right_answers.mp3";
									}
									else if($val['D'] == 1)
									{
										$audio_file = "fill_the_blanks.mp3";
									}
									else if($val['D'] == 3)
									{
										$audio_file = "rewrite_the_sentence.mp3";
									}	
									
									$sql = "INSERT INTO `ss_aw_readalong_quiz`(`ss_aw_readalong_upload_id`,`ss_aw_audio_type`,`ss_aw_content_type`,
									`ss_aw_details`,`ss_aw_question`,`ss_aw_quiz_type`,`ss_aw_quiz_type_audio`,`ss_aw_multiple_choice`,`ss_aw_answers`)
									VALUES ('".$readalong_upload_id."','".$audio_type."','".addslashes($val['A'])."','".addslashes($val['B'])."',
									'".addslashes($val['C'])."','".addslashes($val['D'])."','".$audio_file."','".addslashes($val['E'])."','".addslashes($val['F'])."')";
									$this->db->query($sql);
								}
								}
							}
							$this->session->set_flashdata('success','Succesfully readalong quiz updated.');
						}
						else{
							$this->session->set_flashdata('success','Something went wrong, please try again later.');
						}
				redirect('admin_course_content/readalongs/'.$postdata['page_no']);		
		}
	}

}