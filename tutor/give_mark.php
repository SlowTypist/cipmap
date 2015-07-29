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
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST["Submit"]))
		{
			$tutor = new tutor();
			if ($tutor->setPoints($_POST["id"], $_POST["mark"]))
			{
				header('Location:'.$_POST["returnpage"]);
			}
			else
			{
				echo "ERROR";
			}
		}
		if (isset($_POST["Delete"]))
		{
			$tutor = new tutor();
			if ($tutor->deletePoints($_POST["id"]))
			{
				header('Location:'.$_POST["returnpage"]);
			}
			else
			{
				echo "ERROR";
			}
		}

	}
	else
	{
		header('Location: index.php');
	}
}
?>