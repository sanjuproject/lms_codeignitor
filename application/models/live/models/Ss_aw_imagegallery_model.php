<?php
  class Ss_aw_imagegallery_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = "ss_aw_imagegallery";
	}
  // public function inser_record($data)
  // {
  // 	for($i=0;$i<sizeof($data);$i++)
  // 	{
  // 		$this->db->insert($this->table,$data[$i]);
  // 	}
  // }

  public function number_of_records()
	{		
	   return $this->db->get($this->table)->num_rows();		
	}
  public function fetch_all_record($limit,$start)
  {
    $this->db->order_by("ss_aw_image_id", "desc");
  	$this->db->limit($limit,$start);	
    return $this->db->get($this->table)->result();
  }
  public function delete_record($id)
  {
  	$this->db->where('ss_aw_image_id',$id)->delete($this->table);
  }

  public function insert_record($data)
  {
    $this->db->insert($this->table,$data);    
  }	

 } 