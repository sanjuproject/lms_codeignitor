<?php

class Cron_report_enroll_current_status_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = "ss_aw_childs";
    }

    public function getAllChildCount($month, $year,$course_type,$course_status='') {
         if ($course_type == 1) {
            $course_type = "1,2";
        }
        $where = "DATE_FORMAT(de.ss_aw_diagonastic_exam_date,'%Y-%m')<=concat('$year','-','$month')";
        $this->db->select('count(*)child_count');
        $this->db->from('ss_aw_childs ac');
        $this->db->where("date_format(de.ss_aw_diagonastic_exam_date,'%Y-%m-%d') >=",report_date_from);
        $this->db->where($where);
        $this->db->join('ss_aw_diagonastic_exam de','de.ss_aw_diagonastic_child_id=ac.ss_aw_child_id');
        $this->db->join('ss_aw_child_course cc','cc.ss_aw_child_id=ac.ss_aw_child_id '
                . 'and FIND_IN_SET(cc.ss_aw_course_id,"' . $course_type . '")<>0');
        if($course_status!=''){
            $this->db->where('cc.ss_aw_course_status', $course_status);
        }
       
        
        $this->db->where('ac.ss_aw_child_status', 1);
        $this->db->where('ac.ss_aw_child_delete', 0);        
        $this->db->group_by(array('ac.ss_aw_child_id'));        
        return $this->db->get()->num_rows();
    }
    public function getAllChildCompletedPTD($month, $year,$course_type,$course_status='') {
         if ($course_type == 1) {
            $course_type = "1,2";
        }
        $where = "DATE_FORMAT(de.ss_aw_diagonastic_exam_date,'%Y-%m')<=concat('$year','-','$month')";
        $this->db->select('count(*)child_count,group_concat(distinct(ac.ss_aw_child_id))child_id');
        $this->db->from('ss_aw_childs ac');
        $this->db->where("date_format(de.ss_aw_diagonastic_exam_date,'%Y-%m-%d') >=",report_date_from);
        $this->db->where($where);
        $this->db->join('ss_aw_diagonastic_exam de','de.ss_aw_diagonastic_child_id=ac.ss_aw_child_id');
        $this->db->join('ss_aw_child_course cc','cc.ss_aw_child_id=ac.ss_aw_child_id '
                . 'and FIND_IN_SET(cc.ss_aw_course_id,"' . $course_type . '")<>0');
        if($course_status!=''){
            $this->db->where('cc.ss_aw_course_status', $course_status);
        }
       
        
        $this->db->where('ac.ss_aw_child_status', 1);
        $this->db->where('ac.ss_aw_child_delete', 0);        
        $this->db->group_by(array('ac.ss_aw_child_id'));        
        return $this->db->get()->row();
    }

    public function getessoncompletenum($month, $year, $course_type) {

        if ($course_type == 1) {
            $course_type = "1,2";
        }
        $this->db->select('count(*)complete_num,group_concat(ac.ss_aw_child_id)child_id');
        $this->db->join('ss_aw_child_course ac','cc.ss_aw_child_id=ac.ss_aw_child_id','left');
        $this->db->from('ss_aw_childs cc');
        $this->db->where('MONTH(ac.ss_aw_child_course_modified_date)', $month);
        $this->db->where('YEAR(ac.ss_aw_child_course_modified_date)', $year);
        $this->db->where('ac.ss_aw_course_status', 2);
        $this->db->where('cc.ss_aw_child_status', 1);
        $this->db->where('cc.ss_aw_child_delete', 0);
        $this->db->where('FIND_IN_SET(ac.ss_aw_course_id,"' . $course_type . '")<>0');
        $this->db->group_by(array('ac.ss_aw_child_id'));
        $this->db->order_by('ac.ss_aw_child_course_id','DESC');
        return $this->db->get()->row();
    }
    public function getessonincompletenum($date, $course_type,$range_type='') {

        if ($course_type == 1) {
            $course_type = "1,2";
        }
        $this->db->select('count(*)complete_num,group_concat(ac.ss_aw_child_id)child_id');
       $this->db->join('ss_aw_child_course ac','cc.ss_aw_child_id=ac.ss_aw_child_id AND FIND_IN_SET(ac.ss_aw_course_id,"' . $course_type . '")<>0');
        $this->db->from('ss_aw_childs cc');
        $this->db->join("(SELECT 
   de.ss_aw_diagonastic_child_id child_id,  
    (case 
    when exam.exam_created !='' && exam.exam_created>last_lesson.ss_aw_last_lesson_modified_date then exam.exam_created
    when last_lesson.ss_aw_last_lesson_modified_date !='' && last_lesson.ss_aw_last_lesson_modified_date>de.ss_aw_diagonastic_exam_date then last_lesson.ss_aw_last_lesson_modified_date
    else de.ss_aw_diagonastic_exam_date 
    end)last_active
FROM
ss_aw_diagonastic_exam de
   left join (select ll.ss_aw_child_id,
   MAX(ll.ss_aw_last_lesson_create_date)ss_aw_last_lesson_create_date,
   MAX(ll.ss_aw_last_lesson_modified_date)ss_aw_last_lesson_modified_date 
   from ss_aw_child_last_lesson ll where date_format(ll.ss_aw_last_lesson_modified_date,'%Y-%m-%d')<='$date'
   GROUP BY ll.ss_aw_child_id ORDER BY ll.ss_aw_las_lesson_id DESC)last_lesson on last_lesson.ss_aw_child_id=de.ss_aw_diagonastic_child_id
        LEFT JOIN
    (SELECT 
        ec.ss_aw_child_id, MAX(ec.ss_aw_create_date) exam_created
    FROM
        ss_aw_assessment_exam_completed ec where date_format(ec.ss_aw_create_date,'%Y-%m-%d')<='$date'
    GROUP BY ec.ss_aw_child_id
    ORDER BY ec.ss_aw_id DESC) exam ON exam.ss_aw_child_id = de.ss_aw_diagonastic_child_id
    where de.ss_aw_diagonastic_child_id!='' and date_format(de.ss_aw_diagonastic_exam_date,'%Y-%m-%d')<='$date'
    group by de.ss_aw_diagonastic_child_id)check_data",'check_data.child_id=ac.ss_aw_child_id');
        
         if ($range_type == 1) {//active
            $this->db->where('DATEDIFF("'.$date.'",`check_data`.`last_active`)<=', 7);
        } elseif ($range_type == 2) {//inactive
            $this->db->where('DATEDIFF("'.$date.'",`check_data`.`last_active`)>', 21);
        } elseif ($range_type == 3) {//deliquent
            $this->db->where('DATEDIFF("'.$date.'",`check_data`.`last_active`)>', 7);
            $this->db->where('DATEDIFF("'.$date.'",`check_data`.`last_active`)<=', 21);
        }
        $this->db->where("date_format(`check_data`.`last_active`,'%Y-%m-%d') >=", report_date_from);
        $this->db->where("date_format(`check_data`.`last_active`,'%Y-%m-%d')<=", $date);
        //$this->db->where('YEAR(ac.ss_aw_child_course_modified_date)<=', $year);
        $this->db->where('ac.ss_aw_course_status', 1);
       
         $this->db->where('cc.ss_aw_child_status', 1);
        $this->db->where('cc.ss_aw_child_delete', 0);
        //$this->db->group_by(array('ac.ss_aw_child_id'));
        $this->db->order_by('ac.ss_aw_child_course_id','DESC');
        return $this->db->get()->row();
    }

    public function Add($table, $data) {
        $result = $this->db->insert($table, $data);
        if (!empty($result)) {
            return $this->db->insert_id();
        }
        return false;
    }
public function getAllEnrollStatus($course_type){
     if ($course_type == 1) {
            $course_type = "1,2";
        }
    $this->db->select('*');
    $this->db->from('cron_report_enroll_current_statu_data csd');
    $this->db->where('FIND_IN_SET(csd.course_id,"' . $course_type . '")<>0');
   return $this->db->get()->result_array();
}
}
