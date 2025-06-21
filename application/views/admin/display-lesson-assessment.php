<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<div>
		<form action="<?= base_url(); ?>testingapi/display_lesson_assements" method="post">
			<select name="level">
				<option value="">Choose One</option>
				<option value="1" <?php if(!empty($level)){ if($level == 1){ ?> selected <?php }  } ?>>E</option>
				<option value="2" <?php if(!empty($level)){ if($level == 2){ ?> selected <?php }  } ?>>C</option>
				<option value="3" <?php if(!empty($level)){ if($level == 3){ ?> selected <?php }  } ?>>A</option>
			</select>
			<input type="submit" name="submit" value="Search">
		</form>
	</div>
	<div style="width: 100%; display: flex;">
		<div style="width: 50%;">
			<?php
			if (!empty($lesson_list)) {
				?>
				<table border="1">
					<thead>
						<th>Lesson Name</th>
						<th>Lesson ID</th>
					</thead>
					<tbody>
						<?php
						foreach ($lesson_list as $key => $value) {
							?>
							<tr>
								<td><?= $value['ss_aw_lesson_topic']; ?></td>
								<td><?= $value['ss_aw_lession_id']; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
			}
			?>
		</div>
		<div style="width: 50%;">
			<?php
			if (!empty($assessment_list)) {
				?>
				<table border="1">
					<thead>
						<th>Assessment Name</th>
						<th>Assessment ID</th>
					</thead>
					<tbody>
						<?php
						foreach ($assessment_list as $key => $value) {
							?>
							<tr>
								<td><?= $value->ss_aw_assesment_topic; ?></td>
								<td><?= $value->ss_aw_assessment_id; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
			}
			?>
		</div>
	</div>
</body>
</html>