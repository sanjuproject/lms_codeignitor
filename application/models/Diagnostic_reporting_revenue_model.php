<?php
class Diagnostic_reporting_revenue_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = "diagnostic_reporting_revenue";
    }

    public function store_data($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}
