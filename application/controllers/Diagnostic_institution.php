<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('vendor/autoload.php');
class Diagnostic_institution extends CI_Controller
{
    protected $courseData;
    function __construct()
    {
        parent::__construct();
        $this->courseData = $this->session->userdata("course_type");
        $this->load->model('diagnostic_childs_model');
        $this->load->model('ss_aw_parents_model');
        $this->load->model('ss_aw_institutions_model');
        $this->load->model('ss_aw_adminmenus_model');
        $this->load->model('diagnostic_institution_student_upload_model');
        $this->load->model('ss_aw_schools_model');
        $this->load->model('diagnostic_child_course_model');
        $this->load->model('diagnostic_institution_payment_details_model');
        $this->load->model('diagnostic_payment_details_model');
        $this->load->model('ss_aw_courses_model');
        $this->load->model('ss_aw_email_que_model');
        $this->load->model('diagnostic_purchase_courses_model');
        $this->load->model('diagnostic_reporting_collection_model');
        $this->load->model('diagnostic_reporting_revenue_model');
        $this->load->model('diagnostic_exam_last_lesson_model');
        $this->load->model('diagnostic_upload_child_model');
        $this->load->model('ss_aw_currencies_model');
        $this->load->model('ss_aw_general_settings_model');
        $this->load->helper('custom_helper');
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
                redirect('diagnostic_institution/manage_users');
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

            if ($header_field_count != 4) {
                $this->session->set_flashdata('error', 'Please choose the correct format for Diagnostic programme.');
                redirect('diagnostic_institution/manage_users');
            }

            //save upload mster record
            $original_file_name = $this->input->post('file_name');
            $master_data = array(
                'ss_aw_upload_file_path' => 'uploads/' . $lesson_file,
                'ss_aw_upload_file_name' => $original_file_name,
                'ss_aw_program_type' => $this->input->post('programme_type')
            );
            $upload_record_id = $this->diagnostic_institution_student_upload_model->add_record($master_data);

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
            if ($this->input->post('programme_type') == 6) {
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
                                $code_check = $this->diagnostic_childs_model->child_code_check();
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
                                $child_data['ss_aw_institution_id'] = $institution_id;
                                $child_data['ss_aw_institution_user_upload_id'] = $upload_record_id;
                                $child_data['ss_aw_child_status'] = 0;
                                $child_data['ss_aw_is_self'] = 1;
                                $check_duplicate = $this->ss_aw_schools_model->check_duplicate($institution_details->ss_aw_name);
                                if ($check_duplicate == 0) {
                                    $this->ss_aw_schools_model->add_record(array('ss_aw_name' => $institution_details->ss_aw_name));
                                }



                                $response = $this->diagnostic_childs_model->add_child($child_data);

                                $upd['ss_aw_child_id'] = $response;
                                $upd['ss_aw_institutions'] = $institution_id;
                                $upd['ss_aw_program_type'] = 6;
                                $upd['student_upload_id'] = $upload_record_id;
                                $upd['created_by'] = $parent_id;

                                $this->diagnostic_upload_child_model->store_data($upd);

                                if (!empty($response)) {
                                    $success++;
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
            $msg = "User added successfully. Please Make Payment First";
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
            $this->diagnostic_institution_student_upload_model->update_record($update_data, $upload_record_id);
            $this->session->set_flashdata('success', $msg);
            redirect('diagnostic_institution/manage_payment');
        } else {
            if (!empty($existing_emails)) {
                $existing_emails_string = implode(",", $existing_emails);
                $msg .= "The following emails already exists in the system (" . $existing_emails_string . ").";
            }
            if (!empty($existing_usernames)) {
                $existing_usernames_string = implode(",", $existing_usernames);
                $msg .= "The following user ids already exists in the system (" . $existing_usernames_string . ").";
            }
            $this->diagnostic_institution_student_upload_model->remove_record($upload_record_id);
            $this->session->set_flashdata('error', $msg);
        }

        redirect('diagnostic_institution/manage_users');
    }
    public function manage_users()
    {

        $headerdata = $this->checklogin();
        $headerdata['title'] = "";
        $data = array();
        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;

        // $get_parent=$this->ss_aw_parent_model->
        //if search by any data
        $search_data = "";
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $search_data = $postdata['search_data'];
        }
        $data['search_data'] = $search_data;
        $total_record = $this->diagnostic_upload_child_model->total_diagnostic_users($institution_id, $search_data, 1);


        $redirect_to = base_url() . 'diagnostic_institution/manage_users';
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
        $result = $this->diagnostic_upload_child_model->get_diagnostic_users_by_parents_ary($institution_id, $config['per_page'], $page, $search_data, 1);

        $data['page'] = $page;
        $diagnostictotalquestion = array();
        $diagnosticcorrectquestion = array();
        $diagnosticexamdate = array();

        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $child_id = $value->ss_aw_child_id;
                $duration = "";

                $childary = $this->diagnostic_child_course_model->get_details($child_id);
                if (!empty($childary)) {
                    $value->course = $childary[count($childary) - 1]['ss_aw_course_id'];

                    //get child course details
                    $course_details[$value->ss_aw_child_id] = $this->diagnostic_childs_model->get_details_with_course($value->ss_aw_child_id);
                    //end	
                }
            }
        }

        $data['child_details'] = $result;
        $data['diagnostictotalquestion'] = $diagnostictotalquestion;
        $data['diagnosticcorrectquestion'] = $diagnosticcorrectquestion;
        $data['diagnosticexamdate'] = $diagnosticexamdate;
        $data['course_details'] = $course_details;
        $data['course_type'] = 2;

        $this->loadView('diagnostic/institution/manage_user', $headerdata, $data);
    }
    public function edit_user()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Edit User";
        if ($this->input->post()) {
            $postdata = $this->input->post();
            $pageno = $postdata['pageno'];
            // $parent_id = $postdata['parent_id'];
            // $parent_data = array();
            // $parent_data['ss_aw_parent_full_name'] = $postdata['firstname'] . " " . $postdata['lastname'];
            // $parent_data['ss_aw_parent_email'] = $postdata['email'];
            // if (!empty($postdata['password'])) {
            //     $parent_data['ss_aw_parent_password'] = @$this->bcrypt->hash_password($postdata['password']);
            // }
            // $this->ss_aw_parents_model->update_parent_details($parent_data, $parent_id);
            $child_data = array();
            $child_data['ss_aw_child_nick_name'] = $postdata['nickname'];
            $child_data['ss_aw_child_first_name'] = $postdata['firstname'];
            $child_data['ss_aw_child_last_name'] = $postdata['lastname'];
            $child_data['ss_aw_child_gender'] = $postdata['master_gender'];
            $child_data['ss_aw_child_email'] = $postdata['email'];
            if (!empty($postdata['password'])) {
                $child_data['ss_aw_child_password'] = @$this->bcrypt->hash_password($postdata['password']);
            }
            $this->diagnostic_childs_model->update_child_details($child_data, $postdata['user_id']);
            $this->session->set_flashdata('success', 'Record updated successfully.');
            redirect('diagnostic_institution/manage_users/' . $pageno);
        } else {
            $data = array();
            $child_id = $this->uri->segment(3);
            $page = $this->uri->segment(4);
            $self_details = array();
            $child_details = array();
            $child_details = $this->diagnostic_childs_model->get_child_detail_by_id($child_id);
            if (!empty($child_details)) {
                if (empty($child_details[0]->ss_aw_child_username)) {
                    $self_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($child_details[0]->ss_aw_parent_id);
                }
            }
            $data['child_details'] = $child_details;
            $data['self_details'] = $self_details;
            $data['page'] = $page;
            $this->loadView('diagnostic/institution/edit-user', $headerdata, $data);
        }
    }
    public function manage_payment()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Manage Payments";
        $data = array();
        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;
        $result = $this->diagnostic_institution_student_upload_model->get_institution_upload_records($institution_id);

        $data['result'] = $result;
        $this->loadView('diagnostic/institution/managepayments', $headerdata, $data);
    }
    public function upload_user_list()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Uploaded Users List";
        $data = array();
        $upload_record_id = $this->uri->segment(3);
        $user_upload_details = $this->diagnostic_institution_student_upload_model->get_record_by_id($upload_record_id);
        $result = $this->diagnostic_upload_child_model->get_record_by_upload_id($upload_record_id);

        $lessoncount = array();
        $assessmentcount = array();
        $readalongcount = array();
        $diagnostictotalquestion = array();
        $diagnosticcorrectquestion = array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $child_id = $value->ss_aw_child_id;
                $duration = "";
                $childary = $this->diagnostic_child_course_model->get_details($child_id);

                if (!empty($childary)) {
                    $value->course = $childary[count($childary) - 1]['ss_aw_course_id'];
                    $course_start_date = $childary[count($childary) - 1]['ss_aw_child_course_create_date'];
                    $lessoncount[$value->ss_aw_child_id] = $this->diagnostic_exam_last_lesson_model->gettotalcompletenum($value->ss_aw_child_id, $course_start_date);
                    //get child course details
                    $course_details[$value->ss_aw_child_id] = $this->diagnostic_childs_model->get_details_with_course($value->ss_aw_child_id);
                    //end
                }
            }
        }

        $data['child_details'] = $result;
        $data['course_details'] = $course_details;
        $data['user_upload_details'] = $user_upload_details;
        $this->loadView('diagnostic/institution/uploadeduserslist', $headerdata, $data);
    }
    public function check_pan_gst()
    {
        $excel_upload_id = $this->input->post('excel_upload_id');
        $upload_details = $this->diagnostic_institution_student_upload_model->get_record_by_id($excel_upload_id);
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
    public function make_payment()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Make Payment";
        $upload_id = $this->uri->segment(3);

        $data = array();

        $upload_details = $this->diagnostic_institution_student_upload_model->get_record_by_id($upload_id);

        $payment_history = array();
        $payment_history = $this->diagnostic_institution_payment_details_model->gethistory($upload_details->ss_aw_id);
        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;
        $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);

        $check_payment = $this->diagnostic_institution_payment_details_model->check_lumpsum_payment($upload_id);
        if ($check_payment > 0) {
            $this->session->set_flashdata('success', 'Payment already done.');
            redirect('diagnostic_institution/manage_payment');
        }

        $data['upload_details'] = $upload_details;
        $data['institution_details'] = $institution_details;
        $data['institution_admin_details'] = $institution_admin_details;
        if (!empty($payment_history)) {
            $data['payment_history'] = json_encode($payment_history);
        } else {
            $data['payment_history'] = "";
        }
        $this->loadView('diagnostic/institution/makepayments', $headerdata, $data);
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
            $invoice_prefix = "ALWS/DIST/";
            $invoice_suffix = "/" . date('m') . date('y');
            $get_last_invoice_details = $this->diagnostic_institution_payment_details_model->get_last_record();
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
            $paid_childs_id = array();
            $childs = $this->diagnostic_upload_child_model->get_record_by_upload_id($excel_upload_id);

            if (!empty($childs)) {
                foreach ($childs as $key => $value) {
                    $paid_childs[] = $value->ss_aw_child_id;
                    $paid_childs_id[] = $value->id;
                    $student_upload_details = $this->diagnostic_institution_student_upload_model->get_record_by_id($excel_upload_id);
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
                        } elseif ($course_id == 6) {
                            $email_template = getemailandpushnotification(70, 1, 2);
                            $app_template = getemailandpushnotification(70, 2, 2);
                            $action_id = 11;
                            $course_name = Diagnostic;
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
                            $body = str_ireplace("[@@login_id@@]", $course_id == 6 ? $value->ss_aw_child_email : $value->ss_aw_child_username, $body);
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

            $save_payment = $this->diagnostic_institution_payment_details_model->add_record($data);

            $parent_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
            if ($save_payment) {
                //payment confirmation email notification.
                if ($course_id == 1) {
                    $course_name = Winners;
                } elseif ($course_id == 3) {
                    $course_name = Champions;
                } elseif ($course_id == 6) {
                    $course_name = Diagnostic;
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

            //end
            //check first lumpsum payment
            $prev_payment_details = $this->diagnostic_institution_payment_details_model->gethistory($excel_upload_id);
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
                    $cid = 0;
                    foreach ($paid_childs as $child_id) {
                        $invoice_prefix = "ALWS/";
                        $invoice_suffix = "/" . date('m') . date('y');
                        $get_last_invoice_details = $this->diagnostic_payment_details_model->get_last_invoice();
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
                        $child_details = $this->diagnostic_childs_model->get_child_detail_by_id($child_id);

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
                        $courseary = $this->diagnostic_purchase_courses_model->data_insert($searary);

                        $payment_invoice_file_path = base_url() . "payment_invoice/" . $filename;
                        $searary = array();
                        $searary['ss_aw_child_id'] = $child_id;
                        $searary['ss_aw_course_id'] = $course_id;
                        if ($payment_type != 1) {
                            $searary['ss_aw_course_payemnt_type'] = 1;
                        }

                        //if lumpsum partial payment on and this is second payment then the course and payment details table payment date populate with the first partial payment date.
                        if ($payment_type == 1) {
                            if (count($prev_payment_details) > 0) {
                                $searary['ss_aw_child_course_create_date'] = $prev_payment_details[0]->ss_aw_created_date;
                            }
                        }

                        $searary['upload_child_id'] = $paid_childs_id[$cid];
                        $courseary = $this->diagnostic_child_course_model->data_insert($searary);

                        $last_lesson = array();
                        $last_lesson['ss_aw_child_id'] = $child_id;
                        $last_lesson['upload_child_id'] = $paid_childs_id[$cid];
                        $last_lesson['ss_aw_lesson_level'] = 6;
                        $last_lesson['ss_aw_lesson_id'] = 6;

                        $this->diagnostic_exam_last_lesson_model->insert_data($last_lesson);



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
                        if ($payment_type == 1) {
                            if (count($prev_payment_details) > 0) {
                                $searary['ss_aw_created_date'] = $prev_payment_details[0]->ss_aw_created_date;
                            }
                        }
                        $courseary = $this->diagnostic_payment_details_model->data_insert($searary);

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

                        $resporting_collection_insertion = $this->diagnostic_reporting_collection_model->store_data($reporting_collection_data);
                        $general_setting = $this->ss_aw_general_settings_model->fetch_record();
                        if ($payment_type == 1) {
                            if ($course_id == 1 || $course_id == 2) {
                                $fixed_course_duration = WINNERS_DURATION;
                                $course_duration = WINNERS_DURATION;
                            } elseif ($course_id == 3) {
                                $fixed_course_duration = CHAMPIONS_DURATION;
                                $course_duration = CHAMPIONS_DURATION;
                            } elseif ($course_id == 6) {
                                $fixed_course_duration = $general_setting[0]->ss_aw_diagnostic_purchase_restriction;
                                $course_duration = $general_setting[0]->ss_aw_diagnostic_purchase_restriction;
                            } else {
                                $fixed_course_duration = MASTERS_DURATION;
                                $course_duration = MASTERS_DURATION;
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

                                $this->diagnostic_reporting_revenue_model->store_data($reporting_revenue_data);

                                $count++;
                            }
                        }

                        //update child and parent status to active
                        $this->diagnostic_childs_model->update_child_details(array('ss_aw_child_status' => 1), $child_id);
                        $child_prent_details = $this->diagnostic_childs_model->get_child_detail_by_id($child_id);
                        if (!empty($child_prent_details)) {
                            $childs_parent_id = $child_prent_details[0]->ss_aw_parent_id;
                            $this->ss_aw_parents_model->update_parent_details(array('ss_aw_parent_status' => 1), $childs_parent_id);
                        }
                        //end
                        $cid++;
                    }

                    $update_upload_data = array(
                        'ss_aw_payment_type' => $payment_type
                    );
                    $this->diagnostic_institution_student_upload_model->update_record($update_upload_data, $excel_upload_id);
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
    public function create_new_group()
    {
        $postdata = $this->input->post();
        $headerdata = $this->checklogin();
        $headerdata['title'] = "";
        $data = array();
        $count_user = "";

        $institution_admin_id = $this->session->userdata('id');
        $institute_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($institution_admin_id);
        $institution_id = $institute_admin_details[0]->ss_aw_institution;

        if (!empty($postdata['user_id_data'])) {
            $user_id_data = json_decode($postdata['user_id_data']);
            $count_user = count($user_id_data);
        }

        $data['ss_aw_institution_id'] = $institution_id;
        $data['ss_aw_student_number'] = $count_user;
        $data['ss_aw_upload_file_name'] = $postdata['group_name'];
        $data['ss_aw_program_type'] = 6;
        $data['ss_aw_payment_type'] = 1;

        $upload_record_id = $this->diagnostic_institution_student_upload_model->add_record($data);
        if ($upload_record_id != '' && $count_user != "") {
            foreach ($user_id_data as $user_id) {
                $upd['ss_aw_child_id'] = $user_id;
                $upd['ss_aw_institutions'] = $institution_id;
                $upd['ss_aw_program_type'] = 6;
                $upd['student_upload_id'] = $upload_record_id;
                $upd['created_by'] = $institution_admin_id;
                $this->diagnostic_upload_child_model->store_data($upd);
            }
        }

        redirect(base_url("diagnostic_institution/make_payment/" . $upload_record_id));
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
        redirect('diagnostic_institution/manage_payment');
    }
    public function course_details()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Course Details";
        $data = array();
        $data['result'] = $this->ss_aw_courses_model->get_all_data();
        $data['curerncy'] = $this->ss_aw_currencies_model->get_all_currency();

        $search_data = array();


        $this->loadView('diagnostic/institution/coursedetails', $headerdata, $data);
    }
    public function payment_history()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Payment History";
        $data = array();
        $parent_id = $this->session->userdata('id');
        $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
        $institution_id = $institution_admin_details[0]->ss_aw_institution;

        $total_record = $this->diagnostic_institution_payment_details_model->total_record($institution_id);
        $redirect_to = base_url() . 'diagnostic_institution/payment_histoty';
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
        $payment_history = $this->diagnostic_institution_payment_details_model->get_payment_details($institution_id, $config['per_page'], $page);

        $data['payment_history'] = $payment_history;

        $this->loadView('diagnostic/institution/payment_history', $headerdata, $data);
    }

    public function diagnostic_mis()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Diagnostic MIS";
        $data = array();
        $this->loadView('diagnostic/institution/diagnostic_mis', $headerdata, $data);
    }

    public function diagnostic_mis_sec()
    {
        $headerdata = $this->checklogin();
        $headerdata['title'] = "Diagnostic MIS 2";
        $data = array();
        $this->loadView('diagnostic/institution/diagnostic_mis_sec', $headerdata, $data);
    }

    public function user_course_details()
    {

        $headerdata = $this->checklogin();
        $headerdata['title'] = "Diagnostic MIS";
        $data = array();
        $this->loadView('diagnostic/institution/course_details', $headerdata, $data);
    }




    public function check_email_existance($email)
    {
        $child_email_response = $this->diagnostic_childs_model->check_email($email);
        if (empty($child_email_response)) {
            return 1;
        } else {
            return 0;
        }
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
                    if ($this->courseData == "diagnostic" && in_array($val2['ss_aw_id'], ["69", "70", "71", "72", "73"])) {
                        continue;
                    }
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
                    if ($this->courseData == "diagnostic" && in_array($val['ss_aw_id'], ["69", "70", "71", "72", "73"])) {
                        continue;
                    }
                    if (trim($val['ss_aw_menu_category_id']) == 0) {
                        $admin_menu_ary[$val['ss_aw_id']][0]['menu_icon'] = $val['ss_aw_menu_icon'];
                        $admin_menu_ary[$val['ss_aw_id']][0]['page'] = $val['ss_aw_menu_name'];
                        $admin_menu_ary[$val['ss_aw_id']][0]['link'] = $val['ss_aw_adminusers_pagelink'];
                    }
                }
            }
            foreach ($adminmenuary as $val) {
                if (in_array($val['ss_aw_id'], $user_role_ids_ary)) {
                    if ($this->courseData == "diagnostic" && in_array($val['ss_aw_id'], ["69", "70", "71", "72", "73"])) {
                        continue;
                    }
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
    public function loadView($viewName, $headerData = array(), $pageData = array())
    {
        $this->load->view('diagnostic/header', $headerData);
        $this->load->view($viewName, $pageData);
    }
}
