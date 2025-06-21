<?php
/**
 * 
 */
class Module_wise_performance_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getmodulewisereportdata($institution_id,$level,$course_id){
		if($course_id!=1 && $course_id!=3){
			$dat=explode(",",$level);
			$levelSQl=" AND (FIND_IN_SET('$dat[0]', st.ss_aw_expertise_level) <> 0
			OR FIND_IN_SET('$dat[1]', st.ss_aw_expertise_level) <> 0)";
		}else{
			$levelSQl=" AND FIND_IN_SET('$level', st.ss_aw_expertise_level) <> 0";
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
	      sum(case when fi.ss_aw_section_id=1 then 1 when fi.ss_aw_section_id!=1 and now() >= accessdate then 1 end)lessonnonaccessable
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
	        st.ss_aw_section_id,
	            st.ss_aw_section_title,
	            lu.ss_aw_lession_id,
	            lu.ss_aw_lesson_topic
	    FROM
	        ss_aw_sections_topics st
	    JOIN ss_aw_lessons_uploaded lu ON lu.ss_aw_lesson_topic_id = st.ss_aw_section_id
	        AND lu.ss_aw_lesson_status = '1'
	        AND lu.ss_aw_lesson_delete = '0'
	    WHERE
	        st.ss_aw_topic_deleted = '1'
	            AND st.ss_aw_section_status = '1' $levelSQl
	    GROUP BY st.ss_aw_section_id) lesson_listary
	    JOIN (SELECT 
	        ac.ss_aw_child_id,
	            ac.ss_aw_child_first_name,
	            ac.ss_aw_child_last_name,
	            de.ss_aw_diagonastic_exam_date
	    FROM
	        ss_aw_parents ap
	    JOIN ss_aw_childs ac ON ac.ss_aw_parent_id = ap.ss_aw_parent_id
	        AND ac.ss_aw_child_delete = '0'
	        AND ac.ss_aw_child_username IS NULL
	    JOIN ss_aw_diagonastic_exam de ON de.ss_aw_diagonastic_child_id = ac.ss_aw_child_id
	    JOIN ss_aw_child_course cc ON cc.ss_aw_child_id = ac.ss_aw_child_id
	        AND cc.ss_aw_course_id = '$course_id'
	    WHERE
	        ap.ss_aw_institution = '$institution_id') child
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
	    ORDER BY tot.ss_aw_child_id , tot.ss_aw_section_id ASC) fi
	    left join ss_aw_lesson_score als on als.child_id=fi.ss_aw_child_id and als.lesson_id=fi.ss_aw_lession_id
	GROUP BY fi.ss_aw_lession_id     
	     ")->result_array();
	}

	public function getmodulewisenoncompletedata($institution_id,$level,$course_id){
		if($course_id!=1 && $course_id!=3){
			$dat=explode(",",$level);
			$levelSQl=" AND (FIND_IN_SET('$dat[0]', st.ss_aw_expertise_level) <> 0
			OR FIND_IN_SET('$dat[1]', st.ss_aw_expertise_level) <> 0)";
		}else{
			$levelSQl=" AND FIND_IN_SET('$level', st.ss_aw_expertise_level) <> 0";
		}
		return $this->db->query("select ne.ss_aw_lession_id,ne.ss_aw_lesson_topic,
		sum(case when ne.ss_aw_last_lesson_modified_date is null then 1 end)lessonnotcompleted,
		group_concat(case when ne.ss_aw_last_lesson_modified_date is null then ne.ss_aw_child_id end)lessonnotcompletedchild,
		sum(case when ne.ss_aw_create_date is null then 1 end)assessmentnotcompleted,
		group_concat(case when ne.ss_aw_create_date is null then ne.ss_aw_child_id end)assessmentnotcompletedchild,
		sum(case when ne.ss_aw_create_date !='' and ne.days>7 then 1 end)nextadd,
		group_concat(case when ne.ss_aw_create_date !='' and ne.days>7 then ne.ss_aw_child_id end)nextaddchild,ne.lesson_count
		 from(SELECT 
			li.*,
			ll.ss_aw_lesson_id,
			ll.ss_aw_last_lesson_create_date,
			ll.ss_aw_last_lesson_modified_date,
			lesson_listary.ss_aw_lession_id,
			lesson_listary.ss_aw_lesson_topic,
			aec.ss_aw_create_date,aau.ss_aw_assessment_id,
			 DATE_ADD(ll.ss_aw_last_lesson_create_date, INTERVAL 7 DAY) accessable,
			 datediff(now(),ll.ss_aw_last_lesson_create_date)days,
			 (select count(ss_aw_lesson_id) from ss_aw_child_last_lesson where ss_aw_child_id = li.ss_aw_child_id group by ss_aw_child_id)lesson_count
			 
		FROM
			(SELECT 
				ac.ss_aw_child_id,
					ac.ss_aw_child_first_name,
					ac.ss_aw_child_last_name,
					de.ss_aw_diagonastic_exam_date,
					(SELECT 
							GROUP_CONCAT(ss_aw_las_lesson_id)
						FROM
							ss_aw_child_last_lesson
						WHERE
							ss_aw_child_last_lesson.ss_aw_las_lesson_id = (SELECT 
									MAX(ss_aw_las_lesson_id)
								FROM
									ss_aw_child_last_lesson
								WHERE
									ss_aw_child_id = ac.ss_aw_child_id
								GROUP BY ss_aw_child_id)
								AND ss_aw_child_last_lesson.ss_aw_child_id = ac.ss_aw_child_id) las_lesson_id
								
			FROM
				ss_aw_parents ap
			JOIN ss_aw_childs ac ON ac.ss_aw_parent_id = ap.ss_aw_parent_id
				AND ac.ss_aw_child_delete = '0'
				AND ac.ss_aw_child_username IS NULL
			JOIN ss_aw_diagonastic_exam de ON de.ss_aw_diagonastic_child_id = ac.ss_aw_child_id
			JOIN ss_aw_child_course cc ON cc.ss_aw_child_id = ac.ss_aw_child_id
				AND cc.ss_aw_course_id = '$course_id'
			WHERE
				ap.ss_aw_institution = '$institution_id') li
				LEFT JOIN
			ss_aw_child_last_lesson ll ON ll.ss_aw_las_lesson_id = li.las_lesson_id
				LEFT JOIN
			(SELECT 
				st.ss_aw_section_id,
					st.ss_aw_section_title,
					lu.ss_aw_lession_id,
					lu.ss_aw_lesson_topic
			FROM
				ss_aw_sections_topics st
			JOIN ss_aw_lessons_uploaded lu ON lu.ss_aw_lesson_topic_id = st.ss_aw_section_id
				AND lu.ss_aw_lesson_status = '1'
				AND lu.ss_aw_lesson_delete = '0'
			WHERE
				st.ss_aw_topic_deleted = '1'
					AND st.ss_aw_section_status = '1' $levelSQl
			GROUP BY st.ss_aw_section_id  order by st.ss_aw_section_reference_no asc) lesson_listary ON lesson_listary.ss_aw_lession_id = ll.ss_aw_lesson_id
			   LEFT JOIN ss_aw_assesment_uploaded aau 
		   on aau.ss_aw_lesson_id = ll.ss_aw_lesson_id and aau.ss_aw_assesment_delete=0
			   
				LEFT JOIN
			(SELECT 
				*
			FROM
				ss_aw_assessment_score
			GROUP BY assessment_id , child_id) aas ON aas.assessment_id = aau.ss_aw_assessment_id
				AND aas.child_id = li.ss_aw_child_id
				LEFT JOIN
			(SELECT 
				*
			FROM
				ss_aw_assessment_exam_completed
			GROUP BY ss_aw_assessment_id , ss_aw_child_id) aec ON aec.ss_aw_assessment_id = aau.ss_aw_assessment_id
				AND aec.ss_aw_child_id = li.ss_aw_child_id)ne group by ne.ss_aw_lession_id")->result_array();
	}
	public function getlessondata($institution_id,$lesson_id,$course_id){
		return $this->db->query("SELECT 
		count(ac.ss_aw_child_id)val
	 FROM
		 ss_aw_parents ap
	 JOIN ss_aw_childs ac ON ac.ss_aw_parent_id = ap.ss_aw_parent_id
		 AND ac.ss_aw_child_delete = '0'
		 AND ac.ss_aw_child_username IS NULL
	 JOIN ss_aw_diagonastic_exam de ON de.ss_aw_diagonastic_child_id = ac.ss_aw_child_id
	 JOIN ss_aw_child_course cc ON cc.ss_aw_child_id = ac.ss_aw_child_id
	 JOIN ss_aw_child_last_lesson ll ON ll.ss_aw_lesson_id='$lesson_id' and ll.ss_aw_child_id=ac.ss_aw_child_id
		 AND cc.ss_aw_course_id = '$course_id'
	 WHERE
		 ap.ss_aw_institution = '$institution_id'")->row();
	}
}