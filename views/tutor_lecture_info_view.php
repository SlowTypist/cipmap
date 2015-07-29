<?php include('_header.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getid']))
{?>
	<b>Lecture: </b><?php echo $lectureinfo[0]['name']?>
	<b> Teacher: </b><?php echo $lectureinfo[0]['teacher']?><br>
	<b>Maximum group size: </b><?php echo $lectureinfo[0]['max_group_size']?><br>
	<b>Maximum points available:</b> <?php echo $allPoints?>
	<table border="2">
		<tr>
			<td><b>Homework name</b></td>
			<td><b>Start date</b></td>
			<td><b>End date</b></td>
			<td><b>Max Points</b></td>
			<td><b>Download task</b></td>
			<td><b>Download solution</b></td>
		</tr>
	<?php
	$totalPoint = 0;
	foreach ($allhomeworks as $key => $value) 
	{
		?>
		<tr>
			<td><a href=homework_appointments.php?h_id=<?php echo $value['id']?>><?php echo $value['name']?></a> </td>
			<td><?php echo date('d M Y', strtotime($value['start']))?> </td>
			<td><?php echo date('d M Y', strtotime($value['end']))?> </td>
			<td><?php echo $value['max_points']?> </td>
			<td><?php if ($value['task_exists']){ echo "<a href='../download_task.php?id=".$value['id']."'>Download task</a>"; } else { echo "-";}?> </td>
			<td><?php if ($value['solution_exists']){ echo "<a href='download_solution.php?id=".$value['id']."'>Download solution</a>"; } else { echo "-";}?> </td>
		<tr>
		<?php
	}
	?></table><br><?php
}
?>


<br><br><a href="index.php">Back to main menu</a><br>

<?php include('_footer.php'); ?>