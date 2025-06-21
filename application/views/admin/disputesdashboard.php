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
                            <!-- <li class="breadcrumb-item">Disputes Dashboard</li>
                            <li class="breadcrumb-item active">List of Disputes</li> -->
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <h4 class="page-title">LIST OF DISPUTES</h4>
                </div>

            



            </div>
            <!-- end page title -->

<?php include("error_message.php");?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-sm-4">

                                </div>
                                <div class="col-sm-8">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url();?>disputesdashboard/index" id="updateticket_form" method="post">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group mb-3">
													</div>
												</div>	
												<div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <div class="input-group">
													
                                                            <select class="form-control adminusersbottomdropdown" name="type" id="drpType" onchange="filtertype();">
                                                                <option value="" select>Type</option>
                                                                <option value="1" <?php if($searchtype == 1){?>selected <?php } ?>>Sales</option>
																<option value="2" <?php if($searchtype == 2){?>selected <?php } ?>>Courses</option>
                                                                <option value="3" <?php if($searchtype == 3){?>selected <?php } ?>>Payments</option>
																<option value="4" <?php if($searchtype == 4){?>selected <?php } ?>>Others</option>
                                                            </select>
														
                                                        </div>
                                                    </div>
                                                </div>
												
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <div class="input-group">
													
                                                            <select class="form-control adminusersbottomdropdown" name="status" id="drpStatus" onchange="filterstatus();">
                                                                <option value="" select>Status</option>
                                                                <option value="2" <?php if($searchstatus == 2){?>selected <?php } ?>>Open</option>
																<option value="3" <?php if($searchstatus == 3){?>selected <?php } ?>>Pending</option>
                                                                <option value="4" <?php if($searchstatus == 4){?>selected <?php } ?>>Resolved</option>
																<option value="5" <?php if($searchstatus == 5){?>selected <?php } ?>>Closed</option>
                                                            </select>
														
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

                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                    data-show-columns="true">
                                    <thead class="thead-light">
                                        <tr>
                                            
                                            <th>Ticket ID</th>
                                            <th>Type</th>
                                            <th>Sub Type</th>
                                            <th>Subject</th>
                                            <th>User Name</th>
                                            <th>C.Date</th>
                                            <th>T.Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>


                                    <tbody>
									<?php
									foreach($result as $value){
										if($value['status'] == 2)
										{
											$status = "Open";
										}
										else if($value['status'] == 3)
										{
											$status = "Pending";
										}
										else if($value['status'] == 4)
										{
											$status = "Resolved";
										}
										else if($value['status'] == 5)
										{
											$status = "Closed";
										}
										
									?>
                                        <tr>
                                            
                                            <td><?php echo $value['ticket_id']; ?></td>
                                            <td><?php echo $value['type']; ?></td>
                                            <td><?php echo $value['sub_type']; ?></td>
                                            <td><a class="link" href="<?php echo base_url();?>disputesdashboard/disputedetails/<?php echo base64_encode($value['ticket_id']);?>"><?php echo $value['subject'];?></a></td>
                                            <td><?php echo $value['sender_name']; ?></td>
                                            <td><?php echo date('d M,Y',strtotime($value['create_date']));?></td>
                                            <td>
                                                <?php
                                                if($status=='Open')
                                                {
                                                    $staus_class = 'badge-soft-success';
                                                }
                                                elseif ($status=='Closed') {
                                                     $staus_class = 'badge-soft-dark';
                                                 } 
                                                 elseif ($status=='Pending') {
                                                     $staus_class = 'badge-soft-danger';
                                                 }
                                                 elseif ($status=='Resolved') {
                                                     $staus_class = 'badge-soft-warning';
                                                 }
                                                 else{
                                                    $staus_class = 'badge-soft-success';
                                                 } 
                                                ?>
                                                <a href="#" class="badge <?php echo $staus_class; ?>"
                                                    title="Make Inactive" ><?php echo $status;?></a>
                                            </td>
                                            <td>
                                                
                                                <a href="javascript:void(0);" class="action-icon" onclick="setdeleteticket(<?php echo $value['ticket_id'];?>);"
                                                    data-toggle="modal" data-target="#warning-delete-modal"
                                                    title="Delete"> <i class="mdi mdi-delete"></i></a>
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
                                    <button type="button" class="btn btn-danger"
                                        data-dismiss="modal">Yes</button>
                                    <button type="button" class="btn btn-success"
                                        data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <!-- Delete confirmation dialog -->
            <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog"
                aria-modal="true">
				<form action="<?php echo base_url();?>disputesdashboard/deleteticket" id="deleteticket_form" method="post">
				<input type="hidden" name="ticket_id" id="ticket_id"/>
				</form>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">Deleting will remove this ticket from the system. Are you
                                    sure ?
                                </p>
                                <div class="button-list">
                                    <button type="button" onclick="deleteticket();" class="btn btn-danger"
                                        data-dismiss="modal">Yes</button>
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
        include('bottombar.php');
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
</style>	
    <!-- END wrapper -->
     <?php
            include('footer.php')
        ?>
  <script>
jQuery(function() {
    jQuery('#btnClearFilter').click(function() {
        jQuery('#txtFilter').val('');
        jQuery('#drpStatus').prop('selectedIndex', 0);
		jQuery('#drpType').prop('selectedIndex', 0);
		$("#updateticket_form").submit();
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
function deleteticket()
{
	$("#deleteticket_form").submit();
}
function setdeleteticket(ticket_id)
{
	$("#ticket_id").val(ticket_id);
}
function filterstatus()
{
	$("#updateticket_form").submit();
}
function filtertype()
{
	$("#updateticket_form").submit();
}
</script>

</body>

</html>