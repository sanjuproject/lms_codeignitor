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
        <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/view_institution/<?=$institution_details->ss_aw_id?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/manageinstitutionusers/<?=$institution_details->ss_aw_id?>">Manage Users</a></li>
                            <li class="breadcrumb-item">Edit User</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Manage Institution Users</h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <a href="<?= base_url(); ?>diagnostic/manage_institutions" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH . "views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="formWrapper" id="masters-form-fields">
                                <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>diagnostic/edit_user">
                                    <input type="hidden" name="parent_id" value="<?= $child_details[0]->ss_aw_parent_id; ?>">
                                    <input type="hidden" name="user_id" value="<?= $child_details[0]->ss_aw_child_id; ?>">
                                    <input type="hidden" name="institution_id" value="<?= $institution_details->ss_aw_id; ?>">
                                    <input type="hidden" name="program_type" value="5">
                                    <input type="hidden" name="pageno" value="<?= $page; ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="firstname">First Name<span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input class="form-control " type="text" name="firstname" id="firstname" placeholder="Enter first name" required="" parsley-type="firstname" value="<?= $child_details[0]->ss_aw_child_first_name; ?>">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input class="form-control " type="text" name="lastname" id="lastname" placeholder="Enter last name" required="" parsley-type="lastname" value="<?= $child_details[0]->ss_aw_child_last_name; ?>">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nickname">Nick Name<span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input class="form-control " type="text" name="nickname" id="nickname" placeholder="Enter last name" required="" parsley-type="nickname" value="<?= $child_details[0]->ss_aw_child_nick_name; ?>">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="dob">Gender <span class="text-danger">*</span></label>
                                                <div class="terget-audience-radio">
                                                    <div class="radio radio-primary mr-2">
                                                        <input type="radio" name="master_gender" id="master_male" value="1" required data-parsley-multiple="master_gender" <?= $child_details[0]->ss_aw_child_gender == 1 ? "checked" : ""; ?>>
                                                        <label for="master_male">
                                                            Male
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input type="radio" name="master_gender" id="master_female" value="2" required data-parsley-multiple="master_gender" <?= $child_details[0]->ss_aw_child_gender == 2 ? "checked" : ""; ?>>
                                                        <label for="master_female">
                                                            Female
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-sm-6">


                                            <div class="form-group">
                                                <label for="emailaddress">User Email <span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input type="email" class="form-control " name="email" id="emailaddress" required="" parsley-type="email" placeholder="Enter email" value="<?= $child_details[0]->ss_aw_child_email; ?>">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <div class="verification-parent">
                                                    <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" data-parsley-minlength="8">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmpassword">Confirm Password</label>
                                                <div class="verification-parent">
                                                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again">
                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="text-left">
                                            <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save">
                                            <a class="btn btn-danger waves-effect waves-light m-l-10" href="<?= base_url(); ?>diagnostic/manageinstitutionusers/<?= $this->uri->segment(3); ?>">Cancel</a>
                                        </div>
                                    </div>
                                </form>
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