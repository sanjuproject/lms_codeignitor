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
             when cc.ss_aw_course_id='5' then 'M' end)course_level,ap.ss_aw_institution
        ");
        $this->db->from("(SELECT 
        *
    FROM
        ss_aw_child_course
    WHERE
        ss_aw_course_status = '1'          
    GROUP BY ss_aw_child_id) cc");
        $this->db->join("ss_aw_childs ac", "ac.ss_aw_child_id = cc.ss_aw_child_id");
        $this->db->join("ss_aw_parents ap", "ap.ss_aw_parent_id=ac.ss_aw_parent_id", 'left');
        if ($id != '') {
            $this->db->where("ac.ss_aw_child_id", $id);
        }
        return $this->db->get();
    }

    public function get_child_grammer_assessment($child_id, $start, $end) {

        $seq_no = $start - 1;
        $this->db->query("SET @seq:=$seq_no");
        $this->db->query("SET @seqa:=$seq_no");
        return $this->db->query("select sequence_no,
 `ss_aw_child_id`,
   `ss_aw_section_title`,    
  `ss_aw_section_id`,  
   qes_cnt_lesson,
    correct_answer_lesson,
   correct_answer_percentage_lesson,
       SUM(round(qes_cnt_asses,2)) qes_cnt_asses,
       sum(round(correct_answer_asses,2)) correct_answer_asses,
          SUM(round(correct_answer_percentage_asses,2))correct_answer_percentage_asses,
          SUM(ROUND(potencial, 2)) potencial_total
 from (select * from (select  @seq:= @seq + 1 as sequence_no,
    `ac`.`ss_aw_child_id`,
    `st`.`ss_aw_section_title`,    
   `st`.`ss_aw_section_id`,  
    COUNT(qa.ss_aw_id) qes_cnt_lesson,
    SUM(CASE
        WHEN qa.ss_aw_answer_status = 1 THEN 1
        ELSE 0
    END) correct_answer_lesson,
    ROUND(SUM(CASE
                WHEN qa.ss_aw_answer_status = 1 THEN 1
                ELSE 0
            END) * 100 / COUNT(qa.ss_aw_id),
            2) correct_answer_percentage_lesson,
            @qes_cnt_asses:=0 qes_cnt_asses,
            @correct_answer_asses:=0 correct_answer_asses,
            @correct_answer_percentage_asses:=0 correct_answer_percentage_asses,
             @potencial:=0 potencial
            from ss_aw_sections_topics st 
join  `ss_aw_lesson_quiz_ans` qa ON `st`.`ss_aw_section_id` = `qa`.`ss_aw_topic_id`
 JOIN
    `ss_aw_childs` `ac` ON `ac`.`ss_aw_child_id` = `qa`.`ss_aw_child_id`
where  `st`.`ss_aw_section_id` >= $start
        AND `st`.`ss_aw_section_id` <= $end
        and `qa`.`ss_aw_child_id` = $child_id and qa.ss_aw_answer_status != 3 GROUP BY `qa`.`ss_aw_child_id` , `qa`.`ss_aw_topic_id`
ORDER BY `st`.`ss_aw_section_id` ASC)lesson
        UNION ALL 
        select * from (select  @seqa:= @seqa + 1 as sequence_no,
        ss_aw_log_child_id,
        `ast`.`ss_aw_section_title`,   
            ss_aw_log_topic_id ss_aw_section_id,
            @qes_cnt_lesson:=0,
            @correct_answer_lesson:=0,
            @correct_answer_percentage_lesson:=0,
            COUNT(ss_aw_log_id) qes_cnt_asses,
            ROUND(SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE 0
            END), 2) correct_answer_asses,
            ROUND((SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE 0
            END) * 100) / SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE ad.ss_aw_weight
            END), 2) correct_answer_percentage_asses,
            round(SUM(CASE
                WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
                ELSE ad.ss_aw_weight
            END), 2)potencial
        from ss_aw_sections_topics ast
        JOIN ss_aw_assesment_uploaded aau ON aau.ss_aw_assesment_topic_id = ast.ss_aw_section_id   
        join ss_aw_assessment_exam_log on `ss_aw_assessment_exam_log`.`ss_aw_log_topic_id` = `ast`.`ss_aw_section_id`
        join (select * from ss_aw_assessment_score group by child_id,assessment_id) aas on aas.child_id=`ss_aw_assessment_exam_log`.`ss_aw_log_child_id` and aas.assessment_id=aau.ss_aw_assessment_id
        and aas.exam_code=`ss_aw_assessment_exam_log`.`ss_aw_log_exam_code`       
        JOIN ss_aw_assisment_diagnostic ad ON ad.ss_aw_id = ss_aw_assessment_exam_log.ss_aw_log_question_id
        where `ast`.`ss_aw_section_id` >= $start
        AND `ast`.`ss_aw_section_id` <= $end  and `ss_aw_assessment_exam_log`.`ss_aw_log_child_id` = $child_id and ss_aw_log_answer_status != 3
            GROUP BY ss_aw_log_exam_code , ss_aw_log_topic_id , ss_aw_log_child_id
    ORDER BY ss_aw_assessment_exam_log.ss_aw_log_topic_id)assesment )al group by ss_aw_section_id
    ");
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

    public function get_lesson_non_comprehension($child_id, $course_level, $comprehension) {
        if ($comprehension == false) {
            $comp = " and al.ss_aw_lesson_topic!='0'";
        } else {
            $comp = " and al.ss_aw_lesson_topic='0'";
        }
        if ($course_level == 'E') {
            $course = " and (find_in_set('1',al.ss_aw_course_id)!='0' or find_in_set('2',al.ss_aw_course_id)!='0')";
        } else {
            $course = " and find_in_set(cc.ss_aw_course_id,al.ss_aw_course_id)!='0'";
        }
        $this->db->query("SELECT 
    `al`.`ss_aw_lession_id`,
    `al`.`ss_aw_lesson_topic`,
    `ac`.`ss_aw_child_id`,
    `ac`.`ss_aw_child_nick_name`,
    COUNT(qa.ss_aw_id) qes_cnt_lesson,
    SUM(CASE
        WHEN qa.ss_aw_answer_status = 1 THEN 1
        ELSE 0
    END) correct_answer_lesson,
    ROUND(SUM(CASE
                WHEN qa.ss_aw_answer_status = 1 THEN 1
                ELSE 0
            END) * 100 / COUNT(qa.ss_aw_id),
            2) correct_answer_percentage_lesson
FROM
    `ss_aw_lesson_quiz_ans` `qa`
        JOIN
    (SELECT 
        *
    FROM
        ss_aw_child_course
    GROUP BY ss_aw_child_id , ss_aw_course_id) cc ON `cc`.`ss_aw_child_id` = `qa`.`ss_aw_child_id`
        JOIN
    `ss_aw_childs` `ac` ON `ac`.`ss_aw_child_id` = `cc`.`ss_aw_child_id`
       
        JOIN
    `ss_aw_lessons` `al` ON  `al`.`ss_aw_lession_id` = `qa`.`ss_aw_question_id` and `al`.`ss_aw_lesson_format` = 'Multiple'
        $comp $course
WHERE
    `ac`.`ss_aw_child_id` = '$child_id'
GROUP BY `qa`.`ss_aw_child_id` , al.ss_aw_lesson_topic
ORDER BY `ss_aw_id` ASC");
//    echo $this->db->last_query();
//    exit;
    }

    public function get_assesment_non_comprehension($child_id, $course_level, $comprehension) {
        if ($comprehension == false) {
            $comp = " AND mqa.ss_aw_topic_id != '0'";
        } else {
            $comp = " AND mqa.ss_aw_topic_id = '0'";
        }


        return $this->db->query("SELECT 
    ad.ss_aw_id,
    mqa.ss_aw_topic_id,
    ac.ss_aw_child_id,
    ac.ss_aw_child_nick_name,
    cc.ss_aw_course_id,
    course_level,
    ad.ss_aw_level ss_aw_course_id,
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
    ss_aw_assisment_diagnostic ad ON ad.ss_aw_format = 'Multiple'
        AND IF(cc.course_level = 'E',
        FIND_IN_SET('E', ad.ss_aw_level) != '0'
            OR FIND_IN_SET('C', ad.ss_aw_level) != '0',
        FIND_IN_SET(cc.course_level, ad.ss_aw_level) != '0')
        AND ad.ss_aw_uploaded_record_id = mqa.ss_aw_assessment_id
WHERE
    mqa.ss_aw_question_id != '0'
        AND ac.ss_aw_child_id = $child_id
        $comp
GROUP BY mqa.ss_aw_child_id , mqa.ss_aw_topic_id");
    }

    public function get_readalong_data($child_id) {
        return $this->db->query("select ru.ss_aw_title,lr.ss_aw_child_id,lr.ss_aw_readalong_id,count(qa.ss_aw_id)cnt_total,
SUM(case when qa.ss_aw_quiz_right_wrong=1 then 1
	else 0 end)correct_no_readalong,
    round((SUM(case when qa.ss_aw_quiz_right_wrong=1 then 1
	else 0 end)*100)/count(qa.ss_aw_id),2)percent_readalong
 from ss_aw_last_readalong lr 
join ss_aw_readalong_quiz_ans qa on qa.ss_aw_readalong_id=lr.ss_aw_readalong_id and qa.ss_aw_child_id=lr.ss_aw_child_id join ss_aw_readalongs_upload ru on ru.ss_aw_id = lr.ss_aw_readalong_id
where lr.ss_aw_child_id='$child_id' group by lr.ss_aw_readalong_id order by lr.ss_aw_create_date");
    }

    public function getConfidenceData($child_id) {
        return $this->db->query("select topic_id,
sum(lesson_skipped)lesson_skipped,
sum(lesson_backups)lesson_backups,
sum(lesson_total)lesson_total,
sum(assesment_skipped)assesment_skipped,
sum(review_skipped)review_skipped,
round((sum(multiple_choice_lesson)/2),2) multiple_choice_lesson,
round((sum(short_answers_lesson)/2),2) short_answers_lesson,
round((sum(complete_sentence_lesson)/2),2) complete_sentence_lesson
 from (select *
 from(
SELECT 
qa.ss_aw_topic_id topic_id,
   @lesson_skip:=0 lesson_skipped,
   sum(qa.ss_aw_back_click_count)lesson_backups,
   sum(qa.ss_aw_back_click_count)/3 lesson_total,
   @assesment_skipped:=0 assesment_skipped,
   @review_skipped:=0 review_skipped,
  @multiple_choice_lesson:=0 multiple_choice_lesson,
   @short_answers_lesson:=0 short_answers_lesson,
    @complete_sentence_lesson:=0 complete_sentence_lesson   
FROM
    ss_aw_lesson_quiz_ans qa
WHERE
    qa.ss_aw_child_id = '$child_id'
GROUP BY qa.ss_aw_topic_id , qa.ss_aw_child_id)lesson
union all
select * from (
SELECT 
el.ss_aw_log_topic_id topic_id,
@lesson_skip:=0 lesson_skipped,
@lesson_backups:=0 lesson_backups,
@lesson_total:=0 lesson_total,
    sum(case when el.ss_aw_log_answer_status=3 then 1 else 0 end)assesment_skipped,
    @review_skipped:=0 review_skipped,
   sum(case when el.ss_aw_log_question_type=2 then el.ss_aw_seconds_to_answer_question-ABS(el.ss_aw_log_start_answer_time) else 0 end)/sum(case when el.ss_aw_log_question_type=2 then 1 else 0 end)multiple_choice_lesson,
   sum(case when el.ss_aw_log_question_type=1 then el.ss_aw_seconds_to_answer_question-ABS(el.ss_aw_log_start_answer_time) else 0 end)/sum(case when el.ss_aw_log_question_type=1 then 1 else 0 end)short_answers_lesson,
    sum(case when el.ss_aw_log_question_type=3 then el.ss_aw_seconds_to_answer_question-ABS(el.ss_aw_log_start_answer_time) else 0 end)/sum(case when el.ss_aw_log_question_type=3 then 1 else 0 end)complete_sentence_lesson   
    
    
FROM
    ss_aw_assessment_exam_log el
WHERE
    el.ss_aw_log_child_id = '$child_id'       
GROUP BY el.ss_aw_log_topic_id , el.ss_aw_log_child_id
)assesment
union all
select 
st.ss_aw_section_id topic_id,
@lesson_skip:=0 lesson_skipped,
@lesson_backups:=0 lesson_backups,
@lesson_total:=0 lesson_total,
 @assesment_skipped:=0 assesment_skipped,
sum(case when mqa.ss_aw_answers_status=3 then 1 else 0 end)review_skipped,
sum(case when ad.ss_aw_question_format='Choose the right answer' then mqa.ss_aw_seconds_to_answer_question-ABS(mqa.ss_aw_seconds_to_start_answer_question) else 0 end)/sum(case when ad.ss_aw_question_format='Choose the right answer' then 1 else 0 end)multiple_choice_lesson,
sum(case when ad.ss_aw_question_format='Fill in the blanks' then mqa.ss_aw_seconds_to_answer_question-ABS(mqa.ss_aw_seconds_to_start_answer_question) else 0 end)/sum(case when ad.ss_aw_question_format='Fill in the blanks' then 1 else 0 end)short_answers_lesson,
sum(case when ad.ss_aw_question_format='Rewrite the sentence' then mqa.ss_aw_seconds_to_answer_question-ABS(mqa.ss_aw_seconds_to_start_answer_question) else 0 end)/sum(case when ad.ss_aw_question_format='Rewrite the sentence' then 1 else 0 end)complete_sentence_lesson  
from ss_aw_sections_topics st
left join ss_aw_assisment_diagnostic ad on ad.ss_aw_question_topic_id=st.ss_aw_section_id
left join ss_aw_assesment_multiple_question_answer mqa on mqa.ss_aw_question_id=ad.ss_aw_id and mqa.ss_aw_child_id='$child_id'
where ad.ss_aw_format='Multiple' and ad.ss_aw_question_topic_id!=0 and st.ss_aw_section_id<=11  group by st.ss_aw_section_id

)tb group by tb.topic_id");
    }

    public function getConfidenceVocabulary($child_id, $start, $end) {
        return $this->db->query("SELECT 
    st.ss_aw_section_id,
    st.ss_aw_section_title,
    SUM(CASE
        WHEN el.ss_aw_log_answer_status = 3 THEN 1
        ELSE 0
    END) voccabulary_skipped
FROM
    ss_aw_sections_topics st
        LEFT JOIN
    ss_aw_assessment_exam_log el ON el.ss_aw_log_child_id = '$child_id'
        AND el.ss_aw_log_topic_id = st.ss_aw_section_id
        AND el.ss_aw_log_answer_status = '3'
WHERE
    st.ss_aw_section_id >= '$start'
        AND st.ss_aw_section_id <= '$end'
GROUP BY st.ss_aw_section_id");
    }


//Mlp data querys//

public function get_all_mlp_course_completed_child($id) {
    $this->db->select("ac.*,cc.ss_aw_course_id,TIMESTAMPDIFF(YEAR,
    DATE(ac.ss_aw_child_dob),
    DATE(cc.ss_aw_child_course_create_date))child_age,
    (case when cc.ss_aw_course_id='1' or cc.ss_aw_course_id='2' then 'E'
         when cc.ss_aw_course_id='3' then 'A'
         when cc.ss_aw_course_id='5' then 'M' end)course_level,ap.ss_aw_institution
    ");
    $this->db->from("(SELECT 
    *
FROM
    ss_aw_child_course
WHERE
    ss_aw_course_status = '1'          
GROUP BY ss_aw_child_id) cc");
    $this->db->join("ss_aw_childs ac", "ac.ss_aw_child_id = cc.ss_aw_child_id");
    $this->db->join("ss_aw_parents ap", "ap.ss_aw_parent_id=ac.ss_aw_parent_id", 'left');
    if ($id != '') {
        $this->db->where("ac.ss_aw_child_id", $id);
    }
    return $this->db->get();
}

public function get_child_grammer_assessment_mlp($child_id, $start, $end){
    $seq_no = $start - 1;
    $this->db->query("SET @seq:=$seq_no");
    $this->db->query("SET @seqa:=$seq_no");
    return $this->db->query("select sequence_no,
`ss_aw_child_id`,
`ss_aw_section_title`,    
`ss_aw_section_id`,  
qes_cnt_lesson,
correct_answer_lesson,
correct_answer_percentage_lesson,
   SUM(round(qes_cnt_asses,2)) qes_cnt_asses,
   sum(round(correct_answer_asses,2)) correct_answer_asses,
      SUM(round(correct_answer_percentage_asses,2))correct_answer_percentage_asses,
      SUM(ROUND(potencial, 2)) potencial_total
from (select * from (select  @seq:= @seq + 1 as sequence_no,
`ac`.`ss_aw_child_id`,
`st`.`ss_aw_section_title`,    
`st`.`ss_aw_section_id`,  
COUNT(qa.ss_aw_id) qes_cnt_lesson,
SUM(CASE
    WHEN qa.ss_aw_answer_status = 1 THEN 1
    ELSE 0
END) correct_answer_lesson,
ROUND(SUM(CASE
            WHEN qa.ss_aw_answer_status = 1 THEN 1
            ELSE 0
        END) * 100 / COUNT(qa.ss_aw_id),
        2) correct_answer_percentage_lesson,
        @qes_cnt_asses:=0 qes_cnt_asses,
        @correct_answer_asses:=0 correct_answer_asses,
        @correct_answer_percentage_asses:=0 correct_answer_percentage_asses,
         @potencial:=0 potencial
        from ss_aw_sections_topics st 
        join ss_aw_sections_topic_master_lite stml on stml.ss_aw_section_id=st.ss_aw_section_id
join  `ss_aw_lesson_quiz_ans` qa ON `st`.`ss_aw_section_id` = `qa`.`ss_aw_topic_id`
JOIN
`ss_aw_childs` `ac` ON `ac`.`ss_aw_child_id` = `qa`.`ss_aw_child_id`
where  `st`.`ss_aw_section_id` >= $start
    AND `st`.`ss_aw_section_id` <= $end
    and `qa`.`ss_aw_child_id` = $child_id and qa.ss_aw_answer_status != 3 GROUP BY `qa`.`ss_aw_child_id` , `qa`.`ss_aw_topic_id`
ORDER BY `st`.`ss_aw_section_id` ASC)lesson
    UNION ALL 
    select * from (select  @seqa:= @seqa + 1 as sequence_no,
    ss_aw_log_child_id,
    `ast`.`ss_aw_section_title`,   
        ss_aw_log_topic_id ss_aw_section_id,
        @qes_cnt_lesson:=0,
        @correct_answer_lesson:=0,
        @correct_answer_percentage_lesson:=0,
        COUNT(ss_aw_log_id) qes_cnt_asses,
        ROUND(SUM(CASE
            WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
            ELSE 0
        END), 2) correct_answer_asses,
        ROUND((SUM(CASE
            WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
            ELSE 0
        END) * 100) / SUM(CASE
            WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
            ELSE ad.ss_aw_weight
        END), 2) correct_answer_percentage_asses,
        round(SUM(CASE
            WHEN ss_aw_log_answer_status = 1 THEN ad.ss_aw_weight
            ELSE ad.ss_aw_weight
        END), 2)potencial
    from ss_aw_sections_topics ast
    join ss_aw_sections_topic_master_lite stmla on stmla.ss_aw_section_id=ast.ss_aw_section_id
    JOIN ss_aw_assesment_uploaded aau ON aau.ss_aw_assesment_topic_id = ast.ss_aw_section_id   
    join ss_aw_assessment_exam_log on `ss_aw_assessment_exam_log`.`ss_aw_log_topic_id` = `ast`.`ss_aw_section_id`
    join (select * from ss_aw_assessment_score group by child_id,assessment_id) aas on aas.child_id=`ss_aw_assessment_exam_log`.`ss_aw_log_child_id` and aas.assessment_id=aau.ss_aw_assessment_id
    and aas.exam_code=`ss_aw_assessment_exam_log`.`ss_aw_log_exam_code`       
    JOIN ss_aw_assisment_diagnostic ad ON ad.ss_aw_id = ss_aw_assessment_exam_log.ss_aw_log_question_id
    where `ast`.`ss_aw_section_id` >= $start
    AND `ast`.`ss_aw_section_id` <= $end  and `ss_aw_assessment_exam_log`.`ss_aw_log_child_id` = $child_id and ss_aw_log_answer_status != 3
        GROUP BY ss_aw_log_exam_code , ss_aw_log_topic_id , ss_aw_log_child_id
ORDER BY ss_aw_assessment_exam_log.ss_aw_log_topic_id)assesment )al group by ss_aw_section_id
");
}


public function get_mlp_user_data(){
    $this->db->select("lc.ss_aw_child_id,concat(ac.ss_aw_child_first_name,ac.ss_aw_child_last_name)name");
    $this->db->from("ss_aw_master_lite_childs lc");
    $this->db->join("ss_aw_childs ac","ac.ss_aw_child_id=lc.ss_aw_child_id","left");

    $this->db->where("lc.ss_aw_status",1);
   return $this->db->get()->result();
}

}
