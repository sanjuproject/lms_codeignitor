<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<h1>Transaction ID: <?= $transaction_id; ?></h1>
	<h1>Payment Amount: <?= $payment_amount; ?></h1>
	<h1>Invoice No: <?= $invoice_no; ?></h1>
	<h1>Course: <?php if ($course_id == 1) {
		echo "Emerging";
	}elseif ($course_id == 2) {
		echo "Consolidated";
	}else{
		echo "Advanced";
	} ?></h1>
</body>
</html>