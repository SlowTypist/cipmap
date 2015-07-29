<?php
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
	if (isset($_POST["Search"]))
	{
		$tutor = new tutor();
		$searchResult = $tutor->searchUserByEmail($_POST["email"]);
	}
	if (isset($_POST["Activate"]))
	{
		$tutor = new tutor();
		$activateResult = $tutor->manualActivate($_POST["id"]);
	}
}
else
{
	header('Location: ../login.php');
}
?>