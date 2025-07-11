<?php

/**
 * 
 */
class Ss_aw_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function totallessonquesion($child_id = array(), $search_data = array()) {
        @$quiz_type = $search_data['quiz_type'];
        $this->db->select('ss_aw_lessons.ss_aw_lession_id,ss_aw_lessons.ss_aw_lesson_title,ss_aw_lessons.ss_aw_lesson_details');
        $this->db->from('ss_aw_lessons');
        $this->db->where('ss_aw_lessons.ss_aw_lesson_delete', 0);
        $this->db->where('ss_aw_lessons.ss_aw_lesson_details !=', '');
        $this->db->where('ss_aw_lessons.ss_aw_lesson_quiz_type_id !=', 0);
        $this->db->join('ss_aw_lessons_uploaded', 'ss_aw_lessons.ss_aw_lesson_record_id = ss_aw_lessons_uploaded.ss_aw_lession_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_delete', 0);
        if (!empty($search_data['topics'])) {
            $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_topic', $search_data['topics']);
        }

        if (!empty($child_id)) {
            $child_id_str = implode(",", $child_id);
			if (!empty($search_data['start_date']) && !empty($search_data['end_date'])){
				$this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where ss_aw_lesson_quiz_ans.ss_aw_child_id IN ('.$child_id_str.') and DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) >= "'.$search_data['start_date'].'" and DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) <= "'.$search_data['end_date'].'" and ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
            }
			else{
				$this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where ss_aw_lesson_quiz_ans.ss_aw_child_id IN ('.$child_id_str.') and ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
			}
		}
		else{
			if (!empty($search_data['start_date']) && !empty($search_data['end_date'])){
				$this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) >= "'.$search_data['start_date'].'" and DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) <= "'.$search_data['end_date'].'" and ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
			}
			else{
                $this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
            }
        }
        return $this->db->get()->num_rows();
    }

    public function totalassessmentquestion($child_id = array(), $search_data = array()) {
        //$this->db->where('ss_aw_deleted', 1);
        //$this->db->where('ss_aw_status', 1);
        $this->db->where('ss_aw_question !=', '');
        if (!empty($search_data['topics'])) {
            $this->db->where('ss_aw_assisment_diagnostic.ss_aw_category', $search_data['topics']);
        }

        if (!empty($child_id)) {
            $child_id_str = implode(",", $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) <= "' . $search_data['end_date'] . '" and ss_aw_assesment_multiple_question_answer.ss_aw_child_id IN (' . $child_id_str . ') and ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_assessment_exam_log.ss_aw_log_child_id IN (' . $child_id_str . ') and ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            } else {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where ss_aw_assesment_multiple_question_answer.ss_aw_child_id IN (' . $child_id_str . ') and ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where ss_aw_assessment_exam_log.ss_aw_log_child_id IN (' . $child_id_str . ') and ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            }
        } else {
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) <= "' . $search_data['end_date'] . '" and ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            } else {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            }
        }
        return $this->db->get('ss_aw_assisment_diagnostic')->num_rows();
    }

    public function totaldiagnosticquestion($child_id = array(), $search_data = array()) {
        //$this->db->where('ss_aw_deleted', 1);
        //$this->db->where('ss_aw_status', 1);
        $this->db->where('ss_aw_question !=', '');
        $this->db->where('ss_aw_quiz_type', 1);
        if (!empty($search_data['topics'])) {
            $this->db->where('ss_aw_assisment_diagnostic.ss_aw_category', $search_data['topics']);
        }

        if (!empty($child_id)) {
            $child_id_str = implode(",", $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id IN (' . $child_id_str . ') and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) !=', 0);
            } else {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id IN (' . $child_id_str . ') and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) !=', 0);
            }
        } else {
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) != 0');
            } else {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) != 0');
            }
        }
        return $this->db->get('ss_aw_assisment_diagnostic')->num_rows();
    }

    public function totalreadalongquestion($child_id = array(), $search_data = array()) {
        $this->db->select('*');
        $this->db->from('ss_aw_readalong_quiz');
        $this->db->join('ss_aw_readalong_quiz_ans', 'ss_aw_readalong_quiz_ans.ss_aw_quiz_id = ss_aw_readalong_quiz.ss_aw_readalong_id');
        if (!empty($child_id)) {
            $this->db->where_in('ss_aw_readalong_quiz_ans.ss_aw_child_id', $child_id);
        }
        $this->db->where('ss_aw_readalong_quiz.ss_aw_readalong_upload_id', $search_data['topics']);
        return $this->db->get()->num_rows();
    }

    public function fetchalllessonsquestions2($child_id = array(), $search_data = array(), $limit, $start) {
        $quiz_type = @$search_data['quiz_type'];
        if (!empty($search_data['start_date'] && $search_data['start_date'] < report_date_from)) {
            $search_data['start_date'] = report_date_from;
        }

        $this->db->select('ss_aw_lessons.ss_aw_lesson_answers,ss_aw_lessons.ss_aw_lession_id,'
                . 'ss_aw_lessons.ss_aw_lesson_title,ss_aw_lessons.ss_aw_lesson_details,'
                . 'ss_aw_lessons.ss_aw_lesson_record_id,ss_aw_lessons.ss_aw_lesson_format,'
                . 'ss_aw_lessons.ss_aw_course_id,ss_aw_lessons_uploaded.ss_aw_course_id as course_level,'
                . 'ss_aw_lessons_uploaded.ss_aw_lesson_topic as topic_name');
        $this->db->from('ss_aw_lessons_uploaded');
        $this->db->join('ss_aw_lessons', 'ss_aw_lessons.ss_aw_lesson_record_id = ss_aw_lessons_uploaded.ss_aw_lession_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_delete', 0);
        $this->db->where('ss_aw_lessons.ss_aw_lesson_delete', 0);
        $this->db->where('ss_aw_lessons.ss_aw_lesson_details !=', '');
        if (!empty($search_data['topics'])) {
            $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_topic', $search_data['topics']);
        }

        if (!empty($child_id)) {
            $child_id_str = implode(",", $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where ss_aw_lesson_quiz_ans.ss_aw_child_id IN (' . $child_id_str . ') and DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
            } else {
                $this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where ss_aw_lesson_quiz_ans.ss_aw_child_id IN (' . $child_id_str . ') and ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
            }
        } else {
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_lesson_quiz_ans.ss_aw_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
            } else {
                $this->db->where('(select count(*) from ss_aw_lesson_quiz_ans where ss_aw_lesson_quiz_ans.ss_aw_question_id = ss_aw_lessons.ss_aw_lession_id) != 0');
            }
        }

        $this->db->order_by('ss_aw_lessons.ss_aw_lesson_created_date', 'desc');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function fetchallassessmentquestions($child_id = array(), $search_data = array(), $limit, $start) {
        $this->db->select('ss_aw_assisment_diagnostic.ss_aw_answers, ss_aw_assisment_diagnostic.ss_aw_seq_no, ss_aw_assisment_diagnostic.ss_aw_format, ss_aw_assisment_diagnostic.ss_aw_id, ss_aw_assisment_diagnostic.ss_aw_question_preface,ss_aw_assisment_diagnostic.ss_aw_question, ss_aw_assisment_diagnostic.ss_aw_level,ss_aw_assesment_uploaded.ss_aw_course_id,ss_aw_assesment_uploaded.ss_aw_assesment_topic as topic_name');
        $this->db->from('ss_aw_assesment_uploaded');
        $this->db->join('ss_aw_assisment_diagnostic', 'ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id = ss_aw_assesment_uploaded.ss_aw_assessment_id');
        $this->db->where('ss_aw_assisment_diagnostic.ss_aw_question !=', '');
        if (!empty($search_data['topics'])) {
            $this->db->where('ss_aw_assisment_diagnostic.ss_aw_category', $search_data['topics']);
        }

        if (!empty($child_id)) {
            $child_id_str = implode(",", $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) <= "' . $search_data['end_date'] . '" and ss_aw_assesment_multiple_question_answer.ss_aw_child_id IN (' . $child_id_str . ') and ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_assessment_exam_log.ss_aw_log_child_id IN (' . $child_id_str . ') and ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            } else {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where ss_aw_assesment_multiple_question_answer.ss_aw_child_id IN (' . $child_id_str . ') and ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where ss_aw_assessment_exam_log.ss_aw_log_child_id IN (' . $child_id_str . ') and ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            }
        } else {
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assesment_multiple_question_answer.ss_aw_created_at) <= "' . $search_data['end_date'] . '" and ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_assessment_exam_log.ss_aw_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            } else {
                $this->db->where('((select count(*) from ss_aw_assesment_multiple_question_answer where ss_aw_assesment_multiple_question_answer.ss_aw_question = ss_aw_assisment_diagnostic.ss_aw_question) != 0 or (select count(*) from ss_aw_assessment_exam_log where ss_aw_assessment_exam_log.ss_aw_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id)) != 0');
            }
        }
        $this->db->order_by('ss_aw_assisment_diagnostic.ss_aw_id', 'asc');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function fetchalldiagnosticquestions($child_id = array(), $search_data = array(), $limit, $start) {
        $this->db->select('ss_aw_assisment_diagnostic.ss_aw_answers, ss_aw_assisment_diagnostic.ss_aw_format, ss_aw_assisment_diagnostic.ss_aw_id, ss_aw_assisment_diagnostic.ss_aw_question_preface,ss_aw_assisment_diagnostic.ss_aw_question, ss_aw_assisment_diagnostic.ss_aw_level,ss_aw_assesment_uploaded.ss_aw_course_id,ss_aw_assesment_uploaded.ss_aw_assesment_topic as topic_name,ss_aw_assisment_diagnostic.ss_aw_seq_no');
        $this->db->from('ss_aw_assesment_uploaded');
        $this->db->join('ss_aw_assisment_diagnostic', 'ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id = ss_aw_assesment_uploaded.ss_aw_assessment_id');
        $this->db->where('ss_aw_assisment_diagnostic.ss_aw_quiz_type', 1);
        $this->db->where('ss_aw_assisment_diagnostic.ss_aw_question !=', '');
        if (!empty($search_data['topics'])) {
            $this->db->where('ss_aw_assisment_diagnostic.ss_aw_category', $search_data['topics']);
        }

        if (!empty($child_id)) {
            $child_id_str = implode(",", $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id IN (' . $child_id_str . ') and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) !=', 0);
            } else {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id IN (' . $child_id_str . ') and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) !=', 0);
            }
        } else {
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) >= "' . $search_data['start_date'] . '" and DATE(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_created_date) <= "' . $search_data['end_date'] . '" and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) != 0');
            } else {
                $this->db->where('(select count(*) from ss_aw_diagonastic_exam_log where ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id = ss_aw_assisment_diagnostic.ss_aw_id and ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status != 3) != 0');
            }
        }
        $this->db->order_by('ss_aw_assisment_diagnostic.ss_aw_created_date', 'desc');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function fetchallreadalongquestions($child_id = array(), $search_data = array(), $limit, $start) {
        $this->db->select('ss_aw_readalong_quiz.*, ss_aw_readalongs_upload.ss_aw_level');
        $this->db->from('ss_aw_readalong_quiz');
        $this->db->join('ss_aw_readalongs_upload', 'ss_aw_readalongs_upload.ss_aw_id = ss_aw_readalong_quiz.ss_aw_readalong_upload_id');
        $this->db->join('ss_aw_readalong_quiz_ans', 'ss_aw_readalong_quiz_ans.ss_aw_quiz_id = ss_aw_readalong_quiz.ss_aw_readalong_id');
        if (!empty($child_id)) {
            $this->db->where_in('ss_aw_readalong_quiz_ans.ss_aw_child_id', $child_id);
        }
        $this->db->where('ss_aw_readalong_quiz.ss_aw_readalong_upload_id', $search_data['topics']);
        return $this->db->get()->result();
    }

    public function getallquestions($limit, $start) {
        $this->db->select('ss_aw_lessons.ss_aw_lession_id,ss_aw_lessons.ss_aw_lesson_title,ss_aw_lessons.ss_aw_lesson_details,ss_aw_lessons.ss_aw_lesson_record_id,ss_aw_lessons.ss_aw_lesson_format,ss_aw_lessons.ss_aw_course_id,ss_aw_lessons_uploaded.ss_aw_course_id as course_level');
        $this->db->from('ss_aw_lessons_uploaded');
        $this->db->join('ss_aw_lessons', 'ss_aw_lessons.ss_aw_lesson_record_id = ss_aw_lessons_uploaded.ss_aw_lession_id');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function fetchalltotalquestionnum() {
        $this->db->select('ss_aw_lessons.ss_aw_lession_id,ss_aw_lessons.ss_aw_lesson_title,ss_aw_lessons.ss_aw_lesson_details');
        $this->db->from('ss_aw_lessons_uploaded');
        $this->db->join('ss_aw_lessons', 'ss_aw_lessons.ss_aw_lesson_record_id = ss_aw_lessons_uploaded.ss_aw_lession_id');
        return $this->db->get()->num_rows();
    }

    public function getassesmentquestion($lesson_ids) {
        $this->db->select('ss_aw_assisment_diagnostic.ss_aw_id,ss_aw_assisment_diagnostic.ss_aw_question,ss_aw_assisment_diagnostic.ss_aw_format,ss_aw_assisment_diagnostic.ss_aw_level,ss_aw_assesment_uploaded.ss_aw_course_id');
        $this->db->from('ss_aw_assesment_uploaded');
        $this->db->join('ss_aw_assisment_diagnostic', 'ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id = ss_aw_assesment_uploaded.ss_aw_assessment_id');
        $this->db->where_in('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_ids);
        return $this->db->get()->result();
    }

    public function totalnoofquestionasked($search_data = array(), $child_id = array(), $question, $quiz_type = "", $format = "", $question_id = "") {
        if ($quiz_type == 1) {
            $this->db->select('ss_aw_id');
            $this->db->from('ss_aw_lesson_quiz_ans');
            $this->db->where('ss_aw_question_id', $question);

            if (!empty($child_id)) {
                $this->db->where_in('ss_aw_child_id', $child_id);
            }
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_created_date <=', $search_data['end_date']);
            }
            return $this->db->get()->result();
        } elseif ($quiz_type == 2) {
            if ($format == 'Multiple') {
                $this->db->select('ss_aw_id as log_id');
                $this->db->from('ss_aw_assesment_multiple_question_answer');
                $this->db->where('ss_aw_question', $question);
                if (!empty($child_id)) {
                    $this->db->where_in('ss_aw_child_id', $child_id);
                }
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_created_at >=', $search_data['start_date']);
                    $this->db->where('ss_aw_created_at <=', $search_data['end_date']);
                }
                $this->db->group_by('ss_aw_child_id');
                return $this->db->get()->result();
            } else {
                $this->db->select('ss_aw_log_id as log_id');
                $this->db->from('ss_aw_assessment_exam_log');
                $this->db->where('ss_aw_log_question_id', $question_id);
                $this->db->where('ss_aw_log_answer_status !=', 3);
                if (!empty($child_id)) {
                    $this->db->where_in('ss_aw_log_child_id', $child_id);
                }
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_log_created_date >=', $search_data['start_date']);
                    $this->db->where('ss_aw_log_created_date <=', $search_data['end_date']);
                }
                $this->db->group_by('ss_aw_log_child_id');
                return $this->db->get()->result();
            }
        } elseif ($quiz_type == 4) {
            $this->db->where('ss_aw_quiz_id', $question);
            if (!empty($child_id)) {
                $this->db->where_in('ss_aw_child_id', $child_id);
            }
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_created_date <=', $search_data['end_date']);
            }
            return $this->db->get('ss_aw_readalong_quiz_ans')->num_rows();
        }
    }

    public function totalnoofcorrectanswer($search_data = array(), $child_id = array(), $question, $quiz_type = "", $format = "", $question_id = "", $log_ids = array()) {
        if ($quiz_type == 1 || $quiz_type == "") {
            $this->db->where('ss_aw_question_id', $question);
            $this->db->where('ss_aw_answer_status', 1);
            if (!empty($child_id)) {
                $this->db->where_in('ss_aw_child_id', $child_id);
            }
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_created_date <=', $search_data['end_date']);
            }
            if (!empty($log_ids)) {
                $this->db->where_in('ss_aw_id', $log_ids);
            }
            //$this->db->group_by('ss_aw_child_id');
            return $this->db->get('ss_aw_lesson_quiz_ans')->num_rows();
        } elseif ($quiz_type == 2) {
            if ($format == 'Multiple') {
                $this->db->where('ss_aw_question', $question);
                $this->db->where('ss_aw_answers_status', 1);
                if (!empty($child_id)) {
                    $this->db->where_in('ss_aw_child_id', $child_id);
                }
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_created_at >=', $search_data['start_date']);
                    $this->db->where('ss_aw_created_at <=', $search_data['end_date']);
                }
                if (!empty($log_ids)) {
                    $this->db->where_in('ss_aw_id', $log_ids);
                }
                //$this->db->group_by('ss_aw_child_id');
                return $this->db->get('ss_aw_assesment_multiple_question_answer')->num_rows();
            } else {
                $this->db->select('ss_aw_log_answers as wrong_answer');
                $this->db->from('ss_aw_assessment_exam_log');
                $this->db->where('ss_aw_log_question_id', $question_id);
                $this->db->where('ss_aw_log_answer_status', 1);
                if (!empty($child_id)) {
                    $this->db->where_in('ss_aw_log_child_id', $child_id);
                }
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_log_created_date >=', $search_data['start_date']);
                    $this->db->where('ss_aw_log_created_date <=', $search_data['end_date']);
                }
                if (!empty($log_ids)) {
                    $this->db->where_in('ss_aw_log_id', $log_ids);
                }
                //$this->db->group_by('ss_aw_log_child_id');
                return $this->db->get()->num_rows();
            }
        } elseif ($quiz_type == 4) {
            $this->db->where('ss_aw_quiz_id', $question);
            $this->db->where('ss_aw_quiz_right_wrong', 1);
            if (!empty($child_id)) {
                $this->db->where_in('ss_aw_child_id', $child_id);
            }
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_created_date <=', $search_data['end_date']);
            }
            $this->db->group_by('ss_aw_child_id');
            return $this->db->get('ss_aw_readalong_quiz_ans')->num_rows();
        }
    }

    public function totalnoofdiagnosticquestionasked($search_data = array(), $child_id = array(), $question_id) {
        $this->db->select('ss_aw_diagonastic_log_id');
        $this->db->from('ss_aw_diagonastic_exam_log');
        $this->db->where('ss_aw_diagonastic_log_question_id', $question_id);
        $this->db->where('ss_aw_diagonastic_log_answer_status !=', 3);
        if (!empty($child_id)) {
            $this->db->where_in('ss_aw_diagonastic_log_child_id', $child_id);
        }
        if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
            $this->db->where('DATE(ss_aw_diagonastic_log_created_date) >=', $search_data['start_date']);
            $this->db->where('DATE(ss_aw_diagonastic_log_created_date) <=', $search_data['end_date']);
        }
        $this->db->group_by('ss_aw_diagonastic_log_child_id');
        return $this->db->get()->result();
    }

    public function totalnoofdiagnosticcorrectanswer($search_data = array(), $child_id = array(), $question_id, $log_ids = array()) {
        $this->db->where('ss_aw_diagonastic_log_question_id', $question_id);
        $this->db->where('ss_aw_diagonastic_log_answer_status', 1);
        if (!empty($child_id)) {
            $this->db->where_in('ss_aw_diagonastic_log_child_id', $child_id);
        }
        if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
            $this->db->where('DATE(ss_aw_diagonastic_log_created_date) >=', $search_data['start_date']);
            $this->db->where('DATE(ss_aw_diagonastic_log_created_date) <=', $search_data['end_date']);
        }
        if (!empty($log_ids)) {
            $this->db->where_in('ss_aw_diagonastic_log_id', $log_ids);
        }
        //$this->db->group_by('ss_aw_diagonastic_log_child_id');
        return $this->db->get('ss_aw_diagonastic_exam_log')->num_rows();
    }

    public function student_lesson_complete_num($lesson_id, $searchary = array()) {
        $this->db->select('*');
        $this->db->from('ss_aw_child_last_lesson');
        $this->db->where('ss_aw_child_last_lesson.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_child_last_lesson.ss_aw_lesson_status', 2);
        if (!empty($searchary)) {
            $start_age = $searchary['start_age'];
            $end_age = $searchary['end_age'];
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_child_last_lesson.ss_aw_child_id');
            $this->db->where('ss_aw_childs.ss_aw_child_age >=', $start_age);
            $this->db->where('ss_aw_childs.ss_aw_child_age <=', $end_age);
        }
        return $this->db->get()->num_rows();
    }

    public function get_all_lesson($search_data = array()) {
        $this->db->select('*');
        $this->db->from('ss_aw_lessons_uploaded');
        if (!empty($search_data['assign_level'])) {
            $where = "FIND_IN_SET('" . $search_data['assign_level'] . "', ss_aw_course_id)";
            $this->db->where($where);
        }
        $this->db->where('ss_aw_lesson_delete', 0);
        $this->db->order_by('ss_aw_sl_no', 'ASC');
        return $this->db->get()->result();
    }

    public function get_lesson_completion_detail($search_data) {
        $this->db->select('ss_aw_lessons_uploaded.*,COUNT(ss_aw_child_last_lesson.ss_aw_las_lesson_id) as lesson_complete_count');
        $this->db->from('ss_aw_lessons_uploaded');
        $this->db->join('ss_aw_child_last_lesson', 'ss_aw_child_last_lesson.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id');
        if (!empty($search_data['assign_level'])) {
            $where = "FIND_IN_SET('" . $search_data['assign_level'] . "', ss_aw_course_id)";
            $this->db->where($where);
        }

        if (!empty($search_data['age'])) {
            if ($search_data['age'] == 1) {
                $start_age = 10;
                $end_age = 12;
            } elseif ($search_data['age'] == 2) {
                $start_age = 12;
                $end_age = 14;
            } else {
                $start_age = 14;
                $end_age = 16;
            }
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_child_last_lesson.ss_aw_child_id');
            $this->db->where('ss_aw_childs.ss_aw_child_age >=', $start_age);
            $this->db->where('ss_aw_childs.ss_aw_child_age <=', $end_age);
        }
        $this->db->group_by('ss_aw_lessons_uploaded.ss_aw_lession_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_delete', 0);
        $this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no', 'ASC');
        return $this->db->get()->result();
    }

    public function getalltotalscorebylevel($level) {
        $this->db->where('ss_aw_course_level', $level);
        return $this->db->get('ss_aw_lesson_assessment_total_score')->result();
    }

    public function getstudentcountbypercentagescore($level, $lesson_start_percentage, $lesson_end_percentage, $assessment_start_percentage, $assessment_end_percentage) {
        $this->db->where('ss_aw_course_level', $level);
        if ($assessment_start_percentage == 0) {
            $this->db->where('ss_aw_assessment_in_level_score >=', $assessment_start_percentage);
        } else {
            $this->db->where('ss_aw_assessment_in_level_score >', $assessment_start_percentage);
        }
        $this->db->where('ss_aw_assessment_in_level_score <=', $assessment_end_percentage);
        if ($lesson_start_percentage == 0) {
            $this->db->where('ss_aw_lesson_quiz_correct_percentage >=', $lesson_start_percentage);
        } else {
            $this->db->where('ss_aw_lesson_quiz_correct_percentage >', $lesson_start_percentage);
        }
        $this->db->where('ss_aw_lesson_quiz_correct_percentage <=', $lesson_end_percentage);
        return $this->db->get('ss_aw_lesson_assessment_total_score')->num_rows();
    }

    public function getstudentcountofdiagnosticassessment($level, $lesson_start_percentage, $lesson_end_percentage, $assessment_start_percentage, $assessment_end_percentage) {
        $this->db->where('ss_aw_level', $level);
        if ($assessment_start_percentage == 0) {
            $this->db->where('ss_aw_review_percentage >=', $assessment_start_percentage);
        } else {
            $this->db->where('ss_aw_review_percentage >', $assessment_start_percentage);
        }
        $this->db->where('ss_aw_review_percentage <=', $assessment_end_percentage);
        if ($lesson_start_percentage == 0) {
            $this->db->where('ss_aw_diagnostic_correct_percentage >=', $lesson_start_percentage);
        } else {
            $this->db->where('ss_aw_diagnostic_correct_percentage >', $lesson_start_percentage);
        }
        $this->db->where('ss_aw_diagnostic_correct_percentage <=', $lesson_end_percentage);
        return $this->db->get('ss_aw_diagnostic_review_score')->num_rows();
    }

    public function retentionscoredetail($assign_level, $start_percentage, $end_percentage) {
        $this->db->where('ss_aw_course_level', $assign_level);
        $this->db->where('(ss_aw_assessment_in_level_score - ss_aw_lesson_quiz_correct_percentage) >=', $start_percentage);
        $this->db->where('(ss_aw_assessment_in_level_score - ss_aw_lesson_quiz_correct_percentage) <=', $end_percentage);
        return $this->db->get('ss_aw_lesson_assessment_total_score')->num_rows();
    }

    public function improvementscoredetail($assign_level, $start_percentage, $end_percentage) {
        $this->db->where('ss_aw_level', $assign_level);
        $this->db->where('(ss_aw_review_percentage - ss_aw_diagnostic_correct_percentage) >=', $start_percentage);
        $this->db->where('(ss_aw_review_percentage - ss_aw_diagnostic_correct_percentage) <=', $end_percentage);
        return $this->db->get('ss_aw_diagnostic_review_score')->num_rows();
    }

    public function totalactivestudents($assign_level) {
        $this->db->where('ss_aw_child_status', 1);
        $this->db->where('ss_aw_child_delete', 0);
        return $this->db->get('ss_aw_childs')->num_rows();
    }

    public function getallperticipantnumbyassessmentid($lesson_id, $format_type = "") {
        $this->db->select('GROUP_CONCAT(DISTINCT(ss_aw_assessment_exam_completed.ss_aw_child_id)) as child_id');
        $this->db->from('ss_aw_assessment_exam_completed');
        $this->db->join('ss_aw_assesment_uploaded', 'ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('DATE(ss_aw_assessment_exam_completed.ss_aw_create_date) >=', report_date_from);
        //$this->db->group_by('ss_aw_exam_code');
        return $this->db->get()->result();
    }

    public function formatonenextlevelperticipantnum($child_id, $lesson_id, $level_type) {
        $this->db->select('*');
        $this->db->from('ss_aw_assesment_questions_asked');
        $this->db->join('ss_aw_assesment_uploaded', 'ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assesment_questions_asked.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_asked_level !=', $level_type);
        return $this->db->get()->num_rows();
    }

    public function formattwonextlevelperticipantnum($child_id, $assessment_id, $level_type) {
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_assessment_id', $assessment_id);
        $this->db->where('ss_aw_level !=', $level_type);
        return $this->db->get('ss_aw_assesment_multiple_question_answer')->num_rows();
    }

    public function getreadalongselectionnum($level, $readalong_title, $type = "") {
        //type = 1....Current Year,type = 2.....Current Month
        $current_year = date('Y');
        $current_month = date('m');
        $this->db->select('*');
        $this->db->from('ss_aw_schedule_readalong');
        $this->db->join('ss_aw_readalongs_upload', 'ss_aw_schedule_readalong.ss_aw_readalong_id = ss_aw_readalongs_upload.ss_aw_id');
        $this->db->where('ss_aw_readalongs_upload.ss_aw_title', $readalong_title);
        $this->db->where('ss_aw_readalongs_upload.ss_aw_level', $level);
        if ($type == 1) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
        } elseif ($type == 2) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
            $this->db->where('MONTH(ss_aw_schedule_readalong.ss_aw_create_date)', $current_month);
        }
        $this->db->where('(select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id) > 0');
        return $this->db->get()->num_rows();
    }

    public function getreadalongselectedusers($level, $readalong_title, $type = "") {
        //type = 1....Current Year,type = 2.....Current Month
        $current_year = date('Y');
        $current_month = date('m');
        $this->db->select('ss_aw_schedule_readalong.ss_aw_start_date, ss_aw_childs.ss_aw_child_nick_name, ss_aw_childs.ss_aw_child_id');
        $this->db->from('ss_aw_schedule_readalong');
        $this->db->join('ss_aw_readalongs_upload', 'ss_aw_schedule_readalong.ss_aw_readalong_id = ss_aw_readalongs_upload.ss_aw_id');
        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id', 'left');
        $this->db->where('ss_aw_readalongs_upload.ss_aw_title', $readalong_title);
        $this->db->where('ss_aw_readalongs_upload.ss_aw_level', $level);
        if ($type == 1) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
        } elseif ($type == 2) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
            $this->db->where('MONTH(ss_aw_schedule_readalong.ss_aw_create_date)', $current_month);
        }
        $this->db->where('(select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id) > 0');
        return $this->db->get()->result();
    }

    public function getreadalongcompletednum($level, $readalong_title, $type = "") {
        //type = 1....Current Year,type = 2.....Current Month
        $current_year = date('Y');
        $current_month = date('m');
        $this->db->select('*');
        $this->db->from('ss_aw_schedule_readalong');
        $this->db->join('ss_aw_readalongs_upload', 'ss_aw_schedule_readalong.ss_aw_readalong_id = ss_aw_readalongs_upload.ss_aw_id');
        $this->db->where('ss_aw_readalongs_upload.ss_aw_title', $readalong_title);
        $this->db->where('ss_aw_readalongs_upload.ss_aw_level', $level);
        if ($type == 1) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
        } elseif ($type == 2) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
            $this->db->where('MONTH(ss_aw_schedule_readalong.ss_aw_create_date)', $current_month);
        }
        $this->db->where('(select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id) > 0');
        $this->db->where('ss_aw_schedule_readalong.ss_aw_readalong_status', 1);
        return $this->db->get()->num_rows();
    }

    public function getreadalongcompletedusers($level, $readalong_title, $type = "") {
        //type = 1....Current Year,type = 2.....Current Month
        $current_year = date('Y');
        $current_month = date('m');
        $this->db->select('ss_aw_schedule_readalong.ss_aw_readalong_id,ss_aw_schedule_readalong.ss_aw_start_date, ss_aw_childs.ss_aw_child_nick_name, ss_aw_childs.ss_aw_child_id, (select ss_aw_last_readalong.ss_aw_create_date from ss_aw_last_readalong where ss_aw_last_readalong.ss_aw_readalong_id = ss_aw_schedule_readalong.ss_aw_readalong_id and ss_aw_last_readalong.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id) as complete_date');
        $this->db->from('ss_aw_schedule_readalong');
        $this->db->join('ss_aw_readalongs_upload', 'ss_aw_schedule_readalong.ss_aw_readalong_id = ss_aw_readalongs_upload.ss_aw_id');
        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id', 'left');
        $this->db->where('ss_aw_readalongs_upload.ss_aw_title', $readalong_title);
        $this->db->where('ss_aw_readalongs_upload.ss_aw_level', $level);
        if ($type == 1) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
        } elseif ($type == 2) {
            $this->db->where('YEAR(ss_aw_schedule_readalong.ss_aw_create_date)', $current_year);
            $this->db->where('MONTH(ss_aw_schedule_readalong.ss_aw_create_date)', $current_month);
        }
        $this->db->where('ss_aw_schedule_readalong.ss_aw_readalong_status', 1);
        $this->db->where('(select count(*) from ss_aw_childs where ss_aw_childs.ss_aw_child_id = ss_aw_schedule_readalong.ss_aw_child_id) > 0');
        return $this->db->get()->result();
    }

    public function getFUTstudents() {
        $this->db->select('ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_childs.ss_aw_child_id as child_id');
        $this->db->from('ss_aw_diagonastic_exam');
        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id');
        $this->db->where('ss_aw_diagonastic_exam.ss_aw_diagonastic_exam_date >=', '2021-12-14');
        return $this->db->get()->result();
    }

    public function getFUTstudentsassessmentreport($child_id, $assessment_id) {
        $this->db->select('ss_aw_assessment_exam_log.ss_aw_log_level as question_level, ss_aw_assessment_exam_log.ss_aw_log_answers as student_answer, ss_aw_assessment_exam_log.ss_aw_log_right_answers as correct_answer,ss_aw_assisment_diagnostic.ss_aw_question_preface as question_preface, ss_aw_assisment_diagnostic.ss_aw_question as question');
        $this->db->from('ss_aw_assessment_exam_completed');
        $this->db->join('ss_aw_assessment_exam_log', 'ss_aw_assessment_exam_log.ss_aw_log_exam_code = ss_aw_assessment_exam_completed.ss_aw_exam_code');
        $this->db->join('ss_aw_assisment_diagnostic', 'ss_aw_assisment_diagnostic.ss_aw_id = ss_aw_assessment_exam_log.ss_aw_log_question_id');
        $this->db->where('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_assessment_exam_completed.ss_aw_assessment_id', $assessment_id);
        return $this->db->get()->result();
    }

    public function totalnoofincorrectanswer($search_data = array(), $child_id = array(), $question, $quiz_type = "", $format = "", $question_id = "", $log_ids = array()) {
        if ($quiz_type == 1 || $quiz_type == "") {
            $this->db->where('ss_aw_question_id', $question);
            $this->db->where('ss_aw_answer_status', 2);
            if (!empty($child_id)) {
                $this->db->where_in('ss_aw_child_id', $child_id);
            }
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_created_date <=', $search_data['end_date']);
            }
            if (!empty($log_ids)) {
                $this->db->where_in('ss_aw_id', $log_ids);
            }
            //$this->db->group_by('ss_aw_child_id');
            return $this->db->get('ss_aw_lesson_quiz_ans')->num_rows();
        } elseif ($quiz_type == 2) {
            if ($format == 'Multiple') {
                $this->db->where('ss_aw_question', $question);
                $this->db->where('ss_aw_answers_status', 2);
                if (!empty($child_id)) {
                    $this->db->where_in('ss_aw_child_id', $child_id);
                }
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_created_at >=', $search_data['start_date']);
                    $this->db->where('ss_aw_created_at <=', $search_data['end_date']);
                }
                if (!empty($log_ids)) {
                    $this->db->where_in('ss_aw_id', $log_ids);
                }
                //$this->db->group_by('ss_aw_child_id');
                return $this->db->get('ss_aw_assesment_multiple_question_answer')->num_rows();
            } else {
                $this->db->select('*');
                $this->db->from('ss_aw_assessment_exam_log');
                $this->db->where('ss_aw_log_question_id', $question_id);
                $this->db->where('ss_aw_log_answer_status', 2);
                if (!empty($child_id)) {
                    $this->db->where_in('ss_aw_log_child_id', $child_id);
                }
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_log_created_date >=', $search_data['start_date']);
                    $this->db->where('ss_aw_log_created_date <=', $search_data['end_date']);
                }
                if (!empty($log_ids)) {
                    $this->db->where_in('ss_aw_log_id', $log_ids);
                }
                //$this->db->group_by('ss_aw_log_child_id');
                return $this->db->get()->num_rows();
            }
        } elseif ($quiz_type == 4) {
            $this->db->where('ss_aw_quiz_id', $question);
            $this->db->where('ss_aw_quiz_right_wrong', 2);
            if (!empty($child_id)) {
                $this->db->where_in('ss_aw_child_id', $child_id);
            }
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_created_date <=', $search_data['end_date']);
            }
            $this->db->group_by('ss_aw_child_id');
            return $this->db->get('ss_aw_readalong_quiz_ans')->num_rows();
        }
    }

    public function totalnoofdiagnosticincorrectanswer($search_data = array(), $child_id = array(), $question_id, $log_ids = array()) {
        $this->db->where('ss_aw_diagonastic_log_question_id', $question_id);
        $this->db->where('ss_aw_diagonastic_log_answer_status ', 2);
        if (!empty($child_id)) {
            $this->db->where_in('ss_aw_diagonastic_log_child_id', $child_id);
        }
        if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
            $this->db->where('DATE(ss_aw_diagonastic_log_created_date) >=', $search_data['start_date']);
            $this->db->where('DATE(ss_aw_diagonastic_log_created_date) <=', $search_data['end_date']);
        }
        if (!empty($log_ids)) {
            $this->db->where_in('ss_aw_diagonastic_log_id', $log_ids);
        }
        //$this->db->group_by('ss_aw_diagonastic_log_child_id');
        return $this->db->get('ss_aw_diagonastic_exam_log')->num_rows();
    }

    public function get_all_wrong_answers($child_id = array(), $quiz_type, $question, $question_format = "", $question_id = "") {
        if ($quiz_type == 1) {
            $this->db->select('ss_aw_post_answer as wrong_answer');
            $this->db->from('ss_aw_lesson_quiz_ans');
            $this->db->where('ss_aw_question_id', $question);
            $this->db->where_in('ss_aw_child_id', $child_id);
            $this->db->where('ss_aw_answer_status', 2);
            return $this->db->get()->result();
        } elseif ($quiz_type == 2) {
            if ($question_format == 'Multiple') {
                $this->db->select('ss_aw_answer as wrong_answer');
                $this->db->from('ss_aw_assesment_multiple_question_answer');
                $this->db->where('ss_aw_question', $question);
                $this->db->where('ss_aw_answers_status', 2);
                $this->db->where_in('ss_aw_child_id', $child_id);
                return $this->db->get()->result();
            } elseif ($question_format == 'Single') {
                $this->db->select('ss_aw_log_answers as wrong_answer');
                $this->db->from('ss_aw_assessment_exam_log');
                $this->db->where('ss_aw_log_question_id', $question_id);
                $this->db->where('ss_aw_log_answer_status', 2);
                $this->db->where_in('ss_aw_log_child_id', $child_id);
                return $this->db->get()->result();
            }
        } elseif ($quiz_type == 3) {
            $this->db->select('ss_aw_diagonastic_log_answers as wrong_answer');
            $this->db->from('ss_aw_diagonastic_exam_log');
            $this->db->where('ss_aw_diagonastic_log_question_id', $question_id);
            $this->db->where('ss_aw_diagonastic_log_answer_status', 2);
            $this->db->where_in('ss_aw_diagonastic_log_child_id', $child_id);
            return $this->db->get()->result();
        } else {
            $this->db->select('ss_aw_quiz_ans_post as wrong_answer');
            $this->db->from('ss_aw_readalong_quiz_ans');
            $this->db->where('ss_aw_quiz_id', $question_id);
            $this->db->where('ss_aw_quiz_right_wrong', 2);
            $this->db->where_in('ss_aw_child_id', $child_id);
            return $this->db->get()->result();
        }
    }

    public function get_question_detail($question_id) {
        $this->db->select('ss_aw_lessons.*, ss_aw_sections_topics.ss_aw_section_title as topic_title');
        $this->db->from('ss_aw_lessons');
        $this->db->join('ss_aw_sections_topics', 'ss_aw_sections_topics.ss_aw_section_id = ss_aw_lessons.ss_aw_lesson_topic', 'left');
        $this->db->where('ss_aw_lessons.ss_aw_lession_id', $question_id);
        return $this->db->get()->result();
    }

    public function get_question_detail_assessment($question_id) {
        $this->db->select('ss_aw_assisment_diagnostic.*, ss_aw_assesment_uploaded.ss_aw_lesson_id');
        $this->db->from('ss_aw_assisment_diagnostic');
        $this->db->join('ss_aw_assesment_uploaded', 'ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id');
        $this->db->where('ss_aw_assisment_diagnostic.ss_aw_id', $question_id);
        return $this->db->get()->result();
    }

    public function get_fut_students() {
        $this->db->distinct('ss_aw_child_course.ss_aw_child_id');
        $this->db->select('ss_aw_child_course.ss_aw_child_id,ss_aw_child_course.ss_aw_course_id,ss_aw_childs.ss_aw_child_nick_name');
        $this->db->from('ss_aw_child_course');
        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id');
        $this->db->where('DATE(ss_aw_child_course.ss_aw_child_course_create_date) >=', '2021-12-15');
        return $this->db->get()->result();
    }

    public function get_complete_topical_lessons($child_id) {
        $this->db->select('GROUP_CONCAT(ss_aw_child_last_lesson.ss_aw_lesson_id) as lesson_id');
        $this->db->from('ss_aw_child_last_lesson');
        $this->db->join('ss_aw_lessons_uploaded', 'ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_child_last_lesson.ss_aw_lesson_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_format', 'Single');
        $this->db->where('ss_aw_child_last_lesson.ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_lesson_answer_detail($lesson_id_ary = array(), $child_id) {
        $this->db->select('SUM(ss_aw_seconds_to_answer_question) as total_time, count(*) as total_question');
        $this->db->from('ss_aw_lesson_quiz_ans');
        $this->db->where_in('ss_aw_lesson_id', $lesson_id_ary);
        $this->db->where('ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_complete_topical_assessment($child_id) {
        $this->db->select('GROUP_CONCAT(ss_aw_assessment_exam_completed.ss_aw_assessment_id) as assessment_id');
        $this->db->from('ss_aw_assessment_exam_completed');
        $this->db->join('ss_aw_assesment_uploaded', 'ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_format', 'Single');
        $this->db->where('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_assessment_answer_detail($assessment_id_ary = array(), $child_id) {
        $this->db->select('SUM(ss_aw_assessment_exam_log.ss_aw_seconds_to_answer_question) as total_time, count(*) as total_question');
        $this->db->from('ss_aw_assessment_exam_log');
        $this->db->join('ss_aw_assesment_questions_asked', 'ss_aw_assesment_questions_asked.ss_aw_assessment_exam_code = ss_aw_assessment_exam_log.ss_aw_log_exam_code');
        $this->db->where_in('ss_aw_assesment_questions_asked.ss_aw_assessment_id', $assessment_id_ary);
        $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_total_grammer_proficiency_skipped($assessment_id_ary = array(), $child_id) {
        if (empty($assessment_id_ary)) {
            return 0;
        } else {
            $this->db->select('*');
            $this->db->from('ss_aw_assessment_exam_log');
            /* $this->db->join('ss_aw_assesment_questions_asked','ss_aw_assesment_questions_asked.ss_aw_assessment_exam_code = ss_aw_assessment_exam_log.ss_aw_log_exam_code');
              $this->db->where_in('ss_aw_assesment_questions_asked.ss_aw_assessment_id', $assessment_id_ary); */
            $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_child_id', $child_id);
            $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_answer_status', 3);
            return $this->db->get()->num_rows();
        }
    }

    public function get_complete_multiple_lessons($child_id) {
        $this->db->select('GROUP_CONCAT(ss_aw_child_last_lesson.ss_aw_lesson_id) as lesson_id');
        $this->db->from('ss_aw_child_last_lesson');
        $this->db->join('ss_aw_lessons_uploaded', 'ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_child_last_lesson.ss_aw_lesson_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_format', 'Multiple');
        $this->db->where('ss_aw_child_last_lesson.ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_complete_multiple_assessment($child_id) {
        $this->db->select('GROUP_CONCAT(ss_aw_assessment_exam_completed.ss_aw_assessment_id) as assessment_id');
        $this->db->from('ss_aw_assessment_exam_completed');
        $this->db->join('ss_aw_assesment_uploaded', 'ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_format', 'Multiple');
        $this->db->where('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_multiple_lesson_answer_details($questions = array(), $child_id) {
        $this->db->select('SUM(ss_aw_seconds_to_answer_question) as total_time, count(*) as total_count');
        $this->db->from('ss_aw_lesson_quiz_ans');
        $this->db->where_in('ss_aw_question', $questions);
        $this->db->where('ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_multiple_assessment_answer_details($questions = array(), $child_id) {
        $this->db->select('SUM(ss_aw_seconds_to_answer_question) as total_time, count(*) as total_count');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->where_in('ss_aw_question', $questions);
        $this->db->where('ss_aw_child_id', $child_id);
        return $this->db->get()->result();
    }

    public function get_readalong_complete_count($child_id) {
        $this->db->where('ss_aw_status', 1);
        $this->db->where('ss_aw_child_id', $child_id);
        return $this->db->get('ss_aw_last_readalong')->num_rows();
    }

    public function get_english_proficiency_skip_count($questions = array(), $child_id) {
        $this->db->where_in('ss_aw_question', $questions);
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_answers_status', 3);
        return $this->db->get('ss_aw_assesment_multiple_question_answer')->num_rows();
    }

    public function gettopicsbyquiztype($quiz_type, $assign_level = "") {
        if ($quiz_type == 1) {
            $this->db->select('ss_aw_lesson_topic as topic');
            $this->db->from('ss_aw_lessons_uploaded');
            $this->db->where('ss_aw_lesson_delete', 0);
            $this->db->where('ss_aw_lesson_status', 1);
            if (!empty($assign_level)) {
                $where = "FIND_IN_SET('" . $assign_level . "', ss_aw_course_id)";
                $this->db->where($where);
            }
            return $this->db->get()->result();
        } else {
            $this->db->select('ss_aw_assesment_topic as topic');
            $this->db->from('ss_aw_assesment_uploaded');
            $this->db->where('ss_aw_assesment_delete', 0);
            $this->db->where('ss_aw_assesment_status', 1);
            if (!empty($assign_level)) {
                if ($assign_level == 1) {
                    $level = "E";
                } elseif ($assign_level == 2) {
                    $level = "C";
                } else {
                    $level = "A";
                }
                $where = "FIND_IN_SET('" . $level . "', ss_aw_course_id)";
                $this->db->where($where);
            }
            return $this->db->get()->result();
        }
    }

    public function getPTDlessoncompletenum($childs = array()) {
        $this->db->select('count(*) as complete_num');
        $this->db->from('ss_aw_child_last_lesson');
        $this->db->where('DATE(ss_aw_last_lesson_modified_date) >=', report_date_from);
        if (!empty($childs)) {
            $this->db->where_in('ss_aw_child_id', $childs);
        }
        $this->db->group_by('ss_aw_child_id');
        $response = $this->db->get()->result();
        $complete_students = 0;
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                if ($value->complete_num >= 25) {
                    $complete_students++;
                }
            }
        }
        return $complete_students;
    }

    public function getPTDlessonAssesmentcompletenum() {
        $this->db->select('count(cl.ss_aw_child_id)child_count,group_concat(distinct(cl.ss_aw_child_id))child_id');
        $this->db->join('ss_aw_child_last_lesson cl', 'cc.ss_aw_child_id=cl.ss_aw_child_id');
        $this->db->from('ss_aw_child_course cc');
        $this->db->where('cc.ss_aw_course_status', '2');
        $this->db->where('DATE(ss_aw_last_lesson_modified_date) >=', report_date_from);
        $this->db->group_by(array('YEAR(ss_aw_last_lesson_modified_date)',
            'MONTH(ss_aw_last_lesson_modified_date)', 'cl.ss_aw_child_id'));
        $this->db->order_by('cc.ss_aw_child_id', 'DESC');
        $response = $this->db->get()->row();

        return $response;
    }

    public function getmonthlylessoncompletenum($month, $year, $childs = array()) {
        if (!empty($childs)) {
            $child = implode("','", $childs);
            $sql = "AND cl.ss_aw_child_id IN ('" . $child . "') ";
        } else {
            $sql = '';
        }

        $response = $this->db->query("SELECT 
    COUNT(*) AS complete_num,group_concat(distinct(tab.ss_aw_child_id))child_id   
FROM(
SELECT cl.* FROM 
    `ss_aw_child_last_lesson` `cl`
        JOIN
    `ss_aw_childs` ON `ss_aw_childs`.`ss_aw_child_id` = `cl`.`ss_aw_child_id`
        JOIN
    `ss_aw_assesment_uploaded` `au` ON `au`.`ss_aw_lesson_id` = `cl`.`ss_aw_lesson_id`
        AND `au`.`ss_aw_assesment_status` = 1
        JOIN
    `ss_aw_child_course` `ac` ON `ac`.`ss_aw_child_id` = `cl`.`ss_aw_child_id` AND `ac`.`ss_aw_course_status`='2'      
WHERE
    MONTH(cl.ss_aw_last_lesson_modified_date) = '" . $month . "'
       
        AND DATE(cl.ss_aw_last_lesson_modified_date) >= '" . report_date_from . "'
        AND YEAR(cl.ss_aw_last_lesson_modified_date) = '" . $year . "'
GROUP BY `cl`.`ss_aw_child_id`)tab WHERE 1 GROUP BY YEAR(ss_aw_last_lesson_modified_date) ,
MONTH(ss_aw_last_lesson_modified_date)")->row();
        return $response;
    }

    public function getmonthlylessonAttemptnum($month, $year, $childs = array()) {
//        $this->db->select('cl.ss_aw_child_id');
        $this->db->select('count(*) as complete_num');
        $this->db->join('(select * from ss_aw_child_last_lesson group by `ss_aw_child_last_lesson`.`ss_aw_child_id` order by ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date desc)last_lesson', 'ss_aw_child_course.ss_aw_child_id = last_lesson.ss_aw_child_id');
        $this->db->from('ss_aw_child_course');
        $this->db->join('ss_aw_childs', '`ss_aw_childs`.`ss_aw_child_id` = last_lesson.`ss_aw_child_id` and ss_aw_childs.ss_aw_child_status="1" and ss_aw_childs.ss_aw_child_delete="0"');
        $this->db->order_by('ss_aw_child_course.ss_aw_child_course_id', 'desc');
        $this->db->group_by(array('YEAR(last_lesson.ss_aw_last_lesson_modified_date)', 'MONTH(last_lesson.ss_aw_last_lesson_modified_date)'));
        $this->db->where('DATE(last_lesson.ss_aw_last_lesson_modified_date) >=', report_date_from);
        $this->db->where('ss_aw_child_course.ss_aw_course_status', 1);
        if (!empty($month) && !empty($year)) {
            $this->db->where('MONTH(last_lesson.ss_aw_last_lesson_modified_date)', $month);
            $this->db->where('YEAR(last_lesson.ss_aw_last_lesson_modified_date)', $year);
        }



//
//        $this->db->select('count(*) as complete_num');
//        $this->db->from('ss_aw_child_last_lesson cl');
//        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = cl.ss_aw_child_id');
//        $this->db->where('MONTH(cl.ss_aw_last_lesson_modified_date)', $month);
//        $this->db->where('DATE(cl.ss_aw_last_lesson_modified_date) >=', report_date_from);
//        $this->db->where('YEAR(cl.ss_aw_last_lesson_modified_date)', $year);
////        if (!empty($childs)) {
////            $this->db->where_in('cl.ss_aw_child_id', $childs);
////        }
//        $this->db->group_by(array('MONTH(cl.ss_aw_last_lesson_modified_date)', 'YEAR(cl.ss_aw_last_lesson_modified_date)'));
        $response = $this->db->get()->row();
        return @$response->complete_num;
    }

    public function getmonthlylessonstatusnum($month, $year, $range_type, $data = array()) {
        $this->db->select('count(last_lesson.`ss_aw_child_id`)complete_num,group_concat(distinct(last_lesson.`ss_aw_child_id`))child_id');
        $this->db->join('(select * from ss_aw_child_last_lesson group by `ss_aw_child_last_lesson`.`ss_aw_child_id` order by ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date desc)last_lesson', 'ss_aw_child_course.ss_aw_child_id = last_lesson.ss_aw_child_id');
        $this->db->from('ss_aw_child_course');
        $this->db->join('ss_aw_childs', '`ss_aw_childs`.`ss_aw_child_id` = last_lesson.`ss_aw_child_id` and ss_aw_childs.ss_aw_child_status="1" and ss_aw_childs.ss_aw_child_delete="0"');
        $this->db->order_by('ss_aw_child_course.ss_aw_child_course_id', 'desc');
        $this->db->group_by(array('YEAR(last_lesson.ss_aw_last_lesson_modified_date)', 'MONTH(last_lesson.ss_aw_last_lesson_modified_date)'));
        $this->db->where('DATE(last_lesson.ss_aw_last_lesson_modified_date) >=', report_date_from);
        $this->db->where('ss_aw_child_course.ss_aw_course_status', 1);
        if (!empty($month) && !empty($year)) {
            $this->db->where('MONTH(last_lesson.ss_aw_last_lesson_modified_date)', $month);
            $this->db->where('YEAR(last_lesson.ss_aw_last_lesson_modified_date)', $year);
        }
        if ($range_type == 1) {//active
            $this->db->where('DATEDIFF(now(),`last_lesson`.`ss_aw_last_lesson_modified_date`)<', 15);
        } elseif ($range_type == 2) {//inactive
            $this->db->where('DATEDIFF(now(),`last_lesson`.`ss_aw_last_lesson_modified_date`)>', 21);
        } elseif ($range_type == 3) {//deliquent
            $this->db->where('DATEDIFF(now(),`last_lesson`.`ss_aw_last_lesson_modified_date`)>', 14);
            $this->db->where('DATEDIFF(now(),`last_lesson`.`ss_aw_last_lesson_modified_date`)<', 22);
        }
        if (!empty($data['level'])) {
            $level = $data['level'];
            if ($level == 1) {
                $this->db->where('((SELECT `ss_aw_child_course`.`ss_aw_course_id` '
                        . 'FROM ss_aw_child_course '
                        . 'WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` '
                        . 'ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 1 or '
                        . '(SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course '
                        . 'WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` '
                        . 'ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 2)');
            } else {
                $this->db->where('(SELECT `ss_aw_child_course`.`ss_aw_course_id` '
                        . 'FROM ss_aw_child_course '
                        . 'WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` '
                        . 'ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = "' . $level . '"');
            }
        }

        return $this->db->get()->result();
    }

    public function getchilddetailsbylevel($level, $search_data = array()) {
        $this->db->select('GROUP_CONCAT(ss_aw_child_id) as child_ids');
        $this->db->from('ss_aw_childs');
        if (!empty($search_data)) {
            if (!empty($search_data['age'])) {
                $ageAry = explode("-", $search_data['age']);
                $this->db->where('ss_aw_child_age >=', $ageAry[0]);
                $this->db->where('ss_aw_child_age <=', $ageAry[1]);
            }

            if (!empty($search_data['enroll_type'])) {
                $this->db->where('ss_aw_child_enroll_type', $search_data['enroll_type']);
            }
        }
        if ($level == 1) {
            $this->db->where('(SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 1 or (SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 2');
        } else {
            $this->db->where('(SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_childs`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = "' . $level . '"');
        }

        return $this->db->get()->result();
    }

    public function getcompletelessoncountbylevel($childIds = "", $lesson_id) {
        $child_id_ary = array();
        if (!empty($childIds)) {
            $child_id_ary = explode(",", $childIds);
        }
        if (!empty($child_id_ary)) {
            $this->db->where_in('ss_aw_child_id', $child_id_ary);
            $this->db->where('ss_aw_lesson_id', $lesson_id);
            $this->db->where('ss_aw_lesson_status', 2);
            return $this->db->get('ss_aw_child_last_lesson')->num_rows();
        } else {
            return 0;
        }
    }

    public function getcompletelessonassessmentcount($childIds = array(), $lession_id, $assessment_id) {
        if (!empty($childIds)) {
            $count = 0;
            foreach ($childIds as $value) {
                $this->db->where('ss_aw_lesson_status', 2);
                $this->db->where('ss_aw_child_id', $value);
                $this->db->where('ss_aw_lesson_id', $lession_id);
                $response1 = $this->db->get('ss_aw_child_last_lesson')->num_rows();

                $this->db->where('ss_aw_child_id', $value);
                $this->db->where('ss_aw_assessment_id', $assessment_id);
                $response2 = $this->db->get('ss_aw_assessment_exam_completed')->num_rows();

                if ($response1 > 0 && $response2 > 0) {
                    $count++;
                }
            }
            return $count;
        } else {
            return 0;
        }
    }

    public function getlessonwithassociateassessment() {
        $this->db->select('ss_aw_lessons_uploaded.ss_aw_lession_id as lesson_id, ss_aw_assesment_uploaded.ss_aw_assessment_id as assessment_id');
        $this->db->from('ss_aw_lessons_uploaded');
        $this->db->join('ss_aw_assesment_uploaded', 'ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_assesment_uploaded.ss_aw_lesson_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_status', 1);
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_delete', 0);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_status', 1);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_delete', 0);
        return $this->db->get()->result_array();
    }

    public function get_readalong_question_details($question_id) {
        $this->db->select('ss_aw_readalong_quiz.*,ss_aw_readalongs_upload.ss_aw_title');
        $this->db->from('ss_aw_readalong_quiz');
        $this->db->join('ss_aw_readalongs_upload', 'ss_aw_readalongs_upload.ss_aw_id = ss_aw_readalong_quiz.ss_aw_readalong_upload_id');
        $this->db->where('ss_aw_readalong_quiz.ss_aw_readalong_id', $question_id);
        return $this->db->get()->row();
    }

    public function getdiffuserlogintypenum($program_date) {
        $this->db->select('(SELECT COUNT(*) FROM ss_aw_child_course WHERE DATE(ss_aw_child_course.ss_aw_child_course_create_date) >= "' . report_date_from . '") as online');
        $this->db->limit(1);
        return $this->db->get($this->table)->result();
    }

    public function getdiffuserlogintypenum_ytd($year) {
        $this->db->select('(SELECT COUNT(*) FROM ss_aw_child_course WHERE YEAR(ss_aw_child_course.ss_aw_child_course_create_date) = "' . $year . '" and DATE(ss_aw_child_course.ss_aw_child_course_create_date) >= "' . report_date_from . '") as online');
        $this->db->limit(1);
        return $this->db->get($this->table)->result();
    }

    public function getdiffuserlogintypenum_monthly($year, $month) {
        $this->db->select('(SELECT COUNT(*) FROM ss_aw_child_course WHERE YEAR(ss_aw_child_course.ss_aw_child_course_create_date) = "' . $year . '" and  MONTH(ss_aw_child_course.ss_aw_child_course_create_date) = "' . $month . '" and DATE(ss_aw_child_course.ss_aw_child_course_create_date) >= "' . report_date_from . '") as online');
        $this->db->limit(1);
        return $this->db->get($this->table)->result();
    }

    public function get_all_wrong_answers_child($search_data = array(), $child_id = array(), $quiz_type, $question, $question_format = "", $question_id = "") {
        if ($quiz_type == 1) {
            $this->db->select('ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_lesson_quiz_ans.ss_aw_post_answer as wrong_answer, ss_aw_childs.ss_aw_parent_id as parent_id');
            $this->db->from('ss_aw_lesson_quiz_ans');
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_lesson_quiz_ans.ss_aw_child_id');
            $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_question_id', $question);
            $this->db->where_in('ss_aw_lesson_quiz_ans.ss_aw_child_id', $child_id);
            $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_answer_status', 2);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_created_date <=', $search_data['end_date']);
            }
            $this->db->group_by('ss_aw_lesson_quiz_ans.ss_aw_child_id');
            return $this->db->get()->result();
        } elseif ($quiz_type == 2) {
            if ($question_format == 'Multiple') {
                $this->db->select('ss_aw_assesment_multiple_question_answer.ss_aw_answer as wrong_answer, ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_childs.ss_aw_parent_id as parent_id');
                $this->db->from('ss_aw_assesment_multiple_question_answer');
                $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_assesment_multiple_question_answer.ss_aw_child_id');
                $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_question', $question);
                $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_answers_status', 2);
                $this->db->where_in('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_created_at >=', $search_data['start_date']);
                    $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_created_at <=', $search_data['end_date']);
                }
                $this->db->group_by('ss_aw_assesment_multiple_question_answer.ss_aw_child_id');
                return $this->db->get()->result();
            } elseif ($question_format == 'Single') {
                $this->db->select('ss_aw_assessment_exam_log.ss_aw_log_answers as wrong_answer, ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_childs.ss_aw_parent_id as parent_id');
                $this->db->from('ss_aw_assessment_exam_log');
                $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_assessment_exam_log.ss_aw_log_child_id');
                $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_question_id', $question_id);
                $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_answer_status', 2);
                $this->db->where_in('ss_aw_assessment_exam_log.ss_aw_log_child_id', $child_id);
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_created_date >=', $search_data['start_date']);
                    $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_created_date <=', $search_data['end_date']);
                }
                $this->db->group_by('ss_aw_assessment_exam_log.ss_aw_log_child_id');
                return $this->db->get()->result();
            }
        } elseif ($quiz_type == 3) {
            $this->db->select('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answers as wrong_answer,ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name,ss_aw_childs.ss_aw_parent_id as parent_id');
            $this->db->from('ss_aw_diagonastic_exam_log');
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id');
            $this->db->where('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id', $question_id);
            $this->db->where('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status', 2);
            $this->db->where_in('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id', $child_id);
            $this->db->group_by('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id');
            return $this->db->get()->result();
        } else {
            $this->db->select('ss_aw_quiz_ans_post as wrong_answer,ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name,ss_aw_childs.ss_aw_parent_id as parent_id');
            $this->db->from('ss_aw_readalong_quiz_ans');
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_readalong_quiz_ans.ss_aw_child_id');
            $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_quiz_id', $question_id);
            $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_quiz_right_wrong', 2);
            $this->db->where_in('ss_aw_readalong_quiz_ans.ss_aw_child_id', $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_created_date <=', $search_data['end_date']);
            }
            $this->db->group_by('ss_aw_readalong_quiz_ans.ss_aw_child_id');
            return $this->db->get()->result();
        }
    }

    public function get_all_wright_answers_child($search_data = array(), $child_id = array(), $quiz_type, $question, $question_format = "", $question_id = "") {
        if ($quiz_type == 1) {
            $this->db->select('ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_lesson_quiz_ans.ss_aw_post_answer as wrong_answer, ss_aw_childs.ss_aw_parent_id as parent_id');
            $this->db->from('ss_aw_lesson_quiz_ans');
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_lesson_quiz_ans.ss_aw_child_id');
            $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_question_id', $question);
            $this->db->where_in('ss_aw_lesson_quiz_ans.ss_aw_child_id', $child_id);
            $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_answer_status', 1);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_created_date <=', $search_data['end_date']);
            }
            $this->db->group_by('ss_aw_lesson_quiz_ans.ss_aw_child_id');
            return $this->db->get()->result();
        } elseif ($quiz_type == 2) {
            if ($question_format == 'Multiple') {
                $this->db->select('ss_aw_assesment_multiple_question_answer.ss_aw_answer as wrong_answer, ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_childs.ss_aw_parent_id as parent_id');
                $this->db->from('ss_aw_assesment_multiple_question_answer');
                $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_assesment_multiple_question_answer.ss_aw_child_id');
                $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_question', $question);
                $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_answers_status', 1);
                $this->db->where_in('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_created_at >=', $search_data['start_date']);
                    $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_created_at <=', $search_data['end_date']);
                }
                $this->db->group_by('ss_aw_assesment_multiple_question_answer.ss_aw_child_id');
                return $this->db->get()->result();
            } elseif ($question_format == 'Single') {
                $this->db->select('ss_aw_assessment_exam_log.ss_aw_log_answers as wrong_answer, ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name, ss_aw_childs.ss_aw_parent_id as parent_id');
                $this->db->from('ss_aw_assessment_exam_log');
                $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_assessment_exam_log.ss_aw_log_child_id');
                $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_question_id', $question_id);
                $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_answer_status', 1);
                $this->db->where_in('ss_aw_assessment_exam_log.ss_aw_log_child_id', $child_id);
                if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                    $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_created_date >=', $search_data['start_date']);
                    $this->db->where('ss_aw_assessment_exam_log.ss_aw_log_created_date <=', $search_data['end_date']);
                }
                $this->db->group_by('ss_aw_assessment_exam_log.ss_aw_log_child_id');
                return $this->db->get()->result();
            }
        } elseif ($quiz_type == 3) {
            $this->db->select('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answers as wrong_answer,ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name,ss_aw_childs.ss_aw_parent_id as parent_id');
            $this->db->from('ss_aw_diagonastic_exam_log');
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id');
            $this->db->where('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_question_id', $question_id);
            $this->db->where('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status', 1);
            $this->db->where_in('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id', $child_id);
            $this->db->group_by('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_child_id');
            return $this->db->get()->result();
        } else {
            $this->db->select('ss_aw_quiz_ans_post as wrong_answer,ss_aw_childs.ss_aw_child_id as child_id, ss_aw_childs.ss_aw_child_nick_name as child_name,ss_aw_childs.ss_aw_parent_id as parent_id');
            $this->db->from('ss_aw_readalong_quiz_ans');
            $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_readalong_quiz_ans.ss_aw_child_id');
            $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_quiz_id', $question_id);
            $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_quiz_right_wrong', 1);
            $this->db->where_in('ss_aw_readalong_quiz_ans.ss_aw_child_id', $child_id);
            if (!empty($search_data['start_date']) && !empty($search_data['end_date'])) {
                $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_created_date >=', $search_data['start_date']);
                $this->db->where('ss_aw_readalong_quiz_ans.ss_aw_created_date <=', $search_data['end_date']);
            }
            $this->db->group_by('ss_aw_readalong_quiz_ans.ss_aw_child_id');
            return $this->db->get()->result();
        }
    }

    public function get_assessment_upload_ids($topic) {
        $this->db->select('ss_aw_uploaded_record_id');
        $this->db->from('ss_aw_assisment_diagnostic');
        $this->db->where('ss_aw_category', $topic);
        $this->db->group_by('ss_aw_uploaded_record_id');
        return $this->db->get()->result();
    }

    public function get_assessment_question_by_upload_id($upload_id) {
        $this->db->where('ss_aw_uploaded_record_id', $upload_id);
        $this->db->order_by('ss_aw_id', 'asc');
        return $this->db->get('ss_aw_assisment_diagnostic')->result();
    }

    public function hyatt_details() {
        $this->db->select('ss_aw_parents.ss_aw_parent_full_name as name, ss_aw_parents.ss_aw_parent_email as email, ss_aw_parents.ss_aw_parent_city as city, ss_aw_childs.ss_aw_child_schoolname as property, ss_aw_childs.ss_aw_child_id as child_id');
        $this->db->from('ss_aw_childs');
        $this->db->join('ss_aw_parents', 'ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
        $this->db->where('ss_aw_parents.ss_aw_parent_status', 1);
        $this->db->where('ss_aw_parents.ss_aw_parent_delete', 0);
        $this->db->like('ss_aw_parents.ss_aw_parent_email', 'hyatt');
        $this->db->where('(SELECT COUNT(*) FROM ss_aw_child_last_lesson WHERE ss_aw_child_last_lesson.ss_aw_child_id = ss_aw_childs.ss_aw_child_id) > 0');
        return $this->db->get()->result();
    }

    public function getAllDelinquentdata($filter, $general_language) {
        if (!empty($filter['expertise_level'])) {
            $level = explode(",", $filter['expertise_level']);
        }
        $i = 0;
        $sql = '';
        foreach ($level as $lvl) {
            if ($i > 0) {
                $sql .= " or ";
            }
            $sql .= "FIND_IN_SET('" . $lvl . "', st.ss_aw_expertise_level)";
            $i++;
        }
        $query_general = $general_language != '' ? " UNION ALL
SELECT
  lu.ss_aw_lesson_topic,lu.ss_aw_lession_id,ss_aw_lesson_topic_id,lu.ss_aw_sl_no
FROM
  `ss_aw_lessons_uploaded` lu
WHERE FIND_IN_SET('" . $general_language . "', lu.ss_aw_course_id)
  AND lu.ss_aw_lesson_format='Multiple'" : '';
        $query = $this->db->query("SELECT topic.*,de.`ss_aw_diagonastic_child_id`,
de.`ss_aw_diagonastic_exam_date`,cl.`ss_aw_last_lesson_create_date`,
cl.`ss_aw_last_lesson_modified_date`
FROM (SELECT
  st.ss_aw_section_title ss_aw_lesson_topic,alu.ss_aw_lession_id,alu.ss_aw_lesson_topic_id,alu.ss_aw_sl_no
FROM
  `ss_aw_sections_topics` st
  JOIN ss_aw_lessons_uploaded alu ON st.ss_aw_section_id = alu.ss_aw_lesson_topic_id
WHERE $sql 
$query_general
  )topic
  CROSS JOIN  ss_aw_diagonastic_exam de ON DATE(de.`ss_aw_diagonastic_exam_date`)>='2022-08-01'
  LEFT JOIN ss_aw_child_last_lesson cl ON cl.`ss_aw_child_id`=de.`ss_aw_diagonastic_child_id` 
  AND cl.`ss_aw_lesson_id`= topic.ss_aw_lession_id AND cl.ss_aw_last_lesson_create_date!='' AND DATE(cl.`ss_aw_last_lesson_modified_date`)>='2022-08-01' ORDER BY de.ss_aw_diagonastic_child_id,topic.ss_aw_sl_no ASC");
//       echo $this->db->last_query();
//       exit;
        return $query;
    }

}
