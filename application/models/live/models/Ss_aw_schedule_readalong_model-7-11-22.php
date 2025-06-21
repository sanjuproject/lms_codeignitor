<?php
  class Ss_aw_schedule_readalong_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_schedule_readalong";
	}

	public function search_byparam($data = array())
	{
		$this->db->select($this->table.'.*,ss_aw_readalongs_upload.ss_aw_id as readalongid,ss_aw_readalongs_upload.ss_aw_title,
		ss_aw_readalongs_upload.ss_aw_type,ss_aw_readalongs_upload.ss_aw_level,ss_aw_readalongs_upload.ss_aw_topic,
		ss_aw_readalongs_upload.ss_aw_status');
		$this->db->join('ss_aw_readalongs_upload',$this->table.'.ss_aw_readalong_id = ss_aw_readalongs_upload.ss_aw_id','left');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$this->db->where($this->table.'.'.$key,$val);
			}
		}
		return $this->db->get()->result_array();
	}
	
	public function update_details($data)	
	{
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				if($key != 'ss_aw_readalong_status')
				{
					$this->db->where($key,$val);
				}
			}
		}
		$this->db->update($this->table,$data);
		$count = $this->db->affected_rows();
		if($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	public function data_insert($data)	
	{
		$this->db->insert($this->table, $data );
		return $this->db->insert_id();
	}

	public function fetch_record_byid($id)
	{
      return $this->db->where('ss_aw_test_timing_id',$id)->get($this->table)->result();
	}
	public function update_records($id,$timing)
	{
		$this->db->where('ss_aw_test_timing_id',$id)->set('ss_aw_test_timing_value',$timing)->update($this->table);
	}
	
	public function delete_data($data)
	{
		foreach($data as $key=>$val)
			{
				$this->db->where($key,$val);
			}
		$this->db->delete($this->table);
		return 1;
	}

	public function update_read_status($data){
		$this->db->set('ss_aw_read', 1);
		$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
		$this->db->where('ss_aw_readalong_id', $data['ss_aw_readalong_id']);
		$this->db->update($this->table);
	}

	public function getlastassignedrecord($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function update_scheduler($data){
		$this->db->where('ss_aw_id', $data['ss_aw_id']);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function getscheduledreadalongdetail($data){
		$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
		$this->db->where('ss_aw_readalong_id', $data['ss_aw_readalong_id']);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function remove_scheduled_readalong($data){
		$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
		$this->db->where('ss_aw_readalong_id', $data['ss_aw_readalong_id']);
		$this->db->where('ss_aw_read', 0);
		$this->db->limit(1);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function scheduledreadalongdetail($data){
		$this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->result();
	}

	public function cancelscheduledreadalong($child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function checkreadalongcomprehensionstatus($readalong_id, $child_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		return $this->db->get($this->table)->result();
	}

	public function changereadalongcomprehensionstatus($child_id, $readalong_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		$this->db->set('ss_aw_comprehension_read', 1);
		$this->db->update($this->table);
		return $this->db->affected_rows();
	}

	public function increment_readalong_sitting_count($child_id, $readalong_id){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_readalong_id', $readalong_id);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		$result = $this->db->get($this->table)->row();
		if (!empty($result) && $result->ss_aw_readalong_status == 2) {
			$sitting_count = $result->ss_aw_sitting_count + 1;
			$this->db->where('ss_aw_id', $result->ss_aw_id);
			$this->db->set('ss_aw_sitting_count', $sitting_count);
			$this->db->update($this->table);
			return $this->db->affected_rows();
		}
	}

	public function get_readalong_schduled($child_id, $start_date, $end_date){
		$this->db->where('ss_aw_child_id', $child_id);
		$this->db->where('ss_aw_schedule_readalong >=', $start_date);
		$this->db->where('ss_aw_schedule_readalong <=', $end_date);
		$this->db->where('ss_aw_readalong_status', 1);
		$this->db->order_by('ss_aw_id','desc');
		$this->db->limit(1);
		return $this->db->get($this->table)->row();
	}
}
