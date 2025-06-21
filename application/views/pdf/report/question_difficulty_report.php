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
	                <th>Course</th>
	                <th>Question Level</th>
	                <th>Question</th>
	                <th>Sequence No</th>
	                <th>No Of Time Asked</th>
	                <th>No Of Time Answer Correctly</th>
	            </tr>
            </thead>


                <tbody>
                    <?php
                        if (!empty($result)) {
                            $count = 0;
                            foreach ($result as $key => $value) {
                            $count++;
                            ?>
                                                       
                                <tr>
                                    <td><?php echo $value->lesson_course_type; ?></td>
                                    <td><?php echo $value->question_course_level; ?></td>
                                    <?php 
                                        $title_string = $value->ss_aw_lesson_title." ".$value->ss_aw_lesson_details; 
                                    ?>
                                    <td><?php echo getQuestion($title_string); ?></td>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $question_asked[$value->record_id] ? $question_asked[$value->record_id] : 0; ?></td>
                                    <td><?php echo $correct_answer[$value->record_id] ? $correct_answer[$value->record_id] : 0; ?></td>
                                </tr>

                            <?php
                            $sl++;
                            }
                        }
                        else
                        {
                            ?>
                                <tr colspan="6">
                                    <td>No data found.</td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
</body>
</html>