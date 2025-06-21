 <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
						<?php include("error_message.php");?>
                            <div class="col-12 managedisputesviewreply">
                                <div class="page-title-box col-md-4">
                                    <div class="page-title-left">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><h4>Manage Disputes</h4></a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><h4>View & Reply</h4></a></li>
                                            <!-- <li class="breadcrumb-item active">Shopping Cart</li> -->
                                        </ol>
                                    </div>
                                    <!-- <h4 class="page-title">List of FAQs</h4> -->
									
                                </div>
                            <?php if($result['status'] == 2 || $result['status'] == 3 || $result['status'] == 4) { ?>    
								<div class="col-md-8 text-right">
                                    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#warning-delete-modal" ><i class="mdi mdi-plus-circle mr-2"></i>Request for Closing</a>
                                </div>
                            <?php } ?>    
                            </div>
                        </div>
                        <!-- end page title -->


                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                
                                        <div class="table-responsive managedisputesviewreplytable">
                                            <table class="table table-centered table-nowrap mb-0">
                                            <thead>
                                                    <tr>
                                                        <th class="table-warning">Ticket ID</th>
                                                        <th class="table-info"><?php echo $result['ticket_id'];?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="table-warning">T. Status </td>
										<?php
										if($result['status'] == 2)
										{
											$status = "Open";
										}
										else if($result['status'] == 3)
										{
											$status = "Pending";
										}
										else if($result['status'] == 4)
										{
											$status = "Resolved";
										}
										else if($result['status'] == 5)
										{
											$status = "Closed";
										}
										?>
                                                        <td class="table-info"><?php echo $status;?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-warning">User </td>
                                                        <td class="table-info"><?php echo $result['sender_email'];?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-warning">Type </td>
                                                        <td class="table-info"><?php echo $result['type'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-warning">Sub Type</td>
                                                        <td class="table-info"><?php echo $result['sub_type'];?></td>
                                                    </tr>
													<tr>
                                                        <td class="table-warning">Subject</td>
                                                        <td class="table-info"><?php echo $result['subject'];?></td>
                                                    </tr>
													<!-- <tr>
                                                        <td class="table-warning">Description</td>
                                                        <td class="table-info"><?php echo $result['description'];?></td>
                                                    </tr> -->
                                                    <tr>
                                                        <td class="table-warning">Created</td>
                                                        <td class="table-info"><?php echo date('d M, Y H:i:s',strtotime($result['create_date']));?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-warning">Last Updated</td>
                                                        <td class="table-info"><?php echo date('d M, Y H:i:s',strtotime($result['update_date']));?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <div class="managedisputesprofileimg">
                                        <div class="userdetails">
                                    <div>
                                            <div class="text-center">
                                                <img src="<?php echo $result['profile_photo'];?>" class="img-fluid rounded-circle avatar-lg" alt="user-img">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h5 class="mb-1 mt-2 font-16 text-center"><?php echo $result['parent_full_name'];?></h5>
                                            <p class="mb-2 text-muted text-center">Parent User</p>
                                        </div>
                                        </div>
                                    </div>
                                       

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            <div class="col-lg-8">
                            <div class="card managedisputesviewreplychat">
                                <div class="row">
                                    <div class="col">
                                        <div class=" bg-light p-3">
                                            <p class="m-0 h5"><?php echo $result['description'];?></p>            
                                        </div>
                                    </div>
                                </div>
                                    <div class="card-body">
                                        <ul class="conversation-list" data-simplebar style="max-height: 460px">
                                          <?php	foreach($conversession as $value){?>										  
                                            <li class="clearfix <?php echo $value['view'];?>">
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <i><?php echo $value['user_name'];?> </i>
                                                        <p>
                                                        <?php echo $value['body_text'];?> 
                                                        </p>
                                                        <i class="mdi mdi-calendar-clock"><?php echo $value['create_date'];?> </i>
                                                    </div>
                                                </div>
                                                
                                            </li>
										  <?php } ?>   
                                        </ul>
									<?php if($result['status'] == 2 || $result['status'] == 3) { ?>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mt-2 bg-light p-3 rounded">
                                                    <form class="needs-validation" method="post" novalidate="" action="<?php echo base_url();?>disputesdashboard/postreply" name="chat-form" id="chat-form">
                                                        <input type="hidden" value="<?php echo $result['ticket_id'];?>" name="ticket_id" />
                                                        <input type="hidden" name="subject" value="<?= $result['subject']; ?>">
                                                        <input type="hidden" name="device_token" value="<?= $result['parent_device_token']; ?>">
                                                        <input type="hidden" name="parent_id" value="<?= $result['parent_id']; ?>">
														<div class="row">
                                                            <div class="col mb-2 mb-sm-0">
                                                                <input type="text" class="form-control border-0" name="message" placeholder="Enter your text" required="">
                                                                <div class="invalid-feedback">
                                                                    Please enter your messsage
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-auto">
                                                                <div class="btn-group">
                                                                    <!-- <a href="#" class="btn btn-light"><i class="fe-paperclip"></i></a> -->
                                                                    <button type="submit" class="btn btn-success chat-send btn-block"><i class='fe-send'></i></button>
                                                                </div>
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row-->
                                                    </form>
                                                </div> 
                                            </div> <!-- end col-->
									</div> <?php } ?>
                                        <!-- end row -->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div>
                        </div>
                        <!-- end row -->
                        

                    </div> <!-- container -->

                </div> <!-- content -->
				
				<!-- Delete confirmation dialog -->
            <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                aria-modal="true">
				<form action="<?php echo base_url();?>disputesdashboard/updateticketstatus" id="deleteticket_form" method="post">
				<input type="hidden" name="ticket_id" value="<?php echo $result['ticket_id'];?>" id="ticket_id"/>
				</form>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">This action close the ticket. Are you
                                    sure ?
                                </p>
                                <div class="button-list">
                                    <button type="button" onclick="updateticketstatus();" class="btn btn-danger"
                                        data-dismiss="modal">Yes</button>
                                    <button type="button" class="btn btn-success"
                                        data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

                <?php
include 'bottombar.php';
?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
</div>
    <!-- END wrapper -->

    <style type="text/css">
    .card-box {
        border: 1px solid #ced4da;
    }

    .ticket-details {}

    .ticket-item {
        border-bottom: 1px solid #ced4da;
        display: flex;
    }

    .ticket-item-left {
        width: 40%;
        background-color: #b1f9eb;
        height: 40px;
        line-height: 40px;
        padding: 0px 10px;
    }

    .ticket-item-left p {
        color: #6e768e;
        margin: 0px;
    }

    .ticket-item-right {
        width: 60%;
        background-color: #fef5e4;
        height: 40px;
        line-height: 40px;
        padding: 0px 10px;
    }

    .ticket-item-right p {
        color: #6e768e;
        margin: 0px;
    }

    .user-photo {
        text-align: center;
        padding: 20px;
    }

    .image-view {
        width: 100px;
        height: 100px;
        border: 2px solid #dee2e6;
        border-radius: 50px;
        margin: auto;
    }

    .image-view img {
        width: 100%;
        height: 100%;
        border-radius: 50px;
    }

    .user-photo p {
        color: #66479b;
        font-weight: bold;
        padding-top: 10px;
    }

    .conversation-list .confirm .ctext-wrap {
        background-color: #b1f9eb;
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
            jQuery('#drpStatus').prop('selectedIndex', 0);
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
function updateticketstatus()
{
	$("#deleteticket_form").submit();
}	
	
    </script>

</body>

</html>			