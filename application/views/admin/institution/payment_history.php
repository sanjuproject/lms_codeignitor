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
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item">Payment History</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Payment History</h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right" style="padding: 20px 0px;">
                        <a href="javascript:void(0)" onclick="history.go(-1)" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Payment Date</th>
                                            <th>Payment Type</th>
                                            <th>File Name</th>
                                            <th>No. of Users</th>
                                            <th>Transaction ID</th>
                                            <th>Paid Amount</th>
                                            <th>Gst Amount</th>
                                            <th>Discount Amount</th>
                                            <th>Discount Coupon</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($payment_history)) {
                                            foreach ($payment_history as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($value->ss_aw_created_date)) ?></td>
                                                    <td><?= $value->ss_aw_payment_type == 1 ? "Lumpsum" : "EMI"; ?></td>
                                                    <td>
                                                        <?= $value->ss_aw_upload_file_name; ?>
                                                    </td>
                                                    <td><?= $value->ss_aw_student_number; ?></td>
                                                    <td><?= $value->ss_aw_transaction_id; ?></td>
                                                    <td><?= $value->ss_aw_payment_amount; ?></td>
                                                    <td><?= $value->ss_aw_gst_rate; ?></td>
                                                    <td><?= $value->ss_aw_discount_amount; ?></td>
                                                    <td><?= $value->ss_aw_discount_coupon; ?></td>
                                                    <td><a download href="<?= $value->ss_aw_payment_invoice_filepath ?>"><span class="badge badge-soft-success">Download</span></a></td>
                                                </tr>
                                                <?php
                                            }
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
                            <?php foreach ($links as $link) {
                                echo "<li>" . $link . "</li>";
                            } ?>
                        </ul>
                    </div>
                </div>
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