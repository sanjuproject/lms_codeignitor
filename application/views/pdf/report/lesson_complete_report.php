<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
        <thead class="thead-light">
            <tr>
                <th>Level</th>
                <?php
                    if (!empty($lessons)) {
                        foreach ($lessons as $key => $value){
                        ?>
                            <th><?php echo $value->ss_aw_lesson_topic; ?></th>
                        <?php
                        }
                        ?>
                        <th>Total</th>
                        <?php
                    }
                ?>
            </tr>
        </thead>


        <tbody>
            <tr>
                <?php
                    if ($lesson_completion_searchdata['assign_level'] == 1) {
                        $course = "E";
                    }
                    elseif ($lesson_completion_searchdata['assign_level'] == 2) {
                        $course = "C";
                    }
                    else{
                        $course = "A";
                    }
                ?>
                <td><?= $course; ?></td>
                <?php
                    if (!empty($lessons)) {
                        $total = 0;
                        foreach ($lessons as $key => $value){
                            $total = $total + $lesson_complete_num[$value->ss_aw_lession_id];
                        	?>
                        	<td><?= $lesson_complete_num[$value->ss_aw_lession_id]; ?></td>
                        	<?php
                        }
                        ?>
                        <td><?= $total; ?></td>
                        <?php
                    }
                ?>
            </tr>
        </tbody>
    </table>
</body>
</html>