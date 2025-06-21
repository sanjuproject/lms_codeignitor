<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item">Report Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title">Report Dashboard</h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <a href="<?= base_url(); ?>diagnostic/view_institution/<?= $this->uri->segment(3); ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <a href="<?php echo base_url(); ?>diagnostic/institution_individual_performance/<?= $this->uri->segment(3); ?>" class="pointer">
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
                                        <h3 class="mt-1">Diagnostic MIS</h3>
                                        <p class="mb-1 counter_size text-warning"></p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                    </a>
                </div>

                <div class="col-md-4 col-xl-4">
                    <a href="<?php echo base_url(); ?>admin/institution_combined_performance/<?= $this->uri->segment(3); ?>" class="pointer">
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
                                        <h3 class="mt-1">Diagnostic MIS 2</h3>
                                        <p class="mb-1 counter_size text-warning"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
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