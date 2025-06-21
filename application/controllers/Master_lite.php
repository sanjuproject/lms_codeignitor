<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('vendor/autoload.php');

class Master_lite extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("ss_aw_master_lite_model");
        $this->load->model('ss_aw_parents_model');
        $this->load->model('ss_aw_adminmenus_model');
        $this->load->model('ss_aw_lessons_uploaded_model');
        $this->load->model('ss_aw_sections_topics_model');
        $this->load->model('ss_aw_assesment_uploaded_model');
        $this->load->model('ss_aw_current_lesson_model');
        $this->load->model('ss_aw_childs_model');
        $this->load->model('ss_aw_child_course_model');
        $this->load->model('ss_aw_child_last_lesson_model');
        $this->load->model('ss_aw_lessons_model');
        $this->load->model('ss_aw_lesson_score_model');
        $this->load->model('ss_aw_assessment_exam_completed_model');
        $this->load->model('ss_aw_assisment_diagnostic_model');
        $this->load->model('ss_aw_assessment_subsection_matrix_model');
        $this->load->model('ss_aw_assesment_questions_asked_model');
        $this->load->model('ss_aw_assessment_score_model');
        $this->load->model('ss_aw_assesment_multiple_question_asked_model');
        $this->load->model('ss_aw_assesment_multiple_question_answer_model');
        $this->load->model('ss_aw_lesson_quiz_ans_model');
        $this->load->model('ss_aw_lesson_quiz_ans_model');
        $this->load->model('ss_aw_assessment_exam_log_model');
        $this->load->model('ss_aw_master_lite_access_given_model');

        $this->load->helper("custom_helper");
    }

    public function get_all_student_not_completed_in_time()
    {
        $headerdata['title'] = "Alsowise student data";
        $master_data = $this->ss_aw_master_lite_model->get_all_master_data();
       

        if (!empty($master_data)) {
            $data = array();
            $date = date('jS F , Y', strtotime(' -1 day'));
            $subject = "MLP Report for $date";
            $email = "sanju.malik@schemaphic.com";
            $cc = "";
            // $email = "ateesh@alsowise.com";
            // $cc = "deepanjan@schemaphic.com";
            $data['attachment'] = $this->getExcelfileName($master_data);
            if ($data['attachment'] != '') {
                $msg = $this->load->view("mail_template/mail_child_template", $data, true);
                $mail = emailnotification($email, $subject, $msg, $cc);

                if ($mail) {
                    echo "Mail send successfully";
                    exit;
                } else {
                    echo "Error ! can not send mail";
                    exit;
                }
            } else {
                echo "No data found";
                exit;
            }
        } else {
            echo "No user in table";
            exit;
        }
    }

    public function getExcelfileName($master_data)
    {
        // load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $col = 0;
        $row = 1;
        // $objPHPExcel->getActiveSheet()->setAutoSize(true);

        $styleArrayFirstRow = [
            'font' => [
                'bold' => true,
                'startcolor' => array('rgb' => '788871'),
                'size' => 8,
                'name' => 'Verdana'
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $rowColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'FFFF00' //Yellow
            )
        );
        $link_style_array = array(
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '0000FF'],
                'underline' => 'single',
                'size' => 8,
                //'name' => 'Verdana'
            ]
        );
        ob_start();
        $border_style = array('borders' => array('allborders' => array('style' =>
        PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '766f6e'),)));

        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArrayFirstRow);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'User Id');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'User Name');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Institution Name');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Diagonastic Exam Date');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Topic Name');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Lesson available date');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Lesson completed date');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Assessment completed date');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, 'Update');
        $row_count = 0;
        if (!empty($master_data)) {
            foreach ($master_data->result() as $mas) {
                $diagonastic_diff = $this->date_difference($mas->ss_aw_diagonastic_exam_date);
                $lesson_diff = $this->date_difference($mas->ss_aw_last_lesson_create_date);
                if (($lesson_diff > 6 && !empty($mas->ss_aw_last_lesson_modified_date) && !empty($mas->ss_aw_create_date) && empty($mas->ss_aw_mlp_access_given_id) && $mas->upcoming_lession_id != $mas->ucoming_lesson_id) || $diagonastic_diff == 1) {
                    $row_count++;
                    $row++;
                    $col = 0;
                    $URL = base_url() . "master_lite/active_cheat_code/" . base64_encode($mas->ss_aw_child_id);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_child_id);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_child_first_name . ' ' . $mas->ss_aw_child_last_name);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_name);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_diagonastic_exam_date);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_section_title);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_last_lesson_create_date);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_last_lesson_modified_date);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $mas->ss_aw_create_date);

                    $coordinate = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col++, $row)->getCoordinate();

                    $objPHPExcel->getActiveSheet()->getCell($coordinate)->setValue($URL);
                    $objPHPExcel->getActiveSheet()->getCell($coordinate)->getHyperlink()->setUrl($URL)->setTooltip('Click here to access the link');
                    $objPHPExcel->getActiveSheet()->getStyle($coordinate)->applyFromArray($link_style_array);
                    // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $URL);

                    $upd['ss_aw_id'] = $mas->mlp_id;
                    $upd['upcoming_lession_id'] = $mas->ucoming_lesson_id;
                    $upd['mail_send'] = 1;
                    $this->ss_aw_master_lite_model->update_data($upd);
                }
            }
        }
        if ($row_count > 0) {
            if (!file_exists("./scorepdf/new/")) {
                mkdir("./scorepdf/new/", 0777);
            }
            $filename = "attachment_" . date("Y-m-d-H-i-s") . ".xls";
            $save_file_path = "./scorepdf/new/" . $filename;
            //        header('Content-Type: application/vnd.ms-excel');
            //        header('Content-Disposition: attachment;filename="' . $save_file_path . '"');
            //        header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            ob_end_clean();
            //        $objWriter->save('php://output');
            $objWriter->save($save_file_path);
            return base_url() . "scorepdf/new/" . $filename;
        } else {
            return false;
        }
    }

    public function active_cheat_code($child_id_encode)
    {
        $child_id = base64_decode($child_id_encode);
        $headerdata = $this->checklogin($child_id_encode);
        $headerdata['title'] = "Cheat code";
        $data = array();
        $search_data['ss_aw_expertise_level'] = 'A,M';
        $topic_listary = $this->ss_aw_sections_topics_model->get_all_records(0, 0, $search_data);
        $topicAry = array();
        if (!empty($topic_listary)) {
            foreach ($topic_listary as $key => $value) {
                $topicAry[] = $value->ss_aw_section_id;
            }
        }
        $topic_arr = implode(("','"), $topicAry);
        // $general_language_lessons = $this->ss_aw_lessons_uploaded_model->get_winners_general_language_lessons();
        $topical_lessons = $this->ss_aw_lessons_uploaded_model->get_lessonlist_by_topics_check_last_lesson($topic_arr, $child_id);

        $data['lesson_list'] = $topical_lessons;
        //$general_language_assessments = $this->ss_aw_assesment_uploaded_model->get_winners_general_language_assessments();
        //        $topical_assessments = $this->ss_aw_assesment_uploaded_model->get_assessmentlist_by_topics_check_completed($topicAry, $child_id);
        //
        //        $assessment_listary = array_merge($topical_assessments);
        //        $data['assessment_list'] = $assessment_listary;

        $data['child_details'] = $this->ss_aw_childs_model->get_child_detail_by_id($child_id);
        $data['course_details'] = $this->ss_aw_child_course_model->getcoursedetailsaccordingchildid($child_id);
        $data['institution'] = $this->ss_aw_master_lite_model->get_instution_name_by_child_id($child_id);

        $this->load->view('admin/header_no_sidebar', $headerdata);
        $this->load->view('mannualy_update', $data);
        $this->load->view('admin/footer');
    }

    //data completion for lesson//
    public function lesson_completion()
    {
        $postdata = $this->input->post();
        $created_by = $this->session->userdata('id');
        $lesson_id_value = $postdata['lesson_value'];
        $child_id = $postdata['child_id'];
        $result = $this->ss_aw_child_last_lesson_model->get_last_lesson_for_child($child_id);
        if (!empty($result)) {
            $last_lesson_id = $result[0]->ss_aw_lesson_id;
            $access_assess = $this->ss_aw_master_lite_access_given_model->getassessmentdata($child_id, $last_lesson_id);
            if (empty($access_assess)) {
                $this->session->set_flashdata('error', 'Assessment not completed yet');
                redirect("master_lite/active_cheat_code/" . base64_encode($child_id));
            }
        }
        if ($postdata['action'] == 1) { //complete lesson
            foreach ($lesson_id_value as $lesson_id) {
                $lesson_detail = $this->ss_aw_lessons_uploaded_model->getlessonbyid($lesson_id);
                $format = $lesson_detail[0]->ss_aw_lesson_format;
                $serial_no = $lesson_detail[0]->ss_aw_sl_no;
                $lesson_quiz_detail = $this->get_lesson_details_list($lesson_id, $child_id, $serial_no, $format);
            }
            if ($lesson_quiz_detail == true) {
                $this->session->set_flashdata('success', 'Lesson Assessment updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error ! Lesson not updated.');
            }
        } elseif ($postdata['action'] == 3) { //Mark as accessable//     
            $lesson_id = $lesson_id_value[0];
            $access = $this->ss_aw_master_lite_access_given_model->getaiglerowdata($child_id, $lesson_id, 1);

            if (!empty($access)) {
                $this->session->set_flashdata('error', 'Already Access Given');
                redirect("master_lite/active_cheat_code/" . base64_encode($child_id));
            }

            if (!empty($result)) {
                $record_id = $result[0]->ss_aw_las_lesson_id;
                $start_time = $result[0]->ss_aw_last_lesson_create_date;
                $end_time = $result[0]->ss_aw_last_lesson_modified_date;
                $updated_start_time = "";
                if (!empty($start_time)) {
                    $updated_start_time = date('Y-m-d H:i:s', strtotime($start_time . " -7 day"));
                }
                $updated_end_time = "";
                if (!empty($end_time)) {
                    $updated_end_time = date('Y-m-d H:i:s', strtotime($end_time . " -7 day"));
                }
                $this->db->trans_begin();
                $this->ss_aw_child_last_lesson_model->update_last_lesson($record_id, $updated_start_time, $updated_end_time);

                //assessment complete date//  
                $assesment_com['ss_aw_exam_code'] = $access_assess->exam_code;
                $last_assess_data = $this->ss_aw_assessment_exam_completed_model->fetch_details_byparam($assesment_com);

                $ass_score['ss_aw_create_date'] = date('Y-m-d H:i:s', strtotime($last_assess_data[0]['ss_aw_create_date'] . " -7 day"));
                $ass_score['ss_aw_id'] = $last_assess_data[0]['ss_aw_id'];
                $this->ss_aw_master_lite_access_given_model->update_data($ass_score);

                $access['ss_aw_lesson_type'] = 1;
                $access['ss_aw_lesson_assesment_id'] = $lesson_id;
                $access['ss_aw_access_date'] = $updated_end_time;
                $access['ss_aw_child_id'] = $child_id;
                $access['created_by'] = $created_by;
                $this->ss_aw_master_lite_access_given_model->insert_data($access);

                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('success', 'Access given  successfully.');
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error ! Lesson not activated.');
                }
            }
        }

        redirect("master_lite/active_cheat_code/" . base64_encode($child_id));
    }

    public function get_lesson_details_list($lesson_id, $child_id, $serial_no, $format)
    {
        //Get Current Lesson status
        $lessonary = array();
        $lessonary['ss_aw_lesson_id'] = $lesson_id;
        $lessonary['ss_aw_child_id'] = $child_id;
        $childary = $this->ss_aw_child_course_model->get_details($child_id);

        $level_id = $childary[count($childary) - 1]['ss_aw_course_id']; //course_id

        if ($level_id == 5) {
            if ($serial_no <= 10) {
                $fetch_level_id = 2;
            } elseif ($serial_no > 10 && $serial_no < 56) {
                $fetch_level_id = 3;
            } else {
                $fetch_level_id = 4;
            }
        }
        $searchary = array();
        $searchary['ss_aw_lesson_record_id'] = $lesson_id;
        $searchary['ss_aw_course_id'] = $fetch_level_id;
        $searchary['ss_aw_lesson_format_type'] = '2';

        $this->db->trans_begin();
        $rest = $this->ss_aw_master_lite_model->get_lesson_quize($searchary, $child_id); //Insert all topic question.

        if ($rest) {
            foreach ($rest->result() as $res) {
                $choice_ary = array();
                $choice_ary = explode("/", trim($res->ss_aw_lesson_question_options));
                $choice_ary = implode(",", array_map('trim', $choice_ary));

                $quz_ans['ss_aw_lesson_id'] = $res->ss_aw_lesson_record_id;
                $quz_ans['ss_aw_question_id'] = $res->ss_aw_lession_id;
                $quz_ans['ss_aw_question'] = $res->ss_aw_lesson_details;
                $quz_ans['ss_aw_options'] = !empty($choice_ary) ? $choice_ary : '';
                $quz_ans['ss_aw_post_answer'] = '';
                $quz_ans['ss_aw_answer_status'] = 2;
                $quz_ans['ss_aw_question_format'] = $res->ss_aw_lesson_format_type;
                $quz_ans['ss_aw_child_id'] = $child_id;
                $quz_ans['ss_aw_topic_id'] = $res->ss_aw_lesson_topic;
                $quz_ans['ss_aw_seconds_to_start_answer_question'] = 0;
                $quz_ans['ss_aw_seconds_to_answer_question'] = 0;
                $this->ss_aw_lesson_quiz_ans_model->data_insert($quz_ans);
            }



            $lesson_count = $this->ss_aw_master_lite_model->get_lesson_count_data($searchary, $child_id);

            //Add update score table//
            $score['lesson_id'] = $lesson_id;
            $score['child_id'] = $child_id;
            $score['level'] = 'M';
            $score['total_question'] = $lesson_count->total_lesson;
            $score['wright_answers'] = $lesson_count->correct_lesson != '' ? $lesson_count->correct_lesson : 0;
            $check = $this->ss_aw_master_lite_model->check_score_exist($child_id, $lesson_id);

            if (!empty($check->value)) {
                $this->ss_aw_lesson_score_model->update_data($score);
            } else {
                $this->ss_aw_lesson_score_model->store_data($score);
            }
            //Add and Update child_las_lesson//
            $lass['ss_aw_lesson_id'] = $lesson_id;
            $lass['ss_aw_child_id'] = $child_id;
            $get_last_lesson = $this->ss_aw_child_last_lesson_model->fetch_details_byparam($lass);

            $lass_data['ss_aw_last_lesson_modified_date'] = date('Y-m-d H:i:s');
            $lass_data['ss_aw_child_id'] = $child_id;
            $lass_data['ss_aw_lesson_level'] = $level_id;
            $lass_data['ss_aw_lesson_id'] = $lesson_id;
            $lass_data['ss_aw_lesson_status'] = 2;
            $lass_data['ss_aw_back_click_count'] = 0;
            $lass_data['ss_aw_lesson_format'] = $format;

            if (!empty($get_last_lesson)) {
                $this->ss_aw_child_last_lesson_model->update_last_lesson($get_last_lesson[0]['ss_aw_las_lesson_id'], '', $lass_data['ss_aw_last_lesson_modified_date']);
            } else {
                $this->ss_aw_child_last_lesson_model->data_insert($lass_data);
            }

            //Add update current lesson//
            $curr['ss_aw_lesson_id'] = $lesson_id;
            $curr['ss_aw_child_id'] = $child_id;
            $current_lesson = $this->ss_aw_current_lesson_model->fetch_record_byparam($curr);
            $curr['ss_aw_back_click_count'] = 0;

            if (!empty($current_lesson)) {
                $curr['ss_aw_updated_date'] = date('Y-m-d H:i:s');
                $this->ss_aw_current_lesson_model->update_record($curr);
            } else {
                $this->ss_aw_current_lesson_model->insert_data($curr);
            }

            $this->assessment_completion($lesson_id, $child_id, 1); //For Assessment data//
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    //data completion assesment//
    public function assessment_completion($topic_id, $child_id, $action)
    {
        $created_by = $this->session->userdata('id');
        $postdata = $this->input->post();
        $get_assessment_upload_data = $this->ss_aw_master_lite_model->get_upload_active_data($topic_id);

        $assessment = $get_assessment_upload_data['ss_aw_assessment_id'];
        //$child_id = $postdata['child_id'];
        if ($action == '1') {
            $last_child = $this->ss_aw_master_lite_model->getallcompletelessonbychild($assessment, $child_id);

            if (empty($last_child)) {
                $this->session->set_flashdata('error', 'Pleased Complete lesson first.');
                redirect("master_lite/active_cheat_code/" . base64_encode($child_id));
            }
            $assessment_id = $last_child->ss_aw_assessment_id;
            $childary = $this->ss_aw_child_course_model->get_details($child_id);
            $level = $childary[count($childary) - 1]['ss_aw_course_id'];
            $asses = $this->ss_aw_assesment_uploaded_model->getSerialno($assessment_id);

            $assessment_serial_no = $asses->ss_aw_sl_no;
            if ($level == '5') {
                if ($assessment_serial_no <= 10) {
                    $fetch_level = 'C';
                } elseif ($assessment_serial_no > 10 && $assessment_serial_no < 56) {
                    $fetch_level = 'A';
                } else {
                    $fetch_level = 'M';
                }
            }
            $exam_code = time() . '_' . $child_id;

            $subcategoryary['ss_aw_level'] = $fetch_level;
            $subcategoryary['ss_aw_uploaded_record_id'] = $assessment_id;
            $searchresultary = $this->ss_aw_assisment_diagnostic_model->fetch_subcategory_byparam_groupby($subcategoryary);

            $count_subcategory = count($searchresultary); // Total No of Sub-category
            $subcategoryary = array();
            $subcategoryary['ss_aw_sub_section_no'] = $count_subcategory;
            $matrix = $this->ss_aw_assessment_subsection_matrix_model->fetch_details($subcategoryary);
            $total_question_no = $matrix[0]['ss_aw_total_question'];
            $min_question_no = $matrix[0]['ss_aw_min_question'];
            $this->db->trans_begin();
            if ($searchresultary[0]['ss_aw_format'] == 'Single') {
                if (!empty($searchresultary)) {
                    $i = 0;
                    foreach ($searchresultary as $resarr) {
                        $asses_count = $this->ss_aw_master_lite_model->countsubtopicquestion($fetch_level, $assessment_id, $resarr['ss_aw_sub_category']);
                        $serial_no = $asses_count->value / $total_question_no;
                        for ($j = 1; $j <= $total_question_no; $j++) {
                            $seq_no = $j * $serial_no;
                            if ($seq_no > $asses_count->value) {
                                $seq_no = $asses_count->value - ($seq_no - $asses_count->value);
                            }
                            $ques_log = $this->ss_aw_master_lite_model->get_assesment_log_question_data($resarr['ss_aw_sub_category'], $assessment_id, $fetch_level, ceil($seq_no));

                            $log['ss_aw_log_exam_code'] = $exam_code;
                            $log['ss_aw_log_child_id'] = $child_id;
                            $log['ss_aw_log_level'] = $fetch_level;
                            $log['ss_aw_log_category'] = $ques_log->ss_aw_category;
                            $log['ss_aw_log_subcategory'] = $ques_log->ss_aw_sub_category;
                            $log['ss_aw_log_question_id'] = $ques_log->ss_aw_id;
                            $log['ss_aw_log_topic_id'] = $ques_log->ss_aw_question_topic_id;
                            $log['ss_aw_log_question_type'] = $ques_log->ss_aw_quiz_type;
                            $log['ss_aw_log_weight'] = $ques_log->ss_aw_weight;
                            $log['ss_aw_log_answers'] = '';
                            $log['ss_aw_log_answer_status'] = 2;
                            $this->ss_aw_assessment_exam_log_model->insert_record($log);

                            $asked['ss_aw_assessment_id'] = $ques_log->ss_aw_uploaded_record_id;
                            $asked['ss_aw_child_id'] = $child_id;
                            $asked['ss_aw_assessment_exam_code'] = $exam_code;
                            $asked['ss_aw_calculated_seq_no'] = $seq_no;
                            $asked['ss_aw_asked_level'] = $fetch_level;
                            $asked['ss_aw_asked_category'] = $ques_log->ss_aw_category;
                            $asked['ss_aw_asked_sub_category'] = $ques_log->ss_aw_sub_category;
                            $asked['ss_aw_assessment_question_id'] = $ques_log->ss_aw_id;
                            $asked['ss_aw_answers_status'] = 2;
                            $this->ss_aw_assesment_questions_asked_model->insert_record($asked);
                        }
                    }
                }
                $assesment_log = $this->ss_aw_master_lite_model->get_assesment_log_data($exam_code);
            } else {
                $multi_ques = $this->ss_aw_master_lite_model->get_multiple_question($assessment_id);

                if (!empty($multi_ques)) {
                    foreach ($multi_ques->result() as $mult) {
                        $qes_ask = array();
                        $qes_ans = array();
                        $qes_ans['ss_aw_assessment_id'] = $qes_ask['ss_aw_assessment_id'] = $assessment_id;
                        $qes_ans['ss_aw_child_id'] = $qes_ask['ss_aw_child_id'] = $child_id;
                        $qes_ans['ss_aw_assessment_exam_code'] = $qes_ask['ss_aw_exam_code'] = $exam_code;
                        $qes_ask['ss_aw_assessment_topic'] = $mult->ss_aw_category;
                        $qes_ask['ss_aw_page_index'] = $mult->ss_aw_id;
                        $this->ss_aw_assesment_multiple_question_asked_model->insert_record($qes_ask);

                        $qes_ans['ss_aw_level'] = '5';
                        $qes_ans['ss_aw_question_id'] = $mult->ss_aw_id;
                        $qes_ans['ss_aw_question'] = strip_tags($mult->ss_aw_question);
                        $qes_ans['ss_aw_question_type'] = $mult->qtype;
                        $qes_ans['ss_aw_topic_id'] = $mult->ss_aw_question_topic_id;
                        $qes_ans['ss_aw_answer'] = '';
                        $qes_ans['ss_aw_answers_status'] = 2;
                        $qes_ans['ss_aw_seconds_to_start_answer_question'] = 0;
                        $qes_ans['ss_aw_seconds_to_answer_question'] = 0;
                        $this->ss_aw_assesment_multiple_question_answer_model->store_data($qes_ans);
                    }
                }

                $assesment_log = $this->ss_aw_master_lite_model->get_assesment_log_multi_data($exam_code);
            }




            $ass_score['child_id'] = $child_id;
            $ass_score['level'] = 'M';
            $ass_score['exam_code'] = $exam_code;
            $ass_score['assessment_id'] = $assessment_id;
            $ass_score['assessment_topic'] = $asses->ss_aw_lesson_topic;
            $ass_score['total_question'] = $assesment_log->total_log;
            $ass_score['wright_answers'] = 0;
            $this->ss_aw_assessment_score_model->store_data($ass_score);

            $ass_comp['ss_aw_assessment_id'] = $assessment_id;
            $ass_comp['ss_aw_assessment_topic'] = $asses->ss_aw_lesson_topic;
            $ass_comp['ss_aw_exam_code'] = $exam_code;
            $ass_comp['ss_aw_child_id'] = $child_id;
            $this->ss_aw_assessment_exam_completed_model->insert_data($ass_comp);

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Lesson Assesment updated successfully.');
                return true;
            } else {

                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error ! Lesson Assesment not updated.');
                return false;
            }
        }
    }

    //========================================================================================================//
    public function date_difference($use_date)
    {
        $date = date('Y-m-d');
        $date_use = date_format(date_create($use_date), 'Y-m-d');
        $earlier = new DateTime($date_use);
        $later = new DateTime($date);

        return $abs_diff = $later->diff($earlier)->format("%a");
    }

    public function checklogin($cheat_code = "")
    {

        if (empty($this->session->userdata('id')) && $this->session->userdata('access_id') != 1) {
            $this->session->set_flashdata('error', 'First login to access any page.');
            redirect('admin/index/' . $cheat_code);
        } else {
            $parent_id = $this->session->userdata('id');
            $institution_admin_details = $this->ss_aw_parents_model->get_parent_profile_detailsbyid($parent_id);
            if ($this->session->userdata('is_institute')) {
                if (!empty($institution_admin_details)) {
                    $institution_id = $institution_admin_details[0]->ss_aw_institution;
                    $institution_details = $this->ss_aw_institutions_model->get_record_by_id($institution_id);
                    if ($institution_details->ss_aw_status == 0) {
                        $this->session->set_flashdata('error', 'First login to access any page.');
                        redirect('admin/index');
                    }
                }
            }

            $headerdata = array();
            $headerdata['profile_name'] = $this->session->userdata('fullname');
            $headerdata['profile_pic'] = $this->session->userdata('profile_pic');
            $headerdata['user_email'] = $this->session->userdata('user_email');

            $searchary = array();
            $searchary['ss_aw_status'] = 1;
            return $headerdata;
        }
    }
}
