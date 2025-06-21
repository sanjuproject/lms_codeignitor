<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
	<table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
        <thead class="thead-light">
            <tr>
                <th>Date</th>
                <th>Bill No</th>
                <th>Name</th>
                <th>PAN</th>
                <th>Billing City</th>
                <th>Billing State</th>
                <th>GST HSN Code</th>
                <th>Programme Type</th>
                <th>Invoice Amount</th>
                <th>Lumpsum/EMI</th>
                <th>Discount</th>
                <th>GST</th>
                <th>Total Invoice(Including GST)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($collection_details as $key => $value) {
            ?>
            <tr>
                                                                <td><?= date('d-m-Y', strtotime($value->ss_aw_created_at)); ?></td>
                                                                <td><?= $value->ss_aw_bill_no; ?></td>
                                                                <td><?= $value->ss_aw_parent_full_name; ?></td>
                                                                <td>ABTFA3148H</td>
                                                                <td><?= $value->ss_aw_parent_city; ?></td>
                                                                <td><?= $value->ss_aw_parent_state; ?></td>
                                                                <td>19ABTFA3148H1Z3</td>
                                                                <td>
                                                                    <?php
                                                                    if ($value->ss_aw_course_id == 1) {
                                                                        echo "E";
                                                                    }
                                                                    elseif ($value->ss_aw_course_id == 2) {
                                                                        echo "C";
                                                                    }
                                                                    else{
                                                                        echo "A";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?= $value->ss_aw_invoice_amount; ?></td>
                                                                <td><?= $value->ss_aw_payment_type == 0 ? "Lumpsum" : "EMI" ?></td>
                                                                <td><?= $value->ss_aw_discount_amount; ?></td>
                                                                <td><?= $gst = round(($value->ss_aw_invoice_amount*18)/100); ?></td>
                                                                <td><?= $value->ss_aw_invoice_amount + $gst; ?></td>
                                                            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>