<!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12 managecouponlistofcoupon">
                            <div class="page-title-box">
                                <!-- <div class="page-title-left"> -->
                                <!-- <ol class="breadcrumb m-0"> -->
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0);"><h4>Manage Coupon</h4></a></li> -->
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0);"><h4>List of Coupon</h4></a></li> -->
                                <!-- <li class="breadcrumb-item active">Shopping Cart</li> -->
                                <!-- </ol> -->
                                <!-- </div> -->
                                <h4 class="page-title">List of Error Messages</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2 managecouponlistofcouponsearch">
                                        <div class="col-sm-8">
                                            
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-right">
                                                <form action="<?php echo base_url(); ?>admin/screen_messages" method="post" id="demo-form">
                                                    <div class="form-group mb-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="error_search_data" placeholder="Search Error Message"
                                                                aria-label="Recipient's username"
                                                                <?php
                                                                 if(isset($error_search_data))
                                                                 {
                                                                   echo 'value="'.$error_search_data.'"';
                                                                 } 
                                                                 ?>
                                                                 >
                                                                <input type="hidden" name="error_search" value="error_search">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary waves-effect waves-light"
                                                                    type="submit">Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                            <thead class="thead-light">
                                                <tr>
                                                    
                                                    <th>SL No.</th>                    
                                                    <th>Error ID</th>
                                                    <th>Error Message</th>                
                                                    <th class="actioncol">Actions</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                foreach ($result as $value) {
                                                $error_status = $value->ss_aw_error_status;
                                                $error_msg = $value->ss_aw_error_msg;
                                                ?>
                                                <tr>
                                                    

                                                   
                                                    <td>1</td>
                                                    <td class="targetaudience"> <a href="#" onclick="return view_error_message('<?php echo $error_status; ?>','<?php echo $error_msg; ?>');" 
                                                              data-toggle="modal"
                                                            data-target="#view-details-modal">
                                                            <?php echo $error_status; ?> </a>

                                                    </td>
                                                    <td><?php echo $error_msg; ?></td>
                                                    
                                                   
                                                   
                                                    <td class="actioncell">
                                                        <a href="javascript:void(0);" onclick="return edit_error_message('<?php echo $error_status; ?>','<?php echo $error_msg; ?>');"  class="action-icon"
                                                            data-toggle="modal" data-target="#edit-custom-modal"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        
                                                    </td>
                                                </tr>
                                                <?php
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
                                <ul class="pagination pagination-rounded justify-content-end">
                                    <!-- Show pagination links -->
                                    <?php foreach ($links as $link) {
                                    echo "<li>". $link."</li>";
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php
include 'bottombar.php';
?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


  

    <!-- Modal -->
    <div class="modal fade" id="edit-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Error Message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?php echo base_url(); ?>admin/screen_messages" method="post" name="" class="parsley-examples" id="demo-form">
                        <div class="form-group">
                            <label>Error Status <span class="text-danger">*</span></label>
                            <input type="text" id="edit_error_status" name="edit_error_status" class="form-control" required readonly/>
                        </div>
                        <div class="form-group">
                            <label>Error Message <span class="text-danger">*</span></label>
                            <div>
                                <textarea id="edit_error_message" name="edit_error_message" required class="form-control" data-parsley-trigger="keyup"
                                    data-parsley-maxlength="1000"
                                    data-parsley-minlength-message="You need to enter maximum 1000 character..."></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="edit_error_record" value="edit_error_record">
                       
                        <br>

                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    Submit
                                </button>
                            </div>
                        </div>

                        <!--  <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
                            </div> -->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="view-details-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">View Error Message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" name="" class="parsley-examples" id="demo-form">
                        <div class="form-group">
                            <label>Error Status</label>
                            <div class="faqquestionsdetails">
                                <p id="error_status"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Error Message</label>
                            <div class="faqanswerdetails">
                                <p id="error_message"></p>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

   

   

    <?php
include 'footer.php'
?>


    <!-- Validation init js-->
    <script src="<?php echo base_url(); ?>assets/js/pages/form-validation.init.js"></script>
    <script type="text/javascript">
       function view_error_message(error_status,error_msg)
       {
          document.getElementById('error_status').innerHTML = error_status;
          document.getElementById('error_message').innerHTML = error_msg;
       }

       function edit_error_message(error_status,error_msg)
       {
        document.getElementById('edit_error_status').value = error_status;
        document.getElementById('edit_error_message').value = error_msg;
           
       }


       
    </script>

</body>

</html>