<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
        <thead class="thead-light">
            <tr>
                <th>Improvement</th>
                <th>Students</th>
                <th>% of students</th>
            </tr>
        </thead>

        <tbody>
            <?php
            for ($i=count(RETENTION_PERCENTAGE_CHAIN) - 1; $i >= 0; $i--) {
                if (RETENTION_PERCENTAGE_CHAIN[$i] == '0%') {
                    $percentage_range = RETENTION_PERCENTAGE_CHAIN[$i];
                }
                else
                {
                    $percentageAry = explode("-", RETENTION_PERCENTAGE_CHAIN[$i]);
                    if (!empty($percentageAry)) {
                        $percentage_range = "> -".$percentageAry[0]." - -".$percentageAry[1];    
                    }
                    else{
                        $percentage_range = "";
                    }    
                }
                                                              
            ?>
            <tr>
                <td><?= $percentage_range; ?></td>
                <td><?= $decending_improvement_score[RETENTION_PERCENTAGE_CHAIN[$i]]; ?></td>
                <td><?= get_percentage($total_students, $decending_improvement_score[RETENTION_PERCENTAGE_CHAIN[$i]])."%"; ?></td>
            </tr>
            <?php
            }

            for ($j=0; $j < count(RETENTION_PERCENTAGE_CHAIN); $j++) { 
                if (RETENTION_PERCENTAGE_CHAIN[$j] != '0%') {
                ?>
                <tr>
                    <td><?= ">".RETENTION_PERCENTAGE_CHAIN[$j]; ?></td>
                    <td><?= $improvement_score[RETENTION_PERCENTAGE_CHAIN[$j]]; ?></td>
                    <td><?= get_percentage($total_students, $improvement_score[RETENTION_PERCENTAGE_CHAIN[$j]])."%"; ?>
                    </td>
                </tr>
                <?php
            	}
            }
            ?>
        </tbody>
    </table>
</body>
</html>