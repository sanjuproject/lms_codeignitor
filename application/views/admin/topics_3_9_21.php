 
    <!-- start-debasis -->
    <!-- Plugins css -->
    
    <link href="<?php echo base_url();?>assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
 <!-- start-debasis -->
 <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

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
                                    <li class="breadcrumb-item">Manage Topics</li>

                                    <li class="breadcrumb-item active">List of Topics</li>
                                </ol>
            
                            </div>
                        </div>
                        
                    </div>
                    <!-- end page title -->

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Topics</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="footerformView float-right mb-2">
                                <form>
                                    <div class="row content-right">
                                    <select class="form-control topselectdropdown" id="drpMultipleCta" onchange="dofunctions();">
                                        <option value="" select>Please Select</option>
                                        <option value="1">Add new topic</option>
                                        <option id="delete_option_id" value="2">Deleted selected options</option>
                                    </select>
                                   <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2 mr-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                   
                                </form>
                            </div>
                        </div>

</div>

					<?php include("error_message.php");?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row mb-2">
                                        <div class="col-sm-4">

                                            <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#modal1-add-topic"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add New Topic</a>
                                        </div>
                                        <!-- start-debasis -->
                                        <div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url(); ?>admin/topics" method="post" id="demo-form">
                                                    <div class="row content-right">
                                                         <div class="form-group mb-3 mr-2">
                                                            <select name="search_level" class="form-control" onchange="this.form.submit()">
                                                                <option>Select Levels</option>
                                                                <option value="A" <?php if(isset($search_data['ss_aw_expertise_level'])){
                                                                    if($search_data['ss_aw_expertise_level']=='A'){
                                                                        echo "selected";
                                                                    }
                                                                } ?>>A</option>
                                                                <option value="C"<?php if(isset($search_data['ss_aw_expertise_level'])){
                                                                    if($search_data['ss_aw_expertise_level']=='C'){
                                                                        echo "selected";
                                                                    }
                                                                } ?>>C</option>
                                                                <option value="E" <?php if(isset($search_data['ss_aw_expertise_level'])){
                                                                    if($search_data['ss_aw_expertise_level']=='E'){
                                                                        echo "selected";
                                                                    }
                                                                } ?>>E</option>
                                                            </select>                                                     
                                                            </div>
                                                      
                                                            <div class="form-group mb-3 mr-2">
                                                         
                                                                    <input type="text" class="form-control"
                                                                        id="txtFilter"
                                                                        placeholder="Topic / Section name"
                                                                        aria-label="Recipient's username" name="section_name" value="<?php if(!empty($search_data['ss_aw_section_title'])){echo $search_data['ss_aw_section_title']; }?>">
                                                                        <input type="hidden" name="search_by_section" value="search_by_section">
                                                                   
                                                               
                                                            </div>
                                                       
                                                        <?php
                                                        if($this->session->userdata('search_status_check')!="")
                                                        {
                                                            $status_check = $this->session->userdata('search_status_check');
                                                        }
                                                        else{
                                                            $status_check = "";
                                                        } 

                                                        ?>
                                                       
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                        
                                                                    <select
                                                                        class="form-control adminusersbottomdropdown"
                                                                        id="drpStatus" onchange="this.form.submit()" name="ss_aw_section_status">
																		<option value="" >Status</option>
                                                                        <option value="1" <?php if(!empty($search_data['ss_aw_section_status']) && $search_data['ss_aw_section_status'] == 1){?> selected <?php } ?>>Active</option>
                                                                        <option value="2" <?php if(!empty($search_data['ss_aw_section_status']) && $search_data['ss_aw_section_status'] == 2){?> selected <?php } ?>>Inactive</option>
                                                                 
                                                                    </select>
                                                                   
                                                                </div>
                                                            </div>

                                                     
                                                        <div class="mr-2 ml-2">
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
                                                    
                                                    <th>Topic / Section Name (ID)</th>
													<th>Levels</th>
                                                    <th>Sub Topic</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
									<form action="<?php echo base_url();?>admin/multipledeletetopic" id="deletedata" method="post">
												
										<?php	foreach($result as $key=>$value){
                                            $topic_id = $value->ss_aw_section_id ;
                                            $topic_status =  $value->ss_aw_section_status ;
                                            $topic_name = $value->ss_aw_section_title;
											$topic_level = $value->ss_aw_expertise_level ;
											$topic_desc = $value->ss_aw_topic_description;
                                                  ?>										
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selecteddata[]" value="<?php echo $value->ss_aw_section_id;?>" class="custom-control-input check_row"
                                                                id="customCheck<?php echo $key + 2;?>" >
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $key + 2;?>"></label>
                                                        </div>
                                                    </td>
                                                    
                                                    
                                                    <td><?php echo $value->ss_aw_section_title." (". $topic_id .")";?></td>
													<td><?php echo $value->ss_aw_expertise_level;?></td>
                                                    <td><a class="link" href="<?php echo base_url();?>admin/subtopics/<?php echo $value->ss_aw_section_id;?>">
													<?php 
													if(!empty($subtopic_result[$value->ss_aw_section_id]))
													echo count($subtopic_result[$value->ss_aw_section_id]);
													else
														echo "0";
													?>
													</a></td>

                                                    <td>
                                                        <?php
                                                         if($value->ss_aw_section_status==1)
                                                         {
                                                            ?>
                                                        <a href="#" class="badge badge-soft-success"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $topic_id ?>','<?php echo $topic_status ?>');">Active</a>
                                                            <?php
                                                              }
                                                              else
                                                              { 
                                                            ?>
                                                             <a href="#" class="badge badge-soft-danger"
                                                            title="Make Inactive" data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return change_status('<?php echo $topic_id ?>','<?php echo $topic_status ?>');">Inactive</a>
                                                            <?php
                                                              }
                                                            ?>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="action-icon"  data-toggle="modal" data-target="#modal5-add-topic" onclick="return edit_topic('<?php echo $topic_id ?>',
														'<?php echo $topic_name; ?>','<?php echo $topic_level; ?>','<?php echo $topic_desc; ?>');"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete"  onclick="return topic_delete('<?php echo $topic_id; ?>');"> <i class="mdi mdi-delete"></i></a>
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
                                    echo "<li>". $link."</li>";
                                    } ?>
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
                                            <form action="<?php echo base_url(); ?>admin/topics" method="post">

                                            <input type="hidden" id="status_topic_id" name="status_topic_id">   
                                     <input type="hidden" id="status_topic_status" name="status_topic_status">   
                                     <input type="hidden" name="topic_status_change" value="topic_status_change"> 
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
                                        <div class="button-list">
                                            <form action="<?php echo base_url() ?>admin/topics" method="post">
                                                <input type="hidden" name="topic_delete_process" value="topic_delete_process">
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
                    <div class="modal fade" id="modal1-add-topic" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Add New Topic</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-2">
                                    <form action="<?php echo base_url(); ?>admin/topics" class="parsley-examples" id="modal-demo-form" method="post">
                                        <div class="form-group">
                                            <label for="newtopic">Topic Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="newtopic"
                                                placeholder="New topic" name="new_topic" required>
                                                <input type="hidden" name="add_new_topic" value="add_new_topic">

                                        </div>
										<div class="form-group">
                                            <label for="newtopic">Topic Description<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" name="add_topic_desc" type="text" id="topicDescription"
                                                placeholder="Topic description" required>
                                        </div>
							<!-- start-debasis -->
                                         <div class="form-group">
                                        <label for="newtopic">Topic Level<span
                                                    class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="add_topic_level[]" class="form-control select2-multiple"
                                                                        id="drpRoleFiltera" data-toggle="select2"
                                                                        multiple="multiple"
                                                                        data-placeholder="Multiple Roles">

                                                                        <option value="E">E</option>
                                                                        <option value="C">C</option>
                                                                        <option value="A">A</option>

                                                                    </select>
                                                                    E.g: E,C,A
                                                                </div>
                                                            </div>

<!-- end-debasis -->

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
                    <div class="modal fade" id="modal5-add-topic" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Edit Topic</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-2">
                                    <form action="<?php echo base_url(); ?>admin/topics" class="parsley-examples" id="modal-demo-form" method="post">
                                        <div class="form-group">
                                            <label for="newtopic">Topic Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" 
                                                placeholder="New topic" id ="edit_topic_name" name="edit_topic_name" required>
                                                <input type="hidden" name="edit_topic_id" id="edit_topic_id" >
                                                <input type="hidden" name="edit_new_topic" value="edit_new_topic">

                                        </div>
										
										<div class="form-group">
                                            <label for="newtopic">Topic Description<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" name="edit_topic_desc" type="text" id="edit_topicDescription"
                                                placeholder="Topic description" required>
                                        </div>

										<div class="form-group">
                                            <label for="newtopic">Topic Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="edit_topic_level"
                                                placeholder="Edit Topic Level" name="edit_topic_level" required>
                                          E.g: E,C,A

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
                                    <form action="#" class="parsley-examples" id="modal-demo-form">
                                        <div class="form-group">
                                            <label for="newtopic">Sub Topic Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="newtopic"
                                                placeholder="New topic" required>
                                        </div>
                                        <div class="form-group ">
                                            <div class="input-group">
                                                <select class="form-control adminusersbottomdropdown" >
                                                    <option value="0" select>Select Topic Name</option>
                                                    <option value="1">Topic 1</option>
                                                    <option value="2">Topic 2</option>
                                                </select>
                                            </div>
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
    .card{
        box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
    }
    .card-box{
        border: 1px solid #ced4da;
    }
    /*******Start-debasis******/
.content-right{
    justify-content: flex-end;
}
/*******End-debasis******/
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
    jQuery(function() {
        jQuery('#btnClearFilter').click(function() {
            jQuery('#txtFilter').val('');
            jQuery('#drpStatus').prop('selectedIndex', 0);
            <?php
             $this->session->set_userdata('search_status_check','');
             $url = base_url().'admin/topics';
             ?>
            window.location.href = "<?php echo $url; ?>";
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
		
		jQuery('#choosetopiclevel :checkbox').click(function() {
            let $this = jQuery(this);
            let thisCheckedState = $this.is(':checked');
            let targetCheckbox = $this.closest('table').find('choosetopiclevel :checked');
            if (!thisCheckedState) {
                targetCheckbox.prop('checked', false);
            }
        });

    });
    </script>


<script type="text/javascript">
    function change_status(topic_id,topic_status){
          if(topic_status==1)
          {
            topic_status = 0;
             $('#status_warning_msg').text('Are you sure you want to change the status to Inactive?');
          }
          else
          {
            topic_status = 1;
            $('#status_warning_msg').text('Are you sure you want to change the status to Active?');
          }
          document.getElementById('status_topic_status').value = topic_status;
          document.getElementById('status_topic_id').value = topic_id;

     }
      function edit_topic(topic_id,topic_name,topic_level,topic_desc){
         
          document.getElementById('edit_topic_name').value = topic_name;
          document.getElementById('edit_topicDescription').value = topic_desc;
		  document.getElementById('edit_topic_id').value = topic_id;
		  document.getElementById('edit_topic_level').value = topic_level;	
     }
     
     function topic_delete(topic_id)
     {
         document.getElementById('topic_delete_id').value = topic_id;
     }
     function myform_subimt()
     {
        document.getElementById("myForm12").submit();

     }
 function dofunctions()
{
	var selected_val = $("#drpMultipleCta option:selected").val();
	if(selected_val == 1)
		$("#modal1-add-topic").modal('toggle');
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

function searchsubtopic()
{
	$("#demo-form").submit();
}   

</script>

</body>
</html>
    	