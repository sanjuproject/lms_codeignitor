<?php
class Diagnostic_payment_details_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = "diagnostic_payment_details";
    }
    public function data_insert($data)
    {
        $this->db->insert($this->table, $data);
        return true;
    }
    public function get_last_invoice()
    {
        $this->db->select('ss_aw_payment_invoice');
        $this->db->from($this->table);
        $this->db->order_by('ss_aw_payment_id', 'desc');
        $this->db->limit(1);
        return $this->db->get()->result();
    }
}
