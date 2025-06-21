<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Integrate Payment Gateway</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
    <input type="hidden" name="child_id" id="child_id" value="<?= $child_id; ?>">
    <input type="hidden" name="course_id" id="course_id" value="<?= $course_id; ?>">
    <input type="hidden" name="invoice_no" id="invoice_no" value="<?= $invoice_no; ?>">
    <input type="hidden" name="payment_amount" id="payment_amount" value="<?= $payment_amount; ?>">
    <input type="hidden" name="gst_rate" id="gst_rate" value="<?= $gst_rate; ?>">
    <input type="hidden" name="discount_amount" id="discount_amount" value="<?= $discount_amount; ?>">
    <input type="hidden" name="coupon_id" id="coupon_id" value="<?= $coupon_id; ?>">
    <input type="hidden" name="promoted" id="promoted" value="<?= $promoted; ?>">
    <input type="hidden" name="user_email" id="user_email" value="<?= $user_email; ?>">
    <input type="hidden" name="course_name" id="course_name" value="<?= $course_name; ?>">
    <input type="hidden" name="emi_payment" id="emi_payment" value="<?= $emi_payment; ?>">
    <button class="buy_now" style="display: none;">Buy Now</button>
</body>
</html>

<script>
$(document).ready(function(){
    $(".buy_now").trigger('click');
});    
$('body').on('click', '.buy_now', function(e){
    var user_id = $("#user_id").val();
    var child_id = $("#child_id").val();
    var course_id = $("#course_id").val();
    var invoice_no = $("#invoice_no").val();
    var payment_amount = $("#payment_amount").val();
    var gst_rate = $("#gst_rate").val();
    var discount_amount = $("#discount_amount").val();
    var coupon_id = $("#coupon_id").val();
    var promoted = $("#promoted").val();
    var user_email = $("#user_email").val();
    var course_name = $("#course_name").val();
    var emi_payment = $("#emi_payment").val();

var options = {
    //"key": "rzp_live_5E38oBl0w6EgWD",
    "key": "rzp_test_2S11dmRA9QASUR",
    "currency": "INR",
    "amount": payment_amount,
    "name": course_name,
    "email": user_email,
    "description": "Course Purchase",
    "handler": function (response){
        console.log(response);
        $.ajax({
            url: '<?php echo base_url() ?>'+'v2/parentapi/razorPaySuccess',
            type: 'post',
            dataType: 'json',
            data: {
                user_id: user_id, child_id: child_id, course_id: course_id, transaction_id: response.razorpay_payment_id , payment_amount: payment_amount ,invoice_no: invoice_no, gst_rate: gst_rate, discount_amount: discount_amount, coupon_id: coupon_id, promoted: promoted,emi_payment: emi_payment
            }, 
            success: function (msg) {
               window.location.href = '<?php echo base_url() ?>'+'v1/parentapi/RazorThankYou'
            }
        });
    },
    "theme": {
        "color": "#F37254"
    }
};

var rzp1 = new Razorpay(options);
rzp1.open();
e.preventDefault();

});
</script>