

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
                                    <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/manage_refferal">Manage Referral</a></li>
                                    <li class="breadcrumb-item active">Add Refferal</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <?php include("error_message.php");?>

                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="page-title">Add Refferal</h4>
                        </div>


                        <div class="col-lg-12 col-xl-12">
                            <div class="card-box">
                            <form method="post" action="<?= base_url(); ?>admin/addrefferal" id="demo-form" data-parsley-validate="">
                            

                                <div class="form-group">
                                    <label for="title">Title<span class="text-danger">*</span></label>
                                    <input name="title" class="form-control" type="text" id="title" placeholder="Title" required>
                                    <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                </div> 
                                
                                <div class="form-group">
                                    <label for="title">Newsletter<span class="text-danger">*</span></label>
                                    <select name="newsletter" id="newsletter" class="form-control" required>
                                        <option value="">Choose Newsletter</option>
                                        <?php
                                        if (!empty($newsletter)) {
                                            foreach ($newsletter as $key => $value) {
                                                ?>
                                                <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_aw_title; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                </div>
                                
                                <div class="form-group">
                                    <label for="title">Coupon<span class="text-danger">*</span></label>
                                    <select name="coupon" id="coupon" class="form-control" required>
                                        <option value="">Choose Coupon</option>
                                        <?php
                                        if (!empty($coupons)) {
                                            foreach ($coupons as $key => $value) {
                                                ?>
                                                <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                </div>         
   
                                <div class="form-group">
                                    <button class="btn btn-success waves-effect waves-light mr-2" type="submit">Save</button>
                                    <button class="btn btn-danger waves-effect waves-light" type="button">Cancel</button>
                                </div>
                            </form>
                            </div> <!-- end col -->
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
<script src="./assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
 <!-- Init js-->
 <script src="<?= base_url(); ?>assets/js/pages/create-project.init.js"></script>
 <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>
   <!-- Validation init js-->
   <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>


 <script>
    $(document).ready(function(){

    $("#customSwitch2").click(function(){
    $(".custom-switch label").text(($(".custom-switch label").text() == 'Inactive') ? 'Active' : 'Inactive').fadeIn();
  });

});

</script>

</body>
</html>