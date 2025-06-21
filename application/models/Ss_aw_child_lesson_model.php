<?php

/**
 * 
 */
class Ss_aw_child_lesson_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_child_age($child_id, $level) {
        $this->db->select("ac.ss_aw_child_id,
    TIMESTAMPDIFF(YEAR,
        DATE(ac.ss_aw_child_dob),
        DATE(cc.ss_aw_child_course_create_date)) age  ");
        $this->db->from("ss_aw_childs ac");
        $this->db->join("ss_aw_child_course cc", "cc.ss_aw_child_id = ac.ss_aw_child_id  AND cc.ss_aw_course_id = $level");
        $this->db->where("ac.ss_aw_child_id", $child_id);
        $this->db->where("ac.ss_aw_child_delete", 0);
        $this->db->where("ac.ss_aw_child_status", 1);
        return $this->db->get()->row();
    }

    public function get_question_count($child_id, $course_id, $lesson_id) {
        $this->db->select("count(al.ss_aw_lession_id)cnt_lesson,"
                . "(select count(ss_aw_id) from ss_aw_lesson_quiz_ans where  ss_aw_child_id='$child_id' and ss_aw_lesson_id='$lesson_id' group by ss_aw_lesson_id)cnt_lesson_done");
        $this->db->from("ss_aw_lessons al");
        $this->db->where("al.ss_aw_lesson_record_id", $lesson_id);
        $this->db->where("al.ss_aw_course_id", $course_id);
        $this->db->where("al.ss_aw_lesson_delete", 0);
        $this->db->where("al.ss_aw_lesson_quiz_type_id<>", 0);
        return $this->db->get()->row();
    }

    public function data_lesson_quize_insert($child_id, $course_id, $lesson_id,$limit) {
        return $this->db->query("insert into ss_aw_lesson_quiz_ans (
ss_aw_lesson_id,
ss_aw_question_id,
ss_aw_question,
ss_aw_options,
ss_aw_post_answer,
ss_aw_answer_status,
ss_aw_question_format,
ss_aw_child_id,
ss_aw_topic_id,
ss_aw_seconds_to_start_answer_question,
ss_aw_seconds_to_answer_question,
ss_aw_back_click_count,
ss_aw_created_date
) 
SELECT 
    al.ss_aw_lesson_record_id ,
    al.ss_aw_lession_id,
        al.ss_aw_lesson_details,
      '',
       '',       
       '2',
        al.ss_aw_lesson_format_type,
       $child_id,
        al.ss_aw_lesson_topic,
       '0.00',
        '0.00',
       '0',
        NOW()
        
FROM
    ss_aw_lessons al
WHERE
    `al`.`ss_aw_lesson_record_id` = $lesson_id
        AND `al`.`ss_aw_course_id` = $course_id
        AND `al`.`ss_aw_lesson_delete` = '0'
        AND `al`.`ss_aw_lesson_quiz_type_id` <> '0'
        AND NOT EXISTS( SELECT 
            al.ss_aw_lession_id
        FROM
            ss_aw_lesson_quiz_ans qa
        WHERE
            qa.ss_aw_child_id = $child_id
                AND qa.ss_aw_lesson_id = `al`.`ss_aw_lesson_record_id`
                AND qa.ss_aw_question_id = al.ss_aw_lession_id) limit $limit");
    } 

    public function get_all_lesson_type($child_id='') {
        if($child_id!=''){
            $ch_data=" AND ll.ss_aw_child_id=$child_id";
        }else{
            $ch_data='';
        }
        return $this->db->query("SELECT 
    cc.ss_aw_child_id,cc.ss_aw_course_id,TIMESTAMPDIFF(YEAR,
        DATE(ac.ss_aw_child_dob),
        DATE(cc.ss_aw_child_course_create_date)) age,ll.ss_aw_lesson_id
FROM
 ss_aw_child_last_lesson ll 
  join ss_aw_child_course cc on cc.ss_aw_child_id=ll.ss_aw_child_id and cc.ss_aw_course_id=ll.ss_aw_lesson_level
        JOIN
    ss_aw_childs ac ON ac.ss_aw_child_id = cc.ss_aw_child_id
        AND ac.ss_aw_child_delete = '0'
        AND ac.ss_aw_child_status = '1'
        where ll.ss_aw_last_lesson_modified_date!=''  and ll.ss_aw_last_lesson_create_date>='2023-04-01' $ch_data 
GROUP BY ll.ss_aw_child_id , ll.ss_aw_lesson_id");
    }
    public function update_lesson_score($child_id, $lesson_id,$limit) {
        return $this->db->query("UPDATE ss_aw_lesson_score set total_question=total_question+$limit where lesson_id=$lesson_id and child_id=$child_id");
    }
}
