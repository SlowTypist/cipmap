<?php
require_once(dirname(__DIR__).'/includes/user.php');
require_once(dirname(__DIR__).'/includes/lecture.php');
require_once(dirname(__DIR__).'/includes/homework.php');
require_once(dirname(__DIR__).'/includes/appointment.php');
require_once(dirname(__DIR__).'/includes/location.php');
require_once(dirname(__DIR__).'/includes/tutor.php');
session_start();
if (isset($_SESSION['LAST_ACTIVITY'])==0 || (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header('Location: ../login.php');
}
else
{
		$_SESSION['LAST_ACTIVITY'] = time();
}
if ($_SESSION['loggedin'] == true && ($_SESSION['role'] > 0))
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if (isset($_GET["h_id"]))
		{
			$homework = new homework();
			$homeworkinfo = $homework->getHomeworkInfoNoSolution($_GET["h_id"]);
			$homeworklocations = $homework->getHomeworkLocations($_GET["h_id"]);
			$tutor = new tutor();
			if (!isset($_GET["day"]))
			{
				if (date ("Y-m-d", time()) >=$homeworkinfo['start'] && date ("Y-m-d", time()) <= $homeworkinfo['end'])
				{
					$day = date ("Y-m-d", time());
				}
				else 
				{
					$day = $homeworkinfo['start'];
				}
			}
			else 
			{
				$day = $_GET["day"];
			}

			$allAppointmentsToday = $tutor->listAppointmentsByHomeworkAndDay($_GET["h_id"], $day);
		}
		else 
		{
			header('Location: index.php');
		}
	}
}
else
{
	header('Location: ../login.php');
}
?>