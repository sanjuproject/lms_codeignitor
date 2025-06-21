
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
                                    <li class="breadcrumb-item">Lessons</li>
                                    <li class="breadcrumb-item active">List of Lessons</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
					<?php include("error_message.php");?>
					<div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Lessons</h4>
                        </div>

                        <div class="col-md-6">
                            <div class="footerformView float-right mb-2">
                                <!-- start-debasis -->
                                <form>
                                    <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="do_function(this.value);">
                                        <option value="" select>Please Select</option>
                                        <option value="1">Import New Lesson</option>
                                        <option id="delete_option_id" value="2">Deleted selected options</option>
                                    </select>
                                   <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                   
                                </form>
                                 <!-- end-debasis -->
                            </div>
                        </div>
                    </div>

                
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

									<div class="row mb-2">
                                        <div class="col-sm-4">

                                            <a href="javascript:void(0);" id="btnImportLesson"
                                                class="btn btn-danger mb-2" data-toggle="modal"
                                                data-target="#custom-modal"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Import new Lesson</a>
                                        </div>
                                        <!-- start-debasis -->
                                        <div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url();?>admin_course_content/lessons" method="post" id="demo-form">
												<input type="hidden" name="search_filter" value="filter" />
                                                    <div class="row content-right">
                                                            <div class="form-group mb-3">
                                                                <div>
                                                                    <input type="text" name="topic_name" class="form-control"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Recipient's username" value="<?php if(!empty($search_parent_data['ss_aw_lesson_topic'])) echo $search_parent_data['ss_aw_lesson_topic'];?>" />
                                                                    <div class="input-group-append">
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                      
                                                     
                                                            <div class="form-group mb-3 ml-2 mr-2">
                                                                    <div class="input-group">
                                                                        <select
                                                                            class="form-control adminusersbottomdropdown"
                                                                            id="drpLevel" name="choose_level" onchange="filter_data();">
																			<option value="" selected>Choose Level</option>
                                                                            <option value="1" <?php if(!empty($search_parent_data['ss_aw_course_id']) && $search_parent_data['ss_aw_course_id'] == 1){?>selected <?php } ?>>Level E</option>
                                                                            <option value="2" <?php if(!empty($search_parent_data['ss_aw_course_id']) && $search_parent_data['ss_aw_course_id'] == 2){?>selected <?php } ?>>Level C</option>
                                                                            <option value="3" <?php if(!empty($search_parent_data['ss_aw_course_id']) && $search_parent_data['ss_aw_course_id'] == 3){?>selected <?php } ?>>Level A</option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                            <div class="form-group">
                                                            <div class="input-group">
                                                                        <select
                                                                            class="form-control adminusersbottomdropdown"
                                                                            id="drpStatus" name="status" onchange="filter_data();">
                                                                            <option value="" select>Status</option>
                                                                            <option value="1" <?php if(!empty($search_parent_data['ss_aw_lesson_status']) && $search_parent_data['ss_aw_lesson_status'] == 1){?>selected <?php } ?>>Active</option>
                                                                            <option value="0" <?php if(!empty($search_parent_data['ss_aw_lesson_status']) && $search_parent_data['ss_aw_lesson_status'] == "0"){?>selected <?php } ?>>Inactive</option>
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
                                                    
                                                    <th>SL.No</th>
                                                    <th>Format</th>
                                                    <th>Topic/Section Name</th>
                                                    <th>Level<br/>( E = 1,C = 2, A = 3)</th>
                                                    <th>Created Date</th>
                                                    <th>Modified Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
									<form action="<?php echo base_url();?>admin_course_content/multipledeletelesson" id="deletelessonfrom" method="post">		
										<?php
										
										foreach($result as $key=>$value){
											
											$language = $value->ss_aw_language;
											$topic = $value->ss_aw_lesson_topic;
											$topic_id = $value->ss_aw_lesson_topic_id;
											$format = $value->ss_aw_lesson_format;
											$course = rtrim($value->ss_aw_course_id,",");
											$courseary = explode(",",$course);
											$lesson_id = $value->ss_aw_lession_id;
											$audio_type = $value->ss_aw_audio_type;
										?>										
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $lesson_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="tableeditCell" id="record_id_<?php echo $lesson_id;?>" value="<?php echo $lesson_id;?>" onblur="update_seq_no(<?php echo $lesson_id;?>);"><?php echo $value->ss_aw_sl_no;?></td>
                                                    
                                                    
													<td><?php echo $value->ss_aw_lesson_format;?></td>
													<td><?php echo $value->ss_aw_lesson_topic;?></td>
													<td>
													<?php 
													$course_string = "";
													foreach($courseary as $val){
															if($val == 1)
																$course_string .= "E ".",";
															if($val == 2)
																$course_string .= "C ".",";
															if($val == 3)
																$course_string .= "A ";
													}
													echo rtrim($course_string,",");
													?>
													</td>
                                                    <td><?php echo date('M d, Y', strtotime($value->ss_aw_create_date)); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($value->ss_aw_modified_date)); ?></td>
                                                   
												  
                                                    <?php
                                                     $lesson_status=$value->ss_aw_lesson_status; 
													  
                                                    ?>
                                                    <td>
                                                        <?php
                                                        if($lesson_status==1)
                                                        {
                                                            ?>

                                                        <a href="#" onclick="return change_status('<?php echo $lesson_id ?>',0);" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#warning-status-modal">Active</a></td>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="#" onclick="return change_status('<?php echo $lesson_id ?>',1);" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#warning-status-modal">In Active</a>
                                                            <?php
                                                        } 
                                                        ?>

                                                    <td>
                                                        <button type="button" onclick="edit_lessondata('<?php echo $lesson_id ?>','<?php echo $language;?>',
														'<?php echo $topic;?>','<?php echo $format;?>','<?php echo $course;?>','<?php echo $topic_id;?>','<?php echo $audio_type;?>');" data-toggle="modal" data-target="#custom-modal_edit"
                                                            class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                            Upload Again
                                                        </button>
                                                        <a href="javascript:void(0);" onclick="return lesson_delete('<?php echo $lesson_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"   title="Delete" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-delete"></i></a>

                                                               
                                                       
                                                    </td>

                                                </tr>
                                        <?php } ?>        
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
                    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">New Lesson Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/upload_lesson" method="post" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data" >
                                        <div class="form-row">
                                            <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Subject<span class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" required="" name="language">
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
                                                    <option value="" >Select</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Multiple">Multiple</option>

                                                </select>
												
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-6" id="setlevel" style="display:none;">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <select id="choose_level" name="level" class="form-control parsley-error" required="">
												    <option value="" selected>Choose Level</option>
                                                    <option value="1">Level E</option>
                                                    <option value="2">Level C</option>
                                                    <option value="3">Level A</option>
                                                    
                                                </select>
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
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

<div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Template<span
                                                        class="text-danger">*</span></label><br/>
                                                <button type="button"
                                                    class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload 
                                                    <input name="file" type="file" id="fileUploadAgain">
                                                </button><span id="lblFileName" class="lblFileName">No file selected</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                
                                                <h6>Note : Only Excel file format allowed. <a href="<?php echo base_url();?>assets/templates/lesson_templates.zip">Sample Template</a> file found here.</h6>
                                            </div>
                                        </div>
										


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Add Lesson
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
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit Lesson Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/edit_upload_lesson" method="post" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data" >
									<input type="hidden" name="pageno" value="<?php echo $this->uri->segment(3);?>" readonly />
									<input type="hidden" id="lesson_id" name="lesson_id" value="" readonly />
									<input type="hidden" id="edit_topic_id" name="topic_id" value="" readonly />
									<input type="hidden" id="edit_level_id" name="level" value="" readonly />
									<input type="hidden" id="edit_voice_type" name="voice_type" value="" readonly />
                                        <div class="form-row">
                                            <!-- <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p> -->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label>Subject<span class="text-danger">*</span></label>
                                                <input type="text" id="edit_language" name="language" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"/>
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="select-code-language">Topic<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="edit_topic" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"/ />
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label>Format<span class="text-danger">*</span></label> 
                                                <input type="text" id="edit_format" name="format" value="" readonly style="background: #ede6e6;
border: none;
color: #5d5151;
opacity: .7;"/ />
												<ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-5" id="setlevel" >
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="edit_level" value="" readonly style="background: #ede6e6;
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
                                                    <input name="file" type="file" id="fileUploadAgain1">
                                                </button><span id="lblFileName1" class="lblFileName">No file selected</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                
                                                <h6>Note : Only Excel file format allowed. <a href="<?php echo base_url();?>assets/templates/lesson_templates.zip">Sample Template</a> file found here.</h6>
                                            </div>
                                        </div>
										


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Edit Lesson
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
                                <p class="mt-3">Deleting will remove this lesson from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url() ?>admin_course_content/lessons" method="post">
                                        <input type="hidden" name="lesson_delete_process" value="1" id="lesson_delete_process">
                                        <input type="hidden" name="lesson_delete_id" id="lesson_delete_id">
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
                                    <form action="<?php echo base_url(); ?>admin_course_content/lessons" method="post">
                                     <input type="hidden" id="status_lesson_id" name="status_lesson_id">   
                                     <input type="hidden" id="status_lesson_status" name="status_lesson_status">   
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
                                        <p class="mt-3">Deleting will remove those selected lesson from the system. Are you
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
                    identifier: [2, "Lesson ID"],
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
                jQuery('#btnImportLesson').click();
            }
        });
		
		jQuery('#fileUploadAgain').change(function(){
            jQuery('#lblFileName').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });
         jQuery('#fileUploadAgain1').change(function(){
            jQuery('#lblFileName1').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
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
              
              $("#deletelessonfrom").submit();
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
function lesson_delete(id)
{
	$("#lesson_delete_id").val(id);
}
function edit_lessondata(lesson_id,language,topic,format,course,topic_id,voice_type)
{
	//alert(lesson_id);
	//alert(topic_id);
	$("#edit_language").val(language);
	$("#edit_topic").val(topic);
	$("#edit_format").val(format);
	$("#lesson_id").val(lesson_id);
	$("#edit_topic_id").val(topic_id);
	$("#edit_level_id").val(course);
	$("#edit_voice_type").val(voice_type);
	if(course == 1)
	{
		var course_name = 'E';
	}
	else if(course == 2)
	{
		var course_name = 'C';
	}
	else if(course == 3)
	{
		var course_name = 'A';
	}
	$("#edit_level").val(course_name);
}

    $("#topic_id").change(function(){
	
      $("#topic_name").val($("#topic_id").find(":selected").text());
    });
function change_status(lesson_id,lesson_status)
{
   
    if(lesson_status==0)
    {
         $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
    }
    else
    {
       $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
    }
	$("#status_lesson_id").val(lesson_id);
	$("#status_lesson_status").val(lesson_status);
}
function update_seq_no(record_id)
{
	$(this).blur(); 
}

 jQuery('.tableeditCell').on('keypress',function(e){
    if (e.which == 13) {
        let newValue = jQuery(this).find('.tabledit-input').val();
		var record_id = $(this).attr( "value" );
		$.post("<?php echo base_url();?>/admin_course_content/updatelesson_seqno", { serial_no: newValue,id: record_id })
  .done(function( data ) {
	  if(data == 1){
	  location.reload(true);
	  }
  });
    }
 });



</script>



</body>
</html>
    	