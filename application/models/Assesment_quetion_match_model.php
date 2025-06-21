<?php

class Assesment_quetion_match_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_all_active_question($all_ques_user_id, $course_id, $topic, $course_id_status) {
        if ($course_id == '1') {
            $course = " AND cc.ss_aw_course_id IN ('1' , '2')";
        } else {
            $course = " AND cc.ss_aw_course_id IN ('$course_id')";
        }

        return $this->db->query("SELECT 
  qa.*,al.ss_aw_course_id course_id_status
FROM
   ss_aw_child_last_lesson ll 
   join ss_aw_lesson_quiz_ans qa on qa.ss_aw_child_id=ll.ss_aw_child_id
   join ss_aw_lessons_uploaded lu on lu.ss_aw_lession_id = ll.ss_aw_lesson_id
   join ss_aw_lessons al on al.`ss_aw_lesson_record_id` = lu.`ss_aw_lession_id` and al.`ss_aw_lession_id`= qa.ss_aw_question_id
        AND lu.ss_aw_lesson_topic = '$topic' and al.ss_aw_course_id = '$course_id_status'
    JOIN
    (SELECT 
        *
    FROM
        `ss_aw_child_course`
    GROUP BY ss_aw_child_id , ss_aw_course_id
    ORDER BY ss_aw_child_course_id DESC) cc ON cc.ss_aw_child_id = ll.ss_aw_child_id
        $course
        JOIN
    `ss_aw_childs` ac ON ac.`ss_aw_child_id` = cc.ss_aw_child_id
        AND ac.ss_aw_child_status = '1'
        AND ac.ss_aw_child_delete = '0'
   where ac.ss_aw_child_id='$all_ques_user_id' and date(ll.ss_aw_last_lesson_modified_date)!='' group by qa.ss_aw_question_id");
    }

    public function get_all_active_user_id($all_ques_user_id, $course_id, $topic, $course_id_status, $destination_user_id) {
        $destination = '';
        if ($course_id == '1') {
            $course = " AND cc.ss_aw_course_id IN ('1' , '2')";
        } else {
            $course = " AND cc.ss_aw_course_id IN ('$course_id')";
        }
        if ($destination_user_id != '') {
            $destination = " AND ac.ss_aw_child_id='$destination_user_id' ";
        }

        return $this->db->query("SELECT 
  qa.ss_aw_child_id,al.ss_aw_course_id course_id_status
FROM
   ss_aw_child_last_lesson ll 
   join ss_aw_lesson_quiz_ans qa on qa.ss_aw_child_id=ll.ss_aw_child_id
   join ss_aw_lessons_uploaded lu on lu.ss_aw_lession_id = ll.ss_aw_lesson_id
   join ss_aw_lessons al on al.`ss_aw_lesson_record_id` = lu.`ss_aw_lession_id` and al.`ss_aw_lession_id`= qa.ss_aw_question_id
        AND lu.ss_aw_lesson_topic = '$topic' and al.ss_aw_course_id = '$course_id_status'
    JOIN
    (SELECT 
        *
    FROM
        `ss_aw_child_course`
    GROUP BY ss_aw_child_id , ss_aw_course_id
    ORDER BY ss_aw_child_course_id DESC) cc ON cc.ss_aw_child_id = ll.ss_aw_child_id
        $course
        JOIN
    `ss_aw_childs` ac ON ac.`ss_aw_child_id` = cc.ss_aw_child_id
        AND ac.ss_aw_child_status = '1'
        AND ac.ss_aw_child_delete = '0'
   where ac.ss_aw_child_id!='$all_ques_user_id' $destination and date(ll.ss_aw_last_lesson_modified_date)!='' group by qa.ss_aw_child_id");
    }

    public function get_user_question_count($user_id, $course_id, $topic, $course_id_status) {
        if ($course_id == '1') {
            $course = " AND cc.ss_aw_course_id IN ('1' , '2')";
        } else {
            $course = " AND cc.ss_aw_course_id IN ('$course_id')";
        }
        return $this->db->query("select COUNT(qa.ss_aw_id) count_qes,
    MAX(qa.ss_aw_created_date) max_created_date from 
   ss_aw_child_last_lesson ll 
   join ss_aw_lesson_quiz_ans qa on qa.ss_aw_child_id=ll.ss_aw_child_id
   join ss_aw_lessons_uploaded lu on lu.ss_aw_lession_id = ll.ss_aw_lesson_id
   join ss_aw_lessons al on al.`ss_aw_lesson_record_id` = lu.`ss_aw_lession_id` and al.`ss_aw_lession_id`= qa.ss_aw_question_id
        AND lu.ss_aw_lesson_topic = '$topic' and al.ss_aw_course_id = '$course_id_status'
    JOIN
    (SELECT 
        *
    FROM
        `ss_aw_child_course`
    GROUP BY ss_aw_child_id , ss_aw_course_id
    ORDER BY ss_aw_child_course_id DESC) cc ON cc.ss_aw_child_id = ll.ss_aw_child_id
        $course
        JOIN
    `ss_aw_childs` ac ON ac.`ss_aw_child_id` = cc.ss_aw_child_id
        AND ac.ss_aw_child_status = '1'
        AND ac.ss_aw_child_delete = '0'
   where ac.ss_aw_child_id='$user_id' and date(ll.ss_aw_last_lesson_modified_date)!='' group by qa.ss_aw_child_id")->row();
    }

    public function chek_question_availability($user_id, $question_id, $course_id, $topic, $course_id_status) {

        if ($course_id == '1') {
            $course = " AND cc.ss_aw_course_id IN ('1' , '2')";
        } else {
            $course = " AND cc.ss_aw_course_id IN ('$course_id')";
        }
        return $this->db->query("select * from ss_aw_child_last_lesson ll 
   join ss_aw_lesson_quiz_ans qa on qa.ss_aw_child_id=ll.ss_aw_child_id
   join ss_aw_lessons_uploaded lu on lu.ss_aw_lession_id = ll.ss_aw_lesson_id
   join ss_aw_lessons al on al.`ss_aw_lesson_record_id` = lu.`ss_aw_lession_id` and al.`ss_aw_lession_id`= qa.ss_aw_question_id
        AND lu.ss_aw_lesson_topic = '$topic' and al.ss_aw_course_id = '$course_id_status'
    JOIN
    (SELECT 
        *
    FROM
        `ss_aw_child_course`
    GROUP BY ss_aw_child_id , ss_aw_course_id
    ORDER BY ss_aw_child_course_id DESC) cc ON cc.ss_aw_child_id = ll.ss_aw_child_id
        $course
        JOIN
    `ss_aw_childs` ac ON ac.`ss_aw_child_id` = cc.ss_aw_child_id
        AND ac.ss_aw_child_status = '1'
        AND ac.ss_aw_child_delete = '0'
   where ac.ss_aw_child_id='$user_id' and qa.`ss_aw_question_id`='$question_id'");
    }

    public function update_lessons_score($user_id, $course_level) {
        $this->db->query("UPDATE ss_aw_lesson_score SET total_question=total_question+1 WHERE child_id='$user_id' AND lesson_id='$course_level'");
    }

    public function Add($table, $data) {
        $result = $this->db->insert($table, $data);
        if (!empty($result)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function get_all_active_questionfrom_lesson($course_id, $topic, $course_id_status) {
        return $this->db->query("SELECT 
    *
FROM
    ss_aw_lessons al
   join ss_aw_sections_topics st on st.ss_aw_section_title like '$topic'
WHERE
    al.ss_aw_course_id = '$course_id'
        AND al.ss_aw_lesson_format_type = '2'
        AND al.ss_aw_lesson_topic = st.ss_aw_section_id");
    }

    public function get_all_destination_question($destination_id, $topic) {
        return $this->db->query("SELECT 
    *
FROM
    ss_aw_lesson_quiz_ans qa
        JOIN
    ss_aw_sections_topics st ON st.ss_aw_section_title = '$topic'
WHERE
    qa.ss_aw_child_id = '$destination_id'
        AND qa.ss_aw_topic_id = st.ss_aw_section_id");
    }

    public function Edit($table, $data, $where) {
        $result = $this->db->update($table, $data, $where);
        if (!empty($result)) {
            return true;
        }
        return false;
    }

    public function get_all_readalongquestion($course_status,$topic) {
        return $this->db->query("SELECT 
    rq.*
FROM
    ss_aw_readalongs_upload ru
    join ss_aw_readalong_quiz rq on rq.ss_aw_readalong_upload_id=ru.ss_aw_id
WHERE
    ru.ss_aw_title LIKE '$topic'
        AND ru.ss_aw_level = '$course_status'
        AND ru.ss_aw_deleted = '1'");
    }
    public function get_all_user_readalong($destination_user_id, $course_status, $topic){
        return $this->db->query("SELECT 
    qa.*
FROM
    ss_aw_readalongs_upload ru
    join ss_aw_readalong_quiz_ans qa on qa.ss_aw_readalong_id=ru.ss_aw_id and qa.ss_aw_child_id='$destination_user_id'
    WHERE
    ru.ss_aw_title LIKE '$topic'
        AND ru.ss_aw_level = '$course_status'
        AND ru.ss_aw_deleted = '1';");
        
    }
}
