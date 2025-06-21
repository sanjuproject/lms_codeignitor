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
                                    Email Logs
                                    </h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form" action="<?= base_url(); ?>report/email_log">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    
                                                    <div class="col-md-3">
                                                        <!-- <input name="report_date" type="text" class="form-control report_date" data-toggle="flatpicker" placeholder="Date" > -->
                                                        <label>Date</label>
                                                        <input type="date" name="search_date" class="form-control" id="search_date" <?= $search_date ? "value='".$search_date."'" : ""; ?> autocomplete="off"/>
                                                    </div>

                                                             
                                                            
                                                            
                                                    <div class="col-md-6" style="display: flex;">
                                                        <div class="form-group report-goBtn" style="text-align: left;margin-top: 28px;">
                                                            <input type="submit" name="submit" value="Go" class="btn btn-primary">
                                                        </div>
                                                        <div class="form-group report-goBtn" style="text-align: left;margin-top: 28px; margin-left: 10px;">
                                                            <input type="button" name="submit" value="Clear" class="btn btn-danger" onclick="cleardata();">
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="col-md-3">
                                                        <?php
                                                        if (!empty($result)) {
                                                            ?>
                                                            <div class="row">
                                                                <div style="margin-top: 28px;">
                                                                    <a class="btn btn-primary" href="<?= base_url(); ?>report/email_log_export">Download Report</a>
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
                                            if (!empty($result)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Sending Time</th>
                                                            <th>Subject</th>
                                                            <th>Email ID</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        foreach ($result as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $value->ss_aw_date ? date('d/m/Y h:i a', strtotime($value->ss_aw_date)) : ""; ?></td>
                                                                <td><?= $value->ss_aw_subject; ?></td>
                                                                <td><?= $value->ss_aw_email_id; ?></td>
                                                                <td><?= $value->ss_aw_status; ?></td>
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

<script type="text/javascript">
    function cleardata(){
        location.replace("<?= base_url('report/email_log'); ?>");
    }    
</script>   
<!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->