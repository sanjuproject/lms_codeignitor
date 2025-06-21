<?php
class Diagnostic_exam_log_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = "diagonastic_exam_log";
    }


    public function get_diagnostic_exam_attempt_details($exam_code,$child_id)
    {
        $this->db->select($this->table . ".ss_aw_diagonastic_log_exam_code, (select count(*) from diagonastic_exam_log sa where sa.ss_aw_diagonastic_log_child_id ='". $child_id."') as total_attempt");
        $this->db->from($this->table);
        $this->db->where('ss_aw_diagonastic_log_child_id', $child_id);
        $this->db->where('ss_aw_diagonastic_log_exam_code', $exam_code);
        $this->db->order_by('ss_aw_diagonastic_log_id', 'desc');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
}