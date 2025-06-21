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
                                    <h4 class="page-title">Assessment Report</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive gridview-wrapper">
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="4">Grammar Proficiency</td>
                                                            <td colspan="4">English Proficiency</td>
                                                            <td colspan="5">Reading Comprehension</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Level</td>
                                                            <td>Student Name</td>
                                                            <td>Lessons Completed</td>
                                                            <td>Assessments Completed</td>
                                                            <td>Avgtime to answer question</td>
                                                            <td>Number of questions skipped</td>
                                                            <td>Lessons Completed</td>
                                                            <td>Assessments Completed</td>
                                                            <td>Avgtime to answer question</td>
                                                            <td>Number of questions skipped</td>
                                                            <td>Lessons Completed</td>
                                                            <td>Assessments Completed</td>
                                                            <td>Readalongs Completed</td>
                                                            <td>Avgtime to answer question</td>
                                                            <td>Number of questions skipped</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (!empty($fut_students)) {
                                                            foreach ($fut_students as $key => $value) {
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php
                                                                        if ($value->ss_aw_course_id == 1) {
                                                                            echo "E";
                                                                        }
                                                                        elseif ($value->ss_aw_course_id == 2) {
                                                                            echo "C";
                                                                        }
                                                                        else{
                                                                            echo "A";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?= $value->ss_aw_child_nick_name; ?></td>
                                                                    <td><?= $grammer_proficiency_lesson_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $grammer_proficiency_assessment_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $grammer_proficiency_avg_time[$value->ss_aw_child_id] > 0 ? number_format($grammer_proficiency_avg_time[$value->ss_aw_child_id], 2) : $grammer_proficiency_avg_time[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $grammer_proficiency_skipped_question[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $multiple_lesson_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $multiple_assessment_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $english_proficiency_answer_avg_time[$value->ss_aw_child_id] > 0 ? number_format($english_proficiency_answer_avg_time[$value->ss_aw_child_id], 2) : $english_proficiency_answer_avg_time[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $english_proficiency_skipped_count[$value->ss_aw_child_id] ?></td>
                                                                    <td><?= $multiple_lesson_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $multiple_assessment_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $total_readalong_complete_count[$value->ss_aw_child_id]; ?></td>
                                                                    <td><?= $reading_comprehension_answer_avg_time[$value->ss_aw_child_id] > 0 ? number_format($reading_comprehension_answer_avg_time[$value->ss_aw_child_id], 2) : $reading_comprehension_answer_avg_time[$value->ss_aw_child_id]; ?></td>
                                                                    
                                                                    <td>NA</td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
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