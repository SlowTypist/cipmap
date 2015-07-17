<?php
require_once('includes/user.php');
require_once('includes/lecture.php');
require_once('includes/homework.php');
require_once('includes/appointment.php');
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
		if (isset($_GET["id"]))
		{
			$lecture = new lecture();
			$lectureinfo = $lecture->getLectureInfo($_GET["id"]);
			if (empty($lectureinfo))
				{
					header('Location: index.php');
				}
			$homework = new homework();
			$allhomeworks = $homework->listAllHomeworks($_GET["id"]);
			$allPoints = $homework->allPoints($_GET["id"]);

			$appointment = new appointment();
			$allAppointments = $appointment->allUserLectureAppointments($_SESSION["user"], $_GET["id"]);

		}
		else
		{
			header('Location: index.php');
		}
	}
}

?>