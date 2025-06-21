 <!-- ============================================================== -->
 <!-- Start Page Content here -->
 <!-- ============================================================== -->
 <style>
     .challange_image {
         width: 100px;
         height: 100px;
     }
 </style>
 <div class="content-page">
     <div class="content">

         <!-- Start Content-->
         <div class="container-fluid">
             <!-- start page title -->
             <!-- start page title -->
             <div class="row">
                 <div class="col-12">
                     <div class="page-title-box">
                         <ol class="breadcrumb m-0">
                             <li class="breadcrumb-item">Manage Quiz</li>

                             <li class="breadcrumb-item active">List of Quiz</li>
                         </ol>

                     </div>
                 </div>

             </div>

             <div class="row">

                 <div class="col-md-6">
                     <h4 class="page-title">Quiz List</h4>
                 </div>

             </div>

             <?php include("error_message.php"); ?>

             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <div class="card-body">

                             <div class="table-responsive gridview-wrapper">
                                 <table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
                                     <thead class="thead-light">
                                         <tr>
                                             <th>Id</th>
                                             <th>Quiz Name</th>
                                             <th>Quiz Image</th>
                                             <th>Published Date</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>


                                     <tbody>

                                         <?php foreach ($quiz_list_data as $key => $value) {
                                            ?>
                                             <tr>

                                                 <td><?= $value->ss_aw_challange_id; ?></td>
                                                 <td><?= $value->challange_name; ?></td>

                                                 <?php
                                                 if ($value->challange_type == 'crossword') {
                                                    ?>
                                                    <td><img src="<?= base_url(); ?><?= $value->challange_image; ?>" alt="Quiz Challange" class="mr-2 challange_image"></td>
                                                    <?php
                                                 }
                                                 else{
                                                    ?>
                                                    <td><?= $value->challange_image; ?></td>
                                                    <?php
                                                 }
                                                 ?>
                                                 
                                                 <td><?= $value->challange_pub_date; ?></td>
                                                 <td class="actioncell">
                                                    <?php
                                                    if (empty($value->challange_pub_date)) {
                                                        ?>
                                                        <?php
                                                        if ($value->is_draft == 1) {
                                                            ?>
                                                            <a href="#" onclick="return change_status('<?php echo $value->ss_aw_challange_id; ?>','<?= $value->is_draft; ?>');" class="badge badge-soft-success" data-toggle="modal"
                                                                data-target="#warning-status-modal">Active</a>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <a href="#" onclick="return change_status('<?php echo $value->ss_aw_challange_id; ?>','<?= $value->is_draft; ?>');" class="badge badge-soft-danger" data-toggle="modal"
                                                                data-target="#warning-status-modal">Inactive</a>
                                                            <?php
                                                        }
                                                        
                                                    }
                                                    ?>
                                                     <a class="action-icon" href="<?= base_url(); ?>admin/quiz_list_id_wise_view/<?= $value->ss_aw_challange_id; ?>"> <i class="mdi mdi-eye-outline"></i></a>
                                                     <?php
                                                        $current_date =  date('Y-m-d H:i:s');
                                                        // echo $value->challange_pub_date;
                                                        // echo $current_date;
                                                        if (empty($value->challange_pub_date)) {
                                                        ?>


                                                         <a href="<?= base_url(); ?>admin/update_quiz/<?= $value->ss_aw_challange_id; ?>" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                         <a class="action-icon" href="javascript:void(0)"> <i class="mdi mdi-delete" data-toggle="modal" data-target="#warning-delete-modal" title="Delete" onclick="quiz_delete(<?= $value->ss_aw_challange_id ?>);"></i></a>
                                                     <?php
                                                        }
                                                        ?>
                                                 </td>
                                             </tr>
                                         <?php } ?>

                                     </tbody>
                                 </table>

                             </div>

                         </div> <!-- end card body-->
                     </div> <!-- end card -->
                 </div><!-- end col-->
             </div>
             <div class="row">
                 <div class="col-md-6">

                     <form>

                         <!-- <div class="footerformView mb-2">
                                    <select class="form-control adminusersbottomdropdown" id="drpMultipleCta">
                                        <option value="" select>Please Select</option>
                                        <option value="1">Add new topic</option>
                                        <option id="delete_option_id" value="2">Deleted selected options</option>
                                    </select>
                                    <button type="button" id="btnGo" onclick="dofunctions();"
                                        class="btn btn-primary waves-effect waves-light goBtn">
                                        Go
                                    </button>
                                </div> -->

                     </form>
                 </div>

                 <div class="col-md-6">
                     <div class="text-right">
                         <!-- Show pagination links -->
                         <?php foreach ($links as $link) {
                                echo "<li>" . $link . "</li>";
                            } ?>
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
                         <p class="mt-3">Deleting will remove this record from the system. Are you sure ?
                         </p>
                         <div class="button-list">
                             <form action="<?php echo base_url() ?>admin/delete_quiz" method="post">
                                 <input type="hidden" name="quiz_id" id="quiz_id">

                                 <button type="submit" class="btn btn-danger">Yes</button>
                                 <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                             </form>
                         </div>
                     </div>
                 </div>
             </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
     </div>

     <?php
        include('includes/bottombar.php');
        ?>

 </div>

 <!-- ============================================================== -->
 <!-- End Page content -->
 <!-- ============================================================== -->

 </div>

 <!--Status update confirmation dialog -->
            <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3" id="status_warning_msg">Are you sure you want to change the status?</p>
                               
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>admin/change_draft_status" method="post">
                                     <input type="hidden" id="draft_quiz_id" name="quiz_id">
                                     <input type="hidden" id="draft_quiz_status" name="draft_status">
                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
 <!-- END wrapper -->

 <style type="text/css">
     .custom-form-control {

         width: 50px;

     }

     .selectize-dropdown {
         z-index: 99999;
     }

     .selectize-dropdown-header {
         display: none;
     }

     .dropify-wrapper .dropify-message p {
         line-height: 50px;
     }

     .custom-color {
         background-color: #3283f6;
         margin-right: 10px;
     }

     .templete {
         display: flex;
         align-items: center;
         justify-content: space-between;
     }

     .card {
         box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
     }

     .card-box {
         border: 1px solid #ced4da;
     }

     /*******Start-debasis******/
     .content-right {
         justify-content: flex-end;
     }

     /*******End-debasis******/
     .topselectdropdown {
         width: 200px;
     }

     .content-right button i {
         font-size: 16px;
     }
 </style>

 <?php
    include('footer.php')
    ?>



 <script type="text/javascript">
     function quiz_delete(quiz_id) {
         $("#quiz_id").val(quiz_id);
     }

     function change_status(quiz_id, draft_status){
        $("#draft_quiz_id").val(quiz_id);
        $("#draft_quiz_status").val(draft_status);
     }
 </script>


 </body>

 </html>