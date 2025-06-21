
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assesment_question_match extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assesment_quetion_match_model');
    }

    public function set_question_for_user($all_ques_user_id, $course_id, $course_status, $topic, $destination_user_id = '') {
        $topic = str_replace("_", " ", $topic);
        if ($course_status == 'E') {
            $course_id_status = '1';
        } elseif ($course_status == 'C') {
            $course_id_status = '2';
        } elseif ($course_status == 'A') {
            $course_id_status = '3';
        } else {
            $course_id_status = $course_status;
        }

        if ($all_ques_user_id != '' && $course_id != '' && $topic != '') {
            $all_question = $this->assesment_quetion_match_model->get_all_active_question($all_ques_user_id, $course_id, $topic, $course_id_status);

            $all_user_id = $this->assesment_quetion_match_model->get_all_active_user_id($all_ques_user_id, $course_id, $topic, $course_id_status, $destination_user_id);

            $previous_ques = '';
            $total_user = 0;
            if (!empty($all_user_id)) {
                $count_user_updated = 0;
                $total_user = count($all_user_id->result());
                foreach ($all_user_id->result() as $usr_id) {
                    $i = 1;
                    //get the total question count & max create date                
                    $count_user_question = $this->assesment_quetion_match_model->get_user_question_count($usr_id->ss_aw_child_id, $course_id, $topic, $usr_id->course_id_status);

                    if (count($all_question->result()) > $count_user_question->count_qes) {

                        if (!empty($all_question)) {

                            foreach ($all_question->result() as $ques) {


                                $chk_data = $this->assesment_quetion_match_model->chek_question_availability($usr_id->ss_aw_child_id, $ques->ss_aw_question_id, $course_id, $topic, $usr_id->course_id_status);

                                if (empty($chk_data->result())) {
                                    $ques->ss_aw_created_date = $count_user_question->max_created_date;
                                    $ques->ss_aw_child_id = $usr_id->ss_aw_child_id;
                                    $ques->ss_aw_post_answer = '';
                                    $ques->ss_aw_answer_status = 2;
                                    $ques->ss_aw_seconds_to_start_answer_question = 0;
                                    $ques->ss_aw_seconds_to_answer_question = 0;
                                    unset($ques->ss_aw_id);
                                    unset($ques->course_id_status);
                                    $count_user_updated = $count_user_updated + $i;
                                    $i = 0;
                                    $this->assesment_quetion_match_model->Add('ss_aw_lesson_quiz_ans', $ques);
                                    $this->assesment_quetion_match_model->update_lessons_score($usr_id->ss_aw_child_id, $ques->ss_aw_lesson_id);
                                }
                            }
                        }
                    }
                }
                $total = '';
                if ($destination_user_id == '') {
                    $total = " from $total_user  + 1";
                }
                echo "updated user count $count_user_updated $total";
            }
        } else {
            echo "Please add proper data";
        }
    }

    public function change_question_for_user($destination_user_id, $course_id, $course_status, $topic) {
        $topic = str_replace("_", " ", $topic);
        if ($course_status == 'E') {
            $course_id_status = '1';
        } elseif ($course_status == 'C') {
            $course_id_status = '2';
        } elseif ($course_status == 'A') {
            $course_id_status = '3';
        } else {
            $course_id_status = $course_status;
        }



        if ($course_id != '' && $topic != '') {
            $all_active_question = $this->assesment_quetion_match_model->get_all_active_questionfrom_lesson($course_id, $topic, $course_id_status);
            if (!empty($all_active_question)) {
                $all_inactive_question = $this->assesment_quetion_match_model->get_all_destination_question($destination_user_id, $topic);

                if (!empty($all_inactive_question)) {
                    $all_question = $all_active_question->result_array();

                    $i = 0;
                    foreach ($all_inactive_question->result() as $inactive) {
                        $data['ss_aw_question_id'] = $all_question[$i]['ss_aw_lession_id'];
//                        $this->db->trans_begin();
                        $rest = $this->assesment_quetion_match_model->Edit("ss_aw_lesson_quiz_ans", $data, array('ss_aw_id' => $inactive->ss_aw_id));
//                        if ($rest == false) {
//                            $this->db->trans_rollback();
//                            echo "Error Some Problem Occured";
//                            break;
//                        } else {
//                            $this->db->trans_commit();
//                        }
                        $i++;
                    }
                    echo "Success";
                } else {
                    echo "No data found for destination user Please check parameter";
                }
            } else {
                echo "No data found for first user Please check parameter";
            }
        }
    }

    public function change_question_realalong_for_user($destination_user_id, $course_status, $topic) {
        $topic = str_replace("_", " ", $topic);
        if ($course_status == 'M') {
            $course_status = 'A';
        }
        $readalong = $this->assesment_quetion_match_model->get_all_readalongquestion($course_status, $topic);
         
        if (!empty($readalong)) {
            $all_readalong = $readalong->result_array();
            $needtochange = $this->assesment_quetion_match_model->get_all_user_readalong($destination_user_id, $course_status, $topic);
            if (!empty($needtochange)) {
                $i = 0;
                foreach ($needtochange->result() as $need) {
                    $data['ss_aw_quiz_id'] = $all_readalong[$i]['ss_aw_readalong_id'];
                    $rest = $this->assesment_quetion_match_model->Edit("ss_aw_readalong_quiz_ans", $data, array('ss_aw_id' => $need->ss_aw_id));
                    $i++;
                }
                echo "Success";
            } else {
                echo "No data found for destination user Please check parameter";
            }
        } else {
            echo "No data found for first user Please check parameter";
        }
    }

}
