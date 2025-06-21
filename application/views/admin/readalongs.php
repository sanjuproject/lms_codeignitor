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
                                    <li class="breadcrumb-item">ReadAlongs</li>
                                    <li class="breadcrumb-item active">List of ReadAlongs</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">List of ReadAlongs</h4>
                        </div>

                        <div class="col-md-6">



                            <div class="footerformView float-right mb-2">
                                     <!-- start-debasis -->
                                <form>
                                <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="dofunctions(this.value);">
                                        <option value="" select>Please Select</option>
                                        <option value="1">Add ReadAlong</option>
                                        <option value="2">Remove selected ReadAlongs</option>
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
                                                data-toggle="modal" data-target="#modal-add-readalong"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add ReadAlong</a>
                                        </div>
                                        <!-- start-debasis -->
                                        <div class="col-sm-9">
                                    
                                                <form action="<?php echo base_url(); ?>admin_course_content/readalongs" id="search-demo-form" method="post">
                                                    <input type="hidden" name="search_filter" value="search_filter">
                                                    <div class="row content-right">
                                                            <div class="form-group mb-3">
                                                                    <input type="text" name="title" class="form-control"
                                                                        id="txtFilter" placeholder="Title" value="<?php if(!empty($search_parent_data['ss_aw_title'])) echo $search_parent_data['ss_aw_title'];?>"
                                                                        aria-label="Title" />
                                                            </div>
                                                       
                                                            <div class="form-group mb-3 ml-2 ">
                                                                <!-- <input type="text" class="form-control"
                                                                    data-toggle="flatpicker"
                                                                    placeholder="Publish date range" name="publish_date" value="<?php if(!empty($search_parent_data['ss_aw_created_date'])) echo $search_parent_data['ss_aw_created_date'];?>"
																	id="publish_date" onchange="publishdate_filter(this.value);" /> -->
                                                                     <input type="text" id="range-datepicker" class="form-control" name="publish_date" onchange="publishdate_filter(this.value);" value="<?php if(!empty($search_parent_data['ss_aw_created_date'])) echo $search_parent_data['ss_aw_created_date'];?>" placeholder="2018-10-03 to 2018-10-10">
                                                            </div>
                                                
                                                     
                                                    
                                                                    <div class="form-group mb-3 ml-2 mr-2">
                                                                        <div class="input-group">
                                                                            <select
                                                                                class="form-control topicdropdown" name="topic"
                                                                                id="drpTopic" onchange="filter_data();">
                                                                                <option value="" select>Topic</option>
																			<?php
																			foreach($topicslist as $value){
																			?>																			
                                                                                <option <?php if(!empty($search_parent_data['ss_aw_topic']) && $search_parent_data['ss_aw_topic'] == $value){?>selected <?php } ?> value="<?php echo $value;?>">
																				<?php echo $value;?></option>
																			<?php } ?>	
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                           
                                                       
                                                
                                                                    <div class="form-group mb-3">
                                                                        <div class="input-group">
                                                                            <select
                                                                                class="form-control topicdropdown"
                                                                                id="drpStatus" name="status" onchange="filter_data();">
                                                                                <option value=""<?php if(empty($search_parent_data['ss_aw_status']) ){?>selected <?php } ?>>Status</option>
                                                                                <option value="1"
                                                                                <?php if(!empty($search_parent_data['ss_aw_status']) && $search_parent_data['ss_aw_status'] == 1){?>selected <?php } ?>>Active</option>
                                                                                <option <?php if(!empty($search_parent_data['ss_aw_status']) && $search_parent_data['ss_aw_status'] == 2){?>selected <?php } ?> value="2">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                        
                                                        <div class="ml-2 mr-2">

                                                            <button type="submit"
                                                                class="btn btn-primary waves-effect waves-light">Search</button>
                                                            <button type="button" id="btnClearFilter"
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
                                                    <th>Type</th>
                                                    <th>Level</th>
                                                    <th>Topic</th>
                                                    <th>Title</th>
                                                    <th>File(Zip)</th>
                                                    <th>Publish Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
											<form action="<?php echo base_url();?>admin_course_content/multipledeletereadalong" id="deletereadalongform" method="post">
                                            <?php
											if($result){
												foreach($result as $key=>$value){
													$readalong_id = $value['ss_aw_id'];
											?>											
												<tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $readalong_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>

                                                    <td><?php echo $value['ss_aw_type'];?></td>
                                                    <td><?php echo $value['ss_aw_level'];?></td>
                                                    <td><?php echo $value['ss_aw_topic'];?></td>
                                                    <td><a href="<?= base_url(); ?>admin_course_content/readalong_details/<?= $readalong_id; ?>"><?php echo $value['ss_aw_title'];?></a></td>
                                                    <td>
                                                        <a href="<?php echo base_url().$value['ss_aw_upload_file'];?>" download>
                                                            <?php
                                                            $file_name =  $value['ss_aw_upload_file'];
                                                            $file_name=substr($file_name, strrpos($file_name, '/' )+1);
                                                            ?>
                                                            <div class="avatar-sm">
                                                                <span
                                                                    class="avatar-title bg-light text-secondary rounded">
                                                                    <i class="mdi mdi-folder-zip font-18"
                                                                        title="<?php echo $file_name; ?>" data-plugin="tippy"
                                                                        data-tippy-animation="shift-away"
                                                                        data-tippy-arrow="true"></i>
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td><?php echo date('M d, Y',strtotime($value['ss_aw_created_date']));?></td>
                                                    <td>
                                                        <?php
                                                        if($value['ss_aw_status']==1)
                                                        {
                                                            ?>
                                                        <a href="#" class="badge badge-soft-success"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $value['ss_aw_id'];?>',0);">Active</a>
                                                            <?php
                                                             }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="#" class="badge badge-soft-danger"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $value['ss_aw_id'];?>',1);">
                                                           In Active</a>
                                                            <?php
                                                        } 
                                                        ?>

                                                        <?php
                                                        if ($value['ss_aw_is_demo'] == 1) {
                                                            ?>
                                                            <a href="javascript:void(0)" onclick="set_demo(<?= $value['ss_aw_id']; ?>, <?= $value['ss_aw_is_demo']; ?>)" class="badge badge-soft-warning" data-toggle="modal" data-target="#warning-demo-modal">Demo for <?=Winners?></a>
                                                            <?php    
                                                        }
                                                        elseif ($value['ss_aw_is_demo'] == 2) {
                                                            ?>
                                                            <a href="javascript:void(0)" onclick="set_demo(<?= $value['ss_aw_id']; ?>, <?= $value['ss_aw_is_demo']; ?>)" class="badge badge-soft-warning" data-toggle="modal" data-target="#warning-demo-modal">Demo for <?=Master?>s</a>
                                                            <?php
                                                        }
                                                        elseif ($value['ss_aw_is_demo'] == 3) {
                                                            ?>
                                                            <a href="javascript:void(0)" onclick="set_demo(<?= $value['ss_aw_id']; ?>, <?= $value['ss_aw_is_demo']; ?>)" class="badge badge-soft-warning" data-toggle="modal" data-target="#warning-demo-modal">Demo for Both</a>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <a href="javascript:void(0)" onclick="set_demo(<?= $value['ss_aw_id']; ?>, <?= $value['ss_aw_is_demo']; ?>)" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-demo-modal">Mark for Demo</a>
                                                            <?php
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <button onclick="upload_quiz(<?= $value['ss_aw_id'];?>, <?= $value['ss_aw_audio_type']; ?>);" class="btn btn-warning waves-effect btn-xs waves-light" type="button" data-toggle="modal" data-target="#quiz-upload">Upload Quiz</button>
                                                        <button type="button" data-toggle="modal"
                                                            data-target="#modal-edit-readalong" onclick="edit_readalongdata('<?php echo $value['ss_aw_id'];?>','<?php echo $value['ss_aw_type'];?>',
														'<?php echo $value['ss_aw_level'];?>','<?php echo $value['ss_aw_topic'];?>','<?php echo $value['ss_aw_title'];?>','<?php echo $value['ss_aw_audio_type'];?>');"
                                                            class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                            Upload Again
                                                        </button>
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-toggle="modal" onclick="return readlong_delete('<?php echo $value['ss_aw_id']; ?>');" data-target="#warning-delete-modal"
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

                    <!-- Modal -->
                    <div class="modal fade" id="quiz-upload" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Upload Quiz</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="post" action="<?php echo base_url(); ?>admin_course_content/upload_readalong_quiz" id="demo-form" class="parsley-examples" id="modal-demo-form" enctype="multipart/form-data">
                                        <input type="hidden" name="readalong_upload_id" id="readalong_upload_id">
                                        <input type="hidden" name="readalong_audio_type" id="upload_readalong_audio_type">
                                        <!-- <input type="hidden" name="readalong_audio_type" value="<?= $upload_details[0]->ss_aw_audio_type; ?>"> -->
                                        <input type="hidden" name="page_no" value="<?= $page; ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Quiz<span
                                                        class="text-danger">*</span></label><br />
                                                        <input name="file" type="file" data-plugins="dropify" data-height="100" required/>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <!-- <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                        
                                            </div>
                                            
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Upload
                                            </button>
                                            <button type="reset" class="btn btn-danger waves-effect m-l-5"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>
        
            
                                      

                                    
 
                                        

                                    </div> <!-- end card-body-->

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->

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
										<form action="<?php echo base_url();?>admin_course_content/readalongs" method="post">
										<input type="hidden" id="status_readalong_id" name="status_readalong_id">   
                                             <input type="hidden" id="status_readalong_status" name="status_readalong_status">   
                                             <input type="hidden" name="readalong_status_change" value="readalong_status_change"> 
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
                                        <p class="mt-3">Deleting will remove this ReadAlong from the system. Are you
                                            sure ?
                                        </p>
										<form action="<?php echo base_url() ?>admin_course_content/readalongs" method="post">
                                            <input type="hidden" name="readalong_delete_process" value="1" id="readalong_delete_process">
                                             <input type="hidden" name="readalong_delete_id" id="readalong_delete_id">
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
                    <div class="modal fade" id="modal-add-readalong" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">New ReadAlong Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/upload_readalongs" enctype="multipart/form-data" method="post" id="demo-form" class="parsley-examples" id="modal-demo-form">
                                        <input type="hidden" id="status_readalong_id" name="status_readalong_id">   
                                             <input type="hidden" id="status_readalong_status" name="status_readalong_status">   
                                             <input type="hidden" name="readalong_status_change" value="readalong_status_change"> 
										<div class="form-row">
                                           <!--  <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p> -->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Type<span class="text-danger">*</span></label>
                                                <select id="" name="type" class="form-control parsley-error" required="">
                                                    
                                                    <option value="Linear">Linear</option>
                                                    

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <select id="" class="form-control parsley-error" name="level" onchange="gettopicsbylevel(this.value);" required="">
                                                    <option value="">Select</option>
                                                    <option value="E">Level E</option>
                                                    <option value="C">Level C</option>
                                                    <option value="A">Level A</option>

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Topic<span class="text-danger">*</span></label>
                                                <select id="topic_name" name="topic_name" class="form-control parsley-error" required="">
                                                    <option value="">Select</option>
                                                    

                                                </select>
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="title">ReadAlong Title<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control parsley-error" name="title" type="text" id="title"
                                                    placeholder="ReadAlong Title" required>

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
                                                    Upload
                                                    <input type="file" name="file" id="fileUploadAgain">
                                                </button><span id="lblFileName" class="lblFileName">No file
                                                    selected</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                    <!-- <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                <h6>Note : Only Excel file file format allowed. Sample Directory
                                                    structure and also
                                                    <a href="<?php echo base_url();?>assets/templates/readalong_templates.zip">Template</a> file found here.
                                                </h6>
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Add ReadAlong
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
					
					<div class="modal fade" id="modal-edit-readalong" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Edit ReadAlong Upload</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="<?php echo base_url();?>admin_course_content/edit_upload_readalongs" enctype="multipart/form-data" method="post" id="demo-form" class="parsley-examples" id="modal-demo-form">
                                        <input type="hidden" id="readalong_id" name="rec_id">   
                                        <input type="hidden" readonly id="readalong_audio_type" class="form-control" name="audio_type">     
                                        <input type="hidden" readonly id="readalong_page_no" class="form-control" name="page_no">     
										<div class="form-row">
                                           <!--  <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p> -->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Type<span class="text-danger">*</span></label>
                                                <input type="text" readonly id="readalong_type" class="form-control" name="type"> 
                                               
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" readonly id="readalong_level" class="form-control" name="level"> 
												
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Topic<span class="text-danger">*</span></label>
                                                <input type="text" readonly id="readalong_topic" class="form-control" name="topic_name">
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="title">ReadAlong Title<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="readalong_title" class="form-control" name="title">

                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div>
											
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="select-code-language">Upload Template<span
                                                        class="text-danger">*</span></label><br />
                                                <button type="button"
                                                    class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload
                                                    <input type="file" name="file" id="fileUploadAgain_2">
                                                </button><span id="lblFileName_2" class="lblFileName">No file
                                                    selected</span>
                                                <ul class="parsley-errors-list filled" aria-hidden="false">
                                                   <!--  <li>This error would appear on validation error of template upload
                                                    </li> -->
                                                </ul>
                                                <h6>Note : Only Excel file file format allowed. Sample Directory
                                                    structure and also
                                                    <a href="<?php echo base_url();?>assets/templates/readalong_templates.zip">Template</a> file found here.
                                                </h6>
                                            </div>
                                        </div>


                                        <div>
                                            <button type="submit"
                                                class="btn btn-blue waves-effect waves-light custom-color">
                                                Update ReadAlong
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


				<div id="warning-all-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Deleting will remove those selected readalongs from the system. Are you
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


            <div id="warning-demo-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Demo Availability for Users</h4>
                                <form action="<?php echo base_url(); ?>admin_course_content/readalongs" method="post" class="parsley-examples">   
                                <div style="display: flex; justify-content: space-around; padding-bottom: 10px;"> 
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="winners_demo" name="is_demo[]" value="1"><?=Winners?>
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="masters_demo" name="is_demo[]" value="2"><?=Master?>s
                                      </label>
                                    </div>
                                </div>    
                                    <div class="button-list">
                                        <input type="hidden" id="demo_readalong_id" name="demo_readalong_id">   
                                        <input type="hidden" id="demo_readalong_availability" name="demo_readalong_availability">   
                                        <input type="hidden" id="demo_pageno" name="demo_pageno">   
                                        <button type="submit" class="btn btn-danger" >Yes</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                    </div>
                                </form>
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
        width: 200px !important;
    }
    .topicdropdown {
        width: 100px !important;
    }
    #parsley-id-multiple-is_demo{
        white-space: nowrap; 
        position: absolute;
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
    <script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="<?php echo base_url();?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- Validation init js-->
    <script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>
    <!-- Init js-->
    <script src="<?php echo base_url();?>assets/js/pages/create-project.init.js"></script>
    <script src="<?php echo base_url();?>assets/js/pages/form-pickers.init.js"></script>

    <script>
    jQuery(function() {

        // let $flatpickr = jQuery('#range-datepicker').flatpickr({
        //     mode: "range",
        //     dateFormat: "d M, Y",
        //     conjunction: " - "
        // });
        // let $flatpickr2 = jQuery('#range-datepicker2').flatpickr({
        //     mode: "range",
        //     dateFormat: "d M, Y",
        //     conjunction: " - "
        // });

        jQuery('#btnClearFilter').click(function() {
            //$flatpickr.clear();
            //$flatpickr2.clear();
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus,#drpTopic').prop('selectedIndex', 0);
            jQuery('#publish_date').val('');
			jQuery('#range-datepicker').val('');
			$("#search-demo-form").submit();
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
		jQuery('#fileUploadAgain_2').change(function() {
            jQuery('#lblFileName_2').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''))
        });

    });
function gettopicsbylevel(val)
{
	$.post( "<?php echo base_url();?>admin_course_content/ajax_readalongtopics", { level: val })
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
                    .attr("value", myArr[i])
                    .text(myArr[i]));
   }

  });
}
function filter_data()
        {
            
            //$("#search-demo-form").submit();
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
            $("#status_readalong_id").val(topic_id);
            $("#status_readalong_status").val(topic_status);
        }

        function readlong_delete(id)
        {
            $("#readalong_delete_id").val(id);
        }
	
function edit_readalongdata(readalong_id,type,level,topic,title,audio_type)
{

	$("#readalong_type").val(type);
	$("#readalong_level").val(level);
	$("#readalong_topic").val(topic);
	$("#readalong_id").val(readalong_id);
	$("#readalong_title").val(title);
	$("#readalong_audio_type").val(audio_type);
    $("#readalong_page_no").val('<?= $page; ?>');
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
function dofunctions(value)
{
	if(value == 1)
	{
		$("#modal-add-readalong").modal('toggle');
	}
	else if(value == 2)
	{
        $('#checkboxdata input:checked').each(function() {

            $('#warning-all-delete-modal').modal('show');

            $("#yes_delete_all").click(function(){
              
              $("#deletereadalongform").submit();
            });
                
            }); 
	
	}
	
}
function publishdate_filter(value)
{
   const myArr = value.split("to");
   if(myArr.length==2)
   {
    //$("#search-demo-form").submit();

   }    
}

function upload_quiz(readalong_id, audio_type){
    $("#readalong_upload_id").val(readalong_id);
    $("#upload_readalong_audio_type").val(audio_type);
}

function set_demo(readalong_id,demo_status){
    var pageno = "<?= $this->uri->segment(3) ? $this->uri->segment(3) : ''; ?>"
    $("#demo_readalong_id").val(readalong_id);
    $("#demo_readalong_availability").val(1);
    $("input[name='is_demo[]']").attr('checked', false);
    if (demo_status == 1) {
        $("#winners_demo").attr('checked', true);
    }
    else if (demo_status == 2) {
        $("#masters_demo").attr('checked', true);
    }
    else if (demo_status == 3) {
        $("#winners_demo").attr('checked', true);
        $("#masters_demo").attr('checked', true);
    }
    $("#demo_pageno").val(pageno);
}
    </script>

</body>

</html>