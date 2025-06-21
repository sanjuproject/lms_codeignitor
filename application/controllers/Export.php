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
        $this->load->model('module_wise_performance_model');
        $this->load->helper('custom_helper');
    }

    // create xlsx
    public function generateXls_institutionreportdashboard($institution_id = '', $programme_type = '', $only_active_users_log = 0) {
       
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
		$redirect_to = base_url() . 'admin/institution_individual_performance/' . $institution_id;
		$uri_segment = 4;
		$record_per_page = 10;
		$config = pagination_config($redirect_to, $total_record, $uri_segment, $record_per_page);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;', $str_links);
		if ($page >= $config["total_rows"]) {
			$page = 0;
		}
		$datper = array();
		$performance = $this->module_wise_performance_model->get_module_individual_performence_data($institution_id, $search_data['ss_aw_expertise_level'], $programme_type,$only_active_users_log);
       
		if (!empty($performance)) {
			foreach ($performance as $per) {
				$datper[$per['ss_aw_child_id']][$per['ss_aw_lession_id']] = $per;
			}
		}
		$childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, 0, 0, $only_active_users_log);
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

                    $lessonscore=$datper[$child_id][$topic['ss_aw_lession_id']]['lessonscore'];
                    $assementscore=$datper[$child_id][$topic['ss_aw_lession_id']]['assesmentscore'];

                    $lessonscorepercent=is_numeric($lessonscore)?($lessonscore != 0 ? $lessonscore/100 : 0.000000001):'';
                    $assesmentpercent=is_numeric($assementscore)?($assementscore != 0 ? $assementscore/100 : 0.000000001):'';


                    $al_row = $al_row > 1 ? ($al_row - 3) : 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$al_col, ++$al_row, '');

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $lessonscore  != 'NA' ? $lessonscorepercent : '');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $assesmentpercent  != 'NA' ? $assesmentpercent  : '');
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
            $al_row = $al_row + 3;
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
    public function generateXls_institutionreportdashboard_old($institution_id = '', $programme_type = '', $only_active_users_log = 0) {

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

        $childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, 0, 0, $only_active_users_log);
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

                    $al_row = $al_row > 1 ? ($al_row - 3) : 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$al_col, ++$al_row, '');

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $lessonscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA' ? $lessonscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] : '');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($al_col, ++$al_row, $assessmentscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] != 'NA' ? $assessmentscoredata[$value->ss_aw_child_id][$topic['ss_aw_lession_id']] : '');
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
            $al_row = $al_row + 3;
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

    public function export_institution_module_wise_complete_performance($institution_id = '', $programme_type = '', $only_active_users_log = 0) {


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

        $childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, 0, 0, $only_active_users_log);

        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $child_id = $value->ss_aw_child_id;
                if (!empty($value->ss_aw_diagonastic_exam_date)) {
                    $diagnosticcompletenum++;
                    $diagnosticcompletechilds[] = $child_id;
                }
            }
        }

        $topics = $this->module_wise_performance_model->getmodulewisereportdata($institution_id, $search_data['ss_aw_expertise_level'], $programme_type, $only_active_users_log);

        $diagnostic_complete_log = $this->ss_aw_diagnostic_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id, $only_active_users_log);
        $data['diagnostic_complete_log'] = $diagnostic_complete_log;
        $topics_complete_log = $this->ss_aw_topics_complete_log_model->institution_log($programme_type > 1 ? 2 : $programme_type, $institution_id, $only_active_users_log);
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
        $rss=-1;
        // $objPHPExcel->getActiveSheet()->mergeCells("A1:C1");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, 'Topics');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, '');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, 'Lesson');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, 'Assessment');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, 'Completed on time');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, 'Completed but not on time');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, '1 to 7 days delinquent');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, '8 to 14 days delinquent');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$rss, $row, '15+ days delinquent');

        $col = 0;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'Diagnostic Quiz');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //sl
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Lesson
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnosticcompletenum); //Assessment
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
        if (!empty($topics)) {
            foreach ($topics as $key => $value) {
                $col = 0;
                $lesson_id = $value['ss_aw_lession_id'];
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, $value['ss_aw_lesson_topic']); //topic
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $key + 1); //Sl
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['lessonnonaccessable'] != 0 ? $value['lessoncompletenum'] : 'NA'); //Lesson
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['assessmentnonaccessable'] != 0 ? $value['assessmentcompletenum'] : 'NA'); //Assesment
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['assessmentnonaccessable'] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_completed_on_time : '-') : 'NA'); //Completed on time

                $topic_non_time_complete_users = "";
                if (!empty($topical_log_details)) {
                    $non_time_total_complete = $topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time;

                    if (!empty($topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time_users)) {
                        $topic_non_time_complete_users .= $topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time_users;
                    }
                } else {
                    $non_time_total_complete = "";
                }

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['assessmentnonaccessable'] != 0 ? (!empty($non_time_total_complete) ? $non_time_total_complete : '0') : 'NA'); //Completed but not on time
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['assessmentnonaccessable'] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_one_to_seven_delinquent : '-') : 'NA'); //1 to 7 days delinquent
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['assessmentnonaccessable'] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_eight_to_forteen_delinquent : '-') : 'NA'); //8 to 14 days delinquent
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $value['assessmentnonaccessable'] != 0 ? (!empty($topical_log_details) ? $topical_log_details[$lesson_id]->ss_aw_fifteen_plus_delinquent : '-') : 'NA'); //15+ days delinquent
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

    public function export_institution_module_wise_incomplete_performance($institution_id = '', $programme_type = '', $only_active_users_log = 0) {


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

        $childs = $this->ss_aw_childs_model->get_programee_users($institution_users_id, $programme_type, 0 , 0, $only_active_users_log);

        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $child_id = $value->ss_aw_child_id;
                if (empty($value->ss_aw_diagonastic_exam_date)) {
                    $diagnosticincompletenum++;
                    $diagnosticincompletechilds[] = $child_id;
                }
            }
        }

        $getdata=$this->module_wise_performance_model->getmodulewisenoncompletedata($institution_id,$search_data['ss_aw_expertise_level'],$programme_type, $only_active_users_log);

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
        //FIRST ROW//
        $col = 0;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, 'Diagnostic Quiz');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //key
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, ''); //Lesson
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $diagnosticincompletenum); //Assessment
        //from second row//
        $carry=0;
        $arr_key = array_search("", array_column($getdata, 'ss_aw_lession_id'));
                                         
        if ($arr_key == '0') {
            $lessonnotcompleted = $getdata["$arr_key"]['lessonnotcompleted'];
            $assessmentnotcompleted = $getdata["$arr_key"]['assessmentnotcompleted'];
        } else {
            $lessonnotcompleted = 0;
            $assessmentnotcompleted = 0;
        }
        $i = 0;

        if (!empty($lesson_listary)) {
            foreach ($lesson_listary as $key => $value) {
                $dat=getlastlessondata($institution_id,$value['ss_aw_lession_id'],$searchdata['incomplete_user_programme_type']);
                                                 
                $arr_key = '';
                $lesson_id = $value['ss_aw_lession_id'];
                $arr_key = array_search($lesson_id, array_column($getdata, 'ss_aw_lession_id'));

                $col = 0;

                $lesson_id = $value['ss_aw_lession_id'];
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, ++$row, $value['ss_aw_lesson_topic']); //topic
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $key + 1); //Sl
                if ($dat == 0) {
                    $lessonincompletenum = "NA";
                } else {
                    $lessonnotcomp=$lessonnotcompleted!=0?$getdata["$arr_key"]['lessonnotcompleted']+$lessonnotcompleted:$getdata["$arr_key"]['lessonnotcompleted'];
                    $lessonincompletenum = $carry + $lessonnotcomp;
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $lessonincompletenum); //Lesson
                if ($dat == 0) {
                    $assessmentincompletenum = "NA";
                } else {
                    $assesonnotcomp=$assessmentnotcompleted!=0?$getdata["$arr_key"]['assessmentnotcompleted']+$assessmentnotcompleted:$getdata["$arr_key"]['assessmentnotcompleted'];
                    $assessmentincompletenum = $carry + $assesonnotcomp;
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$col, $row, $assessmentincompletenum); //Assesment

                $carry = 0;
                $carry = $getdata["$arr_key"]['nextadd'];
                $lessonnotcompleted = 0;
                $assessmentnotcompleted = 0;
                $i++;
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
