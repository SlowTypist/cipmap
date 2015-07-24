<?php
require_once('includes/user.php');
$registerresult = "";
session_start();
if ($_SESSION['loggedin'] == true)
{
	if ($_SESSION['role'] == 0)
	{
		header('Location: student1.php');
	}
	if ($_SESSION['role'] == 1)
	{
		header('Location: tutor1.php');
	}
	if ($_SESSION['role'] == 2)
	{
		header('Location: teacher1.php');
	}
	if ($_SESSION['role'] == 3)
	{
		header('Location: admin.php');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST["Register"]))
	{
		$user = new user();

		$result = $user->register($_POST['email'], $_POST['surname'], $_POST['name'], $_POST['matrnr'], $_POST['pw'], $_POST['pw_repeat'] );
		if ($result > 0)
		{
			$registerresult = "Account successfully register. Please activate your account with a link sent to your e-mail.";
		}
		if ($result == -1)
		{
			$registerresult = "This e-mail is already registered. ";
		}
		if ($result == -7)
		{
			$registerresult = "Account registered but verification e-mail wasn't sent. Please contact tutor to activate your account.";
		}		
	}
}
if($registerresult !== "")
	$registerresult = "<p class='error'>{$registerresult}</p>";

?>