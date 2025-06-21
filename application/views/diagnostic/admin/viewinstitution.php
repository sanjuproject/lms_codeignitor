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
                <div class="col-8">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Institution Name: <?= $institution_details->ss_aw_name; ?></h4>
                    </div>
                </div>
                <div class="col-4 text-right mt-3">
                    <a href="<?= base_url(); ?>diagnostic//update_institutions/<?= $institution_details->ss_aw_id; ?>" class="btn btn-primary align-middle"> <i class="mdi mdi-square-edit-outline"></i> Edit</a>
                    <a href="<?= base_url(); ?>diagnostic/manage_institutions/<?= $page_index ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH."views/diagnostic/error_message.php"); ?>
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
                                        <h4 class="text-muted"><?=Diagnostic?> Programme</h4>
                                        <h6 class="details-title"><label>Lumpsum Price:</label> <span><?= number_format($institution_details->ss_aw_lumpsum_price_diagnostic, 2); ?></span></h6>
                                        <!-- <h6 class="details-title"><label>EMI Price:</label> <span></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (Lumpsum):</label> <span></span></h6>
                                        <h6 class="details-title"><label>Coupon Code (EMI):</label> <span></span></h6> -->

                                    </div>
                                   
                                </div>
                                <a style="font-weight: bold; text-decoration: underline;" href="<?= base_url(); ?>diagnostic/manageinstitutionusers/<?= $institution_details->ss_aw_id ?>">Manage Users</a>
                                <a style="font-weight: bold; text-decoration: underline;" href="<?= base_url(); ?>diagnostic/institutionpaymentdetails/<?= $institution_details->ss_aw_id ?>">Payment History</a>
                                <a style="font-weight: bold; text-decoration: underline;" href="<?= base_url(); ?>diagnostic/institutionreportdashboard/<?= $institution_details->ss_aw_id ?>">Report Dashboard</a>
                                <a style="font-weight: bold; text-decoration: underline;" href="<?= base_url(); ?>diagnostic/institutionmanagepayment/<?= $institution_details->ss_aw_id ?>">Manage Payment</a>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div> <!-- container -->

    </div> <!-- content -->





    <?php
    include(APPPATH.'views/diagnostic/bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->
<?php
include(APPPATH.'views/diagnostic/footer.php')
?>

</body>

</html>