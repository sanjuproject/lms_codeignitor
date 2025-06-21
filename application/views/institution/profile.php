<!-- Cropper css -->
<link href="<?php echo base_url();?>css/croppie.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/imageCropModal.css" rel="stylesheet" type="text/css" />
    <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                <?php include("error_message.php");?>

                    <div class="row">

                        <div class="col-lg-3">

                        </div> <!-- end col -->

                        <div class="col-lg-6">
                            <div class="card-box">


                                <?= form_open_multipart(base_url('institution/profile'),array('id' => 'demo-form','class'=>'parsley-examples')) ?>

                                    <!-- <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="fullname" value="<?php echo $institution_admin_details[0]->ss_aw_parent_full_name;?>" data-parsley-maxlength="320" required placeholder="Full Name" />
                                    </div>

                                    <div class="form-group">
                                        <label>E-Mail</label>
                                        <div class="verification-parent">
                                            <input type="hidden" id="email_verified" value="1" />
											<input type="hidden" id="userid" name="userid" value="<?php echo $institution_admin_details[0]->ss_aw_parent_id;?>" />
											<input type="hidden" id="old_email" name="old_email" value="<?php echo $institution_admin_details[0]->ss_aw_parent_email;?>" />
											<input type="email" name="email" id="email" class="form-control" value="<?php echo $institution_admin_details[0]->ss_aw_parent_email;?>" required parsley-type="email"
                                                data-parsley-maxlength="320" placeholder="e-mail" onblur="checkemail(this.value);" />
                                                <div class="verification-btn">
                                                <a href="javascript:void(0);" onclick="sendverificationcode();" id="email_verify" style="display:none;" class="badge badge-soft-warning">Need Verifification</a>
                                                </div>

                                        </div>
                                    </div> -->

                                    <input type="hidden" name="institution_id" value="<?= $institution_details->ss_aw_id; ?>">
                                    <input type="hidden" name="admin_id" value="<?= $institution_admin_details[0]->ss_aw_parent_id; ?>">
                                    <div class="form-group">
                                        <label>Phone No</label>
                                        <input type="text" class="form-control" name="phone_no" value="<?= $institution_details->ss_aw_mobile_no;?>" required placeholder="Phone no" data-toggle="input-mask" data-mask-format="0000000000" maxlength="10"/>
                                    </div>

                                    <div class="form-group">
                                        <label>PAN No</label>
                                        <input type="text" class="form-control" name="pan_no" value="<?= $institution_details->ss_aw_pan_no;?>" placeholder="Full Name"  data-parsley-pattern="^[A-Z]{5}\d{4}[A-Z]$" onkeyup="this.value = this.value.toUpperCase();"/>
                                    </div>

                                    <div class="form-group">
                                        <label>GST No</label>
                                        <input type="text" class="form-control" name="gst_no" value="<?= $institution_details->ss_aw_gst_no;?>" placeholder="Full Name" data-parsley-pattern="^\d{2}[A-Z]{5}\d{4}[A-Z][1-9a-zA-Z]Z([a-zA-Z]|[0-9])$" onkeyup="this.value = this.value.toUpperCase();"/>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input name="password" type="password" id="pass1" class="form-control" style="width: 100%;" placeholder="Enter your password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text" style="position: absolute;top: 0px;right: 0px;z-index: 99;">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Re-Enter Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" data-parsley-equalto="#pass1" class="form-control" style="width: 100%;" placeholder="Re-Enter Password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text" style="position: absolute;top: 0px;right: 0px;z-index: 99;">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0">
                                        <div>
                                            <button type="submit" class="btn btn-blue waves-effect waves-light verify" style="background-color: #3283f6;margin-right:10px;">
                                                Submit
                                            </button>
                                            <a href="<?= base_url(); ?>admin/dashboard" class="btn btn-danger waves-effect m-l-5">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- end card-box -->
                        </div> <!-- end col-->

                        <div class="col-lg-3">

                        </div> <!-- end col -->
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->


   

            <?php
include 'bottombar.php';
?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!--Take from here --->
    <!--Take from here --->
    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#custom-modal"><i
            class="mdi mdi-plus-circle mr-2"></i> Add New</a>

    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#custom-modal2"><i
            class="mdi mdi-plus-circle mr-2"></i> Add New 2</a>
    <!-- Modal -->
    <div class="modal fade" id="modal1-verify1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Enter the code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">

                    <form action="#" class="parsley-examples" id="demo-form-modal1-verify1">

                        <div class="verify-title form-group container">

                            <!-- <ul class="parsley-errors-list filled" id="parsley-id-53" aria-hidden="false">
                                <li class="parsley-required">This value is required.</li>
                            </ul> -->
                            <div class="verify-form-group mb-2 mt-4">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify1" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify2" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify3" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify4" maxlength="1">
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="text-center mb-2">
                            <button type="button" onclick="verify_email();" class="btn btn-success waves-effect waves-light">Verify</button>

                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal2-verify1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal2">Enter the code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="mt-0">

                    <div class="progress progress-sm m-0" style="height: 2px;">
                        <div class="progress-bar bg-success resendprogress" role="progressbar" aria-valuenow="95" aria-valuemin="0"> </div>
                    </div>

                </div>
                <div class="modal-body p-2">

                    <form action="#" class="parsley-examples" id="demo-form-modal2">

                        <div class="verify-title form-group container-modal-second">

                          
                            <!-- <h6> <span class="float-right">60 Seconds</span></h6> -->
                            <div class="verify-form-group mb-2 mt-4 ">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify1" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify2" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify3" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify4" maxlength="1">

                            </div>
                            <a href="javascript:void(0);" onclick="reset_sendverificationcode_phone();" class="btn-resend-otp">Resend OTP</a>
                        </div>
                        <!-- form-group -->
                        <div class="text-center mb-2">
                            <button type="button" onclick="verify_phone();" class="btn btn-success waves-effect waves-light">Verify</button>

                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	<div class="modal fade" id="modal1-message" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Error Message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">

                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

	<?php
            include('footer.php')
        ?>
        <!-- Validation init js-->
<script src="<?php echo base_url();?>assets/js/custom_script.js"></script>		
<style type="text/css">
.dropify-wrapper .dropify-message p{
    line-height: 50px;
}
.verification-parent{
    position: relative;
}
.verification-btn{
    position: absolute;
    top: 7px;
    right: 1px;
    background: #fff;
    padding: 0px 8px;
}
.parsley-error {
    border-color: #f1556c;
}
.modal{
    z-index: 9999;
}
.custom-content{
    width: 100%;
}
</style>
</body>
</html>
	