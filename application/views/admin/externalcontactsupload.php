

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
                                    <li class="breadcrumb-item"><a href="couponmanagement.php"> Coupon Management </a></li>
                                    <li class="breadcrumb-item active">List of Contacts</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">External Contacts Upload</h4>
                        </div>

                        <div class="col-md-6">

                            <div class="footerformView float-right mb-2">
                            <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light"
                                                type="button" data-toggle="modal" data-target="#modal-new-upload">New Upload</button>
                            </div>


                        </div>



                    </div>

                    </div>
                    <div style="display: none" id="success_msg_status" class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Status updated succesfully.  <button type="button" class="close" onclick="closeAlert();">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <!-- end page title -->
                    <?php include("error_message.php");?>
                    <div class="row mt-2">
                        <?php
                        if (!empty($contacts)) {
                            foreach ($contacts as $key => $value) {
                                ?>
                                <div class="col-lg-3">

                                    <div class="contactupload card-box">

                                        <div class="switch-Section">
                                            <div class="custom-control custom-switch" id="custom_switch_<?= $value->ss_aw_id; ?>">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch_<?= $value->ss_aw_id; ?>" onclick="return update_contact_status(<?= $value->ss_aw_id ?>,<?= $value->ss_aw_status ?>)" <?php if($value->ss_aw_status == 1){ ?> checked <?php } ?>>
                                                <label class="custom-control-label" for="customSwitch_<?= $value->ss_aw_id; ?>">
                                                    <?php if($value->ss_aw_status == 1){ ?> Active <?php }else{ ?> Inactive <?php } ?>
                                                </label>          
                                            </div>
                                        </div>
                                                
                                        <h4 class="text-success"><?= $value->ss_aw_title; ?></h4>
                                        <p class="text-muted mb-0">Uploaded by <?= $value->ss_aw_admin_user_full_name; ?></p>
                                        <p class="text-muted mb-0">Dated <?= date('d/m/Y', strtotime($value->ss_aw_created_at)); ?> at <?= date('h:i a', strtotime($value->ss_aw_created_at)); ?></p>

                                        <div class="row contactuploadbuttonsection">
                              
                                        <div class="col-sm-6">
                                        <button onclick="return get_user_detail(<?= $value->ss_aw_id; ?>);" class="btn btn-success btn-block waves-effect waves-light" data-toggle="modal" data-target="#modal-view"
                                                type="button">View</button>
                                        </div>

                                        <div class="col-sm-6">
                                        <button onclick="return assign_delete(<?= $value->ss_aw_id; ?>);" data-toggle="modal" data-target="#warning-delete-modal" title="Delete" class="btn btn-danger btn-block waves-effect waves-light"
                                                type="submit">Remove</button>
                                        </div>

                                        </div>


                                       
                                    </div>

                                </div>    
                                <?php
                            }
                        }
                        ?>
                    </div>


                        
                    <!-- Modal -->
                    <div class="modal fade" id="modal-new-upload" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">New Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="post" action="<?php echo base_url(); ?>admin/externalcontacts" id="demo-form" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="course">Contacts Title<span
                                                        class="text-danger">*</span></label>
                                                        <input name="title" class="form-control parsley-error" type="text" id="course" placeholder="Contacts Title goes here" required>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
                                       
                                     
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Template<span
                                                        class="text-danger">*</span></label><br />
                                                        <input name="file" type="file" data-plugins="dropify" data-height="100" required/>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <!-- <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                        <h6>Note : Only Excel file format allowed. Sample <a download href="<?= base_url(); ?>assets/templates/externalcontacts.xlsx">Template</a> file found here.</h6>
                                            </div>
                                            
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Upload
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>
        
            
                                      

                                    
 
                                        

                                    </div> <!-- end card-body-->

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->   

                    <!-- Delete confirmation dialog -->
                    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Deleting will remove this contact details from the system. Are you
                                            sure ?
                                        </p>
                                        <div class="button-list">
                                            <form action="<?php echo base_url() ?>admin/remove_external_contact" method="post">
                                                <input type="hidden" name="external_contact_id" id="external_contact_id">
                                                <button type="submit" class="btn btn-danger"
                                                >Yes</button>
                                                <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                     <!-- Modal -->
                   <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title">View - External Contacts</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                  
                                  
                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                            data-show-columns="true">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="con-sl"># SL No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th class="con-mbl">Mobile</th>
                                                </tr>
                                            </thead>

                                            <tbody class="view-thead-light"></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


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

        <?php
include 'footer.php'
?>

<script>
    $(document).ready(function(){
        /*$("#customSwitch2").click(function(){
            $(".custom-switch label").text(($(".custom-switch label").text() == 'Inactive') ? 'Active' : 'Inactive').fadeIn();
        });*/
    });

    function closeAlert(){
        $('#success_msg_status').fadeOut('fast');
    }

    function update_contact_status(id, status){
        console.log("@1");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/update_external_contact_status",
            data: {id:id,status:status},
            success: function(result){
                $("#custom_switch_"+id+" label").text(($("#custom_switch_"+id+" label").text() == 'Inactive') ? 'Active' : 'Inactive').fadeIn();
                $("#success_msg_status").show();
                setTimeout(function() {
                    $('#success_msg_status').fadeOut('fast');
                }, 5000);
            }
        });
    }

    function assign_delete(id){
        $("#external_contact_id").val(id);
    }

    function get_user_detail(id){
        console.log("@5");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/get_user_list",
            data: {id:id},
            dataType: "JSON",
            success: function(result){
                console.log(result);
                var alluser = '';
                if(result != ""){
                    $.each(result, function(i, item){
                        alluser += '<tr><td>'+item.sl_no+'</td><td>'+item.name+'</td><td>'+item.email+'</td><td>'+item.phone+'</td></tr>'; 
                    });
                }
                else
                {
                    alluser += '<tr colspan="4">No user found.</tr>';
                }

                $(".view-thead-light").html(alluser);
            }
        });
    }
</script>


</body>
</html>