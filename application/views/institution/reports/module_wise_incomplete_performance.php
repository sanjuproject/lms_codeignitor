<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">

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
                            <li class="breadcrumb-item">Users yet to Complete Modules</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Users yet to Complete Modules</h4>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <form method="post" id="demo-form" action="<?= base_url('institution/module_wise_incomplete_performance'); ?>">
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
                                                    <option value="<?= $cour->ss_aw_course_id ?>" <?php if (!empty($searchdata['incomplete_user_programme_type'])) {
                                                                                                        if ($searchdata['incomplete_user_programme_type'] == $cour->ss_aw_course_id) { ?> selected <?php }
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
                            <a href="<?= base_url(); ?>export/export_institution_module_wise_incomplete_performance/<?= $institution_id; ?>/<?= @$searchdata['incomplete_user_programme_type'] ?>/1" class="btn btn-success align-middle"><i class="mdi mdi-file-excel"></i>Export</a>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Diagnostic Quiz</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center"><a href="<?= $diagnosticincompletenum == 0 ? 'javascript:void(0)' : base_url('institution/diagnostic_incomplete_users/' . $institution_details->ss_aw_id . '/' . base64_encode(implode(",", $diagnosticincompletechilds))) ?>"><?= $diagnosticincompletenum; ?></a></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $carry = 0;
                                            $arr_key = array_search("", array_column($getdata, 'ss_aw_lession_id'));

                                            if ($arr_key == '0') {
                                                $lessonnotcompleted = $getdata["$arr_key"]['lessonnotcompleted'];
                                                $lessonnotcompletedchild = $getdata["$arr_key"]['lessonnotcompletedchild'];
                                                $assessmentnotcompleted = $getdata["$arr_key"]['assessmentnotcompleted'];
                                                $assessmentnotcompletedchild = $getdata["$arr_key"]['assessmentnotcompletedchild'];
                                            } else {
                                                $lessonnotcompleted = 0;
                                                $lessonnotcompletedchild = 0;
                                                $assessmentnotcompleted = 0;
                                                $assessmentnotcompletedchild = 0;
                                            }
                                            $i = 0;
                                            if (!empty($topics)) {
                                                foreach ($topics as $key => $value) {
                                                    $dat = getlastlessondata($institution_id, $value['ss_aw_lession_id'], $searchdata['incomplete_user_programme_type']);

                                                    $arr_key = '';
                                                    $lesson_id = $value['ss_aw_lession_id'];
                                                    $arr_key = array_search($lesson_id, array_column($getdata, 'ss_aw_lession_id'));


                                            ?>
                                                    <tr>
                                                        <td><?= $value['ss_aw_lesson_topic']; ?></td>
                                                        <td><?= $key + 1; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($dat == 0) {
                                                                echo "NA";
                                                            } else {
                                                                $lessonnotcomp = $lessonnotcompleted != 0 ? $getdata["$arr_key"]['lessonnotcompleted'] + $lessonnotcompleted : $getdata["$arr_key"]['lessonnotcompleted'];
                                                                $lessonchild = $lessonnotcompleted != 0 ? $getdata["$arr_key"]['lessonnotcompletedchild'] . ',' . $lessonnotcompletedchild : $getdata["$arr_key"]['lessonnotcompletedchild'];
                                                            ?>
                                                                <a href="<?= $dat == 0 ? 'javascript:void(0)' : base_url('institution/lesson_incomplete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($carry != 0 ? $carry_child . ',' . $lessonchild : $lessonchild)) ?>"><?= $carry + $lessonnotcomp; ?></a>
                                                            <?php
                                                            }
                                                            ?>

                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($dat == 0) {
                                                                echo "NA";
                                                            } else {
                                                                $assesonnotcomp = $assessmentnotcompleted != 0 ? $getdata["$arr_key"]['assessmentnotcompleted'] + $assessmentnotcompleted : $getdata["$arr_key"]['assessmentnotcompleted'];
                                                                $assesonchild = $assessmentnotcompleted != 0 ? $getdata["$arr_key"]['assessmentnotcompletedchild'] . ',' . $assessmentnotcompletedchild : $getdata["$arr_key"]['assessmentnotcompletedchild'];
                                                            ?>
                                                                <a href="<?= $dat == 0 ? 'javascript:void(0)' : base_url('institution/assessment_incomplete_users/' . $institution_details->ss_aw_id . '/' . base64_encode($carry != 0 ? $carry_child . ',' . $assesonchild : $assesonchild)) ?>"><?= $carry + $assesonnotcomp; ?></a>
                                                            <?php
                                                            }
                                                            ?>

                                                        </td>
                                                    </tr>
                                            <?php
                                                    $carry = 0;
                                                    $carry_child = '';
                                                    $carry = $getdata["$arr_key"]['nextadd'];
                                                    $carry_child = $getdata["$arr_key"]['nextaddchild'];
                                                    $lessonnotcompleted = 0;
                                                    $lessonnotcompletedchild = '';
                                                    $assessmentnotcompleted = 0;
                                                    $assessmentnotcompletedchild = '';
                                                    $i++;
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
                </div><!-- end col-->
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