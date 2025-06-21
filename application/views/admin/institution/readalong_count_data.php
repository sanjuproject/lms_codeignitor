<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">

</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>">Report Dashboard</a></li>
                            <li class="breadcrumb-item"><?= $title ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples"><?= $title ?></h4>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <form method="post" id="demo-form" action="<?= base_url('admin/readalog_count/' . $this->uri->segment(3)); ?>">
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
                                                    <option value="<?= $cour->ss_aw_course_id ?>" <?php
                                                                                                    if (!empty($searchdata['programme_type'])) {
                                                                                                        if ($searchdata['programme_type'] ==  $cour->ss_aw_course_id) {
                                                                                                    ?> selected <?php
                                                                                                        }
                                                                                                    }
                                                                ?>><?= $cour->ss_aw_course_nickname ?></option>

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
                    <div class="btn-container pt-3 pl-2">
                        <a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                    </div>

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
                                <h4 class="text-center">Total users: <?= count($childs); ?> (No. of users: <?= $no_users; ?>, No. of ReadAlongs: <?= $readalongs; ?>)</h4>
                                <div class="table-responsive gridview-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Readalong Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $child_no = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
                                            foreach ($childs as $key => $value) {
                                                $child_no++;
                                                $child_id = $value->ss_aw_child_id;
                                            ?>
                                                <tr>
                                                    <td><?= $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name; ?></td>
                                                    <td><?php if ($value->count_readalong != '') { ?>
                                                            <a href="<?= base_url("admin/getallreadalongdata/$child_id/$institution_details->ss_aw_id") ?>" target="_blank"><?= $value->count_readalong ?></a>
                                                        <?php
                                                        } else {
                                                            echo 0;
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
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