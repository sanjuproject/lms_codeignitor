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
                                                            <th>Diagnostic Score</th>
                                                            <?php
                                                            for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) {
                                                                ?>
                                                                <th><?= PERCENTAGE_CHAIN[$j]; ?></th>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        for ($i=0; $i < count(PERCENTAGE_CHAIN); $i++) { 
                                                            ?>
                                                            <tr>
                                                                <td><?= PERCENTAGE_CHAIN[$i]; ?></td>
                                                                <?php
                                                                for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) {
                                                                    ?>
                                                                    <td><?= $report_detail[PERCENTAGE_CHAIN[$i]][PERCENTAGE_CHAIN[$j]]; ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
</body>
</html>