<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <a href="<?php echo base_url(); ?>institution/manage_users" class="pointer">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-3">
                                    <div
                                        class="avatar-lg rounded-circle bg-soft-warning border-warning border details_center">
                                        <img src="<?php echo base_url(); ?>assets/images/lesson.png" alt="contact-img" title="contact-img"
                                            class="avatar-sm" />
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="text-center">
                                        <h3 class="mt-1">Users Enrolled</h3>
                                        <p class="mb-1 counter_size text-warning"><?= $students_num; ?></p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                    </a>
                </div> <!-- end col-->

                <?php
                if (!empty($last_payment)) {
                    $last_payment_date = date('Y-m-d', strtotime($last_payment->ss_aw_created_date));
                    $next_payment_date = date('d/m/Y', strtotime($last_payment_date." +1 month"));
                    ?>
                    <div class="col-md-6 col-xl-3">
                        <a href="<?php echo base_url(); ?>institution/manage_payment" class="pointer">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-3">
                                        <div
                                            class="avatar-lg rounded-circle bg-soft-primary border-primary border details_center">
                                            <img src="<?php echo base_url(); ?>assets/images/assessments.png" alt="contact-img"
                                                title="contact-img" class="avatar-sm" />
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="text-center">
                                            <h3 class="text-dark mt-1">Payments Due</h3>
                                            <p class="mb-1 counter_size text-primary"><?= $next_payment_date; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
                </a>
            </div>
            <!-- end row-->
        </div>
        <!-- end row-->


        


        <div class="row">
            <div class="col-xl-4">
                <div class="card fixedheight">

                </div> <!-- end card-->
            </div>
            <!-- end col-->

            <div class="col-xl-4 col-lg-6">
                <div class="card fixedheight">


                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

            <div class="col-xl-4  col-lg-6">
                <div class="card fixedheight">

                </div> <!-- end card-->
            </div> <!-- end col-->

        </div>
        <!-- end row-->

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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Status update confirmation dialog -->
<div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2">Warning!</h4>
                    <p class="mt-3">Are you sure you want to update the status?</p>
                    <div class="button-list">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
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

.custom-ViewBox {
    background: #fff;
    display: table;
    margin-top: -10px;
    margin-left: -5px;
    padding: 0px 3px 0px 8px;
}

.custom-checkboxView {
    border: 1px solid #ced4da;
    padding: 0px 12px;
    box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
    background: #fff;
    margin-bottom: 10px;
    border-radius: 4px;
}

.under-checkboxView {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: start;
    display: none;
}

.details_center {
    display: flex;
    justify-content: center;
    align-items: center;
}

.counter_size {
    font-size: 22px;
}

.pointer {
    cursor: pointer;
}

.counter_parent_container{
    position:relative;
}

.counter_digit {
    position: absolute;
    width: 20px;
    background: #ff0000;
    height: 20px;
    bottom: 7px;
    right: -7px;
    border-radius: 20px;
    font-size: 13px;
    color: #fff;
    text-align: center;
    line-height: 20px;
}

</style>