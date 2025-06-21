<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Score Card</title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet"> -->

    <style>
        table {
            font-family: 'Roboto', sans-serif;
            border-collapse: collapse;
            width: 70%;
            margin-left:auto;margin-right:auto;
        }
    
        td,
        th {
            font-family: 'Roboto', sans-serif;
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            width:90px;
        }
    
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body style="margin: 0px;">


    <div style="width: 100%;background-color: #f9ef7e;text-align: left;padding: 20px;box-sizing: border-box;">

        <div style="text-align:center">
            <img src="https://techie-experts.co.in/alsowise/uploads/image_galary/y9EMvLWx7N35338.png" alt=""
                style="width: 250px;">
        </div>

        <div
            style="max-width: 650px;background-color: #ffffff;margin: auto;padding: 25px;border-top-left-radius: 30px;border-top-right-radius: 30px;box-sizing: border-box;margin-top: 10px;">


            <p
                style="font-family: 'Roboto', sans-serif;color: #576081;font-size: 16px;font-weight: 300;padding: 10px 0px 10px;margin:0;">
                Dear <strong>Parent</strong></p>

        
            <h3 style="font-family: 'Roboto', sans-serif; text-align:center;">Monthly Score Card</h3>
                
            <table>
                <tr>
                    <th>Sl No.</th>
                    <th>Lessons</th>
                    <th>Assessments</th>
                    <th>ReadAlongs</th>
                </tr>
                <?php
                if (!empty($result)) {
                    $count = 0;
                    foreach ($result as $key => $value) {
                        $count++;
                        $background_color = "#ffffff";
                        if ($count % 2 == 0) {
                            $background_color = "#dddddd";
                        }
                        ?>
                        <tr style="background-color: <?= $background_color; ?>">
                            <td><?= $count; ?></td>
                            <td><?= $value['lesson_total_correct_ans'] ?> of <?= $value['lesson_total_question']; ?></td>
                            <td><?= $value['assessment_total_currect_ans'] ?> of <?= $value['assessment_total_question']; ?></td>
                            <td><?= $value['readalong_complete'] == 1 ? "Completed" : "Not completed"; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>

            <!-- <p
                style="font-family: 'Roboto', sans-serif;color: #576081;font-size: 16px;font-weight: 300;padding: 10px 0px 0px;margin:0;">
                Alternately, you can make the same purchase from your app at a later time. </p> -->

            <p
                style="font-family: 'Roboto', sans-serif;color: #576081;font-size: 16px;font-weight: 300;padding: 10px 0px 30px;margin:0;">
                Warm Regards,<br>
                The <strong>ALSOWISE&trade;</strong> Team</p>




            <p
                style="font-family: 'Roboto', sans-serif;color: #576081;font-size: 14px;font-weight: 300;padding: 0px 0px;">
                We respect your privacy. View our <a href="https://alsowise.com/awadmin/pages/privacy_policy"
                    target="_blank" style="text-decoration:underline;">Privacy Policy</a>.</p>
        </div>

        <div>
            <p
                style="font-family: 'Roboto', sans-serif;color: #576081;font-size: 12px;font-weight: 300; margin-top:10px;text-align:center">
                © 2022 Alsowise™. All rights reserved</p>
        </div>

    </div>
</body>

</html>