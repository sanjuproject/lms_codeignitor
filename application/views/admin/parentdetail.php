<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/manageparents">Manage Parents</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/parentdetail/<?= $parent_id; ?>"><?= $parent_details[0]->ss_aw_parent_full_name; ?></a></li>

                        </ol>
                    </div>
                </div>
            </div>

            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="row parent-details-body">

                                <div class="col-4">
                                    <?php
                                    if (!empty($paymentstatus) && $paymentstatus['payment_status'] != 0) {
                                        ?>
                                        <h4 class="details-title">Parent Name: <a href="<?= base_url(); ?>admin/self_course_details/<?= $self_child_registration->ss_aw_parent_id; ?>/<?= $self_child_registration->ss_aw_child_id; ?>"><span><?= $parent_details[0]->ss_aw_parent_full_name; ?></span></a></h4>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <h4 class="details-title">Parent Name: <span><?= $parent_details[0]->ss_aw_parent_full_name; ?></span></h4>
                                        <?php
                                    }
                                    ?>
                                    
                                    <h4 class="details-title">Date of app signup: <span><?= date('d/m/Y', strtotime($parent_details[0]->ss_aw_parent_created_date)); ?></span></h4>
                                    <?php
                                    {
                                        ?>
                                        <h4 class="details-title">
                                            Payment Status: 
                                        <?php
                                            if ($paymentstatus['payment_status'] == 1){
                                            ?>
                                                <a href="#" class="badge badge-soft-success">Paid</a>
                                                <a href="javascript:void(0)" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-status-modal" data-child="<?= $self_child_registration->ss_aw_child_id; ?>">Mark as Unpaid</a>
                                            <?php
                                            }
                                            elseif ($paymentstatus['payment_status'] == 2 && $course_id!=5){
                                                if (ADVANCED_EMI_DURATION == $paymentstatus['emi_count']) {
                                                ?>
                                                    <a href="#" class="badge badge-soft-success">Paid</a>
                                                    <a href="javascript:void(0)" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-status-modal" data-child="<?= $self_child_registration->ss_aw_child_id; ?>">Mark as Unpaid</a>
                                                <?php
                                                }
                                                else{
                                                ?>
                                                    <a href="#" class="badge badge-soft-danger" data-toggle="modal"data-target="#payment-modal">Mark As Pay ( <?= $paymentstatus['emi_count']; ?> / <?= ADVANCED_EMI_DURATION; ?>)</a>
                                                <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                <a href="#" class="badge badge-soft-danger" data-toggle="modal" data-target="#payment-modal">Mark As Pay</a>
                                                <?php
                                            }
                                        ?>
                                        </h4>
                                        <?php
                                    }
                                    ?>
                                    
                                </div>

                                <div class="col-4">
                                    <h4 class="details-title">Number of children registered: <span><?= count($child_details); ?></span></h4>
                                    <h4 class="details-title">Type of device: <span><?= $parent_details[0]->ss_aw_device_type; ?></span></h4>
                                </div>

                                <div class="col-4">
                                    <h4 class="details-title">Name of Children</h4>
                                    <ul class="children_name">
                                        <?php
                                        if (!empty($child_details)) {
                                            foreach ($child_details as $key => $value) {
                                        ?>
                                                <li>
                                                    <a href="<?= base_url(); ?>admin/child_course_details/<?= $parent_details[0]->ss_aw_parent_id ?>/<?= $value->ss_aw_child_id; ?>"><?= $value->ss_aw_child_nick_name; ?></a>
                                                </li>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <li>No Data</li>
                                        <?php
                                        }
                                        ?>
                                        <li>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#add-child-modal" class="text-danger">Add Child</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>


        </div> <!-- container -->

    </div> <!-- content -->

    <!-- add parent child -->
    <div class="modal fade" id="add-child-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog customewidth modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Child</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body p-4">
                    <form action="<?php echo base_url(); ?>admin/add_child" class="parsley-examples" method="post" id="demo-form">
                        <input type="hidden" name="parent_id" value="<?= $this->uri->segment(3); ?>">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="firstname">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First name" required>
                                </div>

                                <div class="form-group">
                                    <label for="lastname">Last Name <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of birth <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input id="date_of_birth" name="date_of_birth" type="text" class="form-control" data-toggle="flatpicker" placeholder="Date of birth" required readonly>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Gender <span class="text-danger">*</span></label>
                                    <div class="terget-audience-radio">
                                        <div class="radio radio-primary mr-2">
                                            <input type="radio" name="rad_gender" id="rad_male" value="1" required  data-parsley-multiple="rad_gender">
                                            <label for="rad_male">
                                                Male
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <input type="radio" name="rad_gender" id="rad_female" value="2" required  data-parsley-multiple="rad_gender">
                                            <label for="rad_female">
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="city">User Id <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control" name="userid" id="userid" required parsley-type="userid" placeholder="Enter user id" />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="email" class="form-control" name="email" onblur="check_email(this.value);" id="emailaddress" required parsley-type="email" placeholder="Enter email" />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="password" id="password" required parsley-type="password" placeholder="Enter password" data-parsley-minlength="8"
                                        data-parsley-required-message="Please enter your new password."
                                        data-parsley-uppercase="1"
                                        data-parsley-lowercase="1"
                                        data-parsley-number="1"
                                        data-parsley-special="1"
                                        data-parsley-required/>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="password" id="confirmpassword" required parsley-type="confirm_password" placeholder="Enter password again" data-parsley-minlength="8"
                                        data-parsley-errors-container=".errorspanconfirmnewpassinput"
                                        data-parsley-required-message="Please re-enter your new password."
                                        data-parsley-equalto="#password"
                                        data-parsley-required/>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-left">
                            <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save" />
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Mark as payment modal -->
            <div id="payment-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <h4 class="mt-2">Make Payment</h4>
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>admin/mark_payment_for_masters" method="post">
                                        <input type="hidden" name="payment_parent_id" id="payment_parent_id" value="<?= $parent_details[0]->ss_aw_parent_id; ?>">
                                        <div class="form-group">
                                            <label>Transaction ID</label>
                                            <input type="text" name="transaction_id" id="transaction_id" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Payment Amount</label>
                                            <input type="text" name="payment_amount" id="payment_amount" class="form-control" required>
                                        </div>
                                        <!-- <div class="form-group">
                                            <input type="checkbox" name="emi_payment" value="1" id="emi_payment"><label for="promoted">Emi Payment</label>
                                        </div>     -->
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
    <!-- end add child -->
    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3" id="status_warning_msg">Do you want to mark this user as unpaid?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url() ?>admin/unpaid_user" method="post">
                                <input type="hidden" id="child_id" name="child_id">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>    
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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

<style type="text/css">
    .verification-parent {
        position: relative;
    }

    .verification-btn {
        position: absolute;
        top: 7px;
        right: 1px;
        background: #fff;
        padding: 0px 8px;

    }

    input:disabled,
    select:disabled {
        /* background: #e6e6e6; */
        color: #d5dade;
    }
</style>


<?php
include('footer.php')
?>

<script type="text/javascript">
    function tenYearsBack(date, years) {
      date.setFullYear(date.getFullYear() - years);
      return date;
    }
    function make_payment(child_id, emi_payment){
        document.getElementById('payment_child_id').value = child_id;
    }
    $("#date_of_birth").flatpickr({
        dateFormat: "F d, Y", //defaults to "F Y"
        changeMonth: true,
        changeYear: true,
        minDate: tenYearsBack(new Date(), 18),
        maxDate: tenYearsBack(new Date(), 10)

    });

    $('#warning-status-modal').on('show.bs.modal', function(e) {
        var child_id = $(e.relatedTarget).data('child');
        $("#child_id").val(child_id);
    });
</script>

</body>

</html>