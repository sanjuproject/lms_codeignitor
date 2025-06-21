<?php
/**
 * 
 */
class Store_procedure_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_scored_lesson($child_id, $level, $format_type){
		/*$sp_read_user = "CALL get_scored_lesson_list(?,?)";
		$data = array('c_id' => $child_id,'l_id' => $level);
        $query = $this->db->query($sp_read_user, $data);
        if ($query != NULL) {
        	$result = $query->result();
            $query->free_result();
            return $result;	
        }
        else{
        	return false;
        }*/
       
        $where = "FIND_IN_SET('".$level."', ss_aw_lessons_uploaded.ss_aw_course_id)"; 
        $this->db->select('ss_aw_lessons_uploaded.ss_aw_lession_id,ss_aw_lessons_uploaded.ss_aw_lesson_topic,ss_aw_lessons_uploaded.ss_aw_lesson_topic_id,ss_aw_lesson_score.total_question,ss_aw_lesson_score.wright_answers,round((ss_aw_lesson_score.wright_answers/ss_aw_lesson_score.total_question * 100), 2) as percentage');
        $this->db->from('ss_aw_lesson_score');
        $this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lesson_score.lesson_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_format', $format_type);
        $this->db->where('ss_aw_lesson_score.child_id', $child_id);
        $this->db->group_by('ss_aw_lesson_score.lesson_id');
        $this->db->where($where);
        return $this->db->get()->result();

	}

    public function get_scored_lesson_by_multiple_child($child_id, $level, $format_type){
        $where = "FIND_IN_SET('".$level."', ss_aw_lessons_uploaded.ss_aw_course_id)"; 
        $this->db->select('ss_aw_lessons_uploaded.ss_aw_lession_id,ss_aw_lessons_uploaded.ss_aw_lesson_topic,ss_aw_lessons_uploaded.ss_aw_lesson_topic_id');
        $this->db->from('ss_aw_lesson_score');
        $this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_lesson_score.lesson_id');
        $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_format', $format_type);
        $this->db->where_in('ss_aw_lesson_score.child_id', $child_id);
        $this->db->where($where);
        return $this->db->get()->result();
    }

	public function get_inlevel_questions($child_id, $level_type, $lesson_id){
        $query = "(ss_aw_assesment_questions_asked.ss_aw_answers_status = 1 OR ss_aw_assesment_questions_asked.ss_aw_answers_status = 2)";
        $this->db->select('GROUP_CONCAT(ss_aw_assesment_questions_asked.ss_aw_assessment_question_id) as question_id');
        $this->db->from('ss_aw_assesment_questions_asked');
        $this->db->join('ss_aw_assessment_score','ss_aw_assessment_score.exam_code = ss_aw_assesment_questions_asked.ss_aw_assessment_exam_code');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_score.assessment_id');
        $this->db->where('ss_aw_assessment_score.child_id', $child_id);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_asked_level', $level_type);
        $this->db->where($query);
        $this->db->group_by('ss_aw_assessment_score.exam_code');
        return $this->db->get()->result();

	}

	public function get_inlevel_correct_questions($child_id, $level_type, $lesson_id){
        $this->db->select('GROUP_CONCAT(ss_aw_assesment_questions_asked.ss_aw_assessment_question_id) as question_id');
        $this->db->from('ss_aw_assesment_questions_asked');
        $this->db->join('ss_aw_assessment_score','ss_aw_assessment_score.exam_code = ss_aw_assesment_questions_asked.ss_aw_assessment_exam_code');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_score.assessment_id');
        $this->db->where('ss_aw_assessment_score.child_id', $child_id);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_asked_level', $level_type);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_answers_status', 1);
        $this->db->group_by('ss_aw_assessment_score.exam_code');
        return $this->db->get()->result();
    }

    public function getassessmentskipno($child_id, $level_type, $topic_id){
        $this->db->where('ss_aw_log_answer_status', 3);
        $this->db->where('ss_aw_log_level', $level_type);
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_topic_id', $topic_id);
        return $this->db->get('ss_aw_assessment_exam_log')->num_rows();
    }

    public function getreviewassessmentskipno($child_id, $level_type, $topic_id){
        $this->db->where('ss_aw_log_answer_status', 3);
        $this->db->where('ss_aw_log_level !=', $level_type);
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_topic_id', $topic_id);
        return $this->db->get('ss_aw_assessment_exam_log')->num_rows(); 
    }

    public function get_nxtlevel_questions($child_id, $level_type, $lesson_id){
    	$query = "(ss_aw_assesment_questions_asked.ss_aw_answers_status = 1 OR ss_aw_assesment_questions_asked.ss_aw_answers_status = 2)";
        $this->db->select('GROUP_CONCAT(ss_aw_assesment_questions_asked.ss_aw_assessment_question_id) as question_id');
        $this->db->from('ss_aw_assesment_questions_asked');
        $this->db->join('ss_aw_assessment_score','ss_aw_assessment_score.exam_code = ss_aw_assesment_questions_asked.ss_aw_assessment_exam_code');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_score.assessment_id');
        $this->db->where('ss_aw_assessment_score.child_id', $child_id);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_asked_level !=', $level_type);
        $this->db->where($query);
        $this->db->group_by('ss_aw_assessment_score.exam_code');
        return $this->db->get()->result();
    }

    public function get_nxtlevel_correct_questions($child_id, $level_type, $lesson_id){
    	$this->db->select('GROUP_CONCAT(ss_aw_assesment_questions_asked.ss_aw_assessment_question_id) as question_id');
        $this->db->from('ss_aw_assesment_questions_asked');
        $this->db->join('ss_aw_assessment_score','ss_aw_assessment_score.exam_code = ss_aw_assesment_questions_asked.ss_aw_assessment_exam_code');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_score.assessment_id');
        $this->db->where('ss_aw_assessment_score.child_id', $child_id);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_asked_level !=', $level_type);
        $this->db->where('ss_aw_assesment_questions_asked.ss_aw_answers_status', 1);
        $this->db->group_by('ss_aw_assessment_score.exam_code');
        return $this->db->get()->result();
    }

    public function get_review_all_question($topic_id, $lesson_id, $child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_lesson_quiz_ans');
        $this->db->join('ss_aw_lessons','ss_aw_lessons.ss_aw_lesson_details = ss_aw_lesson_quiz_ans.ss_aw_question');
        $this->db->where('ss_aw_lessons.ss_aw_lesson_format', 'Multiple');
        $this->db->where('ss_aw_lessons.ss_aw_lesson_topic', $topic_id);
        $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_child_id', $child_id);
        return $this->db->get()->num_rows();
    }

    public function get_review_correct_question($topic_id, $lesson_id, $child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_lesson_quiz_ans');
        $this->db->join('ss_aw_lessons','ss_aw_lessons.ss_aw_lesson_details = ss_aw_lesson_quiz_ans.ss_aw_question');
        $this->db->where('ss_aw_lessons.ss_aw_lesson_format', 'Multiple');
        $this->db->where('ss_aw_lessons.ss_aw_lesson_topic', $topic_id);
        $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_lesson_quiz_ans.ss_aw_answer_status', 1);
        return $this->db->get()->num_rows();
    }

    public function get_assessment_review_all_question($topic_id, $lesson_id, $child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->join('ss_aw_assisment_diagnostic', 'ss_aw_assisment_diagnostic.ss_aw_question = ss_aw_assesment_multiple_question_answer.ss_aw_question');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assisment_diagnostic.ss_aw_question_topic_id', $topic_id);
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
        return $this->db->get()->num_rows();
    }

    public function get_assessment_review_correct_question($topic_id, $lesson_id, $child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->join('ss_aw_assisment_diagnostic', 'ss_aw_assisment_diagnostic.ss_aw_question = ss_aw_assesment_multiple_question_answer.ss_aw_question');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assisment_diagnostic.ss_aw_uploaded_record_id');
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_answers_status', 1); 
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assisment_diagnostic.ss_aw_question_topic_id', $topic_id);
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
        return $this->db->get()->num_rows();
    }

    public function get_diagnostic_asked_question($child_id){
        $query = "(ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status = 1 OR ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status = 2)";
        $this->db->select('*');
        $this->db->from('ss_aw_diagnonstic_questions_asked');
        $this->db->join('ss_aw_diagonastic_exam_log','ss_aw_diagnonstic_questions_asked.ss_aw_diagonastic_exam_code = ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_exam_code');
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where($query);
        return $this->db->get()->num_rows();
    }

    public function get_diagnostic_correct_question($child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_diagnonstic_questions_asked');
        $this->db->join('ss_aw_diagonastic_exam_log','ss_aw_diagnonstic_questions_asked.ss_aw_diagonastic_exam_code = ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_exam_code');
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_diagonastic_exam_log.ss_aw_diagonastic_log_answer_status', 1);
        return $this->db->get()->num_rows();
    }

    public function store_lesson_assessment_score($data){
        $sp_read_user = "CALL store_lesson_assessment_score(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $store_data = array('ss_aw_child_id' => $data['ss_aw_child_id'],'ss_aw_course_level' => $data['ss_aw_course_level'],'ss_aw_lesson_quiz_asked' => $data['ss_aw_lesson_quiz_asked'],'ss_aw_lesson_quiz_correct' => $data['ss_aw_lesson_quiz_correct'],'ss_aw_lesson_quiz_correct_percentage' => $data['ss_aw_lesson_quiz_correct_percentage'],'ss_aw_lesson_topic' => $data['ss_aw_lesson_topic'],'ss_aw_assessment_in_level_asked' => $data['ss_aw_assessment_in_level_asked'],'ss_aw_assessment_in_level_correct' => $data['ss_aw_assessment_in_level_correct'],'ss_aw_assessment_in_level_actual_score' => $data['ss_aw_assessment_in_level_actual_score'],'ss_aw_assessment_in_level_potential_score' => $data['ss_aw_assessment_in_level_potential_score'],'ss_aw_assessment_in_level_score' => $data['ss_aw_assessment_in_level_score'],'ss_aw_assessment_next_level_asked' => $data['ss_aw_assessment_next_level_asked'],'ss_aw_assessment_next_level_correct' => $data['ss_aw_assessment_next_level_correct'],'ss_aw_assessment_next_level_actual_score' => $data['ss_aw_assessment_next_level_actual_score'],'ss_aw_assessment_next_level_potential_score' => $data['ss_aw_assessment_next_level_potential_score'],'ss_aw_assessment_next_level_score' => $data['ss_aw_assessment_next_level_score'],'ss_aw_review_correct' => $data['ss_aw_review_correct'],'ss_aw_review_asked' => $data['ss_aw_review_asked'],'ss_aw_review_correct_percentage' => $data['ss_aw_review_correct_percentage'],'ss_aw_combine_correct' => $data['ss_aw_combine_correct']);
        $query = $this->db->query($sp_read_user, $store_data);
        echo $this->db->last_query();
        die();
        echo $query;
        die();
    }

    //confidence score queries
    public function getallcompletelessonresult($child_id, $level, $format_type = ""){
        $this->db->select('ss_aw_child_last_lesson.*,ss_aw_lessons_uploaded.ss_aw_lesson_topic_id,ss_aw_lessons_uploaded.ss_aw_lesson_topic');
        $this->db->from('ss_aw_child_last_lesson');
        $this->db->join('ss_aw_lessons_uploaded','ss_aw_lessons_uploaded.ss_aw_lession_id = ss_aw_child_last_lesson.ss_aw_lesson_id');
        $this->db->where('ss_aw_child_last_lesson.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_child_last_lesson.ss_aw_lesson_level', $level);
        $this->db->where('ss_aw_child_last_lesson.ss_aw_lesson_status', 2);
        if (!empty($format_type)) {
            $this->db->where('ss_aw_lessons_uploaded.ss_aw_lesson_format', $format_type);
        }
        $this->db->order_by('ss_aw_child_last_lesson.ss_aw_las_lesson_id','asc');
        return $this->db->get()->result();
    }

    public function getassessmentanswertiming($topic_id, $question_type){
        $this->db->select('SUM(ss_aw_seconds_to_start_answer_question) as begin_to_answer');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->where('ss_aw_question_type', $question_type);
        $this->db->where('ss_aw_topic_id', $topic_id);
        return $this->db->get()->result();
    }

    public function getassessmentformatoneanswertiming($topic_id, $question_type){
        $this->db->select('SUM(ss_aw_log_start_answer_time) as begin_to_answer');
        $this->db->from('ss_aw_assessment_exam_log');
        $this->db->where('ss_aw_log_question_type', $question_type);
        $this->db->where('ss_aw_log_topic_id', $topic_id);
        return $this->db->get()->result();
    }

    public function store_assessment_review_answer_timing($data){
        $this->db->insert('ss_aw_assessment_review_answer_timing', $data);
        return $this->db->insert_id();
    }

    public function store_lesson_assessment_confidence($data){
        $this->db->insert('ss_aw_lesson_assessment_confidence', $data);
        return $this->db->insert_id();
    }

    public function store_total_skip_back_click_details($data){
        $this->db->insert('ss_aw_lesson_assessment_total_skip_back_click_details', $data);
        return $this->db->insert_id();
    }

    public function store_total_assessment_review_answer_timing($data){
        $this->db->insert('ss_aw_total_assessment_review_answer_timing', $data);
        return $this->db->insert_id();
    }

    public function get_total_combine_score($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_lesson_assessment_total_skip_back_click_details')->result();
    }

    public function addgrouptotal($data){
        $this->db->insert('ss_aw_group_score', $data);
        return $this->db->insert_id();
    }

    public function getscoreofgroup($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_group_score')->result();
    }

    public function getquestioncompletetime($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_total_assessment_review_answer_timing')->result();
    }

    public function multipleassessmentwronganswerno($child_id, $level, $lesson_id){
        $this->db->select('*');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assesment_multiple_question_answer.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_answers_status', 3);
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_level', $level);
        return $this->db->get()->num_rows();
    }

    public function addmultipleformatscore($data){
        $this->db->insert('ss_aw_multiple_format_score', $data);
        return $this->db->insert_id();
    }

    public function getlessonskipno($child_id, $level, $lesson_id){
        $this->db->where('ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_answer_status', 3);
        return $this->db->get('ss_aw_lesson_quiz_ans')->num_rows();
    }

    public function getallcoursecompletestudent(){
        $this->db->where('ss_aw_course_status', 2);
        return $this->db->get('ss_aw_child_course')->result();
    }

    public function getalllessonaskedquestion($lesson_id, $child_id){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_lesson_id', $lesson_id);
        return $this->db->get('ss_aw_lesson_quiz_ans')->num_rows();
    }

    public function getalllessoncorrectquestionanswer($lesson_id, $child_id){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_lesson_id', $lesson_id);
        $this->db->where('ss_aw_answer_status', 1);
        return $this->db->get('ss_aw_lesson_quiz_ans')->num_rows();
    }

    public function getallassessmentasked($lesson_id, $child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assesment_multiple_question_answer.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        return $this->db->get()->num_rows();
    }

    public function getallassessmentcorrect($lesson_id, $child_id){
        $this->db->select('*');
        $this->db->from('ss_aw_assesment_multiple_question_answer');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assesment_multiple_question_answer.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_assesment_multiple_question_answer.ss_aw_answers_status', 1);
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_lesson_id', $lesson_id);
        return $this->db->get()->num_rows();
    }

    public function storelessonassessmentscore($data){
        $this->db->insert('ss_aw_format_two_lesson_assessment_score', $data);
        return $this->db->insert_id();
    }

    public function getformattwototallessonassessmentrecord($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $response = $this->db->get('ss_aw_format_two_lesson_assessment_score')->num_rows();
        if ($response > 0) {
            $this->db->select('SUM(ss_aw_asked) as total_asked, SUM(ss_aw_correct) as total_correct');
            $this->db->from('ss_aw_format_two_lesson_assessment_score');
            $this->db->where('ss_aw_child_id', $child_id);
            $this->db->where('ss_aw_level', $level);
            return $this->db->get()->result();
        }
        else
        {
            return false;
        }
    }

    public function store_lesson_assessment_format_two_total_score($data){
        $this->db->insert('ss_aw_format_two_lesson_assessment_total_score', $data);
        return $this->db->insert_id();
    }

    public function getlessonassessmentscoreformatone($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_course_level', $level);
        return $this->db->get('ss_aw_lesson_assessment_score')->result();
    }

    public function getlessonassessmentformattwo($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_format_two_lesson_assessment_score')->result();
    }

    public function getlessonassessmentformattwototal($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_format_two_lesson_assessment_total_score')->result();
    }

    public function getdiagnosticassessmentscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->order_by('ss_aw_id','desc');
        $this->db->limit(1);
        return $this->db->get('ss_aw_diagnostic_review_score')->result();
    }

    public function getallcompletecoursestudentbylevel($level){
        $this->db->distinct('ss_aw_child_id');
        $this->db->where('ss_aw_course_status', 2);
        $this->db->where('ss_aw_course_id', $level);
        return $this->db->get('ss_aw_child_course')->result();
    }

    public function getlessonassessmenttotalscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_course_level', $level);
        return $this->db->get('ss_aw_lesson_assessment_total_score')->result();
    }

    public function getreadalongbylevel($level){
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_readalongs_upload')->result();
    }

    public function getcompletedreadalongs($level, $child_id){
        $this->db->select('ss_aw_readalongs_upload.ss_aw_title,ss_aw_readalongs_upload.ss_aw_id');
        $this->db->from('ss_aw_last_readalong');
        $this->db->join('ss_aw_readalongs_upload','ss_aw_readalongs_upload.ss_aw_id = ss_aw_last_readalong.ss_aw_readalong_id');
        $this->db->where('ss_aw_last_readalong.ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_readalongs_upload.ss_aw_level', $level);
        return $this->db->get()->result();
    }

    public function getallaskedquestion($readalong_id, $child_id){
        $this->db->where('ss_aw_readalong_id', $readalong_id);
        $this->db->where('ss_aw_child_id', $child_id);
        return $this->db->get('ss_aw_readalong_quiz_ans')->result();
    }

    public function getallcorrectquestion($readalong_id, $child_id){
        $this->db->where('ss_aw_readalong_id', $readalong_id);
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_quiz_right_wrong', 1);
        return $this->db->get('ss_aw_readalong_quiz_ans')->result();
    }

    public function store_readalong_scoring_data($data){
        $this->db->insert('ss_aw_readalong_score', $data);
        return $this->db->insert_id();
    }

    public function get_readalong_scoring($child_id, $level){
        $this->db->select('SUM(ss_aw_asked) as total_asked,SUM(ss_aw_correct) as total_correct,');
        $this->db->from('ss_aw_readalong_score');
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get()->result();
    }

    public function store_readalong_total_scoring_data($data){
        $this->db->insert('ss_aw_total_readalong_score', $data);
        return $this->db->insert_id();
    }

    public function getreadalongtotalscore($level_type){
        $this->db->distinct('ss_aw_child_id');
        $this->db->select('ss_aw_correct_percentage');
        $this->db->from('ss_aw_total_readalong_score');
        $this->db->where('ss_aw_level', $level);
        $this->db->order_by('ss_aw_correct_percentage','ASC');
        return $this->db->get()->result();
    }

    public function getreadalongscoring($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_readalong_score')->result();
    }

    public function getreadalongtotalscoring($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_total_readalong_score')->result();
    }

    public function get_inlevel_assessment_questions($child_id, $level_type, $exam_code){
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_level', $level_type);
        $this->db->where('ss_aw_log_exam_code', $exam_code);
        return $this->db->get('ss_aw_assessment_exam_log')->num_rows();
    }

    public function get_inlevel_assessment_correct_questions($child_id, $level_type, $exam_code){
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_level', $level_type);
        $this->db->where('ss_aw_log_exam_code', $exam_code);
        $this->db->where('ss_aw_log_answer_status', 1);
        return $this->db->get('ss_aw_assessment_exam_log')->num_rows();
    }

    public function get_nxtlevel_assessment_questions($child_id, $level_type, $exam_code){
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_level !=', $level_type);
        $this->db->where('ss_aw_log_exam_code', $exam_code);
        return $this->db->get('ss_aw_assessment_exam_log')->num_rows();
    }

    public function get_nxtlevel_assessment_correct_questions($child_id, $level_type, $exam_code){
        $this->db->where('ss_aw_log_child_id', $child_id);
        $this->db->where('ss_aw_log_level !=', $level_type);
        $this->db->where('ss_aw_log_exam_code', $exam_code);
        $this->db->where('ss_aw_log_answer_status', 1);
        return $this->db->get('ss_aw_assessment_exam_log')->num_rows();
    }

    public function getscoringstatements(){
        return $this->db->get('ss_aw_score_statement')->result();
    }

    public function getlessonconfiencescoredetail($level_type){
        $this->db->distinct('ss_aw_child_id');
        $this->db->select('ss_aw_combine_score');
        $this->db->from('ss_aw_lesson_assessment_total_skip_back_click_details');
        $this->db->where('ss_aw_level', $level);
        $this->db->order_by('ss_aw_combine_score','ASC');
        return $this->db->get()->result();
    }

    public function getlanguageconfidencebychildlevel($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        return $this->db->get('ss_aw_lesson_assessment_total_skip_back_click_details')->result();
    }

    public function removeformattwolessonassessmentscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_format_two_lesson_assessment_score');
        return $this->db->affected_rows();
    }

    public function removeformattwolessonassessmenttotalscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_format_two_lesson_assessment_total_score');
        return $this->db->affected_rows();
    }

    public function removelessonassessmentconfidence($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_lesson_assessment_confidence');
        return $this->db->affected_rows();
    }

    public function removebackclickdetails($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_lesson_assessment_total_skip_back_click_details');
        return $this->db->affected_rows();
    }

    public function removelessonassessmentscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_course_level', $level);
        $this->db->delete('ss_aw_lesson_assessment_score');
        return $this->db->affected_rows();
    }

    public function removelessonassessmenttotalscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_course_level', $level);
        $this->db->delete('ss_aw_lesson_assessment_total_score');
        return $this->db->affected_rows();
    }

    public function removemultipleformatskipdetail($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_multiple_format_score');
        return $this->db->affected_rows();
    }

    public function removereadalongscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_readalong_score');
        return $this->db->affected_rows();
    }

    public function removeassessmentanswertimingdetails($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_total_assessment_review_answer_timing');
        return $this->db->affected_rows();
    }

    public function removetotalreadalongscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_total_readalong_score');
        return $this->db->affected_rows();
    }

    public function removedaignosticreviewscore($child_id, $level){
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_level', $level);
        $this->db->delete('ss_aw_diagnostic_review_score');
        return $this->db->affected_rows();
    }

    public function get_group_average_lesson($level){
        $this->db->select('count(*) as lesson_complete_count, ss_aw_child_id');
        $this->db->from('ss_aw_child_last_lesson');
        $this->db->where('ss_aw_lesson_level', $level);
        $this->db->where('ss_aw_lesson_status', 2);
        $this->db->group_by('ss_aw_child_id');
        return $this->db->get()->result();
    }

    public function get_group_average_assessment($child_id = array()){
        $this->db->select('count(*) as assessment_complete_count, ss_aw_child_id');
        $this->db->from('ss_aw_assessment_exam_completed');
        $this->db->where_in('ss_aw_child_id', $child_id);
        $this->db->group_by('ss_aw_child_id');
        return $this->db->get()->result();
    }

    public function get_group_average_readalong($child_id = array()){
        $this->db->select('count(*) as readalong_complete_count, ss_aw_child_id');
        $this->db->from('ss_aw_last_readalong');
        $this->db->where_in('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_status', 1);
        $this->db->group_by('ss_aw_child_id');
        return $this->db->get()->result();
    }

    public function get_group_average_multiple_assessment($child_id = array()){
        $this->db->select('count(*) as assessment_complete_count, ss_aw_assessment_exam_completed.ss_aw_child_id');
        $this->db->from('ss_aw_assessment_exam_completed');
        $this->db->join('ss_aw_assesment_uploaded','ss_aw_assesment_uploaded.ss_aw_assessment_id = ss_aw_assessment_exam_completed.ss_aw_assessment_id');
        $this->db->where('ss_aw_assesment_uploaded.ss_aw_assesment_format','Multiple');
        $this->db->where_in('ss_aw_assessment_exam_completed.ss_aw_child_id', $child_id);
        $this->db->group_by('ss_aw_assessment_exam_completed.ss_aw_child_id');
        return $this->db->get()->result();
    }
}