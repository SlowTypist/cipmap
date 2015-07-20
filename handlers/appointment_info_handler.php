<?php
require_once('includes/user.php');
require_once('includes/lecture.php');
require_once('includes/homework.php');
require_once('includes/appointment.php');
require_once('includes/location.php');
$deletemessage = "";
$addmessage = "";
session_start();
if (isset($_SESSION['LAST_ACTIVITY'])==0 || (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header('Location: login.php');
}
else
{
		$_SESSION['LAST_ACTIVITY'] = time();
}

if ($_SESSION['loggedin'] == true)
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if (isset($_GET["h"]))
		{
			$appointment = new appointment();
			$homework = new homework();
			$location = new location();
			$appointmentinfo = $appointment->userHomeworkAppointment($_SESSION['user'], $_GET["h"]);
			if ($appointmentinfo == -1)
			{
				$homeworkinfo = $homework->getHomeworkInfoNoSolution($_GET["h"]);
				$homeworklocations = $homework->getHomeworkLocations($_GET["h"]);

			}
		}
		else
		{	
			header('Location: index.php');
		}
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (!isset($_POST["deleteAppointment"]))						///work for different sequential pages, when you choose timeslot
		{
			var_dump($_POST);
			$appointment = new appointment();
			$homework = new homework();
			$location = new location();
			$homeworkinfo = $homework->getHomeworkInfoNoSolution($_POST["h"]);
			$homeworklocations = $homework->getHomeworkLocations($_POST["h"]);
			if (isset($_POST['day']) && $homeworkinfo )
			{
				$workingHoursOnDay = $location->getWorkingHoursOnDay($_POST["loc"], date('N', strtotime($_POST["day"])));
				if 	(isset($_POST["confirmed"]))	//multiple checks go further
				{
					foreach ($homeworklocations as $key => $value) {
						if ($homeworklocations[$key]["location_id"] == $_POST["loc"])
						{
							if ($_POST["day"] >= $homeworkinfo["start"] && $_POST["day"] <= $homeworkinfo["end"])
							{
								foreach ($workingHoursOnDay as $key => $value) {
									if ($_POST["t"] > $workingHoursOnDay[$key]["open_time"] && $_POST["t"] < $workingHoursOnDay[$key]["close_time"])
									{
										if ((date('i', strtotime($_POST["t"])) == "20" || date('i', strtotime($_POST["t"])) == "40") && date('s', strtotime($_POST["t"])) == "00")
										{
											$newAppointment_id = $appointment->addAppointment(date ("Y-m-d H:i:s", strtotime($_POST['day']." ".$_POST['t'])),$_SESSION['user'], $_POST["h"], $_POST["loc"]);
											if ($newAppointment_id>0)
											{
												$addmessage="Your appointment is successfully added";
											}
											else 
											{
												$addmessage="Error. Please try again";
											}
										}
									}
								}
							}
						}
					}
				}
			}

		}
		if (isset($_POST["deleteAppointment"]))
		{
			$appointment = new appointment();
			$appointmentinfo = $appointment->userHomeworkAppointment($_SESSION['user'], $_POST["homework_id"]);
			if ($appointmentinfo != -1)
			{
				$appointmentday = date("Y-m-d", strtotime($appointmentinfo["time"]));
				$currentday = date("Y-m-d" ,time());
				if ($appointmentday > $currentday)
				{
					$cancelAppointment = $appointment->deleteAppointment($appointmentinfo["appointment_id"]);
					if ($cancelAppointment)
					{
						$deletemessage = "You have successfully canceled your appointment";
					}
					else
					{
						$deletemessage = "Error";
					}

				}
				else
				{
				 	$deletemessage = "You cannot cancel this appointment";
				}
			} 
		}
	}
}

?>