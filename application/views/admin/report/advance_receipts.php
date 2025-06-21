 <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">
                                    <?php
                                    if (count(explode(" ", $month)) == 1) {
                                        ?>
                                        <h4 class="page-title">ADVANCE RECEIPTS: <?= date('F', mktime(0, 0, 0, $month, 10)); ?>, <?= $year; ?></h4>
                                        <?php    
                                    }
                                    else{
                                        ?>
                                        <h4 class="page-title">ADVANCE RECEIPTS: <?= $month; ?>- <?= $year; ?></h4>
                                        <?php
                                    }
                                    ?>
                                    </h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form" action="<?= base_url(); ?>report/advance_receipts">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    
                                                    <div class="col-md-3">
                                                        <!-- <input name="report_date" type="text" class="form-control report_date" data-toggle="flatpicker" placeholder="Date" > -->
                                                        <label>From</label>
                                                        <input name="report_start_date" id="report_start_date" class="report-date-picker form-control" <?= count(explode(" ", $month)) > 1 ? "value='".$month."'" : ""; ?> autocomplete="off" required/>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label>To</label>
                                                        <input name="report_end_date" id="report_end_date" class="report-date-picker form-control" <?= count(explode(" ", $year)) > 1 ? "value='".$year."'" : ""; ?> autocomplete="off" required/>
                                                    </div>          
                                                            
                                                            
                                                    <div class="col-md-3">
                                                        <div class="form-group report-goBtn" style="text-align: left;">
                                                            <input type="submit" name="submit" value="Go" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <?php
                                                        if (!empty($advance_receipt)) {
                                                            ?>
                                                            <div class="row">
                                                                <div>
                                                                    <a class="btn btn-primary" href="<?= base_url(); ?>report/advance_receipts_export">Download Report</a>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                               
                                        <div class="table-responsive gridview-wrapper">
                                            <?php
                                            if (!empty($advance_receipt)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Bill No</th>
                                                            <th>Name</th>
                                                            <th>PAN</th>
                                                            <th>Billing City</th>
                                                            <th>Billing State</th>
                                                            <th>GST HSN Code</th>
                                                            <th>Programme Type</th>
                                                            <th>Invoice Amount</th>
                                                            <th>Lumpsum/EMI</th>
                                                            <th>Discount</th>
                                                            <th>GST</th>
                                                            <th>Total Invoice(Including GST)</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        foreach ($advance_receipt as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?= date('d-m-Y', strtotime($value->ss_aw_revenue_date)); ?></td>
                                                                <td><?= $value->ss_aw_bill_no; ?></td>
                                                                <td><?= $value->instution_name != '' ? $value->instution_name : $value->ss_aw_parent_full_name; ?></td>
                                                                <td><?=$value->ss_aw_pan_no != '' ? $value->ss_aw_pan_no : 'ABTFA3148H'?></td>
                                                                <td><?= $value->inst_city != '' ? $value->inst_city : $value->ss_aw_parent_city; ?></td>
                                                                <td><?= $value->inst_state != '' ? $value->inst_state : $value->ss_aw_parent_state; ?></td>
                                                                <td><?=$value->ss_aw_gst_no != '' ? $value->ss_aw_gst_no : '19ABTFA3148H1Z3'?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($value->ss_aw_course_id == 1 || $value->ss_aw_course_id == 2) {
                                                                        echo Winners;
                                                                    }
                                                                    elseif ($value->ss_aw_course_id == 3) {
                                                                        echo Champions;
                                                                    }
                                                                    elseif($value->ss_aw_course_id == 5){
                                                                        echo Master."s";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?= $advance_amount = round($value->advance_amount, 2); ?></td>
                                                                <td><?= $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI" ?></td>
                                                                <td><?= $value->ss_aw_discount_amount; ?></td>
                                                                <td><?= $gst = round(($value->advance_amount*18)/100, 2); ?></td>
                                                                <td><?= $advance_amount + $gst; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <p>No data found.</p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->