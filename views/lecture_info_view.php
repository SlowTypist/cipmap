<?php include('_header.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']))
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
			<td><b>Your appointment</b></td>
			<td><b>Your points</b></td>
		</tr>
	<?php
	$totalPoint = 0;
	foreach ($allhomeworks as $key => $value) 
	{
		?>
		<tr>
			<td><?php echo $allhomeworks[$key]['name']?> </td>
			<td><?php echo date('d M Y', strtotime($allhomeworks[$key]['start']))?> </td>
			<td><?php echo date('d M Y', strtotime($allhomeworks[$key]['end']))?> </td>
			<td><?php echo $allhomeworks[$key]['max_points']?> </td>
			<td><?php if ($allhomeworks[$key]['task_exists']){ echo "<a href='download_task.php?id=".$allhomeworks[$key]['id']."'>Download task</a>"; } else { echo "-";}?> </td>
			<?php
			$noappointment = 1;
			foreach ($allAppointments as $key2=> $value2) 
			{
				if ($allhomeworks[$key]['id'] == $allAppointments[$key2]['homework_id'])
				{
					echo "<td><a href='appointment_info.php?h=".$allhomeworks[$key]['id']."'>".date("D d M Y H:i", strtotime($allAppointments[$key2]["time"]))." at ".$allAppointments[$key2]["location_name"]."</a></td><td>".$allAppointments[$key2]["points"]."</td>";
					$noappointment = 0;
					$totalPoint = $totalPoint + intval($allAppointments[$key2]["points"]);
				}
			} 
			if ($noappointment)
			{
				echo "<td><a href='appointment_info.php?h=".$allhomeworks[$key]['id']."'>Register</a></td><td>N/A</td>";
			}
			?>
		<tr>
		<?php
	}
	?></table><br><b>Your total points: </b><?php echo $totalPoint; 
}
?>


<br><br><a href="index.php">Back to main menu</a><br>
<a href="index.php?logout">Logout</a>

<?php include('_footer.php'); ?>