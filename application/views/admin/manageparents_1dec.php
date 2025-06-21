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
                                <h4 class="page-title parsley-examples">Manage Parents</h4>
                            </div>
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


                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url() ?>admin/manageparents" method="post" id="demo-form">
                                                    <div class="form-group mb-3">
                                                        <div class="input-group">
                                                            <input type="text" name="search_parent_data" class="form-control" placeholder="Search Parent Name"
                                                                aria-label="Recipient's username"
                                                                <?php
                                                                 if(isset($search_parent_data))
                                                                 {
                                                                   echo 'value="'.$search_parent_data.'"';
                                                                 } ?>
                                                                 >
                                                                <input type="hidden" name="search_parent" value="search_parent">
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
                                            <thead>
                                                <tr>
                                                    
                                                    
                                                    <th>Profile Photo</th>
                                                    <th class="namecol">Name</th>
                                                    <th class="mobilecol">Mobile</th>
                                                    <th class="emailcol">Email</th>
                                                    <th>City</th>
                                                    <th class="childrencol">Children</th>
                                                    <th>Status</th>
                                                    <th class="actioncol">Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                $sl = 1;
                                                foreach ($result as $value) {          
                                                 $parent_id = $value->ss_aw_parent_id;
                                                ?>

                                                <tr>
                                                   

                                                    
                                                    
                                                    <td class="table-user">
                                                        <?php
                                                        if($value->ss_aw_parent_profile_photo!="")
                                                        {
                                                          $photo = base_url()."uploads/".$value->ss_aw_parent_profile_photo; 
                                                        }
                                                        else{
                                                            $photo = base_url()."uploads/profile.jpg";
                                                        } 
                                                        ?>
                                                        <img src="<?php echo $photo; ?>" alt="table-user"
                                                            class="mr-2 rounded-circle">
                                                        <!-- <a href="javascript:void(0);" class="text-body font-weight-semibold">Paul J. Friend</a> -->
                                                    </td>
                                                    <td>
                                                        <?php echo $value->ss_aw_parent_full_name; ?>
                                                    </td>
                                                    <td><?php echo $value->ss_aw_parent_primary_mobile; ?></td>
                                                    <td><?php echo $value->ss_aw_parent_email; ?></td>
                                                    <td><?php echo $value->ss_aw_parent_city; ?></td>
                                                    <td class="table-children">
                                                        <?php
                                                         if ($value->num_childs>0) {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>admin/childrendetails/<?php echo $parent_id; ?>"><?php echo $value->num_childs; ?></a>
                                                            <?php                     
                                                          }
                                                          else{
                                                            ?>
                                                             <a href="#"><?php echo $value->num_childs; ?></a>
                                                            <?php 
                                                          } 
                                                        ?>
                                                        </td>
                                                    <?php
                                                     $parent_status=$value->ss_aw_parent_status; 
                                                    ?>
                                                    <td>
                                                        <?php
                                                        if($parent_status==1)
                                                        {
                                                            ?>

                                                        <a href="#" onclick="return change_status('<?php echo $parent_id ?>','<?php echo $parent_status ?>');" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#warning-status-modal">Active</a></td>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="#" onclick="return change_status('<?php echo $parent_id ?>','<?php echo $parent_status ?>');" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#warning-status-modal">In Active</a>
                                                            <?php
                                                        } 
                                                        ?>

                                                    <td>
                                                        <!-- <a href="javascript:void(0);" class="action-icon" title="Edit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a> -->
                                                        <a href="javascript:void(0);" onclick="return parent_delete('<?php echo $parent_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"   title="Delete" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-delete"></i></a>
													<?php
													if(!empty($value->ss_aw_parent_auth_key)){
													?>
                                                         <a href="javascript:void(0);" onclick="return parent_logout('<?php echo $parent_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-logout-modal"   title="Logout" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="fe-log-out"></i></a>        
                                                    <?php } ?>   
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
                                <p class="mt-3">Deleting will remove this parent from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url() ?>admin/manageparents" method="post">
                                        <input type="hidden" name="parent_delete_process" value="parent_delete_process">
                                        <input type="hidden" name="parent_delete_id" id="parent_delete_id">
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
                                    <form action="<?php echo base_url(); ?>admin/manageparents" method="post">
                                     <input type="hidden" id="status_parent_id" name="status_parent_id">   
                                     <input type="hidden" id="status_parent_status" name="status_parent_status">   
                                     <input type="hidden" name="parent_status_change" value="parent_status_change">   
                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <div id="warning-logout-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">Are you sure you want to logout parents?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>admin/manageparents" method="post">
                                     <input type="hidden" id="logout_parent_id" name="logout_parent_id">   
                                    
                                     <input type="hidden" name="parent_logout" value="parent_logout">   
                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

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
     function change_status(parent_id,parent_status){
          if(parent_status==1)
          {
            parent_status = 0;
          }
          else
          {
            parent_status = 1;
          }
          document.getElementById('status_parent_status').value = parent_status;
          document.getElementById('status_parent_id').value = parent_id;

     }
     function parent_delete(parent_id)
     {
         document.getElementById('parent_delete_id').value = parent_id;
     }
     function parent_logout(parent_id)
     {
           document.getElementById('logout_parent_id').value = parent_id;
     }
  </script>      

</body>

</html>