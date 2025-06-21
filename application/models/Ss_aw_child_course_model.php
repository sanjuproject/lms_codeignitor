<?php
  class Ss_aw_child_course_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_child_course";
	}

	public function add_child($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	public function deleterecord($id)
	{
		$this->db->where('ss_aw_parent_id', $id);
		$this->db->delete($this->table);
	}
	
	public function delete_single_child($id)
	{
		$this->db->where('ss_aw_child_temp_id', $id);
		$this->db->delete($this->table);
	}
	
	public function get_details($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.ss_aw_child_id',$id);
		$this->db->order_by('ss_aw_child_course_id','ASC');
		return $this->db->get()->result_array();
	}
	
		public function data_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
	
	public function deleterecord_child($id)
	{
		$this->db->where('ss_aw_child_id', $id);
		$this->db->delete($this->table);
	}
	
	public function updaterecord_child($id,$data)
	{
		$this->db->where('ss_aw_child_id', $id);
		$response = $this->db->update($this->table,$data);
		return $response;
	}

	//sayan code

	public function getlastemergingcorsebychildid($child_id){
		$this->db->where('ss_aw_course_id', 1);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_child_course_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result_array();
	}

	public function updatecourseEtoC($course_id, $data){
		$this->db->where('ss_aw_child_course_id', $course_id);
		$response = $this->db->update($this->table, $data);
		if ($response) {
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getlastconsolatingcorsebychildid($child_id){
		$this->db->where('ss_aw_course_id', 2);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_child_course_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result_array();
	}

	public function removecoursewithpaymentdetail($child_id, $level){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_course_id', $level);
		$this->db->delete($this->table);

		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_selected_course_id', $level);
		$response = $this->db->get('ss_aw_purchase_courses')->result();

		if (!empty($response)) {
			$transaction_id = $response[0]->ss_aw_transaction_id;
			$this->db->where('ss_aw_purchase_course_id', $response[0]->ss_aw_purchase_course_id);
			$this->db->delete('ss_aw_purchase_courses');

			$this->db->where('ss_aw_transaction_id', $transaction_id);
			$this->db->delete('ss_aw_payment_details');
		}
	}

	public function getcompletechildparentdetail($compared_date){
		$this->db->distinct('ss_aw_parents.ss_aw_parent_id');
		$this->db->select('ss_aw_parents.ss_aw_parent_id,ss_aw_parents.ss_aw_parent_full_name, ss_aw_parents.ss_aw_parent_email');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id');
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('ss_aw_child_course.ss_aw_course_id !=', 3);
		$this->db->where('ss_aw_course_status', 2);
		$this->db->where('DATE(ss_aw_child_course_modified_date) <=', $compared_date);
		return $this->db->get()->result();
	}

	public function getlastconsolidatedcorsebychildid($child_id){
		$this->db->where('ss_aw_course_id', 2);
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_child_course_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result_array();
	}

	public function getchildstobeginprogram($search_date = ""){
		$this->db->select('ss_aw_child_course.ss_aw_course_id,ss_aw_child_course.ss_aw_child_course_create_date as course_purchase_date,ss_aw_childs.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id');
		if (!empty($search_date)) {
			$this->db->where('DATE(ss_aw_child_course.ss_aw_child_course_create_date) >=', $search_date);	
		}
		$this->db->where('(select count(*) from ss_aw_child_last_lesson where ss_aw_child_last_lesson.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id) = 0');
		$this->db->where('(select count(*) from ss_aw_diagonastic_exam where ss_aw_diagonastic_exam.ss_aw_diagonastic_child_id = ss_aw_child_course.ss_aw_child_id) > 0');
		return $this->db->get()->result();
	}

	public function get_details_by_child_course($child_id, $course_id){
		$this->db->where('ss_aw_course_id', $course_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->result();
	}

	public function getchildstogeneratescorecard(){
		$current_month = date('m');
		$this->db->select('ss_aw_child_course.ss_aw_course_id,ss_aw_child_course.ss_aw_child_course_create_date as course_purchase_date,ss_aw_childs.*');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id');
		$this->db->where('((select count(*) from ss_aw_child_last_lesson where ss_aw_child_last_lesson.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id and ss_aw_child_last_lesson.ss_aw_lesson_status = 2) % 4) = 0');
		$this->db->where('((select count(*) from ss_aw_assessment_exam_completed where ss_aw_assessment_exam_completed.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id) % 4) = 0');
		$this->db->where('(select count(*) from ss_aw_monthly_scorecard_notification where ss_aw_monthly_scorecard_notification.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id and MONTH(ss_aw_created_at) = '.$current_month.') = 0');
		return $this->db->get()->result();
	}

	public function get_complete_student_parent_details(){
		$this->db->select('ss_aw_parents.ss_aw_parent_id,ss_aw_parents.ss_aw_parent_full_name, ss_aw_parents.ss_aw_parent_email,ss_aw_parents.ss_aw_device_token as parent_token,ss_aw_child_course.*,ss_aw_childs.ss_aw_child_nick_name,ss_aw_childs.ss_aw_child_gender,ss_aw_childs.ss_aw_device_token as child_token, ss_aw_childs.ss_aw_child_username');
		$this->db->from($this->table);
		$this->db->join('ss_aw_childs','ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id');
		$this->db->join('ss_aw_parents','ss_aw_parents.ss_aw_parent_id = ss_aw_childs.ss_aw_parent_id');
		$this->db->where('ss_aw_child_course.ss_aw_course_status', 2);
		return $this->db->get()->result();
	}

	public function check_course_complete_or_not($child_id, $course_id){
		$this->db->where('ss_aw_course_status', 2);
		$this->db->where('ss_aw_course_id', $course_id);
		$this->db->where('ss_aw_child_id', $child_id);
		$response = $this->db->get($this->table)->num_rows();
		if ($response > 0) {
			return 1;
		}
		else{
			return 0;
		}
	}

	public function get_registration_by_date($search_date, $type){
		$this->db->where('ss_aw_course_payemnt_type', $type);
		$this->db->where('DATE(ss_aw_child_course_create_date)', $search_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_by_date_range($search_date, $current_date, $type){
		$this->db->where('ss_aw_course_payemnt_type', $type);
		$this->db->where('DATE(ss_aw_child_course_create_date) >', $search_date);
		$this->db->where('DATE(ss_aw_child_course_create_date) <=', $current_date);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_before_last_seven_days_of_current_date($search_date, $type){
		$this->db->where('ss_aw_course_payemnt_type', $type);
		$this->db->where('DATE(ss_aw_child_course_create_date) <', $search_date);
		$this->db->where('DATE(ss_aw_child_course_create_date) >=', '2022-08-01');
		return $this->db->get($this->table)->num_rows();
	}

	public function get_registration_course_by_date($search_date, $type, $course_id){
		$this->db->where('ss_aw_course_payemnt_type', $type);
		$this->db->where('DATE(ss_aw_child_course_create_date) <=', $search_date);
		$this->db->where('DATE(ss_aw_child_course_create_date) >=', '2022-08-01');
		$this->db->where('ss_aw_course_id', $course_id);
		return $this->db->get($this->table)->num_rows();
	}

	public function get_total_childs_up_to_date($current_date, $type){
		$this->db->where('ss_aw_course_payemnt_type', $type);
		$this->db->where('DATE(ss_aw_child_course_create_date) <=', $current_date);
		$this->db->where('DATE(ss_aw_child_course_create_date) >=', '2022-08-01');
		return $this->db->get($this->table)->num_rows();
	}

	public function get_child_complete_course($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.ss_aw_child_id',$id);
		$this->db->where($this->table.'.ss_aw_course_status',2);
		$this->db->order_by('ss_aw_child_course_id','ASC');
		return $this->db->get()->result_array();
	}

	public function getstuentsbycorsetype($course_type,$age_level='') {
        $this->db->select('GROUP_CONCAT(ss_aw_childs.ss_aw_child_id) as child_id');
        $this->db->from($this->table);
        $this->db->join('ss_aw_childs', 'ss_aw_childs.ss_aw_child_id = ss_aw_child_course.ss_aw_child_id');
        $this->db->where('ss_aw_childs.ss_aw_child_delete','0');
        $this->db->where('ss_aw_childs.ss_aw_child_status', '1');
        $this->db->where('ss_aw_child_course.ss_aw_child_course_create_date>=', report_date_from);
        
          if($age_level==1){
            $this->db->where('TIMESTAMPDIFF(YEAR, DATE(ss_aw_childs.ss_aw_child_dob), DATE(ss_aw_child_course.ss_aw_child_course_create_date))<',13);
        }elseif($age_level==2){
            $this->db->where('TIMESTAMPDIFF(YEAR, DATE(ss_aw_childs.ss_aw_child_dob), DATE(ss_aw_child_course.ss_aw_child_course_create_date))>=',13);
        }
        if ($course_type == 1) {
            $this->db->where('(ss_aw_child_course.ss_aw_course_id = 1 or ss_aw_child_course.ss_aw_course_id = 2)');
        } else {
            $this->db->where('ss_aw_child_course.ss_aw_course_id', $course_type);
        }
      
        return $this->db->get()->row();
    }

	public function get_institutional_enroll_count($child_ary = array()){
		if (!empty($child_ary)) {
			$this->db->where_in('ss_aw_child_id', $child_ary);
			return $this->db->get($this->table)->num_rows();	
		}
		else{
			return 0;
		}
		
	}

	public function checkchildCourse($childid,$course){
       if($course==1){
           $this->db->where('ss_aw_child_course.ss_aw_course_id = 1 or ss_aw_child_course.ss_aw_course_id = 2');
       }else{
           $this->db->where('ss_aw_child_course.ss_aw_course_id = "'.$course.'"');
       }
       $this->db->where('ss_aw_child_id="'.$childid.'"');
        return $this->db->get($this->table)->num_rows();
    }

    public function getcoursedetailsaccordingchildid($childid) {
        $this->db->where('ss_aw_child_id="' . $childid . '"');
        $this->db->order_by('ss_aw_child_course_id','DESC');
        return $this->db->get($this->table)->row();
    }

    public function get_completed_courses($child_id){
    	$this->db->where('ss_aw_course_status', 2);
    	$this->db->where('ss_aw_child_id', $child_id);
    	$this->db->order_by('ss_aw_child_course_id','desc');
    	return $this->db->get($this->table)->result();
    }

    public function get_latest_course($child_id){
    	$this->db->where('ss_aw_child_id', $child_id);
    	$this->db->order_by('ss_aw_child_course_id', 'desc');
    	$this->db->limit(1);
    	return $this->db->get($this->table)->row();
    }
}
