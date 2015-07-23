<?php include('_header.php'); ?>
<?php 
if (isset($_GET['h']) && $appointmentinfo != -1)
{
	echo "<b>Lecture: </b>".$appointmentinfo['lecture_name']."<b> Teacher: </b>".$appointmentinfo['teacher']."<br><b>Maximum group size: </b>".$appointmentinfo['max_group_size'];
	echo "<br><b>Homework name: </b>".$appointmentinfo["homework_name"]."<b> Your score: </b>";
	if (isset($appointmentinfo['points']))
	{
		echo $appointmentinfo['points'];
	} 
	else {
		echo "0";
	}
	echo " out of ".$appointmentinfo["max_points"];
	echo "<br><b>Your appointment: </b>".date("D d M Y H:i", strtotime($appointmentinfo["time"]))." at ".$appointmentinfo["location_name"]."";
	?><br><form action="appointment_info.php" method="post">
		<input type="hidden" name="homework_id" value="<?php echo $_GET['h'] ?>">
		<input type="submit" name="deleteAppointment" value="Cancel appointment" /></form><?php
	echo "<a href=lecture_info.php?id=".$appointmentinfo["lecture_id"].">Back to lecture</a><br>";
	
}
else if ($appointmentinfo == -1 || isset($_POST['loc']))
{
	echo "<b>Lecture: </b>".$homeworkinfo['lecture_name']."<b> Teacher: </b>".$homeworkinfo['teacher']."<br><b>Maximum group size: </b>".$homeworkinfo['max_group_size'];
	echo "<br><b>Homework name: </b>".$homeworkinfo["homework_name"]." <b>Start date: </b>".date("d M Y", strtotime($homeworkinfo["start"]))." <b>End date: </b>".date("d M Y", strtotime($homeworkinfo["end"]));
	if (!isset($_POST['loc']))
	{
		echo "<br><br><b>Choose location:</b><br>";
		?><form action ="appointment_info.php" method="post">
		<input type="hidden" name="h" value="<?php echo $_GET['h'] ?>">
		<table border="1">
		<tr><td><b>Location</b></td><td><b>Number of available slots<b></td><td></td></tr>
		<?php
		foreach ($homeworklocations as $key => $value)
		{
			echo "<tr><td>".$value["name"]."</td><td>".$value["freeslots"]."</td><td><input type='radio' name='loc' value=".$value["location_id"]." required></td></tr>";
		}
		?>
		</table><input type="submit" name="chosenLocation" value="Choose day"></form>
		<?php
	}
	else
	{
		echo "<br><br><b>Location: </b>";
		foreach ($homeworklocations as $key => $value) 
		{
			if ($homeworklocations[$key]["location_id"] == $_POST['loc'])
			{
				echo $value["name"];
			}
		}
		if (!isset($_POST["day"]))
		{ 
			echo "<br><b>Choose day:</b><br>";
			if ($homeworkinfo["start"] >= date ('Y-m-d', time()))
			{
				$iterday = $homeworkinfo["start"];
			}
			else 
			{
				$iterday = date ('Y-m-d', time());
			}
			;?>
			<form action ="appointment_info.php" method="post">
			<input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
			<input type="hidden" name="loc" value="<?php echo $_POST['loc'] ?>">
			<table border="1">
			<tr><td><b>Day</b></td><td><b>Number of available slots<b></td><td></td></tr>
			<?php
			foreach ($availableDays as $key => $value) {
				echo "<tr><td>".date ("D d M Y", strtotime($value["day"]))."</td><td>".$value["slots"]."</td><td><input type='radio' name='day' value=".date ("Y-m-d", strtotime($value["day"]))." required></td></tr>";
			}
			?>
 			</table><input type="submit" name="chosenDay" value="Choose timeslot"></form>
 			<?php
 			echo "<a href=appointment_info.php?h=".$_POST["h"].">Back to start</a><br>";
		}
		else
		{
			echo "<br><b>Day: </b>".date("D d M Y", strtotime($_POST["day"]));
			if (!isset($_POST["t"]))
			{
				echo "<br><b>Choose time:</b><br>";
				?>
				<form action ="appointment_info.php" method="post">
				<input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
				<input type="hidden" name="loc" value="<?php echo $_POST['loc'] ?>">
				<input type="hidden" name="day" value="<?php echo $_POST['day'] ?>">
				<table border="1">
				<tr><td><b>Time</b></td><td></td></tr>
				<?php
				foreach ($availableTimeslots as $key => $value) {
					echo "<tr><td>".$value."</td><td><input type='radio' name='t' required value=".$value." </td></tr>";
				}
				?>
				</table><input type="submit" name="chosenTime" value="Continue"></form>
				<form action ="appointment_info.php" method="post">
				<input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
				<input type="hidden" name="loc" value="<?php echo $_POST['loc'] ?>">
				<input type="submit" name="chosenLocation" value="Back to days">
				</form>
				<?php
			}
			else
			{
				echo "<br><b>Timeslot:</b>";
				echo $_POST["t"];
				if (!isset($_POST["confirmed"])):
				?>
				<form action ="appointment_info.php" method="post">
				<input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
				<input type="hidden" name="loc" value="<?php echo $_POST['loc'] ?>">
				<input type="hidden" name="day" value="<?php echo $_POST['day'] ?>">
				<input type="hidden" name="t" value="<?php echo $_POST['t'] ?>">
				<input type="submit" name="confirmed" value="Confirm your appointment">
				</form>
				<?php
				else:
					echo "<br>".$addmessage;
				endif;
			}
			echo "<br><a href=appointment_info.php?h=".$_POST["h"].">Back to start</a><br>";
		}

	}
	echo "<br><a href=lecture_info.php?id=".$homeworkinfo["lecture_id"].">Back to lecture</a><br>";

}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["deleteAppointment"]))
{
	echo $deletemessage."<br>";
	 echo "<a href=lecture_info.php?id=".$appointmentinfo["lecture_id"].">Back to lecture (You will be redirected automatically in 5 seconds)</a><br>";
    header( "refresh:5;url=lecture_info.php?id=".$appointmentinfo["lecture_id"]);
}
?>
<?php include('_footer.php'); ?>