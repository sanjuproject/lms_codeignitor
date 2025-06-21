<?php
  class Ss_aw_voice_type_matrix_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_voice_type_matrix";
	}

	public function search_byparam($data = array())
	{
		$this->db->select('*');
		$this->db->from($this->table);
		if(!empty($data))
		{
			foreach($data as $key=>$val)
			{
				$this->db->where($key,$val);
			}
		}
		return $this->db->get()->result_array();
	}
	
	public function update_details($data)	
	{
		$this->db->where('ss_aw_test_timing_id',$data['ss_aw_test_timing_id']);
		$this->db->update($this->table, $data );
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
	public function get_recordby_id($id)
	{
		return $this->db->where('ss_aw_id',$id)->get($this->table)->result();
	}

	public function update_data($id, $data)
	{
		if (!empty($data)) {
			$this->db->where('ss_aw_id', $id);
			$this->db->update($this->table, $data);
			return $this->db->affected_rows();	
		}
	}
}
