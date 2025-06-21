

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
                                    <li class="breadcrumb-item active"><a href="couponmanagement.php">Coupon Management</a></li>
                                    <li class="breadcrumb-item active">Settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="page-title">Settings</h4>
                        </div>


  
                    
                        <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-row">

                                        <div class="form-group col-md-4">
                                                    <label for="users">Promotion sending frequency for new users (days)</label>
                                                    <input class="form-control" type="text" id="users" placeholder="days" value="30">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="duration">Promotion sending frequecy duration (days)</label>
                                                    <input class="form-control" type="text" id="duration" placeholder="days" value="90">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="period">Promotion Rest period (days)</label>
                                                    <input class="form-control" type="text" id="period" placeholder="days" value="90">
                                                </div>

                                        </div>
                                           
                                      
                                       


                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                     
                   
                            <div class="col-md-6">

                                <div class="text-left">
                                    <button type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Update</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</button>
                                </div>
                            </div>


                       
                          


                    </div>
            

                    

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php
include 'includes/bottombar.php';
?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->


        <style type="text/css">
      
        
        </style>

        <?php
include 'footer.php'
?>
 <!-- Table Editable plugin-->
 <script src="<?= base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
 <!-- Init js-->
 <script src="<?= base_url(); ?>assets/js/pages/create-project.init.js"></script>

</body>
</html>