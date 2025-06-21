<?php
/**
 * 
 */
class Report extends CI_Controller
{
	
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
		$this->load->model('ss_aw_report_model');
		$this->load->model('ss_aw_child_course_model');
		$this->load->model('ss_aw_lessons_uploaded_model');
		$this->load->model('ss_aw_assesment_uploaded_model');
		$this->load->model('ss_aw_readalongs_upload_model');
		$this->load->model('ss_aw_reporting_collection_model');
		$this->load->model('ss_aw_reporting_revenue_model');
		$this->load->model('ss_aw_promotion_model');
		$this->load->model('ss_aw_advance_email_log_model');
		$this->load->model('ss_aw_challange_model');
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
			$headerdata['user_email'] = $this->session->userdata('user_email');
			
			$searchary = array();
			$searchary['ss_aw_status'] = 1;
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

	public function lesson_question_difficulty() {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Dashboard";
        $page = 0;
        if ($this->input->post()) {
            // echo 'p:-1';

            $postdata = $this->input->post();
            if (!empty($postdata)) {
                $this->session->set_userdata('lesson_search_data', $postdata);
            } else {
                $this->session->set_userdata('lesson_search_data', '');
            }
            redirect('report/lesson_question_difficulty/' . $page);
        }


        $result = array();

        if ($this->session->userdata('lesson_search_data')) {
            //echo 'p:-2';exit;
            $searchdata = $this->session->userdata('lesson_search_data');
            $pagedata['searchdata'] = $searchdata;

            $total_record = $this->ss_aw_report_model->totallessonquesion($searchdata, $page);
            

            $redirect_to = base_url() . 'report/lesson_question_difficulty';
            $uri_segment = 3;
            $record_per_page = 10;
            $config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $str_links = $this->pagination->create_links();
            $pagedata["links"] = explode('&nbsp;', $str_links);
            if ($page >= $config["total_rows"]) {
                $page = 0;
            }

            $result = $this->ss_aw_report_model->fetchalllessonsquestions($searchdata, $config['per_page'], $page);
           
        }

        $pagedata['result'] = $result;
        $pagedata['page'] = $page;

        $student_level = @$searchdata['student_level'];
        if (!empty($student_level)) {
            $topic_listary = array();
            $general_language_lessons = array();
            if ($student_level == 1 || $student_level == 2) {
                $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(15, 0);
                $general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
            } elseif ($student_level == 3) {
                $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(10, 15);
                $general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
            } else {
                $topic_listary = $this->ss_aw_sections_topics_model->get_all_records();
            }
            $topicAry = array();
            if (!empty($topic_listary)) {
                foreach ($topic_listary as $key => $value) {
                    $topicAry[] = $value->ss_aw_section_id;
                }
            }
            $topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);
            $pagedata['topic_list'] = array_merge($topical_lessons, $general_language_lessons);
        }

        $this->loadView('admin/report/question_difficulty/lesson', $headerdata, $pagedata);
    }

	public function assessment_question_difficulty() {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Dashboard";
        if ($this->input->post()) {
            $page = 0;
            $postdata = $this->input->post();
            if (!empty($postdata)) {
                $this->session->set_userdata('assessment_search_data', $postdata);
            } else {
                $this->session->set_userdata('assessment_search_data', '');
            }
            redirect('report/assessment_question_difficulty/' . $page);
        }

        $quiz_type = "";
        $result = array();
        if ($this->session->userdata('assessment_search_data')) {
            $searchdata = $this->session->userdata('assessment_search_data');
            $pagedata['searchdata'] = $searchdata;
            $topic = $searchdata['topics'];

            $total_record = $this->ss_aw_report_model->totalassessmentquestion($searchdata);
           
            $redirect_to = base_url() . 'report/assessment_question_difficulty';
            $uri_segment = 3;
            $record_per_page = 10;
            $config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $str_links = $this->pagination->create_links();
            $pagedata["links"] = explode('&nbsp;', $str_links);
            if ($page >= $config["total_rows"]) {
                $page = 0;
            }

            $result = $this->ss_aw_report_model->fetchallassessmentquestions($searchdata, $config['per_page'], $page);
          
            }



        $pagedata['result'] = $result;
      

        $student_level = @$searchdata['student_level'];
        if (!empty($student_level)) {
            $topic_listary = array();
            $general_language_assessments = array();
            if ($student_level == 1 || $student_level == 2) {
                $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(15, 0);
                $general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();
            } elseif ($student_level == 3) {
                $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(10, 15);
                $general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_champions_general_language_assessments();
            } else {
                $topic_listary = $this->ss_aw_sections_topics_model->get_all_records();
            }
            $topicAry = array();
            if (!empty($topic_listary)) {
                foreach ($topic_listary as $key => $value) {
                    $topicAry[] = $value->ss_aw_section_id;
                }
            }
            $topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);

            $result = array_merge($topical_assessments, $general_language_assessments);
            $pagedata['topic_list'] = $result;
        }

        $this->loadView('admin/report/question_difficulty/assessment', $headerdata, $pagedata);
    }

	public function diagnostic_question_difficulty(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Dashboard";
		if ($this->input->post()) {
			$page = 0;
			$postdata = $this->input->post();
			if (!empty($postdata)) {
				$this->session->set_userdata('diagnostic_search_data', $postdata);
			}
			else
			{
				$this->session->set_userdata('diagnostic_search_data', '');
			}
			redirect('report/diagnostic_question_difficulty/'.$page);
		}

		$quiz_type = "";
		$result = array();
		if ($this->session->userdata('diagnostic_search_data')) {
			$searchdata = $this->session->userdata('diagnostic_search_data');
			$pagedata['searchdata'] = $searchdata;
			$child_id = array();
			if (!empty($searchdata['student_level'])) {
				$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($searchdata['student_level']);
				if (!empty($students->child_id)) {
					$child_id = explode(",", $students->child_id);
				}
			}
			
			$total_record = $this->ss_aw_report_model->totaldiagnosticquestion($searchdata);
			$redirect_to = base_url().'report/diagnostic_question_difficulty';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;            
			$str_links = $this->pagination->create_links();         
			$pagedata["links"] = explode('&nbsp;',$str_links );         
			if ($page >= $config["total_rows"]) {
			    $page=0;
			}

			$result = $this->ss_aw_report_model->fetchalldiagnosticquestions($searchdata, $config['per_page'], $page);
		}

		$question_asked = array();
		$correct_answer = array();
		$question_sequence_no = array();
		$incorrect_answer_count = array();

		if (!empty($result)) {
			foreach($result as $key => $value){
				$question = $value->ss_aw_question;
				$asked_question_details = $this->ss_aw_report_model->totalnoofdiagnosticquestionasked($searchdata, $child_id, $value->ss_aw_id);
				$log_ids = array();
				if (!empty($asked_question_details)) {
					foreach ($asked_question_details as $log_details) {
						$log_ids[] = $log_details->ss_aw_diagonastic_log_id;
					}
				}
				$question_asked[$value->ss_aw_id] = count($log_ids);
				$correct_answer[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticcorrectanswer($searchdata, $child_id, $value->ss_aw_id, $log_ids);
				$incorrect_answer_count[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticincorrectanswer($searchdata, $child_id, $value->ss_aw_id, $log_ids);

				$value->question_course_level = $value->ss_aw_level;

				$value->lesson_course_type = $value->ss_aw_course_id;

				$value->ss_aw_lesson_title = $value->ss_aw_question_preface;

				$value->ss_aw_lesson_details = $value->ss_aw_question;

				$value->record_id = $value->ss_aw_id;

				$question_sequence_no[$value->ss_aw_id] = $value->ss_aw_seq_no;

				$value->correct_answer = $value->ss_aw_answers;
			}
		}

		$pagedata['result'] = $result;
		$pagedata['question_asked'] = $question_asked;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_sequence_no'] = $question_sequence_no;
		$pagedata['incorrect_answer_count'] = $incorrect_answer_count;

		$student_level = $searchdata['student_level'];
		if (!empty($student_level)) {
			$topic_listary = array();
			$general_language_assessments = array();
			if ($student_level == 1 || $student_level == 2) {
				$search_data = array();
				$search_data['ss_aw_expertise_level'] = 'E';
				$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
				$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();	
			}
			elseif($student_level == 3){
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
				foreach ($topic_listary as $key => $value) {
					$topicAry[] = $value->ss_aw_section_id;
				}
			}
			$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);

			$result = array_merge($topical_assessments, $general_language_assessments);
			$pagedata['topic_list'] = $result;
		}

		$this->loadView('admin/report/question_difficulty/diagnostic', $headerdata, $pagedata);
	}

	public function readalong_question_difficulty(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Dashboard";
		if ($this->input->post()) {
			$page = 0;
			$postdata = $this->input->post();
			if (!empty($postdata)) {
				$this->session->set_userdata('readalong_search_data', $postdata);
			}
			else
			{
				$this->session->set_userdata('readalong_search_data', '');
			}
			redirect('report/readalong_question_difficulty/'.$page);
		}

		$result = array();
		if ($this->session->userdata('readalong_search_data')) {
			$searchdata = $this->session->userdata('readalong_search_data');
			$pagedata['searchdata'] = $searchdata;
			$child_id = array();
			if (!empty($searchdata['student_level'])) {
				$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($searchdata['student_level']);
				if (!empty($students->child_id)) {
					$child_id = explode(",", $students->child_id);
				}
			}
			
			$total_record = $this->ss_aw_report_model->totalreadalongquestion($child_id, $searchdata);
			$redirect_to = base_url().'report/readalong_question_difficulty';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;            
			$str_links = $this->pagination->create_links();         
			$pagedata["links"] = explode('&nbsp;',$str_links );         
			if ($page >= $config["total_rows"]) {
			    $page=0;
			}

			$result = $this->ss_aw_report_model->fetchallreadalongquestions($child_id, $searchdata, $config['per_page'], $page);
		}

		$question_asked = array();
		$correct_answer = array();
		$question_sequence_no = array();
		$incorrect_answer_count = array();

		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$question = $value->ss_aw_readalong_id;
				$question_asked[$value->ss_aw_readalong_id] = $this->ss_aw_report_model->totalnoofquestionasked($searchdata, $child_id, $question, 4);
				$correct_answer[$value->ss_aw_readalong_id] = $this->ss_aw_report_model->totalnoofcorrectanswer($searchdata, $child_id, $question, 4);
				$incorrect_answer_count[$value->ss_aw_readalong_id] = $this->ss_aw_report_model->totalnoofincorrectanswer($searchdata, $child_id, $question, 4);

				$value->question_course_level = $value->ss_aw_level;

				$value->record_id = $value->ss_aw_readalong_id;

				$question_sequence_no[$value->ss_aw_readalong_id] = $key + 1;

				$value->correct_answer = $value->ss_aw_answers;	
			}
		}

		$pagedata['result'] = $result;
		$pagedata['question_asked'] = $question_asked;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_sequence_no'] = $question_sequence_no;
		$pagedata['incorrect_answer_count'] = $incorrect_answer_count;

		$student_level = $searchdata['student_level'];
		if ($student_level == 1 || $student_level == 2) {
			$course_code = "E";
		}
		elseif ($student_level == 3 || $student_level == 5) {
			$course_code = "A";
		}
		$searchary['ss_aw_level'] = $course_code;
		$result = $this->ss_aw_readalongs_upload_model->fetch_by_params($searchary);
		$pagedata['topic_list'] = $result;

		$this->loadView('admin/report/question_difficulty/readalong', $headerdata, $pagedata);
	}

	public function question_difficulty_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Dashboard";
		if ($this->input->post()) {
			$page = 0;
			$postdata = $this->input->post();
			if (!empty($postdata)) {
				$this->session->set_userdata('search_data', $postdata);
			}
			else
			{
				$this->session->set_userdata('search_data', '');
			}
			redirect('report/question_difficulty_report/'.$page);
		}
		//else
		//{
		$quiz_type = "";
		$result = array();
		if ($this->session->userdata('search_data')) {
			$searchdata = $this->session->userdata('search_data');
			$pagedata['searchdata'] = $searchdata;
			$child_id = array();
			if (!empty($searchdata['student_level'])) {
				$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($searchdata['student_level']);
				if (!empty($students->child_id)) {
					$child_id = explode(",", $students->child_id);
				}
			}
			
			$total_record = $this->ss_aw_report_model->totallessonquesion($child_id, $searchdata);
			$redirect_to = base_url().'report/question_difficulty_report';
			$uri_segment = 3;
			$record_per_page = 10;
			$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;            
			$str_links = $this->pagination->create_links();         
			$pagedata["links"] = explode('&nbsp;',$str_links );         
			if ($page >= $config["total_rows"]) {
			    $page=0;
			}

			$result = $this->ss_aw_report_model->fetchalllessonsquestions($child_id, $searchdata, $config['per_page'], $page);
		}


		$question_asked = array();
		$correct_answer = array();
		$question_sequence_no = array();
		$incorrect_answer_count = array();
		if (!empty($result)) {
			$quiz_type = $searchdata['quiz_type'];
			if ($searchdata['quiz_type'] == 1) {
				$sequence_no = $page;
				foreach($result as $key => $value){
					$question = $value->ss_aw_lesson_details;
					$question_asked[$value->ss_aw_lession_id] = $this->ss_aw_report_model->totalnoofquestionasked($searchdata, $child_id, $value->ss_aw_lession_id, $quiz_type);
					$correct_answer[$value->ss_aw_lession_id] = $this->ss_aw_report_model->totalnoofcorrectanswer($searchdata, $child_id, $value->ss_aw_lession_id, $quiz_type);
					$incorrect_answer_count[$value->ss_aw_lession_id] = $this->ss_aw_report_model->totalnoofincorrectanswer($searchdata, $child_id, $value->ss_aw_lession_id, $quiz_type);

					if($value->ss_aw_course_id == 1){
						$course_level = 'E';
					}
					elseif ($value->ss_aw_course_id == 2) {
						$course_level = 'C';
					}
					elseif ($value->ss_aw_course_id == 3) {
						$course_level = 'A';
					}
					elseif ($value->ss_aw_course_id == 5) {
						$course_level = 'M';
					}

					$value->question_course_level = $course_level;


					$courseAry = explode(",", $value->course_level);
					$course_type = "";
					if (!empty($courseAry)) {
						foreach ($courseAry as $course) {
							if(!empty($course)){
								if($course_type != ""){
									$course_type .= ",";
								}
								if($course == 1){
									$course_type .= 'E';
								}
								elseif ($course == 2) {
									$course_type .= 'C';
								}
								elseif ($course == 3) {
									$course_type .= 'A';
								}
							}
						}
					}

					$value->lesson_course_type = $course_type;
					$value->record_id = $value->ss_aw_lession_id;
					$question_sequence_no[$value->ss_aw_lession_id] = $sequence_no + 1;
					$value->correct_answer = $value->ss_aw_lesson_answers;
					$sequence_no++;
				}	
			}
			elseif ($searchdata['quiz_type'] == 2) {
				foreach($result as $value){
					$question = $value->ss_aw_question;
					$question_asked[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofquestionasked($searchdata, $child_id, $question, $quiz_type, $value->ss_aw_format, $value->ss_aw_id);
					$correct_answer[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofcorrectanswer($searchdata, $child_id, $question, $quiz_type, $value->ss_aw_format, $value->ss_aw_id);
					$incorrect_answer_count[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofincorrectanswer($searchdata, $child_id, $question, $quiz_type, $value->ss_aw_format, $value->ss_aw_id);

					$value->question_course_level = $value->ss_aw_level;

					$value->lesson_course_type = $value->ss_aw_course_id;

					$value->ss_aw_lesson_title = $value->ss_aw_question_preface;

					$value->ss_aw_lesson_details = $value->ss_aw_question;

					$value->record_id = $value->ss_aw_id;

					$question_sequence_no[$value->ss_aw_id] = $value->ss_aw_seq_no;

					$value->correct_answer = $value->ss_aw_answers;
				}
			}
			elseif($searchdata['quiz_type'] == 3){
				foreach($result as $key => $value){
					$question = $value->ss_aw_question;
					$question_asked[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticquestionasked($searchdata, $child_id, $value->ss_aw_id);
					$correct_answer[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticcorrectanswer($searchdata, $child_id, $value->ss_aw_id);
					$incorrect_answer_count[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticincorrectanswer($searchdata, $child_id, $value->ss_aw_id);

					$value->question_course_level = $value->ss_aw_level;

					$value->lesson_course_type = $value->ss_aw_course_id;

					$value->ss_aw_lesson_title = $value->ss_aw_question_preface;

					$value->ss_aw_lesson_details = $value->ss_aw_question;

					$value->record_id = $value->ss_aw_id;

					$question_sequence_no[$value->ss_aw_id] = $value->ss_aw_seq_no;

					$value->correct_answer = $value->ss_aw_answers;
				}
			}
			else{
				foreach ($result as $key => $value) {
					$question = $value->ss_aw_readalong_id;
					$question_asked[$value->ss_aw_readalong_id] = $this->ss_aw_report_model->totalnoofquestionasked($searchdata, $child_id, $question, $quiz_type);
					$correct_answer[$value->ss_aw_readalong_id] = $this->ss_aw_report_model->totalnoofcorrectanswer($searchdata, $child_id, $question, $quiz_type);
					$incorrect_answer_count[$value->ss_aw_readalong_id] = $this->ss_aw_report_model->totalnoofincorrectanswer($searchdata, $child_id, $question, $quiz_type);

					$value->question_course_level = $value->ss_aw_level;

					$value->record_id = $value->ss_aw_readalong_id;

					$question_sequence_no[$value->ss_aw_readalong_id] = $key + 1;

					$value->correct_answer = $value->ss_aw_answers;	
				}
			}
		}

		$pagedata['result'] = $result;
		$pagedata['question_asked'] = $question_asked;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_sequence_no'] = $question_sequence_no;
		$pagedata['incorrect_answer_count'] = $incorrect_answer_count;

		$student_level = $searchdata['student_level'];
		$quiz_type = $searchdata['quiz_type'];
		if (!empty($student_level) && !empty($quiz_type)) {
			if ($quiz_type == 1) {
				$topic_listary = array();
				$general_language_lessons = array();
				if ($student_level == 1 || $student_level == 2) {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'E';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
					$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
				}
				elseif($student_level == 3){
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
				$pagedata['topic_list'] = array_merge($topical_lessons, $general_language_lessons);
			}
			elseif ($quiz_type == 2 || $quiz_type == 3) {
				$topic_listary = array();
				$general_language_assessments = array();
				if ($student_level == 1 || $student_level == 2) {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'E';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
					$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();	
				}
				elseif($student_level == 3){
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
					foreach ($topic_listary as $key => $value) {
						$topicAry[] = $value->ss_aw_section_id;
					}
				}
				$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);

				$result = array_merge($topical_assessments, $general_language_assessments);
				$pagedata['topic_list'] = $result;
			}
			else{
				if ($student_level == 1 || $student_level == 2) {
					$course_code = "E";
				}
				elseif ($student_level == 3 || $student_level == 5) {
					$course_code = "A";
				}
				$searchary['ss_aw_level'] = $course_code;
				$result = $this->ss_aw_readalongs_upload_model->fetch_by_params($searchary);
				$pagedata['topic_list'] = $result;
			}
		}

		$this->loadView('admin/report/question-difficulty-report', $headerdata, $pagedata);
		//}
	}

	public function export_question_difficulty(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Dashboard";
		if ($this->input->post()) {
			$postdata = $this->input->post();

			if (!empty($postdata)) {
				$this->session->set_userdata('search_data', $postdata);
			}
			else
			{
				$this->session->set_userdata('search_data', '');
			}
		}
		//else
		//{
		$quiz_type = "";
		$result = array();
		if ($this->session->userdata('search_data')) {

			$searchdata = $this->session->userdata('search_data');
			$pagedata['searchdata'] = $searchdata;
			if (!empty($searchdata['quiz_type'])) {
				$courseAry = array();
				if ($searchdata['age']) {

					/*$ageAry = explode("-", $searchdata['age']);
					$start_age = $ageAry[0];
					$end_age = $ageAry[1];*/
					if ($searchdata['age'] == 1) {
						$start_age = 10;
						$end_age = 12;
					}
					elseif ($searchdata['age'] == 2) {
						$start_age = 12;
						$end_age = 14;
					}
					else
					{
						$start_age = 14;
						$end_age = 16;
					}
					$get_inage_child = $this->ss_aw_childs_model->getchild_byage($start_age, $end_age);
					
					if (!empty($get_inage_child)) {
						foreach ($get_inage_child as $key => $child) {
							$childary = $this->ss_aw_child_course_model->get_details($child->ss_aw_child_id);
							if (!empty($childary)) {
								$level = $childary[count($childary) - 1]['ss_aw_course_id'];
								if (!in_array($level, $courseAry)) {
									$courseAry[] = $level;
								}	
							}
						}
					}
				}
				$total_record = $this->ss_aw_report_model->totallessonquesion($searchdata, $courseAry);
				$redirect_to = base_url().'report/question_difficulty_report';
				$uri_segment = 3;
				$record_per_page = 10;
				$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
			    $this->pagination->initialize($config);
			    $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;            
			    $str_links = $this->pagination->create_links();         
			    $pagedata["links"] = explode('&nbsp;',$str_links );         
			    if ($page >= $config["total_rows"]) {
			        $page=0;
			    }

				$result = $this->ss_aw_report_model->fetchalllessonsquestions($searchdata, $config['per_page'], $page, $courseAry);	
			}
		}


		$question_asked = array();
		$correct_answer = array();
		if (!empty($result)) {
			$quiz_type = $searchdata['quiz_type'];
			if ($searchdata['quiz_type'] == 1) {
				foreach($result as $value){
					$question = $value->ss_aw_lesson_details;
					$question_asked[$value->ss_aw_lession_id] = $this->ss_aw_report_model->totalnoofquestionasked($question, $quiz_type);
					$correct_answer[$value->ss_aw_lession_id] = $this->ss_aw_report_model->totalnoofcorrectanswer($question, $quiz_type);

					if($value->ss_aw_course_id == 1){
						$course_level = 'E';
					}
					elseif ($value->ss_aw_course_id == 2) {
						$course_level = 'C';
					}
					elseif ($value->ss_aw_course_id == 3) {
						$course_level = 'A';
					}
					$value->question_course_level = $course_level;


					$courseAry = explode(",", $value->course_level);
					$course_type = "";
					if (!empty($courseAry)) {
						foreach ($courseAry as $course) {
							if(!empty($course)){
								if($course_type != ""){
									$course_type .= ",";
								}
								if($course == 1){
									$course_type .= 'E';
								}
								elseif ($course == 2) {
									$course_type .= 'C';
								}
								elseif ($course == 3) {
									$course_type .= 'A';
								}
							}
						}
					}

					$value->lesson_course_type = $course_type;
					$value->record_id = $value->ss_aw_lession_id;
				}	
			}
			elseif ($searchdata['quiz_type'] == 2) {
				foreach($result as $value){
					$question = $value->ss_aw_question;
					$question_asked[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofquestionasked($question, $quiz_type, $value->ss_aw_format);
					$correct_answer[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofcorrectanswer($question, $quiz_type, $value->ss_aw_format);

					$value->question_course_level = $value->ss_aw_level;

					$value->lesson_course_type = $value->ss_aw_course_id;

					$value->ss_aw_lesson_title = $value->ss_aw_question_preface;

					$value->ss_aw_lesson_details = $value->ss_aw_question;

					$value->record_id = $value->ss_aw_id;
				}
			}
			else
			{
				foreach($result as $value){
					$question = $value->ss_aw_question;
					$question_asked[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticquestionasked($value->ss_aw_id);
					$correct_answer[$value->ss_aw_id] = $this->ss_aw_report_model->totalnoofdiagnosticcorrectanswer($value->ss_aw_id);

					$value->question_course_level = $value->ss_aw_level;

					$value->lesson_course_type = $value->ss_aw_course_id;

					$value->ss_aw_lesson_title = $value->ss_aw_question_preface;

					$value->ss_aw_lesson_details = $value->ss_aw_question;

					$value->record_id = $value->ss_aw_id;
				}
			}
		}

		$pagedata['result'] = $result;
		$pagedata['question_asked'] = $question_asked;
		$pagedata['correct_answer'] = $correct_answer;

		$this->load->library('pdf');
		$html = $this->load->view('pdf/report/question_difficulty_report', $pagedata, true);
		$filename = time().".pdf";
		$save_file_path = "./scorepdf/".$filename;
		$this->pdf->viewPDF($save_file_path, $html, $filename, false);
	}

	public function last_complete_lesson(){
		$lesson_completion_searchdata = array();
		$get_all_lessons = array();
		$complete_num = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('lesson_completion_searchdata', $postdata);
		}
		if (!empty($this->session->userdata('lesson_completion_searchdata'))) {
			$lesson_completion_searchdata = $this->session->userdata('lesson_completion_searchdata');
			if (!empty($lesson_completion_searchdata['assign_level'])) {
				$searchary = array();
				if (!empty($lesson_completion_searchdata['age'])) {
					if ($lesson_completion_searchdata['age'] == 1) {
						$start_age = 10;
						$end_age = 12;
					}
					elseif ($lesson_completion_searchdata['age'] == 2) {
						$start_age = 12;
						$end_age = 14;
					}
					else
					{
						$start_age = 14;
						$end_age = 16;
					}

					$searchary['start_age'] = $start_age;
					$searchary['end_age'] = $end_age;
				}

				$get_all_lessons = $this->ss_aw_report_model->get_all_lesson($lesson_completion_searchdata);

				if (!empty($get_all_lessons)) {
					foreach ($get_all_lessons as $key => $value) {
						$complete_num[$value->ss_aw_lession_id] = $this->ss_aw_report_model->student_lesson_complete_num($value->ss_aw_lession_id, $searchary);
					}
				}
			}
		}
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Completion Report";
		$data['lesson_completion_searchdata'] = $lesson_completion_searchdata;
		$data['lessons'] = $get_all_lessons;
		$data['lesson_complete_num'] = $complete_num;
		
		$this->loadView('admin/report/lesson-completion-report', $headerdata, $data);
	}

	public function export_lesson_complete_data(){
		$lesson_completion_searchdata = array();
		$get_all_lessons = array();
		$complete_num = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('lesson_completion_searchdata', $postdata);
		}
		if (!empty($this->session->userdata('lesson_completion_searchdata'))) {
			$lesson_completion_searchdata = $this->session->userdata('lesson_completion_searchdata');
			if (!empty($lesson_completion_searchdata['assign_level'])) {
				$searchary = array();
				if (!empty($lesson_completion_searchdata['age'])) {
					if ($lesson_completion_searchdata['age'] == 1) {
						$start_age = 10;
						$end_age = 12;
					}
					elseif ($lesson_completion_searchdata['age'] == 2) {
						$start_age = 12;
						$end_age = 14;
					}
					else
					{
						$start_age = 14;
						$end_age = 16;
					}

					$searchary['start_age'] = $start_age;
					$searchary['end_age'] = $end_age;
				}

				$get_all_lessons = $this->ss_aw_report_model->get_all_lesson($lesson_completion_searchdata);

				if (!empty($get_all_lessons)) {
					foreach ($get_all_lessons as $key => $value) {
						$complete_num[$value->ss_aw_lession_id] = $this->ss_aw_report_model->student_lesson_complete_num($value->ss_aw_lession_id, $searchary);
					}
				}
			}
		}

		$data['lesson_completion_searchdata'] = $lesson_completion_searchdata;
		$data['lessons'] = $get_all_lessons;
		$data['lesson_complete_num'] = $complete_num;

		$this->load->library('pdf');
		$html = $this->load->view('pdf/report/lesson_complete_report', $data, true);
		$filename = time().".pdf";
		$save_file_path = "./scorepdf/".$filename;
		$this->pdf->viewPDF($save_file_path, $html, $filename, false);
	}

	public function lesson_assessment_score(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Completion Report";
		$data = array();
		$scoreAry = array();
		$lesson_assessment_score_searchdata = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$assign_level = $postdata['assign_level'];
			$lesson_assessment_score_searchdata['assign_level'] = $assign_level;
			for ($i = 0; $i < count(PERCENTAGE_CHAIN); $i++) { 
				for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) { 
					$lesson_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$i]);
					$lesson_start_percentage = trim($lesson_score_percentage_ary[0]);
					$lesson_start_percentage = str_replace(">", "", $lesson_start_percentage);
					$lesson_start_percentage = str_replace("%", "", $lesson_start_percentage);

					$lesson_end_percentage = trim($lesson_score_percentage_ary[1]);
					$lesson_end_percentage = str_replace(">", "", $lesson_end_percentage);
					$lesson_end_percentage = str_replace("%", "", $lesson_end_percentage);

					$assessment_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$j]);
					$assessment_start_percentage = trim($assessment_score_percentage_ary[0]);
					$assessment_start_percentage = str_replace(">", "", $assessment_start_percentage);
					$assessment_start_percentage = str_replace("%", "", $assessment_start_percentage);

					$assessment_end_percentage = trim($assessment_score_percentage_ary[1]);
					$assessment_end_percentage = str_replace(">", "", $assessment_end_percentage);
					$assessment_end_percentage = str_replace("%", "", $assessment_end_percentage);

					$scoreAry[PERCENTAGE_CHAIN[$i]][PERCENTAGE_CHAIN[$j]] = $this->ss_aw_report_model->getstudentcountbypercentagescore($assign_level, $lesson_start_percentage, $lesson_end_percentage, $assessment_start_percentage, $assessment_end_percentage);
				}
			}
		}

		$data['report_detail'] = $scoreAry;
		$data['lesson_assessment_score_searchdata'] = $lesson_assessment_score_searchdata;
		$this->loadView('admin/report/lesson-assessment-score', $headerdata, $data);
	}

	public function export_lesson_assessment_score(){
		$data = array();
		$scoreAry = array();
		if ($this->uri->segment(3)) {
			$assign_level = $this->uri->segment(3);
			for ($i = 0; $i < count(PERCENTAGE_CHAIN); $i++) { 
				for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) { 
					$lesson_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$i]);
					$lesson_start_percentage = trim($lesson_score_percentage_ary[0]);
					$lesson_start_percentage = str_replace(">", "", $lesson_start_percentage);
					$lesson_start_percentage = str_replace("%", "", $lesson_start_percentage);

					$lesson_end_percentage = trim($lesson_score_percentage_ary[1]);
					$lesson_end_percentage = str_replace(">", "", $lesson_end_percentage);
					$lesson_end_percentage = str_replace("%", "", $lesson_end_percentage);

					$assessment_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$j]);
					$assessment_start_percentage = trim($assessment_score_percentage_ary[0]);
					$assessment_start_percentage = str_replace(">", "", $assessment_start_percentage);
					$assessment_start_percentage = str_replace("%", "", $assessment_start_percentage);

					$assessment_end_percentage = trim($assessment_score_percentage_ary[1]);
					$assessment_end_percentage = str_replace(">", "", $assessment_end_percentage);
					$assessment_end_percentage = str_replace("%", "", $assessment_end_percentage);

					$scoreAry[PERCENTAGE_CHAIN[$i]][PERCENTAGE_CHAIN[$j]] = $this->ss_aw_report_model->getstudentcountbypercentagescore($assign_level, $lesson_start_percentage, $lesson_end_percentage, $assessment_start_percentage, $assessment_end_percentage);
				}
			}
		}

		$data['report_detail'] = $scoreAry;

		$this->load->library('pdf');
		$html = $this->load->view('pdf/report/lesson_assessment_score_report', $data, true);
		$filename = time().".pdf";
		$save_file_path = "./scorepdf/".$filename;
		$this->pdf->viewPDF($save_file_path, $html, $filename, false);

	}

	public function retention_score_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Retention Score Report";
		$data = array();
		$decending_retention_score = array();
		$retention_score_searchdata = array();
		$retention_score = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$assign_level = $postdata['assign_level'];
			$retention_score_searchdata['assign_level'] = $assign_level;
			$decending_retention_ary = RETENTION_PERCENTAGE_CHAIN;
			for ($i = count($decending_retention_ary) - 1; $i >= 0; $i--) { 
				$retention_percentage_ary = explode("-", $decending_retention_ary[$i]);
				$retention_start_percentage = (int)str_replace("%", "", $retention_percentage_ary[1]);
				$retention_start_percentage = "-".$retention_start_percentage;
				$retention_end_percentage = (int)str_replace("%", "", $retention_percentage_ary[0]);
				$retention_end_percentage = "-".$retention_end_percentage;
				$check_percentage = $this->ss_aw_report_model->retentionscoredetail($assign_level, $retention_start_percentage, $retention_end_percentage);
				$decending_retention_score[$decending_retention_ary[$i]] = $check_percentage;
			}

			for ($i = 0; $i < count(RETENTION_PERCENTAGE_CHAIN); $i++) { 
				$retention_percentage_ary = explode("-", $decending_retention_ary[$i]);
				$retention_start_percentage = (int)str_replace("%", "", $retention_percentage_ary[0]);
				$retention_start_percentage = $retention_start_percentage;
				$retention_end_percentage = (int)str_replace("%", "", $retention_percentage_ary[1]);
				$retention_end_percentage = $retention_end_percentage;
				$check_percentage = $this->ss_aw_report_model->retentionscoredetail($assign_level, $retention_start_percentage, $retention_end_percentage);
				$retention_score[RETENTION_PERCENTAGE_CHAIN[$i]] = $check_percentage;
			}

			$data['total_students'] = $this->ss_aw_report_model->totalactivestudents($assign_level);

		}

		$data['decending_retention_score'] = $decending_retention_score;
		$data['retention_score'] = $retention_score;
		$data['retention_score_searchdata'] = $retention_score_searchdata;
		$this->loadView('admin/report/retention-score-report', $headerdata, $data);
	}

	public function student_answer_from_next_level(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Answered Student From Next Level";
		$data = array();
		$assessment_perticipant = array();
		$assessment_next_level_perticipant = array();
		$assessment_list = $this->ss_aw_assesment_uploaded_model->fetch_all();
		if (!empty($assessment_list)) {
			foreach ($assessment_list as $key => $value) {
				$result = $this->ss_aw_report_model->getallperticipantnumbyassessmentid($value['ss_aw_lesson_id'], 1);
				if (!empty($result[0]->child_id)) {
					$perticipant_child_Ary = explode(",", $result[0]->child_id);
					$total_perticipant_num = count($perticipant_child_Ary);
				}
				else{
					$total_perticipant_num = 0;
				}

				$assessment_perticipant[$value['ss_aw_assessment_id']] = $total_perticipant_num;

				if (!empty($perticipant_child_Ary)) {
					$next_level_perticipant = 0;
					foreach ($perticipant_child_Ary as $perticipant_id) {

						$childary = $this->ss_aw_child_course_model->get_details($perticipant_id);
						$level_id = $childary[count($childary) - 1]['ss_aw_course_id'];
						if ($level_id == '1') {
							$level_type = "E";
						}
						elseif ($level_id == '2') {
							$level_type = "C";
						}
						else
						{
							$level_type = 'A';
						}

						if ($value['ss_aw_assesment_format'] == 'Single') {
							$check_perticipant = $this->ss_aw_report_model->formatonenextlevelperticipantnum($perticipant_id, $value['ss_aw_lesson_id'], $level_type);

						}	
						else{
							$check_perticipant = $this->ss_aw_report_model->formattwonextlevelperticipantnum($perticipant_id, $value['ss_aw_lesson_id'], $level_type);
						}

						if ($check_perticipant > 0) {
							$next_level_perticipant++;
						}
					}	

					$assessment_next_level_perticipant[$value['ss_aw_assessment_id']] = $next_level_perticipant;
				}
				else{
					$assessment_next_level_perticipant[$value['ss_aw_assessment_id']] = 0;
				}	
			}	
		}

		$data['assessment_list'] = $assessment_list;
		$data['assessment_next_level_perticipant'] = $assessment_next_level_perticipant;
		$data['assessment_perticipant'] = $assessment_perticipant;
		$this->loadView('admin/report/next-level-answer-report', $headerdata, $data);
	}

	public function diagnostic_assessment_score(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Assessment Score";
		$data = array();
		$scoreAry = array();
		$lesson_assessment_score_searchdata = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$assign_level = $postdata['assign_level'];
			$lesson_assessment_score_searchdata['assign_level'] = $assign_level;
			for ($i = 0; $i < count(PERCENTAGE_CHAIN); $i++) { 
				for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) { 
					$lesson_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$i]);
					$lesson_start_percentage = trim($lesson_score_percentage_ary[0]);
					$lesson_start_percentage = str_replace(">", "", $lesson_start_percentage);
					$lesson_start_percentage = str_replace("%", "", $lesson_start_percentage);

					$lesson_end_percentage = trim($lesson_score_percentage_ary[1]);
					$lesson_end_percentage = str_replace(">", "", $lesson_end_percentage);
					$lesson_end_percentage = str_replace("%", "", $lesson_end_percentage);

					$assessment_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$j]);
					$assessment_start_percentage = trim($assessment_score_percentage_ary[0]);
					$assessment_start_percentage = str_replace(">", "", $assessment_start_percentage);
					$assessment_start_percentage = str_replace("%", "", $assessment_start_percentage);

					$assessment_end_percentage = trim($assessment_score_percentage_ary[1]);
					$assessment_end_percentage = str_replace(">", "", $assessment_end_percentage);
					$assessment_end_percentage = str_replace("%", "", $assessment_end_percentage);

					$scoreAry[PERCENTAGE_CHAIN[$i]][PERCENTAGE_CHAIN[$j]] = $this->ss_aw_report_model->getstudentcountofdiagnosticassessment($assign_level, $lesson_start_percentage, $lesson_end_percentage, $assessment_start_percentage, $assessment_end_percentage);
				}
			}
		}

		$data['report_detail'] = $scoreAry;
		$data['lesson_assessment_score_searchdata'] = $lesson_assessment_score_searchdata;
		$this->loadView('admin/report/diagnostic-assessment-score', $headerdata, $data);
	}

	public function export_diagnostic_assessment_score(){
		$data = array();
		$scoreAry = array();
		if ($this->uri->segment(3)) {
			$assign_level = $this->uri->segment(3);
			for ($i = 0; $i < count(PERCENTAGE_CHAIN); $i++) { 
				for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) { 
					$lesson_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$i]);
					$lesson_start_percentage = trim($lesson_score_percentage_ary[0]);
					$lesson_start_percentage = str_replace(">", "", $lesson_start_percentage);
					$lesson_start_percentage = str_replace("%", "", $lesson_start_percentage);

					$lesson_end_percentage = trim($lesson_score_percentage_ary[1]);
					$lesson_end_percentage = str_replace(">", "", $lesson_end_percentage);
					$lesson_end_percentage = str_replace("%", "", $lesson_end_percentage);

					$assessment_score_percentage_ary = explode("-", PERCENTAGE_CHAIN[$j]);
					$assessment_start_percentage = trim($assessment_score_percentage_ary[0]);
					$assessment_start_percentage = str_replace(">", "", $assessment_start_percentage);
					$assessment_start_percentage = str_replace("%", "", $assessment_start_percentage);

					$assessment_end_percentage = trim($assessment_score_percentage_ary[1]);
					$assessment_end_percentage = str_replace(">", "", $assessment_end_percentage);
					$assessment_end_percentage = str_replace("%", "", $assessment_end_percentage);

					$scoreAry[PERCENTAGE_CHAIN[$i]][PERCENTAGE_CHAIN[$j]] = $this->ss_aw_report_model->getstudentcountofdiagnosticassessment($assign_level, $lesson_start_percentage, $lesson_end_percentage, $assessment_start_percentage, $assessment_end_percentage);
				}
			}
		}

		$data['report_detail'] = $scoreAry;

		$this->load->library('pdf');
		$html = $this->load->view('pdf/report/diagnostic_assessment_score_report', $data, true);
		$filename = time().".pdf";
		$save_file_path = "./scorepdf/".$filename;
		$this->pdf->viewPDF($save_file_path, $html, $filename, false);
	}

	public function improvement_score_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Improvement Score Report";
		$data = array();
		$decending_retention_score = array();
		$retention_score_searchdata = array();
		$retention_score = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$assign_level = $postdata['assign_level'];
			$retention_score_searchdata['assign_level'] = $assign_level;
			$decending_retention_ary = RETENTION_PERCENTAGE_CHAIN;
			for ($i = count($decending_retention_ary) - 1; $i >= 0; $i--) { 
				$retention_percentage_ary = explode("-", $decending_retention_ary[$i]);
				$retention_start_percentage = (int)str_replace("%", "", $retention_percentage_ary[1]);
				$retention_start_percentage = "-".$retention_start_percentage;
				$retention_end_percentage = (int)str_replace("%", "", $retention_percentage_ary[0]);
				$retention_end_percentage = "-".$retention_end_percentage;
				$check_percentage = $this->ss_aw_report_model->improvementscoredetail($assign_level, $retention_start_percentage, $retention_end_percentage);
				$decending_retention_score[$decending_retention_ary[$i]] = $check_percentage;
			}

			for ($i = 0; $i < count(RETENTION_PERCENTAGE_CHAIN); $i++) { 
				$retention_percentage_ary = explode("-", $decending_retention_ary[$i]);
				$retention_start_percentage = (int)str_replace("%", "", $retention_percentage_ary[0]);
				$retention_start_percentage = $retention_start_percentage;
				$retention_end_percentage = (int)str_replace("%", "", $retention_percentage_ary[1]);
				$retention_end_percentage = $retention_end_percentage;
				$check_percentage = $this->ss_aw_report_model->improvementscoredetail($assign_level, $retention_start_percentage, $retention_end_percentage);
				$retention_score[RETENTION_PERCENTAGE_CHAIN[$i]] = $check_percentage;
			}

			$data['total_students'] = $this->ss_aw_report_model->totalactivestudents($assign_level);

		}

		$data['decending_improvement_score'] = $decending_retention_score;
		$data['improvement_score'] = $retention_score;
		$data['improvement_score_searchdata'] = $retention_score_searchdata;
		$this->loadView('admin/report/improvement-score-report', $headerdata, $data);
	}

	public function export_improvement_report(){
		$data = array();
		$decending_retention_score = array();
		$retention_score_searchdata = array();
		$retention_score = array();

		$assign_level = $this->uri->segment(3);
		$retention_score_searchdata['assign_level'] = $assign_level;
		$decending_retention_ary = RETENTION_PERCENTAGE_CHAIN;
		for ($i = count($decending_retention_ary) - 1; $i >= 0; $i--) { 
			$retention_percentage_ary = explode("-", $decending_retention_ary[$i]);
			$retention_start_percentage = (int)str_replace("%", "", $retention_percentage_ary[1]);
			$retention_start_percentage = "-".$retention_start_percentage;
			$retention_end_percentage = (int)str_replace("%", "", $retention_percentage_ary[0]);
			$retention_end_percentage = "-".$retention_end_percentage;
			$check_percentage = $this->ss_aw_report_model->improvementscoredetail($assign_level, $retention_start_percentage, $retention_end_percentage);
			$decending_retention_score[$decending_retention_ary[$i]] = $check_percentage;
		}

		for ($i = 0; $i < count(RETENTION_PERCENTAGE_CHAIN); $i++) { 
			$retention_percentage_ary = explode("-", $decending_retention_ary[$i]);
			$retention_start_percentage = (int)str_replace("%", "", $retention_percentage_ary[0]);
			$retention_start_percentage = $retention_start_percentage;
			$retention_end_percentage = (int)str_replace("%", "", $retention_percentage_ary[1]);
			$retention_end_percentage = $retention_end_percentage;
			$check_percentage = $this->ss_aw_report_model->improvementscoredetail($assign_level, $retention_start_percentage, $retention_end_percentage);
			$retention_score[RETENTION_PERCENTAGE_CHAIN[$i]] = $check_percentage;
		}

		$data['total_students'] = $this->ss_aw_report_model->totalactivestudents($assign_level);
		$data['decending_improvement_score'] = $decending_retention_score;
		$data['improvement_score'] = $retention_score;
		$data['improvement_score_searchdata'] = $retention_score_searchdata;

		$this->load->library('pdf');
		$html = $this->load->view('pdf/report/improvement_score_report', $data, true);
		$filename = time().".pdf";
		$save_file_path = "./scorepdf/".$filename;
		$this->pdf->viewPDF($save_file_path, $html, $filename, false);
	}

	public function track_readalong_selection(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Track Readalong Selection";
		$data = array();
		$readalongs = array();
		$selected_num_ptd = array();
		$selected_num_ytd = array();
		$selected_num_mtd = array();
		$completed_num_ptd = array();
		$completed_num_ytd = array();
		$completed_num_mtd = array();
		$track_readalong_data = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$assign_level = $postdata['assign_level'];
			$track_readalong_data['assign_level'] = $assign_level;
			if (!empty($assign_level)) {
				$search_data = array();
				if ($assign_level == 1 || $assign_level == 2) {
					$level = "E";
				}
				elseif ($assign_level == 3) {
					$level = "C";
				}
				elseif ($assign_level == 5) {
					$level = "A";
				}
				$search_data['ss_aw_level'] = $level;
				$readalongs = $this->ss_aw_readalongs_upload_model->fetch_record_alphabatically($search_data);
				
				if (!empty($readalongs)) {
					foreach ($readalongs as $key => $value) {
						$readalong_id = $value['ss_aw_id'];
						$readalong_title = $value['ss_aw_title'];

						$selected_num_ptd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongselectionnum($level, $readalong_title);
						$selected_num_ytd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongselectionnum($level, $readalong_title, 1);
						$selected_num_mtd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongselectionnum($level, $readalong_title, 2);

						$completed_num_ptd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongcompletednum($level, $readalong_title);
						$completed_num_ytd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongcompletednum($level, $readalong_title, 1);
						$completed_num_mtd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongcompletednum($level, $readalong_title, 2);
					}
				}	
			}
		}

		$data['readalongs'] = $readalongs;
		$data['selected_num_ptd'] = $selected_num_ptd;
		$data['selected_num_ytd'] = $selected_num_ytd;
		$data['selected_num_mtd'] = $selected_num_mtd;
		$data['completed_num_ptd'] = $completed_num_ptd;
		$data['completed_num_ytd'] = $completed_num_ytd;
		$data['completed_num_mtd'] = $completed_num_mtd;
		$data['track_readalong_data'] = $track_readalong_data;

		$this->loadView('admin/report/track-readalong-selection', $headerdata, $data);
	}

	public function track_readalong_selected_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Selected Users";
		$data = array();
		$urlAry = explode("@", base64_decode($this->uri->segment(3)));
		$readalong_title = $urlAry[0];
		$level_id = $urlAry[1];
		$type = $urlAry[2]; //1=PTD,2=YTD,3=MTD

		if ($level_id == 1) {
			$level = "E";
		}
		elseif ($level_id == 3) {
			$level = "C";
		}
		else{
			$level = "A";
		}

		$search_data = "";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$search_data = $postdata['search_data'];
		}

		if ($type == 1) {
			$result = $this->ss_aw_report_model->getreadalongselectedusers($search_data, $level, $readalong_title);
		}
		elseif ($type == 2) {
			$result = $this->ss_aw_report_model->getreadalongselectedusers($search_data, $level, $readalong_title, 1);
		}
		else{
			$result = $this->ss_aw_report_model->getreadalongselectedusers($search_data, $level, $readalong_title, 2);
		}

		$data['search_data'] = $search_data;
		$data['level'] = $level;
		$data['readalong_title'] = $readalong_title;
		$data['type'] = $type;
		$data['result'] = $result;
		
		$this->loadView('admin/report/track-readalong-selected-user-list', $headerdata, $data);
	}

	public function track_readalong_completed_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Completed Users";
		$data = array();
		$urlAry = explode("@", base64_decode($this->uri->segment(3)));
		$readalong_title = $urlAry[0];
		$level_id = $urlAry[1];
		$type = $urlAry[2]; //1=PTD,2=YTD,3=MTD

		if ($level_id == 1) {
			$level = "E";
		}
		elseif ($level_id == 3) {
			$level = "C";
		}
		else{
			$level = "A";
		}

		$search_data = "";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$search_data = $postdata['search_data'];
		}

		if ($type == 1) {
			$result = $this->ss_aw_report_model->getreadalongcompletedusers($search_data, $level, $readalong_title);
		}
		elseif ($type == 2) {
			$result = $this->ss_aw_report_model->getreadalongcompletedusers($search_data, $level, $readalong_title, 1);
		}
		else{
			$result = $this->ss_aw_report_model->getreadalongcompletedusers($search_data, $level, $readalong_title, 2);
		}

		$data['search_data'] = $search_data;
		$data['level'] = $level;
		$data['readalong_title'] = $readalong_title;
		$data['type'] = $type;
		$data['result'] = $result;
		$this->loadView('admin/report/track-readalong-completed-user-list', $headerdata, $data);
	}

	public function export_readalong_selection_report(){
		$data = array();
		$readalongs = array();
		$selected_num_ptd = array();
		$selected_num_ytd = array();
		$selected_num_mtd = array();
		$completed_num_ptd = array();
		$completed_num_ytd = array();
		$completed_num_mtd = array();
		$track_readalong_data = array();

		$assign_level = $this->uri->segment(3);
		$track_readalong_data['assign_level'] = $assign_level;
		if (!empty($assign_level)) {
			$search_data = array();
			if ($assign_level == 1 || $assign_level == 2) {
				$level = "E";
			}
			elseif ($assign_level == 3) {
				$level = "C";
			}
			elseif ($assign_level == 5) {
				$level = "A";
			}
			$search_data['ss_aw_level'] = $level;
			$readalongs = $this->ss_aw_readalongs_upload_model->fetch_by_params($search_data);
				
			if (!empty($readalongs)) {
				foreach ($readalongs as $key => $value) {
					$readalong_id = $value['ss_aw_id'];
					$readalong_title = $value['ss_aw_title'];
					$selected_num_ptd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongselectionnum($level, $readalong_title);
					$selected_num_ytd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongselectionnum($level, $readalong_title, 1);
					$selected_num_mtd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongselectionnum($level, $readalong_title, 2);

					$completed_num_ptd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongcompletednum($level, $readalong_title);
					$completed_num_ytd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongcompletednum($level, $readalong_title, 1);
					$completed_num_mtd[$value['ss_aw_id']] = $this->ss_aw_report_model->getreadalongcompletednum($level, $readalong_title, 2);
				}
			}	
		}
  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Readalongs');

        $objPHPExcel->getActiveSheet()->SetCellValue('B1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'PTD');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', '');

        $objPHPExcel->getActiveSheet()->SetCellValue('E1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'YTD');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', '');

        $objPHPExcel->getActiveSheet()->SetCellValue('H1', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'MTD');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', '');

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', '');

        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Selected');       
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Completed');       
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', '%Completed');

        $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Selected');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Completed');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G2', '%Completed');

        $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Selected');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Completed');       
        $objPHPExcel->getActiveSheet()->SetCellValue('J2', '%Completed');

        // set Row
        $rowCount = 3;
        foreach ($readalongs as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value['ss_aw_title']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $selected_num_ptd[$value['ss_aw_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $completed_num_ptd[$value['ss_aw_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, get_percentage($selected_num_ptd[$value['ss_aw_id']], $completed_num_ptd[$value['ss_aw_id']])."%");
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $selected_num_ytd[$value['ss_aw_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $completed_num_ytd[$value['ss_aw_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, get_percentage($selected_num_ytd[$value['ss_aw_id']], $completed_num_ytd[$value['ss_aw_id']])."%");
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $selected_num_mtd[$value['ss_aw_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $completed_num_mtd[$value['ss_aw_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, get_percentage($selected_num_mtd[$value['ss_aw_id']], $completed_num_mtd[$value['ss_aw_id']])."%");
            $rowCount++;
        }
        $filename = "track-readalong-selection". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function new_enrolees(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "New Enrolls";
		$program_date = date('Y-m-d');
		$ptd_num_details = $this->ss_aw_report_model->getdiffuserlogintypenum($program_date);
		$current_year = date('Y');
		$ytd_num_details = $this->ss_aw_report_model->getdiffuserlogintypenum_ytd($current_year);

		$count = 0;
		$monthly_data = array();
		for ($i=0; $i < 25; $i++) { 
			if ($i == 0) {
				$current_month = date('m');
				$current_year = date('Y');
				$monthly_data[date('F Y', strtotime(date('Y-m-d')))] = $this->ss_aw_report_model->getdiffuserlogintypenum_monthly($current_year, $current_month);
			}
			else
			{
				if ($i == 1) {
					$current_date = date('Y-m-d');
					$previous_month_date = date('Y-m-d', strtotime($current_date.' -1 month'));	
				}
				else{
					$previous_month_date = date('Y-m-d', strtotime($previous_month_date.' -1 month'));
				}
				$previous_year = date('Y', strtotime($previous_month_date));
				$previous_month = date('m', strtotime($previous_month_date));
				$month_year = date('F Y', strtotime($previous_month_date));
				$monthly_data[$month_year] = $this->ss_aw_report_model->getdiffuserlogintypenum_monthly($previous_year, $previous_month);
			}
		}

		$data['ptd_num_details'] = $ptd_num_details;
		$data['ytd_num_details'] = $ytd_num_details;
		$data['monthly_data'] = $monthly_data;
		
		$this->loadView('admin/report/new-enrolls', $headerdata, $data);
	}

	public function next_level_ability(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Next Level Ability";
		for ($i=1; $i <= 3; $i++) { 
			if ($i == 1) {
				$level = "E";
			}
			elseif ($i == 2) {
				$level = "C";
			}
			else{
				$level = "A";
			}

			
		}
	}

	public function diagnostic_child_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Report";

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$child_id = $postdata['child_id'];
			$data['child_id'] = $child_id;
			$data['result'] = $this->ss_aw_diagonastic_exam_model->getFUTstudentsreport($child_id);
		}

		$data['students'] = $this->ss_aw_diagonastic_exam_model->getFUTstudents();
		$this->loadView('admin/report/diagnostic_fut_report', $headerdata, $data);
	}

	public function assessment_child_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Report";

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$child_id = $postdata['child_id'];
			$assessment_id = $postdata['assessment_id'];
			$data['child_id'] = $child_id;
			$data['assessment_id'] = $assessment_id;
			$data['result'] = $this->ss_aw_report_model->getFUTstudentsassessmentreport($child_id, $assessment_id);
		}

		$data['students'] = $this->ss_aw_report_model->getFUTstudents();

		$this->loadView('admin/report/assessment_fut_report', $headerdata, $data);
	}

	public function getassessmentbychild(){
		$child_id = $this->input->get('child_id');
		$childary = $this->ss_aw_child_course_model->get_details($child_id);
		$level = $childary[count($childary) - 1]['ss_aw_course_id'];
		if ($level == 1) {
			$level_type = "E";
		}
		elseif ($level == 2) {
			$level_type = "C";
		}
		else{
			$level_type = "A";
		}

		$data['assessment_list'] = $this->ss_aw_assesment_uploaded_model->get_assessment_bylevel($level_type);
		$this->load->view('admin/report/ajax/diagnostic_list', $data);
	}

	public function incorrect_answers(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Incorrect Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$quiz_type = $urlStringAry[2];
		$quiz_format = "";
		$wrong_answer_details = array();
		$question = "";
		$question_preface = "";
		$correct_answer = "";
		$question_topic = "";

		if ($quiz_type == 2) {
			$quiz_format = $urlStringAry[3];
		}
		if (empty($urlStringAry[4])) {
			$page_num = 0;
		}
		else{
			$page_num = $urlStringAry[4];
		}
		
		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				if ($quiz_type == 1) {
					$question_details = $this->ss_aw_report_model->get_question_detail($question_id);
					$question_id = $question_details[0]->ss_aw_lession_id;
					$question = $question_details[0]->ss_aw_lesson_details;
					$question_preface = $question_details[0]->ss_aw_lesson_title;
					$correct_answer = $question_details[0]->ss_aw_lesson_answers;
					$question_topic = $question_details[0]->topic_title;
					$wrong_answer_details = $this->ss_aw_report_model->get_all_wrong_answers($child_id_ary, $quiz_type, $question_id);
				}
				elseif ($quiz_type == 2) {
					$question_details = $this->ss_aw_report_model->get_question_detail_assessment($question_id);
					$question = $question_details[0]->ss_aw_question;
					$question_preface = $question_details[0]->ss_aw_question_preface;
					$correct_answer = $question_details[0]->ss_aw_answers;
					$question_topic = $question_details[0]->ss_aw_category;
					$wrong_answer_details = $this->ss_aw_report_model->get_all_wrong_answers($child_id_ary, $quiz_type, trim($question), $quiz_format, $question_id);

				}
				elseif ($quiz_type == 3){
					$question_details = $this->ss_aw_report_model->get_question_detail_assessment($question_id);
					$question = $question_details[0]->ss_aw_question;
					$question_preface = $question_details[0]->ss_aw_question_preface;
					$correct_answer = $question_details[0]->ss_aw_answers;
					$question_topic = $question_details[0]->ss_aw_category;
					$wrong_answer_details = $this->ss_aw_report_model->get_all_wrong_answers($child_id_ary, $quiz_type, "", "", $question_id);
				}
				else{
					$question_details = $this->ss_aw_report_model->get_readalong_question_details($question_id);
					$question = $question_details->ss_aw_details;
					$question_preface = $question_details->ss_aw_question;
					$correct_answer = $question_details->ss_aw_answers;
					$question_topic = $question_details->ss_aw_title;
					$wrong_answer_details = $this->ss_aw_report_model->get_all_wrong_answers($child_id_ary, $quiz_type, "", "", $question_id);
				}	
			}
		}
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_details'] = $wrong_answer_details;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('search_data');
		$this->loadView('admin/report/incorrect-answer-page', $headerdata, $pagedata);
	}

	public function hesitancy_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Hesitancy Report";
		$fut_students = $this->ss_aw_report_model->get_fut_students();
		$topical_lesson_complete_count = array();
		$topical_assessment_complete_count = array();
		$topical_grammer_avg_time = array();
		$topical_skipped_question = array();
		$multiple_lesson_complete_count = array();
		$multiple_assessment_complete_count = array();
		$english_proficiency_grammer_avg_time = array();
		$english_proficiency_skipped_question = array();
		$reading_comprehension_grammer_avg_time = array();
		$reading_comprehension_skipped_question = array();
		$readalong_complete_count = array();
		if (!empty($fut_students)) {
			foreach ($fut_students as $key => $value) {
				$complete_topical_lessons = $this->ss_aw_report_model->get_complete_topical_lessons($value->ss_aw_child_id);
				$complete_t_l_c = array();
				if (!empty($complete_topical_lessons)) {
					if (!empty($complete_topical_lessons[0]->lesson_id)) {
						$complete_t_l_c = explode(",", $complete_topical_lessons[0]->lesson_id);	
					}
				}
				$topical_lesson_complete_count[$value->ss_aw_child_id] = count($complete_t_l_c);
				$lesson_time = 0;
				$lesson_total_question = 0;
				if (!empty($complete_t_l_c)) {
					$topical_lesson_answer_detail = $this->ss_aw_report_model->get_lesson_answer_detail($complete_t_l_c, $value->ss_aw_child_id);
					$lesson_time = $topical_lesson_answer_detail[0]->total_time;
					$lesson_total_question = $topical_lesson_answer_detail[0]->total_question;	
				}

				$complete_topical_assessment = $this->ss_aw_report_model->get_complete_topical_assessment($value->ss_aw_child_id);
				
				$complete_t_a_c = array();
				if (!empty($complete_topical_assessment)) {
					if (!empty($complete_topical_assessment[0]->assessment_id)) {
						$complete_t_a_c = explode(",", $complete_topical_assessment[0]->assessment_id);	
					}
				}
				$topical_assessment_complete_count[$value->ss_aw_child_id] = count($complete_t_a_c);
				$assessment_time = 0;
				$assessment_total_question = 0;
				if (!empty($complete_t_a_c)) {
					$topical_assessment_answer_detail = $this->ss_aw_report_model->get_assessment_answer_detail($complete_t_a_c, $value->ss_aw_child_id);
					$assessment_time = $topical_assessment_answer_detail[0]->total_time;
					$assessment_total_question = $topical_assessment_answer_detail[0]->total_question;	
				}

				$total_grammer_proficiency_time = $lesson_time + $assessment_time;
				$total_grammer_proficiency_count = $lesson_total_question + $assessment_total_question;

				$grammer_proficiency_avg = 0;
				if ($total_grammer_proficiency_count > 0) {
					$grammer_proficiency_avg = $total_grammer_proficiency_time / $total_grammer_proficiency_count;
				}

				$topical_grammer_avg_time[$value->ss_aw_child_id] = $grammer_proficiency_avg;
				$topical_skipped_question[$value->ss_aw_child_id] = $this->ss_aw_report_model->get_total_grammer_proficiency_skipped($complete_t_a_c, $value->ss_aw_child_id);

				//english proficiency and reading comprehension
				$complete_multiple_lessons = $this->ss_aw_report_model->get_complete_multiple_lessons($value->ss_aw_child_id);
				$complete_m_l_c = array();
				if (!empty($complete_multiple_lessons)) {
					if (!empty($complete_multiple_lessons[0]->lesson_id)) {
						$complete_m_l_c = explode(",", $complete_multiple_lessons[0]->lesson_id);	
					}
				}

				$multiple_lesson_complete_count[$value->ss_aw_child_id] = count($complete_m_l_c);


				$english_proficiency_lesson_time = 0;
				$english_proficiency_lesson_count = 0;

				$reading_comprehension_lesson_time = 0;
				$reading_comprehension_lesson_count = 0;

				$english_proficiency_skipped_count = 0;
				if (!empty($complete_m_l_c)) {
					foreach ($complete_m_l_c as $lession_id) {
						$lesson_details = $this->ss_aw_lessons_model->getrecordbyid($lession_id);
						$english_proficiency_questions = array();
						$reading_comprehension_questions = array();
						if (!empty($lesson_details)) {
							foreach ($lesson_details as $key => $lesson) {
								if ($key > 8) {
									$english_proficiency_questions[] = $lesson['ss_aw_lesson_details'];
								}
								else{
									$reading_comprehension_questions[] = $lesson['ss_aw_lesson_details'];
								}
							}
						}

						if ($value->ss_aw_child_id == 40) {
							echo "<pre>";
							print_r($english_proficiency_questions);
							die();	
						}

						if (!empty($english_proficiency_questions)) {
							$english_proficiency_lesson_answers = $this->ss_aw_report_model->get_multiple_lesson_answer_details($english_proficiency_questions, $value->ss_aw_child_id);

							if (!empty($english_proficiency_lesson_answers)) {
								$english_proficiency_lesson_time = $english_proficiency_lesson_time + $english_proficiency_lesson_answers[0]->total_time;
								$english_proficiency_lesson_count = $english_proficiency_lesson_count + $english_proficiency_lesson_answers[0]->total_count;
							}

							$skip_count = $this->ss_aw_report_model->get_english_proficiency_skip_count($english_proficiency_questions, $value->ss_aw_child_id);
							$english_proficiency_skipped_count = $english_proficiency_skipped_count + $skip_count;
						}

						if (!empty($reading_comprehension_questions)) {
							$reading_comprehension_lesson_answers = $this->ss_aw_report_model->get_multiple_lesson_answer_details($reading_comprehension_questions, $value->ss_aw_child_id);
							if (!empty($reading_comprehension_lesson_answers)) {
								$reading_comprehension_lesson_time = $reading_comprehension_lesson_time + $reading_comprehension_lesson_answers[0]->total_time;
								$reading_comprehension_lesson_count = $reading_comprehension_lesson_count + $reading_comprehension_lesson_answers[0]->total_count;
							}
						}
					}
				}

				$complete_muliple_assessment = $this->ss_aw_report_model->get_complete_multiple_assessment($value->ss_aw_child_id);
				
				$complete_m_a_c = array();
				if (!empty($complete_muliple_assessment)) {
					if (!empty($complete_muliple_assessment[0]->assessment_id)) {
						$complete_m_a_c = explode(",", $complete_muliple_assessment[0]->assessment_id);	
					}
				}

				$multiple_assessment_complete_count[$value->ss_aw_child_id] = count($complete_m_a_c);

				$english_proficiency_assessment_time = 0;
				$english_proficiency_assessment_count = 0;

				$reading_comprehension_assessment_time = 0;
				$reading_comprehension_assessment_count = 0;
				if (!empty($complete_m_a_c)) {
					foreach ($complete_m_a_c as $assessment_id) {
						$assessment_details = $this->ss_aw_assisment_diagnostic_model->fetchrecordbyid($assessment_id);
						$english_proficiency_assessment_questions = array();
						$reading_comprehension_assessment_questions = array();
						if (!empty($assessment_details)) {
							foreach ($assessment_details as $assessment) {
								if ($key > 8) {
									$english_proficiency_assessment_questions[] = $assessment['ss_aw_question'];
								}
								else{
									$reading_comprehension_assessment_questions[] = $assessment['ss_aw_question'];
								}
							}
						}

						if (!empty($english_proficiency_assessment_questions)) {
							$english_proficiency_lesson_answers = $this->ss_aw_report_model->get_multiple_assessment_answer_details($english_proficiency_assessment_questions, $value->ss_aw_child_id);
							if (!empty($english_proficiency_lesson_answers)) {
								$english_proficiency_assessment_time = $english_proficiency_assessment_time + $english_proficiency_lesson_answers[0]->total_time;
								$english_proficiency_assessment_count = $english_proficiency_assessment_count + $english_proficiency_lesson_answers[0]->total_count;
							}
						}

						if (!empty($reading_comprehension_assessment_questions)) {
							$reading_comprehension_lesson_answers = $this->ss_aw_report_model->get_multiple_assessment_answer_details($reading_comprehension_assessment_questions, $value->ss_aw_child_id);
							if (!empty($reading_comprehension_lesson_answers)) {
								$reading_comprehension_assessment_time = $reading_comprehension_assessment_time + $reading_comprehension_lesson_answers[0]->total_time;
								$reading_comprehension_assessment_count = $reading_comprehension_assessment_count + $reading_comprehension_lesson_answers[0]->total_count;
							}
						}
					}
				}

				$english_proficiency_total_time = $english_proficiency_lesson_time + $english_proficiency_assessment_time;
				$english_proficiency_total_count = $english_proficiency_lesson_count + $english_proficiency_assessment_count;

				$english_proficiency_avg_time = 0;
				if ($english_proficiency_total_count > 0) {
					$english_proficiency_avg_time = $english_proficiency_total_time / $english_proficiency_total_count;
				}

				$reading_comprehension_total_time = $reading_comprehension_lesson_time + $reading_comprehension_assessment_time;
				$reading_comprehension_total_count = $reading_comprehension_lesson_count + $reading_comprehension_assessment_count;
				$reading_comprehension_avg_time = 0;
				if ($reading_comprehension_total_count > 0) {
					$reading_comprehension_avg_time = $reading_comprehension_total_time / $reading_comprehension_total_count;
				}

				$english_proficiency_grammer_avg_time[$value->ss_aw_child_id] = $english_proficiency_avg_time;
				$reading_comprehension_grammer_avg_time[$value->ss_aw_child_id] = $reading_comprehension_avg_time;
				$readalong_complete_count[$value->ss_aw_child_id] = $this->ss_aw_report_model->get_readalong_complete_count($value->ss_aw_child_id);
				$english_proficiency_skipped_question[$value->ss_aw_child_id] = $english_proficiency_skipped_count;
			}
		}

		$data['grammer_proficiency_lesson_count'] = $topical_lesson_complete_count;
		$data['grammer_proficiency_assessment_count'] = $topical_assessment_complete_count;
		$data['grammer_proficiency_avg_time'] = $topical_grammer_avg_time;
		$data['grammer_proficiency_skipped_question'] = $topical_skipped_question;
		$data['multiple_lesson_count'] = $multiple_lesson_complete_count;
		$data['multiple_assessment_count'] = $multiple_assessment_complete_count;
		$data['english_proficiency_answer_avg_time'] = $english_proficiency_grammer_avg_time;
		$data['english_proficiency_skipped_count'] = $english_proficiency_skipped_question;
		$data['reading_comprehension_answer_avg_time'] = $reading_comprehension_grammer_avg_time;
		$data['total_readalong_complete_count'] = $readalong_complete_count;
		$data['fut_students'] = $fut_students;

		$this->loadView('admin/report/hesitency-report', $headerdata, $data);
	}

	public function gettopicsbyquiztype(){
		$student_level = $this->input->get('student_level');
		$quiz_type = $this->input->get('quiz_type');
		$data = array();
		
		if (!empty($student_level) && !empty($quiz_type)) {
			if ($quiz_type == 1) {
				$topic_listary = array();
				$general_language_lessons = array();
				if ($student_level == 1 || $student_level == 2) {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'E';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
					$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
				}
				elseif($student_level == 3){
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
				$data['result'] = array_merge($topical_lessons, $general_language_lessons);
			}
			elseif ($quiz_type == 2 || $quiz_type == 3) {
				$topic_listary = array();
				$general_language_assessments = array();
				if ($student_level == 1 || $student_level == 2) {
					$search_data = array();
					$search_data['ss_aw_expertise_level'] = 'E';
					$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
					$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();	
				}
				elseif($student_level == 3){
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
					foreach ($topic_listary as $key => $value) {
						$topicAry[] = $value->ss_aw_section_id;
					}
				}
				$topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics($topicAry);

				$result = array_merge($topical_assessments, $general_language_assessments);
				$data['result'] = $result;
			}
			else{
				if ($student_level == 1 || $student_level == 2) {
					$course_code = "E";
				}
				elseif ($student_level == 3 || $student_level == 5) {
					$course_code = "A";
				}
				$searchary['ss_aw_level'] = $course_code;
				$result = $this->ss_aw_readalongs_upload_model->fetch_by_params($searchary);
				$data['result'] = $result;
			}
			$data['quiz_type'] = $quiz_type;
		}
		$this->load->view('admin/report/ajax/topic_list', $data);
	}

	public function enroll_current_status() {
        $this->load->model('Cron_report_enroll_current_status_model');
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Enrol Current Status";
        $searchdata = array();
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $course_type = $postdata['assign_level'];
            $data['assign_level'] = $postdata['assign_level'];
        } else {
            $course_type = 1;
            $data['assign_level'] = 1;
        }

        $previous_month_date = date('Y-m-d');
        $date = $previous_month_date;
        $previous_year = date('Y', strtotime($previous_month_date));
        $previous_month = date('m', strtotime($previous_month_date));

        $all_child_count = $this->Cron_report_enroll_current_status_model->getAllChildCount($previous_month, $previous_year, $course_type, '');
      
        
        $all_child_count_ptd = $this->Cron_report_enroll_current_status_model->getAllChildCompletedPTD($previous_month, $previous_year, $course_type, 2);
 
        $monthly_total_complete_num = $this->Cron_report_enroll_current_status_model->getessoncompletenum($previous_month, $previous_year, $course_type);

        $total_monthly['completed'] = 0;
        $total_monthly['completed_per'] = 0;
        $total_monthly['completed_ptd'] = 0;
        $total_monthly['completed_ptd_per'] = 0;
        $total_monthly['completed_ptd_child'] = '';

        $total_monthly['course_id'] = $course_type;
        $total_monthly['completed'] = @$monthly_total_complete_num->complete_num == '' ? 0 : $monthly_total_complete_num->complete_num;
        $total_monthly['completed_child'] = @$monthly_total_complete_num->child_id != '' && (!empty($monthly_total_complete_num)) ? $monthly_total_complete_num->child_id : '';
        $total_monthly['completed_total'] = $all_child_count == 0 ? 0 : $all_child_count;
        if ($total_monthly['completed'] != 0) {
            $total_monthly['completed_per'] = round(( ( $total_monthly['completed'] / $all_child_count ) * 100), 2);
        }
        $total_monthly['completed_ptd']=$all_child_count_ptd->child_count;
        if ($total_monthly['completed_ptd'] != 0) {
            $total_monthly['completed_ptd_per'] = round(( ( $total_monthly['completed_ptd'] / $all_child_count ) * 100), 2);
        }
        $total_monthly['completed_ptd_child'] = $all_child_count_ptd->child_id;
        // Active childs details
        $all_child_count_in_active = $this->Cron_report_enroll_current_status_model->getAllChildCount($previous_month, $previous_year, $course_type, 1);

        $total_monthly['incompleted_total'] = !empty($all_child_count_in_active) ? $all_child_count_in_active : 0;
        $total_monthly['active'] = 0;
        $total_monthly['active_child'] = '';
        $total_monthly['active_percent'] = 0;

        $active_monthly_data = $this->Cron_report_enroll_current_status_model->getessonincompletenum($date, $course_type, $range_type = '1');

        if (!empty($active_monthly_data)) {
            $total_monthly['active'] = @$active_monthly_data->complete_num == '' ? 0 : $active_monthly_data->complete_num;
            $total_monthly['active_child'] = @$active_monthly_data->child_id == '' ? 0 : $active_monthly_data->child_id;

            if ($total_monthly['active'] > 0) {
                $total_monthly['active_percent'] = round((( $total_monthly['active'] / $all_child_count_in_active ) * 100), 2);
            }
        }
        // Inactive childs details
        $total_monthly['inactive'] = 0;
        $total_monthly['inactive_child'] = '';
        $total_monthly['inactive_per'] = 0;

        $inactive_monthly_data = $this->Cron_report_enroll_current_status_model->getessonincompletenum($date, $course_type, $range_type = '2');

        if (!empty($inactive_monthly_data)) {
            $total_monthly['inactive'] = @$inactive_monthly_data->complete_num == '' ? 0 : $inactive_monthly_data->complete_num;
            $total_monthly['inactive_child'] = @$inactive_monthly_data->child_id == '' ? 0 : $inactive_monthly_data->child_id;

            if ($total_monthly['inactive'] > 0) {
                $total_monthly['inactive_per'] = round((( $total_monthly['inactive'] / $all_child_count_in_active ) * 100), 2);
            }
        }

        // Deliquent childs details
        $total_monthly['delinquent'] = 0;
        $total_monthly['delinquent_child'] = '';
        $total_monthly['delinquent_per'] = 0;

        $delinquent_monthly_data = $this->Cron_report_enroll_current_status_model->getessonincompletenum($date, $course_type, $range_type = '3');

        if (!empty($delinquent_monthly_data)) {
            $total_monthly['delinquent'] = @$delinquent_monthly_data->complete_num == '' ? 0 : $delinquent_monthly_data->complete_num;
            $total_monthly['delinquent_child'] = @$delinquent_monthly_data->child_id == '' ? 0 : $delinquent_monthly_data->child_id;

            if ($total_monthly['delinquent'] > 0) {
                $total_monthly['delinquent_per'] = round((( $total_monthly['delinquent'] / $all_child_count_in_active ) * 100), 2);
            }
        }


        $cron_data = $this->Cron_report_enroll_current_status_model->getAllEnrollStatus($course_type);

        $data['recent_data'] = $total_monthly;
        $data['pre_data'] = $cron_data;

        $this->loadView('admin/report/enroll_current_status', $headerdata, $data);
    }

    public function enroll_current_user() {
        $headerdata = $this->checklogin();

        $data = array();

        $headerdata['title'] = "Enroll current Users";
        $childs = base64_decode($this->uri->segment(3));
        $childary = explode(",", $childs);
        $data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary_with_parent_lesson($childary);
        
        $this->loadView('admin/report/enroll_current_user', $headerdata, $data);
    }

	public function inactive_stage(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Inactive Stage";

		// $winners_students = $this->ss_aw_report_model->getchilddetailsbylevel(1);
		// $champions_students = $this->ss_aw_report_model->getchilddetailsbylevel(3);
		// $masters_students = $this->ss_aw_report_model->getchilddetailsbylevel(5);
		$winners_students = get_active_inactive_delinquent_students(array('level' => 1));
		$champions_students = get_active_inactive_delinquent_students(array('level' => 3));
		$masters_students = get_active_inactive_delinquent_students(array('level' => 5));
		$topic_listary = array();
		$general_language_lessons = array();

		$winners_topic_name = array();
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'E';
		$winners_topics = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		if (!empty($winners_topics)) {
			foreach ($winners_topics as $key => $value) {
				array_push($winners_topic_name, $value->ss_aw_section_title);
			}
		}
		$winners_general_language = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
		if (!empty($winners_general_language)) {
			foreach ($winners_general_language as $key => $value) {
				array_push($winners_topic_name, $value['ss_aw_lesson_topic']);
			}
		}
		
		$champions_topic_name = array();
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'C';
		$champions_topics = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		if (!empty($champions_topics)) {
			foreach ($champions_topics as $key => $value) {
				array_push($champions_topic_name, $value->ss_aw_section_title);
			}
		}
		$champions_general_language = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
		if (!empty($champions_general_language)) {
			foreach ($champions_general_language as $key => $value) {
				array_push($champions_topic_name, $value['ss_aw_lesson_topic']);
			}
		}

		$masters_topic_name = array();
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'A,M';
		$masters_topics = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		if (!empty($masters_topics)) {
			foreach ($masters_topics as $key => $value) {
				array_push($masters_topic_name, $value->ss_aw_section_title);
			}
		}

		$topic_listary = array_merge($winners_topics, $champions_topics, $masters_topics);
		$topicAry = array();
		if (!empty($topic_listary)) {
			foreach ($topic_listary as $key => $value) {
				$topicAry[] = $value->ss_aw_section_id;
			}
		}
		$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

		$general_language_lessons = array_merge($winners_general_language, $champions_general_language);
		$lesson_list = array_merge($topical_lessons, $general_language_lessons);
		
		$winners = array();
		$champions = array();
		$masters = array();
		if (!empty($lesson_list)) {
			foreach ($lesson_list as $key => $value) {
				if (in_array($value['ss_aw_lesson_topic'], $winners_topic_name)) {
					//$winners[$value['ss_aw_lession_id']] = $this->ss_aw_report_model->getcompletelessoncountbylevel($winners_students[0]->child_ids, $value['ss_aw_lession_id']);	
					$winners[$value['ss_aw_lession_id']] = $this->ss_aw_report_model->getcompletelessoncountbylevel($winners_students['inactive_student_ary'], $value['ss_aw_lession_id']);	
				}
				else{
					$winners[$value['ss_aw_lession_id']] = "-";
				}
				
				if (in_array($value['ss_aw_lesson_topic'], $champions_topic_name)) {
					$champions[$value['ss_aw_lession_id']] = $this->ss_aw_report_model->getcompletelessoncountbylevel($champions_students['inactive_student_ary'], $value['ss_aw_lession_id']);	
				}	
				else{
					$champions[$value['ss_aw_lession_id']] = "-";
				}
				
				if (in_array($value['ss_aw_lesson_topic'], $masters_topic_name)) {
					$masters[$value['ss_aw_lession_id']] = $this->ss_aw_report_model->getcompletelessoncountbylevel($masters_students['inactive_student_ary'], $value['ss_aw_lession_id']);	
				}
				else{
					$masters[$value['ss_aw_lession_id']] = "-";
				}
			}
		}

		$data['winners_complete_count'] = $winners;
		$data['champions_complete_count'] = $champions;
		$data['masters_complete_count'] = $masters;
		$data['lesson_list'] = $lesson_list;
		$this->loadView('admin/report/inactive_stage', $headerdata, $data);

	}

	public function days_deliquent() {
        $this->load->model('ss_aw_assessment_exam_completed_model');
        $this->load->model('ss_aw_assesment_questions_asked_model');
        $this->load->model('ss_aw_assesment_multiple_question_asked_model');
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Days Deliquent";

        $searchary = array();
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $searchary['level'] = $postdata['level'];
        } else {
            $searchary['level'] = 1;
        }
        if ($searchary['level'] == 1) {
            $filter['expertise_level'] = 'E';
            $general_language = 2;
        } elseif ($searchary['level'] == 5) {
            $filter['expertise_level'] = 'A,M';
            $general_language = '';
        } elseif ($searchary['level'] == 3) {
            $filter['expertise_level'] = 'C';
            $general_language = '';
        }

        $get_data = $this->ss_aw_report_model->getAllDelinquentdata($filter, $general_language);
       
        
        $deliquient = array();
        $first=array();
        if (!empty($get_data)) {
            foreach ($get_data->result() as $dat) {
                if (!in_array($dat->ss_aw_lesson_topic, $deliquient)) {
                    $deliquient[] = $dat->ss_aw_lesson_topic;
                    
                }
                $top_array= str_replace(" ","_",$dat->ss_aw_lesson_topic);
                if(!empty($this->ss_aw_child_course_model->checkchildCourse($dat->ss_aw_diagonastic_child_id,$searchary['level']))){
                
                    
                    if (!empty($dat->ss_aw_last_lesson_create_date)) {

                    $assessment_id = "";
                    $topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($dat->ss_aw_diagonastic_child_id, $dat->ss_aw_lession_id);
                    if (!empty($topical_assessment_start_details)) {
                        $assessment_id = @$topical_assessment_start_details[0]->ss_aw_assessment_id;
                    } else {
                        $comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($dat->ss_aw_diagonastic_child_id, $dat->ss_aw_lession_id);

                        $assessment_id = @$comprehension_assessment_start_details[0]->ss_aw_assessment_id;
                    }

                    $assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $dat->ss_aw_diagonastic_child_id);
                    if (@$assessment_completetion_details[0]->ss_aw_create_date == '') {
                        $current_date = date('Y-m-d');
                        $diff = strtotime($current_date) - strtotime($dat->ss_aw_last_lesson_create_date);
                        $diffDay = round($diff / (60 * 60 * 24));
                        if ($diffDay > 7 && $diffDay <= 14) {
                            if(!in_array($dat->ss_aw_diagonastic_child_id,$first[$top_array]['user_id'])){
                            $first[$top_array]['section'] = @$first[$top_array]['section'] + 1;
                            $first[$top_array]['user_id'][]=$dat->ss_aw_diagonastic_child_id;
                            }
                           
                        } elseif ($diffDay > 14 && $diffDay <= 21) {                            
                            if(!in_array($dat->ss_aw_diagonastic_child_id,$second[$top_array]['user_id'])){
                            $second[$top_array]['section'] = @$second[$top_array]['section'] + 1;
                            $second[$top_array]['user_id']=$dat->ss_aw_diagonastic_child_id;
                            }
                        } elseif ($diffDay > 21) {
                            if(!in_array($dat->ss_aw_diagonastic_child_id,$third[$top_array]['user_id'])){
                            $third[$top_array]['section'] = @$third[$top_array]['section'] + 1;
                            $third[$top_array]['user_id'][]=$dat->ss_aw_diagonastic_child_id;
                            }
                        }
                    }
                }
            }
            }
        }
       
        $data['first_dq']=$first;
        $data['second_dq']=$second;
        $data['third_dq']=$third;
        $data['deliquient'] = $deliquient;
        $data['days_deliquent_data'] = $searchary;
        $this->loadView('admin/report/days_deliquent', $headerdata, $data);
    }

    public function days_deliquent_users(){
        $headerdata = $this->checklogin();
		$data = array();		
		$topic = base64_decode($this->uri->segment(3));
        $headerdata['title'] = "Delinquent Users -".$topic;
		$childs = $this->uri->segment(4);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		
		$this->loadView('admin/report/days_deliquent_users',$headerdata, $data);
    }

	public function reporting_collection(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Reporting Collection";
		$result = array();
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('reporting_collection_start_date', $postdata['report_start_date']);
			$this->session->set_userdata('reporting_collection_end_date', $postdata['report_end_date']);
			$start_date = date('m/Y', strtotime($postdata['report_start_date']));
			$end_date = date('m/Y', strtotime($postdata['report_end_date']));
			$result = $this->ss_aw_reporting_collection_model->getalldata($start_date, $end_date);

			$data['month'] = $postdata['report_start_date'];
			$data['year'] = $postdata['report_end_date'];
		}
		else{
			$this->session->unset_userdata('reporting_collection_start_date');
			$this->session->unset_userdata('reporting_collection_end_date');

			$start_date = date('m');
			$end_date = date('Y');
			$result = $this->ss_aw_reporting_collection_model->getalldata($start_date, $end_date);
			
			$data['month'] = $start_date;
			$data['year'] = $end_date;
		}
		
		$data['collection_details'] = $result;
		$this->loadView('admin/report/reporting_collection', $headerdata, $data);
		
	}

	public function reporting_collection_export(){

		$headerdata = $this->checklogin();
		$headerdata['title'] = "Reporting Collection";
		$result = array();
		if (!empty($this->session->userdata('reporting_collection_start_date')) && !empty($this->session->userdata('reporting_collection_end_date'))) {
			$postdata = $this->input->post();
			$start_date = date('m/Y', strtotime($this->session->userdata('reporting_collection_start_date')));
			$end_date = date('m/Y', strtotime($this->session->userdata('reporting_collection_end_date')));
			$result = $this->ss_aw_reporting_collection_model->getalldata($start_date, $end_date);
		}
		else{
			$start_date = date('m');
			$end_date = date('Y');
			$result = $this->ss_aw_reporting_collection_model->getalldata($start_date, $end_date);
		}
		
		$pagedata['collection_details'] = $result;


		// create file name
        $fileName = 'data-'.time().'.xlsx';  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');       
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');       
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');       
        // set Row
        $rowCount = 2;
        foreach ($result as $value) {
        	if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                $program_type = "Winners";
            }
            elseif ($value->ss_aw_course_id == 3) {
                $program_type = "Champions";
            }
            elseif ($value->ss_aw_course_id == 5){
                $program_type = "Masters";
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_created_at)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, trim($value->ss_aw_parent_full_name));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->ss_aw_parent_city);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->ss_aw_parent_state);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->ss_aw_invoice_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
            $gst = round(($value->ss_aw_invoice_amount*18)/100, 2);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value->ss_aw_invoice_amount + $gst);
            $rowCount++;
        }
        $filename = "reporting-collection". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function reporting_revenue(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Reporting Revenue";

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('reporting_revenue_start_date', $postdata['report_start_date']);
			$this->session->set_userdata('reporting_revenue_end_date', $postdata['report_end_date']);
			$start_date = date('m/Y', strtotime($postdata['report_start_date']));
			$end_date = date('m/Y', strtotime($postdata['report_end_date']));
			$result = $this->ss_aw_reporting_revenue_model->getalldata($start_date, $end_date);

			$data['month'] = $postdata['report_start_date'];
			$data['year'] = $postdata['report_end_date'];
		}
		else{
			$this->session->unset_userdata('reporting_revenue_start_date');
			$this->session->unset_userdata('reporting_revenue_end_date');

			$start_date = date('m');
			$end_date = date('Y');
			$result = $this->ss_aw_reporting_revenue_model->getalldata($start_date, $end_date);
			
			$data['month'] = $start_date;
			$data['year'] = $end_date;
		}
		$data['revenue_details'] = $result;
		$this->loadView('admin/report/reporting_revenue', $headerdata, $data);
	}

	public function reporting_revenue_export(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Reporting Revenue";
		$result = array();
		if (!empty($this->session->userdata('reporting_revenue_start_date')) && !empty($this->session->userdata('reporting_revenue_end_date'))) {
			$postdata = $this->input->post();
			$start_date = date('m/Y', strtotime($this->session->userdata('reporting_revenue_start_date')));
			$end_date = date('m/Y', strtotime($this->session->userdata('reporting_revenue_end_date')));
			$result = $this->ss_aw_reporting_revenue_model->getalldata($start_date, $end_date);
		}
		else{
			$start_date = date('m');
			$end_date = date('Y');
			$result = $this->ss_aw_reporting_revenue_model->getalldata($start_date, $end_date);
		}
		
		$pagedata['collection_details'] = $result;

		// create file name
        $fileName = 'data-'.time().'.xlsx';  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');       
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');       
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');       
        // set Row
        $rowCount = 2;
        foreach ($result as $value) {
        	if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                $program_type = "Winners";
            }
            elseif ($value->ss_aw_course_id == 3) {
                $program_type = "Champions";
            }
            elseif ($value->ss_aw_course_id == 5){
                $program_type = "Masters";
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_revenue_date)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, trim($value->ss_aw_parent_full_name));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->ss_aw_parent_city);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->ss_aw_parent_state);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->ss_aw_invoice_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
            $gst = round(($value->ss_aw_invoice_amount*18)/100, 2);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value->ss_aw_invoice_amount + $gst);
            $rowCount++;
        }
        $filename = "reporting-revenue". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function advance_receipts(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Advance Receipts";
		$start_date = "";
		$end_date = "";
		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('advance_receipts_start_date', $postdata['report_start_date']);
			$this->session->set_userdata('advance_receipts_end_date', $postdata['report_end_date']);
		}
		if ($this->session->userdata('advance_receipts_start_date') && $this->session->userdata('advance_receipts_end_date')) {
			$start_date = date('Y-m', strtotime($this->session->userdata('advance_receipts_start_date')));
			$start_date = $start_date."-01";

			$end_date = date('Y-m', strtotime($this->session->userdata('advance_receipts_end_date')));
			$days_current_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($this->session->userdata('advance_receipts_end_date'))), date('Y', strtotime($this->session->userdata('advance_receipts_end_date'))));
			$end_date = $end_date."-".$days_current_month;

			$data['month'] = $this->session->userdata('advance_receipts_start_date');
			$data['year'] = $this->session->userdata('advance_receipts_end_date');
		}
		
		$data['advance_receipt'] = $this->ss_aw_reporting_revenue_model->get_advance_receipt_data($start_date, $end_date);
		$this->loadView('admin/report/advance_receipts', $headerdata, $data);
	}

	public function advance_receipts_export(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Advance Receipts";
		$result = array();
		if (!empty($this->session->userdata('advance_receipts_start_date')) && !empty($this->session->userdata('advance_receipts_end_date'))) {
			$start_date = date('Y-m', strtotime($this->session->userdata('advance_receipts_start_date')));
			$start_date = $start_date."-01";

			$end_date = date('Y-m', strtotime($this->session->userdata('advance_receipts_end_date')));
			$days_current_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($this->session->userdata('advance_receipts_end_date'))), date('Y', strtotime($this->session->userdata('advance_receipts_end_date'))));
			$end_date = $end_date."-".$days_current_month;
			$result = $this->ss_aw_reporting_revenue_model->get_advance_receipt_data($start_date, $end_date);
		}
	


		// create file name
        $fileName = 'data-'.time().'.xlsx';  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');       
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');       
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');       
        // set Row
        $rowCount = 2;
        foreach ($result as $value) {
        	if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                $program_type = "Winners";
            }
            elseif ($value->ss_aw_course_id == 3) {
                $program_type = "Champions";
            }
            elseif ($value->ss_aw_course_id == 5){
                $program_type = "Masters";
            }

            $advance_amount = round($value->advance_amount, 2);

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_revenue_date)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->ss_aw_parent_full_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->ss_aw_parent_city);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->ss_aw_parent_state);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $advance_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
            $gst = round(($advance_amount*18)/100, 2);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $advance_amount + $gst);
            $rowCount++;
        }
        $filename = "advance-receipts". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function advance_revenue(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Advance Revenue";
		$result = array();
		$revenue_amount = array();

		if ($this->input->post()) {
			$postdata = $this->input->post();
			$this->session->set_userdata('advance_revenue_start_date', $postdata['report_start_date']);
			$this->session->set_userdata('advance_revenue_end_date', $postdata['report_end_date']);
			$start_date = date('m/Y', strtotime($postdata['report_start_date']));
			$end_date = date('m/Y', strtotime($postdata['report_end_date']));
			$result = $this->ss_aw_reporting_revenue_model->getalladvancedata($start_date, $end_date);

			$data['month'] = $postdata['report_start_date'];
			$data['year'] = $postdata['report_end_date'];
		}
		else{
			$this->session->unset_userdata('advance_revenue_start_date');
			$this->session->unset_userdata('advance_revenue_end_date');

			$start_date = date('m');
			$end_date = date('Y');
			$result = $this->ss_aw_reporting_revenue_model->getalladvancedata($start_date, $end_date);
			
			$data['month'] = $start_date;
			$data['year'] = $end_date;
		}

		if (!empty($result)) {
			foreach ($result as $key => $value) {
				if ($value->ss_aw_payment_type == 1) {
					$month = date('m', strtotime($value->ss_aw_revenue_date));
					$year = date('Y', strtotime($value->ss_aw_revenue_date));
					$collection_details = $this->ss_aw_reporting_collection_model->getparentdatabymonthyear($month, $year, $value->ss_aw_parent_id);
					$revenue_amount[$value->ss_aw_id] = $collection_details[0]->ss_aw_invoice_amount - $value->ss_aw_invoice_amount;
				}
				else{
					$revenue_amount[$value->ss_aw_id] = $value->ss_aw_invoice_amount;
				}
			}
		}

		$data['revenue_details'] = $result;
		$data['revenue_amount'] = $revenue_amount;
		$this->loadView('admin/report/advance_revenue', $headerdata, $data);
	}

	public function advance_revenue_export(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Advance Revenue";
		$result = array();
		if (!empty($this->session->userdata('advance_revenue_start_date')) && !empty($this->session->userdata('advance_revenue_end_date'))) {
			$postdata = $this->input->post();
			$start_date = date('m/Y', strtotime($this->session->userdata('advance_revenue_start_date')));
			$end_date = date('m/Y', strtotime($this->session->userdata('advance_revenue_end_date')));
			$result = $this->ss_aw_reporting_revenue_model->getalladvancedata($start_date, $end_date);
		}
		else{
			$start_date = date('m');
			$end_date = date('Y');
			$result = $this->ss_aw_reporting_revenue_model->getalladvancedata($start_date, $end_date);
		}
		
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				if ($value->ss_aw_payment_type == 1) {
					$month = date('m', strtotime($value->ss_aw_revenue_date));
					$year = date('Y', strtotime($value->ss_aw_revenue_date));
					$collection_details = $this->ss_aw_reporting_collection_model->getparentdatabymonthyear($month, $year, $value->ss_aw_parent_id);
					$revenue_amount[$value->ss_aw_id] = $collection_details[0]->ss_aw_invoice_amount - $value->ss_aw_invoice_amount;
				}
				else{
					$revenue_amount[$value->ss_aw_id] = $value->ss_aw_invoice_amount;
				}
			}
		}
		
		$pagedata['revenue_details'] = $result;
		$pagedata['revenue_amount'] = $revenue_amount;

		// create file name
        $fileName = 'data-'.time().'.xlsx';  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');       
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');       
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');       
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');       
        // set Row
        $rowCount = 2;
        foreach ($result as $value) {
        	if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                $program_type = "Winners";
            }
            elseif ($value->ss_aw_course_id == 3) {
                $program_type = "Champions";
            }
            elseif ($value->ss_aw_course_id == 5){
                $program_type = "Masters";
            }

            if (!empty($reporting_revenue[$value->ss_aw_parent_id][date('m', strtotime($value->ss_aw_created_at))])) {
                $invoice_amount = $value->ss_aw_invoice_amount - $reporting_revenue[$value->ss_aw_parent_id][date('m', strtotime($value->ss_aw_created_at))];
            }
            else{
                $invoice_amount = $value->ss_aw_invoice_amount;
            }

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_revenue_date)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->ss_aw_parent_full_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->ss_aw_parent_city);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->ss_aw_parent_state);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $revenue_amount[$value->ss_aw_id]);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
            $gst = round(($revenue_amount[$value->ss_aw_id]*18)/100, 2);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $revenue_amount[$value->ss_aw_id] + $gst);
            $rowCount++;
        }
        $filename = "advance-revenue". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function daily_mis(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Daily MIS";
		$result = array();
		if ($this->input->post()) {
			$current_date = date('Y-m-d', strtotime($this->input->post('search_date')));
		}
		else{
			$current_date = date('Y-m-d');
		}
		$this->session->set_userdata('daily_mis_search_date', $current_date);
		$last_3_days = date('Y-m-d', strtotime($current_date."- 3 days"));
		$last_7_days = date('Y-m-d', strtotime($current_date."- 7 days"));

		$parent_profile = array();
		$parent_profile[0] = $this->ss_aw_parents_model->get_registration_by_date($current_date);
		$parent_profile[1] = $this->ss_aw_parents_model->get_registration_by_date_range($last_3_days, $current_date);
		$parent_profile[2] = $this->ss_aw_parents_model->get_registration_by_date_range($last_7_days, $current_date);
		$parent_profile[3] = $this->ss_aw_parents_model->get_registration_before_last_seven_days_of_current_date($last_7_days, $current_date);
		$parent_profile[4] = $this->ss_aw_parents_model->get_total_parents_up_to_date($current_date);

		$child_profile = array();
		$child_profile[0] = $this->ss_aw_childs_model->get_registration_by_date($current_date);
		$child_profile[1] = $this->ss_aw_childs_model->get_registration_by_date_range($last_3_days, $current_date);
		$child_profile[2] = $this->ss_aw_childs_model->get_registration_by_date_range($last_7_days, $current_date);
		$child_profile[3] = $this->ss_aw_childs_model->get_registration_before_last_seven_days_of_current_date($last_7_days, $current_date);
		$child_profile[4] = $this->ss_aw_childs_model->get_total_childs_up_to_date($current_date);

		$diagnostic_quiz_taken = array();
		$diagnostic_quiz_taken[0] = $this->ss_aw_diagonastic_exam_model->get_registration_by_date($current_date);

		$diagnostic_quiz_taken[1] = $this->ss_aw_diagonastic_exam_model->get_registration_by_date_range($last_3_days, $current_date);

		$diagnostic_quiz_taken[2] = $this->ss_aw_diagonastic_exam_model->get_registration_by_date_range($last_7_days, $current_date);
		
		$diagnostic_quiz_taken[3] = $this->ss_aw_diagonastic_exam_model->get_registration_before_last_seven_days_of_current_date($last_7_days);
		$diagnostic_quiz_taken[4] = $this->ss_aw_diagonastic_exam_model->get_total_childs_up_to_date($current_date);

		$diagnostic_quiz['emerging'] = 0;
		$diagnostic_quiz['consolidate'] = 0;
		$diagnostic_quiz['advance'] = 0;
		//get recommendation levels
		$result = $this->ss_aw_diagonastic_exam_model->get_daily_diagnostic_non_course_purchase_details($current_date);
		
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				//get diagnostic exam details
				$searchary = array();
				$searchary['ss_aw_diagonastic_child_id'] = $value->ss_aw_child_id;
				$resultary = array();
				$resultary = $this->ss_aw_diagonastic_exam_model->fetch_record_byparam($searchary);
				if (!empty($resultary)) {
					$exam_code = $resultary[0]['ss_aw_diagonastic_exam_code'];
					$searchary = array();
					$searchary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
					$examresultary = array();
					$examresultary = $this->ss_aw_diagonastic_exam_log_model->fetch_record_byparam($searchary);

					$total_marks = $this->ss_aw_diagonastic_exam_log_model->asked_question_num_by_exam_code($exam_code);
					$obtain_marks = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);

					$resultcountary = array();
					foreach($examresultary as $examresult)
					{
						if($examresult['ss_aw_diagonastic_log_answer_status'] != 3)
						{
							$resultcountary[$examresult['ss_aw_diagonastic_log_level']]['total_ask'][] = $examresult['ss_aw_diagonastic_log_question_id'];
							if($examresult['ss_aw_diagonastic_log_answer_status'] == 1)
								$resultcountary[$examresult['ss_aw_diagonastic_log_level']]['right_ans'][] = $examresult['ss_aw_diagonastic_log_question_id'];
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

					if ($recomended_level == 'E') {
						$diagnostic_quiz['emerging'] = $diagnostic_quiz['emerging'] + 1;
					}
					elseif ($recomended_level == 'C') {
						$diagnostic_quiz['consolidate'] = $diagnostic_quiz['consolidate'] + 1;
					}
					else{
						$diagnostic_quiz['advance'] = $diagnostic_quiz['advance'] + 1;
					}
				}
			}
		}

		//end				

		$enrollment_emi = array();
		$enrollment_emi[0] = $this->ss_aw_child_course_model->get_registration_by_date($current_date, 1);
		$enrollment_emi[1] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_3_days, $current_date, 1);
		$enrollment_emi[2] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_7_days, $current_date, 1);
		$enrollment_emi[3] = $this->ss_aw_child_course_model->get_registration_before_last_seven_days_of_current_date($last_7_days, 1);
		$enrollment_emi[4] = $this->ss_aw_child_course_model->get_total_childs_up_to_date($current_date, 1);
		$enrollment_emi_course['emerging'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 1, 1);
		$enrollment_emi_course['consolidate'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 1, 2);
		$enrollment_emi_course['advance'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 1, 3);

		$enrollment_lumpsum = array();
		$enrollment_lumpsum[0] = $this->ss_aw_child_course_model->get_registration_by_date($current_date, 0);
		$enrollment_lumpsum[1] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_3_days, $current_date, 0);
		$enrollment_lumpsum[2] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_7_days, $current_date, 0);
		$enrollment_lumpsum[3] = $this->ss_aw_child_course_model->get_registration_before_last_seven_days_of_current_date($last_7_days, 0);
		$enrollment_lumpsum[4] = $this->ss_aw_child_course_model->get_total_childs_up_to_date($current_date, 0);
		$enrollment_lumpsum_course['emerging'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 0, 1);
		$enrollment_lumpsum_course['consolidate'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 0, 2);
		$enrollment_lumpsum_course['advance'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 0, 3);

		$data['parent_profile'] = $parent_profile;
		$data['child_profile'] = $child_profile;
		$data['enrollment_emi'] = $enrollment_emi;
		$data['enrollment_lumpsum'] = $enrollment_lumpsum;
		$data['current_date'] = $current_date;
		$data['diagnostic_quiz_taken'] = $diagnostic_quiz_taken;
		$data['diagnostic_quiz'] = $diagnostic_quiz;
		$data['enrollment_emi_course'] = $enrollment_emi_course;
		$data['enrollment_lumpsum_course'] = $enrollment_lumpsum_course;

		$this->loadView('admin/report/daily_mis', $headerdata, $data);

	}

	public function daily_mis_export(){
		$result = array();
		$current_date = $this->session->userdata('daily_mis_search_date');
		$last_3_days = date('Y-m-d', strtotime($current_date."- 3 days"));
		$last_7_days = date('Y-m-d', strtotime($current_date."- 7 days"));

		$parent_profile = array();
		$parent_profile[0] = $this->ss_aw_parents_model->get_registration_by_date($current_date);
		$parent_profile[1] = $this->ss_aw_parents_model->get_registration_by_date_range($last_3_days, $current_date);
		$parent_profile[2] = $this->ss_aw_parents_model->get_registration_by_date_range($last_7_days, $current_date);
		$parent_profile[3] = $this->ss_aw_parents_model->get_registration_before_last_seven_days_of_current_date($last_7_days, $current_date);
		$parent_profile[4] = $this->ss_aw_parents_model->get_total_parents_up_to_date($current_date);

		$child_profile = array();
		$child_profile[0] = $this->ss_aw_childs_model->get_registration_by_date($current_date);
		$child_profile[1] = $this->ss_aw_childs_model->get_registration_by_date_range($last_3_days, $current_date);
		$child_profile[2] = $this->ss_aw_childs_model->get_registration_by_date_range($last_7_days, $current_date);
		$child_profile[3] = $this->ss_aw_childs_model->get_registration_before_last_seven_days_of_current_date($last_7_days, $current_date);
		$child_profile[4] = $this->ss_aw_childs_model->get_total_childs_up_to_date($current_date);

		$diagnostic_quiz_taken = array();
		$diagnostic_quiz_taken[0] = $this->ss_aw_diagonastic_exam_model->get_registration_by_date($current_date);

		$diagnostic_quiz_taken[1] = $this->ss_aw_diagonastic_exam_model->get_registration_by_date_range($last_3_days, $current_date);

		$diagnostic_quiz_taken[2] = $this->ss_aw_diagonastic_exam_model->get_registration_by_date_range($last_7_days, $current_date);
		
		$diagnostic_quiz_taken[3] = $this->ss_aw_diagonastic_exam_model->get_registration_before_last_seven_days_of_current_date($last_7_days);
		$diagnostic_quiz_taken[4] = $this->ss_aw_diagonastic_exam_model->get_total_childs_up_to_date($current_date);

		$diagnostic_quiz['emerging'] = 0;
		$diagnostic_quiz['consolidate'] = 0;
		$diagnostic_quiz['advance'] = 0;
		//get recommendation levels
		$result = $this->ss_aw_diagonastic_exam_model->get_daily_diagnostic_non_course_purchase_details($current_date);
		
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				//get diagnostic exam details
				$searchary = array();
				$searchary['ss_aw_diagonastic_child_id'] = $value->ss_aw_child_id;
				$resultary = array();
				$resultary = $this->ss_aw_diagonastic_exam_model->fetch_record_byparam($searchary);
				if (!empty($resultary)) {
					$exam_code = $resultary[0]['ss_aw_diagonastic_exam_code'];
					$searchary = array();
					$searchary['ss_aw_diagonastic_log_exam_code'] = $exam_code;
					$examresultary = array();
					$examresultary = $this->ss_aw_diagonastic_exam_log_model->fetch_record_byparam($searchary);

					$total_marks = $this->ss_aw_diagonastic_exam_log_model->asked_question_num_by_exam_code($exam_code);
					$obtain_marks = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);

					$resultcountary = array();
					foreach($examresultary as $examresult)
					{
						if($examresult['ss_aw_diagonastic_log_answer_status'] != 3)
						{
							$resultcountary[$examresult['ss_aw_diagonastic_log_level']]['total_ask'][] = $examresult['ss_aw_diagonastic_log_question_id'];
							if($examresult['ss_aw_diagonastic_log_answer_status'] == 1)
								$resultcountary[$examresult['ss_aw_diagonastic_log_level']]['right_ans'][] = $examresult['ss_aw_diagonastic_log_question_id'];
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

					if ($recomended_level == 'E') {
						$diagnostic_quiz['emerging'] = $diagnostic_quiz['emerging'] + 1;
					}
					elseif ($recomended_level == 'C') {
						$diagnostic_quiz['consolidate'] = $diagnostic_quiz['consolidate'] + 1;
					}
					else{
						$diagnostic_quiz['advance'] = $diagnostic_quiz['advance'] + 1;
					}
				}
			}
		}

		//end				

		$enrollment_emi = array();
		$enrollment_emi[0] = $this->ss_aw_child_course_model->get_registration_by_date($current_date, 1);
		$enrollment_emi[1] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_3_days, $current_date, 1);
		$enrollment_emi[2] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_7_days, $current_date, 1);
		$enrollment_emi[3] = $this->ss_aw_child_course_model->get_registration_before_last_seven_days_of_current_date($last_7_days, 1);
		$enrollment_emi[4] = $this->ss_aw_child_course_model->get_total_childs_up_to_date($current_date, 1);
		$enrollment_emi_course['emerging'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 1, 1);
		$enrollment_emi_course['consolidate'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 1, 2);
		$enrollment_emi_course['advance'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 1, 3);

		$enrollment_lumpsum = array();
		$enrollment_lumpsum[0] = $this->ss_aw_child_course_model->get_registration_by_date($current_date, 0);
		$enrollment_lumpsum[1] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_3_days, $current_date, 0);
		$enrollment_lumpsum[2] = $this->ss_aw_child_course_model->get_registration_by_date_range($last_7_days, $current_date, 0);
		$enrollment_lumpsum[3] = $this->ss_aw_child_course_model->get_registration_before_last_seven_days_of_current_date($last_7_days, 0);
		$enrollment_lumpsum[4] = $this->ss_aw_child_course_model->get_total_childs_up_to_date($current_date, 0);
		$enrollment_lumpsum_course['emerging'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 0, 1);
		$enrollment_lumpsum_course['consolidate'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 0, 2);
		$enrollment_lumpsum_course['advance'] = $this->ss_aw_child_course_model->get_registration_course_by_date($current_date, 0, 3);

		$data['parent_profile'] = $parent_profile;
		$data['child_profile'] = $child_profile;
		$data['enrollment_emi'] = $enrollment_emi;
		$data['enrollment_lumpsum'] = $enrollment_lumpsum;
		$data['current_date'] = $current_date;
		$data['diagnostic_quiz_taken'] = $diagnostic_quiz_taken;
		$data['diagnostic_quiz'] = $diagnostic_quiz;
		$data['enrollment_emi_course'] = $enrollment_emi_course;
		$data['enrollment_lumpsum_course'] = $enrollment_lumpsum_course;

		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MIS as of '.date('d/m/Y', strtotime($current_date)));
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Parent Profiles');
        $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Child Profiles');
        //$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Diagnostic Quizzes taken');
        $objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Enrolments - Emi');
        $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Enrolments - Lumpsum');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Today');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last 3 days');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last 7 days');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', '< 7 days');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Total');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Winners');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Champions');       
             
        // set Row
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', $parent_profile[0]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', $parent_profile[1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', $parent_profile[2]);
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', $parent_profile[3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', $parent_profile[4]);

        $objPHPExcel->getActiveSheet()->SetCellValue('B3', $child_profile[0]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C3', $child_profile[1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('D3', $child_profile[2]);
        $objPHPExcel->getActiveSheet()->SetCellValue('E3', $child_profile[3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('F3', $child_profile[4]);

        // $objPHPExcel->getActiveSheet()->SetCellValue('B4', $diagnostic_quiz_taken[0]);
        // $objPHPExcel->getActiveSheet()->SetCellValue('C4', $diagnostic_quiz_taken[1]);
        // $objPHPExcel->getActiveSheet()->SetCellValue('D4', $diagnostic_quiz_taken[2]);
        // $objPHPExcel->getActiveSheet()->SetCellValue('E4', $diagnostic_quiz_taken[3]);
        // $objPHPExcel->getActiveSheet()->SetCellValue('F4', $diagnostic_quiz_taken[4]);
        // $objPHPExcel->getActiveSheet()->SetCellValue('G4', $diagnostic_quiz['emerging'] + $diagnostic_quiz['consolidate']);
        // $objPHPExcel->getActiveSheet()->SetCellValue('H4', $diagnostic_quiz['advance']);

        $objPHPExcel->getActiveSheet()->SetCellValue('B4', $enrollment_emi[0]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C4', $enrollment_emi[1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('D4', $enrollment_emi[2]);
        $objPHPExcel->getActiveSheet()->SetCellValue('E4', $enrollment_emi[3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('F4', $enrollment_emi[4]);
        $objPHPExcel->getActiveSheet()->SetCellValue('G4', $enrollment_emi_course['emerging'] + $enrollment_emi_course['consolidate']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H4', $enrollment_emi_course['advance']);

        $objPHPExcel->getActiveSheet()->SetCellValue('B5', $enrollment_lumpsum[0]);
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', $enrollment_lumpsum[1]);
        $objPHPExcel->getActiveSheet()->SetCellValue('D5', $enrollment_lumpsum[2]);
        $objPHPExcel->getActiveSheet()->SetCellValue('E5', $enrollment_lumpsum[3]);
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', $enrollment_lumpsum[4]);
        $objPHPExcel->getActiveSheet()->SetCellValue('G5', $enrollment_lumpsum_course['emerging'] + $enrollment_lumpsum_course['consolidate']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H5', $enrollment_lumpsum_course['advance']);

        $filename = "daily-mis". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function lesson_completed_promotion(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Promotability Outcome";
		$current_date = date('Y-m-d');
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = date('m', strtotime($current_date,"-1 month"));
		$lesson4_promtional = array();
		$lesson4_promtional[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num($current_date, 4);
		$lesson4_promtional[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num($current_year, 4);
		$lesson4_promtional[2] = $this->ss_aw_promotion_model->get_promotion_num_by_month($last_month, 4);
		$lesson4_promtional[3] = $this->ss_aw_promotion_model->get_promotion_num_by_month($current_month, 4);
		$data['lesson4_promtional'] = $lesson4_promtional;
		$lesson5_promotional = array();
		$lesson5_promtional[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num($current_date, 5);
		$lesson5_promtional[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num($current_year, 5);
		$lesson5_promtional[2] = $this->ss_aw_promotion_model->get_promotion_num_by_month($last_month, 5);
		$lesson5_promtional[3] = $this->ss_aw_promotion_model->get_promotion_num_by_month($current_month, 5);
		$data['lesson5_promtional'] = $lesson5_promtional;
		$lesson6_promotional = array();
		$lesson6_promtional[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num($current_date, 6);
		$lesson6_promtional[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num($current_year, 6);
		$lesson6_promtional[2] = $this->ss_aw_promotion_model->get_promotion_num_by_month($last_month, 6);
		$lesson6_promtional[3] = $this->ss_aw_promotion_model->get_promotion_num_by_month($current_month, 6);
		$data['lesson6_promtional'] = $lesson6_promtional;
		$lesson4_parent_consent = array();
		$lesson4_parent_consent[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num_by_status($current_date, 4, 1);
		$lesson4_parent_consent[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num_by_status($current_year, 4, 1);
		$lesson4_parent_consent[2] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($last_month, 4, 1);
		$lesson4_parent_consent[3] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($current_month, 4, 1);
		$data['lesson4_parent_consent'] = $lesson4_parent_consent;
		$lesson5_parent_consent = array();
		$lesson5_parent_consent[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num_by_status($current_date, 5, 1);
		$lesson5_parent_consent[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num_by_status($current_year, 5, 1);
		$lesson5_parent_consent[2] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($last_month, 5, 1);
		$lesson5_parent_consent[3] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($current_month, 5, 1);
		$data['lesson5_parent_consent'] = $lesson5_parent_consent;
		$lesson6_parent_consent = array();
		$lesson6_parent_consent[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num_by_status($current_date, 6, 1);
		$lesson6_parent_consent[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num_by_status($current_year, 6, 1);
		$lesson6_parent_consent[2] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($last_month, 6, 1);
		$lesson6_parent_consent[3] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($current_month, 6, 1); 
		$data['lesson6_parent_consent'] = $lesson6_parent_consent;
		$lesson4_parent_declined = array();
		$lesson4_parent_declined[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num_by_status($current_date, 4, 2);
		$lesson4_parent_declined[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num_by_status($current_year, 4, 2);
		$lesson4_parent_declined[2] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($last_month, 4, 2);
		$lesson4_parent_declined[3] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($current_month, 4, 2);
		$data['lesson4_parent_declined'] = $lesson4_parent_declined;
		$lesson5_parent_declined = array();
		$lesson5_parent_declined[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num_by_status($current_date, 5, 2);
		$lesson5_parent_declined[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num_by_status($current_year, 5, 2);
		$lesson5_parent_declined[2] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($last_month, 5, 2);
		$lesson5_parent_declined[3] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($current_month, 5, 2);
		$data['lesson5_parent_declined'] = $lesson5_parent_declined;
		$lesson6_parent_declined = array();
		$lesson6_parent_declined[0] = $this->ss_aw_promotion_model->get_ptd_promotion_num_by_status($current_date, 6, 2);
		$lesson6_parent_declined[1] = $this->ss_aw_promotion_model->get_ytd_promotion_num_by_status($current_year, 6, 2);
		$lesson6_parent_declined[2] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($last_month, 6, 2);
		$lesson6_parent_declined[3] = $this->ss_aw_promotion_model->get_promotion_num_by_status_by_month($current_month, 6, 2);
		$data['lesson6_parent_declined'] = $lesson6_parent_declined;
		$lesson4_parent_expired = array();
		$lesson4_parent_expired[0] = $this->ss_aw_promotion_model->get_ptd_expired_promotion_num_by_status($current_date, 4);
		$lesson4_parent_expired[1] = $this->ss_aw_promotion_model->get_ytd_expired_promotion_num_by_status($current_year, 4);
		$lesson4_parent_expired[2] = $this->ss_aw_promotion_model->get_expired_promotion_num_by_status_by_month($last_month, 4);
		$lesson4_parent_expired[3] = $this->ss_aw_promotion_model->get_expired_promotion_num_by_status_by_month($current_month, 4);
		$data['lesson4_parent_expired'] = $lesson4_parent_expired;
		$lesson5_parent_expired = array();
		$lesson5_parent_expired[0] = $this->ss_aw_promotion_model->get_ptd_expired_promotion_num_by_status($current_date, 5);
		$lesson5_parent_expired[1] = $this->ss_aw_promotion_model->get_ytd_expired_promotion_num_by_status($current_year, 5);
		$lesson5_parent_expired[2] = $this->ss_aw_promotion_model->get_expired_promotion_num_by_status_by_month($last_month, 5);
		$lesson5_parent_expired[3] = $this->ss_aw_promotion_model->get_expired_promotion_num_by_status_by_month($current_month, 5);
		$data['lesson5_parent_expired'] = $lesson5_parent_expired;
		$lesson6_parent_expired = array();
		$lesson6_parent_expired[0] = $this->ss_aw_promotion_model->get_ptd_expired_promotion_num_by_status($current_date, 6);
		$lesson6_parent_expired[1] = $this->ss_aw_promotion_model->get_ytd_expired_promotion_num_by_status($current_year, 6);
		$lesson6_parent_expired[2] = $this->ss_aw_promotion_model->get_expired_promotion_num_by_status_by_month($last_month, 6);
		$lesson6_parent_expired[3] = $this->ss_aw_promotion_model->get_expired_promotion_num_by_status_by_month($current_month, 6);
		$data['lesson6_parent_expired'] = $lesson6_parent_expired;

		$this->loadView('admin/report/promotability_outcome', $headerdata, $data);	

	}

	public function email_log(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Email Log";
		$data = array();
		if ($this->input->post('search_date')) {
			$search_date = $this->input->post('search_date');
		}
		else{
			$search_date = date('Y-m-d');
		}
		$result = $this->ss_aw_advance_email_log_model->get_data($search_date);
		$data['search_date'] = $search_date;
		$this->session->set_userdata('email_log_search_date', $search_date);
		$data['result'] = $result;
		$this->loadView('admin/report/email_log', $headerdata, $data);
	}

	public function email_log_export(){
		$data = array();
		if ($this->session->userdata('email_log_search_date')) {
			$search_date = $this->session->userdata('email_log_search_date');
			$result = $this->ss_aw_advance_email_log_model->get_data($search_date);
		}
		else{
			$result = $this->ss_aw_advance_email_log_model->get_data();
		}
		
		// create file name
        $fileName = 'data-'.time().'.xlsx';  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Message ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Subject');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Email ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Status');       
        // set Row
        $rowCount = 2;
        foreach ($result as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->ss_aw_date ? date('d/m/Y', strtotime($value->ss_aw_date)) : "");
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_message_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->ss_aw_subject);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->ss_aw_email_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->ss_aw_status);
            $rowCount++;
        }
        $filename = "email-log". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function puzzle_report(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Email Log";
		$data = array();
		$quiz_report = $this->ss_aw_challange_model->get_report_details();
		$data['quiz_report'] = $quiz_report;
		$this->loadView('admin/report/quiz_challange_report', $headerdata, $data);
	}

	public function puzzle_log_export(){
		$data = array();
		$result = $this->ss_aw_challange_model->get_report_details();
		// create file name
        $fileName = 'data-'.time().'.xlsx';  
		// load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Puzzle Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Total Attempt');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Current');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Wrong');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Likes');       
        // set Row
        $rowCount = 2;
        foreach ($result as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->challange_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->total_attempt);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->correct);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->wrong);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->like_count);
            $rowCount++;
        }
        $filename = "puzzle-log". date("Y-m-d-H-i-s").".csv";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
		$objWriter->save('php://output');
	}

	public function lesson_wrong_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Incorrect Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$lesson_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('lesson_search_data');
				$question_details = $this->ss_aw_report_model->get_question_detail($question_id);
				$lesson_upload_id = $question_details[0]->ss_aw_lesson_record_id;
				$question_id = $question_details[0]->ss_aw_lession_id;
				$question = $question_details[0]->ss_aw_lesson_details;
				$question_preface = $question_details[0]->ss_aw_lesson_title;
				$correct_answer = $question_details[0]->ss_aw_lesson_answers;
				$question_topic = $question_details[0]->topic_title;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wrong_answers_child($searchdata, $child_id_ary, 1, $question_id);	
			}
		}
		$pagedata['lesson_upload_id'] = $lesson_upload_id;
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('lesson_search_data');
		$pagedata['page_type'] = 2;
		$this->loadView('admin/report/question_difficulty/lesson-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function lesson_wright_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "User list - Correct Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$lesson_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('lesson_search_data');
				$question_details = $this->ss_aw_report_model->get_question_detail($question_id);
				$lesson_upload_id = $question_details[0]->ss_aw_lesson_record_id;
				$question_id = $question_details[0]->ss_aw_lession_id;
				$question = $question_details[0]->ss_aw_lesson_details;
				$question_preface = $question_details[0]->ss_aw_lesson_title;
				$correct_answer = $question_details[0]->ss_aw_lesson_answers;
				$question_topic = $question_details[0]->topic_title;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wright_answers_child($searchdata, $child_id_ary, 1, $question_id);	
			}
		}
		$pagedata['lesson_upload_id'] = $lesson_upload_id;
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('lesson_search_data');
		$pagedata['page_type'] = 1;
		$this->loadView('admin/report/question_difficulty/lesson-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function assessment_wrong_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "User list - Incorrect Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$assessment_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('assessment_search_data');

				$question_details = $this->ss_aw_report_model->get_question_detail_assessment($question_id);
				$assessment_upload_id = $question_details[0]->ss_aw_uploaded_record_id;
				$question = $question_details[0]->ss_aw_question;
				$question_preface = $question_details[0]->ss_aw_question_preface;
				$correct_answer = $question_details[0]->ss_aw_answers;
				$question_topic = $question_details[0]->ss_aw_category;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wrong_answers_child($searchdata, $child_id_ary, 2, trim($question), $assessment_format, $question_id);	
			}
		}
		$pagedata['assessment_upload_id'] = $assessment_upload_id;
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('assessment_search_data');
		$pagedata['page_type'] = 2;
		$this->loadView('admin/report/question_difficulty/assessment-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function assessment_wright_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Correct Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$assessment_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('assessment_search_data');

				$question_details = $this->ss_aw_report_model->get_question_detail_assessment($question_id);
				$assessment_upload_id = $question_details[0]->ss_aw_uploaded_record_id;
				$question = $question_details[0]->ss_aw_question;
				$question_preface = $question_details[0]->ss_aw_question_preface;
				$correct_answer = $question_details[0]->ss_aw_answers;
				$question_topic = $question_details[0]->ss_aw_category;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wright_answers_child($searchdata, $child_id_ary, 2, trim($question), $assessment_format, $question_id);	
			}
		}
		$pagedata['assessment_upload_id'] = $assessment_upload_id;
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('assessment_search_data');
		$pagedata['page_type'] = 1;
		$this->loadView('admin/report/question_difficulty/assessment-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function diagnostic_wrong_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Incorrect Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$assessment_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('diagnostic_search_data');

				$question_details = $this->ss_aw_report_model->get_question_detail_assessment($question_id);
				$question = $question_details[0]->ss_aw_question;
				$question_preface = $question_details[0]->ss_aw_question_preface;
				$correct_answer = $question_details[0]->ss_aw_answers;
				$question_topic = $question_details[0]->ss_aw_category;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wrong_answers_child($searchdata, $child_id_ary, 3, trim($question), $assessment_format, $question_id);	
			}
		}
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('diagnostic_search_data');
		$pagedata['page_type'] = 2;
		$this->loadView('admin/report/question_difficulty/diagnostic-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function diagnostic_wright_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Correct Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$assessment_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('diagnostic_search_data');

				$question_details = $this->ss_aw_report_model->get_question_detail_assessment($question_id);
				$question = $question_details[0]->ss_aw_question;
				$question_preface = $question_details[0]->ss_aw_question_preface;
				$correct_answer = $question_details[0]->ss_aw_answers;
				$question_topic = $question_details[0]->ss_aw_category;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wright_answers_child($searchdata, $child_id_ary, 3, trim($question), $assessment_format, $question_id);	
			}
		}
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('diagnostic_search_data');
		$pagedata['page_type'] = 1;
		$this->loadView('admin/report/question_difficulty/diagnostic-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function readalong_wrong_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Incorrect Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$assessment_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('readalong_search_data');

				$question_details = $this->ss_aw_report_model->get_readalong_question_details($question_id);
				$readalong_upload_id = $question_details->ss_aw_readalong_upload_id;
				$question = $question_details->ss_aw_details;
				$question_preface = $question_details->ss_aw_question;
				$correct_answer = $question_details->ss_aw_answers;
				$question_topic = $question_details->ss_aw_title;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wrong_answers_child($searchdata, $child_id_ary, 4, "", "", $question_id);	
			}
		}
		$pagedata['readalong_upload_id'] = $readalong_upload_id;
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('readalong_search_data');
		$pagedata['page_type'] = 2;
		$this->loadView('admin/report/question_difficulty/readalong-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function readalong_wright_answer_childs_list(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Correct Answers";
		$urlStringAry = explode("@", base64_decode($this->uri->segment(3)));
		$student_level = $urlStringAry[0];
		$question_id = $urlStringAry[1];
		$assessment_format = $urlStringAry[2];
		$pageno = $urlStringAry[3] ? $urlStringAry[3] : 0;

		$pagedata['page_num'] = $page_num;
		if ($student_level) {
			$child_id_ary = array();
			$students = $this->ss_aw_child_course_model->getstuentsbycorsetype($student_level);
			$child_id_ary = array();
			if (!empty($students->child_id)) {
				$child_id_ary = explode(",", $students->child_id);
			}

			if (!empty($child_id_ary)) {
				$searchdata = array();
				$searchdata = $this->session->userdata('readalong_search_data');

				$question_details = $this->ss_aw_report_model->get_readalong_question_details($question_id);
				$readalong_upload_id = $question_details->ss_aw_readalong_upload_id;
				$question = $question_details->ss_aw_details;
				$question_preface = $question_details->ss_aw_question;
				$correct_answer = $question_details->ss_aw_answers;
				$question_topic = $question_details->ss_aw_title;
				$wrong_answer_child_list = $this->ss_aw_report_model->get_all_wright_answers_child($searchdata, $child_id_ary, 4, "", "", $question_id);	
			}
		}
		$pagedata['readalong_upload_id'] = $readalong_upload_id;
		$pagedata['question_details'] = $question;
		$pagedata['question_preface'] = $question_preface;
		$pagedata['wrong_answer_child_list'] = $wrong_answer_child_list;
		$pagedata['correct_answer'] = $correct_answer;
		$pagedata['question_topic'] = $question_topic;
		$pagedata['searchdata'] = $this->session->userdata('readalong_search_data');
		$pagedata['page_type'] = 1;
		$this->loadView('admin/report/question_difficulty/readalong-incorrect-answer-childs', $headerdata, $pagedata);
	}

	public function hyatt_users_lessons(){
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_schedule_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_ans_model');
		$this->load->model('ss_aw_last_readalong_model');
		$this->load->model('ss_aw_store_readalong_page_model');

		$users = $this->ss_aw_report_model->hyatt_details();

		$diagnostic_obtain_marks = array();
		$diagnostic_exam_complete = array();
		$lesson_score = array();
		$assessment_score = array();
		$assessment_id_ary = array();
		//get all lesson topic
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'A,M';
		$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		$topicAry = array();
		if (!empty($topic_listary)) {
			foreach ($topic_listary as $key => $value) {
				$topicAry[] = $value->ss_aw_section_id;
			}
		}
		$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

		$result = array();
		if (!empty($users)) {
			foreach ($users as $hyatt_user_count => $hyatt_user) {
				$result[$hyatt_user_count]['name'] = $hyatt_user->name;
				$result[$hyatt_user_count]['email'] = $hyatt_user->email;
				$result[$hyatt_user_count]['property'] = $hyatt_user->property;
				$result[$hyatt_user_count]['location'] = $hyatt_user->city;
				$child_id = $hyatt_user->child_id;
				$diagnostic_exam_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
				if (!empty($diagnostic_exam_details)) {
					$exam_code = $diagnostic_exam_details->ss_aw_diagonastic_exam_code;
					$diagnostic_obtain_marks[$child_id] = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					$diagnostic_exam_complete[$child_id] = date('d/m/Y', strtotime($diagnostic_exam_details->ss_aw_diagonastic_exam_date));
					$result[$hyatt_user_count]['diagnostic_score'] = $diagnostic_obtain_marks[$child_id] ."/". DIAGNOSTIC_QUESTION_NUM;
					$result[$hyatt_user_count]['diagnostic_complete'] = date('d/m/Y', strtotime($diagnostic_exam_details->ss_aw_diagonastic_exam_date));	
				}
				
				//lesson and assessment topical details
				$completed_topic_details = $this->ss_aw_child_last_lesson_model->getallcompletelessonby_child($child_id);
				
				if (!empty($completed_topic_details)) {
					foreach ($completed_topic_details as $key => $value) {
						$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $value->ss_aw_lesson_id);
						$lesson_asked = 0;
						$lesson_correct = 0;
						if (!empty($lesson_score_details)) {
							$lesson_asked = $lesson_score_details[0]->total_question;
							$lesson_correct = $lesson_score_details[0]->wright_answers;
						}
						$lesson_score[$child_id][$value->ss_aw_lesson_id]['asked'] = $lesson_asked;
						$lesson_score[$child_id][$value->ss_aw_lesson_id]['correct'] = $lesson_correct;
						if (!empty($value->ss_aw_last_lesson_modified_date)) {
							$lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete'] = date('d/m/Y', strtotime($value->ss_aw_last_lesson_modified_date));
						}
						else{
							$lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete'] = "NA";
						}

						//assessment section
						$assessment_id = "";
						$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
						if (!empty($topical_assessment_start_details)) {
							if (!empty($topical_assessment_start_details)) {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = date('d/m/Y', strtotime($topical_assessment_start_details[0]->ss_aw_created_date));
							} else {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = "NA";
							}

							$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
						}
						else{
							$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
							if (!empty($comprehension_assessment_start_details)) {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = date('d/m/Y', strtotime($comprehension_assessment_start_details[0]->ss_aw_created_at));
							} else {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = "NA";
							}

							$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
						}
						$assessment_id_ary[$value->ss_aw_lesson_id] = $assessment_id;
						$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
						$assessment_asked = 0;
						$assessment_correct = 0;
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed'] = "NA";
						$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
						if (!empty($assessment_completetion_details)) {
							$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed'] = date('d/m/Y', strtotime($assessment_completetion_details[0]->ss_aw_create_date));
						}
						if (!empty($assessment_score_details)) {
							$assessment_asked = $assessment_score_details[0]->total_question;
							$assessment_correct = $assessment_score_details[0]->wright_answers;
						}
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['asked'] = $assessment_asked;
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['correct'] = $assessment_correct;

						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['lesson_score'] = $lesson_score[$child_id][$value->ss_aw_lesson_id]['correct'] ."/".$lesson_score[$child_id][$value->ss_aw_lesson_id]['asked'];
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['lesson_complete'] = $lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete']; 
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['assessment_score'] = $assessment_score[$child_id][$value->ss_aw_lesson_id]['correct'] ."/".$assessment_score[$child_id][$value->ss_aw_lesson_id]['asked']; 
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['assessment_complete'] = $assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed']; 
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
						$readalong_score[$child_id][$value['ss_aw_readalong_id']]['asked'] = $readalong_asked;
						$readalong_score[$child_id][$value['ss_aw_readalong_id']]['correct'] = $readalong_correct;

						$result[$hyatt_user_count]['readalong'][$value['ss_aw_title']]['readalong_score'] = $readalong_score[$child_id][$value['ss_aw_readalong_id']]['correct']."/".$readalong_score[$child_id][$value['ss_aw_readalong_id']]['asked'];
						$result[$hyatt_user_count]['readalong'][$value['ss_aw_title']]['readalong_complete'] = $readalong_finish['complete_date'][$value['ss_aw_readalong_id']];
					}
				}
				//end
			}
		}

		// echo "<pre>";
		// print_r($lesson_score);
		// die();
		// create file name
	        $fileName = 'data-'.time().'.xlsx';  
			// load excel library
	        $this->load->library('excel');
	        $objPHPExcel = new PHPExcel();
	        $objPHPExcel->setActiveSheetIndex(0);
	        // set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Property');
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Location');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Diagnostic Score');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Diagnostic Exam Complete');
	        //$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ddd');
	        
	        if (!empty($topical_lessons)) {
	        	$column = 'G';
	        	foreach ($topical_lessons as $key => $value) {
					$objPHPExcel->getActiveSheet()->SetCellValue($column.'1', $value['ss_aw_lesson_topic']);
					$column++;	        		   	
	        	}    
	        }       
	        //set Row
	        $rowCount = 2;
	        foreach ($users as $value) {
	        	$child_id = $value->child_id;
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->email);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->property);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->city);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $diagnostic_obtain_marks[$value->child_id] ? $diagnostic_obtain_marks[$value->child_id] : "NA");
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $diagnostic_exam_complete[$value->child_id] ? $diagnostic_exam_complete[$value->child_id] : "NA");

	            if (!empty($topical_lessons)) {
		        	$column = 'G';
		        	foreach ($topical_lessons as $topics) {
		        		if (!empty($lesson_score[$child_id][$topics['ss_aw_lession_id']]['asked'])) {
		        			$score = $lesson_score[$child_id][$topics['ss_aw_lession_id']]['correct']."/".$lesson_score[$child_id][$topics['ss_aw_lession_id']]['asked'];
		        			$complete = $lesson_score[$child_id][$topics['ss_aw_lession_id']]['exam_complete'];
		        			$objPHPExcel->getActiveSheet()->SetCellValue($column.$rowCount, $score.",".$complete);	
		        		}
						$column++;	        		   	
		        	}    
		        }
	            $rowCount++;
	        }
	  
	        $filename = "lesson-log". date("Y-m-d-H-i-s").".csv";
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
			$objWriter->save('php://output');
	}

	public function hyatt_users_assessments(){
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_schedule_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_ans_model');
		$this->load->model('ss_aw_last_readalong_model');
		$this->load->model('ss_aw_store_readalong_page_model');

		$users = $this->ss_aw_report_model->hyatt_details();

		$diagnostic_obtain_marks = array();
		$diagnostic_exam_complete = array();
		$lesson_score = array();
		$assessment_score = array();
		$assessment_id_ary = array();
		//get all lesson topic
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'A,M';
		$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		$topicAry = array();
		if (!empty($topic_listary)) {
			foreach ($topic_listary as $key => $value) {
				$topicAry[] = $value->ss_aw_section_id;
			}
		}
		$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

		$result = array();
		if (!empty($users)) {
			foreach ($users as $hyatt_user_count => $hyatt_user) {
				$result[$hyatt_user_count]['name'] = $hyatt_user->name;
				$result[$hyatt_user_count]['email'] = $hyatt_user->email;
				$result[$hyatt_user_count]['property'] = $hyatt_user->property;
				$result[$hyatt_user_count]['location'] = $hyatt_user->city;
				$child_id = $hyatt_user->child_id;
				$diagnostic_exam_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
				if (!empty($diagnostic_exam_details)) {
					$exam_code = $diagnostic_exam_details->ss_aw_diagonastic_exam_code;
					$diagnostic_obtain_marks[$child_id] = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					$diagnostic_exam_complete[$child_id] = date('d/m/Y', strtotime($diagnostic_exam_details->ss_aw_diagonastic_exam_date));
					$result[$hyatt_user_count]['diagnostic_score'] = $diagnostic_obtain_marks[$child_id] ."/". DIAGNOSTIC_QUESTION_NUM;
					$result[$hyatt_user_count]['diagnostic_complete'] = date('d/m/Y', strtotime($diagnostic_exam_details->ss_aw_diagonastic_exam_date));	
				}
				
				//lesson and assessment topical details
				$completed_topic_details = $this->ss_aw_child_last_lesson_model->getallcompletelessonby_child($child_id);
				
				if (!empty($completed_topic_details)) {
					foreach ($completed_topic_details as $key => $value) {
						$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $value->ss_aw_lesson_id);
						$lesson_asked = 0;
						$lesson_correct = 0;
						if (!empty($lesson_score_details)) {
							$lesson_asked = $lesson_score_details[0]->total_question;
							$lesson_correct = $lesson_score_details[0]->wright_answers;
						}
						$lesson_score[$child_id][$value->ss_aw_lesson_id]['asked'] = $lesson_asked;
						$lesson_score[$child_id][$value->ss_aw_lesson_id]['correct'] = $lesson_correct;
						if (!empty($value->ss_aw_last_lesson_modified_date)) {
							$lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete'] = date('d/m/Y', strtotime($value->ss_aw_last_lesson_modified_date));
						}
						else{
							$lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete'] = "NA";
						}

						//assessment section
						$assessment_id = "";
						$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
						if (!empty($topical_assessment_start_details)) {
							if (!empty($topical_assessment_start_details)) {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = date('d/m/Y', strtotime($topical_assessment_start_details[0]->ss_aw_created_date));
							} else {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = "NA";
							}

							$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
						}
						else{
							$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
							if (!empty($comprehension_assessment_start_details)) {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = date('d/m/Y', strtotime($comprehension_assessment_start_details[0]->ss_aw_created_at));
							} else {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = "NA";
							}

							$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
						}
						$assessment_id_ary[$value->ss_aw_lesson_id] = $assessment_id;
						$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
						$assessment_asked = 0;
						$assessment_correct = 0;
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed'] = "NA";
						$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
						if (!empty($assessment_completetion_details)) {
							$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed'] = date('d/m/Y', strtotime($assessment_completetion_details[0]->ss_aw_create_date));
						}
						if (!empty($assessment_score_details)) {
							$assessment_asked = $assessment_score_details[0]->total_question;
							$assessment_correct = $assessment_score_details[0]->wright_answers;
						}
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['asked'] = $assessment_asked;
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['correct'] = $assessment_correct;

						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['lesson_score'] = $lesson_score[$child_id][$value->ss_aw_lesson_id]['correct'] ."/".$lesson_score[$child_id][$value->ss_aw_lesson_id]['asked'];
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['lesson_complete'] = $lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete']; 
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['assessment_score'] = $assessment_score[$child_id][$value->ss_aw_lesson_id]['correct'] ."/".$assessment_score[$child_id][$value->ss_aw_lesson_id]['asked']; 
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['assessment_complete'] = $assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed']; 
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
						$readalong_score[$child_id][$value['ss_aw_readalong_id']]['asked'] = $readalong_asked;
						$readalong_score[$child_id][$value['ss_aw_readalong_id']]['correct'] = $readalong_correct;

						$result[$hyatt_user_count]['readalong'][$value['ss_aw_title']]['readalong_score'] = $readalong_score[$child_id][$value['ss_aw_readalong_id']]['correct']."/".$readalong_score[$child_id][$value['ss_aw_readalong_id']]['asked'];
						$result[$hyatt_user_count]['readalong'][$value['ss_aw_title']]['readalong_complete'] = $readalong_finish['complete_date'][$value['ss_aw_readalong_id']];
					}
				}
				//end
			}
		}

		// echo "<pre>";
		// print_r($lesson_score);
		// die();
		// create file name
	        $fileName = 'data-'.time().'.xlsx';  
			// load excel library
	        $this->load->library('excel');
	        $objPHPExcel = new PHPExcel();
	        $objPHPExcel->setActiveSheetIndex(0);
	        // set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Property');
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Location');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Diagnostic Score');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Diagnostic Exam Complete');
	        //$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ddd');
	        
	        if (!empty($topical_lessons)) {
	        	$column = 'G';
	        	foreach ($topical_lessons as $key => $value) {
					$objPHPExcel->getActiveSheet()->SetCellValue($column.'1', $value['ss_aw_lesson_topic']);
					$column++;	        		   	
	        	}    
	        }       
	        //set Row
	        $rowCount = 2;
	        foreach ($users as $value) {
	        	$child_id = $value->child_id;
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->email);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->property);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->city);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $diagnostic_obtain_marks[$value->child_id] ? $diagnostic_obtain_marks[$value->child_id] : "NA");
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $diagnostic_exam_complete[$value->child_id] ? $diagnostic_exam_complete[$value->child_id] : "NA");

	            if (!empty($topical_lessons)) {
		        	$column = 'G';
		        	foreach ($topical_lessons as $topics) {
		        		if (!empty($assessment_score[$child_id][$topics['ss_aw_lession_id']]['asked'])) {
		        			$score = $assessment_score[$child_id][$topics['ss_aw_lession_id']]['correct']."/".$assessment_score[$child_id][$topics['ss_aw_lession_id']]['asked'];
		        			$complete = $assessment_score[$child_id][$topics['ss_aw_lession_id']]['exam_completed'];
		        			$objPHPExcel->getActiveSheet()->SetCellValue($column.$rowCount, $score.",".$complete);	
		        		}
						$column++;	        		   	
		        	}    
		        }
	            $rowCount++;
	        }
	  
	        $filename = "assessment-log". date("Y-m-d-H-i-s").".csv";
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
			$objWriter->save('php://output');
	}

	public function hyatt_users_readalongs(){
		$this->load->model('ss_aw_child_last_lesson_model');
		$this->load->model('ss_aw_lesson_score_model');
		$this->load->model('ss_aw_assesment_questions_asked_model');
		$this->load->model('ss_aw_assesment_multiple_question_asked_model');
		$this->load->model('ss_aw_assessment_score_model');
		$this->load->model('ss_aw_assessment_exam_completed_model');
		$this->load->model('ss_aw_schedule_readalong_model');
		$this->load->model('ss_aw_readalong_quiz_ans_model');
		$this->load->model('ss_aw_last_readalong_model');
		$this->load->model('ss_aw_store_readalong_page_model');

		$users = $this->ss_aw_report_model->hyatt_details();

		$diagnostic_obtain_marks = array();
		$diagnostic_exam_complete = array();
		$lesson_score = array();
		$assessment_score = array();
		$assessment_id_ary = array();
		//get all lesson topic
		$search_data = array();
		$search_data['ss_aw_expertise_level'] = 'A,M';
		$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
		$topicAry = array();
		if (!empty($topic_listary)) {
			foreach ($topic_listary as $key => $value) {
				$topicAry[] = $value->ss_aw_section_id;
			}
		}
		$topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($topicAry);

		$result = array();
		if (!empty($users)) {
			foreach ($users as $hyatt_user_count => $hyatt_user) {
				$result[$hyatt_user_count]['name'] = $hyatt_user->name;
				$result[$hyatt_user_count]['email'] = $hyatt_user->email;
				$result[$hyatt_user_count]['property'] = $hyatt_user->property;
				$result[$hyatt_user_count]['location'] = $hyatt_user->city;
				$child_id = $hyatt_user->child_id;
				$diagnostic_exam_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
				if (!empty($diagnostic_exam_details)) {
					$exam_code = $diagnostic_exam_details->ss_aw_diagonastic_exam_code;
					$diagnostic_obtain_marks[$child_id] = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
					$diagnostic_exam_complete[$child_id] = date('d/m/Y', strtotime($diagnostic_exam_details->ss_aw_diagonastic_exam_date));
					$result[$hyatt_user_count]['diagnostic_score'] = $diagnostic_obtain_marks[$child_id] ."/". DIAGNOSTIC_QUESTION_NUM;
					$result[$hyatt_user_count]['diagnostic_complete'] = date('d/m/Y', strtotime($diagnostic_exam_details->ss_aw_diagonastic_exam_date));	
				}
				
				//lesson and assessment topical details
				$completed_topic_details = $this->ss_aw_child_last_lesson_model->getallcompletelessonby_child($child_id);
				
				if (!empty($completed_topic_details)) {
					foreach ($completed_topic_details as $key => $value) {
						$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $value->ss_aw_lesson_id);
						$lesson_asked = 0;
						$lesson_correct = 0;
						if (!empty($lesson_score_details)) {
							$lesson_asked = $lesson_score_details[0]->total_question;
							$lesson_correct = $lesson_score_details[0]->wright_answers;
						}
						$lesson_score[$child_id][$value->ss_aw_lesson_id]['asked'] = $lesson_asked;
						$lesson_score[$child_id][$value->ss_aw_lesson_id]['correct'] = $lesson_correct;
						if (!empty($value->ss_aw_last_lesson_modified_date)) {
							$lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete'] = date('d/m/Y', strtotime($value->ss_aw_last_lesson_modified_date));
						}
						else{
							$lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete'] = "NA";
						}

						//assessment section
						$assessment_id = "";
						$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
						if (!empty($topical_assessment_start_details)) {
							if (!empty($topical_assessment_start_details)) {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = date('d/m/Y', strtotime($topical_assessment_start_details[0]->ss_aw_created_date));
							} else {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = "NA";
							}

							$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
						}
						else{
							$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
							if (!empty($comprehension_assessment_start_details)) {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = date('d/m/Y', strtotime($comprehension_assessment_start_details[0]->ss_aw_created_at));
							} else {
								$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_start'] = "NA";
							}

							$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
						}
						$assessment_id_ary[$value->ss_aw_lesson_id] = $assessment_id;
						$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
						$assessment_asked = 0;
						$assessment_correct = 0;
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed'] = "NA";
						$assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
						if (!empty($assessment_completetion_details)) {
							$assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed'] = date('d/m/Y', strtotime($assessment_completetion_details[0]->ss_aw_create_date));
						}
						if (!empty($assessment_score_details)) {
							$assessment_asked = $assessment_score_details[0]->total_question;
							$assessment_correct = $assessment_score_details[0]->wright_answers;
						}
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['asked'] = $assessment_asked;
						$assessment_score[$child_id][$value->ss_aw_lesson_id]['correct'] = $assessment_correct;

						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['lesson_score'] = $lesson_score[$child_id][$value->ss_aw_lesson_id]['correct'] ."/".$lesson_score[$child_id][$value->ss_aw_lesson_id]['asked'];
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['lesson_complete'] = $lesson_score[$child_id][$value->ss_aw_lesson_id]['exam_complete']; 
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['assessment_score'] = $assessment_score[$child_id][$value->ss_aw_lesson_id]['correct'] ."/".$assessment_score[$child_id][$value->ss_aw_lesson_id]['asked']; 
						$result[$hyatt_user_count]['topics'][$value->ss_aw_lesson_topic]['assessment_complete'] = $assessment_score[$child_id][$value->ss_aw_lesson_id]['exam_completed']; 
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

						$readalong_finish[$child_id]['start_date'][$value['ss_aw_readalong_id']] = "NA";
						$check_store_index = $this->ss_aw_store_readalong_page_model->get_first_start_details($child_id, $value['ss_aw_readalong_id']);
						if (!empty($check_store_index)) {
							$readalong_finish[$child_id]['start_date'][$value['ss_aw_readalong_id']] = date('d/m/Y', strtotime($value['ss_aw_create_date']));
						}
						$check_finish = $this->ss_aw_last_readalong_model->check_readalong_completion($value['ss_aw_readalong_id'], $child_id);
						$readalong_correct = 0;
						$readalong_asked = 0;
						if (!empty($check_finish)) {
							$readalong_finish[$child_id]['complete_date'][$value['ss_aw_readalong_id']] = date('d/m/Y', strtotime($check_finish[0]->ss_aw_create_date));
							$readalong_asked_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id']));
							$readalong_asked = count($readalong_asked_questions);
							$readalong_correct_questions = $this->ss_aw_readalong_quiz_ans_model->search_data_by_param(array('ss_aw_child_id' => $child_id, 'ss_aw_readalong_id' => $value['ss_aw_readalong_id'], 'ss_aw_quiz_right_wrong' => 1));
							$readalong_correct = count($readalong_correct_questions);
						} else {
							$readalong_finish[$child_id]['complete_date'][$value['ss_aw_readalong_id']] = "NA";
						}
						$readalong_score[$child_id][$value['ss_aw_readalong_id']]['asked'] = $readalong_asked;
						$readalong_score[$child_id][$value['ss_aw_readalong_id']]['correct'] = $readalong_correct;

						$result[$hyatt_user_count]['readalong'][$value['ss_aw_title']]['readalong_score'] = $readalong_score[$child_id][$value['ss_aw_readalong_id']]['correct']."/".$readalong_score[$child_id][$value['ss_aw_readalong_id']]['asked'];
						$result[$hyatt_user_count]['readalong'][$value['ss_aw_title']]['readalong_complete'] = $readalong_finish['complete_date'][$value['ss_aw_readalong_id']];
					}
				}
				//end
			}
		}

		$searchary['ss_aw_level'] = 'A';
		$readalongs = $this->ss_aw_readalongs_upload_model->fetch_by_params($searchary);
		// echo "<pre>";
		// print_r($lesson_score);
		// die();
		// create file name
	        $fileName = 'data-'.time().'.xlsx';  
			// load excel library
	        $this->load->library('excel');
	        $objPHPExcel = new PHPExcel();
	        $objPHPExcel->setActiveSheetIndex(0);
	        // set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Property');
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Location');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Diagnostic Score');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Diagnostic Exam Complete');
	        //$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ddd');
	        
	        if (!empty($readalongs)) {
	        	$column = 'G';
	        	foreach ($readalongs as $key => $value) {
					$objPHPExcel->getActiveSheet()->SetCellValue($column.'1', $value['ss_aw_title']);
					$column++;	        		   	
	        	}    
	        }       
	        //set Row
	        $rowCount = 2;
	        foreach ($users as $value) {
	        	$child_id = $value->child_id;
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->email);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->property);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->city);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $diagnostic_obtain_marks[$value->child_id] ? $diagnostic_obtain_marks[$value->child_id] : "NA");
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $diagnostic_exam_complete[$value->child_id] ? $diagnostic_exam_complete[$value->child_id] : "NA");

	            if (!empty($readalongs)) {
		        	$column = 'G';
		        	foreach ($readalongs as $topics) {
		        		if (!empty($readalong_score[$child_id][$topics['ss_aw_id']]['asked'])) {
		        			$score = $readalong_score[$child_id][$topics['ss_aw_id']]['correct']."/".$readalong_score[$child_id][$topics['ss_aw_id']]['asked'];
		        			$complete = $readalong_finish[$child_id]['complete_date'][$topics['ss_aw_id']];
		        			$objPHPExcel->getActiveSheet()->SetCellValue($column.$rowCount, $score.",".$complete);	
		        		}
						$column++;	        		   	
		        	}    
		        }
	            $rowCount++;
	        }
	  
	        $filename = "readalong-log". date("Y-m-d-H-i-s").".csv";
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
			$objWriter->save('php://output');
	}

	public function loadView($view_name, $headerdata = array(), $pagedata = array()){
		$this->load->view('admin/header',$headerdata);
		$this->load->view($view_name, $pagedata);
		$this->load->view('admin/bottombar');
		$this->load->view('admin/footer');
	}
}