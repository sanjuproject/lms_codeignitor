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
                                <h4 class="page-title">List of FAQs</h4>
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

                                            <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#custom-modal"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add a Faq</a>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-right">
                                                <form action="<?php echo base_url(); ?>admin/faq" id="demo-form" method="post">
                                                    <div class="form-group mb-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search FAQ Question"
                                                                aria-label="Recipient's username" name="faq_search_data"
                                                                 <?php
                                                                 if(isset($faq_search_data))
                                                                 {
                                                                   echo 'value="'.$faq_search_data.'"';
                                                                 } 
                                                                 ?>
                                                                >
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary waves-effect waves-light"
                                                                    type="submit">Search</button>
                                                                    <input type="hidden" name="faq_search" value="faq_search">
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
                                                    <!-- <th style="width: 20px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck1">
                                                            <label class="custom-control-label"
                                                                for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th> -->
                                                    <th>SL No.</th>  
                                                    <th>User Type</th>                
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th>C. Date</th>
                                                    <th>L.U.Date</th>
                                                    <th>Status</th>
                                                    <th class="actioncol">Actions</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                $sl_num=1;
                                                 foreach ($result as $value) {
                                                                                                     
                                                ?>
                                                <?php 
                                                        $faq_user_type = $value->faq_user_type;
                                                        $faq_status= $value->faq_status;   
                                                        $faq_id= $value->faq_id;   
                                                        $faq_question= $value->faq_question;   
                                                        $faq_answer= $value->faq_answer;
                                                         $faq_answer =addslashes(htmlspecialchars($faq_answer));
                                                        ?>
 
                                                <tr>
                                                    <!-- <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck2">
                                                            <label class="custom-control-label"
                                                                for="customCheck2"></label>
                                                        </div>
                                                    </td> -->

                                                    <td><?php echo $sl_num; ?></td>
                                                    <td><?= $value->faq_user_type == 1 ? 'Parent' : 'Child'; ?></td>     
                                                    <td class="targetaudience"> <a href="#"
                                                              data-toggle="modal"
                                                            data-target="#view-details-modal" onclick="return view_qus_ans('<?php echo $value->faq_question; ?>','<?php echo $faq_answer; ?>');"> <?php echo $value->faq_question; ?></a>
                                                    </td>
                                                    <td class="targetaudience"><?php echo $value->faq_answer; ?></td>
                                                    <td><?php echo date("d/m/y", strtotime($value->create_date)); ?></td>
                                                   
                                                    <td><?php echo date("d/m/y", strtotime($value->modify_date)); ?></td>
                                                    <td>
                                                        <?php
                                                         if($value->faq_status==1)
                                                         {
                                                            ?>
                                                       <!--  <a href="#" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return update_status('<?php echo $value->faq_status;  ?>','<?php echo $value->faq_id;  ?>')">Active</a> -->
                                                            <a href="#" class="badge badge-soft-success">Active</a>
                                                            <?php
                                                         }
                                                         else{
                                                            ?>
                                                            <!-- <a href="#" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#warning-status-modal">Not Active</a> -->
                                                            <a href="#" class="badge badge-soft-danger">Inactive</a>
                                                            <?php 
                                                         } 
                                                        ?>

                                                        </td>
                                                        
                                                    <td class="actioncell">
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-toggle="modal" data-target="#edit-custom-modal" onclick = "return update_data('<?php echo  $faq_status ?>','<?php echo  $faq_id ?>','<?php echo  $faq_question ?>','<?php echo  $faq_answer ?>','<?= $faq_user_type ?>');"
                                                            > <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal" onclick="return delete_faq('<?php echo $faq_id; ?>')"> <i
                                                                class="mdi mdi-delete"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $sl_num++;
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
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add FAQ </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?php echo base_url(); ?>admin/faq" method="post" name="" class="parsley-examples" id="demo-form">
                        <div class="form-group">
                            <label>User Type <span class="text-danger">*</span></label>
                            <select name="user_type" id="user_type" class="form-control" required>
                                <option value="1">Parent</option>
                                <option value="2">Child</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Question <span class="text-danger">*</span></label>
                            <input type="text" name="faq_question" class="form-control" required placeholder="Type Question"
                                data-parsley-maxlength="250" />
                        </div>
                        <div class="form-group">
                            <label>Answer <span class="text-danger">*</span></label>
                            <div>
                                <textarea required class="form-control" name="faq_answer" data-parsley-trigger="keyup"
                                    data-parsley-maxlength="1000"
                                    data-parsley-minlength-message="You need to enter maximum 1000 character..."></textarea>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="faq_status" value="1">
                            <label class="custom-control-label" for="customSwitch1">Active</label>
                        </div>
                        <br>

                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    Submit
                                </button>
                                <input type="hidden" name="add_faq" value="add_faq">
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
    <div class="modal fade" id="edit-custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit FAQ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?php echo base_url() ?>admin/faq" method="post" name="" class="parsley-examples" id="demo-form">
                        <div class="form-group">
                            <label>User Type <span class="text-danger">*</span></label>
                            <select name="user_type" id="edit_faq_user" class="form-control" required>
                                <option value="1">Parent</option>
                                <option value="2">Child</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required placeholder="Type Question" id="edit_question" name="edit_question" 
                                data-parsley-maxlength="250" />
                        </div>
                        <div class="form-group">
                            <label>Answer <span class="text-danger">*</span></label>
                            <div>
                                <textarea name="edit_answer" id="edit_answer" required class="form-control" data-parsley-trigger="keyup"
                                    data-parsley-maxlength="1000"
                                    data-parsley-minlength-message="You need to enter maximum 1000 character..."></textarea>
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="editcustomSwitch1" name="edit_faq_status" value="1">
                            <label class="custom-control-label" for="editcustomSwitch1">Active</label>
                        </div>
                        <br>
                        <input type="hidden" name="edit_faq_id" id ="edit_faq_id">
                        <input type="hidden" name="edit_faq" value="edit_faq">

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
                    <h4 class="modal-title" id="myCenterModalLabel">View FAQ Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" name="" class="parsley-examples" id="demo-form">
                        <div class="form-group">
                            <label>Question</label>
                            <div class="faqquestionsdetails">
                                <p id='qus_id'></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <div class="faqanswerdetails">
                                <p id='ans_id'></p>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--Status update confirmation dialog -->
    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                <form action="<?php echo base_url();?>admin/faq" method="post" id="demo-form">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Are you sure you want to update the status?</p>
                        <div class="button-list">
                            
                                <input type="hidden" name="faq_id" id="faq_id">
                                <input type="hidden" name="faq_status" id ="faq_status">
                                <input type="hidden" name="faq_status_change" value="faq_status_change">
                            <button type="submit" name="submit" class="btn btn-danger" >Yes</button>                           
                            <button type="cancel" class="btn btn-success" data-dismiss="modal">No</button>
                                
                        </div>
                    </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Are you sure want to delete the record?</p>
                        <form action="<?php echo base_url(); ?>admin/faq" method="post">
                        <div class="button-list">
                            <button type="submit" class="btn btn-danger">Yes</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                        </div>
                        <input type="hidden" name="delete_faq" value="delete_faq">
                        <input type="hidden" name="delete_faq_id" id="delete_faq_id">
                            
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

 <?php
include 'footer.php'
?>


    <!-- Validation init js-->
    <script src="<?php echo base_url(); ?>assets/js/pages/form-validation.init.js"></script>
<?php 
  if($this->session->flashdata('faq_success')!="")
  {
    ?>
   <!--  <script type="text/javascript">
        alert('<?php echo $this->session->flashdata('faq_success'); ?>');
    </script> -->
    <?php 
  }
?>
<script type="text/javascript">
    function view_qus_ans(qus,ans)
    { 
       document.getElementById('qus_id').innerHTML = qus;
       document.getElementById('ans_id').innerHTML = ans;
      
    }

    function update_status(faq_status,faq_id)
    {
        if(faq_status==1)
        {
            faq_status = 0;
        }
        else if(faq_status==0)
        {
            faq_status = 1;
        }
        document.getElementById('faq_id').value = faq_id;
        document.getElementById('faq_status').value = faq_status;

    }
    function update_data(faq_status,faq_id,faq_question,faq_answer,faq_user)
    {
        console.log({faq_answer});
            document.getElementById('edit_faq_id').value = faq_id;
            document.getElementById('edit_question').value = faq_question;
            document.getElementById('edit_answer').value = faq_answer;
            document.getElementById('edit_faq_user').value = faq_user;
            console.log({faq_status});
            if(faq_status==1)
            {
                document.getElementById("editcustomSwitch1").checked = true;
            }
            else
            {
                document.getElementById("editcustomSwitch1").checked = false;
            }
    }
    function delete_faq(faq_id)
    {
        document.getElementById('delete_faq_id').value = faq_id;
    }
</script>
</body>

</html>