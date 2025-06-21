<?php
class Diagnostic_exam_last_lesson_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = "diagnostic_exam_last_lesson";
    }

    public function insert_data($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function gettotalcompletenum($child_id = "", $course_start_date = "")
    {
        if (!empty($child_id) && !empty($course_start_date)) {
            $this->db->where('ss_aw_child_id', $child_id);
            $this->db->where('ss_aw_last_lesson_create_date > ', $course_start_date);
            $this->db->where('ss_aw_lesson_status', 2);
            return $this->db->get($this->table)->num_rows();
        } else {
            return 0;
        }
    }
    public function getcompletelessoncount($child_id, $level)
    {
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->where('ss_aw_lesson_level', $level);
        $this->db->where('ss_aw_lesson_status', 2);
        return $this->db->get($this->table)->num_rows();
    }
    public function get_exam_details_by_child($child_id)
    {
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->order_by('ss_aw_las_lesson_id', 'DESC');
        $this->db->limit(1);
        return $this->db->get($this->table)->row();
    }
    public function get_exam_details_by_child_all($child_id)
    {
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->order_by('ss_aw_las_lesson_id', 'DESC');
        // $this->db->limit(1);
        return $this->db->get($this->table)->result();
    }
    public function update_details($data)
    {
        $this->db->where('ss_aw_child_id', $data['ss_aw_child_id']);
        $this->db->where('upload_child_id', $data['upload_child_id']);
        $this->db->set('ss_aw_lesson_level', $data['ss_aw_lesson_level']);
        $this->db->set('ss_aw_lesson_id', $data['ss_aw_lesson_id']);
        $this->db->set('ss_aw_lesson_code', $data['ss_aw_lesson_code']);
        $this->db->set('ss_aw_last_lesson_create_date', $data['last_lesson_create_date']);
        $this->db->update($this->table);
        $count = $this->db->affected_rows();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }
}
