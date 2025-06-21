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
                                    Daily MIS 
                                    </h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form" action="<?= base_url(); ?>report/daily_mis">
                                            <div class="difficulty_report_form">
                                                <div class="row">    
                                                    <div class="col-md-3">
                                                        <input name="search_date" type="text" class="form-control" data-toggle="flatpicker" placeholder="Date" >
                                                        
                                                    </div>

                                                          
                                                            
                                                            
                                                    <div class="col-md-3">
                                                        <div class="form-group report-goBtn" style="text-align: left;">
                                                            <input type="submit" name="submit" value="Go" class="btn btn-primary">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                       
                                                            <div class="row">
                                                                <div>
                                                                    <a class="btn btn-primary" href="<?= base_url(); ?>report/daily_mis_export">Download Report as PDF Format</a>
                                                                </div>
                                                            </div>
                                                            
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                               
                                        <div class="table-responsive gridview-wrapper">
                                            
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>MIS as of <?= date('d/m/Y', strtotime($current_date)); ?></th>
                                                            <th>Today</th>
                                                            <th>Last 3 days</th>
                                                            <th>Last 7 days</th>
                                                            <th>> 7 days</th>
                                                            <th>Total</th>
                                                            <th><?=Winners?></th>
                                                            <th><?=Champions?></th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <tr>
                                                            <td>Parent Profiles</td>
                                                            <?php
                                                            foreach ($parent_profile as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <!-- <td>-</td> -->
                                                            <td>-</td>
                                                            <td>-</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Child Profiles</td>
                                                            <?php
                                                            foreach ($child_profile as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <!-- <td>-</td> -->
                                                            <td>-</td>
                                                            <td>-</td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <td>Diagnostic Quizzes taken</td>
                                                            <?php
                                                            foreach ($diagnostic_quiz_taken as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                            <td><?= $diagnostic_quiz['emerging'] + $diagnostic_quiz['consolidate']; ?></td>
                                                            <td><?= $diagnostic_quiz['advance']; ?></td>
                                                        </tr> -->
                                                        <tr>
                                                            <td>Enrolments - Emi</td>
                                                            <?php
                                                            foreach ($enrollment_emi as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                            <td><?= $enrollment_emi_course['emerging'] + $enrollment_emi_course['consolidate']; ?></td>
                                                            
                                                            <td><?= $enrollment_emi_course['advance']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Enrolments - Lumpsum</td>
                                                            <?php
                                                            foreach ($enrollment_lumpsum as $key => $value) {
                                                                ?>
                                                                <td><?= $value; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                            <td><?= $enrollment_lumpsum_course['emerging'] + $enrollment_lumpsum_course['consolidate']; ?></td>
                                                            
                                                            <td><?= $enrollment_lumpsum_course['advance']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
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