<?php

class Ss_aw_challange_log_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

// Your own constructor code
		$this->table = "ss_aw_challange_log";
	}

//Add: upload Quiz Challange
	public function answer_log_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}

	public function update_log($data, $id){
		$this->db->where('ss_aw_challange_log_id', $id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function get_latherboard_list($challange_id){
		// $sunday = strtotime("last sunday");
		// $sunday = date('w', $sunday)==date('w') ? $sunday+7*86400 : $sunday;
		// $saturday = strtotime(date("Y-m-d",$sunday)." +6 days");
		// $start_week = date("Y-m-d",$sunday);
		// $end_week = date("Y-m-d",$saturday);

		$this->db->where('ss_aw_participant_name !=','');
		$this->db->where('ss_aw_challange_status', 1);
		$this->db->where('ss_aw_challange_id', $challange_id);
		// $this->db->where('DATE(submit_date) >=', $start_week);
		// $this->db->where('DATE(submit_date) <=', $end_week);
		return $this->db->get($this->table)->result();
	}

	public function get_last_week_winners($challange_id){

		

		// $sunday = strtotime("last sunday");
		// $sunday = date('w', $sunday)==date('w') ? $sunday+7*86400 : $sunday;
		// $saturday = strtotime(date("Y-m-d",$sunday)." +6 days");
		// $start_week = date("Y-m-d",$sunday);
		// $end_week = date("Y-m-d",$saturday);

		$this->db->where('ss_aw_participant_name !=','');
		$this->db->where('ss_aw_challange_status', 1);
		$this->db->where('ss_aw_challange_id', $challange_id);
		$this->db->order_by('ss_aw_challange_log_id', 'asc');
		// $this->db->where('DATE(submit_date) >=', $start_week);
		// $this->db->where('DATE(submit_date) <=', $end_week);
		$this->db->limit(10);
		return $this->db->get($this->table)->result();
	}
}
