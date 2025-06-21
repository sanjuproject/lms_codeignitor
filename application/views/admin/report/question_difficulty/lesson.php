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
                        <h4 class="page-title">Question Difficulty Report</h4>
                    </div>
                </div>
            </div>

            <!-- end page title -->
            <?php
            $urlString = "";
            if (!empty($searchdata['age'])) {
                $urlString .= $searchdata['age'];
            }
            if (!empty($searchdata['assign_level'])) {
                $urlString .= "@" . $searchdata['assign_level'];
            }
            if (!empty($searchdata['quiz_type'])) {
                $urlString .= "@" . $searchdata['quiz_type'];
            }
            if (!empty($searchdata['update_date'])) {
                $urlString .= "@" . $searchdata['update_date'];
            }
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <a href="<?= base_url(); ?>report/lesson_question_difficulty" class="btn btn-primary mb-2">Lesson</a>

                                    <a href="<?= base_url(); ?>report/assessment_question_difficulty" class="btn btn-light mb-2">Assessment</a>

                                    <a href="<?= base_url(); ?>report/diagnostic_question_difficulty" class="btn btn-light mb-2">Diagnostic</a>

                                    <a href="<?= base_url(); ?>report/readalong_question_difficulty" class="btn btn-light mb-2">Readalong</a>
                                </div>
                            </div>

                            <form method="post" id="demo-form">
                                <div class="difficulty_report_form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Program Type</label>
                                                <select name="student_level" id="student_level" class="form-control" onchange="gettopics();" required>
                                                    <option value="">Choose Level</option>
                                                    <?php
                                                    if (!empty($courses_drop)) {
                                                        foreach ($courses_drop as $cour) {
                                                    ?>
                                                            <option value="<?= $cour->ss_aw_course_id ?>" <?php
                                                                                                            if (!empty($searchdata['student_level'])) {
                                                                                                                if ($searchdata['student_level'] == $cour->ss_aw_course_id) {
                                                                                                            ?> selected <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                        ?>><?= $cour->ss_aw_course_nickname ?></option>

                                                    <?php }
                                                    } ?>

                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Topics</label>
                                                <select name="topics" id="topics" class="form-control" required>
                                                    <option value="">Choose Topic</option>
                                                    <?php
                                                    if (!empty($topic_list)) {
                                                        foreach ($topic_list as $key => $value) {
                                                    ?>
                                                            <option value="<?= $value['ss_aw_lesson_topic']; ?>" <?php
                                                                                                                    if (!empty($searchdata['topics'])) {
                                                                                                                        if ($searchdata['topics'] == $value['ss_aw_lesson_topic']) {
                                                                                                                    ?> selected <?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                                ?>><?= $value['ss_aw_lesson_topic']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">

                                                <label>Start Date</label>
                                                <input type="date" id="startdatemax" max="<?= date('Y-m-d'); ?>" name="start_date" onchange="myDateChange()" class="form-control" <?php
                                                                                                                                                                                    if (@$searchdata['start_date']) {
                                                                                                                                                                                    ?>
                                                    value="<?php echo $searchdata['start_date'] ?>"
                                                    <?php
                                                                                                                                                                                    }
                                                    ?>>

                                            </div>

                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">

                                                <label>End Date</label>
                                                <input type="date" id="enddatemin" max="<?= date('Y-m-d'); ?>" name="end_date" class="form-control" <?php if (@$searchdata['end_date']) {
                                                                                                                                                    ?>
                                                    value="<?php echo $searchdata['end_date'] ?>"
                                                    <?php
                                                                                                                                                    }
                                                    ?>>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2">

                                            <div class="form-group report-goBtn" style="margin-top: 25px;">

                                                <input type="submit" name="submit" value="Go" class="btn btn-primary form-control">

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </form>


                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Question Level</th>
                                            <th>Question</th>
                                            <th>Sequence No</th>
                                            <th>Correct Answer</th>
                                            <th>No Of User Asked</th>
                                            <th>No Of User Answer Correctly</th>
                                            <th>No Of User Answer Incorrectly</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php

                                        if (!empty($result)) {
                                            foreach ($result as $key => $value) {
                                                $page++;
                                        ?>

                                                <tr>

                                                    <td><?php echo $value->question_course_level; ?></td>

                                                    <?php
                                                    $title_string = $value->ss_aw_lesson_title . ": " . $value->ss_aw_lesson_details;
                                                    ?>
                                                    <td><?php echo getQuestion($title_string); ?></td>
                                                    <td><?php echo $page ?></td>

                                                    <td><?= $value->ss_aw_lesson_answers; ?></td>
                                                    <td><?php echo $value->question_count ? $value->question_count : 0; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($value->correct_answer_count == 0) {
                                                            echo 0;
                                                        } else {
                                                        ?>
                                                            <a href="<?= base_url(); ?>report/lesson_wright_answer_childs_list/<?= base64_encode($searchdata['student_level'] . "@" . $value->ss_aw_lession_id . "@" . $value->ss_aw_lesson_format . "@" . $this->uri->segment(3)); ?>" target="_blank"><?php echo $value->correct_answer_count ? $value->correct_answer_count : 0; ?></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($value->incorrect_answer_count == 0) {
                                                            echo 0;
                                                        } else {
                                                        ?>
                                                            <a href="<?= base_url(); ?>report/lesson_wrong_answer_childs_list/<?= base64_encode($searchdata['student_level'] . "@" . $value->ss_aw_lession_id . "@" . $value->ss_aw_lesson_format . "@" . $this->uri->segment(3)); ?>" target="_blank"><?php echo $value->incorrect_answer_count ? $value->incorrect_answer_count : 0; ?></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            <?php

                                            }
                                        } else {
                                            ?>
                                            <tr colspan="7">
                                                <td>No data found.</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">

                </div>

                <div class="col-md-6">
                    <div class="text-right">
                        <ul class="pagination pagination-rounded justify-content-end">

                            <?php
                            if (!empty($links)) {
                                foreach ($links as $link) {
                                    echo "<li>" . $link . "</li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <?php
            if (!empty($result)) {
            ?>
                <!-- <div class="row">
                    <div>
                        <a target="_blank" class="btn btn-primary" href="<?= base_url(); ?>report/export_question_difficulty">Download Report as PDF Format</a>
                    </div>
                </div> -->
            <?php
            }
            ?>


        </div> <!-- container -->

    </div> <!-- content -->

</div>
<script type="text/javascript">
    function gettopics() {
        var student_level = $("#student_level").val();
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>report/gettopicsbyquiztype",
            data: {
                "student_level": student_level,
                "quiz_type": 1
            },
            success: function(data) {
                $("#topics").html(data);
            }
        });
    }

    function myDateChange() {

        document.getElementById('enddatemin').min = document.getElementById('startdatemax').value;
        document.getElementById('enddatemin').value = "<?= date('Y-m-d'); ?>";
    }
</script>