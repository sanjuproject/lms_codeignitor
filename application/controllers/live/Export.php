<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ss_aw_parents_model');
        $this->load->model('ss_aw_childs_model');
        $this->load->model('ss_aw_sections_topics_model');
        $this->load->model('ss_aw_lessons_uploaded_model');
        $this->load->model('ss_aw_diagonastic_exam_model');
        $this->load->model('ss_aw_diagonastic_exam_log_model');
        $this->load->model('ss_aw_lesson_score_model');
        $this->load->model('ss_aw_child_last_lesson_model');
        $this->load->model('ss_aw_assesment_questions_asked_model');
        $this->load->model('ss_aw_assesment_multiple_question_asked_model');
        $this->load->model('ss_aw_assessment_score_model');
        $this->load->model('ss_aw_readalong_restriction_model');
        $this->load->model('ss_aw_schedule_readalong_model');
        $this->load->model('ss_aw_last_readalong_model');
        $this->load->model('ss_aw_readalong_quiz_ans_model');
        $this->load->model('ss_aw_adminmenus_model');
        $this->load->model('ss_aw_child_course_model');
        $this->load->model('ss_aw_diagnostic_complete_log_model');
        $this->load->model('ss_aw_topics_complete_log_model');
        $this->load->model('ss_aw_assessment_exam_completed_model');
        $this->load->helper('custom_helper');
    }

    // create xlsx
    public function generateXls_institutionreportdashboard($institution_id = '', $programme_type = '') {

        $institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
        $institution_users_id = array();
        if (!empty($institution_parents)) {
            foreach ($institution_parents as $key => $value) {
                $institution_users_id[] = $value->ss_aw_parent_id;
            }
        }
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
        $lessonscoredata = array();
        $assessment_id_ary = array();
        $assessmentscoredata = array();
        $readalongscore = array();
        $readalong_id_ary = array();

        $childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type);
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $child_id = $value->ss_aw_child_id;

                //diagnostic section
                $diagnostic_exam_code_details = $this->ss_aw_diagonastic_exam_model->get_exam_details_by_child($child_id);
                if (!empty($diagnostic_exam_code_details)) {
                    $exam_code = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_code;
                    $diagnostic_question_correct = $this->ss_aw_diagonastic_exam_log_model->correct_answered_question_num_by_exam_code($exam_code);
//                    $diagnosticcorrectnum[$child_id] = get_percentage(DIAGNOSTIC_QUESTION_NUM, $diagnostic_question_correct) . "%";
                    $diagnosticcorrectnumber = get_percentage(DIAGNOSTIC_QUESTION_NUM, $diagnostic_question_correct) / 100;
                    $diagnosticcorrectnum[$child_id]=is_numeric($diagnosticcorrectnumber) ? ($diagnosticcorrectnumber != 0 ? $diagnosticcorrectnumber : 0.000000001) : '';
                    $diagnostic_exam_complete_date = $diagnostic_exam_code_details->ss_aw_diagonastic_exam_date;
                } else {
                    $diagnostic_question_correct = 0;
                    $diagnosticcorrectnum[$child_id] = "NA";
                }

                //lesson assessment and readalong section
                $finish_record_id = array();
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
                            $lesson_score = $lesson_asked > 0 ? get_percentage($lesson_asked, $lesson_correct) / 100 : "NA";
                        }else {
                            $lesson_score = "NA";
                        }
//                        $lesson_score = $lesson_asked > 0 ? get_percentage($lesson_asked, $lesson_correct)."%" : "NA";
                       
                        $lessonscoredata[$child_id][$lesson_topic['ss_aw_lession_id']]=is_numeric($lesson_score) ? ($lesson_score != 0 ? $lesson_score : 0.000000001) : '';
                              
                        //end
                        //readalong section
                        if (!empty($lesson_complete_date) && !empty($prev_assessment_complete_date)) {
                            $readalong_start_date = $prev_assessment_complete_date;
                            $restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($programme_type);
                            $restriction_time = $restriction_detail[0]->restricted_time;
                            $readalong_end_date = date('Y-m-d', strtotime($readalong_start_date . "+ " . $restriction_time . " minutes"));
                            //get scheduled readalong details
                            $check_finish = $this->ss_aw_last_readalong_model->get_complete_readalong_details($child_id, $readalong_start_date, $readalong_end_date, $finish_record_id);
                            $readalong_complete_date = "";
                            if (!empty($check_finish)) {
                                //store finish record id to filter without these ids in next iteration to readalong complete checking
                                $finish_record_id[] = $check_finish->ss_aw_id;
                                $readalong_id_ary[$child_id][$lesson_topic['ss_aw_lession_id']] = $check_finish->ss_aw_readalong_id;
                                $readalong_complete_date = date('d/m/Y', strtotime($check_finish->ss_aw_create_date));
//                                $readalong_score = $check_finish->total_question > 0 ? get_percentage($check_finish->total_question, $check_finish->wright_question)."%" : "NA";
                                $readalong_score = $check_finish->total_question > 0 ? get_percentage($check_finish->total_question, $check_finish->wright_question) / 100 : "NA";
                                $readalongscore[$child_id][$lesson_topic['ss_aw_lession_id']] = is_numeric($readalong_score) ? ($readalong_score != 0 ? $readalong_score : 0.000000001) : '';
                                $readalongcompletedate[$child_id][$lesson_topic['ss_aw_lession_id']] = $readalong_complete_date != "" ? $readalong_complete_date : "";
                            } else {
                                $readalongscore[$child_id][$lesson_topic['ss_aw_lession_id']] = "NA";
                            }
                        } else {
                            $readalongscore[$child_id][$lesson_topic['ss_aw_lession_id']] = "NA";
                        }
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
                            $assessment_score = $assessment_asked > 0 ? get_percentage($assessment_asked, $assessment_correct) / 100 : "NA";
                        } else {
                            $assessment_score = "NA";
                        }
//                        $assessment_score = $assessment_asked > 0 ? get_percentage($assessment_asked, $assessment_correct)."%" : "NA";
                        

                        $assessmentscoredata[$child_id][$lesson_topic['ss_aw_lession_id']] = is_numeric($assessment_score) ? ($assessment_score != 0 ? $assessment_score : 0.000000001) : '';
                        $assessment_completetion_details = $this->ss_aw_assessment_exam_completed_model->get_assessment_completion_details($assessment_id, $child_id);
                        if (!empty($assessment_completetion_details)) {
                            $assessment_complete_date = $assessment_completetion_details[0]->ss_aw_create_date;
                            $module_complete_day_gap = daysDifferent(strtotime($lesson_start_date), strtotime($assessment_complete_date));
                            if ($module_complete_day_gap < 7) {
                                $prev_assessment_complete_date = date('Y-m-d', strtotime($lesson_start_date . " +7 day"));
                            } else {
                                $prev_assessment_complete_date = date('Y-m-d', strtotime($assessment_complete_date));
                            }
                        }
                        //end       
                    }
                }
            }
        }






        // create file name
        // load excel library
        $this->load->library('excel');
        // $listInfo = $this->export->exportList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
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

        $border_style = array('borders' => array('allborders' => array('style' =>
                    PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '766f6e'),)));
        // set Header
        $row = 1;
        // $objPHPExcel->getActiveSheet()->setAutoSize(true);

        $objPHPExcel->getActiveSheet()->freezePane('D2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '#');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'User Name');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, '');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'Diagnostic Quiz');
        $col = 4;
        if (!empty($lesson_listary)) {
            foreach ($lesson_listary as $key => $value) {

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value['ss_aw_lesson_topic']);
                $col++;
            }
        }


        $child_no = 0;
        $row++;
        $datrow = 0;
        $al_row = 1;
        $m = 1;
        foreach ($childs as $key => $value) {
            $child_no++;
            $child_id = $value->ss_aw_child_id;
            $col = 0;
            $datrow = $row;

            $start_col = $col;
            $start_row = $row;

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $child_no);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, 'Diagnostic Quiz');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'Lesson');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'Assessment');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'ReadAlong');

//echo $diagnosticcorrectnum[$value->ss_aw_child_id];exit;
            //sub headers value//
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $datrow, $diagnosticcorrectnum[$value->ss_aw_child_id] != 'NA' ? $diagnosticcorrectnum[$value->ss_aw_child_id] : '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $datrow, 0.5);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $datrow, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $datrow, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $datrow, '');

            $al_col = 3;

            if (!empty($lesson_listary)) {
                foreach ($lesson_listary as $key => $topic) {
                    $al_row = $al_row > 1 ? ($al_row - 4) : 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$al_col, ++$al_row, '');

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $lessonscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA' ? $lessonscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] : '');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $assessmentscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA' ? $assessmentscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] : '');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $readalongscore[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA' ? $readalongscore[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] : '');
                }
            }

            $end_col = $al_col;
            $end_row = $al_row;
            $start_range = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($start_col, $start_row)->getCoordinate();
            $end_range = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($end_col, $end_row)->getCoordinate();
            if ($m % 2 != 0) {

                $objPHPExcel->getActiveSheet()->getStyle($start_range . ':' . $end_range)->getFill()->applyFromArray($rowColor);
            }
            $objPHPExcel->getActiveSheet()->getStyle($start_range . ':' . $end_range)->applyFromArray($border_style);
            $al_row = $al_row + 4;
            $row++;
            $m++;
        }
        $highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $highestColumn . '1')->applyFromArray($styleArrayFirstRow);
        // foreach (range('A', $highestColumn) as $columnID) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension("'".$columnID."'")->setAutoSize(true);
        // }

        $objPHPExcel->getActiveSheet()->getStyle('D1:' . $end_range)
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
                )
        );
        $pre = $programme_type == 1 ? strtolower(Winners).'_' : strtolower(Master).'s_';

        $filename = $pre . "individual_performance_" . date("Y-m-d-H-i-s") . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function export_institution_module_wise_complete_performance($institution_id = '', $programme_type = '') {


        $institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
        $institution_users_id = array();
        if (!empty($institution_parents)) {
            foreach ($institution_parents as $key => $value) {
                $institution_users_id[] = $value->ss_aw_parent_id;
            }
        }


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
                                        } else {
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
                                        $readalong_end_date = date('Y-m-d H:i:s', strtotime($readalong_start_date . "+ " . $restriction_time . " minutes"));
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
        // load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $row = 1;
        // $objPHPExcel->getActiveSheet()->mergeCells("A1:C1");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'Topics');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, '');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'Lesson');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'Assessment');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'Readalong');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, 'Completed on time');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 'Completed but not on time');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, '1 to 7 days delinquent');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, '8 to 14 days delinquent');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, '15+ days delinquent');

        $col = 0;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'Diagnostic Quiz');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Lesson
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Assessment
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnosticcompletenum); //Readalong
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Completed on time
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnostic_complete_log->ss_aw_completed_on_time);
        $total_non_time_complete_users = "";
        if (!empty($diagnostic_complete_log)) {
            $total_non_time_complete = $diagnostic_complete_log->ss_aw_completed_but_not_on_time;
            if (!empty($diagnostic_complete_log->ss_aw_completed_but_not_on_time_users)) {
                $total_non_time_complete_users .= $diagnostic_complete_log->ss_aw_completed_but_not_on_time_users;
            }
        } else {
            $total_non_time_complete = "";
        }
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $total_non_time_complete); //Completed but not on time
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnostic_complete_log->ss_aw_one_to_seven_delinquent); //1 to 7 days delinquent
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnostic_complete_log->ss_aw_eight_to_forteen_delinquent); //8 to 14 days delinquent
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnostic_complete_log->ss_aw_fifteen_plus_delinquent); //15+ days delinquent
        //from second row//
        if (!empty($lesson_listary)) {
            foreach ($lesson_listary as $key => $value) {
                $col = 0;
                $lesson_id = $value['ss_aw_lession_id'];
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, $value['ss_aw_lesson_topic']); //topic
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $key + 1); //Sl
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $lessonnonaccessable[$lesson_id] != 0 ? $lessoncompletenum[$lesson_id] : 'NA'); //Lesson
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? $assessmentcompletenum[$lesson_id] : 'NA'); //Assesment
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $readalongnonaccessable[$lesson_id] != 0 ? $readalongcompletenum[$lesson_id] : 'NA'); //Readalong
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_completed_on_time : '-') : 'NA'); //Completed on time

                $topic_non_time_complete_users = "";
                if (!empty($topical_log_details)) {
                    $non_time_total_complete = $topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time;

                    if (!empty($topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time_users)) {
                        $topic_non_time_complete_users .= $topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time_users;
                    }
                } else {
                    $non_time_total_complete = "";
                }

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? (!empty($non_time_total_complete) ? $non_time_total_complete : '0') : 'NA'); //Completed but not on time
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_one_to_seven_delinquent : '-') : 'NA'); //1 to 7 days delinquent
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_eight_to_forteen_delinquent : '-') : 'NA'); //8 to 14 days delinquent
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_fifteen_plus_delinquent : '-') : 'NA'); //15+ days delinquent
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle('B2:BD50')
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                )
        );
        $pre = $programme_type == 1 ? strtolower(Winners).'_' : strtolower(Master).'s_';
        $filename = $pre . "institution_module_wise_complete_performance_" . date("Y-m-d-H-i-s") . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function export_institution_module_wise_incomplete_performance($institution_id = '', $programme_type = '') {


        $institution_parents = $this->ss_aw_parents_model->get_institutions_users($institution_id);
        $institution_users_id = array();
        if (!empty($institution_parents)) {
            foreach ($institution_parents as $key => $value) {
                $institution_users_id[] = $value->ss_aw_parent_id;
            }
        }

        $searchdata = array();
        $searchdata['incomplete_user_programme_type'] = $programme_type;
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
                $child_id = $value->ss_aw_child_id;
                if (empty($value->ss_aw_diagonastic_exam_date)) {
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
                        if (!empty($value->ss_aw_diagonastic_exam_date)) {
                            $child_activation_date = date('Y-m-d', strtotime($value->ss_aw_diagonastic_exam_date));
                            if (!empty($child_activation_date)) {
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
                                    //readalong section
                                    $readalongnonaccessable[$lesson_id]++;
                                    if (!empty($lesson_complete_date)) {
                                        $restriction_detail = $this->ss_aw_readalong_restriction_model->get_restricted_time($programme_type);
                                        $restriction_time = $restriction_detail[0]->restricted_time;
                                        $readalong_end_date = date('Y-m-d H:i:s', strtotime($readalong_start_date . "+ " . $restriction_time . " minutes"));
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
                                        } else {
                                            $readalongincompletenum[$lesson_id]++;
                                            $readalongincompletechilds[$lesson_id][] = $child_id;
                                        }
                                    } else {
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




        // load excel library
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('H')->setAutoSize(true);
        $row = 1;
        $col = 0;
        // $objPHPExcel->getActiveSheet()->mergeCells("A1:C1");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Topics');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, '');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, 'Lesson');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, 'Assessment');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, 'Readalong');
        //FIRST ROW//
        $col = 0;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'Diagnostic Quiz');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //key
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Lesson
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnosticincompletenum); //Assessment
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Readalong
        //from second row//
        if (!empty($lesson_listary)) {
            foreach ($lesson_listary as $key => $value) {
                $col = 0;

                $lesson_id = $value['ss_aw_lession_id'];
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, $value['ss_aw_lesson_topic']); //topic
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $key + 1); //Sl
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $lessonnonaccessable[$lesson_id] != 0 ? $lessonincompletenum[$lesson_id] : 'NA'); //Lesson
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentnonaccessable[$lesson_id] != 0 ? $assessmentincompletenum[$lesson_id] : 'NA'); //Assesment
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $readalongnonaccessable[$lesson_id] != 0 ? $readalongincompletenum[$lesson_id] : 'NA'); //Readalong
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle('B2:BD50')
                ->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                )
        );
        $pre = $programme_type == 1 ? strtolower(Winners).'_' : strtolower(Master).'s_';
        $filename = $pre . "institution_module_wise_incomplete_performance_" . date("Y-m-d-H-i-s") . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
