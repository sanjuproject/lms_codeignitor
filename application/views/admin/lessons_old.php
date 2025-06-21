<link href="<?php echo base_url();?>assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
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
                                        <div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="#" id="demo-form">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Recipient's username">
                                                                    <div class="input-group-append">
                                                                        <button
                                                                            class="btn btn-primary waves-effect waves-light"
                                                                            type="button">Go</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group mb-3 row">
                                                                <div class="col-sm-6">
                                                                    <div class="input-group">
                                                                        <select
                                                                            class="form-control adminusersbottomdropdown"
                                                                            id="drpLevel">
                                                                            <option value="0" select>Level E</option>
                                                                            <option value="1">Level C</option>
                                                                            <option value="2">Level A</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="input-group">
                                                                        <select
                                                                            class="form-control adminusersbottomdropdown"
                                                                            id="drpStatus">
                                                                            <option value="0" select>Status</option>
                                                                            <option value="1">Active</option>
                                                                            <option value="2">Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                        <div class="col-md-1">
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
                                                    <th></th>
                                                    
                                                    <th>Topic</th>
                                                    <th>Format</th>
                                                    <th>Level</th>
                                                    
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
										<?php
										
										foreach($result as $value){
										?>										
                                                <tr>
                                                    <td></td>
                                                    
                                                    <td><?php echo $value->ss_aw_lesson_topic;?></td>
                                                    <td><?php echo $value->ss_aw_lesson_format;?></td>
                                                    <td><?php echo $value->ss_aw_course_name;?></td>
                                                   
                                                    <?php
                                                     $lesson_status=$value->ss_aw_lesson_status; 
													 $lesson_id=$value->ss_aw_lession_id; 
                                                    ?>
                                                    <td>
                                                        <?php
                                                        if($lesson_status==1)
                                                        {
                                                            ?>

                                                        <a href="#" onclick="return change_status('<?php echo $lesson_id ?>','<?php echo $lesson_status ?>');" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#warning-status-modal">Active</a></td>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="#" onclick="return change_status('<?php echo $lesson_id ?>','<?php echo $lesson_status ?>');" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#warning-status-modal">In Active</a>
                                                            <?php
                                                        } 
                                                        ?>

                                                    <td>
                                                        <a href="javascript:void(0);" class="action-icon" title="Edit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" onclick="return lesson_delete('<?php echo $lesson_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"   title="Delete" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-delete"></i></a>

                                                               
                                                       
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
                                    <!-- <form action="#" id="demo-form"> -->
                                        <div class="form-row">
                                            <p>Flamma speciem permisit nunc longo altae bracchia stagna diverso
                                                deorum.</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Subject<span class="text-danger">*</span></label>
                                                <select id="" class="selectize-drop-header">
                                                    <option value="1">English</option>
                                                    <option value="2">Option 2</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Topic<span
                                                        class="text-danger">*</span></label>
                                                <select id="" class="selectize-drop-header">
                                                    <option value="1">Nouns</option>
                                                    <option value="2">Adverbs</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Format<span class="text-danger">*</span></label> 
                                                <select id="" class="selectize-drop-header">
                                                    <option value="">Select</option>
                                                    <option value="1">Single</option>
                                                    <option value="2">Option 2</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="select-code-language">Level<span
                                                        class="text-danger">*</span></label>
                                                <select id="" class="selectize-drop-header">
                                                    <option value="1">Level E</option>
                                                    <option value="2">Level C</option>
                                                    <option value="3">Level A</option>
                                                    
                                                </select>
                                            </div>
                                        </div>


                                       <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
            
                                        <form action="/" method="post" class="dropzone" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
                                            data-upload-preview-template="#uploadPreviewTemplate">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>

                                            <div class="dz-message needsclick">
                                                <i class="h1 text-muted dripicons-cloud-upload"></i>
                                                <h3>Drop files here or click to upload.</h3>
                                                <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
                                                    <strong>not</strong> actually uploaded.)</span>
                                            </div>
                                        </form>

                                        <!-- Preview -->
                                        <div class="dropzone-previews mt-3" id="file-previews"></div>  
<p class="text-muted">Note : Only Excel file format allowed. <a href="#">Sample Template</a> file found here.</p>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div><!-- end col -->
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
                                    <!-- </form> -->
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
                                <p class="mt-3">Deleting will remove this parent from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url() ?>admin/lessons" method="post">
                                        <input type="hidden" name="lesson_delete_process" id="lesson_delete_process">
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
                                <p class="mt-3">Are you sure you want to update the status?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url(); ?>admin/lessons" method="post">
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
    ! function(t) {
        "use strict";

        function o() {}
        o.prototype.init = function() {
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
    function() {
        "use strict";
        window.jQuery.EditableTable.init()
    }();

    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus,#drpLevel').prop('selectedIndex', 0);
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

    });
    </script>

</body>
</html>
    	