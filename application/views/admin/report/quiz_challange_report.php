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
                                    Puzzle Logs
                                    </h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-md-3">
                                            <?php
                                            if (!empty($quiz_report)) {
                                            ?>
                                                <div class="row">
                                                    <div style="margin-top: 28px;">
                                                        <a class="btn btn-primary" href="<?= base_url(); ?>report/puzzle_log_export">Download Report</a>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="table-responsive gridview-wrapper">
                                            <?php
                                            if (!empty($quiz_report)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Puzzle Name</th>
                                                            <th>Total Attempts</th>
                                                            <th>Correct</th>
                                                            <th>Incorrect</th>
                                                            <th>Likes</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        foreach ($quiz_report as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $value->challange_name; ?></td>
                                                                <td><?= $value->total_attempt; ?></td>
                                                                <td><?= $value->correct; ?></td>
                                                                <td><?= $value->wrong; ?></td>
                                                                <td><?= $value->like_count; ?></td>
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