<?php include('_header.php'); ?>
	<b>Lecture: </b><?php echo $lectureInfo->name; ?>
	<b> Teacher: </b><?php echo $lectureInfo->teacher;?><br>
	<b>Maximum group size: </b><?php echo $lectureInfo->max_group_size;?><br>
	<b>Maximum points available:</b> <?php echo $allPoints?>
	<table border="2">
		<tr>
			<td><b>Homework name</b></td>
			<td><b>Start date</b></td>
			<td><b>End date</b></td>
			<td><b>Max Points</b></td>
			<td><b>Download task</b></td>
			<td><b>Your appointment</b></td>
			<td><b>Your points</b></td>
		</tr>
	<?php
	foreach ($homeworkList as $key => $value){
		?>
		<tr>
			<td><?php echo $value->name;?> </td>
			<td><?php echo date('d M Y', strtotime($value->start))?> </td>
			<td><?php echo date('d M Y', strtotime($value->end))?> </td>
			<td><?php echo $value->max_points;?> </td>
			<td><?php if (!empty($value->link_task)){
					echo "<a href='download_task.php?id=".$value->id."'>Download task</a>";
				}
				else {
					echo "-";
				}?>
			</td>
			<?php
			$noappointment = 1;
			foreach ($appointmentList as $key2=> $value2){
				if ($value->id == $value2->homework_id){
					echo "<td><a href='appointment_info.php?id=".$value2->id."'>".
						date("D d M Y H:i", strtotime($value2->time))."</a></td><td>".
						$value2->points."</td>";
					$noappointment = 0;
				}
			} 
			if ($noappointment){
				if ($value->end >= date("Y-m-d", time())){
					echo "<td><a href='appointment_info.php?h=".$value->id."'>Register</a></td><td>N/A</td>";
				}
				else{
					echo "<td>Registration closed</td><td>N/A</td>";
				}
			}
			?>
		<tr>
		<?php
	}
	?></table><br><b>Your total points: </b><?php echo $totalPoints;
?>


<br><br><a href="index.php">Back to main menu</a><br>
<a href="index.php?logout">Logout</a>

<?php include('_footer.php'); ?>