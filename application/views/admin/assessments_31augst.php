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
                                    <li class="breadcrumb-item">Assessments</li>
                                    <li class="breadcrumb-item active">List of Assessment</li>
                                </ol>
                            </div>
                        </div>
                    </div>
				<?php include("error_message.php");?>
                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Assessments</h4>
                        </div>

                        <div class="col-md-6">



                            <div class="footerformView float-right mb-2">
                                <!-- start-debasis -->
                                <form>
                                <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="do_function(this.value);">
                                        <option value="0" select>Please Select</option>
                                        <option value="1">Import New Assessment/Diagnostic Quiz</option>
                                        <option id="delete_option_id" value="2">Deleted selected options</option>
                                    </select>
                                     <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
</div>
                                </form>
                                <!-- end-debasis -->
                            </div>


                        </div>



                    </div>
                    <!-- end page title -->



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row mb-2">
                                        <div class="col-sm-4">

                                            <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#modal1-add-assessment"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Import New Assessment</a>
                                        </div>
                                        <!-- start-debasis -->
                                        <div class="col-sm-8">
                                            
                                                <form action="<?php echo base_url();?>admin_course_content/assessments" method="post" id="demo-form">
                                                    <input type="hidden" name="search_filter" value="filter" />
                                                    <div class="row content-right">
                                                    
                                                            <div class="form-group mb-3">
                                                          <input type="text" class="form-control"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Topic / Section name" name="topic_name" value="<?php if(!empty($search_parent_data['ss_aw_assesment_topic'])) echo $search_parent_data['ss_aw_assesment_topic'];?>">
                                                              
                                                            </div>
                                                      
                                                       
                                                            <div class="form-group mb-3 ml-2 mr-2">
                                                                <div class="input-group">
                                                                    <select
                                                                        class="form-control adminusersbottomdropdown"
                                                                        id="drpStatus" onchange="filter_data();" name="status">
                                                                        <option value="" select>Status</option>
                                                                        <option value="1"<?php if(!empty($search_parent_data['ss_aw_assesment_status']) && $search_parent_data['ss_aw_assesment_status'] == 1){?>selected <?php } ?>>Active</option>
                                                                        <option value="2"<?php if(!empty($search_parent_data['ss_aw_assesment_status']) && $search_parent_data['ss_aw_assesment_status'] == 2){?>selected <?php } ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                                    <div class="form-group mb-3">
                                                                        <select
                                                                            class="form-control adminusersbottomdropdown"
                                                                            id="drpformat" name="format" onchange="filter_data();">
																			<option value="">Format</option>
                                                                            <option value="Single" <?php if(!empty($search_parent_data['ss_aw_assesment_format']) && $search_parent_data['ss_aw_assesment_format'] == 'Single'){?>selected<?php } ?>>Single</option>
                                                                            <option value="Multiple" <?php if(!empty($search_parent_data['ss_aw_assesment_format']) && $search_parent_data['ss_aw_assesment_format'] == 'Multiple'){?>selected<?php } ?>>Multiple</option>

                                                                        </select>
                                                                    </div>
                                                            
                                                        <div class="ml-2 mr-2">
                                                            <button type="submit" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Clear</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            
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
                                                    <th># SL No.</th>
                                                    <th>Topic / Section Name</th>
                                                    <th>Format</th>
													<th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
										<form action="<?php echo base_url();?>admin_course_content/multipledeleteassessment" id="deleteassessmentfrom" method="post">
                                                <?php 
                                                    $sl=1 + $this->uri->segment(3);
                                                foreach ($result as $key=>$value) {
                                                     $assesment_status=$value->ss_aw_assesment_status ; 
                                                     $assessment_id=$value->ss_aw_assessment_id; 
                                            ?>

   
                                               
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $assessment_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $sl; ?></td>

                                                    <td><a class="link" href="<?php echo base_url();?>admin_course_content/assessmentsparticulartopic/<?php echo base64_encode($value->ss_aw_assessment_id);?>"><?php 
                                                    echo $value->ss_aw_assesment_topic;
                                                    ?></a></td>

													 <td><?php echo $value->ss_aw_assesment_format; ?></td>
                                                    <td>
                                                         <?php
                                                        if($assesment_status==1)
                                                        {
                                                            ?>
                                                        <a href="#"  class="badge badge-soft-success"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $assessment_id ?>','<?php echo $assesment_status ?>');">Active</a>
                                                                <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                             <a href="#"  class="badge badge-soft-danger"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $assessment_id ?>','<?php echo $assesment_status ?>');">In Active</a>
                                                              <?php
                                                        } 
                                                        ?>
                                                    </td>
                                                    <td>

                                                        <a href="javascript:void(0);" onclick="return assgn_delete('<?php echo $assessment_id; ?>');"  class="action-icon"
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
                                           <form action="<?php echo base_url(); ?>admin_course_content/assessments" method="post">

                                             <input type="hidden" id="status_assesment_id" name="status_assesment_id">   
                                             <input type="hidden" id="status_assesment_status" name="status_assesment_status">   
                                             <input type="hidden" name="assesment_status_change" value="parent_status_change">   
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
                                        <p class="mt-3">Deleting will remove this topic from the system. Are you
                                            sure ?
                                        </p>
                                        <div class="button-list">
                                            <form action="<?php echo base_url() ?>admin_course_content/assessments" method="post">
                                                <input type="hidden" name="assessment_delete_process" id="assessment_delete_process" value="assessment_delete_process">
                                        <input type="hidden" name="assessment_delete_id" id="assessment_delete_id">
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
                    <div class="modal fade" id="modal1-add-assessment" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">New Assessment/Diagnostic Quiz Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/upload_assessment" method="post" enctype="multipart/form-data" id="demo-form" class="parsley-examples" id="modal-demo-form">
                                        <div class="form-row">
                                            <!-- <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p> -->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Subject<span class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" name="language" required="">
                                                   
                                                    <option value="English">English</option>
                                                   

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
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Format<span class="text-danger">*</span></label>
                                                <select id="" name="format" class="form-control parsley-error" onchange="setformat(this.value);" required="">
                                                    <option value="">Select</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Multiple">Multiple</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
											
                                             <div class="form-group col-md-6" id="setlevel" style="display:none;">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control parsley-error" name="level" id="choose_level">
                                                    <option value="" selected>Select</option>
                                                    <option value="E">Level E</option>
                                                    <option value="C">Level C</option>
                                                    <option value="A">Level A</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
										
										<div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Lesson Title<span class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" name="selected_lesson" required="">
                                                    <option value="">Lesson Title goes here</option>
                                                <?php
													foreach($lessonslist as $key=>$value){
												?>	
													<option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                <?php 
													}
												?>													

                                                </select>
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
                                                        class="text-danger">*</span></label><br/>
                                                <button type="button"
                                                    class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload 
                                                    <input type="file" name="file" id="fileUploadAgain">
                                                </button><span id="lblFileName" class="lblFileName">No file selected</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                <h6>Note : Only Excel file format allowed. <a href="<?php echo base_url();?>assets/templates/assessment_templates.zip">Sample Template</a> file found here.</h6>
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Add Assessment
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
       /*******Start-debasis******/
       .content-right{
        justify-content: flex-end;
    }
    .topselectdropdown{
        width: 200px;
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
    <script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <!-- Validation init js-->
    <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>

    <script>
    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus').prop('selectedIndex', 0);
			jQuery('#drpformat').prop('selectedIndex', 0);
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
		
		jQuery('#fileUploadAgain').change(function(){
            jQuery('#lblFileName').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });

    });
$("#topic_id").change(function(){
	
      $("#topic_name").val($("#topic_id").find(":selected").text());
    });	
	
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

        function filter_data()
{
    $("#demo-form").submit();
}   

function change_status(assessment_id,assesment_status){
          if(assesment_status==1)
          {
            assesment_status = 2;
            $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
          }
          else
          {
            assesment_status = 1;
            $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
          }
          document.getElementById('status_assesment_status').value = assesment_status;
          document.getElementById('status_assesment_id').value = assessment_id;

     }
  function assgn_delete(assessment_id)  
  {
   document.getElementById('assessment_delete_id').value = assessment_id;    

  } 
  
 function do_function(value)
{
	if(value == 1)
		$("#modal1-add-assessment").modal('toggle');
	else if(value == 2)
	{

         $('#checkboxdata input:checked').each(function() {

            $('#warning-all-delete-modal').modal('show');

            $("#yes_delete_all").click(function(){
              
             $("#deleteassessmentfrom").submit();
            });
                
            }); 

		
	}
	
} 
    </script>


</body>

</html>	