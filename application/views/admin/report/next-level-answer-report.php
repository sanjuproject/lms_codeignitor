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
                                    <h4 class="page-title">Assessment Difficulty</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">    
                                        <div class="table-responsive gridview-wrapper">
                                            <?php
                                            if (!empty($assessment_list)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Assessment</th>
                                                            <th>Students</th>
                                                            <th>Students that answered questions from next level</th>
                                                            <th>% Students that answered questons from next level</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        foreach ($assessment_list as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $value['ss_aw_assesment_topic']; ?></td>
                                                                <?php
                                                                    if (!empty($assessment_perticipant[$value['ss_aw_assessment_id']])) {
                                                                        $total_student = $assessment_perticipant[$value['ss_aw_assessment_id']];
                                                                    }
                                                                    else
                                                                    {
                                                                        $total_student = "0";
                                                                    }
                                                                ?>
                                                                <td><?= $total_student; ?></td>
                                                                <?php
                                                                    if (!empty($assessment_next_level_perticipant[$value['ss_aw_assessment_id']])) {
                                                                        $next_level_student = $assessment_next_level_perticipant[$value['ss_aw_assessment_id']];
                                                                    }
                                                                    else
                                                                    {
                                                                        $next_level_student = 0;
                                                                    }
                                                                ?>
                                                                <td><?= $next_level_student; ?></td>
                                                                <td><?= get_percentage($total_student, $next_level_student)."%"; ?></td>
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

                        <!-- <?php
                        if (!empty($lessons)) {
                            ?>
                            <div class="row">
                                <div>
                                    <a target="_blank" class="btn btn-primary" href="<?= base_url(); ?>report/export_lesson_complete_data">Download Report as PDF Format</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?> -->
                      
                        
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

</body>
</html>