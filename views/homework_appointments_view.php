<?php include('_header.php'); ?>
	
<b>Lecture:</b><?php echo $homeworkinfo['lecture_name']?><b> Teacher: </b><?php echo $homeworkinfo['teacher']?><br>
<b>Maximum group size:</b> <?php echo $homeworkinfo['max_group_size']?>
<br><b>Homework name: </b><?php echo $homeworkinfo["homework_name"]?>
<br><b>Submitting time : </b><?php echo date ("d M Y", strtotime($homeworkinfo["start"]))?> - <?php echo date ("d M Y", strtotime($homeworkinfo["end"]))?> 
<br><b>Max points: </b><?php echo $homeworkinfo["max_points"]?>
<br><b>Day: </b><?php echo date ("D d M Y", strtotime($day))?>
<center>
<br><a href=homework_appointments.php?h_id=<?php echo $_GET["h_id"]?>&day=<?php echo date("Y-m-d", strtotime("-1 day", strtotime($day)))?>><<</a>
<a href=homework_appointments.php?h_id=<?php echo $_GET["h_id"]?>&day=<?php echo date("Y-m-d", strtotime("+1 day", strtotime($day)))?>>>></a>
</center>
<hr>
<?php 
foreach ($homeworklocations as $key => $value) 
{
	echo "<b>".$value["name"].":</b><br>";
	$lastTimestamp=0;
	foreach ($allAppointmentsToday as $key2 => $value2) 
	{
		if($value["location_id"] == $value2["location_id"]):
			if ($value2["time"] != $lastTimestamp):
				$lastTimestamp = $value2["time"];
				echo "</table><br><b>".date("H:i", strtotime($value2["time"])).':</b>';?>
				<table border=1>
				<?php
			endif;
		?>
		<br><tr><td><?php echo $value2["name"]; ?> <?php echo $value2["surname"]; ?></td><td> <?php echo $value2["matrikelnr"]; ?></td><td>
		<?php
		if (isset($value2["points"])):		
			echo $value2["points"];
		?>
		</td><td>
		<form action="give_mark.php" method="post" style="display: inline">
		<input type="hidden" name="returnpage" value="<?php echo $_SERVER["REQUEST_URI"] ?>">
		<input type="hidden" name="id" value="<?php echo $value2['id'] ?>">
		<input type="submit" name="Delete" value="Set mark zero" style="display: inline; height:25px;font-family: sans-serif;font-size: 10px;"/></form>
		</td>
		<?php
		else:
			?>
		<form action="give_mark.php" method="post" style="display: inline">
		<input type="hidden" name="returnpage" value="<?php echo $_SERVER["REQUEST_URI"] ?>">
		<input type="hidden" name="id" value="<?php echo $value2['id'] ?>">
		<input type="number" name="mark" min = "0" max = "<?php echo $homeworkinfo["max_points"] ?>" value="">
		<input type="submit" name="Submit" value="Sumbit" style="display: inline;"/></form>
		<?php
		endif; ?>
				</td>
		</tr>
		<?php
		endif;

	}
	echo "</table><hr>";
}
?>
<br><br><a href=lecture_info.php?getid=<?php echo $homeworkinfo["lecture_id"]?>>Back to lecture</a>
<?php include('_footer.php'); ?>