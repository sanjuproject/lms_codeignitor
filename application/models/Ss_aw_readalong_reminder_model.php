<?php
/**
 * 
 */
class Ss_aw_readalong_reminder_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_readalong_reminder_notification";
	}

	public function check_first_reminder($child_id, $lesson_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('lesson_id', $lesson_id);
		$this->db->where('type', 1);
		return $this->db->get($this->table)->result();
	}

	public function check_last_reminder($child_id, $lesson_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('lesson_id', $lesson_id);
		$this->db->where('type', 2);
		$result = $this->db->get($this->table)->num_rows();
		if($result < 3){
			$this->db->where('child_id', $child_id);
			$this->db->where('lesson_id', $lesson_id);
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			return $this->db->get($this->table)->result();
		}
		else
		{
			return false;
		}
	}

	public function check_final_reminder($child_id, $lesson_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('lesson_id', $lesson_id);
		$this->db->where('type', 3);
		return $this->db->get($this->table)->num_rows();
	}

	public function save_notification($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getallfirstreminder($searchval){
		$this->db->where('type', 1);
		$this->db->where('notify_time >=', $searchval);
		return $this->db->get($this->table)->result();
	}

	public function getallfirstemergingreminder($searchval){
		$this->db->where('type', 1);
		$this->db->where('lesson_type', 1);
		$this->db->where('notify_time >=', $searchval);
		return $this->db->get($this->table)->result();
	}

	public function check_emerging_reminder($class_id, $lession_id){
		$this->db->where('child_id', $child_id);
		$this->db->where('lesson_id', $lesson_id);
		$this->db->where('type', 4);
		$result = $this->db->get($this->table)->num_rows();
		if($result < 3){
			$this->db->where('child_id', $child_id);
			$this->db->where('lesson_id', $lesson_id);
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			return $this->db->get($this->table)->result();
		}
		else
		{
			return false;
		}
	}
}