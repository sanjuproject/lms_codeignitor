<?php

/**
 * 
 */
class Ss_aw_course_completion_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = "ss_aw_course_completion";
    }

    public function insert_data($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_data($data, $id) {
        $this->db->update($this->table, $data, "ss_aw_id='" . $id . "'");
        return $this->db->affected_rows();
    }

    public function getcoursecompletionRow($child_id, $level_id, $is_completed) {
        $this->db->select("acc.*");
        $this->db->from($this->table . ' acc');
        $this->db->where("acc.ss_aw_child_id", $child_id);
        $this->db->where("acc.ss_aw_course_id", $level_id);
        $this->db->where("acc.ss_aw_is_completed", $is_completed);
        return $this->db->get()->row();
    }

    public function checkcoursecompletionRow($child_id, $level_id) {
        $this->db->select("acc.*");
        $this->db->from($this->table . ' acc');
        $this->db->where("acc.ss_aw_child_id", $child_id);
        $this->db->where("acc.ss_aw_course_id", $level_id);
        $this->db->where("acc.ss_aw_is_completed >", 0);
        return $this->db->get()->row();
    }

    public function getcoursecompletionAll() {
        $this->db->select("acc.*");
        $this->db->from($this->table . ' acc');
        $this->db->where("acc.ss_aw_is_completed", 1);
        $this->db->where("DATEDIFF(NOW(), acc.ss_aw_create_date)>= 30");
        return $this->db->get()->result();
    }

}
