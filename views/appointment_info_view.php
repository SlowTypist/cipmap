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
	echo "<br><b>Your appointment: </b>".date("D d M Y H:i", strtotime($appointmentinfo["time"]))." at ".$appointmentinfo["location_name"];
	?><form action="appointment_info.php" method="post">
		<input type="hidden" name="homework_id" value="<?php echo $_GET['h'] ?>">
		<input type="submit" name="deleteAppointment" value="Cancel appointment" /></form><?php
	
}
else if ($appointmentinfo == -1)
{
	echo "<b>Lecture: </b>".$homeworkinfo['lecture_name']."<b> Teacher: </b>".$homeworkinfo['teacher']."<br><b>Maximum group size: </b>".$homeworkinfo['max_group_size'];
	echo "<br><b>Homework name: </b>".$homeworkinfo["homework_name"]." <b>Start date: </b>".date("d M Y", strtotime($homeworkinfo["start"]))." <b>End date:</b>".date("d M Y", strtotime($homeworkinfo["end"]));
	if (!isset($_GET['loc']))
	{
		echo "<br><br><b>Choose location:</b><br>";
		foreach ($homeworklocations as $key => $value) 
		{
			echo "<a href=appointment_info.php?h=".$_GET["h"]."&loc=".$homeworklocations[$key]["location_id"].">".$homeworklocations[$key]["name"]."</a><br>";
		}
	}
	else
	{
		if (!isset($_GET["day"]))
		{ 
			echo "<br><br><b>Choose day:</b><br>";
			$iterday = $homeworkinfo["start"];
			while (strtotime($iterday) <= strtotime($homeworkinfo["end"])) 
			{
				if(date ("D", strtotime($iterday)) != "Sat" && date ("D", strtotime($iterday)) != "Sun" )
				{
 					echo date ("D d M Y", strtotime($iterday))."<br>";
 				}
 				$iterday = date ("Y-m-d", strtotime("+1 day", strtotime($iterday)));
 			}
 			echo "<br><a href=appointment_info.php?h=".$_GET["h"].">Back to locations</a><br>";
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