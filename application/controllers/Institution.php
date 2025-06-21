<?php

/**
 * 
 */


class Institution extends CI_Controller
{
    protected $courseData;
    function __construct()
    {
        parent::__construct();
        $this->courseData = $this->session->userdata("course_type");
        $this->load->model('ss_aw_adminmenus_model');
        $this->load->model('ss_aw_childs_model');
        $this->load->model('ss_aw_parents_model');
        $this->load->model('ss_aw_institutions_model');
        $this->load->helper('custom_helper');
        $this->load->model('ss_aw_diagonastic_exam_log_model');
        $this->load->model('ss_aw_diagnonstic_questions_asked_model');
        $this->load->model('ss_aw_diagonastic_exam_model');
        $this->load->model('ss_aw_last_readalong_model');
        $this->load->model('ss_aw_assessment_exam_completed_model');
        $this->load->model('ss_aw_child_last_lesson_model');
        $this->load->model('ss_aw_schools_model');
        $this->load->model('ss_aw_childs_temp_model');
        $this->load->model('ss_aw_institution_student_upload_model');
        $this->load->model('ss_aw_coupons_model');
        $this->load->model('ss_aw_institution_payment_details_model');
        $this->load->model('ss_aw_courses_model');
        $this->load->model('ss_aw_payment_details_model');
        $this->load->model('ss_aw_purchase_courses_model');
        $this->load->model('ss_aw_child_course_model');
        $this->load->model('ss_aw_reporting_collection_model');
        $this->load->model('ss_aw_reporting_revenue_model');
        $this->load->model('ss_aw_currencies_model');
        $this->load->model('ss_aw_child_login_model');
        $this->load->model('ss_aw_schedule_readalong_model');
        $this->load->model('ss_aw_lesson_score_model');
        $this->load->model('ss_aw_assesment_questions_asked_model');
        $this->load->model('ss_aw_assesment_multiple_question_asked_model');
        $this->load->model('ss_aw_assessment_score_model');
        $this->load->model('ss_aw_store_readalong_page_model');
        $this->load->model('ss_aw_readalong_quiz_ans_model');
        $this->load->model('ss_aw_assisment_diagnostic_model');
        $this->load->model('ss_aw_lesson_quiz_ans_model');
        $this->load->model('ss_aw_assesment_uploaded_model');
        $this->load->model('ss_aw_assessment_exam_log_model');
        $this->load->model('ss_aw_assesment_multiple_question_answer_model');
        $this->load->model('ss_aw_readalongs_upload_model');
        $this->load->model('ss_aw_email_que_model');
        $this->load->model('ss_aw_sections_topics_model');
        $this->load->model('ss_aw_lessons_uploaded_model');
        $this->load->model('ss_aw_readalong_restriction_model');
        $this->load->model('ss_aw_diagnostic_complete_log_model');
        $this->load->model('ss_aw_topics_complete_log_model');
        $this->load->model('module_wise_performance_model');
    }

    public function checklogin()
    {
        if (empty($this->session->userdata('id'))) {
            $this->session->set_flashdata('error', 'First login to access any page.');
            redirect('admin/index');
        } else {
            $parent_id = $this->session->userdata('id');
            $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
            if (!empty($institution_admin_details)) {
                $institution_id = $institution_admin_details[0]->ss_aw_institution;
                $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
                if ($institution_details->ss_aw_status == 0) {
                    $this->session->set_flashdata('error', 'First login to access any page.');
                    redirect('admin/index');
                }
            }
            $headerdata = array();
            $headerdata['profile_name'] = $this->session->userdata('fullname');
            $headerdata['profile_pic'] = $this->session->userdata('profile_pic');
            $headerdata['user_email'] = $this->session->userdata('user_email');

            $searchary = array();
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

    public function manage_users()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Manage Users";
        $data = array();

        if ($this->courseData == 'diagnostic') {
            redirect('diagnostic_institution/manage_users');
        } else {
            $institution_admin_id = $this->session->userdata('id');
            $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
            $institution_id = $institute_admin_details[0]->ss_aw_institution;
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
            $total_record = $this->ss_aw_childs_model->total_winner_users($institution_users_id, $search_data, 1);
            $redirect_to = base_url() . 'institution/manage_users';
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
            $result = $this->ss_aw_childs_model->get_users_by_parents_ary($institution_users_id, $config['per_page'], $page, $search_data, 1);
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
                        $assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenumbychild($value->ss_aw_child_id);

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

            $data['child_details'] = $result;
            $data['lessoncount'] = $lessoncount;
            $data['assessmentcount'] = $assessmentcount;
            $data['readalongcount'] = $readalongcount;
            $data['diagnostictotalquestion'] = $diagnostictotalquestion;
            $data['diagnosticcorrectquestion'] = $diagnosticcorrectquestion;
            $data['course_details'] = @$course_details;
            $data['diagnosticexamdate'] = $diagnosticexamdate;
            $data['course_type'] = 1;
            $this->loadView('institution/manageinstitutionsusers', $headerdata, $data);
        }
    }

    public function add_institution_single_student()
    {
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $code_check = $this->ss_aw_childs_model->child_code_check();
            if (isset($code_check)) {
                $random_code = $code_check->ss_aw_child_code + 1;
            } else {
                $random_code = 10000001;
            }
            $institution_admin_id = $this->session->userdata('id');
            $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
            $institution_id = $institution_admin_details[0]->ss_aw_institution;
            $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
            if ($postdata['program_type'] == 1) {
                $check_in_parent = $this->ss_aw_parents_model->check_in_parent($parent_id, trim($postdata['email']));
                $check_in_child = $this->ss_aw_childs_model->check_in_child($parent_id, trim($postdata['email']));
                if ($check_in_parent > 0 || $check_in_child > 0) {
                    $this->session->set_flashdata('error', 'Sorry! this email is already exist.');
                    redirect('institution/manage_users');
                } else {
                    if (empty($postdata['email'])) {
                        $postdata['email'] = $this->session->userdata('user_email');
                    }
                    $data = array(
                        'ss_aw_child_username' => $postdata['userid'],
                        'ss_aw_child_code' => $random_code,
                        'ss_aw_parent_id' => $institution_admin_id,
                        'ss_aw_child_nick_name' => $postdata['firstname'] . " " . $postdata['lastname'],
                        'ss_aw_child_first_name' => $postdata['firstname'],
                        'ss_aw_child_last_name' => $postdata['lastname'],
                        'ss_aw_child_gender' => $postdata['rad_gender'],
                        'ss_aw_child_schoolname' => $institution_details->ss_aw_name,
                        'ss_aw_child_dob' => $postdata['date_of_birth'],
                        'ss_aw_child_age' => calculate_age($postdata['date_of_birth']),
                        'ss_aw_child_email' => $postdata['email'],
                        'ss_aw_child_password' => @$this->bcrypt->hash_password($postdata['password']),
                        'ss_aw_is_institute' => 1
                    );
                    $response = $this->ss_aw_childs_model->add_child($data);
                }
            } else {
                $check_in_parent = $this->ss_aw_parents_model->check_in_parent($parent_id, trim($postdata['email']));
                $check_in_child = $this->ss_aw_childs_model->check_in_child($parent_id, trim($postdata['email']));
                if ($check_in_parent > 0 || $check_in_child > 0) {
                    $this->session->set_flashdata('error', 'Sorry! this email is already exist.');
                    redirect('institution/manage_users');
                }

                $data = array(
                    'ss_aw_parent_full_name' => $postdata['firstname'] . " " . $postdata['lastname'],
                    'ss_aw_user_type' => 4,
                    'ss_aw_parent_email' => $postdata['email'],
                    'ss_aw_parent_password' => @$this->bcrypt->hash_password($postdata['password']),
                    'ss_aw_parent_address' => $institution_details->ss_aw_address,
                    'ss_aw_parent_city' => $institution_details->ss_aw_city,
                    'ss_aw_parent_state' => $institution_details->state_name,
                    'ss_aw_parent_pincode' => $institution_details->ss_aw_pincode,
                    'ss_aw_parent_country' => $institution_details->country_name,
                    'ss_aw_institution' => $institution_details->ss_aw_id
                );
                //add data to parent table
                $parent_id = $this->ss_aw_parents_model->data_insert($data);
                if ($parent_id) {
                    $email_template = getemailandpushnotification(61, 1);
                    if (!empty($email_template)) {
                        $body = $email_template['body'];
                        $body = str_ireplace("[@@password@@]", $postdata['password'], $body);
                        $body = str_ireplace("[@@email@@]", $postdata['email'], $body);
                        $body = str_ireplace("[@@username@@]", $postdata['firstname'] . " " . $postdata['lastname'], $body);
                        emailnotification($postdata['email'], 'Welcome to team. Thank you for registering with us.', $body);

                        //add as alert
                        $child_data = array();
                        $child_data['ss_aw_child_code'] = $random_code;
                        $child_data['ss_aw_parent_id'] = $parent_id;
                        $child_data['ss_aw_child_nick_name'] = $postdata['firstname'] . " " . $postdata['lastname'];
                        $current_date = date('Y-m-d');
                        $child_data['ss_aw_child_dob'] = date('Y-m-d', strtotime($current_date . " -18 years"));
                        $child_data['ss_aw_child_age'] = calculate_age($child_data['ss_aw_child_dob']);
                        $child_data['ss_aw_child_email'] = $postdata['email'];
                        $child_data['ss_aw_child_password'] = @$this->bcrypt->hash_password($postdata['password']);
                        $child_data['ss_aw_child_first_name'] = $postdata['firstname'];
                        $child_data['ss_aw_child_last_name'] = $postdata['lastname'];
                        $child_data['ss_aw_child_schoolname'] = $institution_details->ss_aw_name;
                        $child_data['ss_aw_child_gender'] = $postdata['master_gender'];
                        $child_data['ss_aw_is_institute'] = 1;
                        $check_duplicate = $this->ss_aw_schools_model->check_duplicate($institution_details->ss_aw_name);
                        if ($check_duplicate == 0) {
                            $this->ss_aw_schools_model->add_record(array('ss_aw_name' => $institution_details->ss_aw_name));
                        }
                        $response = $this->ss_aw_childs_model->add_child($child_data);
                        if (!empty($response)) {
                            //send welcome masters mail
                            $email_template = getemailandpushnotification(33, 1, 2);
                            $month_date = date('d/m/Y');
                            if (!empty($email_template)) {
                                $body = $email_template['body'];
                                $body = str_ireplace("[@@username@@]", $postdata['firstname'] . " " . $postdata['lastname'], $body);
                                emailnotification($postdata['email'], $email_template['title'], $body);
                            }
                            //end
                        }
                    }
                }
            }

            if ($response) {
                $this->session->set_flashdata('success', 'User added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, please try again later.');
            }

            redirect('institution/manage_users');
        }
    }

    public function edit_user()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Edit User";
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $pageno = $postdata['pageno'];
            if ($postdata['program_type'] == 1) {
                $child_data = array();
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
                redirect('institution/manage_users/' . $pageno);
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
                redirect('institution/manage_master_users/' . $pageno);
            }
        } else {
            $data = array();
            $child_id = $this->uri->segment(3);
            $page = $this->uri->segment(4);
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
            $this->loadView('institution/edit-user', $headerdata, $data);
        }
    }

    public function import_bulk_users()
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
                print_r($error);
                $this->session->set_flashdata('error', 'Uploaded file format mismatch.');
                redirect('institution/manage_users');
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
                    redirect('institution/manage_users');
                }
            } else {
                if ($header_field_count != 4) {
                    $this->session->set_flashdata('error', 'Please choose the correct format for ' . strtolower(Master) . 's programme.');
                    redirect('institution/manage_users');
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
            $parent_id = $this->session->userdata('id');
            $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
            $institution_id = $institution_admin_details[0]->ss_aw_institution;
            $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
            //end
            //send the data in an array format
            $data['header'] = $header;
            $data['values'] = $arr_data;
            $existing_emails = array();
            $existing_usernames = array();
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
                                redirect('institution/manage_users');
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
                                            $random_code = 10000001;
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
                            if ($this->check_email_existance($email)) {
                                //get the last child code and create after last.
                                $code_check = $this->ss_aw_childs_model->child_code_check();
                                if (isset($code_check)) {
                                    $random_code = $code_check->ss_aw_child_code + 1;
                                } else {
                                    $random_code = 10000001;
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
                                if ($parent_id) {
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

        redirect('institution/manage_users');
    }

    public function manage_master_users()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Manage " . Master . " Users";
        $data = array();
        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;
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
        $total_record = $this->ss_aw_childs_model->total_masters_users($institution_users_id, $search_data, 1);
        $redirect_to = base_url() . 'institution/manage_master_users';
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
        $result = $this->ss_aw_childs_model->get_master_users_by_parents_ary($institution_users_id, $config['per_page'], $page, $search_data, 1);
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

                    //$assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenum($value->ss_aw_child_id, $value->course);
                    $assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenumbychild($value->ss_aw_child_id);
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

        $data['child_details'] = $result;
        $data['lessoncount'] = $lessoncount;
        $data['assessmentcount'] = $assessmentcount;
        $data['readalongcount'] = $readalongcount;
        $data['diagnostictotalquestion'] = $diagnostictotalquestion;
        $data['diagnosticcorrectquestion'] = $diagnosticcorrectquestion;
        $data['diagnosticexamdate'] = $diagnosticexamdate;
        $data['course_details'] = $course_details;
        $data['course_type'] = 2;
        $this->loadView('institution/managemastersusers', $headerdata, $data);
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

        if (empty($child_details[0]['ss_aw_child_username'])) {
            redirect('institution/manage_master_users');
        } else {
            redirect('institution/manage_users');
        }
    }

    public function manage_payment()
    {
        if ($this->courseData == 'diagnostic') {
            redirect('diagnostic_institution/manage_payment');
        }
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Manage Payments";
        $data = array();
        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;
        $result = $this->ss_aw_institution_student_upload_model->get_institution_upload_records($institution_id);
        $data['result'] = $result;
        $this->loadView('institution/managepayments', $headerdata, $data);
    }

    public function make_payment()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Make Payment";
        $upload_id = $this->uri->segment(3);
        $data = array();

        $upload_details = $this->ss_aw_institution_student_upload_model->get_record_by_id($upload_id);
        $payment_history = array();
        $payment_history = $this->ss_aw_institution_payment_details_model->gethistory($upload_details->ss_aw_id);
        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;
        $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
        if ($institution_details->ss_aw_partial_payment == 1) {
            if (count($payment_history) == 0) {
                $institution_details->ss_aw_lumpsum_price = round($institution_details->ss_aw_lumpsum_price / 2, 2);
                $institution_details->ss_aw_lumpsum_price_masters = round($institution_details->ss_aw_lumpsum_price_masters / 2, 2);
            } else {
                $institution_details->ss_aw_lumpsum_price = ($payment_history[0]->ss_aw_payment_amount / $upload_details->ss_aw_student_number);
                $institution_details->ss_aw_lumpsum_price_masters = ($payment_history[0]->ss_aw_payment_amount / $upload_details->ss_aw_student_number);
            }
        } else {
            $check_payment = $this->ss_aw_institution_payment_details_model->check_lumpsum_payment($upload_id);
            if ($check_payment > 0) {
                $this->session->set_flashdata('success', 'Payment already done.');
                redirect('institution/manage_payment');
            }
        }
        $data['upload_details'] = $upload_details;
        $data['institution_details'] = $institution_details;
        $data['institution_admin_details'] = $institution_admin_details;
        if (!empty($payment_history)) {
            $data['payment_history'] = json_encode($payment_history);
        } else {
            $data['payment_history'] = "";
        }
        $this->loadView('institution/makepayments', $headerdata, $data);
    }

    public function get_institution_coupon()
    {
        $postdata = $this->input->post();
        $payment_type = $postdata['paymentType'];
        $institution_id = $postdata['institutionId'];
        $program_type = $postdata['programType'];
        $result = $this->ss_aw_institutions_model->get_institution_coupon($payment_type, $institution_id, $program_type);
        $data = array();
        if (!empty($result)) {
            $data['coupon_code'] = $result->coupon_code;
            echo json_encode($data);
        } else {
            echo "";
        }
    }

    public function apply_coupon()
    {
        $postdata = $this->input->post();
        $coupon_code = $postdata['discount_coupon'];
        $payment_type = $postdata['payment_type'];
        $institution_id = $postdata['institution_id'];
        $response = $this->ss_aw_coupons_model->check_coupon_availability($coupon_code, $payment_type, 1); //coupon code, payment type(Lumpsum/emi), coupon type(individual/institution)
        $responseData = array();
        if (!empty($response)) {
            $responseData['status'] = 1;
            $responseData['data'] = $response;
        } else {
            $responseData['status'] = 0;
        }
        echo json_encode($responseData);
    }

    public function bulk_payment()
    {
        $postdata = $this->input->post();
        if (!empty($postdata)) {
            $parent_id = $this->session->userdata('id');
            $institution_id = $postdata['institution_id'];
            $course_id = $postdata['course_id'];
            $transaction_id = $postdata['transaction_id'];
            $payment_amount = $postdata['payment_amount']; //9.99
            $payment_amount_without_gst = ($payment_amount * 100) / 118;
            $payment_amount_without_gst = round($payment_amount_without_gst * 100) / 100;
            $discount_amount = $postdata['discount_amount']; //161.02
            $coupon_code = $postdata['coupon_code'];
            $payment_type = $postdata['payment_type']; //1=lumpsum,2=emi
            $gst_rate = ($payment_amount_without_gst * 18) / 100;
            $gst_rate = round($gst_rate * 100) / 100;

            $excel_upload_id = $postdata['excel_upload_id'];
            $invoice_prefix = "ALWS/IST/";
            $invoice_suffix = "/" . date('m') . date('y');
            $get_last_invoice_details = $this->ss_aw_institution_payment_details_model->get_last_record();
            if (!empty($get_last_invoice_details)) {
                $invoice_ary = explode("/", $get_last_invoice_details->ss_aw_payment_invoice);
                if (!empty($invoice_ary)) {
                    if (!empty($invoice_ary[2])) {
                        if (is_numeric($invoice_ary[2])) {
                            $suffix_num = (int) $invoice_ary[2] + 1;
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
            //check first lumpsum payment
            $prev_payment_details = $this->ss_aw_institution_payment_details_model->gethistory($excel_upload_id);
            //end
            if ($save_payment) {
                if (!empty($paid_childs)) {
                    $child_count = count($paid_childs);
                    //payment amount calculation per user wise
                    $payment_amount = round($postdata['payment_amount'] / $child_count, 2);
                    $payment_amount_without_gst = ($payment_amount * 100) / 118;
                    $payment_amount_without_gst = round($payment_amount_without_gst * 100) / 100;
                    $discount_amount = round($postdata['discount_amount'] / $child_count, 2); //161.02
                    $coupon_code = $postdata['coupon_code'];
                    $payment_type = $postdata['payment_type']; //1=lumpsum,2=emi
                    $gst_rate = ($payment_amount_without_gst * 18) / 100;
                    $gst_rate = round($gst_rate * 100) / 100;

                    foreach ($paid_childs as $child_id) {
                        $invoice_prefix = "ALWS/";
                        $invoice_suffix = "/" . date('m') . date('y');
                        $get_last_invoice_details = $this->ss_aw_payment_details_model->get_last_invoice();
                        if (!empty($get_last_invoice_details)) {
                            $invoice_ary = explode("/", $get_last_invoice_details[0]->ss_aw_payment_invoice);
                            if (!empty($invoice_ary)) {
                                if (!empty($invoice_ary[1])) {
                                    if (is_numeric($invoice_ary[1])) {
                                        $suffix_num = (int) $invoice_ary[1] + 1;
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
                        //if lumpsum partial payment on and this is second payment then the course and payment details table payment date populate with the first partial payment date.
                        if ($institution_details->ss_aw_partial_payment == 1 && $payment_type == 1) {
                            if (count($prev_payment_details) > 0) {
                                $searary['ss_aw_course_created_date'] = $prev_payment_details[0]->ss_aw_created_date;
                            }
                        }
                        $courseary = $this->ss_aw_purchase_courses_model->data_insert($searary);
                        $payment_invoice_file_path = base_url() . "payment_invoice/" . $filename;
                        $searary = array();
                        $searary['ss_aw_child_id'] = $child_id;
                        $searary['ss_aw_course_id'] = $course_id;
                        if ($payment_type != 1) {
                            $searary['ss_aw_course_payemnt_type'] = 1;
                        }

                        //if lumpsum partial payment on and this is second payment then the course and payment details table payment date populate with the first partial payment date.
                        if ($institution_details->ss_aw_partial_payment == 1 && $payment_type == 1) {
                            if (count($prev_payment_details) > 0) {
                                $searary['ss_aw_child_course_create_date'] = $prev_payment_details[0]->ss_aw_created_date;
                            }
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
                        //if lumpsum partial payment on and this is second payment then the course and payment details table payment date populate with the first partial payment date.
                        if ($institution_details->ss_aw_partial_payment == 1 && $payment_type == 1) {
                            if (count($prev_payment_details) > 0) {
                                $searary['ss_aw_created_date'] = $prev_payment_details[0]->ss_aw_created_date;
                            }
                        }
                        $courseary = $this->ss_aw_payment_details_model->data_insert($searary);
                        //end
                        //revenue mis data store
                        $invoice_amount = $payment_amount - $gst_rate;
                        $reporting_collection_data = array(
                            'ss_aw_parent_id' => $parent_id,
                            'ss_aw_bill_no' => $invoice_no,
                            'ss_aw_course_id' => $course_id,
                            'ss_aw_invoice_amount' => round($invoice_amount),
                            'ss_aw_discount_amount' => round($discount_amount),
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

                            if ($institution_details->ss_aw_partial_payment == 1) {
                                if (count($prev_payment_details) == 0) {
                                    $fixed_course_duration = ceil($fixed_course_duration / 2);
                                    $course_duration = ceil($course_duration / 2);
                                } else {
                                    $half_fixed_course_day = ceil($fixed_course_duration / 2);
                                    $fixed_course_duration = $fixed_course_duration - $half_course_day;
                                    $half_course_day = ceil($course_duration / 2);
                                    $course_duration = $course_duration - $half_course_day;
                                }
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
                                    'ss_aw_invoice_amount' => round($revenue_invoice_amount),
                                    'ss_aw_discount_amount' => round($revenue_discount_amount),
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
                                'ss_aw_invoice_amount' => round($revenue_invoice_amount),
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
                                    'ss_aw_invoice_amount' => round($remaing_amount),
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

    public function paymentsuccess()
    {
        $status = $this->uri->segment(3);
        if ($status == 200) {
            $msg = "Payment done successfully.";
            $this->session->set_flashdata('success', $msg);
        } else {
            $msg = "Something went wrong, please try again later.";
            $this->session->set_flashdata('success', $msg);
        }
        redirect('institution/manage_payment');
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

    public function course_details()
    {
        if ($this->courseData == 'diagnostic') {
            redirect('diagnostic_institution/course_details');
        }
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Course Details";
        $data = array();
        $data['result'] = $this->ss_aw_courses_model->get_all_data();
        $data['curerncy'] = $this->ss_aw_currencies_model->get_all_currency();

        $search_data = array();
        $search_data['ss_aw_expertise_level'] = 'E';
        $winners_topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
        $winnersTopicAry = array();
        if (!empty($winners_topic_listary)) {
            foreach ($winners_topic_listary as $key => $value) {
                $winnersTopicAry[] = $value->ss_aw_section_id;
            }
        }
        $winners_topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($winnersTopicAry);
        $winners_general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
        $winners_lesson_listary = array_merge($winners_topical_lessons, $winners_general_language_lessons);
        $data['winners_lesson_listary'] = $winners_topical_lessons;

        $search_data = array();
        $search_data['ss_aw_expertise_level'] = 'C';
        $champions_topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
        $championsTopicAry = array();
        if (!empty($champions_topic_listary)) {
            foreach ($champions_topic_listary as $key => $value) {
                $championsTopicAry[] = $value->ss_aw_section_id;
            }
        }
        $champions_topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($championsTopicAry);
        $champions_general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
        $champions_lesson_listary = array_merge($champions_topical_lessons, $champions_general_language_lessons);
        $data['champions_lesson_listary'] = $champions_lesson_listary;

        $search_data = array();
        $search_data['ss_aw_expertise_level'] = 'A,M';
        $masters_topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
        $mastersTopicAry = array();
        if (!empty($masters_topic_listary)) {
            foreach ($masters_topic_listary as $key => $value) {
                $mastersTopicAry[] = $value->ss_aw_section_id;
            }
        }
        $masters_topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics($mastersTopicAry);
        $data['masters_lesson_listary'] = $masters_topical_lessons;
        $this->loadView('institution/coursedetails', $headerdata, $data);
    }

    public function upload_user_list()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Uploaded Users List";
        $data = array();
        $upload_record_id = $this->uri->segment(3);
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
                    $course_start_date = $childary[count($childary) - 1]['ss_aw_child_course_create_date'];
                    $lessoncount[$value->ss_aw_child_id] = $this->ss_aw_child_last_lesson_model->gettotalcompletenum($value->ss_aw_child_id, $course_start_date);
                    $assessmentcount[$value->ss_aw_child_id] = $this->ss_aw_assessment_exam_completed_model->gettotalcompletenum($value->ss_aw_child_id,  $course_start_date);

                    $readalongcount[$value->ss_aw_child_id] = $this->ss_aw_last_readalong_model->gettotalcompletenum($value->ss_aw_child_id, $course_start_date);

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
        $this->loadView('institution/uploadeduserslist', $headerdata, $data);
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
        redirect('institution/manage_payment');
    }

    public function payment_histoty()
    {
        if ($this->courseData == 'diagnostic') {
            redirect('diagnostic_institution/payment_history');
        }
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Payment History";
        $data = array();
        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;

        $total_record = $this->ss_aw_institution_payment_details_model->total_record($institution_id);
        $redirect_to = base_url() . 'institution/payment_histoty';
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
        $payment_history = $this->ss_aw_institution_payment_details_model->get_payment_details($institution_id, $config['per_page'], $page);
        $data['payment_history'] = $payment_history;
        $this->loadView('institution/payment_history', $headerdata, $data);
    }

    public function removeuploadedfile()
    {
        $file_delete_id = $this->input->post('file_delete_id');

        $winners_users = $this->ss_aw_childs_model->get_winners_by_upload_id($file_delete_id);
        $winners_user_ids = array();
        if (!empty($winners_users)) {
            foreach ($winners_users as $key => $value) {
                $winners_user_ids[] = $value->ss_aw_child_id;
            }
            //soft delete all childs
            $this->ss_aw_childs_model->remove_multiple_child($winners_user_ids);
        }

        $masters_users = $this->ss_aw_childs_model->get_masters_by_upload_id($file_delete_id);
        $masters_user_ids = array();
        $masters_user_parent_ids = array();
        if (!empty($masters_users)) {
            foreach ($masters_users as $key => $value) {
                $masters_user_ids[] = $value->ss_aw_child_id;
                $masters_user_parent_ids[] = $value->ss_aw_parent_id;
            }
            //soft delete all childs
            $this->ss_aw_childs_model->remove_multiple_child($masters_user_ids);
            //soft delete master users parent details
            $this->ss_aw_parents_model->remove_multiple_parent($masters_user_parent_ids);
        }

        //delete uploaded file
        $this->ss_aw_institution_student_upload_model->file_soft_delete($file_delete_id);
        $this->session->set_flashdata('success', 'Record removed successfully.');
        redirect('institution/manage_payment');
    }

    public function user_course_details()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "User Course Details";
        $data = array();
        $parent_id = $this->uri->segment(3);
        $child_id = $this->uri->segment(4);
        $pageno = $this->uri->segment(5);
        $data['page'] = $pageno;
        $program_type = $this->uri->segment(6);
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
            $pct_level_e = round((count($resultcountary['E']['right_ans']) / count($resultcountary['E']['total_ask'])) * 100);

        if (!empty($resultcountary['C']))
            $pct_level_c = round((count($resultcountary['C']['right_ans']) / count($resultcountary['C']['total_ask'])) * 100);

        if (!empty($resultcountary['A']))
            $pct_level_a = round((count($resultcountary['A']['right_ans']) / count($resultcountary['A']['total_ask'])) * 100);

        /* This Checking for the E level student whose age bellow 13 years */
        if (!empty($resultcountary['E'])) {
            if ($pct_level_e > 80 && $pct_level_c > 70) {
                $recomended_level = 'C';
            } else {
                $recomended_level = 'E';
            }
        }
        /* This Checking for the C level student whose age above 13 years */
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
        $this->loadView('institution/user_course_details', $headerdata, $data);
    }

    public function diagnostic_question_details()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Diagnostic Details";
        $child_id = $this->uri->segment(3);
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
                } else {
                    $value->correct_answer = "";
                    $value->student_answer = "";
                    $value->answer_status = 2;
                }
            }
        }
        $data['dianostic_details'] = $asked_question_details;
        $this->loadView('institution/diagnosticdetails', $headerdata, $data);
    }

    public function lesson_quiz_details()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Lesson Quiz Details";
        $child_id = $this->uri->segment(3);
        $lesson_id = $this->uri->segment(4);
        $data = array();
        $data['lesson_details'] = $this->ss_aw_lesson_quiz_ans_model->getlessonquizdetails($child_id, $lesson_id);
        $this->loadView('institution/lessondetails', $headerdata, $data);
    }

    public function assessment_quiz_details()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Assessment Quiz Details";

        $child_id = $this->uri->segment(3);
        $assessment_id = $this->uri->segment(4);
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
        $this->loadView('institution/assessmentdetails', $headerdata, $data);
    }

    public function readalong_quiz_details()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Readalong Quiz Details";

        $child_id = $this->uri->segment(3);
        $readalong_id = $this->uri->segment(4);
        $data = array();
        $question_details = $this->ss_aw_readalong_quiz_ans_model->get_quiz_details($child_id, $readalong_id);
        $readalong_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
        $data['question_details'] = $question_details;
        $data['readalong_details'] = $readalong_details;
        $this->loadView('institution/readalongdetails', $headerdata, $data);
    }

    public function profile()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Update Profile";

        if ($this->input->post()) {
            $postdata = $this->input->post();
            $institution_id = $postdata['institution_id'];
            $admin_id = $postdata['admin_id'];
            $check_duplicate_mobile = $this->ss_aw_institutions_model->check_duplicate_mobile($postdata['phone_no'], $institution_id);
            if ($check_duplicate_mobile > 0) {
                $this->session->set_flashdata('error', 'Mobile no. already exist.');
                redirect('institution/profile');
            }
            if (!empty($postdata['pan_no'])) {
                $check_duplicate_pan = $this->ss_aw_institutions_model->check_duplicate_pan($postdata['pan_no'], $institution_id);
                if ($check_duplicate_pan > 0) {
                    $this->session->set_flashdata('error', 'PAN No. already exist.');
                    redirect('institution/profile');
                }
            }

            if (!empty($postdata['gst_no'])) {
                $check_duplicate_gst = $this->ss_aw_institutions_model->check_duplicate_gst($postdata['gst_no'], $institution_id);
                if ($check_duplicate_gst > 0) {
                    $this->session->set_flashdata('error', 'GST No. already exist.');
                    redirect('institution/profile');
                }
            }

            $institution_data = array();
            $institution_data['ss_aw_mobile_no'] = $postdata['phone_no'];
            $institution_data['ss_aw_pan_no'] = $postdata['pan_no'];
            $institution_data['ss_aw_gst_no'] = $postdata['gst_no'];
            $this->ss_aw_institutions_model->update_record($institution_data, $institution_id);
            if (!empty($postdata['password'])) {
                $institution_admin_data = array();
                $institution_admin_data['ss_aw_parent_password'] = $this->bcrypt->hash_password($postdata['password']);
                $this->ss_aw_parents_model->update_parent_details($institution_admin_data, $admin_id);
                $this->session->set_userdata('id', '');
            }

            $this->session->set_flashdata('success', 'Profile data updated successfully.');
            redirect('institution/profile');
        }

        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;
        $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
        $data = array();
        $data['institution_admin_details'] = $institution_admin_details;
        $data['institution_details'] = $institution_details;
        $this->loadView('institution/profile', $headerdata, $data);
    }



	public function combined_performance(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Individual Performance";
		$data = array();
		$institution_admin_id = $this->session->userdata('id');
		$institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
		$institution_id = $institute_admin_details[0]->ss_aw_institution;
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
		$childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get comprehensions
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
			//get all childs

			$childs = $this->ss_aw_childs_model->get_users_by_parents_ary($institution_users_id);	
		}
		elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
			//champions child is not set for the institution
		}
		else{
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'A,M';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get all childs
			$childs = $this->ss_aw_childs_model->get_master_users_by_parents_ary($institution_users_id);
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

		if (!empty($lesson_listary)) {
			foreach ($lesson_listary as $key => $lesson_topic) {
				$topic_names[] = $lesson_topic['ss_aw_lesson_topic'];
				$lesson_upto25 = '';
				$lesson_upto50 = '';
				$lesson_upto75 = '';
				$lesson_upto100 = '';

				$assessment_upto25 = '';
				$assessment_upto50 = '';
				$assessment_upto75 = '';
				$assessment_upto100 = '';

				$total_lesson_obtain_score = '';
				$total_assessment_obtain_score = '';

				$lesson_attend_child_num = 0;
				$assessment_attend_child_num = 0;

				$lesson_total_marks = 0;
				$assessment_total_marks = 0;
				if (!empty($childs)) {
					foreach ($childs as $key => $value) {
						$child_id = $value->ss_aw_child_id;
						//lesson section
						$lesson_score_details = $this->ss_aw_lesson_score_model->check_data($child_id, $lesson_topic['ss_aw_lession_id']);
						$lesson_asked = 0;
						$lesson_correct = 0;
						$lesson_complete_date = "";
						if (!empty($lesson_score_details)) {
							$lesson_attend_child_num++;
							$lesson_asked = $lesson_score_details[0]->total_question;
							$lesson_correct = $lesson_score_details[0]->wright_answers;
							$lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_topic['ss_aw_lession_id'], $child_id);
							$lesson_complete_date = $lesson_complete_details->ss_aw_last_lesson_modified_date;
							
							$lesson_score_percentage = get_percentage($lesson_asked, $lesson_correct);
							if ($lesson_score_percentage >= 0 && $lesson_score_percentage <= 25) {
								if ($lesson_upto25 == '') {
									$lesson_upto25 = 0;
								}
								$lesson_upto25++;
							}
							elseif ($lesson_score_percentage > 25 && $lesson_score_percentage <= 50) {
								if ($lesson_upto50 == '') {
									$lesson_upto50 = 0;
								}
								$lesson_upto50++;
							}
							elseif ($lesson_score_percentage > 50 && $lesson_score_percentage <= 75) {
								if ($lesson_upto75 == '') {
									$lesson_upto75 = 0;
								}
								$lesson_upto75++;
							}
							elseif ($lesson_score_percentage > 75 && $lesson_score_percentage <= 100) {
								if ($lesson_upto100 == '') {
									$lesson_upto100 = 0;
								}
								$lesson_upto100++;
							}

							if ($total_lesson_obtain_score == '') {
								$total_lesson_obtain_score = 0;
							}
							$total_lesson_obtain_score = $total_lesson_obtain_score + $lesson_correct;
							//total marks
							$lesson_total_marks = $lesson_asked;
						}
						//end

						//assessment section
						$assessment_id = "";
						$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $lesson_topic['ss_aw_lession_id']);
						if (!empty($topical_assessment_start_details)) {
							$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
						}
						else{
							$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
							$assessment_id = $comprehension_assessment_start_details[0]->ss_aw_assessment_id;
						}
						$assessment_score_details = $this->ss_aw_assessment_score_model->get_score_details_by_assessment_child($child_id, $assessment_id);
						$assessment_asked = 0;
						$assessment_correct = 0;
						if (!empty($assessment_score_details)) {
							$assessment_attend_child_num++;
							$assessment_asked = $assessment_score_details[0]->total_question;
							$assessment_correct = $assessment_score_details[0]->wright_answers;
							
							$assessment_score_percentage = get_percentage($assessment_asked, $assessment_correct);
							if ($assessment_score_percentage >= 0 && $assessment_score_percentage <= 25) {
								if ($assessment_upto25 == '') {
									$assessment_upto25 = 0;
								}
								$assessment_upto25++;
							}
							elseif ($assessment_score_percentage > 25 && $assessment_score_percentage <= 50) {
								if ($assessment_upto50 == '') {
									$assessment_upto50 = 0;
								}
								$assessment_upto50++;
							}
							elseif ($assessment_score_percentage > 50 && $assessment_score_percentage <= 75) {
								if ($assessment_upto75 == '') {
									$assessment_upto75 = 0;
								}
								$assessment_upto75++;
							}
							elseif ($assessment_score_percentage > 75 && $assessment_score_percentage <= 100) {
								if ($assessment_upto100 == '') {
									$assessment_upto100 = 0;
								}
								$assessment_upto100++;
							}

							if ($total_assessment_obtain_score == '') {
								$total_assessment_obtain_score = 0;
							}
							$total_assessment_obtain_score = $total_assessment_obtain_score + $assessment_correct;
							//total marks
							$assessment_total_marks = $assessment_asked;
						}
						//end		
					}
				}
				$lesson0to25[] = $lesson_upto25;
				$lesson25to50[] = $lesson_upto50;
				$lesson50to75[] = $lesson_upto75;
				$lesson75to100[] = $lesson_upto100;



				$assessment0to25[] = $assessment_upto25;
				$assessment25to50[] = $assessment_upto50;
				$assessment50to75[] = $assessment_upto75;
				$assessment75to100[] = $assessment_upto100;

				if ($total_lesson_obtain_score != "") {
					$total_lesson_obtain_score = round($total_lesson_obtain_score / $lesson_attend_child_num);
					//percentage of each lesson avg score
					$total_lesson_obtain_score = round(($total_lesson_obtain_score / $lesson_total_marks) * 100, 2);
				}

				if ($total_assessment_obtain_score != "") {
					$total_assessment_obtain_score = round($total_assessment_obtain_score / $assessment_attend_child_num);
					//percentage of each assessment avg score
					$total_assessment_obtain_score = round(($total_assessment_obtain_score / $assessment_total_marks) * 100, 2);
				}

				$lesson_avg_score[] = $total_lesson_obtain_score;
				$assessment_avg_score[] = $total_assessment_obtain_score;
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
		
		$this->loadView('institution/reports/combined_performance', $headerdata, $data);
	}

	public function module_wise_incomplete_performance(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Module Wise Incomplete Performance";
		$data = array();
		$institution_admin_id = $this->session->userdata('id');
		$institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
		$institution_id = $institute_admin_details[0]->ss_aw_institution;
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
		$general_language_lessons = array();
		$diagnostic_complete_childs = array();
		$diagnostic_incomplete_childs = array();
		if ($programme_type == 1) {
			//get all topics
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'E';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			//get comprehensions
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
		}
		elseif ($programme_type == 3) {
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
		//get score data
		$diagnosticincompletenum = 0;
		$diagnosticincompletechilds = array();

		$lessonincompletenum = array();
		$lessonincompletechilds = array();
		$lessonnonaccessable = array();

		$assessmentincompletenum = array();
		$assessmentincompletechilds = array();
		$assessmentnonaccessable = array();

		$readalongincompletenum = array();
		$readalongincompletechilds = array();
		$readalongnonaccessable = array();

		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);

				if (!empty($childs)) {
					foreach ($childs as $key => $value) {
						if (empty($value->ss_aw_diagonastic_exam_date)) {
							$child_id = $value->ss_aw_child_id;
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

						$readalongincompletenum[$lesson_id] = 0;
						$readalongincompletechilds[$lesson_id] = array();
						$readalongnonaccessable[$lesson_id] = 0;

						

						if (!empty($childs)) {
							foreach ($childs as $key => $value) {
								$child_id = $value->ss_aw_child_id;
								{
									//diagnostic section
									if (!empty($value->ss_aw_diagonastic_exam_date)) {
										$accessable = 0;
										if ($i == 0) {
											$accessable = 1;
											$readalong_start_date = date('Y-m-d', strtotime($value->ss_aw_diagonastic_exam_date));
										}
										else{
											$prev_lesson_id = $lesson_listary[$i - 1]['ss_aw_lession_id'];
											$prev_lesson_complete_date = "";
											$prev_lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_listary[$i - 1]['ss_aw_lession_id'], $child_id);

											//check prev assessment complete or not
											//if assessment not complete then upcoming lesson will not open.
											$prev_assessment_id = "";
											$prev_topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $prev_lesson_id);
											if (!empty($prev_topical_assessment_start_details)) {
												$prev_assessment_id = $prev_topical_assessment_start_details[0]->ss_aw_assessment_id;
											}
											else{
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
													$readalong_start_date = date('Y-m-d', strtotime($prev_lesson_complete_details->ss_aw_last_lesson_create_date." +7 day"));
												}
												else{
													$readalong_start_date = date('Y-m-d', strtotime($prev_assessment_complete_date)); 
												}
												//end
												$prev_lesson_start_date = $prev_lesson_complete_details->ss_aw_last_lesson_create_date;
												$prev_lesson_complete_date = $prev_lesson_complete_details->ss_aw_last_lesson_modified_date;
												$accessDate = date('Y-m-d', strtotime($prev_lesson_start_date." + 7 day"));
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
											}
											else{
												$lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_id, $child_id);
												$lesson_complete_date = $lesson_complete_details->ss_aw_last_lesson_modified_date;
											}
											//end

											//readalong section
											$readalongnonaccessable[$lesson_id]++;
											if(!empty($lesson_complete_date)){
												$restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($programme_type);
												$restriction_time = $restriction_detail[0]->restricted_time;
												$readalong_end_date = date('Y-m-d H:i:s', strtotime($readalong_start_date. "+ ".$restriction_time." minutes"));
												//get scheduled readalong details
												$scheduled_readalong = $this->ss_aw_schedule_readalong_model->get_readalong_schduled($child_id, $readalong_start_date, $readalong_end_date);
												if (!empty($scheduled_readalong)) {
													$scheduled_readalong_id = $scheduled_readalong->ss_aw_readalong_id;
													$check_finish = $this->ss_aw_last_readalong_model->check_readalong_completion($scheduled_readalong_id, $child_id);
													$readalong_correct = 0;
													$readalong_asked = 0;
													$readalong_id_ary[$child_id][$lesson_topic['ss_aw_lession_id']] = $scheduled_readalong_id;
													if (empty($check_finish)) {
														$readalongincompletenum[$lesson_id]++;
														$readalongincompletechilds[$lesson_id][] = $child_id;
													}
												}
												else{
													$readalongincompletenum[$lesson_id]++;
													$readalongincompletechilds[$lesson_id][] = $child_id;
												}
											}
											else{
												$readalongincompletenum[$lesson_id]++;
												$readalongincompletechilds[$lesson_id][] = $child_id;
											}
											//end

											{
												$assessmentnonaccessable[$lesson_id]++;
												//assessment section
												$assessment_id = "";
												$topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $lesson_id);
												if (!empty($topical_assessment_start_details)) {
													$assessment_id = $topical_assessment_start_details[0]->ss_aw_assessment_id;
												}
												else{
													$comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
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
		$data['lessonincompletenum'] = $lessonincompletenum;
		$data['lessonincompletechilds'] = $lessonincompletechilds;
		$data['assessmentincompletenum'] = $assessmentincompletenum;
		$data['assessmentincompletechilds'] = $assessmentincompletechilds;
		$data['readalongincompletenum'] = $readalongincompletenum;
		$data['readalongincompletechilds'] = $readalongincompletechilds;
		$data['lessonnonaccessable'] = $lessonnonaccessable;
		$data['assessmentnonaccessable'] = $assessmentnonaccessable;
		$data['readalongnonaccessable'] = $readalongnonaccessable;
		$data['institution_id'] = $institution_id;
		$this->loadView('institution/reports/module_wise_incomplete_performance', $headerdata, $data);
	}

	public function diagnostic_incomplete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Incomplete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$this->loadView('institution/reports/diagnostic_incomplete_users', $headerdata, $data);
	}

	public function lesson_incomplete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Incomplete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$this->loadView('institution/reports/lesson_incomplete_users', $headerdata, $data);
	}

	public function assessment_incomplete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Incomplete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$this->loadView('institution/reports/assessment_incomplete_users', $headerdata, $data);
	}

	public function readalong_incomplete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Incomplete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$this->loadView('institution/reports/readalong_incomplete_users', $headerdata, $data);
	}

	public function module_wise_complete_performance(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Module Wise Complete Performance";
		$data = array();
		$institution_admin_id = $this->session->userdata('id');
		$institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
		$institution_id = $institute_admin_details[0]->ss_aw_institution;
		$institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
		$institution_users_id = array();
		if (!empty($institution_parents)) {
			foreach ($institution_parents as $key => $value) {
				$institution_users_id[] = $value->ss_aw_parent_id;
			}
		}

		if ($this->input->post()) {
			$post_programme_type = $this->input->post('programme_type');
			$this->session->set_userdata('complete_users_programme_type', $post_programme_type);
		}
		$programme_type = $this->session->userdata('complete_users_programme_type') ? $this->session->userdata('complete_users_programme_type') : 1;
		
		$searchdata = array();
		$searchdata['complete_user_programme_type'] = $programme_type;
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
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();	
		}
		elseif ($programme_type == 3) {
			$search_data = array();
			$search_data['ss_aw_expertise_level'] = 'C';
			$topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
			$general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
			//champions child is not set for the institution
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
		//get score data
		$diagnosticcompletenum = 0;
		$diagnosticcompletechilds = array();

		$lessoncompletenum = array();
		$lessoncompletechilds = array();
		$lessonnonaccessable = array();

		$assessmentcompletenum = array();
		$assessmentcompletechilds = array();
		$assessmentnonaccessable = array();

		$readalongcompletenum = array();
		$readalongcompletechilds = array();
		$readalongnonaccessable = array();

		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);
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
				if (!empty($lesson_listary)) {
					foreach ($lesson_listary as $i => $lesson_topic) {
						$lesson_id = $lesson_topic['ss_aw_lession_id'];

						$lessoncompletenum[$lesson_id] = 0;
						$lessoncompletechilds[$lesson_id] = array();
						$lessonnonaccessable[$lesson_id] = 0;

						$assessmentcompletenum[$lesson_id] = 0;
						$assessmentcompletechilds[$lesson_id] = array();
						$assessmentnonaccessable[$lesson_id] = 0;

						$readalongcompletenum[$lesson_id] = 0;
						$readalongcompletechilds[$lesson_id] = array();
						$readalongnonaccessable[$lesson_id] = 0;

						if (!empty($childs)) {
							foreach ($childs as $key => $value) {
								$lesson_complete_date = "";
								$child_id = $value->ss_aw_child_id;
								if (!empty($value->ss_aw_diagonastic_exam_date)) {
									$child_activation_date = date('Y-m-d', strtotime($value->ss_aw_diagonastic_exam_date));
									{
										$accessable = 0;
										if ($i == 0) {
											$accessable = 1;
											$readalong_start_date = $child_activation_date;
										}
										else{
											$prev_lesson_id = $lesson_listary[$i - 1]['ss_aw_lession_id'];
											$prev_lesson_complete_date = "";
											$prev_lesson_complete_details = $this->ss_aw_child_last_lesson_model->get_details_by_lesson($lesson_listary[$i - 1]['ss_aw_lession_id'], $child_id);

											//check prev assessment complete or not
											//if assessment not complete then upcoming lesson will not open.
											$prev_assessment_id = "";
											$prev_topical_assessment_start_details = $this->ss_aw_assesment_questions_asked_model->check_exam_start($child_id, $prev_lesson_id);
											if (!empty($prev_topical_assessment_start_details)) {
												$prev_assessment_id = $prev_topical_assessment_start_details[0]->ss_aw_assessment_id;
											}
											else{
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
													$readalong_start_date = date('Y-m-d', strtotime($prev_lesson_complete_details->ss_aw_last_lesson_create_date." +7 day"));
												}
												else{
													$readalong_start_date = date('Y-m-d', strtotime($prev_assessment_complete_date)); 
												}
												//end
												$prev_lesson_start_date = $prev_lesson_complete_details->ss_aw_last_lesson_create_date;
												$prev_lesson_complete_date = $prev_lesson_complete_details->ss_aw_last_lesson_modified_date;
												$accessDate = date('Y-m-d', strtotime($prev_lesson_start_date." + 7 day"));
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
												}
												else{
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
											

											//readalong section
											if (!empty($lesson_complete_date)) {
												$readalongnonaccessable[$lesson_id]++;
												$restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($programme_type);
												$restriction_time = $restriction_detail[0]->restricted_time;
												$readalong_end_date = date('Y-m-d H:i:s', strtotime($readalong_start_date. "+ ".$restriction_time." minutes"));
												//get scheduled readalong details
												$scheduled_readalong = $this->ss_aw_schedule_readalong_model->get_readalong_schduled($child_id, $readalong_start_date, $readalong_end_date);
												if (!empty($scheduled_readalong)) {
													$scheduled_readalong_id = $scheduled_readalong->ss_aw_readalong_id;
													$check_finish = $this->ss_aw_last_readalong_model->check_readalong_completion($scheduled_readalong_id, $child_id);
													$readalong_correct = 0;
													$readalong_asked = 0;
													$readalong_id_ary[$child_id][$lesson_topic['ss_aw_lession_id']] = $scheduled_readalong_id;
													if (!empty($check_finish)) {
														$readalongcompletenum[$lesson_id]++;
														$readalongcompletechilds[$lesson_id][] = $child_id;
													}
												}
											}
											//end
										}
									}
								}
							}
						}		
					}
				}
		//end

		$diagnostic_complete_log = $this->ss_aw_diagnostic_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
		$data['diagnostic_complete_log'] = $diagnostic_complete_log;
		$topics_complete_log = $this->ss_aw_topics_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
		$topical_log_details = array();
		if (!empty($topics_complete_log)) {
			foreach ($topics_complete_log as $key => $value) {
				$topical_log_details[$value->ss_aw_lesson_id] = $value;		
			}		
		}	
		$data['topical_log_details'] = $topical_log_details;	
		$data['topics'] = $lesson_listary;
		$data['childs'] = $childs;
		$data['diagnosticcompletenum'] = $diagnosticcompletenum;
		$data['diagnosticcompletechilds'] = $diagnosticcompletechilds;
		$data['lessoncompletenum'] = $lessoncompletenum;
		$data['lessoncompletechilds'] = $lessoncompletechilds;
		$data['assessmentcompletenum'] = $assessmentcompletenum;
		$data['assessmentcompletechilds'] = $assessmentcompletechilds;
		$data['readalongcompletenum'] = $readalongcompletenum;
		$data['readalongcompletechilds'] = $readalongcompletechilds;
		$data['assessmentnonaccessable'] = $assessmentnonaccessable;
		$data['readalongnonaccessable'] = $readalongnonaccessable;
		$data['lessonnonaccessable'] = $lessonnonaccessable;
		$data['institution_id'] = $institution_id;
		$this->loadView('institution/reports/module_wise_complete_performance', $headerdata, $data);
	}

	public function diagnostic_complete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Diagnostic Complete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		if ($this->uri->segment(4)) {
			$data['page_type'] = base64_decode($this->uri->segment(4));
		}
		else{
			$data['page_type'] = "";
		}
		$this->loadView('institution/reports/diagnostic_complete_users', $headerdata, $data);
	}

	public function lesson_complete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Lesson Complete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$this->loadView('institution/reports/lesson_complete_users', $headerdata, $data);
	}

	public function assessment_complete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Assessment Complete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		if ($this->uri->segment(4)) {
			$data['page_type'] = base64_decode($this->uri->segment(4));
		}
		else{
			$data['page_type'] = "";
		}
		$this->loadView('institution/reports/assessment_complete_users', $headerdata, $data);
	}

	public function readalong_complete_users(){
		$headerdata = $this->checklogin();
		$headerdata['title'] = "Readalong Complete Users";
		$data = array();
		$childs = $this->uri->segment(3);
		$childs = base64_decode($childs);
		$childary = explode(",", $childs);
		$data['child_list'] = $this->ss_aw_childs_model->get_childs_by_ary($childary);
		$this->loadView('institution/reports/readalong_complete_users', $headerdata, $data);
	}


    public function individual_performance()
    {

        $headerdata = $this->checklogin();
        $headerdata['title'] = "Individual Performance";
        $data = array();
        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;
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
        $redirect_to = base_url() . 'institution/individual_performance';
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
        $datper = array();
        $performance = $this->module_wise_performance_model->get_module_individual_performence_data($institution_id, $search_data['ss_aw_expertise_level'], $programme_type, 1);

        if (!empty($performance)) {
            foreach ($performance as $per) {
                $datper[$per['ss_aw_child_id']][$per['ss_aw_lession_id']] = $per;
            }
        }
        $childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, $config['per_page'], $page, 1);

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
        $this->loadView('institution/reports/individual_performance', $headerdata, $data);
    }
    public function individual_performance_old()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Individual Performance";
        $data = array();

        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;
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
        $diagnosticcompletedate = array();

        $lessonscoredata = array();
        $lessoncompletedate = array();

        $assessment_id_ary = array();
        $assessmentscoredata = array();
        $assessmentcompletedate = array();

        $total_record = $this->ss_aw_childs_model->get_programee_users_count($institution_users_id, $programme_type, 1);
        $redirect_to = base_url() . 'admin/institution_individual_performance/' . $institution_id;
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

        $childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, $config['per_page'], $page, 1);

        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $child_id = $value->ss_aw_child_id;

                //diagnostic section
                $diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
                $diagnostic_exam_complete_date = "";
                if (!empty($diagnostic_exam_code_details)) {
                    $exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
                    $diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
                    $diagnosticcorrectnum[$child_id] = get_percentage(DIAGNOSTIC_QUESTION_NUM, $diagnostic_question_correct) . "%";
                    $diagnosticcompletedate[$child_id] = date('d/m/Y', strtotime($diagnostic_exam_code_details->ss_aw_diagonastic_exam_date));
                    $diagnostic_exam_complete_date = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_date;
                } else {
                    $diagnostic_question_correct = 0;
                    $diagnosticcorrectnum[$child_id] = "NA";
                    $diagnosticcompletedate[$child_id] = "";
                }

                //lesson assessment and readalong section
                $finish_record_id = array(); //readalong finish record id ary
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
                        $lessoncompletedate[$child_id][$lesson_topic['ss_aw_lession_id']] = $lesson_complete_date != "" ? date('d/m/Y', strtotime($lesson_complete_date)) : "";
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
                        $assessment_complete_date = "";
                        if (!empty($assessment_completetion_details)) {
                            $assessment_complete_date = $assessment_completetion_details[0]->ss_aw_create_date;
                            $module_complete_day_gap = daysDifferent(strtotime($lesson_start_date), strtotime($assessment_complete_date));
                            if ($module_complete_day_gap < 7) {
                                $prev_assessment_complete_date = date('Y-m-d', strtotime($lesson_start_date . " +7 day"));
                            } else {
                                $prev_assessment_complete_date = date('Y-m-d', strtotime($assessment_complete_date));
                            }
                        }
                        $assessmentcompletedate[$child_id][$lesson_topic['ss_aw_lession_id']] = $assessment_complete_date != "" ? date('d/m/Y', strtotime($assessment_complete_date)) : "";
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
        $data['assessmentcompletedate'] = $assessmentcompletedate;
        $data['lessoncompletedate'] = $lessoncompletedate;
        $data['diagnosticcompletedate'] = $diagnosticcompletedate;
        $data['institution_id'] = $institution_id;
        $data['courses_drop'] = $this->common_model->getAllcourses(false);
        $this->loadView('institution/reports/individual_performance', $headerdata, $data);
    }




    public function module_wise_incomplete_performance_old()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Module Wise Incomplete Performance";
        $data = array();
        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;
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
        $general_language_lessons = array();
        $diagnostic_complete_childs = array();
        $diagnostic_incomplete_childs = array();
        if ($programme_type == 1) {
            //get all topics
            $search_data = array();
            $search_data['ss_aw_expertise_level'] = 'E';
            $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
            //get comprehensions
            $general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
        } elseif ($programme_type == 3) {
            $search_data = array();
            $search_data['ss_aw_expertise_level'] = 'C';
            $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
            $general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_champions_general_language_lessons();
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
                if (empty($value->ss_aw_diagonastic_exam_date)) {
                    $child_id = $value->ss_aw_child_id;
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
                            //diagnostic section
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
                                            $comprehension_assessment_start_details = $this->ss_aw_assesment_multiple_question_asked_model->check_exam_start($child_id, $value->ss_aw_lesson_id);
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
        $data['lessonincompletenum'] = $lessonincompletenum;
        $data['lessonincompletechilds'] = $lessonincompletechilds;
        $data['assessmentincompletenum'] = $assessmentincompletenum;
        $data['assessmentincompletechilds'] = $assessmentincompletechilds;
        $data['lessonnonaccessable'] = $lessonnonaccessable;
        $data['assessmentnonaccessable'] = $assessmentnonaccessable;
        $data['institution_id'] = $institution_id;
        $data['courses_drop'] = $this->common_model->getAllcourses(false);
        $this->loadView('institution/reports/module_wise_incomplete_performance', $headerdata, $data);
    }



    public function module_wise_complete_performance_old()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Module Wise Complete Performance";
        $data = array();
        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;
        $institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
        $institution_users_id = array();
        if (!empty($institution_parents)) {
            foreach ($institution_parents as $key => $value) {
                $institution_users_id[] = $value->ss_aw_parent_id;
            }
        }

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
        $getdata = $this->ss_aw_admin_users_model->getmodulewisereportdata($institution_id, $search_data['ss_aw_expertise_level'], $programme_type);




        $diagnostic_complete_log = $this->ss_aw_diagnostic_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
        $data['diagnostic_complete_log'] = $diagnostic_complete_log;
        $topics_complete_log = $this->ss_aw_topics_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id);
        $topical_log_details = array();
        if (!empty($topics_complete_log)) {
            foreach ($topics_complete_log as $key => $value) {
                $topical_log_details[$value->ss_aw_lesson_id] = $value;
            }
        }
        $diagnosticcompletenum = 0;
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
        $data['institution_id'] = $institution_id;
        $this->loadView('institution/reports/module_wise_complete_performance', $headerdata, $data);
    }




    public function loadView($viewName, $headerData = array(), $pageData = array())
    {
        $this->load->view('institution/header', $headerData);
        $this->load->view($viewName, $pageData);
    }

    public function readalong_count()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Readalong count";
        $data = array();

        $parent_data = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($this->session->userdata('id'));

        $data['institution_id'] = $institution_id = $parent_data[0]->ss_aw_institution;
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

        $data['childs'] = $childs = $this->ss_aw_childs_model->get_programee_users_readalong($institution_users_id, $programme_type, 1);
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
        $data['courses_drop'] = $this->common_model->getAllcourses(false);
        $this->loadView('institution/reports/readalong_count_data', $headerdata, $data);
    }

    public function getallreadalongdata()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Readalong Details";
        $data = array();

        $child_id = $this->uri->segment(3);
        $data['readalong_details'] = $this->ss_aw_childs_model->getallreadalongdetails($child_id);
        $data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
        $this->loadView('institution/reports/readalong_details_data', $headerdata, $data);
    }

    public function readalnongscoredetails($child_id, $readalong_id)
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Readalong Quiz Details";
        $data = array();
        $question_details = $this->ss_aw_readalong_quiz_ans_model->get_quiz_details($child_id, $readalong_id);
        $readalong_details = $this->ss_aw_readalongs_upload_model->getrecordbyid($readalong_id);
        $data['question_details'] = $question_details;
        $data['readalong_details'] = $readalong_details;
        $data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
        $this->load->view('admin/header', $headerdata);
        $this->load->view('institution/readalongscoredetails', $data);
    }

    public function assessment_subtopic_score($child_id, $assessment_id, $page){
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Readalong Quiz Details";
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
        $data['page'] = $page;
        $this->load->view('admin/header', $headerdata);
        $this->load->view('institution/assessment_subtopic_score', $data);
    }
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
