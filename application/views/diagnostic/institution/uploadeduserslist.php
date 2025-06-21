<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .notification-wrapper .mdi-bell {
        font-size: 1.2rem;
        color: #fc6352 !important;
        position: relative;
        top: -4px;
    }

    .notification-wrapper .mdi-bell span {
        font-size: 10px;
        color: #fff;
        position: absolute;
        left: 0;
        right: 0;
        top: 3px;
        text-align: center;
        font-style: normal;
    }

    .panel-heading-nav {
        border-bottom: 0;
        padding: 10px 0 0;
    }

    .panel-heading-nav .nav {
        padding-left: 10px;
        padding-right: 10px;
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
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>institution/manage_payment">Manage Payment</a></li>
                            <li class="breadcrumb-item">User details of <?= $user_upload_details->ss_aw_upload_file_name; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Manage Institution Users</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH . "views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <a href="<?= base_url(); ?>institution/manage_payment" class="btn btn-danger mb-2"><i class="mdi mdi-arrow-left-bold-circle mr-2"></i> Go Back</a>
                                </div>
                            </div>

                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="namecol">User Name</th>
                                            <th class="emailcol">Email</th>
                                            <th class="mobilecol">Course Name</th>
                                            <th>Start Date</th>
                                            <th>Diagnostic</th>
                                            <th>Report Card</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        if (!empty($child_details)) {
                                            foreach ($child_details as $key => $value) {
                                                $parent_id = $value->ss_aw_parent_id;
                                        ?>
                                                <tr>
                                                    <td><?= $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name; ?></td>
                                                    <td><?= $value->ss_aw_child_email; ?></td>
                                                    <td><?php echo Diagnostic; ?></td>
                                                    <td><?= $course_details[$value->ss_aw_child_id]->course_start_date ? date('d/m/Y', strtotime($course_details[$value->ss_aw_child_id]->course_start_date)) : "NA"; ?></td>
                                                    <td>
                                                        <?= $diagnostictotalquestion[$value->ss_aw_child_id] > 0 ? $diagnosticcorrectquestion[$value->ss_aw_child_id] . '/' . $diagnostictotalquestion[$value->ss_aw_child_id] : 'NA'; ?>
                                                    </td>

                                                    <td>NA</td>
                                                </tr>
                                            <?php
                                                $sl++;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;font-size:15px;font-weight:500;">No Record Found</td>
                                            </tr>
                                        <?php   }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div> <!-- container -->

    </div> <!-- content -->

    <?php
    include(APPPATH . 'views/diagnostic/bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->
<?php
include(APPPATH . 'views/diagnostic/footer.php')
?>

</body>

</html>