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
                                    <li class="breadcrumb-item active">Notification Templates CMS</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                      <div style="display: none" id="success_msg" class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Notification templates updated succesfully.  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div style="display: none" id="success_msg_status" class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Status updated succesfully.  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                     <div style="display: none" id="success_msg_mail" class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Test mail send successful.  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <h4 class="page-title">Notification Templates CMS</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right mb-2">
                                <form action="<?php echo base_url() ?>admin/notificationtemplatescms" method="post" id="select_notification_form">
                                    <input type="hidden" name="select_notification_preview" value="select_notification_preview">
                                    <select name="select_notification" class="form-control " id="drpNotificationSection">
                                        <option value="0" select>Select a notification section</option>
                                        <?php 
                                        foreach ($email_template_result as $value) {
                                        ?>

                                        <option value="<?php echo $value->ss_aw_email_temp_id;  ?>" <?php if(isset($select_notification))
                                                {
                                                    if($select_notification==$value->ss_aw_email_temp_id)
                                                    {
                                                        echo 'selected';
                                                    }
                                                }
                                         ?>>
                                            <?php echo $value->ss_aw_template_name  ?></option>
                                         <?php
                                        }

                                        ?>
                                       
                                    </select>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">

                        <div class="col-lg-12 col-xl-12">
                            <div class="card-box">
                                
                                <?php
                                if(isset($email_template_resultbyid))
                                {
                                ?>
								
                               <form action="#" class="comment-area-box mt-2 mb-3">
                                    <h4><?php echo $email_template_resultbyid[0]->ss_aw_template_name;  ?></h4>
                                    <?php
                                    $email_template_id = $email_template_resultbyid[0]->ss_aw_email_temp_id;
                                      $email_temp_status = $email_template_resultbyid[0]->ss_aw_email_temp_status;
                                      $email_temp_contain = $email_template_resultbyid[0]->ss_aw_email_temp_contain;
                                    ?>
                                    <div>
                                        <div>
                                            <div class="comment-area-btn custom-comment-area-btn">
                                                <div class="float-right">
                                                <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dynamic code list<i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dynamicTags dropdown-menu" id="drpDynamicTags">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="[@@username@@]" dynamic_value="<?php echo $email_template_resultbyid[0]->ss_aw_email_temp_id;?>">Username</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="[@@email@@]" dynamic_value="<?php echo $email_template_resultbyid[0]->ss_aw_email_temp_id;?>">Email</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="[@@mobile@@]" dynamic_value="<?php echo $email_template_resultbyid[0]->ss_aw_email_temp_id;?>">Mobile</a>

                                                        </div>

                                                        <div class="custom-control custom-switch ml-3">
                                                        <input type="checkbox" onclick="return change_email_template_status('<?php echo $email_template_id; ?>')" class="custom-control-input"
                                                            id="customSwitch_email<?php echo $email_template_id; ?>"  <?php
                                                            
                                                            if($email_temp_status=='1')
                                                            {
                                                                echo 'checked';
                                                            } ?>
                                                            >
                                                        <label class="custom-control-label" for="customSwitch_email<?php echo $email_template_id; ?>"></label>
                                                    </div>
                                                    </div>
                                                 
                                                </div>
                                                <div>
                                                    <h4>Email Notification</h4>
                                                </div>
                                            </div>
                                            <span class="input-icon"></span>
                                            <textarea rows="8" class="form-control" placeholder="Write something..." id="email_template_contain<?php echo $email_template_id; ?>">
                                            <?php echo $email_temp_contain;  ?>
                                        
                                            </textarea>
                                            <div class="comment-area-btn comment-right-btn m-0">
											<div class="col-5">
                                                    <input class="form-control" type="text" id="test_emails"
                                                        placeholder="Separate multiple emails with comma ',">
                                                </div>
                                                <div class="col-1 float-left pl-0">
                                                    <button type="button" style="font-size:18px;" onclick="return send_test_email('<?php echo $email_template_id ?>')"
                                                        class="btn btn-success waves-effect waves-light btn-xs" id=""><i
                                                            class="mdi mdi-email-send-outline"></i></button>
                                                </div>
                                                <div class="col-6">
                                                <div class="float-right">
                                                    <button type="button"
                                                        class="btn btn-success waves-effect waves-light emailPreview" data-toggle="modal" data-target="#modal1-preview">Preview</button>
                                                    <button type="button"
                                                        class="btn btn-warning waves-effect waves-light" onclick="return update_email_template('<?php echo $email_template_id ?>')">Update</button>
                                                    <button type="reset"
                                                        class="btn btn-danger waves-effect waves-light">Cancel</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <?php
									if(!empty($app_template_resultbyid[0]->ss_aw_app_temp_status))	
									{										
										$app_temp_status = $app_template_resultbyid[0]->ss_aw_app_temp_status;
										$app_temp_id = $app_template_resultbyid[0]->ss_aw_app_temp_id;
									}
									else
									{
										$app_temp_status = 0;
										$app_temp_id = 0;
									}
									
                                    ?>
                                            <div class="comment-area-btn custom-comment-area-btn">
                                                <div class="float-right">
                                                <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dynamic code list<i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dynamicTags dropdown-menu" id="drpDynamicTags_app">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="[@@username@@]" dynamic_value="<?php echo $email_template_resultbyid[0]->ss_aw_email_temp_id;?>">Username</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="[@@email@@]" dynamic_value="<?php echo $email_template_resultbyid[0]->ss_aw_email_temp_id;?>">Email</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="[@@mobile@@]" dynamic_value="<?php echo $email_template_resultbyid[0]->ss_aw_email_temp_id;?>">Mobile</a>

                                                        </div>
                                                        <div class="custom-control custom-switch ml-3">
                                                        <input type="checkbox" onclick="return change_app_template_status('<?php echo $app_temp_id; ?>')" class="custom-control-input"
                                                            id="customSwitch1_app<?php echo $app_temp_id; ?>" <?php
                                                            if($app_temp_status=='1')
                                                            {
                                                                echo 'checked';
                                                            } 
                                                            ?> >
                                                        <label class="custom-control-label" for="customSwitch1_app<?php echo $app_temp_id; ?>"></label>
                                                    </div>
                                                        
                                                    </div>	
                                                    
                                                </div>
                                                   
                                                </div>
                                                <div>
                                                    <h4>In App Notification</h4>
												
                                            </div>
                                            <span class="input-icon"></span>
                                            <textarea rows="8" class="form-control " placeholder="Write something..." id="app_template_contain<?php echo $app_temp_id; ?>">
                                                    <?php 
													if(!empty($app_template_resultbyid[0]->ss_aw_app_temp_contain)){
													echo $app_template_resultbyid[0]->ss_aw_app_temp_contain; 
													}
													
													?>
                                                </textarea>
                                            <div class="comment-area-btn comment-right-btn">
                                                <div class="float-right">
                                                    <!-- new added code -->
                                                    <button type="button"
                                                        class="btn btn-success waves-effect waves-light inappPreview"
                                                        data-toggle="modal"
                                                        data-target="#modal2-preview">Preview</button>
                                                <!-- end - new added code -->
                                                    <button type="button"
                                                        class="btn btn-warning waves-effect waves-light" onclick="return update_app_template('<?php echo $app_temp_id ?>')">Update</button>
                                                    <button type="reset"
                                                        class="btn btn-danger waves-effect waves-light">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                    }else{ 
                                ?>
								<h4 class="noData text-danger text-center">Please choose a notification first</h4>
									<?php } ?>	
                            </div> <!-- end col -->
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modal1-preview" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Template Preview
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body p-2">
                                        <div id="dvEmailTemplatePreview"></div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
					<!-- new added code -->
                        <div class="modal fade" id="modal2-preview" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body p-2 bg-secondary p-0">
                                    
                                        <div class="mobile-notification-wrapper bg-white">
                                            <div class="notification-message">
                                                <div class="notification-heading">  
                                                    <img src="<?php echo base_url();?>images/alsowise-logo-without-name.png" width="20"/>
                                                    <label>Alsowise - <span>1m</span></label>
                                                </div>
                                                <div id="dvInAppPreview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                         <!-- end - new added code -->
					
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
         <?php
            include('footer.php')
        ?>
         
        <script>
        jQuery(function() {
            jQuery('.emailPreview').click(function() {
                let targetObj = jQuery(this).parent().parent().parent().prev();
                jQuery('#dvEmailTemplatePreview').html(targetObj.val());
            });
			
			jQuery('.appPreview').click(function() {
                let targetObj = jQuery(this).parent().parent().prev();
                jQuery('#dvEmailTemplatePreview').html(targetObj.val());
            });
        });
        </script>
        <script type="text/javascript">

            $('#drpNotificationSection').on('change', function() {
              $( "#select_notification_form" ).submit();
            });
        </script>
        <script src="<?php echo base_url() ?>assets/swal/sweetalert.min.js"></script> 
        <script type="text/javascript">
             function change_app_template_status(id)
         {
                  var app_template_status;

                    if($("#customSwitch1_app"+id).prop("checked") == true){
                        app_template_status = 1;
                    }
                    else if($("#customSwitch1_app"+id).prop("checked") == false){
                        app_template_status = 0;
                    }

                    $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_notificationtemplatescms",
                data: {id:id,'update_template_app_status':'update_template_app_status',app_template_status:app_template_status},
               
                dataType: "json",
                success: function(result){                   
                    swal("Status updated successful");

                }
            });

         }
          function update_email_template(id)
         { 
            var email_template_status; 

            var email_template_contain = $("#email_template_contain"+id).val();

            // if($("#customSwitch_email"+id).prop("checked") == true){
            //     email_template_status = 1;
            // }
            // else if($("#customSwitch_email"+id).prop("checked") == false){
            //     email_template_status = 0;
            // }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_notificationtemplatescms",
                data: {id:id,email_template_contain:email_template_contain,'update_template_email':'update_template_email'},
               
                dataType: "json",
                success: function(result){                   
                    // swal("Record updated successful");
                     $("#success_msg").show();
                     setTimeout(function() {
                        $('#success_msg').fadeOut('fast');
                    }, 5000);


                }
            });
            
         }
		 
		 function send_test_email(id)
         { 
            var email_template_status; 

            var email_template_contain = $("#email_template_contain"+id).val();
			var test_emails = $("#test_emails").val();
     
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/ajax_send_testmail",
                data: {id:id,email_template_contain:email_template_contain,test_emails:test_emails},
               
                dataType: "json",
                success: function(result){
					
                    //swal("Test mail send successful");
                    $("#success_msg_mail").show();
                      setTimeout(function() {
                        $('#success_msg_mail').fadeOut('fast');
                    }, 5000); 
                }
            });
            
         }
		 
          function change_email_template_status(id)
         {
                  var email_template_contain = $("#email_template_contain"+id).val();

                    if($("#customSwitch_email"+id).prop("checked") == true){
                        email_template_status = 1;
                    }
                    else if($("#customSwitch_email"+id).prop("checked") == false){
                        email_template_status = 0;
                    }

                    $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_notificationtemplatescms",
                data: {id:id,'update_template_email_status':'update_template_email_status',email_template_status:email_template_status},
               
                dataType: "json",
                success: function(result){                   
                    // swal("Status updated successful");
                     $("#success_msg_status").show();
                      setTimeout(function() {
                        $('#success_msg_status').fadeOut('fast');
                    }, 5000); 

                }
            });

         }
         function update_app_template(id)
         { 
            var app_template_status; 

            var app_template_contain = $("#app_template_contain"+id).val();

            // if($("#customSwitch1_app"+id).prop("checked") == true){
            //     app_template_status = 1;
            // }
            // else if($("#customSwitch1_app"+id).prop("checked") == false){
            //     app_template_status = 0;
            // }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_notificationtemplatescms",
                data: {id:id,app_template_contain:app_template_contain,app_template_status:app_template_status,'update_template_app':'update_template_app'},
               
                dataType: "json",
                success: function(result){
                     // swal("Record updated successful"); 
                      $("#success_msg").show();
                      setTimeout(function() {
                        $('#success_msg').fadeOut('fast');
                    }, 5000);      

                }
            });
            
         }
        </script>
		
	<script>
            jQuery('#drpDynamicTags a').on('click', function() {
				
                myValue = jQuery(this).data('value');
				dynamic_value = jQuery(this).attr('dynamic_value');
                
				var cursorPos = jQuery('#email_template_contain'+dynamic_value).prop('selectionStart');
                var v = jQuery('#email_template_contain'+dynamic_value).val();
                var textBefore = v.substring(0, cursorPos);
                var textAfter = v.substring(cursorPos, v.length);
                jQuery('#email_template_contain'+dynamic_value).val(textBefore + myValue + textAfter);
            });
			
			jQuery('#drpDynamicTags_app a').on('click', function() {
				
                myValue = jQuery(this).data('value');
				dynamic_value = jQuery(this).attr('dynamic_value');
                
				var cursorPos = jQuery('#app_template_contain'+dynamic_value).prop('selectionStart');
                var v = jQuery('#app_template_contain'+dynamic_value).val();
                var textBefore = v.substring(0, cursorPos);
                var textAfter = v.substring(cursorPos, v.length);
                jQuery('#app_template_contain'+dynamic_value).val(textBefore + myValue + textAfter);
            });
			jQuery(function() {
				//new added code
				let inAppDataObj = new Array();
				inAppDataObj.push(['[@@username@@]', 'johndoe']);
				inAppDataObj.push(['[@@email@@]', 'john.doe@companyname.com']);
				inAppDataObj.push(['[@@mobile@@]', '+91-1234567890']);
				console.log(inAppDataObj)

				jQuery('.inappPreview').click(function() {
					let dynamic_value = jQuery('#drpDynamicTags_app a').attr('dynamic_value');
					
					let targetObj = jQuery('#app_template_contain'+dynamic_value);
					let targetData = targetObj.val();
					for (let i = 0; i < inAppDataObj.length; i++) {
						targetData = targetData.replaceAll(inAppDataObj[i][0], inAppDataObj[i][1]);

					}
				
					jQuery('#dvInAppPreview').html(targetData); //only this line updated
				});
			});
            //end -new added code

        </script>	

</body>

</html>