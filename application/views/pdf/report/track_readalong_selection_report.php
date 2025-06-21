<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
        <thead>
            <th>Readalongs</th>
            <th colspan="3" style="text-align: center;">PTD</th>
            <th colspan="3" style="text-align: center;">YTD</th>
            <th colspan="3" style="text-align: center;">MTD</th>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>Selected</td>
                <td>Completed</td>
                <td>%Completed</td>
                <td>Selected</td>
                <td>Completed</td>
                <td>%Completed</td>
                <td>Selected</td>
                <td>Completed</td>
                <td>%Completed</td>
            </tr>
            <?php
            foreach ($readalongs as $key => $value) {
            ?>
            <tr>
                <td><?= $value['ss_aw_title']; ?></td>
                <td><?= $selected_num_ptd[$value['ss_aw_id']]; ?></td>
                <td><?= $completed_num_ptd[$value['ss_aw_id']]; ?></td>
                <td><?= get_percentage($selected_num_ptd[$value['ss_aw_id']], $completed_num_ptd[$value['ss_aw_id']])."%"; ?></td>
                <td><?= $selected_num_ytd[$value['ss_aw_id']]; ?></td>
                <td><?= $completed_num_ytd[$value['ss_aw_id']]; ?></td>
                <td><?= get_percentage($selected_num_ytd[$value['ss_aw_id']], $completed_num_ytd[$value['ss_aw_id']])."%"; ?></td>
                <td><?= $selected_num_mtd[$value['ss_aw_id']]; ?></td>
                <td><?= $completed_num_mtd[$value['ss_aw_id']]; ?></td>
                <td><?= get_percentage($selected_num_mtd[$value['ss_aw_id']], $completed_num_mtd[$value['ss_aw_id']])."%"; ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>