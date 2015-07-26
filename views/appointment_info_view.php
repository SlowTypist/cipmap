<?php include('_header.php'); ?>
<?php 
if (isset($_GET['h']) && $appointmentinfo != -1)
{?>
	<b>Lecture:</b><?php echo $appointmentinfo['lecture_name']?><b> Teacher: </b><?php echo $appointmentinfo['teacher']?><br>
	<b>Maximum group size:</b> <?php echo $appointmentinfo['max_group_size']?>
	<br><b>Homework name: </b><?php echo $appointmentinfo["homework_name"]?>
	<br><b> Your score: </b>
	<?php
	if (isset($appointmentinfo['points']))
	{
		echo $appointmentinfo['points'];
	} 
	else {
		echo "0";
	}?>
	out of <?php echo $appointmentinfo["max_points"]?>
	<br><b>Your appointment: </b> <?php echo date("D d M Y H:i", strtotime($appointmentinfo["time"]))." at ".$appointmentinfo["location_name"]?>
	<br><b>Your appointment's code: </b> <?php echo $appointmentinfo["code"];?> 
	<br><b>Your group:</b>
	<?php
		foreach ($teammates_info as $key => $value) 
		{
			echo "<br>".$value["name"]." ".$value["surname"];
		}?>
	<br><br><form action="appointment_info.php" method="post">
		<input type="hidden" name="homework_id" value="<?php echo $_GET['h'] ?>">
		<input type="submit" name="deleteAppointment" value="Cancel appointment" /></form><?php
	echo "<a href=lecture_info.php?id=".$appointmentinfo["lecture_id"].">Back to lecture</a><br>";	
}
else if ($appointmentinfo == -1 || isset($_POST['loc']))
{?>
	<b>Lecture: </b><?php echo $homeworkinfo['lecture_name']?>
	<b> Teacher: </b><?php echo $homeworkinfo['teacher']?><br>
	<b>Maximum group size: </b><?php echo $homeworkinfo['max_group_size']?>
	<br><b>Homework name: </b><?php echo $homeworkinfo["homework_name"]?>
	<b>Start date: </b><?php echo date("d M Y", strtotime($homeworkinfo["start"]))?>
	<b>End date: </b><?php echo date("d M Y", strtotime($homeworkinfo["end"]))?>
	<?php
	if (!isset($_POST['loc']))
	{?>
		<form action ="appointment_info.php" method="post">
		<fieldset style="width:25%">
		<legend><b>Choose location:</b></legend>
		<input type="hidden" name="h" value="<?php echo $_GET['h'] ?>">
		<table border="1">
		<tr><td><b>Location</b></td><td><b>Number of available slots<b></td><td></td></tr>
		<?php
		foreach ($homeworklocations as $key => $value)
		{
			echo "<tr><td>".$value["name"]."</td><td>".$value["freeslots"]."</td><td><input type='radio' name='loc' value=".$value["location_id"]." required></td></tr>";
		}
		?>
		</table><input type="submit" name="chosenLocation" value="Choose day"></fieldset></form>
		<br><br><b>Or put the appointment code in:</b><br>
		<form action ="appointment_info.php" method="post">
		<fieldset style="width:25%">
		<legend><b>Code</b></legend>
		<input type="hidden" name="h" value="<?php echo $_GET['h'] ?>">
		<input type="text" name="code" value="" size ="50" required />
		<input type="submit" name="codeGiven" value="Enter Code">
		</fieldset>
		</form>
		<?php
	}
	else
	{?>
		<br><br><b>Location: </b>
		<?php
		foreach ($homeworklocations as $key => $value) 
		{
			if ($homeworklocations[$key]["location_id"] == $_POST['loc'])
			{
				echo $value["name"];
			}
		}
		if (!isset($_POST["day"]))
		{ ?>
			<br><b>Choose day:</b><br>
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
 			<a href=appointment_info.php?h=<?php echo $_POST["h"]?>>Back to start</a><br>
 			<?php
		}
		else
		{?>
			<br><b>Day: </b><?php echo date("D d M Y", strtotime($_POST["day"]))?>
			<?php
			if (!isset($_POST["t"]))
			{?>
				<br><b>Choose time:</b><br>
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
			{?>
				<br><b>Timeslot:</b><?php echo $_POST["t"];
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
			?>
			<br><a href=appointment_info.php?h=<?php echo $_POST["h"]?>>Back to start</a><br>
			<?php
		}
	}?>
	<br><a href=lecture_info.php?id=<?php echo $homeworkinfo["lecture_id"]?>>Back to lecture</a><br>
	<?php
}
else if(isset($_POST["codeGiven"]))
{
	?><b>Lecture: </b><?php echo $homeworkinfo['lecture_name']?>
	<b> Teacher: </b><?php echo $homeworkinfo['teacher']?><br>
	<b>Maximum group size: </b><?php echo $homeworkinfo['max_group_size']?>
	<br><b>Homework name: </b><?php echo $homeworkinfo["homework_name"]?>
	<b>Start date: </b><?php echo date("d M Y", strtotime($homeworkinfo["start"]))?>
	<b>End date: </b><?php echo date("d M Y", strtotime($homeworkinfo["end"]))?>
	<?php
	if (!empty($app_info)):?>
		<br><br>	<b>Code: </b><?php echo $app_info[0]["code"];?>
		<br><b>Location: </b>
		<?php
		foreach ($homeworklocations as $key => $value) 
		{
			if ($homeworklocations[$key]["location_id"] == $app_info[0]['location_id'])
			{
				echo $value["name"];
			}
		}?>
		<br><b>Day: </b><?php echo date ("D d M Y", strtotime($app_info[0]["time"]));?>
		<br><b>Timeslot: </b><?php echo date ("H:i:s", strtotime($app_info[0]["time"]));?>
		<br><b>Groupmates: </b>
		<?php
		foreach ($app_info as $key => $value) 
		{
			echo "<br>".$value["name"]." ".$value["surname"];
		}?>
		<?php
		if (!empty($codeGivenError)):
			echo "<br><br><b>".$codeGivenError."</b>";
		else:?>
		<form action ="appointment_info.php" method="post">
		<input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
		<input type="hidden" name="code" value="<?php echo $_POST['code'] ?>">
		<input type="submit" name="codeConfirmed" value="Confirm your appointment">
		</form>
		<?php
		endif;
	else:?>
		<p>Input code is wrong.</p>
	<?php endif;?>
	<br><br><a href=appointment_info.php?h=<?php echo $_POST["h"];?>>Back to homework page</a>
	
<?php }
else if (isset($_POST["codeConfirmed"]))
{	?>
	<b>Lecture: </b><?php echo $homeworkinfo['lecture_name']?>
	<b> Teacher: </b><?php echo $homeworkinfo['teacher']?><br>
	<b>Maximum group size: </b><?php echo $homeworkinfo['max_group_size']?>
	<br><b>Homework name: </b><?php echo $homeworkinfo["homework_name"]?>
	<b>Start date: </b><?php echo date("d M Y", strtotime($homeworkinfo["start"]))?>
	<b>End date: </b><?php echo date("d M Y", strtotime($homeworkinfo["end"]))?>
	<?php
	if (!empty($codeConfirmed)):
			echo "<br><br><b>".$codeConfirmed."</b>";
	endif;?>
	<br><br><a href=appointment_info.php?h=<?php echo $_POST["h"];?>>Back to homework page</a>
	<?php

}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["deleteAppointment"]))
{
	echo $deletemessage."<br>";
	 echo "<a href=lecture_info.php?id=".$appointmentinfo["lecture_id"].">Back to lecture (You will be redirected automatically in 5 seconds)</a><br>";
    header( "refresh:5;url=lecture_info.php?id=".$appointmentinfo["lecture_id"]);
}
?>
<?php include('_footer.php'); ?>