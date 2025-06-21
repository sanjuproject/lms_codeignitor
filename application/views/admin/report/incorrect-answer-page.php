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
                                    <h4 class="page-title">Incorrect Answers</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 
                        <a href="<?= base_url(); ?>report/question_difficulty_report/<?= $page_num; ?>" class="btn btn-primary">Go Back</a>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                            $assign_level = "";
                                            if (!empty($searchdata['student_level'])) {
                                                $assign_level = $searchdata['student_level'];
                                                if ($assign_level == 1 || $assign_level == 2) {
                                                    $assign_level = Winners;
                                                }
                                                elseif ($assign_level == 3) {
                                                    $assign_level = Champions;
                                                }
                                                else{
                                                    $assign_level = Master."s";
                                                }
                                            }
                                            $quiz_type = "";
                                            if (!empty($searchdata['quiz_type'])) {
                                                $quiz_type = $searchdata['quiz_type'];
                                                if ($quiz_type == 1) {
                                                    $quiz_type = "Lesson Quiz";
                                                }
                                                elseif ($quiz_type == 2) {
                                                    $quiz_type = "Assessment Quiz";
                                                }
                                                else{
                                                    $quiz_type = "Diagnostic Quiz";
                                                }
                                            }
                                            $update_date = "";
                                            if (!empty($searchdata['update_date'])) {
                                                $update_date = $searchdata['update_date'];
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4"><b>Assign Level</b> : <?= $assign_level; ?></div>
                                            <div class="col-md-4"><b>Quiz Type</b> : <?= $quiz_type; ?></div>
                                            <div class="col-md-4"><b>Question Topic</b> : <?= $question_topic; ?></div>
                                        </div>
                                        
                                        <h3><?= $question_preface; ?></h3>
                                        <h4><?= $question_details; ?><span style="font-size: 14px;">(Correct Answer - <?= $correct_answer; ?>)</span></h4>
                                        <div class="table-responsive gridview-wrapper">
                                            <?php
                                            if (!empty($wrong_answer_details)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Wrong Answers</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        foreach ($wrong_answer_details as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $value->wrong_answer; ?></td>
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

        </div>
        <!-- END wrapper -->

</body>
</html>