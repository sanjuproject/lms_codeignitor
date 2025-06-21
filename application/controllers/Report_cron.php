<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_cron extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cron_report_enroll_current_status_model');
        $this->load->model('ss_aw_reporting_collection_model');
        $this->load->model('ss_aw_reporting_revenue_model');
        $this->load->helper("custom_helper");
    }

    public function report_data_enroll_current_status()
    {
        $this->db->query("TRUNCATE cron_report_enroll_current_statu_data");
        $course = array("1", "3", "5");

        foreach ($course as $course_type) {
            $previous_month_date = date('Y-m-d');
            for ($i = 1; $i <= 25; $i++) {

                $previous_month_date = date('Y-m-d', strtotime($previous_month_date . ' -1 month'));
                $date = date("Y-m-t", strtotime($previous_month_date));
                $total_monthly['year'] = $previous_year = date('Y', strtotime($previous_month_date));
                $total_monthly['month'] = $previous_month = date('m', strtotime($previous_month_date));

                $all_child_count = $this->Cron_report_enroll_current_status_model->getAllChildCount($previous_month, $previous_year, $course_type);

                $monthly_total_complete_num = $this->Cron_report_enroll_current_status_model->getessoncompletenum($previous_month, $previous_year, $course_type);

                $total_monthly['completed'] = 0;
                $total_monthly['completed_per'] = 0;

                $total_monthly['course_id'] = $course_type;
                $total_monthly['completed'] = @$monthly_total_complete_num->complete_num == '' ? 0 : $monthly_total_complete_num->complete_num;
                $total_monthly['completed_child'] = @$monthly_total_complete_num->child_id == '' ? 0 : $monthly_total_complete_num->child_id;
                $total_monthly['completed_total'] = !empty($all_child_count) ? $all_child_count : 0;
                if ($total_monthly['completed'] != 0) {
                    $total_monthly['completed_per'] = round((($total_monthly['completed'] / $all_child_count) * 100), 2);
                }

                // Active childs details
                $all_child_count_in_active = $this->Cron_report_enroll_current_status_model->getAllChildCount($previous_month, $previous_year, $course_type, 1);

                $total_monthly['incompleted_total'] = !empty($all_child_count_in_active) ? $all_child_count_in_active : 0;

                $total_monthly['active'] = 0;
                $total_monthly['active_child'] = '';
                $total_monthly['active_percent'] = 0;

                $active_monthly_data = $this->Cron_report_enroll_current_status_model->getessonincompletenum($date, $course_type, $range_type = '1');

                if (!empty($active_monthly_data)) {
                    $total_monthly['active'] = @$active_monthly_data->complete_num == '' ? 0 : $active_monthly_data->complete_num;
                    $total_monthly['active_child'] = @$active_monthly_data->child_id == '' ? 0 : $active_monthly_data->child_id;

                    if ($total_monthly['active'] > 0) {
                        $total_monthly['active_percent'] = round((($total_monthly['active'] / $all_child_count_in_active) * 100), 2);
                    }
                }
                // Inactive childs details
                $total_monthly['inactive'] = 0;
                $total_monthly['inactive_child'] = '';
                $total_monthly['inactive_per'] = 0;

                $inactive_monthly_data = $this->Cron_report_enroll_current_status_model->getessonincompletenum($date, $course_type, $range_type = '2');

                if (!empty($inactive_monthly_data)) {
                    $total_monthly['inactive'] = @$inactive_monthly_data->complete_num == '' ? 0 : $inactive_monthly_data->complete_num;
                    $total_monthly['inactive_child'] = @$inactive_monthly_data->child_id == '' ? 0 : $inactive_monthly_data->child_id;

                    if ($total_monthly['inactive'] > 0) {
                        $total_monthly['inactive_per'] = round((($total_monthly['inactive'] / $all_child_count_in_active) * 100), 2);
                    }
                }

                // Deliquent childs details
                $total_monthly['delinquent'] = 0;
                $total_monthly['delinquent_child'] = '';
                $total_monthly['delinquent_per'] = 0;

                $delinquent_monthly_data = $this->Cron_report_enroll_current_status_model->getessonincompletenum($date, $course_type, $range_type = '3');

                if (!empty($delinquent_monthly_data)) {
                    $total_monthly['delinquent'] = @$delinquent_monthly_data->complete_num == '' ? 0 : $delinquent_monthly_data->complete_num;
                    $total_monthly['delinquent_child'] = @$delinquent_monthly_data->child_id == '' ? 0 : $delinquent_monthly_data->child_id;

                    if ($total_monthly['delinquent'] > 0) {
                        $total_monthly['delinquent_per'] = round((($total_monthly['delinquent'] / $all_child_count_in_active) * 100), 2);
                    }
                }



                $this->Cron_report_enroll_current_status_model->Add('cron_report_enroll_current_statu_data', $total_monthly);
            }
        }

        return true;
    }

    /*FOR COLLECTION REPORT CRON JOB*/
    public function send_collection_mail()
    {
        $data = array();
        $date = date('F , Y', strtotime(' -1 month'));
        $subject = "Collection Report for $date";
        $email = "sanju.malik@schemaphic.com";
        $cc = "sanju.25@yopmail.com";
        $data['attachment'] = $this->auto_send_collection_data();

        if ($data['attachment'] != '') {
            $msg = $this->load->view("mail_template/collection_template", $data, true);
            $mail = emailnotification($email, $subject, $msg, $cc , $data['attachment']);
            if ($mail) {
                echo "Mail send successfully";
                exit;
            } else {
                echo "Error ! can not send mail";
                exit;
            }
        } else {
            echo "No data found";
            exit;
        }
    }


    public function auto_send_collection_data()
    {

        $headerdata['title'] = "Reporting Collection";
        $start_date = date("Y-m-01", strtotime("-1 months"));
        $end_date = date("Y-m-t", strtotime($start_date));


        $result = array();
        if (!empty($start_date) && !empty($end_date)) {
            $start_date_m = date('m/Y', strtotime($start_date));
            $end_date_m = date('m/Y', strtotime($end_date));
            $result = $this->ss_aw_reporting_collection_model->getalldata($start_date_m, $end_date_m);
        }

        $pagedata['collection_details'] = $result;


        // create file name
        $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        // ob_clean();
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Collection Report");

        $objPHPExcel->setActiveSheetIndex(0);

        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');
        // set Row
        $rowCount = 2;
        if (!empty($result)) {
            foreach ($result as $value) {
                if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                    $program_type = Winners;
                } elseif ($value->ss_aw_course_id == 3) {
                    $program_type = Champions;
                } elseif ($value->ss_aw_course_id == 5) {
                    $program_type = Master . "s";
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_created_at)));
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, trim($value->instution_name != '' ? $value->instution_name : $value->ss_aw_parent_full_name));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->ss_aw_pan_no != '' ? trim($value->ss_aw_pan_no) : '');
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->inst_city != '' ? $value->inst_city : $value->ss_aw_parent_city);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->inst_state != '' ? $value->inst_state : $value->ss_aw_parent_state);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->ss_aw_gst_no != '' ? trim($value->ss_aw_gst_no) : '');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->ss_aw_invoice_amount);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
                $gst = round(($value->ss_aw_invoice_amount * 18) / 100, 2);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value->ss_aw_invoice_amount + $gst);
                $rowCount++;
            }
        }

        // --------------------------------SHEET 2-------------------------------------------//
        $result_rev = array();

        if (!empty($start_date) && !empty($end_date)) {
            $start_date_m = date('m/Y', strtotime($start_date));
            $end_date_m = date('m/Y', strtotime($end_date));
            $result_rev = $this->ss_aw_reporting_revenue_model->getalldata($start_date_m, $end_date_m);
        }


        $objPHPExcel->createSheet()->setTitle("Revenue Report");
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');
        // set Row


        $rowCount = 2;
        if (!empty($result_rev)) {
            foreach ($result_rev as $value) {
                if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                    $program_type = Winners;
                } elseif ($value->ss_aw_course_id == 3) {
                    $program_type = Champions;
                } elseif ($value->ss_aw_course_id == 5) {
                    $program_type = Master . "s";
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_revenue_date)));
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, trim($value->instution_name != '' ? $value->instution_name : $value->ss_aw_parent_full_name));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->ss_aw_pan_no != '' ? trim($value->ss_aw_pan_no) : '');
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->inst_city != '' ? $value->inst_city : $value->ss_aw_parent_city);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->inst_state != '' ? $value->inst_state : $value->ss_aw_parent_state);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->ss_aw_gst_no != '' ? $value->ss_aw_gst_no : '');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value->ss_aw_invoice_amount);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
                $gst = round(($value->ss_aw_invoice_amount * 18) / 100, 2);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value->ss_aw_invoice_amount + $gst);
                $rowCount++;
            }
        }

        // -------------------------------SHEET 3----------------------------------//
        $result_receipt = array();
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = date('Y-m', strtotime($start_date));
            $start_date = $start_date . "-01";

            $end_date = date('Y-m', strtotime($end_date));
            $days_current_month = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($end_date)), date('Y', strtotime($end_date)));
            $end_date = $end_date . "-" . $days_current_month;
            $result_receipt = $this->ss_aw_reporting_revenue_model->get_advance_receipt_data($start_date, $end_date);
        }

        $objPHPExcel->createSheet()->setTitle("Receipt Report");
        $objPHPExcel->setActiveSheetIndex(2);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bill No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Billing City');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Billing State');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'GST HSN Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Programme Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoice Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Lumpsum/EMI');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'GST');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Invoice(Including GST)');

        $rowCount = 2;
        if (!empty($result_receipt)) {
            foreach ($result_receipt as $value) {
                if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                    $program_type = Winners;
                } elseif ($value->ss_aw_course_id == 3) {
                    $program_type = Champions;
                } elseif ($value->ss_aw_course_id == 5) {
                    $program_type = Master . "s";
                }

                $advance_amount = round($value->advance_amount, 2);




                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d-m-Y', strtotime($value->ss_aw_revenue_date)));
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->ss_aw_bill_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value->instution_name != '' ? $value->instution_name : $value->ss_aw_parent_full_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->ss_aw_pan_no != '' ? $value->ss_aw_pan_no : '');
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->inst_city != '' ? $value->inst_city : $value->ss_aw_parent_city);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->inst_state != '' ? $value->inst_state : $value->ss_aw_parent_state);

                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value->ss_aw_gst_no != '' ? $value->ss_aw_gst_no : '');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $program_type);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $advance_amount);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI");
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value->ss_aw_discount_amount);
                $gst = round(($advance_amount * 18) / 100, 2);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $gst);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $advance_amount + $gst);
                $rowCount++;
            }
        }
        $objPHPExcel->setActiveSheetIndex(0);


        $filename = "reporting-collection" . date("Y-m-d-H-i-s") . ".xls"; //save our workbook as this file name
        // For Direct Download//
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        // header('Cache-Control: max-age=0'); //no cache`
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');
        $filepath = "collection_report/";
        if (!file_exists($filepath)) {
            mkdir($filepath);
        }
        $save_file_path = $filepath . $filename;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save($save_file_path);
        return "/var/www/vhosts/team.com/httpdocs/awadmin/" . $filepath . $filename;
    }
}
