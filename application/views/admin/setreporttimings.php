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
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">Settings</li>
                                    <li class="breadcrumb-item active">Set Report Timings</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Set Report Timings</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <!-- end page title -->


                    <form action="<?php echo base_url() ?>admin/setreporttimings" class="parsley-examples" id="modal-demo-form" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row mb-2">
                                           
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="txtDiagonsticTestTiming">Set report timings (days)</label>
                                                    <input class="form-control" type="text" id="txtDiagonsticTestTiming"
                                                        placeholder="Set report timings in days" value="<?php echo $result[0]->ss_aw_test_timing_value; ?>" name="report_time">

                                                    <p class="text-hint"><small>Default: 30 days</small></p>
                                                </div>
                                                

                                            </div>
                                            <div class="col-sm-4">
                                                
                                                
                                            </div>
                                             <div class="col-sm-4"> </div>
                                        </div>


                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="text-left">
                                    <button type="submit"
                                        class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Update</button>
                                    <button type="button"
                                        class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
                                </div>
                            </div>
                            <input type="hidden" name="update_report_time" value="update_report_time">


                        </div>
                    </form>



                </div> <!-- container -->

            </div> <!-- content -->

            <?php
                include('includes/bottombar.php');
            ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <style type="text/css">
    .custom-form-control {

        width: 50px;

    }

    .selectize-dropdown {
        z-index: 99999;
    }

    .selectize-dropdown-header {
        display: none;
    }

    .dropify-wrapper .dropify-message p {
        line-height: 50px;
    }

    .custom-color {
        background-color: #3283f6;
        margin-right: 10px;
    }

    .templete {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-box {
        border: 1px solid #ced4da;
    }
    </style>

    <?php
            include('footer.php')
        ?>
    <!-- Table Editable plugin-->
    <script src="./assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
    <script src="./assets/libs/select2/js/select2.min.js"></script>
    <script src="./assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="./assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <!-- Validation init js-->
    <script src="./assets/js/pages/form-validation.init.js"></script>
    <script src="./assets/js/pages/form-advanced.init.js"></script>

    <script>
    jQuery(function() {
       
    });
    </script>

</body>

</html>