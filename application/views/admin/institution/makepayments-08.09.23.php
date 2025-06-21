<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<div id="overlay">
    <div class="cv-spinner">
        <div class="spinner-border text-warning" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<style type="text/css">
    #overlay{   
        position: fixed;
        top: 0;
        z-index: 9999999;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0,0,0,0.6);
        left: 0;
        bottom: 0;
        right: 0;
    }
    .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;  
    }
</style>
<style>
    .form-control[readonly] {
        background: #ddd;
    }

    .emi-grid-view table {
        width: 100%;
    }

    .emi-grid-view th {
        border-bottom: 2px solid #ccc;

    }

    .emi-grid-view td {
        border-bottom: 1px solid #ccc;

    }

    .emi-grid-view tr:nth-child(2n+1) td {
        background-color: #eee;
    }

    #emi-grid {
        display: none;
    }
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $institution_details->ss_aw_id; ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institutionmanagepayment/<?= $institution_details->ss_aw_id; ?>">Manage Payment</a></li>
                            <li class="breadcrumb-item"><?= $upload_details->ss_aw_upload_file_name; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Make Payment for <?= $upload_details->ss_aw_program_type == 1 ? Winners : Master."s" ?> Programme</h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <a href="<?= base_url(); ?>admin/institutionmanagepayment/<?= $institution_details->ss_aw_id; ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <form class="parsley-examples" method="post" id="frm-add-institution">
                                        <div class="row ">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="noofstudent">No. of Users </label>
                                                    <div class="verification-parent">
                                                        <input class="form-control" readonly type="text" name="noofstudent" placeholder="" value="<?= $upload_details->ss_aw_student_number; ?>">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label>Payment Type </label>

                                                    <div class="terget-audience-radio">
                                                        <div class="radio radio-primary mr-2">
                                                            <input type="radio" name="rad_paymenttype" id="rad_lumpsum" value="1" <?= $upload_details->ss_aw_emi_count == 0 ? "checked" : "disabled"; ?> onclick="getPriceDetails(this.value)">
                                                            <label for="rad_lumpsum">
                                                                Lumpsum
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-primary mr-2">
                                                            <input type="radio" name="rad_paymenttype" id="rad_emi" value="2" <?= $upload_details->ss_aw_emi_count > 0 ? "checked" : ""; ?> onclick="getPriceDetails(this.value)">
                                                            <label for="rad_emi">
                                                                EMI
                                                            </label>
                                                        </div>

                                                    </div>



                                                </div>
                                                <div class="form-group">

                                                    <div class="custom-control custom-switch custom-switch-with">
                                                        <input <?= $upload_details->ss_aw_emi_count > 0 ? "disabled" : ""; ?> name="chk_discount_coupon" type="checkbox" class="custom-control-input" id="chk_discount_coupon" onclick="applyCoupon();">
                                                        <label class="custom-control-label" for="chk_discount_coupon">Apply Discount Coupon</label>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="discountcoupon">Discount Coupon:</label>
                                                    <div class="verification-parent">
                                                        <input readonly class="form-control" type="text" name="discountcoupon" id="discountcoupon" placeholder="Enter Coupon Code">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div id="coupon_error" class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Discount Amount:</label>
                                                    <div class="verification-parent">
                                                        <input class="form-control" readonly type="text" name="discountammount" id="discountammount" placeholder="" value="0">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="originalamount" id="originalamount">
                                                <div class="form-group">
                                                    <label for="">Final Amount:</label>
                                                    <div class="verification-parent">
                                                        <input class="form-control" readonly type="text" name="finalamount" id="finalamount" placeholder="">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                    <span>(GST included)</span>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">
                                                <input type="hidden" name="first_emi_amount" id="first_emi_amount" value="0">
                                                <div class="emi-grid-view" id="emi-grid">
                                                    
                                                </div>
                                            </div>


                                            <div class="col-sm-12" id="lumpsum_pay">
                                                <div class="text-left">
                                                    <button type="button" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" data-toggle="modal" data-target="#warning-status-modal">Make Payment</button>
                                                    <a href="<?= base_url(); ?>institution/manage_payment" class="btn btn-danger">Cancel</a>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>


                            </div>


                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
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

<!--Status update confirmation dialog -->
                    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog"
                        aria-modal="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Warning!</h4>
                                        <p class="mt-3">Confirm Payment ?
                                        </p>
                                        <div class="button-list">
                                            <input type="hidden" id="emi_pay_object" name="emi_pay_object">   
                                            <button type="button" class="btn btn-danger"
                                                id="payment_confirmation" onclick="payNow(0);">Yes</button>
                                            <button type="button" class="btn btn-success"
                                                data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
<!-- END wrapper -->
<?php
include('footer.php')
?>
<script>
$(()=>{
    let paymentType = $('input[name="rad_paymenttype"]:checked').val();
    getPriceDetails(paymentType);
});

function getPriceDetails(paymentType){
    let institution_id = "<?= $institution_details->ss_aw_id ?>";
    let programType = "<?= $upload_details->ss_aw_program_type ?>";
    getCouponCode(paymentType, institution_id, programType);
    if (paymentType == 1) {
        $('#emi-grid').hide();
        $("#lumpsum_pay").show();
    }
    else{
        $("#lumpsum_pay").hide();
        $('#emi-grid').show();
    }
    
    let eachAmount = 0;
    let total_student = "<?= $upload_details->ss_aw_student_number ?>";
    let total_amount = 0;
    if (programType == 1) {
        if (paymentType == 1) {
            eachAmount = "<?= $institution_details->ss_aw_lumpsum_price ?>";
        }
        else{
            eachAmount = "<?= $institution_details->ss_aw_emi_price ?>";   
        }
    }
    else{
        if (paymentType == 1) {
            eachAmount = "<?= $institution_details->ss_aw_lumpsum_price_masters ?>";
        }
        else{
            eachAmount = "<?= $institution_details->ss_aw_emi_price_masters ?>";   
        }
    }

    total_amount = eachAmount * total_student;
    total_amount = Math.round(total_amount * 100) / 100;
    $("#originalamount").val(total_amount);
    $("#finalamount").val(total_amount);

    //Setup EMI section
    if (paymentType == 2) {
        let paymentHistory = <?= $payment_history ? $payment_history : "0" ?>;
        let paidEmi = "<?= $upload_details->ss_aw_emi_count; ?>";
        let emicount = 0;
        let emiPricePerEmi = 0;
        if (programType == 1) {
            emicount = "<?= EMERGING_EMI_DURATION ?>";
        }
        else{
            emicount = "<?= ADVANCED_EMI_DURATION ?>";
        }
        emiPricePerEmi = total_amount / emicount;
        emiPricePerEmi = Math.round(emiPricePerEmi * 100) / 100;
        if (paidEmi > 0) {
            $("#first_emi_amount").val(paymentHistory[0].ss_aw_payment_amount);    
        }
        else{
            $("#first_emi_amount").val(emiPricePerEmi);
        }
        
        var emiHtml = "";
        emiHtml += '<table><tr><th colspan="3">EMI Payments list</th></tr>';
        for (var i = 0; i < emicount; i++) {
            let currentDate;
            if (paidEmi > 0) {
                currentDate = new Date(paymentHistory[0].ss_aw_created_date);
            }
            else{
                currentDate = new Date();    
            }
            
            if (i > 0) {
                currentDate = addMonths(currentDate, i);
            }
            let day = currentDate.getDate();
            let month = currentDate.getMonth();
            let incrementedMonth = month + 1;
            let year = currentDate.getFullYear();
            let formatedDate = day+'/'+incrementedMonth+'/'+year;
            if (paidEmi > i) {
                emiHtml += '<tr><td>'+formatedDate+'</td><td>₹'+paymentHistory[i].ss_aw_payment_amount+'</td><td><a href="javascript:void(0)" class="text-muted">Paid</a></td></tr>';
            }
            else{
                if ((paidEmi - i) == 0) {
                    emiHtml += '<tr><td>'+formatedDate+'</td><td>₹'+emiPricePerEmi+'</td><td><a href="javascript:void(0)" class="pay" data-emiPrice="'+emiPricePerEmi+'" data-toggle="modal" data-target="#warning-status-modal">Pay Now</a></td></tr>';    
                }
                else{
                    emiHtml += '<tr><td>'+formatedDate+'</td><td>₹'+emiPricePerEmi+'</td><td><a href="javascript:void(0)" class="text-muted">Pay Now</a></td></tr>';
                }
            }
            
        }
        emiHtml += '</table>';
        $("#emi-grid").html(emiHtml);
    }
    applyCoupon();
}

function addMonths(date, months) {
  date.setMonth(date.getMonth() + months);
  return date;
}

//get coupon code payment type and program type wise
function getCouponCode(paymentType, institutionId, programType){
    $.ajax({
        type:"POST",
        async: false,
        url:"<?= base_url(); ?>institution/get_institution_coupon",
        data:{"paymentType": paymentType, "institutionId": institutionId, "programType": programType},
        dataType:"JSON",
        success:function(data){
            if (data != "") {
                $("#discountcoupon").val(data.coupon_code);
                //console.log(data.coupon_code);
            }
        }
    });
}

function applyCoupon(){
    let discountPercentage = 0;
    if($("#chk_discount_coupon").prop('checked') == true){
        let paymentType = $('input[name="rad_paymenttype"]:checked').val();
        let discountCoupon = $("#discountcoupon").val();
        console.log({discountCoupon});
        if (discountCoupon != "") {
            $.ajax({
                type:"POST",
                async: false,
                url:"<?= base_url(); ?>institution/apply_coupon",
                data:{"discount_coupon": discountCoupon, "payment_type": paymentType},
                dataType:"JSON",
                success:function(response){
                    console.log(response);
                    if (response.status == 1) {
                        $("#coupon_error").html("Coupon applied successfully.");
                        discountPercentage = response.data[0].ss_aw_discount;
                        console.log(response.data);
                    }
                    else{
                        $("#coupon_error").html("Invalid coupon");
                    }
                }
            });
        }
    }
    else{
        $("#coupon_error").html("");
    }
    calculateDiscount(discountPercentage);
}

function calculateDiscount(percentage){
    let paidEmi = "<?= $upload_details->ss_aw_emi_count; ?>";
    let programType = "<?= $upload_details->ss_aw_program_type ?>";
    {
        let paymentType = $('input[name="rad_paymenttype"]:checked').val();
        percentage = Number(percentage);
        let firstEmiPrice = 0;
        let firstEmiDiscount = 0;
        let total_amount = $("#originalamount").val();
        total_amount = Number(total_amount);
        if (paymentType == 2) {
            console.log({percentage});
            let noOfUsers = "<?= $upload_details->ss_aw_student_number ?>";
            let each_emi_w_gst = 0;
            let emicount = 0;
            if (programType == 1) {
                each_emi_w_gst = "<?= $institution_details->ss_aw_emi_price ?>";
                emicount = "<?= EMERGING_EMI_DURATION ?>";
            }
            else{
                each_emi_w_gst = "<?= $institution_details->ss_aw_emi_price_masters ?>";
                emicount = "<?= ADVANCED_EMI_DURATION ?>";
            }
            emicount = Number(emicount);
            console.log({each_emi_w_gst});
            each_emi_w_gst = each_emi_w_gst / emicount;


            let emi_amount_without_gst = (each_emi_w_gst * 100) / 118;
            //emi_amount_without_gst = Math.round(emi_amount_without_gst * 100) / 100;


            let first_emi_discount_price = (emi_amount_without_gst * percentage) / 100;
            let first_emi_price_with_gst = 0;
            let first_emi_price_with_gst_all_users = 0;
			let final_amount_all_users = 0;
            if (paidEmi > 0) {
                console.log("@11");
                let paymentHistory = <?= $payment_history ? $payment_history : "0" ?>;
                let discount_amount = Number(paymentHistory[0].ss_aw_discount_amount);
                first_emi_price_with_gst = Number(paymentHistory[0].ss_aw_payment_amount);//this is for all users

                //first_emi_discount_price = discount_amount / noOfUsers;
                first_emi_price_with_gst_all_users = first_emi_price_with_gst;
				
				let final_amount = first_emi_price_with_gst_all_users + (((each_emi_w_gst * (emicount - 1))) * noOfUsers);
				final_amount_all_users = final_amount;
				
				//console.log("each_emi_w_gst", each_emi_w_gst);//26.66
				//console.log("emicount", emicount);//6
				//console.log("noOfUsers", noOfUsers);//5
				//console.log("first_emi_price_with_gst", first_emi_price_with_gst);//6.67
				//console.log("final_amount_all_users", final_amount_all_users);//80	
				
            }
            else{
                console.log("@22");
                first_emi_price_with_gst = each_emi_w_gst;
                let first_emi_price_wo_gst_all_users = emi_amount_without_gst * noOfUsers;
                first_emi_price_wo_gst_all_users = first_emi_price_wo_gst_all_users - (first_emi_discount_price * noOfUsers);
                first_emi_price_with_gst_all_users = (first_emi_price_wo_gst_all_users * 118) / 100;

                let first_emi_price_wo_gst = emi_amount_without_gst - first_emi_discount_price;
                first_emi_price_with_gst =  (first_emi_price_wo_gst * 118) / 100;
				
				let final_amount = first_emi_price_with_gst + (each_emi_w_gst * (emicount - 1));
				final_amount_all_users = final_amount * noOfUsers;
				
				//console.log("each_emi_w_gst", each_emi_w_gst);//26.66
				//console.log("emicount", emicount);//6
				//console.log("noOfUsers", noOfUsers);//3
				//console.log("first_emi_price_with_gst", first_emi_price_with_gst);//26.66
				//console.log("final_amount_all_users", final_amount_all_users);//80			
            }
            			
            final_amount_all_users = Math.round(final_amount_all_users * 100) / 100;
			
			first_emi_price_with_gst_all_users = Math.round(first_emi_price_with_gst_all_users * 100) / 100;
            $("#emi-grid table tbody tr:nth-child(2) td:nth-child(2)").html("₹"+first_emi_price_with_gst_all_users);
			
            $("#finalamount").val(final_amount_all_users);
			
            let first_emi_discount_price_all_users = first_emi_discount_price * noOfUsers;
            first_emi_discount_price_all_users = Math.round(first_emi_discount_price_all_users * 100) / 100;
            $("#discountammount").val(first_emi_discount_price_all_users);
            return;





            //let firstEmiPrice = $("#first_emi_amount").val();
            //console.log({firstEmiPrice});
            //let firstEmiPriceWithOutGST = (firstEmiPrice * 100) / 118;
            //firstEmiPriceWithOutGST = Math.round(firstEmiPriceWithOutGST * 100) / 100;
            firstEmiPriceWithOutGST = Number(firstEmiPriceWithOutGST);
            console.log({firstEmiPriceWithOutGST});
            firstEmiDiscount = (firstEmiPriceWithOutGST * percentage) / 100;
            firstEmiDiscount = Math.round(firstEmiDiscount * 100) / 100;
            console.log({firstEmiDiscount});
            total_amount = Math.round(total_amount * 100) / 100;
            $("#discountammount").val(firstEmiDiscount);
            let discountedEmiPrice = firstEmiPriceWithOutGST - firstEmiDiscount;
            console.log({discountedEmiPrice});
            let discountedEmiPriceWithGST = (discountedEmiPrice * 118) / 100;
            discountedEmiPriceWithGST = Math.round(discountedEmiPriceWithGST * 100) / 100;
            console.log({discountedEmiPriceWithGST});
            total_amount = firstEmiPrice * (emicount - 1);
            console.log({total_amount});
            total_amount = total_amount + discountedEmiPriceWithGST;
            total_amount = Math.round(total_amount * 100) / 100;
            discountedEmiPriceWithGST = "₹"+discountedEmiPriceWithGST;
            $("#emi-grid table tbody tr:nth-child(2) td:nth-child(2)").html(discountedEmiPriceWithGST);
        }
        else{
            let totalAmountWithOutGST = (total_amount * 100) / 118;
            let discountAmount = (totalAmountWithOutGST * percentage) / 100;
            discountAmount = Math.round(discountAmount * 100) / 100;
            total_amount = totalAmountWithOutGST - discountAmount; 
            total_amount = Math.round(total_amount * 100) / 100;
            total_amount = (total_amount * 118) / 100;
            total_amount = Math.round(total_amount * 100) / 100;
            $("#discountammount").val(discountAmount);   
        }
        $("#finalamount").val(total_amount);
    }
}

function randomString(length) {
    var result = '';
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

function url_redirect(url){
    var X = setTimeout(function(){
        window.location.replace(url);
        return true;
    },300);

    if( window.location = url ){
        clearTimeout(X);
        return true;
    } else {
        if( window.location.href = url ){
            clearTimeout(X);
            return true;
        }else{
            clearTimeout(X);
            window.location.replace(url);
            return true;
        }
    }
    return false;
}

//razorpay payment code
$('body').on('click', '.buy_now', function(e){
    var payment_amount = $("#finalamount").val();
    var discount_amount = $("#discountammount").val();
    var coupon_code = $("#discountcoupon").val();
    var programType = "<?= $upload_details->ss_aw_program_type ?>";
    var course_name = "";
    var course_id = 0;
    if (programType == 1) {
        course_id = 1;
        course_name = "<?=Winners?> Programme";
    }
    else{
        course_id = 5;
        course_name = "<?=Master?>s Programme";
    }
    var user_email = "<?= $institution_admin_details[0]->ss_aw_parent_email ?>";
    var parent_id = "<?= $institution_admin_details[0]->ss_aw_parent_id ?>";
    var payment_type = $('input[name="rad_paymenttype"]:checked').val();
    var institution_id = "<?= $institution_details->ss_aw_id ?>";
    var excel_upload_id = "<?= $upload_details->ss_aw_id ?>";
    {
        var razorpay_payment_id = randomString(14);
        razorpay_payment_id = "pay_"+razorpay_payment_id;
        $("#overlay").fadeIn(300);
        $.ajax({
            url: '<?php echo base_url() ?>'+'admin/institution_bulk_payment',
            type: 'post',
            dataType: 'json',
            data: {
                course_id: course_id, transaction_id: razorpay_payment_id , payment_amount: payment_amount, discount_amount: discount_amount, coupon_code: coupon_code, payment_type: payment_type, institution_id: institution_id, excel_upload_id: excel_upload_id, parent_id: parent_id
            }, 
            success: function (data) {
                var url = '<?php echo base_url() ?>'+'admin/institution_paymentsuccess/'+institution_id+'/'+data.status;
                window.location = url;
                //location.replace(url);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var url = '<?php echo base_url() ?>'+'admin/institution_paymentsuccess/'+institution_id;
                window.location = url;
                //location.replace(url);
            }
        });
    }
});
//end


//If original emi payment price use then the below code will be used.

// $('#warning-status-modal').on('show.bs.modal', function(e) {
//     var emiPrice = $(e.relatedTarget).data('emiprice');
//     let functionName = "payNow("+emiPrice+")";
//     $("#payment_confirmation").attr('onclick', functionName);
// });

function payNow(paidAmount){
    //var emiPrice = Number(emiPrice);
    var payment_amount = paidAmount;
    //var discount_amount = $("#discountammount").val();
    var discount_amount = 0; //Discount 0 from admin end
    //var coupon_code = $("#discountcoupon").val();
    var coupon_code = ""; //Blank from admin end
    var programType = "<?= $upload_details->ss_aw_program_type ?>";
    var course_name = "";
    var course_id = 0;
    if (programType == 1) {
        course_id = 1;
        course_name = "<?=Winners?> Programme";
    }
    else{
        course_id = 5;
        course_name = "<?=Master?>s Programme";
    }
    var user_email = "<?= $institution_admin_details[0]->ss_aw_parent_email ?>";
    var parent_id = "<?= $institution_admin_details[0]->ss_aw_parent_id ?>";
    var payment_type = $('input[name="rad_paymenttype"]:checked').val();
    var institution_id = "<?= $institution_details->ss_aw_id ?>";
    var excel_upload_id = "<?= $upload_details->ss_aw_id ?>";
    {
        var razorpay_payment_id = randomString(14);
        razorpay_payment_id = "pay_"+razorpay_payment_id;
        $("#overlay").fadeIn(300);
        $.ajax({
            url: '<?php echo base_url() ?>'+'admin/institution_bulk_payment',
            type: 'post',
            dataType: 'json',
            data: {
                course_id: course_id, transaction_id: razorpay_payment_id , payment_amount: payment_amount, discount_amount: discount_amount, coupon_code: coupon_code, payment_type: payment_type, institution_id: institution_id, excel_upload_id: excel_upload_id, parent_id: parent_id
            }, 
            success: function (data) {
                var url = '<?php echo base_url() ?>'+'admin/institution_paymentsuccess/'+institution_id+'/'+data.status;
                window.location = url;
                //location.replace(url);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var url = '<?php echo base_url() ?>'+'admin/institution_paymentsuccess/'+institution_id;
                window.location = url;
                //location.replace(url);
            }
        });
    }
}
//end
</script>
</body>

</html>