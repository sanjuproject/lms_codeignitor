<!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title parsley-examples">Manage Parents > Children Details</h4>
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="<?= base_url(); ?>admin/manageparents/<?= $manage_parent_page; ?>" class="btn btn-primary" id="backBtn">Back</a>
                        </div>
                    </div>
                    <!-- end page title -->
				<?php include("error_message.php");?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-8">

                                            <!-- <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#custom-modal"><i
                                                    class="mdi mdi-plus-circle mr-2"></i> Remove Selected Children</a> -->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-sm-right">
                                                <form action="#" id="demo-form">
                                                    <div class="form-group mb-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search"
                                                                aria-label="Recipient's username">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary waves-effect waves-light"
                                                                    type="button">Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                   
                                                    <th># SL NO.</th>
                                                    <th>Child Code</th>
                                                    <th>P.Photo</th>
                                                    
                                                    <th class="namecol">Name</th>
                                                    <th>Age (DOB)</th>
                                                    <th class="mobilecol">Mobile</th>
                                                    <th class="emailcol">Email</th>
                                                    <th>Level</th>
                                                    <th>Payment Status</th>
                                                    <th>C.S Date</th>
                                                    <th>C.Status</th>
                                                    <th>Status</th>
                                                    <th class="actioncol">Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                $sl=1;
                                                foreach ($result as $value) {
                                                    $child_id = $value->ss_aw_child_id;
                                                    $child_status = $value->ss_aw_child_status;
                                                     ?>

                                                <tr>
                                                    

                                                    <td><?php echo $sl; ?></td>
                                                    <td>
                                                        <?php echo  $value->ss_aw_child_code; ?>
                                                    </td>
                                                    <td class="table-user">
                                                        <img src="<?php echo base_url(); ?>uploads/profile.jpg" alt="table-user"
                                                            class="mr-2 rounded-circle">
                                                        <!-- <a href="javascript:void(0);" class="text-body font-weight-semibold">Paul J. Friend</a> -->
                                                    </td>
                                                     
                                                    <td>
                                                        <?php echo  $value->ss_aw_child_nick_name; ?>
                                   
                                                    </td>
                                                    <td><?php echo  $value->ss_aw_child_age; ?> yrs (<?php echo date("d M, Y", strtotime($value->ss_aw_child_dob)); ?>)</td>
                                                    <td><?php echo  $value->ss_aw_child_mobile; ?></td>
                                                    <td>
                                                        <?php
                                                        if($value->ss_aw_child_email!="")
                                                        {
                                                            echo $value->ss_aw_child_email;
                                                        }
                                                        else{
                                                            echo $value->ss_aw_parent_email;
                                                        } 
                                                        ?>
                                                   
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($value->course == 1) {
                                                            echo "E";
                                                        }
                                                        elseif ($value->course == 2) {
                                                            echo "C";
                                                        }
                                                        elseif ($value->course == 3){
                                                            echo "A";
                                                        }
                                                        else{
                                                            echo "NA";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                    <?php 
                                                        if ($paymentstatus[$value->ss_aw_child_id]['payment_status'] == 1){
                                                            ?>
                                                            <a href="#" class="badge badge-soft-success">Paid</a>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <a href="#" onclick="return make_payment('<?php echo $child_id; ?>')" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#payment-modal">Mark As Pay</a>
                                                            <?php
                                                        } 
                                                    ?>        
                                                    </td>
                                                    <td><?= date('d F, Y', strtotime($value->course_start_date)); ?></td>
                                                    <td>
                                                        <a href="#">Lessons: <?= $lessoncount[$value->ss_aw_child_id]; ?></a>
                                                        <a href="#">Assessments: <?= $assessmentcount[$value->ss_aw_child_id]; ?></a>
                                                        <a href="#">ReadAlong: <?= $readalongcount[$value->ss_aw_child_id]; ?></a>
                                                    </td>
                                                   <td>
                                                    <?php
                                                    if($child_status==1)
                                                    {
                                                        ?>
                                                        <a href="#" onclick="return change_active_status('<?php echo $child_id; ?>','<?php echo $child_status; ?>')" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#warning-status-modal">Active</a>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <a href="#" onclick="return change_active_status('<?php echo $child_id; ?>','<?php echo $child_status; ?>')" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#warning-status-modal">Not-Active</a>
                                                        <?php
                                                    } 
                                                    ?>
                                                    
                                                    </td>

                                                    <td class="actioncell">
                                                        <!-- <a href="javascript:void(0);" class="action-icon"  title="Edit" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a> -->
                                                        <a href="javascript:void(0);" onclick="return delete_child('<?php echo $child_id; ?>');" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true">
                                                            <i class="mdi mdi-delete"></i></a>

                                                    </td>
                                                </tr>
                                                   <?php
                                                   $sl++;
                                                 } 
                                                ?>


                                               
                                            </tbody>
                                        </table>
                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>






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
                                <p class="mt-3">Deleting will remove this child from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                        <input type="hidden" name="delete_child" value="delete_child">
                                         <input type="hidden" name="delete_child_id" id="delete_child_id">     
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
                                <p class="mt-3">Are you sure you want to update the status?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post"> 
                                    <input type="hidden" name="chnage_child_status" value="chnage_child_status">   
                                    <input type="hidden" name="status_child_id" id="status_child_id">                        
                                    <input type="hidden" name="status_child_status" id="status_child_status">                        
                                    
                                    <button type="submit" class="btn btn-danger">Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <!-- Mark as payment modal -->
            <div id="payment-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <h4 class="mt-2">Make Payment</h4>
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>admin/mark_payment" method="post">
                                        <input type="hidden" name="payment_child_id" id="payment_child_id">
                                        <input type="hidden" name="payment_parent_id" id="payment_parent_id" value="<?= $parent_id; ?>">
                                        <div class="form-group">
                                            <label>Course</label>
                                            <select name="course_id" id="course_id" class="form-control">
                                                <option value="">Choose One</option>
                                                <?php
                                                if (!empty($courses)) {
                                                    foreach ($courses as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value['ss_aw_course_id'] ?>"><?= $value['ss_aw_course_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Transaction ID</label>
                                            <input type="text" name="transaction_id" id="transaction_id" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Payment Amount</label>
                                            <input type="text" name="payment_amount" id="payment_amount" class="form-control">
                                        </div>    
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- End of section -->
            <?php
                include('bottombar.php');
            ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <?php
            include('footer.php')
        ?>
  <script type="text/javascript">
     function change_active_status(child_id,child_status)
     {
         if(child_status==1)
         {
            child_status = 0;
         }
         else
         {
            child_status = 1;
         }
           document.getElementById('status_child_id').value = child_id;
           document.getElementById('status_child_status').value = child_status;
     }

     function delete_child(child_id)
     {
        document.getElementById('delete_child_id').value = child_id;
     }

     function make_payment(child_id){
        document.getElementById('payment_child_id').value = child_id;
     }
  </script>      

</body>

</html>