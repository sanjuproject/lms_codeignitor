<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    .complete_number th {
        font-size: 11px;
    }
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">Report Dashboard</li>
                            <li class="breadcrumb-item">Module-wise Completion Status</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Module-wise Completion Status</h4>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <form method="post" id="demo-form" action="<?= base_url('institution/module_wise_complete_performance'); ?>">
                        <div class="difficulty_report_form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-end align-items-center pt-3">
                                        <label class="m-0 mr-2">Programme&nbsp;Type</label>
                                        <select name="programme_type" id="programme_type" class="form-control mt-0">
                                            <?php
                                            if (!empty($courses_drop)) {
                                                foreach ($courses_drop as $cour) {
                                            ?>
                                                    <option value="<?= $cour->ss_aw_course_id ?>" <?php if (!empty($searchdata['complete_user_programme_type'])) {
                                                                                                        if ($searchdata['complete_user_programme_type'] == $cour->ss_aw_course_id) { ?> selected <?php }
                                                                                                                                                                                                                                                } ?>><?= $cour->ss_aw_course_nickname ?></option>

                                            <?php }
                                            } ?>
                                        </select>
                                        <div class="form-group report-goBtn ml-2 m-0" style="margin-top: 25px;">
                                            <input type="submit" name="submit" value="Go" class="btn btn-primary form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (!empty($childs)) {
                    ?>
                        <div class="btn-container pt-3 pl-2">
                            <a href="<?= base_url(); ?>export/export_institution_module_wise_complete_performance/<?= $institution_id; ?>/<?= @$searchdata['complete_user_programme_type'] ?>/1" class="btn btn-success align-middle"><i class="mdi mdi-file-excel"></i>Export</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (!empty($childs)) {
                            ?>
                                <h4 class="text-center">No of users: <?= count($childs); ?></h4>
                                <div class="table-responsive gridview-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Topics</th>
                                                <th></th>
                                                <th class="text-center">Lesson</th>
                                                <th class="text-center">Assessment</th>

                                                <th class="text-center">Completed on time</th>
                                                <th class="text-center">Completed but not on time</th>
                                                <th class="text-center">1 to 7 days delinquent</th>
                                                <th class="text-center">8 to 14 days delinquent</th>
                                                <th class="text-center">15+ days delinquent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Diagnostic Quiz</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center"><a target="_blank" href="<?= $diagnosticcompletenum == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_complete_users/' . base64_encode(implode(",", $diagnosticcompletechilds))) ?>"><?= $diagnosticcompletenum; ?></a></td>


                                                <td class="text-center">
                                                    <?php
                                                    if (!empty($diagnostic_complete_log)) {
                                                    ?>
                                                        <a target="_blank"
                                                            href="<?= $diagnostic_complete_log->ss_aw_completed_on_time == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_complete_users/' . base64_encode($diagnostic_complete_log->ss_aw_completed_on_time_users)) ?>/<?= base64_encode(1) ?>"><?= $diagnostic_complete_log->ss_aw_completed_on_time; ?></a>
                                                    <?php
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                $total_non_time_complete_users = "";
                                                if (!empty($diagnostic_complete_log)) {
                                                    $total_non_time_complete = $diagnostic_complete_log->ss_aw_completed_but_not_on_time;
                                                    if (!empty($diagnostic_complete_log->ss_aw_completed_but_not_on_time_users)) {
                                                        $total_non_time_complete_users .= $diagnostic_complete_log->ss_aw_completed_but_not_on_time_users;
                                                    }
                                                } else {
                                                    $total_non_time_complete = "";
                                                }
                                                ?>
                                                <td class="text-center">
                                                    <?php
                                                    if (!empty($total_non_time_complete)) {
                                                    ?>
                                                        <a target="_blank" href="<?= $total_non_time_complete == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_complete_users/' . base64_encode($total_non_time_complete_users)) ?>/<?= base64_encode(2) ?>"><?= $total_non_time_complete; ?></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="javascript:void(0)">0</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php
                                                                        if (!empty($diagnostic_complete_log)) {
                                                                        ?>
                                                        <a target="_blank" href="<?= $diagnostic_complete_log->ss_aw_one_to_seven_delinquent == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_complete_users/' . base64_encode($diagnostic_complete_log->ss_aw_one_to_seven_delinquent_users)) ?>/<?= base64_encode(3) ?>"><?= $diagnostic_complete_log->ss_aw_one_to_seven_delinquent; ?></a>
                                                    <?php
                                                                        } else {
                                                                            echo '';
                                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if (!empty($diagnostic_complete_log)) {
                                                    ?>
                                                        <a target="_blank" href="<?= $diagnostic_complete_log->ss_aw_eight_to_forteen_delinquent == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_complete_users/' . base64_encode($diagnostic_complete_log->ss_aw_eight_to_forteen_delinquent_users)) ?>/<?= base64_encode(4) ?>"><?= $diagnostic_complete_log->ss_aw_eight_to_forteen_delinquent; ?></a>
                                                    <?php
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if (!empty($diagnostic_complete_log)) {
                                                    ?>
                                                        <a target="_blank" href="<?= $diagnostic_complete_log->ss_aw_fifteen_plus_delinquent == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_complete_users/' . base64_encode($diagnostic_complete_log->ss_aw_fifteen_plus_delinquent_users)) ?>/<?= base64_encode(5) ?>"><?= $diagnostic_complete_log->ss_aw_fifteen_plus_delinquent; ?></a>
                                                    <?php
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            if (!empty($topics)) {
                                                foreach ($topics as $key => $value) {
                                                    $lesson_id = $value['ss_aw_lession_id'];
                                            ?>
                                                    <tr>
                                                        <td><?= $value['ss_aw_lesson_topic']; ?></td>
                                                        <td><?= $key + 1; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['lessonnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                            ?>
                                                                <a target="_blank" href="<?= $value['lessoncompletenum'] == 0 ? 'javascript:void(0)' : base_url('institution/lesson_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($value['lessoncompletechilds'])) ?>"><?= $value['lessoncompletenum']; ?></a>
                                                            <?php
                                                            }
                                                            ?>

                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['assessmentnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                            ?>
                                                                <a target="_blank" href="<?= $value['assessmentcompletenum'] == 0 ? 'javascript:void(0)' : base_url('institution/assessment_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($value['assessmentcompletechilds'])) ?>"><?= $value['assessmentcompletenum']; ?></a>
                                                            <?php
                                                            }
                                                            ?>

                                                        </td>

                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['assessmentnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                                if (!empty($topical_log_details)) {
                                                            ?>
                                                                    <a target="_blank" href="<?= $topical_log_details[$lesson_id]->ss_aw_completed_on_time == 0 ? 'javascript:void(0)' : base_url('institution/assessment_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($topical_log_details[$lesson_id]->ss_aw_completed_on_time_users)) ?>//<?= base64_encode(1) ?>"><?= $topical_log_details[$lesson_id]->ss_aw_completed_on_time; ?></a>
                                                            <?php
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            }
                                                            ?>
                                                        </td>

                                                        <?php
                                                        $topic_non_time_complete_users = "";
                                                        if (!empty($topical_log_details)) {
                                                            $non_time_total_complete = $topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time;

                                                            if (!empty($topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time_users)) {
                                                                $topic_non_time_complete_users .= $topical_log_details[$lesson_id]->ss_aw_completed_but_not_on_time_users;
                                                            }
                                                        } else {
                                                            $non_time_total_complete = "";
                                                        }
                                                        ?>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['assessmentnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                                if (!empty($non_time_total_complete)) {
                                                            ?>
                                                                    <a target="_blank" href="<?= $non_time_total_complete == 0 ? 'javascript:void(0)' : base_url('institution/assessment_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($topic_non_time_complete_users)) ?>/<?= base64_encode(2) ?>"><?= $non_time_total_complete; ?></a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a href="javascript:void(0)">0</a>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['assessmentnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                                if (!empty($topical_log_details)) {
                                                            ?>
                                                                    <a target="_blank" href="<?= $topical_log_details[$lesson_id]->ss_aw_one_to_seven_delinquent == 0 ? 'javascript:void(0)' : base_url('institution/assessment_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($topical_log_details[$lesson_id]->ss_aw_one_to_seven_delinquent_users)) ?>/<?= base64_encode(3) ?>"><?= $topical_log_details[$lesson_id]->ss_aw_one_to_seven_delinquent; ?></a>
                                                            <?php
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['assessmentnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                                if (!empty($topical_log_details)) {
                                                            ?>
                                                                    <a target="_blank" href="<?= $topical_log_details[$lesson_id]->ss_aw_eight_to_forteen_delinquent == 0 ? 'javascript:void(0)' : base_url('institution/assessment_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($topical_log_details[$lesson_id]->ss_aw_eight_to_forteen_delinquent_users)) ?>/<?= base64_encode(4) ?>"><?= $topical_log_details[$lesson_id]->ss_aw_eight_to_forteen_delinquent; ?></a>
                                                            <?php
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($value['assessmentnonaccessable'] == 0) {
                                                                echo "NA";
                                                            } else {
                                                                if (!empty($topical_log_details)) {
                                                            ?>
                                                                    <a target="_blank" href="<?= $topical_log_details[$lesson_id]->ss_aw_fifteen_plus_delinquent == 0 ? 'javascript:void(0)' : base_url('institution/assessment_complete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($topical_log_details[$lesson_id]->ss_aw_fifteen_plus_delinquent_users)) ?>/<?= base64_encode(5) ?>"><?= $topical_log_details[$lesson_id]->ss_aw_fifteen_plus_delinquent; ?></a>
                                                            <?php
                                                                } else {
                                                                    echo '-';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h4 class="text-danger">Sorry! no data found</h4>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div>

            </div>


        </div> <!-- container -->

    </div> <!-- content -->
    <?php
    include('bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->
<?php
include('footer.php')
?>
</body>

</html>