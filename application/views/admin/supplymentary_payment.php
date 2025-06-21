
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Make Supplymentary Course Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
    <input type="hidden" name="child_id" id="child_id" value="<?= $child_id; ?>">
    <input type="hidden" name="course_id" id="course_id" value="<?= $course_id; ?>">
    <input type="hidden" name="payment_amount" id="payment_amount" value="<?= $payment_amount; ?>">
    <input type="hidden" name="gst_rate" id="gst_rate" value="<?= $gst_rate; ?>">
    <input type="hidden" name="discount_amount" id="discount_amount" value="<?= $discount_amount; ?>">
    <input type="hidden" name="user_email" id="user_email" value="<?= $user_email; ?>">
    <input type="hidden" name="course_name" id="course_name" value="<?= $course_name; ?>">
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
    var payment_amount = $("#payment_amount").val();
    var gst_rate = $("#gst_rate").val();
    var discount_amount = $("#discount_amount").val();
    var user_email = $("#user_email").val();
    var course_name = $("#course_name").val();

var options = {
    "key": "rzp_live_5E38oBl0w6EgWD",
    "currency": "INR",
    "amount": payment_amount,
    "name": course_name,
    "email": user_email,
    "description": "Spplymentary Course Purchase",
    "handler": function (response){
        console.log(response);
        $.ajax({
            url: '<?php echo base_url() ?>'+'v1/parentapi/razorPaySupplymentarySuccess',
            type: 'post',
            dataType: 'json',
            data: {
                user_id: user_id, child_id: child_id, course_id: course_id, transaction_id: response.razorpay_payment_id, payment_amount: payment_amount, gst_rate: gst_rate, discount_amount: discount_amount
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