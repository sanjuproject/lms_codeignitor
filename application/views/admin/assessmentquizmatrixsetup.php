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
                                    <li class="breadcrumb-item active">Assessment Quiz Matrix Setup</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Assessment Quiz Matrix Setup</h4>
                        </div>

                        <div class="col-md-6">


                        </div>



                    </div>
                    <!-- end page title -->


                    <form action="<?php echo base_url() ?>admin/assessmentquizmatrixsetup" class="parsley-examples" id="modal-demo-form" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="table-responsive gridview-wrapper">
                                                    <table
                                                        class="table table-centered table-striped dt-responsive nowrap w-100"
                                                        data-show-columns="true">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th># of subsections</th>
                                                                <th>Total questions in sub-sections</th>
                                                                <th>Min. questions in sub-sections</th>
                                                            </tr>
                                                        </thead>


                                                        <tbody>

                                                           <?php
                                                           $sl = 1; 
                                                             foreach ($result as $value) {

                                                                 ?>

                                                            <tr>
                                                                <td><?php echo $sl; ?></td>
                                                                <td>
                                                                    <input type="hidden" name="section<?php echo $sl;?>[]" value = "<?php echo $value->ss_aw_assessment_matrix_id; ?>">
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control autonumber  pl-0 pr-0 text-center"
                                                                                type="text" id="" placeholder=""
                                                                                data-a-sep="" data-a-dec="."
                                                                                data-v-min="0" data-v-max="999" value="<?php echo $value->ss_aw_total_question; ?>" name="section<?php echo $sl;?>[]"/>
                                                                        </div>
                                                                        <div class="col-sm-9 pl-0">
                                                                            <span class="badge badge-warning invisible"><i
                                                                                    class="mdi mdi-alert-circle-outline"></i></span>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control autonumber pl-0 pr-0 text-center"
                                                                                type="text" id="" placeholder=""
                                                                                data-a-sep="" data-a-dec="."
                                                                                data-v-min="0" data-v-max="999" value="<?php echo $value->ss_aw_min_question; ?>" name="section<?php echo $sl;?>[]"/>
                                                                        </div>
                                                                        <div class="col-sm-9 pl-0">
                                                                            <span class="badge badge-warning invisible"><i
                                                                                    class="mdi mdi-alert-circle-outline"></i></span>
                                                                        </div>
                                                                    </div>


                                                                </td>

                                                            </tr>
                                                               <?php
                                                               $sl++;
                                                             }
                                                           ?> 
                                                           



                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="col-sm-6"> </div>
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


                        </div>
                        <input type="hidden" name="update_matrix_record" value="update_matrix_record">
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
        jQuery('.autonumber').change(function() {
                let $this = jQuery(this);
                let targetObject = $this.closest('.row').find('.badge-warning');
                targetObject.removeClass('invisible')
                
        });
    });
    </script>

</body>

</html>