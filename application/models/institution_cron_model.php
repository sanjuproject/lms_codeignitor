<?php
  class Institution_cron_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();		
	}

    public function getinstitutionwisedata($institution_id, $level, $course_id, $institution_list = 0) 
	{
		$fetch_users_type = " AND ac.ss_aw_child_delete = '0'";
		if ($institution_list) {
			$fetch_users_type .= " AND ac.ss_aw_child_status = '1'";
		}
		if ($course_id != 1 && $course_id != 3) {
			$dat = explode(",", $level);
			$levelSQl = " AND (FIND_IN_SET('$dat[0]', ss_aw_expertise_level) <> 0
			OR FIND_IN_SET('$dat[1]', ss_aw_expertise_level) <> 0)";
		} else {
			$levelSQl = " AND FIND_IN_SET('$level', ss_aw_expertise_level) <> 0";
		}
        if($course_id==2){
            $course_id=5;
        }
		if($level=='C' && $level=='E'){
			$champ="UNION ALL select * from (SELECT 
			lua.ss_aw_lesson_topic, ss_aw_lession_id
		FROM
			ss_aw_lessons_uploaded lua
		WHERE
			`lua`.`ss_aw_lesson_delete` = 0
				AND `lua`.`ss_aw_lesson_status` = 1
				AND `lua`.`ss_aw_lesson_format` = 'Multiple'
				AND (FIND_IN_SET('2', lua.ss_aw_course_id)
				OR FIND_IN_SET('3', lua.ss_aw_course_id))
		ORDER BY lua.`ss_aw_sl_no` ASC
		LIMIT 10 , 15)mu";
		}else{
			$champ="";
		}

		return $this->db->query("SELECT fi.*,
	    SUM(CASE
	        WHEN fi.ss_aw_diagonastic_exam_date != '' THEN 1
	        ELSE 0
	    END) diagnosticcompletenum,
	    GROUP_CONCAT(fi.ss_aw_child_id) child_id,
	    sum(case when als.id!='' then 1 else 0 end)lessoncompletenum,
	    group_concat((case when als.id!='' then als.child_id  end))lessoncompletechilds,
	    sum(case when fi.id!='' then 1 else 0 end)assessmentcompletenum,
	     group_concat((case when fi.id!='' then fi.ss_aw_child_id  end))assessmentcompletechilds,
	     sum(case when fi.ss_aw_last_lesson_modified_date!='' then 1 else 0 end)assessmentnonaccessable,
	      sum(case when fi.ss_aw_lession_id=1 then 1 when fi.ss_aw_lession_id!=1 and now() >= accessdate then 1 end)lessonnonaccessable,
          SUM(CASE
			WHEN fi.comp_days <= 7 THEN 1
			ELSE 0
		END) completed_on_time,
		 group_concat(CASE
			WHEN fi.comp_days <= 7 THEN fi.ss_aw_child_id       
		END) completed_on_time_users,
          SUM(CASE
			WHEN fi.comp_days > 7 and ss_aw_create_date!='' THEN 1
			ELSE 0
		END) completed_but_not_on_time,
		 group_concat(CASE
			WHEN fi.comp_days > 7 and ss_aw_create_date!='' THEN fi.ss_aw_child_id       
		END) completed_but_not_on_time_users,
		 SUM(CASE
			WHEN fi.comp_days > 7 and fi.comp_days <= 14 and ss_aw_create_date is null THEN 1
			ELSE 0
		END) one_to_seven_delinquent,
		  group_concat(CASE
			WHEN fi.comp_days > 7 and fi.comp_days <= 14 and ss_aw_create_date is null THEN fi.ss_aw_child_id       
		END) one_to_seven_delinquent_users,
		SUM(CASE
			WHEN fi.comp_days > 14 and fi.comp_days <= 21 and ss_aw_create_date is null THEN 1
			ELSE 0
		END) eight_to_forteen_delinquent,
		  group_concat(CASE
			WHEN fi.comp_days > 14 and fi.comp_days <= 21 and ss_aw_create_date is null THEN fi.ss_aw_child_id       
		END) eight_to_forteen_delinquent_users,
		 SUM(CASE
			WHEN fi.comp_days > 21 and ss_aw_create_date is null THEN 1
			ELSE 0
		END) fifteen_plus_delinquent,
	 group_concat(CASE
			WHEN fi.comp_days > 21 and ss_aw_create_date is null THEN fi.ss_aw_child_id       
		END) fifteen_plus_delinquent_users
	FROM
	    (SELECT 
	        tot.*,
	            aec.ss_aw_create_date,
	            (CASE
	                WHEN
	                    tot.ss_aw_last_lesson_create_date != ''
	                        AND aec.ss_aw_create_date != ''
	                THEN
	                    DATEDIFF(aec.ss_aw_create_date, tot.ss_aw_last_lesson_create_date)
	                WHEN
	                    (tot.ss_aw_last_lesson_create_date != ''
	                        AND aec.ss_aw_create_date IS NULL)
	                THEN
	                    DATEDIFF(NOW(), tot.ss_aw_last_lesson_create_date)
	            END) comp_days,
	            DATE_ADD(pll_create_date, INTERVAL 7 DAY) accessdate,aas.id
	    FROM
	        (SELECT 
	        lesson_listary.*,
	            child.*,
	            ll.ss_aw_last_lesson_create_date,
	            ll.ss_aw_last_lesson_modified_date,
	            IF(aqa.ss_aw_assessment_id != '', aqa.ss_aw_assessment_id, maqa.ss_aw_assessment_id) ss_aw_assessment_id,
	            maqa.ss_aw_id,
	            (SELECT 
	                    ss_aw_last_lesson_create_date
	                FROM
	                    ss_aw_child_last_lesson pll
	                WHERE
	                    pll.ss_aw_las_lesson_id = (SELECT 
	                            MAX(ss_aw_las_lesson_id)
	                        FROM
	                            ss_aw_child_last_lesson
	                        WHERE
	                            ss_aw_las_lesson_id < ll.ss_aw_las_lesson_id
	                                AND ss_aw_child_id = child.ss_aw_child_id)
	                        AND pll.ss_aw_child_id = child.ss_aw_child_id) pll_create_date
	    FROM
	        (SELECT 
    ss_aw_lesson_topic, ss_aw_lession_id,ss_aw_section_reference_no
FROM
    ss_aw_sections_topics
        JOIN
    ss_aw_lessons_uploaded lub ON (lub.ss_aw_lesson_topic_id = ss_aw_section_id)
        AND lub.ss_aw_lesson_status = '1'
        AND lub.ss_aw_lesson_delete = '0'
WHERE
    ss_aw_topic_deleted = 1
        AND ss_aw_section_status = 1
        AND (FIND_IN_SET('A', ss_aw_expertise_level) <> 0
        OR FIND_IN_SET('M', ss_aw_expertise_level) <> 0)  $levelSQl 
 $champ) lesson_listary
	    JOIN (SELECT 
	        ac.ss_aw_child_id,
	            ac.ss_aw_child_first_name,
	            ac.ss_aw_child_last_name,
	            de.ss_aw_diagonastic_exam_date
	    FROM
	        ss_aw_parents ap
	    JOIN ss_aw_childs ac ON ac.ss_aw_parent_id = ap.ss_aw_parent_id
	    	$fetch_users_type	      
	    JOIN ss_aw_diagonastic_exam de ON de.ss_aw_diagonastic_child_id = ac.ss_aw_child_id
	    JOIN ss_aw_child_course cc ON cc.ss_aw_child_id = ac.ss_aw_child_id
	        AND cc.ss_aw_course_id = '$course_id'
	    WHERE
	        ap.ss_aw_institution = '$institution_id' and ap.ss_aw_parent_delete='0') child
	    LEFT JOIN ss_aw_child_last_lesson ll ON ll.ss_aw_lesson_id = lesson_listary.ss_aw_lession_id
	        AND ll.ss_aw_child_id = child.ss_aw_child_id
	    LEFT JOIN (SELECT 
	        aau.ss_aw_assessment_id,
	            aau.ss_aw_lesson_id,
	            qa.ss_aw_child_id
	    FROM
	        ss_aw_assesment_questions_asked qa
	    JOIN ss_aw_assesment_uploaded aau ON aau.ss_aw_assessment_id = qa.ss_aw_assessment_id
	    GROUP BY aau.ss_aw_assessment_id , qa.ss_aw_child_id) aqa ON aqa.ss_aw_lesson_id = lesson_listary.ss_aw_lession_id
	        AND aqa.ss_aw_child_id = child.ss_aw_child_id
	    LEFT JOIN (SELECT 
	        aau.ss_aw_assessment_id,
	            aau.ss_aw_lesson_id,
	            mqa.ss_aw_child_id,
	            mqa.ss_aw_id
	    FROM
	        ss_aw_assesment_multiple_question_asked mqa
	    JOIN ss_aw_assesment_uploaded aau ON aau.ss_aw_assessment_id = mqa.ss_aw_assessment_id
	    GROUP BY aau.ss_aw_assessment_id , mqa.ss_aw_child_id) maqa ON maqa.ss_aw_lesson_id = lesson_listary.ss_aw_lession_id
	        AND maqa.ss_aw_child_id = child.ss_aw_child_id) tot
	    LEFT JOIN (SELECT 
	        *
	    FROM
	        ss_aw_assessment_score
	    GROUP BY assessment_id , child_id) aas ON aas.assessment_id = tot.ss_aw_assessment_id
	        AND aas.child_id = tot.ss_aw_child_id
	    LEFT JOIN (SELECT 
	        *
	    FROM
	        ss_aw_assessment_exam_completed
	    GROUP BY ss_aw_assessment_id , ss_aw_child_id) aec ON aec.ss_aw_assessment_id = tot.ss_aw_assessment_id
	        AND aec.ss_aw_child_id = tot.ss_aw_child_id
	    ) fi
	    left join ss_aw_lesson_score als on als.child_id=fi.ss_aw_child_id and als.lesson_id=fi.ss_aw_lession_id
	GROUP BY fi.ss_aw_lession_id order by ss_aw_section_reference_no     
	     ")->result_array();
	}


}