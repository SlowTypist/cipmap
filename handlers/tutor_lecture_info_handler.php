<?php
require_once(dirname(__DIR__).'/includes/user.php');
require_once(dirname(__DIR__).'/includes/lecture.php');
require_once(dirname(__DIR__).'/includes/homework.php');
require_once(dirname(__DIR__).'/includes/appointment.php');
require_once(dirname(__DIR__).'/includes/tutor.php');
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
if ($_SESSION['loggedin'] == true && ($_SESSION['role'] > 0))
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if (isset($_GET["getid"]))
		{
			$lecture = new lecture();
			$lectureinfo = $lecture->getLectureInfo($_GET["getid"]);
			if (empty($lectureinfo))
				{
					header('Location: index.php');
				}
			$homework = new homework();
			$tutor = new tutor();
			$allhomeworks = $tutor->listAllHomeworks($_GET["getid"]);
			$allPoints = $homework->allPoints($_GET["getid"]);
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