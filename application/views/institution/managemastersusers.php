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
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Manage Institution Users</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <!-- <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#add-user-modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Institution User</a> -->

                                    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal1-import-adults"><i class="mdi mdi-plus-circle mr-2"></i>Import Bulk Users</a>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-8">
                                    <a href="<?= base_url(); ?>institution/manage_users" class="btn btn-light mb-2"><?= Winners ?></a>

                                    <a href="<?= base_url(); ?>institution/manage_master_users" class="btn btn-primary mb-2"><?= Master ?>s</a>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url() ?>institution/manage_master_users" method="post" id="filter-form">
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="text" name="search_data" class="form-control" placeholder="Search..." aria-label="Recipient's username"
                                                        <?php
                                                        if (isset($search_data)) {
                                                            echo 'value="' . $search_data . '"';
                                                        }
                                                        ?>>
                                                    <input type="hidden" name="search_parent" value="search_parent">
                                                    <div class="input-group-append" style="position:relative;">
                                                        <?php
                                                        if (!empty($search_data)) {
                                                        ?>
                                                            <div style="position: absolute; right: 20; left: -25px; padding: 8px; cursor: pointer;">
                                                                <i class="fas fa-times" style="cursor: pointer;" onclick="resetsearch();"></i>
                                                            </div>

                                                        <?php
                                                        }
                                                        ?>
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
                                            <th class="childrencol" style="text-align: center;">Completed<br />L | A | R</th>
                                            <th>Report Card</th>
                                            <th>Status</th>
                                            <th class="actioncol">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        foreach ($child_details as $key => $value) {
                                            $parent_id = $value->ss_aw_parent_id;
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    if (!empty($course_details[$value->ss_aw_child_id]->course)) {
                                                    ?>
                                                        <a href="<?= base_url(); ?>institution/user_course_details/<?= $value->ss_aw_parent_id ?>/<?= $value->ss_aw_child_id; ?>/<?= $page; ?>/2"><?= $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name; ?></a>
                                                    <?php
                                                    } else {
                                                        echo $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $value->ss_aw_child_email; ?></td>
                                                <td><?= Master ?>s</td>
                                                <td><?= $diagnosticexamdate[$value->ss_aw_child_id] ? $diagnosticexamdate[$value->ss_aw_child_id] : "NA"; ?></td>
                                                <td>
                                                    <?= $diagnostictotalquestion[$value->ss_aw_child_id] > 0 ? $diagnosticcorrectquestion[$value->ss_aw_child_id] . '/' . $diagnostictotalquestion[$value->ss_aw_child_id] : 'NA'; ?>
                                                </td>
                                                <td class="table-children">
                                                    <?=
                                                    $lessoncount[$value->ss_aw_child_id] == 0 ? "NA" : $lessoncount[$value->ss_aw_child_id]; ?>|<?= $assessmentcount[$value->ss_aw_child_id] == 0 ? "NA" : $assessmentcount[$value->ss_aw_child_id]; ?>|<?= $readalongcount[$value->ss_aw_child_id] == 0 ? "NA" : $readalongcount[$value->ss_aw_child_id];
                                                                                                                                                                                                                                                        ?>
                                                </td>

                                                <td>NA</td>
                                                <td>
                                                    <?php
                                                    if (!empty($course_details[$value->ss_aw_child_id]->course)) {
                                                        if ($value->ss_aw_child_status == 1) {
                                                    ?>
                                                            <span class="badge badge-soft-success">Active</span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="badge badge-soft-danger">Inactive</span>
                                                        <?php
                                                        }

                                                        if ($value->ss_aw_blocked == 1) {
                                                        ?>
                                                            <span class="badge badge-soft-danger">Block</span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="badge badge-soft-success">Unblock</span>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "NA";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="actioncell">
                                                    <a href="<?= base_url(); ?>institution/edit_user/<?= $value->ss_aw_child_id ?>/<?= $this->uri->segment(3); ?>" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                    <?php
                                                    if (empty($course_details[$value->ss_aw_child_id]->course)) {
                                                    ?>
                                                        <a onclick="parent_delete(<?= $value->ss_aw_child_id; ?>)" href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"> <i class="mdi mdi-delete"></i></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="badge badge-soft-success">Enrolled</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                            $sl++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-right">
                        <ul class="pagination pagination-rounded justify-content-end">
                            <!-- Show pagination links -->
                            <?php foreach ($links as $link) {
                                echo "<li>" . $link . "</li>";
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>



        </div> <!-- container -->

    </div> <!-- content -->
    <!-- Delete confirmation dialog -->
    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Deleting will remove this user from the system. Are you sure ?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url() ?>institution/removeuser" method="post">
                                <input type="hidden" name="parent_delete_process" value="parent_delete_process">
                                <input type="hidden" name="parent_delete_id" id="parent_delete_id">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- add parent modal -->
    <div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog customewidth modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Institution User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dob">Programme type <span class="text-danger">*</span></label>
                                <div class="terget-audience-radio">
                                    <div class="radio radio-primary mr-2">
                                        <input type="radio" name="rad_programme_type" id="rad_programme_winners" value="1" required onchange="showFields('winners-form-fields')">
                                        <label for="rad_programme_winners">
                                            <?= Winners ?>
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <input type="radio" name="rad_programme_type" id="rad_programme_masters" value="2" required onchange="showFields('masters-form-fields')">
                                        <label for="rad_programme_masters">
                                            <?= Master ?>s
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="formWrapper" id="winners-form-fields" style="display: none;">
                        <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>institution/add_institution_single_student">
                            <input type="hidden" name="program_type" value="1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name<span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control " type="text" name="firstname" id="firstname" placeholder="Enter first name" required="" parsley-type="firstname">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control " type="text" name="lastname" id="lastname" placeholder="Enter last name" required="" parsley-type="lastname">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="userid">User Id<span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control " type="text" name="userid" id="userid" placeholder="Enter user id" required="" parsley-type="userid">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="date_of_birth">Date of birth <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input id="date_of_birth" name="date_of_birth" type="text" class="form-control" data-toggle="flatpicker" placeholder="Date of birth" required readonly>

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="dob">Gender <span class="text-danger">*</span></label>
                                        <div class="terget-audience-radio">
                                            <div class="radio radio-primary mr-2">
                                                <input type="radio" name="rad_gender" id="rad_male" value="1" required data-parsley-multiple="rad_gender">
                                                <label for="rad_male">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input type="radio" name="rad_gender" id="rad_female" value="2" required data-parsley-multiple="rad_gender">
                                                <label for="rad_female">
                                                    Female
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="email" class="form-control " name="email" id="emailaddress" required="" parsley-type="email" placeholder="Enter email">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again" data-parsley-minlength="8" data-parsley-errors-container=".errorspanconfirmnewpassinput" data-parsley-required-message="Please re-enter your new password." data-parsley-equalto="#password" data-parsley-required="">
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="text-left">
                                    <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save">
                                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="formWrapper" id="masters-form-fields" style="display: none;">
                        <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>institution/add_institution_single_student">
                            <input type="hidden" name="program_type" value="5">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name<span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control " type="text" name="firstname" id="firstname" placeholder="Enter first name" required="" parsley-type="firstname">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control " type="text" name="lastname" id="lastname" placeholder="Enter last name" required="" parsley-type="lastname">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Gender <span class="text-danger">*</span></label>
                                        <div class="terget-audience-radio">
                                            <div class="radio radio-primary mr-2">
                                                <input type="radio" name="master_gender" id="master_male" value="1" required data-parsley-multiple="master_gender">
                                                <label for="master_male">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input type="radio" name="master_gender" id="master_female" value="2" required data-parsley-multiple="master_gender">
                                                <label for="master_female">
                                                    Female
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Confirm age <span class="text-danger">*</span></label>
                                        <div class="terget-audience-radio">
                                            <div class="checkbox radio-primary mr-2">
                                                <input type="checkbox" name="chk_confirm" id="chk_confirm" value="1" required>
                                                <label for="chk_confirm">
                                                    18+
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6">


                                    <div class="form-group">
                                        <label for="emailaddress">User Email <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="email" class="form-control " name="email" id="emailaddress" required="" parsley-type="email" placeholder="Enter email">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="">

                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again">
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="text-left">
                                    <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save">
                                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- end add parent -->

    <div class="modal fade" id="modal1-import-adults" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Import Bulk Users</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">
                    <form action="<?php echo base_url(); ?>institution/import_bulk_users" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="dob">Programme type <span class="text-danger">*</span></label>
                            <div class="terget-audience-radio">
                                <div class="radio radio-primary mr-2">
                                    <input type="radio" name="programme_type" id="bulk_programme_winners" value="1" required onclick="selectProgramType(1)">
                                    <label for="bulk_programme_winners">
                                        <?= Winners ?>
                                    </label>
                                </div>
                                <div class="radio radio-primary">
                                    <input type="radio" name="programme_type" id="bulk_programme_masters" value="2" required onclick="selectProgramType(2)">
                                    <label for="bulk_programme_masters">
                                        <?= Master ?>s
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Title of the file</label>
                                <input type="text" name="file_name" id="file_name" required class="form-control">
                                <h6>Example : LumsumofJan2023user.</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="select-code-language">Upload Template<span
                                        class="text-danger">*</span></label><br />
                                <input name="file" type="file" data-plugins="dropify" data-height="100" required />
                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                <h6>Note : Only Excel file format allowed. <a id="template_link" href="">Sample Template</a> file found here.</h6>
                            </div>
                        </div>
                        <!-- <div class="form-group col-md-12">
                            <label for="select-code-language">Upload Template<span class="text-danger">*</span></label><br/>
                            <button type="button" class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload 
                            <input name="file" type="file" id="fileUploadAgain" required>
                            </button><span id="lblFileName" class="lblFileName">No file selected</span>
                            <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                        </div> -->

                        <div class="text-left">
                            <button type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
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
<script type="text/javascript">
    function change_status(parent_id, parent_status) {
        if (parent_status == 1) {
            parent_status = 0;
        } else {
            parent_status = 1;
        }
        document.getElementById('status_parent_status').value = parent_status;
        document.getElementById('status_parent_id').value = parent_id;
        var pageno = "<?= $this->uri->segment(3) ? $this->uri->segment(3) : ''; ?>";
        $("#status_pageno").val(pageno);

    }

    function parent_delete(parent_id) {
        document.getElementById('parent_delete_id').value = parent_id;
    }

    function parent_logout(parent_id) {
        document.getElementById('logout_parent_id').value = parent_id;
    }

    function showFields(val) {
        $('.formWrapper').hide();
        $('#' + val).show();
    }

    function resetsearch() {
        $("input[name='search_data']").val('');
        $("#filter-form").submit();
    }

    function selectProgramType(programType) {
        let template_link = "<?= base_url(); ?>assets/templates/";
        if (programType == 1) {
            template_link = template_link + "institution_users.xlsx";
        } else {
            template_link = template_link + "institution_master_users.xlsx";
        }
        $("#template_link").attr('href', template_link);
    }
</script>

</body>

</html>