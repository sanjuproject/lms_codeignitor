

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
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/managecoupons">Manage Coupon</a></li>
                                    <li class="breadcrumb-item active">Add Coupon</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="page-title">Add Coupon</h4>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php include("error_message.php");?>
                    <div class="row mt-2">
                    
                    <div class="col-lg-6">

                    <form method="post" action="<?= base_url(); ?>admin/add_coupon" id="demo-form" data-parsley-validate="">
                            <div class="card-box card-layout">
                                <div class="form-row">

                                <div class="form-group col-md-6">

                                                <label>Target Audience<span class="text-danger">*</span></label>

                                                <div class="terget-audience-radio">
                                               <div class="radio radio-primary mr-2">
                                                <input type="radio" name="member" id="Existing" value="1"  data-parsley-multiple="member">
                                                <label for="Existing">
                                                Existing
                                                </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input type="radio" name="member" id="New" value="2" required data-parsley-multiple="member">
                                                <label for="New">
                                                   New
                                                </label>
                                            </div>
                                                </div>
                                                
                                            

                                            </div>

                                <div class="form-group col-md-6">
                                                <label for="coupon_code">Coupon Code<span
                                                        class="text-danger">*</span></label>
                                                        <input name="coupon_code" class="form-control" type="text" id="coupon_code" placeholder="Coupon Code" required style="text-transform: uppercase;">
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div> 
                                 </div>
                            
          
                                            <div class="form-row">
                                           <div class="form-group col-md-6">
                                           <label>Start Date<span class="text-danger">*</span></label>
                                           <input name="start_date" type="text" class="form-control" placeholder="Start Date" id="startDate" required>
                                           <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                           </div>
                                           <div class="form-group col-md-6">
                                           <label>End Date<span class="text-danger">*</span></label>
                                           <input name="end_date" type="text" class="form-control" id="endDate" placeholder="End Date" required>
                                           <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                           </div>
                                            </div>
                                        

                                           <div class="form-row">

                                              <div class="form-group col-md-5">
                                              <label>Discount<span class="text-danger">*</span></label>
                                                        <input name="discount" class="form-control" type="number" id="discount" placeholder="Discount" required>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div> 
                                          
                                           <div class="form-group col-md-1 pt-1">
                                           <label><span class="text-danger"></span></label>
                                           <input name="percentage" class="form-control percentage-control" type="text" id="percentage" placeholder="%" disabled>
                                           </div>
                                           <div class="form-group col-md-6">
                                           <label>Executing Date in a month<span class="text-danger">*</span></label>
                                           <select name="executing_day" id="executing_day" class="form-control">
                                           <option value="">Date in a month</option>
                                               <option value="1">1</option>
                                               <option value="2">2</option>
                                               <option value="3">3</option>
                                               <option value="4">4</option>
                                               <option value="5">5</option>
                                               <option value="6">6</option>
                                               <option value="7">7</option>
                                               <option value="8">8</option>
                                               <option value="9">9</option>
                                               <option value="10">10</option>
                                               <option value="11">11</option>
                                               <option value="12">12</option>
                                               <option value="13">13</option>
                                               <option value="14">14</option>
                                               <option value="15">15</option>
                                               <option value="16">16</option>
                                               <option value="17">17</option>
                                               <option value="18">18</option>
                                               <option value="19">19</option>
                                               <option value="20">20</option>
                                               <option value="21">21</option>
                                               <option value="22">22</option>
                                               <option value="23">23</option>
                                               <option value="24">24</option>
                                               <option value="25">25</option>
                                               <option value="26">26</option>
                                               <option value="27">27</option>
                                               <option value="28">28</option>
                                               <option value="29">29</option>
                                               <option value="30">30</option>
                                           </select>
                                           </div>
                                         
                                           </div>

                                           <div class="form-group">
                                          
                                           <div class="comment-area-btn custom-comment-area-btn">
                                           <label>Template<span class="text-danger">*</span></label>
                                                <div class="float-right">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle mb-1"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Dynamic code<i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dynamicTags dropdown-menu" id="coupondrpDynamicTags">
                                                            <?php
                                                            if (!empty($notification_param)) {
                                                                foreach ($notification_param as $key => $value) {
                                                                    ?>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                data-value="<?= $value->param_value; ?>"><?= $value->param_name; ?></a>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                           
                                                <textarea name="template" rows="3" id="txtTemplate" required class="form-control" placeholder="Write something..."></textarea>
                                              </div>
                                              </div>
                                              <div class="form-group">

                                                    <div class="custom-control custom-switch custom-switch-with">
                                                        <input name="mark_as_default" type="checkbox" class="custom-control-input" id="customSwitch2">
                                                        <label class="custom-control-label" for="customSwitch2">Mark as default</label>
                                                        
                                                    </div>
                                              </div>
                                            <div class="form-group">
                                            <button class="btn btn-success waves-effect waves-light mr-2"
                                            type="submit">Save</button>
                                            <a class="btn btn-danger waves-effect waves-light" href="<?= base_url(); ?>admin/managecoupons">Cancel</a>
                                            </div>

                                   
                                </div>
</form>

                            </div> <!-- end col -->
                    
                           
                    
                    
                    
                    </div> 

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php
include 'includes/bottombar.php';
?>

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->


     

        <?php
include 'footer.php'
?>
 <!-- Table Editable plugin-->
 <script src="<?= base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
 <!-- Init js-->
 <script src="<?= base_url(); ?>assets/js/pages/create-project.init.js"></script>
  <!-- Plugin js-->
  <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>
   <!-- Validation init js-->
   <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>

   <script>
        jQuery(function() {


            jQuery('#coupondrpDynamicTags a').on('click', function() {
                myValue = jQuery(this).data('value');
                var cursorPos = jQuery('#txtTemplate').prop('selectionStart');
                var v = jQuery('#txtTemplate').val();
                var textBefore = v.substring(0, cursorPos);
                var textAfter = v.substring(cursorPos, v.length);
                jQuery('#txtTemplate').val(textBefore + myValue + textAfter);
            });

            /* new code */
            let startDateSelected;
            let endDateSelected;
            let isDefaultSelected = false;
            let startDatePicker = jQuery('#startDate').flatpickr({
                minDate: "today",
                dateFormat: "F d, Y",
                onChange: function(selectedDates) {
                isDefaultSelected = jQuery('#customSwitch2').is(':checked') ? true : false;
                startDateSelected = selectedDates[0];
                    if(isDefaultSelected){
                        endDateSelected = startDateSelected;
                        endDatePicker.setDate(add_years(endDateSelected, 99));
                        jQuery('#endDate').attr('disabled','disabled').addClass('disabledInput');
                        $("#executing_day").attr('required', true);
                    }else{
                        jQuery('#endDate').removeAttr('disabled').removeClass('disabledInput');
                        endDatePicker.set("minDate",startDateSelected);
                        $("#executing_day").attr('required', false);
                    }
                },
            });
            
            let endDatePicker = jQuery('#endDate').flatpickr({
                dateFormat: "F d, Y",  
            });

            jQuery('#customSwitch2').click(function(){
                isDefaultSelected = jQuery(this).is(':checked') ? true : false;
                if(!isDefaultSelected){
                    jQuery('#endDate').removeAttr('disabled').removeClass('disabledInput');
                    endDatePicker.setDate('today');
                    $("#executing_day").attr('required', false);
                }else if(startDateSelected != null){
                    endDatePicker.setDate(add_years(startDateSelected, 99));
                    jQuery('#endDate').attr('disabled','disabled').addClass('disabledInput');
                    $("#executing_day").attr('required', true);
                }
            });
            
        });

        function add_years(dt,n) 
        {   let dt2 = dt;
            return new Date(dt2.setFullYear(dt2.getFullYear() + n));      
        }

        jQuery('input#coupon_code').keyup(function() {
            if (this.value.match(/[^a-zA-Z0-9]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
            }
        });
        /*function check_default(){
            if (jQuery("input[name='mark_as_default']").prop('checked') == true) {
                $("#executing_day").attr('required', true);
            }
            else
            {
                $("#executing_day").attr('required', false);
            }
        }*/
        </script>


</body>
</html>