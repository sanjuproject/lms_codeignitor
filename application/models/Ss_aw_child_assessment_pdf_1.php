<?php

class Ss_aw_child_assessment_pdf extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_all_course_completed_child($id) {
        $this->db->select("ac.*,cc.ss_aw_course_id,TIMESTAMPDIFF(YEAR,
        DATE(ac.ss_aw_child_dob),
        DATE(cc.ss_aw_child_course_create_date))child_age,
        (case when cc.ss_aw_course_id='1' or cc.ss_aw_course_id='2' then 'E'
             when cc.ss_aw_course_id='3' then 'A'
             when cc.ss_aw_course_id='5' then 'M' end)course_level
        ");
        $this->db->from("(SELECT 
        *
    FROM
        ss_aw_child_course
    WHERE
        ss_aw_course_status = '1'          
    GROUP BY ss_aw_child_id) cc");
        $this->db->join("ss_aw_childs ac", "ac.ss_aw_child_id = cc.ss_aw_child_id");
//        $this->db->join("ss_aw_childs ac", "ac.ss_aw_child_id = cc.ss_aw_child_id
//        AND ac.ss_aw_child_delete = '0'
//        AND ac.ss_aw_child_status = '1'");
        if ($id != '') {
            $this->db->where("ac.ss_aw_child_id", $id);
        }
        return $this->db->get();
    }

    public function get_child_grammer_assessment($child_id, $start, $end) {

        $this->db->select('st.ss_aw_section_title,
    ac.ss_aw_child_id,
    ac.ss_aw_child_nick_name,
    COUNT(ss_aw_lesson_quiz_ans.ss_aw_id) qes_cnt_lesson,
    SUM(CASE
        WHEN ss_aw_lesson_quiz_ans.ss_aw_answer_status = 1 THEN 1
        ELSE 0
    END) correct_answer_lesson,
    ROUND(SUM(CASE
                WHEN ss_aw_lesson_quiz_ans.ss_aw_answer_status = 1 THEN 1
                ELSE 0
            END) * 100 / COUNT(ss_aw_lesson_quiz_ans.ss_aw_id),
            2) correct_answer_percentage_lesson,
    el.qes_cnt_asses,
    el.correct_answer_asses,
    el.correct_answer_percentage_asses');
        $this->db->from("ss_aw_lesson_quiz_ans");
        $this->db->join("ss_aw_childs ac", "ac.ss_aw_child_id = ss_aw_lesson_quiz_ans.ss_aw_child_id");
        $this->db->join("ss_aw_sections_topics st", "st.ss_aw_section_id = ss_aw_lesson_quiz_ans.ss_aw_topic_id");
        $this->db->join("(SELECT 
        ss_aw_log_child_id,
            ss_aw_log_topic_id,
            ss_aw_log_exam_code,
            COUNT(ss_aw_log_id) qes_cnt_asses,
            round(SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE 0
            END),2) correct_answer_asses,            
            ROUND(( SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE 0
            END) * 100) /  SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE ad.ss_aw_weight
            END), 2) correct_answer_percentage_asses
    FROM
        ss_aw_assessment_exam_log
     join `ss_aw_sections_topics` `ast` ON `ast`.`ss_aw_section_id` >= $start and `ast`.`ss_aw_section_id` <= $end
         join ss_aw_assesment_uploaded aau on aau.ss_aw_assesment_topic_id=ast.ss_aw_section_id
    JOIN ss_aw_assisment_diagnostic ad ON ad.ss_aw_uploaded_record_id=aau.ss_aw_assessment_id and ad.ss_aw_id = ss_aw_assessment_exam_log.ss_aw_log_question_id
    GROUP BY ss_aw_log_exam_code , ss_aw_log_topic_id , ss_aw_log_child_id
    ORDER BY ss_aw_log_topic_id) el", "el.ss_aw_log_child_id = ac.ss_aw_child_id
        AND el.ss_aw_log_topic_id = ss_aw_lesson_quiz_ans.ss_aw_topic_id", true);
        $this->db->where("ss_aw_lesson_quiz_ans.ss_aw_child_id", $child_id);
        $this->db->where("st.ss_aw_section_id>=", $start);
        $this->db->where("st.ss_aw_section_id<=", $end);
        $this->db->group_by(array("ss_aw_lesson_quiz_ans.ss_aw_child_id", "ss_aw_lesson_quiz_ans.ss_aw_topic_id"));
        $this->db->order_by("st.ss_aw_section_id ASC");

        return $this->db->get();
//        $this->db->get();
//        echo $this->db->last_query();
//        exit;
    }

    public function get_child_diagonostics_data($child_id) {
        $this->db->select("  dc.ss_aw_diagonastic_child_id,
    COUNT(el.ss_aw_diagonastic_log_question_id)ctn_question,
    SUM(CASE
        WHEN el.ss_aw_diagonastic_log_answer_status = 1 THEN 1
        ELSE 0
    END) correct_answer_diagonostic");
        $this->db->from("(SELECT 
        *
    FROM
        ss_aw_diagonastic_exam
    GROUP BY ss_aw_diagonastic_child_id
    ORDER BY ss_aw_diagonastic_exam_id ASC) dc");
        $this->db->join("ss_aw_diagonastic_exam_log el", "el.ss_aw_diagonastic_log_exam_code = dc.ss_aw_diagonastic_exam_code
        AND el.ss_aw_diagonastic_log_child_id = dc.ss_aw_diagonastic_child_id");
        $this->db->where("dc.ss_aw_diagonastic_child_id", $child_id);
        $this->db->group_by(array("el.ss_aw_diagonastic_log_child_id"));
//                $this->db->get();
//        echo $this->db->last_query();
//        exit;
        return $this->db->get()->row();
    }

    public function get_lesson_non_comprehension($child_id, $comprehension) {
        if ($comprehension == false) {
            $comp = " and al.ss_aw_lesson_topic!='0'";
        } else {
            $comp = " and al.ss_aw_lesson_topic='0'";
        }
        $this->db->select("lu.ss_aw_sl_no,lu.ss_aw_lesson_topic,ac.ss_aw_child_id,
    ac.ss_aw_child_nick_name,
    COUNT(qa.ss_aw_id) qes_cnt_lesson,
    SUM(CASE
        WHEN qa.ss_aw_answer_status = 1 THEN 1
        ELSE 0
    END) correct_answer_lesson,
    ROUND(SUM(CASE
                WHEN qa.ss_aw_answer_status = 1 THEN 1
                ELSE 0
            END) * 100 / COUNT(qa.ss_aw_id),
            2) correct_answer_percentage_lesson");
        $this->db->from("ss_aw_lesson_quiz_ans qa");
        $this->db->join("(select * from ss_aw_child_course group by ss_aw_child_id,ss_aw_course_id)cc", "cc.ss_aw_child_id=qa.ss_aw_child_id");
        $this->db->join("ss_aw_childs ac", "ac.ss_aw_child_id=cc.ss_aw_child_id ");
//         $this->db->join("ss_aw_childs ac","ac.ss_aw_child_id=cc.ss_aw_child_id and ac.ss_aw_child_status='2' and ac.ss_aw_child_delete='0'");
        $this->db->join("ss_aw_lessons_uploaded lu", "lu.ss_aw_lesson_format='Multiple' and find_in_set(cc.ss_aw_course_id,lu.ss_aw_course_id)!='0'");
        $this->db->join("ss_aw_lessons al", "al.ss_aw_lesson_record_id=lu.ss_aw_lession_id and al.ss_aw_lession_id=qa.ss_aw_question_id $comp");
        $this->db->where("ac.ss_aw_child_id", $child_id);
        $this->db->group_by(array("qa.ss_aw_child_id", "lu.ss_aw_sl_no"));
        $this->db->order_by("ss_aw_id", "asc");
        return $this->db->get();
//    echo $this->db->last_query();
//    exit;
    }

    public function get_assesment_non_comprehension($child_id, $comprehension) {
        if ($comprehension == false) {
            $comp = " AND mqa.ss_aw_topic_id != '0'";
        } else {
            $comp = " AND mqa.ss_aw_topic_id = '0'";
        }


        return $this->db->query("SELECT 
    au.ss_aw_lesson_id,
    au.ss_aw_assesment_topic,
    ac.ss_aw_child_id,
    ac.ss_aw_child_nick_name,
    cc.ss_aw_course_id,
    course_level,
    au.ss_aw_course_id,
    COUNT(mqa.ss_aw_id) qes_cnt_assesment,
    SUM(CASE
        WHEN mqa.ss_aw_answers_status = 1 THEN 1
        ELSE 0
    END) correct_answer_assesment,
    ROUND(SUM(CASE
                WHEN mqa.ss_aw_answers_status = 1 THEN 1
                ELSE 0
            END) * 100 / COUNT(mqa.ss_aw_id),
            2) correct_answer_percentage_assesment
FROM
    ss_aw_assesment_multiple_question_answer mqa
        JOIN
    (SELECT 
        *,
            (CASE
                WHEN
                    ss_aw_course_id = 1
                        OR ss_aw_course_id = 2
                THEN
                    'E'
                WHEN ss_aw_course_id = 3 THEN 'A'
                WHEN ss_aw_course_id = '5' THEN 'M'
            END) course_level
    FROM
        ss_aw_child_course
    GROUP BY ss_aw_child_id , ss_aw_course_id) cc ON cc.ss_aw_child_id = mqa.ss_aw_child_id
        JOIN
    ss_aw_childs ac ON ac.ss_aw_child_id = cc.ss_aw_child_id
        JOIN
    ss_aw_assesment_uploaded au ON au.ss_aw_assesment_format = 'Multiple'
        AND IF(cc.course_level = 'E',
        FIND_IN_SET('E', au.ss_aw_course_id) != '0'
            OR FIND_IN_SET('C', au.ss_aw_course_id) != '0',
        FIND_IN_SET(cc.course_level, au.ss_aw_course_id) != '0')
        AND au.ss_aw_assessment_id = mqa.ss_aw_assessment_id
WHERE  mqa.ss_aw_question_id != '0'
        AND ac.ss_aw_child_id = $child_id $comp
GROUP BY mqa.ss_aw_child_id , au.ss_aw_lesson_id");
    }

    public function get_readalong_data($child_id) {
        return $this->db->query("select lr.ss_aw_child_id,lr.ss_aw_readalong_id,count(qa.ss_aw_id)cnt_total,
SUM(case when qa.ss_aw_quiz_right_wrong=1 then 1
	else 0 end)correct_no_readalong,
    round((SUM(case when qa.ss_aw_quiz_right_wrong=1 then 1
	else 0 end)*100)/count(qa.ss_aw_id),2)percent_readalong
 from ss_aw_last_readalong lr 
join ss_aw_readalong_quiz_ans qa on qa.ss_aw_readalong_id=lr.ss_aw_readalong_id
where lr.ss_aw_child_id='$child_id' group by lr.ss_aw_readalong_id");
    }

}
