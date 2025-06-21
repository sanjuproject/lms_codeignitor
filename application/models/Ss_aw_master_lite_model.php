<?php

class Ss_aw_master_lite_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_all_master_data() {
        return $this->db->query("SELECT 
    mlc.ss_aw_id mlp_id,mlc.ss_aw_child_id,mlc.upcoming_lession_id,mlc.mail_send,
    ac.ss_aw_child_first_name,
    ac.ss_aw_child_last_name,
    lu.ss_aw_lesson_topic_id,
    st.ss_aw_section_title,
    ss_aw_las_lesson_id,
    le.ss_aw_lesson_id,
    ss_aw_last_lesson_create_date,
    ss_aw_last_lesson_modified_date,
    aec.ss_aw_id,
    aec.ss_aw_create_date,
    ac.ss_aw_parent_id,
    ac.ss_aw_is_institute,
    ap.ss_aw_parent_full_name,
    ap.ss_aw_parent_address,
    ap.ss_aw_parent_city,
    ap.ss_aw_parent_state,
    ap.ss_aw_parent_pincode,
    ap.ss_aw_parent_country,
    ap.ss_aw_institution,
    ai.ss_aw_name,ag.ss_aw_mlp_access_given_id,de.ss_aw_diagonastic_exam_date,
    (select ss_aw_lession_id from ss_aw_lessons_uploaded where ss_aw_lession_id>le.ss_aw_lesson_id limit 1)ucoming_lesson_id
    
FROM
    ss_aw_master_lite_childs mlc
        LEFT JOIN
    (SELECT 
        ll.*
    FROM
        (SELECT 
        MAX(ss_aw_las_lesson_id) las_lesson_id
    FROM
        ss_aw_child_last_lesson
    GROUP BY ss_aw_child_id
    ORDER BY ss_aw_las_lesson_id DESC) les
    JOIN ss_aw_child_last_lesson ll ON ll.ss_aw_las_lesson_id = les.las_lesson_id) le ON le.ss_aw_child_id = mlc.ss_aw_child_id
       LEFT JOIN
    ss_aw_lessons_uploaded lu ON lu.ss_aw_lession_id = le.ss_aw_lesson_id
        LEFT JOIN
    ss_aw_assesment_uploaded au ON au.ss_aw_assesment_topic_id = lu.ss_aw_lesson_topic_id
        LEFT JOIN
    ss_aw_assessment_exam_completed aec ON aec.ss_aw_child_id = mlc.ss_aw_child_id
        AND aec.ss_aw_assessment_id = au.ss_aw_assessment_id
        JOIN
    ss_aw_childs ac ON ac.ss_aw_child_id = mlc.ss_aw_child_id
    left join ss_aw_parents ap on ap.ss_aw_parent_id=ac.ss_aw_parent_id
    left join ss_aw_institutions ai on ai.ss_aw_id=ap.ss_aw_institution
    left join ss_aw_sections_topics st on st.ss_aw_section_id=lu.ss_aw_lesson_topic_id
    LEFT JOIN ss_aw_master_lite_access_given ag on ag.ss_aw_child_id=ac.ss_aw_child_id and ag.ss_aw_lesson_assesment_id=(select ss_aw_lession_id from ss_aw_lessons_uploaded where ss_aw_lession_id>le.ss_aw_lesson_id limit 1)
    left join ss_aw_diagonastic_exam de on de.ss_aw_diagonastic_child_id=ac.ss_aw_child_id and de.ss_aw_diagonastic_exam_status=1
WHERE
    mlc.ss_aw_status = '1'
GROUP BY ss_aw_child_id");
    }

    public function get_lesson_quize($searchary, $child_id) {
        $ss_aw_lesson_record_id = $searchary['ss_aw_lesson_record_id'];
        $ss_aw_course_id = $searchary['ss_aw_course_id'];
        $ss_aw_lesson_format_type = $searchary['ss_aw_lesson_format_type'];

        return $this->db->query("SELECT ss_aw_lesson_record_id,ss_aw_lession_id,"
                        . "ss_aw_lesson_details,ss_aw_lesson_question_options, ss_aw_lesson_format_type,
                  ss_aw_lesson_topic
FROM
    `ss_aw_lessons`
WHERE
    `ss_aw_lessons`.`ss_aw_lesson_record_id` = $ss_aw_lesson_record_id
        AND `ss_aw_lessons`.`ss_aw_course_id` = $ss_aw_course_id
        AND `ss_aw_lessons`.`ss_aw_lesson_format_type` = $ss_aw_lesson_format_type
        AND `ss_aw_lesson_delete` = '0'
        AND `ss_aw_lesson_audio_exist` = '1'
        AND `ss_aw_lesson_status` = '1' 
        and not exists(select * from ss_aw_lesson_quiz_ans where ss_aw_question_id=ss_aw_lession_id and ss_aw_child_id='$child_id')");
    }

    public function get_lesson_count_data($searchary, $child_id) {
        $ss_aw_lesson_record_id = $searchary['ss_aw_lesson_record_id'];
        return $this->db->query("SELECT 
    count(qa.ss_aw_lesson_id)total_lesson,sum(case when ss_aw_answer_status=1 then 1 end)correct_lesson
FROM
    ss_aw_lesson_quiz_ans qa
WHERE
    qa.ss_aw_lesson_id = $ss_aw_lesson_record_id
        AND qa.ss_aw_child_id = '$child_id'")->row();
    }

    public function check_score_exist($child_id, $lesson_id) {
        $this->db->select("ls.*");
        $this->db->where("ls.child_id", "$child_id");
        $this->db->where("ls.lesson_id", "$lesson_id");
        $this->db->from("ss_aw_lesson_score ls");
        return $this->db->get();
    }

    public function get_assesment_log_question_data($ss_aw_sub_category, $assessment_id, $fetch_level, $serial_no) {

        return $this->db->query("SELECT ad.ss_aw_uploaded_record_id,ad.ss_aw_category,ad.ss_aw_sub_category,ad.ss_aw_id,ad.ss_aw_quiz_type,ad.ss_aw_weight,"
                        . "ad.ss_aw_question_topic_id,concat('[\"',replace(ad.ss_aw_answers,'/','\",\"'),'\"]')answer FROM "
                        . "ss_aw_assisment_diagnostic ad WHERE ad.ss_aw_uploaded_record_id='$assessment_id' AND ad.ss_aw_level='$fetch_level'"
                        . " AND ad.ss_aw_sub_category='$ss_aw_sub_category' AND ad.ss_aw_seq_no='" . $serial_no . "' limit 1")->row();
    }

    public function get_assesment_log_data($exam_code) {
        $this->db->select("count(el.ss_aw_log_id)total_log,el.ss_aw_log_category");
        $this->db->where("el.ss_aw_log_exam_code", "$exam_code");
        $this->db->from("ss_aw_assessment_exam_log el");
        $this->db->group_by("el.ss_aw_log_child_id");
        return $this->db->get()->row();
    }

    public function get_assesment_log_multi_data($exam_code) {
        $this->db->select("count(el.ss_aw_id)total_log");
        $this->db->where("el.ss_aw_assessment_exam_code", "$exam_code");
        $this->db->from("ss_aw_assesment_multiple_question_answer el");
        $this->db->group_by("el.ss_aw_child_id");
//        $this->db->get();
//        echo $this->db->last_query();
//        exit;
        return $this->db->get()->row();
    }

    public function get_multiple_question($assesment_id) {
        return $this->db->query("SELECT 
    ad.*,
    (CASE
        WHEN ad.ss_aw_question_format = 'Choose the right answer' THEN 2
        WHEN ad.ss_aw_question_format = 'Fill in the blanks' THEN 1
        WHEN ad.ss_aw_question_format = 'Rewrite the sentence' THEN 3
        ELSE 0
    END) qtype
FROM
    ss_aw_assisment_diagnostic ad
WHERE
    ad.ss_aw_uploaded_record_id = '$assesment_id'
        AND ad.ss_aw_question_format != ''");
    }

    public function getallcompletelessonbychild($ss_aw_assessment_id, $child_id) {
        $this->db->select("ll.*,au.ss_aw_assessment_id");
        $this->db->from("ss_aw_assesment_uploaded au");
        $this->db->join("ss_aw_child_last_lesson ll", "ll.ss_aw_lesson_id=au.ss_aw_lesson_id "
                . "AND ll.ss_aw_child_id=" . $child_id);
        $this->db->where("au.ss_aw_assessment_id", $ss_aw_assessment_id);
        $this->db->where("au.ss_aw_assesment_delete", 0);
        $this->db->order_by('ss_aw_las_lesson_id', 'ASC');
        return $this->db->get()->row();
    }

    public function countsubtopicquestion($fetch_level, $assessment_id, $sub_category) {
        $this->db->select("count(au.ss_aw_id)value");
        $this->db->from("ss_aw_assisment_diagnostic au");
        $this->db->where("au.ss_aw_uploaded_record_id", $assessment_id);
        $this->db->where("au.ss_aw_level", $fetch_level);
        $this->db->where("au.ss_aw_sub_category", $sub_category);
        $this->db->group_by("au.ss_aw_sub_category");
        $this->db->order_by('au.ss_aw_id', 'ASC');
        return $this->db->get()->row();
    }

    public function get_instution_name_by_child_id($child_id) {
        $this->db->select("ai.*");
        $this->db->from("ss_aw_childs ac");
        $this->db->join("ss_aw_parents ap", "ap.ss_aw_parent_id=ac.ss_aw_parent_id");
        $this->db->join("ss_aw_institutions ai", "ai.ss_aw_id=ap.ss_aw_institution");
        $this->db->where("ac.ss_aw_child_id", $child_id);
        return $this->db->get()->row();
    }

    public function get_upload_active_data($assessment_id) {
        $this->db->select('ss_aw_assesment_uploaded .*,ss_aw_lessons_uploaded.ss_aw_sl_no');
        $this->db->join('ss_aw_lessons_uploaded', 'ss_aw_assesment_uploaded.ss_aw_lesson_id = ss_aw_lessons_uploaded.ss_aw_lession_id', 'left');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_delete', '0');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_status', '1');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $assessment_id);
        $this->db->group_by("ss_aw_assesment_topic_id");
        $this->db->order_by('ss_aw_lessons_uploaded.ss_aw_sl_no', 'ASC');
        return $this->db->get("ss_aw_assesment_uploaded")->row_array();
    }
	public function update_data($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);		
		$this->db->update("ss_aw_master_lite_childs", $data);
		return $this->db->affected_rows();
	}
}
