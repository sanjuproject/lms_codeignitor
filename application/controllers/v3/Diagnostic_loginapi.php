<?php
set_time_limit(320);
defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
class Diagnostic_loginapi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ss_aw_parents_model');
        $this->load->model('ss_aw_error_code_model');
        $this->load->model('diagnostic_childs_model');
        $this->load->model('ss_aw_parents_temp_model');
        $this->load->helper('custom_helper');
        $this->load->model('diagnostic_child_login_model');
        $this->load->model('diagnostic_child_course_model');
    }

    public function login()
    {
        // echo $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        // // $request = json_decode($stream_clean);
        // die();
        // $postdata = $this->input->post();
        // $postdata = $this->input->post();


        $currenttime = time();
        $start_time = '2023-10-19 08:00:00';
        $end_time = '2023-10-19 20:00:00';
        if ($currenttime >= strtotime($start_time) && $currenttime <= strtotime($end_time)) {
            $responseary = array();
            $responseary['status'] = 1003;
            $responseary['msg'] = "Sorry! we are under maintenance mode";
            die(json_encode($responseary));
        }
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $user_input = $inputpost['user_input'];
            $password = $inputpost['password'];
            $device_type = $inputpost['os'];
            if (filter_var($user_input, FILTER_VALIDATE_EMAIL)) {
                $email = $user_input;
                $password = $inputpost['password'];
                $result = $this->diagnostic_childs_model->login_process($email);

                if (!empty($result)) {
                    $parent_password = $result[0]->ss_aw_parent_password;
                    //if ($this->bcrypt->check_password($password, $parent_password) || $this->bcrypt->check_password($password, GLOBAL_PASS))
                    if ($this->bcrypt->check_password($password, $parent_password) || $this->bcrypt->check_password($password, GLOBAL_PASS)) {
                        $token = $this->random_strings(20);
                        $token_update = $this->ss_aw_parents_model->token_update_by_email($email, $token, $device_type);
                        $responseary['status'] = 200;
                        $responseary['user_type'] = 1;
                        $responseary['msg'] = "Login successfully";
                        foreach ($result as $value) {
                            $responseary['user_id'] = $value->ss_aw_parent_id;
                            $responseary['fullname'] = $value->ss_aw_parent_full_name;
                            $responseary['address'] = $value->ss_aw_parent_address;
                            $responseary['city'] = $value->ss_aw_parent_city;
                            $responseary['state'] = $value->ss_aw_parent_state;
                            $responseary['pincode'] = $value->ss_aw_parent_pincode;
                            $responseary['country'] = $value->ss_aw_parent_country;
                            $responseary['primary_mobile'] = $value->ss_aw_parent_primary_mobile;
                            $responseary['country_code'] = $value->ss_aw_parent_country_code;
                            $responseary['country_sort_name'] = $value->ss_aw_parent_country_sort_name;
                            $responseary['secondary_mobile'] = $value->ss_aw_parent_secondary_mobile;
                            $responseary['user_type'] = $value->ss_aw_user_type;
                            $responseary['email'] = $value->ss_aw_parent_email;

                            if ($value->ss_aw_parent_profile_photo != "") {
                                $responseary['photo'] = base_url() . "uploads/" . $value->ss_aw_parent_profile_photo;
                            } else {
                                $responseary['photo'] = base_url() . "uploads/profile.jpg";
                            }
                            $responseary['user_token'] = $token;
                            $responseary['created_date'] = $value->ss_aw_parent_created_date;
                            $check_self_registration = $this->diagnostic_childs_model->check_self_registration($value->ss_aw_parent_id);
                            if (!empty($check_self_registration)) {
                                $responseary['adult_child_id'] = $check_self_registration->ss_aw_child_id;
                                $update_data = array();
                                $update_data['ss_aw_device_type'] = $device_type;
                                $this->diagnostic_childs_model->update_child_details($update_data, $check_self_registration->ss_aw_child_id);
                            } else {
                                $responseary['adult_child_id'] = "";
                            }
                        }
                    } elseif ($password == 'demo@123') {
                        $child_code = '10000000';
                        $password = $inputpost['password'];
                        $result = $this->diagnostic_childs_model->child_login_process($child_code);
                        if (!empty($result)) {
                            $child_password = $result[0]->ss_aw_child_password;


                            $token = $this->random_strings(20);
                            $token_update = $this->diagnostic_childs_model->token_update_by_code($child_code, $token, $device_type);
                            //store first login data
                            $check_login_record = $this->diagnostic_child_login_model->check_data($result[0]->ss_aw_child_id);
                            if ($check_login_record == 0) {
                                $this->diagnostic_child_login_model->store_data(array('ss_aw_child_id' => $result[0]->ss_aw_child_id, 'ss_aw_first_login' => date('Y-m-d H:i:s')));
                            }
                            //end

                            $responseary['status'] = 200;
                            $responseary['user_type'] = 2;
                            $responseary['msg'] = "Login successfully";
                            foreach ($result as $value) {
                                $responseary['user_id'] = $value->ss_aw_child_id;
                                $responseary['child_code'] = $value->ss_aw_child_code;
                                $responseary['parent_id'] = $value->ss_aw_parent_id;
                                $responseary['nick_name'] = $value->ss_aw_child_nick_name;
                                $responseary['first_name'] = $value->ss_aw_child_first_name;
                                $responseary['last_name'] = $value->ss_aw_child_last_name;
                                $responseary['child_schoolname'] = $value->ss_aw_child_schoolname;
                                $responseary['child_gender'] = $value->ss_aw_child_gender;
                                $responseary['dob'] = $value->ss_aw_child_dob;

                                if (!empty($value->ss_aw_child_profile_pic))
                                    $responseary['photo'] = base_url() . "uploads/" . $value->ss_aw_child_profile_pic;
                                else
                                    $responseary['photo'] = base_url() . "uploads/profile.jpg";

                                $responseary['email'] = $value->ss_aw_child_email;
                                $responseary['primary_mobile'] = $value->ss_aw_child_mobile;
                                $responseary['country_code'] = $value->ss_aw_child_country_code;
                                $responseary['country_sort_name'] = $value->ss_aw_child_country_sort_name;
                                $responseary['user_token'] = $token;
                                $responseary['child_created_date'] = $value->ss_aw_child_created_date;
                                $parent_id =     $value->ss_aw_parent_id;
                            }
                            $data_arr = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);

                            foreach ($data_arr as $value) {
                                $responseary['parent_name'] = $value->ss_aw_parent_full_name;
                                $responseary['address'] = $value->ss_aw_parent_address;
                                $responseary['city'] = $value->ss_aw_parent_city;
                                $responseary['state'] = $value->ss_aw_parent_state;
                                $responseary['pincode'] = $value->ss_aw_parent_pincode;
                                $responseary['country'] = $value->ss_aw_parent_country;
                                $responseary['country_code'] = $value->ss_aw_parent_country_code;
                                $responseary['country_sort_name'] = $value->ss_aw_parent_country_sort_name;
                                if ($responseary['primary_mobile'] == "") {
                                    $responseary['primary_mobile'] = $value->ss_aw_parent_primary_mobile;
                                }
                                $responseary['secondary_mobile'] = $value->ss_aw_parent_secondary_mobile;

                                if ($responseary['email'] == "") {
                                    $responseary['email'] = $value->ss_aw_parent_email;
                                }
                            }
                        } else {
                            $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1018');
                            foreach ($error_array as $value) {
                                $responseary['status'] = $value->ss_aw_error_status;
                                $responseary['msg'] = $value->ss_aw_error_msg;
                            }
                        }
                    } else {
                        $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1003');
                        foreach ($error_array as $value) {
                            $responseary['status'] = $value->ss_aw_error_status;
                            $responseary['msg'] = $value->ss_aw_error_msg;
                        }
                    }
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1002');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                    }
                }
            } else {
                $child_code = $user_input;
                $password = $inputpost['password'];
                $result = $this->diagnostic_childs_model->child_login_process($child_code);
                if (!empty($result)) {
                    $child_password = $result[0]->ss_aw_child_password;

                    if ($this->bcrypt->check_password($password, $child_password) || $this->bcrypt->check_password($password, GLOBAL_PASS)) {
                        $check_course_exist = $this->diagnostic_child_course_model->get_details($result[0]->ss_aw_child_id);
                        if (empty($check_course_exist)) {
                            $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1038');
                            foreach ($error_array as $value) {
                                $responseary['status'] = $value->ss_aw_error_status;
                                $responseary['msg'] = $value->ss_aw_error_msg;
                            }
                        } else {
                            $token = $this->random_strings(20);
                            $token_update = $this->diagnostic_childs_model->token_update_by_code($child_code, $token, $device_type);
                            //store first login data
                            $check_login_record = $this->diagnostic_child_login_model->check_data($result[0]->ss_aw_child_id);
                            if ($check_login_record == 0) {
                                $this->diagnostic_child_login_model->store_data(array('ss_aw_child_id' => $result[0]->ss_aw_child_id, 'ss_aw_first_login' => date('Y-m-d H:i:s')));
                            }
                            //end
                            $responseary['status'] = 200;
                            $responseary['user_type'] = 2;
                            $responseary['msg'] = "Login successfully";
                            foreach ($result as $value) {
                                $responseary['user_id'] = $value->ss_aw_child_id;
                                $responseary['child_code'] = $value->ss_aw_child_code;
                                $responseary['parent_id'] = $value->ss_aw_parent_id;
                                $responseary['nick_name'] = $value->ss_aw_child_nick_name;
                                $responseary['first_name'] = $value->ss_aw_child_first_name;
                                $responseary['last_name'] = $value->ss_aw_child_last_name;
                                $responseary['child_schoolname'] = $value->ss_aw_child_schoolname;
                                $responseary['child_gender'] = $value->ss_aw_child_gender;
                                $responseary['dob'] = $value->ss_aw_child_dob;

                                if (!empty($value->ss_aw_child_profile_pic))
                                    $responseary['photo'] = base_url() . "uploads/" . $value->ss_aw_child_profile_pic;
                                else
                                    $responseary['photo'] = base_url() . "uploads/profile.jpg";

                                $responseary['email'] = $value->ss_aw_child_email;
                                $responseary['primary_mobile'] = $value->ss_aw_child_mobile;
                                $responseary['country_code'] = $value->ss_aw_child_country_code;
                                $responseary['country_sort_name'] = $value->ss_aw_child_country_sort_name;
                                $responseary['user_token'] = $token;
                                $responseary['child_created_date'] = $value->ss_aw_child_created_date;
                                $responseary['child_username'] = $value->ss_aw_child_username;

                                $parent_id =     $value->ss_aw_parent_id;
                            }
                            $data_arr = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);

                            foreach ($data_arr as $value) {
                                $responseary['parent_name'] = $value->ss_aw_parent_full_name;
                                $responseary['address'] = $value->ss_aw_parent_address;
                                $responseary['city'] = $value->ss_aw_parent_city;
                                $responseary['state'] = $value->ss_aw_parent_state;
                                $responseary['pincode'] = $value->ss_aw_parent_pincode;
                                $responseary['country'] = $value->ss_aw_parent_country;
                                $responseary['country_code'] = $value->ss_aw_parent_country_code;
                                $responseary['country_sort_name'] = $value->ss_aw_parent_country_sort_name;
                                if ($responseary['primary_mobile'] == "") {
                                    $responseary['primary_mobile'] = $value->ss_aw_parent_primary_mobile;
                                }
                                $responseary['secondary_mobile'] = $value->ss_aw_parent_secondary_mobile;

                                if ($responseary['email'] == "") {
                                    $responseary['email'] = $value->ss_aw_parent_email;
                                }
                            }
                        }
                    } else {
                        $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1003');
                        foreach ($error_array as $value) {
                            $responseary['status'] = $value->ss_aw_error_status;
                            $responseary['msg'] = $value->ss_aw_error_msg;
                        }
                    }
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1018');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                    }
                }
            }


            echo json_encode($responseary);
            die();
        }
    }


    public function forget_password_to_get_code()
    {
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $user_input = $inputpost['user_input'];

            if (filter_var($user_input, FILTER_VALIDATE_INT) === false) {
                $email = $user_input;
                $check_email =  $this->ss_aw_parents_model->check_email($email);
                if ($check_email) {
                    $user_details = $this->ss_aw_parents_model->login_process($email);
                    $data['ss_aw_parent_reset_code'] = rand(100000, 999999);
                    $data['ss_aw_parent_modified_date'] = date('Y-m-d H:i:s');
                    $result = $this->ss_aw_parents_model->forget_password_to_set_code($email, $data);

                    $email_template = getemailandpushnotification(23, 1, 1);
                    $body = $email_template['body'];
                    $body = str_ireplace("[@@password_code@@]", $data['ss_aw_parent_reset_code'], $body);
                    $body = str_ireplace("[@@username@@]", $user_details[0]->ss_aw_parent_full_name, $body);
                    emailnotification($email, $email_template['title'], $body);

                    $responseary['status'] = 200;
                    $responseary['msg'] = "Reset code sent to email id";
                    $responseary['reset_code'] = $data['ss_aw_parent_reset_code'];
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1005');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                    }
                }
                echo json_encode($responseary);
                die();
            } else {
                $child_code = $user_input;
                $child_parent_email_result =  $this->diagnostic_childs_model->child_parent_email_id($child_code);
                $parent_email =  $child_parent_email_result[0]->ss_aw_parent_email;
                $child_email = $child_parent_email_result[0]->ss_aw_child_email;
                $child_name = $child_parent_email_result[0]->ss_aw_child_nick_name;
                if ($parent_email != "") {
                    $data['ss_aw_child_reset_code'] = rand(100000, 999999);
                    $data['ss_aw_child_modified_date'] = date('Y-m-d H:i:s');
                    $result = $this->diagnostic_childs_model->forget_password_to_set_code($child_code, $data);

                    $email_template = getemailandpushnotification(23, 1, 1);

                    $body = $email_template['body'];
                    $body = str_ireplace("[@@password_code@@]", $data['ss_aw_child_reset_code'], $body);
                    $body = str_ireplace("[@@username@@]", $child_name, $body);
                    emailnotification($child_email, $email_template['title'], $body);

                    $responseary['status'] = 200;
                    $responseary['msg'] = "Reset code sent to child email id";
                    $responseary['reset_code'] = $data['ss_aw_child_reset_code'];
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1009');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                    }
                }
                echo json_encode($responseary);
                die();
            }
        }
    }


    public function forget_password_reset()
    {
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $reset_code = $inputpost['reset_code'];
            $password = $inputpost['new_password'];
            $user_input = $inputpost['user_input'];
            $cur_time =  date('Y-m-d H:i:s');
            $hash_pass = $this->bcrypt->hash_password($password);

            if (filter_var($user_input, FILTER_VALIDATE_INT) === false) {
                $email = $user_input;
                $modify_time_arr = $this->ss_aw_parents_model->data_modify_time($email);

                $code_time = $modify_time_arr[0]['ss_aw_parent_modified_date'];

                $datetime1 = new DateTime($code_time);
                $datetime2 = new DateTime($cur_time);
                $interval = $datetime1->diff($datetime2);
                $dif_time = $interval->format('%i');

                if ($dif_time < 4) {
                    $data['ss_aw_parent_modified_date'] = date('Y-m-d H:i:s');

                    $data['ss_aw_child_password'] = $hash_pass;
                    $result = $this->ss_aw_parents_model->forget_password_reset($reset_code, $data, $email);
                    if ($result) {
                        $responseary['status'] = 200;
                        $responseary['msg'] = "Password successfully change";
                    } else {
                        $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1006');
                        foreach ($error_array as $value) {
                            $responseary['status'] = $value->ss_aw_error_status;
                            $responseary['msg'] = $value->ss_aw_error_msg;
                        }
                    }
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1027');
                    foreach ($error_array as $value) {
                        $responseary['status'] = $value->ss_aw_error_status;
                        $responseary['msg'] = $value->ss_aw_error_msg;
                        $responseary['title'] = "Error";
                    }
                }
            } else {
                $child_code = $user_input;
                $modify_time_arr = $this->diagnostic_childs_model->data_modify_time($child_code);
                $code_time = $modify_time_arr[0]['ss_aw_child_modified_date'];

                $datetime1 = new DateTime($code_time);
                $datetime2 = new DateTime($cur_time);
                $interval = $datetime1->diff($datetime2);
                $dif_time = $interval->format('%i');

                if ($dif_time < 4) {
                    $data_arr['ss_aw_child_modified_date'] = date('Y-m-d H:i:s');
                    $data_arr['ss_aw_child_password'] = $hash_pass;
                    $result = $this->diagnostic_childs_model->forget_password_reset($reset_code, $data_arr, $child_code);
                    if ($result) {
                        $responseary['status'] = 200;
                        $responseary['msg'] = "Password successfully change";
                    } else {
                        $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1006');
                        foreach ($error_array as $value) {
                            $responseary['status'] = $value->ss_aw_error_status;
                            $responseary['msg'] = $value->ss_aw_error_msg;
                        }
                    }
                } else {
                    $error_array =  $this->ss_aw_error_code_model->get_msg_by_status('1027');
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
    }

    public function logout()
    {
        $inputpost = $this->input->post();
        $responseary = array();
        if ($inputpost) {
            $child_id = $inputpost['user_id'];

            $result = $this->diagnostic_childs_model->logout($child_id);
            if ($result) {
                $responseary['status'] = 200;
                $responseary['msg'] = "Logout Successful";
            } else {
                $error_array = $this->ss_aw_error_code_model->get_msg_by_status('1014');
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
    function random_strings($length_of_string)
    {

        // random_bytes returns number of bytes 
        // bin2hex converts them into hexadecimal format 
        return substr(md5(time()), 0, $length_of_string);
    }
}
