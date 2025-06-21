

<?php
/**
 * 
 */
class Diagnonstic_questions_asked_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "diagnonstic_questions_asked";
    }
    public function insert_record($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function get_diagnostic_exam_attempt_details($child_id)
    {
        $this->db->select($this->table . '.ss_aw_diagonastic_exam_code, (select count(*) from diagnonstic_questions_asked sa where sa.ss_aw_child_id = diagnonstic_questions_asked.ss_aw_child_id) as total_attempt');
        $this->db->from($this->table);
        $this->db->where('ss_aw_child_id', $child_id);
        $this->db->order_by('ss_aw_question_asked_id', 'desc');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
}
