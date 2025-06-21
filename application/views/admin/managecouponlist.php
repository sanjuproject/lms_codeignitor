
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
                                <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/managecoupons"> Coupon Management </a></li>
                                    <li class="breadcrumb-item active">List of Coupon</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <?php include("error_message.php");?>
                    <div class="row">
                        <div class="col-6">
                            <div class="page-title-box">
                                <h4 class="page-title">Manage Coupon</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="footerformView float-right mt-3 mr-2">
                                <form>
                                    <div class="row content-right">
                                        <div>
                                        <select class="form-control topselectdropdown" onchange="dofunctions(this.value);" id="drpMultipleCta">                                    
                                            <option value="" >Please Select</option>
                                            <!-- <option value="2">Add Coupon</option> -->
                                            <option value="1">Delete All</option>
                                        </select>
                                        </div>

                                        <div class="pl-2">
                                            <button type="reset" class="btn btn-primary waves-effect waves-light btn-xs resetBtn" id="btnAudio1"><i class="mdi mdi-refresh"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
             
                    <!-- end page title -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2 managecouponlistofcouponsearch">
                                        <div class="col-sm-2">

                                            <a href="<?= base_url(); ?>admin/add_coupon" class="btn btn-danger mb-2"><i
                                                    class="mdi mdi-plus-circle mr-2"></i>Add Coupon</a>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="text-sm-right">
                                                <form method="post" action="<?= base_url(); ?>admin/managecoupons" id="demo-form" onsubmit="return searchValidation();">
                                                    <div class="coupon-from-section">
                                                    <div class="form-group mb-3 mr-1">
                                                        <div class="input-group">
                                                            <input name="coupon_code" type="text" class="form-control" placeholder="Coupon Code" aria-label="Title" <?php if(!empty($search_data['coupon_code'])){ ?> value="<?= $search_data['coupon_code']; ?>" <?php } ?>>
                                                        </div>
                                                    </div>

                                                            <div class="form-group mb-3 mr-1">
                                                            <input id="search_start_date" name="start_date" type="text" class="form-control" data-toggle="flatpicker" placeholder="Start Date" <?php if(!empty($search_data['start_date'])){ ?> value="<?= $search_data['start_date']; ?>" <?php } ?>>
                                                            <span style="color: red;" id="search_start_date_error"></span>
                                                            </div>

                                                            <div class="form-group mb-3 mr-1">
                                                            <input id="search_end_date" name="end_date" type="text" class="form-control" data-toggle="flatpicker" placeholder="End Date" <?php if(!empty($search_data['end_date'])){ ?> value="<?= $search_data['end_date']; ?>" <?php } ?>>
                                                            <span style="color: red;" id="search_end_date_error"></span>
                                                            </div>

                                                            <div class="apend-goBtn mr-1">
                                                            <div class="input-group-append">
                                                                        <button
                                                                            class="btn btn-primary waves-effect waves-light"
                                                                            type="submit">Go</button>
                                                                    </div>
                                                            </div>

                                                    </div>
                                                       
                                                       
                                                       
                                                      
                                                  
                                                
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck">
                                                            <label class="custom-control-label"
                                                                for="customCheck">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Coupon ID</th>
                                                    <th>Coupon Type</th>
                                                    <th>Coupon Code</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Last send on</th>
                                                    <th>Target Audience</th>
                                                    <th>Default</th>
                                                    <th class="actioncol">Action</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                if (!empty($result)) {
                                                    foreach ($result as $key => $value) {
                                                        ?>
                                                        <tr <?php if($value->ss_aw_default == 1){ ?> class="default-rowcolor" <?php } ?>>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input multideletecheckbox" id="customCheck<?= $value->ss_aw_id; ?>" value="<?= $value->ss_aw_id; ?>">
                                                                    <label class="custom-control-label"
                                                                        for="customCheck<?= $value->ss_aw_id; ?>"></label>
                                                                </div>
                                                            </td>
                                                            <td><?= $value->ss_aw_id; ?></td>
                                                            <td><?= $value->ss_aw_coupon_type == 1 ? "Lumpsum" : "EMI"; ?></td>
                                                            <td><?= $value->ss_coupon_code; ?></td>
                                                            <td><?= date('d/m/Y', strtotime($value->ss_aw_start_date)); ?></td>
                                                            <td><?= date('d/m/Y', strtotime($value->ss_aw_end_date)); ?></td>
                                                            <td>Not Yet Send</td>
                                                            <td class="targetaudience">
                                                                <?php
                                                                if ($value->ss_aw_target_audience == 1) {
                                                                    echo "Existing Users";
                                                                }
                                                                elseif ($value->ss_aw_target_audience == 2) {
                                                                    echo "New Users";
                                                                }
                                                                else{
                                                                    echo "All Users";
                                                                }
                                                                ?>
                                                                
                                                            </td>

                                                            <?php
                                                            if ($value->ss_aw_default == 1) {
                                                                ?>
                                                                <td class="check-default">
                                                                    <i class="mdi mdi-check"></i>
                                                                </td>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <td></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td class="actioncell">
                                                            <a onclick="get_coupon(<?= $value->ss_aw_id; ?>)" href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#modal-link"> <i
                                                                        class="mdi mdi-arrange-send-backward"></i></a>
                                                                <a href="<?= base_url(); ?>admin/edit_coupon/<?= $value->ss_aw_id; ?>" class="action-icon"> <i
                                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                                <a onclick="set_delete_value(<?= $value->ss_aw_id; ?>)" href="javascript:void(0);" class="action-icon"
                                                                    data-toggle="modal" data-target="#warning-delete-modal"> <i
                                                                        class="mdi mdi-delete"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                    <tr>
                                                        <td colspan="10">No record found.</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                
                                            </tbody>

                                        </table>
                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->
                    <div class="row">
                        <div class="col-12">
                            <div class="text-right">
                                <?php foreach ($links as $link) {
                                    echo "<li>". $link."</li>";
                                    } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

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
                                <p class="mt-3">Deleting will remove this coupon from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form id="record_remove_form" method="post" action="<?= base_url(); ?>admin/remove_coupon">
                                        <input type="hidden" name="delete_record_id" id="delete_record_id">
                                        <input type="hidden" name="remove_type" id="remove_type" value="single">
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

            <!-- Delete confirmation dialog -->
            <div id="alert-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">Please select atleast one record to perform the operation.</p>
                                <div class="button-list">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!--Status update confirmation dialog -->
       

             <!-- Modal -->
             <div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Create Coupon</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-4">
                                 
                                <form action="<?= base_url(); ?>admin/copy_coupon" method="post" id="demo-form">

                                <div class="form-row">

                                <div class="form-group col-md-6">

                                                <label>Target Audience<span class="text-danger">*</span></label>

                                                <div class="terget-audience-radio">
                                               <div class="radio radio-primary mr-2">
                                                <input type="radio" name="member" id="existing" value="1" required="" data-parsley-multiple="member" disabled>
                                                <label for="existing">
                                                Existing
                                                </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <input type="radio" name="member" id="new" value="2" data-parsley-multiple="member" disabled>
                                                <label for="new">
                                                   New
                                                </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                    <input type="radio" name="member" id="all" value="3" required data-parsley-multiple="member" disabled>
                                                    <label for="All">
                                                       All
                                                    </label>
                                                </div>
                                                </div>
                                                
                                            

                                            </div>

                                <input type="hidden" name="audience_type" id="audience_type" value="">            
                                <div class="form-group col-md-6">
                                                <label for="title">Coupon Code<span
                                                        class="text-danger">*</span></label>
                                                        <input name="coupon_code" class="form-control" type="text" id="coupon_code" placeholder="Coupon Code" required value="" readonly>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div> 
                                 </div>

                                 <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="coupon_type">Coupon Type</label>
                                                <select name="coupon_type" id="coupon_type" class="form-control">
                                                    <option value="1">LUMPSUM</option>
                                                    <option value="2">EMI</option>
                                                </select>
                                            </div>
                                        </div>
                            
          
                                            <div class="form-row">
                                           <div class="form-group col-md-6">
                                           <label>Start Date<span class="text-danger">*</span></label>
                                           <input name="start_date" type="text" class="form-control" placeholder="Start Date" id="start_date" required>
                                           <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                           </div>
                                           <div class="form-group col-md-6">
                                           <label>End Date<span class="text-danger">*</span></label>
                                           <input name="end_date" type="text" class="form-control" id="end_date" placeholder="End Date" required>
                                           <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                           </div>
                                            </div>
                                        

                                           <div class="form-row">

                                              <div class="form-group col-md-4">
                                              <label>Discount<span class="text-danger">*</span></label>
                                                        <input name="discount" class="form-control" type="number" id="discount" placeholder="Discount" required readonly>
                       
                                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                            </div> 
                                          
                                           <div class="form-group col-md-2 pt-1">
                                           <label><span class="text-danger"></span></label>
                                           <input name="percentage" class="form-control" type="text" id="percentage" placeholder="%" required readonly>
                                           </div>
                                           <!-- <div class="form-group col-md-6">
                                           <label>Executing Date in a month<span class="text-danger">*</span></label>
                                           <select name="executing_day" id="executing_day" class="form-control" readonly>
                                           <option value="0">Date in a month</option>
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
                                           </div> -->
                                         
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
                                                        <div class="dynamicTags dropdown-menu" id="drpDynamicTags2">
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
                                           <textarea name="template" rows="3" class="form-control" placeholder="Write something..." id="template"
                                                value="n App Message for Signup confirmation" readonly></textarea>
                                              </div>
                                              </div>

                                              <div class="form-group">

                                                    <div class="custom-control custom-switch custom-switch-with">
                                                        <input name="use_institution" type="checkbox" class="custom-control-input" id="use_institution">
                                                        <label class="custom-control-label" for="use_institution">Only use for institution</label>
                                                        
                                                    </div>
                                              </div>
                                           
                                            <div class="form-group">
                                            <button class="btn btn-success waves-effect waves-light mr-2"
                                            type="submit">Save</button>
                                            <button class="btn btn-danger waves-effect waves-light"
                                            type="button" data-dismiss="modal"
                                        aria-hidden="true">Cancel</button>
                                            </div>

                                   
                            
</form>
                                    </div> <!-- end card-body-->

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal --> 
            <?php  include 'includes/bottombar.php'; ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <!-- Modal -->
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Coupon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <form action="#" class="parsley-examples" id="demo-form">


                        <div class="text-right">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10"
                                onclick="Custombox.close();">Cancel</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    


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



    <?php
include 'footer.php'
?>

 <!-- Table Editable plugin-->
 <script src="<?= base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

<!-- Table editable init-->
<!-- <script src="./assets/js/pages/tabledit.init.js"></script> -->
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>


 <!-- Init js-->
 <script src="<?= base_url(); ?>assets/js/pages/create-project.init.js"></script>

    <script>

    $("#customCheck").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    function searchValidation(){
        var start_date = $("#search_start_date").val();
        var end_date = $("#search_end_date").val();
        if (start_date != "" || end_date != "") {
            if (start_date != "") {
                if (end_date == "") {
                    $("#search_end_date_error").html("*Please select end date.");
                    return false;
                }
                else
                {
                    $("#search_end_date_error").html("");
                    return true;
                }
            }
            else if(end_date != ""){
                if (start_date == "") {
                    $("#search_start_date_error").html("*Please select end date.");
                    return false;
                }
                else
                {
                    $("#search_start_date_error").html("");
                    return true;
                }
            }
        }
        else{
            return true;
        }
    }

    function dofunctions(value){
        var checkedRecord = [];
        if (value != "") {
            if (value == 1) {
                $(".multideletecheckbox:checked").each(function(){
                    checkedRecord.push($(this).val());
                });

                if (checkedRecord.length > 0) {
                    var checkedRecordString = checkedRecord.toString();
                    $("#delete_record_id").val(checkedRecordString);
                    $("#remove_type").val('multiple');
                    $("#warning-delete-modal").modal('toggle');
                }
                else
                {
                    $("#alert-modal").modal('toggle');
                }
            }
        }
    }    

    function set_delete_value(coupon_id){
        $("#remove_type").val('single');
        $("#delete_record_id").val(coupon_id);
    }   

    function get_coupon(coupon_id){

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/get_coupon_detail",
            data: {coupon_id:coupon_id},
            dataType: "JSON",
            success: function(result){
                //if (result.length > 0) {
                    $("#audience_type").val(result.target_audience);
                    if(result.target_audience == 1){
                        $("#existing").attr('checked', true);
                    }
                    else if(result.target_audience == 2){
                        $("#new").attr('checked', true);
                    }
                    else
                    {
                        $("#all").attr('checked', true);
                    }

                    $("#coupon_code").val(result.coupon_code);
                    $("#coupon_type").val(result.coupon_type);
                    $("#discount").val(result.discount);
                    if (result.use_institution == 1) {
                        $("#use_institution").attr('checked', true);
                    }
                    else{
                        $("#use_institution").attr('checked', false);
                    }
                    //$("#executing_day").val(result.executing_day);
                    $("textarea[name='template']").val(result.template);

                    let startDatePicker = jQuery('#start_date').flatpickr({
                        dateFormat: "F d, Y",  
                    });

                    let endDatePicker = jQuery('#end_date').flatpickr({
                        dateFormat: "F d, Y",  
                    });

                    startDatePicker.setDate(result.start_date);
                    endDatePicker.setDate(result.end_date);
                //}
            }
        });
    }

    function myFunction() {
        var checkBox1 = document.getElementById("checkbox1");
        var checkBox2 = document.getElementById("checkbox2");
        var checkBox3 = document.getElementById("checkbox3");
        var checkBox4 = document.getElementById("checkbox4");
        var text1 = document.getElementById("box1");
        var text2 = document.getElementById("box2");
        var text3 = document.getElementById("box3");
        var text4 = document.getElementById("box4");
        var element1 = document.getElementById("add1");
        var element2 = document.getElementById("add2");
        var element3 = document.getElementById("add3");
        var element4 = document.getElementById("add4");
        if (checkBox1.checked == true) {
            checkBox2.checked == false;
            checkBox3.checked == false;
            checkBox4.checked == false;
            text1.style.display = "flex";
            text2.style.display = "none";
            text3.style.display = "none";
            text4.style.display = "none";
            element1.classList.add("custom-checkboxView");
            element2.classList.remove("custom-checkboxView");
            element3.classList.remove("custom-checkboxView");
            element4.classList.remove("custom-checkboxView");
        } else {
            text1.style.display = "none";
            element1.classList.remove("custom-checkboxView");
        }
    }

    function ManageCourseContents() {
        var checkBox1 = document.getElementById("checkbox1");
        var checkBox2 = document.getElementById("checkbox2");
        var checkBox3 = document.getElementById("checkbox3");
        var checkBox4 = document.getElementById("checkbox4");
        var text1 = document.getElementById("box1");
        var text2 = document.getElementById("box2");
        var text3 = document.getElementById("box3");
        var text4 = document.getElementById("box4");
        var element1 = document.getElementById("add1");
        var element2 = document.getElementById("add2");
        var element3 = document.getElementById("add3");
        var element4 = document.getElementById("add4");
        if (checkBox2.checked == true) {
            checkBox1.checked == false;
            checkBox3.checked == false;
            checkBox4.checked == false;
            text2.style.display = "flex";
            text1.style.display = "none";
            text3.style.display = "none";
            text4.style.display = "none";
            element2.classList.add("custom-checkboxView");
            element1.classList.remove("custom-checkboxView");
            element3.classList.remove("custom-checkboxView");
            element4.classList.remove("custom-checkboxView");
        } else {
            text2.style.display = "none";
            element2.classList.remove("custom-checkboxView");
        }
    }


    function MobileContentManagement() {
        var checkBox = document.getElementById("checkbox3");
        var text1 = document.getElementById("box1");
        var text2 = document.getElementById("box2");
        var text3 = document.getElementById("box3");
        var text4 = document.getElementById("box4");
        var element1 = document.getElementById("add1");
        var element2 = document.getElementById("add2");
        var element3 = document.getElementById("add3");
        var element4 = document.getElementById("add4");
        if (checkBox.checked == true) {
            text3.style.display = "flex";
            text1.style.display = "none";
            text2.style.display = "none";
            text4.style.display = "none";
            element3.classList.add("custom-checkboxView");
            element1.classList.remove("custom-checkboxView");
            element2.classList.remove("custom-checkboxView");
            element4.classList.remove("custom-checkboxView");
        } else {
            text3.style.display = "none";
            element3.classList.remove("custom-checkboxView");
        }
    }


    function Settings() {
        var checkBox = document.getElementById("checkbox4");
        var text1 = document.getElementById("box1");
        var text2 = document.getElementById("box2");
        var text3 = document.getElementById("box3");
        var text4 = document.getElementById("box4");
        var element1 = document.getElementById("add1");
        var element2 = document.getElementById("add2");
        var element3 = document.getElementById("add3");
        var element4 = document.getElementById("add4");
        if (checkBox.checked == true) {
            text4.style.display = "flex";
            text1.style.display = "none";
            text2.style.display = "none";
            text3.style.display = "none";
            element4.classList.add("custom-checkboxView");
            element1.classList.remove("custom-checkboxView");
            element2.classList.remove("custom-checkboxView");
            element3.classList.remove("custom-checkboxView");
        } else {
            text4.style.display = "none";
            element4.classList.remove("custom-checkboxView");
        }
    }
    </script>


</body>

</html>