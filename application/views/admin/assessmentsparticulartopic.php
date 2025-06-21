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
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin_course_content/assessments">List of Assessment</a></li>
                                    <li class="breadcrumb-item active">Assessments for a particular topic and level</li>
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
                                <form>
                                    <div class="row content-right">
                                    <select class="form-control adminusersbottomdropdown" id="drpMultipleCta" onchange="do_function(this.value);">
                                        <option value="0" select>Please Select</option>
                                        
                                        <option value="2">Delete all</option>
                                    </select>
                                    <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                </div>

                                </form>
                            </div>


                        </div>



                    </div>
                    <!-- end page title -->



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row mb-2">

                                        <div class="col-sm-12">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url();?>admin_course_content/assessmentsparticulartopic/<?php echo $record_id;?>" method="post" id="demo-form">
                                                    <div class="row content-right">
                                                        
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                                    <input type="text" name="category" class="form-control"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Recipient's username" value="<?php if(!empty($search_parent_data['ss_aw_category'])) echo $search_parent_data['ss_aw_category'];?>" />

                                                                </div>
                                                            </div>
                                                        
                                                        
                                                            <div class="form-group mb-3 ml-2">
                                                                <div class="input-group">
                                                                    <input type="text" name="sub_category" class="form-control"
                                                                        id="txtFilter2"
                                                                        placeholder="Sub Topic / sub Section name"
                                                                        aria-label="Recipient's username" value="<?php if(!empty($search_parent_data['ss_aw_sub_category'])) echo $search_parent_data['ss_aw_sub_category'];?>" />

                                                                </div>
                                                            </div>
                                                        
                                                        <div class="form-group mb-3 ml-2">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary waves-effect waves-light"
                                                                    type="submit">Go</button>
                                                            </div>
                                                        </div>
                                                        
                                                       
                                                            <div class="form-group mb-3 ml-2 mr-2">
                                                               
                                                                
        <button type="button" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Clear</button>

                                                            </div>

                                                       
                                                    
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
                                                    <th>Format</th>
                                                    
                                                   
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
											<form action="<?php echo base_url();?>admin_course_content/multipledeleteassessment" id="deleteassessmentfrom" method="post">
                                                <input type="hidden" name="ss_aw_uploaded_record_id" value="<?php echo base64_decode($record_id);?>">   
												<?php 
                                                    $sl=1;
                                                foreach ($result as $key=>$value) {
                                                     

                                            ?>

   
                                               
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $value['ss_aw_sub_category'];?>" class="custom-control-input"
                                                                id="customCheck<?php echo $key + 2;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>
                                                    

                                                    <td><?php echo $value['ss_aw_category'];?></td>
													<td><?php echo $value['ss_aw_sub_category'];?></td>
													<td><?php echo $value['ss_aw_format'];?></td>
                                                    <td>
													<?php
													if(!empty($value['ss_aw_sub_category'])){
													?>
														<a href="<?php echo base_url();?>admin_course_content/assessmentsparticulartopicquestions/<?php echo base64_encode($value['ss_aw_sub_category']);?>
														/<?php echo base64_encode($value['ss_aw_uploaded_record_id']);?>" class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                            View
                                                        </a>
													<?php }else{ ?>
													<a href="<?php echo base_url();?>admin_course_content/assessmentsparticulartopicquestions/<?php echo base64_encode($value['ss_aw_category']);?>
														/<?php echo base64_encode($value['ss_aw_uploaded_record_id']);?>" class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                            View
                                                        </a>
													<?php } ?>	
                                                        <!-- <a href="javascript:void(0);" onclick="return delete_record('<?php echo $value['ss_aw_sub_category']; ?>','<?php echo $value['ss_aw_uploaded_record_id'];?>');"  class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete"> <i class="mdi mdi-delete"></i></a> -->
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
                   



                    <!--Status update confirmation dialog -->
                    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Are you sure you want to update the status?</p>
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
                                            <form action="<?php echo base_url();?>admin_course_content/assessmentsparticulartopic/<?php echo $record_id;?>" method="post">
                                                <input type="hidden" name="assessment_delete_process" id="assessment_delete_process" value="assessment_delete_process">
                                        
										<input type="hidden" name="sub_topic" id="sub_topic">
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
    .content-right{
        justify-content: flex-end;
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
    <!-- Validation init js-->
    <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>

    <script>
    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
			jQuery('#txtFilter2').val('');
            jQuery('#drpLevel').prop('selectedIndex', 0);
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
function delete_record(subtopic,record_id)
{
	$("#sub_topic").val(subtopic);
}

 function do_function(value)
{
	if(value == 2)
	{
		$('#checkboxdata input:checked').each(function() {
			$("#deleteassessmentfrom").submit();
		});
	}
	
}
    </script>

</body>

</html>	