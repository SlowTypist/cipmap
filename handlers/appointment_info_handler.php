<?php
require_once('includes/user.php');
require_once('includes/lecture.php');
require_once('includes/homework.php');
require_once('includes/appointment.php');
require_once('includes/location.php');
$deletemessage = "";
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
			$appointmentinfo = $appointment->userHomeworkAppointment($_SESSION['user'], $_GET["h"]);
			if ($appointmentinfo == -1)
			{
				$homeworkinfo = $homework->getHomeworkInfoNoSolution($_GET["h"]);
				$homeworklocations = $homework->getHomeworkLocations($_GET["h"]);
				var_dump($homeworkinfo);
				var_dump($homeworklocations);

			}
		}
		else
		{
			header('Location: index.php');
		}
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
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