<?php include('_header.php'); ?>
<?php
if (isset($_GET['id'])):?>
	<b>Lecture:</b><?php echo $lectureInfo->name;?>
	<b> Teacher: </b><?php echo $lectureInfo->teacher?><br>
	<b>Maximum group size:</b> <?php echo $lectureInfo->max_group_size;?>
	<br><b>Homework name: </b><?php echo $homeworkInfo->name?>
	<br><b> Your score: </b>
	<?php
	if (!empty($appointmentInfo->points)){
		echo $appointmentInfo->points;
	} 
	else {
		echo "0";
	}?>
	out of <?php echo $homeworkInfo->max_points;?>
	<br><b>Your appointment: </b> <?php echo date("D d M Y H:i", strtotime($appointmentInfo->time))." at ".$locationInfo->name; ?>
	<br><b>Your appointment's code: </b> <?php echo $appointmentInfo->code;?>
	<br><b>Your group:</b>
	<?php
		foreach ($teammates as $key => $value)
		{
			echo "<br>".$value->name." ".$value->surname;
            if ($value->email == $_SESSION['email']){
                echo "**";
            }
		}?>
	<br><br><form action="appointment_info.php" method="post">
		<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
		<input type="submit" name="action" value="Cancel appointment" /></form><?php
	echo "<a href=lecture_info.php?id=".$lectureInfo->id.">Back to lecture</a><br>";
elseif(isset($_GET['h'])):?>
    <b>Lecture:</b><?php echo $lectureInfo->name;?>
    <b> Teacher: </b><?php echo $lectureInfo->teacher?><br>
    <b>Maximum group size:</b> <?php echo $lectureInfo->max_group_size;?>
    <br><b>Homework name: </b><?php echo $homeworkInfo->name?>
    <b>Start date: </b><?php echo date("d M Y", strtotime($homeworkInfo->start))?>
    <b>End date: </b><?php echo date("d M Y", strtotime($homeworkInfo->end))?>
    <form action ="appointment_info.php" method="post">
        <fieldset style="width:25%">
            <legend><b>Choose location:</b></legend>
            <input type="hidden" name="h" value="<?php echo $_GET['h'] ?>">
            <table border="1">
                <tr>
                    <td><b>Location</b></td>
                    <td><b>Amount of available slots<b></td>
                    <td></td>
                </tr>
                <?php
                foreach ($allAvailableLocations as $key => $value){
                    echo "<tr>
                        <td>".$value->name."</td>
                        <td>".$freeSlots[$key]."</td>
                        <td><input type='radio' name='location_id' value=".$value->id." required></td>
                    </tr>";
                }
                ?>
            </table>
            <input type="submit" name="action" value="Choose day">
        </fieldset>
    </form>
    <form action ="appointment_info.php" method="post">
        <fieldset style="width:25%">
            <legend><b>Or put the appointment code in:</b></legend>
            <input type="hidden" name="h" value="<?php echo $_GET['h'] ?>">
            <input type="text" name="code" value="" size ="50" required />
            <input type="submit" name="action" value="Enter Code">
        </fieldset>
    </form>
    <a href=lecture_info.php?id=<?php echo $lectureInfo->id;?>>Back to lecture</a><br>
    <?php
elseif($_POST['action'] == 'Choose day'):?>
    <b>Lecture:</b><?php echo $lectureInfo->name;?>
    <b> Teacher: </b><?php echo $lectureInfo->teacher?><br>
    <b>Maximum group size:</b> <?php echo $lectureInfo->max_group_size;?>
    <br><b>Homework name: </b><?php echo $homeworkInfo->name?>
    <b>Start date: </b><?php echo date("d M Y", strtotime($homeworkInfo->start))?>
    <b>End date: </b><?php echo date("d M Y", strtotime($homeworkInfo->end))?>
    <br><b>Location: </b><?php echo $locationInfo->name;?>

    <form action ="appointment_info.php" method="post">
        <fieldset style="width:25%">
            <legend><b>Choose day:</b></legend>
            <input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
            <input type="hidden" name="location_id" value="<?php echo $_POST['location_id'] ?>">
            <table border="1">
                <tr>
                    <td><b>Day</b></td>
                    <td><b>Amount of available slots<b></td>
                    <td></td>
                </tr>
                <?php
                foreach ($availableDays as $key => $value){
                    echo "
                <tr>
                    <td>".date ("D d M Y", strtotime($availableDays[$key]["day"]))."</td>
                    <td>".$availableDays[$key]["slots"]."</td>
                    <td><input type='radio' name='day' value=".date ("Y-m-d", strtotime($availableDays[$key]["day"]))." required></td>
                </tr>";
                }
                ?>

            </table>
            <input type="submit" name="action" value="Choose timeslot">
        </fieldset>
    </form>

    <a href=lecture_info.php?id=<?php echo $lectureInfo->id;?>>Back to lecture</a><br>
    <?php
elseif ($_POST['action'] == 'Choose timeslot'):?>
    <b>Lecture:</b><?php echo $lectureInfo->name;?>
    <b> Teacher: </b><?php echo $lectureInfo->teacher?><br>
    <b>Maximum group size:</b> <?php echo $lectureInfo->max_group_size;?>
    <br><b>Homework name: </b><?php echo $homeworkInfo->name?>
    <b>Start date: </b><?php echo date("d M Y", strtotime($homeworkInfo->start))?>
    <b>End date: </b><?php echo date("d M Y", strtotime($homeworkInfo->end))?>

    <br><b>Location: </b><?php echo $locationInfo->name;?>
    <br><b>Day: </b><?php echo date("D d M Y", strtotime($_POST["day"]))?>

    <form action ="appointment_info.php" method="post">
        <fieldset style="width:25%">
            <legend><b>Choose timeslot:</b></legend>
            <input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
            <input type="hidden" name="location_id" value="<?php echo $_POST['location_id'] ?>">
            <input type="hidden" name="day" value="<?php echo $_POST['day'] ?>">
            <table border="1">
                <tr>
                    <td><b>Timeslot</b></td>
                    <td></td>
                </tr>
                <?php
                foreach ($availableTimeslots as $key => $value){
                    echo "
                <tr>
                    <td>".date ("H:i:s", strtotime($value))."</td>
                    <td><input type='radio' name='time' value=".date ("H:i:s", strtotime($value))." required></td>
                </tr>";
                }
                ?>
            </table>
            <input type="submit" name="action" value="Continue">
        </fieldset>
    </form>
    <?php
elseif($_POST['action'] == 'Continue'):?>
    <b>Lecture:</b><?php echo $lectureInfo->name;?>
    <b> Teacher: </b><?php echo $lectureInfo->teacher?><br>
    <b>Maximum group size:</b> <?php echo $lectureInfo->max_group_size;?>
    <br><b>Homework name: </b><?php echo $homeworkInfo->name?>
    <b>Start date: </b><?php echo date("d M Y", strtotime($homeworkInfo->start))?>
    <b>End date: </b><?php echo date("d M Y", strtotime($homeworkInfo->end))?>

    <br><br><b>Location: </b><?php echo $locationInfo->name;?>
    <br><b>Day: </b><?php echo date("D d M Y", strtotime($_POST["day"]))?>
    <br><b>Timeslot:</b><?php echo $_POST["time"];?>

    <form action ="appointment_info.php" method="post">
        <input type="hidden" name="h" value="<?php echo $_POST['h'] ?>">
        <input type="hidden" name="location_id" value="<?php echo $_POST['location_id'] ?>">
        <input type="hidden" name="day" value="<?php echo $_POST['day'] ?>">
        <input type="hidden" name="time" value="<?php echo $_POST['time'] ?>">
        <input type="submit" name="action" value="Confirm your appointment">
    </form>

    <a href=lecture_info.php?id=<?php echo $lectureInfo->id;?>>Back to lecture</a><br>
    <?php
elseif($_POST['action'] == 'Confirm your appointment'):
    ?>
    <b>Lecture:</b><?php echo $lectureInfo->name;?>
    <b> Teacher: </b><?php echo $lectureInfo->teacher?><br>
    <b>Maximum group size:</b> <?php echo $lectureInfo->max_group_size;?>
    <br><b>Homework name: </b><?php echo $homeworkInfo->name?>
    <b>Start date: </b><?php echo date("d M Y", strtotime($homeworkInfo->start))?>
    <b>End date: </b><?php echo date("d M Y", strtotime($homeworkInfo->end))?>

    <br><br><b>Location: </b><?php echo $locationInfo->name;?>
    <br><b>Day: </b><?php echo date("D d M Y", strtotime($_POST["day"]))?>
    <br><b>Timeslot:</b><?php echo $_POST["time"];?>

<?php endif;
?>