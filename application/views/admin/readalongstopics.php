<?php 
// echo "<pre>";
// print_r($search_parent_data);
// exit();
?>
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
                                <ol class="breadcrumb m-0">
                                    <!-- start-debasis -->

                                    <li class="breadcrumb-item active">ReadAlongs Topics</li>
                                    <li class="breadcrumb-item active">List of ReadAlongs Topics</li>
                                    <!-- start-debasis -->
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                             <!-- start-debasis -->
                            <h4 class="page-title">ReadAlongs Topics</h4>
                            <!-- start-debasis -->
                        </div>

                        <div class="col-md-6">



                            <div class="footerformView float-right mb-2">
                                <!-- start-debasis -->
                                <form>
                                <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="dofunctions(this.value);">
                                        <option value="0" select>Please Select</option>
                                        <option value="1">Add ReadAlong Topics</option>
                                        <option value="2">Remove selected ReadAlongs Topics</option>
                                    </select>
                                     <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                </form>
                                 <!--end-debasis -->
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
                                        <div class="col-sm-3">
                                    
                                            <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#modal-add-readalongtopics"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add ReadAlong Topics</a>
                                        </div>
                                        <!-- start-debasis -->
                                        <div class="col-sm-9">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url(); ?>admin_course_content/readalongstopics" id="search-demo-form" method="post">
                                                    <input type="hidden" name="search_filter" value="search_filter">
                                                    <div class="row content-right">
                            
                                                                    <div class="form-group mb-3">
                                                                        <div class="input-group">
                                                                            <select
                                                                                class="form-control topselectdropdown"
                                                                                id="drpStatus" name="status" onchange="filter_data();">
                                                                                <option value=""<?php if(empty($search_parent_data['ss_aw_section_status']) ){?>selected <?php } ?>>Status</option>
                                                                                <option value="1"
                                                                                <?php if(!empty($search_parent_data['ss_aw_section_status']) && $search_parent_data['ss_aw_section_status'] == 1){?>selected <?php } ?>>Active</option>
                                                                                <option <?php if(!empty($search_parent_data['ss_aw_section_status']) && $search_parent_data['ss_aw_section_status'] == 2){?>selected <?php } ?> value="0">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                         
                                                        <div class="ml-2 mr-2">
                                                            <button type="button" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Clear</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- end-debasis -->
                                    </div>

                                    <div class="table-responsive gridview-wrapper">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                            data-show-columns="true">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck1">
                                                            <label class="custom-control-label"
                                                                for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Topic ID</th>
                                                    <th>Level</th>
                                                    <th>Topic/ Section Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
											<form action="<?php echo base_url();?>admin_course_content/multipledeletereadalongtopic" id="deletereadalongtopicform" method="post">
                                                <?php 
                                                $sl=1;
                                                foreach ($result as $key=>$value) {
                                                    $topic_status = $value->ss_aw_section_status;
                                                    $topic_name = $value->ss_aw_section_title;
                                                    $topic_id = $value->ss_aw_section_id;
                                                    $topic_level = $value->ss_aw_expertise_level;
                                                 ?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $topic_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>

                                                    
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $value->ss_aw_expertise_level; ?></td>
                                                    <td><?php echo $value->ss_aw_section_title; ?></td>


                                                    <td>
                                                        <?php
                                                        if($topic_status==1)
                                                        {
                                                            ?>
                                                        <a href="#" class="badge badge-soft-success"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $topic_id ?>',0);">Active</a>
                                                            <?php
                                                             }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="#" class="badge badge-soft-danger"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $topic_id ?>',1);">
                                                           In Active</a>
                                                            <?php
                                                        } 
                                                        ?>

                                                    </td>
                                                    <td>
                                                    <a href="javascript:void(0);"  class="action-icon" data-toggle="modal" data-target="#modal-edit-readalongtopics" onclick="return update_readalongstopics('<?php echo $topic_id; ?>','<?php echo $topic_name; ?>','<?php echo $topic_level; ?>')"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" onclick="return readlong_delete('<?php echo $topic_id; ?>');" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete"> <i class="mdi mdi-delete"></i></a>
                                                    </td>

                                                </tr>

                                                <?php
                                                $sl++;
                                                }

                                                ?>
											</form>
                                            </tbody>
                                        </table>

                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">


                        </div>

                        <div class="col-md-6">
                            <div class="text-right">
                                <ul class="pagination pagination-rounded justify-content-end">
                                    <?php foreach ($links as $link) {
                                    echo "<li>". $link."</li>";
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>



                    <!--Status update confirmation dialog -->
                    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                         <p class="mt-3" id="status_warning_msg"></p>
                                        <div class="button-list">
                                            <form action="<?php echo base_url() ?>admin_course_content/readalongstopics" method="post">
                                            <input type="hidden" id="status_topic_id" name="status_topic_id">   
                                             <input type="hidden" id="status_topic_status" name="status_topic_status">   
                                             <input type="hidden" name="topic_status_change" value="topic_status_change"> 
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

                    <!-- Delete confirmation dialog -->
                    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Deleting will remove this ReadAlong Topic from the system. Are you
                                            sure ?
                                        </p>
                                        <div class="button-list">

                                            <form action="<?php echo base_url() ?>admin_course_content/readalongstopics" method="post">
                                            <input type="hidden" name="topic_delete_process" value="1" id="topic_delete_process">
                                             <input type="hidden" name="topic_delete_id" id="topic_delete_id">
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
                    <div class="modal fade" id="modal-add-readalongtopics" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Add New ReadAlong Topic</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url() ?>admin_course_content/readalongstopics" id="demo-form" class="parsley-examples" id="modal-demo-form" method="post">
                        
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                            
                                                <label for="level">Level<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select class="form-control select2-multiple"
                                                                        id="level" data-toggle="select2"
                                                                        multiple="multiple"
                                                                        data-placeholder="Multiple Roles" name="read_level[]">
																		<option value="E">E Level</option>
																		<option value="C">C Level</option>
                                                                        <option value="A">A Level</option>
                                                                        
                                                                        

                                                                    </select>
                                                                </div>
                                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                            </div>
                                                            
                                          
                                            <div class="form-group col-md-12">
                                                <label for="Topic">Topic Name<span
                                                        class="text-danger">*</span></label>
                                                        <input name="read_name" class="form-control" type="text" id="Topic" placeholder="ReadAlong Title" required>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                <input type="hidden" name="add_readlong" value="add_readlong">
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Add ReadAlong Topic
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->



                  <!--  ------------------------------- -->

                    <!-- Modal -->
                    <div class="modal fade" id="modal-edit-readalongtopics" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit ReadAlong Topic</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url() ?>admin_course_content/readalongstopics" id="demo-form" class="parsley-examples" id="modal-demo-form" method="post">
                        
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                            
                                                <label for="edit_topiclevel">Level<span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select class="form-control select2-multiple edit_level"
                                                                        id="edit_topiclevel" data-toggle="select2"
                                                                        multiple="multiple"
                                                                        data-placeholder="Multiple Roles" name="edit_topiclevel[]">
																		<option id="edit_E" value="E">E Level</option>
                                                                        <option id="edit_C" value="C">C Level</option>
																		<option id="edit_A" value="A">A Level</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                            </div>
                                                            
                                          
                                            <div class="form-group col-md-12">
                                                <label for="Topic">Topic Name<span
                                                        class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="edit_topic" name="edit_topic" placeholder="ReadAlong Title" required>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Update ReadAlong Topic
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                        <input type="hidden" name="edit_id" id="edit_id">
                                        <input type="hidden" name="update_readlong" value="update_readlong">
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                  
					<div id="warning-all-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Deleting will remove those selected readalongs topics from the system. Are you
                                            sure ?
                                        </p>
                                        <div class="button-list">
                                            <button type="button" id ="yes_delete_all"  class="btn btn-danger"
                                               >Yes</button>
                                            <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                  <!--  ------------------------------- -->



                </div> <!-- container -->

            </div> <!-- content -->

            <?php
                include('includes/bottombar.php');
            ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

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

    .card-box {
        border: 1px solid #ced4da;
    }
    .bg-light{
        background-color: #eceff1!important;
    }
      /*******Start-debasis******/
      .content-right{
        justify-content: flex-end;
    }
    .topselectdropdown{
        width: 200px !important;
    }
    .card{
        box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%) !important;
    }
    /*******End-debasis******/
    </style>

    <?php
            include('footer.php')
        ?>
      <link href="<?php echo base_url(); ?>assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />    
    <!-- Table Editable plugin-->
    <script src="<?php echo base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="<?php echo base_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script> -->

    
    <!-- <script src="<?php echo base_url(); ?>assets/libs/select2/js/select2.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- Validation init js-->
   <!--  <script src="<?php echo base_url(); ?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/form-advanced.init.js"></script> -->

    <script>
    jQuery(function() {
        
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus,#drpTopic').prop('selectedIndex', 0);

            filter_data();
        });

        jQuery('#customCheck1').click(function() {
            let $this = jQuery(this);
            let thisCheckedState = jQuery(this).is(':checked');
            let listOfCheckboxes = $this.closest('table').find('tbody tr td:first-child :checkbox');

            if (thisCheckedState) {
                listOfCheckboxes.each(function() {
                    jQuery(this).prop('checked', true);
                });
            } else {
                listOfCheckboxes.each(function() {
                    jQuery(this).prop('checked', false);
                });
            }

        });
        jQuery('tbody tr td:first-child :checkbox').click(function() {
            let $this = jQuery(this);
            let thisCheckedState = $this.is(':checked');
            let targetCheckbox = $this.closest('table').find('tr th:first-child :checked');
            if (!thisCheckedState) {
                targetCheckbox.prop('checked', false);
            }
        });

        jQuery('#fileUploadAgain').change(function() {
            jQuery('#lblFileName').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });

    });
    </script>
    <script type="text/javascript">
     function update_readalongstopics(topic_id,topic_name,topic_level)
     {          
        var topic_level_array = topic_level.split(',');
        var i;

          jQuery('#edit_A').attr('selected', false);   
          jQuery('#edit_E').attr('selected', false);   
          jQuery('#edit_C').attr('selected', false);   


        for (i = 0; i < topic_level_array.length; i++) {

               if(topic_level_array[i]=='A')
               {
                  jQuery('#edit_A').attr('selected', true);                  
                           
               }
               if(topic_level_array[i]=='E')
               {
                 jQuery('#edit_E').attr('selected', true);             
                          
               }
               if(topic_level_array[i]=='C')
               {             
                jQuery('#edit_C').attr('selected', true);                           
                             
               }            
                jQuery('#edit_topiclevel').select2();              
             
            }
           $("#edit_id").val(topic_id); 
           $("#edit_topic").val(topic_name); 
     }

     function filter_data()
        {
            
            $("#search-demo-form").submit();
        } 
        function change_status(topic_id,topic_status)
        {
           
            if(topic_status==0)
            {
                 $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
            }
            else
            {
               $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
            }
            $("#status_topic_id").val(topic_id);
            $("#status_topic_status").val(topic_status);
        }

        function readlong_delete(id)
        {
            $("#topic_delete_id").val(id);
        } 

function dofunctions(value)
{
	if(value == 1)
	{
		$("#modal-add-readalongtopics").modal('toggle');
	}
	else if(value == 2)
	{
        $('#checkboxdata input:checked').each(function() {

            $('#warning-all-delete-modal').modal('show');

            $("#yes_delete_all").click(function(){
              
              $("#deletereadalongtopicform").submit();
            });
                
            }); 
	}	
}		
    </script>

</body>

</html>