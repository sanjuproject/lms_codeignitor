<?php
class Common_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getAllcourses($is_champion = true)
    {
        $this->db->select("*");
        $this->db->from("ss_aw_courses ac");
        $this->db->where("ac.ss_aw_flag", '1');
        if (!$is_champion) {
            $this->db->where("ac.ss_aw_course_id !=", '3');
        }
        $this->db->where("ac.ss_aw_course_status", '0');
        return $this->db->get()->result();
    }
}
