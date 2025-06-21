

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
                                    <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/managenewsletters">Manage Newsletters</a></li>
                                    <li class="breadcrumb-item active">Add Newsletters</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <?php include("error_message.php");?>

                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="page-title">Add Newsletters</h4>
                        </div>


                        <div class="col-lg-12 col-xl-12">
                            <div class="card-box">
                            <form method="post" action="<?= base_url(); ?>admin/add_newsletter" id="demo-form" data-parsley-validate="">
                            <div class="form-group newsletter-required">
                                <div class="custom-control custom-switch custom-switch-newsletter">
                                    <input name="status" value="1" type="checkbox" class="custom-control-input" id="customSwitch2">
                                    <label class="custom-control-label" for="customSwitch2">Inactive</label>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="title">Name<span
                                                        class="text-danger">*</span></label>
                                                        <input name="title" class="form-control" type="text" id="title" placeholder="Name" required>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div> 
                            
                                              <div class="form-group">
                                              <div class="comment-area-btn custom-comment-area-btn">
                                           <label>Template<span class="text-danger">*</span></label>
                                                <div class="float-right">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle mb-1"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dynamic code<i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dynamicTags dropdown-menu" id="newsletterdrpDynamicTags">
                                                            <?php
                                                            if (!empty($notification_param)) {
                                                                foreach ($notification_param as $key => $value) {
                                                                    ?>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="<?= $value->param_value; ?>"><?= $value->param_name; ?></a>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                           <textarea rows="8" name="template" id="template" class="form-control" placeholder="Write something..." required></textarea>
                                              </div>
                                              <button style="float: right; margin-top: 10px;" type="button" class="btn btn-success waves-effect waves-light emailPreview" data-toggle="modal" data-target="#modal1-preview">Preview</button>
                                              </div>
   
                                            <div class="form-group">
                                            <button class="btn btn-success waves-effect waves-light mr-2"
                                            type="submit">Save</button>
                                            <button class="btn btn-danger waves-effect waves-light"
                                            type="button">Cancel</button>
                                            </div>
                                            </form>
                            </div> <!-- end col -->
                        </div>

                    </div>
            

                    

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Modal -->
                <div class="modal fade" id="modal1-preview" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Template Preview
                                        </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body p-2">
                                <div id="dvEmailTemplatePreview"></div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
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

jQuery(function() {

    jQuery('.emailPreview').click(function() {
        let targetObj = jQuery("#template");
        jQuery('#dvEmailTemplatePreview').html(targetObj.val());
    });

    jQuery('#newsletterdrpDynamicTags a').on('click', function() {
        myValue = jQuery(this).data('value');
        console.log({myValue});
        var cursorPos = jQuery('#template').prop('selectionStart');
        var v = jQuery('#template').val();
        var textBefore = v.substring(0, cursorPos);
        var textAfter = v.substring(cursorPos, v.length);
        jQuery('#template').val(textBefore + myValue + textAfter);
    });


});

</script>

</body>
</html>