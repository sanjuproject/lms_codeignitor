<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_completion_cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("ss_aw_course_completion_model");
        $this->load->model("ss_aw_child_course_model");
        $this->load->model("ss_aw_purchase_courses_model");
    }

    public function complete_child_course() {
        $mesg = array();
        $completed_data = $this->ss_aw_course_completion_model->getcoursecompletionAll();

        if (!empty($completed_data)) {
            foreach ($completed_data as $comp) {
                $data = array();
                $data['ss_aw_course_status'] = 2;
                $data['ss_aw_child_course_modified_date'] = date('Y-m-d H:i:s');
                $result = $this->ss_aw_child_course_model->updaterecord_child($comp->ss_aw_child_id, $data);
                if ($result) {
                    $cour['ss_aw_is_completed'] = 2;
                    $upd_course = $this->ss_aw_course_completion_model->update_data($cour, $comp->ss_aw_id);
                    if ($upd_course) {
                        $pur['ss_aw_course_currrent_status'] = 2;
                        $pur['ss_aw_course_modified_date'] = date('Y-m-d H:i:s');
                        $this->ss_aw_purchase_courses_model->update_record($comp->ss_aw_child_id, $pur);
                    }
                }
            }
            $mesg['status'] = "200";
            $mesg['msg'] = "Child course updated successfully";
        } else {
            $mesg['status'] = "204";
            $mesg['msg'] = "No data found";
        }

        echo json_encode($mesg);
        exit;
    }

}
