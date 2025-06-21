<?php
  class Ss_aw_child_last_lesson_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_child_last_lesson";
	}

	public function data_insert($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->delete($this->table);
	}
	public function fetch_details($id)
	{
		$this->db->select($this->table.'.*,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id ='.$this->table.'.ss_aw_lesson_id','left');
		return $this->db->where($this->table.'.ss_aw_child_id',$id)->order_by($this->table.'.ss_aw_las_lesson_id','DESC')->get($this->table)->result_array();
	}
	
	/*public function fetch_details_lesson_list($id,$level)
	{
		$this->db->select('*');
		$this->db->where($this->table.'.ss_aw_child_id',$id);
		$this->db->where($this->table.'.ss_aw_lesson_level',$level);
		return $this->db->order_by($this->table.'.ss_aw_las_lesson_id','DESC')->get($this->table)->result_array();
	}*/
	public function fetch_details_lesson_list($id,$level, $ordering = "")
	{
		$this->db->select('*');
		$this->db->where($this->table.'.ss_aw_child_id',$id);
		$this->db->where($this->table.'.ss_aw_lesson_level',$level);
		if (!empty($ordering)) {
			$this->db->order_by($this->table.'.ss_aw_las_lesson_id', $ordering);
		}
		else{
			$this->db->order_by($this->table.'.ss_aw_las_lesson_id','DESC');
		}
		return $this->db->get($this->table)->result_array();
	}
	
	public function update_details($data)	
	{
		$this->db->where('ss_aw_child_id',$data['child_id']);
		$this->db->where('ss_aw_lesson_level',$data['level_id']);
		$this->db->where('ss_aw_lesson_id',$data['lesson_id']);
		$this->db->set('ss_aw_lesson_status',$data['ss_aw_lesson_status']);
		$this->db->set('ss_aw_back_click_count', $data['ss_aw_back_click_count']);
		$this->db->set('ss_aw_last_lesson_modified_date', $data['ss_aw_last_lesson_modified_date']);
		$this->db->update($this->table);
		$count = $this->db->affected_rows();
		if($count==1)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	public function fetch_details_byparam($param, $course_purchase_date = "")
	{
		$this->db->select($this->table.'.*');
		if(!empty($param))
		{
			foreach($param as $key=>$val)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$val);
			}
		}
		if (!empty($course_purchase_date)) {
			$this->db->where($this->table.'.ss_aw_last_lesson_modified_date >', $course_purchase_date);
		}
		$this->db->order_by($this->table.'.ss_aw_las_lesson_id','DESC');
		return $this->db->get($this->table)->result_array();
	}
	
	public function deleterecord_child($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}

	//sayan code start
	public function getallcompletelessonresult($search_date = ""){
		$query = "SELECT * FROM ss_aw_child_last_lesson INNER JOIN (SELECT MAX(ss_aw_las_lesson_id) as id FROM ss_aw_child_last_lesson GROUP BY ss_aw_child_id) last_updates ON last_updates.id = ss_aw_child_last_lesson.ss_aw_las_lesson_id JOIN ss_aw_childs ON ss_aw_childs.ss_aw_child_id = ss_aw_child_last_lesson.ss_aw_child_id WHERE ss_aw_child_last_lesson.ss_aw_lesson_status = 2 AND ss_aw_childs.ss_aw_child_status = 1";
		if (!empty($search_date)) {
			$query .= " AND DATE(ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date) = '".$search_date."'";
		}
		$query = $this->db->query($query);
		return $query->result();
	}

	public function countcompletelesson($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_lesson_level', 1);
		$this->db->where('ss_aw_lesson_status', 2);
		return $this->db->get($this->table)->num_rows();
	}

	public function countcompleteconsolatinglesson($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_lesson_level', 2);
		$this->db->where('ss_aw_lesson_status', 2);
		return $this->db->get($this->table)->num_rows();
	}

	public function getsixthcompletelesson($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_lesson_status', 2);
		$this->db->order_by('ss_aw_las_lesson_id','asc');
		$this->db->limit(1, 5);
		return $this->db->get($this->table)->num_rows();
	}

	public function getcompletelessoncount($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_lesson_level', $level);
		$this->db->where('ss_aw_lesson_status', 2);
		return $this->db->get($this->table)->num_rows();
	}

	public function getcompletelessondetailbyindex($index_num, $child_id, $level){
		$index_num = $index_num - 1;
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_lesson_level', $level);
		$this->db->limit(1, $index_num);
		return $this->db->get($this->table)->result();
	}

	public function getallcompletelessonbychild($param){
		/*$this->db->where('ss_aw_child_id', $param['ss_aw_child_id']);
		$this->db->where('ss_aw_lesson_status', $param['ss_aw_lesson_status']);*/
		if(!empty($param))
		{
			foreach($param as $key=>$val)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$val);
			}
		}
		$this->db->order_by('ss_aw_las_lesson_id','ASC');
		return $this->db->get($this->table)->result_array();
	}

	public function get_all_child(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_child_last_lesson.ss_aw_child_id');
		$this->db->where('ss_aw_child_last_lesson.ss_aw_lesson_status', 2);
		$this->db->order_by('ss_aw_child_last_lesson.ss_aw_las_lesson_id','desc');
		$this->db->group_by('ss_aw_child_last_lesson.ss_aw_child_id');
		return $this->db->get()->result();
	}

	public function gettotalcompletenum($child_id = "", $course_start_date = ""){
		if (!empty($child_id) && !empty($course_start_date)) {
			$this->db->where('ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_last_lesson_create_date > ', $course_start_date);
			$this->db->where('ss_aw_lesson_status', 2);
			return $this->db->get($this->table)->num_rows();
		}
		else
		{
			return 0;
		}
	}

	public function check_student_status($data = array()) {
        $this->db->select('ss_aw_child_last_lesson.ss_aw_last_lesson_create_date as start_date, '
                . 'ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date as end_date,'
                . ' ss_aw_child_last_lesson.ss_aw_child_id as child_id,'
                . 'DATEDIFF(now(),`ss_aw_child_last_lesson`.`ss_aw_last_lesson_modified_date`) date_diff');
        $this->db->from($this->table);
        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_child_last_lesson.ss_aw_child_id');
        $this->db->order_by('ss_aw_child_last_lesson.ss_aw_las_lesson_id', 'desc');
        $this->db->group_by(array('YEAR(ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date)','MONTH(ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date)','ss_aw_child_last_lesson.ss_aw_child_id'));
        $this->db->where('ss_aw_child_last_lesson.ss_aw_lesson_status', 2);
        $this->db->where('ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date >=', report_date_from);
        if (!empty($data)) {
            if (!empty($data['age'])) {
                $ageAry = explode("-", $data['age']);
                $start_age = $ageAry[0];
                $end_age = $ageAry[1];
                $this->db->where('ss_aw_child_age >=', $start_age);
                $this->db->where('ss_aw_child_age <=', $end_age);
            }

            if (!empty($data['enroll_type'])) {
                $this->db->where('ss_aw_child_enroll_type', $data['enroll_type']);
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
        }

        return $this->db->get()->result();
    }

	public function child_enroll_details($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_las_lesson_id','ASC');
		$this->db->limit(1);
		return $this->db->get($this->table)->row();
	}

	public function getallcompletelessonby_child($child_id){
		$this->db->select('ss_aw_child_last_lesson.*, ss_aw_lessons_uploaded.ss_aw_lesson_topic');
		$this->db->from($this->table);
		$this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_child_last_lesson.ss_aw_lesson_id');
		$this->db->where('ss_aw_child_last_lesson.ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_child_last_lesson.ss_aw_las_lesson_id','asc');
		$this->db->group_by('ss_aw_child_last_lesson.ss_aw_lesson_id');
		return $this->db->get()->result();
	}

	public function get_details_by_lesson($lesson_id, $child_id){
		$this->db->where('ss_aw_lesson_id', $lesson_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->row();
	}

	public function get_each_user_last_lesson($data = array()){
		$query = "SELECT *, (SELECT ss_aw_assessment_exam_completed.ss_aw_create_date FROM ss_aw_assessment_exam_completed WHERE ss_aw_assessment_exam_completed.ss_aw_create_date > ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date AND ss_aw_assessment_exam_completed.ss_aw_child_id = ss_aw_child_last_lesson.ss_aw_child_id ORDER BY ss_aw_assessment_exam_completed.ss_aw_id ASC LIMIT 1) as assessment_complete_date FROM ss_aw_child_last_lesson INNER JOIN (SELECT MAX(ss_aw_las_lesson_id) as id FROM ss_aw_child_last_lesson GROUP BY ss_aw_child_id) last_updates ON last_updates.id = ss_aw_child_last_lesson.ss_aw_las_lesson_id";
		if (!empty($data['level'])) {
			$level = $data['level'];
			if ($level == 1) {
				$query .= ' WHERE (SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_child_last_lesson`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 1 or (SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_child_last_lesson`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = 2';	
			}
			else{
				$query .=' WHERE (SELECT `ss_aw_child_course`.`ss_aw_course_id` FROM ss_aw_child_course WHERE `ss_aw_child_course`.`ss_aw_child_id` = `ss_aw_child_last_lesson`.`ss_aw_child_id` ORDER BY `ss_aw_child_course`.`ss_aw_child_course_id` DESC LIMIT 1) = "'.$level.'"';
			}
		}
		return $this->db->query($query)->result();
	}

	public function remove_child_data($child_id){
    	$this->db->where('ss_aw_child_id', $child_id);
    	$this->db->delete($this->table);
  	}

  public function check_student_statuscurrent($data = array()) {
        $this->db->select('ss_aw_child_course.ss_aw_course_status,last_lesson.ss_aw_last_lesson_create_date as start_date, '
                . 'last_lesson.ss_aw_last_lesson_modified_date as end_date,'
                . ' last_lesson.ss_aw_child_id as child_id,'
                . 'DATEDIFF(now(),last_lesson.`ss_aw_last_lesson_modified_date`) date_diff');
      
        $this->db->join('(select * from '.$this->table.' group by `ss_aw_child_last_lesson`.`ss_aw_child_id` order by ss_aw_child_last_lesson.ss_aw_last_lesson_modified_date desc)last_lesson','ss_aw_child_course.ss_aw_child_id = last_lesson.ss_aw_child_id');
        $this->db->from('ss_aw_child_course');
        $this->db->join('ss_aw_childs', '`ss_aw_childs`.`ss_aw_child_id` = last_lesson.`ss_aw_child_id` and ss_aw_childs.ss_aw_child_status="1" and ss_aw_childs.ss_aw_child_delete="0"');
        $this->db->order_by('ss_aw_child_course.ss_aw_child_course_id', 'desc');
        $this->db->group_by(array('YEAR(last_lesson.ss_aw_last_lesson_modified_date)','MONTH(last_lesson.ss_aw_last_lesson_modified_date)','last_lesson.ss_aw_child_id'));
        $this->db->where('ss_aw_child_course.ss_aw_course_status', 1);
        $this->db->where('last_lesson.ss_aw_last_lesson_modified_date >=', report_date_from);
        if (!empty($data)) {
            if (!empty($data['age'])) {
                $ageAry = explode("-", $data['age']);
                $start_age = $ageAry[0];
                $end_age = $ageAry[1];
                $this->db->where('ss_aw_child_age >=', $start_age);
                $this->db->where('ss_aw_child_age <=', $end_age);
            }

            if (!empty($data['enroll_type'])) {
                $this->db->where('ss_aw_child_enroll_type', $data['enroll_type']);
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
        }

        return $this->db->get()->result();
    }

    public function get_last_lesson_for_child($child_id) {
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->order_by('ss_aw_las_lesson_id', 'desc');
        $this->db->limit(1);
        return $this->db->get('ss_aw_child_last_lesson')->result();
    }

    public function update_last_lesson($record_id, $updated_start_time, $updated_end_time) {
        $this->db->where('ss_aw_las_lesson_id', $record_id);
        if (!empty($updated_start_time)) {
            $this->db->set('ss_aw_last_lesson_create_date', $updated_start_time);
        }
        if (!empty($updated_end_time)) {
            $this->db->set('ss_aw_last_lesson_modified_date', $updated_end_time);
        }
        return $this->db->update('ss_aw_child_last_lesson');
    }
}
