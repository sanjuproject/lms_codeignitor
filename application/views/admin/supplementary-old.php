
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
                                    <li class="breadcrumb-item">Supplementary Content</li>
                                    <li class="breadcrumb-item active">List of Supplementary Content</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
					<?php include("error_message.php");?>
					<div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">List of Supplementary Content</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="footerformView float-right mb-2">
                                 <!-- start-debasis -->
                                <form>
                                <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="do_function(this.value);">
                                        <option value="" select>Please Select</option>
                                        <option value="1">Add Supplementary Content</option>
                                  
                                        <option id="delete_option_id" value="2">Remove selected Supplementary Content</option>
                                    </select>
                                    <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                </form>
                                    <!--end-debasis -->
                            </div>
                        </div>
                    </div>

                
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

									<div class="row mb-2">
                                        <div class="col-sm-4">

                                            <a href="javascript:void(0);" id="btnImportsupplementary"
                                                class="btn btn-danger mb-2" data-toggle="modal"
                                                data-target="#modal-add-supplementary"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add Supplementary Content</a>
                                        </div>
                                           <!-- start-debasis -->
                                        <div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url();?>admin_course_content/supplementary" method="post" id="demo-form">
												<input type="hidden" name="search_filter" value="filter" />
                                                    <div class="row content-right">
                                    
                                                            <div class="form-group mb-3">
                                                                    <input type="text" name="course_name" class="form-control topselectdropdown"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Recipient's username" value="<?php if(!empty($search_parent_data['ss_aw_course_name'])) echo $search_parent_data['ss_aw_course_name'];?>" />
                                                                
                                                            </div>
                                          
                                                            <div class="form-group mb-3 ml-2">
                                                                        <select
                                                                            class="form-control topicdropdown"
                                                                            id="drpLevel" name="choose_level" onchange="filter_data();">
																			<option value="" selected>Choose Level</option>
                                                                            <option value="E" <?php if(!empty($search_parent_data['ss_aw_level']) && $search_parent_data['ss_aw_level'] == "E"){?>selected <?php } ?>>Level E</option>
                                                                            <option value="C" <?php if(!empty($search_parent_data['ss_aw_level']) && $search_parent_data['ss_aw_level'] == "C"){?>selected <?php } ?>>Level C</option>
                                                                            <option value="A" <?php if(!empty($search_parent_data['ss_aw_level']) && $search_parent_data['ss_aw_level'] == "A"){?>selected <?php } ?>>Level A</option>
                                                                        </select>
                                                            
                                                            </div>
                                                            <div class="form-group mb-3 ml-2">
                                                            <select
                                                                            class="form-control topicdropdown"
                                                                            id="drpStatus" name="status" onchange="filter_data();">
                                                                            <option value="" select>Status</option>
                                                                            <option value="1" <?php if(!empty($search_parent_data['ss_aw_status']) && $search_parent_data['ss_aw_status'] == 1){?>selected <?php } ?>>Active</option>
                                                                            <option value="0" <?php if($search_parent_data['ss_aw_status'] == "0"){?>selected <?php } ?>>Inactive</option>
                                                                        </select>
                                                            </div>

                                                   
                                                        <div class="mr-2 ml-2">
                                                            <button type="button" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Clear</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0" id="inline-editable">
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
                                                    
                                                    
                                                    <th>Course Name</th>
                                                    <th>Level</th>
													<th>Topic</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
									<form action="<?php echo base_url();?>admin_course_content/multipledeletesupplementary" id="deletesupplementaryfrom" method="post">		
										<?php
									$status = "";	
									if(!empty($result))
									{										
										foreach($result as $key=>$value){
								
											$supplementary_id = $value->ss_aw_id;
											$status = $value->ss_aw_status;
										?>										
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $supplementary_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>
                                                    
       
                                                    
                                                    
													<td><?php echo $value->ss_aw_course_name;?></td>
													<td><?php echo $value->ss_aw_level;?></td>
													<td><?php echo $value->ss_aw_topic;?></td>
                                                   
												  
                                                    <?php
                                                     $supplementary_status=$value->ss_aw_status; 
													  
                                                    ?>
                                                    <td>
                                                        <?php
                                                        if($status==1)
                                                        {
                                                            ?>

                                                        <a href="#" onclick="return change_status('<?php echo $supplementary_id ?>',0);" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#warning-status-modal">Active</a></td>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="#" onclick="return change_status('<?php echo $supplementary_id ?>',1);" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#warning-status-modal">In Active</a>
                                                            <?php
                                                        } 
                                                        ?>

                                                    <td>
                                                        <button type="button" onclick="edit_supplementarydata('<?php echo $supplementary_id ?>','<?php echo $value->ss_aw_course_name;?>',
														'<?php echo $value->ss_aw_level;?>','<?php echo $value->ss_aw_topic;?>','<?php echo $value->ss_aw_voice_type;?>','<?php echo $value->ss_aw_description;?>');" data-toggle="modal" data-target="#custom-modal_edit"
                                                            class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                            Upload Again
                                                        </button>
                                                        <a href="javascript:void(0);" onclick="return supplementary_delete('<?php echo $supplementary_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"   title="Delete" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-delete"></i></a>

                                                               
                                                       
                                                    </td>

                                                </tr>
									<?php }}?>
										</form>
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

 <!-- Modal -->
                    <div class="modal fade" id="modal-add-supplementary" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">New Supplementary Content Upload
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/upload_supplymentary" enctype="multipart/form-data" method="post" id="demo-form" class="parsley-examples" id="modal-demo-form">
                                        <div class="form-row">
                                            <!-- <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p> -->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="course">Course Name<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control parsley-error" name="course_name" type="text" id="course"
                                                    placeholder="Course Name" required>

                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
											<div class="form-group col-md-12">
                                                <label for="course">Course Details<span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control parsley-error" name="course_details" type="text" id="course_details"
                                                    placeholder="Course Details" required ></textarea>

                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Level<span class="text-danger">*</span></label>
                                                <select id="" name="level" class="form-control parsley-error" onchange="gettopicsbylevel(this.value);" required="">
                                                    <option value="">Select</option>
                                                    <option value="E">Level E</option>
                                                    <option value="C">Level C</option>
                                                    <option value="A">Level A</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Topic<span
                                                        class="text-danger">*</span></label>
                                                <select id="topic_id" name="topic" class="form-control parsley-error" required="">
													<option value="">Select</option>
                                                    <?php
													foreach($topicslist as $key=>$val){
													?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
													<?php } ?>
                                                </select>
												<input type="hidden" value="" name="topic_name" id="topic_name">
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
											<div class="form-group col-md-12">
                                                <label>Choose Voice Type<span class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" name="voice_type" required="">
                                                   
                                                    <option value="">Voice type goes here</option>
                                                <?php
													foreach($voicetypelist as $key=>$value){
												?>	
													<option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                <?php 
													}
												?>		
                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Template<span
                                                        class="text-danger">*</span></label><br />
                                                <button type="button"
                                                    class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload Again
                                                    <input type="file" name="file" class="fileUploadAgain" required>
                                                </button><span id="lblFileName" class="lblFileName">No file
                                                    selected</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <!-- <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                <h6>Note : Only Excel file format allowed. Sample <a
                                                        href="<?php echo base_url();?>assets/templates/supplementary_excel.xlsx">Template</a> file found here.</h6>
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Add Supplementary Content
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
					
	<!-- Modal -->
                    <div class="modal fade" id="custom-modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit supplementary Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/edit_upload_supplementary" method="post" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data" >
									<input type="hidden" id="supplementary_id" name="supplementary_id" value="" readonly />
									
									<input type="hidden" id="edit_voice_type" name="voice_type" value="" readonly />
                                        <div class="form-row">
                                            <!-- <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p> -->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Course Name<span class="text-danger">*</span></label>
                                                <input type="text" id="edit_language" name="Course Name" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"/>
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
											<div class="form-group col-md-6">
                                                <label>Course Details<span class="text-danger">*</span></label>
                                                <textarea id="edit_details" name="Course Details" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"></textarea>
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="level" id="edit_level" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"/ />
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
										<div class="form-group col-md-6">
                                                <label>Topic<span class="text-danger">*</span></label> 
                                                <input type="text" id="edit_topic" name="topic_name" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"/ />
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>	
                                        </div>
                                        

<div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Template<span
                                                        class="text-danger">*</span></label><br/>
                                                <button type="button"
                                                    class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload Again
                                                    <input name="file" type="file" class="fileUploadAgain" required />
                                                </button><span id="lblFileName" class="lblFileName">No file
                                                    selected</span>
                                                
                                                <h6>Note : Only Excel file format allowed. <a href="<?php echo base_url();?>assets/templates/supplementary_excel.xlsx">Sample Template</a> file found here.</h6>
                                            </div>
                                        </div>
										


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Edit supplementary
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
	
	<!-- Delete confirmation dialog -->
            <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">Deleting will remove this Supplementary Content from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url() ?>admin_course_content/supplementary" method="post">
                                        <input type="hidden" name="supplementary_delete_process" value="1" id="supplementary_delete_process">
                                        <input type="hidden" name="supplementary_delete_id" id="supplementary_delete_id">
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
                                    <form action="<?php echo base_url(); ?>admin_course_content/supplementary" method="post">
                                     <input type="hidden" id="status_supplementary_id" name="status_supplementary_id">   
                                     <input type="hidden" id="status_supplementary_status" name="status_supplementary_status">   
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

            <div id="warning-all-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Deleting will remove those selected supplementary from the system. Are you
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
    /*******Start-debasis******/
    .content-right{
        justify-content: flex-end;
    }
    .topselectdropdown{
        width: 200px !important;
    }
    .topicdropdown {
        width: 100px !important;
    }
    
    /*******End-debasis******/

    </style>
	
<?php
            include('footer.php')
        ?>
<!-- Table Editable plugin-->
    <script src="<?php echo base_url();?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->

    <script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>




<script>
   ! function(t) {
        "use strict";

        function o() {}
        o.prototype.init = function() {
            t("#inline-editable").Tabledit({
                inputClass: "form-control form-control-sm custom-form-control",
                editButton: !1,
                deleteButton: !1,
                columns: {
                    identifier: [2, "supplementary ID"],
                    editable: [
                        [1, "col1"]
                    ]
                }
            })
        }, t.EditableTable = new o, t.EditableTable.Constructor = o
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.EditableTable.init()
    }();

    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus,#drpLevel').prop('selectedIndex', 0);
			
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

        jQuery('#btnGo').click(function() {
            if (jQuery('#drpMultipleCta').val() == 1) {
                jQuery('#btnImportsupplementary').click();
            }
        });
		
		jQuery('.fileUploadAgain').change(function() {
            jQuery('.lblFileName').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });

    });
function filter_data()
{
	$("#demo-form").submit();
}	
function do_function(value)
{
	if(value == 1)
		$("#custom-modal").modal('toggle');
	else if(value == 2)
	{

        $('#checkboxdata input:checked').each(function() {

            $('#warning-all-delete-modal').modal('show');

            $("#yes_delete_all").click(function(){
              
              $("#deletesupplementaryfrom").submit();
            });
                
            }); 


		
	}
	
}
function setformat(value)
{
	$("#setlevel select").removeAttr("required");
	if(value !='Single')
	{
		$("#choose_level").attr("required", true);
		$("#setlevel").css('display','block');
	}else
	{
		$("#setlevel").css('display','none');
	}
}
function supplementary_delete(id)
{
	$("#supplementary_delete_id").val(id);
}
function edit_supplementarydata(supplementary_id,course_name,level,topic,voice_type,course_details)
{
	//alert(supplementary_id);
	//alert(topic_id);
	$("#edit_language").val(course_name);
	$("#edit_details").val(course_details);
	$("#edit_level").val(level);
	$("#edit_topic").val(topic);
	$("#edit_voice_type").val(voice_type);
	$("#supplementary_id").val(supplementary_id);
}

    $("#topic_id").change(function(){
	
      $("#topic_name").val($("#topic_id").find(":selected").text());
    });
function change_status(supplementary_id,supplementary_status)
{
   
    if(supplementary_status==0)
    {
         $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
    }
    else
    {
       $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
    }
	$("#status_supplementary_id").val(supplementary_id);
	$("#status_supplementary_status").val(supplementary_status);
}

function gettopicsbylevel(val)
{
	$.post( "<?php echo base_url();?>admin_course_content/ajax_sectiontopics", { level: val })
  .done(function( data ) {
   const myArr = JSON.parse(data);
   var options = "";
   $('#topic_name').empty();
   $("#topic_name").append($("<option></option>")
                    .attr("value","")
                    .text("Select"));
   for(var i = 0;i<myArr.length;i++)
   {
	   $("#topic_name").append($("<option></option>")
                    .attr("value", myArr[i]['id'])
                    .text(myArr[i]['title']));
   }

  });
}
</script>



</body>
</html>
    	