<?php
  class Ss_aw_last_readalong_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_last_readalong";
	}

	public function data_insert($data)
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}
		
	public function update_record($datary)
	{
		
		$this->db->where('ss_aw_id', $datary['ss_aw_id']);
	
		$this->db->update($this->table,$datary);
	}
	
	public function search_data_by_param($search_data = array())
	{

		if($search_data!="")
		{
			foreach($search_data as $key=>$value)
			{
				$this->db->where('`'.$this->table.'.'.'`'.$key.'`',$value);
			}
		}
		return $this->db->get($this->table)->result_array();
	}

	public function gettotalcompletenum($child_id = "", $course = ""){
		if (!empty($child_id) && !empty($course)) {
			if ($course == 1) {
				$level = "E";
			}
			elseif ($course == 2) {
				$level = "C";
			}
			else
			{
				$level = "A";
			}
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->join('ss_aw_readalongs_upload','ss_aw_readalongs_upload.ss_aw_id = ss_aw_last_readalong.ss_aw_readalong_id');
			$this->db->where('ss_aw_readalongs_upload.ss_aw_level', $level);
			$this->db->where('ss_aw_last_readalong.ss_aw_child_id', $child_id);
			$this->db->where('ss_aw_last_readalong.ss_aw_status', 1);
			return $this->db->get()->num_rows();
		}
	}

	public function check_readalong_completion($readalong_id, $child_id){
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		$this->db->where('ss_aw_child_id', $child_id);
		return $this->db->get($this->table)->result();
	}
	
	public function remove_child_data($child_id){
    $this->db->where('ss_aw_child_id', $child_id);
    $this->db->delete($this->table);
  }

  public function get_complete_readalong_details($child_id, $start_date, $end_date, $finish_record_id = array()){
  	$this->db->select($this->table.'.*, (select count(*) from ss_aw_readalong_quiz_ans where ss_aw_readalong_quiz_ans.ss_aw_child_id = '.$this->table.'.ss_aw_child_id and ss_aw_readalong_quiz_ans.ss_aw_readalong_id = '.$this->table.'.ss_aw_readalong_id) as total_question, (select count(*) from ss_aw_readalong_quiz_ans where ss_aw_readalong_quiz_ans.ss_aw_child_id = '.$this->table.'.ss_aw_child_id and ss_aw_readalong_quiz_ans.ss_aw_quiz_right_wrong = 1 and ss_aw_readalong_quiz_ans.ss_aw_readalong_id = '.$this->table.'.ss_aw_readalong_id) as wright_question');
  	$this->db->from($this->table);
		$this->db->where($this->table.'.ss_aw_child_id', $child_id);
		$this->db->where($this->table.'.ss_aw_create_date >=', $start_date);
		$this->db->where($this->table.'.ss_aw_create_date <=', $end_date);
		$this->db->where($this->table.'.ss_aw_status', 1);
		if (!empty($finish_record_id)) {
			$this->db->where_not_in($this->table.'.ss_aw_id', $finish_record_id);
		}
		return $this->db->get()->row();
	}

}
