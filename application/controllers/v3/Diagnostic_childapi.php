<?php

set_time_limit(320);
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class Diagnostic_childapi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ss_aw_error_code_model');
        $this->load->model('diagnostic_childs_model');
        $this->load->helper('custom_helper');
        $this->load->model('ss_aw_parents_model');
        $this->load->model('diagnostic_exam_last_lesson_model');
        $this->load->model('diagnonstic_questions_asked_model');
        $this->load->model('ss_aw_sections_topics_model');
        $this->load->model('ss_aw_test_timing_model');
        $this->load->model('ss_aw_assisment_diagnostic_model');
        $this->load->model('ss_aw_general_settings_model');
        $this->load->model('ss_aw_update_profile_log_model');

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        if (!$foo = $this->cache->get('idletime')) {
            $searchary = array();
            $test_timeary = $this->ss_aw_test_timing_model->search_byparam($searchary);
            if ($test_timeary[0]['ss_aw_test_timing_fieldname'] == 'Question Idle Time') {
                $idletime = $test_timeary[0]['ss_aw_test_timing_value'];
                $this->cache->file->save('idletime', $idletime, 10);
            }
        }
    }

    public function diagnostic_test_question_first_set()
    {
        $inputpost = $this->input->post(); // Accept All post data post from APP		
        $responseary = array();
        $categorysetcountno = 15;
        $categoryallowcount = 10;

        if ($inputpost) {
            $child_id = $inputpost['user_id']; // Child Record ID from Database
            $child_token = $inputpost['user_token']; // Token get after login
            $parent_id = "";
            if (!empty($inputpost['parent_id'])) {
                $parent_id = $inputpost['parent_id'];
            }

            if ($parent_id == "" ? $this->check_child_existance($child_id, $child_token) : $this->check_parent_existance($parent_id, $child_token)) { // Check provider Token valid or not against child_id and token
                //check diagnostic exam given or not
                $diagnostic_complete_check = $this->diagnostic_exam_last_lesson_model->get_exam_details_by_child($child_id);

                if (!empty($diagnostic_complete_check->ss_aw_last_lesson_modified_date)) {
                    $responseary['status'] = 1025;
                    $responseary['msg'] = "You have already completed diagnostic";
                    // $this->diagnostic_childs_model->logout($child_id);
                    die(json_encode($responseary));
                }

                //check diagnostic attempt number
                // $diagnostic_exam_attempt_details = $this->diagnonstic_questions_asked_model->get_diagnostic_exam_attempt_details($diagnostic_complete_check->ss_aw_lesson_code);

                $diagnostic_exam_code = time() . "_" . $child_id; // Format : time()_<child_id> This code USe to identify ever diagnostic exam uniquely
                $childdetailsary = array();
                $childdetailsary = $this->diagnostic_childs_model->get_child_profile_details($child_id, $child_token);

                $child_level = "E";
                $topic_listary = array();
                $sequencenoary = array();
                if (!empty($childdetailsary[0]->ss_aw_child_username)) {
                    $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(10, 0);
                } else {
                    $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(20, 0);
                }

                $categorysetcountno = count($topic_listary);
                $sequencenoaryids = array();
                foreach ($topic_listary as $key => $val) {
                    $check_validate = $this->ss_aw_assisment_diagnostic_model->checkbycategory($val->ss_aw_section_title, $child_level);

                    if ($check_validate > 0) {
                        if ($key < $categorysetcountno) {
                            $sequencenoaryids[] = $val->ss_aw_section_id;
                            $sequencenoary[$val->ss_aw_section_id] = $val->ss_aw_section_title;
                        }
                    }
                }

                shuffle($sequencenoaryids);

                $randomtopic = array();
                $randomtopic = array_slice($sequencenoaryids, 0, $categoryallowcount);




                /*
                  Create a array of Topic names from where the questions are asked.1 from each topic/category
                 */
                $finalquestionary = array();
                /* Get Idle time for a question */
                $setting_result = array();
                $setting_result = $this->ss_aw_general_settings_model->fetch_record();
                $idletime = $setting_result[0]->ss_aw_time_skip;
                $timesetting = $this->ss_aw_test_timing_model->fetch_record_byid(2);

                $i = 0;
                $asked_question_ids = "";
                $asked_category_ids = "";
                foreach ($randomtopic as $key => $val) {
                    //$randomtopic[$key] = $sequencenoary[$val];
                    $response = $this->ss_aw_assisment_diagnostic_model->fetch_question_bycategory($sequencenoary[$val], $child_level);

                    $finalquestionary[$i]['question_id'] = $response[0]['ss_aw_id'];
                    $finalquestionary[$i]['level'] = $response[0]['ss_aw_level'];
                    $finalquestionary[$i]['format'] = $response[0]['ss_aw_format'];

                    if ($response[0]['ss_aw_format'] == 'Single')
                        $finalquestionary[$i]['format_id'] = 1;
                    else
                        $finalquestionary[$i]['format_id'] = 2;

                    $finalquestionary[$i]['seq_no'] = $response[0]['ss_aw_seq_no'];
                    $finalquestionary[$i]['weight'] = $response[0]['ss_aw_weight'];
                    $finalquestionary[$i]['category'] = $response[0]['ss_aw_category'];
                    $finalquestionary[$i]['sub_category'] = $response[0]['ss_aw_sub_category'];
                    $finalquestionary[$i]['question_format'] = $response[0]['ss_aw_question_format'];

                    if ($response[0]['ss_aw_question_format'] == 'Choose the right answer')
                        $finalquestionary[$i]['question_format_id'] = 2;
                    else if ($response[0]['ss_aw_question_format'] == 'Fill in the blanks')
                        $finalquestionary[$i]['question_format_id'] = 1;
                    else if ($response[0]['ss_aw_question_format'] == 'Rewrite the sentence')
                        $finalquestionary[$i]['question_format_id'] = 3;


                    $finalquestionary[$i]['prefaceaudio'] = base_url() . $response[0]['ss_aw_question_preface_audio'];
                    $finalquestionary[$i]['preface'] = $response[0]['ss_aw_question_preface'];
                    $finalquestionary[$i]['question'] = trim($response[0]['ss_aw_question']);

                    $multiple_choice_ary = array();
                    $multiple_choice_ary = explode("/", $response[0]['ss_aw_multiple_choice']);

                    if (count($multiple_choice_ary) > 1)
                        $finalquestionary[$i]['options'] = $multiple_choice_ary;
                    else
                        $finalquestionary[$i]['options'][0] = $response[0]['ss_aw_multiple_choice'];


                    $finalquestionary[$i]['verb_form'] = $response[0]['ss_aw_verb_form'];

                    $answersary = array();
                    $answersary = explode("/", trim($response[0]['ss_aw_answers']));
                    if (count($answersary) > 1) {
                        $answersary = array_map('trim', $answersary);
                        $finalquestionary[$i]['answers'] = $answersary;
                    } else {
                        $finalquestionary[$i]['answers'][0] = trim($response[0]['ss_aw_answers']);
                    }
                    $finalquestionary[$i]['answeraudio'] = base_url() . $response[0]['ss_aw_answers_audio'];

                    $finalquestionary[$i]['rules'] = trim($response[0]['ss_aw_rules']);

                    $finalquestionary[$i]['hint'] = "";
                    $finalquestionary[$i]['ruleaudio'] = base_url() . $response[0]['ss_aw_rules_audio'];

                    $i++;
                    // $asked_question_ids .= $response[0]['ss_aw_id'] . ",";
                    // $asked_category_ids .= $val . ",";

                    $insertary = array();
                    $insertary['ss_aw_child_id'] = $child_id;
                    $insertary['ss_aw_question_set'] = 1;
                    $insertary['ss_aw_diagnostic_id'] = $response[0]['ss_aw_id'];
                    $insertary['ss_aw_asked_category_id'] = $val;
                    $insertary['ss_aw_diagonastic_exam_code'] = $diagnostic_exam_code;
                    $this->diagnonstic_questions_asked_model->insert_record($insertary);
                }
                $last_lesson = array();
                $last_lesson['ss_aw_child_id'] = $diagnostic_complete_check->ss_aw_child_id;
                $last_lesson['upload_child_id'] = $diagnostic_complete_check->upload_child_id;
                $last_lesson['ss_aw_lesson_level'] = 6;
                $last_lesson['ss_aw_lesson_id'] = 6;
                $last_lesson['ss_aw_lesson_code'] = $diagnostic_exam_code;
                $last_lesson['last_lesson_create_date'] = date('Y-m-d H:i:s');
                $this->diagnostic_exam_last_lesson_model->update_details($last_lesson);

                $responseary['status'] = 200;

                $responseary['total_duration'] = $timesetting[0]->ss_aw_test_timing_value;
                $responseary['correct_answer_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_answer_audio;
                $responseary['complete_assessment_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_complete_assessment_audio;
                $responseary['skip_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_skip_audio;
                $responseary['warning_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_warning_audio;
                $responseary['correct_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_correct_audio;
                $responseary['incorrect_audio'] = base_url() . "assets/audio/" . $setting_result[0]->ss_aw_incorrect_audio;
                $responseary['skip_duration'] = $idletime;
                $responseary['idle_exit_duration'] = $setting_result[0]->ss_aw_time_interval_exit;
                $responseary['skip_type_1_2_duration'] = $idletime;
                $responseary['skip_type_3_duration'] = $setting_result[0]->ss_aw_pause_time;
                $responseary['data'] = $finalquestionary;
                $responseary['diagonastic_exam_code'] = $diagnostic_exam_code;
            } else {
                $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
                foreach ($error_array as $value) {
                    $responseary['status'] = $value->ss_aw_error_status;
                    $responseary['msg'] = $value->ss_aw_error_msg;
                }
            }

            echo json_encode($responseary);
            die();
        }
    }
    public function check_child_existance($child_id, $child_token)
    {

        $response = $this->diagnostic_childs_model->check_child_existance_with_token($child_id, $child_token);

        if ($response) {
            return 1;
        } else {
            return 0;
        }
    }
    public function check_parent_existance($parent_id, $parent_token)
    {
        $response = $this->ss_aw_parents_model->check_parent_existance($parent_id, $parent_token);
        if ($response) {
            return 1;
        } else {
            $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
            foreach ($error_array as $value) {
                $responseary['status'] = $value->ss_aw_error_status;
                $responseary['msg'] = $value->ss_aw_error_msg;
            }
        }
        echo json_encode($responseary);
        die();
    }
    public function change_password()
    {
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $child_id = $inputpost['user_id']; // Child Record ID from Database
            $child_token = $inputpost['user_token']; // Token get after login

            if ($this->check_child_existance($child_id, $child_token)) { // Check provider Token valid or not against child_id and token
                $old_password = $inputpost['old_password'];
                $password = $inputpost['password'];
                $result = $this->diagnostic_childs_model->get_child_profile_details($child_id, $child_token);
                $child_password = $result[0]->ss_aw_child_password;
                if ($this->bcrypt->check_password($old_password, $child_password)) {
                    $hash_pass = $this->bcrypt->hash_password($password);
                    $result = $this->diagnostic_childs_model->password_update($child_id, $hash_pass);

                    if ($result) {
                        $responseary['status'] = 200;
                        $responseary['msg'] = "Password successfully change";
                        $responseary['user_id'] = $child_id;
                    } else {
                        $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1019');
                        foreach ($error_array as $value) {
                            $responseary['status'] = $value->ss_aw_error_status;
                            $responseary['msg'] = $value->ss_aw_error_msg;
                            $responseary['title'] = "Error";
                        }
                    }
                } else {
                    $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1020');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                        $responseary['title'] = "Error";
                    }
                }
            } else {
                $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1025');
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
    public function get_profile_details()
    {
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $child_id = $inputpost['user_id'];
            $child_token = $inputpost['user_token'];
            $result = $this->diagnostic_childs_model->get_child_profile_details($child_id, $child_token);
            if (!empty($result)) {
                $responseary['status'] = 200;
                $responseary['msg'] = "Data Found";
                foreach ($result as $value) {
                    $responseary['user_id'] = $value->ss_aw_child_id;
                    $responseary['child_code'] = $value->ss_aw_child_code;
                    $responseary['parent_id'] = $value->ss_aw_parent_id;
                    $responseary['nick_name'] = $value->ss_aw_child_nick_name;
                    $responseary['first_name'] = $value->ss_aw_child_first_name;
                    $responseary['last_name'] = $value->ss_aw_child_last_name;

                    if (!empty($value->ss_aw_child_profile_pic))
                        $responseary['photo'] = base_url() . "uploads/" . $value->ss_aw_child_profile_pic;
                    else
                        $responseary['photo'] = base_url() . "uploads/profile.jpg";

                    $responseary['child_schoolname'] = $value->ss_aw_child_schoolname;
                    $responseary['child_gender'] = $value->ss_aw_child_gender;
                    $responseary['dob'] = $value->ss_aw_child_dob;
                    $responseary['email'] = $value->ss_aw_child_email;
                    $responseary['primary_mobile'] = $value->ss_aw_child_mobile;
                    $responseary['country_sort_name'] = $value->ss_aw_child_country_sort_name;
                    $responseary['country_code'] = $value->ss_aw_child_country_code;
                    $responseary['user_token'] = $child_token;
                    $responseary['child_created_date'] = $value->ss_aw_child_created_date;
                    $responseary['address'] = $value->ss_aw_child_address;
                    $responseary['city'] = $value->ss_aw_child_city;
                    $responseary['state'] = $value->ss_aw_child_state;
                    $responseary['pincode'] = $value->ss_aw_child_pincode;
                    $responseary['country'] = $value->ss_aw_child_country;
                    $parent_id =     $value->ss_aw_parent_id;
                }
                $data_arr = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);

                foreach ($data_arr as $value) {
                    $responseary['parent_name'] = $value->ss_aw_parent_full_name;
                }
            } else {
                $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
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

    public function update_details()
    {

        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $user_id = $inputpost['user_id'];
            $user_token = $inputpost['user_token'];
            $updateary = array();
            if ($this->check_child_existance($user_id, $user_token)) {

                $image = "";
                if (isset($_FILES["profile_pic"]['name'])) {


                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['encrypt_name'] = TRUE;
                    // $config['max_size']             = 100;
                    // $config['max_width']            = 1024;
                    // $config['max_height']           = 768;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_pic')) {
                        //echo "not success";
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                    }
                    $data = $this->upload->data();
                    $profile_pic = $data['file_name'];
                    $image = $profile_pic;
                    $updateary['ss_aw_child_profile_pic'] = $image;
                }



                if (isset($inputpost['first_name'])) {
                    $updateary['ss_aw_child_first_name'] = $inputpost['first_name'];
                }

                if (isset($inputpost['last_name'])) {
                    $updateary['ss_aw_child_last_name'] = $inputpost['last_name'];
                }

                if (isset($inputpost['fullname'])) {
                    $updateary['ss_aw_child_username'] = $inputpost['fullname'];
                }
                if (isset($inputpost['primary_mobile'])) {
                    $updateary['ss_aw_child_mobile'] = $inputpost['primary_mobile'];
                }
                if (isset($inputpost['address'])) {
                    $updateary['ss_aw_child_address'] = $inputpost['address'];
                }
                if (isset($inputpost['city'])) {
                    $updateary['ss_aw_child_city'] = $inputpost['city'];
                }
                if (isset($inputpost['state'])) {
                    $updateary['ss_aw_child_state'] = $inputpost['state'];
                }
                if (isset($inputpost['pincode'])) {
                    $updateary['ss_aw_child_pincode'] = $inputpost['pincode'];
                }

                if (isset($inputpost['country'])) {
                    $updateary['ss_aw_child_country'] = $inputpost['country'];
                    // $updateary['ss_aw_parent_country_code'] = $inputpost['country_code'];  
                    // $updateary['ss_aw_parent_country_sort_name'] = $inputpost['country_sort_name'];               
                }
                // if (isset($inputpost['secondary_mobile'])) {
                //     $updateary['ss_aw_parent_secondary_mobile'] = $inputpost['secondary_mobile'];
                // }
                // if (isset($inputpost['country_code'])) {
                //     $updateary['ss_aw_parent_country_code'] = $inputpost['country_code'];
                // }

                // if (isset($inputpost['country_sort_name'])) {
                //     $updateary['ss_aw_parent_country_sort_name'] = $inputpost['country_sort_name'];
                // }

                if (isset($inputpost['email'])) {
                    $email = $inputpost['email'];

                    $check_temp_parent_tbl = $this->diagnostic_childs_model->email_existance($email);


                    if (!$check_temp_parent_tbl) {
                        $updateary['ss_aw_child_email'] = $inputpost['email'];

                        $api_key = FRESH_DESK_API;
                        $password = FRESH_DESK_PASSWORD;
                        $yourdomain = FRESH_DESK_DOMAIN;

                        $getpaentdetails = $this->diagnostic_childs_model->get_child_profile_details($user_id);

                        $old_child_email = $getpaentdetails[0]->ss_aw_child_email;

                        $url = "https://$yourdomain.freshdesk.com/api/v2/contacts?email=$old_child_email";

                        $ch = curl_init($url);

                        curl_setopt($ch, CURLOPT_HEADER, true);
                        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $server_output = curl_exec($ch);
                        $info = curl_getinfo($ch);
                        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                        $headers = substr($server_output, 0, $header_size);
                        $response = substr($server_output, $header_size);
                        $responseary = json_decode($response, true);
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
                    // else {
                    //     $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1012');
                    //     foreach ($error_array as $value) {
                    //         $responseary['status'] = $value->ss_aw_error_status;
                    //         $responseary['msg'] = $value->ss_aw_error_msg;
                    //     }

                    //     echo json_encode($responseary);
                    //     die();
                    // }
                }

                //$password = $inputpost['password'];
                //$hash_pass = $this->bcrypt->hash_password($password);


                $updateary['ss_aw_child_modified_date'] = date('Y-m-d H:i:s');

                //$signupary['ss_aw_parent_password'] = $hash_pass;


                $result = $this->diagnostic_childs_model->update_child_details($updateary, $user_id);

                if ($result) {
                    $child_detail = $this->diagnostic_childs_model->get_child_profile_details($user_id, $user_token);
                    if (!empty($child_detail)) {
                        $email_template = getemailandpushnotification(29, 1, 1);
                        if (!empty($email_template)) {
                            $body = $email_template['body'];
                            $body = str_ireplace("[@@username@@]", $child_detail[0]->ss_aw_parent_full_name, $body);

                            $mail_data = array(
                                'ss_aw_email' => $child_detail[0]->ss_aw_parent_email,
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
                    $responseary['user_id'] = $user_id;
                    $responseary['msg'] = 'Update successfully done';
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1017');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                        $responseary['title'] = "Error";
                    }
                }
            } else {
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
    public function get_child_exam_details()
    {
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $user_id = $inputpost['user_id'];
            $user_token = $inputpost['user_token'];
            if ($this->check_child_existance($user_id, $user_token)) {
                $child_exam_details = $this->diagnostic_exam_last_lesson_model->get_exam_details_by_child_all($user_id);
                $key = 0;
                if (!empty($child_exam_details)) {
                    $responseary['status'] = 200;
                    $responseary['msg'] = "Data Found";
                    foreach ($child_exam_details as $exam_details) {
                        $responseary['data'][$key]['last_lesson'] = $exam_details->ss_aw_las_lesson_id;
                        $responseary['data'][$key]['exam_code'] = $exam_details->ss_aw_lesson_code;
                        $responseary['data'][$key]['exam_start_date'] = $exam_details->ss_aw_last_lesson_create_date != "" && $exam_details->ss_aw_last_lesson_create_date != null ? date_format(date_create($exam_details->ss_aw_last_lesson_create_date), "d-m-Y") : '';
                        $responseary['data'][$key]['exam_end_date'] = $exam_details->ss_aw_last_lesson_modified_date != "" && $exam_details->ss_aw_last_lesson_modified_date != null ? date_format(date_create($exam_details->ss_aw_last_lesson_modified_date), "d-m-Y") : '';
                        $key++;
                    }
                   
                } else {
                    $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1001');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                        $responseary['title'] = "Error";
                    }
                }
            } else {
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
}
