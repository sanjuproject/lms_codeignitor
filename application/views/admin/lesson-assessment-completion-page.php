<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<label>Child ID</label>
			<input type="text" name="student_id" id="student_id" onkeyup="storeStudentID(this.value);">
			<label>Level</label>
			<select name="level" onchange="getlessonassessment(this.value);">
				<option value="1"><?=Winners?></option>
				<option value="3"><?=Champions?></option>
				<option value="5"><?=Master?>s</option>
			</select>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<?= form_open(base_url('testingapi/lesson_completion')); ?>
			<input type="hidden" name="child_id" id="lesson_child_id" required>
			<input type="hidden" name="child_level" id="lesson_child_level">
			<label>Lesson</label>
			<select name="lesson" id="lesson_container" required>
				<?php
				if (!empty($lesson_list)) {
					foreach ($lesson_list as $key => $value) {
						?>
						<option value="<?= $value['ss_aw_lession_id']; ?>"><?= $value['ss_aw_lesson_topic']; ?></option>
						<?php
					}
				}
				?>
			</select>
			<label>Action</label>
			<select name="action" required>
				<option value="">Choose Action</option>
				<option value="1">Mark as Complete</option>
				<option value="2">Mark as Incomplete</option>
				<option value="3">Mark as accessable</option>
			</select>
			<input type="submit" name="lesson_submit" value="Submit">
			<?= form_close(); ?>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<?= form_open(base_url('testingapi/assessment_completion')); ?>
			<input type="hidden" name="child_id" id="assessment_child_id" required>
			<input type="hidden" name="child_level" id="assessment_child_level">
			<label>Assessment</label>
			<select name="assessment" id="assessment_container" required>
				<?php
				if (!empty($assessment_list)) {
					foreach ($assessment_list as $key => $value) {
						?>
						<option value="<?= $value['ss_aw_assessment_id']; ?>"><?= $value['ss_aw_assesment_topic']; ?></option>
						<?php
					}
				}
				?>
			</select>
			<label>Action</label>
			<select name="action" required>
				<option value="">Choose Action</option>
				<option value="1">Mark as Complete</option>
				<option value="2">Mark as Incomplete</option>
				<option value="3">Mark as accessable</option>
			</select>
			<input type="submit" name="assessment_submit" value="Submit">
			<?= form_close(); ?>
		</div>
	</div>
	<?php
	if ($this->session->flashdata('success')) {
		?>
		<div class="container">
			<div class="row">
				<?php echo $this->session->flashdata('success'); ?>	
			</div>
		</div>
		<?php	
	}
	?>
</body>
</html>

<script type="text/javascript">
	function storeStudentID(childId){
		$("#lesson_child_id").val(childId);
		$("#assessment_child_id").val(childId);
	}
	function getlessonassessment(level){
		$.ajax({
			method:"GET",
			url:"<?php echo base_url(); ?>testingapi/getlessonassessmentlistbylevel",
			data:{"level":level},
			dataType:"JSON",
			success:function(data){
				$("#lesson_container").html("");
				$("#assessment_container").html("");
				if (data.lesson_list.length > 0) {
					$.each(data.lesson_list, function(lessons){
						$("#lesson_container").append('<option value="'+data.lesson_list[lessons].ss_aw_lession_id+'">'+data.lesson_list[lessons].ss_aw_lesson_topic+'</option>');
					});
				}

				if (data.assessment_list.length > 0) {
					$.each(data.assessment_list, function(assessments){
						$("#assessment_container").append('<option value="'+data.assessment_list[assessments].ss_aw_assessment_id+'">'+data.assessment_list[assessments].ss_aw_assesment_topic+'</option>');
					});
				}
			}
		});
	}
</script>