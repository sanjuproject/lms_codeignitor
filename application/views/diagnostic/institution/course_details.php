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

    .panel-heading-nav {
        border-bottom: 0;
        padding: 10px 0 0;
    }

    .panel-heading-nav .nav {
        padding-left: 10px;
        padding-right: 10px;
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
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic_institution/manage_user/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item">Diagnostic Details</li>
                        </ol>
                    </div>
                </div>
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Details of Diagnostic Programme</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH . "views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <form action="<?php echo base_url() ?>diagnostic_institution/manage_users" method="post" id="filter-form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select name="search_data" class="form-control" id="search_data">
                                                    <option value="">Select Date</option>
                                                    <option value="2023-08-01">01-08-2023</option>
                                                    <option value="2023-02-02">02-02-2023</option>
                                                </select>
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
                               
                                <div class="col-sm-6">
                                    <a href="<?= base_url(); ?>diagnostic_institution/manage_users/<?= $this->uri->segment(5); ?>" style="float: right;" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                                </div>
                            </div>
                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Topic</th>
                                            <th>Question Level</th>
                                            <th>Question</th>
                                            <th>Correct Answer</th>
                                            <th>Answer Given</th>
                                            <th>Correct/In-Correct<br />(C/I)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Noune</td>
                                            <td>5</td>
                                            <td>2</td>
                                            <td>50%</td>
                                            <td>1</td>
                                            <td>25%</td>
                                        </tr>
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
                            <?php
                            if (!empty($links)) {
                                foreach ($links as $link) {
                                    echo "<li>" . $link . "</li>";
                                }
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>



        </div> <!-- container -->

    </div> <!-- content -->
    <!-- Delete confirmation dialog -->

    <!----------------------------------------Message model-------------------------------------->

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