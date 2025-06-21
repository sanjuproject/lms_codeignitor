<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .details-title label {
        width: 150px;
    }
    .details-title span {font-weight: normal;}
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Institution Name: <?= $institution_details->ss_aw_name; ?></h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <a href="<?= base_url(); ?>admin/update_institutions/<?= $institution_details->ss_aw_id; ?>" class="btn btn-primary align-middle"> <i class="mdi mdi-square-edit-outline"></i> Edit</a>
                    <a href="<?= base_url(); ?>admin/manage_institutions/<?= $page_index ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive gridview-wrapper">
                                <div class="row m-0">
                                    <div class="col-sm-6 p-0">
                                        <h5 class="details-title"><label>Admin Name:</label> <span><?= $users[0]->ss_aw_parent_full_name; ?></span></h5>
                                        <h5 class="details-title"><label>Mobile No:</label> <span><?= $institution_details->ss_aw_mobile_no; ?></span></h5>
                                        <h5 class="details-title"><label>Email Id:</label> <span><?= $users[0]->ss_aw_parent_email; ?></span></h5>
                                        <h5 class="details-title"><label>Address:</label> <span><?= $institution_details->ss_aw_address; ?></span></h5>
                                        <h5 class="details-title"><label>City:</label> <span><?= $institution_details->ss_aw_city; ?></span></h5>
                                        <h5 class="details-title"><label>Country:</label> <span><?= $institution_details->country_name; ?></span></h5>
                                        <h5 class="details-title"><label>Pin Code:</label> <span><?= $institution_details->ss_aw_pincode; ?></span></h5>
                                        

                                    </div>
                                    <div class="col-sm-6 p-0"></div>
                                </div>
                                <div class="row m-0">
                                    <div class="col-sm-4 p-0">
                                        <h4 class="text-muted">Winners Programme</h4>
                                        <h6 class="details-title"><label>Lumpsum Price:</label> <span><?= number_format($institution_details->ss_aw_lumpsum_price, 2); ?></span></h6>
                                        <h6 class="details-title"><label>EMI Price:</label> <span><?= number_format($institution_details->ss_aw_emi_price, 2); ?></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (Lumpsum):</label> <span><?= coupon_code($institution_details->ss_aw_coupon_code_lumpsum); ?></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (EMI):</label> <span><?= coupon_code($institution_details->ss_aw_coupon_code_emi); ?></span></h6>

                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <h4 class="text-muted">Champions Programme</h4>
                                        <h6 class="details-title"><label>Lumpsum Price:</label> <span><?= number_format($institution_details->ss_aw_lumpsum_price_champions, 2); ?></span></h6>
                                        <h6 class="details-title"><label>EMI Price:</label> <span><?= number_format($institution_details->ss_aw_emi_price_champions, 2); ?></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (Lumpsum):</label> <span><?= coupon_code($institution_details->ss_aw_coupon_code_lumpsum_champions); ?></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (EMI):</label> <span><?= coupon_code($institution_details->ss_aw_coupon_code_emi_champions); ?></span></h6>
                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <h4 class="text-muted">Masters Programme</h4>
                                        <h6 class="details-title"><label>Lumpsum Price:</label> <span><?= number_format($institution_details->ss_aw_lumpsum_price_masters, 2); ?></span></h6>
                                        <h6 class="details-title"><label>EMI Price:</label> <span><?= number_format($institution_details->ss_aw_emi_price_masters, 2); ?></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (Lumpsum):</label> <span><?= coupon_code($institution_details->ss_aw_coupon_code_lumpsum_masters); ?></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (EMI):</label> <span><?= coupon_code($institution_details->ss_aw_coupon_code_emi_masters); ?></span></h6>
                                    </div>
                                </div>
                                <a style="font-weight: bold; text-decoration: underline;" href="<?= base_url(); ?>admin/manageinstitutionusers/<?= $institution_details->ss_aw_id ?>">Manage Users</a>
                                <a style="font-weight: bold; text-decoration: underline;" href="<?= base_url(); ?>admin/institutionpaymentdetails/<?= $institution_details->ss_aw_id ?>">Payment History</a>
                            </div>

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