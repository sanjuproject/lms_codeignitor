<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Move Readalong Files</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<select name="course_code" id="course_code" onchange="getreadalong(this.value)">
		<option value="">Choose Level</option>
		<option value="E">E</option>
		<option value="C">C</option>
		<option value="A">A</option>
	</select>
	<?= form_open(base_url('testingapi/movereadalongfiles')); ?>
	<select name="readalong_id" id="readalong_id">
		<option value="">Choose Readalong</option>
	</select>
	<input type="submit" name="submit" value="Move Files">
	<?= form_close(); ?>
</body>
</html>

<script type="text/javascript">
	function getreadalong(level){
		$.ajax({
			method:"GET",
			url:"<?php echo base_url(); ?>testingapi/fetchreadalonglist",
			data:{"course_code":level},
			dataType:"JSON",
			success:function(data){
				$("#readalong_id").html("");
				if (data.length > 0) {
					$.each(data, function(x){
						$("#readalong_id").append('<option value="'+data[x].ss_aw_id+"@"+data[x].ss_aw_title+'">'+data[x].ss_aw_title+'</option>');
					});
				}
			}
		});
	}
</script>

