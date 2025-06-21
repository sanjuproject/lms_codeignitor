<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_audio_update extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("course_audio_update_model");
        $this->load->model("ss_aw_voice_type_matrix_model");
        $this->load->model("ss_aw_lessons_model");
        $this->load->model("ss_aw_assisment_diagnostic_model");
    }

    public function audio_update_cheat_code() {
//        $headerdata = $this->checklogin();
        $headerdata['title'] = "Audio Cheat code";
        $data = array();
        $this->load->view('admin/header_no_sidebar', $headerdata);
        $this->load->view('mannualy_update_audio', $data);
        $this->load->view('admin/footer');
    }

    public function create_audio_file() {
        $postdata = $this->input->post();
        $audio_id = 2;
        $course_matrix = array();
        if (!isset($postdata['title']) && !isset($postdata['details'])) {
            $this->session->set_flashdata('error', "Please select minimum one conversion checkbox");
            redirect("course_audio_update/audio_update_cheat_code/");
        }
        $audio_matrix = $this->ss_aw_voice_type_matrix_model->get_recordby_id($audio_id)[0];
        if ($postdata['course_type'] == 1) {
            $_path = "assets/audio/lessons/";
            $course_matrix[0] = array(
                "title" => "ss_aw_lesson_audio",
                "details" => "ss_aw_lesson_details_audio"
            );
            $course_matrix[1] = array(
                "title" => "ss_aw_lesson_audio_slow",
                "details" => "ss_aw_lesson_details_audio_slow"
            );
            $course_matrix[2] = array(
                "title" => "ss_aw_lesson_audio_fast",
                "details" => "ss_aw_lesson_details_audio_fast"
            );
            $details = $this->get_lesson_details($postdata, $audio_matrix, $_path, $course_matrix);
        } else {
            $_path = "assets/audio/assessment/";
            $course_matrix[0] = array(
                "title" => "ss_aw_question_preface_audio",
                "details" => "ss_aw_question_audio"
            );

            $details = $this->get_assesment_details($postdata, $audio_matrix, $_path, $course_matrix);
        }

        if ($details['status'] == 200) {
            $this->session->set_flashdata('success', $details['msg']);
        } else {
            $this->session->set_flashdata('error', $details['msg']);
        }
        redirect("course_audio_update/audio_update_cheat_code/");
    }

    public function get_lesson_details($postdata, $audio_matrix, $_path, $course_matrix) {
        $lesson = $this->course_audio_update_model->get_single_lesson_record($postdata['lesson_id']);
        if (!empty($lesson)) {
            $lesson_topic = trim($lesson->topic_name);
            if (isset($postdata['title']) && $postdata['title'] == 1) {
                $column = "title";
                $text = trim($lesson->ss_aw_lesson_title);
                $response = $this->generate_audio_file($postdata, $lesson, $text, $audio_matrix, $lesson_topic, $quiz_type = false, $column, $_path, $course_matrix);
            } if (isset($postdata['details']) && $postdata['details'] == 1) {
                $column = "details";
                $text = trim($lesson->ss_aw_lesson_details);
                $response = $this->generate_audio_file($postdata, $lesson, $text, $audio_matrix, $lesson_topic, $quiz_type = false, $column, $_path, $course_matrix);
            }
        } else {
            $response = array(
                "status" => 404,
                "msg" => "Data not found"
            );
        }
        return $response;
    }

    public function get_assesment_details($postdata, $audio_matrix, $_path, $course_matrix) {
        $lesson = $this->course_audio_update_model->get_single_assessment_record($postdata['lesson_id']);
        if (!empty($lesson)) {
            $lesson_topic = trim($lesson->topic_name);
            if (isset($postdata['title']) && $postdata['title'] == 1) {
                $column = "title";
                $text = trim($lesson->ss_aw_question_preface);
                $response = $this->generate_audio_file($postdata, $lesson, $text, $audio_matrix, $lesson_topic, $quiz_type = false, $column, $_path, $course_matrix);
            } if (isset($postdata['details']) && $postdata['details'] == 1) {
                $column = "details";
                $text = trim($lesson->ss_aw_question);
                $response = $this->generate_audio_file($postdata, $lesson, $text, $audio_matrix, $lesson_topic, $quiz_type = false, $column, $_path, $course_matrix);
            }
        } else {
            $response = array(
                "status" => 404,
                "msg" => "Data not found"
            );
        }
        return $response;
    }

    public function generate_audio_file($postdata, $lesson, $title_str, $audio_matrix, $lesson_topic, $quiz_type, $column, $_path, $course_matrix) {
        $remove_ary = array("[u]", "[/u]", "[b]", "[/b]", "[c]", "[/c]", "[h]", "[/h]");
        $title_str = str_ireplace($remove_ary, "", trim($title_str));
        $title_str = str_ireplace($remove_ary, "", trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $title_str))));
        $title_str = str_ireplace("i.e.", "that is", $title_str);
        $title_str = str_ireplace("/", ".", $title_str);
        $pattern = '/\[s\].*?\[\/s\]/';
        $title_str = preg_replace($pattern, '', $title_str);

        if ($quiz_type == FALSE) {
            $title_str = str_replace("/", " or ", $title_str);
        }
        if (!empty($title_str) && $title_str != 'NA') {
            //create directory//
            $lesson_topic = str_replace(" ", "_", strtolower($lesson_topic));
            $upload_path = $_path . $lesson_topic;
            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $ad_matrix[0] = array(
                "speed" => $audio_matrix->ss_aw_c_speed,
                "pitch" => $audio_matrix->ss_aw_c_pitch
            );
            $ad_matrix[1] = array(
                "speed" => $audio_matrix->ss_aw_e_speed,
                "pitch" => $audio_matrix->ss_aw_e_pitch
            );
            $ad_matrix[2] = array(
                "speed" => $audio_matrix->ss_aw_a_speed,
                "pitch" => $audio_matrix->ss_aw_a_pitch
            );
            $i = 0;
            foreach ($course_matrix as $c_matrix) {
                $audio = $this->generate_app_audio_file($title_str, $audio_matrix, $ad_matrix[$i], $upload_path);

                if ($audio['file_size'] > 0) {
                    $updateary = array();
                    if ($postdata['course_type'] == 1) {
                        $updateary['ss_aw_lession_id'] = $lesson->ss_aw_lession_id;
                        $updateary[$c_matrix[$column]] = $audio['file_path'];
                        $updateary['ss_aw_lesson_answers_audio_slow_exist'] = 1;
                        $this->ss_aw_lessons_model->update_record($updateary);
                    }if ($postdata['course_type'] == 2) {
                        $updateary['ss_aw_id'] = $lesson->ss_aw_id;
                        $updateary[$c_matrix[$column]] = $audio['file_path'];
                        $updateary['ss_aw_preface_audio_exist'] = 1;
                        $this->ss_aw_assisment_diagnostic_model->update_records($updateary);
                    }
                } else {
                    if (file_exists($audio_file)) {
                        unlink($audio_file);
                    }
                    $audio['file_path'] = '';
                    $audio['msg'] = 'File Not Generated';
                    $audio['status'] = 401;
                    return $audio;
                }
                $i++;
            }
            $response = array(
                "status" => 200,
                "msg" => "File updated successfully"
            );
            return $response;
        } else {
            $updateary = array();
            if ($postdata['course_type'] == 1) {
                $updateary['ss_aw_lession_id'] = $lesson->ss_aw_lession_id;
                $updateary['ss_aw_lesson_answers_audio_slow_exist'] = 3;
                $this->ss_aw_lessons_model->update_record($updateary);
            }if ($postdata['course_type'] == 2) {
                $updateary['ss_aw_id'] = $lesson->ss_aw_id;
                $updateary['ss_aw_preface_audio_exist'] = 1;
                $this->ss_aw_assisment_diagnostic_model->update_records($updateary);
            }
            $response = array(
                "status" => 200,
                "msg" => "No title found"
            );
            return $response;
        }
    }

    public function generate_app_audio_file($title_str, $audio_matrix_speed, $_matrix, $upload_path) {
        $audio_file = $upload_path . "/" . time() . "_" . rand() . ".mp3";
        $url = "https://texttospeech.googleapis.com/v1/text:synthesize?key=" . GOOGLE_KEY;
        $textary = array();
        $textary['input']['text'] = $title_str;
        $textary['voice']['languageCode'] = $audio_matrix_speed->ss_aw_language_code;
        $textary['voice']['name'] = $audio_matrix_speed->ss_aw_voice_type;
        //$textary['voice']['ssmlGender'] = 'FEMALE';
        $textary['audioConfig']['audioEncoding'] = 'MP3';
        $textary['audioConfig']['pitch'] = doubleval($_matrix['pitch']);
        $textary['audioConfig']['speakingRate'] = doubleval($_matrix['speed']);

        $audio_data = json_encode($textary);
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $audio_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        $final_output = json_decode($output, true);
        $final_output = base64_decode($final_output['audioContent']);
        file_put_contents($audio_file, $final_output);

        $filesize = filesize($audio_file);

        $response = array(
            "status" => 200,
            "file_size" => $filesize,
            "file_path" => $audio_file,
            "msg" => "Audio File Generated Successfully"
        );
        return $response;
    }

}
