

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
                                    <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/managepromotions">Manage Promotions</a></li>
                                    <li class="breadcrumb-item active">Create Promotions</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <?php include("error_message.php");?>
                    
                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="page-title">Create Promotions</h4>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mt-2">
                    
                    <div class="col-lg-6">
                    <form method="post" action="<?= base_url(); ?>admin/createpromotions" id="demo-form">
                                <div class="card-box card-layout">

                                            <div class="form-row">
                                           <div class="form-group col-md-6">
                                           <label>Name<span class="text-danger">*</span></label>
                                           <input name="title" class="form-control" type="text" id="title" placeholder="Name" required>
                                           <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                           </div>
                                           <div class="form-group col-md-6">
                                           <label>Date<span class="text-danger">*</span></label>
                                           <input name="date" type="text" class="form-control" data-toggle="flatpicker" placeholder="Date" >
                                           <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                           </div>
                                            </div>


                                            <div class="form-group">

                                                <label>Select Type<span class="text-danger">*</span></label>

                                                <div class="terget-audience-radio">
                                                <div class="radio radio-primary mr-2">
                                                <input type="radio" name="promotiontype" id="Newsletter" value="1" required="" data-parsley-multiple="promotiontype">
                                                <label for="Newsletter">
                                                Newsletter
                                                </label>
                                                </div>
                                                <div class="radio radio-primary">
                                                <input type="radio" name="promotiontype" id="Coupon" value="2" data-parsley-multiple="promotiontype">
                                                <label for="Coupon">
                                                Coupon
                                                </label>
                                                </div>
                                                </div>
                                                </div>

                                                <div class="form-group" id="newsletter-section">
                                                    <div class="newsletter-section">
                                                        <select name="newslettername" id="newslettername" class="form-control">
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
                                                    <!-- <?php
                                                    if (!empty($newsletter)) {
                                                        foreach ($newsletter as $key => $value) {
                                                            ?>
                                                            <div class="radio radio-primary mb-2">
                                                                <input type="radio" name="newslettername" id="newslettername<?= $value->ss_aw_id; ?>" value="<?= $value->ss_aw_id; ?>" data-parsley-multiple="newslettername">
                                                                <label for="newslettername<?= $value->ss_aw_id; ?>">
                                                                <?= $value->ss_aw_title; ?>
                                                                </label>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?> -->    
                                                    
                                                    </div>
                                            </div>

                                             <div class="form-group" id="couponlist-section">
                                                 
                                            <div class="couponlist-section">
                                                <select name="couponname" id="couponname" class="form-control">
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
                                            <!-- <?php
                                            if (!empty($coupons)) {
                                                foreach ($coupons as $key => $value) {
                                                    ?>
                                                    <div class="radio radio-primary mb-2">
                                                        <input type="radio" name="couponname" id="couponname<?= $value->ss_aw_id; ?>" value="<?= $value->ss_aw_id; ?>" data-parsley-multiple="couponname">
                                                        <label for="couponname<?= $value->ss_aw_id; ?>">
                                                        <?= $value->ss_coupon_code; ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?> -->
                                                </div>
                                             </div>

                                                <div class="form-group mt-3 mb-3">

                                                <label>Select Contact list<span class="text-danger">*</span></label>

                                                <div class="terget-audience-radio">
                                                <div class="radio radio-primary mr-2">
                                                <input type="radio" name="contact_type" id="new" value="1" required="" data-parsley-multiple="contactlist">
                                                <label for="new">
                                                New
                                                </label>
                                                </div>
                                                <div class="radio radio-primary">
                                                <input type="radio" name="contact_type" id="existing" value="2" checked data-parsley-multiple="contactlist">
                                                <label for="existing">
                                                Existing
                                                </label>
                                                </div>
                                                </div>
                                                </div>

                                            

                                             <div class="form-group" id="new-contactlist">

                                               <div class="new-contactlist">
                                                <?php
                                                if (!empty($externalcontacts)) {
                                                    foreach ($externalcontacts as $key => $value) {
                                                        ?>
                                                        <div class="checkbox checkbox-pink mb-2">
                                                            <input type="checkbox" name="contact[]" id="contact<?= $value->ss_aw_title; ?>" value="<?= $value->ss_aw_id; ?>" data-parsley-mincheck="1">
                                                            <label for="contact<?= $value->ss_aw_title; ?>"><?= $value->ss_aw_title; ?></label>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                               </div>
                                              </div>

                                        


                                            <div class="form-group">
                                            <button class="btn btn-success waves-effect waves-light mr-2"
                                            type="submit">Save</button>
                                            <a class="btn btn-danger waves-effect waves-light" href="<?= base_url(); ?>admin/managepromotions">Cancel</a>
                                            </div>

                                   
                                </div>
</form>

                            </div> <!-- end col -->
                    
                           
                    
                    
                    
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


 <script>

$(document).ready(function() {
    $("#Newsletter").click(function() {
        $("#couponlist-section").hide();
        $("#newsletter-section").show();
    });
    $("#Coupon").click(function() {
        $("#newsletter-section").hide();
        $("#couponlist-section").show();
    });
    $("#new").click(function() {
        $("#new-contactlist").show();
    });
    $("#existing").click(function() {
        $("#new-contactlist").hide();
    });

   
});
    </script>


</body>
</html>