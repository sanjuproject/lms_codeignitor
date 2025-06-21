    <!-- Plugins css -->
    <link href="<?php echo base_url();?>assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"
        type="text/css" />

    <!-- App css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-6">
                            <div class="page-title-box">
                                <h4 class="page-title">LIST OF ADMIN USRES</h4>
                            </div>
                        </div>
                        <div class="col-6">
                        <div class="footerformView float-right mt-3 mr-2">
                            
                                <form>
                                    <div class="row content-right">
                                    <select class="form-control topselectdropdown" onchange="dofunctions();" id="drpMultipleCta">                                    
                                    <option value="" select>Please Select</option>
                                        <option value="2">Add new Admin User</option>
                                        <option value="3">Delete All</option>
                                    </select>
                                    
                                     <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs ml-2" id="btnAudio1" id="btnClearFilter"><i class="mdi mdi-refresh"></i></button>
                                    </div>
                                   
                                </form>
                               
                            </div>
                    </div>

                    <!-- end page title -->
					<?php include("error_message.php");?>
<!-- Start-debasis -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4">

                                            <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#custom-modal"><i
                                                    class="mdi mdi-plus-circle mr-2"></i> Add New</a>
                                        </div>
                                        
										<!--Start-debasis-->
										<div class="col-sm-8">
                                            <div class="text-sm-right">
                                                <form action="<?php echo base_url();?>admin/adminusers" method="post" id="demo-form">
                                                    <div class="row content-right">
                                                       
                                                            <div class="form-group mb-3 mr-2">
                                                                <div class="input-group">
                                                                    <input type="text" id="txtFilter" class="form-control" value="<?php if(!empty($search_value)){ echo $search_value; } ?>" 
																		name="search_value"
                                                                        placeholder="Name or Mobile or Email"
                                                                        aria-label="Recipient's username">
                                                                    <div class="input-group-append">
                                                                        <button
                                                                            class="btn btn-primary waves-effect waves-light"
                                                                            type="submit">Search</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                        
                                                            <div class="form-group mb-3 mr-2">
                                                                <div class="input-group select-item-width">
																
                                                                    <select class="form-control select2-multiple"
                                                                        id="drpRoleFilter" data-toggle="select2"
                                                                        multiple="multiple"
                                                                        data-placeholder="Multiple Roles" name="selected_roles[]" onchange="searchusersrole();">

                                                                         <?php foreach($category as $key=>$val){ ?>
																
															<?php foreach($val as $key2=>$val2){ 
																	
															?>
																	<option <?php if(!empty($selected_roles)){ if(in_array($key2,$selected_roles)){?> selected <?php }} ?> value="<?php echo $key2;?>"><?php echo $val2;?></option>
																<?php } ?>    
																	
															<?php } ?> 

                                                                    </select>
                                                                </div>
                                                            </div>

                                                   
                                                        <div>
                                                            <button type="button" id="btnClearFilter"
                                                                class="btn btn-danger waves-effect waves-light">Clear</button>
                                                        </div>
                                                
                                                </form>
                                            </div>
                                        </div>

                                        <!--End-debasis-->

                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100">
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
                                                    
                                                    
													<th>Name</th>
                                                    <th class="mobilecol">Mobile</th>
                                                    <th class="emailcol">Email</th>
                                                    <th>Roles</th>
                                                    <th>Status</th>
                                                    <th class="actioncol">Action</th>
                                                </tr>
                                            </thead>

									<form action="<?php echo base_url();?>admin/multipledeleteadminusers" id="deleteuserdata" method="post">
                                            <tbody>
											<?php
											
											if(!empty($adminuserslist)){
											$i = 1;
											foreach($adminuserslist as $value){
											
											?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox" id="checkboxdata">
                                                            <input type="checkbox" name="selectedusers[]" value="<?php echo $value['ss_aw_admin_user_id'];?>" class="custom-control-input"
                                                                id="customCheck<?php echo $i+1;?>">
                                                            <label class="custom-control-label"
                                                                for="customCheck<?php echo $i+1;?>"></label>
                                                        </div>
                                                    </td>
                                                    
                                                    <td><?php echo $value['ss_aw_admin_user_full_name'];?></td>
                                                    <td>
                                                       <?php
                                                       $temp_mob_no =  $value['ss_aw_admin_user_mobile_no'];
                                                       ?> 
                                                        <?php echo substr($temp_mob_no, '0', '5');?>-<?php echo substr($temp_mob_no,'-5'); ?>
                                                            
                                                        </td>
                                                    <td><?php echo $value['ss_aw_admin_user_email'];?></td>
                                                    <td>
                                                        <?php $roleary = explode(",",$value['ss_aw_admin_user_role_ids']);
														$colorcode = array('badge-soft-primary','badge-soft-warning','badge-soft-success','badge-soft-info','badge-soft-danger',
														'badge-soft-dark','badge-soft-pink','badge-soft-secondary');
														$total_color = count($colorcode) - 1;
														
														foreach($roleary as $val2)
														{
															foreach($adminmenuary as $val)
															{
																if($val2 == $val['ss_aw_id'])
																{
																	$rand_color = rand(0,$total_color);
																	echo '<p class="badge '. $colorcode[$rand_color].'">'.$val['ss_aw_menu_name'].'</p>';
																}																	
															}
														}
														?></p>
                                                    </td>
                                                    <td><a href="#" class="badge <?php if($value['ss_aw_admin_user_status'] == 1){ ?> badge-soft-success <?php } else { ?> badge-soft-danger <?php } ?>"
                                                            title="Make <?php if($value['ss_aw_admin_user_status'] == 1){ ?> Inactive <?php } else { ?> Active <?php } ?>" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true"
                                                            data-toggle="modal"
                                                            data-target="#warning-status-modal" onclick="return adminuser_status('<?php if($value['ss_aw_admin_user_status'] == 1){
															?>0<?php }else{ ?>1<?php } ?>','<?php echo $value['ss_aw_admin_user_id']; ?>');">
															<?php if($value['ss_aw_admin_user_status'] == 1){
															?>Active<?php }else{ ?>Inactive<?php } ?></a>
															</td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="updateadminuser(<?php echo $value['ss_aw_admin_user_id']; ?>);" class="action-icon"
                                                            data-toggle="modal" data-target="#custom-modal-edit"> <i
                                                                class="mdi mdi-square-edit-outline" title="Edit"
                                                                data-plugin="tippy" data-tippy-animation="shift-away"
                                                                data-tippy-arrow="true"></i></a>
                                                        <a href="javascript:void(0);" onclick="return adminuser_delete('<?php echo $value['ss_aw_admin_user_id']; ?>');" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-delete-modal"
                                                            title="Delete" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true">
                                                            <i class="mdi mdi-delete"></i></a>
                                                            <a onclick="return confirm('Do you really want to reset password?');" href="<?= base_url(); ?>admin/reset_admin_password/<?= $value['ss_aw_admin_user_id'] ?>" class="badge badge-soft-success">Reset Password</a>
                                                    </td>

                                                </tr>
                                            <?php $i++;}} ?>    

                                            </tbody>
                                        </table>

                                        <!------start-no-data-------->


<!-- <div class="nodatasection">
<h2>Sorry ! No data found. Please try another sort options</h2>
</div> -->
 <!------end-no-data------>
                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                        <div class="col-md-4 mb-2">
                            <input type="hidden" name="selected_action" id="selected_action">
                               <!--  <div class="footerformView mb-8">
                                    <select class="form-control adminusersbottomdropdown" onchange="submitform();" name="selected_action" id="drpMultipleCta">
                                        <option value="" select>Please Select</option>
                                        
                                        <option value="2">Add new Admin User</option>
										<option value="3">Delete All</option>

                                    </select>
                                    <button type="button" id="btnGo" onclick="dofunctions();"
                                        class="btn btn-primary waves-effect waves-light goBtn">
                                        Go
                                    </button>
                                </div> -->

                            </form>
                        </div>
                    </div>
                    <!-- end row-->
				
					<!-- End-debasis -->
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
                                <p class="mt-3">Deleting will remove this user from the system. Are you sure ?</p>
                                <div class="button-list">
								<form action="<?php echo base_url();?>admin/deleteadminusers" class="deleteform" method="post">
                                        
                                        <input type="hidden" name="admin_delete_id" id="admin_delete_id">
                                    
                                    <button type="submit" class="btn btn-danger" >Yes</button>
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
								<form action="<?php echo base_url();?>admin/statusadminusers" class="deleteform" method="post">
                                        
                                  <input type="hidden" name="admin_status_id" id="admin_status_id">
								  <input type="hidden" name="admin_status" id="admin_status">
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
                include('bottombar.php');
            ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <!-- Modal -->
    <!--<div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?php echo base_url();?>admin/addadminuser" class="parsley-examples" method="post" id="demo-form">
                        <div class="form-group">
                            <label for="fullname">Full Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Enter your name"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="emailaddress">Email<span class="text-danger">*</span></label>
                            <div class="verification-parent">
                                <input type="email" class="form-control" name="email" id="emailaddress" required parsley-type="email"
                                    placeholder="Enter your email" />
                                <div class="verification-btn">
                                    <a href="#" class="badge badge-soft-warning">Need Verifification</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Mobile">Mobile <span class="text-danger">*</span></label>
                            <div class="verification-parent">
                                <input type="text" class="form-control" required placeholder="Enter only mobile numbers"
                                    id="Mobile" data-toggle="input-mask" name="mobile" data-mask-format="(+00) 0000-0000-00" />
                                <div class="verification-btn">
                                    <a href="#" class="badge badge-soft-warning">Need Verifification</a>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group mb-4 adminusersselectroles">
                                <p class="mb-1 font-weight-bold text-muted mt-3 mt-md-0">Select Roles</p>
                                <select multiple="multiple" class="multi-select" id="my_multi_select2"
                                    name="my_multi_select2[]" data-plugin="multiselect" data-selectable-optgroup="true"
                                    data-parsley-mincheck="2" required>
                                  <?php foreach($category as $key=>$val){ ?>
									<optgroup label="<?php echo $key;?>">
									<?php foreach($val as $key2=>$val2){ ?>
                                        <option value="<?php echo $key2;?>"><?php echo $val2;?></option>
                                    <?php } ?>    
                                    </optgroup>
								  <?php } ?> 
                                </select>

                            </div>
						
						

                        

                        <div class="text-right">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="Custombox.close();">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>--><!-- /.modal -->
	
	<div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog customewidth modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Add User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <div class="modal-body p-4">
                        <form action="<?php echo base_url();?>admin/addadminuser" class="parsley-examples" method="post" id="demo-form">
                            <div class="form-group">
                                <label for="fullname">Full Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Enter your name"
                                required>
                            </div>

                            <div class="form-group">
                                <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                <div class="verification-parent">
                                    <input type="email" class="form-control" name="email" onblur="check_email(this.value);" id="emailaddress" required parsley-type="email"
                                    placeholder="Enter your email" />
                                    <div class="verification-btn error_msg">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Mobile">Mobile <span class="text-danger">*</span></label>
                                <div class="verification-parent">
                                   <input type="text" class="form-control" required placeholder="Enter only mobile numbers"
                                    id="Mobile" data-toggle="input-mask" onblur="check_phone(this.value);" name="mobile" data-mask-format="00000-00000" />
                                    <div class="verification-btn error_msg_phone">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4 adminusersselectroles">
                                <p class="mb-1 font-weight-bold text-muted mt-3 mt-md-0">Select Roles</p>
                                <select multiple="multiple" class="multi-select" id="my_multi_select2"
                                    name="my_multi_select2[]" data-plugin="multiselect" data-selectable-optgroup="true"
                                    data-parsley-mincheck="2" required>
                                  <?php foreach($category as $key=>$val){ ?>
									<optgroup label="<?php echo $key;?>">
									<?php foreach($val as $key2=>$val2){ ?>
                                        <option value="<?php echo $key2;?>"><?php echo $val2;?></option>
                                    <?php } ?>    
                                    </optgroup>
								  <?php } ?> 
                                </select>

                            </div><!-- form-group -->
                            <div class="text-left">
                                <input type="submit"
                                    class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save" />
                                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true"
                                    onclick="Custombox.close();">Cancel</button>
                            </div>

                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
	
	<!-- Modal -->
    <div class="modal fade" id="custom-modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog customewidth modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?php echo base_url();?>admin/editadminuser" class="parsley-examples" method="post" id="demo-form">
                        <input class="form-control" type="hidden" name="userid" id="edituserid" />
						<div class="form-group">
                            <label for="fullname">Full Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="fullname" id="edit_fullname" placeholder="Enter your name"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="emailaddress">Email<span class="text-danger">*</span></label>
                            <div class="verification-parent">
							<input type="hidden" id="email_verified" value="1" />
							<input type="hidden" id="userid" name="userid" value="" />
							<input type="hidden" id="old_email" name="old_email" value="" />
                                <input type="email" class="form-control" name="email" id="email" required parsley-type="email"
                                    placeholder="Enter your email" />
                                <div class="verification-btn">
                                    <!--<a href="javascript:void(0);" onclick="sendverificationcode();" id="email_verify" class="badge badge-soft-warning">Need Verifification</a>-->
                                </div>
								<span id="email_verify_error" style="color:red;"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Mobile">Mobile <span class="text-danger">*</span></label>
                            <div class="verification-parent">
							<input type="hidden" id="phone_verified" value="1" />
							<input type="hidden" id="old_phone" name="old_phone"  value="" />
                                <input type="text" class="form-control" required placeholder="Enter only mobile numbers"
                                    id="phone" data-toggle="input-mask" name="mobile" data-mask-format="00000-00000" />
                                <div class="verification-btn">
                                    <!--<a href="javascript:void(0);" class="badge badge-soft-warning" onclick="sendverificationcode_phone();" id="phone_verify" >Need Verifification</a>-->
                                </div>
								<span id="phone_verify_error" style="color:red;"></span>
                            </div>
                        </div>

                        
						<div class="form-group mb-4 adminusersselectroles">
                                <p class="mb-1 font-weight-bold text-muted mt-3 mt-md-0">Select Roles</p>
                                <select multiple="multiple" class="multi-select" id="edit_my_multi_select2"
                                    name="edit_my_multi_select2[]" data-plugin="multiselect" data-selectable-optgroup="true"
                                    data-parsley-mincheck="2" required>
                                  <?php foreach($category as $key=>$val){ ?>
									<optgroup label="<?php echo $key;?>">
									<?php foreach($val as $key2=>$val2){ ?>
                                        <option value="<?php echo $key2;?>" id="editcheckbox<?php echo $key2;?>"><?php echo $val2;?></option>
                                    <?php } ?>    
                                    </optgroup>
								  <?php } ?> 
                                </select>

                            </div>

                        <!-- form-group -->
<!----Start-debasis---->
                        <div class="text-left">
                            <button type="submit" class="btn btn-success waves-effect waves-light verify edituserbutton" >Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true"
                                onclick="Custombox.close();">Cancel</button>
                        </div>
                        <!----End-debasis---->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	

<!-- Modal -->
    <div class="modal fade" id="modal1-verify1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Enter the code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">

                    <form action="#" class="parsley-examples" id="demo-form-modal1-verify1">

                        <div class="verify-title form-group container">

                            <!-- <ul class="parsley-errors-list filled" id="parsley-id-53" aria-hidden="false">
                                <li class="parsley-required">This value is required.</li>
                            </ul> -->
                            <div class="verify-form-group mb-2 mt-4">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify1" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify2" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify3" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal1_verify4" maxlength="1">
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="text-center mb-2">
                            <button type="button" onclick="verify_email();" class="btn btn-success waves-effect waves-light">Verify</button>

                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal2-verify1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal2">Enter the code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="mt-0">

                    <div class="progress progress-sm m-0" style="height: 2px;">
                        <div class="progress-bar bg-success resendprogress" role="progressbar" aria-valuenow="95" aria-valuemin="0"> </div>
                    </div>

                </div>
                <div class="modal-body p-2">

                    <form action="#" class="parsley-examples" id="demo-form-modal2">

                        <div class="verify-title form-group container-modal-second">

                          
                            <!-- <h6> <span class="float-right">60 Seconds</span></h6> -->
                            <div class="verify-form-group mb-2 mt-4 ">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify1" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify2" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify3" maxlength="1">
                                <input class="form-control verify-form-control" required type="text" id="modal2_verify4" maxlength="1">

                            </div>
                            <a href="javascript:void(0);" onclick="reset_sendverificationcode_phone();" class="btn-resend-otp">Resend OTP</a>
                        </div>
                        <!-- form-group -->
                        <div class="text-center mb-2">
                            <button type="button" onclick="verify_phone();" class="btn btn-success waves-effect waves-light">Verify</button>

                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	<div class="modal fade" id="modal1-message" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Error Message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">

                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>	

<script>

function adminuser_delete(userid)
{
	$("#admin_delete_id").val(userid);
}
function adminuser_status(status,userid)
{
	$("#admin_status_id").val(userid);
	$("#admin_status").val(status);
}
function updateadminuser(userid)
{
	$.post("getadminuserdata", { id: userid })
  .done(function( data ) {
	  var jsondata = JSON.parse(data);
    $("#edituserid").val(userid);
	$("#edit_fullname").val(jsondata.ss_aw_admin_user_full_name);
	$("#email").val(jsondata.ss_aw_admin_user_email);
	$("#old_email").val(jsondata.ss_aw_admin_user_email);
	$("#userid").val(jsondata.ss_aw_admin_user_id);
	$("#phone_verified").val(jsondata.ss_aw_admin_user_mobile_approved);
	if(jsondata.ss_aw_admin_user_mobile_approved == 1)
	{
		$("#phone_verify").css('display','none');
	}
	$("#email_verified").val(jsondata.ss_aw_admin_user_email_approved);
	if(jsondata.ss_aw_admin_user_email_approved == 1)
	{
		$("#email_verify").css('display','none');
	}
	if(jsondata.ss_aw_admin_user_email_approved == 1 && jsondata.ss_aw_admin_user_mobile_approved == 1)
	{
		$(".edituserbutton").attr("disabled", false);
	}
	$("#phone").val(jsondata.ss_aw_admin_user_mobile_no);
	$("#old_phone").val(jsondata.ss_aw_admin_user_mobile_no);
	var role_ids = jsondata.ss_aw_admin_user_role_ids;
	var role_idary = "";
	role_idary = role_ids.split(",");
		for(var i=0; i<role_idary.length;i++)
		{
			//$('#edit_my_multi_select2 optgroup option[value="1"]').attr("selected", "selected");			
			//$("#editcheckbox"+role_idary[i]).prop('selected', true); 
			jQuery('#editcheckbox'+role_idary[i]).attr('selected', '');
            jQuery('[data-plugin="multiselect"]').multiSelect(jQuery(this).data());
		}

		
  });
}
var phone_status = 0;
var email_status = 0;
function check_email(email)
{
	$.post("check_admin_email_exist", { email: email,userid: 0 })
  .done(function( data ) {
	  if(data == 0)
	  {
		  email_status = 0;
		  $(".error_msg").html("Email address exist");
		  $(".adduserbutton").attr("disabled", true);
	  }
	  else if(data == 1 && email!='')
	  {
		  email_status = 1;
		  $(".error_msg").html("");
		 
		  if(phone_status == 1 && email_status == 1)
		  {
			$(".adduserbutton").attr("disabled", false);
		  }
	  }
  });
}
function check_phone(phone)
{
	$.post("check_admin_phone_exist", { phone: phone,userid: 0,email:"test@gmail.com" })
  .done(function( data ) {
	  if(data == 0 && phone!='')
	  {
		  phone_status = 0;
		  $(".error_msg_phone").html("Phone no exist");
		  $(".adduserbutton").attr("disabled", true);
	  }
	  else if(data == 1 && phone!='')
	  {
		  phone_status = 1;
		  $(".error_msg_phone").html("");
		  if(phone_status == 1 && email_status == 1)
		  {
			$(".adduserbutton").attr("disabled", false);
		  }
	  }
  });
}

</script>

    <style type="text/css">
    .verification-parent {
        position: relative;
    }

    .verification-btn {
        position: absolute;
        top: 7px;
        right: 1px;
        background: #fff;
        padding: 0px 8px;

    }

    .custom-ViewBox {
        background: #fff;
        display: table;
        margin-top: -10px;
        margin-left: -5px;
        padding: 0px 3px 0px 8px;
    }

    .custom-checkboxView {
        border: 1px solid #ced4da;
        padding: 0px 12px;
        box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
        background: #fff;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .under-checkboxView {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: start;
        display: none;
    }
    </style>
<?php include('footer.php'); ?>
<script>
 jQuery(function() {
	 jQuery('#btnClearFilter').click(function() {
                jQuery('#txtFilter').val('');
                jQuery('#drpRoleFilter').prop('selectedIndex',-1).select2();
				searchusersrole();
            });
jQuery('#customCheck1').click(function(){
                let $this = jQuery(this);
                let thisCheckedState = jQuery(this).is(':checked');
                let listOfCheckboxes = $this.closest('table').find('tbody tr td:first-child :checkbox');
                
                if(thisCheckedState){
                    listOfCheckboxes.each(function(){
                        jQuery(this).prop('checked', true);
                    });
                }else{
                    listOfCheckboxes.each(function(){
                        jQuery(this).prop('checked', false);
                    });
                }
                
            });
			jQuery('tbody tr td:first-child :checkbox').click(function(){
                let $this = jQuery(this);
                let thisCheckedState =  $this.is(':checked');
                let targetCheckbox = $this.closest('table').find('tr th:first-child :checked');
                if(!thisCheckedState){
                    targetCheckbox.prop('checked',false);
                }
            });
 });
 
 function searchusersrole()
 {
	 $("#demo-form").submit();
 }
 
 function dofunctions()
{
	var selected_val = $("#drpMultipleCta option:selected").val();
	if(selected_val == 2)
		$("#custom-modal").modal('toggle');
	if(selected_val == 3)
	{   
        $('#selected_action').val('3');
		$('#checkboxdata input:checked').each(function() {
				$("#deleteuserdata").submit(); 
			});	
	}
}  
</script>
<script src="<?php echo base_url();?>assets/js/custom_script.js"></script>		

<style type="text/css">
.dropify-wrapper .dropify-message p{
    line-height: 50px;
}
.verification-parent{
    position: relative;
}
.verification-btn{
    position: absolute;
    top: 7px;
    right: 1px;
    background: #fff;
    padding: 0px 8px;
}
.parsley-error {
    border-color: #f1556c;
}
/*******Start-debasis******/
.table td:nth-child(5), .table th:nth-child(5){
  width: 300px;
}
.badge{
    margin: 0px 3px;
}
.content-right{
    justify-content: flex-end;
}
.select-item-width{
    width: 230px;
}
.nodatasection{
    text-align: center;
    padding: 100px 0px;
    border-top: 1px solid #dee2e6;
}
.nodatasection h2{
    font-size: 20px;
    color: red;
   
}
.topselectdropdown{
        width: 200px;
    }
    .content-right button i{
        font-size: 16px;
    }
/*******End-debasis******/
</style>
</body>
</html>
	


   