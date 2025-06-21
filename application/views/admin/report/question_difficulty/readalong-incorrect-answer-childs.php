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
                        <h4 class="page-title"><?= $title ?></h4>
                    </div>
                </div>
            </div>     

            <!-- end page title --> 
            <a href="<?= base_url(); ?>report/readalong_question_difficulty/<?= $page_num; ?>" class="btn btn-primary">Go Back</a>
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
                                } elseif ($assign_level == 3) {
                                    $assign_level = Champions;
                                } else {
                                    $assign_level = Master."s";
                                }
                            }
                            $quiz_type = "Readalong Quiz";
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
                                if (!empty($wrong_answer_child_list)) {
                                    ?>
                                    <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                           data-show-columns="true">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>User Name</th>
                                                <th>Institution/Parent Name</th>
                                                <th><?= $page_type == 1 ? "Correct" : "Incorrect" ?> Answer</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($wrong_answer_child_list as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><a href="<?= base_url(); ?>admin/readalong_quiz_details/<?= $value->parent_id ?>/<?= $value->child_id; ?>/<?= $readalong_upload_id; ?>"><?= $value->child_name; ?></a></td>
                                                    <td><?= $value->institution_name != '' ? $value->institution_name : $value->parent_name; ?></td>
                                                    <td><?= $value->wrong_answer; ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
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