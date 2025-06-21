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
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Manage Institution Users</h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <?php
                    if (empty($self_details)) {
                        ?>
                        <a href="<?= base_url(); ?>institution/manage_users" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                        <?php  
                    }
                    else{
                        ?>
                        <a href="<?= base_url(); ?>institution/manage_master_users" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <?php
                            if (empty($self_details)) {
                                ?>
                                <div class="formWrapper" id="winners-form-fields">
                                    <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>institution/edit_user">
                                        <input type="hidden" name="user_id" value="<?= $child_details[0]->ss_aw_child_id; ?>">
                                        <input type="hidden" name="program_type" value="1">
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
                                                <label for="userid">User Id<span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input readonly class="form-control " type="text" name="userid" id="userid" placeholder="Enter user id" required="" parsley-type="userid" value="<?= $child_details[0]->ss_aw_child_username; ?>">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="date_of_birth">Date of birth <span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input id="date_of_birth" name="date_of_birth" type="text" class="form-control" data-toggle="flatpicker" placeholder="Date of birth" required readonly value="<?= $child_details[0]->ss_aw_child_dob; ?>">

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
                                                        <input type="radio" name="rad_gender" id="rad_male" value="1" required data-parsley-multiple="rad_gender" <?= $child_details[0]->ss_aw_child_gender == 1 ? "checked" : ""; ?>>
                                                        <label for="rad_male">
                                                            Male
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input type="radio" name="rad_gender" id="rad_female" value="2" required data-parsley-multiple="rad_gender" <?= $child_details[0]->ss_aw_child_gender == 2 ? "checked" : ""; ?>>
                                                        <label for="rad_female">
                                                            Female
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                                <div class="verification-parent">
                                                    <input type="email" class="form-control " name="email" id="emailaddress" required="" parsley-type="email" placeholder="Enter email" value="<?= $child_details[0]->ss_aw_child_email; ?>">

                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <div class="verification-parent">
                                                    <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1">
                                                    
                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmpassword">Confirm Password</label>
                                                <div class="verification-parent">
                                                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again" data-parsley-minlength="8" data-parsley-errors-container=".errorspanconfirmnewpassinput" data-parsley-required-message="Please re-enter your new password." data-parsley-equalto="#password">
                                                    <div class="verification-btn error_msg">

                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="text-left">
                                            <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save">
                                            <a class="btn btn-danger waves-effect waves-light m-l-10" href="<?= base_url(); ?>institution/manage_users">Cancel</a>
                                        </div>
                                        </div>
                                        </form>
                                    </div>
                                <?php
                            }
                            else{
                                ?>
                                <div class="formWrapper" id="masters-form-fields">
                                    <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>institution/edit_user">
                                        <input type="hidden" name="parent_id" value="<?= $child_details[0]->ss_aw_parent_id; ?>">
                                        <input type="hidden" name="user_id" value="<?= $child_details[0]->ss_aw_child_id; ?>">
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
                                            <a class="btn btn-danger waves-effect waves-light m-l-10" href="<?= base_url(); ?>institution/manage_master_users">Cancel</a>
                                        </div>
                                    </div>
                                        </form>
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
                                               <?= Winners?>
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <input type="radio" name="rad_programme_type" id="rad_programme_masters" value="2" required onchange="showFields('masters-form-fields')">
                                            <label for="rad_programme_masters">
                                                <?=Master?>s
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
                                        <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="" >
                                        
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again" data-parsley-minlength="8" data-parsley-errors-container=".errorspanconfirmnewpassinput" data-parsley-required-message="Please re-enter your new password." data-parsley-equalto="#password" data-parsley-required="" >
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
                                            <input type="checkbox" name="chk_confirm" id="chk_confirm" value="1" required >
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
                                        <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="" >
                                        
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