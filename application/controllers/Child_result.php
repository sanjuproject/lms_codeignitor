<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Child_result extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model("ss_aw_child_assessment_pdf");
        $this->load->model("ss_aw_child_result_model");
        $this->load->model("ss_aw_child_assessment_pdf");
        $this->load->helper('awsome_report_helper');
        $this->load->helper('custom_helper');
    }

    public function create_pdf_export_new($child_id = "") {

        $this->load->model("ss_aw_child_assessment_pdf");
        $child_array = $this->ss_aw_child_assessment_pdf->get_all_course_completed_child($child_id);

        $grammer_array = array();
        $vocabulary_array = array();
        $diagonastic_array = array();
        if (!empty($child_array)) {
            foreach ($child_array->result() as $child) {
                $chld_res = $this->ss_aw_child_result_model->checkrecord($child->ss_aw_child_id, $child->course_level);
                if ($chld_res == 0) {
                    if ($child->course_level == "E") {
                        $title = Winners;
                    } elseif ($child->course_level == "A") {
                        $title = Champions;
                    } else {
                        $title = Master."s";
                    }


                    if ($child->course_level == "E" || $child->course_level == "A") {
                        $his = $child->ss_aw_child_gender == 1 ? 'his' : ($child->ss_aw_child_gender == 2 ? 'her' : 'his/her');
                        if ($child->ss_aw_institution == 0) {
                            $text = " Below is our assessment of how <b>" . ucfirst(strtolower($child->ss_aw_child_first_name)) . "</b> performed in the ALSOWISE® ".Winners." Programme, 
                                        a course that he recently completed. Our goal
                                        at ALSOWISE<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> is to provide your child with more than just a performance score on the curriculum. To that
                                        end, we have included feedback on <b>" . ucfirst(strtolower($child->ss_aw_child_first_name)) . "'s</b> performance compared to that"
                                    . "      of the other users who have completed the same programme.";
                        } else {
                            $text = " Below is our assessment of how <b>" . ucfirst(strtolower($child->ss_aw_child_first_name)) . "</b> performed in the ALSOWISE® ".Winners." Programme, 
                                        a course that he recently completed. Our goal
                                        at ALSOWISE<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> is to provide you with more than just a performance score on the curriculum. To that
                                        end, we have included feedback on <b>" . ucfirst(strtolower($child->ss_aw_child_first_name)) . "'s</b> performance compared to that "
                                    . "     of the other users who have completed the same programme.";
                        }
                    } else {
                        $text = "Below is our assessment of how <b>you</b> performed in the ALSOWISE<span style='vertical-align:0.7em; font-size:0.6em;'>&reg;</span> ".Master."s Programme, a course that you recently completed. 
                        Our goal at ALSOWISE<span style='vertical-align:0.7em; font-size:0.6em;'>&reg;</span> is to provide you with more than just a performance score on the curriculum.
                        To that end, we have included feedback on <b>your</b> performance compared to that of the other users who have completed the same programme.";
                    }


                    $grammer_first = array();
                    $grammer_second = array();
                    $grammer_third = array();
                    $voca_first = array();
                    $voca_second = array();
                    $voca_third = array();
                    $proficency = 0;
                    $proficency_count = 0;
                    $protencial = 0;
                    if ($child->course_level == "E" || $child->course_level == "M") {//for grammer
                        $start = 1;
                        $end = 11;
                        $grammer_array = $this->ss_aw_child_assessment_pdf->get_child_grammer_assessment($child->ss_aw_child_id, $start, $end);
//                   echo $this->db->last_query();
//                   exit;
                        if (!empty($grammer_array)) {
                            foreach ($grammer_array->result() as $gram) {
                                if ($gram->correct_answer_percentage_asses >= 65) {
                                    $grammer_first[] = $gram;
                                    $proficency += $gram->correct_answer_asses;
                                    $protencial += $gram->potencial_total;
                                } elseif ($gram->correct_answer_percentage_asses >= 35 && $gram->correct_answer_percentage_asses < 65) {
                                    $grammer_second[] = $gram;
                                    $proficency += $gram->correct_answer_asses;
                                    $protencial += $gram->potencial_total;
                                } else {
                                    $grammer_third[] = $gram;
                                    $proficency += $gram->correct_answer_asses;
                                    $protencial += $gram->potencial_total;
                                }
                                $proficency_count++;
                            }
                        }
                    }

                    if ($child->course_level == "E") {//for vocabulary
                        $start = 12;
                        $end = 15;
                    }
                    if ($child->course_level == "A") {
                        $start = 16;
                        $end = 25;
                    }
                    if ($child->course_level == "M") {
                        $start = 12;
                        $end = 25;
                    }

                    $vocabulary_array = $this->ss_aw_child_assessment_pdf->get_child_grammer_assessment($child->ss_aw_child_id, $start, $end);
//                 echo $this->db->last_query();
//                   exit;
                    if (!empty($vocabulary_array)) {
                        foreach ($vocabulary_array->result() as $voca) {
                            if ($voca->correct_answer_percentage_asses >= 65) {
                                $voca_first[] = $voca;
                            } elseif ($voca->correct_answer_percentage_asses >= 35 && $voca->correct_answer_percentage_asses < 65) {
                                $voca_second[] = $voca;
                            } else {
                                $voca_third[] = $voca;
                            }
                        }
                    }
                    $diagonastic_array = $this->ss_aw_child_assessment_pdf->get_child_diagonostics_data($child->ss_aw_child_id);

                    //non comprehension data start

                    $lesson_non_comprehension = $this->ss_aw_child_assessment_pdf->get_lesson_non_comprehension($child->ss_aw_child_id, $child->course_level, false);

                    $assesment_non_comprehension = $this->ss_aw_child_assessment_pdf->get_assesment_non_comprehension($child->ss_aw_child_id, $child->course_level, false);

                    $lenoco = array();
                    if (!empty($lesson_non_comprehension)) {
                        foreach ($lesson_non_comprehension->result() as $lnc) {


                            $lenoco[$lnc->ss_aw_sl_no]['topic_name'] = $lnc->ss_aw_lesson_topic;
                            $lenoco[$lnc->ss_aw_sl_no]['child_id'] = $lnc->ss_aw_child_id;
                            $lenoco[$lnc->ss_aw_sl_no]['nick_name'] = $lnc->ss_aw_child_nick_name;
                            $lenoco[$lnc->ss_aw_sl_no]['lesson_percent'] = $lnc->correct_answer_percentage_lesson;
                            $lenoco[$lnc->ss_aw_sl_no]['lesson_correct_cnt'] = $lnc->correct_answer_lesson;
                            $lenoco[$lnc->ss_aw_sl_no]['lesson_cnt'] = $lnc->qes_cnt_lesson;
                            $lenoco[$lnc->ss_aw_sl_no]['assesment_percent'] = '';
                        }
                    }
                    if (!empty($assesment_non_comprehension)) {
                        foreach ($assesment_non_comprehension->result() as $anc) {
                            $lenoco[$anc->ss_aw_lesson_id]['topic_name'] = $anc->ss_aw_assesment_topic;
                            $lenoco[$anc->ss_aw_lesson_id]['child_id'] = $anc->ss_aw_child_id;
                            $lenoco[$anc->ss_aw_lesson_id]['nick_name'] = $anc->ss_aw_child_nick_name;
                            $lenoco[$anc->ss_aw_lesson_id]['assesment_cnt'] = $anc->qes_cnt_assesment;
                            $lenoco[$anc->ss_aw_lesson_id]['assesment_correct_cnt'] = $anc->correct_answer_assesment;
                            $lenoco[$anc->ss_aw_lesson_id]['assesment_percent'] = $anc->correct_answer_percentage_assesment;
                        }
                    }

                    //non comprehension data End
                    //comprehension data start 
                    $lesson_comprehension = $this->ss_aw_child_assessment_pdf->get_lesson_non_comprehension($child->ss_aw_child_id, $child->course_level, true);

                    $assesment_comprehension = $this->ss_aw_child_assessment_pdf->get_assesment_non_comprehension($child->ss_aw_child_id, $child->course_level, true);
                    $leco = array();
                    if (!empty($lesson_comprehension)) {
                        foreach ($lesson_comprehension->result() as $lnc) {


                            $leco[$lnc->ss_aw_sl_no]['topic_name'] = $lnc->ss_aw_lesson_topic;
                            $leco[$lnc->ss_aw_sl_no]['child_id'] = $lnc->ss_aw_child_id;
                            $leco[$lnc->ss_aw_sl_no]['nick_name'] = $lnc->ss_aw_child_nick_name;
                            $leco[$lnc->ss_aw_sl_no]['lesson_percent'] = $lnc->correct_answer_percentage_lesson;
                            $leco[$lnc->ss_aw_sl_no]['assesment_percent'] = '';
                        }
                    }
                    if (!empty($assesment_comprehension)) {
                        foreach ($assesment_comprehension->result() as $anc) {
                            $leco[$anc->ss_aw_lesson_id]['topic_name'] = $anc->ss_aw_assesment_topic;
                            $leco[$anc->ss_aw_lesson_id]['child_id'] = $anc->ss_aw_child_id;
                            $leco[$anc->ss_aw_lesson_id]['nick_name'] = $anc->ss_aw_child_nick_name;
                            $leco[$anc->ss_aw_lesson_id]['assesment_percent'] = $anc->correct_answer_percentage_assesment;
                        }
                    }

                    //comprehension data End 
                    //Readalong data Start

                    $readalong = $this->ss_aw_child_assessment_pdf->get_readalong_data($child->ss_aw_child_id);

//                echo $this->db->last_query();
//                exit;
                    //REadalong data End
                    //Face-To-Face and Written Communication start
                    $face_to_face = array();
                    if ($child->course_level == "M") {
                        $start = 29;
                        $end = 30;
                        $face_to_face = $this->ss_aw_child_assessment_pdf->get_child_grammer_assessment($child->ss_aw_child_id, $start, $end);
                    }
                    //Face-To-Face and Written Communication End
                    // Written Communication start
                    $written_communication = array();
                    if ($child->course_level == "M") {
                        $start = 26;
                        $end = 28;
                        $written_communication = $this->ss_aw_child_assessment_pdf->get_child_grammer_assessment($child->ss_aw_child_id, $start, $end);
                    }
                    // Written Communication End


                    $data['title'] = $title;
                    $data['text'] = $text;
                    $data['child_details'] = $child;

                    $data['course_details_grammer_first'] = $grammer_first;
                    $data['course_details_grammer_second'] = $grammer_second;
                    $data['course_details_grammer_third'] = $grammer_third;
                    $data['course_details_vocabulary_first'] = $voca_first;
                    $data['course_details_vocabulary_second'] = $voca_second;
                    $data['course_details_vocabulary_third'] = $voca_third;
                    $data['course_details_diagonastic'] = $diagonastic_array;
                    $data['diagonastic_percentage'] = $diagonastic_array->ctn_question > 0 ? ($diagonastic_array->correct_answer_diagonostic * 100 / DIAGNOSTIC_QUESTION_NUM) : '';
                    $data['non_comprehension'] = $lenoco;
                    $data['comprehension'] = $leco;
                    $data['readalong'] = $readalong;
                    $data['face_to_face'] = $face_to_face;
                    $data['written_communication'] = $written_communication;
                    $proficency_score = $proficency != 0 ? ($proficency * 100) / $protencial : 0;
                    $data['confidence'] = getConfidenceData($child_id, $child, $proficency_score, $proficency_count);

                    $this->load->library('pdf');
                    $html = $this->load->view('pdf/finalscore_new', $data, true);
                    
                    if (!file_exists("./scorepdf/result/")) {
                        mkdir("./scorepdf/result/", 0777);
                    }
                    $filename = time() . rand() . "_" . $child->ss_aw_child_id . ".pdf";
                    $save_file_path = "./scorepdf/result/" . $filename;
                    $path = "scorepdf/result/" . $filename;
                    $gen_pdf = $this->pdf->createPDF($save_file_path, $html, $filename, false);

                    $child_result['ss_aw_child_id'] = $child->ss_aw_child_id;
                    $child_result['ss_aw_level'] = $child->course_level;
                    $child_result['ss_aw_report_path'] = $path;
                    $this->ss_aw_child_result_model->add_record($child_result);
                }
            }
        }
    }

}
