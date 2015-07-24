<?php
require_once('includes/user.php');
$verifyresult = 0;
$verifyerror = "";
$changeresult = "";
session_start();
if ($_SESSION['loggedin'] == true)
{
	header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if (isset($_GET["id"]) && isset($_GET["verification_code"]))
	{
		$user = new user();
		$result = $user->verifyPasswordResetLink($_GET['id'], $_GET['verification_code']);
		if($result > 0)
		{
			$verifyresult = 1;
		}
		else if($result == -1) 
		{
			$verifyerror = "Wrong link";
		}
		else if($result == 0) //db problem
		{
			$verifyerror =  "Couldn't connect to database";
		}
	}
	else
	{
		header('Location: index.php');
	}
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST["Changepw"]))
	{
		$user = new user();
		$result = $user->resetPassword($_POST['id'], $_POST['new_pw'], $_POST['new_pw_repeat']);
		if($result == 1)
		{
			$changeresult = "Password successfully changed. Please proceed to the main page";
		}
		if($result == 0)
		{
			$changeresult = "Database connection problem";
		}
		if($result == -1)
		{
			$changeresult = "Passwords don't match. Please try again";
		}
		if($result == -2)
		{
			$changeresult = "You didn't enter the password";
		}
		if($result == -3)
		{
			$changeresult = "Password is too short. Your password must be at least 6 symbols long. Please try again";
		}
	}
}
if($verifyerror !== "")
	$verifyerror = "<p class='error'>{$verifyerror}</p>";
if($changeresult !== "")
	$changeresult = "<p class='error'>{$changeresult}</p>";

?>