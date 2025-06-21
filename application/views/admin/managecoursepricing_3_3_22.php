
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
                                        
                                        <li class="breadcrumb-item active">Manage Course Details</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
		<?php include("error_message.php");?>				
    <div class="row">
        <div class="col-8">
            <div class="page-title-box">
                <h4 class="page-title">Manage Course Details</h4>
            </div>
        </div>
		<div class="col-md-4">

                                <div class="form-group mb-3">
								<form action="<?php echo base_url(); ?>admin/managecoursepricing" method="post" class="" >
                                    <div class="input-group">
                                        <label for="txtGst" class="GSTper">GST Percentage</label>
                                        <input type="text" class="form-control autonumber" name="gst_value" id="txtGst"
                                            placeholder="GST Percent" aria-label="GST Percent" value="<?php echo $result[0]->ss_aw_gst_rate; ?>" data-a-sign="%"
                                            data-p-sign="s">

                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light"
                                                type="submit">Update</button>
                                        </div>
                                    </div>
									</form>
                                </div>


                            </div>
		
    </div>     
    <!-- end page title --> 

    <div class="row">
        <?php
        foreach ($result as $value) {
            $form_id =1;
         ?>

        <div class="col-lg-4">
            <div class="managecoursepricing card-box">
                <ul class="sortable-list tasklist list-unstyled" id="upcoming">
                    <li id="task1">
                        <h5 class="mt-0"><label class="text-success"><?php echo $value->ss_aw_course_name; ?></label></h5>
                    </li>
                </ul>
                <form action="<?php echo base_url(); ?>admin/managecoursepricing" method="post" class="" id="price_form<?php echo $form_id; ?>">
                  <div class="row">
                    <div class="col-md-6">
				  <div class="form-group">
                         <label for="example-select">Currency</label>
                         
                           <select name="course_currency" class="form-control" id="">
                            <?php
                            foreach ($curerncy as $row) {
                            ?>
                            <option <?php if($value->ss_aw_course_currency==$row->ss_aw_currency_title) {echo 'selected'; } ?> >
                                <?php echo $row->ss_aw_currency_title; ?>

                            </option>
                            <?php
                             } 
                            ?>
                           
                           </select>
                    </div>
				</div>
				<div class="col-md-6">
                    <div class="form-group">
                        <label for="simpleinput">Price</label>
                        <input type="text" placeholder=""  class="form-control autonumber" name="course_price" value="<?php echo $value->ss_aw_course_price; ?>">
                        <input type="hidden" name="course_id" value="<?php echo $value->ss_aw_course_id;?>">
                        <input type="hidden" name="update_course_price" value="update_course_price">
                    </div>
				</div>	
				</div>	
				
				<div class="form-group mb-3">
                                            <label for="">Short Description</label>
                                            <input type="text" placeholder="" value="<?php echo $value->ss_aw_sort_description;?>" name="sort_desc" class="form-control" >
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Long Description</label>
                                            <textarea class="form-control" id="" name="long_desc" rows="5" ><?php echo $value->ss_aw_long_description;?></textarea>
                                        </div>
                <button type="button" data-toggle="modal" data-target="#warning-status-modal_<?php echo $value->ss_aw_course_id;?>" class="btn btn-success btn-block mt-3 waves-effect waves-light"><i class="mdi mdi-check"></i>Update</button>
                
            </div>
        </div> <!-- end col -->


		<div id="warning-status-modal_<?php echo $value->ss_aw_course_id;?>" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Are you sure you want to update the <?php echo $value->ss_aw_course_name; ?>?</p>
                                        <div class="button-list">
                                            

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
       <?php
       $form_id++;
        }
        ?>

       

    </div>
    <!-- end row -->
    
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
        <!-- END wrapper -->

        
        <?php
            include('footer.php')
        ?>
 <style type="text/css">
            .GSTper{
                padding: 6px 10px 0px 20px;
            }
        </style>       

</body>
</html>