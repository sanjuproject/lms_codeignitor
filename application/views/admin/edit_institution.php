

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
                                    <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/manage_institutions">Manage Institutions</a></li>
                                    <li class="breadcrumb-item active">Edit Institution</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <h4 class="page-title">Edit Institution</h4>
                        </div>
                        <div class="col-md-6 text-right mt-3">
                            <a href="<?= base_url(); ?>admin/manage_institutions" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php include("error_message.php");?>
                    <div class="row mt-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                    <form class="parsley-examples" method="post" id="frm-add-institution" novalidate="" action="<?= base_url(); ?>admin/update_institutions" style="box-shadow: 0px 0px 5px #000; padding: 20px 35px; border-radius: 10px;">
                        <input type="hidden" name="update_record_id" value="<?= $institution_details->ss_aw_id; ?>">
                        <input type="hidden" name="admin_id" value="<?= $admin_details[0]->ss_aw_parent_id; ?>">
                        <div class="row" id="step1">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="institutionname">Name of the Institution <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input class="form-control parsley-success" type="text" name="institutionname" id="institutionname" placeholder="Enter name of your institution" required="" parsley-type="institutionname" data-parsley-id="7" value="<?= $institution_details->ss_aw_name; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-7" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control parsley-success" name="address" id="address" required="" parsley-type="address" placeholder="Enter address" data-parsley-id="9" value="<?= $institution_details->ss_aw_address; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-9" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <select name="country" id="country" class="form-control parsley-success" required="" parsley-type="country" data-parsley-group="step1" onchange="getStates(this.value);">
                                            <option value="">Select country</option>
                                            <?php
                                            if (!empty($countries)) {
                                                foreach ($countries as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value['id'] ?>" <?= $institution_details->ss_aw_country == $value['id'] ? "selected" : ""; ?>><?= $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><ul class="parsley-errors-list" id="parsley-id-13" aria-hidden="true"></ul>

                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pin">Pin Code <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control parsley-success" name="pin" id="pin" required="" parsley-type="" placeholder="Enter Zip Code" data-parsley-id="17" value="<?= $institution_details->ss_aw_pincode; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-17" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Mobile">Mobile <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control parsley-success" required="" placeholder="Enter only mobile numbers" id="Mobile" data-toggle="input-mask" name="mobile" data-mask-format="0000000000" maxlength="10" data-parsley-id="21" value="<?= $institution_details->ss_aw_mobile_no; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-21" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg_phone">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control parsley-success" name="password" id="password" placeholder="Enter password"><ul class="parsley-errors-list" id="parsley-id-29" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control parsley-success" name="city" id="city" required="" parsley-type="city" placeholder="Enter city" data-parsley-group="step1" value="<?= $institution_details->ss_aw_city; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-11" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <select name="state" id="state" class="form-control parsley-success" required="" parsley-type="state"  data-parsley-group="step1">
                                            <option value="">Select state</option>
                                            <?php
                                            if (!empty($states)) {
                                                foreach ($states as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value['id'] ?>" <?= $institution_details->ss_aw_state == $value['id'] ? "selected" : ""; ?>><?= $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><ul class="parsley-errors-list" id="parsley-id-15" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adminname">Admin Name <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input class="form-control parsley-success" type="text" name="adminname" id="adminname" placeholder="Enter admin name" required="" parsley-type="adminname" data-parsley-id="27" value="<?= $admin_details[0]->ss_aw_parent_full_name; ?>"><ul class="parsley-errors-list" id="parsley-id-27" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="email" class="form-control parsley-success" name="email" id="emailaddress" required="" parsley-type="email" placeholder="Enter email" data-parsley-id="23" value="<?= $admin_details[0]->ss_aw_parent_email; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-23" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again">
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-sm-12">
                                <div class="text-center">
                                    <input type="button" onclick="validateStep1()"  class="btn btn-warning waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Next">
                                    <a href="<?= base_url(); ?>admin/manage_institutions" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</a>
                                </div>
                            </div>        
                        </div>
                        <div class="row" id="step2" style="display: none;">
                            <div class="col-sm-12">
                                <h4 class="page-title mt-0"><?=Winners?> Programme</h4>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="championsemiprice">Lumpsum Price <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control parsley-success" required="" placeholder="Enter the price" id="lumpsum_price" data-toggle="input-mask" data-mask-format="000000" name="lumpsum_price" parsley-type="lumpsum_price" maxlength="6" data-parsley-id="19" value="<?= $institution_details->ss_aw_lumpsum_price; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-19" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg_price">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="championsemiprice">EMI Price <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control parsley-success" required="" placeholder="Enter the price" id="emi_price" data-toggle="input-mask" data-mask-format="000000" name="emi_price" parsley-type="emi_price" maxlength="6" data-parsley-id="19" value="<?= $institution_details->ss_aw_emi_price; ?>">
                                        <ul class="parsley-errors-list" id="parsley-id-19" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg_price">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="coupon_code_lumpsum">Special coupon code(Lumpsum)</label>
                                    <div class="verification-parent">
                                        <select name="coupon_code_lumpsum" id="coupon_code_lumpsum" class="form-control" parsley-type="coupon_code_lumpsum" data-parsley-group="step2">
                                            <option value="">Select Special Coupon Code</option>
                                            <?php
                                            if (!empty($lumpsum_coupons)) {
                                                foreach ($lumpsum_coupons as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value->ss_aw_id; ?>" <?= $institution_details->ss_aw_coupon_code_lumpsum == $value->ss_aw_id ? "selected" : ""; ?>><?= $value->ss_coupon_code; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <ul class="parsley-errors-list" id="parsley-id-25" aria-hidden="true"></ul>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="coupon_code_emi">Special coupon code(EMI)</label>
                                    <div class="verification-parent">
                                        <select name="coupon_code_emi" id="coupon_code_emi" class="form-control" parsley-type="coupon_code_emi" data-parsley-group="step2">
                                            <option value="">Select Special Coupon Code</option>
                                            <?php
                                            if (!empty($emi_coupons)) {
                                                foreach ($emi_coupons as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value->ss_aw_id; ?>" <?= $institution_details->ss_aw_coupon_code_emi == $value->ss_aw_id ? "selected" : ""; ?>><?= $value->ss_coupon_code; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <ul class="parsley-errors-list" id="parsley-id-25" aria-hidden="true"></ul>
                                    </div>
                                </div>    
                            </div>
                            <div>
                                <hr />
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="page-title mt-0">Champions Programme</h4>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="champions_lumpsum_price">Lumpsum Price <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control" type="text" name="champions_lumpsum_price" id="champions_lumpsum_price" placeholder="Enter Lumpsum price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="champions_lumpsum_price" data-parsley-group="step2" value="<?= $institution_details->ss_aw_lumpsum_price_champions; ?>">
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="champions_emi_price">EMI Price <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control" type="text" name="champions_emi_price" id="champions_emi_price" placeholder="Enter EMI price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="champions_emi_price" data-parsley-group="step2" value="<?= $institution_details->ss_aw_emi_price_champions; ?>">
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="champions_coupon_code_lumpsum">Special coupon code(Lumpsum)</label>
                                        <div class="verification-parent">
                                            <select name="champions_coupon_code_lumpsum" id="champions_coupon_code_lumpsum" class="form-control parsley-success" parsley-type="champions_coupon_code_lumpsum" data-parsley-group="step2">
                                                <option value="">Select Special Coupon Code</option>
                                                <?php
                                                if (!empty($lumpsum_coupons)) {
                                                    foreach ($lumpsum_coupons as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value->ss_aw_id; ?>" <?= $institution_details->ss_aw_coupon_code_lumpsum_champions == $value->ss_aw_id ? "selected" : ""; ?>><?= $value->ss_coupon_code; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <ul class="parsley-errors-list" id="parsley-id-25" aria-hidden="true"></ul>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="champions_coupon_code_emi">Special coupon code(EMI)</label>
                                        <div class="verification-parent">
                                            <select name="champions_coupon_code_emi" id="champions_coupon_code_emi" class="form-control parsley-success" parsley-type="champions_coupon_code_emi" data-parsley-group="step2">
                                                <option value="">Select Special Coupon Code</option>
                                                <?php
                                                if (!empty($emi_coupons)) {
                                                    foreach ($emi_coupons as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value->ss_aw_id; ?>" <?= $institution_details->ss_aw_coupon_code_emi_champions == $value->ss_aw_id ? "selected" : ""; ?>><?= $value->ss_coupon_code; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <ul class="parsley-errors-list" id="parsley-id-25" aria-hidden="true"></ul>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                            <div>
                                <hr />
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="page-title mt-0"><?=Master?>s Programme</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="masters_lumpsum_price">Lumpsum Price <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control" type="text" name="masters_lumpsum_price" id="masters_lumpsum_price" placeholder="Enter Lumpsum price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="masters_lumpsum_price" data-parsley-group="step2" value="<?= $institution_details->ss_aw_lumpsum_price_masters; ?>">
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="masters_emi_price">EMI Price <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input class="form-control" type="text" name="masters_emi_price" id="masters_emi_price" placeholder="Enter EMI price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="championsemiprice" data-parsley-group="step2" value="<?= $institution_details->ss_aw_emi_price_masters; ?>">
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="masters_coupon_code_lumpsum">Special coupon code(Lumpsum)</label>
                                        <div class="verification-parent">
                                            <select name="masters_coupon_code_lumpsum" id="masters_coupon_code_lumpsum" class="form-control parsley-success" parsley-type="masters_coupon_code_lumpsum" data-parsley-group="step2">
                                                <option value="">Select Special Coupon Code</option>
                                                <?php
                                                if (!empty($lumpsum_coupons)) {
                                                    foreach ($lumpsum_coupons as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value->ss_aw_id; ?>" <?= $institution_details->ss_aw_coupon_code_lumpsum_masters == $value->ss_aw_id ? "selected" : ""; ?>><?= $value->ss_coupon_code; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <ul class="parsley-errors-list" id="parsley-id-25" aria-hidden="true"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="masters_coupon_code_emi">Special coupon code(EMI)</label>
                                        <div class="verification-parent">
                                            <select name="masters_coupon_code_emi" id="masters_coupon_code_emi" class="form-control parsley-success" parsley-type="masters_coupon_code_emi" data-parsley-group="step2">
                                                <option value="">Select Special Coupon Code</option>
                                                <?php
                                                if (!empty($emi_coupons)) {
                                                    foreach ($emi_coupons as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value->ss_aw_id; ?>" <?= $institution_details->ss_aw_coupon_code_emi_masters == $value->ss_aw_id ? "selected" : ""; ?>><?= $value->ss_coupon_code; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <ul class="parsley-errors-list" id="parsley-id-25" aria-hidden="true"></ul>
                                        </div>
                                    </div>
                                </div>
                                                         
                            </div>
                            <div>
                                <hr />
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="page-title mt-0"><?=Diagnostic?>s Programme (<small>** No Partial Payment</small>)</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="masters_lumpsum_price">Lumpsum Price </label>
                                        <div class="verification-parent">
                                            <input class="form-control" type="text" name="diagnostic_lumpsum_price" id="diagnostic_lumpsum_price" placeholder="Enter Lumpsum price" data-parsley-type="number" min="0" max="100000" parsley-type="diagnostic_lumpsum_price" data-parsley-group="step2" value="<?= $institution_details->ss_aw_lumpsum_price_diagnostic; ?>">
                                            <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                            <div class="verification-btn error_msg">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                               
                                
                                
                                <div class="col-12">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="partial_payment" name="partial_payment" value="1" <?= $institution_details->ss_aw_partial_payment == 1 ? "checked" : ""; ?>>Allow Partial Payment
                                      </label>
                                    </div>
                                </div>
                            
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary" onclick="showPrev()">Back</button>
                                        <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save">
                                        <a href="<?= base_url(); ?>admin/manage_institutions" class="btn btn-danger waves-effect waves-light m-l-10">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        </div>

                    </form>

                    </div> <!-- end col -->
                    <div class="col-md-2"></div>
                           
                    
                    
                    
                    </div> 

                    </div> <!-- container -->

                </div> <!-- content -->
                
<?php
include 'bottombar.php';
?>

            </div>
<?php
include 'footer.php'
?>

<script type="text/javascript">
    function validateStep1() {
        $('#frm-add-institution').parsley().validate();
        
       let errorlist = $('#step1 .parsley-errors-list li');
       console.log(errorlist);
       if(errorlist.length == 0){
        $('#step1').hide();$('#step2').show();
        console.log($('#step2 input, #step2 select'));
        $('#step2 input, #step2 select').each(()=>{
            $(this).removeClass('parsley-error');
        });
        
       }
    }

    function showPrev(){
        $('#step2').hide();$('#step1').show();
    }
</script>
</body>
</html>