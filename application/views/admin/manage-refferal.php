
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
                                <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/manage_refferal"> Refferal Management </a></li>
                                    <li class="breadcrumb-item active">List of Manage Refferal</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div style="display: none" id="success_msg" class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Copied to clipboard successfully.  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <?php include("error_message.php");?>

                    <div class="row">
            
 
                            <div class="col-6">
                            <div class="page-title-box">
                                <h4 class="page-title">Manage Refferal</h4>
                            </div>
                        </div>
                        <div class="col-6">
                        <div class="footerformView float-right mt-3 mr-2">
                            
                                <!-- <form>
                                    <div class="row content-right">
                                        <div>
                                        <select class="form-control topselectdropdown" onchange="dofunctions(this.value);" id="drpMultipleCta">                                    
                                        <option value="" select="">Please Select</option>
                                        <option value="1">Delete All</option>
                                        </select>
                                        </div>

                                        <div class="pl-2">
                                        <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs resetBtn" id="btnAudio1"><i class="mdi mdi-refresh"></i></button>
                                        </div>
                                  
                                    
                                   
                                    </div>
                                   
                                </form> -->
                               
                            </div>
                    </div>
                        </div>
             
                    <!-- end page title -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2 managecouponlistofcouponsearch">
                                        <div class="col-sm-3">

                                            <a href="<?= base_url(); ?>admin/addrefferal" class="btn btn-danger mb-2"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add Refferal</a>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="text-sm-right">
                                                <!-- <form method="post" action="<?= base_url(); ?>admin/manage_refferal" id="demo-form">
                                                 

                                                    <div class="coupon-from-section">

                                                        <div class="form-group mb-3 mr-1">
                                                            <div class="input-group">
                                                                <select name="status" class="form-control price-select" id="drpStatus">
                                                                    <option value="0" select>Status</option>
                                                                    <option value="1" <?php if(!empty($search_data) && $search_data['status'] == 1){ ?> selected <?php } ?>>Active</option>
                                                                     <option value="2" <?php if(!empty($search_data) && $search_data['status'] == 2){ ?> selected <?php } ?>>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                                    <div class="clear-btn-sec">
                                                        <button type="submit" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Go</button>
                                                        </div>

                                                    </div>
                                                       
                                                       
                                                       
                                                      
                                                  
                                                
                                                </form> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                            <thead class="thead-light">
                                                <tr>
                                                    <!-- <th style="width: 20px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck">
                                                            <label class="custom-control-label"
                                                                for="customCheck">&nbsp;</label>
                                                        </div>
                                                    </th> -->
                                                    <th>Title</th>
                                                    <!-- <th>Staus</th> -->
                                                    <th class="actioncol">Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                            <?php
                                            if (!empty($result)) {
                                                foreach ($result as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <!-- <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input multideletecheckbox"
                                                                    id="customCheck<?= $value->ss_aw_id; ?>" value="<?= $value->ss_aw_id; ?>">
                                                                <label class="custom-control-label"
                                                                    for="customCheck<?= $value->ss_aw_id; ?>"></label>
                                                            </div>
                                                        </td> -->
                                                        <td class="name-newletter"><?= $value->ss_aw_title; ?></td>
                                                        <!-- <td><a href="#" onclick="return change_status(<?= $value->ss_aw_id; ?>, <?= $value->ss_aw_status; ?>);" class="badge <?= $value->ss_aw_status == 1 ? 'badge-soft-success' : 'badge-soft-danger'; ?>" data-toggle="modal"
                                                            data-target="#warning-status-modal"><?= $value->ss_aw_status == 1 ? "Active" : "Inactive"; ?></a></td> -->
                                                        <td class="actioncell">
                                                            <input type="text" name="myInput" id="myInput" value="https://play.google.com/store/apps/details?id=com.team&referrer=utm_source%3D<?= $value->ss_aw_id; ?>" style="display:none">
                                                            <a onclick="myFunction()" href="javascript:void(0);" class="action-icon">
                                                                <i class="mdi mdi-arrange-send-backward" title="Copy Code"></i>
                                                            </a>
                                                            
                                                            <a href="javascript:void(0);" onclick="return set_delete_value(<?= $value->ss_aw_id; ?>)" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"> <i
                                                                    class="mdi mdi-delete"></i></a>
                                                        </td>
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
                    <!-- end row-->
                    <div class="row">
                        <div class="col-12">
                            <div class="text-right">
                                <?php foreach ($links as $link) {
                                    echo "<li>". $link."</li>";
                                } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

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
                                <p class="mt-3">Deleting will remove this coupon from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form id="record_remove_form" method="post" action="<?= base_url(); ?>admin/manage_refferal">
                                        <input type="hidden" name="delete_record_id" id="delete_record_id">
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    </form>
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
                                <p class="mt-3" id="status_warning_msg"></p>
                               
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>admin/changenewsletterstatus" method="post">
                                     <input type="hidden" id="status_newsletter_id" name="status_newsletter_id">   
                                     <input type="hidden" id="status_newsletter_status" name="status_newsletter_status">   
                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
      
            <?php  include 'includes/bottombar.php'; ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <!-- Modal -->
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Coupon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" class="parsley-examples" id="demo-form">


                        <div class="text-right">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="Custombox.close();">Cancel</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    
    <!-- Delete confirmation dialog -->
    <div id="alert-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Please select atleast one record to perform the operation.</p>
                        <div class="button-list">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
            <!--Status update confirmation dialog -->

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
    </style>



    <?php
include 'footer.php'
?>

 <!-- Table Editable plugin-->
 <script src="<?= base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

<!-- Table editable init-->
<!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>


 <!-- Init js-->
 <script src="<?= base_url(); ?>assets/js/pages/create-project.init.js"></script>

 <script type="text/javascript">
    $("#customCheck").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

     function change_status(newsletter_id,newsletter_status){
        if(newsletter_status == 0)
        {
            $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
        }
        else
        {
           $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
        }
        $("#status_newsletter_id").val(newsletter_id);
        $("#status_newsletter_status").val(newsletter_status);
    }

    function dofunctions(value){
        var checkedRecord = [];
        if (value != "") {
            if (value == 1) {
                $(".multideletecheckbox:checked").each(function(){
                    checkedRecord.push($(this).val());
                });

                if (checkedRecord.length > 0) {
                    var checkedRecordString = checkedRecord.toString();
                    $("#delete_record_id").val(checkedRecordString);
                    $("#remove_type").val('multiple');
                    $("#warning-delete-modal").modal('toggle');
                }
                else
                {
                    $("#alert-modal").modal('toggle');
                }
            }
        }
    }    

    function set_delete_value(newsletter_id){
        $("#remove_type").val('single');
        $("#delete_record_id").val(newsletter_id);
    }

function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  $("#success_msg").show();
  setTimeout(function() {
    $('#success_msg').fadeOut('fast');
  }, 5000);
}


 </script>  


</body>

</html>