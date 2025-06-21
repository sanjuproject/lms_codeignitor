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
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/topics">Manage Sub Topics</a></li>

                                    <li class="breadcrumb-item active">List of Sub Topic</li>
</ol>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row mt-2 mb-2">
                    <div class="col-6">
                        <h4 class="page-title">Sub Topics</h4>
                                
                        </div>
                        <div class="col-6">
                            <div class="footerformView float-right mb-2">
                                <!-- start-debasis -->
                                <form>
                                    <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="dofunctions();">
                                         <option value="" select>Please Select</option>
                                       <!--  <option value="1">Add new sub topic</option> -->
                                        <option id="delete_option_id" value="2">Deleted selected options</option>
                                    </select>
                                   <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                   
                                </form>
                                 <!-- end-debasis -->
                            </div>
                        </div>
                    </div>
                    <!-- end-debasis -->
                    <!-- end page title -->

					<?php include("error_message.php");?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row mb-2">
                                        <div class="col-sm-4">

                                           <!--  <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#modal-add-subtopic"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add New Sub Topic</a> -->
                                        </div>
										<!-- Start-debasis -->
                                        <div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url();?>admin/subtopics/<?php echo $topic_id;?>" method="post" id="demo-form">
												<input type="hidden" name="ss_aw_topic_id" value="<?php echo $topic_id;?>" />
                                                    <div class="row content-right">
                                                       
                                                            <div class="form-group mb-3">
                                                              
                                                                    <input type="text" name="searchdata" class="form-control"
                                                                        id="txtFilter" value="<?php if(!empty($search_data['ss_aw_section_title'])){echo $search_data['ss_aw_section_title']; }?>" placeholder="Sub topic name"
                                                                        aria-label="Recipient's username">
                                                                 
                                                            </div>
                                                        
                                                        
                                                            <div class="form-group mb-3 ml-2">
                                                                <div class="input-group">
                                                                    <select
                                                                        class="form-control adminusersbottomdropdown"
                                                                        id="drpStatus" name="ss_aw_section_status" onchange="searchsubtopic();">
                                                                        <option value="" select>Status</option>
                                                                        <option value="1" <?php if(!empty($search_data['ss_aw_section_status']) && $search_data['ss_aw_section_status'] == 1){?> selected <?php } ?>>Active</option>
                                                                        <option value="2" <?php if(!empty($search_data['ss_aw_section_status']) && $search_data['ss_aw_section_status'] == 2){?> selected <?php } ?>>Inactive</option>
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
                                        <!-- End-debasis -->
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
                                                    
                                                    
                                                    <th>Topic Name</th>
                                                    <th>Sub Topic Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
											<form action="<?php echo base_url();?>admin/multipledeletesubtopic" id="deletedata" method="post">
											<input type="hidden" name="ss_aw_topic_id" value="<?php echo $topic_id;?>" />
											<?php
											if($result){
												foreach($result as $key=>$value){
											?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $value->ss_aw_subtopic_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>" >
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>
                                                    
                                                    
                                                    <td><?php echo $value->topic_title;?></td>
                                                    <td><?php echo $value->ss_aw_section_title;?></td>

                                                    <td>
													<a href="#" class="badge <?php if($value->ss_aw_section_status == 1){ ?> badge-soft-success <?php } else { ?> badge-soft-danger <?php } ?>"
                                                            title="Make <?php if($value->ss_aw_section_status == 1){ ?> Inactive <?php } else { ?> Active <?php } ?>" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true"
                                                            data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return subtopic_status('<?php if($value->ss_aw_section_status == 1){
															?>0<?php }else{ ?>1<?php } ?>','<?php echo $value->ss_aw_subtopic_id; ?>');">
															<?php if($value->ss_aw_section_status == 1){
															?>Active<?php }else{ ?>Inactive<?php } ?></a>
															</td>
                                                    
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-edit-subtopic" onclick="editsubtopic(<?php echo $value->ss_aw_subtopic_id;?>);" class="action-icon" > <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" onclick="subtopic_delete(<?php echo $value->ss_aw_subtopic_id;?>);" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete"> <i class="mdi mdi-delete"></i></a>
                                                    </td>

                                                </tr>
												<?php }} ?>        
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

                            <!-- <form>

                                <div class="footerformView mb-2">
                                    <select class="form-control adminusersbottomdropdown" id="drpMultipleCta">
                                        <option value="" select>Please Select</option>
                                        <option value="1">Add new sub topic</option>
                                        <option id="delete_option_id" value="2">Deleted selected options</option>
                                    </select>
                                    <button type="button" id="btnGo" onclick="dofunctions();"
                                        class="btn btn-primary waves-effect waves-light goBtn">
                                        Go
                                    </button>
                                </div>

                            </form> -->
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
                                       
                                        <form action="<?php echo base_url();?>admin/subtopics" class="parsley-examples" method="post" id="modal-demo-form">
										<input type="hidden" name="topic_id" value="<?php echo $topic_id;?>" />
										<input type="hidden" name="subtopic_status_id" value="" id="subtopic_status_id" />
										<input type="hidden" name="subtopic_status" value="" id="subtopic_status" />
										<div class="button-list">
                                            <button type="submit" class="btn btn-danger"
                                                >Yes</button>
                                            <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                        </div>
										</form>
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
                                        <p class="mt-3">Deleting will remove this topic from the system. Are you sure ?
                                        </p>
										<form action="<?php echo base_url();?>admin/subtopics/" class="parsley-examples" method="post" id="modal-demo-form">
										<input type="hidden" name="topic_id" value="<?php echo $topic_id;?>" />
										<input type="hidden" name="subtopic_delete_id" value="" id="subtopic_delete_id" />
                                        <div class="button-list">
                                            <button type="submit" class="btn btn-danger"
                                                >Yes</button>
                                            <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                        </div>
									</form>	
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>



                    <!-- Modal -->
                    <div class="modal fade" id="modal-add-subtopic" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Add New Sub Topic
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-2">
                                    <form action="<?php echo base_url();?>admin/subtopics" class="parsley-examples" method="post" id="modal-demo-form">
									<input type="hidden" name="topic_id" value="<?php echo $topic_id;?>" />
									<input type="hidden" name="add_subtopic" value="1" />
                                        <div class="form-group">
                                            <label for="newtopic">Sub Topic Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="newtopic" name="subtopic_name"
                                                placeholder="New topic" required>
                                        </div>
                                        
                                        <div class="text-left">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Save</button>
                                             <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true"
                                                onclick="Custombox.close();">Cancel</button>
                                        </div>
                                    </form>

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
					
					
					<!-- Modal -->
                    <div class="modal fade" id="modal-edit-subtopic" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Edit Sub Topic
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-2">
                                    <form action="<?php echo base_url();?>admin/subtopics" class="parsley-examples" method="post" id="modal-demo-form">
									<input type="hidden" name="topic_id" value="<?php echo $topic_id;?>" />
									<input type="hidden" name="edit_subtopic" value="" id="edit_subtopic" />
                                        <div class="form-group">
                                            <label for="newtopic">Sub Topic Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="edittopic" name="subtopic_name"
                                                placeholder="New topic" required>
                                        </div>
                                        
                                        <div class="text-left">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Save</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                                onclick="Custombox.close();">Cancel</button>
                                        </div>
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
                                        <p class="mt-3">Deleting will remove this topic from the system. Are you
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
    .custom-form-control{

        width: 50px;
        
    }
    .selectize-dropdown{
        z-index: 99999;
    }
    .selectize-dropdown-header{
        display: none;
    }
    .dropify-wrapper .dropify-message p{
        line-height: 50px;
    }
    .custom-color{
        background-color: #3283f6;
        margin-right:10px;
    }
    .templete{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-box{
        border: 1px solid #ced4da;
    }
.content-right{
    justify-content: flex-end;
}
.topselectdropdown{
        width: 200px;
    }
    .content-right button i{
        font-size: 16px;
    }

    </style>
	
<?php
            include('footer.php')
        ?>
<!-- Table Editable plugin-->
<script src="<?php echo base_url();?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

<!-- Table editable init-->
<!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
<script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>

<script>
        ! function (t) {
            "use strict";

            function o() { }
            o.prototype.init = function () {
                t("#inline-editable").Tabledit({
                    inputClass: "form-control form-control-sm custom-form-control",
                    editButton: !1,
                    deleteButton: !1,
                    columns: {
                        identifier: [0, "id"],
                        editable: [
                            [1, "col1"]
                        ]
                    }
                })
            }, t.EditableTable = new o, t.EditableTable.Constructor = o
        }(window.jQuery),
            function () {
                "use strict";
                window.jQuery.EditableTable.init()
            }();
			
			
	 function change_status(lesson_id,lesson_status){
          if(lesson_status==1)
          {
            lesson_status = 0;
          }
          else
          {
            lesson_status = 1;
          }
          document.getElementById('status_lesson_status').value = lesson_status;
          document.getElementById('status_lesson_id').value = lesson_id;

     }
     function lesson_delete(lesson_id)
     {
		 document.getElementById('lesson_delete_process').value = 1;
         document.getElementById('lesson_delete_id').value = lesson_id;
     }
  		
    </script>

<script>
function subtopic_delete(id)
{
	$("#subtopic_delete_id").val(id);
}
function subtopic_status(status,id)
{
	$("#subtopic_status_id").val(id);
	$("#subtopic_status").val(status);
     if(status==1)
          {
            $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
          }
          else
          {
             $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
          }

}

    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus').prop('selectedIndex', 0);
			
			$("#demo-form").submit();
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

    });
	
function editsubtopic(subtopic)
{
	$.post("subtopics", { id: subtopic,get_subtopic:subtopic })
  .done(function( data ) {
	  var jsondata = JSON.parse(data);
	 $("#edittopic").val(jsondata.ss_aw_section_title);
	 $("#edit_subtopic").val(subtopic);
	});	  
}	

function searchsubtopic()
{
	$("#demo-form").submit();
}

function dofunctions()
{
	
	var selected_val = $("#drpMultipleCta option:selected").val();
	if(selected_val == 1)
		$("#modal-add-subtopic").modal('toggle');
	if(selected_val == 2)
	{

		$('#checkboxdata input:checked').each(function() {

            $('#warning-all-delete-modal').modal('show');

            $("#yes_delete_all").click(function(){
              
              $("#deletedata").submit();
            });
                
            }); 
	}
}
</script>

	

</body>
</html>
    	